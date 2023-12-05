<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori_barang_komponen extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Kategori Barang';
		
		$this->load->model('Kategori_barang_komponen_model');
		$this->load->model('Foto_model');
		//$this->load->model('ws_pegawai_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index()
	{
		//jika mereka belum login
		if (!$this->ion_auth->logged_in())
		{
			// alihkan mereka ke halaman login
			redirect('auth/login', 'refresh');
		}

		//get data tabel users untuk ditampilkan
		$user = $this->ion_auth->user()->row();
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		$this->data['ID_PEGAWAI'] = $user->ID_PEGAWAI;
		$this->data['last_login'] =  date('d-m-Y H:i:s',$user->last_login);
		$this->data['created_on'] = date('d-m-Y H:i:s',$user->created_on);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['left_menu'] = "kategori_barang_komponen_aktif";
		
		$query_foto_user = $this->Foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO")
		{
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		}
		else
		{
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_kategori_barang_komponen');
            $this->load->view('wasa/user_admin/footer');
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$this->load->view('wasa/pegawai/head_normal', $this->data);
		// 	$this->load->view('wasa/pegawai/user_menu');
		// 	$this->load->view('wasa/pegawai/left_menu');
		// 	$this->load->view('wasa/pegawai/content_kategori_barang_komponen');
		// }
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
	
	function data_kategori_barang_komponen()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$data=$this->Kategori_barang_komponen_model->kategori_barang_komponen_list();
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$user = $this->ion_auth->user()->row();
		// 	$data=$this->Kategori_barang_komponen_model->kategori_barang_komponen_list_by_id_pegawai_atau_status($user->ID_PEGAWAI);
		// 	echo json_encode($data);
		// }
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
	
	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$id=$this->input->get('id');
			$data=$this->Kategori_barang_komponen_model->get_data_by_id_kategori_barang_komponen($id);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {	
		// 	$id=$this->input->get('id');
		// 	$data=$this->Kategori_barang_komponen_model->get_data_by_id_kategori_barang_komponen($id);
		// 	echo json_encode($data);
		// }
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
	
	function hapus_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			// $user = $this->ion_auth->user()->row();
			$ID_KATEGORI_BARANG_KOMPONEN=$this->input->post('kode');
			$data=$this->Kategori_barang_komponen_model->get_data_by_id_kategori_barang_komponen($ID_KATEGORI_BARANG_KOMPONEN);
			
			//log
			// $KETERANGAN = "Hapus kategori barang ".$data['NAMA_kategori_barang_komponen']." , KET ".$data['KETERANGAN'];
			// $WAKTU = date('Y-m-d H:i:s');
			// $this->Kategori_barang_komponen_model->log_kategori_barang_komponen($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
			
			$data=$this->Kategori_barang_komponen_model->hapus_data_by_id_kategori_barang_komponen($ID_KATEGORI_BARANG_KOMPONEN);
			echo json_encode($data);
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();
		// 	$id_kategori_barang_komponen=$this->input->post('kode');
		// 	$data=$this->Kategori_barang_komponen_model->get_data_by_id_kategori_barang_komponen($id_kategori_barang_komponen);
			
		// 	//log
		// 	$KETERANGAN = "Hapus kategori_barang_komponen ".$data['NAMA_kategori_barang_komponen'].", ket ".$data['KETERANGAN'];
		// 	$WAKTU = date('Y-m-d H:i:s');
		// 	$this->Kategori_barang_komponen_model->log_kategori_barang_komponen($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
			
		// 	$data=$this->Kategori_barang_komponen_model->hapus_data($id_kategori_barang_komponen);
		// 	echo json_encode($data);
		// }
		else
		{
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
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			// $user = $this->ion_auth->user()->row();
			
			//set validation rules
			$this->form_validation->set_rules('NAMA_KATEGORI_BARANG_KOMPONEN', 'Nama Kategori Barang', 'trim|required|max_length[50]');
			
			//run validation check
			if ($this->form_validation->run() == FALSE)
			{   //validation fails
				echo validation_errors();
			}
			else
			{
				//get the form data
				$NAMA_KATEGORI_BARANG_KOMPONEN = $this->input->post('NAMA_KATEGORI_BARANG_KOMPONEN');
				if($this->Kategori_barang_komponen_model->cek_nama_kategori_barang_komponen_by_admin($NAMA_KATEGORI_BARANG_KOMPONEN) == 'Data belum ada')
				{
					//log
					// $KETERANGAN = "Simpan kategori_barang_komponen ".$nama_kategori_barang_komponen.", ket ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Kategori_barang_komponen_model->log_kategori_barang_komponen($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
					
					$data=$this->Kategori_barang_komponen_model->simpan_data_by_admin($NAMA_KATEGORI_BARANG_KOMPONEN);
				}
				else
				{
					echo 'Nama kategori barang sudah terekam sebelumnya';
				}
				
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();
			
		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_kategori_barang_komponen', 'Nama kategori barang', 'trim|required');
		// 	$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
			
		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo validation_errors();
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$nama_kategori_barang_komponen = $this->input->post('nama_kategori_barang_komponen');
		// 		$keterangan = $this->input->post('keterangan');
		// 		if($this->Kategori_barang_komponen_model->cek_nama_kategori_barang_komponen_by_pegawai($nama_kategori_barang_komponen, $user->ID_PEGAWAI) == 'Data belum ada')
		// 		{
		// 			//log
		// 			$KETERANGAN = "Simpan kategori_barang_komponen ".$nama_kategori_barang_komponen.", ket ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Kategori_barang_komponen_model->log_kategori_barang_komponen($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
					
		// 			$data=$this->Kategori_barang_komponen_model->simpan_data_by_pegawai($nama_kategori_barang_komponen,$keterangan, $user->ID_PEGAWAI);
		// 		}
		// 		else
		// 		{
		// 			echo 'Nama kategori barang sudah terekam sebelumnya';
		// 		}
				
		// 	}
		// }
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
    }
	
	function update_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			// $user = $this->ion_auth->user()->row();
			
			//set validation rules
			$this->form_validation->set_rules('NAMA_KATEGORI_BARANG_KOMPONEN2', 'Nama Kategori Barang', 'trim|required|max_length[50]');
			
			//run validation check
			if ($this->form_validation->run() == FALSE)
			{   //validation fails
				echo json_encode(validation_errors());
			}
			else
			{
				//get the form data
				$ID_KATEGORI_BARANG_KOMPONEN=$this->input->post('ID_KATEGORI_BARANG_KOMPONEN2');
				$NAMA_KATEGORI_BARANG_KOMPONEN=$this->input->post('NAMA_KATEGORI_BARANG_KOMPONEN2');
				// $keterangan=$this->input->post('keterangan2');
				
				//cek apakah input sama dengan eksisting
				$data=$this->Kategori_barang_komponen_model->get_data_by_id_kategori_barang_komponen($ID_KATEGORI_BARANG_KOMPONEN);
				
				if($data['NAMA_KATEGORI_BARANG_KOMPONEN'] == $NAMA_KATEGORI_BARANG_KOMPONEN || ($this->Kategori_barang_komponen_model->cek_nama_kategori_barang_komponen_by_admin($NAMA_KATEGORI_BARANG_KOMPONEN) == 'Data belum ada'))
				{
					$data=$this->Kategori_barang_komponen_model->get_data_by_id_kategori_barang_komponen($ID_KATEGORI_BARANG_KOMPONEN);
					
					//log
					// $KETERANGAN = "Ubah kategori_barang_komponen ".$data['nama_kategori_barang_komponen']." jadi ".$nama_kategori_barang_komponen.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					// $WAKTU = date('Y-m-d H:i:s');
					// $this->Kategori_barang_komponen_model->log_kategori_barang_komponen($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
					
					$data=$this->Kategori_barang_komponen_model->update_data($ID_KATEGORI_BARANG_KOMPONEN, $NAMA_KATEGORI_BARANG_KOMPONEN);
					echo json_encode($data);
				}
				else
				{
					echo json_encode('Nama kategori barang sudah terekam sebelumnya');
				}
			}
		}
		// else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		// {
		// 	$user = $this->ion_auth->user()->row();
			
		// 	//set validation rules
		// 	$this->form_validation->set_rules('nama_kategori_barang_komponen2', 'Nama kategori barang', 'trim|required');
		// 	// $this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');
			
		// 	//run validation check
		// 	if ($this->form_validation->run() == FALSE)
		// 	{   //validation fails
		// 		echo json_encode(validation_errors());
		// 	}
		// 	else
		// 	{
		// 		//get the form data
		// 		$id_kategori_barang_komponen=$this->input->post('id_kategori_barang_komponen2');
		// 		$nama_kategori_barang_komponen=$this->input->post('nama_kategori_barang_komponen2');
		// 		$keterangan=$this->input->post('keterangan2');
				
		// 		//cek apakah input sama dengan eksisting
		// 		$data=$this->Kategori_barang_komponen_model->get_data_by_id_kategori_barang_komponen($id_kategori_barang_komponen);
				
		// 		if($data['nama_kategori_barang_komponen'] == $nama_kategori_barang_komponen || ($this->Kategori_barang_komponen_model->cek_nama_kategori_barang_komponen_by_pegawai($nama_kategori_barang_komponen, $user->ID_PEGAWAI) == 'Data belum ada'))
		// 		{
		// 			$data=$this->Kategori_barang_komponen_model->get_data_by_id_kategori_barang_komponen($id_kategori_barang_komponen);
					
		// 			//log
		// 			$KETERANGAN = "Ubah kategori barang ".$data['nama_kategori_barang_komponen']." jadi ".$nama_kategori_barang_komponen.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
		// 			$WAKTU = date('Y-m-d H:i:s');
		// 			$this->Kategori_barang_komponen_model->log_kategori_barang_komponen($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
					
		// 			$data=$this->Kategori_barang_komponen_model->update_data($id_kategori_barang_komponen, $nama_kategori_barang_komponen,$keterangan);
		// 			echo json_encode($data);
		// 		}
		// 		else
		// 		{
		// 			echo json_encode('Nama kategori barang sudah terekam sebelumnya');
		// 		}
		// 	}
		// }
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
    
    //custom validation function to accept alphabets and space
    function alpha_space_only($str)
    {
        if (!preg_match("/^[a-zA-Z ]+$/",$str))
        {
            $this->form_validation->set_message('alpha_space_only', 'The %s field must contain only alphabets and space');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
}
