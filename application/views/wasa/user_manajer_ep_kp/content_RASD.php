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
		Sistem menampilkan seluruh RASD.
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
</br>

<div class="footer">
	<div>
		<p><strong>&copy; <?php  echo date("Y"); ?> PT. Wasa Mitra Enginering</strong><br /> Hak cipta dilindungi undang-undang.</p>
	</div>
</div>

</div>

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">RASD</h4>
				<small class="font-bold">Silakan edit Dokumen RASD</small>
			</div>
			<?php $attributes = array("id_RASD2" => "contact_form", "id" => "contact_form");
			echo form_open("RASD/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">ID RASD</label>
						<div class="col-xs-9">
							<input name="ID_RASD2" id="ID_RASD2" class="form-control" type="text" placeholder="ID RASD.." readonly>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-3">Nama Proyek</label>
						<div class="col-xs-9">
							<input name="NAMA_PROYEK2" id="NAMA_PROYEK2" class="form-control" type="text" placeholder="Nama Proyek.." readonly>
						</div>
					</div>
					<div class="form-group"><label class="control-label col-xs-3">Dokumen RASD</label>
						<div class="col-xs-9">
							<!-- <img id="imageResult" src="#" alt="" style="width: 20vw;"> -->
							<div class="fileinput fileinput-new" data-provides="fileinput">
								<!-- <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="..."></span> -->
								<!-- <span class="btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="..."></span> -->
								<label class="btn btn-default btn-file">
									<input id="DOK_RASD" type="file" onchange="readURL(this);" name="DOK_RASD"><span class="fileinput-new">Change file</span><span class="fileinput-exists">Change</span>
								</label>
								<span class="fileinput-filename"></span>
								<a href="#" class="close fileinput-exists" data-dismiss="fileinput" style="float: none">&times;</a>
							</div>
							<br>
							<a href="javascript:;" class="btn-xs "><i class="fa fa-download"></i> Download Dokumen RASD </a>
						</div>
					</div>

					<div id="alert-msg-2"></div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Update</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END MODAL EDIT-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
				<h4 class="modal-title" id="myModalLabel">Hapus Data RASD</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" name="kode" id="textkode" value="">
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini?</p>
						<div name="NAMA_PROYEK3" id="NAMA_PROYEK3"></div>
					</div>

				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn_hapus btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--END MODAL HAPUS-->



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

		$('#ModalaAdd').on('shown.bs.modal', function() {
			$('#nama_RASD').focus();
		});

		tampil_data_RASD(); //pemanggilan fungsi tampil data.

		$('#mydata').dataTable({
			pageLength: 25,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'copy'
				},
				{
					extend: 'csv'
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
							'<a href="<?php echo base_url() ?>proyek/profil_proyek/' + data[i].HASH_MD5_PROYEK + '" class="btn btn-warning btn-xs btn-outline block"><i class="fa fa-eye"></i> Lihat Profil Proyek </a>' + ' ' +
							'<a href="<?php echo base_url() ?>rasd_form/index/' + data[i].HASH_MD5_RASD + '" class="btn btn-info btn-xs block"><i class="fa fa-pencil"></i> Edit RASD </a>' + ' ' +
							// '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="' + data[i].ID_RASD + '"><i class="fa fa-trash"></i> Hapus </a>' + ' ' +
							'</td>' +
							'</tr>';
					}
					$('#show_data').html(html);
				}

			});
		}

		//GET UPDATE
		$('#show_data').on('click', '.item_edit', function() {
			var id = $(this).attr('data');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('index.php/RASD/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					console.log(data);
					$.each(data, function(
						ID_RASD,
						ID_PROYEK,
						NAMA_PROYEK
					) {
						$('#ModalaEdit').modal('show');
						$('[name="ID_RASD2"]').val(data.ID_RASD);
						$('[name="NAMA_PROYEK2"]').val(data.NAMA_PROYEK);
						$('#alert-msg-2').html('<div></div>');
					});
				}
			});
			return false;
		});


		//UPDATE DATA 
		$('#btn_update').on('click', function() {

			var ID_RASD2 = $('#ID_RASD2').val();
			var DOK_RASD2 = $('#DOK_RASD2').val();


			$.ajax({
				url: "<?php echo site_url('RASD/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_RASD2: ID_RASD2,
					DOK_RASD2: DOK_RASD2
				},
				success: function(data) {
					if (data == true) {
						$('#ModalaEdit').modal('hide');
						$('[name="ID_RASD2"]').val("");
						$('[name="ID_PROYEK2"]').val("");
						$('[name="DOK_RASD2"]').val("");
						window.location.reload();
					} else {
						$('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
					}
				}
			});
			return false;
		});

	});
</script>

</body>

</html>