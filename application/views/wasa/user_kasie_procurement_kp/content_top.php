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
					<a>List Term of Payment</a>
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
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>List Term of Payment</h5>
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
					<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAddTermofPayment"><span class="fa fa-plus"></span> Tambah Data</a>
					<br><br>
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="mydata_top">
							<thead>
								<tr>
									<th>Nama Term of Payment</th>
									<th class="col-xs-1">Pilihan</td>
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

<!-- MODAL ADD Term of Payment-->
<div class="modal inmodal fade" id="ModalAddTermofPayment" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Term of Payment</h4>
				<small class="font-bold">Silakan tambah data Term of Payment</small>
			</div>
			<?php $attributes = array("nama_term_of_payment" => "contact_form", "id" => "contact_form");
			echo form_open("TOP/simpan_data_top", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Term of Payment</label>
						<div class="col-xs-9">
							<input name="NAMA_TERM_OF_PAYMENT" id="NAMA_TERM_OF_PAYMENT" class="form-control" type="text" placeholder="Contoh: 1 (SATU) BULAN SETELAH INVOICE DITERIMA">
						</div>
					</div>


					<div id="alert-msg-3"></div>

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
<!--END MODAL ADD Term of Payment-->

<!-- MODAL EDIT Term of Payment -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Ubah Nama Term of Payment</h4>
				<small class="font-bold">Silakan Edit Nama Term of Payment</small>
			</div>
			<?php $attributes = array("ID_TERM_OF_PAYMENT_2" => "contact_form", "id" => "contact_form");
			echo form_open("TOP/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">


					<input name="ID_TERM_OF_PAYMENT_2" id="ID_TERM_OF_PAYMENT_2" class="form-control" type="hidden" readonly>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Term of Payment</label>
						<div class="col-xs-9">
							<input name="NAMA_TERM_OF_PAYMENT_2" id="NAMA_TERM_OF_PAYMENT_2" class="form-control" type="text" placeholder="Contoh : 1 (SATU) BULAN SETELAH INVOICE DITERIMA" required autofocus>
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
<!--END MODAL EDIT Term of Payment-->

<!--MODAL HAPUS Term of Payment-->
<div class="modal fade" id="ModalHapusTOP" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
				<h4 class="modal-title" id="myModalLabel">Hapus Data Term of Payment</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="text" name="kode" id="textkode" value="" hidden>
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini? Data Term of Payment yang sudah dihapus tidak bisa dipulihkan kembali.</p>
						</br>
						<div name="NAMA_TERM_OF_PAYMENT_3" id="NAMA_TERM_OF_PAYMENT_3"></div>
					</div>

				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn_hapus btn btn-danger" id="btn_hapus_top"><i class="fa fa-trash"></i> Hapus</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--END MODAL HAPUS Term of Payment-->

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

<script>
	$(document).ready(function() {

		$('.file-box').each(function() {
			animationHover(this, 'pulse');
		});

		tampil_data_top(); //pemanggilan fungsi tampil data.

		$('#mydata_top').dataTable({
			pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'copy'
				},
				{
					extend: 'csv',
					title: 'Data Term of Payment'
				},
				{
					extend: 'excel',
					title: 'Data Term of Payment'
				},
				{
					extend: 'pdf',
					title: 'Data Term of Payment'
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
		function tampil_data_top() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/TOP/data_top',
				async: false,
				dataType: 'JSON',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {

						html += '<tr>' +
							'<td>' + data[i].NAMA_TERM_OF_PAYMENT + '</td>' +
							'<td>' +

							'<a href="javascript:;" class="btn btn-info btn-xs item_edit block" data="' + data[i].ID_TERM_OF_PAYMENT + '"><i class="fa fa-pencil"></i> Edit </a>' +
							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_TERM_OF_PAYMENT + '"><i class="fa fa-trash"></i> Hapus </a>' +
							'</td>' +
							'</tr>';
					}
					$('#show_data').html(html);
				}

			});
		}

		$('#btn_simpan').click(function() {
			var form_data = {
				NAMA_TERM_OF_PAYMENT: $('#NAMA_TERM_OF_PAYMENT').val()

			};
			$.ajax({
				url: "<?php echo site_url('TOP/simpan_data_top'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data != '') {
						$('#alert-msg-3').html('<div class="alert alert-danger">' + data + '</div>');
					} else {
						$('[name="NAMA_TERM_OF_PAYMENT"]').val("");
						$('#ModalAddTermofPayment').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});

		//GET UPDATE untuk edit jumlah
		$('#show_data').on('click', '.item_edit', function() {
			var id = $(this).attr('data');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('index.php/TOP/get_data_top') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function() {
						$('#ModalEdit').modal('show');
						$('[name="ID_TERM_OF_PAYMENT_2"]').val(data.ID_TERM_OF_PAYMENT);
						$('[name="NAMA_TERM_OF_PAYMENT_2"]').val(data.NAMA_TERM_OF_PAYMENT);
					});
				}
			});
			return false;
		});

		//GET HAPUS TOP
		$('#show_data').on('click', '.item_hapus', function() {
			var id = $(this).attr('data');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('index.php/TOP/get_data_top') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_TERM_OF_PAYMENT, NAMA_TERM_OF_PAYMENT) {
						$('#ModalHapusTOP').modal('show');
						$('[name="kode"]').val(id);
						$('#NAMA_TERM_OF_PAYMENT_3').html('Term of Payment: ' + data.NAMA_TERM_OF_PAYMENT);
					});
				}
			});
		});

		//UPDATE DATA 
		$('#btn_update').on('click', function() {
			var ID_TERM_OF_PAYMENT = $('#ID_TERM_OF_PAYMENT_2').val();
			var NAMA_TERM_OF_PAYMENT = $('#NAMA_TERM_OF_PAYMENT_2').val();
			$.ajax({
				url: "<?php echo site_url('index.php/TOP/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_TERM_OF_PAYMENT: ID_TERM_OF_PAYMENT,
					NAMA_TERM_OF_PAYMENT: NAMA_TERM_OF_PAYMENT
				},
				success: function(data) {
					if (data == true) {
						$('#ModalaEdit').modal('hide');
						window.location.reload();
					} else {
						$('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
					}
				}
			});
			return false;
		});

		//HAPUS DATA TOP
		$('#btn_hapus_top').on('click', function() {
			var kode = $('#textkode').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('index.php/TOP/hapus_data_lokasi') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapusTOP').modal('hide');
					window.location.reload();
				}
			});
			return false;
		});
	});
</script>

</body>

</html>