<!DOCTYPE html>
<html lang="en">
    
<head>     
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
    
    <title>KiosK Login</title>
    <link rel="icon" type="image/png" href="<?php echo base_url();?>asset/images/favicon.png"/>
    <link href="<?php echo base_url();?>asset/css/luq.css" type="text/css" rel="stylesheet" >
    <link href="<?php echo base_url();?>asset/css/bootstrap.min.css" rel="stylesheet">    
    <link href="<?php echo base_url();?>asset/css/stylesheet.css" type="text/css" rel="stylesheet" >
    <link href="<?php echo base_url();?>asset/css/font-awesome.min.css" rel="stylesheet" type="text/css">                      

    <script src="<?php echo base_url();?>asset/js/jquery.js"></script>
    <style>
        #submit {
            background: rgba(0, 0, 0, 0.4) none repeat scroll 0 0;
        }
        
        #submit:hover{
            background: rgba(0,0,0,0.8) !important;
        }
        
        .form-control{
            font-size: 15px !important;
            color: #000000;
            font-weight: bold;
        }
    </style>
</head>
<body class="bg-img-num1" style="font-family: Arial Rounded MT Bold; background: url('<?php echo base_url();?>asset/images/taxi.jpg') no-repeat fixed left bottom;"> 
    
    <div class="container">      

        <div class="login-block" style="margin-top:200px;">
            <div class="block block-transparent"> 
                <div class="head">     
                    <center>
                        <img src="<?php echo base_url();?>asset/images/angkasa-pura.png" width="350px">          
                    </center>                                       
                </div>
                <div class="content controls npt" style="border-radius: 15px; margin-top: 50px;">
                    <div class="form-row">
                        <div class="col-md-12 judul2">                            
                            <center><h2>KiosK Ground Transportation</h2></center>                            
                        </div>
                    </div>
					<form method="post" action="<?php echo base_url('page/process_login');?>">
					    <div class="form-row user-change-row" style="display: block; margin-top: 20px;">
							<div class="col-md-12">
								<div class="input-group" >
									<div class="input-group-addon">
										<span class="icon-user"></span>
									</div>
									<input type="text" placeholder="Login" id="uname" name="username" autofocus="" class="form-control">
								</div>
							</div>
						</div>                    
						<div class="form-row">
							<div class="col-md-12">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="icon-key"></span>
									</div>
									<input type="password" id="pass" name="password" class="form-control" placeholder="Password"/>
								</div>
							</div>
						</div>                        
						<div class="form-row">
							<div class="col-md-6">
                                <p style="color: red;">
    								<?php 
                                        $message = $this->session->flashdata('msg');
                                        echo $message;
                                    ?>
                                </p>
							</div>
							<div class="col-md-6">
								<input class="btn btn-default btn-block btn-clean" name="btn_login" type="submit" id="submit" value="Login">
							</div>
						</div> 
					</form>
                </div>
            </div>
        </div>

    </div>

</body>
</html>