<?php defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_perbaikan_barang_entitas extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Riwayat Perbaikan Barang';

		$this->load->model('Riwayat_perbaikan_barang_entitas_model');
		$this->load->model('Barang_entitas_model');
		$this->load->model('Foto_model');
		$this->load->model('Barang_master_model');
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
		//$this->load->model('ws_pegawai_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Riwayat Perbaikan Barang Entitas";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Riwayat_perbaikan_barang_entitas_model->user_log_riwayat_perbaikan_b_e($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Riwayat_perbaikan_barang_entitas_model->user_log_riwayat_perbaikan_b_e($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		$this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
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
			$this->load->view('wasa/user_admin/content_riwayat_perbaikan_barang_entitas');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$this->logout();
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$this->logout();
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$this->logout();
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$this->logout();
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$this->logout();
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$this->logout();
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$this->logout();
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_riwayat_perbaikan_barang_entitas');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$this->logout();
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$this->logout();
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$this->logout();
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_riwayat_perbaikan_barang_entitas');
		// }
		else {
			$this->logout();
		}
	}

	function data_riwayat_perbaikan_barang_entitas()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->riwayat_perbaikan_barang_list($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->riwayat_perbaikan_barang_list($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->riwayat_perbaikan_barang_list($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->riwayat_perbaikan_barang_list($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->riwayat_perbaikan_barang_list($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->riwayat_perbaikan_barang_list($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->riwayat_perbaikan_barang_list($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->riwayat_perbaikan_barang_list($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas : " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$id = $this->input->get('id');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($id);
			echo json_encode($data);

			//USER LOG
			$KETERANGAN = "Melihat Data Riwayat Perbaikan Barang Entitas: " . json_encode($data);
			$this->user_log($KETERANGAN);
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
		$this->data['left_menu'] = "Riwayat_perbaikan_barang_entitas_aktif";

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
			$this->data['ID_BARANG_MASTER'] = $data->ID_BARANG_MASTER;
			$this->data['ID_BARANG_ENTITAS'] = $data->ID_BARANG_ENTITAS;
			$this->data['KODE_BARANG'] = $data->KODE_BARANG;
			$this->data['NAMA'] = $data->NAMA;
			$this->data['MEREK'] = $data->MEREK;
			$this->data['STATUS_KEPEMILIKAN'] = $data->STATUS_KEPEMILIKAN;
			$this->data['PERALATAN_PERLENGKAPAN'] = $data->PERALATAN_PERLENGKAPAN;
		}

		$this->data['ID_R_PERBAIKAN_B_E'] = $this->uri->segment(3);
		$ID_R_PERBAIKAN_B_E = $this->data['ID_R_PERBAIKAN_B_E'];

		$konten_riwayat_perbaikan_barang = $this->Riwayat_perbaikan_barang_entitas_model->riwayat_perbaikan_barang_list($ID_R_PERBAIKAN_B_E);
		$this->data['konten_riwayat_perbaikan_barang'] = $konten_riwayat_perbaikan_barang;
		foreach ($konten_riwayat_perbaikan_barang as $data) {
			$this->data['ID_R_PERBAIKAN_B_E'] = $data->ID_R_PERBAIKAN_B_E;
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

		// $HASH_MD5_BARANG_MASTER = $this->uri->segment(3);
		// if ($this->Riwayat_perbaikan_barang_entitas_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER) == 'BELUM ADA BARANG MASTER') {
		// 	redirect('barang_master', 'refresh');
		// }

		$this->data['riwayat_perbaikan_barang_entitas'] = $this->Riwayat_perbaikan_barang_entitas_model->riwayat_perbaikan_barang_entitas_list_by_HASH_MD5_BARANG_ENTITAS($HASH_MD5_BARANG_ENTITAS);

		$sess_data['HASH_MD5_BARANG_ENTITAS'] = $this->data['HASH_MD5_BARANG_ENTITAS'];
		$this->session->set_userdata($sess_data);

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_riwayat_perbaikan_barang_entitas_md5');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/content_riwayat_perbaikan_barang_entitas_md5');
			$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_riwayat_perbaikan_barang_entitas_md5');
			$this->load->view('wasa/user_kasie_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_riwayat_perbaikan_barang_entitas_md5');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_riwayat_perbaikan_barang_entitas_md5');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/content_riwayat_perbaikan_barang_entitas_md5');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_riwayat_perbaikan_barang_entitas_md5');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$this->load->view('wasa/user_staff_gudang_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/content_riwayat_perbaikan_barang_entitas_md5');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/footer');
		} else {
			$this->logout();
		}
	}

	function simpan_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_perbaikan_barang_entitas_model->simpan_data(
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$LOKASI_SERVICE,
					$KETERANGAN,
					$TANGGAL_MULAI_SERVICE_HARI,
					$TANGGAL_SELESAI_SERVICE_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_perbaikan_barang_entitas_model->set_md5_id_riwayat($ID_BARANG_ENTITAS, $ID_BARANG_MASTER, $LOKASI_SERVICE, $CREATE_BY_USER);

				//USER LOG
				$KETERANGAN = "Simpan Data Riwayat Perbaikan Entitas " . " - " . $ID_BARANG_MASTER . " - " . $ID_BARANG_ENTITAS . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI . " - " . $CREATE_BY_USER;
				$this->user_log($KETERANGAN);
				echo $hasil_2;
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_perbaikan_barang_entitas_model->simpan_data(
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$LOKASI_SERVICE,
					$KETERANGAN,
					$TANGGAL_MULAI_SERVICE_HARI,
					$TANGGAL_SELESAI_SERVICE_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_perbaikan_barang_entitas_model->set_md5_id_riwayat($ID_BARANG_ENTITAS, $ID_BARANG_MASTER, $LOKASI_SERVICE, $CREATE_BY_USER);

				//USER LOG
				$KETERANGAN = "Simpan Data Riwayat Perbaikan Entitas " . " - " . $ID_BARANG_MASTER . " - " . $ID_BARANG_ENTITAS . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI . " - " . $CREATE_BY_USER;
				$this->user_log($KETERANGAN);
				echo $hasil_2;
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_perbaikan_barang_entitas_model->simpan_data(
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$LOKASI_SERVICE,
					$KETERANGAN,
					$TANGGAL_MULAI_SERVICE_HARI,
					$TANGGAL_SELESAI_SERVICE_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_perbaikan_barang_entitas_model->set_md5_id_riwayat($ID_BARANG_ENTITAS, $ID_BARANG_MASTER, $LOKASI_SERVICE, $CREATE_BY_USER);

				//USER LOG
				$KETERANGAN = "Simpan Data Riwayat Perbaikan Entitas " . " - " . $ID_BARANG_MASTER . " - " . $ID_BARANG_ENTITAS . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI . " - " . $CREATE_BY_USER;
				$this->user_log($KETERANGAN);
				echo $hasil_2;
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_perbaikan_barang_entitas_model->simpan_data(
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$LOKASI_SERVICE,
					$KETERANGAN,
					$TANGGAL_MULAI_SERVICE_HARI,
					$TANGGAL_SELESAI_SERVICE_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_perbaikan_barang_entitas_model->set_md5_id_riwayat($ID_BARANG_ENTITAS, $ID_BARANG_MASTER, $LOKASI_SERVICE, $CREATE_BY_USER);

				//USER LOG
				$KETERANGAN = "Simpan Data Riwayat Perbaikan Entitas " . " - " . $ID_BARANG_MASTER . " - " . $ID_BARANG_ENTITAS . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI . " - " . $CREATE_BY_USER;
				$this->user_log($KETERANGAN);
				echo $hasil_2;
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_perbaikan_barang_entitas_model->simpan_data(
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$LOKASI_SERVICE,
					$KETERANGAN,
					$TANGGAL_MULAI_SERVICE_HARI,
					$TANGGAL_SELESAI_SERVICE_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_perbaikan_barang_entitas_model->set_md5_id_riwayat($ID_BARANG_ENTITAS, $ID_BARANG_MASTER, $LOKASI_SERVICE, $CREATE_BY_USER);

				//USER LOG
				$KETERANGAN = "Simpan Data Riwayat Perbaikan Entitas " . " - " . $ID_BARANG_MASTER . " - " . $ID_BARANG_ENTITAS . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI . " - " . $CREATE_BY_USER;
				$this->user_log($KETERANGAN);
				echo $hasil_2;
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_perbaikan_barang_entitas_model->simpan_data(
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$LOKASI_SERVICE,
					$KETERANGAN,
					$TANGGAL_MULAI_SERVICE_HARI,
					$TANGGAL_SELESAI_SERVICE_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_perbaikan_barang_entitas_model->set_md5_id_riwayat($ID_BARANG_ENTITAS, $ID_BARANG_MASTER, $LOKASI_SERVICE, $CREATE_BY_USER);

				//USER LOG
				$KETERANGAN = "Simpan Data Riwayat Perbaikan Entitas " . " - " . $ID_BARANG_MASTER . " - " . $ID_BARANG_ENTITAS . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI . " - " . $CREATE_BY_USER;
				$this->user_log($KETERANGAN);
				echo $hasil_2;
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_perbaikan_barang_entitas_model->simpan_data(
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$LOKASI_SERVICE,
					$KETERANGAN,
					$TANGGAL_MULAI_SERVICE_HARI,
					$TANGGAL_SELESAI_SERVICE_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_perbaikan_barang_entitas_model->set_md5_id_riwayat($ID_BARANG_ENTITAS, $ID_BARANG_MASTER, $LOKASI_SERVICE, $CREATE_BY_USER);

				//USER LOG
				$KETERANGAN = "Simpan Data Riwayat Perbaikan Entitas " . " - " . $ID_BARANG_MASTER . " - " . $ID_BARANG_ENTITAS . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI . " - " . $CREATE_BY_USER;
				$this->user_log($KETERANGAN);
				echo $hasil_2;
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(42))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$ID_BARANG_ENTITAS = $this->input->post('ID_BARANG_ENTITAS');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');
				$CREATE_BY_USER =  $this->data['USER_ID'];

				//check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
				$hasil = $this->Riwayat_perbaikan_barang_entitas_model->simpan_data(
					$ID_BARANG_MASTER,
					$ID_BARANG_ENTITAS,
					$LOKASI_SERVICE,
					$KETERANGAN,
					$TANGGAL_MULAI_SERVICE_HARI,
					$TANGGAL_SELESAI_SERVICE_HARI,
					$CREATE_BY_USER
				);

				$hasil_2 = $this->Riwayat_perbaikan_barang_entitas_model->set_md5_id_riwayat($ID_BARANG_ENTITAS, $ID_BARANG_MASTER, $LOKASI_SERVICE, $CREATE_BY_USER);

				//USER LOG
				$KETERANGAN = "Simpan Data Riwayat Perbaikan Entitas " . " - " . $ID_BARANG_MASTER . " - " . $ID_BARANG_ENTITAS . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI . " - " . $CREATE_BY_USER;
				$this->user_log($KETERANGAN);
				echo $hasil_2;
			}
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$user = $this->ion_auth->user()->row();
			// $this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_R_PERBAIKAN_B_E = $this->input->post('ID_R_PERBAIKAN_B_E');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');

				$data = $this->Riwayat_perbaikan_barang_entitas_model->update_data($ID_R_PERBAIKAN_B_E, $LOKASI_SERVICE, $KETERANGAN, $TANGGAL_MULAI_SERVICE_HARI, $TANGGAL_SELESAI_SERVICE_HARI);

				//USER LOG
				$KETERANGAN = "Ubah Data Riwayat Perbaikan Entitas " . " - " . $ID_R_PERBAIKAN_B_E . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI;
				$this->user_log($KETERANGAN);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

			$user = $this->ion_auth->user()->row();
			// $this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_R_PERBAIKAN_B_E = $this->input->post('ID_R_PERBAIKAN_B_E');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');

				$data = $this->Riwayat_perbaikan_barang_entitas_model->update_data($ID_R_PERBAIKAN_B_E, $LOKASI_SERVICE, $KETERANGAN, $TANGGAL_MULAI_SERVICE_HARI, $TANGGAL_SELESAI_SERVICE_HARI);

				//USER LOG
				$KETERANGAN = "Ubah Data Riwayat Perbaikan Entitas " . " - " . $ID_R_PERBAIKAN_B_E . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI;
				$this->user_log($KETERANGAN);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

			$user = $this->ion_auth->user()->row();
			// $this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_R_PERBAIKAN_B_E = $this->input->post('ID_R_PERBAIKAN_B_E');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');

				$data = $this->Riwayat_perbaikan_barang_entitas_model->update_data($ID_R_PERBAIKAN_B_E, $LOKASI_SERVICE, $KETERANGAN, $TANGGAL_MULAI_SERVICE_HARI, $TANGGAL_SELESAI_SERVICE_HARI);

				//USER LOG
				$KETERANGAN = "Ubah Data Riwayat Perbaikan Entitas " . " - " . $ID_R_PERBAIKAN_B_E . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI;
				$this->user_log($KETERANGAN);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_R_PERBAIKAN_B_E = $this->input->post('ID_R_PERBAIKAN_B_E');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');

				$data = $this->Riwayat_perbaikan_barang_entitas_model->update_data($ID_R_PERBAIKAN_B_E, $LOKASI_SERVICE, $KETERANGAN, $TANGGAL_MULAI_SERVICE_HARI, $TANGGAL_SELESAI_SERVICE_HARI);

				//USER LOG
				$KETERANGAN = "Ubah Data Riwayat Perbaikan Entitas " . " - " . $ID_R_PERBAIKAN_B_E . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI;
				$this->user_log($KETERANGAN);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_R_PERBAIKAN_B_E = $this->input->post('ID_R_PERBAIKAN_B_E');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');

				$data = $this->Riwayat_perbaikan_barang_entitas_model->update_data($ID_R_PERBAIKAN_B_E, $LOKASI_SERVICE, $KETERANGAN, $TANGGAL_MULAI_SERVICE_HARI, $TANGGAL_SELESAI_SERVICE_HARI);

				//USER LOG
				$KETERANGAN = "Ubah Data Riwayat Perbaikan Entitas " . " - " . $ID_R_PERBAIKAN_B_E . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI;
				$this->user_log($KETERANGAN);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {

			$user = $this->ion_auth->user()->row();
			// $this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_R_PERBAIKAN_B_E = $this->input->post('ID_R_PERBAIKAN_B_E');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');

				$data = $this->Riwayat_perbaikan_barang_entitas_model->update_data($ID_R_PERBAIKAN_B_E, $LOKASI_SERVICE, $KETERANGAN, $TANGGAL_MULAI_SERVICE_HARI, $TANGGAL_SELESAI_SERVICE_HARI);

				//USER LOG
				$KETERANGAN = "Ubah Data Riwayat Perbaikan Entitas " . " - " . $ID_R_PERBAIKAN_B_E . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI;
				$this->user_log($KETERANGAN);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

			$user = $this->ion_auth->user()->row();
			// $this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_R_PERBAIKAN_B_E = $this->input->post('ID_R_PERBAIKAN_B_E');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');

				$data = $this->Riwayat_perbaikan_barang_entitas_model->update_data($ID_R_PERBAIKAN_B_E, $LOKASI_SERVICE, $KETERANGAN, $TANGGAL_MULAI_SERVICE_HARI, $TANGGAL_SELESAI_SERVICE_HARI);

				//USER LOG
				$KETERANGAN = "Ubah Data Riwayat Perbaikan Entitas " . " - " . $ID_R_PERBAIKAN_B_E . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI;
				$this->user_log($KETERANGAN);
				echo ($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(42))) {

			$user = $this->ion_auth->user()->row();
			// $this->data['USER_ID'] = $user->id;

			//set validation rules
			$this->form_validation->set_rules('LOKASI_SERVICE', 'Lokasi Service', 'trim|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('TANGGAL_MULAI_SERVICE_HARI', 'Tanggal Mulai', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_SERVICE_HARI', 'Tanggal Selesai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_R_PERBAIKAN_B_E = $this->input->post('ID_R_PERBAIKAN_B_E');
				$LOKASI_SERVICE = $this->input->post('LOKASI_SERVICE');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$TANGGAL_MULAI_SERVICE_HARI = $this->input->post('TANGGAL_MULAI_SERVICE_HARI');
				$TANGGAL_SELESAI_SERVICE_HARI = $this->input->post('TANGGAL_SELESAI_SERVICE_HARI');

				$data = $this->Riwayat_perbaikan_barang_entitas_model->update_data($ID_R_PERBAIKAN_B_E, $LOKASI_SERVICE, $KETERANGAN, $TANGGAL_MULAI_SERVICE_HARI, $TANGGAL_SELESAI_SERVICE_HARI);

				//USER LOG
				$KETERANGAN = "Ubah Data Riwayat Perbaikan Entitas " . " - " . $ID_R_PERBAIKAN_B_E . " - " . $LOKASI_SERVICE . " - " . $KETERANGAN . " - " . $TANGGAL_MULAI_SERVICE_HARI . " - " . $TANGGAL_SELESAI_SERVICE_HARI;
				$this->user_log($KETERANGAN);
				echo ($data);
			}
		}  else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();
			$ID_R_PERBAIKAN_B_E = $this->input->post('kode');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);

			//USER LOG
			$KETERANGAN = "Hapus Riwayat Perbaikan Barang" . " - " . $data['NAMA'] . " - " . $data['KODE_BARANG_ENTITAS'] . " - " . $data['LOKASI_SERVICE'] . " - " . $data['KETERANGAN'] . " - " . $data['TANGGAL_MULAI_SERVICE_HARI'] . " - " . $data['TANGGAL_SELESAI_SERVICE_HARI'];
			$this->user_log($KETERANGAN);

			$data = $this->Riwayat_perbaikan_barang_entitas_model->hapus_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$user = $this->ion_auth->user()->row();
			$ID_R_PERBAIKAN_B_E = $this->input->post('kode');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);

			//USER LOG
			$KETERANGAN = "Hapus Riwayat Perbaikan Barang" . " - " . $data['NAMA'] . " - " . $data['KODE_BARANG_ENTITAS'] . " - " . $data['LOKASI_SERVICE'] . " - " . $data['KETERANGAN'] . " - " . $data['TANGGAL_MULAI_SERVICE_HARI'] . " - " . $data['TANGGAL_SELESAI_SERVICE_HARI'];
			$this->user_log($KETERANGAN);

			$data = $this->Riwayat_perbaikan_barang_entitas_model->hapus_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$user = $this->ion_auth->user()->row();
			$ID_R_PERBAIKAN_B_E = $this->input->post('kode');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);

			//USER LOG
			$KETERANGAN = "Hapus Riwayat Perbaikan Barang" . " - " . $data['NAMA'] . " - " . $data['KODE_BARANG_ENTITAS'] . " - " . $data['LOKASI_SERVICE'] . " - " . $data['KETERANGAN'] . " - " . $data['TANGGAL_MULAI_SERVICE_HARI'] . " - " . $data['TANGGAL_SELESAI_SERVICE_HARI'];
			$this->user_log($KETERANGAN);

			$data = $this->Riwayat_perbaikan_barang_entitas_model->hapus_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;

			$ID_R_PERBAIKAN_B_E = $this->input->post('kode');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);

			//USER LOG
			$KETERANGAN = "Hapus Riwayat Perbaikan Barang" . " - " . $data['NAMA'] . " - " . $data['KODE_BARANG_ENTITAS'] . " - " . $data['LOKASI_SERVICE'] . " - " . $data['KETERANGAN'] . " - " . $data['TANGGAL_MULAI_SERVICE_HARI'] . " - " . $data['TANGGAL_SELESAI_SERVICE_HARI'];
			$this->user_log($KETERANGAN);

			$data = $this->Riwayat_perbaikan_barang_entitas_model->hapus_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$user = $this->ion_auth->user()->row();
			$this->data['USER_ID'] = $user->id;
			
			$ID_R_PERBAIKAN_B_E = $this->input->post('kode');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);

			//USER LOG
			$KETERANGAN = "Hapus Riwayat Perbaikan Barang" . " - " . $data['NAMA'] . " - " . $data['KODE_BARANG_ENTITAS'] . " - " . $data['LOKASI_SERVICE'] . " - " . $data['KETERANGAN'] . " - " . $data['TANGGAL_MULAI_SERVICE_HARI'] . " - " . $data['TANGGAL_SELESAI_SERVICE_HARI'];
			$this->user_log($KETERANGAN);

			$data = $this->Riwayat_perbaikan_barang_entitas_model->hapus_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$user = $this->ion_auth->user()->row();
			$ID_R_PERBAIKAN_B_E = $this->input->post('kode');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);

			//USER LOG
			$KETERANGAN = "Hapus Riwayat Perbaikan Barang" . " - " . $data['NAMA'] . " - " . $data['KODE_BARANG_ENTITAS'] . " - " . $data['LOKASI_SERVICE'] . " - " . $data['KETERANGAN'] . " - " . $data['TANGGAL_MULAI_SERVICE_HARI'] . " - " . $data['TANGGAL_SELESAI_SERVICE_HARI'];
			$this->user_log($KETERANGAN);

			$data = $this->Riwayat_perbaikan_barang_entitas_model->hapus_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$user = $this->ion_auth->user()->row();
			$ID_R_PERBAIKAN_B_E = $this->input->post('kode');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);

			//USER LOG
			$KETERANGAN = "Hapus Riwayat Perbaikan Barang" . " - " . $data['NAMA'] . " - " . $data['KODE_BARANG_ENTITAS'] . " - " . $data['LOKASI_SERVICE'] . " - " . $data['KETERANGAN'] . " - " . $data['TANGGAL_MULAI_SERVICE_HARI'] . " - " . $data['TANGGAL_SELESAI_SERVICE_HARI'];
			$this->user_log($KETERANGAN);

			$data = $this->Riwayat_perbaikan_barang_entitas_model->hapus_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$user = $this->ion_auth->user()->row();
			$ID_R_PERBAIKAN_B_E = $this->input->post('kode');
			$data = $this->Riwayat_perbaikan_barang_entitas_model->get_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);

			//USER LOG
			$KETERANGAN = "Hapus Riwayat Perbaikan Barang" . " - " . $data['NAMA'] . " - " . $data['KODE_BARANG_ENTITAS'] . " - " . $data['LOKASI_SERVICE'] . " - " . $data['KETERANGAN'] . " - " . $data['TANGGAL_MULAI_SERVICE_HARI'] . " - " . $data['TANGGAL_SELESAI_SERVICE_HARI'];
			$this->user_log($KETERANGAN);

			$data = $this->Riwayat_perbaikan_barang_entitas_model->hapus_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E);
			echo json_encode($data);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
}
