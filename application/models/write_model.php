<?
class write_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function gets() {
		return $this->db->query("SELECT * FROM `petent_detail`")->result();
	}

	public function get($topic_id){
		return $this->db->query("select * from test where idx={$topic_id}")->row();
	}

	public function query($query){
			return $this->db->query($query)->row();

	}

}


?>