<meta charset="utf-8">
<meta http-equiv="Content-Language" content="th">
<?php 

session_start();
include('db/connectdb.inc');

$userid = $_SESSION["suserid"];
$usernameid=	$_SESSION["susernameid"];
$userlevel=$_SESSION["suserlevel"];
$yearin= $_GET["yearin"];
$yearin2= $_GET["yearin2"];
//echo " userid = $userid, $usernameid, $userlevel <br>";

if (($userlevel == '2') or ($userlevel == '3')) {
	$empid = $_REQUEST["empid"];
	include('include/header.php');}

else {	include('include/headerE.php');}


$sqle = "select *from employee where empid = '$empid' and invalid_flag='0'  ";
$resulte = mysql_query($sqle);

//echo "sql = $sql<br> result = $result<Br>";
$rowe = mysql_fetch_array($resulte);
	$prename = $rowe["prename"];
	$name = $rowe["name"];
	$lastname = $rowe["lastname"];
	$department = $rowe["department"];
	$position = $rowe["position"];
?>

<!-- /col-md-12 -->
<div class="col-md-12 mt">
<div class="content-panel"><h4><b><?php echo "$prename$name $lastname ";?></b>

<?php 

if ($position <> '' ) {echo " ตำแหน่ง : $position&nbsp;&nbsp;"; }
if ($department <> '' ) { echo " แผนก : $department";}

?> 

</h4>


<?php
//echo "userlevel = $userlevel <Br>";

$ii=1;
//echo "idno = $idno , emp = $empid <Br>";
$sqly = "select distinct yy from slip where empid = '$empid' and invalid_flag='0'  order by yy desc ";
$resulty = mysql_query($sqly);
$numsy = mysql_num_rows($resulty);
//echo "sqly = $sqly<br> resulty = $resulty<Br>numsy = $numsy<Br>";
$u=1;
while ($rowy = mysql_fetch_array($resulty)) {

$yearindex[$u] = $rowy["yy"];

//echo "yearindex[$u] = $yearindex[$u]<br>";
$u=$u+1;
}

//echo "yearin=$yearin<br>";
if ($yearin == '') {$yearin=$yearindex[1];}


if (($userlevel == '3') or ($userlevel == '1')  ) {



$sql = "select *from slip where empid = '$empid' and invalid_flag='0' and yy='$yearin' order by datepay desc ";
$result = mysql_query($sql);
$nums = mysql_num_rows($result);
//echo "sql = $sql<br> result = $result<Br>nums = $nums<Br>";


if ($nums > '0' ) {
?>


<table class="table table-hover">
<h4  id="salary"><i class="fa fa-angle-right"></i> สลิปเงินเดือน : </h4>

<?php
echo "<br>&nbsp;&nbsp;ประจำปี&nbsp;&nbsp;";
for ($x = 1; $x < $u; $x++) {
echo "<a href='employee.php?empid=$empid&yearin=$yearindex[$x]'>[$yearindex[$x]]</a> &nbsp;";
}
echo "<br>";
?>

<hr>
<thead>
<tr>
<th>#</th>
<th>ประจำเดือน</th>
<th>วันที่โอนเงินเข้าบัญชี</th>
<th>ออนไลน์</th>
<!--<th>File PDF</th>-->
</tr>
</thead>

<tbody>
<?php

while ($row = mysql_fetch_array($result)) {
$id = $row["id"];
$datepay = $row["datepay"];
$idno = $row["idno"];
$mm5 = $row["mm"];
$yy5 = $row["yy"];
//echo "datepay  -$datepay  <Br>";

$yy = substr($datepay, 0 ,4);
$mm=substr($datepay, 5 ,2);
$dd = substr($datepay, 8 ,2);
$yy2 = $yy +543;

//$datepay2 = $dd ."/".$mm."/".$yy;
$datepay2 = $dd.'/'.$mm.'/'.$yy2;


$enc = base64_encode($id);


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
<tr>
<td>$ii</td>
<td><i class=\"fa fa-calendar-o fa-1x\" style=\"color:green\" ></i>  &nbsp;$monthname  $yy5 </td>
<td><i class=\"fa fa-calendar fa-1x\" style=\"color:green\" ></i>  &nbsp;$datepay2</td>
<td><i class=\"fa fa-globe fa-1x\" style=\"color:dodgerblue\" ></i> <a href='viewslip.php?id=$enc' target='_blank'>Slip</a></td>
<!--<td><i class=\"fa fa-file-pdf-o fa-1x\"  style=\"color:green\" ></i> <a href='viewslippdf.php?id=$enc' target='_blank'>PDF</a></td>-->
</tr>
";
$ii++;
}

?>



</tbody>
</table>
</div>
</div>
<!-- /col-md-12 -->
</div><br><br><Br>

<?php
} //have data

}//user admin
?>



<!----------------------------รายได้ - ค่าตอบแทน -------------------------------------->
<?php


//echo "idno = $idno , emp = $empid <Br>";
$sqly = "select distinct yy from slipot where empid = '$empid' and invalid_flag='0'  order by yy desc ";
$resulty = mysql_query($sqly);
$numsy = mysql_num_rows($resulty);
//echo "sqly = $sqly<br> resulty = $resulty<Br>numsy = $numsy<Br>";
$u=1;
while ($rowy = mysql_fetch_array($resulty)) {

$yearindex[$u] = $rowy["yy"];

//echo "yearindex[$u] = $yearindex[$u]<br>";
$u=$u+1;
}

//echo "yearin=$yearin<br>";
if ($yearin2 == '') {$yearin2=$yearindex[1];}


$ii=1;
//echo "idno = $idno , emp = $empid <Br>";
$sql2 = "select *from slipot where empid = '$empid' and invalid_flag='0'  and yy='$yearin2'  order by datepay desc ";
$result2 = mysql_query($sql2);
//echo "sql = $sql2<br> result = $result2<Br>";
$nums2 = mysql_num_rows($result2);
//echo "sql = $sql<br> result = $result<Br>";

if ($nums2 > '0' ) {
?>
<div class="col-md-12 mt">
<div class="content-panel">
<table class="table table-hover">
<h4  id="overtime"><i class="fa fa-angle-right"></i> รายได้ - ค่าตอบแทน : </h4>
<?php
echo "<br>&nbsp;&nbsp;ประจำปี&nbsp;&nbsp;";
for ($x = 1; $x < $u; $x++) {
echo "<a href='employee.php?empid=$empid&yearin2=$yearindex[$x]'>[$yearindex[$x]]</a> &nbsp;";
}
echo "<br>";
?>
<hr>
<thead>
<tr>
<th>#</th>
<th>ประจำเดือน</th>
<th>งบจ่าย</th>
<th>วันที่โอนเงินเข้าบัญชี</th>
<th>ออนไลน์</th>
<!--<th>File PDF</th>-->
</tr>
</thead>

<tbody>
<?php


while ($row2 = mysql_fetch_array($result2)) {
$id = $row2["id"];
$datepay = $row2["datepay"];
$idno = $row2["idno"];
$mm5 = $row2["mm"];
$yy5 = $row2["yy"];
$budget = $row2["budget"];
	if ($budget == '11') {$budgetname = 'เงินงบประมาณ';}
	else if ($budget == '12') {$budgetname = 'เงินบำรุง';}

//echo "datepay  -$datepay  <Br>";

$yy = substr($datepay, 0 ,4);
$mm=substr($datepay, 5 ,2);
$dd = substr($datepay, 8 ,2);
$yy2 = $yy +543;

//$datepay2 = $dd ."/".$mm."/".$yy;
$datepay2 = $dd.'/'.$mm.'/'.$yy2;

$enc = base64_encode($id);

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
<tr>
<td>$ii</td>
<td><i class=\"fa fa-calendar-o fa-1x\" style=\"color:green\" ></i>  &nbsp;$monthname  $yy5  </td>
<td>$budgetname </td>
<td><i class=\"fa fa-calendar fa-1x\" style=\"color:green\" ></i>  &nbsp;$datepay2</td>
<td><i class=\"fa fa-globe fa-1x\" style=\"color:dodgerblue\" ></i> <a href='viewslipot.php?id=$enc' target='_blank'>Slip</a></td>
<!--<td><i class=\"fa fa-file-pdf-o fa-1x\"  style=\"color:green\" ></i> <a href='viewslippdf.php?id=$enc' target='_blank'>PDF</a></td>-->
</tr>
";
$ii++;
}

?>



</tbody>
</table>
</div>
</div>
<!-- /col-md-12 -->
</div><br><br><Br>
<?php
} //have data
?>

<!-- row -->
<?php
if ($userlevel == '3') {
echo '
<center><button onclick="goBack()" class="btn btn-theme"  style="margin-top:20px;">กลับไป</button></center>

<script>
function goBack() {
  window.history.back();
}
</script>
';
	
	}


?>
<?php
include('include/footerE.php');
?>
