<?php defined('BASEPATH') or exit('No direct script access allowed');

class RFQ_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Form RFQ';

		$this->load->model('RFQ_model');
		$this->load->model('RFQ_form_model');
		$this->load->model('Vendor_model');
		$this->load->model('Barang_master_model');
		$this->load->model('SPPB_form_model');
		$this->load->model('SPPB_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Klasifikasi_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('RFQ_Form_File_Model');
		$this->load->model('Term_Of_Payment_model');
		$this->load->model('Proyek_model');
		$this->load->model('Quotation_model');
		$this->load->model('Quotation_Form_File_Model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "RFQ_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses RFQ Form";
		$WAKTU = date('Y-m-d H:i:s');
		$this->RFQ_form_model->user_log_rfq_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->RFQ_form_model->user_log_rfq_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		$HASH_MD5_RFQ = $this->uri->segment(3);
		if ($this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ) == 'TIDAK ADA DATA') {
			redirect('RFQ', 'refresh');
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//fungsi ini untuk mengirim data ke dropdown
			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$this->data['PROGRESS_RFQ'] = $hasil['PROGRESS_RFQ'];
			if (($this->data['PROGRESS_RFQ']) == 'Diproses oleh Staff Procurement KP') {

				$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_RFQ = $hasil['ID_RFQ'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$ID_PROYEK_SUB_PEKERJAAN = $hasil['ID_PROYEK_SUB_PEKERJAAN'];
				$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_RFQ'] = $ID_RFQ;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $ID_PROYEK_SUB_PEKERJAAN;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['TERM_OF_PAYMENT'] = $hasil['TERM_OF_PAYMENT'];
				$this->data['TOP'] = $hasil['TOP'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['KETERANGAN_RFQ'] = $hasil['KETERANGAN_RFQ'];
				$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
				$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

				$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
				if ($hasil2 == 'BELUM ADA VENDOR') {
					$this->data['NAMA_PIC_VENDOR'] = "";
					$this->data['EMAIL_PIC_VENDOR'] = "";;
					$this->data['NO_HP_PIC_VENDOR'] = "";;
					$this->data['NAMA_VENDOR'] = "";;
					$this->data['ALAMAT_VENDOR'] = "";;
					$this->data['NO_TELP_VENDOR'] = "";;
					$this->data['EMAIL_VENDOR'] = "";;
				} else {
					$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
					$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
					$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
					$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
					$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
					$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
					$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);
				$this->data['CATATAN_RFQ'] = $this->RFQ_form_model->get_data_catatan_rfq_by_id_rfq($ID_RFQ);

				$this->data['sppb_barang_list'] = $this->RFQ_form_model->sppb_form_list_where_not_in_rfq($ID_RFQ, $ID_SPPB);
				$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_rfq_form_proses');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else {
				redirect('RFQ', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//fungsi ini untuk mengirim data ke dropdown
			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$this->data['PROGRESS_RFQ'] = $hasil['PROGRESS_RFQ'];
			if (($this->data['PROGRESS_RFQ']) == 'Diproses oleh Staff Procurement SP') {

				$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_RFQ = $hasil['ID_RFQ'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$ID_PROYEK_SUB_PEKERJAAN = $hasil['ID_PROYEK_SUB_PEKERJAAN'];
				$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_RFQ'] = $ID_RFQ;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $ID_PROYEK_SUB_PEKERJAAN;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['TERM_OF_PAYMENT'] = $hasil['TERM_OF_PAYMENT'];
				$this->data['TOP'] = $hasil['TOP'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['KETERANGAN_RFQ'] = $hasil['KETERANGAN_RFQ'];
				$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
				$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

				$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
				if ($hasil2 == 'BELUM ADA VENDOR') {
					$this->data['NAMA_PIC_VENDOR'] = "";
					$this->data['EMAIL_PIC_VENDOR'] = "";;
					$this->data['NO_HP_PIC_VENDOR'] = "";;
					$this->data['NAMA_VENDOR'] = "";;
					$this->data['ALAMAT_VENDOR'] = "";;
					$this->data['NO_TELP_VENDOR'] = "";;
					$this->data['EMAIL_VENDOR'] = "";;
				} else {
					$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
					$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
					$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
					$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
					$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
					$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
					$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);
				$this->data['CATATAN_RFQ'] = $this->RFQ_form_model->get_data_catatan_rfq_by_id_rfq($ID_RFQ);

				$this->data['sppb_barang_list'] = $this->RFQ_form_model->sppb_form_list_where_not_in_rfq($ID_RFQ, $ID_SPPB);
				$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_rfq_form_proses');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else {
				redirect('RFQ', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//fungsi ini untuk mengirim data ke dropdown
			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$this->data['PROGRESS_RFQ'] = $hasil['PROGRESS_RFQ'];
			if (($this->data['PROGRESS_RFQ']) == 'Diproses oleh Supervisi Procurement SP') {

				$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
				$ID_SPPB = $hasil['ID_SPPB'];
				$ID_RFQ = $hasil['ID_RFQ'];
				$ID_PROYEK = $hasil['ID_PROYEK'];
				$ID_PROYEK_SUB_PEKERJAAN = $hasil['ID_PROYEK_SUB_PEKERJAAN'];
				$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['ID_RFQ'] = $ID_RFQ;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $ID_PROYEK_SUB_PEKERJAAN;
				$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
				$this->data['TERM_OF_PAYMENT'] = $hasil['TERM_OF_PAYMENT'];
				$this->data['TOP'] = $hasil['TOP'];
				$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
				$this->data['KETERANGAN_RFQ'] = $hasil['KETERANGAN_RFQ'];
				$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];
				$this->data['LOKASI_PENYERAHAN_LIST'] = $this->Proyek_model->lokasi_penyerahan_list_by_id_proyek($this->data['ID_PROYEK']);

				$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR']);
				if ($hasil2 == 'BELUM ADA VENDOR') {
					$this->data['NAMA_PIC_VENDOR'] = "";
					$this->data['EMAIL_PIC_VENDOR'] = "";;
					$this->data['NO_HP_PIC_VENDOR'] = "";;
					$this->data['NAMA_VENDOR'] = "";;
					$this->data['ALAMAT_VENDOR'] = "";;
					$this->data['NO_TELP_VENDOR'] = "";;
					$this->data['EMAIL_VENDOR'] = "";;
				} else {
					$this->data['NAMA_PIC_VENDOR'] = $hasil2['NAMA_PIC_VENDOR'];
					$this->data['EMAIL_PIC_VENDOR'] = $hasil2['EMAIL_PIC_VENDOR'];
					$this->data['NO_HP_PIC_VENDOR'] = $hasil2['NO_HP_PIC_VENDOR'];
					$this->data['NAMA_VENDOR'] = $hasil2['NAMA_VENDOR'];
					$this->data['ALAMAT_VENDOR'] = $hasil2['ALAMAT_VENDOR'];
					$this->data['NO_TELP_VENDOR'] = $hasil2['NO_TELP_VENDOR'];
					$this->data['EMAIL_VENDOR'] = $hasil2['EMAIL_VENDOR'];
				}

				$this->data['term_of_payment'] = $this->Term_Of_Payment_model->term_of_payment_list();
				$this->data['vendor'] = $this->Vendor_model->vendor_list();
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);
				$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);
				$this->data['CATATAN_RFQ'] = $this->RFQ_form_model->get_data_catatan_rfq_by_id_rfq($ID_RFQ);

				$this->data['sppb_barang_list'] = $this->RFQ_form_model->sppb_form_list_where_not_in_rfq($ID_RFQ, $ID_SPPB);
				$this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
				
				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_rfq_form_proses');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else {
				redirect('RFQ', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	function data_rfq_form()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RFQ = $this->input->post('ID_RFQ');

			$data = $this->RFQ_form_model->rfq_form_list_by_id_rfq($ID_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RFQ Form: " . json_encode($ID_RFQ);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
			$data = $this->RFQ_form_model->get_data_by_id_rfq_form($ID_RFQ_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data RFQ Form by ID_RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_rfq_form_by_id_rfq()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$ID_RFQ = $this->input->get('ID_RFQ');
			$data = $this->RFQ_form_model->get_data_rfq_form_by_id_rfq($ID_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data RFQ Form by ID_RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$ID_RFQ = $this->input->get('ID_RFQ');
			$data = $this->RFQ_form_model->get_data_rfq_form_by_id_rfq($ID_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data RFQ Form by ID_RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_RFQ = $this->input->get('ID_RFQ');
			$data = $this->RFQ_form_model->get_data_rfq_form_by_id_rfq($ID_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data RFQ Form by ID_RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_RFQ = $this->input->get('ID_RFQ');
			$data = $this->RFQ_form_model->get_data_rfq_form_by_id_rfq($ID_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data RFQ Form by ID_RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_rfq()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$ID_RFQ = $this->input->get('ID_RFQ');
			$data = $this->RFQ_form_model->get_data_rfq_by_id_rfq($ID_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_RFQ = $this->input->get('ID_RFQ');
			$data = $this->RFQ_form_model->get_data_rfq_by_id_rfq($ID_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_RFQ = $this->input->get('ID_RFQ');
			$data = $this->RFQ_form_model->get_data_rfq_by_id_rfq($ID_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	// function get_data_id_rab_form_by_id_proyek()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
	// 		$ID_PROYEK = $this->input->post('ID_PROYEK');
	// 		$ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
	// 		$data = $this->SPPB_model->get_data_id_rab_form_by_id_proyek($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data ID RAB FORM: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
	// 		$ID_PROYEK = $this->input->post('ID_PROYEK');
	// 		$ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
	// 		$data = $this->SPPB_model->get_data_id_rab_form_by_id_proyek($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data ID RAB FORM: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else {
	// 		// set the flash data error message if there is one
	// 		$this->ion_auth->logout();
	// 		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	// 	}
	// }

	function get_data_id_rasd_by_id_rab_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$data = $this->RFQ_model->get_data_id_rasd_by_id_rab_form($ID_RAB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data ID RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$data = $this->RFQ_model->get_data_id_rasd_by_id_rab_form($ID_RAB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data ID RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$data = $this->RFQ_model->get_data_id_rasd_by_id_rab_form($ID_RAB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data ID RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_data_id_rasd_form_by_id_rasd()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_RASD = $this->input->post('ID_RASD');
			$ID_RFQ = $this->input->post('ID_RFQ');
			$data = $this->RFQ_form_model->get_data_id_rasd_form_by_id_rasd($ID_RASD, $ID_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data ID RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_data_ctt_rfq()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$HASH_MD5_RFQ = $this->input->get('HASH_MD5_RFQ');
			$data = $this->RFQ_model->get_data_CTT_STAFF_PROC($HASH_MD5_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$HASH_MD5_RFQ = $this->input->get('HASH_MD5_RFQ');
			$data = $this->RFQ_model->get_data_CTT_STAFF_PROC($HASH_MD5_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$HASH_MD5_RFQ = $this->input->get('HASH_MD5_RFQ');
			$data = $this->RFQ_model->get_data_CTT_STAFF_PROC($HASH_MD5_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} 
	}

	function get_id_rfq_by_HASH_MD5_RFQ()
	{
		if ($this->ion_auth->logged_in()) {
			$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');
			$data = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			echo json_encode($data);

			$KETERANGAN = "Get Data RFQ: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	// function get_data_catatan_rfq()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
	// 		$ID_SPPB = $this->input->get('id');
	// 		$data = $this->RFQ_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4) || $this->ion_auth->in_group(5) || $this->ion_auth->in_group(6) || $this->ion_auth->in_group(7))) {
	// 		$ID_SPPB = $this->input->get('id');
	// 		$data = $this->RFQ_form_model->get_data_catatan_sppb_by_id_rfq($ID_SPPB);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Data Catatan SPPB: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$ID_RFQ_FORM = $this->input->post('kode');
			$data_hapus = $this->RFQ_form_model->get_data_by_id_rfq_form($ID_RFQ_FORM);

			$KETERANGAN = "Hapus Data RFQ Form: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->RFQ_form_model->hapus_data_by_id_rfq_form($ID_RFQ_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_RFQ_FORM = $this->input->post('kode');
			$data_hapus = $this->RFQ_form_model->get_data_by_id_rfq_form($ID_RFQ_FORM);

			$KETERANGAN = "Hapus Data RFQ Form: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->RFQ_form_model->hapus_data_by_id_rfq_form($ID_RFQ_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_RFQ_FORM = $this->input->post('kode');
			$data_hapus = $this->RFQ_form_model->get_data_by_id_rfq_form($ID_RFQ_FORM);

			$KETERANGAN = "Hapus Data RFQ Form: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->RFQ_form_model->hapus_data_by_id_rfq_form($ID_RFQ_FORM);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}

	function simpan_data_dari_sppb_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
			$ID_RFQ = $this->input->post('ID_RFQ');
			foreach ($ID_SPPB_FORM as $index => $ID_SPPB_FORM) {
				$this->RFQ_form_model->simpan_data_dari_sppb_form($ID_SPPB_FORM, $ID_RFQ);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
			$ID_RFQ = $this->input->post('ID_RFQ');
			foreach ($ID_SPPB_FORM as $index => $ID_SPPB_FORM) {
				$this->RFQ_form_model->simpan_data_dari_sppb_form($ID_SPPB_FORM, $ID_RFQ);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
			$ID_RFQ = $this->input->post('ID_RFQ');
			foreach ($ID_SPPB_FORM as $index => $ID_SPPB_FORM) {
				$this->RFQ_form_model->simpan_data_dari_sppb_form($ID_SPPB_FORM, $ID_RFQ);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}

	// function simpan_data_dari_rasd_form()
	// {
	// 	if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

	// 		$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
	// 		$ID_RFQ = $this->input->post('ID_RFQ');
	// 		$KATEGORI_RAB_FORM = $this->input->post('KATEGORI_RAB_FORM');
	// 		foreach ($ID_RASD_FORM as $index => $value_rasd) {
	// 			$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
	// 			if ($data->ID_BARANG_MASTER == "") {
	// 				$id_master = 'NULL';
	// 			} else {
	// 				$id_master = $data->ID_BARANG_MASTER;
	// 			}
	// 			$jumlah = $this->input->post($value_rasd);
	// 			$this->RFQ_form_model->simpan_data_dari_rasd_form(
	// 				$ID_RFQ,
	// 				$id_master,
	// 				$value_rasd,
	// 				$data->ID_SATUAN_BARANG,
	// 				$data->ID_JENIS_BARANG,
	// 				$data->NAMA,
	// 				$data->MEREK,
	// 				$KATEGORI_RAB_FORM,
	// 				$data->SPESIFIKASI_SINGKAT,
	// 				$jumlah
	// 			);
	// 			$KETERANGAN = "Tambah Data RFQ Form (dari RASD): " . ";" . $ID_RFQ . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
	// 			$this->user_log($KETERANGAN);
	// 		}
	// 		redirect($_SERVER['HTTP_REFERER']);
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

	// 		$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
	// 		$ID_RFQ = $this->input->post('ID_RFQ');
	// 		foreach ($ID_RASD_FORM as $index => $value_rasd) {
	// 			$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
	// 			if ($data->ID_BARANG_MASTER == "") {
	// 				$id_master = 'NULL';
	// 			} else {
	// 				$id_master = $data->ID_BARANG_MASTER;
	// 			}
	// 			$jumlah = $this->input->post($value_rasd);
	// 			$this->RFQ_form_model->simpan_data_dari_rasd_form(
	// 				$ID_RFQ,
	// 				$id_master,
	// 				$value_rasd,
	// 				$data->ID_SATUAN_BARANG,
	// 				$data->ID_JENIS_BARANG,
	// 				$data->NAMA,
	// 				$data->MEREK,
	// 				$data->PERALATAN_PERLENGKAPAN,
	// 				$data->SPESIFIKASI_SINGKAT,
	// 				$jumlah
	// 			);
	// 			$KETERANGAN = "Tambah Data RFQ Form (dari RASD): " . ";" . $ID_RFQ . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
	// 			$this->user_log($KETERANGAN);
	// 		}
	// 		redirect($_SERVER['HTTP_REFERER']);
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

	// 		$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
	// 		$ID_RFQ = $this->input->post('ID_RFQ');
	// 		foreach ($ID_RASD_FORM as $index => $value_rasd) {
	// 			$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
	// 			if ($data->ID_BARANG_MASTER == "") {
	// 				$id_master = 'NULL';
	// 			} else {
	// 				$id_master = $data->ID_BARANG_MASTER;
	// 			}
	// 			$jumlah = $this->input->post($value_rasd);
	// 			$this->RFQ_form_model->simpan_data_dari_rasd_form(
	// 				$ID_RFQ,
	// 				$id_master,
	// 				$value_rasd,
	// 				$data->ID_SATUAN_BARANG,
	// 				$data->ID_JENIS_BARANG,
	// 				$data->NAMA,
	// 				$data->MEREK,
	// 				$data->PERALATAN_PERLENGKAPAN,
	// 				$data->SPESIFIKASI_SINGKAT,
	// 				$jumlah
	// 			);
	// 			$KETERANGAN = "Tambah Data RFQ Form (dari RASD): " . ";" . $ID_RFQ . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
	// 			$this->user_log($KETERANGAN);
	// 		}
	// 		redirect($_SERVER['HTTP_REFERER']);
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

	// 		$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
	// 		$ID_RFQ = $this->input->post('ID_RFQ');
	// 		foreach ($ID_RASD_FORM as $index => $value_rasd) {
	// 			$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
	// 			if ($data->ID_BARANG_MASTER == "") {
	// 				$id_master = 'NULL';
	// 			} else {
	// 				$id_master = $data->ID_BARANG_MASTER;
	// 			}
	// 			$jumlah = $this->input->post($value_rasd);
	// 			$this->RFQ_form_model->simpan_data_dari_rasd_form(
	// 				$ID_RFQ,
	// 				$id_master,
	// 				$value_rasd,
	// 				$data->ID_SATUAN_BARANG,
	// 				$data->ID_JENIS_BARANG,
	// 				$data->NAMA,
	// 				$data->MEREK,
	// 				$data->PERALATAN_PERLENGKAPAN,
	// 				$data->SPESIFIKASI_SINGKAT,
	// 				$jumlah
	// 			);
	// 			$KETERANGAN = "Tambah Data RFQ Form (dari RASD): " . ";" . $ID_RFQ . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
	// 			$this->user_log($KETERANGAN);
	// 		}
	// 		redirect($_SERVER['HTTP_REFERER']);
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

	// 		$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
	// 		$ID_RFQ = $this->input->post('ID_RFQ');
	// 		foreach ($ID_RASD_FORM as $index => $value_rasd) {
	// 			$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
	// 			if ($data->ID_BARANG_MASTER == "") {
	// 				$id_master = 'NULL';
	// 			} else {
	// 				$id_master = $data->ID_BARANG_MASTER;
	// 			}
	// 			$jumlah = $this->input->post($value_rasd);
	// 			$this->RFQ_form_model->simpan_data_dari_rasd_form(
	// 				$ID_RFQ,
	// 				$id_master,
	// 				$value_rasd,
	// 				$data->ID_SATUAN_BARANG,
	// 				$data->ID_JENIS_BARANG,
	// 				$data->NAMA,
	// 				$data->MEREK,
	// 				$data->PERALATAN_PERLENGKAPAN,
	// 				$data->SPESIFIKASI_SINGKAT,
	// 				$jumlah
	// 			);
	// 			$KETERANGAN = "Tambah Data RFQ Form (dari RASD): " . ";" . $ID_RFQ . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
	// 			$this->user_log($KETERANGAN);
	// 		}
	// 		redirect($_SERVER['HTTP_REFERER']);
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	// function simpan_data_dari_barang_master()
	// {
	// 	if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

	// 		$ID_RFQ = $this->input->post('ID_RFQ');
	// 		$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
	// 		foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
	// 			$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
	// 			// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
	// 			// 	$id_rasd = 'NULL';
	// 			// } else {
	// 			// 	$id_rasd = $data->ID_RASD_FORM;
	// 			// }
	// 			$id_rasd = 'NULL';
	// 			$jumlah = $this->input->post($ID_MASTER);
	// 			$this->RFQ_form_model->simpan_data_dari_barang_master(
	// 				$ID_RFQ,
	// 				$ID_MASTER,
	// 				$id_rasd,
	// 				$data->ID_SATUAN_BARANG,
	// 				$data->ID_JENIS_BARANG,
	// 				$data->NAMA,
	// 				$data->MEREK,
	// 				$data->PERALATAN_PERLENGKAPAN,
	// 				$data->SPESIFIKASI_SINGKAT,
	// 				$jumlah
	// 			);
	// 			$KETERANGAN = "Tambah Data RFQ Form (dari barang master): " . ";" . $ID_RFQ . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" .  $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
	// 			$this->user_log($KETERANGAN);
	// 		}
	// 		redirect($_SERVER['HTTP_REFERER']);
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

	// 		$ID_RFQ = $this->input->post('ID_RFQ');
	// 		$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
	// 		foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
	// 			$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
	// 			// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
	// 			// 	$id_rasd = 'NULL';
	// 			// } else {
	// 			// 	$id_rasd = $data->ID_RASD_FORM;
	// 			// }
	// 			$id_rasd = 'NULL';
	// 			$jumlah = $this->input->post($ID_MASTER);
	// 			$this->RFQ_form_model->simpan_data_dari_barang_master(
	// 				$ID_RFQ,
	// 				$ID_MASTER,
	// 				$id_rasd,
	// 				$data->ID_SATUAN_BARANG,
	// 				$data->ID_JENIS_BARANG,
	// 				$data->NAMA,
	// 				$data->MEREK,
	// 				$data->PERALATAN_PERLENGKAPAN,
	// 				$data->SPESIFIKASI_SINGKAT,
	// 				$jumlah
	// 			);
	// 			$KETERANGAN = "Tambah Data RFQ Form (dari barang master): " . ";" . $ID_RFQ . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" .  $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
	// 			$this->user_log($KETERANGAN);
	// 		}
	// 		redirect($_SERVER['HTTP_REFERER']);
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

	// 		$ID_RFQ = $this->input->post('ID_RFQ');
	// 		$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
	// 		foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
	// 			$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
	// 			// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
	// 			// 	$id_rasd = 'NULL';
	// 			// } else {
	// 			// 	$id_rasd = $data->ID_RASD_FORM;
	// 			// }
	// 			$id_rasd = 'NULL';
	// 			$jumlah = $this->input->post($ID_MASTER);
	// 			$this->RFQ_form_model->simpan_data_dari_barang_master(
	// 				$ID_RFQ,
	// 				$ID_MASTER,
	// 				$id_rasd,
	// 				$data->ID_SATUAN_BARANG,
	// 				$data->ID_JENIS_BARANG,
	// 				$data->NAMA,
	// 				$data->MEREK,
	// 				$data->PERALATAN_PERLENGKAPAN,
	// 				$data->SPESIFIKASI_SINGKAT,
	// 				$jumlah
	// 			);
	// 			$KETERANGAN = "Tambah Data RFQ Form (dari barang master): " . ";" . $ID_RFQ . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" .  $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
	// 			$this->user_log($KETERANGAN);
	// 		}
	// 		redirect($_SERVER['HTTP_REFERER']);
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

	// 		$ID_RFQ = $this->input->post('ID_RFQ');
	// 		$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
	// 		foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
	// 			$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
	// 			// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
	// 			// 	$id_rasd = 'NULL';
	// 			// } else {
	// 			// 	$id_rasd = $data->ID_RASD_FORM;
	// 			// }
	// 			$id_rasd = 'NULL';
	// 			$jumlah = $this->input->post($ID_MASTER);
	// 			$this->RFQ_form_model->simpan_data_dari_barang_master(
	// 				$ID_RFQ,
	// 				$ID_MASTER,
	// 				$id_rasd,
	// 				$data->ID_SATUAN_BARANG,
	// 				$data->ID_JENIS_BARANG,
	// 				$data->NAMA,
	// 				$data->MEREK,
	// 				$data->PERALATAN_PERLENGKAPAN,
	// 				$data->SPESIFIKASI_SINGKAT,
	// 				$jumlah
	// 			);
	// 			$KETERANGAN = "Tambah Data RFQ Form (dari barang master): " . ";" . $ID_RFQ . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" .  $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
	// 			$this->user_log($KETERANGAN);
	// 		}
	// 		redirect($_SERVER['HTTP_REFERER']);
	// 	} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

	// 		$ID_RFQ = $this->input->post('ID_RFQ');
	// 		$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
	// 		foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
	// 			$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
	// 			// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
	// 			// 	$id_rasd = 'NULL';
	// 			// } else {
	// 			// 	$id_rasd = $data->ID_RASD_FORM;
	// 			// }
	// 			$id_rasd = 'NULL';
	// 			$jumlah = $this->input->post($ID_MASTER);
	// 			$this->RFQ_form_model->simpan_data_dari_barang_master(
	// 				$ID_RFQ,
	// 				$ID_MASTER,
	// 				$id_rasd,
	// 				$data->ID_SATUAN_BARANG,
	// 				$data->ID_JENIS_BARANG,
	// 				$data->NAMA,
	// 				$data->MEREK,
	// 				$data->PERALATAN_PERLENGKAPAN,
	// 				$data->SPESIFIKASI_SINGKAT,
	// 				$jumlah
	// 			);
	// 			$KETERANGAN = "Tambah Data RFQ Form (dari barang master): " . ";" . $ID_RFQ . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" .  $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
	// 			$this->user_log($KETERANGAN);
	// 		}
	// 		redirect($_SERVER['HTTP_REFERER']);
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	public function simpan_data_di_luar_barang_master()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('KLASIFIKASI_BARANG', 'Klasifikasi Barang', 'trim');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_RFQ = $this->input->post('ID_RFQ');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$KLASIFIKASI_BARANG = $this->input->post('KLASIFIKASI_BARANG');
				$KETERANGAN = $this->input->post('KETERANGAN');


				$data = $this->RFQ_form_model->simpan_data_di_luar_barang_master(
					$ID_RFQ,
					$ID_BARANG_MASTER,
					$ID_RASD_FORM,
					$NAMA,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$JUMLAH_BARANG,
					$SATUAN_BARANG,
					$KLASIFIKASI_BARANG,
					$KETERANGAN
				);

				echo($data);

				// $KETERANGAN = "Tambah Data RFQ Form (di luar barang master dan RASD): " . ";" . $ID_RFQ  . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_BARANG;
				// $this->user_log($KETERANGAN);

			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('KLASIFIKASI_BARANG', 'Klasifikasi Barang', 'trim');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_RFQ = $this->input->post('ID_RFQ');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$KLASIFIKASI_BARANG = $this->input->post('KLASIFIKASI_BARANG');
				$KETERANGAN = $this->input->post('KETERANGAN');


				$data = $this->RFQ_form_model->simpan_data_di_luar_barang_master(
					$ID_RFQ,
					$ID_BARANG_MASTER,
					$ID_RASD_FORM,
					$NAMA,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$JUMLAH_BARANG,
					$SATUAN_BARANG,
					$KLASIFIKASI_BARANG,
					$KETERANGAN
				);

				echo($data);

				// $KETERANGAN = "Tambah Data RFQ Form (di luar barang master dan RASD): " . ";" . $ID_RFQ  . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_BARANG;
				// $this->user_log($KETERANGAN);

			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('KLASIFIKASI_BARANG', 'Klasifikasi Barang', 'trim');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_RFQ = $this->input->post('ID_RFQ');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$KLASIFIKASI_BARANG = $this->input->post('KLASIFIKASI_BARANG');
				$KETERANGAN = $this->input->post('KETERANGAN');


				$data = $this->RFQ_form_model->simpan_data_di_luar_barang_master(
					$ID_RFQ,
					$ID_BARANG_MASTER,
					$ID_RASD_FORM,
					$NAMA,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$JUMLAH_BARANG,
					$SATUAN_BARANG,
					$KLASIFIKASI_BARANG,
					$KETERANGAN
				);

				echo($data);

				// $KETERANGAN = "Tambah Data RFQ Form (di luar barang master dan RASD): " . ";" . $ID_RFQ  . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_BARANG;
				// $this->user_log($KETERANGAN);

			}
		} else {
			$this->logout();
		}
	}

	// function get_nama_vendor()
	// {
	// 	if ($this->ion_auth->logged_in()) {
	// 		$ID_VENDOR = $this->input->get('ID_VENDOR');
	// 		$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Nama Vendor: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else {
	// 		// set the flash data error message if there is one
	// 		$this->ion_auth->logout();
	// 		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	// 	}
	// }

	// function get_nama_term_of_payment()
	// {
	// 	if ($this->ion_auth->logged_in()) {
	// 		$ID_TERM_OF_PAYMENT = $this->input->get('ID_TERM_OF_PAYMENT');
	// 		$data = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
	// 		echo json_encode($data);

	// 		$KETERANGAN = "Get Nama Term of Payment: " . json_encode($data);
	// 		$this->user_log($KETERANGAN);
	// 	} else {
	// 		// set the flash data error message if there is one
	// 		$this->ion_auth->logout();
	// 		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	// 	}
	// }

	function update_data()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|max_length[100]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim');
			$this->form_validation->set_rules('KLASIFIKASI_BARANG', 'Klasifikasi Barang', 'trim');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|max_length[300]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data);
				$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$ID_KLASIFIKASI_BARANG = $this->input->post('KLASIFIKASI_BARANG');
					
				$data_edit = $this->RFQ_form_model->get_data_by_id_rfq_form($ID_RFQ_FORM);
				$KETERANGAN = "Coba isi RFQ Form: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);

				// $KETERANGAN = "Ubah Data RFQ Form: " . json_encode($data_edit) . " ---- " . $ID_RFQ . ";" . $ID_RFQ_FORM . ";" . $NAMA  . ";" . $MEREK . ";" . $JENIS_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $SATUAN_BARANG . ";" . $JUMLAH_BARANG;
				// $this->user_log($KETERANGAN);

				$data = $this->RFQ_form_model->update_data($ID_RFQ_FORM, $NAMA, $MEREK, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG, $KETERANGAN, $ID_KLASIFIKASI_BARANG);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	// function update_data_keterangan_barang()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Catatan Item Barang', 'trim|required|max_length[50]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
	// 			$CATATAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->RFQ_form_model->get_keterangan_by_id_rfq_form($ID_RFQ_FORM);
	// 			$KETERANGAN = "Ubah Data Catatan RFQ Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RFQ_FORM . ";" . $CATATAN;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->RFQ_form_model->update_data_keterangan_barang($ID_RFQ_FORM, $CATATAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Catatan Item Barang', 'trim|required|max_length[50]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
	// 			$CATATAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->RFQ_form_model->get_keterangan_by_id_rfq_form($ID_RFQ_FORM);
	// 			$KETERANGAN = "Ubah Data Catatan RFQ Form (User Kasie Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RFQ_FORM . ";" . $CATATAN;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->RFQ_form_model->update_data_keterangan_barang($ID_RFQ_FORM, $CATATAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Catatan Item Barang', 'trim|required|max_length[50]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
	// 			$CATATAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->RFQ_form_model->get_keterangan_by_id_rfq_form($ID_RFQ_FORM);
	// 			$KETERANGAN = "Ubah Data Catatan RFQ Form (User Manajer Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RFQ_FORM . ";" . $CATATAN;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->RFQ_form_model->update_data_keterangan_barang($ID_RFQ_FORM, $CATATAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Catatan Item Barang', 'trim|required|max_length[50]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
	// 			$CATATAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->RFQ_form_model->get_keterangan_by_id_rfq_form($ID_RFQ_FORM);
	// 			$KETERANGAN = "Ubah Data Catatan RFQ Form (User Staff Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_RFQ_FORM . ";" . $CATATAN;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->RFQ_form_model->update_data_keterangan_barang($ID_RFQ_FORM, $CATATAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('KETERANGAN', 'Catatan Item Barang', 'trim|required|max_length[50]');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
	// 			$CATATAN = $this->input->post('KETERANGAN');

	// 			$data_edit = $this->RFQ_form_model->get_keterangan_by_id_rfq_form($ID_RFQ_FORM);
	// 			$KETERANGAN = "Ubah Data Catatan RFQ Form (User Supervisi Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_RFQ_FORM . ";" . $CATATAN;
	// 			$this->user_log($KETERANGAN);

	// 			$data = $this->RFQ_form_model->update_data_keterangan_barang($ID_RFQ_FORM, $CATATAN);
	// 			echo json_encode($data);
	// 		}
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	function update_data_harga_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG', 'Harga Satuan Barang', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
				$HARGA_SATUAN_BARANG = $this->input->post('HARGA_SATUAN_BARANG');
				$HARGA_TOTAL = $this->input->post('HARGA_TOTAL');

				$data_edit = $this->RFQ_form_model->get_keterangan_by_id_rfq_form($ID_RFQ_FORM);
				$KETERANGAN = "Ubah Data Harga RFQ Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RFQ_FORM . ";" . $HARGA_SATUAN_BARANG . ";" . $HARGA_TOTAL;
				$this->user_log($KETERANGAN);

				$KETERANGAN_INPUT_MANUAL = "Di Input Oleh Staff Procurement KP";

				$data = $this->RFQ_form_model->update_data_harga_barang($ID_RFQ_FORM, $HARGA_SATUAN_BARANG, $HARGA_TOTAL, $KETERANGAN_INPUT_MANUAL);
				echo json_encode($data);
			}
		}else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG', 'Harga Satuan Barang', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
				$HARGA_SATUAN_BARANG = $this->input->post('HARGA_SATUAN_BARANG');
				$HARGA_TOTAL = $this->input->post('HARGA_TOTAL');

				$data_edit = $this->RFQ_form_model->get_keterangan_by_id_rfq_form($ID_RFQ_FORM);
				$KETERANGAN = "Ubah Data Harga RFQ Form (User Staff Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_RFQ_FORM . ";" . $HARGA_SATUAN_BARANG . ";" . $HARGA_TOTAL;
				$this->user_log($KETERANGAN);

				$KETERANGAN_INPUT_MANUAL = "Di Input Oleh Staff Procurement SP";

				$data = $this->RFQ_form_model->update_data_harga_barang($ID_RFQ_FORM, $HARGA_SATUAN_BARANG, $HARGA_TOTAL, $KETERANGAN_INPUT_MANUAL);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG', 'Harga Satuan Barang', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
				$HARGA_SATUAN_BARANG = $this->input->post('HARGA_SATUAN_BARANG');
				$HARGA_TOTAL = $this->input->post('HARGA_TOTAL');

				$data_edit = $this->RFQ_form_model->get_keterangan_by_id_rfq_form($ID_RFQ_FORM);
				$KETERANGAN = "Ubah Data Harga RFQ Form (User Supervisi Procurement SP): " . json_encode($data_edit) . " ---- " . $ID_RFQ_FORM . ";" . $HARGA_SATUAN_BARANG . ";" . $HARGA_TOTAL;
				$this->user_log($KETERANGAN);

				$KETERANGAN_INPUT_MANUAL = "Di Input Oleh Supervisi Procurement SP";

				$data = $this->RFQ_form_model->update_data_harga_barang($ID_RFQ_FORM, $HARGA_SATUAN_BARANG, $HARGA_TOTAL, $KETERANGAN_INPUT_MANUAL);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {

			//set validation rules
			$this->form_validation->set_rules('HARGA_SATUAN_BARANG', 'Harga Satuan Barang', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RFQ_FORM = $this->input->post('ID_RFQ_FORM');
				$HARGA_SATUAN_BARANG = $this->input->post('HARGA_SATUAN_BARANG');
				$HARGA_TOTAL = $this->input->post('HARGA_TOTAL');

				$data_edit = $this->RFQ_form_model->get_keterangan_by_id_rfq_form($ID_RFQ_FORM);
				$KETERANGAN = "Ubah Data Harga RFQ Form (User Vendor): " . json_encode($data_edit) . " ---- " . $ID_RFQ_FORM . ";" . $HARGA_SATUAN_BARANG . ";" . $HARGA_TOTAL;
				$this->user_log($KETERANGAN);

				$KETERANGAN_INPUT_MANUAL = "Di Input Oleh Vendor";

				$data = $this->RFQ_form_model->update_data_harga_barang($ID_RFQ_FORM, $HARGA_SATUAN_BARANG, $HARGA_TOTAL, $KETERANGAN_INPUT_MANUAL);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_catatan_rfq()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_PROC', 'Catatan RFQ Staff Procurement KP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RFQ = $this->input->post('ID_RFQ');
				$CTT_STAFF_PROC = $this->input->post('CTT_STAFF_PROC');

				$data_edit = $this->RFQ_form_model->get_data_catatan_rfq_by_id_rfq($ID_RFQ);
				$KETERANGAN = "Ubah Data Catatan SPP (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RFQ . ";" . $CTT_STAFF_PROC;
				$this->user_log($KETERANGAN);

				$data = $this->RFQ_form_model->update_data_CTT_STAFF_PROC_KP($ID_RFQ, $CTT_STAFF_PROC);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_PROC', 'Catatan RFQ Staff Procurement KP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RFQ = $this->input->post('ID_RFQ');
				$CTT_STAFF_PROC = $this->input->post('CTT_STAFF_PROC');

				$data_edit = $this->RFQ_form_model->get_data_catatan_rfq_by_id_rfq($ID_RFQ);
				$KETERANGAN = "Ubah Data Catatan SPP (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RFQ . ";" . $CTT_STAFF_PROC;
				$this->user_log($KETERANGAN);

				$data = $this->RFQ_form_model->update_data_CTT_STAFF_PROC_KP($ID_RFQ, $CTT_STAFF_PROC);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_PROC', 'Catatan RFQ Staff Procurement KP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RFQ = $this->input->post('ID_RFQ');
				$CTT_STAFF_PROC = $this->input->post('CTT_STAFF_PROC');

				$data_edit = $this->RFQ_form_model->get_data_catatan_rfq_by_id_rfq($ID_RFQ);
				$KETERANGAN = "Ubah Data Catatan SPP (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RFQ . ";" . $CTT_STAFF_PROC;
				$this->user_log($KETERANGAN);

				$data = $this->RFQ_form_model->update_data_CTT_STAFF_PROC_KP($ID_RFQ, $CTT_STAFF_PROC);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function simpan_identitas_form()
	{
		$user = $this->ion_auth->user()->row();
		$this->data['USER_ID'] = $user->id;
		$CREATE_BY_USER =  $this->data['USER_ID'];

		if ($this->ion_auth->logged_in()) {

			//set validation rules
			$this->form_validation->set_rules('NO_URUT_RFQ_GANTI', 'No Urut RFQ', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('TANGGAL_DOKUMEN_RFQ', 'Tanggal Dokumen RFQ', 'trim|required');
			$this->form_validation->set_rules('ID_PROYEK_LOKASI_PENYERAHAN', 'Lokasi Penyerahan', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('ID_VENDOR', 'Vendor', 'trim|max_length[50]|required');
			$this->form_validation->set_rules('TERM_OF_PAYMENT', 'Term Of Payment', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('KETERANGAN_RFQ', 'Keterangan RFQ', 'trim');
			$this->form_validation->set_rules('BATAS_AKHIR', 'Batas Akhir Pengisian RFQ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				if ($this->input->post('ID_VENDOR') == "666666") {
					$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|max_length[50]|required');
					$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat Vendor', 'trim|required');
					$this->form_validation->set_rules('NO_TELP_VENDOR', 'Nomor Telp Vendor', 'trim|max_length[20]|required');
					$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC', 'trim|max_length[50]|required');

					//run validation check
					if ($this->form_validation->run() == FALSE) {   //validation fails
						echo validation_errors();
					} else {

						//get the form data
						$ID_RFQ = $this->input->post('ID_RFQ');
						$NO_URUT_RFQ_GANTI = $this->input->post('NO_URUT_RFQ_GANTI');
						$NO_URUT_RFQ_ASLI = $this->input->post('NO_URUT_RFQ_ASLI');
						$TANGGAL_DOKUMEN_RFQ = $this->input->post('TANGGAL_DOKUMEN_RFQ');
						$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
						$ID_VENDOR = $this->input->post('ID_VENDOR');
						$TERM_OF_PAYMENT = $this->input->post('TERM_OF_PAYMENT');
						$KETERANGAN_RFQ = $this->input->post('KETERANGAN_RFQ');
						$BATAS_AKHIR = $this->input->post('BATAS_AKHIR');
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

							$data = $this->Vendor_model->simpan_data_dari_rfq_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR);

							$this->Vendor_model->set_md5_id_vendor_dari_rfq_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR);
						} else {
							echo 'Nama vendor sudah terekam sebelumnya';
						}


						// ID VENDOR BUKAN DARI ID VENDOR 666666 TAPI DARI ID VENDOR YANG BARU DI INPUT
						$hasil = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
						$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
						$ID_VENDOR = $this->data['ID_VENDOR'];

						// $data_edit = $this->RFQ_model->rfq_list_by_id_rfq($ID_RFQ);
						// $KETERANGAN = "Ubah Data RFQ Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RFQ . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PROGRESS_RFQ . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $KETERANGAN_RFQ . ";"  . $BATAS_AKHIR;
						// $this->user_log($KETERANGAN);

						if($NO_URUT_RFQ_GANTI==$NO_URUT_RFQ_ASLI)
						{
							$data = $this->RFQ_model->simpan_identitas_form($ID_RFQ, $NO_URUT_RFQ_GANTI, $TANGGAL_DOKUMEN_RFQ, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $TERM_OF_PAYMENT, $KETERANGAN_RFQ, $BATAS_AKHIR);
							echo json_encode($data);
						}
						else
						{
							if ($this->RFQ_model->cek_nomor_urut_rfq($NO_URUT_RFQ_GANTI) == 'DATA BELUM ADA') 
							{
								$data = $this->RFQ_model->simpan_identitas_form($ID_RFQ, $NO_URUT_RFQ_GANTI, $TANGGAL_DOKUMEN_RFQ, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $TERM_OF_PAYMENT, $KETERANGAN_RFQ, $BATAS_AKHIR);
								echo json_encode($data);
							} else {
								echo 'Nomor Urut RFQ sudah terekam sebelumnya';
							}
						}
					}
				} else {

					//get the form data
					$ID_RFQ = $this->input->post('ID_RFQ');
					$NO_URUT_RFQ_GANTI = $this->input->post('NO_URUT_RFQ_GANTI');
					$NO_URUT_RFQ_ASLI = $this->input->post('NO_URUT_RFQ_ASLI');
					$TANGGAL_DOKUMEN_RFQ = $this->input->post('TANGGAL_DOKUMEN_RFQ');
					$ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
					$ID_VENDOR = $this->input->post('ID_VENDOR');
					$TERM_OF_PAYMENT = $this->input->post('TERM_OF_PAYMENT');
					$KETERANGAN_RFQ = $this->input->post('KETERANGAN_RFQ');
					$BATAS_AKHIR = $this->input->post('BATAS_AKHIR');
					
					// $data_edit = $this->RFQ_model->rfq_list_by_id_rfq($ID_RFQ);
					// $KETERANGAN = "Ubah Data RFQ Form (User Staff Procurement KP): " . json_encode($data_edit) . " ---- " . $ID_RFQ . ";" . $ID_PROYEK_LOKASI_PENYERAHAN . ";" . $ID_VENDOR . ";" . $ID_TERM_OF_PAYMENT . ";" . $PROGRESS_RFQ . ";" . $NAMA_VENDOR . ";" . $ALAMAT_VENDOR . ";" . $EMAIL_VENDOR . ";"  . $NO_TELP_VENDOR . ";"  . $NAMA_PIC_VENDOR . ";"  . $EMAIL_PIC_VENDOR . ";"  . $NO_HP_PIC_VENDOR . ";"  . $KETERANGAN_RFQ . ";"  . $BATAS_AKHIR;
					// $this->user_log($KETERANGAN);

					if($NO_URUT_RFQ_GANTI==$NO_URUT_RFQ_ASLI)
					{
						$data = $this->RFQ_model->simpan_identitas_form($ID_RFQ, $NO_URUT_RFQ_GANTI, $TANGGAL_DOKUMEN_RFQ, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $TERM_OF_PAYMENT, $KETERANGAN_RFQ, $BATAS_AKHIR);
						echo json_encode($data);
					}
					else
					{
						if ($this->RFQ_model->cek_nomor_urut_rfq($NO_URUT_RFQ_GANTI) == 'DATA BELUM ADA') 
						{
							$data = $this->RFQ_model->simpan_identitas_form($ID_RFQ, $NO_URUT_RFQ_GANTI, $TANGGAL_DOKUMEN_RFQ, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $TERM_OF_PAYMENT, $KETERANGAN_RFQ, $BATAS_AKHIR);
							echo json_encode($data);
						} else {
							echo 'Nomor Urut RFQ sudah terekam sebelumnya';
						}
					}
					
				}
			}
		} else {
			$this->logout();
		}
	}

	// //custom validation function to accept alphabets and space
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

		$HASH_MD5_RFQ = $this->uri->segment(3);
		if ($this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ) == 'TIDAK ADA DATA') {
			redirect('RFQ', 'refresh');
		}


		if ($this->ion_auth->logged_in()) {

			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_RFQ = $this->uri->segment(3);

			if ($this->ion_auth->in_group(5)) {
				$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
				$sess_data['HASH_MD5_RFQ'] = $this->data['HASH_MD5_RFQ'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RFQ);

				$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
				$ID_RFQ = $hasil['ID_RFQ'];
				$this->data['ID_RFQ'] = $ID_RFQ;
				$this->data['RFQ'] = $this->RFQ_model->rfq_list_by_id_rfq($ID_RFQ);

				foreach ($this->data['RFQ']->result() as $RFQ) :
					$this->data['FILE_NAME_TEMP'] = 'rfq_' . $HASH_MD5_RFQ . '.pdf';
					$this->data['NO_URUT_RFQ'] = $RFQ->NO_URUT_RFQ;
					$this->data['HASH_MD5_RFQ'] = $RFQ->HASH_MD5_RFQ;
					$this->data['PROGRESS_RFQ'] = $RFQ->PROGRESS_RFQ;
				endforeach;

				$query_file_HASH_MD5_RFQ = $this->RFQ_Form_File_Model->file_list_by_HASH_MD5_RFQ($HASH_MD5_RFQ);

				if ($query_file_HASH_MD5_RFQ->num_rows() > 0) {

					$this->data['dokumen'] = $this->RFQ_Form_File_Model->file_list_by_HASH_MD5_RFQ_result($HASH_MD5_RFQ);

					$hasil = $query_file_HASH_MD5_RFQ->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_rfq_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['JENIS_FILE'] = $JENIS_FILE;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_rfq_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(8)) {
				$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
				$sess_data['HASH_MD5_RFQ'] = $this->data['HASH_MD5_RFQ'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RFQ);

				$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
				$ID_RFQ = $hasil['ID_RFQ'];
				$this->data['ID_RFQ'] = $ID_RFQ;
				$this->data['RFQ'] = $this->RFQ_model->rfq_list_by_id_rfq($ID_RFQ);

				foreach ($this->data['RFQ']->result() as $RFQ) :
					$this->data['FILE_NAME_TEMP'] = 'rfq_' . $HASH_MD5_RFQ . '.pdf';
					$this->data['NO_URUT_RFQ'] = $RFQ->NO_URUT_RFQ;
					$this->data['HASH_MD5_RFQ'] = $RFQ->HASH_MD5_RFQ;
					$this->data['PROGRESS_RFQ'] = $RFQ->PROGRESS_RFQ;
				endforeach;

				$query_file_HASH_MD5_RFQ = $this->RFQ_Form_File_Model->file_list_by_HASH_MD5_RFQ($HASH_MD5_RFQ);

				if ($query_file_HASH_MD5_RFQ->num_rows() > 0) {

					$this->data['dokumen'] = $this->RFQ_Form_File_Model->file_list_by_HASH_MD5_RFQ_result($HASH_MD5_RFQ);

					$hasil = $query_file_HASH_MD5_RFQ->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_rfq_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['JENIS_FILE'] = $JENIS_FILE;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_rfq_form');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(9)) {
				$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
				$sess_data['HASH_MD5_RFQ'] = $this->data['HASH_MD5_RFQ'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_RFQ);

				$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
				$ID_RFQ = $hasil['ID_RFQ'];
				$this->data['ID_RFQ'] = $ID_RFQ;
				$this->data['RFQ'] = $this->RFQ_model->rfq_list_by_id_rfq($ID_RFQ);

				foreach ($this->data['RFQ']->result() as $RFQ) :
					$this->data['FILE_NAME_TEMP'] = 'rfq_' . $HASH_MD5_RFQ . '.pdf';
					$this->data['NO_URUT_RFQ'] = $RFQ->NO_URUT_RFQ;
					$this->data['HASH_MD5_RFQ'] = $RFQ->HASH_MD5_RFQ;
					$this->data['PROGRESS_RFQ'] = $RFQ->PROGRESS_RFQ;
				endforeach;

				$query_file_HASH_MD5_RFQ = $this->RFQ_Form_File_Model->file_list_by_HASH_MD5_RFQ($HASH_MD5_RFQ);

				if ($query_file_HASH_MD5_RFQ->num_rows() > 0) {

					$this->data['dokumen'] = $this->RFQ_Form_File_Model->file_list_by_HASH_MD5_RFQ_result($HASH_MD5_RFQ);

					$hasil = $query_file_HASH_MD5_RFQ->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_rfq_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['JENIS_FILE'] = $JENIS_FILE;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_rfq_form');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else {
				redirect('RFQ', 'refresh');
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
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->RFQ_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_rfq_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->RFQ_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_RFQ = $this->session->userdata('HASH_MD5_RFQ');
				redirect('/rfq_form/view/' . $HASH_MD5_RFQ, 'refresh');
			} else {
				$HASH_MD5_RFQ = $this->session->userdata('HASH_MD5_RFQ');
				redirect('/rfq_form/view/' . $HASH_MD5_RFQ, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->RFQ_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_rfq_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->RFQ_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_RFQ = $this->session->userdata('HASH_MD5_RFQ');
				redirect('/rfq_form/view/' . $HASH_MD5_RFQ, 'refresh');
			} else {
				$HASH_MD5_RFQ = $this->session->userdata('HASH_MD5_RFQ');
				redirect('/rfq_form/view/' . $HASH_MD5_RFQ, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->RFQ_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_rfq_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->RFQ_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_RFQ = $this->session->userdata('HASH_MD5_RFQ');
				redirect('/rfq_form/view/' . $HASH_MD5_RFQ, 'refresh');
			} else {
				$HASH_MD5_RFQ = $this->session->userdata('HASH_MD5_RFQ');
				redirect('/rfq_form/view/' . $HASH_MD5_RFQ, 'refresh');
			}
		} else {
			redirect('RFQ', 'refresh');
		}
	}

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

	public function cetak_pdf($HASH_MD5_RFQ)
	{
		$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
		$ID_RFQ = $hasil['ID_RFQ'];
		$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);
		foreach ($this->data['RFQ']->result() as $RFQ) :
			$this->data['ID_RFQ'] = $RFQ->ID_RFQ;
			$this->data['NO_URUT_RFQ'] = $RFQ->NO_URUT_RFQ;
			$this->data['TERM_OF_PAYMENT'] = $RFQ->TERM_OF_PAYMENT;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $RFQ->ID_PROYEK_LOKASI_PENYERAHAN;
			$this->data['ID_VENDOR'] = $RFQ->ID_VENDOR;
			$this->data['TANGGAL_DOKUMEN_RFQ'] = $RFQ->TANGGAL_DOKUMEN_RFQ;
			$this->data['TANGGAL_DOKUMEN_RFQ_INDO'] = $this->tanggal_indo_full($RFQ->TANGGAL_DOKUMEN_RFQ_INDO, false);
			$this->data['BATAS_AKHIR'] = $RFQ->BATAS_AKHIR;
			$this->data['BATAS_AKHIR_INDO'] = $this->tanggal_indo_full($RFQ->BATAS_AKHIR_INDO, false);
			$this->data['KETERANGAN_RFQ'] = $RFQ->KETERANGAN_RFQ;
		endforeach;

		$this->data['konten_RFQ_form'] = $this->RFQ_form_model->rfq_form_list_by_id_rfq($ID_RFQ);

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

		if ($this->data['ID_PROYEK_LOKASI_PENYERAHAN'] == "0" || $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] == null) {
			$this->data['NAMA_LOKASI_PENYERAHAN'] = "";
		} else {
			$this->data['PROYEK_LOKASI_PENYERAHAN'] = $this->Proyek_model->lokasi_penyerahan_list($this->data['ID_PROYEK_LOKASI_PENYERAHAN']);
			foreach ($this->data['PROYEK_LOKASI_PENYERAHAN']->result() as $PROYEK_LOKASI_PENYERAHAN) :
				$this->data['NAMA_LOKASI_PENYERAHAN'] = $PROYEK_LOKASI_PENYERAHAN->NAMA_LOKASI_PENYERAHAN;
			endforeach;
		}

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

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE

		$config['cacheable']    = true; //boolean, the default is true
		$config['cachedir']     = './assets/QR_RFQ/cachedir/'; //string, the default is application/cache/
		$config['errorlog']     = './assets/QR_RFQ/errorlog/'; //string, the default is application/logs/
		$config['imagedir']     = './assets/QR_RFQ/'; //direktori penyimpanan qr code
		$config['quality']      = true; //boolean, the default is true
		$config['size']         = '1024'; //interger, the default is 1024
		$config['black']        = array(224, 255, 255); // array, default is array(255,255,255)
		$config['white']        = array(70, 130, 180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		$image_name = $HASH_MD5_RFQ . '.jpg'; //buat name dari qr code sesuai dengan nim
		$this->data['image_name'] =  $image_name;

		$params['data'] = base_url('index.php/Otentikasi_dokumen/RFQ/') . $HASH_MD5_RFQ; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		$this->data['GAMBAR_QR'] = 'C:/xampp/htdocs/project_eam/assets/QR_RFQ/' . $HASH_MD5_RFQ . ".jpg";
		$this->data['GAMBAR_QR_2'] = 'C:/xampp/htdocs/project_eam/assets/QR_RFQ/' . $HASH_MD5_RFQ . ".jpg";


		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Request For Quotation';

		// filename dari pdf ketika didownload
		$file_pdf = 'rfq_' . $HASH_MD5_RFQ;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "potrait";

		$html = $this->load->view('wasa/pdf/rfq_pdf', $this->data, true);

		// run dompdf
		$x          = 500;
		$y          = 800;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 7;

		$file_path = "assets/RFQ/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	public function cetak_harga_pdf($HASH_MD5_RFQ)
	{
		$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
		$ID_RFQ = $hasil['ID_RFQ'];
		$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);
		foreach ($this->data['RFQ']->result() as $RFQ) :
			$this->data['ID_RFQ'] = $RFQ->ID_RFQ;
			$this->data['NO_URUT_RFQ'] = $RFQ->NO_URUT_RFQ;
			$this->data['ID_TERM_OF_PAYMENT'] = $RFQ->ID_TERM_OF_PAYMENT;
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $RFQ->ID_PROYEK_LOKASI_PENYERAHAN;
			$this->data['ID_VENDOR'] = $RFQ->ID_VENDOR;
			$this->data['TANGGAL_DOKUMEN_RFQ'] = $RFQ->TANGGAL_DOKUMEN_RFQ;
			$this->data['BATAS_AKHIR'] = $RFQ->BATAS_AKHIR;
			$this->data['KETERANGAN_RFQ'] = $RFQ->KETERANGAN_RFQ;
		endforeach;

		$this->data['konten_RFQ_form'] = $this->RFQ_form_model->rfq_form_list_by_id_rfq($ID_RFQ);

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
		$this->data['title_pdf'] = 'Request For Quotation Vendor';

		// filename dari pdf ketika didownload
		$file_pdf = 'rfq_vendor_' . $HASH_MD5_RFQ;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "potrait";

		$html = $this->load->view('wasa/pdf/rfq_vendor_pdf', $this->data, true);

		// run dompdf
		$x          = 500;
		$y          = 800;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 7;

		$file_path = "assets/RFQ/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	function update_data_kirim_rfq()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_RFQ', 'HASH_MD5_RFQ ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');

				$KETERANGAN = "Kirim Form RFQ ke Proses Selanjutnya: " . " ---- " . $HASH_MD5_RFQ;
				$this->user_log($KETERANGAN);

				$PROGRESS_RFQ = "Dalam Proses Kasie Procurement KP";

				$data = $this->RFQ_model->update_progress_rfq($HASH_MD5_RFQ, $PROGRESS_RFQ);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_RFQ', 'HASH_MD5_RFQ ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');

				$KETERANGAN = "Kirim Form RFQ ke Proses Selanjutnya: " . " ---- " . $HASH_MD5_RFQ;
				$this->user_log($KETERANGAN);

				$PROGRESS_RFQ = "Dalam Proses Manajer Procurement KP";

				$data = $this->RFQ_model->update_progress_rfq($HASH_MD5_RFQ, $PROGRESS_RFQ);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_RFQ', 'HASH_MD5_RFQ ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');

				$KETERANGAN = "Kirim Form RFQ ke Proses Selanjutnya: " . " ---- " . $HASH_MD5_RFQ;
				$this->user_log($KETERANGAN);

				$PROGRESS_RFQ = "Dalam Proses Manajer Procurement KP";

				$data = $this->RFQ_model->update_progress_rfq($HASH_MD5_RFQ, $PROGRESS_RFQ);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_RFQ', 'HASH_MD5_RFQ ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');

				$KETERANGAN = "Kirim Form RFQ ke Proses Selanjutnya: " . " ---- " . $HASH_MD5_RFQ;
				$this->user_log($KETERANGAN);

				$PROGRESS_RFQ = "Dalam Proses Supervisi Procurement SP";

				$data = $this->RFQ_model->update_progress_rfq($HASH_MD5_RFQ, $PROGRESS_RFQ);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_RFQ', 'HASH_MD5_RFQ ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');

				$KETERANGAN = "Kirim Form RFQ ke Proses Selanjutnya: " . " ---- " . $HASH_MD5_RFQ;
				$this->user_log($KETERANGAN);

				$PROGRESS_RFQ = "Dalam Proses Supervisi Procurement SP";

				$data = $this->RFQ_model->update_progress_rfq($HASH_MD5_RFQ, $PROGRESS_RFQ);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {
			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_RFQ', 'HASH_MD5_RFQ ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');

				$KETERANGAN = "Kirim Form RFQ ke Proses Selanjutnya: " . " ---- " . $HASH_MD5_RFQ;
				$this->user_log($KETERANGAN);

				$REVISI_KE = 1;

				$data = $this->RFQ_model->update_progress_rfq($HASH_MD5_RFQ, $REVISI_KE);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_kirim_email()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {


			// //set validation rules
			// $this->form_validation->set_rules('ID_RFQ', 'ID_RFQ ', 'trim|required');

			// //run validation check
			// if ($this->form_validation->run() == FALSE) {   //validation fails
			// 	echo json_encode(validation_errors());
			// } else {
			// 	//get the form data
			// 	$ID_RFQ = $this->input->post('ID_RFQ');

			// 	$KETERANGAN = "Kirim Form RFQ ke Proses Selanjutnya: " . " ---- " . $ID_RFQ;
			// 	$this->user_log($KETERANGAN);

			// 	$PROGRESS_RFQ = "Dalam Proses Kasie Procurement KP";

			// 	$data = $this->RFQ_model->update_progress_rfq($ID_RFQ, $PROGRESS_RFQ);
			// 	echo json_encode($data);
			// }
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_RFQ', 'HASH_MD5_RFQ ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');

				$KETERANGAN = "Proses Kirim Email RFQ ke Vendor: " . " ---- " . $HASH_MD5_RFQ;
				$this->user_log($KETERANGAN);

				$STATUS_VENDOR = "Dalam Proses Pembuatan Email";
				$PROGRESS_RFQ = "DALAM PEMBUATAN EMAIL";

				$data = $this->RFQ_model->update_status_vendor($HASH_MD5_RFQ, $STATUS_VENDOR);
				$data_2 = $this->RFQ_model->update_progress_rfq($HASH_MD5_RFQ, $PROGRESS_RFQ);
				echo json_encode($data_2);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_RFQ', 'HASH_MD5_RFQ ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');

				$KETERANGAN = "Proses Kirim Email RFQ ke Vendor: " . " ---- " . $HASH_MD5_RFQ;
				$this->user_log($KETERANGAN);

				$STATUS_VENDOR = "Dalam Proses Pembuatan Email";
				$PROGRESS_RFQ = "DALAM PEMBUATAN EMAIL";

				$data = $this->RFQ_model->update_status_vendor($HASH_MD5_RFQ, $STATUS_VENDOR);
				$data_2 = $this->RFQ_model->update_progress_rfq($HASH_MD5_RFQ, $PROGRESS_RFQ);
				echo json_encode($data_2);
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

	public function kirim_email($HASH_MD5_RFQ)
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

		if ($this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ) == 'TIDAK ADA DATA') {
			redirect('RFQ', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_RFQ = $hasil['ID_RFQ'];
			$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_RFQ'] = $ID_RFQ;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];

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

			$hasil = $this->RFQ_form_model->users_by_id_vendor($this->data['ID_VENDOR']);
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
			$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);


			$this->data['rasd_barang_list'] = $this->RFQ_form_model->rasd_form_list_where_not_in_rfq($ID_RFQ);
			$this->data['barang_master_list'] = $this->RFQ_form_model->barang_master_where_not_in_rfq_and_rasd($ID_RFQ);
			

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_rfq_form_kirim_email');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_RFQ = $hasil['ID_RFQ'];
			$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_RFQ'] = $ID_RFQ;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];

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

			$hasil = $this->RFQ_form_model->users_by_id_vendor($this->data['ID_VENDOR']);
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
			$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);


			$this->data['rasd_barang_list'] = $this->RFQ_form_model->rasd_form_list_where_not_in_rfq($ID_RFQ);
			$this->data['barang_master_list'] = $this->RFQ_form_model->barang_master_where_not_in_rfq_and_rasd($ID_RFQ);
			

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_rfq_form_kirim_email');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_RFQ = $hasil['ID_RFQ'];
			$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_RFQ'] = $ID_RFQ;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];

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

			$hasil = $this->RFQ_form_model->users_by_id_vendor($this->data['ID_VENDOR']);
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
			$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);


			$this->data['rasd_barang_list'] = $this->RFQ_form_model->rasd_form_list_where_not_in_rfq($ID_RFQ);
			$this->data['barang_master_list'] = $this->RFQ_form_model->barang_master_where_not_in_rfq_and_rasd($ID_RFQ);
			

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_rfq_form_kirim_email');
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

	function kirim_email_rfq()
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
				$ID_RFQ = $this->input->post('ID_RFQ');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$ISI_BODY = $this->input->post('ISI_BODY');
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');
				$NO_URUT_RFQ = $this->input->post('NO_URUT_RFQ');

				$data_edit = $this->RFQ_form_model->get_data_rfq_by_id_rfq($ID_RFQ);
				$KETERANGAN = "Isi RFQ: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);

				$KETERANGAN = "Update Data RFQ Form: " . json_encode($data_edit) . " ---- " . $ID_RFQ . ";" . $NAMA_PIC_VENDOR . ";" . $EMAIL_PIC_VENDOR  . ";"  . $ISI_BODY . ";" . $NO_URUT_RFQ;
				$this->user_log($KETERANGAN);
				$data = $this->RFQ_form_model->update_data_kirim_email($ID_RFQ, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $ISI_BODY);

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
				$judul = 'WME | Request For Quotation ' . $NO_URUT_RFQ;
				$this->email->subject($judul);
				$this->email->message($htmlContent);
				$alamat_1 = 'C:\xampp\htdocs\project_eam\assets\RFQ';
				$ekstensi = '\rfq_' . $HASH_MD5_RFQ . '.pdf';
				$alamat_pdf = $alamat_1 . $ekstensi;
				$this->email->attach($alamat_pdf);

				//Send email
				if ($this->email->send()) {
					echo 'Email Terkirim ke Vendor.';
				} else {
					show_error($this->email->print_debugger());
					echo show_error($this->email->print_debugger());
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
				$ID_RFQ = $this->input->post('ID_RFQ');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$ISI_BODY = $this->input->post('ISI_BODY');
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');
				$NO_URUT_RFQ = $this->input->post('NO_URUT_RFQ');

				$data_edit = $this->RFQ_form_model->get_data_rfq_by_id_rfq($ID_RFQ);
				$KETERANGAN = "Isi RFQ: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);

				$KETERANGAN = "Update Data RFQ Form: " . json_encode($data_edit) . " ---- " . $ID_RFQ . ";" . $NAMA_PIC_VENDOR . ";" . $EMAIL_PIC_VENDOR  . ";"  . $ISI_BODY . ";" . $NO_URUT_RFQ;
				$this->user_log($KETERANGAN);
				$data = $this->RFQ_form_model->update_data_kirim_email($ID_RFQ, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $ISI_BODY);

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
				$judul = 'WME | Request For Quotation ' . $NO_URUT_RFQ;
				$this->email->subject($judul);
				$this->email->message($htmlContent);
				$alamat_1 = 'C:\xampp\htdocs\project_eam\assets\RFQ';
				$ekstensi = '\rfq_' . $HASH_MD5_RFQ . '.pdf';
				$alamat_pdf = $alamat_1 . $ekstensi;
				$this->email->attach($alamat_pdf);

				//Send email
				if ($this->email->send()) {
					echo 'Email Terkirim ke Vendor.';
				} else {
					show_error($this->email->print_debugger());
					echo show_error($this->email->print_debugger());
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
				$ID_RFQ = $this->input->post('ID_RFQ');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$ISI_BODY = $this->input->post('ISI_BODY');
				$HASH_MD5_RFQ = $this->input->post('HASH_MD5_RFQ');
				$NO_URUT_RFQ = $this->input->post('NO_URUT_RFQ');

				$data_edit = $this->RFQ_form_model->get_data_rfq_by_id_rfq($ID_RFQ);
				$KETERANGAN = "Isi RFQ: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);

				$KETERANGAN = "Update Data RFQ Form: " . json_encode($data_edit) . " ---- " . $ID_RFQ . ";" . $NAMA_PIC_VENDOR . ";" . $EMAIL_PIC_VENDOR  . ";"  . $ISI_BODY . ";" . $NO_URUT_RFQ;
				$this->user_log($KETERANGAN);
				$data = $this->RFQ_form_model->update_data_kirim_email($ID_RFQ, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $ISI_BODY);

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
				$judul = 'WME | Request For Quotation ' . $NO_URUT_RFQ;
				$this->email->subject($judul);
				$this->email->message($htmlContent);
				$alamat_1 = 'C:\xampp\htdocs\project_eam\assets\RFQ';
				$ekstensi = '\rfq_' . $HASH_MD5_RFQ . '.pdf';
				$alamat_pdf = $alamat_1 . $ekstensi;
				$this->email->attach($alamat_pdf);

				//Send email
				if ($this->email->send()) {
					echo 'Email Terkirim ke Vendor.';
				} else {
					show_error($this->email->print_debugger());
					echo show_error($this->email->print_debugger());
				}
			}
		} else {
			$this->logout();
		}
	}

	public function send_email($HASH_MD5_RFQ)
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

	public function input_harga($HASH_MD5_RFQ)
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

		if ($this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ) == 'TIDAK ADA DATA') {
			redirect('RFQ', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {

			//fungsi ini untuk mengirim data ke dropdown
			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_RFQ = $hasil['ID_RFQ'];
			$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_RFQ'] = $ID_RFQ;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];

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
			$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);


			$this->data['rasd_barang_list'] = $this->RFQ_form_model->rasd_form_list_where_not_in_rfq($ID_RFQ);
			$this->data['barang_master_list'] = $this->RFQ_form_model->barang_master_where_not_in_rfq_and_rasd($ID_RFQ);
			

			$this->load->view('wasa/user_vendor/head_normal', $this->data);
			$this->load->view('wasa/user_vendor/user_menu');
			$this->load->view('wasa/user_vendor/left_menu');
			$this->load->view('wasa/user_vendor/header_menu');
			$this->load->view('wasa/user_vendor/content_rfq_form_input_harga');
			$this->load->view('wasa/user_vendor/footer');
		} else {
			$this->logout();
		}
	}

	public function revisi_harga($HASH_MD5_RFQ_REVISI)
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

		if ($this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ_REVISI($HASH_MD5_RFQ_REVISI) == 'TIDAK ADA DATA') {
			redirect('RFQ', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {

			//fungsi ini untuk mengirim data ke dropdown
			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ_REVISI($HASH_MD5_RFQ_REVISI);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_RFQ_REVISI = $hasil['ID_RFQ_REVISI'];
			$this->data['HASH_MD5_RFQ_REVISI'] = $HASH_MD5_RFQ_REVISI;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_RFQ_REVISI'] = $ID_RFQ_REVISI;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];

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
			$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5revisi($HASH_MD5_RFQ_REVISI);


			// $this->data['rasd_barang_list'] = $this->RFQ_form_model->rasd_form_list_where_not_in_rfq($ID_RFQ);
			// $this->data['barang_master_list'] = $this->RFQ_form_model->barang_master_where_not_in_rfq_and_rasd($ID_RFQ);
			

			$this->load->view('wasa/user_vendor/head_normal', $this->data);
			$this->load->view('wasa/user_vendor/user_menu');
			$this->load->view('wasa/user_vendor/left_menu');
			$this->load->view('wasa/user_vendor/header_menu');
			$this->load->view('wasa/user_vendor/content_rfq_form_input_harga');
			$this->load->view('wasa/user_vendor/footer');
		} else {
			$this->logout();
		}
	}

	public function pengajuan_vendor($HASH_MD5_RFQ)
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

		if ($this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ) == 'TIDAK ADA DATA') {
			redirect('RFQ', 'refresh');
		}

		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_RFQ = $hasil['ID_RFQ'];
			$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_RFQ'] = $ID_RFQ;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];

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
			$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);


			$this->data['rasd_barang_list'] = $this->RFQ_form_model->rasd_form_list_where_not_in_rfq($ID_RFQ);
			$this->data['barang_master_list'] = $this->RFQ_form_model->barang_master_where_not_in_rfq_and_rasd($ID_RFQ);
			

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_rfq_form_pengajuan_vendor');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_RFQ = $hasil['ID_RFQ'];
			$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_RFQ'] = $ID_RFQ;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];

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
			$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);


			$this->data['rasd_barang_list'] = $this->RFQ_form_model->rasd_form_list_where_not_in_rfq($ID_RFQ);
			$this->data['barang_master_list'] = $this->RFQ_form_model->barang_master_where_not_in_rfq_and_rasd($ID_RFQ);
			

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_rfq_form_pengajuan_vendor');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//fungsi ini untuk mengirim data ke dropdown

			$hasil = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$ID_SPPB = $hasil['ID_SPPB'];
			$ID_RFQ = $hasil['ID_RFQ'];
			$this->data['HASH_MD5_RFQ'] = $HASH_MD5_RFQ;
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['ID_RFQ'] = $ID_RFQ;
			$this->data['ID_VENDOR'] = $hasil['ID_VENDOR'];
			$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
			$this->data['ID_TERM_OF_PAYMENT'] = $hasil['ID_TERM_OF_PAYMENT'];
			$this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $hasil['ID_PROYEK_LOKASI_PENYERAHAN'];
			$this->data['BATAS_AKHIR'] = $hasil['BATAS_AKHIR'];

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
			$this->data['RFQ'] = $this->RFQ_model->rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ);


			$this->data['rasd_barang_list'] = $this->RFQ_form_model->rasd_form_list_where_not_in_rfq($ID_RFQ);
			$this->data['barang_master_list'] = $this->RFQ_form_model->barang_master_where_not_in_rfq_and_rasd($ID_RFQ);
			

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_rfq_form_pengajuan_vendor');
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

		$HASH_MD5_RFQ = $this->session->userdata('HASH_MD5_RFQ');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_RFQ . '_';
			$config['upload_path']   = './assets/upload_rfq_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_rfq = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$ID_RFQ = $query_id_rfq['ID_RFQ'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_rfq_form_file/' . $nama;
				$this->db->insert('rfq_form_file', array('ID_RFQ' => $ID_RFQ, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_RFQ' => $HASH_MD5_RFQ, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_RFQ . '_';
			$config['upload_path']   = './assets/upload_rfq_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_rfq = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$ID_RFQ = $query_id_rfq['ID_RFQ'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_rfq_form_file/' . $nama;
				$this->db->insert('rfq_form_file', array('ID_RFQ' => $ID_RFQ, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_RFQ' => $HASH_MD5_RFQ, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_RFQ . '_';
			$config['upload_path']   = './assets/upload_rfq_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_rfq = $this->RFQ_model->get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
			$ID_RFQ = $query_id_rfq['ID_RFQ'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_rfq_form_file/' . $nama;
				$this->db->insert('rfq_form_file', array('ID_RFQ' => $ID_RFQ, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_RFQ' => $HASH_MD5_RFQ, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
		}
	}
}
