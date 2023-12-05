<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form PO</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/PO/') ?>">PO</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form PO</a>
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

    <!-- Form PO -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Formulir Pengajuan PO</h5>
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
                        if (isset($PO)) {
                            foreach ($PO->result() as $PO) :
                        ?>

                                <div class="form-group"><label class="col-sm-2 control-label">No Urut PO:</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $PO->NO_URUT_PO; ?>" disabled></div>
                                </div>

                        <?php endforeach;
                        } ?>

                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi Penyerahan:</label>
                            <div class="col-sm-10">
                                <?php
                                if (empty($LOKASI_PENYERAHAN)) {
                                ?>

                                    <input type="text" name="LOKASI_PENYERAHAN" id="LOKASI_PENYERAHAN" class="form-control" placeholder="Contoh: Jalan Raya Cakung Cilincing KM 1 no.11">
                                <?php
                                } else {
                                ?>
                                    <input type="text" name="LOKASI_PENYERAHAN" id="LOKASI_PENYERAHAN" class="form-control" value="<?php echo $LOKASI_PENYERAHAN; ?>">
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Vendor:</label>
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

                        <div id="show_hidden_vendor" class="form-group" hidden><label class="col-sm-2 control-label">Vendor Lainnya:</label>
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

                        <div id="show_hidden_vendor_2" class="form-group" hidden><label class="col-sm-2 control-label">Alamat Vendor:</label>
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

                        <div id="show_hidden_vendor_3" class="form-group" hidden><label class="col-sm-2 control-label">No Telepon Vendor:</label>
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

                        <div class="form-group"><label class="col-sm-2 control-label">Term Of Payment:</label>
                            <div class="col-sm-10">
                                <?php
                                if (empty($TERM_OF_PAYMENT)) {
                                ?>
                                    <input type="text" name="TOP" id="TOP" class="form-control" placeholder="Contoh: Pelunasan 30 hari sejak invoice lengkap diterima">
                                <?php
                                } else {
                                ?>
                                    <input type="text" name="TOP" id="TOP" class="form-control" value="<?php echo $TERM_OF_PAYMENT; ?>" placeholder="Contoh: Pelunasan 30 hari sejak invoice lengkap diterima">
                                <?php
                                }
                                ?>
                            </div>

                        </div>

                        <input style="width:100%" name="HASH_MD5_PO" id="HASH_MD5_PO" type="hidden" value="<?php echo $HASH_MD5_PO; ?>">

                        <hr>

                        <div class="form-horizontal">

                            <div class="alert alert-warning alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                Perubahan data pada form PO tidak akan mempengaruhi data pada form SPPB.
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="mydata">
                                    <thead>
                                        <tr>
                                            <!-- <th>Status Barang</th> -->
                                            <th>Pilihan</th>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Merek Barang</th>
                                            <th>Jenis Barang</th>
                                            <th>Spesifikasi Singkat</th>
                                            <th>Satuan Barang</th>
                                            <th>Jumlah Yang Diadakan</th>
                                            <th>Harga Satuan Barang</th>
                                            <th>Harga Total Barang</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">

                                    </tbody>

                                </table>
                            </div>

                            <div id="alert-msg-6"></div>

                            </br>
                            </br>
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddDariRasdBarang"><span class="fa fa-plus"></span> Tambah Item dari RASD</a><br>
                            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Tambah Item dari Master List/Price List</a><br>
                            <a href="#" class="btn btn-info" data-toggle="modal" data-target="#ModalAddNew"><span class="fa fa-plus"></span> Tambah Item Baru</a>


                        </div>
                    </div>
                </div>

                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="form-group">
                            <div class="sm-10">
                                <button class="btn btn-primary" id="btn_simpan_perubahan_pdf"><i class="fa fa-save"></i> Simpan Perubahan & View Dokumen PO</button>
                                </br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Form PO -->
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
                            <small class="font-bold">Silakan isi data PO berdasarkan daftar Master List/Price List</small>

                        </div>

                        <div class="form-horizontal">
                            <div class="modal-body">
                                <div class="alert alert-info alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    Daftar Master List berikut adalah daftar barang yang tidak termasuk dalam RASD proyek
                                </div>
                                <div class="table-responsive">

                                    <form method="POST" action="<?php echo site_url('PO_form/simpan_data_dari_barang_master'); ?>" id="formTambahMASTER">
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
                                                            <input name="ID_PO" class="form-control" type="text" value="<?php echo $ID_PO  ?>" style="display: none;" readonly>
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

                                    <form method="POST" action="<?php echo site_url('PO_form/simpan_data_dari_rasd_form'); ?>" id="formTambahRASD">
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
                                                            <input name="ID_PO" class="form-control" type="text" value="<?php echo $ID_PO  ?>" style="display: none;" readonly>
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
                        <small class="font-bold">Silakan isi data Item Barang/Jasa PO yang Baru</small>
                    </div>
                    <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
                    echo form_open("PO_form/simpan_data_di_luar_barang_master", $attributes); ?>
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
                                <label class="control-label col-xs-3">Jumlah Diadakan</label>
                                <div class="col-xs-9">
                                    <input class=" touchspin1" type="number" value="0" name="JUMLAH_BARANG_4" id="JUMLAH_BARANG_4">
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
                        <h4 class="modal-title">Ubah Item Barang/Jasa PO</h4>
                        <small class="font-bold">Silakan edit item barang/jasa PO</small>
                    </div>
                    <?php $attributes = array("ID_PO_FORM2" => "contact_form", "id" => "contact_form");
                    echo form_open("PO_form/update_data", $attributes); ?>
                    <div class="form-horizontal">
                        <div class="modal-body">


                            <input name="ID_PO_FORM2" id="ID_PO_FORM2" class="form-control" type="hidden" readonly>

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
                                    <input name="JUMLAH_BARANG2" id="JUMLAH_BARANG2" class="form-control touchspin1" type="number">
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
                                    <input name="HARGA_TOTAL_FIX2" id="HARGA_TOTAL_FIX2" class="form-control" type="hidden" placeholder="Contoh: Rp 14000000 " disabled>
                                    <input name="HARGA_TOTAL_TAMPIL2" id="HARGA_TOTAL_TAMPIL2" class="form-control" type="text" placeholder="Contoh: Rp 14000000 " disabled>
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
                    <?php $attributes = array("ID_PO_barang5" => "contact_form", "id" => "contact_form");
                    echo form_open("PO_form/update_data_justifikasi_barang", $attributes); ?>
                    <div class="form-horizontal">
                        <div class="modal-body">


                            <input name="ID_PO_FORM5" id="ID_PO_FORM5" class="form-control" type="hidden" readonly>

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
                                    <input name="JUMLAH_BARANG5" id="JUMLAH_BARANG5" class="form-control touchspin1" type="number" readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-3">Keterangan Item Barang</label>
                                <div class="col-xs-9">
                                    <textarea class="form-control h-200" name="KETERANGAN5" id="KETERANGAN5" placeholder="Contoh: Paku Payung 13 cm" required></textarea>
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
                        <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa PO</h4>
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



        <!-- MODAL KIRIM PO-->
        <div class="modal inmodal fade" id="ModalEditKirimPO" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog" style="width: 60vw;">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <i class="fa fa-send modal-icon"></i>
                        <h4 class="modal-title">Lanjutkan Proses PO</h4>
                        <small class="font-bold">Selesaikan pengisian Form PO ini untuk proses selanjutnya</small>
                    </div>
                    <div class="form-horizontal">
                        <div class="modal-body">

                            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT_PO" id="JUMLAH_COUNT_PO" disabled />

                            <div class="form-group">
                                <label class="col-xs-3 control-label">Nomor Urut PO:</label>
                                <div class="col-xs-9">
                                    <input type="text" class="form-control" value="" name="NO_URUT_PO" id="NO_URUT_PO" disabled />
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
                                <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form PO ini dan menyetujui untuk diproses lebih lanjut </label></div>
                            </div>

                            <div id="alert-msg-3"></div>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                            <button class="btn btn-primary" id="btn_update_kirim_po" disabled><i class="fa fa-send"></i> Kirim</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--END MODAL EDIT KIRIM PO-->


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
            $("#HARGA_SATUAN_BARANG_FIX_4").on("change", function() {

                var HARGA = $("#HARGA_SATUAN_BARANG_FIX_4").val();
                console.log(HARGA);
                var JUMLAH = $("#JUMLAH_BARANG_4").val();
                console.log(JUMLAH);

                var TOTAL = HARGA * JUMLAH;
                console.log(TOTAL);

                $('[name="HARGA_TOTAL_FIX_4"]').val(TOTAL);
                $('[name="HARGA_TOTAL_TAMPIL_4"]').val(new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(TOTAL));

            });

            $("#HARGA_SATUAN_BARANG_FIX2").on("change", function() {

                var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
                console.log(HARGA);
                var JUMLAH = $("#JUMLAH_BARANG2").val();
                console.log(JUMLAH);

                var TOTAL = HARGA * JUMLAH;
                console.log(TOTAL);

                $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
                $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(TOTAL));

            });

            $(document).ready(function() {
                var ID_SPPB = <?php echo $ID_SPPB;  ?>;
                var ID_PO = <?php echo $ID_PO;  ?>;

                $("#ID_VENDOR").change(function() {
                    if ($("#ID_VENDOR option:selected").text() == '- Vendor Lainnya -') {
                        console.log($("#ID_VENDOR").val());
                        $('#show_hidden_vendor').attr("hidden", false); //enable input
                        $('#show_hidden_vendor_2').attr("hidden", false); //enable input
                        $('#show_hidden_vendor_3').attr("hidden", false); //enable input
                    } else {
                        $('#show_hidden_vendor').attr("hidden", true); //enable input
                        $('#show_hidden_vendor_2').attr("hidden", true); //enable input
                        $('#show_hidden_vendor_3').attr("hidden", true); //enable input
                    }
                });

                tampil_data_form_po(); //pemanggilan fungsi tampil data.

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
                            title: 'PO Form'
                        },
                        {
                            extend: 'pdf',
                            title: 'PO Form'
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

                // jumlah-+
                $(".touchspin1").TouchSpin({
                    buttondown_class: 'btn btn-white',
                    buttonup_class: 'btn btn-white',
                    min: 0,
                    max: 99999999999,
                });

                //fungsi tampil data penyerahan vendor top
                function tampil_data_po_penyerahan_vendor_top() {
                    var ID_PO = ID_PO;
                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url('PO_form/get_data_po') ?>",
                        dataType: "JSON",
                        data: {
                            ID_PO: ID_PO
                        },
                        success: function(data) {
                            $.each(data, function() {
                                $('#ModalEdit').modal('show');
                                $('[name="ID_PO_FORM2"]').val(data.ID_PO_FORM);
                                $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                                $('[name="NAMA2"]').val(data.NAMA_BARANG);
                                $('[name="MEREK2"]').val(data.MEREK);
                                $('[name="JENIS_BARANG2"]').val(data.JENIS_BARANG);
                                $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                                $('[name="SATUAN_BARANG2"]').val(data.SATUAN_BARANG);
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
                function tampil_data_form_po() {
                    $.ajax({
                        type: 'GET',
                        url: '<?php echo base_url() ?>PO_form/data_po_form',
                        async: false,
                        dataType: 'json',
                        data: {
                            id: ID_PO
                        },
                        success: function(data) {
                            console.log(data);
                            var html = '';
                            var i;
                            for (i = 0; i < data.length; i++) {
                                // let jumlah_barang = data[i].JUMLAH_BARANG;
                                let jumlah_rasd = data[i].JUMLAH_RASD;
                                let kode_barang = data[i].KODE_BARANG;

                                if (kode_barang != null) {
                                    kode_barang_cetak = '<a href="<?php echo base_url() ?>barang_master/profil_barang_master/' + data[i].HASH_MD5_BARANG_MASTER + '" class="btn btn-warning btn-xs btn-outline block" target="_blank"><i class="fa fa-eye"></i> ' + kode_barang + ' </a>';
                                }
                                if (kode_barang == null) {
                                    kode_barang_cetak = '<span class="label label-info block"><i class="fa fa-warning"></i> Data Baru</span>';
                                }

                                // if (jumlah_barang == null) {
                                //     jumlah_barang = 0;
                                // }
                                if (kode_barang == null) {
                                    kode_barang = `<span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span>`;
                                }
                                if (jumlah_rasd == null) {
                                    jumlah_rasd = 0;
                                }
                                html += '<tr>' +
                                    '<td>' +
                                    '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_PO_FORM + '"><i class="fa fa-pencil"></i> Ubah </a>' + ' ' +
                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_PO_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' +
                                    '</td>' +
                                    '<td>' + kode_barang_cetak + '</td>' +
                                    '<td>' + data[i].NAMA_BARANG + '</td>' +
                                    '<td>' + data[i].MEREK + '</td>' +
                                    '<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
                                    '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                                    '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                                    '<td>' + data[i].JUMLAH_BARANG + '</td>' +
                                    '<td>' + data[i].HARGA_SATUAN_BARANG_FIX + '</td>' +
                                    '<td>' + data[i].HARGA_TOTAL_FIX + '</td>' +
                                    '<td>' +
                                    '<a href="javascript:;" class="btn btn-success btn-xs item_edit_keterangan block" data="' + data[i].ID_PO_FORM + '"><i class="fa fa-comment  "></i> Keterangan </a>' + ' ' +
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
                        url: "<?php echo base_url('PO_form/get_data') ?>",
                        dataType: "JSON",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            console.log(data);
                            $('#ModalEdit').modal('show');
                            $('[name="LOKASI_PENYERAHAN"]').val(data.LOKASI_PENYERAHAN);
                            $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                            $('[name="NAMA2"]').val(data.NAMA_BARANG);
                            $('[name="MEREK2"]').val(data.MEREK);
                            $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                            $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_BARANG);
                            $('[name="JENIS_BARANG2"]').val(data.ID_JENIS_BARANG);
                            $('[name="SATUAN_BARANG2"]').val(data.ID_SATUAN_BARANG);
                            $('[name="HARGA_SATUAN_BARANG_FIX2"]').val(data.HARGA_SATUAN_BARANG_FIX);
                            $('[name="HARGA_TOTAL_FIX2"]').val(data.HARGA_TOTAL_FIX);

                        }
                    });
                    return false;
                });

                //UPDATE JUSTIFIKASI BARANG 
                $('#btn_update_keterangan_barang').on('click', function() {

                    let ID_PO_FORM = $('#ID_PO_FORM5').val();
                    let KETERANGAN = $('#KETERANGAN5').val();
                    $.ajax({
                        url: "<?php echo site_url('PO_form/update_data_keterangan_barang') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            ID_PO_FORM: ID_PO_FORM,
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
                        ID_PO: ID_PO,
                        NAMA: $('#NAMA_4').val(),
                        MEREK: $('#MEREK_4').val(),
                        JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                        SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                        SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                        JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
                        HARGA_SATUAN_BARANG_FIX: $('#HARGA_SATUAN_BARANG_FIX_4').val(),
                        HARGA_TOTAL_FIX: $('#HARGA_TOTAL_FIX_4').val(),
                    };
                    $.ajax({
                        url: "<?php echo site_url('PO_form/simpan_data_di_luar_barang_master'); ?>",
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
                        ID_PO: ID_PO,
                        LOKASI_PENYERAHAN: $('#LOKASI_PENYERAHAN').val(),
                        ID_VENDOR: $('#ID_VENDOR').val(),
                        TOP: $('#TOP').val(),
                        NAMA_VENDOR: $('#NAMA_VENDOR').val(),
                        ALAMAT_VENDOR: $('#ALAMAT_VENDOR').val(),
                        NO_TELP_VENDOR: $('#NO_TELP_VENDOR').val(),
                    };
                    $.ajax({
                        url: "<?php echo site_url('PO_form/simpan_perubahan_pdf'); ?>",
                        type: 'POST',
                        data: form_data,
                        success: function(data) {
                            if (data != 'true') {
                                $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                            } else {
                                var HASH_MD5_PO = $('#HASH_MD5_PO').val()
                                var alamat = "<?php echo base_url('PO_form/view/'); ?>" + HASH_MD5_PO;
                                window.open(
                                    alamat,
                                    '_blank' // <- This is what makes it open in a new window.
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
                        url: "<?php echo base_url('PO_form/get_data') ?>",
                        dataType: "JSON",
                        data: {
                            id: id
                        },
                        success: function(data) {
                            $.each(data, function() {
                                $('#ModalEditKeteranganBarang').modal('show');
                                $('[name="ID_PO_FORM5"]').val(data.ID_PO_FORM);
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

                    let ID_PO_FORM = $('#ID_PO_FORM2').val();
                    let NAMA = $('#NAMA2').val();
                    let MEREK = $('#MEREK2').val();
                    let JENIS_BARANG = $('#JENIS_BARANG2').val();
                    let SPESIFIKASI_SINGKAT = $('#SPESIFIKASI_SINGKAT2').val();
                    let SATUAN_BARANG = $('#SATUAN_BARANG2').val();
                    let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
                    let HARGA_SATUAN_BARANG_FIX = $('#HARGA_SATUAN_BARANG_FIX2').val();
                    let HARGA_TOTAL_FIX = $('#HARGA_TOTAL_FIX2').val();
                    $.ajax({
                        url: "<?php echo site_url('PO_form/update_data') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            ID_PO: ID_PO,
                            ID_PO_FORM: ID_PO_FORM,
                            NAMA: NAMA,
                            MEREK: MEREK,
                            JENIS_BARANG: JENIS_BARANG,
                            SPESIFIKASI_SINGKAT: SPESIFIKASI_SINGKAT,
                            JUMLAH_BARANG: JUMLAH_BARANG,
                            SATUAN_BARANG: SATUAN_BARANG,
                            HARGA_SATUAN_BARANG_FIX: HARGA_SATUAN_BARANG_FIX,
                            HARGA_TOTAL_FIX: HARGA_TOTAL_FIX
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
                        url: "<?php echo base_url('PO_form/get_data') ?>",
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
                        url: "<?php echo base_url('PO_form/hapus_data') ?>",
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

                        $('#btn_update_kirim_po').removeAttr('disabled'); //enable input

                    } else {
                        $('#btn_update_kirim_po').attr('disabled', true); //disable input
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