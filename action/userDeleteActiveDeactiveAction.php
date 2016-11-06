<?php
	session_start();
	require('../database.php');
	include_once('../necessaryClass/user.php');
	if(!$obj->userType()){
		$_SESSION['userStsMsg']="<p class='alert alert-danger'>You are not permited user</p>";
		header("Location:../index.php?page=viewAlluser&folder=setup");
		exit();
	}
	if(isset($_GET['staActive'])){
		$activeId=$_GET['staActive'];
		$active='active';
		$activeTRim=trim(htmlspecialchars($active));
		$userUP=$db->prepare("UPDATE user SET status=? WHERE id=?");
		$userUP->bindParam(1,$activeTRim);
		$userUP->bindParam(2,$activeId);
		if($userUP->execute()){
			$_SESSION['userStsMsg']="<p class='alert alert-success'>Successfully update</p>";
			header("Location:../index.php?page=viewAlluser&folder=setup");
		}else{
			$_SESSION['userStsMsg']="<p class='alert alert-warning'>Please system check!</p>";
			header("Location:../index.php?page=viewAlluser&folder=setup");
		}
	}elseif(isset($_GET['staDelete'])){
		$deleteId=(int)$_GET['staDelete'];
		$deleteQuery=$db->prepare("DELETE FROM user WHERE id=?");
		$deleteQuery->bindParam(1,$deleteId);
		if($deleteQuery->execute()){
			$_SESSION['userStsMsg']="<p class='alert alert-success'>Successfully Delete</p>";
			header("Location:../index.php?page=viewAlluser&folder=setup");
		}else{
			$_SESSION['userStsMsg']="<p class='alert alert-warning'>Please system check!</p>";
			header("Location:../index.php?page=viewAlluser&folder=setup");
		}
	}elseif(isset($_GET['staDeactive'])){
		$deactiveId=$_GET['staDeactive'];
		$deactive='deactive';
		$DeactiveTRim=trim(htmlspecialchars($deactive));
		$userDe=$db->prepare("UPDATE user SET status=? WHERE id=?");
		$userDe->bindParam(1,$DeactiveTRim);
		$userDe->bindParam(2,$deactiveId);
		if($userDe->execute()){
			$_SESSION['userStsMsg']="<p class='alert alert-success'>Successfully update</p>";
			header("Location:../index.php?page=viewAlluser&folder=setup");
		}else{
			$_SESSION['userStsMsg']="<p class='alert alert-warning'>Please system check!</p>";
			header("Location:../index.php?page=viewAlluser&folder=setup");
		}
	}
?>