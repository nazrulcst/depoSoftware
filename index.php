<?php include_once('loginValidation.php');?>
<?php include('include/header.php'); ?>
<?php include('include/sideBar.php');?>
<?php //include('necessaryClass/user.php');?>

		  <div class="content-wrapper"> <!-- Content Wrapper-->
		    <section class="content"><!-- Main content -->
		    	<?php
		    		if(isset($_GET['page'])){
		    			$page=$_GET['page'];
		    			if(isset($_GET['folder'])){
		    				$folder=$_GET['folder'];
		    				include($folder.'/'.$page.'.php');
		    			}else{
		    				include($page.'.php');
		    			}
		    		}
		    		if(!isset($_GET['page'])){//it's use for just only index.php
		    			echo"<h1 class='text-primary text-center'>Welcome Dashboard</h1>";
		    			echo"<hr>";
		    			$info="
		    				<h3>Hello World </h3>
		    				<pre>Say something about you (-_-)</pre>
		    			";
		    			echo $info;	
		    		}
		    	?>
		    </section><!-- /Main content -->
		  </div><!-- / End content-wrapper -->
<?php include('include/footer.php');?>