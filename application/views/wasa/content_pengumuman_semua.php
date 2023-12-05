<div class="gray-bg">
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-10">
				<h2>Semua Pengumuman</h2>
				<ol class="breadcrumb">
					<li>
						<a href="<?php echo base_url(); ?>">Home</a>
					</li>
					<li class="active">
						<strong>Pengumuman</strong>
					</li>
				</ol>
			</div>
			<div class="col-lg-2">

			</div>
		</div>

		<div class="wrapper wrapper-content  animated fadeInRight blog">
            <div class="row">
					<?php

					$jumlah_pengumuman = count($pengumuman->result_array());
					for ($x = 0; $x < $jumlah_pengumuman; $x++) {

					?>
					<div class="col-lg-4">
						<div class="ibox">
							<div class="ibox-content">
								<a href="#" class="btn-link">
									<h2>
										<?php echo $pengumuman->result_array()[$x]['JUDUL'];?>
									</h2>
								</a>
								<div class="small m-b-xs">
									<span class="text-muted"><i class="fa fa-clock-o"></i> <?php echo $pengumuman->result_array()[$x]['TANGGAL_POSTING'];?></span>
								</div>
								<p><?php echo $pengumuman->result_array()[$x]['ISI'];?></p>
							</div>
						</div>
					</div>

					<?php
					}
					?>

                    
            </div>


        </div>

		
    <!-- Mainly scripts -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>
	
	<!-- Data picker -->
	<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/datapicker/bootstrap-datepicker.js"></script>
	
	<!-- Date range use moment.js same as full calendar plugin -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/fullcalendar/moment.min.js"></script>

    <!-- Date range picker -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>
	
	<!-- SUMMERNOTE -->
	<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/summernote/summernote.min.js"></script>


    <!-- Page-Level Scripts -->


</body>

</html>