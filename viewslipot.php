<?php
session_start();
include('db/connectdb.inc');
$id = $_REQUEST["id"]; 
$sempid = $_SESSION["sempid"];
$userid = $_SESSION["suserid"];
$usernameid=	$_SESSION["susernameid"];
$userlevel=$_SESSION["suserlevel"];
$id = base64_decode($id);
$enc = base64_encode($id);

//echo "id = $id , sempid = $sempid <Br>$userlevel = $userlevel <Br>";

if ($userlevel == '1') {
	$sqls = "select *from slipot where id='$id' and empid = '$sempid' ";
	$results = mysql_query($sqls);
	$nums = mysql_num_rows($results);
	//echo "sql = $sqls <br> results = $results <Br> nums  =$nums <br>";
		if ($nums == '0') { 
		header( "location: employee.php" );
		exit();
		}

}//level 1 

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Language" content="th">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta name="keyword" content="">
<title>สถาบันโรคทรวงอก : Slip Online</title>

<style type="text/css">
@font-face {  
	  font-family: Taviraj ;  
	  src: url( fonts/Taviraj.ttf ) format("truetype");  
}
.Taviraj { font-family: Taviraj; }

@font-face {  
	  font-family: ChakraPetch ;  
	  src: url( fonts/ChakraPetch.ttf ) format("truetype");  
}
.ChakraPetch { font-family: ChakraPetch; }

</style>

<!-- Favicons -->
<link href="img/favicon.png" rel="icon">
<link href="img/apple-touch-icon.png" rel="apple-touch-icon">

<!-- Bootstrap core CSS -->
<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!--external css-->
<link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="css/zabuto_calendar.css">
<link rel="stylesheet" type="text/css" href="lib/gritter/css/jquery.gritter.css" />
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-fileupload/bootstrap-fileupload.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-datepicker/css/datepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-daterangepicker/daterangepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-timepicker/compiled/timepicker.css" />
  <link rel="stylesheet" type="text/css" href="lib/bootstrap-datetimepicker/datertimepicker.css" />

<!-- Custom styles for this template -->
<link href="css/style.css" rel="stylesheet">
<link href="css/style-responsive.css" rel="stylesheet">
<script src="lib/chart-master/Chart.js"></script>

<!-- =======================================================
Template Name: Dashio
Template URL: https://templatemag.com/dashio-bootstrap-admin-template/
Author: TemplateMag.com
License: https://templatemag.com/license/
======================================================= -->
</head>

<body>

<!--
<center><font size=12 color=red style="padding-top=500px;">
อยู่ในระหว่างการทดสอบระบบ
</font></center>

 <style> 
 h1 {
 position: absolute;
 top: 100px;
 z-index: -1;
 } 
 img {
 opacity: 0.7;
 } 
 </style>

 <div>
 <img src="img/test.png" width="30%">
 </div>
<img src='img/test.png'>
<div  style='margin-top=-500px;'></div>-->

<?php

if ($userlevel == '1') {
$sql = "select *, s.emptypeid AS semptypeid  from slipot s
			LEFT JOIN employee e ON e.empid = s.empid
			where s.id='$id' and e.empid = '$sempid'
			";
 }
else if (($userlevel == '2') or ($userlevel == '3')) {

$sql = "select *, s.emptypeid AS semptypeid  from slipot s
			LEFT JOIN employee e ON e.empid = s.empid
			where s.id='$id' 
			";
}


$result = mysql_query($sql);
//echo "sql = $sql <br> result = $result<Br>";
	$rows=mysql_fetch_array($result);
	$usernameid = $rows["USERNAME_ID"];
	$userlevel = $rows["USERLEVEL_ID"];
	$depart = $rows["department"];
	$empid = $rows["empid"];
	$userlogo = $rows["USER_LOGO"];
	$prename = $rows["prename"];
	$name = $rows["name"];
	$lastname = $rows["lastname"];
	$bankno = $rows["nobank"];
	$position = $rows["position"];
	$bankid = $rows["bankid"];
	$idno = $rows["idno"];
	$emptypeid = $rows["semptypeid"];
	$budget = $rows["budget"];
	

		switch ($budget) {
		case "11":
			$typename = 'ข้าราชการ';
			$headname = 'รายได้ - ค่าตอบแทน (เงินงบประมาณ)';
			$headmoney ='รายการ';
			$headsummoney ='รวมจำนวนเงินทั้งหมด';
			$headexp = 'รายการรายจ่าย';
			$headsumexp = 'รวมจ่ายทั้งเดือน';
			$headall =  'รับสุทธิ';
			break;

		case "12":
			$typename = 'ลูกจ้างประจำ';
			$headname = 'รายได้ - ค่าตอบแทน (เงินบำรุง)';
			$headmoney ='รายการ';
			$headsummoney ='รวมรับทั้งเดือน';
			$headexp = 'รายการรายจ่าย';
			$headsumexp = 'รวมจ่ายทั้งเดือน';
			$headall =  'รับสุทธิ';
			break;

		}


$datepay = $rows["datepay"];
$idno = $rows["idno"];
//echo "datepay  -$datepay  <Br>";
$mm5 = $rows["mm"];
$yy5 = $rows["yy"];

$yy = substr($datepay, 0 ,4);
$mm=substr($datepay, 5 ,2);
$dd = substr($datepay, 8 ,2);
$yy2 = $yy +543;
$datepay3  = $dd ."/".$mm."/".$yy2;


$money1 = $rows["money1"];
$money2 = $rows["money2"];
$money3 = $rows["money3"];
$money4 = $rows["money4"];
$money5 = $rows["money5"];
$money6 = $rows["money6"];
$money7 = $rows["money7"];
$money8 = $rows["money8"];
$money9 = $rows["money9"];
$money10 = $rows["money10"];
$money11 = $rows["money11"];
$money12 = $rows["money12"];
$money13 = $rows["money13"];
$money14 = $rows["money14"];
$money15 = $rows["money15"];
$money16 = $rows["money16"];
$money17 = $rows["money17"];
$money18 = $rows["money18"];
$money19 = $rows["money19"];
$money20 = $rows["money20"];


$money_text1 = $rows["money_text1"];
$money_text2 = $rows["money_text2"];
$money_text3 = $rows["money_text3"];
$money_text4 = $rows["money_text4"];
$money_text5 = $rows["money_text5"];
$money_text6 = $rows["money_text6"];
$money_text7 = $rows["money_text7"];
$money_text8 = $rows["money_text8"];
$money_text9 = $rows["money_text9"];
$money_text10 = $rows["money_text10"];
$money_text11 = $rows["money_text11"];
$money_text12 = $rows["money_text12"];
$money_text13 = $rows["money_text13"];
$money_text14 = $rows["money_text14"];
$money_text15 = $rows["money_text15"];
$money_text16 = $rows["money_text16"];
$money_text17 = $rows["money_text17"];
$money_text18 = $rows["money_text18"];
$money_text19 = $rows["money_text19"];
$money_text20 = $rows["money_text20"];

$summoney = $rows["summoney"];
$sumexp = $rows["sumexp"];
$sumnet = $rows["sumnet"];

$summoney2=number_format($summoney , 2 );
$sumexp2=number_format($sumexp , 2 );
$sumnet2=number_format($sumnet , 2 );

switch ($mm5) {
case "1":
	$monthname = 'มกราคม';
    break;
case "2":
	$monthname = 'กุมภาพันธ์';
    break;
case "3":
	$monthname = 'มีนาคม';
    break;
case "4":
	$monthname = 'เมษายน';
    break;
case "5":
	$monthname = 'พฤษภาคม';
    break;
case "6":
	$monthname = 'มิถุนายน';
    break;
case "7":
	$monthname = 'กรกฎาคม';
    break;
case "8":
	$monthname = 'สิงหาคม';
    break;
case "9":
	$monthname = 'กันยายน';
    break;
case "10":
	$monthname = 'ตุลาคม';
    break;
case "11":
	$monthname = 'พฤศจิกายน';
    break;
case "12":
	$monthname = 'ธันวาคม';
    break;
}


switch ($mm) {
case "1":
	$monthname1 = 'มกราคม';
    break;
case "2":
	$monthname1 = 'กุมภาพันธ์';
    break;
case "3":
	$monthname1 = 'มีนาคม';
    break;
case "4":
	$monthname1 = 'เมษายน';
    break;
case "5":
	$monthname1 = 'พฤษภาคม';
    break;
case "6":
	$monthname1 = 'มิถุนายน';
    break;
case "7":
	$monthname1 = 'กรกฎาคม';
    break;
case "8":
	$monthname1 = 'สิงหาคม';
    break;
case "9":
	$monthname1 = 'กันยายน';
    break;
case "10":
	$monthname1 = 'ตุลาคม';
    break;
case "11":
	$monthname1 = 'พฤศจิกายน';
    break;
case "12":
	$monthname1 = 'ธันวาคม';
    break;
}

$datepay2 = $dd.' '.$monthname1.' '.$yy2;


echo "
<Table width='850' align='center' border=0 bgcolor=white   >
<!-- Head -->
<tr bgcolor=white ><td style='padding: 15px;'> 

	<table border=0  width=100%>
	<tr valign=top >
	<td rowspan=4><img src='img/logo.png' width=120 ></td>
	<td colspan=2><font color=#000>&nbsp;&nbsp;&nbsp;$headname เข้าบัญชี 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;วันที่  $datepay2  </td>
	
	</tr>
 

	<tr valign=top >
	<td><font color=#000>&nbsp;&nbsp;&nbsp;ชื่อ - นามสกุล &nbsp;&nbsp;:&nbsp;&nbsp; $prename$name $lastname <Br>
	&nbsp;&nbsp;&nbsp;หน่วยงาน &nbsp;&nbsp;:&nbsp;&nbsp; $depart<Br>
	&nbsp;&nbsp;&nbsp;เข้าบัญชี ธ.กรุงไทย เลขที่  &nbsp;&nbsp;:&nbsp;&nbsp; $bankno
	</td>
";


echo"	<td rowspan=3><center>
<A href='viewslipotprint.php?id=$enc'><img src='img/printer.png'><Br> พิมพ์สลิป</a></td>";


echo"
	</tr>

	<tr valign=top >
	<td align=right><font size=2 color=#333>
	<!---กรุณาตรวจสอบรายการอีกครั้ง หากไม่ถูกต้องกรุณาติดต่อกลุ่มงานการเงินฯ โทร 30975-->
	เอกสารส่วนบุคคล / หากมีข้อสงสัยกรุณาติดต่อ งานการเงินด้วยตนเอง เบอร์โทรศัพท์ 30961&nbsp;&nbsp;&nbsp;

	</td>
	</tr>

	</table>
</td></tr>

<!-- Detail 
<tr bgcolor=white style='background-image: url(img/test.png);' >-->
<tr bgcolor=white >
<td style='padding: 15px;'><font color=#000>
<!--<u>รายการ</u></font><Br>
<hr style='margin-top:5px;'>-->


<table width=100%  style='margin-top:-5px;' > 
<tr  valign=top>
<Td width=50%>

	<table width=100%>
	<tr>
	<td width=50%><font color=#000><u>$headmoney</u></td>
	<td width=50% align=right><font color=#000><u>จำนวนเงิน (บาท)
	<Br><Br></td>
	</tr>
	";

if ($money_text1 <> '' ) { 
	$money1=number_format($money1 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text1</td>
	<td width=50% align=right><font color=#000>$money1</td>
	</tr>
	";
}

if ($money_text2 <> '' ) { 
	$money2=number_format($money2 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text2</td>
	<td width=50% align=right><font color=#000>$money2</td>
	</tr>
	";
}

if ($money_text3 <> '' ) { 
	$money3=number_format($money3 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text3</td>
	<td width=50% align=right><font color=#000>$money3</td>
	</tr>
	";
}

if ($money_text4 <> '' ) { 
	$money4=number_format($money4 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text4</td>
	<td width=50% align=right><font color=#000>$money4</td>
	</tr>
	";
}

if (($money_text5 <> '' ) and ($money_text5 <> '$' )){ 
//if ($money_text5 <> '' ) { 
	$money5=number_format($money5 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text5</td>
	<td width=50% align=right><font color=#000>$money5</td>
	</tr>
	";
}

if (($money_text6 <> '' ) and ($money_text6 <> '$' )){ 
//if ($money_text6 <> '' ) { 
	$money6=number_format($money6 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text6</td>
	<td width=50% align=right><font color=#000>$money6</td>
	</tr>
	";
}

if (($money_text7 <> '' ) and ($money_text7 <> '$' )){ 
//if ($money_text7 <> '' ) { 
	$money7=number_format($money7 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text7</td>
	<td width=50% align=right><font color=#000>$money7</td>
	</tr>
	";
}

if ($money_text8 <> '' ) { 
	$money8=number_format($money8 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text8</td>
	<td width=50% align=right><font color=#000>$money8</td>
	</tr>
	";
}

if ($money_text9 <> '' ) { 
	$money9=number_format($money9 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text9</td>
	<td width=50% align=right><font color=#000>$money9</td>
	</tr>
	";
}

if ($money_text10 <> '' ) { 
	$money10=number_format($money10 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text10</td>
	<td width=50% align=right><font color=#000>$money10</td>
	</tr>
	";
}

 
if ($money_text11 <> '' ) { 
	$money11=number_format($money11 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text11</td>
	<td width=50% align=right><font color=#000>$money11</td>
	</tr>
	";
}

if ($money_text12 <> '' ) { 
	$money12=number_format($money12 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text12</td>
	<td width=50% align=right><font color=#000>$money12</td>
	</tr>
	";
}

if ($money_text13 <> '' ) { 
	$money13=number_format($money13 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text13</td>
	<td width=50% align=right><font color=#000>$money13</td>
	</tr>
	";
}

if ($money_text14 <> '' ) { 
	$money14=number_format($money14 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text14</td>
	<td width=50% align=right><font color=#000>$money14</td>
	</tr>
	";
}

if ($money_text15 <> '' ) { 
	$money15=number_format($money15 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text15</td>
	<td width=50% align=right><font color=#000>$money15</td>
	</tr>
	";
}


if (($money_text16 <> '' ) and ($money_text16 <> '$' )){ 
	$money16=number_format($money16 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text16</td>
	<td width=50% align=right><font color=#000>$money16</td>
	</tr>
	";
}

if (($money_text17 <> '' ) and ($money_text17 <> '$' )){ 
	$money17=number_format($money17 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text17</td>
	<td width=50% align=right><font color=#000>$money17</td>
	</tr>
	";
}

if ($money_text18 <> '' ) { 
	$money18=number_format($money18 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text18</td>
	<td width=50% align=right><font color=#000>$money18</td>
	</tr>
	";
}

if ($money_text19 <> '' ) { 
	$money19=number_format($money19 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text19</td>
	<td width=50% align=right><font color=#000>$money19</td>
	</tr>
	";
}

if ($money_text20 <> '' ) { 
	$money20=number_format($money20 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text20</td>
	<td width=50% align=right><font color=#000>$money20</td>
	</tr>
	";
}


echo "
	<tr>
	<td width=100% colspan=2><hr></td>
	</tr>
	<tr>
	<td width=50%><font color=#000>$headsummoney</td>
	<td width=50% align=right><font color=#000>$summoney2 บาท</td>
	</tr>
	</table>
</td>
";
echo"
</tr>

<!--<tr><td colspan=3 align=right><font color=#000><font size=4>
<b>$headall &nbsp;&nbsp;$sumnet2&nbsp;&nbsp; บาท </b>&nbsp;&nbsp;&nbsp;&nbsp;
</td></tr>
-->

<tr><td colspan=3>
<hr>
</td></tr>

<tr><td colspan=3>
&nbsp;<br><Br>
</td></tr>

<tr><td colspan=3>

<table align=center border=0>

<tr valign=bottom>
<td align=right ><font color=#000>ลงชื่อ &nbsp;&nbsp;&nbsp;</td>
<td style='width: 170px;border-bottom-style: dotted;'><center><img src='img/sign.png' width=140></center></td>
<td  align=left ><font color=#000>&nbsp;&nbsp;&nbsp; ผู้มีหน้าที่จ่ายเงิน</td>
</tr>

<tr valign=bottom >
<td colspan=3 style='padding: 5px'></td>
</tr>

<tr valign=bottom  >
<td align=right ></td>
<td ><font color=#000><center>( $datepay3 )</center></td>
<td></td>
</tr>

<tr valign=bottom >
<td colspan=3 style='padding: 5px'></td>
</tr>

<tr valign=bottom  >
<td align=right ></td>
<td width=250><font color=#000><center>วัน เดือน ปี ที่ออกหนังสือรับรอง</center></td>
<td></td>
</tr>




</table>

</td></tr>



<tr valign=top >
<td align=center colspan=3 ><br><font size=3 color=#333>
กรุณาตรวจสอบยอดเงินที่ได้รับทุกครั้ง หากไม่ถูกต้องกรุณาแจ้งงานการเงินทันที โทร 30961
<br><Br>
</td>
</tr>
</table>

</td></tr>
</table>
<br><Br>

</body>
</html>";

