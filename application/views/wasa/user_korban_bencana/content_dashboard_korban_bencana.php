<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Dashboard</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li class="active">
                <strong>
                    <a>Dashboard</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content">
    <div class="row dashboard-cards">
        <!-- Container 1 -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="dashboard-card card-hover-animation">
                <div class="card-icon bg-gradient-primary">
                    <i class="fa fa-file-text"></i>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Jumlah Pengajuan Bantuan</h3>
                    <h1 class="card-value"><?php echo $jumlah_pengajuan; ?></h1>
                    <p class="card-footer">Update terakhir: <?php echo $last_update_pengajuan; ?></p>
                </div>
            </div>
        </div>

        <!-- Container 2 -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="dashboard-card card-hover-animation">
                <div class="card-icon bg-gradient-success">
                    <i class="fa fa-handshake-o"></i>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Jumlah Penyaluran Bantuan</h3>
                    <h1 class="card-value"><?php echo $jumlah_penyaluran; ?></h1>
                    <p class="card-footer">Update terakhir: <?php echo $last_update_penyaluran; ?></p>
                </div>
            </div>
        </div>

        <!-- Container 3 -->
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="dashboard-card card-hover-animation">
                <div class="card-icon bg-gradient-info">
                    <i class="fa fa-users"></i>
                </div>
                <div class="card-content">
                    <h3 class="card-title">Jumlah Data Korban</h3>
                    <h1 class="card-value"><?php echo $jumlah_data_korban; ?></h1>
                    <p class="card-footer">Update terakhir: <?php echo $last_update_korban; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.dashboard-cards {
    margin: 20px 0;
}

.dashboard-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 220px;
    display: flex;
    flex-direction: column;
}

.card-hover-animation:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}

.card-icon {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, #6777ef 0%, #3512d1 100%);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #47c363 0%, #128a3d 100%);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #3abaf4 0%, #1769d1 100%);
}

.card-content {
    padding: 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.card-title {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 10px;
    font-weight: 600;
}

.card-value {
    font-size: 2.2rem;
    font-weight: 700;
    color: #34395e;
    margin: 10px 0;
}

.card-footer {
    font-size: 0.8rem;
    color: #98a6ad;
    margin-top: auto;
    margin-bottom: 0;
}

@media (max-width: 992px) {
    .dashboard-card {
        height: auto;
    }
}
</style>

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js">
</script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js">
</script>

<!-- Flot -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.tooltip.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.spline.js">
</script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.resize.js">
</script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.symbol.js">
</script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.time.js"></script>

<!-- Peity -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/peity/jquery.peity.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/wasa/js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/jquery-ui/jquery-ui.min.js">
</script>

<!-- Jvectormap -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js">
</script>

<!-- EayPIE -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/easypiechart/jquery.easypiechart.js">
</script>

<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/sparkline/jquery.sparkline.min.js">
</script>

<!-- Sparkline demo data  -->
<script src="<?php echo base_url(); ?>assets/wasa/js/demo/sparkline-demo.js"></script>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script>
$(document).ready(function() {
    // Add any custom JS here if needed
});
</script>
</body>

</html>