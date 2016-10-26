<?php
	require('database.php');
	$proName=$db->prepare("SELECT * FROM products");
	$proName->execute();
	$sl='';
	$input='';
	while($proNameRow=$proName->fetch(PDO::FETCH_OBJ)){
		$sl++;
		
		$input.="
			$proNameRow->pro_name : <input type='checkbox' name='productName[]' value='$proNameRow->pro_name'><br>
			<input type='text' name='proQuantity[]' placeholder='Enter your quantity'>&nbsp;&nbsp;&nbsp;Pcs<br>
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
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Add today package sales</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:20px">
			<form action="action/packageSetupAction.php" method="post">
				<div class="col-sm-8 col-sm-offset-1">
					<div class="form-group">
						<label for="productName">Product Name :</label><br>
							<?php echo $input;?>
					</div>
				</div>
				
				<div class="col-sm-8 col-sm-offset-1">
					<div class="form-group">
						
					</div>
				</div>
				<div class="col-sm-8 col-sm-offset-1">
					<div class="form-group">
						<label for="packageName">Package Name :</label>
						<select name="packageName" id="packageName" class="form-control">
							<option>Select your package</option>
							<?php echo $offData;?>	
						</select>
					</div>
				</div>
				<div class="col-sm-8 col-sm-offset-1">
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Add Sales package</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>