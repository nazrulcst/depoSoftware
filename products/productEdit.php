<?php
	require('database.php');
	if(!isset($_GET['proEditId'])){
		exit();
	}
	$proEditId=$_GET['proEditId'];
	$proEditSelect=$db->prepare("SELECT products.*,category.catName FROM products LEFT JOIN category ON products.cat_id=category.id WHERE products.id=?");
	$proEditSelect->bindParam(1,$proEditId);
	$proEditSelect->execute();
	$proEditRow=$proEditSelect->fetch(PDO::FETCH_ASSOC);
	//category select for update category name
	$catSelcet=$db->prepare("SELECT * FROM category");
	$catSelcet->execute();
	$catName='';
	while($catRow=$catSelcet->fetch(PDO::FETCH_OBJ)){
		$catName.="
			<option value='$catRow->id'>$catRow->catName</option>
		";
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12" style="margin-bottom:20px;">
			<h3 class="text-center text-info">Update product from</h3>
			<hr>
			<?php
				if(isset($_SESSION['proEditMsg'])){
					echo $_SESSION['proEditMsg'];
					unset($_SESSION['proEditMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<form action="action/productEditAction.php" method="post">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proName">Product Name :</label>
						<input type="text" id="proName" name="proName" placeholder="Enter your product name" class="form-control" value="<?php echo $proEditRow['pro_name'];?>">
						<input type="hidden" name="ProeditId" value="<?php echo $proEditRow['id'];?>">
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proPrice">Product Unit Price :</label>
						<input type="number" id="proPrice" name="proPrice" placeholder="Enter your product price" class="form-control" value="<?php echo $proEditRow['pro_price'];?>">
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proQuantity">Product Quantity(pcs) :</label>
						<input type="number" id="proQuantity" name="proQuantity" placeholder="Enter your product quantity" class="form-control" value="<?php echo $proEditRow['quantity'];?>">
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proName">Category Name :</label>
						<select name="catName" class="form-control">
							<option value="<?php echo $proEditRow['cat_id'];?>"><?php echo $proEditRow['catName'];?></option>
							<?php echo $catName;?>
						</select>
					</div>
				</div>
				<div class="col-sm-10">
					<button class="btn btn-primary btn-block">Submit</button><br>
				</div>
			</div>
		</form>
	</div>
	<div class="row">
		<div class="col-sm-5 col-sm-offset-1" style="margin-top:50px;">
			<a href="index.php?page=productViewList&folder=products" class="btn btn-primary pull-right">
				<i class="glyphicon glyphicon-chevron-left"></i>Back to home
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" style="margin-top:30px;">
			<hr>
		</div>
	</div>
</div>