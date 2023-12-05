<?php defined('BASEPATH') or exit('No direct script access allowed');

class kirim_email extends CI_Controller
{
public function index()
	{
		
		//Load email library
		$this->load->library('email');

		//SMTP & mail configuration
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_user' => 'userforkindo@gmail.com',
			'smtp_pass' => 'Andasiapa20',
			'mailtype' => 'html',
			'charset' => 'utf-8'
			
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		//Email content
		$htmlContent = '<h1>Sending email via SMTP server</h1>';
		$htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';
		// $message = str_replace ("\r\n", "<br>", $this->input->post('message') );

		$this->email->to('isramrasal@yahoo.com');
		$this->email->from('userforkindo@gmail.com','MyWebsite');
		$this->email->subject('How to send email via SMTP server in CodeIgniter');
		$this->email->message($htmlContent);

		//Send email
		if($this->email->send())
		{
			echo 'Your email was sent.';
		}

		else
		{
			show_error($this->email->print_debugger());
		}
	}

}