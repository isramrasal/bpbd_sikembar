<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form RFQ</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/RFQ/') ?>">RFQ</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form RFQ</a>
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

    <!-- Identitas Form RFQ -->
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/RFQ/') ?><?php echo $FILE_NAME_TEMP; ?>"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/RFQ/') ?>" class="btn btn-info"> Kembali Ke Halaman List RFQ</a>
            <?php if ($PROGRESS_RFQ == "DRAFT") { ?>
                <a href="<?php echo base_url('index.php/RFQ_form/index/') ?><?php echo $HASH_MD5_RFQ; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah RFQ</a>

            <?php
            }
            ?>
            <a href="javascript:;" id="item_edit_kirim_email_rfq" name="item_edit_kirim_email_rfq" class="btn btn-primary" data="<?php echo $HASH_MD5_RFQ; ?>"><span class="fa fa-send"></span> Kirim RFQ ke Vendor</a>
            <a href="<?php echo base_url('index.php/RFQ_form/pengajuan_vendor/') ?><?php echo $HASH_MD5_RFQ; ?>" class="btn btn-primary"><span class="fa fa-book"></span> Lihat Harga Pengajuan Vendor</a>

        </div>
    </div>
    <!-- End Identitas Form RFQ -->
</div>


<!-- MODAL KIRIM RFQ-->
<div class="modal inmodal fade" id="ModalEditKirimRFQ" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim RFQ</h4>
                <small class="font-bold">Selesaikan proses dan simpan Form RFQ ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("HASH_MD5_RFQ7" => "contact_form", "id" => "contact_form");
            echo form_open("RFQ_form/update_data_kirim_rfq", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="HASH_MD5_RFQ7" id="HASH_MD5_RFQ7" class="form-control" type="hidden" placeholder="ID RFQ" readonly>

                    <div id="alert-msg-7"></div>

                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan pengisian form RFQ ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>


                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_rfq" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM RFQ-->


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
        let ID_RFQ = <?php echo $ID_RFQ  ?>;

        item_edit_kirim_email_rfq.onclick = function() {
            var HASH_MD5_RFQ = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('RFQ_form/get_id_rfq_by_HASH_MD5_RFQ') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_RFQ: HASH_MD5_RFQ
                },
                success: function(data) {

                    if (data.ID_VENDOR == "0" || data.TOP == "" || data.LOKASI_PENYERAHAN == "") {
                        console.log(data);
                        console.log(data.TOP);
                        $('#alert-msg-7').html('<div>Anda belum menentukan Vendor atau Term of Payment atau Lokasi Penyerahan. Anda dialihkan ke halaman pengisian RFQ</div>');

                        var tid = setInterval(function() {
                            //called 5 times each time after one second  
                            //before getting cleared by below timeout. 
                            // alert("I am setInterval");
                        }, 5000); //delay is in milliseconds 

                        alert("Anda belum menentukan Vendor atau Term of Payment atau Lokasi Penyerahan. Anda dialihkan ke halaman pengisian RFQ"); //called second
                        var alamat = "<?php echo base_url('RFQ_form/index/'); ?>" + data.HASH_MD5_RFQ;
                        window.location = alamat;
                    } else {
                        $('#ModalEditKirimRFQ').modal('show');
                        $('[name="HASH_MD5_RFQ7"]').val(data.HASH_MD5_RFQ);
                    }

                }
            });
            return false;
        };

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_rfq').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_rfq').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM RFQ 
        $('#btn_update_kirim_rfq').on('click', function() {

            let HASH_MD5_RFQ = $('#HASH_MD5_RFQ7').val();
            $.ajax({
                url: "<?php echo site_url('RFQ_form/update_data_kirim_rfq') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    HASH_MD5_RFQ: HASH_MD5_RFQ,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimRFQ').modal('hide');
                        var alamat = "<?php echo base_url('RFQ_form/kirim_email/'); ?>" + HASH_MD5_RFQ;
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