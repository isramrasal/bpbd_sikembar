<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form KHP</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/KHP/') ?>">KHP</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form KHP</a>
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

    <!-- Identitas Form KHP -->
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/KHP/') ?><?php echo $FILE_NAME_TEMP; ?>"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/KHP/') ?>" class="btn btn-info"> Kembali Ke Halaman List KHP</a>
            <?php if ($PROGRESS_KHP == "DRAFT") { ?>
                <a href="<?php echo base_url('index.php/KHP_form/index/') ?><?php echo $HASH_MD5_KHP; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah KHP</a>

            <?php
            }
            ?>
            <a href="javascript:;" id="item_edit_kirim_email_khp" name="item_edit_kirim_email_khp" class="btn btn-primary" data="<?php echo $HASH_MD5_KHP; ?>"><span class="fa fa-send"></span> Kirim KHP ke Vendor</a>
            <a href="<?php echo base_url('index.php/KHP_form/pengajuan_vendor/') ?><?php echo $HASH_MD5_KHP; ?>" class="btn btn-primary"><span class="fa fa-book"></span> Lihat Harga Pengajuan Vendor</a>

        </div>
    </div>
    <!-- End Identitas Form KHP -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Download/Upload Dokumen KHP Cap Basah</h5>
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
            <?php if ($FILE == "ADA") { ?>
                <div class="row">
                    <div class="col-lg-9 animated fadeInRight">
                        <div class="row">
                            <div class="col-lg-12">
                                <?php foreach ($dokumen as $barang_master_file) { ?>

                                    <div class="file-box">
                                        <div class="file">
                                            <a href="#">
                                                <span class="corner"></span>

                                                <?php if ($barang_master_file->JENIS_FILE == "Gambar Produk") {
                                                    echo ("<div class='image'>
										<img alt='image' class='img-responsive' 
										src='" . base_url() . $barang_master_file->KETERANGAN . "'></div>");
                                                } else {
                                                    echo ("<div class='icon'>
										<i class='fa fa-file'></i>
										</div>");
                                                } ?>

                                                <div class="file-name">
                                                    <a href="<?php echo base_url(); ?>assets/upload_khp_form_file/<?php echo $barang_master_file->DOK_FILE; ?>">Download file</a>
                                                    <br />
                                                    <small>Jenis file: <?php echo $barang_master_file->JENIS_FILE; ?></small>
                                                    <br />
                                                    <small>Diupload: <?php echo $barang_master_file->TANGGAL_UPLOAD; ?></small>
                                                </div>
                                                <input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>index.php/khp_form/hapus_file/<?php echo $barang_master_file->DOK_FILE; ?>';" value="Hapus" />

                                            </a>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>

            <?php } else { ?>


                <div class="row">
                    <div class="col-lg-12">
                        Belum ada file dokumen. Silakan upload file dokumen.
                    </div>
                </div>
            <?php } ?>
            </br>
            </br>
            <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_KHP; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Foto Tanda Tangan Basah</a>
        </div>
    </div>
</div>


<!-- MODAL KIRIM KHP-->
<div class="modal inmodal fade" id="ModalEditKirimKHP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim KHP</h4>
                <small class="font-bold">Selesaikan proses dan simpan Form KHP ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("HASH_MD5_KHP7" => "contact_form", "id" => "contact_form");
            echo form_open("KHP_form/update_data_kirim_khp", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="HASH_MD5_KHP7" id="HASH_MD5_KHP7" class="form-control" type="hidden" placeholder="ID KHP" readonly>


                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan pengisian form KHP ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_khp" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM KHP-->

<!-- MODAL EDIT GAMBAR -->
<div class="modal inmodal fade" id="ModalEditGambar" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Upload Dokumen KHP Cap Basah</h4>
                <small class="font-bold">Silakan Upload Dokumen KHP Cap Basah</small>
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
                url: "<?php echo base_url('index.php/KHP_form/proses_upload_file') ?>",
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
                            url: "<?php echo base_url('index.php/KHP_form/proses_upload_file') ?>",
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
                    url: "<?php echo base_url('index.php/KHP_form/remove_file') ?>",
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

        let ID_KHP = <?php echo $ID_KHP  ?>;

        item_edit_kirim_email_khp.onclick = function() {
            var HASH_MD5_KHP = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('KHP_form/get_id_khp_by_HASH_MD5_KHP') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_KHP: HASH_MD5_KHP
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditKirimKHP').modal('show');
                        $('[name="HASH_MD5_KHP7"]').val(data.HASH_MD5_KHP);

                        $('#alert-msg-7').html('<div></div>');
                    });
                }
            });
            return false;
        };

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_khp').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_khp').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM KHP 
        $('#btn_update_kirim_khp').on('click', function() {

            let HASH_MD5_KHP = $('#HASH_MD5_KHP7').val();
            $.ajax({
                url: "<?php echo site_url('KHP_form/update_data_kirim_khp') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    HASH_MD5_KHP: HASH_MD5_KHP,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimKHP').modal('hide');
                        var alamat = "<?php echo base_url('KHP_form/kirim_email/'); ?>" + HASH_MD5_KHP;
                        window.open(
                            alamat
                        );
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