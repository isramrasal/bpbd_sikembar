<?php defined('BASEPATH') or exit('No direct script access allowed');

class Spp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('ion_auth', 'form_validation'));
        $this->load->helper(array('url', 'language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->data['title'] = 'SIPESUT | SPP';

        $this->load->model('Spp_model');
        $this->load->model('Foto_model');
        $this->load->model('Jenis_barang_model');
        $this->load->model('Proyek_model');

        date_default_timezone_set('Asia/Jakarta');
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
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        $this->data['user_id'] = $user->id;
        $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['left_menu'] = "spp_aktif";

        $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            // $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $id_khp = $this->uri->segment(3);
            $this->data['id_khp'] = $id_khp;
            $this->load->view('wasa/user_admin/head_normal', $this->data);
            $this->load->view('wasa/user_admin/user_menu');
            $this->load->view('wasa/user_admin/left_menu');
            $this->load->view('wasa/user_admin/header_menu');
            $this->load->view('wasa/user_admin/content_spp_list');
            $this->load->view('wasa/user_admin/footer');
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
        // {	
        // 	$this->load->view('wasa/pegawai/head_normal', $this->data);
        // 	$this->load->view('wasa/pegawai/user_menu');
        // 	$this->load->view('wasa/pegawai/left_menu');
        // 	$this->load->view('wasa/pegawai/content_Spp');
        // }
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }


    function data_spp()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $id = $this->input->get('id');
            $data = $this->Spp_model->spp_list_by_id_khp($id);
            echo json_encode($data);
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
        // {	
        // 	$user = $this->ion_auth->user()->row();
        // 	$data=$this->Spp_model->Spp_list_by_id_pegawai_atau_status($user->ID_PEGAWAI);
        // 	echo json_encode($data);
        // }
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }


    function get_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $id = $this->input->get('id');
            $data = $this->Spp_model->get_data_by_id_spp($id);
            echo json_encode($data);
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
        // {	
        // 	$id=$this->input->get('id');
        // 	$data=$this->Jenis_barang_model->get_data_by_id_jenis_barang($id);
        // 	echo json_encode($data);
        // }
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function hapus_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();
            $ID_BARANG_MASTER = $this->input->post('kode');
            $data = $this->Spp_model->get_data_by_id_spp($ID_BARANG_MASTER);

            // //log
            // $KETERANGAN = "Hapus Barang Master".$data['NAMA_Spp']." , KET ".$data['KETERANGAN'];
            // $WAKTU = date('Y-m-d H:i:s');
            // $this->Spp_model->log_Spp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

            $data = $this->Spp_model->hapus_data_by_id_spp($ID_BARANG_MASTER);
            echo json_encode($data);
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
        // {
        // 	$user = $this->ion_auth->user()->row();
        // 	$id_Spp=$this->input->post('kode');
        // 	$data=$this->Spp_model->get_data_by_id_Spp($id_Spp);

        // 	//log
        // 	$KETERANGAN = "Hapus Spp".$data['NAMA_Spp'].", ket ".$data['KETERANGAN'];
        // 	$WAKTU = date('Y-m-d H:i:s');
        // 	$this->Spp_model->log_Spp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        // 	$data=$this->Spp_model->hapus_data($id_Spp);
        // 	echo json_encode($data);
        // }
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    /**
     * Log the user out
     */
    public function logout()
    {

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('auth/login', 'refresh');
    }

    function simpan_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim|required');
            $this->form_validation->set_rules('MEREK', 'Merek', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim|required');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim|required');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('GAMBAR_1', 'Gambar 1', 'trim');
            $this->form_validation->set_rules('GAMBAR_2', 'Gambar 2', 'trim');
            $this->form_validation->set_rules('GAMBAR_3', 'Gambar 3', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('DOK_BUKU_PANDUAN', 'Dokumen Buku Panduan', 'trim');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|required|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo validation_errors();
            } else {
                //get the form data
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $GAMBAR_1 = $this->input->post('GAMBAR_1');
                $GAMBAR_2 = $this->input->post('GAMBAR_2');
                $GAMBAR_3 = $this->input->post('GAMBAR_3');
                $DOK_BUKU_PANDUAN = $this->input->post('DOK_BUKU_PANDUAN');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //check apakah nama Sppsudah ada. jika belum ada, akan disimpan.
                if ($this->Spp_model->cek_nama_spp_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada') {
                    //log
                    // $KETERANGAN = "Simpan Spp".$NAMA_Spp.", ket ".$keterangan;
                    // $WAKTU = date('Y-m-d H:i:s');
                    // $this->Spp_model->log_Spp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Spp_model->simpan_data_by_admin(
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $NAMA_SATUAN_BARANG,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $GAMBAR_1,
                        $GAMBAR_2,
                        $GAMBAR_3,
                        $DOK_BUKU_PANDUAN,
                        $MASA_PAKAI
                    );
                    redirect('spp', 'refresh');
                } else {
                    echo 'Nama Sppsudah terekam sebelumnya';
                }
            }
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
        // {
        // 	$user = $this->ion_auth->user()->row();

        // 	//set validation rules
        // 	$this->form_validation->set_rules('nama_Spp', 'Nama Spp', 'trim|required');
        // 	$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');

        // 	//run validation check
        // 	if ($this->form_validation->run() == FALSE)
        // 	{   //validation fails
        // 		echo validation_errors();
        // 	}
        // 	else
        // 	{
        // 		//get the form data
        // 		$nama_Spp= $this->input->post('nama_Spp');
        // 		$keterangan = $this->input->post('keterangan');
        // 		if($this->Spp_model->cek_nama_Spp_by_pegawai($nama_Spp, $user->ID_PEGAWAI) == 'Data belum ada')
        // 		{
        // 			//log
        // 			$KETERANGAN = "Simpan Spp".$nama_Spp.", ket ".$keterangan;
        // 			$WAKTU = date('Y-m-d H:i:s');
        // 			$this->Spp_model->log_Spp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

        // 			$data=$this->Spp_model->simpan_data_by_pegawai($nama_Spp,$keterangan, $user->ID_PEGAWAI);
        // 		}
        // 		else
        // 		{
        // 			echo 'Nama Sppsudah terekam sebelumnya';
        // 		}

        // 	}
        // }
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    function update_data()
    {
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('NAMA', 'Nama Barang Master', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('ALIAS', 'Alias', 'trim|required');
            $this->form_validation->set_rules('MEREK', 'Merek', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('JENIS_BARANG', 'Nama Jenis Barang', 'trim|required|max_length[11]');
            $this->form_validation->set_rules('NAMA_SATUAN_BARANG', 'Satuan Barang', 'trim|required|max_length[12]');
            $this->form_validation->set_rules('GROSS_WEIGHT', 'Gross Weight', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('NETT_WEIGHT', 'Nett Weight', 'trim|required|max_length[30]');
            $this->form_validation->set_rules('PERALATAN_PERLENGKAPAN', 'Peralatan/Perlengkapan', 'trim|required');
            $this->form_validation->set_rules('DIMENSI_PANJANG', 'Dimensi Panjang', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_LEBAR', 'Dimensi Lebar', 'trim|max_length[12]');
            $this->form_validation->set_rules('DIMENSI_TINGGI', 'Dimensi Tinggi', 'trim|max_length[12]');
            $this->form_validation->set_rules('SPESIFIKASI_LENGKAP', 'Spesifikasi Lengkap', 'trim|required');
            $this->form_validation->set_rules('SPESIFIKASI_SINGKAT', 'Spesifikasi Singkat', 'trim|required|max_length[100]');
            $this->form_validation->set_rules('CARA_SINGKAT_PENGGUNAAN', 'Cara Singkat Penggunaan', 'trim|required');
            $this->form_validation->set_rules('CARA_PENYIMPANAN_BARANG', 'Cara Penyimpanan Barang', 'trim');
            $this->form_validation->set_rules('GAMBAR_1', 'Gambar 1', 'trim');
            $this->form_validation->set_rules('GAMBAR_2', 'Gambar 2', 'trim');
            $this->form_validation->set_rules('GAMBAR_3', 'Gambar 3', 'trim');
            $this->form_validation->set_rules('KODE_BARANG', 'Kode Barang Master', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('DOK_BUKU_PANDUAN', 'Dokumen Buku Panduan', 'trim');
            $this->form_validation->set_rules('MASA_PAKAI', 'Masa Pakai Barang', 'trim|required|max_length[12]');


            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $ID_BARANG_MASTER = $this->input->post('ID_BARANG_MASTER');
                $NAMA = $this->input->post('NAMA');
                $ALIAS = $this->input->post('ALIAS');
                $MEREK = $this->input->post('MEREK');
                $JENIS_BARANG = $this->input->post('JENIS_BARANG');
                $NAMA_SATUAN_BARANG = $this->input->post('NAMA_SATUAN_BARANG');
                $GROSS_WEIGHT = $this->input->post('GROSS_WEIGHT');
                $NETT_WEIGHT = $this->input->post('NETT_WEIGHT');
                $KODE_BARANG = $this->input->post('KODE_BARANG');
                $PERALATAN_PERLENGKAPAN = $this->input->post('PERALATAN_PERLENGKAPAN');
                $DIMENSI_PANJANG = $this->input->post('DIMENSI_PANJANG');
                $DIMENSI_LEBAR = $this->input->post('DIMENSI_LEBAR');
                $DIMENSI_TINGGI = $this->input->post('DIMENSI_TINGGI');
                $SPESIFIKASI_LENGKAP = $this->input->post('SPESIFIKASI_LENGKAP');
                $SPESIFIKASI_SINGKAT = $this->input->post('SPESIFIKASI_SINGKAT');
                $CARA_SINGKAT_PENGGUNAAN = $this->input->post('CARA_SINGKAT_PENGGUNAAN');
                $CARA_PENYIMPANAN_BARANG = $this->input->post('CARA_PENYIMPANAN_BARANG');
                $GAMBAR_1 = $this->input->post('GAMBAR_1');
                $GAMBAR_2 = $this->input->post('GAMBAR_2');
                $GAMBAR_3 = $this->input->post('GAMBAR_3');
                $DOK_BUKU_PANDUAN = $this->input->post('DOK_BUKU_PANDUAN');
                $MASA_PAKAI = $this->input->post('MASA_PAKAI');

                //cek apakah input sama dengan eksisting
                $data = $this->Spp_model->get_data_by_id_spp($ID_BARANG_MASTER);

                if ($data['NAMA'] == $NAMA || $data['KODE_BARANG'] == $KODE_BARANG || ($this->Spp_model->cek_nama_spp_by_admin($NAMA, $KODE_BARANG) == 'Data belum ada')) {
                    $data = $this->Spp_model->get_data_by_id_spp($ID_BARANG_MASTER);
                    //log
                    // $KETERANGAN = "Ubah Spp".$data['NAMA_Spp']." jadi ".$nama_Spp.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
                    // $WAKTU = date('Y-m-d H:i:s');
                    // $this->Spp_model->log_Spp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Spp_model->update_data(
                        $ID_BARANG_MASTER,
                        $NAMA,
                        $ALIAS,
                        $MEREK,
                        $NAMA_SATUAN_BARANG,
                        $JENIS_BARANG,
                        $PERALATAN_PERLENGKAPAN,
                        $GROSS_WEIGHT,
                        $NETT_WEIGHT,
                        $DIMENSI_PANJANG,
                        $DIMENSI_LEBAR,
                        $DIMENSI_TINGGI,
                        $SPESIFIKASI_LENGKAP,
                        $SPESIFIKASI_SINGKAT,
                        $CARA_SINGKAT_PENGGUNAAN,
                        $CARA_PENYIMPANAN_BARANG,
                        $KODE_BARANG,
                        $GAMBAR_1,
                        $GAMBAR_2,
                        $GAMBAR_3,
                        $DOK_BUKU_PANDUAN,
                        $MASA_PAKAI
                    );
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppsudah terekam sebelumnya');
                }
            }
        } else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4))) {
            $user = $this->ion_auth->user()->row();

            //set validation rules
            $this->form_validation->set_rules('nama_spp2', 'Nama Spp', 'trim|required');
            $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');

            //run validation check
            if ($this->form_validation->run() == FALSE) {   //validation fails
                echo json_encode(validation_errors());
            } else {
                //get the form data
                $id_spp = $this->input->post('id_spp2');
                $nama_spp = $this->input->post('nama_spp2');
                $keterangan = $this->input->post('keterangan2');

                //cek apakah input sama dengan eksisting
                $data = $this->Spp_model->get_data_by_id_spp($id_spp);

                if ($data['NAMA_BARANG_MASTER'] == $nama_spp || ($this->Spp_model->cek_nama_spp_by_pegawai($nama_spp, $user->ID_PEGAWAI) == 'Data belum ada')) {
                    $data = $this->Spp_model->get_data_by_id_spp($id_spp);

                    //log
                    $KETERANGAN = "Ubah Spp" . $data['NAMA_BARANG_MASTER'] . " jadi " . $nama_spp . ", ket " . $data['KETERANGAN'] . " jadi " . $keterangan;
                    $WAKTU = date('Y-m-d H:i:s');
                    $this->Spp_model->log_Spp($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);

                    $data = $this->Spp_model->update_data($id_spp, $nama_spp, $keterangan);
                    echo json_encode($data);
                } else {
                    echo json_encode('Nama Sppsudah terekam sebelumnya');
                }
            }
        } else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    //custom validation function to accept alphabets and space
    function alpha_space_only($str)
    {
        if (!preg_match("/^[a-zA-Z ]+$/", $str)) {
            $this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    //TAMPILAN TAMBAH
    function view_tambah()
    {
        //jika mereka belum login
        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        //get data tabel users untuk ditampilkan
        $user = $this->ion_auth->user()->row();
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        $this->data['user_id'] = $user->id;
        $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['left_menu'] = "spp_aktif";

        $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();
            $this->data['proyek'] = $this->Proyek_model->proyek_list();
            $this->load->view('wasa/user_admin/head_normal', $this->data);
            $this->load->view('wasa/user_admin/user_menu');
            $this->load->view('wasa/user_admin/left_menu');
            $this->load->view('wasa/user_admin/header_menu');
            $this->load->view('wasa/user_admin/content_spp_tambah');
            $this->load->view('wasa/user_admin/footer');
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
        // {	
        // 	$this->load->view('wasa/pegawai/head_normal', $this->data);
        // 	$this->load->view('wasa/pegawai/user_menu');
        // 	$this->load->view('wasa/pegawai/left_menu');
        // 	$this->load->view('wasa/pegawai/content_Spp');
        // }
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }

    //TAMPILAN UBAH
    function view_ubah()
    {
        //jika mereka belum login
        if (!$this->ion_auth->logged_in()) {
            // alihkan mereka ke halaman login
            redirect('auth/login', 'refresh');
        }

        //get data tabel users untuk ditampilkan
        $user = $this->ion_auth->user()->row();
        $this->data['ip_address'] = $user->ip_address;
        $this->data['email'] = $user->email;
        $this->data['user_id'] = $user->id;
        $this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
        $this->data['last_login'] =  date('d-m-Y H:i:s', $user->last_login);
        $this->data['created_on'] = date('d-m-Y H:i:s', $user->created_on);
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->data['left_menu'] = "spp_aktif";

        $id_spp = $this->uri->segment(3);
        $this->data['id_spp'] = $id_spp;
        $this->data['data_spp'] = $this->Spp_model->get_data_by_id_spp($id_spp);
        // $dataspp = $this->Spp_model->get_data_by_id_spp($id_spp);

        $query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
        if ($query_foto_user == "BELUM ADA FOTO") {
            $this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
        } else {
            $this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
        }

        //jika mereka sudah login dan sebagai admin
        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
            //fungsi ini untuk mengirim data ke dropdown
            // $this->data['proyek'] = $this->Proyek_model->proyek_list();
            // $this->data['jenis_barang'] = $this->Jenis_barang_model->jenis_barang_list();

            $this->load->view('wasa/user_admin/head_normal', $this->data);
            $this->load->view('wasa/user_admin/user_menu');
            $this->load->view('wasa/user_admin/left_menu');
            $this->load->view('wasa/user_admin/header_menu');
            $this->load->view('wasa/user_admin/content_spp_ubah');
            $this->load->view('wasa/user_admin/footer');
        }
        // else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
        // {	
        // 	$this->load->view('wasa/pegawai/head_normal', $this->data);
        // 	$this->load->view('wasa/pegawai/user_menu');
        // 	$this->load->view('wasa/pegawai/left_menu');
        // 	$this->load->view('wasa/pegawai/content_Spp');
        // }
        else {
            // set the flash data error message if there is one
            $this->ion_auth->logout();
            $this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
        }
    }
}
