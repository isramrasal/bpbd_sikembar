<?php defined('BASEPATH') or exit('No direct script access allowed');

class Organisasi extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation', 'session'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Organisasi';

		$this->load->model('Organisasi_model');
		$this->load->model('Foto_model');
		$this->load->model('Proyek_model');
		$this->load->model('Departemen_model');
		$this->load->model('Manajemen_user_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "organisasi_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Organisasi";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Organisasi_model->user_log_organisasi($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Organisasi_model->user_log_organisasi($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//fungsi ini untuk mengirim data ke dropdown
		$this->data['proyek'] = $this->Proyek_model->list_proyek();
		$this->data['departemen'] = $this->Departemen_model->departemen_list();
		$this->data['groups'] = $this->Organisasi_model->groups_list();

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_organisasi');
		} else {
			//log the user out
			$this->logout();
		}
	}

	function data_organisasi()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$data = $this->Organisasi_model->organisasi_list_table_view();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Organisasi: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4))) {
			$user = $this->ion_auth->user()->row();
			$data = $this->Organisasi_model->organisasi_list_by_id_organisasi($user->ID_PEGAWAI);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Organisasi: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// log the user out
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Organisasi_model->get_data_by_id($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Organisasi: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$id = $this->input->get('id');
			$data = $this->Organisasi_model->get_data_by_id($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Organisasi: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(4))) {
			$id = $this->input->get('id');
			$data = $this->Organisasi_model->get_data_by_id($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Organisasi: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5) || $this->ion_auth->in_group(6) || $this->ion_auth->in_group(7) || $this->ion_auth->in_group(8) || $this->ion_auth->in_group(9) || $this->ion_auth->in_group(12))) {
			$id = $this->input->get('id');
			$data = $this->Organisasi_model->get_data_by_id($id);
			echo json_encode($data);

			$KETERANGAN = "Get Data Organisasi: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// log the user out
			$this->logout();
		}
	}


	function get_data_jabatan()
	{

		$proyek = $this->input->post('proyek');
		$LOKASI = "";

		if ($proyek != "1") {
			$LOKASI = "sp";
		} else {
			$LOKASI = "kp";
		}

		// get data 
		$data = $this->Organisasi_model->groups_list_by_lokasi($LOKASI);
		echo json_encode($data);

		$KETERANGAN = "Get Data Jabatan By Lokasi: " . json_encode($data);
		$this->user_log($KETERANGAN);
	}

	function get_nama_jabatan()
	{

		$id_jabatan = $this->input->post('id_jabatan');

		// get data 
		$data = $this->Organisasi_model->groups_list_by_id_jabatan($id_jabatan);
		echo json_encode($data);

		$KETERANGAN = "Get Data Jabatan By ID Groups: " . json_encode($data);
		$this->user_log($KETERANGAN);
	}

	function get_inisial_proyek()
	{

		$id_proyek = $this->input->post('id_proyek');

		// get data 
		$data = $this->Proyek_model->detil_proyek_by_ID_PROYEK_result($id_proyek);
		echo json_encode($data);

		$KETERANGAN = "Get Detil Proyek By ID Proyek: " . json_encode($data);
		$this->user_log($KETERANGAN);
	}

	function simpan_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|max_length[100]|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl_2->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function simpan_data_PIC_proyek()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "4") {
					$ID_DEPARTEMEN_PEGAWAI = "PM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($EMAIL, $USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($EMAIL, $USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function update_data_PIC_proyek()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "4") {
					$ID_DEPARTEMEN_PEGAWAI = "PM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
				$ID_USER = $this->input->post('ID_USER');
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				if ($ID_JABATAN_PEGAWAI == "3") {
					$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
				}

				if ($ID_JABATAN_PEGAWAI == "4") {
					$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
				}

				$this->Organisasi_model->update_data($ID_PEGAWAI, $NIP, $ID_PROYEK_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI, $NAMA, $EMAIL, $NO_HP_1);

				$hasil=$this->db->query("UPDATE users SET  username='$USERNAME', password='$PASSWORD_UTAMA' WHERE id='$ID_USER'");

			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
				$ID_USER = $this->input->post('ID_USER');
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				if ($ID_JABATAN_PEGAWAI == "3") {
					$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
				}

				if ($ID_JABATAN_PEGAWAI == "4") {
					$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
				}

				$this->Organisasi_model->update_data($ID_PEGAWAI, $NIP, $ID_PROYEK_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI, $NAMA, $EMAIL, $NO_HP_1);

				$hasil=$this->db->query("UPDATE users SET  username='$USERNAME', password='$PASSWORD_UTAMA' WHERE id='$ID_USER'");

			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				//check apakah nama USERNAME sudah ada. jika belum ada, akan disimpan.
				if ($this->Organisasi_model->cek_username_users($USERNAME) == 'Data belum ada') {

					// SIMPAN DATA
					$this->Organisasi_model->simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI);

					$hsl = $this->db->query("SELECT ID_PEGAWAI from pegawai WHERE NIP ='$NIP' AND ID_PROYEK_PEGAWAI ='$ID_PROYEK_PEGAWAI' AND ID_JABATAN_PEGAWAI ='$ID_JABATAN_PEGAWAI'");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl->result() as $data) {
							$hasil = array(
								'ID_PEGAWAI' => $data->ID_PEGAWAI
							);
						}
					}
					$ID_PEGAWAI = $hasil['ID_PEGAWAI'];


					$CREATED =  time();
					$this->Organisasi_model->register_users($EMAIL, $USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI);


					$hsl_2 = $this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$ID_PEGAWAI' AND username ='$USERNAME' ");
					if ($hsl->num_rows() > 0) {
						foreach ($hsl_2->result() as $data) {
							$hasil = array(
								'id' => $data->id
							);
						}
					}
					$ID_USER = $hasil['id'];

					if ($ID_JABATAN_PEGAWAI == "3") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					if ($ID_JABATAN_PEGAWAI == "4") {
						$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
					}

					$data = $this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_USER', '$ID_JABATAN_PEGAWAI')");
				} else {
					echo 'Username pegawai sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
				$ID_USER = $this->input->post('ID_USER');
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				if ($ID_JABATAN_PEGAWAI == "3") {
					$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
				}

				if ($ID_JABATAN_PEGAWAI == "4") {
					$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
				}

				$this->Organisasi_model->update_data($ID_PEGAWAI, $NIP, $ID_PROYEK_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI, $NAMA, $EMAIL, $NO_HP_1);

				$hasil=$this->db->query("UPDATE users SET  username='$USERNAME', password='$PASSWORD_UTAMA' WHERE id='$ID_USER'");

			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
				$ID_USER = $this->input->post('ID_USER');
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				if ($ID_JABATAN_PEGAWAI == "3") {
					$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
				}

				if ($ID_JABATAN_PEGAWAI == "4") {
					$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
				}

				$this->Organisasi_model->update_data($ID_PEGAWAI, $NIP, $ID_PROYEK_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI, $NAMA, $EMAIL, $NO_HP_1);

				$hasil=$this->db->query("UPDATE users SET  username='$USERNAME', password='$PASSWORD_UTAMA' WHERE id='$ID_USER'");

			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			
			$this->form_validation->set_rules('NAMA', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL', 'Email Pribadi', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_1', 'Nomor Handphone', 'trim|required|numeric');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN_PEGAWAI', 'Jabatan', 'trim|required');

			$tables = $this->config->item('tables', 'ion_auth');
			$this->form_validation->set_rules('USERNAME', 'Username', 'trim|required|is_unique[' . $tables['users'] . '.username]');
			$this->form_validation->set_rules('PASSWORD_UTAMA', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[PASSWORD_KONFIRMASI]');
			$this->form_validation->set_rules('PASSWORD_KONFIRMASI', 'Ketik Ulang Password', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
				$ID_USER = $this->input->post('ID_USER');
				$NIP = $this->input->post('NIP');
				$NAMA = $this->input->post('NAMA');
				$EMAIL = $this->input->post('EMAIL');
				$NO_HP_1 = $this->input->post('NO_HP_1');
				$ID_PROYEK_PEGAWAI = $this->input->post('ID_PROYEK_PEGAWAI');
				$ID_JABATAN_PEGAWAI = $this->input->post('ID_JABATAN_PEGAWAI');
				$ID_DEPARTEMEN_PEGAWAI = $this->input->post('ID_DEPARTEMEN_PEGAWAI');
				$USERNAME = $this->input->post('USERNAME');
				$PASSWORD_UTAMA = $this->input->post('PASSWORD_UTAMA');

				$PASSWORD_UTAMA  = $this->ion_auth->hash_password($PASSWORD_UTAMA);

				if ($ID_JABATAN_PEGAWAI == "3") {
					$ID_DEPARTEMEN_PEGAWAI = "SM";
				}

				if ($ID_JABATAN_PEGAWAI == "3") {
					$this->db->query("UPDATE proyek SET ID_PEGAWAI_SM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
				}

				if ($ID_JABATAN_PEGAWAI == "4") {
					$this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI 'WHERE ID_PROYEK ='$ID_PROYEK_PEGAWAI'");
				}

				$this->Organisasi_model->update_data($ID_PEGAWAI, $NIP, $ID_PROYEK_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI, $NAMA, $EMAIL, $NO_HP_1);

				$hasil=$this->db->query("UPDATE users SET  username='$USERNAME', password='$PASSWORD_UTAMA' WHERE id='$ID_USER'");

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
			$this->form_validation->set_rules('NIP2', 'Nomor Induk Organisasi', 'trim|required');
			$this->form_validation->set_rules('ID_PROYEK_PEGAWAI2', 'Proyek', 'trim|required');
			$this->form_validation->set_rules('ID_DEPARTEMEN_PEGAWAI2', 'Departemen', 'trim|required');
			$this->form_validation->set_rules('NAMA2', 'Nama Lengkap', 'trim|required');
			$this->form_validation->set_rules('EMAIL2', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('NO_HP_12', 'Nomor Handphone Utama', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_PEGAWAI2 = $this->input->post('ID_PEGAWAI2');
				$NIP2 = $this->input->post('NIP2');
				$NIP2_shadow = $this->input->post('NIP2_shadow');
				$ID_PROYEK_PEGAWAI2 = $this->input->post('ID_PROYEK_PEGAWAI2');
				$ID_DEPARTEMEN_PEGAWAI2 = $this->input->post('ID_DEPARTEMEN_PEGAWAI2');
				$NAMA2 = $this->input->post('NAMA2');
				$EMAIL2 = $this->input->post('EMAIL2');
				$EMAIL2 = strtolower($EMAIL2);
				$EMAIL2_shadow = $this->input->post('EMAIL2_shadow');
				$EMAIL2_shadow = strtolower($EMAIL2_shadow);
				$NO_HP_12 = $this->input->post('NO_HP_12');


				if (($NIP2_shadow == $NIP2) || ($this->Organisasi_model->cek_nip($NIP2) == 'Data belum ada')) {

					if (($EMAIL2_shadow == $EMAIL2) || ($this->Organisasi_model->cek_email($EMAIL2) == 'Data belum ada')) {
						$data_awal = $this->Organisasi_model->get_data_by_id($ID_PEGAWAI2);

						//log
						$KETERANGAN = "Ubah Data Organisasi: " . json_encode($data_awal) . " ---- " . $NIP2 . ";" . $ID_PROYEK_PEGAWAI2 . ";" . $ID_DEPARTEMEN_PEGAWAI2 . ";" . $NAMA2 . ";" . $EMAIL2 . ";" . $NO_HP_12;
						$this->user_log($KETERANGAN);

						$data = $this->Organisasi_model->update_data($ID_PEGAWAI2, $NIP2, $ID_PROYEK_PEGAWAI2, $ID_DEPARTEMEN_PEGAWAI2, $NAMA2, $EMAIL2, $NO_HP_12);
						echo json_encode($data);
					} else {
						$pesan = 'Email Organisasi sudah terekam sebelumnya';
						echo json_encode($pesan);
					}
				} else {
					$pesan = 'NIP Organisasi sudah terekam sebelumnya';
					echo json_encode($pesan);
				}
			}
		} else {
			///log the user out
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();
			$id_organisasi = $this->input->post('kode');
			$data_hapus = $this->Organisasi_model->get_data_by_id($id_organisasi);

			$data = $this->Organisasi_model->hapus_data($id_organisasi);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Organisasi: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$user = $this->ion_auth->user()->row();
			$id_organisasi = $this->input->post('kode');
			$data_hapus = $this->Organisasi_model->get_data_by_id($id_organisasi);

			$data = $this->Organisasi_model->hapus_data($id_organisasi);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Organisasi: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$user = $this->ion_auth->user()->row();
			$id_organisasi = $this->input->post('kode');
			$data_hapus = $this->Organisasi_model->get_data_by_id($id_organisasi);

			$data = $this->Organisasi_model->hapus_data($id_organisasi);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Organisasi: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$user = $this->ion_auth->user()->row();
			$id_organisasi = $this->input->post('kode');
			$data_hapus = $this->Organisasi_model->get_data_by_id($id_organisasi);

			$data = $this->Organisasi_model->hapus_data($id_organisasi);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Organisasi: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$user = $this->ion_auth->user()->row();
			$id_organisasi = $this->input->post('kode');
			$data_hapus = $this->Organisasi_model->get_data_by_id($id_organisasi);

			$data = $this->Organisasi_model->hapus_data($id_organisasi);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Organisasi: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$user = $this->ion_auth->user()->row();
			$id_organisasi = $this->input->post('kode');
			$data_hapus = $this->Organisasi_model->get_data_by_id($id_organisasi);

			$data = $this->Organisasi_model->hapus_data($id_organisasi);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Organisasi: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$user = $this->ion_auth->user()->row();
			$id_organisasi = $this->input->post('kode');
			$data_hapus = $this->Organisasi_model->get_data_by_id($id_organisasi);

			$data = $this->Organisasi_model->hapus_data($id_organisasi);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Organisasi: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$user = $this->ion_auth->user()->row();
			$id_organisasi = $this->input->post('kode');
			$data_hapus = $this->Organisasi_model->get_data_by_id($id_organisasi);

			$data = $this->Organisasi_model->hapus_data($id_organisasi);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Organisasi: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$user = $this->ion_auth->user()->row();
			$id_organisasi = $this->input->post('kode');
			$data_hapus = $this->Organisasi_model->get_data_by_id($id_organisasi);

			$data = $this->Organisasi_model->hapus_data($id_organisasi);
			echo json_encode($data);
			$KETERANGAN = "Hapus Data Organisasi: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else {
			///log the user out
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
}
