<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Nota Pengambilan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/Nota_pengambilan/') ?>">Nota Pengambilan</a>
            </li>
            <li class="active">
                <strong>
                    <a>List Nota Pengambilan</a>
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
        Sistem menampilkan seluruh Nota Pengambilan yang dilakukan pada proyek <?php echo ($NAMA_PROYEK); ?>.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Nota Pengambilan</h5>
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

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <th>No. Nota Pengambilan</th>
                                    <th>Tanggal Pembuatan Nota Pengambilan</th>
                                    <th>Progres Nota Pengambilan</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    </br>
                    </br>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Buat Nota Pengambilan</a>
                </div>

            </div>
        </div>
    </div>
</div>
</br>

<br><br>
<div class="footer">
    <div>
        <p><strong>&copy; <?php echo date("Y"); ?> PT. Wasa Mitra Enginering</strong><br /> Hak cipta dilindungi undang-undang.</p>
    </div>
</div>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 40vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Buat Nota Pengambilan</h4>
                <small class="font-bold">Silakan isi tanggal pembuatan nota pengambilan</small>
            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("Nota_Pengambilan/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />

            <input type="hidden" class="form-control" value="<?php echo ($ID_PROYEK); ?>" name="ID_PROYEK" id="ID_PROYEK" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($ID_RASD); ?>" name="ID_RASD" id="ID_RASD" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($INISIAL); ?>" name="INISIAL" id="INISIAL" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($USER_ID); ?>" name="USER_ID" id="USER_ID" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($ID_JABATAN_PEGAWAI); ?>" name="ID_JABATAN_PEGAWAI" id="ID_JABATAN_PEGAWAI" disabled />
            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Lokasi :</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="<?php echo ($NAMA_PROYEK); ?>" name="NAMA_PROYEK" id="NAMA_PROYEK" disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut Nota Pengambilan:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_NOTA_PENGAMBILAN" id="NO_URUT_NOTA_PENGAMBILAN" disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tanggal Pengajuan Nota Pengambilan:</label>
                        <div class="col-xs-9" id="data_1">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="tglPem" type="date" class="form-control unstyled" />
                            </div>
                        </div>
                    </div>

                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Buat Nota Pengambilan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD-->

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

        $("#ModalAdd").on('show.bs.modal', function() {
            var ID_PROYEK = $('#ID_PROYEK').val();
            var INISIAL = $('#INISIAL').val();
            var id = ID_PROYEK;
            var COUNT = "";
            var NO_URUT = "";
            var DEPAN = "";
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>Nota_pengambilan/get_nomor_urut_by_id_proyek",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $.each(data, function() {

                        var COUNT = data.JUMLAH_COUNT;

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
                        console.log(NO_URUT);

                        $('[name="JUMLAH_COUNT"]').val(COUNT);
                        $('[name="NO_URUT_NOTA_PENGAMBILAN"]').val(`${NO_URUT}/AMBIL_GUDANG/WME/${INISIAL}/2022`);
                        $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_AMBIL_GUDANG_WME_${INISIAL}_2022`);
                    });

                }
            });



        });


        var today = new Date().toISOString().substr(0, 10);
        document.querySelector("#tglPem").valueAsDate = new Date();

        tampil_data_nota_pengambilan(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 25,
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
                    title: 'Nota Pengambilan'
                },
                {
                    extend: 'pdf',
                    title: 'Nota Pengambilan'
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
        function tampil_data_nota_pengambilan() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url() ?>Nota_pengambilan/data_nota_pengambilan',
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html, html_progress = '';
                    var tombol_ubah = '';
                    var tombol_hapus = '';
                    var i;
                    for (i = 0; i < data.length; i++) {

                        let PROGRESS_NOTA_PENGAMBILAN = data[i].PROGRESS_NOTA_PENGAMBILAN;
                        let STATUS_NOTA_PENGAMBILAN = data[i].STATUS_NOTA_PENGAMBILAN;

                        // if (PROGRESS_NOTA_PENGAMBILAN != "Dalam Proses Staff Logistic") {
                        //     tombol_ubah = '<a href="#" class="btn btn-warning btn-xs block" disabled><i class="fa fa-pencil"></i> Ubah </a>';
                        // } else {
                        //     tombol_ubah = '<a href="<?php echo base_url() ?>nota_pengambilan_form/index/' + data[i].HASH_MD5_NOTA_PENGAMBILAN + '" class="btn btn-warning btn-xs block"><i class="fa fa-pencil"></i> Ubah </a>';
                        // }

                        if (data[i].PROGRESS_NOTA_PENGAMBILAN == "Dalam Proses Staff Umum Logistik SP") {
                            html_progress = '<a href="#" class="btn btn-warning btn-xs block"> ' + data[i].PROGRESS_NOTA_PENGAMBILAN + ' </a>';
                        } else if (data[i].PROGRESS_NOTA_PENGAMBILAN == "SPPB Disetujui") {
                            html_progress = '<a href="#" class="btn btn-primary btn-xs block"> ' + data[i].PROGRESS_NOTA_PENGAMBILAN + ' </a>';
                        } else {
                            html_progress = '<a href="#" class="btn btn-success btn-xs btn-outline block"> ' + data[i].PROGRESS_NOTA_PENGAMBILAN;
                        }

                        html += '<tr>' +
                            '<td>' + data[i].NO_URUT_NOTA_PENGAMBILAN + '</td>' +
                            '<td>' + data[i].TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_HARI + '</td>' +
                            '<td>' + html_progress + '</td>' +
                            '<td>' +
                            '<a href="<?php echo base_url() ?>nota_pengambilan_form/view/' + data[i].HASH_MD5_NOTA_PENGAMBILAN + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Lihat </a>' + ' ' +
                            tombol_ubah + ' ' +
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
                ID_PROYEK: $('#ID_PROYEK').val(),
                ID_RASD: $('#ID_RASD').val(),
                TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN: $('#tglPem').val(),
                JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
                NO_URUT_NOTA_PENGAMBILAN: $('#NO_URUT_NOTA_PENGAMBILAN').val(),
                USER_ID: $('#USER_ID').val(),
                FILE_NAME_TEMP: $('#FILE_NAME_TEMP').val(),
            };
            console.log(form_data);
            $.ajax({
                url: "<?php echo site_url('Nota_pengambilan/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('Nota_pengambilan/get_data_nota_pengambilan_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                console.log(data);
                                $.each(data, function() {
                                    if (data == 'BELUM ADA SPPB') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        window.location.href = '<?php echo base_url(); ?>Nota_pengambilan_form/index/' + data.HASH_MD5_NOTA_PENGAMBILAN;
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