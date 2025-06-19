<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengajuan_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation','excel'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SiKembar | Form Pengajuan';

		$this->load->model('FPB_form_model');
		$this->load->model('SPPB_form_model');
		$this->load->model('Pengajuan_form_model');
		$this->load->model('Pengajuan_model');
		$this->load->model('SPPB_model');
		$this->load->model('Proyek_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('Klasifikasi_barang_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('SPPB_Form_File_Model');
		$this->load->model('RAB_form_model');
		$this->load->model('RASD_form_model');
		$this->load->model('RASD_model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "sppb_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses SPPB";
		$WAKTU = date('Y-m-d H:i:s');
		// $this->SPPB_form_model->user_log_sppb_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN) //102023
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->SPPB_form_model->user_log_sppb_form($user->ID_PEGAWAI, $ID_SPPB_FORM, $KETERANGAN, $WAKTU);
	}

	public function user_log_sppb($ID_SPPB, $KETERANGAN) //102023
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->SPPB_model->user_log_sppb($user->ID_PEGAWAI, $ID_SPPB, $KETERANGAN, $WAKTU);
    }

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index() //BEDA KP DAN SP
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
		$this->data['username'] = $user->username;
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		$this->data['NIK'] = $user->NIK;
		date_default_timezone_set('Asia/Jakarta');
		$this->data['last_login'] = date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		// $ID_SPPB = 0;
        // $KETERANGAN = "Melihat Halaman Index SPPB Form: ";
        // $this->user_log_sppb($ID_SPPB, $KETERANGAN);

		$CODE_MD5 = $this->uri->segment(3);
		// if ($this->Pengajuan_model->get_id_pengajuan_by_CODE_MD5($CODE_MD5) == 'TIDAK ADA DATA') {
		// 	redirect('Pengajuan', 'refresh');
		// }

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) { //User korban
			$hasil_2 = $this->Pengajuan_model->get_data_pengajuan_by_CODE_MD5($CODE_MD5);
			$PROGRESS_PENGAJUAN = $hasil_2['PROGRESS_PENGAJUAN'];

			// $sess_data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			// $this->session->set_userdata($sess_data);

			if ($PROGRESS_PENGAJUAN == "Diproses oleh Staff BPBD") {
				$hasil = $this->Pengajuan_model->get_data_pengajuan_by_CODE_MD5($CODE_MD5);
				$ID_FORM_INVENTARIS_KORBAN_BENCANA = $hasil['ID_FORM_INVENTARIS_KORBAN_BENCANA'];
				$Nomor_Surat_Form_Inventaris = $hasil['Nomor_Surat_Form_Inventaris'];
				$this->data['CODE_MD5'] = $CODE_MD5;
				$this->data['ID_FORM_INVENTARIS_KORBAN_BENCANA'] = $ID_FORM_INVENTARIS_KORBAN_BENCANA;
				$this->data['Nomor_Surat_Form_Inventaris'] = $Nomor_Surat_Form_Inventaris;

				// $this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['Pengajuan'] = $this->Pengajuan_model->pengajuan_list_by_id_pengajuan($ID_FORM_INVENTARIS_KORBAN_BENCANA);
				// $this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				
				// $this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
				// $this->data['RAB_list'] = $this->RAB_form_model->rab_list_by_id_proyek_sub_pekerjaan($this->data['ID_PROYEK_SUB_PEKERJAAN']);

				$this->load->view('wasa/user_korban_bencana/head_normal', $this->data);
				$this->load->view('wasa/user_korban_bencana/user_menu');
				$this->load->view('wasa/user_korban_bencana/left_menu');
				$this->load->view('wasa/user_korban_bencana/header_menu');
				$this->load->view('wasa/user_korban_bencana/content_pengajuan_form_proses');
				// $this->load->view('wasa/user_korban_bencana/content_pengajuan_perwakilan_form_proses');
				// $this->load->view('wasa/user_korban_bencana/footer');
			} else {
				redirect('Pengajuan', 'refresh');
			}
		
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)){
			$hasil = $this->Pengajuan_model->get_data_pengajuan_by_CODE_MD5($CODE_MD5);
			$ID_FORM_INVENTARIS_KORBAN_BENCANA = $hasil['ID_FORM_INVENTARIS_KORBAN_BENCANA'];
			$Nomor_Surat_Form_Inventaris = $hasil['Nomor_Surat_Form_Inventaris'];
			$this->data['CODE_MD5'] = $CODE_MD5;
			$this->data['ID_FORM_INVENTARIS_KORBAN_BENCANA'] = $ID_FORM_INVENTARIS_KORBAN_BENCANA;
			$this->data['Nomor_Surat_Form_Inventaris'] = $Nomor_Surat_Form_Inventaris;

			// $this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['Pengajuan'] = $this->Pengajuan_model->pengajuan_list_by_id_pengajuan($ID_FORM_INVENTARIS_KORBAN_BENCANA);
			// $this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			
			// $this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
			// $this->data['RAB_list'] = $this->RAB_form_model->rab_list_by_id_proyek_sub_pekerjaan($this->data['ID_PROYEK_SUB_PEKERJAAN']);

			$this->load->view('wasa/user_pegawai_bpbd/head_normal', $this->data);
			$this->load->view('wasa/user_pegawai_bpbd/user_menu');
			$this->load->view('wasa/user_pegawai_bpbd/left_menu');
			$this->load->view('wasa/user_pegawai_bpbd/header_menu');
			$this->load->view('wasa/user_pegawai_bpbd/content_pengajuan_form_proses');
			// $this->load->view('wasa/user_pegawai_bpbd/content_pengajuan_perwakilan_form_proses');
			// $this->load->view('wasa/user_pegawai_bpbd/footer');
		}
		 else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
	public function index_perwakilan() //BEDA KP DAN SP
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
		$this->data['username'] = $user->username;
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		$this->data['NIK'] = $user->NIK;
		date_default_timezone_set('Asia/Jakarta');
		$this->data['last_login'] = date('d-m-Y H:i:s', $user->last_login);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		// $ID_SPPB = 0;
        // $KETERANGAN = "Melihat Halaman Index SPPB Form: ";
        // $this->user_log_sppb($ID_SPPB, $KETERANGAN);

		$CODE_MD5 = $this->uri->segment(3);
		// if ($this->Pengajuan_model->get_id_pengajuan_by_CODE_MD5($CODE_MD5) == 'TIDAK ADA DATA') {
		// 	redirect('Pengajuan', 'refresh');
		// }

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) { //User korban
			$hasil_2 = $this->Pengajuan_model->get_data_pengajuan_by_CODE_MD5($CODE_MD5);
			$PROGRESS_PENGAJUAN = $hasil_2['PROGRESS_PENGAJUAN'];

			// $sess_data['HASH_MD5_SPPB'] = $HASH_MD5_SPPB;
			// $this->session->set_userdata($sess_data);

			if ($PROGRESS_PENGAJUAN == "Diproses oleh Staff BPBD") {
				$hasil = $this->Pengajuan_model->get_data_pengajuan_by_CODE_MD5_perwakilan($CODE_MD5);
				$ID_FORM_INVENTARIS_KORBAN_BENCANA = $hasil['ID_FORM_INVENTARIS_KORBAN_BENCANA'];
				$Nomor_Surat_Form_Inventaris = $hasil['Nomor_Surat_Form_Inventaris'];
				$this->data['CODE_MD5'] = $CODE_MD5;
				$this->data['ID_FORM_INVENTARIS_KORBAN_BENCANA'] = $ID_FORM_INVENTARIS_KORBAN_BENCANA;
				$this->data['Nomor_Surat_Form_Inventaris'] = $Nomor_Surat_Form_Inventaris;

				// $this->data['ID_SPPB'] = $ID_SPPB;
				$this->data['Pengajuan'] = $this->Pengajuan_model->pengajuan_list_by_id_pengajuan($ID_FORM_INVENTARIS_KORBAN_BENCANA);
				// $this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
				
				// $this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
				// $this->data['RAB_list'] = $this->RAB_form_model->rab_list_by_id_proyek_sub_pekerjaan($this->data['ID_PROYEK_SUB_PEKERJAAN']);

				$this->load->view('wasa/user_korban_bencana/head_normal', $this->data);
				$this->load->view('wasa/user_korban_bencana/user_menu');
				$this->load->view('wasa/user_korban_bencana/left_menu');
				$this->load->view('wasa/user_korban_bencana/header_menu');
				// $this->load->view('wasa/user_korban_bencana/content_pengajuan_form_proses');
				$this->load->view('wasa/user_korban_bencana/content_pengajuan_perwakilan_form_proses');
				// $this->load->view('wasa/user_korban_bencana/footer');
			} else {
				redirect('Pengajuan', 'refresh');
			}
		
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)){
			$hasil = $this->Pengajuan_model->get_data_pengajuan_by_CODE_MD5_perwakilan($CODE_MD5);
			$ID_FORM_INVENTARIS_KORBAN_BENCANA = $hasil['ID_FORM_INVENTARIS_KORBAN_BENCANA'];
			$Nomor_Surat_Form_Inventaris = $hasil['Nomor_Surat_Form_Inventaris'];
			$this->data['CODE_MD5'] = $CODE_MD5;
			$this->data['ID_FORM_INVENTARIS_KORBAN_BENCANA'] = $ID_FORM_INVENTARIS_KORBAN_BENCANA;
			$this->data['Nomor_Surat_Form_Inventaris'] = $Nomor_Surat_Form_Inventaris;

			// $this->data['ID_SPPB'] = $ID_SPPB;
			$this->data['Pengajuan'] = $this->Pengajuan_model->pengajuan_list_by_id_pengajuan($ID_FORM_INVENTARIS_KORBAN_BENCANA);
			// $this->data['CATATAN_SPPB'] = $this->SPPB_form_model->get_data_catatan_sppb_by_id_sppb($ID_SPPB);
			
			// $this->data['klasifikasi_barang_list'] = $this->Klasifikasi_barang_model->klasifikasi_barang_list();
			// $this->data['RAB_list'] = $this->RAB_form_model->rab_list_by_id_proyek_sub_pekerjaan($this->data['ID_PROYEK_SUB_PEKERJAAN']);

			$this->load->view('wasa/user_pegawai_bpbd/head_normal', $this->data);
			$this->load->view('wasa/user_pegawai_bpbd/user_menu');
			$this->load->view('wasa/user_pegawai_bpbd/left_menu');
			$this->load->view('wasa/user_pegawai_bpbd/header_menu');
			// $this->load->view('wasa/user_pegawai_bpbd/content_pengajuan_form_proses');
			$this->load->view('wasa/user_pegawai_bpbd/content_pengajuan_perwakilan_form_proses');
			// $this->load->view('wasa/user_pegawai_bpbd/footer');
		}
		 else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_barang_bantuan_form() //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_FORM_INVENTARIS_KORBAN_BENCANA = $this->input->post('ID_FORM_INVENTARIS_KORBAN_BENCANA');
			$data = $this->Pengajuan_form_model->data_barang_bantuan_form($ID_FORM_INVENTARIS_KORBAN_BENCANA);
			echo json_encode($data);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}


	function get_data() //102023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_ITEM_FORM_PENGAJUAN_BARANG = $this->input->get('ID_ITEM_FORM_PENGAJUAN_BARANG');
			$data = $this->Pengajuan_form_model->get_data_by_id_item_form_pengajuan_barang($ID_ITEM_FORM_PENGAJUAN_BARANG);
			echo json_encode($data);

			// $ID_SPPB_FORM = $ID_SPPB_FORM ;
			// $KETERANGAN = "Get Data SPPB Form: " . json_encode($data);
			// $this->user_log_sppb_form($ID_SPPB_FORM, $KETERANGAN);
		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function get_data_hapus_semua()
{
    if ($this->ion_auth->logged_in()) {
        $ID_FORM_INVENTARIS_KORBAN_BENCANA = $this->input->get('ID_FORM_INVENTARIS_KORBAN_BENCANA');
        $data = $this->Pengajuan_form_model->get_data_by_id_item_form_inventaris_korban_bencana($ID_FORM_INVENTARIS_KORBAN_BENCANA);
        
        // Pastikan data yang dikembalikan adalah array atau object yang benar
        echo json_encode($data);
    } else {
        $this->logout();
    }
}


	function hapus_data()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_ITEM_FORM_PENGAJUAN_BARANG = $this->input->post('kode');
			$data = $this->Pengajuan_form_model->hapus_data_by_id_item_form_pengajuan_barang($ID_ITEM_FORM_PENGAJUAN_BARANG);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}

	function hapus_data_semua()
	{
		if ($this->ion_auth->logged_in()) {
			$ID_FORM_INVENTARIS_KORBAN_BENCANA = $this->input->post('kode_semua');
			$data = $this->Pengajuan_form_model->hapus_data_by_id_form_inventaris_korban_bencana($ID_FORM_INVENTARIS_KORBAN_BENCANA);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}


	function simpan_data_barang_bantuan()
	{
		if ($this->ion_auth->logged_in()) {

			$ID_FORM_INVENTARIS_KORBAN_BENCANA = $this->input->post('ID_FORM_INVENTARIS_KORBAN_BENCANA');
		
			//set validation rules
			$this->form_validation->set_rules('JENIS_BANTUAN', 'Jenis Bantuan', 'trim|required');
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[50]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|max_length[50]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|max_length[50]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|required|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[20]');
			$this->form_validation->set_rules('JENIS_BANTUAN', 'Jenis Bantuan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|max_length[100]');
			
			// run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo validation_errors();
			}
			else {
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JENIS_BANTUAN = $this->input->post('JENIS_BANTUAN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				
				$data = $this->Pengajuan_form_model->simpan_data_barang_bantuan(
					$ID_FORM_INVENTARIS_KORBAN_BENCANA,
					$NAMA,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$JUMLAH_BARANG,
					$SATUAN_BARANG,
					$JENIS_BANTUAN,
					$KETERANGAN
				);
				
			}
			
		} else {
			$this->logout();
		}
	}

	function update_data()
	{
		if ($this->ion_auth->logged_in()) {
			
			$ID_ITEM_FORM_PENGAJUAN_BARANG = $this->input->post('ID_ITEM_FORM_PENGAJUAN_BARANG');

			//set validation rules
			$this->form_validation->set_rules('JENIS_BANTUAN', 'Jenis Bantuan', 'trim|required');
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|max_length[100]');
			$this->form_validation->set_rules('JUMLAH_BARANG', 'Jumlah Barang', 'trim|numeric|required|greater_than[0]|less_than[99999999999]');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('JENIS_BANTUAN', 'Jenis Bantuan', 'trim|required|max_length[100]');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|max_length[300]');


			// run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo validation_errors();
			} else {
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$JUMLAH_BARANG = $this->input->post('JUMLAH_BARANG');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$JENIS_BANTUAN = $this->input->post('JENIS_BANTUAN');
				$KETERANGAN = $this->input->post('KETERANGAN');
				
				$data = $this->Pengajuan_form_model->update_data_barang_bantuan(
					$ID_ITEM_FORM_PENGAJUAN_BARANG,
					$NAMA,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$JUMLAH_BARANG,
					$SATUAN_BARANG,
					$JENIS_BANTUAN,
					$KETERANGAN
				);
			}
		
		
		} else {
			$this->logout();
		}
	}


	public function tanggal_indo_full($tanggal, $cetak_hari = false)
	{
		if($tanggal == '0000-00-00')
		{
			$tgl_indo = "-";
			return $tgl_indo;
		}

		else
		{
			$hari = array ( 1 =>    'Senin',
						'Selasa',
						'Rabu',
						'Kamis',
						'Jumat',
						'Sabtu',
						'Minggu'
					);
					
			$bulan = array (1 =>   'Januari',
						'Februari',
						'Maret',
						'April',
						'Mei',
						'Juni',
						'Juli',
						'Agustus',
						'September',
						'Oktober',
						'November',
						'Desember'
					);
			$split 	  = explode('-', $tanggal);
			$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
			
			if ($cetak_hari) {
				$num = date('N', strtotime($tanggal));
				return $hari[$num] . ', ' . $tgl_indo;
			}
			return $tgl_indo;

		}
	}

	public function tanggal_indo_singkat($tanggal, $cetak_hari = false)
	{
		if($tanggal == '0000-00-00')
		{
			$tgl_indo = "-";
			return $tgl_indo;
		}

		else
		{
			$hari = array ( 1 =>    'Senin',
					'Selasa',
					'Rabu',
					'Kamis',
					'Jumat',
					'Sabtu',
					'Minggu'
				);
				
			$bulan = array (1 =>   'Jan',
						'Feb',
						'Mar',
						'Apr',
						'Mei',
						'Jun',
						'Jul',
						'Agt',
						'Sep',
						'Okt',
						'Nov',
						'Des'
					);
			$split 	  = explode('-', $tanggal);
			$tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
			
			if ($cetak_hari) {
				$num = date('N', strtotime($tanggal));
				return $hari[$num] . ', ' . $tgl_indo;
			}
			return $tgl_indo;
		}
		
	}
}