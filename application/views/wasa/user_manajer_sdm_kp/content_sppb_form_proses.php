<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
		<h2>Form SPPB</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li >
					<a href="<?php echo base_url('index.php/SPPB/') ?>">SPPB</a>	
			</li>
			<li class="active">
				<strong>
					<a>Form SPPB</a>
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

    <!-- Identitas Form SPPB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian Item Barang/Jasa SPPB</h5>
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

                    <li class=""><a data-toggle="tab" href="#tab-2">Catatan SPPB</a></li>

                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form method="get" class="form-horizontal">
                                <?php
                                if (isset($SPPB)) {
                                    foreach ($SPPB->result() as $SPPB) :
                                ?>
                                        <hr>
                                        <input style="display:none" type="text" class="form-control" name="ID_RASD" id="ID_RASD" value="<?php echo $SPPB->ID_RASD; ?>">
                                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->NAMA_PROYEK; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Jenis Pekerjaan:</label>
                                            <div class="col-sm-10">
                                                <?php if ($SPPB->JENIS_PEKERJAAN == "mainwork") {
                                                ?>
                                                    <div class="col-xs-2">
                                                        <label><input type="radio" checked value="mainwork" id="mainwork" name="KERJA" disabled>&nbsp; Main Work</label>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label> <input type="radio" value="additional" id="additional" name="KERJA" disabled>
                                                            &nbsp; Addtional</label>
                                                    </div>
                                                <?php
                                                } else { ?>
                                                    <div class="col-xs-2">
                                                        <label><input type="radio" value="mainwork" id="mainwork" name="KERJA" disabled>&nbsp; Main Work</label>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label> <input type="radio" checked value="additional" id="additional" name="KERJA" disabled>
                                                            &nbsp; Addtional</label>
                                                    </div>
                                                <?php } ?>
                                                <input type="text" id="PEKERJAAN" name="PEKERJAAN" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">No Urut:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->NO_URUT_SPPB; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pembuatan :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $SPPB->TANGGAL_PEMBUATAN_SPPB_HARI; ?>" disabled>
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
                                            <span>Catatan Staff Umum Logistik:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SPPB['CTT_STAFF_UMUM_LOG']; ?>
                                </div>
                            </div>

                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Supervisi Logistik:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SPPB['CTT_SPV_LOG']; ?>
                                </div>
                            </div>

                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Staff Logistik:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SPPB['CTT_STAFF_LOG']; ?>
                                </div>
                            </div>

                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Staff Logistik Gudang:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SPPB['CTT_STAFF_GUDANG_LOG']; ?>
                                </div>
                            </div>

                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Kasie Logistik:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SPPB['CTT_KASIE_LOG']; ?>
                                </div>
                            </div>

                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Manajer HRD:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SPPB['CTT_M_HRD']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_M_KEU']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_M_KONS']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_M_SDM']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_M_QAQC']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_M_EP']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_M_HSSE']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_M_MARKETING']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_M_KOMERSIAL']; ?>
                                </div>
                            </div>

                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Manajer Logistik:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_SPPB['CTT_M_LOG']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_D_KEU']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_D_EP_KONS']; ?>
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
                                    <?php echo $CATATAN_SPPB['CTT_D_PSDS']; ?>
                                </div>
                            </div>

                            </br>
                            <div class="hr-line-dashed"></div>
                            <a href="javascript:;" id="item_edit_catatan_sppb" name="item_edit_catatan_sppb" class="btn btn-info" data="<?php echo $HASH_MD5_SPPB; ?>"><i class="fa fa-comment"></i> Berikan Catatan SPPB </a>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <!-- End Identitas Form SPPB -->

    <!-- Form SPPB -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>SPPB Item Barang/Jasa</h5>
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
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <!-- <th>Status Barang</th> -->
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merek Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Satuan Barang</th>
                                    <th>RASD</th>
                                    <th>Stok Gudang Pusat</th>
                                    <th>Stok Gudang Proyek</th>
                                    <th>Total Pengadaan s/d Saat Ini</th>
                                    <th>Jumlah Yang Diminta</th>
                                    <th>Jumlah Yang Disetujui</th>
                                    <!-- <th>Pilih</th> -->
                                    <th>Justifikasi</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    <!-- </br>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddDariRasdBarang"><span class="fa fa-plus"></span> Tambah Item dari RASD</a><br>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Tambah Item dari Barang Master</a><br>
                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#ModalAddNew"><span class="fa fa-plus"></span> Tambah Item Baru</a> -->
                </div>

            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="sm-10">
                            <a href="<?php echo base_url('index.php/SPPB_form/view/') ?><?php echo $HASH_MD5_SPPB; ?>" class="btn btn-primary"><span class="fa fa-save"></span> Simpan Perubahan & View Dokumen SPPB</a>
                            </br>
                            <a href="javascript:;" id="item_edit_kirim_sppb" name="item_edit_kirim_sppb" class="btn btn-success" data="<?php echo $HASH_MD5_SPPB; ?>"><span class="fa fa-send"></span> Ajukan SPPB Untuk Proses Selanjutnya </a><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Form SPPB -->
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
                    <small class="font-bold">Silakan isi data SPPB berdasarkan daftar RASD</small>
                </div>

                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="table-responsive">

                            <form method="POST" action="<?php echo site_url('SPPB_form/simpan_data_dari_rasd_form'); ?>" id="formTambahRASD">
                                <table class="table table-striped table-bordered table-hover" id="modalrasd">
                                    <thead>
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Kode Barang</th>
                                            <th>RASD</th>
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
                                                    <input name="ID_SPPB" class="form-control" type="text" value="<?php echo $ID_SPPB  ?>" style="display: none;" readonly>
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
                                                    <input class="touchspin1" type="text" value="0"  name="<?php echo $data->ID_RASD_FORM ?>">
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
                        <button class="btn btn-primary" type="submit" form="formTambahRASD"><i class="fa fa-save"></i> Simpan</button>
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
                    <b class="font-bold">Maaf semua item barang/jasa dari RASD sudah ada di Form SPPB ini</b>
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
                    <h4 class="modal-title">Daftar Barang Master</h4>
                    <small class="font-bold">Silakan isi data SPPB berdasarkan daftar Barang Master</small>

                </div>
                
                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="alert alert-info alert-dismissable">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            Daftar Barang Master berikut adalah daftar barang yang tidak termasuk dalam RASD proyek
                        </div>
                        <div class="table-responsive">

                            <form method="POST" action="<?php echo site_url('SPPB_form/simpan_data_dari_barang_master'); ?>" id="formTambahMASTER">
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
                                                    <input name="ID_SPPB" class="form-control" type="text" value="<?php echo $ID_SPPB  ?>" style="display: none;" readonly>
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
                        <button class="btn btn-primary" type="submit" form="formTambahMASTER"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            <?php
            } else {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-exclamation-triangle modal-icon"></i>
                    <h4 class="modal-title">Sppb Barang</h4>
                    <b class="font-bold">Maaf semua barang master sudah ada di sppb barang ini</b>
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
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Tambah Item Barang/Jasa Di Luar RASD dan Barang Master</h4>
                <small class="font-bold">Silakan isi data Item Barang/Jasa SPPB yang Baru</small>
            </div>
            <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/simpan_data_di_luar_barang_master", $attributes); ?>
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
                    <button class="btn btn-primary" id="btn_simpan_data_di_luar_barang_master"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD DI LUAR BARANG MASTER-->

<!-- MODAL SIMPAN SPPB -->
<div class="modal inmodal fade" id="ModalSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;"> 
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-save modal-icon"></i>
                <h4 class="modal-title">Simpan SPPB</h4>
                <small class="font-bold">Silakan isi catatan Sppb dan Simpan Perubahan</small>
            </div>
            <!-- exclamation-triangle -->
            <div class="form-horizontal">
                <div class="modal-body">

                    <form method="POST" action="<?php echo site_url('SPPB/simpan_perubahan_sppb'); ?>" id="formSimpanSPPB">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control h-200" name="CTT" id="CTT" placeholder="Contoh : Barang ini sangat diperlukan segera di lapangan" required></textarea>
                                <input name="ID_SPPB" class="form-control" type="text" value="<?php echo $ID_SPPB  ?>" style="display: none;" readonly>
                            </div>
                        </div>
                    </form>
                    <div id="alert-msg"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" type="submit" form="formSimpanSPPB"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- END MODAL SIMPAN SPPB -->



<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Ubah Item Barang/Jasa SPPB</h4>
                <small class="font-bold">Silakan edit item barang/jasa SPPB</small>
            </div>
            <?php $attributes = array("ID_SPPB_barang2" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_SPPB_FORM2" id="ID_SPPB_FORM2" class="form-control" type="hidden" placeholder="ID sppb barang" readonly>

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

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT2" id="SPESIFIKASI_SINGKAT2" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG2" id="JUMLAH_BARANG2" class="form-control touchspin1" type="number">
                        </div>
                    </div>

                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->

<!-- MODAL EDIT JUSTIFIKASI BARANG-->
<div class="modal inmodal fade" id="ModalEditJustifikasiBarang" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Justifikasi Item Barang/Jasa</h4>
                <small class="font-bold">Silakan berikan justifikasi atas item barang/jasa</small>
            </div>
            <?php $attributes = array("ID_SPPB_barang5" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_justifikasi_barang", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_SPPB_FORM5" id="ID_SPPB_FORM5" class="form-control" type="hidden" placeholder="ID sppb barang" readonly>

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
                        <label class="control-label col-xs-3">Justifikasi Item Barang/Jasa Manajer SDM KP</label>
                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="JUSTIFIKASI_SDM5" id="JUSTIFIKASI_SDM5" placeholder="Contoh: " required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-5"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_justifikasi_barang"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT JUSTIFIKASI BARANG-->

<!-- MODAL EDIT CATATAN SPPB-->
<div class="modal inmodal fade" id="ModalEditCatatanSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Catatan SPPB</h4>
                <small class="font-bold">Silakan berikan komentar atau catatan mengenai Form SPPB ini</small>
            </div>
            <?php $attributes = array("ID_SPPB6" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_catatan_sppb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_SPPB6" id="ID_SPPB6" class="form-control" type="hidden" placeholder="ID SPPB" readonly>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Catatan SPPB</label>

                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="CTT_M_SDM6" id="CTT_M_SDM6"  required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-6"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_catatan_sppb"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT CATATAN SPPB-->

<!-- MODAL KIRIM SPPB-->
<div class="modal inmodal fade" id="ModalEditKirimSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim SPPB</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form SPPB ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_SPPB7" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_kirim_sppb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_SPPB7" id="ID_SPPB7" class="form-control" type="hidden" placeholder="ID_SPPB" readonly>


                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melalukan proses form SPPB ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_sppb" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM SPPB-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 80vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa SPPB</h4>
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
        let ID_SPPB = <?php echo $ID_SPPB  ?>;
        tampil_data_sppb_form(); //pemanggilan fungsi tampil data.

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
                    title: 'Sppb Barang'
                },
                {
                    extend: 'pdf',
                    title: 'Sppb Barang'
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

        $('#modalmaster').dataTable();
        $('#modalrasd').dataTable();

        //fungsi tampil data
        function tampil_data_sppb_form() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>SPPB_form/data_sppb_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_SPPB
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_MINTA;
                        let jumlah_rasd = data[i].JUMLAH_RASD;
                        let kode_barang = data[i].KODE_BARANG;

                        if (kode_barang != null) {
                            kode_barang_cetak = '<a href="<?php echo base_url() ?>barang_master/profil_barang_master/'+data[i].HASH_MD5_BARANG_MASTER +'" class="btn btn-warning btn-xs btn-outline block" target="_blank"><i class="fa fa-eye"></i> '+ kode_barang +' </a>';
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
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                            '<td>' + jumlah_rasd + '</td>' +
                            '<td> 0 </td>' +
                            '<td> 0 </td>' +
                            '<td><span class="label label-warning"><i class="fa fa-warning"></i> Belum ada </span></td>' +
                            '<td>' + jumlah_barang + '</td>' +
                            '<td> 0 </td>' +
                            // '<td>' +
                            // '<a href="javascript:;" class="btn btn-info btn-xs item_edit block" data="' + data[i].ID_SPPB_FORM + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
                            // '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_SPPB_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' +
                            // '</td>' +
                            '<td>' + 
                            '<a href="javascript:;" class="btn btn-success btn-xs item_edit_justifikasi block" data="' + data[i].ID_SPPB_FORM + '"><i class="fa fa-comment  "></i> Justifikasi </a>' + ' ' + 
                            '</td>' +
                            
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        // SIMPAN SPPB DAN KEMBALI KE SPPB LIST // BELUM CEK
        $('#btn_simpan_sppb').on('click', function() {
            let ID_SPPB = ID_SPPB;
            let CTT = $('#CTT').val();

        })

        //GET UPDATE untuk edit jumlah
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPPB_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEdit').modal('show');
                        $('[name="ID_SPPB_FORM2"]').val(data.ID_SPPB_FORM);
                        $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                        $('[name="NAMA2"]').val(data.NAMA_BARANG);
                        $('[name="MEREK2"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_MINTA);
                        $('#alert-msg-2').html('<div></div>');
                    });
                }
            });
            return false;
        });

        //GET UDPATE untuk berikan justifkasi
        $('#show_data').on('click', '.item_edit_justifikasi', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPPB_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditJustifikasiBarang').modal('show');
                        $('[name="ID_SPPB_FORM5"]').val(data.ID_SPPB_FORM);
                        $('[name="KODE_BARANG5"]').val(data.KODE_BARANG);
                        $('[name="NAMA5"]').val(data.NAMA_BARANG);
                        $('[name="MEREK5"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT5"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG5"]').val(data.JUMLAH_MINTA);
                        $('[name="JUSTIFIKASI_STAFF_LOG5"]').val(data.JUSTIFIKASI_STAFF_LOG);

                        $('[name="JUSTIFIKASI_SVP_LOG5"]').val(data.JUSTIFIKASI_SVP_LOG);
                        $('[name="JUSTIFIKASI_CHIEF5"]').val(data.JUSTIFIKASI_CHIEF);
                        $('[name="JUSTIFIKASI_SM5"]').val(data.JUSTIFIKASI_SM);
                        $('[name="JUSTIFIKASI_PM5"]').val(data.JUSTIFIKASI_PM);
                        $('[name="JUSTIFIKASI_SDM5"]').val(data.JUSTIFIKASI_SDM);
                        $('#alert-msg-5').html('<div></div>');
                    });
                }
            });
            return false;
        });

        item_edit_catatan_sppb.onclick = function()
        {
            var HASH_MD5_SPPB = $(this).attr('data');
            console.log(HASH_MD5_SPPB);
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPPB_form/get_data_ctt_sppb') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_SPPB: HASH_MD5_SPPB
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditCatatanSPPB').modal('show');
                        $('[name="ID_SPPB6"]').val(data.ID_SPPB);
                        $('[name="CTT_M_SDM6"]').val(data.CTT_M_SDM);

                        $('#alert-msg-6').html('<div></div>');
                    });
                }
            });
            return false;
        };

        item_edit_kirim_sppb.onclick = function()
        {
            var HASH_MD5_SPPB = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPPB_form/get_data_catatan_sppb') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_SPPB: HASH_MD5_SPPB
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditKirimSPPB').modal('show');
                        $('[name="ID_SPPB7"]').val(data.ID_SPPB);

                        $('#alert-msg-7').html('<div></div>');
                    });
                }
            });
            return false;
        };

        $('#saya_setuju').click(function () {
		//check if checkbox is checked
		if ($(this).is(':checked')) {
                
            $('#btn_update_kirim_sppb').removeAttr('disabled'); //enable input
                
            } else {
                $('#btn_update_kirim_sppb').attr('disabled', true); //disable input
            }
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPPB_form/get_data') ?>",
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
                ID_SPPB: ID_SPPB,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('SPPB_form/simpan_data_di_luar_barang_master'); ?>",
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

            let ID_SPPB_FORM = $('#ID_SPPB_FORM2').val();
            let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
            $.ajax({
                url: "<?php echo site_url('SPPB_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPPB_FORM: ID_SPPB_FORM,
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

        //UPDATE JUSTIFIKASI BARANG 
        $('#btn_update_justifikasi_barang').on('click', function() {

        let ID_SPPB_FORM = $('#ID_SPPB_FORM5').val();
        let JUSTIFIKASI_SDM = $('#JUSTIFIKASI_SDM5').val();
        $.ajax({
            url: "<?php echo site_url('SPPB_form/update_data_justifikasi_barang') ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                ID_SPPB_FORM: ID_SPPB_FORM,
                JUSTIFIKASI_SDM: JUSTIFIKASI_SDM
            },
            success: function(data) {
                if (data == true) {
                    $('#ModalEditJustifikasiBarang').modal('hide');
                    window.location.reload();
                } else {
                    $('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
                }
            }
        });
        return false;
        });

        //UPDATE CATATAN SPPB 
        $('#btn_update_catatan_sppb').on('click', function() {

        let ID_SPPB = $('#ID_SPPB6').val();
        let CTT_M_SDM = $('#CTT_M_SDM6').val();
        $.ajax({
            url: "<?php echo site_url('SPPB_form/update_data_catatan_sppb') ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                ID_SPPB: ID_SPPB,
                CTT_M_SDM: CTT_M_SDM
            },
            success: function(data) {
                if (data == true) {
                    $('#ModalEditCatatanSPPB').modal('hide');
                    window.location.reload();
                } else {
                    $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                }
            }
        });
        return false;
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

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('SPPB_form/hapus_data') ?>",
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

</body>

</html>