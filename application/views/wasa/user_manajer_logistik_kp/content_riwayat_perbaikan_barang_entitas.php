<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List Riwayat Perbaikan Barang</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Home</a>
			</li>
			<li class="active">
				<strong>
					<a>Data Riwayat Perbaikan Barang</a>
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
		Sistem menampilkan seluruh riwayat perbaikan barang.
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Riwayat Perbaikan Barang</h5>
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
									<th>Nama Barang</th>
									<th>Merek Barang</th>
									<th>Kode Barang</th>
									<th>Status Kepemilikan</th>
									<th>Jenis Kepemilikan</th>
									<th>Lokasi Service</th>
									<th>Keterangan</th>
									<th>Tanggal Mulai Perbaikan</th>
									<th>Tanggal Selesai Perbaikan</th>
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

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Riwayat Perbaikan Barang</h4>
				<small class="font-bold">Silakan tambah data riwayat perbaikan barang</small>
			</div>
			<?php $attributes = array("name" => "contact_form", "id" => "contact_form");
			echo form_open("riwayat_perbaikan_barang_entitas/simpan_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Barang</label>
						<div class="col-xs-9">
							<input name="NAMA_RIWAYAT_PERBAIKAN_BARANG" id="NAMA_RIWAYAT_PERBAIKAN_BARANG" class="form-control" type="text" placeholder="Contoh : PT. NUSA INDAH CEMERLANG" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Alamat Perbaikan Barang</label>
						<div class="col-xs-9">
							<textarea style="width:100%" name="ALAMAT_RIWAYAT_PERBAIKAN_BARANG" id="ALAMAT_RIWAYAT_PERBAIKAN_BARANG" class="form-control" type="text" placeholder="Contoh : Jl. Teratai 2, No.22 RT/RW: 002/010. Kec. Batu Ampar, Kel. Sungai Jauh. Jakarta Pusat. 12434." required></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. Telpon</label>
						<div class="col-xs-9">
							<input name="NO_TELP_RIWAYAT_PERBAIKAN_BARANG" id="NO_TELP_RIWAYAT_PERBAIKAN_BARANG" class="form-control" type="text" placeholder="Contoh : 0218484212" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama PIC</label>
						<div class="col-xs-9">
							<input name="NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG" id="NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG" class="form-control" type="text" placeholder="Contoh : Nana Sumarna" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. HP PIC</label>
						<div class="col-xs-9">
							<input name="NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG" id="NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG" class="form-control" type="text" placeholder="Contoh : 081228299132" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email PIC</label>
						<div class="col-xs-9">
							<input name="EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG" id="EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG" class="form-control" type="email" placeholder="Contoh : nanas@example.com" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email Riwayat Perbaikan Barang</label>
						<div class="col-xs-9">
							<input name="EMAIL_RIWAYAT_PERBAIKAN_BARANG" id="EMAIL_RIWAYAT_PERBAIKAN_BARANG" class="form-control" type="email" placeholder="Contoh : nusaindahcemerlang@example.com" required autofocus>
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
				<h4 class="modal-title">Riwayat Perbaikan Barang</h4>
				<small class="font-bold">Silakan edit data riwayat_perbaikan_barang</small>
			</div>
			<?php $attributes = array("id_riwayat_perbaikan_barang2" => "contact_form", "id" => "contact_form");
			echo form_open("riwayat_perbaikan_barang_entitas/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Riwayat Perbaikan Barang</label>
						<div class="col-xs-9">
							<input name="NAMA_RIWAYAT_PERBAIKAN_BARANG2" id="NAMA_RIWAYAT_PERBAIKAN_BARANG2" class="form-control" type="text" placeholder="Contoh : PT. NUSA INDAH CEMERLANG" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Alamat Riwayat Perbaikan Barang</label>
						<div class="col-xs-9">
							<textarea style="width:100%" name="ALAMAT_RIWAYAT_PERBAIKAN_BARANG2" id="ALAMAT_RIWAYAT_PERBAIKAN_BARANG2" class="form-control" type="text" placeholder="Contoh : Jl. Teratai 2, No.22 RT/RW: 002/010. Kec. Batu Ampar, Kel. Sungai Jauh. Jakarta Pusat. 12434." required></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. Telpon Riwayat Perbaikan Barang</label>
						<div class="col-xs-9">
							<input name="NO_TELP_RIWAYAT_PERBAIKAN_BARANG2" id="NO_TELP_RIWAYAT_PERBAIKAN_BARANG2" class="form-control" type="text" placeholder="Contoh : 0218484212" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama PIC riwayat_perbaikan_barang</label>
						<div class="col-xs-9">
							<input name="NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG2" id="NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG2" class="form-control" type="text" placeholder="Contoh : Nana Sumarna" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. HP PIC riwayat_perbaikan_barang</label>
						<div class="col-xs-9">
							<input name="NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG2" id="NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG2" class="form-control" type="text" placeholder="Contoh : 081228299132" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email PIC Riwayat Perbaikan Barang</label>
						<div class="col-xs-9">
							<input name="EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG2" id="EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG2" class="form-control" type="email" placeholder="Contoh : nanas@example.com" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email Riwayat Perbaikan Barang</label>
						<div class="col-xs-9">
							<input name="EMAIL_RIWAYAT_PERBAIKAN_BARANG2" id="EMAIL_RIWAYAT_PERBAIKAN_BARANG2" class="form-control" type="email" placeholder="Contoh : nusaindahcemerlang@example.com" required autofocus>
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
				<h4 class="modal-title" id="myModalLabel">Hapus Data riwayat_perbaikan_barang</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" name="kode" id="textkode" value="">
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini?</p>
						<div name="NAMA_RIWAYAT_PERBAIKAN_BARANG3" id="NAMA_RIWAYAT_PERBAIKAN_BARANG3"></div>
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
			$('#nama_riwayat_perbaikan_barang').focus();
		});

		tampil_data_riwayat_perbaikan_barang(); //pemanggilan fungsi tampil data.

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
					title: 'Riwayat Perbaikan Barang'
				},
				{
					extend: 'pdf',
					title: 'Riwayat Perbaikan Barang'
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
		function tampil_data_riwayat_perbaikan_barang() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/riwayat_perbaikan_barang_entitas/data_riwayat_perbaikan_barang',
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<tr>' +
							'<td>' + data[i].NAMA_BARANG + '</td>' +
							'<td>' + data[i].MEREK + '</td>' +
							'<td>' + data[i].KODE_BARANG_ENTITAS + '</td>' +
							'<td>' + data[i].STATUS_KEPEMILIKAN + '</td>' +
							'<td>' + data[i].JENIS_KEPEMILIKAN + '</td>' +
							'<td>' + data[i].LOKASI_SERVICE + '</td>' +
							'<td>' + data[i].KETERANGAN + '</td>' +
							'<td>' + data[i].TANGGAL_MULAI_PERBAIKAN_HARI + '</td>' +
							'<td>' + data[i].TANGGAL_SELESAI_PERBAIKAN_HARI + '</td>' +
							'<td>' +
							'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="' + data[i].ID_RIWAYAT_PERBAIKAN_BARANG + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="' + data[i].ID_RIWAYAT_PERBAIKAN_BARANG + '"><i class="fa fa-trash"></i> Hapus</a>' +
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
				url: "<?php echo base_url('index.php/riwayat_perbaikan_barang_entitas/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(
						ID_RIWAYAT_PERBAIKAN_BARANG,
						NAMA_RIWAYAT_PERBAIKAN_BARANG,
						ALAMAT_RIWAYAT_PERBAIKAN_BARANG,
						NO_TELP_RIWAYAT_PERBAIKAN_BARANG,
						NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG,
						NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG,
						EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG,
						NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG,
						EMAIL_RIWAYAT_PERBAIKAN_BARANG,
						DOK_NPWP,
						DOK_SIUP,
						DOK_AKTA,
						DOK_LAP_KEU,
						DOK_LAINNYA) {
						$('#ModalaEdit').modal('show');
						$('[name="ID_RIWAYAT_PERBAIKAN_BARANG2"]').val(data.ID_RIWAYAT_PERBAIKAN_BARANG);
						$('[name="NAMA_RIWAYAT_PERBAIKAN_BARANG2"]').val(data.NAMA_RIWAYAT_PERBAIKAN_BARANG);
						$('[name="ALAMAT_RIWAYAT_PERBAIKAN_BARANG2"]').val(data.ALAMAT_RIWAYAT_PERBAIKAN_BARANG);
						$('[name="NO_TELP_RIWAYAT_PERBAIKAN_BARANG2"]').val(data.NO_TELP_RIWAYAT_PERBAIKAN_BARANG);
						$('[name="NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG2"]').val(data.NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG);
						$('[name="NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG2"]').val(data.NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG);
						$('[name="EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG2"]').val(data.EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG);
						$('[name="EMAIL_RIWAYAT_PERBAIKAN_BARANG2"]').val(data.EMAIL_RIWAYAT_PERBAIKAN_BARANG);
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
				url: "<?php echo base_url('index.php/riwayat_perbaikan_barang_entitas/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_RIWAYAT_PERBAIKAN_BARANG, NAMA_RIWAYAT_PERBAIKAN_BARANG) {
						$('#ModalHapus').modal('show');
						$('[name="kode"]').val(id);
						$('#NAMA_RIWAYAT_PERBAIKAN_BARANG3').html('Nama Riwayat Perbaikan Barang: ' + data.NAMA_RIWAYAT_PERBAIKAN_BARANG);
					});
				}
			});
		});

		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				NAMA_RIWAYAT_PERBAIKAN_BARANG: $('#NAMA_RIWAYAT_PERBAIKAN_BARANG').val(),
				ALAMAT_RIWAYAT_PERBAIKAN_BARANG: $('#ALAMAT_RIWAYAT_PERBAIKAN_BARANG').val(),
				NO_TELP_RIWAYAT_PERBAIKAN_BARANG: $('#NO_TELP_RIWAYAT_PERBAIKAN_BARANG').val(),
				NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG: $('#NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG').val(),
				NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG: $('#NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG').val(),
				EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG: $('#EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG').val(),
				EMAIL_RIWAYAT_PERBAIKAN_BARANG: $('#EMAIL_RIWAYAT_PERBAIKAN_BARANG').val(),
			};
			$.ajax({
				url: "<?php echo site_url('riwayat_perbaikan_barang_entitas/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data != '') {
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					} else {
						$('[name="NAMA_RIWAYAT_PERBAIKAN_BARANG"]').val("");
						$('[name="ALAMAT_RIWAYAT_PERBAIKAN_BARANG"]').val("");
						$('[name="NO_TELP_RIWAYAT_PERBAIKAN_BARANG"]').val("");
						$('[name="NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG"]').val("");
						$('[name="NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG"]').val("");
						$('[name="EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG"]').val("");
						$('[name="EMAIL_RIWAYAT_PERBAIKAN_BARANG"]').val("");
						$('#ModalaAdd').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});

		//UPDATE DATA 
		$('#btn_update').on('click', function() {

			var ID_RIWAYAT_PERBAIKAN_BARANG2 = $('#ID_RIWAYAT_PERBAIKAN_BARANG2').val();
			var NAMA_RIWAYAT_PERBAIKAN_BARANG2 = $('#NAMA_RIWAYAT_PERBAIKAN_BARANG2').val();
			var ALAMAT_RIWAYAT_PERBAIKAN_BARANG2 = $('#ALAMAT_RIWAYAT_PERBAIKAN_BARANG2').val();
			var NO_TELP_RIWAYAT_PERBAIKAN_BARANG2 = $('#NO_TELP_RIWAYAT_PERBAIKAN_BARANG2').val();
			var NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG2 = $('#NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG2').val();
			var NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG2 = $('#NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG2').val();
			var EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG2 = $('#EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG2').val();
			var EMAIL_RIWAYAT_PERBAIKAN_BARANG2 = $('#EMAIL_RIWAYAT_PERBAIKAN_BARANG2').val();


			$.ajax({
				url: "<?php echo site_url('riwayat_perbaikan_barang_entitas/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_RIWAYAT_PERBAIKAN_BARANG2: ID_RIWAYAT_PERBAIKAN_BARANG2,
					NAMA_RIWAYAT_PERBAIKAN_BARANG2: NAMA_RIWAYAT_PERBAIKAN_BARANG2,
					ALAMAT_RIWAYAT_PERBAIKAN_BARANG2: ALAMAT_RIWAYAT_PERBAIKAN_BARANG2,
					NO_TELP_RIWAYAT_PERBAIKAN_BARANG2: NO_TELP_RIWAYAT_PERBAIKAN_BARANG2,
					NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG2: NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG2,
					NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG2: NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG2,
					EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG2: EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG2,
					EMAIL_RIWAYAT_PERBAIKAN_BARANG2: EMAIL_RIWAYAT_PERBAIKAN_BARANG2
				},
				success: function(data) {
					if (data == true) {
						$('#ModalaEdit').modal('hide');
						$('[name="ID_RIWAYAT_PERBAIKAN_BARANG2"]').val("");
						$('[name="NAMA_RIWAYAT_PERBAIKAN_BARANG2"]').val("");
						$('[name="ALAMAT_RIWAYAT_PERBAIKAN_BARANG2"]').val("");
						$('[name="NO_TELP_RIWAYAT_PERBAIKAN_BARANG2"]').val("");
						$('[name="NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG2"]').val("");
						$('[name="NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG2"]').val("");
						$('[name="EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG2"]').val("");
						$('[name="EMAIL_RIWAYAT_PERBAIKAN_BARANG2"]').val("");

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
				url: "<?php echo base_url('index.php/riwayat_perbaikan_barang_entitas/hapus_data') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapus').modal('hide');
					tampil_data_riwayat_perbaikan_barang();
					window.location.reload();
				}
			});
			return false;
		});

	});
</script>

</body>

</html>