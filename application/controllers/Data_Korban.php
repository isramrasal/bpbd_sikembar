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
        $this->data['title'] = 'SiKembar | Data Korban';

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
        $this->data['username'] = $user->username;
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        $this->data['user_id'] = $user->id;
        $this->data['NIK'] = $user->NIK;
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
        // $this->data['INISIAL'] = $data_proyek['INISIAL'];
        // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

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

    function list_korban_by_all_bencana() //102023
    {

        if ($this->ion_auth->logged_in()) {

            $data = $this->Data_Korban_model->list_korban_by_all_bencana();
            echo json_encode($data);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function generate_md5() //102023
	{
        if ($this->ion_auth->logged_in())
        {
            $TANGGAL_PEMBUATAN_PENGAJUAN_JAM = date("h:i:s.u");
            $CODE_MD5 = md5($TANGGAL_PEMBUATAN_PENGAJUAN_JAM);
            echo ($CODE_MD5);
        }
		else {
			$this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}


    function get_data_korban_baru() //102023
    {
        if ($this->ion_auth->logged_in()) {
            $CODE_MD5 = $this->input->post('CODE_MD5');

            $data = $this->Data_Korban_model->get_data_korban_baru($CODE_MD5);
            echo json_encode($data);
        } else {
            $this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }


    function simpan_data_korban() 
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(3)) {

            $user = $this->ion_auth->user()->row();
            $this->data['user_id'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('JENIS_BENCANA', 'Jenis Bencana', 'trim|required');
            $this->form_validation->set_rules('NAMA_KORBAN', 'Nama Korban', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('NO_KK', 'NO KK', 'trim|max_length[255]');
            $this->form_validation->set_rules('NIK', 'NIK', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('TEMPAT_LAHIR', 'Tempat Lahir', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('TANGGAL_LAHIR', 'Tanggal Lahir', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('ALAMAT', 'Alamat', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('ID_KABUPATEN_KOTA', 'Kabupaten/Kota', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('ID_KECAMATAN', 'Kecamatan', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('ID_DESA_KELURAHAN', 'Desa/Kelurahan', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('RW', 'RW', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('RT', 'RT', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('KAMPUNG', 'Kampung', 'trim|max_length[255]');
            $this->form_validation->set_rules('KODE_POS', 'Kode Pos', 'trim|max_length[255]');
            $this->form_validation->set_rules('TANGGAL_KEJADIAN_BENCANA', 'Tanggal Kejadian Bencana', 'trim|required|max_length[255]');           
            
            //run validation check
            if ($this->form_validation->run() == FALSE) { 
                echo validation_errors();
            } else {
                //get the form data
                $CODE_MD5 = $this->input->post('CODE_MD5');
                $JENIS_BENCANA = $this->input->post('JENIS_BENCANA');
                $NAMA_KORBAN = $this->input->post('NAMA_KORBAN');
                $NO_KK = $this->input->post('NO_KK');
                $NIK = $this->input->post('NIK');
                $TEMPAT_LAHIR = $this->input->post('TEMPAT_LAHIR');
                $TANGGAL_LAHIR = $this->input->post('TANGGAL_LAHIR');
                $ALAMAT = $this->input->post('ALAMAT');
                $ID_KABUPATEN_KOTA = $this->input->post('ID_KABUPATEN_KOTA');
                $ID_KECAMATAN = $this->input->post('ID_KECAMATAN');
                $ID_DESA_KELURAHAN = $this->input->post('ID_DESA_KELURAHAN');
                $RW = $this->input->post('RW');
                $RT = $this->input->post('RT');
                $KAMPUNG = $this->input->post('KAMPUNG');
                $KODE_POS = $this->input->post('KODE_POS');
                $TANGGAL_KEJADIAN_BENCANA = $this->input->post('TANGGAL_KEJADIAN_BENCANA');

               
                $CREATE_BY_USER =  $this->data['user_id'];

                $PROGRESS_DATA_KORBAN = "Diproses oleh Staff BPBD";
                $STATUS_DATA_KORBAN = "DRAFT";

                

                    $hasil = $this->Data_Korban_model->simpan_data_korban(
                        $CODE_MD5,
                        $JENIS_BENCANA,
                        $NAMA_KORBAN,
                        $NO_KK,
                        $NIK,
                        $TEMPAT_LAHIR,
                        $TANGGAL_LAHIR,
                        $ALAMAT,
                        $ID_KABUPATEN_KOTA,
                        $ID_KECAMATAN,
                        $ID_DESA_KELURAHAN,
                        $RW,
                        $RT,
                        $KAMPUNG,
                        $KODE_POS,
                        $TANGGAL_KEJADIAN_BENCANA,
                        $CREATE_BY_USER,
                        $PROGRESS_DATA_KORBAN,
                        $STATUS_DATA_KORBAN
                    );
            }
        } else {
            $this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }
}