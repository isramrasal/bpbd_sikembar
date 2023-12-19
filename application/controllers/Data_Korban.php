<?php defined('BASEPATH') or exit('No direct script access allowed');

class Data_Korban extends CI_Controller
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
        $this->data['title'] = 'SiKembar | Data_Korban';

        $this->load->model('RASD_model');
        $this->load->model('SPPB_model');
        $this->load->model('Data_Korban_model');
        $this->load->model('SPP_model');
        $this->load->model('PO_model');
        $this->load->model('Foto_model');
        $this->load->model('Proyek_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "data_korban_aktif";
    }

    /**
     * Log the user out
     */
    public function logout() //belum diperbaiki
    {
        $ID_FSTB = 0;
        $KETERANGAN = "Paksa Logout Ketika Akses Pengajuan";
        $this->user_log_sppb($ID_SPPB, $KETERANGAN);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log_sppb($ID_SPPB, $KETERANGAN) //belum diperbaiki
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->SPPB_model->user_log_sppb($user->ID_PEGAWAI, $ID_SPPB, $KETERANGAN, $WAKTU);
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index() //BELUM CLEAN SEMUA USER //belum diperbaiki
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
        $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI; //harusnya tidak ada
        $data_role_user = $this->Manajemen_user_model->get_data_role_user_by_id($this->data['user_id']);
        $this->data['role_user'] = $data_role_user['description'];
        $this->data['NAMA_PROYEK'] = $data_role_user['NAMA_PROYEK']; //harusnya tidak ada
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

        $ID_SPPB = 0; //91-93 harus diubah
        $KETERANGAN = "Melihat Halaman Index SPPB List: ";
        $this->user_log_sppb($ID_SPPB, $KETERANGAN);

        $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
        $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
        $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

        $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
        $this->data['INISIAL'] = $data_proyek['INISIAL'];
        $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

        $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
        $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
        $this->session->set_userdata($sess_data);

        //jika mereka sudah login
        if ($this->ion_auth->logged_in()) {
            if ($this->ion_auth->in_group(3)) { //user_korban_bencana

                // tampilkan seluruh proyek
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list();
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list();

                $this->load->view('wasa/user_korban_bencana/head_normal', $this->data);
                $this->load->view('wasa/user_korban_bencana/user_menu');
                $this->load->view('wasa/user_korban_bencana/left_menu');
                $this->load->view('wasa/user_korban_bencana/header_menu');
                $this->load->view('wasa/user_korban_bencana/content_data_korban_list');
                $this->load->view('wasa/user_korban_bencana/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    function list_sppb_by_all_proyek() //102023
    {

        if ($this->ion_auth->logged_in()) {

            $data = $this->SPPB_model->list_sppb_by_all_proyek();
            echo json_encode($data);

            $ID_SPPB = 0;
            $KETERANGAN = "Melihat Data SPPB: " . json_encode($data);
            $this->user_log_sppb($ID_SPPB, $KETERANGAN);
            
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function data_qty_sppb_form() //102023
	{
        if ($this->ion_auth->logged_in())
        {
            $ID_SPPB = $this->input->post('ID_SPPB');
            $data = $this->SPPB_model->qty_sppb_form_by_id_sppb($ID_SPPB);
            echo json_encode($data);

            $ID_SPPB = $ID_SPPB;
            $KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
            $this->user_log_sppb($ID_SPPB, $KETERANGAN);
        }
		else {
			$this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

    function generate_md5() //102023
	{
        if ($this->ion_auth->logged_in())
        {
            $TANGGAL_PEMBUATAN_PENGAJUAN_JAM = date("h:i:s.u");
            $CODE_md5 = md5($TANGGAL_PEMBUATAN_PENGAJUAN_JAM);
            echo json_encode($CODE_md5);
        }
		else {
			$this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

    function data_sppb_by_id_proyek()//BEDA KP DAN SP
    {

        if ($this->ion_auth->logged_in()) {
            if ($this->ion_auth->is_admin()) {
                $data = $this->SPPB_model->sppb_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data SPPB: " . json_encode($data);
                $this->user_log_sppb($ID_SPPB, $KETERANGAN);
            } else if ($this->ion_auth->in_group(5)) {

                $data = $this->SPPB_model->sppb_list();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data SPPB: " . json_encode($data);
                $this->user_log_sppb($ID_SPPB, $KETERANGAN);
            } else if ($this->ion_auth->in_group(8)) {

                $ID_PROYEK = $this->session->userdata('ID_PROYEK');
                $data = $this->SPPB_model->sppb_list_by_id_proyek($ID_PROYEK);
                echo json_encode($data);

                $KETERANGAN = "Melihat Data SPPB: " . json_encode($data);
                $this->user_log_sppb($ID_SPPB, $KETERANGAN);
            } else if ($this->ion_auth->in_group(9)) {

                $ID_PROYEK = $this->session->userdata('ID_PROYEK');
                $data = $this->SPPB_model->sppb_list_by_id_proyek($ID_PROYEK);
                echo json_encode($data);

                $KETERANGAN = "Melihat Data SPPB: " . json_encode($data);
                $this->user_log_sppb($ID_SPPB, $KETERANGAN);
            } 
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function list_sppb_by_id_proyek() //102023
    {
        if ($this->ion_auth->logged_in()) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $data = $this->SPPB_model->list_sppb_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $ID_SPPB = 0;
            $KETERANGAN = "Melihat Data SPPB: " . json_encode($data);
            $this->user_log_sppb($ID_SPPB, $KETERANGAN);
            
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function data_sppb_by_id_sppb() //102023
    {
        if ($this->ion_auth->logged_in()) 
        {
            $ID_SPPB = $this->input->post('ID_SPPB');
            $data = $this->SPPB_model->sppb_list_by_id_sppb_result($ID_SPPB);
            echo json_encode($data);

            $ID_SPPB = $ID_SPPB;
            $KETERANGAN = "Melihat Data SPPB: " . json_encode($data);
            $this->user_log_sppb($ID_SPPB, $KETERANGAN);
            
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function data_sub_pekerjaan_by_id_proyek() //102023
    {
        if($this->ion_auth->logged_in() )
        {
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $data = $this->SPPB_model->data_sub_pekerjaan_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $ID_SPPB = 0;
            $KETERANGAN = "Get Data Sub Pekerjaan: " . json_encode($data);
            $this->user_log_sppb($ID_SPPB, $KETERANGAN);
        }
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_data_pengajuan_bantuan_baru() //102023
    {
        if ($this->ion_auth->logged_in()) {
            $CODE_MD5 = $this->input->post('CODE_MD5');

            $data = $this->Pengajuan_model->get_data_pengajuan_baru($CODE_MD5);
            echo json_encode($data);
        } else {
            $this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_nomor_urut_by_id_proyek()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PROYEK = $this->input->get('ID_PROYEK');
            $data = $this->SPPB_model->get_nomor_urut_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Nomor Urut SPPB: " . json_encode($data);
            $this->user_log_sppb($ID_SPPB, $KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_list_spp_by_id_sppb() //102023
    {
        if ($this->ion_auth->logged_in()) {
            $ID_SPPB = $this->input->post('ID_SPPB');
            $data = $this->SPP_model->get_list_spp_by_id_sppb($ID_SPPB);
            echo json_encode($data);

            $ID_SPPB = $ID_SPPB;
            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log_sppb($ID_SPPB, $KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
        }
    }

    function get_list_po_by_id_spp() //102023
    {
        if ($this->ion_auth->logged_in()) {
            $ID_SPP = $this->input->post('ID_SPP');
            $data = $this->PO_model->get_list_po_by_id_spp($ID_SPP);
            echo json_encode($data);

            $ID_SPPB = 0;
            $KETERANGAN = "Get Data PO: " . json_encode($data);
            $this->user_log_sppb($ID_SPPB, $KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
        }
    }

    function get_list_fstb_by_id_po() //102023
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PO = $this->input->post('ID_PO');
            $data = $this->PO_model->get_list_fstb_by_id_po($ID_PO);
            echo json_encode($data);

            $ID_SPPB = 0;
            $KETERANGAN = "Get Data FSTB: " . json_encode($data);
            $this->user_log_sppb($ID_SPPB, $KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
        }
    }

    function simpan_data_sppb_pembelian() //BEDA KP DAN SP //102023
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            $user = $this->ion_auth->user()->row();
            $this->data['user_id'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('ID_PROYEK', 'Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK_SUB_PEKERJAAN', 'Pekerjaan', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_SPPB', 'Nomor Urut SPPB', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_SPPB', 'Tanggal Pembuatan SPPB', 'trim|required|max_length[100]');
            

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
                $TANGGAL_DOKUMEN_SPPB = $this->input->post('TANGGAL_DOKUMEN_SPPB');
                $TANGGAL_PEMBUATAN_SPPB_JAM = date("h:i:s.u");
                $TANGGAL_PEMBUATAN_SPPB_HARI = date('Y-m-d');
                $dt = date('F');
                $TANGGAL_PEMBUATAN_SPPB_BULAN = $dt;
                $TANGGAL_PEMBUATAN_SPPB_TAHUN = date("Y");
                $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $CREATE_BY_USER =  $this->data['user_id'];

                $PROGRESS_SPPB = "Diproses oleh Staff Procurement KP";
                $STATUS_SPPB = "DRAFT";


                //check apakah NO URUT SPPB sudah ada. jika belum ada, akan disimpan.
                if ($this->SPPB_model->cek_no_urut_sppb($NO_URUT_SPPB) == 'Data belum ada') {

                    $hasil = $this->SPPB_model->simpan_data_sppb_pembelian_by_staff_proc_kp(
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $TANGGAL_DOKUMEN_SPPB,
                        $TANGGAL_PEMBUATAN_SPPB_JAM,
                        $TANGGAL_PEMBUATAN_SPPB_HARI,
                        $TANGGAL_PEMBUATAN_SPPB_BULAN,
                        $TANGGAL_PEMBUATAN_SPPB_TAHUN,
                        $NO_URUT_SPPB,
                        $JUMLAH_COUNT,
                        $CREATE_BY_USER,
                        $PROGRESS_SPPB,
                        $STATUS_SPPB,
                        $FILE_NAME_TEMP
                    );

                    $KETERANGAN = "Simpan SPPB: "
                        . "; " . $ID_PROYEK
                        . "; " . $TANGGAL_DOKUMEN_SPPB
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_JAM
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_HARI
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_BULAN
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_TAHUN
                        . "; " . $NO_URUT_SPPB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $CREATE_BY_USER
                        . "; " . $PROGRESS_SPPB
                        . "; " . $STATUS_SPPB
                        . "; " . $FILE_NAME_TEMP;
                    $ID_SPPB = 0;
                    $this->user_log_sppb($ID_SPPB, $KETERANGAN);

                    $hasil_2 = $this->SPPB_model->set_md5_id_sppb_pembelian($ID_PROYEK, $NO_URUT_SPPB, $CREATE_BY_USER);

                    $ID_SPPB = 0;
                    $KETERANGAN = "Update MD5 SPPB: " . $ID_PROYEK . "; " . $NO_URUT_SPPB
                        . "; " . $CREATE_BY_USER;
                    $this->user_log_sppb($ID_SPPB, $KETERANGAN);
                } else {
                    echo 'Nomor Urut SPPB sudah terekam sebelumnya';
                }
            }
        } 
        else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

            $user = $this->ion_auth->user()->row();
            $this->data['user_id'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('ID_PROYEK', 'Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK_SUB_PEKERJAAN', 'Pekerjaan', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_SPPB', 'Nomor Urut SPPB', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_SPPB', 'Tanggal Pembuatan SPPB', 'trim|required|max_length[100]');
            

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
                $TANGGAL_DOKUMEN_SPPB = $this->input->post('TANGGAL_DOKUMEN_SPPB');
                $TANGGAL_PEMBUATAN_SPPB_JAM = date("h:i:s.u");
                $TANGGAL_PEMBUATAN_SPPB_HARI = date('Y-m-d');
                $dt = date('F');
                $TANGGAL_PEMBUATAN_SPPB_BULAN = $dt;
                $TANGGAL_PEMBUATAN_SPPB_TAHUN = date("Y");
                $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $CREATE_BY_USER =  $this->data['user_id'];

                $PROGRESS_SPPB = "Diproses oleh Staff Procurement KP";
                $STATUS_SPPB = "DRAFT";


                //check apakah NO URUT SPPB sudah ada. jika belum ada, akan disimpan.
                if ($this->SPPB_model->cek_no_urut_sppb($NO_URUT_SPPB) == 'Data belum ada') {

                    $hasil = $this->SPPB_model->simpan_data_sppb_pembelian_by_staff_proc_kp(
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $TANGGAL_DOKUMEN_SPPB,
                        $TANGGAL_PEMBUATAN_SPPB_JAM,
                        $TANGGAL_PEMBUATAN_SPPB_HARI,
                        $TANGGAL_PEMBUATAN_SPPB_BULAN,
                        $TANGGAL_PEMBUATAN_SPPB_TAHUN,
                        $NO_URUT_SPPB,
                        $JUMLAH_COUNT,
                        $CREATE_BY_USER,
                        $PROGRESS_SPPB,
                        $STATUS_SPPB,
                        $FILE_NAME_TEMP
                    );

                    $KETERANGAN = "Simpan SPPB: "
                        . "; " . $ID_PROYEK
                        . "; " . $TANGGAL_DOKUMEN_SPPB
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_JAM
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_HARI
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_BULAN
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_TAHUN
                        . "; " . $NO_URUT_SPPB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $CREATE_BY_USER
                        . "; " . $PROGRESS_SPPB
                        . "; " . $STATUS_SPPB
                        . "; " . $FILE_NAME_TEMP;
                    $ID_SPPB = 0;
                    $this->user_log_sppb($ID_SPPB, $KETERANGAN);

                    $hasil_2 = $this->SPPB_model->set_md5_id_sppb_pembelian($ID_PROYEK, $NO_URUT_SPPB, $CREATE_BY_USER);

                    $ID_SPPB = 0;
                    $KETERANGAN = "Update MD5 SPPB: " . $ID_PROYEK . "; " . $NO_URUT_SPPB
                        . "; " . $CREATE_BY_USER;
                    $this->user_log_sppb($ID_SPPB, $KETERANGAN);
                } else {
                    echo 'Nomor Urut SPPB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

            $user = $this->ion_auth->user()->row();
            $this->data['user_id'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('ID_PROYEK', 'Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK_SUB_PEKERJAAN', 'Pekerjaan', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_SPPB', 'Nomor Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_SPPB', 'Tanggal Pembuatan SPPB', 'trim|required|max_length[100]');
            

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
                $TANGGAL_DOKUMEN_SPPB = $this->input->post('TANGGAL_DOKUMEN_SPPB');
                $TANGGAL_PEMBUATAN_SPPB_JAM = date("h:i:s.u");
                $TANGGAL_PEMBUATAN_SPPB_HARI = date('Y-m-d');
                $dt = date('F');
                $TANGGAL_PEMBUATAN_SPPB_BULAN = $dt;
                $TANGGAL_PEMBUATAN_SPPB_TAHUN = date("Y");
                $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $CREATE_BY_USER =  $this->data['user_id'];

                
                $PROGRESS_SPPB = "Diproses oleh Staff Procurement SP";
                $STATUS_SPPB = "DRAFT";


                //check apakah NO URUT SPPB sudah ada. jika belum ada, akan disimpan.
                if ($this->SPPB_model->cek_no_urut_sppb($NO_URUT_SPPB) == 'Data belum ada') {

                    $hasil = $this->SPPB_model->simpan_data_sppb_pembelian_by_staff_proc_kp(
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $TANGGAL_DOKUMEN_SPPB,
                        $TANGGAL_PEMBUATAN_SPPB_JAM,
                        $TANGGAL_PEMBUATAN_SPPB_HARI,
                        $TANGGAL_PEMBUATAN_SPPB_BULAN,
                        $TANGGAL_PEMBUATAN_SPPB_TAHUN,
                        $NO_URUT_SPPB,
                        $JUMLAH_COUNT,
                        $CREATE_BY_USER,
                        $PROGRESS_SPPB,
                        $STATUS_SPPB,
                        $FILE_NAME_TEMP
                    );

                    $KETERANGAN = "Simpan SPPB: "
                        . "; " . $ID_PROYEK
                        . "; " . $TANGGAL_DOKUMEN_SPPB
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_JAM
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_HARI
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_BULAN
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_TAHUN
                        . "; " . $NO_URUT_SPPB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $CREATE_BY_USER
                        . "; " . $PROGRESS_SPPB
                        . "; " . $STATUS_SPPB
                        . "; " . $FILE_NAME_TEMP;
                    $ID_SPPB = 0;
                    $this->user_log_sppb($ID_SPPB, $KETERANGAN);
                    

                    $hasil_2 = $this->SPPB_model->set_md5_id_sppb_pembelian($ID_PROYEK, $NO_URUT_SPPB, $CREATE_BY_USER);

                    $ID_SPPB = 0;
                    $KETERANGAN = "Update MD5 SPPB: " . $ID_PROYEK . "; " . $NO_URUT_SPPB
                        . "; " . $CREATE_BY_USER;
                    $this->user_log_sppb($ID_SPPB, $KETERANGAN);
                } else {
                    echo 'Nomor Urut SPPB sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

            $user = $this->ion_auth->user()->row();
            $this->data['user_id'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('ID_PROYEK', 'Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK_SUB_PEKERJAAN', 'Pekerjaan', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_SPPB', 'Nomor Urut SPPB', 'trim|required|max_length[250]');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_SPPB', 'Tanggal Pembuatan SPPB', 'trim|required|max_length[100]');
            

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
                $TANGGAL_DOKUMEN_SPPB = $this->input->post('TANGGAL_DOKUMEN_SPPB');
                $TANGGAL_PEMBUATAN_SPPB_JAM = date("h:i:s.u");
                $TANGGAL_PEMBUATAN_SPPB_HARI = date('Y-m-d');
                $dt = date('F');
                $TANGGAL_PEMBUATAN_SPPB_BULAN = $dt;
                $TANGGAL_PEMBUATAN_SPPB_TAHUN = date("Y");
                $NO_URUT_SPPB = $this->input->post('NO_URUT_SPPB');
                $JUMLAH_COUNT = $this->input->post('JUMLAH_COUNT');
                $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
                $CREATE_BY_USER =  $this->data['user_id'];

                
                $PROGRESS_SPPB = "Diproses oleh Supervisi Procurement SP";
                $STATUS_SPPB = "DRAFT";


                //check apakah NO URUT SPPB sudah ada. jika belum ada, akan disimpan.
                if ($this->SPPB_model->cek_no_urut_sppb($NO_URUT_SPPB) == 'Data belum ada') {

                    $hasil = $this->SPPB_model->simpan_data_sppb_pembelian_by_staff_proc_kp(
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $TANGGAL_DOKUMEN_SPPB,
                        $TANGGAL_PEMBUATAN_SPPB_JAM,
                        $TANGGAL_PEMBUATAN_SPPB_HARI,
                        $TANGGAL_PEMBUATAN_SPPB_BULAN,
                        $TANGGAL_PEMBUATAN_SPPB_TAHUN,
                        $NO_URUT_SPPB,
                        $JUMLAH_COUNT,
                        $CREATE_BY_USER,
                        $PROGRESS_SPPB,
                        $STATUS_SPPB,
                        $FILE_NAME_TEMP
                    );

                    $KETERANGAN = "Simpan SPPB: "
                        . "; " . $ID_PROYEK
                        . "; " . $TANGGAL_DOKUMEN_SPPB
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_JAM
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_HARI
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_BULAN
                        . "; " . $TANGGAL_PEMBUATAN_SPPB_TAHUN
                        . "; " . $NO_URUT_SPPB
                        . "; " . $JUMLAH_COUNT
                        . "; " . $CREATE_BY_USER
                        . "; " . $PROGRESS_SPPB
                        . "; " . $STATUS_SPPB
                        . "; " . $FILE_NAME_TEMP;
                    $ID_SPPB = 0;
                    $this->user_log_sppb($ID_SPPB, $KETERANGAN);
                    
                    $hasil_2 = $this->SPPB_model->set_md5_id_sppb_pembelian($ID_PROYEK, $NO_URUT_SPPB, $CREATE_BY_USER);

                    $ID_SPPB = 0;
                    $KETERANGAN = "Update MD5 SPPB: " . $ID_PROYEK . "; " . $NO_URUT_SPPB
                        . "; " . $CREATE_BY_USER;
                    $this->user_log_sppb($ID_SPPB, $KETERANGAN);
                } else {
                    echo 'Nomor Urut SPPB sudah terekam sebelumnya';
                }
            }
        } else {
            $this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function simpan_data_pengajuan_bantuan() //BEDA KP DAN SP //102023
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

            $user = $this->ion_auth->user()->row();
            $this->data['user_id'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('ID_JENIS_BENCANA', 'Jenis Bencana', 'trim|required');
            $this->form_validation->set_rules('NAMA_PEMOHON', 'Nama Pemohon', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('NIK', 'NIK', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('NIP', 'NIP', 'trim|max_length[255]');
            $this->form_validation->set_rules('JABATAN', 'Jabatan', 'trim|max_length[255]');
            $this->form_validation->set_rules('INSTANSI', 'Instansi', 'trim|max_length[255]');
            $this->form_validation->set_rules('ID_KABUPATEN_KOTA', 'Kabupaten/Kota', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('ID_KECAMATAN', 'Kecamatan', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('ID_DESA_KELURAHAN', 'Desa/Kelurahan', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('RW', 'RW', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('RT', 'RT', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('KAMPUNG', 'Kampung', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('KODE_POS', 'Kode Pos', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_PENGAJUAN', 'Tanggal Pengajuan', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('TANGGAL_KEJADIAN_BENCANA', 'Tanggal Kejadian Bencana', 'trim|required|max_length[255]');           
            
            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $CODE_MD5 = $this->input->post('CODE_MD5');
                $ID_JENIS_BENCANA = $this->input->post('ID_JENIS_BENCANA');
                $NAMA_PEMOHON = $this->input->post('NAMA_PEMOHON');
                $NIK = $this->input->post('NIK');
                $NIP = $this->input->post('NIP');
                $JABATAN = $this->input->post('JABATAN');
                $INSTANSI = $this->input->post('INSTANSI');
                $ID_KABUPATEN_KOTA = $this->input->post('ID_KABUPATEN_KOTA');
                $ID_KECAMATAN = $this->input->post('ID_KECAMATAN');
                $ID_DESA_KELURAHAN = $this->input->post('ID_DESA_KELURAHAN');
                $RW = $this->input->post('RW');
                $RT = $this->input->post('RT');
                $KAMPUNG = $this->input->post('KAMPUNG');
                $KODE_POS = $this->input->post('KODE_POS');
                $TANGGAL_DOKUMEN_PENGAJUAN = $this->input->post('TANGGAL_DOKUMEN_PENGAJUAN');
                $TANGGAL_KEJADIAN_BENCANA = $this->input->post('TANGGAL_KEJADIAN_BENCANA');

                $TANGGAL_PEMBUATAN_PENGAJUAN_JAM = date("h:i:s.u");
                $TANGGAL_PEMBUATAN_PENGAJUAN_HARI = date('Y-m-d');
                $dt = date('F');
                $TANGGAL_PEMBUATAN_PENGAJUAN_BULAN = $dt;
                $TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN = date("Y");
                $CREATE_BY_USER =  $this->data['user_id'];

                $PROGRESS_PENGAJUAN = "Diproses oleh Staff BPBD";
                $STATUS_PENGAJUAN = "DRAFT";

                
                // if ($this->SPPB_model->cek_no_urut_sppb($NO_URUT_SPPB) == 'Data belum ada') { 

                    $hasil = $this->Pengajuan_model->simpan_data_pengajuan_bantuan(
                        $CODE_MD5,
                        $ID_JENIS_BENCANA,
                        $NAMA_PEMOHON,
                        $NIK,
                        $NIP,
                        $JABATAN,
                        $INSTANSI,
                        $ID_KABUPATEN_KOTA,
                        $ID_KECAMATAN,
                        $ID_DESA_KELURAHAN,
                        $RW,
                        $RT,
                        $KAMPUNG,
                        $KODE_POS,
                        $TANGGAL_DOKUMEN_PENGAJUAN,
                        $TANGGAL_KEJADIAN_BENCANA,
                        $TANGGAL_PEMBUATAN_PENGAJUAN_JAM,
                        $TANGGAL_PEMBUATAN_PENGAJUAN_HARI,
                        $TANGGAL_PEMBUATAN_PENGAJUAN_BULAN,
                        $TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN,
                        $CREATE_BY_USER,
                        $PROGRESS_PENGAJUAN,
                        $STATUS_PENGAJUAN
                    );

                    // $KETERANGAN = "Simpan SPPB: "
                    //     . "; " . $ID_PROYEK
                    //     . "; " . $TANGGAL_DOKUMEN_SPPB
                    //     . "; " . $TANGGAL_PEMBUATAN_SPPB_JAM
                    //     . "; " . $TANGGAL_PEMBUATAN_SPPB_HARI
                    //     . "; " . $TANGGAL_PEMBUATAN_SPPB_BULAN
                    //     . "; " . $TANGGAL_PEMBUATAN_SPPB_TAHUN
                    //     . "; " . $NO_URUT_SPPB
                    //     . "; " . $JUMLAH_COUNT
                    //     . "; " . $CREATE_BY_USER
                    //     . "; " . $PROGRESS_SPPB
                    //     . "; " . $STATUS_SPPB
                    //     . "; " . $FILE_NAME_TEMP;
                    // $ID_SPPB = 0;
                    // $this->user_log_sppb($ID_SPPB, $KETERANGAN);

                    // $hasil_2 = $this->SPPB_model->set_md5_id_sppb_pembelian($ID_PROYEK, $NO_URUT_SPPB, $CREATE_BY_USER);

                    // $ID_SPPB = 0;
                    // $KETERANGAN = "Update MD5 SPPB: " . $ID_PROYEK . "; " . $NO_URUT_SPPB
                    //     . "; " . $CREATE_BY_USER;
                    // $this->user_log_sppb($ID_SPPB, $KETERANGAN);
                // } else {
                //     echo 'Nomor Urut SPPB sudah terekam sebelumnya';
                // }
            }
        } else {
            $this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }
}


