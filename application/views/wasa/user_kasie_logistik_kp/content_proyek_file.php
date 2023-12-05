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
											<dt>Penggunaan Sumber Daya:</dt>
											<dd>
												<div class="progress progress-striped active m-b-sm">
													<div style="width: <?php echo $data_proyek->PERSENTASE; ?>%;" class="progress-bar"></div>
												</div>
												<small>Persentase Penggunaan Sumber Daya <strong><?php echo $data_proyek->PERSENTASE; ?>%</strong>.</small>
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
							<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAddPIC"><span class="fa fa-plus"></span> Tambah Data</a><br><br>
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="mydata_PIC">
									<thead>
										<tr>
											<th>NIP</th>
											<th>Nama Pegawai</th>
											<th>Email</th>
											<th>Nomor Handphone</th>
											<th>Jabatan</th>
											<th>Username</th>
											<th>Pilihan</td>
										</tr>
									</thead>
									<tbody id="show_data_pic">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- BAGIAN PIC -->

			<!-- BAGIAN LOKASI PENYERAHAN -->
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Lokasi Penyerahan</h5>
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
							<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAddLokasiPenyerahan"><span class="fa fa-plus"></span> Tambah Data</a> <br><br>
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="mydata_lokasi_penyerahan">
									<thead>
										<tr>
											<th>Lokasi Penyerahan</th>
											<th class="col-xs-1">Pilihan</td>
										</tr>
									</thead>
									<tbody id="show_data_lokasi_penyerahan">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- BAGIAN LOKASI PENYERAHAN -->

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
													<a href="<?php echo base_url(); ?>assets/upload_proyek_file/<?php echo $proyek_file->DOK_FILE; ?>">Download file</a>
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
										<option value='Dokumen Lainnya'>Dokumen Proyek Lainnya</option>
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

<!-- MODAL ADD PIC-->
<div class="modal inmodal fade" id="ModalAddPIC" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
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
							</select>
						</div>
					</div>

					<div id="show_hidden_bidang" class="form-group" hidden>
						<label class="control-label col-xs-3">Bidang</label>
						<div class="col-xs-9">
							<select name="ID_DEPARTEMEN_PEGAWAI" class="form-control" id="ID_DEPARTEMEN_PEGAWAI">
								<option value='MEKANIKAL'>MEKANIKAL</option>
								<option value='ELEKTRIKAL'>ELEKTRIKAL</option>
								<option value='PIPING'>PIPING</option>
								<option value='KONTRUKSI'>KONTRUKSI</option>
							</select>
						</div>
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
<!--END MODAL ADD PIC-->

<!-- MODAL ADD Lokasi Penyerahan-->
<div class="modal inmodal fade" id="ModalAddLokasiPenyerahan" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Lokasi Penyerahan</h4>
				<small class="font-bold">Silakan tambah data Lokasi Penyerahan</small>
			</div>
			<?php $attributes = array("nama_lokasi_penyerahan" => "contact_form", "id" => "contact_form");
			echo form_open("Proyek/simpan_data_lokasi_penyerahan", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Lokasi Penyerahan</label>
						<div class="col-xs-9">
							<input name="NAMA_LOKASI_PENYERAHAN" id="NAMA_LOKASI_PENYERAHAN" class="form-control" type="text" placeholder="Contoh: Gudang Logistik Kantor Pusat">
							<input name="ID_PROYEK" id="ID_PROYEK" class="form-control" type="hidden" value="<?= $ID_PROYEK; ?>" hidden>
						</div>
					</div>


					<div id="alert-msg-3"></div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" id="btn_simpan_lokasi_penyerahan"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END MODAL ADD Lokasi Penyerahan-->

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

<!--MODAL HAPUS LOKASI PENYERAHAN-->
<div class="modal fade" id="ModalHapusLokasiPenyerahan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
				<h4 class="modal-title" id="myModalLabel">Hapus Data Organisasi</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="text" name="kode" id="textkode" value="" hidden>
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini? Data lokasi penyerahan yang sudah dihapus tidak bisa dipulihkan kembali.</p>
						</br>
						<div name="NAMA_LOKASI_PENYERAHAN_3" id="NAMA_LOKASI_PENYERAHAN_3"></div>
					</div>

				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn_hapus btn btn-danger" id="btn_hapus_lokasi"><i class="fa fa-trash"></i> Hapus</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--END MODAL HAPUS LOKASI PENYERAHAN-->



<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>


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

		$("#ID_JABATAN_PEGAWAI").change(function() {
			if ($("#ID_JABATAN_PEGAWAI option:selected").text() == 'Chief Proyek') {
				$('#show_hidden_bidang').attr("hidden", false); //enable input

			} else {
				$('#show_hidden_bidang').attr("hidden", true); //enable input
			}
		});

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

					html = "<option value=''>- Pilih Jabatan -</option>";

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
									$('[name="USERNAME"]').val(`${NAMA}_${name_jabatan}_${inisial}@wme.co.id`);
								}
							}
						});
					}
				});
			}
		});


		$('.file-box').each(function() {
			animationHover(this, 'pulse');
		});

		tampil_data_pic_proyek(); //pemanggilan fungsi tampil data.
		tampil_data_lokasi_penyerahan();

		$('#mydata_PIC').dataTable({
			pageLength: 10,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'excel',
					title: 'Data PIC Proyek',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5]
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
						columns: [0, 1, 2, 3, 4, 5]
					},
				}
			]
		});

		$('#mydata_lokasi_penyerahan').dataTable({
			pageLength: 10,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			responsive: true,
		});

		//fungsi tampil data
		function tampil_data_pic_proyek() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/Proyek/data_pic_proyek',
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
							'<td>' + data[i].NAMA_JABATAN + '</td>' +
							'<td>' + data[i].USERNAME + '</td>' +
							'<td>' +

							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_PEGAWAI + '"><i class="fa fa-trash"></i> Hapus </a>' +
							'</td>' +
							'</tr>';
					}
					$('#show_data_pic').html(html);
				}

			});
		}

		//fungsi tampil data
		function tampil_data_lokasi_penyerahan() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/Proyek/data_lokasi_penyerahan',
				async: false,
				dataType: 'JSON',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {

						html += '<tr>' +
							'<td>' + data[i].NAMA_LOKASI_PENYERAHAN + '</td>' +
							'<td>' +

							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus_lokasi block" data="' + data[i].ID_PROYEK_LOKASI_PENYERAHAN + '"><i class="fa fa-trash"></i> Hapus </a>' +
							'</td>' +
							'</tr>';
					}
					$('#show_data_lokasi_penyerahan').html(html);
				}

			});
		}


		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				NIP: $('#NIP').val(),
				NAMA: $('#NAMA').val(),
				EMAIL: $('#EMAIL').val(),
				NO_HP_1: $('#NO_HP_1').val(),
				ID_PROYEK_PEGAWAI: $('#ID_PROYEK_PEGAWAI').val(),
				ID_JABATAN_PEGAWAI: $('#ID_JABATAN_PEGAWAI').val(),
				ID_DEPARTEMEN_PEGAWAI: $('#ID_DEPARTEMEN_PEGAWAI').val(),
				USERNAME: $('#USERNAME').val(),
				PASSWORD_UTAMA: $('#PASSWORD_UTAMA').val(),
				PASSWORD_KONFIRMASI: $('#PASSWORD_KONFIRMASI').val()

			};
			$.ajax({
				url: "<?php echo site_url('organisasi/simpan_data_PIC_proyek'); ?>",
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
						$('[name="ID_DEPARTEMEN_PEGAWAI"]').val("");
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

		$('#btn_simpan_lokasi_penyerahan').click(function() {
			var form_data = {
				NAMA_LOKASI_PENYERAHAN: $('#NAMA_LOKASI_PENYERAHAN').val(),
				ID_PROYEK: $('#ID_PROYEK').val()

			};
			$.ajax({
				url: "<?php echo site_url('Proyek/simpan_data_lokasi_penyerahan'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data != '') {
						$('#alert-msg-3').html('<div class="alert alert-danger">' + data + '</div>');
					} else {
						$('[name="NAMA_LOKASI_PENYERAHAN"]').val("");
						$('[name="NAMA_PROYEK"]').val("");
						$('#ModalaAddLokasiPenyerahan').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});

		//GET HAPUS
		$('#show_data_pic').on('click', '.item_hapus', function() {
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

		//GET HAPUS LOKASI PENYERAHAN
		$('#show_data_lokasi_penyerahan').on('click', '.item_hapus_lokasi', function() {
			var id = $(this).attr('data');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('index.php/Proyek/get_data_lokasi') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function() {
						$('#ModalHapusLokasiPenyerahan').modal('show');
						$('[name="kode"]').val(id);
						$('#NAMA_LOKASI_PENYERAHAN_3').html('Lokasi penyerahan: ' + data.NAMA_LOKASI_PENYERAHAN);
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
					window.location.reload();
				}
			});
			return false;
		});

		//HAPUS DATA LOKASI
		$('#btn_hapus_lokasi').on('click', function() {
			var kode = $('#textkode').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('index.php/Proyek/hapus_data_lokasi') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapusLokasiPenyerahan').modal('hide');
					window.location.reload();
				}
			});
			return false;
		});
	});
</script>

</body>

</html>