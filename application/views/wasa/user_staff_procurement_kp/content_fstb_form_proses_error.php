<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Ubah FSTB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/FSTB/') ?>">FSTB</a>
            </li>
            <li class="active">
                <strong>
                    <a>Ubah FSTB</a>
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

    <!-- Identitas Form FSTB -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Form Serah Terima Barang</h5>
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

                    <li class=""><a data-toggle="tab" href="#tab-2">Catatan FSTB</a></li>

                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form method="get" class="form-horizontal">
                                <?php
                                if (isset($FSTB)) {
                                    foreach ($FSTB->result() as $FSTB) :
                                ?>
                                        <hr>
                                        <div class="form-group"><label class="col-sm-2 control-label">No Urut:</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $FSTB->NO_URUT_FSTB; ?>" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pembuatan FSTB :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $FSTB->TANGGAL_PENGAJUAN_FSTB; ?>" disabled>
                                            *tanggal pengajuan akan berubah sesuai dengan tanggal aktual pengajuan FSTB
                                            </div>
                                            
                                        </div>

                                <?php endforeach;
                                } ?>
                            </form>
                        </div>
                    </div>
                    <div id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <div class="stream">
                                <div class="stream-badge">
                                    <i class="fa fa-circle"></i>
                                </div>
                                <div class="stream-panel">
                                    <div class="stream-info">
                                        <a href="#">
                                            <span>Catatan STAFF:</span>
                                        </a>
                                    </div>
                                    <?php echo $CATATAN_FSTB['CTT_STAFF_LOG']; ?>
                                </div>
                            </div>
                            </br>
                            <div class="hr-line-dashed"></div>

                            <a href="javascript:;" id="item_edit_catatan_fstb" name="item_edit_catatan_fstb" class="btn btn-warning" data="<?php echo $ID_FSTB; ?>"><i class="fa fa-comment"></i> Berikan Catatan FSTB </a>

                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
    <!-- End Identitas Form FSTB -->

    <!-- Form FSTB -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>FSTB Item Barang/Jasa</h5>
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

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <!-- <th>Status Barang</th> -->
                                    <th>Nama Barang</th>
                                    <th>Merek Barang</th>
                                    <th>Jumlah Diterima</th>
                                    <th>Jumlah Ditolak</th>
                                    <th>Jumlah Diterima dengan Syarat</th>
                                    <th>Satuan Barang</th>
                                    <th>Gambar</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    </br>
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddDariRasdBarang"><span class="fa fa-plus"></span> Tambah Item dari PO</a><br>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Tambah Item dari Peminjaman</a><br>
                    <a href="#" class="btn btn-info" data-toggle="modal" data-target="#ModalAddNew"><span class="fa fa-plus"></span> Tambah Item Baru</a>
                </div>

            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="sm-10">
                            <a href="<?php echo base_url('index.php/FSTB_form/view/'); ?><?php echo $HASH_MD5_FSTB; ?>" class="btn btn-primary"><span class="fa fa-save"></span> Simpan Perubahan &  View Dokumen FSTB</a>
                            </br>
                            <a href="javascript:;" id="item_edit_kirim_fstb" name="item_edit_kirim_fstb" class="btn btn-warning" data="<?php echo $ID_FSTB; ?>"><span class="fa fa-send"></span> Ajukan FSTB</a><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Form FSTB -->
</div>

<!-- MODAL SIMPAN FSTB -->
<div class="modal inmodal fade" id="ModalFSTB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-save modal-icon"></i>
                <h4 class="modal-title">Simpan FSTB</h4>
                <small class="font-bold">Silakan isi catatan FSTB dan Simpan Perubahan</small>
            </div>
            <!-- exclamation-triangle -->
            <div class="form-horizontal">
                <div class="modal-body">

                    <form method="POST" action="<?php echo site_url('FSTB/simpan_perubahan_fstb'); ?>" id="formSimpanFSTB">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control h-200" name="CTT" id="CTT" placeholder="Contoh : Barang ini sangat diperlukan segera di lapangan" required></textarea>
                                <input name="ID_FSTB" class="form-control" type="text" value="<?php echo $ID_FSTB  ?>" style="display: none;" readonly>
                            </div>
                        </div>
                    </form>
                    <div id="alert-msg"></div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" type="submit" form="formSimpanFSTB"><i class="fa fa-save"></i> Tambah</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>STATUS_FSTB
    </div>
</div>
<!-- END MODAL SIMPAN FSTB -->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Ubah Item Barang/Jasa FSTB</h4>
                <small class="font-bold">Silakan edit item barang/jasa FSTB</small>
            </div>
            <?php $attributes = array("ID_FSTB_barang2" => "contact_form", "id" => "contact_form");
            echo form_open("FSTB_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_FSTB_FORM2" id="ID_FSTB_FORM2" class="form-control" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA2" id="NAMA2" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="Merek2" id="Merek2" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Diterima</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_DITERIMA2" id="JUMLAH_DITERIMA2" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Ditolak</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_DITOLAK2" id="JUMLAH_DITOLAK2" class="form-control touchspin1" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Diterima Syarat</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_DITERIMA_SYARAT2" id="JUMLAH_DITERIMA_SYARAT2" class="form-control" type="date">
                            (mm/dd/yyyy)
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Gambar FSTB Barang</label>
                        <div class="col-xs-9">
                            <input name="GAMBAR_FSTB_BARANG2" id="GAMBAR_FSTB_BARANG2" class="form-control" type="date">
                            (mm/dd/yyyy)
                        </div>
                        
                    </div>
                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Ubah</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->

<!-- MODAL EDIT CATATAN FSTB-->
<div class="modal inmodal fade" id="ModalEditCatatanFSTB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Catatan FSTB</h4>
                <small class="font-bold">Silakan berikan komentar atau catatan mengenai Form FSTB ini</small>
            </div>
            <?php $attributes = array("ID_FSTB6" => "contact_form", "id" => "contact_form");
            echo form_open("FSTB_form/update_data_catatan_fstb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_FSTB6" id="ID_FSTB6" class="form-control" type="hidden" placeholder="ID FSTB" readonly>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Catatan FSTB</label>

                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="CTT_STAFF_LOG6" id="CTT_STAFF_LOG6" required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-6"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_catatan_fstb"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT CATATAN FSTB-->

<!-- MODAL KIRIM FSTB-->
<div class="modal inmodal fade" id="ModalEditKirimFSTB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim FSTB</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form FSTB ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_FSTB7" => "contact_form", "id" => "contact_form");
            echo form_open("FSTB_form/update_data_kirim_fstb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_FSTB7" id="ID_FSTB7" class="form-control" type="hidden" placeholder="ID FSTB" readonly>


                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melalukan proses form FSTB ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_fstb" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM FSTB-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 80vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa FSTB</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus item barang/jasa ini?</p>
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
    $(document).ready(function() {
        let ID_FSTB = <?php echo $ID_FSTB  ?>;
        tampil_data_fstb_form(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 100,
            responsive: true,
            order: [[ 2, "asc" ]],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                    extend: 'copy'
                },
                {
                    extend: 'csv'
                },
                {
                    extend: 'excel',
                    title: 'FSTB'
                },
                {
                    extend: 'pdf',
                    title: 'FSTB'
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
        $('#modalrasd').dataTable();

        //fungsi tampil data
        function tampil_data_fstb_form() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>FSTB_form/data_fstb_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_FSTB
                },
                
                success: function(data) {
                    console.log(ID_FSTB);
                    var html = '';
                    var i;
                    
                    for (i = 0; i < data.length; i++) {
                        
                        html += '<tr>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].JUMLAH_DITERIMA + '</td>' +
                            '<td>' + data[i].JUMLAH_DITOLAK + '</td>' +
                            '<td>' + data[i].JUMLAH_DITERIMA_SYARAT + '</td>' +
                            '<td>' + data[i].GAMBAR_FSTB_BARANG + '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        // SIMPAN FSTB DAN KEMBALI KE FSTB LIST // BELUM CEK
        $('#btn_simpan_fstb').on('click', function() {
            let ID_FSTB = ID_FSTB;
            let CTT = $('#CTT').val();

        })

        //GET UPDATE untuk edit jumlah
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FSTB_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEdit').modal('show');
                        $('[name="NAMA2"]').val(data.NAMA_BARANG);
                        $('[name="MEREK2"]').val(data.MEREK);
                        $('[name="JUMLAH_DITERIMA2"]').val(data.JUMLAH_DITERIMA);
                        $('[name="JUMLAH_DITOLAK2"]').val(data.JUMLAH_DITOLAK);
                        $('[name="JUMLAH_DITERIMA_SYARAT2"]').val(data.JUMLAH_DITERIMA_SYARAT);
                        $('[name="GAMBAR_FSTB_BARANG2"]').val(data.GAMBAR_FSTB_BARANG);
                        $('#alert-msg-2').html('<div></div>');
                    });
                }
            });
            return false;
        });


        $('.edit').click(function() {
            // Hide input element
            $('.txtedit').hide();

            // Show next input element
            $(this).next('.txtedit').show().focus();

            // Hide clicked element
            $(this).hide();
        });

        // Focus out from a textbox
        $('.txtedit').focusout(function() {
            // Get edit id, field name and value
            var edit_id = $(this).data('id');
            var fieldname = $(this).data('field');
            var value = $(this).val();

            // assign instance to element variable
            var element = this;

            // Send AJAX request
            $.ajax({
                url: "<?php echo base_url('FSTB_form/update_data_tanggal') ?>",
                type: 'POST',
                data: {
                    field: fieldname,
                    value: value,
                    id: edit_id
                },
                success: function(response) {
                    // Hide Input element
                    $(element).hide();

                    // Update viewing value and display it
                    $(element).prev('.edit').show();
                    $(element).prev('.edit').text(value);
                }
            });
        });


        item_edit_catatan_fstb.onclick = function() {
            var id = $(this).attr('data');
            console.log(id);
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FSTB_form/get_data_catatan_fstb') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditCatatanFSTB').modal('show');
                        $('[name="ID_FSTB6"]').val(data.ID_FSTB);
                        $('[name="CTT_STAFF_LOG6"]').val(data.CTT_STAFF_LOG);

                        $('#alert-msg-6').html('<div></div>');
                    });
                }
            });
            return false;
        };

        item_edit_kirim_fstb.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FSTB_form/get_data_catatan_fstb') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditKirimFSTB').modal('show');
                        $('[name="ID_FSTB7"]').val(data.ID_FSTB);

                        $('#alert-msg-7').html('<div></div>');
                    });
                }
            });
            return false;
        };

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_fstb').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_fstb').attr('disabled', true); //disable input
            }
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FSTB_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(id);
                        $('#NAMA_3').html('</br>Nama Barang : ' + data.NAMA_BARANG);

                    });
                }
            });
        });

        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999,
        });

        //SIMPAN DATA
        $('#btn_simpan_data_di_luar_barang_master').click(function() {
            var form_data = {
                ID_FSTB: ID_FSTB,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('FSTB_form/simpan_data_di_luar_barang_master'); ?>",
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

            let ID_FSTB_FORM = $('#ID_FSTB_FORM2').val();
            let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
            let TANGGAL_MULAI_PAKAI = $('#TANGGAL_MULAI_PAKAI2').val();
            let TANGGAL_SELESAI_PAKAI = $('#TANGGAL_SELESAI_PAKAI2').val();
            $.ajax({
                url: "<?php echo site_url('FSTB_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FSTB_FORM: ID_FSTB_FORM,
                    JUMLAH_BARANG: JUMLAH_BARANG,
                    TANGGAL_MULAI_PAKAI: TANGGAL_MULAI_PAKAI,
                    TANGGAL_SELESAI_PAKAI: TANGGAL_SELESAI_PAKAI
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

        //UPDATE JUSTIFIKASI BARANG 
        $('#btn_update_justifikasi_barang').on('click', function() {

            let ID_FSTB_FORM = $('#ID_FSTB_FORM5').val();
            let JUSTIFIKASI_CHIEF = $('#JUSTIFIKASI_CHIEF5').val();
            $.ajax({
                url: "<?php echo site_url('FSTB_form/update_data_justifikasi_barang') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FSTB_FORM: ID_FSTB_FORM,
                    JUSTIFIKASI_CHIEF: JUSTIFIKASI_CHIEF
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditJustifikasiBarang').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //UPDATE CATATAN FSTB 
        $('#btn_update_catatan_fstb').on('click', function() {

            let ID_FSTB = $('#ID_FSTB6').val();
            let CTT_STAFF_LOG = $('#CTT_STAFF_LOG6').val();
            $.ajax({
                url: "<?php echo site_url('FSTB_form/update_data_catatan_fstb') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FSTB: ID_FSTB,
                    CTT_STAFF_LOG: CTT_STAFF_LOG
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditCatatanFSTB').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //UPDATE KIRIM FSTB 
        $('#btn_update_kirim_fstb').on('click', function() {

            let ID_FSTB = $('#ID_FSTB7').val();
            $.ajax({
                url: "<?php echo site_url('FSTB_form/update_data_kirim_fstb') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FSTB: ID_FSTB,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimFSTB').modal('hide');
                        window.location.href = '<?php echo site_url('FSTB') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
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
                url: "<?php echo base_url('FSTB_form/hapus_data') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    $('#ModalHapus').modal('hide');
                    window.location.reload();
                }
            });
            return false;
        });
    });
</script>

<style type="text/css">
    .txtedit {
        display: none;
        width: 98%;
    }
</style>

</body>

</html>