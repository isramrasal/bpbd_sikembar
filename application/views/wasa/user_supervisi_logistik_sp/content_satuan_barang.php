<div class="row wrapper border-bottom white-bg page-heading">
 	<div class="col-lg-10">
 		<h2>List Satuan Barang</h2>
 		<ol class="breadcrumb">
 			<li>
 				<a href="index.html">Home</a>
 			</li>
 			<li class="active">
 				<strong>
 					<a>Satuan Barang</a>
 				</strong>
 			</li>
 		</ol>
 	</div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">

 	<div class="alert alert-danger alert-dismissable">
 		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
 		Pastikan Anda Mengisi Data Dengan Benar.
 	</div>

 	<div class="alert alert-info alert-dismissable">
 		<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
 		Sistem Menampilkan Seluruh Satuan Barang.
 	</div>

 	<div class="row">
 		<div class="col-lg-12">
 			<div class="ibox float-e-margins">
 				<div class="ibox-title">
 					<h5>Satuan Barang</h5>
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
 									<th>Nama Satuan Barang</th>
 									<th class="col-xs-1">Pilihan</th>
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
 				<h4 class="modal-title">Satuan Barang</h4>
 				<small class="font-bold">Silakan Isi Data Satuan Barang</small>
 			</div>
 			<?php $attributes = array("NAMA_SATUAN_BARANG" => "contact_form", "id" => "contact_form");
				echo form_open("jabatan/simpan_data", $attributes); ?>
 			<div class="form-horizontal">
 				<div class="modal-body">

 					<div class="form-group">
 						<label class="control-label col-xs-3">Nama Satuan Barang</label>
 						<div class="col-xs-9">
 							<input name="NAMA_SATUAN_BARANG" id="NAMA_SATUAN_BARANG" class="form-control" type="text" placeholder="Contoh : Unit" required autofocus>
 						</div>
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
<!--END MODAL ADD-->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
 	<div class="modal-dialog">
 		<div class="modal-content animated bounceInRight">
 			<div class="modal-header">
 				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
 				<i class="fa fa-group modal-icon"></i>
 				<h4 class="modal-title">Satuan Barang</h4>
 				<small class="font-bold">Silakan edit data jenis barang</small>
 			</div>
 			<?php $attributes = array("id_satuan_barang2" => "contact_form", "id" => "contact_form");
				echo form_open("satuan_barang/update_data", $attributes); ?>
 			<div class="form-horizontal">
 				<div class="modal-body">

 					<!-- <div class="form-group">
 						<label class="control-label col-xs-3">ID Satuan Barang</label>
 						<div class="col-xs-9"> -->
 							<input name="ID_SATUAN_BARANG2" id="ID_SATUAN_BARANG2" class="form-control" type="hidden" placeholder="ID jenis barang" readonly>
 						<!-- </div>
 					</div> -->

 					<div class="form-group">
 						<label class="control-label col-xs-3">Nama Satuan Barang</label>
 						<div class="col-xs-9">
 							<input name="NAMA_SATUAN_BARANG2" id="NAMA_SATUAN_BARANG2" class="form-control" type="text" placeholder="Contoh : Unit" required>
 						</div>
 					</div>

 					<div id="alert-msg-2"></div>

 				</div>

 				<div class="modal-footer">
 					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
 					<button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Update</button>
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
 				<h4 class="modal-title" id="myModalLabel">Hapus Data jenis barang</h4>
 			</div>
 			<form class="form-horizontal">
 				<div class="modal-body">

 					<input type="hidden" name="kode" id="textkode" value="">
 					<div class="alert alert-warning">
 						<p>Apakah Anda yakin ingin menghapus data ini?</p>
 						<div name="NAMA_SATUAN_BARANG_3" id="NAMA_SATUAN_BARANG_3"></div>
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
 			$('#NAMA_SATUAN_BARANG').focus();
 		});

 		tampil_data_satuan_barang(); //pemanggilan fungsi tampil data.

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
 					title: 'Satuan Barang'
 				},
 				{
 					extend: 'pdf',
 					title: 'Satuan Barang'
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
 		function tampil_data_satuan_barang() {
 			$.ajax({
 				type: 'ajax',
 				url: '<?php echo base_url() ?>satuan_barang/data_satuan_barang',
 				async: false,
 				dataType: 'json',
 				success: function(data) {
 					var html = '';
 					var i;
 					for (i = 0; i < data.length; i++) {
 						html += '<tr>' +
 							'<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
 							'<td>' +
 							'<a href="javascript:;" class="btn btn-info btn-xs item_edit block" data="' + data[i].ID_SATUAN_BARANG + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
 							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_SATUAN_BARANG + '"><i class="fa fa-trash"></i> Hapus</a>' +
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
 				url: "<?php echo base_url('satuan_barang/get_data') ?>",
 				dataType: "JSON",
 				data: {
 					id: id
 				},
 				success: function(data) {
 					$.each(data, function(
 						ID_SATUAN_BARANG,
 						NAMA_SATUAN_BARANG) {
 						$('#ModalaEdit').modal('show');
 						$('[name="ID_SATUAN_BARANG2"]').val(data.ID_SATUAN_BARANG);
 						$('[name="NAMA_SATUAN_BARANG2"]').val(data.NAMA_SATUAN_BARANG);
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
 				url: "<?php echo base_url('satuan_barang/get_data') ?>",
 				dataType: "JSON",
 				data: {
 					id: id
 				},
 				success: function(data) {
 					$.each(data, function(ID_SATUAN_BARANG, NAMA_SATUAN_BARANG) {
 						$('#ModalHapus').modal('show');
 						$('[name="kode"]').val(id);
 						$('#NAMA_SATUAN_BARANG_3').html('Nama Satuan Barang: ' + data.NAMA_SATUAN_BARANG);
 					});
 				}
 			});
 		});

 		//SIMPAN DATA
 		$('#btn_simpan').click(function() {
 			var form_data = {
 				NAMA_SATUAN_BARANG: $('#NAMA_SATUAN_BARANG').val(),
 			};
 			$.ajax({
 				url: "<?php echo site_url('satuan_barang/simpan_data'); ?>",
 				type: 'POST',
 				data: form_data,
 				success: function(data) {
 					if (data != '') {
 						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
 					} else {
 						$('[name="NAMA_SATUAN_BARANG"]').val("");
 						$('#ModalaAdd').modal('hide');
 						window.location.reload();
 					}
 				}
 			});
 			return false;
 		});

 		//UPDATE DATA 
 		$('#btn_update').on('click', function() {

 			var ID_SATUAN_BARANG2 = $('#ID_SATUAN_BARANG2').val();
 			var NAMA_SATUAN_BARANG2 = $('#NAMA_SATUAN_BARANG2').val();

 			$.ajax({
 				url: "<?php echo site_url('satuan_barang/update_data') ?>",
 				type: "POST",
 				dataType: "JSON",
 				data: {
 					ID_SATUAN_BARANG2: ID_SATUAN_BARANG2,
 					NAMA_SATUAN_BARANG2: NAMA_SATUAN_BARANG2
 				},
 				success: function(data) {
 					if (data == true) {
 						$('#ModalaEdit').modal('hide');
 						$('[name="ID_SATUAN_BARANG2"]').val("");
 						$('[name="NAMA_SATUAN_BARANG2"]').val("");
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
 				url: "<?php echo base_url('satuan_barang/hapus_data') ?>",
 				dataType: "JSON",
 				data: {
 					kode: kode
 				},
 				success: function(data) {
 					$('#ModalHapus').modal('hide');
 					tampil_data_satuan_barang();
 					window.location.reload();
 				}
 			});
 			return false;
 		});

 	});
</script>

</body>

</html>