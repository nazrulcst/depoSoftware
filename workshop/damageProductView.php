<?php
	require('database.php');
	$selWorkshop=$db->prepare("SELECT * FROM workshop_loss");
	$selWorkshop->execute();
	$rowCount=$selWorkshop->rowCount();
	$per_page_row=1;
	$pagesNeed=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?$_GET['pgNumber']:$_GET['pgNumber']=1);
	$startPage=($pageNumber-1)*$per_page_row;
	$showDateWorkshop=$db->prepare("SELECT *,products.pro_name AS proName FROM workshop_loss LEFT JOIN products ON workshop_loss.pro_id=products.id LIMIT $startPage,$per_page_row");
	$showDateWorkshop->execute();
	$sl='';
	$data='';
	while($workShopRow=$showDateWorkshop->fetch(PDO::FETCH_ASSOC)){
		$sl++;
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>{$workShopRow['proName']}</td>
				<td>{$workShopRow['quantity']}</td>
				<td>{$workShopRow['total_price']}</td>
				<td>{$workShopRow['enter_date']}</td>
			</tr>
		";
	}
	
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-green text-center">Damaged product view</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2" style="margin-top:15px">
			<table class="table table-hover table-bordered table-striped table-consendend">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Product Name</th>
					<th>Quantity</th>
					<th>Amount</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table>
		</div>
		<div class="col-sm-10 col-sm-offset-1 text-center" style="margin-top:10px">
			<hr>
			<?php
				$pagePre=$pageNumber-1;
				$pageNext=$pageNumber+1;
				if($pageNumber<=1){//checking the previous button
					echo"<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$pagePre}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a> &nbsp;&nbsp;"; // Previous button
				}else{
					echo"<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$pagePre}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a> &nbsp;&nbsp;"; // Previous button
				}

				if($pageNumber <= $pagesNeed OR $pageNumber<1){
					for($i=1;$i<=$pagesNeed;$i++){
						if($i == $pageNumber){
								echo "<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo "<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}else{
					echo"Page not found ! 404";
				}
				// checking the next button
				if($pageNext==$pagesNeed){
					echo"<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$pageNext}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a> &nbsp;&nbsp;"; // Next button
				}else{
					echo"<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$pageNext}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a> &nbsp;&nbsp;"; // Next button
				}
			?>
		</div>
	</div>
</div>