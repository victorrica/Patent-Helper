<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->database();
		//$this->load->model('topic_model');
	}
	function index()
	{
		$this->load->view('head');
		$this->load->view('main');
		$this->load->view('footer');
	}
}
?>