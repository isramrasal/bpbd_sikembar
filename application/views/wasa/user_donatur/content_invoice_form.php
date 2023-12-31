<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form Invoice</h2>
        <ol class="breadcrumb">
            <li>
                Home
            </li>
            <li>
                <a href="<?php echo base_url('Invoice') ?>">Invoice</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form Invoice</a>
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

    <?php if ($FILE == "ADA") { ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download/Upload Dokumen Invoice</h5>
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
                    <div class="col-lg-12 animated fadeInRight">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php foreach ($dokumen as $vendor_invoice_form_file) {
                                    if ($vendor_invoice_form_file->JENIS_FILE == "Dokumen Surat Jalan Cap Basah" || $vendor_invoice_form_file->JENIS_FILE == "Dokumen Serah Terima Cap Basah" || $vendor_invoice_form_file->JENIS_FILE == "Dokumen Invoice Cap Basah" || $vendor_invoice_form_file->JENIS_FILE == "Dokumen Lainnya - Vendor") { ?>

                                        <div class="file-box">
                                            <div class="file">
                                                <a href="#">
                                                    <span class="corner"></span>

                                                    <?php if ($vendor_invoice_form_file->JENIS_FILE == "Gambar Produk") {
                                                        echo ("<div class='image'>
										<img alt='image' class='img-responsive' 
										src='" . base_url() . $vendor_invoice_form_file->KETERANGAN . "'></div>");
                                                    } else {
                                                        echo ("<div class='icon'>
										<i class='fa fa-file'></i>
										</div>");
                                                    } ?>

                                                    <div class="file-name">
                                                        <a href="<?php echo base_url(); ?>assets/upload_vendor_invoice_file/<?php echo $vendor_invoice_form_file->DOK_FILE; ?>">Download file</a>
                                                        <br />
                                                        <small>Jenis file: <?php echo $vendor_invoice_form_file->JENIS_FILE; ?></small>
                                                        <br />
                                                        <small>Diupload: <?php echo $vendor_invoice_form_file->TANGGAL_UPLOAD; ?></small>
                                                    </div>
                                            </div>
                                        </div>
                                <?php }
                                } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_VENDOR_INVOICE; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen Invoice Cap Basah</a>
            </div>
        </div>
    <?php } else { ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download/Upload Dokumen Invoice</h5>
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
                <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_VENDOR_INVOICE; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen Invoice Cap Basah</a>
            </div>
        </div>
    <?php } ?>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Identitas Form</h5>
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
            <form method="get" class="form-horizontal">

                <div class="form-group"><label class="col-sm-2 control-label">No Urut PO:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $NO_URUT_PO; ?>" disabled>
                    </div>
                </div>
                <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pengajuan PO:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $TANGGAL_DOKUMEN_PO; ?>" disabled>
                    </div>
                </div>

                <div class="form-group"><label class="col-sm-2 control-label">Vendor:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="<?php echo $NAMA_VENDOR; ?>" disabled>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT GAMBAR -->
<div class="modal inmodal fade" id="ModalEditGambar" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Upload Dokumen Invoice</h4>
                <small class="font-bold">Silakan Upload Dokumen Invoice</small>
            </div>
            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-info alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">x</button>
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
                                            2. Ukuran dokumen yang diterima sistem maksimal 10 Mega Bytes (10 MB).
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
                                                <option value='Dokumen Invoice Cap Basah'>Dokumen Invoice Cap Basah</option>
                                                <option value='Dokumen Surat Jalan Cap Basah'>Dokumen Surat Jalan Cap Basah</option>
                                                <option value='Dokumen Serah Terima Cap Basah'>Dokumen Serah Terima Cap Basah</option>
                                                <option value='Dokumen Lainnya - Vendor'>Dokumen Lainnya - Vendor</option>
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
        maxFilesize: 1500, // MB
        maxFiles: 1,
        dictDefaultMessage: "<strong>Letakkan file di sini atau klik untuk memuat file. </strong></br> (Pastikan file yang Anda upload sesuai dengan ketentuan)",
        dictFileTooBig: "Maaf ukuran file tidak sesuai ketentuan."
    };
    $(document).ready(function() {

        if (document.getElementById('dropzoneForm')) {
            var file_upload = new Dropzone(".dropzone", {
                url: "<?php echo base_url('index.php/Invoice_form/proses_upload_file') ?>",
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
                            url: "<?php echo base_url('index.php/Invoice_form/proses_upload_file') ?>",
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

            // jumlah-+
            $(".touchspin1").TouchSpin({
                buttondown_class: 'btn btn-white',
                buttonup_class: 'btn btn-white',
                min: 0,
                max: 99999999999,
            });
        }

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_po').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_po').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM SPPB 
        $('#btn_update_kirim_po').on('click', function() {

            let HASH_MD5_PO = $('#HASH_MD5_PO7').val();
            $.ajax({
                url: "<?php echo site_url('PO_form/update_data_kirim_po') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    HASH_MD5_PO: HASH_MD5_PO,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimPO').modal('hide');
                        window.location.href = '<?php echo site_url('PO') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //GET UPDATE untuk Edit Gambar
        item_edit_upload_gambar.onclick = function() {
            $('#ModalEditGambar').modal('show');
        };
    });
</script>

</body>

</html>