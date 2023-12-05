<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form RASD</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/RASD/') ?>">RASD</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form RASD</a>
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
        Sistem menampilkan seluruh isi RASD Proyek.
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian RASD Proyek</h5>
        </div>
        <div class="ibox-content">
            <form method="get" class="form-horizontal">
                <?php
                if (isset($rasd)) {
                    foreach ($rasd->result() as $rasd) :
                ?>
                        <div class="form-group"><label class="col-sm-2 control-label">Nama Proyek</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rasd->NAMA_PROYEK; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Jenis Pekerjaan</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rasd->NAMA_SUB_PEKERJAAN; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Kategori RAB</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $rasd->NAMA_KATEGORI; ?>" disabled>
                            </div>
                        </div>
                <?php endforeach;
                } ?>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>RASD Item Barang</h5>
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
                                    <!-- <th>Status Barang</th> -->
                                    <th>Nama</th>
                                    <th>Merek Barang</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Satuan Barang</th>
                                    <th>Jumlah</th>
                                    <th>Unit Price</th>
                                    <th>Total Harga</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    <br>
                    <a href="#" class="btn btn-primary " data-toggle="modal" data-target="#ModalAddTanpaBarangMaster"><span class="fa fa-plus"></span> Tambah Data</a>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD BUKAN DARI MASTER LIST -->
<div class="modal inmodal fade" id="ModalAddTanpaBarangMaster" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">RASD Form Item Barang</h4>
                <small class="font-bold">Silakan isi data RASD</small>
            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("RASD_form/simpan_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA_4" id="NAMA_4" class="form-control" type="text" placeholder="Contoh: Crane" required autofocus>
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_4" id="MEREK_4" class="form-control" type="text" placeholder="Contoh: Toyota" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_4" id="SPESIFIKASI_SINGKAT_4" class="form-control" type="text" placeholder="Contoh: Crane Toyota 4 ton, 12 roda" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <select name="SATUAN_BARANG_4" class="form-control" id="SATUAN_BARANG_4">
                                <option value=''>- Pilih Satuan Barang -</option>
                                <?php foreach ($satuan_barang_list as $item) {
                                    echo '<option value="' . $item->ID_SATUAN_BARANG . '">' . $item->NAMA_SATUAN_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="JUMLAH_BARANG_4" id="JUMLAH_BARANG_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Satuan Barang (Unit Price)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_FIX4" id="HARGA_SATUAN_BARANG_FIX4" class="form-control" type="text" placeholder="Contoh: Rp 2000000 ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Total Barang</label>
                        <div class="col-xs-9">

                            <input name="HARGA_TOTAL_FIX4" id="HARGA_TOTAL_FIX4" class="form-control" type="hidden" placeholder="Contoh: Rp 14000000 " disabled />
                            <input name="HARGA_TOTAL_TAMPIL4" id="HARGA_TOTAL_TAMPIL4" class="form-control" type="text" placeholder="Contoh: Rp 14000000 " disabled>
                        </div>
                    </div>

                    <div id="alert-msg1"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL ADD BUKAN DARI MASTER LIST-->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">RASD Item Barang</h4>
                <small class="font-bold">Silakan edit data RASD item barang</small>
            </div>
            <?php $attributes = array("ID_RASD_FORM2" => "contact_form", "id" => "contact_form");
            echo form_open("RASD_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_RASD_FORM2" id="ID_RASD_FORM2" class="form-control" type="hidden" placeholder="ID rasd barang" readonly>

                    <input name="ID_BARANG_MASTER2" id="ID_BARANG_MASTER2" class="form-control" placeholder="Barang belum ada di Master List" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA2" id="NAMA2" class="form-control" type="text"placeholder="Contoh: Crane" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK2" id="MEREK2" class="form-control" type="text" placeholder="Contoh: Toyota" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT2" id="SPESIFIKASI_SINGKAT2" class="form-control" type="text" placeholder="Contoh: Crane Toyota 4 ton, 12 roda" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <select name="SATUAN_BARANG2" class="form-control" id="SATUAN_BARANG2">
                                <option value=''>- Pilih Satuan Barang -</option>
                                <?php foreach ($satuan_barang_list as $item) {
                                    echo '<option value="' . $item->ID_SATUAN_BARANG . '">' . $item->NAMA_SATUAN_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG2" id="JUMLAH_BARANG2" class="form-control touchspin1" type="number">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Satuan Barang (Unit Price)'</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_FIX2" id="HARGA_SATUAN_BARANG_FIX2" class="form-control" type="text" placeholder="Contoh: Rp 2000000 ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Total Barang</label>
                        <div class="col-xs-9">

                            <input name="HARGA_TOTAL_FIX2" id="HARGA_TOTAL_FIX2" class="form-control" type="hidden" placeholder="Contoh: Rp 14000000 " disabled />
                            <input name="HARGA_TOTAL_TAMPIL2" id="HARGA_TOTAL_TAMPIL2" class="form-control" type="text" placeholder="Contoh: Rp 14000000 " disabled>
                        </div>
                    </div>

                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Update</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Data RASD Item Barang</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
                        <div name="NAMA_BARANG3" id="NAMA_BARANG3"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn_hapus btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL HAPUS-->




<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- TouchSpin -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    function goBack() {
        window.history.back();
    }
    $(document).ready(function() {
        var ID_RASD = <?php echo $ID_RASD  ?>;
        var ID_PROYEK_SUB_PEKERJAAN = <?php echo $ID_PROYEK_SUB_PEKERJAAN  ?>;
        tampil_data_RASD_form(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            ordering: false,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            order: [
                [2, "asc"]
            ],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {
                    extend: 'excel',
                    title: 'RASD Item Barang'
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


        $("#checkAllbarangmaster").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        //fungsi tampil data
        function tampil_data_RASD_form() {
            var RENCANA_ANGGARAN = 0;
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>RASD_form/data_RASD_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_RASD
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_BARANG;
                        let kode_barang = data[i].KODE_BARANG;
                        if (jumlah_barang == null) {
                            jumlah_barang = 0;
                        }
                        if (kode_barang != null) {
                            kode_barang_cetak = '<a href="<?php echo base_url() ?>barang_master/profil_barang_master/' + data[i].HASH_MD5_BARANG_MASTER + '" target="_blank" class="btn btn-warning btn-xs btn-outline block"><i class="fa fa-eye"></i> ' + kode_barang + ' </a>';
                        }
                        if (kode_barang == null) {
                            kode_barang_cetak = '<span class="label label-info block"><i class="fa fa-warning"></i> Data Baru</span>';
                        }

                        var HARGA_BARANG = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data[i].HARGA_BARANG);

                        var TOTAL_HARGA = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data[i].HARGA_BARANG * jumlah_barang);

                        html += '<tr>' +
                            '<td>' + data[i].NAMA + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                            '<td>' + jumlah_barang + '</td>' +
                            '<td>' + HARGA_BARANG + '</td>' +
                            '<td>' + TOTAL_HARGA + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_RASD_FORM + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_RASD_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' +
                            '</td>' +
                            '</tr>';
                        RENCANA_ANGGARAN += (data[i].HARGA_BARANG * jumlah_barang);


                    }
                    RENCANA_ANGGARAN = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(RENCANA_ANGGARAN);
                    html += '<tr>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + '' + '</td>' +
                        '<td>' + 'Total Rencana Anggaran' + '</td>' +
                        '<td>' + RENCANA_ANGGARAN + '</td>' +
                        '<td>' + '' + '</td>' +
                        '</tr>';
                    $('#show_data').html(html);
                }
            });
        }

        $("#HARGA_SATUAN_BARANG_FIX2").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
            var JUMLAH = $("#JUMLAH_BARANG2").val();

            var TOTAL = HARGA * JUMLAH;

            $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });

        $("#JUMLAH_BARANG2").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX2").val();
            var JUMLAH = $("#JUMLAH_BARANG2").val();

            var TOTAL = HARGA * JUMLAH;

            $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });

        $("#HARGA_SATUAN_BARANG_FIX4").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX4").val();
            var JUMLAH = $("#JUMLAH_BARANG_4").val();

            var TOTAL = HARGA * JUMLAH;

            $('[name="HARGA_TOTAL_FIX4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });

        $("#JUMLAH_BARANG_4").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX4").val();
            var JUMLAH = $("#JUMLAH_BARANG_4").val();

            var TOTAL = HARGA * JUMLAH;

            $('[name="HARGA_TOTAL_FIX4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });

        //GET UPDATE
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('RASD_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {

                    console.log(data);
                    $('#ModalEdit').modal('show');
                    $('[name="ID_RASD_FORM2"]').val(data.ID_RASD_FORM);
                    $('[name="ID_BARANG_MASTER2"]').val(data.ID_BARANG_MASTER);
                    $('[name="NAMA2"]').val(data.NAMA_MASTER);
                    $('[name="MEREK2"]').val(data.MEREK_MASTER);
                    $('[name="SATUAN_BARANG2"]').val(data.ID_SATUAN_BARANG);
                    $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_BARANG);
                    $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);

                    var HARGA = data.HARGA_BARANG;
                    var JUMLAH = data.JUMLAH_BARANG;
                    var TOTAL = HARGA * JUMLAH;

                    $('[name="HARGA_TOTAL_FIX2"]').val(TOTAL);
                    $('[name="HARGA_TOTAL_TAMPIL2"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(TOTAL));

                    $('[name="HARGA_SATUAN_BARANG_FIX2"]').val(HARGA);
                    $('#alert-msg-2').html('<div></div>');

                }
            });
            return false;
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('index.php/RASD_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $.each(data, function(NAMA, MEREK) {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(id);
                        $('#NAMA_BARANG3').html('Nama Barang: ' + data.NAMA_MASTER);
                    });
                }
            });
        });

        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999
        });

        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            var form_data = {
                ID_RASD: ID_RASD,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
                HARGA_BARANG: $('#HARGA_SATUAN_BARANG_FIX4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('RASD_form/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg1').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $('#ModalAdd').modal('hide');
                        window.location.reload();
                    }
                }
            });
            return false;
        });

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            let ID_RASD_FORM = $('#ID_RASD_FORM2').val();
            let ID_BARANG_MASTER = $('#ID_BARANG_MASTER2').val();
            let NAMA = $('#NAMA2').val();
            let MEREK = $('#MEREK2').val();
            let SPESIFIKASI_SINGKAT = $('#SPESIFIKASI_SINGKAT2').val();
            let SATUAN_BARANG = $('#SATUAN_BARANG2').val();
            let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
            let HARGA_BARANG= $('#HARGA_SATUAN_BARANG_FIX2').val();

                $.ajax({
                    url: "<?php echo site_url('RASD_form/update_data') ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        ID_RASD: ID_RASD,
                        ID_RASD_FORM: ID_RASD_FORM,
                        ID_BARANG_MASTER: ID_BARANG_MASTER,
                        NAMA: NAMA,
                        MEREK: MEREK,
                        SPESIFIKASI_SINGKAT: SPESIFIKASI_SINGKAT,
                        SATUAN_BARANG: SATUAN_BARANG,
                        JUMLAH_BARANG: JUMLAH_BARANG,
                        HARGA_BARANG: HARGA_BARANG,
                    },
                    success: function(data) {
                        if (data == true) {
                            $('#ModalEdit').modal('hide');
                            window.location.reload();
                        } else {
                            $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
                        }
                    }
                });
            return false;
        });

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('RASD_form/hapus_data') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    $('#ModalHapus').modal('hide');
                    // tampil_data_jenis_barang();
                    window.location.reload();
                }
            });
            return false;
        });
    });
</script>

</body>

</html>