<?php defined('BASEPATH') or exit('No direct script access allowed');

class Nota_pengambilan_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Form NOTA_PENGAMBILAN';

		$this->load->model('Barang_master_model');
		$this->load->model('FPB_form_model');
		$this->load->model('Nota_pengambilan_form_model');
		$this->load->model('Nota_pengambilan_model');
		$this->load->model('Proyek_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('SPPB_Model');
		$this->load->model('SPPB_form_model');
		$this->load->model('SPPB_form_file_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "Nota_pengambilan_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Nota Pengambilan Form";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Nota_pengambilan_form_model->user_log_nota_pengambilan_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Nota_pengambilan_form_model->user_log_nota_pengambilan_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
		if ($this->Nota_pengambilan_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN) == 'TIDAK ADA DATA') {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
			$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$ID_SPPB = $hasil['ID_SPPB'];
			$this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
			$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);

			$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
			$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
			$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
			$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_nota_pengambilan_form_proses');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {//STAFF UMUM LOG KP
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Staff Umum Logistik KP" || "Dalam Proses Pembuatan Staff Umum Logistik KP") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['fpb_barang_list'] = $this->Nota_pengambilan_form_model->fpb_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/content_nota_pengambilan_form_proses');
				$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		}  else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$hasil_2 = $this->Nota_pengambilan_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Staff Umum Logistik KP" || "Dalam Proses Pembuatan Staff Umum Logistik KP") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['fpb_barang_list'] = $this->Nota_pengambilan_form_model->fpb_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/content_nota_pengambilan_form_proses');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {//SUPERVISI LOG SP
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Supervisi Umum Logistik SP" || "Dalam Proses Pembuatan Supervisi Logistik SP") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['fpb_barang_list'] = $this->Nota_pengambilan_form_model->fpb_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_nota_pengambilan_form_proses');
				$this->load->view('wasa/user_supervisi_logistik_sp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Staff Gudang Logistik KP") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$hasil_2 = $this->SPPB_model->get_id_proyek_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$this->data['NAMA_PROYEK'] = $hasil_2['NAMA_PROYEK'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['fpb_barang_list'] = $this->Nota_pengambilan_form_model->fpb_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_gudang_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_gudang_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/content_nota_pengambilan_form_proses');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
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

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
		if ($this->SPPB_model->get_id_proyek_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN) == 'TIDAK ADA DATA') {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Chief") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_chief_sp/head_normal', $this->data);
				$this->load->view('wasa/user_chief_sp/user_menu');
				$this->load->view('wasa/user_chief_sp/left_menu');
				$this->load->view('wasa/user_chief_sp/header_menu');
				$this->load->view('wasa/user_chief_sp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_chief_sp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses SM") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
				$this->load->view('wasa/user_sm_sp/user_menu');
				$this->load->view('wasa/user_sm_sp/left_menu');
				$this->load->view('wasa/user_sm_sp/header_menu');
				$this->load->view('wasa/user_sm_sp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_sm_sp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses PM") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
				$this->load->view('wasa/user_pm_sp/user_menu');
				$this->load->view('wasa/user_pm_sp/left_menu');
				$this->load->view('wasa/user_pm_sp/header_menu');
				$this->load->view('wasa/user_pm_sp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_pm_sp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Staff Logistik KP") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Kasie Logistik KP") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_kasie_logistik_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_manajer_logistik_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Staff Umum Logistik SP") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['fpb_barang_list'] = $this->Nota_pengambilan_form_model->fpb_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Supervisi Logistik SP") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_supervisi_logistik_sp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_hrd_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_hrd_kp/user_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/left_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/header_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_manajer_hrd_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_keuangan_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_keuangan_kp/user_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/left_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/header_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_manajer_keuangan_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_konstruksi_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_konstruksi_kp/user_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/left_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/header_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_manajer_konstruksi_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_sdm_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_sdm_kp/user_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/left_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/header_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_manajer_sdm_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_qaqc_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_qaqc_kp/user_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/left_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/header_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_manajer_qaqc_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_ep_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_ep_kp/user_menu');
				$this->load->view('wasa/user_manajer_ep_kp/left_menu');
				$this->load->view('wasa/user_manajer_ep_kp/header_menu');
				$this->load->view('wasa/user_manajer_ep_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_manajer_ep_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Direksi") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_direktur_keuangan_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_keuangan_kp/user_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/left_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/header_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_direktur_keuangan_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Direksi") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_direktur_psds_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_psds_kp/user_menu');
				$this->load->view('wasa/user_direktur_psds_kp/left_menu');
				$this->load->view('wasa/user_direktur_psds_kp/header_menu');
				$this->load->view('wasa/user_direktur_psds_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_direktur_psds_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Direksi") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_direktur_konstruksi_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_konstruksi_kp/user_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/left_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/header_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_direktur_konstruksi_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_hsse_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_hsse_kp/user_menu');
				$this->load->view('wasa/user_manajer_hsse_kp/left_menu');
				$this->load->view('wasa/user_manajer_hsse_kp/header_menu');
				$this->load->view('wasa/user_manajer_hsse_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_manajer_hsse_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Staff Gudang Logistik KP") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_staff_gudang_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_gudang_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_marketing_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_marketing_kp/user_menu');
				$this->load->view('wasa/user_manajer_marketing_kp/left_menu');
				$this->load->view('wasa/user_manajer_marketing_kp/header_menu');
				$this->load->view('wasa/user_manajer_marketing_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_manajer_marketing_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {
			$hasil_2 = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$PROGRESS_SPPB = $hasil_2['PROGRESS_SPPB'];
			if ($PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
				$hasil = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);
				$this->data['CATATAN_SPPB'] = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;

				$this->data['rasd_barang_list'] = $this->Nota_pengambilan_form_model->rasd_form_list_where_not_in_nota_pengambilan($ID_SPPB);
				$this->data['barang_master_list'] = $this->Nota_pengambilan_form_model->barang_master_where_not_in_nota_pengambilan_and_rasd($ID_SPPB);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

				$this->load->view('wasa/user_manajer_komersial_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_komersial_kp/user_menu');
				$this->load->view('wasa/user_manajer_komersial_kp/left_menu');
				$this->load->view('wasa/user_manajer_komersial_kp/header_menu');
				$this->load->view('wasa/user_manajer_komersial_kp/content_nota_pengambilan_form_proses_approval');
				$this->load->view('wasa/user_manajer_komersial_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	function data_nota_pengambilan_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {
			$id = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_qty_rasd()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(4))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(18))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(21))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(24))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(27))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(30))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(33))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(34))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(35))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(36))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(41))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(42))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(43))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(44))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->Nota_pengambilan_form_model->data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_qty_entitas()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(42))) {
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			$ID_PROYEK = $this->input->post('ID_PROYEK');
			$data = $this->Nota_pengambilan_form_model->data_quantity_barang_entitas_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_PROYEK);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Quantity: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {
			$ID_SPPB_FORM = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(5))) {
		// 	$ID_SPPB_FORM = $this->input->get('id');
		// 	$data = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
		// 	echo json_encode($data);

		// 	$KETERANGAN = "Get Data NOTA_PENGAMBILAN Form: " . json_encode($data);
		// 	$this->user_log($KETERANGAN);
		// } 
		else {
			$this->logout();
		}
	}

	function get_data_catatan_nota_pengambilan()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(5))) {
		// 	$ID_SPPB = $this->input->get('id');
		// 	$data = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
		// 	echo json_encode($data);

		// 	$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
		// 	$this->user_log($KETERANGAN);
		// } 
		else {
			$this->logout();
		}
	}

	function get_data_ctt_nota_pengambilan()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$ID_SPPB = $this->input->get('id');
			$data = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_CHIEF($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_SM($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_PM($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_STAFF_LOG($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_KASIE_LOG($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_M_LOG($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_STAFF_UMUM_LOG($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_SPV_LOG($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_M_HRD($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_M_KEU($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_M_KONS($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_M_SDM($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_M_QAQC($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_M_EP($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_D_KEU($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_D_PSDS($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_D_EP_KONS($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_M_HSSE($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_STAFF_GUDANG_LOG($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_M_MARKETING($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {
			$HASH_MD5_NOTA_PENGAMBILAN = $this->input->get('HASH_MD5_NOTA_PENGAMBILAN');
			$data = $this->SPPB_model->get_data_CTT_M_KOMERSIAL($HASH_MD5_NOTA_PENGAMBILAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
			$this->user_log($KETERANGAN);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(5))) {
		// 	$ID_SPPB = $this->input->get('id');
		// 	$data = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
		// 	echo json_encode($data);

		// 	$KETERANGAN = "Get Data Catatan NOTA_PENGAMBILAN: " . json_encode($data);
		// 	$this->user_log($KETERANGAN);
		// } 
		else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$ID_FPB_FORM = $data_hapus['ID_FPB_FORM'];
			if ($ID_FPB_FORM != "" || $ID_FPB_FORM != null) {
				//UPDATE STATUS NOTA_PENGAMBILAN RECORD KE TABEL FPB FORM
				$this->FPB_form_model->update_delete_status_nota_pengambilan_by_id_fpb_form($ID_FPB_FORM);
			}

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$ID_FPB_FORM = $data_hapus['ID_FPB_FORM'];
			if ($ID_FPB_FORM != "" || $ID_FPB_FORM != null) {
				//UPDATE STATUS NOTA_PENGAMBILAN RECORD KE TABEL FPB FORM
				$this->FPB_form_model->update_delete_status_nota_pengambilan_by_id_fpb_form($ID_FPB_FORM);
			}

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$ID_FPB_FORM = $data_hapus['ID_FPB_FORM'];
			if ($ID_FPB_FORM != "" || $ID_FPB_FORM != null) {
				//UPDATE STATUS NOTA_PENGAMBILAN RECORD KE TABEL FPB FORM
				$this->FPB_form_model->update_delete_status_nota_pengambilan_by_id_fpb_form($ID_FPB_FORM);
			}

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$ID_FPB_FORM = $data_hapus['ID_FPB_FORM'];
			if ($ID_FPB_FORM != "" || $ID_FPB_FORM != null) {
				//UPDATE STATUS NOTA_PENGAMBILAN RECORD KE TABEL FPB FORM
				$this->FPB_form_model->update_delete_status_nota_pengambilan_by_id_fpb_form($ID_FPB_FORM);
			}

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
			$ID_SPPB_FORM = $this->input->post('kode');
			$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(5))) {
		// 	$ID_SPPB_FORM = $this->input->post('kode');
		// 	$data_hapus = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);

		// 	$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
		// 	$this->user_log($KETERANGAN);

		// 	$data = $this->Nota_pengambilan_form_model->hapus_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
		// 	echo json_encode($data);
		// } 
		else {
			$this->logout();
		}
	}

	function simpan_data_dari_fpb_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_FPB_FORM as $index => $ID_FPB_FORM) {
				$data = $this->FPB_form_model->FPB_form_list_by_id_fpb_form($ID_FPB_FORM);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}

				if ($data->NAMA_BARANG_MASTER != "") {
					$nama_barang = $data->NAMA_BARANG_MASTER;
				} else {
					$nama_barang = $data->NAMA_BARANG;
				}

				if ($data->MEREK_MASTER != "") {
					$merek = $data->MEREK_MASTER;
				} else {
					$merek = $data->MEREK;
				}

				if ($data->SPESIFIKASI_SINGKAT_MASTER != "") {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT_MASTER;
				} else {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT;
				}

				$ID_RASD_FORM = $data->ID_RASD_FORM;

				$TANGGAL_MULAI_PAKAI_HARI = $data->TANGGAL_MULAI_PAKAI;
				$TANGGAL_SELESAI_PAKAI_HARI = $data->TANGGAL_SELESAI_PAKAI;

				//SIMPAN KE TABEL NOTA_PENGAMBILAN FORM
				$this->Nota_pengambilan_form_model->simpan_data_dari_fpb_form(
					$ID_SPPB,
					$ID_FPB_FORM,
					$ID_RASD_FORM,
					$id_master,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$nama_barang,
					$merek,
					$spesifikasi_singkat,
					$data->JUMLAH_QTY_SPPB,
					$TANGGAL_MULAI_PAKAI_HARI,
					$TANGGAL_SELESAI_PAKAI_HARI
				);

				//UPDATE STATUS NOTA_PENGAMBILAN RECORD KE TABEL FPB FORM
				$this->FPB_form_model->update_status_nota_pengambilan_by_id_fpb_form($ID_FPB_FORM, $ID_SPPB);


				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari FPB): " . ";" . $ID_SPPB . ";" . $ID_FPB_FORM . ";" . $id_master . ";" . $ID_FPB_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $nama_barang . ";" . $merek . ";" . $spesifikasi_singkat . ";" . $data->JUMLAH_QTY_SPPB;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_FPB_FORM as $index => $ID_FPB_FORM) {
				$data = $this->FPB_form_model->FPB_form_list_by_id_fpb_form($ID_FPB_FORM);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}

				if ($data->NAMA_BARANG_MASTER != "") {
					$nama_barang = $data->NAMA_BARANG_MASTER;
				} else {
					$nama_barang = $data->NAMA_BARANG;
				}

				if ($data->MEREK_MASTER != "") {
					$merek = $data->MEREK_MASTER;
				} else {
					$merek = $data->MEREK;
				}

				if ($data->SPESIFIKASI_SINGKAT_MASTER != "") {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT_MASTER;
				} else {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT;
				}

				$ID_RASD_FORM = $data->ID_RASD_FORM;

				$TANGGAL_MULAI_PAKAI_HARI = $data->TANGGAL_MULAI_PAKAI;
				$TANGGAL_SELESAI_PAKAI_HARI = $data->TANGGAL_SELESAI_PAKAI;

				//SIMPAN KE TABEL NOTA_PENGAMBILAN FORM
				$this->Nota_pengambilan_form_model->simpan_data_dari_fpb_form(
					$ID_SPPB,
					$ID_FPB_FORM,
					$ID_RASD_FORM,
					$id_master,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$nama_barang,
					$merek,
					$spesifikasi_singkat,
					$data->JUMLAH_QTY_SPPB,
					$TANGGAL_MULAI_PAKAI_HARI,
					$TANGGAL_SELESAI_PAKAI_HARI
				);

				//UPDATE STATUS NOTA_PENGAMBILAN RECORD KE TABEL FPB FORM
				$this->FPB_form_model->update_status_nota_pengambilan_by_id_fpb_form($ID_FPB_FORM, $ID_SPPB);


				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari FPB): " . ";" . $ID_SPPB . ";" . $ID_FPB_FORM . ";" . $id_master . ";" . $ID_FPB_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $nama_barang . ";" . $merek . ";" . $spesifikasi_singkat . ";" . $data->JUMLAH_QTY_SPPB;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_FPB_FORM as $index => $ID_FPB_FORM) {
				$data = $this->FPB_form_model->FPB_form_list_by_id_fpb_form($ID_FPB_FORM);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}

				if ($data->NAMA_BARANG_MASTER != "") {
					$nama_barang = $data->NAMA_BARANG_MASTER;
				} else {
					$nama_barang = $data->NAMA_BARANG;
				}

				if ($data->MEREK_MASTER != "") {
					$merek = $data->MEREK_MASTER;
				} else {
					$merek = $data->MEREK;
				}

				if ($data->SPESIFIKASI_SINGKAT_MASTER != "") {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT_MASTER;
				} else {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT;
				}

				$ID_RASD_FORM = $data->ID_RASD_FORM;

				$TANGGAL_MULAI_PAKAI_HARI = $data->TANGGAL_MULAI_PAKAI;
				$TANGGAL_SELESAI_PAKAI_HARI = $data->TANGGAL_SELESAI_PAKAI;

				//SIMPAN KE TABEL NOTA_PENGAMBILAN FORM
				$this->Nota_pengambilan_form_model->simpan_data_dari_fpb_form(
					$ID_SPPB,
					$ID_FPB_FORM,
					$ID_RASD_FORM,
					$id_master,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$nama_barang,
					$merek,
					$spesifikasi_singkat,
					$data->JUMLAH_QTY_SPPB,
					$TANGGAL_MULAI_PAKAI_HARI,
					$TANGGAL_SELESAI_PAKAI_HARI
				);

				//UPDATE STATUS NOTA_PENGAMBILAN RECORD KE TABEL FPB FORM
				$this->FPB_form_model->update_status_nota_pengambilan_by_id_fpb_form($ID_FPB_FORM, $ID_SPPB);


				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari FPB): " . ";" . $ID_SPPB . ";" . $ID_FPB_FORM . ";" . $id_master . ";" . $ID_FPB_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $nama_barang . ";" . $merek . ";" . $spesifikasi_singkat . ";" . $data->JUMLAH_QTY_SPPB;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_FPB_FORM as $index => $ID_FPB_FORM) {
				$data = $this->FPB_form_model->FPB_form_list_by_id_fpb_form($ID_FPB_FORM);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}

				if ($data->NAMA_BARANG_MASTER != "") {
					$nama_barang = $data->NAMA_BARANG_MASTER;
				} else {
					$nama_barang = $data->NAMA_BARANG;
				}

				if ($data->MEREK_MASTER != "") {
					$merek = $data->MEREK_MASTER;
				} else {
					$merek = $data->MEREK;
				}

				if ($data->SPESIFIKASI_SINGKAT_MASTER != "") {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT_MASTER;
				} else {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT;
				}

				$ID_RASD_FORM = $data->ID_RASD_FORM;

				$TANGGAL_MULAI_PAKAI_HARI = $data->TANGGAL_MULAI_PAKAI;
				$TANGGAL_SELESAI_PAKAI_HARI = $data->TANGGAL_SELESAI_PAKAI;

				//SIMPAN KE TABEL NOTA_PENGAMBILAN FORM
				$this->Nota_pengambilan_form_model->simpan_data_dari_fpb_form(
					$ID_SPPB,
					$ID_FPB_FORM,
					$ID_RASD_FORM,
					$id_master,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$nama_barang,
					$merek,
					$spesifikasi_singkat,
					$data->JUMLAH_QTY_SPPB,
					$TANGGAL_MULAI_PAKAI_HARI,
					$TANGGAL_SELESAI_PAKAI_HARI
				);

				//UPDATE STATUS NOTA_PENGAMBILAN RECORD KE TABEL FPB FORM
				$this->FPB_form_model->update_status_nota_pengambilan_by_id_fpb_form($ID_FPB_FORM, $ID_SPPB);


				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari FPB): " . ";" . $ID_SPPB . ";" . $ID_FPB_FORM . ";" . $id_master . ";" . $ID_FPB_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $nama_barang . ";" . $merek . ";" . $spesifikasi_singkat . ";" . $data->JUMLAH_QTY_SPPB;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$ID_FPB_FORM = $this->input->post('ID_FPB_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_FPB_FORM as $index => $ID_FPB_FORM) {
				$data = $this->FPB_form_model->FPB_form_list_by_id_fpb_form($ID_FPB_FORM);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}

				if ($data->NAMA_BARANG_MASTER != "") {
					$nama_barang = $data->NAMA_BARANG_MASTER;
				} else {
					$nama_barang = $data->NAMA_BARANG;
				}

				if ($data->MEREK_MASTER != "") {
					$merek = $data->MEREK_MASTER;
				} else {
					$merek = $data->MEREK;
				}

				if ($data->SPESIFIKASI_SINGKAT_MASTER != "") {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT_MASTER;
				} else {
					$spesifikasi_singkat = $data->SPESIFIKASI_SINGKAT;
				}

				$ID_RASD_FORM = $data->ID_RASD_FORM;

				$TANGGAL_MULAI_PAKAI_HARI = $data->TANGGAL_MULAI_PAKAI;
				$TANGGAL_SELESAI_PAKAI_HARI = $data->TANGGAL_SELESAI_PAKAI;

				//SIMPAN KE TABEL NOTA_PENGAMBILAN FORM
				$this->Nota_pengambilan_form_model->simpan_data_dari_fpb_form(
					$ID_SPPB,
					$ID_FPB_FORM,
					$ID_RASD_FORM,
					$id_master,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$nama_barang,
					$merek,
					$spesifikasi_singkat,
					$data->JUMLAH_QTY_SPPB,
					$TANGGAL_MULAI_PAKAI_HARI,
					$TANGGAL_SELESAI_PAKAI_HARI
				);

				//UPDATE STATUS NOTA_PENGAMBILAN RECORD KE TABEL FPB FORM
				$this->FPB_form_model->update_status_nota_pengambilan_by_id_fpb_form($ID_FPB_FORM, $ID_SPPB);


				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari FPB): " . ";" . $ID_SPPB . ";" . $ID_FPB_FORM . ";" . $id_master . ";" . $ID_FPB_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $nama_barang . ";" . $merek . ";" . $spesifikasi_singkat . ";" . $data->JUMLAH_QTY_SPPB;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}

	function simpan_data_dari_rasd_form()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$ID_SPPB = $this->input->post('ID_SPPB');
			foreach ($ID_RASD_FORM as $index => $value_rasd) {
				$data = $this->RASD_form_model->rasd_form_list_by_id_rasd_form($value_rasd);
				if ($data->ID_BARANG_MASTER == "") {
					$id_master = 'NULL';
				} else {
					$id_master = $data->ID_BARANG_MASTER;
				}
				$jumlah = $this->input->post($value_rasd);
				$this->Nota_pengambilan_form_model->simpan_data_dari_rasd_form(
					$ID_SPPB,
					$id_master,
					$value_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);

				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari RASD): " . ";" . $ID_SPPB . ";" . $id_master . ";" . $value_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}

	function simpan_data_dari_barang_master()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {

			$ID_SPPB = $this->input->post('ID_SPPB');
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
				$this->Nota_pengambilan_form_model->simpan_data_dari_barang_master(
					$ID_SPPB,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->SPESIFIKASI_SINGKAT,
					$jumlah
				);
				$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (dari barang master): " . ";" . $ID_SPPB . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}

	function simpan_data_di_luar_barang_master()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required|max_length[30]');
			$this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SPPB = $this->input->post('ID_SPPB');
				$ID_JENIS_BARANG = $this->input->post('JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$ID_BARANG_MASTER = 'NULL';
				$ID_RASD_FORM = 'NULL';
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				//check apakah nama Nota_pengambilan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Nota_pengambilan_form_model->cek_nama_barang_nota_pengambilan_form($NAMA) == 'Data belum ada') {
					$data = $this->Nota_pengambilan_form_model->simpan_data_di_luar_barang_master(
						$ID_SPPB,
						$ID_BARANG_MASTER,
						$ID_RASD_FORM,
						$ID_SATUAN_BARANG,
						$ID_JENIS_BARANG,
						$NAMA,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$JUMLAH_MINTA
					);

					$KETERANGAN = "Tambah Data NOTA_PENGAMBILAN Form (di luar barang master dan RASD): " . ";" . $ID_SPPB . ";" . $ID_BARANG_MASTER . ";" . $ID_RASD_FORM . ";" . $ID_SATUAN_BARANG . ";" . $ID_JENIS_BARANG . ";" . $NAMA . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $JUMLAH_MINTA;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya';
				}
			}
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			
			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PAKAI_HARI', 'Tanggal Mulai Pakai', 'required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI_HARI', 'Tanggal Selesai Pakai', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');
				$TANGGAL_MULAI_PAKAI_HARI = $this->input->post('TANGGAL_MULAI_PAKAI_HARI');
				$TANGGAL_SELESAI_PAKAI_HARI = $this->input->post('TANGGAL_SELESAI_PAKAI_HARI');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA. ";". $TANGGAL_MULAI_PAKAI_HARI . ";" . $TANGGAL_SELESAI_PAKAI_HARI;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA, $TANGGAL_MULAI_PAKAI_HARI, $TANGGAL_SELESAI_PAKAI_HARI);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');
				$JUMLAH_SETUJU_M_LOG = $this->input->post('JUMLAH_SETUJU_M_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				// $JUMLAH_SETUJU_M_LOG = $JUMLAH_SETUJU_M_LOG;

				$data = $this->Nota_pengambilan_form_model->update_data_M_LOG($ID_SPPB_FORM, $JUMLAH_MINTA, $JUMLAH_SETUJU_M_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');
				$JUMLAH_SETUJU_M_LOG = $this->input->post('JUMLAH_SETUJU_M_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				// $JUMLAH_SETUJU_M_LOG = $JUMLAH_SETUJU_M_LOG;

				$data = $this->Nota_pengambilan_form_model->update_data_M_LOG($ID_SPPB_FORM, $JUMLAH_MINTA, $JUMLAH_SETUJU_M_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PAKAI_HARI', 'Tanggal Mulai Pakai', 'required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI_HARI', 'Tanggal Selesai Pakai', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');
				$TANGGAL_MULAI_PAKAI_HARI = $this->input->post('TANGGAL_MULAI_PAKAI_HARI');
				$TANGGAL_SELESAI_PAKAI_HARI = $this->input->post('TANGGAL_SELESAI_PAKAI_HARI');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA. ";". $TANGGAL_MULAI_PAKAI_HARI . ";" . $TANGGAL_SELESAI_PAKAI_HARI;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA, $TANGGAL_MULAI_PAKAI_HARI, $TANGGAL_SELESAI_PAKAI_HARI);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('TANGGAL_MULAI_PAKAI_HARI', 'Tanggal Mulai Pakai', 'required');
			$this->form_validation->set_rules('TANGGAL_SELESAI_PAKAI_HARI', 'Tanggal Selesai Pakai', 'required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');
				$TANGGAL_MULAI_PAKAI_HARI = $this->input->post('TANGGAL_MULAI_PAKAI_HARI');
				$TANGGAL_SELESAI_PAKAI_HARI = $this->input->post('TANGGAL_SELESAI_PAKAI_HARI');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA. ";". $TANGGAL_MULAI_PAKAI_HARI . ";" . $TANGGAL_SELESAI_PAKAI_HARI;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA, $TANGGAL_MULAI_PAKAI_HARI, $TANGGAL_SELESAI_PAKAI_HARI);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data($ID_SPPB_FORM, $JUMLAH_MINTA);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Barang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');
				$JUMLAH_SETUJU_M_LOG = $this->input->post('JUMLAH_SETUJU_M_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data NOTA_PENGAMBILAN Form: " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUMLAH_MINTA;
				$this->user_log($KETERANGAN);

				// $JUMLAH_SETUJU_M_LOG = $JUMLAH_SETUJU_M_LOG;

				$data = $this->Nota_pengambilan_form_model->update_data_M_LOG($ID_SPPB_FORM, $JUMLAH_MINTA, $JUMLAH_SETUJU_M_LOG);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_justifikasi_barang()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG5', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_justifikasi_barang($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_SVP_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_SVP_LOG = $this->input->post('JUSTIFIKASI_SVP_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_SVP_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_SVP_LOG($ID_SPPB_FORM, $JUSTIFIKASI_SVP_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_CHIEF', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_CHIEF = $this->input->post('JUSTIFIKASI_CHIEF');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_SDM', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_SDM = $this->input->post('JUSTIFIKASI_SDM');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Manajer SDM): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_SDM;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_SDM($ID_SPPB_FORM, $JUSTIFIKASI_SDM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			//set validation rules
			$this->form_validation->set_rules('JUSTIFIKASI_STAFF_LOG', 'Justifikasi Item Barang/Jasa ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				$JUSTIFIKASI_STAFF_LOG = $this->input->post('JUSTIFIKASI_STAFF_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_justifikasi_by_id_nota_pengambilan_form($ID_SPPB_FORM);
				$KETERANGAN = "Ubah Data JUSTIFIKASI NOTA_PENGAMBILAN Form (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB_FORM . ";" . $JUSTIFIKASI_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_catatan_nota_pengambilan()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_LOG', 'Catatan NOTA_PENGAMBILAN ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_STAFF_LOG = $this->input->post('CTT_STAFF_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Staff logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_catatan_nota_pengambilan($ID_SPPB, $CTT_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) { //CHIEF SP

			//set validation rules
			$this->form_validation->set_rules('CTT_CHIEF', 'Catatan NOTA_PENGAMBILAN CHIEF', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_CHIEF = $this->input->post('CTT_CHIEF');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User CHIEF): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_CHIEF;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_CHIEF($ID_SPPB, $CTT_CHIEF);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) { //SM SP

			//set validation rules
			$this->form_validation->set_rules('CTT_SM', 'Catatan NOTA_PENGAMBILAN SM', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_SM = $this->input->post('CTT_SM');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User SM): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_SM;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_SM($ID_SPPB, $CTT_SM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) { //PM SP

			//set validation rules
			$this->form_validation->set_rules('CTT_PM', 'Catatan NOTA_PENGAMBILAN PM', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_PM = $this->input->post('CTT_PM');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User PM): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_PM;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_PM($ID_SPPB, $CTT_PM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) { //STAFF PROC KP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) { //KASIE PROC KP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) { //MAN PROC KP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) { //STAFF PROC SP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) { //SUPERVISI PROC KP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) { //STAFF LOG KP

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_LOG', 'Catatan NOTA_PENGAMBILAN', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_STAFF_LOG = $this->input->post('CTT_STAFF_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Staff Logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_STAFF_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_STAFF_LOG($ID_SPPB, $CTT_STAFF_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) { //KASIE LOG KP

			//set validation rules
			$this->form_validation->set_rules('CTT_KASIE_LOG', 'Catatan NOTA_PENGAMBILAN Kasie Logistik', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_KASIE_LOG = $this->input->post('CTT_KASIE_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Kasie Logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_KASIE_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_KASIE_LOG($ID_SPPB, $CTT_KASIE_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) { //MAN LOG KP

			//set validation rules
			$this->form_validation->set_rules('CTT_M_LOG', 'Catatan NOTA_PENGAMBILAN Manajer Logistik', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_LOG = $this->input->post('CTT_M_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Manajer Logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_M_LOG($ID_SPPB, $CTT_M_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) { //STAFF UMUM LOG SP

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_UMUM_LOG', 'Catatan NOTA_PENGAMBILAN Staff Umum Logistik', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_STAFF_UMUM_LOG = $this->input->post('CTT_STAFF_UMUM_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Staff Umum Logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_STAFF_UMUM_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_STAFF_UMUM_LOG($ID_SPPB, $CTT_STAFF_UMUM_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) { //STAFF GUDANG LOG SP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) { //SUPERVISI LOGISTIK SP

			//set validation rules
			$this->form_validation->set_rules('CTT_SPV_LOG', 'Catatan NOTA_PENGAMBILAN Supervisi Logistik', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_SPV_LOG = $this->input->post('CTT_SPV_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Supervisi Logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_SPV_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_SPV_LOG($ID_SPPB, $CTT_SPV_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) { //MAN HRD KP

			//set validation rules
			$this->form_validation->set_rules('CTT_M_HRD', 'Catatan NOTA_PENGAMBILAN Manajer HRD', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_HRD = $this->input->post('CTT_M_HRD');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Manajer HRD): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_HRD;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_M_HRD($ID_SPPB, $CTT_M_HRD);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) { //MAN KEU KP

			//set validation rules
			$this->form_validation->set_rules('CTT_M_KEU', 'Catatan NOTA_PENGAMBILAN Manajer Keuangan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_KEU = $this->input->post('CTT_M_KEU');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Manajer Keuangan): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_KEU;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_M_KEU($ID_SPPB, $CTT_M_KEU);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) { //MAN KONS KP

			//set validation rules
			$this->form_validation->set_rules('CTT_M_KONS', 'Catatan NOTA_PENGAMBILAN Manajer Konstruksi', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_KONS = $this->input->post('CTT_M_KONS');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Manajer Konstruksi): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_KONS;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_M_KONS($ID_SPPB, $CTT_M_KONS);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) { //MAN SDM KP

			//set validation rules
			$this->form_validation->set_rules('CTT_M_SDM', 'Catatan NOTA_PENGAMBILAN Manajer SDM', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_SDM = $this->input->post('CTT_M_SDM');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Manajer SDM): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_SDM;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_M_SDM($ID_SPPB, $CTT_M_SDM);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) { //MAN QAQC KP

			//set validation rules
			$this->form_validation->set_rules('CTT_M_QAQC', 'Catatan NOTA_PENGAMBILAN Manajer QAQC', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_QAQC = $this->input->post('CTT_M_QAQC');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Manajer QAQC): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_QAQC;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_M_QAQC($ID_SPPB, $CTT_M_QAQC);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) { //MAN EP KP

			//set validation rules
			$this->form_validation->set_rules('CTT_M_EP', 'Catatan NOTA_PENGAMBILAN Manajer EP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_EP = $this->input->post('CTT_M_EP');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Manajer EP): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_EP;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_M_EP($ID_SPPB, $CTT_M_EP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) { //DIR KEU KP

			//set validation rules
			$this->form_validation->set_rules('CTT_D_KEU', 'Catatan NOTA_PENGAMBILAN Direktur Keuangan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_D_KEU = $this->input->post('CTT_D_KEU');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Direktur Keuangan): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_D_KEU;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_D_KEU($ID_SPPB, $CTT_D_KEU);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) { //DIR PSDS KP

			//set validation rules
			$this->form_validation->set_rules('CTT_D_PSDS', 'Catatan NOTA_PENGAMBILAN Direktur PSDS', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_D_PSDS = $this->input->post('CTT_D_PSDS');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Direktur PSDS): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_D_PSDS;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_D_PSDS($ID_SPPB, $CTT_D_PSDS);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) { //DIR EP & KONS KP

			//set validation rules
			$this->form_validation->set_rules('CTT_D_EP_KONS', 'Catatan NOTA_PENGAMBILAN Direktur EP dan Konstruksi', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_D_EP_KONS = $this->input->post('CTT_D_EP_KONS');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Direktur EP dan Konstruksi): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_D_EP_KONS;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_D_EP_KONS($ID_SPPB, $CTT_D_EP_KONS);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) { //MAN HSSE KP

			//set validation rules
			$this->form_validation->set_rules('CTT_M_HSSE', 'Catatan NOTA_PENGAMBILAN Manajer HSSE', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_HSSE = $this->input->post('CTT_M_HSSE');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Manajer HSSE): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_HSSE;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_M_HSSE($ID_SPPB, $CTT_M_HSSE);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) { //STAFF GUDANG LOG KP

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_GUDANG_LOG', 'Catatan NOTA_PENGAMBILAN Staff Gudang Logistik', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_STAFF_GUDANG_LOG = $this->input->post('CTT_STAFF_GUDANG_LOG');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Staff Gudang Logistik): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_STAFF_GUDANG_LOG;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_STAFF_GUDANG_LOG($ID_SPPB, $CTT_STAFF_GUDANG_LOG);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) { //MAN MARKETING KP

			//set validation rules
			$this->form_validation->set_rules('CTT_M_MARKETING', 'Catatan NOTA_PENGAMBILAN Manajer Marketing', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_MARKETING = $this->input->post('CTT_M_MARKETING');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Manajer Marketing): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_MARKETING;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_M_MARKETING($ID_SPPB, $CTT_M_MARKETING);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) { //MAN KOMERSIAL KP

			//set validation rules
			$this->form_validation->set_rules('CTT_M_KOMERSIAL', 'Catatan NOTA_PENGAMBILAN Manajer Komersial', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');
				$CTT_M_KOMERSIAL = $this->input->post('CTT_M_KOMERSIAL');

				$data_edit = $this->Nota_pengambilan_form_model->get_data_catatan_nota_pengambilan_by_id_nota_pengambilan($ID_SPPB);
				$KETERANGAN = "Ubah Data Catatan NOTA_PENGAMBILAN (User Manajer Komersial): " . json_encode($data_edit) . " ---- " . $ID_SPPB . ";" . $CTT_M_KOMERSIAL;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_CTT_M_KOMERSIAL($ID_SPPB, $CTT_M_KOMERSIAL);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_kirim_nota_pengambilan()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Chief (User Staff logistik): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Chief";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) { //Chief sp


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke SM (User Chief): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses SM";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) { //SM SP


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke PM (User SM): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses PM";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) { //PM SP

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN Staff Logistik KP (User PM): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Staff Logistik KP";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) { //STAFF PROC KP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) { //KASIE PROC KP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) { //MAN PROC KP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) { //STAFF PROC SP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) { //SUPERVISI PROC KP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) { //STAFF UMUM LOG KP

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Staff Gudang Logistik KP (User Staff Supervisi Logistik): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Staff Gudang Logistik KP";
				$STATUS_SPPB = "Proses Pengajuan";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FPB = date("Y-m-d", $d);

				$DATE_SIGN_USER_STAFF_UMUM_LOG_KP = date("Y-m-d H:i:s");
				$SIGN_USER_STAFF_UMUM_LOG_KP = "Diajukan pada tanggal: " . $DATE_SIGN_USER_STAFF_UMUM_LOG_KP;

				//DUE DATE UNTUK STAFF GUDANG LOGISTIK +1 HARI
				$date = new DateTime();
				$date->add(new DateInterval('P1D'));
				$DUE_DATE_STAFF_GUDANG_LOG_KP = $date->format('Y-m-d H:i:s');

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan_user_staff_umum_logistik_kp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_STAFF_UMUM_LOG_KP);
				echo json_encode($data);

			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) { //KASIE LOG KP

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Manajer Logistik KP (User Kasie Logistik KP): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Manajer Kantor Pusat";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) { //MAN LOG KP

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Direksi (User Manajer Logistik KP): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Direksi";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) { //STAFF UMUM LOG SP

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Supervisi Logistik (User Staff Umum Logistik): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Supervisi Logistik SP";
				$STATUS_SPPB = "Proses Pengajuan";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FPB = date("Y-m-d", $d);

				$DATE_SIGN_USER_STAFF_UMUM_LOG_SP = date("Y-m-d H:i:s");
				$SIGN_USER_STAFF_UMUM_LOG_SP = "Diajukan pada tanggal: " . $DATE_SIGN_USER_STAFF_UMUM_LOG_SP;

				//DUE DATE UNTUK STAFF LOGISTIK +1 HARI DARI DATE SIGN PEMINTA
				$date = new DateTime();
				$date->add(new DateInterval('P1D'));
				$DUE_DATE_SPV_LOG = $date->format('Y-m-d H:i:s');

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan_user_staff_umum_logistik_sp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_STAFF_UMUM_LOG_SP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) { //STAFF GUDANG LOG KP

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Kasie Logistik KP (User Staff Gudang Logistik KP): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Kasie Logistik KP";
				$STATUS_SPPB = "Proses Pengajuan";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FPB = date("Y-m-d", $d);

				$DATE_SIGN_USER_STAFF_GUDANG_LOG_KP = date("Y-m-d H:i:s");
				$SIGN_USER_STAFF_GUDANG_LOG_KP = "Diajukan pada tanggal: " . $DATE_SIGN_USER_STAFF_GUDANG_LOG_KP;

				//DUE DATE UNTUK STAFF GUDANG LOGISTIK +1 HARI
				$date = new DateTime();
				$date->add(new DateInterval('P1D'));
				$DUE_DATE_STAFF_GUDANG_LOG_KP = $date->format('Y-m-d H:i:s');

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan_user_supervisi_logistik_sp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_STAFF_GUDANG_LOG_KP);
				echo json_encode($data);

			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) { //STAFF GUDANG LOG SP

			redirect('NOTA_PENGAMBILAN', 'refresh');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) { // SUPERVISI LOG SP

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Staff Umum Logistik KP (User Staff Supervisi Logistik): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Staff Umum Logistik KP";
				$STATUS_SPPB = "Proses Pengajuan";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FPB = date("Y-m-d", $d);

				$DATE_SIGN_USER_SUPERVISI_LOG_SP = date("Y-m-d H:i:s");
				$SIGN_USER_SUPERVISI_LOG_SP = "Diajukan pada tanggal: " . $DATE_SIGN_USER_SUPERVISI_LOG_SP;

				//DUE DATE UNTUK STAFF GUDANG LOGISTIK +1 HARI
				$date = new DateTime();
				$date->add(new DateInterval('P1D'));
				$DUE_DATE_STAFF_GUDANG_LOG_KP = $date->format('Y-m-d H:i:s');

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan_user_supervisi_logistik_sp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_SUPERVISI_LOG_SP);
				echo json_encode($data);

			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(18) || $this->ion_auth->in_group(21) || $this->ion_auth->in_group(24) || $this->ion_auth->in_group(27) || $this->ion_auth->in_group(30) || $this->ion_auth->in_group(33) || $this->ion_auth->in_group(41) || $this->ion_auth->in_group(43) || $this->ion_auth->in_group(44))) { //JAJARAN MANAJER

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Level Manajer (User Manajer): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Manajer Kantor Pusat";
				$STATUS_SPPB = "Proses Pengajuan";

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(34) || $this->ion_auth->in_group(36))) { //JAJARAN

			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Direksi (User Direksi): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "Dalam Proses Direksi";
				$STATUS_SPPB = "Proses pengajuan";

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB = $this->input->post('ID_SPPB');

				$KETERANGAN = "NOTA_PENGAMBILAN Disetujui (User Direktur PSDS): " . " ---- " . $ID_SPPB;
				$this->user_log($KETERANGAN);

				$PROGRESS_SPPB = "NOTA_PENGAMBILAN Disetujui";
				$STATUS_SPPB = "Selesai";

				$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
				echo json_encode($data);
			}
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

		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			// //set validation rules
			// $this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			// //run validation check
			// if ($this->form_validation->run() == FALSE) {   //validation fails
			// 	echo json_encode(validation_errors());
			// } else {
			// 	//get the form data
			// 	$ID_SPPB = $this->input->post('ID_SPPB');

			// 	$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Chief (User Staff logistik): "." ---- " . $ID_SPPB;
			// 	$this->user_log($KETERANGAN);

			// 	$PROGRESS_SPPB = "Dalam Proses Chief";
			// 	$STATUS_SPPB = "Proses pengajuan";

			// 	$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
			// 	echo json_encode($data);
			// }
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Chief): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
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
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User SM): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User PM): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Staff Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Kasie Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Manajer Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Staff Umum Logistik SP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Supervisi Logistik SP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Manajer HRD KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Manajer Keuangan KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Manajer Konstruksi KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Manajer SDM KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Manajer QAQC KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Manajer PE KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Direktur Keuangan KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Direktur PSDS): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Direktur EP dan Konstruksi KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Manajer HSSE KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Staff Gudang Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Manajer Marketing KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_CORET', 'Alasan Penolakan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_CORET = $this->input->post('CATATAN_CORET');

				$CATATAN_CORET = "Alasan penolakan " . $NAMA .  ": " . $CATATAN_CORET;

				$KETERANGAN = "Tolak Barang (User Manajer Komersial KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_coret($ID_SPPB_FORM, $CATATAN_CORET);
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

		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			// //set validation rules
			// $this->form_validation->set_rules('ID_SPPB', 'ID_SPPB ', 'trim|required');

			// //run validation check
			// if ($this->form_validation->run() == FALSE) {   //validation fails
			// 	echo json_encode(validation_errors());
			// } else {
			// 	//get the form data
			// 	$ID_SPPB = $this->input->post('ID_SPPB');

			// 	$KETERANGAN = "Kirim Form NOTA_PENGAMBILAN ke Chief (User Staff logistik): "." ---- " . $ID_SPPB;
			// 	$this->user_log($KETERANGAN);

			// 	$PROGRESS_SPPB = "Dalam Proses Chief";
			// 	$STATUS_SPPB = "Proses pengajuan";

			// 	$data = $this->Nota_pengambilan_form_model->update_data_kirim_nota_pengambilan($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB);
			// 	echo json_encode($data);
			// }
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Chief): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
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
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User SM): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User PM): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Staff Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Kasie Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Manajer Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Staff Umum Logistik SP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Supervisi Logistik SP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Manajer HRD KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Manajer Keuangan KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Manajer Konstruksi KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Manajer SDM KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Manajer QAQC KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Manajer PE KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Direktur Keuangan KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Direktur PSDS): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Direktur EP dan Konstruksi KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Manajer HSSE KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Staff Gudang Logistik KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Manajer Marketing KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {

			//set validation rules
			$this->form_validation->set_rules('CATATAN_BATAL_CORET', 'Alasan Menerima Permintaan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_SPPB_FORM = $this->input->post('kode');
				$CATATAN_BATAL_CORET = $this->input->post('CATATAN_BATAL_CORET');

				$CATATAN_BATAL_CORET = "Alasan penerimaan " . $NAMA .  ": " . $CATATAN_BATAL_CORET;

				$KETERANGAN = "Batal Tolak Barang (User Manajer Komersial KP): " . " ---- " . $ID_SPPB_FORM . " ---- " . $CATATAN_BATAL_CORET;
				$this->user_log($KETERANGAN);

				$data = $this->Nota_pengambilan_form_model->update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_proses()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->Nota_pengambilan_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->Nota_pengambilan_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->Nota_pengambilan_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->Nota_pengambilan_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->Nota_pengambilan_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->Nota_pengambilan_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_SETUJU_TERAKHIR', 'JUMLAH_SETUJU_TERAKHIR', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
				// $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$JUMLAH_SETUJU_TERAKHIR = $this->input->post('JUMLAH_SETUJU_TERAKHIR');

				$data = $this->Nota_pengambilan_form_model->update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR);
				echo json_encode($data);
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();

		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_rasd_barang2', 'Nama Nota_pengambilan_form', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo json_encode(validation_errors());
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$ID_RASD_FORM=$this->input->post('id_rasd_barang2');
		// 		$nama_rasd_barang=$this->input->post('nama_rasd_barang2');
		// 		$keterangan=$this->input->post('keterangan2');

		// 		//cek apakah input sama dengan eksisting
		// 		$data=$this->Nota_pengambilan_form_model->get_data_by_id_rasd_barang($ID_RASD_FORM);

		// 		if($data['NAMA_RASD_BARANG'] == $nama_rasd_barang || ($this->Nota_pengambilan_form_model->cek_nama_rasd_barang_by_pegawai($nama_rasd_barang, $user->ID_PEGAWAI) == 'Data belum ada'))
		// 		{
		// 			$data=$this->Nota_pengambilan_form_model->get_data_by_id_rasd_barang($ID_RASD_FORM);

		// 			//log
		// 			$KETERANGAN = "Ubah Nota_pengambilan_form ".$data['NAMA_RASD_BARANG']." jadi ".$nama_rasd_barang.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Nota_pengambilan_form_model->log_SPPB_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		// 			$data=$this->Nota_pengambilan_form_model->update_data($ID_RASD_FORM, $nama_rasd_barang,$keterangan);
		// 			echo json_encode($data);
		// 		}
		// 		else
		// 		{
		// 			echo json_encode('Nama NOTA_PENGAMBILAN Barang sudah terekam sebelumnya');
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
	public function view()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}
		//push komentar
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

		$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);
		if ($this->Nota_pengambilan_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN) == 'TIDAK ADA DATA') {
			redirect('NOTA_PENGAMBILAN', 'refresh');
		}


		if ($this->ion_auth->logged_in()) {

			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_NOTA_PENGAMBILAN = $this->uri->segment(3);

			if ($this->ion_auth->in_group(2)) { //chief_sp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_chief_sp/head_normal', $this->data);
				$this->load->view('wasa/user_chief_sp/user_menu');
				$this->load->view('wasa/user_chief_sp/left_menu');
				$this->load->view('wasa/user_chief_sp/header_menu');
				$this->load->view('wasa/user_chief_sp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_chief_sp/footer');
			} else if ($this->ion_auth->in_group(3)) { //sm_sp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
				$this->load->view('wasa/user_sm_sp/user_menu');
				$this->load->view('wasa/user_sm_sp/left_menu');
				$this->load->view('wasa/user_sm_sp/header_menu');
				$this->load->view('wasa/user_sm_sp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_sm_sp/footer');
			} else if ($this->ion_auth->in_group(4)) { //pm_sp
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;
				$sess_data['HASH_MD5_NOTA_PENGAMBILAN'] = $this->data['HASH_MD5_NOTA_PENGAMBILAN'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$query_file_HASH_MD5_NOTA_PENGAMBILAN = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);

				if ($query_file_HASH_MD5_NOTA_PENGAMBILAN->num_rows() > 0) {

					$this->data['dokumen'] = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_NOTA_PENGAMBILAN_result($HASH_MD5_NOTA_PENGAMBILAN);

					$hasil = $query_file_HASH_MD5_NOTA_PENGAMBILAN->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_nota_pengambilan_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['JENIS_FILE'] = $JENIS_FILE;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
				$this->load->view('wasa/user_pm_sp/user_menu');
				$this->load->view('wasa/user_pm_sp/left_menu');
				$this->load->view('wasa/user_pm_sp/header_menu');
				$this->load->view('wasa/user_pm_sp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_pm_sp/footer');
			} else if ($this->ion_auth->in_group(5)) { //staff_proc_kp
				$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $HASH_MD5_NOTA_PENGAMBILAN;
				$sess_data['HASH_MD5_NOTA_PENGAMBILAN'] = $this->data['HASH_MD5_NOTA_PENGAMBILAN'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$query_file_HASH_MD5_NOTA_PENGAMBILAN = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);

				if ($query_file_HASH_MD5_NOTA_PENGAMBILAN->num_rows() > 0) {

					$this->data['dokumen'] = $this->SPPB_Form_File_Model->file_list_by_HASH_MD5_NOTA_PENGAMBILAN_result($HASH_MD5_NOTA_PENGAMBILAN);

					$hasil = $query_file_HASH_MD5_NOTA_PENGAMBILAN->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_nota_pengambilan_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['JENIS_FILE'] = $JENIS_FILE;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "TIDAK ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(6)) { //kasie_proc_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(7)) { //manajer_proc_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(8)) { //staff_proc_sp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(9)) { //supervisi_proc_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(10)) { //staff_log_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
					$this->data['STATUS_SPPB'] = $NOTA_PENGAMBILAN->STATUS_SPPB;
				endforeach;

				$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(11)) { //kasie_log_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
					$this->data['STATUS_SPPB'] = $NOTA_PENGAMBILAN->STATUS_SPPB;
				endforeach;

				$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_kasie_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(12)) { //manajer_logsitik_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
					$this->data['STATUS_SPPB'] = $NOTA_PENGAMBILAN->STATUS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(13)) { //staff_umum_log_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
					$this->data['STATUS_SPPB'] = $NOTA_PENGAMBILAN->STATUS_SPPB;
				endforeach;

				$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
			} else if ($this->ion_auth->in_group(14)) { //staff_gudang_log_sp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
			} else if ($this->ion_auth->in_group(15)) { //supervisi_log_sp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
					$this->data['STATUS_SPPB'] = $NOTA_PENGAMBILAN->STATUS_SPPB;
				endforeach;

				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_supervisi_logistik_sp/footer');
			} else if ($this->ion_auth->in_group(18)) { //user_manajer_hrd_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_hrd_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_hrd_kp/user_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/left_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/header_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_hrd_kp/footer');
			} else if ($this->ion_auth->in_group(21)) { //manager_keuangan_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_keuangan_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_keuangan_kp/user_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/left_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/header_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_keuangan_kp/footer');
			} else if ($this->ion_auth->in_group(24)) { //manager_konstruksi_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_konstruksi_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_konstruksi_kp/user_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/left_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/header_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_konstruksi_kp/footer');
			} else if ($this->ion_auth->in_group(27)) { //manager_sdm_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_sdm_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_sdm_kp/user_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/left_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/header_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_sdm_kp/footer');
			} else if ($this->ion_auth->in_group(30)) { //manager_qaqc_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_qaqc_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_qaqc_kp/user_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/left_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/header_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_qaqc_kp/footer');
			} else if ($this->ion_auth->in_group(33)) { //manager_ep_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_ep_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_ep_kp/user_menu');
				$this->load->view('wasa/user_manajer_ep_kp/left_menu');
				$this->load->view('wasa/user_manajer_ep_kp/header_menu');
				$this->load->view('wasa/user_manajer_ep_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_ep_kp/footer');
			} else if ($this->ion_auth->in_group(34)) { //user_direktur_keuangan_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_direktur_keuangan_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_keuangan_kp/user_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/left_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/header_menu');
				$this->load->view('wasa/user_direktur_keuangan_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_direktur_keuangan_kp/footer');
			} else if ($this->ion_auth->in_group(35)) { //user_direktur_psds_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_direktur_psds_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_psds_kp/user_menu');
				$this->load->view('wasa/user_direktur_psds_kp/left_menu');
				$this->load->view('wasa/user_direktur_psds_kp/header_menu');
				$this->load->view('wasa/user_direktur_psds_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_direktur_psds_kp/footer');
			} else if ($this->ion_auth->in_group(36)) { //user_direktur_konstruksi_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_direktur_konstruksi_kp/head_normal', $this->data);
				$this->load->view('wasa/user_direktur_konstruksi_kp/user_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/left_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/header_menu');
				$this->load->view('wasa/user_direktur_konstruksi_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_direktur_konstruksi_kp/footer');
			} else if ($this->ion_auth->in_group(41)) { //manajer_hsse_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_hsse_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_hsse_kp/user_menu');
				$this->load->view('wasa/user_manajer_hsse_kp/left_menu');
				$this->load->view('wasa/user_manajer_hsse_kp/header_menu');
				$this->load->view('wasa/user_manajer_hsse_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_hsse_kp/footer');
			} else if ($this->ion_auth->in_group(42)) { //staff_gudang_logsitik_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
					$this->data['STATUS_SPPB'] = $NOTA_PENGAMBILAN->STATUS_SPPB;
				endforeach;

				$this->load->view('wasa/user_staff_gudang_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_gudang_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_staff_gudang_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(43)) { //manajer_marketing_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_marketing_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_marketing_kp/user_menu');
				$this->load->view('wasa/user_manajer_marketing_kp/left_menu');
				$this->load->view('wasa/user_manajer_marketing_kp/header_menu');
				$this->load->view('wasa/user_manajer_marketing_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_marketing_kp/footer');
			} else if ($this->ion_auth->in_group(44)) { //manajer_komersial_kp
				$this->cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN);

				$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_by_id_nota_pengambilan($ID_SPPB);

				foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
					$this->data['FILE_NAME_TEMP'] = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN . '.pdf';
					$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
					$this->data['HASH_MD5_NOTA_PENGAMBILAN'] = $NOTA_PENGAMBILAN->HASH_MD5_NOTA_PENGAMBILAN;
					$this->data['PROGRESS_SPPB'] = $NOTA_PENGAMBILAN->PROGRESS_SPPB;
				endforeach;

				$this->load->view('wasa/user_manajer_komersial_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_komersial_kp/user_menu');
				$this->load->view('wasa/user_manajer_komersial_kp/left_menu');
				$this->load->view('wasa/user_manajer_komersial_kp/header_menu');
				$this->load->view('wasa/user_manajer_komersial_kp/content_nota_pengambilan_form');
				$this->load->view('wasa/user_manajer_komersial_kp/footer');
			} else {
				redirect('NOTA_PENGAMBILAN', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	function proses_upload_file()
	{

		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		$HASH_MD5_NOTA_PENGAMBILAN = $this->session->userdata('HASH_MD5_NOTA_PENGAMBILAN');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_NOTA_PENGAMBILAN . '_';
			$config['upload_path']   = './assets/upload_nota_pengambilan_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_nota_pengambilan = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$ID_SPPB = $query_id_nota_pengambilan['ID_SPPB'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_nota_pengambilan_form_file/' . $nama;
				$this->db->insert('nota_pengambilan_form_file', array('ID_SPPB' => $ID_SPPB, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_NOTA_PENGAMBILAN' => $HASH_MD5_NOTA_PENGAMBILAN, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_NOTA_PENGAMBILAN . '_';
			$config['upload_path']   = './assets/upload_nota_pengambilan_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_nota_pengambilan = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
			$ID_SPPB = $query_id_nota_pengambilan['ID_SPPB'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_nota_pengambilan_form_file/' . $nama;
				$this->db->insert('nota_pengambilan_form_file', array('ID_SPPB' => $ID_SPPB, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_NOTA_PENGAMBILAN' => $HASH_MD5_NOTA_PENGAMBILAN, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
		} else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
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
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->SPPB_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_nota_pengambilan_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->SPPB_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_NOTA_PENGAMBILAN = $this->session->userdata('HASH_MD5_NOTA_PENGAMBILAN');
				redirect('/nota_pengambilan_form/view/' . $HASH_MD5_NOTA_PENGAMBILAN, 'refresh');
			} else {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->session->userdata('HASH_MD5_NOTA_PENGAMBILAN');
				redirect('/nota_pengambilan_form/view/' . $HASH_MD5_NOTA_PENGAMBILAN, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->SPPB_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_nota_pengambilan_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->SPPB_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_NOTA_PENGAMBILAN = $this->session->userdata('HASH_MD5_NOTA_PENGAMBILAN');
				redirect('/nota_pengambilan_form/view/' . $HASH_MD5_NOTA_PENGAMBILAN, 'refresh');
			} else {
				$HASH_MD5_NOTA_PENGAMBILAN = $this->session->userdata('HASH_MD5_NOTA_PENGAMBILAN');
				redirect('/nota_pengambilan_form/view/' . $HASH_MD5_NOTA_PENGAMBILAN, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->Barang_master_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->Barang_master_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			} else {
				$HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');
				redirect('/barang_master/profil_barang_master/' . $HASH_MD5_BARANG_MASTER, 'refresh');
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
		}
	}

	public function cetak_pdf($HASH_MD5_NOTA_PENGAMBILAN)
	{
		$hasil = $this->SPPB_model->get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN);
		$ID_SPPB = $hasil['ID_SPPB'];
		$this->data['NOTA_PENGAMBILAN'] = $this->SPPB_model->nota_pengambilan_list_nota_pengambilan_by_hashmd5($HASH_MD5_NOTA_PENGAMBILAN);
		foreach ($this->data['NOTA_PENGAMBILAN']->result() as $NOTA_PENGAMBILAN) :
			$this->data['ID_SPPB'] = $NOTA_PENGAMBILAN->ID_SPPB;
			$this->data['ID_PROYEK'] = $NOTA_PENGAMBILAN->ID_PROYEK;
			$this->data['NO_URUT_SPPB'] = $NOTA_PENGAMBILAN->NO_URUT_SPPB;
			// $this->data['TOP'] = $NOTA_PENGAMBILAN->TOP;
			// $this->data['LOKASI_PENYERAHAN'] = $NOTA_PENGAMBILAN->LOKASI_PENYERAHAN;
			// $this->data['ID_VENDOR'] = $NOTA_PENGAMBILAN->ID_VENDOR;
			$this->data['TANGGAL_PEMBUATAN_SPPB_HARI'] = $NOTA_PENGAMBILAN->TANGGAL_PEMBUATAN_SPPB_HARI;
			$this->data['TANGGAL_PEMBUATAN_SPPB_BULAN'] = $NOTA_PENGAMBILAN->TANGGAL_PEMBUATAN_SPPB_BULAN;
			$this->data['TANGGAL_PEMBUATAN_SPPB_TAHUN'] = $NOTA_PENGAMBILAN->TANGGAL_PEMBUATAN_SPPB_TAHUN;
		endforeach;

		$this->data['konten_SPPB_form'] = $this->Nota_pengambilan_form_model->nota_pengambilan_form_list_by_id_nota_pengambilan($ID_SPPB);

		$this->data['PROYEK'] = $this->Proyek_model->detil_proyek_by_ID_PROYEK($this->data['ID_PROYEK']);
		foreach ($this->data['PROYEK']->result() as $PROYEK) :
			$this->data['NAMA_PROYEK'] = $PROYEK->NAMA_PROYEK;
		endforeach;
		// var_dump($this->data['ID_PROYEK']);

		// if ($this->data['ID_VENDOR'] == "0" || $this->data['ID_VENDOR'] == null) {
		// 	$this->data['NAMA_VENDOR'] = "";
		// 	$this->data['ALAMAT_VENDOR'] = "";
		// 	$this->data['NO_TELP_VENDOR'] = "";
		// 	$this->data['NAMA_PIC_VENDOR'] = "";
		// 	$this->data['NO_HP_PIC_VENDOR'] = "";
		// } else {
		// 	$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
		// 	foreach ($hasil->result() as $VENDOR) :
		// 		$NAMA_VENDOR = $VENDOR->NAMA_VENDOR;
		// 		$ALAMAT_VENDOR = $VENDOR->ALAMAT_VENDOR;
		// 		$NO_TELP_VENDOR = $VENDOR->NO_TELP_VENDOR;
		// 		$NAMA_PIC_VENDOR = $VENDOR->NAMA_PIC_VENDOR;
		// 		$NO_HP_PIC_VENDOR = $VENDOR->NO_HP_PIC_VENDOR;


		// 	endforeach;
		// 	$this->data['NAMA_VENDOR'] = $NAMA_VENDOR;
		// 	$this->data['ALAMAT_VENDOR'] = $ALAMAT_VENDOR;
		// 	$this->data['NO_TELP_VENDOR'] = $NO_TELP_VENDOR;
		// 	$this->data['NAMA_PIC_VENDOR'] = $NAMA_PIC_VENDOR;
		// 	$this->data['NO_HP_PIC_VENDOR'] = $NO_HP_PIC_VENDOR;
		// }


		//$this->data['CATATAN_FPB'] = $this->FPB_form_model->get_data_catatan_FPB_by_id_fpb($ID_FPB);

		//$this->data['rasd_barang_list'] = $this->FPB_form_model->rasd_form_list_where_not_in_fpb($ID_FPB);
		//$this->data['barang_master_list'] = $this->FPB_form_model->barang_master_where_not_in_fpb_and_rasd($ID_FPB);
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		// $this->data['USER_PENGAJU'] = $this->FPB_form_model->ID_JABATAN_BY_ID_FPB($ID_FPB);

		// foreach ($this->data['FPB']->result() as $FPB) :
		// 	$FILE_NAME_TEMP = $FPB->FILE_NAME_TEMP;
		// 	$this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
		// endforeach;

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'NOTA_PENGAMBILAN';

		// filename dari pdf ketika didownload
		$file_pdf = 'nota_pengambilan_' . $HASH_MD5_NOTA_PENGAMBILAN;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "landscape";

		$html = $this->load->view('wasa/pdf/nota_pengambilan_pdf', $this->data, true);

		// run dompdf
		$x          = 650;
		$y          = 750;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 10;

		$file_path = "assets/NOTA_PENGAMBILAN/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}
}
