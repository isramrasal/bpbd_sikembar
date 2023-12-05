<?php defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->library(array('ion_auth', 'form_validation'));
		$this->load->helper(array('url', 'language', 'file'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		$this->lang->load('auth');
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index()
	{

		if (!$this->ion_auth->logged_in()) {
			// redirect them to the login page
			redirect('auth/login', 'refresh');
		} else if ($this->ion_auth->is_admin()) {
			redirect('Dashboard_admin', 'refresh');
		} else if ($this->ion_auth->in_group(2)) {
			redirect('Dashboard_chief_sp', 'refresh');
		} else if ($this->ion_auth->in_group(3)) {
			redirect('Dashboard_sm_sp', 'refresh');
		} else if ($this->ion_auth->in_group(4)) {
			redirect('Dashboard_pm_sp', 'refresh');
		} else if ($this->ion_auth->in_group(5)) {
			redirect('Dashboard_staff_procurement_kp', 'refresh');
		} else if ($this->ion_auth->in_group(6)) {
			redirect('Dashboard_kasie_procurement_kp', 'refresh');
		} else if ($this->ion_auth->in_group(7)) {
			redirect('Dashboard_manajer_procurement_kp', 'refresh');
		} else if ($this->ion_auth->in_group(8)) {
			redirect('Dashboard_staff_procurement_sp', 'refresh');
		} else if ($this->ion_auth->in_group(9)) {
			redirect('Dashboard_supervisi_procurement_sp', 'refresh');
		} else if ($this->ion_auth->in_group(10)) {
			redirect('Dashboard_staff_umum_logistik_kp', 'refresh');
		} else if ($this->ion_auth->in_group(11)) {
			redirect('Dashboard_kasie_logistik_kp', 'refresh');
		} else if ($this->ion_auth->in_group(12)) {
			redirect('Dashboard_manajer_logistik_kp', 'refresh');
		} else if ($this->ion_auth->in_group(13)) {
			redirect('Dashboard_staff_umum_logistik_sp', 'refresh');
		} else if ($this->ion_auth->in_group(14)) {
			redirect('Dashboard_staff_gudang_logistik_sp', 'refresh');
		} else if ($this->ion_auth->in_group(15)) {
			redirect('Dashboard_supervisi_logistik_sp', 'refresh');
		} else if ($this->ion_auth->in_group(18)) {
			redirect('Dashboard_manajer_hrd_kp', 'refresh');
		} else if ($this->ion_auth->in_group(19)) {
			redirect('Dashboard_staff_keuangan_kp', 'refresh');
		} else if ($this->ion_auth->in_group(20)) {
			redirect('Dashboard_kasie_keuangan_kp', 'refresh');
		} else if ($this->ion_auth->in_group(21)) {
			redirect('Dashboard_manajer_keuangan_kp', 'refresh');
		} else if ($this->ion_auth->in_group(22)) {
			redirect('Dashboard_staff_konstruksi_kp', 'refresh');
		} else if ($this->ion_auth->in_group(23)) {
			redirect('Dashboard_kasie_konstruksi_kp', 'refresh');
		} else if ($this->ion_auth->in_group(24)) {
			redirect('Dashboard_manajer_konstruksi_kp', 'refresh');
		} else if ($this->ion_auth->in_group(25)) {
			redirect('Dashboard_staff_sdm_kp', 'refresh');
		} else if ($this->ion_auth->in_group(26)) {
			redirect('Dashboard_kasie_sdm_kp', 'refresh');
		} else if ($this->ion_auth->in_group(27)) {
			redirect('Dashboard_manajer_sdm_kp', 'refresh');
		} else if ($this->ion_auth->in_group(28)) {
			redirect('Dashboard_staff_qaqc_kp', 'refresh');
		} else if ($this->ion_auth->in_group(29)) {
			redirect('Dashboard_kasie_qaqc_kp', 'refresh');
		} //test
		else if ($this->ion_auth->in_group(30)) {
			redirect('Dashboard_manajer_qaqc_kp', 'refresh');
		} else if ($this->ion_auth->in_group(31)) {
			redirect('Dashboard_staff_pe_kp', 'refresh');
		} else if ($this->ion_auth->in_group(32)) {
			redirect('Dashboard_kasie_pe_kp', 'refresh');
		} else if ($this->ion_auth->in_group(33)) {
			redirect('Dashboard_manajer_ep_kp', 'refresh');
		} else if ($this->ion_auth->in_group(34)) {
			redirect('Dashboard_direktur_keuangan_kp', 'refresh');
		} else if ($this->ion_auth->in_group(35)) {
			redirect('Dashboard_direktur_psds_kp', 'refresh');
		} else if ($this->ion_auth->in_group(36)) {
			redirect('Dashboard_direktur_konstruksi_kp', 'refresh');
		} else if ($this->ion_auth->in_group(37)) {
			redirect('Dashboard_direktur_utama', 'refresh');
		} else if ($this->ion_auth->in_group(38)) {
			redirect('RFQ', 'refresh');
		} else if ($this->ion_auth->in_group(39)) {
			redirect('Dashboard_staff_hsse_kp', 'refresh');
		} else if ($this->ion_auth->in_group(40)) {
			redirect('Dashboard_kasie_hsse_kp', 'refresh');
		} else if ($this->ion_auth->in_group(41)) {
			redirect('Dashboard_manajer_hsse_kp', 'refresh');
		} else if ($this->ion_auth->in_group(42)) {
			redirect('Dashboard_staff_gudang_logistik_kp', 'refresh');
		} else if ($this->ion_auth->in_group(43)) {
			redirect('Dashboard_manajer_marketing_kp', 'refresh');
		} else if ($this->ion_auth->in_group(44)) {
			redirect('Dashboard_manajer_komersial_kp', 'refresh');
		} else if ($this->ion_auth->in_group(47)) {
			redirect('Dashboard_direktur_marketing_dan_komersial_kp', 'refresh');
		} else {
			// set the flash data error message if there is one
			$this->ion_auth->logout();
			$this->session->set_flashdata('message', 'Anda tidak memiliki otorisasi untuk mengakses sistem, silahkan hubungi admin');
			redirect('auth/login', 'refresh');
		}

		// redirect('Maintenance_404', 'refresh');
	}

	/**
	 * Log the user in
	 * fungsi LOGIN
	 */
	public function login()
	{
		if ($this->ion_auth->logged_in()) {
			// redirect them to the home page
			redirect('auth', 'refresh');
		} else {

			// validate form input
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if ($this->form_validation->run() === TRUE) {
				// check to see if the user is logging in
				// check for "remember me"
				//$remember = (bool)$this->input->post('remember');

				//if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
				if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'))) {
					//if the login is successful
					//redirect them back to the home page
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					redirect('auth', 'refresh');
				} else {
					// if the login was un-successful
					// redirect them back to the login page
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
				}
			} else {
				// the user is not logging in so display the login page
				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
				$this->data['title'] = 'SIPESUT | Login';

				$this->load->view('wasa/auth/login', $this->data);
			}
		}

		// redirect('Maintenance_404', 'refresh');
	}

	/**
	 * fungsi delete user
	 */
	public function delete_user($id)
	{
		$this->ion_auth->delete_user($id);
	}
	// Hapus

	/**
	 * Log the user out
	 */
	public function logout()
	{
		$this->data['title'] = "Wasa Mitra Engineering Employment System";

		// log the user out
		$logout = $this->ion_auth->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('auth/login', 'refresh');
	}

	/**
	 * Change password
	 */
	public function ganti_password()
	{
		if (!$this->ion_auth->logged_in()) {
			redirect('auth/login', 'refresh');
		}


		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

		$user = $this->ion_auth->user()->row();

		if ($this->form_validation->run() === FALSE) {
			// display the form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
			$this->data['old_password'] = array(
				'name' => 'old',
				'id' => 'old',
				'type' => 'password',
			);
			$this->data['new_password'] = array(
				'name' => 'new',
				'id' => 'new',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			);
			$this->data['new_password_confirm'] = array(
				'name' => 'new_confirm',
				'id' => 'new_confirm',
				'type' => 'password',
				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
			);
			$this->data['user_id'] = array(
				'name' => 'user_id',
				'id' => 'user_id',
				'type' => 'hidden',
				'value' => $user->id,
			);

			// render
			$this->load->view('wasa/head_normal', $this->data);
			$this->load->view('wasa/user_menu');
			$this->load->view('wasa/left_menu');
			$this->load->view('wasa/auth/contentgantipassword');
		} else {
			$identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

			if ($change) {
				//if the password was successfully changed
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$this->logout();
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('auth/change_password', 'refresh');
			}
		}
	}

	/**
	 * Forgot password
	 */
	public function lupa_password()
	{
		if ($this->ion_auth->logged_in()) {
			// redirect them to the home page
			redirect('auth', 'refresh');
		}

		// setting validation rules by checking whether identity is username or email
		if ($this->config->item('identity', 'ion_auth') != 'email') {
			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		} else {
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		}


		if ($this->form_validation->run() === FALSE) {
			$this->data['type'] = $this->config->item('identity', 'ion_auth');
			// setup the input
			$this->data['identity'] = array(
				'name' => 'identity',
				'id' => 'identity',
			);

			if ($this->config->item('identity', 'ion_auth') != 'email') {
				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			} else {
				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}

			// set any errors and display the form
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->_render_page('wasa/auth/lupapassword', $this->data);
		} else {
			$identity_column = $this->config->item('identity', 'ion_auth');
			$identity = $this->ion_auth->where($identity_column, $this->input->post('email'))->users()->row();

			if (empty($identity)) {

				if ($this->config->item('identity', 'ion_auth') != 'email') {
					$this->ion_auth->set_error('forgot_password_identity_not_found');
				} else {
					$this->ion_auth->set_error('forgot_password_email_not_found');
				}

				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/lupa_password", 'refresh');
			}

			// run the forgotten password method to email an activation code to the user
			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

			if ($forgotten) {
				// if there were no errors
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
			} else {
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect("auth/lupa_password", 'refresh');
			}
		}
	}

	/**
	 * Reset password - final step for forgotten password
	 *
	 * @param string|null $code The reset code
	 */
	public function reset_password($code = NULL)
	{
		if ($this->ion_auth->logged_in()) {
			// redirect them to the home page
			redirect('auth', 'refresh');
		}

		if (!$code) {
			$code = $this->input->post('code');
			if (!$code) {
				show_404();
			}
		}

		$user = $this->ion_auth->forgotten_password_check($code);

		if ($user) {
			// if the code is valid then display the password reset form

			$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[konfirmasi_password]');
			$this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required');

			if ($this->form_validation->run() === FALSE) {
				// display the form

				// set the flash data error message if there is one
				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');

				$this->data['user_id'] = $user->id;
				$this->data['csrf'] = $this->_get_csrf_nonce();
				$this->data['code'] = $code;

				// render
				$this->_render_page('wasa/auth/resetpassword', $this->data);
			} else {
				// do we have a valid request?
				if (($this->_valid_csrf_nonce() === FALSE) || ($user->id != $this->input->post('user_id'))) {

					// something fishy might be up
					$this->ion_auth->clear_forgotten_password_code($code);


					$this->session->set_flashdata('message', show_error($this->lang->line('error_csrf')));
					redirect("auth/login", 'refresh');
				} else {
					// finally change the password
					$identity = $user->{$this->config->item('identity', 'ion_auth')};

					$change = $this->ion_auth->reset_password($identity, $this->input->post('password'));

					if ($change) {
						// if the password was successfully changed
						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("auth/login", 'refresh');
					} else {
						$this->session->set_flashdata('message', $this->ion_auth->errors());
						$code = $this->input->post('code');
						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		} else {
			// if the code is invalid then send them back to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/lupa_password", 'refresh');
		}
	}

	/**
	 * Activate the user
	 *
	 * @param int         $id   The user ID
	 * @param string|bool $code The activation code
	 */
	public function aktivasi($id, $code = FALSE)
	{
		if ($this->ion_auth->logged_in()) {
			// redirect them to the home page
			redirect('auth', 'refresh');
		}

		if ($code !== FALSE) {
			$activation = $this->ion_auth->activate($id, $code);
		} else if ($this->ion_auth->is_admin()) {
			$activation = $this->ion_auth->activate($id);
		}

		if ($activation) {
			// redirect them to the auth page
			$this->session->set_flashdata('message', $this->ion_auth->messages());
			redirect("auth", 'refresh');
		} else {
			// redirect them to the forgot password page
			$this->session->set_flashdata('message', $this->ion_auth->errors());
			redirect("auth/lupa_password", 'refresh');
		}
	}

	/**
	 * Deactivate the user
	 *
	 * @param int|string|null $id The user ID
	 */
	public function deactivate($id = NULL)
	{
		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			// redirect them to the home page because they must be an administrator to view this
			return show_error('You must be an administrator to view this page.');
		}

		$id = (int)$id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

		if ($this->form_validation->run() === FALSE) {
			// insert csrf check
			$this->data['csrf'] = $this->_get_csrf_nonce();
			$this->data['user'] = $this->ion_auth->user($id)->row();

			$this->_render_page('auth/deactivate_user', $this->data);
		} else {
			// do we really want to deactivate?
			if ($this->input->post('confirm') == 'yes') {
				// do we have a valid request?
				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
					return show_error($this->lang->line('error_csrf'));
				}

				// do we have the right userlevel?
				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {
					$this->ion_auth->deactivate($id);
				}
			}

			// redirect them back to the auth page
			redirect('auth', 'refresh');
		}
	}

	/**
	 * Create a new user
	 * MEMBUAT USER BARU
	 */
	public function register()
	{

		if ($this->ion_auth->logged_in()) {
			// redirect them to the home page
			redirect('auth', 'refresh');
		}

		$this->data['title'] = 'SIPESUT | Register';

		$tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->data['identity_column'] = $identity_column;


		// validate form input
		$this->form_validation->set_rules('nip', 'NIP', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[' . $tables['users'] . '.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required');


		if ($this->form_validation->run() === TRUE) {

			$email = strtolower($this->input->post('email'));
			$identity = ($identity_column === 'email') ? $email : $this->input->post('email');
			$password = $this->input->post('password');

			$this->load->model('Pegawai_model');
			$nip = $this->input->post('nip');
			if ($this->Pegawai_model->cek_nip($nip) == 'Data belum ada') {
				$this->data['pesan_nip'] = "NIP Anda tidak ditemukan";
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
				$this->load->view('wasa/auth/register', $this->data);
			} else if ($this->Pegawai_model->cek_nip_by_status($nip) != 'NIP belum diaktivasi') {
				$this->data['pesan_nip'] = "NIP Anda telah diaktivasi";
				$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
				$this->load->view('wasa/auth/register', $this->data);
			} else {
				if ($this->Pegawai_model->cek_nip_dan_email($nip, $email) != 'Data belum ada') {
					$hasil = $this->Pegawai_model->cek_nip($nip);

					$additional_data = array(
						'ID_PEGAWAI' => $hasil['ID_PEGAWAI'],
						'NIK' => $hasil['NIK'],
						'STATUS_DATA_PEGAWAI' => "pegawai_wme",
					);
					$group = array('2');

					if ($this->ion_auth->register($identity, $password, $email, $additional_data, $group)) {
						// check to see if we are creating the user
						// redirect them back to the admin page


						$this->session->set_flashdata('message', $this->ion_auth->messages());
						redirect("auth", 'refresh');
					} else {
						// display the create user form
						// set the flash data error message if there is one
						$this->data['pesan_nip'] = "";
						$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
						$this->load->view('wasa/auth/register', $this->data);
					}
				} else {
					$this->data['pesan_nip'] = "NIP dan Email tidak sesuai";
					$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
					$this->load->view('wasa/auth/register', $this->data);
				}
			}
		} else {
			// display the create user form
			// set the flash data error message if there is one
			$this->data['pesan_nip'] = "";
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
			$this->load->view('wasa/auth/register', $this->data);
		}
	}


	/**
	 * Edit a user
	 *
	 * @param int|string $id
	 */
	public function edit_user($id)
	{
		$this->data['title'] = $this->lang->line('edit_user_heading');

		if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id))) {
			redirect('auth', 'refresh');
		}

		$user = $this->ion_auth->user($id)->row();
		$groups = $this->ion_auth->groups()->result_array();
		$currentGroups = $this->ion_auth->get_users_groups($id)->result();

		// validate form input
		$this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'trim|required');
		$this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'trim|required');
		$this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'trim|required');
		$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'trim|required');

		if (isset($_POST) && !empty($_POST)) {
			// do we have a valid request?
			if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
				show_error($this->lang->line('error_csrf'));
			}

			// update the password if it was posted
			if ($this->input->post('password')) {
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}

			if ($this->form_validation->run() === TRUE) {
				$data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'company' => $this->input->post('company'),
					'phone' => $this->input->post('phone'),
				);

				// update the password if it was posted
				if ($this->input->post('password')) {
					$data['password'] = $this->input->post('password');
				}

				// Only allow updating groups if user is admin
				if ($this->ion_auth->is_admin()) {
					// Update the groups user belongs to
					$groupData = $this->input->post('groups');

					if (isset($groupData) && !empty($groupData)) {

						$this->ion_auth->remove_from_group('', $id);

						foreach ($groupData as $grp) {
							$this->ion_auth->add_to_group($grp, $id);
						}
					}
				}

				// check to see if we are updating the user
				if ($this->ion_auth->update($user->id, $data)) {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->messages());
					if ($this->ion_auth->is_admin()) {
						redirect('auth', 'refresh');
					} else {
						redirect('/', 'refresh');
					}
				} else {
					// redirect them back to the admin page if admin, or to the base url if non admin
					$this->session->set_flashdata('message', $this->ion_auth->errors());
					if ($this->ion_auth->is_admin()) {
						redirect('auth', 'refresh');
					} else {
						redirect('/', 'refresh');
					}
				}
			}
		}

		// display the edit user form
		$this->data['csrf'] = $this->_get_csrf_nonce();

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['user'] = $user;
		$this->data['groups'] = $groups;
		$this->data['currentGroups'] = $currentGroups;

		$this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
		);
		$this->data['phone'] = array(
			'name'  => 'phone',
			'id'    => 'phone',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('phone', $user->phone),
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password'
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password'
		);

		$this->_render_page('auth/edit_user', $this->data);
	}

	/**
	 * Create a new group
	 */
	public function create_group()
	{
		$this->data['title'] = $this->lang->line('create_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'trim|required|alpha_dash');

		if ($this->form_validation->run() === TRUE) {
			$new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
			if ($new_group_id) {
				// check to see if we are creating the group
				// redirect them back to the admin page
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect("auth", 'refresh');
			}
		} else {
			// display the create group form
			// set the flash data error message if there is one
			$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

			$this->data['group_name'] = array(
				'name'  => 'group_name',
				'id'    => 'group_name',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('group_name'),
			);
			$this->data['description'] = array(
				'name'  => 'description',
				'id'    => 'description',
				'type'  => 'text',
				'value' => $this->form_validation->set_value('description'),
			);

			$this->_render_page('auth/create_group', $this->data);
		}
	}

	/**
	 * Edit a group
	 *
	 * @param int|string $id
	 */
	public function edit_group($id)
	{
		// bail if no group id given
		if (!$id || empty($id)) {
			redirect('auth', 'refresh');
		}

		$this->data['title'] = $this->lang->line('edit_group_title');

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
			redirect('auth', 'refresh');
		}

		$group = $this->ion_auth->group($id)->row();

		// validate form input
		$this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

		if (isset($_POST) && !empty($_POST)) {
			if ($this->form_validation->run() === TRUE) {
				$group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

				if ($group_update) {
					$this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
				} else {
					$this->session->set_flashdata('message', $this->ion_auth->errors());
				}
				redirect("auth", 'refresh');
			}
		}

		// set the flash data error message if there is one
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

		// pass the user to the view
		$this->data['group'] = $group;

		$readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

		$this->data['group_name'] = array(
			'name'    => 'group_name',
			'id'      => 'group_name',
			'type'    => 'text',
			'value'   => $this->form_validation->set_value('group_name', $group->name),
			$readonly => $readonly,
		);
		$this->data['group_description'] = array(
			'name'  => 'group_description',
			'id'    => 'group_description',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('group_description', $group->description),
		);

		$this->_render_page('auth/edit_group', $this->data);
	}

	/**
	 * @return array A CSRF key-value pair
	 */
	public function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	/**
	 * @return bool Whether the posted CSRF token matches
	 */
	public function _valid_csrf_nonce()
	{
		$csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
		if ($csrfkey && $csrfkey === $this->session->flashdata('csrfvalue')) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * @param string     $view
	 * @param array|null $data
	 * @param bool       $returnhtml
	 *
	 * @return mixed
	 */
	public function _render_page($view, $data = NULL, $returnhtml = FALSE) //I think this makes more sense
	{

		$this->viewdata = (empty($data)) ? $this->data : $data;

		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);

		// This will return html on 3rd argument being true
		if ($returnhtml) {
			return $view_html;
		}
	}
}
