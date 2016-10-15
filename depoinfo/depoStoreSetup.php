<?php
	require('database.php');
	include_once('necessaryClass/user.php');
	$loginUserId=$obj->userLoginId();
	$selDepoInfo=$db->prepare("SELECT depo.depo_name,depo.id AS depoId ,user.id FROM `depo` LEFT JOIN user ON depo.user_id=user.id WHERE user.id=?");
	$selDepoInfo->bindParam(1,$loginUserId);
	$selDepoInfo->execute();
	$depoInfoData='';
	while($eslDepoInfoRow=$selDepoInfo->fetch(PDO::FETCH_OBJ)){
		$depoInfoData.="
			<option value='$eslDepoInfoRow->depoId'>$eslDepoInfoRow->depo_name</option>
		";
	}
	$proNameSelect=$db->prepare("SELECT * FROM products");
	$proNameSelect->execute();
	$proNameData='';
	while($proNameSelRow=$proNameSelect->fetch(PDO::FETCH_OBJ)){
		$proNameData.="
			<option value='$proNameSelRow->id'>$proNameSelRow->pro_name</option>
		";
	}
	//action/depoStoreSetupAction.php
?>

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Choice your store product item</h3>
			<hr>
			<?php
				if(isset($_SESSION['storeMsg'])){
					echo $_SESSION['storeMsg'];
					unset($_SESSION['storeMsg']);
				}
			?>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:15px;">
		<form action="action/depoStoreSetupAction.php" method="post" class="myForm">
			<div class="col-sm-10 col-sm-offset-1">
				<div class="form-group">
					<label for="depo">Depo Name :</label>
					<select name="depoNameId" class="form-control" required="1">
						<option value="">Select your depo name</option>
						<?php echo $depoInfoData;?>
					</select>
				</div>
			</div>
			<div class="col-sm-5 col-sm-offset-1">
				<div class="form-group">
					<label for="proName">Product Name :</label>
					<select name="proNameId" class="form-control selPorName" required="1">
						<option value="">Select your product name</option>
						<?php echo $proNameData;?>
					</select>
				</div>
			</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proUnitPrice">Product Unit Price :</label>
						<input type="text" name="UnitPrice" id="proUnitPrice" class="form-control">
					</div>
				</div>
				<div class="col-sm-5 col-sm-offset-1">
					<div class="form-group">
						<label for="ProQuantity">Available Product Quantity :</label>
						<input type="text" name="ProQuantity" id="ProQuantity" class="form-control">
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="entQuantity">Enter Quantity :</label>
						<input type="text" name="entQuantity" id="entQuantity" placeholder="Enter product quantity...." class="form-control" required="1">
					</div>	
				</div>
			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<button class="btn btn-primary btn-block">Submit</button>
				</div>
			</div>
		</form>
		</div>
	</div>
</div>
<script src="last.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".myForm").change(function(){
			var proName=$(".selPorName").val();
			$.ajax({
				url:'ajaxAction/depoStoreSetupAjax.php',
				type:'POST',
				data:{nameVal:proName},
				success:function(data){
					$('#proUnitPrice').val(data.price);
					$('#ProQuantity').val(data.quantity);
				}
			});
		});
	});
</script>