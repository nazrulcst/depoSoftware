<?php
	require("database.php");
	include_once("necessaryClass/user.php");
	$obj->userLoginId();
	$totalWarSel=$db->prepare("SELECT total_warranty.*,total_warranty.id AS totalWarId,depo.depo_name FROM total_warranty LEFT JOIN depo ON total_warranty.depo_id=depo.id");
	$totalWarSel->execute();
	$data='';
	$sl='';
	$totalQuantity='';
	$totalTaka='';
	while($totalWarRow=$totalWarSel->fetch(PDO::FETCH_OBJ)){
		$sl++;
		$Date=$totalWarRow->warranty_date;
		$formateDate=date("d-m-Y",strtotime($Date));
		$totalQuantity+=$totalWarRow->warranty_quantity;
		$totalTaka+=$totalWarRow->total_warranty_tk;
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>$totalWarRow->depo_name</td>
				<td>$totalWarRow->warranty_quantity</td>
				<td>$totalWarRow->total_warranty_tk</td>
				<td>$formateDate</td>
			</tr>
		";
	}
	
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-green text-center">View replace product</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:15px">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead class="text-green">
					<th>SL NO</th>
					<th>Depo Name</th>
					<th>Total Quantity (pcs)</th>
					<th>Total Warranty Taka</th>
					<th>Warranty Date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
					<tr class="info">
						<td></td>
						<td></td>
						<td class="text-green text-bold"><?php echo $totalQuantity;?>&nbsp;&nbsp;&nbsp;&nbsp;Total Quantity</td>
						<td class="text-green text-bold"><?php echo $totalTaka;?>&nbsp;&nbsp;&nbsp;&nbsp;Total Taka</td>
						<td></td>
					</tr>
				</tbody>
			</table>
			<hr>
		</div>
	</div>
</div>