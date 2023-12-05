<?php defined('BASEPATH') or exit('No direct script access allowed');

class FPB_schduler extends CI_Controller
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
        $this->data['title'] = 'SIPESUT | List Form Permintaan Barang';

        $this->load->model('RASD_model');
        $this->load->model('FPB_model');
        $this->load->model('Foto_model');
        $this->load->model('Jenis_barang_model');
        $this->load->model('Proyek_model');
        $this->load->model('FPB_form_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "FPB_aktif";
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses FPB";
        $WAKTU = date('Y-m-d H:i:s');
        $this->FPB_model->user_log_FPB($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {

        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->FPB_model->user_log_FPB($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
    }

    /**
     * Redirect if needed, otherwise display the user list
     */
    public function index()
    {
        $data = $this->FPB_model->fpb_list_by_DUE_DATE_STAFF_LOGISTIK_less_than_now();
        foreach ($data->result() as $FPB) :
            $this->data['ID_PROYEK'] = $FPB->ID_PROYEK;
            $this->data['ID_FPB'] = $FPB->ID_FPB;
            $this->data['PROGRESS_FPB'] = $FPB->PROGRESS_FPB;
            $this->data['DUE_DATE_CHIEF'] = $FPB->DUE_DATE_CHIEF;
            $this->data['DUE_DATE_SM'] = $FPB->DUE_DATE_SM;
            $this->data['DUE_DATE_STAFF_LOGISTIK'] = $FPB->DUE_DATE_STAFF_LOGISTIK;
            echo $this->data['DUE_DATE_STAFF_LOGISTIK'];

            $ID_FPB =  $this->data['ID_FPB'];
            // $KETERANGAN = "Kirim Form FPB ke Chief/SM untuk approval FPB: " . " ---- " . $ID_FPB;
            // $this->user_log($KETERANGAN);

            $PROGRESS_FPB = "Dalam Proses Approval Chief-SM";
            $STATUS_FPB = "Sedang diproses";

            $DATE_SIGN_STAFF_LOGISTIK = date("Y-m-d H:i:s");
            $SIGN_STAFF_LOGISTIK = "Dicek pada tanggal: " . $DATE_SIGN_STAFF_LOGISTIK;

            //DUE DATE UNTUK STAFF LOGISTIK +1 HARI DARI DATE SIGN PEMINTA
            $date = new DateTime();
            $date->add(new DateInterval('P1D'));
            $DUE_DATE_CHIEF = $date->format('Y-m-d H:i:s');
            $DUE_DATE_SM = $date->format('Y-m-d H:i:s');

            $data = $this->FPB_form_model->update_data_kirim_fpb_STAFF_LOGISTIK($ID_FPB, $PROGRESS_FPB, $STATUS_FPB, $SIGN_STAFF_LOGISTIK, $DUE_DATE_CHIEF, $DUE_DATE_SM);

        endforeach;

        // $hasil = $this->db->query("INSERT INTO FPB (
        // 	ID_PROYEK,
        // 	ID_RASD,
        // 	TANGGAL_PENGAJUAN_FPB,
        // 	NO_URUT_FPB,
        // 	CREATE_BY_USER,
        // 	PROGRESS_FPB,
        // 	STATUS_FPB,
        // 	JUMLAH_COUNT,
        // 	FILE_NAME_TEMP)
        // VALUES(
        // 	'999',
        // 	'999',
        // 	'999',
        // 	'999',
        // 	'999',
        // 	'999',
        // 	'999',
        // 	'999',
        // 	'999'
        // 	)");


    }
}
