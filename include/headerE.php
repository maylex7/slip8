<?
session_start();
include('db/connectdb.inc');

$userid = $_SESSION["suserid"];
$usernameid=	$_SESSION["susernameid"];
$userlevel=$_SESSION["suserlevel"];
//echo " userid = $userid, $usernameid, $userlevel <br>";

	$sql = " select * from user u  
	LEFT JOIN employee e ON e.empid = u.empid 
	where u.USER_ID='$userid' and u.INVALID_FLAG='0' ";


	$result = mysql_query($sql) ;

	$nums = mysql_num_rows($result);
	//echo "sql = $sql <br> result= $result<br>nums = $nums <Br>";
	$rows=mysql_fetch_array($result);
	$usernameid = $rows["USERNAME_ID"];
	$userlevel = $rows["USERLEVEL_ID"];
	$depart = $rows["DEPART_ID"];
	$empid = $rows["empid"];
	$userlogo = $rows["USER_LOGO"];
	$prename = $rows["prename"];
	$name = $rows["name"];
	$lastname = $rows["lastname"];
	$bankno = $rows["bankno"];
	$position = $rows["position"];
	$bankid = $rows["bankid"];
	$idno = $rows["idno"];


//กำหนดเวลาที่สามารถอยู่ในระบบ
$sessionlifetime = 60; //กำหนดเป็นนาที

if(isset($_SESSION["timeLasetdActive"])){
	$seclogin = (time()-$_SESSION["timeLasetdActive"])/60;
	//หากไม่ได้ Active ในเวลาที่กำหนด
	if($seclogin>$sessionlifetime){
		//goto logout page
		header("location:logout.php");
		exit;
	}else{
		$_SESSION["timeLasetdActive"] = time();
	}
}else{
	$_SESSION["timeLasetdActive"] = time();
}

include('action/classuser.php');
$action = 'active';
active();
//break;

$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$x = pathinfo($url);
$url2 = $x['filename'].".php";
$x = parse_url($url);
$url4=$x['query'];

$url3 = $url2."?".$url4;

//echo "$url3-$url4 ";

$_SESSION["spage"] = $url3;
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
<section id="container">
<!-- **********************************************************************************************************************************************************
TOP BAR CONTENT & NOTIFICATIONS
*********************************************************************************************************************************************************** -->
<!--header start-->
<header class="header black-bg">
<div class="sidebar-toggle-box">
<div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
</div>
<!--logo start-->
<a href="employee.php" class="logo"><b><span>ระบบ SLIP ONLINE</span> สถาบันโรคทรวงอก</b>  <font size=2>version 1.2</font></a>
<!--logo end-->
<div class="nav notify-row" id="top_menu">


</div>
<div class="top-menu">
<ul class="nav pull-right top-menu">
<li><a class="logout" href="logout.php"><i class="fa fa-sign-out"></i> ออกจากระบบ</a></li>
</ul>
</div>
</header>
<!--header end-->
<!-- **********************************************************************************************************************************************************
MAIN SIDEBAR MENU
*********************************************************************************************************************************************************** -->

<!--sidebar start-->
<aside>
<div id="sidebar" class="nav-collapse ">
<!-- sidebar menu start-->
<ul class="sidebar-menu" id="nav-accordion">
<p class="centered"><a href="employee.php"><img src="img/profile/<?php echo "$userlogo";?>" class="img-circle" width="60"></a></p>
<br>
<h4 class="centered" style="color:white;font-size:15px;"><?php echo "<i class=\"fa fa-user-o\"></i>  $prename$name $lastname  <Br><i class=\"fa fa-address-card-o\"></i> $idno<Br><Br>  $position $depart <Br>$bankid  $bankno ";?></h4>
<hr>
<img src="img/bullet_w.png" width="20" height="10" style="padding-left:10px;" /> <a href="#salary" style='color:#21bfd6;'>เงินเดือน</a><br>
<img src="img/bullet_w.png" width="20" height="10" style="padding-left:10px;" /> <a href="#overtime" style='color:#21bfd6;'>รายได้-ค่าตอบแทน</a><br>
<hr>
<center><a href='changpassword.php'>เปลี่ยนรหัสผ่าน</a></center>

<!--
<li class="mt">
<?php
if ($url3 == "employee.php" ) { $inx = "class=\"active\""; }
?>

<a <?php echo " $inx";?> href="employee.php">
<i class="fa fa-dashboard"></i>
<span>Dashboard</span>
</a>
</li>

<li>
<a href="officer1.php">
<i class="fa fa-group"></i>
<span>ข้าราชการ</span>
</a>
</li>

<li>
<a href="officer2.php">
<i class="fa fa-group"></i>
<span>ลูกจ้างประจำ</span>
</a>
</li>

<li>
<a href="officer3.php">
<i class="fa fa-group"></i>
<span>พนักงานราชการ</span>
</a>
</li>

<li>
<a href="officer4.php">
<i class="fa fa-group"></i>
<span>พนักงานกระทรวง</span>
</a>
</li>

<?php
//echo "$url3 <Br>";

if ( ($url3 == "importdata.php?type=1" ) or ($url3 == "importdata.php?type=2" ) or ($url3 == "importdata.php?type=3" ) or ($url3 == "importdata.php?type=4" ) ) { $imp0 = "class=\"active\""; }
?>

<li class="sub-menu">
<a <?php echo " $imp0";?>  href="javascript:;">
<i class="fa fa-desktop"></i>
<span>Import Data</span>
</a>
<ul class="sub">
<?php
if ($url3 == "importdata.php?type=1" ) { $imp1 = "class=\"active\""; }
?>
<li <?php echo " $imp1";?> ><a href="importdata.php?type=1">ข้าราชการ</a></li>
<?php
if ($url3 == "importdata.php?type=2" ) { $imp2 = "class=\"active\""; }
?>
<li <?php echo " $imp2";?>><a href="importdata.php?type=2">ลูกจ้างประจำ</a></li>
<?php
if ($url3 == "importdata.php?type=3" ) { $imp3 = "class=\"active\""; }
?>
<li <?php echo " $imp3";?>><a href="importdata.php?type=3">พนักงานราชการ</a></li>
<?php
if ($url3 == "importdata.php?type=4" ) { $imp4 = "class=\"active\""; }
?>
<li <?php echo " $imp4";?>><a href="importdata.php?type=4">พนักงานกระทรวง</a></li>
</ul>
</li>
-->


<!--

<li class="sub-menu">
<a href="javascript:;">
<i class="fa fa-desktop"></i>
<span>UI Elements</span>
</a>
<ul class="sub">
<li><a href="general.html">General</a></li>
<li><a href="buttons.html">Buttons</a></li>
<li><a href="panels.html">Panels</a></li>
<li><a href="font_awesome.html">Font Awesome</a></li>
</ul>
</li>
<li class="sub-menu">
<a href="javascript:;">
<i class="fa fa-cogs"></i>
<span>Components</span>
</a>
<ul class="sub">
<li><a href="grids.html">Grids</a></li>
<li><a href="calendar.html">Calendar</a></li>
<li><a href="gallery.html">Gallery</a></li>
<li><a href="todo_list.html">Todo List</a></li>
<li><a href="dropzone.html">Dropzone File Upload</a></li>
<li><a href="inline_editor.html">Inline Editor</a></li>
<li><a href="file_upload.html">Multiple File Upload</a></li>
</ul>
</li>
<li class="sub-menu">
<a href="javascript:;">
<i class="fa fa-book"></i>
<span>Extra Pages</span>
</a>
<ul class="sub">
<li><a href="blank.html">Blank Page</a></li>
<li><a href="login.html">Login</a></li>
<li><a href="lock_screen.html">Lock Screen</a></li>
<li><a href="profile.html">Profile</a></li>
<li><a href="invoice.html">Invoice</a></li>
<li><a href="pricing_table.html">Pricing Table</a></li>
<li><a href="faq.html">FAQ</a></li>
<li><a href="404.html">404 Error</a></li>
<li><a href="500.html">500 Error</a></li>
</ul>
</li>
<li class="sub-menu">
<a href="javascript:;">
<i class="fa fa-tasks"></i>
<span>Forms</span>
</a>
<ul class="sub">
<li><a href="form_component.html">Form Components</a></li>
<li><a href="advanced_form_components.html">Advanced Components</a></li>
<li><a href="form_validation.html">Form Validation</a></li>
<li><a href="contactform.html">Contact Form</a></li>
</ul>
</li>
<li class="sub-menu">
<a href="javascript:;">
<i class="fa fa-th"></i>
<span>Data Tables</span>
</a>
<ul class="sub">
<li><a href="basic_table.html">Basic Table</a></li>
<li><a href="responsive_table.html">Responsive Table</a></li>
<li><a href="advanced_table.html">Advanced Table</a></li>
</ul>
</li>
<li>
<a href="inbox.html">
<i class="fa fa-envelope"></i>
<span>Mail </span>
<span class="label label-theme pull-right mail-info">2</span>
</a>
</li>
<li class="sub-menu">
<a href="javascript:;">
<i class=" fa fa-bar-chart-o"></i>
<span>Charts</span>
</a>
<ul class="sub">
<li><a href="morris.html">Morris</a></li>
<li><a href="chartjs.html">Chartjs</a></li>
<li><a href="flot_chart.html">Flot Charts</a></li>
<li><a href="xchart.html">xChart</a></li>
</ul>
</li>
<li class="sub-menu">
<a href="javascript:;">
<i class="fa fa-comments-o"></i>
<span>Chat Room</span>
</a>
<ul class="sub">
<li><a href="lobby.html">Lobby</a></li>
<li><a href="chat_room.html"> Chat Room</a></li>
</ul>
</li>

<li>
<a href="google_maps.html">
<i class="fa fa-map-marker"></i>
<span>Google Maps </span>
</a>
</li>

</ul>
-->
<!-- sidebar menu end-->
</div>
</aside>
<!--sidebar end-->




<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
<section class="wrapper">
