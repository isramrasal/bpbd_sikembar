<?php defined('BASEPATH') or exit('No direct script access allowed');

class Satuan_barang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Satuan Barang';

		$this->load->model('Satuan_barang_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('Proyek_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		//$this->load->model('ws_pegawai_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "satuan_barang_aktif";
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
			$this->load->view('wasa/user_admin/content_satuan_barang');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_kp/content_satuan_barang');
			$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
			$this->load->view('wasa/user_kasie_logistik_kp/content_satuan_barang');
			$this->load->view('wasa/user_kasie_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
			$this->load->view('wasa/user_manajer_logistik_kp/content_satuan_barang');
			$this->load->view('wasa/user_manajer_logistik_kp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_satuan_barang');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/content_satuan_barang');
			$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_satuan_barang');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$this->load->view('wasa/user_staff_gudang_logistik_kp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_gudang_logistik_kp/user_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/left_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/header_menu');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/content_satuan_barang');
			$this->load->view('wasa/user_staff_gudang_logistik_kp/footer');
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_satuan_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$data = $this->Satuan_barang_model->satuan_barang_list();
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$data = $this->Satuan_barang_model->satuan_barang_list();
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$data = $this->Satuan_barang_model->satuan_barang_list();
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$data = $this->Satuan_barang_model->satuan_barang_list();
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$data = $this->Satuan_barang_model->satuan_barang_list();
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$data = $this->Satuan_barang_model->satuan_barang_list();
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$data = $this->Satuan_barang_model->satuan_barang_list();
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$data = $this->Satuan_barang_model->satuan_barang_list();
			echo json_encode($data);
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
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$id = $this->input->get('id');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$id = $this->input->get('id');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$id = $this->input->get('id');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$id = $this->input->get('id');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$id = $this->input->get('id');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$id = $this->input->get('id');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($id);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$id = $this->input->get('id');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($id);
			echo json_encode($data);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			// $user = $this->ion_auth->user()->row();
			$ID_SATUAN_BARANG = $this->input->post('kode');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

			//log
			// $KETERANGAN = "Hapus jenis barang ".$data['NAMA_satuan_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Satuan_barang_model->hapus_data_by_id_satuan_barang($ID_SATUAN_BARANG);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			// $user = $this->ion_auth->user()->row();
			$ID_SATUAN_BARANG = $this->input->post('kode');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

			//log
			// $KETERANGAN = "Hapus jenis barang ".$data['NAMA_satuan_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Satuan_barang_model->hapus_data_by_id_satuan_barang($ID_SATUAN_BARANG);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			// $user = $this->ion_auth->user()->row();
			$ID_SATUAN_BARANG = $this->input->post('kode');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

			//log
			// $KETERANGAN = "Hapus jenis barang ".$data['NAMA_satuan_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Satuan_barang_model->hapus_data_by_id_satuan_barang($ID_SATUAN_BARANG);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			// $user = $this->ion_auth->user()->row();
			$ID_SATUAN_BARANG = $this->input->post('kode');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

			//log
			// $KETERANGAN = "Hapus jenis barang ".$data['NAMA_satuan_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Satuan_barang_model->hapus_data_by_id_satuan_barang($ID_SATUAN_BARANG);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			// $user = $this->ion_auth->user()->row();
			$ID_SATUAN_BARANG = $this->input->post('kode');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

			//log
			// $KETERANGAN = "Hapus jenis barang ".$data['NAMA_satuan_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Satuan_barang_model->hapus_data_by_id_satuan_barang($ID_SATUAN_BARANG);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			// $user = $this->ion_auth->user()->row();
			$ID_SATUAN_BARANG = $this->input->post('kode');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

			//log
			// $KETERANGAN = "Hapus jenis barang ".$data['NAMA_satuan_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Satuan_barang_model->hapus_data_by_id_satuan_barang($ID_SATUAN_BARANG);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			// $user = $this->ion_auth->user()->row();
			$ID_SATUAN_BARANG = $this->input->post('kode');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

			//log
			// $KETERANGAN = "Hapus jenis barang ".$data['NAMA_satuan_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Satuan_barang_model->hapus_data_by_id_satuan_barang($ID_SATUAN_BARANG);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			// $user = $this->ion_auth->user()->row();
			$ID_SATUAN_BARANG = $this->input->post('kode');
			$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

			//log
			// $KETERANGAN = "Hapus jenis barang ".$data['NAMA_satuan_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Satuan_barang_model->hapus_data_by_id_satuan_barang($ID_SATUAN_BARANG);
			echo json_encode($data);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	function simpan_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
				if ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada') {
					//log
					// $KETERANGAN = "Simpan satuan_barang ".$nama_satuan_barang.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->simpan_data_by_admin($NAMA_SATUAN_BARANG);
				} else {
					echo 'Nama jenis barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
				if ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada') {
					//log
					// $KETERANGAN = "Simpan satuan_barang ".$nama_satuan_barang.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->simpan_data_by_admin($NAMA_SATUAN_BARANG);
				} else {
					echo 'Nama jenis barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
				if ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada') {
					//log
					// $KETERANGAN = "Simpan satuan_barang ".$nama_satuan_barang.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->simpan_data_by_admin($NAMA_SATUAN_BARANG);
				} else {
					echo 'Nama jenis barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
				if ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada') {
					//log
					// $KETERANGAN = "Simpan satuan_barang ".$nama_satuan_barang.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->simpan_data_by_admin($NAMA_SATUAN_BARANG);
				} else {
					echo 'Nama jenis barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
				if ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada') {
					//log
					// $KETERANGAN = "Simpan satuan_barang ".$nama_satuan_barang.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->simpan_data_by_admin($NAMA_SATUAN_BARANG);
				} else {
					echo 'Nama jenis barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
				if ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada') {
					//log
					// $KETERANGAN = "Simpan satuan_barang ".$nama_satuan_barang.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->simpan_data_by_admin($NAMA_SATUAN_BARANG);
				} else {
					echo 'Nama jenis barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
				if ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada') {
					//log
					// $KETERANGAN = "Simpan satuan_barang ".$nama_satuan_barang.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->simpan_data_by_admin($NAMA_SATUAN_BARANG);
				} else {
					echo 'Nama jenis barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
				if ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada') {
					//log
					// $KETERANGAN = "Simpan satuan_barang ".$nama_satuan_barang.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->simpan_data_by_admin($NAMA_SATUAN_BARANG);
				} else {
					echo 'Nama jenis barang sudah terekam sebelumnya';
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
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG2', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG2');
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG2');
				// $keterangan=$this->input->post('keterangan2');

				//cek apakah input sama dengan eksisting
				$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

				if ($data['NAMA_SATUAN_BARANG'] == $NAMA_SATUAN_BARANG || ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada')) {
					$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

					//log
					// $KETERANGAN = "Ubah satuan_barang ".$data['nama_satuan_barang']." jadi ".$nama_satuan_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->update_data($ID_SATUAN_BARANG, $NAMA_SATUAN_BARANG);
					echo json_encode($data);
				} else {
					echo json_encode('Nama jenis barang sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG2', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG2');
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG2');
				// $keterangan=$this->input->post('keterangan2');

				//cek apakah input sama dengan eksisting
				$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

				if ($data['NAMA_SATUAN_BARANG'] == $NAMA_SATUAN_BARANG || ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada')) {
					$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

					//log
					// $KETERANGAN = "Ubah satuan_barang ".$data['nama_satuan_barang']." jadi ".$nama_satuan_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->update_data($ID_SATUAN_BARANG, $NAMA_SATUAN_BARANG);
					echo json_encode($data);
				} else {
					echo json_encode('Nama jenis barang sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG2', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG2');
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG2');
				// $keterangan=$this->input->post('keterangan2');

				//cek apakah input sama dengan eksisting
				$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

				if ($data['NAMA_SATUAN_BARANG'] == $NAMA_SATUAN_BARANG || ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada')) {
					$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

					//log
					// $KETERANGAN = "Ubah satuan_barang ".$data['nama_satuan_barang']." jadi ".$nama_satuan_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->update_data($ID_SATUAN_BARANG, $NAMA_SATUAN_BARANG);
					echo json_encode($data);
				} else {
					echo json_encode('Nama jenis barang sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG2', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG2');
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG2');
				// $keterangan=$this->input->post('keterangan2');

				//cek apakah input sama dengan eksisting
				$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

				if ($data['NAMA_SATUAN_BARANG'] == $NAMA_SATUAN_BARANG || ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada')) {
					$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

					//log
					// $KETERANGAN = "Ubah satuan_barang ".$data['nama_satuan_barang']." jadi ".$nama_satuan_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->update_data($ID_SATUAN_BARANG, $NAMA_SATUAN_BARANG);
					echo json_encode($data);
				} else {
					echo json_encode('Nama jenis barang sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG2', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG2');
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG2');
				// $keterangan=$this->input->post('keterangan2');

				//cek apakah input sama dengan eksisting
				$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

				if ($data['NAMA_SATUAN_BARANG'] == $NAMA_SATUAN_BARANG || ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada')) {
					$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

					//log
					// $KETERANGAN = "Ubah satuan_barang ".$data['nama_satuan_barang']." jadi ".$nama_satuan_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->update_data($ID_SATUAN_BARANG, $NAMA_SATUAN_BARANG);
					echo json_encode($data);
				} else {
					echo json_encode('Nama jenis barang sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG2', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG2');
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG2');
				// $keterangan=$this->input->post('keterangan2');

				//cek apakah input sama dengan eksisting
				$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

				if ($data['NAMA_SATUAN_BARANG'] == $NAMA_SATUAN_BARANG || ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada')) {
					$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

					//log
					// $KETERANGAN = "Ubah satuan_barang ".$data['nama_satuan_barang']." jadi ".$nama_satuan_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->update_data($ID_SATUAN_BARANG, $NAMA_SATUAN_BARANG);
					echo json_encode($data);
				} else {
					echo json_encode('Nama jenis barang sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG2', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG2');
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG2');
				// $keterangan=$this->input->post('keterangan2');

				//cek apakah input sama dengan eksisting
				$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

				if ($data['NAMA_SATUAN_BARANG'] == $NAMA_SATUAN_BARANG || ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada')) {
					$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

					//log
					// $KETERANGAN = "Ubah satuan_barang ".$data['nama_satuan_barang']." jadi ".$nama_satuan_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->update_data($ID_SATUAN_BARANG, $NAMA_SATUAN_BARANG);
					echo json_encode($data);
				} else {
					echo json_encode('Nama jenis barang sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			// $user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_SATUAN_BARANG2', 'Nama Satuan Barang', 'trim|required|max_length[50]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG2');
				$NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG2');
				// $keterangan=$this->input->post('keterangan2');

				//cek apakah input sama dengan eksisting
				$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

				if ($data['NAMA_SATUAN_BARANG'] == $NAMA_SATUAN_BARANG || ($this->Satuan_barang_model->cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG) == 'Data belum ada')) {
					$data = $this->Satuan_barang_model->get_data_by_id_satuan_barang($ID_SATUAN_BARANG);

					//log
					// $KETERANGAN = "Ubah satuan_barang ".$data['nama_satuan_barang']." jadi ".$nama_satuan_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Satuan_barang_model->log_satuan_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Satuan_barang_model->update_data($ID_SATUAN_BARANG, $NAMA_SATUAN_BARANG);
					echo json_encode($data);
				} else {
					echo json_encode('Nama jenis barang sudah terekam sebelumnya');
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
}
