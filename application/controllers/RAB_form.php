<?php defined('BASEPATH') or exit('No direct script access allowed');

class RAB_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | RAB Proyek';

		$this->load->model('Barang_master_model');
		$this->load->model('RAB_form_model');
		$this->load->model('RAB_form_file_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RAB_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Foto_model');
		$this->load->model('Organisasi_model');
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
		$KETERANGAN = "Paksa Logout Ketika Akses RAB Form";
		$WAKTU = date('Y-m-d H:i:s');
		$this->RAB_form_model->user_log_rab_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->RAB_form_model->user_log_RAB_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB,
							'ID_PROYEK' => $data->ID_PROYEK,
							'ID_SUB_PEKERJAAN' => $data->ID_SUB_PEKERJAAN
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;

				$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($hasil['ID_RAB']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_admin/head_normal', $this->data);
				$this->load->view('wasa/user_admin/user_menu');
				$this->load->view('wasa/user_admin/left_menu');
				$this->load->view('wasa/user_admin/header_menu');
				$this->load->view('wasa/user_admin/content_RAB_form');
				//$this->load->view('wasa/user_admin/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rab', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB,
							'ID_PROYEK' => $data->ID_PROYEK,
							'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;
				$this->data['ID_PROYEK'] = $data->ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $data->ID_PROYEK_SUB_PEKERJAAN;

				$sess_data['HASH_MD5_RAB'] = $this->data['HASH_MD5_RAB'];
				$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
				$sess_data['ID_PROYEK_SUB_PEKERJAAN'] = $this->data['ID_PROYEK_SUB_PEKERJAAN'];
				$this->session->set_userdata($sess_data);

				$query_file_HASH_MD5_RAB = $this->RAB_form_model->file_list_by_HASH_MD5_RAB($this->data['HASH_MD5_RAB']);

				if ($query_file_HASH_MD5_RAB->num_rows() > 0) {

					$this->data['dokumen'] = $this->RAB_form_model->file_list_by_HASH_MD5_RAB_result($this->data['HASH_MD5_RAB']);

					$hasil = $query_file_HASH_MD5_RAB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

					if (file_exists($file = './assets/upload_rab_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_RAB_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rab', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;

				$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($hasil['ID_RAB']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_RAB_form');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rab', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB,
							'ID_PROYEK' => $data->ID_PROYEK,
							'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;
				$this->data['ID_PROYEK'] = $data->ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $data->ID_PROYEK_SUB_PEKERJAAN;

				$sess_data['HASH_MD5_RAB'] = $this->data['HASH_MD5_RAB'];
				$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
				$sess_data['ID_PROYEK_SUB_PEKERJAAN'] = $this->data['ID_PROYEK_SUB_PEKERJAAN'];
				$this->session->set_userdata($sess_data);

				$query_file_HASH_MD5_RAB = $this->RAB_form_model->file_list_by_HASH_MD5_RAB($this->data['HASH_MD5_RAB']);

				if ($query_file_HASH_MD5_RAB->num_rows() > 0) {

					$this->data['dokumen'] = $this->RAB_form_model->file_list_by_HASH_MD5_RAB_result($this->data['HASH_MD5_RAB']);

					$hasil = $query_file_HASH_MD5_RAB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

					if (file_exists($file = './assets/upload_rab_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_RAB_form');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('proyek', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;

				$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($hasil['ID_RAB']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_RAB_form');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rab', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB,
							'ID_PROYEK' => $data->ID_PROYEK,
							'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;
				$this->data['ID_PROYEK'] = $data->ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $data->ID_PROYEK_SUB_PEKERJAAN;

				$sess_data['HASH_MD5_RAB'] = $this->data['HASH_MD5_RAB'];
				$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
				$sess_data['ID_PROYEK_SUB_PEKERJAAN'] = $this->data['ID_PROYEK_SUB_PEKERJAAN'];
				$this->session->set_userdata($sess_data);

				$query_file_HASH_MD5_RAB = $this->RAB_form_model->file_list_by_HASH_MD5_RAB($this->data['HASH_MD5_RAB']);

				if ($query_file_HASH_MD5_RAB->num_rows() > 0) {

					$this->data['dokumen'] = $this->RAB_form_model->file_list_by_HASH_MD5_RAB_result($this->data['HASH_MD5_RAB']);

					$hasil = $query_file_HASH_MD5_RAB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

					if (file_exists($file = './assets/upload_rab_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_RAB_form');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rab', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;

				$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($hasil['ID_RAB']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/content_RAB_form');
				$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rab', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;

				$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($hasil['ID_RAB']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/content_RAB_form');
				$this->load->view('wasa/user_kasie_logistik_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rab', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB,
							'ID_PROYEK' => $data->ID_PROYEK,
							'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;
				$this->data['ID_PROYEK'] = $data->ID_PROYEK;
				$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $data->ID_PROYEK_SUB_PEKERJAAN;

				$sess_data['HASH_MD5_RAB'] = $this->data['HASH_MD5_RAB'];
				$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
				$sess_data['ID_PROYEK_SUB_PEKERJAAN'] = $this->data['ID_PROYEK_SUB_PEKERJAAN'];
				$this->session->set_userdata($sess_data);

				$query_file_HASH_MD5_RAB = $this->RAB_form_model->file_list_by_HASH_MD5_RAB($this->data['HASH_MD5_RAB']);

				if ($query_file_HASH_MD5_RAB->num_rows() > 0) {

					$this->data['dokumen'] = $this->RAB_form_model->file_list_by_HASH_MD5_RAB_result($this->data['HASH_MD5_RAB']);

					$hasil = $query_file_HASH_MD5_RAB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

					if (file_exists($file = './assets/upload_rab_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['FILE'] = "ADA";
					} else {
						$this->data['FILE'] = "ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_RAB_form');
				$this->load->view('wasa/user_manajer_logistik_kp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('proyek', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;

				$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($hasil['ID_RAB']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/content_RAB_form');
				$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rab', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;

				$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($hasil['ID_RAB']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/content_RAB_form');
				$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rab', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$HASH_MD5_RAB = $this->uri->segment(3);

			$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
			$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

			if ($query_RAB_HASH_MD5_RAB->num_rows() > 0) {
				//fungsi ini untuk mengirim data ke dropdown
				$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

				if ($this->data['rab']->num_rows() > 0) {
					foreach ($this->data['rab']->result() as $data) {
						$hasil = array(
							'ID_RAB' => $data->ID_RAB
						);
					}
				} else {
					$hasil = "BELUM ADA RAB";
				}
				$this->data['ID_RAB'] = $data->ID_RAB;

				$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($hasil['ID_RAB']);
				$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
				$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_RAB_form');
				$this->load->view('wasa/user_supervisi_logistik_sp/footer');
			} else {
				// alihkan mereka ke halaman login
				redirect('rab', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	// public function detil_pekerjaan()
	// {
	// 	//jika mereka belum login
	// 	if (!$this->ion_auth->logged_in()) {
	// 		// alihkan mereka ke halaman login
	// 		redirect('auth/login', 'refresh');
	// 	}

	// 	//get data tabel users untuk ditampilkan
	// 	$user = $this->ion_auth->user()->row();
	// 	$this->data['user_id'] = $user->id;
	// 	$this->data['USER_ID'] = $user->id;
	// 	$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
	// 	$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
	// 	$this->data['role_user'] = $data_role_user['description'];
	// 	$this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
	// 	$this->data['ip_address'] = $user->ip_address;
	// 	$this->data['email'] = $user->email;
	// 	$this->data['user_id'] = $user->id;
	// 	date_default_timezone_set('Asia/Jakarta');
	// 	$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
	// 	$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
	// 	$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');
	// 	$this->data['title'] = 'SiPESUT | Detil Proyek';

	// 	$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
	// 	if ($query_foto_user == "BELUM ADA FOTO") {
	// 		$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
	// 	} else {
	// 		$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
	// 	}

	// 	$this->data['departemen'] = $this->Departemen_model->departemen_list();


	// 	$HASH_MD5_RAB = $this->uri->segment(3);

	// 	$this->data['HASH_MD5_RAB'] = $HASH_MD5_RAB;
	// 	$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
	// 	$this->data['rab'] = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);
	// 	$query_RAB_HASH_MD5_RAB = $this->RAB_model->RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB);

	// 	if ($query_RAB_HASH_MD5_RAB->num_rows() == 0) {
	// 		// alihkan mereka ke halaman list proyek
	// 		redirect('proyek', 'refresh');
	// 	}

	// 	//Kueri data di tabel proyek
	// 	$query_detil_proyek_HASH_MD5_PROYEK = $this->Proyek_model->detil_proyek_by_HASH_MD5_PROYEK($this->data['HASH_MD5_PROYEK']);

	// 	$query_detil_proyek_HASH_MD5_PROYEK_result = $this->Proyek_model->detil_proyek_by_HASH_MD5_PROYEK_result($this->data['HASH_MD5_PROYEK']);
	// 	$this->data['query_detil_proyek_HASH_MD5_PROYEK_result'] = $query_detil_proyek_HASH_MD5_PROYEK_result;

	// 	if ($query_detil_proyek_HASH_MD5_PROYEK->num_rows() == 0) {
	// 		// alihkan mereka ke halaman list proyek
	// 		redirect('proyek', 'refresh');
	// 	}
	// 	//Kueri data di tabel proyek file
	// 	$query_file_HASH_MD5_PROYEK = $this->Proyek_file_model->file_list_by_HASH_MD5_PROYEK($this->data['HASH_MD5_PROYEK']);

	// 	//log
	// 	$KETERANGAN = "Lihat Profil Proyek: " . json_encode($query_detil_proyek_HASH_MD5_PROYEK_result) . " ---- " . json_encode($query_file_HASH_MD5_PROYEK);
	// 	$this->user_log($KETERANGAN);

	// 	$hasil_1 = $query_detil_proyek_HASH_MD5_PROYEK->row();
	// 	$this->data['HASH_MD5_PROYEK'] = $hasil_1->HASH_MD5_PROYEK;
	// 	$this->data['ID_PROYEK'] = $hasil_1->ID_PROYEK;

	// 	$sess_data['HASH_MD5_PROYEK'] = $this->data['HASH_MD5_PROYEK'];
	// 	$sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
	// 	$this->session->set_userdata($sess_data);

	// 	if ($query_file_HASH_MD5_PROYEK->num_rows() > 0) {

	// 		$this->data['dokumen'] = $this->Proyek_file_model->file_list_by_HASH_MD5_PROYEK_result($sess_data['HASH_MD5_PROYEK']);

	// 		$hasil = $query_file_HASH_MD5_PROYEK->row();
	// 		$DOK_FILE = $hasil->DOK_FILE;
	// 		$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

	// 		if (file_exists($file = './assets/upload_proyek_file/' . $DOK_FILE)) {
	// 			$this->data['DOK_FILE'] = $DOK_FILE;
	// 			$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
	// 			$this->data['FILE'] = "ADA";
	// 		} else {
	// 			$this->data['FILE'] = "ADA";
	// 		}
	// 	} else {
	// 		$this->data['FILE'] = "TIDAK ADA";
	// 	}

	// 	//jika mereka sudah login dan sebagai admin
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) { //user_admin

	// 		$this->load->view('wasa/user_admin/head_normal', $this->data);
	// 		$this->load->view('wasa/user_admin/user_menu');
	// 		$this->load->view('wasa/user_admin/left_menu');
	// 		$this->load->view('wasa/user_admin/header_menu');
	// 		$this->load->view('wasa/user_admin/content_proyek_file');
	// 		$this->load->view('wasa/user_admin/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) { //user_chief_sp

	// 		$this->load->view('wasa/user_chief_sp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_chief_sp/user_menu');
	// 		$this->load->view('wasa/user_chief_sp/left_menu');
	// 		$this->load->view('wasa/user_chief_sp/header_menu');
	// 		$this->load->view('wasa/user_chief_sp/content_proyek_file');
	// 		$this->load->view('wasa/user_chief_sp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) { //user_sm_sp

	// 		$this->load->view('wasa/user_sm_sp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_sm_sp/user_menu');
	// 		$this->load->view('wasa/user_sm_sp/left_menu');
	// 		$this->load->view('wasa/user_sm_sp/header_menu');
	// 		$this->load->view('wasa/user_sm_sp/content_proyek_file');
	// 		$this->load->view('wasa/user_sm_sp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) { //user_pm_sp

	// 		$this->load->view('wasa/user_pm_sp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_pm_sp/user_menu');
	// 		$this->load->view('wasa/user_pm_sp/left_menu');
	// 		$this->load->view('wasa/user_pm_sp/header_menu');
	// 		$this->load->view('wasa/user_pm_sp/content_proyek_file');
	// 		$this->load->view('wasa/user_pm_sp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) { //user_staff_procurement_kp

	// 		$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_staff_procurement_kp/user_menu');
	// 		$this->load->view('wasa/user_staff_procurement_kp/left_menu');
	// 		$this->load->view('wasa/user_staff_procurement_kp/header_menu');
	// 		$this->load->view('wasa/user_staff_procurement_kp/content_proyek_file');
	// 		$this->load->view('wasa/user_staff_procurement_kp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) { //user_kasie_procurement_kp

	// 		$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
	// 		$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
	// 		$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
	// 		$this->load->view('wasa/user_kasie_procurement_kp/content_proyek_file');
	// 		$this->load->view('wasa/user_kasie_procurement_kp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) { //user_manajer_procurement_kp

	// 		$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
	// 		$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
	// 		$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
	// 		$this->load->view('wasa/user_manajer_procurement_kp/content_proyek_file');
	// 		$this->load->view('wasa/user_manajer_procurement_kp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) { //user_staff_procurement_sp

	// 		$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_staff_procurement_sp/user_menu');
	// 		$this->load->view('wasa/user_staff_procurement_sp/left_menu');
	// 		$this->load->view('wasa/user_staff_procurement_sp/header_menu');
	// 		$this->load->view('wasa/user_staff_procurement_sp/content_proyek_file');
	// 		$this->load->view('wasa/user_staff_procurement_sp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) { //user_supervisi_procurement_sp

	// 		$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
	// 		$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
	// 		$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
	// 		$this->load->view('wasa/user_supervisi_procurement_sp/content_proyek_file');
	// 		$this->load->view('wasa/user_supervisi_procurement_sp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) { //user_staff_umum_logistik_kp

	// 		$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
	// 		$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
	// 		$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
	// 		$this->load->view('wasa/user_staff_umum_logistik_kp/content_proyek_file');
	// 		$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) { //user_kasie_logistik_kp

	// 		$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
	// 		$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
	// 		$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
	// 		$this->load->view('wasa/user_kasie_logistik_kp/content_proyek_file');
	// 		$this->load->view('wasa/user_kasie_logistik_kp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) { //user_manajer_logistik_kp

	// 		$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
	// 		$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
	// 		$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
	// 		$this->load->view('wasa/user_manajer_logistik_kp/content_proyek_file');
	// 		$this->load->view('wasa/user_manajer_logistik_kp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) { //user_staff_umum_logistik_sp

	// 		$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
	// 		$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
	// 		$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
	// 		$this->load->view('wasa/user_staff_umum_logistik_sp/content_proyek_file');
	// 		$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) { //user_staff_gudang_logistik_sp

	// 		$this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
	// 		$this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
	// 		$this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
	// 		$this->load->view('wasa/user_staff_gudang_logistik_sp/content_proyek_file');
	// 		$this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) { //user_supervisi_logistik_sp

	// 		$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
	// 		$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
	// 		$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
	// 		$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
	// 		$this->load->view('wasa/user_supervisi_logistik_sp/content_proyek_file');
	// 		$this->load->view('wasa/user_supervisi_logistik_sp/footer');
	// 	} else {
	// 		$this->logout();
	// 	}
	// }


	function data_RAB_form()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_RAB = $this->input->post('ID_RAB');
			$data = $this->RAB_model->RAB_form_list_by_ID_RAB($ID_RAB);
			echo json_encode($data);

			$KETERANGAN = "Melihat RABP: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$data = $this->RAB_form_model->get_data_by_id_RAB_form($ID_RAB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data RAB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_RAB_form = $this->input->post('kode');
			$data_hapus = $this->RAB_form_model->get_data_by_id_RAB_form($ID_RAB_form);

			$data = $this->RAB_form_model->hapus_data_by_id_RAB_form($ID_RAB_form);
			echo json_encode($data);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function simpan_data_rab()
	{
		if ($this->ion_auth->logged_in()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_KATEGORI', 'Nama Kategori', 'trim|required|max_length[255]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RAB = $this->input->post('ID_RAB');
				$ID_PROYEK = $this->input->post('ID_PROYEK');
				$ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
				$NAMA_KATEGORI = strtoupper($this->input->post('NAMA_KATEGORI'));

				//check apakah nama NAMA_KATEGORI sudah ada. jika belum ada, akan disimpan.
				if ($this->RAB_form_model->cek_nama_kategori_rab($ID_RAB, $NAMA_KATEGORI) == 'Data belum ada') {

					// $KETERANGAN = "Tambah Data RAB: " . ";" . $ID_RAB . ";" . $NAMA_KATEGORI . ";" . $NAMA_RASD . ";" . $JENIS_RASD;
					// $this->user_log($KETERANGAN);

					// SIMPAN RAB FORM dulu
					$this->RAB_form_model->simpan_data_nama_kategori_MENGGUNAKAN_RASD($ID_RAB, $NAMA_KATEGORI);

					// AMBIL ID RAB FORM YANG BARU DIBUAT
					$ID_RAB_FORM = $this->RAB_form_model->get_data_id_rab_form($ID_RAB, $NAMA_KATEGORI);

					// kemudian SIMPAN RASD
					$this->RAB_form_model->simpan_data_rasd($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN, $ID_RAB, $ID_RAB_FORM, $NAMA_KATEGORI);

					//SET HASH MD5 RASD YANG BARU
					$this->RAB_form_model->set_md5_id_rasd($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN, $ID_RAB, $NAMA_KATEGORI);

					$HASH_MD5_RAB_FORM = $this->session->userdata('HASH_MD5_RAB_FORM');
					redirect('/RAB_form/index/' . $HASH_MD5_RAB_FORM, 'refresh');
				} else {
					echo 'Nama Kategori sudah terekam sebelumnya';
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

		$HASH_MD5_RAB = $this->session->userdata('HASH_MD5_RAB');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in()) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_RAB . '_';
			$config['upload_path']   = './assets/upload_rab_form_file/';
			$config['allowed_types'] = '|jpg|png|jpeg|bmp|pdf|xls|xlsx|doc|docx|xls|xlsx|csv|tsv|ppt|pptx|pages|odt|rtf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_rab = $this->RAB_model->get_id_rab_by_HASH_MD5_RAB($HASH_MD5_RAB);
			$ID_RAB = $query_id_rab['ID_RAB'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');
				$KETERANGAN_FILE = $this->input->post('KETERANGAN_FILE');

				$KETERANGAN = './assets/upload_rab_form_file/' . $nama;
				$this->db->insert('rab_form_file', array('ID_RAB' => $ID_RAB, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_RAB' => $HASH_MD5_RAB, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN, 'KETERANGAN_FILE' => $KETERANGAN_FILE));
				echo ($JENIS_FILE);
			} else {
				redirect($_SERVER['REQUEST_URI'], 'refresh');
			}
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
		if ($this->ion_auth->logged_in() ) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->RAB_form_file_model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_rab_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->RAB_form_file_model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_RAB = $this->session->userdata('HASH_MD5_RAB');
				redirect('/rab_form/index/' . $HASH_MD5_RAB, 'refresh');
			} else {
				$HASH_MD5_RAB = $this->session->userdata('HASH_MD5_RAB');
				redirect('/rab_form/index/' . $HASH_MD5_RAB, 'refresh');
			}
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in()) {
			$user = $this->ion_auth->user()->row();

			//set validation rules
			$this->form_validation->set_rules('NAMA_KATEGORI', 'Nama Kategori', 'trim|required|max_length[255]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				//get the form data
				$ID_RAB = $this->input->post('ID_RAB');
				$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
				$NAMA_KATEGORI = strtoupper($this->input->post('NAMA_KATEGORI'));
				$JENIS_RASD = "";
				$RENCANA_ANGGARAN = "";

				$data_rab = $this->RAB_form_model->cek_nama_kategori_rab($ID_RAB, $NAMA_KATEGORI);

				//check apakah nama NAMA_KATEGORI sudah ada. jika belum ada, akan disimpan.

				if ($this->RAB_form_model->cek_nama_kategori_rab($ID_RAB, $NAMA_KATEGORI) == 'Data belum ada') {
					$data = $this->RAB_form_model->get_data_by_id_RAB_form($ID_RAB_FORM);

					$KETERANGAN = "Ubah Data RAB Form: " . json_encode($data) . " ---- " . $ID_RAB_FORM . ";" . ";" . $NAMA_KATEGORI . ";" . $JENIS_RASD;
					$this->user_log($KETERANGAN);

					$data = $this->RAB_form_model->update_data_menjadi_RASD($ID_RAB_FORM, $NAMA_KATEGORI);
					echo $data;
				} else if ($data_rab['ID_RAB_FORM'] == $ID_RAB_FORM) {

					$data = $this->RAB_form_model->get_data_by_id_RAB_form($ID_RAB_FORM);

					$KETERANGAN = "Ubah Data RAB Form: " . json_encode($data) . " ---- " . $ID_RAB_FORM . ";" . ";" . $NAMA_KATEGORI . ";" . $JENIS_RASD;
					$this->user_log($KETERANGAN);

					$data = $this->RAB_form_model->update_data_menjadi_RASD($ID_RAB_FORM, $NAMA_KATEGORI);
					echo $data;
				} else {
					echo 'Nama Kategori sudah terekam sebelumnya';
				}
			}
			
		} else {
			$this->logout();
		}
	}

	function get_list_rasd_by_id_rab_form()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');
			$data = $this->RAB_form_model->get_list_rasd_by_id_rab_form($ID_RAB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data RASD: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_total_harga_by_id_rab_form()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RASD = $this->input->post('ID_RASD');
			$data = $this->RAB_form_model->get_total_harga_by_id_rab_form($ID_RASD);
			echo json_encode($data);

			$KETERANGAN = "Get Data Total Harga: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_sum_qty_rasd_realisasi_item_barang()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_RAB_FORM = $this->input->post('ID_RAB_FORM');

			$data = $this->RAB_form_model->data_anggaran_sum_jumlah_barang_rab_pengadaan_sebelumnya($ID_RAB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data RASD Realisasi: " . json_encode($ID_RAB_FORM);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}


	// TAMPILAN VIEW ONLY
	function view_only_RAB_form()
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

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_RAB = $this->uri->segment(3);
			$this->data['id_RAB'] = $id_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_id_RAB($id_RAB);
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_RAB_form_view');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_RAB = $this->uri->segment(3);
			$this->data['id_RAB'] = $id_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_id_RAB($id_RAB);
			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_RAB_form_view');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_RAB = $this->uri->segment(3);
			$this->data['id_RAB'] = $id_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_id_RAB($id_RAB);
			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_RAB_form_view');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	//TAMPILAN TAMBAH
	function view_RAB_form()
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

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_RAB = $this->uri->segment(3);
			$this->data['id_RAB'] = $id_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_id_RAB($id_RAB);
			$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($id_RAB);
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_RAB_form');
			$this->load->view('wasa/user_admin/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_RAB = $this->uri->segment(3);
			$this->data['id_RAB'] = $id_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_id_RAB($id_RAB);
			$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($id_RAB);
			$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
			$this->load->view('wasa/user_staff_umum_logistik_sp/content_RAB_form');
			$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			//fungsi ini untuk mengirim data ke dropdown
			$id_RAB = $this->uri->segment(3);
			$this->data['id_RAB'] = $id_RAB;
			$this->data['rab'] = $this->RAB_model->RAB_list_by_id_RAB($id_RAB);
			$this->data['barang_master_list'] = $this->RAB_form_model->barang_master_list_where_not_in_RAB($id_RAB);
			$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
			$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
			$this->load->view('wasa/user_supervisi_logistik_sp/content_RAB_form');
			$this->load->view('wasa/user_supervisi_logistik_sp/footer');
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
}
