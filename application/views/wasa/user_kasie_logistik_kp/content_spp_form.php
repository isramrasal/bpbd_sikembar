<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form SPP</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPP/') ?>">SPP</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form SPP</a>
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

    <!-- Identitas Form SPP -->
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/SPP/') ?><?php echo $FILE_NAME_TEMP; ?>"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/SPP/') ?>" class="btn btn-info"> Kembali Ke Halaman List SPP</a>
            <?php if ($PROGRESS_SPP == "DRAFT") { ?>
                <a href="<?php echo base_url('index.php/SPP_form/index/') ?><?php echo $HASH_MD5_SPP; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah SPP</a>

            <?php
            }
            ?>
            <!-- <a href="javascript:;" id="item_edit_kirim_email_spp" name="item_edit_kirim_email_spp" class="btn btn-primary" data="<?php echo $HASH_MD5_SPP; ?>"><span class="fa fa-send"></span> Kirim SPP ke Vendor</a> -->
            <!-- <a href="<?php echo base_url('index.php/SPP_form/pengajuan_vendor/') ?><?php echo $HASH_MD5_SPP; ?>" class="btn btn-primary"><span class="fa fa-book"></span> Lihat Harga Pengajuan Vendor</a> -->
            
        </div>
    </div>
    <!-- End Identitas Form SPP -->
</div>


<!-- MODAL KIRIM SPP-->
<div class="modal inmodal fade" id="ModalEditKirimSPP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim SPP</h4>
                <small class="font-bold">Selesaikan proses dan simpan Form SPP ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("HASH_MD5_SPP7" => "contact_form", "id" => "contact_form");
            echo form_open("SPP_form/update_data_kirim_spp", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="HASH_MD5_SPP7" id="HASH_MD5_SPP7" class="form-control" type="hidden" placeholder="ID SPP" readonly>


                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan pengisian form SPP ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_spp" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM SPP-->


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
        let ID_SPP = <?php echo $ID_SPP  ?>;

        item_edit_kirim_email_spp.onclick = function() {
            var HASH_MD5_SPP = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/get_id_spp_by_HASH_MD5_SPP') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_SPP: HASH_MD5_SPP
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditKirimSPP').modal('show');
                        $('[name="HASH_MD5_SPP7"]').val(data.HASH_MD5_SPP);

                        $('#alert-msg-7').html('<div></div>');
                    });
                }
            });
            return false;
        };

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_spp').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_spp').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM SPP 
        $('#btn_update_kirim_spp').on('click', function() {

            let HASH_MD5_SPP = $('#HASH_MD5_SPP7').val();
            $.ajax({
                url: "<?php echo site_url('SPP_form/update_data_kirim_spp') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    HASH_MD5_SPP: HASH_MD5_SPP,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimSPP').modal('hide');
                        var alamat = "<?php echo base_url('SPP_form/kirim_email/'); ?>" + HASH_MD5_SPP;
                        window.open(
                            alamat
                        );
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