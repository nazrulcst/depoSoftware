<?php
require('database.php');
$selectCat=$db->prepare("SELECT * FROM `category`");
$selectCat->execute();
$data="";
$sl="";
 while($catRow=$selectCat->fetch(PDO::FETCH_OBJ)){
 	$sl++;
 	$data.="
 		<option value='$catRow->id'>$catRow->catName</option>
 	";
 }
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-bottom:20px;">
			<h3 class="text-center text-info">Add new product</h3>
			<hr>
			<?php
				if(isset($_SESSION['proInMsg'])){
					echo $_SESSION['proInMsg'];
					unset($_SESSION['proInMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<form action="action/productSetupAction.php" method="post">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proName">Product Name :</label>
						<input type="text" id="proName" name="proName" placeholder="Enter your product name" class="form-control" required="1">
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proPrice">Product Unit Price :</label>
						<input type="number" id="proPrice" name="proPrice" placeholder="Enter your product price" class="form-control" required="1">
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proQuantity">Product Quantity :</label>
						<input type="number" id="proQuantity" name="proQuantity" placeholder="Enter your product quantity" class="form-control" required="1">
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proName">Category Name :</label>
						<select name="catName" class="form-control" required="1">
							<option value="">Select your category</option>
							<?php echo $data;?>				
						</select>
					</div>
				</div>
				<div class="col-sm-10">
					<button class="btn btn-primary btn-block">Save</button>
				</div>
			</div>
		</form>	
	</div>
</div>