<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form SPPB Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPPB/') ?>">SPPB Pembelian</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form SPPB Pembelian</a>
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

    <!-- Identitas Form SPPB -->
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
                <iframe class="responsive-iframe" src="<?php echo base_url('assets/SPPB/') ?><?php echo $FILE_NAME_TEMP; ?>"></iframe>
            </div>
            </br>
            <a href="<?php echo base_url('index.php/SPPB/') ?>" class="btn btn-primary"> Kembali Ke Halaman List SPPB Pembelian</a>
            <a href="<?php echo base_url('index.php/SPPB_form/telusur/') ?><?php echo $HASH_MD5_SPPB; ?>" class="btn btn-primary"><span class="fa fa-random"></span> Telusur SPPB</a>
            <a href="<?php echo base_url('index.php/SPPB_form/index/') ?><?php echo $HASH_MD5_SPPB; ?>" class="btn btn-warning"><span class="fa fa-pencil"></span> Ubah SPPB Pembelian</a>
            <a href="javascript:;" id="item_edit_kirim_sppb" name="item_edit_kirim_sppb" class="btn btn-success" data="<?php echo $ID_SPPB; ?>"><span class="fa fa-send"></span> Ajukan SPPB Pembelian</a><br>
            <select name="PROGRESS_SPPB" class="btn" name="PROGRESS_SPPB" id="PROGRESS_SPPB">
                <option value='<?php echo $PROGRESS_SPPB; ?>'><?php echo $PROGRESS_SPPB; ?></option>
                <option value='Diproses oleh Staff Procurement SP'>Diproses oleh Staff Procurement SP</option>
                <option value='Diproses oleh Supervisi Procurement SP'>Diproses oleh Supervisi Procurement SP</option>
                <option value='Diproses oleh Staff Procurement KP'>Diproses oleh Staff Procurement KP</option>
                <option value='Diproses oleh Kasie Procurement KP'>Diproses oleh Kasie Procurement KP</option>
                <option value='Diproses oleh Manajer Procurement KP'>Diproses oleh Manajer Procurement KP</option>
            </select>

            
        </div>
    </div>
    <!-- End Identitas Form SPPB -->

    <!-- Upload Document Form SPPB -->
    <?php if ($FILE == "ADA") { ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download/Upload Attachment Dokumen SPPB</h5>
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
                                <?php foreach ($dokumen as $sppb_form_file) {
                                    if ($sppb_form_file->JENIS_FILE == "Dokumen Cap Basah" || $sppb_form_file->JENIS_FILE == "Dokumen Lainnya") { ?>

                                        <div class="file-box">
                                            <div class="file">
                                                <a href="#">
                                                    <span class="corner"></span>

                                                    <?php if ($sppb_form_file->JENIS_FILE == "Gambar Produk") {
                                                        echo ("<div class='image'>
                                        <img alt='image' class='img-responsive' 
                                        src='" . base_url() . $sppb_form_file->KETERANGAN . "'></div>");
                                                    } else {
                                                        echo ("<div class='icon'>
                                        <i class='fa fa-file'></i>
                                        </div>");
                                                    } ?>

                                                    <div class="file-name">
                                                        <a href="<?php echo base_url(); ?>assets/upload_sppb_form_file/<?php echo $sppb_form_file->DOK_FILE; ?>">Lihat file</a>
                                                        <br />
                                                        <small>Jenis file: <?php echo $sppb_form_file->JENIS_FILE; ?></small>
                                                        <br />
                                                        <small>Diupload: <?php echo $sppb_form_file->TANGGAL_UPLOAD; ?></small>
                                                    </div>
                                                    <input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>index.php/sppb_form/hapus_file/<?php echo $sppb_form_file->DOK_FILE; ?>';" value="Hapus" />
                                                </a>
                                            </div>
                                        </div>

                                <?php }
                                } ?>
                            </div>

                        </div>
                    </div>
                </div>
                <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_SPPB; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen SPPB</a>
            </div>
        </div>
    <?php } else { ?>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Download/Upload Attachment Dokumen SPPB</h5>
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
                <a href="javascript:;" id="item_edit_upload_gambar" name="item_edit_upload_gambar" class="btn btn-primary" data="<?php echo $HASH_MD5_SPPB; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload Dokumen SPPB Cap Basah</a>
            </div>
        </div>
    <?php } ?>
    </div>
    <!-- End Upload Document Form SPPB -->

    <!-- MODAL EDIT KIRIM SPPB-->
    <div class="modal inmodal fade" id="ModalEditKirimSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Ajukan SPPB</h4>
                <small class="font-bold">Selesaikan proses dan ajukan Form SPPB ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_SPPB7" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_kirim_sppb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SPPB7" id="ID_SPPB7" class="form-control" type="hidden" placeholder="ID SPPB"
                        readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <center><div class="i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai
                        melakukan proses form SPPB ini dan menyetujui untuk diproses lebih lanjut </label></div>
                        </center>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang/jasa yang diminta pada SPPB
                                ini
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_tidak_ada_attachment_dokumen" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>
                                Proses tidak dapat dilanjutkan, tidak ada attachment dokumen <b> SPPB Cap Basah </b> yang diminta pada SPPB ini
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item jumlah barang/jasa yang bernilai 0
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_nama_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item nama barang/jasa yang belum diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_spesifikasi_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item spefisikasi barang/jasa yang belum
                                diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_rab_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item kategori RAB barang/jasa yang belum
                                diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_klasifikasi_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item klasifikasi barang/jasa yang belum
                                diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_satuan_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item satuan barang/jasa yang belum diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_rasd_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item RASD barang/jasa yang belum diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_sub_pekerjaan" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item Jenis Pekerjaan yang belum diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_tanggal_mulai_selesai" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang yang belum diatur tanggal
                                mulai dan selesai pemakaian</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_bidang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang yang belum diatur bidang
                                pemakai</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_peralatan_perlengkapan" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang yang belum diatur
                                Tool/Consumable/Material</center>
                        </div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_sppb" disabled><i class="fa fa-send"></i>
                        Ajukan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    </div>
    <!--END MODAL EDIT KIRIM SPPB-->

    <!-- MODAL UPLOAD DOCUMENT -->
    <div class="modal inmodal fade" id="ModalEditGambar" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Upload Dokumen SPPB Pembelian Cap Basah</h4>
                <small class="font-bold">Silakan Upload Dokumen SPPB Pembelian Cap Basah</small>
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
                                        File dokumen yang Anda upload akan digunakan untuk keperluan SPPB, dengan ketentuan sebagai berikut:
                                    <ul class="sortable-list connectList agile-list" id="ketentuan">
                                        <li class="warning-element" id="task1">
                                            1. File dokumen yang diupload harus merupakan data berkaitan dengan SPPB.
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
                url: "<?php echo base_url('index.php/SPPB_form/proses_upload_file') ?>",
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
                            url: "<?php echo base_url('index.php/SPPB_form/proses_upload_file') ?>",
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

        let ID_SPPB = <?php echo $ID_SPPB  ?>;
        let HASH_MD5_SPPB = "<?php echo $HASH_MD5_SPPB ?>";

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_sppb').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_sppb').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM SPPB 
        $('#btn_update_kirim_sppb').on('click', function() {

            let ID_SPPB = $('#ID_SPPB7').val();
            $.ajax({
                url: "<?php echo site_url('SPPB_form/update_data_kirim_sppb_pembelian') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPPB: ID_SPPB,
                },
                success: function(data) {
                    if (data == true) {

                        $('#ModalEditKirimSPPB').modal('hide');
                        window.location.href = '<?php echo base_url(); ?>SPPB_form/view/' + HASH_MD5_SPPB;

                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        item_edit_kirim_sppb.onclick = function () {
            var ID_SPPB = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPPB_form/data_sppb_form_kirim_SPPB') ?>",
                dataType: "JSON",
                data: {
                    ID_SPPB: ID_SPPB
                },
                success: function (data) {
                    $('#ModalEditKirimSPPB').modal('show');

                    $('[name="ID_SPPB7"]').val(data[0].ID_SPPB);

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD ke SPPB FORM
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);

                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        var i = 0;
                        var banyak_barang = data.length;
                        for (i = 0; i < data.length; i++) {
                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH_QTY_SPP == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_jumlah_barang').attr("hidden", false);
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

                            if (data[i].TANGGAL_MULAI_PAKAI_HARI == "" || data[i].TANGGAL_MULAI_PAKAI_HARI == "00/00/0000" || data[i].TANGGAL_MULAI_PAKAI_HARI == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_tanggal_mulai_selesai').attr("hidden", false);
                                break;
                            }
                        }

                        if (i == banyak_barang) {
                            var ID_SPPB = data[0].ID_SPPB;
                            $.ajax({
                                type: "GET",
                                url: "<?php echo base_url('SPPB_form/data_sppb_form_file') ?>",
                                dataType: "JSON",
                                data: {
                                    ID_SPPB: ID_SPPB
                                },
                                success: function (data) {
                                    

                                    $('#ModalEditKirimSPPB').modal('show');

                                    $('[name="ID_SPPB7"]').val(ID_SPPB);

                                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD ke SPPB FORM
                                        $('#show_hidden_setuju').attr("hidden", true);
                                        $('#show_hidden_tidak_ada_attachment_dokumen').attr("hidden", false);

                                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                                        var j = 0;
                                        for (j = 0; j < data.length; j++) {
                                            //JIKA SEMUA ITEM BARANG ADA JUMLAH MINTANYA (TIDAK NOL)
                                            if (j == (data.length - 1)) {
                                                $('#show_hidden_setuju').attr("hidden", false);
                                            }
                                        }
                                    }
                                }
                            });

                        }


                    }
                }
            });
            return false;
        };

        //GET UPDATE untuk Edit Gambar
        item_edit_upload_gambar.onclick = function() {
            $('#ModalEditGambar').modal('show');
        };

        $("#PROGRESS_SPPB").change(function () {

            var PROGRESS_SPPB = $('[name="PROGRESS_SPPB"]').val();

            var form_data = {
                ID_SPPB: ID_SPPB,
                PROGRESS_SPPB: PROGRESS_SPPB
            }

            $.ajax({
                url: "<?php echo base_url(); ?>/SPPB_form/update_progress",
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