<?php
	require("database.php");
	$selectTotalWarranty=$db->prepare("SELECT total_warranty.*,depo.depo_name FROM total_warranty LEFT JOIN depo ON total_warranty.depo_id=depo.id");
	$selectTotalWarranty->execute();
	$data='';
	$sl='';
	while($warrantyRow=$selectTotalWarranty->fetch(PDO::FETCH_OBJ)){
		$sl++;
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>$warrantyRow->depo_name</td>
				<td>$warrantyRow->warranty_quantity</td>
				<td class='text-green text-bold'>$warrantyRow->total_warranty_tk</td>
				<td>$warrantyRow->warranty_date</td>
			</tr>
		";	
	} 
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">View all replacement product list</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:10px">
			<table class="table table-hover table-bordered">
				<thead class="text-green">
					<th>Sl</th>
					<th>Depo Name</th>
					<th>Total quantity</th>
					<th>Total taka</th>
					<th>Warranty date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table>
			<hr>
		</div>
	</div>	
</div>