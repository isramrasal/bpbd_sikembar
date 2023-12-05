<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List KHP</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/KHP/') ?>">KHP</a>
            </li>
            <li class="active">
                <strong>
                    <a>List KHP</a>
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
        Sistem menampilkan KHP yang telah dibuat.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" id="ibox1">
                <div class="ibox-title">
                    <h5>KHP</h5>
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

                    <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Buat KHP</a>
                    </br>
                    </br>

                    <select name="ID_PROYEK_LIST" class="chosen-select" id="ID_PROYEK_LIST">
                        <option value=''>- Pilih Proyek Untuk Ditampilkan -</option>
                        <option value='Semua'>Semua Proyek</option>
                        <?php foreach ($proyek_dropdown_list as $proyek_dropdown_list) {
                            echo '<option value="' . $proyek_dropdown_list->ID_PROYEK . '">' . $proyek_dropdown_list->NAMA_PROYEK . '</option>';
                        } ?>
                    </select>

                    </br>
                    </br>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="data_khp_list">
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
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 70vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Buat KHP</h4>
                <small class="font-bold">Silakan isi identitas formulir KHP</small>
            </div>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT_KHP" id="JUMLAH_COUNT_KHP" disabled />
            <input type="hidden" class="form-control" value="" name="INISIAL" id="INISIAL" disabled />
            <input type="hidden" class="form-control" value="" name="ID_PROYEK_SUB_PEKERJAAN" id="ID_PROYEK_SUB_PEKERJAAN" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                            <label class="control-label col-xs-3">Proyek *</label>
                            <div class="col-xs-9">
                                <select name="ID_PROYEK" class="chosen-select" id="ID_PROYEK">
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
                            <label class="control-label col-xs-3">No. Urut SPPB *</label>
                            <div class="col-xs-9">
                                <select name="NO_URUT_SPPB" class="chosen-select" id="NO_URUT_SPPB">
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-xs-3 control-label">No. Urut KHP*</label>
                            <div class="col-xs-9">
                                <input type="text" class="form-control" value="" placeholder="Contoh: 009/WME/KHP/CC-CRB2/2022 " name="NO_URUT_KHP" id="NO_URUT_KHP" />
                                <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
                                <input type="hidden" class="form-control" value="" name="ID_SPPB" id="ID_SPPB" disabled />
                            </div>
                        </div>

                        <div class="form-group" id="data_TANGGAL_DOKUMEN_KHP">
                            <label class="col-xs-3 control-label">Tanggal Dokumen KHP */**</label>
                            <div class="col-xs-9">
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                        id="TANGGAL_DOKUMEN_KHP" name="TANGGAL_DOKUMEN_KHP" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                </div>
                                </br>
                                *wajib diisi
                                </br>
                                **Sistem juga menyimpan tanggal aktual pembuatan KHP ini by system
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-xs-3 control-label"></label>
                            <div class="col-xs-9">
                            <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses identitas form KHP ini dan menyetujui untuk proses pengisian item barang/jasa </label></div>
                            </div>
                        </div>

                        <div id="alert-msg"></div>

                    </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" name="btn_simpan" id="btn_simpan" disabled><i class="fa fa-save"></i> Buat KHP</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL ADD-->

<!-- MODAL STATUS -->
<div class="modal inmodal fade" id="ModalStatus" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 50vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Status SPPB</h4>
                <small class="font-bold">Progress SPPB sampai dengan Serah Terima Barang</small>
            </div>

            <input type="hidden" class="form-control" value="" name="ID_SPPB_3" id="ID_SPPB_3" disabled />
            <input type="hidden" class="form-control" value="" name="NO_URUT_SPPB_3" id="NO_URUT_SPPB_3" disabled />
            <input type="hidden" class="form-control" value="" name="HASH_MD5_SPPB_3" id="HASH_MD5_SPPB_3" disabled />
            <input type="hidden" class="form-control" value="" name="TANGGAL_DOKUMEN_SPPB_3" id="TANGGAL_DOKUMEN_SPPB_3"
                disabled />

            <input type="hidden" class="form-control" value="" name="PROGRESS_SPPB_3" id="PROGRESS_SPPB_3" disabled />

            <div class="wrapper wrapper-content  animated fadeInRight form-horizontal">
                <div class="row">
                    <div class="modal-body">
                        <div class="social-feed-box">
                            <div class="social-footer">
                                <div class="social-comment">
                                    <div id="show_data_status_new">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-window-close"></i> Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL STATUS-->

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
        $('.chosen-select').chosen({width: "100%"});

        $('#data_TANGGAL_DOKUMEN_KHP .input-group.date').datepicker({
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

        //tampil data
        $('#data_khp_list').dataTable({
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
                title: 'KHP'
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

        //EVENT DROPDOWN PROYEK LIST BERUBAH
        $("#ID_PROYEK_LIST").change(function () {

            var form_data = {
                ID_PROYEK: $('#ID_PROYEK_LIST').val()
            }

            var ID_PROYEK = $('#ID_PROYEK_LIST').val();
            var NAMA_PROYEK = $('#ID_PROYEK_LIST option:selected').text();
            var JUDUL = "List KHP " + NAMA_PROYEK;

            if (ID_PROYEK == "Semua") {
                $('#data_khp_list').dataTable().fnClearTable();
                $("#data_khp_list").dataTable().fnDestroy();

                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                
                $.ajax({
                    url: "<?php echo base_url(); ?>/KHP/list_KHP_by_all_proyek",
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
                                    ID_SPPB: data_1[i].ID_SPPB,
                                };

                                html += '<tr>' ;

                                //KOLOM KHP
                                html += '<td>';
                                KHP = '<a href="<?php echo base_url() ?>KHP_form/view/' + data_1[i].HASH_MD5_KHP + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_1[i].NO_URUT_KHP + ' </a>';
                                html += KHP + "</br>";
                                html += '</td>';

                                // KOLOM PROYEK
                                html += '<td>';
                                KHP = '<a href="#" class="btn btn-link btn-xs text-decoration-none">' + data_1[i].NAMA_PROYEK + ' </a>';
                                html += KHP + "</br>";
                                html += '</td>';

                                // KOLOM PEKERJAAN
                                html += '<td>';
                                KHP = '<a href="#" class="btn btn-link btn-xs text-decoration-none">' + data_1[i].NAMA_SUB_PEKERJAAN + ' </a>';
                                html += KHP + "</br>";
                                html += '</td>';


                                //KOLOM TANGGAL DOKUMEN
                                html += '<td>';
                                KHP = '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_1[i].TANGGAL_DOKUMEN_KHP + ' </a>';
                                html += KHP + "</br>";
                                html += '</td>';

                                //KOLOM STATUS
                                html += '<td>';
                                KHP = '<a href="javascript:;" class="btn btn-primary btn-xs item_status block" data="' + data_1[i].ID_SPPB + '"><i class="fa fa-search"></i> '+ data_1[i].STATUS_KHP + '</a>';
                                html += KHP;
                                html += '</td>';

                                html += '</tr>' ;
                            }

                        }

                        else
                        {
                            html = '';
                        }

                        html_head = '<tr><th>No. KHP</th><th>Proyek</th><th>Pekerjaan</th><th>Tanggal Dokumen KHP</th><th>Status KHP</th></tr>';
                        $('#show_data_head').html(html_head);
                        $('#show_data').html(html);

                        
                        $('#data_khp_list').dataTable({
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
                        // $("#data_khp_list").dataTable().fnDestroy();

                    }
                });

                setTimeout(function(){
                    $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                }, 1000); 

            }
            else {

                $('#data_khp_list').dataTable().fnClearTable();
                $("#data_khp_list").dataTable().fnDestroy();

                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');

                $.ajax({
                    url: "<?php echo base_url(); ?>/KHP/list_KHP_by_id_proyek",
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

                                html += '<tr>' ;

                                //KOLOM KHP
                                html += '<td>';
                                KHP = '<a href="<?php echo base_url() ?>KHP_form/view/' + data_1[i].HASH_MD5_KHP + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_1[i].NO_URUT_KHP + ' </a>';
                                html += KHP + "</br>";
                                html += '</td>';
                                

                                // KOLOM PEKERJAAN
                                html += '<td>';
                                KHP = '<a href="#" class="btn btn-link btn-xs text-decoration-none">' + data_1[i].NAMA_SUB_PEKERJAAN + ' </a>';
                                html += KHP + "</br>";
                                html += '</td>';
                                
                                
                                //KOLOM TANGGAL DOKUMEN
                                html += '<td>';
                                KHP = '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_1[i].TANGGAL_DOKUMEN_KHP + ' </a>';
                                html += KHP + "</br>";
                                html += '</td>';

                                //KOLOM STATUS
                                html += '<td>';
                                KHP = '<a href="javascript:;" class="btn btn-primary btn-xs item_status block" data="' + data_1[i].ID_SPPB + '"><i class="fa fa-search"></i> '+ data_1[i].STATUS_KHP + '</a>';
                                html += KHP;
                                html += '</td>';
                                
                                html += '</tr>' ;
                                
                            }
                        }

                        else
                        {
                            html = '';
                        }

                        html_head = '<tr><th>No. KHP</th><th>Pekerjaan</th><th>Tanggal Dokumen KHP</th><th>Status KHP</th></tr>';
                        $('#show_data_head').html(html_head);
                        $('#show_data').html(html);

                        
                        $('#data_khp_list').dataTable({
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
                        // $("#data_khp_list").dataTable().fnDestroy();

                    }
                });

                setTimeout(function(){
                    $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                }, 1000); 
            }
        });
        //end tampil data

        $("#ID_PROYEK").change(function () {

            $('[name="ID_PROYEK_SUB_PEKERJAAN"]').val("");

            var ID_PROYEK = $('[name="ID_PROYEK"]').val();

            var form_data = {
                ID_PROYEK: ID_PROYEK,
            }

            $.ajax({
                url: "<?php echo base_url(); ?>/KHP/get_data_sppb_by_id_proyek",
                type: "POST",
                data: form_data,
                async: false,
                dataType: 'json',
                success: function (data) {

                    if (data == "TIDAK ADA DATA")

                    {
                        var html = '';
                        var i;

                        $("#NO_URUT_SPPB").chosen();
                        $('#NO_URUT_SPPB').empty();

                        html += '<option selected="selected" value="">- Tidak Ada SPPB -</option>';
                        $('#NO_URUT_SPPB').html(html);

                        $("#NO_URUT_SPPB").trigger("liszt:updated");
                        $("#NO_URUT_SPPB").chosen();
                        $("#NO_URUT_SPPB").trigger("chosen:updated");

                    }

                    else
                    {
                        var html = '';
                        var i;

                        $("#NO_URUT_SPPB").chosen();
                        $('#NO_URUT_SPPB').empty();

                        html = "<option value=''>- Pilih SPPB -</option>";
                        $('#NO_URUT_SPPB').html(html);

                        for (i = 0; i < data.length; i++) {
                            $("#NO_URUT_SPPB").append('<option value="' + data[i].ID_SPPB  + '">' + data[i].NO_URUT_SPPB + ' </option>');
                        }

                        $("#NO_URUT_SPPB").trigger("liszt:updated");
                        $("#NO_URUT_SPPB").chosen();
                        $("#NO_URUT_SPPB").trigger("chosen:updated");

                    }

                    

                }
            });

        });

        $("#NO_URUT_SPPB").change(function () {

            var ID_SPPB = $('[name="NO_URUT_SPPB"]').val();
            $('[name="ID_SPPB"]').val(ID_SPPB);

            var form_data = {
                ID_SPPB: ID_SPPB,
            }

            $.ajax({
                url: "<?php echo base_url(); ?>/KHP/get_data_sub_pekerjaan_by_id_sppb",
                type: "POST",
                data: form_data,
                async: false,
                dataType: 'json',
                success: function (data) {

                    $('[name="SUB_PROYEK"]').val(data[0].NAMA_SUB_PEKERJAAN);
                    $('[name="ID_PROYEK_SUB_PEKERJAAN"]').val(data[0].ID_PROYEK_SUB_PEKERJAAN);
                    
                }
            });

        });

        //EVENT MODAL STATUS MUNCUL
        $('#ModalStatus').on('shown.bs.modal', function () {

            var ID_SPPB = $("#ID_SPPB_3").val();
            var NO_URUT_SPPB = $("#NO_URUT_SPPB_3").val();
            var HASH_MD5_SPPB = $("#HASH_MD5_SPPB_3").val();
            var TANGGAL_DOKUMEN_SPPB = $("#TANGGAL_DOKUMEN_SPPB_3").val();
            var PROGRESS_SPPB = $("#PROGRESS_SPPB_3").val();
            var html, html_new = "";
            var NO_URUT_SPPB_CETAK = NO_URUT_SPPB;
            var NO_URUT_SPP_CETAK_NEW = "";
            var NO_URUT_PO_CETAK_NEW = "";
            var NO_URUT_FSTB_CETAK_NEW = "";

            //GET JUMLAH ITEM BARANG

            var ID_SPPB = ID_SPPB;
            $.ajax({
                url: "<?php echo site_url('SPPB/data_qty_sppb_form') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    ID_SPPB: ID_SPPB,
                },
                success: function (data) {

                    html_new += '<div class="media-body"><a href="<?php echo base_url() ?>sppb_form/view/' + HASH_MD5_SPPB + '">' + NO_URUT_SPPB_CETAK + '</a><small class="text-muted"> <i class="fa fa-dropbox"></i> ' + data[0].JUMLAH_BARANG_SPPB + ' item barang</small><small class="text-muted"> | Tanggal ' + TANGGAL_DOKUMEN_SPPB + ' | Progress: ' + PROGRESS_SPPB + '</small></div>';
                }
            });

            $.ajax({
                url: "<?php echo site_url('SPPB/get_list_spp_by_id_sppb') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: {
                    ID_SPPB: ID_SPPB,
                },
                success: function (data) {
                    var data_2 = data;

                    if (data_2 != "TIDAK ADA DATA") {
                        for (j = 0; j < data_2.length; j++) {

                            var ID_SPP = data_2[j].ID_SPP;
                            var NO_URUT_SPP = data_2[j].NO_URUT_SPP;
                            var HASH_MD5_SPP = data_2[j].HASH_MD5_SPP;
                            var TANGGAL_DOKUMEN_SPP = data_2[j].TANGGAL_DOKUMEN_SPP;
                            var STATUS_SPP = data_2[j].STATUS_SPP;
                            var br_SPP = "";
                            var br_SPP2 = "";

                            //html_progress = html_progress + NO_URUT_SPP + "</br>";
                            $.ajax({
                                url: "<?php echo site_url('SPPB/get_list_po_by_id_spp') ?>",
                                type: "POST",
                                dataType: "JSON",
                                async: false,
                                data: {
                                    ID_SPP: ID_SPP,
                                },
                                success: function (data) {
                                    var data_3 = data;

                                    if (data_3 != "TIDAK ADA DATA") {

                                        l = 0;
                                        NO_URUT_PO_CETAK_NEW = "";
                                        for (k = 0; k < data_3.length; k++) {
                                            var ID_PO = data_3[k].ID_PO;
                                            var NO_URUT_PO = data_3[k].NO_URUT_PO;
                                            var HASH_MD5_PO = data_3[k].HASH_MD5_PO;
                                            var TANGGAL_DOKUMEN_PO = data_3[k].TANGGAL_DOKUMEN_PO;
                                            var STATUS_PO = data_3[k].STATUS_PO;
                                            var br_PO = "";

                                            if (k > 0) {
                                                br_SPP += '<a href="#" class="btn btn-link btn-xs block text-decoration-none">----</a>';
                                            }

                                            $.ajax({
                                                url: "<?php echo site_url('SPPB/get_list_fstb_by_id_po') ?>",
                                                type: "POST",
                                                dataType: "JSON",
                                                async: false,
                                                data: {
                                                    ID_PO: ID_PO,
                                                },
                                                success: function (data) {
                                                    var data_4 = data;


                                                    if (data_4 != "TIDAK ADA DATA") {
                                                        NO_URUT_FSTB_CETAK_NEW = "";
                                                        for (l = 0; l < data_4.length; l++) {

                                                            var ID_FSTB = data_4[l].ID_FSTB;
                                                            var HASH_MD5_FSTB = data_4[l].HASH_MD5_FSTB;
                                                            var NO_URUT_FSTB = data_4[l].NO_URUT_FSTB;
                                                            var TANGGAL_DOKUMEN_FSTB = data_4[l].TANGGAL_DOKUMEN_FSTB;
                                                            var STATUS_FSTB = data_4[l].STATUS_FSTB;

                                                            var ID_FSTB = ID_FSTB;
                                                            $.ajax({
                                                                url: "<?php echo site_url('FSTB/data_qty_KHP_form') ?>",
                                                                type: "POST",
                                                                dataType: "JSON",
                                                                async: false,
                                                                data: {
                                                                    ID_FSTB: ID_FSTB,
                                                                },
                                                                success: function (data) {

                                                                    NO_URUT_FSTB_CETAK_NEW += '<div class="social-comment"><div class="media-body"><a href="<?php echo base_url() ?>KHP_form/view/' + HASH_MD5_FSTB + '">FSTB nomor: ' + NO_URUT_FSTB + '</a><small class="text-muted"> <i class="fa fa-dropbox"></i> ' + data[0].JUMLAH_BARANG_FSTB + ' item barang</small><small class="text-muted"> | Tanggal ' + TANGGAL_DOKUMEN_FSTB + ' | Progress: ' + STATUS_FSTB + '</small></div></div>';

                                                                }
                                                            });


                                                        }
                                                    }
                                                }
                                            });

                                            var id = ID_PO;
                                            $.ajax({
                                                url: "<?php echo site_url('PO/data_qty_po_form') ?>",
                                                type: "POST",
                                                dataType: "JSON",
                                                async: false,
                                                data: {
                                                    id: id,
                                                },
                                                success: function (data) {

                                                    NO_URUT_PO_CETAK_NEW += '<div class="social-comment"><div class="media-body"><a href="<?php echo base_url() ?>po_form/view/' + HASH_MD5_PO + '">PO nomor: ' + NO_URUT_PO + '</a><small class="text-muted"> <i class="fa fa-dropbox"></i> ' + data[0].JUMLAH_BARANG_PO + ' item barang</small><small class="text-muted"> | Tanggal ' + TANGGAL_DOKUMEN_PO + ' | Progress: ' + STATUS_PO + '</small></div>' + NO_URUT_FSTB_CETAK_NEW + '</div>';
                                                }
                                            });


                                        }
                                    }

                                }
                            });

                            var id = ID_SPP;
                            $.ajax({
                                url: "<?php echo site_url('SPP/data_qty_spp_form') ?>",
                                type: "POST",
                                dataType: "JSON",
                                async: false,
                                data: {
                                    id: id,
                                },
                                success: function (data) {

                                    NO_URUT_SPP_CETAK_NEW += '<div class="social-comment"><div class="media-body"><a href="<?php echo base_url() ?>spp_form/view/' + HASH_MD5_SPP + '">SPP nomor: ' + NO_URUT_SPP + '</a><small class="text-muted"> <i class="fa fa-dropbox"></i> ' + data[0].JUMLAH_BARANG_SPP + ' item barang</small><small class="text-muted"> | Tanggal ' + TANGGAL_DOKUMEN_SPP + ' | Progress: ' + STATUS_SPP + '</small></div>' + NO_URUT_PO_CETAK_NEW + '</div>';
                                }
                            });
                        }

                    }
                }
            });

            html_new += NO_URUT_SPP_CETAK_NEW;

            $('#show_data_status_new').html(html_new);

        })

        //GET STATUS DARI ID SPPB
        $('#show_data').on('click', '.item_status', function () {
            var ID_SPPB = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('SPPB/data_sppb_by_id_sppb') ?>",
                dataType: "JSON",
                data: {
                    ID_SPPB: ID_SPPB
                },
                success: function (data) {
                    $('#ModalStatus').modal('show');
                    $('[name="ID_SPPB_3"]').val(data[0].ID_SPPB);
                    $('[name="NO_URUT_SPPB_3"]').val(data[0].NO_URUT_SPPB);
                    $('[name="HASH_MD5_SPPB_3"]').val(data[0].HASH_MD5_SPPB);
                    $('[name="TANGGAL_DOKUMEN_SPPB_3"]').val(data[0].TANGGAL_DOKUMEN_SPPB);
                    $('[name="PROGRESS_SPPB_3"]').val(data[0].PROGRESS_SPPB);

                }
            });
            return false;
        });

        //SIMPAN DATA
        $('#btn_simpan').click(function () {
            var FILE_NAME_TEMP = $('#NO_URUT_KHP').val();
            FILE_NAME_TEMP = FILE_NAME_TEMP.replace(/[^a-zA-Z0-9]/g, '_');

            $('[name="FILE_NAME_TEMP"]').val(FILE_NAME_TEMP);

            var TANGGAL_DOKUMEN_KHP = $('#TANGGAL_DOKUMEN_KHP').val(),
            TANGGAL_DOKUMEN_KHP = TANGGAL_DOKUMEN_KHP.split("/").reverse().join("-");

            var form_data = {
                ID_PROYEK: $('#ID_PROYEK').val(),
                ID_SPPB: $('#ID_SPPB').val(),
                SUB_PROYEK: $('#SUB_PROYEK').val(),
                JUMLAH_COUNT_KHP: $('#JUMLAH_COUNT_KHP').val(),
                NO_URUT_KHP: $('#NO_URUT_KHP').val(),
                FILE_NAME_TEMP: $('#FILE_NAME_TEMP').val(),
                TANGGAL_DOKUMEN_KHP: TANGGAL_DOKUMEN_KHP,
                ID_PROYEK_SUB_PEKERJAAN: $('#ID_PROYEK_SUB_PEKERJAAN').val()
            };

            $.ajax({
                url: "<?php echo site_url('KHP/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function (data) {
                    if (data != 1) {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('KHP/get_data_khp_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function (data) {
                                if (data == 'BELUM ADA KHP') {
                                    $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                } else {
                                    window.location.href = '<?php echo base_url(); ?>KHP_form/index/' + data.HASH_MD5_KHP;
                                }

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