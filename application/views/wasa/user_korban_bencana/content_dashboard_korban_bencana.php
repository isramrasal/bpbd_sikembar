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
<div class="wrapper wrapper-content d-flex"
    style="display: flex; gap: 20px; flex-direction: row; flex-wrap: nowrap; overflow-x: auto;">
    <!-- Container 1 -->
    <div class="container" style="width: 400px;">
        <div class="card white-bg" style="width: 100%; height: 200px;">
            <div class="card-body" style="padding: 10px;">
                <h2 class="card-title font-bold text-center" style="padding-bottom: 20px;">
                    Jumlah Pengajuan Bantuan
                </h2>
                <h1 class="card-text font-bold text-center">
                    <?php echo $jumlah_pengajuan; ?>
                </h1>
            </div>
        </div>
    </div>

    <!-- Container 2 -->
    <div class="container" style="width: 400px;">
        <div class="card white-bg" style="width: 100%; height: 200px;">
            <div class="card-body" style="padding: 10px;">
                <h2 class="card-title font-bold text-center" style="padding-bottom: 20px;">
                    Jumlah Penyaluran Bantuan
                </h2>
                <h1 class="card-text font-bold text-center">
                    <?php echo $jumlah_penyaluran; ?>
                </h1>
            </div>
        </div>
    </div>

    <!-- Container 3 -->
    <div class="container" style="width: 400px;">
        <div class="card white-bg" style="width: 100%; height: 200px;">
            <div class="card-body" style="padding: 10px;">
                <h2 class="card-title font-bold text-center" style="padding-bottom: 20px;">
                    Jumlah Data Korban
                </h2>
                <h1 class="card-text font-bold text-center">
                    <?php echo $jumlah_data_korban; ?>
                </h1>
            </div>
        </div>
    </div>
</div>

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Flot -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.spline.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.resize.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.pie.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.symbol.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/flot/jquery.flot.time.js"></script>

<!-- Peity -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/peity/jquery.peity.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/demo/peity-demo.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- jQuery UI -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/jquery-ui/jquery-ui.min.js"></script>

<!-- Jvectormap -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js">
</script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js">
</script>

<!-- EayPIE -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/easypiechart/jquery.easypiechart.js"></script>

<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- Sparkline demo data  -->
<script src="<?php echo base_url(); ?>assets/wasa/js/demo/sparkline-demo.js"></script>

<script>
$(document).ready(function() {

});
</script>
</body>

</html>