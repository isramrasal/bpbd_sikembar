<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List Organisasi</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/organisasi/') ?>">Organisasi</a>
			</li>
			<li class="active">
				<strong>
					<a>List Organisasi</a>
				</strong>
			</li>
		</ol>
	</div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">

	<div class="alert alert-info alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Sistem menampilkan seluruh data organisasi.
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Data Organisasi</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="fullscreen-link">
							<i class="fa fa-expand"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">

					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="mydata">
							<thead>
								<tr>
									<th>NIP</th>
									<th>Nama Pegawai</th>
									<th>Username</th>
									<th>Nomor Handphone</th>
									<th>Email Pribadi</th>
									<th>Proyek</th>
									<th>Departemen</th>
									<th>Aksi</td>

								</tr>
							</thead>
							<tbody id="show_data">

							</tbody>

						</table>
					</div>
					</br>
					</br>
					<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalaAdd"><span class="fa fa-plus"></span> Tambah Data</a>
				</div>

			</div>
		</div>
	</div>
</div>
</br>

<div class="footer">
	<div>
		<p><strong>&copy; <?php echo (date("Y")); ?> PT. Wasa Mitra Enginering</strong><br /> Hak cipta dilindungi undang-undang.</p>
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
				<h4 class="modal-title">Organisasi</h4>
				<small class="font-bold">Silakan tambah data organisasi</small>
			</div>
			<?php $attributes = array("nama_pegawai" => "contact_form", "id" => "contact_form");
			echo form_open("organisasi/simpan_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nomor Induk Pegawai</label>
						<div class="col-xs-9">
							<input name="NIP" id="NIP" class="form-control" type="text" placeholder="Contoh: 200504236">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Lengkap</label>
						<div class="col-xs-9">
							<input name="NAMA" id="NAMA" class="form-control" type="text" placeholder="Contoh: Budi Utomo" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email Pribadi</label>
						<div class="col-xs-9">
							<input name="EMAIL" id="EMAIL" class="form-control" type="text" placeholder="Contoh: budiutomo@gmail.com" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nomor Handphone</label>
						<div class="col-xs-9">
							<input name="NO_HP_1" id="NO_HP_1" class="form-control" type="text" placeholder="Contoh: 081812334567" required>
						</div>
					</div>


					<div class="form-group">
						<label class="control-label col-xs-3">Proyek</label>
						<div class="col-xs-9">
							<select name="ID_PROYEK_PEGAWAI" class="form-control" id="ID_PROYEK_PEGAWAI">
								<option value=''>- Pilih Proyek -</option>
								<?php foreach ($proyek as $prov) {
									echo '<option value="' . $prov->ID_PROYEK  . '">' . $prov->NAMA_PROYEK . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Jabatan</label>
						<div class="col-xs-9">
							<select name="ID_JABATAN_PEGAWAI" class="form-control" id="ID_JABATAN_PEGAWAI">
								<option value=''>- Pilih Jabatan -</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Username (Generate by System)</label>
						<div class="col-xs-9">
							<input name="USERNAME" id="USERNAME" class="form-control" type="text" disabled>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Password</label>
						<div class="col-xs-9">
							<input name="PASSWORD_UTAMA" id="PASSWORD_UTAMA" class="form-control" type="password">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Ketik Ulang Password</label>
						<div class="col-xs-9">
							<input name="PASSWORD_KONFIRMASI" id="PASSWORD_KONFIRMASI" class="form-control" type="password">
						</div>
					</div>

					<div class="alert alert-warning alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Perhatian! Pilih jabatan untuk perbarui username.
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
				<i class="fa fa-user-circle modal-icon"></i>
				<h4 class="modal-title">Biodata Organisasi</h4>
				<small class="font-bold">Silakan edit biodata organisasi secara lengkap</small>
			</div>
			<?php $attributes = array("id_pegawai2" => "contact_form", "id" => "contact_form");
			echo form_open("organisasi/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">


					<input name="ID_PEGAWAI2" id="ID_PEGAWAI2" class="form-control" type="hidden" placeholder="ID organisasi..." readonly>


					<div class="form-group">
						<label class="control-label col-xs-3">Nomor Induk Organisasi</label>
						<div class="col-xs-9">
							<input name="NIP2" id="NIP2" class="form-control" type="text" placeholder="Contoh: 200504236">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Proyek</label>
						<div class="col-xs-9">
							<select name="ID_PROYEK_PEGAWAI2" class="form-control" id="ID_PROYEK_PEGAWAI2">
								<option value=''>- Pilih Proyek -</option>
								<?php foreach ($proyek as $prov) {
									echo '<option value="' . $prov->ID_PROYEK  . '">' . $prov->NAMA_PROYEK . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Departemen</label>
						<div class="col-xs-9">
							<select name="ID_JABATAN_PEGAWAI2" class="form-control" id="ID_JABATAN_PEGAWAI2">
								<option value=''>- Pilih Departemen -</option>
								<?php foreach ($departemen as $prov) {
									echo '<option value="' . $prov->ID_DEPARTEMEN  . '">' . $prov->NAMA_DEPARTEMEN . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<input name="NIP2_shadow" id="NIP2_shadow" class="form-control" type="hidden">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Lengkap</label>
						<div class="col-xs-9">
							<input name="NAMA2" id="NAMA2" class="form-control" type="text" placeholder="Contoh: Budi Utomo" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email</label>
						<div class="col-xs-9">
							<input name="EMAIL2" id="EMAIL2" class="form-control" type="text" placeholder="Contoh: budiutomo@gmail.com" required>
						</div>
					</div>

					<input name="EMAIL2_shadow" id="EMAIL2_shadow" class="form-control" type="hidden">

					<div class="form-group">
						<label class="control-label col-xs-3">Nomor Handphone</label>
						<div class="col-xs-9">
							<input name="NO_HP_12" id="NO_HP_12" class="form-control" type="text" placeholder="Contoh: 081812334567" required>
						</div>
					</div>

					<div class="alert alert-warning alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Perhatian! Email akan digunakan sebagai username.
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
				<h4 class="modal-title" id="myModalLabel">Hapus Data Organisasi</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" name="kode" id="textkode" value="">
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini? Data organisasi yang sudah dihapus tidak bisa dipulihkan kembali. Anda akan menghapus seluruh data organisasi, termasuk foto, berkas dan riwayat penggunaan.</p>
						</br>
						<div name="nama_pegawai_3" id="nama_pegawai_3"></div>
						<div name="nip_pegawai_3" id="nip_pegawai_3"></div>
						<div name="email_pegawai_3" id="email_pegawai_3"></div>
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


<!-- Data picker -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Date range use moment.js same as full calendar plugin -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/fullcalendar/moment.min.js"></script>

<!-- Date range picker -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/daterangepicker/daterangepicker.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function() {

		// Dropdown ID PROYEK berubah
		$('#ID_PROYEK_PEGAWAI').change(function() {
			var proyek = $('#ID_PROYEK_PEGAWAI').val();

			// Menggunakan ajax untuk mengirim dan dan menerima data dari server
			$.ajax({
				url: "<?php echo base_url(); ?>/Organisasi/get_data_jabatan",
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
						html += '<option value=' + data[i].id + '>' + data[i].description + '</option>';
					}
					$('#ID_JABATAN_PEGAWAI').html(html);

				}
			});
		});

		// Dropdown ID JABATAN berubah
		$('#ID_JABATAN_PEGAWAI').change(function() {
			var NAMA = $('#NAMA').val();
			var NAMA = NAMA.replace(/ +/g, "");
			var NAMA = NAMA.toLowerCase();
			var id_jabatan = $('#ID_JABATAN_PEGAWAI').val();
			var id_proyek = $('#ID_PROYEK_PEGAWAI').val();


			if (id_proyek == "1") {
				// Menggunakan ajax untuk mengirim dan dan menerima data dari server
				$.ajax({
					url: "<?php echo base_url(); ?>/Organisasi/get_nama_jabatan",
					method: "POST",
					data: {
						id_jabatan: id_jabatan
					},
					async: false,
					dataType: 'json',
					success: function(data) {
						var html = '';
						var i;

						for (i = 0; i < data.length; i++) {

							var name_jabatan = data[i].name;
							console.log(name_jabatan);
							$('[name="USERNAME"]').val(`${NAMA}_${name_jabatan}@wme.co.id`);
						}
					}
				});
			} else {
				$.ajax({
					url: "<?php echo base_url(); ?>/Organisasi/get_inisial_proyek",
					method: "POST",
					data: {
						id_proyek: id_proyek
					},
					async: false,
					dataType: 'json',
					success: function(data) {
						var html = '';
						var i;

						for (i = 0; i < data.length; i++) {

							var inisial = data[i].INISIAL;
						}

						$.ajax({
							url: "<?php echo base_url(); ?>/Organisasi/get_nama_jabatan",
							method: "POST",
							data: {
								id_jabatan: id_jabatan
							},
							async: false,
							dataType: 'json',
							success: function(data) {
								var html = '';
								var i;

								for (i = 0; i < data.length; i++) {

									var name_jabatan = data[i].name;
									console.log(name_jabatan);
									$('[name="USERNAME"]').val(`${NAMA}_${name_jabatan}_${inisial}@wme.co.id`);
								}
							}
						});
					}
				});
			}
		});


		$('#tanggal_akhir .input-group.date').datepicker({
			startView: 1,
			todayBtn: "linked",
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,
			format: "yyyy-mm-dd"
		});

		$('#ModalaEdit').on('shown.bs.modal', function() {
			$('#NIK2').focus();
		});

		tampil_data_organisasi(); //pemanggilan fungsi tampil data.


		$('#mydata').dataTable({
			pageLength: 10,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'copy'
				},
				{
					extend: 'csv',
					title: 'Data Organisasi'
				},
				{
					extend: 'excel',
					title: 'Data Organisasi'
				},
				{
					extend: 'pdf',
					title: 'Data Organisasi'
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
		function tampil_data_organisasi() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/Organisasi/data_organisasi',
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {

						html += '<tr>' +
							'<td>' + data[i].NIP + '</td>' +
							'<td>' + data[i].NAMA + '</td>' +
							'<td>' + data[i].username + '</td>' +
							'<td>' + data[i].NO_HP_1 + '</td>' +
							'<td>' + data[i].EMAIL + '</td>' +
							'<td>' + data[i].NAMA_PROYEK + '</td>' +
							'<td>' + data[i].description + '</td>' +

							'<td>' +
							'<a href="javascript:;" class="btn btn-info btn-xs item_edit block" data="' + data[i].ID_PEGAWAI + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +

							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_PEGAWAI + '"><i class="fa fa-trash"></i> Hapus </a>' +
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
				url: "<?php echo base_url('index.php/organisasi/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_PEGAWAI, NIP, ID_PROYEK_PEGAWAI, ID_JABATAN_PEGAWAI, NAMA_PROYEK, NAMA, EMAIL, NO_HP_1) {
						$('#ModalaEdit').modal('show');
						$('[name="ID_PEGAWAI2"]').val(data.ID_PEGAWAI);
						$('[name="NIP2"]').val(data.NIP);
						$('[name="NIP2_shadow"]').val(data.NIP);
						$('[name="ID_PROYEK_PEGAWAI2"]').val(data.ID_PROYEK_PEGAWAI);
						$('[name="ID_JABATAN_PEGAWAI2"]').val(data.ID_JABATAN_PEGAWAI);
						$('[name="NAMA2"]').val(data.NAMA);
						$('[name="EMAIL2"]').val(data.EMAIL);
						$('[name="EMAIL2_shadow"]').val(data.EMAIL);
						$('[name="NO_HP_12"]').val(data.NO_HP_1);
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
				url: "<?php echo base_url('index.php/organisasi/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_PEGAWAI, NAMA) {
						$('#ModalHapus').modal('show');
						$('[name="kode"]').val(id);
						$('#nip_pegawai_3').html('Nomor Induk Organisasi: ' + data.NIP);
						$('#nama_pegawai_3').html('Nama Organisasi: ' + data.NAMA);
						$('#email_pegawai_3').html('Email Organisasi: ' + data.EMAIL);
					});
				}
			});
		});

		//HAPUS DATA
		$('#btn_hapus').on('click', function() {
			var kode = $('#textkode').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('index.php/organisasi/hapus_data') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapus').modal('hide');
					tampil_data_organisasi();
					window.location.reload();
				}
			});
			return false;
		});

		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				NIP: $('#NIP').val(),
				NAMA: $('#NAMA').val(),
				EMAIL: $('#EMAIL').val(),
				NO_HP_1: $('#NO_HP_1').val(),
				ID_PROYEK_PEGAWAI: $('#ID_PROYEK_PEGAWAI').val(),
				ID_JABATAN_PEGAWAI: $('#ID_JABATAN_PEGAWAI').val(),
				USERNAME: $('#USERNAME').val(),
				PASSWORD_UTAMA: $('#PASSWORD_UTAMA').val(),
				PASSWORD_KONFIRMASI: $('#PASSWORD_KONFIRMASI').val()

			};
			$.ajax({
				url: "<?php echo site_url('organisasi/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data != '') {
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					} else {
						$('[name="NIP"]').val("");
						$('[name="NAMA"]').val("");
						$('[name="EMAIL"]').val("");
						$('[name="NO_HP_1"]').val("");
						$('[name="ID_PROYEK_PEGAWAI"]').val("");
						$('[name="ID_JABATAN_PEGAWAI"]').val("");
						$('[name="USERNAME"]').val("");
						$('[name="PASSWORD_UTAMA"]').val("");
						$('[name="PASSWORD_KONFIRMASI"]').val("");
						$('#ModalaAdd').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});



		//UPDATE DATA 
		$('#btn_update').on('click', function() {

			var ID_PEGAWAI2 = $('#ID_PEGAWAI2').val();
			var NIP2 = $('#NIP2').val();
			var NIP2_shadow = $('#NIP2_shadow').val();
			var ID_PROYEK_PEGAWAI2 = $('#ID_PROYEK_PEGAWAI2').val();
			var ID_JABATAN_PEGAWAI2 = $('#ID_JABATAN_PEGAWAI2').val();
			var NAMA2 = $('#NAMA2').val();
			var EMAIL2 = $('#EMAIL2').val();
			var EMAIL2_shadow = $('#EMAIL2_shadow').val();
			var NO_HP_12 = $('#NO_HP_12').val();

			$.ajax({
				url: "<?php echo site_url('organisasi/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_PEGAWAI2: ID_PEGAWAI2,
					NIP2: NIP2,
					NIP2_shadow: NIP2_shadow,
					ID_PROYEK_PEGAWAI2: ID_PROYEK_PEGAWAI2,
					ID_JABATAN_PEGAWAI2: ID_JABATAN_PEGAWAI2,
					NAMA2: NAMA2,
					EMAIL2: EMAIL2,
					EMAIL2_shadow: EMAIL2_shadow,
					NO_HP_12: NO_HP_12
				},
				success: function(data) {
					if (data == true) {
						$('#ModalaEdit').modal('hide');
						$('[name="ID_PEGAWAI2"]').val("");
						$('[name="NIP2"]').val("");
						$('[name="NIP2_shadow"]').val("");
						$('[name="NAMA2"]').val("");
						$('[name="ID_PROYEK_PEGAWAI2"]').val("");
						$('[name="ID_JABATAN_PEGAWAI2"]').val("");
						$('[name="EMAIL2"]').val("");
						$('[name="EMAIL2_shadow"]').val("");
						$('[name="NO_HP_12"]').val("");
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