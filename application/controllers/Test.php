
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Test extends CI_Controller {

 	function __construct()
	{
		parent::__construct();	
		$this->load->database(); 		
	}
	
	public function konek(){
		
		$sql = odbc_connect("DRIVER={SQL Server};Server=192.168.5.10,35000;Database=Parking", "admin", "P@ssw0rd") or die("gagal koneksi"); 
		echo $sql; die();
	}	

	public function getTgl(){
		date_default_timezone_set("Asia/Makassar");

		$tgl = date("Y-m-d H:i:s");
		$tgl1 = date("Y-m-d ", strtotime($tgl . "-1 days"));
		echo "Today is " .$tgl."<br>";
		echo "Yesterday is ".$tgl1;

		$sql = "UPDATE users SET last_login = '$tgl' WHERE id = '15'";
		$query = $this->db->query($sql);

		return $query->result();
	}
	
}