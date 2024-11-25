<?php defined('BASEPATH') or exit('No direct script access allowed');

class Donatur_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation','excel'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SiPESUT | Form Donatur';

		$this->load->model('FPB_form_model');
		$this->load->model('SPPB_form_model');
		$this->load->model('Donatur_form_model');
		$this->load->model('Donatur_model');
		$this->load->model('SPPB_model');
		$this->load->model('Proyek_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('Klasifikasi_barang_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('SPPB_Form_File_Model');
		$this->load->model('RAB_form_model');
		$this->load->model('RASD_form_model');
		$this->load->model('RASD_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "sppb_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses SPPB";
		$WAKTU = date('Y-m-d H:i:s');
		$this->SPPB_form_model->user_log_sppb_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN) //102023
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->SPPB_form_model->user_log_sppb_form($user->ID_PEGAWAI, $ID_SPPB_FORM, $KETERANGAN, $WAKTU);
	}

	public function user_log_sppb($ID_SPPB, $KETERANGAN) //102023
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->SPPB_model->user_log_sppb($user->ID_PEGAWAI, $ID_SPPB, $KETERANGAN, $WAKTU);
    }

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index() //BEDA KP DAN SP
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
		$this->data['NIK'] = $user->NIK;
		date_default_timezone_set('Asia/Jakarta');
		$this->data['last_login'] = date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		// $ID_SPPB = 0;
        // $KETERANGAN = "Melihat Halaman Index SPPB Form: ";
        // $this->user_log_sppb($ID_SPPB, $KETERANGAN);

		$CODE_MD5 = $this->uri->segment(3);
		// if ($this->Pengajuan_model->get_id_pengajuan_by_CODE_MD5($CODE_MD5) == 'TIDAK ADA DATA') {
		// 	redirect('Pengajuan', 'refresh');
		// }

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) { //User donatur
			$hasil_2 = $this->Donatur_model->get_data_donatur_by_CODE_MD5($CODE_MD5);
			$PROGRESS_PENGAJUAN = $hasil_2['PROGRESS_PENGAJUAN'];

			// $sess_data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			// $this->session->set_userdata($sess_data);

			if ($PROGRESS_PENGAJUAN == "Diproses oleh Staff BPBD") {
				$hasil = $this->Donatur_model->get_data_donatur_by_CODE_MD5($CODE_MD5);
				$ID_FORM_INVENTARIS_BANTUAN_DONASI = $hasil['ID_FORM_INVENTARIS_BANTUAN_DONASI'];
				$Nomor_Surat_Form_Inventaris = $hasil['Nomor_Surat_Form_Inventaris'];
				$this->data['CODE_MD5'] = $CODE_MD5;
				$this->data['ID_FORM_INVENTARIS_BANTUAN_DONASI'] = $ID_FORM_INVENTARIS_BANTUAN_DONASI;
				$this->data['Nomor_Surat_Form_Inventaris'] = $Nomor_Surat_Form_Inventaris;

				// $this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['Donatur'] = $this->Donatur_model->donatur_list_by_id_donatur($ID_FORM_INVENTARIS_BANTUAN_DONASI);
				// $this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				
				// $this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
				// $this->data['RAB_list'] = $this->RAB_form_model->rab_list_by_id_proyek_sub_pekerjaan($this->data['ID_PROYEK_SUB_PEKERJAAN']);

				$this->load->view('wasa/user_donatur/head_normal', $this->data);
				$this->load->view('wasa/user_donatur/user_menu');
				$this->load->view('wasa/user_donatur/left_menu');
				$this->load->view('wasa/user_donatur/header_menu');
				$this->load->view('wasa/user_donatur/content_donatur_form_proses');
				// $this->load->view('wasa/user_korban_bencana/footer');
			} else {
				redirect('Donatur', 'refresh');
			}
		
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	public function telusur() //BEDA KP DAN SP //102023
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
		$this->data['last_login'] = date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$ID_SPPB = 0;
        $KETERANGAN = "Melihat Halaman Telusur SPPB: ";
        $this->user_log_sppb($ID_SPPB, $KETERANGAN);

		$HASH_MD5_SPPB = $this->uri->segment(3);
		if ($this->SPPB_model->get_id_proyek_by_HASH_MD5_SPPB($HASH_MD5_SPPB) == 'TIDAK ADA DATA') {
			redirect('SPPB', 'refresh');
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];

			$sess_data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			$this->session->set_userdata($sess_data);

			$HASH_MD5_SPPB = $this->uri->segment(3);
			$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$ID_SPPB = $hasil['ID_SPPB'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $hasil['ID_PROYEK_SUB_PEKERJAAN'];
			$this->data['NO_URUT_SPPB'] = $hasil['NO_URUT_SPPB'];
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
			$this->data['RAB_list'] = $this->RAB_form_model->rab_list_by_id_proyek_sub_pekerjaan($this->data['ID_PROYEK_SUB_PEKERJAAN']);

			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_sppb_form_telusur');
			$this->load->view('wasa/user_admin/footer');


		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) { //STAFF PROC KP
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];

			$sess_data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			$this->session->set_userdata($sess_data);

			$HASH_MD5_SPPB = $this->uri->segment(3);
			$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$ID_SPPB = $hasil['ID_SPPB'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $hasil['ID_PROYEK_SUB_PEKERJAAN'];
			$this->data['NO_URUT_SPPB'] = $hasil['NO_URUT_SPPB'];
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
			$this->data['RAB_list'] = $this->RAB_form_model->rab_list_by_id_proyek_sub_pekerjaan($this->data['ID_PROYEK_SUB_PEKERJAAN']);

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_sppb_form_telusur');
			$this->load->view('wasa/user_staff_procurement_kp/footer');

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) { //STAFF PROC SP
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];

			$sess_data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			$this->session->set_userdata($sess_data);

			$HASH_MD5_SPPB = $this->uri->segment(3);
			$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$ID_SPPB = $hasil['ID_SPPB'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $hasil['ID_PROYEK_SUB_PEKERJAAN'];
			$this->data['NO_URUT_SPPB'] = $hasil['NO_URUT_SPPB'];
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
			$this->data['RAB_list'] = $this->RAB_form_model->rab_list_by_id_proyek_sub_pekerjaan($this->data['ID_PROYEK_SUB_PEKERJAAN']);

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_sppb_form_telusur');
			$this->load->view('wasa/user_staff_procurement_sp/footer');

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) { //SUPERVISI PROC SP
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];

			$sess_data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			$this->session->set_userdata($sess_data);

			$HASH_MD5_SPPB = $this->uri->segment(3);
			$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$ID_SPPB = $hasil['ID_SPPB'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $hasil['ID_PROYEK_SUB_PEKERJAAN'];
			$this->data['NO_URUT_SPPB'] = $hasil['NO_URUT_SPPB'];
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
			$this->data['RAB_list'] = $this->RAB_form_model->rab_list_by_id_proyek_sub_pekerjaan($this->data['ID_PROYEK_SUB_PEKERJAAN']);

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_sppb_form_telusur');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');

		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	// public function approval()
	// {
	// 	//jika mereka belum login
	// 	if (!$this->ion_auth->logged_in()) {
	// 		// alihkan mereka ke halaman login
	// 		redirect('auth/login', 'refresh');
	// 	}

	// 	//get data tabel users untuk ditampilkan
	// 	$user = $this->ion_auth->user()->row();
	// 	$this->data['user_id'] = $user->id;
	// 	$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
	// 	$this->data['role_user'] = $data_role_user['description'];
	// 	$this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
	// 	$this->data['ip_address'] = $user->ip_address;
	// 	$this->data['email'] = $user->email;
	// 	$this->data['user_id'] = $user->id;
	// 	date_default_timezone_set('Asia/Jakarta');
	// 	$this->data['last_login'] = date('d-m-Y H:i:s', $user->last_login);
	// 	$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	// 	$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

	// 	$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
	// 	if ($query_foto_user == "BELUM ADA FOTO") {
	// 		$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
	// 	} else {
	// 		$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
	// 	}

	// 	$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	if ($this->SPPB_model->get_id_proyek_by_HASH_MD5_SPPB($HASH_MD5_SPPB) == 'TIDAK ADA DATA') {
	// 		redirect('SPPB', 'refresh');
	// 	}

	// 	// //jika mereka sudah login dan sebagai admin
	// 	// if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_pm_sp/user_menu');
	// 	// 		$this->load->view('wasa/user_pm_sp/left_menu');
	// 	// 		$this->load->view('wasa/user_pm_sp/header_menu');
	// 	// 		$this->load->view('wasa/user_pm_sp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_pm_sp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['fpb_barang_list'] = $this->SPPB_form_model->fpb_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_manajer_logistik_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_manajer_logistik_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_manajer_hrd_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_manajer_hrd_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_manajer_hrd_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_manajer_hrd_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_manajer_hrd_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_manajer_hrd_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_manajer_keuangan_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_manajer_keuangan_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_manajer_keuangan_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_manajer_keuangan_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_manajer_keuangan_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_manajer_keuangan_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_manajer_konstruksi_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_manajer_konstruksi_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_manajer_konstruksi_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_manajer_konstruksi_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_manajer_konstruksi_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_manajer_konstruksi_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_manajer_sdm_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_manajer_sdm_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_manajer_sdm_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_manajer_sdm_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_manajer_sdm_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_manajer_sdm_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_manajer_qaqc_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_manajer_qaqc_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_manajer_qaqc_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_manajer_qaqc_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_manajer_qaqc_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_manajer_qaqc_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_manajer_ep_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_manajer_ep_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_manajer_ep_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_manajer_ep_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_manajer_ep_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_manajer_ep_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Direksi") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_direktur_keuangan_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_direktur_keuangan_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_direktur_keuangan_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_direktur_keuangan_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_direktur_keuangan_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_direktur_keuangan_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Direksi") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_direktur_psds_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_direktur_psds_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_direktur_psds_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_direktur_psds_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_direktur_psds_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_direktur_psds_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Direksi") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_direktur_konstruksi_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_direktur_konstruksi_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_direktur_konstruksi_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_direktur_konstruksi_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_direktur_konstruksi_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_direktur_konstruksi_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_manajer_hsse_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_manajer_hsse_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_manajer_hsse_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_manajer_hsse_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_manajer_hsse_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_manajer_hsse_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_manajer_marketing_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_manajer_marketing_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_manajer_marketing_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_manajer_marketing_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_manajer_marketing_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_manajer_marketing_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {
	// 	// 	$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 	$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
	// 	// 	if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
	// 	// 		$HASH_MD5_SPPB = $this->uri->segment(3);
	// 	// 		$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
	// 	// 		$ID_SPPB = $hasil['ID_SPPB'];
	// 	// 		$this->data['ID_SPPB'] = $ID_SPPB;
	// 	// 		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 	// 		$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

	// 	// 		$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
	// 	// 		$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
	// 	// 		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 	// 		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 	// 		$this->load->view('wasa/user_manajer_komersial_kp/head_normal', $this->data);
	// 	// 		$this->load->view('wasa/user_manajer_komersial_kp/user_menu');
	// 	// 		$this->load->view('wasa/user_manajer_komersial_kp/left_menu');
	// 	// 		$this->load->view('wasa/user_manajer_komersial_kp/header_menu');
	// 	// 		$this->load->view('wasa/user_manajer_komersial_kp/content_sppb_form_proses_approval');
	// 	// 		$this->load->view('wasa/user_manajer_komersial_kp/footer');
	// 	// 	} else {
	// 	// 		redirect('SPPB', 'refresh');
	// 	// 	}
	// 	// } else {
	// 	// 	$this->logout();
	// 	// }
	// }

	function data_grup_rab_sppb_form() //102023
	{
		if ($this->ion_auth->logged_in()) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->data_grup_rab_sppb_form($id);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_barang_bantuan_form() //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_FORM_INVENTARIS_BANTUAN_DONASI = $this->input->post('ID_FORM_INVENTARIS_BANTUAN_DONASI');
			$data = $this->Donatur_form_model->data_barang_bantuan_form($ID_FORM_INVENTARIS_BANTUAN_DONASI);
			echo json_encode($data);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_spp_form_by_id_sppb_form() //TELUSUR //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
			$data = $this->SPPB_form_model->data_spp_form_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "TELUSUR Melihat Data SPP Form: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_spp_by_id_spp() //TELUSUR //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPP = $this->input->post('ID_SPP');
			$data = $this->SPPB_form_model->data_spp_by_id_spp($ID_SPP);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "TELUSUR Melihat Data SPP: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_po_form_by_id_sppb_form() //TELUSUR //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
			$data = $this->SPPB_form_model->data_po_form_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "TELUSUR Melihat Data PO Form: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_po_by_id_po() //TELUSUR //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_PO = $this->input->post('ID_PO');
			$data = $this->SPPB_form_model->data_po_by_id_po($ID_PO);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "TELUSUR Melihat Data PO: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_fstb_form_by_id_sppb_form() //TELUSUR //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
			$data = $this->SPPB_form_model->data_fstb_form_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "TELUSUR Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_fstb_by_id_fstb() //TELUSUR //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_FSTB = $this->input->post('ID_FSTB');
			$data = $this->SPPB_form_model->data_fstb_by_id_fstb($ID_FSTB);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "TELUSUR Melihat Data FSTB: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_sppb_form_kirim_sppb() //102023
	{
		if ($this->ion_auth->logged_in()) {

			$ID_SPPB = $this->input->get('ID_SPPB');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb_kirim_SPPB($ID_SPPB);
			echo json_encode($data);

			$ID_SPPB = $ID_SPPB;
			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log_sppb($ID_SPPB, $KETERANGAN);

		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_sppb_form_file() //102023
	{
		if ($this->ion_auth->logged_in()) {

			$ID_SPPB = $this->input->get('ID_SPPB');
			$data = $this->SPPB_form_model->sppb_form_file_list_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$ID_SPPB = $ID_SPPB;
			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log_sppb($ID_SPPB, $KETERANGAN);

		}else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_qty_rasd() //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$data = $this->SPPB_form_model->data_quantity_rasd_by_ID_RASD_FORM($ID_RASD_FORM);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_qty_rasd_realisasi() //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$data = $this->SPPB_form_model->data_quantity_rasd_realisasi_by_ID_RASD_FORM($ID_RASD_FORM);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "Melihat Data Quantity Realisasi RASD: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	// function data_qty_entitas() //102023
	// {
	// 	if ($this->ion_auth->logged_in()) {
	// 		$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
	// 		$ID_PROYEK = $this->input->post('ID_PROYEK');
	// 		$data = $this->SPPB_form_model->data_quantity_barang_entitas_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_PROYEK);
	// 		echo json_encode($data);

	// 		$ID_SPPB_FORM = 0;
	// 		$KETERANGAN = "Melihat Data Quantity: " . json_encode($data);
	// 		$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
	// 	} else {
	// 		$this->logout();
	// 		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	// 	}
	// }

	// function data_qty_consum_material() //102023
	// {
	// 	if ($this->ion_auth->logged_in()) {
	// 		$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
	// 		$ID_PROYEK = $this->input->post('ID_PROYEK');
	// 		$data = $this->SPPB_form_model->data_quantity_barang_entitas_consum_material_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_PROYEK);
	// 		echo json_encode($data);

	// 		$ID_SPPB_FORM = 0;
	// 		$KETERANGAN = "Melihat Data Quantity Consum Material: " . json_encode($data);
	// 		$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
	// 	} else {
	// 		$this->logout();
	// 		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	// 	}
	// }

	function get_data() //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_ITEM_FORM_BANTUAN_DONASI = $this->input->get('ID_ITEM_FORM_BANTUAN_DONASI');
			$data = $this->Donatur_form_model->get_data_by_id_item_form_bantuan_donasi($ID_ITEM_FORM_BANTUAN_DONASI);
			echo json_encode($data);

			// $ID_SPPB_FORM = $ID_SPPB_FORM ;
			// $KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			// $this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_data_id_rab_form_by_id_rab() //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RAB = $this->input->post('ID_RAB');
			$data = $this->SPPB_model->get_data_id_rab_form_by_id_rab($ID_RAB);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "Get Data ID RAB FORM: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_data_id_rab_by_id_proyek() //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_PROYEK = $this->input->post('ID_PROYEK');
			$ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
			$data = $this->SPPB_model->get_data_id_rab_by_id_proyek($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "Get Data ID RAB: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_data_id_rasd_by_id_rab_form()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$data = $this->SPPB_model->get_data_id_rasd_by_id_rab_form($ID_RAB_FORM);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "Get Data ID RASD: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_data_id_rasd_form_by_id_rasd()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->SPPB_form_model->get_data_id_rasd_form_by_id_rasd($ID_RASD);
			echo json_encode($data);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "Get Data ID RASD: " . json_encode($data);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_ITEM_FORM_BANTUAN_DONASI = $this->input->post('kode');
			$data = $this->Donatur_form_model->hapus_data_by_id_item_form_bantuan_donasi($ID_ITEM_FORM_BANTUAN_DONASI);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}


	function hapus_data_semua()
	{
		if ($this->ion_auth->logged_in()) {
			$HASH_MD5_SPPB = $this->input->post('kode');
			$data_hapus = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

			$ID_SPPB_FORM = 0;
			$KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

			$ID_SPPB = $data_hapus['ID_SPPB'];

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb($ID_SPPB);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}

	function simpan_identitas_form()
	{
		if ($this->ion_auth->logged_in()) {

			//set validation rules
			$this->form_validation->set_rules('NO_URUT_SPPB_GANTI', 'No. SPBB', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_DOKUMEN_SPPB', 'Tanggal Dokumen SPPB', 'trim|required');
			$this->form_validation->set_rules('CTT_DEPT_PROC', 'Catatan Dokumen SPPB', 'trim|required');
			$this->form_validation->set_rules('SUB_PROYEK', 'Sub Proyek', 'trim');

			$NO_URUT_SPPB_GANTI = $this->input->post('NO_URUT_SPPB_GANTI');
			$NO_URUT_SPPB_ASLI = $this->input->post('NO_URUT_SPPB_ASLI');
			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo validation_errors();
			} else {

				if($NO_URUT_SPPB_GANTI==$NO_URUT_SPPB_ASLI)
				{
					//get the form data
					$ID_SPPB = $this->input->post('ID_SPPB');
					$CTT_DEPT_PROC = $this->input->post('CTT_DEPT_PROC');
					$SUB_PROYEK = $this->input->post('SUB_PROYEK');
					$TANGGAL_DOKUMEN_SPPB = $this->input->post('TANGGAL_DOKUMEN_SPPB');

					// $KETERANGAN = "Ubah Data Tanggal Dan Bidang Pemakai Semua Item Barang/Jasa di SPPB : " . $ID_SPPB . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI . ";";
					// $this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

					$data = $this->SPPB_form_model->simpan_identitas_form($ID_SPPB, $NO_URUT_SPPB_ASLI, $CTT_DEPT_PROC, $SUB_PROYEK, $TANGGAL_DOKUMEN_SPPB);
					echo json_encode($data);

				}

				else
				{
					if ($this->SPPB_model->cek_no_urut_sppb($NO_URUT_SPPB_GANTI) == 'Data belum ada') {

						//get the form data
						$ID_SPPB = $this->input->post('ID_SPPB');
						$CTT_DEPT_PROC = $this->input->post('CTT_DEPT_PROC');
						$SUB_PROYEK = $this->input->post('SUB_PROYEK');
						$TANGGAL_DOKUMEN_SPPB = $this->input->post('TANGGAL_DOKUMEN_SPPB');
	
						// $KETERANGAN = "Ubah Data Tanggal Dan Bidang Pemakai Semua Item Barang/Jasa di SPPB : " . $ID_SPPB . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI . ";";
						// $this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
	
						$data = $this->SPPB_form_model->simpan_identitas_form($ID_SPPB, $NO_URUT_SPPB_GANTI, $CTT_DEPT_PROC, $SUB_PROYEK, $TANGGAL_DOKUMEN_SPPB);
						echo json_encode($data);
					
					} else {
						echo 'Nomor Urut SPPB sudah terekam sebelumnya';
					}

				}

				
				
			}
		} else {
			$this->logout();
		}
	}

	function simpan_data_barang_bantuan()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_FORM_INVENTARIS_BANTUAN_DONASI = $this->input->post('ID_FORM_INVENTARIS_BANTUAN_DONASI');
		
			//set validation rules
			$this->form_validation->set_rules('JENIS_BANTUAN', 'Jenis Bantuan', 'trim|required');
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|max_length[100]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|required|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('JENIS_BANTUAN', 'Jenis Bantuan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|max_length[300]');
			
			// run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo validation_errors();
			}
			else {
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$KLASIFIKASI_BARANG = $this->input->post('KLASIFIKASI_BARANG');
				$JENIS_BANTUAN = $this->input->post('JENIS_BANTUAN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				
				$data = $this->Donatur_form_model->simpan_data_barang_bantuan(
					$ID_FORM_INVENTARIS_BANTUAN_DONASI,
					$NAMA,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$JUMLAH_BARANG,
					$SATUAN_BARANG,
					$KLASIFIKASI_BARANG,
					$JENIS_BANTUAN,
					$KETERANGAN
				);
				
			}
			
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in()) {
			
			$ID_ITEM_FORM_BANTUAN_DONASI = $this->input->post('ID_ITEM_FORM_BANTUAN_DONASI');

			//set validation rules
			$this->form_validation->set_rules('JENIS_BANTUAN', 'Jenis Bantuan', 'trim|required');
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|max_length[100]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|required|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('JENIS_BANTUAN', 'Jenis Bantuan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|max_length[300]');


			// run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo validation_errors();
			} else {
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JENIS_BANTUAN = $this->input->post('JENIS_BANTUAN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				
				$data = $this->Donatur_form_model->update_data_barang_bantuan(
					$ID_ITEM_FORM_BANTUAN_DONASI,
					$NAMA,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$JUMLAH_BARANG,
					$SATUAN_BARANG,
					$JENIS_BANTUAN,
					$KETERANGAN
				);
				// echo json_encode($data);
			}
		
		
		} else {
			$this->logout();
		}
	}

	function update_status_id_sppb_form()
	{
		if ($this->ion_auth->logged_in()) {
			
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

			$data = $this->SPPB_form_model->update_status_id_sppb_form(
				$ID_SPPB_FORM
			);
			echo json_encode($data);
			
		} else {
			$this->logout();
		}
	}

	function update_progress()
	{
		if ($this->ion_auth->logged_in()) {
			
			$ID_SPPB = $this->input->post('ID_SPPB');
			$PROGRESS_SPPB = $this->input->post('PROGRESS_SPPB');

			$data = $this->SPPB_form_model->update_progress_id_sppb(
				$ID_SPPB, $PROGRESS_SPPB
			);
			echo json_encode($data);
			
		} else {
			$this->logout();
		}
	}

	// function update_status_sppb_complete()
	// {
	// 	if ($this->ion_auth->logged_in()) {
			
	// 		$ID_SPPB = $this->input->post('ID_SPPB');

	// 		$data = $this->SPPB_form_model->update_status_sppb_complete(
	// 			$ID_SPPB
	// 		);
	// 		echo json_encode($data);
			
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	function update_data_kirim_sppb_pembelian()//BEDA KP DAN SP
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "SPPB Pembelian SELESAI" . " ---- " . $ID_SPPB;
				$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

				$PROGRESS_SPPB = "SPPB Pembelian Disetujui";
				$STATUS_SPPB = "SELESAI";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "SPPB Pembelian SELESAI" . " ---- " . $ID_SPPB;
				$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

				$PROGRESS_SPPB = "SPPB Pembelian Disetujui";
				$STATUS_SPPB = "SELESAI";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "SPPB Pembelian SELESAI" . " ---- " . $ID_SPPB;
				$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

				$PROGRESS_SPPB = "SPPB Pembelian Disetujui";
				$STATUS_SPPB = "SELESAI";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "SPPB Pembelian SELESAI" . " ---- " . $ID_SPPB;
				$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

				$PROGRESS_SPPB = "SPPB Pembelian Disetujui";
				$STATUS_SPPB = "SELESAI";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}

		} else {
			$this->logout();
		}
	}

	// function update_data_coret()
	// {
	// 	$user = $this->ion_auth->user()->row();
	// 	$user_id = $user->id;
	// 	$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($user_id);
	// 	$NAMA = $data_role_user['NAMA'];

	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

	// 		// //set validation rules
	// 		// $this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

	// 		// //run validation check
	// 		// if ($this->form_validation->run() == FALSE) {   //validation fails
	// 		// 	echo json_encode(validation_errors());
	// 		// } else {
	// 		// 	//get the form data
	// 		// 	$ID_SPPB = $this->input->post('ID_SPPB');

	// 		// 	$KETERANGAN = "Kirim Form SPPB ke Chief (User Staff logistik): "." ---- " . $ID_SPPB;
	// 		// 	$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 		// 	$PROGRESS_SPPB = "Dalam Proses Chief";
	// 		// 	$STATUS_SPPB = "Proses pengajuan";

	// 		// 	$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
	// 		// 	echo json_encode($data);
	// 		// }
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Chief): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User SM): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');
	// 			$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
	// 			$ID_SPPB = $this->input->post('ID_SPPB');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User PM): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);

	// 			//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
	// 			$this->FPB_form_model->update_coret_status_sppb_by_id_fpb_form($ID_FPB_FORM, $ID_SPPB);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Staff Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Kasie Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Staff Umum Logistik SP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Supervisi Logistik SP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer HRD KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');
	// 			$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
	// 			$ID_SPPB = $this->input->post('ID_SPPB');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
	// 			$this->FPB_form_model->update_coret_status_sppb_by_id_fpb_form($ID_FPB_FORM, $ID_SPPB);

	// 			$KETERANGAN = "Tolak Barang (User Manajer Keuangan KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer Konstruksi KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer SDM KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer QAQC KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer PE KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Direktur Keuangan KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Direktur PSDS): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Direktur EP dan Konstruksi KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer HSSE KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Staff Gudang Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer Marketing KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer Komersial KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	// function update_data_batal_coret()
	// {
	// 	$user = $this->ion_auth->user()->row();
	// 	$user_id = $user->id;
	// 	$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($user_id);
	// 	$NAMA = $data_role_user['NAMA'];

	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

	// 		// //set validation rules
	// 		// $this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

	// 		// //run validation check
	// 		// if ($this->form_validation->run() == FALSE) {   //validation fails
	// 		// 	echo json_encode(validation_errors());
	// 		// } else {
	// 		// 	//get the form data
	// 		// 	$ID_SPPB = $this->input->post('ID_SPPB');

	// 		// 	$KETERANGAN = "Kirim Form SPPB ke Chief (User Staff logistik): "." ---- " . $ID_SPPB;
	// 		// 	$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 		// 	$PROGRESS_SPPB = "Dalam Proses Chief";
	// 		// 	$STATUS_SPPB = "Proses pengajuan";

	// 		// 	$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
	// 		// 	echo json_encode($data);
	// 		// }
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Chief): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User SM): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User PM): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Staff Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Kasie Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Staff Umum Logistik SP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Supervisi Logistik SP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer HRD KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Keuangan KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Konstruksi KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer SDM KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer QAQC KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer PE KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Direktur Keuangan KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Direktur PSDS): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Direktur EP dan Konstruksi KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer HSSE KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Staff Gudang Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Marketing KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPPB_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Komersial KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);

	// 			$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	//custom validation function to accept alphabets and space
	// function alpha_space_only($str)
	// {
	// 	if (!preg_match("/^[a-zA-Z ]+$/", $str)) {
	// 		$this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space');
	// 		return FALSE;
	// 	} else {
	// 		return TRUE;
	// 	}
	// }

	// TAMPILAN VIEW ONLY
	public function view()
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
		$this->data['last_login'] = date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');


		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_SPPB = $this->uri->segment(3);
		if ($this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB) == 'TIDAK ADA DATA') {
			redirect('SPPB', 'refresh');
		}

		if ($this->ion_auth->logged_in()) {

			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_SPPB = $this->uri->segment(3);

			if ($this->ion_auth->is_admin()) //staff_proc_kp
			{ 
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
				$sess_data['HASH_MD5_SPPB'] = $this->data['HASH_MD5_SPPB'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB):
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
					$this->data['STATUS_SPPB'] = $SPPB->STATUS_SPPB;
				endforeach;

				$query_file_HASH_MD5_SPPB = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

				if ($query_file_HASH_MD5_SPPB->num_rows() > 0) {

					$this->data['dokumen'] = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_SPPB_result($HASH_MD5_SPPB);

					$hasil = $query_file_HASH_MD5_SPPB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_sppb_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['JENIS_FILE'] = $JENIS_FILE;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_admin/head_normal', $this->data);
				$this->load->view('wasa/user_admin/user_menu');
				$this->load->view('wasa/user_admin/left_menu');
				$this->load->view('wasa/user_admin/header_menu');
				$this->load->view('wasa/user_admin/content_sppb_form');
				$this->load->view('wasa/user_admin/footer');

			} 
			else if ($this->ion_auth->in_group(5)) //staff_proc_kp
			{ 
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
				$sess_data['HASH_MD5_SPPB'] = $this->data['HASH_MD5_SPPB'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB):
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
					$this->data['STATUS_SPPB'] = $SPPB->STATUS_SPPB;
				endforeach;

				$query_file_HASH_MD5_SPPB = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

				if ($query_file_HASH_MD5_SPPB->num_rows() > 0) {

					$this->data['dokumen'] = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_SPPB_result($HASH_MD5_SPPB);

					$hasil = $query_file_HASH_MD5_SPPB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_sppb_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['JENIS_FILE'] = $JENIS_FILE;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_sppb_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');

			} 
			else if ($this->ion_auth->in_group(8)) //staff_proc_sp
			{ 
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
				$sess_data['HASH_MD5_SPPB'] = $this->data['HASH_MD5_SPPB'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB):
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
					$this->data['STATUS_SPPB'] = $SPPB->STATUS_SPPB;
				endforeach;

				$query_file_HASH_MD5_SPPB = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

				if ($query_file_HASH_MD5_SPPB->num_rows() > 0) {

					$this->data['dokumen'] = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_SPPB_result($HASH_MD5_SPPB);

					$hasil = $query_file_HASH_MD5_SPPB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_sppb_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['JENIS_FILE'] = $JENIS_FILE;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_sppb_form');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(9)) //supervisi_proc_sp
			{ 
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
				$sess_data['HASH_MD5_SPPB'] = $this->data['HASH_MD5_SPPB'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB):
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
					$this->data['STATUS_SPPB'] = $SPPB->STATUS_SPPB;
				endforeach;

				$query_file_HASH_MD5_SPPB = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

				if ($query_file_HASH_MD5_SPPB->num_rows() > 0) {

					$this->data['dokumen'] = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_SPPB_result($HASH_MD5_SPPB);

					$hasil = $query_file_HASH_MD5_SPPB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_sppb_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['JENIS_FILE'] = $JENIS_FILE;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_sppb_form');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else {
			$this->logout();
		}
	}
	
	function proses_upload_file()
	{

		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		$HASH_MD5_SPPB = $this->session->userdata('HASH_MD5_SPPB');

		//jika mereka sudah login
		if ($this->ion_auth->logged_in()) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_SPPB . '_';
			$config['upload_path'] = './assets/upload_sppb_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_sppb = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$ID_SPPB = $query_id_sppb['ID_SPPB'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_sppb_form_file/' . $nama;
				$this->db->insert('sppb_form_file', array('ID_SPPB' => $ID_SPPB, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_SPPB' => $HASH_MD5_SPPB, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else {
			// alihkan mereka ke halaman sppb list
			redirect('SPPB', 'refresh');
		}
	}

	function proses_upload_file_excel()
	{
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		$HASH_MD5_SPPB = $this->session->userdata('HASH_MD5_SPPB');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in()) {

				
			$WAKTU = date('Y-m-d H:i:s');
			$nama_file = "excel_" . $HASH_MD5_SPPB;
			$config['upload_path'] = './assets/upload_sppb_form_excel/';
			$config['allowed_types'] = 'xlsx';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_sppb = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$ID_SPPB = $query_id_sppb['ID_SPPB'];
			$ID_PROYEK_SUB_PEKERJAAN = $query_id_sppb['ID_PROYEK_SUB_PEKERJAAN'];

			if (file_exists($file = './assets/upload_sppb_form_excel/' .$nama_file.".xlsx")) {
				unlink($file);
			}

			if ($this->upload->do_upload('userfile')) {
				$JENIS_FILE = $this->input->post('JENIS_FILE');	

				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$path = $config['upload_path'].$nama_file.".xlsx";
				$object = PHPExcel_IOFactory::load($path);

				$ada_error = "tidak";
				foreach($object->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();	
					for($row=2; $row<=$highestRow; $row++)
					{
						$inserdata['NAMA_BARANG']= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						if(strstr($inserdata['NAMA_BARANG'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['NAMA_BARANG'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['NAMA_BARANG'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['MEREK'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						if(strstr($inserdata['MEREK'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['MEREK'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['MEREK'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['SPESIFIKASI_SINGKAT'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						if(strstr($inserdata['SPESIFIKASI_SINGKAT'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['SPESIFIKASI_SINGKAT'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['SPESIFIKASI_SINGKAT'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['JUMLAH_QTY_SPP'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						if(strstr($inserdata['JUMLAH_QTY_SPP'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['JUMLAH_QTY_SPP'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['JUMLAH_QTY_SPP'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['SATUAN_BARANG'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
						if(strstr($inserdata['SATUAN_BARANG'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['SATUAN_BARANG'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['SATUAN_BARANG'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['TANGGAL_MULAI_PAKAI_HARI'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
						if(strstr($inserdata['TANGGAL_MULAI_PAKAI_HARI'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['TANGGAL_MULAI_PAKAI_HARI'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['TANGGAL_MULAI_PAKAI_HARI'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['TANGGAL_SELESAI_PAKAI_HARI'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
						if(strstr($inserdata['TANGGAL_SELESAI_PAKAI_HARI'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['TANGGAL_SELESAI_PAKAI_HARI'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['TANGGAL_SELESAI_PAKAI_HARI'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['KETERANGAN_UMUM'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
						if(strstr($inserdata['KETERANGAN_UMUM'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['KETERANGAN_UMUM'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['KETERANGAN_UMUM'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['ID_RAB_FORM'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
						if(strstr($inserdata['ID_RAB_FORM'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['ID_RAB_FORM'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['ID_RAB_FORM'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['ID_KLASIFIKASI_BARANG'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
						if(strstr($inserdata['ID_KLASIFIKASI_BARANG'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['ID_KLASIFIKASI_BARANG'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['ID_KLASIFIKASI_BARANG'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

					}

					if($ada_error == "tidak")
					{
						for($row=2; $row<=$highestRow; $row++)
						{
							$inserdata['NAMA_BARANG']= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							$inserdata['MEREK'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
							$inserdata['SPESIFIKASI_SINGKAT'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
							$inserdata['JUMLAH_QTY_SPP'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
							$inserdata['SATUAN_BARANG'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
							$inserdata['TANGGAL_MULAI_PAKAI_HARI'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
							$inserdata['TANGGAL_SELESAI_PAKAI_HARI'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
							$inserdata['KETERANGAN_UMUM'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
							$inserdata['ID_RAB_FORM'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
							$inserdata['ID_KLASIFIKASI_BARANG'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

							$ID_RASD = $this->RASD_model->get_id_rasd_by_id_rab_form($inserdata['ID_RAB_FORM']);

							$hasil = $this->RASD_form_model->get_data_by_id_RASD_nama_spesifikasi($ID_RASD, $inserdata['NAMA_BARANG'], $inserdata['SPESIFIKASI_SINGKAT'] );
							
							//apakah barang ada di RAB/RASD ??
							if($hasil == "BELUM ADA RASD FORM")
							{

								$data = $this->RASD_form_model->simpan_data_dari_sppb_form_deviasi(
									$ID_RASD,
									$inserdata['SATUAN_BARANG'],
									$inserdata['NAMA_BARANG'],
									$inserdata['MEREK'],
									$inserdata['SPESIFIKASI_SINGKAT']
								);
		
								$ID_RASD_FORM = $this->RASD_form_model->get_data_id_rasd_form($ID_RASD, $inserdata['NAMA_BARANG'], $inserdata['SPESIFIKASI_SINGKAT']);

								$data = $this->SPPB_form_model->simpan_data_dari_excel_ada_rasd_form(
									$ID_SPPB,
									$inserdata['ID_RAB_FORM'],
									$ID_PROYEK_SUB_PEKERJAAN,
									$ID_RASD_FORM,
									$inserdata['ID_KLASIFIKASI_BARANG'],
									$inserdata['NAMA_BARANG'],
									$inserdata['MEREK'],
									$inserdata['SPESIFIKASI_SINGKAT'],
									$inserdata['JUMLAH_QTY_SPP'] ,
									$inserdata['SATUAN_BARANG'],
									$inserdata['TANGGAL_MULAI_PAKAI_HARI'],
									$inserdata['TANGGAL_SELESAI_PAKAI_HARI'],
									$inserdata['KETERANGAN_UMUM']
								);
		

							}
							else
							{
								$ID_RASD_FORM = $hasil['ID_RASD_FORM'];

								$data = $this->SPPB_form_model->simpan_data_dari_excel_ada_rasd_form(
									$ID_SPPB,
									$inserdata['ID_RAB_FORM'],
									$ID_PROYEK_SUB_PEKERJAAN,
									$ID_RASD_FORM,
									$inserdata['ID_KLASIFIKASI_BARANG'],
									$inserdata['NAMA_BARANG'],
									$inserdata['MEREK'],
									$inserdata['SPESIFIKASI_SINGKAT'],
									$inserdata['JUMLAH_QTY_SPP'] ,
									$inserdata['SATUAN_BARANG'],
									$inserdata['TANGGAL_MULAI_PAKAI_HARI'],
									$inserdata['TANGGAL_SELESAI_PAKAI_HARI'],
									$inserdata['KETERANGAN_UMUM']
								);
							}							
						}
					}

				}

				// $KETERANGAN = './assets/upload_sppb_form_file/' . $nama;
				// $this->db->insert('sppb_form_file', array('ID_SPPB' => $ID_SPPB, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_SPPB' => $HASH_MD5_SPPB, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
			}

			if (file_exists($file = './assets/upload_sppb_form_excel/' .$nama_file.".xlsx")) {
				unlink($file);
			}

		} else {
			// alihkan mereka ke halaman sppb list
			redirect('SPPB', 'refresh');
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
			$query_DOK_FILE = $this->SPPB_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_sppb_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->SPPB_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_SPPB = $this->session->userdata('HASH_MD5_SPPB');
				redirect('/sppb_form/view/' . $HASH_MD5_SPPB, 'refresh');
			} else {
				$HASH_MD5_SPPB = $this->session->userdata('HASH_MD5_SPPB');
				redirect('/sppb_form/view/' . $HASH_MD5_SPPB, 'refresh');
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('SPPB', 'refresh');
		}
	}

	public function tanggal_indo_full($tanggal, $cetak_hari = false)
	{
		if($tanggal == '0000-00-00')
		{
			$tgl_indo = "-";
			return $tgl_indo;
		}

		else
		{
			$hari = array ( 1 =>    'Senin',
						'Selasa',
						'Rabu',
						'Kamis',
						'Jumat',
						'Sabtu',
						'Minggu'
					);
					
			$bulan = array (1 =>   'Januari',
						'Februari',
						'Maret',
						'April',
						'Mei',
						'Juni',
						'Juli',
						'Agustus',
						'September',
						'Oktober',
						'November',
						'Desember'
					);
			$split 	  = explode('-', $tanggal);
			$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
			
			if ($cetak_hari) {
				$num = date('N', strtotime($tanggal));
				return $hari[$num] . ', ' . $tgl_indo;
			}
			return $tgl_indo;

		}
	}

	public function tanggal_indo_singkat($tanggal, $cetak_hari = false)
	{
		if($tanggal == '0000-00-00')
		{
			$tgl_indo = "-";
			return $tgl_indo;
		}

		else
		{
			$hari = array ( 1 =>    'Senin',
					'Selasa',
					'Rabu',
					'Kamis',
					'Jumat',
					'Sabtu',
					'Minggu'
				);
				
			$bulan = array (1 =>   'Jan',
						'Feb',
						'Mar',
						'Apr',
						'Mei',
						'Jun',
						'Jul',
						'Agt',
						'Sep',
						'Okt',
						'Nov',
						'Des'
					);
			$split 	  = explode('-', $tanggal);
			$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
			
			if ($cetak_hari) {
				$num = date('N', strtotime($tanggal));
				return $hari[$num] . ', ' . $tgl_indo;
			}
			return $tgl_indo;
		}
		
	}

	public function cetak_pdf($HASH_MD5_SPPB)
	{
		$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
		$ID_SPPB = $hasil['ID_SPPB'];
		$this->data['SPPB'] = $this->SPPB_model->sppb_list_sppb_by_hashmd5($HASH_MD5_SPPB);
		setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
		date_default_timezone_set('Asia/Jakarta');
		foreach ($this->data['SPPB']->result() as $SPPB):
			$this->data['ID_SPPB'] = $SPPB->ID_SPPB;
			$this->data['ID_PROYEK'] = $SPPB->ID_PROYEK;
			$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
			$this->data['TANGGAL_DOKUMEN_SPPB'] = $SPPB->TANGGAL_DOKUMEN_SPPB;
			$this->data['TANGGAL_DOKUMEN_SPPB_INDO'] = $this->tanggal_indo_full($SPPB->TANGGAL_DOKUMEN_SPPB_INDO, false);
			$this->data['TANGGAL_PEMBUATAN_SPPB_HARI'] = $SPPB->TANGGAL_PEMBUATAN_SPPB_HARI;
			$this->data['TANGGAL_PEMBUATAN_SPPB_BULAN'] = $SPPB->TANGGAL_PEMBUATAN_SPPB_BULAN;
			$this->data['TANGGAL_PEMBUATAN_SPPB_TAHUN'] = $SPPB->TANGGAL_PEMBUATAN_SPPB_TAHUN;
			$this->data['SUB_PROYEK'] = $SPPB->SUB_PROYEK;
			$this->data['CTT_DEPT_PROC'] = $SPPB->CTT_DEPT_PROC;
		endforeach;

		$this->data['data_grup_rab_sppb_form'] = $this->SPPB_form_model->data_grup_rab_sppb_form($ID_SPPB);
		if (!empty($this->data['data_grup_rab_sppb_form']))
		{
			$data_grup_rab_sppb_form = $this->SPPB_form_model->data_grup_rab_sppb_form($ID_SPPB);
			$urutan = 0;
			foreach ($data_grup_rab_sppb_form as $item) {
				$ID_RAB_FORM = $item->ID_RAB_FORM;
				$NAMA_KATEGORI = $item->NAMA_KATEGORI;
				$konten_SPPB_form = $this->SPPB_form_model->sppb_form_list_by_id_sppb($ID_SPPB, $ID_RAB_FORM);
				
				$konten_rab_sppb_form[$urutan++] = array(
					"ID_RAB_FORM" => $item->ID_RAB_FORM,
					"NAMA_KATEGORI" => $item->NAMA_KATEGORI,
					"konten_SPPB_form" => $konten_SPPB_form
				);
			}
			$this->data['konten_rab_sppb_form'] = $konten_rab_sppb_form;
		}

		if (empty($this->data['data_grup_rab_sppb_form']))
		{
			$this->data['konten_rab_sppb_form'] = "";
		}

		$this->data['konten_keterangan_barang_SPPB_form'] = $this->SPPB_form_model->get_data_keterangan_barang_by_id_sppb($ID_SPPB);
		$this->data['sign_SPPB_form'] = $this->SPPB_form_model->sign_sppb_by_id_sppb_non_result($ID_SPPB); foreach ($this->data['sign_SPPB_form']->result() as $SPPB):
			$this->data['SIGN_USER_D_EP_KONS_KP'] = $SPPB->SIGN_USER_D_EP_KONS_KP;
			$this->data['SIGN_USER_D_PSDS_KP'] = $SPPB->SIGN_USER_D_PSDS_KP;
			$this->data['SIGN_USER_M_EP_KP'] = $SPPB->SIGN_USER_M_EP_KP;
			$this->data['SIGN_USER_M_KONS_KP'] = $SPPB->SIGN_USER_M_KONS_KP;
			$this->data['SIGN_USER_M_LOG_KP'] = $SPPB->SIGN_USER_M_LOG_KP;
			$this->data['SIGN_USER_PM_SP'] = $SPPB->SIGN_USER_PM_SP;
			$this->data['SIGN_USER_SM_SP'] = $SPPB->SIGN_USER_SM_SP;
			$this->data['SIGN_USER_CHIEF_SP'] = $SPPB->SIGN_USER_CHIEF_SP;
			$this->data['SIGN_USER_STAFF_UMUM_LOG_SP'] = $SPPB->SIGN_USER_STAFF_UMUM_LOG_SP;
		endforeach;

		$this->data['ctt_SPPB_form'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb_non_result($ID_SPPB); foreach ($this->data['ctt_SPPB_form']->result() as $SPPB):
			$this->data['CTT_STAFF_UMUM_LOG_SP'] = $SPPB->CTT_STAFF_UMUM_LOG_SP;
			$this->data['CTT_SPV_LOG_SP'] = $SPPB->CTT_SPV_LOG_SP;
			$this->data['CTT_CHIEF'] = $SPPB->CTT_CHIEF;
			$this->data['CTT_SM'] = $SPPB->CTT_SM;
			$this->data['CTT_PM'] = $SPPB->CTT_PM;
			$this->data['CTT_STAFF_LOG_KP'] = $SPPB->CTT_STAFF_LOG_KP;
			$this->data['CTT_STAFF_GUDANG_LOG_KP'] = $SPPB->CTT_STAFF_GUDANG_LOG_KP;
			$this->data['CTT_KASIE_LOG_KP'] = $SPPB->CTT_KASIE_LOG_KP;
			$this->data['CTT_M_HRD'] = $SPPB->CTT_M_HRD;
			$this->data['CTT_M_KEU'] = $SPPB->CTT_M_KEU;
			$this->data['CTT_M_KONS'] = $SPPB->CTT_M_KONS;
			$this->data['CTT_M_SDM'] = $SPPB->CTT_M_SDM;
			$this->data['CTT_M_QAQC'] = $SPPB->CTT_M_QAQC;
			$this->data['CTT_M_EP'] = $SPPB->CTT_M_EP;
			$this->data['CTT_M_HSSE'] = $SPPB->CTT_M_HSSE;
			$this->data['CTT_M_MARKETING'] = $SPPB->CTT_M_MARKETING;
			$this->data['CTT_M_KOMERSIAL'] = $SPPB->CTT_M_KOMERSIAL;
			$this->data['CTT_M_LOG'] = $SPPB->CTT_M_LOG;
			$this->data['CTT_D_KEU'] = $SPPB->CTT_D_KEU;
			$this->data['CTT_D_EP_KONS'] = $SPPB->CTT_D_EP_KONS;
			$this->data['CTT_D_PSDS'] = $SPPB->CTT_D_PSDS;
		endforeach;

		$this->data['PROYEK'] = $this->Proyek_model->detil_proyek_by_ID_PROYEK($this->data['ID_PROYEK']); foreach ($this->data['PROYEK']->result() as $PROYEK):
			$this->data['NAMA_PROYEK_PDF'] = $PROYEK->NAMA_PROYEK;
		endforeach;

		//$this->data['rasd_barang_list'] = $this->FPB_form_model->rasd_form_list_where_not_in_fpb($ID_FPB);
		//$this->data['barang_master_list'] = $this->FPB_form_model->barang_master_where_not_in_fpb_and_rasd($ID_FPB);
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		// $this->data['USER_PENGAJU'] = $this->FPB_form_model->ID_JABATAN_BY_ID_FPB($ID_FPB);

		// foreach ($this->data['FPB']->result() as $FPB) :
		// 	$FILE_NAME_TEMP = $FPB->FILE_NAME_TEMP;
		// 	$this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
		// endforeach;

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE

		$config['cacheable'] = true; //boolean, the default is true
		$config['cachedir'] = './assets/QR_SPPB/cachedir/'; //string, the default is application/cache/
		$config['errorlog'] = './assets/QR_SPPB/errorlog/'; //string, the default is application/logs/
		$config['imagedir'] = './assets/QR_SPPB/'; //direktori penyimpanan qr code
		$config['quality'] = true; //boolean, the default is true
		$config['level'] = 'L'; //boolean, the default is true
		$config['size'] = '1024'; //interger, the default is 1024
		$config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
		$config['white'] = array(70, 130, 180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		$image_name = $HASH_MD5_SPPB . '.jpg'; //buat name dari qr code sesuai dengan nim
		$this->data['image_name'] = $image_name;

		$params['data'] = base_url('index.php/Otentikasi_dokumen/SPPB/') . $HASH_MD5_SPPB; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		$this->data['GAMBAR_QR'] = 'C:/xampp/htdocs/project_eam/assets/QR_SPPB/' . $HASH_MD5_SPPB . ".jpg";
		$this->data['GAMBAR_QR_2'] = 'C:/xampp/htdocs/project_eam/assets/QR_SPPB/' . $HASH_MD5_SPPB . ".jpg";

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'SPPB';

		// filename dari pdf ketika didownload
		$file_pdf = 'sppb_' . $HASH_MD5_SPPB;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "landscape";

		$html = $this->load->view('wasa/pdf/sppb_pdf', $this->data, true);

		// run dompdf
		$x = 735;
		$y = 560;
		$text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size = 7;

		$file_path = "assets/SPPB/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}
}