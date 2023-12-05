<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Informasi Barang Entitas</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/barang_entitas/') ?>">Barang Entitas</a>
			</li>
			<li>
				<a href="#">Profil Barang Entitas</a>
			</li>
			<li class="active">
				<strong>
					<a>Informasi Barang Entitas</a>
				</strong>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<?php foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data_barang_master) { ?>

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


	<?php if ($FILE == "ADA") { ?>
		<div class="row">
			<div class="col-lg-9 animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
						<?php foreach ($dokumen as $barang_entitas_file) { ?>

							<div class="file-box">
								<div class="file">
									<a href="#">
										<span class="corner"></span>




										<?php if ($barang_entitas_file->JENIS_FILE == "Gambar Produk") {
											echo ("<div class='image'>
										<img alt='image' class='img-responsive' 
										src='" . base_url() . $barang_entitas_file->KETERANGAN . "'></div>");
										} else {
											echo ("<div class='icon'>
										<i class='fa fa-file'></i>
										</div>");
										} ?>

										<div class="file-name">
											<a href="<?php echo base_url(); ?>assets/upload_barang_entitas_npwp/<?php echo $barang_entitas_file->DOK_FILE; ?>">Download file</a>
											<br />
											<small>Jenis file: <?php echo $barang_entitas_file->JENIS_FILE; ?></small>
											<br />
											<small>Diupload: <?php echo $barang_entitas_file->TANGGAL_UPLOAD; ?></small>
										</div>

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




	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Barang Entitas</h5>
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
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>Kode Barang Entitas</th>
									<th>Tanggal Perolehan</th>
									<th>No. SPPB</th>
									<th>No. PO</th>
									<th>Jenis Kepemilikan</th>
									<th>Tanggal Mulai Sewa</th>
									<th>Tanggal Selesai Sewa</th>
									<th>Lokasi Saat ini</th>
									<th>Pilihan</th>
									
								</tr>
								<?php foreach ($list_barang_entitas as $be) { ?>
								<tr>
									<td><?php echo $be->KODE_BARANG_ENTITAS ?></td>
									<td><?php echo $be->TANGGAL_PEROLEHAN_HARI ?></td>
									<td><?php echo $be->NO_URUT_PO ?></td>
									<td><?php echo $be->NO_URUT_PO ?></td>
									<td><?php echo $be->JENIS_KEPEMILIKAN ?></td>
									<td><?php echo $be->TANGGAL_MULAI_SEWA_HARI ?></td>
									<td><?php echo $be->TANGGAL_SELESAI_SEWA_HARI ?></td>
									<td><?php echo $be->NAMA_GUDANG ?></td>

									<td>
                            		<a href="<?php echo base_url() ?>Riwayat_pemakaian_barang_entitas/item/<?php echo $be->HASH_MD5_BARANG_ENTITAS ?>" class="btn btn-success btn-xs block"><i class="fa fa-plus-square"></i> Riwayat Pemakaian Barang </a>
                            		<a href="<?php echo base_url() ?>Riwayat_perbaikan_barang_entitas/item/<?php echo $be->HASH_MD5_BARANG_ENTITAS ?>" class="btn btn-success btn-xs block"><i class="fa fa-plus-square"></i> Riwayat Perbaikan Barang </a>
                            		</td>
									
								</tr>
								
								<?php } ?>
							</thead>
							<tbody id="show_data">

							</tbody>

						</table>
					</div>

				</div>

			</div>
		</div>
	</div>
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
</script>


<script>
	$(document).ready(function() {

		$('.file-box').each(function() {
			animationHover(this, 'pulse');
		});

		tampil_data_barang_entitas(); //pemanggilan fungsi tampil data.

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
					title: 'Barang Entitas'
				},
				{
					extend: 'pdf',
					title: 'Barang Entitas'
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
		function tampil_data_barang_entitas() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>barang_entitas/data_barang_entitas',
				async: false,
				dataType: 'json',
				success: function(data) {
					console.log(data);
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<tr>' +
							'<td>' + data[i].KODE_BARANG + '</td>' +
							'<td>' + data[i].NAMA + '</td>' +
							'<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
							'<td>' + data[i].PERALATAN_PERLENGKAPAN + '</td>' +
							'<td>' + data[i].GROSS_WEIGHT + '</td>' +
							'<td>' + data[i].NETT_WEIGHT + '</td>' +
							'<td>' + data[i].DIMENSI_PANJANG + ' cm x ' + data[i].DIMENSI_LEBAR + ' cm x ' + data[i].DIMENSI_TINGGI + ' cm' + '</td>' +
							'<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
							'<td>' +
							'<a href="<?php echo base_url() ?>barang_entitas/profil_barang_entitas/' + data[i].HASH_MD5_BARANG_MASTER + '" class="btn btn-warning btn-xs btn-outline block"><i class="fa fa-eye"></i> Lihat Data </a>' + ' ' +
							'<a href="<?php echo base_url() ?>barang_entitas/ubah/' + data[i].HASH_MD5_BARANG_MASTER + '" class="btn btn-info btn-xs block"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
							'<a href="<?php echo base_url() ?>barang_entitas/list_entitas/' + data[i].HASH_MD5_BARANG_MASTER + '" class="btn btn-success btn-xs block"><i class="fa fa-plus-square"></i> Tambah Barang Entitas </a>' + ' ' +
							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].HASH_MD5_BARANG_MASTER + '"><i class="fa fa-trash"></i> Hapus</a>' +
							'</td>' +
							'</tr>';
					}
					$('#show_data').html(html);
				}
			});
		}

		//GET HAPUS
		$('#show_data').on('click', '.item_hapus', function() {
			var id = $(this).attr('data');
			console.log(id);
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('index.php/barang_entitas/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_BARANG_MASTER, NAMA) {
						$('#ModalHapus').modal('show');
						$('[name="kode"]').val(id);
						$('#NAMA_3').html('Nama Barang Entitas: ' + data.NAMA);
					});
				}
			});
		});

		//HAPUS DATA
		$('#btn_hapus').on('click', function() {
			var kode = $('#textkode').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('index.php/barang_entitas/hapus_data') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapus').modal('hide');
					tampil_data_barang_entitas();
					window.location.reload();
				}
			});
			return false;
		});

	});
</script>

</body>

</html>