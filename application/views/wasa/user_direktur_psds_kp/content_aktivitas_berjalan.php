<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Aktivitas Berjalan</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li class="active">
				<strong>
					<a href="<?php echo base_url('index.php/Aktivitas_berjalan/') ?>">Aktivitas Berjalan</a>
					</strong>	
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">

				<div class="ibox-content">


					<div class="tabs-container">
                        <ul class="nav nav-tabs">
							<?php 
							$index = 0;
							foreach ($proyek as $prov) 
							{
								if($index == 0)
								{
									echo '<li class="active"><a data-toggle="tab" href="#tab-'.$index.'"> '.$prov->NAMA_PROYEK.'</a></li>';
								}
								else
								{
									echo '<li class=""><a data-toggle="tab" href="#tab-'.$index.'"> '.$prov->NAMA_PROYEK.'</a></li>';
								}
								
								$index++;
							} 
							?>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="mydata">
											<thead>
												<tr>
													<th>SPPB</th>
													<th>RFQ</th>
													<th>KHP</th>
													<th>SPP</th>
													<th>PO</th>
													<th>Serah Terima Barang</th>
													<th>Pembayaran Invoice</th>
												</tr>
											</thead>
											<tbody id="show_data">

											</tbody>

										</table>
									</div>
									<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalaAdd"><span class="fa fa-plus"></span> Tambah Data</a>
						
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <strong>Donec quam felis</strong>

                                    <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among the stalks, and grow familiar with the countless indescribable forms of the insects
                                        and flies, then I feel the presence of the Almighty, who formed us in his own image, and the breath </p>

                                    <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss of souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                                        sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a single stroke at the present moment; and yet.</p>
                                </div>
                            </div>
                        </div>
					</div>
					
					</break>


					
				</div>

			</div>
		</div>
	</div>
</div>
</br>

<div class="footer">
	<div>
		<p><strong>&copy; <?php  echo date("Y"); ?> PT. Wasa Mitra Enginering</strong><br /> Hak cipta dilindungi undang-undang.</p>
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
				<i class="fa fa-anchor modal-icon"></i>
				<h4 class="modal-title">Vendor</h4>
				<small class="font-bold">Silakan tambah data vendor</small>
			</div>
			<?php $attributes = array("name" => "contact_form", "id" => "contact_form");
			echo form_open("aktivitas_berjalan/simpan_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Nama Vendor</label>
						<div class="col-xs-9">
							<input name="NAMA_VENDOR" id="NAMA_VENDOR" class="form-control" type="text" placeholder="Contoh: PT. NUSA INDAH CEMERLANG" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Alamat Vendor</label>
						<div class="col-xs-9">
							<textarea style="width:100%" name="ALAMAT_VENDOR" id="ALAMAT_VENDOR" class="form-control" type="text" placeholder="Contoh: Jalan Nusa Indah 4 No.22 RT/RW: 002/010. Kec. Batu Ampar, Kel. Sungai Jauh. Jakarta Pusat. Kodepos 12434." required></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. Telepon Vendor</label>
						<div class="col-xs-9">
							<input name="NO_TELP_VENDOR" id="NO_TELP_VENDOR" class="form-control" type="text" placeholder="Contoh: 0218484212" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email Vendor</label>
						<div class="col-xs-9">
							<input name="EMAIL_VENDOR" id="EMAIL_VENDOR" class="form-control" type="email" placeholder="Contoh: info@nic.com" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama PIC Vendor</label>
						<div class="col-xs-9">
							<input name="NAMA_PIC_VENDOR" id="NAMA_PIC_VENDOR" class="form-control" type="text" placeholder="Contoh: Nana Soewarna" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. HP PIC Vendor</label>
						<div class="col-xs-9">
							<input name="NO_HP_PIC_VENDOR" id="NO_HP_PIC_VENDOR" class="form-control" type="text" placeholder="Contoh: 081228299132" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email PIC Vendor</label>
						<div class="col-xs-9">
							<input name="EMAIL_PIC_VENDOR" id="EMAIL_PIC_VENDOR" class="form-control" type="email" placeholder="Contoh: nana_soewarna@nic.com" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Status</label>
						<div class="col-xs-9">
							<select name="STATUS_VENDOR" class="form-control" id="STATUS_VENDOR">
								<option value=''>- Pilih Status Vendor -</option>
								<option value='Aktif'> Aktif</option>
								<option value='Tidak Aktif'> Tidak Aktif</option>
							</select>
						</div>
					</div>

					
					<div class="alert alert-info alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Upload file dokumen dilakukan di halaman profil vendor.
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
				<i class="fa fa-anchor modal-icon"></i>
				<h4 class="modal-title">Vendor</h4>
				<small class="font-bold">Silakan edit data vendor</small>
			</div>
			<?php $attributes = array("id_vendor2" => "contact_form", "id" => "contact_form");
			echo form_open("aktivitas_berjalan/update_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">
					
				<input name="ID_VENDOR2" id="ID_VENDOR2" class="form-control" type="hidden" placeholder="ID Proyek" readonly>


				<div class="form-group">
						<label class="control-label col-xs-3">Nama Vendor</label>
						<div class="col-xs-9">
							<input name="NAMA_VENDOR2" id="NAMA_VENDOR2" class="form-control" type="text" placeholder="Contoh: PT. NUSA INDAH CEMERLANG" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Alamat Vendor</label>
						<div class="col-xs-9">
							<textarea style="width:100%" name="ALAMAT_VENDOR2" id="ALAMAT_VENDOR2" class="form-control" type="text" placeholder="Contoh: Jalan Nusa Indah 4 No.22 RT/RW: 002/010. Kec. Batu Ampar, Kel. Sungai Jauh. Jakarta Pusat. Kodepos 12434." required></textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. Telepon Vendor</label>
						<div class="col-xs-9">
							<input name="NO_TELP_VENDOR2" id="NO_TELP_VENDOR2" class="form-control" type="text" placeholder="Contoh: 0218484212" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email Vendor</label>
						<div class="col-xs-9">
							<input name="EMAIL_VENDOR2" id="EMAIL_VENDOR2" class="form-control" type="email" placeholder="Contoh: info@nic.com" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nama PIC Vendor</label>
						<div class="col-xs-9">
							<input name="NAMA_PIC_VENDOR2" id="NAMA_PIC_VENDOR2" class="form-control" type="text" placeholder="Contoh: Nana Soewarna" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">No. HP PIC Vendor</label>
						<div class="col-xs-9">
							<input name="NO_HP_PIC_VENDOR2" id="NO_HP_PIC_VENDOR2" class="form-control" type="text" placeholder="Contoh: 081228299132" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Email PIC Vendor</label>
						<div class="col-xs-9">
							<input name="EMAIL_PIC_VENDOR2" id="EMAIL_PIC_VENDOR2" class="form-control" type="email" placeholder="Contoh: nana_soewarna@nic.com" required autofocus>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Status</label>
						<div class="col-xs-9">
							<select name="STATUS_VENDOR2" class="form-control" id="STATUS_VENDOR2">
								<option value=''>- Pilih Status Vendor -</option>
								<option value='Aktif'> Aktif</option>
								<option value='Tidak Aktif'> Tidak Aktif</option>
							</select>
						</div>
					</div>

					<div class="alert alert-info alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Upload file dokumen dilakukan di halaman profil vendor.
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
				<h4 class="modal-title" id="myModalLabel">Hapus Data Vendor</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" name="kode" id="textkode" value="">
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini?</p>
						<div name="NAMA_VENDOR3" id="NAMA_VENDOR3"></div>
					</div>

					<div class="alert alert-danger alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Seluruh file dokumen vendor juga akan dihapus oleh sistem!
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

<script src="http://www.myersdaily.org/joseph/javascript/md5.js"></script>

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function() {

		$('#ModalaAdd').on('shown.bs.modal', function() {
			$('#nama_vendor').focus();
		});

		tampil_data_vendor(); //pemanggilan fungsi tampil data.

		$('#mydata').dataTable({
			pageLength: 25,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'copy'
				},
				{
					extend: 'csv',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6 ]
					},
				},
				{
					extend: 'excel',
					title: 'Vendor',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6 ]
					},
				},
				{
					extend:'pdfHtml5',
					title: 'Vendor',
					orientation:'landscape',
					pageSize: 'A3',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6 ]
					},
					customize: function (doc) {
						doc.content[1].table.widths = 
							Array(doc.content[1].table.body[0].length + 1).join('*').split('');
					}
				},

				{
					extend: 'print',
					orientation:'landscape',
					pageSize: 'A3',
					customize: function(win) {
						$(win.document.body).addClass('white-bg');
						$(win.document.body).css('font-size', '10px');

						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					},
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4, 5, 6 ]
					},
				}
			]

		});

		//fungsi tampil data
		function tampil_data_vendor() {
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/aktivitas_berjalan/data_vendor',
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						if (data[i].STATUS_VENDOR=="Aktif")
						{
							html_status = '<td> <span class="label label-primary block">' + data[i].STATUS_VENDOR + '</span></td>';
						}
						if (data[i].STATUS_VENDOR=="Tidak Aktif")
						{
							html_status = '<td> <span class="label label-danger block">' + data[i].STATUS_VENDOR + '</span></td>';
						}
						html += '<tr>' +
							'<td>' + data[i].NAMA_VENDOR + '</td>' +
							'<td>' + data[i].ALAMAT_VENDOR + '</td>' +
							'<td>' + data[i].NO_TELP_VENDOR + '</td>' +
							'<td>' + data[i].EMAIL_VENDOR + '</td>' +
							'<td>' + data[i].NAMA_PIC_VENDOR + '</td>' +
							'<td>' + data[i].NO_HP_PIC_VENDOR + '</td>' +
							'<td>' + data[i].EMAIL_PIC_VENDOR + '</td>' +
							html_status +
							'<td>' +
							'<a href="<?php echo base_url() ?>aktivitas_berjalan/profil_aktivitas_berjalan/'+data[i].HASH_MD5 +'" class="btn btn-warning btn-xs btn-outline block"><i class="fa fa-eye"></i> Lihat Data </a>' + ' ' +
							'<a href="javascript:;" class="btn btn-info btn-xs item_edit block" data="' + data[i].ID_VENDOR + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_VENDOR + '"><i class="fa fa-trash"></i> Hapus</a>' +
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
				url: "<?php echo base_url('index.php/aktivitas_berjalan/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(
						ID_VENDOR,
						NAMA_VENDOR,
						ALAMAT_VENDOR,
						NO_TELP_VENDOR,
						NAMA_PIC_VENDOR,
						NO_HP_PIC_VENDOR,
						EMAIL_PIC_VENDOR,
						NO_HP_PIC_VENDOR,
						EMAIL_VENDOR,
						STATUS_VENDOR) {
						$('#ModalaEdit').modal('show');
						$('[name="ID_VENDOR2"]').val(data.ID_VENDOR);
						$('[name="NAMA_VENDOR2"]').val(data.NAMA_VENDOR);
						$('[name="ALAMAT_VENDOR2"]').val(data.ALAMAT_VENDOR);
						$('[name="NO_TELP_VENDOR2"]').val(data.NO_TELP_VENDOR);
						$('[name="NAMA_PIC_VENDOR2"]').val(data.NAMA_PIC_VENDOR);
						$('[name="NO_HP_PIC_VENDOR2"]').val(data.NO_HP_PIC_VENDOR);
						$('[name="EMAIL_PIC_VENDOR2"]').val(data.EMAIL_PIC_VENDOR);
						$('[name="EMAIL_VENDOR2"]').val(data.EMAIL_VENDOR);
						$('[name="STATUS_VENDOR2"]').val(data.STATUS_VENDOR);
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
				url: "<?php echo base_url('index.php/aktivitas_berjalan/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_VENDOR, NAMA_VENDOR) {
						$('#ModalHapus').modal('show');
						$('[name="kode"]').val(id);
						$('#NAMA_VENDOR3').html('Nama Vendor: ' + data.NAMA_VENDOR);
					});
				}
			});
		});

		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				NAMA_VENDOR: $('#NAMA_VENDOR').val(),
				ALAMAT_VENDOR: $('#ALAMAT_VENDOR').val(),
				NO_TELP_VENDOR: $('#NO_TELP_VENDOR').val(),
				NAMA_PIC_VENDOR: $('#NAMA_PIC_VENDOR').val(),
				NO_HP_PIC_VENDOR: $('#NO_HP_PIC_VENDOR').val(),
				EMAIL_PIC_VENDOR: $('#EMAIL_PIC_VENDOR').val(),
				EMAIL_VENDOR: $('#EMAIL_VENDOR').val(),
				STATUS_VENDOR: $('#STATUS_VENDOR').val(),
			};
			$.ajax({
				url: "<?php echo site_url('aktivitas_berjalan/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data != '') {
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					} else {
						$('[name="NAMA_VENDOR"]').val("");
						$('[name="ALAMAT_VENDOR"]').val("");
						$('[name="NO_TELP_VENDOR"]').val("");
						$('[name="NAMA_PIC_VENDOR"]').val("");
						$('[name="NO_HP_PIC_VENDOR"]').val("");
						$('[name="EMAIL_PIC_VENDOR"]').val("");
						$('[name="EMAIL_VENDOR"]').val("");
						$('[name="STATUS_VENDOR"]').val("");
						$('#ModalaAdd').modal('hide');
						window.location.reload();
					}
				}
			});
			return false;
		});

		//UPDATE DATA 
		$('#btn_update').on('click', function() {
			var ID_VENDOR2 = $('#ID_VENDOR2').val();
			var NAMA_VENDOR2 = $('#NAMA_VENDOR2').val();
			var ALAMAT_VENDOR2 = $('#ALAMAT_VENDOR2').val();
			var NO_TELP_VENDOR2 = $('#NO_TELP_VENDOR2').val();
			var NAMA_PIC_VENDOR2 = $('#NAMA_PIC_VENDOR2').val();
			var NO_HP_PIC_VENDOR2 = $('#NO_HP_PIC_VENDOR2').val();
			var EMAIL_PIC_VENDOR2 = $('#EMAIL_PIC_VENDOR2').val();
			var EMAIL_VENDOR2 = $('#EMAIL_VENDOR2').val();
			var STATUS_VENDOR2 = $('#STATUS_VENDOR2').val();
			console.log(ID_VENDOR2);
			$.ajax({
				url: "<?php echo site_url('aktivitas_berjalan/update_data') ?>",
				type: "POST",
				dataType: "JSON",
				data: {
					ID_VENDOR2: ID_VENDOR2,
					NAMA_VENDOR2: NAMA_VENDOR2,
					ALAMAT_VENDOR2: ALAMAT_VENDOR2,
					NO_TELP_VENDOR2: NO_TELP_VENDOR2,
					NAMA_PIC_VENDOR2: NAMA_PIC_VENDOR2,
					NO_HP_PIC_VENDOR2: NO_HP_PIC_VENDOR2,
					EMAIL_PIC_VENDOR2: EMAIL_PIC_VENDOR2,
					EMAIL_VENDOR2: EMAIL_VENDOR2,
					STATUS_VENDOR2: STATUS_VENDOR2
				},
				success: function(data) {
					console.log("masuk 2");
					if (data == true) {
						$('#ModalaEdit').modal('hide');
						$('[name="ID_VENDOR2"]').val("");
						$('[name="NAMA_VENDOR2"]').val("");
						$('[name="ALAMAT_VENDOR2"]').val("");
						$('[name="NO_TELP_VENDOR2"]').val("");
						$('[name="NAMA_PIC_VENDOR2"]').val("");
						$('[name="NO_HP_PIC_VENDOR2"]').val("");
						$('[name="EMAIL_PIC_VENDOR2"]').val("");
						$('[name="EMAIL_VENDOR2"]').val("");
						$('[name="STATUS_VENDOR2"]').val("");
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
				url: "<?php echo base_url('index.php/aktivitas_berjalan/hapus_data') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapus').modal('hide');
					tampil_data_vendor();
					window.location.reload();
				}
			});
			return false;
		});

		

	});
</script>

</body>

</html>