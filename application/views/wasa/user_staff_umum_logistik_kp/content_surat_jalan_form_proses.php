<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Ubah Surat Jalan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/Surat_Jalan/') ?>">Surat Jalan</a>
            </li>
            <li class="active">
                <strong>
                    <a>Ubah Surat Jalan</a>
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

    <!-- Identitas Form FSTB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Form Surat Jalan Barang</h5>
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

                    <li class=""><a data-toggle="tab" href="#tab-2">Catatan Surat Jalan</a></li>

                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form method="get" class="form-horizontal">
                                <?php
                                if (isset($Surat_Jalan)) {
                                    foreach ($Surat_Jalan->result() as $Surat_Jalan) :
                                ?>
                                        <hr>
                                        <div class="form-group"><label class="col-sm-2 control-label">No Surat Jalan:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $Surat_Jalan->NO_SURAT_JALAN; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pembuatan Surat Jalan :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $Surat_Jalan->TANGGAL_PENGAJUAN_SURAT_JALAN; ?>" disabled>
                                                *tanggal pengajuan akan berubah sesuai dengan tanggal aktual pengajuan Surat Jalan
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">No Urut SPPB:</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($ID_SPPB)) {
                                                ?>
                                                    <select name="NO_URUT_SPPB" class="form-control" id="NO_URUT_SPPB" disabled>
                                                        <option value=''>- Pilih Nomor SPPB -</option>
                                                        <option value='666666'>- Tanpa SPPB -</option>
                                                        <?php foreach ($sppb_list as $item) {
                                                            echo '<option value="' . $item->ID_SPPB . '">' . $item->NO_URUT_SPPB . '</option>';
                                                        } ?>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="NO_URUT_SPPB" id="NO_URUT_SPPB" disabled>
                                                        <option value=''>- Pilih Nomor SPPB -</option>
                                                        <option value='666666'>- Tanpa SPPB -</option>
                                                        <?php foreach ($SPPB as $prov) {
                                                            if ($prov->ID_SPPB == $ID_SPPB) {
                                                                echo '<option selected="selected" value="' . $prov->ID_SPPB . '">' . $prov->NO_URUT_SPPB . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->ID_SPPB . '">' . $prov->NO_URUT_SPPB . ' </option>';
                                                            }
                                                        } ?>
                                                    </select>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Kepada:</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($Surat_Jalan->KEPADA)) {
                                                ?>
                                                    <input type="text" name="KEPADA" id="KEPADA" class="form-control" placeholder="Contoh: PT. WME Kantor Pusat">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="KEPADA" id="KEPADA" class="form-control" value="<?php echo $Surat_Jalan->KEPADA; ?>" placeholder="Contoh: PT. WME Kantor Pusat">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">PIC Penerima Barang:</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($Surat_Jalan->PIC_PENERIMA_BARANG)) {
                                                ?>

                                                    <input type="text" name="PIC_PENERIMA_BARANG" id="PIC_PENERIMA_BARANG" class="form-control" placeholder="Contoh: Budi">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="PIC_PENERIMA_BARANG" id="PIC_PENERIMA_BARANG" class="form-control" value="<?php echo $Surat_Jalan->PIC_PENERIMA_BARANG; ?>" placeholder="Contoh: Budi">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">No HP PIC:</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($Surat_Jalan->NO_HP_PIC)) {
                                                ?>

                                                    <input type="text" name="NO_HP_PIC" id="NO_HP_PIC" class="form-control" placeholder="Contoh: 08123123123">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="NO_HP_PIC" id="NO_HP_PIC" class="form-control" value="<?php echo $Surat_Jalan->NO_HP_PIC; ?>" placeholder="Contoh: 08123123123">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal Surat Jalan:</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($Surat_Jalan->TANGGAL_SURAT_JALAN_HARI)) {
                                                ?>

                                                    <input name="TANGGAL_SURAT_JALAN_HARI" id="TANGGAL_SURAT_JALAN_HARI" class="form-control" type="date">
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="date" name="TANGGAL_SURAT_JALAN_HARI" id="TANGGAL_SURAT_JALAN_HARI" class="form-control" value="<?php echo $Surat_Jalan->TANGGAL_SURAT_JALAN_HARI; ?>">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <input style="width:100%" name="HASH_MD5_SURAT_JALAN" id="HASH_MD5_SURAT_JALAN" type="hidden" value="<?php echo $HASH_MD5_SURAT_JALAN; ?>">

                                        <div id="alert-msg-8"></div>

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
                                            <span>Catatan Staff Umum Logistik SP:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SURAT_JALAN['CTT_STAFF_UMUM_LOG_SP']; ?>
                                </div>
                            </div>

                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Supervisi Logistik SP:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SURAT_JALAN['CTT_SPV_LOG_SP']; ?>
                                </div>
                            </div>

                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Staff Logistik KP:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SURAT_JALAN['CTT_STAFF_LOG_KP']; ?>
                                </div>
                            </div>

                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Kasie Logistik KP:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SURAT_JALAN['CTT_KASIE_LOG_KP']; ?>
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
                                    <?php echo $CATATAN_SURAT_JALAN['CTT_MAN_LOG_KP']; ?>
                                </div>
                            </div>

                            </br>
                            <div class="hr-line-dashed"></div>
                            <a href="javascript:;" id="item_edit_catatan_surat_jalan" name="item_edit_catatan_surat_jalan" class="btn btn-warning" data="<?php echo $ID_SURAT_JALAN; ?>"><i class="fa fa-comment"></i> Berikan Catatan Surat Jalan </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Identitas Form Surat Jalan -->

    <!-- Form Surat Jalan -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Surat Jalan Item Barang/Jasa</h5>
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
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Tambah Item dari Master List </a><br>
                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#ModalAddNew"><span class="fa fa-plus"></span> Tambah Item Baru </a>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Merek</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Jenis Barang</th>
                                    <th>Tool/</br>Consumable/</br>Material</th>
                                    <th>Jumlah</th>
                                    <th>Satuan Barang</th>
                                    <th>Keterangan</th>
                                    <th>Nett Weight (Kgs)</th>
                                    <th>Gross Weight (Kgs)</th>
                                    <th>Packing Style</th>
                                    <th>Dimensi Panjang (cm)</th>
                                    <th>Dimensi Lebar (cm)</th>
                                    <th>Dimensi Tinggi (cm)</th>
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
                            <div class="ibox-title">
                                <h5>Atur Pengiriman Item Barang/Jasa</h5>
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
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover" id="mydatapengiriman">
                                        <thead>
                                            <tr>
                                                <!-- <th>Status Barang</th> -->
                                                <th>Jenis Pengiriman</th>
                                                <th>Jenis Kendaraan</th>
                                                <th>No Polisi</th>
                                                <th>Nama Pengemudi</th>
                                                <th>No HP Pengemudi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_data_pengiriman">
                                        </tbody>
                                    </table>
                                </div>
                                <a href="javascript:;" class="btn btn-info" id="item_edit_data_pengiriman" name="item_edit_data_pengiriman" data="<?php echo $ID_SURAT_JALAN; ?>"><span class="fa fa-bus"></span> Atur Pengiriman</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="sm-10">
                            <button class="btn btn-primary" id="btn_simpan_perubahan_pdf"><i class="fa fa-save"></i> Simpan Perubahan & View Dokumen Surat Jalan</button>
                            </br>
                            <a href="javascript:;" id="item_edit_kirim_surat_jalan" name="item_edit_kirim_surat_jalan" class="btn btn-warning" data="<?php echo $ID_SURAT_JALAN; ?>"><span class="fa fa-send"></span> Ajukan Surat Jalan</a><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Form Surat Jalan -->

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
                    <small class="font-bold">Silakan isi data Surat Jalan berdasarkan daftar Master List</small>

                </div>

                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="alert alert-info alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Daftar Master List berikut adalah daftar barang yang tidak termasuk dalam RASD proyek
                        </div>
                        <div class="table-responsive">

                            <form method="POST" action="<?php echo site_url('Surat_Jalan_form/simpan_data_dari_barang_master'); ?>" id="formTambahMASTER">
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
                                                    <input name="ID_SURAT_JALAN" class="form-control" type="text" value="<?php echo $ID_SURAT_JALAN  ?>" style="display: none;" readonly>
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
                    <h4 class="modal-title">Form Surat Jalan dari Master List</h4>
                    <b class="font-bold">Maaf semua barang dari master list sudah ada di Surat Jalan ini</b>
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

<!-- MODAL ADD NEW-->
<div class="modal inmodal fade" id="ModalAddNew" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Tambah Item Baru</h4>
                <small class="font-bold">Silakan isi data Item Barang/Jasa Surat Jalan yang Baru</small>
            </div>
            <?php $attributes = array("name" => "contact_form_add_new", "id" => "contact_form_add_new");
            echo form_open("Surat_Jalan_form/simpan_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA_4" id="NAMA_4" class="form-control" type="text" placeholder="Contoh : Crane" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_4" id="MEREK_4" class="form-control" type="text" placeholder="Contoh : Toyota etc" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_4" id="SPESIFIKASI_SINGKAT_4" class="form-control" type="text" placeholder="Contoh : Toyota etc" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Barang</label>
                        <div class="col-xs-9">
                            <select name="ID_JENIS_BARANG_4" class="form-control" id="ID_JENIS_BARANG_4">
                                <option value=''>- Pilih Jenis Barang -</option>
                                <?php foreach ($jenis_barang_list as $item) {
                                    echo '<option value="' . $item->ID_JENIS_BARANG . '">' . $item->NAMA_JENIS_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group"><label class="control-label col-xs-3">Tool/Consumable/<br>Material</label>
                        <div class="col-xs-9">
                            <select name="PERALATAN_PERLENGKAPAN_4" class="form-control" id="PERALATAN_PERLENGKAPAN_4">
                                <option value=''>- Pilih -</option>
                                <option value="TOOL">TOOL</option>
                                <option value="CONSUMABLE">CONSUMABLE</option>
                                <option value="MATERIAL">MATERIAL</option>
                                <option value="JASA/RENTAL">JASA/RENTAL</option>
                            </select>
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
                        <label class="control-label col-xs-3">Jumlah</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="JUMLAH_4" id="JUMLAH_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN_4" id="KETERANGAN_4" class="form-control" type="text" placeholder="Contoh : Barang diterima dengan baik" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nett Weight (Kgs)</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="NETT_WEIGHT_4" id="NETT_WEIGHT_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Gross Weight (Kgs)</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="GROSS_WEIGHT_4" id="GROSS_WEIGHT_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Packing Style</label>
                        <div class="col-xs-9">
                            <input name="PACKING_STYLE_4" id="PACKING_STYLE_4" class="form-control" type="text" placeholder="Contoh : Kardus" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Dimensi Panjang (cm)</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="DIMENSI_PANJANG_4" id="DIMENSI_PANJANG_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Dimensi Lebar (cm)</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="DIMENSI_LEBAR_4" id="DIMENSI_LEBAR_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Dimensi Tinggi (cm)</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="DIMENSI_TINGGI_4" id="DIMENSI_TINGGI_4">
                        </div>
                    </div>

                    <div id="alert-msg-4"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan_data"><i class="fa fa-save"></i> Tambah</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD NEW-->


<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Ubah Item Barang/Jasa Surat Jalan</h4>
                <small class="font-bold">Silakan edit item barang/jasa Surat Jalan</small>
            </div>
            <?php $attributes = array("name" => "contact_form_edit_new", "id" => "contact_form_edit_new");
            echo form_open("Surat_Jalan_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_SURAT_JALAN_FORM2" id="ID_SURAT_JALAN_FORM2" class="form-control" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA_2" id="NAMA_2" class="form-control" type="text" placeholder="Contoh : Crane" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_2" id="MEREK_2" class="form-control" type="text" placeholder="Contoh : Toyota etc" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_2" id="SPESIFIKASI_SINGKAT_2" class="form-control" type="text" placeholder="Contoh : Toyota etc" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Barang</label>
                        <div class="col-xs-9">
                            <select name="ID_JENIS_BARANG_2" class="form-control" id="ID_JENIS_BARANG_2">
                                <option value=''>- Pilih Jenis Barang -</option>
                                <?php foreach ($jenis_barang_list as $item) {
                                    echo '<option value="' . $item->ID_JENIS_BARANG . '">' . $item->NAMA_JENIS_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group"><label class="control-label col-xs-3">Tool/Consumable/<br>Material</label>
                        <div class="col-xs-9">
                            <select name="PERALATAN_PERLENGKAPAN_2" class="form-control" id="PERALATAN_PERLENGKAPAN_2">
                                <option value=''>- Pilih -</option>
                                <option value="TOOL">TOOL</option>
                                <option value="CONSUMABLE">CONSUMABLE</option>
                                <option value="MATERIAL">MATERIAL</option>
                                <option value="JASA/RENTAL">JASA/RENTAL</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <select name="SATUAN_BARANG_2" class="form-control" id="SATUAN_BARANG_2">
                                <option value=''>- Pilih Satuan Barang -</option>
                                <?php foreach ($satuan_barang_list as $item) {
                                    echo '<option value="' . $item->ID_SATUAN_BARANG . '">' . $item->NAMA_SATUAN_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="JUMLAH_2" id="JUMLAH_2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN_2" id="KETERANGAN_2" class="form-control" type="text" placeholder="Contoh : Barang diterima dengan baik" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nett Weight (Kgs)</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="NETT_WEIGHT_2" id="NETT_WEIGHT_2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Gross Weight (Kgs)</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="GROSS_WEIGHT_2" id="GROSS_WEIGHT_2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Packing Style</label>
                        <div class="col-xs-9">
                            <input name="PACKING_STYLE_2" id="PACKING_STYLE_2" class="form-control" type="text" placeholder="Contoh : Kardus" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Dimensi Panjang (cm)</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="DIMENSI_PANJANG_2" id="DIMENSI_PANJANG_2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Dimensi Lebar (cm)</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="DIMENSI_LEBAR_2" id="DIMENSI_LEBAR_2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Dimensi Tinggi (cm)</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="DIMENSI_TINGGI_2" id="DIMENSI_TINGGI_2">
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

<!-- MODAL EDIT CATATAN SURAT JALAN-->
<div class="modal inmodal fade" id="ModalEditCatatanSuratJalan" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Catatan Surat Jalan</h4>
                <small class="font-bold">Silakan berikan komentar atau catatan mengenai Form Surat Jalan ini</small>
            </div>
            <?php $attributes = array("id_surat_jalan" => "contact_form_edit_catatan_new", "id" => "contact_form_edit_catatan_new");
            echo form_open("Surat_Jalan_form/update_data_catatan_surat_jalan", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SURAT_JALAN6" id="ID_SURAT_JALAN6" class="form-control" type="hidden" placeholder="ID_SURAT_JALAN" readonly>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Catatan Surat Jalan</label>

                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="CTT_STAFF_LOG_KP6" id="CTT_STAFF_LOG_KP6" required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-6"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_catatan_surat_jalan"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT CATATAN SURAT JALAN-->

<!-- MODAL KIRIM SURAT JALAN-->
<div class="modal inmodal fade" id="ModalEditKirimSuratJalan" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim Surat Jalan</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form Surat Jalan ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_SURAT_JALAN7" => "contact_form", "id" => "contact_form");
            echo form_open("Surat_Jalan_form/update_data_kirim_surat_jalan", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SURAT_JALAN7" id="ID_SURAT_JALAN7" class="form-control" type="hidden" placeholder="ID_SURAT_JALAN" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form Surat Jalan ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang diminta pada Surat Jalan ini</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item jumlah barang yang bernilai 0</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_pengiriman_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada jenis pengiriman yang diminta pada Surat Jalan ini</center>
                        </div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_surat_jalan" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM SURAT JALAN-->

<!-- MODAL ATUR PENGIRIMAN-->
<div class="modal inmodal fade" id="ModalEdit_AP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Atur Pengiriman</h4>
                <small class="font-bold">Silakan isi data Pengiriman yang Baru</small>
            </div>
            <?php $attributes = array("name" => "contact_form_atur_new", "id" => "contact_form_atur_new");
            echo form_open("Surat_Jalan_form/simpan_data_pengiriman", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_SURAT_JALAN_9" id="ID_SURAT_JALAN_9" class="form-control" type="hidden" placeholder="" required autofocus>


                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Pengiriman</label>
                        <div class="col-xs-9">
                            <input name="JENIS_PENGIRIMAN_9" id="JENIS_PENGIRIMAN_9" class="form-control" type="text" placeholder="Contoh : Kurir Internal" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Kendaraan</label>
                        <div class="col-xs-9">
                            <input name="JENIS_KENDARAAN_9" id="JENIS_KENDARAAN_9" class="form-control" type="text" placeholder="Contoh : Mobil Box" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nomor Polisi</label>
                        <div class="col-xs-9">
                            <input name="NO_POLISI_9" id="NO_POLISI_9" class="form-control" type="text" placeholder="Contoh : B 1234 TF" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Pengemudi</label>
                        <div class="col-xs-9">
                            <input name="NAMA_PENGEMUDI_9" id="NAMA_PENGEMUDI_9" class="form-control" type="text" placeholder="Contoh : Luffy" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">No HP Pengemudi</label>
                        <div class="col-xs-9">
                            <input name="NO_HP_PENGEMUDI_9" id="NO_HP_PENGEMUDI_9" class="form-control" type="text" placeholder="Contoh : 0812354645" required autofocus>
                        </div>
                    </div>

                    <div id="alert-msg-9"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_ap"><i class="fa fa-save"></i> Ubah</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ATUR PENGIRIMAN-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 80vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa Surat Jalan</h4>
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
        let ID_SURAT_JALAN = <?php echo $ID_SURAT_JALAN  ?>;
        tampil_data_surat_jalan_form(); //pemanggilan fungsi tampil data.

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
                    extend: 'csv'
                },
                {
                    extend: 'excel',
                    title: 'Surat Jalan'
                },
                {
                    extend: 'pdf',
                    title: 'Surat Jalan'
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

        $('#modalmaster').dataTable({
            pageLength: 10,
            responsive: true,
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv'
                },
                {
                    extend: 'excel',
                    title: 'Surat Jalan Form'
                },
                {
                    extend: 'pdf',
                    title: 'Surat Jalan Form'
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

        tampil_data_surat_jalan_atur_pengiriman(); //pemanggilan fungsi tampil data.

        $('#mydatapengiriman').dataTable({
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
                    extend: 'csv'
                },
                {
                    extend: 'excel',
                    title: 'Surat Jalan'
                },
                {
                    extend: 'pdf',
                    title: 'Surat Jalan'
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
        function tampil_data_surat_jalan_form() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>Surat_Jalan_form/data_surat_jalan_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_SURAT_JALAN
                },

                success: function(data) {
                    var html = '';
                    var i;

                    for (i = 0; i < data.length; i++) {

                        html += '<tr>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
                            '<td>' + data[i].PERALATAN_PERLENGKAPAN + '</td>' +
                            '<td>' + data[i].JUMLAH + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                            '<td>' + data[i].KETERANGAN + '</td>' +
                            '<td>' + data[i].NETT_WEIGHT + '</td>' +
                            '<td>' + data[i].GROSS_WEIGHT + '</td>' +
                            '<td>' + data[i].PACKING_STYLE + '</td>' +
                            '<td>' + data[i].DIMENSI_PANJANG + '</td>' +
                            '<td>' + data[i].DIMENSI_LEBAR + '</td>' +
                            '<td>' + data[i].DIMENSI_TINGGI + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_SURAT_JALAN_FORM + '"><i class="fa fa-pencil"></i> Ubah </a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_SURAT_JALAN_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' +
                            '<a href="javascript:;" class="btn btn-primary btn-xs item_gambar block" data="' + data[i].ID_SURAT_JALAN_FORM + '"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i>Upload Surat Jalan</a>' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        //GET UPDATE untuk edit jumlah
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('Surat_Jalan_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEdit').modal('show');
                        $('[name="ID_SURAT_JALAN_FORM2"]').val(data.ID_SURAT_JALAN_FORM);
                        $('[name="NAMA_2"]').val(data.NAMA_BARANG);
                        $('[name="MEREK_2"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT_2"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="ID_JENIS_BARANG_2"]').val(data.ID_JENIS_BARANG);
                        $('[name="PERALATAN_PERLENGKAPAN_2"]').val(data.PERALATAN_PERLENGKAPAN);
                        $('[name="SATUAN_BARANG_2"]').val(data.ID_SATUAN_BARANG);
                        $('[name="JUMLAH_2"]').val(data.JUMLAH);
                        $('[name="KETERANGAN_2"]').val(data.KETERANGAN);
                        $('[name="NETT_WEIGHT_2"]').val(data.NETT_WEIGHT);
                        $('[name="GROSS_WEIGHT_2"]').val(data.GROSS_WEIGHT);
                        $('[name="PACKING_STYLE_2"]').val(data.PACKING_STYLE);
                        $('[name="DIMENSI_PANJANG_2"]').val(data.DIMENSI_PANJANG);
                        $('[name="DIMENSI_LEBAR_2"]').val(data.DIMENSI_LEBAR);
                        $('[name="DIMENSI_TINGGI_2"]').val(data.DIMENSI_TINGGI);
                        $('#alert-msg-2').html('<div></div>');

                    });
                }
            });
            return false;
        });

        item_edit_data_pengiriman.onclick = function() {
            var id = $(this).attr('data');

            $.ajax({
                type: "GET",
                url: "<?php echo base_url('Surat_Jalan_form/get_data_pengiriman') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEdit_AP').modal('show');
                        $('[name="ID_SURAT_JALAN_9"]').val(data.ID_SURAT_JALAN);
                        $('[name="JENIS_PENGIRIMAN_9"]').val(data.JENIS_PENGIRIMAN);
                        $('[name="JENIS_KENDARAAN_9"]').val(data.JENIS_KENDARAAN);
                        $('[name="NO_POLISI_9"]').val(data.NO_POLISI);
                        $('[name="NAMA_PENGEMUDI_9"]').val(data.NAMA_PENGEMUDI);
                        $('[name="NO_HP_PENGEMUDI_9"]').val(data.NO_HP_PENGEMUDI);

                        $('#alert-msg-9').html('<div></div>');
                    });
                }
            });
            return false;
        };

        //fungsi tampil data
        function tampil_data_surat_jalan_atur_pengiriman() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>Surat_Jalan_form/data_surat_jalan_form_pengiriman',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_SURAT_JALAN
                },

                success: function(data) {
                    var html = '';
                    var i;

                    for (i = 0; i < data.length; i++) {

                        html += '<tr>' +
                            '<td>' + data[i].JENIS_PENGIRIMAN + '</td>' +
                            '<td>' + data[i].JENIS_KENDARAAN + '</td>' +
                            '<td>' + data[i].NO_POLISI + '</td>' +
                            '<td>' + data[i].NAMA_PENGEMUDI + '</td>' +
                            '<td>' + data[i].NO_HP_PENGEMUDI + '</td>' +
                            '</tr>';
                    }
                    $('#show_data_pengiriman').html(html);
                }
            });
        }

        $('.edit').click(function() {
            // Hide input element
            $('.txtedit').hide();

            // Show next input element
            $(this).next('.txtedit').show().focus();

            // Hide clicked element
            $(this).hide();
        });

        // Focus out from a textbox
        $('.txtedit').focusout(function() {
            // Get edit id, field name and value
            var edit_id = $(this).data('id');
            var fieldname = $(this).data('field');
            var value = $(this).val();

            // assign instance to element variable
            var element = this;

            // Send AJAX request
            $.ajax({
                url: "<?php echo base_url('Surat_Jalan_form/update_data_tanggal') ?>",
                type: 'POST',
                data: {
                    field: fieldname,
                    value: value,
                    id: edit_id
                },
                success: function(response) {
                    // Hide Input element
                    $(element).hide();

                    // Update viewing value and display it
                    $(element).prev('.edit').show();
                    $(element).prev('.edit').text(value);
                }
            });
        });


        item_edit_catatan_surat_jalan.onclick = function() {

            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('Surat_Jalan_form/get_data_catatan_surat_jalan') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditCatatanSuratJalan').modal('show');
                        $('[name="ID_SURAT_JALAN6"]').val(data.ID_SURAT_JALAN);
                        $('[name="CTT_STAFF_LOG_KP6"]').val(data.CTT_STAFF_LOG_KP);

                        $('#alert-msg-6').html('<div></div>');
                    });
                }
            });
            return false;
        };

        item_edit_kirim_surat_jalan.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('Surat_Jalan_form/data_surat_jalan_form') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#ModalEditKirimSuratJalan').modal('show');
                    $.each(data, function() {
                        $('[name="ID_SURAT_JALAN7"]').val(data[0].ID_SURAT_JALAN)
                    });

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);
                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        let i = 0;
                        for (i = 0; i < data.length; i++) {

                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_jumlah_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].JENIS_PENGIRIMAN == "" || data[i].JENIS_PENGIRIMAN == null || data[i].JENIS_PENGIRIMAN == "" || data[i].JENIS_PENGIRIMAN == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_pengiriman_barang').attr("hidden", false);
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

                $('#btn_update_kirim_surat_jalan').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_surat_jalan').attr('disabled', true); //disable input
            }
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('Surat_Jalan_form/get_data') ?>",
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

        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999,
        });

        //SIMPAN DATA
        $('#btn_simpan_data').click(function() {
            var form_data = {
                ID_SURAT_JALAN: ID_SURAT_JALAN,
                NAMA_BARANG: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                ID_JENIS_BARANG: $('#ID_JENIS_BARANG_4').val(),
                PERALATAN_PERLENGKAPAN: $('#PERALATAN_PERLENGKAPAN_4').val(),
                ID_SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH: $('#JUMLAH_4').val(),
                KETERANGAN: $('#KETERANGAN_4').val(),
                NETT_WEIGHT: $('#NETT_WEIGHT_4').val(),
                GROSS_WEIGHT: $('#GROSS_WEIGHT_4').val(),
                PACKING_STYLE: $('#PACKING_STYLE_4').val(),
                DIMENSI_PANJANG: $('#DIMENSI_PANJANG_4').val(),
                DIMENSI_LEBAR: $('#DIMENSI_LEBAR_4').val(),
                DIMENSI_TINGGI: $('#DIMENSI_TINGGI_4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('Surat_Jalan_form/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg-4').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $('#ModalAddNew').modal('hide');
                        window.location.reload();
                    }
                }
            });
            return false;
        });

        //SIMPAN PERUBAHAN DAN LIHAT PDF
        $('#btn_simpan_perubahan_pdf').click(function() {
            var form_data = {
                NO_URUT_SPPB: $('#NO_URUT_SPPB').val(),
                KEPADA: $('#KEPADA').val(),
                PIC_PENERIMA_BARANG: $('#PIC_PENERIMA_BARANG').val(),
                NO_HP_PIC: $('#NO_HP_PIC').val(),
                TANGGAL_SURAT_JALAN_HARI: $('#TANGGAL_SURAT_JALAN_HARI').val(),
                HASH_MD5_SURAT_JALAN: $('#HASH_MD5_SURAT_JALAN').val()
            };
            $.ajax({
                url: "<?php echo site_url('Surat_Jalan_form/simpan_perubahan_pdf'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 'true') {
                        $('#alert-msg-8').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var HASH_MD5_SURAT_JALAN = $('#HASH_MD5_SURAT_JALAN').val()
                        var alamat = "<?php echo base_url('Surat_Jalan_form/view/'); ?>" + HASH_MD5_SURAT_JALAN;
                        window.open(
                            alamat,
                            '_blank' // <- This is what makes it open in a new window.
                        );
                    }
                }
            });
            return false;
        });

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            let ID_SURAT_JALAN_FORM = $('#ID_SURAT_JALAN_FORM2').val();
            let NAMA_BARANG = $('#NAMA_2').val();
            let MEREK = $('#MEREK_2').val();
            let SPESIFIKASI_SINGKAT = $('#SPESIFIKASI_SINGKAT_2').val();
            let ID_JENIS_BARANG = $('#ID_JENIS_BARANG_2').val();
            let PERALATAN_PERLENGKAPAN = $('#PERALATAN_PERLENGKAPAN_2').val();
            let ID_SATUAN_BARANG = $('#SATUAN_BARANG_2').val();
            let JUMLAH = $('#JUMLAH_2').val();
            let KETERANGAN = $('#KETERANGAN_2').val();
            let NETT_WEIGHT = $('#NETT_WEIGHT_2').val();
            let GROSS_WEIGHT = $('#GROSS_WEIGHT_2').val();
            let PACKING_STYLE = $('#PACKING_STYLE_2').val();
            let DIMENSI_PANJANG = $('#DIMENSI_PANJANG_2').val();
            let DIMENSI_LEBAR = $('#DIMENSI_LEBAR_2').val();
            let DIMENSI_TINGGI = $('#DIMENSI_TINGGI_2').val();

            $.ajax({
                url: "<?php echo site_url('Surat_Jalan_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SURAT_JALAN_FORM: ID_SURAT_JALAN_FORM,
                    NAMA_BARANG: NAMA_BARANG,
                    MEREK: MEREK,
                    SPESIFIKASI_SINGKAT: SPESIFIKASI_SINGKAT,
                    ID_JENIS_BARANG: ID_JENIS_BARANG,
                    PERALATAN_PERLENGKAPAN: PERALATAN_PERLENGKAPAN,
                    ID_SATUAN_BARANG: ID_SATUAN_BARANG,
                    JUMLAH: JUMLAH,
                    KETERANGAN: KETERANGAN,
                    NETT_WEIGHT: NETT_WEIGHT,
                    GROSS_WEIGHT: GROSS_WEIGHT,
                    PACKING_STYLE: PACKING_STYLE,
                    DIMENSI_PANJANG: DIMENSI_PANJANG,
                    DIMENSI_LEBAR: DIMENSI_LEBAR,
                    DIMENSI_TINGGI: DIMENSI_TINGGI
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

        //UPDATE DATA PENGIRIMAN
        $('#btn_update_ap').on('click', function() {

            let ID_SURAT_JALAN = $('#ID_SURAT_JALAN_9').val();
            let JENIS_KENDARAAN = $('#JENIS_KENDARAAN_9').val();
            let JENIS_PENGIRIMAN = $('#JENIS_PENGIRIMAN_9').val();
            let NO_POLISI = $('#NO_POLISI_9').val();
            let NAMA_PENGEMUDI = $('#NAMA_PENGEMUDI_9').val();
            let NO_HP_PENGEMUDI = $('#NO_HP_PENGEMUDI_9').val();

            $.ajax({
                url: "<?php echo site_url('Surat_Jalan_form/update_data_pengiriman') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SURAT_JALAN: ID_SURAT_JALAN,
                    JENIS_KENDARAAN: JENIS_KENDARAAN,
                    JENIS_PENGIRIMAN: JENIS_PENGIRIMAN,
                    NO_POLISI: NO_POLISI,
                    NAMA_PENGEMUDI: NAMA_PENGEMUDI,
                    NO_HP_PENGEMUDI: NO_HP_PENGEMUDI

                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEdit_AP').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-9').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //UPDATE CATATAN SURAT JALAN 
        $('#btn_update_catatan_surat_jalan').on('click', function() {

            let ID_SURAT_JALAN = $('#ID_SURAT_JALAN6').val();
            let CTT_STAFF_LOG_KP = $('#CTT_STAFF_LOG_KP6').val();
            $.ajax({
                url: "<?php echo site_url('Surat_Jalan_form/update_data_catatan_surat_jalan') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SURAT_JALAN: ID_SURAT_JALAN,
                    CTT_STAFF_LOG_KP: CTT_STAFF_LOG_KP
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditCatatanSuratJalan').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //UPDATE KIRIM SURAT JALAN 
        $('#btn_update_kirim_surat_jalan').on('click', function() {

            let ID_SURAT_JALAN = $('#ID_SURAT_JALAN7').val();
            $.ajax({
                url: "<?php echo site_url('Surat_Jalan_form/update_data_kirim_surat_jalan') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SURAT_JALAN: ID_SURAT_JALAN,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimSuratJalan').modal('hide');
                        window.location.href = '<?php echo site_url('Surat_Jalan') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
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
                url: "<?php echo base_url('Surat_Jalan_form/hapus_data') ?>",
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
    });
</script>

<style type="text/css">
    .txtedit {
        display: none;
        width: 98%;
    }
</style>

</body>

</html>