<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form FSTB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/FSTB/') ?>">FSTB</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form FSTB</a>
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

    <!-- Identitas Form FSTB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>fstb_<?php echo $HASH_MD5_FSTB; ?></h5>
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/FSTB/') ?>fstb_<?php echo $HASH_MD5_FSTB; ?>.pdf"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/FSTB/') ?>" class="btn btn-info"> Kembali Ke Halaman List FSTB</a>
            <?php if ($PROGRESS_FSTB == "Dalam Proses Pembuatan Kasie Logistik KP") { ?>
                <a href="<?php echo base_url('index.php/FSTB_form/index/') ?><?php echo $HASH_MD5_FSTB; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah FSTB</a>
                <a href="javascript:;" id="item_edit_kirim_fstb" name="item_edit_kirim_fstb" class="btn btn-primary" data="<?php echo $ID_FSTB; ?>"><span class="fa fa-send"></span> Ajukan FSTB Untuk Proses Selanjutnya </a>
            <?php
            } else if ($PROGRESS_FSTB == "Dalam Proses Kasie Logistik KP") {
            ?>
                <a href="<?php echo base_url('index.php/FSTB_form/index/') ?><?php echo $HASH_MD5_FSTB; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah FSTB</a>
                <a href="javascript:;" id="item_edit_kirim_fstb" name="item_edit_kirim_fstb" class="btn btn-primary" data="<?php echo $ID_FSTB; ?>"><span class="fa fa-send"></span> Ajukan FSTB Untuk Proses Selanjutnya </a>
            <?php
            }
            ?>
        </div>
    </div>
    <!-- End Identitas Form FSTB -->
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

    <!-- Identitas Form FIB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>fib_<?php echo $HASH_MD5_FSTB; ?></h5>
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/FIB/') ?>fib_<?php echo $HASH_MD5_FSTB; ?>.pdf"></iframe>
            </div>
            </br>


        </div>
    </div>
    <!-- End Identitas Form FIB -->
</div>

<!-- MODAL KIRIM FSTB-->
<div class="modal inmodal fade" id="ModalEditKirimFSTB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim FSTB</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form FSTB ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_FSTB7" => "contact_form", "id" => "contact_form");
            echo form_open("FSTB_form/update_data_kirim_fstb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_FSTB7" id="ID_FSTB7" class="form-control" type="hidden" placeholder="ID FSTB" readonly>
                    
                    <div id="show_hidden_setuju" class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form FSTB ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang diminta pada FSTB ini</center>
                        </div>
                    </div>

                    <div id="show_hidden_tidak_ada_jumlah_tolak_atau_terima" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang ditolak atau diterima pada FSTB ini</center>
                        </div>
                    </div>
                    
                    <div id="alert-msg-7"></div>
                
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_fstb" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM FSTB-->


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
        let ID_FSTB = <?php echo $ID_FSTB  ?>;

        item_edit_kirim_fstb.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FSTB_form/data_fstb_form') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#ModalEditKirimFSTB').modal('show');
                    $.each(data, function() {
                        $('[name="ID_FSTB7"]').val(data[0].ID_FSTB);
                    });

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);

                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        var i = 0;
                        for (i = 0; i < data.length; i++) {
                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH_DITERIMA == 0 | data[i].JUMLAH_DITERIMA == null | data[i].JUMLAH_DITOLAK == "" | data[i].JUMLAH_DITOLAK == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_tidak_ada_jumlah_tolak_atau_terima').attr("hidden", false);
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

                $('#btn_update_kirim_fstb').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_fstb').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM FSTB 
        $('#btn_update_kirim_fstb').on('click', function() {

            let ID_FSTB = $('#ID_FSTB7').val();
            $.ajax({
                url: "<?php echo site_url('FSTB_form/update_data_kirim_fstb') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FSTB: ID_FSTB,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimFSTB').modal('hide');
                        window.location.href = '<?php echo site_url('FSTB') ?>';
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