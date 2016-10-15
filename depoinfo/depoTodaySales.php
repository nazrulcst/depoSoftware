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
			<h3 class="text-center text-green">Enter your today sales product item</h3>
			<hr>	
		</div>
	</div>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1" style="margin-top:15px;">
		<form action="action/todaySalesInsertAction.php" method="post" class="myForm">
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
					<select name="proName" class="form-control selPorName" id="proId">
						<option value="">Select your product name</option>
						<?php echo $proNameData;?>
					</select>
				</div>
			</div>
			<div class="col-sm-5 col-sm-offset-1">
				<div class="form-group">
					<label for="proUnitPrice">Product Unit Price :</label>
					<input type="text" name="proUnitPrice" id="proUnitPrice" class="form-control" placeholder="Product unit price...">
				</div>
			</div>
			<div class="col-sm-5">
				<div class="form-group">
					<label for="salesQuantity">Sales product Quantity (pcs) :</label>
					<input type="text" name="salesQuantity" id="salesQuantity" class="form-control totaltaka" placeholder="Enter your today sales quantity">
				</div>
			</div>
			<div class="col-sm-10 col-sm-offset-1">
				<div class="form-group">
					<label for="totalTaka">Total Tk :</label>
					<input type="text" name="totalTaka" id="totalTaka" class="form-control" placeholder="Today total sales amount...">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-10 col-sm-offset-1">
					<button class="btn btn-primary btn-block clickBtn">Submit</button>
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
				url:'ajaxAction/todaySalesAjax.php',
				type:'POST',
				data:{nameVal:proName},
				success:function(data){
					$('#proUnitPrice').val(data.price);
				}
			});
		});
		$(".totaltaka").mousemove(function(){//Total amount show script  mousemove
			var todaySales=$("#salesQuantity").val();
			var unitPrice=$("#proUnitPrice").val();
			$.ajax({
				url:'ajaxAction/todaySalesTotalAjax.php',
				type:'POST',
				data:{salesVal:todaySales,unitPriceVal:unitPrice},
				success:function(salesTK){
					$("#totalTaka").val(salesTK.totalPrice);
				}
			});
		});
		
	});
</script>