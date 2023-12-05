<?php defined('BASEPATH') or exit('No direct script access allowed');

class Barang_master extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->data['title'] = 'SIPESUT | Barang Master';

        $this->load->model('Barang_master_model');
        $this->load->model('Barang_master_file_model');
        $this->load->model('Foto_model');
        $this->load->model('Jenis_barang_model');
        $this->load->model('Satuan_barang_model');

        $this->load->model('Manajemen_user_model');
        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "barang_master_aktif";
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses Proyek";
        $WAKTU = date('Y-m-d H:i:s');
        $this->Barang_master_model->user_log_barang_master($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->Barang_master_model->user_log_barang_master($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

            $this->load->view('wasa/user_admin/head_normal', $this->data);
            $this->load->view('wasa/user_admin/user_menu');
            $this->load->view('wasa/user_admin/left_menu');
            $this->load->view('wasa/user_admin/header_menu');
            $this->load->view('wasa/user_admin/content_barang_master_list');
            $this->load->view('wasa/user_admin/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

            $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_procurement_kp/user_menu');
            $this->load->view('wasa/user_staff_procurement_kp/left_menu');
            $this->load->view('wasa/user_staff_procurement_kp/header_menu');
            $this->load->view('wasa/user_staff_procurement_kp/content_barang_master_list');
            $this->load->view('wasa/user_staff_procurement_kp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

            $this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
            $this->load->view('wasa/user_kasie_procurement_kp/user_menu');
            $this->load->view('wasa/user_kasie_procurement_kp/left_menu');
            $this->load->view('wasa/user_kasie_procurement_kp/header_menu');
            $this->load->view('wasa/user_kasie_procurement_kp/content_barang_master_list');
            $this->load->view('wasa/user_kasie_procurement_kp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

            $this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
            $this->load->view('wasa/user_manajer_procurement_kp/user_menu');
            $this->load->view('wasa/user_manajer_procurement_kp/left_menu');
            $this->load->view('wasa/user_manajer_procurement_kp/header_menu');
            $this->load->view('wasa/user_manajer_procurement_kp/content_barang_master_list');
            $this->load->view('wasa/user_manajer_procurement_kp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

            $this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_procurement_sp/user_menu');
            $this->load->view('wasa/user_staff_procurement_sp/left_menu');
            $this->load->view('wasa/user_staff_procurement_sp/header_menu');
            $this->load->view('wasa/user_staff_procurement_sp/content_barang_master_list');
            $this->load->view('wasa/user_staff_procurement_sp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

            $this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
            $this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
            $this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
            $this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
            $this->load->view('wasa/user_supervisi_procurement_sp/content_barang_master_list');
            $this->load->view('wasa/user_supervisi_procurement_sp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

            $this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
            $this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
            $this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
            $this->load->view('wasa/user_staff_umum_logistik_kp/content_barang_master_list');
            $this->load->view('wasa/user_staff_umum_logistik_kp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

            $this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
            $this->load->view('wasa/user_kasie_logistik_kp/user_menu');
            $this->load->view('wasa/user_kasie_logistik_kp/left_menu');
            $this->load->view('wasa/user_kasie_logistik_kp/header_menu');
            $this->load->view('wasa/user_kasie_logistik_kp/content_barang_master_list');
            $this->load->view('wasa/user_kasie_logistik_kp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

            $this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
            $this->load->view('wasa/user_manajer_logistik_kp/user_menu');
            $this->load->view('wasa/user_manajer_logistik_kp/left_menu');
            $this->load->view('wasa/user_manajer_logistik_kp/header_menu');
            $this->load->view('wasa/user_manajer_logistik_kp/content_barang_master_list');
            $this->load->view('wasa/user_manajer_logistik_kp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

            $this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
            $this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
            $this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
            $this->load->view('wasa/user_staff_umum_logistik_sp/content_barang_master_list');
            $this->load->view('wasa/user_staff_umum_logistik_sp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

            $this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/content_barang_master_list');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {

            $this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
            $this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
            $this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
            $this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
            $this->load->view('wasa/user_supervisi_logistik_sp/content_barang_master_list');
            $this->load->view('wasa/user_supervisi_logistik_sp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {

            $this->load->view('wasa/user_staff_gudang_logistik_kp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_gudang_logistik_kp/user_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_kp/left_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_kp/header_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_kp/content_barang_master_list');
            $this->load->view('wasa/user_staff_gudang_logistik_kp/footer');
        } else {
            // log the user out
            $this->logout();
        }
    }

    function data_barang_master()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
            $data = $this->Barang_master_model->barang_master_list();
            echo json_encode($data);
        } else {
            // log the user out
            $this->logout();
        }
    }


    function get_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
            $id = $this->input->get('id');
            $data = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data Barang Master: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // log the user out
            $this->logout();
        }
    }

    function hapus_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();
            $HASH_MD5_BARANG_MASTER = $this->input->post('kode');
            $data_hapus = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

            $data = $this->Barang_master_model->hapus_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            $user = $this->ion_auth->user()->row();
            $HASH_MD5_BARANG_MASTER = $this->input->post('kode');
            $data_hapus = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

            $data = $this->Barang_master_model->hapus_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
            $user = $this->ion_auth->user()->row();
            $HASH_MD5_BARANG_MASTER = $this->input->post('kode');
            $data_hapus = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

            $data = $this->Barang_master_model->hapus_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
            $user = $this->ion_auth->user()->row();
            $HASH_MD5_BARANG_MASTER = $this->input->post('kode');
            $data_hapus = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

            $data = $this->Barang_master_model->hapus_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            $user = $this->ion_auth->user()->row();
            $HASH_MD5_BARANG_MASTER = $this->input->post('kode');
            $data_hapus = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

            $data = $this->Barang_master_model->hapus_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            $user = $this->ion_auth->user()->row();
            $HASH_MD5_BARANG_MASTER = $this->input->post('kode');
            $data_hapus = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

            $data = $this->Barang_master_model->hapus_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            $user = $this->ion_auth->user()->row();
            $HASH_MD5_BARANG_MASTER = $this->input->post('kode');
            $data_hapus = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

            $data = $this->Barang_master_model->hapus_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
            $user = $this->ion_auth->user()->row();
            $HASH_MD5_BARANG_MASTER = $this->input->post('kode');
            $data_hapus = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);

            $data = $this->Barang_master_model->hapus_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data Barang: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function simpan_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //check apakah nama Barang_mastersudah ada. jika belum ada, akan disimpan.
                if ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada') {

                    //log
                    $KETERANGAN = "Tambah Data Barang:" . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                    $this->user_log($KETERANGAN);

                    $data = $this->Barang_master_model->simpan_data_by_admin(
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $NAMA_SATUAN_BARANG,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    $data2 = $this->Barang_master_model->set_md5_id_barang_master($NAMA);

                    redirect('barang_master', 'refresh');
                } else {
                    echo 'Nama Barang Master atau Kode Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //check apakah nama Barang_mastersudah ada. jika belum ada, akan disimpan.
                if ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada') {

                    //log
                    $KETERANGAN = "Tambah Data Barang:" . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                    $this->user_log($KETERANGAN);

                    $data = $this->Barang_master_model->simpan_data_by_admin(
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $NAMA_SATUAN_BARANG,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    $data2 = $this->Barang_master_model->set_md5_id_barang_master($NAMA);

                    redirect('barang_master', 'refresh');
                } else {
                    echo 'Nama Barang Master atau Kode Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //check apakah nama Barang_mastersudah ada. jika belum ada, akan disimpan.
                if ($this->Barang_master_model->cek_nama_barang_master_by_admin_kode($KODE_BARANG) == 'Data belum ada') {

                    //log
                    $KETERANGAN = "Tambah Data Barang:" . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                    $this->user_log($KETERANGAN);

                    $data = $this->Barang_master_model->simpan_data_by_admin(
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $NAMA_SATUAN_BARANG,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    $data2 = $this->Barang_master_model->set_md5_id_barang_master($NAMA);

                    redirect('barang_master', 'refresh');
                } else {
                    echo 'Nama Barang Master atau Kode Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //check apakah nama Barang_mastersudah ada. jika belum ada, akan disimpan.
                if ($this->Barang_master_model->cek_nama_barang_master_by_admin_kode($KODE_BARANG) == 'Data belum ada') {

                    //log
                    $KETERANGAN = "Tambah Data Barang:" . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                    $this->user_log($KETERANGAN);

                    $data = $this->Barang_master_model->simpan_data_by_admin(
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $NAMA_SATUAN_BARANG,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    $data2 = $this->Barang_master_model->set_md5_id_barang_master($NAMA);

                    redirect('barang_master', 'refresh');
                } else {
                    echo 'Nama Barang Master atau Kode Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('JENIS_BARANG', 'Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Tool/Consumable/Material', 'trim|required');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                if ($ALIAS == "")
                {
                    $ALIAS = "-";
                }
                $MEREK = $this->input->post('MEREK');
                if ($MEREK == "")
                {
                    $MEREK = "-";
                }
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                if ($GROSS_WEIGHT == "")
                {
                    $GROSS_WEIGHT = "-";
                }
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                if ($NETT_WEIGHT == "")
                {
                    $NETT_WEIGHT = "-";
                }
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                if ($DIMENSI_PANJANG == "")
                {
                    $DIMENSI_PANJANG = "-";
                }
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                if ($DIMENSI_LEBAR == "")
                {
                    $DIMENSI_LEBAR = "-";
                }
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                if ($DIMENSI_TINGGI == "")
                {
                    $DIMENSI_TINGGI = "-";
                }
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                if ($SPESIFIKASI_LENGKAP == "")
                {
                    $SPESIFIKASI_LENGKAP = "-";
                }
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                if ($SPESIFIKASI_SINGKAT == "")
                {
                    $SPESIFIKASI_SINGKAT = "-";
                }
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                if ($CARA_SINGKAT_PENGGUNAAN == "")
                {
                    $CARA_SINGKAT_PENGGUNAAN = "-";
                }
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                if ($CARA_PENYIMPANAN_BARANG == "")
                {
                    $CARA_PENYIMPANAN_BARANG = "-";
                }
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');
                if ($MASA_PAKAI == "")
                {
                    $MASA_PAKAI = "-";
                }

                //check apakah nama Barang_mastersudah ada. jika belum ada, akan disimpan.
                if ($this->Barang_master_model->cek_nama_barang_master_by_admin_kode($KODE_BARANG) == 'Data belum ada') {

                    //log
                    $KETERANGAN = "Tambah Data Barang:" . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                    $this->user_log($KETERANGAN);

                    $data = $this->Barang_master_model->simpan_data_by_admin(
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $NAMA_SATUAN_BARANG,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    $data2 = $this->Barang_master_model->set_md5_id_barang_master($NAMA);

                    redirect('barang_master', 'refresh');
                } else {
                    echo 'Nama Barang Master atau Kode Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //check apakah nama Barang_mastersudah ada. jika belum ada, akan disimpan.
                if ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada') {

                    //log
                    $KETERANGAN = "Tambah Data Barang:" . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                    $this->user_log($KETERANGAN);

                    $data = $this->Barang_master_model->simpan_data_by_admin(
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $NAMA_SATUAN_BARANG,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    $data2 = $this->Barang_master_model->set_md5_id_barang_master($NAMA);

                    redirect('barang_master', 'refresh');
                } else {
                    echo 'Nama Barang Master atau Kode Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //check apakah nama Barang_mastersudah ada. jika belum ada, akan disimpan.
                if ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada') {

                    //log
                    $KETERANGAN = "Tambah Data Barang:" . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                    $this->user_log($KETERANGAN);

                    $data = $this->Barang_master_model->simpan_data_by_admin(
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $NAMA_SATUAN_BARANG,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    $data2 = $this->Barang_master_model->set_md5_id_barang_master($NAMA);

                    redirect('barang_master', 'refresh');
                } else {
                    echo 'Nama Barang Master atau Kode Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //check apakah nama Barang_mastersudah ada. jika belum ada, akan disimpan.
                if ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada') {

                    //log
                    $KETERANGAN = "Tambah Data Barang:" . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                    $this->user_log($KETERANGAN);

                    $data = $this->Barang_master_model->simpan_data_by_admin(
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $NAMA_SATUAN_BARANG,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    $data2 = $this->Barang_master_model->set_md5_id_barang_master($NAMA);

                    redirect('barang_master', 'refresh');
                } else {
                    echo 'Nama Barang Master atau Kode Barang sudah terekam sebelumnya';
                }
            }
        } else {
            $this->ion_auth->logout();
        }
    }

    function update_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('MEREK', 'Merek', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //cek apakah input sama dengan eksisting
                $data = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
                    $data_awal = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                    $data = $this->Barang_master_model->update_data(
                        $ID_BARANG_MASTER,
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $NAMA_SATUAN_BARANG,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    echo json_encode($data);

                    //log
                    $KETERANGAN = "Ubah Data Barang: " . json_encode($data_awal) . " ---- " . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                } else {
                    echo json_encode('Nama Barang_mastersudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //cek apakah input sama dengan eksisting
                $data = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
                    $data_awal = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                    $data = $this->Barang_master_model->update_data(
                        $ID_BARANG_MASTER,
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $NAMA_SATUAN_BARANG,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    echo json_encode($data);

                    //log
                    $KETERANGAN = "Ubah Data Barang: " . json_encode($data_awal) . " ---- " . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                } else {
                    echo json_encode('Nama Barang_mastersudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //cek apakah input sama dengan eksisting
                $data = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
                    $data_awal = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                    $data = $this->Barang_master_model->update_data(
                        $ID_BARANG_MASTER,
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $NAMA_SATUAN_BARANG,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    echo json_encode($data);

                    //log
                    $KETERANGAN = "Ubah Data Barang: " . json_encode($data_awal) . " ---- " . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                } else {
                    echo json_encode('Nama Barang_mastersudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //cek apakah input sama dengan eksisting
                $data = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
                    $data_awal = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                    $data = $this->Barang_master_model->update_data(
                        $ID_BARANG_MASTER,
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $NAMA_SATUAN_BARANG,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    echo json_encode($data);

                    //log
                    $KETERANGAN = "Ubah Data Barang: " . json_encode($data_awal) . " ---- " . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                } else {
                    echo json_encode('Nama Barang_mastersudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //cek apakah input sama dengan eksisting
                $data = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
                    $data_awal = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                    $data = $this->Barang_master_model->update_data(
                        $ID_BARANG_MASTER,
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $NAMA_SATUAN_BARANG,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    echo json_encode($data);

                    //log
                    $KETERANGAN = "Ubah Data Barang: " . json_encode($data_awal) . " ---- " . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                } else {
                    echo json_encode('Nama Barang_mastersudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //cek apakah input sama dengan eksisting
                $data = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
                    $data_awal = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                    $data = $this->Barang_master_model->update_data(
                        $ID_BARANG_MASTER,
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $NAMA_SATUAN_BARANG,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    echo json_encode($data);

                    //log
                    $KETERANGAN = "Ubah Data Barang: " . json_encode($data_awal) . " ---- " . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                } else {
                    echo json_encode('Nama Barang_mastersudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //cek apakah input sama dengan eksisting
                $data = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
                    $data_awal = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                    $data = $this->Barang_master_model->update_data(
                        $ID_BARANG_MASTER,
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $NAMA_SATUAN_BARANG,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    echo json_encode($data);

                    //log
                    $KETERANGAN = "Ubah Data Barang: " . json_encode($data_awal) . " ---- " . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                } else {
                    echo json_encode('Nama Barang_mastersudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|max_length[30]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //cek apakah input sama dengan eksisting
                $data = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->Barang_master_model->cek_nama_barang_master_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
                    $data_awal = $this->Barang_master_model->get_data_by_id_barang_master($ID_BARANG_MASTER);

                    $data = $this->Barang_master_model->update_data(
                        $ID_BARANG_MASTER,
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $NAMA_SATUAN_BARANG,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $MASA_PAKAI
                    );
                    echo json_encode($data);

                    //log
                    $KETERANGAN = "Ubah Data Barang: " . json_encode($data_awal) . " ---- " . $NAMA . ";" . $ALIAS . ";" . $MEREK . ";" . $NAMA_SATUAN_BARANG . ";" . $GROSS_WEIGHT . ";" . $NETT_WEIGHT . ";" . $KODE_BARANG . ";" . $PERALATAN_PERLENGKAPAN . ";" . $DIMENSI_PANJANG . ";" . $DIMENSI_LEBAR . ";" . $DIMENSI_TINGGI . ";" . $SPESIFIKASI_LENGKAP . ";" . $SPESIFIKASI_SINGKAT . ";" . $CARA_SINGKAT_PENGGUNAAN . ";" . $CARA_PENYIMPANAN_BARANG . ";" . $MASA_PAKAI;
                } else {
                    echo json_encode('Nama Barang_mastersudah terekam sebelumnya');
                }
            }
        } else {
            $this->ion_auth->logout();
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

    //TAMPILAN TAMBAH
    function tambah()
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

        $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_admin/head_normal', $this->data);
            $this->load->view('wasa/user_admin/user_menu');
            $this->load->view('wasa/user_admin/left_menu');
            $this->load->view('wasa/user_admin/header_menu');
            $this->load->view('wasa/user_admin/content_barang_master_tambah');
            $this->load->view('wasa/user_admin/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
            $this->load->view('wasa/user_manajer_procurement_kp/user_menu');
            $this->load->view('wasa/user_manajer_procurement_kp/left_menu');
            $this->load->view('wasa/user_manajer_procurement_kp/header_menu');
            $this->load->view('wasa/user_manajer_procurement_kp/content_barang_master_tambah');
            $this->load->view('wasa/user_manajer_procurement_kp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
            $this->load->view('wasa/user_manajer_logistik_kp/user_menu');
            $this->load->view('wasa/user_manajer_logistik_kp/left_menu');
            $this->load->view('wasa/user_manajer_logistik_kp/header_menu');
            $this->load->view('wasa/user_manajer_logistik_kp/content_barang_master_tambah');
            $this->load->view('wasa/user_manajer_logistik_kp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
            $this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
            $this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
            $this->load->view('wasa/user_staff_umum_logistik_sp/content_barang_master_tambah');
            $this->load->view('wasa/user_staff_umum_logistik_sp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/content_barang_master_tambah');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/content_barang_master_tambah');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    //TAMPILAN UBAH
    function ubah()
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

        $this->data['ID_HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
        $cek_data_barang = $this->Barang_master_model->get_data_by_HASH_MD5_BARANG_MASTER($this->data['ID_HASH_MD5_BARANG_MASTER']);
        if ($cek_data_barang == "BELUM ADA BARANG MASTER") {
            redirect('barang_master', 'refresh');
        }

        $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_admin/head_normal', $this->data);
            $this->load->view('wasa/user_admin/user_menu');
            $this->load->view('wasa/user_admin/left_menu');
            $this->load->view('wasa/user_admin/header_menu');
            $this->load->view('wasa/user_admin/content_barang_master_ubah');
            $this->load->view('wasa/user_admin/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
            $this->load->view('wasa/user_manajer_procurement_kp/user_menu');
            $this->load->view('wasa/user_manajer_procurement_kp/left_menu');
            $this->load->view('wasa/user_manajer_procurement_kp/header_menu');
            $this->load->view('wasa/user_manajer_procurement_kp/content_barang_master_ubah');
            $this->load->view('wasa/user_manajer_procurement_kp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
            $this->load->view('wasa/user_manajer_logistik_kp/user_menu');
            $this->load->view('wasa/user_manajer_logistik_kp/left_menu');
            $this->load->view('wasa/user_manajer_logistik_kp/header_menu');
            $this->load->view('wasa/user_manajer_logistik_kp/content_barang_master_ubah');
            $this->load->view('wasa/user_manajer_logistik_kp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
            $this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
            $this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
            $this->load->view('wasa/user_staff_umum_logistik_sp/content_barang_master_ubah');
            $this->load->view('wasa/user_staff_umum_logistik_sp/footer');
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['satuan_barang'] = $this->Satuan_barang_model->satuan_barang_list();

            $this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
            $this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
            $this->load->view('wasa/user_staff_gudang_logistik_sp/content_barang_master_ubah');
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    public function profil_barang_master()
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

        $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_admin/head_normal', $this->data);
                $this->load->view('wasa/user_admin/user_menu');
                $this->load->view('wasa/user_admin/left_menu');
                $this->load->view('wasa/user_admin/header_menu');
                $this->load->view('wasa/user_admin/content_barang_master_file');
                $this->load->view('wasa/user_admin/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_chief_sp/head_normal', $this->data);
                $this->load->view('wasa/user_chief_sp/user_menu');
                $this->load->view('wasa/user_chief_sp/left_menu');
                $this->load->view('wasa/user_chief_sp/header_menu');
                $this->load->view('wasa/user_chief_sp/content_barang_master_file');
                $this->load->view('wasa/user_chief_sp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_sm_sp/head_normal', $this->data);
                $this->load->view('wasa/user_sm_sp/user_menu');
                $this->load->view('wasa/user_sm_sp/left_menu');
                $this->load->view('wasa/user_sm_sp/header_menu');
                $this->load->view('wasa/user_sm_sp/content_barang_master_file');
                $this->load->view('wasa/user_sm_sp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_kp/user_menu');
                $this->load->view('wasa/user_staff_procurement_kp/left_menu');
                $this->load->view('wasa/user_staff_procurement_kp/header_menu');
                $this->load->view('wasa/user_staff_procurement_kp/content_barang_master_file');
                $this->load->view('wasa/user_staff_procurement_kp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_kasie_procurement_kp/user_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/left_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/header_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/content_barang_master_file');
                $this->load->view('wasa/user_kasie_procurement_kp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_procurement_kp/user_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/left_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/header_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/content_barang_master_file');
                $this->load->view('wasa/user_manajer_procurement_kp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_sp/user_menu');
                $this->load->view('wasa/user_staff_procurement_sp/left_menu');
                $this->load->view('wasa/user_staff_procurement_sp/header_menu');
                $this->load->view('wasa/user_staff_procurement_sp/content_barang_master_file');
                $this->load->view('wasa/user_staff_procurement_sp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_supervisi_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_procurement_kp/user_menu');
                $this->load->view('wasa/user_supervisi_procurement_kp/left_menu');
                $this->load->view('wasa/user_supervisi_procurement_kp/header_menu');
                $this->load->view('wasa/user_supervisi_procurement_kp/content_barang_master_file');
                $this->load->view('wasa/user_supervisi_procurement_kp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/content_barang_master_file');
                $this->load->view('wasa/user_staff_umum_logistik_kp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_logistik_kp/user_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/left_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/header_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/content_barang_master_file');
                $this->load->view('wasa/user_manajer_logistik_kp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/content_barang_master_file');
                $this->load->view('wasa/user_staff_umum_logistik_sp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/content_barang_master_file');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/content_barang_master_file');
                $this->load->view('wasa/user_supervisi_logistik_sp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
            $this->data['HASH_MD5_BARANG_MASTER'] = $this->uri->segment(3);
            $sess_data['HASH_MD5_BARANG_MASTER'] = $this->data['HASH_MD5_BARANG_MASTER'];
            $this->session->set_userdata($sess_data);

            //Kueri data di tabel barang master
            $query_barang_master_HASH_MD5_BARANG_MASTER = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $query_barang_master_HASH_MD5_BARANG_MASTER_result = $this->Barang_master_model->barang_master_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);
            $this->data['query_barang_master_HASH_MD5_BARANG_MASTER_result'] = $query_barang_master_HASH_MD5_BARANG_MASTER_result;

            //Kueri data di tabel barang_master file
            $query_file_HASH_MD5_BARANG_MASTER = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER($sess_data['HASH_MD5_BARANG_MASTER']);

            $KETERANGAN = "Melihat Data Barang Master: " . json_encode($query_barang_master_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN);

            $KETERANGAN2 = "Melihat File Barang Master: " . json_encode($query_file_HASH_MD5_BARANG_MASTER);
            $this->user_log($KETERANGAN2);

            if ($query_barang_master_HASH_MD5_BARANG_MASTER->num_rows() > 0) {
                if ($query_file_HASH_MD5_BARANG_MASTER->num_rows() > 0) {

                    $this->data['dokumen'] = $this->Barang_master_file_model->file_list_by_HASH_MD5_BARANG_MASTER_result($sess_data['HASH_MD5_BARANG_MASTER']);

                    $hasil = $query_file_HASH_MD5_BARANG_MASTER->row();
                    $DOK_FILE = $hasil->DOK_FILE;
                    $TANGGAL_UPLOAD = $hasil->TANGGAL_UPLOAD;

                    if (file_exists($file = './assets/upload_barang_master_file/' . $DOK_FILE)) {
                        $this->data['DOK_FILE'] = $DOK_FILE;
                        $this->data['TANGGAL_UPLOAD'] = $TANGGAL_UPLOAD;
                        $this->data['FILE'] = "ADA";
                    }
                } else {
                    $this->data['FILE'] = "TIDAK ADA";
                }

                $this->load->view('wasa/user_staff_gudang_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_gudang_logistik_kp/user_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_kp/left_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_kp/header_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_kp/content_barang_master_file');
                $this->load->view('wasa/user_staff_gudang_logistik_kp/footer');
            } else {
                // alihkan mereka ke halaman login
                redirect('barang_master', 'refresh');
            }
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }


    //Untuk proses upload file
    function proses_upload_file()
    {

        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        $HASH_MD5_BARANG_MASTER = $this->session->userdata('HASH_MD5_BARANG_MASTER');

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $HASH_MD5_BARANG_MASTER . '_';
            $config['upload_path']   = './assets/upload_barang_master_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;

            $this->load->library('upload', $config);

            $query_id_barang_master = $this->Barang_master_model->get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            $ID_BARANG_MASTER = $query_id_barang_master['ID_BARANG_MASTER'];

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_npwp');
                $nama = $this->upload->data('file_name');

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');

                $KETERANGAN = './assets/upload_barang_master_file/' . $nama;
                $this->db->insert('barang_master_file', array('ID_BARANG_MASTER' => $ID_BARANG_MASTER, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_BARANG_MASTER' => $HASH_MD5_BARANG_MASTER, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
                echo ($JENIS_FILE);
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $HASH_MD5_BARANG_MASTER . '_';
            $config['upload_path']   = './assets/upload_barang_master_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;

            $this->load->library('upload', $config);

            $query_id_barang_master = $this->Barang_master_model->get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            $ID_BARANG_MASTER = $query_id_barang_master['ID_BARANG_MASTER'];

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_npwp');
                $nama = $this->upload->data('file_name');

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');

                $KETERANGAN = './assets/upload_barang_master_file/' . $nama;
                $this->db->insert('barang_master_file', array('ID_BARANG_MASTER' => $ID_BARANG_MASTER, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_BARANG_MASTER' => $HASH_MD5_BARANG_MASTER, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
                echo ($JENIS_FILE);
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $HASH_MD5_BARANG_MASTER . '_';
            $config['upload_path']   = './assets/upload_barang_master_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;

            $this->load->library('upload', $config);

            $query_id_barang_master = $this->Barang_master_model->get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            $ID_BARANG_MASTER = $query_id_barang_master['ID_BARANG_MASTER'];

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_npwp');
                $nama = $this->upload->data('file_name');

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');

                $KETERANGAN = './assets/upload_barang_master_file/' . $nama;
                $this->db->insert('barang_master_file', array('ID_BARANG_MASTER' => $ID_BARANG_MASTER, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_BARANG_MASTER' => $HASH_MD5_BARANG_MASTER, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
                echo ($JENIS_FILE);
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $HASH_MD5_BARANG_MASTER . '_';
            $config['upload_path']   = './assets/upload_barang_master_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;

            $this->load->library('upload', $config);

            $query_id_barang_master = $this->Barang_master_model->get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            $ID_BARANG_MASTER = $query_id_barang_master['ID_BARANG_MASTER'];

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_npwp');
                $nama = $this->upload->data('file_name');

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');

                $KETERANGAN = './assets/upload_barang_master_file/' . $nama;
                $this->db->insert('barang_master_file', array('ID_BARANG_MASTER' => $ID_BARANG_MASTER, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_BARANG_MASTER' => $HASH_MD5_BARANG_MASTER, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
                echo ($JENIS_FILE);
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $HASH_MD5_BARANG_MASTER . '_';
            $config['upload_path']   = './assets/upload_barang_master_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;

            $this->load->library('upload', $config);

            $query_id_barang_master = $this->Barang_master_model->get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            $ID_BARANG_MASTER = $query_id_barang_master['ID_BARANG_MASTER'];

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_npwp');
                $nama = $this->upload->data('file_name');

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');

                $KETERANGAN = './assets/upload_barang_master_file/' . $nama;
                $this->db->insert('barang_master_file', array('ID_BARANG_MASTER' => $ID_BARANG_MASTER, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_BARANG_MASTER' => $HASH_MD5_BARANG_MASTER, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
                echo ($JENIS_FILE);
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $HASH_MD5_BARANG_MASTER . '_';
            $config['upload_path']   = './assets/upload_barang_master_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;

            $this->load->library('upload', $config);

            $query_id_barang_master = $this->Barang_master_model->get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            $ID_BARANG_MASTER = $query_id_barang_master['ID_BARANG_MASTER'];

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_npwp');
                $nama = $this->upload->data('file_name');

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');

                $KETERANGAN = './assets/upload_barang_master_file/' . $nama;
                $this->db->insert('barang_master_file', array('ID_BARANG_MASTER' => $ID_BARANG_MASTER, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_BARANG_MASTER' => $HASH_MD5_BARANG_MASTER, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
                echo ($JENIS_FILE);
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $HASH_MD5_BARANG_MASTER . '_';
            $config['upload_path']   = './assets/upload_barang_master_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;

            $this->load->library('upload', $config);

            $query_id_barang_master = $this->Barang_master_model->get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            $ID_BARANG_MASTER = $query_id_barang_master['ID_BARANG_MASTER'];

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_npwp');
                $nama = $this->upload->data('file_name');

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');

                $KETERANGAN = './assets/upload_barang_master_file/' . $nama;
                $this->db->insert('barang_master_file', array('ID_BARANG_MASTER' => $ID_BARANG_MASTER, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_BARANG_MASTER' => $HASH_MD5_BARANG_MASTER, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
                echo ($JENIS_FILE);
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $HASH_MD5_BARANG_MASTER . '_';
            $config['upload_path']   = './assets/upload_barang_master_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;

            $this->load->library('upload', $config);

            $query_id_barang_master = $this->Barang_master_model->get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            $ID_BARANG_MASTER = $query_id_barang_master['ID_BARANG_MASTER'];

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_npwp');
                $nama = $this->upload->data('file_name');

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');

                $KETERANGAN = './assets/upload_barang_master_file/' . $nama;
                $this->db->insert('barang_master_file', array('ID_BARANG_MASTER' => $ID_BARANG_MASTER, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_BARANG_MASTER' => $HASH_MD5_BARANG_MASTER, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
                echo ($JENIS_FILE);
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $HASH_MD5_BARANG_MASTER . '_';
            $config['upload_path']   = './assets/upload_barang_master_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;

            $this->load->library('upload', $config);

            $query_id_barang_master = $this->Barang_master_model->get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            $ID_BARANG_MASTER = $query_id_barang_master['ID_BARANG_MASTER'];

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_npwp');
                $nama = $this->upload->data('file_name');

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');

                $KETERANGAN = './assets/upload_barang_master_file/' . $nama;
                $this->db->insert('barang_master_file', array('ID_BARANG_MASTER' => $ID_BARANG_MASTER, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_BARANG_MASTER' => $HASH_MD5_BARANG_MASTER, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
                echo ($JENIS_FILE);
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            $WAKTU = date('Y-m-d H:i:s');

            $nama_file = "file_" . $HASH_MD5_BARANG_MASTER . '_';
            $config['upload_path']   = './assets/upload_barang_master_file/';
            $config['allowed_types'] = 'jpg|png|jpeg|bmp|pdf';
            $config['file_name'] = $nama_file;

            $this->load->library('upload', $config);

            $query_id_barang_master = $this->Barang_master_model->get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER);
            $ID_BARANG_MASTER = $query_id_barang_master['ID_BARANG_MASTER'];

            if ($this->upload->do_upload('userfile')) {
                $token = $this->input->post('token_npwp');
                $nama = $this->upload->data('file_name');

                $file_upload = $this->upload->data();

                $JENIS_FILE = $this->input->post('JENIS_FILE');

                $KETERANGAN = './assets/upload_barang_master_file/' . $nama;
                $this->db->insert('barang_master_file', array('ID_BARANG_MASTER' => $ID_BARANG_MASTER, 'JENIS_FILE' => $JENIS_FILE, 'HASH_MD5_BARANG_MASTER' => $HASH_MD5_BARANG_MASTER, 'DOK_FILE' => $nama, 'TOKEN' => $token, 'TANGGAL_UPLOAD' => $WAKTU, 'KETERANGAN' => $KETERANGAN));
                echo ($JENIS_FILE);
            }
        } else {
            // alihkan mereka ke halaman login
            redirect('barang_master', 'refresh');
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
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
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
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
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
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
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
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
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
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
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
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
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
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
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
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
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
        } else {
            // alihkan mereka ke halaman login
            redirect('barang_master', 'refresh');
        }
    }

    function set_manual_md5()
    {
        $hsl = $this->db->query("SELECT * 
		FROM barang_master");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'KODE_BARANG' => $data->KODE_BARANG,
                    'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
                    'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER
                );
                var_dump($hasil['HASH_MD5_BARANG_MASTER']);
                $HASH_MD5_BARANG_MASTER = md5($hasil['KODE_BARANG']);
                $ID_BARANG_MASTER = $hasil['ID_BARANG_MASTER'];
                $this->db->query("UPDATE barang_master SET HASH_MD5_BARANG_MASTER='$HASH_MD5_BARANG_MASTER' WHERE ID_BARANG_MASTER='$ID_BARANG_MASTER'");
            }
        } else {
            $hasil = "BELUM ADA BARANG MASTER";
        }
        return $hasil;
    }
}
