<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List Gudang</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/gudang/') ?>">Gudang</a>
			</li>
			<li class="active">
				<strong>
					<a>List Gudang</a>
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
		Sistem menampilkan seluruh gudang.
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Gudang</h5>
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
									<th>Nama Gudang</th>
									<th>Lokasi Gudang</th>
									<th>Nama Pegawai Departemen Logistik</th>
									<th>Pilihan</th>
								</tr>
							</thead>
							<tbody id="show_data">

							</tbody>

						</table>
					</div>
					<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Tambah Data</a>
				</div>

			</div>
		</div>
	</div>
</div>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Gudang</h4>
				<small class="font-bold">Silakan tambah data gudang</small>
			</div>
			<?php $attributes = array("name" => "contact_form", "id" => "contact_form");
			echo form_open("gudang/simpan_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Proyek</label>
						<div class="col-xs-9">
							<select name="ID_PROYEK" class="form-control" id="ID_PROYEK">
								<option value=''>- Pilih Proyek -</option>
								<?php foreach ($proyek as $prov) {
									echo '<option value="' . $prov->ID_PROYEK  . '">' . $prov->NAMA_PROYEK . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Pegawai Departemen Logistik</label>
						<div class="col-xs-9">
							<select name="ID_PEGAWAI_LOG_GUDANG" class="form-control" id="ID_PEGAWAI_LOG_GUDANG">
								<option value=''>- Pilih Pegawai -</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Gudang</label>
						<div class="col-xs-9">
							<input name="NAMA_GUDANG" id="NAMA_GUDANG" class="form-control" type="text" placeholder="Contoh : Gudang Electrical" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Lokasi Gudang</label>
						<div class="col-xs-9">
							<input name="LOKASI_GUDANG" id="LOKASI_GUDANG" class="form-control" type="text" placeholder="Contoh : Sebelah container office site WME" required>
						</div>
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
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Gudang</h4>
				<small class="font-bold">Silakan edit data gudang</small>
			</div>
			<?php $attributes = array("ID_GUDANG_2" => "contact_form", "id" => "contact_form");
			echo form_open("gudang/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<input name="ID_GUDANG_2" id="ID_GUDANG_2" class="form-control" type="hidden" placeholder="ID Gudang" readonly>

					<input name="ID_PROYEK_2" id="ID_PROYEK_2" class="form-control" type="hidden" placeholder="ID Proyek" readonly>


					<div class="form-group">
						<label class="control-label col-xs-3">Nama Proyek</label>
						<div class="col-xs-9">
							<input name="NAMA_PROYEK_2" id="NAMA_PROYEK_2" class="form-control" type="text" placeholder="ID Gudang" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Lokasi Proyek</label>
						<div class="col-xs-9">
							<textarea style="width:100%" name="LOKASI_2" id="LOKASI_2" class="form-control" type="text" placeholder="Contoh : Sebelah container WASA" readonly></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Pegawai Departemen Logistik</label>
						<div class="col-xs-9">
							<select name="ID_PEGAWAI_LOG_GUDANG_2" class="form-control" id="ID_PEGAWAI_LOG_GUDANG_2">
								<option value=''>- Pilih Pegawai -</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Gudang</label>
						<div class="col-xs-9">
							<input name="NAMA_GUDANG_2" id="NAMA_GUDANG_2" class="form-control" type="text" placeholder="Contoh : Gudang Electrical" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Lokasi Gudang</label>
						<div class="col-xs-9">
							<input name="LOKASI_GUDANG_2" id="LOKASI_GUDANG_2" class="form-control" type="text" placeholder="Contoh : Sebelah container WASA" required>
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
				<h4 class="modal-title" id="myModalLabel">Hapus Data Gudang</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" name="kode" id="textkode" value="">
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini?</p>
						<div name="NAMA_GUDANG3" id="NAMA_GUDANG3"></div>
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

		// Dropdown ID PROYEK_2 berubah
		$('#ModalEdit').on('show.bs.modal', function() {
			var proyek = $('#ID_PROYEK_2').val();

			// Menggunakan ajax untuk mengirim dan dan menerima data dari server
			$.ajax({
				url: "<?php echo base_url(); ?>/Gudang/get_pegawai_proyek",
				method: "POST",
				data: {
					proyek: proyek
				},
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;

					for (i = 0; i < data.length; i++) {
						html += '<option value=' + data[i].ID_PEGAWAI + '>' + data[i].NAMA + '</option>';
					}
					$('#ID_PEGAWAI_LOG_GUDANG_2').html(html);

				}
			});
		});

		// Dropdown ID PROYEK berubah
		$('#ID_PROYEK').change(function() {
			var proyek = $('#ID_PROYEK').val();

			// Menggunakan ajax untuk mengirim dan dan menerima data dari server
			$.ajax({
				url: "<?php echo base_url(); ?>/Gudang/get_pegawai_proyek",
				method: "POST",
				data: {
					proyek: proyek
				},
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;

					console.log(data);

					for (i = 0; i < data.length; i++) {
						html += '<option value=' + data[i].ID_PEGAWAI + '>' + data[i].NAMA + '</option>';
					}
					$('#ID_PEGAWAI_LOG_GUDANG').html(html);

				}
			});
		});

		$('#ModalAdd').on('shown.bs.modal', function() {
			$('#nama_gudang').focus();
		});

		tampil_data_gudang(); //pemanggilan fungsi tampil data.

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
					title: 'Gudang'
				},
				{
					extend: 'pdf',
					title: 'Gudang'
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
		function tampil_data_gudang() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/gudang/data_gudang',
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<tr>' +
							'<td>' + data[i].NAMA_PROYEK + '</td>' +
							'<td>' + data[i].NAMA_GUDANG + '</td>' +
							'<td>' + data[i].LOKASI_GUDANG + '</td>' +
							'<td>' + data[i].PEGAWAI_LOG_GUDANG + '</td>' +
							'<td>' +
							'<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_GUDANG + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
							'<a href="javascript:;" class="btn btn-info btn-xs item_tambah block" data="' + data[i].ID_GUDANG + '"><i class="fa fa-plus"></i> Tambah Barang </a>' + ' ' +
							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_GUDANG + '"><i class="fa fa-trash"></i> Hapus</a>' +
						'<a href="<?php echo base_url() ?>Gudang_barang/index/' + data[i].HASH_MD5_GUDANG + '" class="btn btn-primary btn-xs btn-outline block"><i class="fa fa-eye"></i> Lihat Stok</a>'+
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
				url: "<?php echo base_url('index.php/gudang/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(
						ID_GUDANG,
						ID_PROYEK,
						NAMA_PROYEK,
						LOKASI,
						PEGAWAI_LOG_GUDANG,
						NAMA_GUDANG,
						LOKASI_GUDANG
					) {
						$('#ModalEdit').modal('show');
						$('[name="ID_GUDANG_2"]').val(data.ID_GUDANG);
						$('[name="ID_PROYEK_2"]').val(data.ID_PROYEK);
						$('[name="NAMA_PROYEK_2"]').val(data.NAMA_PROYEK);
						$('[name="LOKASI_2"]').val(data.LOKASI);
						$('[name="NAMA_GUDANG_2"]').val(data.NAMA_GUDANG);
						$('[name="LOKASI_GUDANG_2"]').val(data.LOKASI_GUDANG);
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
				url: "<?php echo base_url('index.php/gudang/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_GUDANG, NAMA_GUDANG) {
						$('#ModalHapus').modal('show');
						$('[name="kode"]').val(id);
						$('#NAMA_GUDANG3').html('Nama Gudang: ' + data.NAMA_GUDANG);
					});
				}
			});
		});

		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				ID_PROYEK: $('#ID_PROYEK').val(),
				ID_PEGAWAI_LOG_GUDANG: $('#ID_PEGAWAI_LOG_GUDANG').val(),
				NAMA_GUDANG: $('#NAMA_GUDANG').val(),
				LOKASI_GUDANG: $('#LOKASI_GUDANG').val(),
			};
			$.ajax({
				url: "<?php echo site_url('gudang/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data != '') {
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					} else {
						$('[name="NAMA_PROYEK"]').val("");
						$('[name="PEGAWAI_LOG_GUDANG"]').val("");
						$('[name="NAMA_GUDANG"]').val("");
						$('[name="LOKASI_GUDANG"]').val("");
						$('#ModalAdd').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});

		//UPDATE DATA 
		$('#btn_update').on('click', function() {

			var ID_GUDANG_2 = $('#ID_GUDANG_2').val();
			var ID_PEGAWAI_LOG_GUDANG_2 = $('#ID_PEGAWAI_LOG_GUDANG_2').val();
			var NAMA_GUDANG_2 = $('#NAMA_GUDANG_2').val();
			var LOKASI_GUDANG_2 = $('#LOKASI_GUDANG_2').val();

			$.ajax({
				url: "<?php echo site_url('gudang/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_GUDANG_2: ID_GUDANG_2,
					ID_PEGAWAI_LOG_GUDANG_2: ID_PEGAWAI_LOG_GUDANG_2,
					NAMA_GUDANG_2: NAMA_GUDANG_2,
					LOKASI_GUDANG_2: LOKASI_GUDANG_2
				},
				success: function(data) {
					if (data == true) {
						$('#ModalEdit').modal('hide');
						$('[name="ID_PROYEK_2"]').val("");
						$('[name="ID_GUDANG_2"]').val("");
						$('[name="NAMA_PROYEK_2"]').val("");
						$('[name="LOKASI_2"]').val("");
						$('[name="ID_PEGAWAI_LOG_GUDANG_2"]').val("");
						$('[name="NAMA_GUDANG_2"]').val("");
						$('[name="LOKASI_GUDANG_2"]').val("");

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
				url: "<?php echo base_url('index.php/gudang/hapus_data') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapus').modal('hide');
					tampil_data_gudang();
					window.location.reload();
				}
			});
			return false;
		});

	});
</script>


</body>

</html>