<?php 
session_start();
require('../database.php');
require_once('../necessaryClass/user.php');
$depoUserId=$obj->userLoginId();//depo user id
$depoEditId=(int)$_POST['depoEditId'];//depo edit id
$uploader=$obj->userName();//uploader name
$firstName=trim(htmlspecialchars($_POST['firstName']));
$lastName=trim(htmlspecialchars($_POST['lastName']));
$birthDate=$_POST['birthDate'];
$dateModify=date('d-m-Y',strtotime($birthDate));
$nid=(int)trim($_POST['nid']);
$phone=trim($_POST['phone']);
$email=trim($_POST['email']);
$webSite=trim(htmlspecialchars($_POST['webSite']));
$upazilla=trim(htmlspecialchars($_POST['upazilla']));
$district=trim(htmlspecialchars($_POST['district']));
$division=trim(htmlspecialchars($_POST['division']));
$street=trim(htmlspecialchars($_POST['street']));
$oldPicName=$_POST['oldPicName'];// Old picture Name
$profilePicture=$_FILES['newPicture'];
$picName=$_FILES['newPicture']['name'];
$tmp_name=$_FILES['newPicture']['tmp_name'];
$fileType=$_FILES['newPicture']['type'];
$explode=explode('.',$picName);
$ext=end($explode);
$sha1pic=sha1($picName).'.'.$ext;
$uploadFolder="../depoPhoto/".$sha1pic;
$fileExt=array("jpg","png","jpeg","gif","bmp","JPG","PNG","JPEG","GIF","BMP");

if(empty($picName)){
	if(!empty($firstName) && !empty($lastName) && !empty($dateModify) && !empty($nid) && !empty($phone) && !empty($email) && !empty($upazilla) && !empty($district) && !empty($division) && !empty($street)){
		$depoEditQuery=$db->prepare("UPDATE depo SET user_id=?,first_name=?,last_name=?,birthDate=?,nid=?,phone=?,email=?,upazilla=?,district=?,division=?,street=?,uploader=?,picture=? WHERE id=?");
		$depoEditQuery->bindParam(1,$depoUserId);
		$depoEditQuery->bindParam(2,$firstName);
		$depoEditQuery->bindParam(3,$lastName);
		$depoEditQuery->bindParam(4,$dateModify);
		$depoEditQuery->bindParam(5,$nid);
		$depoEditQuery->bindParam(6,$phone);
		$depoEditQuery->bindParam(7,$email);
		$depoEditQuery->bindParam(8,$upazilla);
		$depoEditQuery->bindParam(9,$district);
		$depoEditQuery->bindParam(10,$division);
		$depoEditQuery->bindParam(11,$street);
		$depoEditQuery->bindParam(12,$uploader);
		$depoEditQuery->bindParam(13,$oldPicName);
		$depoEditQuery->bindParam(14,$depoEditId);
		if($depoEditQuery->execute()){
			$_SESSION['depoEditMsg']="<p class='alert alert-success'>Data update query successful</p>";
			header("Location:../index.php?page=depoInfoEdit&folder=depoinfo&depoInfoEditId=$depoEditId");
		}else{
			$_SESSION['depoEditMsg']="<p class='alert alert-danger'>System error</p>";
			header("Location:../index.php?page=depoInfoEdit&folder=depoinfo&depoInfoEditId=$depoEditId");
		}
	}else{
		echo"";
		$_SESSION['depoEditMsg']="<p class='alert alert-warning'>Please insert your data</p>";
		header("Location:../index.php?page=depoInfoEdit&folder=depoinfo&depoInfoEditId=$depoEditId");
	}
}else{
	if(!empty($firstName) && !empty($lastName) && !empty($dateModify) && !empty($nid) && !empty($phone) && !empty($email) && !empty($upazilla) && !empty($district) && !empty($division) && !empty($street)){
	
			if(in_array($ext, $fileExt)){
			$depoEditQuery=$db->prepare("UPDATE depo SET user_id=?,first_name=?,last_name=?,birthDate=?,nid=?,phone=?,email=?,upazilla=?,district=?,division=?,street=?,uploader=?,picture=? WHERE id=?");
			$depoEditQuery->bindParam(1,$depoUserId);
			$depoEditQuery->bindParam(2,$firstName);
			$depoEditQuery->bindParam(3,$lastName);
			$depoEditQuery->bindParam(4,$dateModify);
			$depoEditQuery->bindParam(5,$nid);
			$depoEditQuery->bindParam(6,$phone);
			$depoEditQuery->bindParam(7,$email);
			$depoEditQuery->bindParam(8,$upazilla);
			$depoEditQuery->bindParam(9,$district);
			$depoEditQuery->bindParam(10,$division);
			$depoEditQuery->bindParam(11,$street);
			$depoEditQuery->bindParam(12,$uploader);
			$depoEditQuery->bindParam(13,$sha1pic);
			$depoEditQuery->bindParam(14,$depoEditId);
				if($depoEditQuery->execute()){
					move_uploaded_file($tmp_name,$uploadFolder);
					$_SESSION['depoEditMsg']="<p class='alert alert-success'>Data update query successful</p>";
					header("Location:../index.php?page=depoInfoEdit&folder=depoinfo&depoInfoEditId=$depoEditId");
				}else{
					$_SESSION['depoEditMsg']="<p class='alert alert-danger'>System error</p>";
					header("Location:../index.php?page=depoInfoEdit&folder=depoinfo&depoInfoEditId=$depoEditId");
				}
			}else{
				$_SESSION['depoEditMsg']="<p class='alert alert-warning'>we don't allowed this file type</p>";
				header("Location:../index.php?page=depoInfoEdit&folder=depoinfo&depoInfoEditId=$depoEditId");
			}
	}else{
		$_SESSION['depoEditMsg']="<p class='alert alert-warning'>Please insert your data</p>";
		header("Location:../index.php?page=depoInfoEdit&folder=depoinfo&depoInfoEditId=$depoEditId");
	}
}
?>