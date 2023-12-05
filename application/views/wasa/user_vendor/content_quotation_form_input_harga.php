<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Input Quotation</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/RFQ/') ?>">RFQ</a>
            </li>
            <li class="active">
                <strong>
                    <a>Quotation</a>
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
                    <h5>Input Quotation</h5>
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
                        if (isset($QUOTATION)) {
                            foreach ($QUOTATION->result() as $QUOTATION) :
                        ?>

                                <div class="form-group"><label class="col-sm-2 control-label">No Urut RFQ</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $QUOTATION->NO_URUT_RFQ; ?>" disabled></div>
                                </div>

                        <?php endforeach;
                        } ?>


                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi Penyerahan</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_LOKASI_PENYERAHAN; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Vendor</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_VENDOR; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Term Of Payment</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_TERM_OF_PAYMENT; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Nama PIC Vendor</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $NAMA_PIC_VENDOR; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Email PIC Vendor</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $EMAIL_PIC_VENDOR; ?>" disabled></div>
                        </div>

                        <div class="form-group"><label class="col-sm-2 control-label">Batas akhir pengisian RFQ</label>
                            <div class="col-sm-10">
                                <input name="BATAS_AKHIR" id="BATAS_AKHIR" class="form-control" type="date" value="<?php echo $BATAS_AKHIR; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Quotation Item Barang/Jasa</h5>
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
                                    Pastikan telah data diisi dengan benar.
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
                                                <th>Input Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_data">

                                        </tbody>

                                    </table>
                                </div>

                                <div id="alert-msg-6"></div>
                                <!-- <br>
                                <a href="#" class="btn btn-info" data-toggle="modal" data-target="#ModalAddNew"><span class="fa fa-plus"></span> Ajukan Item Alternatif</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Identitas Form RFQ -->
            <?php if ($FILE == "ADA") { ?>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Download/Upload Dokumen Quotation</h5>
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
                        <div class="row">
                            <div class="col-lg-9 animated fadeInRight">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <?php foreach ($dokumen as $quotation_form_file) {
                                            if ($quotation_form_file->JENIS_FILE == "Dokumen List Harga" || $quotation_form_file->JENIS_FILE == "Dokumen Lainnya") { ?>

                                                <div class="file-box">
                                                    <div class="file">
                                                        <a href="#">
                                                            <span class="corner"></span>

                                                            <?php if ($quotation_form_file->JENIS_FILE == "Gambar Produk") {
                                                                echo ("<div class='image'>
										<img alt='image' class='img-responsive' 
										src='" . base_url() . $quotation_form_file->KETERANGAN . "'></div>");
                                                            } else {
                                                                echo ("<div class='icon'>
										<i class='fa fa-file'></i>
										</div>");
                                                            } ?>

                                                            <div class="file-name">
                                                                <a href="<?php echo base_url(); ?>assets/upload_quotation_form_file/<?php echo $quotation_form_file->DOK_FILE; ?>">Download file</a>
                                                                <br />
                                                                <small>Jenis file: <?php echo $quotation_form_file->JENIS_FILE; ?></small>
                                                                <br />
                                                                <small>Diupload: <?php echo $quotation_form_file->TANGGAL_UPLOAD; ?></small>
                                                            </div>
                                                            <input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>quotation_form/hapus_file/<?php echo $quotation_form_file->DOK_FILE; ?>';" value="Hapus" />
                                                        </a>
                                                    </div>
                                                </div>

                                        <?php }
                                        } ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_QUOTATION; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen Quotation</a>
                    </div>
                </div>
            <?php } else { ?>
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Download/Upload Dokumen Quotation</h5>
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
                        <div class="row">
                            <div class="col-lg-9 animated fadeInRight">
                                <div class="row">
                                    <div class="col-lg-12">
                                        Belum ada file dokumen. Silakan upload file dokumen.
                                    </div>
                                </div>
                            </div>
                        </div>
                        </br>
                        </br>
                        <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_QUOTATION; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen Quotation</a>
                    </div>
                </div>
            <?php } ?>

            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="sm-10">
                            <a href="<?php echo base_url('Quotation_form/view/') ?><?php echo $HASH_MD5_QUOTATION; ?>" class="btn btn-primary"><i class="fa fa-save"></i> Simpan Dan Kembali Ke RFQ</a> <br>
                            <a href="javascript:;" class="btn btn-success" data-toggle="modal" data-target="#ModalEditKirimQUOTATION"><span class="fa fa-send"></span> Ajukan Quotation </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Form RFQ -->
    </div>
</div>

<!-- MODAL EDIT HARGA-->
<div class="modal inmodal fade" id="ModalEditHarga" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Harga Satuan Barang/Jasa</h4>
                <small class="font-bold">Silakan berikan harga atas item barang/jasa</small>
            </div>
            <?php $attributes = array("ID_RFQ_barang5" => "contact_form", "id" => "contact_form");
            echo form_open("RFQ_form/update_data_justifikasi_barang", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_QUOTATION5" id="ID_QUOTATION5" class="form-control" type="text" value="<?php echo $ID_QUOTATION; ?>" placeholder="ID_QUOTATION" readonly>

                    <input name="ID_QUOTATION_FORM5" id="ID_QUOTATION_FORM5" class="form-control" type="text" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA5" id="NAMA5" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek</label>
                        <div class="col-xs-9">
                            <input name="MEREK5" id="MEREK5" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT5" id="SPESIFIKASI_SINGKAT5" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG5" id="JUMLAH_BARANG5" class="form-control" type="number" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <select name="SATUAN_BARANG5" class="form-control" id="SATUAN_BARANG5" disabled>
                                <option value=''>- Pilih Satuan Barang -</option>
                                <?php foreach ($satuan_barang_list as $item) {
                                    echo '<option value="' . $item->ID_SATUAN_BARANG . '">' . $item->NAMA_SATUAN_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <label class="col-xs-3 control-label">Kesanggupan Pengadaan </label>
                        <div class="col-xs-9">
                            <div class="col-xs-6">
                                <label>
                                    <input type="radio"  value="Menyanggupi" id="Menyanggupi" name="MyRadio"> &nbsp;Menyanggupi
                                </label>
                            </div>
                            <div class="col-xs-5">
                                <label>
                                    <input type="radio"  value="Tidak Menyanggupi" id="Tidak_Menyanggupi" name="MyRadio"> &nbsp;Tidak Menyanggupi
                                </label>
                            </div>
                            <input type="text" id="PEKERJAAN" name="PEKERJAAN" style="display: none;">
                        </div>
                    </div>

                    <div id="show_hidden_harga" class="form-group" hidden>
                        <label class="control-label col-xs-3">Harga Satuan Barang (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG5" id="HARGA_SATUAN_BARANG5" class="form-control" type="number">
                        </div>
                    </div>

                    <div id="show_hidden_total_harga" class="form-group" hidden>
                        <label class="control-label col-xs-3">Total Harga (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_TOTAL5" id="HARGA_TOTAL5" class="form-control" type="hidden" disabled>
                            <input name="HARGA_TOTAL_TAMPIL5" id="HARGA_TOTAL_TAMPIL5" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <div id="show_hidden_nama_alternatif" class="form-group" hidden>
                        <label class="control-label col-xs-3">Nama Barang Alternatif</label>
                        <div class="col-xs-9">
                            <input name="NAMA_4" id="NAMA_4" class="form-control" type="text" placeholder="Contoh : Crane" required autofocus>
                        </div>
                    </div>

                    <div id="show_hidden_merk_alternatif" class="form-group" hidden>
                        <label class="control-label col-xs-3">Merek Barang Alternatif</label>
                        <div class="col-xs-9">
                            <input name="MEREK_4" id="MEREK_4" class="form-control" type="text" placeholder="Contoh : Toyota etc" required autofocus>
                        </div>
                    </div>

                    <div id="show_hidden_spesifikasi_alternatif" class="form-group" hidden>
                        <label class="control-label col-xs-3">Spesifikasi Singkat Alternatif</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_4" id="SPESIFIKASI_SINGKAT_4" class="form-control" type="text" placeholder="Contoh: Mata Gerindra Stainless Grinding ukuran 4 inch" required autofocus>
                        </div>
                    </div>

                    <div id="show_hidden_jumlah_alternatif" class="form-group" hidden>
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="JUMLAH_BARANG_4" id="JUMLAH_BARANG_4" placeholder="Contoh: 20">
                        </div>
                    </div>

                    <div id="show_hidden_satuan_alternatif" class="form-group" hidden>
                        <label class="control-label col-xs-3">Satuan Barang Alternatif</label>
                        <div class="col-xs-9">
                            <select name="SATUAN_BARANG_4" class="form-control" id="SATUAN_BARANG_4">
                                <option value=''>- Pilih Satuan Barang -</option>
                                <?php foreach ($satuan_barang_list as $item) {
                                    echo '<option value="' . $item->ID_SATUAN_BARANG . '">' . $item->NAMA_SATUAN_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_harga_alternatif" class="form-group" hidden>
                        <label class="control-label col-xs-3">Harga Satuan Barang (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_4" id="HARGA_SATUAN_BARANG_4" class="form-control" type="number" placeholder="Contoh: Rp 200000">
                        </div>
                    </div>

                    <div id="show_hidden_total_harga_alternatif" class="form-group" hidden>
                        <label class="control-label col-xs-3">Total Harga (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_TOTAL_4" id="HARGA_TOTAL_4" class="form-control" type="hidden" disabled>
                            <input name="HARGA_TOTAL_TAMPIL_4" id="HARGA_TOTAL_TAMPIL_4" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <div id="show_hidden_keterangan_alternatif" class="form-group" hidden>
                        <label class="control-label col-xs-3">Keterangan Barang Alternatif</label>
                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="KETERANGAN_VENDOR_4" id="KETERANGAN_VENDOR_4" placeholder="Contoh: Barang yang diminta sudah discontinue. Saat ini yang tersedia adalah tipe ini." required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-5"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <div id="show_hidden_btn_harga" hidden>
                        <button class="btn btn-primary" id="btn_update_harga_barang"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                    <div id="show_hidden_btn_alternatif" hidden>
                        <button class="btn btn-primary" id="btn_simpan_data_barang_alternatif"><i class="fa fa-save"></i> Tambah</button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT HARGA-->

<!-- MODAL KIRIM RFQ-->
<div class="modal inmodal fade" id="ModalEditKirimQUOTATION" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Lanjutkan Proses Quotation</h4>
                <small class="font-bold">Selesaikan pengisian Form Quotation ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("HASH_MD5_QUOTATION7" => "contact_form", "id" => "contact_form");
            echo form_open("RFQ_form/update_data_kirim_rfq", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="HASH_MD5_QUOTATION7" id="HASH_MD5_QUOTATION7" class="form-control" type="hidden" value="<?php echo $HASH_MD5_QUOTATION; ?>" placeholder="HASH MD5 QUOTATION" readonly>

                    <div class="form-group">
                        <div class="i-checks"><input type="checkbox" id="saya_setuju">
                            Saya telah selesai melakukan proses input quotation dan menyetujui untuk diproses lebih lanjut.
                        </div>
                    </div>

                    <div id="alert-msg-7"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_quotation" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM RFQ-->

<!-- MODAL EDIT GAMBAR -->
<div class="modal inmodal fade" id="ModalEditGambar" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Upload Dokumen Quotation</h4>
                <small class="font-bold">Silakan Upload Dokumen Quotation</small>
            </div>
            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-info alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        Silakan upload file dokumen sesuai dengan ketentuan .
                    </div>


                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Upload File Dokumen</h5>
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


                                    <p>
                                        File dokumen yang Anda upload akan digunakan untuk keperluan barang master, dengan ketentuan sebagai berikut:
                                    <ul class="sortable-list connectList agile-list" id="ketentuan">
                                        <li class="warning-element" id="task1">
                                            1. File dokumen yang diupload harus merupakan data berkaitan dengan barang master.
                                        </li>
                                        <li class="danger-element" id="task2">
                                            2. Ukuran dokumen yang diterima sistem maksimal 5 Mega Bytes (5 MB).
                                        </li>
                                        <li class="success-element" id="task4">
                                            3. Ekstensi/tipe file yang diterima sistem adalah .PDF dan .JPEG/.JPG/.BMP.
                                        </li>

                                        <li class="warning-element" id="task1">
                                            4. Pilih jenis File Dokumen sebelum melakukan upload.
                                            </br>

                                        </li>

                                    </ul>
                                    </p>


                                    <form action="#" class="dropzone" id="dropzoneForm">

                                        </br>
                                        <div class="col-xs-9">
                                            <select name="JENIS_FILE" id="JENIS_FILE">
                                                <option value='Dokumen List Harga'>Dokumen List Harga</option>
                                                <option value='Dokumen Lainnya'>Dokumen Lainnya</option>
                                            </select>
                                        </div>
                                        </br>
                                        </br>
                                        </br>
                                        </br>
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>
                                    </form>

                                    <div>
                                        </br>
                                        <button class="btn btn-primary" name="btn_upload" id="btn_upload"><i class="fa fa-save"></i> Upload</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    </br>
                    </br></br>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL EDIT GAMBAR-->

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- TouchSpin -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<!-- DROPZONE -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dropzone/dropzone.js"></script>


<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    Dropzone.autoDiscover = false;

    Dropzone.options.dropzoneForm = {
        paramName: "file", // The name that will be used to transfer the file
        autoProcessQueue: false,
        maxFilesize: 1500, // MB
        maxFiles: 1,
        dictDefaultMessage: "<strong>Letakkan file di sini atau klik untuk memuat file. </strong></br> (Pastikan file yang Anda upload sesuai dengan ketentuan)",
        dictFileTooBig: "Maaf ukuran file tidak sesuai ketentuan."
    };
    $(document).ready(function() {
        if (document.getElementById('dropzoneForm')) {
            var file_upload = new Dropzone(".dropzone", {
                url: "<?php echo base_url('Quotation_form/proses_upload_file') ?>",
                maxFilesize: 1500, // MB
                method: "post",
                acceptedFiles: "image/jpeg,image/png,image/jpg,image/bmp,application/pdf",
                paramName: "userfile",
                dictInvalidFileType: "Maaf ekstensi/tipe file tidak sesuai ketentuan.",
                addRemoveLinks: true,
                init: function() {
                    var myDropzone = this;

                    // Update selector to match your button
                    $("#btn_upload").click(function(e) {
                        e.preventDefault();
                        myDropzone.processQueue();
                        var form_data = {
                            JENIS_FILE: $('#JENIS_FILE').val()
                        };
                        $.ajax({
                            url: "<?php echo base_url('Quotation_form/proses_upload_file') ?>",
                            type: 'POST',
                            data: form_data,
                            // success: function(data) {
                            //     if (data != '') {
                            //         console.log("waduh");
                            //     } else {
                            //         console.log("waduh 2");
                            //         location.reload();
                            //     }
                            // }
                        });
                    });


                    this.on("success", function(file, responseText) {
                        location.reload();;
                        // console.log(file);
                        // console.log(responseText);
                    });
                }
            });

            //Event ketika Memulai mengupload
            file_upload.on("sending", function(a, b, c) {
                a.token = Math.random();
                c.append("token_npwp", a.token); //Mempersiapkan token untuk masing masing npwp
            });

            // jumlah-+
            $(".touchspin1").TouchSpin({
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white',
                min: 0,
                max: 99999999999,
            });


            //Event ketika data dihapus
            file_upload.on("removedfile", function(a) {
                var token = a.token;
                $.ajax({
                    type: "post",
                    data: {
                        token: token
                    },
                    url: "<?php echo base_url('RFQ_form/remove_file') ?>",
                    cache: false,
                    dataType: 'json',
                    success: function() {
                        console.log("Data terhapus");
                    },
                    error: function() {
                        console.log("Error");
                    }
                });
            });
        }

        var ID_SPPB = <?php echo $ID_SPPB;  ?>;
        var ID_RFQ = <?php echo $ID_RFQ;  ?>;
        var ID_QUOTATION = <?php echo $ID_QUOTATION;  ?>;

        $("#HARGA_SATUAN_BARANG_4").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_4").val();
            console.log(HARGA);
            var JUMLAH = $("#JUMLAH_BARANG_4").val();
            console.log(JUMLAH);

            var TOTAL = HARGA * JUMLAH;
            console.log(TOTAL);

            $('[name="HARGA_TOTAL_4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });

        $("#HARGA_SATUAN_BARANG5").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG5").val();
            console.log(HARGA);
            var JUMLAH = $("#JUMLAH_BARANG5").val();
            console.log(JUMLAH);

            var TOTAL = HARGA * JUMLAH;
            console.log(TOTAL);

            $('[name="HARGA_TOTAL5"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL5"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });

        tampil_data_form_quotation(); //pemanggilan fungsi tampil data.

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
                    extend: 'excel',
                    title: '<?php echo $title ?>',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                },
                {
                    extend: 'print',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    customize: function(win) {
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');

                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    },
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
                    },
                }
            ]

        });

        //fungsi tampil data
        function tampil_data_form_quotation() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>Quotation_form/data_quotation_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_QUOTATION
                },
                success: function(data) {
                    console.log(data);
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_BARANG;
                        let jumlah_barang_alternatif = data[i].JUMLAH_BARANG_ALTERNATIF;
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
                            '<td>' + data[i].NAMA_BARANG + '<br>' + data[i].NAMA_BARANG_ALTERNATIF + '</td>' +
                            '<td>' + data[i].MEREK + '<br>' + data[i].MEREK_ALTERNATIF + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '<br>' + data[i].SPESIFIKASI_SINGKAT_ALTERNATIF + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '<br>' + data[i].NAMA_SATUAN_BARANG_ALTERNATIF + '</td>' +
                            '<td>' + jumlah_barang + '<br>' + jumlah_barang_alternatif + '</td>' +
                            '<td> Rp ' + data[i].HARGA_SATUAN_BARANG + '<br> Rp ' + data[i].HARGA_SATUAN_BARANG_ALTERNATIF + '</td>' +
                            '<td> Rp ' + data[i].HARGA_TOTAL + '<br> Rp ' + data[i].HARGA_TOTAL_ALTERNATIF + '</td>' +
                            '<td>' + data[i].KETERANGAN_VENDOR + '<br>' + data[i].KETERANGAN_VENDOR_ALTERNATIF + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-success btn-xs item_edit_harga block" data="' + data[i].ID_QUOTATION_FORM + '"> Harga </a>' + ' ' +
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
        $('#btn_update_harga_barang').on('click', function() {

            let ID_QUOTATION_FORM = $('#ID_QUOTATION_FORM5').val();
            let HARGA_SATUAN_BARANG = $('#HARGA_SATUAN_BARANG5').val();
            let HARGA_TOTAL = $('#HARGA_TOTAL5').val();
            $.ajax({
                url: "<?php echo site_url('Quotation_form/update_data_harga_barang') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_QUOTATION_FORM: ID_QUOTATION_FORM,
                    HARGA_SATUAN_BARANG: HARGA_SATUAN_BARANG,
                    HARGA_TOTAL: HARGA_TOTAL,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditHarga').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //SIMPAN DATA
        $('#btn_simpan_data_barang_alternatif').click(function() {
            var form_data = {
                ID_QUOTATION: $('#ID_QUOTATION5').val(),
                ID_QUOTATION_FORM: $('#ID_QUOTATION_FORM5').val(),
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                HARGA_SATUAN_BARANG: $('#HARGA_SATUAN_BARANG_4').val(),
                HARGA_TOTAL: $('#HARGA_TOTAL_4').val(),
                KETERANGAN_VENDOR: $('#KETERANGAN_VENDOR_4').val()
            };
            $.ajax({
                url: "<?php echo site_url('Quotation_form/simpan_data_barang_alternatif'); ?>",
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
        $('#btn_simpan_rfq').click(function() {
            var HASH_MD5_RFQ = $('#HASH_MD5_RFQ').val()
            var alamat = "<?php echo base_url('RFQ_form/index/'); ?>" + HASH_MD5_RFQ;
            window.open(
                alamat,
                '_self' // <- This is what makes it open in a new window.
            );
        });

        //GET UDPATE untuk berikan justifkasi
        $('#show_data').on('click', '.item_edit_harga', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('Quotation_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditHarga').modal('show');
                        $('[name="ID_QUOTATION_FORM5"]').val(data.ID_QUOTATION_FORM);
                        $('[name="NAMA5"]').val(data.NAMA_BARANG);
                        $('[name="MEREK5"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT5"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG5"]').val(data.JUMLAH_BARANG);
                        $('[name="SATUAN_BARANG5"]').val(data.ID_SATUAN_BARANG);
                        $('[name="KESANGGUPAN_PENGADAAN5"]').val(data.KESANGGUPAN_PENGADAAN);
                        $('[name="HARGA_SATUAN_BARANG5"]').val(data.HARGA_SATUAN_BARANG);
                        $('[name="HARGA_TOTAL5"]').val(data.HARGA_TOTAL);
                        $('[name="HARGA_TOTAL_TAMPIL5"]').val(new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data.HARGA_TOTAL));
                        $('[name="KETERANGAN5"]').val(data.KETERANGAN);
                        $('#alert-msg-5').html('<div></div>');
                    });
                }
            });
            return false;
        });

        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999,
        });

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_quotation').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_quotation').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM SPPB 
        $('#btn_update_kirim_quotation').on('click', function() {

            let HASH_MD5_QUOTATION = $('#HASH_MD5_QUOTATION7').val();
            $.ajax({
                url: "<?php echo site_url('Quotation_form/update_data_kirim_quotation') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    HASH_MD5_QUOTATION: HASH_MD5_QUOTATION,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimQUOTATION').modal('hide');
                        window.location.href = '<?php echo base_url('Quotation_form/view/') ?><?php echo $HASH_MD5_QUOTATION; ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        $('input:radio[name="MyRadio"]').change(function() {
            if ($(this).val() == 'Menyanggupi') {
                $('#show_hidden_harga').attr("hidden", false);
                $('#show_hidden_total_harga').attr("hidden", false);
                $('#show_hidden_btn_harga').attr("hidden", false);

                $('#show_hidden_nama_alternatif').attr("hidden", true);
                $('#show_hidden_merk_alternatif').attr("hidden", true);
                $('#show_hidden_spesifikasi_alternatif').attr("hidden", true);
                $('#show_hidden_jumlah_alternatif').attr("hidden", true);
                $('#show_hidden_satuan_alternatif').attr("hidden", true);
                $('#show_hidden_harga_alternatif').attr("hidden", true);
                $('#show_hidden_total_harga_alternatif').attr("hidden", true);
                $('#show_hidden_keterangan_alternatif').attr("hidden", true);
                $('#show_hidden_btn_alternatif').attr("hidden", true);


                // Menggunakan ajax untuk mengirim dan dan menerima data dari server
                // $.ajax({
                //     url: "<?php echo base_url(); ?>/FSTB/get_data_proyek",
                //     method: "POST",
                //     async: false,
                //     dataType: 'json',
                //     success: function(data) {
                //         var html = '';
                //         var i;

                //         html = "<option value=''>- Pilih Proyek -</option>";

                //         for (i = 0; i < data.length; i++) {
                //             html += '<option value=' + data[i].ID_PROYEK + '>' + data[i].NAMA_PROYEK + '</option>';
                //         }
                //         $('#ID_PROYEK_1').html(html);
                //     }
                // });
            } else if ($(this).val() == 'Tidak Menyanggupi') {
                $('#show_hidden_nama_alternatif').attr("hidden", false);
                $('#show_hidden_merk_alternatif').attr("hidden", false);
                $('#show_hidden_spesifikasi_alternatif').attr("hidden", false);
                $('#show_hidden_jumlah_alternatif').attr("hidden", false);
                $('#show_hidden_satuan_alternatif').attr("hidden", false);
                $('#show_hidden_harga_alternatif').attr("hidden", false);
                $('#show_hidden_total_harga_alternatif').attr("hidden", false);
                $('#show_hidden_keterangan_alternatif').attr("hidden", false);
                $('#show_hidden_btn_alternatif').attr("hidden", false);

                $('#show_hidden_harga').attr("hidden", true);
                $('#show_hidden_total_harga').attr("hidden", true);
                $('#show_hidden_btn_harga').attr("hidden", true);

                // Menggunakan ajax untuk mengirim dan dan menerima data dari server
                // $.ajax({
                //     url: "<?php echo base_url(); ?>/FSTB/get_data_proyek",
                //     method: "POST",
                //     async: false,
                //     dataType: 'json',
                //     success: function(data) {
                //         var html = '';
                //         var i;

                //         html = "<option value=''>- Pilih Proyek -</option>";

                //         for (i = 0; i < data.length; i++) {
                //             html += '<option value=' + data[i].ID_PROYEK + '>' + data[i].NAMA_PROYEK + '</option>';
                //         }
                //         $('#ID_PROYEK_2').html(html);
                //     }
                // });
            } else {
                $('#show_hidden_harga').attr("hidden", true);
                $('#show_hidden_total_harga').attr("hidden", true);
                $('#show_hidden_btn_harga').attr("hidden", true);

                $('#show_hidden_nama_alternatif').attr("hidden", true);
                $('#show_hidden_merk_alternatif').attr("hidden", true);
                $('#show_hidden_spesifikasi_alternatif').attr("hidden", true);
                $('#show_hidden_jumlah_alternatif').attr("hidden", true);
                $('#show_hidden_satuan_alternatif').attr("hidden", true);
                $('#show_hidden_harga_alternatif').attr("hidden", true);
                $('#show_hidden_total_harga_alternatif').attr("hidden", true);
                $('#show_hidden_keterangan_alternatif').attr("hidden", true);
                $('#show_hidden_btn_alternatif').attr("hidden", true);
            }
        });

        //GET UPDATE untuk Edit Gambar
        item_edit_upload_gambar.onclick = function() {
            $('#ModalEditGambar').modal('show');

        };

    });
</script>

</body>

</html>