<!DOCTYPE html>
<html>
    <head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta http-equiv="Content-Type" content="application/vnd.wap.xhtml+xml; charset=utf-8" />
		<link rel="icon" href="https://lh5.googleusercontent.com/r11mo3rYZTueO-8sizMyXjydP_-j_i2L_LA2k0R5hsMMLFM8784IeQe-1bSzuCDQox25vuZmfnrZxTs=w1366-h663">
		<TITLE>Elnino IOT - Điều khiển</TITLE>
		<style type="text/css">
			body {
				background-color:#00676B;
				background: linear-gradient(top, #CAE5E8 0%, #00676B 100%);
				background:-o-linear-gradient(top, #CAE5E8 #00676B);
				background:-moz-linear-gradient(top, #CAE5E8, #00676B);
				background:-webkit-gradient(linear, left top, left bottom, from(#CAE5E8), to(#00676B));
				filter: progid:DXImageTransform.Microsoft.gradient( startColorstr ='#CAE5E8', endColorstr ='#00676B');
				background: -ms-linear-gradient(top, #CAE5E8, #00676B);
				background-attachment: fixed;
				border: 0px;
				margin: 0px;
				padding: 0px;
				color: #000000;
				font-family: Sans Serif, Arial Western, Verdana;
				font-size: small;
				text-align: center;
				align: center;
			}
			table {
				border: 0px;
				width: 60%;
				align: center;
				text-align: center;
				padding: 0px;
				vertical-align: middle;
				border-spacing: 0px;
				box-shadow: 15px 15px 15px #666666;
				-moz-box-shadow: 15px 15px 15px #666666;
				-webkit-box-shadow: 15px 15px 15px #666666;
			}
			tr {
				height: 40px;
			}
			th {
				background-color: #00bfff;
				height: 50px;
			}
			.trh1 {
				background-color: #CAE5E8;
			}
			.trh1:hover {
				background-color: #E6F1D8;
			}
			.trh2 {
				background-color: #99D1D3;
			}
			.trh2:hover {
				background-color: #E6F1D8;
			}
			h1 {
				margin: 25px;
				font-family: Arial Western, Verdana;
				text-shadow: 5px 3px 3px #999999;
				font-size: 20pt;
				font-weight: bold;
				color: #CCFFFF;
				border: 0px;
			}
			h6 {
				font-size: 10pt;
				font-weight: normal;
				text-shadow: 1px 1px 1px #999999;
				color: white;
				margin: 20px;
			}
			.bogoc {
				background-color: #ECECEC;
				-moz-border-radius: 10px;
				-webkit-border-radius: 10px;
				border-radius: 10px;
				box-shadow: 10px 10px 10px #666666;
				-moz-box-shadow: 10px 10px 10px #666666;
				-webkit-box-shadow: 10px 10px 10px #666666;	
			}
			.shadow {
				border: 1px solid #00676B;
				box-shadow: 10px 10px 10px #666666;
				-moz-box-shadow: 10px 10px 10px #666666;
				-webkit-box-shadow: 10px 10px 10px #666666;	
			}
			.button {
				background-color: green;
				color: #FFFFFF;
				padding: 4px 35px 4px 35px;
				text-align: center;
				margin: 0px;
				font-family: Arial Western, sans-serif;
				font-weight: bold;
				text-decoration: none;
				-moz-border-radius: 5px;
				-webkit-border-radius: 5px;
				-o-border-radius: 5px;
				border-radius: 5px;
				border-color:black;
				border-top:2px solid;
				border-bottom:2px solid;
				border-right:2px solid;
				border-left:2px solid;
			}
			.button:link {
				background-color: #293F5E;
				color: #FFFFFF;
			}
			.button:visited {
				background-color: #293F5E;
				color: #FFFFFF;
			}
			.button:hover {
				background-color: red;
				color: #FFFFFF;
			}
			.button:active {
				background-color: red;
				color: #FFFFFF;
			}
			.IO_box {
				background-color: #CAE5E8; 
				float: left;
				margin: 50 20px 20px 0;
				border: 1px solid blue;
				padding: 50 20px 20 5px;
				width: 250px;
			}
			.IO_box:hover {
				background-color: #E6F1D8; 
				float: left;
				margin: 50 20px 20px 0;
				border: 1px solid blue;
				padding: 50 20px 20 5px;
				width: 250px;
			}
		</style>
    </head>
    <body onload="GetArduinoIO()"  align="center">
		
        <p style="color:blue; font-size:30px;"><i class="fa fa-wifi" style="font-size:36px"></i> Điều khiển thiết bị thông qua Internet </p>
		<hr />
	<br />
	<br />
	<table align="center">
		<tr>
			<th width="40%"><h2>Thiết bị</h2></th>
			<th width="15%"><h2>Trạng thái</h2></th>
			<th width="50%"><h2>Bật/Tắt</h2></th>
		</tr>
		
		<tr class="trh1">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-heartbeat" style="font-size:20px;color:red"></i> LED1 (Chân D2)
			</td>
			<td align="center">
				<b><span id="State_LED1">TẮT</span></b>
			</td>
			<td align="center">
				<form method="get" action="index.php">
				<button type="submit" value="ON" name="led1on" class="button"">ON</button>
				<button type="submit" value="OFF" name="led1off" class="button"">OFF</button>
				</form>
			</td>
		</tr>
		
		<tr class="trh2">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-heartbeat" style="font-size:20px;color:red"></i> LED2 (Chân D3)
			</td>
			<td align="center">
				<b><span id="State_LED2">TẮT</span></b>
			</td>
			<td align="center">
				<form method="get" action="index.php">
				<button type="submit" value="ON" name="led2on" class="button"">ON</button>
				<button type="submit" value="OFF" name="led2off" class="button"">OFF</button>
				</form>
			</td>
		</tr>
		
		<tr class="trh1">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-heartbeat" style="font-size:20px;color:red"></i> LED3 (Chân D5)
			</td>
			<td align="center">
				<b><span id="State_LED3">TẮT</span></b>
			</td>
			<td align="center">
				<form method="get" action="index.php">
				<button type="submit" value="ON" name="led3on" class="button"">ON</button>
				<button type="submit" value="OFF" name="led3off" class="button"">OFF</button>
				</form>
			</td>
		</tr>
		
		<tr class="trh2">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-heartbeat" style="font-size:20px;color:red"></i> LED4 (Chân D6)
			</td>
			<td align="center">
				<b><span id="State_LED4">TẮT</span></b>
			</td>
			<td align="center">
				<form method="get" action="index.php">
				<button type="submit" value="ON" name="led4on" class="button"">ON</button>
				<button type="submit" value="OFF" name="led4off" class="button"">OFF</button>
				</form>
			</td>
		</tr>

		<tr class="trh1">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-heartbeat" style="font-size:20px;color:red"></i> LED5 (Chân D7)
			</td>
			<td align="center">
				<b><span id="State_LED5">TẮT</span></b>
			</td>
			<td align="center">
				<form method="get" action="index.php">
				<button type="submit" value="ON" name="led5on" class="button"">ON</button>
				<button type="submit" value="OFF" name="led5off" class="button"">OFF</button>
				</form>
			</td>
		</tr>

		<tr class="trh2">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-heartbeat" style="font-size:20px;color:red"></i> LED6 (Chân D8)
			</td>
			<td align="center">
				<b><span id="State_LED6">TẮT</span></b>
			</td>
			<td align="center">
				<form method="get" action="index.php">
				<button type="submit" value="ON" name="led6on" class="button"">ON</button>
				<button type="submit" value="OFF" name="led6off" class="button"">OFF</button>
				</form>
			</td>
		</tr>
		
		<tr class="trh1">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-heartbeat" style="font-size:20px;color:red"></i> LED7 (Chân D9)
			</td>
			<td align="center">
				<b><span id="State_LED7">TẮT</span></b>
			</td>
			<td align="center">
				<form method="get" action="index.php">
				<button type="submit" value="ON" name="led7on" class="button"">ON</button>
				<button type="submit" value="OFF" name="led7off" class="button"">OFF</button>
				</form>
			</td>
		</tr>
		
		<tr class="trh2">
			<td align="center" colspan="3">
				<h2>Trạng thái các chân Analog</h2>
				<b>A0: </b> Not use &nbsp&nbsp&nbsp&nbsp&nbsp
				<b>A1: </b> Not use &nbsp&nbsp&nbsp&nbsp&nbsp
				<b>A2: </b> <span class="analog">...</span>&nbsp&nbsp&nbsp&nbsp&nbsp
				<b>A3: </b> <span class="analog">...</span>&nbsp&nbsp&nbsp&nbsp&nbsp
				<b>A4: </b> <span class="analog">...</span>&nbsp&nbsp&nbsp&nbsp&nbsp
				<b>A5: </b> <span class="analog">...</span>
				<br />
				<br />
			</td>
		</tr>
	</table>
	</div>
	<?php
         if(isset($_GET['led1on'])){
                 exec('sudo python /var/www/html/led.py');
                 echo "LED is on";
         }
         else if(isset($_GET['led1off'])){
                 exec('sudo python /var/www/html/led.py');
                 echo "LED is off";
         }
    ?>

	<br />
	<br />
	<h6>Hùng Elnino | Điều khiển thiết bị sử dụng Raspberry</h6>
    </body>
</html>
