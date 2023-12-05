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
            <?php if ($PROGRESS_SPPB == "Dalam Proses Direksi") { ?>
                <a href="<?php echo base_url('index.php/SPPB_form/approval/') ?><?php echo $HASH_MD5_SPPB; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Approval SPPB</a>
                <a href="javascript:;" id="item_edit_kirim_sppb" name="item_edit_kirim_sppb" class="btn btn-success" data="<?php echo $HASH_MD5_SPPB; ?>"><span class="fa fa-send"></span> Ajukan SPPB Untuk Proses Selanjutnya </a><br>
            <?php
            } 
            ?>
        </div>
    </div>
    <!-- End Identitas Form SPPB -->
</div>


<!-- MODAL KIRIM SPPB-->
<div class="modal inmodal fade" id="ModalEditKirimSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim SPPB</h4>
                <small class="font-bold">Selesaikan proses dan simpan Form SPPB ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_SPPB7" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_kirim_sppb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_SPPB7" id="ID_SPPB7" class="form-control" type="HIDDEN" placeholder="ID SPPB" readonly>

                    <div id="alert-msg-7"></div>

                    <div class="form-group">
                        <div><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan pengisian form SPPB ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>


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
                        $('#ModalEditKirimSPPB').modal('hide');
                        window.location.href = '<?php echo site_url('SPPB') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        item_edit_kirim_sppb.onclick = function() {
            var HASH_MD5_SPPB = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPPB_form/get_data_catatan_sppb') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_SPPB: HASH_MD5_SPPB
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditKirimSPPB').modal('show');
                        $('[name="ID_SPPB7"]').val(data.ID_SPPB);

                        $('#alert-msg-7').html('<div></div>');
                    });
                }
            });
            return false;
        };
    });
</script>

</body>

</html>