<?php
	date_default_timezone_set("Asia/Dhaka");
	require("../database.php");
	session_start();
	$depoId=$_POST['depoName'];
	$proId=$_POST['proName'];
	$proPrice=$_POST['proPrice'];
	$repQuantity=$_POST['repQuantity'];
	$repTotalPrice=$repQuantity*$proPrice;
	$currentDate=date("Y-m-d");
	// Product id selet query
		$selProId=$db->prepare("SELECT * FROM warranty WHERE pro_id=? AND replace_date=?");
		$selProId->bindParam(1,$proId);
		$selProId->bindParam(2,$currentDate);
		$selProId->execute();
		$rowSel=$selProId->fetch(PDO::FETCH_ASSOC);
		$proIdExist=$rowSel['pro_id'];
		$quantity=$rowSel['quantity'];
		$updateQuantity=$quantity+$repQuantity;
		$total_price=$rowSel['total_price'];
		$updateTotalPrice=$total_price+$repTotalPrice;
		if(!$proIdExist){
			// Replace data insert into warranty table
			$replaceInsert=$db->prepare("INSERT INTO warranty SET depo_id=?,pro_id=?,pro_price=?,quantity=?,total_price=?,replace_date=?");
			$replaceInsert->bindParam(1,$depoId);
			$replaceInsert->bindParam(2,$proId);
			$replaceInsert->bindParam(3,$proPrice);
			$replaceInsert->bindParam(4,$repQuantity);
			$replaceInsert->bindParam(5,$repTotalPrice);
			$replaceInsert->bindParam(6,$currentDate);
			$replaceInsert->execute();
		}else{
			// Replace duplicat id update query
			$repUpdateQuery=$db->prepare("UPDATE warranty SET quantity=?,total_price=? WHERE pro_id=? AND replace_date=?");
			$repUpdateQuery->bindParam(1,$updateQuantity);
			$repUpdateQuery->bindParam(2,$updateTotalPrice);
			$repUpdateQuery->bindParam(3,$proIdExist);
			$repUpdateQuery->bindParam(4,$currentDate);
			$repUpdateQuery->execute();
			echo "Update";
		}

	// Warranty table data select for total_warranty table data insert	
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
	// Total warranty duplicate depo id update Query
		$totalWarrantyUpdate=$db->prepare("SELECT * FROM total_warranty WHERE depo_id=? AND warranty_date=?");
		$totalWarrantyUpdate->bindParam(1,$depoId);
		$totalWarrantyUpdate->bindParam(2,$currentDate);
		$totalWarrantyUpdate->execute();
		$totalWarRrow=$totalWarrantyUpdate->fetch(PDO::FETCH_ASSOC);
		$depoIdExist=$totalWarRrow['depo_id'];
		$Quantity=$totalWarRrow['warranty_quantity'];
		$updateQuantity=$Quantity+$repQuantity; // update total warranty Quantity
		$totalTaka=$totalWarRrow['total_warranty_tk'];
		$updateTotalTaka=$repTotalPrice+$totalTaka;// update total warranty taka
		if(!$depoIdExist){
			// Total warranty insert Query
			$totalWarranty=$db->prepare("INSERT INTO total_warranty SET depo_id=?,warranty_quantity=?,total_warranty_tk=?,warranty_date=?");
			$totalWarranty->bindParam(1,$depoId);		
			$totalWarranty->bindParam(2,$totalQuantity);		
			$totalWarranty->bindParam(3,$totalPrice);		
			$totalWarranty->bindParam(4,$currentDate);	
			$totalWarranty->execute();
			echo"Total warranty insert";
		}else{
			// Total warranty Update Query
			$totalWarrantyUpdate=$db->prepare("UPDATE total_warranty SET warranty_quantity=?,total_warranty_tk=? WHERE depo_id=? AND warranty_date=?");
			$totalWarrantyUpdate->bindParam(1,$updateQuantity);
			$totalWarrantyUpdate->bindParam(2,$updateTotalTaka);
			$totalWarrantyUpdate->bindParam(3,$depoIdExist);
			$totalWarrantyUpdate->bindParam(4,$currentDate);
			$totalWarrantyUpdate->execute();
			echo"Total warranty Update";
		}
	



?>