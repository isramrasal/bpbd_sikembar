<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Profil Barang Master</h2>
		<ol class="breadcrumb">
		<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/barang_master/') ?>">Barang Master</a>
			</li>
			<li class="active">
				<strong>
					<a>Profil Barang Master</a>
				</strong>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<?php foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data_barang_master) { ?>

		<div class="ibox-content">
			<div class="row">
				<div class="col-lg-12">
					<div class="m-b-md">
						<h2>Profil Barang Master</h2>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-md-4">
							<div class="product-images">
								<?php if (isset($dokumen)) { ?>
									<?php foreach ($dokumen as $barang_master_file) { ?>
										<?php if ($barang_master_file->JENIS_FILE == "Gambar Produk") {
											echo ("<img src='" . base_url() . $barang_master_file->KETERANGAN . "' alt='' srcset=''>'");
										}
										?>
								<?php }
								} else {
									echo ("Belum ada gambar produk. Silakan upload gambar produk");
								} ?>
							</div>
						</div>
						<div class="col-md-7">
							<div class="m-t-md">
								Status: <span class="label label-primary">Active</span>
							</div>
							<div class="m-t-md">
								<h2 class="product-main-price"><b>Nama Barang Master:</b> <br><?php echo $data_barang_master->NAMA; ?></h2>
							</div>
							<hr>
							<div class="m-t-md">
								<h4 class="product-main-price">Alias: <br></h4><?php echo $data_barang_master->ALIAS; ?>
							</div>
							<hr>
							<div class="m-t-md">
								<h4 class="product-main-price">Kode Barang: <br></h4><?php echo $data_barang_master->KODE_BARANG; ?>
							</div>
							<div class="m-t-md">
								<h4 class="product-main-price">Merek: <br></h4><?php echo $data_barang_master->MEREK; ?>
							</div>
							<hr>
							<!-- <h4>Spesifikasi Produk</h4> -->
							<dl class="m-t-md">
								<dt>Jenis Barang:</dt>
								<dd><?php echo $data_barang_master->NAMA_JENIS_BARANG ?></dd><br>
								<dt>Satuan Barang:</dt>
								<dd><?php echo $data_barang_master->NAMA_SATUAN_BARANG ?></dd><br>
								<dt>Gross Weight:</dt>
								<dd><?php echo $data_barang_master->GROSS_WEIGHT ?></dd><br>
								<dt>Nett Weight:</dt>
								<dd><?php echo $data_barang_master->NETT_WEIGHT ?></dd><br>
								<dt>Dimensi:</dt>
								<dd><?php echo $data_barang_master->DIMENSI_PANJANG . ' cm x ' . $data_barang_master->DIMENSI_LEBAR . ' cm x ' . $data_barang_master->DIMENSI_TINGGI . ' cm' ?></dd>
							</dl>
							<h4>Spesifikasi Lengkap Produk</h4>
							<div class=" text-muted">
								<?php echo $data_barang_master->SPESIFIKASI_LENGKAP ?>
							</div>
							<h4>Spesifikasi Singkat Produk</h4>
							<div class=" text-muted">
								<?php echo $data_barang_master->SPESIFIKASI_SINGKAT ?>
							</div>
							<h4>Cara Singkat Penggunaan</h4>
							<div class=" text-muted">
								<?php echo $data_barang_master->CARA_SINGKAT_PENGGUNAAN ?>
							</div>
							<h4>Cara Penyimpanan Barang</h4>
							<div class=" text-muted">
								<?php echo $data_barang_master->CARA_PENYIMPANAN_BARANG ?>
							</div>
							<h4>Masa Pakai</h4>
							<div class=" text-muted">
								<?php echo $data_barang_master->MASA_PAKAI ?>
							</div>
							<hr>
						</div>
					</div>
				</div>
			</div>


		</div>
	<?php } ?>

	</br>
	<div class="alert alert-danger alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Sistem hanya mengizinkan sistem untuk mendownload data yang terakhir diupload.
	</div>


	<?php if ($FILE == "ADA") { ?>
		<div class="row">
			<div class="col-lg-9 animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
						<?php foreach ($dokumen as $barang_master_file) { ?>

							<div class="file-box">
								<div class="file">
									<a href="#">
										<span class="corner"></span>

										<?php if ($barang_master_file->JENIS_FILE == "Gambar Produk") {
											echo ("<div class='image'>
										<img alt='image' class='img-responsive' 
										src='" . base_url() . $barang_master_file->KETERANGAN . "'></div>");
										} else {
											echo ("<div class='icon'>
										<i class='fa fa-file'></i>
										</div>");
										} ?>

										<div class="file-name">
											<a href="<?php echo base_url(); ?>assets/upload_barang_master_npwp/<?php echo $barang_master_file->DOK_FILE; ?>">Download file</a>
											<br />
											<small>Jenis file: <?php echo $barang_master_file->JENIS_FILE; ?></small>
											<br />
											<small>Diupload: <?php echo $barang_master_file->TANGGAL_UPLOAD; ?></small>
										</div>
										<!-- <input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>index.php/barang_master/hapus_file/<?php echo $barang_master_file->DOK_FILE; ?>';" value="Hapus" /> -->

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

	<!-- <div class="alert alert-info alert-dismissable">
		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
		Silakan upload file dokumen sesuai dengan ketentuan .
	</div> -->


	<!-- <div class="row">
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
						File dokumen yang Anda upload akan digunakan untuk keperluan barang master, dengan ketentuan sebagai berikut:
						<ul class="sortable-list connectList agile-list" id="ketentuan">
							<li class="warning-element" id="task1">
								1. File dokumen yang diupload harus merupakan data berkaitan dengan barang master.
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
								<option value='Gambar Produk'>Gambar Produk</option>
								<option value='Dokumen Garansi'>Dokumen Garansi</option>
								<option value='Dokumen Buku Manual'>Dokumen Buku Manual</option>
								<option value='Dokumen Lainnya'>Dokumen Lainnya</option>
							</select>
						</div>
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
	</div> -->
	</br>
	</br></br>


</div>
</br>
</br>
</br>
<div class="footer">
	<div>
		<p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br /> Hak cipta dilindungi undang-undang.</p>
	</div>
</div>

</div>
</div>





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

<!-- slick carousel-->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slick/slick.min.js"></script>

<!-- Page-Level Scripts -->
<script>
	$('.product-images').slick({
		dots: true
	});

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
		url: "<?php echo base_url('index.php/barang_master/proses_upload_file') ?>",
		maxFilesize: 1,
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
					JENIS_FILE: $('#JENIS_FILE').val()
				};
				$.ajax({
					url: "<?php echo base_url('index.php/barang_master/proses_upload_file') ?>",
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
			url: "<?php echo base_url('index.php/barang_master/remove_file') ?>",
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
	});
</script>

</body>

</html>