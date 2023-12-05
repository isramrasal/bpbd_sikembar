<?php defined('BASEPATH') or exit('No direct script access allowed');

class KHP_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation','excel'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Form KHP';

		$this->load->model('KHP_model');
		$this->load->model('KHP_form_model');
		$this->load->model('Proyek_model');
		$this->load->model('Vendor_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('KHP_Form_File_Model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "KHP_aktif";
	}


	public function logout() //112023
    {
        $ID_KHP = 0;
        $KETERANGAN = "Paksa Logout Ketika Akses KHP Form";
        $this->user_log_khp($ID_KHP, $KETERANGAN);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

	public function user_log_khp_form($ID_KHP_FORM, $KETERANGAN) //112023
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->KHP_form_model->user_log_khp_form($user->ID_PEGAWAI, $ID_KHP_FORM, $KETERANGAN, $WAKTU);
	}

	public function user_log_khp($ID_KHP, $KETERANGAN) //112023
    {
        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->KHP_model->user_log_khp($user->ID_PEGAWAI, $ID_KHP, $KETERANGAN, $WAKTU);
    }

	public function index() //122023
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		//get data tabel users untuk ditampilkan
		$user = $this->ion_auth->user()->row();
		$this->data['USER_ID'] = $user->id;
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
		$this->data['role_user'] = $data_role_user['description'];
		$this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['USER_ID'] = $user->id;
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

		$HASH_MD5_KHP = $this->uri->segment(3);
		if ($this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP) == 'TIDAK ADA DATA') {
			redirect('KHP', 'refresh');
		}

		//fungsi ini untuk mengirim data ke dropdown
		$hasil = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);
		$this->data['HASH_MD5_KHP'] = $HASH_MD5_KHP;
		$this->data['ID_SPPB'] = $hasil['ID_SPPB'];
		$this->data['ID_KHP'] = $hasil['ID_KHP'];
		$ID_KHP = $hasil['ID_KHP'];
		$ID_SPPB = $hasil['ID_SPPB'];

		$this->data['ID_PROYEK'] = $hasil['ID_PROYEK'];
		$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $hasil['ID_PROYEK_SUB_PEKERJAAN'];

		$this->data['STATUS_KHP'] = $hasil['STATUS_KHP'];
		$this->data['PROGRESS_KHP'] = $hasil['PROGRESS_KHP'];

		$this->data['ID_VENDOR_PERTAMA'] = $hasil['ID_VENDOR_PERTAMA'];
		$this->data['ID_VENDOR_KEDUA'] = $hasil['ID_VENDOR_KEDUA'];
		$this->data['ID_VENDOR_KETIGA'] = $hasil['ID_VENDOR_KETIGA'];

		$this->data['DELIVERY_VENDOR_PERTAMA'] = $hasil['DELIVERY_VENDOR_PERTAMA'];
		$this->data['DELIVERY_VENDOR_KEDUA'] = $hasil['DELIVERY_VENDOR_KEDUA'];
		$this->data['DELIVERY_VENDOR_KETIGA'] = $hasil['DELIVERY_VENDOR_KETIGA'];

		$this->data['SISTEM_BAYAR_VENDOR_PERTAMA'] = $hasil['SISTEM_BAYAR_VENDOR_PERTAMA'];
		$this->data['SISTEM_BAYAR_VENDOR_KEDUA'] = $hasil['SISTEM_BAYAR_VENDOR_KEDUA'];
		$this->data['SISTEM_BAYAR_VENDOR_KETIGA'] = $hasil['SISTEM_BAYAR_VENDOR_KETIGA'];

		$this->data['PROGRESS_KHP'] = $hasil['PROGRESS_KHP'];
		$this->data['STATUS_KHP'] = $hasil['STATUS_KHP'];
		$this->data['NO_URUT_KHP'] = $hasil['NO_URUT_KHP'];

		$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR_PERTAMA']);
		if ($hasil2 == 'BELUM ADA VENDOR') {
			$this->data['NAMA_VENDOR_PERTAMA'] = "";
			;
		} else {
			$this->data['NAMA_VENDOR_PERTAMA'] = $hasil2['NAMA_VENDOR'];
		}

		$hasil3 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR_KEDUA']);
		if ($hasil3 == 'BELUM ADA VENDOR') {
			$this->data['NAMA_VENDOR_KEDUA'] = "";
			;
		} else {
			$this->data['NAMA_VENDOR_KEDUA'] = $hasil3['NAMA_VENDOR'];
		}

		$hasil4 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR_KETIGA']);
		if ($hasil4 == 'BELUM ADA VENDOR') {
			$this->data['NAMA_VENDOR_KETIGA'] = "";
			;
		} else {
			$this->data['NAMA_VENDOR_KETIGA'] = $hasil4['NAMA_VENDOR'];
		}

		$this->data['vendor_pertama'] = $this->Vendor_model->vendor_list_aktif();
		$this->data['vendor_kedua'] = $this->Vendor_model->vendor_list_aktif();
		$this->data['vendor_ketiga'] = $this->Vendor_model->vendor_list_aktif();
		$this->data['SPPB'] = $this->KHP_model->sppb_list_by_id_sppb($this->data['ID_SPPB']);
		$this->data['KHP'] = $this->KHP_model->khp_list_by_id_khp($this->data['ID_KHP']);

		$this->data['sppb_barang_list'] = $this->KHP_form_model->sppb_form_list_where_not_in_rfq($ID_KHP, $ID_SPPB);

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

			if ($this->data['PROGRESS_KHP'] == "Diproses oleh Staff Procurement KP") {
				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_khp_form_proses');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else {
				redirect('KHP', 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

			if ($this->data['PROGRESS_KHP'] == "Diproses oleh Kasie Procurement KP") {
				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_khp_form_proses');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else {
				redirect('KHP', 'refresh');
			}
			
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

			if ($this->data['PROGRESS_KHP'] == "Diproses oleh Manajer Procurement KP") {
				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_khp_form_proses');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else {
				redirect('KHP', 'refresh');
			}

		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

			if ($this->data['PROGRESS_KHP'] == "Diproses oleh Staff Procurement SP") {
				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_khp_form_proses');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else {
				redirect('KHP', 'refresh');
			}

			
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

			if ($this->data['PROGRESS_KHP'] == "Diproses oleh Supervisi Procurement SP") {
				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_khp_form_proses');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else {
				redirect('KHP', 'refresh');
			}
			
		} else {
			$this->logout();
		}
	}

	public function data_khp_form() //112023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_KHP = $this->input->post('ID_KHP');
			$data = $this->KHP_form_model->khp_form_list_by_id_khp($ID_KHP);
			echo json_encode($data);

			$ID_KHP = $ID_KHP;
			$KETERANGAN = "data_khp_form: " . json_encode($data);
            $this->user_log_khp( $ID_KHP, $KETERANGAN);
		} else {
			$this->logout();
		}
	}

	public function get_data() //112023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_KHP_FORM = $this->input->post('ID_KHP_FORM');
			$data = $this->KHP_form_model->get_data_by_id_khp_form($ID_KHP_FORM);
			echo json_encode($data);

			$ID_KHP_FORM = $ID_KHP_FORM;
			$KETERANGAN = "get_data: " . json_encode($data);
            $this->user_log_khp_form( $ID_KHP_FORM, $KETERANGAN);
		} else {
			$this->logout();
		}
	}

	public function hapus_data() //112023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_KHP_FORM = $this->input->post('ID_KHP_FORM');
			$data_hapus = $this->KHP_form_model->get_data_by_id_khp_form($ID_KHP_FORM);

			$ID_KHP_FORM = $ID_KHP_FORM;
			$KETERANGAN = "hapus_data: " . json_encode($data_hapus);
            $this->user_log_khp_form( $ID_KHP_FORM, $KETERANGAN);

			$data = $this->KHP_form_model->hapus_data_by_id_khp_form($ID_KHP_FORM);
			echo json_encode($data);

		} else {
			$this->logout();
		}
	}

	public function hapus_data_semua()//122023
	{
		if ($this->ion_auth->logged_in()) {
			$HASH_MD5_KHP = $this->input->post('HASH_MD5_KHP');
			$data_hapus = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);

			$ID_KHP = $data_hapus['ID_KHP'];

			$KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
			$this->user_log_khp($ID_KHP, $KETERANGAN);

			// $data_khp_form = $this->KHP_form_model->khp_form_list_by_id_khp($ID_KHP);
			// 	foreach ($data_khp_form as $KHP_FORM):
			// 		$this->data['ID_SPPB_FORM'] = $SPP_FORM->ID_SPPB_FORM;
			// 		$this->SPP_form_model->update_status_id_sppb_form_incomplete($this->data['ID_SPPB_FORM']);
			// 	endforeach;

			$data = $this->KHP_form_model->hapus_data_by_id_khp($ID_KHP);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}

	public function update_data() //112023
	{
		if ($this->ion_auth->logged_in()) {

			//set validation rules
			$this->form_validation->set_rules('NAMA', 'Nama Barang', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('MEREK', 'Merek Barang', 'trim|max_length[100]');
			$this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('JUMLAH_MINTA', 'Jumlah Yang Diadakan', 'trim|numeric|greater_than[0]|less_than[99999999999]|required');
			$this->form_validation->set_rules('SATUAN_BARANG', 'Satuan Barang', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('KETERANGAN', 'Keterangan', 'trim|max_length[400]');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_KHP = $this->input->post('ID_KHP');
				$ID_KHP_FORM = $this->input->post('ID_KHP_FORM');
				$JUMLAH_MINTA = $this->input->post('JUMLAH_MINTA');
				$SATUAN_BARANG = $this->input->post('SATUAN_BARANG');
				$NAMA = $this->input->post('NAMA');
				$MEREK = $this->input->post('MEREK');
				$SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
				$KETERANGAN = $this->input->post('KETERANGAN');

				$ID_VENDOR_PERTAMA = $this->input->post('ID_VENDOR_PERTAMA');
				$HARGA_SATUAN_BARANG_VENDOR_PERTAMA = $this->input->post('HARGA_SATUAN_BARANG_VENDOR_PERTAMA');
				$HARGA_TOTAL_VENDOR_PERTAMA = $this->input->post('HARGA_TOTAL_VENDOR_PERTAMA');

				$ID_VENDOR_KEDUA = $this->input->post('ID_VENDOR_KEDUA');
				$HARGA_SATUAN_BARANG_VENDOR_KEDUA = $this->input->post('HARGA_SATUAN_BARANG_VENDOR_KEDUA');
				$HARGA_TOTAL_VENDOR_KEDUA = $this->input->post('HARGA_TOTAL_VENDOR_KEDUA');

				$ID_VENDOR_KETIGA = $this->input->post('ID_VENDOR_KETIGA');
				$HARGA_SATUAN_BARANG_VENDOR_KETIGA = $this->input->post('HARGA_SATUAN_BARANG_VENDOR_KETIGA');
				$HARGA_TOTAL_VENDOR_KETIGA = $this->input->post('HARGA_TOTAL_VENDOR_KETIGA');

				$data_edit = $this->KHP_form_model->get_data_by_id_khp_form($ID_KHP_FORM);

				$data = $this->KHP_form_model->update_data(
					$ID_KHP_FORM,
					$JUMLAH_MINTA,
					$SATUAN_BARANG,
					$NAMA,
					$MEREK,
					$SPESIFIKASI_SINGKAT,
					$KETERANGAN,
					$ID_VENDOR_PERTAMA,
					$HARGA_SATUAN_BARANG_VENDOR_PERTAMA,
					$HARGA_TOTAL_VENDOR_PERTAMA,
					$ID_VENDOR_KEDUA,
					$HARGA_SATUAN_BARANG_VENDOR_KEDUA,
					$HARGA_TOTAL_VENDOR_KEDUA,
					$ID_VENDOR_KETIGA,
					$HARGA_SATUAN_BARANG_VENDOR_KETIGA,
					$HARGA_TOTAL_VENDOR_KETIGA
				);
				echo json_encode($data);

				$KETERANGAN = "update_data: " . json_encode($data_edit) 
				. ";" . $ID_KHP_FORM
				. ";" . $JUMLAH_MINTA
				. ";" . $SATUAN_BARANG
				. ";" . $NAMA
				. ";" . $MEREK
				. ";" . $SPESIFIKASI_SINGKAT
				. ";" . $KETERANGAN
				. ";" . $ID_VENDOR_PERTAMA
				. ";" . $HARGA_SATUAN_BARANG_VENDOR_PERTAMA
				. ";" . $HARGA_TOTAL_VENDOR_PERTAMA
				. ";" . $ID_VENDOR_KEDUA
				. ";" . $HARGA_SATUAN_BARANG_VENDOR_KEDUA
				. ";" . $HARGA_TOTAL_VENDOR_KEDUA
				. ";" . $ID_VENDOR_KETIGA
				. ";" . $HARGA_SATUAN_BARANG_VENDOR_KETIGA
				. ";" . $HARGA_TOTAL_VENDOR_KETIGA;
	
				$ID_KHP_FORM = $ID_KHP_FORM;
				$this->user_log_khp_form( $ID_KHP_FORM, $KETERANGAN);

			}
		} else {
			$this->logout();
		}
	}

	public function update_data_penetapan_vendor() //112023
	{
		if ($this->ion_auth->logged_in()) {

			//set validation rules
			$this->form_validation->set_rules('ID_VENDOR_FIX', 'Vendor Ditetapkan', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_KHP = $this->input->post('ID_KHP');
				$ID_KHP_FORM = $this->input->post('ID_KHP_FORM');
				$ID_VENDOR_FIX = $this->input->post('ID_VENDOR_FIX');

				$data_edit = $this->KHP_form_model->get_data_by_id_khp_form($ID_KHP_FORM);

				$data = $this->KHP_form_model->update_data_penetapan_vendor($ID_KHP_FORM, $ID_VENDOR_FIX);
				echo json_encode($data);

				$KETERANGAN = "update_data_penetapan_vendor: " 
				. json_encode($data_edit) 
				. ";" . $ID_KHP 
				. ";" . $ID_KHP_FORM 
				. ";" . $ID_VENDOR_FIX;
				$ID_KHP_FORM = $ID_KHP_FORM;
				$this->user_log_khp_form( $ID_KHP_FORM, $KETERANGAN);

			}
		} else {
			$this->logout();
		}
	}

	public function simpan_data_dari_sppb_form() //112023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_SPPB_FORM = $this->input->post('ID_SPPB_FORM');
			$ID_KHP = $this->input->post('ID_KHP');

			$ID_KHP = $ID_KHP;
			$KETERANGAN = "hapus_data: " . json_encode($data_hapus);
            $this->user_log_khp( $ID_KHP, $KETERANGAN);
			
			foreach ($ID_SPPB_FORM as $index => $ID_SPPB_FORM) {
				$this->KHP_form_model->simpan_data_dari_sppb_form($ID_SPPB_FORM, $ID_KHP);

				$ID_KHP = $ID_KHP;
				$KETERANGAN = "simpan_data_dari_sppb_form: " . json_encode($ID_SPPB_FORM);
				$this->user_log_khp( $ID_KHP, $KETERANGAN);
			}
			redirect($_SERVER['HTTP_REFERER']);
		} else {
			$this->logout();
		}
	}

	public function simpan_identitas_form() //112023
	{
		if ($this->ion_auth->logged_in()) {

			//set validation rules
			$this->form_validation->set_rules('ID_VENDOR_PERTAMA', 'Vendor Pertama', 'trim|required');
			$this->form_validation->set_rules('NO_URUT_KHP_GANTI', 'No. Urut KHP', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('TANGGAL_DOKUMEN_KHP', 'Tanggal Dokumen KHP', 'trim|required');

			$NO_URUT_KHP_GANTI = $this->input->post('NO_URUT_KHP_GANTI');
			$NO_URUT_KHP_ASLI = $this->input->post('NO_URUT_KHP_ASLI');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo (validation_errors());
			} else {

				//get the form data
				$ID_KHP = $this->input->post('ID_KHP');
				$KETERANGAN_KHP = $this->input->post('KETERANGAN_KHP');
				$ID_VENDOR_PERTAMA = $this->input->post('ID_VENDOR_PERTAMA');
				$ID_VENDOR_KEDUA = $this->input->post('ID_VENDOR_KEDUA');
				$ID_VENDOR_KETIGA = $this->input->post('ID_VENDOR_KETIGA');
				$DELIVERY_VENDOR_PERTAMA = $this->input->post('DELIVERY_VENDOR_PERTAMA');
				$DELIVERY_VENDOR_KEDUA = $this->input->post('DELIVERY_VENDOR_KEDUA');
				$DELIVERY_VENDOR_KETIGA = $this->input->post('DELIVERY_VENDOR_KETIGA');
				$SISTEM_BAYAR_VENDOR_PERTAMA = $this->input->post('SISTEM_BAYAR_VENDOR_PERTAMA');
				$SISTEM_BAYAR_VENDOR_KEDUA = $this->input->post('SISTEM_BAYAR_VENDOR_KEDUA');
				$SISTEM_BAYAR_VENDOR_KETIGA = $this->input->post('SISTEM_BAYAR_VENDOR_KETIGA');
				$NO_URUT_KHP_GANTI = $this->input->post('NO_URUT_KHP_GANTI');
				$TANGGAL_DOKUMEN_KHP = $this->input->post('TANGGAL_DOKUMEN_KHP');

				if($ID_VENDOR_KEDUA == '')
				{
					$ID_VENDOR_KEDUA = '';
					$DELIVERY_VENDOR_KEDUA = '';
					$SISTEM_BAYAR_VENDOR_KEDUA = '';
				}

				if($ID_VENDOR_KETIGA == '')
				{
					$ID_VENDOR_KETIGA = '';
					$DELIVERY_VENDOR_KETIGA = '';
					$SISTEM_BAYAR_VENDOR_KETIGA = '';
				}

				if($NO_URUT_KHP_GANTI==$NO_URUT_KHP_ASLI)
				{
					$data_edit = $this->KHP_model->khp_list_by_id_khp($ID_KHP);

					$data = $this->KHP_model->simpan_identitas_form(
						$ID_KHP, 
						$KETERANGAN_KHP, 
						$ID_VENDOR_PERTAMA, 
						$DELIVERY_VENDOR_PERTAMA, 
						$SISTEM_BAYAR_VENDOR_PERTAMA, 
						$ID_VENDOR_KEDUA, 
						$DELIVERY_VENDOR_KEDUA, 
						$SISTEM_BAYAR_VENDOR_KEDUA, 
						$ID_VENDOR_KETIGA, 
						$DELIVERY_VENDOR_KETIGA, 
						$SISTEM_BAYAR_VENDOR_KETIGA,
						$NO_URUT_KHP_GANTI,
						$TANGGAL_DOKUMEN_KHP
					);
					echo json_encode($data);

					$KETERANGAN = "simpan_identitas_form: " 
					. json_encode($data_edit) 
					. ";" . $ID_KHP 
					. ";" . $KETERANGAN_KHP
					. ";" . $ID_VENDOR_PERTAMA 
					. ";" . $DELIVERY_VENDOR_PERTAMA
					. ";" . $SISTEM_BAYAR_VENDOR_PERTAMA 
					. ";" . $ID_VENDOR_KEDUA
					. ";" . $DELIVERY_VENDOR_KEDUA 
					. ";" . $SISTEM_BAYAR_VENDOR_KEDUA
					. ";" . $ID_VENDOR_KETIGA 
					. ";" . $DELIVERY_VENDOR_KETIGA
					. ";" . $SISTEM_BAYAR_VENDOR_KETIGA
					. ";" . $NO_URUT_KHP_GANTI
					. ";" . $TANGGAL_DOKUMEN_KHP;

					$ID_KHP = $ID_KHP;
					$this->user_log_khp( $ID_KHP, $KETERANGAN);
					}

				else
				{
					if ($this->KHP_model->cek_nomor_urut_KHP($NO_URUT_KHP_GANTI) == 'DATA BELUM ADA') {

						$data_edit = $this->KHP_model->khp_list_by_id_khp($ID_KHP);

						$data = $this->KHP_model->simpan_identitas_form(
							$ID_KHP, 
							$KETERANGAN_KHP, 
							$ID_VENDOR_PERTAMA, 
							$DELIVERY_VENDOR_PERTAMA, 
							$SISTEM_BAYAR_VENDOR_PERTAMA, 
							$ID_VENDOR_KEDUA, 
							$DELIVERY_VENDOR_KEDUA, 
							$SISTEM_BAYAR_VENDOR_KEDUA, 
							$ID_VENDOR_KETIGA, 
							$DELIVERY_VENDOR_KETIGA, 
							$SISTEM_BAYAR_VENDOR_KETIGA,
							$NO_URUT_KHP_GANTI,
							$TANGGAL_DOKUMEN_KHP
						);
						echo json_encode($data);

						$KETERANGAN = "simpan_identitas_form: " 
						. json_encode($data_edit) 
						. ";" . $ID_KHP 
						. ";" . $KETERANGAN_KHP
						. ";" . $ID_VENDOR_PERTAMA 
						. ";" . $DELIVERY_VENDOR_PERTAMA
						. ";" . $SISTEM_BAYAR_VENDOR_PERTAMA 
						. ";" . $ID_VENDOR_KEDUA
						. ";" . $DELIVERY_VENDOR_KEDUA 
						. ";" . $SISTEM_BAYAR_VENDOR_KEDUA
						. ";" . $ID_VENDOR_KETIGA 
						. ";" . $DELIVERY_VENDOR_KETIGA
						. ";" . $SISTEM_BAYAR_VENDOR_KETIGA
						. ";" . $NO_URUT_KHP_GANTI
						. ";" . $TANGGAL_DOKUMEN_KHP;

						$ID_KHP = $ID_KHP;
						$this->user_log_khp( $ID_KHP, $KETERANGAN);
						
					}
					else {
						echo 'Nomor Urut KHP sudah terekam sebelumnya';
					}
				}
			}
		} else {
			$this->logout();
		}
	}

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

		$this->data['title'] = 'SIPESUT | Form KHP';

		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_KHP = $this->uri->segment(3);
		if ($this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP) == 'TIDAK ADA DATA') {
			redirect('KHP', 'refresh');
		}

		if ($this->ion_auth->logged_in()) {

			
			if ($this->ion_auth->in_group(5)) {
				$this->data['HASH_MD5_KHP'] = $HASH_MD5_KHP;
				$this->cetak_pdf($HASH_MD5_KHP);

				$hasil = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);
				$ID_KHP = $hasil['ID_KHP'];
				$this->data['ID_KHP'] = $ID_KHP;
				$this->data['KHP'] = $this->KHP_model->khp_list_by_id_khp($ID_KHP);

				$KETERANGAN = "view: ";
				$ID_KHP = $ID_KHP;
				$this->user_log_khp($ID_KHP, $KETERANGAN);

				foreach ($this->data['KHP']->result() as $KHP):
					$this->data['FILE_NAME_TEMP'] = 'khp_' . $HASH_MD5_KHP . '.pdf';
					$this->data['NO_URUT_KHP'] = $KHP->NO_URUT_KHP;
					$this->data['HASH_MD5_KHP'] = $KHP->HASH_MD5_KHP;
					$this->data['PROGRESS_KHP'] = $KHP->PROGRESS_KHP;
					$this->data['STATUS_KHP'] = $KHP->STATUS_KHP;
				endforeach;

				$query_file_HASH_MD5_KHP = $this->KHP_Form_File_Model->file_list_by_HASH_MD5_KHP($HASH_MD5_KHP);

				if ($query_file_HASH_MD5_KHP->num_rows() > 0) {

					$this->data['dokumen'] = $this->KHP_Form_File_Model->file_list_by_HASH_MD5_KHP_result($HASH_MD5_KHP);

					$hasil = $query_file_HASH_MD5_KHP->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_khp_form_file/' . $DOK_FILE)) {
						$this->data['DOK_FILE'] = $DOK_FILE;
						$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
						$this->data['JENIS_FILE'] = $JENIS_FILE;
						$this->data['FILE'] = "ADA";
					}
				} else {
					$this->data['FILE'] = "TIDAK ADA";
				}

				$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_kp/user_menu');
				$this->load->view('wasa/user_staff_procurement_kp/left_menu');
				$this->load->view('wasa/user_staff_procurement_kp/header_menu');
				$this->load->view('wasa/user_staff_procurement_kp/content_khp_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(6)) {
				$this->cetak_pdf($HASH_MD5_KHP);

				$hasil = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);
				$ID_KHP = $hasil['ID_KHP'];
				$this->data['ID_KHP'] = $ID_KHP;
				$this->data['KHP'] = $this->KHP_model->khp_list_by_id_khp($ID_KHP);

				foreach ($this->data['KHP']->result() as $KHP):
					$this->data['FILE_NAME_TEMP'] = 'khp_' . $HASH_MD5_KHP . '.pdf';
					$this->data['NO_URUT_KHP'] = $KHP->NO_URUT_KHP;
					$this->data['HASH_MD5_KHP'] = $KHP->HASH_MD5_KHP;
					$this->data['PROGRESS_KHP'] = $KHP->PROGRESS_KHP;
				endforeach;

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_khp_form');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(7)) {
				$this->cetak_pdf($HASH_MD5_KHP);

				$hasil = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);
				$ID_KHP = $hasil['ID_KHP'];
				$this->data['ID_KHP'] = $ID_KHP;
				$this->data['KHP'] = $this->KHP_model->khp_list_by_id_khp($ID_KHP);

				foreach ($this->data['KHP']->result() as $KHP):
					$this->data['FILE_NAME_TEMP'] = 'khp_' . $HASH_MD5_KHP . '.pdf';
					$this->data['NO_URUT_KHP'] = $KHP->NO_URUT_KHP;
					$this->data['HASH_MD5_KHP'] = $KHP->HASH_MD5_KHP;
					$this->data['PROGRESS_KHP'] = $KHP->PROGRESS_KHP;
				endforeach;

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_khp_form');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(8)) {
				$this->cetak_pdf($HASH_MD5_KHP);

				$hasil = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);
				$ID_KHP = $hasil['ID_KHP'];
				$this->data['ID_KHP'] = $ID_KHP;
				$this->data['KHP'] = $this->KHP_model->khp_list_by_id_khp($ID_KHP);

				foreach ($this->data['KHP']->result() as $KHP):
					$this->data['FILE_NAME_TEMP'] = 'khp_' . $HASH_MD5_KHP . '.pdf';
					$this->data['NO_URUT_KHP'] = $KHP->NO_URUT_KHP;
					$this->data['HASH_MD5_KHP'] = $KHP->HASH_MD5_KHP;
					$this->data['PROGRESS_KHP'] = $KHP->PROGRESS_KHP;
				endforeach;

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_khp_form');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(9)) {
				$this->cetak_pdf($HASH_MD5_KHP);

				$hasil = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);
				$ID_KHP = $hasil['ID_KHP'];
				$this->data['ID_KHP'] = $ID_KHP;
				$this->data['KHP'] = $this->KHP_model->khp_list_by_id_khp($ID_KHP);

				foreach ($this->data['KHP']->result() as $KHP):
					$this->data['FILE_NAME_TEMP'] = 'khp_' . $HASH_MD5_KHP . '.pdf';
					$this->data['NO_URUT_KHP'] = $KHP->NO_URUT_KHP;
					$this->data['HASH_MD5_KHP'] = $KHP->HASH_MD5_KHP;
					$this->data['PROGRESS_KHP'] = $KHP->PROGRESS_KHP;
				endforeach;

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_khp_form');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else {
				redirect('KHP', 'refresh');
			}
		} else {
			$this->logout();
		}
	}

	public function hapus_file()
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
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->KHP_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_khp_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->KHP_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_KHP = $this->session->userdata('HASH_MD5_KHP');
				redirect('/KHP_form/view/' . $HASH_MD5_KHP, 'refresh');
			} else {
				$HASH_MD5_KHP = $this->session->userdata('HASH_MD5_KHP');
				redirect('/KHP_form/view/' . $HASH_MD5_KHP, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
		} else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
		}
	}

	public function tanggal_indo_full($tanggal, $cetak_hari = false) //112023
	{
		if($tanggal == '0000-00-00')
		{
			$tgl_indo = "-";
			return $tgl_indo;
		}

		else if($tanggal == NULL)
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

	public function tanggal_indo_singkat($tanggal, $cetak_hari = false) //112023
	{
		if($tanggal == '0000-00-00')
		{
			$tgl_indo = "-";
			return $tgl_indo;
		}

		else if($tanggal == NULL)
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

	public function cetak_pdf($HASH_MD5_KHP)
	{
		$hasil = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);
		$this->data['ID_SPPB'] = $hasil['ID_SPPB'];
		$this->data['ID_KHP'] = $hasil['ID_KHP'];

		$this->data['ID_VENDOR_PERTAMA'] = $hasil['ID_VENDOR_PERTAMA'];
		$this->data['ID_VENDOR_KEDUA'] = $hasil['ID_VENDOR_KEDUA'];
		$this->data['ID_VENDOR_KETIGA'] = $hasil['ID_VENDOR_KETIGA'];

		$this->data['DELIVERY_VENDOR_PERTAMA'] = $hasil['DELIVERY_VENDOR_PERTAMA'];
		$this->data['DELIVERY_VENDOR_KEDUA'] = $hasil['DELIVERY_VENDOR_KEDUA'];
		$this->data['DELIVERY_VENDOR_KETIGA'] = $hasil['DELIVERY_VENDOR_KETIGA'];

		$this->data['SISTEM_BAYAR_VENDOR_PERTAMA'] = $hasil['SISTEM_BAYAR_VENDOR_PERTAMA'];
		$this->data['SISTEM_BAYAR_VENDOR_KEDUA'] = $hasil['SISTEM_BAYAR_VENDOR_KEDUA'];
		$this->data['SISTEM_BAYAR_VENDOR_KETIGA'] = $hasil['SISTEM_BAYAR_VENDOR_KETIGA'];

		$hasil2 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR_PERTAMA']);
		if ($hasil2 == 'BELUM ADA VENDOR') {
			$this->data['NAMA_VENDOR_PERTAMA'] = "";
			;
		} else {
			$this->data['NAMA_VENDOR_PERTAMA'] = $hasil2['NAMA_VENDOR'];
		}

		$hasil3 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR_KEDUA']);
		if ($hasil3 == 'BELUM ADA VENDOR') {
			$this->data['NAMA_VENDOR_KEDUA'] = "";
			;
		} else {
			$this->data['NAMA_VENDOR_KEDUA'] = $hasil3['NAMA_VENDOR'];
		}

		$hasil4 = $this->Vendor_model->get_data_by_id_vendor($this->data['ID_VENDOR_KETIGA']);
		if ($hasil4 == 'BELUM ADA VENDOR') {
			$this->data['NAMA_VENDOR_KETIGA'] = "";
			;
		} else {
			$this->data['NAMA_VENDOR_KETIGA'] = $hasil4['NAMA_VENDOR'];
		}

		$ID_KHP = $hasil['ID_KHP'];
		$this->data['KHP'] = $this->KHP_model->khp_list_khp_by_hashmd5($HASH_MD5_KHP);
		foreach ($this->data['KHP']->result() as $KHP):
			$this->data['ID_PROYEK'] = $KHP->ID_PROYEK;
			$this->data['NO_URUT_KHP'] = $KHP->NO_URUT_KHP;
			$this->data['TANGGAL_PEMBUATAN_KHP_HARI'] = $KHP->TANGGAL_PEMBUATAN_KHP_HARI;
			$this->data['TANGGAL_PEMBUATAN_KHP_HARI'] = $this->tanggal_indo_full($KHP->TANGGAL_PEMBUATAN_KHP_HARI, false);
			$this->data['TANGGAL_PEMBUATAN_KHP_BULAN'] = $KHP->TANGGAL_PEMBUATAN_KHP_BULAN;
			$this->data['TANGGAL_PEMBUATAN_KHP_TAHUN'] = $KHP->TANGGAL_PEMBUATAN_KHP_TAHUN;
			$this->data['ID_KHP'] = $KHP->ID_KHP;
			$this->data['ID_SPPB'] = $KHP->ID_SPPB;
			$this->data['SUB_PROYEK'] = $KHP->SUB_PROYEK;
			$this->data['ID_PROYEK_SUB_PEKERJAAN'] = $KHP->ID_PROYEK_SUB_PEKERJAAN;
			$this->data['TANGGAL_DOKUMEN_KHP'] = $KHP->TANGGAL_DOKUMEN_KHP;
			$this->data['TANGGAL_DOKUMEN_KHP'] = $this->tanggal_indo_full($KHP->TANGGAL_DOKUMEN_KHP, false);
			$this->data['KETERANGAN_KHP'] = $KHP->KETERANGAN_KHP;
		endforeach;

		$this->data['PROYEK'] = $this->Proyek_model->detil_proyek_by_ID_PROYEK($this->data['ID_PROYEK']);
		foreach ($this->data['PROYEK']->result() as $PROYEK):
			$this->data['NAMA_PROYEK_PDF'] = $PROYEK->NAMA_PROYEK;
		endforeach;

		$this->data['SUB_PROYEK'] = $this->Proyek_model->sub_pekerjaan_list($this->data['ID_PROYEK_SUB_PEKERJAAN']);
		foreach ($this->data['SUB_PROYEK']->result() as $SUB_PROYEK):
			$this->data['SUB_PROYEK_PDF'] = $SUB_PROYEK->NAMA_SUB_PEKERJAAN;
		endforeach;

		$this->data['konten_KHP_form'] = $this->KHP_form_model->khp_form_list_by_id_khp($ID_KHP);

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE

		$config['cacheable'] = true; //boolean, the default is true
		$config['cachedir'] = './assets/QR_KHP/cachedir/'; //string, the default is application/cache/
		$config['errorlog'] = './assets/QR_KHP/errorlog/'; //string, the default is application/logs/
		$config['imagedir'] = './assets/QR_KHP/'; //direktori penyimpanan qr code
		$config['quality'] = true; //boolean, the default is true
		$config['size'] = '1024'; //interger, the default is 1024
		$config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
		$config['white'] = array(70, 130, 180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		$image_name = $HASH_MD5_KHP . '.jpg'; //buat name dari qr code sesuai dengan nim
		$this->data['image_name'] = $image_name;

		$params['data'] = base_url('index.php/Otentikasi_dokumen/KHP/') . $HASH_MD5_KHP; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		$this->data['GAMBAR_QR'] = 'C:/xampp/htdocs/project_eam/assets/QR_KHP/' . $HASH_MD5_KHP . ".jpg";
		$this->data['GAMBAR_QR_2'] = 'C:/xampp/htdocs/project_eam/assets/QR_KHP/' . $HASH_MD5_KHP . ".jpg";

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Komparasi Harga Pemasok';

		// filename dari pdf ketika didownload
		$file_pdf = 'khp_' . $HASH_MD5_KHP;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "landscape";

		$html = $this->load->view('wasa/pdf/khp_pdf', $this->data, true);

		// run dompdf
		$x = 735;
		$y = 560;
		$text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size = 7;

		$file_path = "assets/KHP/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	public function update_data_kirim_khp() //112023 //belum cek semua
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) { //user_staff_procurement_kp


			//set validation rules
			$this->form_validation->set_rules('ID_KHP', 'KHP', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_KHP = $this->input->post('ID_KHP');

				$PROGRESS_KHP = "Diproses oleh Kasie Procurement KP";
				$STATUS_KHP = "Sedang diproses";

				$KETERANGAN = $PROGRESS_KHP . " " . $STATUS_KHP;

				$ID_KHP = $ID_KHP;
 				//$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$data = $this->KHP_form_model->update_data_kirim_khp($ID_KHP, $PROGRESS_KHP, $STATUS_KHP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {


			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_KHP', 'HASH_MD5_KHP ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_KHP = $this->input->post('HASH_MD5_KHP');

				$KETERANGAN = "Dalam Pembuatan Email: " . " ---- " . $HASH_MD5_KHP;
				$this->user_log($KETERANGAN);

				$PROGRESS_KHP = "Dalam Pembuatan Email";

				$data = $this->KHP_model->update_progress_khp($HASH_MD5_KHP, $PROGRESS_KHP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {


			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_KHP', 'HASH_MD5_KHP ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_KHP = $this->input->post('HASH_MD5_KHP');

				$KETERANGAN = "Dalam Pembuatan Email: " . " ---- " . $HASH_MD5_KHP;
				$this->user_log($KETERANGAN);

				$PROGRESS_KHP = "Dalam Pembuatan Email";

				$data = $this->KHP_model->update_progress_khp($HASH_MD5_KHP, $PROGRESS_KHP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {


			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_KHP', 'HASH_MD5_KHP ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_KHP = $this->input->post('HASH_MD5_KHP');

				$KETERANGAN = "Dalam Pembuatan Email: " . " ---- " . $HASH_MD5_KHP;
				$this->user_log($KETERANGAN);

				$PROGRESS_KHP = "Dalam Pembuatan Email";

				$data = $this->KHP_model->update_progress_khp($HASH_MD5_KHP, $PROGRESS_KHP);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {


			//set validation rules
			$this->form_validation->set_rules('HASH_MD5_KHP', 'HASH_MD5_KHP ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) { //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$HASH_MD5_KHP = $this->input->post('HASH_MD5_KHP');

				$KETERANGAN = "Dalam Pembuatan Email: " . " ---- " . $HASH_MD5_KHP;
				$this->user_log($KETERANGAN);

				$PROGRESS_KHP = "Dalam Pembuatan Email";

				$data = $this->KHP_model->update_progress_khp($HASH_MD5_KHP, $PROGRESS_KHP);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	public function proses_upload_file()//112023
	{

		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		$HASH_MD5_KHP = $this->session->userdata('HASH_MD5_KHP');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in()) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_KHP . '_';
			$config['upload_path'] = './assets/upload_khp_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_khp = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);
			$ID_KHP = $query_id_khp['ID_KHP'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_khp_form_file/' . $nama;
				$this->db->insert('khp_form_file', array('ID_KHP' => $ID_KHP, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_KHP' => $HASH_MD5_KHP, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('KHP', 'refresh');
		}
	}

	public function proses_upload_file_excel_bulk_khp()
	{

		$HASH_MD5_KHP = $this->input->post('HASH_MD5_KHP_UPLOAD_EXCEL');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in()) {

			$WAKTU = date('Y-m-d H:i:s');
			$nama_file = "excel_" . $HASH_MD5_KHP;
			$config['upload_path'] = './assets/upload_khp_form_excel/';
			$config['allowed_types'] = 'xlsx';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_khp = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);
			$ID_KHP = $query_id_khp['ID_KHP'];

		
			if (file_exists($file = './assets/upload_khp_form_excel/' .$nama_file.".xlsx")) {
				unlink($file);
			}

			if ($this->upload->do_upload('userfile')) {
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
						$inserdata['NAMA_BARANG']= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						if(strstr($inserdata['NAMA_BARANG'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['NAMA_BARANG'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['NAMA_BARANG'], ";")){
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
						if(strstr($inserdata['MEREK'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['MEREK'], ";")){
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
						if(strstr($inserdata['SPESIFIKASI_SINGKAT'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['SPESIFIKASI_SINGKAT'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['JUMLAH_MINTA'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						if(strstr($inserdata['JUMLAH_MINTA'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['JUMLAH_MINTA'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['JUMLAH_MINTA'], ";")){
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
						if(strstr($inserdata['SATUAN_BARANG'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['SATUAN_BARANG'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['HARGA_SATUAN_BARANG_VENDOR_PERTAMA'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
						if(strstr($inserdata['HARGA_SATUAN_BARANG_VENDOR_PERTAMA'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['HARGA_SATUAN_BARANG_VENDOR_PERTAMA'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['HARGA_SATUAN_BARANG_VENDOR_PERTAMA'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['HARGA_SATUAN_BARANG_VENDOR_KEDUA'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
						if(strstr($inserdata['HARGA_SATUAN_BARANG_VENDOR_KEDUA'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['HARGA_SATUAN_BARANG_VENDOR_KEDUA'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['HARGA_SATUAN_BARANG_VENDOR_KEDUA'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}

						$inserdata['HARGA_SATUAN_BARANG_VENDOR_KETIGA'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
						if(strstr($inserdata['HARGA_SATUAN_BARANG_VENDOR_KETIGA'], '"')){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['HARGA_SATUAN_BARANG_VENDOR_KETIGA'], "'")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
						if(strstr($inserdata['HARGA_SATUAN_BARANG_VENDOR_KETIGA'], ";")){
							echo 'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon';
							$ada_error = "ya";
							break;
						}
					}

					if($ada_error == "tidak")
					{
						for($row=2; $row<=$highestRow; $row++)
						{
							$inserdata['NAMA_BARANG']= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
							$inserdata['MEREK'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
							$inserdata['SPESIFIKASI_SINGKAT'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
							$inserdata['JUMLAH_MINTA'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
							$inserdata['SATUAN_BARANG'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
							$inserdata['HARGA_SATUAN_BARANG_VENDOR_PERTAMA'] = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
							$inserdata['HARGA_SATUAN_BARANG_VENDOR_KEDUA'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
							$inserdata['HARGA_SATUAN_BARANG_VENDOR_KETIGA'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
							$inserdata['ID_KHP_FORM'] = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

							$inserdata['HARGA_TOTAL_VENDOR_PERTAMA'] = $inserdata['JUMLAH_MINTA'] * $inserdata['HARGA_SATUAN_BARANG_VENDOR_PERTAMA'];
							$inserdata['HARGA_TOTAL_VENDOR_KEDUA'] = $inserdata['JUMLAH_MINTA'] * $inserdata['HARGA_SATUAN_BARANG_VENDOR_KEDUA'];
							$inserdata['HARGA_TOTAL_VENDOR_KETIGA'] = $inserdata['JUMLAH_MINTA'] * $inserdata['HARGA_SATUAN_BARANG_VENDOR_KETIGA'];

							$data = $this->KHP_form_model->update_data_from_excel(
								$ID_KHP,
								$inserdata['ID_KHP_FORM'],
								$inserdata['NAMA_BARANG'],
								$inserdata['MEREK'],
								$inserdata['SPESIFIKASI_SINGKAT'],
								$inserdata['JUMLAH_MINTA'],
								$inserdata['SATUAN_BARANG'],
								$inserdata['HARGA_SATUAN_BARANG_VENDOR_PERTAMA'],
								$inserdata['HARGA_TOTAL_VENDOR_PERTAMA'],
								$inserdata['HARGA_SATUAN_BARANG_VENDOR_KEDUA'],
								$inserdata['HARGA_TOTAL_VENDOR_KEDUA'],
								$inserdata['HARGA_SATUAN_BARANG_VENDOR_KETIGA'],
								$inserdata['HARGA_TOTAL_VENDOR_KETIGA']);
							
						}
					}
				}
			}

			// if (file_exists($file = './assets/upload_sppb_form_excel/' .$nama_file.".xlsx")) {
			// 	unlink($file);
			// }

		} else {
			// alihkan mereka ke halaman sppb list
			redirect('KHP', 'refresh');
		}
	}

	public function download_excel() //112023
	{
		//jika mereka sudah login
		if ($this->ion_auth->logged_in()) {
			$HASH_MD5_KHP = $this->uri->segment(3);

			if ($this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP) == 'TIDAK ADA DATA') {
				redirect('KHP', 'refresh');
			}

			$hasil = $this->KHP_model->get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP);
			$ID_KHP = $hasil['ID_KHP'];

			$objPHPExcel    =   new PHPExcel();
			// $result         =   $db->query("SELECT * FROM countries") or die(mysql_error());

			$data_KHP_form = $this->KHP_form_model->khp_form_list_by_id_khp($ID_KHP);
			
			$objPHPExcel->setActiveSheetIndex(0);

			$NAMA_VENDOR_PERTAMA = '1';
			$NAMA_VENDOR_KEDUA = '2';
			$NAMA_VENDOR_KETIGA = '3';

			$vendor_KHP_form = $this->KHP_form_model->vendor_list_by_id_khp($ID_KHP);
			foreach ($vendor_KHP_form as $VENDOR):
				$NAMA_VENDOR_PERTAMA = $VENDOR->NAMA_VENDOR_PERTAMA;
				$NAMA_VENDOR_KEDUA = $VENDOR->NAMA_VENDOR_KEDUA;
				$NAMA_VENDOR_KETIGA = $VENDOR->NAMA_VENDOR_KETIGA;
			endforeach;
				
			$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Nama Barang/Jasa');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Merek Barang/Jasa');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Spesifikasi Singkat');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Jumlah Yang Diadakan');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Satuan Barang');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1', $NAMA_VENDOR_PERTAMA);
			$objPHPExcel->getActiveSheet()->SetCellValue('G1', $NAMA_VENDOR_KEDUA);
			$objPHPExcel->getActiveSheet()->SetCellValue('H1', $NAMA_VENDOR_KETIGA);
			$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'ID KHP FORM');

			$objPHPExcel->getActiveSheet()->getStyle("A1:J1")->getFont()->setBold(true);
			
			$rowCount   =   2;
			foreach ($data_KHP_form as $KHP):
				//var_dump($SPP->NAMA_BARANG);
				$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $KHP->NAMA_BARANG);
				$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $KHP->MEREK);
				$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $KHP->SPESIFIKASI_SINGKAT);
				$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $KHP->JUMLAH_MINTA);
				$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $KHP->SATUAN_BARANG);
				$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $KHP->HARGA_SATUAN_BARANG_VENDOR_PERTAMA);
				$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $KHP->HARGA_SATUAN_BARANG_VENDOR_KEDUA);
				$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $KHP->HARGA_SATUAN_BARANG_VENDOR_KETIGA);
				$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $KHP->ID_KHP_FORM);
				$rowCount++;
			endforeach;
			
			
			$objWriter  =   new PHPExcel_Writer_Excel2007($objPHPExcel);
			// var_dump($objPHPExcel);

			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="bulk_khp_'.$HASH_MD5_KHP.'.xlsx"');
			header('Cache-Control: max-age=0'); //no cache
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
			$objWriter->save('php://output');

		} else {
			// alihkan mereka ke halaman sppb list
			redirect('KHP', 'refresh');
		}

	}
}