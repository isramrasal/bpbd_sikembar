<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List Barang di Gudang</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/Gudang_barang/') ?>">Gudang Barang</a>
			</li>
			<li class="active">
				<strong>
					<a>List Barang di Gudang</a>
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
		Sistem menampilkan seluruh barang di gudang.
	</div>

	<!-- BAGIAN PROFIL -->
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Profil Gudang Proyek</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="fullscreen-link">
							<i class="fa fa-expand"></i>
						</a>
						<!-- <a href="javascript:;" class="btn btn-info btn-xs item_edit_profil_proyek"><i class="fa fa-pencil"></i> Edit</a> -->
					</div>
				</div>

				<?php foreach ($detil_proyek_by_ID_PROYEK_result as $data_proyek) { ?>
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

									</br>
									</br>
									<dt>Nama Gudang:</dt>
									<dd><?php echo $NAMA_GUDANG; ?></dd>
									<dt>Lokasi Gudang:</dt>
									<dd> <?php echo $LOKASI_GUDANG; ?></dd>
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

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Barang di Gudang: <?php echo $NAMA_GUDANG; ?></h5>
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
									<th>Kode Barang Entitas</th>
									<th>Jenis Barang</th>
									<th>Nama Barang</th>
									<th>Merek</th>
									<th>Satuan Barang</th>
									<th>Jumlah Item</th>
									<th>Tanggal Kadaluarsa</th>
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

		tampil_data_gudang_barang(); //pemanggilan fungsi tampil data.

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
					title: 'Barang di Gudang'
				},
				{
					extend: 'pdf',
					title: 'Barang di Gudang'
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
		function tampil_data_gudang_barang() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/Gudang_barang/data_gudang_barang',
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<tr>' +
							'<td>' + data[i].KODE_BARANG_ENTITAS + '</td>' +
							'<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
							'<td>' + data[i].NAMA + '</td>' +
							'<td>' + data[i].MEREK + '</td>' +
							'<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
							'<td>' + data[i].JUMLAH_BARANG + '</td>' +
							'<td>' + data[i].TANGGAL_KADALUARSA_HARI + '</td>' +


							'<td>' +
							'<a href="<?php echo base_url() ?>barang_entitas/list_entitas/' + data[i].HASH_MD5_BARANG_MASTER + '" class="btn btn-primary btn-xs block"><i class="fa fa-eye"></i>Lihat Profil Barang</a>' +
							'<a href="<?php echo base_url() ?>Riwayat_pemakaian_barang_entitas/item/' + data[i].HASH_MD5_BARANG_ENTITAS + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i>Riwayat Pemakaian Barang</a>' +
							'<a href="<?php echo base_url() ?>Riwayat_perbaikan_barang_entitas/item/' + data[i].HASH_MD5_BARANG_ENTITAS + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i>Riwayat Perbaikan Barang</a>' +
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