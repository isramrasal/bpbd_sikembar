<?php defined('BASEPATH') or exit('No direct script access allowed');

class Proyek_detil extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');

		$this->load->model('Proyek_model');
		$this->load->model('Proyek_file_model');
		$this->load->model('Rasd_barang_model');
		$this->load->model('RASD_model');
		$this->load->model('Departemen_model');
		$this->load->model('Foto_model');
		$this->load->model('Pegawai_model');
		$this->load->model('Manajemen_user_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "proyek_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Proyek_detil";
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
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		date_default_timezone_set('Asia/Jakarta');
		$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');
		$this->data['title'] = 'SIPESUT | Detil Proyek';

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$this->data['departemen'] = $this->Departemen_model->departemen_list();
		$this->data['HASH_MD5_PROYEK'] = $this->uri->segment(3);

		//Kueri data di tabel proyek
		$query_detil_proyek_HASH_MD5_PROYEK = $this->Proyek_model->detil_proyek_by_HASH_MD5_PROYEK($this->data['HASH_MD5_PROYEK']);

		$query_detil_proyek_HASH_MD5_PROYEK_result = $this->Proyek_model->detil_proyek_by_HASH_MD5_PROYEK_result($this->data['HASH_MD5_PROYEK']);
		$this->data['query_detil_proyek_HASH_MD5_PROYEK_result'] = $query_detil_proyek_HASH_MD5_PROYEK_result;
		
		if ($query_detil_proyek_HASH_MD5_PROYEK->num_rows() == 0) {
			// alihkan mereka ke halaman list proyek
			redirect('proyek', 'refresh');
		}
		//Kueri data di tabel proyek file
		$query_file_HASH_MD5_PROYEK = $this->Proyek_file_model->file_list_by_HASH_MD5_PROYEK($this->data['HASH_MD5_PROYEK']);

		//log
		$KETERANGAN = "Lihat Profil Proyek: " . json_encode($query_detil_proyek_HASH_MD5_PROYEK_result) . " ---- " . json_encode($query_file_HASH_MD5_PROYEK);
		$this->user_log($KETERANGAN);

		$hasil_1 = $query_detil_proyek_HASH_MD5_PROYEK->row();
		$this->data['HASH_MD5_PROYEK'] = $hasil_1->HASH_MD5_PROYEK;
		$this->data['ID_PROYEK'] = $hasil_1->ID_PROYEK;

		$sess_data['HASH_MD5_PROYEK'] = $this->data['HASH_MD5_PROYEK'];
		$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
		$this->session->set_userdata($sess_data);

		if ($query_file_HASH_MD5_PROYEK->num_rows() > 0) {

			$this->data['dokumen'] = $this->Proyek_file_model->file_list_by_HASH_MD5_PROYEK_result($sess_data['HASH_MD5_PROYEK']);

			$hasil = $query_file_HASH_MD5_PROYEK->row();
			$DOK_FILE = $hasil->DOK_FILE;
			$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

			if (file_exists($file = './assets/upload_proyek_file/' . $DOK_FILE)) {
				$this->data['DOK_FILE'] = $DOK_FILE;
				$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
				$this->data['FILE'] = "ADA";
			}
		} else {
			$this->data['FILE'] = "TIDAK ADA";
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_proyek_file');
		} else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$id = $this->input->get('id');
			$data = $this->Proyek_model->get_data_by_id_proyek($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$ID_PROYEK = $this->input->post('kode');
			$data_hapus = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK);
			$data = $this->Proyek_model->hapus_data_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_PROYEK = $this->input->post('kode');
			$data_hapus = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK);
			$data = $this->Proyek_model->hapus_data_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function simpan_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI', 'Lokasi', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('INISIAL', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$LOKASI = $this->input->post('LOKASI');
				$INISIAL = $this->input->post('INISIAL');
				$STATUS_PROYEK = $this->input->post('STATUS_PROYEK');

				//check apakah nama Proyek sudah ada. jika belum ada, akan disimpan.
				if ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK) == 'Data belum ada') {

					$KETERANGAN = "Tambah Data Proyek: " . ";" . $NAMA_PROYEK . ";" . $LOKASI . ";" . $INISIAL . ";" . $STATUS_PROYEK;
					$this->user_log($KETERANGAN);

					// SIMPAN DULU DATA KE TABEL PROYEK 
					$simpan_data = $this->Proyek_model->simpan_data_by_admin($NAMA_PROYEK, $LOKASI, $INISIAL, $STATUS_PROYEK);

					$simpan_data2 = $this->Proyek_model->set_md5_id_proyek($NAMA_PROYEK, $LOKASI, $INISIAL);

					// AMBIL ID PROYEK DARI TABLE PROYEK DENGAN PARAMETER NAMA PROYEK 
					$ID_PROYEK = $this->Proyek_model->get_data_by_nama_proyek($NAMA_PROYEK);

					// SIMPAN ID PROYEK KE TABEL RASD
					$this->RASD_model->simpan_data_by_admin($ID_PROYEK);
					$this->RASD_model->set_md5_id_rasd($ID_PROYEK);
				} else {
					echo 'Nama Proyek sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI', 'Lokasi', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('INISIAL', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NAMA_PROYEK = $this->input->post('NAMA_PROYEK');
				$LOKASI = $this->input->post('LOKASI');
				$INISIAL = $this->input->post('INISIAL');
				$STATUS_PROYEK = $this->input->post('STATUS_PROYEK');

				//check apakah nama Proyek sudah ada. jika belum ada, akan disimpan.
				if ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK) == 'Data belum ada') {

					$KETERANGAN = "Tambah Data Proyek: " . ";" . $NAMA_PROYEK . ";" . $LOKASI . ";" . $INISIAL . ";" . $STATUS_PROYEK;
					$this->user_log($KETERANGAN);

					// SIMPAN DULU DATA KE TABEL PROYEK 
					$simpan_data = $this->Proyek_model->simpan_data_by_admin($NAMA_PROYEK, $LOKASI, $INISIAL, $STATUS_PROYEK);

					$simpan_data2 = $this->Proyek_model->set_md5_id_proyek($NAMA_PROYEK, $LOKASI, $INISIAL);

					// AMBIL ID PROYEK DARI TABLE PROYEK DENGAN PARAMETER NAMA PROYEK 
					$ID_PROYEK = $this->Proyek_model->get_data_by_nama_proyek($NAMA_PROYEK);

					// SIMPAN ID PROYEK KE TABEL RASD
					$this->RASD_model->simpan_data_by_admin($ID_PROYEK);
					$this->RASD_model->set_md5_id_rasd($ID_PROYEK);
				} else {
					echo 'Nama Proyek sudah terekam sebelumnya';
				}
			}
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK2', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI2', 'Lokasi', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('INISIAL2', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK2', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PROYEK2 = $this->input->post('ID_PROYEK2');
				$NAMA_PROYEK2 = $this->input->post('NAMA_PROYEK2');
				$LOKASI2 = $this->input->post('LOKASI2');
				$INISIAL2 = $this->input->post('INISIAL2');
				$STATUS_PROYEK2 = $this->input->post('STATUS_PROYEK2');

				//cek apakah input sama dengan eksisting
				$data = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

				if ($data['NAMA_PROYEK'] == $NAMA_PROYEK2 || ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK2) == 'Data belum ada')) {
					$data_awal = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

					//log
					$KETERANGAN = "Ubah Data Proyek: " . json_encode($data_awal) . " ---- " . $NAMA_PROYEK2 . ";" . $LOKASI2 . ";" . $INISIAL2 . ";" . $STATUS_PROYEK2;
					$this->user_log($KETERANGAN);

					$data = $this->Proyek_model->update_data($ID_PROYEK2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $STATUS_PROYEK2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Proyek sudah terekam sebelumnya');
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_PROYEK2', 'Nama Proyek', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('LOKASI2', 'Lokasi', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('INISIAL2', 'Inisial', 'trim|required|max_length[10]');
			$this->form_validation->set_rules('STATUS_PROYEK2', 'Status', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PROYEK2 = $this->input->post('ID_PROYEK2');
				$NAMA_PROYEK2 = $this->input->post('NAMA_PROYEK2');
				$LOKASI2 = $this->input->post('LOKASI2');
				$INISIAL2 = $this->input->post('INISIAL2');
				$STATUS_PROYEK2 = $this->input->post('STATUS_PROYEK2');

				//cek apakah input sama dengan eksisting
				$data = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

				if ($data['NAMA_PROYEK'] == $NAMA_PROYEK2 || ($this->Proyek_model->cek_nama_proyek_by_admin($NAMA_PROYEK2) == 'Data belum ada')) {
					$data_awal = $this->Proyek_model->get_data_by_id_proyek($ID_PROYEK2);

					//log
					$KETERANGAN = "Ubah Data Proyek: " . json_encode($data_awal) . " ---- " . $NAMA_PROYEK2 . ";" . $LOKASI2 . ";" . $INISIAL2 . ";" . $STATUS_PROYEK2;
					$this->user_log($KETERANGAN);

					$data = $this->Proyek_model->update_data($ID_PROYEK2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $STATUS_PROYEK2);
					echo json_encode($data);
				} else {
					echo json_encode('Nama Proyek sudah terekam sebelumnya');
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

	public function organisasi_proyek()
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
			$this->data['HASH_MD5_PROYEK'] = $this->uri->segment(3);
			$sess_data['HASH_MD5_PROYEK'] = $this->data['HASH_MD5_PROYEK'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel proyek
			$query_detil_proyek_HASH_MD5_PROYEK = $this->Proyek_model->proyek_list_by_HASH_MD5_PROYEK($sess_data['HASH_MD5_PROYEK']);

			$query_detil_proyek_HASH_MD5_PROYEK_result = $this->Proyek_model->proyek_list_by_HASH_MD5_PROYEK_result($sess_data['HASH_MD5_PROYEK']);
			$this->data['query_detil_proyek_HASH_MD5_PROYEK_result'] = $query_detil_proyek_HASH_MD5_PROYEK_result;

			foreach ($query_detil_proyek_HASH_MD5_PROYEK_result as $data) {
				$sess_data['ID_PROYEK'] = $data->ID_PROYEK;
				$this->session->set_userdata($sess_data);
				$ID_PROYEK = $data->ID_PROYEK;
				$this->data['ID_PROYEK'] = $ID_PROYEK;
			}

			//fungsi ini untuk mengirim data ke dropdown
			$this->data['pegawai_proyek'] = $this->Pegawai_model->pegawai_list_by_id_proyek($ID_PROYEK);

			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_organisasi_proyek');
		} else {
			$this->logout();
		}
	}

	function update_data_organisasi()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('ID_PEGAWAI_PM', 'Project Manager', 'trim|required');
			$this->form_validation->set_rules('ID_PEGAWAI_SM', 'Site Manager', 'trim|required');
			$this->form_validation->set_rules('ID_PEGAWAI_LOG', 'Supervisor Logistik', 'trim|required');
			$this->form_validation->set_rules('ID_PEGAWAI_PROC', 'Supervisor Procurement', 'trim|required');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_PEGAWAI_PM = $this->input->post('ID_PEGAWAI_PM');
				$ID_PEGAWAI_SM = $this->input->post('ID_PEGAWAI_SM');
				$ID_PEGAWAI_LOG = $this->input->post('ID_PEGAWAI_LOG');
				$ID_PEGAWAI_PROC = $this->input->post('ID_PEGAWAI_PROC');


				$data_awal = $this->Proyek_model->proyek_list_by_id_proyek($ID_PROYEK);

				$data = $this->Proyek_model->update_data_organisasi(
					$ID_PROYEK,
					$ID_PEGAWAI_PM,
					$ID_PEGAWAI_SM,
					$ID_PEGAWAI_LOG,
					$ID_PEGAWAI_PROC
				);
				echo json_encode($data);

				//log
				// $KETERANGAN = "Ubah Data Barang: " . json_encode($data_awal) . " ---- " .$NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT. ";" . $KODE_BARANG. ";" . $PERALATAN_PERLENGKAPAN. ";" . $DIMENSI_PANJANG. ";" . $DIMENSI_LEBAR. ";" . $DIMENSI_TINGGI. ";" . $SPESIFIKASI_LENGKAP. ";" . $SPESIFIKASI_SINGKAT. ";" . $CARA_SINGKAT_PENGGUNAAN. ";" . $CARA_PENYIMPANAN_BARANG. ";" . $MASA_PAKAI;
			}
		} else {
			$this->ion_auth->logout();
		}
	}

	function data_pic_proyek()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->Proyek_model->pegawai_list_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data PIC Proyek: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function simpan_data_pic_proyek()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('NIP', 'Nomor Induk Pegawai', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_DEPARTEMEN_PEGAWAI', 'Departemen', 'trim|required');
			$this->form_validation->set_rules('JABATAN_PEGAWAI', 'Jabatan', 'trim|required');
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone Utama', 'trim|required|numeric');


			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$JABATAN_PEGAWAI = $this->input->post('JABATAN_PEGAWAI');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$EMAIL = strtolower($EMAIL);
				$NO_HP_1 = $this->input->post('NO_HP_1');

				//check apakah nama Proyek sudah ada. jika belum ada, akan disimpan.
				if ($this->Pegawai_model->cek_nip($NIP) == 'Data belum ada') {

					if ($this->Pegawai_model->cek_email($EMAIL) == 'Data belum ada') {
						$KETERANGAN = "Tambah Data Pegawai: " . ";" . $NIP . ";" . $ID_PROYEK_PEGAWAI . ";" . $ID_DEPARTEMEN_PEGAWAI . ";" . $JABATAN_PEGAWAI . ";" . $NAMA . ";" . $EMAIL . ";" . $NO_HP_1;
						$this->user_log($KETERANGAN);

						// SIMPAN DATA
						$this->Pegawai_model->simpan_data($NIP, $ID_PROYEK_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI,  $NAMA, $EMAIL, $NO_HP_1);
					} else {
						echo json_encode('Email Pegawai sudah terekam sebelumnya');
					}
				} else {
					echo json_encode('NIP Pegawai sudah terekam sebelumnya');
				}
			}
		} else {
			$this->logout();
		}
	}


	//Untuk proses upload file
	function proses_upload_file()
	{

		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		$HASH_MD5_PROYEK = $this->session->userdata('HASH_MD5_PROYEK');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_PROYEK . '_';
			$config['upload_path']   = './assets/upload_proyek_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_proyek = $this->Proyek_model->get_id_proyek_by_HASH_MD5_PROYEK($HASH_MD5_PROYEK);
			$ID_PROYEK = $query_id_proyek['ID_PROYEK'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');
				$KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

				$KETERANGAN = './assets/upload_proyek_file/' . $nama;
				$this->db->insert('proyek_file', array('ID_PROYEK' => $ID_PROYEK, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_PROYEK' => $HASH_MD5_PROYEK, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
				echo ($JENIS_FILE);
			} else {
				redirect($_SERVER['REQUEST_URI'], 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_PROYEK . '_';
			$config['upload_path']   = './assets/upload_proyek_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_proyek = $this->Proyek_model->get_id_proyek_by_HASH_MD5_PROYEK($HASH_MD5_PROYEK);
			$ID_PROYEK = $query_id_proyek['ID_PROYEK'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');
				$KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

				$KETERANGAN = './assets/upload_proyek_file/' . $nama;
				$this->db->insert('proyek_file', array('ID_PROYEK' => $ID_PROYEK, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_PROYEK' => $HASH_MD5_PROYEK, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
				echo ($JENIS_FILE);
			} else {
				redirect($_SERVER['REQUEST_URI'], 'refresh');
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
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Proyek_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_proyek_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Proyek_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PROYEK = $this->session->userdata('HASH_MD5_PROYEK');
				redirect('/proyek/detil_proyek/' . $HASH_MD5_PROYEK, 'refresh');
			} else {
				$HASH_MD5_PROYEK = $this->session->userdata('HASH_MD5_PROYEK');
				redirect('/proyek/detil_proyek/' . $HASH_MD5_PROYEK, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Proyek_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_proyek_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Proyek_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PROYEK = $this->session->userdata('HASH_MD5_PROYEK');
				redirect('/proyek/detil_proyek/' . $HASH_MD5_PROYEK, 'refresh');
			} else {
				$HASH_MD5_PROYEK = $this->session->userdata('HASH_MD5_PROYEK');
				redirect('/proyek/detil_proyek/' . $HASH_MD5_PROYEK, 'refresh');
			}
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
}
