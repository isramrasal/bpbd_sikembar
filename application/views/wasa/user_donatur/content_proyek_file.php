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

							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="mydata_PIC">
									<thead>
										<tr>
											<th>Nama Pegawai</th>
											<th>Email</th>
											<th>Nomor Handphone</th>
											<th>Jabatan</th>
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

							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="mydata_lokasi_penyerahan">
									<thead>
										<tr>
											<th>Lokasi Penyerahan</th>
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

			<!-- BAGIAN SUB PEKERJAAAN -->
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>List Pekerjaan</h5>
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
							<!-- <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAddSubPekerjaan"><span class="fa fa-plus"></span> Tambah Data</a> <br><br> -->
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="mydata_sub_pekerjaan">
									<thead>
										<tr>
											<th>Pekerjaan</th>
											<th class="col-xs-1">Pilihan</td>
										</tr>
									</thead>
									<tbody id="show_data_sub_pekerjaan">
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- BAGIAN SUB PEKERJAAAN -->

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
		</div>
	</div>
</div>

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
	$(document).ready(function() {
		$('.file-box').each(function() {
			animationHover(this, 'pulse');
		});

		tampil_data_pic_proyek(); //pemanggilan fungsi tampil data.
		tampil_data_lokasi_penyerahan(); //pemanggilan fungsi tampil data ke table
		tampil_data_sub_pekerjaan(); //pemanggilan fungsi tampil data ke table

		$('#mydata_PIC').dataTable({
			pageLength: 10,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			responsive: true,			
		});
		
		$('#mydata_lokasi_penyerahan').dataTable({
			pageLength: 10,
			lengthMenu: [
				[10, 25, 50, -1],
				[10, 25, 50, 'All'],
			],
			responsive: true,
		});

		$('#mydata_sub_pekerjaan').dataTable({
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
							'<td>' + data[i].NAMA + '</td>' +
							'<td>' + data[i].EMAIL + '</td>' +
							'<td>' + data[i].NO_HP_1 + '</td>' +
							'<td>' + data[i].NAMA_JABATAN + '</td>' +
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
							'</tr>';
					}
					$('#show_data_lokasi_penyerahan').html(html);
				}
			});
		}

		//fungsi tampil data
		function tampil_data_sub_pekerjaan() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/Proyek/data_sub_pekerjaan',
				async: false,
				dataType: 'JSON',
				success: function(data) {
					var html, html_button_rab = '';
					var i;
					var data_1 = data;

					for (i = 0; i < data.length; i++) {

						html += '<tr>' +
							'<td>' + data_1[i].NAMA_SUB_PEKERJAAN + '</td>' +
							'<td>' + '<a href="<?php echo base_url() ?>rab_form/index/' + data_1[i].HASH_MD5_RAB + '" class="btn btn-primary btn-xs block"><i class="fa fa-search"></i> Lihat RAB </a>' +  ' ' +
							'</td>' +
							'</tr>';
					}
					$('#show_data_sub_pekerjaan').html(html);
				}

			});
		}

	});
</script>

</body>

</html>