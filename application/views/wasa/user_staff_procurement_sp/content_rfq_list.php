<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List RFQ</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/RFQ/') ?>">RFQ</a>
            </li>
            <li class="active">
                <strong>
                    <a>List RFQ</a>
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
        Sistem menampilkan RFQ yang telah dibuat.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>RFQ</h5>
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
                <h4 class="modal-title">Buat RFQ</h4>
                <small class="font-bold">Silakan isi identitas formulir RFQ</small>


            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("FPB/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT_RFQ" id="JUMLAH_COUNT_RFQ" disabled />
            <input type="hidden" class="form-control" value="" name="ID_PROYEK" id="ID_PROYEK" disabled />
            <input type="hidden" class="form-control" value="" name="INISIAL" id="INISIAL" disabled />
            <input type="hidden" class="form-control" value="" name="ID_PROYEK_SUB_PEKERJAAN" id="ID_PROYEK_SUB_PEKERJAAN" disabled />


            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-xs-3 control-label">No. Urut SPPB</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_SPPB" id="NO_URUT_SPPB" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Proyek</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NAMA_PROYEK" id="NAMA_PROYEK" disabled />
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
                        <label class="col-xs-3 control-label">Nomor Urut RFQ*</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" placeholder="Contoh: 009/WME/RFQ/CC-CRB2/2022 " name="NO_URUT_RFQ" id="NO_URUT_RFQ" />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
                            <input type="hidden" class="form-control" value="" name="ID_SPPB" id="ID_SPPB" disabled />
                        </div>
                    </div>

                    <div class="form-group" id="data_TANGGAL_DOKUMEN_RFQ">
                        <label class="col-xs-3 control-label">Tanggal Dokumen RFQ */**</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_RFQ" type="text" class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                            </br>
                            *wajib diisi
                            </br>
                            **Sistem juga menyimpan tanggal aktual pembuatan RFQ ini by system
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses identitas form RFQ ini dan menyetujui untuk proses pengisian item barang/jasa </label></div>
                        </div>
                    </div>

                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" name="btn_simpan" id="btn_simpan" disabled><i class="fa fa-save"></i> Buat RFQ</button>
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

        $('#data_TANGGAL_DOKUMEN_RFQ .input-group.date').datepicker({
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

        // tampil_data_RFQ(); //pemanggilan fungsi tampil data.
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
                title: 'RFQ'
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
            
            $.ajax({
                url: "<?php echo base_url(); ?>/RFQ/data_RFQ",
                method: "POST",
                data: form_data,
                async: false,
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

                            $.ajax({
                                url: "<?php echo site_url('RFQ/get_list_rfq_by_id_sppb') ?>",
                                type: "POST",
                                dataType: "JSON",
                                async: false,
                                data: {
                                    ID_SPPB: data_1[i].ID_SPPB,
                                },
                                success: function (data) {
                                    var data_2 = data;
                                    var RFQ = '';

                                    if (data_2 == 'TIDAK ADA DATA') {
                                        html += '<tr style="background-color:#DAF7A6">' ;

                                    } else {
                                        html += '<tr>' ;
                                    }

                                    html += '<td>' + '<a href="<?php echo base_url() ?>SPPB_form/view/' + data_1[i].HASH_MD5_SPPB + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_1[i].NO_URUT_SPPB + ' </a>';
                                    html += '</br><a href="javascript:;" class="btn btn-success btn-xs item_buat_rfq_baru" data="' + data_1[i].HASH_MD5_SPPB + '"><i class="fa fa-plus"></i> Buat RFQ </a>' + ' ' +
                                        '</td>';

                                    html +=
                                    '<td>';
                                    if (data_2 == 'TIDAK ADA DATA') {
                                        var RFQ = '';

                                    } else {
                                        for (j = 0; j < data_2.length; j++) {
                                            RFQ = '<a href="<?php echo base_url() ?>RFQ_form/view/' + data_2[j].HASH_MD5_RFQ + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_2[j].NO_URUT_RFQ + ' </a>';
                                            html += RFQ + "</br>";
                                        }
                                    }
                                    html +=
                                    '</td>';

                                    html += '<td>' + '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_1[i].NAMA_PROYEK + ' </a>' + '</td>';

                                    html +=
                                    '<td>';
                                    if (data_2 == 'TIDAK ADA DATA') {
                                        var RFQ = '';

                                    } else {
                                        for (j = 0; j < data_2.length; j++) {
                                            var TANGGAL = '';
                                            TANGGAL = '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_2[j].TANGGAL_DOKUMEN_RFQ + ' </a>';
                                            html += TANGGAL + "</br>";
                                        }

                                    }
                                    html +=
                                    '</td>';

                                    html +=
                                    '<td>';
                                    if (data_2 == 'TIDAK ADA DATA') {
                                        var RFQ = '';

                                    } else {
                                        for (j = 0; j < data_2.length; j++) {
                                            var STATUS = '';
                                            STATUS = '<a href="javascript:;" class="btn btn-info btn-xs item_status block" data="' + data_2[j].ID_RFQ + '"><i class="fa fa-search"></i> Lihat Status</a>';
                                            html += STATUS ;
                                        }
                                    }
                                    html +=
                                    '</td>';

                                    html += '</tr>';
                                }
                            });

                        }

                    }

                    else
                    {
                        html = '';
                    }

                    

                    html_head = '<tr><th>No. SPPB</th><th>No. RFQ</th><th>Proyek</th><th>Tanggal Dokumen RFQ</th><th>Status RFQ</th></tr>';
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

        }
        else {

            $("#mydata").dataTable().fnDestroy();

            $.ajax({
                url: "<?php echo base_url(); ?>/RFQ/data_RFQ_by_id_proyek_list",
                method: "POST",
                data: form_data,
                async: false,
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

                            $.ajax({
                                url: "<?php echo site_url('RFQ/get_list_rfq_by_id_sppb') ?>",
                                type: "POST",
                                dataType: "JSON",
                                async: false,
                                data: {
                                    ID_SPPB: data_1[i].ID_SPPB,
                                },
                                success: function (data) {
                                    var data_2 = data;
                                    var RFQ = '';

                                    if (data_2 == 'TIDAK ADA DATA') {
                                        html += '<tr style="background-color:#DAF7A6">' ;

                                    } else {
                                        html += '<tr>' ;
                                    }

                                    html += '<td>' + '<a href="<?php echo base_url() ?>SPPB_form/view/' + data_1[i].HASH_MD5_SPPB + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_1[i].NO_URUT_SPPB + ' </a>';
                                    html += '</br><a href="javascript:;" class="btn btn-success btn-xs item_buat_rfq_baru" data="' + data_1[i].HASH_MD5_SPPB + '"><i class="fa fa-plus"></i> Buat RFQ </a>' + ' ' +
                                        '</td>';

                                    html +=
                                    '<td>';
                                    if (data_2 == 'TIDAK ADA DATA') {
                                        var RFQ = '';

                                    } else {
                                        for (j = 0; j < data_2.length; j++) {
                                            RFQ = '<a href="<?php echo base_url() ?>RFQ_form/view/' + data_2[j].HASH_MD5_RFQ + '" class="btn btn-default btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_2[j].NO_URUT_RFQ + ' </a>';
                                            html += RFQ + "</br>";
                                        }
                                    }
                                    html +=
                                    '</td>';

                                    html +=
                                    '<td>';
                                    if (data_2 == 'TIDAK ADA DATA') {
                                        var RFQ = '';

                                    } else {
                                        for (j = 0; j < data_2.length; j++) {
                                            var TANGGAL = '';
                                            TANGGAL = '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_2[j].TANGGAL_DOKUMEN_RFQ + ' </a>';
                                            html += TANGGAL + "</br>";
                                        }

                                    }
                                    html +=
                                    '</td>';

                                    html +=
                                    '<td>';
                                    if (data_2 == 'TIDAK ADA DATA') {
                                        var RFQ = '';

                                    } else {
                                        for (j = 0; j < data_2.length; j++) {
                                            var STATUS = '';
                                            STATUS = '<a href="javascript:;" class="btn btn-info btn-xs item_status block" data="' + data_2[j].ID_RFQ + '"><i class="fa fa-search"></i> Lihat Status</a>';
                                            html += STATUS;
                                        }
                                    }
                                    html +=
                                    '</td>';

                                    
                                    
                                    html += '</tr>';
                                }
                            });

                        }

                    }

                    else
                    {
                        html = '';
                    }

                    

                    html_head = '<tr><th>No. SPPB</th><th>No. RFQ</th><th>Tanggal Dokumen RFQ</th><th>Status RFQ</th></tr>';
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

        }
        });

        //GET NOMOR URUT PER SPPB
        $('#show_data').on('click', '.item_buat_rfq_baru', function() {
            $('#btn_simpan').attr('disabled', true); //disable input
            $('#saya_setuju').prop('checked', false); // Unchecks it
            var HASH_MD5_SPPB = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/RFQ/get_data_proyek_by_hash_md5_sppb') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_SPPB: HASH_MD5_SPPB
                },
                success: function(data) {
        
                    $('[name="ID_PROYEK"]').val(data.ID_PROYEK);
                    $('[name="ID_PROYEK_SUB_PEKERJAAN"]').val(data.ID_PROYEK_SUB_PEKERJAAN);
                    $('[name="ID_RASD"]').val(data.ID_RASD);
                    $('[name="INISIAL"]').val(data.INISIAL);
                    $('[name="NAMA_PROYEK"]').val(data.NAMA_PROYEK);
                    $('[name="SUB_PROYEK"]').val(data.SUB_PROYEK);
                    $('[name="NO_URUT_SPPB"]').val(data.NO_URUT_SPPB);
                    $('[name="ID_SPPB"]').val(data.ID_SPPB);

                    var ID_SPPB = data.ID_SPPB;
                    var INISIAL = data.INISIAL;
                    var ID_PROYEK = data.ID_PROYEK;

                    var COUNT = "";
                    var NO_URUT = "";
                    var DEPAN = "";

                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url() ?>RFQ/get_nomor_urut",
                        dataType: "JSON",
                        data: {
                            ID_PROYEK: ID_PROYEK
                        },
                        success: function(data) {
                            $.each(data, function() {

                                var COUNT = data.JUMLAH_COUNT_RFQ;
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

                                $('#ModalAdd').modal('show');


                                $('[name="JUMLAH_COUNT_RFQ"]').val(COUNT);
                                //$('[name="NO_URUT_RFQ"]').val(`${NO_URUT}/RFQ/WME/${INISIAL}/${date.getFullYear()}`);
                                $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_RFQ_WME_${INISIAL}_${date.getFullYear()}`);

                            });

                        }
                    });
                }
            });
            return false;
        });

        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            var FILE_NAME_TEMP = $('#NO_URUT_SPPB').val();
            FILE_NAME_TEMP = FILE_NAME_TEMP.replace(/[^a-zA-Z0-9]/g, '_');

            var TANGGAL_DOKUMEN_RFQ = $('#TANGGAL_DOKUMEN_RFQ').val(),
            TANGGAL_DOKUMEN_RFQ = TANGGAL_DOKUMEN_RFQ.split("/").reverse().join("-");

            var form_data = {
                ID_PROYEK: $('#ID_PROYEK').val(),
                ID_SPPB: $('#ID_SPPB').val(),
                JUMLAH_COUNT_RFQ: $('#JUMLAH_COUNT_RFQ').val(),
                NO_URUT_RFQ: $('#NO_URUT_RFQ').val(),
                FILE_NAME_TEMP: FILE_NAME_TEMP,
                TANGGAL_DOKUMEN_RFQ: TANGGAL_DOKUMEN_RFQ,
                ID_PROYEK_SUB_PEKERJAAN: $('#ID_PROYEK_SUB_PEKERJAAN').val()
            };
            $.ajax({
                url: "<?php echo site_url('RFQ/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 1) {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('RFQ/get_data_rfq_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                console.log(data);
                                $.each(data, function() {
                                    if (data == 'BELUM ADA RFQ') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        window.location.href = '<?php echo base_url(); ?>RFQ_form/index/' + data.HASH_MD5_RFQ;
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