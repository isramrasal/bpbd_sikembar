<?php defined('BASEPATH') or exit('No direct script access allowed');

class Khp extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | KHP';

		$this->load->model('Khp_model');
		$this->load->model('RASD_model');
		$this->load->model('Foto_model');
		$this->load->model('Pegawai_model');
		date_default_timezone_set('Asia/Jakarta');
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
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		$this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['left_menu'] = "khp_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai'] = $this->Pegawai_model->pegawai_list();

			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_khp_list');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_khp_list');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_khp()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$data = $this->Khp_model->khp_list();
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$user = $this->ion_auth->user()->row();
		// 	$data=$this->Khp_model->Khp_list_by_id_pegawai_atau_status($user->ID_PEGAWAI);
		// 	echo json_encode($data);
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Khp_model->get_data_by_id_khp($id);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$id=$this->input->get('id');
		// 	$data=$this->Khp_model->get_data_by_id_Khp($id);
		// 	echo json_encode($data);
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();
			$ID_KHP = $this->input->post('kode');
			$data = $this->Khp_model->get_data_by_id_khp($ID_KHP);

			// //log
			// $KETERANGAN = "Hapus KHP ".$data['NAMA_Khp']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Khp_model->log_Khp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Khp_model->hapus_data_by_id_khp($ID_KHP);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();
		// 	$id_Khp=$this->input->post('kode');
		// 	$data=$this->Khp_model->get_data_by_id_Khp($id_Khp);

		// 	//log
		// 	$KETERANGAN = "Hapus KHP ".$data['NAMA_Khp'].", ket ".$data['KETERANGAN'];
		// 	$WAKTU = date('Y-m-d H:i:s');
		// 	$this->Khp_model->log_Khp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 	$data=$this->Khp_model->hapus_data($id_Khp);
		// 	echo json_encode($data);
		// }
		else {
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
			$user = $this->ion_auth->user()->row();
			//aduhai 
			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$this->Khp_model->simpan_data_by_admin($ID_SPPB);
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_Khp', 'Nama KHP', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo validation_errors();
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$nama_Khp = $this->input->post('nama_Khp');
		// 		$keterangan = $this->input->post('keterangan');
		// 		if($this->Khp_model->cek_nama_Khp_by_pegawai($nama_Khp, $user->ID_PEGAWAI) == 'Data belum ada')
		// 		{
		// 			//log
		// 			$KETERANGAN = "Simpan KHP ".$nama_Khp.", ket ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Khp_model->log_Khp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Khp_model->simpan_data_by_pegawai($nama_Khp,$keterangan, $user->ID_PEGAWAI);
		// 		}
		// 		else
		// 		{
		// 			echo 'Nama KHP sudah terekam sebelumnya';
		// 		}

		// 	}
		// }
		else {
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
			$this->form_validation->set_rules('NAMA_PROYEK2', 'Nama KHP', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI2', 'Lokasi', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('INISIAL2', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('NAMA_PROJECT_MANAGER2', 'Nama Project Manager', 'trim|required');
			$this->form_validation->set_rules('NAMA_SITE_MANAGER2', 'Nama Site Manager', 'trim|required');
			$this->form_validation->set_rules('NAMA_SPV_LOG2', 'Nama Supervisor Logistik', 'trim|required');
			$this->form_validation->set_rules('NAMA_SPV_PROC2', 'Nama Supervisor Procurement', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_KHP2 = $this->input->post('ID_KHP2');
				$NAMA_PROYEK2 = $this->input->post('NAMA_PROYEK2');
				$LOKASI2 = $this->input->post('LOKASI2');
				$INISIAL2 = $this->input->post('INISIAL2');
				$NAMA_PROJECT_MANAGER2 = $this->input->post('NAMA_PROJECT_MANAGER2');
				$NAMA_SITE_MANAGER2 = $this->input->post('NAMA_SITE_MANAGER2');
				$NAMA_SPV_LOG2 = $this->input->post('NAMA_SPV_LOG2');
				$NAMA_SPV_PROC2 = $this->input->post('NAMA_SPV_PROC2');

				//cek apakah input sama dengan eksisting
				$data = $this->Khp_model->get_data_by_id_khp($ID_KHP2);

				if ($data['NAMA_PROYEK'] == $NAMA_PROYEK2 || ($this->Khp_model->cek_nama_khp_by_admin($NAMA_PROYEK2) == 'Data belum ada')) {
					$data = $this->Khp_model->get_data_by_id_khp($ID_KHP2);

					//log
					// $KETERANGAN = "Ubah KHP ".$data['NAMA_Khp']." jadi ".$nama_Khp.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Khp_model->log_Khp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

					$data = $this->Khp_model->update_data($ID_KHP2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $NAMA_PROJECT_MANAGER2, $NAMA_SITE_MANAGER2, $NAMA_SPV_LOG2, $NAMA_SPV_PROC2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama KHP sudah terekam sebelumnya');
				}
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_khp2', 'Nama KHP', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo json_encode(validation_errors());
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$id_khp=$this->input->post('id_khp2');
		// 		$nama_khp=$this->input->post('nama_khp2');
		// 		$keterangan=$this->input->post('keterangan2');

		// 		//cek apakah input sama dengan eksisting
		// 		$data=$this->Khp_model->get_data_by_id_khp($id_khp);

		// 		if($data['NAMA_PROYEK'] == $nama_khp || ($this->Khp_model->cek_nama_khp_by_pegawai($nama_khp, $user->ID_PEGAWAI) == 'Data belum ada'))
		// 		{
		// 			$data=$this->Khp_model->get_data_by_id_khp($id_khp);

		// 			//log
		// 			$KETERANGAN = "Ubah KHP ".$data['NAMA_PROYEK']." jadi ".$nama_khp.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Khp_model->log_Khp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Khp_model->update_data($id_khp, $nama_khp,$keterangan);
		// 			echo json_encode($data);
		// 		}
		// 		else
		// 		{
		// 			echo json_encode('Nama KHP sudah terekam sebelumnya');
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
}
