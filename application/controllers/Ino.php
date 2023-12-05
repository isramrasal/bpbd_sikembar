<?php defined('BASEPATH') or exit('No direct script access allowed');

class Rencana_Pengiriman_Barang extends CI_Controller
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
        $this->data['title'] = 'SIPESUT | Rencana Pengiriman Barang';

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
        $this->load->model('Vendor_model');
        $this->load->model('Rencana_pengiriman_barang_model');

        $this->load->model('FPB_model');
        $this->load->model('SPPB_form_model');


        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "Rencana_Pengiriman_Barang_aktif";
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses SURAT_JALAN";
        $WAKTU = date('Y-m-d H:i:s');
        $this->Rencana_pengiriman_barang_model->user_log_rpb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->Rencana_pengiriman_barang_model->user_log_rpb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

        if ($this->ion_auth->logged_in()) {
            if ($this->ion_auth->in_group(38)) { //user_vendor

                //get data tabel users untuk ditampilkan
                $user = $this->ion_auth->user()->row();
                $this->data['user_id'] = $user->id;
                $this->data['USER_ID'] = $user->id;
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

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_vendor/head_normal', $this->data);
                $this->load->view('wasa/user_vendor/user_menu');
                $this->load->view('wasa/user_vendor/left_menu');
                $this->load->view('wasa/user_vendor/header_menu');
                $this->load->view('wasa/user_vendor/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_vendor/footer');
            } else if ($this->ion_auth->in_group(5)) { //user_staff_procurement_kp

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

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_po = $this->PO_model->get_data_po_by_ID_PROYEK($this->data['ID_PROYEK']);
                // var_dump($this->data['ID_PROYEK']);
                // $this->data['ID_SPPB'] = $data_po['ID_SPPB'];
                // $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $data_po['ID_PROYEK_LOKASI_PENYERAHAN'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
                $sess_data['USER_ID'] = $this->data['USER_ID'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_kp/user_menu');
                $this->load->view('wasa/user_staff_procurement_kp/left_menu');
                $this->load->view('wasa/user_staff_procurement_kp/header_menu');
                $this->load->view('wasa/user_staff_procurement_kp/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_staff_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(6)) { //user_kasie_procurement_kp

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

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_po = $this->PO_model->get_data_po_by_ID_PROYEK($this->data['ID_PROYEK']);
                // var_dump($this->data['ID_PROYEK']);
                // $this->data['ID_SPPB'] = $data_po['ID_SPPB'];
                // $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $data_po['ID_PROYEK_LOKASI_PENYERAHAN'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
                $sess_data['USER_ID'] = $this->data['USER_ID'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_kasie_procurement_kp/user_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/left_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/header_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_kasie_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(7)) { //user_manajer_procurement_kp

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

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_po = $this->PO_model->get_data_po_by_ID_PROYEK($this->data['ID_PROYEK']);
                // var_dump($this->data['ID_PROYEK']);
                // $this->data['ID_SPPB'] = $data_po['ID_SPPB'];
                // $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $data_po['ID_PROYEK_LOKASI_PENYERAHAN'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
                $sess_data['USER_ID'] = $this->data['USER_ID'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_procurement_kp/user_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/left_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/header_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_manajer_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(8)) { //user_staff_procurement_sp

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

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_po = $this->PO_model->get_data_po_by_ID_PROYEK($this->data['ID_PROYEK']);
                // var_dump($this->data['ID_PROYEK']);
                // $this->data['ID_SPPB'] = $data_po['ID_SPPB'];
                // $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $data_po['ID_PROYEK_LOKASI_PENYERAHAN'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
                $sess_data['USER_ID'] = $this->data['USER_ID'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_sp/user_menu');
                $this->load->view('wasa/user_staff_procurement_sp/left_menu');
                $this->load->view('wasa/user_staff_procurement_sp/header_menu');
                $this->load->view('wasa/user_staff_procurement_sp/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_staff_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(9)) { //user_supervisi_procurement_sp

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

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_po = $this->PO_model->get_data_po_by_ID_PROYEK($this->data['ID_PROYEK']);
                // var_dump($this->data['ID_PROYEK']);
                // $this->data['ID_SPPB'] = $data_po['ID_SPPB'];
                // $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $data_po['ID_PROYEK_LOKASI_PENYERAHAN'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
                $sess_data['USER_ID'] = $this->data['USER_ID'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_supervisi_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(10)) { //user_staff_umum_logistik_kp

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

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_po = $this->PO_model->get_data_po_by_ID_PROYEK($this->data['ID_PROYEK']);
                // var_dump($this->data['ID_PROYEK']);
                // $this->data['ID_SPPB'] = $data_po['ID_SPPB'];
                // $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $data_po['ID_PROYEK_LOKASI_PENYERAHAN'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
                $sess_data['USER_ID'] = $this->data['USER_ID'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_staff_umum_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_umum_logistik_kp/user_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/left_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/header_menu');
                $this->load->view('wasa/user_staff_umum_logistik_kp/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_staff_umum_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(11)) { //user_kasie_logistik_kp

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

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_po = $this->PO_model->get_data_po_by_ID_PROYEK($this->data['ID_PROYEK']);
                // var_dump($this->data['ID_PROYEK']);
                // $this->data['ID_SPPB'] = $data_po['ID_SPPB'];
                // $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $data_po['ID_PROYEK_LOKASI_PENYERAHAN'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
                $sess_data['USER_ID'] = $this->data['USER_ID'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_kasie_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_kasie_logistik_kp/user_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/left_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/header_menu');
                $this->load->view('wasa/user_kasie_logistik_kp/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_kasie_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(12)) { //user_manajer_logistik_kp

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

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_po = $this->PO_model->get_data_po_by_ID_PROYEK($this->data['ID_PROYEK']);
                // var_dump($this->data['ID_PROYEK']);
                // $this->data['ID_SPPB'] = $data_po['ID_SPPB'];
                // $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $data_po['ID_PROYEK_LOKASI_PENYERAHAN'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
                $sess_data['USER_ID'] = $this->data['USER_ID'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_manajer_logistik_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_logistik_kp/user_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/left_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/header_menu');
                $this->load->view('wasa/user_manajer_logistik_kp/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_manajer_logistik_kp/footer');
            } else if ($this->ion_auth->in_group(13)) { //user_staff_umum_logistik_sp

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

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_po = $this->PO_model->get_data_po_by_ID_PROYEK($this->data['ID_PROYEK']);
                // var_dump($this->data['ID_PROYEK']);
                // $this->data['ID_SPPB'] = $data_po['ID_SPPB'];
                // $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $data_po['ID_PROYEK_LOKASI_PENYERAHAN'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
                $sess_data['USER_ID'] = $this->data['USER_ID'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_staff_umum_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_umum_logistik_sp/user_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/left_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/header_menu');
                $this->load->view('wasa/user_staff_umum_logistik_sp/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_staff_umum_logistik_sp/footer');
            } else if ($this->ion_auth->in_group(15)) { //user_supervisi_logistik_sp

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

                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_po = $this->PO_model->get_data_po_by_ID_PROYEK($this->data['ID_PROYEK']);
                // var_dump($this->data['ID_PROYEK']);
                // $this->data['ID_SPPB'] = $data_po['ID_SPPB'];
                // $this->data['ID_PROYEK_LOKASI_PENYERAHAN'] = $data_po['ID_PROYEK_LOKASI_PENYERAHAN'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_VENDOR'] = $this->data['ID_VENDOR'];
                $sess_data['USER_ID'] = $this->data['USER_ID'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();
                $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                $this->data['rasd'] = $this->RASD_model->RASD_list();

                $hasil = $this->Vendor_model->vendor_list_by_id_vendor($this->data['ID_VENDOR']);
                foreach ($hasil->result() as $VENDOR) :
                    $this->data['NAMA_VENDOR'] = $VENDOR->NAMA_VENDOR;
                    $this->data['NAMA_PIC_VENDOR'] = $VENDOR->NAMA_PIC_VENDOR;
                    $this->data['EMAIL_PIC_VENDOR'] = $VENDOR->EMAIL_PIC_VENDOR;
                    $this->data['EMAIL_VENDOR'] = $VENDOR->EMAIL_VENDOR;
                endforeach;

                $this->load->view('wasa/user_supervisi_logistik_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_logistik_sp/user_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/left_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/header_menu');
                $this->load->view('wasa/user_supervisi_logistik_sp/content_rencana_pengiriman_barang');
                $this->load->view('wasa/user_supervisi_logistik_sp/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    function data_RPB()
    {

        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {
            $ID_VENDOR = $this->session->userdata('ID_VENDOR');

            $data = $this->Rencana_pengiriman_barang_model->po_list_rpb_by_id_vendor($ID_VENDOR);
            echo json_encode($data);

            $KETERANGAN = "Melihat Data PO bahan RPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function get_list_rpb_by_id_po()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PO = $this->input->post('ID_PO');
            $data = $this->Rencana_pengiriman_barang_model->get_list_rpb_by_id_po($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_data_proyek_by_hash_md5_po()
    {
        if ($this->ion_auth->logged_in()) {
            $HASH_MD5_PO = $this->input->get('HASH_MD5_PO');
            $data = $this->Rencana_pengiriman_barang_model->get_data_proyek_by_hash_md5_po($HASH_MD5_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_nomor_urut()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PROYEK = $this->input->get('ID_PROYEK');

            $data = $this->Rencana_pengiriman_barang_model->get_nomor_urut_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Nomor Urut Rencana Pengiriman Barang: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }

    function simpan_data()
    {
        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_RENCANA_PENGIRIMAN_BARANG', 'Nomor Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI', 'Tanggal Rencana Pengiriman Barang', 'trim|required');
            $this->form_validation->set_rules('NAMA_PENGIRIM', 'Nama Pengirim', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NO_HP_PENGIRIM', 'NO HP Pengirim', 'trim|required|max_length[20]|numeric');
            $this->form_validation->set_rules('KEPADA', 'KEPADA', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TUJUAN', 'TUJUAN', 'trim|required|min_length[10]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');
                $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI = $this->input->post('TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI');
                $NAMA_PENGIRIM = $this->input->post('NAMA_PENGIRIM');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $NO_HP_PENGIRIM = $this->input->post('NO_HP_PENGIRIM');
                // $FILE_NAME_TEMP_PACKING_LIST = $this->input->post('FILE_NAME_TEMP_PACKING_LIST');
                $KEPADA = $this->input->post('KEPADA');
                $TUJUAN = $this->input->post('TUJUAN');
                $ID_PO = $this->input->post('ID_PO');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Rencana_pengiriman_barang_model->cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG) == 'DATA BELUM ADA') {

                    $hasil = $this->Rencana_pengiriman_barang_model->simpan_data_rpb(
                        $ID_PO,
                        $ID_PROYEK,
                        $ID_VENDOR,
                        $ID_SPPB,
                        $ID_PROYEK_LOKASI_PENYERAHAN,
                        $JUMLAH_COUNT,
                        $NO_URUT_PO,
                        $NO_RENCANA_PENGIRIMAN_BARANG,
                        $TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
                        $CREATE_BY_USER,
                        $NAMA_PENGIRIM,
                        $NO_HP_PENGIRIM,
                        $KEPADA,
                        $TUJUAN
                    );

                    $hasil_2 = $this->Rencana_pengiriman_barang_model->set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Rencana Pengiriman Barang sudah terekam sebelumnya';
                }
            }
        } else {
            $this->logout();
        }
    }

    function get_data_rpb_baru()
    {
        $user = $this->ion_auth->user()->row();
        $this->data['USER_ID'] = $user->id;
        $CREATE_BY_USER =  $this->data['USER_ID'];

        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(10))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(11))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(12))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(13))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(15))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_RENCANA_PENGIRIMAN_BARANG = $this->input->post('NO_RENCANA_PENGIRIMAN_BARANG');

            $data = $this->Rencana_pengiriman_barang_model->get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RPB Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
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
