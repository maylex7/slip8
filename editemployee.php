<meta charset="utf-8">
<meta http-equiv="Content-Language" content="th">
<?php 

session_start();
include('db/connectdb.inc');

$userid = $_SESSION["suserid"];
$usernameid=	$_SESSION["susernameid"];
$userlevel=$_SESSION["suserlevel"];
$Page= $_REQUEST["Page"];
$type= $_REQUEST["type"];
$searchq = $_REQUEST["searchq"];

//echo " userid = $userid, $usernameid, $userlevel <br>";

if ($userlevel == '3') {
	$empid = $_REQUEST["empid"];
	include('include/header.php');}

else {	include('include/headerE.php');}


$sqle = "select *from employee where empid = '$empid' and invalid_flag='0'  ";
$resulte = mysql_query($sqle);
//echo "sql = $sql<br> result = $result<Br>";
$rowe = mysql_fetch_array($resulte);
	$empid = $rowe["empid"];
	$prename = $rowe["prename"];
	$name = $rowe["name"];
	$lastname = $rowe["lastname"];
	$department = $rowe["department"];
	$position = $rowe["position"];
	$emptypeid = $rowe["emptypeid"];

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

<h3><i class="fa fa-angle-right"></i>&nbsp;&nbsp;แก้ไขข้อมูลเจ้าหน้าที่ </h3>
<div class="row">

<!--ADVANCED FILE INPUT-->

<div class="col-lg-12">
<div class="form-panel">
<h4><i class="fa fa-angle-right"></i> <b><?php echo "$prename$name $lastname";?> </b></h4>
<hr>

<form action="action/employeeupdate.php" method="post" enctype="multipart/form-data" class="form-horizontal" name="form"  onsubmit="return checkForm(this);">
<input type='hidden' name='empid' value='<?php echo"$empid";?>'>
<input type='hidden' name='Page' value='<?php echo"$Page";?>'>
<input type='hidden' name='type' value='<?php echo"$type";?>'>
<input type='hidden' name='searchq' value='<?php echo"$searchq";?>'>

<div class="row form-group">
<div class="col col-md-4">
<label for="password-input" class=" form-control-label">คำนำหน้า</label>
</div>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="prename">
<option value='' >-- ไม่ได้ระบุ --</option>
<?php
if ($prename == 'นาย' ) {$pred1 = 'selected'; }
else if ($prename == 'นาง' ) {$pred2 = 'selected'; }
else if ($prename == 'นางสาว' ) {$pred3 = 'selected'; }
else if ($prename == 'ว่าที่ร.ต.' ) {$pred4 = 'selected'; }
else if ($prename == 'ว่าที่ร้อยตรีหญิง' ) {$pred5 = 'selected'; }
else if ($prename == 'เรืออากาศโทหญิง' ) {$pred6 = 'selected'; }
else if ($prename == 'เรืออากาศโท' ) {$pred7 = 'selected'; }
else if ($prename == 'ว่าที่ร้อยตรี' ) {$pred8 = 'selected'; }
else if ($prename == 'จ่าเอกหญิง' ) {$pred9 = 'selected'; }

?>
<option value='นาย' <?php echo"$pred1";?> >นาย</option>
<option value='นาง'  <?php echo"$pred2";?> >นาง</option>
<option value='นางสาว'  <?php echo"$pred3";?> >นางสาว</option>
<option value='ว่าที่ร.ต.'  <?php echo"$pred4";?> >ว่าที่ร.ต.</option>
<option value='ว่าที่ร้อยตรีหญิง'  <?php echo"$pred5";?> >ว่าที่ร้อยตรีหญิง</option>
<option value='เรืออากาศโทหญิง'  <?php echo"$pred6";?> >เรืออากาศโทหญิง</option>
<option value='เรืออากาศโท'  <?php echo"$pred7";?> >เรืออากาศโท</option>
<option value='ว่าที่ร้อยตรี'  <?php echo"$pred8";?> >ว่าที่ร้อยตรี</option>
<option value='จ่าเอกหญิง'  <?php echo"$pred9";?> >จ่าเอกหญิง</option>
</select>
</div>
</div>

<div class="row form-group">
<div class="col col-md-4">
<label for="password-input" class=" form-control-label">ชื่อ</label>
</div>
<div class="col-12 col-md-3">
<input type="text" id="password-input" name="fname" placeholder="ชื่อ" class="form-control" value="<?php echo "$name";?>">
</div>
</div>

<div class="row form-group">
<div class="col col-md-4">
<label for="password-input" class=" form-control-label">นามสกุล</label>
</div>
<div class="col-12 col-md-3">
<input type="text" id="password-input" name="lastname" placeholder="นามสกุล" class="form-control" value="<?php echo "$lastname";?>">
</div>
</div>

<div class="row form-group">
<div class="col col-md-4">
<label for="password-input" class=" form-control-label">ตำแหน่ง</label>
</div>
<div class="col-12 col-md-3">
<input type="text" id="password-input" name="position" placeholder="ตำแหน่ง" class="form-control" value="<?php echo "$position";?>">
</div>
</div>

<div class="row form-group">
<div class="col col-md-4">
<label for="password-input" class=" form-control-label">แผนก</label>
</div>
<div class="col-12 col-md-3">
<input type="text" id="password-input" name="department" placeholder="แผนก" class="form-control" value="<?php echo "$department";?>">
</div>
</div>


<div class="row form-group">
<div class="col col-md-4">
<label for="password-input" class=" form-control-label">ประเภท</label>
</div>
<div class="col-md-3 col-xs-8">
<select class="form-control" name="emptypeid">
<option value='' >-- ไม่ได้ระบุ --</option>
<?php
if ($emptypeid == '1' ) {$predw1 = 'selected'; }
else if ($emptypeid == '2' ) {$predw2 = 'selected'; }
else if ($emptypeid == '3' ) {$predw3 = 'selected'; }
else if ($emptypeid == '4' ) {$predw4 = 'selected'; }
else if ($emptypeid == '5' ) {$predw5 = 'selected'; }
else if ($emptypeid == '6' ) {$predw6 = 'selected'; }

?>
<option value='1' <?php echo"$predw1";?> >ข้าราชการ</option>
<option value='2' <?php echo"$predw2";?> >ลูกจ้างประจำ</option>
<option value='3' <?php echo"$predw3";?> >พนักงานราชการ</option>
<option value='4' <?php echo"$predw4";?> >พนักงานกระทรวง</option>
<option value='5' <?php echo"$predw5";?> >ลูกจ้างรายคาบ</option>
<option value='6' <?php echo"$predw6";?> >ลูกจ้างชั่วคราว</option>


</select>
</div>
</div>

<div class="form-group">
<center>
<button class="btn btn-theme" type="submit">ตกลง</button></form> <input type="button" class="btn btn-theme" value="กลับไป" onclick="history.back()">
</center>
</div>
</div>
</div>
</div>
<!-- Main Close -->

</div>
<!-- /row -->

<?php
include('include/footer.php');
?>