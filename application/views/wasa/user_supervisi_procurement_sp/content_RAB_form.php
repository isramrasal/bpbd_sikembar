<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form RAB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/RAB/') ?>">RAB</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form RAB</a>
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
            <h5>Formulir Pengisian RAB Proyek</h5>
        </div>
        <div class="ibox-content">
            <div class="form-horizontal">
                <?php
                if (isset($rab)) {
                    foreach ($rab->result() as $rab) :
                ?>
                        <div class="form-group"><label class="col-sm-2 control-label">Nama Proyek</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rab->NAMA_PROYEK; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Pekerjaan</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rab->NAMA_SUB_PEKERJAAN; ?>" disabled>
                            </div>
                        </div>
                <?php endforeach;
                } ?>
            </div>
        </div>
    </div>

    <!-- TAMPILAN KATEGORI RAB -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>RAB Proyek</h5>
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
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddRABP"><span class="fa fa-plus"></span> Tambah Kategori RAB</a>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <th>Nama Kategori</th>
                                    <th>Rencana Anggaran</th>
                                    <th>Realisasi Anggaran</th>
                                    <th>Sisa Anggaran</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="show_data_RAB">

                            </tbody>

                        </table>
                    </div>
                    

                </div>

            </div>
        </div>
    </div>
    <!-- END TAMPILAN KATEGORI RABP -->


    <!-- BAGIAN DOWNLOAD FILE -->
    <?php if ($FILE == "ADA") { ?>
        <div class="row">
            <div class="col-lg-9 animated fadeInRight">
                <div class="row">
                    <div class="col-lg-12">
                        <?php foreach ($dokumen as $proyek_file) { ?>

                            <div class="file-box">
                                <div class="file">
                                    <a href="#">
                                        <span class="corner"></span>

                                        <div class="icon">
                                            <i class="fa fa-file"></i>
                                        </div>
                                        <div class="file-name">
                                            <a href="<?php echo base_url(); ?>assets/upload_proyek_file/<?php echo $proyek_file->DOK_FILE; ?>">Download file</a>
                                            <br />
                                            <small>Jenis file: <?php echo $proyek_file->JENIS_FILE; ?></small>
                                            <br />
                                            <small>Keterangan file: <?php echo $proyek_file->KETERANGAN_FILE; ?></small>
                                            <br />
                                            <small>Diupload: <?php echo $proyek_file->TANGGAL_UPLOAD; ?></small>
                                        </div>
                                        <input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>index.php/RAB_form/hapus_file/<?php echo $proyek_file->DOK_FILE; ?>';" value="Hapus" />

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
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Download File Dokumen</h5>
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
                        Belum ada file dokumen. Silakan upload file dokumen.
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>
    <!-- BAGIAN DOWNLOAD FILE -->

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
                        File dokumen yang Anda upload akan digunakan untuk keperluan proyek, dengan ketentuan sebagai berikut:
                    <ul class="sortable-list connectList agile-list" id="ketentuan">
                        <li class="warning-element" id="task1">
                            1. File dokumen yang diupload harus merupakan data milik proyek.
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
                                <option value='Belum didefinisikan'>- Pilih Jenis File Dokumen -</option>
                                <option value='RAB'>RAB</option>
                                <option value='Dokumen Lainnya'>Dokumen Proyek Lainnya</option>
                            </select>
                            </br>
                            <input name="KETERANGAN_FILE" id="KETERANGAN_FILE" class="form-control" type="text" placeholder="Keterangan File Dokumen" required>

                        </div>
                        </br>
                        </br>
                        </br>
                        </br>
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


<!-- MODAL ADD RABP-->
<div class="modal inmodal fade" id="ModalAddRABP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 50vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">RAB Proyek</h4>
                <small class="font-bold">Silakan tambah data nama kategori</small>
            </div>
            <?php $attributes = array("nama_rabp" => "nama_Sub nama_rabp", "id" => "id");
            echo form_open("RAB_form/simpan_data_rab", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Kategori</label>
                        <div class="col-xs-9">
                            <input name="NAMA_KATEGORI_5" id="NAMA_KATEGORI_5" class="form-control" type="text" placeholder="Contoh: CONSUMABLE">
                            <input name="ID_PROYEK_5" id="ID_PROYEK_5" class="form-control" type="hidden" value="<?= $ID_PROYEK; ?>">
                            <input name="ID_RAB_5" id="ID_RAB_5" class="form-control" type="hidden" value="<?= $ID_RAB; ?>">
                            <input name="ID_PROYEK_SUB_PEKERJAAN_5" id="ID_PROYEK_SUB_PEKERJAAN_5" class="form-control" type="hidden" value="<?= $ID_PROYEK_SUB_PEKERJAAN; ?>">
                        </div>
                    </div>

                    <div id="alert-msg-6"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan_rab"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD RABP-->


<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 50vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">RAB Proyek</h4>
                <small class="font-bold">Silakan edit data RAB Proyek</small>
            </div>
            <?php $attributes = array("ID_RAB_FORM2" => "contact_form", "id" => "contact_form");
            echo form_open("RAB_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Kategori</label>
                        <div class="col-xs-9">
                            <input name="NAMA_KATEGORI_2" id="NAMA_KATEGORI_2" class="form-control" type="text" placeholder="Contoh: CONSUMABLE">
                            <input name="ID_PROYEK_2" id="ID_PROYEK_2" class="form-control" type="hidden" value="<?= $ID_PROYEK; ?>">
                            <input name="ID_RAB_2" id="ID_RAB_2" class="form-control" type="hidden" value="<?= $ID_RAB; ?>">
                            <input name="ID_RAB_FORM_2" id="ID_RAB_FORM_2" class="form-control" type="hidden">
                            <input name="ID_PROYEK_SUB_PEKERJAAN_2" id="ID_PROYEK_SUB_PEKERJAAN_2" class="form-control" type="hidden" value="<?= $ID_PROYEK_SUB_PEKERJAAN; ?>">
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

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" style="width: 50vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Data RAB</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
                        <div name="NAMA_KATEGORI3" id="NAMA_KATEGORI3"></div>
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

    var file_upload = new Dropzone(".dropzone", {
		url: "<?php echo base_url('index.php/RAB_form/proses_upload_file') ?>",
		maxFilesize: 1500,
		method: "post",
		acceptedFiles: "image/jpeg,image/png,image/jpg,image/bmp,application/pdf,.doc,.docx,.xls,.xlsx,.csv,.tsv,.ppt,.pptx,.pages,.odt,.rtf",
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
					JENIS_FILE: $('#JENIS_FILE').val(),
					KETERANGAN_FILE: $('#KETERANGAN_FILE').val()
				};
				$.ajax({
					url: "<?php echo base_url('index.php/RAB_form/proses_upload_file') ?>",
					type: 'POST',
					data: form_data,
					success: function(data) {
						if (data != '') {
							console.log("waduh");
						} else {
							console.log("waduh 2");
						}
					}
				});
			});


			this.on("success", function(file, responseText) {
				location.reload();;
			});
		}
	});


    $(document).ready(function() {
        let ID_RAB = <?php echo $ID_RAB  ?>;
        let ID_PROYEK_SUB_PEKERJAAN = <?php echo $ID_PROYEK_SUB_PEKERJAAN  ?>;

        tampil_data_RAB_form(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            columns: [
                { width: "25%" },
                { width: "25%" },
                { width: "25%" },
                { width: "20%" },
                { width: "1%" }
            ],
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
                    title: 'RAB'
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


        //fungsi tampil data
        function tampil_data_RAB_form() {
            var RENCANA_ANGGARAN = 0;
            var REALISASI_ANGGARAN = 0;
            var SISA_ANGGARAN = 0;
            var TOTAL_RENCANA_ANGGARAN = 0;
            var TOTAL_REALISASI_ANGGARAN = 0;
            var TOTAL_SISA_ANGGARAN = 0;

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>RAB_form/data_RAB_form',
                async: false,
                dataType: 'json',
                data: {
                    ID_RAB: ID_RAB
                },
                success: function(data) {

                    data_1 = data;
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {

                        var  ID_RAB_FORM = data_1[i].ID_RAB_FORM;

                        $.ajax({
                            url: "<?php echo site_url('RAB_form/get_list_rasd_by_id_rab_form') ?>",
                            type: "POST",
                            dataType: "JSON",
                            async: false,
                            data: {
                                ID_RAB_FORM: ID_RAB_FORM,
                            },
                            success: function(data) {
                                
                                var data_2 = data;

                                $.ajax({
                                    url: "<?php echo site_url('RAB_form/get_total_harga_by_id_rab_form') ?>",
                                    type: "POST",
                                    dataType: "JSON",
                                    async: false,
                                    data: {
                                        ID_RASD: data_2[0].ID_RASD,
                                    },
                                    success: function(data) {
                                        var data_3 = data;
    
                                        var html_keterangan_RASD = "";

                                        var form_data = {
                                            ID_RAB_FORM: ID_RAB_FORM
                                        }

                                        var TOTAL_HARGA_TOTAL = 0;

                                        var REALISASI_ANGGARAN = '';

                                        $.ajax({
                                            type: 'POST',
                                            url: '<?php echo base_url() ?>RAB_form/data_sum_qty_rasd_realisasi_item_barang',
                                            async: false,
                                            dataType: 'json',
                                            data: form_data,
                                            success: function(data) {

                                                data_5 = data;

                                                for (m = 0; m < data_5.length; m++) {

                                                    var HARGA_TOTAL = Number(data_5[m].HARGA_TOTAL);
                                                    TOTAL_HARGA_TOTAL = Number(TOTAL_HARGA_TOTAL) + Number(HARGA_TOTAL);
                                                }

                                                REALISASI_ANGGARAN = new Intl.NumberFormat('id-ID', {
                                                    style: 'currency',
                                                    currency: 'IDR',
                                                    maximumFractionDigits: 0, 
                                                    minimumFractionDigits: 0,
                                                }).format(TOTAL_HARGA_TOTAL);

                                                RENCANA_ANGGARAN_NUMERIC = 0;
                                                for (k = 0; k < data_3.length; k++) {
                                                    RENCANA_ANGGARAN_NUMERIC += (data_3[k].HARGA_BARANG * data_3[k].JUMLAH_BARANG);
                                                }

                                                RENCANA_ANGGARAN = new Intl.NumberFormat('id-ID', {
                                                    style: 'currency',
                                                    currency: 'IDR',
                                                    maximumFractionDigits: 0, 
                                                    minimumFractionDigits: 0,
                                                }).format(RENCANA_ANGGARAN_NUMERIC);

                                                // REALISASI_ANGGARAN = new Intl.NumberFormat('id-ID', {
                                                //     style: 'currency',
                                                //     currency: 'IDR',
                                                //     maximumFractionDigits: 0, 
                                                //     minimumFractionDigits: 0,
                                                // }).format(0); //BELUM DIAMBIL DARI TABEL REALISASI

                                                SISA_ANGGARAN = new Intl.NumberFormat('id-ID', {
                                                    style: 'currency',
                                                    currency: 'IDR',
                                                    maximumFractionDigits: 0, 
                                                    minimumFractionDigits: 0,
                                                }).format(RENCANA_ANGGARAN_NUMERIC - TOTAL_HARGA_TOTAL);


                                                html_keterangan_RASD = "";
                                                
                                                html += '<tr>' +
                                                    '<td>' + data_1[i].NAMA_KATEGORI + '</td>' +
                                                    '<td>' + RENCANA_ANGGARAN + html_keterangan_RASD + '</td>' +
                                                    '<td>' + REALISASI_ANGGARAN + '</td>' +
                                                    '<td>' + SISA_ANGGARAN + "</br>" + '</td>' +
                                                    '<td>';

                                                for (j = 0; j < data_2.length; j++) {
                                                    var nama_rasd = '';
                                                    nama_rasd = '<a href="<?php echo base_url() ?>rasd_form/index/' + data_2[j].HASH_MD5_RASD + '" class="btn btn-primary btn-xs block"><i class="fa fa-cogs"></i> Atur RASD </a>' + ' ';
                                                    html += nama_rasd;
                                                }

                                                html += '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data_1[i].ID_RAB_FORM + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
                                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data_1[i].ID_RAB_FORM + '"><i class="fa fa-trash"></i> Hapus </a>' +
                                                    '</td>' +
                                                    '</tr>';

                                            }
                                        });

                                    }
                                });

                            }
                        });
                    }
                    $('#show_data_RAB').html(html);
                }
            });
        }

        //GET UPDATE
        $('#show_data_RAB').on('click', '.item_edit', function() {
            var ID_RAB_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RAB_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_RAB_FORM: ID_RAB_FORM
                },
                success: function(data) {
                    $.each(data, function() {

                        $('#ModalEdit').modal('show');
                        $('[name="ID_RAB_FORM_2"]').val(data.ID_RAB_FORM);
                        $('[name="NAMA_KATEGORI_2"]').val(data.NAMA_KATEGORI);
                        $('[name="RENCANA_ANGGARAN_2"]').val(data.RENCANA_ANGGARAN);
                        $('#NAMA_RASD_2').attr("disabled", true);
                        $('#alert-msg-2').html('<div></div>');
                    });
                }
            });
            return false;
        });


        //GET HAPUS
        $('#show_data_RAB').on('click', '.item_hapus', function() {
            var ID_RAB_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('index.php/RAB_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_RAB_FORM: ID_RAB_FORM
                },
                success: function(data) {

                    $.each(data, function(NAMA, MEREK) {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(data.ID_RAB_FORM);
                        $('#NAMA_KATEGORI3').html('Nama Kategori: ' + data.NAMA_KATEGORI);
                    });
                }
            });
        });


        //SIMPAN DATA RAB
        $('#btn_simpan_rab').click(function() {
 
            var form_data = {
                ID_RAB: $('#ID_RAB_5').val(),
                ID_PROYEK: $('#ID_PROYEK_5').val(),
                ID_PROYEK_SUB_PEKERJAAN: $('#ID_PROYEK_SUB_PEKERJAAN_5').val(),
                NAMA_KATEGORI: $('#NAMA_KATEGORI_5').val()
            };

            $.ajax({
                url: "<?php echo site_url('RAB_form/simpan_data_rab'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $('[name="NAMA_KATEGORI_5"]').val("");
                        $('#ModalAddRABP').modal('hide');
                        window.location.reload();
                    }
                }
            });
            return false;
        });

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            var form_data = {
                ID_RAB: $('#ID_RAB_2').val(),
                ID_PROYEK: $('#ID_PROYEK_2').val(),
                ID_PROYEK_SUB_PEKERJAAN: $('#ID_PROYEK_SUB_PEKERJAAN_2').val(),
                ID_RAB_FORM: $('#ID_RAB_FORM_2').val(),
                NAMA_KATEGORI: $('#NAMA_KATEGORI_2').val(),
                JENIS_RASD: $('#JENIS_RASD_2').val(),
            };

            $.ajax({
                url: "<?php echo site_url('RAB_form/update_data') ?>",
                type: "POST",
                data: form_data,
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

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RAB_form/hapus_data') ?>",
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