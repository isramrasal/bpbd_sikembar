<?php
function tanggal_indo_full($tanggal, $cetak_hari = false)
{
    if($tanggal == '0000-00-00')
    {
        $tgl_indo = "-";
        return $tgl_indo;
    }

    else if($tanggal == NULL)
    {
        $tgl_indo = "-";
        return $tgl_indo;
    }

    else
    {
        $hari = array ( 1 =>    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu',
                    'Minggu'
                );
                
        $bulan = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        $split 	  = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        
        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;

    }
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form Data Korban</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/Data_Korban/') ?>">Data Korban</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form Data Korban</a>
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

    <!-- Identitas Form Pengajuan -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian Data Korban</h5>
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

            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1">Identitas Form</a></li>

                    <li class="" style="display:none;"><a data-toggle="tab" href="#tab-2">Catatan Data Korban</a></li>

                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form method="get" class="form-horizontal">
                                <?php
                                if (isset($Korban)) {
                                    foreach ($Korban as $Korban):
                                        ?>
                                <div class="form-group"><label class="col-sm-2 control-label">Nama Korban</label>
                                    <div class="col-sm-10">
                                        <input name="NAMA_KORBAN_GANTI" id="NAMA_KORBAN_GANTI" type="text"
                                            class="form-control" value="<?php echo $Korban->NAMA_KORBAN; ?>">
                                        <input name="NAMA_KORBAN_GANTI_ASLI" id="NAMA_KORBAN_GANTI_ASLI" type="hidden"
                                            class="form-control" value="<?php echo $Korban->NAMA_KORBAN; ?>">
                                    </div>
                                </div>

                                <div class="form-group" id="data_TANGGAL_LAHIR"><label
                                        class="col-sm-2 control-label">Tanggal Lahir</label>
                                    <div class="col-sm-10">
                                        <?php
                                                if (empty($Korban->TANGGAL_LAHIR)) {
                                                ?>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                                id="TANGGAL_LAHIR" name="TANGGAL_LAHIR" type="text" class="form-control"
                                                placeholder="dd/mm/yyyy">
                                        </div>
                                        <?php
                                                } else {
                                                ?>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                                id="TANGGAL_LAHIR" name="TANGGAL_LAHIR" type="text" class="form-control"
                                                placeholder="dd/mm/yyyy" value="<?php echo $Korban->TANGGAL_LAHIR; ?>">
                                        </div>
                                        <?php
                                                }
                                                ?>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Jenis Bencana</label>
                                    <div class="col-sm-10"><input name="JENIS_BENCANA" id="JENIS_BENCANA" type="text"
                                            class="form-control" value="<?php echo $Korban->JENIS_BENCANA; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">NO_KK</label>
                                    <div class="col-sm-10"><input name="NO_KK" id="NO_KK" type="text"
                                            class="form-control" value="<?php echo $Korban->NO_KK; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">NIK</label>
                                    <div class="col-sm-10"><input name="NIK" id="NIK" type="text" class="form-control"
                                            value="<?php echo $Korban->NIK; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Tempat Lahir</label>
                                    <div class="col-sm-10"><input name="TEMPAT LAHIR" id="NIP" type="text"
                                            class="form-control" value="<?php echo $Korban->TEMPAT_LAHIR; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Alamat</label>
                                    <div class="col-sm-10"><input name="ALAMAT" id="JABATAN" type="text"
                                            class="form-control" value="<?php echo $Korban->ALAMAT; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Kabupaten / Kota</label>
                                    <div class="col-sm-10"><input name="KABUPATEN_KOTA" id="KABUPATEN_KOTA" type="text"
                                            class="form-control" value="<?php echo $Korban->KABUPATEN_KOTA; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Kecamatan</label>
                                    <div class="col-sm-10"><input name="KECAMATAN" id="KECAMATAN" type="text"
                                            class="form-control" value="<?php echo $Korban->KECAMATAN; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Desa / Kelurahan</label>
                                    <div class="col-sm-10"><input name="DESA_KELURAHAN" id="DESA_KELURAHAN" type="text"
                                            class="form-control" value="<?php echo $Korban->DESA_KELURAHAN; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">RT</label>
                                    <div class="col-sm-10"><input name="RT" id="RT" type="text" class="form-control"
                                            value="<?php echo $Korban->RT; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">RW</label>
                                    <div class="col-sm-10"><input name="RW" id="RW" type="text" class="form-control"
                                            value="<?php echo $Korban->RW; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Kampung</label>
                                    <div class="col-sm-10"><input name="KAMPUNG" id="KAMPUNG" type="text"
                                            class="form-control" value="<?php echo $Korban->KAMPUNG; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Kode Pos</label>
                                    <div class="col-sm-10"><input name="KODE_POS" id="KODE_POS" type="text"
                                            class="form-control" value="<?php echo $Korban->KODE_POS; ?>">
                                    </div>
                                </div>
                                <div class="form-group" id="data_TANGGAL_KEJADIAN_BENCANA"><label
                                        class="col-sm-2 control-label">Tanggal Kejadian Bencana</label>
                                    <div class="col-sm-10">
                                        <?php
                                                if (empty($Korban->TANGGAL_KEJADIAN_BENCANA)) {
                                                ?>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                                id="TANGGAL_KEJADIAN_BENCANA" name="TANGGAL_KEJADIAN_BENCANA"
                                                type="text" class="form-control" placeholder="dd/mm/yyyy">
                                        </div>
                                        <?php
                                                } else {
                                                ?>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                                id="TANGGAL_KEJADIAN_BENCANA" name="TANGGAL_KEJADIAN_BENCANA"
                                                type="text" class="form-control" placeholder="dd/mm/yyyy"
                                                value="<?php echo $Korban->TANGGAL_KEJADIAN_BENCANA; ?>">
                                        </div>
                                        <?php
                                                }
                                                ?>
                                    </div>
                                </div>


                                <?php endforeach;
                                } ?>
                            </form>
                            <!-- <div class="hr-line-dashed"></div> -->
                            <div id="alert-msg-4"></div>
                            <button class="btn btn-primary" id="btn_simpan_identitas_form"><i class="fa fa-save"></i>
                                Simpan Identitas Form</button>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">

                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan Dept. Procurement</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            </br>
                            <!-- <div class="hr-line-dashed"></div> -->

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- End Identitas Form SPPB -->
</div>


<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/summernote/summernote.min.js"></script>

<!-- TouchSpin -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/datapicker/bootstrap-datepicker.js"></script>

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
            url: "<?php echo base_url('index.php/SPPB_form/proses_upload_file_excel') ?>",
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
                        url: "<?php echo base_url('index.php/SPPB_form/proses_upload_file_excel') ?>",
                        type: 'POST',
                        data: form_data,
                        success: function(data) {
                            if (data != '') {

                            } else {

                            }
                        }
                    });
                });

                this.on("success", function(file, responseText) {

                    if (responseText ==
                        'Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon'
                    ) {
                        $('#ModalEditExcel').modal('hide')
                        $('#ModalGagalExcel').modal('show');

                    } else {
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

    let ID_FORM_INVENTARIS_KORBAN_BENCANA = <?php echo $ID_FORM_INVENTARIS_KORBAN_BENCANA ?>;
    let CODE_MD5 = "<?php echo $CODE_MD5 ?>";
    let Nomor_Surat_Form_Inventaris = "<?php echo $Nomor_Surat_Form_Inventaris ?>";
    // tampil_data_pengajuan_form(); //pemanggilan fungsi tampil data.

    $('#data_TANGGAL_MULAI_PAKAI_HARI_2 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#data_TANGGAL_SELESAI_PAKAI_HARI_2 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#data_TANGGAL_MULAI_PAKAI_HARI_4 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#data_TANGGAL_KEJADIAN_BENCANA .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#data_TANGGAL_DOKUMEN_PENGAJUAN .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#mydata').dataTable({
        pageLength: 10,
        aaSorting: [],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'excel',
                title: 'SPPB export EXCEL <?php echo $Nomor_Surat_Form_Inventaris ?>',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
            },
            {
                extend: 'print',
                orientation: 'landscape',
                title: 'SPPB export <?php echo $Nomor_Surat_Form_Inventaris ?>',
                pageSize: 'A4',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
            }
        ]

    });


    $("#checkAllrasd").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });



    $('#btn_gagal_upload').click(function() {
        location.reload();
    });



    $('#saya_setuju').click(function() {
        //check if checkbox is checked
        if ($(this).is(':checked')) {

            $('#btn_update_kirim_sppb').removeAttr('disabled'); //enable input

        } else {
            $('#btn_update_kirim_sppb').attr('disabled', true); //disable input
        }
    });



    //SIMPAN DATA
    $('#btn_simpan_data_1_item').click(function() {
        var TANGGAL_MULAI_PAKAI_HARI = $('#TANGGAL_MULAI_PAKAI_HARI_4').val(),
            TANGGAL_MULAI_PAKAI_HARI = TANGGAL_MULAI_PAKAI_HARI.split("/").reverse().join("-");

        var TANGGAL_SELESAI_PAKAI_HARI = $('#TANGGAL_SELESAI_PAKAI_HARI_4').val(),
            TANGGAL_SELESAI_PAKAI_HARI = TANGGAL_SELESAI_PAKAI_HARI.split("/").reverse().join("-");

        var form_data = {
            ID_SPPB: ID_SPPB,
            NAMA: $('#NAMA_4').val(),
            MEREK: $('#MEREK_4').val(),
            SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
            JUMLAH_QTY_SPP: $('#JUMLAH_QTY_SPP_4').val(),
            SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
            KLASIFIKASI_BARANG: $('#KLASIFIKASI_BARANG_4').val(),
            TANGGAL_MULAI_PAKAI_HARI: TANGGAL_MULAI_PAKAI_HARI,
            TANGGAL_SELESAI_PAKAI_HARI: TANGGAL_SELESAI_PAKAI_HARI,
            KETERANGAN: $('#KETERANGAN_4').val(),
            ID_PROYEK_SUB_PEKERJAAN: $('#ID_PROYEK_SUB_PEKERJAAN_4').val(),
            ID_RAB: $('#ID_RAB_4').val(),
            ID_RAB_FORM: $('#ID_RAB_FORM_4').val(),
            NAMA_RAB: $('#ID_RAB_FORM_4 option:selected').text(),
            NAMA_KATEGORI_RAB: $('#NAMA_KATEGORI_RAB_4').val(),
            ID_RASD_FORM: $('#ID_RASD_FORM_4').val(),
            ID_PROYEK: ID_PROYEK
        };
        $.ajax({
            url: "<?php echo site_url('SPPB_form/simpan_data_sppb_pembelian_1_item'); ?>",
            type: 'POST',
            data: form_data,
            success: function(data) {
                if (data != '') {
                    $('#alert-msg-1').html('<div class="alert alert-danger">' + data +
                        '</div>');
                } else {
                    $('#ModalAdd1Item').modal('hide');
                    window.location.reload();
                }
            }
        });
        return false;
    });

    //UPDATE DATA 
    $('#btn_update').on('click', function() {

        var TANGGAL_MULAI_PAKAI_HARI = $('#TANGGAL_MULAI_PAKAI_HARI_2').val(),
            TANGGAL_MULAI_PAKAI_HARI = TANGGAL_MULAI_PAKAI_HARI.split("/").reverse().join("-");

        var TANGGAL_SELESAI_PAKAI_HARI = $('#TANGGAL_SELESAI_PAKAI_HARI_2').val(),
            TANGGAL_SELESAI_PAKAI_HARI = TANGGAL_SELESAI_PAKAI_HARI.split("/").reverse().join("-");

        var form_data = {
            ID_SPPB: ID_SPPB,
            ID_SPPB_FORM: $('#ID_SPPB_FORM_2').val(),
            NAMA: $('#NAMA_2').val(),
            MEREK: $('#MEREK_2').val(),
            SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_2').val(),
            JUMLAH_QTY_SPP: $('#JUMLAH_QTY_SPP_2').val(),
            SATUAN_BARANG: $('#SATUAN_BARANG_2').val(),
            KLASIFIKASI_BARANG: $('#KLASIFIKASI_BARANG_2').val(),
            TANGGAL_MULAI_PAKAI_HARI: TANGGAL_MULAI_PAKAI_HARI,
            TANGGAL_SELESAI_PAKAI_HARI: TANGGAL_SELESAI_PAKAI_HARI,
            KETERANGAN: $('#KETERANGAN_2').val(),
            ID_PROYEK_SUB_PEKERJAAN: $('#ID_PROYEK_SUB_PEKERJAAN_2').val(),
            ID_RAB_FORM: $('#ID_RAB_FORM_2').val(),
            NAMA_KATEGORI_RAB: $('#NAMA_KATEGORI_RAB_2').val(),
            ID_RASD_FORM: $('#ID_RASD_FORM_2').val(),
            ID_RAB: $('#ID_RAB_2').val(),
            NAMA_RAB: $('#ID_RAB_FORM_2 option:selected').text(),
            ID_PROYEK: ID_PROYEK
        };

        $.ajax({
            url: "<?php echo site_url('SPPB_form/update_data') ?>",
            type: "POST",
            data: form_data,
            success: function(data) {

                if (data == "true") {
                    $('#ModalEdit').modal('hide');
                    window.location.reload();
                } else {
                    $('#alert-msg-2').html('<div class="alert alert-danger">' + data +
                        '</div>');
                }
            }
        });
        return false;
    });

    $('#summernote').summernote({
        tabsize: 1,
        height: 420
    });

    //GET UPDATE untuk Upload Excel
    // item_edit_upload_excel.onclick = function() {
    //     $('#ModalEditExcel').modal('show');
    // };
});
</script>

</body>

</html>