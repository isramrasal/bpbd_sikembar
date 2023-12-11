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
										<th>Kode Barang</th>
										<th>Status Kepemilikan</th>
										<th>Jenis Kepemilikan</th>
										<th>Lokasi Service</th>
										<th>Keterangan</th>
										<th>Tanggal Mulai Perbaikan</th>
										<th>Tanggal Selesai Perbaikan</th>
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

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function() {

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
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url() ?>index.php/riwayat_perbaikan_barang_entitas/data_riwayat_perbaikan_barang_entitas',
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<tr>' +
						'<td>' + data[i].NAMA_BARANG + '</td>' +
							'<td>' + data[i].MEREK + '</td>' +
							'<td>' + data[i].KODE_BARANG_ENTITAS + '</td>' +
							'<td>' + data[i].STATUS_KEPEMILIKAN + '</td>' +
							'<td>' + data[i].JENIS_KEPEMILIKAN + '</td>' +
							'<td>' + data[i].LOKASI_SERVICE + '</td>' +
							'<td>' + data[i].KETERANGAN + '</td>' +
							'<td>' + data[i].TANGGAL_MULAI_SERVICE_HARI + '</td>' +
							'<td>' + data[i].TANGGAL_SELESAI_SERVICE_HARI + '</td>' +
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