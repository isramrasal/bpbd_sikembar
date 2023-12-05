<?php defined('BASEPATH') or exit('No direct script access allowed');

class Barang_entitas extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Barang Entitas';

		$this->load->model('Barang_entitas_model');
		$this->load->model('Barang_master_model');
		$this->load->model('Barang_master_file_model');
		$this->load->model('Gudang_model');
		$this->load->model('Gudang_barang_model');
		$this->load->model('Foto_model');
		$this->load->model('SPPB_model');
		$this->load->model('PO_model');
		$this->load->model('Proyek_model');

		$this->load->model('Manajemen_user_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "barang_master_aktif";
	}

	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Proyek";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Barang_entitas_model->user_log_barang_entitas($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Barang_entitas_model->user_log_barang_entitas($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_barang_entitas_list');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_barang_entitas_list');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$this->load->view('wasa/user_staff_umum_logistic_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistic_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/content_barang_entitas_list');
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function list_entitas()
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

		$HASH_MD5_BARANG_MASTER = $this->uri->segment(3);
		if ($this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER) == 'BELUM ADA BARANG MASTER') {
			redirect('barang_master', 'refresh');
		}


		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
			$query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);
			$this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;
			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;

			foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data) {
				$sess_data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->session->set_userdata($sess_data);

				$this->data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->data['KODE_BARANG'] = $data->KODE_BARANG;
				$this->data['NAMA'] = $data->NAMA;
				$this->data['PERALATAN_PERLENGKAPAN'] = $data->PERALATAN_PERLENGKAPAN;
			}

			$this->data['list_barang_entitas'] = $this->Barang_entitas_model->list_barang_entitas($sess_data['ID_BARANG_MASTER']);
			$this->data['sppb_list'] = $this->SPPB_model->sppb_list();
			$this->data['po_list'] = $this->PO_model->po_list();
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();

			//Kueri data di tabel barang_master file
			$query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

			if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

				$this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);

				$hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

				//USER LOG
				$KETERANGAN = "Melihat list Entitas: " . json_encode($hasil);
				$this->user_log($KETERANGAN);

				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['FILE'] = "ADA";
				} else {
					$this->data['FILE'] = "ADA";
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
			}


			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_barang_entitas_list_entitas');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
			$query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);
			$this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;
			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;

			foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data) {
				$sess_data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->session->set_userdata($sess_data);

				$this->data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->data['KODE_BARANG'] = $data->KODE_BARANG;
				$this->data['NAMA'] = $data->NAMA;
				$this->data['PERALATAN_PERLENGKAPAN'] = $data->PERALATAN_PERLENGKAPAN;
			}

			$this->data['list_barang_entitas'] = $this->Barang_entitas_model->list_barang_entitas($sess_data['ID_BARANG_MASTER']);
			$this->data['sppb_list'] = $this->SPPB_model->sppb_list();
			$this->data['po_list'] = $this->PO_model->po_list();
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();

			//Kueri data di tabel barang_master file
			$query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

			if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

				$this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);

				$hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

				//USER LOG
				$KETERANGAN = "Melihat list Entitas: " . json_encode($hasil);
				$this->user_log($KETERANGAN);

				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['FILE'] = "ADA";
				} else {
					$this->data['FILE'] = "ADA";
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
			}

			$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/content_barang_entitas_list_entitas');
			$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
			$query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);
			$this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;
			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;

			foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data) {
				$sess_data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->session->set_userdata($sess_data);

				$this->data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->data['KODE_BARANG'] = $data->KODE_BARANG;
				$this->data['NAMA'] = $data->NAMA;
				$this->data['PERALATAN_PERLENGKAPAN'] = $data->PERALATAN_PERLENGKAPAN;
			}

			$this->data['list_barang_entitas'] = $this->Barang_entitas_model->list_barang_entitas($sess_data['ID_BARANG_MASTER']);
			$this->data['sppb_list'] = $this->SPPB_model->sppb_list();
			$this->data['po_list'] = $this->PO_model->po_list();
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();

			//Kueri data di tabel barang_master file
			$query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

			if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

				$this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);

				$hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

				//USER LOG
				$KETERANGAN = "Melihat list Entitas: " . json_encode($hasil);
				$this->user_log($KETERANGAN);

				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['FILE'] = "ADA";
				} else {
					$this->data['FILE'] = "ADA";
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
			}

			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_barang_entitas_list_entitas');
			$this->load->view('wasa/user_kasie_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
			$query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);
			$this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;
			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;

			foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data) {
				$sess_data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->session->set_userdata($sess_data);

				$this->data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->data['KODE_BARANG'] = $data->KODE_BARANG;
				$this->data['NAMA'] = $data->NAMA;
				$this->data['PERALATAN_PERLENGKAPAN'] = $data->PERALATAN_PERLENGKAPAN;
			}

			$this->data['list_barang_entitas'] = $this->Barang_entitas_model->list_barang_entitas($sess_data['ID_BARANG_MASTER']);
			$this->data['sppb_list'] = $this->SPPB_model->sppb_list();
			$this->data['po_list'] = $this->PO_model->po_list();
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();

			//Kueri data di tabel barang_master file
			$query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

			if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

				$this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);

				$hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

				//USER LOG
				$KETERANGAN = "Melihat list Entitas: " . json_encode($hasil);
				$this->user_log($KETERANGAN);

				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['FILE'] = "ADA";
				} else {
					$this->data['FILE'] = "ADA";
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
			}

			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_barang_entitas_list_entitas');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
			$query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);
			$this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;
			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;

			foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data) {
				$sess_data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->session->set_userdata($sess_data);

				$this->data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->data['KODE_BARANG'] = $data->KODE_BARANG;
				$this->data['NAMA'] = $data->NAMA;
				$this->data['PERALATAN_PERLENGKAPAN'] = $data->PERALATAN_PERLENGKAPAN;
			}

			$this->data['list_barang_entitas'] = $this->Barang_entitas_model->list_barang_entitas($sess_data['ID_BARANG_MASTER']);
			$this->data['sppb_list'] = $this->SPPB_model->sppb_list();
			$this->data['po_list'] = $this->PO_model->po_list();
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();

			//Kueri data di tabel barang_master file
			$query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

			if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

				$this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);

				$hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

				//USER LOG
				$KETERANGAN = "Melihat list Entitas: " . json_encode($hasil);
				$this->user_log($KETERANGAN);

				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['FILE'] = "ADA";
				} else {
					$this->data['FILE'] = "ADA";
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
			}

			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_barang_entitas_list_entitas');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
			$query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);
			$this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;
			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;

			foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data) {
				$sess_data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->session->set_userdata($sess_data);

				$this->data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->data['KODE_BARANG'] = $data->KODE_BARANG;
				$this->data['NAMA'] = $data->NAMA;
				$this->data['PERALATAN_PERLENGKAPAN'] = $data->PERALATAN_PERLENGKAPAN;
			}

			$this->data['list_barang_entitas'] = $this->Barang_entitas_model->list_barang_entitas($sess_data['ID_BARANG_MASTER']);
			$this->data['sppb_list'] = $this->SPPB_model->sppb_list();
			$this->data['po_list'] = $this->PO_model->po_list();
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();

			//Kueri data di tabel barang_master file
			$query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

			if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

				$this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);

				$hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

				//USER LOG
				$KETERANGAN = "Melihat list Entitas: " . json_encode($hasil);
				$this->user_log($KETERANGAN);

				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['FILE'] = "ADA";
				} else {
					$this->data['FILE'] = "ADA";
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
			}

			$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/content_barang_entitas_list_entitas');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
			$query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);
			$this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;
			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;

			foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data) {
				$sess_data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->session->set_userdata($sess_data);

				$this->data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->data['KODE_BARANG'] = $data->KODE_BARANG;
				$this->data['NAMA'] = $data->NAMA;
				$this->data['PERALATAN_PERLENGKAPAN'] = $data->PERALATAN_PERLENGKAPAN;
			}

			$this->data['list_barang_entitas'] = $this->Barang_entitas_model->list_barang_entitas($sess_data['ID_BARANG_MASTER']);
			$this->data['sppb_list'] = $this->SPPB_model->sppb_list();
			$this->data['po_list'] = $this->PO_model->po_list();
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();

			//Kueri data di tabel barang_master file
			$query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

			if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

				$this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);

				$hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

				//USER LOG
				$KETERANGAN = "Melihat list Entitas: " . json_encode($hasil);
				$this->user_log($KETERANGAN);

				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['FILE'] = "ADA";
				} else {
					$this->data['FILE'] = "ADA";
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
			}

			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_barang_entitas_list_entitas');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
			$query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);
			$this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;
			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;

			foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data) {
				$sess_data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->session->set_userdata($sess_data);

				$this->data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->data['KODE_BARANG'] = $data->KODE_BARANG;
				$this->data['NAMA'] = $data->NAMA;
				$this->data['PERALATAN_PERLENGKAPAN'] = $data->PERALATAN_PERLENGKAPAN;
			}

			$this->data['list_barang_entitas'] = $this->Barang_entitas_model->list_barang_entitas($sess_data['ID_BARANG_MASTER']);
			$this->data['sppb_list'] = $this->SPPB_model->sppb_list();
			$this->data['po_list'] = $this->PO_model->po_list();
			$this->data['proyek_list'] = $this->Proyek_model->list_proyek();

			//Kueri data di tabel barang_master file
			$query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

			if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

				$this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);

				$hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

				//USER LOG
				$KETERANGAN = "Melihat list Entitas: " . json_encode($hasil);
				$this->user_log($KETERANGAN);

				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['FILE'] = "ADA";
				} else {
					$this->data['FILE'] = "ADA";
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
			}

			$this->load->view('wasa/user_staff_gudang_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/content_barang_entitas_list_entitas');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/footer');
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_list_sppb_by_id_proyek()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_PROYEK = $this->input->post('ID_PROYEK');
			$data = $this->Proyek_model->get_list_sppb_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Get Data SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_list_po_by_id_sppb()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPPB = $this->input->post('ID_SPPB');
			$data = $this->PO_model->get_list_po_by_id_sppb($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data PO: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_gudang_proyek()
	{
		$ID_PROYEK = $this->input->post('proyek', TRUE);
		$data = $this->Gudang_model->gudang_list_by_id_proyek_result($ID_PROYEK);
		echo json_encode($data);

		$KETERANGAN = "Get Data Gudang By Proyek: " . json_encode($data);
		$this->user_log($KETERANGAN);
	}

	function get_nomor_urut_by_ID_BARANG_MASTER()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_BARANG_MASTER = $this->input->get('id');
			$data = $this->Barang_entitas_model->get_nomor_urut_by_ID_BARANG_MASTER($ID_BARANG_MASTER);
			echo json_encode($data);

			$KETERANGAN = "Get Nomor Urut SPPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function list_barang_entitas()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_barang_entitas_by_id_master()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat list Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat list Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat list Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat list Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat list Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat list Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat list Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->list_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat list Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$id = $this->input->get('id');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();
			$ID_BARANG_ENTITAS = $this->input->post('kode');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($ID_BARANG_ENTITAS);

			//USER LOG
			$KETERANGAN = "Hapus barang_entitas " . $data['KODE_BARANG_ENTITAS'];
			$this->user_log($KETERANGAN);

			$data = $this->Barang_entitas_model->hapus_data_by_id_barang_entitas($ID_BARANG_ENTITAS);
			$data_2 = $this->Gudang_barang_model->hapus_data_by_ID_BARANG_ENTITAS($ID_BARANG_ENTITAS);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$user = $this->ion_auth->user()->row();
			$ID_BARANG_ENTITAS = $this->input->post('kode');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($ID_BARANG_ENTITAS);

			//USER LOG
			$KETERANGAN = "Hapus barang_entitas " . $data['KODE_BARANG_ENTITAS'];
			$this->user_log($KETERANGAN);

			$data = $this->Barang_entitas_model->hapus_data_by_id_barang_entitas($ID_BARANG_ENTITAS);
			$data_2 = $this->Gudang_barang_model->hapus_data_by_ID_BARANG_ENTITAS($ID_BARANG_ENTITAS);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$user = $this->ion_auth->user()->row();
			$ID_BARANG_ENTITAS = $this->input->post('kode');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($ID_BARANG_ENTITAS);

			//USER LOG
			$KETERANGAN = "Hapus barang_entitas " . $data['KODE_BARANG_ENTITAS'];
			$this->user_log($KETERANGAN);

			$data = $this->Barang_entitas_model->hapus_data_by_id_barang_entitas($ID_BARANG_ENTITAS);
			$data_2 = $this->Gudang_barang_model->hapus_data_by_ID_BARANG_ENTITAS($ID_BARANG_ENTITAS);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();
			$ID_BARANG_ENTITAS = $this->input->post('kode');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($ID_BARANG_ENTITAS);

			//USER LOG
			$KETERANGAN = "Hapus barang_entitas " . $data['KODE_BARANG_ENTITAS'];
			$this->user_log($KETERANGAN);

			$data = $this->Barang_entitas_model->hapus_data_by_id_barang_entitas($ID_BARANG_ENTITAS);
			$data_2 = $this->Gudang_barang_model->hapus_data_by_ID_BARANG_ENTITAS($ID_BARANG_ENTITAS);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$user = $this->ion_auth->user()->row();
			$ID_BARANG_ENTITAS = $this->input->post('kode');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($ID_BARANG_ENTITAS);

			//USER LOG
			$KETERANGAN = "Hapus barang_entitas " . $data['KODE_BARANG_ENTITAS'];
			$this->user_log($KETERANGAN);

			$data = $this->Barang_entitas_model->hapus_data_by_id_barang_entitas($ID_BARANG_ENTITAS);
			$data_2 = $this->Gudang_barang_model->hapus_data_by_ID_BARANG_ENTITAS($ID_BARANG_ENTITAS);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$user = $this->ion_auth->user()->row();
			$ID_BARANG_ENTITAS = $this->input->post('kode');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($ID_BARANG_ENTITAS);

			//USER LOG
			$KETERANGAN = "Hapus barang_entitas " . $data['KODE_BARANG_ENTITAS'];
			$this->user_log($KETERANGAN);

			$data = $this->Barang_entitas_model->hapus_data_by_id_barang_entitas($ID_BARANG_ENTITAS);
			$data_2 = $this->Gudang_barang_model->hapus_data_by_ID_BARANG_ENTITAS($ID_BARANG_ENTITAS);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$user = $this->ion_auth->user()->row();
			$ID_BARANG_ENTITAS = $this->input->post('kode');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($ID_BARANG_ENTITAS);

			//USER LOG
			$KETERANGAN = "Hapus barang_entitas " . $data['KODE_BARANG_ENTITAS'];
			$this->user_log($KETERANGAN);

			$data = $this->Barang_entitas_model->hapus_data_by_id_barang_entitas($ID_BARANG_ENTITAS);
			$data_2 = $this->Gudang_barang_model->hapus_data_by_ID_BARANG_ENTITAS($ID_BARANG_ENTITAS);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$user = $this->ion_auth->user()->row();
			$ID_BARANG_ENTITAS = $this->input->post('kode');
			$data = $this->Barang_entitas_model->get_data_by_id_barang_entitas($ID_BARANG_ENTITAS);

			//USER LOG
			$KETERANGAN = "Hapus barang_entitas " . $data['KODE_BARANG_ENTITAS'];
			$this->user_log($KETERANGAN);

			$data = $this->Barang_entitas_model->hapus_data_by_id_barang_entitas($ID_BARANG_ENTITAS);
			$data_2 = $this->Gudang_barang_model->hapus_data_by_ID_BARANG_ENTITAS($ID_BARANG_ENTITAS);
			echo json_encode($data);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function simpan_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$user = $this->ion_auth->user()->row();
			//set validation rules
			$this->form_validation->set_rules('KODE_BARANG_MASTER', 'Kode Barang Master', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('NO_URUT_BARANG', 'Nomor Urut Barang', 'trim|required|numeric|max_length[4]');
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('ID_PROYEK', 'Lokasi Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_GUDANG', 'Lokasi Gudang', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$KODE_BARANG_MASTER = $this->input->post('KODE_BARANG_MASTER');
				$QUANTITY_ENTITAS = $this->input->post('QUANTITY_ENTITAS');
				$KODE_BARANG_ENTITAS_START = $this->input->post('KODE_BARANG_ENTITAS_START');
				$KODE_BARANG_ENTITAS_END = $this->input->post('KODE_BARANG_ENTITAS_END');
				$SUDAH_SAMPAI_KE = $this->input->post('SUDAH_SAMPAI_KE');
				$NO_URUT_BARANG = $this->input->post('NO_URUT_BARANG');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_GUDANG = $this->input->post('ID_GUDANG');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');


				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";

					for ($x = 0; $x <= $QUANTITY_ENTITAS; $x++) {

						$SUDAH_SAMPAI_KE = $SUDAH_SAMPAI_KE + 1;

						if ($SUDAH_SAMPAI_KE < 1000) {
							$DEPAN_1 = "0";
						}

						if ($SUDAH_SAMPAI_KE < 100) {
							$DEPAN_1 = "00";
						}

						if ($SUDAH_SAMPAI_KE < 10) {
							$DEPAN_1 = "000";
						}

						if ($SUDAH_SAMPAI_KE < 1000) {
							$DEPAN_1 = "0";
						}

						if ($SUDAH_SAMPAI_KE < 100) {
							$DEPAN_1 = "00";
						}

						if ($SUDAH_SAMPAI_KE < 10) {
							$DEPAN_1 = "000";
						}

						$str1 = $DEPAN_1;
						$str2 = $SUDAH_SAMPAI_KE;

						$NO_URUT_1 = $str1 . $str2;

						$KODE_BARANG_ENTITAS = $KODE_BARANG_MASTER . "." . $NO_URUT_1;

						//check apakah nama barang_entitas sudah ada. jika belum ada, akan disimpan.
						if ($this->Barang_entitas_model->cek_kode_barang_entitas($KODE_BARANG_ENTITAS) == 'BELUM ADA KODE BARANG ENTITAS') {

							//USER LOG
							$KETERANGAN = "Simpan Barang Entitas " . $KODE_BARANG_ENTITAS .
								", KODE_BARANG_MASTER: " . $KODE_BARANG_MASTER .
								", ID_BARANG_MASTER: " . $ID_BARANG_MASTER .
								", NO_URUT_BARANG: " . $NO_URUT_BARANG .
								", ID_SPPB: " . $ID_SPPB .
								", ID_PO: " . $ID_PO .
								", TANGGAL_PEROLEHAN_HARI: " . $TANGGAL_PEROLEHAN_HARI .
								", STATUS_KEPEMILIKAN: " . $STATUS_KEPEMILIKAN .
								", ID_PROYEK: " . $ID_PROYEK .
								", ID_GUDANG: " . $ID_GUDANG .
								", POSISI: " . $POSISI .
								", KONDISI: " . $KONDISI .
								", JUMLAH_BARANG: " . $JUMLAH_BARANG .
								", JUMLAH_COUNT: " . $JUMLAH_COUNT .
								", TANGGAL_MULAI_SEWA_HARI: " . $TANGGAL_MULAI_SEWA_HARI .
								", TANGGAL_SELESAI_SEWA_HARI: " . $TANGGAL_SELESAI_SEWA_HARI .
								", PERALATAN_PERLENGKAPAN: " . $PERALATAN_PERLENGKAPAN;
							$this->user_log($KETERANGAN);

							$data = $this->Barang_entitas_model->simpan_data(
								$ID_BARANG_MASTER,
								$ID_SPPB,
								$ID_PO,
								$ID_PROYEK,
								$ID_GUDANG,
								$KODE_BARANG_ENTITAS,
								$JUMLAH_BARANG,
								$JUMLAH_COUNT,
								$TANGGAL_PEROLEHAN_HARI,
								$STATUS_KEPEMILIKAN,
								$TANGGAL_MULAI_SEWA_HARI,
								$TANGGAL_SELESAI_SEWA_HARI,
								$POSISI,
								$KONDISI
							);
							$ID_BARANG_ENTITAS = $this->Barang_entitas_model->get_id_barang_entitas_by_kode_barang_entitas($KODE_BARANG_ENTITAS);
							$this->Gudang_model->simpan_data_gudang_barang($ID_BARANG_MASTER, $ID_BARANG_ENTITAS, $ID_GUDANG);
						} else {
							echo 'Kode barang entitas sudah terekam sebelumnya';
						}
					}
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$user = $this->ion_auth->user()->row();
			//set validation rules
			$this->form_validation->set_rules('KODE_BARANG_MASTER', 'Kode Barang Master', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('NO_URUT_BARANG', 'Nomor Urut Barang', 'trim|required|numeric|max_length[4]');
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('ID_PROYEK', 'Lokasi Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_GUDANG', 'Lokasi Gudang', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$KODE_BARANG_MASTER = $this->input->post('KODE_BARANG_MASTER');
				$QUANTITY_ENTITAS = $this->input->post('QUANTITY_ENTITAS');
				$KODE_BARANG_ENTITAS_START = $this->input->post('KODE_BARANG_ENTITAS_START');
				$KODE_BARANG_ENTITAS_END = $this->input->post('KODE_BARANG_ENTITAS_END');
				$SUDAH_SAMPAI_KE = $this->input->post('SUDAH_SAMPAI_KE');
				$NO_URUT_BARANG = $this->input->post('NO_URUT_BARANG');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_GUDANG = $this->input->post('ID_GUDANG');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";

					for ($x = 0; $x <= $QUANTITY_ENTITAS; $x++) {

						$SUDAH_SAMPAI_KE = $SUDAH_SAMPAI_KE + 1;

						if ($SUDAH_SAMPAI_KE < 1000) {
							$DEPAN_1 = "0";
						}

						if ($SUDAH_SAMPAI_KE < 100) {
							$DEPAN_1 = "00";
						}

						if ($SUDAH_SAMPAI_KE < 10) {
							$DEPAN_1 = "000";
						}

						if ($SUDAH_SAMPAI_KE < 1000) {
							$DEPAN_1 = "0";
						}

						if ($SUDAH_SAMPAI_KE < 100) {
							$DEPAN_1 = "00";
						}

						if ($SUDAH_SAMPAI_KE < 10) {
							$DEPAN_1 = "000";
						}

						$str1 = $DEPAN_1;
						$str2 = $SUDAH_SAMPAI_KE;

						$NO_URUT_1 = $str1 . $str2;

						$KODE_BARANG_ENTITAS = $KODE_BARANG_MASTER . "." . $NO_URUT_1;

						//check apakah nama barang_entitas sudah ada. jika belum ada, akan disimpan.
						if ($this->Barang_entitas_model->cek_kode_barang_entitas($KODE_BARANG_ENTITAS) == 'BELUM ADA KODE BARANG ENTITAS') {

							//USER LOG
							$KETERANGAN = "Simpan Barang Entitas " . $KODE_BARANG_ENTITAS .
								", KODE_BARANG_MASTER: " . $KODE_BARANG_MASTER .
								", ID_BARANG_MASTER: " . $ID_BARANG_MASTER .
								", NO_URUT_BARANG: " . $NO_URUT_BARANG .
								", ID_SPPB: " . $ID_SPPB .
								", ID_PO: " . $ID_PO .
								", TANGGAL_PEROLEHAN_HARI: " . $TANGGAL_PEROLEHAN_HARI .
								", STATUS_KEPEMILIKAN: " . $STATUS_KEPEMILIKAN .
								", ID_PROYEK: " . $ID_PROYEK .
								", ID_GUDANG: " . $ID_GUDANG .
								", POSISI: " . $POSISI .
								", KONDISI: " . $KONDISI .
								", JUMLAH_BARANG: " . $JUMLAH_BARANG .
								", JUMLAH_COUNT: " . $JUMLAH_COUNT .
								", TANGGAL_MULAI_SEWA_HARI: " . $TANGGAL_MULAI_SEWA_HARI .
								", TANGGAL_SELESAI_SEWA_HARI: " . $TANGGAL_SELESAI_SEWA_HARI .
								", PERALATAN_PERLENGKAPAN: " . $PERALATAN_PERLENGKAPAN;
							$this->user_log($KETERANGAN);

							$data = $this->Barang_entitas_model->simpan_data(
								$ID_BARANG_MASTER,
								$ID_SPPB,
								$ID_PO,
								$ID_PROYEK,
								$ID_GUDANG,
								$KODE_BARANG_ENTITAS,
								$JUMLAH_BARANG,
								$JUMLAH_COUNT,
								$TANGGAL_PEROLEHAN_HARI,
								$STATUS_KEPEMILIKAN,
								$TANGGAL_MULAI_SEWA_HARI,
								$TANGGAL_SELESAI_SEWA_HARI,
								$POSISI,
								$KONDISI
							);
							$ID_BARANG_ENTITAS = $this->Barang_entitas_model->get_id_barang_entitas_by_kode_barang_entitas($KODE_BARANG_ENTITAS);
							$this->Gudang_model->simpan_data_gudang_barang($ID_BARANG_MASTER, $ID_BARANG_ENTITAS, $ID_GUDANG);
						} else {
							echo 'Kode barang entitas sudah terekam sebelumnya';
						}
					}
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();
			//set validation rules
			$this->form_validation->set_rules('KODE_BARANG_MASTER', 'Kode Barang Master', 'trim|required|max_length[30]');
			// $this->form_validation->set_rules('NO_URUT_BARANG', 'Nomor Urut Barang', 'trim|required|numeric|max_length[4]');
			$this->form_validation->set_rules('ID_PROYEK', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_GUDANG', 'Gudang', 'trim|required');
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$KODE_BARANG_MASTER = $this->input->post('KODE_BARANG_MASTER');
				$QUANTITY_ENTITAS = $this->input->post('QUANTITY_ENTITAS');
				$KODE_BARANG_ENTITAS_START = $this->input->post('KODE_BARANG_ENTITAS_START');
				$KODE_BARANG_ENTITAS_END = $this->input->post('KODE_BARANG_ENTITAS_END');
				$SUDAH_SAMPAI_KE = $this->input->post('SUDAH_SAMPAI_KE');
				// $NO_URUT_BARANG = $this->input->post('NO_URUT_BARANG');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_GUDANG = $this->input->post('ID_GUDANG');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($JUMLAH_COUNT == null) {
					$JUMLAH_COUNT = 0;
				}

				$SUDAH_SAMPAI_KE = $JUMLAH_COUNT;

				if ($PERALATAN_PERLENGKAPAN == ("TOOL")) {
					$JUMLAH_BARANG = "1";

					for ($x = 1; $x <= $QUANTITY_ENTITAS; $x++) {

						$SUDAH_SAMPAI_KE = $SUDAH_SAMPAI_KE + 1;

						if ($SUDAH_SAMPAI_KE < 1000) {
							$DEPAN_1 = "0";
						}

						if ($SUDAH_SAMPAI_KE < 100) {
							$DEPAN_1 = "00";
						}

						if ($SUDAH_SAMPAI_KE < 10) {
							$DEPAN_1 = "000";
						}

						if ($SUDAH_SAMPAI_KE < 1000) {
							$DEPAN_1 = "0";
						}

						if ($SUDAH_SAMPAI_KE < 100) {
							$DEPAN_1 = "00";
						}

						if ($SUDAH_SAMPAI_KE < 10) {
							$DEPAN_1 = "000";
						}

						$str1 = $DEPAN_1;
						$str2 = $SUDAH_SAMPAI_KE;

						$NO_URUT_1 = $str1 . $str2;

						$KODE_BARANG_ENTITAS = $KODE_BARANG_MASTER . "." . $NO_URUT_1;

						$JUMLAH_COUNT = $JUMLAH_COUNT + 1;

						//check apakah nama barang_entitas sudah ada. jika belum ada, akan disimpan.
						if ($this->Barang_entitas_model->cek_kode_barang_entitas($KODE_BARANG_ENTITAS) == 'BELUM ADA KODE BARANG ENTITAS') {

							//USER LOG
							$KETERANGAN = "Simpan Barang Entitas " . $KODE_BARANG_ENTITAS .
								", KODE_BARANG_MASTER: " . $KODE_BARANG_MASTER .
								", ID_BARANG_MASTER: " . $ID_BARANG_MASTER .
								", ID_SPPB: " . $ID_SPPB .
								", ID_PO: " . $ID_PO .
								", TANGGAL_PEROLEHAN_HARI: " . $TANGGAL_PEROLEHAN_HARI .
								", STATUS_KEPEMILIKAN: " . $STATUS_KEPEMILIKAN .
								", ID_PROYEK: " . $ID_PROYEK .
								", ID_GUDANG: " . $ID_GUDANG .
								", POSISI: " . $POSISI .
								", KONDISI: " . $KONDISI .
								", JUMLAH_BARANG: " . $JUMLAH_BARANG .
								", JUMLAH_COUNT: " . $JUMLAH_COUNT .
								", TANGGAL_MULAI_SEWA_HARI: " . $TANGGAL_MULAI_SEWA_HARI .
								", TANGGAL_SELESAI_SEWA_HARI: " . $TANGGAL_SELESAI_SEWA_HARI .
								", PERALATAN_PERLENGKAPAN: " . $PERALATAN_PERLENGKAPAN;
							$this->user_log($KETERANGAN);

							$data = $this->Barang_entitas_model->simpan_data(
								$ID_BARANG_MASTER,
								$ID_SPPB,
								$ID_PO,
								$ID_PROYEK,
								$ID_GUDANG,
								$KODE_BARANG_ENTITAS,
								$JUMLAH_BARANG,
								$JUMLAH_COUNT,
								$TANGGAL_PEROLEHAN_HARI,
								$STATUS_KEPEMILIKAN,
								$TANGGAL_MULAI_SEWA_HARI,
								$TANGGAL_SELESAI_SEWA_HARI,
								$POSISI,
								$KONDISI
							);
							$ID_BARANG_ENTITAS = $this->Barang_entitas_model->get_id_barang_entitas_by_kode_barang_entitas($KODE_BARANG_ENTITAS);
							$this->Gudang_model->simpan_data_gudang_barang($ID_BARANG_MASTER, $ID_BARANG_ENTITAS, $ID_GUDANG);
						} else {
							echo 'Kode barang entitas sudah terekam sebelumnya';
						}
					}
				} else if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {

					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

					for ($x = 1; $x <= $QUANTITY_ENTITAS; $x++) {

						$SUDAH_SAMPAI_KE = $SUDAH_SAMPAI_KE + 1;

						if ($SUDAH_SAMPAI_KE < 1000) {
							$DEPAN_1 = "0";
						}

						if ($SUDAH_SAMPAI_KE < 100) {
							$DEPAN_1 = "00";
						}

						if ($SUDAH_SAMPAI_KE < 10) {
							$DEPAN_1 = "000";
						}

						if ($SUDAH_SAMPAI_KE < 1000) {
							$DEPAN_1 = "0";
						}

						if ($SUDAH_SAMPAI_KE < 100) {
							$DEPAN_1 = "00";
						}

						if ($SUDAH_SAMPAI_KE < 10) {
							$DEPAN_1 = "000";
						}

						$str1 = $DEPAN_1;
						$str2 = $SUDAH_SAMPAI_KE;

						$NO_URUT_1 = $str1 . $str2;

						$KODE_BARANG_ENTITAS = $KODE_BARANG_MASTER . "." . $NO_URUT_1;

						$JUMLAH_COUNT = $JUMLAH_COUNT + 1;

						//check apakah nama barang_entitas sudah ada. jika belum ada, akan disimpan.
						if ($this->Barang_entitas_model->cek_kode_barang_entitas($KODE_BARANG_ENTITAS) == 'BELUM ADA KODE BARANG ENTITAS') {

							//USER LOG
							$KETERANGAN = "Simpan Barang Entitas " . $KODE_BARANG_ENTITAS .
								", KODE_BARANG_MASTER: " . $KODE_BARANG_MASTER .
								", ID_BARANG_MASTER: " . $ID_BARANG_MASTER .
								", ID_SPPB: " . $ID_SPPB .
								", ID_PO: " . $ID_PO .
								", TANGGAL_PEROLEHAN_HARI: " . $TANGGAL_PEROLEHAN_HARI .
								", STATUS_KEPEMILIKAN: " . $STATUS_KEPEMILIKAN .
								", ID_PROYEK: " . $ID_PROYEK .
								", ID_GUDANG: " . $ID_GUDANG .
								", POSISI: " . $POSISI .
								", KONDISI: " . $KONDISI .
								", JUMLAH_BARANG: " . $JUMLAH_BARANG .
								", JUMLAH_COUNT: " . $JUMLAH_COUNT .
								", TANGGAL_MULAI_SEWA_HARI: " . $TANGGAL_MULAI_SEWA_HARI .
								", TANGGAL_SELESAI_SEWA_HARI: " . $TANGGAL_SELESAI_SEWA_HARI .
								", PERALATAN_PERLENGKAPAN: " . $PERALATAN_PERLENGKAPAN;
							$this->user_log($KETERANGAN);

							$data = $this->Barang_entitas_model->simpan_data(
								$ID_BARANG_MASTER,
								$ID_SPPB,
								$ID_PO,
								$ID_PROYEK,
								$ID_GUDANG,
								$KODE_BARANG_ENTITAS,
								$JUMLAH_BARANG,
								$JUMLAH_COUNT,
								$TANGGAL_PEROLEHAN_HARI,
								$STATUS_KEPEMILIKAN,
								$TANGGAL_MULAI_SEWA_HARI,
								$TANGGAL_SELESAI_SEWA_HARI,
								$POSISI,
								$KONDISI
							);
							$ID_BARANG_ENTITAS = $this->Barang_entitas_model->get_id_barang_entitas_by_kode_barang_entitas($KODE_BARANG_ENTITAS);
							$this->Gudang_model->simpan_data_gudang_barang($ID_BARANG_MASTER, $ID_BARANG_ENTITAS, $ID_GUDANG);
						} else {
							echo 'Kode barang entitas sudah terekam sebelumnya';
						}
					}
				} else {
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$user = $this->ion_auth->user()->row();
			//set validation rules
			$this->form_validation->set_rules('KODE_BARANG_MASTER', 'Kode Barang Master', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('KODE_BARANG_ENTITAS', 'Kode Barang Entitas', 'trim|required');
			$this->form_validation->set_rules('NO_URUT_BARANG', 'Nomor Urut Barang', 'trim|required|numeric|max_length[4]');
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('ID_PROYEK', 'Lokasi Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_GUDANG', 'Lokasi Gudang', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$KODE_BARANG_MASTER = $this->input->post('KODE_BARANG_MASTER');
				$KODE_BARANG_ENTITAS = $this->input->post('KODE_BARANG_ENTITAS');
				$NO_URUT_BARANG = $this->input->post('NO_URUT_BARANG');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_GUDANG = $this->input->post('ID_GUDANG');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}


				//check apakah nama barang_entitas sudah ada. jika belum ada, akan disimpan.
				if ($this->Barang_entitas_model->cek_kode_barang_entitas($KODE_BARANG_ENTITAS) == 'BELUM ADA KODE BARANG ENTITAS') {

					//USER LOG
					$KETERANGAN = "Simpan Barang Entitas " . $KODE_BARANG_ENTITAS .
						", KODE_BARANG_MASTER: " . $KODE_BARANG_MASTER .
						", ID_BARANG_MASTER: " . $ID_BARANG_MASTER .
						", NO_URUT_BARANG: " . $NO_URUT_BARANG .
						", ID_SPPB: " . $ID_SPPB .
						", ID_PO: " . $ID_PO .
						", TANGGAL_PEROLEHAN_HARI: " . $TANGGAL_PEROLEHAN_HARI .
						", STATUS_KEPEMILIKAN: " . $STATUS_KEPEMILIKAN .
						", ID_PROYEK: " . $ID_PROYEK .
						", ID_GUDANG: " . $ID_GUDANG .
						", POSISI: " . $POSISI .
						", KONDISI: " . $KONDISI .
						", JUMLAH_BARANG: " . $JUMLAH_BARANG .
						", JUMLAH_COUNT: " . $JUMLAH_COUNT .
						", TANGGAL_MULAI_SEWA_HARI: " . $TANGGAL_MULAI_SEWA_HARI .
						", TANGGAL_SELESAI_SEWA_HARI: " . $TANGGAL_SELESAI_SEWA_HARI .
						", PERALATAN_PERLENGKAPAN: " . $PERALATAN_PERLENGKAPAN;
					$this->user_log($KETERANGAN);

					$data = $this->Barang_entitas_model->simpan_data(
						$ID_BARANG_MASTER,
						$ID_SPPB,
						$ID_PO,
						$ID_PROYEK,
						$ID_GUDANG,
						$KODE_BARANG_ENTITAS,
						$JUMLAH_BARANG,
						$JUMLAH_COUNT,
						$TANGGAL_PEROLEHAN_HARI,
						$STATUS_KEPEMILIKAN,
						$TANGGAL_MULAI_SEWA_HARI,
						$TANGGAL_SELESAI_SEWA_HARI,
						$POSISI,
						$KONDISI
					);
					$ID_BARANG_ENTITAS = $this->Barang_entitas_model->get_id_barang_entitas_by_kode_barang_entitas($KODE_BARANG_ENTITAS);
					$this->Gudang_model->simpan_data_gudang_barang($ID_BARANG_MASTER, $ID_BARANG_ENTITAS, $ID_GUDANG);
				} else {
					echo 'Kode barang entitas sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$user = $this->ion_auth->user()->row();
			//set validation rules
			$this->form_validation->set_rules('KODE_BARANG_MASTER', 'Kode Barang Master', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('KODE_BARANG_ENTITAS', 'Kode Barang Entitas', 'trim|required');
			$this->form_validation->set_rules('NO_URUT_BARANG', 'Nomor Urut Barang', 'trim|required|numeric|max_length[4]');
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('ID_PROYEK', 'Lokasi Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_GUDANG', 'Lokasi Gudang', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$KODE_BARANG_MASTER = $this->input->post('KODE_BARANG_MASTER');
				$KODE_BARANG_ENTITAS = $this->input->post('KODE_BARANG_ENTITAS');
				$NO_URUT_BARANG = $this->input->post('NO_URUT_BARANG');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_GUDANG = $this->input->post('ID_GUDANG');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}


				//check apakah nama barang_entitas sudah ada. jika belum ada, akan disimpan.
				if ($this->Barang_entitas_model->cek_kode_barang_entitas($KODE_BARANG_ENTITAS) == 'BELUM ADA KODE BARANG ENTITAS') {

					//USER LOG
					$KETERANGAN = "Simpan Barang Entitas " . $KODE_BARANG_ENTITAS .
						", KODE_BARANG_MASTER: " . $KODE_BARANG_MASTER .
						", ID_BARANG_MASTER: " . $ID_BARANG_MASTER .
						", NO_URUT_BARANG: " . $NO_URUT_BARANG .
						", ID_SPPB: " . $ID_SPPB .
						", ID_PO: " . $ID_PO .
						", TANGGAL_PEROLEHAN_HARI: " . $TANGGAL_PEROLEHAN_HARI .
						", STATUS_KEPEMILIKAN: " . $STATUS_KEPEMILIKAN .
						", ID_PROYEK: " . $ID_PROYEK .
						", ID_GUDANG: " . $ID_GUDANG .
						", POSISI: " . $POSISI .
						", KONDISI: " . $KONDISI .
						", JUMLAH_BARANG: " . $JUMLAH_BARANG .
						", JUMLAH_COUNT: " . $JUMLAH_COUNT .
						", TANGGAL_MULAI_SEWA_HARI: " . $TANGGAL_MULAI_SEWA_HARI .
						", TANGGAL_SELESAI_SEWA_HARI: " . $TANGGAL_SELESAI_SEWA_HARI .
						", PERALATAN_PERLENGKAPAN: " . $PERALATAN_PERLENGKAPAN;
					$this->user_log($KETERANGAN);

					$data = $this->Barang_entitas_model->simpan_data(
						$ID_BARANG_MASTER,
						$ID_SPPB,
						$ID_PO,
						$ID_PROYEK,
						$ID_GUDANG,
						$KODE_BARANG_ENTITAS,
						$JUMLAH_BARANG,
						$JUMLAH_COUNT,
						$TANGGAL_PEROLEHAN_HARI,
						$STATUS_KEPEMILIKAN,
						$TANGGAL_MULAI_SEWA_HARI,
						$TANGGAL_SELESAI_SEWA_HARI,
						$POSISI,
						$KONDISI
					);
					$ID_BARANG_ENTITAS = $this->Barang_entitas_model->get_id_barang_entitas_by_kode_barang_entitas($KODE_BARANG_ENTITAS);
					$this->Gudang_model->simpan_data_gudang_barang($ID_BARANG_MASTER, $ID_BARANG_ENTITAS, $ID_GUDANG);
				} else {
					echo 'Kode barang entitas sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$user = $this->ion_auth->user()->row();
			//set validation rules
			$this->form_validation->set_rules('KODE_BARANG_MASTER', 'Kode Barang Master', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('KODE_BARANG_ENTITAS', 'Kode Barang Entitas', 'trim|required');
			$this->form_validation->set_rules('NO_URUT_BARANG', 'Nomor Urut Barang', 'trim|required|numeric|max_length[4]');
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('ID_PROYEK', 'Lokasi Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_GUDANG', 'Lokasi Gudang', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$KODE_BARANG_MASTER = $this->input->post('KODE_BARANG_MASTER');
				$KODE_BARANG_ENTITAS = $this->input->post('KODE_BARANG_ENTITAS');
				$NO_URUT_BARANG = $this->input->post('NO_URUT_BARANG');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_GUDANG = $this->input->post('ID_GUDANG');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}


				//check apakah nama barang_entitas sudah ada. jika belum ada, akan disimpan.
				if ($this->Barang_entitas_model->cek_kode_barang_entitas($KODE_BARANG_ENTITAS) == 'BELUM ADA KODE BARANG ENTITAS') {

					//USER LOG
					$KETERANGAN = "Simpan Barang Entitas " . $KODE_BARANG_ENTITAS .
						", KODE_BARANG_MASTER: " . $KODE_BARANG_MASTER .
						", ID_BARANG_MASTER: " . $ID_BARANG_MASTER .
						", NO_URUT_BARANG: " . $NO_URUT_BARANG .
						", ID_SPPB: " . $ID_SPPB .
						", ID_PO: " . $ID_PO .
						", TANGGAL_PEROLEHAN_HARI: " . $TANGGAL_PEROLEHAN_HARI .
						", STATUS_KEPEMILIKAN: " . $STATUS_KEPEMILIKAN .
						", ID_PROYEK: " . $ID_PROYEK .
						", ID_GUDANG: " . $ID_GUDANG .
						", POSISI: " . $POSISI .
						", KONDISI: " . $KONDISI .
						", JUMLAH_BARANG: " . $JUMLAH_BARANG .
						", JUMLAH_COUNT: " . $JUMLAH_COUNT .
						", TANGGAL_MULAI_SEWA_HARI: " . $TANGGAL_MULAI_SEWA_HARI .
						", TANGGAL_SELESAI_SEWA_HARI: " . $TANGGAL_SELESAI_SEWA_HARI .
						", PERALATAN_PERLENGKAPAN: " . $PERALATAN_PERLENGKAPAN;
					$this->user_log($KETERANGAN);

					$data = $this->Barang_entitas_model->simpan_data(
						$ID_BARANG_MASTER,
						$ID_SPPB,
						$ID_PO,
						$ID_PROYEK,
						$ID_GUDANG,
						$KODE_BARANG_ENTITAS,
						$JUMLAH_BARANG,
						$JUMLAH_COUNT,
						$TANGGAL_PEROLEHAN_HARI,
						$STATUS_KEPEMILIKAN,
						$TANGGAL_MULAI_SEWA_HARI,
						$TANGGAL_SELESAI_SEWA_HARI,
						$POSISI,
						$KONDISI
					);
					$ID_BARANG_ENTITAS = $this->Barang_entitas_model->get_id_barang_entitas_by_kode_barang_entitas($KODE_BARANG_ENTITAS);
					$this->Gudang_model->simpan_data_gudang_barang($ID_BARANG_MASTER, $ID_BARANG_ENTITAS, $ID_GUDANG);
				} else {
					echo 'Kode barang entitas sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$user = $this->ion_auth->user()->row();
			//set validation rules
			$this->form_validation->set_rules('KODE_BARANG_MASTER', 'Kode Barang Master', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('KODE_BARANG_ENTITAS', 'Kode Barang Entitas', 'trim|required');
			$this->form_validation->set_rules('NO_URUT_BARANG', 'Nomor Urut Barang', 'trim|required|numeric|max_length[4]');
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('ID_PROYEK', 'Lokasi Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_GUDANG', 'Lokasi Gudang', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$KODE_BARANG_MASTER = $this->input->post('KODE_BARANG_MASTER');
				$KODE_BARANG_ENTITAS = $this->input->post('KODE_BARANG_ENTITAS');
				$NO_URUT_BARANG = $this->input->post('NO_URUT_BARANG');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_GUDANG = $this->input->post('ID_GUDANG');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}


				//check apakah nama barang_entitas sudah ada. jika belum ada, akan disimpan.
				if ($this->Barang_entitas_model->cek_kode_barang_entitas($KODE_BARANG_ENTITAS) == 'BELUM ADA KODE BARANG ENTITAS') {

					//USER LOG
					$KETERANGAN = "Simpan Barang Entitas " . $KODE_BARANG_ENTITAS .
						", KODE_BARANG_MASTER: " . $KODE_BARANG_MASTER .
						", ID_BARANG_MASTER: " . $ID_BARANG_MASTER .
						", NO_URUT_BARANG: " . $NO_URUT_BARANG .
						", ID_SPPB: " . $ID_SPPB .
						", ID_PO: " . $ID_PO .
						", TANGGAL_PEROLEHAN_HARI: " . $TANGGAL_PEROLEHAN_HARI .
						", STATUS_KEPEMILIKAN: " . $STATUS_KEPEMILIKAN .
						", ID_PROYEK: " . $ID_PROYEK .
						", ID_GUDANG: " . $ID_GUDANG .
						", POSISI: " . $POSISI .
						", KONDISI: " . $KONDISI .
						", JUMLAH_BARANG: " . $JUMLAH_BARANG .
						", JUMLAH_COUNT: " . $JUMLAH_COUNT .
						", TANGGAL_MULAI_SEWA_HARI: " . $TANGGAL_MULAI_SEWA_HARI .
						", TANGGAL_SELESAI_SEWA_HARI: " . $TANGGAL_SELESAI_SEWA_HARI .
						", PERALATAN_PERLENGKAPAN: " . $PERALATAN_PERLENGKAPAN;
					$this->user_log($KETERANGAN);

					$data = $this->Barang_entitas_model->simpan_data(
						$ID_BARANG_MASTER,
						$ID_SPPB,
						$ID_PO,
						$ID_PROYEK,
						$ID_GUDANG,
						$KODE_BARANG_ENTITAS,
						$JUMLAH_BARANG,
						$JUMLAH_COUNT,
						$TANGGAL_PEROLEHAN_HARI,
						$STATUS_KEPEMILIKAN,
						$TANGGAL_MULAI_SEWA_HARI,
						$TANGGAL_SELESAI_SEWA_HARI,
						$POSISI,
						$KONDISI
					);
					$ID_BARANG_ENTITAS = $this->Barang_entitas_model->get_id_barang_entitas_by_kode_barang_entitas($KODE_BARANG_ENTITAS);
					$this->Gudang_model->simpan_data_gudang_barang($ID_BARANG_MASTER, $ID_BARANG_ENTITAS, $ID_GUDANG);
				} else {
					echo 'Kode barang entitas sudah terekam sebelumnya';
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
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN_HARI', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN_HARI');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}

				$data = $this->Barang_entitas_model->update_data(
					$ID_BARANG_ENTITAS,
					$ID_SPPB,
					$ID_PO,
					$JUMLAH_BARANG,
					$TANGGAL_PEROLEHAN_HARI,
					$STATUS_KEPEMILIKAN,
					$TANGGAL_MULAI_SEWA_HARI,
					$TANGGAL_SELESAI_SEWA_HARI,
					$POSISI,
					$KONDISI
				);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN_HARI', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN_HARI');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}

				$data = $this->Barang_entitas_model->update_data(
					$ID_BARANG_ENTITAS,
					$ID_SPPB,
					$ID_PO,
					$JUMLAH_BARANG,
					$TANGGAL_PEROLEHAN_HARI,
					$STATUS_KEPEMILIKAN,
					$TANGGAL_MULAI_SEWA_HARI,
					$TANGGAL_SELESAI_SEWA_HARI,
					$POSISI,
					$KONDISI
				);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN_HARI', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN_HARI');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}

				$data = $this->Barang_entitas_model->update_data(
					$ID_BARANG_ENTITAS,
					$ID_SPPB,
					$ID_PO,
					$JUMLAH_BARANG,
					$TANGGAL_PEROLEHAN_HARI,
					$STATUS_KEPEMILIKAN,
					$TANGGAL_MULAI_SEWA_HARI,
					$TANGGAL_SELESAI_SEWA_HARI,
					$POSISI,
					$KONDISI
				);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN_HARI', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN_HARI');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}

				$data = $this->Barang_entitas_model->update_data($ID_BARANG_ENTITAS, $ID_SPPB, $ID_PO, $JUMLAH_BARANG, $TANGGAL_PEROLEHAN_HARI, $STATUS_KEPEMILIKAN, $TANGGAL_MULAI_SEWA_HARI, $TANGGAL_SELESAI_SEWA_HARI, $POSISI, $KONDISI);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN_HARI', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN_HARI');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}

				$data = $this->Barang_entitas_model->update_data(
					$ID_BARANG_ENTITAS,
					$ID_SPPB,
					$ID_PO,
					$JUMLAH_BARANG,
					$TANGGAL_PEROLEHAN_HARI,
					$STATUS_KEPEMILIKAN,
					$TANGGAL_MULAI_SEWA_HARI,
					$TANGGAL_SELESAI_SEWA_HARI,
					$POSISI,
					$KONDISI
				);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN_HARI', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN_HARI');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}

				$data = $this->Barang_entitas_model->update_data(
					$ID_BARANG_ENTITAS,
					$ID_SPPB,
					$ID_PO,
					$JUMLAH_BARANG,
					$TANGGAL_PEROLEHAN_HARI,
					$STATUS_KEPEMILIKAN,
					$TANGGAL_MULAI_SEWA_HARI,
					$TANGGAL_SELESAI_SEWA_HARI,
					$POSISI,
					$KONDISI
				);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN_HARI', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN_HARI');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}

				$data = $this->Barang_entitas_model->update_data(
					$ID_BARANG_ENTITAS,
					$ID_SPPB,
					$ID_PO,
					$JUMLAH_BARANG,
					$TANGGAL_PEROLEHAN_HARI,
					$STATUS_KEPEMILIKAN,
					$TANGGAL_MULAI_SEWA_HARI,
					$TANGGAL_SELESAI_SEWA_HARI,
					$POSISI,
					$KONDISI
				);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(42))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_PEROLEHAN_HARI', 'Tanggal Perolehan', 'trim|required');
			$this->form_validation->set_rules('STATUS_KEPEMILIKAN', 'Beli atau Sewa', 'trim|required');
			$this->form_validation->set_rules('POSISI', 'Posisi', 'trim|required');
			$this->form_validation->set_rules('KONDISI', 'Kondisi', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|max_length[4]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_PO = $this->input->post('ID_PO');
				$TANGGAL_PEROLEHAN_HARI = $this->input->post('TANGGAL_PEROLEHAN_HARI');
				$STATUS_KEPEMILIKAN = $this->input->post('STATUS_KEPEMILIKAN');
				$POSISI = $this->input->post('POSISI');
				$KONDISI = $this->input->post('KONDISI');
				$TANGGAL_MULAI_SEWA_HARI = $this->input->post('TANGGAL_MULAI_SEWA_HARI');
				$TANGGAL_SELESAI_SEWA_HARI = $this->input->post('TANGGAL_SELESAI_SEWA_HARI');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');

				if ($PERALATAN_PERLENGKAPAN == ("TOOL" || "Tool" || "Tools" || "tools")) {
					$JUMLAH_BARANG = "1";
				}
				if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) {
					$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				}

				$data = $this->Barang_entitas_model->update_data(
					$ID_BARANG_ENTITAS,
					$ID_SPPB,
					$ID_PO,
					$JUMLAH_BARANG,
					$TANGGAL_PEROLEHAN_HARI,
					$STATUS_KEPEMILIKAN,
					$TANGGAL_MULAI_SEWA_HARI,
					$TANGGAL_SELESAI_SEWA_HARI,
					$POSISI,
					$KONDISI
				);
				echo ($data);
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

	//TAMPILAN TAMBAH
	function tambah()
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

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$HASH_MD5_BARANG_MASTER = $this->uri->segment(3);
			if ($this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER) == 'BELUM ADA BARANG MASTER') {
				redirect('barang_master', 'refresh');
			}

			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
			$query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER);
			$this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;
			$this->data['HASH_MD5_BARANG_MASTER'] = $HASH_MD5_BARANG_MASTER;

			foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data) {
				$sess_data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
				$this->session->set_userdata($sess_data);
			}

			//Kueri data di tabel barang_master file
			$query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($this->data['HASH_MD5_BARANG_MASTER']);

			if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

				$this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($this->data['HASH_MD5_BARANG_MASTER']);

				$hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['FILE'] = "ADA";
				} else {
					$this->data['FILE'] = "ADA";
				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
			}

			$this->data['sppb_list'] = $this->SPPB_model->sppb_list();

			$this->data['gudang'] = $this->Gudang_model->gudang_list();
			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			//$this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_barang_entitas_tambah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$id_master = $this->uri->segment(3);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['gudang'] = $this->Gudang_model->gudang_list();
			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_barang_entitas_tambah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$id_master = $this->uri->segment(3);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['gudang'] = $this->Gudang_model->gudang_list();
			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_barang_entitas_tambah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$id_master = $this->uri->segment(3);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['gudang'] = $this->Gudang_model->gudang_list();
			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_barang_entitas_tambah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$id_master = $this->uri->segment(3);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['gudang'] = $this->Gudang_model->gudang_list();
			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_barang_entitas_tambah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$id_master = $this->uri->segment(3);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['gudang'] = $this->Gudang_model->gudang_list();
			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_supervisi_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_kp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_kp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_kp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_kp/content_barang_entitas_tambah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$id_master = $this->uri->segment(3);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['gudang'] = $this->Gudang_model->gudang_list();
			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_staff_umum_logistic_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistic_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/content_barang_entitas_tambah');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_Barang_master');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	//TAMPILAN UBAH
	function view_ubah()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}


		//get data tabel users untuk ditampilkan
		$user = $this->ion_auth->user()->row();
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		$this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['left_menu'] = "barang_master_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_barang_entitas_ubah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_barang_entitas_ubah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_barang_entitas_ubah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_barang_entitas_ubah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_barang_entitas_ubah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->load->view('wasa/user_supervisi_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_kp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_kp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_kp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_kp/content_barang_entitas_ubah');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			$this->load->view('wasa/user_staff_umum_logistic_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistic_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/content_barang_entitas_ubah');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_Barang_master');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	//TAMPILAN VIEW
	function view()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}


		//get data tabel users untuk ditampilkan
		$user = $this->ion_auth->user()->row();
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		$this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['left_menu'] = "barang_master_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			// $this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_barang_entitas_view');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			// $this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_barang_entitas_view');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			// $this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_barang_entitas_view');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			// $this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_barang_entitas_view');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			// $this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_barang_entitas_view');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			// $this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_supervisi_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_kp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_kp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_kp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_kp/content_barang_entitas_view');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$id_master = $this->uri->segment(3);
			$id_entitas = $this->uri->segment(4);
			if ($this->Barang_master_model->get_data_by_id_barang_master($id_master) == 'BELUM ADA BARANG MASTER' || $this->Barang_entitas_model->get_data_by_id_barang_entitas($id_entitas) == 'BELUM ADA BARANG ENTITAS') {
				redirect('404_override', 'refresh');
			}
			$this->data['id_barang_master'] = $id_master;
			$this->data['id_barang_entitas'] = $id_entitas;
			$this->data['barang_master'] = $this->Barang_master_model->barang_master_list_by_id_barang_master($id_master);
			$this->data['proyek'] = $this->Gudang_model->gudang_list();

			$this->data['barang_entitas'] = $this->Barang_entitas_model->barang_entitas_list();
			// $this->data['kode_barang_entitas'] = $this->Barang_entitas_model->buat_kode($id_master);
			$this->load->view('wasa/user_staff_umum_logistic_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistic_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistic_sp/content_barang_entitas_view');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_Barang_master');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
}
