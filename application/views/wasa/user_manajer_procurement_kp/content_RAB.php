<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List RASB</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/RAB/') ?>">RAB</a>
			</li>
			<li class="active">
				<strong>
					<a>List RAB</a>
				</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

	<div class="alert alert-info alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Sistem menampilkan seluruh RAB.
	</div>

	<div class="alert alert-success alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Anda dapat menambahkan RAB jika sebelumnya proyek dan sub pekerjaan telah didefinisikan.
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>RAB</h5>
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
						<table class="table table-striped table-bordered table-hover" id="mydata">
							<thead>
								<tr>
									<th>Nama Proyek</th>
									<th>Lokasi Proyek</th>
									<th>Status</th>
									<th>Nama Project Manager</th>
									<th>Nama Site Manager</th>
									<th>Pilihan</th>
								</tr>
							</thead>
							<tbody id="show_data">

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
		<p><strong>&copy; <?php echo date("Y"); ?> PT. Wasa Mitra Enginering</strong><br /> Hak cipta dilindungi undang-undang.</p>
	</div>
</div>

</div>


<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Jasny -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/jasny/jasny-bootstrap.min.js"></script>

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function() {

		tampil_data_RAB(); //pemanggilan fungsi tampil data.

		$('#mydata').dataTable({
			pageLength: 25,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'copy'
				},
				{
					extend: 'csv',
					title: 'RAB'
				},
				{
					extend: 'excel',
					title: 'RAB'
				},
				{
					extend: 'pdf',
					title: 'RAB'
				},
				{
					extend: 'print',
					customize: function(win) {
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
		function tampil_data_RAB() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>RAB/data_RAB',
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var html_status = '';
					var i;
					var data_1 = data;
					for (i = 0; i < data.length; i++) {
						$.ajax({
							url: "<?php echo site_url('RAB/get_list_rab_by_id_proyek') ?>",
							type: "POST",
							dataType: "JSON",
							async: false,
							data: {
								ID_PROYEK: data_1[i].ID_PROYEK,
							},
							success: function(data) {
								var data_2 = data;
								var RAB = '';

								console.log(data_2);

								if (data_1[i].STATUS_PROYEK == "Berjalan") {
									html_status = '<td> <span class="label label-primary block">' + data_1[i].STATUS_PROYEK + '</span></td>';
								}
								if (data_1[i].STATUS_PROYEK == "Selesai") {
									html_status = '<td> <span class="label label-danger block">' + data_1[i].STATUS_PROYEK + '</span></td>';
								}

								html += '<tr>' +
									'<td>' + '<a href="<?php echo base_url() ?>Proyek/detil_proyek/' + data_1[i].HASH_MD5_PROYEK + '" class="btn btn-primary btn-xs btn-outline block"> ' + data_1[i].NAMA_PROYEK+' </a>' + '</td>' +
									'<td>' + data_1[i].LOKASI + '</td>' +
									html_status +
									'<td>' + data_1[i].PEGAWAI_PM + '</td>' +
									'<td>' + data_1[i].PEGAWAI_SM + '</td>' +
									'<td>' ;

								if (data_2 == 'TIDAK ADA DATA') {
									RAB = '';

								} else {
									for (j = 0; j < data_2.length; j++) {
										var html_progress = '';
										html_progress = '<a href="<?php echo base_url() ?>rab_form/index/' + data_2[j].HASH_MD5_RAB + '" class="btn btn-warning btn-xs block"><i class="fa fa-pencil"></i> Ubah RAB '+ data_2[j].NAMA_SUB_PEKERJAAN+' </a>' + ' ';
										html += html_progress;
									}

								}

								html +=
									'</td>';
							}
						});
					}
					$('#show_data').html(html);
				}

			});
		}
	});
</script>

</body>

</html>