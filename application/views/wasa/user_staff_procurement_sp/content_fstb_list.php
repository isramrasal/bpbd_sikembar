<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List FISTB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php/') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/FSTB/') ?>">FISTB</a>
            </li>
            <li class="active">
                <strong>
                    <a>List FISTB</a>
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
        Sistem menampilkan seluruh FISTB yang pada proyek di Kantor Lapangan.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" id="ibox1">
                <div class="ibox-title">
                    <h5>FISTB</h5>
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
                            class="fa fa-plus"></span> Buat FISTB</a>
                    </br>
                    </br>

                    <select class="chosen-select" name="ID_PROYEK_LIST" id="ID_PROYEK_LIST">
                        <option value=''>- Pilih Proyek Untuk Ditampilkan -</option>
                        <?php foreach ($proyek_dropdown_list as $proyek_dropdown_list) {
                            echo '<option value="' . $proyek_dropdown_list->ID_PROYEK . '">' . $proyek_dropdown_list->NAMA_PROYEK . '</option>';
                        } ?>
                    </select>

                    </br>
                    </br>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="data_fstb_list">
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
                <h4 class="modal-title">Identitas Form Inspeksi dan Serah Terima Barang</h4>
                <small class="font-bold">Silakan isi identitas formulir FISTB</small>
            </div>

            <input type="hidden" class="form-control"  name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />
            <input type="hidden" class="form-control"  name="ID_PROYEK" id="ID_PROYEK" disabled />
            <input type="hidden" class="form-control"  name="ID_PROYEK_SUB_PEKERJAAN" id="ID_PROYEK_SUB_PEKERJAAN" disabled />
            <input type="hidden" class="form-control"  name="ID_SPPB" id="ID_SPPB" disabled />
            <input type="hidden" class="form-control"  name="ID_SPP" id="ID_SPP" disabled />
            <input type="hidden" class="form-control"  name="ID_PO" id="ID_PO" disabled />
            <input type="hidden" class="form-control"  name="ID_VENDOR" id="ID_VENDOR" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Sumber Penerimaan*</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="SUMBER_PENERIMAAN" class="form-control" id="SUMBER_PENERIMAAN">
                                <option value=''>- Pilih -</option>
                                <!-- <option value="Pengembalian Dari Site Project">Pengembalian Dari Site Project</option> -->
                                <option value="Pengiriman Dari Vendor">Pengiriman Dari Vendor</option>
                                <!-- <option value="Hasil Perbaikan">Hasil Perbaikan</option> -->
                            </select>

                        </div>
                    </div>

                    <!-- DARI SITE PROJECT 1-->
                    <div id="show_hidden_np_1" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nama Proyek*</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" class="form-control" name="ID_PROYEK_1" id="ID_PROYEK_1">
                            </select>
                        </div>
                    </div>
                    <!-- END DARI SITE PROJECT -->

                    <!-- DARI VENDOR 2-->
                    <div id="show_hidden_np_2" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nama Proyek*</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_PROYEK_2" id="ID_PROYEK_2">
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_po_2" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nomor PO*</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" class="form-control" name="ID_PO_2" id="ID_PO_2">
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_nv_2" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nama Vendor*</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" class="form-control" name="ID_VENDOR_2" id="ID_VENDOR_2">
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_lstb_2" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Lokasi Serah Terima Barang*</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" placeholder="Contoh: Gudang Logistik Kantor Pusat PT. WME" name="LOKASI_PENYERAHAN" id="LOKASI_PENYERAHAN" />
                        </div>
                    </div>

                    <!-- END DARI VENDOR 2 -->

                    <!-- DARI PERBAIKAN 3-->
                    <div id="show_hidden_np_3" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nama Proyek*</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" class="form-control" name="ID_PROYEK_3" id="ID_PROYEK_3">
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_po_3" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nomor PO*</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" class="form-control" name="ID_PO_3" id="ID_PO_3">
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_nv_3" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nama Vendor*</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" class="form-control" name="ID_VENDOR_3" id="ID_VENDOR_3">
                            </select>
                        </div>
                    </div>
                    <!-- END DARI PERBAIKAN 3 -->

                   

                    <!-- POSISI FIX -->
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut FISTB*</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" placeholder="Contoh: 009/WME/FISTB/CC-CRB2/2022 " name="NO_URUT_FSTB" id="NO_URUT_FSTB" />
                        </div>
                    </div>

                    <div class="form-group" id="data_TANGGAL_DOKUMEN_FIB_FSTB">
                        <label class="col-xs-3 control-label">Tanggal Dokumen FISTB */**</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                name="TANGGAL_DOKUMEN_FSTB"  id="TANGGAL_DOKUMEN_FSTB" type="text" class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                    </div>
                    <!-- END POSISI FIX -->

                    <div id="show_hidden_nsj_1" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nomor Surat Jalan*</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" class="form-control" name="ID_SURAT_JALAN_1" id="ID_SURAT_JALAN_1">
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_nsj_vendor_1" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nomor Surat Jalan Vendor*</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NOMOR_SURAT_JALAN_VENDOR_1" id="NOMOR_SURAT_JALAN_VENDOR_1" />
                        </div>
                    </div>

                    <div id="show_hidden_nsj_vendor_2" class="form-group" hidden>
                        <label class="col-xs-3 control-label">Nomor Surat Jalan Vendor*</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NOMOR_SURAT_JALAN_VENDOR_2" id="NOMOR_SURAT_JALAN_VENDOR_2" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama Pengirim*</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NAMA_PENGIRIM" id="NAMA_PENGIRIM" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">No HP Pengirim</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NO_HP_PENGIRIM" id="NO_HP_PENGIRIM" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Pegawai Penerima Barang*</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NAMA_PEGAWAI" id="NAMA_PEGAWAI" />
                        </div>
                    </div>

                    <div class="form-group" id="data_TANGGAL_BARANG_DATANG">
                        <label class="col-xs-3 control-label">Tanggal Barang Datang*</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                name="TANGGAL_BARANG_DATANG_HARI"  id="TANGGAL_BARANG_DATANG_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                            *wajib diisi
                            </br>
                            **Sistem juga menyimpan tanggal aktual pembuatan FSTB/FIB ini by system
                            </br>
                            </br>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses identitas form FISTB ini dan menyetujui untuk proses pengisian item barang/jasa </label></div>
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" name="btn_simpan" id="btn_simpan" disabled><i class="fa fa-save"></i> Buat FSTB</button>
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

        $('#data_TANGGAL_DOKUMEN_FIB_FSTB .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#data_TANGGAL_BARANG_DATANG .input-group.date').datepicker({
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

        $('#data_fstb_list').dataTable({
            aaSorting: [],
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                extend: 'print',
                customize: function (win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');
                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }]
        });

        //EVENT DROPDOWN PROYEK LIST BERUBAH
        $("#ID_PROYEK_LIST").change(function () {

            var form_data = {
                ID_PROYEK: $('#ID_PROYEK_LIST').val()
            }

            var ID_PROYEK = $('#ID_PROYEK_LIST').val();
            var NAMA_PROYEK = $('#ID_PROYEK_LIST option:selected').text();
            var today = new Date().toISOString().slice(0, 10)
            var JUDUL = "List FISTB " + NAMA_PROYEK + ' ' + today ;

            if (ID_PROYEK == "Semua") {
                $('#data_fstb_list').dataTable().fnClearTable();
                $("#data_fstb_list").dataTable().fnDestroy();

                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                
                $.ajax({
                    url: "<?php echo base_url(); ?>/FSTB/list_FSTB_by_all_proyek",
                    method: "POST",
                    data: form_data,
                    async: true,
                    dataType: 'JSON',
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

                                //KOLOM FSTB
                                html += '<td>';
                                FSTB = '<a href="<?php echo base_url() ?>FSTB_form/view/' + data_1[i].HASH_MD5_FSTB + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_1[i].NO_URUT_FSTB + ' </a>';
                                html += FSTB + "</br>";
                                html += '</td>';

                                // KOLOM PROYEK
                                html += '<td>';
                                FSTB = '<a href="#" class="btn btn-link btn-xs text-decoration-none">' + data_1[i].NAMA_PROYEK + ' </a>';
                                html += FSTB + "</br>";
                                html += '</td>';

                                // KOLOM PEKERJAAN
                                html += '<td>';
                                FSTB = '<a href="#" class="btn btn-link btn-xs text-decoration-none">' + data_1[i].NAMA_SUB_PEKERJAAN + ' </a>';
                                html += FSTB + "</br>";
                                html += '</td>';


                                //KOLOM TANGGAL DOKUMEN
                                html += '<td>';
                                FSTB = '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_1[i].TANGGAL_DOKUMEN_FSTB + ' </a>';
                                html += FSTB + "</br>";
                                html += '</td>';

                                //KOLOM STATUS
                                html += '<td>';
                                FSTB = '<a href="javascript:;" class="btn btn-primary btn-xs item_status block" data="' + data_1[i].ID_SPPB + '"><i class="fa fa-search"></i> '+ data_1[i].STATUS_FSTB + '</a>';
                                html += FSTB;
                                html += '</td>';

                                html += '</tr>' ;
                            }

                        }

                        else
                        {
                            html = '';
                        }

                        html_head = '<tr><th>No. FISTB</th><th>Proyek</th><th>Pekerjaan</th><th>Tanggal Dokumen FISTB</th><th>Status FISTB</th></tr>';
                        $('#show_data_head').html(html_head);
                        $('#show_data').html(html);

                        
                        $('#data_fstb_list').dataTable({
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
                        // $("#data_fstb_list").dataTable().fnDestroy();

                    }
                });

                setTimeout(function(){
                    $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                }, 1000); 

            }
            else {

                $('#data_fstb_list').dataTable().fnClearTable();
                $("#data_fstb_list").dataTable().fnDestroy();

                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');

                $.ajax({
                    url: "<?php echo base_url(); ?>/FSTB/list_FSTB_by_id_proyek",
                    method: "POST",
                    data: form_data,
                    async: true,
                    dataType: 'JSON',
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

                                //KOLOM FSTB
                                html += '<td>';
                                FSTB = '<a href="<?php echo base_url() ?>FSTB_form/view/' + data_1[i].HASH_MD5_FSTB + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_1[i].NO_URUT_FSTB + ' </a>';
                                html += FSTB + "</br>";
                                html += '</td>';
                                

                                // KOLOM PEKERJAAN
                                html += '<td>';
                                FSTB = '<a href="#" class="btn btn-link btn-xs text-decoration-none">' + data_1[i].NAMA_SUB_PEKERJAAN + ' </a>';
                                html += FSTB + "</br>";
                                html += '</td>';
                                
                                
                                //KOLOM TANGGAL DOKUMEN
                                html += '<td>';
                                FSTB = '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_1[i].TANGGAL_DOKUMEN_FSTB + ' </a>';
                                html += FSTB + "</br>";
                                html += '</td>';

                                //KOLOM STATUS
                                html += '<td>';
                                FSTB = '<a href="javascript:;" class="btn btn-primary btn-xs item_status block" data="' + data_1[i].ID_SPPB + '"><i class="fa fa-search"></i> '+ data_1[i].STATUS_FSTB + '</a>';
                                html += FSTB;
                                html += '</td>';
                                
                                html += '</tr>' ;
                                
                            }
                        }

                        else
                        {
                            html = '';
                        }

                        html_head = '<tr><th>No. FSTB</th><th>Pekerjaan</th><th>Tanggal Dokumen FSTB</th><th>Status FSTB</th></tr>';
                        $('#show_data_head').html(html_head);
                        $('#show_data').html(html);

                        
                        $('#data_fstb_list').dataTable({
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
                        // $("#data_fstb_list").dataTable().fnDestroy();

                    }
                });

                setTimeout(function(){
                    $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                }, 1000); 
            }
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
                                                                url: "<?php echo site_url('FSTB/data_qty_fstb_form') ?>",
                                                                type: "POST",
                                                                dataType: "JSON",
                                                                async: false,
                                                                data: {
                                                                    ID_FSTB: ID_FSTB,
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
        $('#btn_simpan').click(function() {
            var FILE_NAME_TEMP = $('#NO_URUT_FSTB').val();
            FILE_NAME_TEMP = FILE_NAME_TEMP.replace(/[^a-zA-Z0-9]/g, '_');

            var TANGGAL_DOKUMEN_FSTB = $('#TANGGAL_DOKUMEN_FSTB').val(),
                TANGGAL_DOKUMEN_FSTB = TANGGAL_DOKUMEN_FSTB.split("/").reverse().join("-");

            var TANGGAL_BARANG_DATANG_HARI = $('#TANGGAL_BARANG_DATANG_HARI').val(),
            TANGGAL_BARANG_DATANG_HARI = TANGGAL_BARANG_DATANG_HARI.split("/").reverse().join("-");

            var form_data = {
                
                ID_PROYEK: $('#ID_PROYEK').val(),
                ID_PROYEK_SUB_PEKERJAAN: $('#ID_PROYEK_SUB_PEKERJAAN').val(),
                ID_SPPB: $('#ID_SPPB').val(),
                ID_SPP: $('#ID_SPP').val(),
                ID_PO: $('#ID_PO').val(),
                ID_VENDOR: $('#ID_VENDOR').val(),
                TANGGAL_DOKUMEN_FSTB: TANGGAL_DOKUMEN_FSTB,
                JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
                NO_URUT_FSTB: $('#NO_URUT_FSTB').val(),
                FILE_NAME_TEMP: FILE_NAME_TEMP,
                ID_SURAT_JALAN_1: $('#ID_SURAT_JALAN_1').val(),
                NOMOR_SURAT_JALAN_VENDOR_1: $('#NOMOR_SURAT_JALAN_VENDOR_1').val(),
                NOMOR_SURAT_JALAN_VENDOR_2: $('#NOMOR_SURAT_JALAN_VENDOR_2').val(),
                LOKASI_PENYERAHAN: $('#LOKASI_PENYERAHAN').val(),
                NAMA_PENGIRIM: $('#NAMA_PENGIRIM').val(),
                NO_HP_PENGIRIM: $('#NO_HP_PENGIRIM').val(),
                NAMA_PEGAWAI: $('#NAMA_PEGAWAI').val(),
                TANGGAL_BARANG_DATANG_HARI: TANGGAL_BARANG_DATANG_HARI,
                SUMBER_PENERIMAAN: $('#SUMBER_PENERIMAAN').val()
            };

            $.ajax({
                url: "<?php echo site_url('FSTB/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data == '1') {
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo base_url('FSTB/get_data_fstb_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                if (data == 'BELUM ADA FSTB') {
                                    $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                } else {
                                    window.location.href = '<?php echo base_url(); ?>FSTB_form/index/' + data.HASH_MD5_FSTB;
                                }
                            }
                        });
                    } else {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });

            return false;
        });

        //EVENT DROPDOWN SUMBER PENERIMAAN
        $("#SUMBER_PENERIMAAN").change(function() {
            if ($("#SUMBER_PENERIMAAN option:selected").text() == 'Pengembalian Dari Site Project') {
                $('#show_hidden_np_1').attr("hidden", false);

                $('#show_hidden_np_2').attr("hidden", true);
                $('#show_hidden_po_2').attr("hidden", true);
                $('#show_hidden_lstb_2').attr("hidden", true);
                $('#show_hidden_nv_2').attr("hidden", true);
                $('#show_hidden_nsj_vendor_1').attr("hidden", true);
                $('#NOMOR_SURAT_JALAN_VENDOR_1').val("");
                
                $('#show_hidden_np_3').attr("hidden", true);
                $('#show_hidden_po_3').attr("hidden", true);
                $('#show_hidden_nv_3').attr("hidden", true);
                $('#show_hidden_nsj_vendor_2').attr("hidden", true);
                $('#NOMOR_SURAT_JALAN_VENDOR_2').val("");
                // Menggunakan ajax untuk mengirim dan dan menerima data dari server
                $.ajax({
                    url: "<?php echo base_url(); ?>/FSTB/get_data_proyek",
                    method: "POST",
                    async: false,
                    dataType: 'JSON',
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
            } else if ($("#SUMBER_PENERIMAAN option:selected").text() == 'Pengiriman Dari Vendor') {
                $('#show_hidden_np_1').attr("hidden", true);
                $('#show_hidden_nsj_1').attr("hidden", true);

                $('#show_hidden_np_2').attr("hidden", false);

                $('#show_hidden_np_3').attr("hidden", true);
                $('#show_hidden_po_3').attr("hidden", true);
                $('#show_hidden_nv_3').attr("hidden", true);
                $('#show_hidden_nsj_vendor_2').attr("hidden", true);
                $('#NOMOR_SURAT_JALAN_VENDOR_2').val("");
                // Menggunakan ajax untuk mengirim dan dan menerima data dari server

                $("#ID_PROYEK_2").empty();
                $.ajax({
                    url: "<?php echo base_url(); ?>/FSTB/get_data_proyek_sp",
                    method: "POST",
                    async: false,
                    dataType: 'JSON',
                    success: function(data) {
                        var html = '';
                        var i;

                        $("#ID_PROYEK_2").chosen();
                        $('#ID_PROYEK_2').empty();

                        html = "<option value=''>- Pilih Proyek -</option>";
                        $('#ID_PROYEK_2').html(html);

                        for (i = 0; i < data.length; i++) {
                            // html += '<option value=' + data[i].ID_PROYEK + '>' + data[i].NAMA_PROYEK + '</option>';
                            $("#ID_PROYEK_2").append('<option value="' + data[i].ID_PROYEK  + '">' + data[i].NAMA_PROYEK + '</option>');
                        }
                        
                        $("#ID_PROYEK_2").trigger("liszt:updated");

                        $("#ID_PROYEK_2").chosen();

                        $("#ID_PROYEK_2").trigger("chosen:updated");
                    }
                });
            } else if ($("#SUMBER_PENERIMAAN option:selected").text() == 'Hasil Perbaikan') {
                $('#show_hidden_np_1').attr("hidden", true);
                $('#show_hidden_nsj_1').attr("hidden", true);

                $('#show_hidden_np_2').attr("hidden", true);
                $('#show_hidden_po_2').attr("hidden", true);
                $('#show_hidden_lstb_2').attr("hidden", true);
                $('#show_hidden_nv_2').attr("hidden", true);
                $('#show_hidden_nsj_vendor_1').attr("hidden", true);
                $('#NOMOR_SURAT_JALAN_VENDOR_1').val("");

                $('#show_hidden_np_3').attr("hidden", false);
                // Menggunakan ajax untuk mengirim dan dan menerima data dari server
                $.ajax({
                    url: "<?php echo base_url(); ?>/FSTB/get_data_proyek",
                    method: "POST",
                    async: false,
                    dataType: 'JSON',
                    success: function(data) {
                        var html = '';
                        var i;

                        html = "<option value=''>- Pilih Proyek -</option>";

                        for (i = 0; i < data.length; i++) {
                            html += '<option value=' + data[i].ID_PROYEK + '>' + data[i].NAMA_PROYEK + '</option>';
                        }
                        $('#ID_PROYEK_3').html(html);
                    }
                });
            } else {
                $('#show_hidden_np_1').attr("hidden", true);
                $('#show_hidden_nsj_1').attr("hidden", true);

                $('#show_hidden_np_2').attr("hidden", true);
                $('#show_hidden_po_2').attr("hidden", true);
                $('#show_hidden_lstb_2').attr("hidden", true);
                $('#show_hidden_nv_2').attr("hidden", true);
                $('#show_hidden_nsj_vendor_1').attr("hidden", true);
                $('#NOMOR_SURAT_JALAN_VENDOR_1').val("");

                $('#show_hidden_np_3').attr("hidden", true);
                $('#show_hidden_po_3').attr("hidden", true);
                $('#show_hidden_nv_3').attr("hidden", true);
                $('#show_hidden_nsj_vendor_2').attr("hidden", true);
                $('#NOMOR_SURAT_JALAN_VENDOR_2').val("");
            }
        });

        //EVENT DROPDOWN ID PROYEK 1
        $("#ID_PROYEK_1").change(function() {
            if ($("#ID_PROYEK_1 option:selected").text() == '- Pilih Proyek -') {
                $('#show_hidden_nsj_1').attr("hidden", true);
            } else {
                $('#show_hidden_nsj_1').attr("hidden", false);
                var ID_PROYEK = $('#ID_PROYEK_1').val();
                $.ajax({
                    url: "<?php echo base_url(); ?>/FSTB/get_data_surat_jalan",
                    method: "POST",
                    data: {
                        ID_PROYEK: ID_PROYEK
                    },
                    async: false,
                    dataType: 'JSON',
                    success: function(data) {
                        var html = '';
                        var i;

                        html = "<option value=''>- Pilih Surat Jalan -</option>";

                        for (i = 0; i < data.length; i++) {
                            html += '<option value=' + data[i].ID_SURAT_JALAN + '>' + data[i].NO_SURAT_JALAN + '</option>';
                        }
                        $('#ID_SURAT_JALAN_1').html(html);
                    }
                });
            }
        });

        //EVENT DROPDOWN ID PROYEK 2
        $("#ID_PROYEK_2").change(function() {
            if ($("#ID_PROYEK_2 option:selected").text() == '- Pilih Proyek -') {
                $('[name="ID_PROYEK"]').val("");
                $('#show_hidden_po_2').attr("hidden", true);
                $('[name="ID_VENDOR_2"]').val("");
                
            } else {
                $('#show_hidden_po_2').attr("hidden", false);
                $('#show_hidden_lstb_2').attr("hidden", false);
                var ID_PROYEK = $('#ID_PROYEK_2').val();
                $('[name="ID_PROYEK"]').val(ID_PROYEK);
                $.ajax({
                    url: "<?php echo base_url(); ?>/FSTB/get_data_po",
                    method: "POST",
                    data: {
                        ID_PROYEK: ID_PROYEK
                    },
                    async: false,
                    dataType: 'JSON',
                    success: function(data) {
 
                        var html = '';
                        var i;

                        $("#ID_PO_2").chosen();
                        $('#ID_PO_2').empty();

                        // html = "<option value=''>- Pilih Nomor PO -</option>";
                        // $('#ID_PO_2').html(html);

                        $("#ID_PO_2").append('<option value="">- Pilih Nomor PO -</option>');

                        for (i = 0; i < data.length; i++) {
                            $("#ID_PO_2").append('<option value="' + data[i].ID_PO  + '">' + data[i].NO_URUT_PO + '</option>');
                        }
                        
                        $("#ID_PO_2").trigger("liszt:updated");

                        $("#ID_PO_2").chosen();

                        $("#ID_PO_2").trigger("chosen:updated");
                    }
                });
            }
        });

        //EVENT DROPDOWN ID PO 2
        $("#ID_PO_2").change(function() {
            if ($("#ID_PO_2 option:selected").text() == '- Pilih Nomor PO -') {
                $('#show_hidden_nv_2').attr("hidden", true);
                $('#show_hidden_nsj_vendor_1').attr("hidden", true);
                $('#show_hidden_lstb_2').attr("hidden", true);
                $('[name="LOKASI_PENYERAHAN"]').val("");
            } else {
                $('#show_hidden_nv_2').attr("hidden", false);
                $('#show_hidden_nsj_vendor_1').attr("hidden", false);
                var ID_PO = $('#ID_PO_2').val();
                $.ajax({
                    url: "<?php echo base_url(); ?>/FSTB/get_data_vendor",
                    method: "POST",
                    data: {
                        ID_PO: ID_PO
                    },
                    async: false,
                    dataType: 'JSON',
                    success: function(data) {

                        var html = '';
                        var i;

                        $("#ID_VENDOR_2").chosen();
                        $('#ID_VENDOR_2').empty();

                        html = "<option value=''>- Pilih Nama Vendor -</option>";
                        $('#ID_VENDOR_2').html(html);

                        for (i = 0; i < data.length; i++) {
                            $("#ID_VENDOR_2").append('<option selected="selected" value="' + data[i].ID_VENDOR  + '">' + data[i].NAMA_VENDOR + ' </option>');

                            $('[name="ID_PROYEK_SUB_PEKERJAAN"]').val(data[0].ID_PROYEK_SUB_PEKERJAAN);
                            $('[name="ID_SPPB"]').val(data[0].ID_SPPB);
                            $('[name="ID_SPP"]').val(data[0].ID_SPP);
                            $('[name="ID_PO"]').val(data[0].ID_PO);
                            $('[name="ID_VENDOR"]').val(data[0].ID_VENDOR);
                            $('[name="LOKASI_PENYERAHAN"]').val(data[0].LOKASI_PENYERAHAN);
                        }

                        $("#ID_VENDOR_2").trigger("liszt:updated");

                        $("#ID_VENDOR_2").chosen();

                        $("#ID_VENDOR_2").trigger("chosen:updated");

                    }
                });
            }
        });

        //EVENT DROPDOWN ID PROYEK 3
        $("#ID_PROYEK_3").change(function() {
            if ($("#ID_PROYEK_3 option:selected").text() == '- Pilih Proyek -') {
                $('#show_hidden_po_3').attr("hidden", true);
                $('#show_hidden_nsj_vendor_2').attr("hidden", true);
            } else {
                $('#show_hidden_po_3').attr("hidden", false);
                $('#show_hidden_nsj_vendor_2').attr("hidden", false);
                var ID_PROYEK = $('#ID_PROYEK_3').val();
                $.ajax({
                    url: "<?php echo base_url(); ?>/FSTB/get_data_po",
                    method: "POST",
                    data: {
                        ID_PROYEK: ID_PROYEK
                    },
                    async: false,
                    dataType: 'JSON',
                    success: function(data) {
                        var html = '';
                        var i;

                        html = "<option value=''>- Pilih Nomor PO -</option>";

                        for (i = 0; i < data.length; i++) {
                            html += '<option value=' + data[i].ID_PO + '>' + data[i].NO_URUT_PO + '</option>';
                        }
                        $('#ID_PO_3').html(html);
                    }
                });
            }
        });

        //EVENT DROPDOWN ID PO 2
        $("#ID_PO_3").change(function() {
            if ($("#ID_PO_3 option:selected").text() == '- Pilih Nomor PO -') {
                $('#show_hidden_nv_3').attr("hidden", true);
                $('#show_hidden_nsj_vendor_2').attr("hidden", true);
            } else {
                $('#show_hidden_nv_3').attr("hidden", false);
                $('#show_hidden_nsj_vendor_2').attr("hidden", false);
                var ID_PO = $('#ID_PO_3').val();
                $.ajax({
                    url: "<?php echo base_url(); ?>/FSTB/get_data_vendor",
                    method: "POST",
                    data: {
                        ID_PO: ID_PO
                    },
                    async: false,
                    dataType: 'JSON',
                    success: function(data) {
                        var html = '';
                        var i;

                        html = "<option value=''>- Pilih Nama Vendor -</option>";

                        for (i = 0; i < data.length; i++) {
                            html += '<option value=' + data[i].ID_VENDOR + '>' + data[i].NAMA_VENDOR + '</option>';
                        }
                        $('#ID_VENDOR_3').html(html);
                    }
                });
            }
        });
    });
</script>

</body>

</html>