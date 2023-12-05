<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Landing extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language', 'file'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');


	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index()
	{
		$this->data['title'] = 'Dashboard';

		//$this->load->model('ws_pengumuman_model');

		//$this->data['pengumuman'] = $this->ws_pengumuman_model->pengumuman_list_landing();

		$this->load->view('wasa/landing', $this->data );
	}

}
