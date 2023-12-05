<?php defined('BASEPATH') or exit('No direct script access allowed');

class RASD_barang extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | RASD Barang dan Jasa';

		$this->load->model('Barang_master_model');
		$this->load->model('Rasd_barang_model');
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
		$this->data['left_menu'] = "rasd_barang_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_rasd = $this->uri->segment(3);
			$this->data['id_rasd'] = $id_rasd;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_id_RASD($id_rasd);
			
			$this->data['barang_master_list'] = $this->Rasd_barang_model->barang_master_list_where_not_in_rasd($id_rasd);
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_rasd_barang');
			$this->load->view('wasa/user_admin/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_RASD_barang');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_rasd_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Rasd_barang_model->rasd_barang_list_by_id_rasd($id);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$user = $this->ion_auth->user()->row();
		// 	$data=$this->Rasd_barang_model->RASD_barang_list_by_id_pegawai_atau_status($user->ID_PEGAWAI);
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
			$data = $this->Rasd_barang_model->get_data_by_id_rasd_barang($id);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$id=$this->input->get('id');
		// 	$data=$this->Rasd_barang_model->get_data_by_id_RASD_barang($id);
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
			$ID_RASD_BARANG = $this->input->post('kode');
			$data = $this->Rasd_barang_model->get_data_by_id_rasd_barang($ID_RASD_BARANG);

			// //log
			// $KETERANGAN = "Hapus RASD_barang ".$data['NAMA_RASD_barang']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Rasd_barang_model->log_RASD_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Rasd_barang_model->hapus_data_by_id_rasd_barang($ID_RASD_BARANG);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();
		// 	$id_RASD_barang=$this->input->post('kode');
		// 	$data=$this->Rasd_barang_model->get_data_by_id_RASD_barang($id_RASD_barang);

		// 	//log
		// 	$KETERANGAN = "Hapus RASD_barang ".$data['NAMA_RASD_barang'].", ket ".$data['KETERANGAN'];
		// 	$WAKTU = date('Y-m-d H:i:s');
		// 	$this->Rasd_barang_model->log_RASD_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 	$data=$this->Rasd_barang_model->hapus_data($id_RASD_barang);
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
				$ID_BARANG_MASTER = 'null';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				//check apakah nama RASD_barang sudah ada. jika belum ada, akan disimpan.
				if ($this->Rasd_barang_model->cek_nama_rasd_barang_by_admin($NAMA) == 'Data belum ada') {
					$data = $this->Rasd_barang_model->simpan_data_by_admin(
						$ID_BARANG_MASTER,
						$ID_RASD,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_BARANG
					);
				} else {
					echo 'Nama RASD Barang sudah terekam sebelumnya';
				}
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_RASD_barang', 'Nama RASD_barang', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo validation_errors();
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$nama_RASD_barang = $this->input->post('nama_RASD_barang');
		// 		$keterangan = $this->input->post('keterangan');
		// 		if($this->Rasd_barang_model->cek_nama_RASD_barang_by_pegawai($nama_RASD_barang, $user->ID_PEGAWAI) == 'Data belum ada')
		// 		{
		// 			//log
		// 			$KETERANGAN = "Simpan RASD_barang ".$nama_RASD_barang.", ket ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Rasd_barang_model->log_RASD_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Rasd_barang_model->simpan_data_by_pegawai($nama_RASD_barang,$keterangan, $user->ID_PEGAWAI);
		// 		}
		// 		else
		// 		{
		// 			echo 'Nama RASD_barang sudah terekam sebelumnya';
		// 		}

		// 	}
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function simpan_data_dari_barang_master()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');

			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				// echo $jumlah[$index];
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				$jumlah = $this->input->post($ID_MASTER);
				$this->Rasd_barang_model->simpan_data_by_admin(
					$ID_MASTER,
					$ID_RASD,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
			}

			redirect($_SERVER['HTTP_REFERER']);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_RASD_barang', 'Nama RASD_barang', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo validation_errors();
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$nama_RASD_barang = $this->input->post('nama_RASD_barang');
		// 		$keterangan = $this->input->post('keterangan');
		// 		if($this->Rasd_barang_model->cek_nama_RASD_barang_by_pegawai($nama_RASD_barang, $user->ID_PEGAWAI) == 'Data belum ada')
		// 		{
		// 			//log
		// 			$KETERANGAN = "Simpan RASD_barang ".$nama_RASD_barang.", ket ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Rasd_barang_model->log_RASD_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Rasd_barang_model->simpan_data_by_pegawai($nama_RASD_barang,$keterangan, $user->ID_PEGAWAI);
		// 		}
		// 		else
		// 		{
		// 			echo 'Nama RASD_barang sudah terekam sebelumnya';
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
			// $this->form_validation->set_rules('ID_BARANG_MASTER', 'Id Barang Master', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_RASD_BARANG = $this->input->post('ID_RASD_BARANG');
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

				//cek apakah input sama dengan eksisting
				// $data = $this->Rasd_barang_model->get_data_by_id_rasd_barang($ID_RASD_BARANG2);

				// if ($data['NAMA_RASD_BARANG'] == $NAMA_RASD_BARANG2 || ($this->Rasd_barang_model->cek_nama_rasd_barang_by_admin($NAMA_RASD_BARANG2) == 'Data belum ada')) {
				$data = $this->Rasd_barang_model->get_data_by_id_rasd_barang($ID_RASD_BARANG);

				//log
				// $KETERANGAN = "Ubah RASD_barang ".$data['NAMA_RASD_barang']." jadi ".$nama_RASD_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
				// $WAKTU = date('Y-m-d H:i:s');
				// $this->Rasd_barang_model->log_RASD_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

				$data = $this->Rasd_barang_model->update_data($ID_RASD_BARANG, $ID_BARANG_MASTER, $JUMLAH_BARANG);
				echo json_encode($data);
				// } else {
				// echo json_encode('Nama RASD Barang sudah terekam sebelumnya');
				// }
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_rasd_barang2', 'Nama RASD_barang', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo json_encode(validation_errors());
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$id_rasd_barang=$this->input->post('id_rasd_barang2');
		// 		$nama_rasd_barang=$this->input->post('nama_rasd_barang2');
		// 		$keterangan=$this->input->post('keterangan2');

		// 		//cek apakah input sama dengan eksisting
		// 		$data=$this->Rasd_barang_model->get_data_by_id_rasd_barang($id_rasd_barang);

		// 		if($data['NAMA_RASD_BARANG'] == $nama_rasd_barang || ($this->Rasd_barang_model->cek_nama_rasd_barang_by_pegawai($nama_rasd_barang, $user->ID_PEGAWAI) == 'Data belum ada'))
		// 		{
		// 			$data=$this->Rasd_barang_model->get_data_by_id_rasd_barang($id_rasd_barang);

		// 			//log
		// 			$KETERANGAN = "Ubah RASD_barang ".$data['NAMA_RASD_BARANG']." jadi ".$nama_rasd_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Rasd_barang_model->log_RASD_barang($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Rasd_barang_model->update_data($id_rasd_barang, $nama_rasd_barang,$keterangan);
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
	function view_only_rasd_barang()
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
		$this->data['left_menu'] = "rasd_barang_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_rasd = $this->uri->segment(3);
			$this->data['id_rasd'] = $id_rasd;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_id_RASD($id_rasd);
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_rasd_barang_view');
			$this->load->view('wasa/user_admin/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_RASD_barang');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	//TAMPILAN TAMBAH
	function view_rasd_barang()
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
		$this->data['left_menu'] = "rasd_barang_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_rasd = $this->uri->segment(3);
			$this->data['id_rasd'] = $id_rasd;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_id_RASD($id_rasd);
			$this->data['barang_master_list'] = $this->Rasd_barang_model->barang_master_list_where_not_in_rasd($id_rasd);
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_rasd_barang');
			$this->load->view('wasa/user_admin/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_RASD_barang');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
}