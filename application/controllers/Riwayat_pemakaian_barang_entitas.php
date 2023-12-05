<?php defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_pemakaian_barang_entitas extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Riwayat Pemakaian Barang';

		$this->load->model('Riwayat_pemakaian_barang_entitas_model');
		$this->load->model('Foto_model');
		$this->load->model('Barang_master_model');
		$this->load->model('Barang_entitas_model');
		$this->load->model('Barang_master_file_model');
		$this->load->model('RFQ_model');
		$this->load->model('RFQ_form_model');
		$this->load->model('Vendor_model');
		$this->load->model('SPPB_form_model');
		$this->load->model('SPPB_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('RFQ_Form_File_Model');
		$this->load->model('Term_Of_Payment_model');
		$this->load->model('Proyek_model');
		$this->load->model('Departemen_model');
		//$this->load->model('ws_pegawai_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Riwayat Pemakaian Barang Entitas";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Riwayat_pemakaian_barang_entitas_model->user_log_riwayat_pemakaian_b_e($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Riwayat_pemakaian_barang_entitas_model->user_log_riwayat_pemakaian_b_e($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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
		$this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		date_default_timezone_set('Asia/Jakarta');
		$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');
		$this->data['left_menu'] = "Riwayat_pemakaian_barang_entitas_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_kasie_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_riwayat_pemakaian_barang_entitas');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_Riwayat_pemakaian_barang_entitas');
		// }
		else {
			$this->logout();
		}
	}

	function data_riwayat_pemakaian_barang_entitas()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$HASH_MD5_RIWAYAT = $this->session->userdata('HASH_MD5_RIWAYAT');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Riwayat Pemakaian Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$user = $this->ion_auth->user()->row();
		// 	$data=$this->Riwayat_pemakaian_barang_entitas_model->Riwayat_pemakaian_barang_entitas_list_by_id_pegawai_atau_status($user->ID_PEGAWAI);
		// 	echo json_encode($data);
		// }
		else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$ID_R_PEMAKAIAN_B_E = $this->input->get('id');
			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$id=$this->input->get('id');
		// 	$data=$this->Riwayat_pemakaian_barang_entitas_model->get_data_by_id_Riwayat_pemakaian_barang_entitas($id);
		// 	echo json_encode($data);
		// }
		else {
			$this->logout();
		}
	}

	//custom validation function to accept alphabets and space
	function alpha_space_only($str)
	{
		if (!preg_match("/^[a-zA-Z ]+$/", $str)) {
			$this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function item()
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
		$this->data['left_menu'] = "Riwayat_pemakaian_barang_entitas_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$this->data['HASH_MD5_BARANG_ENTITAS'] = $this->uri->segment(3);
		$HASH_MD5_BARANG_ENTITAS = $this->data['HASH_MD5_BARANG_ENTITAS'];

		if ($this->Barang_entitas_model->get_data_by_HASH_MD5_BARANG_ENTITAS($HASH_MD5_BARANG_ENTITAS) == 'BELUM ADA BARANG ENTITAS') {
			redirect('barang_master', 'refresh');
		}

		$query_barang_master_HASH_MD5_BARANG_ENTITAS_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_ENTITAS_result($HASH_MD5_BARANG_ENTITAS);
		$this->data['query_barang_master_HASH_MD5_BARANG_ENTITAS_result'] = $query_barang_master_HASH_MD5_BARANG_ENTITAS_result;
		foreach ($query_barang_master_HASH_MD5_BARANG_ENTITAS_result as $data) {
			$HASH_MD5_BARANG_MASTER = $data->HASH_MD5_BARANG_MASTER;
		}

		//Kueri data di tabel barang_master file
		$query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
		if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

			$this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);

			$hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
			$DOK_FILE = $hasil->DOK_FILE;
			$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

			if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
				$this->data['DOK_FILE'] = $DOK_FILE;
				$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
				$this->data['FILE'] = "ADA";
			}
		} else {
			$this->data['FILE'] = "TIDAK ADA";
		}

		$this->data['riwayat_pemakaian_barang_entitas'] = $this->Riwayat_pemakaian_barang_entitas_model->riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_BARANG_ENTITAS($HASH_MD5_BARANG_ENTITAS);

		$sess_data['HASH_MD5_BARANG_ENTITAS'] = $this->data['HASH_MD5_BARANG_ENTITAS'];
		$this->session->set_userdata($sess_data);

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();
			$this->data['pegawai_list'] = $this->Proyek_model->list_pegawai();
			$this->data['departemen_list'] = $this->Departemen_model->departemen_list();
			
			$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();
			$this->data['pegawai_list'] = $this->Proyek_model->list_pegawai();
			$this->data['departemen_list'] = $this->Departemen_model->departemen_list();
			
			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_kasie_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			// $hasil = $this->Riwayat_pemakaian_barang_entitas_model->get_data_riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_BARANG_ENTITAS($HASH_MD5_BARANG_ENTITAS);

			// $this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];

			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();
			$this->data['pegawai_list'] = $this->Proyek_model->list_pegawai();
			$this->data['departemen_list'] = $this->Departemen_model->departemen_list();


			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();
			$this->data['pegawai_list'] = $this->Proyek_model->list_pegawai();
			$this->data['departemen_list'] = $this->Departemen_model->departemen_list();

			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();
			$this->data['pegawai_list'] = $this->Proyek_model->list_pegawai();
			$this->data['departemen_list'] = $this->Departemen_model->departemen_list();
			
			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_riwayat_pemakaian_barang_entitas_md5');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_RFQ = $this->input->post('ID_RFQ');
				$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->RFQ_form_model->get_data_by_id_rfq_form($ID_RFQ_FORM);
				$KETERANGAN = "Coba isi RFQ Form: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->RFQ_form_model->cek_nama_barang_rfq_form($NAMA, $ID_RFQ) == 'Data belum ada') || ($data_edit['NAMA_BARANG'] == $NAMA)) {
					$KETERANGAN = "Ubah Data RFQ Form: " . json_encode($data_edit) . " ---- " . $ID_RFQ . ";" . $ID_RFQ_FORM . ";" . $NAMA  . ";" . $MEREK . ";" . $JENIS_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $SATUAN_BARANG . ";" . $JUMLAH_BARANG;
					$this->user_log($KETERANGAN);
					$data = $this->RFQ_form_model->update_data($ID_RFQ_FORM, $NAMA, $MEREK, $JENIS_BARANG, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai', 'trim|required');
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('DEPARTEMEN', 'Departemen', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PEMAKAIAN_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PEMAKAIAN_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_R_PEMAKAIAN_B_E = $this->input->post('ID_R_PEMAKAIAN_B_E');
				$NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$DEPARTEMEN = $this->input->post('DEPARTEMEN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_MULAI_PEMAKAIAN_HARI');
				$TANGGAL_SELESAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_SELESAI_PEMAKAIAN_HARI');

				$data = $this->Riwayat_pemakaian_barang_entitas_model->update_data($ID_R_PEMAKAIAN_B_E, $NAMA_PEGAWAI, $NAMA_PROYEK, $DEPARTEMEN, $KETERANGAN, $TANGGAL_MULAI_PEMAKAIAN_HARI, $TANGGAL_SELESAI_PEMAKAIAN_HARI);
				echo json_encode($data);
				
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai', 'trim|required');
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('DEPARTEMEN', 'Departemen', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PEMAKAIAN_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PEMAKAIAN_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_R_PEMAKAIAN_B_E = $this->input->post('ID_R_PEMAKAIAN_B_E');
				$NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$DEPARTEMEN = $this->input->post('DEPARTEMEN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_MULAI_PEMAKAIAN_HARI');
				$TANGGAL_SELESAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_SELESAI_PEMAKAIAN_HARI');

				$data = $this->Riwayat_pemakaian_barang_entitas_model->update_data($ID_R_PEMAKAIAN_B_E, $NAMA_PEGAWAI, $NAMA_PROYEK, $DEPARTEMEN, $KETERANGAN, $TANGGAL_MULAI_PEMAKAIAN_HARI, $TANGGAL_SELESAI_PEMAKAIAN_HARI);
				echo json_encode($data);
				
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai', 'trim|required');
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('DEPARTEMEN', 'Departemen', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PEMAKAIAN_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PEMAKAIAN_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_R_PEMAKAIAN_B_E = $this->input->post('ID_R_PEMAKAIAN_B_E');
				$NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$DEPARTEMEN = $this->input->post('DEPARTEMEN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_MULAI_PEMAKAIAN_HARI');
				$TANGGAL_SELESAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_SELESAI_PEMAKAIAN_HARI');

				$data = $this->Riwayat_pemakaian_barang_entitas_model->update_data($ID_R_PEMAKAIAN_B_E, $NAMA_PEGAWAI, $NAMA_PROYEK, $DEPARTEMEN, $KETERANGAN, $TANGGAL_MULAI_PEMAKAIAN_HARI, $TANGGAL_SELESAI_PEMAKAIAN_HARI);
				echo json_encode($data);
				
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai', 'trim|required');
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('DEPARTEMEN', 'Departemen', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PEMAKAIAN_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PEMAKAIAN_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_R_PEMAKAIAN_B_E = $this->input->post('ID_R_PEMAKAIAN_B_E');
				$NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$DEPARTEMEN = $this->input->post('DEPARTEMEN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_MULAI_PEMAKAIAN_HARI');
				$TANGGAL_SELESAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_SELESAI_PEMAKAIAN_HARI');

				$data = $this->Riwayat_pemakaian_barang_entitas_model->update_data($ID_R_PEMAKAIAN_B_E, $NAMA_PEGAWAI, $NAMA_PROYEK, $DEPARTEMEN, $KETERANGAN, $TANGGAL_MULAI_PEMAKAIAN_HARI, $TANGGAL_SELESAI_PEMAKAIAN_HARI);
				echo json_encode($data);
				
			}
		} else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			// $ID_SPPB_FORM = $this->input->post('kode');
			// $data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			// $KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			// $this->user_log($KETERANGAN);

			// $data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			// echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_R_PEMAKAIAN_B_E = $this->input->post('kode');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->hapus_data_by_id_riwayat($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_R_PEMAKAIAN_B_E = $this->input->post('kode');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->hapus_data_by_id_riwayat($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_R_PEMAKAIAN_B_E = $this->input->post('kode');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->hapus_data_by_id_riwayat($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_R_PEMAKAIAN_B_E = $this->input->post('kode');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->hapus_data_by_id_riwayat($ID_R_PEMAKAIAN_B_E);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}

	function get_data_riwayat_baru()
	{
		$user = $this->ion_auth->user()->row();
		$this->data['USER_ID'] = $user->id;
		$CREATE_BY_USER =  $this->data['USER_ID'];

		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

			$ID_PROYEK = $this->input->post('ID_PROYEK');
			$HASH_MD5_RIWAYAT = $this->input->post('ID_PROYEK');
			$ID_R_PEMAKAIAN_B_E = $this->input->post('ID_R_PEMAKAIAN_B_E');

			$data = $this->Riwayat_pemakaian_barang_entitas_model->get_data_riwayat_baru($HASH_MD5_RIWAYAT, $ID_R_PEMAKAIAN_B_E, $CREATE_BY_USER);
			echo json_encode($data);

			$KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
			$this->user_log($KETERANGAN);
		}
	}

	function simpan_data()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			// $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai', 'trim|required');
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('DEPARTEMEN', 'Departemen', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PEMAKAIAN_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PEMAKAIAN_HARI', 'Tanggal Selesai', 'trim|required');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$DEPARTEMEN = $this->input->post('DEPARTEMEN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_MULAI_PEMAKAIAN_HARI');
				$TANGGAL_SELESAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_SELESAI_PEMAKAIAN_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_pemakaian_barang_entitas_model->simpan_data_riwayat(
					$ID_PROYEK,
					$ID_PEGAWAI,
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$NAMA_PEGAWAI,
					$NAMA_PROYEK,
					$DEPARTEMEN,
					$KETERANGAN,
					$TANGGAL_MULAI_PEMAKAIAN_HARI,
					$TANGGAL_SELESAI_PEMAKAIAN_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_pemakaian_barang_entitas_model->set_md5_id_riwayat($KETERANGAN, $DEPARTEMEN, $NAMA_PROYEK, $NAMA_PEGAWAI, $CREATE_BY_USER);
				echo $hasil_2;
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			// $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai', 'trim|required');
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('DEPARTEMEN', 'Departemen', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PEMAKAIAN_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PEMAKAIAN_HARI', 'Tanggal Selesai', 'trim|required');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$DEPARTEMEN = $this->input->post('DEPARTEMEN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_MULAI_PEMAKAIAN_HARI');
				$TANGGAL_SELESAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_SELESAI_PEMAKAIAN_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_pemakaian_barang_entitas_model->simpan_data_riwayat(
					$ID_PROYEK,
					$ID_PEGAWAI,
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$NAMA_PEGAWAI,
					$NAMA_PROYEK,
					$DEPARTEMEN,
					$KETERANGAN,
					$TANGGAL_MULAI_PEMAKAIAN_HARI,
					$TANGGAL_SELESAI_PEMAKAIAN_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_pemakaian_barang_entitas_model->set_md5_id_riwayat($KETERANGAN, $DEPARTEMEN, $NAMA_PROYEK, $NAMA_PEGAWAI, $CREATE_BY_USER);
				echo $hasil_2;
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			// $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai', 'trim|required');
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('DEPARTEMEN', 'Departemen', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PEMAKAIAN_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PEMAKAIAN_HARI', 'Tanggal Selesai', 'trim|required');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$DEPARTEMEN = $this->input->post('DEPARTEMEN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_MULAI_PEMAKAIAN_HARI');
				$TANGGAL_SELESAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_SELESAI_PEMAKAIAN_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_pemakaian_barang_entitas_model->simpan_data_riwayat(
					$ID_PROYEK,
					$ID_PEGAWAI,
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$NAMA_PEGAWAI,
					$NAMA_PROYEK,
					$DEPARTEMEN,
					$KETERANGAN,
					$TANGGAL_MULAI_PEMAKAIAN_HARI,
					$TANGGAL_SELESAI_PEMAKAIAN_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_pemakaian_barang_entitas_model->set_md5_id_riwayat($KETERANGAN, $DEPARTEMEN, $NAMA_PROYEK, $NAMA_PEGAWAI, $CREATE_BY_USER);
				echo $hasil_2;
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			// $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai', 'trim|required');
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('DEPARTEMEN', 'Departemen', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PEMAKAIAN_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PEMAKAIAN_HARI', 'Tanggal Selesai', 'trim|required');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$DEPARTEMEN = $this->input->post('DEPARTEMEN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_MULAI_PEMAKAIAN_HARI');
				$TANGGAL_SELESAI_PEMAKAIAN_HARI = $this->input->post('TANGGAL_SELESAI_PEMAKAIAN_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_pemakaian_barang_entitas_model->simpan_data_riwayat(
					$ID_PROYEK,
					$ID_PEGAWAI,
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$NAMA_PEGAWAI,
					$NAMA_PROYEK,
					$DEPARTEMEN,
					$KETERANGAN,
					$TANGGAL_MULAI_PEMAKAIAN_HARI,
					$TANGGAL_SELESAI_PEMAKAIAN_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_pemakaian_barang_entitas_model->set_md5_id_riwayat($KETERANGAN, $DEPARTEMEN, $NAMA_PROYEK, $NAMA_PEGAWAI, $CREATE_BY_USER);
				echo $hasil_2;
			}
		} else {
			$this->logout();
		}
	}
}
