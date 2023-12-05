<?php defined('BASEPATH') or exit('No direct script access allowed');

class SPP extends CI_Controller
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
        $this->data['title'] = 'SIPESUT | SPP';

        $this->load->model('SPP_model');
        $this->load->model('RASD_model');
        $this->load->model('SPPB_model');
        $this->load->model('FPB_model');
        $this->load->model('Foto_model');
        $this->load->model('Jenis_barang_model');
        $this->load->model('Khp_model');
        $this->load->model('Proyek_model');
        $this->load->model('SPPB_form_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');
        $this->load->model('Vendor_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "SPP_aktif";
    }

    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses SPP";
        $WAKTU = date('Y-m-d H:i:s');
        $this->SPP_model->user_log_spp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->SPP_model->user_log_spp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index() //BEDA KP DAN SP
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

        //jika mereka sudah login
        if ($this->ion_auth->logged_in()) {
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
            
            $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
            $sess_data['ID_JABATAN_PEGAWAI'] = $this->data['ID_JABATAN_PEGAWAI'];
            $this->session->set_userdata($sess_data);

            //jika mereka sebagai admin
            if ($this->ion_auth->is_admin()) { //administrator

                // tampilkan seluruh proyek
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list();
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list();

                $this->load->view('wasa/user_admin/head_normal', $this->data);
                $this->load->view('wasa/user_admin/user_menu');
                $this->load->view('wasa/user_admin/left_menu');
                $this->load->view('wasa/user_admin/header_menu');
                $this->load->view('wasa/user_admin/content_spp_list');
                $this->load->view('wasa/user_admin/footer');
                                
            } else if ($this->ion_auth->in_group(5)) { //STAFF PROC KP

                // tampilkan seluruh proyek
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list();
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list();

                $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_kp/user_menu');
                $this->load->view('wasa/user_staff_procurement_kp/left_menu');
                $this->load->view('wasa/user_staff_procurement_kp/header_menu');
                $this->load->view('wasa/user_staff_procurement_kp/content_spp_list');
                $this->load->view('wasa/user_staff_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(8)) { //STAFF PROC SP

                // tampilkan hanya proyek site user
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list_by_id_proyek($this->data['ID_PROYEK']);

                $this->load->view('wasa/user_staff_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_sp/user_menu');
                $this->load->view('wasa/user_staff_procurement_sp/left_menu');
                $this->load->view('wasa/user_staff_procurement_sp/header_menu');
                $this->load->view('wasa/user_staff_procurement_sp/content_spp_list');
                $this->load->view('wasa/user_staff_procurement_sp/footer');
            } else if ($this->ion_auth->in_group(9)) { //SPV PROC SP

                // tampilkan hanya proyek site user
                $this->data['proyek_dropdown'] = $this->SPPB_model->proyek_list_by_id_proyek($this->data['ID_PROYEK']);
                $this->data['proyek_dropdown_list'] = $this->SPPB_model->proyek_list_by_id_proyek($this->data['ID_PROYEK']);

                $this->load->view('wasa/user_supervisi_procurement_sp/head_normal', $this->data);
                $this->load->view('wasa/user_supervisi_procurement_sp/user_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/left_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/header_menu');
                $this->load->view('wasa/user_supervisi_procurement_sp/content_spp_list');
                $this->load->view('wasa/user_supervisi_procurement_sp/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function data_SPP()
    {

        if ($this->ion_auth->logged_in()) {
            
            $data = $this->SPP_model->sppb_list_spp();
            echo json_encode($data);

            $KETERANGAN = "Melihat Data SPPB bahan SPP: " . json_encode($data);
            $this->user_log($KETERANGAN);
           
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function data_spp_by_id_proyek_list()
    {
        if ($this->ion_auth->logged_in()) {
           
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $data = $this->SPP_model->sppb_list_spp_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Melihat Data SPP: " . json_encode($data);
            $this->user_log($KETERANGAN);
           
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function data_qty_spp_form()
	{
		if ($this->ion_auth->logged_in()) {
			$id = $this->input->post('id');
			$data = $this->SPP_model->qty_spp_form_by_id_spp($id);
			echo json_encode($data);

			$KETERANGAN = "Melihat Data SPPB Form: " . json_encode($data);
			$this->user_log($KETERANGAN);
		} else {
			$this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}

    function data_sppb_form()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_SPPB = $this->input->get('ID_SPPB');
            $data = $this->SPPB_form_model->sppb_form_list_by_id_sppb($ID_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Melihat Data SPPB Form Ketika Tampil Modal Create SPP: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    // function data_SPP_vendor()
    // {

    //     if ($this->ion_auth->logged_in()) {
    //         if ($this->ion_auth->in_group(38)) {

    //             $ID_VENDOR = $this->input->post('ID_VENDOR');

    //             date_default_timezone_set('Asia/Jakarta');
    //             $WAKTU = date('Y-m-d H:i:s');

    //             $data = $this->SPP_model->spp_list_by_ID_VENDOR($ID_VENDOR, $WAKTU);
    //             echo json_encode($data);

    //             $KETERANGAN = "Melihat Data SPP: " . json_encode($data);
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
            $data = $this->SPP_model->get_data_proyek_by_hash_md5_sppb($HASH_MD5_SPPB);
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
            $data = $this->SPP_model->get_nomor_urut_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Nomor Urut SPP: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_data_SPP_baru()
    {
        $user = $this->ion_auth->user()->row();
        $this->data['USER_ID'] = $user->id;
        $CREATE_BY_USER =  $this->data['USER_ID'];

        if ($this->ion_auth->logged_in()) {

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $NO_URUT_SPP = $this->input->post('NO_URUT_SPP');

            $data = $this->SPP_model->get_data_spp_baru($ID_PROYEK, $NO_URUT_SPP, $CREATE_BY_USER);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 SPP Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_list_spp_by_id_sppb()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_SPPB = $this->input->post('ID_SPPB');
            $data = $this->SPP_model->get_list_spp_by_id_sppb($ID_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_data_sppb_by_id_proyek()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $data = $this->SPP_model->get_data_sppb_by_id_proyek($ID_PROYEK);
            echo json_encode($data);

            $KETERANGAN = "Get Data SPPB: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_data_sub_pekerjaan_by_id_sppb()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_SPPB = $this->input->post('ID_SPPB');
            $data = $this->SPP_model->get_data_sub_pekerjaan_by_id_sppb($ID_SPPB);
            echo json_encode($data);

            $KETERANGAN = "Get Data Sub Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function simpan_data() //BEDA KP DAN SP
    {
        $user = $this->ion_auth->user()->row();
        $this->data['USER_ID'] = $user->id;
        $CREATE_BY_USER =  $this->data['USER_ID'];

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

            //set validation rules
            $this->form_validation->set_rules('ID_PROYEK', 'Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK_SUB_PEKERJAAN', 'Nomor Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_SPP', 'Nomor Urut SPP', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('JENIS_PERMINTAAN', 'Jenis Permintaan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_SPP', 'Tanggal Dokumen SPP', 'trim|required');

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_SPP = $this->input->post('JUMLAH_COUNT_SPP');
            $SUB_PROYEK = $this->input->post('SUB_PROYEK');
            $NO_URUT_SPP = $this->input->post('NO_URUT_SPP');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
            $JENIS_PERMINTAAN = $this->input->post('JENIS_PERMINTAAN');
            $TANGGAL_DOKUMEN_SPP = $this->input->post('TANGGAL_DOKUMEN_SPP');

            $PROGRESS_SPP = ('Diproses oleh Staff Procurement KP');
            $STATUS_SPP = ('DRAFT');

            $TANGGAL_PEMBUATAN_SPP_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_SPP_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_SPP_BULAN = $dt;
            $TANGGAL_PEMBUATAN_SPP_TAHUN = date("Y");

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo (validation_errors());
            } else {
                //check apakah NOMOR URUT SPP_form sudah ada. jika belum ada, akan disimpan.
                if ($this->SPP_model->cek_nomor_urut_spp($NO_URUT_SPP) == 'DATA BELUM ADA') {


                    $data = $this->SPP_model->simpan_data_spp(
                        $ID_SPPB,
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $JUMLAH_COUNT_SPP,
                        $SUB_PROYEK,
                        $NO_URUT_SPP,
                        $CREATE_BY_USER,
                        $PROGRESS_SPP,
                        $STATUS_SPP,
                        $TANGGAL_DOKUMEN_SPP,
                        $TANGGAL_PEMBUATAN_SPP_JAM,
                        $TANGGAL_PEMBUATAN_SPP_HARI,
                        $TANGGAL_PEMBUATAN_SPP_BULAN,
                        $TANGGAL_PEMBUATAN_SPP_TAHUN,
                        $JENIS_PERMINTAAN,
                        $FILE_NAME_TEMP
                    );

                    // $KETERANGAN = "Simpan SPP: "
                    //     . "; " . $ID_RASD
                    //     . "; " . $ID_PROYEK
                    //     . "; " . $JUMLAH_COUNT_SPP
                    //     . "; " . $NO_URUT_SPP
                    //     . "; " . $CREATE_BY_USER
                    //     . "; " . $PROGRESS_SPP
                    //     . "; " . $STATUS_SPP
                    //     . "; " . $TANGGAL_DOKUMEN_SPP
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_JAM
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_HARI
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_BULAN
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_TAHUN
                    //     . "; " . $JENIS_PERMINTAAN;
                    // $this->user_log($KETERANGAN);

                    $data_2 = $this->SPP_model->set_md5_id_SPP($ID_PROYEK, $ID_SPPB, $NO_URUT_SPP, $CREATE_BY_USER);

                    // $KETERANGAN = "Update MD5 SPP: " . $ID_RASD . "; " . $NO_URUT_SPPB  . "; " . $ID_SPPB . "; " . $NO_URUT_SPP . "; " . $CREATE_BY_USER;
                    // $this->user_log($KETERANGAN);
                    echo $data_2;
                } else {
                    echo 'Nomor urut sudah terekam sebelumnya';
                }
            }
        }
        else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(5)) {

            //set validation rules
            $this->form_validation->set_rules('ID_PROYEK', 'Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK_SUB_PEKERJAAN', 'Nomor Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_SPP', 'Nomor Urut SPP', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('JENIS_PERMINTAAN', 'Jenis Permintaan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_SPP', 'Tanggal Dokumen SPP', 'trim|required');

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_SPP = $this->input->post('JUMLAH_COUNT_SPP');
            $SUB_PROYEK = $this->input->post('SUB_PROYEK');
            $NO_URUT_SPP = $this->input->post('NO_URUT_SPP');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
            $JENIS_PERMINTAAN = $this->input->post('JENIS_PERMINTAAN');
            $TANGGAL_DOKUMEN_SPP = $this->input->post('TANGGAL_DOKUMEN_SPP');

            $PROGRESS_SPP = ('Diproses oleh Staff Procurement KP');
            $STATUS_SPP = ('DRAFT');

            $TANGGAL_PEMBUATAN_SPP_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_SPP_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_SPP_BULAN = $dt;
            $TANGGAL_PEMBUATAN_SPP_TAHUN = date("Y");

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo (validation_errors());
            } else {
                //check apakah NOMOR URUT SPP_form sudah ada. jika belum ada, akan disimpan.
                if ($this->SPP_model->cek_nomor_urut_spp($NO_URUT_SPP) == 'DATA BELUM ADA') {


                    $data = $this->SPP_model->simpan_data_spp(
                        $ID_SPPB,
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $JUMLAH_COUNT_SPP,
                        $SUB_PROYEK,
                        $NO_URUT_SPP,
                        $CREATE_BY_USER,
                        $PROGRESS_SPP,
                        $STATUS_SPP,
                        $TANGGAL_DOKUMEN_SPP,
                        $TANGGAL_PEMBUATAN_SPP_JAM,
                        $TANGGAL_PEMBUATAN_SPP_HARI,
                        $TANGGAL_PEMBUATAN_SPP_BULAN,
                        $TANGGAL_PEMBUATAN_SPP_TAHUN,
                        $JENIS_PERMINTAAN,
                        $FILE_NAME_TEMP
                    );

                    // $KETERANGAN = "Simpan SPP: "
                    //     . "; " . $ID_RASD
                    //     . "; " . $ID_PROYEK
                    //     . "; " . $JUMLAH_COUNT_SPP
                    //     . "; " . $NO_URUT_SPP
                    //     . "; " . $CREATE_BY_USER
                    //     . "; " . $PROGRESS_SPP
                    //     . "; " . $STATUS_SPP
                    //     . "; " . $TANGGAL_DOKUMEN_SPP
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_JAM
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_HARI
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_BULAN
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_TAHUN
                    //     . "; " . $JENIS_PERMINTAAN;
                    // $this->user_log($KETERANGAN);

                    $data_2 = $this->SPP_model->set_md5_id_SPP($ID_PROYEK, $ID_SPPB, $NO_URUT_SPP, $CREATE_BY_USER);

                    // $KETERANGAN = "Update MD5 SPP: " . $ID_RASD . "; " . $NO_URUT_SPPB  . "; " . $ID_SPPB . "; " . $NO_URUT_SPP . "; " . $CREATE_BY_USER;
                    // $this->user_log($KETERANGAN);
                    echo $data_2;
                } else {
                    echo 'Nomor urut sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(8)) {

            //set validation rules
            $this->form_validation->set_rules('ID_PROYEK', 'Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK_SUB_PEKERJAAN', 'Nomor Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_SPP', 'Nomor Urut SPP', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('JENIS_PERMINTAAN', 'Jenis Permintaan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_SPP', 'Tanggal Dokumen SPP', 'trim|required');

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_SPP = $this->input->post('JUMLAH_COUNT_SPP');
            $SUB_PROYEK = $this->input->post('SUB_PROYEK');
            $NO_URUT_SPP = $this->input->post('NO_URUT_SPP');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
            $JENIS_PERMINTAAN = $this->input->post('JENIS_PERMINTAAN');
            $TANGGAL_DOKUMEN_SPP = $this->input->post('TANGGAL_DOKUMEN_SPP');

            $PROGRESS_SPP = ('Diproses oleh Staff Procurement SP');
            $STATUS_SPP = ('DRAFT');

            $TANGGAL_PEMBUATAN_SPP_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_SPP_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_SPP_BULAN = $dt;
            $TANGGAL_PEMBUATAN_SPP_TAHUN = date("Y");

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo (validation_errors());
            } else {
                //check apakah NOMOR URUT SPP_form sudah ada. jika belum ada, akan disimpan.
                if ($this->SPP_model->cek_nomor_urut_spp($NO_URUT_SPP) == 'DATA BELUM ADA') {


                    $data = $this->SPP_model->simpan_data_spp(
                        $ID_SPPB,
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $JUMLAH_COUNT_SPP,
                        $SUB_PROYEK,
                        $NO_URUT_SPP,
                        $CREATE_BY_USER,
                        $PROGRESS_SPP,
                        $STATUS_SPP,
                        $TANGGAL_DOKUMEN_SPP,
                        $TANGGAL_PEMBUATAN_SPP_JAM,
                        $TANGGAL_PEMBUATAN_SPP_HARI,
                        $TANGGAL_PEMBUATAN_SPP_BULAN,
                        $TANGGAL_PEMBUATAN_SPP_TAHUN,
                        $JENIS_PERMINTAAN,
                        $FILE_NAME_TEMP
                    );

                    // $KETERANGAN = "Simpan SPP: "
                    //     . "; " . $ID_RASD
                    //     . "; " . $ID_PROYEK
                    //     . "; " . $JUMLAH_COUNT_SPP
                    //     . "; " . $NO_URUT_SPP
                    //     . "; " . $CREATE_BY_USER
                    //     . "; " . $PROGRESS_SPP
                    //     . "; " . $STATUS_SPP
                    //     . "; " . $TANGGAL_DOKUMEN_SPP
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_JAM
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_HARI
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_BULAN
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_TAHUN
                    //     . "; " . $JENIS_PERMINTAAN;
                    // $this->user_log($KETERANGAN);

                    $data_2 = $this->SPP_model->set_md5_id_SPP($ID_PROYEK, $ID_SPPB, $NO_URUT_SPP, $CREATE_BY_USER);

                    // $KETERANGAN = "Update MD5 SPP: " . $ID_RASD . "; " . $NO_URUT_SPPB  . "; " . $ID_SPPB . "; " . $NO_URUT_SPP . "; " . $CREATE_BY_USER;
                    // $this->user_log($KETERANGAN);
                    echo $data_2;
                } else {
                    echo 'Nomor urut sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && $this->ion_auth->in_group(9)) {

            //set validation rules
            $this->form_validation->set_rules('ID_PROYEK', 'Proyek', 'trim|required');
            $this->form_validation->set_rules('ID_PROYEK_SUB_PEKERJAAN', 'Nomor Urut SPPB', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_SPP', 'Nomor Urut SPP', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('JENIS_PERMINTAAN', 'Jenis Permintaan', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_DOKUMEN_SPP', 'Tanggal Dokumen SPP', 'trim|required');

            $ID_PROYEK = $this->input->post('ID_PROYEK');
            $ID_PROYEK_SUB_PEKERJAAN = $this->input->post('ID_PROYEK_SUB_PEKERJAAN');
            $ID_SPPB = $this->input->post('ID_SPPB');
            $JUMLAH_COUNT_SPP = $this->input->post('JUMLAH_COUNT_SPP');
            $SUB_PROYEK = $this->input->post('SUB_PROYEK');
            $NO_URUT_SPP = $this->input->post('NO_URUT_SPP');
            $FILE_NAME_TEMP = $this->input->post('FILE_NAME_TEMP');
            $JENIS_PERMINTAAN = $this->input->post('JENIS_PERMINTAAN');
            $TANGGAL_DOKUMEN_SPP = $this->input->post('TANGGAL_DOKUMEN_SPP');

            $PROGRESS_SPP = ('Diproses oleh Supervisi Procurement SP');
            $STATUS_SPP = ('DRAFT');
            
            $TANGGAL_PEMBUATAN_SPP_JAM = date("h:i:s.u");
            $TANGGAL_PEMBUATAN_SPP_HARI = date('Y-m-d');
            $dt = date('F');
            $TANGGAL_PEMBUATAN_SPP_BULAN = $dt;
            $TANGGAL_PEMBUATAN_SPP_TAHUN = date("Y");

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo (validation_errors());
            } else {
                //check apakah NOMOR URUT SPP_form sudah ada. jika belum ada, akan disimpan.
                if ($this->SPP_model->cek_nomor_urut_spp($NO_URUT_SPP) == 'DATA BELUM ADA') {


                    $data = $this->SPP_model->simpan_data_spp(
                        $ID_SPPB,
                        $ID_PROYEK,
                        $ID_PROYEK_SUB_PEKERJAAN,
                        $JUMLAH_COUNT_SPP,
                        $SUB_PROYEK,
                        $NO_URUT_SPP,
                        $CREATE_BY_USER,
                        $PROGRESS_SPP,
                        $STATUS_SPP,
                        $TANGGAL_DOKUMEN_SPP,
                        $TANGGAL_PEMBUATAN_SPP_JAM,
                        $TANGGAL_PEMBUATAN_SPP_HARI,
                        $TANGGAL_PEMBUATAN_SPP_BULAN,
                        $TANGGAL_PEMBUATAN_SPP_TAHUN,
                        $JENIS_PERMINTAAN,
                        $FILE_NAME_TEMP
                    );

                    // $KETERANGAN = "Simpan SPP: "
                    //     . "; " . $ID_RASD
                    //     . "; " . $ID_PROYEK
                    //     . "; " . $JUMLAH_COUNT_SPP
                    //     . "; " . $NO_URUT_SPP
                    //     . "; " . $CREATE_BY_USER
                    //     . "; " . $PROGRESS_SPP
                    //     . "; " . $STATUS_SPP
                    //     . "; " . $TANGGAL_DOKUMEN_SPP
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_JAM
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_HARI
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_BULAN
                    //     . "; " . $TANGGAL_PEMBUATAN_SPP_TAHUN
                    //     . "; " . $JENIS_PERMINTAAN;
                    // $this->user_log($KETERANGAN);

                    $data_2 = $this->SPP_model->set_md5_id_SPP($ID_PROYEK, $ID_SPPB, $NO_URUT_SPP, $CREATE_BY_USER);

                    // $KETERANGAN = "Update MD5 SPP: " . $ID_RASD . "; " . $NO_URUT_SPPB  . "; " . $ID_SPPB . "; " . $NO_URUT_SPP . "; " . $CREATE_BY_USER;
                    // $this->user_log($KETERANGAN);
                    echo $data_2;
                } else {
                    echo 'Nomor urut sudah terekam sebelumnya';
                }
            }
        } else {
            $this->logout();
        }
    }



 



    
}
