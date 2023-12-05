<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Term of Payment</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/TOP/') ?>">Term of Payment</a>
			</li>
			<li class="active">
				<strong>
					<a>Term of Payment</a>
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

	<div class="row">
		<div class="col-lg-12">
			<div class="wrapper wrapper-content animated fadeInRight">

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
								</br>

								<a href="#" class="btn btn-success btn-xs" data-toggle="modal" data-target="#ModalAddLokasiPenyerahan"><span class="fa fa-plus"></span> Tambah Data</a>

							</div>

						</div>
					</div>
				</div>
				<!-- BAGIAN LOKASI PENYERAHAN -->

			</div>
		</div>
	</div>
</div>

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

		$('#mydata_lokasi_penyerahan').dataTable({
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