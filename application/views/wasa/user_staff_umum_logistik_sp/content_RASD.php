<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List RASD</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li >
					<a href="<?php echo base_url('index.php/RASD/') ?>">RASD</a>	
			</li>
			<li class="active">
				<strong>
					<a>List RASD</a>
				</strong>
			</li>
		</ol>
	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

	<div class="alert alert-info alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Sistem Menampilkan RASD Pada Proyek <?php echo ($NAMA_PROYEK); ?>.
	</div>

	<div class="alert alert-success alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Anda dapat menambahkan RASD jika sebelumnya proyek telah didefinisikan.
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>RASD</h5>
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
					<!-- <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalaAdd"><span class="fa fa-plus"></span> Tambah Data</a> -->
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

<!-- Jasny -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/jasny/jasny-bootstrap.min.js"></script>

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function() {

		tampil_data_RASD(); //pemanggilan fungsi tampil data.

		$('#mydata').dataTable({
			pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'copy'
				},
				{
					extend: 'csv',
					title: 'RASD'
				},
				{
					extend: 'excel',
					title: 'RASD'
				},
				{
					extend: 'pdf',
					title: 'RASD'
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
		function tampil_data_RASD() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>RASD/data_RASD',
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						if (data[i].STATUS_PROYEK=="Berjalan")
						{
							html_status = '<td> <span class="label label-primary block">' + data[i].STATUS_PROYEK + '</span></td>';
						}
						if (data[i].STATUS_PROYEK=="Selesai")
						{
							html_status = '<td> <span class="label label-danger block">' + data[i].STATUS_PROYEK + '</span></td>';
						}

						html += '<tr>' +
							'<td>' + data[i].NAMA_PROYEK + '</td>' +
							'<td>' + data[i].LOKASI + '</td>' +
							html_status +
							'<td>' + data[i].PEGAWAI_PM + '</td>' +
							'<td>' + data[i].PEGAWAI_SM + '</td>' +

							'<td>' +
							'<a href="<?php echo base_url() ?>Proyek/detil_proyek/' + data[i].HASH_MD5_PROYEK + '" class="btn btn-primary btn-xs btn-outline block"><i class="fa fa-eye"></i> Lihat Profil Proyek </a>' + ' ' +
							'<a href="<?php echo base_url() ?>rasd_form/index/' + data[i].HASH_MD5_RASD + '" class="btn btn-warning btn-xs block"><i class="fa fa-pencil"></i> Ubah RASD </a>' + ' ' +
							// '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="' + data[i].ID_RASD + '"><i class="fa fa-trash"></i> Hapus </a>' + ' ' +
							'</td>' +
							'</tr>';
					}
					$('#show_data').html(html);
				}

			});
		}
	});
</script>

</body>

</html>