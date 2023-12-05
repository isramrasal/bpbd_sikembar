<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form KHP</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/KHP/') ?>">KHP</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form KHP</a>
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

    <!-- Form KHP -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Formulir Pengajuan KHP</h5>
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
                        if (isset($SPPB)) {
                            foreach ($SPPB->result() as $SPPB) :
                        ?>
                                <div class="form-group"><label class="col-sm-2 control-label">No. Urut SPPB:</label>
                                    <div class="col-sm-10">
                                        <a href="<?php echo base_url() ?>SPPB_form/view/<?php echo $SPPB->HASH_MD5_SPPB; ?>" class="form-control" target="_blank"><?php echo $SPPB->NO_URUT_SPPB; ?> </a>
                                    </div>
                                </div>

                                <div class="form-group"><label class="col-sm-2 control-label">Proyek:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->NAMA_PROYEK; ?>" disabled></div>
                                </div>
                        <?php endforeach;
                        } ?>

                        <?php
                        if (isset($KHP)) {
                            foreach ($KHP->result() as $KHP) :
                        ?>

                                <div class="form-group"><label class="col-sm-2 control-label">No Urut KHP:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $KHP->NO_URUT_KHP; ?>" disabled></div>
                                </div>

                        <?php endforeach;
                        } ?>

                    </div>
                    <br>
                    <hr>
                    <div class="form-horizontal">

                        <div class="alert alert-warning alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Perubahan data pada form KHP tidak akan mempengaruhi data pada form SPPB.
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="mydata">
                                <div>
                                    <thead>
                                        <tr>
                                            <th style='width: 5px;'>Pilihan</th>
                                            <th style='width: 5px;'>Nama </br> Barang</th>
                                            <th style='width: 5px;'>Merek </br> Barang</th>
                                            <th style='width: 5px;'>Jenis </br> Barang</th>
                                            <th style='width: 5px;'>Spesifikasi </br> Singkat</th>
                                            <th style='width: 5px;'>Jumlah </br> Yang </br> Diadakan</th>
                                            <th style='width: 325px;'>Pengajuan </br> Vendor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">
                                    </tbody>
                                </div>
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
                            <button class="btn btn-primary" id="btn_simpan_perubahan_pdf"><i class="fa fa-save"></i> Simpan Perubahan & View Dokumen KHP</button>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Form KHP -->
    </div>
</div>


<!-- MODAL KIRIM KHP-->
<div class="modal inmodal fade" id="ModalEditKirimKHP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 60vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Lanjutkan Proses KHP</h4>
                <small class="font-bold">Selesaikan pengisian Form KHP ini untuk proses selanjutnya</small>
            </div>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT_KHP" id="JUMLAH_COUNT_KHP" disabled />

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut KHP:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_KHP" id="NO_URUT_KHP" disabled />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama Vendor:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NAMA_VENDOR" id="NAMA_VENDOR" />
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form KHP ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="alert-msg-3"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_khp" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM KHP-->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalPengajuanVendor" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Tambah Pengajuan Harga Barang/Jasa</h4>
                <small class="font-bold">Silakan tambah pengajuan harga barang/jasa KHP</small>
            </div>
            <?php $attributes = array("ID_KHP_FORM2" => "contact_form", "id" => "contact_form");
            echo form_open("KHP_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_KHP_FORM2" id="ID_KHP_FORM2" class="form-control" type="hidden" readonly>
                    <input name="ID_KHP2" id="ID_KHP2" class="form-control" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA2" id="NAMA2" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek</label>
                        <div class="col-xs-9">
                            <input name="MEREK2" id="MEREK2" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT2" id="SPESIFIKASI_SINGKAT2" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG2" id="JUMLAH_BARANG2" class="form-control touchspin1" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Vendor</label>
                        <div class="col-xs-9">
                            <input name="NAMA_VENDOR2" id="NAMA_VENDOR2" class="form-control touchspin1" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Item Barang (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG2" id="HARGA_SATUAN_BARANG2" class="form-control" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Total Harga (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_TOTAL2" id="HARGA_TOTAL2" class="form-control" type="hidden" disabled>
                            <input name="HARGA_TOTAL_TAMPIL2" id="HARGA_TOTAL_TAMPIL2" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Term Of Payment</label>
                        <div class="col-xs-9">
                            <input name="SISTEM_BAYAR_VENDOR2" id="SISTEM_BAYAR_VENDOR2" class="form-control">
                        </div>
                    </div>

                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_tambah_vendor"><i class="fa fa-save"></i> Tambah</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->


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
        var ID_KHP = <?php echo $ID_KHP;  ?>;

        $("#HARGA_SATUAN_BARANG2").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG2").val();
            console.log(HARGA);
            var JUMLAH = $("#JUMLAH_BARANG2").val();
            console.log(JUMLAH);

            var TOTAL = HARGA * JUMLAH;
            console.log(TOTAL);

            $('[name="HARGA_TOTAL2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });



        tampil_data_form_khp(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 100,
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
                    title: 'KHP Form'
                },
                {
                    extend: 'pdf',
                    title: 'KHP Form'
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
        function tampil_data_form_khp() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>KHP_form/data_khp_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_KHP
                },
                success: function(data) {
                    var data_1 = data;
                    var html, penawaran = '';
                    console.log(data_1);

                    for (i = 0; i < data.length; i++) {

                        var form_data = {
                            ID_SPPB_FORM: data_1[i].ID_SPPB_FORM,
                        };

                        $.ajax({
                            url: "<?php echo site_url('KHP_form/get_list_pengajuan_vendor_by_id_sppb_form') ?>",
                            type: "POST",
                            dataType: "JSON",
                            async: false,
                            data: {
                                ID_SPPB_FORM: data_1[i].ID_SPPB_FORM,
                                ID_KHP: data_1[i].ID_KHP
                            },
                            success: function(data) {

                                var data_2 = data;
                                var KHP = '';

                                let jumlah_barang = data_1[i].JUMLAH_MINTA;
                                let kode_barang = data_1[i].KODE_BARANG;

                                if (kode_barang != null) {
                                    kode_barang_cetak = '<a href="<?php echo base_url() ?>barang_master/profil_barang_master/' + data_1[i].HASH_MD5_BARANG_MASTER + '" class="btn btn-warning btn-xs btn-outline block" target="_blank"><i class="fa fa-eye"></i> ' + kode_barang + ' </a>';
                                }
                                if (kode_barang == null) {
                                    kode_barang_cetak = '<span class="label label-info block"><i class="fa fa-warning"></i> Data Baru</span>';
                                }

                                if (jumlah_barang == null) {
                                    jumlah_barang = 0;
                                }
                                if (kode_barang == null) {
                                    kode_barang = `<span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span>`;
                                }

                                for (l = 0; l < data_2.length; l++) {
                                    console.log(data_2[l].HARGA_SATUAN_BARANG);

                                    var no_urut = l + 1;
                                    penawaran += no_urut + ". " + data_2[l].NAMA_VENDOR + "</br>-Harga satuan barang: Rp" + data_2[l].HARGA_SATUAN_BARANG + "</br> -Harga total barang: Rp" + data_2[l].HARGA_TOTAL + "</br> -TOP: " + data_2[l].SISTEM_BAYAR_VENDOR + '<div class="hr-line-dashed"></div>';
                                }

                                html +=
                                    '<tr>' +
                                    '<td>' +
                                    '<a href="javascript:;" class="btn btn-primary btn-xs item_pengajuan block" data="' + data_1[i].ID_KHP_FORM + '"><i class="fa fa-plus"></i> Pengajuan</br>Vendor</a>' + ' ' +
                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data_1[i].ID_KHP_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' +
                                    '</td>' +
                                    '<td>' + data_1[i].NAMA_BARANG + '</td>' +
                                    '<td>' + data_1[i].MEREK + '</td>' +
                                    '<td>' + data_1[i].NAMA_JENIS_BARANG + '</td>' +
                                    '<td>' + data_1[i].SPESIFIKASI_SINGKAT + '</td>' +
                                    '<td>' + jumlah_barang + ' ' + data_1[i].NAMA_SATUAN_BARANG + '</td>' +
                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_KHP_FORM + '"><i class="fa fa-trash"></i> Hapus Item Barang</a>' +
                                    '</td>' +
                                    '<td>' + penawaran + '</td>' +
                                    '</tr>';
                                penawaran = '';
                            }
                        });
                    }
                    $('#show_data').html(html);
                }
            });
        }

        //GET UPDATE untuk edit pengajuan
        $('#show_data').on('click', '.item_pengajuan', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('KHP_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalPengajuanVendor').modal('show');
                        $('[name="ID_KHP_FORM2"]').val(data.ID_KHP_FORM);
                        $('[name="ID_KHP2"]').val(data.ID_KHP);
                        $('[name="NAMA2"]').val(data.NAMA_BARANG);
                        $('[name="MEREK2"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_MINTA);
                    });
                }
            });
            return false;
        });

        //UPDATE JUSTIFIKASI BARANG 
        $('#btn_update_keterangan_barang').on('click', function() {

            let ID_KHP_FORM = $('#ID_KHP_FORM5').val();
            let KETERANGAN = $('#KETERANGAN5').val();
            $.ajax({
                url: "<?php echo site_url('KHP_form/update_data_keterangan_barang') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_KHP_FORM: ID_KHP_FORM,
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

        //SIMPAN DATA
        $('#btn_simpan_data_di_luar_barang_master').click(function() {
            var form_data = {
                ID_KHP: ID_KHP,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('KHP_form/simpan_data_di_luar_barang_master'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg1').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $('#ModalAdd').modal('hide');
                        window.location.reload();
                    }
                }
            });
            return false;
        });

        //SIMPAN PERUBAHAN DAN LIHAT PDF
        $('#btn_simpan_perubahan_pdf').click(function() {
            var form_data = {
                ID_KHP: ID_KHP,
                LOKASI_PENYERAHAN: $('#LOKASI_PENYERAHAN').val(),
                ID_VENDOR: $('#ID_VENDOR').val(),
                TOP: $('#TOP').val()
            };
            $.ajax({
                url: "<?php echo site_url('KHP_form/simpan_perubahan_pdf'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 'true') {
                        $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var HASH_MD5_KHP = $('#HASH_MD5_KHP').val()
                        var alamat = "<?php echo base_url('KHP_form/view/'); ?>" + HASH_MD5_KHP;
                        window.open(
                            alamat,
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                }
            });
            return false;
        });


        //UPDATE DATA 
        $('#btn_tambah_vendor').on('click', function() {

            let ID_KHP_FORM = $('#ID_KHP_FORM2').val();
            let ID_KHP = $('#ID_KHP').val();
            let NAMA = $('#NAMA2').val();
            let MEREK = $('#MEREK2').val();
            let SPESIFIKASI_SINGKAT = $('#SPESIFIKASI_SINGKAT2').val();
            let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
            let NAMA_VENDOR = $('#NAMA_VENDOR2').val();
            let HARGA_SATUAN_BARANG = $('#HARGA_SATUAN_BARANG2').val();
            let HARGA_TOTAL = $('#HARGA_TOTAL2').val();
            let SISTEM_BAYAR_VENDOR = $('#SISTEM_BAYAR_VENDOR2').val();

            $.ajax({
                url: "<?php echo site_url('KHP_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_KHP: ID_KHP,
                    ID_KHP_FORM: ID_KHP_FORM,
                    NAMA: NAMA,
                    MEREK: MEREK,
                    SPESIFIKASI_SINGKAT: SPESIFIKASI_SINGKAT,
                    JUMLAH_BARANG: JUMLAH_BARANG
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEdit').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });



        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('KHP_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(id);
                        $('#NAMA_3').html('</br>Nama Barang : ' + data.NAMA_BARANG);

                    });
                }
            });
        });

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('KHP_form/hapus_data') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    $('#ModalHapus').modal('hide');
                    window.location.reload();
                }
            });
            return false;
        });

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_khp').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_khp').attr('disabled', true); //disable input
            }
        });


        //UPDATE KIRIM SPPB 
        $('#btn_update_kirim_sppb').on('click', function() {

            let ID_SPPB = $('#ID_SPPB7').val();
            $.ajax({
                url: "<?php echo site_url('SPPB_form/update_data_kirim_sppb') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPPB: ID_SPPB,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimSPPB').modal('hide');
                        window.location.href = '<?php echo site_url('SPPB') ?>';
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