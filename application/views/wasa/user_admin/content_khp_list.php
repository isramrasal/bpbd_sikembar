<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List KHP</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Home</a>
			</li>
			<li class="active">
				<strong>
					<a>Data KHP</a>
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
					<h5>KHP</h5>
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
									<th>No. KHP</th>
									<th>No. SPPB</th>
									<th>Nama Proyek</th>
									<th>Nama Vendor</th>
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
		<p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br /> Hak cipta dilindungi undang-undang.</p>
	</div>
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
				<h4 class="modal-title">Proyek</h4>
				<small class="font-bold">Silakan edit data proyek</small>
			</div>
			<?php $attributes = array("id_proyek2" => "contact_form", "id" => "contact_form");
			echo form_open("proyek/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">ID Proyek</label>
						<div class="col-xs-9">
							<input name="ID_PROYEK2" id="ID_PROYEK2" class="form-control" type="text" placeholder="ID Proyek" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Proyek</label>
						<div class="col-xs-9">
							<input name="NAMA_PROYEK2" id="NAMA_PROYEK2" class="form-control" type="text" placeholder="Contoh : Cakung (1 x 1000MW) CFPP, Jakarta Timur." required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Lokasi</label>
						<div class="col-xs-9">
							<input name="LOKASI2" id="LOKASI2" class="form-control" type="text" placeholder="Contoh : Jalan Rawa Pendek, Kampung Sawah, Jakarta, 13281." required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Inisial</label>
						<div class="col-xs-9">
							<input name="INISIAL2" id="INISIAL2" class="form-control" type="text" placeholder="Contoh : JKT-488" required>
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

		tampil_data_khp(); //pemanggilan fungsi tampil data.

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
					title: 'Proyek'
				},
				{
					extend: 'pdf',
					title: 'Proyek'
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
		function tampil_data_khp() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>khp/data_khp',
				async: false,
				dataType: 'json',
				success: function(data) {
					console.log(data);
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<tr>' +
							'<td>' + data[i].NO_URUT_KHP + '</td>' +
							'<td>' + data[i].NO_URUT_SPPB + '</td>' +
							'<td>' + data[i].NAMA_PROYEK + '</td>' +
							'<td>' + data[i].NAMA_VENDOR + '</td>' +
							'<td>' +
							'<a href="<?php echo base_url() ?>khp_barang/index/' + data[i].ID_KHP + '" class="btn btn-info btn-xs"><i class="fa fa-plus-square"></i> Proses KHP  </a><br>' + ' ' +
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
						PEGAWAI_PM,
						PEGAWAI_SM,
						PEGAWAI_LOG,
						PEGAWAI_PROC
					) {
						$('#ModalaEdit').modal('show');
						$('[name="ID_PROYEK2"]').val(data.ID_PROYEK);
						$('[name="NAMA_PROYEK2"]').val(data.NAMA_PROYEK);
						$('[name="LOKASI2"]').val(data.LOKASI);
						$('[name="INISIAL2"]').val(data.INISIAL);
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
				NAMA_PROJECT_MANAGER: $('#NAMA_PROJECT_MANAGER').val(),
				NAMA_SITE_MANAGER: $('#NAMA_SITE_MANAGER').val(),
				NAMA_SPV_LOG: $('#NAMA_SPV_LOG').val(),
				NAMA_SPV_PROC: $('#NAMA_SPV_PROC').val(),
			};
			$.ajax({
				url: "<?php echo site_url('proyek/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data != '') {
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					} else {
						// <?php
							// $this->db->query("INSERT into rasd(ID_PROYEK) VALUES('" . $id_rasd . "','" . $value . "')");
							// 
							?>

						// $('[name="NAMA_PROYEK"]').val("");
						// $('[name="LOKASI"]').val("");
						// $('[name="INISIAL"]').val("");
						// $('[name="NAMA_PROJECT_MANAGER"]').val("");
						// $('[name="NAMA_SITE_MANAGER"]').val("");
						// $('[name="NAMA_SPV_LOG"]').val("");
						// $('[name="NAMA_SPV_PROC"]').val("");
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
					tampil_data_proyek();
					window.location.reload();
				}
			});
			return false;
		});

	});
</script>

</body>

</html>