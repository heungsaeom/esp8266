#include <ESP8266WiFi.h>
#include <SimpleDHT.h>
#include <Wire.h>
#include <LiquidCrystal_I2C.h>
#include <FirebaseArduino.h>
#define FIREBASE_HOST "https://dieu-khien-led-8d13c.firebaseio.com/"
#define FIREBASE_AUTH ""
const char* ssid = "WIFIFREE";
const char* password = "09562318";

int pinDHT11 = D6;
SimpleDHT11 dht11;
char giatrinhietdo[5];
char giatridoam[5];
byte temperature = 0;
byte humidity = 0;
LiquidCrystal_I2C lcd(0x3F, 16, 2);
void setup() {
  // put your setup code here, to run once:
  Serial.begin(9600);
  lcd.begin(16, 2);
  lcd.init();
  lcd.backlight();
  lcd.setCursor(1, 0);
  lcd.print("NHIET DO:");
  lcd.setCursor(1, 1);
  lcd.print("DO AM   :");
  int err = SimpleDHTErrSuccess;
  if ((err = dht11.read(pinDHT11, &temperature, &humidity, NULL)) == SimpleDHTErrSuccess) {
    sprintf(giatrinhietdo, "%d", (int)temperature);
    sprintf(giatridoam, "%d", (int)humidity);
    lcd.setCursor(11, 0);
    lcd.print(giatrinhietdo);
    lcd.print("*C");
    lcd.setCursor(11, 1);
    lcd.print(giatridoam);
    lcd.print(" %");

  }
  pinMode(D4, OUTPUT);
  //pinMode(D3, OUTPUT);
  //pinMode(D5, OUTPUT);
  //pinMode(D7, OUTPUT);
  //pinMode(D8, OUTPUT);
  // Két nối wifi.
  WiFi.begin(ssid, password);
  delay(500);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println();
  Serial.print("Ket noi thanh cong:");
  Serial.println(WiFi.localIP());

  Firebase.begin(FIREBASE_HOST, FIREBASE_AUTH);
}

void loop() {
  //DIEU KHIEN VAN
  String giatri = Firebase.getString("VAN");
  if (giatri.toInt() == 1)
  {
    digitalWrite(D4, LOW);
    Serial.println("Van1 da tat");
    delay(200);
  }
  else if (giatri.toInt() == 0)
  {
    digitalWrite(D4, HIGH);
    Serial.println("Van1 da bat");
    delay(200);
  }
  //DOC GIA TRI NHIET DO,DO AM
  int err = SimpleDHTErrSuccess;
  if ((err = dht11.read(pinDHT11, &temperature, &humidity, NULL)) == SimpleDHTErrSuccess) {
    sprintf(giatrinhietdo, "%d", (int)temperature);
    sprintf(giatridoam, "%d", (int)humidity);
    lcd.setCursor(11, 0);
    lcd.print(giatrinhietdo);
    lcd.print("*C");
    lcd.setCursor(11, 1);
    lcd.print(giatridoam);
    lcd.print(" %");
  }
  Firebase.setString("nhietdo", giatrinhietdo);
  Firebase.setString("doam", giatridoam);
  delay(500);
}
