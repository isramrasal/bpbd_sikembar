<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_korban_bencana extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->load->model('Foto_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Pengajuan_model');
        $this->load->model('Penyaluran_model');
        $this->load->model('Data_Korban_model');

        $this->data['title'] = 'SiKembar | Dashboard Korban Bencana';
        $this->data['left_menu'] = "dashboard_korban_bencana_aktif";
    }

    public function index()
    {
        // Jika mereka belum login
        if (!$this->ion_auth->logged_in()) {
            redirect('auth/login', 'refresh');
        }

        // Ambil data user yang login
        $user = $this->ion_auth->user()->row();
        // var_dump($user->id);die;
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
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

        // Ambil foto user
        $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        // Ambil jumlah pengajuan berdasarkan user_id
        $ID_JENIS_BENCANA_LIST = "Semua";  // Ganti dengan filter yang sesuai
        $jumlah_pengajuan = $this->Pengajuan_model->count_pengajuan_by_filter($ID_JENIS_BENCANA_LIST, $this->data['user_id']);
        $this->data['jumlah_pengajuan'] = $jumlah_pengajuan;
        $this->data['last_update_pengajuan'] = $this->Pengajuan_model->get_last_update($this->data['user_id']);

        // Ambil jumlah penyaluran
        $this->data['jumlah_penyaluran'] = $this->Penyaluran_model->count_penyaluran_by_filter($ID_JENIS_BENCANA_LIST, 
        $this->data['user_id']);
        $this->data['last_update_penyaluran'] = $this->Penyaluran_model->get_last_update($this->data['user_id']);
        
        // $this->data['jumlah_penyaluran'] = $this->Penyaluran_model->count_penyaluran_by_filter($ID_JENIS_BENCANA_LIST, $this->data['user_id']);

        // Ambil jumlah data korban
        $this->data['jumlah_data_korban'] = $this->Data_Korban_model->count_data_korban_by_filter($ID_JENIS_BENCANA_LIST, $this->data['user_id']);
        $this->data['last_update_korban'] = $this->Data_Korban_model->get_last_update($this->data['user_id']);

        // Cek role user, jika manajer proyek
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {
            $this->load->view('wasa/user_korban_bencana/head_normal', $this->data);
            $this->load->view('wasa/user_korban_bencana/user_menu');
            $this->load->view('wasa/user_korban_bencana/left_menu');
            $this->load->view('wasa/user_korban_bencana/header_menu');
            $this->load->view('wasa/user_korban_bencana/content_dashboard_korban_bencana');
            $this->load->view('wasa/user_korban_bencana/footer');
        } else {
            // Logout jika tidak memiliki otorisasi
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    public function logout()
    {
        // Log out
        $logout = $this->ion_auth->logout();

        // Redirect ke login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('auth/login', 'refresh');
    }
}