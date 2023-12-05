<?php defined('BASEPATH') or exit('No direct script access allowed');

class Catat_stok_gudang_form extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->load->library('session');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->data['title'] = 'SIPESUT | List Format Serah Terima Barang';

        $this->load->model('RASD_model');
        $this->load->model('FSTB_model');
        $this->load->model('Foto_model');
        $this->load->model('Jenis_barang_model');
        $this->load->model('Khp_model');
        $this->load->model('Proyek_model');
        $this->load->model('FSTB_form_model');
        $this->load->model('Satuan_barang_model');
		$this->load->model('Jenis_barang_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');
        $this->load->model('PO_model');
        $this->load->model('Vendor_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "FSTB_aktif";
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses Catat stok gudang";
        $WAKTU = date('Y-m-d H:i:s');
        $this->FSTB_model->user_log_FSTB($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->FSTB_model->user_log_FSTB($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

        $HASH_MD5_FSTB = $this->uri->segment(3);
		if ($this->FSTB_model->get_id_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB) == 'TIDAK ADA DATA FSTB') {
			redirect('FSTB', 'refresh');
		}

        //fungsi ini untuk mengirim data ke dropdown
		$HASH_MD5_FSTB = $this->uri->segment(3);
		$hasil = $this->FSTB_model->get_id_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB);
		$ID_FSTB = $hasil['ID_FSTB'];
		$this->data['ID_FSTB'] = $ID_FSTB;
		$this->data['FSTB'] = $this->FSTB_model->fstb_list_by_id_fstb($ID_FSTB);
		$this->data['CATATAN_FSTB'] = $this->FSTB_form_model->get_data_catatan_FSTB_by_id_fstb($ID_FSTB);

        foreach ($this->data['FSTB']->result() as $FSTB) :
			$this->data['HASH_MD5_FSTB'] = $FSTB->HASH_MD5_FSTB;
			$this->data['STATUS_FSTB'] = $FSTB->STATUS_FSTB;
			$this->data['PROGRESS_FSTB'] = $FSTB->PROGRESS_FSTB;
		endforeach;

        $this->data['satuan_barang_list'] = $this->Satuan_barang_model->satuan_barang_list();
		$this->data['jenis_barang_list'] = $this->Jenis_barang_model->jenis_barang_list();

        $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
        $this->data['ID_PROYEK_SERAH_TERIMA'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
        $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

        $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK_SERAH_TERIMA']);
        $this->data['INISIAL'] = $data_proyek['INISIAL'];
        $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

        $this->data['DATA_PEGAWAI_PROYEK'] = $this->Organisasi_model->organisasi_list_by_id_proyek($this->data['ID_PROYEK_SERAH_TERIMA']);

        $sess_data['ID_PROYEK_SERAH_TERIMA'] = $this->data['ID_PROYEK_SERAH_TERIMA'];
        $sess_data['USER_ID'] = $this->data['USER_ID'];
        $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
        $this->session->set_userdata($sess_data);

        if ($this->ion_auth->logged_in()) {
            //fungsi ini untuk mengirim data ke dropdown

            if ($this->ion_auth->in_group(5)) { //staff_procurement_kp
                $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_kp/user_menu');
                $this->load->view('wasa/user_staff_procurement_kp/left_menu');
                $this->load->view('wasa/user_staff_procurement_kp/header_menu');
                $this->load->view('wasa/user_staff_procurement_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_staff_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(6)) { //kasie_procurement_kp
                $this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_kasie_procurement_kp/user_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/left_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/header_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_kasie_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(7)) { //manajer_procurement_kp
                $this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_procurement_kp/user_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/left_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/header_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_manajer_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(8)) { //staff_umum_logistik_sp
                $this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_sp/user_menu');
                $this->load->view('wasa/user_staff_procurement_sp/left_menu');
                $this->load->view('wasa/user_staff_procurement_sp/header_menu');
                $this->load->view('wasa/user_staff_procurement_sp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_staff_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(9)) { //supervisi_procurement_sp
                $this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_supervisi_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(10)) { //staff_umum_logistik_kp
                $this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_staff_umum_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(11)) { //kasie_logistik_kp
                $this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_kasie_logistik_kp/user_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/left_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/header_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_kasie_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(12)) { //manajer_logistik_kp
                $this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_logistik_kp/user_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/left_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/header_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_manajer_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(13)) { //staff_umum_logistik_sp
                $this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_staff_umum_logistik_sp/footer');
            } else if ($this->ion_auth->in_group(15)) { //supervisi_logistik_sp
                $this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_supervisi_logistik_sp/footer');
            } else if ($this->ion_auth->in_group(18)) { //manajer_hrd_kp
                $this->load->view('wasa/user_manajer_hrd_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_hrd_kp/user_menu');
                $this->load->view('wasa/user_manajer_hrd_kp/left_menu');
                $this->load->view('wasa/user_manajer_hrd_kp/header_menu');
                $this->load->view('wasa/user_manajer_hrd_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_manajer_hrd_kp/footer');
            } else if ($this->ion_auth->in_group(21)) { //manajer_keuangan_kp
                $this->load->view('wasa/user_manajer_keuangan_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_keuangan_kp/user_menu');
                $this->load->view('wasa/user_manajer_keuangan_kp/left_menu');
                $this->load->view('wasa/user_manajer_keuangan_kp/header_menu');
                $this->load->view('wasa/user_manajer_keuangan_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_manajer_keuangan_kp/footer');
            } else if ($this->ion_auth->in_group(24)) { //manajer_konstruksi_kp
                $this->load->view('wasa/user_manajer_konstruksi_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_konstruksi_kp/user_menu');
                $this->load->view('wasa/user_manajer_konstruksi_kp/left_menu');
                $this->load->view('wasa/user_manajer_konstruksi_kp/header_menu');
                $this->load->view('wasa/user_manajer_konstruksi_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_manajer_konstruksi_kp/footer');
            } else if ($this->ion_auth->in_group(27)) { //manajer_sdm_kp
                $this->load->view('wasa/user_manajer_sdm_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_sdm_kp/user_menu');
                $this->load->view('wasa/user_manajer_sdm_kp/left_menu');
                $this->load->view('wasa/user_manajer_sdm_kp/header_menu');
                $this->load->view('wasa/user_manajer_sdm_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_manajer_sdm_kp/footer');
            } else if ($this->ion_auth->in_group(30)) { //manajer_qaqc_kp
                $this->load->view('wasa/user_manajer_qaqc_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_qaqc_kp/user_menu');
                $this->load->view('wasa/user_manajer_qaqc_kp/left_menu');
                $this->load->view('wasa/user_manajer_qaqc_kp/header_menu');
                $this->load->view('wasa/user_manajer_qaqc_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_manajer_qaqc_kp/footer');
            } else if ($this->ion_auth->in_group(33)) { //manajer_ep_kp
                $this->load->view('wasa/user_manajer_ep_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_ep_kp/user_menu');
                $this->load->view('wasa/user_manajer_ep_kp/left_menu');
                $this->load->view('wasa/user_manajer_ep_kp/header_menu');
                $this->load->view('wasa/user_manajer_ep_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_manajer_ep_kp/footer');
            } else if ($this->ion_auth->in_group(41)) { //manajer_hsse_kp
                $this->load->view('wasa/user_manajer_hsse_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_hsse_kp/user_menu');
                $this->load->view('wasa/user_manajer_hsse_kp/left_menu');
                $this->load->view('wasa/user_manajer_hsse_kp/header_menu');
                $this->load->view('wasa/user_manajer_hsse_kp/content_catat_stok_gudang_form');
                $this->load->view('wasa/user_manajer_hsse_kp/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    function data_FSTB()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //staff_procurement_kp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK_SERAH_TERIMA');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FSTB_model->fstb_list_by_kantor_pusat($ID_PROYEK, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) { //kasie_procurement_kp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK_SERAH_TERIMA');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FSTB_model->fstb_list_by_kantor_pusat($ID_PROYEK, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) { //manajer_procurement_kp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK_SERAH_TERIMA');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FSTB_model->fstb_list_by_kantor_pusat($ID_PROYEK, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //staff_procurement_sp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK_SERAH_TERIMA');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FSTB_model->fstb_list_by_ID_PROYEK($ID_PROYEK, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //supervisi_procurement_sp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK_SERAH_TERIMA');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FSTB_model->fstb_list_by_ID_PROYEK($ID_PROYEK, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK_SERAH_TERIMA');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FSTB_model->fstb_list_by_kantor_pusat($ID_PROYEK, $USER_ID);
            echo($ID_PROYEK);

            $KETERANGAN = "Melihat List Data FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK_SERAH_TERIMA');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FSTB_model->fstb_list_by_kantor_pusat($ID_PROYEK, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK_SERAH_TERIMA');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FSTB_model->fstb_list_by_kantor_pusat($ID_PROYEK, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK_SERAH_TERIMA');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FSTB_model->fstb_list_by_ID_PROYEK($ID_PROYEK, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK_SERAH_TERIMA');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FSTB_model->fstb_list_by_ID_PROYEK($ID_PROYEK, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function data_fstb_form()
	{
		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$ID_FSTB = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB($ID_FSTB);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$ID_FSTB = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB($ID_FSTB);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$ID_FSTB = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB($ID_FSTB);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_FSTB = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB($ID_FSTB);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_FSTB = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB($ID_FSTB);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_FSTB = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB($ID_FSTB);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_FSTB = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB($ID_FSTB);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_FSTB = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB($ID_FSTB);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_FSTB = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB($ID_FSTB);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_FSTB = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB($ID_FSTB);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

    function get_data()
	{

		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_by_id_FSTB_form($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}

    function get_data_nama_master()
	{

		if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_nama_master($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_nama_master($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_nama_master($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_nama_master($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_nama_master($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_nama_master($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_nama_master($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
			$nama = $this->input->get('nama');

            $panjang = count($nama);

			$data = $this->FSTB_form_model->get_data_nama_master($nama);
			echo json_encode($data);

			// $KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			// $this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_nama_master($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
			$ID_FSTB_FORM = $this->input->get('id');
			$data = $this->FSTB_form_model->get_data_nama_master($ID_FSTB_FORM);
			echo json_encode($data);

			$KETERANGAN = "Get Data FSTB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->logout();
		}
	}


    function get_data_fstb_baru()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //staff_procurement_kp
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('ID_PROYEK_SERAH_TERIMA');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK_SERAH_TERIMA, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) { //kasie_procurement_kp
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('ID_PROYEK_SERAH_TERIMA');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK_SERAH_TERIMA, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) { //manajer_procurement_kp
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('ID_PROYEK_SERAH_TERIMA');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK_SERAH_TERIMA, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //staff_procurement_sp
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('ID_PROYEK_SERAH_TERIMA');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK_SERAH_TERIMA, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //supervisi_procurement_sp
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('ID_PROYEK_SERAH_TERIMA');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK_SERAH_TERIMA, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('ID_PROYEK_SERAH_TERIMA');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK_SERAH_TERIMA, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('ID_PROYEK_SERAH_TERIMA');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK_SERAH_TERIMA, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('ID_PROYEK_SERAH_TERIMA');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK_SERAH_TERIMA, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('ID_PROYEK_SERAH_TERIMA');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK_SERAH_TERIMA, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('ID_PROYEK_SERAH_TERIMA');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK_SERAH_TERIMA, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(18))) { //manajer_hrd_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(21))) { //manajer_keuangan_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(24))) { //manajer_konstruksi_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(27))) { //manajer_sdm_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(30))) { //manajer_qaqc_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(33))) { //manajer_ep_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(41))) { //manajer_hsse_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_proyek()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //staff_procurement_kp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) { //kasie_procurement_kp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) { //manajer_procurement_kp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //staff_procurement_sp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //supervisi_procurement_sp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_proyek_sp()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //staff_procurement_sp
            $user = $this->ion_auth->user()->row();
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
            $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];


            $data = $this->FSTB_model->get_data_proyek_sp($this->data['ID_PROYEK']);
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //supervisi_procurement_sp
            $user = $this->ion_auth->user()->row();
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
            $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];


            $data = $this->FSTB_model->get_data_proyek_sp($this->data['ID_PROYEK']);
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $user = $this->ion_auth->user()->row();
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
            $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];


            $data = $this->FSTB_model->get_data_proyek_sp($this->data['ID_PROYEK']);
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $user = $this->ion_auth->user()->row();
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
            $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];


            $data = $this->FSTB_model->get_data_proyek_sp($this->data['ID_PROYEK']);
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_surat_jalan()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //staff_procurement_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) { //kasie_procurement_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) { //manajer_procurement_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //staff_procurement_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //supervisi_procurement_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(18))) { //manajer_hrd_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(21))) { //manajer_keuangan_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(24))) { //manajer_konstruksi_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(27))) { //manajer_sdm_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(30))) { //manajer_qaqc_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(33))) { //manajer_ep_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(41))) { //manajer_hsse_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_po()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //staff_procurement_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) { //kasie_procurement_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) { //manajer_procurement_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //staff_procurement_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //supervisi_procurement_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(18))) { //manajer_hrd_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(21))) { //manajer_keuangan_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(24))) { //manajer_konstruksi_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(27))) { //manajer_sdm_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(30))) { //manajer_qaqc_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(33))) { //manajer_ep_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(41))) { //manajer_hsse_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_vendor()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //staff_procurement_kp
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) { //kasie_procurement_kp
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) { //manajer_procurement_kp
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //staff_procurement_sp
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //supervisi_procurement_sp
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_nomor_urut()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PROYEK_SERAH_TERIMA = $this->input->get('id');

            $data = $this->FSTB_model->get_nomor_urut_by_ID_PROYEK_SERAH_TERIMA($ID_PROYEK_SERAH_TERIMA);
            echo json_encode($data);

            $KETERANGAN = "Get Nomor Urut FSTB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function simpan_data()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //staff_procurement_kp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
            $this->data['JABATAN_PEGAWAI'] = $data_role_user['description'];
            $CREATE_BY_USER =  $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_FSTB', 'Tanggal Pembuatan FSTB', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_PO_2', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PO_3', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_1', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_2', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_3', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('NO_SURAT_JALAN_1', 'Nomor Surat Jalan', 'trim|required');
            // $this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR_1', 'Nomor Surat Jalan Vendor', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('ID_PEGAWAI', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK_SERAH_TERIMA = $this->input->post('ID_PROYEK_SERAH_TERIMA');
                $TANGGAL_PENGAJUAN_FSTB = $this->input->post('TANGGAL_PENGAJUAN_FSTB');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $NO_URUT_FIB = $this->input->post('NO_URUT_FIB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_FIB = $this->input->post('FILE_NAME_TEMP_FIB');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');
                $PROGRESS_FSTB = "Dalam Proses Pembuatan Staff Procurement KP";
                $STATUS_FSTB = "Draft";

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else if ($this->input->post('ID_PROYEK_2') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_2');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_3');
                }

                if ($this->input->post('ID_PO_2') != '') {
                    $ID_PO = $this->input->post('ID_PO_2');
                } else {
                    $ID_PO = $this->input->post('ID_PO_3');
                }

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('ID_VENDOR_2') != '') {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                } else {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_3');
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }

                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK_SERAH_TERIMA,
                        $ID_PROYEK,
                        $ID_PO,
                        $TANGGAL_PENGAJUAN_FSTB,
                        $NO_URUT_FSTB,
                        $NO_URUT_FIB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_FIB,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $ID_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "Simpan FSTB: "
                        . "; " . $ID_PROYEK_SERAH_TERIMA
                        . "; " . $ID_PROYEK
                        . "; " . $ID_PO
                        . "; " . $TANGGAL_PENGAJUAN_FSTB
                        . "; " . $NO_URUT_FSTB
                        . "; " . $NO_URUT_FIB
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_FSTB
                        . "; " . $PROGRESS_FSTB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_FIB
                        . "; " . $ID_VENDOR
                        . "; " . $ID_SURAT_JALAN
                        . "; " . $NOMOR_SURAT_JALAN_VENDOR
                        . "; " . $NAMA_PENGIRIM
                        . "; " . $NO_HP_PENGIRIM
                        . "; " . $ID_PEGAWAI
                        . "; " . $TANGGAL_BARANG_DATANG_HARI
                        . "; " . $SUMBER_PENERIMAAN;
                    $this->user_log($KETERANGAN);

                    if ($SUMBER_PENERIMAAN == 'Pengembalian Dari Site Project') {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 FSTB: " . $ID_PROYEK . "; " . $NO_URUT_FSTB
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) { //kasie_procurement_kp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
            $this->data['JABATAN_PEGAWAI'] = $data_role_user['description'];
            $CREATE_BY_USER =  $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_FSTB', 'Tanggal Pembuatan FSTB', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_PO_2', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PO_3', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_1', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_2', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_3', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('NO_SURAT_JALAN_1', 'Nomor Surat Jalan', 'trim|required');
            // $this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR_1', 'Nomor Surat Jalan Vendor', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('ID_PEGAWAI', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK_SERAH_TERIMA = $this->input->post('ID_PROYEK_SERAH_TERIMA');
                $TANGGAL_PENGAJUAN_FSTB = $this->input->post('TANGGAL_PENGAJUAN_FSTB');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $NO_URUT_FIB = $this->input->post('NO_URUT_FIB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_FIB = $this->input->post('FILE_NAME_TEMP_FIB');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');
                $PROGRESS_FSTB = "Dalam Proses Pembuatan Kasie Procurement KP";
                $STATUS_FSTB = "Draft";

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else if ($this->input->post('ID_PROYEK_2') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_2');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_3');
                }

                if ($this->input->post('ID_PO_2') != '') {
                    $ID_PO = $this->input->post('ID_PO_2');
                } else {
                    $ID_PO = $this->input->post('ID_PO_3');
                }

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('ID_VENDOR_2') != '') {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                } else {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_3');
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }

                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK_SERAH_TERIMA,
                        $ID_PROYEK,
                        $ID_PO,
                        $TANGGAL_PENGAJUAN_FSTB,
                        $NO_URUT_FSTB,
                        $NO_URUT_FIB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_FIB,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $ID_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "Simpan FSTB: "
                        . "; " . $ID_PROYEK_SERAH_TERIMA
                        . "; " . $ID_PROYEK
                        . "; " . $ID_PO
                        . "; " . $TANGGAL_PENGAJUAN_FSTB
                        . "; " . $NO_URUT_FSTB
                        . "; " . $NO_URUT_FIB
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_FSTB
                        . "; " . $PROGRESS_FSTB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_FIB
                        . "; " . $ID_VENDOR
                        . "; " . $ID_SURAT_JALAN
                        . "; " . $NOMOR_SURAT_JALAN_VENDOR
                        . "; " . $NAMA_PENGIRIM
                        . "; " . $NO_HP_PENGIRIM
                        . "; " . $ID_PEGAWAI
                        . "; " . $TANGGAL_BARANG_DATANG_HARI
                        . "; " . $SUMBER_PENERIMAAN;
                    $this->user_log($KETERANGAN);

                    if ($SUMBER_PENERIMAAN == 'Pengembalian Dari Site Project') {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 FSTB: " . $ID_PROYEK . "; " . $NO_URUT_FSTB
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) { //manajer_procurement_kp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
            $this->data['JABATAN_PEGAWAI'] = $data_role_user['description'];
            $CREATE_BY_USER =  $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_FSTB', 'Tanggal Pembuatan FSTB', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_PO_2', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PO_3', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_1', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_2', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_3', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('NO_SURAT_JALAN_1', 'Nomor Surat Jalan', 'trim|required');
            // $this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR_1', 'Nomor Surat Jalan Vendor', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('ID_PEGAWAI', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK_SERAH_TERIMA = $this->input->post('ID_PROYEK_SERAH_TERIMA');
                $TANGGAL_PENGAJUAN_FSTB = $this->input->post('TANGGAL_PENGAJUAN_FSTB');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $NO_URUT_FIB = $this->input->post('NO_URUT_FIB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_FIB = $this->input->post('FILE_NAME_TEMP_FIB');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');
                $PROGRESS_FSTB = "Dalam Proses Pembuatan Manajer Procurement KP";
                $STATUS_FSTB = "Draft";

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else if ($this->input->post('ID_PROYEK_2') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_2');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_3');
                }

                if ($this->input->post('ID_PO_2') != '') {
                    $ID_PO = $this->input->post('ID_PO_2');
                } else {
                    $ID_PO = $this->input->post('ID_PO_3');
                }

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('ID_VENDOR_2') != '') {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                } else {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_3');
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }

                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK_SERAH_TERIMA,
                        $ID_PROYEK,
                        $ID_PO,
                        $TANGGAL_PENGAJUAN_FSTB,
                        $NO_URUT_FSTB,
                        $NO_URUT_FIB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_FIB,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $ID_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "Simpan FSTB: "
                        . "; " . $ID_PROYEK_SERAH_TERIMA
                        . "; " . $ID_PROYEK
                        . "; " . $ID_PO
                        . "; " . $TANGGAL_PENGAJUAN_FSTB
                        . "; " . $NO_URUT_FSTB
                        . "; " . $NO_URUT_FIB
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_FSTB
                        . "; " . $PROGRESS_FSTB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_FIB
                        . "; " . $ID_VENDOR
                        . "; " . $ID_SURAT_JALAN
                        . "; " . $NOMOR_SURAT_JALAN_VENDOR
                        . "; " . $NAMA_PENGIRIM
                        . "; " . $NO_HP_PENGIRIM
                        . "; " . $ID_PEGAWAI
                        . "; " . $TANGGAL_BARANG_DATANG_HARI
                        . "; " . $SUMBER_PENERIMAAN;
                    $this->user_log($KETERANGAN);

                    if ($SUMBER_PENERIMAAN == 'Pengembalian Dari Site Project') {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 FSTB: " . $ID_PROYEK . "; " . $NO_URUT_FSTB
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //staff_procurement_sp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
            $this->data['JABATAN_PEGAWAI'] = $data_role_user['description'];
            $CREATE_BY_USER =  $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_FSTB', 'Tanggal Pembuatan FSTB', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_PO_2', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PO_3', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_1', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_2', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_3', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('NO_SURAT_JALAN_1', 'Nomor Surat Jalan', 'trim|required');
            // $this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR_1', 'Nomor Surat Jalan Vendor', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('ID_PEGAWAI', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK_SERAH_TERIMA = $this->input->post('ID_PROYEK_SERAH_TERIMA');
                $TANGGAL_PENGAJUAN_FSTB = $this->input->post('TANGGAL_PENGAJUAN_FSTB');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $NO_URUT_FIB = $this->input->post('NO_URUT_FIB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_FIB = $this->input->post('FILE_NAME_TEMP_FIB');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');
                $PROGRESS_FSTB = "Dalam Proses Pembuatan Staff Procurement SP";
                $STATUS_FSTB = "Draft";

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else if ($this->input->post('ID_PROYEK_2') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_2');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_3');
                }

                if ($this->input->post('ID_PO_2') != '') {
                    $ID_PO = $this->input->post('ID_PO_2');
                } else {
                    $ID_PO = $this->input->post('ID_PO_3');
                }

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('ID_VENDOR_2') != '') {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                } else {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_3');
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }

                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK_SERAH_TERIMA,
                        $ID_PROYEK,
                        $ID_PO,
                        $TANGGAL_PENGAJUAN_FSTB,
                        $NO_URUT_FSTB,
                        $NO_URUT_FIB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_FIB,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $ID_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "Simpan FSTB: "
                        . "; " . $ID_PROYEK_SERAH_TERIMA
                        . "; " . $ID_PROYEK
                        . "; " . $ID_PO
                        . "; " . $TANGGAL_PENGAJUAN_FSTB
                        . "; " . $NO_URUT_FSTB
                        . "; " . $NO_URUT_FIB
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_FSTB
                        . "; " . $PROGRESS_FSTB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_FIB
                        . "; " . $ID_VENDOR
                        . "; " . $ID_SURAT_JALAN
                        . "; " . $NOMOR_SURAT_JALAN_VENDOR
                        . "; " . $NAMA_PENGIRIM
                        . "; " . $NO_HP_PENGIRIM
                        . "; " . $ID_PEGAWAI
                        . "; " . $TANGGAL_BARANG_DATANG_HARI
                        . "; " . $SUMBER_PENERIMAAN;
                    $this->user_log($KETERANGAN);

                    if ($SUMBER_PENERIMAAN == 'Pengembalian Dari Site Project') {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 FSTB: " . $ID_PROYEK . "; " . $NO_URUT_FSTB
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //supervisi_procurement_sp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
            $this->data['JABATAN_PEGAWAI'] = $data_role_user['description'];
            $CREATE_BY_USER =  $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_FSTB', 'Tanggal Pembuatan FSTB', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_PO_2', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PO_3', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_1', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_2', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_3', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('NO_SURAT_JALAN_1', 'Nomor Surat Jalan', 'trim|required');
            // $this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR_1', 'Nomor Surat Jalan Vendor', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('ID_PEGAWAI', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK_SERAH_TERIMA = $this->input->post('ID_PROYEK_SERAH_TERIMA');
                $TANGGAL_PENGAJUAN_FSTB = $this->input->post('TANGGAL_PENGAJUAN_FSTB');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $NO_URUT_FIB = $this->input->post('NO_URUT_FIB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_FIB = $this->input->post('FILE_NAME_TEMP_FIB');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');
                $PROGRESS_FSTB = "Dalam Proses Pembuatan Supervisi Procurement SP";
                $STATUS_FSTB = "Draft";

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else if ($this->input->post('ID_PROYEK_2') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_2');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_3');
                }

                if ($this->input->post('ID_PO_2') != '') {
                    $ID_PO = $this->input->post('ID_PO_2');
                } else {
                    $ID_PO = $this->input->post('ID_PO_3');
                }

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('ID_VENDOR_2') != '') {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                } else {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_3');
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }

                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK_SERAH_TERIMA,
                        $ID_PROYEK,
                        $ID_PO,
                        $TANGGAL_PENGAJUAN_FSTB,
                        $NO_URUT_FSTB,
                        $NO_URUT_FIB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_FIB,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $ID_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "Simpan FSTB: "
                        . "; " . $ID_PROYEK_SERAH_TERIMA
                        . "; " . $ID_PROYEK
                        . "; " . $ID_PO
                        . "; " . $TANGGAL_PENGAJUAN_FSTB
                        . "; " . $NO_URUT_FSTB
                        . "; " . $NO_URUT_FIB
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_FSTB
                        . "; " . $PROGRESS_FSTB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_FIB
                        . "; " . $ID_VENDOR
                        . "; " . $ID_SURAT_JALAN
                        . "; " . $NOMOR_SURAT_JALAN_VENDOR
                        . "; " . $NAMA_PENGIRIM
                        . "; " . $NO_HP_PENGIRIM
                        . "; " . $ID_PEGAWAI
                        . "; " . $TANGGAL_BARANG_DATANG_HARI
                        . "; " . $SUMBER_PENERIMAAN;
                    $this->user_log($KETERANGAN);

                    if ($SUMBER_PENERIMAAN == 'Pengembalian Dari Site Project') {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 FSTB: " . $ID_PROYEK . "; " . $NO_URUT_FSTB
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_logistik_kp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
            $this->data['JABATAN_PEGAWAI'] = $data_role_user['description'];
            $CREATE_BY_USER =  $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_FSTB', 'Tanggal Pembuatan FSTB', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_PO_2', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PO_3', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_1', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_2', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_3', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('NO_SURAT_JALAN_1', 'Nomor Surat Jalan', 'trim|required');
            // $this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR_1', 'Nomor Surat Jalan Vendor', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('ID_PEGAWAI', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK_SERAH_TERIMA = $this->input->post('ID_PROYEK_SERAH_TERIMA');
                $TANGGAL_PENGAJUAN_FSTB = $this->input->post('TANGGAL_PENGAJUAN_FSTB');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $NO_URUT_FIB = $this->input->post('NO_URUT_FIB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_FIB = $this->input->post('FILE_NAME_TEMP_FIB');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');
                $PROGRESS_FSTB = "Dalam Proses Pembuatan Staff Logistik KP";
                $STATUS_FSTB = "Draft";

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else if ($this->input->post('ID_PROYEK_2') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_2');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_3');
                }

                if ($this->input->post('ID_PO_2') != '') {
                    $ID_PO = $this->input->post('ID_PO_2');
                } else {
                    $ID_PO = $this->input->post('ID_PO_3');
                }

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('ID_VENDOR_2') != '') {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                } else {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_3');
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }

                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK_SERAH_TERIMA,
                        $ID_PROYEK,
                        $ID_PO,
                        $TANGGAL_PENGAJUAN_FSTB,
                        $NO_URUT_FSTB,
                        $NO_URUT_FIB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_FIB,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $ID_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "Simpan FSTB: "
                        . "; " . $ID_PROYEK_SERAH_TERIMA
                        . "; " . $ID_PROYEK
                        . "; " . $ID_PO
                        . "; " . $TANGGAL_PENGAJUAN_FSTB
                        . "; " . $NO_URUT_FSTB
                        . "; " . $NO_URUT_FIB
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_FSTB
                        . "; " . $PROGRESS_FSTB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_FIB
                        . "; " . $ID_VENDOR
                        . "; " . $ID_SURAT_JALAN
                        . "; " . $NOMOR_SURAT_JALAN_VENDOR
                        . "; " . $NAMA_PENGIRIM
                        . "; " . $NO_HP_PENGIRIM
                        . "; " . $ID_PEGAWAI
                        . "; " . $TANGGAL_BARANG_DATANG_HARI
                        . "; " . $SUMBER_PENERIMAAN;
                    $this->user_log($KETERANGAN);

                    if ($SUMBER_PENERIMAAN == 'Pengembalian Dari Site Project') {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 FSTB: " . $ID_PROYEK . "; " . $NO_URUT_FSTB
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
            $this->data['JABATAN_PEGAWAI'] = $data_role_user['description'];
            $CREATE_BY_USER =  $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_FSTB', 'Tanggal Pembuatan FSTB', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_PO_2', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PO_3', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_1', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_2', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_3', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('NO_SURAT_JALAN_1', 'Nomor Surat Jalan', 'trim|required');
            // $this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR_1', 'Nomor Surat Jalan Vendor', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('ID_PEGAWAI', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK_SERAH_TERIMA = $this->input->post('ID_PROYEK_SERAH_TERIMA');
                $TANGGAL_PENGAJUAN_FSTB = $this->input->post('TANGGAL_PENGAJUAN_FSTB');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $NO_URUT_FIB = $this->input->post('NO_URUT_FIB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_FIB = $this->input->post('FILE_NAME_TEMP_FIB');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');
                $PROGRESS_FSTB = "Dalam Proses Pembuatan Kasie Logistik KP";
                $STATUS_FSTB = "Draft";

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else if ($this->input->post('ID_PROYEK_2') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_2');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_3');
                }

                if ($this->input->post('ID_PO_2') != '') {
                    $ID_PO = $this->input->post('ID_PO_2');
                } else {
                    $ID_PO = $this->input->post('ID_PO_3');
                }

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('ID_VENDOR_2') != '') {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                } else {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_3');
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }

                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK_SERAH_TERIMA,
                        $ID_PROYEK,
                        $ID_PO,
                        $TANGGAL_PENGAJUAN_FSTB,
                        $NO_URUT_FSTB,
                        $NO_URUT_FIB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_FIB,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $ID_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "Simpan FSTB: "
                        . "; " . $ID_PROYEK_SERAH_TERIMA
                        . "; " . $ID_PROYEK
                        . "; " . $ID_PO
                        . "; " . $TANGGAL_PENGAJUAN_FSTB
                        . "; " . $NO_URUT_FSTB
                        . "; " . $NO_URUT_FIB
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_FSTB
                        . "; " . $PROGRESS_FSTB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_FIB
                        . "; " . $ID_VENDOR
                        . "; " . $ID_SURAT_JALAN
                        . "; " . $NOMOR_SURAT_JALAN_VENDOR
                        . "; " . $NAMA_PENGIRIM
                        . "; " . $NO_HP_PENGIRIM
                        . "; " . $ID_PEGAWAI
                        . "; " . $TANGGAL_BARANG_DATANG_HARI
                        . "; " . $SUMBER_PENERIMAAN;
                    $this->user_log($KETERANGAN);

                    if ($SUMBER_PENERIMAAN == 'Pengembalian Dari Site Project') {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 FSTB: " . $ID_PROYEK . "; " . $NO_URUT_FSTB
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
            $this->data['JABATAN_PEGAWAI'] = $data_role_user['description'];
            $CREATE_BY_USER =  $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_FSTB', 'Tanggal Pembuatan FSTB', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_PO_2', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PO_3', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_1', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_2', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_3', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('NO_SURAT_JALAN_1', 'Nomor Surat Jalan', 'trim|required');
            // $this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR_1', 'Nomor Surat Jalan Vendor', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('ID_PEGAWAI', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK_SERAH_TERIMA = $this->input->post('ID_PROYEK_SERAH_TERIMA');
                $TANGGAL_PENGAJUAN_FSTB = $this->input->post('TANGGAL_PENGAJUAN_FSTB');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $NO_URUT_FIB = $this->input->post('NO_URUT_FIB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_FIB = $this->input->post('FILE_NAME_TEMP_FIB');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');
                $PROGRESS_FSTB = "Dalam Proses Pembuatan Manajer Logistik KP";
                $STATUS_FSTB = "Draft";

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else if ($this->input->post('ID_PROYEK_2') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_2');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_3');
                }

                if ($this->input->post('ID_PO_2') != '') {
                    $ID_PO = $this->input->post('ID_PO_2');
                } else {
                    $ID_PO = $this->input->post('ID_PO_3');
                }

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('ID_VENDOR_2') != '') {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                } else {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_3');
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }

                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK_SERAH_TERIMA,
                        $ID_PROYEK,
                        $ID_PO,
                        $TANGGAL_PENGAJUAN_FSTB,
                        $NO_URUT_FSTB,
                        $NO_URUT_FIB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_FIB,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $ID_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "Simpan FSTB: "
                        . "; " . $ID_PROYEK_SERAH_TERIMA
                        . "; " . $ID_PROYEK
                        . "; " . $ID_PO
                        . "; " . $TANGGAL_PENGAJUAN_FSTB
                        . "; " . $NO_URUT_FSTB
                        . "; " . $NO_URUT_FIB
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_FSTB
                        . "; " . $PROGRESS_FSTB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_FIB
                        . "; " . $ID_VENDOR
                        . "; " . $ID_SURAT_JALAN
                        . "; " . $NOMOR_SURAT_JALAN_VENDOR
                        . "; " . $NAMA_PENGIRIM
                        . "; " . $NO_HP_PENGIRIM
                        . "; " . $ID_PEGAWAI
                        . "; " . $TANGGAL_BARANG_DATANG_HARI
                        . "; " . $SUMBER_PENERIMAAN;
                    $this->user_log($KETERANGAN);

                    if ($SUMBER_PENERIMAAN == 'Pengembalian Dari Site Project') {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 FSTB: " . $ID_PROYEK . "; " . $NO_URUT_FSTB
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
            $this->data['JABATAN_PEGAWAI'] = $data_role_user['description'];
            $CREATE_BY_USER =  $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_FSTB', 'Tanggal Pembuatan FSTB', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_PO_2', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PO_3', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_1', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_2', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_3', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('NO_SURAT_JALAN_1', 'Nomor Surat Jalan', 'trim|required');
            // $this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR_1', 'Nomor Surat Jalan Vendor', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('ID_PEGAWAI', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK_SERAH_TERIMA = $this->input->post('ID_PROYEK_SERAH_TERIMA');
                $TANGGAL_PENGAJUAN_FSTB = $this->input->post('TANGGAL_PENGAJUAN_FSTB');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $NO_URUT_FIB = $this->input->post('NO_URUT_FIB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_FIB = $this->input->post('FILE_NAME_TEMP_FIB');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');
                $PROGRESS_FSTB = "Dalam Proses Pembuatan Staff Umum Logistik SP";
                $STATUS_FSTB = "Draft";

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else if ($this->input->post('ID_PROYEK_2') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_2');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_3');
                }

                if ($this->input->post('ID_PO_2') != '') {
                    $ID_PO = $this->input->post('ID_PO_2');
                } else {
                    $ID_PO = $this->input->post('ID_PO_3');
                }

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('ID_VENDOR_2') != '') {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                } else {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_3');
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }

                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK_SERAH_TERIMA,
                        $ID_PROYEK,
                        $ID_PO,
                        $TANGGAL_PENGAJUAN_FSTB,
                        $NO_URUT_FSTB,
                        $NO_URUT_FIB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_FIB,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $ID_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "Simpan FSTB: "
                        . "; " . $ID_PROYEK_SERAH_TERIMA
                        . "; " . $ID_PROYEK
                        . "; " . $ID_PO
                        . "; " . $TANGGAL_PENGAJUAN_FSTB
                        . "; " . $NO_URUT_FSTB
                        . "; " . $NO_URUT_FIB
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_FSTB
                        . "; " . $PROGRESS_FSTB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_FIB
                        . "; " . $ID_VENDOR
                        . "; " . $ID_SURAT_JALAN
                        . "; " . $NOMOR_SURAT_JALAN_VENDOR
                        . "; " . $NAMA_PENGIRIM
                        . "; " . $NO_HP_PENGIRIM
                        . "; " . $ID_PEGAWAI
                        . "; " . $TANGGAL_BARANG_DATANG_HARI
                        . "; " . $SUMBER_PENERIMAAN;
                    $this->user_log($KETERANGAN);

                    if ($SUMBER_PENERIMAAN == 'Pengembalian Dari Site Project') {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 FSTB: " . $ID_PROYEK . "; " . $NO_URUT_FSTB
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['USER_ID']);
            $this->data['JABATAN_PEGAWAI'] = $data_role_user['description'];
            $CREATE_BY_USER =  $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_FSTB', 'Tanggal Pembuatan FSTB', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_PO_2', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PO_3', 'Nomor Urut PO', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_1', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_2', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('ID_PROYEK_3', 'Nama Vendor', 'trim|required');
            // $this->form_validation->set_rules('NO_SURAT_JALAN_1', 'Nomor Surat Jalan', 'trim|required');
            // $this->form_validation->set_rules('NOMOR_SURAT_JALAN_VENDOR_1', 'Nomor Surat Jalan Vendor', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('ID_PEGAWAI', 'Nama Pegawai', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK_SERAH_TERIMA = $this->input->post('ID_PROYEK_SERAH_TERIMA');
                $TANGGAL_PENGAJUAN_FSTB = $this->input->post('TANGGAL_PENGAJUAN_FSTB');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $NO_URUT_FIB = $this->input->post('NO_URUT_FIB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_FIB = $this->input->post('FILE_NAME_TEMP_FIB');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $ID_PEGAWAI = $this->input->post('ID_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');
                $PROGRESS_FSTB = "Dalam Proses Pembuatan Supervisi Logistik SP";
                $STATUS_FSTB = "Draft";

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else if ($this->input->post('ID_PROYEK_2') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_2');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_3');
                }

                if ($this->input->post('ID_PO_2') != '') {
                    $ID_PO = $this->input->post('ID_PO_2');
                } else {
                    $ID_PO = $this->input->post('ID_PO_3');
                }

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('ID_VENDOR_2') != '') {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                } else {
                    $ID_VENDOR = $this->input->post('ID_VENDOR_3');
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }

                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK_SERAH_TERIMA,
                        $ID_PROYEK,
                        $ID_PO,
                        $TANGGAL_PENGAJUAN_FSTB,
                        $NO_URUT_FSTB,
                        $NO_URUT_FIB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_FIB,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $ID_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "Simpan FSTB: "
                        . "; " . $ID_PROYEK_SERAH_TERIMA
                        . "; " . $ID_PROYEK
                        . "; " . $ID_PO
                        . "; " . $TANGGAL_PENGAJUAN_FSTB
                        . "; " . $NO_URUT_FSTB
                        . "; " . $NO_URUT_FIB
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_FSTB
                        . "; " . $PROGRESS_FSTB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_FIB
                        . "; " . $ID_VENDOR
                        . "; " . $ID_SURAT_JALAN
                        . "; " . $NOMOR_SURAT_JALAN_VENDOR
                        . "; " . $NAMA_PENGIRIM
                        . "; " . $NO_HP_PENGIRIM
                        . "; " . $ID_PEGAWAI
                        . "; " . $TANGGAL_BARANG_DATANG_HARI
                        . "; " . $SUMBER_PENERIMAAN;
                    $this->user_log($KETERANGAN);

                    if ($SUMBER_PENERIMAAN == 'Pengembalian Dari Site Project') {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 FSTB: " . $ID_PROYEK . "; " . $NO_URUT_FSTB
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        } else {
            $this->logout();
        }
    }

    function simpan_perubahan_FSTB()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('CTT', 'CTT', 'trim');
            // run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                $ID_FSTB = $this->input->post('ID_FSTB');
                $CTT = $this->input->post('CTT');
                $this->FSTB_model->update_data_ubah_logistik($ID_FSTB, $CTT);
                redirect('FSTB', 'refresh');
            }
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function simpan_ajuan_akhir()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('CTT', 'CTT', 'trim');
            // run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                $ID_FSTB = $this->input->post('ID_FSTB');
                $CTT = $this->input->post('CTT');
                $this->FSTB_model->update_data_akhir($ID_FSTB, $CTT);
                $ID_KHP = $this->Khp_model->simpan_data_by_admin($ID_FSTB);
                $list_FSTB_barang = $this->FSTB_barang_model->FSTB_barang_list_by_id_FSTB($ID_FSTB);
                foreach ($list_FSTB_barang as $index => $value) {
                    $this->Khp_model->simpan_data_khp_barang_by_admin($ID_KHP, $value->ID_FSTB_BARANG, $value->JUMLAH_SETUJU_D_KEU);
                }
                redirect('FSTB', 'refresh');
            }
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
