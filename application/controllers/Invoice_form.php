<?php defined('BASEPATH') or exit('No direct script access allowed');

class Invoice_form extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Form Invoice';

		$this->load->model('PO_model');
		$this->load->model('PO_form_model');
		$this->load->model('Vendor_model');
		$this->load->model('Barang_master_model');
		$this->load->model('SPPB_form_model');
		$this->load->model('SPPB_model');
		$this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
		$this->load->model('RASD_form_model');
		$this->load->model('Foto_model');
		$this->load->model('Manajemen_user_model');
		$this->load->model('Organisasi_model');
		$this->load->model('SPP_model');
		$this->load->model('PO_Form_File_Model');
		$this->load->model('Term_Of_Payment_model');
		$this->load->model('Proyek_model');
		$this->load->model('Invoice_model');
		$this->load->model('Vendor_Invoice_Form_File_Model');
		date_default_timezone_set('Asia/Jakarta');
		$this->data['left_menu'] = "Invoice_aktif";
	}

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$user = $this->ion_auth->user()->row();
		$KETERANGAN = "Paksa Logout Ketika Akses SPPB";
		$WAKTU = date('Y-m-d H:i:s');
		$this->PO_form_model->user_log_po_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

		$this->ion_auth->logout();

		// set the flash data error message if there is one
		$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
	}

	public function user_log($KETERANGAN)
	{

		$user = $this->ion_auth->user()->row();
		$WAKTU = date('Y-m-d H:i:s');
		$this->PO_form_model->user_log_po_form($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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
		$this->data['USER_ID'] = $user->id;
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$this->data['ID_VENDOR'] = $user->ID_VENDOR;
		$data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
		$this->data['role_user'] = $data_role_user['description'];
		$this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK'];
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['username'] = $user->username;
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

		$sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
		$sess_data['USER_ID'] = $this->data['USER_ID'];
		$this->session->set_userdata($sess_data);

		$HASH_MD5_VENDOR_INVOICE = $this->uri->segment(3);
		if ($this->Invoice_model->get_data_po_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE) == 'TIDAK ADA DATA') {
			redirect('Invoice', 'refresh');
		}

		if ($this->ion_auth->logged_in()) {

			//fungsi ini untuk mengirim data ke dropdown
			$HASH_MD5_VENDOR_INVOICE = $this->uri->segment(3);

			if ($this->ion_auth->in_group(5)) {
				$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;

				$hasil = $this->data['PO'] = $this->Invoice_model->po_list_invoice_by_id_vendor($this->data['ID_VENDOR']);
				foreach ($hasil as $PO) :
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['TANGGAL_DOKUMEN_PO'] = $PO->TANGGAL_DOKUMEN_PO;
				endforeach;

				$this->data['HASH_MD5_VENDOR_INVOICE'] = $HASH_MD5_VENDOR_INVOICE;
				$sess_data['HASH_MD5_VENDOR_INVOICE'] = $this->data['HASH_MD5_VENDOR_INVOICE'];
				$this->session->set_userdata($sess_data);
				// $this->cetak_pdf($HASH_MD5_PO);

				$hasil = $this->Invoice_model->get_data_po_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);
				$HASH_MD5_VENDOR_INVOICE = $hasil['HASH_MD5_VENDOR_INVOICE'];
				$this->data['HASH_MD5_VENDOR_INVOICE'] = $HASH_MD5_VENDOR_INVOICE;

				$query_file_HASH_MD5_VENDOR_INVOICE = $this->Vendor_Invoice_Form_File_Model->file_list_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);

				if ($query_file_HASH_MD5_VENDOR_INVOICE->num_rows() > 0) {

					$this->data['dokumen'] = $this->Vendor_Invoice_Form_File_Model->file_list_by_HASH_MD5_VENDOR_INVOICE_result($HASH_MD5_VENDOR_INVOICE);

					$hasil = $query_file_HASH_MD5_VENDOR_INVOICE->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_vendor_invoice_file/' . $DOK_FILE)) {
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
				$this->load->view('wasa/user_staff_procurement_kp/content_invoice_form');
				$this->load->view('wasa/user_staff_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(6)) {
				$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;

				$hasil = $this->data['PO'] = $this->Invoice_model->po_list_invoice_by_id_vendor($this->data['ID_VENDOR']);
				foreach ($hasil as $PO) :
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['TANGGAL_DOKUMEN_PO'] = $PO->TANGGAL_DOKUMEN_PO;
				endforeach;

				$this->data['HASH_MD5_VENDOR_INVOICE'] = $HASH_MD5_VENDOR_INVOICE;
				$sess_data['HASH_MD5_VENDOR_INVOICE'] = $this->data['HASH_MD5_VENDOR_INVOICE'];
				$this->session->set_userdata($sess_data);
				// $this->cetak_pdf($HASH_MD5_PO);

				$hasil = $this->Invoice_model->get_data_po_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);
				$HASH_MD5_VENDOR_INVOICE = $hasil['HASH_MD5_VENDOR_INVOICE'];
				$this->data['HASH_MD5_VENDOR_INVOICE'] = $HASH_MD5_VENDOR_INVOICE;

				$query_file_HASH_MD5_VENDOR_INVOICE = $this->Vendor_Invoice_Form_File_Model->file_list_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);

				if ($query_file_HASH_MD5_VENDOR_INVOICE->num_rows() > 0) {

					$this->data['dokumen'] = $this->Vendor_Invoice_Form_File_Model->file_list_by_HASH_MD5_VENDOR_INVOICE_result($HASH_MD5_VENDOR_INVOICE);

					$hasil = $query_file_HASH_MD5_VENDOR_INVOICE->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_vendor_invoice_file/' . $DOK_FILE)) {
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

				$this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_kasie_procurement_kp/user_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/left_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/header_menu');
				$this->load->view('wasa/user_kasie_procurement_kp/content_invoice_form');
				$this->load->view('wasa/user_kasie_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(7)) {
				$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;

				$hasil = $this->data['PO'] = $this->Invoice_model->po_list_invoice_by_id_vendor($this->data['ID_VENDOR']);
				foreach ($hasil as $PO) :
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['TANGGAL_DOKUMEN_PO'] = $PO->TANGGAL_DOKUMEN_PO;
				endforeach;

				$this->data['HASH_MD5_VENDOR_INVOICE'] = $HASH_MD5_VENDOR_INVOICE;
				$sess_data['HASH_MD5_VENDOR_INVOICE'] = $this->data['HASH_MD5_VENDOR_INVOICE'];
				$this->session->set_userdata($sess_data);
				// $this->cetak_pdf($HASH_MD5_PO);

				$hasil = $this->Invoice_model->get_data_po_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);
				$HASH_MD5_VENDOR_INVOICE = $hasil['HASH_MD5_VENDOR_INVOICE'];
				$this->data['HASH_MD5_VENDOR_INVOICE'] = $HASH_MD5_VENDOR_INVOICE;

				$query_file_HASH_MD5_VENDOR_INVOICE = $this->Vendor_Invoice_Form_File_Model->file_list_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);

				if ($query_file_HASH_MD5_VENDOR_INVOICE->num_rows() > 0) {

					$this->data['dokumen'] = $this->Vendor_Invoice_Form_File_Model->file_list_by_HASH_MD5_VENDOR_INVOICE_result($HASH_MD5_VENDOR_INVOICE);

					$hasil = $query_file_HASH_MD5_VENDOR_INVOICE->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_vendor_invoice_file/' . $DOK_FILE)) {
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

				$this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
				$this->load->view('wasa/user_manajer_procurement_kp/user_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/left_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/header_menu');
				$this->load->view('wasa/user_manajer_procurement_kp/content_invoice_form');
				$this->load->view('wasa/user_manajer_procurement_kp/footer');
			} else if ($this->ion_auth->in_group(38)) {
				$hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
				foreach ($hasil->result() as $VENDOR) :
					$this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
					$this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
					$this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
					$this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
				endforeach;

				$hasil = $this->data['PO'] = $this->Invoice_model->po_list_invoice_by_id_vendor($this->data['ID_VENDOR']);
				foreach ($hasil as $PO) :
					$this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
					$this->data['TANGGAL_DOKUMEN_PO'] = $PO->TANGGAL_DOKUMEN_PO;
				endforeach;

				$this->data['HASH_MD5_VENDOR_INVOICE'] = $HASH_MD5_VENDOR_INVOICE;
				$sess_data['HASH_MD5_VENDOR_INVOICE'] = $this->data['HASH_MD5_VENDOR_INVOICE'];
				$this->session->set_userdata($sess_data);
				// $this->cetak_pdf($HASH_MD5_PO);

				// var_dump($HASH_MD5_VENDOR_INVOICE);

				$hasil = $this->Invoice_model->get_data_po_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);
				$HASH_MD5_VENDOR_INVOICE = $hasil['HASH_MD5_VENDOR_INVOICE'];
				$this->data['HASH_MD5_VENDOR_INVOICE'] = $HASH_MD5_VENDOR_INVOICE;

				$query_file_HASH_MD5_VENDOR_INVOICE = $this->Vendor_Invoice_Form_File_Model->file_list_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);

				if ($query_file_HASH_MD5_VENDOR_INVOICE->num_rows() > 0) {

					$this->data['dokumen'] = $this->Vendor_Invoice_Form_File_Model->file_list_by_HASH_MD5_VENDOR_INVOICE_result($HASH_MD5_VENDOR_INVOICE);

					$hasil = $query_file_HASH_MD5_VENDOR_INVOICE->row();
					$DOK_FILE = $hasil->DOK_FILE;
					$TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;
					$JENIS_FILE = $hasil->JENIS_FILE;

					if (file_exists($file = './assets/upload_vendor_invoice_file/' . $DOK_FILE)) {
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

				$this->load->view('wasa/user_vendor/head_normal', $this->data);
				$this->load->view('wasa/user_vendor/user_menu');
				$this->load->view('wasa/user_vendor/left_menu');
				$this->load->view('wasa/user_vendor/header_menu');
				$this->load->view('wasa/user_vendor/content_invoice_form');
				// $this->load->view('wasa/user_vendor/footer');
			} else {
				redirect('Invoice', 'refresh');
			}
		} else {
			$this->logout();
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
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
			//Query file BY DOK_FILE
			$query_DOK_FILE = $this->PO_Form_File_Model->file_list_by_DOK_FILE($this->data['DOK_FILE']);

			if ($query_DOK_FILE->num_rows() > 0) {
				$hasil = $query_DOK_FILE->row();
				$DOK_FILE = $hasil->DOK_FILE;
				if (file_exists($file = './assets/upload_po_form_file/' . $DOK_FILE)) {
					unlink($file);
				}

				$this->PO_Form_File_Model->hapus_data_by_DOK_FILE($DOK_FILE);

				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			} else {
				$HASH_MD5_PO = $this->session->userdata('HASH_MD5_PO');
				redirect('/po_form/view/' . $HASH_MD5_PO, 'refresh');
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('PO', 'refresh');
		}
	}

	function proses_upload_file()
	{

		if (!$this->ion_auth->logged_in()) {
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		$HASH_MD5_VENDOR_INVOICE = $this->session->userdata('HASH_MD5_VENDOR_INVOICE');

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "Invoice_" . $HASH_MD5_VENDOR_INVOICE . '_';
			$config['upload_path']   = './assets/upload_vendor_invoice_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_ID_VENDOR_INVOICE = $this->Invoice_model->get_data_po_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);
			$ID_VENDOR_INVOICE = $query_ID_VENDOR_INVOICE['ID_VENDOR_INVOICE'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_vendor_invoice_file/' . $nama;
				$this->db->insert('vendor_invoice_form_file', array('ID_VENDOR_INVOICE' => $ID_VENDOR_INVOICE, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_VENDOR_INVOICE' => $HASH_MD5_VENDOR_INVOICE, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "Invoice_" . $HASH_MD5_VENDOR_INVOICE . '_';
			$config['upload_path']   = './assets/upload_vendor_invoice_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_ID_VENDOR_INVOICE = $this->Invoice_model->get_data_po_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);
			$ID_VENDOR_INVOICE = $query_ID_VENDOR_INVOICE['ID_VENDOR_INVOICE'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_vendor_invoice_file/' . $nama;
				$this->db->insert('vendor_invoice_form_file', array('ID_VENDOR_INVOICE' => $ID_VENDOR_INVOICE, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_VENDOR_INVOICE' => $HASH_MD5_VENDOR_INVOICE, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "Invoice_" . $HASH_MD5_VENDOR_INVOICE . '_';
			$config['upload_path']   = './assets/upload_vendor_invoice_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_ID_VENDOR_INVOICE = $this->Invoice_model->get_data_po_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);
			$ID_VENDOR_INVOICE = $query_ID_VENDOR_INVOICE['ID_VENDOR_INVOICE'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_vendor_invoice_file/' . $nama;
				$this->db->insert('vendor_invoice_form_file', array('ID_VENDOR_INVOICE' => $ID_VENDOR_INVOICE, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_VENDOR_INVOICE' => $HASH_MD5_VENDOR_INVOICE, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			}
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
		} else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) {
			$WAKTU = date('Y-m-d H:i:s');

			$nama_file = "Invoice_" . $HASH_MD5_VENDOR_INVOICE . '_';
			$config['upload_path']   = './assets/upload_vendor_invoice_file/';
			$config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
			$config['max_size']  = 15000000;
			$config['file_name'] = $nama_file;

			$this->load->library('upload', $config);

			$query_ID_VENDOR_INVOICE = $this->Invoice_model->get_data_po_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE);
			$ID_VENDOR_INVOICE = $query_ID_VENDOR_INVOICE['ID_VENDOR_INVOICE'];

			if ($this->upload->do_upload('userfile')) {
				$token = $this->input->post('token_npwp');
				$nama = $this->upload->data('file_name');

				$file_upload = $this->upload->data();

				$JENIS_FILE = $this->input->post('JENIS_FILE');

				$KETERANGAN = './assets/upload_vendor_invoice_file/' . $nama;
				$this->db->insert('vendor_invoice_form_file', array('ID_VENDOR_INVOICE' => $ID_VENDOR_INVOICE, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_VENDOR_INVOICE' => $HASH_MD5_VENDOR_INVOICE, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
				echo ($JENIS_FILE);
			} else {
				$error = $this->upload->display_errors();

				echo($error);
			}
		} else {
			// alihkan mereka ke halaman login
			redirect('barang_master', 'refresh');
		}
	}
}
