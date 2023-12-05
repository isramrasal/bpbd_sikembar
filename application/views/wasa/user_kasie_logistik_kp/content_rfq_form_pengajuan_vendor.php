<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Pengajuan Harga Dari Vendor</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/RFQ/') ?>">RFQ</a>
            </li>
            <li class="active">
                <strong>
                    <a>Pengajuan Harga Dari Vendor</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <!-- Form RFQ -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Pengajuan Harga Dari Vendor</h5>
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
                        <?php
                        if (isset($RFQ)) {
                            foreach ($RFQ->result() as $RFQ) :
                        ?>

                                <div class="form-group"><label class="col-sm-2 control-label">No Urut RFQ:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $RFQ->NO_URUT_RFQ; ?>" disabled></div>
                                </div>

                        <?php endforeach;
                        } ?>

                        <?php
                        if (isset($SPPB)) {
                            foreach ($SPPB->result() as $SPPB) :
                        ?>
                                <div class="form-group"><label class="col-sm-2 control-label">Proyek:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->NAMA_PROYEK; ?>" disabled></div>
                                </div>
                        <?php endforeach;
                        } ?>

                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi Penyerahan:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $LOKASI_PENYERAHAN; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Vendor:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_VENDOR; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Term Of Payment:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $TERM_OF_PAYMENT; ?>" disabled></div>
                        </div>
                        <div class="hr-line-dashed"></div>

                        <div class="form-group"><label class="col-sm-2 control-label">Nama PIC Vendor:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_PIC_VENDOR; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Email PIC Vendor:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $EMAIL_PIC_VENDOR; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Batas akhir pengisian RFQ:</label>
                            <div class="col-sm-10">
                                <input name="BATAS_AKHIR" id="BATAS_AKHIR" class="form-control" type="date" disabled>
                            </div>
                        </div>



                    </div>

                    <div class="form-horizontal">

                        <div class="alert alert-warning alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Berikut adalah harga yang diajukan oleh vendor.
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="mydata">
                                <thead>
                                    <tr>
                                        <!-- <th>Status Barang</th> -->

                                        <th>Nama Barang</th>
                                        <th>Merek Barang</th>
                                        <th>Spesifikasi Singkat</th>
                                        <th>Satuan Barang</th>
                                        <th>Jumlah Yang Diadakan</th>
                                        <th>Harga Satuan Barang</th>
                                        <th>Total Harga</th>
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
                            <button class="btn btn-primary" id="btn_kirim_rfq"><i class="fa fa-arrow-left"></i> Kembali ke halaman list RFQ</button>
                            </br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Form RFQ -->
    </div>

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
                        <small class="font-bold">Silakan isi data RFQ berdasarkan daftar Master List/Price List</small>

                    </div>

                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="alert alert-info alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                Daftar Master List berikut adalah daftar barang yang tidak termasuk dalam RASD proyek
                            </div>
                            <div class="table-responsive">

                                <form method="POST" action="<?php echo site_url('RFQ_form/simpan_data_dari_barang_master'); ?>" id="formTambahMASTER">
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
                                                        <input name="ID_RFQ" class="form-control" type="text" value="<?php echo $ID_RFQ  ?>" style="display: none;" readonly>
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

                                <form method="POST" action="<?php echo site_url('RFQ_form/simpan_data_dari_rasd_form'); ?>" id="formTambahRASD">
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
                                                        <input name="ID_RFQ" class="form-control" type="text" value="<?php echo $ID_RFQ  ?>" style="display: none;" readonly>
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
                    <small class="font-bold">Silakan isi data Item Barang/Jasa RFQ yang Baru</small>
                </div>
                <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
                echo form_open("RFQ_form/simpan_data_di_luar_barang_master", $attributes); ?>
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
                    <h4 class="modal-title">Ubah Item Barang/Jasa RFQ</h4>
                    <small class="font-bold">Silakan edit item barang/jasa RFQ</small>
                </div>
                <?php $attributes = array("ID_RFQ_FORM2" => "contact_form", "id" => "contact_form");
                echo form_open("RFQ_form/update_data", $attributes); ?>
                <div class="form-horizontal">
                    <div class="modal-body">


                        <input name="ID_RFQ_FORM2" id="ID_RFQ_FORM2" class="form-control" type="hidden" readonly>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Nama Barang</label>
                            <div class="col-xs-9">
                                <input name="NAMA2" id="NAMA2" class="form-control" type="text" placeholder="Contoh : Mata Gerinda 3 Inch">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Merek</label>
                            <div class="col-xs-9">
                                <input name="MEREK2" id="MEREK2" class="form-control" type="text" placeholder="Contoh : Tekiro">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                            <div class="col-xs-9">
                                <input name="SPESIFIKASI_SINGKAT2" id="SPESIFIKASI_SINGKAT2" class="form-control" type="text" placeholder="Contoh : 3 Inch">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Jumlah Barang</label>
                            <div class="col-xs-9">
                                <input name="JUMLAH_BARANG2" id="JUMLAH_BARANG2" class="form-control touchspin1" value="0" type="number">
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
                <?php $attributes = array("ID_RFQ_barang5" => "contact_form", "id" => "contact_form");
                echo form_open("RFQ_form/update_data_justifikasi_barang", $attributes); ?>
                <div class="form-horizontal">
                    <div class="modal-body">


                        <input name="ID_RFQ_FORM5" id="ID_RFQ_FORM5" class="form-control" type="hidden" readonly>

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
                                <input name="JUMLAH_BARANG5" id="JUMLAH_BARANG5" class="form-control touchspin1" value="0" type="number" readonly>
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
        <div class="modal-dialog" style="width: 60vw;">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-send modal-icon"></i>
                    <h4 class="modal-title">Lanjutkan Proses RFQ</h4>
                    <small class="font-bold">Selesaikan pengisian Form RFQ ini untuk proses selanjutnya</small>
                </div>
                <div class="form-horizontal">
                    <div class="modal-body">

                        <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT_RFQ" id="JUMLAH_COUNT_RFQ" disabled />

                        <div class="form-group">
                            <label class="col-xs-3 control-label">Nomor Urut RFQ:</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" value="" name="NO_URUT_RFQ" id="NO_URUT_RFQ" disabled />
                                <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label">Nama Vendor:</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" value="" name="NAMA_VENDOR" id="NAMA_VENDOR" disabled />
                            </div>
                        </div>

                        <hr>


                        <div class="form-group">
                            <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form RFQ ini dan menyetujui untuk diproses lebih lanjut </label></div>
                        </div>

                        <div id="alert-msg-3"></div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                        <button class="btn btn-primary" id="btn_update_kirim_rfq" disabled><i class="fa fa-send"></i> Kirim</button>
                    </div>
                </div>
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

            var ID_SPPB = <?php echo $ID_SPPB;  ?>;
            var ID_RFQ = <?php echo $ID_RFQ;  ?>;

            $(".touchspin1").TouchSpin({
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white',
                min: 0,
                max: 99999999999,
            });

            tampil_data_form_rfq(); //pemanggilan fungsi tampil data.

            $('#mydata').dataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [{
                        extend: 'copy'
                    },
                    {
                        extend: 'csv'
                    },
                    {
                        extend: 'excel',
                        title: 'RFQ Form'
                    },
                    {
                        extend: 'pdf',
                        title: 'RFQ Form'
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
                        console.log(data);
                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            let jumlah_barang = data[i].JUMLAH_BARANG;
                            let jumlah_rasd = data[i].JUMLAH_RASD;
                            let kode_barang = data[i].KODE_BARANG;


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
                                '<td>' + data[i].NAMA_BARANG + '</td>' +
                                '<td>' + data[i].MEREK + '</td>' +
                                '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                                '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                                '<td>' + jumlah_barang + '</td>' +
                                '<td> Rp ' + data[i].HARGA_SATUAN_BARANG + '</td>' +
                                '<td> Rp ' + data[i].HARGA_TOTAL + '</td>' +
                                '<td>' + data[i].KETERANGAN + '</td>' +

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
                    url: "<?php echo base_url('RFQ_form/get_data') ?>",
                    dataType: "JSON",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $.each(data, function() {
                            $('#ModalEdit').modal('show');
                            $('[name="LOKASI_PENYERAHAN"]').val(data.LOKASI_PENYERAHAN);
                            $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                            $('[name="NAMA2"]').val(data.NAMA_BARANG);
                            $('[name="MEREK2"]').val(data.MEREK);
                        });
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
                    JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                    SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                    SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                    JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
                };
                $.ajax({
                    url: "<?php echo site_url('RFQ_form/simpan_data_di_luar_barang_master'); ?>",
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
            $('#btn_kirim_rfq').click(function() {
                var alamat = "<?php echo base_url('RFQ'); ?>";
                window.open(
                    alamat
                );
            });

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

                let ID_RFQ_FORM = $('#ID_RFQ_FORM2').val();
                let MEREK = $('#MEREK2').val();
                let SPESIFIKASI_SINGKAT = $('#SPESIFIKASI_SINGKAT2').val();
                let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
                let NAMA = $('#NAMA2').val();

                $.ajax({
                    url: "<?php echo site_url('RFQ_form/update_data') ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        ID_RFQ: ID_RFQ,
                        ID_RFQ_FORM: ID_RFQ_FORM,
                        NAMA: NAMA,
                        MEREK: MEREK,
                        SPESIFIKASI_SINGKAT: SPESIFIKASI_SINGKAT,
                        JUMLAH_BARANG: JUMLAH_BARANG
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

            $('#saya_setuju').click(function() {
                //check if checkbox is checked
                if ($(this).is(':checked')) {

                    $('#btn_update_kirim_rfq').removeAttr('disabled'); //enable input

                } else {
                    $('#btn_update_kirim_rfq').attr('disabled', true); //disable input
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

        });
    </script>

    </body>

    </html>