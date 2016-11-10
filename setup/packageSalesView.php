<?php
	require("database.php");
	$packageRecods=$db->prepare("SELECT * FROM package");
	$packageRecods->bindParam(1,$depoId);
	$packageRecods->execute();
	$rowCount=$packageRecods->rowCount();
	$per_page_row=10;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		echo"You have no recods in your database!";
	}
	$package_sales=$db->prepare("SELECT *,depo.depo_name AS depoName,products.pro_name AS pName FROM package LEFT JOIN depo ON package.depo_id=depo.id LEFT JOIN depo_store ON package.store_id=depo_store.id LEFT JOIN products ON depo_store.pro_id=products.id ORDER BY package_date DESC LIMIT $startPage,$per_page_row");
	$package_sales->execute();
	$inc='';
	$data='';
	while($packageRow=$package_sales->fetch(PDO::FETCH_ASSOC)){
		$inc++;
		$date=date('d-M-Y',strtotime($packageRow['package_date']));
		$data.="
			<tr class='success'>
				<td>$inc</td>
				<td>{$packageRow['depoName']}</td>
				<td>{$packageRow['pName']}</td>
				<td>{$packageRow['total_item']}</td>
				<td>{$packageRow['percentageOff']}</td>
				<td>{$packageRow['total_sales_taka']}</td>
				<td>{$date}</td>
			</tr>
		";
	};
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Daily package sales</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<table class="table table-hover">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Proucts Name</th>
					<th>Quantity</th>
					<th>Percentage</th>
					<th>Total Sales Tk</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data; ?>
				</tbody>
			</table><hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1 text-center" style="margin-top:10px">
			<?php
				$prevPage=$pageNumber-1;
				$nextPage=$pageNumber+1;
				if($pageNumber<=1){
					echo"<a href='index.php?page=packageSalesView&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=packageSalesView&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=packageSalesView&folder=setup&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=packageSalesView&folder=setup&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=packageSalesView&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=packageSalesView&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>