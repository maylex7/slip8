<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<META content="text/html; charset=utf8" http-equiv=Content-Type>
<?php
session_start();
include('../db/connectdb.inc');

$action = $_REQUEST["action"]; 
$filedate = $_REQUEST["filedate"]; 

$mm5 = $_REQUEST["mm5"];
$yy5 = $_REQUEST["yy5"];

$dates = date("Y-m-d");
$times = date("H:i:s");         
$suserid = $_SESSION["suserid"];
//echo "suserid = $suserid <Br>";
//echo " action = $action <br> filedate = $filedate<br>";
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
	exit("<script>alert('กรุณาแนบไฟล์ excel เท่านั้น');window.location='../importdata.php?type=$action';</script>");
	}	

if(strchr($input_file_name,".")==".xls" or strchr($input_file_name,".")==".xlsx" )
{
	//echo 'txt';
	//$file_newname="data.xls";


if ($action == '4' ) { $aa="T4_".$yy5."_".$mm5.".xls";} //พกส
else if ($action == '3' ) { $aa="T3_".$yy5."_".$mm5.".xls";} //พรก
else if ($action == '5' ) { $aa="T5_".$yy5."_".$mm5.".xls";} //รายคาบ
else if ($action == '2' ) { $aa="T2_".$yy5."_".$mm5.".xls";} //ลูกจ้างประจำ
else if ($action == '1' ) { $aa="T1_".$yy5."_".$mm5.".xls";} //ขรก
else if ($action == '6' ) { $aa="T1_".$yy5."_".$mm5.".xls";} //ขรก

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
//echo "  lastRow =  $lastRow <br>";

/* เอาข้อมูลจาก Excel 
1. Check T.Employee โดยเช็คจากบัตรประชาชน($idno)  ถ้าไม่ซ้ำให้ insert 
2. Check T.Slip โดยเช็คจาก idno, yy,nn ถ้าไม่ซ้ำค่อย insert 
*/
//echo "actione = $action<Br>";


if ($action == '1' ) { $ccc = '6';} //ขรก
else if ($action == '2' ) { $ccc = '6';} //ประจำ
else if ($action == '3' ) { $ccc = '6';} //พรก
else if ($action == '4' ) { $ccc = '5';} //พกส
else if ($action == '5' ) { $ccc = '6';} //รายคาบ
else if ($action == '6' ) { $ccc = '5';} //ชั่วคราว

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
//exit();

/******************** พนักงานกระทรวง ****************************/
if ($action == '4' ) { 
	$idno    = $worksheet->getCell('C'.$row)->getCalculatedValue(); ///อาจจะต้องดูอีกที
	$idno = str_replace("-","",$idno);
	$idno = str_replace(" ","",$idno);

	$position = $worksheet->getCell('D'.$row)->getCalculatedValue();
	$department    = $worksheet->getCell('E'.$row)->getCalculatedValue();
	$bankno    = $worksheet->getCell('G'.$row)->getCalculatedValue();
	$bankid = $worksheet->getCell('F'.$row)->getCalculatedValue();
	$password    = md5($idno);
	
	$mobile = "";

	/*Slip*/
	$money1    = $worksheet->getCell('H'.$row)->getCalculatedValue();
	$money2    = $worksheet->getCell('I'.$row)->getCalculatedValue();
	$money3    = $worksheet->getCell('J'.$row)->getCalculatedValue();
	$money4    = $worksheet->getCell('K'.$row)->getCalculatedValue();
	$money5    = '';
	$money6    = $worksheet->getCell('XX'.$row)->getCalculatedValue();
	$money7    = $worksheet->getCell('XX'.$row)->getCalculatedValue();
	$money8    = $worksheet->getCell('XX'.$row)->getCalculatedValue();
	$money9    = $worksheet->getCell('XX'.$row)->getCalculatedValue();
	$money10  = $worksheet->getCell('XX'.$row)->getCalculatedValue();
	$money11 = "";
	$money12 = "";
	$money13 = "";
	$money14 = "";
	$money15 = "";

	$money_text1    = "ค่าจ้าง";
	$money_text2    = "ค่าตอบแทนพิเศษ";
	$money_text3    = "ค่าตอบแทนพิเศษตกเบิก";
	$money_text4    = "ตกเบิก";
	$money_text5    = "";
	$money_text6    = "";
	$money_text7    = "";
	$money_text8    = "";
	$money_text9    = "";
	$money_text10  = "";
	$money_text11  = "";
	$money_text12  = "";
	$money_text13  = "";
	$money_text14  = "";
	$money_text15  = "";

	$exp1    = $worksheet->getCell('L'.$row)->getCalculatedValue();
	$exp2    = $worksheet->getCell('M'.$row)->getCalculatedValue();
	$exp3    = $worksheet->getCell('N'.$row)->getCalculatedValue();
	$exp4    = $worksheet->getCell('O'.$row)->getCalculatedValue();
	$exp5    = $worksheet->getCell('P'.$row)->getCalculatedValue();
	$exp6    = $worksheet->getCell('Q'.$row)->getCalculatedValue();
	$exp7    = $worksheet->getCell('R'.$row)->getCalculatedValue();
	$exp8    = $worksheet->getCell('S'.$row)->getCalculatedValue();
	$exp9    = $worksheet->getCell('T'.$row)->getCalculatedValue();
	$exp10    = $worksheet->getCell('U'.$row)->getCalculatedValue();
	$exp11    = $worksheet->getCell('V'.$row)->getCalculatedValue();
	$exp12    = $worksheet->getCell('W'.$row)->getCalculatedValue();
	$exp13    = $worksheet->getCell('X'.$row)->getCalculatedValue();
	$exp14    = $worksheet->getCell('Y'.$row)->getCalculatedValue();
	$exp15    = $worksheet->getCell('Z'.$row)->getCalculatedValue();
	$exp16    = $worksheet->getCell('AA'.$row)->getCalculatedValue();
	$exp17    = $worksheet->getCell('AB'.$row)->getCalculatedValue();
	$exp18    ="";
	$exp19    ="";
	$exp20    ="";
	$exp21    ="";
	$exp21    = "";
	$exp22    = "";
	$exp23    = "";
	$exp24    = "";
	$exp25    = "";


	$exp_text1    = "ฌาปนกิจ";
	$exp_text2    = "สหกรณ์กรมการแพทย์";
	$exp_text3    = "ประกันสังคม";
	$exp_text4    = "วันลา/คืนค่าจ้าง";
	$exp_text5    = "ค่าไฟฟ้า";
	$exp_text6    = "ค่าน้ำประปา";
	$exp_text7    = "ค่าทำความทำความสะอาด";
	$exp_text8    = "ประกันชีวิต AIA";
	$exp_text9    = "ธนาคารออมสิน";
	$exp_text10  = "ภาษี";
	$exp_text11    = "สหกรณ์กรมควบคุมโรค";
	$exp_text12    = "เงินสะสม กสล.";
	$exp_text13    = "ธนาคารกรุงไทย";
	$exp_text14    = "กยศ./กรอ.";
	$exp_text15    = "ธนาคารอิสลาม";
	$exp_text16    = "ประกันสังคมตกเบิก";
	$exp_text17    = "ธนาคาร ธอส.";
	$exp_text18    = "";
	$exp_text19    = "";
	$exp_text20    = "";
	$exp_text21    = "";
	$exp_text22    = "";
	$exp_text23    = "";
	$exp_text24    = "";
	$exp_text25    = "";

}// type4


/****************** พนักงานราชการ ********************/
else if ($action == '3' ) { 
	$idno    = $worksheet->getCell('C'.$row)->getCalculatedValue(); ///อาจจะต้องดูอีกที
	$idno = str_replace("-","",$idno);
	$idno = str_replace(" ","",$idno);

	$position = $worksheet->getCell('D'.$row)->getCalculatedValue();
	$department    = $worksheet->getCell('E'.$row)->getCalculatedValue();
	$password    = md5($idno);
	$bankno = $worksheet->getCell('G'.$row)->getCalculatedValue();
	$bankid = $worksheet->getCell('F'.$row)->getCalculatedValue();


	$mobile = "";
//echo "idno11  = $idno ,position = $position, department= $department <Br>";


	/*Slip*/
	$money1    = $worksheet->getCell('H'.$row)->getCalculatedValue();
	$money2    = $worksheet->getCell('I'.$row)->getCalculatedValue();
	$money3    = $worksheet->getCell('J'.$row)->getCalculatedValue();
	$money4    = $worksheet->getCell('K'.$row)->getCalculatedValue();
	$money5    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money6    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money7    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money8    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money9    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money10  = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money11 = "";
	$money12 = "";
	$money13 = "";
	$money14 = "";
	$money15 = "";


	$money_text1    = "ค่าจ้าง";
	$money_text2    = "ค่าจ้างตกเบิก";
	$money_text3    = " ค่าครองชีพ";
	$money_text4    = "ค่าครองชีพ ตกเบิก";
	$money_text5    = "";
	$money_text6    = "";
	$money_text7    = "";
	$money_text8    = "";
	$money_text9    = "";
	$money_text10  = "";
	$money_text11  = "";
	$money_text12  = "";
	$money_text13  = "";
	$money_text14  = "";
	$money_text15  = "";

	$exp1    = $worksheet->getCell('L'.$row)->getCalculatedValue();
	$exp2    = $worksheet->getCell('M'.$row)->getCalculatedValue();
	$exp3    = $worksheet->getCell('N'.$row)->getCalculatedValue();
	$exp4    = $worksheet->getCell('O'.$row)->getCalculatedValue();
	$exp5    = $worksheet->getCell('P'.$row)->getCalculatedValue();
	$exp6    = $worksheet->getCell('Q'.$row)->getCalculatedValue();
	$exp7    = $worksheet->getCell('R'.$row)->getCalculatedValue();
	$exp8    = $worksheet->getCell('S'.$row)->getCalculatedValue();
	$exp9    = $worksheet->getCell('T'.$row)->getCalculatedValue();
	$exp10    = $worksheet->getCell('U'.$row)->getCalculatedValue();
	$exp11    = $worksheet->getCell('V'.$row)->getCalculatedValue();
	$exp12    = $worksheet->getCell('W'.$row)->getCalculatedValue();
	$exp13    = $worksheet->getCell('X'.$row)->getCalculatedValue();
	$exp14    = $worksheet->getCell('Y'.$row)->getCalculatedValue();
	$exp15    = $worksheet->getCell('Z'.$row)->getCalculatedValue();
	$exp16    =$worksheet->getCell('AA'.$row)->getCalculatedValue();
	$exp17    ="";
	$exp18    ="";
	$exp19    ="";
	$exp20    ="";
	$exp21    ="";
	$exp22    = "";
	$exp23    = "";
	$exp24    = "";
	$exp25    = "";

	$exp_text1    = "ประกันสังคม";
	$exp_text2    = "ตกเบิกประกันสังคม";	
	$exp_text3    = "สหกรณ์กรมการแพทย์";
	$exp_text4    = "ฌาปนกิจ";
	$exp_text5    = "ค่าไฟฟ้า";
	$exp_text6    = "ค่าน้ำประปา";
	$exp_text7    = "ประกันชีวิต AIA";
	$exp_text8    = "สหกรณ์กรมควบคุมโรค";
	$exp_text9    = "ธนาคารออมสิน";
	$exp_text10   = "ธนาคารกรุงไทย";
	$exp_text11  = "ธนาคารไทยพาณิชย์";
	$exp_text12    = "ธนาคารอาคารสงเคราะห์";
	$exp_text13    = "กองทุนกู้ยืม กยศ.";
	$exp_text14    = "คืนเงินค่าครองชีพ";
	$exp_text15    = "คืนเงินประกันสังคม";
	$exp_text16    = "คืนเงินค่าจ้าง";
	$exp_text17    = "";
	$exp_text18    = "";
	$exp_text19    = "";
	$exp_text20    = "";
	$exp_text21    = "";
	$exp_text22    = "";
	$exp_text23    = "";
	$exp_text24    = "";
	$exp_text25    = "";
}// type3


/****************** ลูกจ้างรายคาบ ********************/
else if ($action == '5' ) { 
	$idno    = $worksheet->getCell('C'.$row)->getCalculatedValue(); ///อาจจะต้องดูอีกที
	$idno = str_replace("-","",$idno);
	$idno = str_replace(" ","",$idno);

	$position = $worksheet->getCell('D'.$row)->getCalculatedValue();
	$department    = $worksheet->getCell('E'.$row)->getCalculatedValue();
	$bankid = $worksheet->getCell('F'.$row)->getCalculatedValue();
	$bankno    = $worksheet->getCell('G'.$row)->getCalculatedValue();
	$password    = md5($idno);
	
	$mobile = "";
//echo "idno11  = $idno ,position = $position, department= $department <Br>";


	/*Slip*/
	$money1    = $worksheet->getCell('H'.$row)->getCalculatedValue();
	$money2    = $worksheet->getCell('I'.$row)->getCalculatedValue();
	$money3    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money4    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money5    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money6    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money7    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money8    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money9    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money10  = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money11 = "";
	$money12 = "";
	$money13 = "";
	$money14 = "";
	$money15 = "";

	$money_text1    = "ค่าจ้าง";
	$money_text2    = "ค่าจ้างตกเบิก";
	$money_text3    = "";
	$money_text4    = "";
	$money_text5    = "";
	$money_text6    = "";
	$money_text7    = "";
	$money_text8    = "";
	$money_text9    = "";
	$money_text10  = "";
	$money_text11  = "";
	$money_text12  = "";
	$money_text13  = "";
	$money_text14  = "";
	$money_text15  = "";

	$exp1    = $worksheet->getCell('J'.$row)->getCalculatedValue();
	$exp2    = $worksheet->getCell('K'.$row)->getCalculatedValue();
	$exp3    = $worksheet->getCell('L'.$row)->getCalculatedValue();
	$exp4    = $worksheet->getCell('M'.$row)->getCalculatedValue();
	$exp5    = $worksheet->getCell('N'.$row)->getCalculatedValue();
	$exp6    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp7    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp8    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp9    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp10   = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp11   = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp12    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp13    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp14    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp15    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp16    ="";
	$exp17    ="";
	$exp18    ="";
	$exp19    ="";
	$exp20    ="";
	$exp21    ="";
	$exp22    = "";
	$exp23    = "";
	$exp24    = "";
	$exp25    = "";


	$exp_text1    = "ประกันสังคม";
	$exp_text2    = "วันลา/คืนค่าจ้าง";
	$exp_text3    = "กยศ/กรอ";
	$exp_text4    = "ค่าไฟฟ้า";
	$exp_text5    = "ค่าประปา";
	$exp_text6    = "";
	$exp_text7    = "";
	$exp_text8    = "";
	$exp_text9   = "";
	$exp_text10  = "";
	$exp_text11  = "";
	$exp_text12   = "";
	$exp_text13    = "";
	$exp_text14    = "";
	$exp_text15    = "";
	$exp_text16    = "";
	$exp_text17    = "";
	$exp_text18    = "";
	$exp_text19    = "";
	$exp_text20    = "";
	$exp_text21    = "";
	$exp_text22    = "";
	$exp_text23    = "";
	$exp_text24    = "";
	$exp_text25    = "";


}// type5

/*************** ลูกจ้างประจำ ******************/
else if ($action == '2' ) { 
	//echo "actond = $action<Br>";

	$idno    = $worksheet->getCell('C'.$row)->getCalculatedValue(); ///อาจจะต้องดูอีกที
	$idno = str_replace("-","",$idno);
	$idno = str_replace(" ","",$idno);

	$position = $worksheet->getCell('D'.$row)->getCalculatedValue();
	$department    = $worksheet->getCell('E'.$row)->getCalculatedValue();
	$bankno    = $worksheet->getCell('I'.$row)->getCalculatedValue();
	$bankid = $worksheet->getCell('H'.$row)->getCalculatedValue();
	$password    = md5($idno);

	$mobile = "";
//echo "idno11  = $idno ,position = $position, department= $department <Br>";

	/*Slip*/
	$money1    = $worksheet->getCell('J'.$row)->getCalculatedValue();
	$money2    = $worksheet->getCell('K'.$row)->getCalculatedValue();
	$money3    = $worksheet->getCell('L'.$row)->getCalculatedValue();
	$money4    = $worksheet->getCell('M'.$row)->getCalculatedValue();
	$money5    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money6    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money7    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money8    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money9    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$money10  = $worksheet->getCell('AL'.$row)->getCalculatedValue();
   //echo "m1 = $money1 <Br>";
	$money_text1    = "ค่าจ้าง";
	$money_text2    = "ค่าจ้างตกเบิก";
	$money_text3    = "ต.พ.จ.ว319";
	$money_text4    = "ต.พ.จ.ว319 ตกเบิก";
	$money_text5    = "";
	$money_text6    = "";
	$money_text7    = "";
	$money_text8    = "";
	$money_text9    = "";
	$money_text10  = "";
	$money11 = "";
	$money12 = "";
	$money13 = "";
	$money14 = "";
	$money15 = "";
	$money_text11  = "";
	$money_text12  = "";
	$money_text13  = "";
	$money_text14  = "";
	$money_text15  = "";


	$exp1    = $worksheet->getCell('O'.$row)->getCalculatedValue();
	$exp2    = $worksheet->getCell('P'.$row)->getCalculatedValue();
	$exp3    = $worksheet->getCell('Q'.$row)->getCalculatedValue();
	$exp4    = $worksheet->getCell('R'.$row)->getCalculatedValue();
	$exp5    = $worksheet->getCell('S'.$row)->getCalculatedValue();
	$exp6    = $worksheet->getCell('T'.$row)->getCalculatedValue();
	$exp7    = $worksheet->getCell('U'.$row)->getCalculatedValue();
	$exp8    = $worksheet->getCell('V'.$row)->getCalculatedValue();
	$exp9    = $worksheet->getCell('W'.$row)->getCalculatedValue();
	$exp10   = $worksheet->getCell('X'.$row)->getCalculatedValue();
	$exp11   = $worksheet->getCell('Y'.$row)->getCalculatedValue();
	//$exp11 = $worksheet->getCell('W')->getCalculatedValue();
	$exp12    = $worksheet->getCell('Z'.$row)->getCalculatedValue();
	$exp13    = $worksheet->getCell('AA'.$row)->getCalculatedValue();
	$exp14    = $worksheet->getCell('AB'.$row)->getCalculatedValue();
	$exp15    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp16    ="";
	$exp17    ="";
	$exp18    ="";
	$exp19    ="";
	$exp20    ="";
	$exp21    ="";
	$exp22    = "";
	$exp23    = "";
	$exp24    = "";
	$exp25    = "";

	$exp_text1    = "ภาษี หัก ณ ที่จ่าย";
	$exp_text2    = "สหกรณ์กรมการแพทย์";
	$exp_text3    = "ฌาปนกิจ";
	$exp_text4    = "สหกรณ์กรมควบคุมโรค";
	$exp_text5    = "ธนาคารออมสิน";
	$exp_text6    = "ธนาคารอาคารสงเคราะห์";
	$exp_text7    = "ธนาคารกรุงไทย";
	$exp_text8    = "ค่าไฟฟ้า";
	$exp_text9   = "ค่าประปา";
	$exp_text10  = "ประกันชีวิต AIA";
	$exp_text11  = "สะสม กสจ";
	$exp_text12   = "คืนเงิน ต.พ.จ.ว319";
	$exp_text13    = "คืนเงิน ต.พ.จ.ว319 ปีภาษีเก่า";
	$exp_text14    = "สะสม กสจ ตกเบิก";
	$exp_text15    = "";
	$exp_text16    = "";
	$exp_text17    = "";
	$exp_text18    = "";
	$exp_text19    = "";
	$exp_text20    = "";
	$exp_text21    = "";
	$exp_text22    = "";
	$exp_text23    = "";
	$exp_text24    = "";
	$exp_text25    = "";

}// type5

/****************** ข้าราชการ ********************/
else if ($action == '1' ) { 
	$idno    = $worksheet->getCell('C'.$row)->getCalculatedValue(); ///อาจจะต้องดูอีกที
	$idno = str_replace("-","",$idno);
	$idno = str_replace(" ","",$idno);

	$position = $worksheet->getCell('D'.$row)->getCalculatedValue();
	$department    = $worksheet->getCell('E'.$row)->getCalculatedValue();
	//$bankno    = $worksheet->getCell('F'.$row)->getCalculatedValue();
	//$bankno    = "";
	//$bankid = "ธนาคารกรุงไทย";
	$bankno    = $worksheet->getCell('I'.$row)->getCalculatedValue();
	$bankid = $worksheet->getCell('H'.$row)->getCalculatedValue();

	$password    = md5($idno);
	
	$mobile = "";
//echo "idno11  = $idno ,position = $position, department= $department <Br>";


	/*Slip*/
	$money1    = $worksheet->getCell('J'.$row)->getCalculatedValue();
	$money2    = $worksheet->getCell('K'.$row)->getCalculatedValue();
	$money3    = $worksheet->getCell('L'.$row)->getCalculatedValue();
	$money4    = $worksheet->getCell('M'.$row)->getCalculatedValue();
	$money5    = $worksheet->getCell('N'.$row)->getCalculatedValue();
	$money6    = $worksheet->getCell('O'.$row)->getCalculatedValue();
	$money7    = $worksheet->getCell('P'.$row)->getCalculatedValue();
	$money8    = $worksheet->getCell('Q'.$row)->getCalculatedValue();
	$money9    = $worksheet->getCell('R'.$row)->getCalculatedValue();
	$money10  = $worksheet->getCell('S'.$row)->getCalculatedValue();
	$money11 = $worksheet->getCell('T'.$row)->getCalculatedValue();
	$money12 = $worksheet->getCell('U'.$row)->getCalculatedValue();
	$money13 = $worksheet->getCell('V'.$row)->getCalculatedValue();

	$money14 = $worksheet->getCell('W'.$row)->getCalculatedValue();
	$money15 = $worksheet->getCell('X'.$row)->getCalculatedValue();

	

	$money_text1    = "เงินเดือน";
	$money_text2    = "เงินเดือนตกเบิก";
	$money_text3    = "งบสก (ปจต.) ";
	$money_text4    = "งบสก ตกเบิก ปจต. ตกเบิก";
	$money_text5    = "ตขท ปจต";
	$money_text6    = "ตขท ปจต ตกเบิก";
	$money_text7    = "ต.ข.8-8ว";
	$money_text8    = "ต.ข.8-8ว ตกเบิก";
	$money_text9    = "ต.พ.ข. ว 319";
	$money_text10  = "ต.พ.ข. ว 319 ตกเบิก";
	$money_text11  = "ต.ด.ข1-7";
	$money_text12  = "พ.ค.ช.ข";
	$money_text13  = "พ.ค.ช.ข ตกเบิก";
	$money_text14  = "พ.พ.ด";
	$money_text15  = "พ.พ.ด (ตกเบิก)";

	$exp1    = $worksheet->getCell('Z'.$row)->getCalculatedValue();
	$exp2    = $worksheet->getCell('AA'.$row)->getCalculatedValue();
	$exp3    = $worksheet->getCell('AB'.$row)->getCalculatedValue();
	$exp4    = $worksheet->getCell('AC'.$row)->getCalculatedValue();
	$exp5    = $worksheet->getCell('AD'.$row)->getCalculatedValue();
	$exp6    = $worksheet->getCell('AE'.$row)->getCalculatedValue();
	$exp7    = $worksheet->getCell('AF'.$row)->getCalculatedValue();
	$exp8   = $worksheet->getCell('AG'.$row)->getCalculatedValue();
	$exp9   = $worksheet->getCell('AH'.$row)->getCalculatedValue();
	$exp10    = $worksheet->getCell('AI'.$row)->getCalculatedValue();
	$exp11    = $worksheet->getCell('AJ'.$row)->getCalculatedValue();
	$exp12    = $worksheet->getCell('AK'.$row)->getCalculatedValue();
	$exp13    = $worksheet->getCell('AL'.$row)->getCalculatedValue();
	$exp14    = $worksheet->getCell('AM'.$row)->getCalculatedValue();
	$exp15    = $worksheet->getCell('AN'.$row)->getCalculatedValue();
	$exp16    = $worksheet->getCell('AO'.$row)->getCalculatedValue();
	$exp17    = $worksheet->getCell('AP'.$row)->getCalculatedValue();
	$exp18    = $worksheet->getCell('AQ'.$row)->getCalculatedValue();
	$exp19    = $worksheet->getCell('AR'.$row)->getCalculatedValue();

	$exp20    = $worksheet->getCell('AS'.$row)->getCalculatedValue();
	$exp21    = $worksheet->getCell('AT'.$row)->getCalculatedValue();
	$exp22    = $worksheet->getCell('AU'.$row)->getCalculatedValue();
	$exp23    = '';
	$exp24    = '';	
	$exp25    = '';


	$exp_text1    = "สะสม กบข";
	$exp_text2    = "สะสม กบข ตกเบิก";
	$exp_text3    = "สะสม กบข ส่วนเพิ่ม";
	$exp_text4    = "สะสม กบข ตกเบิก ส่วนเพิ่ม";
	$exp_text5    = "ภาษีรายเดือน";
	$exp_text6    = "ภาษี ตกเบิก";
	$exp_text7    = "กยศ";
	$exp_text8    = "กรอ.";
	$exp_text9   = "สหกรณ์กรมการแพทย์";
	$exp_text10  = "ฌาปนกิจ";
	$exp_text11  = "สหกรณ์กรมควบคุมโรค";
	$exp_text12   = "ธนาคารออมสิน";
	$exp_text13    = "ธ.อ.ส.";
	$exp_text14    = "ธนาคารกรุงไทย";
	$exp_text15    = "ไฟฟ้า";
	$exp_text16    = "ประปา";
	$exp_text17    = "บ้านพัก";
	$exp_text18    = "AIA";
	$exp_text19    = "รค.งด. ปีภาษีเก่า";
	$exp_text20    = "ส่งคืนเงินเดือน";
	$exp_text21    = "ธนาคารอิสลาม";
	$exp_text22    = " สหกรณ์อื่นๆ";
	$exp_text23    = "";
	$exp_text24    = "";
	$exp_text25    = "";

}// type1


/****************** ลูกจ้างชั่วคราว ********************/
if ($action == '6' ) { 
	$idno    = $worksheet->getCell('C'.$row)->getCalculatedValue(); ///อาจจะต้องดูอีกที
	$idno = str_replace("-","",$idno);
	$idno = str_replace(" ","",$idno);

	$position = $worksheet->getCell('D'.$row)->getCalculatedValue();
	$department    = $worksheet->getCell('E'.$row)->getCalculatedValue();
	$bankno    = $worksheet->getCell('G'.$row)->getCalculatedValue();
	$password    = md5($idno);
	$bankid = $worksheet->getCell('F'.$row)->getCalculatedValue();
	$mobile = "";

	/*Slip*/
	$money1    = $worksheet->getCell('H'.$row)->getCalculatedValue();
	$money2    = $worksheet->getCell('I'.$row)->getCalculatedValue();
	$money3    = '';
	$money4    = '';
	$money5    = '';
	$money6    = '';
	$money7    = '';
	$money8    = '';
	$money9    = '';
	$money10  = '';
	$money11 = "";
	$money12 = "";
	$money13 = "";
	$money14 = "";
	$money15 = "";

	$money_text1    = "ค่าจ้าง";
	$money_text2    = "ตกเบิก";
	$money_text3    = "";
	$money_text4    = "";
	$money_text5    = "";
	$money_text6    = "";
	$money_text7    = "";
	$money_text8    = "";
	$money_text9    = "";
	$money_text10  = "";
	$money_text11  = "";
	$money_text12  = "";
	$money_text13  = "";
	$money_text14  = "";
	$money_text15  = "";

	$exp1    = $worksheet->getCell('J'.$row)->getCalculatedValue();
	$exp2    = $worksheet->getCell('K'.$row)->getCalculatedValue();
	$exp3    = $worksheet->getCell('L'.$row)->getCalculatedValue();
	$exp4    = $worksheet->getCell('M'.$row)->getCalculatedValue();
	$exp5    = $worksheet->getCell('N'.$row)->getCalculatedValue();
	$exp6    = $worksheet->getCell('O'.$row)->getCalculatedValue();
	$exp7    = $worksheet->getCell('P'.$row)->getCalculatedValue();
	$exp8    = $worksheet->getCell('Q'.$row)->getCalculatedValue();
	$exp9    = $worksheet->getCell('R'.$row)->getCalculatedValue();
	$exp10    = $worksheet->getCell('S'.$row)->getCalculatedValue();
	$exp11    = $worksheet->getCell('T'.$row)->getCalculatedValue();
	$exp12    = $worksheet->getCell('U'.$row)->getCalculatedValue();
	$exp13    = $worksheet->getCell('V'.$row)->getCalculatedValue();
	$exp14    = "";
	$exp15    = "";
	$exp16    ="";
	$exp17    ="";
	$exp18    ="";
	$exp19    ="";
	$exp20    ="";
	$exp21    ="";
	$exp22    = "";
	$exp23    = "";
	$exp24    = "";
	$exp25    = "";

	$exp_text1    = "ฌาปนกิจ";
	$exp_text2    = "สหกรณ์กรมการแพทย์";
	$exp_text3    = "ประกันสังคม 5%";
	$exp_text4    = "วันลา/คืนค่าจ้าง";
	$exp_text5    = "ค่าไฟฟ้า";
	$exp_text6    = "ค่าน้ำประปา";
	$exp_text7    = "ค่าทำความทำความสะอาด";
	$exp_text8    = "ประกันชีวิต AIA";
	$exp_text9    = "ธนาคารออมสิน";
	$exp_text10  = "ภาษี";
	$exp_text11    = "สหกรณ์กรมควบคุมโรค";
	$exp_text12    = "ธนาคารกรุงไทย";
	$exp_text13    = "กยศ/กรอ";
	$exp_text14    = "";
	$exp_text15    = "";
	$exp_text16    = "";
	$exp_text17    = "";
	$exp_text18    = "";
	$exp_text19    = "";
	$exp_text20    = "";
	$exp_text21    = "";
	$exp_text22    = "";
	$exp_text23    = "";
	$exp_text24    = "";
	$exp_text25    = "";


}// type6

//echo "money13= $money13<Br> money14= $money14<Br> money15= $money15<Br>";


/***********************************************************************************************************************/


$summoney = $money1+$money2+$money3+$money4+$money5+$money6+$money7+$money8+$money9+$money10
						+$money11+$money12+$money13+$money14+$money15;
$sumexp = $exp1+$exp2+$exp3+$exp4+$exp5+$exp6+$exp7+$exp8+$exp9+$exp10+$exp11+$exp12+$exp13+$exp14+$exp15
					+$exp16+$exp17+$exp18+$exp19+$exp20+$exp21+$exp22+$exp23+$exp24+$exp25;

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
	values ('$action','$prename','$name','$surname','$bankno','$idno','$position','$department','$password','$bankid','$mobile','$note','$dates','1','0','$suserid','$dates','$times','$suserid','$dates','$times')
	";

	$result_e = mysql_query($sql_e);
	$empid = mysql_insert_id();

	//echo " sql = $sql_e <br> result = $result_e<br></br>";

	$sql_u ="insert user(USER_NAME,empid,emptypeid,USERNAME_ID,USER_PASSWORD,USERLEVEL_ID,DEPART_ID,USER_EMAIL,USER_PHONE,USER_LOGO,USER_LASTLOGIN_DATE,USER_LASTLOGIN_TIME,ACTIVE,ACTIVE_DATE,NOTE,INVALID_FLAG,CREATE_USER,CREATE_DATE,CREATE_TIME,UPDATE_USER,UPDATE_DATE,UPDATE_TIME)  

	values('$USER_NAME','$empid','$action','$idno','$password','1','$department','$USER_EMAIL','$USER_PHONE','$USER_LOGO','$USER_LASTLOGIN_DATE','$USER_LASTLOGIN_TIME','$ACTIVE','$ACTIVE_DATE','$NOTE','$INVALID_FLAG','$suserid','$dates','$times','$suserid','$dates','$times') ";
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

//////////////// save t.sliponline ประจำเดือน

//if ($idno <> '') {
if ( is_numeric($idno) ) {

$sql_s = "select *from slip where empid = '$empid' and yy='$yy5' and mm = '$mm5' and emptypeid = '$action'   ";

$result_s = mysql_query($sql_s);
$num_s = mysql_num_rows($result_s);


//echo "sql_s = $sql_s <Br> result_s=$result_s<Br>";
//echo "num_s = $num_s <Br>";
//echo " summoney = $summoney ,sumexp = $sumexp,sumnet  = $sumnet <Br>";
if ($num_s == '0') {
		$sql = "insert
		slip(empid,datepay,yy,mm,idno,nobank,emptypeid,money1,money2,money3,money4,money5,money6,money7,money8,money9,money10
		,money11,money12,money13,money14,money15,
		money_text1,money_text2,money_text3,money_text4,money_text5,money_text6,money_text7,money_text8,money_text9,money_text10
		,money_text11,money_text12,money_text13,money_text14,money_text15,
		exp1,exp2,exp3,exp4,exp5,exp6,exp7,exp8,exp9,exp10,exp11,exp12,exp13,exp14,exp15
		,exp16,exp17,exp18,exp19,exp20,exp21
		,exp22,exp23,exp24,exp25
		,exp_text1,exp_text2,exp_text3,exp_text4,exp_text5,exp_text6,exp_text7,exp_text8,exp_text9,exp_text10,exp_text11,exp_text12,exp_text13,exp_text14,exp_text15,exp_text16,exp_text17,exp_text18,exp_text19,exp_text20,exp_text21,exp_text22,exp_text23,exp_text24,exp_text25,summoney,sumexp,sumnet,notes,remarks,invalid_flag,create_user,create_date,create_time,update_user,update_date,update_time)

		values('$empid','$datepay','$yy5','$mm5','$idno','$bankno','$action','$money1','$money2','$money3','$money4','$money5','$money6','$money7','$money8','$money9','$money10','$money11','$money12','$money13','$money14','$money15'
		,'$money_text1','$money_text2','$money_text3','$money_text4','$money_text5','$money_text6','$money_text7','$money_text8','$money_text9','$money_text10','$money_text11','$money_text12','$money_text13','$money_text14','$money_text15','$exp1','$exp2','$exp3','$exp4','$exp5','$exp6','$exp7','$exp8','$exp9','$exp10','$exp11','$exp12','$exp13','$exp14','$exp15','$exp16','$exp17','$exp18','$exp19','$exp20','$exp21'
		,'$exp22','$exp23','$exp24','$exp25'
		,'$exp_text1','$exp_text2','$exp_text3','$exp_text4','$exp_text5','$exp_text6','$exp_text7','$exp_text8','$exp_text9','$exp_text10','$exp_text11','$exp_text12','$exp_text13','$exp_text14','$exp_text15','$exp_text16','$exp_text17','$exp_text18','$exp_text19','$exp_text20','$exp_text21','$exp_text22','$exp_text23','$exp_text24','$exp_text25','$summoney','$sumexp','$sumnet','','','0','$suserid','$dates','$times','$suserid','$dates','$times')

		";

$jj++;

}//notsame slip

else {
//echo "slip same <Br>";


		$sql = "update slip set 
		datepay='$datepay',yy='$yy5',mm='$mm5',idno='$idno',nobank='$bankno',emptypeid='$action'
		,money1='$money1',money2='$money2',money3='$money3',money4='$money4',money5='$money5',money6='$money6',money7='$money7',money8='$money8',money9='$money9',money10='$money10',
		money11='$money11',money12='$money12',money13='$money13',money14='$money14',money15='$money15',

		money_text1='$money_text1',money_text2='$money_text2',money_text3='$money_text3',money_text4='$money_text4',money_text5='$money_text5',money_text6='$money_text6',money_text7='$money_text7',money_text8='$money_text8',money_text9='$money_text9',money_text10='$money_text10',
		money_text11='$money_text11',money_text12='$money_text12',money_text13='$money_text13',money_text14='$money_text14',money_text15='$money_text15',

		exp1='$exp1',exp2='$exp2',exp3='$exp3',exp4='$exp4',exp5='$exp5',exp6='$exp6',exp7='$exp7',exp8='$exp8',exp9='$exp9',exp10='$exp10',exp11='$exp11',exp12='$exp12',exp13='$exp13',exp14='$exp14',exp15='$exp15',
		exp16='$exp16',exp17='$exp17',exp18='$exp18',exp19='$exp19',exp20='$exp20',exp21='$exp21'
		,exp22='$exp22',exp23='$exp23',exp24='$exp24',exp25='$exp25'
		,exp_text1='$exp_text1',exp_text2='$exp_text2',exp_text3='$exp_text3',exp_text4='$exp_text4',exp_text5='$exp_text5',exp_text6='$exp_text6',exp_text7='$exp_text7',exp_text8='$exp_text8',exp_text9='$exp_text9',exp_text10='$exp_text10',exp_text11='$exp_text11',exp_text12='$exp_text12',exp_text13='$exp_text13',exp_text14='$exp_text14',exp_text15='$exp_text15',
		exp_text16='$exp_text16',exp_text17='$exp_text17',exp_text18='$exp_text18',exp_text19='$exp_text19',exp_text20='$exp_text20',exp_text21='$exp_text21'
		,exp_text22='$exp_text22',exp_text23='$exp_text23',exp_text24='$exp_text24',exp_text25='$exp_text25',
		summoney='$summoney',sumexp='$sumexp',sumnet='$sumnet',invalid_flag='0',update_user='$suserid',update_date='$dates',update_time='$times'
		where  empid = '$empid' and yy='$yy5' and mm = '$mm5' ";

$jj++;
} //edit slip


$result = mysql_query($sql);
//echo "sql = $sql , result = $result<br><hr>";
//exit();

$sqle = " update employee set 
 prename='$prename',name='$name',lastname='$surname',bankno='$bankno',idno='$idno',position='$position',department='$department',password='$password',bankid='$bankid',mobile='$mobile',note='$note',invalid_flag='0',update_user='$suserid',update_date='$dates',update_time='$times'
where empid = '$empid'  ";

$resulte = mysql_query($sqle);
//echo "sql = $sqle , result = $resulte<br><hr>";
//exit();

}//have id no


$ii++;
}//For 

$sql_f = "insert fileupload(namefile,slipnums,empnums,emptypeid,CREATE_USER,CREATE_DATE,CREATE_TIME) 
values ('$file_newname','$jj','$kk','$action','$suserid','$dates','$times') ";
$result_f = mysql_query($sql_f);

//echo "sql = $sql_f <br> Result = $result_f <br>";

echo " <meta http-equiv=\"refresh\" content=\"0;url=../complete.php?action=$action&mm=$mm5&yy=$yy5\"> ";

?>