<div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">

            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
				<li>
                    <a href="<?php echo base_url(); ?>index.php/auth/logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            
        <div class="wrapper wrapper-content animated fadeInRight">
		
			<div class="alert alert-danger alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				Berikut adalah log aktivitas Anda dalam menggunakan aplikasi 
			</div>
			
            <div class="row">
                <div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log NIP dan Biodata Pegawai</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_pegawai">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_pegawai">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>

					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Riwayat Pekerjaan</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_riwayat_pekerjaan">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_riwayat_pekerjaan">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>

					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Pendidikan</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_pendidikan">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_pendidikan">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Pelatihan</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_pelatihan">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_pelatihan">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Alamat</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_alamat">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_alamat">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Keluarga</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_keluarga">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_keluarga">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Role User</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_role_user">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_role_user">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Registrasi User</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_registrasi_user">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_registrasi_user">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Ganti Password</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_ganti_password">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_ganti_password">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Status Pegawai</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_status_pegawai">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_status_pegawai">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Departemen</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_departemen">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_departemen">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Bidang Pekerjaan</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_bidang_pekerjaan">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_bidang_pekerjaan">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Jabatan</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_jabatan">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_jabatan">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Log Perusahaan</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a class="close-link">
									<i class="fa fa-times"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_log_perusahaan">
						<thead>
						<tr>
							<th>Melakukan</th>
							<th>Waktu</th>
							
						</tr>
						</thead>
						<tbody id="show_data_log_perusahaan">
					
						</tbody>
				 
						</table>
						</div>
						</div>
						
					</div>
					
					
					
				</div>
            </div>
        </div>
		</br>
		
        <div class="footer">
			<div>
				<p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br/> Hak cipta dilindungi undang-undang.</p>
			</div> 
        </div>

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

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
			
			//pemanggilan fungsi tampil data.
			tampil_data_log_pegawai();
			tampil_data_log_riwayat_pekerjaan();
			tampil_data_log_pendidikan();
			tampil_data_log_pelatihan();
			tampil_data_log_alamat();
			tampil_data_log_keluarga();
			tampil_data_log_role_user();
			tampil_data_log_registrasi_user();
			tampil_data_log_ganti_password();
			tampil_data_log_status_pegawai();
			tampil_data_log_departemen();
			tampil_data_log_bidang_pekerjaan();
			tampil_data_log_jabatan();
			tampil_data_log_perusahaan();
			
			$('#mydata_log_pegawai').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Biodata Pegawai'},
                    {extend: 'pdf', title: 'Log Biodata Pegawai'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

			$('#mydata_log_riwayat_pekerjaan').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Riwayat Pekerjaan Pegawai'},
                    {extend: 'pdf', title: 'Log Riwayat Pekerjaan Pegawai'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

			$('#mydata_log_pendidikan').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Pendidikan Pegawai'},
                    {extend: 'pdf', title: 'Log Pendidikan Pegawai'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			
			$('#mydata_log_pelatihan').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Pelatihan Pegawai'},
                    {extend: 'pdf', title: 'Log Pelatihan Pegawai'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#mydata_log_alamat').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Alamat Pegawai'},
                    {extend: 'pdf', title: 'Log Alamat Pegawai'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#mydata_log_keluarga').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Keluarga Pegawai'},
                    {extend: 'pdf', title: 'Log Keluarga Pegawai'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#mydata_log_role_user').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Role User Pegawai'},
                    {extend: 'pdf', title: 'Log Role User Pegawai'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#mydata_log_registrasi_user').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Registrasi User Pegawai'},
                    {extend: 'pdf', title: 'Log Registrasi User Pegawai'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#mydata_log_ganti_password').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Ganti Password Pegawai'},
                    {extend: 'pdf', title: 'Log Ganti Password Pegawai'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#mydata_log_status_pegawai').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Status Pegawai'},
                    {extend: 'pdf', title: 'Log Status Pegawai'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#mydata_log_departemen').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Departemen'},
                    {extend: 'pdf', title: 'Log Departemen'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#mydata_log_bidang_pekerjaan').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Bidang Pekerjaan'},
                    {extend: 'pdf', title: 'Log Bidang Pekerjaan'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#mydata_log_jabatan').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Jabatan'},
                    {extend: 'pdf', title: 'Log Jabatan'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#mydata_log_perusahaan').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Log Perusahaan'},
                    {extend: 'pdf', title: 'Log Perusahaan'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			 
			//fungsi tampil data log pegawai
			function tampil_data_log_pegawai(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_pegawai',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_pegawai').html(html);
					}

				});
			}

			//fungsi tampil data log riwayat pekerjaan
			function tampil_data_log_riwayat_pekerjaan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_riwayat_pekerjaan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_riwayat_pekerjaan').html(html);
					}

				});
			}

			//fungsi tampil data log riwayat pendidikan
			function tampil_data_log_pendidikan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_pendidikan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_pendidikan').html(html);
					}

				});
			}
			
			//fungsi tampil data log riwayat pelatihan
			function tampil_data_log_pelatihan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_pelatihan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_pelatihan').html(html);
					}

				});
			}
			
			//fungsi tampil data log alamat
			function tampil_data_log_alamat(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_alamat',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_alamat').html(html);
					}

				});
			}
			
			
			//fungsi tampil data log keluarga
			function tampil_data_log_keluarga(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_keluarga',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_keluarga').html(html);
					}

				});
			}
			
			//fungsi tampil data log role user
			function tampil_data_log_role_user(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_role_user',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_role_user').html(html);
					}

				});
			}
			
			//fungsi tampil data log registrasi user
			function tampil_data_log_registrasi_user(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_registrasi_user',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_registrasi_user').html(html);
					}

				});
			}
			
			//fungsi tampil data log ganti password
			function tampil_data_log_ganti_password(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_ganti_password',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_ganti_password').html(html);
					}

				});
			}
			
			//fungsi tampil data log status pegawai
			function tampil_data_log_status_pegawai(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_status_pegawai',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_status_pegawai').html(html);
					}

				});
			}
			
			//fungsi tampil data log departemen
			function tampil_data_log_departemen(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_departemen',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_departemen').html(html);
					}

				});
			}
			
			//fungsi tampil data log bidang pekerjaan
			function tampil_data_log_bidang_pekerjaan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_bidang_pekerjaan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_bidang_pekerjaan').html(html);
					}

				});
			}
			
			//fungsi tampil data log jabatan
			function tampil_data_log_jabatan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_jabatan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_jabatan').html(html);
					}

				});
			}
			
			//fungsi tampil data log perusahaan
			function tampil_data_log_perusahaan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/log_aktivitas/data_log_perusahaan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+data[i].WAKTU+'</td>'+
									'</tr>';
						}
						$('#show_data_log_perusahaan').html(html);
					}

				});
			}
			
        });

    </script>

</body>

</html>