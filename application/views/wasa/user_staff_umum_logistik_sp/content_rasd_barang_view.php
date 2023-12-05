<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Rasd Barang</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a onclick="goBack()">Rasd</a>
            </li>
            <li class="active">
                <strong>
                    <a>Rasd Barang</a>
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
        Sistem menampilkan seluruh rasd barang.
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian Rasd Barang</h5>
        </div>
        <div class="ibox-content">
            <form method="get" class="form-horizontal">
                <?php
                if (isset($rasd)) {
                    foreach ($rasd->result() as $rasd) :
                ?>
                        <div class="form-group"><label class="col-sm-2 control-label">Nama Proyek :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rasd->NAMA_PROYEK; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi Proyek :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rasd->LOKASI; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Nama Project Manager :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rasd->PEGAWAI_PM; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Nama Site Manager :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rasd->PEGAWAI_SM; ?>" disabled>
                            </div>
                        </div>
                <?php endforeach;
                } ?>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Rasd Barang List From Rasd</h5>
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
                                    <!-- <th>Status Barang</th> -->
                                    <th>Kode Barang</th>
                                    <th>Nama</th>
                                    <th>Merek Barang</th>
                                    <th>Rasd Barang</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Satuan Barang</th>
                                    <th>Jumlah</th>
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

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- TouchSpin -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    function goBack() {
        window.history.back();
    }
    $(document).ready(function() {
        let id_rasd = <?php echo $id_rasd  ?>;
        tampil_data_rasd_barang(); //pemanggilan fungsi tampil data.

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
                    title: 'Rasd Barang'
                },
                {
                    extend: 'pdf',
                    title: 'Rasd Barang'
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
        function tampil_data_rasd_barang() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>rasd_barang/data_rasd_barang',
                async: false,
                dataType: 'json',
                data: {
                    id: id_rasd
                },
                success: function(data) {
                    var html = '';
                    var i;

                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_BARANG;
                        let kode_barang = data[i].KODE_BARANG;
                        if (jumlah_barang == null) {
                            jumlah_barang = 0;
                        }
                        if (kode_barang == null) {
                            kode_barang = `<span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span>`;
                        }
                        html += '<tr>' +
                            '<td>' + kode_barang + '</td>' +
                            '<td>' + data[i].NAMA + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                            '<td>' + jumlah_barang + '</td>' +
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