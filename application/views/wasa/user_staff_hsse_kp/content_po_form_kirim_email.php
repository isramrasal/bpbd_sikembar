<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Kirim Email PO</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/PO/') ?>">PO</a>
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

    <!-- Form PO -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Kirim Email PO</h5>
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
                    <input type="hidden" name="HASH_MD5_PO" id="HASH_MD5_PO" class="form-control" value="<?php echo $HASH_MD5_PO; ?>" enable> </br>
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
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $LOKASI_PENYERAHAN; ?>" disabled></div>
                        </div>

                        <!-- <?php
                        if (!isset($NAMA_VENDOR)) { ?>
                            <div class="form-group"><label class="col-sm-2 control-label">Vendor:</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="tidak ada nama vendor" disabled></div>
                            </div>
                        <?php } else { ?>
                            <div class="form-group"><label class="col-sm-2 control-label">Vendor:</label>
                                <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_VENDOR; ?>" disabled></div>
                            </div>
                        <?php } ?> -->

                        <div class="form-group"><label class="col-sm-2 control-label">Vendor:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_VENDOR; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Term Of Payment:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $TERM_OF_PAYMENT; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Batas akhir Konfirmasi PO:</label>
                            <div class="col-sm-10"><input type="date" class="form-control" value="<?php echo $TANGGAL_KIRIM_BARANG_HARI; ?>" disabled></div>
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
                            <br></br>
                            </textarea>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Isi body email:</label>
                            <div class="col-sm-10">
                                <textarea style="width:100%" rows="12" name="ISI_BODY" id="ISI_BODY" required>Terlampir file PO dari kami. Mohon untuk memberikan penawaran harga melalui link berikut:<br></br>
                            Mohon berikan penawaran harga sebelum tanggal: <?php echo $TANGGAL_KIRIM_BARANG_HARI; ?><br></br> <br></br>
                            Terima kasih.
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
                            <button class="btn btn-primary" id="btn_kirim_email_vendor"><i class="fa fa-save"></i> Kirim Email Vendor</button>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Form PO -->
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

            //fungsi tampil data penyerahan vendor top
            function tampil_data_po_penyerahan_vendor_top() {
                var ID_PO = ID_PO;
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url('PO_form/get_data_po') ?>",
                    dataType: "JSON",
                    data: {
                        ID_PO: ID_PO
                    },
                    success: function(data) {
                        $.each(data, function() {
                            $('#ModalEdit').modal('show');
                            $('[name="ID_PO_FORM2"]').val(data.ID_PO_FORM);
                            $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                            $('[name="NAMA2"]').val(data.NAMA_BARANG);
                            $('[name="MEREK2"]').val(data.MEREK);
                            $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                            $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_MINTA);
                            $('[name="TANGGAL_MULAI_PAKAI2"]').val(data.TANGGAL_MULAI_PAKAI);
                            $('[name="TANGGAL_SELESAI_PAKAI2"]').val(data.TANGGAL_SELESAI_PAKAI);
                            $('#alert-msg-2').html('<div></div>');
                        });
                    }
                });
                return false;

            }

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
                        console.log(data);
                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            let jumlah_barang = data[i].JUMLAH_MINTA;
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

            // //GET UPDATE untuk edit jumlah
            // $('#show_data').on('click', '.item_edit', function() {
            //     var id = $(this).attr('data');
            //     $.ajax({
            //         type: "GET",
            //         url: "<?php echo base_url('PO_form/get_data') ?>",
            //         dataType: "JSON",
            //         data: {
            //             id: id
            //         },
            //         success: function(data) {
            //             $.each(data, function() {
            //                 $('#ModalEdit').modal('show');
            //                 $('[name="LOKASI_PENYERAHAN"]').val(data.LOKASI_PENYERAHAN);
            //                 $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
            //                 $('[name="NAMA2"]').val(data.NAMA_BARANG);
            //                 $('[name="MEREK2"]').val(data.MEREK);
            //             });
            //         }
            //     });
            //     return false;
            // });

            // //UPDATE JUSTIFIKASI BARANG 
            // $('#btn_update_keterangan_barang').on('click', function() {

            //     let ID_PO_FORM = $('#ID_PO_FORM5').val();
            //     let KETERANGAN = $('#KETERANGAN5').val();
            //     $.ajax({
            //         url: "<?php echo site_url('PO_form/update_data_keterangan_barang') ?>",
            //         type: "POST",
            //         dataType: "JSON",
            //         data: {
            //             ID_PO_FORM: ID_PO_FORM,
            //             KETERANGAN: KETERANGAN
            //         },
            //         success: function(data) {
            //             if (data == true) {
            //                 $('#ModalEditKeteranganBarang').modal('hide');
            //                 window.location.reload();
            //             } else {
            //                 $('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
            //             }
            //         }
            //     });
            //     return false;
            // });

            // //SIMPAN DATA
            // $('#btn_simpan_data_di_luar_barang_master').click(function() {
            //     var form_data = {
            //         ID_PO: ID_PO,
            //         NAMA: $('#NAMA_4').val(),
            //         MEREK: $('#MEREK_4').val(),
            //         JENIS_BARANG: $('#JENIS_BARANG_4').val(),
            //         SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
            //         SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
            //         JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
            //     };
            //     $.ajax({
            //         url: "<?php echo site_url('PO_form/simpan_data_di_luar_barang_master'); ?>",
            //         type: 'POST',
            //         data: form_data,
            //         success: function(data) {
            //             if (data != '') {
            //                 $('#alert-msg1').html('<div class="alert alert-danger">' + data + '</div>');
            //             } else {
            //                 $('#ModalAdd').modal('hide');
            //                 window.location.reload();
            //             }
            //         }
            //     });
            //     return false;
            // });

            //SIMPAN PERUBAHAN DAN LIHAT PDF
            $('#btn_kirim_email_vendor').click(function() {
                var form_data = {
                    ID_PO: ID_PO,
                    NAMA_PIC_VENDOR: $('#NAMA_PIC_VENDOR').val(),
                    EMAIL_PIC_VENDOR: $('#EMAIL_PIC_VENDOR').val(),
                    SALAM_PEMBUKA: $('#SALAM_PEMBUKA').val(),
                    ISI_BODY: $('#ISI_BODY').val(),
                    HASH_MD5_PO: $('#HASH_MD5_PO').val(),
                    NO_URUT_PO: $('#NO_URUT_PO').val()
                };
                $.ajax({
                    url: "<?php echo site_url('PO_form/kirim_email_po'); ?>",
                    type: 'POST',
                    data: form_data,
                    success: function(data) {
                        if (data != 'true') {
                            $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                        } else {
                            var HASH_MD5_PO = $('#HASH_MD5_PO').val()
                            var alamat = "<?php echo base_url('PO_form/view/'); ?>" + HASH_MD5_PO;
                            window.open(
                                alamat,
                                '_blank' // <- This is what makes it open in a new window.
                            );
                        }
                    }
                });
                return false;
            });

            // //GET UDPATE untuk berikan justifkasi
            // $('#show_data').on('click', '.item_edit_keterangan', function() {
            //     var id = $(this).attr('data');
            //     $.ajax({
            //         type: "GET",
            //         url: "<?php echo base_url('PO_form/get_data') ?>",
            //         dataType: "JSON",
            //         data: {
            //             id: id
            //         },
            //         success: function(data) {
            //             $.each(data, function() {
            //                 $('#ModalEditKeteranganBarang').modal('show');
            //                 $('[name="ID_PO_FORM5"]').val(data.ID_PO_FORM);
            //                 $('[name="KODE_BARANG5"]').val(data.KODE_BARANG);
            //                 $('[name="NAMA5"]').val(data.NAMA_BARANG);
            //                 $('[name="MEREK5"]').val(data.MEREK);
            //                 $('[name="SPESIFIKASI_SINGKAT5"]').val(data.SPESIFIKASI_SINGKAT);
            //                 $('[name="JUMLAH_BARANG5"]').val(data.JUMLAH_MINTA);
            //                 $('[name="KETERANGAN5"]').val(data.KETERANGAN);
            //                 $('#alert-msg-5').html('<div></div>');
            //             });
            //         }
            //     });
            //     return false;
            // });



            // //UPDATE DATA 
            // $('#btn_update').on('click', function() {

            //     let ID_PO_FORM = $('#ID_PO_FORM2').val();
            //     let MEREK = $('#MEREK2').val();
            //     let SPESIFIKASI_SINGKAT = $('#SPESIFIKASI_SINGKAT2').val();
            //     let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
            //     let NAMA = $('#NAMA2').val();

            //     $.ajax({
            //         url: "<?php echo site_url('PO_form/update_data') ?>",
            //         type: "POST",
            //         dataType: "JSON",
            //         data: {
            //             ID_PO: ID_PO,
            //             ID_PO_FORM: ID_PO_FORM,
            //             NAMA: NAMA,
            //             MEREK: MEREK,
            //             SPESIFIKASI_SINGKAT: SPESIFIKASI_SINGKAT,
            //             JUMLAH_BARANG: JUMLAH_BARANG
            //         },
            //         success: function(data) {
            //             if (data == true) {
            //                 $('#ModalEdit').modal('hide');
            //                 window.location.reload();
            //             } else {
            //                 $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
            //             }
            //         }
            //     });
            //     return false;
            // });



            // //GET HAPUS
            // $('#show_data').on('click', '.item_hapus', function() {
            //     var id = $(this).attr('data');
            //     $.ajax({
            //         type: "GET",
            //         url: "<?php echo base_url('PO_form/get_data') ?>",
            //         dataType: "JSON",
            //         data: {
            //             id: id
            //         },
            //         success: function(data) {
            //             $.each(data, function() {
            //                 $('#ModalHapus').modal('show');
            //                 $('[name="kode"]').val(id);
            //                 $('#NAMA_3').html('</br>Nama Barang : ' + data.NAMA_BARANG);

            //             });
            //         }
            //     });
            // });

            // //HAPUS DATA
            // $('#btn_hapus').on('click', function() {
            //     var kode = $('#textkode').val();
            //     $.ajax({
            //         type: "POST",
            //         url: "<?php echo base_url('PO_form/hapus_data') ?>",
            //         dataType: "JSON",
            //         data: {
            //             kode: kode
            //         },
            //         success: function(data) {
            //             $('#ModalHapus').modal('hide');
            //             window.location.reload();
            //         }
            //     });
            //     return false;
            // });

            // $('#saya_setuju').click(function() {
            //     //check if checkbox is checked
            //     if ($(this).is(':checked')) {

            //         $('#btn_update_kirim_po').removeAttr('disabled'); //enable input

            //     } else {
            //         $('#btn_update_kirim_po').attr('disabled', true); //disable input
            //     }
            // });


            // //UPDATE KIRIM SPPB 
            // $('#btn_update_kirim_sppb').on('click', function() {

            //     let ID_SPPB = $('#ID_SPPB7').val();
            //     $.ajax({
            //         url: "<?php echo site_url('SPPB_form/update_data_kirim_sppb') ?>",
            //         type: "POST",
            //         dataType: "JSON",
            //         data: {
            //             ID_SPPB: ID_SPPB,
            //         },
            //         success: function(data) {
            //             if (data == true) {
            //                 $('#ModalEditKirimSPPB').modal('hide');
            //                 window.location.href = '<?php echo site_url('SPPB') ?>';
            //             } else {
            //                 $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
            //             }
            //         }
            //     });
            //     return false;
            // });

        });
    </script>

    </body>

    </html>