<?php defined('BASEPATH') OR exit('No direct script access allowed');

class nip extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Buat Nomor Induk Pegawai';
		
		$this->load->model(array('ws_pegawai_model'));
		$this->load->model('ws_foto_model');
		$this->load->model('ws_status_pegawai_model');
		$this->load->model('ws_jabatan_model');
		$this->load->model('ws_departemen_model');
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

		$user = $this->ion_auth->user()->row();
		$this->data['ip_address'] = $user->ip_address;
		$this->data['email'] = $user->email;
		$this->data['user_id'] = $user->id;
		$this->data['last_login'] =  date('d-m-Y H:i:s',$user->last_login);
		$this->data['created_on'] = date('d-m-Y H:i:s',$user->created_on);
		$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
		$this->data['message_deaktivasi'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message_deaktivasi');
		$this->data['left_menu'] = "pegawai_aktif";
		
		$query_foto_user = $this->ws_foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
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
			$this->data['status_pegawai']=$this->ws_status_pegawai_model->status_pegawai_list();
			$this->data['jabatan']=$this->ws_jabatan_model->jabatan_list_by_status();
			$this->data['departemen']=$this->ws_departemen_model->departemen_list();
			
			$this->load->view('wasa/head_normal', $this->data);
			$this->load->view('wasa/user_menu');
			$this->load->view('wasa/left_menu');
			$this->load->view('wasa/content_nip');
			
		}
		else
		{
			// log the user out
			$this->logout();
		}
	}
	
	function data_pegawai()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$data=$this->ws_pegawai_model->pegawai_list();
			echo json_encode($data);
		}
		else
		{
			// log the user out
			$this->logout();
		}
	}
	
	function get_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$id=$this->input->get('id');
			$data=$this->ws_pegawai_model->get_data_by_id_cont_nip($id);
			echo json_encode($data);
		}
		else
		{
			/// log the user out
			$this->logout();
		}
	}
	
	function simpan_data()
    {	
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$user = $this->ion_auth->user()->row();
			
			//set validation rules
			$this->form_validation->set_rules('nip', 'NIP', 'trim|required');
			$this->form_validation->set_rules('nik', 'NIK', 'trim|required');
			$this->form_validation->set_rules('nama', 'Nama', 'trim|required');
			$this->form_validation->set_rules('ID_STATUS_PEGAWAI', 'Status Pegawai', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN', 'Jabatan', 'trim|required');
			$this->form_validation->set_rules('ID_DEPARTEMEN', 'Departemen', 'trim|required');
			
			//run validation check
			if ($this->form_validation->run() == FALSE)
			{   //validation fails
				echo validation_errors();
			}
			else
			{
				//get the form data
				$nip = $this->input->post('nip');
				$nik = $this->input->post('nik');
				$nama = $this->input->post('nama');
				$ID_STATUS_PEGAWAI = $this->input->post('ID_STATUS_PEGAWAI');
				$ID_JABATAN = $this->input->post('ID_JABATAN');
				$ID_DEPARTEMEN = $this->input->post('ID_DEPARTEMEN');
				$tanggal_status_kontrak = $this->input->post('tanggal_status_kontrak');
				$tanggal_status_tetap = $this->input->post('tanggal_status_tetap');
				
				if(($this->ws_pegawai_model->cek_nip($nip) == 'Data belum ada') && ($this->ws_pegawai_model->cek_nik($nik) == 'Data belum ada'))
				{
					
					//log
					$KETERANGAN = "Simpan data pegawai: NIP ".$nip. " NIK ".$nik." NAMA ".$nama." ID_STATUS_PEGAWAI ".$ID_STATUS_PEGAWAI." ID_JABATAN ".$ID_JABATAN." ID_DEPARTEMEN ".$ID_DEPARTEMEN." tanggal_status_kontrak ".$tanggal_status_kontrak." tanggal_status_tetap ".$tanggal_status_tetap;
					$WAKTU = date('Y-m-d H:i:s');
					$this->ws_pegawai_model->log_pegawai($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
					
					$data=$this->ws_pegawai_model->simpan_data_buat_nip($nip, $nik, $nama, $ID_STATUS_PEGAWAI, $ID_JABATAN, $ID_DEPARTEMEN, $tanggal_status_kontrak, $tanggal_status_tetap);
				}
				else
				{
					echo 'NIP atau NIK sudah terekam';
				}
				
			}
		}
		else
		{
			// log the user out
			$this->logout();
		}
    }
	
	function update_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$user = $this->ion_auth->user()->row();
			
			//set validation rules
			$this->form_validation->set_rules('nip2', 'NIP', 'trim|required');
			$this->form_validation->set_rules('nama2', 'Nama', 'trim|required');
			$this->form_validation->set_rules('ID_STATUS_PEGAWAI2', 'Status Pegawai', 'trim|required');
			$this->form_validation->set_rules('ID_JABATAN2', 'Jabatan', 'trim|required');
			$this->form_validation->set_rules('ID_DEPARTEMEN2', 'Departemen', 'trim|required');
			
			//run validation check
			if ($this->form_validation->run() == FALSE)
			{   //validation fails
				echo json_encode(validation_errors());
			}
			else
			{
				//get the form data
				$id_pegawai=$this->input->post('id_pegawai2');
				$nip = $this->input->post('nip2');
				$nama = $this->input->post('nama2');
				$ID_STATUS_PEGAWAI2 = $this->input->post('ID_STATUS_PEGAWAI2');
				$ID_JABATAN2 = $this->input->post('ID_JABATAN2');
				$ID_DEPARTEMEN2 = $this->input->post('ID_DEPARTEMEN2');
				$tanggal_status_kontrak2 = $this->input->post('tanggal_status_kontrak2');
				$tanggal_status_tetap2 = $this->input->post('tanggal_status_tetap2');
				
				//cek apakah input sama dengan eksisting
				$data=$this->ws_pegawai_model->get_data_by_id($id_pegawai);
				
				if($data['NIP'] == $nip || ($this->ws_pegawai_model->cek_nip($nip) == 'Data belum ada'))
				{
					//log
					$data=$this->ws_pegawai_model->get_data_by_id_cont_nip($id_pegawai);
					$KETERANGAN = "Ubah data pegawai: NIP ".$data['NIP']." jadi ".$nip." NAMA ".$data['NAMA']." jadi ".$nama." ID_STATUS_PEGAWAI ".$data['ID_STATUS_PEGAWAI']." jadi ".$ID_STATUS_PEGAWAI2." ID_JABATAN ".$data['ID_JABATAN']." jadi ".$ID_JABATAN2." ID_DEPARTEMEN ".$data['ID_DEPARTEMEN']." jadi ".$ID_DEPARTEMEN2." TANGGAL_STATUS_KONTRAK ".$data['TANGGAL_STATUS_KONTRAK']." jadi ".$tanggal_status_kontrak2." TANGGAL_STATUS_TETAP ".$data['TANGGAL_STATUS_TETAP']." jadi ".$tanggal_status_tetap2;
					$WAKTU = date('Y-m-d H:i:s');
					$this->ws_pegawai_model->log_pegawai($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
					
					
					$data=$this->ws_pegawai_model->update_nip($id_pegawai, $nip, $nama, $ID_STATUS_PEGAWAI2, $ID_JABATAN2, $ID_DEPARTEMEN2, $tanggal_status_kontrak2, $tanggal_status_tetap2);
					echo json_encode($data);
				}
				else
				{
					echo json_encode('NIP sudah terekam sebelumnya');
				}
			}
		}
		else
		{
			// log the user out
			$this->logout();
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
	
	/**
	 * Log the user out
	 */
	public function logout()
	{

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message','Anda tidak memiliki otorisasi untuk mengakses fitur ini, silahkan hubungi Administrator');
		redirect('auth/login', 'refresh');
	}
}
