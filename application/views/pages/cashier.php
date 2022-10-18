<script type="text/javascript">	
	function get_trans_kiosk(){
		var barcode = $('#barcode').val();
        
        if(barcode == ''){        
        	$('#barcode').val('');	
            return false;
        } else {
        	$('#loading').show();			
        	var data = { "barcode" 	: barcode };
        	var content = "";
        	var cont_opr = "";

            $.post("<?php echo site_url('cashier/get_trans_kiosk');?>", data,
                function (msg){       
					//alert('sampe sini');
                    console.log(msg);     
                    $('#loading').hide();
                    if(typeof(msg.trans) != "undefined" && msg.trans !== null && msg.trans.length > 0 ){
                    	for(var i=0; i < msg.opr.length; i++){
                    		var v1 = msg.opr[i].id+"_"+msg.opr[i].name;
                    		cont_opr += "<option value='"+v1+"'>"+msg.opr[i].name+"</option>";
                    	}
                    	$('#operator').html(cont_opr);	

                    	if(msg.trans[0].vehicle_type == '1'){
							$('#cost').val('ARGO PRICE');
                    	} else {
                    		$('#cost').val('');
                    	}
                    	 
                    	$('#operator').val(msg.trans[0].operator_id+"_"+msg.trans[0].nama_operator); 
                    	$('#id_transaksi_kiosk').val(msg.trans[0].id_transaksi_kiosk);  
                    	//$('#id_ready_line').val(msg.trans[0].id_ready_line);                    	
                    	for(var i=0; i < msg.trans.length; i++){
                    		var ready_line = msg.trans[i].entry_ready_line;
                    		var value = msg.trans[i].id_transaksi+"_"+msg.trans[i].plate_no+"_"+msg.trans[i].no_lambung+"_"+msg.trans[i].id_ready_line; // kode id_transaksi_pengendapan + plate no + driver name	+ id_ready_line
	                    	content += "<option value='"+value+"'>Lmb "+msg.trans[i].no_lambung+" ["+ready_line.substring(11, 16)+"] - "+msg.trans[i].plate_no+"</option>";
	                    }
	                    $('#driver').html(content);	
                    } else {
            			alert(msg.error);
            			window.location.reload(true);
                    }                                    
                }
            , "JSON");
        }
	}

	function get_driver(){
		var operator = $('#operator').val();
		var content = "";

		if(operator == '0'){
			alert("Please choose operator");
		} else {
			var data = { "operator" 	: operator };
			$('#loading').show();
			$.post("<?php echo site_url('cashier/get_driver');?>", data,
	            function (msg){
	                console.log(msg);
	                $('#loading').hide();   
	                // content = "<option value='0'>-- Pilih Driver --</td>";	                
	                if(msg.length > 0){
	                	for(var i=0; i < msg.length; i++){
                    		var ready_line = msg[i].entry_ready_line;
                    		var value = msg[i].id_transaksi+"_"+msg[i].plate_no+"_"+msg[i].no_lambung+"_"+msg[i].id_ready_line; // kode id_transaksi_pengendapan + plate no + driver name + id_ready_line
	                    	content += "<option value='"+value+"'>Lmb "+msg[i].no_lambung+" ["+ready_line.substring(11, 16)+"] - "+msg[i].plate_no+"</td>";
	                    }
	                    $('#driver').html('');
	                    $('#driver').html(content);							
	                } else {
	                	alert('Driver Not Found, Please Choose Another Operator !');
	                	content = "<option value='0'>-- NOT DRIVER FOUND --</td>";	
	                	$('#driver').html(content);		
	                }                 
	            }
	        , "JSON");  
		}		
	}

	function save(){
    	var barcode 	= $('#barcode').val();
    	var penumpang	= $('#penumpang').val();    	
    	var operator	= $('#operator').val(); 
    	var driver		= $('#driver').val(); 
    	var cost 		= $('#cost').val();
    	var destination = $('#destination').val();
    	
    	if(operator == '0' || driver == '0' || barcode == '' || penumpang == '' || cost == '' || destination == ''){
    		return false;
    	} else {
    		setTimeout(function(){ window.location.reload(true); }, 3000);
    	}
		
	}

	function checkPasswordMatch() {
		var password = $("#new_pass").val();
		var confirmPassword = $("#re_pass").val();

		if(password != '' && confirmPassword != ''){
			if (password != confirmPassword){
				$("#warning").html("<font color='red'><b>Passwords do not match!</b></font>");
				$('#btn_submit_admin').hide();
			} else {
				$("#warning").html("<font color='green'><b>Passwords match!</b></font>");
				$('#btn_submit_admin').show();
			}
		}
	}	

	function update_occupied(){
		$.post("<?php echo site_url('cashier/update_occupied');?>",
	            function (msg){
	                console.log(msg);        
	                var content = "<pre> <b>Ready Vehicle</b><br/>";

	                if(msg.length > 0){
	                	<?php 
	                		$terminal_id = $this->session->userdata('terminal_id');
	                		if($terminal_id == '1'){
	                	?>
		                    for(var i=0; i < msg.length; i++){
		                		if(msg[i].available_dom == 0){
		                			content += msg[i].name+" : <b>"+msg[i].available_dom+"</b> vehicle<br/>";
		                		} else {
		                			content += "<a href='#' onclick='get_occupied("+msg[i].id+")' data-toggle='modal' data-target='#list_vehicle'>"+msg[i].name+" : <b>"+msg[i].available_dom+"</b> vehicle<br/></a>";
		                		} 	
		                    }
	                    <?php } else { ?>
	                    	for(var i=0; i < msg.length; i++){
		                		if(msg[i].available_int == 0){
		                			content += msg[i].name+" : <b>"+msg[i].available_int+"</b> vehicle<br/>";
		                		} else {
		                			content += "<a href='#' onclick='get_occupied("+msg[i].id+")' data-toggle='modal' data-target='#list_vehicle'>"+msg[i].name+" : <b>"+msg[i].available_int+"</b> vehicle<br/></a>";
		                		} 	
		                    }
	                    <?php } ?>	                	
	                    content += "</pre>";
	                    $('#occupied').html(content);
	                }               
	            }
	        , "JSON");  
	} 

	function get_occupied(id_opr){
		var id = id_opr;
		var content = "";

		if(id == '0' || id == ''){
			alert("No ID Operator");
		} else {
			var data = { "operator" : id };
			$.post("<?php echo site_url('cashier/get_list_occupied');?>", data,
	            function (msg){
	                console.log(msg);   
	                if(msg.length > 0){
	                	for(var i=0; i < msg.length; i++){
	                		content += "<tr>";
	                		content += "<td>"+(i+1)+"</td>";
                    		content += "<td>"+msg[i].nama_operator+"</td>";
                    		content += "<td>"+msg[i].no_lambung+"</td>";
                    		content += "<td>"+msg[i].plate_no+"</td>";
                    		content += "<td>"+msg[i].entry_ready_line+"</td>";
                    		content += "<td><center><a href='#' onclick='kick("+msg[i].id+")'><i class='fa fa-trash'></i></a></center></td>";
                    		content += "</tr>";
                    		
	                    }

	                    $('#tabel_list_occupied').dataTable().fnDestroy();
	                    $('#list_occupied').html('');	
	                    $('#list_occupied').html(content);
	                    $('#tabel_list_occupied').DataTable({
							'iDisplayLength': 10,
							"bAutoWidth": false,
							"aoColumns": [{"sWidth":"2%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"}, {"sWidth":"3%"}]
						});

	                } else {
	                	alert('Failed!');
	                }                 
	            }
	        ,"JSON");  
		}		
	}	

	function data_vehicle_otw(){
        $.post("<?php echo site_url('cashier/vehicle_otw');?>",
            function (msg){
                console.log(msg);        
                var content = "<pre> <b>On The Way Vehicle</b><br/>";

                if(msg.length > 0){
                	<?php 
                		$terminal_id = $this->session->userdata('terminal_id');
                		if($terminal_id == '1'){
                	?>
	                    for(var i=0; i < msg.length; i++){
	                        content += msg[i].name+" : <b>"+msg[i].available_dom+"</b> vehicle<br/>";    	
	                    }
                    <?php } else { ?>
                    	for(var i=0; i < msg.length; i++){
	                        content += msg[i].name+" : <b>"+msg[i].available_int+"</b> vehicle<br/>";    	
	                    }
                    <?php } ?>
                    content += "</pre>";
                    $('#vehicle_otw').html(content);
                }               
            }
        , "JSON");  
    }


	function kick(idne){
		var id = idne;

		var result = confirm('Are you sure want to kick ?');

		if(result) {
			if(id == '0' || id == ''){
				alert("No ID Operator");
			} else {
				var data = { "id" : id };
				$.post("<?php echo site_url('cashier/kick');?>", data,
		            function (msg){
		                console.log(msg);   
		                if(msg == 1){
		                	alert('Taxi has been kicked');
		                	update_occupied(); 
		                	$('#closeButton').click(); 
		                } else {
		                	alert('Failed!');
		                }                 
		            }
		        );  
			}
		}
		else {
			return false;
		}		
	}


	function list_order(){
		var content = "";

		$.post("<?php echo site_url('cashier/get_list_order');?>",
            function (msg){
                console.log(msg);   
                if(msg.length > 0){
                	for(var i=0; i < msg.length; i++){
                		content += "<tr>";
                		content += "<td>"+(i+1)+"</td>";
                		content += "<td>"+msg[i].nama_operator+"</td>";
                		content += "<td>"+msg[i].no_lambung+"</td>";
                		content += "<td>"+msg[i].plate_no+"</td>";
                		content += "<td>"+msg[i].pax_name+"</td>";                		
                		content += "<td>"+msg[i].tujuan+"</td>";
                		content += "<td><center><a href='#' onclick='showReason("+msg[i].id+","+msg[i].transactions_id+","+msg[i].taxi_id+")'><i class='fa fa-trash'></i></a></center></td>";
                		content += "</tr>";                		
                    }

                    $('#tabel_list_order').dataTable().fnDestroy();
                    $('#list_order').html('');	
                    $('#list_order').html(content);
                    $('#tabel_list_order').DataTable({
						'iDisplayLength': 10,
						"bAutoWidth": false,
						"aoColumns": [{"sWidth":"2%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"}, {"sWidth":"10%"},{"sWidth":"5%"}]
					});

                } else {
                	$('#tabel_list_order').dataTable().fnDestroy();
                    $('#list_order').html('');	
                    $('#list_order').html(content);
                    $('#tabel_list_order').DataTable({
						'iDisplayLength': 10,
						"bAutoWidth": false,
						"aoColumns": [{"sWidth":"2%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"}, {"sWidth":"10%"},{"sWidth":"5%"}]
					});
                }                 
            }
        ,"JSON");	
	}	

	function showReason(idne,trans_id,taxi_id){
		// console.log();
		var id = ""+idne+"_"+trans_id+"_"+taxi_id;

		$('#listOrder').modal('hide');
		$('#modalReasonCancel').modal('show');
		$('#ready_line_id').val(id);
	}

	var idletime = 0;

	function timerIncrement(){
		console.log(idletime);
		idletime++;
		update_occupied();
		data_vehicle_otw();
	}
	
	$( document ).ready(function() {   
		var idleInterval = setInterval(timerIncrement, 5000);  
		update_occupied();   
		data_vehicle_otw();                                    
		$("#new_pass").keyup(checkPasswordMatch);
		$("#re_pass").keyup(checkPasswordMatch);

		$("#header-icon").attr('class', 'fa fa-money');
		$('#tabel_transaksi').DataTable({
			'iDisplayLength': 50,
			"bAutoWidth": false,
			"aoColumns": [{"sWidth":"2%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"5%"},{"sWidth":"5%"}, {"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"20%"},{"sWidth":"5%"}]
		});
		$('#tabel_list_occupied').DataTable();
		$('#tabel_list_order').DataTable({
			'iDisplayLength': 50,
			"bAutoWidth": false,
			"aoColumns": [{"sWidth":"2%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"}, {"sWidth":"10%"},{"sWidth":"5%"}]
		});
		
		<?php
			if($this->session->flashdata('msgPass')){
				?> alert("<?php echo $msgPass;?>"); <?php
			}
		?>
	});
</script>
		<div class="row bs-example">
			<div class="col-md-4">
				<form action="<?php echo site_url('cashier/save');?>" method="POST" id="form_pairing" style="padding-top:0;" target="_blank">
					<table class="table" style="font-size:12px; padding:0;">
						<tr>
							<td width="25%">
								<label class="control-label" style="font-size: 14pt;">Barcode</label>
							</td>
							<td width='2%'>
								<label class="control-label" style="font-size: 14pt;">:</label>
							</td> 
							<td>
								<input type="text" class="form-control" id="barcode" name="barcode" required="required" style="display: inline-block; font-size: 12pt; text-transform: uppercase;" onblur="get_trans_kiosk()" autofocus="" maxlength="17">
								<!--<button type="button" class="btn btn-warning">Check</button>-->
							</td>
						</tr>
						<tr>
							<td>
								<label class="control-label" style="font-size: 14pt;">Operator</label>
							</td>
							<td width='2%'>
								<label class="control-label" style="font-size: 14pt;">:</label>
							</td> 
							<td>
								<select id="operator" class="form-control" name="operator" onchange="get_driver()" style="font-size: 11pt">
									<option value="0">-- Pilih Operator--</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<label class="control-label" style="font-size: 14pt;">Vehicle</label>
							</td>
							<td width='2%'>
								<label class="control-label" style="font-size: 14pt;">:</label>
							</td> 
							<td>
								<select id="driver" class="form-control" name="driver" style="font-size: 10pt">
									<option value="0">-- Vehicle Not Found--</option>									
								</select>
							</td>
						</tr>											
						<tr>
							<td>
								<label class="control-label" style="font-size: 14pt;">Customer</label>
							</td>
							<td width='2%'>
								<label class="control-label" style="font-size: 14pt;">:</label>
							</td> 
							<td>
								<input type="text" class="form-control" id="penumpang" name="penumpang" required="required" style="font-size: 12pt;" maxlength="20">
							</td>
						</tr>
						<tr>
							<td>
								<label class="control-label" style="font-size: 14pt;">Destination</label>
							</td>
							<td width='2%'>
								<label class="control-label" style="font-size: 14pt;">:</label>
							</td> 
							<td>
								<input type="text" class="form-control" id="destination" name="destination" style="font-size: 12pt;" maxlength="20">
							</td>
						</tr>
						<tr>
							<td>
								<label class="control-label" style="font-size: 14pt;">Cost</label>
							</td>
							<td width='2%'>
								<label class="control-label" style="font-size: 14pt;">:</label>
							</td> 
							<td>
								<!-- <input type="hidden" id="zona" name="zona">		 -->
								<input type="text" class="form-control" id="cost" name="cost" required="required" style="font-size: 12pt;">
							</td>
						</tr>
						<tr style="text-align:right;">
							<td>								
								<input type="hidden" name="id_transaksi_kiosk" id="id_transaksi_kiosk">
								<!-- <input type="hidden" name="id_ready_line" id="id_ready_line"> -->
							</td>
							<td></td>
							<td style="text-align: right;">
								<input type="reset" class="btn btn-default" style="width: 30%" value="Reset">
								<input type="submit" class="btn btn-default btn-primary" style="width: 50%" value="Save" onclick="save()">
							</td>
						</tr>	
						<tr>
							<td colspan="3">					
								<?php 
									  $curr = $this->session->userdata('curr_opr');
									  $next = $this->session->userdata('next_opr');
									  echo "<pre>";
									  foreach ($operator as $key){ 
									  	if($key->id == $curr){
									  		echo "Current Operator : <b>".$key->name."</b>";
									  	}
									  }
									  foreach ($operator as $key){ 
									  	if($key->id == $next){
									  		echo "<br/>Next Operator    : <b>".$key->name."</b>";
									  	}
									  }
									  echo "</pre>";

								?>
								<div id='occupied'></div>
								<div id='vehicle_otw'></div>
							</td>							
						</tr>						
					</table>					
				</form>					
			</div>	
			<div class="col-md-8">
				<?php 
                    $message = $this->session->flashdata('msg');
                    echo $message;
                ?>
				<table class="table table-bordered table-hover table-striped" style="margin-top: 10px;" id="tabel_transaksi">
				  <thead>
					<tr>
						<th width='10px'>No</th>
						<th>Barcode</th>							
						<th>Operator</th>							
						<th>Taxi No</th>
						<th>Plate No</th>
						<th>Cost</th>
						<th>Destination</th>
						<th>Time</th>
						<th>Act</th>
					</tr>
				  </thead>  
				  <tbody id="isi_tabel_transaksi">
				  	<?php 
				  		$nomer = 1;
				  		if(isset($transaksi)){
							foreach ($transaksi as $key){ 
					?>
						<tr>
							<td><?php echo $nomer; $nomer++;?></td>
							<td><?php echo $key->code;?></td>
							<td><?php echo strtoupper($key->nama_operator);?></td>
							<td><?php echo $key->no_lambung;?></td>
							<td><?php echo $key->plate_no;?></td>
							<td><?php 
									if($key->vehicle_type_id == 1){
										$value = "ARGO PRICE";
									} else {
										$value = "Rp. ".number_format($key->cost,0,",",".").",-";
									}
									echo $value;
								?>
										
							</td>
							<td><?php echo strtoupper($key->pax_destination);?></td>
							<td><?php echo date("j F Y, g:i a", strtotime($key->pairing_time));?></td>
							<td><center>								
								<!-- <a href="<?php echo site_url('cashier/cancel/'.$key->code);?>" title="Re-Print" target="_blank"><i class='fa fa-close'></i></a>&nbsp;&nbsp; || &nbsp;&nbsp;  -->
								<a href="<?php echo site_url('cashier/reprint/'.$key->code);?>" title="Re-Print" target="_blank"><i class='fa fa-print'></i></a>
								</center>
							</td>
						</tr>
					<?php }} ?>	
				  </tbody>
				</table>
			</div>
		<!-- /.row -->
	</div>
	<!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->

<!-- Modal Change password-->
<div class="modal fade" id="myChangePassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Change Password</h4>
      </div>
      <form action="<?php echo site_url('cashier/update_password');?>" method="POST">
      	<div class="modal-body">        
			<div class="form-group">
				<label for="exampleInputEmail1">Old Password</label>
				<input type="password" class="form-control" name="old_pass" id="old_pass" placeholder="Old Password" required="required">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">New Password</label>
				<input type="password" class="form-control" name="new_pass" id="new_pass" placeholder="New Password" required="required">
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Re-type Password</label>
				<input type="password" class="form-control" name="re_pass" id="re_pass" placeholder="Re-type" required="required">
			</div>		
			<div class="form-group">
				<label id="warning"></label>				
			</div>  		  		
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	<button type="submit" class="btn btn-primary" id="btn_submit_update_password">Save changes</button>
      	</div>
      </form>
    </div>
  </div>
</div>

<!-- Modal list kendaraan -->
<div class="modal fade" id="list_vehicle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Vehicle List</h4>
      </div>
      <div class="modal-body">  
	      <table class="table table-bordered table-hover table-striped" style="margin-top: 10px;" id="tabel_list_occupied">
			<thead>
				<tr>
					<th>No</th>
					<th>Operator</th>	
					<th>No Lambung</th>						
					<th>Plate No</th>
					<th>Entry Time</th>
					<th>Act</th>
				</tr>
			</thead> 
			<tbody id="list_occupied">

			</tbody>
		  </table>
	  </div>
      <div class="modal-footer">
       	<button type="button" class="btn btn-default" data-dismiss="modal" id="closeButton">Close</button>       	
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal list order -->
<div class="modal fade" id="listOrder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 1200px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Order List</h4>
      </div>
      <div class="modal-body">  
	      <table class="table table-bordered table-hover table-striped" style="margin-top: 10px;" id="tabel_list_order">
			<thead>
				<tr>
					<th>No</th>
					<th>Operator</th>	
					<th>No Lambung</th>						
					<th>Plate No</th>
					<th>Pax Name</th>
					<th>Tujuan</th>
					<th>Act</th>
				</tr>
			</thead> 
			<tbody id="list_order">

			</tbody>
		  </table>
	  </div>
      <div class="modal-footer">
       	<button type="button" class="btn btn-default" data-dismiss="modal" id="closeModalListOrder">Close</button>       	
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal alasan cancel-->
<div class="modal fade" id="modalReasonCancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Cancel Reason</h4>
      </div>
      <form action="<?php echo site_url('cashier/cancel_order');?>" method="POST">
      	<div class="modal-body">        
			<div class="form-group">
				<textarea id="cancel_reason" name="cancel_reason" class="form-control" required=""></textarea>
				<input type="hidden" name="ready_line_id" id="ready_line_id">
			</div>								  	
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        	<button type="submit" class="btn btn-primary" id="btn_submit_cancel">Confirm</button>
      	</div>
      </form>
    </div>
  </div>
</div>