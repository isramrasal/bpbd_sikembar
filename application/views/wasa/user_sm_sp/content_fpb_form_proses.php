<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Ubah FPB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/FPB/') ?>">FPB</a>
            </li>
            <li class="active">
                <strong>
                    <a>Ubah FPB</a>
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

    <!-- Identitas Form FPB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian Item Barang/Jasa FPB</h5>
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

                    <li class=""><a data-toggle="tab" href="#tab-2">Catatan FPB</a></li>

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
                                        <div class="form-group"><label class="col-sm-2 control-label">No Urut</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $FPB->NO_URUT_FPB; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pembuatan </label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $FPB->TANGGAL_DOKUMEN_FPB; ?>" disabled>
                                                *tanggal pengajuan akan berubah sesuai dengan tanggal aktual pengajuan FPB
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">User Peminta </label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $FPB->NAMA; ?> - <?php echo $FPB->NAMA_JABATAN; ?>" disabled>
                                            </div>
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
                                            <span>Catatan Peminta</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_FPB['CTT_PEMINTA']; ?>
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Staff Gudang Logistik</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_FPB['CTT_STAFF_GUDANG_LOGISTIK']; ?>
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Chief</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_FPB['CTT_CHIEF']; ?>
                                </div>
                            </div>
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan SM</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_FPB['CTT_SM']; ?>
                                </div>
                            </div>
                            </br>
                            <div class="hr-line-dashed"></div>

                            <a href="javascript:;" id="item_edit_catatan_fpb" name="item_edit_catatan_fpb" class="btn btn-warning" data="<?php echo $ID_FPB; ?>"><i class="fa fa-comment"></i> Berikan Catatan FPB </a>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <!-- End Identitas Form FPB -->

    <!-- Form FPB -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>FPB Item Barang/Jasa</h5>
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

                    <!-- konten tanggal apply for all -->
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="control-label col-xs-2">Tanggal Mulai Pemakaian</label>
                            <div class="col-xs-2">
                                <input name="TANGGAL_MULAI_PAKAI3" id="TANGGAL_MULAI_PAKAI3" class="form-control" type="date">
                            </div>
                        </div>

                        <input name="HASH_MD5_FPB3" id="HASH_MD5_FPB3" class="form-control" value="<?php echo $HASH_MD5_FPB; ?>" type="hidden" readonly>

                        <div class="form-group">
                            <label class="control-label col-xs-2">Tanggal Selesai Pemakaian</label>
                            <div class="col-xs-2">
                                <input name="TANGGAL_SELESAI_PAKAI3" id="TANGGAL_SELESAI_PAKAI3" class="form-control" type="date">
                            </div>
                        </div>

                        <div class="form-group"><label class="control-label col-xs-2">Bidang Pemakai</label>
                            <div class="col-xs-2">
                                <select name="BIDANG_PEMAKAI3" class="form-control" id="BIDANG_PEMAKAI3">
                                    <option value=''>- Pilih -</option>
                                    <option value="Elektrikal">Elektrikal</option>
                                    <option value="Mekanikal">Mekanikal</option>
                                    <option value="Piping">Piping</option>
                                    <option value="Konstruksi">Konstruksi</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        <div id="alert-msg-8"></div>
                        <button class="btn btn-primary" id="btn_simpan_tanggal"><i class="fa fa-save"></i> Simpan Untuk Semua Item Barang/Jasa</button><br>

                    </div>
                    <div class="hr-line-dashed"></div>
                    <!-- END OF konten tanggal apply for all -->

                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddDariRasdBarang"><span class="fa fa-plus"></span> Tambah Item dari RASD</a><br>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Tambah Item dari Master List</a><br>
                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#ModalAddNew"><span class="fa fa-plus"></span> Tambah Item Baru</a>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <th>Kode Master</th>
                                    <th>Nama Barang</th>
                                    <th>Merek Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Tool/</br>Consumable/</br>Material</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Satuan Barang</th>
                                    <th>Jumlah Yang Diminta</th>
                                    <th>Tanggal Mulai Pemakaian</th>
                                    <th>Tanggal Selesai Pemakaian</th>
                                    <th>Pilihan</th>
                                    <th>Remarks</th>
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
                            <a href="<?php echo base_url('index.php/FPB_form/view/'); ?><?php echo $HASH_MD5_FPB; ?>" class="btn btn-primary"><span class="fa fa-save"></span> Simpan Perubahan & View Dokumen FPB</a>
                            </br>
                            <a href="javascript:;" id="item_edit_kirim_fpb" name="item_edit_kirim_fpb" class="btn btn-warning" data="<?php echo $ID_FPB; ?>"><span class="fa fa-send"></span> Ajukan FPB</a><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Form FPB -->
</div>

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

                            <form method="POST" action="<?php echo site_url('FPB_form/simpan_data_dari_rasd_form'); ?>" id="formTambahRASD">
                                <table class="table table-striped table-bordered table-hover" id="modalrasd">
                                    <thead>
                                        <tr>
                                            <th>Pilih<input type="checkbox" id="checkAllrasd"></th>
                                            <th>Kode Barang</th>
                                            <th>RASD Qty</th>
                                            <th>Nama Barang</th>
                                            <th>Merek Barang</th>
                                            <th>Jenis Barang</th>
                                            <th>Tool/</br>Consumable/</br>Material</th>
                                            <th style="width: 30%;">Spesifikasi Singkat</th>
                                            <th>Satuan Barang</th>
                                            <th>Jumlah Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody">
                                        <?php
                                        foreach ($rasd_barang_list as $data) : ?>
                                            <tr>

                                                <td>
                                                    <input name="ID_FPB" class="form-control" type="text" value="<?php echo $ID_FPB  ?>" style="display: none;" readonly>
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
                                                <td> <?php echo $data->PERALATAN_PERLENGKAPAN; ?> </td>
                                                <td> <?php echo $data->SPESIFIKASI_SINGKAT; ?> </td>
                                                <td> <?php echo $data->NAMA_SATUAN_BARANG; ?> </td>
                                                <td style="width: 20%;">
                                                    <input type="number" value="0" min="0" name="<?php echo $data->ID_RASD_FORM ?>">
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

<!-- MODAL ADD FROM MASTER -->
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
                    <small class="font-bold">Silakan isi data FPB berdasarkan daftar Master List</small>

                </div>

                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="alert alert-info alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Daftar Master List berikut adalah daftar barang yang tidak termasuk dalam RASD proyek
                        </div>
                        <div class="table-responsive">

                            <form method="POST" action="<?php echo site_url('FPB_form/simpan_data_dari_barang_master'); ?>" id="formTambahMASTER">
                                <table class="table table-striped table-bordered table-hover" id="modalmaster">
                                    <thead>
                                        <tr>
                                            <th>Pilih<input type="checkbox" id="checkAllbarangmaster"></th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Merek Barang</th>
                                            <th>Jenis Barang</th>
                                            <th>Tool/</br>Consumable/</br>Material</th>
                                            <th style="width: 30%;">Spesifikasi Singkat</th>
                                            <th>Satuan Barang</th>
                                            <th>Jumlah Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($barang_master_list as $data) : ?>
                                            <tr>
                                                <td>
                                                    <input name="ID_FPB" class="form-control" type="text" value="<?php echo $ID_FPB  ?>" style="display: none;" readonly>
                                                    <input class="checkbox" name="ID_BARANG_MASTER[]" value="<?php echo $data->ID_BARANG_MASTER ?>" type="checkbox">
                                                </td>
                                                <td><a href="<?php echo base_url() ?>barang_master/profil_barang_master/<?php echo $data->HASH_MD5_BARANG_MASTER; ?>" class="btn btn-warning btn-xs btn-outline block" target="_blank"><i class="fa fa-eye"></i> <?php echo $data->KODE_BARANG; ?> </a>
                                                </td>
                                                <td> <?php echo $data->NAMA; ?> </td>
                                                <td> <?php echo $data->MEREK; ?> </td>
                                                <td> <?php echo $data->NAMA_JENIS_BARANG; ?> </td>
                                                <td> <?php echo $data->PERALATAN_PERLENGKAPAN; ?> </td>
                                                <td> <?php echo $data->SPESIFIKASI_SINGKAT; ?> </td>
                                                <td> <?php echo $data->NAMA_SATUAN_BARANG; ?> </td>
                                                <td style="width: 20%;">
                                                    <input type="number" value="0" min="0" name="<?php echo $data->ID_BARANG_MASTER ?>">
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

<!-- MODAL ADD DI LUAR BARANG MASTER-->
<div class="modal inmodal fade" id="ModalAddNew" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Ajukan Item Barang/Jasa Di Luar RASD dan Master List</h4>
                <small class="font-bold">Silakan isi data Item Barang/Jasa FPB yang Baru</small>
            </div>
            <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
            echo form_open("FPB_form/simpan_data_di_luar_barang_master", $attributes); ?>
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
                            <input class="form-control" type="number" value="0" name="JUMLAH_BARANG_4" id="JUMLAH_BARANG_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Tanggal Mulai Pemakaian</label>
                        <div class="col-xs-9">
                            <input name="TANGGAL_MULAI_PAKAI_4" id="TANGGAL_MULAI_PAKAI_4" class="form-control" type="date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Tanggal Selesai Pemakaian</label>
                        <div class="col-xs-9">
                            <input name="TANGGAL_SELESAI_PAKAI_4" id="TANGGAL_SELESAI_PAKAI_4" class="form-control" type="date">
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
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Ubah Item Barang/Jasa FPB</h4>
                <small class="font-bold">Silakan edit item barang/jasa FPB</small>
            </div>
            <?php $attributes = array("ID_FPB_barang2" => "contact_form", "id" => "contact_form");
            echo form_open("FPB_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_FPB_FORM2" id="ID_FPB_FORM2" class="form-control" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Kode Barang</label>
                        <div class="col-xs-9">
                            <input name="KODE_BARANG2" id="KODE_BARANG2" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA2" id="NAMA2" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek</label>
                        <div class="col-xs-9">
                            <input name="MEREK2" id="MEREK2" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" readonly>
                        </div>
                    </div>

                    <div class="form-group"><label class="control-label col-xs-3">Tool/Consumable/<br>Material</label>
                        <div class="col-xs-9">
                            <select name="PERALATAN_PERLENGKAPAN2" class="form-control" id="PERALATAN_PERLENGKAPAN2">
                                <option value=''>- Pilih -</option>
                                <option value="TOOL">TOOL</option>
                                <option value="CONSUMABLE">CONSUMABLE</option>
                                <option value="MATERIAL">MATERIAL</option>
                                <option value="JASA/RENTAL">JASA/RENTAL</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT2" id="SPESIFIKASI_SINGKAT2" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG2" id="JUMLAH_BARANG2" class="form-control" type="number">
                        </div>
                    </div>

                    <div class="form-group"><label class="control-label col-xs-3">Bidang Pemakai</label>
                        <div class="col-xs-9">
                            <select name="BIDANG_PEMAKAI2" class="form-control" id="BIDANG_PEMAKAI2">
                                <option value=''>- Pilih -</option>
                                <option value="Elektrikal">Elektrikal</option>
                                <option value="Mekanikal">Mekanikal</option>
                                <option value="Piping">Piping</option>
                                <option value="Konstruksi">Konstruksi</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Tanggal Mulai Pemakaian</label>
                        <div class="col-xs-9">
                            <input name="TANGGAL_MULAI_PAKAI2" id="TANGGAL_MULAI_PAKAI2" class="form-control" type="date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Tanggal Selesai Pemakaian</label>
                        <div class="col-xs-9">
                            <input name="TANGGAL_SELESAI_PAKAI2" id="TANGGAL_SELESAI_PAKAI2" class="form-control" type="date">
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

<!-- MODAL EDIT REMARKS BARANG-->
<div class="modal inmodal fade" id="ModalEditRemarksBarang" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Remarks Item Barang/Jasa</h4>
                <small class="font-bold">Silakan berikan Remarks atas item barang/jasa</small>
            </div>
            <?php $attributes = array("ID_FPB_barang5" => "contact_form", "id" => "contact_form");
            echo form_open("FPB_form/update_data_remarks_barang", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_FPB_FORM5" id="ID_FPB_FORM5" class="form-control" type="hidden" readonly>

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
                        <label class="control-label col-xs-3">Remarks Item Barang</label>
                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="REMARKS_SM5" id="REMARKS_SM5" placeholder="Contoh: " required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-5"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_remarks_barang"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT REMARKS BARANG-->

<!-- MODAL EDIT CATATAN FPB-->
<div class="modal inmodal fade" id="ModalEditCatatanFPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Catatan FPB</h4>
                <small class="font-bold">Silakan berikan komentar atau catatan mengenai Form FPB ini</small>
            </div>
            <?php $attributes = array("ID_FPB6" => "contact_form", "id" => "contact_form");
            echo form_open("FPB_form/update_data_catatan_fpb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_FPB6" id="ID_FPB6" class="form-control" type="hidden" placeholder="ID FPB" readonly>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Catatan FPB</label>

                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="CTT_PEMINTA6" id="CTT_PEMINTA6" required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-6"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_catatan_fpb"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT CATATAN FPB-->

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

                    <div id="show_hidden_belum_atur_peralatan_perlengkapan" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang yang belum diatur Tool/Consumable/Material</center>
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

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa FPB</h4>
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
        let ID_FPB = <?php echo $ID_FPB  ?>;

        $("#checkAllbarangmaster").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#checkAllrasd").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        tampil_data_fpb_form(); //pemanggilan fungsi tampil data.

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
                    title: 'FPB'
                },
                {
                    extend: 'pdf',
                    title: 'FPB'
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
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            order: [
                [2, "asc"]
            ]
        });
        $('#modalrasd').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            order: [
                [2, "asc"]
            ]
        });

        //fungsi tampil data
        function tampil_data_fpb_form() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>FPB_form/data_fpb_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_FPB
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_MINTA;
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
                        html += '<tr>' +
                            '<td>' + kode_barang_cetak + '</td>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
                            '<td>' + data[i].PERALATAN_PERLENGKAPAN + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                            '<td>' + jumlah_barang + '</td>' +
                            '<td>' +
                            '<span class="edit" >' + data[i].TANGGAL_MULAI_PAKAI + '</span>' +
                            '<input type="date" class="txtedit" data-id="' + data[i].ID_FPB_FORM + '" data-field="TANGGAL_MULAI_PAKAI" id="tanggaltxt_' + data[i].ID_FPB_FORM + '" value="' + data[i].TANGGAL_MULAI_PAKAI + '" >' + '</td>' +
                            '<td>' +
                            '<span class="edit" >' + data[i].TANGGAL_SELESAI_PAKAI + '</span>' +
                            '<input type="date" class="txtedit" data-id="' + data[i].ID_FPB_FORM + '" data-field="TANGGAL_SELESAI_PAKAI" id="tanggaltxt_' + data[i].ID_FPB_FORM + '" value="' + data[i].TANGGAL_SELESAI_PAKAI + '" >' + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_FPB_FORM + '"><i class="fa fa-pencil"></i> Ubah </a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_FPB_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' + '<br> Bidang Pemakai: ' + data[i].BIDANG_PEMAKAI +
                            '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-success btn-xs item_edit_remarks block" data="' + data[i].ID_FPB_FORM + '"><i class="fa fa-comment  "></i> Remarks </a>' + ' ' + data[i].REMARKS_CHIEF + ' ' + data[i].REMARKS_STAFF_GUDANG_LOGISTIK + ' ' + data[i].REMARKS_SM + ' ' + data[i].REMARKS_STAFF_UMUM_LOGISTIK +
                            '</td>' +

                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        // SIMPAN FPB DAN KEMBALI KE FPB LIST // BELUM CEK
        $('#btn_simpan_fpb').on('click', function() {
            let ID_FPB = ID_FPB;
            let CTT = $('#CTT').val();

        })

        //GET UPDATE untuk edit jumlah
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FPB_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEdit').modal('show');
                        $('[name="ID_FPB_FORM2"]').val(data.ID_FPB_FORM);
                        $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                        $('[name="NAMA2"]').val(data.NAMA_BARANG);
                        $('[name="MEREK2"]').val(data.MEREK);
                        $('[name="PERALATAN_PERLENGKAPAN2"]').val(data.PERALATAN_PERLENGKAPAN);
                        $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_MINTA);
                        $('[name="BIDANG_PEMAKAI2"]').val(data.BIDANG_PEMAKAI);
                        $('[name="TANGGAL_MULAI_PAKAI2"]').val(data.TANGGAL_MULAI_PAKAI);
                        $('[name="TANGGAL_SELESAI_PAKAI2"]').val(data.TANGGAL_SELESAI_PAKAI);
                        $('#alert-msg-2').html('<div></div>');
                    });
                }
            });
            return false;
        });

        //GET UDPATE untuk berikan justifkasi
        $('#show_data').on('click', '.item_edit_remarks', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FPB_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditRemarksBarang').modal('show');
                        $('[name="ID_FPB_FORM5"]').val(data.ID_FPB_FORM);
                        $('[name="KODE_BARANG5"]').val(data.KODE_BARANG);
                        $('[name="NAMA5"]').val(data.NAMA_BARANG);
                        $('[name="MEREK5"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT5"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG5"]').val(data.JUMLAH_MINTA);
                        $('[name="REMARKS_SM5"]').val(data.REMARKS_SM);
                        $('#alert-msg-5').html('<div></div>');
                    });
                }
            });
            return false;
        });

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
                url: "<?php echo base_url('FPB_form/update_data_tanggal') ?>",
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



        item_edit_catatan_fpb.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FPB_form/get_data_catatan_fpb') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditCatatanFPB').modal('show');
                        $('[name="ID_FPB6"]').val(data.ID_FPB);
                        $('[name="CTT_PEMINTA6"]').val(data.CTT_PEMINTA);

                        $('#alert-msg-6').html('<div></div>');
                    });
                }
            });
            return false;
        };

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
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);
                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

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

                            if (data[i].PERALATAN_PERLENGKAPAN == "" || data[i].PERALATAN_PERLENGKAPAN == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_peralatan_perlengkapan').attr("hidden", false);
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

                $('#btn_update_kirim_fpb').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_fpb').attr('disabled', true); //disable input
            }
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FPB_form/get_data') ?>",
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
        $('#btn_simpan_data_di_luar_barang_master').click(function() {
            var form_data = {
                ID_FPB: ID_FPB,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                PERALATAN_PERLENGKAPAN: $('#PERALATAN_PERLENGKAPAN_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
                TANGGAL_MULAI_PAKAI: $('#TANGGAL_MULAI_PAKAI_4').val(),
                TANGGAL_SELESAI_PAKAI: $('#TANGGAL_SELESAI_PAKAI_4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('FPB_form/simpan_data_di_luar_barang_master'); ?>",
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

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            let ID_FPB_FORM = $('#ID_FPB_FORM2').val();
            let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
            let PERALATAN_PERLENGKAPAN = $('#PERALATAN_PERLENGKAPAN2').val();
            let BIDANG_PEMAKAI = $('#BIDANG_PEMAKAI2').val();
            let TANGGAL_MULAI_PAKAI = $('#TANGGAL_MULAI_PAKAI2').val();
            let TANGGAL_SELESAI_PAKAI = $('#TANGGAL_SELESAI_PAKAI2').val();
            $.ajax({
                url: "<?php echo site_url('FPB_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FPB_FORM: ID_FPB_FORM,
                    JUMLAH_BARANG: JUMLAH_BARANG,
                    PERALATAN_PERLENGKAPAN: PERALATAN_PERLENGKAPAN,
                    BIDANG_PEMAKAI: BIDANG_PEMAKAI,
                    TANGGAL_MULAI_PAKAI: TANGGAL_MULAI_PAKAI,
                    TANGGAL_SELESAI_PAKAI: TANGGAL_SELESAI_PAKAI
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

        //UPDATE REMARKS BARANG 
        $('#btn_update_remarks_barang').on('click', function() {

            let ID_FPB_FORM = $('#ID_FPB_FORM5').val();
            let REMARKS_SM = $('#REMARKS_SM5').val();
            $.ajax({
                url: "<?php echo site_url('FPB_form/update_data_remarks_barang') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FPB_FORM: ID_FPB_FORM,
                    REMARKS_SM: REMARKS_SM
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditRemarksBarang').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //UPDATE CATATAN FPB 
        $('#btn_update_catatan_fpb').on('click', function() {

            let ID_FPB = $('#ID_FPB6').val();
            let CTT_PEMINTA = $('#CTT_PEMINTA6').val();
            $.ajax({
                url: "<?php echo site_url('FPB_form/update_data_catatan_fpb') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FPB: ID_FPB,
                    CTT_PEMINTA: CTT_PEMINTA
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditCatatanFPB').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
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

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('FPB_form/hapus_data') ?>",
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

        //SIMPAN TANGGAL FOR ALL
        $('#btn_simpan_tanggal').click(function() {
            var form_data = {
                ID_FPB: ID_FPB,
                TANGGAL_MULAI_PAKAI: $('#TANGGAL_MULAI_PAKAI3').val(),
                TANGGAL_SELESAI_PAKAI: $('#TANGGAL_SELESAI_PAKAI3').val(),
                BIDANG_PEMAKAI: $('#BIDANG_PEMAKAI3').val()
            };
            $.ajax({
                url: "<?php echo site_url('FPB_form/simpan_tanggal'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 'true') {
                        $('#alert-msg-8').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var HASH_MD5_FPB = $('#HASH_MD5_FPB3').val()
                        var alamat = "<?php echo base_url('FPB_form/index/'); ?>" + HASH_MD5_FPB;
                        window.open(
                            alamat,
                            '_self' // <- This is what makes it open in a new window.
                        );
                    }
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