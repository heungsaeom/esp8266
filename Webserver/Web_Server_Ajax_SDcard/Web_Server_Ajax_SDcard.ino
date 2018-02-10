#include <SPI.h>
#include <Ethernet.h>
#include <SD.h>

#define REQ_BUF_SZ   60                                 //Tạo bộ đếm để nhận và gởi yêu cầu HTTP

byte mac[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };    //Địa chỉ MAC của Ethernet Shield (có thể tự đặt theo hệ số HEX)
IPAddress ip(192, 168, 0, 20);                          //Địa chỉ IP của Ethernet Shield
EthernetServer server(80);                              //Cổng kết nối HTTP
File webFile;                                           //Các tập tin trang web được lưu trên thẻ SD
char HTTP_req[REQ_BUF_SZ] = {0};                        //Khởi tạo chuổi yêu cầu rỗng
char req_index = 0;                                     //Khởi tạo bộ đệm yêu cầu
boolean LED_state[7] = {0};                             //Khởi tạo mảng có 7 phần tử để lưu trữ các trạng thái của LED

void setup()
{
    pinMode(10, OUTPUT);
    digitalWrite(10, HIGH);
    
    Serial.begin(9600);
    
    //Khởi tạo thẻ SD
    Serial.println(F("Initializing SD card..."));
    if (!SD.begin(4)) {
        Serial.println(F("ERROR - SD card initialization failed!"));
        return;
    }
    Serial.println(F("SUCCESS - SD card initialized."));
    
    //Tìm kiếm file index.htm trên thẻ SD
    if (!SD.exists("index.htm")) {
        Serial.println(F("ERROR - Can't find index.htm file!"));
        return;
    }
    Serial.println(F("SUCCESS - Found index.htm file."));
    
    //Khai báo chân kết nối LED
    pinMode(2, OUTPUT);
    pinMode(3, OUTPUT);
    pinMode(5, OUTPUT);
    pinMode(6, OUTPUT);
    pinMode(7, OUTPUT);
    pinMode(8, OUTPUT);
    pinMode(9, OUTPUT);
    
    Ethernet.begin(mac, ip);
    server.begin();
}

void loop()
{ 
    EthernetClient client = server.available();     //Kiểm tra khởi tạo kết nối client

    if (client)
    {
        boolean currentLineIsBlank = true;
        while (client.connected())
        {
            if (client.available())
            {
                char c = client.read();             //Đọc dữ liệu từ client
                if (req_index < (REQ_BUF_SZ - 1))
                {
                    HTTP_req[req_index] = c;
                    req_index++;
                }

                //Kiểm tra yêu cầu từ client và gởi trang web đến client
                if (c == '\n' && currentLineIsBlank)
                {
                    client.println(F("HTTP/1.1 200 OK"));
                    
                    if (StrContains(HTTP_req, "ajax_inputs"))
                    {
                        client.println(F("Content-Type: text/xml"));
                        client.println(F("Connection: keep-alive"));
                        client.println();
                        SetLEDs();
                        XML_response(client);
                    }
                    else
                    {
                        client.println(F("Content-Type: text/html"));
                        client.println(F("Connection: keep-alive"));
                        client.println();
                        webFile = SD.open("index.htm");
                        if (webFile)
                        {
                            while(webFile.available())
                            {
                                client.write(webFile.read());
                            }
                            webFile.close();
                        }
                    }
                    Serial.print(HTTP_req);
                    req_index = 0;
                    StrClear(HTTP_req, REQ_BUF_SZ);
                    break;
                }

                if (c == '\n')
                {
                    currentLineIsBlank = true;
                } 
                else if (c != '\r')
                {
                    currentLineIsBlank = false;
                }
            }
        }
        delay(1);
        client.stop();
    }
}

void SetLEDs(void)
{
    // LED 1 (pin 2)
    if (StrContains(HTTP_req, "LED1=1"))
    {
        LED_state[0] = 1;
        digitalWrite(2, HIGH);
    }
    else if (StrContains(HTTP_req, "LED1=0"))
    {
        LED_state[0] = 0;
        digitalWrite(2, LOW);
    }
    
    // LED 2 (pin 3)
    if (StrContains(HTTP_req, "LED2=1"))
    {
        LED_state[1] = 1;
        digitalWrite(3, HIGH);
    }
    else if (StrContains(HTTP_req, "LED2=0"))
    {
        LED_state[1] = 0;
        digitalWrite(3, LOW);
    }
    
    // LED 3 (pin 5)
    if (StrContains(HTTP_req, "LED3=1"))
    {
        LED_state[2] = 1;
        digitalWrite(5, HIGH);
    }
    else if (StrContains(HTTP_req, "LED3=0"))
    {
        LED_state[2] = 0;
        digitalWrite(5, LOW);
    }
    
    // LED 4 (pin 6)
    if (StrContains(HTTP_req, "LED4=1"))
    {
        LED_state[3] = 1;
        digitalWrite(6, HIGH);
    }
    else if (StrContains(HTTP_req, "LED4=0"))
    {
        LED_state[3] = 0;
        digitalWrite(6, LOW);
    }
    
    // LED 5 (pin 7)
    if (StrContains(HTTP_req, "LED5=1"))
    {
        LED_state[4] = 1;
        digitalWrite(7, HIGH);
    }
    else if (StrContains(HTTP_req, "LED5=0"))
    {
        LED_state[4] = 0;
        digitalWrite(7, LOW);
    }
    
    // LED 6 (pin 8)
    if (StrContains(HTTP_req, "LED6=1"))
    {
        LED_state[5] = 1;
        digitalWrite(8, HIGH);
    }
    else if (StrContains(HTTP_req, "LED6=0"))
    {
        LED_state[5] = 0;
        digitalWrite(8, LOW);
    }
    
    // LED 7 (pin 9)
    if (StrContains(HTTP_req, "LED7=1"))
    {
        LED_state[6] = 1;
        digitalWrite(9, HIGH);
    }
    else if (StrContains(HTTP_req, "LED7=0"))
    {
        LED_state[6] = 0;
        digitalWrite(9, LOW);
    }
}

//Gởi file XML chứa thông tin trạng thái của LED và đầu vào analog
void XML_response(EthernetClient cl)
{
    int analog_val;            //Lưu trữ giá trị của đầu vào analog
    int count;                 //Sử dụng trong vòng lặp for
    
    cl.print(F("<?xml version = \"1.0\" ?>"));
    cl.print(F("<inputs>"));
    
    //Đọc đầu vào analog
    for (count = 2; count <= 5; count++)        // A2 to A5
    { 
        analog_val = analogRead(count);
        cl.print(F("<analog>"));
        cl.print(analog_val);
        cl.println(F("</analog>"));
    }
    
    //Đọc trang thái của LED
    // LED1
    cl.print(F("<LED>"));
    if (LED_state[0]) {
        cl.print(F("on"));
    }
    else {
        cl.print(F("off"));
    }
    cl.println(F("</LED>"));

    // LED2
    cl.print(F("<LED>"));
    if (LED_state[1]) {
        cl.print(F("on"));
    }
    else {
        cl.print(F("off"));
    }
    cl.println(F("</LED>"));
    
    // LED3
    cl.print(F("<LED>"));
    if (LED_state[2]) {
        cl.print(F("on"));
    }
    else {
        cl.print(F("off"));
    }
    cl.println(F("</LED>"));
    
    // LED4
    cl.print(F("<LED>"));
    if (LED_state[3]) {
        cl.print(F("on"));
    }
    else {
        cl.print(F("off"));
    }
    cl.println(F("</LED>"));

    // LED5
    cl.print(F("<LED>"));
    if (LED_state[4]) {
        cl.print(F("on"));
    }
    else {
        cl.print(F("off"));
    }
    cl.println(F("</LED>"));

    // LED6
    cl.print(F("<LED>"));
    if (LED_state[5]) {
        cl.print(F("on"));
    }
    else {
        cl.print(F("off"));
    }
    cl.println(F("</LED>"));

    // LED7
    cl.print(F("<LED>"));
    if (LED_state[6]) {
        cl.print(F("on"));
    }
    else {
        cl.print(F("off"));
    }
    cl.println(F("</LED>"));
    
    cl.print(F("</inputs>"));
}

//Xóa mảng trạng thái của LED
void StrClear(char *str, char length)
{
    for (int i = 0; i < length; i++) {
        str[i] = 0;
    }
}

//Tìm kiếm các chuỗi trong chuỗi str
char StrContains(char *str, char *sfind)
{
    char found = 0;
    char index = 0;
    char len;

    len = strlen(str);
    
    if (strlen(sfind) > len)
    {
        return 0;
    }
    while (index < len)
    {
        if (str[index] == sfind[found])
        {
            found++;
            if (strlen(sfind) == found)
            {
                return 1;
            }
        }
        else 
        {
            found = 0;
        }
        index++;
    }
    return 0;
}
