<?php defined('BASEPATH') or exit('No direct script access allowed');

class Surat_Jalan_form extends CI_Controller
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
		$this->load->model('Surat_Jalan_form_model');
		$this->load->model('Surat_Jalan_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('SPPB_model');
		$this->load->model('Vendor_model');
		$this->load->model('RFQ_model');
		$this->load->model('RFQ_form_model');
		$this->load->model('Proyek_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "Surat_Jalan_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{

		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses Surat Jalan Form";
		$WAKTU = date('Y-m-d H:i:s');
		$this->Surat_Jalan_form_model->user_log_surat_jalan_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->Surat_Jalan_form_model->user_log_surat_jalan_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
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

		$this->data['title'] = 'SIPESUT | Ubah SURAT JALAN';

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_SURAT_JALAN = $this->uri->segment(3);
		if ($this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN) == 'TIDAK ADA DATA SURAT JALAN') {
			redirect('Surat_Jalan', 'refresh');
		}

		//fungsi ini untuk mengirim data ke dropdown
		$HASH_MD5_SURAT_JALAN = $this->uri->segment(3);
		$hasil = $this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
		$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
		$this->data['ID_SURAT_JALAN'] = $ID_SURAT_JALAN;
		$this->data['Surat_Jalan'] = $this->Surat_Jalan_model->surat_jalan_list_by_id_surat_jalan($ID_SURAT_JALAN);
		$this->data['CATATAN_SURAT_JALAN'] = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);

		//$this->data['rasd_barang_list'] = $this->FSTB_form_model->rasd_form_list_where_not_in_fstb($ID_FSTB);
		//$this->data['barang_master_list'] = $this->FSTB_form_model->barang_master_where_not_in_fstb_and_rasd($ID_FSTB);
		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();
		$this->data['barang_master_list'] = $this->Surat_Jalan_model->barang_master_where_not_in_surat_jalan_and_rasd($ID_SURAT_JALAN);

		foreach ($this->data['Surat_Jalan']->result() as $Surat_Jalan) :
			$this->data['HASH_MD5_SURAT_JALAN'] = $Surat_Jalan->HASH_MD5_SURAT_JALAN;
			$this->data['PROGRESS_SURAT_JALAN'] = $Surat_Jalan->PROGRESS_SURAT_JALAN;
		endforeach;

		if ($this->ion_auth->logged_in()) {

			if ($this->ion_auth->in_group(10)) {
				$hasil = $this->Surat_Jalan_model->get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $hasil['ID_SPPB'];
				$this->data['NO_URUT_SPPB'] = $hasil['NO_URUT_SPPB'];
				$this->data['KEPADA'] = $hasil['KEPADA'];
				$this->data['PIC_PENERIMA_BARANG'] = $hasil['PIC_PENERIMA_BARANG'];
				$this->data['NO_HP_PIC'] = $hasil['NO_HP_PIC'];
				$this->data['TANGGAL_SURAT_JALAN_HARI'] = $hasil['TANGGAL_SURAT_JALAN_HARI'];

				$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
				$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
				$this->data['SPPB'] = $this->SPPB_model->sppb_list();

				if ($this->data['PROGRESS_SURAT_JALAN'] == "Dalam Proses Staff Logistik KP") {
					$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/content_surat_jalan_form_proses');
					$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
				} else {
					redirect('Surat_Jalan', 'refresh');
				}
			} else if ($this->ion_auth->in_group(11)) {
				$hasil = $this->Surat_Jalan_model->get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $hasil['ID_SPPB'];
				$this->data['NO_URUT_SPPB'] = $hasil['NO_URUT_SPPB'];
				$this->data['KEPADA'] = $hasil['KEPADA'];
				$this->data['PIC_PENERIMA_BARANG'] = $hasil['PIC_PENERIMA_BARANG'];
				$this->data['NO_HP_PIC'] = $hasil['NO_HP_PIC'];
				$this->data['TANGGAL_SURAT_JALAN_HARI'] = $hasil['TANGGAL_SURAT_JALAN_HARI'];

				$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
				$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
				$this->data['SPPB'] = $this->SPPB_model->sppb_list();

				if ($this->data['PROGRESS_SURAT_JALAN'] == "Dalam Proses Kasie Logistik KP") {
					$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/content_surat_jalan_form_proses');
					$this->load->view('wasa/user_kasie_logistik_kp/footer');
				} else {
					redirect('Surat_Jalan', 'refresh');
				}
			} else if ($this->ion_auth->in_group(12)) {
				$hasil = $this->Surat_Jalan_model->get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $hasil['ID_SPPB'];
				$this->data['NO_URUT_SPPB'] = $hasil['NO_URUT_SPPB'];
				$this->data['KEPADA'] = $hasil['KEPADA'];
				$this->data['PIC_PENERIMA_BARANG'] = $hasil['PIC_PENERIMA_BARANG'];
				$this->data['NO_HP_PIC'] = $hasil['NO_HP_PIC'];
				$this->data['TANGGAL_SURAT_JALAN_HARI'] = $hasil['TANGGAL_SURAT_JALAN_HARI'];

				$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
				$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
				$this->data['SPPB'] = $this->SPPB_model->sppb_list();

				if ($this->data['PROGRESS_SURAT_JALAN'] == "Dalam Proses Manajer Logistik KP") {
					$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
					$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
					$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
					$this->load->view('wasa/user_manajer_logistik_kp/content_surat_jalan_form_proses');
					$this->load->view('wasa/user_manajer_logistik_kp/footer');
				} else {
					redirect('Surat_Jalan', 'refresh');
				}
			} else if ($this->ion_auth->in_group(13)) {
				$hasil = $this->Surat_Jalan_model->get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $hasil['ID_SPPB'];
				$this->data['NO_URUT_SPPB'] = $hasil['NO_URUT_SPPB'];
				$this->data['KEPADA'] = $hasil['KEPADA'];
				$this->data['PIC_PENERIMA_BARANG'] = $hasil['PIC_PENERIMA_BARANG'];
				$this->data['NO_HP_PIC'] = $hasil['NO_HP_PIC'];
				$this->data['TANGGAL_SURAT_JALAN_HARI'] = $hasil['TANGGAL_SURAT_JALAN_HARI'];

				$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
				$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_proyek($this->data['ID_PROYEK']);

				if ($this->data['PROGRESS_SURAT_JALAN'] == "Dalam Proses Staff Umum Logistik SP") {
					$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/content_surat_jalan_form_proses');
					$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
				} else {
					redirect('Surat_Jalan', 'refresh');
				}
			} else if ($this->ion_auth->in_group(15)) {
				$hasil = $this->Surat_Jalan_model->get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$ID_SPPB = $hasil['ID_SPPB'];
				$this->data['ID_SPPB'] = $hasil['ID_SPPB'];
				$this->data['NO_URUT_SPPB'] = $hasil['NO_URUT_SPPB'];
				$this->data['KEPADA'] = $hasil['KEPADA'];
				$this->data['PIC_PENERIMA_BARANG'] = $hasil['PIC_PENERIMA_BARANG'];
				$this->data['NO_HP_PIC'] = $hasil['NO_HP_PIC'];
				$this->data['TANGGAL_SURAT_JALAN_HARI'] = $hasil['TANGGAL_SURAT_JALAN_HARI'];

				$data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
				$this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
				$this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_proyek($this->data['ID_PROYEK']);

				if ($this->data['PROGRESS_SURAT_JALAN'] == "Dalam Proses Supervisor Logistik SP") {
					$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
					$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
					$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
					$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
					$this->load->view('wasa/user_supervisi_logistik_sp/content_surat_jalan_form_proses');
					$this->load->view('wasa/user_supervisi_logistik_sp/footer');
				} else {
					redirect('Surat_Jalan', 'refresh');
				}
			}
		} else {
			$this->logout();
		}
	}

	function data_surat_jalan_form()
	{

		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_by_id_Surat_Jalan($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Surat Jalan Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_by_id_Surat_Jalan($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Surat Jalan Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_by_id_Surat_Jalan($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Surat Jalan Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_by_id_Surat_Jalan($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Surat Jalan Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_by_id_Surat_Jalan($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Surat Jalan Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_catatan_surat_jalan()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan Surat Jalan: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan Surat Jalan: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan Surat Jalan: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan Surat Jalan: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Catatan Surat Jalan: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_SURAT_JALAN_FORM = $this->input->post('kode');
			$data_hapus = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Surat_Jalan_form_model->hapus_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_SURAT_JALAN_FORM = $this->input->post('kode');
			$data_hapus = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Surat_Jalan_form_model->hapus_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_SURAT_JALAN_FORM = $this->input->post('kode');
			$data_hapus = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Surat_Jalan_form_model->hapus_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_SURAT_JALAN_FORM = $this->input->post('kode');
			$data_hapus = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Surat_Jalan_form_model->hapus_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
			echo json_encode($data);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_SURAT_JALAN_FORM = $this->input->post('kode');
			$data_hapus = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);

			$KETERANGAN = "Hapus Data Proyek: " . json_encode($data_hapus);
			$this->user_log($KETERANGAN);

			$data = $this->Surat_Jalan_form_model->hapus_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}

	function simpan_data_dari_barang_master()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

			$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->Surat_Jalan_form_model->simpan_data_dari_barang_master(
					$ID_SURAT_JALAN,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$data->GROSS_WEIGHT,
					$data->NETT_WEIGHT,
					$data->DIMENSI_PANJANG,
					$data->DIMENSI_LEBAR,
					$data->DIMENSI_TINGGI,
					$jumlah
				);
				$KETERANGAN = "Tambah Data Surat Jalan Form (dari barang master): " . ";" . $ID_SURAT_JALAN . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

			$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->Surat_Jalan_form_model->simpan_data_dari_barang_master(
					$ID_SURAT_JALAN,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$data->GROSS_WEIGHT,
					$data->NETT_WEIGHT,
					$data->DIMENSI_PANJANG,
					$data->DIMENSI_LEBAR,
					$data->DIMENSI_TINGGI,
					$jumlah
				);
				$KETERANGAN = "Tambah Data Surat Jalan Form (dari barang master): " . ";" . $ID_SURAT_JALAN . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

			$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->Surat_Jalan_form_model->simpan_data_dari_barang_master(
					$ID_SURAT_JALAN,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$data->GROSS_WEIGHT,
					$data->NETT_WEIGHT,
					$data->DIMENSI_PANJANG,
					$data->DIMENSI_LEBAR,
					$data->DIMENSI_TINGGI,
					$jumlah
				);
				$KETERANGAN = "Tambah Data Surat Jalan Form (dari barang master): " . ";" . $ID_SURAT_JALAN . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

			$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->Surat_Jalan_form_model->simpan_data_dari_barang_master(
					$ID_SURAT_JALAN,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$data->GROSS_WEIGHT,
					$data->NETT_WEIGHT,
					$data->DIMENSI_PANJANG,
					$data->DIMENSI_LEBAR,
					$data->DIMENSI_TINGGI,
					$jumlah
				);
				$KETERANGAN = "Tambah Data Surat Jalan Form (dari barang master): " . ";" . $ID_SURAT_JALAN . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

			$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
			$ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
			foreach ($ID_BARANG_MASTER as $index => $ID_MASTER) {
				$data = $this->Barang_master_model->barang_master_list_by_id_barang_master($ID_MASTER);
				// if ($data->ID_RASD_FORM == "") { //PERLU DICEK LAGI INI
				// 	$id_rasd = 'NULL';
				// } else {
				// 	$id_rasd = $data->ID_RASD_FORM;
				// }
				$id_rasd = 'NULL';
				$jumlah = $this->input->post($ID_MASTER);
				$this->Surat_Jalan_form_model->simpan_data_dari_barang_master(
					$ID_SURAT_JALAN,
					$ID_MASTER,
					$id_rasd,
					$data->ID_SATUAN_BARANG,
					$data->ID_JENIS_BARANG,
					$data->NAMA,
					$data->MEREK,
					$data->PERALATAN_PERLENGKAPAN,
					$data->SPESIFIKASI_SINGKAT,
					$data->GROSS_WEIGHT,
					$data->NETT_WEIGHT,
					$data->DIMENSI_PANJANG,
					$data->DIMENSI_LEBAR,
					$data->DIMENSI_TINGGI,
					$jumlah
				);
				$KETERANGAN = "Tambah Data Surat Jalan Form (dari barang master): " . ";" . $ID_SURAT_JALAN . ";" . $ID_MASTER . ";" . $id_rasd . ";" . $data->ID_SATUAN_BARANG . ";" . $data->ID_JENIS_BARANG . ";" . $data->NAMA . ";" . $data->MEREK . ";" . $data->PERALATAN_PERLENGKAPAN . ";" . $data->SPESIFIKASI_SINGKAT . ";" . $jumlah;
				$this->user_log($KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}

	public function simpan_data()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_BARANG', 'Nama Barang', 'trim|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('ID_JENIS_BARANG', 'Nama Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('ID_SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH', 'Jumlah', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required');
			$this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('PACKING_STYLE', 'Packing Style', 'trim|required');
			$this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$NAMA_BARANG = $this->input->post('NAMA_BARANG');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_JENIS_BARANG = $this->input->post('ID_JENIS_BARANG');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG');
				$JUMLAH = $this->input->post('JUMLAH');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
				$GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
				$PACKING_STYLE = $this->input->post('PACKING_STYLE');
				$DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
				$DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
				$DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');

				//check apakah nama Surat_Jalan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Surat_Jalan_form_model->cek_nama_barang_surat_jalan_form($NAMA_BARANG, $ID_SURAT_JALAN) == 'Data belum ada') {
					$data = $this->Surat_Jalan_form_model->simpan_data(
						$ID_SURAT_JALAN,
						$NAMA_BARANG,
						$MEREK,
						$SPESIFIKASI_SINGKAT,
						$ID_JENIS_BARANG,
						$PERALATAN_PERLENGKAPAN,
						$ID_SATUAN_BARANG,
						$JUMLAH,
						$KETERANGAN,
						$NETT_WEIGHT,
						$GROSS_WEIGHT,
						$PACKING_STYLE,
						$DIMENSI_PANJANG,
						$DIMENSI_LEBAR,
						$DIMENSI_TINGGI
					);

					$KETERANGAN = "Tambah Data Surat Jalan Form (MODAL_ADD_NEW): " . ";" . $ID_SURAT_JALAN  . ";" . $NAMA_BARANG . ";" . $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $ID_JENIS_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_SATUAN_BARANG . ";" . $JUMLAH . ";" . $KETERANGAN . ";" . $NETT_WEIGHT . ";" . $GROSS_WEIGHT . ";" . $PACKING_STYLE . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_BARANG', 'Nama Barang', 'trim|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('ID_JENIS_BARANG', 'Nama Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('ID_SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH', 'Jumlah', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required');
			$this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('PACKING_STYLE', 'Packing Style', 'trim|required');
			$this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$NAMA_BARANG = $this->input->post('NAMA_BARANG');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_JENIS_BARANG = $this->input->post('ID_JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG');
				$JUMLAH = $this->input->post('JUMLAH');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
				$GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
				$PACKING_STYLE = $this->input->post('PACKING_STYLE');
				$DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
				$DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
				$DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');

				//check apakah nama Surat_Jalan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Surat_Jalan_form_model->cek_nama_barang_surat_jalan_form($NAMA_BARANG, $ID_SURAT_JALAN) == 'Data belum ada') {
					$data = $this->Surat_Jalan_form_model->simpan_data(
						$ID_SURAT_JALAN,
						$NAMA_BARANG,
						$SPESIFIKASI_SINGKAT,
						$ID_JENIS_BARANG,
						$ID_SATUAN_BARANG,
						$JUMLAH,
						$KETERANGAN,
						$NETT_WEIGHT,
						$GROSS_WEIGHT,
						$PACKING_STYLE,
						$DIMENSI_PANJANG,
						$DIMENSI_LEBAR,
						$DIMENSI_TINGGI
					);

					$KETERANGAN = "Tambah Data Surat Jalan Form (MODAL_ADD_NEW): " . ";" . $ID_SURAT_JALAN  . ";" . $NAMA_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $ID_JENIS_BARANG . ";" . $ID_SATUAN_BARANG . ";" . $JUMLAH . ";" . $KETERANGAN . ";" . $NETT_WEIGHT . ";" . $GROSS_WEIGHT . ";" . $PACKING_STYLE . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_BARANG', 'Nama Barang', 'trim|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('ID_JENIS_BARANG', 'Nama Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('ID_SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH', 'Jumlah', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required');
			$this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('PACKING_STYLE', 'Packing Style', 'trim|required');
			$this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$NAMA_BARANG = $this->input->post('NAMA_BARANG');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_JENIS_BARANG = $this->input->post('ID_JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG');
				$JUMLAH = $this->input->post('JUMLAH');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
				$GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
				$PACKING_STYLE = $this->input->post('PACKING_STYLE');
				$DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
				$DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
				$DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');

				//check apakah nama Surat_Jalan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Surat_Jalan_form_model->cek_nama_barang_surat_jalan_form($NAMA_BARANG, $ID_SURAT_JALAN) == 'Data belum ada') {
					$data = $this->Surat_Jalan_form_model->simpan_data(
						$ID_SURAT_JALAN,
						$NAMA_BARANG,
						$SPESIFIKASI_SINGKAT,
						$ID_JENIS_BARANG,
						$ID_SATUAN_BARANG,
						$JUMLAH,
						$KETERANGAN,
						$NETT_WEIGHT,
						$GROSS_WEIGHT,
						$PACKING_STYLE,
						$DIMENSI_PANJANG,
						$DIMENSI_LEBAR,
						$DIMENSI_TINGGI
					);

					$KETERANGAN = "Tambah Data Surat Jalan Form (MODAL_ADD_NEW): " . ";" . $ID_SURAT_JALAN  . ";" . $NAMA_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $ID_JENIS_BARANG . ";" . $ID_SATUAN_BARANG . ";" . $JUMLAH . ";" . $KETERANGAN . ";" . $NETT_WEIGHT . ";" . $GROSS_WEIGHT . ";" . $PACKING_STYLE . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_BARANG', 'Nama Barang', 'trim|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('ID_JENIS_BARANG', 'Nama Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('ID_SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH', 'Jumlah', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required');
			$this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('PACKING_STYLE', 'Packing Style', 'trim|required');
			$this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$NAMA_BARANG = $this->input->post('NAMA_BARANG');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_JENIS_BARANG = $this->input->post('ID_JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG');
				$JUMLAH = $this->input->post('JUMLAH');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
				$GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
				$PACKING_STYLE = $this->input->post('PACKING_STYLE');
				$DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
				$DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
				$DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');

				//check apakah nama Surat_Jalan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Surat_Jalan_form_model->cek_nama_barang_surat_jalan_form($NAMA_BARANG, $ID_SURAT_JALAN) == 'Data belum ada') {
					$data = $this->Surat_Jalan_form_model->simpan_data(
						$ID_SURAT_JALAN,
						$NAMA_BARANG,
						$SPESIFIKASI_SINGKAT,
						$ID_JENIS_BARANG,
						$ID_SATUAN_BARANG,
						$JUMLAH,
						$KETERANGAN,
						$NETT_WEIGHT,
						$GROSS_WEIGHT,
						$PACKING_STYLE,
						$DIMENSI_PANJANG,
						$DIMENSI_LEBAR,
						$DIMENSI_TINGGI
					);

					$KETERANGAN = "Tambah Data Surat Jalan Form (MODAL_ADD_NEW): " . ";" . $ID_SURAT_JALAN  . ";" . $NAMA_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $ID_JENIS_BARANG . ";" . $ID_SATUAN_BARANG . ";" . $JUMLAH . ";" . $KETERANGAN . ";" . $NETT_WEIGHT . ";" . $GROSS_WEIGHT . ";" . $PACKING_STYLE . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_BARANG', 'Nama Barang', 'trim|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('ID_JENIS_BARANG', 'Nama Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('ID_SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH', 'Jumlah', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required');
			$this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('PACKING_STYLE', 'Packing Style', 'trim|required');
			$this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$NAMA_BARANG = $this->input->post('NAMA_BARANG');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_JENIS_BARANG = $this->input->post('ID_JENIS_BARANG');
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG');
				$JUMLAH = $this->input->post('JUMLAH');
				$KETERANGAN = $this->input->post('KETERANGAN');
				$NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
				$GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
				$PACKING_STYLE = $this->input->post('PACKING_STYLE');
				$DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
				$DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
				$DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');

				//check apakah nama Surat_Jalan_form sudah ada. jika belum ada, akan disimpan.
				if ($this->Surat_Jalan_form_model->cek_nama_barang_surat_jalan_form($NAMA_BARANG, $ID_SURAT_JALAN) == 'Data belum ada') {
					$data = $this->Surat_Jalan_form_model->simpan_data(
						$ID_SURAT_JALAN,
						$NAMA_BARANG,
						$SPESIFIKASI_SINGKAT,
						$ID_JENIS_BARANG,
						$ID_SATUAN_BARANG,
						$JUMLAH,
						$KETERANGAN,
						$NETT_WEIGHT,
						$GROSS_WEIGHT,
						$PACKING_STYLE,
						$DIMENSI_PANJANG,
						$DIMENSI_LEBAR,
						$DIMENSI_TINGGI
					);

					$KETERANGAN = "Tambah Data Surat Jalan Form (MODAL_ADD_NEW): " . ";" . $ID_SURAT_JALAN  . ";" . $NAMA_BARANG . ";" . $SPESIFIKASI_SINGKAT . ";" . $ID_JENIS_BARANG . ";" . $ID_SATUAN_BARANG . ";" . $JUMLAH . ";" . $KETERANGAN . ";" . $NETT_WEIGHT . ";" . $GROSS_WEIGHT . ";" . $PACKING_STYLE . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI;
					$this->user_log($KETERANGAN);
				} else {
					echo 'Nama Item Barang sudah terekam sebelumnya. Mohon gunakan nama yang lain';
				}
			}
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_BARANG', 'Nama Barang', 'trim|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('ID_JENIS_BARANG', 'Nama Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('ID_SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH', 'Jumlah', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required');
			$this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('PACKING_STYLE', 'Packing Style', 'trim|required');
			$this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|numeric|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN_FORM = $this->input->post('ID_SURAT_JALAN_FORM');
				$NAMA_BARANG = $this->input->post('NAMA_BARANG');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_JENIS_BARANG = $this->input->post('ID_JENIS_BARANG');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG');
				$JUMLAH = $this->input->post('JUMLAH');
				$KETERANGAN_SURAT_JALAN = $this->input->post('KETERANGAN');
				$NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
				$GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
				$PACKING_STYLE = $this->input->post('PACKING_STYLE');
				$DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
				$DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
				$DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');

				$data_edit = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
				$KETERANGAN = "Ubah Data Surat Jalan Form: " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN_FORM  . ";" . $NAMA_BARANG . ";" .  $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $ID_JENIS_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_SATUAN_BARANG . ";" . $JUMLAH . ";" . $KETERANGAN_SURAT_JALAN . ";" . $NETT_WEIGHT . ";" . $GROSS_WEIGHT . ";" . $PACKING_STYLE . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data(
					$ID_SURAT_JALAN_FORM,
					$NAMA_BARANG,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$ID_JENIS_BARANG,
					$PERALATAN_PERLENGKAPAN,
					$ID_SATUAN_BARANG,
					$JUMLAH,
					$KETERANGAN_SURAT_JALAN,
					$NETT_WEIGHT,
					$GROSS_WEIGHT,
					$PACKING_STYLE,
					$DIMENSI_PANJANG,
					$DIMENSI_LEBAR,
					$DIMENSI_TINGGI
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_BARANG', 'Nama Barang', 'trim|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('ID_JENIS_BARANG', 'Nama Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('ID_SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH', 'Jumlah', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required');
			$this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('PACKING_STYLE', 'Packing Style', 'trim|required');
			$this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|numeric|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN_FORM = $this->input->post('ID_SURAT_JALAN_FORM');
				$NAMA_BARANG = $this->input->post('NAMA_BARANG');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_JENIS_BARANG = $this->input->post('ID_JENIS_BARANG');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG');
				$JUMLAH = $this->input->post('JUMLAH');
				$KETERANGAN_SURAT_JALAN = $this->input->post('KETERANGAN');
				$NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
				$GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
				$PACKING_STYLE = $this->input->post('PACKING_STYLE');
				$DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
				$DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
				$DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');

				$data_edit = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
				$KETERANGAN = "Ubah Data Surat Jalan Form: " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN_FORM  . ";" . $NAMA_BARANG . ";" .  $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $ID_JENIS_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_SATUAN_BARANG . ";" . $JUMLAH . ";" . $KETERANGAN_SURAT_JALAN . ";" . $NETT_WEIGHT . ";" . $GROSS_WEIGHT . ";" . $PACKING_STYLE . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data(
					$ID_SURAT_JALAN_FORM,
					$NAMA_BARANG,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$ID_JENIS_BARANG,
					$PERALATAN_PERLENGKAPAN,
					$ID_SATUAN_BARANG,
					$JUMLAH,
					$KETERANGAN_SURAT_JALAN,
					$NETT_WEIGHT,
					$GROSS_WEIGHT,
					$PACKING_STYLE,
					$DIMENSI_PANJANG,
					$DIMENSI_LEBAR,
					$DIMENSI_TINGGI
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_BARANG', 'Nama Barang', 'trim|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('ID_JENIS_BARANG', 'Nama Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('ID_SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH', 'Jumlah', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required');
			$this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('PACKING_STYLE', 'Packing Style', 'trim|required');
			$this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|numeric|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN_FORM = $this->input->post('ID_SURAT_JALAN_FORM');
				$NAMA_BARANG = $this->input->post('NAMA_BARANG');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_JENIS_BARANG = $this->input->post('ID_JENIS_BARANG');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG');
				$JUMLAH = $this->input->post('JUMLAH');
				$KETERANGAN_SURAT_JALAN = $this->input->post('KETERANGAN');
				$NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
				$GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
				$PACKING_STYLE = $this->input->post('PACKING_STYLE');
				$DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
				$DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
				$DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');

				$data_edit = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
				$KETERANGAN = "Ubah Data Surat Jalan Form: " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN_FORM  . ";" . $NAMA_BARANG . ";" .  $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $ID_JENIS_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_SATUAN_BARANG . ";" . $JUMLAH . ";" . $KETERANGAN_SURAT_JALAN . ";" . $NETT_WEIGHT . ";" . $GROSS_WEIGHT . ";" . $PACKING_STYLE . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data(
					$ID_SURAT_JALAN_FORM,
					$NAMA_BARANG,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$ID_JENIS_BARANG,
					$PERALATAN_PERLENGKAPAN,
					$ID_SATUAN_BARANG,
					$JUMLAH,
					$KETERANGAN_SURAT_JALAN,
					$NETT_WEIGHT,
					$GROSS_WEIGHT,
					$PACKING_STYLE,
					$DIMENSI_PANJANG,
					$DIMENSI_LEBAR,
					$DIMENSI_TINGGI
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_BARANG', 'Nama Barang', 'trim|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('ID_JENIS_BARANG', 'Nama Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('ID_SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH', 'Jumlah', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required');
			$this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('PACKING_STYLE', 'Packing Style', 'trim|required');
			$this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|numeric|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN_FORM = $this->input->post('ID_SURAT_JALAN_FORM');
				$NAMA_BARANG = $this->input->post('NAMA_BARANG');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_JENIS_BARANG = $this->input->post('ID_JENIS_BARANG');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG');
				$JUMLAH = $this->input->post('JUMLAH');
				$KETERANGAN_SURAT_JALAN = $this->input->post('KETERANGAN');
				$NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
				$GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
				$PACKING_STYLE = $this->input->post('PACKING_STYLE');
				$DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
				$DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
				$DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');

				$data_edit = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
				$KETERANGAN = "Ubah Data Surat Jalan Form: " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN_FORM  . ";" . $NAMA_BARANG . ";" .  $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $ID_JENIS_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_SATUAN_BARANG . ";" . $JUMLAH . ";" . $KETERANGAN_SURAT_JALAN . ";" . $NETT_WEIGHT . ";" . $GROSS_WEIGHT . ";" . $PACKING_STYLE . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data(
					$ID_SURAT_JALAN_FORM,
					$NAMA_BARANG,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$ID_JENIS_BARANG,
					$PERALATAN_PERLENGKAPAN,
					$ID_SATUAN_BARANG,
					$JUMLAH,
					$KETERANGAN_SURAT_JALAN,
					$NETT_WEIGHT,
					$GROSS_WEIGHT,
					$PACKING_STYLE,
					$DIMENSI_PANJANG,
					$DIMENSI_LEBAR,
					$DIMENSI_TINGGI
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

			//set validation rules
			$this->form_validation->set_rules('NAMA_BARANG', 'Nama Barang', 'trim|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|required');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required');
			$this->form_validation->set_rules('ID_JENIS_BARANG', 'Nama Jenis Barang', 'trim|required');
			$this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
			$this->form_validation->set_rules('ID_SATUAN_BARANG', 'Satuan Barang', 'trim|required');
			$this->form_validation->set_rules('JUMLAH', 'Jumlah', 'trim|required|numeric|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|required');
			$this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('PACKING_STYLE', 'Packing Style', 'trim|required');
			$this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|numeric|less_than[99999999999]');
			$this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|numeric|less_than[99999999999]');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN_FORM = $this->input->post('ID_SURAT_JALAN_FORM');
				$NAMA_BARANG = $this->input->post('NAMA_BARANG');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$ID_JENIS_BARANG = $this->input->post('ID_JENIS_BARANG');
				$PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
				$ID_SATUAN_BARANG = $this->input->post('ID_SATUAN_BARANG');
				$JUMLAH = $this->input->post('JUMLAH');
				$KETERANGAN_SURAT_JALAN = $this->input->post('KETERANGAN');
				$NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
				$GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
				$PACKING_STYLE = $this->input->post('PACKING_STYLE');
				$DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
				$DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
				$DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');

				$data_edit = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
				$KETERANGAN = "Ubah Data Surat Jalan Form: " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN_FORM  . ";" . $NAMA_BARANG . ";" .  $MEREK . ";" . $SPESIFIKASI_SINGKAT . ";" . $ID_JENIS_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $ID_SATUAN_BARANG . ";" . $JUMLAH . ";" . $KETERANGAN_SURAT_JALAN . ";" . $NETT_WEIGHT . ";" . $GROSS_WEIGHT . ";" . $PACKING_STYLE . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data(
					$ID_SURAT_JALAN_FORM,
					$NAMA_BARANG,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$ID_JENIS_BARANG,
					$PERALATAN_PERLENGKAPAN,
					$ID_SATUAN_BARANG,
					$JUMLAH,
					$KETERANGAN_SURAT_JALAN,
					$NETT_WEIGHT,
					$GROSS_WEIGHT,
					$PACKING_STYLE,
					$DIMENSI_PANJANG,
					$DIMENSI_LEBAR,
					$DIMENSI_TINGGI
				);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_catatan_surat_jalan()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_LOG_KP', 'Catatan Surat Jalan Staff Logistik KP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$CTT_STAFF_LOG_KP = $this->input->post('CTT_STAFF_LOG_KP');

				$data_edit = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Catatan Surat Jalan (User Staff Logistik KP): " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN . ";" . $CTT_STAFF_LOG_KP;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data_CTT_STAFF_LOG_KP($ID_SURAT_JALAN, $CTT_STAFF_LOG_KP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_KASIE_LOG_KP', 'Catatan Surat Jalan Kasie Logistik KP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$CTT_KASIE_LOG_KP = $this->input->post('CTT_KASIE_LOG_KP');

				$data_edit = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Catatan Surat Jalan (User Kasie Logistik KP): " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN . ";" . $CTT_KASIE_LOG_KP;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data_CTT_KASIE_LOG_KP($ID_SURAT_JALAN, $CTT_KASIE_LOG_KP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_MAN_LOG_KP', 'Catatan Surat Jalan Manajer Logistik KP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$CTT_MAN_LOG_KP = $this->input->post('CTT_MAN_LOG_KP');

				$data_edit = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Catatan Surat Jalan (User Manajer Logistik KP): " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN . ";" . $CTT_MAN_LOG_KP;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data_CTT_MAN_LOG_KP($ID_SURAT_JALAN, $CTT_MAN_LOG_KP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_STAFF_UMUM_LOG_SP', 'Catatan Surat Jalan Staff Umum Logistik SP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$CTT_STAFF_UMUM_LOG_SP = $this->input->post('CTT_STAFF_UMUM_LOG_SP');

				$data_edit = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Catatan Surat Jalan (User Staff Umum Logistik SP): " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN . ";" . $CTT_STAFF_UMUM_LOG_SP;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data_CTT_STAFF_UMUM_LOG_SP($ID_SURAT_JALAN, $CTT_STAFF_UMUM_LOG_SP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('CTT_SPV_LOG_SP', 'Catatan Surat Jalan Supervisi Logistik SP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$CTT_SPV_LOG_SP = $this->input->post('CTT_SPV_LOG_SP');

				$data_edit = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Catatan Surat Jalan (User Supervisi Logistik SP): " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN . ";" . $CTT_SPV_LOG_SP;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data_CTT_SPV_LOG_SP($ID_SURAT_JALAN, $CTT_SPV_LOG_SP);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_kirim_surat_jalan()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SURAT_JALAN', 'SURAT JALAN ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');

				$KETERANGAN = "Kirim Form Surat ke Kasie Logistik KP untuk diperiksa (User Staff Logistik KP): " . " ---- " . $ID_SURAT_JALAN;
				$this->user_log($KETERANGAN);

				$PROGRESS_SURAT_JALAN = "Dalam Proses Kasie Logistik KP";
				$STATUS_SURAT_JALAN = "Proses Pengajuan";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_SURAT_JALAN = date("d-m-Y", $d);

				$data = $this->Surat_Jalan_form_model->update_data_kirim_surat_jalan($ID_SURAT_JALAN, $PROGRESS_SURAT_JALAN, $STATUS_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SURAT_JALAN', 'SURAT JALAN ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');

				$KETERANGAN = "Kirim Form Surat ke Manajer Logistik KP untuk diperiksa (User Kasie Logistik KP): " . " ---- " . $ID_SURAT_JALAN;
				$this->user_log($KETERANGAN);

				$PROGRESS_SURAT_JALAN = "Dalam Proses Manajer Logistik KP";
				$STATUS_SURAT_JALAN = "Proses Pengajuan";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_SURAT_JALAN = date("d-m-Y", $d);

				$data = $this->Surat_Jalan_form_model->update_data_kirim_surat_jalan($ID_SURAT_JALAN, $PROGRESS_SURAT_JALAN, $STATUS_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SURAT_JALAN', 'SURAT JALAN ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');

				$KETERANGAN = "Surat Jalan Disetujui (User Manajer Logistik KP): " . " ---- " . $ID_SURAT_JALAN;
				$this->user_log($KETERANGAN);

				$PROGRESS_SURAT_JALAN = "Surat Jalan Disetujui";
				$STATUS_SURAT_JALAN = "Selesai";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_SURAT_JALAN = date("d-m-Y", $d);

				$data = $this->Surat_Jalan_form_model->update_data_kirim_surat_jalan($ID_SURAT_JALAN, $PROGRESS_SURAT_JALAN, $STATUS_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SURAT_JALAN', 'SURAT JALAN ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');

				$KETERANGAN = "Kirim Form Surat Jalan ke Supervisor Logistik SP untuk diperiksa (User Staff Umum Logistik SP): " . " ---- " . $ID_SURAT_JALAN;
				$this->user_log($KETERANGAN);

				$PROGRESS_SURAT_JALAN = "Dalam Proses Supervisor Logistik SP";
				$STATUS_SURAT_JALAN = "Proses Pengajuan";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_SURAT_JALAN = date("d-m-Y", $d);

				$data = $this->Surat_Jalan_form_model->update_data_kirim_surat_jalan($ID_SURAT_JALAN, $PROGRESS_SURAT_JALAN, $STATUS_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {


			//set validation rules
			$this->form_validation->set_rules('ID_SURAT_JALAN', 'SURAT JALAN ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');

				$KETERANGAN = "Kirim Form Surat ke Staff Logistik KP untuk diperiksa (User Supervisor Logistik SP): " . " ---- " . $ID_SURAT_JALAN;
				$this->user_log($KETERANGAN);

				$PROGRESS_SURAT_JALAN = "Dalam Proses Staff Logistik KP";
				$STATUS_SURAT_JALAN = "Proses Pengajuan";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_SURAT_JALAN = date("d-m-Y", $d);

				$data = $this->Surat_Jalan_form_model->update_data_kirim_surat_jalan($ID_SURAT_JALAN, $PROGRESS_SURAT_JALAN, $STATUS_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_coret()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

				$KETERANGAN = "Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->FSTB_form_model->update_data_coret($ID_FSTB_FORM);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_batal_coret()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

				$KETERANGAN = "Batal Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
				$this->user_log($KETERANGAN);

				$data = $this->FSTB_form_model->update_data_batal_coret($ID_FSTB_FORM);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function update_data_tanggal()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			$id = $this->input->post('id');
			$field = $this->input->post('field');
			$value = $this->input->post('value');

			$KETERANGAN = "Update Tanggal Mulai Pemakaian (User Staff Logistik KP): " . " ---- " . $id . " ;" . $field . " ;" . $value;
			$this->user_log($KETERANGAN);

			$data = $this->Surat_Jalan_form_model->update_data_tanggal($id, $field, $value);
			echo ($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			$id = $this->input->post('id');
			$field = $this->input->post('field');
			$value = $this->input->post('value');

			$KETERANGAN = "Update Tanggal Mulai Pemakaian (User Kasie Logistik KP): " . " ---- " . $id . " ;" . $field . " ;" . $value;
			$this->user_log($KETERANGAN);

			$data = $this->Surat_Jalan_form_model->update_data_tanggal($id, $field, $value);
			echo ($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			$id = $this->input->post('id');
			$field = $this->input->post('field');
			$value = $this->input->post('value');

			$KETERANGAN = "Update Tanggal Mulai Pemakaian (User Manajer Logistik KP): " . " ---- " . $id . " ;" . $field . " ;" . $value;
			$this->user_log($KETERANGAN);

			$data = $this->Surat_Jalan_form_model->update_data_tanggal($id, $field, $value);
			echo ($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			$id = $this->input->post('id');
			$field = $this->input->post('field');
			$value = $this->input->post('value');

			$KETERANGAN = "Update Tanggal Mulai Pemakaian (User Staff Umum Logistik SP): " . " ---- " . $id . " ;" . $field . " ;" . $value;
			$this->user_log($KETERANGAN);

			$data = $this->Surat_Jalan_form_model->update_data_tanggal($id, $field, $value);
			echo ($data);
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			$id = $this->input->post('id');
			$field = $this->input->post('field');
			$value = $this->input->post('value');

			$KETERANGAN = "Update Tanggal Mulai Pemakaian (User Supervisi Logistik SP): " . " ---- " . $id . " ;" . $field . " ;" . $value;
			$this->user_log($KETERANGAN);

			$data = $this->Surat_Jalan_form_model->update_data_tanggal($id, $field, $value);
			echo ($data);
		} else {
			$this->logout();
		}
	}

	function simpan_perubahan_pdf()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

			//set validation rules
			$this->form_validation->set_rules('NO_URUT_SPPB', 'No Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('PIC_PENERIMA_BARANG', 'PIC Penerima Barang', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PIC', 'NO HP PIC', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('TANGGAL_SURAT_JALAN_HARI', 'Tanggal Surat Jalan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
				$TANGGAL_SURAT_JALAN_HARI = $this->input->post('TANGGAL_SURAT_JALAN_HARI');
				$KEPADA = $this->input->post('KEPADA');
				$PIC_PENERIMA_BARANG = $this->input->post('PIC_PENERIMA_BARANG');
				$NO_HP_PIC = $this->input->post('NO_HP_PIC');
				$HASH_MD5_SURAT_JALAN = $this->input->post('HASH_MD5_SURAT_JALAN');

				$data_edit = $this->Surat_Jalan_model->get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Surat Jalan: " . json_encode($data_edit) . " ---- " . $NO_URUT_SPPB  . ";" . $TANGGAL_SURAT_JALAN_HARI . ";" . $KEPADA . ";" . $PIC_PENERIMA_BARANG . ";" . $NO_HP_PIC;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_model->update_data(
					$NO_URUT_SPPB,
					$TANGGAL_SURAT_JALAN_HARI,
					$KEPADA,
					$PIC_PENERIMA_BARANG,
					$NO_HP_PIC,
					$HASH_MD5_SURAT_JALAN
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

			//set validation rules
			$this->form_validation->set_rules('NO_URUT_SPPB', 'No Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('PIC_PENERIMA_BARANG', 'PIC Penerima Barang', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PIC', 'NO HP PIC', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('TANGGAL_SURAT_JALAN_HARI', 'Tanggal Surat Jalan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
				$TANGGAL_SURAT_JALAN_HARI = $this->input->post('TANGGAL_SURAT_JALAN_HARI');
				$KEPADA = $this->input->post('KEPADA');
				$PIC_PENERIMA_BARANG = $this->input->post('PIC_PENERIMA_BARANG');
				$NO_HP_PIC = $this->input->post('NO_HP_PIC');
				$HASH_MD5_SURAT_JALAN = $this->input->post('HASH_MD5_SURAT_JALAN');

				$data_edit = $this->Surat_Jalan_model->get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Surat Jalan: " . json_encode($data_edit) . " ---- " . $NO_URUT_SPPB  . ";" . $TANGGAL_SURAT_JALAN_HARI . ";" . $KEPADA . ";" . $PIC_PENERIMA_BARANG . ";" . $NO_HP_PIC;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_model->update_data(
					$NO_URUT_SPPB,
					$TANGGAL_SURAT_JALAN_HARI,
					$KEPADA,
					$PIC_PENERIMA_BARANG,
					$NO_HP_PIC,
					$HASH_MD5_SURAT_JALAN
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

			//set validation rules
			$this->form_validation->set_rules('NO_URUT_SPPB', 'No Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('PIC_PENERIMA_BARANG', 'PIC Penerima Barang', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PIC', 'NO HP PIC', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('TANGGAL_SURAT_JALAN_HARI', 'Tanggal Surat Jalan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
				$TANGGAL_SURAT_JALAN_HARI = $this->input->post('TANGGAL_SURAT_JALAN_HARI');
				$KEPADA = $this->input->post('KEPADA');
				$PIC_PENERIMA_BARANG = $this->input->post('PIC_PENERIMA_BARANG');
				$NO_HP_PIC = $this->input->post('NO_HP_PIC');
				$HASH_MD5_SURAT_JALAN = $this->input->post('HASH_MD5_SURAT_JALAN');

				$data_edit = $this->Surat_Jalan_model->get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Surat Jalan: " . json_encode($data_edit) . " ---- " . $NO_URUT_SPPB  . ";" . $TANGGAL_SURAT_JALAN_HARI . ";" . $KEPADA . ";" . $PIC_PENERIMA_BARANG . ";" . $NO_HP_PIC;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_model->update_data(
					$NO_URUT_SPPB,
					$TANGGAL_SURAT_JALAN_HARI,
					$KEPADA,
					$PIC_PENERIMA_BARANG,
					$NO_HP_PIC,
					$HASH_MD5_SURAT_JALAN
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

			//set validation rules
			$this->form_validation->set_rules('NO_URUT_SPPB', 'No Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('PIC_PENERIMA_BARANG', 'PIC Penerima Barang', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PIC', 'NO HP PIC', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('TANGGAL_SURAT_JALAN_HARI', 'Tanggal Surat Jalan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
				$TANGGAL_SURAT_JALAN_HARI = $this->input->post('TANGGAL_SURAT_JALAN_HARI');
				$KEPADA = $this->input->post('KEPADA');
				$PIC_PENERIMA_BARANG = $this->input->post('PIC_PENERIMA_BARANG');
				$NO_HP_PIC = $this->input->post('NO_HP_PIC');
				$HASH_MD5_SURAT_JALAN = $this->input->post('HASH_MD5_SURAT_JALAN');

				$data_edit = $this->Surat_Jalan_model->get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Surat Jalan: " . json_encode($data_edit) . " ---- " . $NO_URUT_SPPB  . ";" . $TANGGAL_SURAT_JALAN_HARI . ";" . $KEPADA . ";" . $PIC_PENERIMA_BARANG . ";" . $NO_HP_PIC;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_model->update_data(
					$NO_URUT_SPPB,
					$TANGGAL_SURAT_JALAN_HARI,
					$KEPADA,
					$PIC_PENERIMA_BARANG,
					$NO_HP_PIC,
					$HASH_MD5_SURAT_JALAN
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

			//set validation rules
			$this->form_validation->set_rules('NO_URUT_SPPB', 'No Urut SPPB', 'trim|required');
			$this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('PIC_PENERIMA_BARANG', 'PIC Penerima Barang', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PIC', 'NO HP PIC', 'trim|required|max_length[20]|numeric');
			$this->form_validation->set_rules('TANGGAL_SURAT_JALAN_HARI', 'Tanggal Surat Jalan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
				$TANGGAL_SURAT_JALAN_HARI = $this->input->post('TANGGAL_SURAT_JALAN_HARI');
				$KEPADA = $this->input->post('KEPADA');
				$PIC_PENERIMA_BARANG = $this->input->post('PIC_PENERIMA_BARANG');
				$NO_HP_PIC = $this->input->post('NO_HP_PIC');
				$HASH_MD5_SURAT_JALAN = $this->input->post('HASH_MD5_SURAT_JALAN');

				$data_edit = $this->Surat_Jalan_model->get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Surat Jalan: " . json_encode($data_edit) . " ---- " . $NO_URUT_SPPB  . ";" . $TANGGAL_SURAT_JALAN_HARI . ";" . $KEPADA . ";" . $PIC_PENERIMA_BARANG . ";" . $NO_HP_PIC;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_model->update_data(
					$NO_URUT_SPPB,
					$TANGGAL_SURAT_JALAN_HARI,
					$KEPADA,
					$PIC_PENERIMA_BARANG,
					$NO_HP_PIC,
					$HASH_MD5_SURAT_JALAN
				);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	function get_data()
	{

		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_SURAT_JALAN_FORM = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data Surat Jalan Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_SURAT_JALAN_FORM = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data Surat Jalan Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_SURAT_JALAN_FORM = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data Surat Jalan Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_SURAT_JALAN_FORM = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data Surat Jalan Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_SURAT_JALAN_FORM = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data Surat Jalan Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function get_data_pengiriman()
	{

		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Pengiriman: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Pengiriman: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Pengiriman: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Pengiriman: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Get Data Pengiriman: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	public function simpan_data_pengiriman()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

			//set validation rules
			$this->form_validation->set_rules('JENIS_PENGIRIMAN', 'Jenis Pengiriman', 'trim|required');
			$this->form_validation->set_rules('JENIS_KENDARAAN', 'Jenis Kendaraan', 'trim|required');
			$this->form_validation->set_rules('NO_POLISI', 'No Polisi', 'trim|required');
			$this->form_validation->set_rules('NAMA_PENGEMUDI', 'Nama Pengemudi', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PENGEMUDI', 'No HP Pengemudi', 'trim|required|numeric');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$JENIS_PENGIRIMAN = $this->input->post('JENIS_PENGIRIMAN');
				$JENIS_KENDARAAN = $this->input->post('JENIS_KENDARAAN');
				$NO_POLISI = $this->input->post('NO_POLISI');
				$NAMA_PENGEMUDI = $this->input->post('NAMA_PENGEMUDI');
				$NO_HP_PENGEMUDI = $this->input->post('NO_HP_PENGEMUDI');

				$data = $this->Surat_Jalan_form_model->simpan_data_pengiriman(
					$ID_SURAT_JALAN,
					$JENIS_PENGIRIMAN,
					$JENIS_KENDARAAN,
					$NO_POLISI,
					$NAMA_PENGEMUDI,
					$NO_HP_PENGEMUDI
				);

				$KETERANGAN = "Tambah Data Surat Jalan Form (User Staff Logistik KP): " . ";" . $ID_SURAT_JALAN  . ";" . $JENIS_PENGIRIMAN . ";" . $JENIS_KENDARAAN . ";" . $NO_POLISI . ";" . $NAMA_PENGEMUDI . ";" . $NO_HP_PENGEMUDI;
				$this->user_log($KETERANGAN);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

			//set validation rules
			$this->form_validation->set_rules('JENIS_PENGIRIMAN', 'Jenis Pengiriman', 'trim|required');
			$this->form_validation->set_rules('JENIS_KENDARAAN', 'Jenis Kendaraan', 'trim|required');
			$this->form_validation->set_rules('NO_POLISI', 'No Polisi', 'trim|required');
			$this->form_validation->set_rules('NAMA_PENGEMUDI', 'Nama Pengemudi', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PENGEMUDI', 'No HP Pengemudi', 'trim|required|numeric');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$JENIS_PENGIRIMAN = $this->input->post('JENIS_PENGIRIMAN');
				$JENIS_KENDARAAN = $this->input->post('JENIS_KENDARAAN');
				$NO_POLISI = $this->input->post('NO_POLISI');
				$NAMA_PENGEMUDI = $this->input->post('NAMA_PENGEMUDI');
				$NO_HP_PENGEMUDI = $this->input->post('NO_HP_PENGEMUDI');

				$data = $this->Surat_Jalan_form_model->simpan_data_pengiriman(
					$ID_SURAT_JALAN,
					$JENIS_PENGIRIMAN,
					$JENIS_KENDARAAN,
					$NO_POLISI,
					$NAMA_PENGEMUDI,
					$NO_HP_PENGEMUDI
				);

				$KETERANGAN = "Tambah Data Surat Jalan Form (User Kasie Logistik KP): " . ";" . $ID_SURAT_JALAN  . ";" . $JENIS_PENGIRIMAN . ";" . $JENIS_KENDARAAN . ";" . $NO_POLISI . ";" . $NAMA_PENGEMUDI . ";" . $NO_HP_PENGEMUDI;
				$this->user_log($KETERANGAN);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

			//set validation rules
			$this->form_validation->set_rules('JENIS_PENGIRIMAN', 'Jenis Pengiriman', 'trim|required');
			$this->form_validation->set_rules('JENIS_KENDARAAN', 'Jenis Kendaraan', 'trim|required');
			$this->form_validation->set_rules('NO_POLISI', 'No Polisi', 'trim|required');
			$this->form_validation->set_rules('NAMA_PENGEMUDI', 'Nama Pengemudi', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PENGEMUDI', 'No HP Pengemudi', 'trim|required|numeric');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$JENIS_PENGIRIMAN = $this->input->post('JENIS_PENGIRIMAN');
				$JENIS_KENDARAAN = $this->input->post('JENIS_KENDARAAN');
				$NO_POLISI = $this->input->post('NO_POLISI');
				$NAMA_PENGEMUDI = $this->input->post('NAMA_PENGEMUDI');
				$NO_HP_PENGEMUDI = $this->input->post('NO_HP_PENGEMUDI');

				$data = $this->Surat_Jalan_form_model->simpan_data_pengiriman(
					$ID_SURAT_JALAN,
					$JENIS_PENGIRIMAN,
					$JENIS_KENDARAAN,
					$NO_POLISI,
					$NAMA_PENGEMUDI,
					$NO_HP_PENGEMUDI
				);

				$KETERANGAN = "Tambah Data Surat Jalan Form (User Manajer Logistik KP): " . ";" . $ID_SURAT_JALAN  . ";" . $JENIS_PENGIRIMAN . ";" . $JENIS_KENDARAAN . ";" . $NO_POLISI . ";" . $NAMA_PENGEMUDI . ";" . $NO_HP_PENGEMUDI;
				$this->user_log($KETERANGAN);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

			//set validation rules
			$this->form_validation->set_rules('JENIS_PENGIRIMAN', 'Jenis Pengiriman', 'trim|required');
			$this->form_validation->set_rules('JENIS_KENDARAAN', 'Jenis Kendaraan', 'trim|required');
			$this->form_validation->set_rules('NO_POLISI', 'No Polisi', 'trim|required');
			$this->form_validation->set_rules('NAMA_PENGEMUDI', 'Nama Pengemudi', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PENGEMUDI', 'No HP Pengemudi', 'trim|required|numeric');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$JENIS_PENGIRIMAN = $this->input->post('JENIS_PENGIRIMAN');
				$JENIS_KENDARAAN = $this->input->post('JENIS_KENDARAAN');
				$NO_POLISI = $this->input->post('NO_POLISI');
				$NAMA_PENGEMUDI = $this->input->post('NAMA_PENGEMUDI');
				$NO_HP_PENGEMUDI = $this->input->post('NO_HP_PENGEMUDI');

				$data = $this->Surat_Jalan_form_model->simpan_data_pengiriman(
					$ID_SURAT_JALAN,
					$JENIS_PENGIRIMAN,
					$JENIS_KENDARAAN,
					$NO_POLISI,
					$NAMA_PENGEMUDI,
					$NO_HP_PENGEMUDI
				);

				$KETERANGAN = "Tambah Data Surat Jalan Form (User Staff Umum Logistik SP): " . ";" . $ID_SURAT_JALAN  . ";" . $JENIS_PENGIRIMAN . ";" . $JENIS_KENDARAAN . ";" . $NO_POLISI . ";" . $NAMA_PENGEMUDI . ";" . $NO_HP_PENGEMUDI;
				$this->user_log($KETERANGAN);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

			//set validation rules
			$this->form_validation->set_rules('JENIS_PENGIRIMAN', 'Jenis Pengiriman', 'trim|required');
			$this->form_validation->set_rules('JENIS_KENDARAAN', 'Jenis Kendaraan', 'trim|required');
			$this->form_validation->set_rules('NO_POLISI', 'No Polisi', 'trim|required');
			$this->form_validation->set_rules('NAMA_PENGEMUDI', 'Nama Pengemudi', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PENGEMUDI', 'No HP Pengemudi', 'trim|required|numeric');

			// run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			} else {
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$JENIS_PENGIRIMAN = $this->input->post('JENIS_PENGIRIMAN');
				$JENIS_KENDARAAN = $this->input->post('JENIS_KENDARAAN');
				$NO_POLISI = $this->input->post('NO_POLISI');
				$NAMA_PENGEMUDI = $this->input->post('NAMA_PENGEMUDI');
				$NO_HP_PENGEMUDI = $this->input->post('NO_HP_PENGEMUDI');

				$data = $this->Surat_Jalan_form_model->simpan_data_pengiriman(
					$ID_SURAT_JALAN,
					$JENIS_PENGIRIMAN,
					$JENIS_KENDARAAN,
					$NO_POLISI,
					$NAMA_PENGEMUDI,
					$NO_HP_PENGEMUDI
				);

				$KETERANGAN = "Tambah Data Surat Jalan Form (User Supervisi Logistik SP): " . ";" . $ID_SURAT_JALAN  . ";" . $JENIS_PENGIRIMAN . ";" . $JENIS_KENDARAAN . ";" . $NO_POLISI . ";" . $NAMA_PENGEMUDI . ";" . $NO_HP_PENGEMUDI;
				$this->user_log($KETERANGAN);
			}
		} else {
			$this->logout();
		}
	}

	function data_surat_jalan_form_pengiriman()
	{

		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_surat_jalan_form_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Pengiriman (User Staff Logistik KP): " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_surat_jalan_form_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Pengiriman (User Kasie Logistik KP): " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_surat_jalan_form_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Pengiriman (User Manajer Logistik KP): " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_surat_jalan_form_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Pengiriman (User Staff Umum Logistik SP): " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_SURAT_JALAN = $this->input->get('id');
			$data = $this->Surat_Jalan_form_model->get_data_surat_jalan_form_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data Pengiriman (User Supervisi Logistik SP): " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

	function update_data_pengiriman()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

			//set validation rules
			$this->form_validation->set_rules('JENIS_PENGIRIMAN', 'Jenis Pengiriman', 'trim|required');
			$this->form_validation->set_rules('JENIS_KENDARAAN', 'Jenis Kendaraan', 'trim|required');
			$this->form_validation->set_rules('NO_POLISI', 'No Polisi', 'trim|required');
			$this->form_validation->set_rules('NAMA_PENGEMUDI', 'Nama Pengemudi', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PENGEMUDI', 'No HP Pengemudi', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$JENIS_PENGIRIMAN = $this->input->post('JENIS_PENGIRIMAN');
				$JENIS_KENDARAAN = $this->input->post('JENIS_KENDARAAN');
				$NO_POLISI = $this->input->post('NO_POLISI');
				$NAMA_PENGEMUDI = $this->input->post('NAMA_PENGEMUDI');
				$NO_HP_PENGEMUDI = $this->input->post('NO_HP_PENGEMUDI');

				$data_edit = $this->Surat_Jalan_form_model->get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Pengiriman: " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN  . ";" . $JENIS_PENGIRIMAN . ";" . $JENIS_KENDARAAN . ";" . $NO_POLISI . ";" . $NAMA_PENGEMUDI . ";" . $NO_HP_PENGEMUDI;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data_pengiriman(
					$ID_SURAT_JALAN,
					$JENIS_PENGIRIMAN,
					$JENIS_KENDARAAN,
					$NO_POLISI,
					$NAMA_PENGEMUDI,
					$NO_HP_PENGEMUDI
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

			//set validation rules
			$this->form_validation->set_rules('JENIS_PENGIRIMAN', 'Jenis Pengiriman', 'trim|required');
			$this->form_validation->set_rules('JENIS_KENDARAAN', 'Jenis Kendaraan', 'trim|required');
			$this->form_validation->set_rules('NO_POLISI', 'No Polisi', 'trim|required');
			$this->form_validation->set_rules('NAMA_PENGEMUDI', 'Nama Pengemudi', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PENGEMUDI', 'No HP Pengemudi', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$JENIS_PENGIRIMAN = $this->input->post('JENIS_PENGIRIMAN');
				$JENIS_KENDARAAN = $this->input->post('JENIS_KENDARAAN');
				$NO_POLISI = $this->input->post('NO_POLISI');
				$NAMA_PENGEMUDI = $this->input->post('NAMA_PENGEMUDI');
				$NO_HP_PENGEMUDI = $this->input->post('NO_HP_PENGEMUDI');

				$data_edit = $this->Surat_Jalan_form_model->get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Pengiriman: " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN  . ";" . $JENIS_PENGIRIMAN . ";" . $JENIS_KENDARAAN . ";" . $NO_POLISI . ";" . $NAMA_PENGEMUDI . ";" . $NO_HP_PENGEMUDI;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data_pengiriman(
					$ID_SURAT_JALAN,
					$JENIS_PENGIRIMAN,
					$JENIS_KENDARAAN,
					$NO_POLISI,
					$NAMA_PENGEMUDI,
					$NO_HP_PENGEMUDI
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

			//set validation rules
			$this->form_validation->set_rules('JENIS_PENGIRIMAN', 'Jenis Pengiriman', 'trim|required');
			$this->form_validation->set_rules('JENIS_KENDARAAN', 'Jenis Kendaraan', 'trim|required');
			$this->form_validation->set_rules('NO_POLISI', 'No Polisi', 'trim|required');
			$this->form_validation->set_rules('NAMA_PENGEMUDI', 'Nama Pengemudi', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PENGEMUDI', 'No HP Pengemudi', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$JENIS_PENGIRIMAN = $this->input->post('JENIS_PENGIRIMAN');
				$JENIS_KENDARAAN = $this->input->post('JENIS_KENDARAAN');
				$NO_POLISI = $this->input->post('NO_POLISI');
				$NAMA_PENGEMUDI = $this->input->post('NAMA_PENGEMUDI');
				$NO_HP_PENGEMUDI = $this->input->post('NO_HP_PENGEMUDI');

				$data_edit = $this->Surat_Jalan_form_model->get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Pengiriman: " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN  . ";" . $JENIS_PENGIRIMAN . ";" . $JENIS_KENDARAAN . ";" . $NO_POLISI . ";" . $NAMA_PENGEMUDI . ";" . $NO_HP_PENGEMUDI;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data_pengiriman(
					$ID_SURAT_JALAN,
					$JENIS_PENGIRIMAN,
					$JENIS_KENDARAAN,
					$NO_POLISI,
					$NAMA_PENGEMUDI,
					$NO_HP_PENGEMUDI
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

			//set validation rules
			$this->form_validation->set_rules('JENIS_PENGIRIMAN', 'Jenis Pengiriman', 'trim|required');
			$this->form_validation->set_rules('JENIS_KENDARAAN', 'Jenis Kendaraan', 'trim|required');
			$this->form_validation->set_rules('NO_POLISI', 'No Polisi', 'trim|required');
			$this->form_validation->set_rules('NAMA_PENGEMUDI', 'Nama Pengemudi', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PENGEMUDI', 'No HP Pengemudi', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$JENIS_PENGIRIMAN = $this->input->post('JENIS_PENGIRIMAN');
				$JENIS_KENDARAAN = $this->input->post('JENIS_KENDARAAN');
				$NO_POLISI = $this->input->post('NO_POLISI');
				$NAMA_PENGEMUDI = $this->input->post('NAMA_PENGEMUDI');
				$NO_HP_PENGEMUDI = $this->input->post('NO_HP_PENGEMUDI');

				$data_edit = $this->Surat_Jalan_form_model->get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Pengiriman: " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN  . ";" . $JENIS_PENGIRIMAN . ";" . $JENIS_KENDARAAN . ";" . $NO_POLISI . ";" . $NAMA_PENGEMUDI . ";" . $NO_HP_PENGEMUDI;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data_pengiriman(
					$ID_SURAT_JALAN,
					$JENIS_PENGIRIMAN,
					$JENIS_KENDARAAN,
					$NO_POLISI,
					$NAMA_PENGEMUDI,
					$NO_HP_PENGEMUDI
				);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

			//set validation rules
			$this->form_validation->set_rules('JENIS_PENGIRIMAN', 'Jenis Pengiriman', 'trim|required');
			$this->form_validation->set_rules('JENIS_KENDARAAN', 'Jenis Kendaraan', 'trim|required');
			$this->form_validation->set_rules('NO_POLISI', 'No Polisi', 'trim|required');
			$this->form_validation->set_rules('NAMA_PENGEMUDI', 'Nama Pengemudi', 'trim|required');
			$this->form_validation->set_rules('NO_HP_PENGEMUDI', 'No HP Pengemudi', 'trim|required|numeric');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN');
				$JENIS_PENGIRIMAN = $this->input->post('JENIS_PENGIRIMAN');
				$JENIS_KENDARAAN = $this->input->post('JENIS_KENDARAAN');
				$NO_POLISI = $this->input->post('NO_POLISI');
				$NAMA_PENGEMUDI = $this->input->post('NAMA_PENGEMUDI');
				$NO_HP_PENGEMUDI = $this->input->post('NO_HP_PENGEMUDI');

				$data_edit = $this->Surat_Jalan_form_model->get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN);
				$KETERANGAN = "Ubah Data Pengiriman: " . json_encode($data_edit) . " ---- " . $ID_SURAT_JALAN  . ";" . $JENIS_PENGIRIMAN . ";" . $JENIS_KENDARAAN . ";" . $NO_POLISI . ";" . $NAMA_PENGEMUDI . ";" . $NO_HP_PENGEMUDI;
				$this->user_log($KETERANGAN);

				$data = $this->Surat_Jalan_form_model->update_data_pengiriman(
					$ID_SURAT_JALAN,
					$JENIS_PENGIRIMAN,
					$JENIS_KENDARAAN,
					$NO_POLISI,
					$NAMA_PENGEMUDI,
					$NO_HP_PENGEMUDI
				);
				echo json_encode($data);
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
		$this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		date_default_timezone_set('Asia/Jakarta');
		$this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

		$this->data['title'] = 'SIPESUT | Surat Jalan PDF';


		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_SURAT_JALAN = $this->uri->segment(3);
		if ($this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN) == 'TIDAK ADA DATA SURAT JALAN') {
			redirect('Surat_Jalan', 'refresh');
		}


		if ($this->ion_auth->logged_in()) {

			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_SURAT_JALAN = $this->uri->segment(3);

			if ($this->ion_auth->in_group(10)) {
				$this->cetak_pdf($HASH_MD5_SURAT_JALAN);
				$this->cetak_pdf2($HASH_MD5_SURAT_JALAN);
				$this->cetak_pdf3($HASH_MD5_SURAT_JALAN);

				$hasil = $this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
				$this->data['ID_SURAT_JALAN'] = $ID_SURAT_JALAN;
				$this->data['Surat_Jalan'] = $this->Surat_Jalan_model->surat_jalan_list_by_id_surat_jalan($ID_SURAT_JALAN);


				foreach ($this->data['Surat_Jalan']->result() as $Surat_Jalan) :
					$this->data['FILE_NAME_TEMP'] = $Surat_Jalan->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_DELIVERY_NOTE'] = $Surat_Jalan->FILE_NAME_TEMP_DELIVERY_NOTE;
					$this->data['FILE_NAME_TEMP_PACKING_LIST'] = $Surat_Jalan->FILE_NAME_TEMP_PACKING_LIST;
					$this->data['NO_SURAT_JALAN'] = $Surat_Jalan->NO_SURAT_JALAN;
					$this->data['HASH_MD5_SURAT_JALAN'] = $Surat_Jalan->HASH_MD5_SURAT_JALAN;
					$this->data['PROGRESS_SURAT_JALAN'] = $Surat_Jalan->PROGRESS_SURAT_JALAN;
				endforeach;

				$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/content_surat_jalan_form');
			} else if ($this->ion_auth->in_group(11)) {
				$this->cetak_pdf($HASH_MD5_SURAT_JALAN);
				$this->cetak_pdf2($HASH_MD5_SURAT_JALAN);
				$this->cetak_pdf3($HASH_MD5_SURAT_JALAN);

				$hasil = $this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
				$this->data['ID_SURAT_JALAN'] = $ID_SURAT_JALAN;
				$this->data['Surat_Jalan'] = $this->Surat_Jalan_model->surat_jalan_list_by_id_surat_jalan($ID_SURAT_JALAN);


				foreach ($this->data['Surat_Jalan']->result() as $Surat_Jalan) :
					$this->data['FILE_NAME_TEMP'] = $Surat_Jalan->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_DELIVERY_NOTE'] = $Surat_Jalan->FILE_NAME_TEMP_DELIVERY_NOTE;
					$this->data['FILE_NAME_TEMP_PACKING_LIST'] = $Surat_Jalan->FILE_NAME_TEMP_PACKING_LIST;
					$this->data['NO_SURAT_JALAN'] = $Surat_Jalan->NO_SURAT_JALAN;
					$this->data['HASH_MD5_SURAT_JALAN'] = $Surat_Jalan->HASH_MD5_SURAT_JALAN;
					$this->data['PROGRESS_SURAT_JALAN'] = $Surat_Jalan->PROGRESS_SURAT_JALAN;
				endforeach;

				$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/content_surat_jalan_form');
			} else if ($this->ion_auth->in_group(12)) {
				$this->cetak_pdf($HASH_MD5_SURAT_JALAN);
				$this->cetak_pdf2($HASH_MD5_SURAT_JALAN);
				$this->cetak_pdf3($HASH_MD5_SURAT_JALAN);

				$hasil = $this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
				$this->data['ID_SURAT_JALAN'] = $ID_SURAT_JALAN;
				$this->data['Surat_Jalan'] = $this->Surat_Jalan_model->surat_jalan_list_by_id_surat_jalan($ID_SURAT_JALAN);


				foreach ($this->data['Surat_Jalan']->result() as $Surat_Jalan) :
					$this->data['FILE_NAME_TEMP'] = $Surat_Jalan->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_DELIVERY_NOTE'] = $Surat_Jalan->FILE_NAME_TEMP_DELIVERY_NOTE;
					$this->data['FILE_NAME_TEMP_PACKING_LIST'] = $Surat_Jalan->FILE_NAME_TEMP_PACKING_LIST;
					$this->data['NO_SURAT_JALAN'] = $Surat_Jalan->NO_SURAT_JALAN;
					$this->data['HASH_MD5_SURAT_JALAN'] = $Surat_Jalan->HASH_MD5_SURAT_JALAN;
					$this->data['PROGRESS_SURAT_JALAN'] = $Surat_Jalan->PROGRESS_SURAT_JALAN;
				endforeach;

				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_surat_jalan_form');
			} else if ($this->ion_auth->in_group(13)) {
				$this->cetak_pdf($HASH_MD5_SURAT_JALAN);
				$this->cetak_pdf2($HASH_MD5_SURAT_JALAN);
				$this->cetak_pdf3($HASH_MD5_SURAT_JALAN);

				$hasil = $this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
				$this->data['ID_SURAT_JALAN'] = $ID_SURAT_JALAN;
				$this->data['Surat_Jalan'] = $this->Surat_Jalan_model->surat_jalan_list_by_id_surat_jalan($ID_SURAT_JALAN);


				foreach ($this->data['Surat_Jalan']->result() as $Surat_Jalan) :
					$this->data['FILE_NAME_TEMP'] = $Surat_Jalan->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_DELIVERY_NOTE'] = $Surat_Jalan->FILE_NAME_TEMP_DELIVERY_NOTE;
					$this->data['FILE_NAME_TEMP_PACKING_LIST'] = $Surat_Jalan->FILE_NAME_TEMP_PACKING_LIST;
					$this->data['NO_SURAT_JALAN'] = $Surat_Jalan->NO_SURAT_JALAN;
					$this->data['HASH_MD5_SURAT_JALAN'] = $Surat_Jalan->HASH_MD5_SURAT_JALAN;
					$this->data['PROGRESS_SURAT_JALAN'] = $Surat_Jalan->PROGRESS_SURAT_JALAN;
				endforeach;

				$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/content_surat_jalan_form');
			} else if ($this->ion_auth->in_group(15)) {
				$this->cetak_pdf($HASH_MD5_SURAT_JALAN);
				$this->cetak_pdf2($HASH_MD5_SURAT_JALAN);
				$this->cetak_pdf3($HASH_MD5_SURAT_JALAN);

				$hasil = $this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
				$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
				$this->data['ID_SURAT_JALAN'] = $ID_SURAT_JALAN;
				$this->data['Surat_Jalan'] = $this->Surat_Jalan_model->surat_jalan_list_by_id_surat_jalan($ID_SURAT_JALAN);


				foreach ($this->data['Surat_Jalan']->result() as $Surat_Jalan) :
					$this->data['FILE_NAME_TEMP'] = $Surat_Jalan->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_DELIVERY_NOTE'] = $Surat_Jalan->FILE_NAME_TEMP_DELIVERY_NOTE;
					$this->data['FILE_NAME_TEMP_PACKING_LIST'] = $Surat_Jalan->FILE_NAME_TEMP_PACKING_LIST;
					$this->data['NO_SURAT_JALAN'] = $Surat_Jalan->NO_SURAT_JALAN;
					$this->data['HASH_MD5_SURAT_JALAN'] = $Surat_Jalan->HASH_MD5_SURAT_JALAN;
					$this->data['PROGRESS_SURAT_JALAN'] = $Surat_Jalan->PROGRESS_SURAT_JALAN;
				endforeach;

				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_surat_jalan_form');
			} else {
				redirect('Surat_Jalan', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	function get_nama_vendor()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_VENDOR = $this->input->get('ID_VENDOR');
			$data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			echo json_encode($data);

			$KETERANGAN = "Get Nama Vendor: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	public function cetak_pdf($HASH_MD5_SURAT_JALAN)

	{

		$hasil = $this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
		$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
		$this->data['ID_SURAT_JALAN'] = $ID_SURAT_JALAN;
		$this->data['Surat_Jalan'] = $this->Surat_Jalan_model->surat_jalan_list_by_id_surat_jalan($ID_SURAT_JALAN);
		$this->data['CATATAN_SURAT_JALAN'] = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);

		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

		$this->data['konten_Surat_Jalan_form'] = $this->Surat_Jalan_form_model->surat_jalan_form_list_by_id_surat_jalan($ID_SURAT_JALAN);

		$this->data['USER_PENGAJU'] = $this->Surat_Jalan_form_model->ID_JABATAN_PEGAWAI_BY_ID_SURAT_JALAN($ID_SURAT_JALAN);

		foreach ($this->data['Surat_Jalan']->result() as $Surat_Jalan) :
			$FILE_NAME_TEMP = $Surat_Jalan->FILE_NAME_TEMP;
			$this->data['STATUS_SURAT_JALAN'] = $Surat_Jalan->STATUS_SURAT_JALAN;
			$this->data['NO_SURAT_JALAN'] = $Surat_Jalan->NO_SURAT_JALAN;
			$this->data['TANGGAL_SURAT_JALAN_HARI'] = $Surat_Jalan->TANGGAL_SURAT_JALAN_HARI;
			$this->data['ID_VENDOR'] = $Surat_Jalan->ID_VENDOR;
			$this->data['KEPADA'] = $Surat_Jalan->KEPADA;
			$this->data['PIC_PENERIMA_BARANG'] = $Surat_Jalan->PIC_PENERIMA_BARANG;
			$this->data['NO_HP_PIC'] = $Surat_Jalan->NO_HP_PIC;
			$this->data['ID_SPPB'] = $Surat_Jalan->ID_SPPB;
			$this->data['NO_POLISI'] = $Surat_Jalan->NO_POLISI;
			$this->data['NAMA_PENGEMUDI'] = $Surat_Jalan->NAMA_PENGEMUDI;
			$this->data['NO_HP_PENGEMUDI'] = $Surat_Jalan->NO_HP_PENGEMUDI;
			$this->data['JENIS_KENDARAAN'] = $Surat_Jalan->JENIS_KENDARAAN;
		endforeach;

		if ($this->data['ID_VENDOR'] == "0" || $this->data['ID_VENDOR'] == null) {
			$this->data['NAMA_VENDOR'] = "";
			$this->data['ALAMAT_VENDOR'] = "";
			$this->data['NO_TELP_VENDOR'] = "";
			$this->data['NAMA_PIC_VENDOR'] = "";
			$this->data['NO_HP_PIC_VENDOR'] = "";
		} else {
			$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
			foreach ($hasil->result() as $VENDOR) :
				$NAMA_VENDOR = $VENDOR->NAMA_VENDOR;
				$ALAMAT_VENDOR = $VENDOR->ALAMAT_VENDOR;
				$NO_TELP_VENDOR = $VENDOR->NO_TELP_VENDOR;
				$NAMA_PIC_VENDOR = $VENDOR->NAMA_PIC_VENDOR;
				$NO_HP_PIC_VENDOR = $VENDOR->NO_HP_PIC_VENDOR;


			endforeach;
			$this->data['NAMA_VENDOR'] = $NAMA_VENDOR;
			$this->data['ALAMAT_VENDOR'] = $ALAMAT_VENDOR;
			$this->data['NO_TELP_VENDOR'] = $NO_TELP_VENDOR;
			$this->data['NAMA_PIC_VENDOR'] = $NAMA_PIC_VENDOR;
			$this->data['NO_HP_PIC_VENDOR'] = $NO_HP_PIC_VENDOR;
		}

		if ($this->data['ID_SPPB'] == "666666") {
			$this->data['NO_URUT_SPPB'] = "Tanpa SPPB";
			$this->data['TANGGAL_PEMBUATAN_SPPB_HARI'] = "Tanpa SPPB";
		} else {
			$hasil = $this->SPPB_model->sppb_list_by_id_sppb($this->data['ID_SPPB']);
			foreach ($hasil->result() as $SPPB) :
				$this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
				$this->data['TANGGAL_PEMBUATAN_SPPB_HARI'] = $SPPB->TANGGAL_PEMBUATAN_SPPB_HARI;
			endforeach;
		}



		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Form Surat Jalan Barang';

		// filename dari pdf ketika didownload
		$file_pdf = 'Surat_Jalan_' . $HASH_MD5_SURAT_JALAN;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "portrait";

		$html = $this->load->view('wasa/pdf/surat_jalan_pdf', $this->data, true);

		// run dompdf
		$x          = 500;
		$y          = 800;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 10;

		$file_path = "assets/Surat_Jalan/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	public function cetak_pdf2($HASH_MD5_SURAT_JALAN)

	{

		$hasil = $this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
		$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
		$this->data['ID_SURAT_JALAN'] = $ID_SURAT_JALAN;
		$this->data['Surat_Jalan'] = $this->Surat_Jalan_model->surat_jalan_list_by_id_surat_jalan($ID_SURAT_JALAN);
		$this->data['CATATAN_SURAT_JALAN'] = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);

		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

		$this->data['konten_Surat_Jalan_form'] = $this->Surat_Jalan_form_model->surat_jalan_form_list_by_id_surat_jalan($ID_SURAT_JALAN);

		$this->data['USER_PENGAJU'] = $this->Surat_Jalan_form_model->ID_JABATAN_PEGAWAI_BY_ID_SURAT_JALAN($ID_SURAT_JALAN);

		foreach ($this->data['Surat_Jalan']->result() as $Surat_Jalan) :
			$FILE_NAME_TEMP_DELIVERY_NOTE = $Surat_Jalan->FILE_NAME_TEMP_DELIVERY_NOTE;
			$this->data['STATUS_SURAT_JALAN'] = $Surat_Jalan->STATUS_SURAT_JALAN;
			$this->data['NO_SURAT_JALAN'] = $Surat_Jalan->NO_SURAT_JALAN;
			$this->data['NO_DELIVERY_NOTE'] = $Surat_Jalan->NO_DELIVERY_NOTE;
			$this->data['TANGGAL_SURAT_JALAN_HARI'] = $Surat_Jalan->TANGGAL_SURAT_JALAN_HARI;
			$this->data['ID_VENDOR'] = $Surat_Jalan->ID_VENDOR;
			$this->data['ID_SPPB'] = $Surat_Jalan->ID_SPPB;
			$this->data['PIC_PENERIMA_BARANG'] = $Surat_Jalan->PIC_PENERIMA_BARANG;
			$this->data['KEPADA'] = $Surat_Jalan->KEPADA;
		endforeach;

		$hasil = $this->SPPB_model->sppb_list_by_id_sppb($this->data['ID_SPPB']);
		foreach ($hasil->result() as $SPPB) :
			$this->data['NAMA_PROYEK'] = $SPPB->NAMA_PROYEK;
			$this->data['TANGGAL_PEMBUATAN_SPPB_HARI'] = $SPPB->TANGGAL_PEMBUATAN_SPPB_HARI;
		endforeach;


		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Form Surat Jalan Barang';

		// filename dari pdf ketika didownload
		$file_pdf = 'Delivery_Note_' . $HASH_MD5_SURAT_JALAN;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "portrait";

		$html = $this->load->view('wasa/pdf/surat_jalan_pdf2', $this->data, true);

		// run dompdf
		$x          = 500;
		$y          = 800;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 10;

		$file_path = "assets/Delivery_Note/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	public function cetak_pdf3($HASH_MD5_SURAT_JALAN)

	{

		$hasil = $this->Surat_Jalan_model->get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN);
		$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
		$this->data['ID_SURAT_JALAN'] = $ID_SURAT_JALAN;
		$this->data['Surat_Jalan'] = $this->Surat_Jalan_model->surat_jalan_list_by_id_surat_jalan($ID_SURAT_JALAN);
		$this->data['CATATAN_SURAT_JALAN'] = $this->Surat_Jalan_form_model->get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN);

		$this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

		$this->data['konten_Surat_Jalan_form'] = $this->Surat_Jalan_form_model->surat_jalan_form_list_by_id_surat_jalan($ID_SURAT_JALAN);

		$this->data['USER_PENGAJU'] = $this->Surat_Jalan_form_model->ID_JABATAN_PEGAWAI_BY_ID_SURAT_JALAN($ID_SURAT_JALAN);

		foreach ($this->data['Surat_Jalan']->result() as $Surat_Jalan) :
			$FILE_NAME_TEMP_PACKING_LIST = $Surat_Jalan->FILE_NAME_TEMP_PACKING_LIST;
			$this->data['STATUS_SURAT_JALAN'] = $Surat_Jalan->STATUS_SURAT_JALAN;
			$this->data['NO_SURAT_JALAN'] = $Surat_Jalan->NO_SURAT_JALAN;
			$this->data['NO_DELIVERY_NOTE'] = $Surat_Jalan->NO_DELIVERY_NOTE;
			$this->data['TANGGAL_SURAT_JALAN_HARI'] = $Surat_Jalan->TANGGAL_SURAT_JALAN_HARI;
			$this->data['ID_VENDOR'] = $Surat_Jalan->ID_VENDOR;
			$this->data['ID_SPPB'] = $Surat_Jalan->ID_SPPB;
			$this->data['PIC_PENERIMA_BARANG'] = $Surat_Jalan->PIC_PENERIMA_BARANG;
			$this->data['KEPADA'] = $Surat_Jalan->KEPADA;
			$this->data['NAMA_PROYEK'] = $Surat_Jalan->NAMA_PROYEK;
			$this->data['NAMA_VENDOR'] = $Surat_Jalan->NAMA_VENDOR;
		endforeach;

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Form Surat Jalan Barang';

		// filename dari pdf ketika didownload
		$file_pdf = 'Packing_List_' . $HASH_MD5_SURAT_JALAN;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "landscape";

		$html = $this->load->view('wasa/pdf/packing_list', $this->data, true);

		// run dompdf
		$x          = 735;
		$y          = 560;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 10;

		$file_path = "assets/Packing_List/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}
}
