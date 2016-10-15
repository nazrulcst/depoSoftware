<?php
	header('Content-Type: application/json');
	$salesVal=$_POST['salesVal'];
	$unitPriceVal=$_POST['unitPriceVal'];
	$data['totalPrice']=$unitPriceVal*$salesVal;
	echo json_encode($data);

?>