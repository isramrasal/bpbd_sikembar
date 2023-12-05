<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Harga Barang Pemasok</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a onclick="goBack()">KHP Barang</a>
            </li>
            <li class="active">
                <strong>
                    <a>Harga Barang Pemasok</a>
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
        Sistem menampilkan seluruh harga barang pemasok.
    </div>

    <!-- <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian Harga Barang Pemasok</h5>
        </div>
        <div class="ibox-content">
            <form method="get" class="form-horizontal">
                <?php
                if (isset($sppb_barang)) {
                    foreach ($sppb_barang->result() as $sppb_barang) :
                ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Kode Barang :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo  $sppb_barang->KODE_BARANG; ?>" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nama Barang :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $sppb_barang->NAMA_BARANG; ?>" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Merek Barang :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $sppb_barang->MEREK; ?>" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jenis Barang :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="<?php echo $sppb_barang->NAMA_JENIS_BARANG; ?>" disabled />
                            </div>
                        </div>

                <?php endforeach;
                } ?>
            </form>
        </div>
    </div> -->

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>HBP Item</h5>
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
                                    <th>Nama Vendor</th>
                                    <th>Harga Barang Satuan</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                            </tbody>
                        </table>
                    </div>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalaAdd"><span class="fa fa-plus "> </span> Tambah Vendor </a>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#"><span class="fa fa-save "> </span> Simpan Data HBP </a>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-anchor modal-icon"></i>
                <h4 class="modal-title">Vendor</h4>
                <small class="font-bold">Silakan tambah data vendor</small>
            </div>
            <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
            echo form_open("vendor/simpan_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group"><label class="control-label col-xs-3">Nama Vendor :</label>
                        <div class="col-xs-9">
                            <select name="ID_VENDOR" class="form-control" id="ID_VENDOR">
                                <option value=''>- Pilih Vendor -</option>
                                <?php foreach ($vendor as $vendor) {
                                    echo '<option value="' . $vendor->ID_VENDOR . '">' . $vendor->NAMA_VENDOR . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Barang Satuan :</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_VENDOR" id="HARGA_SATUAN_VENDOR" class="form-control" type="number" placeholder="Contoh: 120000" required autofocus>
                        </div>
                    </div>
                    <div id="#alert-msg1"></div>

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
<!--END MODAL ADD-->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-anchor modal-icon"></i>
                <h4 class="modal-title">Vendor</h4>
                <small class="font-bold">Silakan edit data vendor</small>
            </div>
            <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
            echo form_open("hbp/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                <div class="form-group"><label class="control-label col-xs-3">Nama Vendor :</label>
                        <div class="col-xs-9">
                            <select name="ID_VENDOR2" class="form-control" id="ID_VENDOR2">
                                <option value=''>- Pilih Vendor -</option>
                                <?php foreach ($vendor as $vendor) {
                                    echo '<option value="' . $vendor->ID_VENDOR . '">' . $vendor->NAMA_VENDOR . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Barang Satuan :</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_VENDOR2" id="HARGA_SATUAN_VENDOR2" class="form-control" type="number" placeholder="Contoh: 120000" required autofocus>
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
                <h4 class="modal-title" id="myModalLabel">Hapus Data harga barang pemasok</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
                        <div name="NAMA_3" id="NAMA_3"></div>
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
        let id_khp_barang = <?php echo $id_khp_barang  ?>;
        console.log(id_khp_barang);
        tampil_data_khp_barang(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
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
                    title: 'Harga Barang Pemasok'
                },
                {
                    extend: 'pdf',
                    title: 'Harga Barang Pemasok'
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
        $('#modalmaster').dataTable();

        //fungsi tampil data
        function tampil_data_khp_barang() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>hbp/data_hbp_barang',
                async: false,
                dataType: 'json',
                data: {
                    id: id_khp_barang
                },
                success: function(data) {
                    console.log(data);
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<tr>' +
                            '<td>' + data[i].NAMA_VENDOR + '</td>' +
                            '<td>' + data[i].HARGA_SATUAN_VENDOR + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-info btn-xs item_edit block" data="' + data[i].ID_HBP + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block " data="' + data[i].ID_HBP + '"><i class="fa fa-trash"></i> Hapus</a>' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }

            });
        }

        //GET UPDATE
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('hbp/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {

                        $('#ModalaEdit').modal('show');
                        $('[name="ID_HBP2"]').val(data.ID_HBP);
                        $('[name="ID_KHP_BARANG2"]').val(data.ID_KHP_BARANG);
                        $('[name="ID_VENDOR2"]').val(data.ID_VENDOR);
                        $('[name="HARGA_SATUAN_VENDOR2"]').val(data.HARGA_SATUAN_VENDOR);
                        
                        $('#alert-msg-2').html('<div></div>');
                    });
                }
            });
            return false;
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('hbp/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(id);
                        if (data.ID_VENDOR != null) {
                            $('#NAMA_3').html('Nama Vendor : ' + data.NAMA_VENDOR);
                        } else {
                            $('#NAMA_3').html('Nama Vendor : ' + data.ID_VENDOR);
                        }
                    });
                }
            });
        });


        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            var form_data = {
                ID_KHP_BARANG: id_khp_barang,
                ID_VENDOR: $('#ID_VENDOR').val(),
                HARGA_SATUAN_VENDOR: $('#HARGA_SATUAN_VENDOR').val(),
            };
            console.log(form_data);
            $.ajax({
                url: "<?php echo site_url('hbp/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg1').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $('#ModalaAdd').modal('hide');
                        window.location.reload();
                    }
                }
            });
            return false;
        });

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            let ID_RASD_BARANG = $('#ID_RASD_BARANG2').val();
            let ID_BARANG_MASTER = $('#ID_BARANG_MASTER2').val();
            let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();

            $.ajax({
                url: "<?php echo site_url('hbp/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_RASD_BARANG: ID_RASD_BARANG,
                    ID_BARANG_MASTER: ID_BARANG_MASTER,
                    JUMLAH_BARANG: JUMLAH_BARANG
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalaEdit').modal('hide');
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
                url: "<?php echo base_url('hbp/hapus_data') ?>",
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