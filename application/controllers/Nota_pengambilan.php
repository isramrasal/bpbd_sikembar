<?php defined('BASEPATH') or exit('No direct script access allowed');

class Nota_pengambilan extends CI_Controller
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
        $this->data['title'] = 'SIPESUT | Nota Pengambilan';

        $this->load->model('RASD_model');
        $this->load->model('SPPB_model');
        $this->load->model('FPB_model');
        $this->load->model('Nota_pengambilan_model');
        $this->load->model('Foto_model');
        $this->load->model('Jenis_barang_model');
        $this->load->model('Khp_model');
        $this->load->model('Proyek_model');
        $this->load->model('SPPB_form_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "Nota_pengambilan_aktif";
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses Nota Pengambilan";
        $WAKTU = date('Y-m-d H:i:s');
        $this->Nota_pengambilan_model->user_log_nota_pengambilan($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->Nota_pengambilan_model->user_log_nota_pengambilan($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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
        $this->data['USER_ID'] = $user->id;
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


        $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        //jika mereka sudah login
        if ($this->ion_auth->logged_in()) {
            //fungsi ini untuk mengirim data ke dropdown
            $this->data['proyek'] = $this->Proyek_model->list_proyek();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['rasd'] = $this->RASD_model->RASD_list();
            //jika mereka sebagai admin
            if ($this->ion_auth->is_admin()) { //admin
                //fungsi ini untuk mengirim data ke dropdown
                // $this->data['proyek'] = $this->Proyek_model->list_proyek();
                // $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                // $this->data['rasd'] = $this->RASD_model->RASD_list();

                // $this->load->view('wasa/user_admin/head_normal', $this->data);
                // $this->load->view('wasa/user_admin/user_menu');
                // $this->load->view('wasa/user_admin/left_menu');
                // $this->load->view('wasa/user_admin/header_menu');
                // $this->load->view('wasa/user_admin/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_admin/footer');
            } else if ($this->ion_auth->in_group(2)) {  //user chief sp
                // $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                // $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                // $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                // $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                // $this->data['INISIAL'] = $data_proyek['INISIAL'];
                // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                // $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                // $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                // $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                // $this->session->set_userdata($sess_data);

                // $this->load->view('wasa/user_chief_sp/head_normal', $this->data);
                // $this->load->view('wasa/user_chief_sp/user_menu');
                // $this->load->view('wasa/user_chief_sp/left_menu');
                // $this->load->view('wasa/user_chief_sp/header_menu');
                // $this->load->view('wasa/user_chief_sp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_chief_sp/footer');
            } else if ($this->ion_auth->in_group(3)) {  //user sm sp
                // $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                // $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                // $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                // $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                // $this->data['INISIAL'] = $data_proyek['INISIAL'];
                // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                // $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                // $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                // $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                // $this->session->set_userdata($sess_data);

                // $this->load->view('wasa/user_sm_sp/head_normal', $this->data);
                // $this->load->view('wasa/user_sm_sp/user_menu');
                // $this->load->view('wasa/user_sm_sp/left_menu');
                // $this->load->view('wasa/user_sm_sp/header_menu');
                // $this->load->view('wasa/user_sm_sp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_sm_sp/footer');
            } else if ($this->ion_auth->in_group(4)) {  //user pm sp
                // $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                // $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                // $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                // $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                // $this->data['INISIAL'] = $data_proyek['INISIAL'];
                // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                // $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                // $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                // $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                // $this->session->set_userdata($sess_data);

                // $this->load->view('wasa/user_pm_sp/head_normal', $this->data);
                // $this->load->view('wasa/user_pm_sp/user_menu');
                // $this->load->view('wasa/user_pm_sp/left_menu');
                // $this->load->view('wasa/user_pm_sp/header_menu');
                // $this->load->view('wasa/user_pm_sp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_pm_sp/footer');
            } else if ($this->ion_auth->in_group(5)) {

                // //fungsi ini untuk mengirim data ke dropdown
                // $this->data['proyek'] = $this->Proyek_model->list_proyek();
                // $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                // $this->data['rasd'] = $this->RASD_model->RASD_list();

                // $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
                // $this->load->view('wasa/user_staff_procurement_kp/user_menu');
                // $this->load->view('wasa/user_staff_procurement_kp/left_menu');
                // $this->load->view('wasa/user_staff_procurement_kp/header_menu');
                // $this->load->view('wasa/user_staff_procurement_kp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_staff_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(6)) {

                // //fungsi ini untuk mengirim data ke dropdown
                // $this->data['proyek'] = $this->Proyek_model->list_proyek();
                // $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                // $this->data['rasd'] = $this->RASD_model->RASD_list();

                // $this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
                // $this->load->view('wasa/user_kasie_procurement_kp/user_menu');
                // $this->load->view('wasa/user_kasie_procurement_kp/left_menu');
                // $this->load->view('wasa/user_kasie_procurement_kp/header_menu');
                // $this->load->view('wasa/user_kasie_procurement_kp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_kasie_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(7)) {

                // //fungsi ini untuk mengirim data ke dropdown
                // $this->data['proyek'] = $this->Proyek_model->list_proyek();
                // $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                // $this->data['rasd'] = $this->RASD_model->RASD_list();

                // $this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
                // $this->load->view('wasa/user_manajer_procurement_kp/user_menu');
                // $this->load->view('wasa/user_manajer_procurement_kp/left_menu');
                // $this->load->view('wasa/user_manajer_procurement_kp/header_menu');
                // $this->load->view('wasa/user_manajer_procurement_kp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_manajer_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(8)) { //user staff umum logistik

                // //fungsi ini untuk mengirim data ke dropdown
                // $this->data['proyek'] = $this->Proyek_model->list_proyek();
                // $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                // $this->data['rasd'] = $this->RASD_model->RASD_list();

                // $this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
                // $this->load->view('wasa/user_staff_procurement_sp/user_menu');
                // $this->load->view('wasa/user_staff_procurement_sp/left_menu');
                // $this->load->view('wasa/user_staff_procurement_sp/header_menu');
                // $this->load->view('wasa/user_staff_procurement_sp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_staff_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(9)) { //user supervisi procurement sp

                // //fungsi ini untuk mengirim data ke dropdown
                // $this->data['proyek'] = $this->Proyek_model->list_proyek();
                // $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                // $this->data['rasd'] = $this->RASD_model->RASD_list();

                // $this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
                // $this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
                // $this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
                // $this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
                // $this->load->view('wasa/user_supervisi_procurement_sp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_supervisi_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(10)) { //user staff logistik kp

                // $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                // $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                // $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                // $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                // $this->data['INISIAL'] = $data_proyek['INISIAL'];
                // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                // $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                // $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                // $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                // $this->session->set_userdata($sess_data);

                // $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);

                // $this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
                // $this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
                // $this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
                // $this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
                // $this->load->view('wasa/user_staff_umum_logistik_kp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_staff_umum_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(11)) { //user kasie logistik kp

                // $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                // $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                // $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                // $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                // $this->data['INISIAL'] = $data_proyek['INISIAL'];
                // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                // $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                // $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                // $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                // $this->session->set_userdata($sess_data);

                // $this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
                // $this->load->view('wasa/user_kasie_logistik_kp/user_menu');
                // $this->load->view('wasa/user_kasie_logistik_kp/left_menu');
                // $this->load->view('wasa/user_kasie_logistik_kp/header_menu');
                // $this->load->view('wasa/user_kasie_logistik_kp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_kasie_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(12)) { //user staff umum logistik

                // //fungsi ini untuk mengirim data ke dropdown
                // $this->data['proyek'] = $this->Proyek_model->list_proyek();
                // $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                // $this->data['rasd'] = $this->RASD_model->RASD_list();

                // $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                // $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                // $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                // $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                // $this->data['INISIAL'] = $data_proyek['INISIAL'];
                // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                // $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                // $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                // $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                // $this->session->set_userdata($sess_data);

                // $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                // //var_dump($this->data['LIST_FPB']);die;

                // $this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
                // $this->load->view('wasa/user_manajer_logistik_kp/user_menu');
                // $this->load->view('wasa/user_manajer_logistik_kp/left_menu');
                // $this->load->view('wasa/user_manajer_logistik_kp/header_menu');
                // $this->load->view('wasa/user_manajer_logistik_kp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_manajer_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(13)) { //user staff umum logistik sp

                // $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                // $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                // $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                // $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                // $this->data['INISIAL'] = $data_proyek['INISIAL'];
                // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                // $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                // $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                // $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                // $this->session->set_userdata($sess_data);

                // $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);

                // $this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
                // $this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
                // $this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
                // $this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
                // $this->load->view('wasa/user_staff_umum_logistik_sp/content_nota_pengambilan_list');
                // $this->load->view('wasa/user_staff_umum_logistik_sp/footer');
            } else if ($this->ion_auth->in_group(14)) { //user staff umum logistik sp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->load->view('wasa/user_staff_gudang_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_gudang_logistik_sp/user_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/left_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/header_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_staff_gudang_logistik_sp/footer');
            } else if ($this->ion_auth->in_group(15)) { //user supervisi logistik sp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);

                $this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_supervisi_logistik_sp/footer');
            } else if ($this->ion_auth->in_group(18)) { //user supervisi logistik sp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_manajer_hrd_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_hrd_kp/user_menu');
                $this->load->view('wasa/user_manajer_hrd_kp/left_menu');
                $this->load->view('wasa/user_manajer_hrd_kp/header_menu');
                $this->load->view('wasa/user_manajer_hrd_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_manajer_hrd_kp/footer');
            } else if ($this->ion_auth->in_group(21)) { //user manajer keuangan kp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_manajer_keuangan_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_keuangan_kp/user_menu');
                $this->load->view('wasa/user_manajer_keuangan_kp/left_menu');
                $this->load->view('wasa/user_manajer_keuangan_kp/header_menu');
                $this->load->view('wasa/user_manajer_keuangan_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_manajer_keuangan_kp/footer');
            } else if ($this->ion_auth->in_group(24)) { //user manajer konstruksi kp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_manajer_konstruksi_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_konstruksi_kp/user_menu');
                $this->load->view('wasa/user_manajer_konstruksi_kp/left_menu');
                $this->load->view('wasa/user_manajer_konstruksi_kp/header_menu');
                $this->load->view('wasa/user_manajer_konstruksi_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_manajer_konstruksi_kp/footer');
            } else if ($this->ion_auth->in_group(27)) { //user manajer sdm kp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_manajer_sdm_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_sdm_kp/user_menu');
                $this->load->view('wasa/user_manajer_sdm_kp/left_menu');
                $this->load->view('wasa/user_manajer_sdm_kp/header_menu');
                $this->load->view('wasa/user_manajer_sdm_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_manajer_sdm_kp/footer');
            } else if ($this->ion_auth->in_group(30)) { //user manajer qaqc kp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_manajer_qaqc_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_qaqc_kp/user_menu');
                $this->load->view('wasa/user_manajer_qaqc_kp/left_menu');
                $this->load->view('wasa/user_manajer_qaqc_kp/header_menu');
                $this->load->view('wasa/user_manajer_qaqc_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_manajer_qaqc_kp/footer');
            } else if ($this->ion_auth->in_group(33)) { //user manajer ep kp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_manajer_ep_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_ep_kp/user_menu');
                $this->load->view('wasa/user_manajer_ep_kp/left_menu');
                $this->load->view('wasa/user_manajer_ep_kp/header_menu');
                $this->load->view('wasa/user_manajer_ep_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_manajer_ep_kp/footer');
            } else if ($this->ion_auth->in_group(34)) { //user direktur keuangan kp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_direktur_keuangan_kp/head_normal', $this->data);
                $this->load->view('wasa/user_direktur_keuangan_kp/user_menu');
                $this->load->view('wasa/user_direktur_keuangan_kp/left_menu');
                $this->load->view('wasa/user_direktur_keuangan_kp/header_menu');
                $this->load->view('wasa/user_direktur_keuangan_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_direktur_keuangan_kp/footer');
            } else if ($this->ion_auth->in_group(35)) { //user direktur psds kp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_direktur_psds_kp/head_normal', $this->data);
                $this->load->view('wasa/user_direktur_psds_kp/user_menu');
                $this->load->view('wasa/user_direktur_psds_kp/left_menu');
                $this->load->view('wasa/user_direktur_psds_kp/header_menu');
                $this->load->view('wasa/user_direktur_psds_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_direktur_psds_kp/footer');
            } else if ($this->ion_auth->in_group(36)) { //user direktur konstruksi kp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_direktur_konstruksi_kp/head_normal', $this->data);
                $this->load->view('wasa/user_direktur_konstruksi_kp/user_menu');
                $this->load->view('wasa/user_direktur_konstruksi_kp/left_menu');
                $this->load->view('wasa/user_direktur_konstruksi_kp/header_menu');
                $this->load->view('wasa/user_direktur_konstruksi_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_direktur_konstruksi_kp/footer');
            } else if ($this->ion_auth->in_group(41)) { //user manajer hsse kp

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_manajer_hsse_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_hsse_kp/user_menu');
                $this->load->view('wasa/user_manajer_hsse_kp/left_menu');
                $this->load->view('wasa/user_manajer_hsse_kp/header_menu');
                $this->load->view('wasa/user_manajer_hsse_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_manajer_hsse_kp/footer');
            } else if ($this->ion_auth->in_group(42)) { //user staff gudang logistik kp

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);

                $this->load->view('wasa/user_staff_gudang_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_gudang_logistik_kp/user_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_kp/left_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_kp/header_menu');
                $this->load->view('wasa/user_staff_gudang_logistik_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_staff_gudang_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(43)) { //user manajer marketing kp

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_manajer_marketing_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_marketing_kp/user_menu');
                $this->load->view('wasa/user_manajer_marketing_kp/left_menu');
                $this->load->view('wasa/user_manajer_marketing_kp/header_menu');
                $this->load->view('wasa/user_manajer_marketing_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_manajer_marketing_kp/footer');
            } else if ($this->ion_auth->in_group(44)) { //user manajer komersial kp

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                $this->data['LIST_FPB'] = $this->FPB_model->fpb_list_by_ID_PROYEK_and_condition($this->data['ID_PROYEK']);
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_manajer_komersial_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_komersial_kp/user_menu');
                $this->load->view('wasa/user_manajer_komersial_kp/left_menu');
                $this->load->view('wasa/user_manajer_komersial_kp/header_menu');
                $this->load->view('wasa/user_manajer_komersial_kp/content_nota_pengambilan_list');
                $this->load->view('wasa/user_manajer_komersial_kp/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    function data_nota_pengambilan()
    {

        if ($this->ion_auth->logged_in()) {
            if ($this->ion_auth->is_admin()) {
                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(2)) {
                $ID_PROYEK = $this->session->userdata('ID_PROYEK');
                $data = $this->Nota_pengambilan_model->nota_pengambilan_list_by_id_proyek($ID_PROYEK);
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(3)) {
                $ID_PROYEK = $this->session->userdata('ID_PROYEK');
                $data = $this->Nota_pengambilan_model->nota_pengambilan_list_by_id_proyek($ID_PROYEK);
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(4)) {

                $ID_PROYEK = $this->session->userdata('ID_PROYEK');
                $data = $this->Nota_pengambilan_model->nota_pengambilan_list_by_id_proyek($ID_PROYEK);
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(5)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(6)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(7)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(8)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(9)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(10)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(11)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(12)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(13)) {

                $ID_PROYEK = $this->session->userdata('ID_PROYEK');
                $data = $this->Nota_pengambilan_model->nota_pengambilan_list_by_id_proyek($ID_PROYEK);
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(14)) {

                $ID_PROYEK = $this->session->userdata('ID_PROYEK');
                $data = $this->Nota_pengambilan_model->nota_pengambilan_list_by_id_proyek($ID_PROYEK);
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(15)) { //user_supervisi_logistik_sp

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(18)) { //user_supervisi_logistik_sp

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(21)) { //user_manajer_keuangan_kp

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(24)) { //user_manajer_konstruksi_kp

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(27)) { //user_manajer_sdm_kp

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(30)) { //user_manajer_qaqc_kp

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(33)) { //user_manajer_ep_kp

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(34)) { //user_direktur_keuangan_kp

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(35)) { //user_direktur_psds_kp

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(36)) { //user_direktur_konstruksi_kp

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(41)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(42)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(43)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(44)) {

                $data = $this->Nota_pengambilan_model->nota_pengambilan_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data Nota Pengambilan: " . json_encode($data);
                $this->user_log($KETERANGAN);
            }
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) { //user_supervisi_logistik_sp
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) { //user_supervisi_logistik_sp
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) { //user_manajer_keuangan_kp
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) { //user_manajer_konstruksi_kp
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) { //user_manajer_sdm_kp
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) { //user_manajer_qaqc_kp
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) { //user_manajer_pe_kp
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) { //user_direktur_keuangan_kp
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) { //user_direktur_psds_kp
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) { //user_direktur_konstruksi_kp
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4))) {
        //     $id = $this->input->get('id');
        //     $data = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($id);
        //     echo json_encode($data);

        //     $KETERANGAN = "Get Data SPPB: " . json_encode($data);
        //     $this->user_log($KETERANGAN);
        // } 
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_nomor_urut()
    {
        if ($this->ion_auth->logged_in()) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_nomor_urut_by_id_rasd($id);
            echo json_encode($data);

            $KETERANGAN = "Get Nomor Urut SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_nomor_urut_by_id_proyek()
    {
        if ($this->ion_auth->logged_in()) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_nomor_urut_by_id_proyek($id);
            echo json_encode($data);

            $KETERANGAN = "Get Nomor Urut SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_nomor_urut_by_id_rasd()
    {
        if ($this->ion_auth->logged_in()) {
            $id = $this->input->get('id');
            $data = $this->Nota_pengambilan_model->get_nomor_urut_by_id_rasd($id);
            echo json_encode($data);

            $KETERANGAN = "Get Nomor Urut SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function hapus_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) { //user_supervisi_logistik_sp

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) { //user_supervisi_logistik_sp

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) { //user_supervisi_logistik_sp

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) { //user_supervisi_logistik_sp

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) { //user_supervisi_logistik_sp

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) { //user_supervisi_logistik_sp

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(38)) { //user_direktur_keuangan_kp

            $HASH_MD5_SPPB = $this->input->post('kode');
            $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

            //HAPUS SEMUA DATA SETELAH SPPB!!!

            $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
            $this->user_log($KETERANGAN);
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(5))) {

        //     $HASH_MD5_SPPB = $this->input->post('kode');
        //     $data_hapus = $this->Nota_pengambilan_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

        //     //HAPUS SEMUA DATA SETELAH SPPB!!!


        //     $data = $this->Nota_pengambilan_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
        //     echo json_encode($data);

        //     $KETERANGAN = "Hapus Data SPPB: " . json_encode($data_hapus);
        //     $this->user_log($KETERANGAN);
        // } 
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function simpan_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();
            $this->data['user_id'] = $user->id;
            $this->data['USER_ID'] = $user->id;
            $CREATE_BY_USER =  $this->data['user_id'];

            //set validation rules
            $this->form_validation->set_rules('JENIS_PEKERJAAN', 'Jenis Pekerjaan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_PEMBUATAN_SPPB', 'Tanggal Pembuatan SPPB', 'trim|required|max_length[100]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_RASD = $this->input->post('ID_RASD');
                $JENIS_PEKERJAAN = $this->input->post('JENIS_PEKERJAAN');
                $TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_JAM = date("h:i:s.u");
                $TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_HARI = date('Y-m-d');
                $dt = date('F');
                $TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_BULAN = $dt;
                $TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_TAHUN = date("Y");
                $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');

                $this->data['PROYEK'] = $this->Proyek_model->get_id_proyek_by_id_rasd($ID_RASD);
                foreach ($this->data['PROYEK']->result() as $PROYEK) :
                    $this->data['ID_PROYEK'] = $PROYEK->ID_PROYEK;
                endforeach;
                $ID_PROYEK = $this->data['ID_PROYEK'];

                $CREATE_BY_USER =  $this->data['user_id'];

                if ($this->ion_auth->is_admin()) {
                    $PROGRESS_SPPB = "Dalam Proses Administrator";
                    $STATUS_SPPB = "DRAFT";
                }

                //check apakah nama SPPB sudah ada. jika belum ada, akan disimpan.
                if ($this->Nota_pengambilan_model->cek_no_urut_nota_pengambilan_by_admin($NO_URUT_SPPB) == 'Data belum ada') {

                    $hasil = $this->Nota_pengambilan_model->simpan_data_by_admin(
                        $ID_RASD,
                        $ID_PROYEK,
                        $JENIS_PEKERJAAN,
                        $TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_JAM,
                        $TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_HARI,
                        $TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_BULAN,
                        $TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_TAHUN,
                        $NO_URUT_SPPB,
                        $JUMLAH_COUNT,
                        $CREATE_BY_USER,
                        $PROGRESS_SPPB,
                        $STATUS_SPPB,
                        $FILE_NAME_TEMP
                    );

                    $hasil_2 = $this->Nota_pengambilan_model->set_md5_id_nota_pengambilan($ID_RASD, $NO_URUT_SPPB, $CREATE_BY_USER);
                } else {
                    echo 'Nomor Urut SPPB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

            $user = $this->ion_auth->user()->row();
            $this->data['user_id'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('JENIS_PEKERJAAN', 'Jenis Pekerjaan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_PEMBUATAN_SPPB', 'Tanggal Pembuatan SPPB', 'trim|required|max_length[100]');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_RASD = $this->input->post('ID_RASD');
                $JENIS_PEKERJAAN = $this->input->post('JENIS_PEKERJAAN');
                $TANGGAL_PEMBUATAN_SPPB = $this->input->post('TANGGAL_PEMBUATAN_SPPB');
                $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $LIST_FPB = $this->input->post('LIST_FPB');


                $CREATE_BY_USER =  $this->data['user_id'];
                if ($this->ion_auth->in_group(3)) {
                    $PROGRESS_SPPB = "Dalam Proses Chief";
                    $STATUS_SPPB = "DRAFT";
                }

                // if ($this->ion_auth->in_group(5)) {
                //     $PROGRESS_SPPB = "Dalam Proses Staff Procurement Kantor Pusat";
                //     $STATUS_SPPB = "DRAFT";
                // }

                // if ($this->ion_auth->in_group(13)) {
                //     $PROGRESS_SPPB = "Dalam Proses Staff Umum Logistik";
                //     $STATUS_SPPB = "DRAFT";
                // }


                //check apakah nama SPPB sudah ada. jika belum ada, akan disimpan.
                if ($this->Nota_pengambilan_model->cek_no_urut_nota_pengambilan_by_admin($NO_URUT_NOTA_PENGAMBILAN) == 'Data belum ada') {

                    $hasil = $this->Nota_pengambilan_model->simpan_data_by_staff_logistic(
                        $ID_RASD,
                        $ID_PROYEK,
                        $JENIS_PEKERJAAN,
                        $TANGGAL_PEMBUATAN_SPPB,
                        $NO_URUT_NOTA_PENGAMBILAN,
                        $JUMLAH_COUNT,
                        $CREATE_BY_USER,
                        $PROGRESS_SPPB,
                        $STATUS_SPPB,
                        $FILE_NAME_TEMP
                    );

                    $hasil_2 = $this->Nota_pengambilan_model->set_md5_id_nota_pengambilan($ID_RASD, $NO_URUT_NOTA_PENGAMBILAN, $CREATE_BY_USER);

                    //echo var_dump($hasil_2);
                } else {
                    echo 'Nomor Urut SPPB sudah terekam sebelumnya';
                }
            }
        } else {
            $this->logout();
        }
    }

    function get_data_nota_pengambilan_baru()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(12)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(41)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(42)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(43)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(44)) {
            $NO_URUT_NOTA_PENGAMBILAN = $this->input->post('NO_URUT_NOTA_PENGAMBILAN');

            $data = $this->Nota_pengambilan_model->get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Nota Pengambilan Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function simpan_perubahan_nota_pengambilan()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('CTT', 'CTT', 'trim');
            // run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                $ID_SPPB = $this->input->post('ID_SPPB');
                $CTT = $this->input->post('CTT');
                $this->Nota_pengambilan_model->update_data_ubah_logistik($ID_SPPB, $CTT);
                redirect('sppb', 'refresh');
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
                $ID_SPPB = $this->input->post('ID_SPPB');
                $CTT = $this->input->post('CTT');
                $this->Nota_pengambilan_model->update_data_akhir($ID_SPPB, $CTT);
                $ID_KHP = $this->Khp_model->simpan_data_by_admin($ID_SPPB);
                $list_nota_pengambilan_barang = $this->Sppb_barang_model->sppb_barang_list_by_id_nota_pengambilan($ID_SPPB);
                foreach ($list_nota_pengambilan_barang as $index => $value) {
                    $this->Khp_model->simpan_data_khp_barang_by_admin($ID_KHP, $value->ID_NOTA_PENGAMBILAN_BARANG, $value->JUMLAH_SETUJU_D_KEU);
                }
                redirect('sppb', 'refresh');
            }
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function update_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_admin()) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim|required');
            $this->form_validation->set_rules('MEREK', 'Merek', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim|required');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim|required');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('GAMBAR_1', 'Gambar 1', 'trim');
            $this->form_validation->set_rules('GAMBAR_2', 'Gambar 2', 'trim');
            $this->form_validation->set_rules('GAMBAR_3', 'Gambar 3', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('DOK_BUKU_PANDUAN', 'Dokumen Buku Panduan', 'trim');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|required|max_length[12]');

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
                $GAMBAR_1 = $this->input->post('GAMBAR_1');
                $GAMBAR_2 = $this->input->post('GAMBAR_2');
                $GAMBAR_3 = $this->input->post('GAMBAR_3');
                $DOK_BUKU_PANDUAN = $this->input->post('DOK_BUKU_PANDUAN');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($ID_BARANG_MASTER);

                if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($ID_BARANG_MASTER);
                    //log
                    // $KETERANGAN = "Ubah SPPB".$data['NAMA_Sppb']." jadi ".$nama_Sppb.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
                    // $WAKTU = date('Y-m-d H:i:s');
                    // $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data(
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
                        $GAMBAR_1,
                        $GAMBAR_2,
                        $GAMBAR_3,
                        $DOK_BUKU_PANDUAN,
                        $MASA_PAKAI
                    );
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(6)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(7)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(10)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(11)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(13)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(14)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(15)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(18)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(21)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(24)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(27)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(30)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(33)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(34)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(35)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(36)) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
                $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

                    //log
                    $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppbsudah terekam sebelumnya');
                }
            }
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4) || $this->ion_auth->in_group(5))) {
        //     $user = $this->ion_auth->user()->row();

        //     //set validation rules
        //     $this->form_validation->set_rules('nama_nota_pengambilan2', 'Nama SPPB', 'trim|required');
        //     $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

        //     //run validation check
        //     if ($this->form_validation->run() == FALSE) {   //validation fails
        //         echo json_encode(validation_errors());
        //     } else {
        //         //get the form data
        //         $id_nota_pengambilan = $this->input->post('id_nota_pengambilan2');
        //         $nama_nota_pengambilan = $this->input->post('nama_nota_pengambilan2');
        //         $keterangan = $this->input->post('keterangan2');

        //         //cek apakah input sama dengan eksisting
        //         $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

        //         if ($data['NAMA_BARANG_MASTER'] == $nama_nota_pengambilan || ($this->Nota_pengambilan_model->cek_nama_nota_pengambilan_by_pegawai($nama_nota_pengambilan, $user->ID_PEGAWAI) == 'Data belum ada')) {
        //             $data = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($id_nota_pengambilan);

        //             //log
        //             $KETERANGAN = "Ubah SPPB" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_nota_pengambilan . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
        //             $WAKTU = date('Y-m-d H:i:s');
        //             $this->Nota_pengambilan_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        //             $data = $this->Nota_pengambilan_model->update_data($id_nota_pengambilan, $nama_nota_pengambilan, $keterangan);
        //             echo json_encode($data);
        //         } else {
        //             echo json_encode('Nama Sppbsudah terekam sebelumnya');
        //         }
        //     }
        // } 
        else {
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

    //TAMPILAN TAMBAH
    function view_tambah()
    {
        //jika mereka belum login
        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        //get data tabel users untuk ditampilkan
        $user = $this->ion_auth->user()->row();
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        $this->data['user_id'] = $user->id;
        $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['left_menu'] = "sppb_aktif";

        $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_admin()) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->list_proyek();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['rasd'] = $this->RASD_model->RASD_list();
            $this->load->view('wasa/user_admin/head_normal', $this->data);
            $this->load->view('wasa/user_admin/user_menu');
            $this->load->view('wasa/user_admin/left_menu');
            $this->load->view('wasa/user_admin/header_menu');
            $this->load->view('wasa/user_admin/content_nota_pengambilan_tambah');
            $this->load->view('wasa/user_admin/footer');
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
        // {	
        // 	$this->load->view('wasa/pegawai/head_normal', $this->data);
        // 	$this->load->view('wasa/pegawai/user_menu');
        // 	$this->load->view('wasa/pegawai/left_menu');
        // 	$this->load->view('wasa/pegawai/content_Sppb');
        // }
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    //TAMPILAN UBAH
    function view_ubah()
    {
        //jika mereka belum login
        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        //get data tabel users untuk ditampilkan
        $user = $this->ion_auth->user()->row();
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        $this->data['user_id'] = $user->id;
        $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['left_menu'] = "sppb_aktif";

        $this->data['id_ubah'] = $this->uri->segment(3);
        $cek_data_barang = $this->Nota_pengambilan_model->get_data_by_id_nota_pengambilan($this->data['id_ubah']);
        if ($cek_data_barang == "BELUM ADA BARANG MASTER") {
            redirect('sppb', 'refresh');
        }

        $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_admin()) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->list_proyek();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();

            $this->load->view('wasa/user_admin/head_normal', $this->data);
            $this->load->view('wasa/user_admin/user_menu');
            $this->load->view('wasa/user_admin/left_menu');
            $this->load->view('wasa/user_admin/header_menu');
            $this->load->view('wasa/user_admin/content_nota_pengambilan_ubah');
            $this->load->view('wasa/user_admin/footer');
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
        // {	
        // 	$this->load->view('wasa/pegawai/head_normal', $this->data);
        // 	$this->load->view('wasa/pegawai/user_menu');
        // 	$this->load->view('wasa/pegawai/left_menu');
        // 	$this->load->view('wasa/pegawai/content_Sppb');
        // }
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }
}
