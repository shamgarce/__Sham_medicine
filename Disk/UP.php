<?php
///*****************************************  
//Title :文件上传详解  
//*****************************************/  
define('FCPATH', '');

$uploaddir = "../A/upload/";					//设置文件保存目录 注意包含/      
$uploaddirre = "/A/upload/";					//设置文件保存目录 注意包含/      

$type=array("jpg","gif","bmp","jpeg","png");	//设置允许上传文件的类型   
//--------------------------------------------------------------
function fileext($filename){  
	return substr(strrchr($filename, '.'), 1);  
} 

function random($length){  
	$hash = 'CR-';  
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';  
	$max = strlen($chars) - 1;  
	mt_srand((double)microtime() * 1000000);  
	for($i = 0; $i < $length; $i++){  
		$hash .= $chars[mt_rand(0, $max)];  
	}  
	return $hash;
}

echo json_encode($_FILES);
exit;

//--------------------------------------------------------------
if(!in_array(strtolower(fileext($_FILES['file']['name'])),$type)){  
	$text=implode(",",$type);  
		
	$res['code'] = -100;
	$res['msg'] = '您只能上传以下类型文件 "jpg","gif","bmp","jpeg","png"';
	$res['img'] = '/upload/n.pic';
	//$res['file'] = 'a.html';
	$strjson = json_encode($res);
	echo '<script type="text/javascript">';
	echo "window.top.window.stopUpload($strjson)";
	echo '</script>';
	exit;
}

if ($_FILES["file"]["size"] > 40000000){
	$res['code'] = -100;
	$res['msg'] = '超出文件大小限制';
	$res['img'] = '/upload/n.pic';
	//$res['file'] = 'a.html';
	$strjson = json_encode($res);
	echo '<script type="text/javascript">';
	echo "window.top.window.stopUpload($strjson)";
	echo '</script>';
	exit;
}

$filenames = random(10).'.'.fileext($_FILES['file']['name']);

$uploadfile = $uploaddir.$filenames;
$uploadfilere = $uploaddirre.$filenames;

//--------------------------------------------------------------
if (move_uploaded_file($_FILES['file']['tmp_name'],$uploadfile)){
	if (file_exists($uploadfile)) {
		$res['code'] = 200;
		$res['msg'] = '超出文件大小限制';
		$res['img'] = $uploadfilere;
		//$res['file'] = 'a.html';
		$strjson = json_encode($res);
		echo '<script type="text/javascript">';
		echo "window.top.window.stopUpload($strjson)";
		echo '</script>';
		exit;
	}else{
		$res['code'] = -200;
		$res['msg'] = '上传失败';
		$res['img'] = $uploadfile;
		//$res['file'] = 'a.html';
		$strjson = json_encode($res);
		echo '<script type="text/javascript">';
		echo "window.top.window.stopUpload($strjson)";
		echo '</script>';
		exit;
	}
//	if(is_uploaded_file($_FILES['file']['tmp_name'])){
}




