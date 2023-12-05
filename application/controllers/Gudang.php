<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Gudang';

		$this->load->model('Gudang_model');
		$this->load->model('Foto_model');
		$this->load->model('Organisasi_model');
		$this->load->model('Proyek_model');
		$this->load->model('Manajemen_user_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "gudang_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Gudang";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Gudang_model->user_log_gudang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Gudang_model->user_log_gudang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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
        $this->data['ID_VENDOR'] = $user->ID_VENDOR;
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

		$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
            $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
            $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

            $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
            $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

            $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
            $this->session->set_userdata($sess_data);

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['proyek'] = $this->Proyek_model->list_proyek();
			//$this->data['pegawai']=$this->Organisasi_model->pegawai_list();

			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_gudang');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_gudang');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_gudang');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_gudang');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_gudang');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_gudang');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/content_gudang');
			$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_gudang');
			$this->load->view('wasa/user_kasie_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_gudang');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/content_gudang');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_gudang');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$this->data['proyek'] = $this->Proyek_model->list_proyek();

			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_gudang');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else {
			$this->logout();
		}
	}

	function get_pegawai_proyek()
	{
		$ID_PROYEK = $this->input->post('proyek', TRUE);
		$data = $this->Organisasi_model->pegawai_list_by_id_proyek_logistik($ID_PROYEK);
		echo json_encode($data);

		$KETERANGAN = "Get Data Pegawai By Proyek: " . json_encode($data);
		$this->user_log($KETERANGAN);
	}

	function data_gudang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$data = $this->Gudang_model->gudang_list();
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$data = $this->Gudang_model->gudang_list();
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$data = $this->Gudang_model->gudang_list();
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$data = $this->Gudang_model->gudang_list();
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Gudang_model->gudang_list_by_id_proyek_result($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Gudang_model->gudang_list_by_id_proyek_result($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$data = $this->Gudang_model->gudang_list();
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$data = $this->Gudang_model->gudang_list();
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$data = $this->Gudang_model->gudang_list();
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Gudang_model->gudang_list_by_id_proyek_result($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Gudang_model->gudang_list_by_id_proyek_result($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Gudang_model->gudang_list_by_id_proyek_result($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Lihat Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Gudang_model->get_data_by_id_gudang($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$id = $this->input->get('id');
			$data = $this->Gudang_model->get_data_by_id_gudang($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$id = $this->input->get('id');
			$data = $this->Gudang_model->get_data_by_id_gudang($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$id = $this->input->get('id');
			$data = $this->Gudang_model->get_data_by_id_gudang($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Gudang: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();
			$ID_GUDANG = $this->input->post('kode');
			$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG);

			///log
			$KETERANGAN = "Hapus Gudang " . $data['NAMA_GUDANG'];
			$this->user_log($KETERANGAN);

			$data = $this->Gudang_model->hapus_data_by_id_gudang($ID_GUDANG);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$user = $this->ion_auth->user()->row();
			$ID_GUDANG = $this->input->post('kode');
			$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG);

			///log
			$KETERANGAN = "Hapus Gudang " . $data['NAMA_GUDANG'];
			$this->user_log($KETERANGAN);

			$data = $this->Gudang_model->hapus_data_by_id_gudang($ID_GUDANG);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$user = $this->ion_auth->user()->row();
			$ID_GUDANG = $this->input->post('kode');
			$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG);

			///log
			$KETERANGAN = "Hapus Gudang " . $data['NAMA_GUDANG'];
			$this->user_log($KETERANGAN);

			$data = $this->Gudang_model->hapus_data_by_id_gudang($ID_GUDANG);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();
			$ID_GUDANG = $this->input->post('kode');
			$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG);

			///log
			$KETERANGAN = "Hapus Gudang " . $data['NAMA_GUDANG'];
			$this->user_log($KETERANGAN);

			$data = $this->Gudang_model->hapus_data_by_id_gudang($ID_GUDANG);
			echo json_encode($data);
		} else {
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
			$this->form_validation->set_rules('PEGAWAI_LOG_GUDANG', 'Nama Pegawai Logistik Gudang', 'trim|required');
			$this->form_validation->set_rules('NAMA_GUDANG', 'Nama Gudang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI_GUDANG', 'Lokasi Gudang', 'trim|required|max_length[100]');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$PEGAWAI_LOG_GUDANG = $this->input->post('PEGAWAI_LOG_GUDANG');
				$NAMA_GUDANG = $this->input->post('NAMA_GUDANG');
				$LOKASI_GUDANG = $this->input->post('LOKASI_GUDANG');

				//check apakah nama Gudang sudah ada. jika belum ada, akan disimpan.
				if ($this->Gudang_model->cek_nama_gudang_by_admin($NAMA_GUDANG) == 'Data belum ada') {
					//log
					// $KETERANGAN = "Simpan Gudang ".$NAMA_Gudang.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Gudang_model->log_Gudang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Gudang_model->simpan_data_by_admin($NAMA_PROYEK, $PEGAWAI_LOG_GUDANG, $NAMA_GUDANG, $LOKASI_GUDANG);
				} else {
					echo 'Nama Gudang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_PEGAWAI_LOG_GUDANG', 'Nama Pegawai Logistik Gudang', 'trim|required');
			$this->form_validation->set_rules('NAMA_GUDANG', 'Nama Gudang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI_GUDANG', 'Lokasi Gudang', 'trim|required|max_length[100]');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_PEGAWAI_LOG_GUDANG = $this->input->post('ID_PEGAWAI_LOG_GUDANG');
				$NAMA_GUDANG = $this->input->post('NAMA_GUDANG');
				$LOKASI_GUDANG = $this->input->post('LOKASI_GUDANG');

				//check apakah nama Gudang sudah ada. jika belum ada, akan disimpan.
				if ($this->Gudang_model->cek_nama_gudang_by_admin($NAMA_GUDANG) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan Gudang: " . $NAMA_GUDANG . ", LOKASI_GUDANG: " . $LOKASI_GUDANG . "ID_PROYEK: " . $ID_PROYEK . ", ID_PEGAWAI_LOG_GUDANG: " . $ID_PEGAWAI_LOG_GUDANG;
					$this->user_log($KETERANGAN);

					$data = $this->Gudang_model->simpan_data_by_admin($ID_PROYEK, $ID_PEGAWAI_LOG_GUDANG, $NAMA_GUDANG, $LOKASI_GUDANG);

					$data_2 = $this->Gudang_model->set_md5_ID_GUDANG($ID_PROYEK, $ID_PEGAWAI_LOG_GUDANG, $NAMA_GUDANG, $LOKASI_GUDANG);
				} else {
					echo 'Nama Gudang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_PEGAWAI_LOG_GUDANG', 'Nama Pegawai Logistik Gudang', 'trim|required');
			$this->form_validation->set_rules('NAMA_GUDANG', 'Nama Gudang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI_GUDANG', 'Lokasi Gudang', 'trim|required|max_length[100]');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_PEGAWAI_LOG_GUDANG = $this->input->post('ID_PEGAWAI_LOG_GUDANG');
				$NAMA_GUDANG = $this->input->post('NAMA_GUDANG');
				$LOKASI_GUDANG = $this->input->post('LOKASI_GUDANG');

				//check apakah nama Gudang sudah ada. jika belum ada, akan disimpan.
				if ($this->Gudang_model->cek_nama_gudang_by_admin($NAMA_GUDANG) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan Gudang: " . $NAMA_GUDANG . ", LOKASI_GUDANG: " . $LOKASI_GUDANG . "ID_PROYEK: " . $ID_PROYEK . ", ID_PEGAWAI_LOG_GUDANG: " . $ID_PEGAWAI_LOG_GUDANG;
					$this->user_log($KETERANGAN);

					$data = $this->Gudang_model->simpan_data_by_admin($ID_PROYEK, $ID_PEGAWAI_LOG_GUDANG, $NAMA_GUDANG, $LOKASI_GUDANG);

					$data_2 = $this->Gudang_model->set_md5_ID_GUDANG($ID_PROYEK, $ID_PEGAWAI_LOG_GUDANG, $NAMA_GUDANG, $LOKASI_GUDANG);
				} else {
					echo 'Nama Gudang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_PROYEK', 'Nama Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_PEGAWAI_LOG_GUDANG', 'Nama Pegawai Logistik Gudang', 'trim|required');
			$this->form_validation->set_rules('NAMA_GUDANG', 'Nama Gudang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI_GUDANG', 'Lokasi Gudang', 'trim|required|max_length[100]');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_PEGAWAI_LOG_GUDANG = $this->input->post('ID_PEGAWAI_LOG_GUDANG');
				$NAMA_GUDANG = $this->input->post('NAMA_GUDANG');
				$LOKASI_GUDANG = $this->input->post('LOKASI_GUDANG');

				//check apakah nama Gudang sudah ada. jika belum ada, akan disimpan.
				if ($this->Gudang_model->cek_nama_gudang_by_admin($NAMA_GUDANG) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan Gudang: " . $NAMA_GUDANG . ", LOKASI_GUDANG: " . $LOKASI_GUDANG . "ID_PROYEK: " . $ID_PROYEK . ", ID_PEGAWAI_LOG_GUDANG: " . $ID_PEGAWAI_LOG_GUDANG;
					$this->user_log($KETERANGAN);

					$data = $this->Gudang_model->simpan_data_by_admin($ID_PROYEK, $ID_PEGAWAI_LOG_GUDANG, $NAMA_GUDANG, $LOKASI_GUDANG);

					$data_2 = $this->Gudang_model->set_md5_ID_GUDANG($ID_PROYEK, $ID_PEGAWAI_LOG_GUDANG, $NAMA_GUDANG, $LOKASI_GUDANG);
				} else {
					echo 'Nama Gudang sudah terekam sebelumnya';
				}
			}
		} else {
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
			$this->form_validation->set_rules('PEGAWAI_LOG_GUDANG2', 'Nama Pegawai Logistik Gudang', 'trim|required');
			$this->form_validation->set_rules('NAMA_GUDANG2', 'Nama Gudang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI_GUDANG2', 'Lokasi Gudang', 'trim|required|max_length[100]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_GUDANG2 = $this->input->post('ID_GUDANG2');
				$PEGAWAI_LOG_GUDANG2 = $this->input->post('PEGAWAI_LOG_GUDANG2');
				$NAMA_GUDANG2 = $this->input->post('NAMA_GUDANG2');
				$LOKASI_GUDANG2 = $this->input->post('LOKASI_GUDANG2');

				//cek apakah input sama dengan eksisting
				$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG2);

				if ($data['NAMA_GUDANG'] == $NAMA_GUDANG2 || ($this->Gudang_model->cek_nama_gudang_by_admin($NAMA_GUDANG2) == 'Data belum ada')) {
					$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG2);

					//log
					// $KETERANGAN = "Ubah Gudang ".$data['NAMA_Gudang']." jadi ".$nama_Gudang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Gudang_model->log_Gudang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Gudang_model->update_data($ID_GUDANG2, $PEGAWAI_LOG_GUDANG2, $NAMA_GUDANG2, $LOKASI_GUDANG2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Gudang sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_PEGAWAI_LOG_GUDANG_2', 'Nama Pegawai Logistik Gudang', 'trim|required');
			$this->form_validation->set_rules('NAMA_GUDANG_2', 'Nama Gudang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI_GUDANG_2', 'Lokasi Gudang', 'trim|required|max_length[100]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_GUDANG_2 = $this->input->post('ID_GUDANG_2');
				$ID_PEGAWAI_LOG_GUDANG_2 = $this->input->post('ID_PEGAWAI_LOG_GUDANG_2');
				$NAMA_GUDANG_2 = $this->input->post('NAMA_GUDANG_2');
				$LOKASI_GUDANG_2 = $this->input->post('LOKASI_GUDANG_2');

				//cek apakah input sama dengan eksisting
				$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG_2);

				if ($data['NAMA_GUDANG'] == $NAMA_GUDANG_2 || ($this->Gudang_model->cek_nama_gudang_by_admin($NAMA_GUDANG_2) == 'Data belum ada')) {
					$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG_2);

					//log
					// $KETERANGAN = "Ubah Gudang ".$data['NAMA_GUDANG']." jadi ".$NAMA_GUDANG_2.", ket ".$data['LOKASI_GUDANG']." jadi ".$LOKASI_GUDANG_2.", ket ".$data['ID_PEGAWAI_LOG_GUDANG']." jadi ".$ID_PEGAWAI_LOG_GUDANG_2;
					// $this->user_log($KETERANGAN); ERROR DI ID_PEGAWAI_LOG_GUDANG, CEK KE MODEL

					$data = $this->Gudang_model->update_data($ID_GUDANG_2, $ID_PEGAWAI_LOG_GUDANG_2, $NAMA_GUDANG_2, $LOKASI_GUDANG_2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Gudang sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_PEGAWAI_LOG_GUDANG_2', 'Nama Pegawai Logistik Gudang', 'trim|required');
			$this->form_validation->set_rules('NAMA_GUDANG_2', 'Nama Gudang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI_GUDANG_2', 'Lokasi Gudang', 'trim|required|max_length[100]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_GUDANG_2 = $this->input->post('ID_GUDANG_2');
				$ID_PEGAWAI_LOG_GUDANG_2 = $this->input->post('ID_PEGAWAI_LOG_GUDANG_2');
				$NAMA_GUDANG_2 = $this->input->post('NAMA_GUDANG_2');
				$LOKASI_GUDANG_2 = $this->input->post('LOKASI_GUDANG_2');

				//cek apakah input sama dengan eksisting
				$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG_2);

				if ($data['NAMA_GUDANG'] == $NAMA_GUDANG_2 || ($this->Gudang_model->cek_nama_gudang_by_admin($NAMA_GUDANG_2) == 'Data belum ada')) {
					$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG_2);

					//log
					// $KETERANGAN = "Ubah Gudang ".$data['NAMA_GUDANG']." jadi ".$NAMA_GUDANG_2.", ket ".$data['LOKASI_GUDANG']." jadi ".$LOKASI_GUDANG_2.", ket ".$data['ID_PEGAWAI_LOG_GUDANG']." jadi ".$ID_PEGAWAI_LOG_GUDANG_2;
					// $this->user_log($KETERANGAN); ERROR DI ID_PEGAWAI_LOG_GUDANG, CEK KE MODEL

					$data = $this->Gudang_model->update_data($ID_GUDANG_2, $ID_PEGAWAI_LOG_GUDANG_2, $NAMA_GUDANG_2, $LOKASI_GUDANG_2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Gudang sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_PEGAWAI_LOG_GUDANG_2', 'Nama Pegawai Logistik Gudang', 'trim|required');
			$this->form_validation->set_rules('NAMA_GUDANG_2', 'Nama Gudang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI_GUDANG_2', 'Lokasi Gudang', 'trim|required|max_length[100]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_GUDANG_2 = $this->input->post('ID_GUDANG_2');
				$ID_PEGAWAI_LOG_GUDANG_2 = $this->input->post('ID_PEGAWAI_LOG_GUDANG_2');
				$NAMA_GUDANG_2 = $this->input->post('NAMA_GUDANG_2');
				$LOKASI_GUDANG_2 = $this->input->post('LOKASI_GUDANG_2');

				//cek apakah input sama dengan eksisting
				$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG_2);

				if ($data['NAMA_GUDANG'] == $NAMA_GUDANG_2 || ($this->Gudang_model->cek_nama_gudang_by_admin($NAMA_GUDANG_2) == 'Data belum ada')) {
					$data = $this->Gudang_model->get_data_by_id_gudang($ID_GUDANG_2);

					//log
					// $KETERANGAN = "Ubah Gudang ".$data['NAMA_GUDANG']." jadi ".$NAMA_GUDANG_2.", ket ".$data['LOKASI_GUDANG']." jadi ".$LOKASI_GUDANG_2.", ket ".$data['ID_PEGAWAI_LOG_GUDANG']." jadi ".$ID_PEGAWAI_LOG_GUDANG_2;
					// $this->user_log($KETERANGAN); ERROR DI ID_PEGAWAI_LOG_GUDANG, CEK KE MODEL

					$data = $this->Gudang_model->update_data($ID_GUDANG_2, $ID_PEGAWAI_LOG_GUDANG_2, $NAMA_GUDANG_2, $LOKASI_GUDANG_2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Gudang sudah terekam sebelumnya');
				}
			}
		} else {
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
