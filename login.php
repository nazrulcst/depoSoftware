<?php
	session_start();
	if(isset($_GET['page']) && $_GET['page']=="logOut"){
		session_destroy();
	}
	if(isset($_SESSION['userId'])){
		header("Location:index.php");
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Login</title>
	<link rel="stylesheet" href="style.css">
	<!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 login">
				<form action="loginAction.php" method="post">
					<div>
						<p>Administration Login</p>
						<?php
							if(isset($_SESSION['msg'])){
								echo $_SESSION['msg'];
								unset($_SESSION['msg']);
							}
						?>
					</div>
					<div class="form-group">
						<label for="loginUser">User Name :</label>
						<input type="text" id="loginUser" name="loginUser" placeholder="Enter your user name" class="form-control" autofocus>
					</div>
					<div class="form-group">
						<label for="password">Password :</label>
						<input type="password" id="password" name="password" placeholder="Enter your password" class="form-control">
					</div>
					<div class="form-group">
						<button class="btn btn-primary btn-block" href="">Sign in</button>						
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>