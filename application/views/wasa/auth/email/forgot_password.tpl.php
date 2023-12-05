<html>
<body>
	<h1><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></h1>
	<p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?>
	</br>
	</br>
	</br>
	Abaikan email ini jika Anda tidak merasa ingin mereset password.
	</p>
</body>
</html>