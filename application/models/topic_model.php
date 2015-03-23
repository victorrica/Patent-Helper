<?
class topic_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function gets() {
		return $this->db->query("select * from test")->result();
	}
	public function get($topic_id){
		return $this->db->query("select * from test where idx={$topic_id}")->row();
	}
}