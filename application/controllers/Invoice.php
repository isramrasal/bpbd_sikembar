<?php defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
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
        $this->data['title'] = 'SIPESUT | Invoice';

        $this->load->model('PO_model');
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
        $this->load->model('Invoice_model');

        date_default_timezone_set('Asia/Jakarta');
        $this->data['left_menu'] = "Invoice_aktif";
    }

    public function logout()
    {
        $user = $this->ion_auth->user()->row();
        $KETERANGAN = "Paksa Logout Ketika Akses PO";
        $WAKTU = date('Y-m-d H:i:s');
        $this->PO_model->user_log_po($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        $this->ion_auth->logout();

        // set the flash data error message if there is one
        $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
    }

    public function user_log($KETERANGAN)
    {
        $user = $this->ion_auth->user()->row();
        $WAKTU = date('Y-m-d H:i:s');
        $this->PO_model->user_log_po($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
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

        //jika mereka sudah login
        if ($this->ion_auth->logged_in()) {
            //fungsi ini untuk mengirim data ke dropdown
            $this->data['proyek'] = $this->Proyek_model->list_proyek();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['rasd'] = $this->RASD_model->RASD_list();
            //jika mereka sebagai admin
            if ($this->ion_auth->is_admin()) {
                // //fungsi ini untuk mengirim data ke dropdown
                // $this->data['proyek'] = $this->Proyek_model->list_proyek();
                // $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
                // $this->data['rasd'] = $this->RASD_model->RASD_list();

                // $this->load->view('wasa/user_admin/head_normal', $this->data);
                // $this->load->view('wasa/user_admin/user_menu');
                // $this->load->view('wasa/user_admin/left_menu');
                // $this->load->view('wasa/user_admin/header_menu');
                // $this->load->view('wasa/user_admin/content_sppb_list');
                // $this->load->view('wasa/user_admin/footer');
            } else if ($this->ion_auth->in_group(5)) {

                // $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                // $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                // $this->data['ID_JABATAN'] = $data_pegawai['ID_JABATAN'];

                // $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                // $this->data['INISIAL'] = $data_proyek['INISIAL'];
                // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                // $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                // $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                // $sess_data['ID_JABATAN'] = $this->data['ID_JABATAN'];
                // $this->session->set_userdata($sess_data);

                //$this->data['LIST_SPPB_PROC'] = $this->PO_model->sppb_list_po();
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_staff_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_staff_procurement_kp/user_menu');
                $this->load->view('wasa/user_staff_procurement_kp/left_menu');
                $this->load->view('wasa/user_staff_procurement_kp/header_menu');
                $this->load->view('wasa/user_staff_procurement_kp/content_invoice_list');
                $this->load->view('wasa/user_staff_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(6)) {

                // $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                // $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                // $this->data['ID_JABATAN'] = $data_pegawai['ID_JABATAN'];

                // $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                // $this->data['INISIAL'] = $data_proyek['INISIAL'];
                // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                // $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                // $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                // $sess_data['ID_JABATAN'] = $this->data['ID_JABATAN'];
                // $this->session->set_userdata($sess_data);

                //$this->data['LIST_SPPB_PROC'] = $this->PO_model->sppb_list_po();
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_kasie_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_kasie_procurement_kp/user_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/left_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/header_menu');
                $this->load->view('wasa/user_kasie_procurement_kp/content_invoice_list');
                $this->load->view('wasa/user_kasie_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(7)) {

                // $data_pegawai = $this->Organisasi_model->get_data_by_id($this->data['ID_PEGAWAI']);
                // $this->data['ID_PROYEK'] = $data_pegawai['ID_PROYEK_PEGAWAI'];
                // $this->data['ID_JABATAN'] = $data_pegawai['ID_JABATAN'];

                // $data_proyek = $this->Proyek_model->get_data_by_id_proyek($this->data['ID_PROYEK']);
                // $this->data['INISIAL'] = $data_proyek['INISIAL'];
                // $this->data['NAMA_PROYEK'] = $data_proyek['NAMA_PROYEK'];

                // $data_rasd = $this->RASD_model->get_id_rasd_by_id_proyek_FPB($this->data['ID_PROYEK']);
                // $this->data['ID_RASD'] = $data_rasd['ID_RASD'];

                // $sess_data['ID_PROYEK'] = $this->data['ID_PROYEK'];
                // $sess_data['ID_JABATAN'] = $this->data['ID_JABATAN'];
                // $this->session->set_userdata($sess_data);

                //$this->data['LIST_SPPB_PROC'] = $this->PO_model->sppb_list_po();
                //var_dump($this->data['LIST_FPB']);die;

                $this->load->view('wasa/user_manajer_procurement_kp/head_normal', $this->data);
                $this->load->view('wasa/user_manajer_procurement_kp/user_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/left_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/header_menu');
                $this->load->view('wasa/user_manajer_procurement_kp/content_invoice_list');
                $this->load->view('wasa/user_manajer_procurement_kp/footer');
            } else if ($this->ion_auth->in_group(38)) {

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
                $this->load->view('wasa/user_vendor/content_invoice_list');
                $this->load->view('wasa/user_vendor/footer');
            } else {
                $this->logout();
            }
        } else {
            $this->logout();
        }
    }

    function data_Invoice()
    {

        if ($this->ion_auth->logged_in()) {
            if ($this->ion_auth->is_admin()) {
                // $data = $this->SPPB_model->sppb_list();
                // echo json_encode($data);

                // $KETERANGAN = "Melihat Data PO: " . json_encode($data);
                // $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(5)) {

                $data = $this->Invoice_model->po_list_invoice();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data PO bahan Invoice: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(6)) {

                $data = $this->Invoice_model->po_list_invoice();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data PO bahan Invoice: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(7)) {

                $data = $this->Invoice_model->po_list_invoice();
                echo json_encode($data);

                $KETERANGAN = "Melihat Data PO bahan Invoice: " . json_encode($data);
                $this->user_log($KETERANGAN);
            } else if ($this->ion_auth->in_group(38)) {

                $ID_VENDOR = $this->session->userdata('ID_VENDOR');

                $data = $this->Invoice_model->po_list_invoice_by_id_vendor($ID_VENDOR);
                echo json_encode($data);

                $KETERANGAN = "Melihat Data PO bahan Invoice: " . json_encode($data);
                $this->user_log($KETERANGAN);
            }
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function get_list_invoice_by_id_po()
    {
        if ($this->ion_auth->logged_in()) {
            $ID_PO = $this->input->post('ID_PO');
            $data = $this->Invoice_model->get_list_invoice_by_id_po($ID_PO);
            echo json_encode($data);

            $KETERANGAN = "Get Data Proyek: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
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
            $this->form_validation->set_rules('NO_INVOICE', 'Nomor Invoice Vendor', 'trim|required');
            $this->form_validation->set_rules('HARGA_INVOICE', 'Nominal Invoice', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_PENYERAHAN_HARI', 'Tanggal Penyerahan Invoice', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $ID_PO = $this->input->post('ID_PO');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_INVOICE = $this->input->post('NO_INVOICE');
                $HARGA_INVOICE = $this->input->post('HARGA_INVOICE');
                $TANGGAL_PENYERAHAN_HARI = $this->input->post('TANGGAL_PENYERAHAN_HARI');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Invoice_model->cek_no_urut_invoice($NO_INVOICE) == 'DATA BELUM ADA') {

                    $hasil = $this->Invoice_model->simpan_data_invoice(
                        $ID_PO,
                        $ID_VENDOR,
                        $NO_INVOICE,
                        $HARGA_INVOICE,
                        $TANGGAL_PENYERAHAN_HARI
                    );

                    $hasil_2 = $this->Invoice_model->set_md5_id_invoice($ID_VENDOR, $ID_PO, $NO_INVOICE);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Invoice sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_INVOICE', 'Nomor Invoice Vendor', 'trim|required');
            $this->form_validation->set_rules('HARGA_INVOICE', 'Nominal Invoice', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_PENYERAHAN_HARI', 'Tanggal Penyerahan Invoice', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $ID_PO = $this->input->post('ID_PO');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_INVOICE = $this->input->post('NO_INVOICE');
                $HARGA_INVOICE = $this->input->post('HARGA_INVOICE');
                $TANGGAL_PENYERAHAN_HARI = $this->input->post('TANGGAL_PENYERAHAN_HARI');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Invoice_model->cek_no_urut_invoice($NO_INVOICE) == 'DATA BELUM ADA') {

                    $hasil = $this->Invoice_model->simpan_data_invoice(
                        $ID_PO,
                        $ID_VENDOR,
                        $NO_INVOICE,
                        $HARGA_INVOICE,
                        $TANGGAL_PENYERAHAN_HARI
                    );

                    $hasil_2 = $this->Invoice_model->set_md5_id_invoice($ID_VENDOR, $ID_PO, $NO_INVOICE);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Invoice sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_INVOICE', 'Nomor Invoice Vendor', 'trim|required');
            $this->form_validation->set_rules('HARGA_INVOICE', 'Nominal Invoice', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_PENYERAHAN_HARI', 'Tanggal Penyerahan Invoice', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $ID_PO = $this->input->post('ID_PO');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_INVOICE = $this->input->post('NO_INVOICE');
                $HARGA_INVOICE = $this->input->post('HARGA_INVOICE');
                $TANGGAL_PENYERAHAN_HARI = $this->input->post('TANGGAL_PENYERAHAN_HARI');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Invoice_model->cek_no_urut_invoice($NO_INVOICE) == 'DATA BELUM ADA') {

                    $hasil = $this->Invoice_model->simpan_data_invoice(
                        $ID_PO,
                        $ID_VENDOR,
                        $NO_INVOICE,
                        $HARGA_INVOICE,
                        $TANGGAL_PENYERAHAN_HARI
                    );

                    $hasil_2 = $this->Invoice_model->set_md5_id_invoice($ID_VENDOR, $ID_PO, $NO_INVOICE);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Invoice sudah terekam sebelumnya';
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

            $user = $this->ion_auth->user()->row();
            $this->data['USER_ID'] = $user->id;

            //set validation rules
            // $this->form_validation->set_rules('ID_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_URUT_PO', 'Nomor Urut PO', 'trim|required');
            $this->form_validation->set_rules('NO_INVOICE', 'Nomor Invoice Vendor', 'trim|required');
            $this->form_validation->set_rules('HARGA_INVOICE', 'Nominal Invoice', 'trim|required');
            $this->form_validation->set_rules('TANGGAL_PENYERAHAN_HARI', 'Tanggal Penyerahan Invoice', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $ID_PROYEK = $this->input->post('ID_PROYEK');
                $ID_VENDOR = $this->input->post('ID_VENDOR');
                $ID_SPPB = $this->input->post('ID_SPPB');
                $ID_PROYEK_LOKASI_PENYERAHAN = $this->input->post('ID_PROYEK_LOKASI_PENYERAHAN');
                $ID_PO = $this->input->post('ID_PO');
                $NO_URUT_PO = $this->input->post('NO_URUT_PO');
                $NO_INVOICE = $this->input->post('NO_INVOICE');
                $HARGA_INVOICE = $this->input->post('HARGA_INVOICE');
                $TANGGAL_PENYERAHAN_HARI = $this->input->post('TANGGAL_PENYERAHAN_HARI');

                $CREATE_BY_USER =  $this->data['USER_ID'];

                //check apakah nomor Surat Jalan sudah ada. jika belum ada, akan disimpan.
                if ($this->Invoice_model->cek_no_urut_invoice($NO_INVOICE) == 'DATA BELUM ADA') {

                    $hasil = $this->Invoice_model->simpan_data_invoice(
                        $ID_PO,
                        $ID_VENDOR,
                        $NO_INVOICE,
                        $HARGA_INVOICE,
                        $TANGGAL_PENYERAHAN_HARI
                    );

                    $hasil_2 = $this->Invoice_model->set_md5_id_invoice($ID_VENDOR, $ID_PO, $NO_INVOICE);
                    echo $hasil_2;
                } else {
                    echo 'Nomor Urut Invoice sudah terekam sebelumnya';
                }
            }
        } else {
            $this->logout();
        }
    }

    function get_data_invoice_baru()
    {
        $user = $this->ion_auth->user()->row();
        $this->data['USER_ID'] = $user->id;
        $CREATE_BY_USER =  $this->data['USER_ID'];

        if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(38))) {

            $ID_VENDOR = $this->input->post('ID_VENDOR');
            $NO_INVOICE = $this->input->post('NO_INVOICE');

            $data = $this->Invoice_model->get_data_invoice_baru($ID_VENDOR, $NO_INVOICE);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Invoice Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(5))) {

            $ID_VENDOR = $this->input->post('ID_VENDOR');
            $NO_INVOICE = $this->input->post('NO_INVOICE');

            $data = $this->Invoice_model->get_data_invoice_baru($ID_VENDOR, $NO_INVOICE);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Invoice Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(6))) {

            $ID_VENDOR = $this->input->post('ID_VENDOR');
            $NO_INVOICE = $this->input->post('NO_INVOICE');

            $data = $this->Invoice_model->get_data_invoice_baru($ID_VENDOR, $NO_INVOICE);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Invoice Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(7))) {

            $ID_VENDOR = $this->input->post('ID_VENDOR');
            $NO_INVOICE = $this->input->post('NO_INVOICE');

            $data = $this->Invoice_model->get_data_invoice_baru($ID_VENDOR, $NO_INVOICE);
            echo json_encode($data);

            $KETERANGAN = "Get Data MD5 Invoice Baru: " . json_encode($data);
            $this->user_log($KETERANGAN);
        } else {
            $this->logout();
        }
    }
}
