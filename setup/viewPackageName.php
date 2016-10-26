<?php
	require('database.php');
	$package_nameSel=$db->prepare("SELECT * FROM pack_name");
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
					<a class='btn btn-danger btn-sm' href='index.php?page=viewPackageName&folder=setup&offerDelId=$packRow->id'>
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
</div>