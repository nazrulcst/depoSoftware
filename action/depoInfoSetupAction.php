<?php
require('../database.php');
session_start();
require_once('../necessaryClass/user.php');
if(!$obj->userName()){
	$_SESSION['depoMsg']="<p class='alert alert-danger'>You are not permited user</p>";
	header("Location:../index.php?page=depoInfoSetup&folder=depoinfo");
	exit();
}
$uploader=$obj->userName();//uploader this point
$userId=$obj->userLoginId();//uploader id
$depoName=trim(htmlspecialchars($_POST['depoName']));
$firstName=trim(htmlspecialchars($_POST['firstName']));
$lastName=trim(htmlspecialchars($_POST['lastName']));
$birthDate=trim($_POST['birthDate']);
$modifyDate=date('d/m/y',strtotime($birthDate));
$nid=trim((int)$_POST['nid']);
$phone=trim((int)$_POST['phone']);
$email=trim(htmlspecialchars($_POST['email']));
$webSite=trim($_POST['webSite']);
$upazilla=trim(htmlspecialchars($_POST['upazilla']));
$district=trim(htmlspecialchars($_POST['district']));
$division=htmlspecialchars($_POST['division']);
$street=trim(htmlspecialchars($_POST['street']));
//profile picture received & upload process
$file=$_FILES['ppicture'];
$fileName=$_FILES['ppicture']['name'];
$fileType=$_FILES['ppicture']['type'];
$fileTempName=$_FILES['ppicture']['tmp_name'];
$fileSize=$_FILES['ppicture']['size'];
$explode=explode('.',$fileName);
$ext=end($explode);
$sha1=sha1($fileName);
$uploadFileName=$sha1.'.'.$ext;
$upload_dir='../depoPhoto/'.$uploadFileName;
//check the already you have a account
$selDepoUserId=$db->prepare("SELECT depo.*,user.id FROM depo LEFT JOIN user ON depo.user_id=user.id WHERE user_id=?");
$selDepoUserId->bindParam(1,$userId);
$selDepoUserId->execute();
$selDepoUserRow=$selDepoUserId->fetch(PDO::FETCH_ASSOC);
$haveUserId=$selDepoUserRow['user_id'];
if($haveUserId){
	$_SESSION['depoMsg']="<p class='alert alert-info'>Already you have a depo account</p>";
	header("Location:../index.php?page=depoInfoSetup&folder=depoinfo");
}else{
	if(!empty($depoName) && !empty($firstName) && !empty($lastName) && !empty($birthDate) && !empty($nid) && !empty($phone) && !empty($email) && !empty($upazilla) && !empty($district) && !empty($division) && !empty($street) && !empty($file)) {//start the insertion our depo information
	if($ext=="jpg" OR $ext=="JPG"  OR $ext=="png" OR $ext=="PNG" OR $ext=="jpeg" OR $ext=="JPEG" OR $ext=="gif" OR $ext=="GIF"){
		$depoInfo=$db->prepare("INSERT INTO depo SET user_id=?,depo_name=?,first_name=?,last_name=?,birthDate=?,nid=?,phone=?,email=?,website=?,upazilla=?,district=?,division=?,street=?,uploader=?,picture=?");
		$depoInfo->bindParam(1,$userId);
		$depoInfo->bindParam(2,$depoName);
		$depoInfo->bindParam(3,$firstName);
		$depoInfo->bindParam(4,$lastName);
		$depoInfo->bindParam(5,$modifyDate);
		$depoInfo->bindParam(6,$nid);
		$depoInfo->bindParam(7,$phone);
		$depoInfo->bindParam(8,$email);
		$depoInfo->bindParam(9,$webSite);
		$depoInfo->bindParam(10,$upazilla);
		$depoInfo->bindParam(11,$district);
		$depoInfo->bindParam(12,$division);
		$depoInfo->bindParam(13,$street);
		$depoInfo->bindParam(14,$uploader);
		$depoInfo->bindParam(15,$uploadFileName);//Depo information close
		if($depoInfo->execute()){
			move_uploaded_file($fileTempName, $upload_dir);
			$_SESSION['depoMsg']="<p class='alert alert-success'>Successfully data inserted</p>";
			header("Location:../index.php?page=depoInfoSetup&folder=depoinfo");
		}else{
			$db->rollback();
			$_SESSION['depoMsg']="<p class='alert alert-warning'>Submited query failed !</p>";
			header("Location:../index.php?page=depoInfoSetup&folder=depoinfo");
		}
	}else{
		$_SESSION['depoMsg']="<p class='alert alert-danger'>This file type don't allowed here !</p>";
		header("Location:../index.php?page=depoInfoSetup&folder=depoinfo");
	}	
}else{
	$_SESSION['depoMsg']="<p class='alert alert-warning'>Please insert your information !!</p>";
	header("Location:../index.php?page=depoInfoSetup&folder=depoinfo");
}
}












