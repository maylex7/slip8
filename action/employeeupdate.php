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
	$prename = $_REQUEST["prename"];
	$name = $_REQUEST["fname"];
	$lastname = $_REQUEST["lastname"];
	$department = $_REQUEST["department"];
	$position = $_REQUEST["position"];
	$emptypeid = $_REQUEST["emptypeid"];
	$Page= $_REQUEST["Page"];
	$type= $_REQUEST["type"];
$searchq = $_REQUEST["searchq"];

//echo "new = $new <br> ";
//echo "password = $password <br>";



$sql = "update employee set  
prename='$prename' ,  name='$name' , lastname='$lastname' , department='$department' , position='$position'  , emptypeid='$emptypeid' 
where empid = '$empid' ";
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
echo " <meta http-equiv=\"refresh\" content=\"0;url=../officer.php?Page=$Page&type=$type&searchq=$searchq\"> ";
	
} // ok


?>