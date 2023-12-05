<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>List Riwayat Perbaikan Barang Entitas</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/Riwayat_pemakaian_barang_entitas/') ?>">Riwayat Perbaikan Barang Entitas</a>
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
		Sistem menampilkan seluruh riwayat perbaikan barang.
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
												<h2 class="product-main-price"><b>Nama Barang Master:</b></h2>
												<h2><?php echo $data_barang_master->NAMA; ?></h2>
											</div>
											<hr>
											<div class="m-t-md">
												<h4 class="product-main-price"><b>Alias:</b></h4>
												<?php echo $data_barang_master->ALIAS; ?>
											</div>
											<hr>
											<div class="m-t-md">
												<h4 class="product-main-price"><b>Kode Barang:</b></h4>
												<?php echo $data_barang_master->KODE_BARANG; ?>
											</div>
											<div class="m-t-md">
												<h4 class="product-main-price"><b>Merek:</b></h4>
												<?php echo $data_barang_master->MEREK; ?>
											</div>
											<hr>
											<!-- <h4>Spesifikasi Produk</h4> -->
											<div class="m-t-md">
												<h4 class="product-main-price"><b>Jenis Barang:</b></h4>
												<?php echo $data_barang_master->NAMA_JENIS_BARANG; ?>
											</div>
											<div class="m-t-md">
												<h4 class="product-main-price"><b>Peralatan Perlengkapan:</b></h4>
												<?php echo $data_barang_master->PERALATAN_PERLENGKAPAN; ?>
											</div>
											<div class="m-t-md">
												<h4 class="product-main-price"><b>Satuan Barang:</b></h4>
												<?php echo $data_barang_master->NAMA_SATUAN_BARANG; ?>
											</div>
											<div class="m-t-md">
												<h4 class="product-main-price"><b>Gross Weight:</b></h4>
												<?php echo $data_barang_master->GROSS_WEIGHT; ?>
											</div>
											<div class="m-t-md">
												<h4 class="product-main-price"><b>Nett Weight:</b></h4>
												<?php echo $data_barang_master->NETT_WEIGHT; ?>
											</div>
											<div class="m-t-md">
												<h4 class="product-main-price"><b>Dimensi:</b></h4>
												<?php echo $data_barang_master->DIMENSI_PANJANG . ' cm x ' . $data_barang_master->DIMENSI_LEBAR . ' cm x ' . $data_barang_master->DIMENSI_TINGGI . ' cm'; ?>
											</div>
											<hr>
											<div class="m-t-md">
												<h4 class="product-main-price">Spesifikasi Lengkap Produk:</h4>
												<?php echo $data_barang_master->SPESIFIKASI_LENGKAP; ?>
											</div>
											<div class="m-t-md">
												<h4 class="product-main-price">Spesifikasi Singkat Produk:</h4>
												<?php echo $data_barang_master->SPESIFIKASI_SINGKAT; ?>
											</div>
											<div class="m-t-md">
												<h4 class="product-main-price">Cara Singkat Penggunaan:</h4>
												<?php echo $data_barang_master->CARA_SINGKAT_PENGGUNAAN; ?>
											</div>
											<div class="m-t-md">
												<h4 class="product-main-price">Cara Penyimpanan Barang: <br></h4>
												<?php echo $data_barang_master->CARA_PENYIMPANAN_BARANG; ?>
											</div>
											<div class="m-t-md">
												<h4 class="product-main-price">Masa Pakai: <br></h4>
												<?php echo $data_barang_master->MASA_PAKAI; ?>
											</div>
											<hr>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Riwayat Perbaikan Barang</h5>
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
									<th>Nama Barang</th>
									<th>Merek Barang</th>
									<th>Kode Barang Entitas</th>
									<th>Status Kepemilikan</th>
									<th>Lokasi Service</th>
									<th>Keterangan</th>
									<th>Tanggal Mulai Perbaikan</th>
									<th>Tanggal Selesai Perbaikan</th>
									<th>Pilihan</th>
								</tr>
							</thead>
							<tbody id="show_data">
							</tbody>
						</table>
					</div>
					<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Tambah Data</a>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-suitcase modal-icon"></i>
				<h4 class="modal-title">Identitas Form Riwayat Perbaikan Barang</h4>
			</div>

			<?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
			echo form_open("FPB/simpan_data", $attributes); ?>

			<input type="hidden" class="form-control" value='<?php echo $ID_BARANG_MASTER; ?>' name="ID_BARANG_MASTER" id="ID_BARANG_MASTER" disabled />
			<input type="hidden" class="form-control" value='<?php echo $ID_BARANG_ENTITAS; ?>' name="ID_BARANG_ENTITAS" id="ID_BARANG_ENTITAS" disabled />

			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Barang</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="NAMA_BARANG" id="NAMA_BARANG" value='<?php echo $NAMA; ?>' disabled />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Merek</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="MEREK_BARANG" id="MEREK_BARANG" value='<?php echo $MEREK; ?>' disabled />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Kode Barang</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="KODE_BARANG" id="KODE_BARANG" value='<?php echo $KODE_BARANG; ?>' disabled />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Status Kepemilikan</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="STATUS_KEPEMILIKAN" id="STATUS_KEPEMILIKAN" value='<?php echo $STATUS_KEPEMILIKAN; ?>' disabled />
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Lokasi Service</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="LOKASI_SERVICE" id="LOKASI_SERVICE" placeholder="Contoh : PT Dwindo Berlian Samjaya, Raden Inten Jakarta Timur" />
						</div>
					</div>

					<div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>

                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="KETERANGAN" id="KETERANGAN" placeholder="Contoh : Service Berkala"></textarea>
                        </div>
                    </div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Tanggal Mulai Perbaikan</label>
						<div class="col-xs-9">
							<input type="date" class="form-control" name="TANGGAL_MULAI_SERVICE_HARI" id="TANGGAL_MULAI_SERVICE_HARI">
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Tanggal Selesai Perbaikan</label>
						<div class="col-xs-9">
							<input type="date" class="form-control" name="TANGGAL_SELESAI_SERVICE_HARI" id="TANGGAL_SELESAI_SERVICE_HARI">
						</div>
					</div>

					<div id="alert-msg"></div>

					<div class="form-group">
						<div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses pengisian form Riwayat Perbaikan Barang ini dan menyetujui untuk proses selanjutnya </label></div>
					</div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" name="btn_simpan" id="btn_simpan" disabled><i class="fa fa-save"></i> Buat Perbaikan</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END MODAL ADD-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
				<h4 class="modal-title" id="myModalLabel">Hapus Data Riwayat Perbaikan Barang</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" name="kode" id="textkode" value="">
					<div class="alert alert-warning">
						<p>Apakah Anda Yakin Ingin Menghapus Data Ini?</p>
						<div name="ID_R_PERBAIKAN_B_E_3" id="ID_R_PERBAIKAN_B_E_3"></div>
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

<!-- MODAL EDIT-->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Identitas Form Riwayat Perbaikan Barang</h4>
			</div>

			<div class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" class="form-control" value='<?php echo $ID_R_PERBAIKAN_B_E; ?>' name="ID_R_PERBAIKAN_B_E5" id="ID_R_PERBAIKAN_B_E5" disabled />

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Barang</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="NAMA_BARANG5" id="NAMA_BARANG5" value='<?php echo $NAMA; ?>' disabled />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Merek</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="MEREK_BARANG5" id="MEREK_BARANG5" value='<?php echo $MEREK; ?>' disabled />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Kode Barang Entitas</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="KODE_BARANG_ENTITAS5" id="KODE_BARANG_ENTITAS5" value='<?php echo $KODE_BARANG_ENTITAS; ?>' disabled />
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Status Kepemilikan</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="STATUS_KEPEMILIKAN5" id="STATUS_KEPEMILIKAN5" value='<?php echo $STATUS_KEPEMILIKAN; ?>' disabled />
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Lokasi Service</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="LOKASI_SERVICE5" id="LOKASI_SERVICE5" placeholder="Contoh : PT Dwindo Berlian Samjaya, Raden Inten Jakarta Timur" />
						</div>
					</div>

					<div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>

                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="KETERANGAN5" id="KETERANGAN5" placeholder="Contoh : Service Berkala"></textarea>
                        </div>
                    </div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Tanggal Mulai Perbaikan</label>
						<div class="col-xs-9">
							<input type="date" class="form-control" name="TANGGAL_MULAI_SERVICE_HARI5" id="TANGGAL_MULAI_SERVICE_HARI5">
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Tanggal Selesai Perbaikan</label>
						<div class="col-xs-9">
							<input type="date" class="form-control" name="TANGGAL_SELESAI_SERVICE_HARI5" id="TANGGAL_SELESAI_SERVICE_HARI5">
						</div>
					</div>

					<div id="alert-msg-5"></div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END MODAL EDIT-->

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

		$('#saya_setuju').click(function() {
			//check if checkbox is checked
			if ($(this).is(':checked')) {

				$('#btn_simpan').removeAttr('disabled'); //enable input

			} else {
				$('#btn_simpan').attr('disabled', true); //disable input
			}
		});

		tampil_data_riwayat_perbaikan_barang(); //pemanggilan fungsi tampil data.

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
					title: 'Riwayat Perbaikan Barang'
				},
				{
					extend: 'pdf',
					title: 'Riwayat Perbaikan Barang'
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
		function tampil_data_riwayat_perbaikan_barang() {
			var id = <?php echo $ID_BARANG_ENTITAS; ?>;
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url() ?>index.php/Riwayat_perbaikan_barang_entitas/data_riwayat_perbaikan_barang_entitas',
				async: false,
				dataType: 'json',
				data: {
					id: id
				},
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<tr>' +
							'<td>' + data[i].NAMA + '</td>' +
							'<td>' + data[i].MEREK + '</td>' +
							'<td>' + data[i].KODE_BARANG_ENTITAS + '</td>' +
							'<td>' + data[i].STATUS_KEPEMILIKAN + '</td>' +
							'<td>' + data[i].LOKASI_SERVICE + '</td>' +
							'<td>' + data[i].KETERANGAN + '</td>' +
							'<td>' + data[i].TANGGAL_MULAI_SERVICE_HARI + '</td>' +
							'<td>' + data[i].TANGGAL_SELESAI_SERVICE_HARI + '</td>' +
							'<td>' +
							'<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_R_PERBAIKAN_B_E + '"><i class="fa fa-pencil"></i> Edit</a>' + ' ' +
							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_R_PERBAIKAN_B_E + '"><i class="fa fa-trash"></i> Hapus</a>' +
							'</td>' +
							'</tr>';
					}
					$('#show_data').html(html);
				}
			});
		}

		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				ID_BARANG_MASTER: $('#ID_BARANG_MASTER').val(),
				ID_BARANG_ENTITAS: $('#ID_BARANG_ENTITAS').val(),
				LOKASI_SERVICE: $('#LOKASI_SERVICE').val(),
				KETERANGAN: $('#KETERANGAN').val(),
				TANGGAL_MULAI_SERVICE_HARI: $('#TANGGAL_MULAI_SERVICE_HARI').val(),
				TANGGAL_SELESAI_SERVICE_HARI: $('#TANGGAL_SELESAI_SERVICE_HARI').val()
			};
			console.log(form_data);
			$.ajax({
				url: "<?php echo site_url('Riwayat_perbaikan_barang_entitas/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data == true) {
						$('#ModalAdd').modal('hide');
						window.location.reload();
					} else {
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					}
				}
			});
			return false;
		});

		//GET UDPATE
		$('#show_data').on('click', '.item_edit', function() {
			var id = $(this).attr('data');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('Riwayat_perbaikan_barang_entitas/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {

					$('#ModalEdit').modal('show');
					$('[name="ID_R_PERBAIKAN_B_E5"]').val(data.ID_R_PERBAIKAN_B_E);
					$('[name="NAMA_BARANG5"]').val(data.NAMA);
					$('[name="MEREK_BARANG5"]').val(data.MEREK);
					$('[name="KODE_BARANG_ENTITAS5"]').val(data.KODE_BARANG_ENTITAS);
					$('[name="STATUS_KEPEMILIKAN5"]').val(data.STATUS_KEPEMILIKAN);
					$('[name="LOKASI_SERVICE5"]').val(data.LOKASI_SERVICE);
					$('[name="KETERANGAN5"]').val(data.KETERANGAN);
					$('[name="TANGGAL_MULAI_SERVICE_HARI5"]').val(data.TANGGAL_MULAI_SERVICE_HARI);
					$('[name="TANGGAL_SELESAI_SERVICE_HARI5"]').val(data.TANGGAL_SELESAI_SERVICE_HARI);

				}
			});
			return false;
		});

		//UPDATE DATA 
		$('#btn_update').on('click', function() {
			var form_data = {
				ID_R_PERBAIKAN_B_E: $('#ID_R_PERBAIKAN_B_E5').val(),
				NAMA_BARANG: $('#NAMA_BARANG5').val(),
				MEREK_BARANG: $('#MEREK_BARANG5').val(),
				KODE_BARANG: $('#KODE_BARANG5').val(),
				STATUS_KEPEMILIKAN: $('#STATUS_KEPEMILIKAN5').val(),
				LOKASI_SERVICE: $('#LOKASI_SERVICE5').val(),
				KETERANGAN: $('#KETERANGAN5').val(),
				TANGGAL_MULAI_SERVICE_HARI: $('#TANGGAL_MULAI_SERVICE_HARI5').val(),
				TANGGAL_SELESAI_SERVICE_HARI: $('#TANGGAL_SELESAI_SERVICE_HARI5').val()
			};
			$.ajax({
				url: "<?php echo site_url('Riwayat_perbaikan_barang_entitas/update_data') ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data == true) {
						$('#ModalaEdit').modal('hide');
						window.location.reload();
					} else {
						$('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
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
				url: "<?php echo base_url('index.php/Riwayat_perbaikan_barang_entitas/hapus_data') ?>",
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

		//GET HAPUS
		$('#show_data').on('click', '.item_hapus', function() {
			var id = $(this).attr('data');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('index.php/Riwayat_perbaikan_barang_entitas/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_R_PERBAIKAN_B_E, NAMA, TANGGAL_MULAI_SERVICE_HARI, TANGGAL_SELESAI_SERVICE_HARI) {
						$('#ModalHapus').modal('show');
						$('[name="kode"]').val(id);
						$('#ID_R_PERBAIKAN_B_E_3').html('Nama Barang: ' + data.NAMA + '<br>' + 'Tanggal Mulai Service: ' + data.TANGGAL_MULAI_SERVICE_HARI + '<br>' + 'Tanggal Selesai Service: ' + data.TANGGAL_SELESAI_SERVICE_HARI);
					});
				}
			});
		});
	});
</script>

</body>

</html>