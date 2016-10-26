<?php
	require('database.php');
	$proName=$db->prepare("SELECT * FROM products");
	$proName->execute();
	$sl='';
	$data='';
	while($proNameRow=$proName->fetch(PDO::FETCH_OBJ)){
		$sl++;
		$data.="
			<option value='$proNameRow->id'>$proNameRow->pro_name</option>
		";
	}
	$offerSel=$db->prepare("SELECT * FROM pack_name");
	$offerSel->execute();
	$icr='';
	$offData='';
	while($offRow=$offerSel->fetch(PDO::FETCH_OBJ)){
		$offData.="
			<option value='$offRow->package_name'>$offRow->package_name</option>
		";
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10">
			<h3 class="text-center text-green">Add today package sales</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:20px">
			<form action="action/packageSetupAction.php" method="post">
				<div class="col-sm-5 col-sm-offset-1">
					<div class="form-group">
						<label for="productName">Product Name :</label>
						<select name="productName" id="productName" class="form-control">
							<option>Select your product</option>
							<?php echo $data;?>	
						</select>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="packageName">Package Name :</label>
						<select name="packageName" id="packageName" class="form-control">
							<option>Select your package</option>
							<?php echo $offData;?>	
						</select>
					</div>
					</div>
				<div class="col-sm-10 col-sm-offset-1">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Add</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>