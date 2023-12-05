<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT | Jabatan';
		
		$this->load->model('ws_jabatan_model');
		$this->load->model('ws_foto_model');
		$this->load->model('ws_pegawai_model');
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
		$this->data['left_menu'] = "jabatan_aktif";
		
		$query_foto_user = $this->ws_foto_model->get_data_by_id_pegawai($user->ID_PEGAWAI);
		if ($query_foto_user == "BELUM ADA FOTO")
		{
			$this->data['foto_user'] = "assets/wasa/img/profile_small.jpg";
		}
		else
		{
			$this->data['foto_user'] = $query_foto_user['KETERANGAN_2'];
		}
		
		$query_jabatan_departemen = $this->ws_pegawai_model->get_data_by_id_cont_nip($user->ID_PEGAWAI);
		$this->data['nama'] = $query_jabatan_departemen['NAMA'];
		$this->data['nama_status_pegawai'] = $query_jabatan_departemen['NAMA_STATUS_PEGAWAI'];
		$this->data['jabatan'] = $query_jabatan_departemen['NAMA_JABATAN'];
		$this->data['departemen'] = $query_jabatan_departemen['NAMA_DEPARTEMEN'];

		//jika mereka sudah login dan sebagai admin
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$this->load->view('wasa/head_normal', $this->data);
			$this->load->view('wasa/user_menu');
			$this->load->view('wasa/left_menu');
			$this->load->view('wasa/content_jabatan');
			
		}
		else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		{	
			$this->load->view('wasa/pegawai/head_normal', $this->data);
			$this->load->view('wasa/pegawai/user_menu');
			$this->load->view('wasa/pegawai/left_menu');
			$this->load->view('wasa/pegawai/content_jabatan');
		}
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
	
	function data_jabatan()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$data=$this->ws_jabatan_model->jabatan_list();
			echo json_encode($data);
		}
		else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		{	
			$user = $this->ion_auth->user()->row();
			$data=$this->ws_jabatan_model->jabatan_list_by_id_pegawai_atau_status($user->ID_PEGAWAI);
			echo json_encode($data);
		}
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
			$data=$this->ws_jabatan_model->get_data_by_id($id);
			echo json_encode($data);
		}
		else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		{	
			$id=$this->input->get('id');
			$data=$this->ws_jabatan_model->get_data_by_id($id);
			echo json_encode($data);
		}
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
			$user = $this->ion_auth->user()->row();
			$id_jabatan=$this->input->post('kode');
			$data=$this->ws_jabatan_model->get_data_by_id($id_jabatan);
			
			//log
			$KETERANGAN = "Hapus jabatan ".$data['NAMA_JABATAN']." , KET ".$data['KETERANGAN'];
			$WAKTU = date('Y-m-d H:i:s');
			$this->ws_jabatan_model->log_jabatan($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
			
			$data=$this->ws_jabatan_model->hapus_data($id_jabatan);
			echo json_encode($data);
		}
		else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		{
			$user = $this->ion_auth->user()->row();
			$id_jabatan=$this->input->post('kode');
			$data=$this->ws_jabatan_model->get_data_by_id($id_jabatan);
			
			//log
			$KETERANGAN = "Hapus jabatan ".$data['NAMA_JABATAN'].", ket ".$data['KETERANGAN'];
			$WAKTU = date('Y-m-d H:i:s');
			$this->ws_jabatan_model->log_jabatan($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
			
			$data=$this->ws_jabatan_model->hapus_data($id_jabatan);
			echo json_encode($data);
		}
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
			$user = $this->ion_auth->user()->row();
			
			//set validation rules
			$this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'trim|required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
			
			//run validation check
			if ($this->form_validation->run() == FALSE)
			{   //validation fails
				echo validation_errors();
			}
			else
			{
				//get the form data
				$nama_jabatan = $this->input->post('nama_jabatan');
				$keterangan = $this->input->post('keterangan');
				if($this->ws_jabatan_model->cek_nama_jabatan_by_admin($nama_jabatan) == 'Data belum ada')
				{
					//log
					$KETERANGAN = "Simpan jabatan ".$nama_jabatan.", ket ".$keterangan;
					$WAKTU = date('Y-m-d H:i:s');
					$this->ws_jabatan_model->log_jabatan($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
					
					$data=$this->ws_jabatan_model->simpan_data_by_admin($nama_jabatan,$keterangan, $user->ID_PEGAWAI);
				}
				else
				{
					echo 'Nama jabatan sudah terekam sebelumnya';
				}
				
			}
		}
		else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		{
			$user = $this->ion_auth->user()->row();
			
			//set validation rules
			$this->form_validation->set_rules('nama_jabatan', 'Nama Jabatan', 'trim|required');
			$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|required');
			
			//run validation check
			if ($this->form_validation->run() == FALSE)
			{   //validation fails
				echo validation_errors();
			}
			else
			{
				//get the form data
				$nama_jabatan = $this->input->post('nama_jabatan');
				$keterangan = $this->input->post('keterangan');
				if($this->ws_jabatan_model->cek_nama_jabatan_by_pegawai($nama_jabatan, $user->ID_PEGAWAI) == 'Data belum ada')
				{
					//log
					$KETERANGAN = "Simpan jabatan ".$nama_jabatan.", ket ".$keterangan;
					$WAKTU = date('Y-m-d H:i:s');
					$this->ws_jabatan_model->log_jabatan($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
					
					$data=$this->ws_jabatan_model->simpan_data_by_pegawai($nama_jabatan,$keterangan, $user->ID_PEGAWAI);
				}
				else
				{
					echo 'Nama jabatan sudah terekam sebelumnya';
				}
				
			}
		}
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
			$user = $this->ion_auth->user()->row();
			
			//set validation rules
			$this->form_validation->set_rules('nama_jabatan2', 'Nama Jabatan', 'trim|required');
			$this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');
			
			//run validation check
			if ($this->form_validation->run() == FALSE)
			{   //validation fails
				echo json_encode(validation_errors());
			}
			else
			{
				//get the form data
				$id_jabatan=$this->input->post('id_jabatan2');
				$nama_jabatan=$this->input->post('nama_jabatan2');
				$keterangan=$this->input->post('keterangan2');
				
				//cek apakah input sama dengan eksisting
				$data=$this->ws_jabatan_model->get_data_by_id($id_jabatan);
				
				if($data['NAMA_JABATAN'] == $nama_jabatan || ($this->ws_jabatan_model->cek_nama_jabatan_by_admin($nama_jabatan) == 'Data belum ada'))
				{
					$data=$this->ws_jabatan_model->get_data_by_id($id_jabatan);
					
					//log
					$KETERANGAN = "Ubah jabatan ".$data['NAMA_JABATAN']." jadi ".$nama_jabatan.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					$WAKTU = date('Y-m-d H:i:s');
					$this->ws_jabatan_model->log_jabatan($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
					
					$data=$this->ws_jabatan_model->update_data($id_jabatan, $nama_jabatan,$keterangan);
					echo json_encode($data);
				}
				else
				{
					echo json_encode('Nama jabatan sudah terekam sebelumnya');
				}
			}
		}
		else if ($this->ion_auth->logged_in() && ($this->ion_auth->in_group(2) || $this->ion_auth->in_group(3) || $this->ion_auth->in_group(4)))
		{
			$user = $this->ion_auth->user()->row();
			
			//set validation rules
			$this->form_validation->set_rules('nama_jabatan2', 'Nama Jabatan', 'trim|required');
			$this->form_validation->set_rules('keterangan2', 'Keterangan', 'trim|required');
			
			//run validation check
			if ($this->form_validation->run() == FALSE)
			{   //validation fails
				echo json_encode(validation_errors());
			}
			else
			{
				//get the form data
				$id_jabatan=$this->input->post('id_jabatan2');
				$nama_jabatan=$this->input->post('nama_jabatan2');
				$keterangan=$this->input->post('keterangan2');
				
				//cek apakah input sama dengan eksisting
				$data=$this->ws_jabatan_model->get_data_by_id($id_jabatan);
				
				if($data['NAMA_JABATAN'] == $nama_jabatan || ($this->ws_jabatan_model->cek_nama_jabatan_by_pegawai($nama_jabatan, $user->ID_PEGAWAI) == 'Data belum ada'))
				{
					$data=$this->ws_jabatan_model->get_data_by_id($id_jabatan);
					
					//log
					$KETERANGAN = "Ubah jabatan ".$data['NAMA_JABATAN']." jadi ".$nama_jabatan.", ket ".$data['KETERANGAN']." jadi ".$keterangan;
					$WAKTU = date('Y-m-d H:i:s');
					$this->ws_jabatan_model->log_jabatan($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
					
					$data=$this->ws_jabatan_model->update_data($id_jabatan, $nama_jabatan,$keterangan);
					echo json_encode($data);
				}
				else
				{
					echo json_encode('Nama jabatan sudah terekam sebelumnya');
				}
			}
		}
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
