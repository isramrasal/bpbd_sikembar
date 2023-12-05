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
									<th>Nama Pegawai Departemen Logistik</th>
									<th>Nama Gudang</th>
									<th>Lokasi Gudang</th>
									<th>Pilihan</th>
								</tr>
							</thead>
							<tbody id="show_data">

							</tbody>

						</table>
					</div>
					<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalaAdd"><span class="fa fa-plus"></span> Tambah Data</a>
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

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
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
						<label class="control-label col-xs-3">Nama Proyek</label>
						<div class="col-xs-9">
							<select name="NAMA_PROYEK" class="form-control" id="NAMA_PROYEK">
								<option value=''>- Pilih Proyek -</option>
								<?php foreach ($proyek as $prov_proyek) {
									echo '<option value="' . $prov_proyek->ID_PROYEK . '">' . $prov_proyek->NAMA_PROYEK . ' - ' . $prov_proyek->LOKASI . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Pegawai Departemen Logistik</label>
						<div class="col-xs-9">
							<select name="PEGAWAI_LOG_GUDANG" class="form-control" id="PEGAWAI_LOG_GUDANG">
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
							<input name="LOKASI_GUDANG" id="LOKASI_GUDANG" class="form-control" type="text" placeholder="Contoh : Sebelah container WASA" required>
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
<div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Gudang</h4>
				<small class="font-bold">Silakan edit data gudang</small>
			</div>
			<?php $attributes = array("id_gudang2" => "contact_form", "id" => "contact_form");
			echo form_open("gudang/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<input name="ID_GUDANG2" id="ID_GUDANG2" class="form-control" type="hidden" placeholder="ID Gudang" readonly>

					<input name="ID_PROYEK2" id="ID_PROYEK2" class="form-control" type="hidden" placeholder="ID Proyek" readonly>


					<div class="form-group">
						<label class="control-label col-xs-3">Nama Proyek</label>
						<div class="col-xs-9">
							<input name="NAMA_PROYEK2" id="NAMA_PROYEK2" class="form-control" type="text" placeholder="ID Gudang" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Lokasi Proyek</label>
						<div class="col-xs-9">
							<textarea style="width:100%" name="LOKASI2" id="LOKASI2" class="form-control" type="text" placeholder="Contoh : Sebelah container WASA" readonly></textarea>
						</div>
					</div>

					<input name="PEGAWAI_LOG_GUDANG2_A" id="PEGAWAI_LOG_GUDANG2_A" class="form-control" type="hidden">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Pegawai Departemen Logistik</label>
						<div class="col-xs-9">
							<select name="PEGAWAI_LOG_GUDANG2" class="form-control" id="PEGAWAI_LOG_GUDANG2">
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Gudang</label>
						<div class="col-xs-9">
							<input name="NAMA_GUDANG2" id="NAMA_GUDANG2" class="form-control" type="text" placeholder="Contoh : Gudang Electrical" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Lokasi Gudang</label>
						<div class="col-xs-9">
							<input name="LOKASI_GUDANG2" id="LOKASI_GUDANG2" class="form-control" type="text" placeholder="Contoh : Sebelah container WASA" required>
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

		$('#ModalaAdd').on('shown.bs.modal', function() {
			$('#nama_gudang').focus();
		});

		$('#NAMA_PROYEK').change(function() {
			var id = $(this).val();
			$.ajax({
				url: "<?php echo site_url('gudang/get_pegawai_proyek'); ?>",
				method: "POST",
				data: {
					id: id
				},
				async: true,
				dataType: 'json',
				success: function(data) {

					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<option value=' + data[i].ID_PEGAWAI + '>' + data[i].NAMA + '</option>';
					}
					$('#PEGAWAI_LOG_GUDANG').html(html);

				}
			});
			return false;
		});

		$('#ModalaEdit').on('shown.bs.modal', function() {
			console.log('test');
			var id = $('#ID_PROYEK2').val();
			var id_pegawai_selected = $('#PEGAWAI_LOG_GUDANG2_A').val();
			$.ajax({
				url: "<?php echo site_url('gudang/get_pegawai_proyek'); ?>",
				method: "POST",
				data: {
					id: id
				},
				async: true,
				dataType: 'json',
				success: function(data) {

					

					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<option value=' + data[i].ID_PEGAWAI + '>' + data[i].NAMA + '</option>';
					}
					$('#PEGAWAI_LOG_GUDANG2').html(html);
					$('#PEGAWAI_LOG_GUDANG2').val(id_pegawai_selected);

				}
			});
			return false;
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
							'<td>' + data[i].PEGAWAI_LOG_GUDANG + '</td>' +
							'<td>' + data[i].NAMA_GUDANG + '</td>' +
							'<td>' + data[i].LOKASI_GUDANG + '</td>' +
							'<td>' +
							'<a href="javascript:;" class="btn btn-info btn-xs item_edit block" data="' + data[i].ID_GUDANG + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
							// '<a href="javascript:;" class="btn btn-info btn-xs item_tambah" data="' + data[i].ID_GUDANG + '"><i class="fa fa-plus"></i> Tambah Barang </a>' + ' ' +
							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_GUDANG + '"><i class="fa fa-trash"></i> Hapus</a>' +
							'<a href="<?php echo base_url() ?>Gudang_barang/index/' + data[i].HASH_MD5_GUDANG + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Lihat Barang</a>'+
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
						$('#ModalaEdit').modal('show');
						$('[name="ID_GUDANG2"]').val(data.ID_GUDANG);
						$('[name="ID_PROYEK2"]').val(data.ID_PROYEK);
						$('[name="NAMA_PROYEK2"]').val(data.NAMA_PROYEK);
						$('[name="LOKASI2"]').val(data.LOKASI);
						$('[name="PEGAWAI_LOG_GUDANG2_A"]').val(data.PEGAWAI_LOG_GUDANG);
						$('[name="NAMA_GUDANG2"]').val(data.NAMA_GUDANG);
						$('[name="LOKASI_GUDANG2"]').val(data.LOKASI_GUDANG);
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
				NAMA_PROYEK: $('#NAMA_PROYEK').val(),
				PEGAWAI_LOG_GUDANG: $('#PEGAWAI_LOG_GUDANG').val(),
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
						$('#ModalaAdd').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});

		//UPDATE DATA 
		$('#btn_update').on('click', function() {

			var ID_GUDANG2 = $('#ID_GUDANG2').val();
			var PEGAWAI_LOG_GUDANG2 = $('#PEGAWAI_LOG_GUDANG2').val();
			var NAMA_GUDANG2 = $('#NAMA_GUDANG2').val();
			var LOKASI_GUDANG2 = $('#LOKASI_GUDANG2').val();

			$.ajax({
				url: "<?php echo site_url('gudang/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_GUDANG2: ID_GUDANG2,
					PEGAWAI_LOG_GUDANG2: PEGAWAI_LOG_GUDANG2,
					NAMA_GUDANG2: NAMA_GUDANG2,
					LOKASI_GUDANG2: LOKASI_GUDANG2
				},
				success: function(data) {
					if (data == true) {
						$('#ModalaEdit').modal('hide');
						$('[name="ID_PROYEK2"]').val("");
						$('[name="ID_GUDANG2"]').val("");
						$('[name="NAMA_PROYEK2"]').val("");
						$('[name="LOKASI2"]').val("");
						$('[name="PEGAWAI_LOG_GUDANG2"]').val("");
						$('[name="NAMA_GUDANG2"]').val("");
						$('[name="LOKASI_GUDANG2"]').val("");

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