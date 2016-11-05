<?php
	require('database.php');
	$selWorkshop=$db->prepare("SELECT * FROM workshop_loss");
	$selWorkshop->execute();
	$rowCount=$selWorkshop->rowCount();
	$per_page_row=10;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		$_SESSION['erMsg']="You are enter wrong values !";
	}
	$showDateWorkshop=$db->prepare("SELECT *,workshop_loss.quantity AS lossQuantity,workshop_loss.total_price AS lossPrice, products.pro_name AS proName FROM workshop_loss LEFT JOIN products ON workshop_loss.pro_id=products.id LIMIT $startPage,$per_page_row");
	$showDateWorkshop->execute();
	$sl='';
	$data='';
	while($workShopRow=$showDateWorkshop->fetch(PDO::FETCH_ASSOC)){
		$sl++;
		$date=date('d-M-Y',strtotime($workShopRow['enter_date']));
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>{$workShopRow['proName']}</td>
				<td>{$workShopRow['lossQuantity']}</td>
				<td>{$workShopRow['lossPrice']}</td>
				<td>{$date}</td>
			</tr>
		";
	}
	
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-green text-center">Damaged product view</h3>
			<hr>
			<?php
				if(isset($_SESSION['erMsg'])){
					echo $_SESSION['erMsg'];
					unset($_SESSION['erMsg']);
				}
			?>
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
				$prevPage=$pageNumber-1;
				$nextPage=$pageNumber+1;
				if($pageNumber<=1){
					echo"<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=damageProductView&folder=workshop&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>