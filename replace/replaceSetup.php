<?php
	require('database.php');
	include_once('necessaryClass/user.php');
	$loginUserId=$obj->userLoginId();
	$selDepoInfo=$db->prepare("SELECT depo.id AS depoId,depo.depo_name,user.id FROM `depo` LEFT JOIN user ON depo.user_id=user.id WHERE user.id=?");
	$selDepoInfo->bindParam(1,$loginUserId);
	$selDepoInfo->execute();
	$depoInfoData='';
	while($eslDepoInfoRow=$selDepoInfo->fetch(PDO::FETCH_OBJ)){
		$depoInfoData.="
			<option value='$eslDepoInfoRow->depoId'>$eslDepoInfoRow->depo_name</option>
		";
	}
	$proNameSelect=$db->prepare("SELECT depo_store.*, products.pro_name  AS  productName FROM `depo_store` LEFT JOIN products ON depo_store.pro_id=products.id GROUP BY productName");
	$proNameSelect->execute();
	$proNameData='';
	while($proNameSelRow=$proNameSelect->fetch(PDO::FETCH_OBJ)){
		$proNameData.="
			<option value='$proNameSelRow->pro_id'>$proNameSelRow->productName</option>
		";
	}
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h3 class="text-center text-green">Enter your replacement produc</h3>
			<hr>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:25px;">
			<form action="action/replaceSetupAction.php" method="post">
				<div class="col-sm-5 col-sm-offset-1">
					<div class="form-group">
						<label for="depo">Depo Name :</label>
						<select name="depoName" class="form-control" id="depoId">
							<option value="">Select your depo name</option>
							<?php echo $depoInfoData;?>
						</select>
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="proName">Product Name :</label>
						<select name="proName" class="form-control" id="proId">
							<option value="">Select your product name</option>
							<?php echo $proNameData;?>
						</select>
					</div>
				</div>
				<div class="col-sm-5 col-sm-offset-1">
					<div class="form-group">
						<label for="proPrice">Product price :</label>
						<input type="text" name="proPrice" class="form-control" id="proPriceId" placeholder="Product unit price">	
					</div>
				</div>
				<div class="col-sm-5">
					<div class="form-group">
						<label for="repQuantity">Replace quantity :</label>
						<input type="text" name="repQuantity" class="form-control" id="repQuantity" placeholder="Enter your replacement quantity">
					</div>
				</div>
				<div class="col-sm-10 col-sm-offset-1">
					<button type="submit" class="btn btn-primary btn-block">Submit</button>					
				</div>
			</form>	
		</div>
	</div>	
</div>
<script src="last.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#proId").change(function(){
			var pro_id=$(this).val();
			$.ajax({
				url:'ajaxAction/replaceSetupAjax.php',
				type:'POST',
				data:{protIdVal:pro_id},
				success:function(data){
					$("#proPriceId").val(data.price);
				}
			});
		});
	});
	
</script>