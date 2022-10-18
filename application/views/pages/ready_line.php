<script type="text/javascript">	
	function get_ngurahrai(){
		var content = "";
		var clas = "";
		var id = "";

		$.post("<?php echo site_url('cashier/get_ngurahrai');?>",
            function (msg){
                console.log(msg);   
                if(msg.length > 0){
                	for(var i=0; i < msg.length; i++){
                		if(msg[i].status == '0'){
                			clas = "class = 'success'";
                		} else if(msg[i].status == '1'){
                			clas = "class = 'warning'";
                		} else if(msg[i].status == '2'){
                			clas = "class = 'info'";
                		} else {
                			clas = "class = 'danger'";
                		}
                		content += "<tr "+clas+">";
                		content += "<td>"+(i+1)+" ("+msg[i].stat+")"+"</td>";
                		content += "<td>"+msg[i].plate_no+"</td>";
                		content += "<td>"+msg[i].no_lambung+"</td>";
                		content += "<td>"+msg[i].rdin+"</td>";                		
                		content += "<td><center><a href='#' onclick='delete_readyline("+msg[i].id+")'><i class='fa fa-trash'></i></a></center></td>";
                		content += "</tr>";                		
                    }

                    $('#isi_table_ngurahrai').html('');	
                    $('#isi_table_ngurahrai').html(content);                    
                } else {
                	$('#isi_table_ngurahrai').html('');	
                    $('#isi_table_ngurahrai').html(content);                    
                }                 
            }
        ,"JSON");	
	}	

	function get_lohjinawi(){
		var content = "";

		$.post("<?php echo site_url('cashier/get_lohjinawi');?>",
            function (msg){
                console.log(msg);   
                if(msg.length > 0){
                	for(var i=0; i < msg.length; i++){
                		if(msg[i].status == '0'){
                			clas = "class = 'success'";
                		} else if(msg[i].status == '1'){
                			clas = "class = 'warning'";
                		} else if(msg[i].status == '2'){
                			clas = "class = 'info'";
                		} else {
                			clas = "class = 'danger'";
                		}
                		content += "<tr "+clas+">";
                		content += "<td>"+(i+1)+" ("+msg[i].stat+")"+"</td>";
                		content += "<td>"+msg[i].plate_no+"</td>";
                		content += "<td>"+msg[i].no_lambung+"</td>";
                		content += "<td>"+msg[i].rdin+"</td>";
                		content += "<td><center><a href='#' onclick='delete_readyline("+msg[i].id+")'><i class='fa fa-trash'></i></a></center></td>";
                		content += "</tr>";                		
                    }

                    $('#isi_table_lohjinawi').html('');	
                    $('#isi_table_lohjinawi').html(content);                    
                } else {
                	$('#isi_table_lohjinawi').html('');	
                    $('#isi_table_lohjinawi').html(content);                    
                }                 
            }
        ,"JSON");	
	}	

	function get_transtuban(){
		var content = "";

		$.post("<?php echo site_url('cashier/get_transtuban');?>",
            function (msg){
                console.log(msg);   
                if(msg.length > 0){
                	for(var i=0; i < msg.length; i++){
                		if(msg[i].status == '0'){
                			clas = "class = 'success'";
                		} else if(msg[i].status == '1'){
                			clas = "class = 'warning'";
                		} else if(msg[i].status == '2'){
                			clas = "class = 'info'";
                		} else {
                			clas = "class = 'danger'";
                		}
                		content += "<tr "+clas+">";
                		content += "<td>"+(i+1)+" ("+msg[i].stat+")"+"</td>";
                		content += "<td>"+msg[i].plate_no+"</td>";
                		content += "<td>"+msg[i].no_lambung+"</td>";
                		content += "<td>"+msg[i].rdin+"</td>";
                		content += "<td><center><a href='#' onclick='delete_readyline("+msg[i].id+")'><i class='fa fa-trash'></i></a></center></td>";
                		content += "</tr>";                		
                    }

                    $('#isi_table_transtuban').html('');	
                    $('#isi_table_transtuban').html(content);                    
                } else {
                	$('#isi_table_transtuban').html('');	
                    $('#isi_table_transtuban').html(content);                    
                }                 
            }
        ,"JSON");	
	}

	function get_saptapesona(){
		var content = "";

		$.post("<?php echo site_url('cashier/get_saptapesona');?>",
            function (msg){
                console.log(msg);   
                if(msg.length > 0){
                	for(var i=0; i < msg.length; i++){
                		if(msg[i].status == '0'){
                			clas = "class = 'success'";
                		} else if(msg[i].status == '1'){
                			clas = "class = 'warning'";
                		} else if(msg[i].status == '2'){
                			clas = "class = 'info'";
                		} else {
                			clas = "class = 'danger'";
                		}
                		content += "<tr "+clas+">";
                		content += "<td>"+(i+1)+" ("+msg[i].stat+")"+"</td>";
                		content += "<td>"+msg[i].plate_no+"</td>";
                		content += "<td>"+msg[i].no_lambung+"</td>";
                		content += "<td>"+msg[i].rdin+"</td>";
                		content += "<td><center><a href='#' onclick='delete_readyline("+msg[i].id+")'><i class='fa fa-trash'></i></a></center></td>";
                		content += "</tr>";                		
                    }

                    $('#isi_table_saptapesona').html('');	
                    $('#isi_table_saptapesona').html(content);                    
                } else {
                	$('#isi_table_saptapesona').html('');	
                    $('#isi_table_saptapesona').html(content);                    
                }                 
            }
        ,"JSON");	
	}

	function get_balisegara(){
		var content = "";

		$.post("<?php echo site_url('cashier/get_balisegara');?>",
            function (msg){
                console.log(msg);   
                if(msg.length > 0){
                	for(var i=0; i < msg.length; i++){
                		if(msg[i].status == '0'){
                			clas = "class = 'success'";
                		} else if(msg[i].status == '1'){
                			clas = "class = 'warning'";
                		} else if(msg[i].status == '2'){
                			clas = "class = 'info'";
                		} else {
                			clas = "class = 'danger'";
                		}
                		content += "<tr "+clas+">";
                		content += "<td>"+(i+1)+" ("+msg[i].stat+")"+"</td>";
                		content += "<td>"+msg[i].plate_no+"</td>";
                		content += "<td>"+msg[i].no_lambung+"</td>";
                		content += "<td>"+msg[i].rdin+"</td>";
                		content += "<td><center><a href='#' onclick='delete_readyline("+msg[i].id+")'><i class='fa fa-trash'></i></a></center></td>";
                		content += "</tr>";                		
                    }

                    $('#isi_table_balisegara').html('');	
                    $('#isi_table_balisegara').html(content);                    
                } else {
                	$('#isi_table_balisegara').html('');	
                    $('#isi_table_balisegara').html(content);                    
                }                 
            }
        ,"JSON");	
	}

	function delete_readyline(idne){
		var id = idne;
		var result = confirm('Are you sure want to delete ?');

		if(result) {
			if(id == '0' || id == ''){
				alert("No ID Ready Line");
			} else {
				var data = { "id" : id };
				$.post("<?php echo site_url('cashier/delete_readyline');?>", data,
		            function (msg){
		                console.log(msg);   
		                if(msg == 1){
		                	alert('Vehicle has been deleted');
		                	get_ngurahrai();     
							get_lohjinawi();     
							get_saptapesona();     
							get_transtuban();     
							get_balisegara();		                	
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

	var idletime = 0;

	function timerIncrement(){
		console.log(idletime);
		idletime++;
		get_ngurahrai();     
		get_lohjinawi();     
		get_saptapesona();     
		get_transtuban();     
		get_balisegara();
	}
	
	$( document ).ready(function() {   
		var idleInterval = setInterval(timerIncrement, 5000);  
		get_ngurahrai();     
		get_lohjinawi();     
		get_saptapesona();     
		get_transtuban();     
		get_balisegara();                                    
		
		$("#header-icon").attr('class', 'fa fa-car');
		
		<?php
			if($this->session->flashdata('msgPass')){
				?> alert("<?php echo $msgPass;?>"); <?php
			}
		?>
	});
</script>
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-2">
			<center><h5>NGURAH RAI</h5></center>
			<table class="table" id="table_ngurahrai">
			  <thead>
			    <tr>
			      <th scope="col">NO</th>
			      <th scope="col">PLAT</th>
			      <th scope="col">LBG</th>
			      <th scope="col">IN</th>
			      <th scope="col">ACT</th>
			    </tr>
			  </thead>
			  <tbody id="isi_table_ngurahrai">
			    
			  </tbody>
			</table>				
		</div>	
		<div class="col-md-2">
			<center><h5>LOHJINAWI</h5></center>
			<table class="table" id="table_lohjinawi">
			  <thead>
			    <tr>
			      <th scope="col">NO</th>
			      <th scope="col">PLAT</th>
			      <th scope="col">LBG</th>
			      <th scope="col">IN</th>
			      <th scope="col">ACT</th>
			    </tr>
			  </thead>
			  <tbody id="isi_table_lohjinawi">
			    
			  </tbody>
			</table>	
		</div>	
		<div class="col-md-2">
			<center><h5>TRANS TUBAN</h5></center>
			<table class="table" id="table_transtuban">
			  <thead>
			    <tr>
			      <th scope="col">NO</th>
			      <th scope="col">PLAT</th>
			      <th scope="col">LBG</th>
			      <th scope="col">IN</th>
			      <th scope="col">ACT</th>
			    </tr>
			  </thead>
			  <tbody id="isi_table_transtuban">
			    
			  </tbody>
			</table>	
		</div>
		<div class="col-md-2">
			<center><h5>SAPTA PESONA</h5></center>
			<table class="table" id="table_saptapesona">
			  <thead>
			    <tr>
			      <th scope="col">NO</th>
			      <th scope="col">PLAT</th>
			      <th scope="col">LBG</th>
			      <th scope="col">IN</th>
			      <th scope="col">ACT</th>
			    </tr>
			  </thead>
			  <tbody id="isi_table_saptapesona">
			    
			  </tbody>
			</table>	
		</div>
		<div class="col-md-2">
			<center><h5>BALI SEGARA</h5></center>
			<table class="table" id="table_balisegara">
			  <thead>
			    <tr>
			      <th scope="col">NO</th>
			      <th scope="col">PLAT</th>
			      <th scope="col">LBG</th>
			      <th scope="col">IN</th>
			      <th scope="col">ACT</th>
			    </tr>
			  </thead>
			  <tbody id="isi_table_balisegara">
			    
			  </tbody>
			</table>		
		</div>	
	</div>
</div>