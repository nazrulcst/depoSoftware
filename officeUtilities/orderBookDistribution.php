<?php
	require('database.php');
	$selectDepo=$db->prepare('SELECT * FROM depo');
	$selectDepo->execute();
	$inc='';
	$data='';
	while($depoRow=$selectDepo->fetch(PDO::FETCH_OBJ)){
		$inc++;
		$data.="
			<option value='$depoRow->id'>$depoRow->depo_name</option>
		";
	}

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-green text-center">Order Book Distribution</h3>
			<hr>
			<?php
				if(isset($_SESSION['bookDist'])){
					echo $_SESSION['bookDist'];
					unset($_SESSION['bookDist']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:15px">
			<form action="action/orderBookDistributionAction.php" method="post">
				<div class="col-sm-5 col-sm-offset-1">
					<div class="form-group">
						<label for="depoName">Depo Name :</label>
						<select class="form-control" name="depoName">
							<option value="">Select your depo name</option>
							<?php echo $data;?>
						</select>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="bookNumber">Book Number:</label>
						<input type="number" name="bookNumber" id="bookNumber" placeholder="Enter your book number" class="form-control">
					</div>
				</div>
				<div class="col-sm-10 col-sm-offset-1">
					<div class="form-group">
						<button class="btn btn-block btn-primary">Submit</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>