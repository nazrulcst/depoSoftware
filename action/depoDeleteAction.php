<?php
  session_start();
  require('../database.php');
  include_once('../necessaryClass/user.php');
  if(!$obj->userType()){
  	$_SESSION['delDepoMsg']="<p class='alert alert-danger'>you have no right!</p>";
    header("Location:../index.php?page=viewAlldepoList&folder=setup");
  	exit();
  }
  if(!isset($_GET['depoDelid'])){
    $_SESSION['delDepoMsg']="<p class='alert alert-info'>Delete id is required!</p>";
    header("Location:../index.php?page=viewAlldepoList&folder=setup");
    exit();
  }
  $depoDelid=$_GET['depoDelid'];//Received the Delete Id

  $db->beginTransaction();
    $depoPhoto=$db->prepare("SELECT * FROM depo WHERE id=?");
    $depoPhoto->bindParam(1,$depoDelid);
    $selExe=$depoPhoto->execute();
    $depoPhotoRow=$depoPhoto->fetch(PDO::FETCH_OBJ);
    $pictureName=$depoPhotoRow->picture;

    $depoDelQuery=$db->prepare("DELETE FROM `depo` WHERE `id`=?");
    $depoDelQuery->bindParam(1,$depoDelid);
    $delExe=$depoDelQuery->execute();
    if($selExe && $delExe){
      $db->commit();
      unlink('../depoPhoto/'.$pictureName);//Delete user picture from directory
      $_SESSION['delDepoMsg']="<p class='alert alert-success'>Delete has been successful</p>";
      header("Location:../index.php?page=viewAlldepoList&folder=setup");
    }else{
      $db->rollback();
      $_SESSION['delDepoMsg']="<p class='alert alert-danger'>Delete query has been failed!</p>";
      header("Location:../index.php?page=viewAlldepoList&folder=setup");
    }


?>