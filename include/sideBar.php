  <aside class="main-sidebar">  
		    <!-- sidebar: style can be found in sidebar.less -->
		    <section class="sidebar">
		      <!-- Sidebar user panel -->
		      <div class="user-panel">
		        <div class="pull-left image">
		          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
		        </div>
		        <div class="pull-left info">
		          <p><?php echo $userNameRow->userName;?></p>
		          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
		        </div>
		      </div>
		      <!-- search form -->
		      <form action="#" method="get" class="sidebar-form">
		        <div class="input-group">
		          <input type="text" name="q" class="form-control" placeholder="Search...">
		              <span class="input-group-btn">
		                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
		                </button>
		              </span>
		        </div>
		      </form>
		      <!-- /.search form -->
		      <!-- sidebar menu: : style can be found in sidebar.less -->
		      <ul class="sidebar-menu">
		        <li class="header">MAIN NAVIGATION</li>
		        <li class="<?php echo(isset($_GET['folder']) && $_GET['folder']=='setup')?'active':null;?> treeview">
		          <a href="#">
		            <i class="fa fa-cog text-green"></i> <span>General Setup</span>
		            <span class="pull-right-container">
		              <i class="fa fa-angle-left pull-right"></i>
		            </span>
		          </a>
		          <ul class="treeview-menu">
		            <li class="<?php echo (isset($_GET['page']) && $_GET['page']=='categorySetup')? 'active':null;?>"><a href="index.php?page=categorySetup&folder=setup"><i class="fa fa-circle-o"></i>Category Setup</a></li>
		            <li class="<?php echo (isset($_GET['page']) && $_GET['page']=='userCreateSetup')? 'active':null;?>"><a href="index.php?page=userCreateSetup&folder=setup"><i class="fa fa-circle-o"></i>Create new user</a></li>
		            <li class="<?php echo (isset($_GET['page']) && $_GET['page']=='viewAlluser')? 'active':null;?>"><a href="index.php?page=viewAlluser&folder=setup"><i class="fa fa-circle-o"></i>All user list</a></li>
		            <li class="<?php echo (isset($_GET['page']) && $_GET['page']=='viewAlldepoList')? 'active':null;?>"><a href="index.php?page=viewAlldepoList&folder=setup"><i class="fa fa-circle-o"></i>All depo list</a>
		            </li>

		          </ul>
		        </li>
		        <!--Depo Info start-->
		        <li class="<?php echo(isset($_GET['folder']) && $_GET['folder']=='depoinfo')?'active':null;?> treeview">
		          <a href="#">
		            <i class="fa fa-building text-green"></i> <span>Depo Setup</span>
		            <span class="pull-right-container">
		              <i class="fa fa-angle-left pull-right"></i>
		            </span>
		          </a>
		          <ul class="treeview-menu">
		            <li class="<?php echo (isset($_GET['page']) && $_GET['page']=='depoInfoSetup')? 'active':null;?>"><a href="index.php?page=depoInfoSetup&folder=depoinfo"><i class="fa fa-circle-o"></i>Create new depo</a></li>
		            <li class="<?php echo (isset($_GET['page']) && $_GET['page']=='depoView')? 'active':null;?>"><a href="index.php?page=depoView&folder=depoinfo"><i class="fa fa-circle-o"></i>View depo</a></li>
		            <li class="<?php echo (isset($_GET['page']) && $_GET['page']=='depoStoreSetup')? 'active':null;?>"><a href="index.php?page=depoStoreSetup&folder=depoinfo"><i class="fa fa-circle-o"></i>Depo Store</a></li>
		            <li class="<?php echo (isset($_GET['page']) && $_GET['page']=='depoTodaySales')? 'active':null;?>"><a href="index.php?page=depoTodaySales&folder=depoinfo"><i class="fa fa-circle-o"></i>Today sales</a></li>
		            <li class="<?php echo (isset($_GET['page']) && $_GET['page']=='viewDepoTotalSales')? 'active':null;?>"><a href="index.php?page=viewDepoTotalSales&folder=depoinfo"><i class="fa fa-circle-o"></i>View all sales</a></li>
		          </ul>
		        </li>
		        <!--Depo Info End-->
		        <!--Products Setup start-->
		        <li class="<?php echo(isset($_GET['folder']) && $_GET['folder']=='products')?'active':null;?> treeview">
		          <a href="#">
		            <i class="fa fa-product-hunt text-green"></i> <span>Products Setup</span>
		            <span class="pull-right-container">
		              <i class="fa fa-angle-left pull-right"></i>
		            </span>
		          </a>
		          <ul class="treeview-menu">
		            <li class="<?php echo (isset($_GET['page']) && $_GET['page']=='productSetup')? 'active':null;?>"><a href="index.php?page=productSetup&folder=products"><i class="fa fa-circle-o"></i>Add new product</a></li>
		            <li class="<?php echo(isset($_GET['page']) && $_GET['page']=='productViewList')?'active':null;?>">
		            	<a href="index.php?page=productViewList&folder=products"><i class="fa fa-circle-o"></i>View all product list</a>
		            </li>
		          </ul>
		        </li>
		        <!--Products Setup End-->
		      </ul>
		    </section>
		    <!-- /.sidebar -->
		  </aside>