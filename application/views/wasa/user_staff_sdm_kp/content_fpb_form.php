<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form FPB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/FPB/') ?>">FPB</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form FPB</a>
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

    <!-- Identitas Form FPB -->
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/FPB/') ?>fpb_<?php echo $FILE_NAME_TEMP; ?>.pdf"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/FPB/') ?>" class="btn btn-info"> Kembali Ke Halaman List FPB</a>
            <?php if ($STATUS_FPB == "Draft") { ?>
                <a href="<?php echo base_url('index.php/FPB_form/index/') ?><?php echo $HASH_MD5_FPB; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah FPB</a>
                <a href="javascript:;" id="item_edit_kirim_fpb" name="item_edit_kirim_fpb" class="btn btn-primary" data="<?php echo $ID_FPB; ?>"><span class="fa fa-send"></span> Ajukan FPB</a>
            <?php
            }
            ?>
            
        </div>
    </div>
    <!-- End Identitas Form FPB -->
</div>


<!-- MODAL KIRIM FPB-->
<div class="modal inmodal fade" id="ModalEditKirimFPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim FPB</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form FPB ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_FPB7" => "contact_form", "id" => "contact_form");
            echo form_open("FPB_form/update_data_kirim_fpb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_FPB7" id="ID_FPB7" class="form-control" type="hidden" placeholder="ID FPB" readonly>


                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan pengisian form FPB ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_fpb" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM FPB-->


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

</body>

</html>