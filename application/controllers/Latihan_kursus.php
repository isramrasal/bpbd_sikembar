<?php defined('BASEPATH') or exit('No direct script access allowed');

class Latihan_kursus extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->load->library('session');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');


        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "Latihan_kursus_aktif";
    }


	
    public function index()
    {
        
        echo "Halo, Dunia! <br/>";
        echo "Ini adalah <i>script</i> php pertamaku";
     
    }

   

}
