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
        Sistem menampilkan seluruh Rencana Pengiriman Barang yang Anda ajukan pada proyek <?php echo ($NAMA_PROYEK); ?>.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Rencana Pengiriman Barang</h5>
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
                                    <th>Nomor Surat Jalan</th>
                                    <th>Tanggal Pengiriman</th>
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
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd" style="margin-top: 30px;"><span class="fa fa-plus"></span>Buat Rencana Pengiriman Barang</a>
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
                <h4 class="modal-title">Identitas Form Rencana Pengiriman Barang</h4>
                <small class="font-bold">Silakan isi tanggal Rencana Pengiriman Barang</small>
            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("Rencana_Pengiriman_Barang/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />

            <input type="hidden" class="form-control" value="<?php echo ($ID_PROYEK); ?>" name="ID_PROYEK" id="ID_PROYEK" disabled />

            <input type="hidden" class="form-control" value="<?php echo ($USER_ID); ?>" name="USER_ID" id="USER_ID" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($ID_JABATAN_PEGAWAI); ?>" name="ID_JABATAN_PEGAWAI" id="ID_JABATAN_PEGAWAI" disabled />
            <input type="hidden" class="form-control" value="" name="INISIAL" id="INISIAL" disabled />


            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut PO:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_PO" id="NO_URUT_PO"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut Rencana Pengirman Barang:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_RENCANA_PENGIRIMAN_BARANG" id="NO_RENCANA_PENGIRIMAN_BARANG"  />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tanggal Pengajuan Rencana Pengiriman Barang:</label>
                        <div class="col-xs-9">
                            <input type="date" class="form-control" id="TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI" name="TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI">
                        </div>
                    </div>
                    <p>*tanggal pengajuan akan berubah sesuai dengan tanggal aktual pengajuan Rencana Pengiriman Barang</p>

                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3">Nomor Urut SPPB</label>
                        <div class="col-xs-9">
                            <select name="NO_URUT_SPPB_1" class="form-control" id="NO_URUT_SPPB_1">
                                <option value=''>- Pilih Nomor SPPB -</option>
                                <option value='666666'>- Tanpa SPPB -</option>
                                <?//php foreach ($sppb_list as $item) {
                                   // echo '<option value="' . $item->ID_SPPB . '">' . $item->NO_URUT_SPPB . '</option>';
                                //} ?>
                            </select>
                        </div>
                    </div> -->

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama Pengirim:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NAMA_PENGIRIM" id="NAMA_PENGIRIM" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">No HP Pengirim:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NO_HP_PENGIRIM" id="NO_HP_PENGIRIM" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Kepada:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="KEPADA" id="KEPADA" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tujuan:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="TUJUAN" id="TUJUAN" />
                        </div>
                    </div>

                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Buat Rencana Pengiriman Barang</button>
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
        var today = new Date().toISOString().substr(0, 10);
        // document.querySelector("#tglPem").valueAsDate = new Date();

        // tampil_data_surat_jalan(); //pemanggilan fungsi tampil data.
        tampil_data_RFQ();
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
        // function tampil_data_surat_jalan() {
        //     $.ajax({
        //         type: 'ajax',
        //         url: '<?php echo base_url() ?>Rencana_Pengiriman_Barang/data_surat_jalan',
        //         async: false,
        //         dataType: 'json',
        //         success: function(data) {
        //             var html = '';
        //             var i;
        //             var data_2= data;
        //             for (i = 0; i < data.length; i++) {

        //                 let PROGRESS_RENCANA_PENGIRIMAN_BARANG = data[i].PROGRESS_RENCANA_PENGIRIMAN_BARANG;

        //                 if (PROGRESS_RENCANA_PENGIRIMAN_BARANG == "Dalam Proses Supervisor Logistik") {
        //                     tombol_ubah = '<a href="#" class="btn btn-warning btn-xs block" disabled><i class="fa fa-pencil"></i> Ubah </a>';
        //                 } else {
        //                     tombol_ubah = '<a href="<?php echo base_url() ?>Rencana_Pengiriman_Barang/index/' + data[i].HASH_MD5_RENCANA_PENGIRIMAN_BARANG + '" class="btn btn-warning btn-xs block"><i class="fa fa-pencil"></i> Ubah </a>';
        //                 }

        //                 if (data[i].NO_URUT_SPPB === null) {
        //                     KET_NO_URUT_SPPB = 'TANPA SPPB';
        //                 } else {
        //                     KET_NO_URUT_SPPB = data[i].NO_URUT_SPPB;
        //                 }

        //                 html += '<tr>' +
        //                     '<td>' + data[i].NO_URUT_PO + '</td>' +
        //                     '<td>' + data[i].NO_RENCANA_PENGIRIMAN_BARANG + '</td>' +
        //                     '<td>' + data[i].TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI + '</td>' +
        //                     '<td>' + data[i].NAMA_PENGIRIM + '</td>' +
        //                     '<td>' + data[i].NO_HP_PENGIRIM + '</td>' +
        //                     '<td>' + data[i].KEPADA + '</td>' +
        //                     '<td>' + data[i].TUJUAN + '</td>' +
        //                     '<td>'
        //                     for(j = 0; j < data_2.length; j++) {
        //                     html +=  '<a href="<?php echo base_url() ?>Rencana_Pengiriman_Barang_form/view/' + data[i].HASH_MD5_RENCANA_PENGIRIMAN_BARANG + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i>Lihat Rencana Pengiriman Barang</a>'
        //                      } + ' ' +
        //                     '</td>' +
        //                     '</tr>';
        //             }
        //             $('#show_data').html(html);
        //         }
        //     });
        // }

        //fungsi tampil data
        function tampil_data_RFQ() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url() ?>Rencana_Pengiriman_Barang/data_RPB',
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
                            url: "<?php echo site_url('Rencana_Pengiriman_Barang/get_list_rfq_by_id_po') ?>",
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
                                    '<td>' + data_1[i].NO_RENCANA_PENGIRIMAN_BARANG + '</td>' +
                                    '<td>' + data_1[i].TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI + '</td>' +
                                    '<td>' +
                                    '<td>' + data_1[i].NAMA_PENGIRIM + '</td>' +
                                    '<td>' + data_1[i].NO_HP_PENGIRIM + '</td>' +
                                    '<td>' + data_1[i].KEPADA + '</td>' +
                                    '<td>' + data_1[i].TUJUAN + '</td>' +
                                    '<td>';

                                if (data_2 == 'TIDAK ADA DATA') {
                                    var PO = '';

                                } else {
                                    for (j = 0; j < data_2.length; j++) {
                                        PO = '<a href="<?php echo base_url() ?>Rencana_Pengiriman_Barang_form/view/' + data_2[j].HASH_MD5_RENCANA_PENGIRIMAN_BARANG + '" class="btn btn-primary btn-xs btn-outline" target="_blank"><i class="fa fa-eye"></i> ' + 'Lihat Data' + ' </a> '
                                        html += PO + "</br>";
                                    }

                                }

                                html += '<a href="javascript:;" class="btn btn-info btn-xs item_buat_rfq_baru" data="' + data_1[i].HASH_MD5_PO + '"><i class="fa fa-plus"></i> Buat Rencana Pengiriman Barang </a>' + ' ' +
                                    '</td>' +

                                    '</tr>';
                            }
                        });

                    }
                    $('#show_data').html(html);

                }
            });
        }

        //GET NOMOR URUT PER PO
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
                    $.each(data, function(
                        ID_PROYEK,
                        ID_RASD,
                        NAMA_PROYEK,
                        LOKASI,
                        INISIAL,
                        NO_URUT_SPPB,
                        ID_SPPB) {

                        $('[name="ID_PROYEK"]').val(data.ID_PROYEK);
                        $('[name="ID_RASD"]').val(data.ID_RASD);
                        $('[name="INISIAL"]').val(data.INISIAL);
                        $('[name="NAMA_PROYEK"]').val(data.NAMA_PROYEK);
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
                                    $('[name="NO_URUT_RFQ"]').val(`${NO_URUT}/RFQ/WME/${INISIAL}/2021`);
                                    $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_RFQ_WME_${INISIAL}_2021`);

                                });

                            }
                        });

                    });
                }
            });
            return false;
        });

        // //GET NOMOR URUT PER SPPB
        // $('#show_data').on('click', '.item_buat_rfq_baru', function() {
        //     $('#btn_simpan').attr('disabled', true); //disable input
        //     $('#saya_setuju').prop('checked', false); // Unchecks it
        //     var HASH_MD5_SPPB = $(this).attr('data');
        //     $.ajax({
        //         type: "GET",
        //         url: "<?php echo base_url('index.php/RFQ/get_data_proyek_by_hash_md5_sppb') ?>",
        //         dataType: "JSON",
        //         data: {
        //             HASH_MD5_SPPB: HASH_MD5_SPPB
        //         },
        //         success: function(data) {
        //             $.each(data, function(
        //                 ID_PROYEK,
        //                 ID_RASD,
        //                 NAMA_PROYEK,
        //                 LOKASI,
        //                 INISIAL,
        //                 NO_URUT_SPPB,
        //                 ID_SPPB) {

        //                 $('[name="ID_PROYEK"]').val(data.ID_PROYEK);
        //                 $('[name="ID_RASD"]').val(data.ID_RASD);
        //                 $('[name="INISIAL"]').val(data.INISIAL);
        //                 $('[name="NAMA_PROYEK"]').val(data.NAMA_PROYEK);
        //                 $('[name="NO_URUT_SPPB"]').val(data.NO_URUT_SPPB);
        //                 $('[name="ID_SPPB"]').val(data.ID_SPPB);

        //                 var ID_SPPB = data.ID_SPPB;
        //                 var INISIAL = data.INISIAL;
        //                 var ID_PROYEK = data.ID_PROYEK;

        //                 var COUNT = "";
        //                 var NO_URUT = "";
        //                 var DEPAN = "";

        //                 $.ajax({
        //                     type: "GET",
        //                     url: "<?php echo base_url() ?>RFQ/get_nomor_urut",
        //                     dataType: "JSON",
        //                     data: {
        //                         ID_PROYEK: ID_PROYEK
        //                     },
        //                     success: function(data) {
        //                         $.each(data, function() {

        //                             var COUNT = data.JUMLAH_COUNT_RFQ;

        //                             if (COUNT == null) {
        //                                 COUNT = "0";
        //                             }
        //                             if (COUNT == NaN) {
        //                                 COUNT = "0";
        //                             }

        //                             COUNT = parseInt(COUNT) + 1;

        //                             if (COUNT < 1000) {
        //                                 DEPAN = "";
        //                             }

        //                             if (COUNT < 100) {
        //                                 DEPAN = "0";
        //                             }

        //                             if (COUNT < 10) {
        //                                 DEPAN = "00";
        //                             }

        //                             var str1 = DEPAN;
        //                             var str2 = COUNT;
        //                             var belakang = +str2.toString();
        //                             NO_URUT = str1 + str2.toString();

        //                             $('#ModalAdd').modal('show');


        //                             $('[name="JUMLAH_COUNT_RFQ"]').val(COUNT);
        //                             $('[name="NO_URUT_RFQ"]').val(`${NO_URUT}/RFQ/WME/${INISIAL}/2021`);
        //                             $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_RFQ_WME_${INISIAL}_2021`);

        //                         });

        //                     }
        //                 });

        //             });
        //         }
        //     });
        //     return false;
        // });

        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            let form_data = {
                ID_PROYEK: $('#ID_PROYEK').val(),
                TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI: $('#TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI').val(),
                JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
                NO_URUT_PO: $('#NO_URUT_PO').val(),
                NO_RENCANA_PENGIRIMAN_BARANG: $('#NO_RENCANA_PENGIRIMAN_BARANG').val(),
                USER_ID: $('#USER_ID').val(),
                FILE_NAME_TEMP: $('#FILE_NAME_TEMP').val(),
                NAMA_PENGIRIM: $('#NAMA_PENGIRIM').val(),
                NO_HP_PENGIRIM: $('#NO_HP_PENGIRIM').val(),
                TUJUAN: $('#TUJUAN').val(),
                PIC_PENERIMA_BARANG: $('#PIC_PENERIMA_BARANG').val(),
                NO_HP_PIC: $('#NO_HP_PIC').val(),
                TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI: $('#TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI').val(),
                KEPADA: $('#KEPADA').val(),
            };
            $.ajax({
                url: "<?php echo site_url('Rencana_Pengiriman_Barang/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "GET",
                            url: "<?php echo base_url('Rencana_Pengiriman_Barang/get_data_surat_jalan_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                $.each(data, function() {
                                    if (data == 'BELUM ADA SURAT JALAN') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        console.log(data);
                                        window.location.href = '<?php echo base_url(); ?>Rencana_Pengiriman_Barang/index/' + data.HASH_MD5_RENCANA_PENGIRIMAN_BARANG;
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