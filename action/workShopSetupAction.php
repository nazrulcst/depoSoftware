<?php
	date_default_timezone_set('Asia/Dhaka');
	require("../database.php");
	session_start();
	include("../necessaryClass/user.php");
	if(!$obj->userType()){
		$_SESSION['workMsg']="You are not permited";
		exit();
	}
	$userType=$obj->userType();
	$userLoginId=$obj->userLoginId();
	$ProNameId=(int)$_POST['ProName'];
	$proPrice=(int)$_POST['proPrice'];
	$repQuantity=(int)$_POST['repQuantity'];
	$selectMode=htmlspecialchars($_POST['selectMode']);
	$entPrice=$proPrice*$repQuantity;
	$curDate=date('Y-m-d');
	$strcurDate=strtotime($curDate); 
	$first_day_of_month = date('Y-m-01');
	$strfirsDayofmonth=strtotime($first_day_of_month);
	$last_day_of_month = date('Y-m-t');
	$strlastDayofmonth=strtotime($last_day_of_month);

	// select product table data
	//$db->beginTransaction();// begin transaction start here
		$selProQuery=$db->prepare("SELECT products.*,products.id AS proId,user.id AS userId,category.id AS catId FROM products LEFT JOIN user ON products.user_id=user.id LEFT JOIN category ON products.cat_id=category.id WHERE products.id=?");
		$selProQuery->bindParam(1,$ProNameId);
		$proSelExe=$selProQuery->execute();
		$selProRow=$selProQuery->fetch(PDO::FETCH_ASSOC);
		$productId=$selProRow['proId'];
		$quantity=$selProRow['quantity'];
		$totalPrice=$selProRow['total_price'];
		$updateQuantity=$repQuantity+$quantity;
		$updateTotalPrice=$totalPrice+$entPrice;
	
	if($selectMode=='replaced'){
		/*/ product table update query
		$updateProducts=$db->prepare("UPDATE products SET user_id=?,quantity=?,total_price=?,uploader=? WHERE id=?");
		$updateProducts->bindParam(1,$userLoginId);
		$updateProducts->bindParam(2,$updateQuantity);
		$updateProducts->bindParam(3,$updateTotalPrice);
		$updateProducts->bindParam(4,$userType);
		$updateProducts->bindParam(5,$productId);
		$proUpExe=$updateProducts->execute();
		echo"replaced";
		*/
	}elseif($selectMode=='damaged'){
		// workshop_loss table data select
		$workshop_lossSelQuery=$db->prepare("SELECT workshop_loss.*,workshop_loss.id AS workshop_lossId,products.id AS productsId FROM workshop_loss LEFT JOIN products ON workshop_loss.pro_id=products.id WHERE workshop_loss.pro_id=?");
		$workshop_lossSelQuery->bindParam(1,$ProNameId);
		$workShopExe=$workshop_lossSelQuery->execute();
		$workshop_lossRow=$workshop_lossSelQuery->fetch(PDO::FETCH_ASSOC);
		$workShopExistQuantity=$workshop_lossRow['quantity'];
		$upWorkQuantity=$workShopExistQuantity+$repQuantity;// Update workshop variable
		$workShopExistPrice=$workshop_lossRow['total_price'];
		$upWorkPrice=$workShopExistPrice+$entPrice;// Update workshop variable
		$workShopExistId=$workshop_lossRow['workshop_lossId'];// Workshop Exist ID
		$workShopProductExistId=$workshop_lossRow['productsId'];// Workshop Exist product id

		if( $workShopProductExistId != $ProNameId or $strcurDate==$strfirsDayofmonth){
			/*/ workshop_loss data insert query
			$workshop_lossInQuery=$db->prepare("INSERT INTO workshop_loss SET pro_id=?,quantity=?,total_price=?,enter_date=?");
			$workshop_lossInQuery->bindParam(1,$ProNameId);
			$workshop_lossInQuery->bindParam(2,$repQuantity);
			$workshop_lossInQuery->bindParam(3,$entPrice);
			$workshop_lossInQuery->bindParam(4,$curDate);
			$workShopInsExe=$workshop_lossInQuery->execute();*/
			echo"work shop insert";
		}elseif($strcurDate<=$strlastDayofmonth && $workShopProductExistId==$ProNameId){
		/*/ workshop_loss data update query
			$updateWorkshopLoss=$db->prepare("UPDATE workshop_loss SET quantity=?,total_price=?,enter_date=? WHERE id=? AND pro_id=?");
			$updateWorkshopLoss->bindParam(1,$upWorkQuantity);
			$updateWorkshopLoss->bindParam(2,$upWorkPrice);
			$updateWorkshopLoss->bindParam(3,$curDate);
			$updateWorkshopLoss->bindParam(4,$workShopExistId);
			$updateWorkshopLoss->bindParam(5,$workShopProductExistId);
			$updateWorkshopLoss->execute();
			*/
			echo"workshop update";
		}
	}

?>