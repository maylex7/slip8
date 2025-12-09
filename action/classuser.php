<?php
$action = $_REQUEST['action'];

switch ($action) {
case "login":
    login();
    break;

case "active":
    active();
    break;

case "logout":
    logout();
    break;
}

function login() {
global $USERNAME_ID,$USER_PASSWORD,$active,$username,$password;
echo "login<Br>";
include('../db/connectdb.inc');

$date = date("Y-m-d");
$time = date("H:i:s");         
	$username =$_REQUEST["username"];
	$password =$_REQUEST["password"];
	//$password = MD5($_REQUEST["password"]);
	//echo "user = $username <br> pass = $password<Br>";

	$sql = "select * from user where USERNAME_ID='$username' and USER_PASSWORD='$password' and INVALID_FLAG='0' ";
	$result = mysql_query($sql) ;

	$nums = mysql_num_rows($result);
	//echo "sql = $sql <br> result= $result<br>nums = $nums <Br>";
	$rows=mysql_fetch_array($result);
	$userid = $rows["USER_ID"];
	$usernameid = $rows["USERNAME_ID"];
	$userlevel = $rows["USERLEVEL_ID"];
	$depart = $rows["DEPART_ID"];
	$empid = $rows["empid"];
	//echo "levelid = $userlevel<br>";

	session_start();
	$_SESSION["suserid"] = "$userid";
	$_SESSION["susernameid"] = "$usernameid";
	$_SESSION["suserlevel"] = "$userlevel";
	$_SESSION["slanguage"] = "th";
	$_SESSION["sdepart"] = "$depart";
	$_SESSION["sempid"] = "$empid";
	session_write_close();
	if ($userid <> '' ) {
	$sqlu = "update user set USER_LASTLOGIN_DATE = '$date' , USER_LASTLOGIN_TIME = '$time' where  USER_ID = '$userid' ";
	$resultu = mysql_query($sqlu);
	//echo "sql = $sqlu <br> result= $resultu<br>";

		if ($userlevel == '1') {
			header( "location: ../employee.php" );
		}
		else if ($userlevel == '3') {
			header( "location: ../index.php" );
		}
		else if ($userlevel == '2') {
			header( "location: ../index.php" );
		}

	}
	else { header( "location: ../login.php" );
	}
} //login	


function active() {
global $userid,$usernameid, $userlevel;

include('db/connectdb.inc');
session_start();
$userid = $_SESSION["suserid"];
$usernameid=	$_SESSION["susernameid"];
$userlevel=$_SESSION["suserlevel"];
$sempid=$_SESSION["sempid"];
//echo " userid = $userid, $usernameid, $userlevel <br>";
	if ($userid == '' ) {
		header( "location: login.php" );
		// header( "location: index.php" );
	}
	else {// header( "location: login.php" );
	}

} //active

function logout() {
session_start();
session_destroy();
 header( "location: ../index.php" );
} //logout
?>