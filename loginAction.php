
<?php
 	require('database.php');
 	session_start();
 	$loginUser=trim(htmlspecialchars($_POST['loginUser']));
 	$password=$_POST['password'];
if(!empty($loginUser) && !empty($password)){
	$shaPassword=sha1($password);
	 	$userSelect=$db->prepare("SELECT * FROM `user` WHERE `userName`=? AND `password`=?");
	 	$userSelect->bindParam(1,$loginUser);
	 	$userSelect->bindParam(2,$shaPassword);
	 	$userSelect->execute();
	 	$loginRow=$userSelect->fetch(PDO::FETCH_OBJ);
	 	if($loginRow->userName==$loginUser &&  $loginRow->password==$shaPassword){
	 		if($loginRow->status=='active'){
	 			$_SESSION['userId']=$loginRow->id;
	 			$_SESSION['userType']=$loginRow->userType;
	 			$_SESSION['loginUserName']=$loginRow->userName;
	 			header("Location:index.php");
	 		}else{
	 			$_SESSION['msg']="You are bolcked";
	 			header("Location:login.php");
	 		}
	 	}else{
	 		$_SESSION['msg']="Your user name or password incorrect";
	 		header("Location:login.php");
	 	}
}else{
	$_SESSION['msg']="Please enter your valid user name and password";
	header("Location:login.php");
}
?>