<?php
	require('database.php');
	if(isset($_GET['id'])){
		$catId=$_GET['id'];
		$editCategory=$db->prepare("SELECT * FROM `category` WHERE `id`=?");
		$editCategory->bindParam(1,$catId);
		$editCategory->execute();
		$editCatRow=$editCategory->fetch(PDO::FETCH_ASSOC);
	}else{
		exit();
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<h2 class="text-info text-center">Edit category name</h2>
			<hr>
			<?php
				if(isset($_SESSION['cateditMsg'])){
					echo $_SESSION['cateditMsg'];
					unset($_SESSION['cateditMsg']);
				}
			?>
			<a href="index.php?page=categoryView&folder=category" class="btn btn-primary pull-right">View all category
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<form action="action/categoryEditAction.php" method="post">
				<div class="col-sm-12">
					<div class="form-group">
						<label for="cat">Category Name :</label>
						<input type="text" id="cat" name="cat" placeholder="Write your category name" class="form-control" value="<?php echo $editCatRow['catName'];?>">
						<input type="hidden" id="catId" name="catId" value="<?php echo $editCatRow['id'];?>">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<button href="" class="btn btn-primary btn-block">Update</button>
					</div>
				</div>
				<div class="col-xs-2 col-xs-offset-5" style="margin-top:10px">
				<a href="index.php?page=categoryView&folder=category" class="btn btn-primary pull-right"><span class="glyphicon glyphicon-chevron-left"></span>Back</a>
			</div>
			</form>
		</div>
	</div>	
</div>