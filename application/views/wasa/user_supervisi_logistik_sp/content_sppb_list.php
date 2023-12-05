<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List SPPB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPPB/') ?>">SPPB</a>
            </li>
            <li class="active">
                <strong>
                    <a>List SPPB</a>
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
        Sistem menampilkan seluruh SPPB yang diajukan pada proyek <?php echo ($NAMA_PROYEK); ?>.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>SPPB</h5>
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
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Buat SPPB</a>
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <th>No. SPPB</th>
                                    <th>Nama Proyek</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Tanggal Pembuatan SPPB</th>
                                    <th>Status SPPB</th>
                                    <th>Pilihan</th>
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
</div>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 40vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Buat SPPB</h4>
                <small class="font-bold">Silakan isi tanggal pembuatan SPPB</small>
            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />
            <input type="hidden" class="form-control" value="" name="INISIAL" id="INISIAL" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($USER_ID); ?>" name="USER_ID" id="USER_ID" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($ID_JABATAN_PEGAWAI); ?>" name="ID_JABATAN_PEGAWAI" id="ID_JABATAN_PEGAWAI" disabled />
            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Proyek</label>
                        <div class="col-xs-9">
                            <select name="ID_RASD" class="form-control" id="ID_RASD" disabled>
                                <option value='<?php echo ($ID_RASD); ?> <?php echo ($INISIAL); ?>'><?php echo ($NAMA_PROYEK); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xs-3 control-label">Jenis Pekerjaan</label>
                        <div class="col-xs-9">
                            <select name="JENIS_PEKERJAAN" class="form-control" id="JENIS_PEKERJAAN">
                                <option value=''>- Pilih -</option>
                                <option value="mainwork">MAIN WORK</option>
                                <option value="additional">ADDITIONAL</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut SPPB</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_SPPB" id="NO_URUT_SPPB" disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tanggal Pengajuan SPPB</label>
                        <div class="col-xs-9" id="data_1">
                            <input id="TANGGAL_DOKUMEN_SPPB" type="date" class="form-control">
                            *tanggal pengajuan akan berubah sesuai dengan tanggal aktual pengajuan SPPB
                        </div>
                    </div>

                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Buat SPPB</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD-->
</br>

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>

    $(document).ready(function() {
        var today = new Date().toISOString().substr(0, 10);
        document.querySelector("#TANGGAL_DOKUMEN_SPPB").valueAsDate = new Date();

        tampil_data_sppb(); //pemanggilan fungsi tampil data.

        $("#ID_RASD").change(function() {
            var kerja = $("#JENIS_PEKERJAAN").val();
            console.log(kerja);
            var rasd = $('#ID_RASD').val();
            var pisah = rasd.split(' ')
            var INISIAL = pisah[1]
            var ID_RASD = pisah[0]
            var jenis = ""
            if (kerja == 'additional') {
                jenis = 'additional'
            } else {
                jenis = 'mainwork'
            }

            var id = ID_RASD;
            var COUNT = "";
            var NO_URUT = "";
            var DEPAN = "";
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>SPPB/get_nomor_urut_by_id_rasd",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {

                        var COUNT = data.JUMLAH_COUNT;
                        var date = new Date();

                        if (COUNT == null) {
                            COUNT = "0";
                        }
                        if (COUNT == NaN) {
                            COUNT = "0";
                        }

                        COUNT = parseInt(COUNT) + 1;

                        if (COUNT < 1000) {
                            DEPAN = "";
                        }

                        if (COUNT < 100) {
                            DEPAN = "0";
                        }

                        if (COUNT < 10) {
                            DEPAN = "00";
                        }

                        var str1 = DEPAN;
                        var str2 = COUNT;
                        var belakang = +str2.toString();
                        NO_URUT = str1 + str2.toString();

                        $('[name="JUMLAH_COUNT"]').val(COUNT);
                        $('[name="NO_URUT_SPPB"]').val(`${NO_URUT}/SPPB/WME/${INISIAL}/${jenis}/${date.getFullYear()}`);
                        $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_SPPB_WME_${INISIAL}_${jenis}_${date.getFullYear()}`);
                    });

                }
            });
        });

        $("#JENIS_PEKERJAAN").change(function() {
            var kerja = $("#JENIS_PEKERJAAN").val();
            console.log(kerja);
            var rasd = $('#ID_RASD').val();
            var pisah = rasd.split(' ')
            var INISIAL = pisah[1]
            var ID_RASD = pisah[0]
            var jenis = ""
            if (kerja == 'additional') {
                jenis = 'additional'
            } else {
                jenis = 'mainwork'
            }

            var id = ID_RASD;
            var COUNT = "";
            var NO_URUT = "";
            var DEPAN = "";
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>SPPB/get_nomor_urut_by_id_rasd",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {

                        var COUNT = data.JUMLAH_COUNT;
                        var date = new Date();

                        if (COUNT == null) {
                            COUNT = "0";
                        }
                        if (COUNT == NaN) {
                            COUNT = "0";
                        }

                        COUNT = parseInt(COUNT) + 1;

                        if (COUNT < 1000) {
                            DEPAN = "";
                        }

                        if (COUNT < 100) {
                            DEPAN = "0";
                        }

                        if (COUNT < 10) {
                            DEPAN = "00";
                        }

                        var str1 = DEPAN;
                        var str2 = COUNT;
                        var belakang = +str2.toString();
                        NO_URUT = str1 + str2.toString();

                        $('[name="JUMLAH_COUNT"]').val(COUNT);
                        $('[name="NO_URUT_SPPB"]').val(`${NO_URUT}/SPPB/WME/${INISIAL}/${jenis}/${date.getFullYear()}`);
                        $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_SPPB_WME_${INISIAL}_${jenis}_${date.getFullYear()}`);
                    });

                }
            });
        });

        $('#mydata').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv'
                },
                {
                    extend: 'excel',
                    title: 'SPPB'
                },
                {
                    extend: 'pdf',
                    title: 'SPPB'
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
        function tampil_data_sppb() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url() ?>SPPB/data_sppb',
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html, html_progress = '';
                    var tombol_hapus = '';
                    var i;
                    for (i = 0; i < data.length; i++) {

                        var PROGRESS_SPPB = data[i].PROGRESS_SPPB;
                        var STATUS_SPPB = data[i].STATUS_SPPB;

                        if (data[i].PROGRESS_SPPB == "Dalam Proses Supervisi Logistik SP") {
                            html_progress = '<a href="#" class="btn btn-info btn-xs block"> ' + data[i].PROGRESS_SPPB + ' </a>';
                            tombol_sppb = '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-warning btn-xs block"><i class="fa fa-eye"></i> Lihat SPPB </a>';
                        } else if (data[i].PROGRESS_SPPB == "Dalam Proses Pembuatan Supervisi Logistik SP") {
                            html_progress = '<a href="#" class="btn btn-info btn-xs block"> ' + data[i].PROGRESS_SPPB + ' </a>';
                            tombol_sppb = '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-warning btn-xs block"><i class="fa fa-eye"></i> Lihat SPPB </a>';
                        } else if (data[i].PROGRESS_SPPB == "SPPB Disetujui") {
                            html_progress = '<a href="#" class="btn btn-primary btn-xs block"> ' + data[i].PROGRESS_SPPB + ' </a>';
                            tombol_sppb = '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Lihat SPPB </a>';
                        } else {
                            html_progress = '<a href="#" class="btn btn-info btn-outline btn-xs block"> ' + data[i].PROGRESS_SPPB + ' </a>';
                            tombol_sppb = '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Lihat SPPB </a>';
                        }

                        html += '<tr>' +
                            '<td>' + data[i].NO_URUT_SPPB + '</td>' +
                            '<td>' + data[i].NAMA_PROYEK + '</td>' +
                            '<td>' + data[i].JENIS_PEKERJAAN + '</td>' +
                            '<td>' + data[i].TANGGAL_DOKUMEN_SPPB + '</td>' +
                            '<td>' + html_progress + '</td>' +
                            '<td>' + tombol_sppb + ' '
                        '</td>' +
                        '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            var form_data = {
                ID_RASD: $('#ID_RASD').val(),
                JENIS_PEKERJAAN: $('#JENIS_PEKERJAAN').val(),
                TANGGAL_DOKUMEN_SPPB: $('#TANGGAL_DOKUMEN_SPPB').val(),
                JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
                NO_URUT_SPPB: $('#NO_URUT_SPPB').val(),
                USER_ID: $('#USER_ID').val(),
                FILE_NAME_TEMP: $('#FILE_NAME_TEMP').val(),
            };

            $.ajax({
                url: "<?php echo site_url('SPPB/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('SPPB/get_data_sppb_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                $.each(data, function() {
                                    if (data == 'BELUM ADA SPPB') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        window.location.href = '<?php echo base_url(); ?>SPPB_form/index/' + data.HASH_MD5_SPPB;
                                    }
                                });
                            }
                        });
                    }
                }
            });

            return false;
        });

    });
</script>

</body>

</html>