<?php defined('BASEPATH') or exit('No direct script access allowed');

class SPPB_form_cek_gudang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Form SPPB';

		$this->load->model('Barang_master_model');
		$this->load->model('SPPB_form_model');
		$this->load->model('SPPB_model');
		$this->load->model('Proyek_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('SPPB_Form_File_Model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "rasd_barang_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses SPPB Cek Gudang";
		$WAKTU = date('Y-m-d H:i:s');
		$this->SPPB_form_model->user_log_sppb_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->SPPB_form_model->user_log_sppb_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_SPPB = $this->uri->segment(3);
		if ($this->SPPB_model->get_id_proyek_by_HASH_MD5_SPPB($HASH_MD5_SPPB) == 'TIDAK ADA DATA') {
			redirect('SPPB', 'refresh');
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_SPPB = $this->uri->segment(3);
			$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$ID_SPPB = $hasil['ID_SPPB'];
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);

			$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
			$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_sppb_form_proses');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Chief") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_chief_sp/head_normal', $this->data);
				$this->load->view('wasa/user_chief_sp/user_menu');
				$this->load->view('wasa/user_chief_sp/left_menu');
				$this->load->view('wasa/user_chief_sp/header_menu');
				$this->load->view('wasa/user_chief_sp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses SM") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
				$this->load->view('wasa/user_sm_sp/user_menu');
				$this->load->view('wasa/user_sm_sp/left_menu');
				$this->load->view('wasa/user_sm_sp/header_menu');
				$this->load->view('wasa/user_sm_sp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses PM") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
				$this->load->view('wasa/user_pm_sp/user_menu');
				$this->load->view('wasa/user_pm_sp/left_menu');
				$this->load->view('wasa/user_pm_sp/header_menu');
				$this->load->view('wasa/user_pm_sp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$this->load->view('wasa/content_error_not_found', $this->data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			redirect('SPPB', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			redirect('SPPB', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			redirect('SPPB', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			redirect('SPPB', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_SPPB = $this->uri->segment(3);
			$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$ID_SPPB = $hasil['ID_SPPB'];
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);

			$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
			$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_staff_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_logistik_kp/content_sppb_form_proses');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_SPPB = $this->uri->segment(3);
			$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$ID_SPPB = $hasil['ID_SPPB'];
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);

			$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
			$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_sppb_form_proses');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Staff Umum Logistik SP") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_SPPB = $this->uri->segment(3);
			$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$ID_SPPB = $hasil['ID_SPPB'];
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

			$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
			$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/content_sppb_form_proses');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Supervisi Logistik SP") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_hrd_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_hrd_kp/user_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/left_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/header_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_keuangan_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_keuangan_kp/user_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/left_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/header_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_konstruksi_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_konstruksi_kp/user_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/left_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/header_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_sdm_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_sdm_kp/user_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/left_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/header_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_qaqc_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_qaqc_kp/user_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/left_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/header_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_ep_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_ep_kp/user_menu');
				$this->load->view('wasa/user_manajer_ep_kp/left_menu');
				$this->load->view('wasa/user_manajer_ep_kp/header_menu');
				$this->load->view('wasa/user_manajer_ep_kp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Direksi") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_direktur_keuangan_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_keuangan_kp/user_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/left_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/header_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Direksi") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_direktur_psds_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_psds_kp/user_menu');
				$this->load->view('wasa/user_direktur_psds_kp/left_menu');
				$this->load->view('wasa/user_direktur_psds_kp/header_menu');
				$this->load->view('wasa/user_direktur_psds_kp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$hasil_2 = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Direksi") {
				$HASH_MD5_SPPB = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;

				$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
				$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_direktur_konstruksi_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_konstruksi_kp/user_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/left_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/header_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/content_sppb_form_proses');
			} else {
				redirect('SPPB', 'refresh');
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(5))) {
		// 	//fungsi ini untuk mengirim data ke dropdown
		// 	$HASH_MD5_SPPB = $this->uri->segment(3);
		// 	$hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
		// 	$ID_SPPB = $hasil['ID_SPPB'];
		// 	$this->data['ID_SPPB'] = $ID_SPPB;
		// 	$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
		// 	$this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);

		// 	$this->data['rasd_barang_list'] = $this->SPPB_form_model->rasd_form_list_where_not_in_sppb($ID_SPPB);
		// 	$this->data['barang_master_list'] = $this->SPPB_form_model->barang_master_where_not_in_sppb_and_rasd($ID_SPPB);
		// 	$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		// 	$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

		// 	if ($this->ion_auth->in_group(13)) {
		// 		$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
		// 		$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
		// 		$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
		// 		$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
		// 		$this->load->view('wasa/user_staff_umum_logistik_sp/content_sppb_form_proses');
		// 	} else if ($this->ion_auth->in_group(3)) {
		// 		$this->load->view('wasa/user_supervisor_logistik/head_normal', $this->data);
		// 		$this->load->view('wasa/user_supervisor_logistik/user_menu');
		// 		$this->load->view('wasa/user_supervisor_logistik/left_menu');
		// 		$this->load->view('wasa/user_supervisor_logistik/header_menu');
		// 		$this->load->view('wasa/user_supervisor_logistik/content_sppb_form_proses');
		// 	} else if ($this->ion_auth->in_group(5)) {
		// 		$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
		// 		$this->load->view('wasa/user_staff_procurement_kp/user_menu');
		// 		$this->load->view('wasa/user_staff_procurement_kp/left_menu');
		// 		$this->load->view('wasa/user_staff_procurement_kp/header_menu');
		// 		$this->load->view('wasa/user_staff_procurement_kp/content_sppb_form_proses');
		// 	}
		// } 
		else {
			$this->logout();
		}
	}

	function data_sppb_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$id = $this->input->get('id');
			$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(5))) {
		// 	$id = $this->input->get('id');
		// 	$data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
		// 	echo json_encode($data);

		// 	$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
		// 	$this->user_log($KETERANGAN);
		// } 
		else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(5))) {
		// 	$ID_SPPB_FORM = $this->input->get('id');
		// 	$data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
		// 	echo json_encode($data);

		// 	$KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
		// 	$this->user_log($KETERANGAN);
		// } 
		else {
			$this->logout();
		}
	}

	function get_data_catatan_sppb()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(5))) {
		// 	$ID_SPPB = $this->input->get('id');
		// 	$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
		// 	echo json_encode($data);

		// 	$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
		// 	$this->user_log($KETERANGAN);
		// } 
		else {
			$this->logout();
		}
	}

	function get_data_ctt_sppb()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_CHIEF($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_SM($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_PM($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_M_PROC($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_M_LOG($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_STAFF_LOG($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_STAFF_LOG($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_SPV_LOG($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_M_HRD($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_M_KEU($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_M_KONS($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_M_SDM($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_M_QAQC($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_M_EP($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_D_KEU($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_D_PSDS($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
			$data = $this->SPPB_model->get_data_CTT_D_KONS($HASH_MD5_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(5))) {
		// 	$ID_SPPB = $this->input->get('id');
		// 	$data = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
		// 	echo json_encode($data);

		// 	$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
		// 	$this->user_log($KETERANGAN);
		// } 
		else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		}  else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(5))) {
		// 	$ID_SPPB_FORM = $this->input->post('kode');
		// 	$data_hapus = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);

		// 	$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
		// 	$this->user_log($KETERANGAN);

		// 	$data = $this->SPPB_form_model->hapus_data_by_id_sppb_form($ID_SPPB_FORM);
		// 	echo json_encode($data);
		// } 
		else {
			$this->logout();
		}
	}

	function simpan_data_dari_rasd_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->SPPB_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(5))) {

		// 	$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
		// 	$ID_SPPB = $this->input->post('ID_SPPB');
		// 	foreach ($ID_RASD_FORM as $index => $value_rasd) {
		// 		$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
		// 		if ($data->ID_BARANG_MASTER == "") {
		// 			$id_master = 'NULL';
		// 		} else {
		// 			$id_master = $data->ID_BARANG_MASTER;
		// 		}
		// 		$jumlah = $this->input->post($value_rasd);
		// 		$this->SPPB_form_model->simpan_data_dari_rasd_form(
		// 			$ID_SPPB,
		// 			$id_master,
		// 			$value_rasd,
		// 			$data->ID_SATUAN_BARANG,
		// 			$data->ID_JENIS_BARANG,
		// 			$data->NAMA,
		// 			$data->MEREK,
		// 			$data->SPESIFIKASI_SINGKAT,
		// 			$jumlah
		// 		);
		// 		$KETERANGAN = "Tambah Data SPPB Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
		// 		$this->user_log($KETERANGAN);
		// 	}
		// 	redirect($_SERVER['HTTP_REFERER']);
		// } 
		else {
			$this->logout();
		}
	}

	function simpan_data_dari_barang_master()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->SPPB_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(5))) {

		// 	$ID_SPPB = $this->input->post('ID_SPPB');
		// 	$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
		// 	foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
		// 		$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
		// 		if ($data->ID_RASD_FORM == "") {
		// 			$id_rasd = 'NULL';
		// 		} else {
		// 			$id_rasd = $data->ID_RASD_FORM;
		// 		}
		// 		$jumlah = $this->input->post($ID_MASTER);
		// 		$this->SPPB_form_model->simpan_data_dari_barang_master(
		// 			$ID_SPPB,
		// 			$ID_MASTER,
		// 			$id_rasd,
		// 			$data->ID_SATUAN_BARANG,
		// 			$data->ID_JENIS_BARANG,
		// 			$data->NAMA,
		// 			$data->MEREK,
		// 			$data->SPESIFIKASI_SINGKAT,
		// 			$jumlah
		// 		);
		// 		$KETERANGAN = "Tambah Data SPPB Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
		// 		$this->user_log($KETERANGAN);
		// 	}
		// 	redirect($_SERVER['HTTP_REFERER']);
		// } 
		else {
			$this->logout();
		}
	}

	function simpan_data_di_luar_barang_master()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		}  else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
					$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Sppb Barang sudah terekam sebelumnya';
				}
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(5))) {

		// 	//set validation rules
		// 	$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
		// 	$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
		// 	$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required');
		// 	$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
		// 	$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
		// 	$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
		// 	// run validation check
		// 	if ($this->form_validation->run() == FALSE) {   //validation fails
		// 		echo validation_errors();
		// 	} else {
		// 		$ID_SPPB = $this->input->post('ID_SPPB');
		// 		$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
		// 		$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
		// 		$ID_BARANG_MASTER = 'NULL';
		// 		$ID_RASD_FORM = 'NULL';
		// 		$NAMA = $this->input->post('NAMA');
		// 		$MEREK = $this->input->post('MEREK');
		// 		$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
		// 		$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

		// 		//check apakah nama SPPB_form sudah ada. jika belum ada, akan disimpan.
		// 		if ($this->SPPB_form_model->cek_nama_barang_sppb_form($NAMA) == 'Data belum ada') {
		// 			$data = $this->SPPB_form_model->simpan_data_di_luar_barang_master(
		// 				$ID_SPPB,
		// 				$ID_BARANG_MASTER,
		// 				$ID_RASD_FORM,
		// 				$ID_SATUAN_BARANG,
		// 				$ID_JENIS_BARANG,
		// 				$NAMA,
		// 				$MEREK,
		// 				$SPESIFIKASI_SINGKAT,
		// 				$JUMLAH_MINTA
		// 			);

		// 			$KETERANGAN = "Tambah Data SPPB Form (di luar barang master dan RASD): " . ";" . $ID_SPPB  . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
		// 			$this->user_log($KETERANGAN);
		// 		} else {
		// 			echo 'Nama Sppb Barang sudah terekam sebelumnya';
		// 		}
		// 	}
		// } 
		else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');
				$JUMLAH_SETUJU_M_LOG = $this->input->post('JUMLAH_SETUJU_M_LOG');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				// $JUMLAH_SETUJU_M_LOG = $JUMLAH_SETUJU_M_LOG;

				$data = $this->SPPB_form_model->update_data_M_LOG($ID_SPPB_FORM, $JUMLAH_MINTA, $JUMLAH_SETUJU_M_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(5))) {

		// 	//set validation rules
		// 	$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE) {   //validation fails
		// 		echo json_encode(validation_errors());
		// 	} else {
		// 		//get the form data
		// 		$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
		// 		$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

		// 		$data_edit = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
		// 		$KETERANGAN = "Ubah Data SPPB Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
		// 		$this->user_log($KETERANGAN);

		// 		$data = $this->SPPB_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
		// 		echo json_encode($data);
		// 	}
		// } 
		else {
			$this->logout();
		}
	}

	function update_data_justifikasi_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG5', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_justifikasi_barang($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_SVP_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_SVP_LOG = $this->input->post('JUSTIFIKASI_SVP_LOG');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_SVP_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_SVP_LOG($ID_SPPB_FORM, $JUSTIFIKASI_SVP_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_SDM', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_SDM = $this->input->post('JUSTIFIKASI_SDM');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Manajer SDM): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_SDM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_SDM($ID_SPPB_FORM, $JUSTIFIKASI_SDM);
				echo json_encode($data);
			}
		}else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_justifikasi_by_id_sppb_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI SPPB Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_catatan_sppb()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_LOG', 'Catatan SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_STAFF_LOG = $this->input->post('CTT_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_catatan_sppb($ID_SPPB, $CTT_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_CHIEF', 'Catatan SPPB CHIEF', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_CHIEF = $this->input->post('CTT_CHIEF');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User CHIEF): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_CHIEF($ID_SPPB, $CTT_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_SM', 'Catatan SPPB SM', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_SM = $this->input->post('CTT_SM');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User SM): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_SM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_SM($ID_SPPB, $CTT_SM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_PM', 'Catatan SPPB PM', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_PM = $this->input->post('CTT_PM');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User PM): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_PM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_PM($ID_SPPB, $CTT_PM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_CHIEF', 'Catatan SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_CHIEF = $this->input->post('CTT_CHIEF');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User SUpervisor logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_CHIEF($ID_SPPB, $CTT_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_M_PROC', 'Catatan Manajer Procurement', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_PROC = $this->input->post('CTT_M_PROC');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Manajer Procurement): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_PROC;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_M_PROC($ID_SPPB, $CTT_M_PROC);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_CHIEF', 'Catatan SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_CHIEF = $this->input->post('CTT_CHIEF');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User SUpervisor logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_CHIEF($ID_SPPB, $CTT_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_M_LOG', 'Catatan SPPB Manajer Logistik', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_LOG = $this->input->post('CTT_M_LOG');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Manajer Logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_M_LOG($ID_SPPB, $CTT_M_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_LOG', 'Catatan SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_STAFF_LOG = $this->input->post('CTT_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_STAFF_LOG($ID_SPPB, $CTT_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_LOG', 'Catatan SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_STAFF_LOG = $this->input->post('CTT_STAFF_LOG');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_STAFF_LOG($ID_SPPB, $CTT_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_SPV_LOG', 'Catatan SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_SPV_LOG = $this->input->post('CTT_SPV_LOG');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_SPV_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_SPV_LOG($ID_SPPB, $CTT_SPV_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_M_HRD', 'Catatan SPPB Manajer HRD', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_HRD = $this->input->post('CTT_M_HRD');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Manajer HRD): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_HRD;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_M_HRD($ID_SPPB, $CTT_M_HRD);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_M_KEU', 'Catatan SPPB Manajer Keuangan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_KEU = $this->input->post('CTT_M_KEU');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Manajer Keuangan): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_KEU;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_M_KEU($ID_SPPB, $CTT_M_KEU);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_M_KONS', 'Catatan SPPB Manajer Konstruksi', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_KONS = $this->input->post('CTT_M_KONS');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Manajer Konstruksi): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_KONS;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_M_KONS($ID_SPPB, $CTT_M_KONS);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_M_SDM', 'Catatan SPPB Manajer SDM', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_SDM = $this->input->post('CTT_M_SDM');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Manajer SDM): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_SDM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_M_SDM($ID_SPPB, $CTT_M_SDM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_M_QAQC', 'Catatan SPPB Manajer QAQC', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_QAQC = $this->input->post('CTT_M_QAQC');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Manajer QAQC): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_QAQC;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_M_QAQC($ID_SPPB, $CTT_M_QAQC);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_M_EP', 'Catatan SPPB Manajer EP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_EP = $this->input->post('CTT_M_EP');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Manajer EP): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_EP;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_M_EP($ID_SPPB, $CTT_M_EP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_D_KEU', 'Catatan SPPB Direktur Keuangan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_D_KEU = $this->input->post('CTT_D_KEU');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Direktur Keuangan): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_D_KEU;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_D_KEU($ID_SPPB, $CTT_D_KEU);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_D_PSDS', 'Catatan SPPB Direktur PSDS', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_D_PSDS = $this->input->post('CTT_D_PSDS');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Direktur PSDS): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_D_PSDS;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_D_PSDS($ID_SPPB, $CTT_D_PSDS);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_D_KONS', 'Catatan SPPB Direktur Konstruksi', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_D_KONS = $this->input->post('CTT_D_KONS');

				$data_edit = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan SPPB (User Direktur Konstruksi): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_D_KONS;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_CTT_D_KONS($ID_SPPB, $CTT_D_KONS);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_kirim_sppb()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Chief (User Staff logistik): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Chief";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke SM (User Chief): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses SM";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke PM (User SM): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses PM";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB Manajer Kantor Pusat (User PM): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Manajer Kantor Pusat";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Proses Selanjutnya: " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Kasie Procurement KP";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Proses Selanjutnya: " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Kasie Procurement KP";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Manajer SDM KP (User Manajer Procurement KP): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Manajer SDM KP";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Proses Selanjutnya: " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Kasie Procurement KP";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Proses Selanjutnya: " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Kasie Procurement KP";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Proses Selanjutnya: " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Kasie Procurement KP";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Direksi (User Manajer Logistik): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Direksi";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Supervisi Logistik (User Staff Umum Logistik): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Supervisi Logistik SP";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Supervisi Logistik (User Staff Umum Logistik): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Supervisi Logistik SP";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Chief (User Staff Supervisi Logistik): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Chief";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(18) || $this->ion_auth->in_group(21) || $this->ion_auth->in_group(24) || $this->ion_auth->in_group(27) || $this->ion_auth->in_group(30) || $this->ion_auth->in_group(33))) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Level Manajer (User Manajer): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Manajer Kantor Pusat";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(34) || $this->ion_auth->in_group(36))) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form SPPB ke Direksi (User Direksi): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Direksi";
				$STATUS_SPPB = "Proses pengajuan";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "SPPB Disetujui (User Direktur PSDS): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "SPPB Disetujui";
				$STATUS_SPPB = "Selesai";

				$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_coret()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			// //set validation rules
			// $this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			// //run validation check
			// if ($this->form_validation->run() == FALSE) {   //validation fails
			// 	echo json_encode(validation_errors());
			// } else {
			// 	//get the form data
			// 	$ID_SPPB = $this->input->post('ID_SPPB');

			// 	$KETERANGAN = "Kirim Form SPPB ke Chief (User Staff logistik): "." ---- " . $ID_SPPB;
			// 	$this->user_log($KETERANGAN);

			// 	$PROGRESS_SPPB = "Dalam Proses Chief";
			// 	$STATUS_SPPB = "Proses pengajuan";

			// 	$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
			// 	echo json_encode($data);
			// }
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_batal_coret()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			// //set validation rules
			// $this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			// //run validation check
			// if ($this->form_validation->run() == FALSE) {   //validation fails
			// 	echo json_encode(validation_errors());
			// } else {
			// 	//get the form data
			// 	$ID_SPPB = $this->input->post('ID_SPPB');

			// 	$KETERANGAN = "Kirim Form SPPB ke Chief (User Staff logistik): "." ---- " . $ID_SPPB;
			// 	$this->user_log($KETERANGAN);

			// 	$PROGRESS_SPPB = "Dalam Proses Chief";
			// 	$STATUS_SPPB = "Proses pengajuan";

			// 	$data = $this->SPPB_form_model->update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
			// 	echo json_encode($data);
			// }
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB_FORM', 'ID_SPPB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User SPV logistik): " . " ---- " . $ID_SPPB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->SPPB_form_model->update_data_batal_coret($ID_SPPB_FORM);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_proses()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->SPPB_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->SPPB_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->SPPB_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->SPPB_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->SPPB_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->SPPB_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->SPPB_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_rasd_barang2', 'Nama SPPB_form', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo json_encode(validation_errors());
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$ID_RASD_FORM=$this->input->post('id_rasd_barang2');
		// 		$nama_rasd_barang=$this->input->post('nama_rasd_barang2');
		// 		$keterangan=$this->input->post('keterangan2');

		// 		//cek apakah input sama dengan eksisting
		// 		$data=$this->SPPB_form_model->get_data_by_id_rasd_barang($ID_RASD_FORM);

		// 		if($data['NAMA_RASD_BARANG'] == $nama_rasd_barang || ($this->SPPB_form_model->cek_nama_rasd_barang_by_pegawai($nama_rasd_barang, $user->ID_PEGAWAI) == 'Data belum ada'))
		// 		{
		// 			$data=$this->SPPB_form_model->get_data_by_id_rasd_barang($ID_RASD_FORM);

		// 			//log
		// 			$KETERANGAN = "Ubah SPPB_form ".$data['NAMA_RASD_BARANG']." jadi ".$nama_rasd_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->SPPB_form_model->log_SPPB_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->SPPB_form_model->update_data($ID_RASD_FORM, $nama_rasd_barang,$keterangan);
		// 			echo json_encode($data);
		// 		}
		// 		else
		// 		{
		// 			echo json_encode('Nama Sppb Barang sudah terekam sebelumnya');
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

	// TAMPILAN VIEW ONLY
	public function view()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}
		//push komentar
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

		$HASH_MD5_SPPB = $this->uri->segment(3);
		if ($this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB) == 'TIDAK ADA DATA') {
			redirect('SPPB', 'refresh');
		}


		if ($this->ion_auth->logged_in()) {

			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_SPPB = $this->uri->segment(3);

			if ($this->ion_auth->in_group(2)) { //chief_sp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_chief_sp/head_normal', $this->data);
				$this->load->view('wasa/user_chief_sp/user_menu');
				$this->load->view('wasa/user_chief_sp/left_menu');
				$this->load->view('wasa/user_chief_sp/header_menu');
				$this->load->view('wasa/user_chief_sp/content_sppb_form');
			} else if ($this->ion_auth->in_group(3)) { //sm_sp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
				$this->load->view('wasa/user_sm_sp/user_menu');
				$this->load->view('wasa/user_sm_sp/left_menu');
				$this->load->view('wasa/user_sm_sp/header_menu');
				$this->load->view('wasa/user_sm_sp/content_sppb_form');
			} else if ($this->ion_auth->in_group(4)) { //staff_proc_kp
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
				$sess_data['HASH_MD5_SPPB'] = $this->data['HASH_MD5_SPPB'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
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

				$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
				$this->load->view('wasa/user_pm_sp/user_menu');
				$this->load->view('wasa/user_pm_sp/left_menu');
				$this->load->view('wasa/user_pm_sp/header_menu');
				$this->load->view('wasa/user_pm_sp/content_sppb_form');
			} else if ($this->ion_auth->in_group(5)) { //staff_proc_kp
				$this->data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
				$sess_data['HASH_MD5_SPPB'] = $this->data['HASH_MD5_SPPB'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
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
			} else if ($this->ion_auth->in_group(6)) { //kasie_proc_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(7)) { //manajer_proc_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(8)) { //staff_proc_sp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_sppb_form');
			} else if ($this->ion_auth->in_group(9)) { //supervisi_proc_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_sppb_form');
			} else if ($this->ion_auth->in_group(10)) { //staff_log_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_staff_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_logistik_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(12)) { //manajer_logsitik_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(13)) { //staff_umum_log_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/content_sppb_form');
			} else if ($this->ion_auth->in_group(14)) { //staff_gudang_log_sp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/content_sppb_form');
			} else if ($this->ion_auth->in_group(15)) { //supervisi_log_sp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_sppb_form');
			} else if ($this->ion_auth->in_group(18)) { //user_manajer_hrd_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_hrd_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_hrd_kp/user_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/left_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/header_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(21)) { //manager_keuangan_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_keuangan_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_keuangan_kp/user_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/left_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/header_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(24)) { //manager_konstruksi_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_konstruksi_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_konstruksi_kp/user_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/left_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/header_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(27)) { //manager_sdm_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_sdm_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_sdm_kp/user_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/left_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/header_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(30)) { //manager_qaqc_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_qaqc_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_qaqc_kp/user_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/left_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/header_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(33)) { //manager_ep_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_ep_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_ep_kp/user_menu');
				$this->load->view('wasa/user_manajer_ep_kp/left_menu');
				$this->load->view('wasa/user_manajer_ep_kp/header_menu');
				$this->load->view('wasa/user_manajer_ep_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(34)) { //user_direktur_keuangan_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_direktur_keuangan_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_keuangan_kp/user_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/left_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/header_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(35)) { //user_direktur_psds_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_direktur_psds_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_psds_kp/user_menu');
				$this->load->view('wasa/user_direktur_psds_kp/left_menu');
				$this->load->view('wasa/user_direktur_psds_kp/header_menu');
				$this->load->view('wasa/user_direktur_psds_kp/content_sppb_form');
			} else if ($this->ion_auth->in_group(36)) { //user_direktur_konstruksi_kp
				$this->cetak_pdf($HASH_MD5_SPPB);

				$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

				foreach ($this->data['SPPB']->result() as $SPPB) :
					$this->data['FILE_NAME_TEMP'] = 'sppb_' . $HASH_MD5_SPPB . '.pdf';
					$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
					$this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
					$this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_direktur_konstruksi_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_konstruksi_kp/user_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/left_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/header_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/content_sppb_form');
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

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_SPPB . '_';
			$config['upload_path']   = './assets/upload_sppb_form_file/';
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
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_SPPB . '_';
			$config['upload_path']   = './assets/upload_sppb_form_file/';
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
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
		} else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
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
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
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
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
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
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
		}
	}

	public function cetak_pdf($HASH_MD5_SPPB)
	{
		$hasil = $this->SPPB_model->get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
		$ID_SPPB = $hasil['ID_SPPB'];
		$this->data['SPPB'] = $this->SPPB_model->sppb_list_sppb_by_hashmd5($HASH_MD5_SPPB);
		foreach ($this->data['SPPB']->result() as $SPPB) :
			$this->data['ID_SPPB'] = $SPPB->ID_SPPB;
			$this->data['ID_PROYEK'] = $SPPB->ID_PROYEK;
			$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
			// $this->data['TOP'] = $SPPB->TOP;
			// $this->data['LOKASI_PENYERAHAN'] = $SPPB->LOKASI_PENYERAHAN;
			// $this->data['ID_VENDOR'] = $SPPB->ID_VENDOR;
			$this->data['TANGGAL_PEMBUATAN_SPPB_HARI'] = $SPPB->TANGGAL_PEMBUATAN_SPPB_HARI;
			$this->data['TANGGAL_PEMBUATAN_SPPB_BULAN'] = $SPPB->TANGGAL_PEMBUATAN_SPPB_BULAN;
			$this->data['TANGGAL_PEMBUATAN_SPPB_TAHUN'] = $SPPB->TANGGAL_PEMBUATAN_SPPB_TAHUN;
		endforeach;

		$this->data['konten_SPPB_form'] = $this->SPPB_form_model->sppb_form_list_by_id_sppb($ID_SPPB);

		$this->data['PROYEK'] = $this->Proyek_model->detil_proyek_by_ID_PROYEK($this->data['ID_PROYEK']);
		foreach ($this->data['PROYEK']->result() as $PROYEK) :
			$this->data['NAMA_PROYEK'] = $PROYEK->NAMA_PROYEK;
		endforeach;
		// var_dump($this->data['ID_PROYEK']);

		// if ($this->data['ID_VENDOR'] == "0" || $this->data['ID_VENDOR'] == null) {
		// 	$this->data['NAMA_VENDOR'] = "";
		// 	$this->data['ALAMAT_VENDOR'] = "";
		// 	$this->data['NO_TELP_VENDOR'] = "";
		// 	$this->data['NAMA_PIC_VENDOR'] = "";
		// 	$this->data['NO_HP_PIC_VENDOR'] = "";
		// } else {
		// 	$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
		// 	foreach ($hasil->result() as $VENDOR) :
		// 		$NAMA_VENDOR = $VENDOR->NAMA_VENDOR;
		// 		$ALAMAT_VENDOR = $VENDOR->ALAMAT_VENDOR;
		// 		$NO_TELP_VENDOR = $VENDOR->NO_TELP_VENDOR;
		// 		$NAMA_PIC_VENDOR = $VENDOR->NAMA_PIC_VENDOR;
		// 		$NO_HP_PIC_VENDOR = $VENDOR->NO_HP_PIC_VENDOR;


		// 	endforeach;
		// 	$this->data['NAMA_VENDOR'] = $NAMA_VENDOR;
		// 	$this->data['ALAMAT_VENDOR'] = $ALAMAT_VENDOR;
		// 	$this->data['NO_TELP_VENDOR'] = $NO_TELP_VENDOR;
		// 	$this->data['NAMA_PIC_VENDOR'] = $NAMA_PIC_VENDOR;
		// 	$this->data['NO_HP_PIC_VENDOR'] = $NO_HP_PIC_VENDOR;
		// }


		//$this->data['CATATAN_FPB'] = $this->FPB_form_model->get_data_catatan_FPB_by_id_fpb($ID_FPB);

		//$this->data['rasd_barang_list'] = $this->FPB_form_model->rasd_form_list_where_not_in_fpb($ID_FPB);
		//$this->data['barang_master_list'] = $this->FPB_form_model->barang_master_where_not_in_fpb_and_rasd($ID_FPB);
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		// $this->data['USER_PENGAJU'] = $this->FPB_form_model->ID_JABATAN_BY_ID_FPB($ID_FPB);

		// foreach ($this->data['FPB']->result() as $FPB) :
		// 	$FILE_NAME_TEMP = $FPB->FILE_NAME_TEMP;
		// 	$this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
		// endforeach;

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
		$x          = 650;
		$y          = 750;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 10;

		$file_path = "assets/SPPB/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}
}
