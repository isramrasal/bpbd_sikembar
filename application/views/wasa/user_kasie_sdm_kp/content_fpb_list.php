<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List FPB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/FPB/') ?>">FPB</a>
            </li>
            <li class="active">
                <strong>
                    <a>List FPB</a>
                </strong>
            </li>
        </ol>
    </div>

</div>

<div class="wrapper wrapper-content animated fadeInRight">

    <div class="alert alert-info alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Sistem menampilkan seluruh FPB yang diajukan pada proyek <?php echo ($NAMA_PROYEK); ?>.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>FPB</h5>
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

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <th>Nomor Urut FPB</th>
                                    <th>Tanggal Pengajuan FPB</th>
                                    <th>Peminta</th>
                                    <th>Progres FPB</th>
                                    <th>Status</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Buat SPPB dari FPB</a>
                </div>

            </div>
        </div>
    </div>
</div>
</br>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 40vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Buat SPPB dari FPB</h4>
                <small class="font-bold">Silakan isi tanggal pembuatan SPPB</small>
            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("FPB/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />

            <input type="hidden" class="form-control" value="<?php echo ($ID_PROYEK); ?>" name="ID_PROYEK" id="ID_PROYEK" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($ID_RASD); ?>" name="ID_RASD" id="ID_RASD" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($INISIAL); ?>" name="INISIAL" id="INISIAL" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($USER_ID); ?>" name="USER_ID" id="USER_ID" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($ID_JABATAN); ?>" name="ID_JABATAN" id="ID_JABATAN" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Lokasi :</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="<?php echo ($NAMA_PROYEK); ?>" name="NAMA_PROYEK" id="NAMA_PROYEK" disabled />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xs-3 control-label">Jenis Pekerjaan :</label>
                        <div class="col-xs-9">
                            <div class="col-xs-4">
                                <label><input type="radio" value="Mainwork" id="Mainwork" name="KERJA" onclick="getPekerjaan(this.value)">&nbsp; Main Work</label>
                            </div>
                            <div class="col-xs-4">
                                <label> <input type="radio" value="additional" id="additional" name="KERJA" onclick="getPekerjaan(this.value)">
                                    &nbsp; Additional</label>
                            </div>
                            <input type="text" id="PEKERJAAN" name="PEKERJAAN" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut SPPB:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_SPPB" id="NO_URUT_SPPB" disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tanggal Pengajuan SPPB:</label>
                        <div class="col-xs-9" id="data_1">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="tglPem" type="date" class="form-control unstyled" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Sumber FPB:</label>
                        <div class="col-xs-9">

                            <?php

                            $i = 1;

                            foreach ($LIST_FPB as $LIST_FPB) {
                                echo '<input name="FPB[] id="chkbx_fpb_' . '$i' . '" type="checkbox" " />' . $LIST_FPB->NO_URUT_FPB . '</br>';
                                $i = $i + 1;
                            } ?>

                        </div>
                    </div>

                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Ajukan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Data FPB</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
                        <div name="NAMA_3" id="NAMA_3"></div>
                    </div>

                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        Seluruh isian item barang dan jasa pada FPB juga akan dihapus oleh sistem!
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

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    function getPekerjaan(kerja) {

        var ID_PROYEK = $('#ID_PROYEK').val();
        var INISIAL = $('#INISIAL').val();

        var jenis = ""
        if (kerja == 'Mainwork') {
            jenis = 'Main Work'
        } else {
            jenis = 'Additional'
        }

        var id = ID_PROYEK;
        var COUNT = "";
        var NO_URUT = "";
        var DEPAN = "";
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>SPPB/get_nomor_urut_by_id_proyek",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
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
                    $('[name="NO_URUT_SPPB"]').val(`${NO_URUT}/SPPB/WME/${INISIAL}/${jenis}/2021`);
                });

            }
        });

    }



    $(document).ready(function() {
        var today = new Date().toISOString().substr(0, 10);
        document.querySelector("#tglPem").valueAsDate = new Date();

        tampil_data_fpb(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }]

        });

        //fungsi tampil data
        function tampil_data_fpb() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url() ?>FPB/data_FPB',
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var tombol_ubah = '';
                    var i;
                    for (i = 0; i < data.length; i++) {

                        let PROGRESS_FPB = data[i].PROGRESS_FPB;
                        let STATUS_FPB = data[i].STATUS_FPB;


                        html += '<tr>' +
                            '<td>' + data[i].NO_URUT_FPB + '</td>' +
                            '<td>' + data[i].TANGGAL_PENGAJUAN_FPB + '</td>' +
                            '<td>' + data[i].ID_JABATAN + '</td>' +
                            '<td>' + data[i].PROGRESS_FPB + '</td>' +
                            '<td>' + data[i].STATUS_FPB + '</td>' +
                            '<td>' +
                            '<a href="<?php echo base_url() ?>FPB_form/view/' + data[i].HASH_MD5_FPB + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Lihat FPB </a>' + ' ' +

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
                TANGGAL_PENGAJUAN_FPB: $('#tglPem').val(),
                JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
                NO_URUT_SPPB: $('#NO_URUT_SPPB').val(),
                USER_ID: $('#USER_ID').val(),
                ID_RASD: $('#ID_RASD').val(),
            };
            $.ajax({
                url: "<?php echo site_url('FPB/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "GET",
                            url: "<?php echo base_url('FPB/get_data_fpb_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                $.each(data, function() {
                                    if (data == 'BELUM ADA FPB') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        console.log(data);
                                        window.location.href = '<?php echo base_url(); ?>fpb_form/index/' + data.HASH_MD5_FPB;
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