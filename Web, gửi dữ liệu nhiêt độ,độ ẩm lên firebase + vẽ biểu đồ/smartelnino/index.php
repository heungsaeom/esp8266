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
		<script type="text/javascript">

		function time() {
   var today = new Date();
   var weekday=new Array(7);
   weekday[0]="Chủ Nhật";
   weekday[1]="Thứ Hai";
   weekday[2]="Thứ Ba";
   weekday[3]="Thứ Tư";
   weekday[4]="Thứ Năm";
   weekday[5]="Thứ Sáu";
   weekday[6]="Thứ Bảy";
   var day = weekday[today.getDay()]; 
   var dd = today.getDate();
   var mm = today.getMonth()+1; //January is 0!
   var yyyy = today.getFullYear();
   var h=today.getHours();
   var m=today.getMinutes();
   var s=today.getSeconds();
   m=checkTime(m);
   s=checkTime(s);
   nowTime = h+":"+m+":"+s;
   if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = day+', '+ dd+'/'+mm+'/'+yyyy;
 
   tmp='<span class="date">'+today+' - Time: '+nowTime+'</span>';
 
   document.getElementById("clock").innerHTML=tmp;
 
   clocktime=setTimeout("time()","1000","JavaScript");
   function checkTime(i)
   {
      if(i<10){
   i="0" + i;
      }
      return i;
   }
		}
		</script>
    </head>
    <body onload="time()" align="center">
		<div id="clock" style="font-size: 20px; background-color: blue; color: white;" ></div>
		<marquee direction="right" behavior="alternate" width="900px" ><h2>Hệ thống điều khiển thiết bị SmartElnino</h2></marquee>
		<br>
		<img src="img/logo.gif" width="150" height="150">

	
	<br />

	<?php include('bangnhietdo.php');?>
	<?php include('bangdoam.php');?>
	

	<br />

	<table align="center">
		<tr>
			<th width="30%"><h2>Thiết bị</h2></th>
			<th width="20%"><h2>Trạng thái</h2></th>
			<th width="40%"><h2>Bật/Tắt</h2></th>
		</tr>
		
		<tr class="trh1">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-plug" style="font-size:20px;color:red"></i> Thiết bị 1
			</td>
			<td align="center">
				<b><span id="State_LED1">TẮT</span></b>
			</td>
			<td align="center">
				<form method="GET" action="led1.php">
				<button type="submit" value="1" name="led1" class="button""><i class="fa fa-lightbulb-o" style="font-size:20px"></i> ON</button>
				<button type="submit" value="0" name="led1" class="button""> <i class="fa fa-lightbulb-o" style="font-size:20px"></i> OFF</button>
				</form>
			</td>
		</tr>
		
		<tr class="trh2">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-plug" style="font-size:20px;color:red"></i> Thiết bị 2
			</td>
			<td align="center">
				<b><span id="State_LED2">TẮT</span></b>
			</td>
			<td align="center">
				<form method="GET" action="led2.php">
				<button type="submit" value="1" name="led2" class="button""> <i class="fa fa-lightbulb-o" style="font-size:20px"></i> ON</button>
				<button type="submit" value="0" name="led2" class="button""> <i class="fa fa-lightbulb-o" style="font-size:20px"></i> OFF</button>
				</form>
			</td>
		</tr>
		
		<tr class="trh1">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-plug" style="font-size:20px;color:red"></i> Thiết bị 3
			</td>
			<td align="center">
				<b><span id="State_LED3">TẮT</span></b>
			</td>
			<td align="center">
				<form method="GET" action="led3.php">
				<button type="submit" value="1" name="led3" class="button""> <i class="fa fa-lightbulb-o" style="font-size:20px"></i> ON</button>
				<button type="submit" value="0" name="led3" class="button""> <i class="fa fa-lightbulb-o" style="font-size:20px"></i> OFF</button>
				</form>
			</td>
		</tr>
		
		<tr class="trh2">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-plug" style="font-size:20px;color:red"></i> Thiết bị 4
			</td>
			<td align="center">
				<b><span id="State_LED4">TẮT</span></b>
			</td>
			<td align="center">
				<form method="GET" action="led4.php">
				<button type="submit" value="1" name="led4" class="button""> <i class="fa fa-lightbulb-o" style="font-size:20px"></i> ON</button>
				<button type="submit" value="0" name="led4" class="button""> <i class="fa fa-lightbulb-o" style="font-size:20px"></i> OFF</button>
				</form>
			</td>
		</tr>
		<tr class="trh1">
			<td align="center">
				&nbsp;
				&nbsp;
				<i class="fa fa-plug" style="font-size:20px;color:red"></i> TẤT CẢ
			</td>
			<td align="center">
				<b><span id="State_LED3">TẮT</span></b>
			</td>
			<td align="center">
				<form method="GET" action="allled.php">
				<button type="submit" value="1" name="allled" class="button""> <i class="fa fa-lightbulb-o" style="font-size:20px"></i> ON</button>
				<button type="submit" value="0" name="allled" class="button""> <i class="fa fa-lightbulb-o" style="font-size:20px"></i> OFF</button>
				</form>
			</td>
		</tr>
		
		
		
		
	</table>
	</div>

	<br />
	<br />
	 <h6><i class="fa fa-user-secret" style="font-size:16px"></i> Hùng Elnino | Điều khiển thiết bị thông qua Internet</h6>
    </body>

</html>
