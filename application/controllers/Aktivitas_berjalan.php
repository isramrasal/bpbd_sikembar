<?php defined('BASEPATH') or exit('No direct script access allowed');

class Aktivitas_berjalan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Aktivitas_berjalan_model');

		$this->data['title'] = 'SIPESUT WME | Aktivitas Berjalan';
		$this->data['left_menu'] = "aktivitas_berjalan_aktif";
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		//get data tabel users untuk ditampilkan
		$user = $this->ion_auth->user()->row();
		$this->data['user_id'] = $user->id;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
		$this->data['role_user'] = $data_role_user['description'];
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		date_default_timezone_set('Asia/Jakarta');
		$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$this->data['proyek'] = $this->Aktivitas_berjalan_model->daftar_proyek();

		//jika mereka sudah login dan sebagai manajer proyek
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$this->load->view('wasa/user_manajer_procurement/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement/user_menu');
			$this->load->view('wasa/user_manajer_procurement/left_menu');
			$this->load->view('wasa/user_manajer_procurement/header_menu');
			$this->load->view('wasa/user_manajer_procurement/content_aktivitas_berjalan');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$this->load->view('wasa/user_staff_logistic/head_normal', $this->data);
			$this->load->view('wasa/user_staff_logistic/user_menu');
			$this->load->view('wasa/user_staff_logistic/left_menu');
			$this->load->view('wasa/user_staff_logistic/header_menu');
			$this->load->view('wasa/user_staff_logistic/content_aktivitas_berjalan');
		}
		// else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
		// 	$this->load->view('wasa/user_staff_umum_logistic_sp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_staff_umum_logistic_sp/user_menu');
		// 	$this->load->view('wasa/user_staff_umum_logistic_sp/left_menu');
		// 	$this->load->view('wasa/user_staff_umum_logistic_sp/header_menu');
		// 	$this->load->view('wasa/user_staff_umum_logistic_sp/content_aktivitas_berjalan');
		// } 
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}
}
