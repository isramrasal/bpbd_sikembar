<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List FPB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/FPB/') ?>">FPB</a>
            </li>
            <li class="active">
                <strong>
                    <a>List FPB</a>
                </strong>
            </li>
        </ol>
    </div>

</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="alert alert-info alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Sistem menampilkan seluruh FPB yang diajukan pada proyek <?php echo ($NAMA_PROYEK); ?>.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>FPB</h5>
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
                                    <th>Nomor Urut FPB</th>
                                    <th>Tanggal Pengajuan FPB</th>
                                    <th>Peminta</th>
                                    <th>Progres FPB</th>
                                    <th>Status</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    <!-- <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Buat SPPB dari FPB</a> -->
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
        tampil_data_fpb(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }]

        });

        //fungsi tampil data
        function tampil_data_fpb() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url() ?>FPB/data_FPB',
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var html_progress = '';
                    var i;
                    for (i = 0; i < data.length; i++) {

                        if (data[i].PROGRESS_FPB == "Dalam Proses Staff Logistik (Penyiapan Barang/SPPB)") {
                            html_progress = '<a href="#" class="btn btn-info btn-xs block"> ' + data[i].PROGRESS_FPB + ' </a>';
                            tr_kode = '<tr>';
                            tombol_fpb = '<a href="<?php echo base_url() ?>FPB_form/view/' + data[i].HASH_MD5_FPB + '" class="btn btn-warning btn-xs block"><i class="fa fa-eye"></i> Lihat FPB </a>';
                        } else if (data[i].PROGRESS_FPB == "Dalam Proses Staff Logistik") {
                            html_progress = '<a href="#" class="btn btn-info btn-xs block"> ' + data[i].PROGRESS_FPB + ' </a>';
                            tr_kode = '<tr>';
                            tombol_fpb = '<a href="<?php echo base_url() ?>FPB_form/view/' + data[i].HASH_MD5_FPB + '" class="btn btn-warning btn-xs block"><i class="fa fa-eye"></i> Lihat FPB </a>';
                        } else {
                            html_progress = data[i].PROGRESS_FPB;
                            tombol_fpb = '<a href="<?php echo base_url() ?>FPB_form/view/' + data[i].HASH_MD5_FPB + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Lihat FPB </a>';
                            tr_kode = '<tr>';
                        }

                        html += tr_kode +
                            '<td>' + data[i].NO_URUT_FPB + '</td>' +
                            '<td>' + data[i].TANGGAL_DOKUMEN_FPB + '</td>' +
                            '<td>' + data[i].NAMA + ' - ' + data[i].NAMA_JABATAN + '</td>' +
                            '<td> <center>' + html_progress + '</center></td>' +
                            '<td>' + data[i].STATUS_FPB + '</td>' +
                            '<td>' + tombol_fpb + ' ' +

                            '</td>' +
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