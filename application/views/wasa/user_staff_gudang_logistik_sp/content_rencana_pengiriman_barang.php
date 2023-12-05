<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Rencana Pengiriman Barang</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/Rencana_Pengiriman_Barang/') ?>">Rencana Pengiriman Barang</a>
            </li>
            <li class="active">
                <strong>
                    <a>List Rencana Pengiriman Barang</a>
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
        Sistem menampilkan SPPB yang diajukan dari seluruh proyek, dan RPB yang telah dibuat.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>RPB</h5>
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
                                    <th>Nomor Urut PO</th>
                                    <th>Tanggal Rencana Pengiriman Barang</th>
                                    <th>Nama Pengirim</th>
                                    <th>Nomor HP Pengirim</th>
                                    <th>Kepada</th>
                                    <th>Tujuan</th>
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
</br>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 40vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Identitas Form RPB</h4>

            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("FPB/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />

            <input type="hidden" class="form-control" value="" name="ID_PROYEK" id="ID_PROYEK" disabled />
            <!-- <input type="hidden" class="form-control" value="" name="ID_RASD" id="ID_RASD" disabled /> -->
            <input type="hidden" class="form-control" value="" name="INISIAL" id="INISIAL" disabled />


            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-xs-3 control-label">No. Urut PO:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_PO" id="NO_URUT_PO" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut RPB:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_RENCANA_PENGIRIMAN_BARANG" id="NO_RENCANA_PENGIRIMAN_BARANG" disabled />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
                            <input type="hidden" class="form-control" value="" name="ID_PO" id="ID_PO" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tanggal Pengiriman:</label>
                        <div class="col-xs-9">
                            <input type="date" class="form-control" id="TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama Pengirim:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NAMA_PENGIRIM" id="NAMA_PENGIRIM" placeholder="Rifky Lazuardi" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">No HP Pengirim:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NO_HP_PENGIRIM" id="NO_HP_PENGIRIM" placeholder="087808780878" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Kepada:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="KEPADA" id="KEPADA" placeholder="Pandy Andhika" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tujuan:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="TUJUAN" id="TUJUAN" placeholder="JL. Raya Cakung Cilincing, Km 1 No.11 Gedung WASA, RT.11/RW.7, Cakung Bar., Kec. Cakung, Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13910" />
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label class="col-xs-3 control-label">Jenis Barang:</label>
                        <div class="col-xs-9">
                            <select name="PERALATAN_PERLENGKAPAN" class="form-control" id="PERALATAN_PERLENGKAPAN">
                                <option value=''>- Pilih -</option>
                                <option value="TOOL">TOOL</option>
                                <option value="CONSUMPTION">CONSUMPTION</option>
                                <option value="MATERIAL">MATERIAL</option>
                                <option value="JASA/RENTAL">JASA/RENTAL</option>
                            </select>
                        </div>
                    </div> -->

                    <div id="alert-msg"></div>

                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses identitas form RPB ini dan menyetujui untuk proses selanjutnya </label></div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" name="btn_simpan" id="btn_simpan" disabled><i class="fa fa-save"></i> Buat RPB</button>
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

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_simpan').removeAttr('disabled'); //enable input

            } else {
                $('#btn_simpan').attr('disabled', true); //disable input
            }
        });

        tampil_data_RPB(); //pemanggilan fungsi tampil data.

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
        function tampil_data_RPB() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url() ?>Rencana_pengiriman_barang/data_RPB',
                async: false,
                dataType: 'json',
                success: function(data) {

                    var data_1 = data;
                    var html = '';
                    var i, j, k = 0;

                    for (i = 0; i < data_1.length; i++) {

                        var form_data = {
                            ID_PO: data_1[i].ID_PO,
                        };

                        $.ajax({
                            url: "<?php echo site_url('Rencana_pengiriman_barang/get_list_rpb_by_id_po') ?>",
                            type: "POST",
                            dataType: "JSON",
                            async: false,
                            data: {
                                ID_PO: data_1[i].ID_PO,
                            },
                            success: function(data) {
                                var data_2 = data;
                                var PO = '';

                                html += '<tr>' +
                                    '<td>' + '<a href="<?php echo base_url() ?>PO_form/view/' + data_1[i].HASH_MD5_PO + '" class="btn btn-primary btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_1[i].NO_URUT_PO + ' </a>' + '</td>' +
                                    '<td>';

                                    if (data_2 == 'TIDAK ADA DATA') {
                                    var PO = '';

                                } else {
                                    for (j = 0; j < data_2.length; j++) {
                                        var html_progress = '';                                        
                                        html_progress = '<a href="#" class="btn btn-secondary btn-xs"> ' + data_2[j].TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI + ' </a>';
                                        html += html_progress + "</br>";
                                    }

                                }

                                html +=
                                    '</td>' +

                                    '<td>';

                                if (data_2 == 'TIDAK ADA DATA') {
                                    var PO = '';

                                } else {
                                    for (j = 0; j < data_2.length; j++) {
                                        var html_progress = '';                                        
                                        html_progress = '<a href="#" class="btn btn-secondary btn-xs"> ' + data_2[j].NAMA_PENGIRIM + ' </a>';
                                        html += html_progress + "</br>";
                                    }

                                }

                                html +=
                                    '</td>' +

                                    '<td>';

                                if (data_2 == 'TIDAK ADA DATA') {
                                    var PO = '';

                                } else {
                                    for (j = 0; j < data_2.length; j++) {
                                        var html_progress = '';
                                        if (data_2[j].PROGRESS_PO == "Dalam Proses Staff Procurement KP") {
                                            html_progress = '<a href="#" class="btn btn-warning btn-xs"> ' + data_2[j].PROGRESS_PO + ' </a>';
                                        } else {
                                            html_progress = '<a href="#" class="btn btn-secondary btn-xs"> ' + data_2[j].NO_HP_PENGIRIM + ' </a>';
                                        }
                                        html += html_progress + "</br>";
                                    }

                                }

                                html +=
                                    '</td>' +

                                    '<td>';

                                if (data_2 == 'TIDAK ADA DATA') {
                                    var PO = '';

                                } else {
                                    for (j = 0; j < data_2.length; j++) {
                                        var html_progress = '';
                                        html_progress = '<a href="#" class="btn btn-secondary btn-xs"> ' + data_2[j].KEPADA + ' </a>';                                        
                                        html += html_progress + "</br>";
                                    }

                                }

                                html +=
                                    '</td>' +

                                    '<td>';

                                if (data_2 == 'TIDAK ADA DATA') {
                                    var PO = '';

                                } else {
                                    for (j = 0; j < data_2.length; j++) {
                                        var html_progress = '';
                                        html_progress = '<a href="#" class="btn btn-secondary btn-xs"> ' + data_2[j].TUJUAN + ' </a>';
                                        html += html_progress + "</br>";
                                    }

                                }

                                html +=
                                    '</td>' +

                                    '<td>';

                                if (data_2 == 'TIDAK ADA DATA') {
                                    var PO = '';

                                } else {
                                    for (j = 0; j < data_2.length; j++) {
                                        PO = '<a href="<?php echo base_url() ?>Rencana_pengiriman_barang_form/view/' + data_2[j].HASH_MD5_RENCANA_PENGIRIMAN_BARANG + '" class="btn btn-primary btn-xs btn-outline"><i class="fa fa-eye"></i> ' + data_2[j].NO_RENCANA_PENGIRIMAN_BARANG + ' </a>';
                                        html += PO + "</br>";
                                    }

                                }
                            }
                        });

                    }
                    $('#show_data').html(html);

                }
            });
        }

        //GET NOMOR URUT PER SPPB
        $('#show_data').on('click', '.item_buat_po_baru', function() {
            $('#btn_simpan').attr('disabled', true); //disable input
            $('#saya_setuju').prop('checked', false); // Unchecks it
            var HASH_MD5_PO = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/Rencana_pengiriman_barang/get_data_proyek_by_hash_md5_po') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_PO: HASH_MD5_PO
                },
                success: function(data) {
                    $.each(data, function(
                        ID_PO,
                        ID_PROYEK,
                        NO_URUT_PO,
                        ID_RASD,
                        ID_SPPB,
                        NAMA_PROYEK,
                        LOKASI,
                        INISIAL) {

                        $('[name="ID_PO"]').val(data.ID_PO);
                        $('[name="ID_PROYEK"]').val(data.ID_PROYEK);
                        $('[name="NO_URUT_PO"]').val(data.NO_URUT_PO);
                        $('[name="ID_RASD"]').val(data.ID_RASD);
                        $('[name="ID_SPPB"]').val(data.ID_SPPB);
                        $('[name="NAMA_PROYEK"]').val(data.NAMA_PROYEK);
                        $('[name="LOKASI"]').val(data.LOKASI);
                        $('[name="INISIAL"]').val(data.INISIAL);

                        var ID_SPPB = data.ID_SPPB;
                        var INISIAL = data.INISIAL;
                        var ID_PROYEK = data.ID_PROYEK;
                        var ID_PO = data.ID_PO;

                        var COUNT = "";
                        var NO_URUT = "";
                        var DEPAN = "";

                        $.ajax({
                            type: "GET",
                            url: "<?php echo base_url() ?>Rencana_pengiriman_barang/get_nomor_urut",
                            dataType: "JSON",
                            data: {
                                ID_PROYEK: ID_PROYEK
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

                                    $('#ModalAdd').modal('show');


                                    $('[name="JUMLAH_COUNT"]').val(COUNT);
                                    $('[name="NO_RENCANA_PENGIRIMAN_BARANG"]').val(`${NO_URUT}/RPB/WME/${INISIAL}/2021`);
                                    $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_RPB_WME_${INISIAL}_2021`);

                                });

                            }
                        });

                    });
                }
            });
            return false;
        });


        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            var form_data = {
                ID_PO: $('#ID_PO').val(),
                ID_PROYEK: $('#ID_PROYEK').val(),
                ID_RASD: $('#ID_RASD').val(),
                INISIAL: $('#INISIAL').val(),
                NAMA_PROYEK: $('#NAMA_PROYEK').val(),
                NO_URUT_SPPB: $('#NO_URUT_SPPB').val(),
                ID_SPPB: $('#ID_SPPB').val(),
                JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
                NO_URUT_PO: $('#NO_URUT_PO').val(),
                NO_RENCANA_PENGIRIMAN_BARANG: $('#NO_RENCANA_PENGIRIMAN_BARANG').val(),
                TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI: $('#TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI').val(),
                NAMA_PENGIRIM: $('#NAMA_PENGIRIM').val(),
                NO_HP_PENGIRIM: $('#NO_HP_PENGIRIM').val(),
                KEPADA: $('#KEPADA').val(),
                TUJUAN: $('#TUJUAN').val(),
                PERALATAN_PERLENGKAPAN: $('#PERALATAN_PERLENGKAPAN').val(),
                FILE_NAME_TEMP: $('#FILE_NAME_TEMP').val()
            };
            $.ajax({
                url: "<?php echo site_url('Rencana_pengiriman_barang/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 1) {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        console.log(form_data);
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('Rencana_pengiriman_barang/get_data_rpb_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                console.log(data);
                                $.each(data, function() {
                                    if (data == 'BELUM ADA RPB') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        window.location.href = '<?php echo base_url(); ?>Rencana_pengiriman_barang_form/index/' + data.HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
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