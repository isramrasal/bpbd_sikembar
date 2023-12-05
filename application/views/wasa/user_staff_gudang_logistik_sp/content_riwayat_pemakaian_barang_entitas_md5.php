<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List Riwayat Pemakaian Barang Entitas</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/Riwayat_pemakaian_barang_entitas/') ?>">Riwayat Pemakaian Barang Entitas</a>
			</li>
			<li class="active">
				<strong>
					<a>Barang Entitas</a>
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
		Sistem menampilkan seluruh riwayat pemakaian barang.
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<?php foreach ($query_barang_master_HASH_MD5_BARANG_ENTITAS_result as $data_barang_master) { ?>

					<div class="ibox">
						<div class="ibox-title">
							<h5>Profil Barang Master</h5>
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
												<h2 class="product-main-price">Nama Barang Master: <br><?php echo $data_barang_master->NAMA; ?></h2>
											</div>
											<hr>
											<div class="m-t-md">
												<h2 class="product-main-price">Merek: <br><?php echo $data_barang_master->MEREK; ?></h2>
											</div>
											<hr>
											<div class="m-t-md">
												<h4 class="product-main-price">Alias: <br></h4><?php echo $data_barang_master->ALIAS; ?>
											</div>
											<hr>
											<div class="m-t-md">
												<h4 class="product-main-price">Kode Barang: <br></h4><?php echo $data_barang_master->KODE_BARANG; ?>
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
					</div>
				<?php } ?>

				</br>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Riwayat Pemakaian Barang</h5>
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
									<th>Nama Pegawai</th>
									<th>Nama Proyek</th>
									<th>Departemen</th>
									<th>Keterangan</th>
									<th>Tanggal Mulai Pemakaian</th>
									<th>Tanggal Selesai Pemakaian</th>
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

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>


<!-- slick carousel-->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slick/slick.min.js"></script>

<!-- Page-Level Scripts -->
<script>
	$('.product-images').slick({
		dots: true
	});
</script>

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function() {

		tampil_data_riwayat_pemakaian_barang(); //pemanggilan fungsi tampil data.

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
					title: 'Riwayat Pemakaian Barang'
				},
				{
					extend: 'pdf',
					title: 'Riwayat Pemakaian Barang'
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
		function tampil_data_riwayat_pemakaian_barang() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/riwayat_pemakaian_barang_entitas/data_riwayat_pemakaian_barang_entitas',
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<tr>' +
							'<td>' + data[i].NAMA_PEGAWAI + '</td>' +
							'<td>' + data[i].NAMA_PROYEK + '</td>' +
							'<td>' + data[i].DEPARTEMEN + '</td>' +
							'<td>' + data[i].KETERANGAN + '</td>' +
							'<td>' + data[i].TANGGAL_MULAI_PEMAKAIAN_HARI + '</td>' +
							'<td>' + data[i].TANGGAL_SELESAI_PEMAKAIAN_HARI + '</td>' +
							'</tr>';
					}
					$('#show_data').html(html);
				}

			});
		}

	});
</script>

</body>

</html>