<!-- Navigation -->
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#" style="padding: 6px;">
				<img src="<?php echo base_url();?>asset/images/logo_apps.png" width="40px" height="40px">
			</a>
			<a class="navbar-brand" href="<?php echo site_url();?>" >
				<h3 style="margin-top:12px;color:white;"> <strong> Land Transport Management System</strong> </h3>
			</a>
			
		</div>
		<!-- Top Menu Items -->
		<ul class="nav navbar-right top-nav">    			       
			<li class="dropdown">
				<a href="#" style="color: white;">
					<div id="clock">
						<div id="time"></div>
						<!-- <div id="date"></div> -->
					</div>
				</a>
			</li> 
			<li class="dropdown">
				<a href="#" style="color: white;"><?php if($this->session->userdata('nama')) { echo strtoupper($this->session->userdata('nama'))." ".strtoupper($this->session->userdata('terminal')); } else { echo "UNLOGIN"; }?></a>
			</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-bottom: 22px;"><i class="fa fa-user"></i><b class="caret"></b></a>
				<ul class="dropdown-menu" style="min-width: 200px;">
					<li>
						<a href="#" id="setting" data-toggle="modal" data-target="#myChangePassword"><i class="fa fa-fw fa-gear"></i> Setting</a>
					</li>
					<li>
						<a href="#" id="cancel" data-toggle="modal" data-target="#listOrder" onclick="list_order()"><i class="fa fa-fw fa-close"></i> Cancel Order</a>
					</li>
					<li>						
						<a href="<?php echo site_url('page/ready_line');?>" target="_blank"><i class="fa fa-fw fa-car"></i> Ready Line</a>
					</li>
					<li class="divider"></li>
					<li>
						<a href="<?php echo site_url('page/logout');?>" onclick="return confirm('Are you sure?')"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
					</li>
				</ul>
			</li>			
		</ul>
		<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
		<!--<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav side-nav" id="sidebar-menu">
				<li id="menu_dashboard" class="active">
					<a href="<?php echo base_url();?>" onclick="menu_dashboard()"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
				</li>
				<li id="menu_input">
					<a href="<?php echo base_url('input');?>" ><i class="fa fa-fw fa-upload"></i> Input Data</a>
				</li>
				<li id="menu_master">
					<a href="javascript:;" data-toggle="collapse" data-target="#drop_master"><i class="fa fa-fw fa-dashboard"></i> Master Data<i class="fa fa-fw fa-caret-down"></i></a>
					<ul id="drop_master" class="collapse">
						<li>
							<a href="<?php echo base_url('master/handling');?>" >Handling</a>
						</li>
						<li>
							<a href="<?php echo base_url('master/operator');?>" >Operator</a>
						</li>
						<li>
							<a href="<?php echo base_url('master/aircraft');?>" >Aircraft</a>
						</li>
						<li>
							<a href="<?php echo base_url('master/airport');?>" >Airport</a>
						</li>
					</ul>
				</li>
				
				
			</ul>
		</div>-->
		<!-- /.navbar-collapse -->
	</nav>