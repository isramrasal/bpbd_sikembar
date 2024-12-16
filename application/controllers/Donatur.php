<?php defined('BASEPATH') or exit('No direct script access allowed');

class Donatur extends CI_Controller
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
        $this->data['title'] = 'SiKembar | Donasi';

        $this->load->model('RASD_model');
        $this->load->model('SPPB_model');
        $this->load->model('Donatur_model');
        $this->load->model('SPP_model');
        $this->load->model('PO_model');
        $this->load->model('Foto_model');
        $this->load->model('Proyek_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "donatur_aktif";
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

        $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
        $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
        $this->session->set_userdata($sess_data);

        //jika mereka sudah login
        if ($this->ion_auth->logged_in()) {
            if ($this->ion_auth->in_group(4)) { //user_donatur

                // tampilkan seluruh proyek
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list();
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list();

                $this->load->view('wasa/user_donatur/head_normal', $this->data);
                $this->load->view('wasa/user_donatur/user_menu');
                $this->load->view('wasa/user_donatur/left_menu');
                $this->load->view('wasa/user_donatur/header_menu');
                $this->load->view('wasa/user_donatur/content_donatur_list');
                $this->load->view('wasa/user_donatur/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    function list_pengajuan_by_user()
    {
        if ($this->ion_auth->logged_in()) {
            $user = $this->ion_auth->user()->row(); // Data user yang login

            // Ambil data berdasarkan user_id dari model
            $data = $this->Donatur_model->list_pengajuan_by_user($user->id);

            // Tampilkan data dalam format JSON
            echo json_encode($data);
        } else {
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silakan hubungi admin');
            redirect('auth/login');
        }
    }

    function list_sppb_by_all_proyek() //102023
    {

        if ($this->ion_auth->logged_in()) {

            $data = $this->SPPB_model->list_sppb_by_all_proyek();
            echo ($data);

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
            echo ($CODE_md5);
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

    function list_donatur_by_nik() //102023
    {
        if ($this->ion_auth->logged_in()) {

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
            $this->data['NIK'] = $user->NIK;


            $data = $this->Donatur_model->list_donatur_by_nik($this->data['NIK']);
            echo json_encode($data);
        
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

    function get_data_donatur_baru() //102023
    {
        if ($this->ion_auth->logged_in()) {
            $CODE_MD5 = $this->input->post('CODE_MD5');

            $data = $this->Donatur_model->get_data_donatur_baru($CODE_MD5);
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

    
    function simpan_data_donatur() //BEDA KP DAN SP //102023
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(4)) {

            $user = $this->ion_auth->user()->row();
            $this->data['user_id'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('NAMA_DONATUR', 'Nama Donatur', 'trim|required|max_length[255]');
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
            $this->form_validation->set_rules('KODE_POS', 'Kode Pos', 'trim|max_length[255]');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_DONASI', 'Tanggal Dokumen Donasi', 'trim|required|max_length[255]');        
            
            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $CODE_MD5 = $this->input->post('CODE_MD5');
                $NAMA_DONATUR = $this->input->post('NAMA_DONATUR');
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
                $TANGGAL_DOKUMEN_DONASI = $this->input->post('TANGGAL_DOKUMEN_DONASI');
            
                $TANGGAL_PEMBUATAN_PENGAJUAN_JAM = date("h:i:s.u");
                $TANGGAL_PEMBUATAN_PENGAJUAN_HARI = date('Y-m-d');
                $TANGGAL_PEMBUATAN = date('Y-m-d');
                $dt = date('F');
                $TANGGAL_PEMBUATAN_PENGAJUAN_BULAN = $dt;
                $TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN = date("Y");
                $CREATE_BY_USER =  $this->data['user_id'];

                $PROGRESS_PENGAJUAN = "Diproses oleh Staff BPBD";
                $STATUS_PENGAJUAN = "DRAFT";

                
                // if ($this->SPPB_model->cek_no_urut_sppb($NO_URUT_SPPB) == 'Data belum ada') { 

                    $hasil = $this->Donatur_model->simpan_data_pengajuan_donasi(
                        $CODE_MD5,
                        $NAMA_DONATUR,
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
                        $TANGGAL_DOKUMEN_DONASI,
                        $TANGGAL_PEMBUATAN,
                        $TANGGAL_PEMBUATAN_PENGAJUAN_JAM,
                        $TANGGAL_PEMBUATAN_PENGAJUAN_HARI,
                        $TANGGAL_PEMBUATAN_PENGAJUAN_BULAN,
                        $TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN,
                        $CREATE_BY_USER,
                        $PROGRESS_PENGAJUAN,
                        $STATUS_PENGAJUAN
                    );

                   
            }
        } else {
            $this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }
}