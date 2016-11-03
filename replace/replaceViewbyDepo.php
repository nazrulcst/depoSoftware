<?php
	date_default_timezone_set('Asia/Dhaka');
	require('database.php');
	include_once('necessaryClass/user.php');
	$userLoginId=(int)$obj->userLoginId();
	$selWarranty=$db->prepare("SELECT *,depo.depo_name AS depoName,products.pro_name AS proName FROM warranty LEFT JOIN depo ON warranty.depo_id=depo.id LEFT JOIN user ON depo.user_id=user.id LEFT JOIN products ON warranty.pro_id=products.id WHERE depo.user_id=?");
	$selWarranty->bindParam(1,$userLoginId);
	$selWarranty->execute();
	$sl='';
	$data='';
	while($warRow=$selWarranty->fetch(PDO::FETCH_ASSOC)){
		$sl++;
		$date=date('d-M-Y',strtotime($warRow['replace_date']));
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>{$warRow['depoName']}</td>
				<td>{$warRow['proName']}</td>
				<td>{$warRow['quantity']}</td>
				<td>{$warRow['total_price']}</td>
				<td>{$date}</td>
			</tr>
		";
	}


?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Your replacement products</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<table class="table table-hover table-bordered table-striped table-consendend">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Product Name</th>
					<th>Quantity</th>
					<th>Total Tk</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table>
			<hr>
		</div>
	</div>
</div>