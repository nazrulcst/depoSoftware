<?php
class loginUser{
	public function userType(){
		if($_SESSION['userType']=='admin' OR $_SESSION['userType']=='superadmin'){
			return $_SESSION['userType'];
		}
		return false;
	}
	public function userLoginId(){
		if($_SESSION['userId']){
			return $_SESSION['userId'];
		}
		return false;
	}
	public function userName(){
		if($_SESSION['loginUserName']){
			return $_SESSION['loginUserName']; 
		}
		return false;
	}
} 
$obj = new loginUser;
?>