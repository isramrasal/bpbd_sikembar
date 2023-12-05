<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form Rencana Pengiriman Barang</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/Rencana_pengiriman_barang/') ?>">Rencana Pengiriman Barang</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form Rencana Pengiriman Barang</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<!-- Form Rencana Pengiriman Barang -->
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Pastikan Anda mengisi data dengan benar.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Formulir Pengajuan Rencana Pengiriman Barang</h5>
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
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab">Identitas Form RPB</a></li>

                        </ul>
                        <div class="tab-content">

                            <div class="panel-body">
                                <form method="get" class="form-horizontal">
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
                                    if (isset($RPB)) {
                                        foreach ($RPB->result() as $RPB) :
                                    ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">No Urut RPB:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $RPB->NO_RENCANA_PENGIRIMAN_BARANG; ?>" disabled></div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label">Nama Pengirim:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $RPB->NAMA_PENGIRIM; ?>" placeholder="Pandy Maulana" disabled></div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label">Nomor HP Pengirim:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $RPB->NO_HP_PENGIRIM; ?>" placeholder="0878098291" disabled></div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label">Kepada:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $RPB->KEPADA; ?>" placeholder="Rifky Giaraka" disabled></div>
                                            </div>

                                            <div class="form-group"><label class="col-sm-2 control-label">Tujuan:</label>
                                                <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $RPB->TUJUAN; ?>" placeholder="JL. Raya Cakung Cilincing, Km 1 No.11 Gedung WASA, RT.11/RW.7, Cakung Bar., Kec. Cakung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13910" disabled></div>
                                            </div>
                                    <?php endforeach;
                                    } ?>

                                    <input style="width:100%" name="HASH_MD5_RENCANA_PENGIRIMAN_BARANG" id="HASH_MD5_RENCANA_PENGIRIMAN_BARANG" type="hidden" value="<?php echo $HASH_MD5_RENCANA_PENGIRIMAN_BARANG; ?>">

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Rencana Pengiriman Barang</h5>
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
                                    Perubahan data pada form RPB tidak akan mempengaruhi data pada form PO.
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="mydata">
                                        <thead>
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Merek Barang</th>
                                                <th>Jenis Barang</th>
                                                <th>Spesifikasi Singkat</th>
                                                <th>Satuan Barang</th>
                                                <th>Jumlah Yang Diadakan</th>
                                                <th>Jumlah Barang Yang Dikirim</th>
                                                <th>Pilihan</th>
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
                                    <a href="<?php echo base_url('Rencana_Pengiriman_Barang_form/view/'); ?><?php echo $HASH_MD5_RENCANA_PENGIRIMAN_BARANG; ?> " class="btn btn-primary"><i class="fa fa-save"></i> Simpan Perubahan & View Dokumen RPB</a><br>
                                    <a href="javascript:;" id="item_edit_kirim_rpb" name="item_edit_kirim_rpb" class="btn btn-success" data="<?php echo $ID_RENCANA_PENGIRIMAN_BARANG; ?>"><span class="fa fa-send"></span> Ajukan RPB Untuk Proses Selanjutnya </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Form RPB -->

<!-- MODAL ADD FROM MASTER LIST -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <?php
            if ($barang_master_list != NULL) {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-suitcase modal-icon"></i>
                    <h4 class="modal-title">Daftar Master List</h4>
                    <small class="font-bold">Silakan isi data RPB berdasarkan daftar Master List/Price List</small>

                </div>

                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="alert alert-info alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Daftar Master List berikut adalah daftar barang yang tidak termasuk dalam RASD proyek
                        </div>
                        <div class="table-responsive">

                            <form method="POST" action="<?php echo site_url('Rencana_Pengiriman_Barang_form/simpan_data_dari_barang_master'); ?>" id="formTambahMASTER">
                                <table class="table table-striped table-bordered table-hover" id="modalmaster">
                                    <thead>
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Merek Barang</th>
                                            <th>Jenis Barang</th>
                                            <th style="width: 30%;">Spesifikasi Singkat</th>
                                            <th>Satuan Barang</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($barang_master_list as $data) : ?>
                                            <tr>
                                                <td>
                                                    <input name="ID_PO" class="form-control" type="text" value="<?php echo $ID_PO  ?>" style="display: none;" readonly>
                                                    <input class="checkbox" name="ID_BARANG_MASTER[]" value="<?php echo $data->ID_BARANG_MASTER ?>" type="checkbox">
                                                </td>
                                                <td><a href="<?php echo base_url() ?>barang_master/profil_barang_master/<?php echo $data->HASH_MD5_BARANG_MASTER; ?>" class="btn btn-warning btn-xs btn-outline block" target="_blank"><i class="fa fa-eye"></i> <?php echo $data->KODE_BARANG; ?> </a>
                                                </td>
                                                <td> <?php echo $data->NAMA; ?> </td>
                                                <td> <?php echo $data->MEREK; ?> </td>
                                                <td> <?php echo $data->NAMA_JENIS_BARANG; ?> </td>
                                                <td> <?php echo $data->SPESIFIKASI_SINGKAT; ?> </td>
                                                <td> <?php echo $data->NAMA_SATUAN_BARANG; ?> </td>
                                                <td style="width: 20%;">
                                                    <input class=" touchspin1" type="text" value="0" name="<?php echo $data->ID_BARANG_MASTER ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                        ?>
                                    </tbody>
                                </table>

                            </form>
                        </div>
                        <div id="alert-msg"></div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                        <button class="btn btn-primary" type="submit" form="formTambahMASTER"><i class="fa fa-save"></i> Tambah</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            <?php
            } else {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-exclamation-triangle modal-icon"></i>
                    <h4 class="modal-title">Form FPB dari Master List</h4>
                    <b class="font-bold">Maaf semua barang dari master list sudah ada di FPB ini</b>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!--END MODAL ADD-->

<!-- MODAL EDIT JUMLAH BARANG KIRIM-->
<div class="modal inmodal fade" id="ModalEditJumlah" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Rencana Pengiriman Barang</h4>
                <small class="font-bold">Silakan isi barang yang akan dikirim</small>
            </div>

            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_RENCANA_PENGIRIMAN_BARANG_FORM5" id="ID_RENCANA_PENGIRIMAN_BARANG_FORM5" class="form-control" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA5" id="NAMA5" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek</label>
                        <div class="col-xs-9">
                            <input name="MEREK5" id="MEREK5" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT5" id="SPESIFIKASI_SINGKAT5" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang Yang Diadakan</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG5" id="JUMLAH_BARANG5" class="form-control" type="number" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang Yang Dikirim</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG_KIRIM5" id="JUMLAH_BARANG_KIRIM5" class="form-control" type="number">
                        </div>
                    </div>

                    <div id="alert-msg-5"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_jumlah_barang"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT JUMLAH BARANG KIRIM-->

<!-- MODAL KIRIM RPB-->
<div class="modal inmodal fade" id="ModalEditKirimRPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim Rencana Pengiriman Barang</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form Rencana Pengiriman Barang ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_FPB7" => "contact_form", "id" => "contact_form");
            echo form_open("FPB_form/update_data_kirim_fpb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_RENCANA_PENGIRIMAN_BARANG7" id="ID_RENCANA_PENGIRIMAN_BARANG7" class="form-control" type="hidden" placeholder="ID FPB" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="i-checks"><input type="checkbox" id="saya_setuju">
                            Saya telah selesai melakukan proses form Rencana Pengiriman Barang ini dan menyetujui untuk diproses lebih lanjut
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_minta" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item jumlah barang yang bernilai 0</center>
                        </div>
                    </div>


                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_rpb" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM RPB-->


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
    $("#HARGA_SATUAN_BARANG_FIX_4").on("change", function() {

        var HARGA = $("#HARGA_SATUAN_BARANG_FIX_4").val();
        console.log(HARGA);
        var JUMLAH = $("#JUMLAH_BARANG_4").val();
        console.log(JUMLAH);

        var TOTAL = HARGA * JUMLAH;
        console.log(TOTAL);

        $('[name="HARGA_TOTAL_FIX_4"]').val(TOTAL);
        $('[name="HARGA_TOTAL_TAMPIL_4"]').val(new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(TOTAL));

    });

    $("#HARGA_SATUAN_BARANG_FIX2").on("change", function() {

        var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
        console.log(HARGA);
        var JUMLAH = $("#JUMLAH_BARANG2").val();
        console.log(JUMLAH);

        var TOTAL = HARGA * JUMLAH;
        console.log(TOTAL);

        $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
        $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(TOTAL));

    });

    $(document).ready(function() {
        var ID_RENCANA_PENGIRIMAN_BARANG = <?php echo $ID_RENCANA_PENGIRIMAN_BARANG;  ?>;
        var ID_PO = <?php echo $ID_PO;  ?>;

        $("#ID_VENDOR").change(function() {
            if ($("#ID_VENDOR option:selected").text() == '- Vendor Lainnya -') {
                console.log($("#ID_VENDOR").val());
                $('#show_hidden_vendor').attr("hidden", false); //enable input
                $('#show_hidden_vendor_2').attr("hidden", false); //enable input
                $('#show_hidden_vendor_3').attr("hidden", false); //enable input
                $('#show_hidden_vendor_4').attr("hidden", false); //enable input
                $('#show_hidden_vendor_5').attr("hidden", false); //enable input
                $('#show_hidden_vendor_6').attr("hidden", false); //enable input
                $('#show_hidden_vendor_7').attr("hidden", false); //enable input
            } else {
                $('#show_hidden_vendor').attr("hidden", true); //enable input
                $('#show_hidden_vendor_2').attr("hidden", true); //enable input
                $('#show_hidden_vendor_3').attr("hidden", true); //enable input
                $('#show_hidden_vendor_4').attr("hidden", true); //enable input
                $('#show_hidden_vendor_5').attr("hidden", true); //enable input
                $('#show_hidden_vendor_6').attr("hidden", true); //enable input
                $('#show_hidden_vendor_7').attr("hidden", true); //enable input
            }
        });

        tampil_data_form_rpb(); //pemanggilan fungsi tampil data.

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
                    title: 'RPB Form'
                },
                {
                    extend: 'pdf',
                    title: 'RPB Form'
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

        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999,
        });

        //fungsi tampil data penyerahan vendor top
        function tampil_data_po_penyerahan_vendor_top() {
            var ID_PO = ID_PO;
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('Rencana_Pengiriman_Barang_form/get_data_po') ?>",
                dataType: "JSON",
                data: {
                    ID_PO: ID_PO
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEdit').modal('show');
                        $('[name="ID_Rencana_Pengiriman_Barang_form2"]').val(data.ID_Rencana_Pengiriman_Barang_form);
                        $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                        $('[name="NAMA2"]').val(data.NAMA_BARANG);
                        $('[name="MEREK2"]').val(data.MEREK);
                        $('[name="JENIS_BARANG2"]').val(data.JENIS_BARANG);
                        $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="SATUAN_BARANG2"]').val(data.SATUAN_BARANG);
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
        function tampil_data_form_rpb() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>Rencana_Pengiriman_Barang_form/data_rpb_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_RENCANA_PENGIRIMAN_BARANG
                },
                success: function(data) {
                    console.log(data);
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_BARANG;
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
                        // if (jumlah_rasd == null) {
                        //     jumlah_rasd = 0;
                        // }
                        html += '<tr>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                            '<td>' + data[i].JUMLAH_BARANG + '</td>' +
                            '<td>' + data[i].JUMLAH_BARANG_KIRIM + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-success btn-xs item_edit_jumlah block" data="' + data[i].ID_RENCANA_PENGIRIMAN_BARANG_FORM + '"><i class="fa fa-pencil  "></i> Edit Jumah Barang Yang Dikirim </a>' + ' ' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        //UPDATE JUSTIFIKASI BARANG 
        $('#btn_update_keterangan_barang').on('click', function() {

            let ID_RENCANA_PENGIRIMAN_BARANG_FORM = $('#ID_RENCANA_PENGIRIMAN_BARANG_FORM5').val();
            let KETERANGAN = $('#KETERANGAN5').val();
            $.ajax({
                url: "<?php echo site_url('Rencana_Pengiriman_Barang_form/update_data_keterangan_barang') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_RENCANA_PENGIRIMAN_BARANG_FORM: ID_RENCANA_PENGIRIMAN_BARANG_FORM,
                    KETERANGAN: KETERANGAN
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKeteranganBarang').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //UPDATE JUMLAH BARANG 
        $('#btn_update_jumlah_barang').on('click', function() {

            let ID_RENCANA_PENGIRIMAN_BARANG_FORM = $('#ID_RENCANA_PENGIRIMAN_BARANG_FORM5').val();
            let JUMLAH_BARANG_KIRIM = $('#JUMLAH_BARANG_KIRIM5').val();
            let JUMLAH_BARANG = $('#JUMLAH_BARANG5').val();
            $.ajax({
                url: "<?php echo site_url('Rencana_Pengiriman_Barang_form/update_data_jumlah_barang') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_RENCANA_PENGIRIMAN_BARANG_FORM: ID_RENCANA_PENGIRIMAN_BARANG_FORM,
                    JUMLAH_BARANG_KIRIM: JUMLAH_BARANG_KIRIM,
                    JUMLAH_BARANG: JUMLAH_BARANG
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditJumlah').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //SIMPAN PERUBAHAN DAN LIHAT PDF
        $('#btn_simpan_perubahan_pdf').click(function() {
            var form_data = {
                ID_RENCANA_PENGIRIMAN_BARANG: ID_RENCANA_PENGIRIMAN_BARANG,
                ID_PO: $('#ID_PO').val(),
                NAMA_PENGIRIM: $('#NAMA_PENGIRIM').val(),
                NO_HP_PENGIRIM: $('#NO_HP_PENGIRIM').val(),
                KEPADA: $('#KEPADA').val(),
                TUJUAN: $('#TUJUAN').val()
            };
            $.ajax({
                url: "<?php echo site_url('Rencana_Pengiriman_Barang_form/simpan_perubahan_pdf'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 'true') {
                        $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var HASH_MD5_RENCANA_PENGIRIMAN_BARANG = $('#HASH_MD5_RENCANA_PENGIRIMAN_BARANG').val()
                        var alamat = "<?php echo base_url('Rencana_Pengiriman_Barang_form/view/'); ?>" + HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
                        window.open(
                            alamat,
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                }
            });
            return false;
        });

        //GET UDPATE untuk berikan justifkasi
        $('#show_data').on('click', '.item_edit_jumlah', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('Rencana_Pengiriman_Barang_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditJumlah').modal('show');
                        $('[name="ID_RENCANA_PENGIRIMAN_BARANG_FORM5"]').val(data.ID_RENCANA_PENGIRIMAN_BARANG_FORM);
                        $('[name="NAMA5"]').val(data.NAMA_BARANG);
                        $('[name="MEREK5"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT5"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG5"]').val(data.JUMLAH_BARANG);
                        $('[name="JUMLAH_BARANG_KIRIM5"]').val(data.JUMLAH_BARANG_KIRIM);
                        $('#alert-msg-5').html('<div></div>');
                    });
                }
            });
            return false;
        });


        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_rpb').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_rpb').attr('disabled', true); //disable input
            }
        });

        item_edit_kirim_rpb.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('Rencana_Pengiriman_Barang_form/data_rpb_form') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#ModalEditKirimRPB').modal('show');
                    $.each(data, function() {
                        $('[name="ID_RENCANA_PENGIRIMAN_BARANG7"]').val(data[0].ID_RENCANA_PENGIRIMAN_BARANG);
                    });

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM  
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);
                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        let i = 0;
                        for (i = 0; i < data.length; i++) {

                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH_BARANG_KIRIM == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_jumlah_minta').attr("hidden", false);
                                break;
                            }

                            //JIKA SEMUA ITEM BARANG ADA JUMLAH MINTANYA (TIDAK NOL)
                            if (i == (data.length - 1)) {
                                $('#show_hidden_setuju').attr("hidden", false);
                            }
                        }
                    }
                }
            });
            return false;
        };

        //UPDATE KIRIM FPB 
        $('#btn_update_kirim_rpb').on('click', function() {

            let ID_FPB = $('#ID_FPB7').val();
            $.ajax({
                url: "<?php echo site_url('Rencana_Pengiriman_Barang_form/update_data_kirim_rpb') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_RENCANA_PENGIRIMAN_BARANG: ID_RENCANA_PENGIRIMAN_BARANG,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimRPB').modal('hide');
                        window.location.href = '<?php echo site_url('Rencana_pengiriman_barang') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });
    });
</script>

</body>

</html>