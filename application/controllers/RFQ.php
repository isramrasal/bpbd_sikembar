<?php defined('BASEPATH') or exit('No direct script access allowed');

class RFQ extends CI_Controller
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
        $this->data['title'] = 'SIPESUT | RFQ';

        $this->load->model('RFQ_model');
        $this->load->model('SPPB_model');
        $this->load->model('Foto_model');
        $this->load->model('Proyek_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "RFQ_aktif";
    }

    public function logout() //092023
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses RFQ";
        $WAKTU = date('Y-m-d H:i:s');
        $this->RFQ_model->user_log_rfq($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->RFQ_model->user_log_rfq($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
    }

    public function index() //092023
    {
        //jika mereka belum login
        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        //jika mereka sudah login
        if ($this->ion_auth->logged_in()) {
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
            $this->data['last_login'] = date('d-m-Y H:i:s', $user->last_login);
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');

            $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
            if ($query_foto_user == "BELUM ADA FOTO") {
                $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
            } else {
                $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
            }

            //jika mereka sebagai admin
            if ($this->ion_auth->is_admin()) { //admin
            } else if ($this->ion_auth->in_group(5)) { //staf_proc_kp

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();

                //BASED ON PEGAWAI
                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //END OF BASED ON PEGAWAI

                // tampilkan seluruh proyek
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list();
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list();

                $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_kp/user_menu');
                $this->load->view('wasa/user_staff_procurement_kp/left_menu');
                $this->load->view('wasa/user_staff_procurement_kp/header_menu');
                $this->load->view('wasa/user_staff_procurement_kp/content_rfq_list');
                $this->load->view('wasa/user_staff_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(8)) { //staff_proc_sp

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();

                //BASED ON PEGAWAI
                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //END OF BASED ON PEGAWAI
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list_by_id_proyek($this->data['ID_PROYEK']);

                ////

                $this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_sp/user_menu');
                $this->load->view('wasa/user_staff_procurement_sp/left_menu');
                $this->load->view('wasa/user_staff_procurement_sp/header_menu');
                $this->load->view('wasa/user_staff_procurement_sp/content_rfq_list');
                $this->load->view('wasa/user_staff_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(9)) { //staff_proc_sp

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek'] = $this->Proyek_model->list_proyek();

                //BASED ON PEGAWAI
                $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

                $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['INISIAL'] = $data_proyek['INISIAL'];
                $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
                $this->session->set_userdata($sess_data);

                //END OF BASED ON PEGAWAI
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list_by_id_proyek($this->data['ID_PROYEK']);

                ////

                $this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/content_rfq_list');
                $this->load->view('wasa/user_supervisi_procurement_sp/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    public function list_RFQ_by_all_proyek() //092023
    {

        if ($this->ion_auth->logged_in()) {
            $data = $this->RFQ_model->list_RFQ_by_all_proyek();
            echo json_encode($data);

            // $KETERANGAN = "Melihat Data SPPB bahan RFQ: " . json_encode($data);
            // $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    public function list_RFQ_by_id_proyek() //092023
    {

        if ($this->ion_auth->logged_in()) {
            
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $data = $this->RFQ_model->list_RFQ_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            // $KETERANGAN = "Melihat Data SPPB bahan RFQ: " . json_encode($data);
            // $this->user_log($KETERANGAN);
            
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    // function data_RFQ_vendor()
    // {

    //     if ($this->ion_auth->logged_in()) {
    //         if ($this->ion_auth->in_group(38)) {

    //             $ID_VENDOR = $this->session->userdata('ID_VENDOR');

    //             date_default_timezone_set('Asia/Jakarta');
    //             $WAKTU = date('Y-m-d H:i:s');

    //             $data = $this->RFQ_model->rfq_list_by_ID_VENDOR($ID_VENDOR, $WAKTU);
    //             echo json_encode($data);

    //             $KETERANGAN = "Melihat Data RFQ: " . json_encode($data);
    //             $this->user_log($KETERANGAN);
    //         }
    //     } else {
    //         // set the flash data error message if there is one
    //         $this->ion_auth->logout();
    //         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    //     }
    // }

    function get_data_proyek_by_hash_md5_sppb()
    {
        if ($this->ion_auth->logged_in()) {
            $HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
            $data = $this->RFQ_model->get_data_proyek_by_hash_md5_sppb($HASH_MD5_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    public function get_nomor_urut() //cek lagi
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $data = $this->RFQ_model->get_nomor_urut_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Nomor Urut RFQ: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    public function get_data_sppb_by_id_proyek()//092023
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $data = $this->RFQ_model->get_data_sppb_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    public function get_data_sub_pekerjaan_by_id_sppb()//092023
    {
        if ($this->ion_auth->logged_in()) {
            $ID_SPPB = $this->input->post('ID_SPPB');
            $data = $this->RFQ_model->get_data_sub_pekerjaan_by_id_sppb($ID_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Get Data Sub Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    public function simpan_data()//092023
    {
        $user = $this->ion_auth->user()->row();
        $this->data['USER_ID'] = $user->id;
        $CREATE_BY_USER = $this->data['USER_ID'];

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

            $this->form_validation->set_rules('NO_URUT_RFQ', 'Nomor Urut RFQ', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_RFQ', 'Tanggal Dokumen RFQ', 'trim|required');
            
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_RFQ = $this->input->post('JUMLAH_COUNT_RFQ');
            $NO_URUT_RFQ = $this->input->post('NO_URUT_RFQ');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');

            $STATUS_RFQ = ('DRAFT');
            $PROGRESS_RFQ = 'Diproses oleh Staff Procurement KP';

            $TANGGAL_DOKUMEN_RFQ = $this->input->post('TANGGAL_DOKUMEN_RFQ');
            $TANGGAL_PEMBUATAN_RFQ_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_RFQ_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_RFQ_BULAN = $dt;
            $TANGGAL_PEMBUATAN_RFQ_TAHUN = date("Y");
            $REVISI_KE = 0;

            //run validation check
            if ($this->form_validation->run() == FALSE) { //validation fails
                echo (validation_errors());
            } else {
                //check apakah NOMOR URUT RFQ_form sudah ada. jika belum ada, akan disimpan.
                if ($this->RFQ_model->cek_nomor_urut_rfq($NO_URUT_RFQ) == 'DATA BELUM ADA') {

                    $data = $this->RFQ_model->simpan_data_rfq(
                        $ID_SPPB,
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $FILE_NAME_TEMP,
                        $REVISI_KE,
                        $JUMLAH_COUNT_RFQ,
                        $TANGGAL_DOKUMEN_RFQ,
                        $NO_URUT_RFQ,
                        $CREATE_BY_USER,
                        $STATUS_RFQ,
                        $PROGRESS_RFQ,
                        $TANGGAL_PEMBUATAN_RFQ_JAM,
                        $TANGGAL_PEMBUATAN_RFQ_HARI,
                        $TANGGAL_PEMBUATAN_RFQ_BULAN,
                        $TANGGAL_PEMBUATAN_RFQ_TAHUN
                    );

                    $data_2 = $this->RFQ_model->set_md5_id_RFQ($ID_PROYEK, $ID_SPPB, $NO_URUT_RFQ, $CREATE_BY_USER);

                    echo $data_2;
                } else {
                    echo 'Nomor urut sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

            $this->form_validation->set_rules('NO_URUT_RFQ', 'Nomor Urut RFQ', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_RFQ', 'Tanggal Dokumen RFQ', 'trim|required');
            
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_RFQ = $this->input->post('JUMLAH_COUNT_RFQ');
            $NO_URUT_RFQ = $this->input->post('NO_URUT_RFQ');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');

            $STATUS_RFQ = ('DRAFT');
            $PROGRESS_RFQ = 'Diproses oleh Staff Procurement SP';

            $TANGGAL_DOKUMEN_RFQ = $this->input->post('TANGGAL_DOKUMEN_RFQ');
            $TANGGAL_PEMBUATAN_RFQ_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_RFQ_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_RFQ_BULAN = $dt;
            $TANGGAL_PEMBUATAN_RFQ_TAHUN = date("Y");
            $REVISI_KE = 0;

            //run validation check
            if ($this->form_validation->run() == FALSE) { //validation fails
                echo (validation_errors());
            } else {
                //check apakah NOMOR URUT RFQ_form sudah ada. jika belum ada, akan disimpan.
                if ($this->RFQ_model->cek_nomor_urut_rfq($NO_URUT_RFQ) == 'DATA BELUM ADA') {

                    $data = $this->RFQ_model->simpan_data_rfq(
                        $ID_SPPB,
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $FILE_NAME_TEMP,
                        $REVISI_KE,
                        $JUMLAH_COUNT_RFQ,
                        $TANGGAL_DOKUMEN_RFQ,
                        $NO_URUT_RFQ,
                        $CREATE_BY_USER,
                        $STATUS_RFQ,
                        $PROGRESS_RFQ,
                        $TANGGAL_PEMBUATAN_RFQ_JAM,
                        $TANGGAL_PEMBUATAN_RFQ_HARI,
                        $TANGGAL_PEMBUATAN_RFQ_BULAN,
                        $TANGGAL_PEMBUATAN_RFQ_TAHUN
                    );

                    $data_2 = $this->RFQ_model->set_md5_id_RFQ($ID_PROYEK, $ID_SPPB, $NO_URUT_RFQ, $CREATE_BY_USER);

                    echo $data_2;
                } else {
                    echo 'Nomor urut sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

            $this->form_validation->set_rules('NO_URUT_RFQ', 'Nomor Urut RFQ', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_RFQ', 'Tanggal Dokumen RFQ', 'trim|required');
            
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_RFQ = $this->input->post('JUMLAH_COUNT_RFQ');
            $NO_URUT_RFQ = $this->input->post('NO_URUT_RFQ');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');

            $STATUS_RFQ = ('DRAFT');
            $PROGRESS_RFQ = 'Diproses oleh Supervisi Procurement SP';

            $TANGGAL_DOKUMEN_RFQ = $this->input->post('TANGGAL_DOKUMEN_RFQ');
            $TANGGAL_PEMBUATAN_RFQ_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_RFQ_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_RFQ_BULAN = $dt;
            $TANGGAL_PEMBUATAN_RFQ_TAHUN = date("Y");
            $REVISI_KE = 0;

            //run validation check
            if ($this->form_validation->run() == FALSE) { //validation fails
                echo (validation_errors());
            } else {
                //check apakah NOMOR URUT RFQ_form sudah ada. jika belum ada, akan disimpan.
                if ($this->RFQ_model->cek_nomor_urut_rfq($NO_URUT_RFQ) == 'DATA BELUM ADA') {

                    $data = $this->RFQ_model->simpan_data_rfq(
                        $ID_SPPB,
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $FILE_NAME_TEMP,
                        $REVISI_KE,
                        $JUMLAH_COUNT_RFQ,
                        $TANGGAL_DOKUMEN_RFQ,
                        $NO_URUT_RFQ,
                        $CREATE_BY_USER,
                        $STATUS_RFQ,
                        $PROGRESS_RFQ,
                        $TANGGAL_PEMBUATAN_RFQ_JAM,
                        $TANGGAL_PEMBUATAN_RFQ_HARI,
                        $TANGGAL_PEMBUATAN_RFQ_BULAN,
                        $TANGGAL_PEMBUATAN_RFQ_TAHUN
                    );

                    $data_2 = $this->RFQ_model->set_md5_id_RFQ($ID_PROYEK, $ID_SPPB, $NO_URUT_RFQ, $CREATE_BY_USER);

                    echo $data_2;
                } else {
                    echo 'Nomor urut sudah terekam sebelumnya';
                }
            }
        } else {
            $this->logout();
        }
    }

    public function get_data_RFQ_baru() //092023
    {
        $user = $this->ion_auth->user()->row();
        $this->data['USER_ID'] = $user->id;
        $CREATE_BY_USER = $this->data['USER_ID'];

        if ($this->ion_auth->logged_in()) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_URUT_RFQ = $this->input->post('NO_URUT_RFQ');

            $data = $this->RFQ_model->get_data_rfq_baru($ID_PROYEK, $NO_URUT_RFQ, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 RFQ Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

}