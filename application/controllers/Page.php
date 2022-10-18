<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Page extends CI_Controller {

 	public $logged = FALSE;
 	
	function __construct()
	{
		parent::__construct();	 
		date_default_timezone_set("Asia/Makassar");		
		$this->load->database();	 
		$this->load->library('session');	
		$this->load->model('m_cashier');
		$this->logged = $this->session_check();
		//$this->logged = FALSE;
		//$this->session->sess_destroy();
	}

	public function session_check()
    {
		//$username = $this->session->userdata('username');
		if($this->session->userdata('username')){			
			return TRUE;			
		} else {
			return FALSE;
		}
    }
	
	public function index()
	{		
		if($this->logged === TRUE){
			$id 			= $this->session->userdata('id_opr');
			$terminal_id 	= $this->session->userdata('terminal_id');
			$data['title']		= 'Pairing';
			$data['transaksi']  = $this->m_cashier->load_transaksi($id, $terminal_id);
			$data['operator']	= $this->m_cashier->load_operator();
			
			$this->load->view('templates/header', $data);			
			$this->load->view('pages/cashier');
			$this->load->view('templates/footer');
		} else {
			redirect(site_url('page/login'));
		}
	}

	public function login(){
		//print_r($this->session->userdata());
		if($this->logged === TRUE){			
			redirect(site_url('page/index'));
		} else {
			$data['terminal'] =  $this->m_cashier->load_terminal();
			$this->load->view('pages/login', $data);
		}		
	}
	
	public function process_login(){
		$username = $this->input->post("username");
		$password = md5($this->input->post("password"));
		$terminal = $this->input->post("terminal");
		$terminal = explode('_', $terminal);
		$terminal_id = $terminal[0];
		$terminal = $terminal[1];
		
		//validation succeeds
		if ($this->input->post('btn_login') == "Login")
		{
			//check if username and password is correct
			$usr_result = $this->m_cashier->get_user($username, $password);

			if (count($usr_result) > 0) //active user record is present
			{				
				$id = $usr_result[0]->id;				

				//update last login
				$udata = array( 'last_login' => 'NOW()');
				$update = $this->db->where('id', $id)
						   		   ->update('users', $udata);

				$query1 = $this->db->order_by("id", 'ASC')
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
					  'id_opr'	 		=> $usr_result[0]->id,
					  'username' 		=> $username,
					  'login_user' 		=> TRUE,
					  'nama'			=> $usr_result[0]->name,
					  'min_opr'		 	=> $min,
					  'max_opr'		 	=> $max,
					  'curr_opr' 		=> $curr,
					  'terminal_id'		=> $terminal_id,
					  'terminal'		=> $terminal,					  
					  'next_opr'		=> $next
				);

				// print_r($sessiondata); die();
									
				$this->session->set_userdata($sessiondata);
				redirect(site_url('page'));
			}
			else
			{				
				$this->session->set_flashdata('msg', 'Invalid username and password!');
				redirect(site_url('page/login'));
			}
		}
		else
		{			
			$this->session->set_flashdata('msg', 'Invalid username and password!');
			redirect(site_url('page/login'));
		}
	}

	public function logout(){			

		$id = $this->session->userdata('id_opr');		

		if(isset($id)){										   
			$this->session->sess_destroy();
			redirect(site_url('page/login'));
		} else {
			show_404();
		}
	}	

	 public function ready_line(){
    	if($this->logged === TRUE){
			$id 			= $this->session->userdata('id_opr');
			$terminal_id 	= $this->session->userdata('terminal_id');
			$data['title']		= 'Daftar kendaraan Ready Line';				
			
			$this->load->view('templates/header', $data);			
			$this->load->view('pages/ready_line');
			$this->load->view('templates/footer');
		} else {
			redirect(site_url('page/login'));
		}
    }	
	
}