
<?php
header("Content-Type: application/pdf");
header("Content-Disposition:inline;filename=\"invoice.pdf\"");
header("Content-Transfer-Encoding: binary");
// Require composer autoload
require_once __DIR__ . '../vendor/autoload.php';

// เพิ่ม Font ให้กับ mPDF
$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];
$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/tmp',
    'fontdata' => $fontData + [
            'sarabun' => [ // ส่วนที่ต้องเป็น lower case ครับ
                'R' => 'Taviraj.ttf',
                'I' => 'Taviraj.ttf',
                'B' =>  'Taviraj.ttf',
                'BI' => "Taviraj.ttf",
            ]
        ],
]);

ob_start(); // Start get HTML code
?>

<?php
session_start();
include('db/connectdb.inc');
$id = $_REQUEST["id"]; 
$sempid = $_SESSION["sempid"];
$userid = $_SESSION["suserid"];
$usernameid=	$_SESSION["susernameid"];
$userlevel=$_SESSION["suserlevel"];
//echo "id = $id , sempid = $sempid <Br>";

if ($userlevel == '1') {
	$sqls = "select *from slip where id='$id' and empid = '$sempid' ";
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


<!--<link href="https://fonts.googleapis.com/css?family=Sarabun&display=swap" rel="stylesheet">-->

<style type="text/css">

body {
    font-family: sarabun;
	background-color: #fff;
}

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
<?php
if ($userlevel == '1') {
$sql = "select *from slip s
			LEFT JOIN employee e ON e.empid = s.empid
			where s.id='$id' and e.empid = '$sempid'
			";
 }
else if ($userlevel == '3') {

$sql = "select *from slip s
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
	$bankno = $rows["bankno"];
	$position = $rows["position"];
	$bankid = $rows["bankid"];
	$idno = $rows["idno"];
	$emptypeid = $rows["emptypeid"];

		switch ($emptypeid) {
		case "1":
			$typename = 'ข้าราชการ';
			break;
		case "2":
			$typename = 'ลูกจ้างประจำ';
			break;
		case "3":
			$typename = 'พนักงานราชการ';
			break;
		case "4":
			$typename = 'พนักงานกระทรวง';
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
$yy2 = $yy -543;
//$datepay2 = $dd ."/".$mm."/".$yy;
$datepay2 = $dd.'/'.$mm.'/'.$yy2;

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


$exp1 = $rows["exp1"];
$exp2 = $rows["exp2"];
$exp3 = $rows["exp3"];
$exp4 = $rows["exp4"];
$exp5 = $rows["exp5"];
$exp6 = $rows["exp6"];
$exp7 = $rows["exp7"];
$exp8 = $rows["exp8"];
$exp9 = $rows["exp9"];
$exp10 = $rows["exp10"];
$exp11 = $rows["exp11"];
$exp12 = $rows["exp12"];
$exp13 = $rows["exp13"];
$exp14 = $rows["exp14"];
$exp15 = $rows["exp15"];
$exp16 = $rows["exp16"];
$exp17 = $rows["exp17"];
$exp18 = $rows["exp18"];
$exp19 = $rows["exp19"];
$exp20 = $rows["exp20"];

$exp_text1 = $rows["exp_text1"];
$exp_text2 = $rows["exp_text2"];
$exp_text3 = $rows["exp_text3"];
$exp_text4 = $rows["exp_text4"];
$exp_text5 = $rows["exp_text5"];
$exp_text6 = $rows["exp_text6"];
$exp_text7 = $rows["exp_text7"];
$exp_text8 = $rows["exp_text8"];
$exp_text9 = $rows["exp_text9"];
$exp_text10 = $rows["exp_text10"];
$exp_text11 = $rows["exp_text11"];
$exp_text12 = $rows["exp_text12"];
$exp_text13 = $rows["exp_text13"];
$exp_text14 = $rows["exp_text14"];
$exp_text15 = $rows["exp_text15"];
$exp_text16 = $rows["exp_text16"];
$exp_text17 = $rows["exp_text17"];
$exp_text18 = $rows["exp_text18"];
$exp_text19 = $rows["exp_text19"];
$exp_text20 = $rows["exp_text20"];

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

echo "
<Table width='850' align='center' border=0 bgcolor=white >

<!-- Head -->
<tr bgcolor=white  valign=top><td style='padding: 15px;'> 
	<table >

	<tr valign=top >
	<td rowspan=4><img src='img/logo.png' width=120 ></td>
	<td><font color=#000>&nbsp;&nbsp;&nbsp;ใบรับรองการจ่ายค่าจ้าง$typename (สถาบันโรคทรวงอก) ประจำเดือน $monthname $yy5 </td>
	</tr>

	<tr valign=top >
	<td><font color=#000>&nbsp;&nbsp;&nbsp;ชื่อ - นามสกุล &nbsp;&nbsp;:&nbsp;&nbsp; $prename$name $lastname <Br>
	&nbsp;&nbsp;&nbsp;หน่วยงาน &nbsp;&nbsp;:&nbsp;&nbsp; $depart
	</td>
	</tr>

	<tr valign=top >
	<td align=center><font size=2 color=#333>กรุณาตรวจสอบรายการอีกครั้ง หากไม่ถูกต้องกรุณาติดต่อกลุ่มงานการเงินฯ โทร 30975
	</td>
	</tr>
	</table>

</td></tr>

<!-- Detail -->
<tr bgcolor=white  valign=top><td style='padding: 15px;'><font color=#000><u>รายละเอียด</u></font><Br>
<hr style='margin-top:5px;'>

<table width=100%  style='margin-top:-5px;' > 



<tr  valign=top>
<Td width=50%  valign=top>

	<table width=100% >
	<tr  valign=top>
	<td width=50%><font color=#000><u>รายการค่าจ้าง</u></td>
	<td width=50% align=right><font color=#000>จำนวนเงิน (บาท)</td>
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

if ($money_text5 <> '' ) { 
	$money5=number_format($money5 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text5</td>
	<td width=50% align=right><font color=#000>$money5</td>
	</tr>
	";
}

if ($money_text6 <> '' ) { 
	$money6=number_format($money6 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$money_text6</td>
	<td width=50% align=right><font color=#000>$money6</td>
	</tr>
	";
}

if ($money_text7 <> '' ) { 
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


echo "
	<tr>
	<td width=100% colspan=2><hr></td>
	</tr>
	<tr>
	<td width=50%><font color=#000>รวมรายการค่าจ้าง</td>
	<td width=50% align=right><font color=#000>$summoney2</td>
	</tr>


	</table>

</td>
<Td width=5%>&nbsp;</td>

<Td width=50%>

	<table width=100%>
	<tr>
	<td width=50%><font color=#000><u>รายการหัก</u></td>
	<td width=50%><font color=#000>จำนวนเงิน (บาท)</td>
	</tr>
";

if ($exp_text1 <> '' ) { 
	$exp1=number_format($exp1 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text1</td>
	<td width=50% align=right><font color=#000>$exp1</td>
	</tr>
	";
}

if ($exp_text2 <> '' ) { 
	$exp2=number_format($exp2 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text2</td>
	<td width=50% align=right><font color=#000>$exp2</td>
	</tr>
	";
}


if ($exp_text3 <> '' ) { 
	$exp3=number_format($exp3 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text3</td>
	<td width=50% align=right><font color=#000>$exp3</td>
	</tr>
	";
}


if ($exp_text4 <> '' ) { 
	$exp4=number_format($exp4 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text4</td>
	<td width=50% align=right><font color=#000>$exp4</td>
	</tr>
	";
}

if ($exp_text5 <> '' ) { 
	$exp5=number_format($exp5 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text5</td>
	<td width=50% align=right><font color=#000>$exp5</td>
	</tr>
	";
}

if ($exp_text6 <> '' ) { 
	$exp6=number_format($exp6 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text6</td>
	<td width=50% align=right><font color=#000>$exp6</td>
	</tr>
	";
}

if ($exp_text7 <> '' ) { 
	$exp7=number_format($exp7 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text7</td>
	<td width=50% align=right><font color=#000>$exp7</td>
	</tr>
	";
}

if ($exp_text8 <> '' ) { 
	$exp8=number_format($exp8 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text8</td>
	<td width=50% align=right><font color=#000>$exp8</td>
	</tr>
	";
}

if ($exp_text9 <> '' ) { 
	$exp9=number_format($exp9 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text9</td>
	<td width=50% align=right><font color=#000>$exp9</td>
	</tr>
	";
}

if ($exp_text10 <> '' ) { 
	$exp10=number_format($exp10 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text10</td>
	<td width=50% align=right><font color=#000>$exp10</td>
	</tr>
	";
}


if ($exp_text11 <> '' ) { 
	$exp11=number_format($exp11 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text11</td>
	<td width=50% align=right><font color=#000>$exp11</td>
	</tr>
	";
}

if ($exp_text12 <> '' ) { 
	$exp12=number_format($exp12 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text12</td>
	<td width=50% align=right><font color=#000>$exp12</td>
	</tr>
	";
}


if ($exp_text13 <> '' ) { 
	$exp13=number_format($exp13 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text13</td>
	<td width=50% align=right><font color=#000>$exp13</td>
	</tr>
	";
}


if ($exp_text14 <> '' ) { 
	$exp4=number_format($exp14 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text14</td>
	<td width=50% align=right><font color=#000>$exp14</td>
	</tr>
	";
}

if ($exp_text15 <> '' ) { 
	$exp5=number_format($exp15 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text15</td>
	<td width=50% align=right><font color=#000>$exp15</td>
	</tr>
	";
}

if ($exp_text16 <> '' ) { 
	$exp16=number_format($exp16 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text16</td>
	<td width=50% align=right><font color=#000>$exp16</td>
	</tr>
	";
}

if ($exp_text17 <> '' ) { 
	$exp17=number_format($exp17 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text17</td>
	<td width=50% align=right><font color=#000>$exp17</td>
	</tr>
	";
}

if ($exp_text18 <> '' ) { 
	$exp18=number_format($exp18 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text18</td>
	<td width=50% align=right><font color=#000>$exp18</td>
	</tr>
	";
}

if ($exp_text19 <> '' ) { 
	$exp19=number_format($exp19 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text19</td>
	<td width=50% align=right><font color=#000>$exp19</td>
	</tr>
	";
}

if ($exp_text20 <> '' ) { 
	$exp20=number_format($exp20 , 2 );
	echo " 	
	<tr>
	<td width=50%><font color=#000>$exp_text20</td>
	<td width=50% align=right><font color=#000>$exp20</td>
	</tr>
	";
}

echo"
	<tr>
	<td width=100% colspan=2><hr></td>
	</tr>
	<tr>
	<td width=50%><font color=#000>รวมรายการหัก</td>
	<td width=50% align=right><font color=#000>$sumexp2</td>
	</tr>
	</table>
</td>
</tr>

<tr><td colspan=3>
&nbsp;<br><Br>
</td></tr>

<tr><td colspan=3>
<hr>
</td></tr>

<tr><td colspan=3 align=right><font color=#000><font size=4>
<b>รวมจำนวนทั้งหมด &nbsp;&nbsp;$sumnet2&nbsp;&nbsp; บาท </b>&nbsp;&nbsp;&nbsp;&nbsp;
</td></tr>

<tr><td colspan=3>
<hr>
</td></tr>

<tr valign=top >
<td align=center colspan=3 ><br><font size=2 color=#333>กรุณาตรวจสอบรายการอีกครั้ง หากไม่ถูกต้องกรุณาติดต่อกลุ่มงานการเงินฯ โทร 30975
<br><Br>
</td>
</tr>
</table>


</td></tr>
</table>
<br><Br>

</body>
</html>

";

?>
<?php
$html = ob_get_contents();
$mpdf->WriteHTML($html);
$mpdf->Output();
//$mypdfile = $idno."-".$mm."-".$yy.".pdf";
//$mpdf->Output("pdf/$mypdfile");
ob_end_flush()
?>

<!--ดาวโหลดรายงานในรูปแบบ PDF <a href="MyPDF.pdf">คลิกที่นี้</a>-->