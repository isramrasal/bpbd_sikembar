<?php defined('BASEPATH') or exit('No direct script access allowed');

class Rencana_Pengiriman_Barang_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Form RPB';

		$this->load->model('PO_model');
		$this->load->model('PO_form_model');
		$this->load->model('Vendor_model');
		$this->load->model('Barang_master_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('SPP_model');
		$this->load->model('PO_Form_File_Model');
		$this->load->model('Rencana_pengiriman_barang_model');
		$this->load->model('Rencana_pengiriman_barang_form_models');
		$this->load->model('Term_Of_Payment_model');
		$this->load->model('Proyek_model');
		$this->load->model('RPB_form_file_model');


		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "RPB_form_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses SPPB";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Rencana_pengiriman_barang_form_models->user_log_rpb_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Rencana_pengiriman_barang_form_models->user_log_rpb_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index()
	{
		$HASH_MD5_RENCANA_PENGIRIMAN_BARANG = $this->uri->segment(3);
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_kasie_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {

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
			$this->data['username'] = $user->username;
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

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$ID_PO = $hasil['ID_PO'];
			$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
			$ID_PROYEK = $hasil['ID_PROYEK'];
			$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PROYEK'] = $ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $hasil['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'];
			$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

			$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
			if ($hasil2 == 'BELUM ADA VENDOR') {
				$this->data['NAMA_PIC_VENDOR'] = " ";
				$this->data['EMAIL_PIC_VENDOR'] = " ";
				$this->data['NO_HP_PIC_VENDOR'] = " ";
				$this->data['NAMA_VENDOR'] = " ";
				$this->data['ALAMAT_VENDOR'] = " ";
				$this->data['NO_TELP_VENDOR'] = " ";
				$this->data['EMAIL_VENDOR'] = " ";
			} else {
				$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
				$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
				$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
				$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
				$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
				$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
				$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
			}

			$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);
			$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

			$this->load->view('wasa/user_vendor/head_normal', $this->data);
			$this->load->view('wasa/user_vendor/user_menu');
			$this->load->view('wasa/user_vendor/left_menu');
			$this->load->view('wasa/user_vendor/header_menu');
			$this->load->view('wasa/user_vendor/content_rencana_pengiriman_barang_form_proses');
			$this->load->view('wasa/user_vendor/footer');
		} else {
			$this->logout();
		}
	}

	function data_rpb_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {
			$id = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RPB Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			// $ID_SPPB_FORM = $this->input->get('id');
			// $data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			// echo json_encode($data);

			// $KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			// $this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {
			$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->get('id');
			$data = $this->Rencana_pengiriman_barang_form_models->get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_nama_vendor()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_VENDOR = $this->input->get('ID_VENDOR');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);

			$KETERANGAN = "Get Nama Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function update_data_jumlah_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG_KIRIM', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang Yang Dikirim', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG_FORM = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG_FORM');
				$JUMLAH_BARANG_KIRIM = $this->input->post('JUMLAH_BARANG_KIRIM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				$data_edit = $this->Rencana_pengiriman_barang_form_models->get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM);
				$KETERANGAN = "Ubah Data Jumlah RPB Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG_FORM . ";" . $JUMLAH_BARANG_KIRIM;
				$this->user_log($KETERANGAN);

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function simpan_perubahan_pdf()
	{
		$user = $this->ion_auth->user()->row();
		$this->data['USER_ID'] = $user->id;
		$CREATE_BY_USER =  $this->data['USER_ID'];

		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'Nomor Handphone Pengirim', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TUJUAN', 'Tujuan', 'trim|max_length[255]|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');
				$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
				$KEPADA = $this->input->post('KEPADA');
				$TUJUAN = $this->input->post('TUJUAN');
				$PROGRESS_RPB = 'Draft';

				$data_edit = $this->rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
				$KETERANGAN = "Ubah Data SPP Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG . ";" . $NAMA_PENGIRIM . ";" . $KEPADA . ";" . $TUJUAN . ";" . $PROGRESS_RPB;
				$this->user_log($KETERANGAN);

				$data = $this->rencana_pengiriman_barang_form_models->simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else {
			$this->logout();
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

		//get data tabel users untuk ditampilkan
		$user = $this->ion_auth->user()->row();
		$this->data['ID_VENDOR'] = $user->ID_VENDOR;
		$user = $this->ion_auth->user()->row();
		$this->data['user_id'] = $user->id;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
		$this->data['role_user'] = $data_role_user['description'];
		$this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['username'] = $user->username;
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

		$HASH_MD5_RENCANA_PENGIRIMAN_BARANG = $this->uri->segment(3);
		if ($this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG) == 'TIDAK ADA DATA') {
			redirect('Rencana_Pengiriman_Barang', 'refresh');
		}


		if ($this->ion_auth->logged_in()) {

			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_RENCANA_PENGIRIMAN_BARANG = $this->uri->segment(3);

			if ($this->ion_auth->in_group(38)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_vendor/head_normal', $this->data);
				$this->load->view('wasa/user_vendor/user_menu');
				$this->load->view('wasa/user_vendor/left_menu');
				$this->load->view('wasa/user_vendor/header_menu');
				$this->load->view('wasa/user_vendor/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_vendor/footer');
			} else if ($this->ion_auth->in_group(5)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(6)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(7)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(8)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(9)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(10)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(11)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_kasie_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(12)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_manajer_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(13)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
			} else if ($this->ion_auth->in_group(15)) {
				$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
				$sess_data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);

				$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
				$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $this->Rencana_pengiriman_barang_model->rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);

				foreach ($this->data['RPB']->result() as $RPB) :
					$this->data['FILE_NAME_TEMP'] = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG . '.pdf';
					$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
					$this->data['HASH_MD5_RENCANA_PENGIRIMAN_BARANG'] = $RPB->HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
					$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
					$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
				endforeach;

				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_rencana_pengiriman_barang_form');
				$this->load->view('wasa/user_supervisi_logistik_sp/footer');
			} else {
				redirect('Rencana_Pengiriman_Barang', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	public function cetak_pdf($HASH_MD5_RENCANA_PENGIRIMAN_BARANG)
	{
		$hasil = $this->Rencana_pengiriman_barang_model->get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
		$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
		$this->data['RPB'] = $this->Rencana_pengiriman_barang_model->rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG);
		foreach ($this->data['RPB']->result() as $RPB) :
			$this->data['ID_RENCANA_PENGIRIMAN_BARANG'] = $RPB->ID_RENCANA_PENGIRIMAN_BARANG;
			$this->data['NO_RENCANA_PENGIRIMAN_BARANG'] = $RPB->NO_RENCANA_PENGIRIMAN_BARANG;
			$this->data['ID_PO'] = $RPB->ID_PO;
			$this->data['NO_URUT_PO'] = $RPB->NO_URUT_PO;
			$this->data['ID_PROYEK'] = $RPB->ID_PROYEK;
			$this->data['KEPADA'] = $RPB->KEPADA;
			$this->data['TUJUAN'] = $RPB->TUJUAN;
			$this->data['STATUS_RPB'] = $RPB->STATUS_RPB;
			$this->data['PROGRESS_RPB'] = $RPB->PROGRESS_RPB;
			$this->data['NAMA_PENGIRIM'] = $RPB->NAMA_PENGIRIM;
			$this->data['NO_HP_PENGIRIM'] = $RPB->NO_HP_PENGIRIM;
			$this->data['TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI'] = $RPB->TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI;
		endforeach;

		$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
		if ($hasil2 == 'BELUM ADA VENDOR') {
			$this->data['NAMA_PIC_VENDOR'] = " ";
			$this->data['EMAIL_PIC_VENDOR'] = " ";
			$this->data['NO_HP_PIC_VENDOR'] = " ";
			$this->data['NAMA_VENDOR'] = " ";
			$this->data['ALAMAT_VENDOR'] = " ";
			$this->data['NO_TELP_VENDOR'] = " ";
			$this->data['EMAIL_VENDOR'] = " ";
		} else {
			$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
			$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
			$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
			$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
			$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
			$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
			$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
		}

		// var_dump($ID_VENDOR);
		// if ($ID_VENDOR == "0" || $ID_VENDOR == NULL) {
		// 	$this->data['NAMA_VENDOR'] = "";
		// } else {
		// 	$hasil = $this->Vendor_model->vendor_list_by_id_vendor($ID_VENDOR);
		// 	foreach ($hasil->result() as $VENDOR) :
		// 		$NAMA_VENDOR = $VENDOR->NAMA_VENDOR;
		// 	endforeach;
		// 	$this->data['NAMA_VENDOR'] = $NAMA_VENDOR;
		// }


		//$this->data['CATATAN_FPB'] = $this->FPB_form_model->get_data_catatan_FPB_by_id_fpb($ID_FPB);

		//$this->data['rasd_barang_list'] = $this->FPB_form_model->rasd_form_list_where_not_in_fpb($ID_FPB);
		//$this->data['barang_master_list'] = $this->FPB_form_model->barang_master_where_not_in_fpb_and_rasd($ID_FPB);
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

		$this->data['konten_RPB_form'] = $this->Rencana_pengiriman_barang_form_models->rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG);
		// $this->data['USER_PENGAJU'] = $this->FPB_form_model->ID_JABATAN_BY_ID_FPB($ID_FPB);

		// foreach ($this->data['FPB']->result() as $FPB) :
		// 	$FILE_NAME_TEMP = $FPB->FILE_NAME_TEMP;
		// 	$this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
		// endforeach;

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Rencana Pengiriman Barang';

		// filename dari pdf ketika didownload
		$file_pdf = 'rpb_' . $HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "landscape";

		$html = $this->load->view('wasa/pdf/rpb_pdf', $this->data, true);

		//run dompdf
		$x          = 500;
		$y          = 800;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 10;

		$file_path = "assets/RPB/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	function update_data_kirim_rpb()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {
			//set validation rules
			$this->form_validation->set_rules('ID_RENCANA_PENGIRIMAN_BARANG', 'ID_RENCANA_PENGIRIMAN_BARANG ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RENCANA_PENGIRIMAN_BARANG = $this->input->post('ID_RENCANA_PENGIRIMAN_BARANG');

				$KETERANGAN = "Kirim Form RPB ke Proses Selanjutnya: " . " ---- " . $ID_RENCANA_PENGIRIMAN_BARANG;
				$this->user_log($KETERANGAN);

				$PROGRESS_RPB = "RPB Diterima";
				$STATUS_RPB = "SELESAI";

				$data = $this->Rencana_pengiriman_barang_form_models->update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB);
				echo json_encode($data);
			}
		} else {
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
}
