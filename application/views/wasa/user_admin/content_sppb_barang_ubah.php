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

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian Item Barang/Jasa SPPB</h5>
        </div>
        <div class="ibox-content">
            <form method="get" class="form-horizontal">
                <?php
                if (isset($sppb)) {
                    foreach ($sppb->result() as $sppb) :
                ?>
                        <hr>
                        <input style="display:none" type="text" class="form-control" name="ID_RASD" id="ID_RASD" value="<?php echo $sppb->ID_RASD; ?>">
                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi:</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $sppb->NAMA_PROYEK; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Jenis Pekerjaan:</label>
                            <div class="col-sm-10">
                                <?php if ($sppb->JENIS_PEKERJAAN == "mainwork") {
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
                        <div class="form-group"><label class="col-sm-2 control-label">No Urut :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $sppb->NO_URUT_SPPB; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pembuatan :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $sppb->TANGGAL_PEMBUATAN_SPPB_HARI; ?>" disabled>
                                <a href="#">Lihat RASD Proyek</a>
                            </div>
                        </div>
                <?php endforeach;
                } ?>
            </form>
        </div>
    </div>

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
                        <a class="close-link">
                            <i class="fa fa-times"></i>
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
                                    <th>Nama</th>
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
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddDariRasdBarang"><span class="fa fa-plus"></span> Tambah Data dari RASD</a><br>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Tambah Data dari Barang Master</a><br>
                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#ModalAddNew"><span class="fa fa-plus"></span> Tambah Data Baru</a>
                </div>

            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="sm-10">
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalSPPB"><span class="fa fa-save"></span> Simpan Perubahan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SIMPAN SPPB -->
<div class="modal inmodal fade" id="ModalSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-save modal-icon"></i>
                <h4 class="modal-title">Simpan Sppb</h4>
                <small class="font-bold">Silakan isi catatan Sppb dan Simpan Perubahan</small>
            </div>
            <!-- exclamation-triangle -->
            <div class="form-horizontal">
                <div class="modal-body">

                    <form method="POST" action="<?php echo site_url('sppb/simpan_perubahan_sppb'); ?>" id="formSimpanSPPB">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control h-200" name="CTT" id="CTT" placeholder="Contoh : Barang ini sangat diperlukan segera di lapangan" required></textarea>
                                <input name="ID_SPPB" class="form-control" type="text" value="<?php echo $id_sppb  ?>" style="display: none;" readonly>
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
                <!-- exclamation-triangle -->
                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="table-responsive">

                            <form method="POST" action="<?php echo site_url('sppb_barang/simpan_data_dari_barang_master'); ?>" id="formTambahMASTER">
                                <table class="table table-striped table-bordered table-hover" id="modalmaster">
                                    <thead>
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Kode Barang</th>
                                            <th>Nama</th>
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
                                                    <input name="ID_SPPB" class="form-control" type="text" value="<?php echo $id_sppb  ?>" style="display: none;" readonly>
                                                    <input class="checkbox" name="ID_BARANG_MASTER[]" value="<?php echo $data->ID_BARANG_MASTER ?>" type="checkbox">
                                                </td>
                                                <td> <?php echo $data->KODE_BARANG; ?> </td>
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
                <!-- exclamation-triangle -->
                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="table-responsive">

                            <form method="POST" action="<?php echo site_url('sppb_barang/simpan_data_dari_rasd_barang'); ?>" id="formTambahRASD">
                                <table class="table table-striped table-bordered table-hover" id="modalrasd">
                                    <thead>
                                        <tr>
                                            <th>Pilih</th>
                                            <th>Kode Barang</th>
                                            <th>RASD</th>
                                            <th>Nama</th>
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
                                                    <input name="ID_SPPB" class="form-control" type="text" value="<?php echo $id_sppb  ?>" style="display: none;" readonly>
                                                    <input class="checkbox" name="ID_RASD_BARANG[]" value="<?php echo $data->ID_RASD_BARANG ?>" type="checkbox">
                                                </td>
                                                <?php if ($data->ID_BARANG_MASTER == null) { ?>
                                                    <td><span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span></td>
                                                <?php } else { ?>
                                                    <td> <?php echo $data->KODE_BARANG; ?> </td>
                                                <?php } ?>

                                                <td> <?php echo $data->JUMLAH_BARANG; ?> </td>
                                                <td> <?php echo $data->NAMA; ?> </td>
                                                <td> <?php echo $data->MEREK; ?> </td>
                                                <td> <?php echo $data->NAMA_JENIS_BARANG; ?> </td>
                                                <td> <?php echo $data->SPESIFIKASI_SINGKAT; ?> </td>
                                                <td> <?php echo $data->NAMA_SATUAN_BARANG; ?> </td>
                                                <td style="width: 20%;">
                                                    <input class="touchspin1" type="text" value="0" name="<?php echo $data->ID_RASD_BARANG ?>">
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
                    <h4 class="modal-title">RASD</h4>
                    <b class="font-bold">Maaf semua barang dari RASD sudah ada di sppb ini</b>
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

<!-- MODAL ADD NEW-->
<div class="modal inmodal fade" id="ModalAddNew" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Tambah Data Baru Di Luar RASD dan Barang Master</h4>
                <small class="font-bold">Silakan isi data item SPPB</small>
            </div>
            <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
            echo form_open("sppb_barang/simpan_data", $attributes); ?>
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
                            <input name="SPESIFIKASI_SINGKAT_4" id="SPESIFIKASI_SINGKAT_4" class="form-control" type="text" placeholder="Mengenai barang seperti bentuk dan kelebihannya" required autofocus>
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
                    <button class="btn btn-primary" id="btn_simpan_sppb_barang"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD BUKAN DARI BARANG MASTER-->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Sppb Barang</h4>
                <small class="font-bold">Silakan edit data sppb barang</small>
            </div>
            <?php $attributes = array("id_sppb_barang2" => "contact_form", "id" => "contact_form");
            echo form_open("sppb_barang/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">ID Sppb Barang</label>
                        <div class="col-xs-9">
                            <input name="ID_SPPB_BARANG2" id="ID_SPPB_BARANG2" class="form-control" type="text" placeholder="ID sppb barang" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">ID Barang Master</label>
                        <div class="col-xs-9">
                            <input name="ID_BARANG_MASTER2" id="ID_BARANG_MASTER2" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Kode Barang</label>
                        <div class="col-xs-9">
                            <input name="KODE_BARANG2" id="KODE_BARANG2" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama</label>
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
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG2" id="JUMLAH_BARANG2" class="form-control touchspin1" type="number">
                        </div>
                    </div>

                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Update</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Data sppb barang</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
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
    function goBack() {
        location.replace("<?php echo base_url(); ?>sppb")
    }

    function goToRasdBarang() {
        let id_rasd = $('#ID_RASD').val();
        if (id_rasd) {
            window.open("<?php echo base_url(); ?>rasd_barang/view/" + id_rasd)
        } else {
            $('#alert-msg').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> Pastikan anda pilih lokasi untuk melihat barang RASD </div>');
        }
    }
    $(document).ready(function() {
        let id_sppb = <?php echo $id_sppb  ?>;
        tampil_data_sppb_barang(); //pemanggilan fungsi tampil data.

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
        function tampil_data_sppb_barang() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>sppb_barang/data_sppb_barang',
                async: false,
                dataType: 'json',
                data: {
                    id: id_sppb
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_MINTA;
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
                            '<td>' + kode_barang + '</td>' +
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
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-info btn-xs item_edit block" data="' + data[i].ID_SPPB_BARANG + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_SPPB_BARANG + '"><i class="fa fa-trash"></i> Hapus</a>' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        // SIMPAN SPPB DAN KEMBALI KE SPPB LIST
        $('#btn_simpan_sppb').on('click', function() {
            let ID_SPPB = id_sppb;
            let CTT = $('#CTT').val();

        })

        //GET UPDATE
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('sppb_barang/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalaEdit').modal('show');
                        $('[name="ID_SPPB_BARANG2"]').val(data.ID_SPPB_BARANG);
                        // $('[name="ID_BARANG_MASTER2"]').val(data.ID_BARANG_MASTER);
                        $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                        $('[name="NAMA2"]').val(data.NAMA_MASTER);
                        $('[name="MEREK2"]').val(data.MEREK_MASTER);
                        $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_SPPB);
                        $('#alert-msg-2').html('<div></div>');
                    });
                }
            });
            return false;
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('sppb_barang/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(id);
                        if (data.NAMA_SPPB != null) {
                            $('#NAMA_3').html('Sppb Barang : ' + data.NAMA_SPPB);
                        } else if (data.NAMA_RASD != null) {
                            $('#NAMA_3').html('Nama Rasd : ' + data.NAMA_RASD);
                        } else if (data.NAMA_MASTER != null) {
                            $('#NAMA_3').html('Nama Master : ' + data.NAMA_MASTER);
                        }
                    });
                }
            });
        });

        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });

        //SIMPAN DATA
        $('#btn_simpan_sppb_barang').click(function() {
            var form_data = {
                ID_SPPB: id_sppb,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('sppb_barang/simpan_data'); ?>",
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

            let ID_SPPB_BARANG = $('#ID_SPPB_BARANG2').val();
            // let ID_BARANG_MASTER = $('#ID_BARANG_MASTER2').val();
            let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
            $.ajax({
                url: "<?php echo site_url('sppb_barang/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPPB_BARANG: ID_SPPB_BARANG,
                    // ID_BARANG_MASTER: ID_BARANG_MASTER,
                    JUMLAH_BARANG: JUMLAH_BARANG
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalaEdit').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
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
                url: "<?php echo base_url('sppb_barang/hapus_data') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    $('#ModalHapus').modal('hide');
                    // tampil_data_jenis_barang();
                    window.location.reload();
                }
            });
            return false;
        });
    });
</script>

</body>

</html>