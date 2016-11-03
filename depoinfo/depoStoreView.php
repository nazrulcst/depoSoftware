<?php
	require('database.php');
	include_once('necessaryClass/user.php');
	$userLoginId=(int)$obj->userLoginId();
	$recodsSel=$db->prepare("SELECT * FROM depo_store LEFT JOIN depo ON depo_store.depo_id=depo.id LEFT JOIN user ON depo.user_id=user.id WHERE depo.user_id=?");
	$recodsSel->bindParam(1,$userLoginId);
	$recodsSel->execute();
	$totalRow=$recodsSel->rowCount();
	$showRecodsPerPage=10;
	$totalPage=ceil($totalRow/$showRecodsPerPage);
	$pageNumber=(isset($_GET['pgNumber'])?$_GET['pgNumber']:$_GET['pgNumber']=1);
	$start=($pageNumber-1)*$showRecodsPerPage;
	if($pageNumber<1){
		$start=(-$pageNumber+1)*$showRecodsPerPage;
	}

	$depoStoreSel=$db->prepare("SELECT *,depo.depo_name AS depoName,products.pro_name AS proName FROM depo_store LEFT JOIN depo ON depo_store.depo_id=depo.id LEFT JOIN user ON depo.user_id=user.id LEFT JOIN products ON depo_store.pro_id=products.id  WHERE depo.user_id=? LIMIT $start,$showRecodsPerPage");
	$depoStoreSel->bindParam(1,$userLoginId);
	$depoStoreSel->execute();
	$sl='';
	$data='';
	while($storeRow=$depoStoreSel->fetch(PDO::FETCH_ASSOC)){
		$sl++;
		$date=date('d-M-Y',strtotime($storeRow['store_date']));
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>{$storeRow['depoName']}</td>
				<td>{$storeRow['proName']}</td>
				<td>{$storeRow['pro_quantity']}</td>
				<td>{$storeRow['pro_price']}</td>
				<td>{$storeRow['total_price']}</td>
				<td>{$date}</td>
			</tr>
		";
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-green text-center">View your Store</h3>
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
					<th>Unit Price</th>
					<th>Total Tk</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table><hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2 text-center" style="margin-top:10px">
			<?php
				$pagePre=$pageNumber-1;
				$pageNext=$pageNumber+1;
				if($pagePre==0){//checking the previous button
					echo"<a href='index.php?page=depoStoreView&folder=depoinfo&pgNumber={$pagePre}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a> &nbsp;&nbsp;"; // Previous button
				}else{
					echo"<a href='index.php?page=depoStoreView&folder=depoinfo&pgNumber={$pagePre}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a> &nbsp;&nbsp;"; // Previous button
				}
				
				if($pageNumber <= $totalPage){
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
								echo "<a href='index.php?page=depoStoreView&folder=depoinfo&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>".'&nbsp;';
						}else{
							echo "<a href='index.php?page=depoStoreView&folder=depoinfo&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>".'&nbsp;';
						}
					}
				}else{
					echo"Page not found ! 404";
				}
				if($pageNumber==$totalPage){//checking the next button
					echo"&nbsp;&nbsp;<a class='btn btn-primary btn-sm disabled'
						href='index.php?page=depoStoreView&folder=depoinfo={$pageNext}'>Next
							<span class='glyphicon glyphicon-chevron-right'></span>
						</a>";// Next button
				}else{
					echo"&nbsp;&nbsp;<a href='index.php?page=depoStoreView&folder=depoinfo&pgNumber={$pageNext}'
					 class='btn btn-primary btn-sm'>Next
					 	<span class='glyphicon glyphicon-chevron-right'></span>
					 </a>";// Next button
				}
			?>
		</div>
	</div>
</div>