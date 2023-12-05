<?php defined('BASEPATH') or exit('No direct script access allowed');

class Khp_barang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | KHP Barang';

		$this->load->model('Barang_master_model');
		$this->load->model('Khp_barang_model');
		$this->load->model('Hbp_model');
		$this->load->model('Sppb_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RASD_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Foto_model');
		$this->load->model('Pegawai_model');
		date_default_timezone_set('Asia/Jakarta');
	}
	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index()
	{
		// echo $params;
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
		$this->data['left_menu'] = "khp_barang_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_khp = $this->uri->segment(3);
			$this->data['id_khp'] = $id_khp;
			$this->data['sppb'] = $this->Sppb_model->get_id_sppb_by_id_khp($id_khp);
			// $this->data['sppb_barang'] = $this->Sppb_barang_model->RASD_list_by_id_RASD($id_khp);
			// $this->data['barang_master_list'] = $this->Khp_barang_model->barang_master_list_where_not_in_khp($id_khp);
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
			$this->data['create_spp'] = $this->Khp_barang_model->khp_barang_list_by_id_khp($id_khp);
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_khp_barang');
			$this->load->view('wasa/user_admin/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_Khp_barang');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_khp_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Khp_barang_model->khp_barang_list_by_id_khp($id);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$user = $this->ion_auth->user()->row();
		// 	$data=$this->Khp_barang_model->Khp_barang_list_by_id_pegawai_atau_status($user->ID_PEGAWAI);
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
			$data = $this->Khp_barang_model->get_data_by_id_khp_barang($id);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$id=$this->input->get('id');
		// 	$data=$this->Khp_barang_model->get_data_by_id_Khp_barang($id);
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
			$ID_KHP_BARANG = $this->input->post('kode');
			$data = $this->Khp_barang_model->get_data_by_id_khp_barang($ID_KHP_BARANG);

			// //log
			// $KETERANGAN = "Hapus Khp_barang ".$data['NAMA_Khp_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Khp_barang_model->log_Khp_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Khp_barang_model->hapus_data_by_id_khp_barang($ID_KHP_BARANG);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();
		// 	$id_Khp_barang=$this->input->post('kode');
		// 	$data=$this->Khp_barang_model->get_data_by_id_Khp_barang($id_Khp_barang);

		// 	//log
		// 	$KETERANGAN = "Hapus Khp_barang ".$data['NAMA_Khp_barang'].", ket ".$data['KETERANGAN'];
		// 	$WAKTU = date('Y-m-d H:i:s');
		// 	$this->Khp_barang_model->log_Khp_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 	$data=$this->Khp_barang_model->hapus_data($id_Khp_barang);
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

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'NAMA', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'MEREK', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'JENIS_BARANG', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'SPESIFIKASI_SINGKAT', 'trim|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'NAMA_SATUAN_BARANG', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'JUMLAH_BARANG', 'trim|required');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_RASD = $this->input->post('ID_RASD');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				//check apakah nama Khp_barang sudah ada. jika belum ada, akan disimpan.
				if ($this->Khp_barang_model->cek_nama_khp_barang_by_admin($NAMA) == 'Data belum ada') {
					$data = $this->Khp_barang_model->simpan_data_baru_by_admin($ID_RASD, $NAMA, $MEREK, $JENIS_BARANG, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG);
				} else {
					echo 'Nama RASD Barang sudah terekam sebelumnya';
				}
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_Khp_barang', 'Nama Khp_barang', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo validation_errors();
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$nama_Khp_barang = $this->input->post('nama_Khp_barang');
		// 		$keterangan = $this->input->post('keterangan');
		// 		if($this->Khp_barang_model->cek_nama_Khp_barang_by_pegawai($nama_Khp_barang, $user->ID_PEGAWAI) == 'Data belum ada')
		// 		{
		// 			//log
		// 			$KETERANGAN = "Simpan Khp_barang ".$nama_Khp_barang.", ket ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Khp_barang_model->log_Khp_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Khp_barang_model->simpan_data_by_pegawai($nama_Khp_barang,$keterangan, $user->ID_PEGAWAI);
		// 		}
		// 		else
		// 		{
		// 			echo 'Nama Khp_barang sudah terekam sebelumnya';
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


			$DATA_HBP = $this->input->post('DATA_HBP');
			$data = (explode('/', $DATA_HBP));
			$ID_HBP = $data[0];
			$ID_KHP_BARANG = $data[1];
			$this->Khp_barang_model->update_data($ID_HBP, $ID_KHP_BARANG);
			redirect($_SERVER['HTTP_REFERER']);

		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_khp_barang2', 'Nama Khp_barang', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo json_encode(validation_errors());
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$id_khp_barang=$this->input->post('id_khp_barang2');
		// 		$nama_khp_barang=$this->input->post('nama_khp_barang2');
		// 		$keterangan=$this->input->post('keterangan2');

		// 		//cek apakah input sama dengan eksisting
		// 		$data=$this->Khp_barang_model->get_data_by_id_khp_barang($id_khp_barang);

		// 		if($data['NAMA_RASD_BARANG'] == $nama_khp_barang || ($this->Khp_barang_model->cek_nama_khp_barang_by_pegawai($nama_khp_barang, $user->ID_PEGAWAI) == 'Data belum ada'))
		// 		{
		// 			$data=$this->Khp_barang_model->get_data_by_id_khp_barang($id_khp_barang);

		// 			//log
		// 			$KETERANGAN = "Ubah Khp_barang ".$data['NAMA_RASD_BARANG']." jadi ".$nama_khp_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Khp_barang_model->log_Khp_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Khp_barang_model->update_data($id_khp_barang, $nama_khp_barang,$keterangan);
		// 			echo json_encode($data);
		// 		}
		// 		else
		// 		{
		// 			echo json_encode('Nama RASD Barang sudah terekam sebelumnya');
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
	function view_only_khp_barang()
	{

		// echo $params;
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
		$this->data['left_menu'] = "khp_barang_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_khp = $this->uri->segment(3);
			$this->data['id_khp'] = $id_khp;
			$this->data['khp'] = $this->RASD_model->RASD_list_by_id_RASD($id_khp);
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_khp_barang_view');
			$this->load->view('wasa/user_admin/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_Khp_barang');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	//TAMPILAN TAMBAH
	function view_khp_barang()
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
		$this->data['left_menu'] = "khp_barang_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_khp = $this->uri->segment(3);
			$this->data['id_khp'] = $id_khp;
			$this->data['khp'] = $this->RASD_model->RASD_list_by_id_RASD($id_khp);
			$this->data['barang_master_list'] = $this->Khp_barang_model->khp_barang_list_by_id_khp($id_khp);
			$this->data['hbp_list'] = $this->Hbp_model->hbp_list_by_id_khp_barang($id_khp);
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_khp_barang');
			$this->load->view('wasa/user_admin/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_Khp_barang');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

}
