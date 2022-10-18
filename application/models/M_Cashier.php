<?php
	class M_Cashier extends CI_Model {
        
        public function __construct()
        {
			// Call the CI_Model constructor
			parent::__construct();
			$this->load->database();
        }
        			
		public function get_transaksi($barcode){
			$query = $this->db->where('barcode', $barcode)
							  ->get('all_transaksi');
			return $query->result();
		}

		public function get_user($username, $password){
			$query = $this->db->where('username', $username)
							  ->where('password', $password)
							  ->where('role_id', '3')
							  ->get('users');
			return $query->result();
		}

		public function isLogin($username){
			$sql = "select * from user where username = '" . $username . "'";
			$query = $this->db->query($sql);
			return $query->result();
		}
		
		public function m_save_trans($udata, $id_trans){
			$update = $this->db->where('id',$id_trans)							   
							   ->update('transactions', $udata);
			return $update;
		}

		public function load_operator($vehicle_type = null){
			if(isset($vehicle_type)){
				$query = $this->db->where('vehicle_type', $vehicle_type)
								  ->order_by("id", "asc")
							      ->get('operators');
			} else {
				$query = $this->db->order_by("id", "asc")
							  ->get('operators');
			}
			
			return $query->result();
		}

		public function load_transaksi($opr, $terminal_id){
			$today = date('Y-m-d');
			$yesterday = date('Y-m-d', strtotime($today . "-1 days"));

			$sql = "SELECT t.pairing_time, t.pax_name nama_penumpang, tk.code, op.name nama_operator, tx.no_lambung, tx.plate_no, t.cost, tk.vehicle_type_id, t.pax_destination
					FROM transactions t
					LEFT JOIN transactions_kiosk tk ON tk.id = t.trans_kiosk_id
					LEFT JOIN taxis tx ON tx.id = t.taxi_id
					LEFT JOIN operators op ON op.id = tx.operator_id
					WHERE t.operator_id = '$opr' AND to_char(t.pairing_time, 'YYYY-MM-DD') >= '$yesterday' AND t.terminal_id = '$terminal_id'
					GROUP BY t.id, tk.id, tx.id, op.id
					ORDER BY t.pairing_time DESC";			
			
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function m_reprint($barcode){
			$sql = "SELECT t.pairing_time, op.name nama_operator, tx.plate_no, tx.no_lambung, t.pax_name, tk.vehicle_type_id, t.pax_destination, t.cost, tr.name as terminal
					FROM transactions_kiosk tk
					LEFT JOIN transactions t ON t.trans_kiosk_id = tk.id
					LEFT JOIN taxis tx ON t.taxi_id = tx.id
					LEFT JOIN operators op ON op.id = tx.operator_id
					LEFT JOIN terminals tr ON tr.id = t.terminal_id
					WHERE tk.code = '$barcode'
					GROUP BY tk.id, t.id, tx.id, op.id, tr.id";			
			
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function load_history($id_user){
			$sql = "SELECT oc.*, count(at.id) trans
					FROM on_cash oc
					LEFT JOIN all_transaksi at ON at.id_on_cashier = oc.id					
					where oc.id_user = '$id_user' AND status = '1'
					GROUP BY oc.id ORDER BY oc.entry_time DESC";
			$query = $this->db->query($sql);

			return $query->result();
		}

		public function m_update_antrian($curr, $max, $min){			
			if($curr == $max){
				$curr_opr = $min;
			} else {
				$query = "SELECT id, next_id
					  FROM (
						    SELECT  
						           id,
						           lead(id) over (order by id) as next_id
						    FROM operators
						    WHERE vehicle_type = 2
						) as t
					  WHERE id = $curr";
		    	$execute = $this->db->query($query);	
		    	$data = $execute->result();
		    	$curr_opr = $data[0]->next_id;
			}
			
				   
		}

		public function save_cancel($udata){
			$insert = $this->db->insert('cancel_order', $udata);
			return $update;
		}

		public function load_terminal(){
			$query = $this->db->get('terminals');
			return $query->result();
		}
	}
?>