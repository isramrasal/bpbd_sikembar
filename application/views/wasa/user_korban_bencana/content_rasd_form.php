<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form RASD</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/RASD/') ?>">RASD</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form RASD</a>
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

    <div class="alert alert-info alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Sistem menampilkan seluruh isi RASD Proyek.
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian RASD Proyek</h5>
        </div>
        <div class="ibox-content">
            <form method="get" class="form-horizontal">
                <?php
                if (isset($rasd)) {
                    foreach ($rasd->result() as $rasd) :
                ?>
                        <div class="form-group"><label class="col-sm-2 control-label">Nama Proyek</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rasd->NAMA_PROYEK; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Pekerjaan</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rasd->NAMA_SUB_PEKERJAAN; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Kategori RAB</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rasd->NAMA_KATEGORI; ?>" disabled>
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
                    <h5>RASD Item Barang</h5>
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

                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddTanpaBarangMaster"><span class="fa fa-plus"></span> Tambah Item Barang/Jasa</a>
                    </br>
                    <a href="javascript:;" id="item_edit_upload_excel" name="item_edit_upload_excel" class="btn btn-primary" data="<?php echo $HASH_MD5_RASD; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Tambah Item Barang/Jasa Secara Bulk</a>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <th>Nama Barang/Jasa</th>
                                    <th>Merek Barang/Jasa</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Jumlah Barang/Jasa</th>
                                    <th>Satuan Barang/Jasa</th>
                                    <th>Unit Price</th>
                                    <th>Total Harga</th>
                                    <th>Realisasi (Qty)</th>
                                    <th>Realisasi (Rupiah)</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    
                    

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Item Deviasi</h5>
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
                        <table class="table table-striped table-bordered table-hover" id="mydata_deviasi">
                            <thead>
                                <tr>
                                    <th>Nama Barang/Jasa</th>
                                    <th>Merek Barang/Jasa</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Jumlah Barang/Jasa</th>
                                    <th>Satuan Barang/Jasa</th>
                                    <th>Unit Price</th>
                                    <th>Total Harga</th>
                                    <th>Realisasi (Qty)</th>
                                    <th>Realisasi (Rupiah)</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="show_data_deviasi">

                            </tbody>

                        </table>
                    </div>
                    
                    

                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD BUKAN DARI MASTER LIST -->
<div class="modal inmodal fade" id="ModalAddTanpaBarangMaster" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">RASD Form Item Barang</h4>
                <small class="font-bold">Silakan isi data RASD</small>
            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("RASD_form/simpan_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang/Jasa</label>
                        <div class="col-xs-9">
                            <input name="NAMA_4" id="NAMA_4" class="form-control" type="text" placeholder="Contoh: Crane" required autofocus>
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang/Jasa</label>
                        <div class="col-xs-9">
                            <input name="MEREK_4" id="MEREK_4" class="form-control" type="text" placeholder="Contoh: Toyota" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_4" id="SPESIFIKASI_SINGKAT_4" class="form-control" type="text" placeholder="Contoh: Crane Toyota 4 ton, 12 roda" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="SATUAN_BARANG_4" id="SATUAN_BARANG_4" class="form-control" type="text"
                                placeholder="Contoh : Pcs">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input class="touchspin1" type="number" value="0" name="JUMLAH_BARANG_4" id="JUMLAH_BARANG_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Satuan Barang (Unit Price)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_FIX4" id="HARGA_SATUAN_BARANG_FIX4" class="touchspin2" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Total Barang (Pembulatan Ke Bawah)</label>
                        <div class="col-xs-9">

                            <input name="HARGA_TOTAL_FIX4" id="HARGA_TOTAL_FIX4" class="form-control" type="hidden" placeholder="Contoh: Rp 14000000 " disabled />
                            <input name="HARGA_TOTAL_TAMPIL4" id="HARGA_TOTAL_TAMPIL4" class="form-control" type="text" placeholder="Contoh: Rp 14000000 " disabled>
                        </div>
                    </div>

                    <div id="alert-msg1"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD BUKAN DARI MASTER LIST-->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">RASD Item Barang</h4>
                <small class="font-bold">Silakan edit data RASD item barang</small>
            </div>
            <?php $attributes = array("ID_RASD_FORM2" => "contact_form", "id" => "contact_form");
            echo form_open("RASD_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_RASD_FORM2" id="ID_RASD_FORM2" class="form-control" type="hidden" placeholder="ID rasd barang" readonly>

                    <input name="ID_BARANG_MASTER2" id="ID_BARANG_MASTER2" class="form-control" placeholder="Barang belum ada di Master List" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang/Jasa</label>
                        <div class="col-xs-9">
                            <input name="NAMA2" id="NAMA2" class="form-control" type="text"placeholder="Contoh: Crane" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang/Jasa</label>
                        <div class="col-xs-9">
                            <input name="MEREK2" id="MEREK2" class="form-control" type="text" placeholder="Contoh: Toyota" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT2" id="SPESIFIKASI_SINGKAT2" class="form-control" type="text" placeholder="Contoh: Crane Toyota 4 ton, 12 roda" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="SATUAN_BARANG2" id="SATUAN_BARANG2" class="form-control" type="text"
                                placeholder="Contoh : Pcs">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG2" id="JUMLAH_BARANG2" class="form-control touchspin1" type="number">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Satuan Barang (Unit Price)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_FIX2" id="HARGA_SATUAN_BARANG_FIX2" class="touchspin2" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Total Barang (Pembulatan Ke Bawah)</label>
                        <div class="col-xs-9">

                            <input name="HARGA_TOTAL_FIX2" id="HARGA_TOTAL_FIX2" class="form-control" type="hidden" placeholder="Contoh: Rp 14000000 " disabled />
                            <input name="HARGA_TOTAL_TAMPIL2" id="HARGA_TOTAL_TAMPIL2" class="form-control" type="text" placeholder="Contoh: Rp 14000000 " disabled>
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

<!-- MODAL REALISASI -->
<div class="modal inmodal fade" id="ModalRealisasi" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 70vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Realisasi Item Barang/Jasa RASD</h4>
            </div>

            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang/Jasa</label>
                        <div class="col-xs-9">
                            <input name="NAMA3" id="NAMA3" class="form-control" type="text" disabled >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang/Jasa</label>
                        <div class="col-xs-9">
                            <input name="MEREK3" id="MEREK3" class="form-control" type="text" disabled >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT3" id="SPESIFIKASI_SINGKAT3" class="form-control" type="text" disabled >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="SATUAN_BARANG3" id="SATUAN_BARANG3" class="form-control" type="text"
                            disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG3" id="JUMLAH_BARANG3" class="form-control" type="number" disabled>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Satuan Barang (Unit Price)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_FIX3" id="HARGA_SATUAN_BARANG_FIX3" class="form-control" type="text" placeholder="Contoh: Rp 14000000 " disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Total Barang (Pembulatan Ke Bawah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_TOTAL_TAMPIL3" id="HARGA_TOTAL_TAMPIL3" class="form-control" type="text" placeholder="Contoh: Rp 14000000 " disabled>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata_rasd_realisasi">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Merek</th>
                                    <th>Satuan Barang/Jasa</th>
                                    <th>Jumlah Barang/Jasa</th>
                                    <th>Unit Price</th>
                                    <th>Total Harga</th>
                                    <th>SPP</th>
                                </tr>
                            </thead>
                            <tbody id="show_data_rasd_realisasi">

                            </tbody>

                        </table>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
<!--END MODAL REALISASI -->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Data RASD Item Barang</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="ID_RASD_FORM_3" id="ID_RASD_FORM_3" disabled>
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
                        <div name="NAMA_BARANG_3" id="NAMA_BARANG_3"></div>
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

<!-- MODAL UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalEditExcel" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Upload Item Barang/Jasa Secara Bulk</h4>
                <small class="font-bold">Silakan Upload Item Barang/Jasa Secara Bulk</small>
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
                                        File dokumen yang Anda upload akan digunakan untuk keperluan pengisian item barang/jasa RASD/RAB, dengan ketentuan sebagai berikut:
                                    <ul class="sortable-list connectList agile-list" id="ketentuan">
                                        <li class="warning-element" id="task1">
                                            1. File dokumen yang diupload harus merupakan data berkaitan dengan RASD/RAB.
                                        </li>
                                        <li class="danger-element" id="task2">
                                            2. Ukuran dokumen yang diterima sistem maksimal 1.5 Giga Bytes (1.5 GB).
                                        </li>
                                        <li class="success-element" id="task4">
                                            3. Ekstensi/tipe file yang diterima sistem adalah .XLSX
                                        </li>
                                        <li class="warning-element" id="task1">
                                            4. File yang diupload berdasarkan template bulk. <a href="<?php echo base_url(); ?>assets/template/template_rasd.xlsx">Download file template bulk khusus RASD/RAB</a>
                                            </br>
                                        </li>
                                    </ul>
                                    </p>

                                    <form action="#" class="dropzone" id="dropzoneForm">

                                        </br>
                                        <div class="col-xs-9">
                                            <input name="JENIS_FILE_3" id="JENIS_FILE_3" type="hidden" value="Dokumen Bulk SPPB" readonly>
                                        </div>
                                        </br>
                                        </br>
                                        </br>
                                        </br>
                                        <div class="fallback">
                                            <input name="file" type="file" />
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
<!--END MODAL UPLOAD DOCUMENT-->

<!-- MODAL GAGAL UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalGagalExcel" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 45vw;">
        <div class="modal-content animated bounceInRight">

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        Proses upload gagal. Terdapat simbol yang tidak bisa diproses: mengandung tanda petik dan semicolon.
                        <br>
                        <br>
                        Mohon cek kembali dokumen excel dan upload ulang kembali.
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="btn_gagal_upload"><i class="fa fa-window-close"></i>
                        Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL UPLOAD DOCUMENT-->


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

<!-- DROPZONE -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dropzone/dropzone.js"></script>

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

    function goBack() {
        window.history.back();
    }
    $(document).ready(function() {

        if (document.getElementById('dropzoneForm')) {
            var file_upload = new Dropzone(".dropzone", {
                url: "<?php echo base_url('index.php/RASD_form/proses_upload_file_excel') ?>",
                maxFilesize: 1500, // MB
                method: "post",
                acceptedFiles: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
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
                            JENIS_FILE: $('#JENIS_FILE_3').val()
                        };
                        $.ajax({
                            url: "<?php echo base_url('index.php/RASD_form/proses_upload_file_excel') ?>",
                            type: 'POST',
                            data: form_data,
                            success: function(data) {
                                if (data != '') {
                                    console.log(data);
                                } else {
                                    console.log(data);
                                }
                            }
                        });
                    });

                    this.on("success", function(file, responseText) {

                    if (responseText=='Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon')
                    {
                        $('#ModalEditExcel').modal('hide')
                        $('#ModalGagalExcel').modal('show');
                    }
                    else
                    {
                        location.reload();
                    }

                    });
                }
            });

            //Event ketika Memulai mengupload
            file_upload.on("sending", function(a, b, c) {
                a.token = Math.random();
                c.append("token_npwp", a.token); //Mempersiapkan token untuk masing masing npwp
            });

        }


        var ID_RASD = <?php echo $ID_RASD  ?>;
        var ID_PROYEK_SUB_PEKERJAAN = <?php echo $ID_PROYEK_SUB_PEKERJAAN  ?>;
        tampil_data_RASD_form();
        tampil_data_RASD_form_deviasi(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            ordering: false,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            aaSorting: [],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {
                    extend: 'excel',
                    title: 'RASD Item Barang'
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

        $('#mydata_deviasi').dataTable({
            pageLength: 10,
            ordering: false,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            aaSorting: [],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {
                    extend: 'excel',
                    title: 'RASD Item Barang Deviasi'
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

        $('#mydata_rasd_realisasi').dataTable({
            pageLength: 10,
            ordering: false,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            aaSorting: [],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {
                    extend: 'excel',
                    title: 'RASD Item Barang'
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


        $("#checkAllbarangmaster").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        //fungsi tampil data
        function tampil_data_RASD_form() {
            var RENCANA_ANGGARAN = 0;
            var REALISASI_ANGGARAN = 0;
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>RASD_form/data_RASD_form',
                async: false,
                dataType: 'json',
                data: {
                    ID_RASD: ID_RASD
                },
                success: function(data) {

                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_BARANG;
                        let kode_barang = data[i].KODE_BARANG;
                        if (jumlah_barang == null) {
                            jumlah_barang = 0;
                        }
                        if (kode_barang != null) {
                            kode_barang_cetak = '<a href="<?php echo base_url() ?>barang_master/profil_barang_master/' + data[i].HASH_MD5_BARANG_MASTER + '" target="_blank" class="btn btn-warning btn-xs btn-outline block"><i class="fa fa-eye"></i> ' + kode_barang + ' </a>';
                        }
                        if (kode_barang == null) {
                            kode_barang_cetak = '<span class="label label-info block"><i class="fa fa-warning"></i> Data Baru</span>';
                        }

                        var HARGA_BARANG = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            maximumFractionDigits: 0, 
                            minimumFractionDigits: 0,
                        }).format(data[i].HARGA_BARANG);

                        var TOTAL_HARGA = 0;
                        if (data[i].TOTAL_HARGA == null )
                        {
                            TOTAL_HARGA = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0, 
                                minimumFractionDigits: 0,
                            }).format(data[i].HARGA_BARANG * jumlah_barang);
                        }
                        else
                        {
                            TOTAL_HARGA = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0, 
                                minimumFractionDigits: 0,
                            }).format(data[i].TOTAL_HARGA);
                        }

                        var NAMA = data[i].NAMA;
                        var MEREK = data[i].MEREK;
                        var SPESIFIKASI_SINGKAT = data[i].SPESIFIKASI_SINGKAT;
                        var SATUAN_BARANG = data[i].SATUAN_BARANG;
                        var ID_RASD_FORM = data[i].ID_RASD_FORM;

                        var form_data = {
                                    ID_RAB_FORM: data[i].ID_RAB_FORM, //
                                    ID_RASD_FORM: data[i].ID_RASD_FORM,
                                }
                        var m;
                        var TOTAL_JUMLAH_BARANG = 0;
                        var TOTAL_HARGA_TOTAL = 0;
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() ?>RASD_form/data_sum_qty_rasd_realisasi_item_barang',
                            async: false,
                            dataType: 'json',
                            data: form_data,
                            success: function(data) {

                                data_5 = data;

                                for (m = 0; m < data_5.length; m++) {

                                    var JUMLAH_BARANG = Number(data_5[m].JUMLAH_BARANG);

                                    TOTAL_JUMLAH_BARANG = Number(TOTAL_JUMLAH_BARANG) + Number(JUMLAH_BARANG);

                                    var HARGA_TOTAL = Number(data_5[m].HARGA_TOTAL);

                                    TOTAL_HARGA_TOTAL = Number(TOTAL_HARGA_TOTAL) + Number(HARGA_TOTAL);

                                }

                                TERBILANG_HARGA_TOTAL = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        maximumFractionDigits: 0, 
                                        minimumFractionDigits: 0,
                                    }).format(TOTAL_HARGA_TOTAL);

                                html += '<tr>' +
                                '<td>' + NAMA + '</td>' +
                                '<td>' + MEREK + '</td>' +
                                '<td>' + SPESIFIKASI_SINGKAT + '</td>' +
                                '<td>' + jumlah_barang + '</td>' +
                                '<td>' + SATUAN_BARANG + '</td>' +
                                '<td>' + HARGA_BARANG + '</td>' +
                                '<td>' + TOTAL_HARGA + '</td>' +
                                '<td>' + TOTAL_JUMLAH_BARANG + '</td>' +
                                '<td>' + TERBILANG_HARGA_TOTAL + '</td>' +
                                '<td>' +
                                '<a href="javascript:;" class="btn btn-primary btn-xs item_realisasi block" data="' + ID_RASD_FORM + '"><i class="fa fa-search"></i> Realisasi</a>' +
                                '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + ID_RASD_FORM + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
                                '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + ID_RASD_FORM + '"><i class="fa fa-trash"></i> Hapus </a>' +
                                '</td>' +
                                '</tr>';

                            }
                        });

                        RENCANA_ANGGARAN += Math.floor(data[i].HARGA_BARANG * jumlah_barang);
                        REALISASI_ANGGARAN += Math.floor(TOTAL_HARGA_TOTAL);


                    }
                    RENCANA_ANGGARAN = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(RENCANA_ANGGARAN);
                    
                    REALISASI_ANGGARAN = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(REALISASI_ANGGARAN);
                    html += '<tr>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + 'Total Rencana' + '</td>' +
                        '<td>' + RENCANA_ANGGARAN + '</td>' +
                        '<td>' + 'Total Realisasi'  + '</td>' +
                        '<td>' + REALISASI_ANGGARAN + '</td>' +
                        '<td>' + '' + '</td>' +
                        '</tr>';
                    $('#show_data').html(html);
                }
            });
        }

        //fungsi tampil data deviasi
        function tampil_data_RASD_form_deviasi() {
            var RENCANA_ANGGARAN = 0;
            var REALISASI_ANGGARAN = 0;
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>RASD_form/data_RASD_form_deviasi',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_RASD
                },
                success: function(data) {

                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_BARANG;
                        let kode_barang = data[i].KODE_BARANG;
                        if (jumlah_barang == null) {
                            jumlah_barang = 0;
                        }
                        if (kode_barang != null) {
                            kode_barang_cetak = '<a href="<?php echo base_url() ?>barang_master/profil_barang_master/' + data[i].HASH_MD5_BARANG_MASTER + '" target="_blank" class="btn btn-warning btn-xs btn-outline block"><i class="fa fa-eye"></i> ' + kode_barang + ' </a>';
                        }
                        if (kode_barang == null) {
                            kode_barang_cetak = '<span class="label label-info block"><i class="fa fa-warning"></i> Data Baru</span>';
                        }

                        var HARGA_BARANG = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            maximumFractionDigits: 0, 
                            minimumFractionDigits: 0,
                        }).format(data[i].HARGA_BARANG);

                        var TOTAL_HARGA = 0;
                        if (data[i].TOTAL_HARGA == null )
                        {
                            TOTAL_HARGA = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0, 
                                minimumFractionDigits: 0,
                            }).format(data[i].HARGA_BARANG * jumlah_barang);
                        }
                        else
                        {
                            TOTAL_HARGA = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0, 
                                minimumFractionDigits: 0,
                            }).format(data[i].TOTAL_HARGA);
                        }

                        var NAMA = data[i].NAMA;
                        var MEREK = data[i].MEREK;
                        var SPESIFIKASI_SINGKAT = data[i].SPESIFIKASI_SINGKAT;
                        var SATUAN_BARANG = data[i].SATUAN_BARANG;
                        var ID_RASD_FORM = data[i].ID_RASD_FORM;

                        var form_data = {
                                    ID_RAB_FORM: data[i].ID_RAB_FORM, //
                                    ID_RASD_FORM: data[i].ID_RASD_FORM,
                                }
                        var m;
                        var TOTAL_JUMLAH_BARANG = 0;
                        var TOTAL_HARGA_TOTAL = 0;
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() ?>RASD_form/data_sum_qty_rasd_realisasi_item_barang',
                            async: false,
                            dataType: 'json',
                            data: form_data,
                            success: function(data) {

                                data_5 = data;

                                for (m = 0; m < data_5.length; m++) {

                                    var JUMLAH_BARANG = Number(data_5[m].JUMLAH_BARANG);

                                    TOTAL_JUMLAH_BARANG = Number(TOTAL_JUMLAH_BARANG) + Number(JUMLAH_BARANG);

                                    var HARGA_TOTAL = Number(data_5[m].HARGA_TOTAL);

                                    TOTAL_HARGA_TOTAL = Number(TOTAL_HARGA_TOTAL) + Number(HARGA_TOTAL);

                                }

                                TERBILANG_HARGA_TOTAL = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        maximumFractionDigits: 0, 
                                        minimumFractionDigits: 0,
                                    }).format(TOTAL_HARGA_TOTAL);

                                html += '<tr>' +
                                '<td>' + NAMA + '</td>' +
                                '<td>' + MEREK + '</td>' +
                                '<td>' + SPESIFIKASI_SINGKAT + '</td>' +
                                '<td>' + jumlah_barang + '</td>' +
                                '<td>' + SATUAN_BARANG + '</td>' +
                                '<td>' + HARGA_BARANG + '</td>' +
                                '<td>' + TOTAL_HARGA + '</td>' +
                                '<td>' + TOTAL_JUMLAH_BARANG + '</td>' +
                                '<td>' + TERBILANG_HARGA_TOTAL + '</td>' +
                                '<td>' +
                                '<a href="javascript:;" class="btn btn-primary btn-xs item_realisasi block" data="' + ID_RASD_FORM + '"><i class="fa fa-search"></i> Realisasi</a>' +
                                '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + ID_RASD_FORM + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
                                '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + ID_RASD_FORM + '"><i class="fa fa-trash"></i> Hapus </a>' +
                                '</td>' +
                                '</tr>';

                            }
                        });

                        RENCANA_ANGGARAN += Math.floor(data[i].HARGA_BARANG * jumlah_barang);
                        REALISASI_ANGGARAN += Math.floor(TOTAL_HARGA_TOTAL);

                    }
                    RENCANA_ANGGARAN = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(RENCANA_ANGGARAN);
                    
                    REALISASI_ANGGARAN = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(REALISASI_ANGGARAN);
                    html += '<tr>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + 'Total Rencana' + '</td>' +
                        '<td>' + RENCANA_ANGGARAN + '</td>' +
                        '<td>' + 'Total Realisasi'  + '</td>' +
                        '<td>' + REALISASI_ANGGARAN + '</td>' +
                        '<td>' + '' + '</td>' +
                        '</tr>';
                    $('#show_data_deviasi').html(html);
                }
            });
        }


        $("#HARGA_SATUAN_BARANG_FIX2").on("keyup", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
            var JUMLAH = $("#JUMLAH_BARANG2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#HARGA_SATUAN_BARANG_FIX2").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
            var JUMLAH = $("#JUMLAH_BARANG2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#HARGA_SATUAN_BARANG_FIX2").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
            var JUMLAH = $("#JUMLAH_BARANG2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#JUMLAH_BARANG2").on("keyup", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
            var JUMLAH = $("#JUMLAH_BARANG2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#JUMLAH_BARANG2").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
            var JUMLAH = $("#JUMLAH_BARANG2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#JUMLAH_BARANG2").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
            var JUMLAH = $("#JUMLAH_BARANG2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#HARGA_SATUAN_BARANG_FIX4").on("keyup", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX4").val();
            var JUMLAH = $("#JUMLAH_BARANG_4").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#HARGA_SATUAN_BARANG_FIX4").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX4").val();
            var JUMLAH = $("#JUMLAH_BARANG_4").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#HARGA_SATUAN_BARANG_FIX4").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX4").val();
            var JUMLAH = $("#JUMLAH_BARANG_4").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#JUMLAH_BARANG_4").on("keyup", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX4").val();
            var JUMLAH = $("#JUMLAH_BARANG_4").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#JUMLAH_BARANG_4").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX4").val();
            var JUMLAH = $("#JUMLAH_BARANG_4").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#JUMLAH_BARANG_4").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX4").val();
            var JUMLAH = $("#JUMLAH_BARANG_4").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        //GET UPDATE
        $('#show_data').on('click', '.item_edit', function() {
            var ID_RASD_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RASD_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_RASD_FORM: ID_RASD_FORM
                },
                success: function(data) {

                    $('#ModalEdit').modal('show');
                    $('[name="ID_RASD_FORM2"]').val(data.ID_RASD_FORM);
                    $('[name="ID_BARANG_MASTER2"]').val(data.ID_BARANG_MASTER);
                    $('[name="NAMA2"]').val(data.NAMA);
                    $('[name="MEREK2"]').val(data.MEREK);
                    $('[name="SATUAN_BARANG2"]').val(data.SATUAN_BARANG);
                    $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_BARANG);
                    $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);

                    var HARGA = data.HARGA_BARANG;
                    var JUMLAH = data.JUMLAH_BARANG;
                    var TOTAL = Math.floor(HARGA * JUMLAH);

                    $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
                    $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(TOTAL));

                    $('[name="HARGA_SATUAN_BARANG_FIX2"]').val(HARGA);
                    $('#alert-msg-2').html('<div></div>');

                }
            });
            return false;
        });

        $('#show_data').on('click', '.item_realisasi', function() {
            var ID_RASD_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RASD_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_RASD_FORM: ID_RASD_FORM
                },
                success: function(data) {

                    $('[name="NAMA3"]').val(data.NAMA);
                    $('[name="MEREK3"]').val(data.MEREK);
                    $('[name="SATUAN_BARANG3"]').val(data.SATUAN_BARANG);
                    $('[name="JUMLAH_BARANG3"]').val(data.JUMLAH_BARANG);
                    $('[name="SPESIFIKASI_SINGKAT3"]').val(data.SPESIFIKASI_SINGKAT);

                    var HARGA = data.HARGA_BARANG;
                    var JUMLAH = data.JUMLAH_BARANG;
                    var TOTAL = Math.floor(HARGA * JUMLAH);

                    $('[name="HARGA_TOTAL_TAMPIL3"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(TOTAL));

                    $('[name="HARGA_SATUAN_BARANG_FIX3"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(HARGA));

                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RASD_form/data_rasd_realisasi') ?>",
                dataType: "JSON",
                data: {
                    ID_RASD_FORM: ID_RASD_FORM
                },
                success: function(data) {
                    $('#ModalRealisasi').modal('show');


                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_BARANG;


                        var HARGA_BARANG = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            maximumFractionDigits: 0, 
                            minimumFractionDigits: 0,
                        }).format(data[i].HARGA_BARANG);

                        var TOTAL_HARGA = 0;
                        if (data[i].TOTAL_HARGA == null )
                        {
                            TOTAL_HARGA = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0, 
                                minimumFractionDigits: 0,
                            }).format(data[i].HARGA_BARANG * jumlah_barang);
                        }
                        else
                        {
                            TOTAL_HARGA = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0, 
                                minimumFractionDigits: 0,
                            }).format(data[i].TOTAL_HARGA);
                        }

                        html += '<tr>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + jumlah_barang + '</td>' +
                            '<td>' + data[i].SATUAN_BARANG + '</td>' +
                            '<td>' + HARGA_BARANG + '</td>' +
                            '<td>' + TOTAL_HARGA + '</td>' +
                            '<td>' + '<a href="<?php echo base_url() ?>SPP_form/view/' + data[i].HASH_MD5_SPP + '" target="_blank" class="btn btn-warning btn-xs btn-outline block"><i class="fa fa-eye"></i> ' + data[i].NO_URUT_SPP + ' </a>' + '</td>' +    
                            '</tr>';
                    }
                    
                    $('#show_data_rasd_realisasi').html(html);
                }
            });

            
            return false;
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var ID_RASD_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/RASD_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_RASD_FORM: ID_RASD_FORM
                },
                success: function(data) {

                    $('#ModalHapus').modal('show');
                    $('[name="ID_RASD_FORM_3"]').val(ID_RASD_FORM);
                    $('#NAMA_BARANG_3').html('Nama Barang: ' + data.NAMA);

                }
            });
        });

        //GET UPDATE
        $('#show_data_deviasi').on('click', '.item_edit', function() {
            var ID_RASD_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RASD_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_RASD_FORM: ID_RASD_FORM
                },
                success: function(data) {

                    $('#ModalEdit').modal('show');
                    $('[name="ID_RASD_FORM2"]').val(data.ID_RASD_FORM);
                    $('[name="ID_BARANG_MASTER2"]').val(data.ID_BARANG_MASTER);
                    $('[name="NAMA2"]').val(data.NAMA);
                    $('[name="MEREK2"]').val(data.MEREK);
                    $('[name="SATUAN_BARANG2"]').val(data.SATUAN_BARANG);
                    $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_BARANG);
                    $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);

                    var HARGA = data.HARGA_BARANG;
                    var JUMLAH = data.JUMLAH_BARANG;
                    var TOTAL = Math.floor(HARGA * JUMLAH);

                    $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
                    $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(TOTAL));

                    $('[name="HARGA_SATUAN_BARANG_FIX2"]').val(HARGA);
                    $('#alert-msg-2').html('<div></div>');

                }
            });
            return false;
        });

        $('#show_data_deviasi').on('click', '.item_realisasi', function() {
            var ID_RASD_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RASD_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_RASD_FORM: ID_RASD_FORM
                },
                success: function(data) {

                    console.log(data);

                    $('[name="NAMA3"]').val(data.NAMA);
                    $('[name="MEREK3"]').val(data.MEREK);
                    $('[name="SATUAN_BARANG3"]').val(data.SATUAN_BARANG);
                    $('[name="JUMLAH_BARANG3"]').val(data.JUMLAH_BARANG);
                    $('[name="SPESIFIKASI_SINGKAT3"]').val(data.SPESIFIKASI_SINGKAT);

                    var HARGA = data.HARGA_BARANG;
                    var JUMLAH = data.JUMLAH_BARANG;
                    var TOTAL = Math.floor(HARGA * JUMLAH);

                    $('[name="HARGA_TOTAL_TAMPIL3"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(TOTAL));

                    $('[name="HARGA_SATUAN_BARANG_FIX3"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(HARGA));

                }
            });

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RASD_form/data_rasd_realisasi') ?>",
                dataType: "JSON",
                data: {
                    ID_RASD_FORM: ID_RASD_FORM
                },
                success: function(data) {
                    $('#ModalRealisasi').modal('show');


                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_BARANG;


                        var HARGA_BARANG = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            maximumFractionDigits: 0, 
                            minimumFractionDigits: 0,
                        }).format(data[i].HARGA_BARANG);

                        var TOTAL_HARGA = 0;
                        if (data[i].TOTAL_HARGA == null )
                        {
                            TOTAL_HARGA = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0, 
                                minimumFractionDigits: 0,
                            }).format(data[i].HARGA_BARANG * jumlah_barang);
                        }
                        else
                        {
                            TOTAL_HARGA = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR',
                                maximumFractionDigits: 0, 
                                minimumFractionDigits: 0,
                            }).format(data[i].TOTAL_HARGA);
                        }

                        html += '<tr>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + jumlah_barang + '</td>' +
                            '<td>' + data[i].SATUAN_BARANG + '</td>' +
                            '<td>' + HARGA_BARANG + '</td>' +
                            '<td>' + TOTAL_HARGA + '</td>' +
                            '<td>' + '<a href="<?php echo base_url() ?>SPP_form/view/' + data[i].HASH_MD5_SPP + '" target="_blank" class="btn btn-warning btn-xs btn-outline block"><i class="fa fa-eye"></i> ' + data[i].NO_URUT_SPP + ' </a>' + '</td>' +    
                            '</tr>';
                    }
                    
                    $('#show_data_rasd_realisasi').html(html);
                }
            });

            
            return false;
        });

        //GET HAPUS
        $('#show_data_deviasi').on('click', '.item_hapus', function() {
            var ID_RASD_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/RASD_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_RASD_FORM: ID_RASD_FORM
                },
                success: function(data) {

                    $('#ModalHapus').modal('show');
                    $('[name="ID_RASD_FORM_3"]').val(ID_RASD_FORM);
                    $('#NAMA_BARANG_3').html('Nama Barang: ' + data.NAMA);

                }
            });
        });



        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999,
            step: 0.01,
            decimals: 2,
        });

        // jumlah-+
        $(".touchspin2").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999,
            step: 1,
            decimals: 0,
        });


        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            var form_data = {
                ID_RASD: ID_RASD,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
                HARGA_BARANG: $('#HARGA_SATUAN_BARANG_FIX4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('RASD_form/simpan_data'); ?>",
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

            let ID_RASD_FORM = $('#ID_RASD_FORM2').val();
            let ID_BARANG_MASTER = $('#ID_BARANG_MASTER2').val();
            let NAMA = $('#NAMA2').val();
            let MEREK = $('#MEREK2').val();
            let SPESIFIKASI_SINGKAT = $('#SPESIFIKASI_SINGKAT2').val();
            let SATUAN_BARANG = $('#SATUAN_BARANG2').val();
            let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
            let HARGA_BARANG= $('#HARGA_SATUAN_BARANG_FIX2').val();

                $.ajax({
                    url: "<?php echo site_url('RASD_form/update_data') ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        ID_RASD: ID_RASD,
                        ID_RASD_FORM: ID_RASD_FORM,
                        ID_BARANG_MASTER: ID_BARANG_MASTER,
                        NAMA: NAMA,
                        MEREK: MEREK,
                        SPESIFIKASI_SINGKAT: SPESIFIKASI_SINGKAT,
                        SATUAN_BARANG: SATUAN_BARANG,
                        JUMLAH_BARANG: JUMLAH_BARANG,
                        HARGA_BARANG: HARGA_BARANG,
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

        $('#btn_gagal_upload').on('click', function() {
            window.location.reload();
        });

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var ID_RASD_FORM = $('#ID_RASD_FORM_3').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RASD_form/hapus_data') ?>",
                dataType: "JSON",
                data: {
                    ID_RASD_FORM: ID_RASD_FORM
                },
                success: function(data) {
                    $('#ModalHapus').modal('hide');
                    // tampil_data_jenis_barang();
                    window.location.reload();
                }
            });
            return false;
        });

        //GET UPDATE untuk Upload Excel
        item_edit_upload_excel.onclick = function() {
            $('#ModalEditExcel').modal('show');
        };
    });
</script>

</body>

</html>