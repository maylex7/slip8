<?php 
include('include/header.php');
$action = $_REQUEST["action"]; 
$mm = $_REQUEST["mm"]; 
$yy = $_REQUEST["yy"]; 



switch ($action) {
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

case "11":
	$typename = 'รายได้ - ค่าตอบแทน :  เงินงบประมาณ';
    break;
case "12":
	$typename = 'รายได้ - ค่าตอบแทน :  เงินบำรุง';
    break;
}


?>
<br>
<!--  ALERTS EXAMPLES -->
<div class="showback">
<h4><i class="fa fa-angle-right"></i> นำเข้าข้อมูล</h4>
<div class="alert alert-success">นำเข้าข้อมูล<b> <?php echo "$typename";?></b>  ประจำ <?php echo "$mm/$yy";?> เรียบร้อยแล้ว</div>
</div>
 
<?
include('include/footer.php');
?>