<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List Vendor</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url() ?>">Home</a>
			</li>
			<li class="active">
				<a href="<?php echo base_url('index.php/Vendor/') ?>">Vendor</a>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

	<div class="alert alert-danger alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Pastikan Anda mengisi data vendor dengan benar.
	</div>

	<div class="alert alert-info alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Sistem menampilkan seluruh vendor.
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>List Vendor</h5>
					<div class="ibox-tools">
						<a class="fullscreen-link">
							<i class="fa fa-expand"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalaAdd"><span class="fa fa-plus"></span> Tambah Data</a>
					<a href="<?php echo base_url('index.php/TOP/') ?>" class="btn btn-outline btn-primary"> Atur Term of Payment</a>
					<br><br>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="mydata">
							<thead>
								<tr>
									<th style="width:5%">No.</th>
									<th>Nama Vendor</th>
									<th>No. Telepon Vendor</th>
									<th>Email Vendor</th>
									<th>Status</th>
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

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-anchor modal-icon"></i>
				<h4 class="modal-title">Vendor</h4>
				<small class="font-bold">Silakan tambah data vendor</small>
			</div>
			<?php
			echo form_open("vendor/simpan_data"); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="alert alert-info alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Upload file dokumen dilakukan di halaman profil vendor.
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Vendor</label>
						<div class="col-xs-9">
							<input name="NAMA_VENDOR" id="NAMA_VENDOR" class="form-control" type="text" placeholder="Contoh: PT. NUSA INDAH CEMERLANG" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Alamat Vendor</label>
						<div class="col-xs-9">
							<textarea name="ALAMAT_VENDOR" id="ALAMAT_VENDOR" class="form-control" type="text" placeholder="Contoh: Jalan Nusa Indah 4 No.22 RT/RW: 002/010. Kec. Batu Ampar, Kel. Sungai Jauh. Jakarta Pusat. Kodepos 12434."></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. Telepon Vendor</label>
						<div class="col-xs-9">
							<input name="NO_TELP_VENDOR" id="NO_TELP_VENDOR" class="form-control" type="text" placeholder="Contoh: 0218484212" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email Vendor</label>
						<div class="col-xs-9">
							<input name="EMAIL_VENDOR" id="EMAIL_VENDOR" class="form-control" type="email" placeholder="Contoh: info@nic.com" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama PIC Vendor</label>
						<div class="col-xs-9">
							<input name="NAMA_PIC_VENDOR" id="NAMA_PIC_VENDOR" class="form-control" type="text" placeholder="Contoh: Nana Soewarna" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. HP PIC Vendor</label>
						<div class="col-xs-9">
							<input name="NO_HP_PIC_VENDOR" id="NO_HP_PIC_VENDOR" class="form-control" type="text" placeholder="Contoh: 081228299132" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email PIC Vendor</label>
						<div class="col-xs-9">
							<input name="EMAIL_PIC_VENDOR" id="EMAIL_PIC_VENDOR" class="form-control" type="email" placeholder="Contoh: nana_soewarna@nic.com" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Status</label>
						<div class="col-xs-9">
							<select name="STATUS_VENDOR" class="form-control" id="STATUS_VENDOR">
								<option value=''>- Pilih Status Vendor -</option>
								<option value='AKTIF'> Aktif</option>
								<option value='TIDAK AKTIF'> Tidak Aktif</option>
							</select>
						</div>
					</div>

					<!-- <div class="hr-line-dashed"></div>

					<div class="alert alert-info alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Pendaftaran Akun Vendor Untuk Aplikasi SIPESUT
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Username (Generate by System)</label>
						<div class="col-xs-9">
							<input name="USERNAME" id="USERNAME" class="form-control" type="text" enabled>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Password</label>
						<div class="col-xs-9">
							<input name="PASSWORD_UTAMA" id="PASSWORD_UTAMA" class="form-control" type="text"> <br>
							<button class="btn btn-warning " id="btn_generate_password"><i class="fa fa-cog"></i> Generate Password</button>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Tanggal Expired Access</label>
						<div class="col-xs-9">
							<input id="EXPIRED" name="EXPIRED" type="date" class="form-control">
						</div>
					</div> -->

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
				<i class="fa fa-anchor modal-icon"></i>
				<h4 class="modal-title">Vendor</h4>
				<small class="font-bold">Silakan edit data vendor</small>
			</div>
			<?php $attributes = array("id_vendor2" => "contact_form", "id" => "contact_form");
			echo form_open("vendor/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<input name="ID_VENDOR2" id="ID_VENDOR2" class="form-control" type="hidden" placeholder="ID Proyek" readonly>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Vendor</label>
						<div class="col-xs-9">
							<input name="NAMA_VENDOR2" id="NAMA_VENDOR2" class="form-control" type="text" placeholder="Contoh: PT. NUSA INDAH CEMERLANG" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Alamat Vendor</label>
						<div class="col-xs-9">
							<textarea name="ALAMAT_VENDOR2" id="ALAMAT_VENDOR2" class="form-control" type="text" placeholder="Contoh: Jalan Nusa Indah 4 No.22 RT/RW: 002/010. Kec. Batu Ampar, Kel. Sungai Jauh. Jakarta Pusat. Kodepos 12434."></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. Telepon Vendor</label>
						<div class="col-xs-9">
							<input name="NO_TELP_VENDOR2" id="NO_TELP_VENDOR2" class="form-control" type="text" placeholder="Contoh: 0218484212" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email Vendor</label>
						<div class="col-xs-9">
							<input name="EMAIL_VENDOR2" id="EMAIL_VENDOR2" class="form-control" type="email" placeholder="Contoh: info@nic.com" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama PIC Vendor</label>
						<div class="col-xs-9">
							<input name="NAMA_PIC_VENDOR2" id="NAMA_PIC_VENDOR2" class="form-control" type="text" placeholder="Contoh: Nana Soewarna" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. HP PIC Vendor</label>
						<div class="col-xs-9">
							<input name="NO_HP_PIC_VENDOR2" id="NO_HP_PIC_VENDOR2" class="form-control" type="text" placeholder="Contoh: 081228299132" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email PIC Vendor</label>
						<div class="col-xs-9">
							<input name="EMAIL_PIC_VENDOR2" id="EMAIL_PIC_VENDOR2" class="form-control" type="email" placeholder="Contoh: nana_soewarna@nic.com" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Status</label>
						<div class="col-xs-9">
							<select name="STATUS_VENDOR2" class="form-control" id="STATUS_VENDOR2">
								<option value=''>- Pilih Status Vendor -</option>
								<option value='AKTIF'> Aktif</option>
								<option value='TIDAK AKTIF'> Tidak Aktif</option>
							</select>
						</div>
					</div>

					<div class="alert alert-info alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Upload file dokumen dilakukan di halaman profil vendor.
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
				<h4 class="modal-title" id="myModalLabel">Hapus Data Vendor</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" name="kode" id="textkode" value="">
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini?</p>
						<div name="NAMA_VENDOR3" id="NAMA_VENDOR3"></div>
					</div>

					<div class="alert alert-danger alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Seluruh file dokumen vendor juga akan dihapus oleh sistem!
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
		// $("#EMAIL_VENDOR").change(function() {
		// 	let EMAIL_VENDOR = $('#EMAIL_VENDOR').val();
		// 	$('[name="USERNAME"]').val(EMAIL_VENDOR);
		// });

		$('#ModalaAdd').on('shown.bs.modal', function() {
			$('#nama_vendor').focus();
		});

		tampil_data_vendor(); //pemanggilan fungsi tampil data.

		$('#mydata').dataTable({
			pageLength: 10,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'excel',
					title: '<?php echo $title ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
						columns: [0, 1, 2, 3, 4, 5, 6, 7]
					},
				}
			]

		});

		//fungsi tampil data
		function tampil_data_vendor() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/Vendor/data_vendor',
				async: false,
				dataType: 'json',
				success: function(data) {
					var nomor = 1;
					var html, html_status = '';
					var i;
					for (i = 0; i < data.length; i++) {
						if (data[i].STATUS_VENDOR == "AKTIF") {
							html_status = '<span class="label label-primary block">' + data[i].STATUS_VENDOR + '</span>';
						}
						if (data[i].STATUS_VENDOR == "TIDAK AKTIF") {
							html_status = '<span class="label label-danger block">' + data[i].STATUS_VENDOR + '</span>';
						}
						html += '<tr>' +
							'<td>' + nomor + '</td>' +
							'<td>' + data[i].NAMA_VENDOR + '</td>' +
							'<td>' + data[i].NO_TELP_VENDOR + '</td>' +
							'<td>' + data[i].EMAIL_VENDOR + '</td>' +
							'<td>' + html_status + '</td>' +
							'<td>' +
							'<a href="<?php echo base_url() ?>vendor/profil_vendor/' + data[i].HASH_MD5_VENDOR + '" class="btn btn-primary btn-xs btn-outline block"><i class="fa fa-eye"></i> Lihat Data </a>' + ' ' +
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
				url: "<?php echo base_url('index.php/Vendor/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(
						ID_VENDOR,
						NAMA_VENDOR,
						ALAMAT_VENDOR,
						NO_TELP_VENDOR,
						NAMA_PIC_VENDOR,
						NO_HP_PIC_VENDOR,
						EMAIL_PIC_VENDOR,
						NO_HP_PIC_VENDOR,
						EMAIL_VENDOR,
						STATUS_VENDOR) {
						$('#ModalaEdit').modal('show');
						$('[name="ID_VENDOR2"]').val(data.ID_VENDOR);
						$('[name="NAMA_VENDOR2"]').val(data.NAMA_VENDOR);
						$('[name="ALAMAT_VENDOR2"]').val(data.ALAMAT_VENDOR);
						$('[name="NO_TELP_VENDOR2"]').val(data.NO_TELP_VENDOR);
						$('[name="NAMA_PIC_VENDOR2"]').val(data.NAMA_PIC_VENDOR);
						$('[name="NO_HP_PIC_VENDOR2"]').val(data.NO_HP_PIC_VENDOR);
						$('[name="EMAIL_PIC_VENDOR2"]').val(data.EMAIL_PIC_VENDOR);
						$('[name="EMAIL_VENDOR2"]').val(data.EMAIL_VENDOR);
						$('[name="STATUS_VENDOR2"]').val(data.STATUS_VENDOR);
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
				url: "<?php echo base_url('index.php/Vendor/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_VENDOR, NAMA_VENDOR) {
						$('#ModalHapus').modal('show');
						$('[name="kode"]').val(id);
						$('#NAMA_VENDOR3').html('Nama Vendor: ' + data.NAMA_VENDOR);
					});
				}
			});
		});

		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				NAMA_VENDOR: $('#NAMA_VENDOR').val(),
				ALAMAT_VENDOR: $('#ALAMAT_VENDOR').val(),
				NO_TELP_VENDOR: $('#NO_TELP_VENDOR').val(),
				NAMA_PIC_VENDOR: $('#NAMA_PIC_VENDOR').val(),
				NO_HP_PIC_VENDOR: $('#NO_HP_PIC_VENDOR').val(),
				EMAIL_PIC_VENDOR: $('#EMAIL_PIC_VENDOR').val(),
				EMAIL_VENDOR: $('#EMAIL_VENDOR').val(),
				STATUS_VENDOR: $('#STATUS_VENDOR').val(),
				// USERNAME: $('#USERNAME').val(),
				// PASSWORD_UTAMA: $('#PASSWORD_UTAMA').val(),
				// EXPIRED: $('#EXPIRED').val(),
			};
			$.ajax({
				url: "<?php echo site_url('vendor/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data != '') {
						// if (data == 'Email Terkirim ke Vendor') {
						// 	$('[name="NAMA_VENDOR"]').val("");
						// 	$('[name="ALAMAT_VENDOR"]').val("");
						// 	$('[name="NO_TELP_VENDOR"]').val("");
						// 	$('[name="NAMA_PIC_VENDOR"]').val("");
						// 	$('[name="NO_HP_PIC_VENDOR"]').val("");
						// 	$('[name="EMAIL_PIC_VENDOR"]').val("");
						// 	$('[name="EMAIL_VENDOR"]').val("");
						// 	$('[name="STATUS_VENDOR"]').val("");
						// 	$('[name="USERNAME"]').val("");
						// 	$('[name="PASSWORD_UTAMA"]').val("");
						// 	$('[name="EXPIRED"]').val("");
						// 	$('#ModalaAdd').modal('hide');
						// 	window.location.reload();
						// } else {
						// }
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					} else {
						$('[name="NAMA_VENDOR"]').val("");
						$('[name="ALAMAT_VENDOR"]').val("");
						$('[name="NO_TELP_VENDOR"]').val("");
						$('[name="NAMA_PIC_VENDOR"]').val("");
						$('[name="NO_HP_PIC_VENDOR"]').val("");
						$('[name="EMAIL_PIC_VENDOR"]').val("");
						$('[name="EMAIL_VENDOR"]').val("");
						$('[name="STATUS_VENDOR"]').val("");
						// $('[name="USERNAME"]').val("");
						// $('[name="PASSWORD_UTAMA"]').val("");
						// $('[name="EXPIRED"]').val("");
						$('#ModalaAdd').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});

		//UPDATE DATA 
		$('#btn_update').on('click', function() {
			var ID_VENDOR2 = $('#ID_VENDOR2').val();
			var NAMA_VENDOR2 = $('#NAMA_VENDOR2').val();
			var ALAMAT_VENDOR2 = $('#ALAMAT_VENDOR2').val();
			var NO_TELP_VENDOR2 = $('#NO_TELP_VENDOR2').val();
			var NAMA_PIC_VENDOR2 = $('#NAMA_PIC_VENDOR2').val();
			var NO_HP_PIC_VENDOR2 = $('#NO_HP_PIC_VENDOR2').val();
			var EMAIL_PIC_VENDOR2 = $('#EMAIL_PIC_VENDOR2').val();
			var EMAIL_VENDOR2 = $('#EMAIL_VENDOR2').val();
			var STATUS_VENDOR2 = $('#STATUS_VENDOR2').val();
			console.log(ID_VENDOR2);
			$.ajax({
				url: "<?php echo site_url('vendor/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_VENDOR2: ID_VENDOR2,
					NAMA_VENDOR2: NAMA_VENDOR2,
					ALAMAT_VENDOR2: ALAMAT_VENDOR2,
					NO_TELP_VENDOR2: NO_TELP_VENDOR2,
					NAMA_PIC_VENDOR2: NAMA_PIC_VENDOR2,
					NO_HP_PIC_VENDOR2: NO_HP_PIC_VENDOR2,
					EMAIL_PIC_VENDOR2: EMAIL_PIC_VENDOR2,
					EMAIL_VENDOR2: EMAIL_VENDOR2,
					STATUS_VENDOR2: STATUS_VENDOR2
				},
				success: function(data) {
					console.log("masuk 2");
					if (data == true) {
						$('#ModalaEdit').modal('hide');
						$('[name="ID_VENDOR2"]').val("");
						$('[name="NAMA_VENDOR2"]').val("");
						$('[name="ALAMAT_VENDOR2"]').val("");
						$('[name="NO_TELP_VENDOR2"]').val("");
						$('[name="NAMA_PIC_VENDOR2"]').val("");
						$('[name="NO_HP_PIC_VENDOR2"]').val("");
						$('[name="EMAIL_PIC_VENDOR2"]').val("");
						$('[name="EMAIL_VENDOR2"]').val("");
						$('[name="STATUS_VENDOR2"]').val("");
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
				url: "<?php echo base_url('index.php/Vendor/hapus_data') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapus').modal('hide');
					tampil_data_vendor();
					window.location.reload();
				}
			});
			return false;
		});

		// $('#btn_generate_password').on('click', function() {
		// 	var USERNAME = $('#USERNAME').val();
		// 	$.ajax({
		// 		type: "POST",
		// 		url: "<?php echo base_url('index.php/Vendor/generate_password') ?>",
		// 		dataType: "JSON",
		// 		data: {
		// 			USERNAME: USERNAME
		// 		},
		// 		success: function(data) {
		// 			console.log(data);
		// 			$('[name="PASSWORD_UTAMA"]').val(data);
		// 		}
		// 	});
		// 	return false;
		// });

		$('#ALAMAT_VENDOR2').on('input', function() {
			this.style.height = 'auto';

			this.style.height =
				(this.scrollHeight) + 'px';
		});

		$('#ALAMAT_VENDOR').on('input', function() {
			this.style.height = 'auto';

			this.style.height =
				(this.scrollHeight) + 'px';
		});
	});
</script>

</body>

</html>