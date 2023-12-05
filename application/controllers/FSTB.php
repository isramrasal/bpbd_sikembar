<?php defined('BASEPATH') or exit('No direct script access allowed');

class FSTB extends CI_Controller
{

    public function __construct() //092023
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));
        $this->load->library('session');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->data['title'] = 'SIPESUT | List Form Inspeksi & Serah Terima Barang';

        $this->load->model('SPPB_model');
        $this->load->model('FSTB_model');
        $this->load->model('Foto_model');
        $this->load->model('Proyek_model');
        $this->load->model('FSTB_form_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "FSTB_aktif";
    }

    /**
     * Log the user out
     */
    public function logout() //092023
    {
        $ID_FSTB = 0;
        $KETERANGAN = "Paksa Logout Ketika Akses FSTB";
        $this->user_log_fstb($ID_FSTB, $KETERANGAN);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log_fstb($ID_FSTB, $KETERANGAN) //112023
    {
        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->FSTB_model->user_log_fstb($user->ID_PEGAWAI, $ID_FSTB, $KETERANGAN, $WAKTU);
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index()//23092023 //BEDA KP DAN SP
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

        $ID_FSTB = 0;
        $KETERANGAN = "Melihat Halaman Index FISTB List: ";
        $this->user_log_fstb($ID_FSTB, $KETERANGAN);

        $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
        $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
        $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

        if ($this->ion_auth->logged_in()) {

            if ($this->ion_auth->is_admin()) { //admin
                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list();
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->Proyek_list();

                $this->load->view('wasa/user_admin/head_normal', $this->data);
                $this->load->view('wasa/user_admin/user_menu');
                $this->load->view('wasa/user_admin/left_menu');
                $this->load->view('wasa/user_admin/header_menu');
                $this->load->view('wasa/user_admin/content_fstb_list');
                $this->load->view('wasa/user_admin/footer');
            } else if ($this->ion_auth->in_group(5)) { //staff_procurement_kp
                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list();
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->Proyek_list();

                $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_kp/user_menu');
                $this->load->view('wasa/user_staff_procurement_kp/left_menu');
                $this->load->view('wasa/user_staff_procurement_kp/header_menu');
                $this->load->view('wasa/user_staff_procurement_kp/content_fstb_list');
                $this->load->view('wasa/user_staff_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(8)) { //user_staff_procurement_sp

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list_by_id_proyek($this->data['ID_PROYEK']);

                $this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_sp/user_menu');
                $this->load->view('wasa/user_staff_procurement_sp/left_menu');
                $this->load->view('wasa/user_staff_procurement_sp/header_menu');
                $this->load->view('wasa/user_staff_procurement_sp/content_fstb_list');
                $this->load->view('wasa/user_staff_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(9)) { //user_supervisi_procurement_sp
                
                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list_by_id_proyek($this->data['ID_PROYEK']);

                $this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/content_fstb_list');
                $this->load->view('wasa/user_supervisi_procurement_sp/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    function list_FSTB_by_all_proyek() //23092023
    {

        if ($this->ion_auth->logged_in()) {

            $data = $this->FSTB_model->list_FISTB_by_all_proyek();
            echo json_encode($data);

            $ID_FSTB = 0;
            $KETERANGAN = "list_FSTB_by_all_proyek: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);

        } else {
            // set the flash data error message if there is one
            $this->logout();
        }
    }

    function list_FSTB_by_id_proyek()//092023
    {

        if ($this->ion_auth->logged_in()) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $data = $this->FSTB_model->list_FSTB_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $ID_FSTB = 0;
            $KETERANGAN = "list_FSTB_by_id_proyek: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);

        } else {
            $this->logout();
        }
    }
    
    function data_qty_fstb_form() //092023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_FSTB = $this->input->post('ID_FSTB');
			$data = $this->FSTB_model->qty_fstb_form_by_id_fstb($ID_FSTB);
			echo json_encode($data);

            $ID_FSTB = $ID_FSTB;
			$KETERANGAN = "data_qty_fstb_form: " . json_encode($data);
			$this->user_log_fstb($ID_FSTB, $KETERANGAN);
		} else {
			$this->logout();
		}
	}

    function get_data_fstb_baru() //23092023
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $NO_URUT_FSTB);
            echo json_encode($data);

            $ID_FSTB = 0;
            $KETERANGAN = "get_data_fstb_baru: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_proyek() //092023
    {
        if ($this->ion_auth->logged_in()) { //staff_procurement_kp
            $data = $this->FSTB_model->get_data_proyek();
            echo json_encode($data);

            $ID_FSTB = 0;
            $KETERANGAN = "get_data_proyek: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_proyek_sp() //102023
    {
        if ($this->ion_auth->logged_in()) {
            
            $user = $this->ion_auth->user()->row();
            $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
            $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
            $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];

            $data = $this->FSTB_model->get_data_proyek_sp($this->data['ID_PROYEK']);
            echo json_encode($data);

        } else {
            $this->logout();
        }
    }

    function get_data_surat_jalan() //??
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin())) { //ADMINISTRATOR
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //staff_procurement_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) { //kasie_procurement_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) { //manajer_procurement_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //staff_procurement_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //supervisi_procurement_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_surat_jalan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Surat Jalan: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(18))) { //manajer_hrd_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(21))) { //manajer_keuangan_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(24))) { //manajer_konstruksi_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(27))) { //manajer_sdm_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(30))) { //manajer_qaqc_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(33))) { //manajer_ep_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(41))) { //manajer_hsse_kp
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $TANGGAL_PENGAJUAN_FSTB = $this->input->get('TANGGAL_PENGAJUAN_FSTB');
            $NO_URUT_FSTB = $this->input->get('NO_URUT_FSTB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FSTB_model->get_data_fstb_baru($ID_PROYEK, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FSTB Baru: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else {
            $this->logout();
        }
    }

    public function get_data_po() //092023
    {
        if ($this->ion_auth->logged_in()) { 
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->FSTB_model->get_data_po($ID_PROYEK);
            echo json_encode($data);

        } else {
            $this->logout();
        }
    }

    function get_data_vendor()//092023
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PO = $this->input->post('ID_PO');

            $data = $this->FSTB_model->get_data_vendor($ID_PO);
            echo json_encode($data);

            $ID_FSTB = 0;
            $KETERANGAN = "get_data_vendor: " . json_encode($data);
            $this->user_log_fstb($ID_FSTB, $KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function simpan_data()//092023
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->is_admin())) { //ADMINISTRATOR

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $CREATE_BY_USER = $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK', 'Nama Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PO', 'Nomor PO', 'trim|required');
            $this->form_validation->set_rules('ID_VENDOR', 'Nama Vendor', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_FSTB', 'No Urut FISTB', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_FSTB', 'Tanggal Dokumen FISTB', 'trim|required');
            $this->form_validation->set_rules('LOKASI_PENYERAHAN', 'Lokasi Serah Terima Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|max_length[20]|numeric|max_length[20]');
            $this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai Penerima Barang', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_SPP = $this->input->post('ID_SPP');
                $ID_PO = $this->input->post('ID_PO');
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
                $TANGGAL_DOKUMEN_FSTB = $this->input->post('TANGGAL_DOKUMEN_FSTB');
                $TANGGAL_PEMBUATAN_FSTB_HARI = date('Y-m-d');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $LOKASI_PENYERAHAN = $this->input->post('LOKASI_PENYERAHAN');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');

                $PROGRESS_FSTB = "Diproses oleh Staff Procurement KP";
                $STATUS_FSTB = "DRAFT";

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }
                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $ID_SPPB,
                        $ID_SPP,
                        $ID_PO,
                        $TANGGAL_DOKUMEN_FSTB,
                        $TANGGAL_PEMBUATAN_FSTB_HARI,
                        $NO_URUT_FSTB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $LOKASI_PENYERAHAN,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $NAMA_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "simpan_data: "
                        . "; " .$ID_PROYEK
                        . "; " .$ID_PROYEK_SUB_PEKERJAAN
                        . "; " .$ID_SPPB
                        . "; " .$ID_SPP
                        . "; " .$ID_PO
                        . "; " .$TANGGAL_DOKUMEN_FSTB
                        . "; " .$TANGGAL_PEMBUATAN_FSTB_HARI
                        . "; " .$NO_URUT_FSTB
                        . "; " .$CREATE_BY_USER
                        . "; " .$STATUS_FSTB
                        . "; " .$PROGRESS_FSTB
                        . "; " .$JUMLAH_COUNT
                        . "; " .$FILE_NAME_TEMP
                        . "; " .$ID_VENDOR
                        . "; " .$ID_SURAT_JALAN
                        . "; " .$NOMOR_SURAT_JALAN_VENDOR
                        . "; " .$LOKASI_PENYERAHAN
                        . "; " .$NAMA_PENGIRIM
                        . "; " .$NO_HP_PENGIRIM
                        . "; " .$NAMA_PEGAWAI
                        . "; " .$TANGGAL_BARANG_DATANG_HARI
                        . "; " .$SUMBER_PENERIMAAN;
                    $ID_FSTB = 0;
                    $this->user_log_fstb($ID_FSTB, $KETERANGAN);


                    $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    echo $hasil_2;

                    $ID_FSTB = 0;
                    $KETERANGAN = "set_md5_id_FSTB_dari_vendor: " . $ID_PROYEK . "; " . $NO_URUT_FSTB . ";" . $ID_PO . ";" . $CREATE_BY_USER;
                    $this->user_log_fstb($ID_FSTB, $KETERANGAN);

                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        }
        else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //staff_procurement_kp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $CREATE_BY_USER = $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK', 'Nama Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PO', 'Nomor PO', 'trim|required');
            $this->form_validation->set_rules('ID_VENDOR', 'Nama Vendor', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_FSTB', 'No Urut FISTB', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_FSTB', 'Tanggal Dokumen FISTB', 'trim|required');
            $this->form_validation->set_rules('LOKASI_PENYERAHAN', 'Lokasi Serah Terima Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|max_length[20]|numeric|max_length[20]');
            $this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai Penerima Barang', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_SPP = $this->input->post('ID_SPP');
                $ID_PO = $this->input->post('ID_PO');
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
                $TANGGAL_DOKUMEN_FSTB = $this->input->post('TANGGAL_DOKUMEN_FSTB');
                $TANGGAL_PEMBUATAN_FSTB_HARI = date('Y-m-d');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $LOKASI_PENYERAHAN = $this->input->post('LOKASI_PENYERAHAN');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');

                $PROGRESS_FSTB = "Diproses oleh Staff Procurement KP";
                $STATUS_FSTB = "DRAFT";

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }
                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $ID_SPPB,
                        $ID_SPP,
                        $ID_PO,
                        $TANGGAL_DOKUMEN_FSTB,
                        $TANGGAL_PEMBUATAN_FSTB_HARI,
                        $NO_URUT_FSTB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $LOKASI_PENYERAHAN,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $NAMA_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "simpan_data: "
                        . "; " .$ID_PROYEK
                        . "; " .$ID_PROYEK_SUB_PEKERJAAN
                        . "; " .$ID_SPPB
                        . "; " .$ID_SPP
                        . "; " .$ID_PO
                        . "; " .$TANGGAL_DOKUMEN_FSTB
                        . "; " .$TANGGAL_PEMBUATAN_FSTB_HARI
                        . "; " .$NO_URUT_FSTB
                        . "; " .$CREATE_BY_USER
                        . "; " .$STATUS_FSTB
                        . "; " .$PROGRESS_FSTB
                        . "; " .$JUMLAH_COUNT
                        . "; " .$FILE_NAME_TEMP
                        . "; " .$ID_VENDOR
                        . "; " .$ID_SURAT_JALAN
                        . "; " .$NOMOR_SURAT_JALAN_VENDOR
                        . "; " .$LOKASI_PENYERAHAN
                        . "; " .$NAMA_PENGIRIM
                        . "; " .$NO_HP_PENGIRIM
                        . "; " .$NAMA_PEGAWAI
                        . "; " .$TANGGAL_BARANG_DATANG_HARI
                        . "; " .$SUMBER_PENERIMAAN;
                    $ID_FSTB = 0;
                    $this->user_log_fstb($ID_FSTB, $KETERANGAN);


                    $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    echo $hasil_2;

                    $ID_FSTB = 0;
                    $KETERANGAN = "set_md5_id_FSTB_dari_vendor: " . $ID_PROYEK . "; " . $NO_URUT_FSTB . ";" . $ID_PO . ";" . $CREATE_BY_USER;
                    $this->user_log_fstb($ID_FSTB, $KETERANGAN);

                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        }
        else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //staff_procurement_sp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $CREATE_BY_USER = $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK', 'Nama Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PO', 'Nomor PO', 'trim|required');
            $this->form_validation->set_rules('ID_VENDOR', 'Nama Vendor', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_FSTB', 'No Urut FISTB', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_FSTB', 'Tanggal Dokumen FISTB', 'trim|required');
            $this->form_validation->set_rules('LOKASI_PENYERAHAN', 'Lokasi Serah Terima Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|max_length[20]|numeric|max_length[20]');
            $this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai Penerima Barang', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_SPP = $this->input->post('ID_SPP');
                $ID_PO = $this->input->post('ID_PO');
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
                $TANGGAL_DOKUMEN_FSTB = $this->input->post('TANGGAL_DOKUMEN_FSTB');
                $TANGGAL_PEMBUATAN_FSTB_HARI = date('Y-m-d');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $LOKASI_PENYERAHAN = $this->input->post('LOKASI_PENYERAHAN');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');

                $PROGRESS_FSTB = "Diproses oleh Staff Procurement SP";
                $STATUS_FSTB = "DRAFT";

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }
                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $ID_SPPB,
                        $ID_SPP,
                        $ID_PO,
                        $TANGGAL_DOKUMEN_FSTB,
                        $TANGGAL_PEMBUATAN_FSTB_HARI,
                        $NO_URUT_FSTB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $LOKASI_PENYERAHAN,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $NAMA_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "simpan_data: "
                        . "; " .$ID_PROYEK
                        . "; " .$ID_PROYEK_SUB_PEKERJAAN
                        . "; " .$ID_SPPB
                        . "; " .$ID_SPP
                        . "; " .$ID_PO
                        . "; " .$TANGGAL_DOKUMEN_FSTB
                        . "; " .$TANGGAL_PEMBUATAN_FSTB_HARI
                        . "; " .$NO_URUT_FSTB
                        . "; " .$CREATE_BY_USER
                        . "; " .$STATUS_FSTB
                        . "; " .$PROGRESS_FSTB
                        . "; " .$JUMLAH_COUNT
                        . "; " .$FILE_NAME_TEMP
                        . "; " .$ID_VENDOR
                        . "; " .$ID_SURAT_JALAN
                        . "; " .$NOMOR_SURAT_JALAN_VENDOR
                        . "; " .$LOKASI_PENYERAHAN
                        . "; " .$NAMA_PENGIRIM
                        . "; " .$NO_HP_PENGIRIM
                        . "; " .$NAMA_PEGAWAI
                        . "; " .$TANGGAL_BARANG_DATANG_HARI
                        . "; " .$SUMBER_PENERIMAAN;
                    $ID_FSTB = 0;
                    $this->user_log_fstb($ID_FSTB, $KETERANGAN);


                    $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    echo $hasil_2;

                    $ID_FSTB = 0;
                    $KETERANGAN = "set_md5_id_FSTB_dari_vendor: " . $ID_PROYEK . "; " . $NO_URUT_FSTB . ";" . $ID_PO . ";" . $CREATE_BY_USER;
                    $this->user_log_fstb($ID_FSTB, $KETERANGAN);

                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        }
        else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //supervisi_procurement_sp

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $CREATE_BY_USER = $this->data['USER_ID'];

            //set validation rules
            $this->form_validation->set_rules('SUMBER_PENERIMAAN', 'Sumber Penerimaan', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK', 'Nama Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PO', 'Nomor PO', 'trim|required');
            $this->form_validation->set_rules('ID_VENDOR', 'Nama Vendor', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_FSTB', 'No Urut FISTB', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_FSTB', 'Tanggal Dokumen FISTB', 'trim|required');
            $this->form_validation->set_rules('LOKASI_PENYERAHAN', 'Lokasi Serah Terima Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'No HP Pengirim', 'trim|max_length[20]|numeric|max_length[20]');
            $this->form_validation->set_rules('NAMA_PEGAWAI', 'Nama Pegawai Penerima Barang', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('TANGGAL_BARANG_DATANG_HARI', 'Tanggal Barang Datang', 'trim|required');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_SPP = $this->input->post('ID_SPP');
                $ID_PO = $this->input->post('ID_PO');
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
                $TANGGAL_DOKUMEN_FSTB = $this->input->post('TANGGAL_DOKUMEN_FSTB');
                $TANGGAL_PEMBUATAN_FSTB_HARI = date('Y-m-d');
                $NO_URUT_FSTB = $this->input->post('NO_URUT_FSTB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $LOKASI_PENYERAHAN = $this->input->post('LOKASI_PENYERAHAN');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                $NAMA_PEGAWAI = $this->input->post('NAMA_PEGAWAI');
                $TANGGAL_BARANG_DATANG_HARI = $this->input->post('TANGGAL_BARANG_DATANG_HARI');
                $SUMBER_PENERIMAAN = $this->input->post('SUMBER_PENERIMAAN');

                $PROGRESS_FSTB = "Diproses oleh Supervisi Procurement SP";
                $STATUS_FSTB = "DRAFT";

                if ($this->input->post('ID_SURAT_JALAN_1') != '') {
                    $ID_SURAT_JALAN = $this->input->post('ID_SURAT_JALAN_1');
                } else {
                    $ID_SURAT_JALAN = '';
                }

                if ($this->input->post('NOMOR_SURAT_JALAN_VENDOR_1') != '') {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_1');
                } else {
                    $NOMOR_SURAT_JALAN_VENDOR = $this->input->post('NOMOR_SURAT_JALAN_VENDOR_2');
                }
                //check apakah nomor FSTB sudah ada. jika belum ada, akan disimpan.
                if ($this->FSTB_model->cek_no_urut_FSTB($NO_URUT_FSTB) == 'Data belum ada') {

                    $hasil = $this->FSTB_model->simpan_data(
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $ID_SPPB,
                        $ID_SPP,
                        $ID_PO,
                        $TANGGAL_DOKUMEN_FSTB,
                        $TANGGAL_PEMBUATAN_FSTB_HARI,
                        $NO_URUT_FSTB,
                        $CREATE_BY_USER,
                        $STATUS_FSTB,
                        $PROGRESS_FSTB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $ID_VENDOR,
                        $ID_SURAT_JALAN,
                        $NOMOR_SURAT_JALAN_VENDOR,
                        $LOKASI_PENYERAHAN,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $NAMA_PEGAWAI,
                        $TANGGAL_BARANG_DATANG_HARI,
                        $SUMBER_PENERIMAAN
                    );

                    $KETERANGAN = "simpan_data: "
                        . "; " .$ID_PROYEK
                        . "; " .$ID_PROYEK_SUB_PEKERJAAN
                        . "; " .$ID_SPPB
                        . "; " .$ID_SPP
                        . "; " .$ID_PO
                        . "; " .$TANGGAL_DOKUMEN_FSTB
                        . "; " .$TANGGAL_PEMBUATAN_FSTB_HARI
                        . "; " .$NO_URUT_FSTB
                        . "; " .$CREATE_BY_USER
                        . "; " .$STATUS_FSTB
                        . "; " .$PROGRESS_FSTB
                        . "; " .$JUMLAH_COUNT
                        . "; " .$FILE_NAME_TEMP
                        . "; " .$ID_VENDOR
                        . "; " .$ID_SURAT_JALAN
                        . "; " .$NOMOR_SURAT_JALAN_VENDOR
                        . "; " .$LOKASI_PENYERAHAN
                        . "; " .$NAMA_PENGIRIM
                        . "; " .$NO_HP_PENGIRIM
                        . "; " .$NAMA_PEGAWAI
                        . "; " .$TANGGAL_BARANG_DATANG_HARI
                        . "; " .$SUMBER_PENERIMAAN;
                    $ID_FSTB = 0;
                    $this->user_log_fstb($ID_FSTB, $KETERANGAN);


                    $hasil_2 = $this->FSTB_model->set_md5_id_FSTB_dari_vendor($ID_PROYEK, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER);
                    echo $hasil_2;

                    $ID_FSTB = 0;
                    $KETERANGAN = "set_md5_id_FSTB_dari_vendor: " . $ID_PROYEK . "; " . $NO_URUT_FSTB . ";" . $ID_PO . ";" . $CREATE_BY_USER;
                    $this->user_log_fstb($ID_FSTB, $KETERANGAN);

                } else {
                    echo 'Nomor Urut FSTB sudah terekam sebelumnya';
                }
            }
        }
        else {
            $this->logout();
        }
    }
}
