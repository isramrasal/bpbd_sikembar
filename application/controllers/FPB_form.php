<?php defined('BASEPATH') or exit('No direct script access allowed');

class FPB_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->model('Barang_master_model');
		$this->load->model('FPB_form_model');
		$this->load->model('FPB_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('Proyek_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "FPB_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses FPB Form";
		$WAKTU = date('Y-m-d H:i:s');
		$this->FPB_form_model->user_log_fpb_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{
		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->FPB_form_model->user_log_fpb_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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
		$this->data['username'] = $user->username;
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
		$this->data['role_user'] = $data_role_user['description'];
		$this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
		$this->data['NAMA'] = $data_role_user['NAMA'];
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		date_default_timezone_set('Asia/Jakarta');
		$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

		$this->data['title'] = 'SIPESUT | Ubah FPB';

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_FPB = $this->uri->segment(3);
		if ($this->FPB_model->get_id_fpb_by_HASH_MD5_FPB($HASH_MD5_FPB) == 'TIDAK ADA DATA') {
			redirect('FPB', 'refresh');
		}

		//fungsi ini untuk mengirim data ke dropdown
		$HASH_MD5_FPB = $this->uri->segment(3);
		$hasil = $this->FPB_model->get_id_fpb_by_HASH_MD5_FPB($HASH_MD5_FPB);
		$ID_FPB = $hasil['ID_FPB'];
		$this->data['ID_FPB'] = $ID_FPB;
		$this->data['FPB'] = $this->FPB_model->fpb_list_by_id_fpb($ID_FPB);
		$this->data['CATATAN_FPB'] = $this->FPB_form_model->get_data_catatan_FPB_by_id_fpb($ID_FPB);

		$this->data['rasd_barang_list'] = $this->FPB_form_model->rasd_form_list_where_not_in_fpb($ID_FPB);
		$this->data['barang_master_list'] = $this->FPB_form_model->barang_master_where_not_in_fpb_and_rasd($ID_FPB);
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

		foreach ($this->data['FPB']->result() as $FPB) :
			$this->data['FILE_NAME_TEMP'] = $FPB->FILE_NAME_TEMP;
			$this->data['NO_URUT_FPB'] = $FPB->NO_URUT_FPB;
			$this->data['HASH_MD5_FPB'] = $FPB->HASH_MD5_FPB;
			$this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
			$this->data['PROGRESS_FPB'] = $FPB->PROGRESS_FPB;
			$this->data['ID_PROYEK'] = $FPB->ID_PROYEK;
		endforeach;

		$this->data['PROYEK'] = $this->Proyek_model->detil_proyek_by_ID_PROYEK($this->data['ID_PROYEK']);

		foreach ($this->data['PROYEK']->result() as $PROYEK) :
			$this->data['NAMA_PROYEK'] = $PROYEK->NAMA_PROYEK;
		endforeach;

		$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
        $this->data['ID_DEPARTEMEN_PEGAWAI'] = $data_pegawai['ID_DEPARTEMEN_PEGAWAI'];

		if ($this->ion_auth->logged_in()) {

			if ($this->ion_auth->in_group(2)) { //user_chief_sp

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan Chief") {
					$this->load->view('wasa/user_chief_sp/head_normal', $this->data);
					$this->load->view('wasa/user_chief_sp/user_menu');
					$this->load->view('wasa/user_chief_sp/left_menu');
					$this->load->view('wasa/user_chief_sp/header_menu');
					$this->load->view('wasa/user_chief_sp/content_fpb_form_proses');
					$this->load->view('wasa/user_chief_sp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(3)) { //user_sm_sp

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan SM") {
					$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
					$this->load->view('wasa/user_sm_sp/user_menu');
					$this->load->view('wasa/user_sm_sp/left_menu');
					$this->load->view('wasa/user_sm_sp/header_menu');
					$this->load->view('wasa/user_sm_sp/content_fpb_form_proses');
					$this->load->view('wasa/user_sm_sp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(4)) { //user_pm_sp

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan PM") {
					$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
					$this->load->view('wasa/user_pm_sp/user_menu');
					$this->load->view('wasa/user_pm_sp/left_menu');
					$this->load->view('wasa/user_pm_sp/header_menu');
					$this->load->view('wasa/user_pm_sp/content_fpb_form_proses');
					$this->load->view('wasa/user_pm_sp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(5)) { //user_staff_procurement_kp

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan Staff Proc KP") {
					$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_procurement_kp/user_menu');
					$this->load->view('wasa/user_staff_procurement_kp/left_menu');
					$this->load->view('wasa/user_staff_procurement_kp/header_menu');
					$this->load->view('wasa/user_staff_procurement_kp/content_fpb_form_proses');
					$this->load->view('wasa/user_staff_procurement_kp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(6)) { //user_kasie_procurement_kp

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan Kasie Proc KP") {
					$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
					$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
					$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
					$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
					$this->load->view('wasa/user_kasie_procurement_kp/content_fpb_form_proses');
					$this->load->view('wasa/user_kasie_procurement_kp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(7)) { //user_manajer_procurement_kp

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan Manajer Proc KP") {
					$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
					$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
					$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
					$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
					$this->load->view('wasa/user_manajer_procurement_kp/content_fpb_form_proses');
					$this->load->view('wasa/user_manajer_procurement_kp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(8)) { //user_staff_procurement_sp

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan Staff Proc SP") {
					$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_procurement_sp/user_menu');
					$this->load->view('wasa/user_staff_procurement_sp/left_menu');
					$this->load->view('wasa/user_staff_procurement_sp/header_menu');
					$this->load->view('wasa/user_staff_procurement_sp/content_fpb_form_proses');
					$this->load->view('wasa/user_staff_procurement_sp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(9)) { //user_supervisi_procurement_sp

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan Supervisi Proc SP") {
					$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
					$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
					$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
					$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
					$this->load->view('wasa/user_supervisi_procurement_sp/content_fpb_form_proses');
					$this->load->view('wasa/user_supervisi_procurement_sp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(10)) { //user_staff_umum_logistik_kp

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan Staff Umum Log KP") {
					$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/content_fpb_form_proses');
					$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(11)) { //user_kasie_logistik_kp

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan Kasie Log KP") {
					$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/content_fpb_form_proses');
					$this->load->view('wasa/user_kasie_logistik_kp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(12)) { //SM

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Pembuatan Manajer Log KP") { //user_manajer_logistik_kp
					$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
					$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
					$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
					$this->load->view('wasa/user_manajer_logistik_kp/content_fpb_form_proses');
					$this->load->view('wasa/user_manajer_logistik_kp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(13)) { //STAFF UMUM LOGISTIK SP
				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Staff Logistik") {
					$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/content_fpb_form_proses');
					$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(14)) { //STAFF GUDANG LOGISTIK

				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Staff Logistik") {
					$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
					$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
					$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
					$this->load->view('wasa/user_staff_gudang_logistik_sp/content_fpb_form_proses');
					$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			}
		} else {
			$this->logout();
		}
	}

	public function approval()
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

		$this->data['title'] = 'SIPESUT | Ubah FPB';

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_FPB = $this->uri->segment(3);
		if ($this->FPB_model->get_id_fpb_by_HASH_MD5_FPB($HASH_MD5_FPB) == 'TIDAK ADA DATA') {
			redirect('FPB', 'refresh');
		}

		//fungsi ini untuk mengirim data ke dropdown
		$HASH_MD5_FPB = $this->uri->segment(3);
		$hasil = $this->FPB_model->get_id_fpb_by_HASH_MD5_FPB($HASH_MD5_FPB);
		$ID_FPB = $hasil['ID_FPB'];
		$this->data['ID_FPB'] = $ID_FPB;
		$this->data['FPB'] = $this->FPB_model->fpb_list_by_id_fpb($ID_FPB);
		$this->data['CATATAN_FPB'] = $this->FPB_form_model->get_data_catatan_FPB_by_id_fpb($ID_FPB);

		$this->data['rasd_barang_list'] = $this->FPB_form_model->rasd_form_list_where_not_in_fpb($ID_FPB);
		$this->data['barang_master_list'] = $this->FPB_form_model->barang_master_where_not_in_fpb_and_rasd($ID_FPB);
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

		foreach ($this->data['FPB']->result() as $FPB) :
			$this->data['FILE_NAME_TEMP'] = $FPB->FILE_NAME_TEMP;
			$this->data['NO_URUT_FPB'] = $FPB->NO_URUT_FPB;
			$this->data['HASH_MD5_FPB'] = $FPB->HASH_MD5_FPB;
			$this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
			$this->data['PROGRESS_FPB'] = $FPB->PROGRESS_FPB;
			$this->data['ID_PROYEK'] = $FPB->ID_PROYEK;
		endforeach;

		$this->data['PROYEK'] = $this->Proyek_model->detil_proyek_by_ID_PROYEK($this->data['ID_PROYEK']);

		foreach ($this->data['PROYEK']->result() as $PROYEK) :
			$this->data['NAMA_PROYEK'] = $PROYEK->NAMA_PROYEK;
		endforeach;


		if ($this->ion_auth->logged_in()) {

			if ($this->ion_auth->in_group(2)) { //CHIEF
				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Approval Chief-SM") {
					$this->load->view('wasa/user_chief_sp/head_normal', $this->data);
					$this->load->view('wasa/user_chief_sp/user_menu');
					$this->load->view('wasa/user_chief_sp/left_menu');
					$this->load->view('wasa/user_chief_sp/header_menu');
					$this->load->view('wasa/user_chief_sp/content_fpb_form_proses_approval');
					$this->load->view('wasa/user_chief_sp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(3)) { //SM
				if ($this->data['PROGRESS_FPB'] == "Dalam Proses Approval Chief-SM") {
					$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
					$this->load->view('wasa/user_sm_sp/user_menu');
					$this->load->view('wasa/user_sm_sp/left_menu');
					$this->load->view('wasa/user_sm_sp/header_menu');
					$this->load->view('wasa/user_sm_sp/content_fpb_form_proses_approval');
					$this->load->view('wasa/user_sm_sp/footer');
				} else {
					redirect('FPB', 'refresh');
				}
			}
		} else {
			$this->logout();
		}
	}

	function data_fpb_form()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_fpb_form_tool()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_tool_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_tool_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_tool_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_fpb_form_consumable()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_consumable_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_consumable_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_consumable_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_fpb_form_material()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_material_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_material_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_material_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_fpb_form_jasa_rental()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_jasa_rental_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_jasa_rental_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_jasa_rental_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_fpb_form_appproval()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_approval_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$id = $this->input->get('id');
			$data = $this->FPB_form_model->FPB_form_list_approval_by_id_fpb($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_qty_entitas()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_PROYEK = $this->input->post('ID_PROYEK');
			$data = $this->FPB_form_model->data_quantity_barang_entitas_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_qty_rasd()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$data = $this->FPB_form_model->get_data_quantity_rasd_by_ID_RASD_FORM($ID_RASD_FORM);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
			$ID_FPB_FORM = $this->input->get('id');
			$data = $this->FPB_form_model->get_data_by_id_FPB_form($ID_FPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$ID_FPB_FORM = $this->input->get('id');
			$data = $this->FPB_form_model->get_data_by_id_FPB_form($ID_FPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {
			$ID_FPB_FORM = $this->input->get('id');
			$data = $this->FPB_form_model->get_data_by_id_FPB_form($ID_FPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_catatan_fpb()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
			$ID_FPB = $this->input->get('id');
			$data = $this->FPB_form_model->get_data_catatan_fpb_by_id_fpb($ID_FPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan FPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$ID_FPB = $this->input->get('id');
			$data = $this->FPB_form_model->get_data_catatan_fpb_by_id_fpb($ID_FPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan FPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {
			$ID_FPB = $this->input->get('id');
			$data = $this->FPB_form_model->get_data_catatan_fpb_by_id_fpb($ID_FPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan FPB: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
			$ID_FPB_FORM = $this->input->post('kode');
			$data_hapus = $this->FPB_form_model->get_data_by_id_fpb_form($ID_FPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->FPB_form_model->hapus_data_by_id_fpb_form($ID_FPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$ID_FPB_FORM = $this->input->post('kode');
			$data_hapus = $this->FPB_form_model->get_data_by_id_fpb_form($ID_FPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->FPB_form_model->hapus_data_by_id_fpb_form($ID_FPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) {
			$ID_FPB_FORM = $this->input->post('kode');
			$data_hapus = $this->FPB_form_model->get_data_by_id_fpb_form($ID_FPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->FPB_form_model->hapus_data_by_id_fpb_form($ID_FPB_FORM);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}

	function simpan_data_dari_rasd_form()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_FPB = $this->input->post('ID_FPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->FPB_form_model->simpan_data_dari_rasd_form(
					$ID_FPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data FPB Form (dari RASD): " . ";" . $ID_FPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_FPB = $this->input->post('ID_FPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->FPB_form_model->simpan_data_dari_rasd_form(
					$ID_FPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data FPB Form (dari RASD): " . ";" . $ID_FPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}

	function simpan_data_dari_barang_master()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {

			$ID_FPB = $this->input->post('ID_FPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->FPB_form_model->simpan_data_dari_barang_master(
					$ID_FPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data FPB Form (dari barang master): " . ";" . $ID_FPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {

			$ID_FPB = $this->input->post('ID_FPB');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") {
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->FPB_form_model->simpan_data_dari_barang_master(
					$ID_FPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data FPB Form (dari barang master): " . ";" . $ID_FPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}


	public function simpan_data_di_luar_barang_master()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PAKAI', 'Tanggal Mulai Pemakaian', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI', 'Tanggal Selesai Pemakaian', 'trim|required');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_FPB = $this->input->post('ID_FPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$TANGGAL_MULAI_PAKAI = $this->input->post('TANGGAL_MULAI_PAKAI');
				$TANGGAL_SELESAI_PAKAI = $this->input->post('TANGGAL_SELESAI_PAKAI');

				//check apakah nama FPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->FPB_form_model->cek_nama_barang_fpb_form($NAMA, $ID_FPB) == 'Data belum ada') {
					$data = $this->FPB_form_model->simpan_data_di_luar_barang_master(
						$ID_FPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$PERALATAN_PERLENGKAPAN,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_BARANG,
						$TANGGAL_MULAI_PAKAI,
						$TANGGAL_SELESAI_PAKAI
					);

					$KETERANGAN = "Tambah Data FPB Form (di luar barang master dan RASD): " . ";" . $ID_FPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_BARANG . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PAKAI', 'Tanggal Mulai Pemakaian', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI', 'Tanggal Selesai Pemakaian', 'trim|required');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_FPB = $this->input->post('ID_FPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$TANGGAL_MULAI_PAKAI = $this->input->post('TANGGAL_MULAI_PAKAI');
				$TANGGAL_SELESAI_PAKAI = $this->input->post('TANGGAL_SELESAI_PAKAI');

				//check apakah nama FPB_form sudah ada. jika belum ada, akan disimpan.
				if ($this->FPB_form_model->cek_nama_barang_fpb_form($NAMA, $ID_FPB) == 'Data belum ada') {
					$data = $this->FPB_form_model->simpan_data_di_luar_barang_master(
						$ID_FPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$PERALATAN_PERLENGKAPAN,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_BARANG,
						$TANGGAL_MULAI_PAKAI,
						$TANGGAL_SELESAI_PAKAI
					);

					$KETERANGAN = "Tambah Data FPB Form (di luar barang master dan RASD): " . ";" . $ID_FPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $PERALATAN_PERLENGKAPAN . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_BARANG . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else {
			$this->logout();
		}
	}

	function simpan_tanggal()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {

			//set validation rules
			$this->form_validation->set_rules('TANGGAL_MULAI_PAKAI', 'Tanggal Mulai Pemakaian', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI', 'Tanggal Selesai Pemakaian', 'trim|required');
			$this->form_validation->set_rules('BIDANG_PEMAKAI', 'Bidang Pemakai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');
				$TANGGAL_MULAI_PAKAI = $this->input->post('TANGGAL_MULAI_PAKAI');
				$TANGGAL_SELESAI_PAKAI = $this->input->post('TANGGAL_SELESAI_PAKAI');
				$BIDANG_PEMAKAI = $this->input->post('BIDANG_PEMAKAI');

				$KETERANGAN = "Ubah Data Tanggal Dan Bidang Pemakai Semua Item Barang/Jasa di FPB : " . $ID_FPB . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI . ";" . $BIDANG_PEMAKAI;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->simpan_tanggal($ID_FPB, $TANGGAL_MULAI_PAKAI, $TANGGAL_SELESAI_PAKAI, $BIDANG_PEMAKAI);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {

			//set validation rules
			$this->form_validation->set_rules('TANGGAL_MULAI_PAKAI', 'Tanggal Mulai Pemakaian', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI', 'Tanggal Selesai Pemakaian', 'trim|required');
			$this->form_validation->set_rules('BIDANG_PEMAKAI', 'Bidang Pemakai', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');
				$TANGGAL_MULAI_PAKAI = $this->input->post('TANGGAL_MULAI_PAKAI');
				$TANGGAL_SELESAI_PAKAI = $this->input->post('TANGGAL_SELESAI_PAKAI');
				$BIDANG_PEMAKAI = $this->input->post('BIDANG_PEMAKAI');

				$KETERANGAN = "Ubah Data Tanggal Dan Bidang Pemakai Semua Item Barang/Jasa di FPB : " . $ID_FPB . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI . ";" . $BIDANG_PEMAKAI;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->simpan_tanggal($ID_FPB, $TANGGAL_MULAI_PAKAI, $TANGGAL_SELESAI_PAKAI, $BIDANG_PEMAKAI);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('BIDANG_PEMAKAI', 'Bidang Pemakai', 'required');
			$this->form_validation->set_rules('TANGGAL_MULAI_PAKAI', 'Tanggal Mulai Pemakaian', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI', 'Tanggal Selesai Pemakaian', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$BIDANG_PEMAKAI = $this->input->post('BIDANG_PEMAKAI');
				$TANGGAL_MULAI_PAKAI = $this->input->post('TANGGAL_MULAI_PAKAI');
				$TANGGAL_SELESAI_PAKAI = $this->input->post('TANGGAL_SELESAI_PAKAI');

				$data_edit = $this->FPB_form_model->get_data_by_id_fpb_form($ID_FPB_FORM);
				$KETERANGAN = "Ubah Data FPB Form: " . json_encode($data_edit) . " ---- " . $ID_FPB_FORM . ";" . $JUMLAH_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $BIDANG_PEMAKAI . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data($ID_FPB_FORM, $JUMLAH_BARANG, $PERALATAN_PERLENGKAPAN, $BIDANG_PEMAKAI, $TANGGAL_MULAI_PAKAI, $TANGGAL_SELESAI_PAKAI);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('BIDANG_PEMAKAI', 'Bidang Pemakai', 'required');
			$this->form_validation->set_rules('TANGGAL_MULAI_PAKAI', 'Tanggal Mulai Pemakaian', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI', 'Tanggal Selesai Pemakaian', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$BIDANG_PEMAKAI = $this->input->post('BIDANG_PEMAKAI');
				$TANGGAL_MULAI_PAKAI = $this->input->post('TANGGAL_MULAI_PAKAI');
				$TANGGAL_SELESAI_PAKAI = $this->input->post('TANGGAL_SELESAI_PAKAI');

				$data_edit = $this->FPB_form_model->get_data_by_id_fpb_form($ID_FPB_FORM);
				$KETERANGAN = "Ubah Data FPB Form: " . json_encode($data_edit) . " ---- " . $ID_FPB_FORM . ";" . $JUMLAH_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $BIDANG_PEMAKAI . ";" . $TANGGAL_MULAI_PAKAI . ";" . $TANGGAL_SELESAI_PAKAI;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_by_user_sm($ID_FPB_FORM, $JUMLAH_BARANG, $PERALATAN_PERLENGKAPAN, $BIDANG_PEMAKAI, $TANGGAL_MULAI_PAKAI, $TANGGAL_SELESAI_PAKAI);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PAKAI', 'Tanggal Mulai Pemakaian', 'trim|required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI', 'Tanggal Selesai Pemakaian', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$TANGGAL_MULAI_PAKAI = $this->input->post('TANGGAL_MULAI_PAKAI');
				$TANGGAL_SELESAI_PAKAI = $this->input->post('TANGGAL_SELESAI_PAKAI');

				$data_edit = $this->FPB_form_model->get_data_by_id_fpb_form($ID_FPB_FORM);
				$KETERANGAN = "Ubah Data FPB Form: " . json_encode($data_edit) . " ---- " . $ID_FPB_FORM . ";" . $JUMLAH_BARANG;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data($ID_FPB_FORM, $JUMLAH_BARANG, $TANGGAL_MULAI_PAKAI, $TANGGAL_SELESAI_PAKAI);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_remarks_barang()
	{
		$user = $this->ion_auth->user()->row();
		$user_id = $user->id;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($user_id);
		$NAMA = $data_role_user['NAMA'];

		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('REMARKS_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required|max_length[80]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
				$REMARKS_CHIEF = $this->input->post('REMARKS_CHIEF');

				$REMARKS_CHIEF = "Remarks " . $NAMA .  ": " . $REMARKS_CHIEF;

				$data_edit = $this->FPB_form_model->get_justifikasi_by_id_fpb_form($ID_FPB_FORM);
				$KETERANGAN = "Ubah Data Remarks Barang FPB Form (User CHIEF): " . json_encode($data_edit) . " ---- " . $ID_FPB_FORM . ";" . $REMARKS_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_REMARKS_CHIEF($ID_FPB_FORM, $REMARKS_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('REMARKS_SM', 'Justifikasi Item Barang/Jasa ', 'trim|required|max_length[80]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
				$REMARKS_SM = $this->input->post('REMARKS_SM');

				$REMARKS_SM = "Remarks " . $NAMA .  ": " . $REMARKS_SM;

				$data_edit = $this->FPB_form_model->get_justifikasi_by_id_fpb_form($ID_FPB_FORM);
				$KETERANGAN = "Ubah Data Remarks Barang FPB Form (User SM): " . json_encode($data_edit) . " ---- " . $ID_FPB_FORM . ";" . $REMARKS_SM;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_REMARKS_SM($ID_FPB_FORM, $REMARKS_SM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('REMARKS_STAFF_UMUM_LOGISTIK', 'Remarks Item Barang/Jasa ', 'trim|required|max_length[90]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
				$REMARKS_STAFF_UMUM_LOGISTIK = $this->input->post('REMARKS_STAFF_UMUM_LOGISTIK');

				$REMARKS_STAFF_UMUM_LOGISTIK = "Remarks " . $NAMA .  ": " . $REMARKS_STAFF_UMUM_LOGISTIK;

				$data_edit = $this->FPB_form_model->get_justifikasi_by_id_fpb_form($ID_FPB_FORM);
				$KETERANGAN = "Ubah Data Remarks Barang FPB Form (User STAFF UMUM LOGISTIK): " . json_encode($data_edit) . " ---- " . $ID_FPB_FORM . ";" . $REMARKS_STAFF_UMUM_LOGISTIK;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_REMARKS_STAFF_UMUM_LOGISTIK($ID_FPB_FORM, $REMARKS_STAFF_UMUM_LOGISTIK);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('REMARKS_STAFF_GUDANG_LOGISTIK', 'Remarks Item Barang/Jasa ', 'trim|required|max_length[90]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
				$REMARKS_STAFF_GUDANG_LOGISTIK = $this->input->post('REMARKS_STAFF_GUDANG_LOGISTIK');

				$REMARKS_STAFF_GUDANG_LOGISTIK = "Remarks Log Gudang :" . $REMARKS_STAFF_GUDANG_LOGISTIK;

				$data_edit = $this->FPB_form_model->get_justifikasi_by_id_fpb_form($ID_FPB_FORM);
				$KETERANGAN = "Ubah Data Remarks Barang FPB Form (User STAFF GUDANG LOGISTIK): " . json_encode($data_edit) . " ---- " . $ID_FPB_FORM . ";" . $REMARKS_STAFF_GUDANG_LOGISTIK;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_REMARKS_STAFF_GUDANG_LOGISTIK($ID_FPB_FORM, $REMARKS_STAFF_GUDANG_LOGISTIK);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_catatan_fpb()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_PEMINTA', 'Catatan FPB ', 'trim|required|max_length[150]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');
				$CTT_PEMINTA = $this->input->post('CTT_PEMINTA');

				$data_edit = $this->FPB_form_model->get_data_catatan_fpb_by_id_fpb($ID_FPB);
				$KETERANGAN = "Ubah Data Catatan FPB (User CHIEF): " . json_encode($data_edit) . " ---- " . $ID_FPB . ";" . $CTT_PEMINTA;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_CTT_PEMINTA($ID_FPB, $CTT_PEMINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_PEMINTA', 'Catatan FPB ', 'trim|required|max_length[150]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');
				$CTT_PEMINTA = $this->input->post('CTT_PEMINTA');

				$data_edit = $this->FPB_form_model->get_data_catatan_fpb_by_id_fpb($ID_FPB);
				$KETERANGAN = "Ubah Data Catatan FPB (User SM): " . json_encode($data_edit) . " ---- " . $ID_FPB . ";" . $CTT_PEMINTA;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_CTT_PEMINTA($ID_FPB, $CTT_PEMINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_GUDANG_LOGISTIK', 'Catatan FPB ', 'trim|required|max_length[150]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');
				$CTT_STAFF_GUDANG_LOGISTIK = $this->input->post('CTT_STAFF_GUDANG_LOGISTIK');

				$data_edit = $this->FPB_form_model->get_data_catatan_fpb_by_id_fpb($ID_FPB);
				$KETERANGAN = "Ubah Data Catatan FPB (User Staff Gudang Logistik): " . json_encode($data_edit) . " ---- " . $ID_FPB . ";" . $CTT_STAFF_GUDANG_LOGISTIK;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_CTT_STAFF_GUDANG_LOGISTIK($ID_FPB, $CTT_STAFF_GUDANG_LOGISTIK);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_catatan_fpb_approval()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_CHIEF', 'Catatan FPB ', 'trim|required|max_length[150]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');
				$CTT_CHIEF = $this->input->post('CTT_CHIEF');

				$data_edit = $this->FPB_form_model->get_data_catatan_fpb_by_id_fpb($ID_FPB);
				$KETERANGAN = "Ubah Data Catatan FPB (User CHIEF): " . json_encode($data_edit) . " ---- " . $ID_FPB . ";" . $CTT_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_CTT_CHIEF($ID_FPB, $CTT_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_SM', 'Catatan FPB ', 'trim|required|max_length[150]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');
				$CTT_SM = $this->input->post('CTT_SM');

				$data_edit = $this->FPB_form_model->get_data_catatan_fpb_by_id_fpb($ID_FPB);
				$KETERANGAN = "Ubah Data Catatan FPB (User SM): " . json_encode($data_edit) . " ---- " . $ID_FPB . ";" . $CTT_SM;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_CTT_SM($ID_FPB, $CTT_SM);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_kirim_fpb()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('ID_FPB', 'ID_FPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');

				$PROGRESS_FPB = "Dalam Proses Staff Logistik";
				$STATUS_FPB = "Sedang diproses";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FPB = date("Y-m-d", $d);

				$DATE_SIGN_USER_PEMINTA = date("Y-m-d H:i:s");
				$SIGN_USER_PEMINTA = $DATE_SIGN_USER_PEMINTA;

				//DUE DATE UNTUK STAFF LOGISTIK +1 HARI DARI DATE SIGN PEMINTA
				$date = new DateTime();
				$date->add(new DateInterval('P1D'));
				$DUE_DATE_STAFF_LOGISTIK = $date->format('Y-m-d H:i:s');

				$data = $this->FPB_form_model->update_data_kirim_fpb($ID_FPB, $PROGRESS_FPB, $STATUS_FPB, $TANGGAL_PENGAJUAN_FPB, $SIGN_USER_PEMINTA, $DUE_DATE_STAFF_LOGISTIK);

				$KETERANGAN = "Kirim Form FPB ke Staff Logistik untuk menjadi Diproses Pengecekan Stok: " . " ---- " . $ID_FPB . " ---- " . $PROGRESS_FPB . " ---- " . $STATUS_FPB . " ---- " . $TANGGAL_PENGAJUAN_FPB . " ---- " . $TANGGAL_PENGAJUAN_FPB . " ---- " . $DATE_SIGN_USER_PEMINTA . " ---- " . $SIGN_USER_PEMINTA . " ---- " . $DUE_DATE_STAFF_LOGISTIK;
				$this->user_log($KETERANGAN);

				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('ID_FPB', 'ID_FPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');

				$PROGRESS_FPB = "Dalam Proses Staff Logistik";
				$STATUS_FPB = "Sedang diproses";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FPB = date("Y-m-d", $d);
				$DATE_SIGN_USER_PEMINTA = date("Y-m-d H:i:s");
				$SIGN_USER_PEMINTA = $DATE_SIGN_USER_PEMINTA;

				//DUE DATE UNTUK STAFF LOGISTIK +1 HARI DARI DATE SIGN PEMINTA
				$date = new DateTime();
				$date->add(new DateInterval('P1D'));
				$DUE_DATE_STAFF_LOGISTIK = $date->format('Y-m-d H:i:s');

				$data = $this->FPB_form_model->update_data_kirim_fpb($ID_FPB, $PROGRESS_FPB, $STATUS_FPB, $TANGGAL_PENGAJUAN_FPB, $SIGN_USER_PEMINTA, $DUE_DATE_STAFF_LOGISTIK);

				$KETERANGAN = "Kirim Form FPB ke Staff Logistik untuk menjadi Diproses Pengecekan Stok: " . " ---- " . $ID_FPB . " ---- " . $PROGRESS_FPB . " ---- " . $STATUS_FPB . " ---- " . $TANGGAL_PENGAJUAN_FPB . " ---- " . $TANGGAL_PENGAJUAN_FPB . " ---- " . $DATE_SIGN_USER_PEMINTA . " ---- " . $SIGN_USER_PEMINTA . " ---- " . $DUE_DATE_STAFF_LOGISTIK;
				$this->user_log($KETERANGAN);

				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('ID_FPB', 'ID_FPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');

				$PROGRESS_FPB = "Dalam Proses Approval Chief-SM";
				$STATUS_FPB = "Sedang diproses";

				$DATE_SIGN_STAFF_LOGISTIK = date("Y-m-d H:i:s");
				$SIGN_STAFF_LOGISTIK = $DATE_SIGN_STAFF_LOGISTIK;

				//DUE DATE UNTUK CHIEF DAN SM +1 HARI DARI DATE SIGN PEMINTA
				$date = new DateTime();
				$date->add(new DateInterval('P1D'));
				$DUE_DATE_CHIEF = $date->format('Y-m-d H:i:s');
				$DUE_DATE_SM = $date->format('Y-m-d H:i:s');

				$data = $this->FPB_form_model->update_data_kirim_fpb_STAFF_LOGISTIK($ID_FPB, $PROGRESS_FPB, $STATUS_FPB, $SIGN_STAFF_LOGISTIK, $DUE_DATE_CHIEF, $DUE_DATE_SM);

				$KETERANGAN = "Kirim Form FPB ke SM-CHIEF: " . " ---- " . $ID_FPB . " ---- " . $PROGRESS_FPB . " ---- " . $STATUS_FPB  . " ---- " . $DATE_SIGN_STAFF_LOGISTIK . " ---- " . $SIGN_STAFF_LOGISTIK . " ---- " . $DUE_DATE_SM;
				$this->user_log($KETERANGAN);

				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_gudang_fpb()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('ID_FPB', 'ID_FPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');

				$PROGRESS_FPB = "Dalam Proses Staff Logistik";
				$STATUS_FPB = "Sedang diproses";

				$data = $this->FPB_form_model->update_data_gudang_fpb($ID_FPB, $PROGRESS_FPB, $STATUS_FPB);

				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_kirim_fpb_approval()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) { //CHIEF

			//set validation rules
			$this->form_validation->set_rules('ID_FPB', 'ID_FPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');

				$KETERANGAN = "Kirim Form FPB ke Staff Logistik untuk persiapan barang dan atau pembuatan SPPB: " . " ---- " . $ID_FPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_FPB = "Dalam Proses Staff Logistik (Penyiapan Barang/SPPB)";
				$STATUS_FPB = "Sedang diproses";

				$DATE_SIGN_CHIEF = date("Y-m-d H:i:s");
				$DATE_SIGN_SM = date("Y-m-d H:i:s");

				$SIGN_CHIEF = $DATE_SIGN_CHIEF;
				$SIGN_SM = $DATE_SIGN_SM;

				$data = $this->FPB_form_model->update_data_kirim_fpb_finish($ID_FPB, $PROGRESS_FPB, $STATUS_FPB, $SIGN_CHIEF, $SIGN_SM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) { //SM

			//set validation rules
			$this->form_validation->set_rules('ID_FPB', 'ID_FPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FPB = $this->input->post('ID_FPB');

				$KETERANGAN = "Kirim Form FPB ke Staff Logistik untuk persiapan barang dan atau pembuatan SPPB: " . " ---- " . $ID_FPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_FPB = "Dalam Proses Staff Logistik (Penyiapan Barang/SPPB)";
				$STATUS_FPB = "Sedang diproses";

				$DATE_SIGN_CHIEF = date("Y-m-d H:i:s");
				$DATE_SIGN_SM = date("Y-m-d H:i:s");

				$SIGN_CHIEF = $DATE_SIGN_CHIEF;
				$SIGN_SM = $DATE_SIGN_SM;

				$data = $this->FPB_form_model->update_data_kirim_fpb_finish($ID_FPB, $PROGRESS_FPB, $STATUS_FPB, $SIGN_CHIEF, $SIGN_SM);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_quantity_sppb()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {


			//get the form data
			$ID_FPB = $this->input->post('ID_FPB');
			$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
			$JUMLAH_QTY_SPPB = $this->input->post('JUMLAH_QTY_SPPB');
			$JUMLAH_QTY_GUDANG = $this->input->post('JUMLAH_QTY_GUDANG');

			$data_edit = $this->FPB_form_model->FPB_form_list_by_id_fpb($ID_FPB);
			$KETERANGAN = "Ubah Data FPB Form (User Staff Gudang Logistik): " . json_encode($data_edit) . " ---- JUMLAH QTY SPPB: " . $JUMLAH_QTY_SPPB . ";" .  " ---- JUMLAH QTY GUDANG: " . $JUMLAH_QTY_GUDANG;
			$this->user_log($KETERANGAN);

			$data = $this->FPB_form_model->update_quantity_sppb($ID_FPB_FORM, $JUMLAH_QTY_SPPB, $JUMLAH_QTY_GUDANG);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}


	function update_data_coret()
	{
		$user = $this->ion_auth->user()->row();
		$user_id = $user->id;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($user_id);
		$NAMA = $data_role_user['NAMA'];

		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_FPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Chief): " . " ---- " . $ID_FPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_coret($ID_FPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_FPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User SM): " . " ---- " . $ID_FPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_coret($ID_FPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_batal_coret()
	{
		$user = $this->ion_auth->user()->row();
		$user_id = $user->id;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($user_id);
		$NAMA = $data_role_user['NAMA'];

		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_FPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Chief): " . " ---- " . $ID_FPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_batal_coret($ID_FPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_FPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User SM): " . " ---- " . $ID_FPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->FPB_form_model->update_data_batal_coret($ID_FPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_tanggal()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			$id = $this->input->post('id');
			$field = $this->input->post('field');
			$value = $this->input->post('value');

			$KETERANGAN = "Update Tanggal Mulai Pemakaian (User Chief): " . " ---- " . $id . " ;" . $field . " ;" . $value;
			$this->user_log($KETERANGAN);

			$data = $this->FPB_form_model->update_data_tanggal($id, $field, $value);
			echo ($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			$id = $this->input->post('id');
			$field = $this->input->post('field');
			$value = $this->input->post('value');

			$KETERANGAN = "Update Tanggal Mulai Pemakaian (User Chief): " . " ---- " . $id . " ;" . $field . " ;" . $value;
			$this->user_log($KETERANGAN);

			$data = $this->FPB_form_model->update_data_tanggal($id, $field, $value);
			echo ($data);
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

	// TAMPILAN VIEW ONLY
	public function view()
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

		$this->data['title'] = 'SIPESUT | Form FPB';


		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_FPB = $this->uri->segment(3);
		if ($this->FPB_model->get_id_fpb_by_HASH_MD5_FPB($HASH_MD5_FPB) == 'TIDAK ADA DATA') {
			redirect('FPB', 'refresh');
		}


		if ($this->ion_auth->logged_in()) {

			$this->cetak_pdf($HASH_MD5_FPB);

			$hasil = $this->FPB_model->get_id_fpb_by_HASH_MD5_FPB($HASH_MD5_FPB);
			$ID_FPB = $hasil['ID_FPB'];
			$this->data['ID_FPB'] = $ID_FPB;
			$this->data['FPB'] = $this->FPB_model->fpb_list_by_id_fpb($ID_FPB);

			foreach ($this->data['FPB']->result() as $FPB) :
				$this->data['FILE_NAME_TEMP'] = $FPB->FILE_NAME_TEMP;
				$this->data['NO_URUT_FPB'] = $FPB->NO_URUT_FPB;
				$this->data['HASH_MD5_FPB'] = $FPB->HASH_MD5_FPB;
				$this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
				$this->data['PROGRESS_FPB'] = $FPB->PROGRESS_FPB;
			endforeach;

			if ($this->ion_auth->in_group(2)) { //CHIEF

				$this->load->view('wasa/user_chief_sp/head_normal', $this->data);
				$this->load->view('wasa/user_chief_sp/user_menu');
				$this->load->view('wasa/user_chief_sp/left_menu');
				$this->load->view('wasa/user_chief_sp/header_menu');
				$this->load->view('wasa/user_chief_sp/content_fpb_form');
				$this->load->view('wasa/user_chief_sp/footer');
			} else if ($this->ion_auth->in_group(3)) { //SM

				$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
				$this->load->view('wasa/user_sm_sp/user_menu');
				$this->load->view('wasa/user_sm_sp/left_menu');
				$this->load->view('wasa/user_sm_sp/header_menu');
				$this->load->view('wasa/user_sm_sp/content_fpb_form');
				$this->load->view('wasa/user_sm_sp/footer');
			} else if ($this->ion_auth->in_group(4)) { //user_pm_sp

				$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
				$this->load->view('wasa/user_pm_sp/user_menu');
				$this->load->view('wasa/user_pm_sp/left_menu');
				$this->load->view('wasa/user_pm_sp/header_menu');
				$this->load->view('wasa/user_pm_sp/content_fpb_form');
				$this->load->view('wasa/user_pm_sp/footer');
			} else if ($this->ion_auth->in_group(5)) { //user_staff_procurement_kp

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_fpb_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(6)) { //user_kasie_procurement_kp

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_fpb_form');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(7)) { //user_manajer_procurement_kp

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_fpb_form');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(8)) { //user_staff_procurement_sp

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_fpb_form');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(9)) { //user_supervisi_procurement_sp

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_fpb_form');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(10)) { //user_staff_umum_logistik_kp

				$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/content_fpb_form');
				$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(11)) { //user_kasie_logistik_kp

				$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/content_fpb_form');
				$this->load->view('wasa/user_kasie_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(12)) { //user_manajer_logistik_kp

				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_fpb_form');
				$this->load->view('wasa/user_manajer_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(13)) { //user_staff_umum_logistik_sp

				$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/content_fpb_form');
				$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
			} else if ($this->ion_auth->in_group(14)) { //user_staff_gudang_logistik_sp

				$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/content_fpb_form');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
			} else if ($this->ion_auth->in_group(15)) { //user_supervisi_logistik_sp

				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_fpb_form');
				$this->load->view('wasa/user_supervisi_logistik_sp/footer');
			} else {
				redirect('FPB', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	public function cetak_pdf($HASH_MD5_FPB)
	{
		$hasil = $this->FPB_model->get_id_fpb_by_HASH_MD5_FPB($HASH_MD5_FPB);
		$ID_FPB = $hasil['ID_FPB'];
		$this->data['ID_FPB'] = $ID_FPB;
		$this->data['FPB'] = $this->FPB_model->fpb_list_by_id_fpb($ID_FPB);
		$this->data['CATATAN_FPB'] = $this->FPB_form_model->get_data_catatan_FPB_by_id_fpb($ID_FPB);

		$this->data['rasd_barang_list'] = $this->FPB_form_model->rasd_form_list_where_not_in_fpb($ID_FPB);
		$this->data['barang_master_list'] = $this->FPB_form_model->barang_master_where_not_in_fpb_and_rasd($ID_FPB);
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

		$this->data['konten_FPB_form'] = $this->FPB_form_model->FPB_form_list_by_id_fpb($ID_FPB);
		$this->data['konten_keterangan_barang_FPB_form'] = $this->FPB_form_model->get_data_remaks_barang_by_id_fpb($ID_FPB);
		$this->data['justifikasi_barang'] = $this->FPB_form_model->justifikasi_by_id_fpb($ID_FPB);
		$this->data['USER_PENGAJU'] = $this->FPB_form_model->ID_JABATAN_BY_ID_FPB($ID_FPB);

		foreach ($this->data['FPB']->result() as $FPB) :
			$FILE_NAME_TEMP = $FPB->FILE_NAME_TEMP;
			$this->data['ID_PROYEK'] = $FPB->ID_PROYEK;
			$this->data['ID_FPB'] = $FPB->ID_FPB;
			$this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
			$this->data['TANGGAL_DOKUMEN_FPB'] = $FPB->TANGGAL_DOKUMEN_FPB;
			$this->data['NO_URUT_FPB'] = $FPB->NO_URUT_FPB;
			$this->data['SIGN_USER_PEMINTA'] = $FPB->SIGN_USER_PEMINTA;
			$this->data['SIGN_CHIEF'] = $FPB->SIGN_CHIEF;
			$this->data['SIGN_SM'] = $FPB->SIGN_SM;
			$this->data['SIGN_STAFF_LOGISTIK'] = $FPB->SIGN_STAFF_LOGISTIK;
			$this->data['CTT_PEMINTA'] = $FPB->CTT_PEMINTA;
		endforeach;

		$this->data['ctt_FPB_form'] = $this->FPB_form_model->get_data_catatan_fpb_by_id_fpb_non_result($ID_FPB);
		foreach ($this->data['ctt_FPB_form']->result() as $FPB) :
			$this->data['CTT_PEMINTA'] = $FPB->CTT_PEMINTA;
			$this->data['CTT_STAFF_GUDANG_LOGISTIK'] = $FPB->CTT_STAFF_GUDANG_LOGISTIK;
			$this->data['CTT_CHIEF'] = $FPB->CTT_CHIEF;
			$this->data['CTT_SM'] = $FPB->CTT_SM;
		endforeach;

		$this->data['PROYEK'] = $this->Proyek_model->detil_proyek_by_ID_PROYEK($this->data['ID_PROYEK']);
		foreach ($this->data['PROYEK']->result() as $PROYEK) :
			$this->data['NAMA_PROYEK'] = $PROYEK->NAMA_PROYEK;
		endforeach;

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE
 
        $config['cacheable']    = true; //boolean, the default is true
        $config['cachedir']     = './assets/QR_FPB/cachedir/'; //string, the default is application/cache/
        $config['errorlog']     = './assets/QR_FPB/errorlog/'; //string, the default is application/logs/
        $config['imagedir']     = './assets/QR_FPB/'; //direktori penyimpanan qr code
        $config['quality']      = true; //boolean, the default is true
        $config['size']         = '1024'; //interger, the default is 1024
        $config['black']        = array(224,255,255); // array, default is array(255,255,255)
        $config['white']        = array(70,130,180); // array, default is array(0,0,0)
        $this->ciqrcode->initialize($config);

        $image_name=$HASH_MD5_FPB.'.jpg'; //buat name dari qr code sesuai dengan nim
		$this->data['image_name'] =  $image_name;

		$params['data'] = base_url('index.php/Otentikasi_dokumen/FPB/').$HASH_MD5_FPB; //data yang akan di jadikan QR CODE
        $params['level'] = 'H'; //H=High
        $params['size'] = 10;
        $params['savename'] = FCPATH.$config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		$this->data['GAMBAR_QR'] = 'C:/xampp/htdocs/project_eam/assets/QR_FPB/'.$HASH_MD5_FPB.".jpg";
		$this->data['GAMBAR_QR_2'] = 'C:/xampp/htdocs/project_eam/assets/QR_FPB/'.$HASH_MD5_FPB.".jpg";


		$user = $this->ion_auth->user()->row();
		$this->data['user_id'] = $user->id;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
		$this->data['role_user'] = $data_role_user['description'];

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Form Permintaan Barang';

		// filename dari pdf ketika didownload
		$file_pdf = 'fpb_' . $HASH_MD5_FPB;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "landscape";

		// $html = $this->load->view('wasa/user_chief_sp/laporan_pdf', $this->data, true);
		$html = $this->load->view('wasa/pdf/fpb_pdf', $this->data, true);

		// run dompdf
		$x          = 735;
		$y          = 560;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 10;

		$file_path = "assets/FPB/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}
}
