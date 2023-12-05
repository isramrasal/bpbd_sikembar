<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form Surat Jalan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/Surat_Jalan/') ?>">Surat Jalan</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form Surat Jalan</a>
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

    <!-- Identitas Form SURAT JALAN -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Surat_Jalan_<?php echo $HASH_MD5_SURAT_JALAN; ?></h5>
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/Surat_Jalan/') ?>Surat_Jalan_<?php echo $HASH_MD5_SURAT_JALAN; ?>.pdf"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/Surat_Jalan/') ?>" class="btn btn-info"> Kembali Ke Halaman List Surat Jalan</a>
            <?php if ($PROGRESS_SURAT_JALAN == "Dalam Proses Staff Logistik KP") { ?>
                <a href="<?php echo base_url('index.php/Surat_Jalan_form/index/') ?><?php echo $HASH_MD5_SURAT_JALAN; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah Surat Jalan</a>
                <a href="javascript:;" id="item_edit_kirim_surat_jalan" name="item_edit_kirim_surat_jalan" class="btn btn-primary" data="<?php echo $ID_SURAT_JALAN; ?>"><span class="fa fa-send"></span> Ajukan Surat Jalan</a>
            <?php
            } else 
            ?>
            
        </div>
    </div>
    <!-- End Identitas Form SURAT JALAN -->
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

    <!-- Identitas Form Delivery Note -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Delivery_Note_<?php echo $HASH_MD5_SURAT_JALAN; ?></h5>
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/Delivery_Note/') ?>Delivery_Note_<?php echo $HASH_MD5_SURAT_JALAN; ?>.pdf"></iframe>
            </div>
            </br>
            
            
        </div>
    </div>
    <!-- End Identitas Form Delivery Note -->
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

    <!-- Identitas Form Packing List -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Packing_List_<?php echo $HASH_MD5_SURAT_JALAN; ?></h5>
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/Packing_List/') ?>Packing_List_<?php echo $HASH_MD5_SURAT_JALAN; ?>.pdf"></iframe>
            </div>
            </br>
            
            
        </div>
    </div>
    <!-- End Identitas Form Packing List -->
</div>

<!-- MODAL KIRIM SURAT JALAN-->
<div class="modal inmodal fade" id="ModalEditKirimSuratJalan" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim Surat Jalan</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form Surat Jalan ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_SURAT_JALAN7" => "contact_form", "id" => "contact_form");
            echo form_open("Surat_Jalan_form/update_data_kirim_surat_jalan", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SURAT_JALAN7" id="ID_SURAT_JALAN7" class="form-control" type="hidden" placeholder="ID_SURAT_JALAN" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form Surat Jalan ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang diminta pada Surat Jalan ini. Silahkan ke bagian Ubah Surat Jalan</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item jumlah barang yang bernilai 0. Silahkan ke bagian Ubah Surat Jalan</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_pengiriman_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada jenis pengiriman yang diminta pada Surat Jalan ini. Silahkan ke bagian Ubah Surat Jalan</center>
                        </div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_surat_jalan" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM SURAT JALAN-->


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
        let ID_SURAT_JALAN = <?php echo $ID_SURAT_JALAN  ?>;

        item_edit_kirim_surat_jalan.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('Surat_Jalan_form/data_surat_jalan_form') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#ModalEditKirimSuratJalan').modal('show');
                    $.each(data, function() {
                        $('[name="ID_SURAT_JALAN7"]').val(data[0].ID_SURAT_JALAN)
                    });

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);
                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        let i = 0;
                        for (i = 0; i < data.length; i++) {

                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_jumlah_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].JENIS_PENGIRIMAN == "" || data[i].JENIS_PENGIRIMAN == null || data[i].JENIS_PENGIRIMAN == "" || data[i].JENIS_PENGIRIMAN == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_pengiriman_barang').attr("hidden", false);
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

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_surat_jalan').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_surat_jalan').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM SURAT JALAN 
        $('#btn_update_kirim_surat_jalan').on('click', function() {

            let ID_SURAT_JALAN = $('#ID_SURAT_JALAN7').val();
            $.ajax({
                url: "<?php echo site_url('Surat_Jalan_form/update_data_kirim_surat_jalan') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SURAT_JALAN: ID_SURAT_JALAN,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimSuratJalan').modal('hide');
                        window.location.href = '<?php echo site_url('Surat_Jalan') ?>';
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