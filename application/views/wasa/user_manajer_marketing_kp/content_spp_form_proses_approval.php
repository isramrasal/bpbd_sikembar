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

<!-- Form SPP -->
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Pastikan Anda mengisi data dengan benar.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Formulir Pengajuan SPP</h5>
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

                            <li class=""><a data-toggle="tab" href="#tab-2">Catatan SPP</a></li>

                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <form method="get" class="form-horizontal">
                                        <?php
                                        if (isset($SPPB)) {
                                            foreach ($SPPB->result() as $SPPB) :
                                        ?>
                                                <div class="form-group"><label class="col-sm-2 control-label">No Urut SPPB:</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->NO_URUT_SPPB; ?>" disabled></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Proyek:</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->NAMA_PROYEK; ?>" disabled></div>
                                                </div>
                                        <?php endforeach;
                                        } ?>

                                        <?php
                                        if (isset($SPP)) {
                                            foreach ($SPP->result() as $SPP) :
                                        ?>
                                                <div class="form-group"><label class="col-sm-2 control-label">No Urut SPP:</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPP->NO_URUT_SPP; ?>" disabled></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pengajuan SPP:</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPP->TANGGAL_DOKUMEN_SPP; ?>" disabled></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pembuatan SPP:</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPP->TANGGAL_PEMBUATAN_SPP_HARI; ?>" disabled></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Jenis Permintaan:</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPP->JENIS_PERMINTAAN; ?>" disabled></div>
                                                </div>
                                        <?php endforeach;
                                        } ?>
                                    </form>
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
                                                    <span>Catatan Staff Procurement Site Project:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_STAFF_PROC_PROYEK']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Supervisi Procurement Site Project:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_SPV_PROC_PROYEK']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan SM:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_SM']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan PM:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_PM']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Staff Procurement KP:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_STAFF_PROC_KP']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Kasie Procurement KP:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_KASIE_PROC_KP']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer Logistik KP:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_M_LOG']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer Keuangan:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_M_KEU']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer Konstruksi:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_M_KONS']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer SDM:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_M_SDM']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer QAQC:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_M_QAQC']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer EP:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_M_EP']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer HSSE:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_M_HSSE']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer Marketing:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_M_MARKETING']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer Komersial:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_M_KOMERSIAL']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer Procurement KP:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_M_PROC']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Direktur PSDS:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_D_PSDS']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Direktur EP dan Konstruksi:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_D_EP_KONS']; ?>
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Direktur Keuangan:</span>
                                                </a>
                                            </div>
                                            <?php echo $CATATAN_SPP['CTT_D_KEU']; ?>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="hr-line-dashed"></div>
                                    <a href="javascript:;" id="item_edit_catatan_spp" name="item_edit_catatan_spp" class="btn btn-info" data="<?php echo $HASH_MD5_SPP; ?>"><i class="fa fa-comment"></i> Berikan Catatan SPP </a>
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
                            <h5>SPP Item Barang/Jasa</h5>
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

                                <div class="alert alert-warning alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    Perubahan data pada form SPP tidak akan mempengaruhi data pada form SPPB.
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="mydata">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Merek Barang</th>
                                                <th>Jenis Barang</th>
                                                <th>Tool/</br>Consumable/</br>Material</th>
                                                <th>Spesifikasi Singkat</th>
                                                <th>Jumlah Yang Diadakan</th>
                                                <th>Tanggal Dibutuhkan</th>
                                                <th>Supplier / Vendor</th>
                                                <th>Harga Satuan Barang</th>
                                                <th>Harga Total Barang</th>
                                                <th>Tolak / Batal Tolak</th>
                                                <th>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_data">

                                        </tbody>

                                    </table>
                                </div>
                                <div id="alert-msg-6"></div>
                            </div>
                        </div>
                    </div>

                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="form-group">
                                <div class="sm-10">
                                    <a href="<?php echo base_url('index.php/SPP_form/view/') ?><?php echo $HASH_MD5_SPP; ?>" class="btn btn-primary"><span class="fa fa-save"></span> Simpan Perubahan & View Dokumen SPP</a>
                                    </br>
                                    <a href="javascript:;" id="item_edit_kirim_spp" name="item_edit_kirim_spp" class="btn btn-success" data="<?php echo $HASH_MD5_SPP; ?>"><span class="fa fa-send"></span> Ajukan SPP Untuk Proses Selanjutnya </a><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Form SPP -->

<!-- MODAL ADD FROM MASTER LIST -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <?php
            if ($barang_master_list != NULL) {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-suitcase modal-icon"></i>
                    <h4 class="modal-title">Daftar Master List</h4>
                    <small class="font-bold">Silakan isi data SPP berdasarkan daftar Master List/Price List</small>

                </div>

                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="alert alert-info alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Daftar Master List berikut adalah daftar barang yang tidak termasuk dalam RASD proyek
                        </div>
                        <div class="table-responsive">

                            <form method="POST" action="<?php echo site_url('SPP_form/simpan_data_dari_barang_master'); ?>" id="formTambahMASTER">
                                <table class="table table-striped table-bordered table-hover" id="modalmaster">
                                    <thead>
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Merek Barang</th>
                                            <th>Jenis Barang</th>
                                            <th style="width: 30%;">Spesifikasi Singkat</th>
                                            <th>Satuan Barang</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($barang_master_list as $data) : ?>
                                            <tr>
                                                <td>
                                                    <input name="ID_SPP" class="form-control" type="text" value="<?php echo $ID_SPP  ?>" style="display: none;" readonly>
                                                    <input class="checkbox" name="ID_BARANG_MASTER[]" value="<?php echo $data->ID_BARANG_MASTER ?>" type="checkbox">
                                                </td>
                                                <td><a href="<?php echo base_url() ?>barang_master/profil_barang_master/<?php echo $data->HASH_MD5_BARANG_MASTER; ?>" class="btn btn-warning btn-xs btn-outline block" target="_blank"><i class="fa fa-eye"></i> <?php echo $data->KODE_BARANG; ?> </a>
                                                </td>
                                                <td> <?php echo $data->NAMA; ?> </td>
                                                <td> <?php echo $data->MEREK; ?> </td>
                                                <td> <?php echo $data->NAMA_JENIS_BARANG; ?> </td>
                                                <td> <?php echo $data->SPESIFIKASI_SINGKAT; ?> </td>
                                                <td> <?php echo $data->NAMA_SATUAN_BARANG; ?> </td>
                                                <td style="width: 20%;">
                                                    <input class=" touchspin1" type="text" value="0" name="<?php echo $data->ID_BARANG_MASTER ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                        ?>
                                    </tbody>
                                </table>

                            </form>
                        </div>
                        <div id="alert-msg"></div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                        <button class="btn btn-primary" type="submit" form="formTambahMASTER"><i class="fa fa-save"></i> Tambah</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            <?php
            } else {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-exclamation-triangle modal-icon"></i>
                    <h4 class="modal-title">Form FPB dari Master List</h4>
                    <b class="font-bold">Maaf semua barang dari master list sudah ada di FPB ini</b>
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
<!--END MODAL ADD-->

<!-- MODAL ADD  DARI RASD -->
<div class="modal inmodal fade" id="ModalAddDariRasdBarang" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <?php
            if ($rasd_barang_list != NULL) {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-suitcase modal-icon"></i>
                    <h4 class="modal-title">Daftar Item Barang/Jasa dari RASD</h4>
                    <small class="font-bold">Silakan isi data FPB berdasarkan daftar RASD</small>
                </div>

                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="table-responsive">

                            <form method="POST" action="<?php echo site_url('SPP_form/simpan_data_dari_rasd_form'); ?>" id="formTambahRASD">
                                <table class="table table-striped table-bordered table-hover" id="modalrasd">
                                    <thead>
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Kode Barang</th>
                                            <th>RASD (Unit)</th>
                                            <th>Nama Barang</th>
                                            <th>Merek Barang</th>
                                            <th>Jenis Barang</th>
                                            <th style="width: 30%;">Spesifikasi Singkat</th>
                                            <th>Satuan Barang</th>
                                            <th>Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody">
                                        <?php
                                        foreach ($rasd_barang_list as $data) : ?>
                                            <tr>

                                                <td>
                                                    <input name="ID_SPP" class="form-control" type="text" value="<?php echo $ID_SPP  ?>" style="display: none;" readonly>
                                                    <input class="checkbox" name="ID_RASD_FORM[]" value="<?php echo $data->ID_RASD_FORM ?>" type="checkbox">
                                                </td>
                                                <?php if ($data->ID_BARANG_MASTER == null) { ?>
                                                    <td><span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span></td>
                                                <?php } else { ?>
                                                    <td><a href="<?php echo base_url() ?>barang_master/profil_barang_master/<?php echo $data->HASH_MD5_BARANG_MASTER; ?>" class="btn btn-warning btn-xs btn-outline block" target="_blank"><i class="fa fa-eye"></i> <?php echo $data->KODE_BARANG; ?> </a>
                                                    </td>
                                                <?php } ?>

                                                <td> <?php echo $data->JUMLAH_BARANG; ?> </td>
                                                <td> <?php echo $data->NAMA; ?> </td>
                                                <td> <?php echo $data->MEREK; ?> </td>
                                                <td> <?php echo $data->NAMA_JENIS_BARANG; ?> </td>
                                                <td> <?php echo $data->SPESIFIKASI_SINGKAT; ?> </td>
                                                <td> <?php echo $data->NAMA_SATUAN_BARANG; ?> </td>
                                                <td style="width: 20%;">
                                                    <input class="touchspin1" type="text" value="0" name="<?php echo $data->ID_RASD_FORM ?>">
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                        ?>
                                        </tbody>
                                </table>

                            </form>
                        </div>
                        <div id="alert-msg-add-dari-rasd"></div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                        <button class="btn btn-primary" type="submit" form="formTambahRASD"><i class="fa fa-save"></i> Tambah</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            <?php
            } else {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-exclamation-triangle modal-icon"></i>
                    <h4 class="modal-title">Daftar Item Barang/Jasa dari RASD</h4>
                    <b class="font-bold">Maaf semua item barang/jasa dari RASD sudah ada di Form FPB ini</b>
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
<!--END MODAL ADD DARI RASD -->

<!-- MODAL ADD DI LUAR BARANG MASTER-->
<div class="modal inmodal fade" id="ModalAddNew" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Ajukan Item Barang/Jasa Di Luar RASD dan Master List</h4>
                <small class="font-bold">Silakan isi data Item Barang/Jasa SPP yang Baru</small>
            </div>
            <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
            echo form_open("SPP_form/simpan_data_di_luar_barang_master", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA_4" id="NAMA_4" class="form-control" type="text" placeholder="Contoh : Crane" required autofocus>
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_4" id="MEREK_4" class="form-control" type="text" placeholder="Contoh : Toyota etc" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Barang</label>
                        <div class="col-xs-9">
                            <select name="JENIS_BARANG_4" class="form-control" id="JENIS_BARANG_4">
                                <option value=''>- Pilih Jenis Barang -</option>
                                <?php foreach ($jenis_barang_list as $item) {
                                    echo '<option value="' . $item->ID_JENIS_BARANG . '">' . $item->NAMA_JENIS_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_4" id="SPESIFIKASI_SINGKAT_4" class="form-control" type="text" placeholder="Contoh: Mata Gerindra Stainless Grinding ukuran 4 inch " required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <select name="SATUAN_BARANG_4" class="form-control" id="SATUAN_BARANG_4">
                                <option value=''>- Pilih Satuan Barang -</option>
                                <?php foreach ($satuan_barang_list as $item) {
                                    echo '<option value="' . $item->ID_SATUAN_BARANG . '">' . $item->NAMA_SATUAN_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="JUMLAH_BARANG_4" id="JUMLAH_BARANG_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Vendor</label>
                        <div class="col-xs-9">
                            <select class="form-control" name="ID_VENDOR_4" id="ID_VENDOR_4">
                                <option value=''>- Pilih Vendor -</option>
                                <?php foreach ($vendor as $prov) {
                                    echo '<option value="' . $prov->ID_VENDOR . '">' . $prov->NAMA_VENDOR . '</option>';
                                } ?>
                                <option value='666666'>- Vendor Lainnya -</option>
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_vendor" class="form-group" hidden>
                        <label class="control-label col-xs-3">Nama Vendor</label>
                        <div class="col-xs-9">
                            <input type="text" name="NAMA_VENDOR_4" id="NAMA_VENDOR_4" class="form-control" placeholder="Contoh: PT. Pertamina Persero">
                        </div>
                    </div>

                    <div id="show_hidden_vendor_2" class="form-group" hidden>
                        <label class="control-label col-xs-3">Alamat Vendor</label>
                        <div class="col-xs-9">
                            <input type="text" name="ALAMAT_VENDOR_4" id="ALAMAT_VENDOR_4" class="form-control" placeholder="Contoh: JL. TB Simatupang Kavling 28">
                        </div>
                    </div>

                    <div id="show_hidden_vendor_3" class="form-group" hidden>
                        <label class="control-label col-xs-3">No Telepon Vendor</label>
                        <div class="col-xs-9">
                            <input type="text" name="NO_TELP_VENDOR_4" id="NO_TELP_VENDOR_4" class="form-control" placeholder="Contoh: 021-8762812">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_FIX_4" id="HARGA_SATUAN_BARANG_FIX_4" class="form-control" type="text" placeholder="Contoh: Rp 2000000 ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Total Barang</label>
                        <div class="col-xs-9">
                            <input name="HARGA_TOTAL_FIX_4" id="HARGA_TOTAL_FIX_4" class="form-control" type="hidden" placeholder="Contoh: Rp 14000000 " disabled>
                            <input name="HARGA_TOTAL_TAMPIL_4" id="HARGA_TOTAL_TAMPIL_4" class="form-control" type="text" placeholder="Contoh: Rp 14000000 " disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Tanggal Mulai Pemakaian</label>
                        <div class="col-xs-9">
                            <input name="TANGGAL_MULAI_PAKAI_4" id="TANGGAL_MULAI_PAKAI_4" class="form-control" type="date">
                            (mm/dd/yyyy)
                        </div>
                    </div>

                    <div id="alert-msg1"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan_data_di_luar_barang_master"><i class="fa fa-save"></i> Tambah</button>
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
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Ubah Item Barang/Jasa SPP</h4>
                <small class="font-bold">Silakan edit item barang/jasa SPP</small>
            </div>
            <?php $attributes = array("ID_SPP_FORM2" => "contact_form", "id" => "contact_form");
            echo form_open("SPP_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_SPP_FORM2" id="ID_SPP_FORM2" class="form-control" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA2" id="NAMA2" class="form-control" type="text" placeholder="Contoh : Mata Gerinda 3 Inch">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK2" id="MEREK2" class="form-control" type="text" placeholder="Contoh : Tekiro">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Barang</label>
                        <div class="col-xs-9">
                            <select name="JENIS_BARANG2" class="form-control" id="JENIS_BARANG2">
                                <option value=''>- Pilih Jenis Barang -</option>
                                <?php foreach ($jenis_barang_list as $item) {
                                    echo '<option value="' . $item->ID_JENIS_BARANG . '">' . $item->NAMA_JENIS_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT2" id="SPESIFIKASI_SINGKAT2" class="form-control" type="text" placeholder="Contoh : 3 Inch">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <select name="SATUAN_BARANG2" class="form-control" id="SATUAN_BARANG2">
                                <option value=''>- Pilih Satuan Barang -</option>
                                <?php foreach ($satuan_barang_list as $item) {
                                    echo '<option value="' . $item->ID_SATUAN_BARANG . '">' . $item->NAMA_SATUAN_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG2" id="JUMLAH_BARANG2" class="touchspin1" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Vendor</label>
                        <div class="col-xs-9">
                            <select class="form-control" name="ID_VENDOR2" id="ID_VENDOR2">
                                <option value=''>- Pilih Vendor -</option>
                                <?php foreach ($vendor as $prov) {
                                    echo '<option value="' . $prov->ID_VENDOR . '">' . $prov->NAMA_VENDOR . '</option>';
                                } ?>
                                <option value='666666'>- Vendor Lainnya -</option>
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_vendor_4" class="form-group" hidden>
                        <label class="control-label col-xs-3">Nama Vendor</label>
                        <div class="col-xs-9">
                            <input type="text" name="NAMA_VENDOR2" id="NAMA_VENDOR2" class="form-control" placeholder="Contoh: PT. Pertamina Persero">
                        </div>
                    </div>

                    <div id="show_hidden_vendor_5" class="form-group" hidden>
                        <label class="control-label col-xs-3">Alamat Vendor</label>
                        <div class="col-xs-9">
                            <input type="text" name="ALAMAT_VENDOR2" id="ALAMAT_VENDOR2" class="form-control" placeholder="Contoh: JL. TB Simatupang Kavling 28">
                        </div>
                    </div>

                    <div id="show_hidden_vendor_6" class="form-group" hidden>
                        <label class="control-label col-xs-3">No Telepon Vendor</label>
                        <div class="col-xs-9">
                            <input type="text" name="NO_TELP_VENDOR2" id="NO_TELP_VENDOR2" class="form-control" placeholder="Contoh: 021-8762812">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_FIX2" id="HARGA_SATUAN_BARANG_FIX2" class="form-control" type="text" placeholder="Contoh: Rp 2000000 ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Total Barang</label>
                        <div class="col-xs-9">

                            <input name="HARGA_TOTAL_FIX2" id="HARGA_TOTAL_FIX2" class="form-control" type="hidden" placeholder="Contoh: Rp 14000000 " disabled />
                            <input name="HARGA_TOTAL_TAMPIL2" id="HARGA_TOTAL_TAMPIL2" class="form-control" type="text" placeholder="Contoh: Rp 14000000 " disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Tanggal Mulai Pemakaian</label>
                        <div class="col-xs-9">
                            <input name="TANGGAL_MULAI_PAKAI2" id="TANGGAL_MULAI_PAKAI2" class="form-control" type="date">
                            (mm/dd/yyyy)
                        </div>
                    </div>

                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Ubah</button>
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
            <?php $attributes = array("ID_SPP_barang5" => "contact_form", "id" => "contact_form");
            echo form_open("SPP_form/update_data_justifikasi_barang", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_SPP_FORM5" id="ID_SPP_FORM5" class="form-control" type="hidden" readonly>

                    <div class="form-group">
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
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG5" id="JUMLAH_BARANG5" class="form-control" type="number" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_FIX5" id="HARGA_SATUAN_BARANG_FIX5" class="form-control" type="number" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Total Barang</label>
                        <div class="col-xs-9">
                            <input name="HARGA_TOTAL_FIX5" id="HARGA_TOTAL_FIX5" class="form-control" type="number" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan Item Barang</label>
                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="KETERANGAN5" id="KETERANGAN5" placeholder="Contoh: " required></textarea>
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
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa SPP</h4>
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

<!-- MODAL KIRIM SPP-->
<div class="modal inmodal fade" id="ModalEditKirimSPP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim SPP</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form SPP ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_SPP7" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_kirim_sppb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SPP7" id="ID_SPP7" class="form-control" type="hidden" placeholder="ID_SPP" readonly>

                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melalukan proses form SPP ini dan menyetujui untuk diproses lebih lanjut </label></div>
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

<!-- MODAL EDIT CATATAN SPPB-->
<div class="modal inmodal fade" id="ModalEditCatatanSPP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Catatan SPP</h4>
                <small class="font-bold">Silakan berikan komentar atau catatan mengenai Form SPP ini</small>
            </div>
            <?php $attributes = array("ID_SPP6" => "contact_form", "id" => "contact_form");
            echo form_open("SPP_form/update_data_catatan_spp", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_SPP6" id="ID_SPP6" class="form-control" type="hidden" placeholder="ID SPP" readonly>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Catatan SPP</label>

                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="CTT_M_MARKETING6" id="CTT_M_MARKETING6" required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-6"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_catatan_spp"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT CATATAN SPPB-->

<!--MODAL CORET-->
<div class="modal fade" id="ModalCoret" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Tolak Item Barang/Jasa SPP</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menolak permintaan item barang/jasa ini?</p>
                        <div name="NAMA_3" id="NAMA_3"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Alasan Penolakan</label>
                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="CATATAN_CORET" id="CATATAN_CORET" placeholder="Contoh: Tidak sesuai dengan kebutuhan di lapangan " required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-8"></div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn_coret btn btn-danger" id="btn_coret"><i class="fa fa-trash"></i> Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL CORET-->

<!--MODAL BATAL CORET-->
<div class="modal fade" id="ModalBatalCoret" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Batal Tolak Item Barang/Jasa SPP</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menerima permintaan item barang/jasa ini?</p>
                        <div name="NAMA_4" id="NAMA_4"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Alasan Menerima Permintaan</label>
                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="CATATAN_BATAL_CORET" id="CATATAN_BATAL_CORET" placeholder="Contoh: Sudah dilakukan cross check dengan kebutuhan di lapangan " required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-4"></div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn_terima btn btn-info" id="btn_terima"><i class="fa fa-check"></i> Terima</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END BATAL CORET-->

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
        $("#ID_VENDOR_4").change(function() {
            if ($("#ID_VENDOR_4 option:selected").text() == '- Vendor Lainnya -') {
                $('#show_hidden_vendor').attr("hidden", false); //enable input
                $('#show_hidden_vendor_2').attr("hidden", false); //enable input
                $('#show_hidden_vendor_3').attr("hidden", false); //enable input
            } else {
                $('#show_hidden_vendor').attr("hidden", true); //enable input
                $('#show_hidden_vendor_2').attr("hidden", true); //enable input
                $('#show_hidden_vendor_3').attr("hidden", true); //enable input
            }
        });

        $("#ID_VENDOR2").change(function() {
            if ($("#ID_VENDOR2 option:selected").text() == '- Vendor Lainnya -') {
                $('#show_hidden_vendor_4').attr("hidden", false); //enable input
                $('#show_hidden_vendor_5').attr("hidden", false); //enable input
                $('#show_hidden_vendor_6').attr("hidden", false); //enable input
            } else {
                $('#show_hidden_vendor_4').attr("hidden", true); //enable input
                $('#show_hidden_vendor_5').attr("hidden", true); //enable input
                $('#show_hidden_vendor_6').attr("hidden", true); //enable input
            }
        });

        var ID_SPPB = <?php echo $ID_SPPB;  ?>;
        var ID_SPP = <?php echo $ID_SPP;  ?>;
        $("#HARGA_SATUAN_BARANG_FIX_4").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_4").val();
            var JUMLAH = $("#JUMLAH_BARANG_4").val();
            var TOTAL = HARGA * JUMLAH;

            $('[name="HARGA_TOTAL_FIX_4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999,
        });

        tampil_data_form_spp(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            order: [
                [2, "asc"]
            ],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv',
                    title: 'SPP Form'
                },
                {
                    extend: 'excel',
                    title: 'SPP Form'
                },
                {
                    extend: 'pdf',
                    title: 'SPP Form'
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

        //fungsi tampil data
        function tampil_data_form_spp() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>SPP_form/data_spp_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_SPP
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_BARANG;
                        let jumlah_rasd = data[i].JUMLAH_RASD;
                        let kode_barang = data[i].KODE_BARANG;

                        if (kode_barang != null) {
                            kode_barang_cetak = '<a href="<?php echo base_url() ?>barang_master/profil_barang_master/' + data[i].HASH_MD5_BARANG_MASTER + '" class="btn btn-warning btn-xs btn-outline block" target="_blank"><i class="fa fa-eye"></i> ' + kode_barang + ' </a>';
                        }
                        if (kode_barang == null) {
                            kode_barang_cetak = '<span class="label label-info block"><i class="fa fa-warning"></i> Data Baru</span>';
                        }

                        if (jumlah_barang == null) {
                            jumlah_barang = 0;
                        }
                        if (kode_barang == null) {
                            kode_barang = `<span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span>`;
                        }
                        if (jumlah_rasd == null) {
                            jumlah_rasd = 0;
                        }
                        
                        data[i].HARGA_SATUAN_BARANG_FIX = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data[i].HARGA_SATUAN_BARANG_FIX);

                        HARGA_TOTAL_FIX = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data[i].HARGA_TOTAL_FIX);

                        if (data[i].CORET == '1') {
                            html += '<tr>' +
                                '<td class="danger"> <strike>' + kode_barang_cetak + '</td> </strike>' +
                                '<td class="danger"> <strike>' + data[i].NAMA_BARANG + '</td> </strike>' +
                                '<td class="danger"> <strike>' + data[i].MEREK + '</td> </strike>' +
                                '<td class="danger"> <strike>' + data[i].NAMA_JENIS_BARANG + '</td> </strike>' +
                                '<td class="danger"> <strike>' + data[i].PERALATAN_PERLENGKAPAN + '</td> </strike>' +
                                '<td class="danger"> <strike>' + data[i].SPESIFIKASI_SINGKAT + '</td> </strike>' +
                                '<td class="danger"> <strike>' + jumlah_barang + ' ' + data[i].NAMA_SATUAN_BARANG + '</td> </strike>' +
                                '<td class="danger"> <strike>' + data[i].TANGGAL_MULAI_PAKAI + '</td> </strike>' +
                                '<td class="danger"> <strike>' + data[i].NAMA_VENDOR + '</td> </strike>' +
                                '<td class="danger"> <strike>' + data[i].HARGA_SATUAN_BARANG_FIX + '</td> </strike>' +
                                '<td class="danger"> <strike>' + HARGA_TOTAL_FIX + '</td> </strike>' +
                                '<td>' +
                                '<a href="javascript:;" class="btn btn-info btn-xs item_batal_coret block" data="' + data[i].ID_SPP_FORM + '"><i class="fa fa-check"></i> Batal Tolak</a>' + ' ' + data[i].CATATAN_CORET +
                                '</td>' +
                                '<td>' +
                                '<a href="javascript:;" class="btn btn-success btn-xs item_edit_keterangan block" data="' + data[i].ID_SPP_FORM + '"><i class="fa fa-comment  "></i> Keterangan </a>' + ' ' +
                                '</td>' +

                                '</tr>';
                        } else {
                            html += '<tr>' +
                                '<td>' + kode_barang_cetak + '</td>' +
                                '<td>' + data[i].NAMA_BARANG + '</td>' +
                                '<td>' + data[i].MEREK + '</td>' +
                                '<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
                                '<td>' + data[i].PERALATAN_PERLENGKAPAN + '</td>' +
                                '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                                '<td>' + jumlah_barang + ' ' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                                '<td>' + data[i].TANGGAL_MULAI_PAKAI + '</td>' +
                                '<td>' + data[i].NAMA_VENDOR + '</td>' +
                                '<td>' + data[i].HARGA_SATUAN_BARANG_FIX + '</td>' +
                                '<td>' + HARGA_TOTAL_FIX + '</td>' +
                                '<td>' +
                                '<a href="javascript:;" class="btn btn-danger btn-xs item_coret block" data="' + data[i].ID_SPP_FORM + '"><i class="fa fa-ban"></i> Tolak</a>' + ' ' + data[i].CATATAN_BATAL_CORET +
                                '</td>' +
                                '<td>' +
                                '<a href="javascript:;" class="btn btn-success btn-xs item_edit_keterangan block" data="' + data[i].ID_SPP_FORM + '"><i class="fa fa-comment  "></i> Keterangan </a>' + ' ' +
                                '</td>' +

                                '</tr>';
                        }
                    }
                    $('#show_data').html(html);
                }
            });
        }

        //GET UPDATE untuk edit jumlah
        $("#HARGA_SATUAN_BARANG_FIX2").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
            var JUMLAH = $("#JUMLAH_BARANG2").val();
            var TOTAL = HARGA * JUMLAH;

            $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEdit').modal('show');
                        $('[name="ID_SPP_FORM2"]').val(data.ID_SPP_FORM);
                        $('[name="LOKASI_PENYERAHAN"]').val(data.LOKASI_PENYERAHAN);
                        $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                        $('[name="NAMA2"]').val(data.NAMA_BARANG);
                        $('[name="MEREK2"]').val(data.MEREK);
                        $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_BARANG);
                        $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="SATUAN_BARANG2"]').val(data.ID_SATUAN_BARANG);
                        $('[name="JENIS_BARANG2"]').val(data.ID_JENIS_BARANG);
                        $('[name="ID_VENDOR2"]').val(data.ID_VENDOR);
                        $('[name="HARGA_SATUAN_BARANG_FIX2"]').val(data.HARGA_SATUAN_BARANG_FIX);
                        $('[name="HARGA_TOTAL_FIX2"]').val(data.HARGA_TOTAL_FIX);
                        $('[name="TANGGAL_MULAI_PAKAI2"]').val(data.TANGGAL_MULAI_PAKAI);
                    });
                }
            });
            return false;
        });

        //UPDATE JUSTIFIKASI BARANG 
        $('#btn_update_keterangan_barang').on('click', function() {

            var ID_SPP_FORM = $('#ID_SPP_FORM5').val();
            var KETERANGAN = $('#KETERANGAN5').val();
            $.ajax({
                url: "<?php echo site_url('SPP_form/update_data_keterangan_barang') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPP_FORM: ID_SPP_FORM,
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
                ID_SPP: ID_SPP,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
                ID_VENDOR: $('#ID_VENDOR_4').val(),
                NAMA_VENDOR: $('#NAMA_VENDOR_4').val(),
                ALAMAT_VENDOR: $('#ALAMAT_VENDOR_4').val(),
                NO_TELP_VENDOR: $('#NO_TELP_VENDOR_4').val(),
                HARGA_SATUAN_BARANG_FIX: $('#HARGA_SATUAN_BARANG_FIX_4').val(),
                HARGA_TOTAL_FIX: $('#HARGA_TOTAL_FIX_4').val(),
                TANGGAL_MULAI_PAKAI: $('#TANGGAL_MULAI_PAKAI_4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('SPP_form/simpan_data_di_luar_barang_master'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg1').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $('#ModalAdd').modal('hide');
                        window.location.reload();
                    }
                }
            });
            return false;
        });

        //SIMPAN PERUBAHAN DAN LIHAT PDF
        $('#btn_simpan_perubahan_pdf').click(function() {
            var form_data = {
                ID_SPP: ID_SPP,
                LOKASI_PENYERAHAN: $('#LOKASI_PENYERAHAN').val(),
                ID_VENDOR_FIX: $('#ID_VENDOR_FIX').val(),
                TOP: $('#TOP').val()
            };
            $.ajax({
                url: "<?php echo site_url('SPP_form/simpan_perubahan_pdf'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 'true') {
                        $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var HASH_MD5_SPP = $('#HASH_MD5_SPP').val()
                        var alamat = "<?php echo base_url('SPP_form/view/'); ?>" + HASH_MD5_SPP;
                        window.open(
                            alamat,
                            '_self' // <- This is what makes it open in a new window.
                        );
                    }
                }
            });
            return false;
        });

        //GET UDPATE untuk berikan justifkasi
        $('#show_data').on('click', '.item_edit_keterangan', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditKeteranganBarang').modal('show');
                        $('[name="ID_SPP_FORM5"]').val(data.ID_SPP_FORM);
                        $('[name="KODE_BARANG5"]').val(data.KODE_BARANG);
                        $('[name="NAMA5"]').val(data.NAMA_BARANG);
                        $('[name="MEREK5"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT5"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG5"]').val(data.JUMLAH_BARANG);
                        $('[name="HARGA_SATUAN_BARANG_FIX5"]').val(data.HARGA_SATUAN_BARANG_FIX);
                        $('[name="HARGA_TOTAL_FIX5"]').val(data.HARGA_TOTAL_FIX);
                        $('[name="KETERANGAN5"]').val(data.KETERANGAN_M_MARKETING);
                        $('#alert-msg-5').html('<div></div>');
                    });
                }
            });
            return false;
        });

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            let ID_SPP_FORM = $('#ID_SPP_FORM2').val();
            let MEREK = $('#MEREK2').val();
            let SPESIFIKASI_SINGKAT = $('#SPESIFIKASI_SINGKAT2').val();

            let JENIS_BARANG = $('#JENIS_BARANG2').val();
            let SATUAN_BARANG = $('#SATUAN_BARANG2').val();

            let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
            let NAMA = $('#NAMA2').val();
            let ID_VENDOR = $('#ID_VENDOR2').val();
            let NAMA_VENDOR = $('#NAMA_VENDOR2').val();
            let ALAMAT_VENDOR = $('#ALAMAT_VENDOR2').val();
            let NO_TELP_VENDOR = $('#NO_TELP_VENDOR2').val();
            let HARGA_SATUAN_BARANG_FIX = $('#HARGA_SATUAN_BARANG_FIX2').val();
            let HARGA_TOTAL_FIX = $('#HARGA_TOTAL_FIX2').val();
            let TANGGAL_MULAI_PAKAI = $('#TANGGAL_MULAI_PAKAI2').val();

            $.ajax({
                url: "<?php echo site_url('SPP_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPP: ID_SPP,
                    ID_SPP_FORM: ID_SPP_FORM,
                    NAMA: NAMA,
                    MEREK: MEREK,
                    SPESIFIKASI_SINGKAT: SPESIFIKASI_SINGKAT,
                    JUMLAH_BARANG: JUMLAH_BARANG,
                    JENIS_BARANG: JENIS_BARANG,
                    SATUAN_BARANG: SATUAN_BARANG,
                    ID_VENDOR: ID_VENDOR,
                    NAMA_VENDOR: NAMA_VENDOR,
                    ALAMAT_VENDOR: ALAMAT_VENDOR,
                    NO_TELP_VENDOR: NO_TELP_VENDOR,
                    HARGA_SATUAN_BARANG_FIX: HARGA_SATUAN_BARANG_FIX,
                    HARGA_TOTAL_FIX: HARGA_TOTAL_FIX,
                    TANGGAL_MULAI_PAKAI: TANGGAL_MULAI_PAKAI
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEdit').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //GET CORET
        $('#show_data').on('click', '.item_coret', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalCoret').modal('show');
                        $('[name="kode"]').val(id);
                        $('#NAMA_3').html('</br>Nama Barang : ' + data.NAMA_BARANG);

                    });
                }
            });
        });

        //GET BATAL
        $('#show_data').on('click', '.item_batal_coret', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalBatalCoret').modal('show');
                        $('[name="kode"]').val(id);
                        $('#NAMA_4').html('</br>Nama Barang : ' + data.NAMA_BARANG);

                    });
                }
            });
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/get_data') ?>",
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

        //CORET DATA
        $('#btn_coret').on('click', function() {
            var form_data = {
                kode: $('#textkode').val(),
                CATATAN_CORET: $('#CATATAN_CORET').val()
            };

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('SPP_form/update_data_coret') ?>",
                dataType: "JSON",
                data: form_data,
                success: function(data) {
                    if (data == true) {
                        $('#ModalCoret').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-8').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //BATAL CORET DATA
        $('#btn_terima').on('click', function() {
            var form_data = {
                kode: $('#textkode').val(),
                CATATAN_BATAL_CORET: $('#CATATAN_BATAL_CORET').val()
            };

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('SPP_form/update_data_batal_coret') ?>",
                dataType: "JSON",
                data: form_data,
                success: function(data) {
                    if (data == true) {
                        $('#ModalBatalCoret').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-4').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('SPP_form/hapus_data') ?>",
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

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_spp').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_spp').attr('disabled', true); //disable input
            }
        });

        //UPDATE CATATAN SPP 
        $('#btn_update_catatan_spp').on('click', function() {

            let ID_SPP = $('#ID_SPP6').val();
            let CTT_M_MARKETING = $('#CTT_M_MARKETING6').val();
            $.ajax({
                url: "<?php echo site_url('SPP_form/update_data_catatan_spp') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPP: ID_SPP,
                    CTT_M_MARKETING: CTT_M_MARKETING
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditCatatanSPP').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //UPDATE KIRIM SPP 
        $('#btn_update_kirim_spp').on('click', function() {

            let ID_SPP = $('#ID_SPP7').val();
            $.ajax({
                url: "<?php echo site_url('SPP_form/update_data_kirim_spp') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPP: ID_SPP,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimSPP').modal('hide');
                        window.location.href = '<?php echo site_url('SPP') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        item_edit_catatan_spp.onclick = function() {
            var HASH_MD5_SPP = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/get_data_ctt_spp') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_SPP: HASH_MD5_SPP
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditCatatanSPP').modal('show');
                        $('[name="ID_SPP6"]').val(data.ID_SPP);
                        $('[name="CTT_M_MARKETING6"]').val(data.CTT_M_MARKETING);

                        $('#alert-msg-6').html('<div></div>');
                    });
                }
            });
            return false;
        };

        item_edit_kirim_spp.onclick = function() {
            var HASH_MD5_SPP = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/get_data_catatan_spp') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_SPP: HASH_MD5_SPP
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditKirimSPP').modal('show');
                        $('[name="ID_SPP7"]').val(data.ID_SPP);

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