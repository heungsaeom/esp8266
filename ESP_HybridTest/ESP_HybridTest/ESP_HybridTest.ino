extern "C" {
#include <user_interface.h> // ESP8266 SDK API
}

#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <WiFiUdp.h>
#include <ESP8266WebServer.h>
#include <ESP8266mDNS.h>
#include "StringLog.h"

#define IP(a,b,c,d) (uint32_t)(a | (b << 8) | (c << 16) | (d << 24))

const int ledPin = LED_BUILTIN;

const uint32_t wifiTimeout = 30000;

const char* const hostPrefix = "ESP8266_";
const char* const staSSID = "******";
const char* const staPassword = "******";
const char* const apPassword = "Pa$$w0rd";

const uint32_t apIP = IP(192, 168, 200, 1);
const uint32_t apGateway = apIP;
const uint32_t apSubnet = IP(255, 255, 255, 0);

const uint16_t localPort = 54321; // Local port to listen for UDP packets

enum moduleMode_t : uint8_t { UNDEFINED, SLAVE, MASTER } moduleMode = UNDEFINED;

IPAddress broadcastAddress;
WiFiUDP udp;
ESP8266WebServer* server;
StringLog* logger;

bool startUdpServer() {
  if (! udp.begin(localPort)) {
    Serial.println("Error starting UDP server!");
    return false;
  }
  Serial.print(F("UDP server started on port "));
  Serial.println(udp.localPort());

  return true;
}

bool sendPacket(const IPAddress& address, const uint8_t* buf, uint8_t bufSize) {
  udp.beginPacket(address, localPort);
  udp.write(buf, bufSize);
  return (udp.endPacket() == 1);
}

bool receivePacket() {
  uint8_t buf[2]; // Second byte must be equal to ~ first byte

  Serial.print(F("UPD packet received ("));
  Serial.print(udp.available());
  Serial.println(F(" bytes)"));

  udp.read((uint8_t*)buf, sizeof(buf));
  udp.flush();
  if (buf[1] != (uint8_t)~buf[0]) {
    if (moduleMode == MASTER)
      logger->println(F("Wrong UDP packet!"));
    else
      Serial.println(F("Wrong UDP packet!"));
    return false;
  }

  if (moduleMode == MASTER) {
    if (udp.destinationIP() != broadcastAddress) {
      logger->print(F("Client with IP "));
      logger->print(udp.remoteIP());
      logger->print(F(" turned led "));
      logger->println((buf[0] & 0x01) ? F("off") : F("on"));
    } else {
      logger->println(F("Skip broadcast packet"));
    }
  } else {
    digitalWrite(ledPin, buf[0] & 0x01);
    buf[0] = digitalRead(ledPin);
    buf[1] = ~buf[0];
    Serial.print(F("Turn led "));
    Serial.println((buf[0] & 0x01) ? F("off") : F("on"));
    if (! sendPacket(udp.remoteIP(), (uint8_t*)buf, sizeof(buf)))
      Serial.println(F("Error sending answer UDP packet!"));
  }

  return true;
}

bool connectToMaster() {
  moduleMode = UNDEFINED;

  WiFi.disconnect();
  WiFi.mode(WIFI_STA);
  int8_t n = WiFi.scanNetworks();
  if (! n) {
    Serial.println(F("No Wi-Fi networks found!"));
  } else {
    while (--n >= 0) {
      if (WiFi.SSID(n).startsWith(hostPrefix)) {
        Serial.print(F("Connecting to "));
        Serial.print(WiFi.SSID(n));
        WiFi.begin(WiFi.SSID(n).c_str(), apPassword);
        uint32_t maxTime = millis() + wifiTimeout;
        while ((WiFi.status() != WL_CONNECTED) && (millis() < maxTime)) {
          digitalWrite(ledPin, ! digitalRead(ledPin));
          delay(500);
          Serial.print('.');
        }
        digitalWrite(ledPin, HIGH);
        Serial.println();
        if (WiFi.status() != WL_CONNECTED) {
          Serial.println(F("fail, trying next!"));
          continue;
        }
        Serial.print(F("Connected with IP address: "));
        Serial.println(WiFi.localIP());
        break;
      }
    }
    if (WiFi.isConnected()) {
      Serial.println(F("SLAVE started"));
      moduleMode = SLAVE;
      return true;
    }
  }

  return false;
}

bool becomeMaster() {
  moduleMode = UNDEFINED;

  WiFi.mode(WIFI_AP_STA);
  Serial.print(F("Connecting to "));
  Serial.print(staSSID);
  WiFi.begin(staSSID, staPassword);
  uint32_t maxTime = millis() + wifiTimeout;
  while ((WiFi.status() != WL_CONNECTED) && (millis() < maxTime)) {
    digitalWrite(ledPin, ! digitalRead(ledPin));
    delay(500);
    Serial.print('.');
  }
  digitalWrite(ledPin, HIGH);
  Serial.println();
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println(F("fail!"));
    return false;
  }
  Serial.print(F("Connected with IP address: "));
  Serial.println(WiFi.localIP());

  Serial.print(F("Configuring access point "));
  Serial.println(WiFi.hostname());
  WiFi.softAPConfig(IPAddress(apIP), IPAddress(apGateway), IPAddress(apSubnet));
  WiFi.softAP(WiFi.hostname().c_str(), apPassword);
  Serial.print(F("AP IP address: "));
  Serial.println(WiFi.softAPIP());
  broadcastAddress = (uint32_t)WiFi.softAPIP() | ~apSubnet;
  Serial.print(F("AP broadcast address: "));
  Serial.println(broadcastAddress);
  wifi_set_broadcast_if(SOFTAP_MODE); // Broadcast to AP only

  if (MDNS.begin(WiFi.hostname().c_str())) {
    Serial.println(F("mDNS responder started"));
  }

  server = new ESP8266WebServer(80);
  server->on("/", handleRoot);
  server->on("/udp", handleUdp);
  server->onNotFound(handleNotFound);
  server->begin();
  Serial.println(F("HTTP server started"));
  logger = new StringLog(&Serial);
  logger->println(F("MASTER started"));
  moduleMode = MASTER;

  return true;
}

void handleRoot() {
  static uint32_t minMemSize = 0xFFFFFFFF;
  uint32_t memSize;

  String page = F("<!DOCTYPE html>\n\
<html>\n\
<head>\n\
<META http-equiv=\"refresh\" content=\"2;URL=\">\n\
<title>ESP8266 Hybrid Master</title>\n\
<script>\n\
function openUrl(url) {\n\
var request = new XMLHttpRequest();\n\
request.open('GET', url, false);\n\
request.send(null);\n\
}\n\
function sendCommand(ip, led) {\n\
openUrl('/udp?ip=' + ip + '&led=' + led);\n\
location.reload();\n\
}\n\
</script>\n\
</head>\n\
<body>\n\
<h1>ESP8266 Hybrid Master</h1>\n\
Free heap size (current/minimum): ");

  memSize = ESP.getFreeHeap();
  if (memSize < minMemSize)
    minMemSize = memSize;
  page += String(memSize);
  page += '/';
  page += String(minMemSize);
  page += F(" bytes\n<p>\n\
<table><caption><h3>Slave List</h3></caption>\n\
<tr><th>#</th><th>BSSID</th><th>IP address</th><th></th><th></th></tr>\n");

  struct station_info* station = wifi_softap_get_station_info();
  uint8_t i, n = 0;
  while (station) {
    page += F("<tr><td>");
    page += String(++n);
    page += F("</td><td>");
    for (i = 0; i < 6; ++i) {
      if (i)
        page += ':';
      page += String(station->bssid[i], HEX);
    }
    page += F("</td><td>");
    page += String(station->ip.addr & 0xFF);
    page += '.';
    page += String((station->ip.addr >> 8) & 0xFF);
    page += '.';
    page += String((station->ip.addr >> 16) & 0xFF);
    page += '.';
    page += String((station->ip.addr >> 24) & 0xFF);
    page += F("</td><td><input type=\"button\" value=\"Turn LED on\" onclick=\"sendCommand(");
    page += String((long)station->ip.addr);
    page += F(", 0)\"></td><td><input type=\"button\" value=\"Turn LED off\" onclick=\"sendCommand(");
    page += String((long)station->ip.addr);
    page += F(", 1)\"></td></tr>\n");
    station = STAILQ_NEXT(station, next);
  }
  wifi_softap_free_station_info();

  page += ("</table>\n\
<p>\n\
<input type=\"button\" value=\"Turn all LED on\" onclick=\"sendCommand(");
  page += String((long)((uint32_t)broadcastAddress));
  page += F(", 0)\"");
  if (! n)
    page += F(" disabled");
  page += F(">\n\
<input type=\"button\" value=\"Turn all LED off\" onclick=\"sendCommand(");
  page += String((long)((uint32_t)broadcastAddress));
  page += F(", 1)\"");
  if (! n)
    page += F(" disabled");
  page += F(">\n\
<p>\n\
Log:<br/>\n\
<textarea cols=\"80\" rows=\"25\" readonly>\n");
  page += logger->encodeStr(logger->text());
  page += F("</textarea>\n\
</body>\n\
</html>");

  server->send(200, F("text/html"), page);
}

void handleUdp() {
  if (server->hasArg("ip") && server->hasArg("led")) {
    IPAddress ip;
    uint8_t buf[2];

    ip = (uint32_t)server->arg("ip").toInt();
    buf[0] = server->arg("led").toInt() & 0x01;
    buf[1] = ~buf[0];
    if (sendPacket(ip, (uint8_t*)buf, sizeof(buf))) {
      logger->print(F("Sending UDP command "));
      logger->print(buf[0] & 0x01);
      logger->print(F(" to IP "));
      logger->println(ip);
    } else
      logger->println(F("Error sending command UDP packet!"));
    server->send(200, F("text/plain"), "");
  } else
    server->send(500, F("text/plain"), F("Bad arguments!"));
}

void handleNotFound() {
  String message = F("File Not Found\n\n\
URI: ");
  message += server->uri();
  message += F("\nMethod: ");
  message += (server->method() == HTTP_GET) ? F("GET") : F("POST");
  message += F("\nArguments: ");
  message += server->args();
  message += '\n';
  for (uint8_t i=0; i < server->args(); i++) {
    message += " " + server->argName(i) + ": " + server->arg(i) + '\n';
  }
  server->send(404, F("text/plain"), message);
}

void reboot() {
  Serial.println(F("Rebooting..."));
  Serial.flush();
  ESP.restart();
}

void setup(void) {
  Serial.begin(115200);
  Serial.println();

  pinMode(ledPin, OUTPUT);
  digitalWrite(ledPin, HIGH);

  String hostName = String(ESP.getChipId(), HEX);
  hostName.toUpperCase();
  hostName = hostPrefix + hostName;
  if (! WiFi.hostname(hostName)) {
    Serial.print(F("Error changing module host name to "));
    Serial.println(hostName);
  }

  while (moduleMode == UNDEFINED) {
    if (connectToMaster() || becomeMaster())
      break;
    delay(5000);
  }

  if (! startUdpServer())
    reboot();
}

void loop(void) {
  if (! WiFi.isConnected())
    reboot();

  if (udp.parsePacket())
    receivePacket();

  if (moduleMode == MASTER)
    server->handleClient();
}
