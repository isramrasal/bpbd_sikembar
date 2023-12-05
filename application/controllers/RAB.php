<?php defined('BASEPATH') or exit('No direct script access allowed');

class RAB extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | RAB';

		$this->load->model('RAB_model');
		$this->load->model('Foto_model');
		$this->load->model('Proyek_model');
		$this->load->model('Organisasi_model');
		$this->load->model('Manajemen_user_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "RAB_aktif";
	}

	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses List RAB";
		$WAKTU = date('Y-m-d H:i:s');
		$this->RAB_model->user_log_rab($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->RAB_model->user_log_rab($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		redirect('proyek', 'refresh');

		// //get data tabel users untuk ditampilkan
		// $user = $this->ion_auth->user()->row();
		// $this->data['user_id'] = $user->id;
		// $this->data['USER_ID'] = $user->id;
		// $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		// $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
		// $this->data['role_user'] = $data_role_user['description'];
		// $this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
		// $this->data['ip_address'] = $user->ip_address;
		// $this->data['email'] = $user->email;
		// $this->data['user_id'] = $user->id;
		// date_default_timezone_set('Asia/Jakarta');
		// $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		// $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		// $this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

		// $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		// if ($query_foto_user == "BELUM ADA FOTO") {
		// 	$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		// } else {
		// 	$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		// }

		// //jika mereka sudah login dan sebagai admin
		// if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

		// 	$this->load->view('wasa/user_admin/head_normal', $this->data);
		// 	$this->load->view('wasa/user_admin/user_menu');
		// 	$this->load->view('wasa/user_admin/left_menu');
		// 	$this->load->view('wasa/user_admin/header_menu');
		// 	$this->load->view('wasa/user_admin/content_RAB');
		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

		// 	$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_staff_procurement_kp/user_menu');
		// 	$this->load->view('wasa/user_staff_procurement_kp/left_menu');
		// 	$this->load->view('wasa/user_staff_procurement_kp/header_menu');
		// 	$this->load->view('wasa/user_staff_procurement_kp/content_RAB');
		// 	$this->load->view('wasa/user_staff_procurement_kp/footer');

		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

		// 	$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
		// 	$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
		// 	$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
		// 	$this->load->view('wasa/user_kasie_procurement_kp/content_RAB');
		// 	$this->load->view('wasa/user_kasie_procurement_kp/footer');

		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

		// 	$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
		// 	$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
		// 	$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
		// 	$this->load->view('wasa/user_manajer_procurement_kp/content_RAB');
		// 	$this->load->view('wasa/user_manajer_procurement_kp/footer');

		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

		// 	//fungsi ini untuk mengirim data ke dropdown
		// 	$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

		// 	$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
		// 	$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

		// 	$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
		// 	$this->session->set_userdata($sess_data);

		// 	$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_staff_procurement_sp/user_menu');
		// 	$this->load->view('wasa/user_staff_procurement_sp/left_menu');
		// 	$this->load->view('wasa/user_staff_procurement_sp/header_menu');
		// 	$this->load->view('wasa/user_staff_procurement_sp/content_RAB');
		// 	$this->load->view('wasa/user_staff_procurement_sp/footer');

		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

		// 	//fungsi ini untuk mengirim data ke dropdown
		// 	$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

		// 	$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
		// 	$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

		// 	$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
		// 	$this->session->set_userdata($sess_data);

		// 	$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
		// 	$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
		// 	$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
		// 	$this->load->view('wasa/user_supervisi_procurement_sp/content_RAB');
		// 	$this->load->view('wasa/user_supervisi_procurement_sp/footer');

		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

		// 	$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
		// 	$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
		// 	$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
		// 	$this->load->view('wasa/user_staff_umum_logistik_kp/content_RAB');
		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

		// 	$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
		// 	$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
		// 	$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
		// 	$this->load->view('wasa/user_kasie_logistik_kp/content_RAB');
		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

		// 	$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
		// 	$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
		// 	$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
		// 	$this->load->view('wasa/user_manajer_logistik_kp/content_RAB');
		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

		// 	//fungsi ini untuk mengirim data ke dropdown
		// 	$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

		// 	$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
		// 	$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

		// 	$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
		// 	$this->session->set_userdata($sess_data);

		// 	$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
		// 	$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
		// 	$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
		// 	$this->load->view('wasa/user_staff_umum_logistik_sp/content_RAB');
		// 	$this->load->view('wasa/user_staff_umum_logistik_sp/footer');

		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

		// 	//fungsi ini untuk mengirim data ke dropdown
		// 	$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

		// 	$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
		// 	$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

		// 	$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
		// 	$this->session->set_userdata($sess_data);

		// 	$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
		// 	$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
		// 	$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
		// 	$this->load->view('wasa/user_staff_gudang_logistik_sp/content_RAB');
		// 	$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
			
		// } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

		// 	//fungsi ini untuk mengirim data ke dropdown
		// 	$this->data['pegawai'] = $this->Organisasi_model->organisasi_list();

		// 	$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
		// 	$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

		// 	$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
		// 	$this->session->set_userdata($sess_data);

		// 	$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
		// 	$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
		// 	$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
		// 	$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
		// 	$this->load->view('wasa/user_supervisi_logistik_sp/content_RAB');
		// 	$this->load->view('wasa/user_supervisi_logistik_sp/footer');
			
		// } else {
		// 	$this->logout();
		// }
	}

	function data_RAB()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$data = $this->RAB_model->RAB_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$data = $this->RAB_model->RAB_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$data = $this->RAB_model->RAB_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$data = $this->RAB_model->RAB_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->RAB_model->RAB_list_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->RAB_model->RAB_list_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$data = $this->RAB_model->RAB_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$data = $this->RAB_model->RAB_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$data = $this->RAB_model->RAB_list();
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->RAB_model->RAB_list_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->RAB_model->RAB_list_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$ID_PROYEK = $this->session->userdata('ID_PROYEK');
			$data = $this->RAB_model->RAB_list_by_id_proyek($ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RAB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_list_rab_by_id_proyek()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $data = $this->RAB_model->get_list_rab_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data RAB: " . json_encode($data);
            $this->user_log($KETERANGAN);
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
