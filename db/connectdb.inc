<?
date_default_timezone_set('Asia/Bangkok');

$host="localhost";$username="root";$password="";$db = "sliponline";
//$host="localhost";$username="admin_smcdb";$password="sar@2019";$db = "admin_smcdb";


mysql_connect($host,$username,$password) or die("Error Connect to Database"); 
mysql_select_db($db);


mysql_query('SET CHARACTER SET utf8');
?>