<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List Surat Jalan</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Home</a>
			</li>
			<li class="active">
				<strong>
					<a>Data Surat Jalan</a>
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
		Sistem menampilkan seluruh Surat Jalan.
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Surat Jalan</h5>
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
									<th>No. Surat Jalan</th>
									<th>Tanggal Surat Jalan</th>
									<th>Kepada</th>
									<th>PIC Penerima Barang</th>
									<th>No. HP PIC</th>
									<th>Jenis Pengiriman</th>
									<th>Jenis Kendaraan</th>
									<th>No. Polisi</th>
									<th>Nama Pengemudi</th>
									<th>No. HP Pengemudi</th>
									<th>Dokumen Surat Jalan</th>
									<th>Dokumen Delivery Note</th>
									<th>Dokumen Packing List</th>
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
				<h4 class="modal-title">Surat Jalan</h4>
				<small class="font-bold">Silakan tambah data surat jalan</small>
			</div>
			<?php $attributes = array("nama_surat_jalan" => "contact_form", "id" => "contact_form");
			echo form_open("surat_jalan/simpan_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Surat Jalan</label>
						<div class="col-xs-9">
							<input name="NAMA_SURAT_JALAN" id="NAMA_SURAT_JALAN" class="form-control" type="text" placeholder="Nama Surat Jalan.." required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Alamat Surat Jalan</label>
						<div class="col-xs-9">
							<textarea style="width:100%" name="ALAMAT_SURAT_JALAN" id="ALAMAT_SURAT_JALAN" class="form-control" type="text" placeholder="Alamat Surat Jalan.." required></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. Telpon Surat Jalan</label>
						<div class="col-xs-9">
							<input name="NO_TELP_SURAT_JALAN" id="NO_TELP_SURAT_JALAN" class="form-control" type="text" placeholder="No. Telpon Surat Jalan.." required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama PIC Surat Jalan</label>
						<div class="col-xs-9">
							<input name="NAMA_PIC_SURAT_JALAN" id="NAMA_PIC_SURAT_JALAN" class="form-control" type="text" placeholder="Nama PIC Surat Jalan.." required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. HP PIC Surat Jalan</label>
						<div class="col-xs-9">
							<input name="NO_HP_PIC_SURAT_JALAN" id="NO_HP_PIC_SURAT_JALAN" class="form-control" type="text" placeholder="No. HP PIC Surat Jalan.." required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email PIC Surat Jalan</label>
						<div class="col-xs-9">
							<input name="EMAIL_PIC_SURAT_JALAN" id="EMAIL_PIC_SURAT_JALAN" class="form-control" type="email" placeholder="Email PIC Surat Jalan.." required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email Surat Jalan</label>
						<div class="col-xs-9">
							<input name="EMAIL_SURAT_JALAN" id="EMAIL_SURAT_JALAN" class="form-control" type="email" placeholder="Email Surat Jalan.." required autofocus>
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
				<h4 class="modal-title">Surat Jalan</h4>
				<small class="font-bold">Silakan edit data Surat Jalan</small>
			</div>
			<?php $attributes = array("id_surat_jalan2" => "contact_form", "id" => "contact_form");
			echo form_open("surat_jalan/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">ID Surat Jalan</label>
						<div class="col-xs-9">
							<input name="ID_SURAT_JALAN2" id="ID_SURAT_JALAN2" class="form-control" type="text" placeholder="ID surat_jalan" readonly>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Surat Jalan</label>
						<div class="col-xs-9">
							<input name="NAMA_SURAT_JALAN2" id="NAMA_SURAT_JALAN2" class="form-control" type="text" placeholder="Nama Surat Jalan.." required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Alamat</label>
						<div class="col-xs-9">
							<textarea style="width:100%" name="ALAMAT_SURAT_JALAN2" id="ALAMAT_SURAT_JALAN2" class="form-control" type="text" placeholder="Alamat Surat Jalan.." required></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No Telp Surat Jalan</label>
						<div class="col-xs-9">
							<input name="NO_TELP_SURAT_JALAN2" id="NO_TELP_SURAT_JALAN2" class="form-control" type="text" placeholder="No Telp Surat Jalan.." required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama PIC Surat Jalan</label>
						<div class="col-xs-9">
							<input name="NAMA_PIC_SURAT_JALAN2" id="NAMA_PIC_SURAT_JALAN2" class="form-control" type="text" placeholder="Nama PIC.." required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No HP PIC Surat Jalan</label>
						<div class="col-xs-9">
							<input name="NO_HP_PIC_SURAT_JALAN2" id="NO_HP_PIC_SURAT_JALAN2" class="form-control" type="text" placeholder="No HP PIC" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email PIC Surat Jalan</label>
						<div class="col-xs-9">
							<input name="EMAIL_PIC_SURAT_JALAN2" id="EMAIL_PIC_SURAT_JALAN2" class="form-control" type="text" placeholder="Email PIC" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email Surat Jalan</label>
						<div class="col-xs-9">
							<input name="EMAIL_SURAT_JALAN2" id="EMAIL_SURAT_JALAN2" class="form-control" type="text" placeholder="Email Surat Jalan" required>
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
				<h4 class="modal-title" id="myModalLabel">Hapus Data Surat Jalan</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" name="kode" id="textkode" value="">
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini?</p>
						<div name="NAMA_SURAT_JALAN3" id="NAMA_SURAT_JALAN3"></div>
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
			$('#nama_surat_jalan').focus();
		});

		tampil_data_surat_jalan(); //pemanggilan fungsi tampil data.

		$('#mydata').dataTable({
			pageLength: 10,
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
					title: 'Surat Jalan'
				},
				{
					extend: 'pdf',
					title: 'Surat Jalan'
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
		function tampil_data_surat_jalan() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/surat_jalan/data_surat_jalan',
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<tr>' +
							'<td>' + data[i].NO_SURAT_JALAN + '</td>' +
							'<td>' + data[i].TANGGAL_SURAT_JALAN_HARI + '</td>' +
							'<td>' + data[i].KEPADA + '</td>' +
							'<td>' + data[i].PIC_PENERIMA_BARANG + '</td>' +
							'<td>' + data[i].NO_HP_PIC + '</td>' +
							'<td>' + data[i].JENIS_PENGIRIMAN + '</td>' +
							'<td>' + data[i].JENIS_KENDARAAN + '</td>' +
							'<td>' + data[i].NO_POLISI + '</td>' +
							'<td>' + data[i].NAMA_PENGEMUDI + '</td>' +
							'<td>' + data[i].NO_HP_PENGEMUDI + '</td>' +
							'<td>' + data[i].DOK_SURAT_JALAN + '</td>' +
							'<td>' + data[i].DOK_DELIVERY_NOTE + '</td>' +
							'<td>' + data[i].DOK_PACKING_LIST + '</td>' +
							'<td>' +
							'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="' + data[i].ID_SURAT_JALAN + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="' + data[i].ID_SURAT_JALAN + '"><i class="fa fa-trash"></i> Hapus</a>' +
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
				url: "<?php echo base_url('index.php/surat_jalan/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(
						ID_SURAT_JALAN,
						NO_SURAT_JALAN,
						KEPADA,
						PIC_PENERIMA_BARANG,
						NO_HP_PIC,
						JENIS_PENGIRIMAN,
						JENIS_KENDARAAN,
						NO_POLISI,
						NAMA_PENGEMUDI,
						NO_HP_PENGEMUDI,
						DOK_SURAT_JALAN,
						DOK_DELIVERY_NOTE,
						DOK_PACKING_LIST) {
						$('#ModalaEdit').modal('show');
						$('[name="ID_SURAT_JALAN2"]').val(data.ID_SURAT_JALAN);
						$('[name="NO_SURAT_JALAN2"]').val(data.NO_SURAT_JALAN);
						$('[name="TANGGAL_SURAT_JALAN_BULAN2"]').val(data.TANGGAL_SURAT_JALAN_BULAN);
						$('[name="KEPADA2"]').val(data.KEPADA);
						$('[name="PIC_PENERIMA_BARANG2"]').val(data.PIC_PENERIMA_BARANG);
						$('[name="NO_HP_PIC2"]').val(data.NO_HP_PIC);
						$('[name="JENIS_PENGIRIMAN2"]').val(data.JENIS_PENGIRIMAN);
						$('[name="JENIS_KENDARAAN2"]').val(data.JENIS_KENDARAAN);
						$('[name="NO_POLISI2"]').val(data.NO_POLISI);
						$('[name="NAMA_PENGEMUDI2"]').val(data.NAMA_PENGEMUDI);
						$('[name="NO_HP_PENGEMUDI2"]').val(data.NO_HP_PENGEMUDI);
						$('[name="DOK_SURAT_JALAN2"]').val(data.DOK_SURAT_JALAN);
						$('[name="DOK_DELIVERY_NOTE2"]').val(data.DOK_DELIVERY_NOTE);
						$('[name="DOK_PACKING_LIST2"]').val(data.DOK_PACKING_LIST);
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
				url: "<?php echo base_url('index.php/surat_jalan/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_SURAT_JALAN, NAMA_SURAT_JALAN) {
						$('#ModalHapus').modal('show');
						$('[name="kode"]').val(id);
						$('#NAMA_SURAT_JALAN3').html('Nama Surat Jalan: ' + data.NAMA_SURAT_JALAN);
					});
				}
			});
		});

		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				NAMA_SURAT_JALAN: $('#NAMA_SURAT_JALAN').val(),
				ALAMAT_SURAT_JALAN: $('#ALAMAT_SURAT_JALAN').val(),
				NO_TELP_SURAT_JALAN: $('#NO_TELP_SURAT_JALAN').val(),
				NAMA_PIC_SURAT_JALAN: $('#NAMA_PIC_SURAT_JALAN').val(),
				NO_HP_PIC_SURAT_JALAN: $('#NO_HP_PIC_SURAT_JALAN').val(),
				EMAIL_PIC_SURAT_JALAN: $('#EMAIL_PIC_SURAT_JALAN').val(),
				EMAIL_SURAT_JALAN: $('#EMAIL_SURAT_JALAN').val(),
			};
			$.ajax({
				url: "<?php echo site_url('surat_jalan/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data != '') {
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					} else {
						$('[name="NAMA_SURAT_JALAN"]').val("");
						$('[name="ALAMAT_SURAT_JALAN"]').val("");
						$('[name="NO_TELP_SURAT_JALAN"]').val("");
						$('[name="NAMA_PIC_SURAT_JALAN"]').val("");
						$('[name="NO_HP_PIC_SURAT_JALAN"]').val("");
						$('[name="EMAIL_PIC_SURAT_JALAN"]').val("");
						$('[name="EMAIL_SURAT_JALAN"]').val("");
						$('#ModalaAdd').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});

		//UPDATE DATA 
		$('#btn_update').on('click', function() {

			var ID_SURAT_JALAN2 = $('#ID_SURAT_JALAN2').val();
			var NAMA_SURAT_JALAN2 = $('#NAMA_SURAT_JALAN2').val();
			var ALAMAT_SURAT_JALAN2 = $('#ALAMAT_SURAT_JALAN2').val();
			var NO_TELP_SURAT_JALAN2 = $('#NO_TELP_SURAT_JALAN2').val();
			var NAMA_PIC_SURAT_JALAN2 = $('#NAMA_PIC_SURAT_JALAN2').val();
			var NO_HP_PIC_SURAT_JALAN2 = $('#NO_HP_PIC_SURAT_JALAN2').val();
			var EMAIL_PIC_SURAT_JALAN2 = $('#EMAIL_PIC_SURAT_JALAN2').val();
			var EMAIL_SURAT_JALAN2 = $('#EMAIL_SURAT_JALAN2').val();


			$.ajax({
				url: "<?php echo site_url('surat_jalan/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_SURAT_JALAN2: ID_SURAT_JALAN2,
					NAMA_SURAT_JALAN2: NAMA_SURAT_JALAN2,
					ALAMAT_SURAT_JALAN2: ALAMAT_SURAT_JALAN2,
					NO_TELP_SURAT_JALAN2: NO_TELP_SURAT_JALAN2,
					NAMA_PIC_SURAT_JALAN2: NAMA_PIC_SURAT_JALAN2,
					NO_HP_PIC_SURAT_JALAN2: NO_HP_PIC_SURAT_JALAN2,
					EMAIL_PIC_SURAT_JALAN2: EMAIL_PIC_SURAT_JALAN2,
					EMAIL_SURAT_JALAN2: EMAIL_SURAT_JALAN2
				},
				success: function(data) {
					if (data == true) {
						$('#ModalaEdit').modal('hide');
						$('[name="ID_SURAT_JALAN2"]').val("");
						$('[name="NAMA_SURAT_JALAN2"]').val("");
						$('[name="ALAMAT_SURAT_JALAN2"]').val("");
						$('[name="NO_TELP_SURAT_JALAN2"]').val("");
						$('[name="NAMA_PIC_SURAT_JALAN2"]').val("");
						$('[name="NO_HP_PIC_SURAT_JALAN2"]').val("");
						$('[name="EMAIL_PIC_SURAT_JALAN2"]').val("");
						$('[name="EMAIL_SURAT_JALAN2"]').val("");

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
				url: "<?php echo base_url('index.php/surat_jalan/hapus_data') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapus').modal('hide');
					tampil_data_surat_jalan();
					window.location.reload();
				}
			});
			return false;
		});

	});
</script>

</body>

</html>