<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List PO</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/PO/') ?>">PO</a>
            </li>
            <li class="active">
                <strong>
                    <a>List PO</a>
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
        Sistem menampilkan PO yang telah dibuat.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" id="ibox1">
                <div class="ibox-title">
                    <h5>PO</h5>
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

                    <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ModalAdd"><span
                            class="fa fa-plus"></span> Buat PO</a>
                    </br>
                    </br>
                    <select name="ID_PROYEK_LIST" class="form-control" id="ID_PROYEK_LIST">
                        <option value=''>- Pilih Proyek Untuk Ditampilkan -</option>
                        <?php foreach ($proyek_dropdown_list as $proyek_dropdown_list) {
                            echo '<option value="' . $proyek_dropdown_list->ID_PROYEK . '">' . $proyek_dropdown_list->NAMA_PROYEK . '</option>';
                        } ?>
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
</br>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 70vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Buat PO</h4>
                <small class="font-bold">Silakan isi identitas formulir PO</small>


            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("FPB/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT_PO" id="JUMLAH_COUNT_PO" disabled />
            <input type="hidden" class="form-control" value="" name="INISIAL" id="INISIAL" disabled />
            <input type="hidden" class="form-control" value="" name="ID_PROYEK_SUB_PEKERJAAN" id="ID_PROYEK_SUB_PEKERJAAN" disabled />


            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Proyek *</label>
                        <div class="col-xs-9">
                            <select name="ID_PROYEK" class="form-control" id="ID_PROYEK">
                                <option value=''>- Pilih Proyek -</option>
                                <?php foreach ($proyek_dropdown as $proyek_dropdown) {
                                    echo '<option value="' . $proyek_dropdown->ID_PROYEK.'">' . $proyek_dropdown->NAMA_PROYEK . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Pekerjaan</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="SUB_PROYEK" id="SUB_PROYEK"
                                disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">No. Urut SPP *</label>
                        <div class="col-xs-9">
                            <select name="NO_URUT_SPP" class="form-control" id="NO_URUT_SPP">
                            </select>
                        </div>
                    </div>

                   

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut PO*</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" placeholder="Contoh: 009/WME/PO/CC-CRB2/2022 " name="NO_URUT_PO" id="NO_URUT_PO" />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
                            <input type="hidden" class="form-control" value="" name="ID_SPP" id="ID_SPP" disabled />
                            <input type="hidden" class="form-control" value="" name="ID_SPPB" id="ID_SPPB" disabled />
                        </div>
                    </div>

                    <div class="form-group" id="data_TANGGAL_DOKUMEN_PO">
                        <label class="col-xs-3 control-label">Tanggal Dokumen PO */**</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_PO" type="text" class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                            </br>
                            *wajib diisi
                            </br>
                            **Sistem juga menyimpan tanggal aktual pembuatan PO ini by system
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Vendor</label>
                        <div class="col-xs-9">
                            <select class="form-control" name="ID_VENDOR" id="ID_VENDOR">
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Jenis Pengadaan</label>
                        <div class="col-xs-9">
                            <select name="JENIS_PENGADAAN" class="form-control" id="JENIS_PENGADAAN">
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Klasifikasi Barang</label>
                        <div class="col-xs-9">
                            <select name="KLASIFIKASI_BARANG" class="form-control" id="KLASIFIKASI_BARANG">
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses identitas form PO ini dan menyetujui untuk proses pengisian item barang/jasa </label></div>
                        </div>
                    </div>

                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" name="btn_simpan" id="btn_simpan" disabled><i class="fa fa-save"></i> Buat PO</button>
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

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function() {

        $('#data_TANGGAL_DOKUMEN_PO .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_simpan').removeAttr('disabled'); //enable input

            } else {
                $('#btn_simpan').attr('disabled', true); //disable input
            }
        });

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
                title: 'PO'
            },
            {
                extend: 'print',
                customize: function (win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
            ]

        });

        $("#ID_PROYEK_LIST").change(function () {

            var form_data = {
                ID_PROYEK: $('#ID_PROYEK_LIST').val()
            }

            var ID_PROYEK = $('#ID_PROYEK_LIST').val();
            var NAMA_PROYEK = $('#ID_PROYEK_LIST option:selected').text();
            var JUDUL = "List PO " + NAMA_PROYEK;

            if (ID_PROYEK == "Semua") {

                $('#mydata').dataTable().fnClearTable();
                $("#mydata").dataTable().fnDestroy();

                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                
                $.ajax({
                    url: "<?php echo base_url(); ?>/PO/data_PO",
                    method: "POST",
                    data: form_data,
                    async: true,
                    dataType: 'json',
                    success: function (data) {

                        var html, html_head = '';

                        $('#show_data_head').html(html_head);
                        $('#show_data').html(html);

                        if (data.length > 0)
                        {
                            var data_1 = data;
                            var html = '';
                            var i, j, k = 0;

                            for (i = 0; i < data_1.length; i++) {
                                var form_data = {
                                    ID_SPP: data_1[i].ID_SPP,
                                };

                                $.ajax({
                                    url: "<?php echo site_url('PO/get_list_po_by_id_spp') ?>",
                                    type: "POST",
                                    dataType: "JSON",
                                    async: false,
                                    data: {
                                        ID_SPP: data_1[i].ID_SPP,
                                    },
                                    success: function (data) {
                                        var data_2 = data;
                                        var PO = '';

                                        if (data_2 == 'TIDAK ADA DATA') {
                                            // html += '<tr style="background-color:#DAF7A6">' ;

                                        } else {
                                            html += '<tr>' ;
                                        }

                                        // html += '<td>' + '<a href="<?php echo base_url() ?>SPP_form/view/' + data_1[i].HASH_MD5_SPP + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_1[i].NO_URUT_SPP + ' </a>';

                                        // html += '</br><a href="javascript:;" class="btn btn-success btn-xs item_buat_po_baru" data="' + data_1[i].HASH_MD5_SPP + '"><i class="fa fa-plus"></i> Buat PO </a>' + ' ' +
                                        //     '</td>';

                                        // KOLOM NO URUT PO
                                       
                                        if (data_2 == 'TIDAK ADA DATA') {
                                            // var PO = '';
                                        } else {
                                            html +=
                                            '<td>';
                                            for (j = 0; j < data_2.length; j++) {
                                                PO = '<a href="<?php echo base_url() ?>PO_form/view/' + data_2[j].HASH_MD5_PO + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_2[j].NO_URUT_PO + ' </a>';
                                                html += PO + "</br>";
                                            }
                                            html +=
                                            '</td>';
                                        }
                                        

                                        // KOLOM NAMA PROYEK
                                        if (data_2 == 'TIDAK ADA DATA') {
                                                // var SPP = '';

                                        } else {
                                            html +=
                                            '<td>';
                                            PO = '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_1[i].NAMA_PROYEK + ' </a>';
                                            html += PO + "</br>";
                                            html +=
                                            '</td>';
                                        }

                                        // KOLOM PEKERJAAN
                                        if (data_2 == 'TIDAK ADA DATA') {
                                                // var SPP = '';

                                        } else {
                                            html +=
                                            '<td>';

                                            PEKERJAAN = '<a href="#" class="btn btn-link btn-xs text-decoration-none">' + data_1[i].NAMA_SUB_PEKERJAAN + ' </a>';
                                            html += PEKERJAAN + "</br>";
                                            
                                            html +=
                                            '</td>';
                                        }


                                        // KOLOM TANGGAL
                                        if (data_2 == 'TIDAK ADA DATA') {
                                            // var PO = '';

                                        } else {
                                            html +=
                                            '<td>';
                                            for (j = 0; j < data_2.length; j++) {
                                                var TANGGAL = '';
                                                TANGGAL = '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_2[j].TANGGAL_DOKUMEN_PO + ' </a>';
                                                html += TANGGAL + "</br>";
                                            }
                                            html +=
                                        '</td>';
                                        }
                                        

                                        // KOLOM STATUS
                                        if (data_2 == 'TIDAK ADA DATA') {
                                            var PO = '';

                                        } else {
                                            html +=
                                            '<td>';
                                            for (j = 0; j < data_2.length; j++) {
                                                var STATUS = '';
                                                STATUS = '<a href="javascript:;" class="btn btn-primary btn-xs item_status block" data="' + data_2[j].ID_PO + '"><i class="fa fa-search"></i>'+ data_2[j].STATUS_PO + '</a>';
                                                html += STATUS ;
                                            }
                                            html +=
                                            '</td>';
                                        }
                                       

                                        html += '</tr>';
                                    }
                                });

                            }

                        }

                        else
                        {
                            html = '';
                        }

                        html_head = '<tr><th>No. PO</th><th>Proyek</th><th>Pekerjaan</th><th>Tanggal Dokumen PO</th><th>Status PO</th></tr>';
                        $('#show_data_head').html(html_head);
                        $('#show_data').html(html);

                        
                        $('#mydata').dataTable({
                            order: [[0, 'desc']],
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
                                customize: function (win) {
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');

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

                setTimeout(function(){
                    $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                }, 3000); 

            }
            else {

                $('#mydata').dataTable().fnClearTable();
                $("#mydata").dataTable().fnDestroy();

                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');

                $.ajax({
                    url: "<?php echo base_url(); ?>/PO/data_PO_by_id_proyek_list",
                    method: "POST",
                    data: form_data,
                    async: true,
                    dataType: 'json',
                    success: function (data) {

                        var html, html_head = '';

                        $('#show_data_head').html(html_head);
                        $('#show_data').html(html);

                        if (data.length > 0)
                        {
                            var data_1 = data;
                            var html = '';
                            var i, j, k = 0;

                            for (i = 0; i < data_1.length; i++) {
                                var form_data = {
                                    ID_SPP: data_1[i].ID_SPP,
                                };

                                $.ajax({
                                    url: "<?php echo site_url('PO/get_list_po_by_id_spp') ?>",
                                    type: "POST",
                                    dataType: "JSON",
                                    async: false,
                                    data: {
                                        ID_SPP: data_1[i].ID_SPP,
                                    },
                                    success: function (data) {
                                        var data_2 = data;
                                        var PO = '';

                                        if (data_2 == 'TIDAK ADA DATA') {
                                            // html += '<tr style="background-color:#DAF7A6">' ;
                                        } else {
                                            html += '<tr>' ;
                                        }

                                        // KOLOM NO URUT PO
                                        
                                        if (data_2 == 'TIDAK ADA DATA') {
                                            // var PO = '';
                                        } else {
                                            html +=
                                            '<td>';
                                            for (j = 0; j < data_2.length; j++) {
                                                PO = '<a href="<?php echo base_url() ?>PO_form/view/' + data_2[j].HASH_MD5_PO + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_2[j].NO_URUT_PO + ' </a>';
                                                html += PO + "</br>";
                                            }
                                            html +=
                                            '</td>';
                                        }
                                        

                                        // KOLOM PEKERJAAN
                                        if (data_2 == 'TIDAK ADA DATA') {
                                                // var SPP = '';
                                        } else {
                                            html += 
                                            '<td>';
                                            PEKERJAAN = '<a href="#" class="btn btn-link btn-xs text-decoration-none">' + data_1[i].NAMA_SUB_PEKERJAAN + ' </a>';
                                            html += PEKERJAAN + "</br>";
                                            html += 
                                            '</td>';
                                        }

                                        // KOLOM TANGGAL
                                       
                                        if (data_2 == 'TIDAK ADA DATA') {
                                            // var PO = '';
                                        } else {
                                            html +=
                                            '<td>';
                                            for (j = 0; j < data_2.length; j++) {
                                                var TANGGAL = '';
                                                TANGGAL = '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_2[j].TANGGAL_DOKUMEN_PO + ' </a>';
                                                html += TANGGAL + "</br>";
                                            }
                                            html +=
                                            '</td>';
                                        }
                                        

                                        // KOLOM STATUS
                                        if (data_2 == 'TIDAK ADA DATA') {
                                            var PO = '';
                                        } else {
                                            html +=
                                            '<td>';
                                            for (j = 0; j < data_2.length; j++) {
                                                var STATUS = '';
                                                STATUS = '<a href="javascript:;" class="btn btn-primary btn-xs item_status block" data="' + data_2[j].ID_PO + '"><i class="fa fa-search"></i> '+ data_2[j].STATUS_PO + '</a>';
                                                html += STATUS;
                                            }
                                            html +=
                                            '</td>';
                                        }
                                        
                                        html += '</tr>';
                                    }
                                });

                            }
                        }
                        else
                        {
                            html = '';
                        }

                        html_head = '<tr><th>No. PO</th><th>Pekerjaan</th><th>Tanggal Dokumen PO</th><th>Status PO</th></tr>';
                        $('#show_data_head').html(html_head);
                        $('#show_data').html(html);

                        $('#mydata').dataTable({
                            order: [[0, 'desc']],
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
                                customize: function (win) {
                                    $(win.document.body).addClass('white-bg');
                                    $(win.document.body).css('font-size', '10px');

                                    $(win.document.body).find('table')
                                        .addClass('compact')
                                        .css('font-size', 'inherit');
                                }
                            }
                            ]

                        });

                    }
                });

                setTimeout(function(){
                    $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                }, 3000); 

            }
        });

        // Dropdown ID VENDOR berubah
        $("#ID_VENDOR").change(function () {
            var ID_SPP = $('#ID_SPP').val();
            var ID_VENDOR = $('#ID_VENDOR').val();

            // Menggunakan ajax untuk mengirim dan dan menerima data dari server
            $.ajax({
                url: "<?php echo base_url(); ?>/PO/get_data_jenis_pengadaan_by_id_spp_id_vendor",
                method: "POST",
                data: {
                    ID_SPP: ID_SPP,
                    ID_VENDOR: ID_VENDOR,
                },
                async: false,
                dataType: 'json',
                success: function(data) {
   
                    var html = '';
                    var i;

                    html = "<option value=''>- Pilih Jenis Pengadaan -</option>";

                    for (i = 0; i < data.length; i++) {
                        if (data[i].JENIS_PENGADAAN == null)
                        {
                            html += '';
                        }
                        else
                        {
                            html += '<option value=' + data[i].JENIS_PENGADAAN + '>' + data[i].JENIS_PENGADAAN + '</option>';
                        }
                        
                    }
                    $('#JENIS_PENGADAAN').html(html);
                }
            });

        });

        // Dropdown JENIS_PENGADAAN
        $("#JENIS_PENGADAAN").change(function () {
            var ID_SPP = $('#ID_SPP').val();
            var ID_VENDOR = $('#ID_VENDOR').val();
            var JENIS_PENGADAAN = $('#JENIS_PENGADAAN').val();

            // Menggunakan ajax untuk mengirim dan dan menerima data dari server
            $.ajax({
                url: "<?php echo base_url(); ?>/PO/get_data_jenis_pengadaan_by_id_spp_id_vendor_jenis_pengadaan",
                method: "POST",
                data: {
                    ID_SPP: ID_SPP,
                    ID_VENDOR: ID_VENDOR,
                    JENIS_PENGADAAN: JENIS_PENGADAAN,
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;

                    html = "<option value=''>- Pilih Klasifikasi Barang -</option>";

                    for (i = 0; i < data.length; i++) {
                        if (data[i].ID_KLASIFIKASI_BARANG == null)
                        {
                            html += '';
                        }
                        else
                        {
                            html += '<option value=' + data[i].ID_KLASIFIKASI_BARANG + '>' + data[i].NAMA_KLASIFIKASI_BARANG + '</option>';
                        }
                        
                    }
                    html += '<option value="SEMUA">Pilih Semua Klasifikasi</option>';
                    $('#KLASIFIKASI_BARANG').html(html);
                }
            });

        });


        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            var FILE_NAME_TEMP = $('#NO_URUT_SPP').val();
            FILE_NAME_TEMP = FILE_NAME_TEMP.replace(/[^a-zA-Z0-9]/g, '_');

            var TANGGAL_DOKUMEN_PO = $('#TANGGAL_DOKUMEN_PO').val(),
            TANGGAL_DOKUMEN_PO = TANGGAL_DOKUMEN_PO.split("/").reverse().join("-");

            var form_data = {
                ID_PROYEK: $('#ID_PROYEK').val(),
                ID_SPP: $('#ID_SPP').val(),
                ID_SPPB: $('#ID_SPPB').val(),
                JUMLAH_COUNT_PO: $('#JUMLAH_COUNT_PO').val(),
                NO_URUT_PO: $('#NO_URUT_PO').val(),
                FILE_NAME_TEMP: FILE_NAME_TEMP,
                TANGGAL_DOKUMEN_PO: TANGGAL_DOKUMEN_PO,
                ID_PROYEK_SUB_PEKERJAAN: $('#ID_PROYEK_SUB_PEKERJAAN').val(),
                ID_VENDOR: $('#ID_VENDOR').val(),
                JENIS_PENGADAAN: $('#JENIS_PENGADAAN').val(),
                KLASIFIKASI_BARANG: $('#KLASIFIKASI_BARANG').val(),
            };
            $.ajax({
                url: "<?php echo site_url('PO/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 1) {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('PO/get_data_po_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
         
                                $.each(data, function() {
                                    if (data == 'BELUM ADA PO') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        window.location.href = '<?php echo base_url(); ?>PO_form/index/' + data.HASH_MD5_PO;
                                    }
                                });
                            }
                        });
                    }
                }
            });


            return false;
        });

        $("#ID_PROYEK").change(function () {

            $('[name="ID_PROYEK_SUB_PEKERJAAN"]').val("");

            var ID_PROYEK = $('[name="ID_PROYEK"]').val();

            var form_data = {
                ID_PROYEK: ID_PROYEK,
            }

            $.ajax({
                url: "<?php echo base_url(); ?>/PO/get_data_spp_by_id_proyek",
                method: "POST",
                data: form_data,
                async: false,
                dataType: 'json',
                success: function (data) {

                    if (data == "TIDAK ADA DATA")

                    {
                        var html = '';
                        var i;

                        html += '<option value="">- Tidak Ada SPP -</option>';

                        $('#NO_URUT_SPP').html(html);
                        document.getElementById("NO_URUT_PO").disabled = true;
                        document.getElementById("TANGGAL_DOKUMEN_PO").disabled = true;

                    }

                    else
                    {
                        var html = '';
                        var i;

                        html += '<option value="">- Pilih SPP -</option>';
                        for (i = 0; i < data.length; i++) {
                            html += '<option value="' + data[i].HASH_MD5_SPP + '">' + data[i].NO_URUT_SPP + '</option>';
                        }
                        $('#NO_URUT_SPP').html(html);

                        document.getElementById("NO_URUT_PO").disabled = false;
                        document.getElementById("TANGGAL_DOKUMEN_PO").disabled = false;

                    }

                    

                }
            });

        });

        $("#NO_URUT_SPP").change(function () {

            var HASH_MD5_SPP = $('[name="NO_URUT_SPP"]').val();

            var form_data = {
                HASH_MD5_SPP: HASH_MD5_SPP,
            }

            $.ajax({
                url: "<?php echo base_url(); ?>/PO/get_data_proyek_by_hash_md5_spp",
                method: "POST",
                data: form_data,
                async: false,
                dataType: 'json',
                success: function (data) {

                    $('[name="ID_PROYEK_SUB_PEKERJAAN"]').val(data.ID_PROYEK_SUB_PEKERJAAN);
                    $('[name="ID_RASD"]').val(data.ID_RASD);
                    $('[name="INISIAL"]').val(data.INISIAL);
                    $('[name="NAMA_PROYEK"]').val(data.NAMA_PROYEK);
                    $('[name="SUB_PROYEK"]').val(data.SUB_PROYEK);
                    $('[name="ID_SPP"]').val(data.ID_SPP);
                    $('[name="ID_SPPB"]').val(data.ID_SPPB);

                    var ID_SPP = data.ID_SPP;
                    var INISIAL = data.INISIAL;
                    var ID_PROYEK = data.ID_PROYEK;

                    var COUNT = "";
                    var NO_URUT = "";
                    var DEPAN = "";

                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url() ?>PO/get_nomor_urut",
                        dataType: "JSON",
                        data: {
                            ID_PROYEK: ID_PROYEK
                        },
                        success: function(data) {
                            $.each(data, function() {

                                var COUNT = data.JUMLAH_COUNT_PO;
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

                                // $('#ModalAdd').modal('show');

                                $('[name="JUMLAH_COUNT_PO"]').val(COUNT);
                                //$('[name="NO_URUT_PO"]').val(`${NO_URUT}/PO/WME/${INISIAL}/${date.getFullYear()}`);
                                $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_PO_WME_${INISIAL}_${date.getFullYear()}`);

                            });

                        }
                    });

                    var ID_SPP = $('#ID_SPP').val();

                    // Menggunakan ajax untuk mengirim dan dan menerima data dari server
                    $.ajax({
                        url: "<?php echo base_url(); ?>/PO/get_data_id_vendor_by_id_spp",
                        method: "POST",
                        data: {
                            ID_SPP: ID_SPP
                        },
                        async: false,
                        dataType: 'json',
                        success: function(data) {

                            var html = '';
                            var i;

                            html = "<option value=''>- Pilih Vendor -</option>";

                            for (i = 0; i < data.length; i++) {
                                if (data[i].NAMA_VENDOR == null)
                                {
                                    html += '';
                                }
                                else
                                {
                                    html += '<option value=' + data[i].ID_VENDOR + '>' + data[i].NAMA_VENDOR + '</option>';
                                }
                                
                            }
                            $('#ID_VENDOR').html(html);
                        }
                    });
                    
                }
            });

        });

    });
</script>

</body>

</html>