<?php
	require('database.php');
	//include_once();
	$offerEditId=$_GET['offerEid'];
	$offerEdit=$db->prepare("SELECT * FROM pack_name WHERE id=?");
	$offerEdit->bindParam(1,$offerEditId);
	$offerEdit->execute();
	$offerRow=$offerEdit->fetch(PDO::FETCH_ASSOC);
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Edit package offer</h3>
			<hr>
			<?php
				if(isset($_SESSION['offMsg'])){
					echo $_SESSION['offMsg'];
					unset($_SESSION['offMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:15px">
			<form action="action/offerEditAction.php" method="post">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
						<label for="packageName">Package Name :</label>
						<input type="text" name="packageName" id="packageName" placeholder="Enter package name" class="form-control" value="<?php echo $offerRow['package_name'];?>">
						<input type="hidden" name="editId" value="<?php echo $offerRow['id'];?>">
					</div>
				</div>
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
						<label for="percentage">Percentage Off :</label>
						<input type="number" name="percentage" id="percentage" placeholder="Enter a value without %" class="form-control" value="<?php echo $offerRow['percentage'];?>">
					</div>
				</div>
				<div class="col-sm-4 col-sm-offset-2">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Edit submit</button>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-group">
						<a href="index.php?page=viewPackageName&folder=setup" class="btn btn-info btn-block">Back to previous</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>