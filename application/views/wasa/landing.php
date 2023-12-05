<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EAM | Home Page</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/wasa/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animation CSS -->
    <link href="<?php echo base_url(); ?>assets/wasa/css/animate.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/wasa/css/style.css" rel="stylesheet">
</head>
<body id="page-top" class="landing-page no-skin-config">
<div class="navbar-wrapper">
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url(); ?>index.php/auth">LOGIN</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a class="page-scroll" href="#page-top">Home</a></li>
						<li><a class="page-scroll" href="#about">Tentang</a></li>
						<li><a class="page-scroll" href="#pengumuman">Pengumuman</a></li>
                        <li><a class="page-scroll" href="#contact">Kontak</a></li>
                    </ul>
                </div>
            </div>
        </nav>
</div>
<div id="inSlider" class="carousel carousel-fade" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#inSlider" data-slide-to="0" class="active"></li>
        <li data-target="#inSlider" data-slide-to="1"></li>
    </ol>
    <div class="carousel-inner" role="listbox">
        <div class="item active">
            <div class="container">
                <div class="carousel-caption blank">
                    <h1>Selamat Datang di <br/>
						Enterprise Management System <br/>
                        PT. Wasa Mitra Engineering <br/>
						</br>
                    <p>
                        <a class="btn btn-lg btn-primary" href="#" role="button">BERGABUNGLAH BERSAMA KAMI</a>
                    </p>
                </div>
				<!-- 
                <div class="carousel-image wow zoomIn">
                    <img src="<?php echo base_url(); ?>assets/wasa/img/landing/MobileSlider_engineering.jpg" alt="MOBILE"/>
                </div>
				-->
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back one"></div>

        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-caption blank">
                    <h1>43 tahun <br/> Kami berkarya untuk Indonesia</h1>
                    <p>Berkontribusi dalam pembangunan di banyak penjuru negeri</p>
                </div>
            </div>
            <!-- Set background for slide in css -->
            <div class="header-back two"></div>
        </div>
    </div>
    <a class="left carousel-control" href="#inSlider" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#inSlider" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<section  id="about" class="container features">
    <div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1>Building Up<br/> <span class="navy"> For Better Future</span> </h1>
            <p>Kami bekerja dengan sepenuh hati</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 text-center wow fadeInLeft">
            <div>
                <i class="fa fa-gears features-icon"></i>
                <h2>Mechanical Works</h2>
                <p>Mengerjakan pekerjaan Mekanikal, seperti : Pemasangan Steam Turbine Generator. Circulating Water Pipe, Piping, Dll.</p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-bolt features-icon"></i>
                <h2>Electrical Works</h2>
                <p>Mengerjakan pekerjaan Elektrikal, seperti : Pemasangan Cable Tray, Pembangunan Switchyard Substation, Instalasi listrik dengan Conduit, Dll.</p>
            </div>
        </div>
        <div class="col-md-6 text-center wow zoomIn">
            <img src="<?php echo base_url(); ?>assets/wasa/img/landing/worker.png" alt="dashboard" class="img-responsive">
        </div>
        <div class="col-md-3 text-center wow fadeInRight">
            <div>
                <i class="fa fa-plug features-icon"></i>
                <h2>Instrumentation Works</h2>
                <p>Mengerjakan pekerjaan yang berkaitan dengan pemasangan dan maintenance instrumen</p>
            </div>
            <div class="m-t-lg">
                <i class="fa fa-check-square-o features-icon"></i>
                <h2>Commisioning Support</h2>
                <p>Menyediakan jasa commisioning untuk mengawasi progress suatu proyek</p>
            </div>
        </div>
    </div>
</section>

<section id="pengumuman" class="timeline gray-section">
<div class="container services">
	<div class="row">
        <div class="col-lg-12 text-center">
            <div class="navy-line"></div>
            <h1><br/> <span class="navy">Pengumuman</span> </h1>
        </div>
    </div>
    <div class="row">
		<?php

		$jumlah_pengumuman = count($pengumuman->result_array());
		$batas = 0;
		if($jumlah_pengumuman > 4)
		{
			$batas = 4;
		}
		else
		{
			$batas = count($pengumuman->result_array());
		}
		for ($x = 0; $x < $batas; $x++) {

		?>

		<div class="col-sm-3">
            <h2><?php echo $pengumuman->result_array()[$x]['JUDUL'];?></h2>
            <p><?php echo $pengumuman->result_array()[$x]['ISI'];?></p>
			<p><a class="navy-link" href="#" role="button">Posted: <?php echo $pengumuman->result_array()[$x]['TANGGAL_POSTING'];?></a></p>
        </div>

		<?php
		}
		?>

    </div>
	<p><a class="navy-link" href="<?php echo base_url(); ?>index.php/pengumuman/semua" role="button">Lihat semua pengumuman &raquo;</a></p>
</div>
</section>


<section id="contact" class="contact">
    <div class="container">
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <div class="navy-line"></div>
                <h1>Kontak Kami</h1>
            </div>
        </div>
        <div class="row m-b-lg">
            <div class="col-lg-12 text-center">
                <address>
                    <strong><span class="navy">PT. Wasa Mitra Enginering </span></strong><br/>
                    Gedung WASA<br/>
					Jalan Raya Cakung Cilincing KM 1 No. 11<br/>
					Jakarta Timur 13910<br/>
                    <abbr title="Telephone">Tel:</abbr> (62) 21 4604958
                </address>
            </div>
           
        </div>
        <div class="row">
            <div class="col-lg-12 text-center">
                <a href="mailto:test@email.com" class="btn btn-primary">Send us mail</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center m-t-lg m-b-lg">
                <p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br/> Hak cipta dilindungi undang-undang.</p>
				<a href="https://seal.beyondsecurity.com/vulnerability-scanner-verification/119.82.239.162"><img src="https://seal.beyondsecurity.com/verification-images/119.82.239.162/vulnerability-scanner-2.gif" alt="Website Security Test" border="0"></a>
            </div>
        </div>
    </div>
</section>

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/wow/wow.min.js"></script>


<script>

    $(document).ready(function () {

        $('body').scrollspy({
            target: '.navbar-fixed-top',
            offset: 80
        });

        // Page scrolling feature
        $('a.page-scroll').bind('click', function(event) {
            var link = $(this);
            $('html, body').stop().animate({
                scrollTop: $(link.attr('href')).offset().top - 50
            }, 500);
            event.preventDefault();
            $("#navbar").collapse('hide');
        });
    });

    var cbpAnimatedHeader = (function() {
        var docElem = document.documentElement,
                header = document.querySelector( '.navbar-default' ),
                didScroll = false,
                changeHeaderOn = 200;
        function init() {
            window.addEventListener( 'scroll', function( event ) {
                if( !didScroll ) {
                    didScroll = true;
                    setTimeout( scrollPage, 250 );
                }
            }, false );
        }
        function scrollPage() {
            var sy = scrollY();
            if ( sy >= changeHeaderOn ) {
                $(header).addClass('navbar-scroll')
            }
            else {
                $(header).removeClass('navbar-scroll')
            }
            didScroll = false;
        }
        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }
        init();

    })();

    // Activate WOW.js plugin for animation on scrol
    new WOW().init();

</script>

</body>
</html>
