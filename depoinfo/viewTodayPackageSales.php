<?php
	require('database.php');
	include_once('necessaryClass/user.php');
	$userLoginId=$obj->userLoginId();
	$depo=$db->prepare('SELECT * FROM depo WHERE user_id=?');
	$depo->bindParam(1,$userLoginId);
	$depo->execute();
	$fetchDepo=$depo->fetch(PDO::FETCH_ASSOC);
	$depoId=$fetchDepo['id'];
	$packageRecods=$db->prepare("SELECT * FROM package WHERE depo_id=?");
	$packageRecods->bindParam(1,$depoId);
	$packageRecods->execute();
	$rowCount=$packageRecods->rowCount();
	$per_page_row=10;
	$totalPage=ceil($rowCount/$per_page_row);
	$pageNumber=(isset($_GET['pgNumber'])?(int)$_GET['pgNumber']:(int)$_GET['pgNumber']=1);
	$startPage=(int)($pageNumber-1)*$per_page_row;
	if($pageNumber<1){
		$startPage=(int)(-$pageNumber+1)*$per_page_row;
		$_SESSION['erMsg']="You are enter wrong values !";
	}
	$PackageSales=$db->prepare("SELECT *,package.id AS pID,depo.depo_name AS Dname,products.pro_name AS Pname FROM package LEFT JOIN depo ON package.depo_id=depo.id LEFT JOIN depo_store ON package.store_id=depo_store.id LEFT JOIN products ON depo_store.pro_id=products.id WHERE package.depo_id=? ORDER BY pID DESC LIMIT $startPage,$per_page_row");
	$PackageSales->bindParam(1,$depoId);
	$PackageSales->execute();
	$i='';
	$data='';
	while($packageRow=$PackageSales->fetch(PDO::FETCH_ASSOC)){
		$i++;
		$date=date('d-M-Y',strtotime($packageRow['package_date']));
		$data.="
			<tr class='success'>
				<td>$i</td>
				<td>{$packageRow['Dname']}</td>
				<td>{$packageRow['Pname']}</td>
				<td>{$packageRow['total_item']}</td>
				<td>{$packageRow['percentageOff']}&nbsp;%</td>
				<td>{$packageRow['total_sales_taka']}</td>
				<td>{$date}</td>
			</tr>
		";
	}

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h3 class="text-green text-center">Today package sales view</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2" style="margin-top:10px">
			<table class="table table-hover table-bordered table-striped table-consendend">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Depo Name</th>
					<th>Product Name</th>
					<th>Quantity</th>
					<th>Percentage</th>
					<th>Sales Tk</th>
					<th>Date</th>
				</thead>
				<tbody>
					<?php echo $data;?>
				</tbody>
			</table><hr>
		</div>
		<div class="col-sm-10 col-sm-offset-1 text-center" style="margin-top:10px">
			<?php
				$prevPage=$pageNumber-1;
				$nextPage=$pageNumber+1;
				if($pageNumber<=1){
					echo"<a href='index.php?page=viewTodayPackageSales&folder=depoinfo&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=viewTodayPackageSales&folder=depoinfo&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=viewTodayPackageSales&folder=depoinfo&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=viewTodayPackageSales&folder=depoinfo&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=viewTodayPackageSales&folder=depoinfo&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=viewTodayPackageSales&folder=depoinfo&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>