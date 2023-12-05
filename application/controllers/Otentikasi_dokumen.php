<?php defined('BASEPATH') or exit('No direct script access allowed');

class Otentikasi_dokumen extends CI_Controller
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
        $this->data['title'] = 'SIPESUT | Otentikasi Dokumen';

        $this->load->model('RASD_model');
        $this->load->model('FPB_model');
        $this->load->model('SPPB_model');
        $this->load->model('RFQ_model');
        $this->load->model('SPP_model');
        $this->load->model('PO_model');
        $this->load->model('Foto_model');
        $this->load->model('Jenis_barang_model');
        $this->load->model('Proyek_model');
        $this->load->model('FPB_form_model');
        $this->load->model('Manajemen_user_model');
        $this->load->model('Organisasi_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "FPB_aktif";
    }


    public function index()
    {
        redirect('auth/login', 'refresh');
    }

    function FPB()
    {
        $HASH_MD5_FPB = $this->uri->segment(3);
        if ($this->FPB_model->get_id_fpb_by_HASH_MD5_FPB($HASH_MD5_FPB) == 'TIDAK ADA DATA') {

            $this->load->view('wasa/user_tanpa_login/head_normal', $this->data);
            $this->load->view('wasa/user_tanpa_login/user_menu');
            $this->load->view('wasa/user_tanpa_login/left_menu');
            $this->load->view('wasa/user_tanpa_login/header_menu');
            $this->load->view('wasa/user_tanpa_login/content_fpb_otentikasi_gagal');
            $this->load->view('wasa/user_tanpa_login/footer');
        } else {
            $hasil = $this->FPB_model->get_id_fpb_by_HASH_MD5_FPB($HASH_MD5_FPB);
            $ID_FPB = $hasil['ID_FPB'];
            $this->data['ID_FPB'] = $ID_FPB;
            $this->data['FPB'] = $this->FPB_model->fpb_list_by_id_fpb($ID_FPB);

            foreach ($this->data['FPB']->result() as $FPB) :
                $this->data['FILE_NAME_TEMP'] = $FPB->FILE_NAME_TEMP;
                $this->data['NO_URUT_FPB'] = $FPB->NO_URUT_FPB;
                $this->data['HASH_MD5_FPB'] = $FPB->HASH_MD5_FPB;
                $this->data['STATUS_FPB'] = $FPB->STATUS_FPB;
                $this->data['PROGRESS_FPB'] = $FPB->PROGRESS_FPB;
                $this->data['ID_PROYEK'] = $FPB->ID_PROYEK;
            endforeach;

            $this->load->view('wasa/user_tanpa_login/head_normal', $this->data);
            $this->load->view('wasa/user_tanpa_login/user_menu');
            $this->load->view('wasa/user_tanpa_login/left_menu');
            $this->load->view('wasa/user_tanpa_login/header_menu');
            $this->load->view('wasa/user_tanpa_login/content_fpb_otentikasi');
            $this->load->view('wasa/user_tanpa_login/footer');
        }
    }

    function SPPB()
    {
        $HASH_MD5_SPPB = $this->uri->segment(3);
        if ($this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB) == 'TIDAK ADA DATA') {

            $this->load->view('wasa/user_tanpa_login/head_normal', $this->data);
            $this->load->view('wasa/user_tanpa_login/user_menu');
            $this->load->view('wasa/user_tanpa_login/left_menu');
            $this->load->view('wasa/user_tanpa_login/header_menu');
            $this->load->view('wasa/user_tanpa_login/content_sppb_otentikasi_gagal');
            $this->load->view('wasa/user_tanpa_login/footer');
        } else {
            $hasil = $this->SPPB_model->get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB);
            $ID_SPPB = $hasil['ID_SPPB'];
            $this->data['ID_SPPB'] = $ID_SPPB;
            $this->data['SPPB'] = $this->SPPB_model->sppb_list_by_id_sppb($ID_SPPB);

            foreach ($this->data['SPPB']->result() as $SPPB) :
                $this->data['NO_URUT_SPPB'] = $SPPB->NO_URUT_SPPB;
                $this->data['HASH_MD5_SPPB'] = $SPPB->HASH_MD5_SPPB;
                $this->data['TANGGAL_PEMBUATAN_SPPB_HARI'] = $SPPB->TANGGAL_PEMBUATAN_SPPB_HARI;
                $this->data['PROGRESS_SPPB'] = $SPPB->PROGRESS_SPPB;
            endforeach;

            $this->load->view('wasa/user_tanpa_login/head_normal', $this->data);
            $this->load->view('wasa/user_tanpa_login/user_menu');
            $this->load->view('wasa/user_tanpa_login/left_menu');
            $this->load->view('wasa/user_tanpa_login/header_menu');
            $this->load->view('wasa/user_tanpa_login/content_sppb_otentikasi');
            $this->load->view('wasa/user_tanpa_login/footer');
        }
    }

    function RFQ()
    {
        $HASH_MD5_RFQ = $this->uri->segment(3);
        if ($this->RFQ_model->get_id_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ) == 'TIDAK ADA DATA') {

            $this->load->view('wasa/user_tanpa_login/head_normal', $this->data);
            $this->load->view('wasa/user_tanpa_login/user_menu');
            $this->load->view('wasa/user_tanpa_login/left_menu');
            $this->load->view('wasa/user_tanpa_login/header_menu');
            $this->load->view('wasa/user_tanpa_login/content_RFQ_otentikasi_gagal');
            $this->load->view('wasa/user_tanpa_login/footer');
        } else {
            $hasil = $this->RFQ_model->get_id_RFQ_by_HASH_MD5_RFQ($HASH_MD5_RFQ);
            $ID_RFQ = $hasil['ID_RFQ'];
            $this->data['ID_RFQ'] = $ID_RFQ;
            $this->data['RFQ'] = $this->RFQ_model->RFQ_list_by_id_RFQ($ID_RFQ);

            foreach ($this->data['RFQ']->result() as $RFQ) :
                $this->data['NO_URUT_RFQ'] = $RFQ->NO_URUT_RFQ;
                $this->data['HASH_MD5_RFQ'] = $RFQ->HASH_MD5_RFQ;
                $this->data['TANGGAL_PEMBUATAN_RFQ_HARI'] = $RFQ->TANGGAL_PEMBUATAN_RFQ_HARI;
                $this->data['PROGRESS_RFQ'] = $RFQ->PROGRESS_RFQ;
            endforeach;

            $this->load->view('wasa/user_tanpa_login/head_normal', $this->data);
            $this->load->view('wasa/user_tanpa_login/user_menu');
            $this->load->view('wasa/user_tanpa_login/left_menu');
            $this->load->view('wasa/user_tanpa_login/header_menu');
            $this->load->view('wasa/user_tanpa_login/content_RFQ_otentikasi');
            $this->load->view('wasa/user_tanpa_login/footer');
        }
    }

    function SPP()
    {
        $HASH_MD5_SPP = $this->uri->segment(3);
        if ($this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP) == 'TIDAK ADA DATA') {

            $this->load->view('wasa/user_tanpa_login/head_normal', $this->data);
            $this->load->view('wasa/user_tanpa_login/user_menu');
            $this->load->view('wasa/user_tanpa_login/left_menu');
            $this->load->view('wasa/user_tanpa_login/header_menu');
            $this->load->view('wasa/user_tanpa_login/content_spp_otentikasi_gagal');
            $this->load->view('wasa/user_tanpa_login/footer');
        } else {
            $hasil = $this->SPP_model->get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP);
            $ID_SPP = $hasil['ID_SPP'];
            $this->data['ID_SPP'] = $ID_SPP;
            $this->data['SPP'] = $this->SPP_model->spp_list_by_id_spp($ID_SPP);

            foreach ($this->data['SPP']->result() as $SPP) :
                $this->data['NO_URUT_SPP'] = $SPP->NO_URUT_SPP;
                $this->data['HASH_MD5_SPP'] = $SPP->HASH_MD5_SPP;
                $this->data['TANGGAL_PEMBUATAN_SPP_HARI'] = $SPP->TANGGAL_PEMBUATAN_SPP_HARI;
                $this->data['PROGRESS_SPP'] = $SPP->PROGRESS_SPP;
            endforeach;

            $this->load->view('wasa/user_tanpa_login/head_normal', $this->data);
            $this->load->view('wasa/user_tanpa_login/user_menu');
            $this->load->view('wasa/user_tanpa_login/left_menu');
            $this->load->view('wasa/user_tanpa_login/header_menu');
            $this->load->view('wasa/user_tanpa_login/content_spp_otentikasi');
            $this->load->view('wasa/user_tanpa_login/footer');
        }
    }

    function PO()
    {
        $HASH_MD5_PO = $this->uri->segment(3);
        if ($this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO) == 'TIDAK ADA DATA') {

            $this->load->view('wasa/user_tanpa_login/head_normal', $this->data);
            $this->load->view('wasa/user_tanpa_login/user_menu');
            $this->load->view('wasa/user_tanpa_login/left_menu');
            $this->load->view('wasa/user_tanpa_login/header_menu');
            $this->load->view('wasa/user_tanpa_login/content_PO_otentikasi_gagal');
            $this->load->view('wasa/user_tanpa_login/footer');
        } else {
            $hasil = $this->PO_model->get_data_po_by_HASH_MD5_PO($HASH_MD5_PO);
            $ID_PO = $hasil['ID_PO'];
            $this->data['ID_PO'] = $ID_PO;
            $this->data['PO'] = $this->PO_model->po_list_by_id_po($ID_PO);

            foreach ($this->data['PO']->result() as $PO) :
                $this->data['NO_URUT_PO'] = $PO->NO_URUT_PO;
                $this->data['HASH_MD5_PO'] = $PO->HASH_MD5_PO;
                $this->data['TANGGAL_PEMBUATAN_PO_HARI'] = $PO->TANGGAL_PEMBUATAN_PO_HARI;
                $this->data['PROGRESS_PO'] = $PO->PROGRESS_PO;
            endforeach;

            $this->load->view('wasa/user_tanpa_login/head_normal', $this->data);
            $this->load->view('wasa/user_tanpa_login/user_menu');
            $this->load->view('wasa/user_tanpa_login/left_menu');
            $this->load->view('wasa/user_tanpa_login/header_menu');
            $this->load->view('wasa/user_tanpa_login/content_PO_otentikasi');
            $this->load->view('wasa/user_tanpa_login/footer');
        }
    }
}

