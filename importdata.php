<?php 
include('include/header.php');

$type = $_REQUEST["type"];

//echo "userid = $userid <Br>";

//-----------------------------------------------------------------------------------------------------------------//
if ($type == '1' ) {
?>
<h3><i class="fa fa-angle-right"></i>&nbsp;&nbsp;ข้าราชการ</h3>

<div class="row">


<!--เงินเดือน-->
<h4 style="margin-left:35px;"><i class="fa fa-users"></i>&nbsp;&nbsp;เงินเดือน</h4>
<div class="col-lg-12">
<div class="form-panel">

<form class="form-horizontal style-form"  enctype="multipart/form-data" action="action/classimport.php" method="post">
<input type='hidden' name='action' value='1'>

<div class="form-group">
<label class="control-label col-md-4"><b>เลือกไฟล์</b><br>
* กรุณาเลือกไฟล์ Excel <br>
</label>
<div class="col-md-4">

<script type="text/javascript" language="javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      return false;
    }
    else return true;
}
</script>

<input type="file" id="file" name="fileupload" onchange="checkfile(this);" />
</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">ประจำเดือน</label>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="mm5">
		<option value='1'>มกราคม</option>
		<option value='2'>กุมภาพันธ์</option>
		<option value='3'>มีนาคม</option>
		<option value='4'>เมษายน</option>
		<option value='5'>พฤษภาคม</option>
		<option value='6'>มิถุนายน</option>
		<option value='7'>กรกฎาคม</option>
		<option value='8'>สิงหาคม</option>
		<option value='9'>กันยายน</option>
		<option value='10'>ตุลาคม</option>
		<option value='11'>พฤศจิกายน</option>
		<option value='12'>ธันวาคม</option>
</select>
<Br>

<?php
$yearnow = date("Y")+542;
$yearnow2 = $yearnow+1;
//echo " yearnow = $yearnow<Br>";
?>

<select class="form-control" name="yy5">
<?php
for ($xx = $yearnow; $xx <= $yearnow2; $xx++) {
	if ($xx == $yearnow2) {$s2 = "selected ";}
	echo "<option value='$xx' $s2>$xx</option>";
	  }
?>
</select>

</div>
</div>
<div class="form-group">
<label class="control-label col-md-4">วันที่โอนเงินเข้า </label>
<div class="col-md-3 col-xs-8">
<!--<input class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"  name='filedate'>-->
<input class="form-control form-control-inline input-medium" size="16" type="text"  name='filedate'>

</div>
</div>

<div class="form-group">
<center>
<button class="btn btn-theme" type="submit">ตกลง</button>
</center>
</div>

</form>
</div>
</div>
<!-- Main Close -->
</div>
<!-- /row -->
<Br><BR>


<?php
} //type 1



//-----------------------------------------------------------------------------------------------------------------//
if ($type == '2' ) {
?>
<h3><i class="fa fa-angle-right"></i>&nbsp;&nbsp;ลูกจ้างประจำ</h3>
<div class="row">

<!--ADVANCED FILE INPUT-->

<div class="col-lg-12">
<div class="form-panel">

<form class="form-horizontal style-form"  enctype="multipart/form-data" action="action/classimport.php" method="post">
<input type='hidden' name='action' value='2'>

<div class="form-group">
<label class="control-label col-md-4"><b>เลือกไฟล์</b><br>
* กรุณาเลือกไฟล์ Excel <br>
</label>
<div class="col-md-4">

<script type="text/javascript" language="javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      return false;
    }
    else return true;
}
</script>

<input type="file" id="file" name="fileupload" onchange="checkfile(this);" />
</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">ประจำเดือน</label>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="mm5">
		<option value='1'>มกราคม</option>
		<option value='2'>กุมภาพันธ์</option>
		<option value='3'>มีนาคม</option>
		<option value='4'>เมษายน</option>
		<option value='5'>พฤษภาคม</option>
		<option value='6'>มิถุนายน</option>
		<option value='7'>กรกฎาคม</option>
		<option value='8'>สิงหาคม</option>
		<option value='9'>กันยายน</option>
		<option value='10'>ตุลาคม</option>
		<option value='11'>พฤศจิกายน</option>
		<option value='12'>ธันวาคม</option>
</select>
<Br>

<?php
$yearnow = date("Y")+542;
$yearnow2 = $yearnow+1;
//echo " yearnow = $yearnow<Br>";
?>

<select class="form-control" name="yy5">
<?php
for ($xx = $yearnow; $xx <= $yearnow2; $xx++) {
	if ($xx == $yearnow2) {$s2 = "selected ";}
	echo "<option value='$xx' $s2>$xx</option>";
	  }
?>
</select>

</div>
</div>
<div class="form-group">
<label class="control-label col-md-4">วันที่โอนเงินเข้า </label>
<div class="col-md-3 col-xs-8">
<!--<input class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"  name='filedate'>-->
<input class="form-control form-control-inline input-medium" size="16" type="text"  name='filedate'>

</div>
</div>

<div class="form-group">
<center>
<button class="btn btn-theme" type="submit">ตกลง</button>
</center>
</div>

</div>
</div>
<!-- Main Close -->
</div>
<!-- /row -->



<?php
} //type 2

//-----------------------------------------------------------------------------------------------------------------//
if ($type == '3' ) {
?>
<h3><i class="fa fa-angle-right"></i>&nbsp;&nbsp;พนักงานราชการ</h3>
<div class="row">

<!--ADVANCED FILE INPUT-->

<div class="col-lg-12">
<div class="form-panel">

<form class="form-horizontal style-form"  enctype="multipart/form-data" action="action/classimport.php" method="post">
<input type='hidden' name='action' value='3'>

<div class="form-group">
<label class="control-label col-md-4"><b>เลือกไฟล์</b><br>
* กรุณาเลือกไฟล์ Excel <br>
</label>
<div class="col-md-4">

<script type="text/javascript" language="javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      return false;
    }
    else return true;
}
</script>

<input type="file" id="file" name="fileupload" onchange="checkfile(this);" />
</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">ประจำเดือน</label>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="mm5">
		<option value='1'>มกราคม</option>
		<option value='2'>กุมภาพันธ์</option>
		<option value='3'>มีนาคม</option>
		<option value='4'>เมษายน</option>
		<option value='5'>พฤษภาคม</option>
		<option value='6'>มิถุนายน</option>
		<option value='7'>กรกฎาคม</option>
		<option value='8'>สิงหาคม</option>
		<option value='9'>กันยายน</option>
		<option value='10'>ตุลาคม</option>
		<option value='11'>พฤศจิกายน</option>
		<option value='12'>ธันวาคม</option>
</select>
<Br>

<?php
$yearnow = date("Y")+542;
$yearnow2 = $yearnow+1;
//echo " yearnow = $yearnow<Br>";
?>

<select class="form-control" name="yy5">
<?php
for ($xx = $yearnow; $xx <= $yearnow2; $xx++) {
	if ($xx == $yearnow2) {$s2 = "selected ";}
	echo "<option value='$xx' $s2>$xx</option>";
	  }
?>
</select>

</div>
</div>
<div class="form-group">
<label class="control-label col-md-4">วันที่โอนเงินเข้า </label>
<div class="col-md-3 col-xs-8">
<!--<input class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"  name='filedate'>-->
<input class="form-control form-control-inline input-medium" size="16" type="text"  name='filedate'>

</div>
</div>

<div class="form-group">
<center>
<button class="btn btn-theme" type="submit">ตกลง</button>
</center>
</div>

</div>
</div>
<!-- Main Close -->
</div>
<!-- /row -->


<?php
} //type 3

//-----------------------------------------------------------------------------------------------------------------//
if ($type == '4' ) {
?>
<h3><i class="fa fa-angle-right"></i>&nbsp;&nbsp;พนักงานกระทรวง</h3>
<div class="row">

<!--ADVANCED FILE INPUT-->

<div class="col-lg-12">
<div class="form-panel">

<form class="form-horizontal style-form"  enctype="multipart/form-data" action="action/classimport.php" method="post">
<input type='hidden' name='action' value='4'>

<div class="form-group">
<label class="control-label col-md-4"><b>เลือกไฟล์</b><br>
* กรุณาเลือกไฟล์ Excel <br>
</label>
<div class="col-md-4">

<script type="text/javascript" language="javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      return false;
    }
    else return true;
}
</script>

<input type="file" id="file" name="fileupload" onchange="checkfile(this);" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-4">ประจำเดือน</label>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="mm5">
		<option value='1'>มกราคม</option>
		<option value='2'>กุมภาพันธ์</option>
		<option value='3'>มีนาคม</option>
		<option value='4'>เมษายน</option>
		<option value='5'>พฤษภาคม</option>
		<option value='6'>มิถุนายน</option>
		<option value='7'>กรกฎาคม</option>
		<option value='8'>สิงหาคม</option>
		<option value='9'>กันยายน</option>
		<option value='10'>ตุลาคม</option>
		<option value='11'>พฤศจิกายน</option>
		<option value='12'>ธันวาคม</option>
</select>
<Br>

<?php
$yearnow = date("Y")+542;
$yearnow2 = $yearnow+1;
//echo " yearnow = $yearnow<Br>";
?>

<select class="form-control" name="yy5">
<?php
for ($xx = $yearnow; $xx <= $yearnow2; $xx++) {
	if ($xx == $yearnow2) {$s2 = "selected ";}
	echo "<option value='$xx' $s2>$xx</option>";
	  }
?>
</select>

</div>
</div>
<div class="form-group">
<label class="control-label col-md-4">วันที่โอนเงินเข้า </label>
<div class="col-md-3 col-xs-8">
<!--<input class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"  name='filedate'>-->
<input class="form-control form-control-inline input-medium" size="16" type="text"  name='filedate'>

</div>
</div>

<div class="form-group">
<center>
<button class="btn btn-theme" type="submit">ตกลง</button>
</center>
</div>

</div>
</div>
<!-- Main Close -->
</div>
<!-- /row -->

<?php
} //type 4


//-----------------------------------------------------------------------------------------------------------------//
if ($type == '5' ) {
?>
<h3><i class="fa fa-angle-right"></i>&nbsp;&nbsp;ลูกจ้างรายคาบ</h3>
<div class="row">

<!--ADVANCED FILE INPUT-->

<div class="col-lg-12">
<div class="form-panel">

<form class="form-horizontal style-form"  enctype="multipart/form-data" action="action/classimport.php" method="post">
<input type='hidden' name='action' value='5'>

<div class="form-group">
<label class="control-label col-md-4"><b>เลือกไฟล์</b><br>
* กรุณาเลือกไฟล์ Excel <br>
</label>
<div class="col-md-4">

<script type="text/javascript" language="javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      return false;
    }
    else return true;
}
</script>

<input type="file" id="file" name="fileupload" onchange="checkfile(this);" />
</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">ประจำเดือน</label>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="mm5">
		<option value='1'>มกราคม</option>
		<option value='2'>กุมภาพันธ์</option>
		<option value='3'>มีนาคม</option>
		<option value='4'>เมษายน</option>
		<option value='5'>พฤษภาคม</option>
		<option value='6'>มิถุนายน</option>
		<option value='7'>กรกฎาคม</option>
		<option value='8'>สิงหาคม</option>
		<option value='9'>กันยายน</option>
		<option value='10'>ตุลาคม</option>
		<option value='11'>พฤศจิกายน</option>
		<option value='12'>ธันวาคม</option>
</select>
<Br>

<?php
$yearnow = date("Y")+542;
$yearnow2 = $yearnow+1;
//echo " yearnow = $yearnow<Br>";
?>

<select class="form-control" name="yy5">
<?php
for ($xx = $yearnow; $xx <= $yearnow2; $xx++) {
	if ($xx == $yearnow2) {$s2 = "selected ";}
	echo "<option value='$xx' $s2>$xx</option>";
	  }
?>
</select>

</div>
</div>


<div class="form-group">
<label class="control-label col-md-4">วันที่โอนเงินเข้า </label>
<div class="col-md-3 col-xs-8">
<!--<input class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"  name='filedate'>-->
<input class="form-control form-control-inline input-medium" size="16" type="text"  name='filedate'>

</div>
</div>

<div class="form-group">
<center>
<button class="btn btn-theme" type="submit">ตกลง</button>
</center>
</div>

</div>
</div>
<!-- Main Close -->
</div>
<!-- /row -->

<?php
} //type 5

//-----------------------------------------------------------------------------------------------------------------//
if ($type == '6' ) {
?>
<h3><i class="fa fa-angle-right"></i>&nbsp;&nbsp;ลูกจ้างชั่วคราว</h3>
<div class="row">

<!--ADVANCED FILE INPUT-->

<div class="col-lg-12">
<div class="form-panel">

<form class="form-horizontal style-form"  enctype="multipart/form-data" action="action/classimport.php" method="post">
<input type='hidden' name='action' value='6'>

<div class="form-group">
<label class="control-label col-md-4"><b>เลือกไฟล์</b><br>
* กรุณาเลือกไฟล์ Excel <br>
</label>
<div class="col-md-4">

<script type="text/javascript" language="javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      return false;
    }
    else return true;
}
</script>

<input type="file" id="file" name="fileupload" onchange="checkfile(this);" />
</div>
</div>
<div class="form-group">
<label class="control-label col-md-4">ประจำเดือน</label>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="mm5">
		<option value='1'>มกราคม</option>
		<option value='2'>กุมภาพันธ์</option>
		<option value='3'>มีนาคม</option>
		<option value='4'>เมษายน</option>
		<option value='5'>พฤษภาคม</option>
		<option value='6'>มิถุนายน</option>
		<option value='7'>กรกฎาคม</option>
		<option value='8'>สิงหาคม</option>
		<option value='9'>กันยายน</option>
		<option value='10'>ตุลาคม</option>
		<option value='11'>พฤศจิกายน</option>
		<option value='12'>ธันวาคม</option>
</select>
<Br>

<?php
$yearnow = date("Y")+542;
$yearnow2 = $yearnow+1;
//echo " yearnow = $yearnow<Br>";
?>

<select class="form-control" name="yy5">
<?php
for ($xx = $yearnow; $xx <= $yearnow2; $xx++) {
	if ($xx == $yearnow2) {$s2 = "selected ";}
	echo "<option value='$xx' $s2>$xx</option>";
	  }
?>
</select>


</div>
</div>
<div class="form-group">
<label class="control-label col-md-4">วันที่โอนเงินเข้า </label>
<div class="col-md-3 col-xs-8">
<!--<input class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"  name='filedate'>-->
<input class="form-control form-control-inline input-medium" size="16" type="text"  name='filedate'>

</div>
</div>

<div class="form-group">
<center>
<button class="btn btn-theme" type="submit">ตกลง</button>
</center>
</div>

</div>
</div>
<!-- Main Close -->
</div>
<!-- /row -->

<?php
} //type 6




//---------------------------------------OT เงินงบประมาณ--------------------------------------------------------------------------//
else if ($type == '11' ) {
?>

<h3><i class="fa fa-angle-right"></i>&nbsp;&nbsp;รายได้ - ค่าตอบแทน :  เงินงบประมาณ</h3>
<!--รายได้ - ค่าตอบแทน-->
<div class="row">
<h4 style="margin-left:35px;"><i class="fa fa-users"></i>&nbsp;&nbsp;รายได้ - ค่าตอบแทน</h4>
<div class="col-lg-12">
<div class="form-panel">

<form class="form-horizontal style-form"  enctype="multipart/form-data" action="action/classimportot.php" method="post">
<input type='hidden' name='action' value='11'>

<div class="form-group">
<label class="control-label col-md-4"><b>เลือกไฟล์</b><br>
* กรุณาเลือกไฟล์ Excel <br>
</label>
<div class="col-md-4">

<script type="text/javascript" language="javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      return false;
    }
    else return true;
}
</script>

<input type="file" id="file" name="fileupload" onchange="checkfile(this);" />
</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">ประจำเดือน</label>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="mm5">
		<option value='1'>มกราคม</option>
		<option value='2'>กุมภาพันธ์</option>
		<option value='3'>มีนาคม</option>
		<option value='4'>เมษายน</option>
		<option value='5'>พฤษภาคม</option>
		<option value='6'>มิถุนายน</option>
		<option value='7'>กรกฎาคม</option>
		<option value='8'>สิงหาคม</option>
		<option value='9'>กันยายน</option>
		<option value='10'>ตุลาคม</option>
		<option value='11'>พฤศจิกายน</option>
		<option value='12'>ธันวาคม</option>
</select>
<Br>

<?php
$yearnow = date("Y")+542;
$yearnow2 = $yearnow+1;
//echo " yearnow = $yearnow<Br>";
?>

<select class="form-control" name="yy5">
<?php
for ($xx = $yearnow; $xx <= $yearnow2; $xx++) {
	if ($xx == $yearnow2) {$s2 = "selected ";}
	echo "<option value='$xx' $s2>$xx</option>";
	  }
?>
</select>

</div>
</div>
<div class="form-group">
<label class="control-label col-md-4">วันที่โอนเงินเข้า </label>
<div class="col-md-3 col-xs-8">
<!--<input class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"  name='filedate'>-->
<input class="form-control form-control-inline input-medium" size="16" type="text"  name='filedate'>

</div>
</div>



<div class="form-group">
<center>
<button class="btn btn-theme" type="submit">ตกลง</button>
</center>
</div>

</form>
</div>
</div>
<!-- Main Close -->
</div>
<!-- /row -->

<?php
} //type Ot เงินงบประมาณ

//---------------------------------------OT เงินบำรุง--------------------------------------------------------------------------//
else if ($type == '12' ) {
?>

<h3><i class="fa fa-angle-right"></i>&nbsp;&nbsp;รายได้ - ค่าตอบแทน :  เงินบำรุง</h3>
<!--รายได้ - ค่าตอบแทน-->
<div class="row">
<h4 style="margin-left:35px;"><i class="fa fa-users"></i>&nbsp;&nbsp;รายได้ - ค่าตอบแทน</h4>
<div class="col-lg-12">
<div class="form-panel">

<form class="form-horizontal style-form"  enctype="multipart/form-data" action="action/classimportot.php" method="post">
<input type='hidden' name='action' value='12'>

<div class="form-group">
<label class="control-label col-md-4"><b>เลือกไฟล์</b><br>
* กรุณาเลือกไฟล์ Excel <br>
</label>
<div class="col-md-4">

<script type="text/javascript" language="javascript">
function checkfile(sender) {
    var validExts = new Array(".xlsx", ".xls", ".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      return false;
    }
    else return true;
}
</script>

<input type="file" id="file" name="fileupload" onchange="checkfile(this);" />
</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">ประจำเดือน</label>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="mm5">
		<option value='1'>มกราคม</option>
		<option value='2'>กุมภาพันธ์</option>
		<option value='3'>มีนาคม</option>
		<option value='4'>เมษายน</option>
		<option value='5'>พฤษภาคม</option>
		<option value='6'>มิถุนายน</option>
		<option value='7'>กรกฎาคม</option>
		<option value='8'>สิงหาคม</option>
		<option value='9'>กันยายน</option>
		<option value='10'>ตุลาคม</option>
		<option value='11'>พฤศจิกายน</option>
		<option value='12'>ธันวาคม</option>
</select>
<Br>

<?php
$yearnow = date("Y")+542;
$yearnow2 = $yearnow+1;
//echo " yearnow = $yearnow<Br>";
?>

<select class="form-control" name="yy5">
<?php
for ($xx = $yearnow; $xx <= $yearnow2; $xx++) {
	if ($xx == $yearnow2) {$s2 = "selected ";}
	echo "<option value='$xx' $s2>$xx</option>";
	  }
?>
</select>

</div>
</div>
<div class="form-group">
<label class="control-label col-md-4">วันที่โอนเงินเข้า </label>
<div class="col-md-3 col-xs-8">
<!--<input class="form-control form-control-inline input-medium default-date-picker" size="16" type="text"  name='filedate'>-->
<input class="form-control form-control-inline input-medium" size="16" type="text"  name='filedate'>

</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">ครั้งที่ </label>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="timesno">
<option value='1'>1</option>
<option value='2'>2</option>
</select>
</div>
</div>

<div class="form-group">
<center>
<button class="btn btn-theme" type="submit">ตกลง</button>
</center>
</div>

</form>
</div>
</div>
<!-- Main Close -->
</div>
<!-- /row -->

<?php
} //type Ot เงินบำรุง
?>




<?
include('include/footer.php');
?>