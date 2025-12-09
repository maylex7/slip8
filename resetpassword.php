<?php
session_start();
include ('db/connectdb.inc');

$suserid = $_SESSION["suserid"];
$susernameid=	$_SESSION["susernameid"];
$suserlevel=$_SESSION["suserlevel"];

$Page= $_REQUEST["Page"];
$type= $_REQUEST["type"];
$searchq = $_REQUEST["searchq"];
$empid= $_REQUEST["empid"];

//echo " userid = $suserid, $susernameid, $suserlevel <br>";

//echo "empid = $empid <br>";

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php

$sqlu = "select *from employee where empid = '$empid'";
$resultu = mysql_query($sqlu);

echo "sql = $sqlu <br> Result = $resultu <br>";
$row = mysql_fetch_array($resultu);
$idno= $row["idno"];
$name= $row["name"];
$lastname= $row["lastname"];

$password    = md5($idno);
//echo " idno = $idno $name $lastname<br> ";

//echo "new = $new <br> ";
//echo "password = $password <br>";


$sql = "update user set USER_PASSWORD = '$password' where empid = '$empid' ";
$result = mysql_query($sql);

//echo "sql = $sql <br> Result = $result <br>";
//exit();


echo " <meta http-equiv=\"refresh\" content=\"0;url=officer.php?Page=$Page&type=$type&searchq=$searchq\"> ";
	

?>