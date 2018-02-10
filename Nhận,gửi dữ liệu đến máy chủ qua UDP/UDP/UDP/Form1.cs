using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;
using System.Threading;
using System.Net;
using System.Net.Sockets;
using System.IO;

namespace UDP
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }
        public void serverThread()
        {
            UdpClient udpClient = new UdpClient(80);
            while (true)
            {
                IPEndPoint RemoteIpEndPoint = new IPEndPoint(IPAddress.Any, 80);
                Byte[] receiveBytes = udpClient.Receive(ref RemoteIpEndPoint);
                string returnData = Encoding.ASCII.GetString(receiveBytes);

                this.Invoke((MethodInvoker)delegate()
                {
                    //lbConnections.Items.Add(RemoteIpEndPoint.Address.ToString() + ": " + returnData.ToString()); // Gửi dữ liệu có cả IP server
                    lbconnections.Items.Add(returnData.ToString()); // Không có địa chỉ IP của server
                    textBox2.Text = RemoteIpEndPoint.Address.ToString();
                });

            }
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            Thread thdserver = new Thread(new ThreadStart(serverThread));
            thdserver.Start();
            string[] IPreceive = { "192.168.100.160","192.168.100.110","192.168.100.115","192.168.100.170" };
            comboBox1.Items.AddRange(IPreceive);

        }

        private void button1_Click(object sender, EventArgs e)
        {
            UdpClient udpclient = new UdpClient();
            udpclient.Connect(comboBox1.Text, 80);
            Byte[] senddata = Encoding.ASCII.GetBytes(textBox3.Text);
            udpclient.Send(senddata, senddata.Length);
        }
    }
}
