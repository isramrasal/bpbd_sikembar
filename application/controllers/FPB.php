<?php defined('BASEPATH') or exit('No direct script access allowed');

class FPB extends CI_Controller
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
        $this->data['title'] = 'SIPESUT | List Form Permintaan Barang';

        $this->load->model('RASD_model');
        $this->load->model('FPB_model');
        $this->load->model('Foto_model');
        $this->load->model('Jenis_barang_model');
        $this->load->model('Proyek_model');
        $this->load->model('FPB_form_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "FPB_aktif";
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses FPB";
        $WAKTU = date('Y-m-d H:i:s');
        $this->FPB_model->user_log_FPB($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->FPB_model->user_log_FPB($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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
        $this->data['ID_DEPARTEMEN_PEGAWAI'] = $data_pegawai['ID_DEPARTEMEN_PEGAWAI'];

        $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
        $this->data['INISIAL'] = $data_proyek['INISIAL'];
        $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

        $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
        $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

        $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);

        $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
        $sess_data['USER_ID'] = $this->data['USER_ID'];
        $sess_data['ID_DEPARTEMEN_PEGAWAI'] = $this->data['ID_DEPARTEMEN_PEGAWAI'];
        $this->session->set_userdata($sess_data);

        if ($this->ion_auth->logged_in()) {
            //fungsi ini untuk mengirim data ke dropdown

            if ($this->ion_auth->in_group(2)) { //user_chief_sp
                $this->load->view('wasa/user_chief_sp/head_normal', $this->data);
                $this->load->view('wasa/user_chief_sp/user_menu');
                $this->load->view('wasa/user_chief_sp/left_menu');
                $this->load->view('wasa/user_chief_sp/header_menu');
                $this->load->view('wasa/user_chief_sp/content_fpb_list');
                $this->load->view('wasa/user_chief_sp/footer');
            } else if ($this->ion_auth->in_group(3)) { //user_sm_sp
                $this->load->view('wasa/user_sm_sp/head_normal', $this->data);
                $this->load->view('wasa/user_sm_sp/user_menu');
                $this->load->view('wasa/user_sm_sp/left_menu');
                $this->load->view('wasa/user_sm_sp/header_menu');
                $this->load->view('wasa/user_sm_sp/content_fpb_list');
                $this->load->view('wasa/user_sm_sp/footer');
            } else if ($this->ion_auth->in_group(4)) { //user_pm_sp
                $this->load->view('wasa/user_pm_sp/head_normal', $this->data);
                $this->load->view('wasa/user_pm_sp/user_menu');
                $this->load->view('wasa/user_pm_sp/left_menu');
                $this->load->view('wasa/user_pm_sp/header_menu');
                $this->load->view('wasa/user_pm_sp/content_fpb_list');
                $this->load->view('wasa/user_pm_sp/footer');
            } else if ($this->ion_auth->in_group(5)) { //user_staff_procurement_kp
                $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_kp/user_menu');
                $this->load->view('wasa/user_staff_procurement_kp/left_menu');
                $this->load->view('wasa/user_staff_procurement_kp/header_menu');
                $this->load->view('wasa/user_staff_procurement_kp/content_fpb_list');
                $this->load->view('wasa/user_staff_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(6)) { //user_kasie_procurement_kp
                $this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_kasie_procurement_kp/user_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/left_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/header_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/content_fpb_list');
                $this->load->view('wasa/user_kasie_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(7)) { //user_manajer_procurement_kp
                $this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_procurement_kp/user_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/left_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/header_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/content_fpb_list');
                $this->load->view('wasa/user_manajer_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(8)) { //user_staff_procurement_sp
                $this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_sp/user_menu');
                $this->load->view('wasa/user_staff_procurement_sp/left_menu');
                $this->load->view('wasa/user_staff_procurement_sp/header_menu');
                $this->load->view('wasa/user_staff_procurement_sp/content_fpb_list');
                $this->load->view('wasa/user_staff_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(9)) { //user_supervisi_procurement_sp
                $this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/content_fpb_list');
                $this->load->view('wasa/user_supervisi_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(10)) { //user_staff_umum_logistik_kp
                $this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/content_fpb_list');
                $this->load->view('wasa/user_staff_umum_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(11)) { //user_kasie_logistik_kp
                $this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_kasie_logistik_kp/user_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/left_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/header_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/content_fpb_list');
                $this->load->view('wasa/user_kasie_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(12)) { //user_manajer_logistik_kp
                $this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_logistik_kp/user_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/left_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/header_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/content_fpb_list');
                $this->load->view('wasa/user_manajer_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(13)) { //user_staff_umum_logistik_sp
                $this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/content_fpb_list');
                $this->load->view('wasa/user_staff_umum_logistik_sp/footer');
            } else if ($this->ion_auth->in_group(14)) { //user_staff_gudang_logistik_sp
                $this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/content_fpb_list');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
            } else if ($this->ion_auth->in_group(15)) { //user_supervisi_logistik_sp
                $this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/content_fpb_list');
                $this->load->view('wasa/user_supervisi_logistik_sp/footer');
            }
        } else {
            $this->logout();
        }
    }

    function data_FPB()
    {

        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) { //user_chief_sp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            $USER_ID = $this->session->userdata('USER_ID');
            $data = $this->FPB_model->fpb_list_by_ID_PROYEK_USER_ID($ID_PROYEK, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) { //user_sm_sp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            $data = $this->FPB_model->fpb_list_by_ID_PROYEK($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(4))) { //user_pm_sp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            $data = $this->FPB_model->fpb_list_by_ID_PROYEK($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) { //user_staff_procurement_kp

            $data = $this->FPB_model->fpb_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) { //user_kasie_procurement_kp

            $data = $this->FPB_model->fpb_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) { //user_manajer_procurement_kp

            $data = $this->FPB_model->fpb_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) { //user_staff_procurement_sp

            $data = $this->FPB_model->fpb_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) { //user_supervisi_procurement_sp

            $data = $this->FPB_model->fpb_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //user_staff_umum_logistik_kp

            $data = $this->FPB_model->fpb_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //user_kasie_logistik_kp

            $data = $this->FPB_model->fpb_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) { //user_manajer_logistik_kp

            $data = $this->FPB_model->fpb_list();
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) { //user_staff_umum_logistik_sp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            $data = $this->FPB_model->fpb_list_by_ID_PROYEK($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(14))) { //user_staff_gudang_logistik_sp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            $data = $this->FPB_model->fpb_list_by_ID_PROYEK($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) { //user_supervisi_logistik_sp

            $ID_PROYEK = $this->session->userdata('ID_PROYEK');
            $data = $this->FPB_model->fpb_list_by_ID_PROYEK($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Melihat List Data FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_data_fpb_baru()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
            $ID_PROYEK = $this->input->get('ID_PROYEK'); //CHIEF
            $TANGGAL_DOKUMEN_FPB = $this->input->get('TANGGAL_DOKUMEN_FPB');
            $NO_URUT_FPB = $this->input->get('NO_URUT_FPB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FPB_model->get_data_fpb_baru($ID_PROYEK, $TANGGAL_DOKUMEN_FPB, $NO_URUT_FPB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) { //SM
            $ID_PROYEK = $this->input->get('ID_PROYEK'); //CHIEF
            $TANGGAL_DOKUMEN_FPB = $this->input->get('TANGGAL_DOKUMEN_FPB');
            $NO_URUT_FPB = $this->input->get('NO_URUT_FPB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FPB_model->get_data_fpb_baru($ID_PROYEK, $TANGGAL_DOKUMEN_FPB, $NO_URUT_FPB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(4))) { //SM
            $ID_PROYEK = $this->input->get('ID_PROYEK'); //CHIEF
            $TANGGAL_DOKUMEN_FPB = $this->input->get('TANGGAL_DOKUMEN_FPB');
            $NO_URUT_FPB = $this->input->get('NO_URUT_FPB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FPB_model->get_data_fpb_baru($ID_PROYEK, $TANGGAL_DOKUMEN_FPB, $NO_URUT_FPB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) { //STAFF LOG SP
            $ID_PROYEK = $this->input->get('ID_PROYEK'); //CHIEF
            $TANGGAL_DOKUMEN_FPB = $this->input->get('TANGGAL_DOKUMEN_FPB');
            $NO_URUT_FPB = $this->input->get('NO_URUT_FPB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FPB_model->get_data_fpb_baru($ID_PROYEK, $TANGGAL_DOKUMEN_FPB, $NO_URUT_FPB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) { //KASIE LOG SP
            $ID_PROYEK = $this->input->get('ID_PROYEK'); //CHIEF
            $TANGGAL_DOKUMEN_FPB = $this->input->get('TANGGAL_DOKUMEN_FPB');
            $NO_URUT_FPB = $this->input->get('NO_URUT_FPB');
            $USER_ID = $this->input->get('USER_ID');

            $data = $this->FPB_model->get_data_fpb_baru($ID_PROYEK, $TANGGAL_DOKUMEN_FPB, $NO_URUT_FPB, $USER_ID);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 FPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_nomor_urut()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PROYEK = $this->input->get('id');
            $USER_ID = $this->session->userdata('USER_ID');

            // $data = $this->FPB_model->get_nomor_urut_by_ID_PROYEK_USER_ID($ID_PROYEK, $USER_ID);
            $data = $this->FPB_model->get_nomor_urut_by_ID_PROYEK_USER_ID($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Nomor Urut FPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function simpan_data()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) { //CHIEF

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_FPB', 'Tanggal Pembuatan FPB', 'trim|required|max_length[100]');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_RASD = $this->input->post('ID_RASD');
                $TANGGAL_DOKUMEN_FPB = $this->input->post('TANGGAL_DOKUMEN_FPB');
                $TANGGAL_PENGAJUAN_FPB = date("Y-m-d");
                $NO_URUT_FPB = $this->input->post('NO_URUT_FPB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');

                $CREATE_BY_USER =  $this->data['USER_ID'];
                if ($this->ion_auth->in_group(2)) {
                    $ID_JABATAN_PEGAWAI = $this->session->userdata('ID_JABATAN_PEGAWAI');
                    $PROGRESS_FPB = "Dalam Proses Pembuatan Chief";
                    $STATUS_FPB = "DRAFT";
                }

                //check apakah nomor FPB sudah ada. jika belum ada, akan disimpan.
                if ($this->FPB_model->cek_no_urut_FPB_by_chief($NO_URUT_FPB) == 'Data belum ada') {

                    $hasil = $this->FPB_model->simpan_data_by_chief(
                        $ID_PROYEK,
                        $ID_RASD,
                        $TANGGAL_DOKUMEN_FPB,
                        $TANGGAL_PENGAJUAN_FPB,
                        $NO_URUT_FPB,
                        $CREATE_BY_USER,
                        $PROGRESS_FPB,
                        $STATUS_FPB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP
                    );

                    $KETERANGAN = "Simpan FPB: "
                        . "; " . $ID_PROYEK
                        . "; " . $ID_RASD
                        . "; " . $TANGGAL_DOKUMEN_FPB
                        . "; " . $TANGGAL_PENGAJUAN_FPB
                        . "; " . $NO_URUT_FPB
                        . "; " . $NO_URUT_FPB
                        . "; " . $CREATE_BY_USER
                        . "; " . $PROGRESS_FPB
                        . "; " . $STATUS_FPB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP;
                    $this->user_log($KETERANGAN);

                    $hasil_2 = $this->FPB_model->set_md5_id_FPB($ID_PROYEK, $NO_URUT_FPB, $CREATE_BY_USER);

                    $KETERANGAN = "Update MD5 FPB: " . $ID_PROYEK . "; " . $NO_URUT_FPB
                        . "; " . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FPB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(3))) { //SM //SM

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_FPB', 'Tanggal Pembuatan FPB', 'trim|required|max_length[100]');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_RASD = $this->input->post('ID_RASD');
                $TANGGAL_DOKUMEN_FPB = $this->input->post('TANGGAL_DOKUMEN_FPB');
                $TANGGAL_PENGAJUAN_FPB = date("Y-m-d");
                $NO_URUT_FPB = $this->input->post('NO_URUT_FPB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');

                $CREATE_BY_USER =  $this->data['USER_ID'];
                if ($this->ion_auth->in_group(3)) {
                    $ID_JABATAN_PEGAWAI = $this->session->userdata('ID_JABATAN_PEGAWAI');
                    $PROGRESS_FPB = "Dalam Proses Pembuatan SM";
                    $STATUS_FPB = "DRAFT";
                }

                //check apakah nomor FPB sudah ada. jika belum ada, akan disimpan.
                if ($this->FPB_model->cek_no_urut_FPB_by_chief($NO_URUT_FPB) == 'Data belum ada') {

                    $hasil = $this->FPB_model->simpan_data_by_chief(
                        $ID_PROYEK,
                        $ID_RASD,
                        $TANGGAL_DOKUMEN_FPB,
                        $TANGGAL_PENGAJUAN_FPB,
                        $NO_URUT_FPB,
                        $CREATE_BY_USER,
                        $PROGRESS_FPB,
                        $STATUS_FPB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP
                    );

                    $KETERANGAN = "Simpan FPB: "
                        . "; " . $ID_PROYEK
                        . "; " . $ID_RASD
                        . "; " . $TANGGAL_DOKUMEN_FPB
                        . "; " . $TANGGAL_PENGAJUAN_FPB
                        . "; " . $NO_URUT_FPB
                        . "; " . $NO_URUT_FPB
                        . "; " . $CREATE_BY_USER
                        . "; " . $PROGRESS_FPB
                        . "; " . $STATUS_FPB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP;
                    $this->user_log($KETERANGAN);

                    $hasil_2 = $this->FPB_model->set_md5_id_FPB($ID_PROYEK, $NO_URUT_FPB, $CREATE_BY_USER);

                    $KETERANGAN = "Update MD5 FPB: " . $ID_PROYEK . "; " . $NO_URUT_FPB
                        . "; " . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FPB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(4))) { //PM

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_FPB', 'Tanggal Pembuatan FPB', 'trim|required|max_length[100]');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_RASD = $this->input->post('ID_RASD');
                $TANGGAL_DOKUMEN_FPB = $this->input->post('TANGGAL_DOKUMEN_FPB');
                $NO_URUT_FPB = $this->input->post('NO_URUT_FPB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');

                $CREATE_BY_USER =  $this->data['USER_ID'];
                if ($this->ion_auth->in_group(3)) {
                    $ID_JABATAN_PEGAWAI = $this->session->userdata('ID_JABATAN_PEGAWAI');
                    $PROGRESS_FPB = "Dalam Proses Pembuatan PM";
                    $STATUS_FPB = "DRAFT";
                }

                //check apakah nomor FPB sudah ada. jika belum ada, akan disimpan.
                if ($this->FPB_model->cek_no_urut_FPB_by_chief($NO_URUT_FPB) == 'Data belum ada') {

                    $hasil = $this->FPB_model->simpan_data_by_chief(
                        $ID_PROYEK,
                        $ID_RASD,
                        $TANGGAL_DOKUMEN_FPB,
                        $NO_URUT_FPB,
                        $CREATE_BY_USER,
                        $PROGRESS_FPB,
                        $STATUS_FPB,
                        $JUMLAH_COUNT,
                        $FILE_NAME_TEMP
                    );

                    $KETERANGAN = "Simpan FPB: "
                        . "; " . $ID_PROYEK
                        . "; " . $ID_RASD
                        . "; " . $TANGGAL_DOKUMEN_FPB
                        . "; " . $NO_URUT_FPB
                        . "; " . $NO_URUT_FPB
                        . "; " . $CREATE_BY_USER
                        . "; " . $PROGRESS_FPB
                        . "; " . $STATUS_FPB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $FILE_NAME_TEMP;
                    $this->user_log($KETERANGAN);

                    $hasil_2 = $this->FPB_model->set_md5_id_FPB($ID_PROYEK, $NO_URUT_FPB, $CREATE_BY_USER);

                    $KETERANGAN = "Update MD5 FPB: " . $ID_PROYEK . "; " . $NO_URUT_FPB
                        . "; " . $CREATE_BY_USER;
                    $this->user_log($KETERANGAN);
                } else {
                    echo 'Nomor Urut FPB sudah terekam sebelumnya';
                }
            }
        } else {
            $this->logout();
        }
    }

    function simpan_perubahan_FPB()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('CTT', 'CTT', 'trim');
            // run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                $ID_FPB = $this->input->post('ID_FPB');
                $CTT = $this->input->post('CTT');
                $this->FPB_model->update_data_ubah_logistik($ID_FPB, $CTT);
                redirect('FPB', 'refresh');
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
