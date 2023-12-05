<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
		<h2>List SPPB</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li >
					<a href="<?php echo base_url('index.php/SPPB/') ?>">SPPB</a>	
			</li>
			<li class="active">
				<strong>
					<a>List SPPB</a>
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
        Sistem menampilkan seluruh SPPB.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>SPPB</h5>
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
                                    <th>No. SPPB</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Tanggal Pembuatan SPPB</th>
                                    <th>Status SPPB</th>
                                    <th>Pilihan</th>
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
        tampil_data_sppb(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
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
                    extend: 'csv'
                },
                {
                    extend: 'excel',
                    title: 'SPPB'
                },
                {
                    extend: 'pdf',
                    title: 'SPPB'
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
        function tampil_data_sppb() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url('SPPB/data_sppb') ?>',
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html, html_progress = '';
                    var i;
                    for (i = 0; i < data.length; i++) {

                        var PROGRESS_SPPB = data[i].PROGRESS_SPPB;
                        var STATUS_SPPB = data[i].STATUS_SPPB;

                        if (data[i].PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
                            html_progress = '<a href="#" class="btn btn-info btn-xs block"> ' + data[i].PROGRESS_SPPB + ' </a>';
                            tombol_sppb = '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-warning btn-xs block"><i class="fa fa-eye"></i> Lihat SPPB </a>';
                        } else if (data[i].PROGRESS_SPPB == "SPPB Disetujui") {
                            html_progress = '<a href="#" class="btn btn-primary btn-xs block"> ' + data[i].PROGRESS_SPPB + ' </a>';
                            tombol_sppb = '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Lihat SPPB </a>';
                        } else {
                            html_progress = data[i].PROGRESS_SPPB;
                            tombol_sppb = '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Lihat SPPB </a>';
                        }

                        html += '<tr>' +
                            '<td>' + data[i].NO_URUT_SPPB + '</td>' +
                            '<td>' + data[i].JENIS_PEKERJAAN + '</td>' +
                            '<td>' + data[i].TANGGAL_PEMBUATAN_SPPB_HARI + '</td>' +
                            '<td>' + html_progress + '</td>' +
                            '<td>' + tombol_sppb + ' '
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