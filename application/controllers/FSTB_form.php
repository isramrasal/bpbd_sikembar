<?php defined('BASEPATH') or exit('No direct script access allowed');

class FSTB_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->load->model('FSTB_form_model');
		$this->load->model('FSTB_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('FSTB_Form_File_Model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "FSTB_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()//092023
	{
		$ID_FSTB_FORM = 0;
		$KETERANGAN = "Paksa Logout Ketika Akses FSTB Form";
        $this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

        $this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN) //102023
	{
		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->FSTB_form_model->user_log_fstb_form($user->ID_PEGAWAI, $ID_FSTB_FORM, $KETERANGAN, $WAKTU);
	}

	public function user_log_fstb($ID_FSTB, $KETERANGAN) //10203
    {
        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->FSTB_model->user_log_FSTB($user->ID_PEGAWAI, $ID_FSTB, $KETERANGAN, $WAKTU);
    }

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index() //092023
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

		$this->data['title'] = 'SIPESUT | Ubah FSTB';


		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_FSTB = $this->uri->segment(3);
		if ($this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB) == 'TIDAK ADA DATA FSTB') {
			redirect('Auth', 'refresh');
		}

		//fungsi ini untuk mengirim data ke dropdown
		$HASH_MD5_FSTB = $this->uri->segment(3);
		$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
		$this->data['ID_SPPB'] = $hasil['ID_SPPB'];
		$this->data['SPPB'] = $this->FSTB_model->sppb_list_by_id_sppb($this->data['ID_SPPB']);
		$this->data['ID_SPP'] = $hasil['ID_SPP'];
		$this->data['SPP'] = $this->FSTB_model->spp_list_by_id_spp($this->data['ID_SPP']);
		$this->data['ID_PO'] = $hasil['ID_PO'];
		$this->data['PO'] = $this->FSTB_model->po_list_by_id_po($this->data['ID_PO']);
		$this->data['ID_FSTB'] = $hasil['ID_FSTB'];
		$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($this->data['ID_FSTB']);
		$this->data['HASH_MD5_FSTB'] = $hasil['HASH_MD5_FSTB'];

		$this->data['CATATAN_FSTB'] = $this->FSTB_form_model->get_data_catatan_FSTB_by_id_fstb($this->data['ID_FSTB']);

		$this->data['po_barang_list'] = $this->FSTB_form_model->po_form_list_where_not_in_fstb($this->data['ID_PO']);

		foreach ($this->data['FSTB']->result() as $FSTB) :
			$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
			$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
			$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
		endforeach;

		$KETERANGAN = "Melihat Halaman Index FISTB Form: ";
				$ID_FSTB = $this->data['ID_FSTB'];
                $this->user_log_fstb($ID_FSTB, $KETERANGAN);

		if ($this->ion_auth->logged_in()) {

			if ($this->ion_auth->is_admin()) {

				$this->load->view('wasa/user_admin/head_normal', $this->data);
				$this->load->view('wasa/user_admin/user_menu');
				$this->load->view('wasa/user_admin/left_menu');
				$this->load->view('wasa/user_admin/header_menu');
				$this->load->view('wasa/user_admin/content_fstb_form_proses');
				$this->load->view('wasa/user_admin/footer');
	
			} else if ($this->ion_auth->in_group(5)) {

				if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Staff Procurement KP") {
					$this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_procurement_kp/user_menu');
					$this->load->view('wasa/user_staff_procurement_kp/left_menu');
					$this->load->view('wasa/user_staff_procurement_kp/header_menu');
					$this->load->view('wasa/user_staff_procurement_kp/content_fstb_form_proses');
					$this->load->view('wasa/user_staff_procurement_kp/footer');
				} else {
					redirect('FSTB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(6)) {

				if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Kasie Procurement KP") {
					$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
					$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
					$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
					$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
					$this->load->view('wasa/user_kasie_procurement_kp/content_fstb_form_proses');
					$this->load->view('wasa/user_kasie_procurement_kp/footer');
				} else if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Kasie Procurement KP") {
					$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
					$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
					$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
					$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
					$this->load->view('wasa/user_kasie_procurement_kp/content_fstb_form_proses');
					$this->load->view('wasa/user_kasie_procurement_kp/footer');
				} else {
					redirect('FSTB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(7)) {

				if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Manajer Procurement KP") {
					$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
					$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
					$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
					$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
					$this->load->view('wasa/user_manajer_procurement_kp/content_fstb_form_proses');
					$this->load->view('wasa/user_manajer_procurement_kp/footer');
				} else {
					redirect('FSTB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(8)) {

				if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Staff Procurement SP") {
					$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_procurement_sp/user_menu');
					$this->load->view('wasa/user_staff_procurement_sp/left_menu');
					$this->load->view('wasa/user_staff_procurement_sp/header_menu');
					$this->load->view('wasa/user_staff_procurement_sp/content_fstb_form_proses');
					$this->load->view('wasa/user_staff_procurement_sp/footer');
				} else {
					redirect('FSTB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(9)) {

				if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Supervisi Procurement SP") {
					$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
					$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
					$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
					$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
					$this->load->view('wasa/user_supervisi_procurement_sp/content_fstb_form_proses');
					$this->load->view('wasa/user_supervisi_procurement_sp/footer');
				} else {
					redirect('FSTB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(10)) {

				if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Staff Logistik KP") {
					$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/content_fstb_form_proses');
					$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
				} else if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Staff Logistik KP") {
					$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
					$this->load->view('wasa/user_staff_umum_logistik_kp/content_fstb_form_proses');
					$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
				} else {
					redirect('FSTB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(11)) {

				if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Kasie Logistik KP") {
					$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/content_fstb_form_proses');
					$this->load->view('wasa/user_kasie_logistik_kp/footer');
				} else if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Kasie Logistik KP") {
					$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
					$this->load->view('wasa/user_kasie_logistik_kp/content_fstb_form_proses');
					$this->load->view('wasa/user_kasie_logistik_kp/footer');
				} else {
					redirect('FSTB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(12)) {

				if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Manajer Logistik KP") {
					$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
					$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
					$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
					$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
					$this->load->view('wasa/user_manajer_logistik_kp/content_fstb_form_proses');
					$this->load->view('wasa/user_manajer_logistik_kp/footer');
				} else {
					redirect('FSTB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(13)) {

				if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Staff Umum Logistik SP") {
					$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/content_fstb_form_proses');
					$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
				} else if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Staff Logistik SP") {
					$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
					$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
					$this->load->view('wasa/user_staff_umum_logistik_sp/content_fstb_form_proses');
					$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
				} else {
					redirect('FSTB', 'refresh');
				}
			} else if ($this->ion_auth->in_group(15)) {

				if ($this->data['PROGRESS_FSTB'] == "Diproses oleh Supervisi Logistik SP") {
					$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
					$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
					$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
					$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
					$this->load->view('wasa/user_supervisi_logistik_sp/content_fstb_form_proses');
					$this->load->view('wasa/user_supervisi_logistik_sp/footer');
				} else {
					redirect('FSTB', 'refresh');
				}
			} else {
				$this->logout();
			}
		} else {
			$this->logout();
		}
	}

	function data_qty_fstb_realisasi() //092023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_PO_FORM = $this->input->post('ID_PO_FORM');
			$data = $this->FSTB_form_model->data_qty_po_realisasi_by_ID_PO_FORM($ID_PO_FORM);
			echo json_encode($data);

		} else {
			$this->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function data_fstb_form() //092023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_FSTB = $this->input->post('ID_FSTB');
			$data = $this->FSTB_form_model->fstb_form_list_by_id_fstb($ID_FSTB);
			echo json_encode($data);

			$ID_FSTB = $ID_FSTB;
			$KETERANGAN = "data_fstb_form: " . json_encode($ID_FSTB);
			$this->user_log_fstb($ID_FSTB, $KETERANGAN);
		}else {
			$this->logout();
		}
	}

	function hapus_data() //092023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_FSTB_FORM = $this->input->post('kode');
			$data_hapus = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);

			$ID_FSTB_FORM = $ID_FSTB_FORM;
			$KETERANGAN = "Hapus Data FISTB Form: " . json_encode($data_hapus);
			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

			$data = $this->FSTB_form_model->hapus_data_by_id_fstb_form($ID_FSTB_FORM);
			echo json_encode($data);
		} else {
			$this->logout();
		}
	}

	function hapus_data_semua() //092023
	{
		if ($this->ion_auth->logged_in()) {
			$HASH_MD5_FSTB = $this->input->post('HASH_MD5_FSTB');
			$data_hapus = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
			$ID_FSTB = $data_hapus['ID_FSTB'];

			$ID_FSTB = $ID_FSTB;
			$KETERANGAN = "Hapus Semua Data FISTB Form: " . json_encode($data_hapus);
			$this->user_log_fstb($ID_FSTB, $KETERANGAN);

			$data_fstb_form = $this->FSTB_form_model->fstb_form_list_by_id_fstb($ID_FSTB);
			foreach ($data_fstb_form as $FSTB_FORM):
				$this->data['ID_PO_FORM'] = $FSTB_FORM->ID_PO_FORM;
				$this->FSTB_form_model->update_status_id_po_form_incomplete($this->data['ID_PO_FORM']);
			endforeach;

			$data = $this->FSTB_form_model->hapus_data_by_id_fstb($ID_FSTB);
			echo json_encode($data);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	function simpan_data_dari_po_form() //092023
	{
		if ($this->ion_auth->logged_in()) {

			$ID_PO_FORM = $this->input->post('ID_PO_FORM');
			$ID_FSTB = $this->input->post('ID_FSTB');

			foreach ($ID_PO_FORM as $index => $ID_PO_FORM) {
				$ID_FSTB = $ID_FSTB;
				$KETERANGAN = "simpan_data_dari_po_form: " . json_encode($ID_PO_FORM) . " + ". json_encode($ID_FSTB);
				$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$this->FSTB_form_model->simpan_data_dari_po_form($ID_PO_FORM, $ID_FSTB);
			}

			redirect($_SERVER['HTTP_REFERER']);
			
		} else {
			$this->logout();
		}
	}

	function simpan_identitas_form() //092023
	{
		$user = $this->ion_auth->user()->row();
		$this->data['USER_ID'] = $user->id;
		$CREATE_BY_USER =  $this->data['USER_ID'];

		if ($this->ion_auth->logged_in()) {

			//set validation rules
			$this->form_validation->set_rules('NO_URUT_FSTB_GANTI', 'No. Urut FSTB', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('TANGGAL_DOKUMEN_FSTB', 'Tanggal Dokumen FSTB', 'trim|required');
			$this->form_validation->set_rules('LOKASI_PENYERAHAN', 'Lokasi Penyerahan', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR', 'Nomor Surat Jalan Vendor', 'trim|max_length[255]|required');
			$this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai Penerima Barang', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|max_length[100]|required');
			$this->form_validation->set_rules('CTT_STAFF_LOG', 'Catatan', 'trim|max_length[100]');

			$NO_URUT_FSTB_GANTI = $this->input->post('NO_URUT_FSTB_GANTI');
			$NO_URUT_FSTB_ASLI = $this->input->post('NO_URUT_FSTB_ASLI');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo validation_errors();
			
			} else {

				if($NO_URUT_FSTB_GANTI==$NO_URUT_FSTB_ASLI)
				{
					//get the form data
					$ID_FSTB = $this->input->post('ID_FSTB');
					$NO_URUT_FSTB_GANTI = $this->input->post('NO_URUT_FSTB_GANTI');
					$TANGGAL_DOKUMEN_FSTB = $this->input->post('TANGGAL_DOKUMEN_FSTB');
					$LOKASI_PENYERAHAN = $this->input->post('LOKASI_PENYERAHAN');
					$NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR');
					$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
					$NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
					$NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
					$TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
					$CTT_STAFF_LOG = $this->input->post('CTT_STAFF_LOG');
					
					$data = $this->FSTB_model->simpan_identitas_form(
						$ID_FSTB,
						$NO_URUT_FSTB_GANTI,
						$TANGGAL_DOKUMEN_FSTB,
						$LOKASI_PENYERAHAN, 
						$NOMOR_SURAT_JALAN_VENDOR, 
						$NAMA_PENGIRIM, 
						$NO_HP_PENGIRIM,
						$NAMA_PEGAWAI,
						$TANGGAL_BARANG_DATANG_HARI,
						$CTT_STAFF_LOG
					);
					echo json_encode($data);

					$KETERANGAN = "simpan_identitas_form: "
						. "; " .$ID_FSTB
						. "; " .$NO_URUT_FSTB_GANTI
						. "; " .$TANGGAL_DOKUMEN_FSTB
						. "; " .$LOKASI_PENYERAHAN
						. "; " .$NOMOR_SURAT_JALAN_VENDOR
						. "; " .$NAMA_PENGIRIM
						. "; " .$NO_HP_PENGIRIM
						. "; " .$NAMA_PEGAWAI
						. "; " .$TANGGAL_BARANG_DATANG_HARI
						. "; " .$CTT_STAFF_LOG;
					$ID_FSTB = $ID_FSTB;
					$this->user_log_fstb($ID_FSTB, $KETERANGAN);
				}

				else
				{
					if ($this->FSTB_model->cek_nomor_urut_fstb($NO_URUT_FSTB_GANTI) == 'DATA BELUM ADA') {

						//get the form data
						$ID_FSTB = $this->input->post('ID_FSTB');
						$NO_URUT_FSTB_GANTI = $this->input->post('NO_URUT_FSTB_GANTI');
						$TANGGAL_DOKUMEN_FSTB = $this->input->post('TANGGAL_DOKUMEN_FSTB');
						$LOKASI_PENYERAHAN = $this->input->post('LOKASI_PENYERAHAN');
						$NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR');
						$NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
						$NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
						$NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
						$TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
						$CTT_STAFF_LOG = $this->input->post('CTT_STAFF_LOG');
						
						$data = $this->FSTB_model->simpan_identitas_form(
							$ID_FSTB,
							$NO_URUT_FSTB_GANTI,
							$TANGGAL_DOKUMEN_FSTB,
							$LOKASI_PENYERAHAN, 
							$NOMOR_SURAT_JALAN_VENDOR, 
							$NAMA_PENGIRIM, 
							$NO_HP_PENGIRIM,
							$NAMA_PEGAWAI,
							$TANGGAL_BARANG_DATANG_HARI,
							$CTT_STAFF_LOG
						);
						echo json_encode($data);

						$KETERANGAN = "simpan_identitas_form: "
						. "; " .$ID_FSTB
						. "; " .$NO_URUT_FSTB_GANTI
						. "; " .$TANGGAL_DOKUMEN_FSTB
						. "; " .$LOKASI_PENYERAHAN
						. "; " .$NOMOR_SURAT_JALAN_VENDOR
						. "; " .$NAMA_PENGIRIM
						. "; " .$NO_HP_PENGIRIM
						. "; " .$NAMA_PEGAWAI
						. "; " .$TANGGAL_BARANG_DATANG_HARI
						. "; " .$CTT_STAFF_LOG;
						$ID_FSTB = $ID_FSTB;
						$this->user_log_fstb($ID_FSTB, $KETERANGAN);
					
					} else {
						echo 'Nomor Urut FSTB sudah terekam sebelumnya';
					}
				}
			}
		} else {
			$this->logout();
		}
	}

	function update_data() //092023
	{
		if ($this->ion_auth->logged_in()) {

			//set validation rules
			$this->form_validation->set_rules('JUMLAH_DITERIMA', 'Jumlah Yang Diterima', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_DITOLAK', 'Jumlah Yang Ditolak', 'trim|required');
			$this->form_validation->set_rules('JUMLAH_DITERIMA_SYARAT', 'Jumlah Yang Diterima Dengan Syarat', 'trim|required');


			
			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {

				//get the form data
				$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');
				$JUMLAH_DIMINTA = $this->input->post('JUMLAH_DIMINTA');
				$JUMLAH_DITERIMA = $this->input->post('JUMLAH_DITERIMA');
				$JUMLAH_DITOLAK = $this->input->post('JUMLAH_DITOLAK');
				$JUMLAH_DITERIMA_SYARAT = $this->input->post('JUMLAH_DITERIMA_SYARAT');
				$KETERANGAN_DITOLAK = $this->input->post('KETERANGAN_DITOLAK');
				$KETERANGAN_DITERIMA_SYARAT = $this->input->post('KETERANGAN_DITERIMA_SYARAT');

				$JUMLAH_DITERIMA_JUMLAH_DITOLAK = $JUMLAH_DITERIMA + $JUMLAH_DITOLAK;
				$JUMLAH_DITERIMA_JUMLAH_DITERIMA_SYARAT = $JUMLAH_DITERIMA + $JUMLAH_DITERIMA_SYARAT;
				$JUMLAH_DITOLAK_JUMLAH_DITERIMA_SYARAT = $JUMLAH_DITOLAK + $JUMLAH_DITERIMA_SYARAT;

				$JUMLAH_DITERIMA_JUMLAH_DITOLAK_JUMLAH_DITERIMA_SYARAT = $JUMLAH_DITERIMA + $JUMLAH_DITOLAK + $JUMLAH_DITERIMA_SYARAT;

				// if( $JUMLAH_DITOLAK > 0)
				// {
				// 	//set validation rules
				// 	$this->form_validation->set_rules('KETERANGAN_DITOLAK', 'Keterangan Ditolak', 'trim|required');					
				// 	//run validation check
				// 	if ($this->form_validation->run() == FALSE) {   //validation fails
				// 		echo json_encode(validation_errors());
				// 	}
				// }

				// if( $JUMLAH_DITERIMA_SYARAT > 0)
				// {
				// 	//set validation rules
				// 	$this->form_validation->set_rules('KETERANGAN_DITERIMA_SYARAT', 'Keterangan Diterima Dengan Syarat', 'trim|required');					
				// 	//run validation check
				// 	if ($this->form_validation->run() == FALSE) {   //validation fails
				// 		echo json_encode(validation_errors());
				// 	}
				// }

				
				if( $JUMLAH_DITERIMA_JUMLAH_DITOLAK_JUMLAH_DITERIMA_SYARAT > $JUMLAH_DIMINTA )
				{
					$PesanError = 'Jumlah diterima, ditolak dan diterima dengan syarat, melebihi jumlah dipesan';
					echo json_encode($PesanError);
				}

				else if( $JUMLAH_DITOLAK_JUMLAH_DITERIMA_SYARAT > $JUMLAH_DIMINTA )
				{
					$PesanError = 'Jumlah ditolak dan diterima dengan syarat, melebihi jumlah dipesan';
					echo json_encode($PesanError);
				}

				else if( $JUMLAH_DITOLAK_JUMLAH_DITERIMA_SYARAT > $JUMLAH_DIMINTA )
				{
					$PesanError = 'Jumlah ditolak dan diterima dengan syarat, melebihi jumlah dipesan';
					echo json_encode($PesanError);
				}

				else if( $JUMLAH_DITERIMA_JUMLAH_DITERIMA_SYARAT > $JUMLAH_DIMINTA )
				{
					$PesanError = 'Jumlah diterima dan diterima dengan syarat, melebihi jumlah dipesan';
					echo json_encode($PesanError);
				}

				else if( $JUMLAH_DITERIMA_JUMLAH_DITOLAK > $JUMLAH_DIMINTA )
				{
					$PesanError = 'Jumlah diterima dan ditolak, melebihi jumlah dipesan';
					echo json_encode($PesanError);
				}

				else if( $JUMLAH_DITERIMA > $JUMLAH_DIMINTA )
				{
					$PesanError = 'Jumlah diterima melebihi jumlah dipesan';
					echo json_encode($PesanError);
				}

				else if( $JUMLAH_DITOLAK > $JUMLAH_DIMINTA )
				{
					$PesanError = 'Jumlah ditolak melebihi jumlah dipesan';
					echo json_encode($PesanError);
				}

				else if( $JUMLAH_DITERIMA_SYARAT > $JUMLAH_DIMINTA )
				{
					$PesanError = 'Jumlah diterima dengan syarat melebihi jumlah dipesan';
					echo json_encode($PesanError);
				}

				else{
					$data_edit = $this->FSTB_form_model->get_data_by_ID_FSTB_FORM($ID_FSTB_FORM);
					$KETERANGAN = "update_data: " . json_encode($data_edit) . " ---- " . $JUMLAH_DITERIMA . ";" . $JUMLAH_DITOLAK . ";" . $JUMLAH_DITERIMA_SYARAT;

					$ID_FSTB_FORM = $ID_FSTB_FORM;
					$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

					$data = $this->FSTB_form_model->update_data($ID_FSTB_FORM, $JUMLAH_DITERIMA, $JUMLAH_DITOLAK, $JUMLAH_DITERIMA_SYARAT, $KETERANGAN_DITOLAK, $KETERANGAN_DITERIMA_SYARAT);
					echo json_encode($data);
				}

			}
		} else {
			$this->logout();
		}
	}

	// function update_progress()
	// {
	// 	if ($this->ion_auth->logged_in()) {
			
	// 		$ID_FSTB = $this->input->post('ID_FSTB');
	// 		$PROGRESS_FSTB = $this->input->post('PROGRESS_FSTB');

	// 		$data = $this->FSTB_form_model->update_progress_id_fstb(
	// 			$ID_FSTB, $PROGRESS_FSTB
	// 		);
	// 		echo json_encode($data);
			
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	function update_data_kirim_fstb()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) { //user_staff_procurement_kp


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB', 'FSTB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB = $this->input->post('ID_FSTB');

				$PROGRESS_FSTB = "Diproses oleh Kasie Procurement KP";
				$STATUS_FSTB = "Sedang diproses";

				$KETERANGAN = $PROGRESS_FSTB . " " . $STATUS_FSTB;

				$ID_FSTB = $ID_FSTB;
 				$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$data = $this->FSTB_form_model->update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) { //user_kasie_procurement_kp


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB', 'FSTB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB = $this->input->post('ID_FSTB');

				$PROGRESS_FSTB = "Diproses oleh Staff Logistik KP";
				$STATUS_FSTB = "Sedang diproses";

				$ID_FSTB = $ID_FSTB;
				
 				$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FSTB = date("d-m-Y", $d);

				$data = $this->FSTB_form_model->update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) { //user_manajer_procurement_kp


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB', 'FSTB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB = $this->input->post('ID_FSTB');

				$PROGRESS_FSTB = "Diproses oleh Staff Logistik KP";
				$STATUS_FSTB = "Sedang diproses";

				$ID_FSTB = $ID_FSTB;
				
 				$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FSTB = date("d-m-Y", $d);

				$data = $this->FSTB_form_model->update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) { //user_staff_procurement_sp


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB', 'FSTB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB = $this->input->post('ID_FSTB');

				$PROGRESS_FSTB = "Diproses oleh Supervisi Procurement SP";
				$STATUS_FSTB = "Sedang diproses";

				$ID_FSTB = $ID_FSTB;
				
 				$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FSTB = date("d-m-Y", $d);

				$data = $this->FSTB_form_model->update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) { //user_supervisi_procurement_sp


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB', 'FSTB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB = $this->input->post('ID_FSTB');

				$PROGRESS_FSTB = "Diproses oleh Staff Procurement SP";
				$STATUS_FSTB = "Sedang diproses";

				$ID_FSTB = $ID_FSTB;
				
 				$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FSTB = date("d-m-Y", $d);

				$data = $this->FSTB_form_model->update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) { //user_staff_umum_logistik_kp


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB', 'FSTB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB = $this->input->post('ID_FSTB');

				$PROGRESS_FSTB = "Diproses oleh Kasie Logistik KP";
				$STATUS_FSTB = "Sedang diproses";

				$ID_FSTB = $ID_FSTB;
				
 				$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FSTB = date("d-m-Y", $d);

				$data = $this->FSTB_form_model->update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) { //user_kasie_logistik_kp


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB', 'FSTB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB = $this->input->post('ID_FSTB');

				$PROGRESS_FSTB = "FSTB Disetujui";
				$STATUS_FSTB = "SELESAI";

				
 				$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FSTB = date("d-m-Y", $d);

				$data = $this->FSTB_form_model->update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) { //user_manajer_logistik_kp


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB', 'FSTB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB = $this->input->post('ID_FSTB');

				$PROGRESS_FSTB = "FSTB Disetujui";
				$STATUS_FSTB = "SELESAI";

				
 				$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FSTB = date("d-m-Y", $d);

				$data = $this->FSTB_form_model->update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) { //user_staff_umum_logistik_sp


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB', 'FSTB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB = $this->input->post('ID_FSTB');

				$PROGRESS_FSTB = "Diproses oleh Supervisi Logistik SP";
				$STATUS_FSTB = "Sedang diproses";

				$ID_FSTB = $ID_FSTB;
				
 				$this->user_log_fstb($ID_FSTB, $KETERANGAN);

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FSTB = date("d-m-Y", $d);

				$data = $this->FSTB_form_model->update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB);
				echo json_encode($data);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) { //user_supervisi_logistik_sp


			//set validation rules
			$this->form_validation->set_rules('ID_FSTB', 'FSTB ', 'trim|required');

			//run validation check
			if ($this->form_validation->run() == FALSE) {   //validation fails
				echo json_encode(validation_errors());
			} else {
				//get the form data
				$ID_FSTB = $this->input->post('ID_FSTB');

				$PROGRESS_FSTB = "FSTB Disetujui";
				$STATUS_FSTB = "SELESAI";

				$d = strtotime("today");
				$TANGGAL_PENGAJUAN_FSTB = date("d-m-Y", $d);

				$data = $this->FSTB_form_model->update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB);
				echo json_encode($data);
			}
		} else {
			$this->logout();
		}
	}

	// function update_data_coret()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	// function update_data_batal_coret()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Batal Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_batal_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Batal Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_batal_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Batal Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_batal_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Batal Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_batal_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Batal Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_batal_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Batal Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_batal_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {


	// 		//set validation rules
	// 		$this->form_validation->set_rules('ID_FSTB_FORM', 'ID_FSTB_FORM ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');

	// 			$KETERANGAN = "Batal Tolak Barang (User STAFF LOG): " . " ---- " . $ID_FSTB_FORM;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_batal_coret($ID_FSTB_FORM);
	// 			echo json_encode($data);
	// 		}
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	// function update_data_tanggal()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

	// 		$id = $this->input->post('id');
	// 		$field = $this->input->post('field');
	// 		$value = $this->input->post('value');

	// 		$KETERANGAN = "Update Tanggal Mulai Pemakaian (User STAFF LOG): " . " ---- " . $id . " ;" . $field . " ;" . $value;
	// 		$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 		$data = $this->FSTB_form_model->update_data_tanggal($id, $field, $value);
	// 		echo ($data);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

	// 		$id = $this->input->post('id');
	// 		$field = $this->input->post('field');
	// 		$value = $this->input->post('value');

	// 		$KETERANGAN = "Update Tanggal Mulai Pemakaian (User STAFF LOG): " . " ---- " . $id . " ;" . $field . " ;" . $value;
	// 		$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 		$data = $this->FSTB_form_model->update_data_tanggal($id, $field, $value);
	// 		echo ($data);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

	// 		$id = $this->input->post('id');
	// 		$field = $this->input->post('field');
	// 		$value = $this->input->post('value');

	// 		$KETERANGAN = "Update Tanggal Mulai Pemakaian (User STAFF LOG): " . " ---- " . $id . " ;" . $field . " ;" . $value;
	// 		$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 		$data = $this->FSTB_form_model->update_data_tanggal($id, $field, $value);
	// 		echo ($data);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

	// 		$id = $this->input->post('id');
	// 		$field = $this->input->post('field');
	// 		$value = $this->input->post('value');

	// 		$KETERANGAN = "Update Tanggal Mulai Pemakaian (User STAFF LOG): " . " ---- " . $id . " ;" . $field . " ;" . $value;
	// 		$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 		$data = $this->FSTB_form_model->update_data_tanggal($id, $field, $value);
	// 		echo ($data);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

	// 		$id = $this->input->post('id');
	// 		$field = $this->input->post('field');
	// 		$value = $this->input->post('value');

	// 		$KETERANGAN = "Update Tanggal Mulai Pemakaian (User STAFF LOG): " . " ---- " . $id . " ;" . $field . " ;" . $value;
	// 		$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 		$data = $this->FSTB_form_model->update_data_tanggal($id, $field, $value);
	// 		echo ($data);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

	// 		$id = $this->input->post('id');
	// 		$field = $this->input->post('field');
	// 		$value = $this->input->post('value');

	// 		$KETERANGAN = "Update Tanggal Mulai Pemakaian (User STAFF LOG): " . " ---- " . $id . " ;" . $field . " ;" . $value;
	// 		$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 		$data = $this->FSTB_form_model->update_data_tanggal($id, $field, $value);
	// 		echo ($data);
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

	// 		$id = $this->input->post('id');
	// 		$field = $this->input->post('field');
	// 		$value = $this->input->post('value');

	// 		$KETERANGAN = "Update Tanggal Mulai Pemakaian (User STAFF LOG): " . " ---- " . $id . " ;" . $field . " ;" . $value;
	// 		$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 		$data = $this->FSTB_form_model->update_data_tanggal($id, $field, $value);
	// 		echo ($data);
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

	function proses_upload_file()
	{

		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		$HASH_MD5_FSTB = $this->session->userdata('HASH_MD5_FSTB');

		//jika mereka sudah login
		if ($this->ion_auth->logged_in()) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "file_" . $HASH_MD5_FSTB . '_';
			$config['upload_path'] = './assets/upload_fstb_form_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_id_fstb = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
			$ID_FSTB = $query_id_fstb['ID_FSTB'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_fstb_form_file/' . $nama;
				$this->db->insert('fstb_form_file', array('ID_FSTB' => $ID_FSTB, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_FSTB' => $HASH_MD5_FSTB, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else {
			// alihkan mereka ke halaman fstb list
			redirect('FSTB', 'refresh');
		}
	}

	function get_data() //092023
	{

		if ($this->ion_auth->logged_in()) {
			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');
			$data = $this->FSTB_form_model->get_data_by_ID_FSTB_FORM($ID_FSTB_FORM);
			echo json_encode($data);

			$ID_FSTB_FORM = $ID_FSTB_FORM;
			$KETERANGAN = "Get Data FSTB Item Barang: " . json_encode($data);
			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);
		} else {
			$this->logout();
		}
	}

	// function update_data_barang_hasil_temuan()
	// {
	// 	if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('HASIL_INSPEKSI', 'Hasil Temuan Item Barang/Jasa ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');
	// 			$HASIL_INSPEKSI = $this->input->post('HASIL_INSPEKSI');

	// 			$data_edit = $this->FSTB_form_model->get_hasil_inspeksi_by_id_fstb_form($ID_FSTB_FORM);
	// 			$KETERANGAN = "Ubah Data HASIL TEMUAN FSTB Form (User STAFF): " . json_encode($data_edit) . " ---- " . $ID_FSTB_FORM . ";" . $HASIL_INSPEKSI;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_hasil_inspeksi($ID_FSTB_FORM, $HASIL_INSPEKSI);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('HASIL_INSPEKSI', 'Hasil Temuan Item Barang/Jasa ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');
	// 			$HASIL_INSPEKSI = $this->input->post('HASIL_INSPEKSI');

	// 			$data_edit = $this->FSTB_form_model->get_hasil_inspeksi_by_id_fstb_form($ID_FSTB_FORM);
	// 			$KETERANGAN = "Ubah Data HASIL TEMUAN FSTB Form (User STAFF): " . json_encode($data_edit) . " ---- " . $ID_FSTB_FORM . ";" . $HASIL_INSPEKSI;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_hasil_inspeksi($ID_FSTB_FORM, $HASIL_INSPEKSI);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('HASIL_INSPEKSI', 'Hasil Temuan Item Barang/Jasa ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');
	// 			$HASIL_INSPEKSI = $this->input->post('HASIL_INSPEKSI');

	// 			$data_edit = $this->FSTB_form_model->get_hasil_inspeksi_by_id_fstb_form($ID_FSTB_FORM);
	// 			$KETERANGAN = "Ubah Data HASIL TEMUAN FSTB Form (User STAFF): " . json_encode($data_edit) . " ---- " . $ID_FSTB_FORM . ";" . $HASIL_INSPEKSI;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_hasil_inspeksi($ID_FSTB_FORM, $HASIL_INSPEKSI);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('HASIL_INSPEKSI', 'Hasil Temuan Item Barang/Jasa ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');
	// 			$HASIL_INSPEKSI = $this->input->post('HASIL_INSPEKSI');

	// 			$data_edit = $this->FSTB_form_model->get_hasil_inspeksi_by_id_fstb_form($ID_FSTB_FORM);
	// 			$KETERANGAN = "Ubah Data HASIL TEMUAN FSTB Form (User STAFF): " . json_encode($data_edit) . " ---- " . $ID_FSTB_FORM . ";" . $HASIL_INSPEKSI;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_hasil_inspeksi($ID_FSTB_FORM, $HASIL_INSPEKSI);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('HASIL_INSPEKSI', 'Hasil Temuan Item Barang/Jasa ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');
	// 			$HASIL_INSPEKSI = $this->input->post('HASIL_INSPEKSI');

	// 			$data_edit = $this->FSTB_form_model->get_hasil_inspeksi_by_id_fstb_form($ID_FSTB_FORM);
	// 			$KETERANGAN = "Ubah Data HASIL TEMUAN FSTB Form (User STAFF): " . json_encode($data_edit) . " ---- " . $ID_FSTB_FORM . ";" . $HASIL_INSPEKSI;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_hasil_inspeksi($ID_FSTB_FORM, $HASIL_INSPEKSI);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('HASIL_INSPEKSI', 'Hasil Temuan Item Barang/Jasa ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');
	// 			$HASIL_INSPEKSI = $this->input->post('HASIL_INSPEKSI');

	// 			$data_edit = $this->FSTB_form_model->get_hasil_inspeksi_by_id_fstb_form($ID_FSTB_FORM);
	// 			$KETERANGAN = "Ubah Data HASIL TEMUAN FSTB Form (User STAFF): " . json_encode($data_edit) . " ---- " . $ID_FSTB_FORM . ";" . $HASIL_INSPEKSI;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_hasil_inspeksi($ID_FSTB_FORM, $HASIL_INSPEKSI);
	// 			echo json_encode($data);
	// 		}
	// 	} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

	// 		//set validation rules
	// 		$this->form_validation->set_rules('HASIL_INSPEKSI', 'Hasil Temuan Item Barang/Jasa ', 'trim|required');

	// 		//run validation check
	// 		if ($this->form_validation->run() == FALSE) {   //validation fails
	// 			echo json_encode(validation_errors());
	// 		} else {
	// 			//get the form data
	// 			$ID_FSTB_FORM = $this->input->post('ID_FSTB_FORM');
	// 			$HASIL_INSPEKSI = $this->input->post('HASIL_INSPEKSI');

	// 			$data_edit = $this->FSTB_form_model->get_hasil_inspeksi_by_id_fstb_form($ID_FSTB_FORM);
	// 			$KETERANGAN = "Ubah Data HASIL TEMUAN FSTB Form (User STAFF): " . json_encode($data_edit) . " ---- " . $ID_FSTB_FORM . ";" . $HASIL_INSPEKSI;
	// 			$this->user_log_fstb_form($ID_FSTB_FORM, $KETERANGAN);

	// 			$data = $this->FSTB_form_model->update_data_hasil_inspeksi($ID_FSTB_FORM, $HASIL_INSPEKSI);
	// 			echo json_encode($data);
	// 		}
	// 	} else {
	// 		$this->logout();
	// 	}
	// }

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

		$this->data['title'] = 'SIPESUT | Form FSTB';


		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO") {
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		} else {
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		$HASH_MD5_FSTB = $this->uri->segment(3);
		if ($this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB) == 'TIDAK ADA DATA FSTB') {
			redirect('FSTB', 'refresh');
		}


		if ($this->ion_auth->logged_in()) {

			if ($this->ion_auth->is_admin()) {

				$this->data['HASH_MD5_FSTB'] = $HASH_MD5_FSTB;
				$sess_data['HASH_MD5_FSTB'] = $this->data['HASH_MD5_FSTB'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_FSTB);

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				$KETERANGAN = "view: ";
				$ID_FSTB = $ID_FSTB;
                $this->user_log_fstb($ID_FSTB, $KETERANGAN);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$query_file_HASH_MD5_FSTB = $this->FSTB_Form_File_Model->file_list_by_HASH_MD5_FSTB($HASH_MD5_FSTB);

				if ($query_file_HASH_MD5_FSTB->num_rows() > 0) {

					$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_HASH_MD5_FSTB_result($HASH_MD5_FSTB);

					$hasil = $query_file_HASH_MD5_FSTB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
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

				$this->load->view('wasa/user_admin/head_normal', $this->data);
				$this->load->view('wasa/user_admin/user_menu');
				$this->load->view('wasa/user_admin/left_menu');
				$this->load->view('wasa/user_admin/header_menu');
				$this->load->view('wasa/user_admin/content_fstb_form');
				$this->load->view('wasa/user_admin/footer');
			} else if ($this->ion_auth->in_group(5)) {

				$this->data['HASH_MD5_FSTB'] = $HASH_MD5_FSTB;
				$sess_data['HASH_MD5_FSTB'] = $this->data['HASH_MD5_FSTB'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_FSTB);

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				$KETERANGAN = "view: ";
				$ID_FSTB = $ID_FSTB;
                $this->user_log_fstb($ID_FSTB, $KETERANGAN);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$query_file_HASH_MD5_FSTB = $this->FSTB_Form_File_Model->file_list_by_HASH_MD5_FSTB($HASH_MD5_FSTB);

				if ($query_file_HASH_MD5_FSTB->num_rows() > 0) {

					$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_HASH_MD5_FSTB_result($HASH_MD5_FSTB);

					$hasil = $query_file_HASH_MD5_FSTB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
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
				$this->load->view('wasa/user_staff_procurement_kp/content_fstb_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(6)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_fstb_form');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(7)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_fstb_form');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(8)) {

				$this->data['HASH_MD5_FSTB'] = $HASH_MD5_FSTB;
				$sess_data['HASH_MD5_FSTB'] = $this->data['HASH_MD5_FSTB'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_FSTB);

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				$KETERANGAN = "view: ";
				$ID_FSTB = $ID_FSTB;
                $this->user_log_fstb($ID_FSTB, $KETERANGAN);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$query_file_HASH_MD5_FSTB = $this->FSTB_Form_File_Model->file_list_by_HASH_MD5_FSTB($HASH_MD5_FSTB);

				if ($query_file_HASH_MD5_FSTB->num_rows() > 0) {

					$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_HASH_MD5_FSTB_result($HASH_MD5_FSTB);

					$hasil = $query_file_HASH_MD5_FSTB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
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

				$this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_procurement_sp/user_menu');
				$this->load->view('wasa/user_staff_procurement_sp/left_menu');
				$this->load->view('wasa/user_staff_procurement_sp/header_menu');
				$this->load->view('wasa/user_staff_procurement_sp/content_fstb_form');
				$this->load->view('wasa/user_staff_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(9)) {
				
				$this->data['HASH_MD5_FSTB'] = $HASH_MD5_FSTB;
				$sess_data['HASH_MD5_FSTB'] = $this->data['HASH_MD5_FSTB'];
				$this->session->set_userdata($sess_data);
				$this->cetak_pdf($HASH_MD5_FSTB);

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				$KETERANGAN = "view: ";
				$ID_FSTB = $ID_FSTB;
                $this->user_log_fstb($ID_FSTB, $KETERANGAN);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$query_file_HASH_MD5_FSTB = $this->FSTB_Form_File_Model->file_list_by_HASH_MD5_FSTB($HASH_MD5_FSTB);

				if ($query_file_HASH_MD5_FSTB->num_rows() > 0) {

					$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_HASH_MD5_FSTB_result($HASH_MD5_FSTB);

					$hasil = $query_file_HASH_MD5_FSTB->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
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

				$this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
				$this->load->view('wasa/user_supervisi_procurement_sp/content_fstb_form');
				$this->load->view('wasa/user_supervisi_procurement_sp/footer');
			} else if ($this->ion_auth->in_group(10)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_kp/content_fstb_form');
				$this->load->view('wasa/user_staff_umum_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(11)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_logistik_kp/user_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/left_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/header_menu');
				$this->load->view('wasa/user_kasie_logistik_kp/content_fstb_form');
				$this->load->view('wasa/user_kasie_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(12)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_logistik_kp/user_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/left_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/header_menu');
				$this->load->view('wasa/user_manajer_logistik_kp/content_fstb_form');
				$this->load->view('wasa/user_manajer_logistik_kp/footer');
			} else if ($this->ion_auth->in_group(13)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
				$this->load->view('wasa/user_staff_umum_logistik_sp/content_fstb_form');
				$this->load->view('wasa/user_staff_umum_logistik_sp/footer');
			} else if ($this->ion_auth->in_group(15)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB

				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
					$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
				endforeach;

				$this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
				$this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
				$this->load->view('wasa/user_supervisi_logistik_sp/content_fstb_form');
				$this->load->view('wasa/user_supervisi_logistik_sp/footer');
			} else if ($this->ion_auth->in_group(18)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB


				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
				endforeach;

				$this->load->view('wasa/user_manajer_hrd_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_hrd_kp/user_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/left_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/header_menu');
				$this->load->view('wasa/user_manajer_hrd_kp/content_fstb_form');
				$this->load->view('wasa/user_manajer_hrd_kp/footer');
			} else if ($this->ion_auth->in_group(21)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB


				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
				endforeach;

				$this->load->view('wasa/user_manajer_keuangan_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_keuangan_kp/user_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/left_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/header_menu');
				$this->load->view('wasa/user_manajer_keuangan_kp/content_fstb_form');
				$this->load->view('wasa/user_manajer_keuangan_kp/footer');
			} else if ($this->ion_auth->in_group(24)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB


				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
				endforeach;

				$this->load->view('wasa/user_manajer_konstruksi_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_konstruksi_kp/user_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/left_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/header_menu');
				$this->load->view('wasa/user_manajer_konstruksi_kp/content_fstb_form');
				$this->load->view('wasa/user_manajer_konstruksi_kp/footer');
			} else if ($this->ion_auth->in_group(27)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB


				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
				endforeach;

				$this->load->view('wasa/user_manajer_sdm_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_sdm_kp/user_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/left_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/header_menu');
				$this->load->view('wasa/user_manajer_sdm_kp/content_fstb_form');
				$this->load->view('wasa/user_manajer_sdm_kp/footer');
			} else if ($this->ion_auth->in_group(30)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB


				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
				endforeach;

				$this->load->view('wasa/user_manajer_qaqc_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_qaqc_kp/user_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/left_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/header_menu');
				$this->load->view('wasa/user_manajer_qaqc_kp/content_fstb_form');
				$this->load->view('wasa/user_manajer_qaqc_kp/footer');
			} else if ($this->ion_auth->in_group(33)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB


				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
				endforeach;

				$this->load->view('wasa/user_manajer_ep_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_ep_kp/user_menu');
				$this->load->view('wasa/user_manajer_ep_kp/left_menu');
				$this->load->view('wasa/user_manajer_ep_kp/header_menu');
				$this->load->view('wasa/user_manajer_ep_kp/content_fstb_form');
				$this->load->view('wasa/user_manajer_ep_kp/footer');
			} else if ($this->ion_auth->in_group(41)) {
				$this->cetak_pdf($HASH_MD5_FSTB); //form FSTB
				$this->cetak_pdf2($HASH_MD5_FSTB); //form FIB


				$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
				$ID_FSTB = $hasil['ID_FSTB'];
				$this->data['ID_FSTB'] = $ID_FSTB;
				$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);

				foreach ($this->data['FSTB']->result() as $FSTB) :
					$this->data['FILE_NAME_TEMP'] = $FSTB->FILE_NAME_TEMP;
					$this->data['FILE_NAME_TEMP_FIB'] = $FSTB->FILE_NAME_TEMP_FIB;
					$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
					$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
					$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
				endforeach;

				$this->load->view('wasa/user_manajer_hsse_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_hsse_kp/user_menu');
				$this->load->view('wasa/user_manajer_hsse_kp/left_menu');
				$this->load->view('wasa/user_manajer_hsse_kp/header_menu');
				$this->load->view('wasa/user_manajer_hsse_kp/content_fstb_form');
				$this->load->view('wasa/user_manajer_hsse_kp/footer');
			} else {
				redirect('FSTB', 'refresh');
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

	public function cetak_pdf($HASH_MD5_FSTB)
	{
		$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
		$ID_FSTB = $hasil['ID_FSTB'];

		$KETERANGAN = "Cetak PDF";
		$ID_FSTB = $ID_FSTB;
		$this->user_log_fstb($ID_FSTB, $KETERANGAN);

		$this->data['ID_FSTB'] = $ID_FSTB;
		$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);
		$this->data['CATATAN_FSTB'] = $this->FSTB_form_model->get_data_catatan_fstb_by_id_fstb($ID_FSTB);

		$this->data['konten_FSTB_form'] = $this->FSTB_form_model->fstb_form_list_by_id_fstb($ID_FSTB);

		$this->data['USER_PENGAJU'] = $this->FSTB_form_model->ID_JABATAN_BY_ID_FSTB($ID_FSTB);

		foreach ($this->data['FSTB']->result() as $FSTB) :
			$FILE_NAME_TEMP = $FSTB->FILE_NAME_TEMP;
			$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
			$this->data['NO_URUT_FSTB'] = $FSTB->NO_URUT_FSTB;
			$this->data['NO_URUT_SPPB'] = $FSTB->NO_URUT_SPPB;
			$this->data['NO_URUT_SPP'] = $FSTB->NO_URUT_SPP;
			$this->data['TANGGAL_DOKUMEN_FSTB_INDO'] = $this->tanggal_indo_full($FSTB->TANGGAL_DOKUMEN_FSTB_INDO, false);
			$this->data['TANGGAL_BARANG_DATANG_HARI_INDO'] = $this->tanggal_indo_full($FSTB->TANGGAL_BARANG_DATANG_HARI_INDO, false);
			$this->data['NO_SURAT_JALAN'] = $FSTB->NO_SURAT_JALAN;
			$this->data['NO_URUT_PO'] = $FSTB->NO_URUT_PO;
			$this->data['NAMA_VENDOR'] = $FSTB->NAMA_VENDOR;
			$this->data['NOMOR_SURAT_JALAN_VENDOR'] = $FSTB->NOMOR_SURAT_JALAN_VENDOR;
			$this->data['LOKASI_PENYERAHAN'] = $FSTB->LOKASI_PENYERAHAN;
			$this->data['SUMBER_PENERIMAAN'] = $FSTB->SUMBER_PENERIMAAN;
		endforeach;

		$this->load->library('ciqrcode'); //pemanggilan library QR CODE

		$config['cacheable'] = true; //boolean, the default is true
		$config['cachedir'] = './assets/QR_FSTB/cachedir/'; //string, the default is application/cache/
		$config['errorlog'] = './assets/QR_FSTB/errorlog/'; //string, the default is application/logs/
		$config['imagedir'] = './assets/QR_FSTB/'; //direktori penyimpanan qr code
		$config['quality'] = true; //boolean, the default is true
		$config['level'] = 'L'; //boolean, the default is true
		$config['size'] = '1024'; //interger, the default is 1024
		$config['black'] = array(224, 255, 255); // array, default is array(255,255,255)
		$config['white'] = array(70, 130, 180); // array, default is array(0,0,0)
		$this->ciqrcode->initialize($config);

		$image_name = $HASH_MD5_FSTB . '.jpg'; //buat name dari qr code sesuai dengan nim
		$this->data['image_name'] = $image_name;

		$params['data'] = base_url('index.php/Otentikasi_dokumen/FSTB/') . $HASH_MD5_FSTB; //data yang akan di jadikan QR CODE
		$params['level'] = 'H'; //H=High
		$params['size'] = 10;
		$params['savename'] = FCPATH . $config['imagedir'] . $image_name; //simpan image QR CODE ke folder assets/images/
		$this->ciqrcode->generate($params); // fungsi untuk generate QR CODE

		$this->data['GAMBAR_QR'] = 'C:/xampp/htdocs/project_eam/assets/QR_FSTB/' . $HASH_MD5_FSTB . ".jpg";

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Form Serah Terima Barang';

		// filename dari pdf ketika didownload
		$file_pdf = 'fstb_' . $HASH_MD5_FSTB;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "potrait";

		$html = $this->load->view('wasa/pdf/fstb_pdf', $this->data, true);

		// run dompdf
		$x          = 500;
		$y          = 800;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 7;

		$file_path = "assets/FSTB/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	public function cetak_pdf2($HASH_MD5_FSTB)
	{

		$hasil = $this->FSTB_model->get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
		$ID_FSTB = $hasil['ID_FSTB'];
		$this->data['ID_FSTB'] = $ID_FSTB;
		$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);
		$this->data['CATATAN_FSTB'] = $this->FSTB_form_model->get_data_catatan_fstb_by_id_fstb($ID_FSTB);

		$this->data['konten_FSTB_form'] = $this->FSTB_form_model->fstb_form_list_by_id_fstb($ID_FSTB);
		$this->data['hasil_inspeksi'] = $this->FSTB_form_model->hasil_inspeksi_by_id_fstb($ID_FSTB);

		$this->data['USER_PENGAJU'] = $this->FSTB_form_model->ID_JABATAN_BY_ID_FSTB($ID_FSTB);

		foreach ($this->data['FSTB']->result() as $FSTB) :
			$FILE_NAME_TEMP_FIB = $FSTB->FILE_NAME_TEMP_FIB;
			$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
			$this->data['NO_URUT_FIB'] = $FSTB->NO_URUT_FIB;
			$this->data['TANGGAL_DOKUMEN_FSTB'] = $FSTB->TANGGAL_DOKUMEN_FSTB;
			$this->data['TANGGAL_BARANG_DATANG_HARI'] = $FSTB->TANGGAL_BARANG_DATANG_HARI;
			$this->data['NO_SURAT_JALAN'] = $FSTB->NO_SURAT_JALAN;
			$this->data['NO_URUT_PO'] = $FSTB->NO_URUT_PO;
			$this->data['NAMA_VENDOR'] = $FSTB->NAMA_VENDOR;
			$this->data['NOMOR_SURAT_JALAN_VENDOR'] = $FSTB->NOMOR_SURAT_JALAN_VENDOR;
			$this->data['SUMBER_PENERIMAAN'] = $FSTB->SUMBER_PENERIMAAN;
		endforeach;

		// panggil library yang kita buat sebelumnya yang bernama pdfgenerator
		$this->load->library('pdfgenerator');

		// title dari pdf
		$this->data['title_pdf'] = 'Form Inspeksi Barang';

		// filename dari pdf ketika didownload
		$file_pdf = 'fib_' . $HASH_MD5_FSTB;
		// setting paper
		$paper = 'A4';
		//orientasi paper potrait / landscape
		$orientation = "potrait";

		$html = $this->load->view('wasa/pdf/fib_pdf', $this->data, true);

		// run dompdf
		$x          = 500;
		$y          = 800;
		$text       = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
		$size       = 7;

		$file_path = "assets/FIB/";
		$this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation, $x, $y, $text, $size, $file_path);
	}

	public function get_fstb_file()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$ID_FSTB_FORM = $this->input->get('id');
			// $data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['ID_FSTB_FORM'] = $ID_FSTB_FORM;
			$sess_data['ID_FSTB_FORM'] = $this->data['ID_FSTB_FORM'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel fstb_form_file
			$query_file_FSTB_ID_FSTB = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM($ID_FSTB_FORM);

			$KETERANGAN2 = "Melihat File Gambar FSTB: " . json_encode($query_file_FSTB_ID_FSTB);
			$this->user_log_fstb_form($KETERANGAN2);


			if ($query_file_FSTB_ID_FSTB->num_rows() > 0) {

				$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM_result($ID_FSTB_FORM);

				$hasil = $query_file_FSTB_ID_FSTB->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);

				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$ID_FSTB_FORM = $this->input->get('id');
			// $data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['ID_FSTB_FORM'] = $ID_FSTB_FORM;
			$sess_data['ID_FSTB_FORM'] = $this->data['ID_FSTB_FORM'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel fstb_form_file
			$query_file_FSTB_ID_FSTB = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM($ID_FSTB_FORM);

			$KETERANGAN2 = "Melihat File Gambar FSTB: " . json_encode($query_file_FSTB_ID_FSTB);
			$this->user_log_fstb_form($KETERANGAN2);


			if ($query_file_FSTB_ID_FSTB->num_rows() > 0) {

				$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM_result($ID_FSTB_FORM);

				$hasil = $query_file_FSTB_ID_FSTB->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);

				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$ID_FSTB_FORM = $this->input->get('id');
			// $data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['ID_FSTB_FORM'] = $ID_FSTB_FORM;
			$sess_data['ID_FSTB_FORM'] = $this->data['ID_FSTB_FORM'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel fstb_form_file
			$query_file_FSTB_ID_FSTB = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM($ID_FSTB_FORM);

			$KETERANGAN2 = "Melihat File Gambar FSTB: " . json_encode($query_file_FSTB_ID_FSTB);
			$this->user_log_fstb_form($KETERANGAN2);


			if ($query_file_FSTB_ID_FSTB->num_rows() > 0) {

				$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM_result($ID_FSTB_FORM);

				$hasil = $query_file_FSTB_ID_FSTB->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);

				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			$ID_FSTB_FORM = $this->input->get('id');
			// $data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['ID_FSTB_FORM'] = $ID_FSTB_FORM;
			$sess_data['ID_FSTB_FORM'] = $this->data['ID_FSTB_FORM'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel fstb_form_file
			$query_file_FSTB_ID_FSTB = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM($ID_FSTB_FORM);

			$KETERANGAN2 = "Melihat File Gambar FSTB: " . json_encode($query_file_FSTB_ID_FSTB);
			$this->user_log_fstb_form($KETERANGAN2);


			if ($query_file_FSTB_ID_FSTB->num_rows() > 0) {

				$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM_result($ID_FSTB_FORM);

				$hasil = $query_file_FSTB_ID_FSTB->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);

				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			$ID_FSTB_FORM = $this->input->get('id');
			// $data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['ID_FSTB_FORM'] = $ID_FSTB_FORM;
			$sess_data['ID_FSTB_FORM'] = $this->data['ID_FSTB_FORM'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel fstb_form_file
			$query_file_FSTB_ID_FSTB = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM($ID_FSTB_FORM);

			$KETERANGAN2 = "Melihat File Gambar FSTB: " . json_encode($query_file_FSTB_ID_FSTB);
			$this->user_log_fstb_form($KETERANGAN2);


			if ($query_file_FSTB_ID_FSTB->num_rows() > 0) {

				$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM_result($ID_FSTB_FORM);

				$hasil = $query_file_FSTB_ID_FSTB->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);

				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
			$ID_FSTB_FORM = $this->input->get('id');
			// $data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['ID_FSTB_FORM'] = $ID_FSTB_FORM;
			$sess_data['ID_FSTB_FORM'] = $this->data['ID_FSTB_FORM'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel fstb_form_file
			$query_file_FSTB_ID_FSTB = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM($ID_FSTB_FORM);

			$KETERANGAN2 = "Melihat File Gambar FSTB: " . json_encode($query_file_FSTB_ID_FSTB);
			$this->user_log_fstb_form($KETERANGAN2);


			if ($query_file_FSTB_ID_FSTB->num_rows() > 0) {

				$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM_result($ID_FSTB_FORM);

				$hasil = $query_file_FSTB_ID_FSTB->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);

				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
			$ID_FSTB_FORM = $this->input->get('id');
			// $data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['ID_FSTB_FORM'] = $ID_FSTB_FORM;
			$sess_data['ID_FSTB_FORM'] = $this->data['ID_FSTB_FORM'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel fstb_form_file
			$query_file_FSTB_ID_FSTB = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM($ID_FSTB_FORM);

			$KETERANGAN2 = "Melihat File Gambar FSTB: " . json_encode($query_file_FSTB_ID_FSTB);
			$this->user_log_fstb_form($KETERANGAN2);


			if ($query_file_FSTB_ID_FSTB->num_rows() > 0) {

				$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM_result($ID_FSTB_FORM);

				$hasil = $query_file_FSTB_ID_FSTB->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);

				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
			$ID_FSTB_FORM = $this->input->get('id');
			// $data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['ID_FSTB_FORM'] = $ID_FSTB_FORM;
			$sess_data['ID_FSTB_FORM'] = $this->data['ID_FSTB_FORM'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel fstb_form_file
			$query_file_FSTB_ID_FSTB = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM($ID_FSTB_FORM);

			$KETERANGAN2 = "Melihat File Gambar FSTB: " . json_encode($query_file_FSTB_ID_FSTB);
			$this->user_log_fstb_form($KETERANGAN2);


			if ($query_file_FSTB_ID_FSTB->num_rows() > 0) {

				$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM_result($ID_FSTB_FORM);

				$hasil = $query_file_FSTB_ID_FSTB->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);

				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			$ID_FSTB_FORM = $this->input->get('id');
			// $data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['ID_FSTB_FORM'] = $ID_FSTB_FORM;
			$sess_data['ID_FSTB_FORM'] = $this->data['ID_FSTB_FORM'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel fstb_form_file
			$query_file_FSTB_ID_FSTB = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM($ID_FSTB_FORM);

			$KETERANGAN2 = "Melihat File Gambar FSTB: " . json_encode($query_file_FSTB_ID_FSTB);
			$this->user_log_fstb_form($KETERANGAN2);


			if ($query_file_FSTB_ID_FSTB->num_rows() > 0) {

				$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM_result($ID_FSTB_FORM);

				$hasil = $query_file_FSTB_ID_FSTB->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);

				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}

		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
			$ID_FSTB_FORM = $this->input->get('id');
			// $data = $this->Vendor_model->get_data_by_id_vendor($ID_VENDOR);
			// echo json_encode($data);

			$this->data['ID_FSTB_FORM'] = $ID_FSTB_FORM;
			$sess_data['ID_FSTB_FORM'] = $this->data['ID_FSTB_FORM'];
			$this->session->set_userdata($sess_data);

			//Kueri data di tabel fstb_form_file
			$query_file_FSTB_ID_FSTB = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM($ID_FSTB_FORM);

			$KETERANGAN2 = "Melihat File Gambar FSTB: " . json_encode($query_file_FSTB_ID_FSTB);
			$this->user_log_fstb_form($KETERANGAN2);


			if ($query_file_FSTB_ID_FSTB->num_rows() > 0) {

				$this->data['dokumen'] = $this->FSTB_Form_File_Model->file_list_by_ID_FSTB_FORM_result($ID_FSTB_FORM);

				$hasil = $query_file_FSTB_ID_FSTB->row();
				$DOK_FILE = $hasil->DOK_FILE;
				$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
				$JENIS_FILE = $hasil->JENIS_FILE;

				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					$this->data['DOK_FILE'] = $DOK_FILE;
					$this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
					$this->data['JENIS_FILE'] = $JENIS_FILE;
					$this->data['FILE'] = "ADA";
					echo json_encode($this->data);

				}
			} else {
				$this->data['FILE'] = "TIDAK ADA";
				echo json_encode($this->data);
			}

		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

	//Hapus file by button
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
		if ($this->ion_auth->logged_in()) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->FSTB_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_fstb_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->FSTB_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_FSTB = $this->session->userdata('HASH_MD5_FSTB');
				redirect('/fstb_form/view/' . $HASH_MD5_FSTB, 'refresh');
			} else {
				$HASH_MD5_FSTB = $this->session->userdata('HASH_MD5_FSTB');
				redirect('/fstb_form/view/' . $HASH_MD5_FSTB, 'refresh');
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('FSTB', 'refresh');
		}
	}
}
