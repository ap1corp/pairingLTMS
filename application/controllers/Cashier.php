<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Cashier extends CI_Controller {
 
	function __construct()
	{
		parent::__construct();	 
		$this->load->database();
		$this->load->library('session');	
		$this->load->model('m_cashier');

	}
	 
	public function save()
	{		
		date_default_timezone_set("Asia/Makassar");
		$trans 			= $this->input->post('driver');
		$trans 			= explode("_", $trans);
		$trans_id 		= $trans[0];
		$plate_no 		= $trans[1];
		$driver_name 	= $trans[2];
		$id_ready_line  = $trans[3];
		$barcode 		= $this->input->post('barcode');
		$cost 			= $this->input->post('cost');
		$opr_taksi_id	= $this->input->post('operator');
		$opr_taksi_id 	= explode("_", $opr_taksi_id);
		$id_opr_select 	= $opr_taksi_id[0];
		$nama_opr 		= $opr_taksi_id[1];
		$kiosk_id		= $this->input->post('id_transaksi_kiosk');		
		$pax_name 		= $this->input->post('penumpang');
		// $id_ready_line 	= $this->input->post('id_ready_line');
		$destination 	= $this->input->post('destination');
		$opr_id 		= $this->session->userdata('id_opr');
		$terminal_id 	= $this->session->userdata('terminal_id');
		$terminal    	= $this->session->userdata('terminal'); 	
		
		$udata['trans_kiosk_id']	= $kiosk_id;
		$udata['pax_name']			= $pax_name;
		$udata['pax_destination']	= $destination;
		$vehicle_type = substr($barcode, -1);
		if($vehicle_type == 2){			
			$udata['cost']	= $cost;
			$cost 			= 'Rp. '.number_format($cost).',-';
		}		
		$udata['operator_id']		= $opr_id;
		$set_pairing_time			= date("Y-m-d H:i");
		$udata['pairing_time']		= $set_pairing_time;
		$udata['terminal_id']		= $terminal_id;		
		
		$res = $this->m_cashier->m_save_trans($udata, $trans_id);		
			
		if($res){				
			$data['barcode']		= $barcode;
			$data['plate_no']		= $plate_no;
			$data['driver_name']	= $driver_name;
			$data['cost']			= $cost;
			$data['penumpang']		= $pax_name;
			$data['destination']	= $destination;
			$data['terminal']		= $terminal;

			//update pairing time
			$q_time_pairing = $this->db->where('id', $trans_id)
							  		   ->get('transactions');
			$get_pairing_time = $q_time_pairing->result();			

			$data['time_pairing']	= date("j F Y, g:i a", strtotime($get_pairing_time[0]->pairing_time));
			$data['operator']		= $nama_opr;

			$vehicle_type = substr($barcode, -1);  // update antrian operator
			if($vehicle_type == 2){
				//$this->update_antrian();
				$this->update_antrian($id_opr_select);
			}

			//UPDATE ISACTIVE BARCODE
			$dt['is_active']  = 'TRUE';
			$update_isactive = $this->db->where('code', $barcode)						   
					   	   				->update('transactions_kiosk', $dt);

			//UPDATE READY LINE
			$du['status']  = 2;
			$update_isactive = $this->db->where('id', $id_ready_line)						   
					   	   				->update('ready_line', $du);

			$this->load->view('pages/print', $data);
		} else {
			echo "Failed Save transaksi";				
		}
			
	}
	
	public function edit_transaksi(){
		echo "tekan edit";
	}
	
	public function delete_transaksi(){
		echo "tekan delete";
	}

	public function get_trans_kiosk(){
		$barcode = $_POST['barcode'];
		$vehicle_type = substr($barcode, -1);
		$terminal_id 	= $this->session->userdata('terminal_id');
		$cek = FALSE; 
		

		if($vehicle_type == '1' || $vehicle_type == '2'){			
			if($terminal_id == '1'){
				$where = "vehicle_type = '$vehicle_type' AND available_dom > 0";
			} else {
				$where = "vehicle_type = '$vehicle_type' AND available_int > 0";
			}

			$sql = $this->db->where($where)							  
						   	->get('vw_readyline_occupied');
			
			$get_occupied = $sql->result();

			if(count($get_occupied) > 0){
				$where = "code = '$barcode' AND is_active IS false";
				$sql = $this->db->where($where)							  
							   	->get('transactions_kiosk');
				$get_code = $sql->result();

				if(count($get_code) > 0){					 
					do {
						$operator = $this->session->userdata('curr_opr');
						if($vehicle_type == 1){  //ARGO
							$q1 = "SELECT tk.id id_transaksi_kiosk, tx.id id_taxi, tx.no_lambung, tx.plate_no, rd.transactions_id id_transaksi, rd.entry_ready_line, tx.operator_id, op.vehicle_type, op.name nama_operator, rd.id id_ready_line
								FROM public.transactions_kiosk tk
								LEFT JOIN public.taxis tx ON tx.vehicle_type_id = tk.vehicle_type_id
						        LEFT JOIN public.ready_line rd ON rd.taxi_id = tx.id AND rd.terminal_id = '$terminal_id'
								LEFT JOIN public.operators op ON tx.operator_id = op.id
								WHERE tk.code = '$barcode' AND rd.entry_ready_line IS NOT NULL AND rd.status = '1' AND tx.vehicle_type_id = '1' AND rd.service_type_id = '1'
								GROUP BY tk.id, tx.id, rd.id, op.id
								ORDER BY rd.entry_ready_line ASC";
						} else { // Fixed Price
							$q1 = "SELECT tk.id id_transaksi_kiosk, tx.id id_taxi, tx.no_lambung, tx.plate_no, rd.transactions_id id_transaksi, rd.entry_ready_line, tx.operator_id, op.vehicle_type, op.name nama_operator, rd.id id_ready_line
								FROM public.transactions_kiosk tk
								LEFT JOIN public.taxis tx ON tx.vehicle_type_id = tk.vehicle_type_id AND tx.operator_id = '$operator'
								LEFT JOIN public.ready_line rd ON rd.taxi_id = tx.id AND rd.terminal_id = '$terminal_id'
								LEFT JOIN public.operators op ON tx.operator_id = op.id
								WHERE tk.code = '$barcode' AND rd.entry_ready_line IS NOT NULL AND rd.status = '1' AND tx.vehicle_type_id = '2' AND rd.service_type_id = '1'
								GROUP BY tk.id, tx.id, rd.id, op.id
								ORDER BY rd.entry_ready_line ASC";
						}		

						$query1 = $this->db->query($q1);
						$trans_kiosk = $query1->result();

						if(count($trans_kiosk) > 0){				
							$cek = TRUE;	
						} else if(count($trans_kiosk) == 0 && $vehicle_type == 2){
							$this->update_antrian();				
						}
					} while($cek == FALSE);

					$opr = $this->m_cashier->load_operator($vehicle_type);
					$data = array('trans'	=> $trans_kiosk,
								  'opr'		=> $opr);
					echo json_encode($data);			
				} else {
					// echo "anjog kene"; die();
					$data = array('error'	=> 'TICKET HAS BEEN PAIRED');
					echo json_encode($data);
				}
			} else {
				$data = array('error'	=> 'NO VEHICLE ON READY LINE');
				echo json_encode($data);
			}
		} else {
			$data = array('error'	=> 'INVALID BARCODE FORMAT');
			echo json_encode($data);
		}
	}

	public function update_antrian($op_curr = NULL){
		$terminal_id = $this->session->userdata('terminal_id');

		if($op_curr === NULL){
            $curr = $this->session->userdata('curr_opr');
        } else {
            $curr = $op_curr;
        }

		// $curr = $this->session->userdata('curr_opr');
		$min  = $this->session->userdata('min_opr');		
		$max  = $this->session->userdata('max_opr');
		$next = $this->session->userdata('next_opr');

		if($curr == $max){
			$udata['value'] = $this->session->userdata('min_opr');			
		} else {
			$query = "SELECT id, next_id
					from(
					    select  
					           id,
					           lead(id) over (order by id) as next_id
					    from operators
					    where vehicle_type = 2
					) as t
					where id =  '$curr' ";
			$exe = $this->db->query($query);
			$data = $exe->result();

			$udata['value'] = $data[0]->next_id;
		}

		if($terminal_id == '1'){
			$update = $this->db->where('name', 'current_operator')
					   	   ->update('settings', $udata);
		} else {
			$update = $this->db->where('name', 'current_operator_int')
					   	   ->update('settings', $udata);
		}
		
		
		if($update === FALSE){
			echo "GAGAL UPDATE ANTRIAN";
		} else {
			$query1 = $this->db->order_by("id", "asc")
								->get('settings');							
			$data_settings = $query1->result();

			if($terminal_id == '1'){
				$curr = $data_settings[5]->value;
				$max = $data_settings[4]->value;
				$min = $data_settings[3]->value;
			} else {
				$curr = $data_settings[11]->value;
				$max = $data_settings[10]->value;
				$min = $data_settings[9]->value;
			}
			
			
			if($curr == $max){
				$next = $min;			
			} else {
				$query = "SELECT id, next_id
				from(
				    select  
				           id,
				           lead(id) over (order by id) as next_id
				    from operators
				    where vehicle_type = 2
				) as t
				where id =  '$curr' ";
				$exe = $this->db->query($query);
				$data = $exe->result();

				$next = $data[0]->next_id;
			}
			
			//set the session variables
			$sessiondata = array(
				  'curr_opr'	 	=> $curr,
				  'min_opr'		 	=> $min,
				  'max_opr' 		=> $max,
				  'next_opr'		=> $next
			);
			
			$this->session->set_userdata($sessiondata);
		}		
	}

	public function get_driver(){
		$terminal_id 	= $this->session->userdata('terminal_id');
		$opr 	= $_POST['operator'];
		$opr 	= explode("_", $opr);
		$operator   = $opr[0];

		$query = "SELECT rd.transactions_id id_transaksi, tx.plate_no, tx.no_lambung, rd.entry_ready_line, rd.id id_ready_line
                        FROM operators op
                        LEFT JOIN taxis tx ON tx.operator_id = op.id
                        LEFT JOIN ready_line rd ON rd.taxi_id = tx.id 
                        WHERE op.id = '$operator' AND rd.entry_ready_line IS NOT NULL AND rd.status = '1' AND rd.terminal_id = '$terminal_id' AND rd.service_type_id = '1'
                        GROUP BY op.id, rd.id, tx.id
                        ORDER BY rd.entry_ready_line";

		$exe = $this->db->query($query);
		$data = $exe->result();

		echo json_encode($data);
	}	

	public function update_password(){		
		$password	= $this->input->post('old_pass'); 
		$username 	= $this->session->userdata('username');				
		
		$usr_result = $this->m_cashier->get_user($username, $password);

		if (count($usr_result) > 0) {
			$udata['password']	= md5($this->input->post('new_pass')); 
			//update password user		
			$update = $this->db->where('username', $username)							   
					   		   ->update('users', $udata);
			if($update){
				$this->session->set_flashdata('msgPass', 'Success Update Password!');
				redirect(base_url());
			}
		} else {
			$this->session->set_flashdata('msgPass', 'Wrong Old Password!');
			redirect(base_url());
		}		
	}

	public function reprint($barcode = null){
		$barcode = $this->uri->segment(3);
		$udata   = $this->m_cashier->m_reprint($barcode);

		$data['barcode']		= $barcode;
		$data['plate_no']		= $udata[0]->plate_no;
		$data['no_lambung']		= $udata[0]->no_lambung;
		if($udata[0]->vehicle_type_id == '1'){
			$cost = "ARGO PRICE";
		} else {
			$cost = "Rp. ".number_format($udata[0]->cost).",-";
		}
		$data['cost']			= $cost;
		$data['penumpang']		= $udata[0]->pax_name;
		$data['destination']	= $udata[0]->pax_destination;
		$data['time_pairing']	= date("j F Y, g:i a", strtotime($udata[0]->pairing_time));
		$data['operator']		= $udata[0]->nama_operator;
		$data['terminal']		= $udata[0]->terminal;
		
		$this->load->view('pages/reprint', $data);
	}

	function update_occupied(){		
		$query = "SELECT * FROM vw_readyline_occupied_reg";
		$exe = $this->db->query($query);
		$data = $exe->result();

		echo json_encode($data);
	}

	public function get_list_occupied(){
		$terminal_id 	= $this->session->userdata('terminal_id');
		$id	= $this->input->post('operator'); 

		$query = "SELECT r.id, o.name nama_operator, t.no_lambung, t.plate_no, r.entry_ready_line
					FROM ready_line r
					JOIN taxis t ON t.id = r.taxi_id
					JOIN operators o ON o.id = t.operator_id AND o.id = '$id'
					WHERE r.status = 1 AND r.terminal_id = '$terminal_id' AND r.service_type_id = '1'
					GROUP BY r.id, t.id, o.id
					ORDER BY r.entry_ready_line ASC";

		$exe = $this->db->query($query);
		$data = $exe->result();

		echo json_encode($data);
	} 

	public function kick(){
		$id	= $this->input->post('id'); 

		$du['status']  = 3; // status di ready line
		$update_kick = $this->db->where('id', $id)						   
					   	   		->update('ready_line', $du);

		$query = $this->db->where('id', $id)
						  ->get('ready_line');
		$result = $query->result();

		$id_trans = $result[0]->transactions_id;

		$dt['status'] = 2;
		$update_trans = $this->db->where('id', $id_trans)						   
					   	   		->update('transactions', $dt);
		if($update_kick && $update_trans){
			echo 1;
		} else {
			echo 0;
		}
	}

	public function vehicle_otw(){		
		$query = "SELECT * FROM vw_vehicle_otw";
        $exe = $this->db->query($query);
        $data = $exe->result();

        echo json_encode($data);
    } 

    public function get_list_order(){
    	$terminal_id 	= $this->session->userdata('terminal_id');
    	$query = "SELECT r.id, r.taxi_id, o.name nama_operator, t.no_lambung, t.plate_no, r.entry_ready_line, r.transactions_id, tr.pax_name, tr.pax_destination tujuan
					FROM ready_line r
					JOIN taxis t ON t.id = r.taxi_id
					JOIN operators o ON o.id = t.operator_id
                    JOIN transactions tr on tr.id = r.transactions_id
					WHERE r.status = 2 AND r.terminal_id = '$terminal_id' AND r.service_type_id = '1'
					GROUP BY r.id, t.id, o.id, tr.id
					ORDER BY r.entry_ready_line ASC";

		$exe = $this->db->query($query);
		$data = $exe->result();

		echo json_encode($data);
    }

    public function cancel_order(){
    	date_default_timezone_set("Asia/Makassar");
    	$cancel_reason 	= $this->input->post('cancel_reason');	
    	$order			= $this->input->post('ready_line_id'); 
    	$explode_order  = explode("_", $order);
    	$id_ready_line 	= $explode_order[0];
    	$trans_id 		= $explode_order[1];
    	$taxi_id	 	= $explode_order[2];

    	$du['status']  = 1;
		$update_kick = $this->db->where('id', $id_ready_line)						   
					   	   		->update('ready_line', $du);
		
		$udata['date_cancel']	= 'NOW()';
		$udata['taxi_id']		= $taxi_id;
		$udata['reason_cancel']	= $cancel_reason;
		$udata['trans_id']		= $trans_id;
		$usr_result = $this->m_cashier->save_cancel($udata);

		if ($usr_result) {
			//$this->session->set_flashdata('msgPass', "<p style='color: green;'>Success Canceling Order</p>");
			redirect(base_url());			
		} else {
			//$this->session->set_flashdata('msgPass', "<p style='color: red;'>Failed</p>");
			redirect(base_url());
		}		
    }

    public function get_ngurahrai(){
    	$terminal_id 	= $this->session->userdata('terminal_id');
    	$query = "SELECT id, plate_no, no_lambung, to_char(entry_ready_line, 'HH24:MI') rdin, status, operator_id, substring(status_desc from 1 for 1) stat 
    			  FROM vw_readyline_status_all 
    			  WHERE operator_id = '5' and terminal_id = '$terminal_id' and service_type_id = '1'
    			  ORDER BY rdin ASC";

		$exe = $this->db->query($query);
		$data = $exe->result();

		echo json_encode($data);
    }

    public function get_lohjinawi(){
    	$terminal_id 	= $this->session->userdata('terminal_id');
    	$query = "SELECT id, plate_no, no_lambung, to_char(entry_ready_line, 'HH24:MI') rdin, status, operator_id, substring(status_desc from 1 for 1) stat
    			  FROM vw_readyline_status_all 
    			  WHERE operator_id = '1' and terminal_id = '$terminal_id' and service_type_id = '1'
    			  ORDER BY rdin ASC";

		$exe = $this->db->query($query);
		$data = $exe->result();

		echo json_encode($data);
    }

    public function get_transtuban(){
    	$terminal_id 	= $this->session->userdata('terminal_id');
    	$query = "SELECT id, plate_no, no_lambung, to_char(entry_ready_line, 'HH24:MI') rdin, status, operator_id, substring(status_desc from 1 for 1) stat 
    			  FROM vw_readyline_status_all 
    			  WHERE operator_id = '2' and terminal_id = '$terminal_id' and service_type_id = '1'
    			  ORDER BY rdin ASC";

		$exe = $this->db->query($query);
		$data = $exe->result();

		echo json_encode($data);
    }

    public function get_saptapesona(){
    	$terminal_id 	= $this->session->userdata('terminal_id');
    	$query = "SELECT id, plate_no, no_lambung, to_char(entry_ready_line, 'HH24:MI') rdin, status, operator_id, substring(status_desc from 1 for 1) stat 
    			  FROM vw_readyline_status_all 
    			  WHERE operator_id = '3' and terminal_id = '$terminal_id' and service_type_id = '1'
    			  ORDER BY rdin ASC";

		$exe = $this->db->query($query);
		$data = $exe->result();

		echo json_encode($data);
    }

    public function get_balisegara(){
    	$terminal_id 	= $this->session->userdata('terminal_id');
    	$query = "SELECT id, plate_no, no_lambung, to_char(entry_ready_line, 'HH24:MI') rdin, status, operator_id, substring(status_desc from 1 for 1) stat 
    			  FROM vw_readyline_status_all 
    			  WHERE operator_id = '4' and terminal_id = '$terminal_id' and service_type_id = '1'
    			  ORDER BY rdin ASC";

		$exe = $this->db->query($query);
		$data = $exe->result();

		echo json_encode($data);
    }

    public function delete_readyline(){
    	$idne	= $this->input->post('id');     	

    	$query = "DELETE FROM ready_line WHERE id = '$idne'";

		$exe = $this->db->query($query);

		echo '1';		

    }

}