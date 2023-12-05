<?php defined('BASEPATH') or exit('No direct script access allowed');

class Surat_Jalan extends CI_Controller
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
        $this->data['title'] = 'SIPESUT | List Surat Jalan';

        $this->load->model('RASD_model');
        $this->load->model('Surat_Jalan_model');
        $this->load->model('Foto_model');
        $this->load->model('Jenis_barang_model');
        $this->load->model('Khp_model');
        $this->load->model('Proyek_model');
        $this->load->model('Surat_Jalan_form_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');
        $this->load->model('PO_model');
        $this->load->model('SPPB_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "Surat_Jalan_aktif";
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses SURAT_JALAN";
        $WAKTU = date('Y-m-d H:i:s');
        $this->Surat_Jalan_model->user_log_Surat_Jalan($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->Surat_Jalan_model->user_log_surat_jalan($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

        $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
        $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
        $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

        $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
        $this->data['INISIAL'] = $data_proyek['INISIAL'];
        $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

        $this->data['no_po_list'] = $this->PO_model->po_list($this->data['ID_PROYEK']);
        $this->data['sppb_list'] = $this->SPPB_model->sppb_list();
        $this->data['sppb_list_by_id_proyek'] = $this->SPPB_model->sppb_list_by_id_proyek($this->data['ID_PROYEK']);

        $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
        $sess_data['USER_ID'] = $this->data['USER_ID'];
        $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
        $this->session->set_userdata($sess_data);

        if ($this->ion_auth->logged_in()) {
            //fungsi ini untuk mengirim data ke dropdown

            if ($this->ion_auth->in_group(10)) { //staff logistik kp
                $this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/content_surat_jalan_list');
                $this->load->view('wasa/user_staff_umum_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(11)) { //kasie logistik kp
                $this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_kasie_logistik_kp/user_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/left_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/header_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/content_surat_jalan_list');
                $this->load->view('wasa/user_kasie_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(12)) { //manajer logistik kp
                $this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_logistik_kp/user_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/left_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/header_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/content_surat_jalan_list');
                $this->load->view('wasa/user_manajer_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(13)) { //staff umum logistik sp
                $this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/content_surat_jalan_list');
                $this->load->view('wasa/user_staff_umum_logistik_sp/footer');
            } else if ($this->ion_auth->in_group(15)) { //supervisi logistik sp
                $this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/content_surat_jalan_list');
                $this->load->view('wasa/user_supervisi_logistik_sp/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    function data_surat_jalan()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

            // $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            // $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->Surat_Jalan_model->surat_jalan_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

            // $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            // $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->Surat_Jalan_model->surat_jalan_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

            // $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            // $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->Surat_Jalan_model->surat_jalan_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

            $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            $data = $this->Surat_Jalan_model->surat_jalan_list_by_ID_PROYEK($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

            $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            $data = $this->Surat_Jalan_model->surat_jalan_list_by_ID_PROYEK($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_surat_jalan_baru()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {
            $ID_PROYEK_SURAT_JALAN = $this->input->get('ID_PROYEK_SURAT_JALAN');
            $TANGGAL_PENGAJUAN_SURAT_JALAN = $this->input->get('TANGGAL_PENGAJUAN_SURAT_JALAN');
            $NO_SURAT_JALAN = $this->input->get('NO_SURAT_JALAN');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->Surat_Jalan_model->get_data_surat_jalan_baru($ID_PROYEK_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN, $NO_SURAT_JALAN, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Surat Jalan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {
            $ID_PROYEK_SURAT_JALAN = $this->input->get('ID_PROYEK_SURAT_JALAN');
            $TANGGAL_PENGAJUAN_SURAT_JALAN = $this->input->get('TANGGAL_PENGAJUAN_SURAT_JALAN');
            $NO_SURAT_JALAN = $this->input->get('NO_SURAT_JALAN');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->Surat_Jalan_model->get_data_surat_jalan_baru($ID_PROYEK_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN, $NO_SURAT_JALAN, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Surat Jalan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {
            $ID_PROYEK_SURAT_JALAN = $this->input->get('ID_PROYEK_SURAT_JALAN');
            $TANGGAL_PENGAJUAN_SURAT_JALAN = $this->input->get('TANGGAL_PENGAJUAN_SURAT_JALAN');
            $NO_SURAT_JALAN = $this->input->get('NO_SURAT_JALAN');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->Surat_Jalan_model->get_data_surat_jalan_baru($ID_PROYEK_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN, $NO_SURAT_JALAN, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Surat Jalan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {
            $ID_PROYEK_SURAT_JALAN = $this->input->get('ID_PROYEK_SURAT_JALAN');
            $TANGGAL_PENGAJUAN_SURAT_JALAN = $this->input->get('TANGGAL_PENGAJUAN_SURAT_JALAN');
            $NO_SURAT_JALAN = $this->input->get('NO_SURAT_JALAN');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->Surat_Jalan_model->get_data_surat_jalan_baru($ID_PROYEK_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN, $NO_SURAT_JALAN, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Surat Jalan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {
            $ID_PROYEK_SURAT_JALAN = $this->input->get('ID_PROYEK_SURAT_JALAN');
            $TANGGAL_PENGAJUAN_SURAT_JALAN = $this->input->get('TANGGAL_PENGAJUAN_SURAT_JALAN');
            $NO_SURAT_JALAN = $this->input->get('NO_SURAT_JALAN');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->Surat_Jalan_model->get_data_surat_jalan_baru($ID_PROYEK_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN, $NO_SURAT_JALAN, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Surat Jalan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_nomor_urut()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PROYEK_SURAT_JALAN = $this->input->get('id');

            $data = $this->Surat_Jalan_model->get_nomor_urut_by_ID_PROYEK($ID_PROYEK_SURAT_JALAN);
            echo json_encode($data);

            $KETERANGAN = "Get Nomor Urut Surat Jalan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_proyek()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp
            $data = $this->Surat_Jalan_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp
            $data = $this->Surat_Jalan_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp
            $data = $this->Surat_Jalan_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $data = $this->Surat_Jalan_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $data = $this->Surat_Jalan_model->get_data_proyek();
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_vendor()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp

            $data = $this->Surat_Jalan_model->get_data_vendor();
            echo json_encode($data);

            $KETERANGAN = "Get Data Vendor: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp
            $data = $this->Surat_Jalan_model->get_data_vendor();
            echo json_encode($data);

            $KETERANGAN = "Get Data Vendor: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp
            $data = $this->Surat_Jalan_model->get_data_vendor();
            echo json_encode($data);

            $KETERANGAN = "Get Data Vendor: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $data = $this->Surat_Jalan_model->get_data_vendor();
            echo json_encode($data);

            $KETERANGAN = "Get Data Vendor: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $data = $this->Surat_Jalan_model->get_data_vendor();
            echo json_encode($data);

            $KETERANGAN = "Get Data Vendor: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_sppb()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->Surat_Jalan_model->get_data_sppb($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->Surat_Jalan_model->get_data_sppb($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->Surat_Jalan_model->get_data_sppb($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->Surat_Jalan_model->get_data_sppb($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->Surat_Jalan_model->get_data_sppb($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_lokasi_penyerahan()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //staff_umum_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->Surat_Jalan_model->get_data_lokasi_penyerahan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Lokasi Penyerahan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //kasie_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->Surat_Jalan_model->get_data_lokasi_penyerahan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Lokasi Penyerahan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //manajer_logistik_kp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->Surat_Jalan_model->get_data_lokasi_penyerahan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Lokasi Penyerahan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //staff_umum_logistik_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->Surat_Jalan_model->get_data_lokasi_penyerahan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Lokasi Penyerahan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //supervisi_logistik_sp
            $ID_PROYEK = $this->input->post('ID_PROYEK');

            $data = $this->Surat_Jalan_model->get_data_lokasi_penyerahan($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data Lokasi Penyerahan: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function simpan_data()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_SURAT_JALAN', 'Tanggal Pembuatan Surat Jalan', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('MAKSUD_PENGIRIMAN', 'Maksud Pengiriman', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('NO_SURAT_JALAN', 'Nomor Surat Jalan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_SURAT_JALAN_HARI', 'Tanggal Surat Jalan', 'trim|required');
            $this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('PIC_PENERIMA_BARANG', 'PIC Penerima Barang', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PIC', 'NO HP PIC', 'trim|required|max_length[20]|numeric');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $TANGGAL_PENGAJUAN_SURAT_JALAN = $this->input->post('TANGGAL_PENGAJUAN_SURAT_JALAN');
                $NO_SURAT_JALAN = $this->input->post('NO_SURAT_JALAN');
                $NO_DELIVERY_NOTE = $this->input->post('NO_DELIVERY_NOTE');
                $NO_PACKING_LIST = $this->input->post('NO_PACKING_LIST');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_DELIVERY_NOTE = $this->input->post('FILE_NAME_TEMP_DELIVERY_NOTE');
                $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $ID_SPPB = $this->input->post('ID_SPPB_1');
                $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                $ID_PROYEK_SURAT_JALAN = $this->input->post('ID_PROYEK_SURAT_JALAN');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $KEPADA = $this->input->post('KEPADA');
                $PIC_PENERIMA_BARANG = $this->input->post('PIC_PENERIMA_BARANG');
                $NO_HP_PIC = $this->input->post('NO_HP_PIC');
                $TANGGAL_SURAT_JALAN_HARI = $this->input->post('TANGGAL_SURAT_JALAN_HARI');
                $MAKSUD_PENGIRIMAN = $this->input->post('MAKSUD_PENGIRIMAN');

                $CREATE_BY_USER =  $this->data['USER_ID'];
                if ($this->ion_auth->in_group(10)) {
                    $PROGRESS_SURAT_JALAN = "Dalam Proses Staff Logistik KP";
                    $STATUS_SURAT_JALAN = "DRAFT";
                }

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK');
                }

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Surat_Jalan_model->cek_no_urut_Surat_Jalan($NO_SURAT_JALAN) == 'Data belum ada') {

                    $hasil = $this->Surat_Jalan_model->simpan_data(
                        $ID_PROYEK,
                        $ID_PROYEK_SURAT_JALAN,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $TANGGAL_PENGAJUAN_SURAT_JALAN,
                        $NO_SURAT_JALAN,
                        $NO_DELIVERY_NOTE,
                        $NO_PACKING_LIST,
                        $CREATE_BY_USER,
                        $STATUS_SURAT_JALAN,
                        $PROGRESS_SURAT_JALAN,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_DELIVERY_NOTE,
                        $FILE_NAME_TEMP_PACKING_LIST,
                        $ID_SPPB,
                        $ID_VENDOR,
                        $KEPADA,
                        $PIC_PENERIMA_BARANG,
                        $NO_HP_PIC,
                        $TANGGAL_SURAT_JALAN_HARI
                    );

                    $KETERANGAN = "Simpan Surat Jalan: "
                        . "; " . $ID_PROYEK
                        . "; " . $TANGGAL_PENGAJUAN_SURAT_JALAN
                        . "; " . $NO_SURAT_JALAN
                        . "; " . $NO_DELIVERY_NOTE
                        . "; " . $NO_PACKING_LIST
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_SURAT_JALAN
                        . "; " . $PROGRESS_SURAT_JALAN
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_DELIVERY_NOTE
                        . "; " . $FILE_NAME_TEMP_PACKING_LIST
                        . "; " . $ID_SPPB
                        . "; " . $KEPADA
                        . "; " . $PIC_PENERIMA_BARANG
                        . "; " . $NO_HP_PIC
                        . "; " . $TANGGAL_SURAT_JALAN_HARI;
                    $this->user_log($KETERANGAN);

                    if ($MAKSUD_PENGIRIMAN == 'Pengiriman Ke Site Project') {
                        $hasil_2 = $this->Surat_Jalan_model->set_md5_id_Surat_Jalan_ke_sp($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $ID_SPPB, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->Surat_Jalan_model->set_md5_id_Surat_Jalan($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $NO_SURAT_JALAN, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 Surat Jalan: " . $ID_PROYEK . "; " . $NO_SURAT_JALAN
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut Surat Jalan sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_SURAT_JALAN', 'Tanggal Pembuatan Surat Jalan', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('MAKSUD_PENGIRIMAN', 'Maksud Pengiriman', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('NO_SURAT_JALAN', 'Nomor Surat Jalan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_SURAT_JALAN_HARI', 'Tanggal Surat Jalan', 'trim|required');
            $this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('PIC_PENERIMA_BARANG', 'PIC Penerima Barang', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PIC', 'NO HP PIC', 'trim|required|max_length[20]|numeric');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $TANGGAL_PENGAJUAN_SURAT_JALAN = $this->input->post('TANGGAL_PENGAJUAN_SURAT_JALAN');
                $NO_SURAT_JALAN = $this->input->post('NO_SURAT_JALAN');
                $NO_DELIVERY_NOTE = $this->input->post('NO_DELIVERY_NOTE');
                $NO_PACKING_LIST = $this->input->post('NO_PACKING_LIST');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_DELIVERY_NOTE = $this->input->post('FILE_NAME_TEMP_DELIVERY_NOTE');
                $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $ID_SPPB = $this->input->post('ID_SPPB_1');
                $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                $ID_PROYEK_SURAT_JALAN = $this->input->post('ID_PROYEK_SURAT_JALAN');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $KEPADA = $this->input->post('KEPADA');
                $PIC_PENERIMA_BARANG = $this->input->post('PIC_PENERIMA_BARANG');
                $NO_HP_PIC = $this->input->post('NO_HP_PIC');
                $TANGGAL_SURAT_JALAN_HARI = $this->input->post('TANGGAL_SURAT_JALAN_HARI');
                $MAKSUD_PENGIRIMAN = $this->input->post('MAKSUD_PENGIRIMAN');

                $CREATE_BY_USER =  $this->data['USER_ID'];
                if ($this->ion_auth->in_group(11)) {
                    $PROGRESS_SURAT_JALAN = "Dalam Proses Kasie Logistik KP";
                    $STATUS_SURAT_JALAN = "DRAFT";
                }

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK');
                }

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Surat_Jalan_model->cek_no_urut_Surat_Jalan($NO_SURAT_JALAN) == 'Data belum ada') {

                    $hasil = $this->Surat_Jalan_model->simpan_data(
                        $ID_PROYEK,
                        $ID_PROYEK_SURAT_JALAN,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $TANGGAL_PENGAJUAN_SURAT_JALAN,
                        $NO_SURAT_JALAN,
                        $NO_DELIVERY_NOTE,
                        $NO_PACKING_LIST,
                        $CREATE_BY_USER,
                        $STATUS_SURAT_JALAN,
                        $PROGRESS_SURAT_JALAN,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_DELIVERY_NOTE,
                        $FILE_NAME_TEMP_PACKING_LIST,
                        $ID_SPPB,
                        $ID_VENDOR,
                        $KEPADA,
                        $PIC_PENERIMA_BARANG,
                        $NO_HP_PIC,
                        $TANGGAL_SURAT_JALAN_HARI
                    );

                    $KETERANGAN = "Simpan Surat Jalan: "
                        . "; " . $ID_PROYEK
                        . "; " . $TANGGAL_PENGAJUAN_SURAT_JALAN
                        . "; " . $NO_SURAT_JALAN
                        . "; " . $NO_DELIVERY_NOTE
                        . "; " . $NO_PACKING_LIST
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_SURAT_JALAN
                        . "; " . $PROGRESS_SURAT_JALAN
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_DELIVERY_NOTE
                        . "; " . $FILE_NAME_TEMP_PACKING_LIST
                        . "; " . $ID_SPPB
                        . "; " . $KEPADA
                        . "; " . $PIC_PENERIMA_BARANG
                        . "; " . $NO_HP_PIC
                        . "; " . $TANGGAL_SURAT_JALAN_HARI;
                    $this->user_log($KETERANGAN);

                    if ($MAKSUD_PENGIRIMAN == 'Pengiriman Ke Site Project') {
                        $hasil_2 = $this->Surat_Jalan_model->set_md5_id_Surat_Jalan_ke_sp($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $ID_SPPB, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->Surat_Jalan_model->set_md5_id_Surat_Jalan($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $NO_SURAT_JALAN, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 Surat Jalan: " . $ID_PROYEK . "; " . $NO_SURAT_JALAN
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut Surat Jalan sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_SURAT_JALAN', 'Tanggal Pembuatan Surat Jalan', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('MAKSUD_PENGIRIMAN', 'Maksud Pengiriman', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('NO_SURAT_JALAN', 'Nomor Surat Jalan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_SURAT_JALAN_HARI', 'Tanggal Surat Jalan', 'trim|required');
            $this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('PIC_PENERIMA_BARANG', 'PIC Penerima Barang', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PIC', 'NO HP PIC', 'trim|required|max_length[20]|numeric');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $TANGGAL_PENGAJUAN_SURAT_JALAN = $this->input->post('TANGGAL_PENGAJUAN_SURAT_JALAN');
                $NO_SURAT_JALAN = $this->input->post('NO_SURAT_JALAN');
                $NO_DELIVERY_NOTE = $this->input->post('NO_DELIVERY_NOTE');
                $NO_PACKING_LIST = $this->input->post('NO_PACKING_LIST');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_DELIVERY_NOTE = $this->input->post('FILE_NAME_TEMP_DELIVERY_NOTE');
                $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $ID_SPPB = $this->input->post('ID_SPPB_1');
                $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                $ID_PROYEK_SURAT_JALAN = $this->input->post('ID_PROYEK_SURAT_JALAN');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $KEPADA = $this->input->post('KEPADA');
                $PIC_PENERIMA_BARANG = $this->input->post('PIC_PENERIMA_BARANG');
                $NO_HP_PIC = $this->input->post('NO_HP_PIC');
                $TANGGAL_SURAT_JALAN_HARI = $this->input->post('TANGGAL_SURAT_JALAN_HARI');
                $MAKSUD_PENGIRIMAN = $this->input->post('MAKSUD_PENGIRIMAN');

                $CREATE_BY_USER =  $this->data['USER_ID'];
                if ($this->ion_auth->in_group(12)) {
                    $PROGRESS_SURAT_JALAN = "Dalam Proses Manajer Logistik KP";
                    $STATUS_SURAT_JALAN = "DRAFT";
                }

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK');
                }

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Surat_Jalan_model->cek_no_urut_Surat_Jalan($NO_SURAT_JALAN) == 'Data belum ada') {

                    $hasil = $this->Surat_Jalan_model->simpan_data(
                        $ID_PROYEK,
                        $ID_PROYEK_SURAT_JALAN,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $TANGGAL_PENGAJUAN_SURAT_JALAN,
                        $NO_SURAT_JALAN,
                        $NO_DELIVERY_NOTE,
                        $NO_PACKING_LIST,
                        $CREATE_BY_USER,
                        $STATUS_SURAT_JALAN,
                        $PROGRESS_SURAT_JALAN,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_DELIVERY_NOTE,
                        $FILE_NAME_TEMP_PACKING_LIST,
                        $ID_SPPB,
                        $ID_VENDOR,
                        $KEPADA,
                        $PIC_PENERIMA_BARANG,
                        $NO_HP_PIC,
                        $TANGGAL_SURAT_JALAN_HARI
                    );

                    $KETERANGAN = "Simpan Surat Jalan: "
                        . "; " . $ID_PROYEK
                        . "; " . $TANGGAL_PENGAJUAN_SURAT_JALAN
                        . "; " . $NO_SURAT_JALAN
                        . "; " . $NO_DELIVERY_NOTE
                        . "; " . $NO_PACKING_LIST
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_SURAT_JALAN
                        . "; " . $PROGRESS_SURAT_JALAN
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_DELIVERY_NOTE
                        . "; " . $FILE_NAME_TEMP_PACKING_LIST
                        . "; " . $ID_SPPB
                        . "; " . $KEPADA
                        . "; " . $PIC_PENERIMA_BARANG
                        . "; " . $NO_HP_PIC
                        . "; " . $TANGGAL_SURAT_JALAN_HARI;
                    $this->user_log($KETERANGAN);

                    if ($MAKSUD_PENGIRIMAN == 'Pengiriman Ke Site Project') {
                        $hasil_2 = $this->Surat_Jalan_model->set_md5_id_Surat_Jalan_ke_sp($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $ID_SPPB, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->Surat_Jalan_model->set_md5_id_Surat_Jalan($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $NO_SURAT_JALAN, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 Surat Jalan: " . $ID_PROYEK . "; " . $NO_SURAT_JALAN
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut Surat Jalan sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_SURAT_JALAN', 'Tanggal Pembuatan Surat Jalan', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('MAKSUD_PENGIRIMAN', 'Maksud Pengiriman', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('NO_SURAT_JALAN', 'Nomor Surat Jalan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_SURAT_JALAN_HARI', 'Tanggal Surat Jalan', 'trim|required');
            $this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('PIC_PENERIMA_BARANG', 'PIC Penerima Barang', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PIC', 'NO HP PIC', 'trim|required|max_length[20]|numeric');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $TANGGAL_PENGAJUAN_SURAT_JALAN = $this->input->post('TANGGAL_PENGAJUAN_SURAT_JALAN');
                $NO_SURAT_JALAN = $this->input->post('NO_SURAT_JALAN');
                $NO_DELIVERY_NOTE = $this->input->post('NO_DELIVERY_NOTE');
                $NO_PACKING_LIST = $this->input->post('NO_PACKING_LIST');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_DELIVERY_NOTE = $this->input->post('FILE_NAME_TEMP_DELIVERY_NOTE');
                $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $ID_SPPB = $this->input->post('ID_SPPB_1');
                $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                $ID_PROYEK_SURAT_JALAN = $this->input->post('ID_PROYEK_SURAT_JALAN');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $KEPADA = $this->input->post('KEPADA');
                $PIC_PENERIMA_BARANG = $this->input->post('PIC_PENERIMA_BARANG');
                $NO_HP_PIC = $this->input->post('NO_HP_PIC');
                $TANGGAL_SURAT_JALAN_HARI = $this->input->post('TANGGAL_SURAT_JALAN_HARI');
                $MAKSUD_PENGIRIMAN = $this->input->post('MAKSUD_PENGIRIMAN');

                $CREATE_BY_USER =  $this->data['USER_ID'];
                if ($this->ion_auth->in_group(13)) {
                    $PROGRESS_SURAT_JALAN = "Dalam Proses Staff Umum Logistik SP";
                    $STATUS_SURAT_JALAN = "DRAFT";
                }

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK');
                }

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Surat_Jalan_model->cek_no_urut_Surat_Jalan($NO_SURAT_JALAN) == 'Data belum ada') {

                    $hasil = $this->Surat_Jalan_model->simpan_data(
                        $ID_PROYEK,
                        $ID_PROYEK_SURAT_JALAN,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $TANGGAL_PENGAJUAN_SURAT_JALAN,
                        $NO_SURAT_JALAN,
                        $NO_DELIVERY_NOTE,
                        $NO_PACKING_LIST,
                        $CREATE_BY_USER,
                        $STATUS_SURAT_JALAN,
                        $PROGRESS_SURAT_JALAN,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_DELIVERY_NOTE,
                        $FILE_NAME_TEMP_PACKING_LIST,
                        $ID_SPPB,
                        $ID_VENDOR,
                        $KEPADA,
                        $PIC_PENERIMA_BARANG,
                        $NO_HP_PIC,
                        $TANGGAL_SURAT_JALAN_HARI
                    );

                    $KETERANGAN = "Simpan Surat Jalan: "
                        . "; " . $ID_PROYEK
                        . "; " . $TANGGAL_PENGAJUAN_SURAT_JALAN
                        . "; " . $NO_SURAT_JALAN
                        . "; " . $NO_DELIVERY_NOTE
                        . "; " . $NO_PACKING_LIST
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_SURAT_JALAN
                        . "; " . $PROGRESS_SURAT_JALAN
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_DELIVERY_NOTE
                        . "; " . $FILE_NAME_TEMP_PACKING_LIST
                        . "; " . $ID_SPPB
                        . "; " . $KEPADA
                        . "; " . $PIC_PENERIMA_BARANG
                        . "; " . $NO_HP_PIC
                        . "; " . $TANGGAL_SURAT_JALAN_HARI;
                    $this->user_log($KETERANGAN);

                    if ($MAKSUD_PENGIRIMAN == 'Pengiriman Ke Site Project') {
                        $hasil_2 = $this->Surat_Jalan_model->set_md5_id_Surat_Jalan_ke_sp($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $ID_SPPB, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->Surat_Jalan_model->set_md5_id_Surat_Jalan($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $NO_SURAT_JALAN, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 Surat Jalan: " . $ID_PROYEK . "; " . $NO_SURAT_JALAN
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut Surat Jalan sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_PENGAJUAN_SURAT_JALAN', 'Tanggal Pembuatan Surat Jalan', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('MAKSUD_PENGIRIMAN', 'Maksud Pengiriman', 'trim|required|max_length[100]');
            // $this->form_validation->set_rules('ID_SPPB', 'Nomor Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('NO_SURAT_JALAN', 'Nomor Surat Jalan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_SURAT_JALAN_HARI', 'Tanggal Surat Jalan', 'trim|required');
            $this->form_validation->set_rules('KEPADA', 'Kepada', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('PIC_PENERIMA_BARANG', 'PIC Penerima Barang', 'trim|required');
            $this->form_validation->set_rules('NO_HP_PIC', 'NO HP PIC', 'trim|required|max_length[20]|numeric');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $TANGGAL_PENGAJUAN_SURAT_JALAN = $this->input->post('TANGGAL_PENGAJUAN_SURAT_JALAN');
                $NO_SURAT_JALAN = $this->input->post('NO_SURAT_JALAN');
                $NO_DELIVERY_NOTE = $this->input->post('NO_DELIVERY_NOTE');
                $NO_PACKING_LIST = $this->input->post('NO_PACKING_LIST');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $FILE_NAME_TEMP_DELIVERY_NOTE = $this->input->post('FILE_NAME_TEMP_DELIVERY_NOTE');
                $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $ID_SPPB = $this->input->post('ID_SPPB_1');
                $ID_VENDOR = $this->input->post('ID_VENDOR_2');
                $ID_PROYEK_SURAT_JALAN = $this->input->post('ID_PROYEK_SURAT_JALAN');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $KEPADA = $this->input->post('KEPADA');
                $PIC_PENERIMA_BARANG = $this->input->post('PIC_PENERIMA_BARANG');
                $NO_HP_PIC = $this->input->post('NO_HP_PIC');
                $TANGGAL_SURAT_JALAN_HARI = $this->input->post('TANGGAL_SURAT_JALAN_HARI');
                $MAKSUD_PENGIRIMAN = $this->input->post('MAKSUD_PENGIRIMAN');

                $CREATE_BY_USER =  $this->data['USER_ID'];
                if ($this->ion_auth->in_group(15)) {
                    $PROGRESS_SURAT_JALAN = "Dalam Proses Supervisor Logistik SP";
                    $STATUS_SURAT_JALAN = "DRAFT";
                }

                if ($this->input->post('ID_PROYEK_1') != '') {
                    $ID_PROYEK = $this->input->post('ID_PROYEK_1');
                } else {
                    $ID_PROYEK = $this->input->post('ID_PROYEK');
                }

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Surat_Jalan_model->cek_no_urut_Surat_Jalan($NO_SURAT_JALAN) == 'Data belum ada') {

                    $hasil = $this->Surat_Jalan_model->simpan_data(
                        $ID_PROYEK,
                        $ID_PROYEK_SURAT_JALAN,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $TANGGAL_PENGAJUAN_SURAT_JALAN,
                        $NO_SURAT_JALAN,
                        $NO_DELIVERY_NOTE,
                        $NO_PACKING_LIST,
                        $CREATE_BY_USER,
                        $STATUS_SURAT_JALAN,
                        $PROGRESS_SURAT_JALAN,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP,
                        $FILE_NAME_TEMP_DELIVERY_NOTE,
                        $FILE_NAME_TEMP_PACKING_LIST,
                        $ID_SPPB,
                        $ID_VENDOR,
                        $KEPADA,
                        $PIC_PENERIMA_BARANG,
                        $NO_HP_PIC,
                        $TANGGAL_SURAT_JALAN_HARI
                    );

                    $KETERANGAN = "Simpan Surat Jalan: "
                        . "; " . $ID_PROYEK
                        . "; " . $TANGGAL_PENGAJUAN_SURAT_JALAN
                        . "; " . $NO_SURAT_JALAN
                        . "; " . $NO_DELIVERY_NOTE
                        . "; " . $NO_PACKING_LIST
                        . "; " . $CREATE_BY_USER
                        . "; " . $STATUS_SURAT_JALAN
                        . "; " . $PROGRESS_SURAT_JALAN
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP
                        . "; " . $FILE_NAME_TEMP_DELIVERY_NOTE
                        . "; " . $FILE_NAME_TEMP_PACKING_LIST
                        . "; " . $ID_SPPB
                        . "; " . $KEPADA
                        . "; " . $PIC_PENERIMA_BARANG
                        . "; " . $NO_HP_PIC
                        . "; " . $TANGGAL_SURAT_JALAN_HARI;
                    $this->user_log($KETERANGAN);

                    if ($MAKSUD_PENGIRIMAN == 'Pengiriman Ke Site Project') {
                        $hasil_2 = $this->Surat_Jalan_model->set_md5_id_Surat_Jalan_ke_sp($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $ID_SPPB, $CREATE_BY_USER);
                    } else {
                        $hasil_2 = $this->Surat_Jalan_model->set_md5_id_Surat_Jalan($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $NO_SURAT_JALAN, $CREATE_BY_USER);
                    }

                    $KETERANGAN = "Update MD5 Surat Jalan: " . $ID_PROYEK . "; " . $NO_SURAT_JALAN
                        . ";" . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut Surat Jalan sudah terekam sebelumnya';
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
