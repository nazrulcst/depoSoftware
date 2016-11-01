<?php
	require("database.php");
	$selectPackageSales=$db->prepare("SELECT *,depo.depo_name AS depoName,pack_name.package_name AS packageName FROM package LEFT JOIN depo ON package.depo_id=depo.id LEFT JOIN pack_name ON package.pack_name_id=pack_name.id");
	$selectPackageSales->execute();
	$inc='';
	$data='';
	while($package_sales_row=$selectPackageSales->fetch(PDO::FETCH_ASSOC)){
		$inc++;
		$data.="
			<tr class='success'>
				<td>$inc</td>
				<td>{$package_sales_row['depoName']}</td>
				<td>{$package_sales_row['packageName']}</td>
				<td>{$package_sales_row['total_item']}</td>
				<td>{$package_sales_row['percentageOff']}</td>
				<td>{$package_sales_row['total_sales_taka']}</td>
				<td>{$package_sales_row['package_date']}</td>
			</tr>
		";
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Package sales view</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:10px">
			<table class="table table-hover">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Package Name</th>
					<th>Total Item pcs</th>
					<th>Percentage</th>
					<th>Total Taka</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data; ?>
				</tbody>
			</table>
			<hr>
		</div>
	</div>
</div>