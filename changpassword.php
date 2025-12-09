<meta charset="utf-8">
<meta http-equiv="Content-Language" content="th">
<?php 

session_start();
include('db/connectdb.inc');

$userid = $_SESSION["suserid"];
$usernameid=	$_SESSION["susernameid"];
$userlevel=$_SESSION["suserlevel"];

//echo " userid = $userid, $usernameid, $userlevel <br>";

if ($userlevel == '3') {
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


<!-- Check Form -->
<script type="text/javascript">
  function checkForm(form)
  {
    if(form.new1.value != "" && form.new1.value == form.new2.value) {
      if(form.new1.value.length < 8) {
        alert("รหัสผ่านไม่น้อยกว่า 8 ตัว!");
        form.new1.focus();
        return false;
      }
      if(form.new1.value == form.username.value) {
        alert("Error: Password must be different from Username!");
        form.new1.focus();
        return false;
      }
    } else {
      alert("Error: Please check that you've entered and confirmed your password!");
      form.new1.focus();
      return false;
    }
    alert("You entered a valid password: " + form.new1.value);
    return true;
  }
</script>

<h3><i class="fa fa-angle-right"></i>&nbsp;&nbsp;เปลี่ยนรหัสผ่าน (Password) </h3>
<div class="row">

<!--ADVANCED FILE INPUT-->

<div class="col-lg-12">
<div class="form-panel">
<form action="action/passwordupdate.php" method="post" enctype="multipart/form-data" class="form-horizontal" name="form"  onsubmit="return checkForm(this);">
<input type='hidden' name='action' value='1'>

<!--
<div class="form-group">
<label class="control-label col-md-4">	รหัสผ่านเดิม</label>
<div class="col-md-3 col-xs-8">
<input type="text" class="form-control" id="inputSuccess" >
</div>
</div>

<div class="form-group">
<label class="control-label col-md-4">	รหัสผ่านใหม่</label>
<div class="col-md-3 col-xs-8">
<input type="text" class="form-control" id="inputSuccess">
</div>
</div>
-->

<div class="row form-group">
<div class="col col-md-4">
<label for="password-input" class=" form-control-label">รหัสผ่านใหม่</label>
</div>
<div class="col-12 col-md-3">
<input type="password" id="password-input" name="new1" placeholder="Password" class="form-control" >
<small class="help-block form-text">รหัสผ่านไม่น้อยกว่า 8 ตัว</small>
</div>
</div>

<div class="row form-group">
<div class="col col-md-4">
<label for="password-input" class=" form-control-label">รหัสผ่านใหม่ (อีกครั้ง)</label>
</div>
<div class="col-12 col-md-3">
<input type="password" id="password-input" name="new2" placeholder="Password" class="form-control">
<small class="help-block form-text">รหัสผ่านไม่น้อยกว่า 8 ตัว</small>
</div>
</div>



<div class="form-group">
<center>
<button class="btn btn-theme" type="submit">ตกลง</button>
</center>
</div>
</div>
</div>
</div>
<!-- Main Close -->

</div>
<!-- /row -->





<?php
include('include/footerE.php');
?>
