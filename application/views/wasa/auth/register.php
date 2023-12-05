<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIPESUT | Registrasi Akun</title>

    <link rel="icon" href="<?php echo base_url(); ?>assets/logo_wasa.png">

    <link href="<?php echo base_url(); ?>assets/wasa/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <h3>Selamat Datang di Enterprise Asset Management PT. Wasa Mitra Engineering</h3>
			</br>
            <p>Silakan mendaftar untuk mendapatkan hak akses</p>
			<?php if($message != "") { ?>
			<div class="alert alert-danger alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<?php echo $message;?>
			</div>
			<?php 
			} ?>
			<?php if($pesan_nip != "") { ?>
			<div class="alert alert-danger alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<?php echo $pesan_nip;?>
			</div>
			<?php 
			} ?>
			
			
            <?php echo form_open("auth/register");?>
			<div class="form-group">
                    <input type="text" class="form-control" name="nip" id="nip" value="<?php echo set_value('nip'); ?>" placeholder="NIP" autofocus>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo set_value('email'); ?>" placeholder="Email" autofocus>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" id="password" value="<?php echo set_value('password'); ?>" placeholder="Password">
                </div>
				<div class="form-group">
                    <input type="password" class="form-control" name="password_confirm" id="password_confirm" value="<?php echo set_value('password_confirm'); ?>" placeholder="Konfirmasi Password">
                </div>
                <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="terms"><i></i> Saya setuju tentang syarat dan ketentuan </label></div>
                </div>
                <button id="daftar" type="submit" class="btn btn-primary block full-width m-b" disabled>Register</button>

                
                <a class="btn btn-sm btn-white btn-block" href="<?php echo base_url(); ?>index.php/auth/login">Kembali ke halaman Login</a>
            <?php echo form_close(); ?>
            <p class="m-t"> <small>EAM PT. WME &copy; 2021. Tema oleh Inspina</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
	
	<script>
	$('#terms').click(function () {
		//check if checkbox is checked
		if ($(this).is(':checked')) {
			
			$('#daftar').removeAttr('disabled'); //enable input
			
		} else {
			$('#daftar').attr('disabled', true); //disable input
		}
	});
    </script>
</body>

</html>
