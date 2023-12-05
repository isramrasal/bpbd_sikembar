<?php defined('BASEPATH') or exit('No direct script access allowed');

class SPP_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation','excel'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Form SPP';

		$this->load->model('SPP_model');
		$this->load->model('SPP_form_model');
		$this->load->model('Vendor_model');
		$this->load->model('Barang_master_model');
		$this->load->model('SPPB_form_model');
		$this->load->model('SPPB_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('Proyek_model');
		$this->load->model('SPP_Form_File_Model');
		$this->load->model('Pajak_model');
		$this->load->model('Klasifikasi_barang_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "SPP_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses SPPB";
		$WAKTU = date('Y-m-d H:i:s');
		$this->SPP_form_model->user_log_spp_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->SPP_form_model->user_log_spp_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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
		$this->data['last_login'] = date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_SPP = $this->uri->segment(3);
		if ($this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP) == 'TIDAK ADA DATA') {
			redirect('SPP', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['pajak_list'] = $this->Pajak_model->pajak_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) { //administrator

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['NO_URUT_SPP'] = $hasil['NO_URUT_SPP'];
			$this->data['BARIS_KOSONG'] = $hasil['BARIS_KOSONG'];
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

			$this->data['sppb_barang_list'] = $this->SPP_form_model->sppb_form_list_where_not_in_spp($ID_SPP, $ID_SPPB);
			$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
			$this->data['jenis_pekerjaan_list'] = $this->SPPB_model->data_sub_pekerjaan_by_id_proyek($this->data['ID_PROYEK']);

			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_spp_form_proses');
			$this->load->view('wasa/user_admin/footer');

		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //STAFF PROC KP

			$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
			if ($PROGRESS_SPP == "Diproses oleh Staff Procurement KP") {
				$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_SPP = $hasil['ID_SPP'];
				$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['NO_URUT_SPP'] = $hasil['NO_URUT_SPP'];
				$this->data['BARIS_KOSONG'] = $hasil['BARIS_KOSONG'];
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

				$this->data['sppb_barang_list'] = $this->SPP_form_model->sppb_form_list_where_not_in_spp($ID_SPP, $ID_SPPB);
				$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
				$this->data['jenis_pekerjaan_list'] = $this->SPPB_model->data_sub_pekerjaan_by_id_proyek($this->data['ID_PROYEK']);

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_spp_form_proses');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else {
				redirect('SPP', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //STAFF PROC SP

			$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
			if ($PROGRESS_SPP == "Diproses oleh Staff Procurement SP") {
				$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_SPP = $hasil['ID_SPP'];
				$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_SPP'] = $ID_SPP;

				
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

				$this->data['sppb_barang_list'] = $this->SPP_form_model->sppb_form_list_where_not_in_spp($ID_SPP, $ID_SPPB);
				$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
				$this->data['jenis_pekerjaan_list'] = $this->SPPB_model->data_sub_pekerjaan_by_id_proyek($this->data['ID_PROYEK']);

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_spp_form_proses');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else {
				redirect('SPP', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //SPV PROC SP

			$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
			if ($PROGRESS_SPP == "Diproses oleh Supervisi Procurement SP") {
				$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_SPP = $hasil['ID_SPP'];
				$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['NO_URUT_SPP'] = $hasil['NO_URUT_SPP'];
				$this->data['BARIS_KOSONG'] = $hasil['BARIS_KOSONG'];
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

				$this->data['sppb_barang_list'] = $this->SPP_form_model->sppb_form_list_where_not_in_spp($ID_SPP, $ID_SPPB);
				$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
				$this->data['jenis_pekerjaan_list'] = $this->SPPB_model->data_sub_pekerjaan_by_id_proyek($this->data['ID_PROYEK']);

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_spp_form_proses');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			}  else {
				redirect('SPP', 'refresh');
			}
		} else {
			$this->ion_auth->logout();
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

	// 	$HASH_MD5_SPP = $this->uri->segment(3);
	// 	if ($this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP) == 'TIDAK ADA DATA') {
	// 		redirect('SPP', 'refresh');
	// 	}

	// 	$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
	// 	$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

	// 	//jika mereka sudah login dan sebagai admin
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses SM") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_sm_sp/user_menu');
	// 			$this->load->view('wasa/user_sm_sp/left_menu');
	// 			$this->load->view('wasa/user_sm_sp/header_menu');
	// 			$this->load->view('wasa/user_sm_sp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_sm_sp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(4))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses PM") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_pm_sp/user_menu');
	// 			$this->load->view('wasa/user_pm_sp/left_menu');
	// 			$this->load->view('wasa/user_pm_sp/header_menu');
	// 			$this->load->view('wasa/user_pm_sp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_pm_sp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Manajer Kantor Pusat") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
	// 			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
	// 			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
	// 			$this->load->view('wasa/user_manajer_procurement_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_manajer_procurement_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Manajer Kantor Pusat") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
	// 			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
	// 			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
	// 			$this->load->view('wasa/user_manajer_logistik_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_manajer_logistik_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(21))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Manajer Kantor Pusat") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_manajer_keuangan_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_manajer_keuangan_kp/user_menu');
	// 			$this->load->view('wasa/user_manajer_keuangan_kp/left_menu');
	// 			$this->load->view('wasa/user_manajer_keuangan_kp/header_menu');
	// 			$this->load->view('wasa/user_manajer_keuangan_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_manajer_keuangan_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(24))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Manajer Kantor Pusat") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_manajer_konstruksi_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_manajer_konstruksi_kp/user_menu');
	// 			$this->load->view('wasa/user_manajer_konstruksi_kp/left_menu');
	// 			$this->load->view('wasa/user_manajer_konstruksi_kp/header_menu');
	// 			$this->load->view('wasa/user_manajer_konstruksi_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_manajer_konstruksi_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(27))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Manajer Kantor Pusat") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_manajer_sdm_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_manajer_sdm_kp/user_menu');
	// 			$this->load->view('wasa/user_manajer_sdm_kp/left_menu');
	// 			$this->load->view('wasa/user_manajer_sdm_kp/header_menu');
	// 			$this->load->view('wasa/user_manajer_sdm_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_manajer_sdm_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(30))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Manajer Kantor Pusat") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_manajer_qaqc_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_manajer_qaqc_kp/user_menu');
	// 			$this->load->view('wasa/user_manajer_qaqc_kp/left_menu');
	// 			$this->load->view('wasa/user_manajer_qaqc_kp/header_menu');
	// 			$this->load->view('wasa/user_manajer_qaqc_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_manajer_qaqc_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(33))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Manajer Kantor Pusat") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_manajer_ep_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_manajer_ep_kp/user_menu');
	// 			$this->load->view('wasa/user_manajer_ep_kp/left_menu');
	// 			$this->load->view('wasa/user_manajer_ep_kp/header_menu');
	// 			$this->load->view('wasa/user_manajer_ep_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_manajer_ep_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(34))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Direksi") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_direktur_keuangan_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_direktur_keuangan_kp/user_menu');
	// 			$this->load->view('wasa/user_direktur_keuangan_kp/left_menu');
	// 			$this->load->view('wasa/user_direktur_keuangan_kp/header_menu');
	// 			$this->load->view('wasa/user_direktur_keuangan_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_direktur_keuangan_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(35))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Direksi") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_direktur_psds_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_direktur_psds_kp/user_menu');
	// 			$this->load->view('wasa/user_direktur_psds_kp/left_menu');
	// 			$this->load->view('wasa/user_direktur_psds_kp/header_menu');
	// 			$this->load->view('wasa/user_direktur_psds_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_direktur_psds_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(36))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Direksi") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_direktur_konstruksi_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_direktur_konstruksi_kp/user_menu');
	// 			$this->load->view('wasa/user_direktur_konstruksi_kp/left_menu');
	// 			$this->load->view('wasa/user_direktur_konstruksi_kp/header_menu');
	// 			$this->load->view('wasa/user_direktur_konstruksi_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_direktur_konstruksi_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(41))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Manajer Kantor Pusat") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_manajer_hsse_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_manajer_hsse_kp/user_menu');
	// 			$this->load->view('wasa/user_manajer_hsse_kp/left_menu');
	// 			$this->load->view('wasa/user_manajer_hsse_kp/header_menu');
	// 			$this->load->view('wasa/user_manajer_hsse_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_manajer_hsse_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(43))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Manajer Kantor Pusat") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_manajer_marketing_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_manajer_marketing_kp/user_menu');
	// 			$this->load->view('wasa/user_manajer_marketing_kp/left_menu');
	// 			$this->load->view('wasa/user_manajer_marketing_kp/header_menu');
	// 			$this->load->view('wasa/user_manajer_marketing_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_manajer_marketing_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(44))) {

	// 		$hasil_2 = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		$PROGRESS_SPP = $hasil_2['PROGRESS_SPP'];
	// 		if ($PROGRESS_SPP == "Dalam Proses Manajer Kantor Pusat") {
	// 			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 			$ID_SPPB = $hasil['ID_SPPB'];
	// 			$ID_SPP = $hasil['ID_SPP'];
	// 			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
	// 			$this->data['ID_SPPB'] = $ID_SPPB;
	// 			$this->data['ID_SPP'] = $ID_SPP;
	// 			$this->data['CATATAN_SPP'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);

	// 			$this->data['vendor'] = $this->Vendor_model->vendor_list();
	// 			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
	// 			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);

	// 			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
	// 			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
	// 			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
	// 			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

	// 			$this->load->view('wasa/user_manajer_komersial_kp/head_normal', $this->data);
	// 			$this->load->view('wasa/user_manajer_komersial_kp/user_menu');
	// 			$this->load->view('wasa/user_manajer_komersial_kp/left_menu');
	// 			$this->load->view('wasa/user_manajer_komersial_kp/header_menu');
	// 			$this->load->view('wasa/user_manajer_komersial_kp/content_spp_form_proses_approval');
	// 			$this->load->view('wasa/user_manajer_komersial_kp/footer');
	// 		} else {
	// 			redirect('SPP', 'refresh');
	// 		}
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	function grup_rab_spp_form()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPP = $this->input->post('ID_SPP');
			$data = $this->SPP_form_model->grup_rab_spp_form($ID_SPP);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPP Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_vendor()
	{
		if ($this->ion_auth->logged_in()) {
			$data = $this->Vendor_model->vendor_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Melihat Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_spp_form()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPP = $this->input->post('ID_SPP');
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$data = $this->SPP_form_model->spp_form_list_by_id_spp($ID_SPP, $ID_RAB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPP Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_spp_form_by_id_spp()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPP = $this->input->post('ID_SPP');
			$data = $this->SPP_form_model->data_spp_form_by_id_spp($ID_SPP);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPP Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_spp_form_kirim_SPP()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_SPP = $this->input->get('ID_SPP');
			$data = $this->SPP_form_model->spp_form_list_by_id_spp_kirim_SPP($ID_SPP);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPP Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_anggaran()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPP = $this->input->post('ID_SPP');

			$data = $this->SPP_form_model->spp_form_list_anggaran_by_id_spp($ID_SPP);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPP Form: " . json_encode($ID_SPP);
			$this->user_log($KETERANGAN);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_anggaran_sum_jumlah_barang_rasd()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RASD = $this->input->post('ID_RASD');

			$data = $this->SPP_form_model->data_anggaran_sum_jumlah_barang_rasd($ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPP Form: " . json_encode($ID_RASD);
			$this->user_log($KETERANGAN);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_anggaran_sum_jumlah_barang_rab()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$ID_SPP = $this->input->post('ID_SPP');

			$data = $this->SPP_form_model->data_anggaran_sum_jumlah_barang_rab($ID_RAB_FORM, $ID_SPP);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPP Form: " . json_encode($ID_RAB_FORM);
			$this->user_log($KETERANGAN);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_anggaran_sum_jumlah_barang_rab_pengadaan_sebelumnya()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$ID_SPP = $this->input->post('ID_SPP');

			$data = $this->SPP_form_model->data_anggaran_sum_jumlah_barang_rab_pengadaan_sebelumnya($ID_RAB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPP Form: " . json_encode($ID_RAB_FORM);
			$this->user_log($KETERANGAN);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_qty_spp_realisasi()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
			$data = $this->SPP_form_model->data_qty_spp_realisasi_by_ID_SPPB_FORM($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity Realisasi SPP: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_jumlah_qty_spp_by_id_sppb_form()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
			$data = $this->SPP_form_model->data_jumlah_qty_spp_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity Diajukan SPP: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPP_FORM = $this->input->get('id');
			$data = $this->SPP_form_model->get_data_by_id_spp_form($ID_SPP_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPP Form by ID_SPP: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	// function get_data_spp()
	// {
	// 	if ($this->ion_auth->logged_in()) {
	// 		$ID_SPP = $this->input->get('ID_SPP');
	// 		$data = $this->SPP_form_model->get_data_spp_by_id_spp($ID_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	// function get_id_spp_by_HASH_MD5_SPP()
	// {	
	// 	if ($this->ion_auth->logged_in()) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	// function get_data_catatan_spp()
	// {
	// 	if ($this->ion_auth->logged_in()) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_id_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	// function get_data_ctt_spp()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_SM($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_PM($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_STAFF_PROC_KP($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_KASIE_PROC_KP($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_M_PROC($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_STAFF_PROC_PROYEK($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_SPV_PROC_PROYEK($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_M_LOG($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_M_KEU($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_M_KONS($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_M_SDM($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_M_QAQC($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_M_EP($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_D_KEU($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_D_PSDS($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_D_EP_KONS($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_M_HSSE($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_M_MARKETING($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {
	// 		$HASH_MD5_SPP = $this->input->get('HASH_MD5_SPP');
	// 		$data = $this->SPP_model->get_data_CTT_M_KOMERSIAL($HASH_MD5_SPP);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPP: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	function hapus_data()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPP_FORM = $this->input->post('kode');
			$data_hapus = $this->SPP_form_model->get_data_by_id_spp_form($ID_SPP_FORM);

			$ID_SPPB_FORM = $data_hapus['ID_SPPB_FORM'];

			$this->SPP_form_model->update_status_id_sppb_form_incomplete($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data SPP Form: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			//HAPUS DATA REALISASI DAHULU
			$data = $this->SPP_form_model->hapus_rasd_realisasi($ID_SPP_FORM);

			$data = $this->SPP_form_model->hapus_data_by_id_spp_form($ID_SPP_FORM);
			echo json_encode($data);
						
						
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function hapus_data_semua()
	{
		if ($this->ion_auth->logged_in()) {
			$HASH_MD5_SPP = $this->input->post('kode');
			$data_hapus = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);

			$KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$ID_SPP = $data_hapus['ID_SPP'];

			$data_spp_form = $this->SPP_form_model->spp_form_list_by_id_spp_kirim_SPP($ID_SPP);
				foreach ($data_spp_form as $SPP_FORM):
					$this->data['ID_SPPB_FORM'] = $SPP_FORM->ID_SPPB_FORM;
					$this->SPP_form_model->update_status_id_sppb_form_incomplete($this->data['ID_SPPB_FORM']);
				endforeach;

			$data = $this->SPP_form_model->hapus_data_by_id_spp($ID_SPP);
			echo json_encode($data);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function simpan_identitas_form()
	{
		if ($this->ion_auth->logged_in()) {

			//set validation rules
			$this->form_validation->set_rules('NO_URUT_SPP_GANTI', 'No. Urut SPP', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('TANGGAL_DOKUMEN_SPP', 'Tanggal Dokumen SPP', 'trim|required');
			$this->form_validation->set_rules('JENIS_PERMINTAAN', 'Jenis Permintaan', 'trim|required');
			$this->form_validation->set_rules('CTT_DEPT_PROC', 'Catatan Dokumen SPP', 'trim|required');

			//get the form data
			$ID_SPP = $this->input->post('ID_SPP');
			$TANGGAL_DOKUMEN_SPP = $this->input->post('TANGGAL_DOKUMEN_SPP');
			$JENIS_PERMINTAAN = $this->input->post('JENIS_PERMINTAAN');
			$CTT_DEPT_PROC = $this->input->post('CTT_DEPT_PROC');
			$BARIS_KOSONG = $this->input->post('BARIS_KOSONG');
			$NO_URUT_SPP_GANTI = $this->input->post('NO_URUT_SPP_GANTI');
			$NO_URUT_SPP_ASLI = $this->input->post('NO_URUT_SPP_ASLI');
			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo validation_errors();
			} else {

				if($NO_URUT_SPP_GANTI==$NO_URUT_SPP_ASLI)
				{
					$data = $this->SPP_form_model->simpan_identitas_form($ID_SPP, $NO_URUT_SPP_ASLI, $TANGGAL_DOKUMEN_SPP, $JENIS_PERMINTAAN, $CTT_DEPT_PROC, $BARIS_KOSONG );
					echo json_encode($data);
				}
				else
				{
					if ($this->SPP_model->cek_nomor_urut_spp($NO_URUT_SPP_GANTI) == 'DATA BELUM ADA') {

						$data = $this->SPP_form_model->simpan_identitas_form($ID_SPP, $NO_URUT_SPP_GANTI, $TANGGAL_DOKUMEN_SPP, $JENIS_PERMINTAAN, $CTT_DEPT_PROC, $BARIS_KOSONG );
						echo json_encode($data);

					} else {
						echo 'Nomor Urut SPP sudah terekam sebelumnya';
					}
				}
				
			}
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function simpan_data_dari_sppb_form()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
			$ID_SPP = $this->input->post('ID_SPP');
			foreach ($ID_SPPB_FORM as $index => $ID_SPPB_FORM) {
				$this->SPP_form_model->simpan_data_dari_sppb_form($ID_SPPB_FORM, $ID_SPP);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in()) {

			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|greater_than[0]|less_than[99999999999]|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('KLASIFIKASI_BARANG', 'Klasifikasi Barang', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN_UMUM', 'Keterangan', 'trim|max_length[300]');
			$this->form_validation->set_rules('ID_RAB_FORM', 'Kategori RAB', 'trim');
			$this->form_validation->set_rules('JENIS_PENGADAAN', 'Jenis Pengadaan', 'trim|required');

			$TANGGAL_MULAI_PAKAI_HARI = $this->input->post('TANGGAL_MULAI_PAKAI_HARI');
			$TANGGAL_SELESAI_PAKAI_HARI = $this->input->post('TANGGAL_SELESAI_PAKAI_HARI');

			$JENIS_PENGADAAN = $this->input->post('JENIS_PENGADAAN');
			if ($JENIS_PENGADAAN == 'Rental' || $JENIS_PENGADAAN == 'Jasa')
			{
				$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI_HARI', 'Tanggal Selesai Pemakaian', 'trim|max_length[100]|required');
			}

			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

			$hasil = $this->SPP_form_model->data_jumlah_qty_spp_by_id_sppb_form($ID_SPPB_FORM);
			$JUMLAH_QTY_SPPB = $hasil['JUMLAH_QTY_SPP'];

			$hasil_2 = $this->SPP_form_model->data_jumlah_realisasi_by_id_sppb_form($ID_SPPB_FORM);
			$JUMLAH_REALISASI_SPP = $hasil_2['JUMLAH_REALISASI_SPP'];

			$JUMLAH_QTY_SPPB = floatval($JUMLAH_QTY_SPPB);
			$JUMLAH_BARANG = floatval($this->input->post('JUMLAH_BARANG'));
			$JUMLAH_BARANG_ORIGINAL = floatval($this->input->post('JUMLAH_BARANG_ORIGINAL'));
			$JUMLAH_REALISASI_SPP = floatval($JUMLAH_REALISASI_SPP);

			$JUMLAH_SISA = $JUMLAH_QTY_SPPB - $JUMLAH_REALISASI_SPP + $JUMLAH_BARANG_ORIGINAL;
			
			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			
			} else if ($JUMLAH_BARANG > $JUMLAH_QTY_SPPB) {
				echo json_encode("Jumlah Barang Melebihi Jumlah Barang Pada Permintaan SPPB");
	
			} else if ($JUMLAH_BARANG > $JUMLAH_SISA) {
				echo json_encode("Jumlah Barang Melebihi Jumlah Qty Yang Bisa Diajukan SPP");

			} else if ($TANGGAL_SELESAI_PAKAI_HARI < $TANGGAL_MULAI_PAKAI_HARI) {
				echo json_encode("Tanggal Selesai Pemakaian Tidak Bisa Sebelum Tanggal Mulai Pemakaian");

			} else {
				if ($this->input->post('ID_VENDOR') == "666666") {
					$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat Vendor', 'trim|max_length[255]|required');
					$this->form_validation->set_rules('NO_TELP_VENDOR', 'Nomor Telp Vendor', 'trim|max_length[20]|required');

					//run validation check
					if ($this->form_validation->run() == FALSE) { //validation fails
						echo json_encode(validation_errors());
					} else {
						//get the form data
						$ID_SPP = $this->input->post('ID_SPP');
						$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
						$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
						$NAMA = $this->input->post('NAMA');
						$MEREK = $this->input->post('MEREK');
						$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
						$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
						$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
						$KETERANGAN_UMUM = $this->input->post('KETERANGAN_UMUM');
						$JENIS_PENGADAAN = $this->input->post('JENIS_PENGADAAN');
						$ID_KLASIFIKASI_BARANG = $this->input->post('KLASIFIKASI_BARANG');

						$ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
						$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
						$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');

						$ID_VENDOR = $this->input->post('ID_VENDOR');
						$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
						$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
						$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
						$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
						$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');
						$TANGGAL_MULAI_PAKAI = $this->input->post('TANGGAL_MULAI_PAKAI');

						if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
							//log
							$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
							$this->user_log($KETERANGAN);

							$data = $this->Vendor_model->simpan_data_dari_spp_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);

							$this->Vendor_model->set_md5_id_vendor_dari_spp_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);

							$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
							$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
							$ID_VENDOR = $this->data['ID_VENDOR'];

							$ID_VENDOR_FIX = $ID_VENDOR;

							$data_edit = $this->SPP_form_model->get_data_by_id_spp_form($ID_SPP_FORM);

							$KETERANGAN = "Ubah Data SPP Form: " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $ID_SPP_FORM . ";" . $JUMLAH_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT;
							$this->user_log($KETERANGAN);

							if ($JUMLAH_BARANG <= $JUMLAH_SISA)
							{
								$data = $this->SPP_form_model->update_data(
									$ID_SPP_FORM,
									$NAMA,
									$MEREK,
									$SPESIFIKASI_SINGKAT,
									$JUMLAH_BARANG,
									$SATUAN_BARANG,
									$ID_KLASIFIKASI_BARANG,
									$JENIS_PENGADAAN,
									$TANGGAL_MULAI_PAKAI_HARI,
									$TANGGAL_SELESAI_PAKAI_HARI,
									$KETERANGAN_UMUM,
									$ID_PROYEK_SUB_PEKERJAAN,
									$ID_RAB_FORM,
									$ID_RASD_FORM,
									$ID_VENDOR_FIX,
									$HARGA_SATUAN_BARANG_FIX,
									$HARGA_TOTAL_FIX
								);

								//UPDATE KE SPPB FORM
								$hasil = $this->SPP_form_model->data_jumlah_qty_spp_by_id_sppb_form($ID_SPPB_FORM);
								$JUMLAH_QTY_SPP = $hasil['JUMLAH_QTY_SPP'];

								$hasil_2 = $this->SPP_form_model->data_jumlah_realisasi_by_id_sppb_form($ID_SPPB_FORM);
								$JUMLAH_REALISASI_SPP = $hasil_2['JUMLAH_REALISASI_SPP'];

								if ($JUMLAH_REALISASI_SPP < $JUMLAH_QTY_SPPB)
								{
									$data = $this->SPP_form_model->update_status_id_sppb_form_incomplete($ID_SPPB_FORM);
								}

								if ($JUMLAH_REALISASI_SPP == $JUMLAH_QTY_SPPB)
								{
									$data = $this->SPP_form_model->update_status_id_sppb_form_complete($ID_SPPB_FORM);
								}

								$HARGA_BARANG = $HARGA_SATUAN_BARANG_FIX;
								$HARGA_TOTAL = $HARGA_TOTAL_FIX;
								//TAMBAHKAN ATAU CEK RASD REALISASI
								if ($this->SPP_form_model->cek_rasd_realiasi_by_id_spp_form($ID_SPP_FORM) == 'BELUM ADA ITEM')
								{
									$data = $this->SPP_form_model->simpan_rasd_realisasi(
										$ID_RAB_FORM,
										$ID_RASD_FORM,
										$ID_SPP,
										$ID_SPP_FORM,
										$SATUAN_BARANG,
										$JUMLAH_BARANG,
										$HARGA_BARANG,
										$HARGA_TOTAL
									);
									echo json_encode($data);
								}
								else
								{
									$data = $this->SPP_form_model->update_rasd_realisasi(
										$ID_RAB_FORM,
										$ID_RASD_FORM,
										$ID_SPP,
										$ID_SPP_FORM,
										$SATUAN_BARANG,
										$JUMLAH_BARANG,
										$HARGA_BARANG,
										$HARGA_TOTAL
									);
									echo json_encode($data);
								}
						
							}
							else
							{
								echo json_encode('Gagal melakukan update data');
							}


						} else {
							echo json_encode('Nama vendor sudah terekam sebelumnya');
						}
						
					}
				} else {
					//get the form data

					$ID_SPP = $this->input->post('ID_SPP');
					$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
					$NAMA = $this->input->post('NAMA');
					$MEREK = $this->input->post('MEREK');
					$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
					$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
					$ID_KLASIFIKASI_BARANG = $this->input->post('KLASIFIKASI_BARANG');
					$KETERANGAN_UMUM = $this->input->post('KETERANGAN_UMUM');
					$JENIS_PENGADAAN = $this->input->post('JENIS_PENGADAAN');

					$ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
					$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
					$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');

					$ID_VENDOR = $this->input->post('ID_VENDOR');
					$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
					$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

					$ID_VENDOR_FIX = $ID_VENDOR;

					// $data_edit = $this->SPP_form_model->get_data_by_id_spp_form($ID_SPP_FORM);


					// $KETERANGAN = "Ubah Data SPP Form: " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $ID_SPP_FORM . ";" . $JUMLAH_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT;
					// $this->user_log($KETERANGAN);

					if ($JUMLAH_BARANG <= $JUMLAH_SISA)
					{
						$data = $this->SPP_form_model->update_data(
							$ID_SPP_FORM,
							$NAMA,
							$MEREK,
							$SPESIFIKASI_SINGKAT,
							$JUMLAH_BARANG,
							$SATUAN_BARANG,
							$ID_KLASIFIKASI_BARANG,
							$JENIS_PENGADAAN,
							$TANGGAL_MULAI_PAKAI_HARI,
							$TANGGAL_SELESAI_PAKAI_HARI,
							$KETERANGAN_UMUM,
							$ID_PROYEK_SUB_PEKERJAAN,
							$ID_RAB_FORM,
							$ID_RASD_FORM,
							$ID_VENDOR_FIX,
							$HARGA_SATUAN_BARANG_FIX,
							$HARGA_TOTAL_FIX
						);

						//UPDATE KE SPPB FORM
						$hasil = $this->SPP_form_model->data_jumlah_qty_spp_by_id_sppb_form($ID_SPPB_FORM);
						$JUMLAH_QTY_SPP = $hasil['JUMLAH_QTY_SPP'];

						$hasil_2 = $this->SPP_form_model->data_jumlah_realisasi_by_id_sppb_form($ID_SPPB_FORM);
						$JUMLAH_REALISASI_SPP = $hasil_2['JUMLAH_REALISASI_SPP'];

						if ($JUMLAH_REALISASI_SPP < $JUMLAH_QTY_SPPB)
						{
							$data = $this->SPP_form_model->update_status_id_sppb_form_incomplete($ID_SPPB_FORM);
						}

						if ($JUMLAH_REALISASI_SPP == $JUMLAH_QTY_SPPB)
						{
							$data = $this->SPP_form_model->update_status_id_sppb_form_complete($ID_SPPB_FORM);
							
						}


						$HARGA_BARANG = $HARGA_SATUAN_BARANG_FIX;
						$HARGA_TOTAL = $HARGA_TOTAL_FIX;
						//TAMBAHKAN ATAU CEK RASD REALISASI
						if ($this->SPP_form_model->cek_rasd_realiasi_by_id_spp_form($ID_SPP_FORM) == 'BELUM ADA ITEM')
						{
							$data = $this->SPP_form_model->simpan_rasd_realisasi(
								$ID_RAB_FORM,
								$ID_RASD_FORM,
								$ID_SPP,
								$ID_SPP_FORM,
								$SATUAN_BARANG,
								$JUMLAH_BARANG,
								$HARGA_BARANG,
								$HARGA_TOTAL
							);
							echo json_encode($data);
						}
						else
						{
							$data = $this->SPP_form_model->update_rasd_realisasi(
								$ID_RAB_FORM,
								$ID_RASD_FORM,
								$ID_SPP,
								$ID_SPP_FORM,
								$SATUAN_BARANG,
								$JUMLAH_BARANG,
								$HARGA_BARANG,
								$HARGA_TOTAL
							);
							echo json_encode($data);
						}
						

						
					}
					else
					{
						echo json_encode('Gagal melakukan update data');
					}

					
				}
			}
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function update_progress()
	{
		if ($this->ion_auth->logged_in()) {
			
			$ID_SPP = $this->input->post('ID_SPP');
			$PROGRESS_SPP = $this->input->post('PROGRESS_SPP');

			$data = $this->SPP_form_model->update_progress_id_spp(
				$ID_SPP, $PROGRESS_SPP
			);
			echo json_encode($data);
			
		} else {
			$this->logout();
		}
	}

	function update_tabel_rasd_realisasi()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPP = $this->input->post('ID_SPP');
			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
			$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
			$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
			$HARGA_BARANG = $this->input->post('HARGA_BARANG');
			$HARGA_TOTAL = $this->input->post('HARGA_TOTAL');

			if ($this->SPP_form_model->cek_rasd_realiasi_by_id_spp_form($ID_SPP_FORM) == 'BELUM ADA ITEM')
			{
				$data = $this->SPP_form_model->simpan_rasd_realisasi(
					$ID_RAB_FORM,
					$ID_RASD_FORM,
					$ID_SPP,
					$ID_SPP_FORM,
					$SATUAN_BARANG,
					$JUMLAH_BARANG,
					$HARGA_BARANG,
					$HARGA_TOTAL
				);
				echo json_encode($data);
			}
			else
			{
				$data = $this->SPP_form_model->update_rasd_realisasi(
					$ID_RAB_FORM,
					$ID_RASD_FORM,
					$ID_SPP,
					$ID_SPP_FORM,
					$SATUAN_BARANG,
					$JUMLAH_BARANG,
					$HARGA_BARANG,
					$HARGA_TOTAL
				);
				echo json_encode($data);
			}
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function update_data_kontrol_anggaran()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_SPP = $this->input->post('ID_SPP');
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
			$NAMA_KATEGORI = $this->input->post('NAMA_KATEGORI');
			$RENCANA_ANGGARAN = $this->input->post('RENCANA_ANGGARAN');
			$PENGADAAN_SEBELUMNYA = $this->input->post('PENGADAAN_SEBELUMNYA');
			$PENGADAAN_SAAT_INI = $this->input->post('PENGADAAN_SAAT_INI');
			$TOTAL_PENGADAAN = $this->input->post('TOTAL_PENGADAAN');
			$SISA_ANGGARAN = $this->input->post('SISA_ANGGARAN');

			if ($this->SPP_form_model->cek_item_spp_kontrol_anggaran($ID_SPP, $ID_RAB_FORM) == 'BELUM ADA ITEM') {

				$data_2 = $this->SPP_form_model->simpan_item_spp_kontrol_anggaran($ID_SPP, $ID_RAB_FORM, $ID_PROYEK_SUB_PEKERJAAN, $NAMA_KATEGORI, $RENCANA_ANGGARAN, $PENGADAAN_SEBELUMNYA, $PENGADAAN_SAAT_INI, $TOTAL_PENGADAAN, $SISA_ANGGARAN);
				echo json_encode($data_2);
			} else {

				$data_3 = $this->SPP_form_model->update_item_spp_kontrol_anggaran($ID_SPP, $ID_RAB_FORM, $ID_PROYEK_SUB_PEKERJAAN, $NAMA_KATEGORI, $RENCANA_ANGGARAN, $PENGADAAN_SEBELUMNYA, $PENGADAAN_SAAT_INI, $TOTAL_PENGADAAN, $SISA_ANGGARAN);
				
				echo json_encode($data_3);
			}

			

		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function update_data_tampil_kontrol_anggaran()
	{
		if ($this->ion_auth->logged_in()) {

			$HASH_MD5_SPP = $this->input->post('HASH_MD5_SPP');

			$data_2 = $this->SPP_form_model->ubah_TAMPILKAN_KONTROL_ANGGARAN($HASH_MD5_SPP);
			echo json_encode($data_2);			

		}
		else
		{
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function hapus_item_spp_kontrol_anggaran()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_SPP = $this->input->post('ID_SPP');
			$data_2 = $this->SPP_form_model->hapus_item_spp_kontrol_anggaran($ID_SPP);
			echo json_encode($data_2);

		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	// function update_data_keterangan_barang()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User SM): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_SM($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User PM): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_PM($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_STAFF_PROC_KP($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Kasie Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_KASIE_PROC_KP($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_M_PROC_KP($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Staff Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_STAFF_PROC_PROYEK($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Supervisi Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_SPV_PROC_PROYEK($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer Logistik): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_M_LOG($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer Keuangan): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_M_KEU($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer Konstruksi): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_M_KONS($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer SDM): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_M_SDM($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer QAQC): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_M_QAQC($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer PE): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_M_EP($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Direktur Keuangan): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_D_KEU($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Direktur PSDS): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_D_PSDS($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer EP dan Konstruksi): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_D_EP_KONS($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer HSSE): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_M_HSSE($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer Marketing): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_M_MARKETING($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Keterangan Item Barang/Jasa ', 'trim|required|max_length[118]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$KETERANGAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KET = "Ubah Data Keterangan SPP Form (User Manajer Komersial): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . " ----- " . $KETERANGAN;
	// 			$this->user_log($KET);

	// 			$data = $this->SPP_form_model->update_data_KETERANGAN_M_KOMERSIAL($ID_SPP_FORM, $KETERANGAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	// function update_data_harga_barang()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('HARGA_SATUAN_BARANG', 'Harga Satuan Barang', 'trim|required|numeric');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
	// 			$HARGA_SATUAN_BARANG = $this->input->post('HARGA_SATUAN_BARANG');
	// 			$HARGA_TOTAL = $this->input->post('HARGA_TOTAL');

	// 			$data_edit = $this->SPP_form_model->get_keterangan_by_id_spp_form($ID_SPP_FORM);
	// 			$KETERANGAN = "Ubah Data Harga SPP Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_SPP_FORM . ";" . $HARGA_SATUAN_BARANG . ";" . $HARGA_TOTAL;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_harga_barang($ID_SPP_FORM, $HARGA_SATUAN_BARANG, $HARGA_TOTAL);
	// 			echo json_encode($data);
	// 		}
	// 	} else {
	// 		$this->logout();
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

		$HASH_MD5_SPP = $this->uri->segment(3);
		if ($this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP) == 'TIDAK ADA DATA') {
			redirect('SPP', 'refresh');
		}


		if ($this->ion_auth->logged_in()) {

			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_SPP = $this->uri->segment(3);

			if ($this->ion_auth->is_admin()) {
				$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
				$sess_data['HASH_MD5_SPP'] = $this->data['HASH_MD5_SPP'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_SPP);

				$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
				$ID_SPP = $hasil['ID_SPP'];
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp($ID_SPP);

				foreach ($this->data['SPP']->result() as $SPP):
					$this->data['FILE_NAME_TEMP'] = 'spp_' . $HASH_MD5_SPP . '.pdf';
					$this->data['NO_URUT_SPP'] = $SPP->NO_URUT_SPP;
					$this->data['HASH_MD5_SPP'] = $SPP->HASH_MD5_SPP;
					$this->data['PROGRESS_SPP'] = $SPP->PROGRESS_SPP;
					$this->data['STATUS_SPP'] = $SPP->STATUS_SPP;
				endforeach;

				$query_file_HASH_MD5_SPP = $this->SPP_Form_File_Model->file_list_by_HASH_MD5_SPP($HASH_MD5_SPP);

				if ($query_file_HASH_MD5_SPP->num_rows() > 0) {

					$this->data['dokumen'] = $this->SPP_Form_File_Model->file_list_by_HASH_MD5_SPP_result($HASH_MD5_SPP);

					$hasil = $query_file_HASH_MD5_SPP->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_spp_form_file/' . $DOK_FILE)) {
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
				$this->load->view('wasa/user_admin/content_spp_form');
			}

			else if ($this->ion_auth->in_group(5)) {
				$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
				$sess_data['HASH_MD5_SPP'] = $this->data['HASH_MD5_SPP'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_SPP);

				$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
				$ID_SPP = $hasil['ID_SPP'];
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp($ID_SPP);

				foreach ($this->data['SPP']->result() as $SPP):
					$this->data['FILE_NAME_TEMP'] = 'spp_' . $HASH_MD5_SPP . '.pdf';
					$this->data['NO_URUT_SPP'] = $SPP->NO_URUT_SPP;
					$this->data['HASH_MD5_SPP'] = $SPP->HASH_MD5_SPP;
					$this->data['PROGRESS_SPP'] = $SPP->PROGRESS_SPP;
					$this->data['STATUS_SPP'] = $SPP->STATUS_SPP;
				endforeach;

				$query_file_HASH_MD5_SPP = $this->SPP_Form_File_Model->file_list_by_HASH_MD5_SPP($HASH_MD5_SPP);

				if ($query_file_HASH_MD5_SPP->num_rows() > 0) {

					$this->data['dokumen'] = $this->SPP_Form_File_Model->file_list_by_HASH_MD5_SPP_result($HASH_MD5_SPP);

					$hasil = $query_file_HASH_MD5_SPP->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_spp_form_file/' . $DOK_FILE)) {
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
				$this->load->view('wasa/user_staff_procurement_kp/content_spp_form');
			} else if ($this->ion_auth->in_group(8)) {
				$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
				$sess_data['HASH_MD5_SPP'] = $this->data['HASH_MD5_SPP'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_SPP);

				$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
				$ID_SPP = $hasil['ID_SPP'];
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp($ID_SPP);

				foreach ($this->data['SPP']->result() as $SPP):
					$this->data['FILE_NAME_TEMP'] = 'spp_' . $HASH_MD5_SPP . '.pdf';
					$this->data['NO_URUT_SPP'] = $SPP->NO_URUT_SPP;
					$this->data['HASH_MD5_SPP'] = $SPP->HASH_MD5_SPP;
					$this->data['PROGRESS_SPP'] = $SPP->PROGRESS_SPP;
					$this->data['STATUS_SPP'] = $SPP->STATUS_SPP;
				endforeach;

				$query_file_HASH_MD5_SPP = $this->SPP_Form_File_Model->file_list_by_HASH_MD5_SPP($HASH_MD5_SPP);

				if ($query_file_HASH_MD5_SPP->num_rows() > 0) {

					$this->data['dokumen'] = $this->SPP_Form_File_Model->file_list_by_HASH_MD5_SPP_result($HASH_MD5_SPP);

					$hasil = $query_file_HASH_MD5_SPP->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_spp_form_file/' . $DOK_FILE)) {
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
				$this->load->view('wasa/user_staff_procurement_sp/content_spp_form');
			} else if ($this->ion_auth->in_group(9)) {
				$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
				$sess_data['HASH_MD5_SPP'] = $this->data['HASH_MD5_SPP'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_SPP);

				$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
				$ID_SPP = $hasil['ID_SPP'];
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp($ID_SPP);

				foreach ($this->data['SPP']->result() as $SPP):
					$this->data['FILE_NAME_TEMP'] = 'spp_' . $HASH_MD5_SPP . '.pdf';
					$this->data['NO_URUT_SPP'] = $SPP->NO_URUT_SPP;
					$this->data['HASH_MD5_SPP'] = $SPP->HASH_MD5_SPP;
					$this->data['PROGRESS_SPP'] = $SPP->PROGRESS_SPP;
					$this->data['STATUS_SPP'] = $SPP->STATUS_SPP;
				endforeach;

				$query_file_HASH_MD5_SPP = $this->SPP_Form_File_Model->file_list_by_HASH_MD5_SPP($HASH_MD5_SPP);

				if ($query_file_HASH_MD5_SPP->num_rows() > 0) {

					$this->data['dokumen'] = $this->SPP_Form_File_Model->file_list_by_HASH_MD5_SPP_result($HASH_MD5_SPP);

					$hasil = $query_file_HASH_MD5_SPP->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_spp_form_file/' . $DOK_FILE)) {
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
				$this->load->view('wasa/user_supervisi_procurement_sp/content_spp_form');
			} else {
				redirect('SPP', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	function hapus_file()
	{
		//get data dari parameter URL
		$this->data['DOK_FILE'] = $this->uri->segment(3);

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in()) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->SPP_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_spp_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->SPP_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_SPP = $this->session->userdata('HASH_MD5_SPP');
				redirect('/SPP_form/view/' . $HASH_MD5_SPP, 'refresh');
			} else {
				$HASH_MD5_SPP = $this->session->userdata('HASH_MD5_SPP');
				redirect('/SPP_form/view/' . $HASH_MD5_SPP, 'refresh');
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}
	}

	function update_data_TOTAL_HARGA_SPP_BARANG($ID_SPP, $TOTAL_HARGA_SPP_BARANG)
	{
		if ($this->ion_auth->logged_in()) {

			$data = $this->SPP_form_model->update_data_total_harga_spp_barang($ID_SPP, $TOTAL_HARGA_SPP_BARANG);
		} else {
			$this->logout();
		}
	}

	// function update_data_TOTAL_ALL_SPP_BARANG($ID_SPP, $TOTAL_ALL_SPP_BARANG)
	// {
	// 	if ($this->ion_auth->logged_in()) {

	// 		$data = $this->SPP_form_model->update_data_total_all_spp_barang($ID_SPP, $TOTAL_ALL_SPP_BARANG);
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	public function tanggal_indo_full($tanggal, $cetak_hari = false)
	{
		if($tanggal == '0000-00-00')
		{
			$tgl_indo = "-";
			return $tgl_indo;
		}

		else if($tanggal == NULL)
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

		else if($tanggal == NULL)
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


	public function cetak_pdf($HASH_MD5_SPP)
	{
		$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
		$ID_SPP = $hasil['ID_SPP'];
		setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);
		foreach ($this->data['SPP']->result() as $SPP):
			$this->data['ID_SPP'] = $SPP->ID_SPP;
			$this->data['ID_SPPB'] = $SPP->ID_SPPB;
			$this->data['ID_PROYEK'] = $SPP->ID_PROYEK;
			$this->data['NO_URUT_SPP'] = $SPP->NO_URUT_SPP;
			$this->data['SUB_PROYEK'] = $SPP->SUB_PROYEK;
			$this->data['TANGGAL_DOKUMEN_SPP'] = $SPP->TANGGAL_DOKUMEN_SPP;
			$this->data['TANGGAL_DOKUMEN_SPP_INDO'] = $this->tanggal_indo_full($SPP->TANGGAL_DOKUMEN_SPP_INDO, false);
			$this->data['JENIS_PERMINTAAN'] = $SPP->JENIS_PERMINTAAN;
			$this->data['TOTAL_HARGA_SPP_BARANG'] = $SPP->TOTAL_HARGA_SPP_BARANG;
			$this->data['TOTAL_PAJAK_SPP_BARANG'] = $SPP->TOTAL_PAJAK_SPP_BARANG;
			$this->data['TOTAL_ALL_SPP_BARANG'] = $SPP->TOTAL_ALL_SPP_BARANG;
			$this->data['CTT_DEPT_PROC'] = $SPP->CTT_DEPT_PROC;
			$this->data['TAMPILKAN_KONTROL_ANGGARAN'] = $SPP->TAMPILKAN_KONTROL_ANGGARAN;
			$this->data['BARIS_KOSONG'] = $SPP->BARIS_KOSONG;
		endforeach;

		if (empty($this->data['KETERANGAN'])) {
			// list is empty.
			$this->data['KETERANGAN'] = "";
		}
		//NO URUT SPPB
		$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($this->data['ID_SPPB']); 
		foreach ($this->data['SPPB']->result() as $SPPB):
			$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
		endforeach;

		//NAMA PROYEK
		$this->data['PROYEK'] = $this->Proyek_model->detil_proyek_by_ID_PROYEK($this->data['ID_PROYEK']);
		foreach ($this->data['PROYEK']->result() as $PROYEK):
			$this->data['NAMA_PROYEK_PDF'] = $PROYEK->NAMA_PROYEK;
		endforeach;

		// APAKAH DIHAPUS?
		// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

		$this->data['grup_rab_SPP_form'] = $this->SPP_form_model->grup_rab_spp_form($ID_SPP);
		$grup_rab_SPP_form = $this->SPP_form_model->grup_rab_spp_form($ID_SPP);
		if (count($grup_rab_SPP_form) === 0)
		{
			$this->data['konten_rab_spp_form'] = "";
			$this->data['TOTAL_HARGA_SPP_BARANG'] = 0;
	   	}
		else
		{
			$urutan = 0;
			$this->data['TOTAL_HARGA_SPP_BARANG'] = 0;
			
			foreach ($grup_rab_SPP_form as $item) {
				$ID_RAB_FORM = $item->ID_RAB_FORM;
				$NAMA_KATEGORI = $item->NAMA_KATEGORI;
				$konten_SPP_form = $this->SPP_form_model->spp_form_list_by_id_spp($ID_SPP, $ID_RAB_FORM);
				$konten_rab_spp_form[$urutan++] = array(
					"ID_RAB_FORM" => $item->ID_RAB_FORM,
					"NAMA_KATEGORI" => $item->NAMA_KATEGORI,
					"konten_SPP_form" => $konten_SPP_form
				);

				foreach ($konten_SPP_form as $item) {
					$this->data['TOTAL_HARGA_SPP_BARANG'] = $this->data['TOTAL_HARGA_SPP_BARANG'] + $item->HARGA_TOTAL_FIX;
				}
				$total = $this->update_data_TOTAL_HARGA_SPP_BARANG($this->data['ID_SPP'], $this->data['TOTAL_HARGA_SPP_BARANG']);
			}
			$this->data['konten_rab_spp_form'] = $konten_rab_spp_form;
		}

		// $this->data['konten_SPP_form'] = $this->SPP_form_model->spp_form_list_by_id_spp($ID_SPP);
		$this->data['konten_keterangan_barang_SPP_form'] = $this->SPP_form_model->get_data_keterangan_barang_by_id_spp($ID_SPP);
		$this->data['sign_SPP_form'] = $this->SPP_form_model->sign_spp_by_id_spp_non_result($ID_SPP); 
		foreach ($this->data['sign_SPP_form']->result() as $SPP):
			$this->data['SIGN_USER_M_PROC'] = $SPP->SIGN_USER_M_PROC;
			$this->data['SIGN_USER_SM'] = $SPP->SIGN_USER_SM;
			$this->data['SIGN_USER_M_QAQC'] = $SPP->SIGN_USER_M_QAQC;
			$this->data['SIGN_USER_M_HSSE'] = $SPP->SIGN_USER_M_HSSE;
			$this->data['SIGN_USER_M_EP'] = $SPP->SIGN_USER_M_EP;
			$this->data['SIGN_USER_M_KONS'] = $SPP->SIGN_USER_M_KONS;
			$this->data['SIGN_USER_M_LOG'] = $SPP->SIGN_USER_M_LOG;
			$this->data['SIGN_USER_M_KEU'] = $SPP->SIGN_USER_M_KEU;
			$this->data['SIGN_USER_D_KEU'] = $SPP->SIGN_USER_D_KEU;
			$this->data['SIGN_USER_D_EP_KONS'] = $SPP->SIGN_USER_D_EP_KONS;
			$this->data['SIGN_USER_D_PSDS'] = $SPP->SIGN_USER_D_PSDS;
		endforeach;

		$this->data['ctt_SPP_form'] = $this->SPP_form_model->get_data_catatan_spp_by_id_spp_non_result($ID_SPP); 
		foreach ($this->data['ctt_SPP_form']->result() as $SPP):
			$this->data['CTT_STAFF_PROC_PROYEK'] = $SPP->CTT_STAFF_PROC_PROYEK;
			$this->data['CTT_SPV_PROC_PROYEK'] = $SPP->CTT_SPV_PROC_PROYEK;
			$this->data['CTT_SM'] = $SPP->CTT_SM;
			$this->data['CTT_PM'] = $SPP->CTT_PM;
			$this->data['CTT_STAFF_PROC_KP'] = $SPP->CTT_STAFF_PROC_KP;
			$this->data['CTT_KASIE_PROC_KP'] = $SPP->CTT_KASIE_PROC_KP;
			$this->data['CTT_M_LOG'] = $SPP->CTT_M_LOG;
			$this->data['CTT_M_KEU'] = $SPP->CTT_M_KEU;
			$this->data['CTT_M_KONS'] = $SPP->CTT_M_KONS;
			$this->data['CTT_M_SDM'] = $SPP->CTT_M_SDM;
			$this->data['CTT_M_QAQC'] = $SPP->CTT_M_QAQC;
			$this->data['CTT_M_EP'] = $SPP->CTT_M_EP;
			$this->data['CTT_M_HSSE'] = $SPP->CTT_M_HSSE;
			$this->data['CTT_M_MARKETING'] = $SPP->CTT_M_MARKETING;
			$this->data['CTT_M_KOMERSIAL'] = $SPP->CTT_M_KOMERSIAL;
			$this->data['CTT_M_PROC'] = $SPP->CTT_M_PROC;
			$this->data['CTT_D_KEU'] = $SPP->CTT_D_KEU;
			$this->data['CTT_D_EP_KONS'] = $SPP->CTT_D_EP_KONS;
			$this->data['CTT_D_PSDS'] = $SPP->CTT_D_PSDS;
		endforeach;

		$this->data['konten_kontrol_anggaran'] = $this->SPP_form_model->kontrol_anggaran_list_by_id_spp($ID_SPP);

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE

		$config['cacheable'] = true; //boolean, the default is true
		$config['cachedir'] = './assets/QR_SPP/cachedir/'; //string, the default is application/cache/
		$config['errorlog'] = './assets/QR_SPP/errorlog/'; //string, the default is application/logs/
		$config['imagedir'] = './assets/QR_SPP/'; //direktori penyimpanan qr code
		$config['quality'] = true; //boolean, the default is true
		$config['size'] = '1024'; //interger, the default is 1024
		$config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
		$config['white'] = array(70, 130, 180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		$image_name = $HASH_MD5_SPP . '.jpg'; //buat name dari qr code sesuai dengan nim
		$this->data['image_name'] = $image_name;

		$params['data'] = base_url('index.php/Otentikasi_dokumen/SPP/') . $HASH_MD5_SPP; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		$this->data['GAMBAR_QR'] = 'C:/xampp/htdocs/project_eam/assets/QR_SPP/' . $HASH_MD5_SPP . ".jpg";
		$this->data['GAMBAR_QR_2'] = 'C:/xampp/htdocs/project_eam/assets/QR_SPP/' . $HASH_MD5_SPP . ".jpg";


		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'SURAT PERMINTAAN BARANG';

		// filename dari pdf ketika didownload
		$file_pdf = 'spp_' . $HASH_MD5_SPP;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "landscape";

		// Menampilkan pdf
		$html = $this->load->view('wasa/pdf/spp_pdf', $this->data, true);

		// run dompdf
		$x = 735;
		$y = 560;
		$text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size = 7;

		$file_path = "assets/SPP/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	// function update_data_catatan_spp()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_SM', 'Catatan SPP SM', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_SM = $this->input->post('CTT_SM');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User SM): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_SM;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_SM($ID_SPP, $CTT_SM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_PM', 'Catatan SPP PM', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_PM = $this->input->post('CTT_PM');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User PM): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_PM;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_PM($ID_SPP, $CTT_PM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_STAFF_PROC_KP', 'Catatan SPP Staff Procurement KP', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_STAFF_PROC_KP = $this->input->post('CTT_STAFF_PROC_KP');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_STAFF_PROC_KP;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_STAFF_PROC_KP($ID_SPP, $CTT_STAFF_PROC_KP);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_KASIE_PROC_KP', 'Catatan SPP Kasie Procurement KP', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_KASIE_PROC_KP = $this->input->post('CTT_KASIE_PROC_KP');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPPB (User Kasie Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_KASIE_PROC_KP;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_KASIE_PROC_KP($ID_SPP, $CTT_KASIE_PROC_KP);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_M_PROC', 'Catatan Manajer Procurement KP', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_M_PROC = $this->input->post('CTT_M_PROC');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Manajer Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_M_PROC;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_M_PROC($ID_SPP, $CTT_M_PROC);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_STAFF_PROC_PROYEK', 'Catatan SPP Staff Procurement SP', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_STAFF_PROC_PROYEK = $this->input->post('CTT_STAFF_PROC_PROYEK');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Staff Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_STAFF_PROC_PROYEK;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_STAFF_PROC_PROYEK($ID_SPP, $CTT_STAFF_PROC_PROYEK);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_SPV_PROC_PROYEK', 'Catatan SPP Supervisi Procurement SP', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_SPV_PROC_PROYEK = $this->input->post('CTT_SPV_PROC_PROYEK');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Supervisi Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_SPV_PROC_PROYEK;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_SPV_PROC_PROYEK($ID_SPP, $CTT_SPV_PROC_PROYEK);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_M_LOG', 'Catatan SPP Manajer Logistik', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_M_LOG = $this->input->post('CTT_M_LOG');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Manajer Logistik): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_M_LOG;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_M_LOG($ID_SPP, $CTT_M_LOG);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_M_KEU', 'Catatan SPP Manajer Keuangan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_M_KEU = $this->input->post('CTT_M_KEU');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Manajer Keuangan): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_M_KEU;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_M_KEU($ID_SPP, $CTT_M_KEU);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_M_KONS', 'Catatan SPP Manajer Konstruksi', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_M_KONS = $this->input->post('CTT_M_KONS');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Manajer Konstruksi): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_M_KONS;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_M_KONS($ID_SPP, $CTT_M_KONS);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_M_SDM', 'Catatan SPP Manajer SDM', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_M_SDM = $this->input->post('CTT_M_SDM');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Manajer SDM): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_M_SDM;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_M_SDM($ID_SPP, $CTT_M_SDM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_M_QAQC', 'Catatan SPPB Manajer QAQC', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_M_QAQC = $this->input->post('CTT_M_QAQC');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Manajer QAQC): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_M_QAQC;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_M_QAQC($ID_SPP, $CTT_M_QAQC);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_M_EP', 'Catatan SPPB Manajer EP', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_M_EP = $this->input->post('CTT_M_EP');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Manajer EP): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_M_EP;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_M_EP($ID_SPP, $CTT_M_EP);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_D_KEU', 'Catatan SPP Direktur Keuangan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_D_KEU = $this->input->post('CTT_D_KEU');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Direktur Keuangan): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_D_KEU;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_D_KEU($ID_SPP, $CTT_D_KEU);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_D_PSDS', 'Catatan SPP Direktur PSDS', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_D_PSDS = $this->input->post('CTT_D_PSDS');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Direktur PSDS): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_D_PSDS;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_D_PSDS($ID_SPP, $CTT_D_PSDS);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_D_EP_KONS', 'Catatan SPP Direktur EP dan Kontruksi', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_D_EP_KONS = $this->input->post('CTT_D_EP_KONS');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Direktur EP dan Kontruksi): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_D_EP_KONS;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_D_EP_KONS($ID_SPP, $CTT_D_EP_KONS);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_M_HSSE', 'Catatan SPP Manajer HSSE', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_M_HSSE = $this->input->post('CTT_M_HSSE');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Manajer HSSE): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_M_HSSE;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_M_HSSE($ID_SPP, $CTT_M_HSSE);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_M_MARKETING', 'Catatan SPP Manajer Marketing', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_M_MARKETING = $this->input->post('CTT_M_MARKETING');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Manajer Marketing): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_M_MARKETING;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_M_MARKETING($ID_SPP, $CTT_M_MARKETING);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CTT_M_KOMERSIAL', 'Catatan SPP Manajer Komersial', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_SPP = $this->input->post('ID_SPP');
	// 			$CTT_M_KOMERSIAL = $this->input->post('CTT_M_KOMERSIAL');

	// 			$data_edit = $this->SPP_form_model->get_data_catatan_spp_by_id_spp($ID_SPP);
	// 			$KETERANGAN = "Ubah Data Catatan SPP (User Manajer Komersial): " . json_encode($data_edit) . " ---- " . $ID_SPP . ";" . $CTT_M_KOMERSIAL;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_CTT_M_KOMERSIAL($ID_SPP, $CTT_M_KOMERSIAL);
	// 			echo json_encode($data);
	// 		}
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	function update_data_kirim_spp()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPP', 'ID_SPP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPP = $this->input->post('ID_SPP');

				$KETERANGAN = "Kirim Form SPP Ke Kasie Procurement KP (User Staff Procurement KP): " . " ---- " . $ID_SPP;
				$this->user_log($KETERANGAN);

				// $PROGRESS_SPP = "Dalam Proses Kasie Procurement KP";
				// $STATUS_SPP = "Proses Pengajuan";

				$PROGRESS_SPP = "SPP Disetujui";
				$STATUS_SPP = "SELESAI";


				$data = $this->SPP_form_model->update_data_kirim_spp($ID_SPP, $PROGRESS_SPP, $STATUS_SPP);

				echo json_encode($data);

			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPP', 'ID_SPP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPP = $this->input->post('ID_SPP');

				$KETERANGAN = "Kirim Form SPP Ke Kasie Procurement KP (User Staff Procurement KP): " . " ---- " . $ID_SPP;
				$this->user_log($KETERANGAN);

				// $PROGRESS_SPP = "Dalam Proses Kasie Procurement KP";
				// $STATUS_SPP = "Proses Pengajuan";

				$PROGRESS_SPP = "SPP Disetujui";
				$STATUS_SPP = "SELESAI";


				$data = $this->SPP_form_model->update_data_kirim_spp($ID_SPP, $PROGRESS_SPP, $STATUS_SPP);

				echo json_encode($data);

			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPP', 'ID_SPP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPP = $this->input->post('ID_SPP');

				$KETERANGAN = "Kirim Form SPP" . " ---- " . $ID_SPP;
				$this->user_log($KETERANGAN);

				// $PROGRESS_SPP = "Dalam Proses Kasie Procurement KP";
				// $STATUS_SPP = "Proses Pengajuan";

				$PROGRESS_SPP = "SPP Disetujui";
				$STATUS_SPP = "SELESAI";


				$data = $this->SPP_form_model->update_data_kirim_spp($ID_SPP, $PROGRESS_SPP, $STATUS_SPP);

				echo json_encode($data);

			}

			
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPP', 'ID_SPP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPP = $this->input->post('ID_SPP');

				$KETERANGAN = "Kirim Form SPP" . " ---- " . $ID_SPP;
				$this->user_log($KETERANGAN);

				// $PROGRESS_SPP = "Dalam Proses Kasie Procurement KP";
				// $STATUS_SPP = "Proses Pengajuan";

				$PROGRESS_SPP = "SPP Disetujui";
				$STATUS_SPP = "SELESAI";


				$data = $this->SPP_form_model->update_data_kirim_spp($ID_SPP, $PROGRESS_SPP, $STATUS_SPP);

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
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User SM): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User PM): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Staff Procurement KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Kasie Procurement KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer Procurement KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Staff Procurement SP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Supervisi Procurement SP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer Logistik KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer Keuangan KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer Konstruksi KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer SDM KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer QAQC KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer PE KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Direktur Keuangan KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Direktur PSDS): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Direktur EP dan Konstruksi KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer HSSE KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer Marketing KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_CORET = $this->input->post('CATATAN_CORET');

	// 			$CATATAN_CORET = "Alasan penolakan " . $NAMA . ": " . $CATATAN_CORET;

	// 			$KETERANGAN = "Tolak Barang (User Manajer Komersial KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_coret($ID_SPP_FORM, $CATATAN_CORET);
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
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User SM): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User PM): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Staff Procurement KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Kasie Procurement KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Procurement KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Staff Procurement SP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) { //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {

	// 			//get the form data
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Supervisi Procurement SP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Logistik KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Keuangan KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Konstruksi KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer SDM KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer QAQC KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer PE KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Direktur Keuangan KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Direktur PSDS): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Direktur EP dan Konstruksi KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer HSSE KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Marketing KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
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
	// 			$ID_SPP_FORM = $this->input->post('kode');
	// 			$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

	// 			$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA . ": " . $CATATAN_BATAL_CORET;

	// 			$KETERANGAN = "Batal Tolak Barang (User Manajer Komersial KP): " . " ---- " . $ID_SPP_FORM . " ---- " . $CATATAN_BATAL_CORET;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->SPP_form_model->update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET);
	// 			echo json_encode($data);
	// 		}
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	public function kirim_email($HASH_MD5_SPP) //belum cek
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

		if ($this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP) == 'TIDAK ADA DATA') {
			redirect('SPP', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['ID_VENDOR_FIX'] = $hasil['ID_VENDOR_FIX'];
			$this->data['TERM_OF_PAYMENT'] = $hasil['TOP'];
			$this->data['LOKASI_PENYERAHAN'] = $hasil['LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR_FIX']);
			foreach ($hasil->result() as $VENDOR):
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);


			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_spp_form_kirim_email');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['ID_VENDOR_FIX'] = $hasil['ID_VENDOR_FIX'];
			$this->data['TERM_OF_PAYMENT'] = $hasil['TOP'];
			$this->data['LOKASI_PENYERAHAN'] = $hasil['LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR_FIX']);
			foreach ($hasil->result() as $VENDOR):
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);


			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_spp_form_kirim_email');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['ID_VENDOR_FIX'] = $hasil['ID_VENDOR_FIX'];
			$this->data['TERM_OF_PAYMENT'] = $hasil['TOP'];
			$this->data['LOKASI_PENYERAHAN'] = $hasil['LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR_FIX']);
			foreach ($hasil->result() as $VENDOR):
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);


			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_spp_form_kirim_email');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['ID_VENDOR_FIX'] = $hasil['ID_VENDOR_FIX'];
			$this->data['TERM_OF_PAYMENT'] = $hasil['TOP'];
			$this->data['LOKASI_PENYERAHAN'] = $hasil['LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR_FIX']);
			foreach ($hasil->result() as $VENDOR):
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);


			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_spp_form_kirim_email');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['ID_VENDOR_FIX'] = $hasil['ID_VENDOR_FIX'];
			$this->data['TERM_OF_PAYMENT'] = $hasil['TOP'];
			$this->data['LOKASI_PENYERAHAN'] = $hasil['LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR_FIX']);
			foreach ($hasil->result() as $VENDOR):
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);


			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_spp_form_kirim_email');
		} else {
			$this->logout();
		}
	}

	public function send_email($HASH_MD5_SPP) //belum cek
	{
		$config['mailtype'] = 'html';
		$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'ssl://smtp.gmail.com';
		$config['smtp_user'] = 'hrd.wasamitra@gmail.com';
		$config['smtp_pass'] = '!wasamitra2018';
		$config['smtp_port'] = 465;
		$config['newline'] = "\r\n";


		$this->load->library('email', $config);

		$this->email->from('no-reply@bahasaweb.com', 'Sistem Bahasaweb.com');
		$this->email->to('isramrasal@yahoo.com');
		$this->email->subject('Contoh Kirim Email Dengan Codeigniter');
		$this->email->message('Contoh pesan yang dikirim dengan codeigniter');

		if ($this->email->send()) {
			echo 'Email berhasil dikirim';
		} else {
			echo 'Email tidak berhasil dikirim';
			echo '<br />';
			echo $this->email->print_debugger();
		}
	}

	public function pengajuan_vendor($HASH_MD5_SPP) //belum cek
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

		if ($this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP) == 'TIDAK ADA DATA') {
			redirect('SPP', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['ID_VENDOR_FIX'] = $hasil['ID_VENDOR_FIX'];
			$this->data['TERM_OF_PAYMENT'] = $hasil['TOP'];
			$this->data['LOKASI_PENYERAHAN'] = $hasil['LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR_FIX']);
			foreach ($hasil->result() as $VENDOR):
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);


			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_spp_form_pengajuan_vendor');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['ID_VENDOR_FIX'] = $hasil['ID_VENDOR_FIX'];
			$this->data['TERM_OF_PAYMENT'] = $hasil['TOP'];
			$this->data['LOKASI_PENYERAHAN'] = $hasil['LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR_FIX']);
			foreach ($hasil->result() as $VENDOR):
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);


			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_spp_form_pengajuan_vendor');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['ID_VENDOR_FIX'] = $hasil['ID_VENDOR_FIX'];
			$this->data['TERM_OF_PAYMENT'] = $hasil['TOP'];
			$this->data['LOKASI_PENYERAHAN'] = $hasil['LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR_FIX']);
			foreach ($hasil->result() as $VENDOR):
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);


			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_spp_form_pengajuan_vendor');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['ID_VENDOR_FIX'] = $hasil['ID_VENDOR_FIX'];
			$this->data['TERM_OF_PAYMENT'] = $hasil['TOP'];
			$this->data['LOKASI_PENYERAHAN'] = $hasil['LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR_FIX']);
			foreach ($hasil->result() as $VENDOR):
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);


			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_spp_form_pengajuan_vendor');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_SPP = $hasil['ID_SPP'];
			$this->data['HASH_MD5_SPP'] = $HASH_MD5_SPP;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_SPP'] = $ID_SPP;
			$this->data['ID_VENDOR_FIX'] = $hasil['ID_VENDOR_FIX'];
			$this->data['TERM_OF_PAYMENT'] = $hasil['TOP'];
			$this->data['LOKASI_PENYERAHAN'] = $hasil['LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR_FIX']);
			foreach ($hasil->result() as $VENDOR):
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['SPP'] = $this->SPP_model->spp_list_spp_by_hashmd5($HASH_MD5_SPP);


			$this->data['rasd_barang_list'] = $this->SPP_form_model->rasd_form_list_where_not_in_spp($ID_SPP);
			$this->data['barang_master_list'] = $this->SPP_form_model->barang_master_where_not_in_spp_and_rasd($ID_SPP);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_spp_form_pengajuan_vendor');
		} else {
			$this->logout();
		}
	}

	function proses_upload_file()
	{

		$HASH_MD5_SPP = $this->session->userdata('HASH_MD5_SPP');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in()) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_SPP . '_';
			$config['upload_path'] = './assets/upload_spp_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_spp = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPP = $query_id_spp['ID_RFQ'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_spp_form_file/' . $nama;
				$this->db->insert('spp_form_file', array('ID_SPP' => $ID_SPP, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_SPP' => $HASH_MD5_SPP, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		}else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
		}
	}

	function proses_upload_file_excel_bulk_spp()
	{

		$HASH_MD5_SPP = $this->session->userdata('HASH_MD5_SPP');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in()) {

			$WAKTU = date('Y-m-d H:i:s');
			$nama_file = "excel_" . $HASH_MD5_SPP;
			$config['upload_path'] = './assets/upload_spp_form_excel/';
			$config['allowed_types'] = 'xlsx';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_spp = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPP = $query_id_spp['ID_SPP'];

			if (file_exists($file = './assets/upload_spp_form_excel/' .$nama_file.".xlsx")) {
				unlink($file);
			}

			if ($this->upload->do_upload('userfile')) {
				$ID_SPP = $this->input->post('ID_SPP');	

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

						$inserdata['JUMLAH_BARANG'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						if(strstr($inserdata['JUMLAH_BARANG'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['JUMLAH_BARANG'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['JUMLAH_BARANG'], ";")){
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

						$inserdata['ID_VENDOR_FIX'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
						if(strstr($inserdata['ID_VENDOR_FIX'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['ID_VENDOR_FIX'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['ID_VENDOR_FIX'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['HARGA_SATUAN_BARANG_FIX'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
						if(strstr($inserdata['HARGA_SATUAN_BARANG_FIX'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['HARGA_SATUAN_BARANG_FIX'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['HARGA_SATUAN_BARANG_FIX'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['JENIS_PEMBELIAN'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
						if(strstr($inserdata['JENIS_PEMBELIAN'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['JENIS_PEMBELIAN'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['JENIS_PEMBELIAN'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['KETERANGAN_UMUM'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
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

						$inserdata['ID_SPP_FORM'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
						if(strstr($inserdata['ID_SPP_FORM'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['ID_SPP_FORM'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['ID_SPP_FORM'], ";")){
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
							$inserdata['JUMLAH_BARANG'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
							$inserdata['SATUAN_BARANG'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
							$inserdata['ID_VENDOR_FIX'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
							$inserdata['HARGA_SATUAN_BARANG_FIX'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
							$inserdata['JENIS_PEMBELIAN'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
							$inserdata['KETERANGAN_UMUM'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
							$inserdata['ID_SPP_FORM'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

							$HARGA_TOTAL_FIX = $inserdata['JUMLAH_BARANG'] * $inserdata['HARGA_SATUAN_BARANG_FIX'];

							$data = $this->SPP_form_model->update_data_from_excel(
								$ID_SPP,
								$inserdata['ID_SPP_FORM'],
								$inserdata['NAMA_BARANG'],
								$inserdata['MEREK'],
								$inserdata['SPESIFIKASI_SINGKAT'],
								$inserdata['JUMLAH_BARANG'],
								$inserdata['SATUAN_BARANG'],
								$inserdata['ID_VENDOR_FIX'],
								$inserdata['HARGA_SATUAN_BARANG_FIX'],
								$HARGA_TOTAL_FIX,
								$inserdata['JENIS_PEMBELIAN'],
								$inserdata['KETERANGAN_UMUM']
							);

							$data_2 = $this->SPP_form_model->get_data_by_id_spp_form($inserdata['ID_SPP_FORM']);
							$ID_SPPB_FORM = $data_2['ID_SPPB_FORM'];
							$ID_RAB_FORM = $data_2['ID_RAB_FORM'];
							$ID_RASD_FORM = $data_2['ID_RASD_FORM'];
							$ID_SPP = $data_2['ID_SPP'];
							$ID_SPP_FORM = $data_2['ID_SPP_FORM'];
							$SATUAN_BARANG = $data_2['SATUAN_BARANG'];
							$JUMLAH_BARANG = $data_2['JUMLAH_BARANG'];
							$HARGA_SATUAN_BARANG_FIX = $data_2['HARGA_SATUAN_BARANG_FIX'];
							$HARGA_TOTAL_FIX = $data_2['HARGA_TOTAL_FIX'];

							//TAMBAHKAN ATAU CEK RASD REALISASI
							if ($this->SPP_form_model->cek_rasd_realiasi_by_id_spp_form($ID_SPP_FORM ) == 'BELUM ADA ITEM')
							{
								$data_3 = $this->SPP_form_model->simpan_rasd_realisasi(
									$ID_RAB_FORM, 
									$ID_RASD_FORM, 
									$ID_SPP, 
									$ID_SPP_FORM, 
									$SATUAN_BARANG, 
									$JUMLAH_BARANG,
									$HARGA_SATUAN_BARANG_FIX, 
									$HARGA_TOTAL_FIX
								);
							}
							else
							{
								$data_4 = $this->SPP_form_model->update_rasd_realisasi(
									$ID_RAB_FORM,
									$ID_RASD_FORM,
									$ID_SPP,
									$ID_SPP_FORM,
									$SATUAN_BARANG,
									$JUMLAH_BARANG,
									$HARGA_SATUAN_BARANG_FIX,
									$HARGA_TOTAL_FIX
								);
							}

							//UPDATE KE SPPB FORM
							$hasil_5 = $this->SPP_form_model->data_jumlah_qty_spp_by_id_sppb_form($ID_SPPB_FORM);
							$JUMLAH_QTY_SPP = $hasil_5['JUMLAH_QTY_SPP'];

							$hasil_6 = $this->SPP_form_model->data_jumlah_realisasi_by_id_sppb_form($ID_SPPB_FORM);
							$JUMLAH_REALISASI_SPP = $hasil_6['JUMLAH_REALISASI_SPP'];

							if ($JUMLAH_REALISASI_SPP < $JUMLAH_QTY_SPPB)
							{
								$data_7 = $this->SPP_form_model->update_status_id_sppb_form_incomplete($ID_SPPB_FORM);
							}

							if ($JUMLAH_REALISASI_SPP == $JUMLAH_QTY_SPPB)
							{
								$data_8 = $this->SPP_form_model->update_status_id_sppb_form_complete($ID_SPPB_FORM);
							}

							//BELUM ADA CEGATAN JUMLAH MAKSIMAL
						}
					}
				}
			}

			if (file_exists($file = './assets/upload_sppb_form_excel/' .$nama_file.".xlsx")) {
				unlink($file);
			}

		} else {
			// alihkan mereka ke halaman sppb list
			redirect('SPPB', 'refresh');
		}
	}

	function download_excel()
	{

		//jika mereka sudah login
		if ($this->ion_auth->logged_in()) {
			$HASH_MD5_SPP = $this->uri->segment(3);

			if ($this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP) == 'TIDAK ADA DATA') {
				redirect('SPP', 'refresh');
			}

			$hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
			$ID_SPP = $hasil['ID_SPP'];

			$objPHPExcel    =   new PHPExcel();
			// $result         =   $db->query("SELECT * FROM countries") or die(mysql_error());

			$data_spp_form = $this->SPP_form_model->spp_form_list_by_id_spp_kirim_SPP($ID_SPP);
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Nama Barang/Jasa');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Merek Barang/Jasa');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Spesifikasi Singkat');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Jumlah Yang Diadakan');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Satuan Barang');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'ID Supplier/Vendor');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Harga Satuan Barang');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Jenis Pembelian');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Keterangan');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'ID SPP FORM');

			$objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true);
			
			$rowCount   =   2;
			foreach ($data_spp_form as $SPP):
				//var_dump($SPP->NAMA_BARANG);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $SPP->NAMA_BARANG);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $SPP->MEREK);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $SPP->SPESIFIKASI_SINGKAT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $SPP->JUMLAH_BARANG);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $SPP->SATUAN_BARANG);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $SPP->ID_VENDOR_FIX);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $SPP->HARGA_SATUAN_BARANG_FIX);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $SPP->JENIS_PENGADAAN);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $SPP->KETERANGAN_UMUM);
				$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $SPP->ID_SPP_FORM);
				$rowCount++;
			endforeach;
			
			
			$objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);
			// var_dump($objPHPExcel);

			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="bulk_spp_'.$HASH_MD5_SPP.'.xlsx"');
			header('Cache-Control: max-age=0'); //no cache
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
			$objWriter->save('php://output');

		} else {
			// alihkan mereka ke halaman sppb list
			redirect('SPP', 'refresh');
		}

	}

	function download_excel_vendor()
	{
		//jika mereka sudah login
		if ($this->ion_auth->logged_in()) {

			
			$objPHPExcel = new PHPExcel();

			$data_vendor = $this->Vendor_model->vendor_list();
			
			$objPHPExcel->setActiveSheetIndex(0);
			
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Nama Vendor');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Alamat');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'ID Vendor');

			$objPHPExcel->getActiveSheet()->getStyle("A1:C1")->getFont()->setBold(true);
			
			$rowCount   =   2;
			foreach ($data_vendor as $VENDOR):
				//var_dump($SPP->NAMA_BARANG);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $VENDOR->NAMA_VENDOR);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $VENDOR->ALAMAT_VENDOR);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $VENDOR->ID_VENDOR );
				$rowCount++;
			endforeach;
			
			
			$objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);
			// var_dump($objPHPExcel);

			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="list_vendor.xlsx"');
			header('Cache-Control: max-age=0'); //no cache
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
			$objWriter->save('php://output');

		} else {
			// alihkan mereka ke halaman sppb list
			redirect('SPP', 'refresh');
		}

	}
}