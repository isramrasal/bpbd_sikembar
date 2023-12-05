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
				Pastikan Anda mengisi data dengan benar.
			</div>
			
			<div class="alert alert-info">
				Sifat Kriteria Penilaian "Benefit"
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Kriteria Penilaian Pendidikan (C1)</h5>
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
                    <table class="table table-striped table-bordered table-hover"  id="mydata_pendidikan">
					<thead>
                    <tr>
						<th>Nomor</th>
						<th>Jenjang Pendidikan</th>
						<th>Kategori</th>
						<th>Nilai</th>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data_pendidikan">
				
					</tbody>
             
                    </table>
                </div>
            </div>
            </div>
			
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Kriteria Penilaian Lama Kerja (C2)</h5>
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
                    <table class="table table-striped table-bordered table-hover"  id="mydata_pengalaman_kerja">
					<thead>
                    <tr>
						<th>Nomor</th>
						<th>Lama Kerja</th>
						<th>Kategori</th>
						<th>Nilai</th>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data_pengalaman_kerja">
				
					</tbody>
             
                    </table>
                </div>
            </div>
            </div>
			
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Kriteria Penilaian Sertifikasi (C3)</h5>
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
                    <table class="table table-striped table-bordered table-hover"  id="mydata_sertifikasi">
					<thead>
                    <tr>
						<th>Nomor</th>
						<th>Sertifikasi</th>
						<th>Kategori</th>
						<th>Nilai</th>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data_sertifikasi">
				
					</tbody>
             
                    </table>
                </div>
            </div>
            </div>
			
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Kriteria Penilaian Wawancara (C4)</h5>
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
                    <table class="table table-striped table-bordered table-hover"  id="mydata_wawancara">
					<thead>
                    <tr>
						<th>Nomor</th>
						<th>Hasil Wawancara</th>
						<th>Kategori</th>
						<th>Nilai</th>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data_wawancara">
				
					</tbody>
             
                    </table>
                </div>
            </div>
            </div>
			
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Kriteria Penilaian Ujian (C5)</h5>
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
                    <table class="table table-striped table-bordered table-hover"  id="mydata_ujian">
					<thead>
                    <tr>
						<th>Nomor</th>
						<th>Hasil Ujian</th>
						<th>Kategori</th>
						<th>Nilai</th>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data_ujian">
				
					</tbody>
             
                    </table>
                </div>
            </div>
            </div>
			
			<div class="alert alert-info">
				Sifat Kriteria Penilaian "Cost"
			</div>
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Kriteria Penilaian Usia (C6)</h5>
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
                    <table class="table table-striped table-bordered table-hover"  id="mydata_usia">
					<thead>
                    <tr>
						<th>Nomor</th>
						<th>Usia</th>
						<th>Kategori</th>
						<th>Nilai</th>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data_usia">
				
					</tbody>
             
                    </table>
                </div>
            </div>
            </div>
			
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Kriteria Penilaian Jenis Kelamin (C7)</h5>
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
                    <table class="table table-striped table-bordered table-hover"  id="mydata_jenis_kelamin">
					<thead>
                    <tr>
						<th>Nomor</th>
						<th>Jenis Kelamin</th>
						<th>Kategori</th>
						<th>Nilai</th>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data_jenis_kelamin">
				
					</tbody>
             
                    </table>
                </div>
            </div>
            </div>
			
			<div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Kriteria Penilaian Status Pernikahan (C8)</h5>
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
                    <table class="table table-striped table-bordered table-hover"  id="mydata_status_pernikahan">
					<thead>
                    <tr>
						<th>Nomor</th>
						<th>Status</th>
						<th>Kategori</th>
						<th>Nilai</th>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data_status_pernikahan">
				
					</tbody>
             
                    </table>
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
			
			$('#tanggal_akhir .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
			
			$('#tanggal_akhir_2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
			
			tampil_data_kriteria_penilaian_pendidikan();	//pemanggilan fungsi tampil data.
			tampil_data_kriteria_penilaian_pengalaman_kerja();	//pemanggilan fungsi tampil data.
			tampil_data_kriteria_penilaian_sertifikasi();	//pemanggilan fungsi tampil data.
			tampil_data_kriteria_penilaian_wawancara();	//pemanggilan fungsi tampil data.
			tampil_data_kriteria_penilaian_ujian();	//pemanggilan fungsi tampil data.
			tampil_data_kriteria_penilaian_usia();	//pemanggilan fungsi tampil data.
			tampil_data_kriteria_penilaian_jenis_kelamin();	//pemanggilan fungsi tampil data.
			tampil_data_kriteria_penilaian_status_pernikahan();	//pemanggilan fungsi tampil data.
			
			
			
			$('#mydata_pendidikan').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'kriteria_penilaian_pendidikan'},
                    {extend: 'csv', title: 'kriteria_penilaian_pendidikan'},
                    {extend: 'excel', title: 'kriteria_penilaian_pendidikan'},
                    {extend: 'pdf', title: 'kriteria_penilaian_pendidikan' },

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
			
			$('#mydata_pengalaman_kerja').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'kriteria_penilaian_pengalaman_kerja'},
                    {extend: 'csv', title: 'kriteria_penilaian_pengalaman_kerja'},
                    {extend: 'excel', title: 'kriteria_penilaian_pengalaman_kerja'},
                    {extend: 'pdf', title: 'kriteria_penilaian_pengalaman_kerja' },

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
			
			$('#mydata_sertifikasi').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'kriteria_penilaian_sertifikasi'},
                    {extend: 'csv', title: 'kriteria_penilaian_sertifikasi'},
                    {extend: 'excel', title: 'kriteria_penilaian_sertifikasi'},
                    {extend: 'pdf', title: 'kriteria_penilaian_sertifikasi' },

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
			
			$('#mydata_wawancara').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'kriteria_penilaian_wawancara'},
                    {extend: 'csv', title: 'kriteria_penilaian_wawancara'},
                    {extend: 'excel', title: 'kriteria_penilaian_wawancara'},
                    {extend: 'pdf', title: 'kriteria_penilaian_wawancara' },

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
			
			$('#mydata_ujian').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'kriteria_penilaian_ujian'},
                    {extend: 'csv', title: 'kriteria_penilaian_ujian'},
                    {extend: 'excel', title: 'kriteria_penilaian_ujian'},
                    {extend: 'pdf', title: 'kriteria_penilaian_ujian' },

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
			
			$('#mydata_usia').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'kriteria_penilaian_usia'},
                    {extend: 'csv', title: 'kriteria_penilaian_usia'},
                    {extend: 'excel', title: 'kriteria_penilaian_usia'},
                    {extend: 'pdf', title: 'kriteria_penilaian_usia' },

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
			
			$('#mydata_jenis_kelamin]').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'kriteria_penilaian_jenis_kelamin'},
                    {extend: 'csv', title: 'kriteria_penilaian_jenis_kelamin'},
                    {extend: 'excel', title: 'kriteria_penilaian_jenis_kelamin'},
                    {extend: 'pdf', title: 'kriteria_penilaian_jenis_kelamin' },

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
			
			$('#mydata_status_pernikahan').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'kriteria_penilaian_status_pernikahan'},
                    {extend: 'csv', title: 'kriteria_penilaian_status_pernikahan'},
                    {extend: 'excel', title: 'kriteria_penilaian_status_pernikahan'},
                    {extend: 'pdf', title: 'kriteria_penilaian_status_pernikahan' },

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
			

			//fungsi tampil data
			function tampil_data_kriteria_penilaian_pendidikan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/kriteria_penilaian/data_kriteria_penilaian_pendidikan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].JENJANG_PENDIDIKAN+'</td>'+
									'<td>'+data[i].KATEGORI+'</td>'+
									'<td>'+data[i].NILAI+'</td>'+
									'</tr>';
						}
						$('#show_data_pendidikan').html(html);
					}

				});
			}
			
			function tampil_data_kriteria_penilaian_pengalaman_kerja(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/kriteria_penilaian/data_kriteria_penilaian_pengalaman_kerja',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].PENGALAMAN_KERJA+'</td>'+
									'<td>'+data[i].KATEGORI+'</td>'+
									'<td>'+data[i].NILAI+'</td>'+
									'</tr>';
						}
						$('#show_data_pengalaman_kerja').html(html);
					}

				});
			}
			
			function tampil_data_kriteria_penilaian_sertifikasi(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/kriteria_penilaian/data_kriteria_penilaian_sertifikasi',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].SERTIFIKASI+'</td>'+
									'<td>'+data[i].KATEGORI+'</td>'+
									'<td>'+data[i].NILAI+'</td>'+
									'</tr>';
						}
						$('#show_data_sertifikasi').html(html);
					}

				});
			}
			
			function tampil_data_kriteria_penilaian_wawancara(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/kriteria_penilaian/data_kriteria_penilaian_wawancara',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].HASIL_WAWANCARA+'</td>'+
									'<td>'+data[i].KATEGORI+'</td>'+
									'<td>'+data[i].NILAI+'</td>'+
									'</tr>';
						}
						$('#show_data_wawancara').html(html);
					}

				});
			}
			
			function tampil_data_kriteria_penilaian_ujian(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/kriteria_penilaian/data_kriteria_penilaian_ujian',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].HASIL_UJIAN+'</td>'+
									'<td>'+data[i].KATEGORI+'</td>'+
									'<td>'+data[i].NILAI+'</td>'+
									'</tr>';
						}
						$('#show_data_ujian').html(html);
					}

				});
			}

			function tampil_data_kriteria_penilaian_usia(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/kriteria_penilaian/data_kriteria_penilaian_usia',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].USIA+'</td>'+
									'<td>'+data[i].KATEGORI+'</td>'+
									'<td>'+data[i].NILAI+'</td>'+
									'</tr>';
						}
						$('#show_data_usia').html(html);
					}

				});
			}
			
			function tampil_data_kriteria_penilaian_jenis_kelamin(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/kriteria_penilaian/data_kriteria_penilaian_jenis_kelamin',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].JENIS_KELAMIN+'</td>'+
									'<td>'+data[i].KATEGORI+'</td>'+
									'<td>'+data[i].NILAI+'</td>'+
									'</tr>';
						}
						$('#show_data_jenis_kelamin').html(html);
					}

				});
			}
			
			function tampil_data_kriteria_penilaian_status_pernikahan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/kriteria_penilaian/data_kriteria_penilaian_status_pernikahan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+(i+1)+'</td>'+
									'<td>'+data[i].STATUS+'</td>'+
									'<td>'+data[i].KATEGORI+'</td>'+
									'<td>'+data[i].NILAI+'</td>'+
									'</tr>';
						}
						$('#show_data_status_pernikahan').html(html);
					}

				});
			}
			

        });

    </script>

</body>

</html>