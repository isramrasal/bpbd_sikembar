<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Otentikasi Dokumen FPB</h2>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Data berikut merupakan hasil pengecekan Si-Pesut.
    </div>

    <!-- Identitas Form FPB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Hasil pengecekan Si-Pesut</h5>
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
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1">Identitas Form</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form method="get" class="form-horizontal">
                                <?php
                                if (isset($FPB)) {
                                    foreach ($FPB->result() as $FPB) :
                                ?>
                                        <hr>
                                        <input style="display:none" type="text" class="form-control" name="ID_RASD" id="ID_RASD" value="<?php echo $FPB->ID_RASD; ?>">
                                        <div class="form-group"><label class="col-sm-2 control-label">No Urut:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $FPB->NO_URUT_FPB; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pembuatan :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $FPB->TANGGAL_DOKUMEN_FPB; ?>" disabled>
                                                *tanggal pengajuan akan berubah sesuai dengan tanggal aktual pengajuan FPB
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">User Peminta :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $FPB->NAMA; ?> - <?php echo $FPB->NAMA_JABATAN; ?>" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Lihat Dokumen FPB :</label>
                                            <div class="col-sm-10"><a href="<?php echo base_url('index.php/FPB_form/view/').$HASH_MD5_FPB;?>">Klik di sini</a>
                                            </div>
                                        </div>
                                <?php endforeach;
                                } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <!-- End Identitas Form FPB -->

  
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

</script>

<style type="text/css">
    .txtedit {
        display: none;
        width: 98%;
    }
</style>

</body>

</html>