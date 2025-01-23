<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Data Korban</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPPB/') ?>">Data KOrban</a>
            </li>
            <li class="active">
                <strong>
                    <a>List Data Korban</a>
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
        Sistem menampilkan seluruh data korban.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" id="ibox1">
                <div class="ibox-title">
                    <h5>Data Korban</h5>
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
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>

                    <a href="#" class="btn btn-primary btn-xs" name="btn_buat" id="btn_buat"><span
                            class="fa fa-plus"></span> Tambah Data Korban</a>

                    <!-- <a href="#" class="btn btn-primary btn-xs" name="btn_buat" id="btn_buat" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Buat Pengajuan Bantuan</a> -->
                    </br>
                    </br>

                    <select class="chosen-select" name="ID_JENIS_BENCANA_LIST" class="form-control"
                        id="ID_JENIS_BENCANA_LIST">
                        <option value=''>- Pilih Bencana -</option>
                        <option value='Semua'>Semua Bencana</option>
                        <option value='Gempa Bumi'>Gempa Bumi</option>
                        <option value='Angin Puting Beliung'>Angin Puting Beliung</option>
                        <option value='Banjir'>Banjir</option>
                        <option value='Longsor'>Longsor</option>
                        <option value='Tsunami'>Tsunami</option>
                        <option value='Kebakaran'>Kebakaran</option>
                        <option value='Pohon Tumbang'>Pohon Tumbang</option>
                        <option value='Kekeringan'>Kekeringan</option>
                    </select>

                    </br>
                    </br>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead id="show_data_head">
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
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 70vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Buat Data Korban</h4>
                <small class="font-bold">Silakan isi identitas data korban</small>
            </div>
            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
            <input type="hidden" class="form-control" value="" name="CODE_MD5" id="CODE_MD5" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Bencana *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="JENIS_BENCANA" class="form-control" id="JENIS_BENCANA">
                                <option value=''>- Pilih Bencana -</option>
                                <option value='semua'> Semua Bencana -</option>
                                <option value='Gempa Bumi'>Gempa Bumi</option>
                                <option value='Angin Puting Beliung'>Angin Puting Beliung</option>
                                <option value='Banjir'>Banjir</option>
                                <option value='Longsor'>Longsor</option>
                                <option value='Tsunami'>Tsunami</option>
                                <option value='Kebakaran'>Kebakaran</option>
                                <option value='Pohon Tumbang'>Pohon Tumbang</option>
                                <option value='Kekeringan'>Kekeringan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama Korban *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NAMA_KORBAN" id="NAMA_KORBAN"
                                placeholder="Contoh: Apprilia Agusti" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">NO KK </label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_KK" id="NO_KK"
                                placeholder="Contoh: 3602041211870001" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">NIK *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NIK" id="NIK"
                                placeholder="Contoh: 3602041211870001" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tempat Lahir *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="TEMPAT_LAHIR" id="TEMPAT_LAHIR"
                                placeholder="Contoh: Kota Cianjur" />
                        </div>
                    </div>
                    <div class="form-group" id="data_TANGGAL_LAHIR">
                        <label class="col-xs-3 control-label">Tanggal Lahir *</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    id="TANGGAL_LAHIR" type="text" class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Alamat *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="ALAMAT" id="ALAMAT"
                                placeholder="Contoh: UG Technopark, Jamali, Kec. Mande, Kabupaten Cianjur" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kabupaten/Kota *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_KABUPATEN_KOTA" class="form-control"
                                id="ID_KABUPATEN_KOTA">
                                <option value=''>- Pilih Kabupaten/Kota -</option>
                                <option value='Cianjur'>Cianjur</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kecamatan *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_KECAMATAN" class="form-control" id="ID_KECAMATAN">
                                <option value=''>- Pilih Kecamatan -</option>
                                <option value='Bojongpicung'>Bojongpicung</option>
                                <option value='Campaka'>Campaka</option>
                                <option value='Campaka Mulya'>Campaka Mulya</option>
                                <option value='Cianjur'>Cianjur</option>
                                <option value='Cibeber'>Cibeber</option>
                                <option value='Cibinong'>Cibinong</option>
                                <option value='Cidaun'>Cidaun</option>
                                <option value='Cijati'>Cijati</option>
                                <option value='Cikadu'>Cikadu</option>
                                <option value='Cikalongkulon'>Cikalongkulon</option>
                                <option value='Cilaku'>Cilaku</option>
                                <option value='Cipanas'>Cipanas</option>
                                <option value='Ciranjang'>Ciranjang</option>
                                <option value='Cugenang'>Cugenang</option>
                                <option value='Gekbrong'>Gekbrong</option>
                                <option value='Haurwangi'>Haurwangi</option>
                                <option value='Kadupandak'>Kadupandak</option>
                                <option value='Karangtengah'>Karangtengah</option>
                                <option value='Leles'>Leles</option>
                                <option value='Mande'>Mande</option>
                                <option value='Naringgul'>Naringgul</option>
                                <option value='Pacet'>Pacet</option>
                                <option value='Pagelaran'>Pagelaran</option>
                                <option value='Pasirkuda'>Pasirkuda</option>
                                <option value='Sindangbarang'>Sindangbarang</option>
                                <option value='Sukaluyu'>Sukaluyu</option>
                                <option value='Sukanagara'>Sukanagara</option>
                                <option value='Sukaresmi'>Sukaresmi</option>
                                <option value='Takokak'>Takokak</option>
                                <option value='Tanggeung'>Tanggeung</option>
                                <option value='Warungkondang'>Warungkondang</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Desa/Kelurahan *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_DESA_KELURAHAN" class="form-control"
                                id="ID_DESA_KELURAHAN">
                                <option value=''>- Pilih Desa/Kelurahan -</option>
                                <option value='Bojongkaso'>Bojongkaso</option>
                                <option value='Bunisari'>Bunisari</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">RW *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="RW" id="RW"
                                placeholder="Contoh: 02" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">RT *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="RT" id="RT"
                                placeholder="Contoh: 03" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Kampung</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="KAMPUNG" id="KAMPUNG"
                                placeholder="Contoh: Kp. Ciater" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Kode Pos</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="KODE_POS" id="KODE_POS"
                                placeholder="Contoh: 43273" />
                        </div>
                    </div>
                    <div class="form-group" id="data_TANGGAL_KEJADIAN_BENCANA">
                        <label class="col-xs-3 control-label">Tanggal Kejadian Bencana *</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    id="TANGGAL_KEJADIAN_BENCANA" type="text" class="form-control"
                                    placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Simpan Data
                        Korban</button>
                </div>
            </div>
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

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Chosen -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/chosen/chosen.jquery.js"></script>

<!-- Page-Level Scripts -->
<script>
$(document).ready(function() {
    $('.chosen-select').chosen({
        width: "100%"
    });

    var today = new Date().toISOString().substr(0, 10);

    $('#data_TANGGAL_KEJADIAN_BENCANA .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#data_TANGGAL_LAHIR .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    // html_head = '<tr><th>No. SPPB</th><th>Proyek</th>><th>Tanggal Dokumen SPPB</th><th>Status SPPB</th></tr>';
    // $('#show_data_head').html(html_head);
    $('#mydata').dataTable({
        aaSorting: [],
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'excel',
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

    $("#ID_JENIS_BENCANA_LIST").change(function() {

        var form_data = {
            ID_JENIS_BENCANA_LIST: $('#ID_JENIS_BENCANA_LIST').val()
        }

        var ID_JENIS_BENCANA_LIST = $('#ID_JENIS_BENCANA_LIST').val();
        var NAMA_BENCANA = $('#ID_JENIS_BENCANA_LIST option:selected').text();
        var JUDUL = "List Data Korban " + NAMA_BENCANA;

        if (ID_JENIS_BENCANA_LIST == "Semua") {
            $("#mydata").dataTable().fnDestroy();
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');

            $.ajax({
                url: "<?php echo base_url(); ?>/Data_Korban/list_korban_by_all_bencana",
                method: "POST",
                data: form_data,
                async: false,
                dataType: 'json',
                success: function(data) {

                    console.log(data);

                    var html, html_head = '';
                    var i, j, k;

                    $('#show_data_head').html(html_head);
                    $('#show_data').html(html);

                    if (data.length > 0) {
                        for (i = 0; i < data.length; i++) {

                            html += '<tr>' +
                                '<td>' +
                                '<a href="<?php echo base_url() ?>Data_Korban_form/view/' +
                                data[i].CODE_MD5 +
                                '" class="btn btn-default btn-xs btn-outline">' +
                                '<i class="fa fa-eye"></i></a></td>' +
                                '<td>' + data[i].JENIS_BENCANA + '</td>' +
                                '<td>' + data[i].NAMA_KORBAN + '</td>' +
                                '<td>' + data[i].NO_KK + '</td>' +
                                '<td>' + data[i].NIK + '</td>' +
                                '<td>' + data[i].TANGGAL_LAHIR + '</td>' +
                                '<td>' + data[i].TANGGAL_KEJADIAN_BENCANA + '</td>' +
                                '<td>' + data[i].KECAMATAN + '</td>' +
                                '<td>' + data[i].DESA_KELURAHAN + '</td>' +
                                '</tr>';
                        }
                    } else {
                        html = '';
                    }
                    html_head =
                        '<tr><th></th><th>Jenis Bencana</th><th>Nama Korban</th><th>NO.KK</th><th>NIK</th><th>Tanggal Lahir</th><th>Tanggal Bencana</th><th>Kecamatan</th><th>Desa</th></tr>';
                    $('#show_data_head').html(html_head);
                    $('#show_data').html(html);


                    $('#mydata').dataTable({
                        aaSorting: [],
                        pageLength: 10,
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'All'],
                        ],
                        responsive: true,
                        dom: '<"html5buttons"B>lTfgitp',
                        buttons: [{
                                extend: 'excel',
                                title: JUDUL
                            },
                            {
                                extend: 'print',
                                customize: function(win) {
                                    $(win.document.body).addClass(
                                        'white-bg');
                                    $(win.document.body).css('font-size',
                                        '10px');

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                }
                            }
                        ]

                    });
                    // $("#mydata").dataTable().fnDestroy();

                }
            });

            setTimeout(function() {
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            }, 3000);

        } else {
            $("#mydata").dataTable().fnDestroy();
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');

            $.ajax({
                url: "<?php echo base_url(); ?>/Data_Korban/list_korban_by_all_bencana",
                method: "POST",
                data: form_data,
                async: false,
                dataType: 'json',
                success: function(data) {

                    var html, html_head = '';
                    var i, j, k;

                    $('#show_data_head').html(html_head);
                    $('#show_data').html(html);

                    if (data.length > 0) {
                        for (i = 0; i < data.length; i++) {

                            html += '<tr>' +
                                '<td>' +
                                '<a href="<?php echo base_url() ?>Data_Korban_form/view/' +
                                data[i].CODE_MD5 +
                                '" class="btn btn-default btn-xs btn-outline">' +
                                '<i class="fa fa-eye"></i></a></td>' +
                                '<td>' + data[i].JENIS_BENCANA + '</td>' +
                                '<td>' + data[i].NAMA_KORBAN + '</td>' +
                                '<td>' + data[i].NO_KK + '</td>' +
                                '<td>' + data[i].NIK + '</td>' +
                                '<td>' + data[i].TANGGAL_LAHIR + '</td>' +
                                '<td>' + data[i].TANGGAL_KEJADIAN_BENCANA + '</td>' +
                                '<td>' + data[i].KECAMATAN + '</td>' +
                                '<td>' + data[i].DESA_KELURAHAN + '</td>' +
                                '</tr>';
                        }
                    } else {
                        html = '';
                    }


                    html_head =
                        '<tr><th></th><th>Jenis Bencana</th><th>Nama Korban</th><th>NO.KK</th><th>NIK</th><th>Tanggal Lahir</th><th>Tanggal Bencana</th><th>Kecamatan</th><th>Desa</th></tr>';
                    $('#show_data_head').html(html_head);
                    $('#show_data').html(html);



                    $('#mydata').dataTable({
                        aaSorting: [],
                        pageLength: 10,
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'All'],
                        ],
                        responsive: true,
                        dom: '<"html5buttons"B>lTfgitp',
                        buttons: [{
                                extend: 'excel',
                                title: JUDUL
                            },
                            {
                                extend: 'print',
                                customize: function(win) {
                                    $(win.document.body).addClass(
                                        'white-bg');
                                    $(win.document.body).css('font-size',
                                        '10px');

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                }
                            }
                        ]

                    });

                    // $("#mydata").dataTable().fnDestroy();

                }
            });

            setTimeout(function() {
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            }, 3000);
        }
    });
    //SIMPAN DATA
    $('#btn_simpan').click(function() {

        var TANGGAL_LAHIR = $('#TANGGAL_LAHIR').val(),
            TANGGAL_LAHIR = TANGGAL_LAHIR.split("/").reverse().join("-");

        var TANGGAL_KEJADIAN_BENCANA = $('#TANGGAL_KEJADIAN_BENCANA').val(),
            TANGGAL_KEJADIAN_BENCANA = TANGGAL_KEJADIAN_BENCANA.split("/").reverse().join("-");

        var form_data = {
            CODE_MD5: $('#CODE_MD5').val(),
            JENIS_BENCANA: $('#JENIS_BENCANA').val(),
            NAMA_KORBAN: $('#NAMA_KORBAN').val(),
            NO_KK: $('#NO_KK').val(),
            NIK: $('#NIK').val(),
            TEMPAT_LAHIR: $('#TEMPAT_LAHIR').val(),
            TANGGAL_LAHIR: TANGGAL_LAHIR,
            ALAMAT: $('#ALAMAT').val(),
            ID_KABUPATEN_KOTA: $('#ID_KABUPATEN_KOTA').val(),
            ID_KECAMATAN: $('#ID_KECAMATAN').val(),
            ID_DESA_KELURAHAN: $('#ID_DESA_KELURAHAN').val(),
            RW: $('#RW').val(),
            RT: $('#RT').val(),
            KAMPUNG: $('#KAMPUNG').val(),
            KODE_POS: $('#KODE_POS').val(),
            TANGGAL_KEJADIAN_BENCANA: TANGGAL_KEJADIAN_BENCANA
        };

        $.ajax({
            url: "<?php echo site_url('Data_Korban/simpan_data_korban'); ?>",
            type: 'POST',
            data: form_data,
            success: function(data) {
                console.log(data);

                // 

                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('Data_Korban/get_data_korban_baru') ?>",
                    dataType: "JSON",
                    data: form_data,
                    success: function(data) {
                        $.each(data, function() {
                            if (data == 'BELUM ADA DATA KORBAN') {
                                $('#alert-msg').html(
                                    '<div class="alert alert-danger">' +
                                    data + '</div>');
                            } else {
                                window.location.href =
                                    '<?php echo base_url(); ?>Data_Korban_form/index/' +
                                    data.CODE_MD5;
                            }
                        });
                    }
                });
                // }
            }
        });
        return false;
    });

    $('#btn_buat').click(function() {

        $.ajax({
            url: "<?php echo site_url('Data_Korban/generate_md5'); ?>",
            type: 'POST',
            success: function(data) {

                $('[name="CODE_MD5"]').val(data);
                console.log(data);
                $('#ModalAdd').modal('show');

            }
        });
        return false;
    });

});
</script>

</body>

</html>