<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>SIPESUT | Reset Password</title>

    <link rel="icon" href="<?php echo base_url(); ?>assets/logo_wasa.png">

    <link href="<?php echo base_url(); ?>assets/wasa/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/wasa/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <h3>Selamat Datang di SIPESUT WME</h3>
			</br>
            <p>Silakan masukkan password yang baru untuk mereset password Anda</p>
			
			<?php if($message != "") { ?>
			<div class="alert alert-danger alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				<?php echo $message;?>
			</div>
			<?php 
			} ?>
			
            <?php echo form_open("auth/reset_password/");?>
				<div class="form-group">
					<input type="password" class="form-control" name="password" id="password" value="<?php echo set_value('password'); ?>" placeholder="Password.." autofocus>
                </div>
				
				<div class="form-group">
					<input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" value="<?php echo set_value('konfirmasi_password'); ?>" placeholder="Konfirmasi Password.." >
                </div>
				
				<div class="form-group">
					<input type="hidden" class="form-control" name="code" id="code" value="<?php echo $code; ?>">
                </div>
				
				<div class="form-group">
					<input type="hidden" class="form-control" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                </div>
				
                <?php echo form_hidden($csrf); ?>

				
                <button type="submit" class="btn btn-primary block full-width m-b">Simpan Password</button>
				
				<a href=<?php echo base_url(); ?>index.php/auth/login><small>Login</small></a>
                
            <?php echo form_close(); ?>
            <p class="m-t"> <small>WME &copy; <?php echo date('Y'); ?>.</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>

</body>

</html>
