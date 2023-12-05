<?php defined('BASEPATH') or exit('No direct script access allowed');

class Proyek extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SiPESUT | Proyek';

		$this->load->model('Proyek_model');
		$this->load->model('Proyek_file_model');
		$this->load->model('Rasd_barang_model');
		$this->load->model('RASD_model');
		$this->load->model('Departemen_model');
		$this->load->model('Foto_model');
		$this->load->model('Organisasi_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('RAB_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "proyek_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Proyek";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Proyek_model->user_log_proyek($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Proyek_model->user_log_proyek($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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
		$this->data['USER_ID'] = $user->id;
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
		$this->data['role_user'] = $data_role_user['description'];
		$this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
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

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			// $this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			// $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			// $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			// $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			// $this->session->set_userdata($sess_data);

			// $this->load->view('wasa/user_admin/head_normal', $this->data);
			// $this->load->view('wasa/user_admin/user_menu');
			// $this->load->view('wasa/user_admin/left_menu');
			// $this->load->view('wasa/user_admin/header_menu');
			// $this->load->view('wasa/user_admin/content_proyek');
			// $this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) { //CHIEF
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_chief_sp/head_normal', $this->data);
			$this->load->view('wasa/user_chief_sp/user_menu');
			$this->load->view('wasa/user_chief_sp/left_menu');
			$this->load->view('wasa/user_chief_sp/header_menu');
			$this->load->view('wasa/user_chief_sp/content_proyek');
			$this->load->view('wasa/user_chief_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) { //SM SP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
			$this->load->view('wasa/user_sm_sp/user_menu');
			$this->load->view('wasa/user_sm_sp/left_menu');
			$this->load->view('wasa/user_sm_sp/header_menu');
			$this->load->view('wasa/user_sm_sp/content_proyek');
			$this->load->view('wasa/user_sm_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) { //SM SP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
			$this->load->view('wasa/user_pm_sp/user_menu');
			$this->load->view('wasa/user_pm_sp/left_menu');
			$this->load->view('wasa/user_pm_sp/header_menu');
			$this->load->view('wasa/user_pm_sp/content_proyek');
			$this->load->view('wasa/user_pm_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) { //STAFF PROC KP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_proyek');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) { //KASIE PROC KP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_proyek');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) { //MAN PROC KP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_proyek');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) { //STAFF PROC SP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_proyek');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) { //SPV PROC SP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_proyek');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) { //STAFF UMUM LOG KP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/content_proyek');
			$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) { //KASIE LOG KP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_proyek');
			$this->load->view('wasa/user_kasie_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) { //MAN LOG KP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_proyek');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) { //STAFF UMUM LOG SP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_proyek');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) { //STAFF GUDANG LOG SP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/content_proyek');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) { //SUPERVISI LOG SP
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

			$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
			$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

			$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
			$this->session->set_userdata($sess_data);

			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_proyek');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else {
			$this->logout();
		}
	}

	function list_proyek()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			// $data = $this->Proyek_model->list_proyek();
			// echo json_encode($data);

			// $KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			// $this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->list_proyek_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->list_proyek_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->list_proyek_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$data = $this->Proyek_model->list_proyek();
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$data = $this->Proyek_model->list_proyek();
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$data = $this->Proyek_model->list_proyek();
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->list_proyek_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->list_proyek_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$data = $this->Proyek_model->list_proyek();
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$data = $this->Proyek_model->list_proyek();
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$data = $this->Proyek_model->list_proyek();
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->list_proyek_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->list_proyek_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->list_proyek_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat List Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	//komentar
	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			// $id = $this->input->get('id');
			// $data = $this->Proyek_model->get_data_by_id_proyek($id);
			// echo json_encode($data);

			// $KETERANGAN = "Get Data Proyek: " . json_encode($data);
			// $this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$ID_PROYEK = $this->input->post('kode');
			$data_hapus = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK);
			$data = $this->Proyek_model->hapus_data_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$ID_PROYEK = $this->input->post('kode');
			$data_hapus = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK);
			$data = $this->Proyek_model->hapus_data_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$ID_PROYEK = $this->input->post('kode');
			$data_hapus = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK);
			$data = $this->Proyek_model->hapus_data_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$ID_PROYEK = $this->input->post('kode');
			$data_hapus = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK);
			$data = $this->Proyek_model->hapus_data_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$ID_PROYEK = $this->input->post('kode');
			$data_hapus = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK);
			$data = $this->Proyek_model->hapus_data_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function simpan_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI', 'Lokasi', 'trim|required');
			$this->form_validation->set_rules('INISIAL', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK', 'Status', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_MULAI_PROYEK', 'Tanggal Mulai Proyek', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PROYEK', 'Tanggal Selesai Proyek', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$LOKASI = $this->input->post('LOKASI');
				$INISIAL = $this->input->post('INISIAL');
				$STATUS_PROYEK = $this->input->post('STATUS_PROYEK');
				$TANGGAL_MULAI_PROYEK = $this->input->post('TANGGAL_MULAI_PROYEK');
				$TANGGAL_SELESAI_PROYEK = $this->input->post('TANGGAL_SELESAI_PROYEK');

				//check apakah nama Proyek sudah ada. jika belum ada, akan disimpan.
				if ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK) == 'Data belum ada') {

					$KETERANGAN = "Tambah Data Proyek: " . ";" . $NAMA_PROYEK . ";" . $LOKASI . ";" . $INISIAL . ";" . $STATUS_PROYEK . ";" . $TANGGAL_MULAI_PROYEK . ";" . $TANGGAL_SELESAI_PROYEK;
					$this->user_log($KETERANGAN);

					// SIMPAN DULU DATA KE TABEL PROYEK 
					$simpan_data = $this->Proyek_model->simpan_data_by_admin($NAMA_PROYEK, $LOKASI, $INISIAL, $STATUS_PROYEK, $TANGGAL_MULAI_PROYEK, $TANGGAL_SELESAI_PROYEK);

					$simpan_data2 = $this->Proyek_model->set_md5_id_proyek($NAMA_PROYEK, $LOKASI, $INISIAL);

					// AMBIL ID PROYEK DARI TABLE PROYEK DENGAN PARAMETER NAMA PROYEK 
					$ID_PROYEK = $this->Proyek_model->get_data_by_nama_proyek($NAMA_PROYEK);

					// SIMPAN ID PROYEK KE TABEL RASD
					$this->RASD_model->simpan_data_by_admin($ID_PROYEK);
					$this->RASD_model->set_md5_id_rasd($ID_PROYEK);
				} else {
					echo 'Nama Proyek sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI', 'Lokasi', 'trim|required');
			$this->form_validation->set_rules('INISIAL', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK', 'Status', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_MULAI_PROYEK', 'Tanggal Mulai Proyek', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PROYEK', 'Tanggal Selesai Proyek', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$LOKASI = $this->input->post('LOKASI');
				$INISIAL = $this->input->post('INISIAL');
				$STATUS_PROYEK = $this->input->post('STATUS_PROYEK');
				$TANGGAL_MULAI_PROYEK = $this->input->post('TANGGAL_MULAI_PROYEK');
				$TANGGAL_SELESAI_PROYEK = $this->input->post('TANGGAL_SELESAI_PROYEK');

				//check apakah nama Proyek sudah ada. jika belum ada, akan disimpan.
				if ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK) == 'Data belum ada') {

					$KETERANGAN = "Tambah Data Proyek: " . ";" . $NAMA_PROYEK . ";" . $LOKASI . ";" . $INISIAL . ";" . $STATUS_PROYEK . ";" . $TANGGAL_MULAI_PROYEK . ";" . $TANGGAL_SELESAI_PROYEK;
					$this->user_log($KETERANGAN);

					// SIMPAN DULU DATA KE TABEL PROYEK 
					$simpan_data = $this->Proyek_model->simpan_data_by_admin($NAMA_PROYEK, $LOKASI, $INISIAL, $STATUS_PROYEK, $TANGGAL_MULAI_PROYEK, $TANGGAL_SELESAI_PROYEK);

					$simpan_data2 = $this->Proyek_model->set_md5_id_proyek($NAMA_PROYEK, $LOKASI, $INISIAL);

					// AMBIL ID PROYEK DARI TABLE PROYEK DENGAN PARAMETER NAMA PROYEK 
					$ID_PROYEK = $this->Proyek_model->get_data_by_nama_proyek($NAMA_PROYEK);

					//SIMPAN DATA MAIN PROYEK DI TABEL PROYEK_SUB_PEKERJAAN
					$NAMA_SUB_PEKERJAAN = "Main-Work";
					$this->Proyek_model->simpan_data_sub_pekerjaan($ID_PROYEK, $NAMA_SUB_PEKERJAAN);

					// AMBIL ID PROYEK_SUB_PEKERJAAN DARI TABLE PROYEK_SUB_PEKERJAAN DENGAN PARAMETER NAMA SUB PEKERJAAN 
					$ID_PROYEK_SUB_PEKERJAAN = $this->Proyek_model->get_data_id_sub_pekerjaan_by_nama_sub_pekerjaan($ID_PROYEK, $NAMA_SUB_PEKERJAAN);

					//SIMPAN RAB BARU
					$this->Proyek_model->simpan_data_rab_baru($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN);
					$this->Proyek_model->set_md5_id_rab_by_ID_PROYEK_dan_ID_PROYEK_SUB_PEKERJAAN($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN);

				} else {
					echo 'Nama Proyek sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI', 'Lokasi', 'trim|required');
			$this->form_validation->set_rules('INISIAL', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK', 'Status', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_MULAI_PROYEK', 'Tanggal Mulai Proyek', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PROYEK', 'Tanggal Selesai Proyek', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$LOKASI = $this->input->post('LOKASI');
				$INISIAL = $this->input->post('INISIAL');
				$STATUS_PROYEK = $this->input->post('STATUS_PROYEK');
				$TANGGAL_MULAI_PROYEK = $this->input->post('TANGGAL_MULAI_PROYEK');
				$TANGGAL_SELESAI_PROYEK = $this->input->post('TANGGAL_SELESAI_PROYEK');

				//check apakah nama Proyek sudah ada. jika belum ada, akan disimpan.
				if ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK) == 'Data belum ada') {

					$KETERANGAN = "Tambah Data Proyek: " . ";" . $NAMA_PROYEK . ";" . $LOKASI . ";" . $INISIAL . ";" . $STATUS_PROYEK . ";" . $TANGGAL_MULAI_PROYEK . ";" . $TANGGAL_SELESAI_PROYEK;
					$this->user_log($KETERANGAN);

					// SIMPAN DULU DATA KE TABEL PROYEK 
					$simpan_data = $this->Proyek_model->simpan_data_by_admin($NAMA_PROYEK, $LOKASI, $INISIAL, $STATUS_PROYEK, $TANGGAL_MULAI_PROYEK, $TANGGAL_SELESAI_PROYEK);

					$simpan_data2 = $this->Proyek_model->set_md5_id_proyek($NAMA_PROYEK, $LOKASI, $INISIAL);

					// AMBIL ID PROYEK DARI TABLE PROYEK DENGAN PARAMETER NAMA PROYEK 
					$ID_PROYEK = $this->Proyek_model->get_data_by_nama_proyek($NAMA_PROYEK);

					// SIMPAN ID PROYEK KE TABEL RASD
					$this->RASD_model->simpan_data_by_admin($ID_PROYEK);
					$this->RASD_model->set_md5_id_rasd($ID_PROYEK);
				} else {
					echo 'Nama Proyek sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI', 'Lokasi', 'trim|required');
			$this->form_validation->set_rules('INISIAL', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK', 'Status', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_MULAI_PROYEK', 'Tanggal Mulai Proyek', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PROYEK', 'Tanggal Selesai Proyek', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$LOKASI = $this->input->post('LOKASI');
				$INISIAL = $this->input->post('INISIAL');
				$STATUS_PROYEK = $this->input->post('STATUS_PROYEK');
				$TANGGAL_MULAI_PROYEK = $this->input->post('TANGGAL_MULAI_PROYEK');
				$TANGGAL_SELESAI_PROYEK = $this->input->post('TANGGAL_SELESAI_PROYEK');

				//check apakah nama Proyek sudah ada. jika belum ada, akan disimpan.
				if ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK) == 'Data belum ada') {

					$KETERANGAN = "Tambah Data Proyek: " . ";" . $NAMA_PROYEK . ";" . $LOKASI . ";" . $INISIAL . ";" . $STATUS_PROYEK . ";" . $TANGGAL_MULAI_PROYEK . ";" . $TANGGAL_SELESAI_PROYEK;
					$this->user_log($KETERANGAN);

					// SIMPAN DULU DATA KE TABEL PROYEK 
					$simpan_data = $this->Proyek_model->simpan_data_by_admin($NAMA_PROYEK, $LOKASI, $INISIAL, $STATUS_PROYEK, $TANGGAL_MULAI_PROYEK, $TANGGAL_SELESAI_PROYEK);

					$simpan_data2 = $this->Proyek_model->set_md5_id_proyek($NAMA_PROYEK, $LOKASI, $INISIAL);

					// AMBIL ID PROYEK DARI TABLE PROYEK DENGAN PARAMETER NAMA PROYEK 
					$ID_PROYEK = $this->Proyek_model->get_data_by_nama_proyek($NAMA_PROYEK);

					$NAMA_LOKASI_PENYERAHAN = "Gudang Logistik Kantor Pusat PT. WME, JL. Raya Cakung Cilincing, Km 1 No.11 Gedung WASA, RT.11/RW.7, Cakung Bar., Kec. Cakung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13910";

					// SIMPAN DULU DATA KE TABEL PROYEK 
					$this->Proyek_model->simpan_data_lokasi($ID_PROYEK, $NAMA_LOKASI_PENYERAHAN);


					// //SIMPAN DATA MAIN PROYEK DI TABEL PROYEK_SUB_PEKERJAAN
					// $NAMA_SUB_PEKERJAAN = "Main-Work";
					// $this->Proyek_model->simpan_data_sub_pekerjaan($ID_PROYEK, $NAMA_SUB_PEKERJAAN);

					// // AMBIL ID PROYEK_SUB_PEKERJAAN DARI TABLE PROYEK_SUB_PEKERJAAN DENGAN PARAMETER NAMA SUB PEKERJAAN 
					// $ID_PROYEK_SUB_PEKERJAAN = $this->Proyek_model->get_data_id_sub_pekerjaan_by_nama_sub_pekerjaan($ID_PROYEK, $NAMA_SUB_PEKERJAAN);

					// //SIMPAN RAB BARU
					// $this->Proyek_model->simpan_data_rab_baru($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN);
					// $this->Proyek_model->set_md5_id_rab_by_ID_PROYEK_dan_ID_PROYEK_SUB_PEKERJAAN($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN);

				} else {
					echo 'Nama Proyek sudah terekam sebelumnya';
				}
			}
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK2', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI2', 'Lokasi', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('INISIAL2', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK2', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PROYEK2 = $this->input->post('ID_PROYEK2');
				$NAMA_PROYEK2 = $this->input->post('NAMA_PROYEK2');
				$LOKASI2 = $this->input->post('LOKASI2');
				$INISIAL2 = $this->input->post('INISIAL2');
				$STATUS_PROYEK2 = $this->input->post('STATUS_PROYEK2');

				//cek apakah input sama dengan eksisting
				$data = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

				if ($data['NAMA_PROYEK'] == $NAMA_PROYEK2 || ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK2) == 'Data belum ada')) {
					$data_awal = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

					//log
					$KETERANGAN = "Ubah Data Proyek: " . json_encode($data_awal) . " ---- " . $NAMA_PROYEK2 . ";" . $LOKASI2 . ";" . $INISIAL2 . ";" . $STATUS_PROYEK2;
					$this->user_log($KETERANGAN);

					$data = $this->Proyek_model->update_data($ID_PROYEK2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $STATUS_PROYEK2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Proyek sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK2', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI2', 'Lokasi', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('INISIAL2', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK2', 'Status', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_MULAI_PROYEK2', 'Tanggal Mulai Proyek', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PROYEK2', 'Tanggal Selesai Proyek', 'trim|required');
			

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PROYEK2 = $this->input->post('ID_PROYEK2');
				$NAMA_PROYEK2 = $this->input->post('NAMA_PROYEK2');
				$LOKASI2 = $this->input->post('LOKASI2');
				$INISIAL2 = $this->input->post('INISIAL2');
				$STATUS_PROYEK2 = $this->input->post('STATUS_PROYEK2');
				$TANGGAL_MULAI_PROYEK2 = $this->input->post('TANGGAL_MULAI_PROYEK2');
				$TANGGAL_SELESAI_PROYEK2 = $this->input->post('TANGGAL_SELESAI_PROYEK2');
				$PERSENTASE2 = $this->input->post('PERSENTASE2');

				//cek apakah input sama dengan eksisting
				$data = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

				if ($data['NAMA_PROYEK'] == $NAMA_PROYEK2 || ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK2) == 'Data belum ada')) {
					$data_awal = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

					//log
					$KETERANGAN = "Ubah Data Proyek: " . json_encode($data_awal) . " ---- " . $NAMA_PROYEK2 . ";" . $LOKASI2 . ";" . $INISIAL2 . ";" . $STATUS_PROYEK2 . ";" . $TANGGAL_MULAI_PROYEK2 . ";" . $TANGGAL_SELESAI_PROYEK2 . ";" . $PERSENTASE2;
					$this->user_log($KETERANGAN);

					$data = $this->Proyek_model->update_data($ID_PROYEK2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $STATUS_PROYEK2, $TANGGAL_MULAI_PROYEK2, $TANGGAL_SELESAI_PROYEK2, $PERSENTASE2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Proyek sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK2', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI2', 'Lokasi', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('INISIAL2', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK2', 'Status', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_MULAI_PROYEK2', 'Tanggal Mulai Proyek', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PROYEK2', 'Tanggal Selesai Proyek', 'trim|required');
			

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PROYEK2 = $this->input->post('ID_PROYEK2');
				$NAMA_PROYEK2 = $this->input->post('NAMA_PROYEK2');
				$LOKASI2 = $this->input->post('LOKASI2');
				$INISIAL2 = $this->input->post('INISIAL2');
				$STATUS_PROYEK2 = $this->input->post('STATUS_PROYEK2');
				$TANGGAL_MULAI_PROYEK2 = $this->input->post('TANGGAL_MULAI_PROYEK2');
				$TANGGAL_SELESAI_PROYEK2 = $this->input->post('TANGGAL_SELESAI_PROYEK2');
				$PERSENTASE2 = $this->input->post('PERSENTASE2');

				//cek apakah input sama dengan eksisting
				$data = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

				if ($data['NAMA_PROYEK'] == $NAMA_PROYEK2 || ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK2) == 'Data belum ada')) {
					$data_awal = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

					//log
					$KETERANGAN = "Ubah Data Proyek: " . json_encode($data_awal) . " ---- " . $NAMA_PROYEK2 . ";" . $LOKASI2 . ";" . $INISIAL2 . ";" . $STATUS_PROYEK2 . ";" . $TANGGAL_MULAI_PROYEK2 . ";" . $TANGGAL_SELESAI_PROYEK2 . ";" . $PERSENTASE2;
					$this->user_log($KETERANGAN);

					$data = $this->Proyek_model->update_data($ID_PROYEK2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $STATUS_PROYEK2, $TANGGAL_MULAI_PROYEK2, $TANGGAL_SELESAI_PROYEK2, $PERSENTASE2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Proyek sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK2', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI2', 'Lokasi', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('INISIAL2', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK2', 'Status', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_MULAI_PROYEK2', 'Tanggal Mulai Proyek', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PROYEK2', 'Tanggal Selesai Proyek', 'trim|required');
			

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PROYEK2 = $this->input->post('ID_PROYEK2');
				$NAMA_PROYEK2 = $this->input->post('NAMA_PROYEK2');
				$LOKASI2 = $this->input->post('LOKASI2');
				$INISIAL2 = $this->input->post('INISIAL2');
				$STATUS_PROYEK2 = $this->input->post('STATUS_PROYEK2');
				$TANGGAL_MULAI_PROYEK2 = $this->input->post('TANGGAL_MULAI_PROYEK2');
				$TANGGAL_SELESAI_PROYEK2 = $this->input->post('TANGGAL_SELESAI_PROYEK2');
				$PERSENTASE2 = $this->input->post('PERSENTASE2');

				//cek apakah input sama dengan eksisting
				$data = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

				if ($data['NAMA_PROYEK'] == $NAMA_PROYEK2 || ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK2) == 'Data belum ada')) {
					$data_awal = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

					//log
					$KETERANGAN = "Ubah Data Proyek: " . json_encode($data_awal) . " ---- " . $NAMA_PROYEK2 . ";" . $LOKASI2 . ";" . $INISIAL2 . ";" . $STATUS_PROYEK2 . ";" . $TANGGAL_MULAI_PROYEK2 . ";" . $TANGGAL_SELESAI_PROYEK2 . ";" . $PERSENTASE2;
					$this->user_log($KETERANGAN);

					$data = $this->Proyek_model->update_data($ID_PROYEK2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $STATUS_PROYEK2, $TANGGAL_MULAI_PROYEK2, $TANGGAL_SELESAI_PROYEK2, $PERSENTASE2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Proyek sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK2', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI2', 'Lokasi', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('INISIAL2', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK2', 'Status', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_MULAI_PROYEK2', 'Tanggal Mulai Proyek', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PROYEK2', 'Tanggal Selesai Proyek', 'trim|required');
			

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PROYEK2 = $this->input->post('ID_PROYEK2');
				$NAMA_PROYEK2 = $this->input->post('NAMA_PROYEK2');
				$LOKASI2 = $this->input->post('LOKASI2');
				$INISIAL2 = $this->input->post('INISIAL2');
				$STATUS_PROYEK2 = $this->input->post('STATUS_PROYEK2');
				$TANGGAL_MULAI_PROYEK2 = $this->input->post('TANGGAL_MULAI_PROYEK2');
				$TANGGAL_SELESAI_PROYEK2 = $this->input->post('TANGGAL_SELESAI_PROYEK2');
				$PERSENTASE2 = $this->input->post('PERSENTASE2');

				//cek apakah input sama dengan eksisting
				$data = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

				if ($data['NAMA_PROYEK'] == $NAMA_PROYEK2 || ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK2) == 'Data belum ada')) {
					$data_awal = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

					//log
					$KETERANGAN = "Ubah Data Proyek: " . json_encode($data_awal) . " ---- " . $NAMA_PROYEK2 . ";" . $LOKASI2 . ";" . $INISIAL2 . ";" . $STATUS_PROYEK2 . ";" . $TANGGAL_MULAI_PROYEK2 . ";" . $TANGGAL_SELESAI_PROYEK2 . ";" . $PERSENTASE2;
					$this->user_log($KETERANGAN);

					$data = $this->Proyek_model->update_data($ID_PROYEK2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $STATUS_PROYEK2, $TANGGAL_MULAI_PROYEK2, $TANGGAL_SELESAI_PROYEK2, $PERSENTASE2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Proyek sudah terekam sebelumnya');
				}
			}
		} else {
			$this->logout();
		}
	}

	function simpan_data_lokasi_penyerahan()
	{
		if ($this->ion_auth->logged_in()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_LOKASI_PENYERAHAN', 'Nama Lokasi Penyerahan', 'trim|required|max_length[255]');
			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$NAMA_LOKASI_PENYERAHAN = $this->input->post('NAMA_LOKASI_PENYERAHAN');

				//check apakah nama Lokasi Penyerahan sudah ada. jika belum ada, akan disimpan.
				if ($this->Proyek_model->cek_nama_lokasi($NAMA_LOKASI_PENYERAHAN, $ID_PROYEK) == 'Data belum ada') {

					$KETERANGAN = "Tambah Data Lokasi: " . ";" . $ID_PROYEK . ";" . $NAMA_LOKASI_PENYERAHAN;
					$this->user_log($KETERANGAN);

					// SIMPAN DULU DATA KE TABEL PROYEK 
					$this->Proyek_model->simpan_data_lokasi($ID_PROYEK, $NAMA_LOKASI_PENYERAHAN);

					$HASH_MD5_PROYEK = $this->session->userdata('HASH_MD5_PROYEK');
					redirect('/proyek/detil_proyek/' . $HASH_MD5_PROYEK, 'refresh');
				} else {
					echo 'Nama Proyek sudah terekam sebelumnya';
				}
			}
		} else {
			$this->logout();
		}
	}

	function simpan_data_sub_pekerjaan()
	{
		if ($this->ion_auth->logged_in()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SUB_PEKERJAAN', 'Nama Sub Pekerjaan', 'trim|required|max_length[255]');
			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$NAMA_SUB_PEKERJAAN = $this->input->post('NAMA_SUB_PEKERJAAN');

				//check apakah nama Sub Pekerjaan sudah ada. jika belum ada, akan disimpan.
				if ($this->Proyek_model->cek_nama_sub_pekerjaan($ID_PROYEK, $NAMA_SUB_PEKERJAAN) == 'Data belum ada') {

					$KETERANGAN = "Tambah Data Lokasi: " . ";" . $ID_PROYEK . ";" . $NAMA_SUB_PEKERJAAN;
					$this->user_log($KETERANGAN);

					// SIMPAN DULU DATA KE TABEL PROYEK 
					$this->Proyek_model->simpan_data_sub_pekerjaan($ID_PROYEK, $NAMA_SUB_PEKERJAAN);

					// AMBIL ID PROYEK_SUB_PEKERJAAN DARI TABLE PROYEK_SUB_PEKERJAAN DENGAN PARAMETER NAMA SUB PEKERJAAN 
					$ID_PROYEK_SUB_PEKERJAAN = $this->Proyek_model->get_data_id_sub_pekerjaan_by_nama_sub_pekerjaan($ID_PROYEK, $NAMA_SUB_PEKERJAAN);

					//SIMPAN RAB BARU
					$this->Proyek_model->simpan_data_rab_baru($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN);
					$this->Proyek_model->set_md5_id_rab_by_ID_PROYEK_dan_ID_PROYEK_SUB_PEKERJAAN($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN);

					$HASH_MD5_PROYEK = $this->session->userdata('HASH_MD5_PROYEK');
					redirect('/proyek/detil_proyek/' . $HASH_MD5_PROYEK, 'refresh');
				} else {
					echo 'Nama Sub Pekerjaan sudah terekam sebelumnya';
				}
			}
		} else {
			$this->logout();
		}
	}

	
	function update_data_organisasi()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_PEGAWAI_PM', 'Project Manager', 'trim|required');
			$this->form_validation->set_rules('ID_PEGAWAI_SM', 'Site Manager', 'trim|required');
			$this->form_validation->set_rules('ID_PEGAWAI_LOG', 'Supervisor Logistik', 'trim|required');
			$this->form_validation->set_rules('ID_PEGAWAI_PROC', 'Supervisor Procurement', 'trim|required');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_PEGAWAI_PM = $this->input->post('ID_PEGAWAI_PM');
				$ID_PEGAWAI_SM = $this->input->post('ID_PEGAWAI_SM');
				$ID_PEGAWAI_LOG = $this->input->post('ID_PEGAWAI_LOG');
				$ID_PEGAWAI_PROC = $this->input->post('ID_PEGAWAI_PROC');


				$data_awal = $this->Proyek_model->proyek_list_by_id_proyek($ID_PROYEK);

				$data = $this->Proyek_model->update_data_organisasi(
					$ID_PROYEK,
					$ID_PEGAWAI_PM,
					$ID_PEGAWAI_SM,
					$ID_PEGAWAI_LOG,
					$ID_PEGAWAI_PROC
				);
				echo json_encode($data);

				//log
				// $KETERANGAN = "Ubah Data Barang: " . json_encode($data_awal) . " ---- " .$NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT. ";" . $KODE_BARANG. ";" . $PERALATAN_PERLENGKAPAN. ";" . $DIMENSI_PANJANG. ";" . $DIMENSI_LEBAR. ";" . $DIMENSI_TINGGI. ";" . $SPESIFIKASI_LENGKAP. ";" . $SPESIFIKASI_SINGKAT. ";" . $CARA_SINGKAT_PENGGUNAAN. ";" . $CARA_PENYIMPANAN_BARANG. ";" . $MASA_PAKAI;
			}
		} else {
			$this->ion_auth->logout();
		}
	}

	public function detil_proyek()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		//get data tabel users untuk ditampilkan
		$user = $this->ion_auth->user()->row();
		$this->data['user_id'] = $user->id;
		$this->data['USER_ID'] = $user->id;
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
		$this->data['role_user'] = $data_role_user['description'];
		$this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		date_default_timezone_set('Asia/Jakarta');
		$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');
		$this->data['title'] = 'SiPESUT | Detil Proyek';

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$this->data['departemen'] = $this->Departemen_model->departemen_list();
		$this->data['HASH_MD5_PROYEK'] = $this->uri->segment(3);
		$this->data['proyek'] = $this->Proyek_model->detil_proyek_by_HASH_MD5_PROYEK_result($this->data['HASH_MD5_PROYEK']);

		//Kueri data di tabel proyek
		$query_detil_proyek_HASH_MD5_PROYEK = $this->Proyek_model->detil_proyek_by_HASH_MD5_PROYEK($this->data['HASH_MD5_PROYEK']);

		$query_detil_proyek_HASH_MD5_PROYEK_result = $this->Proyek_model->detil_proyek_by_HASH_MD5_PROYEK_result($this->data['HASH_MD5_PROYEK']);
		$this->data['query_detil_proyek_HASH_MD5_PROYEK_result'] = $query_detil_proyek_HASH_MD5_PROYEK_result;

		if ($query_detil_proyek_HASH_MD5_PROYEK->num_rows() == 0) {
			// alihkan mereka ke halaman list proyek
			redirect('proyek', 'refresh');
		}
		//Kueri data di tabel proyek file
		$query_file_HASH_MD5_PROYEK = $this->Proyek_file_model->file_list_by_HASH_MD5_PROYEK($this->data['HASH_MD5_PROYEK']);

		//log
		$KETERANGAN = "Lihat Profil Proyek: " . json_encode($query_detil_proyek_HASH_MD5_PROYEK_result) . " ---- " . json_encode($query_file_HASH_MD5_PROYEK);
		$this->user_log($KETERANGAN);

		$hasil_1 = $query_detil_proyek_HASH_MD5_PROYEK->row();
		$this->data['HASH_MD5_PROYEK'] = $hasil_1->HASH_MD5_PROYEK;
		$this->data['ID_PROYEK'] = $hasil_1->ID_PROYEK;

		$sess_data['HASH_MD5_PROYEK'] = $this->data['HASH_MD5_PROYEK'];
		$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
		$this->session->set_userdata($sess_data);

		if ($query_file_HASH_MD5_PROYEK->num_rows() > 0) {

			$this->data['dokumen'] = $this->Proyek_file_model->file_list_by_HASH_MD5_PROYEK_result($sess_data['HASH_MD5_PROYEK']);

			$hasil = $query_file_HASH_MD5_PROYEK->row();
			$DOK_FILE = $hasil->DOK_FILE;
			$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

			if (file_exists($file = './assets/upload_proyek_file/' . $DOK_FILE)) {
				$this->data['DOK_FILE'] = $DOK_FILE;
				$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
				$this->data['FILE'] = "ADA";
			} else {
				$this->data['FILE'] = "ADA";
			}
		} else {
			$this->data['FILE'] = "TIDAK ADA";
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) { //user_admin

			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_proyek_file');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) { //user_chief_sp

			$this->load->view('wasa/user_chief_sp/head_normal', $this->data);
			$this->load->view('wasa/user_chief_sp/user_menu');
			$this->load->view('wasa/user_chief_sp/left_menu');
			$this->load->view('wasa/user_chief_sp/header_menu');
			$this->load->view('wasa/user_chief_sp/content_proyek_file');
			$this->load->view('wasa/user_chief_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) { //user_sm_sp

			$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
			$this->load->view('wasa/user_sm_sp/user_menu');
			$this->load->view('wasa/user_sm_sp/left_menu');
			$this->load->view('wasa/user_sm_sp/header_menu');
			$this->load->view('wasa/user_sm_sp/content_proyek_file');
			$this->load->view('wasa/user_sm_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) { //user_pm_sp

			$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
			$this->load->view('wasa/user_pm_sp/user_menu');
			$this->load->view('wasa/user_pm_sp/left_menu');
			$this->load->view('wasa/user_pm_sp/header_menu');
			$this->load->view('wasa/user_pm_sp/content_proyek_file');
			$this->load->view('wasa/user_pm_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) { //user_staff_procurement_kp

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_proyek_file');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) { //user_kasie_procurement_kp

			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_proyek_file');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) { //user_manajer_procurement_kp

			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_proyek_file');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) { //user_staff_procurement_sp

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_proyek_file');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) { //user_supervisi_procurement_sp

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_proyek_file');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) { //user_staff_umum_logistik_kp

			$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/content_proyek_file');
			$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) { //user_kasie_logistik_kp

			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_proyek_file');
			$this->load->view('wasa/user_kasie_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) { //user_manajer_logistik_kp

			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_proyek_file');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) { //user_staff_umum_logistik_sp

			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_proyek_file');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) { //user_staff_gudang_logistik_sp

			$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/content_proyek_file');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) { //user_supervisi_logistik_sp

			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_proyek_file');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else {
			$this->logout();
		}
	}

	function data_pic_proyek()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->pegawai_list_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data PIC Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_lokasi_penyerahan()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_PROYEK  = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Lokasi Penyerahan: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_sub_pekerjaan()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_PROYEK  = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->sub_pekerjaan_list_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Lokasi Penyerahan: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_lokasi()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->get('id');
			$data = $this->Proyek_model->get_data_lokasi_by_id_proyek_lokasi_penyerahan($ID_PROYEK_LOKASI_PENYERAHAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// log the user out
			$this->logout();
		}
	}

	function get_data_sub_pekerjaan()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_PROYEK_SUB_PEKERJAAN = $this->input->get('id');
			$data = $this->Proyek_model->get_data_sub_pekerjaan_by_id_proyek_sub_pekerjaan($ID_PROYEK_SUB_PEKERJAAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Sub Pekerjaan: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// log the user out
			$this->logout();
		}
	}

	function hapus_data_lokasi()
	{
		if ($this->ion_auth->logged_in()) {
			$user = $this->ion_auth->user()->row();
			$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('kode');
			$data_hapus = $this->Proyek_model->get_data_by_id_lokasi($ID_PROYEK_LOKASI_PENYERAHAN);

			$data = $this->Proyek_model->hapus_data_lokasi($ID_PROYEK_LOKASI_PENYERAHAN);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Lokasi Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else {
			///log the user out
			$this->logout();
		}
	}

	function hapus_data_sub_pekerjaan()
	{
		if ($this->ion_auth->logged_in()) {
			$user = $this->ion_auth->user()->row();
			$ID_PROYEK_SUB_PEKERJAAN = $this->input->post('kode');
			$data_hapus = $this->Proyek_model->get_data_by_id_sub_pekerjaan($ID_PROYEK_SUB_PEKERJAAN);

			$data = $this->Proyek_model->hapus_data_sub_pekerjaan($ID_PROYEK_SUB_PEKERJAAN);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Sub Pekerjaan: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else {
			///log the user out
			$this->logout();
		}
	}

	//Untuk proses upload file
	function proses_upload_file()
	{

		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		$HASH_MD5_PROYEK = $this->session->userdata('HASH_MD5_PROYEK');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in()) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_PROYEK . '_';
			$config['upload_path']   = './assets/upload_proyek_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_proyek = $this->Proyek_model->get_id_proyek_by_HASH_MD5_PROYEK($HASH_MD5_PROYEK);
			$ID_PROYEK = $query_id_proyek['ID_PROYEK'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');
				$KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

				$KETERANGAN = './assets/upload_proyek_file/' . $nama;
				$this->db->insert('proyek_file', array('ID_PROYEK' => $ID_PROYEK, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_PROYEK' => $HASH_MD5_PROYEK, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
				echo ($JENIS_FILE);
			} else {
				redirect($_SERVER['REQUEST_URI'], 'refresh');
			}
		} else {
			$this->logout();
		}
	}
	//Hapus file by button
	function hapus_file()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		//get data dari parameter URL
		$this->data['DOK_FILE'] = $this->uri->segment(3);

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in()) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Proyek_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_proyek_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Proyek_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PROYEK = $this->session->userdata('HASH_MD5_PROYEK');
				redirect('/proyek/detil_proyek/' . $HASH_MD5_PROYEK, 'refresh');
			} else {
				$HASH_MD5_PROYEK = $this->session->userdata('HASH_MD5_PROYEK');
				redirect('/proyek/detil_proyek/' . $HASH_MD5_PROYEK, 'refresh');
			}
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
}
