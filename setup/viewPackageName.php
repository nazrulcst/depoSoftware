<?php
	require('database.php');
	$offerRecods=$db->prepare("SELECT * FROM pack_name");
	$offerRecods->execute();
	$totalRecods=$offerRecods->rowCount();
	$perPage=10;
	$totalPage=ceil($totalRecods/$perPage);
	$pageNumber=(isset($_GET['pgNumber'])?$_GET['pgNumber']:$_GET['pgNumber']=1);
	$startPage=($pageNumber-1)*$perPage;
	if($pageNumber<1){
		$startPage=(-$pageNumber+1)*$perPage;
		echo"No recods found!";
	}
	$package_nameSel=$db->prepare("SELECT * FROM pack_name LIMIT $startPage,$perPage");
	$package_nameSel->execute();
	$incr='';
	$data='';
	while($packRow=$package_nameSel->fetch(PDO::FETCH_OBJ)){
		$incr++;
		$data.="
			<tr class='success'>
				<td>$incr</td>
				<td>$packRow->package_name</td>
				<td>$packRow->percentage %</td>
				<td>
					<a class='btn btn-primary btn-sm' href='index.php?page=offerEdit&folder=setup&offerEid=$packRow->id'>
						<span class='glyphicon glyphicon-pencil'></span>
					</a>
				</td>
				<td>
					<a class='btn btn-danger btn-sm disabled' href='index.php?page=viewPackageName&folder=setup&offerDelId=$packRow->id'>
						<span class='glyphicon glyphicon-trash'></span>
					</a>
				</td>
			</tr>
		";
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">View all availabel offer</h3>
			<hr>
			<?php
				if(isset($_GET['offerDelId'])){
					$delId=$_GET['offerDelId'];
					echo"
						Are you sure ? <a href='action/offerDeleteAction.php?&deleteId=$delId' class='btn btn-danger btn-sm'>
							<span class='glyphicon glyphicon-ok'></span>
						</a>
						<a href='index.php?page=viewPackageName&folder=setup' class='btn btn-primary btn-sm'>
							<span class='glyphicon glyphicon-remove'></span>
						</a>
					";
				}
				if(isset($_SESSION['delMsg'])){
					echo $_SESSION['delMsg'];
					unset($_SESSION['delMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<table class="table table-hover table-bordered table-striped table-condensend">
				<thead class="text-green">
					<th>Sl No</th>
					<th>Package Name</th>
					<th>Percentage</th>
					<th width="5%">Edit</th>
					<th>Delete</th>
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
				$prevPage=$pageNumber-1;
				$nextPage=$pageNumber+1;
				if($pageNumber<=1){
					echo"<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm disabled'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}else{
					echo"<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$prevPage}' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-chevron-left'></span>Prev</a>&nbsp;&nbsp;";
				}
				if($pageNumber>$totalPage){
					echo"Page not found";	
				}else{
					for($i=1;$i<=$totalPage;$i++){
						if($i == $pageNumber){
							echo"<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$i}' class='btn btn-primary btn-sm'>$i</a>&nbsp;";
						}else{
							echo"<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$i}' class='btn btn-default btn-sm'>$i</a>&nbsp;";
						}
					}
				}
			if($totalPage==$pageNumber){
				echo"&nbsp;&nbsp;<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm disabled'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}else{
				echo"&nbsp;&nbsp;<a href='index.php?page=viewAlluser&folder=setup&pgNumber={$nextPage}' class='btn btn-primary btn-sm'>Next<span class='glyphicon glyphicon-chevron-right'></span></a>";
			}	
			?>
		</div>
	</div>
</div>