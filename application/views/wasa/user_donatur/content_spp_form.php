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

<div class="wrapper wrapper-content animated fadeInRight">

    <style>
        .container_iframe {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding-top: 25%;
            /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
        }

        /* Then style the iframe to fit in the container div with full height and width */
        .responsive-iframe {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }
    </style>

    <!-- Identitas Form SPP -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo $FILE_NAME_TEMP; ?></h5>
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
            <div class="container_iframe">
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/SPP/') ?><?php echo $FILE_NAME_TEMP; ?>"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/SPP/') ?>" class="btn btn-primary"> Kembali Ke Halaman List SPP</a>
            <?php if ($PROGRESS_SPP == "Diproses oleh Staff Procurement KP") { ?>
                <a href="<?php echo base_url('index.php/SPP_form/index/') ?><?php echo $HASH_MD5_SPP; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah SPP</a>
                <a href="javascript:;" id="item_edit_tampilkan_kontrol_anggaran" name="item_edit_tampilkan_kontrol_anggaran" class="btn btn-primary" data="<?php echo $ID_SPP; ?>"><span class="fa fa-money "></span> Sembunyikan atau Tampilkan Kontrol Anggaran</a>
                <a href="javascript:;" id="item_edit_kirim_spp" name="item_edit_kirim_spp" class="btn btn-success" data="<?php echo $ID_SPP; ?>"><span class="fa fa-send"></span> Ajukan SPP Untuk Proses Selanjutnya </a><br>
            <?php
            } else if ($PROGRESS_SPP == "Diproses oleh Staff Procurement KP") {
            ?>
                <a href="<?php echo base_url('index.php/SPP_form/index/') ?><?php echo $HASH_MD5_SPP; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah SPP</a>
                <a href="javascript:;" id="item_edit_tampilkan_kontrol_anggaran" name="item_edit_tampilkan_kontrol_anggaran" class="btn btn-primary" data="<?php echo $ID_SPP; ?>"><span class="fa fa-money "></span> Sembunyikan atau Tampilkan Kontrol Anggaran</a>
                <a href="javascript:;" id="item_edit_kirim_spp" name="item_edit_kirim_spp" class="btn btn-success" data="<?php echo $ID_SPP; ?>"><span class="fa fa-send"></span> Ajukan SPP Untuk Proses Selanjutnya </a><br>
            <?php
            } else { ?>
            <a href="#" id="item_edit_kirim_spp" name="item_edit_kirim_spp" class="btn btn-success" data="" style="display:none">&nbsp;</a>
            <a href="javascript:;" id="item_edit_tampilkan_kontrol_anggaran" name="item_edit_tampilkan_kontrol_anggaran" class="btn btn-primary" data="<?php echo $ID_SPP; ?>"><span class="fa fa-money "></span> Sembunyikan atau Tampilkan Kontrol Anggaran</a>
                <?php } ?>
            <!-- <a href="javascript:;" id="item_edit_kirim_email_spp" name="item_edit_kirim_email_spp" class="btn btn-primary" data="<?php echo $HASH_MD5_SPP; ?>"><span class="fa fa-send"></span> Kirim SPP ke Vendor</a> -->
            <!-- <a href="<?php echo base_url('index.php/SPP_form/pengajuan_vendor/') ?><?php echo $HASH_MD5_SPP; ?>" class="btn btn-primary"><span class="fa fa-book"></span> Lihat Harga Pengajuan Vendor</a> -->

        </div>
    </div>
    <!-- End Identitas Form SPP -->
    <!-- Upload Document Form SPP -->
    <?php if ($FILE == "ADA") { ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download/Upload Dokumen SPP</h5>
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
                                <?php foreach ($dokumen as $spp_form_file) {
                                    if ($spp_form_file->JENIS_FILE == "Dokumen Cap Basah" || $spp_form_file->JENIS_FILE == "Dokumen Lainnya") { ?>

                                        <div class="file-box">
                                            <div class="file">
                                                <a href="#">
                                                    <span class="corner"></span>

                                                    <?php if ($spp_form_file->JENIS_FILE == "Gambar Produk") {
                                                        echo ("<div class='image'>
										<img alt='image' class='img-responsive' 
										src='" . base_url() . $spp_form_file->KETERANGAN . "'></div>");
                                                    } else {
                                                        echo ("<div class='icon'>
										<i class='fa fa-file'></i>
										</div>");
                                                    } ?>

                                                    <div class="file-name">
                                                        <a href="<?php echo base_url(); ?>assets/upload_spp_form_file/<?php echo $spp_form_file->DOK_FILE; ?>">Lihat file</a>
                                                        <br />
                                                        <small>Jenis file: <?php echo $spp_form_file->JENIS_FILE; ?></small>
                                                        <br />
                                                        <small>Diupload: <?php echo $spp_form_file->TANGGAL_UPLOAD; ?></small>
                                                    </div>
                                                    <input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>index.php/spp_form/hapus_file/<?php echo $spp_form_file->DOK_FILE; ?>';" value="Hapus" />
                                                </a>
                                            </div>
                                        </div>

                                <?php }
                                } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_SPP; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen SPP</a>
            </div>
        </div>
    <?php } else { ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download/Upload Attachment Dokumen SPP</h5>
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
                                Belum ada Attachment file dokumen. Silakan upload file dokumen.
                            </div>
                        </div>
                    </div>
                </div>
                </br>
                </br>
                <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_SPP; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen SPP Cap Basah</a>
            </div>
        </div>
    <?php } ?>
    <!-- End Upload Document Form SPP -->
</div>

<!-- MODAL KIRIM SPP-->
<div class="modal inmodal fade" id="ModalEditKirimSPP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Kirim SPP</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form SPP ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_SPP7" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_kirim_sppb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SPP7" id="ID_SPP7" class="form-control" type="hidden" placeholder="ID_SPP" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form SPP ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang/jasa yang diminta pada SPP ini.</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_minta" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang/jasa yang diminta bernilai 0</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_harga_minta" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada harga item barang/jasa yang diminta bernilai 0</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_tanggal_mulai_dibutuhkan" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang yang belum diatur tanggal dibutuhkan</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_nama_vendor" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada nama vendor yang belum diinput</center>
                        </div>
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

<!-- MODAL KONTROL ANGGARAN SPP-->
<div class="modal inmodal fade" id="ModalEditKontrolAnggaran" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Sembunyikan Atau Tampilkan Kontrol Anggaran</h4>
            </div>
            <?php $attributes = array("HASH_MD5_SPP8" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_tampil_kontrol_anggaran", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="HASH_MD5_SPP8" id="HASH_MD5_SPP8" class="form-control" type="hidden" placeholder="HASH_MD5_SPP" readonly>

                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju_kontrol_anggaran"><i></i> Saya menyetujui untuk menyembunyikan atau menampilkan kontrol anggaran pada SPP ini </label></div>
                    </div>

                    <div id="alert-msg-8"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_tampil_kontrol_anggaran" disabled><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- END MODAL KONTROL ANGGARAN SPP-->

<!-- MODAL UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalEditGambar" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Upload Dokumen SPP Cap Basah</h4>
                <small class="font-bold">Silakan Upload Dokumen SPP Cap Basah</small>
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
                                        File dokumen yang Anda upload akan digunakan untuk keperluan SPP, dengan ketentuan sebagai berikut:
                                    <ul class="sortable-list connectList agile-list" id="ketentuan">
                                        <li class="warning-element" id="task1">
                                            1. File dokumen yang diupload harus merupakan data berkaitan dengan SPP.
                                        </li>
                                        <li class="danger-element" id="task2">
                                            2. Ukuran dokumen yang diterima sistem maksimal 1.5 Giga Bytes (1.5 GB).
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
                                                <option value='Dokumen Cap Basah'>Dokumen Cap Basah</option>
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

    $(document).ready(function() {
        
        if (document.getElementById('dropzoneForm')) {
            var file_upload = new Dropzone(".dropzone", {
                url: "<?php echo base_url('index.php/SPP_form/proses_upload_file') ?>",
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
                            url: "<?php echo base_url('index.php/SPP_form/proses_upload_file') ?>",
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
                        location.reload();
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

        }

        let ID_SPP = <?php echo $ID_SPP  ?>;

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_spp').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_spp').attr('disabled', true); //disable input
            }
        });

        $('#saya_setuju_kontrol_anggaran').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_tampil_kontrol_anggaran').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_tampil_kontrol_anggaran').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM SPP 
        $('#btn_update_kirim_spp').on('click', function() {

            tampil_data_anggaran();
            update_tabel_rasd_realisasi();

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

        //fungsi update_tabel_rasd_realisasi
        function update_tabel_rasd_realisasi() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>SPP_form/data_spp_form_by_id_spp', //GET DATA BY ID RAB FORM/ KATEGORI RAB
                async: false,
                dataType: 'json',
                data: {
                    ID_SPP: ID_SPP
                },
                success: function(data) {

                    console.log(data);

                    for (i = 0; i < data.length; i++) {
                        var form_data = {
                            ID_RAB_FORM: data[i].ID_RAB_FORM,
                            ID_RASD_FORM: data[i].ID_RASD_FORM,
                            ID_SPP: data[i].ID_SPP,
                            ID_SPP_FORM: data[i].ID_SPP_FORM,
                            SATUAN_BARANG: data[i].SATUAN_BARANG,
                            JUMLAH_BARANG: data[i].JUMLAH_BARANG,
                            HARGA_BARANG: data[i].HARGA_SATUAN_BARANG_FIX,
                            HARGA_TOTAL: data[i].HARGA_TOTAL_FIX
                        };

                        $.ajax({
                            url: "<?php echo site_url('SPP_form/update_tabel_rasd_realisasi') ?>",
                            type: "POST",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {

                                console.log(data);

                                if (data == true) {
                                    
                                } else {
                                    
                                }
                            }
                        });
                    }
                }
            });
        }

        //fungsi tampil data
        function tampil_data_anggaran() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>SPP_form/data_anggaran', //GET DATA BY ID RAB FORM/ KATEGORI RAB
                async: false,
                dataType: 'json',
                data: {
                    ID_SPP: ID_SPP
                },
                success: function(data) {

                    var html = '';
                    var i;
                    var jumlah_rasd = 0;
                    var nama_rasd = '';

                    var form_data = {
                        ID_SPP: ID_SPP,
                    }

                    $.ajax({
                        url: "<?php echo site_url('SPP_form/hapus_item_spp_kontrol_anggaran') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: form_data,
                        success: function(data) {
                        }
                    });
        
                    for (i = 0; i < data.length; i++) {

                        var rencana_anggaran = 0;
                        var total_pengadaan = 0;
                        var pengadaan_saat_ini = 0;
                        var pengadaan_sebelumnya = 0;
                        var sisa_anggaran = 0;

                        var ID_RASD = Number(data[i].ID_RASD);
                        var ID_RAB_FORM = Number(data[i].ID_RAB_FORM);
                        var ID_PROYEK_SUB_PEKERJAAN = Number(data[i].ID_PROYEK_SUB_PEKERJAAN);

                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() ?>SPP_form/data_anggaran_sum_jumlah_barang_rasd',
                            async: false,
                            dataType: 'json',
                            data: {
                                ID_RASD: ID_RASD
                            },
                            success: function(data) {
                                
                                data_2 = data;

                                for (j = 0; j < data_2.length; j++) {

                                    var HARGA_BARANG = data_2[j].HARGA_BARANG;
                                    var JUMLAH_BARANG = data_2[j].JUMLAH_BARANG;

                                    rencana_anggaran = rencana_anggaran + (HARGA_BARANG*JUMLAH_BARANG);
                                }
                            }
                        });

                        var form_data = {
                                    ID_RAB_FORM: data[i].ID_RAB_FORM,
                                    ID_SPP: data[i].ID_SPP,
                                }
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() ?>SPP_form/data_anggaran_sum_jumlah_barang_rab_pengadaan_sebelumnya',
                            async: false,
                            dataType: 'json',
                            data: form_data,
                            success: function(data) {
            
                                data_4 = data;

                                for (l = 0; l < data_4.length; l++) {

                                    var HARGA_TOTAL = Number(data_4[l].HARGA_TOTAL);

                                    pengadaan_sebelumnya = pengadaan_sebelumnya + HARGA_TOTAL ;
                                }
                            }
                        });

                        var form_data = {
                                    ID_RAB_FORM: data[i].ID_RAB_FORM,
                                    ID_SPP: data[i].ID_SPP,
                                }
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() ?>SPP_form/data_anggaran_sum_jumlah_barang_rab',
                            async: false,
                            dataType: 'json',
                            data: form_data,
                            success: function(data) {
          
                                data_3 = data;

                                for (k = 0; k < data_3.length; k++) {

                                    var HARGA_TOTAL = Number(data_3[k].HARGA_TOTAL_FIX);

                                    pengadaan_saat_ini = pengadaan_saat_ini + HARGA_TOTAL ;
                                }

                            }
                        });
            
                        total_pengadaan = pengadaan_saat_ini + pengadaan_sebelumnya;
                        sisa_anggaran = rencana_anggaran - total_pengadaan;

                        var form_data = {
                            ID_SPP: ID_SPP,
                            ID_RAB_FORM: ID_RAB_FORM,
                            ID_PROYEK_SUB_PEKERJAAN: ID_PROYEK_SUB_PEKERJAAN,
                            NAMA_KATEGORI: data[i].NAMA_KATEGORI,
                            RENCANA_ANGGARAN: rencana_anggaran,
                            TOTAL_PENGADAAN: total_pengadaan,
                            PENGADAAN_SAAT_INI: pengadaan_saat_ini,
                            PENGADAAN_SEBELUMNYA: pengadaan_sebelumnya,
                            SISA_ANGGARAN: sisa_anggaran
                        }

                        $.ajax({
                            url: "<?php echo site_url('SPP_form/update_data_kontrol_anggaran') ?>",
                            type: "POST",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                            }
                        });

                    }
                }
            });
        }


        item_edit_kirim_spp.onclick = function() {
            var ID_SPP = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/data_spp_form_kirim_SPP') ?>",
                dataType: "JSON",
                data: {
                    ID_SPP: ID_SPP
                },
                success: function(data) {
                    $('#ModalEditKirimSPP').modal('show');
                    $.each(data, function() {
                        $('[name="ID_SPP7"]').val(data[0].ID_SPP);
                        $('#alert-msg-7').html('<div></div>');
                    });

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);
                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        let i = 0;
                        for (i = 0; i < data.length; i++) {
                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH_BARANG == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_jumlah_minta').attr("hidden", false);
                                break;
                            }

                            if (data[i].NAMA_BARANG == null || data[i].NAMA_BARANG == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_nama_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].SPESIFIKASI_SINGKAT == null || data[i].SPESIFIKASI_SINGKAT == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_spesifikasi_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_PROYEK_SUB_PEKERJAAN == null || data[i].ID_PROYEK_SUB_PEKERJAAN == "" || data[i].ID_PROYEK_SUB_PEKERJAAN == "0") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_sub_pekerjaan').attr("hidden", false);
                                break;
                            }

                            
                            if (data[i].ID_RAB_FORM == "" && data[i].NAMA_KATEGORI_RAB == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rab_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_RAB_FORM == null && data[i].NAMA_KATEGORI_RAB == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rab_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_RAB_FORM == null && data[i].NAMA_KATEGORI_RAB == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rab_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_RAB_FORM == "" && data[i].NAMA_KATEGORI_RAB == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rab_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_RAB_FORM == "0" && data[i].NAMA_KATEGORI_RAB == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rab_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_KLASIFIKASI_BARANG == null || data[i].ID_KLASIFIKASI_BARANG == "" || data[i].ID_KLASIFIKASI_BARANG == "0") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_klasifikasi_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].SATUAN_BARANG == null || data[i].SATUAN_BARANG == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_satuan_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_RASD_FORM == null || data[i].ID_RASD_FORM == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rasd_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].TANGGAL_MULAI_PAKAI_HARI == "" || data[i].TANGGAL_MULAI_PAKAI_HARI == "00/00/0000" || data[i].TANGGAL_MULAI_PAKAI_HARI == null || data[i].TANGGAL_SELESAI_PAKAI_HARI == "" || data[i].TANGGAL_SELESAI_PAKAI_HARI == null || data[i].TANGGAL_SELESAI_PAKAI_HARI == "00/00/0000") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_tanggal_mulai_selesai').attr("hidden", false);
                                break;
                            }

                            
                            if (data[i].NAMA_VENDOR == "" || data[i].NAMA_VENDOR == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_nama_vendor').attr("hidden", false);
                                break;
                            }

                            if (data[i].HARGA_SATUAN_BARANG_FIX == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_harga_minta').attr("hidden", false);
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


        $('#btn_update_tampil_kontrol_anggaran').on('click', function() {

            let HASH_MD5_SPP = $('#HASH_MD5_SPP8').val();
            console.log(HASH_MD5_SPP);
            $.ajax({
                url: "<?php echo site_url('SPP_form/update_data_tampil_kontrol_anggaran') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    HASH_MD5_SPP: HASH_MD5_SPP,
                },
                success: function(data) {

                    if (data.length > 0) {
                        $('#ModalEditKontrolAnggaran').modal('hide');
                        var alamat = "<?php echo base_url('SPP_form/view/'); ?>" + HASH_MD5_SPP;
                            window.open(
                                alamat,
                                '_self' // <- This is what makes it open in a new window.
                            );
                    } else {
                        $('#alert-msg-8').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        item_edit_tampilkan_kontrol_anggaran.onclick = function() {
            var ID_SPP = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/data_spp_form_kirim_SPP') ?>",
                dataType: "JSON",
                data: {
                    ID_SPP: ID_SPP
                },
                success: function(data) {
                    $('#ModalEditKontrolAnggaran').modal('show');
                    $.each(data, function() {
                        $('[name="HASH_MD5_SPP8"]').val(data[0].HASH_MD5_SPP);
                        $('#alert-msg-8').html('<div></div>');
                    });
                }
            });
            return false;
        };

        //GET UPDATE untuk Edit Gambar
        item_edit_upload_gambar.onclick = function() {
            $('#ModalEditGambar').modal('show');
        };
    });
</script>

</body>

</html>