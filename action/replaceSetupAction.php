<?php
	date_default_timezone_set("Asia/Dhaka");
	require("../database.php");
	session_start();
	echo"DepoId ".$depoId=$_POST['depoName']."<br>";
	echo"Product Id ".$proId=$_POST['proName']."<br>";
	$proPrice=$_POST['proPrice'];
	$repQuantity=$_POST['repQuantity'];
	$repTotalPrice=$repQuantity*$proPrice;
	echo"current date ".$currentDate=date("Y-m-d")."<br>";
	
	// Product id selet for warranty table data insert & update operation
		$selWarTableData=$db->prepare("SELECT * FROM warranty WHERE pro_id=? AND replace_date=?");
		$selWarTableData->bindParam(1,$proId);
		$selWarTableData->bindParam(2,$currentDate);
		$selWarTableData->execute();
		$selWarRow=$selWarTableData->fetch(PDO::FETCH_ASSOC);
		echo $existProId=$selWarRow['pro_id']."<br>";
		echo $existDepoId=$selWarRow['depo_id']."<br>";
		echo $existRepDate=$selWarRow['replace_date']."<br>";

		//if(!$ProductId){
			/*/ Warranty/Replace data insert into arranty table
			$replaceInsert=$db->prepare("INSERT INTO warranty SET depo_id=?,pro_id=?,pro_price=?,quantity=?,total_price=?,replace_date=?");
			$replaceInsert->bindParam(1,$depoId);
			$replaceInsert->bindParam(2,$proId);
			$replaceInsert->bindParam(3,$proPrice);
			$replaceInsert->bindParam(4,$repQuantity);
			$replaceInsert->bindParam(5,$repTotalPrice);
			$replaceInsert->bindParam(6,$currentDate);
			$replaceInsert->execute();
			*/
			//echo"Insert for warranty table data<br>";
		//}else{
			/*/ Warranty/Replace duplicat id update query
			$repUpdateQuery=$db->prepare("UPDATE warranty SET quantity=?,total_price=? WHERE pro_id=? AND replace_date=?");
			$repUpdateQuery->bindParam(1,$updateQuantity);
			$repUpdateQuery->bindParam(2,$updateTotalPrice);
			$repUpdateQuery->bindParam(3,$proIdExist);
			$repUpdateQuery->bindParam(4,$currentDate);
			$repUpdateQuery->execute();
			*/
			//echo "Update for warranty table data<br>";
	//	}
	

	// Warranty table data select for Total warranty table inser & update
		$proIdSelect=$db->prepare("SELECT warranty.*,warranty.id AS warrantyId,depo.* FROM warranty LEFT JOIN depo ON warranty.depo_id=depo.id WHERE depo_id=? AND replace_date=?");
		$proIdSelect->bindParam(1,$depoId);
		$proIdSelect->bindParam(2,$currentDate);
		$proIdSelect->execute();
		$totalQuantity="";
		$totalPrice="";
		$i=0;
		while($selProRow=$proIdSelect->fetch(PDO::FETCH_OBJ)){
			$totalPrice+=$selProRow->total_price;
			$totalQuantity+=$selProRow->quantity;
			$i++;
		}
		echo $totalPrice."<br>";
	
	
	// Total warranty table data select
		$selTotalWarranty=$db->prepare("SELECT total_warranty.*,total_warranty.depo_id AS depoId,depo.id FROM total_warranty LEFT JOIN depo ON total_warranty.depo_id=depo.id WHERE total_warranty.depo_id=? AND total_warranty.warranty_date=?");
		$selTotalWarranty->bindParam(1,$depoId);
		$selTotalWarranty->bindParam(2,$currentDate);
		$selTotalWarranty->execute();
		$selRow=$selTotalWarranty->fetch(PDO::FETCH_ASSOC);

		$existDate=$selRow['warranty_date'];
		//if($existDepoId==$depoId && $existDate==$currentDate){
			/*/ Total warranty table data Update
			$totalWarrantyUpdate=$db->prepare("UPDATE total_warranty SET warranty_quantity=?,total_warranty_tk=? WHERE depo_id=? AND warranty_date=?");
			$totalWarrantyUpdate->bindParam(1,$updateTotalQuantity);
			$totalWarrantyUpdate->bindParam(2,$totalPrice);
			$totalWarrantyUpdate->bindParam(3,$existDepoId);
			$totalWarrantyUpdate->bindParam(4,$currentDate);*/
			//echo"update";
		//}else{
			/*/ Total warranty table data insert Query
			$totalWarrantyInser=$db->prepare("INSERT INTO total_warranty SET depo_id=?,warranty_quantity=?, 	total_warranty_tk=?,warranty_date=?");
			$totalWarrantyInser->bindParam(1,$depoId);	
			$totalWarrantyInser->bindParam(2,$totalQuantity);	
			$totalWarrantyInser->bindParam(3,$totalPrice);	
			$totalWarrantyInser->bindParam(4,$currentDate);
			$totalWarrantyInser->execute();*/
			//echo"Insert";
	//	}



?>