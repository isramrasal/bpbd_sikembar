<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List Proyek</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li >
					<a href="<?php echo base_url('index.php/proyek/') ?>">Proyek</a>	
			</li>
			<li class="active">
				<strong>
					<a>List Proyek</a>
				</strong>
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
								<th style="width:5%">No.</th>
									<th>Nama Proyek</th>
									<th>Lokasi</th>
									<th>Inisial</th>
									<th>Status</th>
									<th  style="width:5%">Pilihan</th>
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
</div>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Proyek</h4>
				<small class="font-bold">Silakan tambah data proyek</small>
			</div>
			<?php $attributes = array("nama_proyek" => "contact_form", "id" => "contact_form");
			echo form_open("proyek/simpan_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Proyek</label>
						<div class="col-xs-9">
							<input name="NAMA_PROYEK" id="NAMA_PROYEK" class="form-control" type="text" placeholder="Contoh : Surabaya (1 x 1000MW) CFPP, Jawa Timur." required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Lokasi</label>
						<div class="col-xs-9">
							<input name="LOKASI" id="LOKASI" class="form-control" type="text" placeholder="Contoh : Jalan Rawa Surabaya, Kampung Sawah, Surabaya, 13281." required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Inisial</label>
						<div class="col-xs-9">
							<input name="INISIAL" id="INISIAL" class="form-control" type="text" placeholder="Contoh : SRB-1" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Status</label>
						<div class="col-xs-9">
							<select name="STATUS_PROYEK" class="form-control" id="STATUS_PROYEK">
								<option value=''>- Pilih Status Proyek -</option>
								<option value='Selesai'> Selesai</option>
								<option value='Berjalan'> Berjalan</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Poject Manager</label>
						<div class="col-xs-9">
							<select name="NAMA_PROJECT_MANAGER" class="form-control" id="NAMA_PROJECT_MANAGER">
								<option value=''>- Pilih Pegawai -</option>
								<?php foreach ($pegawai as $prov) {
									echo '<option value="' . $prov->ID_PEGAWAI . '">' . $prov->NAMA . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Site Manager</label>
						<div class="col-xs-9">
							<select name="NAMA_SITE_MANAGER" class="form-control" id="NAMA_SITE_MANAGER">
								<option value=''>- Pilih Pegawai -</option>
								<?php foreach ($pegawai as $prov) {
									echo '<option value="' . $prov->ID_PEGAWAI . '">' . $prov->NAMA . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Supervisor Logistik</label>
						<div class="col-xs-9">
							<select name="NAMA_SPV_LOG" class="form-control" id="NAMA_SPV_LOG">
								<option value=''>- Pilih Pegawai -</option>
								<?php foreach ($pegawai as $prov) {
									echo '<option value="' . $prov->ID_PEGAWAI . '">' . $prov->NAMA . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Supervisor Procurement</label>
						<div class="col-xs-9">
							<select name="NAMA_SPV_PROC" class="form-control" id="NAMA_SPV_PROC">
								<option value=''>- Pilih Pegawai -</option>
								<?php foreach ($pegawai as $prov) {
									echo '<option value="' . $prov->ID_PEGAWAI . '">' . $prov->NAMA . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="alert alert-info alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Upload file dokumen dilakukan di halaman profil proyek.
					</div>

					<div id="alert-msg"></div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END MODAL ADD-->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Proyek</h4>
				<small class="font-bold">Silakan edit data proyek</small>
			</div>
			<?php $attributes = array("id_proyek2" => "contact_form", "id" => "contact_form");
			echo form_open("proyek/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<input name="ID_PROYEK2" id="ID_PROYEK2" class="form-control" type="hidden" placeholder="ID Proyek" readonly>
					
					<div class="form-group">
						<label class="control-label col-xs-3">Nama Proyek</label>
						<div class="col-xs-9">
							<input name="NAMA_PROYEK2" id="NAMA_PROYEK2" class="form-control" type="text" placeholder="Contoh : Surabaya (1 x 1000MW) CFPP, Jawa Timur." required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Lokasi</label>
						<div class="col-xs-9">
							<input name="LOKASI2" id="LOKASI2" class="form-control" type="text" placeholder="Contoh : Jalan Rawa Surabaya, Kampung Sawah, Surabaya, 13281." required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Inisial</label>
						<div class="col-xs-9">
							<input name="INISIAL2" id="INISIAL2" class="form-control" type="text" placeholder="Contoh : SRB-1" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Status</label>
						<div class="col-xs-9">
							<select name="STATUS_PROYEK2" class="form-control" id="STATUS_PROYEK2">
								<option value=''>- Pilih Status Proyek -</option>
								<option value='Selesai'> Selesai</option>
								<option value='Berjalan'> Berjalan</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Poject Manager</label>
						<div class="col-xs-9">
							<select name="NAMA_PROJECT_MANAGER2" class="form-control" id="NAMA_PROJECT_MANAGER2">
								<option value=''>- Pilih Pegawai -</option>
								<?php foreach ($pegawai as $prov) {
									echo '<option value="' . $prov->ID_PEGAWAI . '">' . $prov->NAMA . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Site Manager</label>
						<div class="col-xs-9">
							<select name="NAMA_SITE_MANAGER2" class="form-control" id="NAMA_SITE_MANAGER2">
								<option value=''>- Pilih Pegawai -</option>
								<?php foreach ($pegawai as $prov) {
									echo '<option value="' . $prov->ID_PEGAWAI . '">' . $prov->NAMA . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Supervisor Logistik</label>
						<div class="col-xs-9">
							<select name="NAMA_SPV_LOG2" class="form-control" id="NAMA_SPV_LOG2">
								<option value=''>- Pilih Pegawai -</option>
								<?php foreach ($pegawai as $prov) {
									echo '<option value="' . $prov->ID_PEGAWAI . '">' . $prov->NAMA . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Supervisor Procurement</label>
						<div class="col-xs-9">
							<select name="NAMA_SPV_PROC2" class="form-control" id="NAMA_SPV_PROC2">
								<option value=''>- Pilih Pegawai -</option>
								<?php foreach ($pegawai as $prov) {
									echo '<option value="' . $prov->ID_PEGAWAI . '">' . $prov->NAMA . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="alert alert-info alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Upload file dokumen dilakukan di halaman profil proyek.
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
				<h4 class="modal-title" id="myModalLabel">Hapus Data Proyek</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" name="kode" id="textkode" value="">
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini?</p>
						<div name="NAMA_PROYEK3" id="NAMA_PROYEK3"></div>
					</div>

					<div class="alert alert-danger alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Seluruh file dokumen proyek dan RASD proyek juga akan dihapus oleh sistem!
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

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function() {

		$('#ModalaAdd').on('shown.bs.modal', function() {
			$('#nama_proyek').focus();
		});

		tampil_list_proyek(); //pemanggilan fungsi tampil data.

		$('#mydata').dataTable({
			pageLength: 25,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'copy'
				},
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
					},
				},
				{
					extend: 'excel',
					title: 'Proyek',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
					},
				},
				{
					extend:'pdfHtml5',
					title: 'Proyek',
					orientation:'landscape',
					pageSize: 'A3',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
					},
					customize: function (doc) {
						doc.content[1].table.widths = 
							Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					}
				},

				{
					extend: 'print',
					orientation:'landscape',
					pageSize: 'A3',
					customize: function(win) {
						$(win.document.body).addClass('white-bg');
						$(win.document.body).css('font-size', '10px');

						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					},
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
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
							'<a href="<?php echo base_url() ?>Proyek/detil_proyek/' + data[i].HASH_MD5_PROYEK + '" class="btn btn-warning btn-xs btn-outline block"><i class="fa fa-eye"></i> Lihat Data </a>' + ' ' +
							// '<a href="javascript:;" class="btn btn-info btn-xs item_edit block" data="' + data[i].ID_PROYEK + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
							// '<a href="<?php echo base_url() ?>proyek_detil/index/' + data[i].HASH_MD5_PROYEK + '" class="btn btn-warning btn-xs btn-outline block"><i class="fa fa-eye"></i> Detil Proyek </a>' + ' ' +
							// '<a href="<?php echo base_url() ?>Proyek/organisasi_proyek/' + data[i].HASH_MD5_PROYEK + '" class="btn btn-success btn-xs item_edit_organisasi block"><i class="fa fa-users"></i> Atur Organisasi </a>' + ' ' +
							// '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_PROYEK + '"><i class="fa fa-trash"></i> Hapus</a>' +
							'</td>' +
							'</tr>';
						nomor = nomor + 1;
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
				url: "<?php echo base_url('index.php/proyek/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(
						NAMA_PROYEK,
						LOKASI,
						INISIAL,
						STATUS_PROYEK,
						PEGAWAI_PM,
						PEGAWAI_SM,
						PEGAWAI_LOG,
						PEGAWAI_PROC,
						
					) {
						$('#ModalaEdit').modal('show');
						$('[name="ID_PROYEK2"]').val(data.ID_PROYEK);
						$('[name="NAMA_PROYEK2"]').val(data.NAMA_PROYEK);
						$('[name="LOKASI2"]').val(data.LOKASI);
						$('[name="INISIAL2"]').val(data.INISIAL);
						$('[name="STATUS_PROYEK2"]').val(data.STATUS_PROYEK);
						$('[name="NAMA_PROJECT_MANAGER2"]').val(data.PEGAWAI_PM);
						$('[name="NAMA_SITE_MANAGER2"]').val(data.PEGAWAI_SM);
						$('[name="NAMA_SPV_LOG2"]').val(data.PEGAWAI_LOG);
						$('[name="NAMA_SPV_PROC2"]').val(data.PEGAWAI_PROC);
						$('#alert-msg-2').html('<div></div>');
					});
				}
			});
			return false;
		});

		//GET HAPUS
		$('#show_data').on('click', '.item_hapus', function() {
			var id = $(this).attr('data');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('index.php/proyek/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_PROYEK, NAMA_PROYEK) {
						$('#ModalHapus').modal('show');
						$('[name="kode"]').val(id);
						$('#NAMA_PROYEK3').html('Nama Proyek: ' + data.NAMA_PROYEK);
					});
				}
			});
		});

		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				NAMA_PROYEK: $('#NAMA_PROYEK').val(),
				LOKASI: $('#LOKASI').val(),
				INISIAL: $('#INISIAL').val(),
				STATUS_PROYEK: $('#STATUS_PROYEK').val(),
				NAMA_PROJECT_MANAGER: $('#NAMA_PROJECT_MANAGER').val(),
				NAMA_SITE_MANAGER: $('#NAMA_SITE_MANAGER').val(),
				NAMA_SPV_LOG: $('#NAMA_SPV_LOG').val(),
				NAMA_SPV_PROC: $('#NAMA_SPV_PROC').val()
				
			};
			$.ajax({
				url: "<?php echo site_url('proyek/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data != '') {
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					} else {
						$('[name="NAMA_PROYEK"]').val("");
						$('[name="LOKASI"]').val("");
						$('[name="INISIAL"]').val("");
						$('[name="NAMA_PROJECT_MANAGER"]').val("");
						$('[name="NAMA_SITE_MANAGER"]').val("");
						$('[name="NAMA_SPV_LOG"]').val("");
						$('[name="NAMA_SPV_PROC"]').val("");
						$('[name="STATUS_PROYEK"]').val("");
						$('#ModalaAdd').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});

		//UPDATE DATA 
		$('#btn_update').on('click', function() {

			var ID_PROYEK2 = $('#ID_PROYEK2').val();
			var NAMA_PROYEK2 = $('#NAMA_PROYEK2').val();
			var LOKASI2 = $('#LOKASI2').val();
			var INISIAL2 = $('#INISIAL2').val();
			var STATUS_PROYEK2 = $('#STATUS_PROYEK2').val();
			var NAMA_PROJECT_MANAGER2 = $('#NAMA_PROJECT_MANAGER2').val();
			var NAMA_SITE_MANAGER2 = $('#NAMA_SITE_MANAGER2').val();
			var NAMA_SPV_LOG2 = $('#NAMA_SPV_LOG2').val();
			var NAMA_SPV_PROC2 = $('#NAMA_SPV_PROC2').val();


			$.ajax({
				url: "<?php echo site_url('proyek/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_PROYEK2: ID_PROYEK2,
					NAMA_PROYEK2: NAMA_PROYEK2,
					LOKASI2: LOKASI2,
					INISIAL2: INISIAL2,
					STATUS_PROYEK2: STATUS_PROYEK2,
					NAMA_PROJECT_MANAGER2: NAMA_PROJECT_MANAGER2,
					NAMA_SITE_MANAGER2: NAMA_SITE_MANAGER2,
					NAMA_SPV_LOG2: NAMA_SPV_LOG2,
					NAMA_SPV_PROC2: NAMA_SPV_PROC2
				},
				success: function(data) {
					if (data == true) {
						$('#ModalaEdit').modal('hide');
						$('[name="ID_PROYEK2"]').val("");
						$('[name="NAMA_PROYEK2"]').val("");
						$('[name="LOKASI2"]').val("");
						$('[name="INISIAL2"]').val("");
						$('[name="STATUS_PROYEK2"]').val("");
						$('[name="NAMA_PROJECT_MANAGER2"]').val("");
						$('[name="NAMA_SITE_MANAGER2"]').val("");
						$('[name="NAMA_SPV_LOG2"]').val("");
						$('[name="NAMA_SPV_PROC2"]').val("");

						window.location.reload();
					} else {
						$('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
					}
				}
			});
			return false;
		});

		//HAPUS DATA
		$('#btn_hapus').on('click', function() {
			var kode = $('#textkode').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('index.php/proyek/hapus_data') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapus').modal('hide');
					tampil_list_proyek();
					window.location.reload();
				}
			});
			return false;
		});

	});
</script>

</body>

</html>