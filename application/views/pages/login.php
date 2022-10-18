<!DOCTYPE html>
<html lang="en">
    
<head>     
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
    
    <title>LTMS Login</title>
    <link rel="icon" type="image/png" href="<?php echo base_url();?>asset/images/icons.ico"/>
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
            background: rgba(255,255,0,0.3) !important;
        }
        
        .form-control{
            font-size: 15px !important;
            color: #000000;
            font-weight: bold;
        }
    </style>
    <script type="text/javascript">
        function cek_terminal(){
            var terminal = $('#terminal').val();
            if(terminal == '0'){
                document.getElementById("btn_login").disabled = true;
            } else {
                document.getElementById("btn_login").disabled = false;
            }
        }

        $( document ).ready(function() {
            document.getElementById("btn_login").disabled = true;
        });
    </script>
</head>
<body class="bg-img-num1" style="font-family: Arial Rounded MT Bold; background: url('<?php echo base_url();?>asset/images/bg7.jpg') no-repeat center center fixed; background-size: cover;"> 
    <div class="container">      
        <div class="login-block" style="margin-top:200px;">
            <div class="block-transparent"> 
                <div class="head" style="margin-bottom: 50px;">     
                    <center>
                        <img src="<?php echo base_url();?>asset/images/angkasa-pura.png" width="350px">
                    </center>                                       
                </div>
                <div class="block">
                    <div class="content tab-content controls npt" style="border-radius: 5px;">
                        <div class="form-row">
                            <div class="col-md-12 judul">                            
                                <center><h2>Land Transport Management System</h2></center>                            
                            </div>
                        </div>
    					<form method="post" action="<?php echo site_url('page/process_login');?>">
    					    <div class="form-row user-change-row" style="display: block; margin-top: 20px;">
                                <div class="col-md-12">
                                    <div class="input-group" >
                                        <div class="input-group-addon">
                                            <span class="icon-home"></span>
                                        </div>
                                        <select class="form-control" style="color: #fff;" name="terminal" id="terminal" onchange="cek_terminal()" required="">
                                            <option value="0">-- Pilih Terminal --</option>
                                            <?php 
                                                foreach ($terminal as $key) {
                                                    echo "<option value='".$key->id."_".$key->name."'>".$key->name."</option>";
                                                }
                                            ?>                                            
                                        </select>                                        
                                    </div>
                                </div>
                            </div>  
                            <div class="form-row user-change-row" style="display: block; margin-top: 20px;">
    							<div class="col-md-12">
    								<div class="input-group" >
    									<div class="input-group-addon">
    										<span class="icon-user"></span>
    									</div>
    									<input type="text" placeholder="Login" id="uname" name="username" class="form-control" style="color: #fff;" required="">
    								</div>
    							</div>
    						</div>                    
    						<div class="form-row">
    							<div class="col-md-12">
    								<div class="input-group">
    									<div class="input-group-addon">
    										<span class="icon-key"></span>
    									</div>
    									<input type="password" id="pass" name="password" class="form-control" placeholder="Password" style="color: #fff;" required="">
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
                                    <input class="btn btn-default btn-block btn-clean" name="btn_login" id="btn_login" type="submit" id="submit" value="Login" onclick="return confirm('Are you sure?')">
                                </div>
                            </div> 
    					</form>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>