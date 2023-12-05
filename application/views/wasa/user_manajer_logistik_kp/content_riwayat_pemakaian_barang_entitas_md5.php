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
									<th>Pilihan</th>
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

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-suitcase modal-icon"></i>
				<h4 class="modal-title">Identitas Form Riwayat Pemakaian Barang</h4>

			</div>
			<?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
			echo form_open("FPB/simpan_data", $attributes); ?>

			<input type="hidden" class="form-control" value="" name="ID_PROYEK" id="ID_PROYEK" disabled />
			<input type="hidden" class="form-control" value="" name="ID_PEGAWAI" id="ID_PEGAWAI" disabled />
			<input type="hidden" class="form-control" value="" name="ID_BARANG_MASTER" id="ID_BARANG_MASTER" disabled />
			<input type="hidden" class="form-control" value="" name="ID_BARANG_ENTITAS" id="ID_BARANG_ENTITAS" disabled />


			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Proyek</label>
						<div class="col-xs-9">
							<select name="NAMA_PROYEK" class="form-control" id="NAMA_PROYEK">
								<option value=''>- Pilih Proyek -</option>
								<?php foreach ($proyek_list as $prov) {
									echo '<option value="' . $prov->NAMA_PROYEK  . '">' . $prov->NAMA_PROYEK . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Departemen</label>
						<div class="col-xs-9">
							<select name="DEPARTEMEN" class="form-control" id="DEPARTEMEN">
								<option value=''>- Pilih Departemen -</option>
								<?php foreach ($departemen_list as $prov) {
									echo '<option value="' . $prov->NAMA_DEPARTEMEN  . '">' . $prov->NAMA_DEPARTEMEN . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Pegawai</label>
						<div class="col-xs-9">
							<select name="NAMA_PEGAWAI" class="form-control" id="NAMA_PEGAWAI">
								<option value=''>- Pilih Pegawai -</option>
								<?php foreach ($pegawai_list as $prov) {
									echo '<option value="' . $prov->NAMA_PEGAWAI  . '">' . $prov->NAMA_PEGAWAI . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Keterangan</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="KETERANGAN" id="KETERANGAN" placeholder="Untuk Mengerjakan Proyek A" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Tanggal Mulai Pemakaian</label>
						<div class="col-xs-9">
							<input type="date" class="form-control" name="TANGGAL_MULAI_PEMAKAIAN_HARI" id="TANGGAL_MULAI_PEMAKAIAN_HARI">
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Tanggal Selesai Pemakaian</label>
						<div class="col-xs-9">
							<input type="date" class="form-control" name="TANGGAL_SELESAI_PEMAKAIAN_HARI" id="TANGGAL_SELESAI_PEMAKAIAN_HARI">
						</div>
					</div>

					<div id="alert-msg"></div>

					<div class="form-group">
						<div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses identitas form Pemakaian ini dan menyetujui untuk proses selanjutnya </label></div>
					</div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" name="btn_simpan" id="btn_simpan" disabled><i class="fa fa-save"></i> Buat RPB</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END MODAL ADD-->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Identitas Form Riwayat Pemakaian Barang</h4>
			</div>
			<?php $attributes = array("ID_R_PEMAKAIAN_B_E_2" => "contact_form", "id" => "contact_form");
			echo form_open("RFQ_form/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">


					<input name="ID_R_PEMAKAIAN_B_E_2" id="ID_R_PEMAKAIAN_B_E_2" class="form-control" type="hidden" readonly>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Pegawai :</label>
						<div class="col-xs-9">
							<select name="NAMA_PEGAWAI_2" class="form-control" id="NAMA_PEGAWAI_2">
								<option value=''>- Pilih Pegawai -</option>
								<?php foreach ($pegawai_list as $prov) {
									echo '<option value="' . $prov->NAMA_PEGAWAI  . '">' . $prov->NAMA_PEGAWAI . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Proyek :</label>
						<div class="col-xs-9">
							<select name="NAMA_PROYEK_2" class="form-control" id="NAMA_PROYEK_2">
								<option value=''>- Pilih Proyek -</option>
								<?php foreach ($proyek_list as $prov) {
									echo '<option value="' . $prov->NAMA_PROYEK  . '">' . $prov->NAMA_PROYEK . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Departemen :</label>
						<div class="col-xs-9">
							<select name="DEPARTEMEN_2" class="form-control" id="DEPARTEMEN_2">
								<option value=''>- Pilih Departemen -</option>
								<?php foreach ($departemen_list as $prov) {
									echo '<option value="' . $prov->NAMA_DEPARTEMEN  . '">' . $prov->NAMA_DEPARTEMEN . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Keterangan :</label>
						<div class="col-xs-9">
							<input type="text" class="form-control" name="KETERANGAN_2" id="KETERANGAN_2" placeholder="Untuk Mengerjakan Proyek A" />
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Tanggal Mulai Pemakaian :</label>
						<div class="col-xs-9">
							<input type="date" class="form-control" name="TANGGAL_MULAI_PEMAKAIAN_HARI_2" id="TANGGAL_MULAI_PEMAKAIAN_HARI_2">
						</div>
					</div>

					<div class="form-group">
						<label class="col-xs-3 control-label">Tanggal Selesai Pemakaian :</label>
						<div class="col-xs-9">
							<input type="date" class="form-control" name="TANGGAL_SELESAI_PEMAKAIAN_HARI_2" id="TANGGAL_SELESAI_PEMAKAIAN_HARI_2">
						</div>
					</div>

					<div id="alert-msg-2"></div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Ubah</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END MODAL EDIT-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Riwayat Pemakaian Barang</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda Yakin Ingin Menghapus Data Ini?</p>
                        <div name="NAMA_PEGAWAI_3" id="NAMA_PEGAWAI_3"></div>
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
				url: '<?php echo base_url() ?>index.php/Riwayat_pemakaian_barang_entitas/data_riwayat_pemakaian_barang_entitas',
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
							'<td>' +
							'<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_R_PEMAKAIAN_B_E + '"><i class="fa fa-pencil"></i> Ubah </a>' + ' ' +
							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_R_PEMAKAIAN_B_E + '"><i class="fa fa-trash"></i> Hapus</a>' +
							'</td>' +
							'</tr>';
					}
					$('#show_data').html(html);
				}

			});
		}

		//GET UPDATE untuk edit Riwayat
		$('#show_data').on('click', '.item_edit', function() {
			var id = $(this).attr('data');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('Riwayat_pemakaian_barang_entitas/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function() {
						$('#ModalEdit').modal('show');
						$('[name="ID_R_PEMAKAIAN_B_E_2"]').val(data.ID_R_PEMAKAIAN_B_E);
						$('[name="DEPARTEMEN_2"]').val(data.DEPARTEMEN);
						$('[name="KETERANGAN_2"]').val(data.KETERANGAN);
						$('[name="NAMA_PEGAWAI_2"]').val(data.NAMA_PEGAWAI);
						$('[name="NAMA_PROYEK_2"]').val(data.NAMA_PROYEK);
						$('[name="TANGGAL_MULAI_PEMAKAIAN_HARI_2"]').val(data.TANGGAL_MULAI_PEMAKAIAN_HARI);
						$('[name="TANGGAL_SELESAI_PEMAKAIAN_HARI_2"]').val(data.TANGGAL_SELESAI_PEMAKAIAN_HARI);
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
                url: "<?php echo base_url('Riwayat_pemakaian_barang_entitas/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(id);
                        $('#NAMA_PEGAWAI_3').html('</br>Nama Pegawai : ' + data.NAMA_PEGAWAI);

                    });
                }
            });
        });

		//UPDATE DATA 
		$('#btn_update').on('click', function() {

			let ID_R_PEMAKAIAN_B_E = $('#ID_R_PEMAKAIAN_B_E_2').val();
			let DEPARTEMEN = $('#DEPARTEMEN_2').val();
			let KETERANGAN = $('#KETERANGAN_2').val();
			let NAMA_PEGAWAI = $('#NAMA_PEGAWAI_2').val();
			let NAMA_PROYEK = $('#NAMA_PROYEK_2').val();
			let TANGGAL_MULAI_PEMAKAIAN_HARI = $('#TANGGAL_MULAI_PEMAKAIAN_HARI_2').val();
			let TANGGAL_SELESAI_PEMAKAIAN_HARI = $('#TANGGAL_SELESAI_PEMAKAIAN_HARI_2').val();

			$.ajax({
				url: "<?php echo site_url('Riwayat_pemakaian_barang_entitas/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_R_PEMAKAIAN_B_E: ID_R_PEMAKAIAN_B_E,
					DEPARTEMEN: DEPARTEMEN,
					KETERANGAN: KETERANGAN,
					NAMA_PEGAWAI: NAMA_PEGAWAI,
					NAMA_PROYEK: NAMA_PROYEK,
					TANGGAL_MULAI_PEMAKAIAN_HARI: TANGGAL_MULAI_PEMAKAIAN_HARI,
					TANGGAL_SELESAI_PEMAKAIAN_HARI: TANGGAL_SELESAI_PEMAKAIAN_HARI
				},
				success: function(data) {
					if (data == true) {
						$('#ModalEdit').modal('hide');
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
                url: "<?php echo base_url('Riwayat_pemakaian_barang_entitas/hapus_data') ?>",
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

		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				ID_PROYEK: $('#ID_PROYEK').val(),
				ID_PEGAWAI: $('#ID_PEGAWAI').val(),
				ID_BARANG_MASTER: $('#ID_BARANG_MASTER').val(),
				ID_BARANG_ENTITAS: $('#ID_BARANG_ENTITAS').val(),
				NAMA_PEGAWAI: $('#NAMA_PEGAWAI').val(),
				NAMA_PROYEK: $('#NAMA_PROYEK').val(),
				DEPARTEMEN: $('#DEPARTEMEN').val(),
				KETERANGAN: $('#KETERANGAN').val(),
				TANGGAL_MULAI_PEMAKAIAN_HARI: $('#TANGGAL_MULAI_PEMAKAIAN_HARI').val(),
				TANGGAL_SELESAI_PEMAKAIAN_HARI: $('#TANGGAL_SELESAI_PEMAKAIAN_HARI').val()
			};
			$.ajax({
				url: "<?php echo site_url('Riwayat_pemakaian_barang_entitas/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data == true) {
						$('#ModalaAdd').modal('hide');
						window.location.reload();
					} else {
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					}
				}
			});
			return false;
		});

	});
</script>

</body>

</html>