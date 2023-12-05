<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Sppb Barang</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a onclick="goBack()">Sppb</a>
            </li>
            <li class="active">
                <strong>
                    <a>Sppb Barang</a>
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
        Sistem menampilkan seluruh sppb barang.
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian Item Sppb</h5>
        </div>
        <div class="ibox-content">
            <form method="get" class="form-horizontal">
                <?php
                if (isset($sppb)) {
                    foreach ($sppb->result() as $sppb) :
                ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Form No :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="WME/FSPPB/01" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">SOP No :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="WME/SOP/FHS-PL/01" disabled />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Departemen :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="Procurement & Logistik" disabled />
                            </div>
                        </div>
                        <hr>
                        <input style="display:none" type="text" class="form-control" name="ID_RASD" id="ID_RASD" value="<?php echo $sppb->ID_RASD; ?>">
                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $sppb->NAMA_PROYEK; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Jenis Pekerjaan :</label>
                            <div class="col-sm-10">
                                <?php if ($sppb->JENIS_PEKERJAAN == "mainwork") {
                                ?>
                                    <div class="col-xs-2">
                                        <label><input type="radio" checked value="mainwork" id="mainwork" name="KERJA" disabled>&nbsp; Main Work</label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label> <input type="radio" value="additional" id="additional" name="KERJA" disabled>
                                            &nbsp; Addtional</label>
                                    </div>
                                <?php
                                } else { ?>
                                    <div class="col-xs-2">
                                        <label><input type="radio" value="mainwork" id="mainwork" name="KERJA" disabled>&nbsp; Main Work</label>
                                    </div>
                                    <div class="col-xs-2">
                                        <label> <input type="radio" checked value="additional" id="additional" name="KERJA" disabled>
                                            &nbsp; Addtional</label>
                                    </div>
                                <?php } ?>
                                <input type="text" id="PEKERJAAN" name="PEKERJAAN" style="display: none;">
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">No Urut :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $sppb->NO_URUT_SPPB; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pembuatan :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $sppb->TANGGAL_PEMBUATAN_SPPB_HARI; ?>" disabled>
                                <a href='javascript:;' onclick='goToRasdBarang();'>Lihat RASD Proyek</a>
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
                    <h5>Sppb Item List</h5>
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
                                    <th>Kode Barang</th>
                                    <th>Nama</th>
                                    <th>Merek Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Satuan Barang</th>
                                    <th>RASD</th>
                                    <th>Stok Gudang Pusat</th>
                                    <th>Stok Gudang Proyek</th>
                                    <th>Total Pengadaan s/d Saat Ini</th>
                                    <th>Jumlah Yang Diminta</th>
                                    <th>Jumlah Yang Disetujui</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                </div>

            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="sm-10">
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalSPPB"><span class="fa fa-save"></span> Proses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL SIMPAN SPPB -->
<div class="modal inmodal fade" id="ModalSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 40vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-save modal-icon"></i>
                <h4 class="modal-title">Ajukan Sppb</h4>
                <small class="font-bold">Silakan isi catatan Sppb dan ajukan SPPB</small>
            </div>
            <!-- exclamation-triangle -->
            <div class="form-horizontal">
                <div class="modal-body">

                    <form method="POST" action="<?php echo site_url('sppb/simpan_ajuan_akhir'); ?>" id="formSimpanSPPB">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <textarea class="form-control h-200" name="CTT" id="CTT" placeholder="Contoh : Barang ini sangat diperlukan segera di lapangan" required></textarea>
                                <input name="ID_SPPB" class="form-control" type="text" value="<?php echo $id_sppb  ?>" style="display: none;" readonly>
                            </div>
                        </div>
                    </form>
                    <div id="alert-msg"></div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" type="submit" form="formSimpanSPPB"><i class="fa fa-save"></i> Simpan Sebagai Ajuan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!-- END MODAL SIMPAN SPPB -->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Sppb Barang</h4>
                <small class="font-bold">Silakan isi atau ubah jumlah yang ingin disetujui</small>
            </div>
            <?php $attributes = array("id_sppb_barang2" => "contact_form", "id" => "contact_form");
            echo form_open("sppb_barang/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-xs-3">ID Sppb Barang</label>
                        <div class="col-xs-9">
                            <input name="ID_SPPB_BARANG2" id="ID_SPPB_BARANG2" class="form-control" type="text" placeholder="ID sppb barang" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang Rasd</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_RASD2" id="JUMLAH_RASD2" class="form-control touchspin1" type="number" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Minta</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_MINTA2" id="JUMLAH_MINTA2" class="form-control touchspin1" type="number" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Setuju</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_SETUJU_TERAKHIR2" id="JUMLAH_SETUJU_TERAKHIR2" class="form-control touchspin1" type="number">
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

<!-- MODAL TOLAK -->
<div class="modal inmodal fade" id="ModalTolak" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Tolak Barang</h4>
                <small class="font-bold">Silakan pilih setuju atau tolak barang</small>
            </div>
            <?php $attributes = array("id_sppb_barang2" => "contact_form", "id" => "contact_form");
            echo form_open("sppb_barang/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">ID Sppb Barang</label>
                        <div class="col-xs-9">
                            <input name="ID_SPPB_BARANG_3" id="ID_SPPB_BARANG_3" class="form-control" type="text" placeholder="ID sppb barang" readonly>
                        </div>
                    </div>

                    <div class="form-group"><label class="col-xs-3 control-label">Ubah Status :</label>
                        <div class="col-xs-9">
                            <select name="CORET" class="form-control" id="CORET">
                                <option value=''>- Pilih -</option>
                                <option value="0">Setuju</option>
                                <option value="1">Tolak</option>
                            </select>
                        </div>
                    </div>
                    <div id="alert-msg-3"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_tolak"><i class="fa fa-save"></i> Update</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL TOLAK-->



<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- TouchSpin -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<!-- Switchery Toggle -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/switchery/switchery.js"></script>


<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    function goBack() {
        window.history.back();
    }

    function goToRasdBarang() {
        let id_rasd = $('#ID_RASD').val();
        if (id_rasd) {
            window.open("<?php echo base_url(); ?>rasd_barang/view/" + id_rasd)
        } else {
            $('#alert-msg').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> Pastikan anda pilih lokasi untuk melihat barang RASD </div>');
        }
    }

    function tolak() {
        console.log("masuk");
    }

    $(document).ready(function() {


        let id_sppb = <?php echo $id_sppb  ?>;
        tampil_data_sppb_barang(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 25,
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
                    title: 'Sppb Barang'
                },
                {
                    extend: 'pdf',
                    title: 'Sppb Barang'
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
        function tampil_data_sppb_barang() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>sppb_barang/data_sppb_barang',
                async: false,
                dataType: 'json',
                data: {
                    id: id_sppb
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_rasd = data[i].JUMLAH_RASD;
                        let jumlah_barang = data[i].JUMLAH_MINTA;
                        let kode_barang = data[i].KODE_BARANG;
                        let jumlah_setuju = data[i].JUMLAH_SETUJU_TERAKHIR;
                        let coret = '';
                        let disabled = '';
                        if (kode_barang == null) {
                            kode_barang = `<span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span>`;
                        }
                        if (data[i].CORET != null && data[i].CORET == 1) {
                            coret = `todo-completed`;
                            disabled = `disabled`
                        }
                        if (jumlah_rasd == null) {
                            jumlah_rasd = 0;
                        }
                        if (jumlah_setuju == null) {
                            jumlah_setuju = 0;
                        }
                        html += '<tr class="' + coret + '">' +
                            '<td>' + kode_barang + '</td>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].NAMA_JENIS_BARANG + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].NAMA_SATUAN_BARANG + '</td>' +
                            '<td>' + jumlah_rasd + '</td>' +
                            '<td> 0 </td>' +
                            '<td> 0 </td>' +
                            '<td><span class="label label-warning"><i class="fa fa-warning"></i> Belum ada </span></td>' +
                            '<td>' + jumlah_barang + '</td>' +
                            '<td>' + jumlah_setuju + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="' + data[i].ID_SPPB_BARANG + '"><i class="fa fa-pencil"></i> proses </a>' +
                            '<a href="javascript:;" class="btn btn-danger btn-xs item_tolak" data="' + data[i].ID_SPPB_BARANG + '"><i class="fa fa-ban"></i> Tolak</a>' +
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
                url: "<?php echo base_url('sppb_barang/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('#ModalaEdit').modal('show');

                    $('[name="ID_SPPB_BARANG2"]').val(id);
                    $('[name="JUMLAH_RASD2"]').val(data.JUMLAH_RASD);
                    if (data.JUMLAH_SETUJU_TERAKHIR == null) {
                        $('[name="JUMLAH_SETUJU_TERAKHIR2"]').val(0);
                    } else {
                        $('[name="JUMLAH_SETUJU_TERAKHIR2"]').val(data.JUMLAH_SETUJU_TERAKHIR);
                    }
                    $('[name="JUMLAH_MINTA2"]').val(data.JUMLAH_MINTA);
                    $('#alert-msg-2').html('<div></div>');
                }
            });
            return false;
        });

        //GET TOLAK
        $('#show_data').on('click', '.item_tolak', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('sppb_barang/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function(ID_JENIS_BARANG, NAMA_JENIS_BARANG) {
                        $('#ModalTolak').modal('show');
                        $('[name="ID_SPPB_BARANG_3"]').val(id);
                        if (data.CORET == null) {
                            $('[name="CORET"]').val(0);
                        } else {
                            $('[name="CORET"]').val(data.CORET);
                        }
                        $('#alert-msg-3').html('<div></div>');

                    });
                }
            });
        });

        //UPDATE DATA 
        $('#btn_update').on('click', function() {
            $.ajax({
                url: "<?php echo site_url('sppb_barang/update_data_proses') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPPB_BARANG: $('#ID_SPPB_BARANG2').val(),
                    JUMLAH_SETUJU_TERAKHIR: $('#JUMLAH_SETUJU_TERAKHIR2').val()
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


        //UPDATE TOLAK 
        $('#btn_tolak').on('click', function() {
            $.ajax({
                url: "<?php echo site_url('sppb_barang/update_data_tolak') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPPB_BARANG: $('#ID_SPPB_BARANG_3').val(),
                    CORET: $('#CORET').val()
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


    });
</script>

</body>

</html>