<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form FISTB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/FSTB/') ?>">FISTB</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form FISTB</a>
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

    <!-- Identitas Form FSTB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>fstb_<?php echo $HASH_MD5_FSTB; ?></h5>
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/FSTB/') ?>fstb_<?php echo $HASH_MD5_FSTB; ?>.pdf"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/FSTB_form/index/') ?><?php echo $HASH_MD5_FSTB; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah FSTB</a>
            <a href="javascript:;" id="item_edit_kirim_fstb" name="item_edit_kirim_fstb" class="btn btn-primary" data="<?php echo $ID_FSTB; ?>"><span class="fa fa-send"></span> Ajukan FISTB Untuk Proses Selanjutnya </a><br>
            <select name="PROGRESS_FSTB" class="btn" name="PROGRESS_FSTB" id="PROGRESS_FSTB">
                <option value='<?php echo $PROGRESS_FSTB; ?>'><?php echo $PROGRESS_FSTB; ?></option>
                <option value='Diproses oleh Staff Procurement SP'>Diproses oleh Staff Procurement SP</option>
                <option value='Diproses oleh Supervisi Procurement SP'>Diproses oleh Supervisi Procurement SP</option>
                <option value='Diproses oleh Staff Procurement KP'>Diproses oleh Staff Procurement KP</option>
                <option value='Diproses oleh Kasie Procurement KP'>Diproses oleh Kasie Procurement KP</option>
                <option value='Diproses oleh Manajer Procurement KP'>Diproses oleh Manajer Procurement KP</option>
            </select>
            
        </div>
    </div>
    <!-- End Identitas Form FISTB -->


        <!-- Upload Document Form FISTB -->
        <?php if ($FILE == "ADA") { ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download/Upload Attachment Dokumen FISTB</h5>
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
                                <?php foreach ($dokumen as $fstb_form_file) {
                                    if ($fstb_form_file->JENIS_FILE == "Dokumen Cap Basah" || $fstb_form_file->JENIS_FILE == "Dokumen Lainnya") { ?>
                                        <div class="file-box">
                                            <div class="file">
                                                <a href="#">
                                                    <span class="corner"></span>

                                                    <?php if ($fstb_form_file->JENIS_FILE == "Gambar Produk") {
                                                        echo ("<div class='image'>
                                        <img alt='image' class='img-responsive' 
                                        src='" . base_url() . $fstb_form_file->KETERANGAN . "'></div>");
                                                    } else {
                                                        echo ("<div class='icon'>
                                        <i class='fa fa-file'></i>
                                        </div>");
                                                    } ?>

                                                    <div class="file-name">
                                                        <a href="<?php echo base_url(); ?>assets/upload_fstb_form_file/<?php echo $fstb_form_file->DOK_FILE; ?>">Lihat file</a>
                                                        <br />
                                                        <small>Jenis file: <?php echo $fstb_form_file->JENIS_FILE; ?></small>
                                                        <br />
                                                        <small>Diupload: <?php echo $fstb_form_file->TANGGAL_UPLOAD; ?></small>
                                                    </div>
                                                    <input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>index.php/fstb_form/hapus_file/<?php echo $fstb_form_file->DOK_FILE; ?>';" value="Hapus" />
                                                </a>
                                            </div>
                                        </div>

                                <?php }
                                } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_FSTB; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen FISTB</a>
            </div>
        </div>
    <?php } else { ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download/Upload Attachment Dokumen FISTB</h5>
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
                <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_FSTB; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen FISTB Cap Basah</a>
            </div>
        </div>
    <?php } ?>
    <!-- End Upload Document Form FISTB -->

</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <style>
        .container_iframe {
            position: relative;
            overflow: hidden;
            width: 100%;
            padding-top: 24.5%;
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

</div>



<!-- MODAL KIRIM FISTB-->
<div class="modal inmodal fade" id="ModalEditKirimFISTB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim FISTB</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form FISTB ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_FSTB7" => "contact_form", "id" => "contact_form");
            echo form_open("FSTB_form/update_data_kirim_fstb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_FSTB7" id="ID_FSTB7" class="form-control" type="hidden" placeholder="ID FSTB" readonly>
                    
                    <div id="show_hidden_setuju" class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form FISTB ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang diminta pada FISTB ini</center>
                        </div>
                    </div>

                    <div id="show_hidden_tidak_ada_jumlah_tolak_atau_terima" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang ditolak atau diterima pada FISTB ini</center>
                        </div>
                    </div>
                    
                    <div id="alert-msg-7"></div>
                
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_fstb" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM FISTB-->

<!-- MODAL UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalEditGambar" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Upload Dokumen FISTB Cap Basah</h4>
                <small class="font-bold">Silakan Upload Dokumen FISTB Cap Basah</small>
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
                                        File dokumen yang Anda upload akan digunakan untuk keperluan FISTB, dengan ketentuan sebagai berikut:
                                    <ul class="sortable-list connectList agile-list" id="ketentuan">
                                        <li class="warning-element" id="task1">
                                            1. File dokumen yang diupload harus merupakan data berkaitan dengan FISTB.
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
                url: "<?php echo base_url('index.php/FSTB_form/proses_upload_file') ?>",
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
                            url: "<?php echo base_url('index.php/FSTB_form/proses_upload_file') ?>",
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

        let ID_FSTB = <?php echo $ID_FSTB  ?>;

        item_edit_kirim_fstb.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FSTB_form/data_fstb_form') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#ModalEditKirimFISTB').modal('show');
                    $.each(data, function() {
                        $('[name="ID_FSTB7"]').val(data[0].ID_FSTB);
                    });

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);

                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        var i = 0;
                        for (i = 0; i < data.length; i++) {
                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH_DITERIMA == 0 | data[i].JUMLAH_DITERIMA == null | data[i].JUMLAH_DITOLAK == "" | data[i].JUMLAH_DITOLAK == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_tidak_ada_jumlah_tolak_atau_terima').attr("hidden", false);
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

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_fstb').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_fstb').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM FSTB 
        $('#btn_update_kirim_fstb').on('click', function() {

            let ID_FSTB = $('#ID_FSTB7').val();
            $.ajax({
                url: "<?php echo site_url('FSTB_form/update_data_kirim_fstb') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FSTB: ID_FSTB,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimFSTB').modal('hide');
                        window.location.href = '<?php echo site_url('FSTB') ?>';
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

        $("#PROGRESS_FSTB").change(function () {

            var PROGRESS_FSTB = $('[name="PROGRESS_FSTB"]').val();

            var form_data = {
                ID_FSTB: ID_FSTB,
                PROGRESS_FSTB: PROGRESS_FSTB
            }

            $.ajax({
                url: "<?php echo base_url(); ?>/FSTB_form/update_progress",
                method: "POST",
                data: form_data,
                async: false,
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                }
            });

        });
    });
</script>

</body>

</html>