<?php defined('BASEPATH') or exit('No direct script access allowed');

class PO_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Form PO';

		$this->load->model('PO_model');
		$this->load->model('PO_form_model');
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
		$this->load->model('SPP_model');
		$this->load->model('SPP_form_model');
		$this->load->model('PO_Form_File_Model');
		$this->load->model('Term_Of_Payment_model');
		$this->load->model('Proyek_model');
		$this->load->model('Pajak_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "rasd_barang_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses SPPB";
		$WAKTU = date('Y-m-d H:i:s');
		$this->PO_form_model->user_log_po_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->PO_form_model->user_log_po_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

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

			$HASH_MD5_PO = $this->uri->segment(3);
			if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
				redirect('PO', 'refresh');
			}

			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['pajak_list'] = $this->Pajak_model->pajak_list();

			//fungsi ini untuk mengirim data ke dropdown
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$this->data['PROGRESS_PO'] = $hasil['PROGRESS_PO'];
			if (($this->data['PROGRESS_PO']) == 'Dalam Proses Pembuatan Staff Procurement KP') {
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_PO = $hasil['ID_PO'];
				$ID_SPP = $hasil['ID_SPP'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_PO'] = $ID_PO;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
				$this->data['PERALATAN_PERLENGKAPAN'] = $hasil['PERALATAN_PERLENGKAPAN'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['CTT_KEPERLUAN'] = $hasil['CTT_KEPERLUAN'];
				$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
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
					$this->data['ID_VENDOR'] = $hasil2['ID_VENDOR'];
				}

				$hasil4 = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
				if ($hasil4 == 'BELUM ADA TERM OF PAYMENT') {
					$this->data['NAMA_TERM_OF_PAYMENT'] = " ";
				} else {
					$this->data['NAMA_TERM_OF_PAYMENT'] = $hasil4['NAMA_TERM_OF_PAYMENT'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->PO_model->sppb_list_by_id_sppb_result($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp_result($ID_SPP);
				$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
				$this->data['CATATAN_PO'] = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$this->data['spp_barang_list'] = $this->PO_form_model->spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $this->data['ID_VENDOR']);
				$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
				$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
				// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_po_form_proses');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else if (($this->data['PROGRESS_PO']) == 'Dalam Proses Staff Procurement KP') {
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_PO = $hasil['ID_PO'];
				$ID_SPP = $hasil['ID_SPP'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_PO'] = $ID_PO;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
				$this->data['PERALATAN_PERLENGKAPAN'] = $hasil['PERALATAN_PERLENGKAPAN'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['CTT_KEPERLUAN'] = $hasil['CTT_KEPERLUAN'];
				$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
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
					$this->data['ID_VENDOR'] = $hasil2['ID_VENDOR'];
				}

				$hasil4 = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
				if ($hasil4 == 'BELUM ADA TERM OF PAYMENT') {
					$this->data['NAMA_TERM_OF_PAYMENT'] = " ";
				} else {
					$this->data['NAMA_TERM_OF_PAYMENT'] = $hasil4['NAMA_TERM_OF_PAYMENT'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->PO_model->sppb_list_by_id_sppb_result($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp_result($ID_SPP);
				$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
				$this->data['CATATAN_PO'] = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$this->data['spp_barang_list'] = $this->PO_form_model->spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $this->data['ID_VENDOR']);
				$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
				$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
				// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_po_form_proses');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else {
				redirect('PO', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

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

			$HASH_MD5_PO = $this->uri->segment(3);
			if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
				redirect('PO', 'refresh');
			}

			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['pajak_list'] = $this->Pajak_model->pajak_list();

			//fungsi ini untuk mengirim data ke dropdown
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$this->data['PROGRESS_PO'] = $hasil['PROGRESS_PO'];
			if (($this->data['PROGRESS_PO']) == 'Dalam Proses Pembuatan Kasie Procurement KP') {
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_PO = $hasil['ID_PO'];
				$ID_SPP = $hasil['ID_SPP'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_PO'] = $ID_PO;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
				$this->data['PERALATAN_PERLENGKAPAN'] = $hasil['PERALATAN_PERLENGKAPAN'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['CTT_KEPERLUAN'] = $hasil['CTT_KEPERLUAN'];
				$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
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
					$this->data['ID_VENDOR'] = $hasil2['ID_VENDOR'];
				}

				$hasil4 = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
				if ($hasil4 == 'BELUM ADA TERM OF PAYMENT') {
					$this->data['NAMA_TERM_OF_PAYMENT'] = " ";
				} else {
					$this->data['NAMA_TERM_OF_PAYMENT'] = $hasil4['NAMA_TERM_OF_PAYMENT'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->PO_model->sppb_list_by_id_sppb_result($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp_result($ID_SPP);
				$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
				$this->data['CATATAN_PO'] = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$this->data['spp_barang_list'] = $this->PO_form_model->spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $this->data['ID_VENDOR']);
				$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
				$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
				// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_po_form_proses');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else if (($this->data['PROGRESS_PO']) == 'Dalam Proses Kasie Procurement KP') {
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_PO = $hasil['ID_PO'];
				$ID_SPP = $hasil['ID_SPP'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_PO'] = $ID_PO;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
				$this->data['PERALATAN_PERLENGKAPAN'] = $hasil['PERALATAN_PERLENGKAPAN'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['CTT_KEPERLUAN'] = $hasil['CTT_KEPERLUAN'];
				$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
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
					$this->data['ID_VENDOR'] = $hasil2['ID_VENDOR'];
				}

				$hasil4 = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
				if ($hasil4 == 'BELUM ADA TERM OF PAYMENT') {
					$this->data['NAMA_TERM_OF_PAYMENT'] = " ";
				} else {
					$this->data['NAMA_TERM_OF_PAYMENT'] = $hasil4['NAMA_TERM_OF_PAYMENT'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->PO_model->sppb_list_by_id_sppb_result($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp_result($ID_SPP);
				$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
				$this->data['CATATAN_PO'] = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$this->data['spp_barang_list'] = $this->PO_form_model->spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $this->data['ID_VENDOR']);
				$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
				$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
				// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_po_form_proses');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else {
				redirect('PO', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

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

			$HASH_MD5_PO = $this->uri->segment(3);
			if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
				redirect('PO', 'refresh');
			}

			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['pajak_list'] = $this->Pajak_model->pajak_list();

			//fungsi ini untuk mengirim data ke dropdown
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$this->data['PROGRESS_PO'] = $hasil['PROGRESS_PO'];
			if (($this->data['PROGRESS_PO']) == 'Dalam Proses Pembuatan Manajer Procurement KP') {
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_PO = $hasil['ID_PO'];
				$ID_SPP = $hasil['ID_SPP'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_PO'] = $ID_PO;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
				$this->data['PERALATAN_PERLENGKAPAN'] = $hasil['PERALATAN_PERLENGKAPAN'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['CTT_KEPERLUAN'] = $hasil['CTT_KEPERLUAN'];
				$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
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
					$this->data['ID_VENDOR'] = $hasil2['ID_VENDOR'];
				}

				$hasil4 = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
				if ($hasil4 == 'BELUM ADA TERM OF PAYMENT') {
					$this->data['NAMA_TERM_OF_PAYMENT'] = " ";
				} else {
					$this->data['NAMA_TERM_OF_PAYMENT'] = $hasil4['NAMA_TERM_OF_PAYMENT'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->PO_model->sppb_list_by_id_sppb_result($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp_result($ID_SPP);
				$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
				$this->data['CATATAN_PO'] = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$this->data['spp_barang_list'] = $this->PO_form_model->spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $this->data['ID_VENDOR']);
				$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
				$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
				// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_po_form_proses');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else if (($this->data['PROGRESS_PO']) == 'Dalam Proses Manajer Procurement KP') {
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_PO = $hasil['ID_PO'];
				$ID_SPP = $hasil['ID_SPP'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_PO'] = $ID_PO;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
				$this->data['PERALATAN_PERLENGKAPAN'] = $hasil['PERALATAN_PERLENGKAPAN'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['CTT_KEPERLUAN'] = $hasil['CTT_KEPERLUAN'];
				$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
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
					$this->data['ID_VENDOR'] = $hasil2['ID_VENDOR'];
				}

				$hasil4 = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
				if ($hasil4 == 'BELUM ADA TERM OF PAYMENT') {
					$this->data['NAMA_TERM_OF_PAYMENT'] = " ";
				} else {
					$this->data['NAMA_TERM_OF_PAYMENT'] = $hasil4['NAMA_TERM_OF_PAYMENT'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->PO_model->sppb_list_by_id_sppb_result($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp_result($ID_SPP);
				$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
				$this->data['CATATAN_PO'] = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$this->data['spp_barang_list'] = $this->PO_form_model->spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $this->data['ID_VENDOR']);
				$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
				$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
				// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_po_form_proses');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else {
				redirect('PO', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

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

			$HASH_MD5_PO = $this->uri->segment(3);
			if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
				redirect('PO', 'refresh');
			}

			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['pajak_list'] = $this->Pajak_model->pajak_list();

			//fungsi ini untuk mengirim data ke dropdown
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$this->data['PROGRESS_PO'] = $hasil['PROGRESS_PO'];
			if (($this->data['PROGRESS_PO']) == 'Dalam Proses Pembuatan Staff Procurement SP') {
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_PO = $hasil['ID_PO'];
				$ID_SPP = $hasil['ID_SPP'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_PO'] = $ID_PO;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
				$this->data['PERALATAN_PERLENGKAPAN'] = $hasil['PERALATAN_PERLENGKAPAN'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['CTT_KEPERLUAN'] = $hasil['CTT_KEPERLUAN'];
				$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
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
					$this->data['ID_VENDOR'] = $hasil2['ID_VENDOR'];
				}

				$hasil4 = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
				if ($hasil4 == 'BELUM ADA TERM OF PAYMENT') {
					$this->data['NAMA_TERM_OF_PAYMENT'] = " ";
				} else {
					$this->data['NAMA_TERM_OF_PAYMENT'] = $hasil4['NAMA_TERM_OF_PAYMENT'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->PO_model->sppb_list_by_id_sppb_result($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp_result($ID_SPP);
				$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
				$this->data['CATATAN_PO'] = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$this->data['spp_barang_list'] = $this->PO_form_model->spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $this->data['ID_VENDOR']);
				$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
				$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
				// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_po_form_proses');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else if (($this->data['PROGRESS_PO']) == 'Dalam Proses Staff Procurement SP') {
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_PO = $hasil['ID_PO'];
				$ID_SPP = $hasil['ID_SPP'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_PO'] = $ID_PO;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
				$this->data['PERALATAN_PERLENGKAPAN'] = $hasil['PERALATAN_PERLENGKAPAN'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['CTT_KEPERLUAN'] = $hasil['CTT_KEPERLUAN'];
				$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
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
					$this->data['ID_VENDOR'] = $hasil2['ID_VENDOR'];
				}

				$hasil4 = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
				if ($hasil4 == 'BELUM ADA TERM OF PAYMENT') {
					$this->data['NAMA_TERM_OF_PAYMENT'] = " ";
				} else {
					$this->data['NAMA_TERM_OF_PAYMENT'] = $hasil4['NAMA_TERM_OF_PAYMENT'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->PO_model->sppb_list_by_id_sppb_result($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp_result($ID_SPP);
				$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
				$this->data['CATATAN_PO'] = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$this->data['spp_barang_list'] = $this->PO_form_model->spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $this->data['ID_VENDOR']);
				$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
				$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
				// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_po_form_proses');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else {
				redirect('PO', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

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

			$HASH_MD5_PO = $this->uri->segment(3);
			if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
				redirect('PO', 'refresh');
			}

			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['pajak_list'] = $this->Pajak_model->pajak_list();

			//fungsi ini untuk mengirim data ke dropdown
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$this->data['PROGRESS_PO'] = $hasil['PROGRESS_PO'];
			if (($this->data['PROGRESS_PO']) == 'Dalam Proses Pembuatan Supervisi Procurement SP') {
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_PO = $hasil['ID_PO'];
				$ID_SPP = $hasil['ID_SPP'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_PO'] = $ID_PO;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
				$this->data['PERALATAN_PERLENGKAPAN'] = $hasil['PERALATAN_PERLENGKAPAN'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['CTT_KEPERLUAN'] = $hasil['CTT_KEPERLUAN'];
				$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
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
					$this->data['ID_VENDOR'] = $hasil2['ID_VENDOR'];
				}

				$hasil4 = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
				if ($hasil4 == 'BELUM ADA TERM OF PAYMENT') {
					$this->data['NAMA_TERM_OF_PAYMENT'] = " ";
				} else {
					$this->data['NAMA_TERM_OF_PAYMENT'] = $hasil4['NAMA_TERM_OF_PAYMENT'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->PO_model->sppb_list_by_id_sppb_result($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp_result($ID_SPP);
				$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
				$this->data['CATATAN_PO'] = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$this->data['spp_barang_list'] = $this->PO_form_model->spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $this->data['ID_VENDOR']);
				$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
				$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
				// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_po_form_proses');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else if (($this->data['PROGRESS_PO']) == 'Dalam Proses Supervisi Procurement SP') {
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_PO = $hasil['ID_PO'];
				$ID_SPP = $hasil['ID_SPP'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_PO'] = $ID_PO;
				$this->data['ID_SPP'] = $ID_SPP;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
				$this->data['PERALATAN_PERLENGKAPAN'] = $hasil['PERALATAN_PERLENGKAPAN'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['CTT_KEPERLUAN'] = $hasil['CTT_KEPERLUAN'];
				$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
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
					$this->data['ID_VENDOR'] = $hasil2['ID_VENDOR'];
				}

				$hasil4 = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
				if ($hasil4 == 'BELUM ADA TERM OF PAYMENT') {
					$this->data['NAMA_TERM_OF_PAYMENT'] = " ";
				} else {
					$this->data['NAMA_TERM_OF_PAYMENT'] = $hasil4['NAMA_TERM_OF_PAYMENT'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->PO_model->sppb_list_by_id_sppb_result($ID_SPPB);
				$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp_result($ID_SPP);
				$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
				$this->data['CATATAN_PO'] = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$this->data['spp_barang_list'] = $this->PO_form_model->spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $this->data['ID_VENDOR']);
				$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
				$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
				// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_po_form_proses');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else {
				redirect('PO', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	function data_po_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$id = $this->input->get('id');
			$data = $this->PO_form_model->po_form_list_by_id_po($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data PO Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$id = $this->input->get('id');
			// $data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			// echo json_encode($data);

			$data = $this->PO_form_model->po_form_list_by_id_po($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data PO Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$id = $this->input->get('id');
			$data = $this->PO_form_model->po_form_list_by_id_po($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data PO Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$id = $this->input->get('id');
			// $data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			// echo json_encode($data);

			$data = $this->PO_form_model->po_form_list_by_id_po($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data PO Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$id = $this->input->get('id');
			// $data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			// echo json_encode($data);

			$data = $this->PO_form_model->po_form_list_by_id_po($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data PO Form: " . json_encode($id);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {
			$id = $this->input->get('id');
			// $data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($id);
			// echo json_encode($data);

			$data = $this->PO_form_model->po_form_list_by_id_po($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data PO Form: " . json_encode($id);
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
			$ID_PO_FORM = $this->input->get('id');
			$data = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$ID_PO_FORM = $this->input->get('id');
			$data = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$ID_PO_FORM = $this->input->get('id');
			$data = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_PO_FORM = $this->input->get('id');
			$data = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_PO_FORM = $this->input->get('id');
			$data = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {
			$ID_PO_FORM = $this->input->get('id');
			$data = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO Form by ID_PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_po()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			// $ID_SPPB_FORM = $this->input->get('id');
			// $data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			// echo json_encode($data);

			// $KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			// $this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$ID_PO = $this->input->get('ID_PO');
			$data = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$ID_PO = $this->input->get('ID_PO');
			$data = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$ID_PO = $this->input->get('ID_PO');
			$data = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_PO = $this->input->get('ID_PO');
			$data = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_PO = $this->input->get('ID_PO');
			$data = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {
			$ID_PO = $this->input->get('ID_PO');
			$data = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_po_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			// $ID_SPPB_FORM = $this->input->get('id');
			// $data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			// echo json_encode($data);

			// $KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			// $this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $hasil['ID_PO'];
			$data = $this->PO_form_model->get_data_po_form_by_ID_PO($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $hasil['ID_PO'];
			$data = $this->PO_form_model->get_data_po_form_by_ID_PO($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $hasil['ID_PO'];
			$data = $this->PO_form_model->get_data_po_form_by_ID_PO($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $hasil['ID_PO'];
			$data = $this->PO_form_model->get_data_po_form_by_ID_PO($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $hasil['ID_PO'];
			$data = $this->PO_form_model->get_data_po_form_by_ID_PO($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $hasil['ID_PO'];
			$data = $this->PO_form_model->get_data_po_form_by_ID_PO($ID_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_id_po_by_HASH_MD5_PO()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			// $ID_SPPB_FORM = $this->input->get('id');
			// $data = $this->SPPB_form_model->get_data_by_id_sppb_form($ID_SPPB_FORM);
			// echo json_encode($data);

			// $KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			// $this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_catatan_po()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_id_po_by_HASH_MD5_PO($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_id_po_by_HASH_MD5_PO($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_id_po_by_HASH_MD5_PO($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_ctt_po()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_data_CTT_STAFF_PROC($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_data_CTT_KASIE($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_data_CTT_MANAGER_PROC($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_data_CTT_STAFF_PROC_SP($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
			$data = $this->PO_model->get_data_CTT_SUPERVISI_PROC_SP($HASH_MD5_PO);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
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
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$ID_PO_FORM = $this->input->post('kode');
			$data_hapus = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);

			$ID_SPP_FORM = $data_hapus['ID_SPP_FORM'];
			if ($ID_SPP_FORM != "" || $ID_SPP_FORM != null) {
				//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
				$this->SPP_form_model->update_delete_status_po_by_id_spp_form($ID_SPP_FORM);
			}

			$KETERANGAN = "Hapus Data PO Form: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->PO_form_model->hapus_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$ID_PO_FORM = $this->input->post('kode');
			$data_hapus = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);

			$ID_SPP_FORM = $data_hapus['ID_SPP_FORM'];
			if ($ID_SPP_FORM != "" || $ID_SPP_FORM != null) {
				//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
				$this->SPP_form_model->update_delete_status_po_by_id_spp_form($ID_SPP_FORM);
			}

			$KETERANGAN = "Hapus Data PO Form: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->PO_form_model->hapus_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$ID_PO_FORM = $this->input->post('kode');
			$data_hapus = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);

			$ID_SPP_FORM = $data_hapus['ID_SPP_FORM'];
			if ($ID_SPP_FORM != "" || $ID_SPP_FORM != null) {
				//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
				$this->SPP_form_model->update_delete_status_po_by_id_spp_form($ID_SPP_FORM);
			}

			$KETERANGAN = "Hapus Data PO Form: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->PO_form_model->hapus_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_PO_FORM = $this->input->post('kode');
			$data_hapus = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);

			$ID_SPP_FORM = $data_hapus['ID_SPP_FORM'];
			if ($ID_SPP_FORM != "" || $ID_SPP_FORM != null) {
				//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
				$this->SPP_form_model->update_delete_status_po_by_id_spp_form($ID_SPP_FORM);
			}

			$KETERANGAN = "Hapus Data PO Form: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->PO_form_model->hapus_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_PO_FORM = $this->input->post('kode');
			$data_hapus = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);

			$ID_SPP_FORM = $data_hapus['ID_SPP_FORM'];
			if ($ID_SPP_FORM != "" || $ID_SPP_FORM != null) {
				//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
				$this->SPP_form_model->update_delete_status_po_by_id_spp_form($ID_SPP_FORM);
			}

			$KETERANGAN = "Hapus Data PO Form: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->PO_form_model->hapus_data_by_id_po_form($ID_PO_FORM);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}

	function simpan_data_dari_spp_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
			$ID_PO = $this->input->post('ID_PO');
			foreach ($ID_SPP_FORM as $index => $ID_SPP_FORM) {
				$data = $this->SPP_form_model->SPP_form_list_by_id_spp_form($ID_SPP_FORM);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}

				if ($data->NAMA_BARANG_MASTER != "") {
					$nama_barang = $data->NAMA_BARANG_MASTER;
				} else {
					$nama_barang = $data->NAMA_BARANG;
				}

				if ($data->MEREK_MASTER != "") {
					$merek = $data->MEREK_MASTER;
				} else {
					$merek = $data->MEREK;
				}

				if ($data->SPESIFIKASI_SINGKAT_MASTER != "") {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT_MASTER;
				} else {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT;
				}

				$ID_SPP = $data->ID_SPP;
				$ID_RASD_FORM = $data->ID_RASD_FORM;

				$TANGGAL_MULAI_PAKAI = $data->TANGGAL_MULAI_PAKAI;
				$TANGGAL_SELESAI_PAKAI = $data->TANGGAL_SELESAI_PAKAI;

				//SIMPAN KE TABEL SPPB FORM
				$this->PO_form_model->simpan_data_dari_spp_form(
					$ID_PO,
					$ID_SPP,
					$ID_SPP_FORM,
					$ID_RASD_FORM,
					$id_master,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->ID_PAJAK,
					$nama_barang,
					$merek,
					$data->PERALATAN_PERLENGKAPAN,
					$spesifikasi_singkat,
					$data->JUMLAH_BARANG,
					$data->HARGA_SATUAN_BARANG_FIX,
					$data->HARGA_TOTAL_FIX,
					$TANGGAL_MULAI_PAKAI,
					$TANGGAL_SELESAI_PAKAI
				);

				//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
				$this->SPP_form_model->update_status_po_by_id_spp_form($ID_SPP_FORM, $ID_PO);

				$KETERANGAN = "Tambah Data PO Form (dari SPP): " . ";" . $ID_PO . ";" . $ID_SPP . ";" . $ID_SPP_FORM . ";" . $ID_RASD_FORM . ";" . $id_master . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->ID_PAJAK . ";" . $nama_barang . ";" . $merek . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $spesifikasi_singkat . ";" . $data->JUMLAH_BARANG . ";" . $data->HARGA_SATUAN_BARANG_FIX . ";" . $data->HARGA_TOTAL_FIX . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
			$ID_PO = $this->input->post('ID_PO');
			foreach ($ID_SPP_FORM as $index => $ID_SPP_FORM) {
				$data = $this->SPP_form_model->SPP_form_list_by_id_spp_form($ID_SPP_FORM);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}

				if ($data->NAMA_BARANG_MASTER != "") {
					$nama_barang = $data->NAMA_BARANG_MASTER;
				} else {
					$nama_barang = $data->NAMA_BARANG;
				}

				if ($data->MEREK_MASTER != "") {
					$merek = $data->MEREK_MASTER;
				} else {
					$merek = $data->MEREK;
				}

				if ($data->SPESIFIKASI_SINGKAT_MASTER != "") {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT_MASTER;
				} else {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT;
				}

				$ID_SPP = $data->ID_SPP;
				$ID_RASD_FORM = $data->ID_RASD_FORM;

				$TANGGAL_MULAI_PAKAI = $data->TANGGAL_MULAI_PAKAI;
				$TANGGAL_SELESAI_PAKAI = $data->TANGGAL_SELESAI_PAKAI;

				//SIMPAN KE TABEL SPPB FORM
				$this->PO_form_model->simpan_data_dari_spp_form(
					$ID_PO,
					$ID_SPP,
					$ID_SPP_FORM,
					$ID_RASD_FORM,
					$id_master,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->ID_PAJAK,
					$nama_barang,
					$merek,
					$data->PERALATAN_PERLENGKAPAN,
					$spesifikasi_singkat,
					$data->JUMLAH_BARANG,
					$data->HARGA_SATUAN_BARANG_FIX,
					$data->HARGA_TOTAL_FIX,
					$TANGGAL_MULAI_PAKAI,
					$TANGGAL_SELESAI_PAKAI
				);

				//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
				$this->SPP_form_model->update_status_po_by_id_spp_form($ID_SPP_FORM, $ID_PO);

				$KETERANGAN = "Tambah Data PO Form (dari SPP): " . ";" . $ID_PO . ";" . $ID_SPP . ";" . $ID_SPP_FORM . ";" . $ID_RASD_FORM . ";" . $id_master . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->ID_PAJAK . ";" . $nama_barang . ";" . $merek . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $spesifikasi_singkat . ";" . $data->JUMLAH_BARANG . ";" . $data->HARGA_SATUAN_BARANG_FIX . ";" . $data->HARGA_TOTAL_FIX . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
			$ID_PO = $this->input->post('ID_PO');
			foreach ($ID_SPP_FORM as $index => $ID_SPP_FORM) {
				$data = $this->SPP_form_model->SPP_form_list_by_id_spp_form($ID_SPP_FORM);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}

				if ($data->NAMA_BARANG_MASTER != "") {
					$nama_barang = $data->NAMA_BARANG_MASTER;
				} else {
					$nama_barang = $data->NAMA_BARANG;
				}

				if ($data->MEREK_MASTER != "") {
					$merek = $data->MEREK_MASTER;
				} else {
					$merek = $data->MEREK;
				}

				if ($data->SPESIFIKASI_SINGKAT_MASTER != "") {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT_MASTER;
				} else {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT;
				}

				$ID_SPP = $data->ID_SPP;
				$ID_RASD_FORM = $data->ID_RASD_FORM;

				$TANGGAL_MULAI_PAKAI = $data->TANGGAL_MULAI_PAKAI;
				$TANGGAL_SELESAI_PAKAI = $data->TANGGAL_SELESAI_PAKAI;

				//SIMPAN KE TABEL SPPB FORM
				$this->PO_form_model->simpan_data_dari_spp_form(
					$ID_PO,
					$ID_SPP,
					$ID_SPP_FORM,
					$ID_RASD_FORM,
					$id_master,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->ID_PAJAK,
					$nama_barang,
					$merek,
					$data->PERALATAN_PERLENGKAPAN,
					$spesifikasi_singkat,
					$data->JUMLAH_BARANG,
					$data->HARGA_SATUAN_BARANG_FIX,
					$data->HARGA_TOTAL_FIX,
					$TANGGAL_MULAI_PAKAI,
					$TANGGAL_SELESAI_PAKAI
				);

				//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
				$this->SPP_form_model->update_status_po_by_id_spp_form($ID_SPP_FORM, $ID_PO);

				$KETERANGAN = "Tambah Data PO Form (dari SPP): " . ";" . $ID_PO . ";" . $ID_SPP . ";" . $ID_SPP_FORM . ";" . $ID_RASD_FORM . ";" . $id_master . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->ID_PAJAK . ";" . $nama_barang . ";" . $merek . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $spesifikasi_singkat . ";" . $data->JUMLAH_BARANG . ";" . $data->HARGA_SATUAN_BARANG_FIX . ";" . $data->HARGA_TOTAL_FIX . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
			$ID_PO = $this->input->post('ID_PO');
			foreach ($ID_SPP_FORM as $index => $ID_SPP_FORM) {
				$data = $this->SPP_form_model->SPP_form_list_by_id_spp_form($ID_SPP_FORM);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}

				if ($data->NAMA_BARANG_MASTER != "") {
					$nama_barang = $data->NAMA_BARANG_MASTER;
				} else {
					$nama_barang = $data->NAMA_BARANG;
				}

				if ($data->MEREK_MASTER != "") {
					$merek = $data->MEREK_MASTER;
				} else {
					$merek = $data->MEREK;
				}

				if ($data->SPESIFIKASI_SINGKAT_MASTER != "") {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT_MASTER;
				} else {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT;
				}

				$ID_SPP = $data->ID_SPP;
				$ID_RASD_FORM = $data->ID_RASD_FORM;

				$TANGGAL_MULAI_PAKAI = $data->TANGGAL_MULAI_PAKAI;
				$TANGGAL_SELESAI_PAKAI = $data->TANGGAL_SELESAI_PAKAI;

				//SIMPAN KE TABEL SPPB FORM
				$this->PO_form_model->simpan_data_dari_spp_form(
					$ID_PO,
					$ID_SPP,
					$ID_SPP_FORM,
					$ID_RASD_FORM,
					$id_master,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->ID_PAJAK,
					$nama_barang,
					$merek,
					$data->PERALATAN_PERLENGKAPAN,
					$spesifikasi_singkat,
					$data->JUMLAH_BARANG,
					$data->HARGA_SATUAN_BARANG_FIX,
					$data->HARGA_TOTAL_FIX,
					$TANGGAL_MULAI_PAKAI,
					$TANGGAL_SELESAI_PAKAI
				);

				//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
				$this->SPP_form_model->update_status_po_by_id_spp_form($ID_SPP_FORM, $ID_PO);

				$KETERANGAN = "Tambah Data PO Form (dari SPP): " . ";" . $ID_PO . ";" . $ID_SPP . ";" . $ID_SPP_FORM . ";" . $ID_RASD_FORM . ";" . $id_master . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->ID_PAJAK . ";" . $nama_barang . ";" . $merek . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $spesifikasi_singkat . ";" . $data->JUMLAH_BARANG . ";" . $data->HARGA_SATUAN_BARANG_FIX . ";" . $data->HARGA_TOTAL_FIX . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_SPP_FORM = $this->input->post('ID_SPP_FORM');
			$ID_PO = $this->input->post('ID_PO');
			foreach ($ID_SPP_FORM as $index => $ID_SPP_FORM) {
				$data = $this->SPP_form_model->SPP_form_list_by_id_spp_form($ID_SPP_FORM);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}

				if ($data->NAMA_BARANG_MASTER != "") {
					$nama_barang = $data->NAMA_BARANG_MASTER;
				} else {
					$nama_barang = $data->NAMA_BARANG;
				}

				if ($data->MEREK_MASTER != "") {
					$merek = $data->MEREK_MASTER;
				} else {
					$merek = $data->MEREK;
				}

				if ($data->SPESIFIKASI_SINGKAT_MASTER != "") {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT_MASTER;
				} else {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT;
				}

				$ID_SPP = $data->ID_SPP;
				$ID_RASD_FORM = $data->ID_RASD_FORM;

				$TANGGAL_MULAI_PAKAI = $data->TANGGAL_MULAI_PAKAI;
				$TANGGAL_SELESAI_PAKAI = $data->TANGGAL_SELESAI_PAKAI;

				//SIMPAN KE TABEL SPPB FORM
				$this->PO_form_model->simpan_data_dari_spp_form(
					$ID_PO,
					$ID_SPP,
					$ID_SPP_FORM,
					$ID_RASD_FORM,
					$id_master,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->ID_PAJAK,
					$nama_barang,
					$merek,
					$data->PERALATAN_PERLENGKAPAN,
					$spesifikasi_singkat,
					$data->JUMLAH_BARANG,
					$data->HARGA_SATUAN_BARANG_FIX,
					$data->HARGA_TOTAL_FIX,
					$TANGGAL_MULAI_PAKAI,
					$TANGGAL_SELESAI_PAKAI
				);

				//UPDATE STATUS SPPB RECORD KE TABEL FPB FORM
				$this->SPP_form_model->update_status_po_by_id_spp_form($ID_SPP_FORM, $ID_PO);

				$KETERANGAN = "Tambah Data PO Form (dari SPP): " . ";" . $ID_PO . ";" . $ID_SPP . ";" . $ID_SPP_FORM . ";" . $ID_RASD_FORM . ";" . $id_master . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->ID_PAJAK . ";" . $nama_barang . ";" . $merek . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $spesifikasi_singkat . ";" . $data->JUMLAH_BARANG . ";" . $data->HARGA_SATUAN_BARANG_FIX . ";" . $data->HARGA_TOTAL_FIX . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}

	function simpan_data_dari_rasd_form()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_PO = $this->input->post('ID_PO');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->PO_form_model->simpan_data_dari_rasd_form(
					$ID_PO,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data PO Form (dari RASD): " . ";" . $ID_PO . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_PO = $this->input->post('ID_PO');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->PO_form_model->simpan_data_dari_rasd_form(
					$ID_PO,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data PO Form (dari RASD): " . ";" . $ID_PO . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_PO = $this->input->post('ID_PO');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->PO_form_model->simpan_data_dari_rasd_form(
					$ID_PO,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data PO Form (dari RASD): " . ";" . $ID_PO . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_PO = $this->input->post('ID_PO');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->PO_form_model->simpan_data_dari_rasd_form(
					$ID_PO,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data PO Form (dari RASD): " . ";" . $ID_PO . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_PO = $this->input->post('ID_PO');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->PO_form_model->simpan_data_dari_rasd_form(
					$ID_PO,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data PO Form (dari RASD): " . ";" . $ID_PO . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}

	function simpan_data_dari_barang_master()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			$ID_PO = $this->input->post('ID_PO');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->PO_form_model->simpan_data_dari_barang_master(
					$ID_PO,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data FPB Form (dari barang master): " . ";" . $ID_PO . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			$ID_PO = $this->input->post('ID_PO');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->PO_form_model->simpan_data_dari_barang_master(
					$ID_PO,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data FPB Form (dari barang master): " . ";" . $ID_PO . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			$ID_PO = $this->input->post('ID_PO');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->PO_form_model->simpan_data_dari_barang_master(
					$ID_PO,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data FPB Form (dari barang master): " . ";" . $ID_PO . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			$ID_PO = $this->input->post('ID_PO');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->PO_form_model->simpan_data_dari_barang_master(
					$ID_PO,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data FPB Form (dari barang master): " . ";" . $ID_PO . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			$ID_PO = $this->input->post('ID_PO');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->PO_form_model->simpan_data_dari_barang_master(
					$ID_PO,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data FPB Form (dari barang master): " . ";" . $ID_PO . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}

	public function simpan_data_di_luar_barang_master()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Kategori', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Kategori Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_PO = $this->input->post('ID_PO');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				//check apakah nama FPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->PO_form_model->cek_nama_barang_po_form($NAMA, $ID_PO) == 'Data belum ada') {
					$data = $this->PO_form_model->simpan_data_di_luar_barang_master(
						$ID_PO,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$PERALATAN_PERLENGKAPAN,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_BARANG,
						$HARGA_SATUAN_BARANG_FIX,
						$HARGA_TOTAL_FIX,

					);

					$KETERANGAN = "Tambah Data PO Form (di luar barang master dan RASD): " . ";" . $ID_PO . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_BARANG . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Kategori', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Kategori Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_PO = $this->input->post('ID_PO');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				//check apakah nama FPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->PO_form_model->cek_nama_barang_po_form($NAMA, $ID_PO) == 'Data belum ada') {
					$data = $this->PO_form_model->simpan_data_di_luar_barang_master(
						$ID_PO,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$PERALATAN_PERLENGKAPAN,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_BARANG,
						$HARGA_SATUAN_BARANG_FIX,
						$HARGA_TOTAL_FIX,

					);

					$KETERANGAN = "Tambah Data PO Form (di luar barang master dan RASD): " . ";" . $ID_PO . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_BARANG . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Kategori', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Kategori Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_PO = $this->input->post('ID_PO');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				//check apakah nama FPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->PO_form_model->cek_nama_barang_po_form($NAMA, $ID_PO) == 'Data belum ada') {
					$data = $this->PO_form_model->simpan_data_di_luar_barang_master(
						$ID_PO,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$PERALATAN_PERLENGKAPAN,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_BARANG,
						$HARGA_SATUAN_BARANG_FIX,
						$HARGA_TOTAL_FIX,

					);

					$KETERANGAN = "Tambah Data PO Form (di luar barang master dan RASD): " . ";" . $ID_PO . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_BARANG . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Kategori', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Kategori Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_PO = $this->input->post('ID_PO');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				//check apakah nama FPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->PO_form_model->cek_nama_barang_po_form($NAMA, $ID_PO) == 'Data belum ada') {
					$data = $this->PO_form_model->simpan_data_di_luar_barang_master(
						$ID_PO,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$PERALATAN_PERLENGKAPAN,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_BARANG,
						$HARGA_SATUAN_BARANG_FIX,
						$HARGA_TOTAL_FIX,

					);

					$KETERANGAN = "Tambah Data PO Form (di luar barang master dan RASD): " . ";" . $ID_PO . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_BARANG . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Kategori', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Kategori Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_PO = $this->input->post('ID_PO');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				//check apakah nama FPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->PO_form_model->cek_nama_barang_po_form($NAMA, $ID_PO) == 'Data belum ada') {
					$data = $this->PO_form_model->simpan_data_di_luar_barang_master(
						$ID_PO,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$PERALATAN_PERLENGKAPAN,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_BARANG,
						$HARGA_SATUAN_BARANG_FIX,
						$HARGA_TOTAL_FIX,

					);

					$KETERANGAN = "Tambah Data PO Form (di luar barang master dan RASD): " . ";" . $ID_PO . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_BARANG . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else {
			$this->logout();
		}
	}

	function simpan_pajak()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//set validation rules
			$this->form_validation->set_rules('TARIF_PAJAK', 'Tarif Pajak', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$ID_PAJAK = $this->input->post('TARIF_PAJAK');

				$KETERANGAN = "Ubah Data Pajak Semua Item Barang/Jasa di PO : " . $ID_PO . ";" . $ID_PAJAK;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->simpan_pajak($ID_PO, $ID_PAJAK);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//set validation rules
			$this->form_validation->set_rules('TARIF_PAJAK', 'Tarif Pajak', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$ID_PAJAK = $this->input->post('TARIF_PAJAK');

				$KETERANGAN = "Ubah Data Pajak Semua Item Barang/Jasa di PO : " . $ID_PO . ";" . $ID_PAJAK;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->simpan_pajak($ID_PO, $ID_PAJAK);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//set validation rules
			$this->form_validation->set_rules('TARIF_PAJAK', 'Tarif Pajak', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$ID_PAJAK = $this->input->post('TARIF_PAJAK');

				$KETERANGAN = "Ubah Data Pajak Semua Item Barang/Jasa di PO : " . $ID_PO . ";" . $ID_PAJAK;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->simpan_pajak($ID_PO, $ID_PAJAK);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//set validation rules
			$this->form_validation->set_rules('TARIF_PAJAK', 'Tarif Pajak', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$ID_PAJAK = $this->input->post('TARIF_PAJAK');

				$KETERANGAN = "Ubah Data Pajak Semua Item Barang/Jasa di PO : " . $ID_PO . ";" . $ID_PAJAK;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->simpan_pajak($ID_PO, $ID_PAJAK);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//set validation rules
			$this->form_validation->set_rules('TARIF_PAJAK', 'Tarif Pajak', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$ID_PAJAK = $this->input->post('TARIF_PAJAK');

				$KETERANGAN = "Ubah Data Pajak Semua Item Barang/Jasa di PO : " . $ID_PO . ";" . $ID_PAJAK;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->simpan_pajak($ID_PO, $ID_PAJAK);
				echo json_encode($data);
			}
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

	function update_data()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Kategori', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Kategori Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				$data_edit = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Coba isi PO Form: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->PO_form_model->cek_nama_barang_po_form($NAMA, $ID_PO) == 'Data belum ada') || ($data_edit['NAMA_BARANG'] == $NAMA)) {
					// if (($data_edit['NAMA_BARANG'] == $NAMA) ) {
					$KETERANGAN = "Ubah Data PO Form: " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PO_FORM . ";" . $NAMA  . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_JENIS_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $SATUAN_BARANG . ";" . $JUMLAH_BARANG . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
					$this->user_log($KETERANGAN);
					$data = $this->PO_form_model->update_data($ID_PO, $ID_PO_FORM, $NAMA, $MEREK, $PERALATAN_PERLENGKAPAN, $ID_JENIS_BARANG, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG, $HARGA_SATUAN_BARANG_FIX, $HARGA_TOTAL_FIX);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Kategori', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Kategori Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				$data_edit = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Coba isi PO Form: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->PO_form_model->cek_nama_barang_po_form($NAMA, $ID_PO) == 'Data belum ada') || ($data_edit['NAMA_BARANG'] == $NAMA)) {
					// if (($data_edit['NAMA_BARANG'] == $NAMA) ) {
					$KETERANGAN = "Ubah Data PO Form: " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PO_FORM . ";" . $NAMA  . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_JENIS_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $SATUAN_BARANG . ";" . $JUMLAH_BARANG . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
					$this->user_log($KETERANGAN);
					$data = $this->PO_form_model->update_data($ID_PO, $ID_PO_FORM, $NAMA, $MEREK, $PERALATAN_PERLENGKAPAN, $ID_JENIS_BARANG, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG, $HARGA_SATUAN_BARANG_FIX, $HARGA_TOTAL_FIX);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Kategori', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Kategori Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				$data_edit = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Coba isi PO Form: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->PO_form_model->cek_nama_barang_po_form($NAMA, $ID_PO) == 'Data belum ada') || ($data_edit['NAMA_BARANG'] == $NAMA)) {
					// if (($data_edit['NAMA_BARANG'] == $NAMA) ) {
					$KETERANGAN = "Ubah Data PO Form: " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PO_FORM . ";" . $NAMA  . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_JENIS_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $SATUAN_BARANG . ";" . $JUMLAH_BARANG . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
					$this->user_log($KETERANGAN);
					$data = $this->PO_form_model->update_data($ID_PO, $ID_PO_FORM, $NAMA, $MEREK, $PERALATAN_PERLENGKAPAN, $ID_JENIS_BARANG, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG, $HARGA_SATUAN_BARANG_FIX, $HARGA_TOTAL_FIX);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Kategori', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Kategori Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				$data_edit = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Coba isi PO Form: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->PO_form_model->cek_nama_barang_po_form($NAMA, $ID_PO) == 'Data belum ada') || ($data_edit['NAMA_BARANG'] == $NAMA)) {
					// if (($data_edit['NAMA_BARANG'] == $NAMA) ) {
					$KETERANGAN = "Ubah Data PO Form: " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PO_FORM . ";" . $NAMA  . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_JENIS_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $SATUAN_BARANG . ";" . $JUMLAH_BARANG . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
					$this->user_log($KETERANGAN);
					$data = $this->PO_form_model->update_data($ID_PO, $ID_PO_FORM, $NAMA, $MEREK, $PERALATAN_PERLENGKAPAN, $ID_JENIS_BARANG, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG, $HARGA_SATUAN_BARANG_FIX, $HARGA_TOTAL_FIX);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Kategori', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Kategori Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				$data_edit = $this->PO_form_model->get_data_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Coba isi PO Form: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->PO_form_model->cek_nama_barang_po_form($NAMA, $ID_PO) == 'Data belum ada') || ($data_edit['NAMA_BARANG'] == $NAMA)) {
					// if (($data_edit['NAMA_BARANG'] == $NAMA) ) {
					$KETERANGAN = "Ubah Data PO Form: " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PO_FORM . ";" . $NAMA  . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_JENIS_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $SATUAN_BARANG . ";" . $JUMLAH_BARANG . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
					$this->user_log($KETERANGAN);
					$data = $this->PO_form_model->update_data($ID_PO, $ID_PO_FORM, $NAMA, $MEREK, $PERALATAN_PERLENGKAPAN, $ID_JENIS_BARANG, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG, $HARGA_SATUAN_BARANG_FIX, $HARGA_TOTAL_FIX);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
				}
			}
		} else {
			$this->logout();
		}
	}

	function update_data_keterangan_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('KETERANGAN', 'Catatan Item Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$CATATAN = $this->input->post('KETERANGAN');

				$data_edit = $this->PO_form_model->get_keterangan_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Ubah Data Catatan PO Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO_FORM . ";" . $CATATAN;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_keterangan_barang($ID_PO_FORM, $CATATAN);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('KETERANGAN', 'Catatan Item Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$CATATAN = $this->input->post('KETERANGAN');

				$data_edit = $this->PO_form_model->get_keterangan_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Ubah Data Catatan PO Form (User Kasie Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO_FORM . ";" . $CATATAN;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_keterangan_barang($ID_PO_FORM, $CATATAN);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('KETERANGAN', 'Catatan Item Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$CATATAN = $this->input->post('KETERANGAN');

				$data_edit = $this->PO_form_model->get_keterangan_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Ubah Data Catatan PO Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO_FORM . ";" . $CATATAN;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_keterangan_barang($ID_PO_FORM, $CATATAN);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('KETERANGAN', 'Catatan Item Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$CATATAN = $this->input->post('KETERANGAN');

				$data_edit = $this->PO_form_model->get_keterangan_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Ubah Data Catatan PO Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO_FORM . ";" . $CATATAN;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_keterangan_barang($ID_PO_FORM, $CATATAN);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('KETERANGAN', 'Catatan Item Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$CATATAN = $this->input->post('KETERANGAN');

				$data_edit = $this->PO_form_model->get_keterangan_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Ubah Data Catatan PO Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO_FORM . ";" . $CATATAN;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_keterangan_barang($ID_PO_FORM, $CATATAN);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_harga_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {

			//set validation rules
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG_FIX', 'Harga Satuan Barang', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO_FORM = $this->input->post('ID_PO_FORM');
				$HARGA_SATUAN_BARANG_FIX = $this->input->post('HARGA_SATUAN_BARANG_FIX');
				$HARGA_TOTAL_FIX = $this->input->post('HARGA_TOTAL_FIX');

				$data_edit = $this->PO_form_model->get_keterangan_by_id_po_form($ID_PO_FORM);
				$KETERANGAN = "Ubah Data Harga PO Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_PO_FORM . ";" . $HARGA_SATUAN_BARANG_FIX . ";" . $HARGA_TOTAL_FIX;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_harga_barang($ID_PO_FORM, $HARGA_SATUAN_BARANG_FIX, $HARGA_TOTAL_FIX);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_TOTAL_HARGA_PO_BARANG($ID_PO, $TOTAL_HARGA_PO_BARANG)
	{
		if ($this->ion_auth->logged_in()) {

			$data = $this->PO_form_model->update_data_total_harga_po_barang($ID_PO, $TOTAL_HARGA_PO_BARANG);
		} else {
			$this->logout();
		}
	}

	function update_data_TOTAL_PAJAK_PO_BARANG($ID_PO, $TOTAL_PAJAK_PO_BARANG)
	{
		if ($this->ion_auth->logged_in()) {

			$data = $this->PO_form_model->update_data_total_pajak_po_barang($ID_PO, $TOTAL_PAJAK_PO_BARANG);
		} else {
			$this->logout();
		}
	}

	function update_data_TOTAL_ALL_PO_BARANG($ID_PO, $TOTAL_ALL_PO_BARANG)
	{
		if ($this->ion_auth->logged_in()) {

			$data = $this->PO_form_model->update_data_total_all_po_barang($ID_PO, $TOTAL_ALL_PO_BARANG);
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
			$this->form_validation->set_rules('ID_PROYEK_LOKASI_PENYERAHAN', 'Lokasi Penyerahan', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('ID_VENDOR', 'Vendor', 'trim|max_length[50]|required');
			$this->form_validation->set_rules('ID_TERM_OF_PAYMENT', 'Term Of Payment', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Jenis Barang', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TANGGAL_KIRIM_BARANG_HARI', 'Tanggal Kirim Barang', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('CTT_KEPERLUAN', 'Keperluan PO', 'trim|max_length[130]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				if ($this->input->post('ID_VENDOR') == "666666") {
					$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat Vendor', 'trim|required');
					$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|max_length[50]|required|valid_email');
					$this->form_validation->set_rules('NO_TELP_VENDOR', 'Nomor Telp Vendor', 'trim|max_length[20]|required|numeric');
					$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC', 'trim|max_length[50]|required|valid_email');
					$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'Nomor Handphone PIC', 'trim|max_length[20]|required|numeric');

					//run validation check
					if ($this->form_validation->run() == FALSE) {   //validation fails
						echo validation_errors();
					} else {
						if ($this->input->post('ID_TERM_OF_PAYMENT') == "99999") {
							$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment Lainnya', 'trim|max_length[255]|required');
							if ($this->form_validation->run() == FALSE) {   //validation fails
								echo validation_errors();
							} else {

								//get the form data
								$ID_PO = $this->input->post('ID_PO');
								$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
								$ID_VENDOR = $this->input->post('ID_VENDOR');
								$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
								$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
								$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
								$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
								$PROGRESS_PO = 'Dalam Proses Staff Procurement KP';
								$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');
								$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
								$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
								$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
								$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
								$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
								$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
								$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');

								if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
									//log
									$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
									$this->user_log($KETERANGAN);

									$data = $this->Vendor_model->simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

									$this->Vendor_model->set_md5_id_vendor_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
								} else {
									echo 'Nama vendor sudah terekam sebelumnya';
								}

								if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
									//log
									$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
									$this->user_log($KETERANGAN);

									$data = $this->Term_Of_Payment_model->simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

									$this->Term_Of_Payment_model->set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT);
								} else {
									echo 'Nama TOP sudah terekam sebelumnya';
								}

								// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT

								$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
								$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
								$ID_VENDOR = $this->data['ID_VENDOR'];

								$hasil = $this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT);
								$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
								$ID_TERM_OF_PAYMENT = $this->data['ID_TERM_OF_PAYMENT'];

								$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
								$KETERANGAN = "Ubah Data PO Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PERALATAN_PERLENGKAPAN . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $TANGGAL_KIRIM_BARANG_HARI;
								$this->user_log($KETERANGAN);

								$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
								echo json_encode($data);
							}
						} else {

							//get the form data
							$ID_PO = $this->input->post('ID_PO');
							$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
							$ID_VENDOR = $this->input->post('ID_VENDOR');
							$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
							$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
							$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
							$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
							$PROGRESS_PO = 'Dalam Proses Staff Procurement KP';
							$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');
							$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
							$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
							$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
							$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
							$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
							$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
							$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');

							if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
								//log
								$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
								$this->user_log($KETERANGAN);

								$data = $this->Vendor_model->simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

								$this->Vendor_model->set_md5_id_vendor_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
							} else {
								echo 'Nama vendor sudah terekam sebelumnya';
							}

							// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT

							$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
							$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
							$ID_VENDOR = $this->data['ID_VENDOR'];

							$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
							$KETERANGAN = "Ubah Data PO Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PERALATAN_PERLENGKAPAN . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $TANGGAL_KIRIM_BARANG_HARI;
							$this->user_log($KETERANGAN);

							$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
							echo json_encode($data);
						}
					}
				} else {
					if ($this->input->post('ID_TERM_OF_PAYMENT') == "99999") {
						$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment Lainnya', 'trim|max_length[255]|required');
						if ($this->form_validation->run() == FALSE) {   //validation fails
							echo validation_errors();
						} else {

							//get the form data
							$ID_PO = $this->input->post('ID_PO');
							$ID_SPP = $this->input->post('ID_SPP');
							$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
							$ID_VENDOR = $this->input->post('ID_VENDOR');
							$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
							$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
							$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
							$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
							$PROGRESS_PO = 'Dalam Proses Staff Procurement KP';
							$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');

							if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
								//log
								$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
								$this->user_log($KETERANGAN);

								$data = $this->Term_Of_Payment_model->simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

								$this->Term_Of_Payment_model->set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT);
							} else {
								echo 'Nama TOP sudah terekam sebelumnya';
							}

							$hasil = $this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT);
							$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
							$ID_TERM_OF_PAYMENT = $this->data['ID_TERM_OF_PAYMENT'];

							$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
							$KETERANGAN = "Ubah Data PO Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_SPP . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $NAMA_TERM_OF_PAYMENT . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $TANGGAL_KIRIM_BARANG_HARI;
							$this->user_log($KETERANGAN);

							$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
							echo json_encode($data);
						}
					} else {

						//get the form data
						$ID_PO = $this->input->post('ID_PO');
						$ID_SPP = $this->input->post('ID_SPP');
						$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
						$ID_VENDOR = $this->input->post('ID_VENDOR');
						$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
						$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
						$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
						$PROGRESS_PO = 'Dalam Proses Staff Procurement KP';
						$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');

						$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
						$KETERANGAN = "Ubah Data PO Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_SPP . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $TANGGAL_KIRIM_BARANG_HARI;
						$this->user_log($KETERANGAN);

						$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
						echo json_encode($data);
					}
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('ID_PROYEK_LOKASI_PENYERAHAN', 'Lokasi Penyerahan', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('ID_VENDOR', 'Vendor', 'trim|max_length[50]|required');
			$this->form_validation->set_rules('ID_TERM_OF_PAYMENT', 'Term Of Payment', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Jenis Barang', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TANGGAL_KIRIM_BARANG_HARI', 'Tanggal Kirim Barang', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('CTT_KEPERLUAN', 'Keperluan PO', 'trim|max_length[130]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				if ($this->input->post('ID_VENDOR') == "666666") {
					$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat Vendor', 'trim|required');
					$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|max_length[50]|required|valid_email');
					$this->form_validation->set_rules('NO_TELP_VENDOR', 'Nomor Telp Vendor', 'trim|max_length[20]|required|numeric');
					$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC', 'trim|max_length[50]|required|valid_email');
					$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'Nomor Handphone PIC', 'trim|max_length[20]|required|numeric');

					//run validation check
					if ($this->form_validation->run() == FALSE) {   //validation fails
						echo validation_errors();
					} else {
						if ($this->input->post('ID_TERM_OF_PAYMENT') == "99999") {
							$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment Lainnya', 'trim|max_length[255]|required');
							if ($this->form_validation->run() == FALSE) {   //validation fails
								echo validation_errors();
							} else {

								//get the form data
								$ID_PO = $this->input->post('ID_PO');
								$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
								$ID_VENDOR = $this->input->post('ID_VENDOR');
								$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
								$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
								$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
								$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
								$PROGRESS_PO = 'Dalam Proses Kasie Procurement KP';
								$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');
								$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
								$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
								$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
								$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
								$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
								$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
								$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');

								if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
									//log
									$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
									$this->user_log($KETERANGAN);

									$data = $this->Vendor_model->simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

									$this->Vendor_model->set_md5_id_vendor_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
								} else {
									echo 'Nama vendor sudah terekam sebelumnya';
								}

								if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
									//log
									$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
									$this->user_log($KETERANGAN);

									$data = $this->Term_Of_Payment_model->simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

									$this->Term_Of_Payment_model->set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT);
								} else {
									echo 'Nama TOP sudah terekam sebelumnya';
								}

								// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT

								$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
								$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
								$ID_VENDOR = $this->data['ID_VENDOR'];

								$hasil = $this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT);
								$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
								$ID_TERM_OF_PAYMENT = $this->data['ID_TERM_OF_PAYMENT'];

								$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
								$KETERANGAN = "Ubah Data PO Form (User Kasie Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PERALATAN_PERLENGKAPAN . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $TANGGAL_KIRIM_BARANG_HARI;
								$this->user_log($KETERANGAN);

								$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
								echo json_encode($data);
							}
						} else {

							//get the form data
							$ID_PO = $this->input->post('ID_PO');
							$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
							$ID_VENDOR = $this->input->post('ID_VENDOR');
							$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
							$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
							$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
							$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
							$PROGRESS_PO = 'Dalam Proses Kasie Procurement KP';
							$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');
							$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
							$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
							$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
							$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
							$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
							$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
							$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');

							if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
								//log
								$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
								$this->user_log($KETERANGAN);

								$data = $this->Vendor_model->simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

								$this->Vendor_model->set_md5_id_vendor_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
							} else {
								echo 'Nama vendor sudah terekam sebelumnya';
							}

							// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT

							$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
							$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
							$ID_VENDOR = $this->data['ID_VENDOR'];

							$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
							$KETERANGAN = "Ubah Data PO Form (User Kasie Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PERALATAN_PERLENGKAPAN . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $TANGGAL_KIRIM_BARANG_HARI;
							$this->user_log($KETERANGAN);

							$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
							echo json_encode($data);
						}
					}
				} else {
					if ($this->input->post('ID_TERM_OF_PAYMENT') == "99999") {
						$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment Lainnya', 'trim|max_length[255]|required');
						if ($this->form_validation->run() == FALSE) {   //validation fails
							echo validation_errors();
						} else {

							//get the form data
							$ID_PO = $this->input->post('ID_PO');
							$ID_SPP = $this->input->post('ID_SPP');
							$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
							$ID_VENDOR = $this->input->post('ID_VENDOR');
							$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
							$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
							$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
							$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
							$PROGRESS_PO = 'Dalam Proses Kasie Procurement KP';
							$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');

							if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
								//log
								$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
								$this->user_log($KETERANGAN);

								$data = $this->Term_Of_Payment_model->simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

								$this->Term_Of_Payment_model->set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT);
							} else {
								echo 'Nama TOP sudah terekam sebelumnya';
							}

							$hasil = $this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT);
							$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
							$ID_TERM_OF_PAYMENT = $this->data['ID_TERM_OF_PAYMENT'];

							$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
							$KETERANGAN = "Ubah Data PO Form (User Kasie Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_SPP . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $NAMA_TERM_OF_PAYMENT . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $TANGGAL_KIRIM_BARANG_HARI;
							$this->user_log($KETERANGAN);

							$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
							echo json_encode($data);
						}
					} else {

						//get the form data
						$ID_PO = $this->input->post('ID_PO');
						$ID_SPP = $this->input->post('ID_SPP');
						$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
						$ID_VENDOR = $this->input->post('ID_VENDOR');
						$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
						$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
						$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
						$PROGRESS_PO = 'Dalam Proses Kasie Procurement KP';
						$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');

						$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
						$KETERANGAN = "Ubah Data PO Form (User Kasie Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_SPP . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $TANGGAL_KIRIM_BARANG_HARI;
						$this->user_log($KETERANGAN);

						$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
						echo json_encode($data);
					}
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('ID_PROYEK_LOKASI_PENYERAHAN', 'Lokasi Penyerahan', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('ID_VENDOR', 'Vendor', 'trim|max_length[50]|required');
			$this->form_validation->set_rules('ID_TERM_OF_PAYMENT', 'Term Of Payment', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Jenis Barang', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TANGGAL_KIRIM_BARANG_HARI', 'Tanggal Kirim Barang', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('CTT_KEPERLUAN', 'Keperluan PO', 'trim|max_length[130]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				if ($this->input->post('ID_VENDOR') == "666666") {
					$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat Vendor', 'trim|required');
					$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|max_length[50]|required|valid_email');
					$this->form_validation->set_rules('NO_TELP_VENDOR', 'Nomor Telp Vendor', 'trim|max_length[20]|required|numeric');
					$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC', 'trim|max_length[50]|required|valid_email');
					$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'Nomor Handphone PIC', 'trim|max_length[20]|required|numeric');

					//run validation check
					if ($this->form_validation->run() == FALSE) {   //validation fails
						echo validation_errors();
					} else {
						if ($this->input->post('ID_TERM_OF_PAYMENT') == "99999") {
							$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment Lainnya', 'trim|max_length[255]|required');
							if ($this->form_validation->run() == FALSE) {   //validation fails
								echo validation_errors();
							} else {

								//get the form data
								$ID_PO = $this->input->post('ID_PO');
								$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
								$ID_VENDOR = $this->input->post('ID_VENDOR');
								$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
								$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
								$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
								$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
								$PROGRESS_PO = 'Dalam Proses Manajer Procurement KP';
								$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');
								$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
								$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
								$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
								$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
								$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
								$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
								$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');

								if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
									//log
									$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
									$this->user_log($KETERANGAN);

									$data = $this->Vendor_model->simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

									$this->Vendor_model->set_md5_id_vendor_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
								} else {
									echo 'Nama vendor sudah terekam sebelumnya';
								}

								if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
									//log
									$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
									$this->user_log($KETERANGAN);

									$data = $this->Term_Of_Payment_model->simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

									$this->Term_Of_Payment_model->set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT);
								} else {
									echo 'Nama TOP sudah terekam sebelumnya';
								}

								// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT

								$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
								$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
								$ID_VENDOR = $this->data['ID_VENDOR'];

								$hasil = $this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT);
								$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
								$ID_TERM_OF_PAYMENT = $this->data['ID_TERM_OF_PAYMENT'];

								$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
								$KETERANGAN = "Ubah Data PO Form (User Manajer Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PERALATAN_PERLENGKAPAN . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $TANGGAL_KIRIM_BARANG_HARI;
								$this->user_log($KETERANGAN);

								$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
								echo json_encode($data);
							}
						} else {

							//get the form data
							$ID_PO = $this->input->post('ID_PO');
							$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
							$ID_VENDOR = $this->input->post('ID_VENDOR');
							$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
							$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
							$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
							$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
							$PROGRESS_PO = 'Dalam Proses Manajer Procurement KP';
							$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');
							$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
							$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
							$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
							$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
							$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
							$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
							$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');

							if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
								//log
								$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
								$this->user_log($KETERANGAN);

								$data = $this->Vendor_model->simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

								$this->Vendor_model->set_md5_id_vendor_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
							} else {
								echo 'Nama vendor sudah terekam sebelumnya';
							}

							// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT

							$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
							$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
							$ID_VENDOR = $this->data['ID_VENDOR'];

							$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
							$KETERANGAN = "Ubah Data PO Form (User Manajer Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PERALATAN_PERLENGKAPAN . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $TANGGAL_KIRIM_BARANG_HARI;
							$this->user_log($KETERANGAN);

							$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
							echo json_encode($data);
						}
					}
				} else {
					if ($this->input->post('ID_TERM_OF_PAYMENT') == "99999") {
						$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment Lainnya', 'trim|max_length[255]|required');
						if ($this->form_validation->run() == FALSE) {   //validation fails
							echo validation_errors();
						} else {

							//get the form data
							$ID_PO = $this->input->post('ID_PO');
							$ID_SPP = $this->input->post('ID_SPP');
							$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
							$ID_VENDOR = $this->input->post('ID_VENDOR');
							$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
							$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
							$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
							$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
							$PROGRESS_PO = 'Dalam Proses Manajer Procurement KP';
							$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');

							if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
								//log
								$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
								$this->user_log($KETERANGAN);

								$data = $this->Term_Of_Payment_model->simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

								$this->Term_Of_Payment_model->set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT);
							} else {
								echo 'Nama TOP sudah terekam sebelumnya';
							}

							$hasil = $this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT);
							$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
							$ID_TERM_OF_PAYMENT = $this->data['ID_TERM_OF_PAYMENT'];

							$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
							$KETERANGAN = "Ubah Data PO Form (User Manajer Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_SPP . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $NAMA_TERM_OF_PAYMENT . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $TANGGAL_KIRIM_BARANG_HARI;
							$this->user_log($KETERANGAN);

							$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
							echo json_encode($data);
						}
					} else {

						//get the form data
						$ID_PO = $this->input->post('ID_PO');
						$ID_SPP = $this->input->post('ID_SPP');
						$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
						$ID_VENDOR = $this->input->post('ID_VENDOR');
						$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
						$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
						$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
						$PROGRESS_PO = 'Dalam Proses Manajer Procurement KP';
						$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');

						$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
						$KETERANGAN = "Ubah Data PO Form (User Manajer Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_SPP . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $TANGGAL_KIRIM_BARANG_HARI;
						$this->user_log($KETERANGAN);

						$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
						echo json_encode($data);
					}
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('ID_PROYEK_LOKASI_PENYERAHAN', 'Lokasi Penyerahan', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('ID_VENDOR', 'Vendor', 'trim|max_length[50]|required');
			$this->form_validation->set_rules('ID_TERM_OF_PAYMENT', 'Term Of Payment', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Jenis Barang', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TANGGAL_KIRIM_BARANG_HARI', 'Tanggal Kirim Barang', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('CTT_KEPERLUAN', 'Keperluan PO', 'trim|max_length[130]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				if ($this->input->post('ID_VENDOR') == "666666") {
					$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat Vendor', 'trim|required');
					$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|max_length[50]|required|valid_email');
					$this->form_validation->set_rules('NO_TELP_VENDOR', 'Nomor Telp Vendor', 'trim|max_length[20]|required|numeric');
					$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC', 'trim|max_length[50]|required|valid_email');
					$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'Nomor Handphone PIC', 'trim|max_length[20]|required|numeric');

					//run validation check
					if ($this->form_validation->run() == FALSE) {   //validation fails
						echo validation_errors();
					} else {
						if ($this->input->post('ID_TERM_OF_PAYMENT') == "99999") {
							$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment Lainnya', 'trim|max_length[255]|required');
							if ($this->form_validation->run() == FALSE) {   //validation fails
								echo validation_errors();
							} else {

								//get the form data
								$ID_PO = $this->input->post('ID_PO');
								$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
								$ID_VENDOR = $this->input->post('ID_VENDOR');
								$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
								$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
								$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
								$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
								$PROGRESS_PO = 'Dalam Proses Staff Procurement SP';
								$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');
								$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
								$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
								$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
								$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
								$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
								$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
								$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');

								if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
									//log
									$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
									$this->user_log($KETERANGAN);

									$data = $this->Vendor_model->simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

									$this->Vendor_model->set_md5_id_vendor_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
								} else {
									echo 'Nama vendor sudah terekam sebelumnya';
								}

								if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
									//log
									$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
									$this->user_log($KETERANGAN);

									$data = $this->Term_Of_Payment_model->simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

									$this->Term_Of_Payment_model->set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT);
								} else {
									echo 'Nama TOP sudah terekam sebelumnya';
								}

								// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT

								$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
								$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
								$ID_VENDOR = $this->data['ID_VENDOR'];

								$hasil = $this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT);
								$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
								$ID_TERM_OF_PAYMENT = $this->data['ID_TERM_OF_PAYMENT'];

								$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
								$KETERANGAN = "Ubah Data PO Form (User Staff Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PERALATAN_PERLENGKAPAN . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $TANGGAL_KIRIM_BARANG_HARI;
								$this->user_log($KETERANGAN);

								$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
								echo json_encode($data);
							}
						} else {

							//get the form data
							$ID_PO = $this->input->post('ID_PO');
							$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
							$ID_VENDOR = $this->input->post('ID_VENDOR');
							$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
							$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
							$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
							$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
							$PROGRESS_PO = 'Dalam Proses Staff Procurement SP';
							$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');
							$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
							$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
							$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
							$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
							$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
							$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
							$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');

							if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
								//log
								$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
								$this->user_log($KETERANGAN);

								$data = $this->Vendor_model->simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

								$this->Vendor_model->set_md5_id_vendor_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
							} else {
								echo 'Nama vendor sudah terekam sebelumnya';
							}

							// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT

							$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
							$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
							$ID_VENDOR = $this->data['ID_VENDOR'];

							$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
							$KETERANGAN = "Ubah Data PO Form (User Staff Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PERALATAN_PERLENGKAPAN . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $TANGGAL_KIRIM_BARANG_HARI;
							$this->user_log($KETERANGAN);

							$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
							echo json_encode($data);
						}
					}
				} else {
					if ($this->input->post('ID_TERM_OF_PAYMENT') == "99999") {
						$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment Lainnya', 'trim|max_length[255]|required');
						if ($this->form_validation->run() == FALSE) {   //validation fails
							echo validation_errors();
						} else {

							//get the form data
							$ID_PO = $this->input->post('ID_PO');
							$ID_SPP = $this->input->post('ID_SPP');
							$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
							$ID_VENDOR = $this->input->post('ID_VENDOR');
							$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
							$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
							$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
							$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
							$PROGRESS_PO = 'Dalam Proses Staff Procurement SP';
							$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');

							if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
								//log
								$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
								$this->user_log($KETERANGAN);

								$data = $this->Term_Of_Payment_model->simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

								$this->Term_Of_Payment_model->set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT);
							} else {
								echo 'Nama TOP sudah terekam sebelumnya';
							}

							$hasil = $this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT);
							$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
							$ID_TERM_OF_PAYMENT = $this->data['ID_TERM_OF_PAYMENT'];

							$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
							$KETERANGAN = "Ubah Data PO Form (User Staff Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_SPP . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $NAMA_TERM_OF_PAYMENT . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $TANGGAL_KIRIM_BARANG_HARI;
							$this->user_log($KETERANGAN);

							$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
							echo json_encode($data);
						}
					} else {

						//get the form data
						$ID_PO = $this->input->post('ID_PO');
						$ID_SPP = $this->input->post('ID_SPP');
						$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
						$ID_VENDOR = $this->input->post('ID_VENDOR');
						$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
						$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
						$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
						$PROGRESS_PO = 'Dalam Proses Staff Procurement SP';
						$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');

						$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
						$KETERANGAN = "Ubah Data PO Form (User Staff Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_SPP . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $TANGGAL_KIRIM_BARANG_HARI;
						$this->user_log($KETERANGAN);

						$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
						echo json_encode($data);
					}
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('ID_PROYEK_LOKASI_PENYERAHAN', 'Lokasi Penyerahan', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('ID_VENDOR', 'Vendor', 'trim|max_length[50]|required');
			$this->form_validation->set_rules('ID_TERM_OF_PAYMENT', 'Term Of Payment', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Jenis Barang', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('TANGGAL_KIRIM_BARANG_HARI', 'Tanggal Kirim Barang', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('CTT_KEPERLUAN', 'Keperluan PO', 'trim|max_length[130]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				if ($this->input->post('ID_VENDOR') == "666666") {
					$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat Vendor', 'trim|required');
					$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|max_length[50]|required|valid_email');
					$this->form_validation->set_rules('NO_TELP_VENDOR', 'Nomor Telp Vendor', 'trim|max_length[20]|required|numeric');
					$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC', 'trim|max_length[50]|required|valid_email');
					$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'Nomor Handphone PIC', 'trim|max_length[20]|required|numeric');

					//run validation check
					if ($this->form_validation->run() == FALSE) {   //validation fails
						echo validation_errors();
					} else {
						if ($this->input->post('ID_TERM_OF_PAYMENT') == "99999") {
							$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment Lainnya', 'trim|max_length[255]|required');
							if ($this->form_validation->run() == FALSE) {   //validation fails
								echo validation_errors();
							} else {

								//get the form data
								$ID_PO = $this->input->post('ID_PO');
								$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
								$ID_VENDOR = $this->input->post('ID_VENDOR');
								$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
								$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
								$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
								$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
								$PROGRESS_PO = 'Dalam Proses Supervisi Procurement SP';
								$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');
								$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
								$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
								$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
								$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
								$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
								$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
								$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');

								if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
									//log
									$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
									$this->user_log($KETERANGAN);

									$data = $this->Vendor_model->simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

									$this->Vendor_model->set_md5_id_vendor_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
								} else {
									echo 'Nama vendor sudah terekam sebelumnya';
								}

								if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
									//log
									$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
									$this->user_log($KETERANGAN);

									$data = $this->Term_Of_Payment_model->simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

									$this->Term_Of_Payment_model->set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT);
								} else {
									echo 'Nama TOP sudah terekam sebelumnya';
								}

								// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT

								$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
								$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
								$ID_VENDOR = $this->data['ID_VENDOR'];

								$hasil = $this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT);
								$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
								$ID_TERM_OF_PAYMENT = $this->data['ID_TERM_OF_PAYMENT'];

								$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
								$KETERANGAN = "Ubah Data PO Form (User Supervisi Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PERALATAN_PERLENGKAPAN . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $TANGGAL_KIRIM_BARANG_HARI;
								$this->user_log($KETERANGAN);

								$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
								echo json_encode($data);
							}
						} else {

							//get the form data
							$ID_PO = $this->input->post('ID_PO');
							$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
							$ID_VENDOR = $this->input->post('ID_VENDOR');
							$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
							$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
							$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
							$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
							$PROGRESS_PO = 'Dalam Proses Supervisi Procurement SP';
							$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');
							$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
							$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
							$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
							$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
							$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
							$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
							$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');

							if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
								//log
								$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
								$this->user_log($KETERANGAN);

								$data = $this->Vendor_model->simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

								$this->Vendor_model->set_md5_id_vendor_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
							} else {
								echo 'Nama vendor sudah terekam sebelumnya';
							}

							// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT

							$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
							$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
							$ID_VENDOR = $this->data['ID_VENDOR'];

							$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
							$KETERANGAN = "Ubah Data PO Form (User Supervisi Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PERALATAN_PERLENGKAPAN . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $TANGGAL_KIRIM_BARANG_HARI;
							$this->user_log($KETERANGAN);

							$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
							echo json_encode($data);
						}
					}
				} else {
					if ($this->input->post('ID_TERM_OF_PAYMENT') == "99999") {
						$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment Lainnya', 'trim|max_length[255]|required');
						if ($this->form_validation->run() == FALSE) {   //validation fails
							echo validation_errors();
						} else {

							//get the form data
							$ID_PO = $this->input->post('ID_PO');
							$ID_SPP = $this->input->post('ID_SPP');
							$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
							$ID_VENDOR = $this->input->post('ID_VENDOR');
							$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
							$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');
							$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
							$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
							$PROGRESS_PO = 'Dalam Proses Supervisi Procurement SP';
							$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');

							if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
								//log
								$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
								$this->user_log($KETERANGAN);

								$data = $this->Term_Of_Payment_model->simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

								$this->Term_Of_Payment_model->set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT);
							} else {
								echo 'Nama TOP sudah terekam sebelumnya';
							}

							$hasil = $this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT);
							$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
							$ID_TERM_OF_PAYMENT = $this->data['ID_TERM_OF_PAYMENT'];

							$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
							$KETERANGAN = "Ubah Data PO Form (User Supervisi Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_SPP . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $NAMA_TERM_OF_PAYMENT . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $TANGGAL_KIRIM_BARANG_HARI;
							$this->user_log($KETERANGAN);

							$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
							echo json_encode($data);
						}
					} else {

						//get the form data
						$ID_PO = $this->input->post('ID_PO');
						$ID_SPP = $this->input->post('ID_SPP');
						$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
						$ID_VENDOR = $this->input->post('ID_VENDOR');
						$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
						$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
						$TANGGAL_KIRIM_BARANG_HARI = $this->input->post('TANGGAL_KIRIM_BARANG_HARI');
						$PROGRESS_PO = 'Dalam Proses Supervisi Procurement SP';
						$CTT_KEPERLUAN = $this->input->post('CTT_KEPERLUAN');

						$data_edit = $this->PO_model->po_list_by_id_po($ID_PO);
						$KETERANGAN = "Ubah Data PO Form (User Supervisi Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $ID_SPP . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PROGRESS_PO . ";" . $CTT_KEPERLUAN . ";" . $TANGGAL_KIRIM_BARANG_HARI;
						$this->user_log($KETERANGAN);

						$data = $this->PO_model->simpan_perubahan_pdf($ID_PO, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $CTT_KEPERLUAN, $TANGGAL_KIRIM_BARANG_HARI);
						echo json_encode($data);
					}
				}
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

	// TAMPILAN VIEW ONLY
	public function view()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		if ($this->ion_auth->logged_in()) {

			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_PO = $this->uri->segment(3);

			if ($this->ion_auth->in_group(5)) {

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

				$HASH_MD5_PO = $this->uri->segment(3);
				if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
					redirect('PO', 'refresh');
				}

				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_PO);

				$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
				$ID_PO = $hasil['ID_PO'];
				$this->data['ID_PO'] = $ID_PO;
				$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);

				foreach ($this->data['PO']->result() as $PO) :
					$this->data['FILE_NAME_TEMP'] = 'po_' . $HASH_MD5_PO . '.pdf';
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['HASH_MD5_PO'] = $PO->HASH_MD5_PO;
					$this->data['PROGRESS_PO'] = $PO->PROGRESS_PO;
				endforeach;

				$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

				if ($query_file_HASH_MD5_PO->num_rows() > 0) {

					$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

					$hasil = $query_file_HASH_MD5_PO->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
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
				$this->load->view('wasa/user_staff_procurement_kp/content_po_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(6)) {

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

				$HASH_MD5_PO = $this->uri->segment(3);
				if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
					redirect('PO', 'refresh');
				}

				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_PO);

				$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
				$ID_PO = $hasil['ID_PO'];
				$this->data['ID_PO'] = $ID_PO;
				$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);

				foreach ($this->data['PO']->result() as $PO) :
					$this->data['FILE_NAME_TEMP'] = 'po_' . $HASH_MD5_PO . '.pdf';
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['HASH_MD5_PO'] = $PO->HASH_MD5_PO;
					$this->data['PROGRESS_PO'] = $PO->PROGRESS_PO;
				endforeach;

				$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

				if ($query_file_HASH_MD5_PO->num_rows() > 0) {

					$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

					$hasil = $query_file_HASH_MD5_PO->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
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

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_po_form');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(7)) {

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

				$HASH_MD5_PO = $this->uri->segment(3);
				if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
					redirect('PO', 'refresh');
				}

				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_PO);

				$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
				$ID_PO = $hasil['ID_PO'];
				$this->data['ID_PO'] = $ID_PO;
				$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);

				foreach ($this->data['PO']->result() as $PO) :
					$this->data['FILE_NAME_TEMP'] = 'po_' . $HASH_MD5_PO . '.pdf';
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['HASH_MD5_PO'] = $PO->HASH_MD5_PO;
					$this->data['PROGRESS_PO'] = $PO->PROGRESS_PO;
				endforeach;

				$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

				if ($query_file_HASH_MD5_PO->num_rows() > 0) {

					$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

					$hasil = $query_file_HASH_MD5_PO->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
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

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_po_form');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(8)) {

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

				$HASH_MD5_PO = $this->uri->segment(3);
				if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
					redirect('PO', 'refresh');
				}

				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_PO);

				$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
				$ID_PO = $hasil['ID_PO'];
				$this->data['ID_PO'] = $ID_PO;
				$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);

				foreach ($this->data['PO']->result() as $PO) :
					$this->data['FILE_NAME_TEMP'] = 'po_' . $HASH_MD5_PO . '.pdf';
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['HASH_MD5_PO'] = $PO->HASH_MD5_PO;
					$this->data['PROGRESS_PO'] = $PO->PROGRESS_PO;
				endforeach;

				$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

				if ($query_file_HASH_MD5_PO->num_rows() > 0) {

					$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

					$hasil = $query_file_HASH_MD5_PO->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
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
				$this->load->view('wasa/user_staff_procurement_sp/content_po_form');
			} else if ($this->ion_auth->in_group(9)) {

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

				$HASH_MD5_PO = $this->uri->segment(3);
				if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
					redirect('PO', 'refresh');
				}

				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_PO);

				$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
				$ID_PO = $hasil['ID_PO'];
				$this->data['ID_PO'] = $ID_PO;
				$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);

				foreach ($this->data['PO']->result() as $PO) :
					$this->data['FILE_NAME_TEMP'] = 'po_' . $HASH_MD5_PO . '.pdf';
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['HASH_MD5_PO'] = $PO->HASH_MD5_PO;
					$this->data['PROGRESS_PO'] = $PO->PROGRESS_PO;
				endforeach;

				$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

				if ($query_file_HASH_MD5_PO->num_rows() > 0) {

					$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

					$hasil = $query_file_HASH_MD5_PO->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
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
				$this->load->view('wasa/user_supervisi_procurement_sp/content_po_form');
			} else if ($this->ion_auth->in_group(38)) {

				//get data tabel users untuk ditampilkan
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

				$HASH_MD5_PO = $this->uri->segment(3);
				if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
					redirect('PO', 'refresh');
				}

				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_PO);

				$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
				$ID_PO = $hasil['ID_PO'];
				$this->data['ID_PO'] = $ID_PO;
				$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);

				foreach ($this->data['PO']->result() as $PO) :
					$this->data['FILE_NAME_TEMP'] = 'po_' . $HASH_MD5_PO . '.pdf';
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['HASH_MD5_PO'] = $PO->HASH_MD5_PO;
					$this->data['PROGRESS_PO'] = $PO->PROGRESS_PO;
				endforeach;

				$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

				if ($query_file_HASH_MD5_PO->num_rows() > 0) {

					$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

					$hasil = $query_file_HASH_MD5_PO->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
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

				$this->load->view('wasa/user_vendor/head_normal', $this->data);
				$this->load->view('wasa/user_vendor/user_menu');
				$this->load->view('wasa/user_vendor/left_menu');
				$this->load->view('wasa/user_vendor/header_menu');
				$this->load->view('wasa/user_vendor/content_po_form');
				$this->load->view('wasa/user_vendor/footer');
			} else {
				redirect('PO', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	// TAMPILAN VIEW ONLY
	public function submit_invoice()
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

		$HASH_MD5_PO = $this->uri->segment(3);
		if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
			redirect('PO', 'refresh');
		}

		if ($this->ion_auth->logged_in()) {

			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_PO = $this->uri->segment(3);

			if ($this->ion_auth->in_group(38)) {
				$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
				$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_PO);

				$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
				$ID_PO = $hasil['ID_PO'];
				$this->data['ID_PO'] = $ID_PO;
				$this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);

				foreach ($this->data['PO']->result() as $PO) :
					$this->data['FILE_NAME_TEMP'] = 'po_' . $HASH_MD5_PO . '.pdf';
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['HASH_MD5_PO'] = $PO->HASH_MD5_PO;
					$this->data['PROGRESS_PO'] = $PO->PROGRESS_PO;
				endforeach;

				$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

				if ($query_file_HASH_MD5_PO->num_rows() > 0) {

					$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

					$hasil = $query_file_HASH_MD5_PO->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
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

				$this->load->view('wasa/user_vendor/head_normal', $this->data);
				$this->load->view('wasa/user_vendor/user_menu');
				$this->load->view('wasa/user_vendor/left_menu');
				$this->load->view('wasa/user_vendor/header_menu');
				$this->load->view('wasa/user_vendor/content_po_form_submit_invoice');
				$this->load->view('wasa/user_vendor/footer');
			} else {
				redirect('PO', 'refresh');
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
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			}

			// //Query file BY DOK_FILE
			// $query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			// if ($query_DOK_FILE->num_rows() > 0) {
			// 	$hasil = $query_DOK_FILE->row();
			// 	$DOK_FILE = $hasil->DOK_FILE;
			// 	if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
			// 		unlink($file);
			// 	}

			// 	$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

			// 	$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
			// 	redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			// } else {
			// 	$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
			// 	redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			// }
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
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
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
		}
	}

	//Hapus file by button
	function hapus_file_invoice()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		//get data dari parameter URL
		$this->data['DOK_FILE'] = $this->uri->segment(3);

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/submit_invoice/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/submit_invoice/' . $HASH_MD5_PO, 'refresh');
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
		}
	}

	public function cetak_pdf($HASH_MD5_PO)
	{
		$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
		$ID_PO = $hasil['ID_PO'];
		$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
		foreach ($this->data['PO']->result() as $PO) :
			$this->data['ID_PO'] = $PO->ID_PO;
			$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
			$this->data['ID_SPP'] = $PO->ID_SPP;
			$this->data['ID_PROYEK'] = $PO->ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $PO->ID_PROYEK_LOKASI_PENYERAHAN;
			$this->data['ID_TERM_OF_PAYMENT'] = $PO->ID_TERM_OF_PAYMENT;
			$this->data['ID_VENDOR'] = $PO->ID_VENDOR;
			$this->data['TANGGAL_DOKUMEN_PO'] = $PO->TANGGAL_DOKUMEN_PO;
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $PO->TANGGAL_KIRIM_BARANG_HARI;
			$this->data['CTT_KEPERLUAN'] = $PO->CTT_KEPERLUAN;
			$this->data['TOTAL_HARGA_PO_BARANG'] = $PO->TOTAL_HARGA_PO_BARANG;
			$this->data['TOTAL_PAJAK_PO_BARANG'] = $PO->TOTAL_PAJAK_PO_BARANG;
			$this->data['TOTAL_ALL_PO_BARANG'] = $PO->TOTAL_ALL_PO_BARANG;
		endforeach;

		if ($this->data['ID_SPP'] == "0" || $this->data['ID_SPP'] == null) {
			$this->data['NO_URUT_SPP'] = "";
		} else {
			$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp($this->data['ID_SPP']);
			foreach ($this->data['SPP']->result() as $SPP) :
				$this->data['NO_URUT_SPP'] = $SPP->NO_URUT_SPP;
			endforeach;
		}

		$this->data['PAJAK'] = $this->PO_form_model->pajak_by_id_po_non_result($ID_PO);
		foreach ($this->data['PAJAK']->result() as $PAJAK) :
			$this->data['KETERANGAN'] = $PAJAK->KETERANGAN;
		endforeach;

		if (empty($this->data['KETERANGAN'])) {
			// list is empty.
			$this->data['KETERANGAN'] = "";
		}

		if ($this->data['ID_PROYEK_LOKASI_PENYERAHAN'] == "0" || $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] == null) {
			$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
		} else {
			$this->data['PROYEK_LOKASI_PENYERAHAN'] = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			foreach ($this->data['PROYEK_LOKASI_PENYERAHAN']->result() as $PROYEK_LOKASI_PENYERAHAN) :
				$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
			endforeach;
		}

		if ($this->data['ID_TERM_OF_PAYMENT'] == "0" || $this->data['ID_TERM_OF_PAYMENT'] == null) {
			$this->data['NAMA_TERM_OF_PAYMENT'] = "";
		} else {
			$this->data['TERM_OF_PAYMENT'] = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			foreach ($this->data['TERM_OF_PAYMENT']->result() as $TERM_OF_PAYMENT) :
				$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
			endforeach;
		}

		if ($this->data['ID_VENDOR'] == "0" || $this->data['ID_VENDOR'] == null) {
			$this->data['NAMA_VENDOR'] = "";
			$this->data['ALAMAT_VENDOR'] = "";
			$this->data['NO_TELP_VENDOR'] = "";
			$this->data['NAMA_PIC_VENDOR'] = "";
			$this->data['NO_HP_PIC_VENDOR'] = "";
		} else {
			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			foreach ($hasil->result() as $VENDOR) :
				$NAMA_VENDOR = $VENDOR->NAMA_VENDOR;
				$ALAMAT_VENDOR = $VENDOR->ALAMAT_VENDOR;
				$NO_TELP_VENDOR = $VENDOR->NO_TELP_VENDOR;
				$NAMA_PIC_VENDOR = $VENDOR->NAMA_PIC_VENDOR;
				$NO_HP_PIC_VENDOR = $VENDOR->NO_HP_PIC_VENDOR;
			endforeach;
			$this->data['NAMA_VENDOR'] = $NAMA_VENDOR;
			$this->data['ALAMAT_VENDOR'] = $ALAMAT_VENDOR;
			$this->data['NO_TELP_VENDOR'] = $NO_TELP_VENDOR;
			$this->data['NAMA_PIC_VENDOR'] = $NAMA_PIC_VENDOR;
			$this->data['NO_HP_PIC_VENDOR'] = $NO_HP_PIC_VENDOR;
		}

		$this->data['sign_PO_form'] = $this->PO_form_model->sign_po_by_id_po_non_result($ID_PO);
		foreach ($this->data['sign_PO_form']->result() as $PO) :
			$this->data['SIGN_USER_M_PROC'] = $PO->SIGN_USER_M_PROC;
			$this->data['SIGN_USER_KASIE_PROC'] = $PO->SIGN_USER_KASIE_PROC;
		endforeach;

		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['konten_PO_form'] = $this->PO_form_model->po_form_list_by_id_po($ID_PO);

		$this->data['TOTAL_HARGA_PO_BARANG'] = 0;
		foreach ($this->data['konten_PO_form'] as $item) {
			$this->data['TOTAL_HARGA_PO_BARANG'] = $this->data['TOTAL_HARGA_PO_BARANG'] + $item->HARGA_TOTAL_FIX;
		}
		$total = $this->update_data_TOTAL_HARGA_PO_BARANG($this->data['ID_PO'], $this->data['TOTAL_HARGA_PO_BARANG']);

		$this->data['TOTAL_PAJAK_PO_BARANG'] = 0;
		foreach ($this->data['konten_PO_form'] as $item) {
			$this->data['TOTAL_PAJAK_PO_BARANG'] = $this->data['TOTAL_PAJAK_PO_BARANG'] + ($item->HARGA_TOTAL_FIX * $item->TARIF_PAJAK / 100);
		}
		$total = $this->update_data_TOTAL_PAJAK_PO_BARANG($this->data['ID_PO'], $this->data['TOTAL_PAJAK_PO_BARANG']);

		$this->data['TOTAL_ALL_PO_BARANG'] = $this->data['TOTAL_HARGA_PO_BARANG'] + $this->data['TOTAL_PAJAK_PO_BARANG'];
		$total = $this->update_data_TOTAL_ALL_PO_BARANG($this->data['ID_PO'], $this->data['TOTAL_ALL_PO_BARANG']);

		// $this->data['USER_PENGAJU'] = $this->FPB_form_model->ID_JABATAN_BY_ID_FPB($ID_FPB);

		// foreach ($this->data['FPB']->result() as $FPB) :
		// 	$FILE_NAME_TEMP = $FPB->FILE_NAME_TEMP;
		// 	$this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
		// endforeach;

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Order Pembelian';

		// filename dari pdf ketika didownload
		$file_pdf = 'po_' . $HASH_MD5_PO;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "potrait";

		$html = $this->load->view('wasa/pdf/po_pdf', $this->data, true);

		//run dompdf
		$x          = 500;
		$y          = 800;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 10;

		$file_path = "assets/PO/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	public function cetak_harga_pdf($HASH_MD5_PO)
	{
		$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
		$ID_PO = $hasil['ID_PO'];
		$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);
		foreach ($this->data['PO']->result() as $PO) :
			$this->data['ID_PO'] = $PO->ID_PO;
			$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
			$this->data['ID_SPP'] = $PO->ID_SPP;
			$this->data['ID_PROYEK'] = $PO->ID_PROYEK;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $PO->ID_PROYEK_LOKASI_PENYERAHAN;
			$this->data['ID_TERM_OF_PAYMENT'] = $PO->ID_TERM_OF_PAYMENT;
			$this->data['ID_VENDOR'] = $PO->ID_VENDOR;
			$this->data['TANGGAL_PEMBUATAN_PO_HARI'] = $PO->TANGGAL_PEMBUATAN_PO_HARI;
			$this->data['TANGGAL_PEMBUATAN_PO_BULAN'] = $PO->TANGGAL_PEMBUATAN_PO_BULAN;
			$this->data['TANGGAL_PEMBUATAN_PO_TAHUN'] = $PO->TANGGAL_PEMBUATAN_PO_TAHUN;
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $PO->TANGGAL_KIRIM_BARANG_HARI;

		endforeach;

		if ($this->data['ID_SPP'] == "0" || $this->data['ID_SPP'] == null) {
			$this->data['NO_URUT_SPP'] = "";
		} else {
			$this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp($this->data['ID_SPP']);
			foreach ($this->data['SPP']->result() as $SPP) :
				$this->data['NO_URUT_SPP'] = $SPP->NO_URUT_SPP;
			endforeach;
		}

		if ($this->data['ID_PROYEK_LOKASI_PENYERAHAN'] == "0" || $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] == null) {
			$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
		} else {
			$this->data['PROYEK_LOKASI_PENYERAHAN'] = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK']);
			foreach ($this->data['PROYEK_LOKASI_PENYERAHAN']->result() as $PROYEK_LOKASI_PENYERAHAN) :
				$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
			endforeach;
		}

		if ($this->data['ID_TERM_OF_PAYMENT'] == "0" || $this->data['ID_TERM_OF_PAYMENT'] == null) {
			$this->data['NAMA_TERM_OF_PAYMENT'] = "";
		} else {
			$this->data['TERM_OF_PAYMENT'] = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			foreach ($this->data['TERM_OF_PAYMENT']->result() as $TERM_OF_PAYMENT) :
				$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
			endforeach;
		}

		if ($this->data['ID_VENDOR'] == "0" || $this->data['ID_VENDOR'] == null) {
			$this->data['NAMA_VENDOR'] = "";
			$this->data['ALAMAT_VENDOR'] = "";
			$this->data['NO_TELP_VENDOR'] = "";
			$this->data['NAMA_PIC_VENDOR'] = "";
			$this->data['NO_HP_PIC_VENDOR'] = "";
		} else {
			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			foreach ($hasil->result() as $VENDOR) :
				$NAMA_VENDOR = $VENDOR->NAMA_VENDOR;
				$ALAMAT_VENDOR = $VENDOR->ALAMAT_VENDOR;
				$NO_TELP_VENDOR = $VENDOR->NO_TELP_VENDOR;
				$NAMA_PIC_VENDOR = $VENDOR->NAMA_PIC_VENDOR;
				$NO_HP_PIC_VENDOR = $VENDOR->NO_HP_PIC_VENDOR;
			endforeach;
			$this->data['NAMA_VENDOR'] = $NAMA_VENDOR;
			$this->data['ALAMAT_VENDOR'] = $ALAMAT_VENDOR;
			$this->data['NO_TELP_VENDOR'] = $NO_TELP_VENDOR;
			$this->data['NAMA_PIC_VENDOR'] = $NAMA_PIC_VENDOR;
			$this->data['NO_HP_PIC_VENDOR'] = $NO_HP_PIC_VENDOR;
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

		$this->data['konten_PO_form'] = $this->PO_form_model->po_form_list_by_id_po($ID_PO);
		// $this->data['USER_PENGAJU'] = $this->FPB_form_model->ID_JABATAN_BY_ID_FPB($ID_FPB);

		// foreach ($this->data['FPB']->result() as $FPB) :
		// 	$FILE_NAME_TEMP = $FPB->FILE_NAME_TEMP;
		// 	$this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
		// endforeach;

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Order Pembelian';

		// filename dari pdf ketika didownload
		$file_pdf = 'po_vendor_' . $HASH_MD5_PO;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "potrait";

		$html = $this->load->view('wasa/pdf/po_vendor_pdf', $this->data, true);

		//run dompdf
		$x          = 500;
		$y          = 800;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 10;

		$file_path = "assets/PO/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	function update_data_catatan_po()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_PROC', 'Catatan PO Staff Procurement KP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$CTT_STAFF_PROC = $this->input->post('CTT_STAFF_PROC');

				$data_edit = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$KETERANGAN = "Ubah Data Catatan PO (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $CTT_STAFF_PROC;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_CTT_STAFF_PROC($ID_PO, $CTT_STAFF_PROC);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_KASIE', 'Catatan PO Kasie Procurement KP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$CTT_KASIE = $this->input->post('CTT_KASIE');

				$data_edit = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$KETERANGAN = "Ubah Data Catatan PO (User Kasie Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $CTT_KASIE;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_CTT_KASIE($ID_PO, $CTT_KASIE);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_MANAGER_PROC', 'Catatan PO Manajer Procurement KP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$CTT_MANAGER_PROC = $this->input->post('CTT_MANAGER_PROC');

				$data_edit = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$KETERANGAN = "Ubah Data Catatan PO (User Manajer Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $CTT_MANAGER_PROC;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_CTT_MANAGER_PROC($ID_PO, $CTT_MANAGER_PROC);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_PROC_SP', 'Catatan PO Staff Procurement SP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$CTT_STAFF_PROC_SP = $this->input->post('CTT_STAFF_PROC_SP');

				$data_edit = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$KETERANGAN = "Ubah Data Catatan PO (User Staff Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $CTT_STAFF_PROC_SP;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_CTT_STAFF_PROC_SP($ID_PO, $CTT_STAFF_PROC_SP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_SUPERVISI_PROC_SP', 'Catatan PO Supervisi Procurement SP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$CTT_SUPERVISI_PROC_SP = $this->input->post('CTT_SUPERVISI_PROC_SP');

				$data_edit = $this->PO_form_model->get_data_catatan_po_by_id_po($ID_PO);
				$KETERANGAN = "Ubah Data Catatan PO (User Supervisi Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $CTT_SUPERVISI_PROC_SP;
				$this->user_log($KETERANGAN);

				$data = $this->PO_form_model->update_data_CTT_SUPERVISI_PROC_SP($ID_PO, $CTT_SUPERVISI_PROC_SP);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_kirim_po()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			//set validation rules
			$this->form_validation->set_rules('ID_PO', 'ID_PO ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');

				$KETERANGAN = "Kirim Form PO ke Proses Selanjutnya: " . " ---- " . $ID_PO;
				$this->user_log($KETERANGAN);

				$PROGRESS_PO = "Dalam Proses Kasie Procurement KP";
				$STATUS_PO = "Proses Pengajuan";

				$data = $this->PO_form_model->update_data_kirim_po($ID_PO, $PROGRESS_PO, $STATUS_PO);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			//set validation rules
			$this->form_validation->set_rules('ID_PO', 'ID_PO ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');

				$KETERANGAN = "Kirim Form PO ke Proses Selanjutnya: " . " ---- " . $ID_PO;
				$this->user_log($KETERANGAN);

				$PROGRESS_PO = "Dalam Proses Manajer Procurement KP";
				$STATUS_PO = "Proses Pengajuan";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_PO = date("Y-m-d", $d);

				$DATE_SIGN_USER_KASIE_PROC = date("Y-m-d H:i:s");
				$SIGN_USER_KASIE_PROC =  $DATE_SIGN_USER_KASIE_PROC;

				//DUE DATE UNTUK SM +1 HARI DARI DATE SIGN PEMINTA
				$date = new DateTime();
				$date->add(new DateInterval('P1D'));
				$DUE_DATE_KASIE_PROC = $date->format('Y-m-d H:i:s');

				$data = $this->PO_form_model->update_data_kirim_po_user_kasie_proc($ID_PO, $PROGRESS_PO, $STATUS_PO, $SIGN_USER_KASIE_PROC);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			//set validation rules
			$this->form_validation->set_rules('ID_PO', 'ID_PO ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');

				$KETERANGAN = "Kirim Form PO ke Proses Selanjutnya: " . " ---- " . $ID_PO;
				$this->user_log($KETERANGAN);

				$PROGRESS_PO = "Dalam Proses Manajer Procurement KP";
				$STATUS_PO = "Proses Pengajuan";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_PO = date("Y-m-d", $d);

				$DATE_SIGN_USER_M_PROC = date("Y-m-d H:i:s");
				$SIGN_USER_M_PROC =  $DATE_SIGN_USER_M_PROC;
				$SIGN_USER_KASIE_PROC =  $DATE_SIGN_USER_M_PROC;

				//DUE DATE UNTUK KASIE PROC +1 HARI DARI DATE SIGN PEMINTA
				$date = new DateTime();
				$date->add(new DateInterval('P1D'));
				$DUE_DATE_M_PROC = $date->format('Y-m-d H:i:s');

				$data = $this->PO_form_model->update_data_kirim_po_user_m_proc($ID_PO, $PROGRESS_PO, $STATUS_PO, $SIGN_USER_M_PROC, $SIGN_USER_KASIE_PROC);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			//set validation rules
			$this->form_validation->set_rules('ID_PO', 'ID_PO ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');

				$KETERANGAN = "Kirim Form PO ke Proses Selanjutnya: " . " ---- " . $ID_PO;
				$this->user_log($KETERANGAN);

				$PROGRESS_PO = "Dalam Proses Supervisi Procurement SP";
				$STATUS_PO = "Proses Pengajuan";

				$data = $this->PO_form_model->update_data_kirim_po($ID_PO, $PROGRESS_PO, $STATUS_PO);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			//set validation rules
			$this->form_validation->set_rules('ID_PO', 'ID_PO ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');

				$KETERANGAN = "Kirim Form PO ke Proses Selanjutnya: " . " ---- " . $ID_PO;
				$this->user_log($KETERANGAN);

				$PROGRESS_PO = "Dalam Proses Staff Procurement KP";
				$STATUS_PO = "Proses Pengajuan";

				$data = $this->PO_form_model->update_data_kirim_po($ID_PO, $PROGRESS_PO, $STATUS_PO);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function generate_password()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$USERNAME = $this->input->post('USERNAME');
			$password = md5($USERNAME);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$USERNAME = $this->input->post('USERNAME');
			$password = md5($USERNAME);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$USERNAME = $this->input->post('USERNAME');
			$password = md5($USERNAME);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			$USERNAME = $this->input->post('USERNAME');
			$password = md5($USERNAME);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$USERNAME = $this->input->post('USERNAME');
			$password = md5($USERNAME);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$USERNAME = $this->input->post('USERNAME');
			$password = md5($USERNAME);

			echo json_encode($password);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function generate_password_2()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$t = time();
			$password = md5($t);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$t = time();
			$password = md5($t);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$t = time();
			$password = md5($t);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			$t = time();
			$password = md5($t);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$t = time();
			$password = md5($t);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$t = time();
			$password = md5($t);

			echo json_encode($password);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	public function kirim_email($HASH_MD5_PO)
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

		if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
			redirect('PO', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['NAMA_VENDOR'] = "";
				$this->data['NAMA_PIC_VENDOR'] = "";
				$this->data['EMAIL_PIC_VENDOR'] = "";
				$this->data['EMAIL_VENDOR'] = "";
			} else {
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;
			}

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->PO_form_model->users_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['USERNAME'] = "";
				$this->data['PASSWORD'] = "";
				$this->data['EXPIRED'] = "";
			} else {
				foreach ($hasil->result() as $USERS) :
					$this->data['USERNAME'] = $USERS->username;
					$this->data['PASSWORD'] = $USERS->password;
					$this->data['EXPIRED'] = $USERS->expired;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_po_form_kirim_email');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['NAMA_VENDOR'] = "";
				$this->data['NAMA_PIC_VENDOR'] = "";
				$this->data['EMAIL_PIC_VENDOR'] = "";
				$this->data['EMAIL_VENDOR'] = "";
			} else {
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;
			}

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->PO_form_model->users_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['USERNAME'] = "";
				$this->data['PASSWORD'] = "";
				$this->data['EXPIRED'] = "";
			} else {
				foreach ($hasil->result() as $USERS) :
					$this->data['USERNAME'] = $USERS->username;
					$this->data['PASSWORD'] = $USERS->password;
					$this->data['EXPIRED'] = $USERS->expired;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_po_form_kirim_email');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['NAMA_VENDOR'] = "";
				$this->data['NAMA_PIC_VENDOR'] = "";
				$this->data['EMAIL_PIC_VENDOR'] = "";
				$this->data['EMAIL_VENDOR'] = "";
			} else {
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;
			}

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->PO_form_model->users_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['USERNAME'] = "";
				$this->data['PASSWORD'] = "";
				$this->data['EXPIRED'] = "";
			} else {
				foreach ($hasil->result() as $USERS) :
					$this->data['USERNAME'] = $USERS->username;
					$this->data['PASSWORD'] = $USERS->password;
					$this->data['EXPIRED'] = $USERS->expired;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_po_form_kirim_email');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['NAMA_VENDOR'] = "";
				$this->data['NAMA_PIC_VENDOR'] = "";
				$this->data['EMAIL_PIC_VENDOR'] = "";
				$this->data['EMAIL_VENDOR'] = "";
			} else {
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;
			}

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->PO_form_model->users_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['USERNAME'] = "";
				$this->data['PASSWORD'] = "";
				$this->data['EXPIRED'] = "";
			} else {
				foreach ($hasil->result() as $USERS) :
					$this->data['USERNAME'] = $USERS->username;
					$this->data['PASSWORD'] = $USERS->password;
					$this->data['EXPIRED'] = $USERS->expired;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_po_form_kirim_email');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['NAMA_VENDOR'] = "";
				$this->data['NAMA_PIC_VENDOR'] = "";
				$this->data['EMAIL_PIC_VENDOR'] = "";
				$this->data['EMAIL_VENDOR'] = "";
			} else {
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;
			}

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->PO_form_model->users_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['USERNAME'] = "";
				$this->data['PASSWORD'] = "";
				$this->data['EXPIRED'] = "";
			} else {
				foreach ($hasil->result() as $USERS) :
					$this->data['USERNAME'] = $USERS->username;
					$this->data['PASSWORD'] = $USERS->password;
					$this->data['EXPIRED'] = $USERS->expired;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_po_form_kirim_email');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');
		} else {
			$this->logout();
		}
	}

	function simpan_akun_vendor()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//set validation rules
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				$EXPIRED = $this->input->post('EXPIRED');

				if ($this->Vendor_model->cek_username_users($USERNAME) == 'Data belum ada') {

					$data = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
					$this->data['ID_VENDOR'] = $data['ID_VENDOR'];
					$ID_VENDOR = $this->data['ID_VENDOR'];
					$EXPIRED_KIRIM = $EXPIRED;
					$date = date_create($EXPIRED);
					$EXPIRED = date_timestamp_get($date);

					$STATUS_DATA_PEGAWAI = 'vendor';
					$CREATED_ON =  time();
					$EMAIL = $EMAIL_VENDOR;
					$PASSWORD_KIRIM = $PASSWORD_UTAMA;
					$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
					$this->Vendor_model->register_users($USERNAME, $PASSWORD_UTAMA, $EMAIL, $CREATED_ON, $EXPIRED, $ID_VENDOR, $STATUS_DATA_PEGAWAI);

					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_VENDOR ='$ID_VENDOR' AND username ='$USERNAME' ");
					if ($hsl_2->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '38')");

					echo ($data);
				} else {
					echo 'Nama username sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//set validation rules
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				$EXPIRED = $this->input->post('EXPIRED');

				if ($this->Vendor_model->cek_username_users($USERNAME) == 'Data belum ada') {

					$data = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
					$this->data['ID_VENDOR'] = $data['ID_VENDOR'];
					$ID_VENDOR = $this->data['ID_VENDOR'];
					$EXPIRED_KIRIM = $EXPIRED;
					$date = date_create($EXPIRED);
					$EXPIRED = date_timestamp_get($date);

					$STATUS_DATA_PEGAWAI = 'vendor';
					$CREATED_ON =  time();
					$EMAIL = $EMAIL_VENDOR;
					$PASSWORD_KIRIM = $PASSWORD_UTAMA;
					$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
					$this->Vendor_model->register_users($USERNAME, $PASSWORD_UTAMA, $EMAIL, $CREATED_ON, $EXPIRED, $ID_VENDOR, $STATUS_DATA_PEGAWAI);

					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_VENDOR ='$ID_VENDOR' AND username ='$USERNAME' ");
					if ($hsl_2->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '38')");

					echo ($data);
				} else {
					echo 'Nama username sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//set validation rules
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				$EXPIRED = $this->input->post('EXPIRED');

				if ($this->Vendor_model->cek_username_users($USERNAME) == 'Data belum ada') {

					$data = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
					$this->data['ID_VENDOR'] = $data['ID_VENDOR'];
					$ID_VENDOR = $this->data['ID_VENDOR'];
					$EXPIRED_KIRIM = $EXPIRED;
					$date = date_create($EXPIRED);
					$EXPIRED = date_timestamp_get($date);

					$STATUS_DATA_PEGAWAI = 'vendor';
					$CREATED_ON =  time();
					$EMAIL = $EMAIL_VENDOR;
					$PASSWORD_KIRIM = $PASSWORD_UTAMA;
					$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
					$this->Vendor_model->register_users($USERNAME, $PASSWORD_UTAMA, $EMAIL, $CREATED_ON, $EXPIRED, $ID_VENDOR, $STATUS_DATA_PEGAWAI);

					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_VENDOR ='$ID_VENDOR' AND username ='$USERNAME' ");
					if ($hsl_2->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '38')");

					echo ($data);
				} else {
					echo 'Nama username sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//set validation rules
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				$EXPIRED = $this->input->post('EXPIRED');

				if ($this->Vendor_model->cek_username_users($USERNAME) == 'Data belum ada') {

					$data = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
					$this->data['ID_VENDOR'] = $data['ID_VENDOR'];
					$ID_VENDOR = $this->data['ID_VENDOR'];
					$EXPIRED_KIRIM = $EXPIRED;
					$date = date_create($EXPIRED);
					$EXPIRED = date_timestamp_get($date);

					$STATUS_DATA_PEGAWAI = 'vendor';
					$CREATED_ON =  time();
					$EMAIL = $EMAIL_VENDOR;
					$PASSWORD_KIRIM = $PASSWORD_UTAMA;
					$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
					$this->Vendor_model->register_users($USERNAME, $PASSWORD_UTAMA, $EMAIL, $CREATED_ON, $EXPIRED, $ID_VENDOR, $STATUS_DATA_PEGAWAI);

					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_VENDOR ='$ID_VENDOR' AND username ='$USERNAME' ");
					if ($hsl_2->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '38')");

					echo ($data);
				} else {
					echo 'Nama username sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//set validation rules
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				$EXPIRED = $this->input->post('EXPIRED');

				if ($this->Vendor_model->cek_username_users($USERNAME) == 'Data belum ada') {

					$data = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
					$this->data['ID_VENDOR'] = $data['ID_VENDOR'];
					$ID_VENDOR = $this->data['ID_VENDOR'];
					$EXPIRED_KIRIM = $EXPIRED;
					$date = date_create($EXPIRED);
					$EXPIRED = date_timestamp_get($date);

					$STATUS_DATA_PEGAWAI = 'vendor';
					$CREATED_ON =  time();
					$EMAIL = $EMAIL_VENDOR;
					$PASSWORD_KIRIM = $PASSWORD_UTAMA;
					$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
					$this->Vendor_model->register_users($USERNAME, $PASSWORD_UTAMA, $EMAIL, $CREATED_ON, $EXPIRED, $ID_VENDOR, $STATUS_DATA_PEGAWAI);

					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_VENDOR ='$ID_VENDOR' AND username ='$USERNAME' ");
					if ($hsl_2->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '38')");

					echo ($data);
				} else {
					echo 'Nama username sudah terekam sebelumnya';
				}
			}
		} else {
			$this->logout();
		}
	}

	function update_password_vendor()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//set validation rules
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				$EXPIRED = $this->input->post('EXPIRED');

				$date = date_create($EXPIRED);
				$EXPIRED = date_timestamp_get($date);
				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
				$data = $this->Vendor_model->update_password_users($USERNAME, $PASSWORD_UTAMA, $EXPIRED);

				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//set validation rules
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				$EXPIRED = $this->input->post('EXPIRED');

				$date = date_create($EXPIRED);
				$EXPIRED = date_timestamp_get($date);
				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
				$data = $this->Vendor_model->update_password_users($USERNAME, $PASSWORD_UTAMA, $EXPIRED);

				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//set validation rules
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				$EXPIRED = $this->input->post('EXPIRED');

				$date = date_create($EXPIRED);
				$EXPIRED = date_timestamp_get($date);
				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
				$data = $this->Vendor_model->update_password_users($USERNAME, $PASSWORD_UTAMA, $EXPIRED);

				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//set validation rules
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				$EXPIRED = $this->input->post('EXPIRED');

				$date = date_create($EXPIRED);
				$EXPIRED = date_timestamp_get($date);
				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
				$data = $this->Vendor_model->update_password_users($USERNAME, $PASSWORD_UTAMA, $EXPIRED);

				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//set validation rules
			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				$EXPIRED = $this->input->post('EXPIRED');

				$date = date_create($EXPIRED);
				$EXPIRED = date_timestamp_get($date);
				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
				$data = $this->Vendor_model->update_password_users($USERNAME, $PASSWORD_UTAMA, $EXPIRED);

				echo ($data);
			}
		} else {
			$this->logout();
		}
	}

	function kirim_email_po()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|max_length[30]|required|valid_email');
			$this->form_validation->set_rules('ISI_BODY', 'Isi Body', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$ISI_BODY = $this->input->post('ISI_BODY');
				$HASH_MD5_PO = $this->input->post('HASH_MD5_PO');
				$NO_URUT_PO = $this->input->post('NO_URUT_PO');

				$data_edit = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
				$KETERANGAN = "Isi PO: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);

				$KETERANGAN = "Update Data PO Form: " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $NAMA_PIC_VENDOR . ";" . $EMAIL_PIC_VENDOR . ";" . $ISI_BODY . ";" . $NO_URUT_PO;
				$this->user_log($KETERANGAN);
				$data = $this->PO_form_model->update_data_kirim_email($ID_PO, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $ISI_BODY);

				//Load email library
				$this->load->library('email');

				//SMTP & mail configuration
				// $config = array(
				// 	'protocol'  => 'smtp',
				// 	'smtp_host' => 'ssl://smtp.gmail.com',
				// 	'smtp_port' => 465,
				// 	'smtp_user' => 'userforkindo@gmail.com',
				// 	'smtp_pass' => 'Andasiapa21_',
				// 	'mailtype' => 'html',
				// 	'charset' => 'utf-8'
				// );

				$config = array(
					'protocol'  => 'smtp',
					'smtp_host' => 'mail.wasamitra.co.id',
					'smtp_port' => 25,
					'smtp_user' => 'notifikasi@wasamitra.co.id',
					'smtp_pass' => 'Eam.wme2022',
					'smtp_timeout' => '10',
					'mailtype' => 'html',
					'charset' => 'utf-8'
				);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");

				//Email content
				$htmlContent = $ISI_BODY;

				$this->email->to($EMAIL_PIC_VENDOR);
				$this->email->cc('notifikasi@wasamitra.co.id');
				$this->email->from('notifikasi@wasamitra.co.id', 'Departemen Procurement PT WME');
				$judul = 'WME | Purchase Order ' . $NO_URUT_PO;
				$this->email->subject($judul);
				$this->email->message($htmlContent);
				$alamat_1 = 'C:\xampp\htdocs\project_eam\assets\PO';
				$ekstensi = '\po_' . $HASH_MD5_PO . '.pdf';
				$alamat_pdf = $alamat_1 . $ekstensi;
				$this->email->attach($alamat_pdf);

				//Send email
				if ($this->email->send()) {
					echo 'Email Terkirim ke Vendor.';
				} else {
					show_error($this->email->print_debugger());
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|max_length[30]|required|valid_email');
			$this->form_validation->set_rules('ISI_BODY', 'Isi Body', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$ISI_BODY = $this->input->post('ISI_BODY');
				$HASH_MD5_PO = $this->input->post('HASH_MD5_PO');
				$NO_URUT_PO = $this->input->post('NO_URUT_PO');

				$data_edit = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
				$KETERANGAN = "Isi PO: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);

				$KETERANGAN = "Update Data PO Form: " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $NAMA_PIC_VENDOR . ";" . $EMAIL_PIC_VENDOR . ";" . $ISI_BODY . ";" . $NO_URUT_PO;
				$this->user_log($KETERANGAN);
				$data = $this->PO_form_model->update_data_kirim_email($ID_PO, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $ISI_BODY);

				//Load email library
				$this->load->library('email');

				//SMTP & mail configuration
				// $config = array(
				// 	'protocol'  => 'smtp',
				// 	'smtp_host' => 'ssl://smtp.gmail.com',
				// 	'smtp_port' => 465,
				// 	'smtp_user' => 'userforkindo@gmail.com',
				// 	'smtp_pass' => 'Andasiapa21_',
				// 	'mailtype' => 'html',
				// 	'charset' => 'utf-8'
				// );

				$config = array(
					'protocol'  => 'smtp',
					'smtp_host' => 'mail.wasamitra.co.id',
					'smtp_port' => 25,
					'smtp_user' => 'notifikasi@wasamitra.co.id',
					'smtp_pass' => 'Eam.wme2022',
					'smtp_timeout' => '10',
					'mailtype' => 'html',
					'charset' => 'utf-8'
				);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");

				//Email content
				$htmlContent = $ISI_BODY;

				$this->email->to($EMAIL_PIC_VENDOR);
				$this->email->cc('notifikasi@wasamitra.co.id');
				$this->email->from('notifikasi@wasamitra.co.id', 'Departemen Procurement PT WME');
				$judul = 'WME | Purchase Order ' . $NO_URUT_PO;
				$this->email->subject($judul);
				$this->email->message($htmlContent);
				$alamat_1 = 'C:\xampp\htdocs\project_eam\assets\PO';
				$ekstensi = '\po_' . $HASH_MD5_PO . '.pdf';
				$alamat_pdf = $alamat_1 . $ekstensi;
				$this->email->attach($alamat_pdf);

				//Send email
				if ($this->email->send()) {
					echo 'Email Terkirim ke Vendor.';
				} else {
					show_error($this->email->print_debugger());
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|max_length[30]|required|valid_email');
			$this->form_validation->set_rules('ISI_BODY', 'Isi Body', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$ISI_BODY = $this->input->post('ISI_BODY');
				$HASH_MD5_PO = $this->input->post('HASH_MD5_PO');
				$NO_URUT_PO = $this->input->post('NO_URUT_PO');

				$data_edit = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
				$KETERANGAN = "Isi PO: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);

				$KETERANGAN = "Update Data PO Form: " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $NAMA_PIC_VENDOR . ";" . $EMAIL_PIC_VENDOR . ";" . $ISI_BODY . ";" . $NO_URUT_PO;
				$this->user_log($KETERANGAN);
				$data = $this->PO_form_model->update_data_kirim_email($ID_PO, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $ISI_BODY);

				//Load email library
				$this->load->library('email');

				//SMTP & mail configuration
				// $config = array(
				// 	'protocol'  => 'smtp',
				// 	'smtp_host' => 'ssl://smtp.gmail.com',
				// 	'smtp_port' => 465,
				// 	'smtp_user' => 'userforkindo@gmail.com',
				// 	'smtp_pass' => 'Andasiapa21_',
				// 	'mailtype' => 'html',
				// 	'charset' => 'utf-8'
				// );

				$config = array(
					'protocol'  => 'smtp',
					'smtp_host' => 'mail.wasamitra.co.id',
					'smtp_port' => 25,
					'smtp_user' => 'notifikasi@wasamitra.co.id',
					'smtp_pass' => 'Eam.wme2022',
					'smtp_timeout' => '10',
					'mailtype' => 'html',
					'charset' => 'utf-8'
				);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");

				//Email content
				$htmlContent = $ISI_BODY;

				$this->email->to($EMAIL_PIC_VENDOR);
				$this->email->cc('notifikasi@wasamitra.co.id');
				$this->email->from('notifikasi@wasamitra.co.id', 'Departemen Procurement PT WME');
				$judul = 'WME | Purchase Order ' . $NO_URUT_PO;
				$this->email->subject($judul);
				$this->email->message($htmlContent);
				$alamat_1 = 'C:\xampp\htdocs\project_eam\assets\PO';
				$ekstensi = '\po_' . $HASH_MD5_PO . '.pdf';
				$alamat_pdf = $alamat_1 . $ekstensi;
				$this->email->attach($alamat_pdf);

				//Send email
				if ($this->email->send()) {
					echo 'Email Terkirim ke Vendor.';
				} else {
					show_error($this->email->print_debugger());
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|max_length[30]|required|valid_email');
			$this->form_validation->set_rules('ISI_BODY', 'Isi Body', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$ISI_BODY = $this->input->post('ISI_BODY');
				$HASH_MD5_PO = $this->input->post('HASH_MD5_PO');
				$NO_URUT_PO = $this->input->post('NO_URUT_PO');

				$data_edit = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
				$KETERANGAN = "Isi PO: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);

				$KETERANGAN = "Update Data PO Form: " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $NAMA_PIC_VENDOR . ";" . $EMAIL_PIC_VENDOR . ";" . $ISI_BODY . ";" . $NO_URUT_PO;
				$this->user_log($KETERANGAN);
				$data = $this->PO_form_model->update_data_kirim_email($ID_PO, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $ISI_BODY);

				//Load email library
				$this->load->library('email');

				//SMTP & mail configuration
				// $config = array(
				// 	'protocol'  => 'smtp',
				// 	'smtp_host' => 'ssl://smtp.gmail.com',
				// 	'smtp_port' => 465,
				// 	'smtp_user' => 'userforkindo@gmail.com',
				// 	'smtp_pass' => 'Andasiapa21_',
				// 	'mailtype' => 'html',
				// 	'charset' => 'utf-8'
				// );

				$config = array(
					'protocol'  => 'smtp',
					'smtp_host' => 'mail.wasamitra.co.id',
					'smtp_port' => 25,
					'smtp_user' => 'notifikasi@wasamitra.co.id',
					'smtp_pass' => 'Eam.wme2022',
					'smtp_timeout' => '10',
					'mailtype' => 'html',
					'charset' => 'utf-8'
				);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");

				//Email content
				$htmlContent = $ISI_BODY;

				$this->email->to($EMAIL_PIC_VENDOR);
				$this->email->cc('notifikasi@wasamitra.co.id');
				$this->email->from('notifikasi@wasamitra.co.id', 'Departemen Procurement PT WME');
				$judul = 'WME | Purchase Order ' . $NO_URUT_PO;
				$this->email->subject($judul);
				$this->email->message($htmlContent);
				$alamat_1 = 'C:\xampp\htdocs\project_eam\assets\PO';
				$ekstensi = '\po_' . $HASH_MD5_PO . '.pdf';
				$alamat_pdf = $alamat_1 . $ekstensi;
				$this->email->attach($alamat_pdf);

				//Send email
				if ($this->email->send()) {
					echo 'Email Terkirim ke Vendor.';
				} else {
					show_error($this->email->print_debugger());
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|max_length[30]|required|valid_email');
			$this->form_validation->set_rules('ISI_BODY', 'Isi Body', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo (validation_errors());
			} else {
				//get the form data
				$ID_PO = $this->input->post('ID_PO');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$ISI_BODY = $this->input->post('ISI_BODY');
				$HASH_MD5_PO = $this->input->post('HASH_MD5_PO');
				$NO_URUT_PO = $this->input->post('NO_URUT_PO');

				$data_edit = $this->PO_form_model->get_data_po_by_id_po($ID_PO);
				$KETERANGAN = "Isi PO: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);

				$KETERANGAN = "Update Data PO Form: " . json_encode($data_edit) . " ---- " . $ID_PO . ";" . $NAMA_PIC_VENDOR . ";" . $EMAIL_PIC_VENDOR . ";" . $ISI_BODY . ";" . $NO_URUT_PO;
				$this->user_log($KETERANGAN);
				$data = $this->PO_form_model->update_data_kirim_email($ID_PO, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $ISI_BODY);

				//Load email library
				$this->load->library('email');

				//SMTP & mail configuration
				// $config = array(
				// 	'protocol'  => 'smtp',
				// 	'smtp_host' => 'ssl://smtp.gmail.com',
				// 	'smtp_port' => 465,
				// 	'smtp_user' => 'userforkindo@gmail.com',
				// 	'smtp_pass' => 'Andasiapa21_',
				// 	'mailtype' => 'html',
				// 	'charset' => 'utf-8'
				// );

				$config = array(
					'protocol'  => 'smtp',
					'smtp_host' => 'mail.wasamitra.co.id',
					'smtp_port' => 25,
					'smtp_user' => 'notifikasi@wasamitra.co.id',
					'smtp_pass' => 'Eam.wme2022',
					'smtp_timeout' => '10',
					'mailtype' => 'html',
					'charset' => 'utf-8'
				);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");

				//Email content
				$htmlContent = $ISI_BODY;

				$this->email->to($EMAIL_PIC_VENDOR);
				$this->email->cc('notifikasi@wasamitra.co.id');
				$this->email->from('notifikasi@wasamitra.co.id', 'Departemen Procurement PT WME');
				$judul = 'WME | Purchase Order ' . $NO_URUT_PO;
				$this->email->subject($judul);
				$this->email->message($htmlContent);
				$alamat_1 = 'C:\xampp\htdocs\project_eam\assets\PO';
				$ekstensi = '\po_' . $HASH_MD5_PO . '.pdf';
				$alamat_pdf = $alamat_1 . $ekstensi;
				$this->email->attach($alamat_pdf);

				//Send email
				if ($this->email->send()) {
					echo 'Email Terkirim ke Vendor.';
				} else {
					show_error($this->email->print_debugger());
				}
			}
		} else {
			$this->logout();
		}
	}


	public function send_email($HASH_MD5_PO)
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

	public function detil_po($HASH_MD5_PO)
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

		if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
			redirect('PO', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			foreach ($hasil->result() as $VENDOR) :
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_vendor/head_normal', $this->data);
			$this->load->view('wasa/user_vendor/user_menu');
			$this->load->view('wasa/user_vendor/left_menu');
			$this->load->view('wasa/user_vendor/header_menu');
			$this->load->view('wasa/user_vendor/content_po_form_input_harga');
			$this->load->view('wasa/user_vendor/footer');
		} else {
			$this->logout();
		}
	}

	public function proses_invoice($HASH_MD5_PO)
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

		if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
			redirect('PO', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			foreach ($hasil->result() as $VENDOR) :
				$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
				$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
				$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
				$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
			endforeach;

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_vendor/head_normal', $this->data);
			$this->load->view('wasa/user_vendor/user_menu');
			$this->load->view('wasa/user_vendor/left_menu');
			$this->load->view('wasa/user_vendor/header_menu');
			$this->load->view('wasa/user_vendor/content_po_form_input_harga');
		} else {
			$this->logout();
		}
	}

	public function pengajuan_vendor($HASH_MD5_PO)
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

		if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {
			redirect('PO', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['NAMA_VENDOR'] = "";
				$this->data['NAMA_PIC_VENDOR'] = "";
				$this->data['EMAIL_PIC_VENDOR'] = "";
				$this->data['EMAIL_VENDOR'] = "";
			} else {
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;
			}

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_po_form_pengajuan_vendor');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['NAMA_VENDOR'] = "";
				$this->data['NAMA_PIC_VENDOR'] = "";
				$this->data['EMAIL_PIC_VENDOR'] = "";
				$this->data['EMAIL_VENDOR'] = "";
			} else {
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;
			}

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_po_form_pengajuan_vendor');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['NAMA_VENDOR'] = "";
				$this->data['NAMA_PIC_VENDOR'] = "";
				$this->data['EMAIL_PIC_VENDOR'] = "";
				$this->data['EMAIL_VENDOR'] = "";
			} else {
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;
			}

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_po_form_pengajuan_vendor');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['NAMA_VENDOR'] = "";
				$this->data['NAMA_PIC_VENDOR'] = "";
				$this->data['EMAIL_PIC_VENDOR'] = "";
				$this->data['EMAIL_VENDOR'] = "";
			} else {
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;
			}

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_po_form_pengajuan_vendor');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_PO = $hasil['ID_PO'];
			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_PO'] = $ID_PO;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
			$this->data['TANGGAL_KIRIM_BARANG_HARI'] = $hasil['TANGGAL_KIRIM_BARANG_HARI'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];

			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			if (empty($hasil->result())) {
				$this->data['NAMA_VENDOR'] = "";
				$this->data['NAMA_PIC_VENDOR'] = "";
				$this->data['EMAIL_PIC_VENDOR'] = "";
				$this->data['EMAIL_VENDOR'] = "";
			} else {
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;
			}

			$hasil = $this->Term_Of_Payment_model->term_of_payment_list_by_id_term_of_payment($this->data['ID_TERM_OF_PAYMENT']);
			if (empty($hasil->result())) {
				$this->data['NAMA_TERM_OF_PAYMENT'] = "";
			} else {
				foreach ($hasil->result() as $TERM_OF_PAYMENT) :
					$this->data['NAMA_TERM_OF_PAYMENT'] = $TERM_OF_PAYMENT->NAMA_TERM_OF_PAYMENT;
				endforeach;
			}

			$hasil = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			if (empty($hasil->result())) {
				$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
			} else {
				foreach ($hasil->result() as $PROYEK_LOKASI_PENYERAHAN) :
					$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
				endforeach;
			}

			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
			$this->data['PO'] = $this->PO_model->po_list_po_by_hashmd5($HASH_MD5_PO);


			$this->data['rasd_barang_list'] = $this->PO_form_model->rasd_form_list_where_not_in_po($ID_PO);
			$this->data['barang_master_list'] = $this->PO_form_model->barang_master_where_not_in_po_and_rasd($ID_PO);
			// $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			// $this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_po_form_pengajuan_vendor');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');
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

		$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_PO . '_';
			$config['upload_path']   = './assets/upload_po_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_po = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $query_id_po['ID_PO'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_po_form_file/' . $nama;
				$this->db->insert('po_form_file', array('ID_PO' => $ID_PO, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_PO' => $HASH_MD5_PO, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_PO . '_';
			$config['upload_path']   = './assets/upload_po_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_po = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $query_id_po['ID_PO'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_po_form_file/' . $nama;
				$this->db->insert('po_form_file', array('ID_PO' => $ID_PO, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_PO' => $HASH_MD5_PO, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_PO . '_';
			$config['upload_path']   = './assets/upload_po_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_po = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $query_id_po['ID_PO'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_po_form_file/' . $nama;
				$this->db->insert('po_form_file', array('ID_PO' => $ID_PO, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_PO' => $HASH_MD5_PO, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_PO . '_';
			$config['upload_path']   = './assets/upload_po_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_po = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $query_id_po['ID_PO'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_po_form_file/' . $nama;
				$this->db->insert('po_form_file', array('ID_PO' => $ID_PO, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_PO' => $HASH_MD5_PO, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_PO . '_';
			$config['upload_path']   = './assets/upload_po_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_po = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $query_id_po['ID_PO'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_po_form_file/' . $nama;
				$this->db->insert('po_form_file', array('ID_PO' => $ID_PO, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_PO' => $HASH_MD5_PO, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_PO . '_';
			$config['upload_path']   = './assets/upload_po_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_po = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
			$ID_PO = $query_id_po['ID_PO'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_po_form_file/' . $nama;
				$this->db->insert('po_form_file', array('ID_PO' => $ID_PO, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_PO' => $HASH_MD5_PO, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
		}
	}

	public function get_po_file()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$HASH_MD5_PO = $this->input->get('id');
			//$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel PO_Form_file
			$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

			$KETERANGAN2 = "Melihat File PO Cap Basah: " . json_encode($query_file_HASH_MD5_PO);
			$this->user_log($KETERANGAN2);

			if ($query_file_HASH_MD5_PO->num_rows() > 0) {

				$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

				$hasil = $query_file_HASH_MD5_PO->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$HASH_MD5_PO = $this->input->get('id');
			//$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel PO_Form_file
			$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

			$KETERANGAN2 = "Melihat File PO Cap Basah: " . json_encode($query_file_HASH_MD5_PO);
			$this->user_log($KETERANGAN2);

			if ($query_file_HASH_MD5_PO->num_rows() > 0) {

				$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

				$hasil = $query_file_HASH_MD5_PO->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$HASH_MD5_PO = $this->input->get('id');
			//$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel PO_Form_file
			$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

			$KETERANGAN2 = "Melihat File PO Cap Basah: " . json_encode($query_file_HASH_MD5_PO);
			$this->user_log($KETERANGAN2);

			if ($query_file_HASH_MD5_PO->num_rows() > 0) {

				$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

				$hasil = $query_file_HASH_MD5_PO->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$HASH_MD5_PO = $this->input->get('id');
			//$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel PO_Form_file
			$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

			$KETERANGAN2 = "Melihat File PO Cap Basah: " . json_encode($query_file_HASH_MD5_PO);
			$this->user_log($KETERANGAN2);

			if ($query_file_HASH_MD5_PO->num_rows() > 0) {

				$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

				$hasil = $query_file_HASH_MD5_PO->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$HASH_MD5_PO = $this->input->get('id');
			//$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['HASH_MD5_PO'] = $HASH_MD5_PO;
			$sess_data['HASH_MD5_PO'] = $this->data['HASH_MD5_PO'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel PO_Form_file
			$query_file_HASH_MD5_PO = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO($HASH_MD5_PO);

			$KETERANGAN2 = "Melihat File PO Cap Basah: " . json_encode($query_file_HASH_MD5_PO);
			$this->user_log($KETERANGAN2);

			if ($query_file_HASH_MD5_PO->num_rows() > 0) {

				$this->data['dokumen'] = $this->PO_Form_File_Model->file_list_by_HASH_MD5_PO_result($HASH_MD5_PO);

				$hasil = $query_file_HASH_MD5_PO->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
}
