<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List SPPB Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPPB/') ?>">SPPB Pembelian</a>
            </li>
            <li class="active">
                <strong>
                    <a>List SPPB Pembelian</a>
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
        Sistem menampilkan seluruh SPPB Pembelian.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" id="ibox1">
                <div class="ibox-title">
                    <h5>SPPB Pembelian</h5>
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
                    
                    <a href="#" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Buat SPPB Pembelian</a>
                    </br>
                    </br>

                    <select class="chosen-select" name="ID_PROYEK_LIST" class="form-control" id="ID_PROYEK_LIST">
                        <option value=''>- Pilih Proyek Untuk Ditampilkan -</option>
                        <option value='Semua'>Semua Proyek</option>
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

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 70vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Buat SPPB Pembelian</h4>
                <small class="font-bold">Silakan isi identitas formulir SPPB</small>
            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB/simpan_data_sppb_pembelian", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />
            <input type="hidden" class="form-control" value="" name="INISIAL" id="INISIAL" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($USER_ID); ?>" name="USER_ID" id="USER_ID" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($ID_JABATAN_PEGAWAI); ?>" name="ID_JABATAN_PEGAWAI" id="ID_JABATAN_PEGAWAI" disabled />
            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Proyek *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_PROYEK" class="form-control" id="ID_PROYEK">
                                <option value=''>- Pilih Proyek -</option>
                                <?php foreach ($proyek_dropdown as $proyek_dropdown) {
                                    echo '<option value="' . $proyek_dropdown->ID_PROYEK.'">' . $proyek_dropdown->NAMA_PROYEK . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Pekerjaan *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_PROYEK_SUB_PEKERJAAN" class="form-control" id="ID_PROYEK_SUB_PEKERJAAN">
                                <option value=''>- Pilih Pekerjaan -</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut SPPB *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_SPPB" id="NO_URUT_SPPB"
                                placeholder="Contoh: 003/WME/SPPB/CC-CRB2/Main-Work/2022" />
                        </div>
                    </div>

                    <div class="form-group" id="data_TANGGAL_DOKUMEN_SPPB">
                        <label class="col-xs-3 control-label">Tanggal Dokumen SPPB */**</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_SPPB" type="text" class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                            </br>
                            *wajib diisi
                            </br>
                            **Sistem juga menyimpan tanggal aktual pembuatan SPPB ini by system
                        </div>
                    </div>


                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Buat SPPB Pembelian</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD-->
</br>

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
    $(document).ready(function () {
        $('.chosen-select').chosen({width: "100%"});

        var today = new Date().toISOString().substr(0, 10);

        $('#data_TANGGAL_DOKUMEN_SPPB .input-group.date').datepicker({
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
            var JUDUL = "List SPPB " + NAMA_PROYEK;

            if (ID_PROYEK == "Semua") {
                $("#mydata").dataTable().fnDestroy();
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                
                $.ajax({
                    url: "<?php echo base_url(); ?>/SPPB/list_sppb_by_all_proyek",
                    method: "POST",
                    data: form_data,
                    async: false,
                    dataType: 'json',
                    success: function (data) {

                        

                        var html, html_head = '';
                        var i, j, k;

                        $('#show_data_head').html(html_head);
                        $('#show_data').html(html);

                        if (data.length > 0)
                        {
                            for (i = 0; i < data.length; i++) {

                                html += '<tr>' +
                                    '<td>' + '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-default btn-xs btn-outline"><i class="fa fa-eye"></i> ' + data[i].NO_URUT_SPPB + '</a>' + '</td>' +
                                    '<td>' + data[i].NAMA_PROYEK + '</td>' +
                                    '<td>' + data[i].NAMA_SUB_PEKERJAAN + '</td>' +
                                    '<td>' + data[i].TANGGAL_DOKUMEN_SPPB + '</td>' +
                                    '<td>' + '<a href="javascript:;" class="btn btn-primary btn-xs item_status block" data="' + data[i].ID_SPPB + '"><i class="fa fa-search"></i>'+ data[i].STATUS_SPPB + '</a>' + '</td>' +
                                    '</tr>';
                            }
                        }

                        else
                        {
                            html = '';
                        }

                        

                        html_head = '<tr><th>No. SPPB</th><th>Proyek</th><th>Pekerjaan</th><th>Tanggal Dokumen SPPB</th><th>Status SPPB</th></tr>';
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
                $("#mydata").dataTable().fnDestroy();
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');

                $.ajax({
                    url: "<?php echo base_url(); ?>/SPPB/list_sppb_by_id_proyek",
                    method: "POST",
                    data: form_data,
                    async: false,
                    dataType: 'json',
                    success: function (data) {

                        var html, html_head = '';
                        var i, j, k;

                        $('#show_data_head').html(html_head);
                        $('#show_data').html(html);

                        if (data.length > 0)
                        {
                            for (i = 0; i < data.length; i++) {

                                html += '<tr>' +
                                    '<td>' + '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-default btn-xs btn-outline"><i class="fa fa-eye"></i> ' + data[i].NO_URUT_SPPB + '</a>' + '</td>' +
                                    '<td>' + data[i].NAMA_SUB_PEKERJAAN + '</td>' +
                                    '<td>' + data[i].TANGGAL_DOKUMEN_SPPB + '</td>' +
                                    '<td>' + '<a href="javascript:;" class="btn btn-primary btn-xs item_status block" data="' + data[i].ID_SPPB + '"><i class="fa fa-search"></i> '+ data[i].STATUS_SPPB + '</a>' + '</td>' +
                                    '</tr>';
                            }
                        }

                        else
                        {
                            html = '';
                        }
                        

                        html_head = '<tr><th>No. SPPB</th><th>Pekerjaan</th><th>Tanggal Dokumen SPPB</th><th>Status SPPB</th></tr>';
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
        });

        $("#ID_PROYEK").change(function () {

            var ID_PROYEK = $('[name="ID_PROYEK"]').val();

            var form_data = {
                ID_PROYEK: ID_PROYEK,
            }

            $.ajax({
                url: "<?php echo base_url(); ?>/SPPB/data_sub_pekerjaan_by_id_proyek",
                method: "POST",
                data: form_data,
                async: false,
                dataType: 'json',
                success: function (data) {

                    var html = '';
                    var i;

                    $("#ID_PROYEK_SUB_PEKERJAAN").chosen();
                    $('#ID_PROYEK_SUB_PEKERJAAN').empty();

                    for (i = 0; i < data.length; i++) {
                        $("#ID_PROYEK_SUB_PEKERJAAN").append('<option selected="selected" value="' + data[i].ID_PROYEK_SUB_PEKERJAAN  + '">' + data[i].NAMA_SUB_PEKERJAAN + ' </option>');
                    }

                    $("#ID_PROYEK_SUB_PEKERJAAN").trigger("liszt:updated");
                    $("#ID_PROYEK_SUB_PEKERJAAN").chosen();
                    $("#ID_PROYEK_SUB_PEKERJAAN").trigger("chosen:updated");

                }
            });

        });


        $('#ModalStatus').on('shown.bs.modal', function () {

            var ID_SPPB = $("#ID_SPPB_3").val();
            var NO_URUT_SPPB = $("#NO_URUT_SPPB_3").val();
            var HASH_MD5_SPPB = $("#HASH_MD5_SPPB_3").val();
            var TANGGAL_DOKUMEN_SPPB = $("#TANGGAL_DOKUMEN_SPPB_3").val();
            var PROGRESS_SPPB = $("#PROGRESS_SPPB_3").val();
            var html, html_new = "";
            var NO_URUT_SPPB_CETAK = NO_URUT_SPPB;
            var NO_URUT_SPP_CETAK, NO_URUT_SPP_CETAK_NEW = "";
            var NO_URUT_PO_CETAK, NO_URUT_PO_CETAK_NEW = "";
            var NO_URUT_FSTB_CETAK, NO_URUT_FSTB_CETAK_NEW = "";

            // html += '<tr>';
            // html += '<td>' + '<a href="<?php echo base_url() ?>sppb_form/view/' + HASH_MD5_SPPB + '" class="btn btn-xs block"><i class="fa fa-eye"></i> ' + NO_URUT_SPPB_CETAK + " " + '</a>' + '</td>';

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
                                                    console.log(data);
                                                    var data_4 = data;


                                                    if (data_4 != "TIDAK ADA DATA") {
                                                        NO_URUT_FSTB_CETAK_NEW = "";
                                                        for (l = 0; l < data_4.length; l++) {

                                                            var ID_FSTB = data_4[l].ID_FSTB;
                                                            var HASH_MD5_FSTB = data_4[l].HASH_MD5_FSTB;
                                                            var NO_URUT_FSTB = data_4[l].NO_URUT_FSTB;
                                                            var TANGGAL_DOKUMEN_FSTB = data_4[l].TANGGAL_DOKUMEN_FSTB;
                                                            var STATUS_FSTB = data_4[l].STATUS_FSTB;

                                                            var id = ID_FSTB;
                                                            $.ajax({
                                                                url: "<?php echo site_url('FSTB/data_qty_fstb_form') ?>",
                                                                type: "POST",
                                                                dataType: "JSON",
                                                                async: false,
                                                                data: {
                                                                    id: id,
                                                                },
                                                                success: function (data) {

                                                                    NO_URUT_FSTB_CETAK_NEW += '<div class="social-comment"><div class="media-body"><a href="<?php echo base_url() ?>fstb_form/view/' + HASH_MD5_FSTB + '">FSTB nomor: ' + NO_URUT_FSTB + '</a><small class="text-muted"> <i class="fa fa-dropbox"></i> ' + data[0].JUMLAH_BARANG_FSTB + ' item barang</small><small class="text-muted"> | Tanggal ' + TANGGAL_DOKUMEN_FSTB + ' | Progress: ' + STATUS_FSTB + '</small></div></div>';

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

        //GET STATUS
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

            var FILE_NAME_TEMP = $('#NO_URUT_SPPB').val();
            FILE_NAME_TEMP = FILE_NAME_TEMP.replace(/[^a-zA-Z0-9]/g, '_');

            var TANGGAL_DOKUMEN_SPPB = $('#TANGGAL_DOKUMEN_SPPB').val(),
            TANGGAL_DOKUMEN_SPPB = TANGGAL_DOKUMEN_SPPB.split("/").reverse().join("-");

            var form_data = {
                ID_PROYEK: $('#ID_PROYEK').val(),
                ID_PROYEK_SUB_PEKERJAAN: $('#ID_PROYEK_SUB_PEKERJAAN').val(),
                TANGGAL_DOKUMEN_SPPB: TANGGAL_DOKUMEN_SPPB,
                JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
                NO_URUT_SPPB: $('#NO_URUT_SPPB').val(),
                USER_ID: $('#USER_ID').val(),
                FILE_NAME_TEMP: FILE_NAME_TEMP
            };

            $.ajax({
                url: "<?php echo site_url('SPPB/simpan_data_sppb_pembelian'); ?>",
                type: 'POST',
                data: form_data,
                success: function (data) {
                    if (data != '') {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('SPPB/get_data_sppb_pembelian_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function (data) {
                                $.each(data, function () {
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