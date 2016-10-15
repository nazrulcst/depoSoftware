<div class="container-fluid">
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<h2 class="text-info text-center">Create new category</h2>
			<hr>
			<?php
				if(isset($_SESSION['catMsg'])){
					echo $_SESSION['catMsg'];
					unset($_SESSION['catMsg']);
				}
			?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8 col-sm-offset-2">
			<a href="index.php?page=categoryView&folder=category" class="btn btn-primary pull-right">View all category</a>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<form action="action/categorySetupAction.php" method="post">
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
						<label for="catName">Category Name :</label>
						<input type="text" id="catName" name="catName" placeholder="Write your category name" class="form-control" required="1">
					</div>
				</div>
				<div class="col-sm-8 col-sm-offset-2">
					<div class="form-group">
						<button href="" class="btn btn-primary btn-block" id="Button">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>