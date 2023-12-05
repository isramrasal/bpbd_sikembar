<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form SPPB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPPB/') ?>">SPPB</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form SPPB</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <style>
        .container_iframe {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding-top: 56.25%;
            /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
        }

        /* Then style the iframe to fit in the container div with full height and width */
        .responsive-iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }
    </style>

    <!-- Identitas Form SPPB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo $FILE_NAME_TEMP; ?></h5>
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
            <div class="container_iframe">
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/SPPB/') ?><?php echo $FILE_NAME_TEMP; ?>"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/SPPB/') ?>" class="btn btn-info"> Kembali Ke Halaman List SPPB</a>
            <?php if ($PROGRESS_SPPB == "Dalam Proses Supervisi Logistik SP") { ?>
                <a href="<?php echo base_url('index.php/SPPB_form/index/') ?><?php echo $HASH_MD5_SPPB; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah SPPB</a>
                <a href="javascript:;" id="item_edit_kirim_sppb" name="item_edit_kirim_sppb" class="btn btn-success" data="<?php echo $ID_SPPB; ?>"><span class="fa fa-send"></span> Ajukan SPPB Untuk Proses Selanjutnya </a><br>
            <?php
            } ?>
            <?php if ($PROGRESS_SPPB == "Dalam Proses Pembuatan Supervisi Logistik SP") { ?>
                <a href="<?php echo base_url('index.php/SPPB_form/index/') ?><?php echo $HASH_MD5_SPPB; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah SPPB</a>
                <a href="javascript:;" id="item_edit_kirim_sppb" name="item_edit_kirim_sppb" class="btn btn-success" data="<?php echo $ID_SPPB; ?>"><span class="fa fa-send"></span> Ajukan SPPB Untuk Proses Selanjutnya </a><br>
            <?php
            } ?>


        </div>
    </div>
    <!-- End Identitas Form SPPB -->


</div>

<!-- MODAL EDIT KIRIM SPPB-->
<div class="modal inmodal fade" id="ModalEditKirimSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim SPPB</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form SPPB ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_SPPB7" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_kirim_sppb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SPPB7" id="ID_SPPB7" class="form-control" type="hidden" placeholder="ID SPPB" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form SPPB ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang diminta pada SPPB ini</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item jumlah barang yang bernilai 0</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_tanggal_mulai_selesai" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang yang belum diatur tanggal mulai dan selesai pemakaian</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_bidang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang yang belum diatur bidang pemakai</center>
                        </div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_sppb" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM SPPB-->


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
        let ID_SPPB = <?php echo $ID_SPPB  ?>;

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_sppb').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_sppb').attr('disabled', true); //disable input
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
                        $.ajax({
                            type: 'GET',
                            url: '<?php echo base_url() ?>SPPB_form/data_sppb_form',
                            async: false,
                            dataType: 'json',
                            data: {
                                id: ID_SPPB
                            },
                            success: function(data) {
                                var data_1 = data;
                                var html = '';
                                var i, j, k = 0;
                                var jumlah_quantity, jumlah_qty_spp = 0;

                                for (i = 0; i < data_1.length; i++) {

                                    var form_data = {
                                        ID_BARANG_MASTER: data_1[i].ID_BARANG_MASTER,
                                        ID_PROYEK: data_1[i].ID_PROYEK,
                                    };

                                    if (data_1[i].PERALATAN_PERLENGKAPAN == "CONSUMABLE" || data_1[i].PERALATAN_PERLENGKAPAN == "Consumption" || data_1[i].PERALATAN_PERLENGKAPAN == "MATERIAL") {
                                        $.ajax({
                                            url: "<?php echo site_url('SPPB_form/data_qty_consum_material') ?>",
                                            type: "POST",
                                            dataType: "JSON",
                                            async: false,
                                            data: form_data,
                                            success: function(data) {
                                                var data_2 = data;
                                                jumlah_quantity = data_2[0].jumlah_quantity;

                                                if (data_1[i].JUMLAH_MINTA - jumlah_quantity < 0) {
                                                    jumlah_qty_spp = data_1[i].JUMLAH_MINTA;
                                                } else {
                                                    jumlah_qty_spp = data_1[i].JUMLAH_MINTA - jumlah_quantity;
                                                }

                                                var form_data_4 = {
                                                    ID_SPPB: data_1[i].ID_SPPB,
                                                    ID_SPPB_FORM: data_1[i].ID_SPPB_FORM,
                                                    JUMLAH_QTY_GUDANG: jumlah_quantity,
                                                    JUMLAH_QTY_SPP: jumlah_qty_spp
                                                };
                                                $.ajax({
                                                    url: "<?php echo site_url('SPPB_form/update_quantity_spp') ?>",
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    data: form_data_4,
                                                    success: function(data) {
                                                        $('#ModalEditKirimSPPB').modal('hide');
                                                        window.location.href = '<?php echo site_url('SPPB') ?>';
                                                    }
                                                })
                                            }
                                        });
                                    } else {
                                        $.ajax({
                                            url: "<?php echo site_url('SPPB_form/data_qty_entitas') ?>",
                                            type: "POST",
                                            dataType: "JSON",
                                            async: false,
                                            data: form_data,
                                            success: function(data) {
                                                var data_2 = data;
                                                jumlah_quantity = data_2[0].jumlah_quantity;

                                                if (data_1[i].JUMLAH_MINTA - jumlah_quantity < 0) {
                                                    jumlah_qty_spp = data_1[i].JUMLAH_MINTA;
                                                } else {
                                                    jumlah_qty_spp = data_1[i].JUMLAH_MINTA - jumlah_quantity;
                                                }

                                                var form_data_4 = {
                                                    ID_SPPB: data_1[i].ID_SPPB,
                                                    ID_SPPB_FORM: data_1[i].ID_SPPB_FORM,
                                                    JUMLAH_QTY_GUDANG: jumlah_quantity,
                                                    JUMLAH_QTY_SPP: jumlah_qty_spp
                                                };
                                                $.ajax({
                                                    url: "<?php echo site_url('SPPB_form/update_quantity_spp') ?>",
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    data: form_data_4,
                                                    success: function(data) {
                                                        $('#ModalEditKirimSPPB').modal('hide');
                                                        window.location.href = '<?php echo site_url('SPPB') ?>';
                                                    }
                                                })
                                            }
                                        });
                                    }
                                }
                            }
                        })
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        item_edit_kirim_sppb.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPPB_form/data_sppb_form') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#ModalEditKirimSPPB').modal('show');
                    $.each(data, function() {
                        $('[name="ID_SPPB7"]').val(data[0].ID_SPPB);
                    });

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);

                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        var i = 0;
                        for (i = 0; i < data.length; i++) {
                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH_MINTA == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_jumlah_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].TANGGAL_MULAI_PAKAI_HARI == "" || data[i].TANGGAL_MULAI_PAKAI_HARI == null || data[i].TANGGAL_SELESAI_PAKAI_HARI == "" || data[i].TANGGAL_SELESAI_PAKAI_HARI == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_tanggal_mulai_selesai').attr("hidden", false);
                                break;
                            }

                            if (data[i].NO_URUT_FPB == null) {
                                if (data[i].BIDANG_PEMAKAI == null) {
                                    $('#show_hidden_setuju').attr("hidden", true);
                                    $('#show_hidden_belum_atur_bidang').attr("hidden", false);
                                    break;
                                }
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
    });
</script>

</body>

</html>