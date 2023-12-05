<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List Proyek</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url() ?>">Home</a>
			</li>
			<li class="active">
				<a href="<?php echo base_url('index.php/Proyek/') ?>">Proyek</a>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

	<div class="alert alert-danger alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Pastikan Anda mengisi data dengan benar.
	</div>

	<div class="alert alert-info alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Sistem menampilkan seluruh proyek.
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Proyek</h5>
				</div>
				<div class="ibox-content">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="mydata">
							<thead>
								<tr>
									<th style="width:5%">No.</th>
									<th>Nama Proyek</th>
									<th>Lokasi</th>
									<th>Inisial</th>
									<th>Status</th>
									<th style="width:5%">Pilihan</th>
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

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function() {

		tampil_list_proyek(); //pemanggilan fungsi tampil data.

		$('#mydata').dataTable({
			pageLength: 25,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
				{
					extend: 'excel',
					title: '<?php echo $title ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					},
				},
				{
					extend: 'print',
					orientation: 'landscape',
					pageSize: 'A3',
					customize: function(win) {
						$(win.document.body).addClass('white-bg');
						$(win.document.body).css('font-size', '10px');

						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					},
					exportOptions: {
						columns: [0, 1, 2, 3, 4]
					},
				}
			]

		});

		//fungsi tampil data
		function tampil_list_proyek() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/Proyek/list_proyek',
				async: false,
				dataType: 'json',
				success: function(data) {
					var nomor = 1;
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						if (data[i].STATUS_PROYEK == "Berjalan") {
							html_status = '<td> <span class="label label-primary block">' + data[i].STATUS_PROYEK + '</span></td>';
						}
						if (data[i].STATUS_PROYEK == "Selesai") {
							html_status = '<td> <span class="label label-danger block">' + data[i].STATUS_PROYEK + '</span></td>';
						}
						html += '<tr>' +
							'<td>' + nomor + '</td>' +
							'<td>' + data[i].NAMA_PROYEK + '</td>' +
							'<td>' + data[i].LOKASI + '</td>' +
							'<td>' + data[i].INISIAL + '</td>' +
							html_status +
							'<td>' +
							'<a href="<?php echo base_url() ?>Proyek/detil_proyek/' + data[i].HASH_MD5_PROYEK + '" class="btn btn-info btn-xs btn-outline block"><i class="fa fa-eye"></i> Lihat Data </a>' + ' ' +
							'</td>' +
							'</tr>';
						nomor = nomor + 1;
					}
					$('#show_data').html(html);
				}

			});
		}
	});
</script>

</body>

</html>