<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registrasi_user extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation','session'));
		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
		$this->data['title'] = 'SIPESUT WME | Registrasi User';
		
		$this->load->model('Registrasi_user_model');
		$this->load->model('Foto_model');
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
			$this->data['left_menu'] = "pegawai_aktif";
			
			$this->load->view('wasa/user_admin/head_normal', $this->data);
			$this->load->view('wasa/user_admin/user_menu');
			$this->load->view('wasa/user_admin/left_menu');
			$this->load->view('wasa/user_admin/header_menu');
			$this->load->view('wasa/user_admin/content_registrasi_user');
			
		}
		else
		{
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
		}
	}
	
	function data_registrasi_user()
	{	
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$data=$this->Registrasi_user_model->registrasi_user_list();
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
			$data=$this->Registrasi_user_model->get_data_by_id($id);
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
	
	
	function update_data()
	{
		if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
		{
			$user = $this->ion_auth->user()->row();
			
			$tables = $this->config->item('tables', 'ion_auth');
			//set validation rules
			$this->form_validation->set_rules('email2', 'Email', 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
			$this->form_validation->set_rules('ganti_password2', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[ganti_password3]');
			$this->form_validation->set_rules('ganti_password3', 'Ketik Ulang Password', 'required');
			
			//run validation check
			if ($this->form_validation->run() == FALSE)
			{   //validation fails
				echo json_encode(validation_errors());
			}
			else
			{
				//get the form data
				$id_pegawai2=$this->input->post('id_pegawai2');
				$email2=$this->input->post('email2');
				$ganti_password2=$this->input->post('ganti_password2');
				$ganti_password3=$this->input->post('ganti_password3');
				
				$hashed_new_password  = $this->ion_auth->hash_password($ganti_password3);
				
				$created =  time();
				
				$data=$this->Registrasi_user_model->update_data($email2, $hashed_new_password, $created, $id_pegawai2);
				
				$hsl=$this->db->query("SELECT id from users WHERE ID_PEGAWAI ='$id_pegawai2'");
				if($hsl->num_rows()>0){
					foreach ($hsl->result() as $data) {
						$hasil=array(
							'id' => $data->id
							);
					}
				}
				$ID_User = $hasil['id'];
				
				$data=$this->db->query("INSERT INTO users_groups (id, user_id, group_id) VALUES (NULL, '$ID_User', '2')");
				
				//log
				// $KETERANGAN = "Registrasi User: ID PEGAWAI ".$id_pegawai2." EMAIL ".$email2.", HASH PASSWORD ".$hashed_new_password." CREATED ".$created;
				// $WAKTU = date('Y-m-d H:i:s');
				// $this->Registrasi_user_model->log_registrasi_user($user->ID_PEGAWAI, $KETERANGAN, $WAKTU);
				
				echo json_encode($data);

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
