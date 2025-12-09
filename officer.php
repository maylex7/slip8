<?php 
$action = $_REQUEST["action"];
$type = $_REQUEST["type"];
$searchq = $_REQUEST["searchq"];
//echo " type = $type<br>";

switch ($type) {
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
case "5":
	$typename = 'ลูกจ้างรายคาบ';
    break;
case "6":
	$typename = 'ลูกจ้างชั่วคราว';
    break;
case "99":
	$typename = 'ยังไม่ระบุ';
    break;
}

include('include/header.php');
require_once("include/pagination_function.php");
$form = $_REQUEST["form"];
$sortby = $_REQUEST["sort"];


//echo "idno = $idno , emp = $empid <Br>";
/*
	if ($type == '1' ) {
		$sql = "select *from employee where emptypeid = '$type' and invalid_flag='0'   ";
	}

	else if ($type == '2' ) {
		$sql = "select *from employee where emptypeid = '$type' and invalid_flag='0' ";
	}

	else if ($type == '3' ) {
		$sql = "select *from employee where emptypeid = '$type' and invalid_flag='0'   ";
	}

	else if ($type == '4' ) {
		$sql = "select *from employee where emptypeid = '$type' and invalid_flag='0'   ";
	}

	else if ($type == '5' ) {
		$sql = "select *from employee where emptypeid = '$type' and invalid_flag='0'   ";
	}*/
if ($type == '99') {
	$sql = "select *from employee where emptypeid = '0' and invalid_flag='0'   ";
}
else {
$sql = "select *from employee where emptypeid = '$type' and invalid_flag='0'   ";
}

if ($searchq <> '') {
	$sql .= " and (name like '%$searchq%' or lastname like '%$searchq%'  ) ";
}


$result = mysql_query($sql);
$numm = mysql_num_rows($result);
$Num_Rows = $numm;

//echo "sql = $sql<br> result = $result<Br>";
$Per_Page= 10;

?>
<!-- /col-md-12 -->
<div class="col-md-12 mt">
<div class="content-panel">
<table class="table table-hover">
<form   enctype="multipart/form-data" action="" method="post">
<h4><i class="fa fa-angle-right"></i> รายชื่อเจ้าหน้าที่ <?php echo "<u><strong>$typename</strong></u> จำนวน <u>$numm</u> คน";?>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input size="30" type="text"  name='searchq' placeholder="ใส่ชื่อ หรือนามสกุล" style="margin-right:0px;">
<button class="btn btn-theme" type="submit">ค้นหา</button><Br>
<?php
if ($searchq <> '') { ?>
ค้นหา : <u><?php echo "$searchq";?></u>
<? } ?>
</h4>
<hr>
<thead>
<tr>
<th>#</th>
<th>ชื่อ นามสกุล</th>
<!--<th>ตำแหน่ง</th>-->
<th>แผนก</th>
<th><!--ข้อมูล--></th>
</tr>
</thead>

<tbody>
<?php

if ($numm == '0') {
?>
<tr class="spacer" ></tr>
<tr class="tr-shadow">
<td   style="width:100%" colspan=5>
<center>
<?php echo "Lno_data";?>
</td>
</tr>

<?php
}

/**************************** Have Data **************************/
else {

/**** First Section Page ****/
$Page = $_GET["Page"];
if(!$_GET["Page"])
{
	$Page=1;
}

$Prev_Page = $Page-1;
$Next_Page = $Page+1;

$Page_Start = (($Per_Page*$Page)-$Per_Page);
if($Num_Rows<=$Per_Page)
{
	$Num_Pages =1;
}
else if(($Num_Rows % $Per_Page)==0)
{
	$Num_Pages =($Num_Rows/$Per_Page) ;
}
else
{
	$Num_Pages =($Num_Rows/$Per_Page)+1;
	$Num_Pages = (int)$Num_Pages;
}

//echo "Num_Pages = $Num_Pages <br>";
/**** Second SQL ****/
$sql .=" order by name,lastname  LIMIT $Page_Start , $Per_Page";

$result_s = mysql_query($sql);
//echo "sql1 = $sql <br>";

$ii=$Page_Start+1;

while ($row = mysql_fetch_array($result_s)) {

$empid= $row["empid"];
$emptypeid= $row["emptypeid"];
$prename= $row["prename"];
$name= $row["name"];
$lastname= $row["lastname"];
$bankno= $row["bankno"];
$idno= $row["idno"];
$position= $row["position"];
$department= $row["department"];
$password= $row["password"];
$bankid= $row["bankid"];
$mobile= $row["mobile"];
$note= $row["note"];
$passwordchangedate= $row["passwordchangedate"];
$passwordchange= $row["passwordchange"];
$invalid_flag= $row["invalid_flag"];
$create_user= $row["create_user"];
$create_date= $row["create_date"];
$create_time= $row["create_time"];
$update_user= $row["update_user"];
$update_date= $row["update_date"];
$update_time= $row["update_time"];

/*echo "datepay  -$datepay  <Br>";
$yy = substr($datepay, 0 ,4);
$mm=substr($datepay, 5 ,2);
$dd = substr($datepay, 8 ,2);
//$datepay2 = $dd ."/".$mm."/".$yy;
$datepay2 = $dd.'/'.$mm.'/'.$yy;
*/

switch ($mm) {

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
<td>&nbsp; $prename$name $lastname</td>
<!--<td>&nbsp; $position</td>-->
<td>&nbsp; $department</td>

<td><a href='employee.php?empid=$empid'><i class=\"fa fa-globe fa-1x\" style=\"color:dodgerblue\" ></i>  ดู </a></td>
";

if ($userlevel == '3') {
echo "
<td><a href='editemployee.php?empid=$empid&Page=$Page&type=$type&searchq=$searchq' > <i class=\"fa fa-edit\" style=\"color:dodgerblue\" ></i>  แก้ไข </a></td>

<td>
<a href='resetpassword.php?empid=$empid&Page=$Page&type=$type&searchq=$searchq' 
onclick=\"return confirm('คุณรีเซ็ตรหัสผ่านใช่ไหม ? ')\"> <i class=\"fa fa-unlock\" style=\"color:dodgerblue\" ></i> รีเซ็ตรหัสผ่าน </a>
</td>
<td>
<a href='action/deleteemployee.php?empid=$empid&Page=$Page&type=$type&searchq=$searchq' 
onclick=\"return confirm('คุณต้องการลบใช่ไหม ? ')\"> <i class=\"fa fa-trash\" style=\"color:dodgerblue\" ></i>  ลบ </a>

</td>
";
}

echo " </tr>";
$ii++;
}

?>

<?php } //havedata
?>

</tbody>
</table>

</div>
</div>
</div>
<!-- /col-md-12 -->
</div>


<div class="span6">
<div class="dataTables_paginate paging_bootstrap pagination">
<ul>
    
<?

if($Page >1 ) {
echo "<li><a href='$_SERVER[SCRIPT_NAME]?Page=1&type=$type&searchq=$searchq'><i class=\"fa fa-step-backward fa-1x\" style=\"color:#848282\" ></i> หน้าแรก</a><li>";
}

else { echo "<li></i>"; }

if($Prev_Page)
{
	echo "<li ><a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page&type=$type&searchq=$searchq'><i class=\"fa fa-backward fa-1x\" style=\"color:#848282\" ></i>  หน้าก่อนนี้</a><li>";
}

//style=\"background-color: #c8faf6;\"

for($i=1; $i<=$Num_Pages; $i++){
	$Page1 = $Page-2;
	$Page2 = $Page+2;
	if($i != $Page && $i >= $Page1 && $i <= $Page2)
	{
		echo "<li ><a href='$_SERVER[SCRIPT_NAME]?Page=$i&isearch=$isearch&type=$type&searchq=$searchq'>$i</a><li>";
	}
	elseif($i==$Page)
	{
	echo "<span  style=\"	text-decoration: none;
	display: inline-block;
	padding: 2px 8px;
	margin: 1px;
	color: #fff;
	border: 1px solid #057971;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #A65B1A), color-stop(1, #7F4614) )
	background:-moz-linear-gradient( center top, #A65B1A 5%, #7F4614 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#A65B1A', endColorstr='#7F4614');
	background-color: #4ecdc4;
	font-weight: bolder;\">$i</span>";
	}$jj = $Page+1;

	}

if ($Num_Pages <> $Page)  {
echo "<li><a href ='$_SERVER[SCRIPT_NAME]?Page=$jj&type=$type&searchq=$searchq'>หน้าถัดไป <i class=\"fa fa-forward fa-1x\" style=\"color:#848282\" ></i></a><li>";
}

if($Page!=$Num_Pages) {
echo "<li><a href ='$_SERVER[SCRIPT_NAME]?Page=$Num_Pages&isearch=$isearch&type=$type&searchq=$searchq'>หน้าสุดท้าย <i class=\"fa fa-step-forward fa-1x\" style=\"color:#848282\" ></i></a><li>";
}


?>
    </ul>
</div></div>

<!--
<div class="span6">
<div class="dataTables_paginate paging_bootstrap pagination">
<ul><li class="prev disabled">
<a href="#">← Previous</a></li>
<li class="active"><a href="#">1</a></li>
<li><a href="#">2</a></li>
<li><a href="#">3</a></li>
<li><a href="#">4</a></li><li><a href="#">5</a></li>
<li class="next"><a href="#">Next → </a></li>
</ul>
</div>
</div>

<br style="clear:both;" />
<br style="clear:both;" />-->
<?php
/*echo "<br><br>";
page_navi($total,(isset($_GET['page']))?$_GET['page']:1,$e_page);*/
?>

<!-- row -->
<?php
include('include/footer.php');
?>