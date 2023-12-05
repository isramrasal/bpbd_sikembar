 <div class="row wrapper border-bottom white-bg page-heading">
 	<div class="col-lg-10">
 		<h2>List Barang Entitas</h2>
 		<ol class="breadcrumb">
 			<li>
 				<a href="index.html">Home</a>
 			</li>
 			<li>
 				<a>Barang Entitas</a>
 			</li>
 			<li class="active">
 				<strong>Data</strong>
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
 		Sistem menampilkan seluruh barang entitas.
	 </div>

	 
	Menambahkan header dengan tujuan memanjakan user -->
 	<!-- <div class="ibox-content">
 		<div class="row">
 			<?php
				if (isset($barang_master)) {
					foreach ($barang_master->result() as $master) {
				?>
 					<div class="col-md-4">
 						<div class="product-images">
 							<img src="https://d2pa5gi5n2e1an.cloudfront.net/webp/global/images/product/laptops/ASUS_ROG_Zephyrus_S_GX521/ASUS_ROG_Zephyrus_S_GX521_L_1.jpg" alt="" srcset="">
 							<img src="https://d2pa5gi5n2e1an.cloudfront.net/webp/global/images/product/laptops/ASUS_ROG_Zephyrus_S_GX521/ASUS_ROG_Zephyrus_S_GX521_L_5.jpg" alt="" srcset="">
 							<img src="https://d2pa5gi5n2e1an.cloudfront.net/webp/global/images/product/laptops/ASUS_ROG_Zephyrus_S_GX521/ASUS_ROG_Zephyrus_S_GX521_L_4.jpg" alt="" srcset="">
 						</div>
 					</div>
 					<div class="col-md-7">

 						<h2 class="font-bold m-b-xs">
 							<?php echo $master->NAMA; ?>
 						</h2>
 						<div class="m-t-md">
 							<h2 class="product-main-price">Kode Master : <?php echo $master->KODE_BARANG; ?></h2>
 						</div>
 						<div class="m-t-md">
 							<h3 class="product-main-price">Kode Entity : <?php echo $kode_barang_entitas; ?></h3>
 						</div>
 						<!-- <div>
                                                                <label class="col-sm-3 " style="font-size: 12pt;">Kode Entity :</label>
                                                                <div class="col-sm-5"><input type="text" class="form-control" value="getKodeEntitas()" name="KODE_BARANG_ENTITAS" id="KODE_BARANG_ENTITAS" required disabled></div>
                                                            </div> -->
 						<hr>
 						<!-- <h4>Spesifikasi Produk</h4> -->
 						<dl class="m-t-md">
 							<dt>Jenis Barang :</dt>
 							<dd><?php echo $master->NAMA_JENIS_BARANG ?></dd><br>
 							<dt>Gross Weight :</dt>
 							<dd><?php echo $master->GROSS_WEIGHT ?></dd><br>
 							<dt>Nett Weight :</dt>
 							<dd><?php echo $master->NETT_WEIGHT ?></dd><br>
 							<dt>Dimensi :</dt>
 							<dd><?php echo $master->DIMENSI_PANJANG . ' cm x ' . $master->DIMENSI_LEBAR . ' cm x ' . $master->DIMENSI_TINGGI . ' cm' ?></dd>
 						</dl>
 						<h4>Spesifikasi Singkat Produk</h4>
 						<div class=" text-muted">
 							<?php echo $master->SPESIFIKASI_SINGKAT ?>
 						</div>
 						<hr>
 						<button class="btn btn-primary btn-sm" style="font-weight: bold;"><i class="fa fa-download"></i> Download Buku Panduan</button>
 					</div>
 			<?php
					}
				}
				?>
 		</div>
 	</div>

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
 									<th>Tanggal Perolehan</th>
 									<th>Dok. Kartu Garansi</th>
 									<th>Dok. Sertifikat Produk</th>
 									<th>Dok. Lainnya</th>
 									<th>Jenis Kepelmilikan</th>
 									<th>Tanggal Mulai Sewa</th>
 									<th>Tanggal Selesai Sewa</th>
 									<th>Pilihan</th>
 								</tr>
 							</thead>
 							<tbody id="show_data">

 							</tbody>

 						</table>
 					</div>
 					<a href="<?php echo base_url(); ?>index.php/barang_entitas/view_tambah" class="btn btn-success"><span class="fa fa-plus"></span> Tambah Data</a>
 				</div>

 			</div>
 		</div>
 	</div>
 </div>

 <!--MODAL HAPUS-->
 <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
 	<div class="modal-dialog" role="document">
 		<div class="modal-content">
 			<div class="modal-header">
 				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
 				<h4 class="modal-title" id="myModalLabel">Hapus Data barang_entitas</h4>
 			</div>
 			<form class="form-horizontal">
 				<div class="modal-body">

 					<input type="hidden" name="kode" id="textkode" value="">
 					<div class="alert alert-warning">
 						<p>Apakah Anda yakin ingin menghapus data ini?</p>
 						<div name="KODE_BARANG_ENTITAS3" id="KODE_BARANG_ENTITAS3"></div>
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

 		$('#ModalaAdd').on('shown.bs.modal', function() {
 			$('#nama_barang_entitas').focus();
 		});

 		tampil_data_barang_entitas(); //pemanggilan fungsi tampil data.

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
 					title: 'Barang_entitas'
 				},
 				{
 					extend: 'pdf',
 					title: 'Barang_entitas'
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
 				url: '<?php echo base_url() ?>index.php/barang_entitas/data_barang_entitas',
 				async: false,
 				dataType: 'json',
 				success: function(data) {
 					var html = '';
 					var i;
 					for (i = 0; i < data.length; i++) {
 						html += '<tr>' +
 							'<td>' + data[i].KODE_BARANG_ENTITAS + '</td>' +
 							'<td>' + data[i].TANGGAL_PEROLEHAN + '</td>' +
 							'<td>' + data[i].DOK_KARTU_GARANSI + '</td>' +
 							'<td>' + data[i].DOK_SERTIFIKAT_PRODUK + '</td>' +
 							'<td>' + data[i].DOK_LAINNYA + '</td>' +
 							'<td>' + data[i].JENIS_KEPEMILIKAN + '</td>' +
 							'<td>' + data[i].TANGGAL_MULAI_SEWA + '</td>' +
 							'<td>' + data[i].TANGGAL_SELESAI_SEWA + '</td>' +
 							'<td>' +
 							'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="' + data[i].ID_BARANG_ENTITAS + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
 							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="' + data[i].ID_BARANG_ENTITAS + '"><i class="fa fa-trash"></i> Hapus</a>' +
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
 				url: "<?php echo base_url('index.php/barang_entitas/get_data') ?>",
 				dataType: "JSON",
 				data: {
 					id: id
 				},
 				success: function(data) {
 					$.each(data, function(
 						ID_BARANG_ENTITAS,
 						KODE_BARANG_ENTITAS,
 						TANGGAL_PEROLEHAN,
 						DOK_KARTU_GARANSI,
 						DOK_SERTIFIKAT_PRODUK,
 						DOK_LAINNYA,
 						JENIS_KEPEMILIKAN,
 						TANGGAL_MULAI_SEWA,
 						TANGGAL_SELESAI_SEWA) {
 						$('#ModalaEdit').modal('show');
 						$('[name="ID_BARANG_ENTITAS2"]').val(data.ID_BARANG_ENTITAS);
 						$('[name="KODE_BARANG_ENTITAS2"]').val(data.KODE_BARANG_ENTITAS);
 						$('[name="TANGGAL_PEROLEHAN2"]').val(data.TANGGAL_PEROLEHAN);
 						$('[name="DOK_KARTU_GARANSI2"]').val(data.DOK_KARTU_GARANSI);
 						$('[name="DOK_SERTIFIKAT_PRODUK2"]').val(data.DOK_SERTIFIKAT_PRODUK);
 						$('[name="DOK_LAINNYA2"]').val(data.DOK_LAINNYA);
 						$('[name="JENIS_KEPEMILIKAN2"]').val(data.JENIS_KEPEMILIKAN);
 						$('[name="TANGGAL_MULAI_SEWA2"]').val(data.TANGGAL_MULAI_SEWA);
 						$('[name="TANGGAL_SELESAI_SEWA2"]').val(data.TANGGAL_SELESAI_SEWA);
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
 				url: "<?php echo base_url('index.php/barang_entitas/get_data') ?>",
 				dataType: "JSON",
 				data: {
 					id: id
 				},
 				success: function(data) {
 					$.each(data, function(ID_BARANG_ENTITAS, KODE_BARANG_ENTITAS) {
 						$('#ModalHapus').modal('show');
 						$('[name="kode"]').val(id);
 						$('#KODE_BARANG_ENTITAS3').html('Kode Barang Entitas: ' + data.KODE_BARANG_ENTITAS);
 					});
 				}
 			});
 		});

 		//SIMPAN DATA
 		$('#btn_simpan').click(function() {
 			var form_data = {
 				KODE_BARANG_ENTITAS: $('#KODE_BARANG_ENTITAS').val(),
 				TANGGAL_PEROLEHAN: $('#TANGGAL_PEROLEHAN').val(),
 				DOK_KARTU_GARANSI: $('#DOK_KARTU_GARANSI').val(),
 				DOK_SERTIFIKAT_PRODUK: $('#DOK_SERTIFIKAT_PRODUK').val(),
 				DOK_LAINNYA: $('#DOK_LAINNYA').val(),
 				JENIS_KEPEMILIKAN: $('#JENIS_KEPEMILIKAN').val(),
 				TANGGAL_MULAI_SEWA: $('#TANGGAL_MULAI_SEWA').val(),
 				TANGGAL_SELESAI_SEWA: $('#TANGGAL_SELESAI_SEWA').val(),
 			};
 			$.ajax({
 				url: "<?php echo site_url('barang_entitas/simpan_data'); ?>",
 				type: 'POST',
 				data: form_data,
 				success: function(data) {
 					if (data != '') {
 						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
 					} else {
 						$('[name="KODE_BARANG_ENTITAS"]').val("");
 						$('[name="TANGGAL_PEROLEHAN"]').val("");
 						$('[name="DOK_KARTU_GARANSI"]').val("");
 						$('[name="DOK_SERTIFIKAT_PRODUK"]').val("");
 						$('[name="DOK_LAINNYA"]').val("");
 						$('[name="JENIS_KEPEMILIKAN"]').val("");
 						$('[name="TANGGAL_MULAI_SEWA"]').val("");
 						$('[name="TANGGAL_SELESAI_SEWA"]').val("");
 						$('#ModalaAdd').modal('hide');
 						window.location.reload();
 					}
 				}
 			});
 			return false;
 		});

 		//UPDATE DATA 
 		$('#btn_update').on('click', function() {

 			var ID_BARANG_ENTITAS2 = $('#ID_BARANG_ENTITAS2').val();
 			var KODE_BARANG_ENTITA2S = $('#KODE_BARANG_ENTITAS2').val();
 			var TANGGAL_PEROLEHAN2 = $('#TANGGAL_PEROLEHAN2').val();
 			var DOK_KARTU_GARANSI2 = $('#DOK_KARTU_GARANSI2').val();
 			var DOK_SERTIFIKAT_PRODUK2 = $('#DOK_SERTIFIKAT_PRODUK2').val();
 			var DOK_LAINNYA2 = $('#DOK_LAINNYA2').val();
 			var JENIS_KEPEMILIKAN2 = $('#JENIS_KEPEMILIKAN2').val();
 			var TANGGAL_MULAI_SEWA2 = $('#TANGGAL_MULAI_SEWA2').val();
 			var TANGGAL_SELESAI_SEWA2 = $('#TANGGAL_SELESAI_SEWA2').val();


 			$.ajax({
 				url: "<?php echo site_url('barang_entitas/update_data') ?>",
 				type: "POST",
 				dataType: "JSON",
 				data: {
 					ID_BARANG_ENTITAS2: ID_BARANG_ENTITAS2,
 					KODE_BARANG_ENTITAS2: KODE_BARANG_ENTITAS2,
 					TANGGAL_PEROLEHAN2: TANGGAL_PEROLEHAN2,
 					DOK_KARTU_GARANSI2: DOK_KARTU_GARANSI2,
 					DOK_SERTIFIKAT_PRODUK2: DOK_SERTIFIKAT_PRODUK2,
 					DOK_LAINNYA2: DOK_LAINNYA2,
 					JENIS_KEPEMILIKAN2: JENIS_KEPEMILIKAN2,
 					TANGGAL_MULAI_SEWA2: TANGGAL_MULAI_SEWA2,
 					TANGGAL_SELESAI_SEWA2: TANGGAL_SELESAI_SEWA2
 				},
 				success: function(data) {
 					if (data == true) {
 						$('#ModalaEdit').modal('hide');
 						$('[name="ID_BARANG_ENTITAS2"]').val("");
 						$('[name="KODE_BARANG_ENTITA2S"]').val("");
 						$('[name="TANGGAL_PEROLEHAN2"]').val("");
 						$('[name="DOK_KARTU_GARANSI2"]').val("");
 						$('[name="DOK_SERTIFIKAT_PRODUK2"]').val("");
 						$('[name="DOK_LAINNYA2"]').val("");
 						$('[name="JENIS_KEPEMILIKAN2"]').val("");
 						$('[name="TANGGAL_MULAI_SEWA2"]').val("");
 						$('[name="TANGGAL_SELESAI_SEWA2"]').val("");

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