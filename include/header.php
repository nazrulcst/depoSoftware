<?php
require('database.php');
include_once('necessaryClass/user.php');
$userId=$_SESSION['userId'];
$userNameSelect=$db->prepare("SELECT * FROM `user` WHERE id=?");
$userNameSelect->bindParam(1,$userId);
$userNameSelect->execute();
$userNameRow=$userNameSelect->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html>
	<head>
	  <meta charset="utf-8">
	  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <title>Depo Management Dashboard</title>
	  <!-- Tell the browser to be responsive to screen width -->
	  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <!-- Bootstrap 3.3.6 -->
	  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	  <!-- Font Awesome -->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	  <!--bootstrap datepicker-->
	  <link rel="stylesheet" href="../datepicker/css/datepicker.css">
	  <!-- Theme style -->
	  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	  <!-- AdminLTE Skins. Choose a skin from the css/skins
	       folder instead of downloading all of them to reduce the load. -->
	       <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/> 
	  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	  <!--Bootstrap Datepicker-->
	  <link rel="stylesheet" href="datepicker/css/datepicker.css">
	  <!-- bootstrap wysihtml5 - text editor -->
	  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
	  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	  <!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	  <![endif]-->
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">

		  <header class="main-header">
		    <!-- Logo -->
		    <a href="index.php" class="logo">
		      <!-- mini logo for sidebar mini 50x50 pixels -->
		      <span class="logo-mini"><b>DE</b>PO</span>
		      <!-- logo for regular state and mobile devices -->
		      <span class="logo-lg"><b>Depo</b>Admin</span>
		    </a>
		    <!-- Header Navbar: style can be found in header.less -->
		    <nav class="navbar navbar-static-top">
		      <!-- Sidebar toggle button-->
		      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		        <span class="sr-only">Toggle navigation</span>
		      </a>
		      <div class="navbar-custom-menu">
		        <ul class="nav navbar-nav">
		          <!-- Messages: style can be found in dropdown.less-->
		          <li class="dropdown messages-menu">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		              <i class="fa fa-envelope-o"></i>
		              <span class="label label-success">4</span>
		            </a>
		            <ul class="dropdown-menu">
		              <li class="header">You have 4 messages</li>
		              <li>
		                <!-- inner menu: contains the actual data -->
		                <ul class="menu">
		                  <li><!-- start message -->
		                    <a href="#">
		                      <div class="pull-left">
		                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
		                      </div>
		                      <h4>
		                        Support Team
		                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
		                      </h4>
		                      <p>Why not buy a new awesome theme?</p>
		                    </a>
		                  </li>
		                  <!-- end message -->
		                  <li>
		                    <a href="#">
		                      <div class="pull-left">
		                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
		                      </div>
		                      <h4>
		                        AdminLTE Design Team
		                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
		                      </h4>
		                      <p>Why not buy a new awesome theme?</p>
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <div class="pull-left">
		                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
		                      </div>
		                      <h4>
		                        Developers
		                        <small><i class="fa fa-clock-o"></i> Today</small>
		                      </h4>
		                      <p>Why not buy a new awesome theme?</p>
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <div class="pull-left">
		                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
		                      </div>
		                      <h4>
		                        Sales Department
		                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
		                      </h4>
		                      <p>Why not buy a new awesome theme?</p>
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <div class="pull-left">
		                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
		                      </div>
		                      <h4>
		                        Reviewers
		                        <small><i class="fa fa-clock-o"></i> 2 days</small>
		                      </h4>
		                      <p>Why not buy a new awesome theme?</p>
		                    </a>
		                  </li>
		                </ul>
		              </li>
		              <li class="footer"><a href="#">See All Messages</a></li>
		            </ul>
		          </li>
		          <!-- Notifications: style can be found in dropdown.less -->
		          <li class="dropdown notifications-menu">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		              <i class="fa fa-bell-o"></i>
		              <span class="label label-warning">10</span>
		            </a>
		            <ul class="dropdown-menu">
		              <li class="header">You have 10 notifications</li>
		              <li>
		                <!-- inner menu: contains the actual data -->
		                <ul class="menu">
		                  <li>
		                    <a href="#">
		                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
		                      page and may cause design problems
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <i class="fa fa-users text-red"></i> 5 new members joined
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
		                    </a>
		                  </li>
		                  <li>
		                    <a href="#">
		                      <i class="fa fa-user text-red"></i> You changed your username
		                    </a>
		                  </li>
		                </ul>
		              </li>
		              <li class="footer"><a href="#">View all</a></li>
		            </ul>
		          </li>
		          <!-- User Account: style can be found in dropdown.less -->
		          <li class="dropdown user user-menu">
		            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
		              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
		              <span class="hidden-xs"><?php echo $userNameRow->userName;?></span>
		            </a>
		            <ul class="dropdown-menu">
		              <!-- User image -->
		              <li class="user-header">
		                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

		                <p>
		                  Nazrul Islam- Web Developer
		                  <small>Member since Nov. 2016</small>
		                </p>
		              </li>
		              <!-- Menu Footer-->
		              <li class="user-footer">
		                <div class="pull-left">
		                  <a href="#" class="btn btn-primary">Profile</a>
		                </div>
		                <div class="pull-right">
		                  <a href="login.php?page=logOut" class="btn btn-primary">Sign out</a>
		                </div>
		              </li>
		            </ul>
		          </li>
		        </ul>
		      </div>
		    </nav>
		  </header>