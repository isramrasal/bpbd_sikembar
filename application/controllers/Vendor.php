<?php defined('BASEPATH') or exit('No direct script access allowed');

class Vendor extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->library('session');
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Vendor';

		$this->load->model('Vendor_model');
		$this->load->model('Foto_model');
		$this->load->model('Vendor_file_model');
		$this->load->model('Manajemen_user_model');
		//$this->load->model('ws_pegawai_model');
		date_default_timezone_set('Asia/Jakarta');

		$this->data['left_menu'] = "vendor_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Vendor";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Vendor_model->user_log_vendor($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Vendor_model->user_log_vendor($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_vendor');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_vendor');
			$this->load->view('wasa/user_staff_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_vendor');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_vendor');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_vendor');
			$this->load->view('wasa/user_staff_procurement_sp/footer');
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_vendor');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_vendor()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$data = $this->Vendor_model->vendor_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Melihat Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$data = $this->Vendor_model->vendor_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Melihat Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$data = $this->Vendor_model->vendor_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Melihat Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$data = $this->Vendor_model->vendor_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Melihat Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$data = $this->Vendor_model->vendor_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Melihat Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
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

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Vendor_model->get_data_by_id_vendor($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$id = $this->input->get('id');
			$data = $this->Vendor_model->get_data_by_id_vendor($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$id = $this->input->get('id');
			$data = $this->Vendor_model->get_data_by_id_vendor($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$id = $this->input->get('id');
			$data = $this->Vendor_model->get_data_by_id_vendor($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$id = $this->input->get('id');
			$data = $this->Vendor_model->get_data_by_id_vendor($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$id = $this->input->get('id');
			$data = $this->Vendor_model->get_data_by_id_vendor($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Vendor: " . json_encode($data);
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
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$user = $this->ion_auth->user()->row();
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$user = $this->ion_auth->user()->row();
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$user = $this->ion_auth->user()->row();
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$user = $this->ion_auth->user()->row();
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$user = $this->ion_auth->user()->row();
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function generate_password()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$user = $this->ion_auth->user()->row();
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$user = $this->ion_auth->user()->row();
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			$USERNAME = $this->input->post('USERNAME');
			$password = md5($USERNAME);

			echo json_encode($password);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$user = $this->ion_auth->user()->row();
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$user = $this->ion_auth->user()->row();
			$ID_VENDOR = $this->input->post('kode');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);

			//log
			$KETERANGAN = "Hapus Data Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);

			$data = $this->Vendor_model->hapus_data_by_id_vendor($ID_VENDOR);
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
			$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
				$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$STATUS_VENDOR = $this->input->post('STATUS_VENDOR');

				//check apakah nama vendor sudah ada. jika belum ada, akan disimpan.
				if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->simpan_data_by_admin($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR, $STATUS_VENDOR);

					$this->Vendor_model->set_md5_id_vendor($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR);
				} else {
					echo 'Nama vendor sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
				$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$STATUS_VENDOR = $this->input->post('STATUS_VENDOR');

				//check apakah nama vendor sudah ada. jika belum ada, akan disimpan.
				if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->simpan_data_by_admin($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR, $STATUS_VENDOR);

					$this->Vendor_model->set_md5_id_vendor($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR);
				} else {
					echo 'Nama vendor sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
				$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$STATUS_VENDOR = $this->input->post('STATUS_VENDOR');

				//check apakah nama vendor sudah ada. jika belum ada, akan disimpan.
				if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->simpan_data_by_admin($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR, $STATUS_VENDOR);

					$this->Vendor_model->set_md5_id_vendor($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR);
				} else {
					echo 'Nama vendor sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR', 'Status', 'trim|required');
			// $tables = $this->config->item('tables', 'ion_auth');
			// $this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]|is_unique[' . $tables['users'] . '.username]');
			// $this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'trim|required|max_length[255]');
			// $this->form_validation->set_rules('EXPIRED', 'Tanggal Expired Access', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
				$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$STATUS_VENDOR = $this->input->post('STATUS_VENDOR');
				// $USERNAME = $this->input->post('USERNAME');
				// $PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');
				// $EXPIRED = $this->input->post('EXPIRED');

				//check apakah nama vendor sudah ada. jika belum ada, akan disimpan.
				if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {

					// if ($this->Vendor_model->cek_username_users($USERNAME) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->simpan_data_by_admin($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR, $STATUS_VENDOR);

					$this->Vendor_model->set_md5_id_vendor($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR);

					// $data = $this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR);
					// $this->data['ID_VENDOR'] = $data['ID_VENDOR'];
					// $ID_VENDOR = $this->data['ID_VENDOR'];
					// $EXPIRED_KIRIM = $EXPIRED;
					// $date = date_create($EXPIRED);
					// $EXPIRED = date_timestamp_get($date);

					// $STATUS_DATA_PEGAWAI = 'vendor';
					// $CREATED_ON =  time();
					// $EMAIL = $EMAIL_VENDOR;
					// $PASSWORD_KIRIM = $PASSWORD_UTAMA;
					// $PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);
					// $this->Vendor_model->register_users($USERNAME, $PASSWORD_UTAMA, $EMAIL, $CREATED_ON, $EXPIRED, $ID_VENDOR, $STATUS_DATA_PEGAWAI);


					// $hsl_2 = $this->db->query("SELECT id from users WHERE ID_VENDOR ='$ID_VENDOR' AND username ='$USERNAME' ");
					// if ($hsl_2->num_rows() > 0) {
					// 	foreach ($hsl_2->result() as $data) {
					// 		$hasil = array(
					// 			'id' => $data->id
					// 		);
					// 	}
					// }
					// $ID_USER = $hasil['id'];

					// $data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '38')");

					// //Load email library
					// $this->load->library('email');

					// //SMTP & mail configuration
					// // $config = array(
					// // 	'protocol'  => 'smtp',
					// // 	'smtp_host' => 'ssl://smtp.gmail.com',
					// // 	'smtp_port' => 465,
					// // 	'smtp_user' => 'userforkindo@gmail.com',
					// // 	'smtp_pass' => 'Andasiapa21_',
					// // 	'mailtype' => 'html',
					// // 	'charset' => 'utf-8'
					// // );

					// $config = array(
					// 	'protocol'  => 'smtp',
					// 	'smtp_host' => 'mail.wasamitra.co.id',
					// 	'smtp_port' => 25,
					// 	'smtp_user' => 'notifikasi@wasamitra.co.id',
					// 	'smtp_pass' => 'Eam.wme2022',
					// 	'smtp_timeout' => '10',
					// 	'mailtype' => 'html',
					// 	'charset' => 'utf-8'
					// );
					// $this->email->initialize($config);
					// $this->email->set_mailtype("html");
					// $this->email->set_newline("\r\n");

					// //Email content
					// $htmlContent = '<p>Kepada Yth.</p>
					// 	<p>' . $NAMA_VENDOR . ',</p>
					// 	<p>&nbsp;</p>
					// 	<p>Berikut adalah Credential untuk mengakses aplikasi SIPESUT:</p>
					// 	<p>Username: ' . $USERNAME . '</p>
					// 	<p>Password: ' . $PASSWORD_KIRIM . '</p>
					// 	<p>Masa Berlaku Credential: ' . $EXPIRED_KIRIM . '</p>
					// 	<p>&nbsp;</p>
					// 	<p>Aplikasi SIPESUT bisa diakses melalui link: isi_alamat_link</p>
					// 	<p>Dengan menerima email ini, pihak Vendor <strong>wajib</strong> menjaga kerahasiaan. Terima kasih.</p>';

					// $this->email->to($EMAIL);
					// $this->email->cc($EMAIL_PIC_VENDOR);
					// $this->email->from('notifikasi@wasamitra.co.id', 'Departemen Pengadaan dan Logistik PT WME');
					// $judul = 'WME | Pendaftaran Akun Vendor ';
					// $this->email->subject($judul);
					// $this->email->message($htmlContent);

					// //Send email
					// if ($this->email->send()) {
					// 	echo 'Email Terkirim ke Vendor';
					// } else {
					// 	show_error($this->email->print_debugger());
					// 	echo show_error($this->email->print_debugger());
					// }
					// } else {
					// 	echo 'Nama username sudah terekam sebelumnya';
					// }
				} else {
					echo 'Nama vendor sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
				$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$STATUS_VENDOR = $this->input->post('STATUS_VENDOR');

				//check apakah nama vendor sudah ada. jika belum ada, akan disimpan.
				if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->simpan_data_by_admin($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR, $STATUS_VENDOR);

					$this->Vendor_model->set_md5_id_vendor($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR);
				} else {
					echo 'Nama vendor sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_VENDOR', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_VENDOR', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_VENDOR = $this->input->post('NAMA_VENDOR');
				$ALAMAT_VENDOR = $this->input->post('ALAMAT_VENDOR');
				$NO_TELP_VENDOR = $this->input->post('NO_TELP_VENDOR');
				$NAMA_PIC_VENDOR = $this->input->post('NAMA_PIC_VENDOR');
				$NO_HP_PIC_VENDOR = $this->input->post('NO_HP_PIC_VENDOR');
				$EMAIL_PIC_VENDOR = $this->input->post('EMAIL_PIC_VENDOR');
				$EMAIL_VENDOR = $this->input->post('EMAIL_VENDOR');
				$STATUS_VENDOR = $this->input->post('STATUS_VENDOR');

				//check apakah nama vendor sudah ada. jika belum ada, akan disimpan.
				if ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan vendor " . $NAMA_VENDOR;
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->simpan_data_by_admin($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR, $STATUS_VENDOR);

					$this->Vendor_model->set_md5_id_vendor($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR);
				} else {
					echo 'Nama vendor sudah terekam sebelumnya';
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
			$this->form_validation->set_rules('NAMA_VENDOR2', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR2', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR2', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR2', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR2', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR2', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('EMAIL_VENDOR2', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR2', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_VENDOR2 = $this->input->post('ID_VENDOR2');
				$NAMA_VENDOR2 = $this->input->post('NAMA_VENDOR2');
				$ALAMAT_VENDOR2 = $this->input->post('ALAMAT_VENDOR2');
				$NO_TELP_VENDOR2 = $this->input->post('NO_TELP_VENDOR2');
				$NAMA_PIC_VENDOR2 = $this->input->post('NAMA_PIC_VENDOR2');
				$NO_HP_PIC_VENDOR2 = $this->input->post('NO_HP_PIC_VENDOR2');
				$EMAIL_PIC_VENDOR2 = $this->input->post('EMAIL_PIC_VENDOR2');
				$EMAIL_VENDOR2 = $this->input->post('EMAIL_VENDOR2');
				$STATUS_VENDOR2 = $this->input->post('STATUS_VENDOR2');
				//cek apakah input sama dengan eksisting
				$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

				if ($data['NAMA_VENDOR'] == $NAMA_VENDOR2 || ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR2) == 'Data belum ada')) {
					$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

					$KETERANGAN = "Ubah Data Vendor: " . json_encode($data) . " ---- " . $NAMA_VENDOR2 . ";" . $ALAMAT_VENDOR2 . ";" . $NO_TELP_VENDOR2  . ";" . $NAMA_PIC_VENDOR2 . ";" . $NO_HP_PIC_VENDOR2 . ";" . $EMAIL_PIC_VENDOR2 . ";" . $EMAIL_VENDOR2 . ";" . $STATUS_VENDOR2 . ";";
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->update_data($ID_VENDOR2, $NAMA_VENDOR2, $ALAMAT_VENDOR2, $NO_TELP_VENDOR2, $NAMA_PIC_VENDOR2, $NO_HP_PIC_VENDOR2, $EMAIL_PIC_VENDOR2, $EMAIL_VENDOR2, $STATUS_VENDOR2);
					//echo "waduh";
					echo json_encode($data);
				} else {
					echo json_encode('Nama vendor sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_VENDOR2', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR2', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR2', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR2', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR2', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR2', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('EMAIL_VENDOR2', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR2', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_VENDOR2 = $this->input->post('ID_VENDOR2');
				$NAMA_VENDOR2 = $this->input->post('NAMA_VENDOR2');
				$ALAMAT_VENDOR2 = $this->input->post('ALAMAT_VENDOR2');
				$NO_TELP_VENDOR2 = $this->input->post('NO_TELP_VENDOR2');
				$NAMA_PIC_VENDOR2 = $this->input->post('NAMA_PIC_VENDOR2');
				$NO_HP_PIC_VENDOR2 = $this->input->post('NO_HP_PIC_VENDOR2');
				$EMAIL_PIC_VENDOR2 = $this->input->post('EMAIL_PIC_VENDOR2');
				$EMAIL_VENDOR2 = $this->input->post('EMAIL_VENDOR2');
				$STATUS_VENDOR2 = $this->input->post('STATUS_VENDOR2');
				//cek apakah input sama dengan eksisting
				$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

				if ($data['NAMA_VENDOR'] == $NAMA_VENDOR2 || ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR2) == 'Data belum ada')) {
					$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

					$KETERANGAN = "Ubah Data Vendor: " . json_encode($data) . " ---- " . $NAMA_VENDOR2 . ";" . $ALAMAT_VENDOR2 . ";" . $NO_TELP_VENDOR2  . ";" . $NAMA_PIC_VENDOR2 . ";" . $NO_HP_PIC_VENDOR2 . ";" . $EMAIL_PIC_VENDOR2 . ";" . $EMAIL_VENDOR2 . ";" . $STATUS_VENDOR2 . ";";
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->update_data($ID_VENDOR2, $NAMA_VENDOR2, $ALAMAT_VENDOR2, $NO_TELP_VENDOR2, $NAMA_PIC_VENDOR2, $NO_HP_PIC_VENDOR2, $EMAIL_PIC_VENDOR2, $EMAIL_VENDOR2, $STATUS_VENDOR2);
					//echo "waduh";
					echo json_encode($data);
				} else {
					echo json_encode('Nama vendor sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_VENDOR2', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR2', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR2', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR2', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR2', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR2', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('EMAIL_VENDOR2', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR2', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_VENDOR2 = $this->input->post('ID_VENDOR2');
				$NAMA_VENDOR2 = $this->input->post('NAMA_VENDOR2');
				$ALAMAT_VENDOR2 = $this->input->post('ALAMAT_VENDOR2');
				$NO_TELP_VENDOR2 = $this->input->post('NO_TELP_VENDOR2');
				$NAMA_PIC_VENDOR2 = $this->input->post('NAMA_PIC_VENDOR2');
				$NO_HP_PIC_VENDOR2 = $this->input->post('NO_HP_PIC_VENDOR2');
				$EMAIL_PIC_VENDOR2 = $this->input->post('EMAIL_PIC_VENDOR2');
				$EMAIL_VENDOR2 = $this->input->post('EMAIL_VENDOR2');
				$STATUS_VENDOR2 = $this->input->post('STATUS_VENDOR2');
				//cek apakah input sama dengan eksisting
				$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

				if ($data['NAMA_VENDOR'] == $NAMA_VENDOR2 || ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR2) == 'Data belum ada')) {
					$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

					$KETERANGAN = "Ubah Data Vendor: " . json_encode($data) . " ---- " . $NAMA_VENDOR2 . ";" . $ALAMAT_VENDOR2 . ";" . $NO_TELP_VENDOR2  . ";" . $NAMA_PIC_VENDOR2 . ";" . $NO_HP_PIC_VENDOR2 . ";" . $EMAIL_PIC_VENDOR2 . ";" . $EMAIL_VENDOR2 . ";" . $STATUS_VENDOR2 . ";";
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->update_data($ID_VENDOR2, $NAMA_VENDOR2, $ALAMAT_VENDOR2, $NO_TELP_VENDOR2, $NAMA_PIC_VENDOR2, $NO_HP_PIC_VENDOR2, $EMAIL_PIC_VENDOR2, $EMAIL_VENDOR2, $STATUS_VENDOR2);
					//echo "waduh";
					echo json_encode($data);
				} else {
					echo json_encode('Nama vendor sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_VENDOR2', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR2', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR2', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR2', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR2', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR2', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('EMAIL_VENDOR2', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR2', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_VENDOR2 = $this->input->post('ID_VENDOR2');
				$NAMA_VENDOR2 = $this->input->post('NAMA_VENDOR2');
				$ALAMAT_VENDOR2 = $this->input->post('ALAMAT_VENDOR2');
				$NO_TELP_VENDOR2 = $this->input->post('NO_TELP_VENDOR2');
				$NAMA_PIC_VENDOR2 = $this->input->post('NAMA_PIC_VENDOR2');
				$NO_HP_PIC_VENDOR2 = $this->input->post('NO_HP_PIC_VENDOR2');
				$EMAIL_PIC_VENDOR2 = $this->input->post('EMAIL_PIC_VENDOR2');
				$EMAIL_VENDOR2 = $this->input->post('EMAIL_VENDOR2');
				$STATUS_VENDOR2 = $this->input->post('STATUS_VENDOR2');
				//cek apakah input sama dengan eksisting
				$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

				if ($data['NAMA_VENDOR'] == $NAMA_VENDOR2 || ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR2) == 'Data belum ada')) {
					$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

					$KETERANGAN = "Ubah Data Vendor: " . json_encode($data) . " ---- " . $NAMA_VENDOR2 . ";" . $ALAMAT_VENDOR2 . ";" . $NO_TELP_VENDOR2  . ";" . $NAMA_PIC_VENDOR2 . ";" . $NO_HP_PIC_VENDOR2 . ";" . $EMAIL_PIC_VENDOR2 . ";" . $EMAIL_VENDOR2 . ";" . $STATUS_VENDOR2 . ";";
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->update_data($ID_VENDOR2, $NAMA_VENDOR2, $ALAMAT_VENDOR2, $NO_TELP_VENDOR2, $NAMA_PIC_VENDOR2, $NO_HP_PIC_VENDOR2, $EMAIL_PIC_VENDOR2, $EMAIL_VENDOR2, $STATUS_VENDOR2);
					//echo "waduh";
					echo json_encode($data);
				} else {
					echo json_encode('Nama vendor sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_VENDOR2', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR2', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR2', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR2', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR2', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR2', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('EMAIL_VENDOR2', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR2', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_VENDOR2 = $this->input->post('ID_VENDOR2');
				$NAMA_VENDOR2 = $this->input->post('NAMA_VENDOR2');
				$ALAMAT_VENDOR2 = $this->input->post('ALAMAT_VENDOR2');
				$NO_TELP_VENDOR2 = $this->input->post('NO_TELP_VENDOR2');
				$NAMA_PIC_VENDOR2 = $this->input->post('NAMA_PIC_VENDOR2');
				$NO_HP_PIC_VENDOR2 = $this->input->post('NO_HP_PIC_VENDOR2');
				$EMAIL_PIC_VENDOR2 = $this->input->post('EMAIL_PIC_VENDOR2');
				$EMAIL_VENDOR2 = $this->input->post('EMAIL_VENDOR2');
				$STATUS_VENDOR2 = $this->input->post('STATUS_VENDOR2');
				//cek apakah input sama dengan eksisting
				$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

				if ($data['NAMA_VENDOR'] == $NAMA_VENDOR2 || ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR2) == 'Data belum ada')) {
					$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

					$KETERANGAN = "Ubah Data Vendor: " . json_encode($data) . " ---- " . $NAMA_VENDOR2 . ";" . $ALAMAT_VENDOR2 . ";" . $NO_TELP_VENDOR2  . ";" . $NAMA_PIC_VENDOR2 . ";" . $NO_HP_PIC_VENDOR2 . ";" . $EMAIL_PIC_VENDOR2 . ";" . $EMAIL_VENDOR2 . ";" . $STATUS_VENDOR2 . ";";
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->update_data($ID_VENDOR2, $NAMA_VENDOR2, $ALAMAT_VENDOR2, $NO_TELP_VENDOR2, $NAMA_PIC_VENDOR2, $NO_HP_PIC_VENDOR2, $EMAIL_PIC_VENDOR2, $EMAIL_VENDOR2, $STATUS_VENDOR2);
					//echo "waduh";
					echo json_encode($data);
				} else {
					echo json_encode('Nama vendor sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_VENDOR2', 'Nama Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('ALAMAT_VENDOR2', 'Alamat', 'trim|required');
			$this->form_validation->set_rules('NO_TELP_VENDOR2', 'No Telp Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('NAMA_PIC_VENDOR2', 'Nama PIC Vendor', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('NO_HP_PIC_VENDOR2', 'No HP PIC Vendor', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('EMAIL_PIC_VENDOR2', 'Email PIC Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('EMAIL_VENDOR2', 'Email Vendor', 'trim|required|valid_email');
			$this->form_validation->set_rules('STATUS_VENDOR2', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_VENDOR2 = $this->input->post('ID_VENDOR2');
				$NAMA_VENDOR2 = $this->input->post('NAMA_VENDOR2');
				$ALAMAT_VENDOR2 = $this->input->post('ALAMAT_VENDOR2');
				$NO_TELP_VENDOR2 = $this->input->post('NO_TELP_VENDOR2');
				$NAMA_PIC_VENDOR2 = $this->input->post('NAMA_PIC_VENDOR2');
				$NO_HP_PIC_VENDOR2 = $this->input->post('NO_HP_PIC_VENDOR2');
				$EMAIL_PIC_VENDOR2 = $this->input->post('EMAIL_PIC_VENDOR2');
				$EMAIL_VENDOR2 = $this->input->post('EMAIL_VENDOR2');
				$STATUS_VENDOR2 = $this->input->post('STATUS_VENDOR2');
				//cek apakah input sama dengan eksisting
				$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

				if ($data['NAMA_VENDOR'] == $NAMA_VENDOR2 || ($this->Vendor_model->cek_nama_vendor_by_admin($NAMA_VENDOR2) == 'Data belum ada')) {
					$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR2);

					$KETERANGAN = "Ubah Data Vendor: " . json_encode($data) . " ---- " . $NAMA_VENDOR2 . ";" . $ALAMAT_VENDOR2 . ";" . $NO_TELP_VENDOR2  . ";" . $NAMA_PIC_VENDOR2 . ";" . $NO_HP_PIC_VENDOR2 . ";" . $EMAIL_PIC_VENDOR2 . ";" . $EMAIL_VENDOR2 . ";" . $STATUS_VENDOR2 . ";";
					$this->user_log($KETERANGAN);

					$data = $this->Vendor_model->update_data($ID_VENDOR2, $NAMA_VENDOR2, $ALAMAT_VENDOR2, $NO_TELP_VENDOR2, $NAMA_PIC_VENDOR2, $NO_HP_PIC_VENDOR2, $EMAIL_PIC_VENDOR2, $EMAIL_VENDOR2, $STATUS_VENDOR2);
					//echo "waduh";
					echo json_encode($data);
				} else {
					echo json_encode('Nama vendor sudah terekam sebelumnya');
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

	public function profil_vendor()
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

		// $query_jabatan_departemen = $this->ws_pegawai_model->get_data_by_id_cont_nip($user->ID_PEGAWAI);
		// $this->data['nama'] = $query_jabatan_departemen['NAMA'];
		// $this->data['nama_status_pegawai'] = $query_jabatan_departemen['NAMA_STATUS_VENDOR_PEGAWAI'];
		// $this->data['jabatan'] = $query_jabatan_departemen['NAMA_JABATAN'];
		// $this->data['departemen'] = $query_jabatan_departemen['NAMA_DEPARTEMEN'];

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$this->data['HASH_MD5_VENDOR'] = $this->uri->segment(3);
			$sess_data['HASH_MD5_VENDOR'] = $this->data['HASH_MD5_VENDOR'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel vendor
			$query_vendor_HASH_MD5_VENDOR = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			$query_vendor_HASH_MD5_VENDOR_result = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);
			$this->data['query_vendor_HASH_MD5_VENDOR_result'] = $query_vendor_HASH_MD5_VENDOR_result;

			//Kueri data di tabel vendor file
			$query_file_HASH_MD5_VENDOR = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			if ($query_vendor_HASH_MD5_VENDOR->num_rows() > 0) {
				if ($query_file_HASH_MD5_VENDOR->num_rows() > 0) {

					$this->data['dokumen'] = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);

					$hasil = $query_file_HASH_MD5_VENDOR->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

					if (file_exists($file = './assets/upload_vendor_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['FILE'] = "ADA";
					} else {	//file terhapus di server
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_admin/head_normal', $this->data);
				$this->load->view('wasa/user_admin/user_menu');
				$this->load->view('wasa/user_admin/left_menu');
				$this->load->view('wasa/user_admin/header_menu');
				$this->load->view('wasa/user_admin/content_vendor_file');
			} else {
				// alihkan mereka ke halaman login
				redirect('vendor', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$this->data['HASH_MD5_VENDOR'] = $this->uri->segment(3);
			$sess_data['HASH_MD5_VENDOR'] = $this->data['HASH_MD5_VENDOR'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel vendor
			$query_vendor_HASH_MD5_VENDOR = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			$query_vendor_HASH_MD5_VENDOR_result = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);
			$this->data['query_vendor_HASH_MD5_VENDOR_result'] = $query_vendor_HASH_MD5_VENDOR_result;

			//Kueri data di tabel vendor file
			$query_file_HASH_MD5_VENDOR = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			if ($query_vendor_HASH_MD5_VENDOR->num_rows() > 0) {
				if ($query_file_HASH_MD5_VENDOR->num_rows() > 0) {

					$this->data['dokumen'] = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);

					$hasil = $query_file_HASH_MD5_VENDOR->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

					if (file_exists($file = './assets/upload_vendor_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['FILE'] = "ADA";
					} else {	//file terhapus di server
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_vendor_file');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$this->data['HASH_MD5_VENDOR'] = $this->uri->segment(3);
			$sess_data['HASH_MD5_VENDOR'] = $this->data['HASH_MD5_VENDOR'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel vendor
			$query_vendor_HASH_MD5_VENDOR = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			$query_vendor_HASH_MD5_VENDOR_result = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);
			$this->data['query_vendor_HASH_MD5_VENDOR_result'] = $query_vendor_HASH_MD5_VENDOR_result;

			//Kueri data di tabel vendor file
			$query_file_HASH_MD5_VENDOR = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			if ($query_vendor_HASH_MD5_VENDOR->num_rows() > 0) {
				if ($query_file_HASH_MD5_VENDOR->num_rows() > 0) {

					$this->data['dokumen'] = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);

					$hasil = $query_file_HASH_MD5_VENDOR->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

					if (file_exists($file = './assets/upload_vendor_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['FILE'] = "ADA";
					} else {	//file terhapus di server
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_vendor_file');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$this->data['HASH_MD5_VENDOR'] = $this->uri->segment(3);
			$sess_data['HASH_MD5_VENDOR'] = $this->data['HASH_MD5_VENDOR'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel vendor
			$query_vendor_HASH_MD5_VENDOR = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			$query_vendor_HASH_MD5_VENDOR_result = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);
			$this->data['query_vendor_HASH_MD5_VENDOR_result'] = $query_vendor_HASH_MD5_VENDOR_result;

			//Kueri data di tabel vendor file
			$query_file_HASH_MD5_VENDOR = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			if ($query_vendor_HASH_MD5_VENDOR->num_rows() > 0) {
				if ($query_file_HASH_MD5_VENDOR->num_rows() > 0) {

					$this->data['dokumen'] = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);

					$hasil = $query_file_HASH_MD5_VENDOR->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

					if (file_exists($file = './assets/upload_vendor_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['FILE'] = "ADA";
					} else {	//file terhapus di server
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_vendor_file');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$this->data['HASH_MD5_VENDOR'] = $this->uri->segment(3);
			$sess_data['HASH_MD5_VENDOR'] = $this->data['HASH_MD5_VENDOR'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel vendor
			$query_vendor_HASH_MD5_VENDOR = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			$query_vendor_HASH_MD5_VENDOR_result = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);
			$this->data['query_vendor_HASH_MD5_VENDOR_result'] = $query_vendor_HASH_MD5_VENDOR_result;

			//Kueri data di tabel vendor file
			$query_file_HASH_MD5_VENDOR = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			if ($query_vendor_HASH_MD5_VENDOR->num_rows() > 0) {
				if ($query_file_HASH_MD5_VENDOR->num_rows() > 0) {

					$this->data['dokumen'] = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);

					$hasil = $query_file_HASH_MD5_VENDOR->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

					if (file_exists($file = './assets/upload_vendor_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['FILE'] = "ADA";
					} else {	//file terhapus di server
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_vendor_file');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$this->data['HASH_MD5_VENDOR'] = $this->uri->segment(3);
			$sess_data['HASH_MD5_VENDOR'] = $this->data['HASH_MD5_VENDOR'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel vendor
			$query_vendor_HASH_MD5_VENDOR = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			$query_vendor_HASH_MD5_VENDOR_result = $this->Vendor_model->vendor_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);
			$this->data['query_vendor_HASH_MD5_VENDOR_result'] = $query_vendor_HASH_MD5_VENDOR_result;

			//Kueri data di tabel vendor file
			$query_file_HASH_MD5_VENDOR = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR($sess_data['HASH_MD5_VENDOR']);

			if ($query_vendor_HASH_MD5_VENDOR->num_rows() > 0) {
				if ($query_file_HASH_MD5_VENDOR->num_rows() > 0) {

					$this->data['dokumen'] = $this->Vendor_file_model->file_list_by_HASH_MD5_VENDOR_result($sess_data['HASH_MD5_VENDOR']);

					$hasil = $query_file_HASH_MD5_VENDOR->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

					if (file_exists($file = './assets/upload_vendor_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['FILE'] = "ADA";
					} else {	//file terhapus di server
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_vendor_file');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			}
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	//Untuk proses upload file
	function proses_upload_file()
	{

		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		$HASH_MD5_VENDOR = $this->session->userdata('HASH_MD5_VENDOR');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_VENDOR . '_';
			$config['upload_path']   = './assets/upload_vendor_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_vendor = $this->Vendor_model->get_id_vendor_by_HASH_MD5_VENDOR($HASH_MD5_VENDOR);
			$ID_VENDOR = $query_id_vendor['ID_VENDOR'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');
				$KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

				$KETERANGAN = './assets/upload_vendor_file/' . $nama;
				$this->db->insert('vendor_file', array('ID_VENDOR' => $ID_VENDOR, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_VENDOR' => $HASH_MD5_VENDOR, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
			} else {
				// set the flash data error message if there is one
				// $this->ion_auth->logout();
				// $this->session->set_flashdata('message', $this->display->display_errors());
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_VENDOR . '_';
			$config['upload_path']   = './assets/upload_vendor_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_vendor = $this->Vendor_model->get_id_vendor_by_HASH_MD5_VENDOR($HASH_MD5_VENDOR);
			$ID_VENDOR = $query_id_vendor['ID_VENDOR'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');
				$KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

				$KETERANGAN = './assets/upload_vendor_file/' . $nama;
				$this->db->insert('vendor_file', array('ID_VENDOR' => $ID_VENDOR, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_VENDOR' => $HASH_MD5_VENDOR, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
			} else {
				// set the flash data error message if there is one
				// $this->ion_auth->logout();
				// $this->session->set_flashdata('message', $this->display->display_errors());
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_VENDOR . '_';
			$config['upload_path']   = './assets/upload_vendor_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_vendor = $this->Vendor_model->get_id_vendor_by_HASH_MD5_VENDOR($HASH_MD5_VENDOR);
			$ID_VENDOR = $query_id_vendor['ID_VENDOR'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');
				$KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

				$KETERANGAN = './assets/upload_vendor_file/' . $nama;
				$this->db->insert('vendor_file', array('ID_VENDOR' => $ID_VENDOR, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_VENDOR' => $HASH_MD5_VENDOR, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
			} else {
				// set the flash data error message if there is one
				// $this->ion_auth->logout();
				// $this->session->set_flashdata('message', $this->display->display_errors());
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "vendor_" . $HASH_MD5_VENDOR;
			$config['upload_path']   = './assets/upload_vendor_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_vendor = $this->Vendor_model->get_id_vendor_by_HASH_MD5_VENDOR($HASH_MD5_VENDOR);
			$ID_VENDOR = $query_id_vendor['ID_VENDOR'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');
				$KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

				$KETERANGAN = './assets/upload_vendor_file/' . $nama;
				$this->db->insert('vendor_file', array('ID_VENDOR' => $ID_VENDOR, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_VENDOR' => $HASH_MD5_VENDOR, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
			} else {
				// set the flash data error message if there is one
				// $this->ion_auth->logout();
				// $this->session->set_flashdata('message', $this->display->display_errors());
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_VENDOR . '_';
			$config['upload_path']   = './assets/upload_vendor_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_vendor = $this->Vendor_model->get_id_vendor_by_HASH_MD5_VENDOR($HASH_MD5_VENDOR);
			$ID_VENDOR = $query_id_vendor['ID_VENDOR'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');
				$KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

				$KETERANGAN = './assets/upload_vendor_file/' . $nama;
				$this->db->insert('vendor_file', array('ID_VENDOR' => $ID_VENDOR, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_VENDOR' => $HASH_MD5_VENDOR, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
			} else {
				// set the flash data error message if there is one
				// $this->ion_auth->logout();
				// $this->session->set_flashdata('message', $this->display->display_errors());
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_VENDOR . '_';
			$config['upload_path']   = './assets/upload_vendor_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_vendor = $this->Vendor_model->get_id_vendor_by_HASH_MD5_VENDOR($HASH_MD5_VENDOR);
			$ID_VENDOR = $query_id_vendor['ID_VENDOR'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');
				$KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

				$KETERANGAN = './assets/upload_vendor_file/' . $nama;
				$this->db->insert('vendor_file', array('ID_VENDOR' => $ID_VENDOR, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_VENDOR' => $HASH_MD5_VENDOR, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
			} else {
				// set the flash data error message if there is one
				// $this->ion_auth->logout();
				// $this->session->set_flashdata('message', $this->display->display_errors());
			}
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
			$query_DOK_FILE = $this->Vendor_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_vendor_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Vendor_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_VENDOR = $this->session->userdata('HASH_MD5_VENDOR');
				redirect('/vendor/profil_vendor/' . $HASH_MD5_VENDOR, 'refresh');
			} else {
				$HASH_MD5_VENDOR = $this->session->userdata('HASH_MD5_VENDOR');
				redirect('/vendor/profil_vendor/' . $HASH_MD5_VENDOR, 'refresh');
			}
		}
		// else if ($this->ion_auth->logged_in() && $this->ion_auth->groups(3))
		// {				


		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
}
