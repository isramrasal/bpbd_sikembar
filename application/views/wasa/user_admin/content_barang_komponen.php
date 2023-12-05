 <div class="row wrapper border-bottom white-bg page-heading">
 	<div class="col-lg-10">
 		<h2>List Barang Komponen</h2>
 		<ol class="breadcrumb">
 			<li>
 				<a href="index.html">Home</a>
 			</li>
 			<li class="active">
 				<strong>
 					<a>Barang Komponen</a>
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
 		Sistem menampilkan seluruh barang komponen.
 	</div>

 	<div class="row">
 		<div class="col-lg-12">
 			<div class="ibox float-e-margins">
 				<div class="ibox-title">
 					<h5>Barang Komponen</h5>
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
 									<th>Nama Komponen</th>
 									<th>Kategori</th>
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
 </br>

 <div class="footer">
 	<div>
 		<p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br /> Hak cipta dilindungi undang-undang.</p>
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
 				<h4 class="modal-title">Barang Komponen</h4>
 				<small class="font-bold">Silakan isi data Barang Komponen</small>
 			</div>
 			<?php $attributes = array("name" => "contact_form", "id" => "contact_form");
				echo form_open("barang_komponen/simpan_data", $attributes); ?>
 			<div class="form-horizontal">
 				<div class="modal-body">

 					<div class="form-group">
 						<label class="control-label col-xs-3">Nama Komponen</label>
 						<div class="col-xs-9">
 							<input name="NAMA_KOMPONEN" id="NAMA_KOMPONEN" class="form-control" type="text" placeholder="Nama Komponen.." required autofocus>
 						</div>
 					</div>
 					<div class="form-group">
 						<label class="control-label col-xs-3">Nama Kategori</label>
 						<div class="col-xs-9">
 							<select name="NAMA_KATEGORI" class="form-control" id="NAMA_KATEGORI">
 								<option value=''>- Pilih Kategori -</option>
 								<?php foreach ($kategori as $kategori) {
										echo '<option value="' . $kategori->ID_KATEGORI_BARANG_KOMPONEN . '">' . $kategori->NAMA_KATEGORI  . '</option>';
									} ?>
 							</select>
 						</div>
 					</div>

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
 				<h4 class="modal-title">Barang Komponen</h4>
 				<small class="font-bold">Silakan edit data barang komponen</small>
 			</div>
 			<?php $attributes = array("id_barang_komponen2" => "contact_form", "id" => "contact_form");
				echo form_open("barang_komponen/update_data", $attributes); ?>
 			<div class="form-horizontal">
 				<div class="modal-body">

 					<div class="form-group">
 						<label class="control-label col-xs-3">ID Barang Komponen</label>
 						<div class="col-xs-9">
 							<input name="ID_BARANG_KOMPONEN2" id="ID_BARANG_KOMPONEN2" class="form-control" type="text" placeholder="ID barang komponen" readonly>
 						</div>
 					</div>

 					<div class="form-group">
 						<label class="control-label col-xs-3">Nama Komponen</label>
 						<div class="col-xs-9">
 							<input name="NAMA_KOMPONEN2" id="NAMA_KOMPONEN2" class="form-control" type="text" placeholder="Nama  Komponen.." required>
 						</div>
 					</div>

 					<div class="form-group">
 						<label class="control-label col-xs-3">Nama Kategori</label>
 						<div class="col-xs-9">
 							<select name="NAMA_KATEGORI2" class="form-control" id="NAMA_KATEGORI2">
 								<option value=''>- Pilih Kategori -</option>
 								<?php foreach ($kategori as $kategori) {
										echo '<option value="' . $kategori->ID_KATEGORI_BARANG_KOMPONEN . '">' . $kategori->NAMA_KATEGORI  . '</option>';
									} ?>
 							</select>
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
 				<h4 class="modal-title" id="myModalLabel">Hapus Data barang komponen</h4>
 			</div>
 			<form class="form-horizontal">
 				<div class="modal-body">

 					<input type="hidden" name="kode" id="textkode" value="">
 					<div class="alert alert-warning">
 						<p>Apakah Anda yakin ingin menghapus data ini?</p>
 						<div name="NAMA_KOMPONEN_3" id="NAMA_KOMPONEN_3"></div>
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
 			$('#NAMA_KOMPONEN').focus();
 		});

 		tampil_data_barang_komponen(); //pemanggilan fungsi tampil data.

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
 					title: 'Barang Komponen'
 				},
 				{
 					extend: 'pdf',
 					title: 'Barang Komponen'
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
 		function tampil_data_barang_komponen() {
 			$.ajax({
 				type: 'ajax',
 				url: '<?php echo base_url() ?>index.php/barang_komponen/data_barang_komponen',
 				async: false,
 				dataType: 'json',
 				success: function(data) {
 					var html = '';
 					var i;
 					for (i = 0; i < data.length; i++) {
 						html += '<tr>' +
 							'<td>' + data[i].NAMA_KOMPONEN + '</td>' +
 							'<td>' + data[i].NAMA_KATEGORI + '</td>' +
 							'<td>' +
 							'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="' + data[i].ID_BARANG_KOMPONEN + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
 							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="' + data[i].ID_BARANG_KOMPONEN + '"><i class="fa fa-trash"></i> Hapus</a>' +
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
 				url: "<?php echo base_url('barang_komponen/get_data') ?>",
 				dataType: "JSON",
 				data: {
 					id: id
 				},
 				success: function(data) {
 					console.log(data);
 					$.each(data, function(
 						ID_BARANG_KOMPONEN,
 						NAMA_KOMPONEN,
 						NAMA_KATEGORI) {
 						$('#ModalaEdit').modal('show');
 						$('[name="ID_BARANG_KOMPONEN2"]').val(data.ID_BARANG_KOMPONEN);
 						$('[name="NAMA_KOMPONEN2"]').val(data.NAMA_KOMPONEN);
 						$('[name="NAMA_KATEGORI2"]').val(data.NAMA_KATEGORI);
						 console.log(data.NAMA_KATEGORI);
 						$('#alert-msg-2').html('<div></div>');
 					});
 				}
 			});
 			return false;
 		});

 		//GET HAPUS
 		$('#show_data').on('click', '.item_hapus', function() {
 			var id = $(this).attr('data');
 			console.log(id);
 			$.ajax({
 				type: "GET",
 				url: "<?php echo base_url('barang_komponen/get_data') ?>",
 				dataType: "JSON",
 				data: {
 					id: id
 				},
 				success: function(data) {
 					console.log(data);
 					$.each(data, function(ID_BARANG_KOMPONEN, NAMA_KOMPONEN) {
 						$('#ModalHapus').modal('show');
 						$('[name="kode"]').val(id);
 						$('#NAMA_KOMPONEN_3').html('Nama Komponen : ' + data.NAMA_KOMPONEN);
 					});
 				}
 			});
 		});

 		//SIMPAN DATA
 		$('#btn_simpan').click(function() {
 			var form_data = {
 				NAMA_KOMPONEN: $('#NAMA_KOMPONEN').val(),
 				NAMA_KATEGORI: $('#NAMA_KATEGORI').val(),
 			};
 			$.ajax({
 				url: "<?php echo site_url('barang_komponen/simpan_data'); ?>",
 				type: 'POST',
 				data: form_data,
 				success: function(data) {
 					console.log(data);
 					if (data != '') {
 						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
 					} else {
 						$('[name="NAMA_KOMPONEN"]').val("");
 						$('[name="NAMA_KATEGORI"]').val("");
 						$('#ModalaAdd').modal('hide');
 						window.location.reload();
 					}
 				}
 			});
 			return false;
 		});

 		//UPDATE DATA 
 		$('#btn_update').on('click', function() {

 			var ID_BARANG_KOMPONEN2 = $('#ID_BARANG_KOMPONEN2').val();
 			var NAMA_KOMPONEN2 = $('#NAMA_KOMPONEN2').val();
 			var NAMA_KATEGORI2 = $('#NAMA_KATEGORI2').val();

 			$.ajax({
 				url: "<?php echo site_url('barang_komponen/update_data') ?>",
 				type: "POST",
 				dataType: "JSON",
 				data: {
 					ID_BARANG_KOMPONEN2: ID_BARANG_KOMPONEN2,
 					NAMA_KOMPONEN2: NAMA_KOMPONEN2,
 					NAMA_KATEGORI2: NAMA_KATEGORI2
 				},
 				success: function(data) {
 					if (data == true) {
 						$('#ModalaEdit').modal('hide');
 						$('[name="ID_BARANG_KOMPONEN2"]').val("");
 						$('[name="NAMA_KOMPONEN2"]').val("");
 						$('[name="NAMA_KATEGORI2"]').val("");
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
 				url: "<?php echo base_url('barang_komponen/hapus_data') ?>",
 				dataType: "JSON",
 				data: {
 					kode: kode
 				},
 				success: function(data) {
 					$('#ModalHapus').modal('hide');
 					tampil_data_barang_komponen();
 					window.location.reload();
 				}
 			});
 			return false;
 		});

 	});
 </script>

 </body>

 </html>