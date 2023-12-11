<?php
function tanggal_indo_full($tanggal, $cetak_hari = false)
{
    if($tanggal == '0000-00-00')
    {
        $tgl_indo = "-";
        return $tgl_indo;
    }

    else if($tanggal == NULL)
    {
        $tgl_indo = "-";
        return $tgl_indo;
    }

    else
    {
        $hari = array ( 1 =>    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu',
                    'Minggu'
                );
                
        $bulan = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        $split 	  = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        
        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;

    }
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form SPPB Pembelian</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPPB/') ?>">SPPB Pembelian</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form SPPB</a>
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
                    <h5>Formulir Pengisian Item Barang/Jasa SPPB Pembelian</h5>
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
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Identitas Form</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <form method="get" class="form-horizontal">
                                        <?php
                                        if (isset($SPPB)) {
                                            foreach ($SPPB->result() as $SPPB):
                                                ?>
                                                <div class="form-group"><label class="col-sm-2 control-label">Proyek</label>
                                                    <div class="col-sm-10"><a href="<?php echo base_url() ?>Proyek/detil_proyek/<?php echo $SPPB->HASH_MD5_PROYEK; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $SPPB->NAMA_PROYEK; ?> </a></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Pekerjaan</label>
                                                    <div class="col-sm-10"><input name="SUB_PROYEK" id="SUB_PROYEK" type="text"
                                                            class="form-control" value="<?php echo $SPPB->NAMA_SUB_PEKERJAAN; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">No. Urut SPBB</label>
                                                    <div class="col-sm-10">
                                                            <input name="NO_URUT_SPPB_GANTI" id="NO_URUT_SPPB_GANTI" type="text" class="form-control"
                                                            value="<?php echo $SPPB->NO_URUT_SPPB; ?>" disabled>
                                                            <input name="NO_URUT_SPPB_ASLI" id="NO_URUT_SPPB_ASLI" type="hidden" class="form-control" value="<?php echo $SPPB->NO_URUT_SPPB; ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Tanggal Dokumen
                                                        SPPB</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control"
                                                            value="<?php echo tanggal_indo_full($SPPB->TANGGAL_DOKUMEN_SPPB_INDO, false);?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Tanggal SPPB By
                                                        System</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control"
                                                            value="<?php echo tanggal_indo_full($SPPB->TANGGAL_PEMBUATAN_SPPB_HARI_INDO, false); ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Catatan Dokumen
                                                        SPPB</label>
                                                    <div class="col-sm-10"><input name="CTT_DEPT_PROC" id="CTT_DEPT_PROC" type="text"
                                                            class="form-control" value="<?php echo $SPPB->CTT_DEPT_PROC; ?>" disabled>
                                                    </div>
                                                </div>

                                            <?php endforeach;
                                        } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Telusur Item Barang/Jasa SPPB Pembelian</h5>
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
                            <div class="form-horizontal">
                                    <!-- <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAdd1Item"><span class="fa fa-plus"></span> Tambah Item Barang/Jasa</a>
                                    </br>
                                    <a href="javascript:;" id="item_edit_upload_excel" name="item_edit_upload_excel" class="btn btn-primary" data="<?php echo $HASH_MD5_SPPB; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Tambah Item Barang/Jasa Secara Bulk</a>
                                    </br>
                                    <a href="javascript:;" id="hapus_semua_item" name="hapus_semua_item" class="btn btn-danger text-right" data="<?php echo $HASH_MD5_SPPB; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Hapus Semua Barang/Jasa</a> -->
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="mydata">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang/Jasa</th>
                                            <th>Merek Barang/Jasa</th>
                                            <th>Spesifikasi Singkat</th>
                                            <th>Kategori RAB dan Klasifikasi Barang/Jasa</th>
                                            <th>Item dan Qty RASD</th>
                                            <th>Total Pengadaan s/d Saat Ini</th>
                                            <th>SPPB</th>
                                            <th>SPP</th>
                                            <th>PO</th>
                                            <th>FIB/FSTB</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">

                                    </tbody>

                                </table>
                            </div>

                            <br>
                            <!-- <div class="hr-line-dashed"></div> -->
                            
                            <!-- END OF konten tanggal apply for all -->
                        </div>

                    </div>
                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="form-group">
                                <div class="sm-10">
                                    <a href="<?php echo base_url('index.php/SPPB_form/view/'); ?><?php echo $HASH_MD5_SPPB; ?>"
                                        class="btn btn-primary"><span class="fa fa-save"></span> Kembali Ke Halaman View Dokumen
                                        SPPB</a>
                                    </br>
                                    
                                </div>
                            </div>
                            <div id="alert-msg-9"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/summernote/summernote.min.js"></script>

<!-- TouchSpin -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- DROPZONE -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dropzone/dropzone.js"></script>

<!-- Page-Level Scripts -->
<script>

    $(document).ready(function () {

        let ID_SPPB = <?php echo $ID_SPPB ?>;
        let HASH_MD5_SPPB = "<?php echo $HASH_MD5_SPPB ?>";
        let ID_PROYEK = <?php echo $ID_PROYEK ?>;
        let NO_URUT_SPPB = "<?php echo $NO_URUT_SPPB ?>";
        tampil_data_sppb_form(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            aaSorting: [],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                extend: 'excel',
                title: 'Telusur SPPB export EXCEL <?php echo $NO_URUT_SPPB ?>',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
            },
            {
                extend: 'print',
                orientation: 'landscape',
                title: 'Telusur SPPB export <?php echo $NO_URUT_SPPB ?>',
                pageSize: 'A4',
                customize: function (win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
            }
            ]

        });

        //fungsi tampil data
        function tampil_data_sppb_form() {

            // var form_data = {
            //     ID_SPPB: ID_SPPB
            // };

            // $.ajax({
            //     url: "<?php echo site_url('SPPB_form/update_status_sppb_complete') ?>",
            //     type: "POST",
            //     dataType: "JSON",
            //     async: false,
            //     data: form_data,
            //     success: function (data) {
                    
            //     }
            // });

            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>SPPB_form/data_grup_rab_sppb_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_SPPB
                },
                success: function (data) {

                    var html, html_PO, html_spp, html_fstb = '';

                    for (l = 0; l < data.length; l++) {

                        ID_RAB_FORM = data[l].ID_RAB_FORM;
                        NAMA_KATEGORI = data[l].NAMA_KATEGORI;

                        html +=
                        '<tr>'+
                        '<td>' + '<b>' + NAMA_KATEGORI + '</b>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '</tr>';

                        $.ajax({
                            type: 'GET',
                            url: '<?php echo base_url() ?>SPPB_form/data_sppb_form',
                            async: false,
                            dataType: 'json',
                            data: {
                                ID_SPPB: ID_SPPB,
                                ID_RAB_FORM: ID_RAB_FORM
                            },
                            success: function (data) {

                                var data_1 = data;
                                var i, j, k = 0;
                                var jumlah_quantity, jumlah_qty_spp = 0;
                                var jumlah_rasd,jumlah_realisasi = 0;
                                var nama_rasd,NAMA_BARANG,SPESIFIKASI_SINGKAT,SATUAN_BARANG,JUMLAH_QTY_SPP,TANGGAL_MULAI_PAKAI_HARI,NAMA_KATEGORI,TD_KLASIFIKASI,TELUSUR_SPP, tr_buka_coret, tr_tutup_coret = '';

                                for (i = 0; i < data_1.length; i++) {

                                    JUMLAH_QTY_SPP = data_1[i].JUMLAH_QTY_SPP;

                                    if (data_1[i].ID_RASD_FORM == null) {
                                        jumlah_rasd = null;
                                        nama_rasd = null;
                                    }
                                    else {
                                        var form_data = {
                                            ID_RASD_FORM: data_1[i].ID_RASD_FORM
                                        };
            
                                        $.ajax({
                                            url: "<?php echo site_url('SPPB_form/data_qty_rasd') ?>",
                                            type: "POST",
                                            dataType: "JSON",
                                            async: false,
                                            data: form_data,
                                            success: function (data) {
                                                var data_2 = data;

                                                if (data_2[0] == null) {

                                                }
                                                else {
                                                    jumlah_rasd = data_2[0].jumlah_quantity_rasd;
                                                    nama_rasd = data_2[0].NAMA;
                                                }

                                            }
                                        });
                                    }

                                    
                                    if(data_1[i].COMPLETE == "TERPENUHI")
                                    {
                                        tanda_coret_buka = '<s>';
                                        tanda_coret_tutup = '</s>';
                                    }
                                    else
                                    {
                                        tanda_coret_buka = '';
                                        tanda_coret_tutup = '';
                                    }

                                    if (data[i].JUMLAH_QTY_SPP == null || data[i].JUMLAH_QTY_SPP == 0) {
                                        JUMLAH_QTY_SPP = '<td style="background-color:#DAF7A6">' + tanda_coret_buka + data_1[i].JUMLAH_QTY_SPP + ' '+ data_1[i].SATUAN_BARANG + tanda_coret_tutup + '</td>';
                                    }
                                    else
                                    {
                                        JUMLAH_QTY_SPP = '<td>' + tanda_coret_buka + data_1[i].JUMLAH_QTY_SPP + ' '+ data_1[i].SATUAN_BARANG + tanda_coret_tutup +'</td>';
                                    }

                                    if (data[i].NAMA_BARANG == null || data[i].NAMA_BARANG == "") {
                                        NAMA_BARANG = '<td style="background-color:#DAF7A6">' + tanda_coret_buka + data_1[i].NAMA_BARANG + tanda_coret_tutup +'</td>';
                                    }
                                    else
                                    {
                                        NAMA_BARANG = '<td>' + tanda_coret_buka + data_1[i].NAMA_BARANG + tanda_coret_tutup + '</td>';
                                    }


                                    if (data[i].SPESIFIKASI_SINGKAT == null || data[i].SPESIFIKASI_SINGKAT == "") {
                                        SPESIFIKASI_SINGKAT = '<td style="background-color:#DAF7A6">' + tanda_coret_buka + data_1[i].SPESIFIKASI_SINGKAT + tanda_coret_tutup + '</td>';
                                    }
                                    else
                                    {
                                        SPESIFIKASI_SINGKAT = '<td>' + tanda_coret_buka + data_1[i].SPESIFIKASI_SINGKAT + tanda_coret_tutup + '</td>';
                                    }


                                    if (data[i].ID_RAB_FORM == "" && data[i].NAMA_KATEGORI_RAB == "") {
                                        TD_KLASIFIKASI = '<td style="background-color:#DAF7A6">';
                                    }

                                    else if (data[i].ID_RAB_FORM == null && data[i].NAMA_KATEGORI_RAB == null) {
                                        TD_KLASIFIKASI = '<td style="background-color:#DAF7A6">';
                                    }

                                    else if (data[i].ID_RAB_FORM == null && data[i].NAMA_KATEGORI_RAB == "") {
                                        TD_KLASIFIKASI = '<td style="background-color:#DAF7A6">';
                                    }

                                    else if (data[i].ID_RAB_FORM == "" && data[i].NAMA_KATEGORI_RAB == null) {
                                        TD_KLASIFIKASI = '<td style="background-color:#DAF7A6">';
                                    }

                                    else if (data[i].ID_RAB_FORM == "0" && data[i].NAMA_KATEGORI_RAB == null) {
                                        TD_KLASIFIKASI = '<td style="background-color:#DAF7A6">';
                                    }
                                    else
                                    {
                                        TD_KLASIFIKASI = '<td>';
                                    }

                                    if (data[i].ID_KLASIFIKASI_BARANG == null || data[i].ID_KLASIFIKASI_BARANG == "" || data[i].ID_KLASIFIKASI_BARANG == "0" || TD_KLASIFIKASI=='<td style="background-color:#DAF7A6">') {
                                        TD_KLASIFIKASI = '<td style="background-color:#DAF7A6">';
                                    }
                                    else
                                    {
                                        TD_KLASIFIKASI = '<td>';
                                    }

                                    if (data[i].TANGGAL_MULAI_PAKAI_HARI == "" || data[i].TANGGAL_MULAI_PAKAI_HARI == "00/00/0000" || data[i].TANGGAL_MULAI_PAKAI_HARI == null) {
                                        TANGGAL_MULAI_PAKAI_HARI = '<td style="background-color:#DAF7A6">' + 'Mulai: ' + data_1[i].TANGGAL_MULAI_PAKAI_HARI;
                                    }

                                    else{
                                        TANGGAL_MULAI_PAKAI_HARI = '<td>' + 'Mulai: ' + data_1[i].TANGGAL_MULAI_PAKAI_HARI;
                                    }

                                    var form_data = {
                                        ID_RASD_FORM: data_1[i].ID_RASD_FORM
                                    };
        
                                    $.ajax({
                                        url: "<?php echo site_url('SPPB_form/data_qty_rasd_realisasi') ?>",
                                        type: "POST",
                                        dataType: "JSON",
                                        async: false,
                                        data: form_data,
                                        success: function (data) {
                                            var data_3 = data;

                                            if (data_3[0].JUMLAH_BARANG == null) {
                                                jumlah_realisasi = 0;
                                            }
                                            else {
                                                jumlah_realisasi = data_3[0].JUMLAH_BARANG;
                                            }

                                        }
                                    });

                                    html +=
                                    '<tr>'+
                                    NAMA_BARANG +
                                    '<td>' + tanda_coret_buka + data_1[i].MEREK + tanda_coret_tutup + '</td>' +
                                    SPESIFIKASI_SINGKAT +
                                    TD_KLASIFIKASI + tanda_coret_buka + 'RAB: ' + data_1[i].NAMA_KATEGORI + '</br> Klasifikasi:' + data_1[i].NAMA_KLASIFIKASI_BARANG + tanda_coret_tutup + '</td>' +
                                    SATUAN_BARANG +
                                    '<td>' + tanda_coret_buka + 'Item: ' + nama_rasd + '</br>' + 'Qty: ' + jumlah_rasd + tanda_coret_tutup + '</td>' +
                                    '<td>' + jumlah_realisasi + ' item barang </td>' +
                                    JUMLAH_QTY_SPP;

                                    var form_data = {
                                        ID_SPPB_FORM: data_1[i].ID_SPPB_FORM
                                    };
        
                                    html_spp = '';

                                    $.ajax({
                                        url: "<?php echo site_url('SPPB_form/data_spp_form_by_id_sppb_form') ?>",
                                        type: "POST",
                                        dataType: "JSON",
                                        async: false,
                                        data: form_data,
                                        success: function (data) {
                                            var data_spp_form = data;
                                            
                    
                                            html_spp += '<td>';
                                            JUMLAH_BARANG_SPP = 0;
                                            for (m = 0; m < data_spp_form.length; m++) {

                                                var form_data_spp = {
                                                    ID_SPP: data_spp_form[m].ID_SPP
                                                };
                                                $.ajax({
                                                    url: "<?php echo site_url('SPPB_form/data_spp_by_id_spp') ?>",
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    async: false,
                                                    data: form_data_spp,
                                                    success: function (data) {
                                                        var data_spp_induk = data;

                                                        html_spp +='<a href="<?php echo base_url() ?>SPP_form/view/'+ data_spp_induk[0].HASH_MD5_SPP +'" class="btn btn-primary btn-xs block"><i class="fa fa-eye"></i>'+ data_spp_induk[0].NO_URUT_SPP +'</a> Qty:'+ data_spp_form[m].JUMLAH_BARANG  +' ' + data_spp_form[m].SATUAN_BARANG + '<br>' ;

                                                        JUMLAH_BARANG_SPP = JUMLAH_BARANG_SPP + parseInt(data_spp_form[m].JUMLAH_BARANG);
                                                    }
                                                });

                                            }
                                            // if( JUMLAH_BARANG_SPP>=data_1[i].JUMLAH_QTY_SPP )
                                            // {
                                            //     var form_data_id_sppb_form = {
                                            //         ID_SPPB_FORM: data_1[i].ID_SPPB_FORM
                                            //     };

                                            //     $.ajax({
                                            //         url: "<?php echo site_url('SPPB_form/update_status_id_sppb_form') ?>",
                                            //         type: "POST",
                                            //         dataType: "JSON",
                                            //         async: false,
                                            //         data: form_data_id_sppb_form,
                                            //         success: function (data) {
                                                        
    
                                            //         }
                                            //     });

                                            // }

                                            html_spp += ' </td>';
                                            
                                        }
                                    });
                                
                                    html += html_spp;

                                    html_po = '';

                                    $.ajax({
                                        url: "<?php echo site_url('SPPB_form/data_po_form_by_id_sppb_form') ?>",
                                        type: "POST",
                                        dataType: "JSON",
                                        async: false,
                                        data: form_data,
                                        success: function (data) {
                                            var data_po_form = data;
                                            
                                            html_po += '<td>';
                                            for (n = 0; n < data_po_form.length; n++) {

                                                var form_data_po = {
                                                    ID_PO: data_po_form[n].ID_PO
                                                };
                                                $.ajax({
                                                    url: "<?php echo site_url('SPPB_form/data_po_by_id_po') ?>",
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    async: false,
                                                    data: form_data_po,
                                                    success: function (data) {
                                                        var data_po_induk = data;

                                                        html_po +='<a href="<?php echo base_url() ?>PO_form/view/'+ data_po_induk[0].HASH_MD5_PO +'" class="btn btn-primary btn-xs block"><i class="fa fa-eye"></i>'+ data_po_induk[0].NO_URUT_PO +'</a> Qty:'+ data_po_form[n].JUMLAH_BARANG  +' ' + data_po_form[n].SATUAN_BARANG + '<br>' ;
                                                    }
                                                });

                                            }
                                            html_po += ' </td>';
                                            
                                        }
                                    });

                                    html += html_po;

                                    html_fstb = '';

                                    $.ajax({
                                        url: "<?php echo site_url('SPPB_form/data_fstb_form_by_id_sppb_form') ?>",
                                        type: "POST",
                                        dataType: "JSON",
                                        async: false,
                                        data: form_data,
                                        success: function (data) {
                                            var data_fstb_form = data;
                                            
                                            html_fstb += '<td>';
                                            for (p = 0; p < data_fstb_form.length; p++) {

                                                var form_data_fstb = {
                                                    ID_FSTB: data_fstb_form[p].ID_FSTB
                                                };
                                                $.ajax({
                                                    url: "<?php echo site_url('SPPB_form/data_fstb_by_id_fstb') ?>",
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    async: false,
                                                    data: form_data_fstb,
                                                    success: function (data) {
                                                        var data_fstb_induk = data;

                                                        html_fstb +='<a href="<?php echo base_url() ?>FSTB_form/view/'+ data_fstb_induk[0].HASH_MD5_FSTB +'" class="btn btn-primary btn-xs block"><i class="fa fa-eye"></i>'+ data_fstb_induk[0].NO_URUT_FSTB +'</a> Qty Diterima:'+ data_fstb_form[p].JUMLAH_DITERIMA  +' ' + data_fstb_form[p].SATUAN_BARANG + '<br>' +'</a> Qty Diterima Bersyarat:'+ data_fstb_form[p].JUMLAH_DITERIMA_SYARAT  +' ' + data_fstb_form[p].SATUAN_BARANG + '<br>' ;
                                                    }
                                                });

                                            }
                                            html_fstb += ' </td>';
                                            
                                        }
                                    });

                                    html += html_fstb;

                                    html += '</tr>';
                                }
                            }
                        });
                        $('#show_data').html(html);
                    }
                    
                }
            });
        }

    });
</script>

</body>

</html>