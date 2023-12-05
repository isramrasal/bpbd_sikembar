<?php defined('BASEPATH') or exit('No direct script access allowed');

class TOP extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Term of Payment';

		$this->load->model('Term_Of_Payment_model');
		$this->load->model('Departemen_model');
		$this->load->model('Proyek_model');
		$this->load->model('Foto_model');
		$this->load->model('Organisasi_model');
		$this->load->model('Manajemen_user_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "top_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses TOP";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Proyek_model->user_log_proyek($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Proyek_model->user_log_proyek($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) { //Staff Proc KP

			$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_kp/user_menu');
			$this->load->view('wasa/user_staff_procurement_kp/left_menu');
			$this->load->view('wasa/user_staff_procurement_kp/header_menu');
			$this->load->view('wasa/user_staff_procurement_kp/content_top');
			$this->load->view('wasa/user_staff_procurement_kp/footer');

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) { //Kasie Proc KP

			$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
			$this->load->view('wasa/user_kasie_procurement_kp/content_top');
			$this->load->view('wasa/user_kasie_procurement_kp/footer');

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) { //Manajer Proc KP

			$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
			$this->load->view('wasa/user_manajer_procurement_kp/content_top');
			$this->load->view('wasa/user_manajer_procurement_kp/footer');

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) { //Staff Proc SP

			$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_procurement_sp/user_menu');
			$this->load->view('wasa/user_staff_procurement_sp/left_menu');
			$this->load->view('wasa/user_staff_procurement_sp/header_menu');
			$this->load->view('wasa/user_staff_procurement_sp/content_top');
			$this->load->view('wasa/user_staff_procurement_sp/footer');

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) { //Supervisi Proc SP

			$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
			$this->load->view('wasa/user_supervisi_procurement_sp/content_top');
			$this->load->view('wasa/user_supervisi_procurement_sp/footer');

		} else {
			$this->logout();
		}
	}

	function simpan_data_top()
	{
		$user = $this->ion_auth->user()->row();
		$this->data['USER_ID'] = $user->id;
		$CREATE_BY_USER =  $this->data['USER_ID'];

		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment', 'trim|required|max_length[100]');
			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');

				//check apakah nama Lokasi Penyerahan sudah ada. jika belum ada, akan disimpan.
				if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
					$this->user_log($KETERANGAN);

					$data = $this->Term_Of_Payment_model->simpan_data_term_of_payment($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

					$this->Term_Of_Payment_model->set_md5_id_term_of_payment($NAMA_TERM_OF_PAYMENT);
				} else {
					echo 'Nama TOP sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment', 'trim|required|max_length[100]');
			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');

				//check apakah nama Lokasi Penyerahan sudah ada. jika belum ada, akan disimpan.
				if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
					$this->user_log($KETERANGAN);

					$data = $this->Term_Of_Payment_model->simpan_data_term_of_payment($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

					$this->Term_Of_Payment_model->set_md5_id_term_of_payment($NAMA_TERM_OF_PAYMENT);
				} else {
					echo 'Nama TOP sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment', 'trim|required|max_length[100]');
			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');

				//check apakah nama Lokasi Penyerahan sudah ada. jika belum ada, akan disimpan.
				if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
					$this->user_log($KETERANGAN);

					$data = $this->Term_Of_Payment_model->simpan_data_term_of_payment($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

					$this->Term_Of_Payment_model->set_md5_id_term_of_payment($NAMA_TERM_OF_PAYMENT);
				} else {
					echo 'Nama TOP sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment', 'trim|required|max_length[100]');
			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');

				//check apakah nama Lokasi Penyerahan sudah ada. jika belum ada, akan disimpan.
				if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
					$this->user_log($KETERANGAN);

					$data = $this->Term_Of_Payment_model->simpan_data_term_of_payment($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

					$this->Term_Of_Payment_model->set_md5_id_term_of_payment($NAMA_TERM_OF_PAYMENT);
				} else {
					echo 'Nama TOP sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Term of Payment', 'trim|required|max_length[100]');
			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');

				//check apakah nama Lokasi Penyerahan sudah ada. jika belum ada, akan disimpan.
				if ($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada') {
					//log
					$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
					$this->user_log($KETERANGAN);

					$data = $this->Term_Of_Payment_model->simpan_data_term_of_payment($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);

					$this->Term_Of_Payment_model->set_md5_id_term_of_payment($NAMA_TERM_OF_PAYMENT);
				} else {
					echo 'Nama TOP sudah terekam sebelumnya';
				}
			}
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		$user = $this->ion_auth->user()->row();
		$this->data['USER_ID'] = $user->id;
		$CREATE_BY_USER =  $this->data['USER_ID'];

		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Nama Term of Payment', 'trim|required|max_length[100]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
				$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');

				$data_edit = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
				$KETERANGAN = "Coba isi Nama Term of Payment: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada')) {
					
					$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
					$this->user_log($KETERANGAN);

					$data = $this->Term_Of_Payment_model->update_data($ID_TERM_OF_PAYMENT, $NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Nama Term of Payment', 'trim|required|max_length[100]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
				$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');

				$data_edit = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
				$KETERANGAN = "Coba isi Nama Term of Payment: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada')) {
					
					$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
					$this->user_log($KETERANGAN);

					$data = $this->Term_Of_Payment_model->update_data($ID_TERM_OF_PAYMENT, $NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Nama Term of Payment', 'trim|required|max_length[100]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
				$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');

				$data_edit = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
				$KETERANGAN = "Coba isi Nama Term of Payment: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada')) {
					
					$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
					$this->user_log($KETERANGAN);

					$data = $this->Term_Of_Payment_model->update_data($ID_TERM_OF_PAYMENT, $NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Nama Term of Payment', 'trim|required|max_length[100]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
				$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');

				$data_edit = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
				$KETERANGAN = "Coba isi Nama Term of Payment: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada')) {
					
					$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
					$this->user_log($KETERANGAN);

					$data = $this->Term_Of_Payment_model->update_data($ID_TERM_OF_PAYMENT, $NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_TERM_OF_PAYMENT', 'Nama Term of Payment', 'trim|required|max_length[100]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_TERM_OF_PAYMENT = $this->input->post('ID_TERM_OF_PAYMENT');
				$NAMA_TERM_OF_PAYMENT = $this->input->post('NAMA_TERM_OF_PAYMENT');

				$data_edit = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
				$KETERANGAN = "Coba isi Nama Term of Payment: " . json_encode($data_edit);
				$this->user_log($KETERANGAN);
				if (($this->Term_Of_Payment_model->cek_nama_top($NAMA_TERM_OF_PAYMENT) == 'Data belum ada')) {
					
					$KETERANGAN = "Simpan TOP " . $NAMA_TERM_OF_PAYMENT . $CREATE_BY_USER;
					$this->user_log($KETERANGAN);

					$data = $this->Term_Of_Payment_model->update_data($ID_TERM_OF_PAYMENT, $NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain');
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

	function data_top()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$data = $this->Term_Of_Payment_model->term_of_payment_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Term of Payment: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$data = $this->Term_Of_Payment_model->term_of_payment_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Term of Payment: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$data = $this->Term_Of_Payment_model->term_of_payment_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Term of Payment: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$data = $this->Term_Of_Payment_model->term_of_payment_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Term of Payment: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$data = $this->Term_Of_Payment_model->term_of_payment_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Term of Payment: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_top()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$ID_TERM_OF_PAYMENT = $this->input->get('id');
			$data = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
			echo json_encode($data);

			$KETERANGAN = "Get Data Term of Payment: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$ID_TERM_OF_PAYMENT = $this->input->get('id');
			$data = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
			echo json_encode($data);

			$KETERANGAN = "Get Data Term of Payment: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$ID_TERM_OF_PAYMENT = $this->input->get('id');
			$data = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
			echo json_encode($data);

			$KETERANGAN = "Get Data Term of Payment: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_TERM_OF_PAYMENT = $this->input->get('id');
			$data = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
			echo json_encode($data);

			$KETERANGAN = "Get Data Term of Payment: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_TERM_OF_PAYMENT = $this->input->get('id');
			$data = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);
			echo json_encode($data);

			$KETERANGAN = "Get Data Term of Payment: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function hapus_data_lokasi()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$user = $this->ion_auth->user()->row();
			$ID_TERM_OF_PAYMENT = $this->input->post('kode');
			$data_hapus = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);

			$data = $this->Term_Of_Payment_model->hapus_data_top($ID_TERM_OF_PAYMENT);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Lokasi Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$user = $this->ion_auth->user()->row();
			$ID_TERM_OF_PAYMENT = $this->input->post('kode');
			$data_hapus = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);

			$data = $this->Term_Of_Payment_model->hapus_data_top($ID_TERM_OF_PAYMENT);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Lokasi Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$user = $this->ion_auth->user()->row();
			$ID_TERM_OF_PAYMENT = $this->input->post('kode');
			$data_hapus = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);

			$data = $this->Term_Of_Payment_model->hapus_data_top($ID_TERM_OF_PAYMENT);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Lokasi Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$user = $this->ion_auth->user()->row();
			$ID_TERM_OF_PAYMENT = $this->input->post('kode');
			$data_hapus = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);

			$data = $this->Term_Of_Payment_model->hapus_data_top($ID_TERM_OF_PAYMENT);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Lokasi Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$user = $this->ion_auth->user()->row();
			$ID_TERM_OF_PAYMENT = $this->input->post('kode');
			$data_hapus = $this->Term_Of_Payment_model->get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT);

			$data = $this->Term_Of_Payment_model->hapus_data_top($ID_TERM_OF_PAYMENT);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Lokasi Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}
}
