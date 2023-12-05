<?php defined('BASEPATH') or exit('No direct script access allowed');

class KHP extends CI_Controller
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
        $this->data['title'] = 'SIPESUT | KHP';

        $this->load->model('KHP_model');
        $this->load->model('SPPB_model');
        $this->load->model('Foto_model');
        $this->load->model('Khp_model');
        $this->load->model('Proyek_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "KHP_aktif";
    }

    /**
     * Log the user out
     */
    public function logout() //112023
    {

        $ID_KHP = 0;
        $KETERANGAN = "Paksa Logout Ketika Akses KHP";
        $this->user_log_khp($ID_KHP, $KETERANGAN);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log_khp($ID_KHP, $KETERANGAN) //112023
    {
        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->KHP_model->user_log_khp($user->ID_PEGAWAI, $ID_KHP, $KETERANGAN, $WAKTU);
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index() //02112023
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

            $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
            $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
            $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

            $ID_KHP = 0;
            $KETERANGAN = "index: ";
            $this->user_log_khp($ID_KHP, $KETERANGAN);

            //jika mereka sebagai admin
            if ($this->ion_auth->is_admin()) {

            } else if ($this->ion_auth->in_group(5)) { //user_staff_procurement_kp

                //fungsi ini untuk mengirim data ke dropdown
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list();
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list();

                $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_kp/user_menu');
                $this->load->view('wasa/user_staff_procurement_kp/left_menu');
                $this->load->view('wasa/user_staff_procurement_kp/header_menu');
                $this->load->view('wasa/user_staff_procurement_kp/content_khp_list');
                $this->load->view('wasa/user_staff_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(6)) { //user_kasie_procurement_kp

                $this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_kasie_procurement_kp/user_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/left_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/header_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/content_khp_list');
                $this->load->view('wasa/user_kasie_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(7)) { //user_manajer_procurement_kp

                $this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_procurement_kp/user_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/left_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/header_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/content_khp_list');
                $this->load->view('wasa/user_manajer_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(8)) { //user_staff_procurement_sp

                $this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_sp/user_menu');
                $this->load->view('wasa/user_staff_procurement_sp/left_menu');
                $this->load->view('wasa/user_staff_procurement_sp/header_menu');
                $this->load->view('wasa/user_staff_procurement_sp/content_khp_list');
                $this->load->view('wasa/user_staff_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(9)) { //user_supervisi_procurement_sp

                $this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/content_khp_list');
                $this->load->view('wasa/user_supervisi_procurement_sp/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    function get_data_sppb_by_id_proyek() //112023
    {
        if ($this->ion_auth->logged_in()) {

            $ID_KHP = 0;
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $data = $this->KHP_model->get_data_sppb_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "get_data_sppb_by_id_proyek: " . json_encode($data);
            $this->user_log_khp( $ID_KHP, $KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->logout();
        }
    }

    function get_data_sub_pekerjaan_by_id_sppb() //2023
    {
        if ($this->ion_auth->logged_in()) {

            $ID_KHP = 0;
            $ID_SPPB = $this->input->post('ID_SPPB');
            $data = $this->KHP_model->get_data_sub_pekerjaan_by_id_sppb($ID_SPPB);
            echo json_encode($data);

            $KETERANGAN = "get_data_sub_pekerjaan_by_id_sppb: " . json_encode($data);
            $this->user_log_khp($ID_KHP, $KETERANGAN);
        } else {

            // set the flash data error message if there is one
            $this->logout();
        }
    }

    function list_KHP_by_all_proyek() //23092023
    {

        if ($this->ion_auth->logged_in()) {

            $ID_KHP = 0;
            $data = $this->KHP_model->list_KHP_by_all_proyek();
            echo json_encode($data);

            $KETERANGAN = "list_KHP_by_all_proyek: " . json_encode($data);
            $this->user_log_khp($ID_KHP, $KETERANGAN);

        } else {
            // set the flash data error message if there is one
            $this->logout();
        }
    }

    function list_KHP_by_id_proyek() //112023
    {

        if ($this->ion_auth->logged_in()) {

            $ID_KHP = 0;
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $data = $this->KHP_model->list_KHP_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "list_KHP_by_id_proyek: " . json_encode($data);
            $this->user_log_khp($ID_KHP, $KETERANGAN);
           
        } else {
            // set the flash data error message if there is one
            $this->logout();
        }
    }

    public function get_data() //122023
	{
		if ($this->ion_auth->logged_in()) {
			$ID_KHP = $this->input->post('ID_KHP');
			$data = $this->KHP_model->get_data_khp_by_ID_KHP($ID_KHP);
			echo json_encode($data);

			$KETERANGAN = "get_data: " . json_encode($data);
            $this->user_log_khp( $ID_KHP, $KETERANGAN);
		} else {
			$this->logout();
		}
	}

    // function data_KHP()
    // {

    //     if ($this->ion_auth->logged_in()) {
    
    //         $data = $this->KHP_model->sppb_list_khp();
    //         echo json_encode($data);

    //         $KETERANGAN = "Melihat Data SPPB bahan KHP: " . json_encode($data);
    //             $this->user_log($KETERANGAN);
            
    //     } else {
    //         // set the flash data error message if there is one
    //         $this->ion_auth->logout();
    //         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    //     }
    // }

    
    // function data_KHP_vendor()
    // {

    //     if ($this->ion_auth->logged_in()) {
    //         if ($this->ion_auth->in_group(38)) {

    //             $ID_VENDOR = $this->input->post('ID_VENDOR');

    //             date_default_timezone_set('Asia/Jakarta');
    //             $WAKTU = date('Y-m-d H:i:s');

    //             $data = $this->KHP_model->rfq_list_by_ID_VENDOR($ID_VENDOR, $WAKTU);
    //             echo json_encode($data);

    //             $KETERANGAN = "Melihat Data KHP: " . json_encode($data);
    //             $this->user_log($KETERANGAN);
    //         }
    //     } else {
    //         // set the flash data error message if there is one
    //         $this->ion_auth->logout();
    //         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    //     }
    // }

    // function get_data_proyek_by_hash_md5_sppb()
    // {
    //     if ($this->ion_auth->logged_in()) {
    //         $HASH_MD5_SPPB = $this->input->get('HASH_MD5_SPPB');
    //         $data = $this->KHP_model->get_data_proyek_by_hash_md5_sppb($HASH_MD5_SPPB);
    //         echo json_encode($data);

    //         $KETERANGAN = "Get Data Proyek: " . json_encode($data);
    //         $this->user_log($KETERANGAN);
    //     } else {
    //         // set the flash data error message if there is one
    //         $this->ion_auth->logout();
    //         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    //     }
    // }

    // function get_nomor_urut()
    // {
    //     if ($this->ion_auth->logged_in()) {
    //         $ID_PROYEK = $this->input->get('ID_PROYEK');
    //         $data = $this->KHP_model->get_nomor_urut_by_id_proyek($ID_PROYEK);
    //         echo json_encode($data);

    //         $KETERANGAN = "Get No. Urut KHP: " . json_encode($data);
    //         $this->user_log($KETERANGAN);
    //     } else {
    //         // set the flash data error message if there is one
    //         $this->ion_auth->logout();
    //         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    //     }
    // }

    function simpan_data()
    {
        $user = $this->ion_auth->user()->row();
        $this->data['USER_ID'] = $user->id;
        $CREATE_BY_USER = $this->data['USER_ID'];

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

            $this->form_validation->set_rules('ID_PROYEK', 'Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_SPPB', 'No. Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_KHP', 'No. Urut KHP', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_KHP', 'Tanggal Dokumen KHP', 'trim|required');

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_KHP = $this->input->post('JUMLAH_COUNT_KHP');
            $NO_URUT_KHP = $this->input->post('NO_URUT_KHP');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
            $TANGGAL_DOKUMEN_KHP = $this->input->post('TANGGAL_DOKUMEN_KHP');
            $TANGGAL_PEMBUATAN_KHP_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_KHP_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_KHP_BULAN = $dt;
            $TANGGAL_PEMBUATAN_KHP_TAHUN = date("Y");

            $PROGRESS_KHP = "Diproses oleh Staff Procurement KP";
            $STATUS_KHP = "DRAFT";

            //run validation check
            if ($this->form_validation->run() == FALSE) { //validation fails
                echo (validation_errors());
            } else {
                //check apakah NOMOR URUT KHP_form sudah ada. jika belum ada, akan disimpan.
                if ($this->KHP_model->cek_nomor_urut_KHP($NO_URUT_KHP) == 'DATA BELUM ADA') {

                    $data = $this->KHP_model->simpan_data_khp(
                        $ID_SPPB,
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $FILE_NAME_TEMP,
                        $JUMLAH_COUNT_KHP,
                        $TANGGAL_DOKUMEN_KHP,
                        $NO_URUT_KHP,
                        $CREATE_BY_USER,
                        $PROGRESS_KHP,
                        $STATUS_KHP,
                        $TANGGAL_PEMBUATAN_KHP_JAM,
                        $TANGGAL_PEMBUATAN_KHP_HARI,
                        $TANGGAL_PEMBUATAN_KHP_BULAN,
                        $TANGGAL_PEMBUATAN_KHP_TAHUN
                    );

                    $KETERANGAN = "simpan_data: "
                        . "; " .$ID_SPPB
                        . "; " .$ID_PROYEK
                        . "; " .$ID_PROYEK_SUB_PEKERJAAN
                        . "; " .$FILE_NAME_TEMP
                        . "; " .$JUMLAH_COUNT_KHP
                        . "; " .$TANGGAL_DOKUMEN_KHP
                        . "; " .$NO_URUT_KHP
                        . "; " .$CREATE_BY_USER
                        . "; " .$PROGRESS_KHP
                        . "; " .$STATUS_KHP
                        . "; " .$TANGGAL_PEMBUATAN_KHP_JAM
                        . "; " .$TANGGAL_PEMBUATAN_KHP_HARI
                        . "; " .$TANGGAL_PEMBUATAN_KHP_BULAN
                        . "; " .$TANGGAL_PEMBUATAN_KHP_TAHUN;
                    $ID_KHP = 0;
                    $this->user_log_khp($ID_KHP, $KETERANGAN);


                    $data_2 = $this->KHP_model->set_md5_id_KHP($ID_PROYEK, $ID_SPPB, $NO_URUT_KHP, $CREATE_BY_USER);

                    $KETERANGAN = "set_md5_id_KHP: "
                        . "; " .$ID_SPPB
                        . "; " .$ID_PROYEK
                        . "; " .$NO_URUT_KHP
                        . "; " .$CREATE_BY_USER;
                    $ID_KHP = 0;
                    $this->user_log_khp($ID_KHP, $KETERANGAN);

                    echo $data_2;

                } else {
                    echo 'Nomor urut sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $INISIAL = $this->input->post('INISIAL');
            $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_KHP = $this->input->post('JUMLAH_COUNT_KHP');
            $NO_URUT_KHP = $this->input->post('NO_URUT_KHP');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
            $PROGRESS_KHP = 'Dalam Proses Pembuatan Kasie Procurement KP'; //di grup lain nama progress berubah
            $TANGGAL_PEMBUATAN_KHP_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_KHP_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_KHP_BULAN = $dt;
            $TANGGAL_PEMBUATAN_KHP_TAHUN = date("Y");

            //check apakah NOMOR URUT KHP_form sudah ada. jika belum ada, akan disimpan.
            if ($this->KHP_model->cek_nomor_urut_KHP($NO_URUT_KHP) == 'DATA BELUM ADA') {

                $data = $this->KHP_model->simpan_data_khp(
                    $ID_SPPB,
                    $ID_PROYEK,
                    $JUMLAH_COUNT_KHP,
                    $NO_URUT_KHP,
                    $CREATE_BY_USER,
                    $PROGRESS_KHP,
                    $TANGGAL_PEMBUATAN_KHP_JAM,
                    $TANGGAL_PEMBUATAN_KHP_HARI,
                    $TANGGAL_PEMBUATAN_KHP_BULAN,
                    $TANGGAL_PEMBUATAN_KHP_TAHUN
                );


                $data_2 = $this->KHP_model->set_md5_id_KHP($ID_PROYEK, $ID_SPPB, $NO_URUT_KHP, $CREATE_BY_USER);

                echo $data_2;
            } else {
                echo 'Nomor urut sudah terekam sebelumnya';
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $INISIAL = $this->input->post('INISIAL');
            $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_KHP = $this->input->post('JUMLAH_COUNT_KHP');
            $NO_URUT_KHP = $this->input->post('NO_URUT_KHP');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
            $PROGRESS_KHP = 'Dalam Proses Pembuatan Manajer Procurement KP'; //di grup lain nama progress berubah
            $TANGGAL_PEMBUATAN_KHP_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_KHP_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_KHP_BULAN = $dt;
            $TANGGAL_PEMBUATAN_KHP_TAHUN = date("Y");

            //check apakah NOMOR URUT KHP_form sudah ada. jika belum ada, akan disimpan.
            if ($this->KHP_model->cek_nomor_urut_KHP($NO_URUT_KHP) == 'DATA BELUM ADA') {

                $data = $this->KHP_model->simpan_data_khp(
                    $ID_SPPB,
                    $ID_PROYEK,
                    $JUMLAH_COUNT_KHP,
                    $NO_URUT_KHP,
                    $CREATE_BY_USER,
                    $PROGRESS_KHP,
                    $TANGGAL_PEMBUATAN_KHP_JAM,
                    $TANGGAL_PEMBUATAN_KHP_HARI,
                    $TANGGAL_PEMBUATAN_KHP_BULAN,
                    $TANGGAL_PEMBUATAN_KHP_TAHUN
                );


                $data_2 = $this->KHP_model->set_md5_id_KHP($ID_PROYEK, $ID_SPPB, $NO_URUT_KHP, $CREATE_BY_USER);

                echo $data_2;
            } else {
                echo 'Nomor urut sudah terekam sebelumnya';
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $INISIAL = $this->input->post('INISIAL');
            $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_KHP = $this->input->post('JUMLAH_COUNT_KHP');
            $NO_URUT_KHP = $this->input->post('NO_URUT_KHP');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
            $PROGRESS_KHP = 'Dalam Proses Pembuatan Staff Procurement SP'; //di grup lain nama progress berubah
            $TANGGAL_PEMBUATAN_KHP_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_KHP_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_KHP_BULAN = $dt;
            $TANGGAL_PEMBUATAN_KHP_TAHUN = date("Y");

            //check apakah NOMOR URUT KHP_form sudah ada. jika belum ada, akan disimpan.
            if ($this->KHP_model->cek_nomor_urut_KHP($NO_URUT_KHP) == 'DATA BELUM ADA') {

                $data = $this->KHP_model->simpan_data_khp(
                    $ID_SPPB,
                    $ID_PROYEK,
                    $JUMLAH_COUNT_KHP,
                    $NO_URUT_KHP,
                    $CREATE_BY_USER,
                    $PROGRESS_KHP,
                    $TANGGAL_PEMBUATAN_KHP_JAM,
                    $TANGGAL_PEMBUATAN_KHP_HARI,
                    $TANGGAL_PEMBUATAN_KHP_BULAN,
                    $TANGGAL_PEMBUATAN_KHP_TAHUN
                );


                $data_2 = $this->KHP_model->set_md5_id_KHP($ID_PROYEK, $ID_SPPB, $NO_URUT_KHP, $CREATE_BY_USER);

                echo $data_2;
            } else {
                echo 'Nomor urut sudah terekam sebelumnya';
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(9))) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $INISIAL = $this->input->post('INISIAL');
            $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_KHP = $this->input->post('JUMLAH_COUNT_KHP');
            $NO_URUT_KHP = $this->input->post('NO_URUT_KHP');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
            $PROGRESS_KHP = 'Dalam Proses Pembuatan Supervisi Procurement SP'; //di grup lain nama progress berubah
            $TANGGAL_PEMBUATAN_KHP_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_KHP_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_KHP_BULAN = $dt;
            $TANGGAL_PEMBUATAN_KHP_TAHUN = date("Y");

            //check apakah NOMOR URUT KHP_form sudah ada. jika belum ada, akan disimpan.
            if ($this->KHP_model->cek_nomor_urut_KHP($NO_URUT_KHP) == 'DATA BELUM ADA') {

                $data = $this->KHP_model->simpan_data_khp(
                    $ID_SPPB,
                    $ID_PROYEK,
                    $JUMLAH_COUNT_KHP,
                    $NO_URUT_KHP,
                    $CREATE_BY_USER,
                    $PROGRESS_KHP,
                    $TANGGAL_PEMBUATAN_KHP_JAM,
                    $TANGGAL_PEMBUATAN_KHP_HARI,
                    $TANGGAL_PEMBUATAN_KHP_BULAN,
                    $TANGGAL_PEMBUATAN_KHP_TAHUN
                );


                $data_2 = $this->KHP_model->set_md5_id_KHP($ID_PROYEK, $ID_SPPB, $NO_URUT_KHP, $CREATE_BY_USER);

                echo $data_2;
            } else {
                echo 'Nomor urut sudah terekam sebelumnya';
            }
        } else {
            $this->logout();
        }
    }

    function get_data_khp_baru() //112023
    {
        if ($this->ion_auth->logged_in()) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;
            $CREATE_BY_USER = $this->data['USER_ID'];

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_URUT_KHP = $this->input->post('NO_URUT_KHP');

            $data = $this->KHP_model->get_data_khp_baru($ID_PROYEK, $NO_URUT_KHP, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "get_data_khp_baru: " . json_encode($data);
            $ID_KHP = 0;
            $this->user_log_khp($ID_KHP, $KETERANGAN);
        } else {
            $this->logout();
        }
    }

    // function get_list_khp_by_id_sppb()
    // {
    //     if ($this->ion_auth->logged_in()) {
    //         $ID_SPPB = $this->input->post('ID_SPPB');
    //         $data = $this->KHP_model->get_list_khp_by_id_sppb($ID_SPPB);
    //         echo json_encode($data);

    //         $KETERANGAN = "Get Data KHP: " . json_encode($data);
    //         $this->user_log($KETERANGAN);
    //     } else {
    //         // set the flash data error message if there is one
    //         $this->ion_auth->logout();
    //         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    //     }
    // }

// function get_data()
// {
//     if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
//         $id = $this->input->get('id');
//         $data = $this->SPPB_model->get_data_by_HASH_MD5_SPPB($id);
//         echo json_encode($data);

//         $KETERANGAN = "Get Data KHP: " . json_encode($data);
//         $this->user_log($KETERANGAN);
//     } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(8) || $this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4))) {
//         $id = $this->input->get('id');
//         $data = $this->SPPB_model->get_data_by_HASH_MD5_SPPB($id);
//         echo json_encode($data);

//         $KETERANGAN = "Get Data KHP: " . json_encode($data);
//         $this->user_log($KETERANGAN);
//     } else {
//         // set the flash data error message if there is one
//         $this->ion_auth->logout();
//         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
//     }
// }



// function get_nomor_urut_by_id_proyek()
// {
//     if ($this->ion_auth->logged_in()) {
//         $id = $this->input->get('id');
//         $data = $this->SPPB_model->get_nomor_urut_by_id_proyek($id);
//         echo json_encode($data);

//         $KETERANGAN = "Get No. Urut KHP: " . json_encode($data);
//         $this->user_log($KETERANGAN);
//     } else {
//         // set the flash data error message if there is one
//         $this->ion_auth->logout();
//         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
//     }
// }

// function hapus_data()
// {
//     if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

//         $HASH_MD5_SPPB = $this->input->post('kode');
//         $data_hapus = $this->SPPB_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

//         //HAPUS SEMUA DATA SETELAH KHP!!!

//         $data = $this->SPPB_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
//         echo json_encode($data);

//         $KETERANGAN = "Hapus Data KHP: " . json_encode($data_hapus);
//         $this->user_log($KETERANGAN);
//     } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3))) {

//         $HASH_MD5_SPPB = $this->input->post('kode');
//         $data_hapus = $this->SPPB_model->get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);

//         //HAPUS SEMUA DATA SETELAH KHP!!!


//         $data = $this->SPPB_model->hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
//         echo json_encode($data);

//         $KETERANGAN = "Hapus Data KHP: " . json_encode($data_hapus);
//         $this->user_log($KETERANGAN);
//     } else {
//         // set the flash data error message if there is one
//         $this->ion_auth->logout();
//         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
//     }
// }

// function simpan_data()
// {
//     if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
//         $user = $this->ion_auth->user()->row();

//         //set validation rules
//         $this->form_validation->set_rules('JENIS_PEKERJAAN', 'Jenis Pekerjaan', 'trim|required');
//         $this->form_validation->set_rules('TANGGAL_PEMBUATAN_SPPB', 'Tanggal Pembuatan KHP', 'trim|required|max_length[100]');


//         //run validation check
//         if ($this->form_validation->run() == FALSE) {   //validation fails
//             echo validation_errors();
//         } else {
//             //get the form data
//             $ID_RASD = $this->input->post('ID_RASD');
//             $JENIS_PEKERJAAN = $this->input->post('JENIS_PEKERJAAN');
//             $TANGGAL_PEMBUATAN_SPPB = $this->input->post('TANGGAL_PEMBUATAN_SPPB');
//             $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
//             $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
//             $LIST_FPB[] = $this->input->post('LIST_FPB');

//             //cek apakah nama Sppbsudah ada. jika belum ada, akan disimpan.
//             if ($this->SPPB_model->cek_no_urut_sppb_by_admin($NO_URUT_SPPB) == 'Data belum ada') {

//                 $hasil = $this->SPPB_model->simpan_data_by_admin(
//                     $ID_RASD,
//                     $JENIS_PEKERJAAN,
//                     $TANGGAL_PEMBUATAN_SPPB,
//                     $NO_URUT_SPPB,
//                     $JUMLAH_COUNT
//                 );
//             } else {
//                 echo 'No. Urut KHP sudah terekam sebelumnya';
//             }
//         }
//     } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3))) {

//         $user = $this->ion_auth->user()->row();
//         $this->data['user_id'] = $user->id;

//         //set validation rules
//         $this->form_validation->set_rules('JENIS_PEKERJAAN', 'Jenis Pekerjaan', 'trim|required');
//         $this->form_validation->set_rules('TANGGAL_PEMBUATAN_SPPB', 'Tanggal Pembuatan KHP', 'trim|required|max_length[100]');


//         //run validation check
//         if ($this->form_validation->run() == FALSE) {   //validation fails
//             echo validation_errors();
//         } else {
//             //get the form data
//             $ID_PROYEK = $this->input->post('ID_PROYEK');
//             $ID_RASD = $this->input->post('ID_RASD');
//             $JENIS_PEKERJAAN = $this->input->post('JENIS_PEKERJAAN');
//             $TANGGAL_PEMBUATAN_SPPB = $this->input->post('TANGGAL_PEMBUATAN_SPPB');
//             $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
//             $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
//             $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
//             $LIST_FPB = $this->input->post('LIST_FPB');


//             $CREATE_BY_USER =  $this->data['user_id'];
//             if ($this->ion_auth->in_group(2)) {
//                 $PROGRESS_SPPB = "Dalam Proses Staff Logistik";
//                 $STATUS_SPPB = "Draft";
//             }

//             if ($this->ion_auth->in_group(3)) {
//                 $PROGRESS_SPPB = "Dalam Proses Supervisor Logistik";
//                 $STATUS_SPPB = "Draft";
//             }


//             //check apakah nama KHP sudah ada. jika belum ada, akan disimpan.
//             if ($this->SPPB_model->cek_no_urut_sppb_by_admin($NO_URUT_SPPB) == 'Data belum ada') {

//                 $hasil = $this->SPPB_model->simpan_data_by_staff_logistic(
//                     $ID_RASD,
//                     $ID_PROYEK,
//                     $JENIS_PEKERJAAN,
//                     $TANGGAL_PEMBUATAN_SPPB,
//                     $NO_URUT_SPPB,
//                     $JUMLAH_COUNT,
//                     $CREATE_BY_USER,
//                     $PROGRESS_SPPB,
//                     $STATUS_SPPB,
//                     $FILE_NAME_TEMP
//                 );

//                 $hasil_2 = $this->SPPB_model->set_md5_id_sppb($ID_RASD, $NO_URUT_SPPB, $CREATE_BY_USER);

//                 //echo var_dump($hasil_2);
//             } else {
//                 echo 'No. Urut KHP sudah terekam sebelumnya';
//             }
//         }
//     } else {
//         $this->logout();
//     }
// }

// function get_data_sppb_baru()
// {
//     if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2))) {
//         $ID_PROYEK = $this->input->post('ID_PROYEK');
//         $TANGGAL_PEMBUATAN_SPPB = $this->input->post('TANGGAL_PEMBUATAN_SPPB');
//         $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
//         $USER_ID = $this->input->post('USER_ID');

//         $data = $this->SPPB_model->get_data_sppb_baru($ID_PROYEK, $TANGGAL_PEMBUATAN_SPPB, $NO_URUT_SPPB, $USER_ID);
//         echo json_encode($data);

//         $KETERANGAN = "Get Data MD5 KHP Baru: " . json_encode($data);
//         $this->user_log($KETERANGAN);
//     } else {
//         $this->logout();
//     }
// }

// function simpan_perubahan_sppb()
// {
//     if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
//         $user = $this->ion_auth->user()->row();

//         //set validation rules
//         $this->form_validation->set_rules('CTT', 'CTT', 'trim');
//         // run validation check
//         if ($this->form_validation->run() == FALSE) {   //validation fails
//             echo validation_errors();
//         } else {
//             $ID_SPPB = $this->input->post('ID_SPPB');
//             $CTT = $this->input->post('CTT');
//             $this->SPPB_model->update_data_ubah_logistik($ID_SPPB, $CTT);
//             redirect('sppb', 'refresh');
//         }
//     } else {
//         // set the flash data error message if there is one
//         $this->ion_auth->logout();
//         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
//     }
// }

// function simpan_ajuan_akhir()
// {
//     if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
//         $user = $this->ion_auth->user()->row();

//         //set validation rules
//         $this->form_validation->set_rules('CTT', 'CTT', 'trim');
//         // run validation check
//         if ($this->form_validation->run() == FALSE) {   //validation fails
//             echo validation_errors();
//         } else {
//             $ID_SPPB = $this->input->post('ID_SPPB');
//             $CTT = $this->input->post('CTT');
//             $this->SPPB_model->update_data_akhir($ID_SPPB, $CTT);
//             $ID_KHP = $this->Khp_model->simpan_data_by_admin($ID_SPPB);
//             $list_sppb_barang = $this->Sppb_barang_model->sppb_barang_list_by_id_sppb($ID_SPPB);
//             foreach ($list_sppb_barang as $index => $value) {
//                 $this->Khp_model->simpan_data_khp_barang_by_admin($ID_KHP, $value->ID_SPPB_BARANG, $value->JUMLAH_SETUJU_D_KEU);
//             }
//             redirect('sppb', 'refresh');
//         }
//     } else {
//         // set the flash data error message if there is one
//         $this->ion_auth->logout();
//         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
//     }
// }

// function update_data()
// {
//     if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
//         $user = $this->ion_auth->user()->row();

//         //set validation rules
//         $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
//         $this->form_validation->set_rules('ALIAS', 'Alias', 'trim|required');
//         $this->form_validation->set_rules('MEREK', 'Merek', 'trim|required|max_length[100]');
//         $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
//         $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
//         $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|max_length[30]');
//         $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|max_length[30]');
//         $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
//         $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
//         $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
//         $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
//         $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim|required');
//         $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
//         $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim|required');
//         $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
//         $this->form_validation->set_rules('GAMBAR_1', 'Gambar 1', 'trim');
//         $this->form_validation->set_rules('GAMBAR_2', 'Gambar 2', 'trim');
//         $this->form_validation->set_rules('GAMBAR_3', 'Gambar 3', 'trim');
//         $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[20]');
//         $this->form_validation->set_rules('DOK_BUKU_PANDUAN', 'Dokumen Buku Panduan', 'trim');
//         $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|required|max_length[12]');

//         //run validation check
//         if ($this->form_validation->run() == FALSE) {   //validation fails
//             echo json_encode(validation_errors());
//         } else {
//             //get the form data
//             $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
//             $NAMA = $this->input->post('NAMA');
//             $ALIAS = $this->input->post('ALIAS');
//             $MEREK = $this->input->post('MEREK');
//             $JENIS_BARANG = $this->input->post('JENIS_BARANG');
//             $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
//             $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
//             $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
//             $KODE_BARANG = $this->input->post('KODE_BARANG');
//             $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
//             $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
//             $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
//             $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
//             $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
//             $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
//             $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
//             $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
//             $GAMBAR_1 = $this->input->post('GAMBAR_1');
//             $GAMBAR_2 = $this->input->post('GAMBAR_2');
//             $GAMBAR_3 = $this->input->post('GAMBAR_3');
//             $DOK_BUKU_PANDUAN = $this->input->post('DOK_BUKU_PANDUAN');
//             $MASA_PAKAI = $this->input->post('MASA_PAKAI');

//             //cek apakah input sama dengan eksisting
//             $data = $this->SPPB_model->get_data_by_id_sppb($ID_BARANG_MASTER);

//             if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->SPPB_model->cek_nama_sppb_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
//                 $data = $this->SPPB_model->get_data_by_id_sppb($ID_BARANG_MASTER);
//                 //log
//                 // $KETERANGAN = "Ubah KHP".$data['NAMA_Sppb']." jadi ".$nama_Sppb.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
//                 // $WAKTU = date('Y-m-d H:i:s');
//                 // $this->SPPB_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

//                 $data = $this->SPPB_model->update_data(
//                     $ID_BARANG_MASTER,
//                     $NAMA,
//                     $ALIAS,
//                     $MEREK,
//                     $NAMA_SATUAN_BARANG,
//                     $JENIS_BARANG,
//                     $PERALATAN_PERLENGKAPAN,
//                     $GROSS_WEIGHT,
//                     $NETT_WEIGHT,
//                     $DIMENSI_PANJANG,
//                     $DIMENSI_LEBAR,
//                     $DIMENSI_TINGGI,
//                     $SPESIFIKASI_LENGKAP,
//                     $SPESIFIKASI_SINGKAT,
//                     $CARA_SINGKAT_PENGGUNAAN,
//                     $CARA_PENYIMPANAN_BARANG,
//                     $KODE_BARANG,
//                     $GAMBAR_1,
//                     $GAMBAR_2,
//                     $GAMBAR_3,
//                     $DOK_BUKU_PANDUAN,
//                     $MASA_PAKAI
//                 );
//                 echo json_encode($data);
//             } else {
//                 echo json_encode('Nama Sppbsudah terekam sebelumnya');
//             }
//         }
//     } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4))) {
//         $user = $this->ion_auth->user()->row();

//         //set validation rules
//         $this->form_validation->set_rules('nama_sppb2', 'Nama KHP', 'trim|required');
//         $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

//         //run validation check
//         if ($this->form_validation->run() == FALSE) {   //validation fails
//             echo json_encode(validation_errors());
//         } else {
//             //get the form data
//             $id_sppb = $this->input->post('id_sppb2');
//             $nama_sppb = $this->input->post('nama_sppb2');
//             $keterangan = $this->input->post('keterangan2');

//             //cek apakah input sama dengan eksisting
//             $data = $this->SPPB_model->get_data_by_id_sppb($id_sppb);

//             if ($data['NAMA_BARANG_MASTER'] == $nama_sppb || ($this->SPPB_model->cek_nama_sppb_by_pegawai($nama_sppb, $user->ID_PEGAWAI) == 'Data belum ada')) {
//                 $data = $this->SPPB_model->get_data_by_id_sppb($id_sppb);

//                 //log
//                 $KETERANGAN = "Ubah KHP" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_sppb . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
//                 $WAKTU = date('Y-m-d H:i:s');
//                 $this->SPPB_model->log_Sppb($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

//                 $data = $this->SPPB_model->update_data($id_sppb, $nama_sppb, $keterangan);
//                 echo json_encode($data);
//             } else {
//                 echo json_encode('Nama Sppbsudah terekam sebelumnya');
//             }
//         }
//     } else {
//         // set the flash data error message if there is one
//         $this->ion_auth->logout();
//         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
//     }
// }

// //custom validation function to accept alphabets and space
// function alpha_space_only($str)
// {
//     if (!preg_match("/^[a-zA-Z ]+$/", $str)) {
//         $this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space');
//         return FALSE;
//     } else {
//         return TRUE;
//     }
// }

// //TAMPILAN TAMBAH
// function view_tambah()
// {
//     //jika mereka belum login
//     if (!$this->ion_auth->logged_in()) {
//         // alihkan mereka ke halaman login
//         redirect('auth/login', 'refresh');
//     }

//     //get data tabel users untuk ditampilkan
//     $user = $this->ion_auth->user()->row();
//     $this->data['ip_address'] = $user->ip_address;
//     $this->data['email'] = $user->email;
//     $this->data['user_id'] = $user->id;
//     $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
//     $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
//     $this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
//     $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
//     $this->data['left_menu'] = "sppb_aktif";

//     $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
//     if ($query_foto_user == "BELUM ADA FOTO") {
//         $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
//     } else {
//         $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
//     }

//     //jika mereka sudah login dan sebagai admin
//     if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
//         //fungsi ini untuk mengirim data ke dropdown
//         // $this->data['proyek'] = $this->Proyek_model->list_proyek();
//         $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
//         $this->data['rasd'] = $this->RASD_model->RASD_list();
//         $this->load->view('wasa/user_admin/head_normal', $this->data);
//         $this->load->view('wasa/user_admin/user_menu');
//         $this->load->view('wasa/user_admin/left_menu');
//         $this->load->view('wasa/user_admin/header_menu');
//         $this->load->view('wasa/user_admin/content_sppb_tambah');
//         $this->load->view('wasa/user_admin/footer');
//     }
//     // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
//     // {	
//     // 	$this->load->view('wasa/pegawai/head_normal', $this->data);
//     // 	$this->load->view('wasa/pegawai/user_menu');
//     // 	$this->load->view('wasa/pegawai/left_menu');
//     // 	$this->load->view('wasa/pegawai/content_Sppb');
//     // }
//     else {
//         // set the flash data error message if there is one
//         $this->ion_auth->logout();
//         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
//     }
// }

// //TAMPILAN UBAH
// function view_ubah()
// {
//     //jika mereka belum login
//     if (!$this->ion_auth->logged_in()) {
//         // alihkan mereka ke halaman login
//         redirect('auth/login', 'refresh');
//     }

//     //get data tabel users untuk ditampilkan
//     $user = $this->ion_auth->user()->row();
//     $this->data['ip_address'] = $user->ip_address;
//     $this->data['email'] = $user->email;
//     $this->data['user_id'] = $user->id;
//     $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
//     $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
//     $this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
//     $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
//     $this->data['left_menu'] = "sppb_aktif";

//     $this->data['id_ubah'] = $this->uri->segment(3);
//     $cek_data_barang = $this->SPPB_model->get_data_by_id_sppb($this->data['id_ubah']);
//     if ($cek_data_barang == "BELUM ADA BARANG MASTER") {
//         redirect('sppb', 'refresh');
//     }

//     $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
//     if ($query_foto_user == "BELUM ADA FOTO") {
//         $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
//     } else {
//         $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
//     }

//     //jika mereka sudah login dan sebagai admin
//     if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
//         //fungsi ini untuk mengirim data ke dropdown
//         // $this->data['proyek'] = $this->Proyek_model->list_proyek();
//         $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();

//         $this->load->view('wasa/user_admin/head_normal', $this->data);
//         $this->load->view('wasa/user_admin/user_menu');
//         $this->load->view('wasa/user_admin/left_menu');
//         $this->load->view('wasa/user_admin/header_menu');
//         $this->load->view('wasa/user_admin/content_sppb_ubah');
//         $this->load->view('wasa/user_admin/footer');
//     }
//     // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
//     // {	
//     // 	$this->load->view('wasa/pegawai/head_normal', $this->data);
//     // 	$this->load->view('wasa/pegawai/user_menu');
//     // 	$this->load->view('wasa/pegawai/left_menu');
//     // 	$this->load->view('wasa/pegawai/content_Sppb');
//     // }
//     else {
//         // set the flash data error message if there is one
//         $this->ion_auth->logout();
//         $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
//     }
// }
}