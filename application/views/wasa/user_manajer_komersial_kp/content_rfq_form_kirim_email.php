<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Kirim Email RFQ</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/RFQ/') ?>">RFQ</a>
            </li>
            <li class="active">
                <strong>
                    <a>Kirim Email</a>
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

    <!-- Form RFQ -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Kirim Email RFQ</h5>
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
                    <input type="hidden" name="HASH_MD5_RFQ" id="HASH_MD5_RFQ" class="form-control" value="<?php echo $HASH_MD5_RFQ; ?>" enable> </br>
                    <div class="form-horizontal">
                        <?php
                        if (isset($RFQ)) {
                            foreach ($RFQ->result() as $RFQ) :
                        ?>

                                <div class="form-group"><label class="col-sm-2 control-label">No Urut RFQ:</label>
                                    <div class="col-sm-10"><input type="text" name="NO_URUT_RFQ" id="NO_URUT_RFQ" class="form-control" value="<?php echo $RFQ->NO_URUT_RFQ; ?>" disabled></div>
                                </div>

                             

                        <?php endforeach;
                        } ?>

                        <?php
                        if (isset($SPPB)) {
                            foreach ($SPPB->result() as $SPPB) :
                        ?>
                                <div class="form-group"><label class="col-sm-2 control-label">Proyek:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->NAMA_PROYEK; ?>" disabled></div>
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

                        <div class="form-group"><label class="col-sm-2 control-label">Batas Akhir Pengisian RFQ:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $BATAS_AKHIR; ?>" disabled></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group"><label class="col-sm-2 control-label">Nama PIC Vendor:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="NAMA_PIC_VENDOR" id="NAMA_PIC_VENDOR" value="<?php echo $NAMA_PIC_VENDOR; ?>"></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Email PIC Vendor:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="EMAIL_PIC_VENDOR" id="EMAIL_PIC_VENDOR" value="<?php echo $EMAIL_PIC_VENDOR; ?>"></div>
                        </div>

                    </div>

                    <div class="form-horizontal">

                        <div class="alert alert-warning alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Pastikan telah data diisi dengan benar.
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group"><label class="col-sm-2 control-label">Salam pembuka email:</label>
                            <div class="col-sm-10">
                                <textarea style="width:100%" rows="12" name="SALAM_PEMBUKA" id="SALAM_PEMBUKA" required><p>Yth. Bapak/ibu <?php echo $NAMA_PIC_VENDOR; ?>, <?php echo $NAMA_VENDOR; ?></p>
                            </textarea>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Isi body email:</label>
                            <div class="col-sm-10">
                                <textarea style="width:100%" rows="12" name="ISI_BODY" id="ISI_BODY" required>Terlampir file RFQ dari kami. Mohon untuk memberikan penawaran harga melalui link berikut:<br></br>
                            Mohon berikan penawaran harga sebelum tanggal: <?php echo $BATAS_AKHIR; ?><br></br> <br></br>
                            Dengan menerima email ini, pihak Vendor harus menjaga kerahasiaan. Terima kasih.
                            </textarea>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="mydata">
                                <thead>
                                    <tr>
                                        <!-- <th>Status Barang</th> -->

                                        <th>Nama Barang</th>
                                        <th>Merek Barang</th>
                                        <th>Spesifikasi Singkat</th>
                                        <th>Satuan Barang</th>
                                        <th>Jumlah Yang Diadakan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody id="show_data">

                                </tbody>

                            </table>
                        </div>

                        <div id="alert-msg-6"></div>


                    </div>
                </div>
            </div>

            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="sm-10">
                            <button class="btn btn-primary" id="btn_kirim_email_vendor"><i class="fa fa-save"></i> Kirim Email RFQ</button>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Form RFQ -->
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
            var ID_RFQ = <?php echo $ID_RFQ;  ?>;


            tampil_data_form_rfq(); //pemanggilan fungsi tampil data.

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
                        title: 'RFQ Form'
                    },
                    {
                        extend: 'pdf',
                        title: 'RFQ Form'
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

            //fungsi tampil data penyerahan vendor top
            function tampil_data_rfq_penyerahan_vendor_top() {
                var ID_RFQ = ID_RFQ;
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url('RFQ_form/get_data_rfq') ?>",
                    dataType: "JSON",
                    data: {
                        ID_RFQ: ID_RFQ
                    },
                    success: function(data) {
                        $.each(data, function() {
                            $('#ModalEdit').modal('show');
                            $('[name="ID_RFQ_FORM2"]').val(data.ID_RFQ_FORM);
                            $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                            $('[name="NAMA2"]').val(data.NAMA_BARANG);
                            $('[name="MEREK2"]').val(data.MEREK);
                            $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                            $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_BARANG);
                            $('[name="TANGGAL_MULAI_PAKAI2"]').val(data.TANGGAL_MULAI_PAKAI);
                            $('[name="TANGGAL_SELESAI_PAKAI2"]').val(data.TANGGAL_SELESAI_PAKAI);
                            $('#alert-msg-2').html('<div></div>');
                        });
                    }
                });
                return false;

            }

            //fungsi tampil data
            function tampil_data_form_rfq() {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() ?>RFQ_form/data_rfq_form',
                    async: false,
                    dataType: 'json',
                    data: {
                        id: ID_RFQ
                    },
                    success: function(data) {
                        console.log(data);
                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            let jumlah_barang = data[i].JUMLAH_BARANG;
                            let jumlah_rasd = data[i].JUMLAH_RASD;
                            let kode_barang = data[i].KODE_BARANG;


                            if (jumlah_barang == null) {
                                jumlah_barang = 0;
                            }
                            if (kode_barang == null) {
                                kode_barang = `<span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span>`;
                            }
                            if (jumlah_rasd == null) {
                                jumlah_rasd = 0;
                            }
                            html += '<tr>' +
                                '<td>' + data[i].NAMA_BARANG + '</td>' +
                                '<td>' + data[i].MEREK + '</td>' +
                                '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                                '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                                '<td>' + jumlah_barang + '</td>' +
                                '<td>' + data[i].KETERANGAN + '</td>' +

                                '</tr>';
                        }
                        $('#show_data').html(html);
                    }
                });
            }

            //SIMPAN PERUBAHAN DAN LIHAT PDF
            $('#btn_kirim_email_vendor').click(function() {
                var form_data = {
                    ID_RFQ: ID_RFQ,
                    NAMA_PIC_VENDOR: $('#NAMA_PIC_VENDOR').val(),
                    EMAIL_PIC_VENDOR: $('#EMAIL_PIC_VENDOR').val(),
                    SALAM_PEMBUKA: $('#SALAM_PEMBUKA').val(),
                    ISI_BODY: $('#ISI_BODY').val(),
                    HASH_MD5_RFQ: $('#HASH_MD5_RFQ').val(),
                    NO_URUT_RFQ: $('#NO_URUT_RFQ').val()
                };
                console.log(form_data);
                $.ajax({
                    url: "<?php echo site_url('RFQ_form/kirim_email_rfq'); ?>",
                    type: 'POST',
                    data: form_data,
                    success: function(data) {
                        if (data != 'true') {
                            $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                        } else {
                            var HASH_MD5_RFQ = $('#HASH_MD5_RFQ').val()
                            var alamat = "<?php echo base_url('RFQ_form/view/'); ?>" + HASH_MD5_RFQ;
                            window.open(
                                alamat,
                                '_blank' // <- This is what makes it open in a new window.
                            );
                        }
                    }
                });
                return false;
            });
        });
    </script>

    </body>

    </html>