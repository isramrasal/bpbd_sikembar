<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form RFQ</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/RFQ/') ?>">RFQ</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form RFQ</a>
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
            padding-top: 56.25%;
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

    <!-- Identitas Form RFQ -->
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/RFQ/') ?><?php echo $FILE_NAME_TEMP; ?>"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/RFQ/') ?>" class="btn btn-info"> Kembali Ke Halaman List RFQ</a>
            <?php if ($PROGRESS_RFQ == "Dalam Proses Pembuatan Manajer Procurement KP") { ?>
                <a href="<?php echo base_url('index.php/RFQ_form/index/') ?><?php echo $HASH_MD5_RFQ; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah RFQ</a>
                <a href="javascript:;" id="item_edit_kirim_rfq" name="item_edit_kirim_rfq" class="btn btn-success" data="<?php echo $HASH_MD5_RFQ; ?>"><span class="fa fa-send"></span> Ajukan RFQ Untuk Proses Selanjutnya </a>
            <?php
            } else if ($PROGRESS_RFQ == "Dalam Proses Manajer Procurement KP") {
            ?>
                <a href="<?php echo base_url('index.php/RFQ_form/index/') ?><?php echo $HASH_MD5_RFQ; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah RFQ</a>
                <a href="javascript:;" id="item_edit_kirim_rfq" name="item_edit_kirim_rfq" class="btn btn-success" data="<?php echo $HASH_MD5_RFQ; ?>"><span class="fa fa-send"></span> Ajukan RFQ Untuk Proses Selanjutnya </a>
            <?php
            } else {
            ?>
                <a href="<?php echo base_url('index.php/RFQ/') ?>" class="btn btn-warning" disabled><span class="fa fa-pencil"></span> Ubah RFQ</a>
                <a href="javascript:;" id="item_edit_kirim_rfq" name="item_edit_kirim_rfq" class="btn btn-success" data="<?php echo $HASH_MD5_RFQ; ?>" disabled><span class="fa fa-send"></span> Ajukan RFQ Untuk Proses Selanjutnya </a>
            <?php } ?>
            <a href="javascript:;" id="item_edit_kirim_email_rfq" name="item_edit_kirim_email_rfq" class="btn btn-primary" data="<?php echo $HASH_MD5_RFQ; ?>"><span class="fa fa-send"></span> Kirim RFQ ke Vendor</a>

            <a href="<?php echo base_url('index.php/RFQ_form/pengajuan_vendor/') ?><?php echo $HASH_MD5_RFQ; ?>" class="btn btn-primary"><span class="fa fa-book"></span> Lihat Harga Pengajuan Vendor</a>
        </div>
    </div>
    <!-- End Identitas Form RFQ -->
    <?php if ($FILE == "ADA") { ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download/Upload Dokumen RFQ - Dept Procurement</h5>
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
                                <?php foreach ($dokumen as $rfq_form_file) {
                                    if ($rfq_form_file->JENIS_FILE == "Dokumen Cap Basah" || $rfq_form_file->JENIS_FILE == "Dokumen Lainnya - Dept Proc") { ?>

                                        <div class="file-box">
                                            <div class="file">
                                                <a href="#">
                                                    <span class="corner"></span>

                                                    <?php if ($rfq_form_file->JENIS_FILE == "Gambar Produk") {
                                                        echo ("<div class='image'>
										<img alt='image' class='img-responsive' 
										src='" . base_url() . $rfq_form_file->KETERANGAN . "'></div>");
                                                    } else {
                                                        echo ("<div class='icon'>
										<i class='fa fa-file'></i>
										</div>");
                                                    } ?>

                                                    <div class="file-name">
                                                        <a href="<?php echo base_url(); ?>assets/upload_rfq_form_file/<?php echo $rfq_form_file->DOK_FILE; ?>">Download file</a>
                                                        <br />
                                                        <small>Jenis file: <?php echo $rfq_form_file->JENIS_FILE; ?></small>
                                                        <br />
                                                        <small>Diupload: <?php echo $rfq_form_file->TANGGAL_UPLOAD; ?></small>
                                                    </div>
                                                    <input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>index.php/rfq_form/hapus_file/<?php echo $rfq_form_file->DOK_FILE; ?>';" value="Hapus" />
                                                </a>
                                            </div>
                                        </div>

                                <?php }
                                } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_RFQ; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen RFQ Cap Basah</a>
            </div>
        </div>

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download Dokumen RFQ - Vendor</h5>
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
                                <?php foreach ($dokumen as $rfq_form_file) {
                                    if ($rfq_form_file->JENIS_FILE == "Dokumen List Harga" || $rfq_form_file->JENIS_FILE == "Dokumen Lainnya - Vendor") { ?>

                                        <div class="file-box">
                                            <div class="file">
                                                <a href="#">
                                                    <span class="corner"></span>

                                                    <?php if ($rfq_form_file->JENIS_FILE == "Gambar Produk") {
                                                        echo ("<div class='image'>
										<img alt='image' class='img-responsive' 
										src='" . base_url() . $rfq_form_file->KETERANGAN . "'></div>");
                                                    } else {
                                                        echo ("<div class='icon'>
										<i class='fa fa-file'></i>
										</div>");
                                                    } ?>

                                                    <div class="file-name">
                                                        <a href="<?php echo base_url(); ?>assets/upload_rfq_form_file/<?php echo $rfq_form_file->DOK_FILE; ?>">Download file</a>
                                                        <br />
                                                        <small>Jenis file: <?php echo $rfq_form_file->JENIS_FILE; ?></small>
                                                        <br />
                                                        <small>Diupload: <?php echo $rfq_form_file->TANGGAL_UPLOAD; ?></small>
                                                    </div>

                                                </a>
                                            </div>
                                        </div>

                                <?php }
                                } ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download/Upload Dokumen RFQ - Dept Procurement</h5>
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
                <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_RFQ; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen RFQ Cap Basah</a>
            </div>
        </div>
    <?php } ?>
</div>

<!-- MODAL KIRIM RFQ-->
<div class="modal inmodal fade" id="ModalEditKirimRFQ" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim RFQ</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form RFQ ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("HASH_MD5_RFQ7" => "contact_form", "id" => "contact_form");
            echo form_open("RFQ_form/update_data_kirim_rfq", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="HASH_MD5_RFQ7" id="HASH_MD5_RFQ7" class="form-control" type="hidden" placeholder="ID RFQ" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="i-checks"><input type="checkbox" id="saya_setuju">
                            Saya telah selesai melakukan proses form RFQ ini dan menyetujui untuk diproses lebih lanjut
                        </div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang diminta pada RFQ ini</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item jumlah barang yang bernilai 0</center>
                        </div>
                    </div>

                    <div id="alert-msg-7"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_rfq" disabled><i class="fa fa-send"></i> Kirim</button>
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
                <h4 class="modal-title">Upload Dokumen RFQ Cap Basah</h4>
                <small class="font-bold">Silakan Upload Dokumen RFQ Cap Basah</small>
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
                                                <option value='Dokumen Cap Basah'>Dokumen Cap Basah</option>
                                                <option value='Dokumen Lainnya - Dept Proc'>Dokumen Lainnya</option>
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
        maxFilesize: 5, // MB
        maxFiles: 1,
        dictDefaultMessage: "<strong>Letakkan file di sini atau klik untuk memuat file. </strong></br> (Pastikan file yang Anda upload sesuai dengan ketentuan)",
        dictFileTooBig: "Maaf ukuran file tidak sesuai ketentuan."
    };
    $(document).ready(function() {

        if (document.getElementById('dropzoneForm')) {
            var file_upload = new Dropzone(".dropzone", {
                url: "<?php echo base_url('index.php/RFQ_form/proses_upload_file') ?>",
                maxFilesize: 1,
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
                            url: "<?php echo base_url('index.php/RFQ_form/proses_upload_file') ?>",
                            type: 'POST',
                            data: form_data,
                            success: function(data) {
                                if (data != '') {
                                    console.log("waduh");
                                } else {
                                    console.log("waduh 2");
                                    location.reload();
                                }
                            }
                        });
                    });

                    this.on("success", function(file, responseText) {
                        location.reload();;
                    });
                }
            });

            //Event ketika Memulai mengupload
            file_upload.on("sending", function(a, b, c) {
                a.token = Math.random();
                c.append("token_npwp", a.token); //Mempersiapkan token untuk masing masing npwp
            });

            //Event ketika data dihapus
            file_upload.on("removedfile", function(a) {
                var token = a.token;
                $.ajax({
                    type: "post",
                    data: {
                        token: token
                    },
                    url: "<?php echo base_url('index.php/RFQ_form/remove_file') ?>",
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

        let ID_RFQ = <?php echo $ID_RFQ  ?>;

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_rfq').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_rfq').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM SPPB 
        $('#btn_update_kirim_rfq').on('click', function() {

            let HASH_MD5_RFQ = $('#HASH_MD5_RFQ7').val();
            $.ajax({
                url: "<?php echo site_url('RFQ_form/update_data_kirim_rfq') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    HASH_MD5_RFQ: HASH_MD5_RFQ,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimRFQ').modal('hide');
                        window.location.href = '<?php echo site_url('RFQ') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        item_edit_kirim_email_rfq.onclick = function() {
            var HASH_MD5_RFQ = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('RFQ_form/get_id_rfq_by_HASH_MD5_RFQ') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_RFQ: HASH_MD5_RFQ
                },
                success: function(data) {
                    if (data.ID_VENDOR == null || data.ID_TERM_OF_PAYMENT == null || data.ID_PROYEK_LOKASI_PENYERAHAN == null || data.PROGRESS_RFQ == "Dalam Proses Staff Procurement KP" || data.PROGRESS_RFQ == "Dalam Proses Kasie Procurement KP") {
                        $('#alert-msg-7').html('<div>Anda belum menentukan Vendor atau Term of Payment atau Lokasi Penyerahan atau RFQ ini belum diproses oleh kasie atau manajer procurement KP. Anda dialihkan ke halaman pengisian RFQ</div>');

                        var tid = setInterval(function() {
                            //called 5 times each time after one second  
                            //before getting cleared by below timeout. 
                            // alert("I am setInterval");
                        }, 5000); //delay is in milliseconds 

                        alert("Anda belum menentukan Vendor atau Term of Payment atau Lokasi Penyerahan atau RFQ ini belum diproses oleh kasie atau manajer procurement KP. Anda dialihkan ke halaman pengisian RFQ"); //called second
                        var alamat = "<?php echo base_url('RFQ_form/index/'); ?>" + data.HASH_MD5_RFQ;
                        window.location = alamat;
                    } else {
                        var alamat = "<?php echo base_url('RFQ_form/kirim_email/'); ?>" + HASH_MD5_RFQ;
                        window.open(
                            alamat,
                            '_self'
                        );
                    }

                }
            });
            return false;
        };

        item_edit_kirim_rfq.onclick = function() {
            var HASH_MD5_RFQ = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('RFQ_form/get_id_rfq_by_HASH_MD5_RFQ') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_RFQ: HASH_MD5_RFQ
                },
                success: function(data) {
                    if (data.ID_VENDOR == null || data.ID_TERM_OF_PAYMENT == null || data.ID_PROYEK_LOKASI_PENYERAHAN == null) {
                        $('#alert-msg-7').html('<div>Anda belum menentukan Vendor atau Term of Payment atau Lokasi Penyerahan. Anda dialihkan ke halaman pengisian RFQ</div>');

                        var tid = setInterval(function() {
                            //called 5 times each time after one second  
                            //before getting cleared by below timeout. 
                            // alert("I am setInterval");
                        }, 5000); //delay is in milliseconds 

                        alert("Anda belum menentukan Vendor atau Term of Payment atau Lokasi Penyerahan. Anda dialihkan ke halaman pengisian RFQ"); //called second
                        location.reload();
                    } else {
                        var ID_RFQ = data.ID_RFQ;
                        $.ajax({
                            type: "GET",
                            url: "<?php echo base_url('RFQ_form/get_data_rfq_form_by_id_rfq') ?>",
                            dataType: "JSON",
                            data: {
                                ID_RFQ: ID_RFQ
                            },
                            success: function(data) {
                                console.log(data);

                                //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                                if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                                    $('#show_hidden_setuju').attr("hidden", true);
                                    $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);

                                } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                                    var i = 0;
                                    for (i = 0; i < data.length; i++) {
                                        //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                                        if (data[i].JUMLAH_BARANG == 0) {
                                            $('#show_hidden_setuju').attr("hidden", true);
                                            $('#show_hidden_belum_atur_jumlah_barang').attr("hidden", false);
                                            break;
                                        }
                                        if (data[i].JUMLAH_BARANG == null) {
                                            $('#show_hidden_setuju').attr("hidden", true);
                                            $('#show_hidden_belum_atur_jumlah_barang').attr("hidden", false);
                                            break;
                                        }

                                        //JIKA SEMUA ITEM BARANG ADA JUMLAH MINTANYA (TIDAK NOL)
                                        if (i == (data.length - 1)) {
                                            $('#show_hidden_setuju').attr("hidden", false);
                                        }
                                    }
                                }
                                $('#ModalEditKirimRFQ').modal('show');
                                $('[name="HASH_MD5_RFQ7"]').val(HASH_MD5_RFQ);
                            }
                        });
                    }

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