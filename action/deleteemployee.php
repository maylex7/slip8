<?php
session_start();
include ('../db/connectdb.inc');

$suserid = $_SESSION["suserid"];
$susernameid=	$_SESSION["susernameid"];
$suserlevel=$_SESSION["suserlevel"];

//echo " userid = $suserid, $susernameid, $suserlevel <br>";

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php
$empid = $_REQUEST["empid"];
$Page= $_REQUEST["Page"];
$type= $_REQUEST["type"];
//echo "empid = $empid <br> ";
//echo "password = $password <br>";



$sqle = "update employee set invalid_flag = '1' where empid = '$empid' ";
$resulte = mysql_query($sqle);

$sqlu = "update user set invalid_flag = '1' where empid = '$empid' ";
$resultu = mysql_query($sqlu);

//echo "sqle = $sqle <br> Resulte = $resulte <br>";
//echo "sqlu = $sqlu <br> Resultu = $resultu <br>";

//exit();

echo " <meta http-equiv=\"refresh\" content=\"0;url=../officer.php?Page=$Page&type=$type\"> ";

/*
if ($result <> '1' ){
echo "
	<script language=\"javascript\" type=\"text/javascript\">
		alert('เปลี่ยนรหัสผ่านไม่สำเร็จ กลับไปทำใหม่อีกรอบ');
		window.location = \"../changpassword.php\";
	</script>	";
	
}//not ok
	
else {
echo "
	<script language=\"javascript\" type=\"text/javascript\">
		alert('รหัสผ่านใหม่ของคุณคือ  $new ');
		window.location = \"../employee.php\";
	</script>";
	
} // ok

*/

?>