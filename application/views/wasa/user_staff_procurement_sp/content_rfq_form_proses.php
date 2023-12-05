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
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Pastikan Anda mengisi data dengan benar.
    </div>

    <!-- Form RFQ -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Formulir Pengajuan RFQ</h5>
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

                            <li class="" style="display:none;"><a data-toggle="tab" href="#tab-2">Catatan RFQ</a></li>

                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <form method="get" class="form-horizontal">
                                        <?php
                                        if (isset($SPPB)) {
                                            foreach ($SPPB->result() as $SPPB) :
                                        ?>
                                                <div class="form-group"><label class="col-sm-2 control-label">No. Urut SPPB</label>
                                                    <div class="col-sm-10"><a href="<?php echo base_url() ?>SPPB_form/view/<?php echo $SPPB->HASH_MD5_SPPB; ?>" class="btn btn-info btn-outline" target="_blank"><?php echo $SPPB->NO_URUT_SPPB; ?> </a></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Proyek</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->NAMA_PROYEK; ?>" disabled></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Pekerjaan</label>
                                                    <div class="col-sm-10"><input name="SUB_PROYEK" id="SUB_PROYEK" type="text"
                                                            class="form-control" value="<?php echo $SPPB->SUB_PROYEK; ?>" disabled>
                                                    </div>
                                                </div>
                                        <?php endforeach;
                                        } ?>

                                        <?php
                                        if (isset($RFQ)) {
                                            foreach ($RFQ->result() as $RFQ) :
                                        ?>
                                                <div class="form-group"><label class="col-sm-2 control-label">No. Urut RFQ</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $RFQ->NO_URUT_RFQ; ?>" disabled></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Tanggal Dokumen RFQ</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $RFQ->TANGGAL_DOKUMEN_RFQ; ?>" disabled></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Tanggal RFQ By System</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $RFQ->TANGGAL_PEMBUATAN_RFQ_HARI; ?>" disabled></div>
                                                </div>
                                        <?php endforeach;
                                        } ?>

                                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi Penyerahan</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($ID_PROYEK_LOKASI_PENYERAHAN)) {
                                                ?>
                                                    <select class="form-control" name="ID_PROYEK_LOKASI_PENYERAHAN" id="ID_PROYEK_LOKASI_PENYERAHAN">
                                                        <option value=''>- Pilih Lokasi Penyerahan -</option>
                                                        <?php foreach ($LOKASI_PENYERAHAN_LIST as $prov) {
                                                            echo '<option value="' . $prov->ID_PROYEK_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . '</option>';
                                                        } ?>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="ID_PROYEK_LOKASI_PENYERAHAN" id="ID_PROYEK_LOKASI_PENYERAHAN">
                                                        <option value=''>- Pilih Lokasi Penyerahan -</option>
                                                        <?php foreach ($LOKASI_PENYERAHAN_LIST as $prov) {
                                                            if ($prov->ID_PROYEK_LOKASI_PENYERAHAN == $ID_PROYEK_LOKASI_PENYERAHAN) {
                                                                echo '<option selected="selected" value="' . $prov->ID_PROYEK_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->ID_PROYEK_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . ' </option>';
                                                            }
                                                        } ?>
                                                    </select>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Vendor</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($ID_VENDOR)) {
                                                ?>
                                                    <select class="form-control" name="ID_VENDOR" id="ID_VENDOR">
                                                        <option value=''>- Pilih Vendor -</option>
                                                        <?php foreach ($vendor as $prov) {
                                                            echo '<option value="' . $prov->ID_VENDOR . '">' . $prov->NAMA_VENDOR . '</option>';
                                                        } ?>
                                                        <option value='666666'>- Vendor Lainnya -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="ID_VENDOR" id="ID_VENDOR">
                                                        <option value=''>- Pilih Vendor -</option>
                                                        <?php foreach ($vendor as $prov) {
                                                            if ($prov->ID_VENDOR == $ID_VENDOR) {
                                                                echo '<option selected="selected" value="' . $prov->ID_VENDOR . '">' . $prov->NAMA_VENDOR . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->ID_VENDOR . '">' . $prov->NAMA_VENDOR . ' </option>';
                                                            }
                                                        } ?>
                                                        <option value='666666'>- Vendor Lainnya -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div id="show_hidden_vendor" class="form-group" hidden><label class="col-sm-2 control-label">Vendor Lainnya</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($NAMA_VENDOR)) {
                                                ?>
                                                    <input type="text" name="NAMA_VENDOR" id="NAMA_VENDOR" class="form-control" placeholder="Contoh: PT. Pertamina Persero">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="NAMA_VENDOR" id="NAMA_VENDOR" class="form-control" value="<?php echo $NAMA_VENDOR; ?>" placeholder="Contoh: PT. Pertamina Persero">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div id="show_hidden_vendor_2" class="form-group" hidden><label class="col-sm-2 control-label">Alamat Vendor</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($ALAMAT_VENDOR)) {
                                                ?>
                                                    <input type="text" name="ALAMAT_VENDOR" id="ALAMAT_VENDOR" class="form-control" placeholder="Contoh: JL. TB Simatupang Kavling 28">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="ALAMAT_VENDOR" id="ALAMAT_VENDOR" class="form-control" value="<?php echo $ALAMAT_VENDOR; ?>" placeholder="Contoh: JL. TB Simatupang Kavling 28">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div id="show_hidden_vendor_3" class="form-group" hidden><label class="col-sm-2 control-label">Email Vendor</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($EMAIL_VENDOR)) {
                                                ?>
                                                    <input type="text" name="EMAIL_VENDOR" id="EMAIL_VENDOR" class="form-control" placeholder="Contoh: asus@gmail.com">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="EMAIL_VENDOR" id="EMAIL_VENDOR" class="form-control" value="<?php echo $EMAIL_VENDOR; ?>" placeholder="Contoh: asus@gmail.com">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div id="show_hidden_vendor_4" class="form-group" hidden><label class="col-sm-2 control-label">No Telepon Vendor</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($NO_TELP_VENDOR)) {
                                                ?>
                                                    <input type="text" name="NO_TELP_VENDOR" id="NO_TELP_VENDOR" class="form-control" placeholder="Contoh: 021-8762812">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="NO_TELP_VENDOR" id="NO_TELP_VENDOR" class="form-control" value="<?php echo $NO_TELP_VENDOR; ?>" placeholder="Contoh: 021-8762812">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div id="show_hidden_vendor_5" class="form-group" hidden><label class="col-sm-2 control-label">Nama PIC</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($NAMA_PIC_VENDOR)) {
                                                ?>
                                                    <input type="text" name="NAMA_PIC_VENDOR" id="NAMA_PIC_VENDOR" class="form-control" placeholder="Contoh: Rahmat Suryo">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="NAMA_PIC_VENDOR" id="NAMA_PIC_VENDOR" class="form-control" value="<?php echo $NAMA_PIC_VENDOR; ?>" placeholder="Contoh: Rahmat Suryo">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div id="show_hidden_vendor_6" class="form-group" hidden><label class="col-sm-2 control-label">Email PIC</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($EMAIL_PIC_VENDOR)) {
                                                ?>
                                                    <input type="text" name="EMAIL_PIC_VENDOR" id="EMAIL_PIC_VENDOR" class="form-control" placeholder="Contoh: RahmadS.11@gmail.com">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="EMAIL_PIC_VENDOR" id="EMAIL_PIC_VENDOR" class="form-control" value="<?php echo $EMAIL_PIC_VENDOR; ?>" placeholder="Contoh: RahmadS.11@gmail.com">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div id="show_hidden_vendor_7" class="form-group" hidden><label class="col-sm-2 control-label">No Handphone PIC</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($NO_HP_PIC_VENDOR)) {
                                                ?>
                                                    <input type="text" name="NO_HP_PIC_VENDOR" id="NO_HP_PIC_VENDOR" class="form-control" placeholder="Contoh: 081802372912">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="NO_HP_PIC_VENDOR" id="NO_HP_PIC_VENDOR" class="form-control" value="<?php echo $NO_HP_PIC_VENDOR; ?>" placeholder="Contoh: 081802372912">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Term of Payment</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($ID_TERM_OF_PAYMENT)) {
                                                ?>
                                                    <select class="form-control" name="ID_TERM_OF_PAYMENT" id="ID_TERM_OF_PAYMENT">
                                                        <option value=''>- Pilih -</option>
                                                        <?php foreach ($term_of_payment as $prov) {
                                                            echo '<option value="' . $prov->ID_TERM_OF_PAYMENT . '">' . $prov->NAMA_TERM_OF_PAYMENT . '</option>';
                                                        } ?>
                                                        <option value='99999'>- TERM OF PAYMENT LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="ID_TERM_OF_PAYMENT" id="ID_TERM_OF_PAYMENT">
                                                        <option value=''>- Pilih -</option>
                                                        <?php foreach ($term_of_payment as $prov) {
                                                            if ($prov->ID_TERM_OF_PAYMENT == $ID_TERM_OF_PAYMENT) {
                                                                echo '<option selected="selected" value="' . $prov->ID_TERM_OF_PAYMENT . '">' . $prov->NAMA_TERM_OF_PAYMENT . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->ID_TERM_OF_PAYMENT . '">' . $prov->NAMA_TERM_OF_PAYMENT . '</option>';
                                                            }
                                                        } ?>
                                                        <option value='99999'>- TERM OF PAYMENT LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div id="show_hidden_top" class="form-group" hidden><label class="col-sm-2 control-label">Term of Payment lainnya</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($NAMA_TERM_OF_PAYMENT)) {
                                                ?>
                                                    <input type="text" name="NAMA_TERM_OF_PAYMENT" id="NAMA_TERM_OF_PAYMENT" class="form-control" placeholder="Contoh: 1 (SATU) BULAN SETELAH INVOICE DITERIMA">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="NAMA_TERM_OF_PAYMENT" id="NAMA_TERM_OF_PAYMENT" class="form-control" value="<?php echo $NAMA_TERM_OF_PAYMENT; ?>" placeholder="Contoh: 1 (SATU) BULAN SETELAH INVOICE DITERIMA">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group" id="data_TANGGAL_DOKUMEN_RFQ">
                                            <label class="col-sm-2 control-label">Batas Akhir Pengisian RFQ</label>
                                            <div class="col-sm-10">
                                            <?php
                                                if (empty($BATAS_AKHIR)) {
                                                ?>
                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="BATAS_AKHIR" name="BATAS_AKHIR" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                                </div>

                                                <?php
                                                } else {
                                                ?>

                                                <div class="input-group date">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="BATAS_AKHIR" name="BATAS_AKHIR" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $BATAS_AKHIR; ?>">
                                                </div>
                                                    
                                                <?php
                                                }
                                                ?>
                                                
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Catatan Dokumen RFQ</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($KETERANGAN_RFQ)) {
                                                ?>
                                                    <textarea class="form-control h-100" name="KETERANGAN_RFQ" id="KETERANGAN_RFQ" placeholder="Contoh: Keterangan Mengenai RFQ" required></textarea>
                                                <?php
                                                } else {
                                                ?>
                                                    <textarea class="form-control h-100" name="KETERANGAN_RFQ" id="KETERANGAN_RFQ" placeholder="Contoh: Keterangan Mengenai RFQ" required><?php echo $KETERANGAN_RFQ; ?></textarea>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <input style="width:100%" name="HASH_MD5_RFQ" id="HASH_MD5_RFQ" type="hidden" value="<?php echo $HASH_MD5_RFQ; ?>">
                                    </form>
                                    <div class="hr-line-dashed"></div>
                                    <div id="alert-msg-8"></div>
                                    <button class="btn btn-primary" id="btn_simpan_identitas_form"><i class="fa fa-save"></i> Simpan Identitas Form</button>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Staff Procurement KL</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_RFQ['CTT_STAFF_PROC_SP']; ?>
                                        </div>
                                    </div>
                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Supervisi Procurement KL</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_RFQ['CTT_SUPERVISI_PROC_SP']; ?>
                                        </div>
                                    </div>
                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Staff Procurement KP</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_RFQ['CTT_STAFF_PROC']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Kasie Procurement KP</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_RFQ['CTT_KASIE']; ?>
                                        </div>
                                    </div>
                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer Procurement KP</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_RFQ['CTT_MANAGER_PROC']; ?>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="hr-line-dashed"></div>
                                    <a href="javascript:;" id="item_edit_catatan_rfq" name="item_edit_catatan_rfq" class="btn btn-info" data="<?php echo $HASH_MD5_RFQ; ?>"><i class="fa fa-comment"></i> Berikan Catatan RFQ </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>RFQ Item Barang/Jasa</h5>
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
                            <div class="form-horizontal">

                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddDariSPPB"><span class="fa fa-plus"></span> Tambah Item dari SPPB</a><br>

                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#ModalAddNew"><span class="fa fa-plus"></span> Tambah Item Baru</a>

                                <div class="hr-line-dashed"></div>

                                <div class="alert alert-warning alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    Perubahan data pada form RFQ tidak akan mempengaruhi data pada form SPPB Pembelian.
                                </div>

                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="mydata">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang/Jasa</th>
                                            <th>Merek Barang/Jasa</th>
                                            <th>Spesifikasi Singkat</th>    
                                            <th>Klasifikasi Barang</th>
                                            <th>Satuan Barang</th>
                                            <th>Jumlah Yang Diadakan</th>
                                            <th>Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">

                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="form-group">
                                <div class="sm-10">
                                    <a href="<?php echo base_url('index.php/RFQ_form/view/') ?><?php echo $HASH_MD5_RFQ; ?>" class="btn btn-primary"><span class="fa fa-save"></span> Simpan Perubahan & View Dokumen RFQ</a>
                                    </br>
                                    <a href="javascript:;" id="item_edit_kirim_rfq" name="item_edit_kirim_rfq" class="btn btn-success" data="<?php echo $HASH_MD5_RFQ; ?>"><span class="fa fa-send"></span> Ajukan RFQ Untuk Proses Selanjutnya </a><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Form RFQ -->


<!-- MODAL ADD  DARI SPPB -->
<div class="modal inmodal fade" id="ModalAddDariSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <?php
            if ($sppb_barang_list != NULL) {
                ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Daftar Item Barang/Jasa dari SPPB</h4>
        <small class="font-bold">Silakan isi data RFQ berdasarkan SPPB</small>
    </div>

    <div class="form-horizontal">
        <div class="modal-body">
            <div class="table-responsive">

            <?php
                foreach ($sppb_barang_list as $data): ?>
                Sumber SPPB: <a href="<?php echo base_url() ?>SPPB_form/view/<?php echo $SPPB->HASH_MD5_SPPB; ?>" class="btn btn-info btn-outline" target="_blank"><?php echo $SPPB->NO_URUT_SPPB; ?> </a>
                <?php break;?>
                <?php endforeach;
                ?>

                </br>
                </br>
                <form method="POST" action="<?php echo site_url('RFQ_form/simpan_data_dari_sppb_form'); ?>" id="formTambahSPPB">
                    <table class="table table-striped table-bordered table-hover" id="modalsppb">
                        <thead>
                            <tr>
                                <th>Pilih<input type="checkbox" id="checkAllsppb"></th>
                                <th>Nama Barang/Jasa</th>
                                <th>Merek Barang/Jasa</th>
                                <th style="width: 30%;">Spesifikasi Singkat</th>
                                <th>Kategori RAB dan Klasifikasi Barang</th>
                                <th>Satuan Barang</th>
                                <th>Jumlah Yang Diminta</th>
                                <th>Tanggal Mulai dan Selesai Pemakaian</th>
                            </tr>
                        </thead>
                        <tbody">
                            <?php
                            foreach ($sppb_barang_list as $data): ?>
                            <tr>

                                <td>
                                    <input name="ID_RFQ" class="form-control" type="text" value="<?php echo $ID_RFQ ?>" style="display: none;" readonly>
                                    <input class="checkbox" name="ID_SPPB_FORM[]" value="<?php echo $data->ID_SPPB_FORM ?>" type="checkbox">
                                </td>

                                <td> <?php echo $data->NAMA_BARANG; ?> </td>
                                <td> <?php echo $data->MEREK; ?> </td>
                                <td> <?php echo $data->SPESIFIKASI_SINGKAT; ?> </td>
                                <td> Kategori RAB: <?php echo $data->NAMA_KATEGORI; ?> </br> Klasifikasi: <?php echo $data->NAMA_KLASIFIKASI_BARANG; ?></td>
                                <td> <?php echo $data->SATUAN_BARANG; ?> </td>
                                <td style="width: 20%;">
                                    <?php echo $data->JUMLAH_QTY_SPP ?>
                                </td>
                                <td>
                                    <?php echo $data->TANGGAL_MULAI_PAKAI_HARI ?> s.d. <?php echo $data->TANGGAL_SELESAI_PAKAI_HARI ?>
                                </td>
                            </tr>
                            <?php endforeach;
                            ?>
                            </tbody>
                    </table>

                </form>
            </div>
            <div id="alert-msg-add-dari-spp"></div>

        </div>

        <div class="modal-footer">
            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
            <button class="btn btn-primary" type="submit" form="formTambahSPPB"><i class="fa fa-save"></i> Simpan</button>
        </div>
    </div>
    <?php echo form_close(); ?>
<?php
} else {
?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <i class="fa fa-exclamation-triangle modal-icon"></i>
        <h4 class="modal-title">Daftar Item Barang/Jasa dari SPPB</h4>
        <b class="font-bold">Maaf semua item barang/jasa dari SPPB sudah ada di Form SPP ini atau seluruh item sudah diproses di Form SPP yang lain</b>
    </div>
    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
    </div>
<?php
            }
            ?>

        </div>
    </div>
</div>
<!--END MODAL ADD DARI SPPB -->

<!-- MODAL ADD DI LUAR BARANG MASTER-->
<div class="modal inmodal fade" id="ModalAddNew" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ajukan Item Barang/Jasa Di Luar SPPB</h4>
                <small class="font-bold">Silakan isi data Item Barang/Jasa RFQ yang Baru</small>
            </div>
            <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
            echo form_open("RFQ_form/simpan_data_di_luar_barang_master", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                <div class="form-group row">
                        <label class="col-xs-2 control-label">Identitas Barang/Jasa</label>
                    </div> 

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA_4" id="NAMA_4" class="form-control" type="text" placeholder="Contoh : Crane" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_4" id="MEREK_4" class="form-control" type="text" placeholder="Contoh : Toyota etc">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_4" id="SPESIFIKASI_SINGKAT_4" class="form-control" type="text" placeholder="Contoh: Mata Gerindra Stainless Grinding ukuran 4 inch " required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" name="JUMLAH_BARANG_4" id="JUMLAH_BARANG_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="SATUAN_BARANG_4" id="SATUAN_BARANG_4" class="form-control" type="text" placeholder="Contoh : PCS">
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-xs-3">Klasifikasi Barang</label>
                        <div class="col-xs-9">
                            <select name="KLASIFIKASI_BARANG_4" class="form-control" id="KLASIFIKASI_BARANG_4">
                                <option value=''>- Pilih Klasifikasi Barang -</option>
                                <?php foreach ($klasifikasi_barang_list as $item) {
                                    echo '<option value="' . $item->ID_KLASIFIKASI_BARANG . '">' . $item->NAMA_KLASIFIKASI_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN_4" id="KETERANGAN_4" placeholder="Contoh : Dibutuhkan Segera" class="form-control" type="text">
                        </div>
                    </div>

                    <input type="hidden" class="form-control" name="ID_PROYEK_SUB_PEKERJAAN_4" id="ID_PROYEK_SUB_PEKERJAAN_4"  />
                    <input type="hidden" class="form-control" name="ID_PROYEK_4" id="ID_PROYEK_4"  />

                    <div class="form-group">
                        <label class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                            <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju_add_new"><i></i> Saya
                                    telah selesai melakukan pengisian identitas pada item barang/jasa dengan benar, menyetujui untuk
                                    dimasukkan ke dalam dokumen RFQ </label></div>
                        </div>
                    </div>


                    <div id="alert-msg-4"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan_data_di_luar_barang_master" disabled><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD DI LUAR BARANG MASTER-->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ubah Item Barang/Jasa RFQ</h4>
                <small class="font-bold">Silakan edit item barang/jasa RFQ</small>
            </div>
            <?php $attributes = array("ID_RFQ_FORM_2" => "contact_form", "id" => "contact_form");
            echo form_open("RFQ_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-xs-2 control-label">Identitas Barang/Jasa</label>
                    </div> 

                    <input name="ID_RFQ_FORM_2" id="ID_RFQ_FORM_2" class="form-control" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA_2" id="NAMA_2" class="form-control" type="text" placeholder="Contoh : Crane" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_2" id="MEREK_2" class="form-control" type="text" placeholder="Contoh : Toyota etc" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_2" id="SPESIFIKASI_SINGKAT_2" class="form-control" type="text" placeholder="Contoh: Mata Gerindra Stainless Grinding ukuran 4 inch " >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="JUMLAH_BARANG_2" id="JUMLAH_BARANG_2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="SATUAN_BARANG_2" id="SATUAN_BARANG_2" placeholder="Contoh : PCS" class="form-control" type="text">
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-xs-3">Klasifikasi Barang</label>
                        <div class="col-xs-9">
                            <select name="KLASIFIKASI_BARANG_2" class="form-control" id="KLASIFIKASI_BARANG_2">
                                <option value=''>- Pilih Klasifikasi Barang -</option>
                                <?php foreach ($klasifikasi_barang_list as $item) {
                                    echo '<option value="' . $item->ID_KLASIFIKASI_BARANG . '">' . $item->NAMA_KLASIFIKASI_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN_UMUM_2" id="KETERANGAN_UMUM_2" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                            <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya
                                    telah selesai melakukan pengisian identitas pada item barang/jasa dengan benar, menyetujui untuk
                                    dimasukkan ke dalam dokumen RFQ </label></div>
                        </div>
                    </div>

                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" name="btn_update" id="btn_update" disabled><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->

<!-- MODAL EDIT KETERANGAN BARANG-->
<div class="modal inmodal fade" id="ModalEditKeteranganBarang" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Keterangan Item Barang/Jasa</h4>
                <small class="font-bold">Silakan berikan keterangan atas item barang/jasa</small>
            </div>
            <?php $attributes = array("ID_RFQ_barang5" => "contact_form", "id" => "contact_form");
            echo form_open("RFQ_form/update_data_keterangan_barang", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_RFQ_FORM5" id="ID_RFQ_FORM5" class="form-control" type="hidden" readonly>

                    <div class="form-group hidden">
                        <label class="control-label col-xs-3">Kode Barang</label>
                        <div class="col-xs-9">
                            <input name="KODE_BARANG5" id="KODE_BARANG5" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA5" id="NAMA5" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek</label>
                        <div class="col-xs-9">
                            <input name="MEREK5" id="MEREK5" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT5" id="SPESIFIKASI_SINGKAT5" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Quantity Yang Diadakan</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG5" id="JUMLAH_BARANG5" class="form-control touchspin1" type="number" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan Item Barang</label>
                        <div class="col-xs-9">
                            <textarea class="form-control h-100" name="KETERANGAN5" id="KETERANGAN5" placeholder="Contoh: " required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-5"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_keterangan_barang"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KETERANGAN BARANG-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 80vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa RFQ</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus item barang/jasa ini?</p>
                        <div name="NAMA_3" id="NAMA_3"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn_hapus btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL HAPUS-->

<!-- MODAL KIRIM RFQ-->
<div class="modal inmodal fade" id="ModalEditKirimRFQ" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Kirim RFQ</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form RFQ ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("HASH_MD5_RFQ7" => "contact_form", "id" => "contact_form");
            echo form_open("RFQ_form/update_data_kirim_rfq", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="HASH_MD5_RFQ7" id="HASH_MD5_RFQ7" class="form-control" type="hidden" placeholder="ID RFQ" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="i-checks"><input type="checkbox" id="saya_setuju_kirim">
                            Saya telah selesai melakukan proses form RFQ ini dan menyetujui untuk diproses lebih lanjut
                        </div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang diminta pada RFQ ini</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada quantity item yang diadakan yang bernilai 0</center>
                        </div>
                    </div>

                    <div id="alert-msg-7"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_rfq" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM RFQ-->

<!-- MODAL EDIT CATATAN RFQ-->
<div class="modal inmodal fade" id="ModalEditCatatanRFQ" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Catatan RFQ</h4>
                <small class="font-bold">Silakan berikan komentar atau catatan mengenai Form RFQ ini</small>
            </div>
            <?php $attributes = array("ID_RFQ6" => "contact_form", "id" => "contact_form");
            echo form_open("RFQ_form/update_data_catatan_rfq", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_RFQ6" id="ID_RFQ6" class="form-control" type="hidden" placeholder="ID RFQ" readonly>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Catatan RFQ</label>

                        <div class="col-xs-9">
                            <textarea class="form-control h-100" name="CTT_STAFF_PROC6" id="CTT_STAFF_PROC6" required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-6"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_catatan_rfq"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT CATATAN RFQ-->

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- TouchSpin -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function() {
        var ID_SPPB = <?php echo $ID_SPPB;  ?>;
        var ID_RFQ = <?php echo $ID_RFQ;  ?>;
        var ID_PROYEK = <?php echo $ID_PROYEK;  ?>;
        var ID_PROYEK_SUB_PEKERJAAN = <?php echo $ID_PROYEK_SUB_PEKERJAAN;  ?>;

        $('#data_TANGGAL_DOKUMEN_RFQ .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#saya_setuju').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update').attr('disabled', true); //disable input
            }
        });

        $('#saya_setuju_add_new').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_simpan_data_di_luar_barang_master').removeAttr('disabled'); //enable input

            } else {
                $('#btn_simpan_data_di_luar_barang_master').attr('disabled', true); //disable input
            }
        });

        $("#ID_VENDOR").change(function() {
            if ($("#ID_VENDOR option:selected").text() == '- Vendor Lainnya -') {

                $('#show_hidden_vendor').attr("hidden", false); //enable input
                $('#show_hidden_vendor_2').attr("hidden", false); //enable input
                $('#show_hidden_vendor_3').attr("hidden", false); //enable input
                $('#show_hidden_vendor_4').attr("hidden", false); //enable input
                $('#show_hidden_vendor_5').attr("hidden", false); //enable input
                $('#show_hidden_vendor_6').attr("hidden", false); //enable input
                $('#show_hidden_vendor_7').attr("hidden", false); //enable input
            } else {
                $('#show_hidden_vendor').attr("hidden", true); //enable input
                $('#show_hidden_vendor_2').attr("hidden", true); //enable input
                $('#show_hidden_vendor_3').attr("hidden", true); //enable input
                $('#show_hidden_vendor_4').attr("hidden", true); //enable input
                $('#show_hidden_vendor_5').attr("hidden", true); //enable input
                $('#show_hidden_vendor_6').attr("hidden", true); //enable input
                $('#show_hidden_vendor_7').attr("hidden", true); //enable input
            }
        });

        $("#ID_TERM_OF_PAYMENT").change(function() {
            if ($("#ID_TERM_OF_PAYMENT option:selected").text() == '- TERM OF PAYMENT LAINNYA -') {

                $('#show_hidden_top').attr("hidden", false); //enable input

            } else {
                $('#show_hidden_top').attr("hidden", true); //enable input

            }
        });

        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999,
        });

        $("#checkAllsppb").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        tampil_data_form_rfq(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            aaSorting: [],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ]

        });

        $('#mydata_RASD').dataTable({
                        pageLength: 10,
                        aaSorting: [],
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'All'],
                        ],
                        responsive: true,
                        order: [
                            [2, "asc"]
                        ]
                    });

        $("#ModalAddNew").on("shown.bs.modal", function() {

            $('[name="ID_PROYEK_4"]').val(ID_PROYEK);
            $('[name="ID_PROYEK_SUB_PEKERJAAN_4"]').val(ID_PROYEK_SUB_PEKERJAAN);

            var form_data = {
                ID_PROYEK: ID_PROYEK,
                ID_PROYEK_SUB_PEKERJAAN: ID_PROYEK_SUB_PEKERJAAN
            }

        });

        //fungsi tampil data penyerahan vendor top
        function tampil_data_rfq_penyerahan_vendor_top() {
            var ID_RFQ = ID_RFQ;
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('RFQ_form/get_data_rfq') ?>",
                dataType: "JSON",
                data: {
                    ID_RFQ: ID_RFQ
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEdit').modal('show');
                        $('[name="ID_RFQ_FORM_2"]').val(data.ID_RFQ_FORM);
                        $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                        $('[name="NAMA2"]').val(data.NAMA_BARANG);
                        $('[name="MEREK2"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_BARANG);
                        $('[name="TANGGAL_MULAI_PAKAI2"]').val(data.TANGGAL_MULAI_PAKAI);
                        $('[name="TANGGAL_SELESAI_PAKAI2"]').val(data.TANGGAL_SELESAI_PAKAI);
                        $('#alert-msg-2').html('<div></div>');
                    });
                }
            });
            return false;

        }

        //fungsi tampil data
        function tampil_data_form_rfq() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>RFQ_form/data_rfq_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_RFQ
                },
                success: function(data) {

                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {


                        html += '<tr>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].NAMA_KLASIFIKASI_BARANG + '</td>' +
                            '<td>' + data[i].SATUAN_BARANG + '</td>' +
                            '<td>' + data[i].JUMLAH_BARANG + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_RFQ_FORM + '"><i class="fa fa-pencil"></i> Ubah </a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_RFQ_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' +
                            '</td>' +

                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        $("#ID_RAB_FORM_2").change(function() {
            var form_data = {
                ID_RAB_FORM: $('#ID_RAB_FORM_2').val()
            }

            $.ajax({
                url: "<?php echo base_url(); ?>/RFQ_form/get_data_id_rasd_by_id_rab_form",
                method: "POST",
                data: form_data,
                async: false,
                dataType: 'json',
                success: function(data) {

                    var html = '';
                    var i;

                    html = "<option value=''>- Pilih RASD -</option>";

                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].ID_RASD + '">' + data[i].NAMA_RASD + '</option>';
                    }
                    $('#ID_RASD_2').html(html);

                }
            });

        });

        $("#ID_RASD_2").change(function() {

            var form_data = {
                ID_RASD: $('#ID_RASD_2').val(),
                ID_RFQ: ID_RFQ
            }

            var KATEGORI_RAB_FORM = $("#ID_RAB_FORM_2 option:selected").text();

            $.ajax({
                url: "<?php echo base_url(); ?>/RFQ_form/get_data_id_rasd_form_by_id_rasd",
                method: "POST",
                data: form_data,
                async: false,
                dataType: 'json',
                success: function(data) {

                    $("#mydata_RASD").dataTable().fnDestroy();



                    var html = '';
                    var i;

                    for (i = 0; i < data.length; i++) {

                        html += '<tr>' +
                            '<td style="width: 10%;">' + '<input name="ID_RFQ" class="form-control" type="text" value="<?php echo $ID_RFQ  ?>" style="display: none;" readonly>' + '<input name="KATEGORI_RAB_FORM" class="form-control" type="text" value="' + KATEGORI_RAB_FORM + '" style="display: none;" readonly>' + '<input class="checkbox" name="ID_RASD_FORM[]" value="' + data[i].ID_RASD_FORM + '" type="checkbox">' + '<input name="PERALATAN_PERLENGKAPAN" class="form-control" type="text" value="' + $("#ID_RAB_FORM_2 option:selected").text() + '" style="display: none;" readonly>' + '</td>' +
                            '<td>' + data[i].NAMA + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].JUMLAH_BARANG + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                            '<td style="width: 20%;"> <input class="touchspin1" type="number" value="0" name="' + data[i].ID_RASD_FORM + '"></td>' +
                            '</tr>';
                    }
                    $('#show_data_RASD').html(html);

                    $("#mydata_RASD").dataTable().draw();

                }
            });

        });



        //GET UPDATE untuk edit jumlah
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('RFQ_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {

                    $('#ModalEdit').modal('show');
                    $('[name="ID_RFQ_FORM_2"]').val(data.ID_RFQ_FORM);
                    $('[name="NAMA_2"]').val(data.NAMA_BARANG);
                    $('[name="MEREK_2"]').val(data.MEREK);
                    $('[name="KLASIFIKASI_BARANG_2"]').val(data.ID_JENIS_BARANG);
                    $('[name="PERALATAN_PERLENGKAPAN_2"]').val(data.PERALATAN_PERLENGKAPAN);
                    $('[name="SPESIFIKASI_SINGKAT_2"]').val(data.SPESIFIKASI_SINGKAT);
                    $('[name="SATUAN_BARANG_2"]').val(data.SATUAN_BARANG);
                    $('[name="JUMLAH_BARANG_2"]').val(data.JUMLAH_BARANG);
                    $('[name="KLASIFIKASI_BARANG_2"]').val(data.ID_KLASIFIKASI_BARANG);
                }
            });
            return false;
        });

        //UPDATE JUSTIFIKASI BARANG 
        $('#btn_update_keterangan_barang').on('click', function() {

            let ID_RFQ_FORM = $('#ID_RFQ_FORM5').val();
            let KETERANGAN = $('#KETERANGAN5').val();
            $.ajax({
                url: "<?php echo site_url('RFQ_form/update_data_keterangan_barang') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_RFQ_FORM: ID_RFQ_FORM,
                    KETERANGAN: KETERANGAN
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKeteranganBarang').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //SIMPAN DATA
        $('#btn_simpan_data_di_luar_barang_master').click(function() {
            var form_data = {
                ID_RFQ: ID_RFQ,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                KLASIFIKASI_BARANG: $('#KLASIFIKASI_BARANG_4').val(),
                KETERANGAN: $('#KETERANGAN_4').val()
            };
            $.ajax({
                url: "<?php echo site_url('RFQ_form/simpan_data_di_luar_barang_master'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data == true) {
                        document.getElementById("saya_setuju").checked = false;
                        $('#btn_simpan_data_di_luar_barang_master').attr('disabled', true); //disable input
                        $('#ModalAddNew').modal('hide');
                        $("#mydata").dataTable().fnDestroy();
                        tampil_data_form_rfq();
                    } else {
                        $('#alert-msg-4').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        $('#btn_simpan_identitas_form').click(function() {
            var BATAS_AKHIR = $('#BATAS_AKHIR').val(),
            BATAS_AKHIR = BATAS_AKHIR.split("/").reverse().join("-");

            var form_data = {
                ID_RFQ: ID_RFQ,
                ID_PROYEK_LOKASI_PENYERAHAN: $('#ID_PROYEK_LOKASI_PENYERAHAN').val(),
                ID_VENDOR: $('#ID_VENDOR').val(),
                ID_TERM_OF_PAYMENT: $('#ID_TERM_OF_PAYMENT').val(),
                NAMA_TERM_OF_PAYMENT: $('#NAMA_TERM_OF_PAYMENT').val(),
                NAMA_VENDOR: $('#NAMA_VENDOR').val(),
                ALAMAT_VENDOR: $('#ALAMAT_VENDOR').val(),
                EMAIL_VENDOR: $('#EMAIL_VENDOR').val(),
                NO_TELP_VENDOR: $('#NO_TELP_VENDOR').val(),
                NAMA_PIC_VENDOR: $('#NAMA_PIC_VENDOR').val(),
                EMAIL_PIC_VENDOR: $('#EMAIL_PIC_VENDOR').val(),
                NO_HP_PIC_VENDOR: $('#NO_HP_PIC_VENDOR').val(),
                KETERANGAN_RFQ: $('#KETERANGAN_RFQ').val(),
                BATAS_AKHIR: BATAS_AKHIR
            };
            $.ajax({
                url: "<?php echo site_url('RFQ_form/simpan_identitas_form'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 'true') {
                        $('#alert-msg-8').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var HASH_MD5_RFQ = $('#HASH_MD5_RFQ').val()
                        var alamat = "<?php echo base_url('RFQ_form/index/'); ?>" + HASH_MD5_RFQ;
                        window.open(
                            alamat,
                            '_self' // <- This is what makes it open in a new window.
                        );
                    }
                }
            });
            return false;
        });

        //SIMPAN PERUBAHAN DAN LIHAT PDF
        // $('#btn_simpan_perubahan_pdf').click(function() {
        //     var form_data = {
        //         ID_RFQ: ID_RFQ,
        //         ID_PROYEK_LOKASI_PENYERAHAN: $('#ID_PROYEK_LOKASI_PENYERAHAN').val(),
        //         ID_VENDOR: $('#ID_VENDOR').val(),
        //         ID_TERM_OF_PAYMENT: $('#ID_TERM_OF_PAYMENT').val(),
        //         NAMA_TERM_OF_PAYMENT: $('#NAMA_TERM_OF_PAYMENT').val(),
        //         NAMA_VENDOR: $('#NAMA_VENDOR').val(),
        //         ALAMAT_VENDOR: $('#ALAMAT_VENDOR').val(),
        //         EMAIL_VENDOR: $('#EMAIL_VENDOR').val(),
        //         NO_TELP_VENDOR: $('#NO_TELP_VENDOR').val(),
        //         NAMA_PIC_VENDOR: $('#NAMA_PIC_VENDOR').val(),
        //         EMAIL_PIC_VENDOR: $('#EMAIL_PIC_VENDOR').val(),
        //         NO_HP_PIC_VENDOR: $('#NO_HP_PIC_VENDOR').val(),
        //         KETERANGAN_RFQ: $('#KETERANGAN_RFQ').val(),
        //         BATAS_AKHIR: $('#BATAS_AKHIR').val()
        //     };
        //     $.ajax({
        //         url: "<?php echo site_url('RFQ_form/simpan_identitas_form'); ?>",
        //         type: 'POST',
        //         data: form_data,
        //         success: function(data) {
        //             if (data != 'true') {
        //                 $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
        //             } else {
        //                 var HASH_MD5_RFQ = $('#HASH_MD5_RFQ').val()
        //                 var alamat = "<?php echo base_url('RFQ_form/view/'); ?>" + HASH_MD5_RFQ;
        //                 window.open(
        //                     alamat,
        //                     '_self' // <- This is what makes it open in a new window.
        //                 );
        //             }
        //         }
        //     });
        //     return false;
        // });

        //GET UDPATE untuk berikan justifkasi
        $('#show_data').on('click', '.item_edit_keterangan', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('RFQ_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditKeteranganBarang').modal('show');
                        $('[name="ID_RFQ_FORM5"]').val(data.ID_RFQ_FORM);
                        $('[name="KODE_BARANG5"]').val(data.KODE_BARANG);
                        $('[name="NAMA5"]').val(data.NAMA_BARANG);
                        $('[name="MEREK5"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT5"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG5"]').val(data.JUMLAH_BARANG);
                        $('[name="KETERANGAN5"]').val(data.KETERANGAN);
                        $('#alert-msg-5').html('<div></div>');
                    });
                }
            });
            return false;
        });

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            var form_data = {
                ID_RFQ_FORM: $('#ID_RFQ_FORM_2').val(),
                NAMA: $('#NAMA_2').val(),
                MEREK: $('#MEREK_2').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_2').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_2').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_2').val(),
                KLASIFIKASI_BARANG: $('#KLASIFIKASI_BARANG_2').val(),
                KETERANGAN: $('#KETERANGAN_UMUM_2').val()
            };

            $.ajax({
                url: "<?php echo site_url('RFQ_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: form_data,
                success: function(data) {
                    if (data == true) {
                        document.getElementById("saya_setuju").checked = false;
                        $('#btn_update').attr('disabled', true); //disable input
                        $('#ModalEdit').modal('hide');
                        $("#mydata").dataTable().fnDestroy();
                        tampil_data_form_rfq();
                    } else {
                        $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('RFQ_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(id);
                        $('#NAMA_3').html('</br>Nama Barang : ' + data.NAMA_BARANG);

                    });
                }
            });
        });

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RFQ_form/hapus_data') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    $('#ModalHapus').modal('hide');
                    window.location.reload();
                }
            });
            return false;
        });

        $('#saya_setuju_kirim').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_rfq').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_rfq').attr('disabled', true); //disable input
            }
        });

        //UPDATE CATATAN RFQ 
        $('#btn_update_catatan_rfq').on('click', function() {

            let ID_RFQ = $('#ID_RFQ6').val();
            let CTT_STAFF_PROC = $('#CTT_STAFF_PROC6').val();
            $.ajax({
                url: "<?php echo site_url('RFQ_form/update_data_catatan_rfq') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_RFQ: ID_RFQ,
                    CTT_STAFF_PROC: CTT_STAFF_PROC
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditCatatanRFQ').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });


        //UPDATE KIRIM SPPB 
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
                        window.location.href = '<?php echo site_url('RFQ') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        item_edit_catatan_rfq.onclick = function() {
            var HASH_MD5_RFQ = $(this).attr('data');

            $.ajax({
                type: "GET",
                url: "<?php echo base_url('RFQ_form/get_data_ctt_rfq') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_RFQ: HASH_MD5_RFQ
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditCatatanRFQ').modal('show');
                        $('[name="ID_RFQ6"]').val(data.ID_RFQ);
                        $('[name="CTT_STAFF_PROC6"]').val(data.CTT_STAFF_PROC);

                        $('#alert-msg-6').html('<div></div>');
                    });
                }
            });
            return false;
        };

        item_edit_kirim_rfq.onclick = function() {
            var HASH_MD5_RFQ = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('RFQ_form/get_id_rfq_by_HASH_MD5_RFQ') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_RFQ: HASH_MD5_RFQ
                },
                success: function(data) {
                    if (data.ID_VENDOR == null || data.ID_TERM_OF_PAYMENT == null || data.ID_PROYEK_LOKASI_PENYERAHAN == null) {
                        $('#alert-msg-7').html('<div>Anda belum menentukan Vendor atau Term of Payment atau Lokasi Penyerahan. Anda dialihkan ke halaman pengisian RFQ</div>');

                        var tid = setInterval(function() {
                            //called 5 times each time after one second  
                            //before getting cleared by below timeout. 
                            // alert("I am setInterval");
                        }, 5000); //delay is in milliseconds 

                        alert("Anda belum menentukan Vendor atau Term of Payment atau Lokasi Penyerahan. Anda dialihkan ke halaman pengisian RFQ"); //called second
                        location.reload();
                    } else {
                        var ID_RFQ = data.ID_RFQ;
                        $.ajax({
                            type: "GET",
                            url: "<?php echo base_url('RFQ_form/get_data_rfq_form_by_id_rfq') ?>",
                            dataType: "JSON",
                            data: {
                                ID_RFQ: ID_RFQ
                            },
                            success: function(data) {

                                //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                                if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                                    $('#show_hidden_setuju').attr("hidden", true);
                                    $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);

                                } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                                    var i = 0;
                                    for (i = 0; i < data.length; i++) {
                                        //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                                        if (data[i].JUMLAH_BARANG == 0) {
                                            $('#show_hidden_setuju').attr("hidden", true);
                                            $('#show_hidden_belum_atur_jumlah_barang').attr("hidden", false);
                                            break;
                                        }
                                        if (data[i].JUMLAH_BARANG == null) {
                                            $('#show_hidden_setuju').attr("hidden", true);
                                            $('#show_hidden_belum_atur_jumlah_barang').attr("hidden", false);
                                            break;
                                        }

                                        //JIKA SEMUA ITEM BARANG ADA JUMLAH MINTANYA (TIDAK NOL)
                                        if (i == (data.length - 1)) {
                                            $('#show_hidden_setuju').attr("hidden", false);
                                        }
                                    }
                                }
                                $('#ModalEditKirimRFQ').modal('show');
                                $('[name="HASH_MD5_RFQ7"]').val(HASH_MD5_RFQ);
                            }
                        });
                    }

                }
            });
            return false;
        };
    });
</script>

</body>

</html>