<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<META content="text/html; charset=utf8" http-equiv=Content-Type>
<?php
session_start();
include('../db/connectdb.inc');

$action = $_REQUEST["action"]; 
$filedate = $_REQUEST["filedate"]; 

$mm5 = $_REQUEST["mm5"];
$yy5 = $_REQUEST["yy5"];
$timesno=$_REQUEST["timesno"];

if ($mm5 =='01' ) {$month5 = "มกราคม";}
else if ($mm5 =='02' ) {$month5 = "กุมภาพันธ์";}
else if ($mm5 =='03' ) {$month5 = "มีนาคม";}
else if ($mm5 =='04' ) {$month5 = "เมษายน";}
else if ($mm5 =='05' ) {$month5 = "พฤษภาคม";}
else if ($mm5 =='06' ) {$month5 = "มิถุนายน";}
else if ($mm5 =='07' ) {$month5 = "กรกฎาคม";}
else if ($mm5 =='08' ) {$month5 = "สิงหาคม";}
else if ($mm5 =='09' ) {$month5 = "กันยายน";}
else if ($mm5 =='10' ) {$month5 = "ตุลาคม";}
else if ($mm5 =='11' ) {$month5 = "พฤศจิกายน";}
else if ($mm5 =='12' ) {$month5 = "ธันวาคม";}


$dates = date("Y-m-d");
$times = date("H:i:s");         
$suserid = $_SESSION["suserid"];
//echo "suserid = $suserid <Br>";
//echo " action = $action <br> filedate = $filedate<br> เดือน $month5 $yy5 <Br>";
//exit();

$yy = substr($filedate, -4);
$mm=substr($filedate, 3 ,2);
$dd = substr($filedate, 0 ,2);

$yy2 = $yy -543;
$datepay = $yy2.'-'.$mm.'-'.$dd;

//echo " yy = $yy , yy2 = $yy2 , mm = $mm, dd = $dd<Br>";
//exit();

$input_file_name=$_FILES['fileupload']['name'];
$input_file_temp=$_FILES['fileupload']['tmp_name'];

//echo "input_file_name = $input_file_name <Br>";
//exit();

if($input_file_name=="")
	{
	exit("<script>alert('กรุณาแนบไฟล์ ด้วยคะ');window.location='../importdata.php?type=$action';</script>");
	}

	
	//echo $input_file_name."<br>";
	/* echo $input_file_name."<br>"; exit;
	echo $input_file_temp."<br>"; */

	if((strchr($input_file_name,".")!=".xls") && (strchr($input_file_name,".")!=".xlsx") )
	{

		//echo "input_file_name = $input_file_name <Br>";
		exit();

	exit("<script>alert('กรุณาแนบไฟล์ excel เท่านั้น');window.location='../importdata.php?type=$action';</script>");

	}	

if(strchr($input_file_name,".")==".xls" or strchr($input_file_name,".")==".xlsx" )
{
	//echo 'txt';
	//$file_newname="data.xls";

if ($action == '11' ) { 
	$aa="OT1_".$yy5."_".$mm5.".xls";
	$ccc = '7';
	$budget = '1';
} //งบประมาณจ่าย

else if ($action == '12' ) { 
	$aa="OT2_".$yy5."_".$mm5.".xls";
	$ccc = '7';
	$budget = '2';
} //เงินบำรุงจ่าย

	$file_newname="$aa";

}

$source=$input_file_temp;
$target = "../data/";
copy($source,$target.$file_newname);

//echo $source."<br>";
//echo $target.$file_newname."<br><br>";
 if (!copy($source,$target.$file_newname)) {
    //echo "failed to copy $file...\n";
} 

//--------------------------------  Read Data -------------------------------------------------------------//
require_once "../PHPExcel/Classes/PHPExcel.php";
include '../PHPExcel/Classes/PHPExcel/IOFactory.php';

		$tmpfname = $file_newname;		
		$pathToFile = realpath("../data/$file_newname"); 
		$excelReader = PHPExcel_IOFactory::createReaderForFile($pathToFile);		
		$excelObj = $excelReader->load($pathToFile); 
		
		$worksheet = $excelObj->getSheet(0);
		$lastRow = $worksheet->getHighestRow();

$ii = 0;
$kk = 0;
$jj = 0 ; 
$ki=1;
//echo "  lastRow =  $lastRow <br>";

/* เอาข้อมูลจาก Excel 
1. Check T.Employee โดยเช็คจากบัตรประชาชน($idno)  ถ้าไม่ซ้ำให้ insert 
2. Check T.Slip โดยเช็คจาก idno, yy,nn ถ้าไม่ซ้ำค่อย insert 
*/
//echo "actione = $action<Br>";

for ($row = $ccc; $row <= $lastRow; $row++) {
//echo " row = $row <Br>";

//prename name surname
$fullname    = $worksheet->getCell('B'.$row)->getCalculatedValue();

list($name,$surname1,$surname2,$surname3)=explode(" ",$fullname);

if ($surname2 <> '')  {  $surname = $surname1." ".$surname2; }
else { $surname = $surname1; }

if ($surname3 <> '')  {  $surname = $surname1." ".$surname2." ".$surname3; }

if ($surname == '') { list($name,$surname)=explode("  ",$fullname); }


$p1 = substr($name,0,9);
$p2 = substr($name,0,18);

$string = $name;

$find1 = 'นาง';
$pos1 = strpos($string,$find1);
	if ($pos1 == 'นาง') {
		$prename = 'นาง';
		$j = 9;
		$name = substr($string,$j);
	}

$find2 = 'นางสาว';
$pos2 = strpos($string,$find2);
	if ($pos2 == 'นางสาว') {
		$prename = 'นางสาว';
		$j = 18;
		$name = substr($string,$j);
	}

$find3 = 'นาย';
$pos3 = strpos($string,$find3);
	if ($pos3 == 'นาย') {
		$prename = 'นาย';
		$j = 9;
		$name = substr($string,$j);
	}

$find4 = 'ว่าที่ร.ต.';
$pos4 = strpos($string,$find4);
	if ($pos4 == 'ว่าที่ร.ต.') {
		$prename = 'ว่าที่ร.ต.';
		$j = 26;
		$name = substr($string,$j);
	}

$find5 = 'ว่าที่ร้อยตรีหญิง';
$pos5 = strpos($string,$find5);
	if ($pos5 == 'ว่าที่ร้อยตรีหญิง') {
		$prename = 'ว่าที่ร้อยตรีหญิง';
		$j = 51;
		$name = substr($string,$j);
	}

$find6 = 'น.ส.';
$pos6 = strpos($string,$find6);
	if ($pos6 == 'น.ส.') {
		$prename = 'นางสาว';
		$j = 8;
		$name = substr($string,$j);
	}

$find7 = 'เรืออากาศโทหญิง';
$pos7 = strpos($string,$find7);
	if ($pos7 == 'เรืออากาศโทหญิง') {
		$prename = 'เรืออากาศโทหญิง';
		$j = 45;
		$name = substr($string,$j);
	}

$find8 = 'เรืออากาศโท';
$pos8 = strpos($string,$find8);
	if ($pos8 == 'เรืออากาศโท') {
		$prename = 'เรืออากาศโท';
		$j = 33;
		$name = substr($string,$j);
	}

$find9 = 'ว่าที่ร้อยตรี';
$pos9 = strpos($string,$find9);
	if ($pos9 == 'ว่าที่ร้อยตรี') {
		$prename = 'ว่าที่ร้อยตรี';
		$j = 39;
		$name = substr($string,$j);
	}

$find10 = 'จ่าเอกหญิง';
$pos10 = strpos($string,$find10);
	if ($pos10 == 'จ่าเอกหญิง') {
		$prename = 'จ่าเอกหญิง';
		$j = 30;
		$name = substr($string,$j);
	}

/*
$find6 = 'น.ส.';
$pos6 = strpos($string,$find2);
	if ($pos6 == 'น.ส.') {
		$prename = 'น.ส.';
		$j = 12;
		$name = substr($string,$j);
	}

*/

//echo "$fullname=  $prename,$name,$surname<br>";
//echo "id = $idno,$fullname<br>";

if ($action == '11' ) { 
	$idno    = $worksheet->getCell('C'.$row)->getCalculatedValue(); ///อาจจะต้องดูอีกที
	$idno = str_replace("-","",$idno);
	$idno = str_replace(" ","",$idno);


	$bankno    = $worksheet->getCell('E'.$row)->getCalculatedValue();
	$department    = $worksheet->getCell('D'.$row)->getCalculatedValue();
	$password    = md5($idno);
	$bankid = "ธนาคารกรุงไทย";
	$mobile = "";

/*
	$position = $worksheet->getCell('D'.$row)->getCalculatedValue();
	$department    = $worksheet->getCell('E'.$row)->getCalculatedValue();	
	$password    = md5($idno);	
	$mobile = "";
*/

	/*Slip*/
	$money1    = $worksheet->getCell('F'.$row)->getCalculatedValue();
	$money2    = $worksheet->getCell('AI'.$row)->getCalculatedValue();
	$money3    = $worksheet->getCell('AN'.$row)->getCalculatedValue();
	$money4    = $worksheet->getCell('M'.$row)->getCalculatedValue();
	$money5    = $worksheet->getCell('G'.$row)->getCalculatedValue();
	$money6    = $worksheet->getCell('AF'.$row)->getCalculatedValue();

	$money7    = $worksheet->getCell('AP'.$row)->getCalculatedValue();
	$money8    = $worksheet->getCell('AR'.$row)->getCalculatedValue();
	$money9    = $worksheet->getCell('AT'.$row)->getCalculatedValue();
	$money10  = $worksheet->getCell('AV'.$row)->getCalculatedValue();
	$money11 =  $worksheet->getCell('AX'.$row)->getCalculatedValue();
	$money12 = "";
	$money13 = "";
	$money14 = "";
	$money15 = "";
	$money16 = "";
	$money17 = "";
	$money18 = "";
	$money19 = "";
	$money20 = "";

	$money_text1    = "ค่าเช่าบ้าน";
	$money_text2    = "ค่าเล่าเรียนบุตร";
	$money_text3    = "ค่ารักษาพยาบาล";
	$money_text4    = "เวรบ่าย - ดึก เดือน $month5 $yy5";
	$money_text5    = "เงินเพิ่มพิเศษแพทย์, เภสัชกร เดือน $month5 $yy5";
	$money_text6    = "พ.ต.ส. เดือน $month5 $yy5";

	$money_text7    =  $worksheet->getCell('AO'.$row)->getCalculatedValue();
	$money_text8    = $worksheet->getCell('AQ'.$row)->getCalculatedValue();
	$money_text9    = $worksheet->getCell('AS'.$row)->getCalculatedValue();
	$money_text10  = $worksheet->getCell('AU'.$row)->getCalculatedValue();
	$money_text11  = $worksheet->getCell('AW'.$row)->getCalculatedValue();
	$money_text12  = "";
	$money_text13  = "";
	$money_text14  = "";
	$money_text15  = "";
	$money_text16  = "";
	$money_text17  = "";
	$money_text18  = "";
	$money_text19  = "";
	$money_text20  = "";
	
}// type11

else if ($action == '12' ) { 
	$idno    = $worksheet->getCell('C'.$row)->getCalculatedValue(); ///อาจจะต้องดูอีกที
	$idno = str_replace("-","",$idno);
	$idno = str_replace(" ","",$idno);


	$bankno    = $worksheet->getCell('E'.$row)->getCalculatedValue();
	$department    = $worksheet->getCell('D'.$row)->getCalculatedValue();
	$password    = md5($idno);
	$bankid = "ธนาคารกรุงไทย";
	$mobile = "";

	/*Slip*/
	$money1    = $worksheet->getCell('F'.$row)->getCalculatedValue();
	$money2    = $worksheet->getCell('G'.$row)->getCalculatedValue();
	$money3    = $worksheet->getCell('J'.$row)->getCalculatedValue();
	$money4    = $worksheet->getCell('M'.$row)->getCalculatedValue();
	$money5    = $worksheet->getCell('W'.$row)->getCalculatedValue();
	$money6    = $worksheet->getCell('Z'.$row)->getCalculatedValue();
	$money7    = $worksheet->getCell('AK'.$row)->getCalculatedValue();
	$money8    = $worksheet->getCell('AN'.$row)->getCalculatedValue();

	$money9    = $worksheet->getCell('AP'.$row)->getCalculatedValue();
	$money10  = $worksheet->getCell('AR'.$row)->getCalculatedValue();
	$money11   = $worksheet->getCell('AT'.$row)->getCalculatedValue();
	$money12   = $worksheet->getCell('AV'.$row)->getCalculatedValue();
	$money13   = $worksheet->getCell('AX'.$row)->getCalculatedValue();
	$money14   = $worksheet->getCell('AZ'.$row)->getCalculatedValue();
	$money15   = $worksheet->getCell('BB'.$row)->getCalculatedValue();
	$money16   = $worksheet->getCell('BD'.$row)->getCalculatedValue();
	$money17   = $worksheet->getCell('BF'.$row)->getCalculatedValue();
	$money18   = $worksheet->getCell('BH'.$row)->getCalculatedValue();
	$money19   = "";
	$money20   = "";


	$money_text1    = "เงินเพิ่มพิเศษไม่ทำเวชปฏิบัติ";
	$money_text2    = "เงินเพิ่มพิเศษส่งเสริมพิเศษ";
	$money_text3    = "นอกเวลาพยาบาล เดือน $month5 $yy5";
	$money_text4    = "เวร บ่าย - ดึก พยาบาล เดือน $month5 $yy5";
	$money_text5    = "นอกเวลาราชการ เดือน $month5 $yy5";
	$money_text6    = "คลินิกนอกเวลา เดือน $month5 $yy5";
	$money_text7    = "พ.ต.ส. เดือน $month5 $yy5";
	$money_text8    = "คลินิกรุ่งอรุณ  เดือน $month5 $yy5";

	$money_text9    = $worksheet->getCell('AO'.$row)->getCalculatedValue();;
	$money_text10  = $worksheet->getCell('AQ'.$row)->getCalculatedValue();
	$money_text11  = $worksheet->getCell('AS'.$row)->getCalculatedValue();
	$money_text12  = $worksheet->getCell('AU'.$row)->getCalculatedValue();
	$money_text13  = $worksheet->getCell('AW'.$row)->getCalculatedValue();
	$money_text14  = $worksheet->getCell('AY'.$row)->getCalculatedValue();
	$money_text15  = $worksheet->getCell('BA'.$row)->getCalculatedValue();
	$money_text16  = $worksheet->getCell('BC'.$row)->getCalculatedValue();
	$money_text17  = $worksheet->getCell('BE'.$row)->getCalculatedValue();
	$money_text18  = $worksheet->getCell('BG'.$row)->getCalculatedValue();
	$money_text19  = "";
	$money_text20  = "";
	
}// type12


/***********************************************************************************************************************/

$summoney = $money1+$money2+$money3+$money4+$money5+$money6+$money7+$money8+$money9+$money10
						+$money11+$money12+$money13+$money14+$money15+$money16+$money17+$money18+$money19+$money20;

$sumexp = 0;

$sumnet = $summoney-$sumexp ;
//echo " summoney = $summoney ,sumexp = $sumexp,sumnet  = $sumnet <Br>";
//exit();

$USER_NAME = $name.' '.$surname;
$USER_EMAIL='';
$USER_PHONE='';
$USER_LOGO ='profile.png';
$USER_LASTLOGIN_DATE='';
$USER_LASTLOGIN_TIME='';
$ACTIVE='';
$ACTIVE_DATE='';
$NOTE='';
$INVALID_FLAG ='0';
//echo "idno = $idno,$fullname<br>";

/////////////เจ้าหน้าที่ไม่ซ้ำกับของเดิม save t.employee , t.user

$sql_s = "select *from employee e where e.idno = '$idno' ";
$result_s = mysql_query($sql_s);
$num_s = mysql_num_rows($result_s);
//echo " sql = $sql_s <br> result = $result_s<br>num_s = $num_s";

if ($num_s == '0' ) {
	
//if ($idno <> '') {

if ( is_numeric($idno) ) {
	$sql_e = "insert employee(emptypeid,prename,name,lastname,bankno,idno,position,department,password,bankid,mobile,note,passwordchangedate,passwordchange,invalid_flag,create_user,create_date,create_time,update_user,update_date,update_time)
	values ('','$prename','$name','$surname','$bankno','$idno','$position','$department','$password','$bankid','$mobile','$note','$dates','1','0','$suserid','$dates','$times','$suserid','$dates','$times')
	";

	$result_e = mysql_query($sql_e);
	$empid = mysql_insert_id();

	//echo " sql = $sql_e <br> result = $result_e<br></br>";

	$sql_u ="insert user(USER_NAME,empid,emptypeid,USERNAME_ID,USER_PASSWORD,USERLEVEL_ID,DEPART_ID,USER_EMAIL,USER_PHONE,USER_LOGO,USER_LASTLOGIN_DATE,USER_LASTLOGIN_TIME,ACTIVE,ACTIVE_DATE,NOTE,INVALID_FLAG,CREATE_USER,CREATE_DATE,CREATE_TIME,UPDATE_USER,UPDATE_DATE,UPDATE_TIME)  

	values('$USER_NAME','$empid','','$idno','$password','1','$department','$USER_EMAIL','$USER_PHONE','$USER_LOGO','$USER_LASTLOGIN_DATE','$USER_LASTLOGIN_TIME','$ACTIVE','$ACTIVE_DATE','$NOTE','$INVALID_FLAG','$suserid','$dates','$times','$suserid','$dates','$times') ";
	$result_u = mysql_query($sql_u);
//echo " sql = $sql_u <br> result = $result_u<br>";

$kk++;
}//if idno have

///echo "empid_notsame =$empid<Br>";
}//not same

else {

//echo "same <br>";

$sqle = "select *from employee where idno= '$idno' ";
$resulte = mysql_query($sqle);
$rowe = mysql_fetch_array($resulte);

$empid = $rowe['empid'];

//echo "empid_same =$empid<Br>";

}//same t.user t.employee


if ($empid <> '') {


//////////////// save t.sliponline ประจำเดือน

//if ($idno <> '') {
if ( is_numeric($idno) ) {

$sql_s = "select *from slipot where empid = '$empid' and yy='$yy5' and mm = '$mm5' and datepay = '$datepay' and budget = '$action' and timesno='$timesno' ";
$result_s = mysql_query($sql_s);
$num_s = mysql_num_rows($result_s);

//echo "sql_s = $sql_s <Br> result_s=$result_s<Br>";
//echo "num_s = $num_s <Br>";
//echo " summoney = $summoney ,sumexp = $sumexp,sumnet  = $sumnet <Br>";
//exit();

if ($num_s == '0') {
		$sql = "insert
		slipot(empid,datepay,yy,mm,idno,nobank,emptypeid,money1,money2,money3,money4,money5,money6,money7,money8,money9,money10
		,money11,money12,money13,money14,money15,money16,money17,money18,money19,money20
		,money_text1,money_text2,money_text3,money_text4,money_text5,money_text6,money_text7,money_text8,money_text9,money_text10
	,money_text11,money_text12,money_text13,money_text14,money_text15,money_text16,money_text17,money_text18,money_text19,money_text20
		,summoney,sumnet,notes,remarks,invalid_flag,create_user,create_date,create_time,update_user,update_date,update_time,budget,timesno)

		values('$empid','$datepay','$yy5','$mm5','$idno','$bankno','0','$money1','$money2','$money3','$money4','$money5','$money6','$money7','$money8','$money9','$money10','$money11','$money12','$money13','$money14','$money15'
		,'$money16','$money17','$money18','$money19','$money20'
		,'$money_text1','$money_text2','$money_text3','$money_text4','$money_text5','$money_text6','$money_text7','$money_text8','$money_text9','$money_text10','$money_text11','$money_text12','$money_text13','$money_text14','$money_text15'
		,'$money_text16','$money_text17','$money_text18','$money_text19','$money_text20'
		,'$summoney','$sumnet','','','0','$suserid','$dates','$times','$suserid','$dates','$times','$action','$timesno')

		";

$jj++;

}//notsame slip

else {
//echo "slip same <Br>";


		$sql = "update slipot set 
		datepay='$datepay',yy='$yy5',mm='$mm5',idno='$idno',nobank='$bankno',emptypeid='0'
		,money1='$money1',money2='$money2',money3='$money3',money4='$money4',money5='$money5',money6='$money6',money7='$money7',money8='$money8',money9='$money9',money10='$money10',
		money11='$money11',money12='$money12',money13='$money13',money14='$money14',money15='$money15',
		money16='$money16',money17='$money17',money18='$money18',money19='$money19',money20='$money20',

		money_text1='$money_text1',money_text2='$money_text2',money_text3='$money_text3',money_text4='$money_text4',money_text5='$money_text5',money_text6='$money_text6',money_text7='$money_text7',money_text8='$money_text8',money_text9='$money_text9',money_text10='$money_text10',
		money_text11='$money_text11',money_text12='$money_text12',money_text13='$money_text13',money_text14='$money_text14',money_text15='$money_text15',		

		money_text16='$money_text16',money_text17='$money_text17',money_text18='$money_text18',money_text19='$money_text19',money_text20='$money_text20',
		
		summoney='$summoney',sumnet='$sumnet',invalid_flag='0',update_user='$suserid',update_date='$dates',update_time='$times'

		where  empid = '$empid' and yy='$yy5' and mm = '$mm5'   and budget='$action' and datepay = '$datepay' and timesno='$timesno' ";

$jj++;
} //edit slip

//echo " sql = $sql <Br>";

$result = mysql_query($sql);

//echo "sql = $sql <br> result = $result<br><hr>";

//exit();

}//have id no
}//have empid

$ii++;
}//For 

$sql_f = "insert fileupload(namefile,slipnums,empnums,emptypeid,CREATE_USER,CREATE_DATE,CREATE_TIME) 
values ('$file_newname','$jj','$kk','$action','$suserid','$dates','$times') ";
$result_f = mysql_query($sql_f);

//echo "sql = $sql_f <br> Result = $result_f <br>";
//exit();
echo " <meta http-equiv=\"refresh\" content=\"0;url=../complete.php?action=$action&mm=$mm5&yy=$yy5\"> ";

?>