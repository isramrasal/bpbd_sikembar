<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo $title; ?></title>

    <link rel="icon" href="<?php echo base_url(); ?>assets/logo_bpbd.jpg">

    <link href="<?php echo base_url(); ?>assets/wasa/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="<?php echo base_url(); ?>assets/wasa/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/wasa/css/style.css" rel="stylesheet">

</head>


<body class="gray-bg">

    <div class="loginColumns animated fadeInDown">

        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo base_url(); ?>assets/logo_bpbd.jpg" width="120" height="auto" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2 class="font-bold">Selamat Datang di SiKembar <br> BPBD Kabupaten Cianjur</h2>

                <p>
                    SiKembar
                </p>

                <p>
                    adalah sistem informasi keluar masuk barang untuk membantu kegiatan Divisi Kedaruratan & Logistik BPBD Kabupaten Cianjur
                </p>

                <p>
                    <small>Silahkan hubungi administrator untuk dapat mengakses aplikasi ini.</small>
                </p>
                </br>
                </br>


            </div>
            <div class="col-md-6">
                <?php if ($message != "") { ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <?php echo $message; ?>
                    </div>
                <?php
                } ?>

                <div class="ibox-content">
                    <?php echo form_open("auth/login"); ?>
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo set_value('username'); ?>" placeholder="Username" autofocus>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" value="<?php echo set_value('password'); ?>" placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                    <a href=<?php echo base_url(); ?>index.php/auth/lupa_password><small>Lupa Password</small></a>

                    <?php echo form_close(); ?>
                    <p class="m-t">
                        <small>Theme by Inspina | Engine by CodeIgniter | Webapps</small>
                    </p>
                </div>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-6">
                Copyright Tim PKKM Prodi Informatika Universitas Gunadarma
            </div>
            <div class="col-md-6 text-right">
                <small>© <?php echo date('Y'); ?></small>
            </div>
        </div>
    </div>

</body>

</html>