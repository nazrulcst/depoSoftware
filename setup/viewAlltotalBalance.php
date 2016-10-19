<?php
	require("database.php");
	$balSelQuery=$db->prepare("SELECT balance.*,balance.id AS balId,depo_total_sales.id,depo.depo_name AS depoName FROM balance LEFT JOIN depo_total_sales ON balance.total_sales_id=depo_total_sales.id LEFT JOIN depo ON depo_total_sales.depo_id=depo.id");
	$balSelQuery->execute();
	$data='';
	$sl='';
	while($balSelRow=$balSelQuery->fetch(PDO::FETCH_OBJ)){
		$sl++;
		
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>$balSelRow->depoName</td>
				<td>$balSelRow->total_sales_taka</td>
			</tr>
		";		
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">View all depo balance chart</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:10px">
			<table class="table table-hover table-bordered">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Total sales Taka</th>
					<th>Total warranty Taka</th>
					<th>Total balance</th>
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