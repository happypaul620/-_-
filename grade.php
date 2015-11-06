<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>grade.php</title>
</head>
<body>
<?php
//=========================連線資料庫==========================
	$link=mysql_connect("localhost","root","555888") or die("連線失敗：".mysql_error());
	mysql_select_db("grade")or die("無法選擇資料庫");

//=========================接收變數============================
	echo $_POSE["name"];
	echo $_POSE["ID"];
	echo $_POSE["email"];
	echo $_POSE["chinese"];
	echo $_POSE["english"];
	echo $_POSE["mathematics"];
	echo $_POSE["physics"];
	echo $_POSE["chemical"];
	
//=========================檢查姓名欄位函數==========================
function check_name($name){
	if($name!='')
	{
		if(preg_match("/[0-9]/", $name))
		{
			echo("姓名中不能有數字喔\n");
			return false;
		}
		else
		{
			//echo("姓名正確\n");;
			return true;
		}
	}
	else
	{
		echo("你沒有輸入姓名喔\n");
		return false;
	}
}
//=========================檢查學號欄位函數========================
function check_ID($ID){
	if($ID!='')
	{
		$pattern = "/[0-9]{8}/";
		
		if(preg_match($pattern,$ID))
		{
			//echo("學號正確\n");
			return true;
		}
		else
		{
			echo("學號要輸入8位數字喔\n");
			return false;
		}
	}
	else
	{
		echo("你沒有輸入學號喔\n");
		return false;
	}
}
//=========================檢查信箱欄位函數=========================
function check_email($email){
	if($email!='')
	{	
		if(preg_match("/^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$/", $email))
		{
			//echo("信箱格式正確\n");
			return true;
		}
		else
		{
			echo("信箱格式錯誤\n");
			return false;
		}
	}
	else
	{
		echo("你沒有輸入信箱喔\n");
		return false;
	}	
}
//=========================檢查成績欄位函數=========================
function check_grade($chinese,$english,$mathematics,$physics,$chemical){

	if($chinese!='')
	{	
		if($chinese<=100&&$chinese>=0)
		{
			//echo("國文成績正確\n");
		}
		else
		{
			echo("國文成績輸入要介於0~100喔\n");
		}
	}
	else
	{
		echo("你沒有輸入國文成績喔\n");
		return false;
	}
	
	if($english!='')
	{
		if($english<=100&&$english>=0)
		{
			//echo("英文成績正確\n");
		}
		else
		{
			echo("英文成績輸入要介於0~100喔\n");
		}
	}
	else
	{
		echo("你沒有輸入英文成績喔\n");
		return false;
	}
	
	if($mathematics!='')
	{
		if($mathematics<=100&&$mathematics>=0)
		{
			//echo("數學成績正確\n");
		}
		else
		{
			echo("數學成績輸入要介於0~100喔\n");
		}
	}
	else
	{
		echo("你沒有輸入數學成績喔\n");
		return false;
	}
	
	if($physics!='')
	{
		if($physics<=100&&$physics>=0)
		{
			//echo("物理成績正確\n");
		}
		else
		{
			echo("物理成績輸入要介於0~100喔\n");
		}
	}
	else
	{
		echo("你沒有輸入物理成績喔\n");
		return false;
	}
	
	if($chemical!='')
	{
		if($chemical<=100&&$chemical>=0)
		{
			//echo("化學成績正確\n");
		}
		else
		{
			echo("化學成績輸入要介於0~100喔\n");
		}
	}
	else
	{
		echo("你沒有輸入化學成績喔\n");
		return false;
	}
	
	if($chinese<=100&&$chinese>=0&&$english<=100&&$english>=0&&$mathematics<=100&&$mathematics>=0&&$physics<=100&&$physics>=0&&$chemical<=100&&$chemical>=0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

$sum=$chinese+$english+$mathematics+$physics+$chemical;
$average=$sum / 5;

//=================================呼叫函數==================================

if(check_name($name)&&check_ID($ID)&&check_email($email)&&check_grade($chinese,$english,$mathematics,$physics,$chemical)==1){

//=================================寫入到grade.txt==================================
$filename = 'grade.txt';
$content = $name." ".$ID." ".$email." ".$chinese." ".$english." ".$mathematics." ".$physics." ".$chemical." ".$sum." ".$average;

if(is_writable($filename)){

	$fopen = fopen($filename, 'a');
	if($fopen == false)
	{
		echo '無法開啟檔案： '.$filename;
		exit;
	}

	$fwrite = fwrite($fopen, "$content\r\n");
	if($fwrite == false)
	{
		echo '檔案寫入失敗: '.$filename;
		exit;
	}
	
	echo '寫入檔案成功 開啟瞧瞧吧: <a href="'. $filename .'">'. $filename. '</a><br>';
	
	fclose($fopen);
}

//=================================寫入到MySQL內======================================
$query="INSERT INTO avg_grade(name,ID,email,chinese_grade,english_grade,mathematics_grade,physics_grade,chemical_grade,sum,average)VALUES
('$name','$ID','$email','$chinese','$english','$mathematics','$physics','$chemical','$sum','$average')";
$result=mysql_query($query) or die("資料輸入錯誤：".mysql_error());
mysql_close($link);
echo '輸入資料成功';
}
?>
</body>
</html>


