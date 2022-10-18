<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Dashboard Bali Aiport Apps">
    <meta name="author" content="Luqman hakim">

    <title>LTMS | Pairing</title>
    <link rel="icon" type="image/png" href="<?php echo base_url();?>asset/images/icons.ico"/>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url();?>asset/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url();?>asset/css/sb-admin.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="<?php echo base_url();?>asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> 
    <link href="<?php echo base_url();?>asset/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"> 
    <link href="<?php echo base_url();?>asset/css/jquery-ui.css" rel="stylesheet" type="text/css">     
    <!-- <link href="<?php echo base_url();?>asset/css/lightbox.css" rel="stylesheet">  -->
	<link href="<?php echo base_url();?>asset/css/custom.css" rel="stylesheet">
	<link href="<?php echo base_url();?>asset/css/loader.css" rel="stylesheet">
	<link href="<?php echo base_url();?>asset/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="<?php echo base_url();?>asset/js/jquery.js"></script>
    <script src="<?php echo base_url();?>asset/js/bootstrap.min.js"></script>  
    <script src="<?php echo base_url();?>asset/js/jquery-ui.js"></script> 
    <script src="<?php echo base_url();?>asset/js/jquery.dataTables.min.js"></script>
    <!-- <script src="<?php echo base_url();?>asset/js/pekeUpload.js"></script>  -->
	<script src="<?php echo base_url();?>asset/js/select2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>asset/simpleClock/simpleClock.js"></script>
	
	<style>
		.no{
			width: 50px;
		}
		.right{
			text-align: right;
		}
		.tengah{
			text-align: center;
		}
		.peringatan{
			background:red;
			color:white;
		}
		td, th {
			padding: 5px;
		}
		.form-control {
			height: 30px;
		}
	</style>
	<script>
		function loading(){
			$('#loading').show();
		}
		
		$( document ).ready(function() {
			$('#loading').hide();
			$('#clock').simpleClock();
		});
	</script>
</head>
<body style="background: url('<?php echo base_url();?>asset/images/Taxi-icon.jpg') no-repeat fixed right bottom; background-size: 15%;">
	<div id="loading">
		<div id="loader"></div>
	</div>
	<div id="wrapper"> <!-- end of header -->
        <?php require_once "menu.php";?>
			<div id="page-wrapper">
				<div class="container-fluid" style="padding:0;">
					<!-- Page Heading -->
					<div class="row">
						<div class="col-lg-12">
							<h3 class="page-header" style="padding-left:30px; margin-bottom:5px;">
								<i id="header-icon" class="fa fa-money"></i>&nbsp;&nbsp;<?php if(isset($title)) { echo $title; } else { echo "UNLOGIN";}?>
							</h3>
						</div>
					</div>