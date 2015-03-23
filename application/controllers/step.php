<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class step extends CI_Controller {
	function __construct() {
		parent::__construct();

		$this->load->database();
		//$this->load->model('topic_model');
	}
	function index()
	{
		$this->load->view('head');
		$this->load->view('step');
		$this->load->view('teudoli');
		$this->load->view('footer');
	}
}
?>