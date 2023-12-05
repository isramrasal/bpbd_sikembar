<?php defined('BASEPATH') or exit('No direct script access allowed');

class Hbp extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | HBP';

		$this->load->model('Barang_master_model');
		$this->load->model('Hbp_model');
		$this->load->model('Vendor_model');
		$this->load->model('Khp_barang_model');
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
		$this->data['left_menu'] = "hbp_barang_aktif";

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_khp_barang = $this->uri->segment(3);
			$this->data['id_khp_barang'] = $id_khp_barang;
			$this->data['sppb_barang'] = $this->Khp_barang_model->get_data_sppb_barang_by_id_khp_barang_for_hbp($id_khp_barang);
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
			$this->data['vendor'] = $this->Vendor_model->vendor_list();
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_hbp');
			$this->load->view('wasa/user_admin/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_Hbp');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_hbp_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Hbp_model->hbp_barang_list_by_id_khp_barang($id);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$user = $this->ion_auth->user()->row();
		// 	$data=$this->Hbp_model->Hbp_list_by_id_pegawai_atau_status($user->ID_PEGAWAI);
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
			$data = $this->Hbp_model->hbp_barang_list($id);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$id=$this->input->get('id');
		// 	$data=$this->Hbp_model->get_data_by_id_Hbp($id);
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
			$ID_HBP = $this->input->post('kode');
			// $data = $this->Hbp_model->get_data_by_id_hbp_barang($ID_HBP);

			// //log
			// $KETERANGAN = "Hapus Hbp ".$data['NAMA_Hbp']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Hbp_model->log_Hbp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

			$data = $this->Hbp_model->hapus_data_by_id_hbp($ID_HBP);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();
		// 	$id_Hbp=$this->input->post('kode');
		// 	$data=$this->Hbp_model->get_data_by_id_Hbp($id_Hbp);

		// 	//log
		// 	$KETERANGAN = "Hapus Hbp ".$data['NAMA_Hbp'].", ket ".$data['KETERANGAN'];
		// 	$WAKTU = date('Y-m-d H:i:s');
		// 	$this->Hbp_model->log_Hbp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 	$data=$this->Hbp_model->hapus_data($id_Hbp);
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
			$this->form_validation->set_rules('ID_KHP_BARANG', 'ID KHP BARANG', 'trim');
			$this->form_validation->set_rules('ID_VENDOR', 'Nama Vendor', 'trim|required');
			$this->form_validation->set_rules('HARGA_SATUAN_VENDOR', 'Harga Satuan Barang', 'trim|required');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_KHP_BARANG = $this->input->post('ID_KHP_BARANG');
				$ID_VENDOR = $this->input->post('ID_VENDOR');
				$HARGA_SATUAN_VENDOR = $this->input->post('HARGA_SATUAN_VENDOR');

				//check apakah nama Hbp sudah ada. jika belum ada, akan disimpan.
				if ($this->Hbp_model->cek_id_vendor($ID_VENDOR) == 'Data belum ada') {
					$data = $this->Hbp_model->simpan_data_baru_by_admin($ID_KHP_BARANG, $ID_VENDOR, $HARGA_SATUAN_VENDOR);
				} else {
					echo 'Nama Vendor sudah terekam sebelumnya';
				}
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_Hbp', 'Nama Hbp', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo validation_errors();
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$nama_Hbp = $this->input->post('nama_Hbp');
		// 		$keterangan = $this->input->post('keterangan');
		// 		if($this->Hbp_model->cek_nama_Hbp_by_pegawai($nama_Hbp, $user->ID_PEGAWAI) == 'Data belum ada')
		// 		{
		// 			//log
		// 			$KETERANGAN = "Simpan Hbp ".$nama_Hbp.", ket ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Hbp_model->log_Hbp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Hbp_model->simpan_data_by_pegawai($nama_Hbp,$keterangan, $user->ID_PEGAWAI);
		// 		}
		// 		else
		// 		{
		// 			echo 'Nama Hbp sudah terekam sebelumnya';
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
			$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');

			foreach ($ID_BARANG_MASTER as $index => $ID_BARANG_MASTER) {
				$this->Hbp_model->simpan_data_from_barang_master_by_admin($ID_BARANG_MASTER, $ID_RASD[$index], $JUMLAH_BARANG[$index]);
			}

			redirect($_SERVER['HTTP_REFERER']);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_Hbp', 'Nama Hbp', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo validation_errors();
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$nama_Hbp = $this->input->post('nama_Hbp');
		// 		$keterangan = $this->input->post('keterangan');
		// 		if($this->Hbp_model->cek_nama_Hbp_by_pegawai($nama_Hbp, $user->ID_PEGAWAI) == 'Data belum ada')
		// 		{
		// 			//log
		// 			$KETERANGAN = "Simpan Hbp ".$nama_Hbp.", ket ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Hbp_model->log_Hbp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Hbp_model->simpan_data_by_pegawai($nama_Hbp,$keterangan, $user->ID_PEGAWAI);
		// 		}
		// 		else
		// 		{
		// 			echo 'Nama Hbp sudah terekam sebelumnya';
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
				$ID_KHP_BARANG = $this->input->post('ID_KHP_BARANG');
				$ID_HBP = $this->input->post('ID_HBP');
				$ID_VENDOR = $this->input->post('ID_VENDOR');
				$HARGA_SATUAN_VENDOR = $this->input->post('HARGA_SATUAN_VENDOR');

				//cek apakah input sama dengan eksisting
				// $data = $this->Hbp_model->get_data_by_id_hbp_barang($ID_KHP_BARANG2);

				// if ($data['NAMA_RASD_BARANG'] == $NAMA_RASD_BARANG2 || ($this->Hbp_model->cek_nama_hbp_barang_by_admin($NAMA_RASD_BARANG2) == 'Data belum ada')) {
				$data = $this->Hbp_model->get_data_by_id_hbp($ID_HBP);

				//log
				// $KETERANGAN = "Ubah Hbp ".$data['NAMA_Hbp']." jadi ".$nama_Hbp.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
				// $WAKTU = date('Y-m-d H:i:s');
				// $this->Hbp_model->log_Hbp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

				$data = $this->Hbp_model->update_data($ID_KHP_BARANG, $ID_HBP, $ID_VENDOR, $HARGA_SATUAN_VENDOR);
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
		// 	$this->form_validation->set_rules('nama_hbp_barang2', 'Nama Hbp', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo json_encode(validation_errors());
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$id_hbp_barang=$this->input->post('id_hbp_barang2');
		// 		$nama_hbp_barang=$this->input->post('nama_hbp_barang2');
		// 		$keterangan=$this->input->post('keterangan2');

		// 		//cek apakah input sama dengan eksisting
		// 		$data=$this->Hbp_model->get_data_by_id_hbp_barang($id_hbp_barang);

		// 		if($data['NAMA_RASD_BARANG'] == $nama_hbp_barang || ($this->Hbp_model->cek_nama_hbp_barang_by_pegawai($nama_hbp_barang, $user->ID_PEGAWAI) == 'Data belum ada'))
		// 		{
		// 			$data=$this->Hbp_model->get_data_by_id_hbp_barang($id_hbp_barang);

		// 			//log
		// 			$KETERANGAN = "Ubah Hbp ".$data['NAMA_RASD_BARANG']." jadi ".$nama_hbp_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Hbp_model->log_Hbp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Hbp_model->update_data($id_hbp_barang, $nama_hbp_barang,$keterangan);
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
	function view_only_hbp_barang()
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
		$this->data['left_menu'] = "hbp_barang_aktif";

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
			$this->load->view('wasa/user_admin/content_hbp_view');
			$this->load->view('wasa/user_admin/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_Hbp');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	//TAMPILAN TAMBAH
	function view_hbp_barang()
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
		$this->data['left_menu'] = "hbp_barang_aktif";

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
			$this->data['barang_master_list'] = $this->Hbp_model->hbp_barang_list_by_id_khp($id_khp);
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_hbp');
			$this->load->view('wasa/user_admin/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_Hbp');
		// }
		else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
}
