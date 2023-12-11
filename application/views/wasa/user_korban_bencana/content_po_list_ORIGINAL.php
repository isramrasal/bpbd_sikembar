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
        Sistem menampilkan SPP yang diajukan dari seluruh proyek, dan PO yang telah dibuat.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>PO</h5>
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
                                    <th>Nomor Urut SPP</th>
                                    <th>Tanggal Pengajuan SPP</th>
                                    <th>Proyek</th>
                                    <th>Tanggal Pengajuan PO</th>
                                    <th>Progress PO</th>
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
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Identitas Form PO</h4>

            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("FPB/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT_PO" id="JUMLAH_COUNT_PO" disabled />

            <input type="hidden" class="form-control" value="" name="ID_PROYEK" id="ID_PROYEK" disabled />
            <input type="hidden" class="form-control" value="" name="ID_RASD" id="ID_RASD" disabled />
            <input type="hidden" class="form-control" value="" name="INISIAL" id="INISIAL" disabled />


            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-xs-3 control-label">No. Urut SPP</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_SPP" id="NO_URUT_SPP" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama Proyek</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NAMA_PROYEK" id="NAMA_PROYEK" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut PO</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" placeholder="Contoh: 004/PO/WME/CC-CRB2/2022" name="NO_URUT_PO" id="NO_URUT_PO" />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
                            <input type="hidden" class="form-control" value="" name="ID_SPP" id="ID_SPP" disabled />
                            <input type="hidden" class="form-control" value="" name="ID_SPPB" id="ID_SPPB" disabled />
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
                        <label class="col-xs-3 control-label">Kategori RAB</label>
                        <div class="col-xs-9">
                            <select name="PERALATAN_PERLENGKAPAN" class="form-control" id="PERALATAN_PERLENGKAPAN">
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tanggal Pengajuan PO</label>
                        <div class="col-xs-9">
                            <input id="TANGGAL_DOKUMEN_PO" type="date" class="form-control">
                            *tanggal pengajuan akan berubah sesuai dengan tanggal aktual pengajuan PO
                        </div>
                    </div>

                    <div id="alert-msg"></div>

                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses identitas form PO ini dan menyetujui untuk proses selanjutnya </label></div>
                    </div>

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

        var today = new Date().toISOString().substr(0, 10);
        document.querySelector("#TANGGAL_DOKUMEN_PO").valueAsDate = new Date();

        tampil_data_PO(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
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
                    title: 'PO'
                },
                {
                    extend: 'pdf',
                    title: 'PO'
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
        function tampil_data_PO() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url() ?>PO/data_PO',
                async: false,
                dataType: 'json',
                success: function(data) {

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
                            success: function(data) {
                                var data_2 = data;
                                var PO = '';

                                html += '<tr>' +
                                    '<td>' + '<a href="<?php echo base_url() ?>SPP_form/view/' + data_1[i].HASH_MD5_SPP + '" class="btn btn-primary btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_1[i].NO_URUT_SPP + ' </a>' + '</td>' +
                                    '<td>' + '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_1[i].TANGGAL_DOKUMEN_SPP + ' </a>' + '</td>' +
                                    '<td>' + '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_1[i].NAMA_PROYEK + ' </a>' + '</td>' +
                                    '<td>';

                                if (data_2 == 'TIDAK ADA DATA') {
                                    var PO = '';

                                } else {
                                    for (j = 0; j < data_2.length; j++) {
                                        var TANGGAL = '';
                                        TANGGAL = '<a href="#" class="btn btn-link btn-xs text-decoration-none"> ' + data_2[j].TANGGAL_DOKUMEN_PO + ' </a>';
                                        html += TANGGAL + "</br>";
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
                                            html_progress = '<a href="#" class="btn btn-success btn-xs btn-outline"> ' + data_2[j].PROGRESS_PO + ' </a>';
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
                                        PO = '<a href="<?php echo base_url() ?>PO_form/view/' + data_2[j].HASH_MD5_PO + '" class="btn btn-primary btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + data_2[j].NO_URUT_PO + ' </a>';
                                        html += PO + "</br>";
                                    }

                                }

                                html += '<a href="javascript:;" class="btn btn-info btn-xs item_buat_po_baru" data="' + data_1[i].HASH_MD5_SPP + '"><i class="fa fa-plus"></i> Buat PO </a>' + ' ' +
                                    '</td>' +
                                    '</tr>';
                            }
                        });
                    }
                    $('#show_data').html(html);
                }
            });
        }

        // Dropdown ID VENDOR berubah
        $('#ModalAdd').on('shown.bs.modal', function() {
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
                        html += '<option value=' + data[i].ID_VENDOR + '>' + data[i].NAMA_VENDOR + '</option>';
                    }
                    $('#ID_VENDOR').html(html);
                }
            });

            $.ajax({
                url: "<?php echo base_url(); ?>/PO/get_data_id_rab_form_by_id_spp",
                method: "POST",
                data: {
                    ID_SPP: ID_SPP
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;

                    html = "<option value=''>- Pilih Kategori RAB -</option>";

                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].ID_RAB_FORM + '">' + data[i].NAMA_KATEGORI + '</option>';
                    }
                    $('#PERALATAN_PERLENGKAPAN').html(html);

                }
            });
        });

        //GET NOMOR URUT PER SPP
        $('#show_data').on('click', '.item_buat_po_baru', function() {
            $('#btn_simpan').attr('disabled', true); //disable input
            $('#saya_setuju').prop('checked', false); // Unchecks it
            var HASH_MD5_SPP = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/PO/get_data_proyek_by_hash_md5_spp') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_SPP: HASH_MD5_SPP
                },
                success: function(data) {
                    $('[name="ID_PROYEK"]').val(data.ID_PROYEK);
                    $('[name="INISIAL"]').val(data.INISIAL);
                    $('[name="ID_RASD"]').val(data.ID_RASD);
                    $('[name="NAMA_PROYEK"]').val(data.NAMA_PROYEK);
                    $('[name="NO_URUT_SPP"]').val(data.NO_URUT_SPP);
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

                                $('#ModalAdd').modal('show');

                                $('[name="JUMLAH_COUNT_PO"]').val(COUNT);
                                //$('[name="NO_URUT_PO"]').val(`${NO_URUT}/PO/WME/${INISIAL}/${date.getFullYear()}`);
                                $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_PO_WME_${INISIAL}_${date.getFullYear()}`);

                            });
                        }
                    });
                }
            });
            return false;
        });


        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            var form_data = {
                ID_PROYEK: $('#ID_PROYEK').val(),
                ID_RASD: $('#ID_RASD').val(),
                ID_SPPB: $('#ID_SPPB').val(),
                ID_SPP: $('#ID_SPP').val(),
                ID_VENDOR: $('#ID_VENDOR').val(),
                INISIAL: $('#INISIAL').val(),
                NAMA_PROYEK: $('#NAMA_PROYEK').val(),
                NO_URUT_SPPB: $('#NO_URUT_SPPB').val(),
                NO_URUT_SPP: $('#NO_URUT_SPP').val(),
                JUMLAH_COUNT_PO: $('#JUMLAH_COUNT_PO').val(),
                NO_URUT_PO: $('#NO_URUT_PO').val(),
                PERALATAN_PERLENGKAPAN: $('#PERALATAN_PERLENGKAPAN').val(),
                TANGGAL_DOKUMEN_PO: $('#TANGGAL_DOKUMEN_PO').val(),
                FILE_NAME_TEMP: $('#FILE_NAME_TEMP').val()
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
    });
</script>

</body>

</html>