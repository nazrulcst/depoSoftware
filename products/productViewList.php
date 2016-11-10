<?php
	require('database.php');
	$pagination=$db->prepare("SELECT * FROM products");
	$pagination->execute();
	$totalRow=$pagination->rowCount();
	$itemPerpage=5;
	$totalPage=ceil($totalRow/$itemPerpage);
	$pageNumber=(isset($_GET['pgNumber'])?$_GET['pgNumber']:$_GET['pgNumber']=1);
	$start=($pageNumber-1)*$itemPerpage;
	if($pageNumber<1){
		$start=(-$pageNumber+1)*$itemPerpage;
		echo"No recods found !";
	}
	$viewAllProList=$db->prepare("SELECT products.*,category.catName FROM products LEFT JOIN category ON products.cat_id=category.id ORDER BY entry_date DESC LIMIT $start,$itemPerpage");
	$viewAllProList->execute();
	$sl='';
	$data='';
	while($viewAllProListRow=$viewAllProList->fetch(PDO::FETCH_OBJ)){
		$sl++;
		$date=date('d-M-Y',strtotime($viewAllProListRow->entry_date));
		$data.="
			<tr class='success'>
				<td>$sl</td>
				<td>$viewAllProListRow->catName</td>
				<td>$viewAllProListRow->pro_name</td>
				<td>$viewAllProListRow->pro_price</td>
				<td>$viewAllProListRow->quantity</td>
				<td>$viewAllProListRow->total_price</td>
				<td>$date</td>
				<td>
					<a href='index.php?page=productEdit&folder=products&proEditId=$viewAllProListRow->id' class='btn btn-primary'>
						<span class='glyphicon glyphicon-pencil'></span>
					</a>
				</td>
				<td>
					<a href='index.php?page=productViewList&folder=products&proDelid=$viewAllProListRow->id' class='btn btn-danger disabled'>
						<span class='glyphicon glyphicon-trash'></span>
					</a>
				</td>
			</tr>
		";
	};
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h3 class="text-center text-green">View all product list</h3>
			<hr>
			<?php
				if(isset($_GET['proDelid'])){
					$deletId=$_GET['proDelid'];
					echo"
						<b>Are you sure you want to delete this ?</b>
						<a href='action/productDeleteAction.php?ProdelId=$deletId' class='btn btn-danger'>Delete</a>&nbsp;&nbsp;
						<a href='index.php?page=productViewList&folder=products' class='btn btn-primary'>Cancel</a>
					";
				}
				if(isset($_SESSION['proDelMsg'])){
					echo $_SESSION['proDelMsg'];
					unset($_SESSION['proDelMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<table class="table table-bordered table-hover table-condensed table-striped">
				<thead class="text-green">
					<th>Sl</th>
					<th>Category Name</th>
					<th>Product Name</th>
					<th>Unit Price/BDT</th>
					<th>Quantity</th>
					<th>Total Price/BDT</th>
					<th>Date</th>
					<th width="5%">Update</th>
					<th>Delete</th>
				<thead>
				<tbody>
					<?php echo $data;?>			
				</tbody>
			</table><hr>
		</div>
	</div>
	<div class="row"><!--Pagination Section start here-->
		<div class="col-xs-8 col-xs-offset-2 text-center" style="margin-top:10px">
			<?php
				$pagePre=$pageNumber-1;
				$pageNext=$pageNumber+1;
				if($pagePre==0){//checking the previous button
					echo"<a href='index.php?page=productViewList&folder=products&pgNumber={$pagePre}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a> &nbsp;&nbsp;"; // Previous button
				}else{
					echo"<a href='index.php?page=productViewList&folder=products&pgNumber={$pagePre}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a> &nbsp;&nbsp;"; // Previous button
				}
				
				if($pageNumber <= $totalPage){
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
								echo "<a href='index.php?page=productViewList&folder=products&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>".'&nbsp;';
						}else{
							echo "<a href='index.php?page=productViewList&folder=products&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>".'&nbsp;';
						}
					}
				}else{
					echo"Page not found ! 404";
				}
				if($pageNumber==$totalPage){//checking the next button
					echo"&nbsp;&nbsp;<a class='btn btn-primary btn-sm disabled'
						href='index.php?page=productViewList&folder=products&pgNumber={$pageNext}'>Next
							<span class='glyphicon glyphicon-chevron-right'></span>
						</a>";// Next button
				}else{
					echo"&nbsp;&nbsp;<a href='index.php?page=productViewList&folder=products&pgNumber={$pageNext}'
					 class='btn btn-primary btn-sm'>Next
					 	<span class='glyphicon glyphicon-chevron-right'></span>
					 </a>";// Next button
				}
			?>	
		</div>
	</div><!--/Pagination Section End here-->
</div>