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

$new = $_REQUEST["new1"];
$password    = md5($new);


//echo "new = $new <br> ";
//echo "password = $password <br>";



$sql = "update user set USER_PASSWORD = '$password' where USER_ID = '$suserid' ";
$result = mysql_query($sql);

//echo "sql = $sql <br> Result = $result <br>";
//exit();

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


?>