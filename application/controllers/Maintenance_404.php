<?php defined('BASEPATH') or exit('No direct script access allowed');

class Maintenance_404 extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index()
	{

		$this->load->view('maintenance');
	}

}
