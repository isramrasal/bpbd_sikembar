<?php defined('BASEPATH') or exit('No direct script access allowed');

class RASD_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation','excel'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | RASD Barang dan Jasa';

		$this->load->model('Barang_master_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RASD_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Foto_model');
		$this->load->model('Organisasi_model');
		$this->load->model('Manajemen_user_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "Proyek_aktif";
	}
	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses RASD Form";
		$WAKTU = date('Y-m-d H:i:s');
		$this->RASD_form_model->user_log_rasd_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->RASD_form_model->user_log_rasd_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		$HASH_MD5_RASD = $this->uri->segment(3);

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD,
							'ID_PROYEK' => $data->ID_PROYEK,
							'ID_SUB_PEKERJAAN' => $data->ID_SUB_PEKERJAAN
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;

				$this->data['barang_master_list'] = $this->RASD_form_model->barang_master_list_where_not_in_rasd($hasil['ID_RASD']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_admin/head_normal', $this->data);
				$this->load->view('wasa/user_admin/user_menu');
				$this->load->view('wasa/user_admin/left_menu');
				$this->load->view('wasa/user_admin/header_menu');
				$this->load->view('wasa/user_admin/content_rasd_form');
				//$this->load->view('wasa/user_admin/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			$sess_data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->session->set_userdata($sess_data);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD,
							'ID_PROYEK' => $data->ID_PROYEK,
							'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;
				$this->data['ID_PROYEK'] = $data->ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $data->ID_PROYEK_SUB_PEKERJAAN;

				$sess_data['HASH_MD5_RASD'] = $this->data['HASH_MD5_RASD'];
				$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
				$sess_data['ID_PROYEK_SUB_PEKERJAAN'] = $this->data['ID_PROYEK_SUB_PEKERJAAN'];
				$this->session->set_userdata($sess_data);

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_rasd_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {


			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;

				$this->data['barang_master_list'] = $this->RASD_form_model->barang_master_list_where_not_in_rasd($hasil['ID_RASD']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_rasd_form');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);



			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD,
							'ID_PROYEK' => $data->ID_PROYEK,
							'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;
				$this->data['ID_PROYEK'] = $data->ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $data->ID_PROYEK_SUB_PEKERJAAN;

				$sess_data['HASH_MD5_RASD'] = $this->data['HASH_MD5_RASD'];
				$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
				$sess_data['ID_PROYEK_SUB_PEKERJAAN'] = $this->data['ID_PROYEK_SUB_PEKERJAAN'];
				$this->session->set_userdata($sess_data);

				$this->data['barang_master_list'] = $this->RASD_form_model->barang_master_list_where_not_in_rasd($hasil['ID_RASD']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_rasd_form');
				$this->load->view('wasa/user_manajer_logistik_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;

				$this->data['barang_master_list'] = $this->RASD_form_model->barang_master_list_where_not_in_rasd($hasil['ID_RASD']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_rasd_form');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			$sess_data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->session->set_userdata($sess_data);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD,
							'ID_PROYEK' => $data->ID_PROYEK,
							'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;
				$this->data['ID_PROYEK'] = $data->ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $data->ID_PROYEK_SUB_PEKERJAAN;

				$sess_data['HASH_MD5_RASD'] = $this->data['HASH_MD5_RASD'];
				$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
				$sess_data['ID_PROYEK_SUB_PEKERJAAN'] = $this->data['ID_PROYEK_SUB_PEKERJAAN'];
				$this->session->set_userdata($sess_data);
				
				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_rasd_form');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;

				$this->data['barang_master_list'] = $this->RASD_form_model->barang_master_list_where_not_in_rasd($hasil['ID_RASD']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/content_rasd_form');
				$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;

				$this->data['barang_master_list'] = $this->RASD_form_model->barang_master_list_where_not_in_rasd($hasil['ID_RASD']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/content_rasd_form');
				$this->load->view('wasa/user_kasie_logistik_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			$sess_data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->session->set_userdata($sess_data);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD,
							'ID_PROYEK' => $data->ID_PROYEK,
							'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;
				$this->data['ID_PROYEK'] = $data->ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $data->ID_PROYEK_SUB_PEKERJAAN;

				$sess_data['HASH_MD5_RASD'] = $this->data['HASH_MD5_RASD'];
				$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
				$sess_data['ID_PROYEK_SUB_PEKERJAAN'] = $this->data['ID_PROYEK_SUB_PEKERJAAN'];
				$this->session->set_userdata($sess_data);

				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_rasd_form');
				$this->load->view('wasa/user_manajer_logistik_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$HASH_MD5_RASD = $this->uri->segment(3);

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;

				$this->data['barang_master_list'] = $this->RASD_form_model->barang_master_list_where_not_in_rasd($hasil['ID_RASD']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/content_rasd_form');
				$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$HASH_MD5_RASD = $this->uri->segment(3);

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;

				$this->data['barang_master_list'] = $this->RASD_form_model->barang_master_list_where_not_in_rasd($hasil['ID_RASD']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/content_rasd_form');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$HASH_MD5_RASD = $this->uri->segment(3);

			$this->data['HASH_MD5_RASD'] = $HASH_MD5_RASD;
			$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);
			$query_rasd_HASH_MD5_RASD = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

			if ($query_rasd_HASH_MD5_RASD->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rasd'] = $this->RASD_model->RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD);

				if ($this->data['rasd']->num_rows() > 0) {
					foreach ($this->data['rasd']->result() as $data) {
						$hasil = array(
							'ID_RASD' => $data->ID_RASD
						);
					}
				} else {
					$hasil = "BELUM ADA RASD";
				}
				$this->data['ID_RASD'] = $data->ID_RASD;

				$this->data['barang_master_list'] = $this->RASD_form_model->barang_master_list_where_not_in_rasd($hasil['ID_RASD']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_rasd_form');
				$this->load->view('wasa/user_supervisi_logistik_sp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rasd', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	function data_RASD_form()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->RASD_form_model->RASD_form_list_by_id_rasd($ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RASD Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_RASD_form_deviasi()
	{
		if ($this->ion_auth->logged_in()) {
			$id = $this->input->get('id');
			$data = $this->RASD_form_model->RASD_form_deviasi_list_by_id_rasd($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RASD Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} 
		else {
			$this->logout();
		}
	}

	function data_RASD_realisasi()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$data = $this->RASD_form_model->data_RASD_realisasi($ID_RASD_FORM);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RASD Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$data = $this->RASD_form_model->get_data_by_id_RASD_form($ID_RASD_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data RASD Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function data_sum_qty_rasd_realisasi_item_barang()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');

			$data = $this->RASD_form_model->data_anggaran_sum_jumlah_barang_rab_pengadaan_sebelumnya($ID_RAB_FORM, $ID_RASD_FORM);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RASD Realisasi: " . json_encode($ID_RAB_FORM);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
			$data_hapus = $this->RASD_form_model->get_data_by_id_RASD_form($ID_RASD_FORM);

			$data = $this->RASD_form_model->hapus_data_by_id_RASD_form($ID_RASD_FORM);
			echo json_encode($data);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function simpan_data()
	{
		if ($this->ion_auth->logged_in()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|max_length[99999999999]');
			$this->form_validation->set_rules('HARGA_BARANG', 'Harga Satuan Barang (Unit Price)', 'trim|required|integer|max_length[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_RASD = $this->input->post('ID_RASD');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');

				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_BARANG = $this->input->post('HARGA_BARANG');
				$TOTAL_HARGA = $JUMLAH_BARANG * $HARGA_BARANG;

				$data = $this->RASD_form_model->simpan_data(
					$ID_RASD,
					$SATUAN_BARANG,
					$NAMA,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$JUMLAH_BARANG,
					$HARGA_BARANG,
					$TOTAL_HARGA
				);

				// $KETERANGAN = "Simpan Data RASD Form: " . $ID_BARANG_MASTER . "; " . $ID_RASD . "; " . $ID_SATUAN_BARANG . "; " . $NAMA . "; " . $MEREK . "; " . $SPESIFIKASI_SINGKAT . "; " . $JUMLAH_BARANG  . "; " . $HARGA_BARANG;
				// $this->user_log($KETERANGAN);

			}
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in()) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[255]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|required|max_length[99999999999]');
			$this->form_validation->set_rules('HARGA_BARANG', 'Harga Satuan Barang (Unit Price)', 'trim|required|integer|max_length[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_RASD = $this->input->post('ID_RASD');
				$ID_RASD_FORM = $this->input->post('ID_RASD_FORM');
				$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$HARGA_BARANG = $this->input->post('HARGA_BARANG');
				$TOTAL_HARGA = $JUMLAH_BARANG * $HARGA_BARANG;

				$data = $this->RASD_form_model->get_data_by_id_RASD_form($ID_RASD_FORM);
				// $KETERANGAN = "Ubah Data RASD Form: " . json_encode($data) . " ---- " . $ID_RASD_FORM . ";" . $ID_BARANG_MASTER . ";" . $JUMLAH_BARANG . ";" . $HARGA_BARANG;
				// $this->user_log($KETERANGAN);

				$data = $this->RASD_form_model->update_data($ID_RASD_FORM, $ID_BARANG_MASTER, $NAMA, $MEREK, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG, $HARGA_BARANG, $TOTAL_HARGA);
				echo json_encode($data);

			}
		} else {
			$this->logout();
		}
	}


	function proses_upload_file_excel()
	{

		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		$HASH_MD5_RASD = $this->session->userdata('HASH_MD5_RASD');

		//jika mereka sudah login
		if ($this->ion_auth->logged_in()) {
			$WAKTU = date('Y-m-d H:i:s');
			$nama_file = "excel_" . $HASH_MD5_RASD;
			$config['upload_path'] = './assets/upload_rasd_form_excel/';
			$config['allowed_types'] = 'xlsx';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_rasd = $this->RASD_model->get_data_by_HASH_MD_RASD($HASH_MD5_RASD);
			$ID_RASD = $query_id_rasd['ID_RASD'];

			if (file_exists($file = './assets/upload_rasd_form_excel/' .$nama_file.".xlsx")) {
				unlink($file);
			}

			if ($this->upload->do_upload('userfile')) {
				$JENIS_FILE = $this->input->post('JENIS_FILE');	

				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$path = $config['upload_path'].$nama_file.".xlsx";
				$object = PHPExcel_IOFactory::load($path);

				$ada_error = "tidak";
				foreach($object->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();	
					for($row=2; $row<=$highestRow; $row++)
					{
						$inserdata['NAMA']= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						if(strstr($inserdata['NAMA'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['NAMA'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['NAMA'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['MEREK'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						if(strstr($inserdata['MEREK'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['MEREK'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['MEREK'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['SPESIFIKASI_SINGKAT'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
						if(strstr($inserdata['SPESIFIKASI_SINGKAT'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['SPESIFIKASI_SINGKAT'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['SPESIFIKASI_SINGKAT'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['JUMLAH_BARANG'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						if(strstr($inserdata['JUMLAH_BARANG'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['JUMLAH_BARANG'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['JUMLAH_BARANG'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['SATUAN_BARANG'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
						if(strstr($inserdata['SATUAN_BARANG'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['SATUAN_BARANG'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['SATUAN_BARANG'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['HARGA_BARANG'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
						if(strstr($inserdata['HARGA_BARANG'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['HARGA_BARANG'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						else if(strstr($inserdata['HARGA_BARANG'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['TOTAL_HARGA'] = floor(floatval($inserdata['JUMLAH_BARANG']) * (int) $inserdata['HARGA_BARANG']);

					}

					if($ada_error == "tidak")
					{
						for($row=2; $row<=$highestRow; $row++)
						{
							$inserdata['NAMA']= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							$inserdata['MEREK'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
							$inserdata['SPESIFIKASI_SINGKAT'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
							$inserdata['JUMLAH_BARANG'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
							$inserdata['SATUAN_BARANG'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
							$inserdata['HARGA_BARANG'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
							$inserdata['TOTAL_HARGA'] = floor(floatval($inserdata['JUMLAH_BARANG']) * (int) $inserdata['HARGA_BARANG']);
							
							$data = $this->RASD_form_model->simpan_data(
								$ID_RASD,
								$inserdata['SATUAN_BARANG'],
								$inserdata['NAMA'],
								$inserdata['MEREK'],
								$inserdata['SPESIFIKASI_SINGKAT'],
								$inserdata['JUMLAH_BARANG'],
								$inserdata['HARGA_BARANG'],
								$inserdata['TOTAL_HARGA']
							);	
						}
					}
				}

				// $KETERANGAN = './assets/upload_sppb_form_file/' . $nama;
				// $this->db->insert('sppb_form_file', array('ID_SPPB' => $ID_SPPB, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_RASD' => $HASH_MD5_RASD, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}

			if (file_exists($file = './assets/upload_rasd_form_excel/' .$nama_file.".xlsx")) {
				unlink($file);
			}
			
		} else {
			// alihkan mereka ke halaman sppb list
			redirect('SPPB', 'refresh');
		}
	}

}
