<?php defined('BASEPATH') or exit('No direct script access allowed');

class Penyaluran extends CI_Controller
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
        $this->data['title'] = 'SiKembar | Penyaluran';

        $this->load->model('RASD_model');
        $this->load->model('SPPB_model');
        $this->load->model('Penyaluran_model');
        $this->load->model('SPP_model');
        $this->load->model('PO_model');
        $this->load->model('Foto_model');
        $this->load->model('Proyek_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "penyaluran_aktif";
    }

    /**
     * Log the user out
     */
    public function logout() 
    {


        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log_sppb($ID_SPPB, $KETERANGAN) 
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');

    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index() 
    {

        if (!$this->ion_auth->logged_in()) {

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
        // $this->user_log_sppb($ID_SPPB, $KETERANGAN);

        $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
        $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
        $this->data['ID_JABATAN_PEGAWAI'] = $data_pegawai['ID_JABATAN_PEGAWAI'];

        $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
        //$this->data['INISIAL'] = $data_proyek['INISIAL'];
       // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

        $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
        $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
        $this->session->set_userdata($sess_data);

        //jika mereka sudah login
        if ($this->ion_auth->logged_in()) {
            if ($this->ion_auth->in_group(2)) { //user_pegawai_BPBD

                // tampilkan seluruh proyek
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list();
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list();

                $this->load->view('wasa/user_pegawai_bpbd/head_normal', $this->data);
                $this->load->view('wasa/user_pegawai_bpbd/user_menu');
                $this->load->view('wasa/user_pegawai_bpbd/left_menu');
                $this->load->view('wasa/user_pegawai_bpbd/header_menu');
                $this->load->view('wasa/user_pegawai_bpbd/content_penyaluran_list');
                $this->load->view('wasa/user_pegawai_bpbd/footer');
            }   else if ($this->ion_auth->in_group(3)) { //user_korban

                // tampilkan seluruh proyek
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list();
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list();

                $this->load->view('wasa/user_korban_bencana/head_normal', $this->data);
                $this->load->view('wasa/user_korban_bencana/user_menu');
                $this->load->view('wasa/user_korban_bencana/left_menu');
                $this->load->view('wasa/user_korban_bencana/header_menu');
                $this->load->view('wasa/user_korban_bencana/content_penyaluran_list');
                $this->load->view('wasa/user_korban_bencana/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    function list_penyaluran_by_all_bencana()
    {
        if ($this->ion_auth->logged_in()) {
            $user = $this->ion_auth->user()->row(); // Data user yang login
    
            // Ambil ID user dari pengguna yang login
            $user_id = $user->id;
    
            // Panggil model dengan filter user_id
            $data = $this->Penyaluran_model->list_penyaluran_by_all_bencana($this->input->post('ID_JENIS_BENCANA_LIST'), $user_id);
    
            echo json_encode($data);
        } else {
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silakan hubungi admin');
            redirect('auth/login');
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



    function simpan_data_penyaluran_bantuan() //BEDA KP DAN SP //102023
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(2)) {

            $user = $this->ion_auth->user()->row();
            $this->data['user_id'] = $user->id;

            //set validation rules
            $this->form_validation->set_rules('ID_JENIS_BENCANA', 'Jenis Bencana', 'trim|required');
            $this->form_validation->set_rules('NAMA_PEGAWAI_BPBD', 'Nama Pegawai', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('NIK_PEGAWAI_BPBD', 'NIK Pegawai', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('NIP_PEGAWAI_BPBD', 'NIP Pegawai', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('JABATAN_PEGAWAI_BPBD', 'Jabatan Pegawai', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('NAMA_PENERIMA', 'Nama Penerima', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('NOMOR_KK_PENERIMA', 'Nomor KK Penerima', 'trim|max_length[255]');
            $this->form_validation->set_rules('NIK_PENERIMA', 'NIK Penerima', 'trim|max_length[255]');
            $this->form_validation->set_rules('TANGGAL_LAHIR_PENERIMA', 'Tanggal Lahir Penerima', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('TEMPAT_LAHIR_PENERIMA', 'Tempat Lahir Penerima', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('NIP_PENERIMA', 'NIP Penerima', 'trim|max_length[255]');
            $this->form_validation->set_rules('JABATAN_PENERIMA', 'Jabatan Penerima', 'trim|max_length[255]');
            $this->form_validation->set_rules('INSTANSI_PENERIMA', 'Instansi Penerima', 'trim|max_length[255]');
            $this->form_validation->set_rules('ID_KABUPATEN_KOTA', 'Kabupaten/Kota', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('ID_KECAMATAN', 'Kecamatan', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('ID_DESA_KELURAHAN', 'Desa/Kelurahan', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('RW', 'RW', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('RT', 'RT', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('KAMPUNG', 'Kampung', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('KODE_POS', 'Kode Pos', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_PENYALURAN', 'Tanggal Penyaluran', 'trim|required|max_length[255]');
            $this->form_validation->set_rules('TANGGAL_KEJADIAN_BENCANA', 'Tanggal Kejadian Bencana', 'trim|required|max_length[255]');           
            
            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $CODE_MD5 = $this->input->post('CODE_MD5');
                $ID_JENIS_BENCANA = $this->input->post('ID_JENIS_BENCANA');
                $NAMA_PEGAWAI_BPBD = $this->input->post('NAMA_PEGAWAI_BPBD');
                $NIK_PEGAWAI_BPBD = $this->input->post('NIK_PEGAWAI_BPBD');
                $NIP_PEGAWAI_BPBD = $this->input->post('NIP_PEGAWAI_BPBD');
                $JABATAN_PEGAWAI_BPBD = $this->input->post('JABATAN_PEGAWAI_BPBD');
                $NAMA_PENERIMA = $this->input->post('NAMA_PENERIMA');
                $NOMOR_KK_PENERIMA = $this->input->post('NOMOR_KK_PENERIMA');
                $NIK_PENERIMA = $this->input->post('NIK_PENERIMA');
                $TANGGAL_LAHIR_PENERIMA = $this->input->post('TANGGAL_LAHIR_PENERIMA');
                $TEMPAT_LAHIR_PENERIMA = $this->input->post('TEMPAT_LAHIR_PENERIMA');
                $NIP_PENERIMA = $this->input->post('NIP_PENERIMA');
                $JABATAN_PENERIMA = $this->input->post('JABATAN_PENERIMA');
                $INSTANSI_PENERIMA = $this->input->post('INSTANSI_PENERIMA');
                $ID_KABUPATEN_KOTA = $this->input->post('ID_KABUPATEN_KOTA');
                $ID_KECAMATAN = $this->input->post('ID_KECAMATAN');
                $ID_DESA_KELURAHAN = $this->input->post('ID_DESA_KELURAHAN');
                $RW = $this->input->post('RW');
                $RT = $this->input->post('RT');
                $KAMPUNG = $this->input->post('KAMPUNG');
                $KODE_POS = $this->input->post('KODE_POS');
                $TANGGAL_DOKUMEN_PENYALURAN = $this->input->post('TANGGAL_DOKUMEN_PENYALURAN');
                $TANGGAL_KEJADIAN_BENCANA = $this->input->post('TANGGAL_KEJADIAN_BENCANA');
                $TANGGAL_PEMBUATAN_PENYALURAN_JAM = date("h:i:s.u");
                $TANGGAL_PEMBUATAN_PENYALURAN_HARI = date('Y-m-d');
                $dt = date('F');
                $TANGGAL_PEMBUATAN_PENYALURAN_BULAN = $dt;
                $TANGGAL_PEMBUATAN_PENYALURAN_TAHUN = date("Y");
                $CREATE_BY_USER =  $this->data['user_id'];
                $PROGRESS_PENYALURAN = "Diproses oleh Staff BPBD";
                $STATUS_PENYALURAN = "DRAFT";

                

                    $hasil = $this->Penyaluran_model->simpan_data_penyaluran_bantuan(
                        $CODE_MD5,
                        $ID_JENIS_BENCANA,
                        $NAMA_PEGAWAI_BPBD,
                        $NIK_PEGAWAI_BPBD,
                        $NIP_PEGAWAI_BPBD,
                        $JABATAN_PEGAWAI_BPBD,
                        $NAMA_PENERIMA,
                        $NOMOR_KK_PENERIMA,
                        $NIK_PENERIMA,
                        $TANGGAL_LAHIR_PENERIMA,
                        $TEMPAT_LAHIR_PENERIMA,
                        $NIP_PENERIMA,
                        $JABATAN_PENERIMA,
                        $INSTANSI_PENERIMA,
                        $ID_KABUPATEN_KOTA,
                        $ID_KECAMATAN,
                        $ID_DESA_KELURAHAN,
                        $RW,
                        $RT,
                        $KAMPUNG,
                        $KODE_POS,
                        $TANGGAL_DOKUMEN_PENYALURAN,
                        $TANGGAL_KEJADIAN_BENCANA,
                        $TANGGAL_PEMBUATAN_PENYALURAN_JAM,
                        $TANGGAL_PEMBUATAN_PENYALURAN_HARI,
                        $TANGGAL_PEMBUATAN_PENYALURAN_BULAN,
                        $TANGGAL_PEMBUATAN_PENYALURAN_TAHUN,
                        $CREATE_BY_USER,
                        $PROGRESS_PENYALURAN,
                        $STATUS_PENYALURAN
                    );

            }
        } else {
            $this->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }
}