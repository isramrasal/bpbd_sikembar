<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Detil Proyek</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url() ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/Proyek/') ?>">Proyek</a>
			</li>
			<li class="active">
				<strong>
					<a>Detil Proyek</a>
				</strong>
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInRight">

			<!-- BAGIAN PROFIL -->
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Profil Proyek</h5>
							<div class="ibox-tools">
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
							</div>
						</div>

						<?php foreach ($query_detil_proyek_HASH_MD5_PROYEK_result as $data_proyek) { ?>
							<div class="ibox-content">
								<div class="row">
									<div class="col-lg-12">
										<dl class="dl-horizontal">
											<?php if ($data_proyek->STATUS_PROYEK == "Berjalan") {
											?>
												<dt>Status:</dt>
												<dd><span class="label label-primary">Berjalan</span></dd>
											<?php
											}
											?>
											<?php if ($data_proyek->STATUS_PROYEK == "Selesai") {
											?>
												<dt>Status:</dt>
												<dd><span class="label label-danger">Selesai</span></dd>
											<?php
											}
											?>

										</dl>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-5">
										<dl class="dl-horizontal">

											<dt>Nama Proyek:</dt>
											<dd><?php echo $data_proyek->NAMA_PROYEK; ?></dd>
											<dt>Lokasi Proyek:</dt>
											<dd> <?php echo $data_proyek->LOKASI; ?></dd>
											<dt>Inisial Proyek:</dt>
											<dd> <?php echo $data_proyek->INISIAL; ?></dd>
										</dl>
									</div>
									<div class="col-lg-5">
										<dl class="dl-horizontal">

											<dt>Tanggal Mulai:</dt>
											<dd><?php echo $data_proyek->TANGGAL_MULAI_PROYEK; ?></dd>
											<dt>Tanggal Selesai:</dt>
											<dd><?php echo $data_proyek->TANGGAL_SELESAI_PROYEK; ?></dd>

										</dl>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-12">
										<dl class="dl-horizontal">
											<dt>Penyelesaian:</dt>
											<dd>
												<div class="progress progress-striped active m-b-sm">
													<div style="width: 30%;" class="progress-bar"></div>
												</div>
												<small>Persentase penyelesaian proyek <strong>30%</strong>.</small>
											</dd>
										</dl>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<!-- BAGIAN PROFIL -->

			<!-- BAGIAN PIC -->
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>PIC Proyek</h5>
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
								<table class="table table-striped table-bordered table-hover" id="mydata_PIC">
									<thead>
										<tr>
											<th>NIP</th>
											<th>Nama Pegawai</th>
											<th>Email</th>
											<th>Nomor Handphone</th>
											<th>Departemen</th>
											<th>Jabatan</th>
											<th>Pilihan</td>

										</tr>
									</thead>
									<tbody id="show_data_pic">

									</tbody>

								</table>
							</div>

							<!-- <a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#ModalAddPIC"><span class="fa fa-plus"></span> Tambah Data</a> -->

						</div>

					</div>
				</div>
			</div>
			<!-- BAGIAN PIC -->

			<!-- BAGIAN DOWNLOAD FILE -->
			<?php if ($FILE == "ADA") { ?>
				<div class="row">
					<div class="col-lg-9 animated fadeInRight">
						<div class="row">
							<div class="col-lg-12">
								<?php foreach ($dokumen as $proyek_file) { ?>

									<div class="file-box">
										<div class="file">
											<a href="#">
												<span class="corner"></span>

												<div class="icon">
													<i class="fa fa-file"></i>
												</div>
												<div class="file-name">
													<a href="<?php echo base_url(); ?>assets/upload_proyek_npwp/<?php echo $proyek_file->DOK_FILE; ?>">Download file</a>
													<br />
													<small>Jenis file: <?php echo $proyek_file->JENIS_FILE; ?></small>
													<br />
													<small>Keterangan file: <?php echo $proyek_file->KETERANGAN_FILE; ?></small>
													<br />
													<small>Diupload: <?php echo $proyek_file->TANGGAL_UPLOAD; ?></small>
												</div>
												<input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>index.php/Proyek/hapus_file/<?php echo $proyek_file->DOK_FILE; ?>';" value="Hapus" />

											</a>
										</div>
									</div>

								<?php } ?>
							</div>

						</div>
					</div>
				</div>

			<?php } else { ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox">
							<div class="ibox-title">
								<h5>Download File Dokumen</h5>
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
								Belum ada file dokumen. Silakan upload file dokumen.
							</div>

						</div>
					</div>
				</div>
			<?php } ?>
			<!-- BAGIAN DOWNLOAD FILE -->

			<div class="alert alert-info alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				Silakan upload file dokumen sesuai dengan ketentuan .
			</div>


			<div class="row">
				<div class="col-lg-12">
					<div class="ibox">
						<div class="ibox-title">
							<h5>Upload File Dokumen</h5>
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


							<p>
								File dokumen yang Anda upload akan digunakan untuk keperluan proyek, dengan ketentuan sebagai berikut:
							<ul class="sortable-list connectList agile-list" id="ketentuan">
								<li class="warning-element" id="task1">
									1. File dokumen yang diupload harus merupakan data milik proyek.
								</li>
								<li class="danger-element" id="task2">
									2. Ukuran dokumen yang diterima sistem maksimal 5 Mega Bytes (5 MB).
								</li>
								<li class="success-element" id="task4">
									3. Ekstensi/tipe file yang diterima sistem adalah .PDF dan .JPEG/.JPG/.BMP.
								</li>

								<li class="warning-element" id="task1">
									4. Pilih jenis File Dokumen sebelum melakukan upload.
									</br>

								</li>

							</ul>
							</p>


							<form action="#" class="dropzone" id="dropzoneForm">

								</br>
								<div class="col-xs-9">
									<select name="JENIS_FILE" id="JENIS_FILE">
										<option value='Belum didefinisikan'>- Pilih Jenis File Dokumen -</option>
										<option value='RASD'>RASD</option>
										<option value='Dokumen Lainnya'>Dokumen Lainnya</option>
									</select>
									</br>
									<input name="KETERANGAN_FILE" id="KETERANGAN_FILE" class="form-control" type="text" placeholder="Keterangan File Dokumen" required>

								</div>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								<div class="fallback">
									<input name="file" type="file" multiple />
								</div>
							</form>

							<div>
								</br>
								<button class="btn btn-primary" name="btn_upload" id="btn_upload"><i class="fa fa-save"></i> Upload</button>
							</div>

						</div>
					</div>
				</div>
			</div>
			</br>
			</br></br>


		</div>
	</div>
</div>
</br>
</br>
</br>
<div class="footer">
	<div>
		<p><strong>&copy; <?php echo (date("Y")); ?> PT. Wasa Mitra Enginering</strong><br /> Hak cipta dilindungi undang-undang.</p>
	</div>
</div>

</div>
</div>

<!-- MODAL ADD PIC -->
<div class="modal inmodal fade" id="ModalAddPIC" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">PIC Proyek</h4>
				<small class="font-bold">Silakan tambah data PIC Proyek</small>
			</div>
			<?php $attributes = array("nama_pegawai" => "contact_form", "id" => "contact_form");
			echo form_open("Proyek_detil/simpan_data_pic_proyek", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nomor Induk Pegawai</label>
						<div class="col-xs-9">
							<input name="NIP" id="NIP" class="form-control" type="text" placeholder="Contoh: 200504236">
						</div>
					</div>


					<input name="ID_PROYEK_PEGAWAI" id="ID_PROYEK_PEGAWAI" class="form-control" type="hidden" value="<?php echo $ID_PROYEK; ?>">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Lengkap</label>
						<div class="col-xs-9">
							<input name="NAMA" id="NAMA" class="form-control" type="text" placeholder="Contoh: Budi Utomo" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email</label>
						<div class="col-xs-9">
							<input name="EMAIL" id="EMAIL" class="form-control" type="text" placeholder="Contoh: budiutomo@gmail.com" required>
						</div>
					</div>

					<div class="alert alert-warning alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Perhatian! Email akan digunakan sebagai username.
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nomor Handphone</label>
						<div class="col-xs-9">
							<input name="NO_HP_1" id="NO_HP_1" class="form-control" type="text" placeholder="Contoh: 081812334567" required>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Departemen</label>
						<div class="col-xs-9">
							<select name="ID_DEPARTEMEN_PEGAWAI" class="form-control" id="ID_DEPARTEMEN_PEGAWAI">
								<option value=''>- Pilih Departemen -</option>
								<?php foreach ($departemen as $prov) {
									echo '<option value="' . $prov->ID_DEPARTEMEN  . '">' . $prov->NAMA_DEPARTEMEN . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Jabatan</label>
						<div class="col-xs-9">
							<select name="JABATAN_PEGAWAI" class="form-control" id="JABATAN_PEGAWAI">
								<option value=''>- Pilih Jabatan -</option>
								<option value='Project Manager'>Project Manager </option>
								<option value='Site Manager'>Site Manager </option>
								<option value='Chief'>Chief</option>
								<option value='Supervisor'>Supervisor</option>
								<option value='Staff'>Staff</option>
							</select>
						</div>
					</div>

					

					<div id="alert-msg-pic"></div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" id="btn_simpan_pic"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END MODAL ADD-->





<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- DROPZONE -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dropzone/dropzone.js"></script>

<!-- Page-Level Scripts -->
<script>
	Dropzone.autoDiscover = false;

	Dropzone.options.dropzoneForm = {
		paramName: "file", // The name that will be used to transfer the file
		autoProcessQueue: false,
		maxFilesize: 5, // MB
		maxFiles: 1,
		dictDefaultMessage: "<strong>Letakkan file di sini atau klik untuk memuat file. </strong></br> (Pastikan file yang Anda upload sesuai dengan ketentuan)",
		dictFileTooBig: "Maaf ukuran file tidak sesuai ketentuan."
	};



	var file_upload = new Dropzone(".dropzone", {
		url: "<?php echo base_url('index.php/Proyek/proses_upload_file') ?>",
		maxFilesize: 5,
		method: "post",
		acceptedFiles: "image/jpeg,image/png,image/jpg,image/bmp,application/pdf",
		paramName: "userfile",
		dictInvalidFileType: "Maaf ekstensi/tipe file tidak sesuai ketentuan.",
		addRemoveLinks: true,
		init: function() {
			var myDropzone = this;

			// Update selector to match your button
			$("#btn_upload").click(function(e) {
				e.preventDefault();
				myDropzone.processQueue();
				var form_data = {
					JENIS_FILE: $('#JENIS_FILE').val(),
					KETERANGAN_FILE: $('#KETERANGAN_FILE').val()
				};
				$.ajax({
					url: "<?php echo base_url('index.php/Proyek/proses_upload_file') ?>",
					type: 'POST',
					data: form_data,
					success: function(data) {
						if (data != '') {
							console.log("waduh");
						} else {
							console.log("waduh 2");
						}
					}
				});
			});


			this.on("success", function(file, responseText) {
				location.reload();;
			});
		}
	});


	//Event ketika Memulai mengupload
	file_upload.on("sending", function(a, b, c) {
		a.token = Math.random();
		c.append("token_npwp", a.token); //Mempersiapkan token untuk masing masing npwp
	});


	//Event ketika data dihapus
	file_upload.on("removedfile", function(a) {
		var token = a.token;
		$.ajax({
			type: "post",
			data: {
				token: token
			},
			url: "<?php echo base_url('index.php/Proyek/remove_file') ?>",
			cache: false,
			dataType: 'json',
			success: function() {
				console.log("Data terhapus");
			},
			error: function() {
				console.log("Error");
			}
		});
	});
</script>

<script>
	$(document).ready(function() {
		$('.file-box').each(function() {
			animationHover(this, 'pulse');
		});

		tampil_data_pic_proyek(); //pemanggilan fungsi tampil data.

		//fungsi tampil data
		function tampil_data_pic_proyek() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/Proyek_detil/data_pic_proyek',
				async: false,
				dataType: 'JSON',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {

						html += '<tr>' +
							'<td>' + data[i].NIP + '</td>' +
							'<td>' + data[i].NAMA + '</td>' +
							'<td>' + data[i].EMAIL + '</td>' +
							'<td>' + data[i].NO_HP_1 + '</td>' +
							'<td>' + data[i].NAMA_DEPARTEMEN + '</td>' +
							'<td>' + data[i].JABATAN_PEGAWAI + '</td>' +
							'<td>' +
							'<a href="javascript:;" class="btn btn-info btn-xs item_edit block" data="' + data[i].ID_PEGAWAI + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +

							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_PEGAWAI + '"><i class="fa fa-trash"></i> Hapus </a>' +
							'</td>' +
							'</tr>';
					}
					$('#show_data_pic').html(html);
				}

			});
		}

		$('#mydata_PIC').dataTable({
			pageLength: 10,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'copy'
				},
				{
					extend: 'csv',
					title: 'Data PIC Proyek'
				},
				{
					extend: 'excel',
					title: 'Data PIC Proyek'
				},
				{
					extend: 'pdf',
					title: 'Data PIC Proyek'
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

		//SIMPAN DATA
		$('#btn_simpan_pic').click(function() {
			var form_data = {
				NIP: $('#NIP').val(),
				ID_PROYEK_PEGAWAI: $('#ID_PROYEK_PEGAWAI').val(),
				ID_DEPARTEMEN_PEGAWAI: $('#ID_DEPARTEMEN_PEGAWAI').val(),
				JABATAN_PEGAWAI: $('#JABATAN_PEGAWAI').val(),
				NAMA: $('#NAMA').val(),
				EMAIL: $('#EMAIL').val(),
				NO_HP_1: $('#NO_HP_1').val()
			};
			$.ajax({
				url: "<?php echo site_url('Proyek/simpan_data_pic_proyek'); ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					NIP: NIP,
					ID_PROYEK_PEGAWAI: ID_PROYEK_PEGAWAI,
					ID_DEPARTEMEN_PEGAWAI: ID_DEPARTEMEN_PEGAWAI,
					JABATAN_PEGAWAI: JABATAN_PEGAWAI,
					NAMA: NAMA,
					EMAIL: EMAIL,
					NO_HP_1: NO_HP_1
				},
				success: function(data) {
					if (data != '') {
						$('#alert-msg-pic').html('<div class="alert alert-danger">' + data + '</div>');
						console.log(data);
					} else {
						$('[name="NIP"]').val("");
						$('[name="ID_PROYEK_PEGAWAI"]').val("");
						$('[name="ID_DEPARTEMEN_PEGAWAI"]').val("");
						$('[name="NAMA"]').val("");
						$('[name="EMAIL"]').val("");
						$('[name="NO_HP_1"]').val("");
						$('[name="JABATAN_PEGAWAI"]').val("");
						$('#ModalAddPIC').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});
	});
</script>

</body>

</html>