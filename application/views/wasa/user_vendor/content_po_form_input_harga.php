<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Purchase Order</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/PO/') ?>">PO</a>
            </li>
            <li class="active">
                <strong>
                    <a>Purchase Order</a>
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

    <!-- Form PO -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Purchase Order</h5>
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
                    <div class="form-horizontal">
                        <?php
                        if (isset($PO)) {
                            foreach ($PO->result() as $PO) :
                        ?>

                                <div class="form-group"><label class="col-sm-2 control-label">No Urut PO:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $PO->NO_URUT_PO; ?>" disabled></div>
                                </div>

                        <?php endforeach;
                        } ?>


                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi Penyerahan:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_LOKASI_PENYERAHAN; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Vendor:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_VENDOR; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Term Of Payment:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_TERM_OF_PAYMENT; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Nama PIC Vendor:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_PIC_VENDOR; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Email PIC Vendor:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $EMAIL_PIC_VENDOR; ?>" disabled></div>
                        </div>

                        <!-- <div class="form-group"><label class="col-sm-2 control-label">Batas akhir pengisian PO:</label>
                            <div class="col-sm-10">
                                <input name="BATAS_AKHIR" id="BATAS_AKHIR" class="form-control" type="date" value="<?php echo $BATAS_AKHIR; ?>" disabled>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>PO Item Barang/Jasa</h5>
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
                            <div class="form-horizontal">

                                <div class="alert alert-warning alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    Pastikan telah data diisi dengan benar.
                                </div>

                                <div class="hr-line-dashed"></div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="mydata">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Merek Barang</th>
                                                <th>Jenis Barang</th>
                                                <th>Tool/</br>Consumable/</br>Material</th>
                                                <th>Spesifikasi Singkat</th>
                                                <th>Satuan Barang</th>
                                                <th>Jumlah Yang Diadakan</th>
                                                <th>Harga Satuan Barang</th>
                                                <th>Pajak</th>
                                                <th>Harga Total Barang</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_data">
                                        </tbody>
                                    </table>
                                </div>
                                <div id="alert-msg-6"></div>
                                <!-- <br> -->
                                <!-- <a href="#" class="btn btn-info" data-toggle="modal" data-target="#ModalAddNew"><span class="fa fa-plus"></span> Ajukan Item Alternatif</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="sm-10">
                            <button class="btn btn-info" id="btn_kirim_po"> Kembali ke Purchase Order</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Form PO -->
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
    $(document).ready(function() {

        var ID_SPPB = <?php echo $ID_SPPB;  ?>;
        var ID_PO = <?php echo $ID_PO;  ?>;

        tampil_data_form_po(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            order: [
                [2, "asc"]
            ],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv'
                },
                {
                    extend: 'excel',
                    title: 'PO Form'
                },
                {
                    extend: 'pdf',
                    title: 'PO Form'
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
        function tampil_data_form_po() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>PO_form/data_po_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_PO
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        // let jumlah_barang = data[i].JUMLAH_BARANG;
                        let jumlah_rasd = data[i].JUMLAH_RASD;
                        let kode_barang = data[i].KODE_BARANG;

                        if (kode_barang != null) {
                            kode_barang_cetak = '<a href="<?php echo base_url() ?>barang_master/profil_barang_master/' + data[i].HASH_MD5_BARANG_MASTER + '" class="btn btn-warning btn-xs btn-outline block" target="_blank"><i class="fa fa-eye"></i> ' + kode_barang + ' </a>';
                        }
                        if (kode_barang == null) {
                            kode_barang_cetak = '<span class="label label-info block"><i class="fa fa-warning"></i> Data Baru</span>';
                        }

                        // if (jumlah_barang == null) {
                        //     jumlah_barang = 0;
                        // }
                        if (kode_barang == null) {
                            kode_barang = `<span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span>`;
                        }
                        if (jumlah_rasd == null) {
                            jumlah_rasd = 0;
                        }
                        data[i].HARGA_SATUAN_BARANG_FIX = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data[i].HARGA_SATUAN_BARANG_FIX);

                        HARGA_TOTAL_FIX = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data[i].HARGA_TOTAL_FIX);

                        HARGA_SETELAH_PAJAK = (parseInt(data[i].HARGA_TOTAL_FIX) * parseInt(data[i].TARIF_PAJAK) / 100);
                        HARGA_SETELAH_PAJAK = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(HARGA_SETELAH_PAJAK);

                        html += '<tr>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
                            '<td>' + data[i].PERALATAN_PERLENGKAPAN + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                            '<td>' + data[i].JUMLAH_BARANG + '</td>' +
                            '<td>' + data[i].HARGA_SATUAN_BARANG_FIX + '</td>' +
                            '<td>' + data[i].TARIF_PAJAK + '%' + '<br>' + HARGA_SETELAH_PAJAK + '</td>' +
                            '<td>' + HARGA_TOTAL_FIX + '</td>' +
                            '<td>' + data[i].KETERANGAN_BARANG_PO + '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        //SIMPAN PERUBAHAN DAN LIHAT PDF
        $('#btn_kirim_po').click(function() {
            var alamat = "<?php echo base_url('PO'); ?>";
            window.open(
                alamat,
                '_self'
            );
        });
    });
</script>

</body>

</html>