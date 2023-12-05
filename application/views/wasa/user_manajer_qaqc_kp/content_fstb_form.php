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
            <h5>fstb_<?php echo $FILE_NAME_TEMP; ?></h5>
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/FSTB/') ?>fstb_<?php echo $FILE_NAME_TEMP; ?>.pdf"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/FSTB/') ?>" class="btn btn-info"> Kembali Ke Halaman List FSTB</a>
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
            <h5>fib_<?php echo $FILE_NAME_TEMP_FIB; ?></h5>
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/FIB/') ?>fib_<?php echo $FILE_NAME_TEMP_FIB; ?>.pdf"></iframe>
            </div>
            </br>
        </div>
    </div>
    <!-- End Identitas Form FIB -->
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
        let ID_FSTB = <?php echo $ID_FSTB  ?>;

        item_edit_kirim_fstb.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FSTB_form/get_data_catatan_fstb') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditKirimFSTB').modal('show');
                        $('[name="ID_FSTB7"]').val(data.ID_FSTB);

                        $('#alert-msg-7').html('<div></div>');
                    });
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