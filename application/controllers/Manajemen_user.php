<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Manajemen_user extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation','session'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Manajemen User';
		
		$this->load->model('Manajemen_user_model');
		$this->load->model('Foto_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses FPB";
		$WAKTU = date('Y-m-d H:i:s');
		$this->FPB_moManajemen_user_modelel->user_log_manajemen_user($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->FPB_model->user_log_manajemen_user($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
	}

	public function index()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in())
		{
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		//get data tabel users untuk ditampilkan
		$user = $this->ion_auth->user()->row();
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$this->data['last_login'] =  date('d-m-Y H:i:s',$user->last_login);
		$this->data['created_on'] = date('d-m-Y H:i:s',$user->created_on);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		
		$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		
		// $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		// if ($query_foto_user == "BELUM ADA FOTO")
		// {
		// 	$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		// }
		// else
		// {
		// 	$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		// }
		
		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$this->data['left_menu'] = "pegawai_aktif";
			
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_manajemen_user');
			
		}
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
	
	function data_manajemen_user()
	{	
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$data=$this->Manajemen_user_model->manajemen_user_list();
			echo json_encode($data);
		}
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
	
	function get_data_role_user()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$id=$this->input->get('id');
			$data=$this->Manajemen_user_model->get_data_role_user_by_id($id);
			echo json_encode($data);
		}
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function update_data_role_user()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$user = $this->ion_auth->user()->row();
			
			//set validation rules
			$this->form_validation->set_rules('status_user2', 'Status User', 'trim|required');
			$this->form_validation->set_rules('role_user2', 'Role User', 'trim|required');
			
			
			//run validation check
			if ($this->form_validation->run() == FALSE)
			{   //validation fails
				echo json_encode(validation_errors());
			}
			else
			{
				//get the form data
				$id_user2=$this->input->post('id_user2');
				$role_user2=$this->input->post('role_user2');
				$status_user2=$this->input->post('status_user2');
				
				//$data=$this->Manajemen_user_model->get_data_by_id($id_user2);
				
				// //log
				// $KETERANGAN = "Ubah role user ".$data['NAMA'].", ROLE USER ".$data['group_id']." jadi ".$manajemen_user2;
				// $WAKTU = date('Y-m-d H:i:s');
				// $this->Manajemen_user_model->log_manajemen_user($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
				
				$data=$this->Manajemen_user_model->update_data_role_user($id_user2,$role_user2,$status_user2);
				echo json_encode($data);

			}
		}
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
    
    //custom validation function to accept alphabets and space
    function alpha_space_only($str)
    {
        if (!preg_match("/^[a-zA-Z ]+$/",$str))
        {
            $this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}
