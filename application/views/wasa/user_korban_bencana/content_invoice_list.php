<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Invoice</h2>
        <ol class="breadcrumb">
            <li>
                Home
            </li>
            <li>
                <a href="<?php echo base_url('Invoice') ?>">Invoice</a>
            </li>
            <li class="active">
                <strong>
                    <a>List Invoice</a>
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

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Invoice</h5>
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
                                    <th>Nomor Invoice Vendor</th>
                                    <th>Nominal Invoice</th>
                                    <th>Tanggal Penyerahan Invoice</th>
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

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 40vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Identitas Form Delivery Plan</h4>

            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("FPB/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />
            <input type="hidden" class="form-control" value="" name="ID_PROYEK" id="ID_PROYEK" disabled />
            <input type="hidden" class="form-control" value="" name="ID_VENDOR" id="ID_VENDOR" disabled />
            <input type="hidden" class="form-control" value="" name="ID_SPPB" id="ID_SPPB" disabled />
            <input type="hidden" class="form-control" value="" name="ID_PROYEK_LOKASI_PENYERAHAN" id="ID_PROYEK_LOKASI_PENYERAHAN" disabled />
            <input type="hidden" class="form-control" value="" name="INISIAL" id="INISIAL" disabled />
            <input type="hidden" class="form-control" value="" name="ID_PO" id="ID_PO" disabled />


            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-xs-3 control-label">No. Urut PO:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_PO" id="NO_URUT_PO" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Invoice Vendor:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_INVOICE" id="NO_INVOICE" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nominal Invoice</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="HARGA_INVOICE" id="HARGA_INVOICE" placeholder="Contoh: Rp 2000000 ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tanggal Penyerahan Invoice:</label>
                        <div class="col-xs-9">
                            <input type="date" class="form-control" id="TANGGAL_PENYERAHAN_HARI">
                        </div>
                    </div>

                    <div id="alert-msg"></div>

                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses identitas form Invoice ini dan menyetujui untuk proses selanjutnya </label></div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" name="btn_simpan" id="btn_simpan" disabled><i class="fa fa-save"></i> Buat Invoice</button>
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
        document.querySelector("#TANGGAL_PENYERAHAN_HARI").valueAsDate = new Date();

        tampil_data_invoice(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
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
        function tampil_data_invoice() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url() ?>Invoice/data_Invoice',
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
                            url: "<?php echo site_url('Invoice/get_list_invoice_by_id_po') ?>",
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
                                        html_progress = data_2[j].NO_INVOICE;
                                        html += '<a href="#" class="btn btn-link btn-xs btn-block text-decoration-none"> ' + html_progress + "</br>";
                                    }
                                }

                                html +=
                                    '</td>' +

                                    '<td>';

                                if (data_2 == 'TIDAK ADA DATA') {
                                    var PO = '';

                                } else {
                                    for (j = 0; j < data_2.length; j++) {

                                        data_2[j].HARGA_INVOICE = new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR'
                                        }).format(data_2[j].HARGA_INVOICE);


                                        var html_progress = '';
                                        html_progress = data_2[j].HARGA_INVOICE;
                                        html += '<a href="#" class="btn btn-link btn-xs btn-block text-decoration-none"> ' + html_progress + "</br>";
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
                                        html_progress = data_2[j].TANGGAL_PENYERAHAN_HARI;
                                        html += '<a href="#" class="btn btn-link btn-xs btn-block text-decoration-none"> ' + html_progress + "</br>";
                                    }
                                }

                                html +=
                                    '</td>' +

                                    '<td>';

                                if (data_2 == 'TIDAK ADA DATA') {
                                    var PO = '';

                                } else {
                                    for (j = 0; j < data_2.length; j++) {
                                        PO = '<a href="<?php echo base_url() ?>Invoice_form/view/' + data_2[j].HASH_MD5_VENDOR_INVOICE + '" class="btn btn-primary btn-xs btn-outline"><i class="fa fa-eye"></i> ' + data_2[j].NO_INVOICE + ' </a>';
                                        html += PO + "</br>";
                                    }
                                }

                                html += '<a href="javascript:;" class="btn btn-info btn-xs item_buat_po_baru" data="' + data_1[i].HASH_MD5_PO + '"><i class="fa fa-plus"></i> Buat Invoice </a>' + ' ' +
                                    '</td>' +
                                    '</tr>';
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
                url: "<?php echo base_url('index.php/Rencana_Pengiriman_Barang/get_data_proyek_by_hash_md5_po') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_PO: HASH_MD5_PO
                },
                success: function(data) {
                    $('[name="ID_PO"]').val(data.ID_PO);
                    $('[name="ID_PROYEK"]').val(data.ID_PROYEK);
                    $('[name="ID_VENDOR"]').val(data.ID_VENDOR);
                    $('[name="ID_SPPB"]').val(data.ID_SPPB);
                    $('[name="ID_PROYEK_LOKASI_PENYERAHAN"]').val(data.ID_PROYEK_LOKASI_PENYERAHAN);
                    $('[name="NO_URUT_PO"]').val(data.NO_URUT_PO);
                    $('[name="ID_RASD"]').val(data.ID_RASD);
                    $('[name="ID_SPPB"]').val(data.ID_SPPB);
                    $('[name="NAMA_PROYEK"]').val(data.NAMA_PROYEK);
                    $('[name="LOKASI"]').val(data.LOKASI);
                    $('[name="INISIAL"]').val(data.INISIAL);

                    var ID_SPPB = data.ID_SPPB;
                    var INISIAL = data.INISIAL;
                    var ID_PROYEK = data.ID_PROYEK;
                    var ID_VENDOR = data.ID_VENDOR;
                    var ID_PO = data.ID_PO;

                    var COUNT = "";
                    var NO_URUT = "";
                    var DEPAN = "";

                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url() ?>Rencana_Pengiriman_Barang/get_nomor_urut",
                        dataType: "JSON",
                        data: {
                            ID_PROYEK: ID_PROYEK
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

                                $('#ModalAdd').modal('show');


                                $('[name="JUMLAH_COUNT"]').val(COUNT);
                                $('[name="NO_RENCANA_PENGIRIMAN_BARANG"]').val(`${NO_URUT}/RPB/WME/${INISIAL}/${date.getFullYear()}`);
                                $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_RPB_WME_${INISIAL}_${date.getFullYear()}`);

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
                ID_PO: $('#ID_PO').val(),
                ID_PROYEK: $('#ID_PROYEK').val(),
                ID_VENDOR: $('#ID_VENDOR').val(),
                ID_SPPB: $('#ID_SPPB').val(),
                ID_PROYEK_LOKASI_PENYERAHAN: $('#ID_PROYEK_LOKASI_PENYERAHAN').val(),
                ID_RASD: $('#ID_RASD').val(),
                INISIAL: $('#INISIAL').val(),
                NO_URUT_PO: $('#NO_URUT_PO').val(),
                NO_INVOICE: $('#NO_INVOICE').val(),
                TANGGAL_PENYERAHAN_HARI: $('#TANGGAL_PENYERAHAN_HARI').val(),
                HARGA_INVOICE: $('#HARGA_INVOICE').val()
            };
            $.ajax({
                url: "<?php echo site_url('Invoice/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 1) {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('Invoice/get_data_invoice_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                $.each(data, function() {
                                    if (data == 'BELUM ADA INVOICE') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        window.location.href = '<?php echo base_url(); ?>index.php/Invoice_form/view/' + data.HASH_MD5_VENDOR_INVOICE;
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