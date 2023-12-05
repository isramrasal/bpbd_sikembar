<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Surat Jalan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SURAT JALAN/') ?>">Surat Jalan</a>
            </li>
            <li class="active">
                <strong>
                    <a>List Surat Jalan</a>
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
        Sistem menampilkan seluruh Surat Jalan yang Anda ajukan pada seluruh proyek.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>SURAT JALAN</h5>
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
                                    <th>Nomor Urut Surat Jalan</th>
                                    <th>Tanggal Pengajuan Surat Jalan</th>
                                    <th>Nomor Urut SPPB</th>
                                    <th>Tanggal Surat Jalan</th>
                                    <th>Kepada</th>
                                    <th>PIC Penerima Barang</th>
                                    <th>Progres Surat Jalan</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd" style="margin-top: 30px;"><span class="fa fa-plus"></span>Buat Surat Jalan Barang</a>
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
                <h4 class="modal-title">Identitas Form Surat Jalan Barang</h4>
                <small class="font-bold">Silakan isi tanggal surat jalan barang</small>
            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("surat_jalan/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />

            <input type="hidden" class="form-control" value="<?php echo ($ID_PROYEK); ?>" name="ID_PROYEK_SURAT_JALAN" id="ID_PROYEK_SURAT_JALAN" disabled />

            <input type="hidden" class="form-control" value="<?php echo ($INISIAL); ?>" name="INISIAL" id="INISIAL" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($USER_ID); ?>" name="USER_ID" id="USER_ID" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($ID_JABATAN_PEGAWAI); ?>" name="ID_JABATAN_PEGAWAI" id="ID_JABATAN_PEGAWAI" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut Surat Jalan:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_SURAT_JALAN" id="NO_SURAT_JALAN" disabled />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut Delivery Note:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_DELIVERY_NOTE" id="NO_DELIVERY_NOTE" disabled />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP_DELIVERY_NOTE" id="FILE_NAME_TEMP_DELIVERY_NOTE" disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut Packing List:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_PACKING_LIST" id="NO_PACKING_LIST" disabled />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP_PACKING_LIST" id="FILE_NAME_TEMP_PACKING_LIST" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tanggal Pengajuan Surat Jalan:</label>
                        <div class="col-xs-9">
                            <input type="date" class="form-control" id="tglPem">
                        </div>
                    </div>
                    <p>*tanggal pengajuan akan berubah sesuai dengan tanggal aktual pengajuan SURAT JALAN</p>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Maksud Pengiriman:</label>
                        <div class="col-xs-9">
                            <select name="MAKSUD_PENGIRIMAN" class="form-control" id="MAKSUD_PENGIRIMAN">
                                <option value=''>- Pilih -</option>
                                <option value="Pengiriman Ke Site Project">Pengiriman Ke Site Project</option>
                                <option value="Pengiriman Ke Vendor Untuk Perbaikan">Pengiriman Ke Vendor Untuk Perbaikan</option>
                                <option value="Pengiriman Ke Vendor Untuk Retur/Pengembalian">Pengiriman Ke Vendor Untuk Retur/Pengembalian</option>
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_np_1" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nama Proyek:</label>
                        <div class="col-xs-9">
                            <select class="form-control" name="ID_PROYEK_1" id="ID_PROYEK_1">
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_lp_1" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Lokasi Penyerahan Proyek:</label>
                        <div class="col-xs-9">
                            <select class="form-control" name="ID_PROYEK_LOKASI_PENYERAHAN_1" id="ID_PROYEK_LOKASI_PENYERAHAN_1">
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_nv_2" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nama Vendor:</label>
                        <div class="col-xs-9">
                            <select class="form-control" name="ID_VENDOR_2" id="ID_VENDOR_2">
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_sppb_1" class="form-group" hidden>
                        <label class="control-label col-xs-3">Nomor Urut SPPB</label>
                        <div class="col-xs-9">
                            <select name="ID_SPPB_1" class="form-control" id="ID_SPPB_1">
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Tanggal Surat Jalan</label>
                        <div class="col-xs-9">
                            <input name="TANGGAL_SURAT_JALAN_HARI" id="TANGGAL_SURAT_JALAN_HARI" class="form-control" type="date">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Kepada:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="KEPADA" id="KEPADA" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">PIC Penerima Barang:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="PIC_PENERIMA_BARANG" id="PIC_PENERIMA_BARANG" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">No HP PIC:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NO_HP_PIC" id="NO_HP_PIC" />
                        </div>
                    </div>

                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Buat Surat Jalan</button>
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
    $('#ModalAdd').on('shown.bs.modal', function(e) {

        var ID_JABATAN_PEGAWAI = $('#ID_JABATAN_PEGAWAI').val();
        //console.log(rasd);
        var pisah = ID_JABATAN_PEGAWAI.split(' ');
        var SUB_DEPARTEMEN = pisah[1];

        var ID_PROYEK_SURAT_JALAN = $('#ID_PROYEK_SURAT_JALAN').val();
        var INISIAL = $('#INISIAL').val();

        var id = ID_PROYEK_SURAT_JALAN;
        var COUNT = "";
        var NO_URUT = "";
        var DEPAN = "";

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>Surat_Jalan/get_nomor_urut",
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
                    console.log(NO_URUT);

                    $('[name="JUMLAH_COUNT"]').val(COUNT);
                    $('[name="NO_SURAT_JALAN"]').val(`${NO_URUT}/SJ/WME/${INISIAL}/${date.getFullYear()}`);
                    $('[name="NO_DELIVERY_NOTE"]').val(`${NO_URUT}/DN/WME/${INISIAL}/${date.getFullYear()}`);
                    $('[name="NO_PACKING_LIST"]').val(`${NO_URUT}/PL/WME/${INISIAL}/${date.getFullYear()}`);

                    $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_SJ_WME_${INISIAL}_${date.getFullYear()}`);
                    $('[name="FILE_NAME_TEMP_DELIVERY_NOTE"]').val(`${NO_URUT}_DN_WME_${INISIAL}_${date.getFullYear()}`);
                    $('[name="FILE_NAME_TEMP_PACKING_LIST"]').val(`${NO_URUT}_PL_WME_${INISIAL}_${date.getFullYear()}`);
                });

            }
        });

    })



    $(document).ready(function() {
        var today = new Date().toISOString().substr(0, 10);
        // document.querySelector("#tglPem").valueAsDate = new Date();

        tampil_data_surat_jalan(); //pemanggilan fungsi tampil data.

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
        function tampil_data_surat_jalan() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url() ?>Surat_Jalan/data_surat_jalan',
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html, html_progress = '';
                    var i;
                    for (i = 0; i < data.length; i++) {

                        let PROGRESS_SURAT_JALAN = data[i].PROGRESS_SURAT_JALAN;

                        if (PROGRESS_SURAT_JALAN == "Dalam Proses Kasie Logistik KP") {
                            html_progress = '<a href="#" class="btn btn-warning btn-xs block"> ' + PROGRESS_SURAT_JALAN + ' </a>';
                        } else if (PROGRESS_SURAT_JALAN == "Surat Jalan Disetujui") {
                            html_progress = '<a href="#" class="btn btn-primary btn-xs block"> ' + PROGRESS_SURAT_JALAN + ' </a>';
                        } else {
                            html_progress = '<a href="#" class="btn btn-success btn-xs btn-outline block"> ' + PROGRESS_SURAT_JALAN;
                        }

                        if (data[i].NO_URUT_SPPB === null) {
                            KET_NO_URUT_SPPB = 'TANPA SPPB';
                        } else {
                            KET_NO_URUT_SPPB = data[i].NO_URUT_SPPB;
                        }

                        html += '<tr>' +
                            '<td>' + data[i].NO_SURAT_JALAN + '</td>' +
                            '<td>' + data[i].TANGGAL_PENGAJUAN_SURAT_JALAN + '</td>' +
                            '<td>' + data[i].NO_URUT_SPPB + '</td>' +
                            '<td>' + data[i].TANGGAL_SURAT_JALAN_HARI + '</td>' +
                            '<td>' + data[i].KEPADA + '</td>' +
                            '<td>' + data[i].PIC_PENERIMA_BARANG + '</td>' +
                            '<td>' + html_progress + '</td>' +
                            '<td>' +
                            '<a href="<?php echo base_url() ?>Surat_Jalan_form/view/' + data[i].HASH_MD5_SURAT_JALAN + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i>Lihat Surat Jalan</a>' + ' ' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            let form_data = {
                ID_PROYEK_SURAT_JALAN: $('#ID_PROYEK_SURAT_JALAN').val(),
                ID_PROYEK_LOKASI_PENYERAHAN: $('#ID_PROYEK_LOKASI_PENYERAHAN').val(),
                ID_PROYEK_1: $('#ID_PROYEK_1').val(),
                ID_VENDOR_2: $('#ID_VENDOR_2').val(),
                ID_SPPB_1: $('#ID_SPPB_1').val(),
                TANGGAL_PENGAJUAN_SURAT_JALAN: $('#tglPem').val(),
                JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
                NO_SURAT_JALAN: $('#NO_SURAT_JALAN').val(),
                NO_DELIVERY_NOTE: $('#NO_DELIVERY_NOTE').val(),
                NO_PACKING_LIST: $('#NO_PACKING_LIST').val(),
                USER_ID: $('#USER_ID').val(),
                FILE_NAME_TEMP: $('#FILE_NAME_TEMP').val(),
                FILE_NAME_TEMP_DELIVERY_NOTE: $('#FILE_NAME_TEMP_DELIVERY_NOTE').val(),
                FILE_NAME_TEMP_PACKING_LIST: $('#FILE_NAME_TEMP_PACKING_LIST').val(),
                ID_SPPB: $('#NO_URUT_SPPB_1').val(),
                PIC_PENERIMA_BARANG: $('#PIC_PENERIMA_BARANG').val(),
                NO_HP_PIC: $('#NO_HP_PIC').val(),
                TANGGAL_SURAT_JALAN_HARI: $('#TANGGAL_SURAT_JALAN_HARI').val(),
                KEPADA: $('#KEPADA').val(),
                MAKSUD_PENGIRIMAN: $('#MAKSUD_PENGIRIMAN').val()
            };
            $.ajax({
                url: "<?php echo site_url('Surat_Jalan/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "GET",
                            url: "<?php echo base_url('Surat_Jalan/get_data_surat_jalan_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                $.each(data, function() {
                                    if (data == 'BELUM ADA SURAT JALAN') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        console.log(data);
                                        window.location.href = '<?php echo base_url(); ?>Surat_Jalan_form/index/' + data.HASH_MD5_SURAT_JALAN;
                                    }

                                });
                            }
                        });
                    }
                }
            });

            return false;
        });

        $("#MAKSUD_PENGIRIMAN").change(function() {
            if ($("#MAKSUD_PENGIRIMAN option:selected").text() == 'Pengiriman Ke Site Project') {
                $('#show_hidden_np_1').attr("hidden", false);
                $('#show_hidden_nv_2').attr("hidden", true);
                // Menggunakan ajax untuk mengirim dan dan menerima data dari server
                $.ajax({
                    url: "<?php echo base_url(); ?>/Surat_Jalan/get_data_proyek",
                    method: "POST",
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        var i;

                        html = "<option value=''>- Pilih Proyek -</option>";

                        for (i = 0; i < data.length; i++) {
                            html += '<option value=' + data[i].ID_PROYEK + '>' + data[i].NAMA_PROYEK + '</option>';
                        }
                        $('#ID_PROYEK_1').html(html);
                    }
                });
            } else if ($("#MAKSUD_PENGIRIMAN option:selected").text() == 'Pengiriman Ke Vendor Untuk Perbaikan') {
                $('#show_hidden_np_1').attr("hidden", true);
                $('#show_hidden_sppb_1').attr("hidden", true);
                $('#show_hidden_lp_1').attr("hidden", true);
                $('#show_hidden_nv_2').attr("hidden", false);
                // Menggunakan ajax untuk mengirim dan dan menerima data dari server
                $.ajax({
                    url: "<?php echo base_url(); ?>/Surat_Jalan/get_data_vendor",
                    method: "POST",
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        var i;

                        html = "<option value=''>- Pilih Nama Vendor -</option>";

                        for (i = 0; i < data.length; i++) {
                            html += '<option value=' + data[i].ID_VENDOR + '>' + data[i].NAMA_VENDOR + '</option>';
                        }
                        $('#ID_VENDOR_2').html(html);
                    }
                });
            } else if ($("#MAKSUD_PENGIRIMAN option:selected").text() == 'Pengiriman Ke Vendor Untuk Retur/Pengembalian') {
                $('#show_hidden_np_1').attr("hidden", true);
                $('#show_hidden_sppb_1').attr("hidden", true);
                $('#show_hidden_lp_1').attr("hidden", true);
                $('#show_hidden_nv_2').attr("hidden", false);
                // Menggunakan ajax untuk mengirim dan dan menerima data dari server
                $.ajax({
                    url: "<?php echo base_url(); ?>/Surat_Jalan/get_data_vendor",
                    method: "POST",
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        var i;

                        html = "<option value=''>- Pilih Nama Vendor -</option>";

                        for (i = 0; i < data.length; i++) {
                            html += '<option value=' + data[i].ID_VENDOR + '>' + data[i].NAMA_VENDOR + '</option>';
                        }
                        $('#ID_VENDOR_2').html(html);
                    }
                });
            } else {
                $('#show_hidden_np_1').attr("hidden", true);
                $('#show_hidden_nv_2').attr("hidden", true);
            }
        });

        $("#ID_PROYEK_1").change(function() {
            if ($("#ID_PROYEK_1 option:selected").text() == '- Pilih Proyek -') {
                $('#show_hidden_sppb_1').attr("hidden", true);
                $('#show_hidden_lp_1').attr("hidden", true);
            } else {
                $('#show_hidden_sppb_1').attr("hidden", false);
                var ID_PROYEK = $('#ID_PROYEK_1').val();
                $.ajax({
                    url: "<?php echo base_url(); ?>/Surat_Jalan/get_data_sppb",
                    method: "POST",
                    data: {
                        ID_PROYEK: ID_PROYEK
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        var i;

                        html = "<option value=''>- Pilih Nomor SPPB -</option>";
                        html = html + "<option value='666666'>- Tanpa SPPB -</option>";


                        for (i = 0; i < data.length; i++) {
                            html += '<option value=' + data[i].ID_SPPB + '>' + data[i].NO_URUT_SPPB + '</option>';
                        }
                        $('#ID_SPPB_1').html(html);
                    }
                });

                $('#show_hidden_lp_1').attr("hidden", false);
                var ID_PROYEK = $('#ID_PROYEK_1').val();
                $.ajax({
                    url: "<?php echo base_url(); ?>/Surat_Jalan/get_data_lokasi_penyerahan",
                    method: "POST",
                    data: {
                        ID_PROYEK: ID_PROYEK
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        var html = '';
                        var i;

                        html = "<option value=''>- Pilih Lokasi Penyerahan -</option>";

                        for (i = 0; i < data.length; i++) {
                            html += '<option value=' + data[i].ID_PROYEK_LOKASI_PENYERAHAN + '>' + data[i].NAMA_LOKASI_PENYERAHAN + '</option>';
                        }
                        $('#ID_PROYEK_LOKASI_PENYERAHAN_1').html(html);
                    }
                });
            }
        });

    });
</script>

</body>

</html>