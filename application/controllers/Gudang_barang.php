<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gudang_barang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Gudang Barang';

		$this->load->model('Gudang_barang_model');
		$this->load->model('Gudang_model');
		$this->load->model('Foto_model');
		$this->load->model('Organisasi_model');
		$this->load->model('Proyek_model');
		$this->load->model('Manajemen_user_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "Gudang_barang_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Gudang Barang";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Gudang_barang_model->user_log_gudang_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Gudang_barang_model->user_log_gudang_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		$HASH_MD5_GUDANG = $this->uri->segment(3);
		$this->data['HASH_MD5_GUDANG'] = $HASH_MD5_GUDANG;
		if ($this->Gudang_model->get_id_model_by_HASH_MD5_GUDANG($HASH_MD5_GUDANG) == 'TIDAK ADA DATA') {
			redirect('Gudang', 'refresh');
		}

		$hasil = $this->Gudang_barang_model->get_id_gudang_by_HASH_MD5_GUDANG($HASH_MD5_GUDANG);
		$ID_GUDANG = $hasil['ID_GUDANG'];
		$ID_PROYEK = $hasil['ID_PROYEK'];
		$NAMA_GUDANG = $hasil['NAMA_GUDANG'];
		$LOKASI_GUDANG = $hasil['LOKASI_GUDANG'];
		$this->data['NAMA_GUDANG'] = $NAMA_GUDANG;
		$this->data['LOKASI_GUDANG'] = $LOKASI_GUDANG;

		$sess_data['ID_GUDANG'] = $ID_GUDANG;
		$sess_data['HASH_MD5_GUDANG'] = $HASH_MD5_GUDANG;
		$this->session->set_userdata($sess_data);

		$detil_proyek_by_ID_PROYEK_result = $this->Proyek_model->detil_proyek_by_ID_PROYEK_result($ID_PROYEK);
		$this->data['detil_proyek_by_ID_PROYEK_result'] = $detil_proyek_by_ID_PROYEK_result;

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['proyek'] = $this->Proyek_model->list_proyek();
			//$this->data['pegawai']=$this->Organisasi_model->pegawai_list();

			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_gudang_barang');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_gudang_barang');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_gudang_barang');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_gudang_barang');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_gudang_barang');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_gudang_barang');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/content_gudang_barang');
			$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_gudang_barang');
			$this->load->view('wasa/user_kasie_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_gudang_barang');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_gudang_barang');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/content_gudang_barang');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_gudang_barang');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else {
			$this->logout();
		}
	}

	function get_pegawai_proyek()
	{
		$ID_PROYEK = $this->input->post('id', TRUE);
		$data = $this->Organisasi_model->pegawai_list_by_id_proyek_logistik($ID_PROYEK);
		echo json_encode($data);

		$KETERANGAN = "Get Data Pegawai By Proyek: " . json_encode($data);
		$this->user_log($KETERANGAN);
	}

	function data_gudang_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$data = $this->Gudang_barang_model->gudang_barang_list();
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$ID_GUDANG = $this->session->userdata('ID_GUDANG');
			$data = $this->Gudang_barang_model->gudang_barang_list_by_ID_GUDANG($ID_GUDANG);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Barang di Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Gudang_barang_model->get_data_by_id_Gudang_barang($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Gudang_barang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();
			$ID_Gudang_barang = $this->input->post('kode');
			$data = $this->Gudang_barang_model->get_data_by_id_Gudang_barang($ID_Gudang_barang);

			// //log
			// $KETERANGAN = "Hapus Gudang_barang ".$data['NAMA_Gudang_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Gudang_barang_model->log_Gudang_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Gudang_barang_model->hapus_data_by_id_Gudang_barang($ID_Gudang_barang);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();
		// 	$id_Gudang_barang=$this->input->post('kode');
		// 	$data=$this->Gudang_barang_model->get_data_by_id_Gudang_barang($id_Gudang_barang);

		// 	//log
		// 	$KETERANGAN = "Hapus Gudang_barang ".$data['NAMA_Gudang_barang'].", ket ".$data['KETERANGAN'];
		// 	$WAKTU = date('Y-m-d H:i:s');
		// 	$this->Gudang_barang_model->log_Gudang_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 	$data=$this->Gudang_barang_model->hapus_data($id_Gudang_barang);
		// 	echo json_encode($data);
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function simpan_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('PEGAWAI_LOG_Gudang_barang', 'Nama Pegawai Logistik Gudang_barang', 'trim|required');
			$this->form_validation->set_rules('NAMA_Gudang_barang', 'Nama Gudang_barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI_Gudang_barang', 'Lokasi Gudang_barang', 'trim|required|max_length[100]');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$PEGAWAI_LOG_Gudang_barang = $this->input->post('PEGAWAI_LOG_Gudang_barang');
				$NAMA_Gudang_barang = $this->input->post('NAMA_Gudang_barang');
				$LOKASI_Gudang_barang = $this->input->post('LOKASI_Gudang_barang');

				//check apakah nama Gudang_barang sudah ada. jika belum ada, akan disimpan.
				if ($this->Gudang_barang_model->cek_nama_Gudang_barang_by_admin($NAMA_Gudang_barang) == 'Data belum ada') {
					//log
					// $KETERANGAN = "Simpan Gudang_barang ".$NAMA_Gudang_barang.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Gudang_barang_model->log_Gudang_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Gudang_barang_model->simpan_data_by_admin($NAMA_PROYEK, $PEGAWAI_LOG_Gudang_barang, $NAMA_Gudang_barang, $LOKASI_Gudang_barang);
				} else {
					echo 'Nama Gudang_barang sudah terekam sebelumnya';
				}
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_Gudang_barang', 'Nama Gudang_barang', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo validation_errors();
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$nama_Gudang_barang = $this->input->post('nama_Gudang_barang');
		// 		$keterangan = $this->input->post('keterangan');
		// 		if($this->Gudang_barang_model->cek_nama_Gudang_barang_by_pegawai($nama_Gudang_barang, $user->ID_PEGAWAI) == 'Data belum ada')
		// 		{
		// 			//log
		// 			$KETERANGAN = "Simpan Gudang_barang ".$nama_Gudang_barang.", ket ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Gudang_barang_model->log_Gudang_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Gudang_barang_model->simpan_data_by_pegawai($nama_Gudang_barang,$keterangan, $user->ID_PEGAWAI);
		// 		}
		// 		else
		// 		{
		// 			echo 'Nama Gudang_barang sudah terekam sebelumnya';
		// 		}

		// 	}
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('PEGAWAI_LOG_Gudang_barang2', 'Nama Pegawai Logistik Gudang_barang', 'trim|required');
			$this->form_validation->set_rules('NAMA_Gudang_barang2', 'Nama Gudang_barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI_Gudang_barang2', 'Lokasi Gudang_barang', 'trim|required|max_length[100]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_Gudang_barang2 = $this->input->post('ID_Gudang_barang2');
				$PEGAWAI_LOG_Gudang_barang2 = $this->input->post('PEGAWAI_LOG_Gudang_barang2');
				$NAMA_Gudang_barang2 = $this->input->post('NAMA_Gudang_barang2');
				$LOKASI_Gudang_barang2 = $this->input->post('LOKASI_Gudang_barang2');

				//cek apakah input sama dengan eksisting
				$data = $this->Gudang_barang_model->get_data_by_id_Gudang_barang($ID_Gudang_barang2);

				if ($data['NAMA_Gudang_barang'] == $NAMA_Gudang_barang2 || ($this->Gudang_barang_model->cek_nama_Gudang_barang_by_admin($NAMA_Gudang_barang2) == 'Data belum ada')) {
					$data = $this->Gudang_barang_model->get_data_by_id_Gudang_barang($ID_Gudang_barang2);

					//log
					// $KETERANGAN = "Ubah Gudang_barang ".$data['NAMA_Gudang_barang']." jadi ".$nama_Gudang_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Gudang_barang_model->log_Gudang_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Gudang_barang_model->update_data($ID_Gudang_barang2, $PEGAWAI_LOG_Gudang_barang2, $NAMA_Gudang_barang2, $LOKASI_Gudang_barang2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Gudang_barang sudah terekam sebelumnya');
				}
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_Gudang_barang2', 'Nama Gudang_barang', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo json_encode(validation_errors());
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$id_Gudang_barang=$this->input->post('id_Gudang_barang2');
		// 		$nama_Gudang_barang=$this->input->post('nama_Gudang_barang2');
		// 		$keterangan=$this->input->post('keterangan2');

		// 		//cek apakah input sama dengan eksisting
		// 		$data=$this->Gudang_barang_model->get_data_by_id_Gudang_barang($id_Gudang_barang);

		// 		if($data['NAMA_Gudang_barang'] == $nama_Gudang_barang || ($this->Gudang_barang_model->cek_nama_Gudang_barang_by_pegawai($nama_Gudang_barang, $user->ID_PEGAWAI) == 'Data belum ada'))
		// 		{
		// 			$data=$this->Gudang_barang_model->get_data_by_id_Gudang_barang($id_Gudang_barang);

		// 			//log
		// 			$KETERANGAN = "Ubah Gudang_barang ".$data['NAMA_Gudang_barang']." jadi ".$nama_Gudang_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Gudang_barang_model->log_Gudang_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Gudang_barang_model->update_data($id_Gudang_barang, $nama_Gudang_barang,$keterangan);
		// 			echo json_encode($data);
		// 		}
		// 		else
		// 		{
		// 			echo json_encode('Nama Gudang_barang sudah terekam sebelumnya');
		// 		}
		// 	}
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
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
}
