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
            <h5>fpb_<?php echo $HASH_MD5_FPB; ?>.pdf</h5>
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/FPB/') ?>fpb_<?php echo $HASH_MD5_FPB; ?>.pdf"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/FPB/') ?>" class="btn btn-info"> Kembali Ke Halaman List FPB</a>
            <?php if (($PROGRESS_FPB == "Dalam Proses Staff Logistik") && ($STATUS_FPB != "Sudah diproses Staff Gudang")) { ?>
                <a href="<?php echo base_url('index.php/FPB_form/index/') ?><?php echo $HASH_MD5_FPB; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Proses FPB</a>
                <!-- <a href="javascript:;" id="item_edit_kirim_fpb" name="item_edit_kirim_fpb" class="btn btn-primary" data="<?php echo $ID_FPB; ?>"><span class="fa fa-send"></span> Ajukan FPB</a> -->
            <?php
            }
            ?>

            <?php if ($PROGRESS_FPB == "Dalam Proses Staff Logistik (Penyiapan Barang/SPPB)") { ?>
                <a href="<?php echo base_url('index.php/FPB_form/cek_progress/') ?><?php echo $HASH_MD5_FPB; ?>" class="btn btn-primary"><span class="fa fa-binoculars"></span> Cek Status Kesiapan Barang/Jasa</a>
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

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form FPB ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang/jasa yang diminta pada FPB ini.</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_minta" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang/jasa yang diminta bernilai 0</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_tanggal_pakai" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih belum ada tanggal pemakaian item barang/jasa yang diminta</center>
                        </div>
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
<script>
    $(document).ready(function() {
        let ID_FPB = <?php echo $ID_FPB  ?>;

        item_edit_kirim_fpb.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FPB_form/data_fpb_form') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#ModalEditKirimFPB').modal('show');
                    $.each(data, function() {
                        $('[name="ID_FPB7"]').val(data[0].ID_FPB);
                    });


                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) {//JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true); 
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false); 
                    } else {//JIKA SUDAH ADA BARANG YANG DI ADD

                        let i = 0;
                        for (i = 0; i < data.length; i++) {

                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH_MINTA == 0) {
                                $('#show_hidden_setuju').attr("hidden", true); 
                                $('#show_hidden_belum_atur_jumlah_minta').attr("hidden", false); 
                                break;
                            }

                            if (data[i].TANGGAL_MULAI_PAKAI == "" || data[i].TANGGAL_MULAI_PAKAI == null || data[i].TANGGAL_MULAI_PAKAI == "" || data[i].TANGGAL_MULAI_PAKAI == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_tanggal_pakai').attr("hidden", false);
                                break;
                            }

                            //JIKA SEMUA ITEM BARANG ADA JUMLAH MINTANYA (TIDAK NOL)
                            if(i == (data.length-1))
                            {
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

                $('#btn_update_kirim_fpb').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_fpb').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM FPB 
        $('#btn_update_kirim_fpb').on('click', function() {

            let ID_FPB = $('#ID_FPB7').val();
            $.ajax({
                url: "<?php echo site_url('FPB_form/update_data_kirim_fpb') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FPB: ID_FPB,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimFPB').modal('hide');
                        window.location.href = '<?php echo site_url('FPB') ?>';
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