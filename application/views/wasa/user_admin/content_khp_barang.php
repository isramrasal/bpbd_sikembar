<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List KHP Barang</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a onclick="goBack()">KHP</a>
            </li>
            <li class="active">
                <strong>
                    <a>KHP Barang</a>
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
        Sistem menampilkan seluruh khp barang.
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian KHP Barang</h5>
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
                                <a href='javascript:;' onclick='goToRasdBarang();'>Lihat SPPB</a>
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
                    <h5>KHP Item</h5>
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
                                    <th>Nama Vendor Yang Terpilih</th>
                                    <th>Harga Satuan Vendor</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                            </tbody>
                        </table>
                    </div>

                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-save"></span> Buat SPP</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CHOOSE -->
<div class="modal inmodal fade" id="ModalPilih" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">Harga Barang Dari Pemasok</h4>
                <small class="font-bold">Silakan pilih vendor</small>
            </div>
            <!-- exclamation-triangle -->
            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="table-responsive">

                        <form method="POST" action="<?php echo site_url('khp_barang/update_data'); ?>" id="formTambah">
                            <table class="table table-striped table-bordered table-hover" id="tabelMaster">
                                <thead>
                                    <tr>
                                        <th>Pilih</th>
                                        <th>Nama Vendor</th>
                                        <th>Harga Satuan Vendor</th>
                                    </tr>
                                </thead>
                                <tbody id="show_data_hbp">
                                </tbody>
                            </table>

                        </form>
                    </div>
                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" type="submit" form="formTambah"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>

        </div>
    </div>
</div>
<!--END MODAL CHOOSE-->


<!-- MODAL CREATE SPP -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 50vw;">
        <div class="modal-content animated bounceInRight">
            <?php
            if ($create_spp != NULL) {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-suitcase modal-icon"></i>
                    <h4 class="modal-title">Sppb Barang</h4>
                    <small class="font-bold">Silakan isi data Sppb Barang</small>
                </div>
                <!-- exclamation-triangle -->
                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="table-responsive">

                            <form method="POST" action="<?php echo site_url('khp_barang/simpan_data_dari_barang_master'); ?>" id="formTambahMASTER">
                                <table class="table table-striped table-bordered table-hover" id="modalmaster">
                                    <thead>
                                        <tr>
                                            <th>Pilih</th>
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
                                            <th>Nama Vendor Yang Terpilih</th>
                                            <th>Harga Satuan Vendor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($create_spp as $data) : ?>
                                            <tr>
                                                <td>
                                                    <!-- <input name="ID_SPPB" class="form-control" type="text" value="<?php echo $id_sppb  ?>" style="display: none;" readonly>
                                                    <input class="checkbox" name="ID_BARANG_MASTER[]" value="<?php echo $data->ID_BARANG_MASTER ?>" type="checkbox"> -->
                                                </td>
                                                <td> <?php echo $data->KODE_BARANG; ?> </td>
                                                <td> <?php echo $data->NAMA_BARANG; ?> </td>
                                                <td> <?php echo $data->MEREK; ?> </td>
                                                <td> <?php echo $data->NAMA_JENIS_BARANG; ?> </td>
                                                <td> <?php echo $data->SPESIFIKASI_SINGKAT; ?> </td>
                                                <td> <?php echo $data->NAMA_SATUAN_BARANG; ?> </td>
                                                <td> <?php echo $data->JUMLAH_RASD; ?> </td>
                                                <td> 0 </td>
                                                <td> 0 </td>
                                                <td>  </td>
                                                <td> <?php echo $data->JUMLAH_MINTA; ?>  </td>
                                                <td> <?php echo $data->JUMLAH_SETUJU_TERAKHIR; ?> </td>
                                                <td>  </td>
                                                <td>  </td>
                                            </tr>
                                        <?php endforeach;
                                        ?>
                                    </tbody>
                                </table>

                            </form>
                        </div>
                        <div id="alert-msg"></div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                        <button class="btn btn-primary" type="submit" form="formTambahMASTER"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            <?php
            } else {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-exclamation-triangle modal-icon"></i>
                    <h4 class="modal-title">Sppb Barang</h4>
                    <b class="font-bold">Maaf semua barang master sudah ada di sppb barang ini</b>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!--END MODAL CREATE SPP-->



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
        let id_khp = <?php echo $id_khp  ?>;
        tampil_data_khp_barang(); //pemanggilan fungsi tampil data.

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
                    title: 'KHP Barang'
                },
                {
                    extend: 'pdf',
                    title: 'KHP Barang'
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
                url: '<?php echo base_url() ?>khp_barang/data_khp_barang',
                async: false,
                dataType: 'json',
                data: {
                    id: id_khp
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_MINTA;
                        let jumlah_rasd = data[i].JUMLAH_RASD;
                        let kode_barang = data[i].KODE_BARANG;
                        if (jumlah_barang == null) {
                            jumlah_barang = 0;
                        }
                        if (kode_barang == null) {
                            kode_barang = `<span class="label label-warning"><i class="fa fa-warning"></i> Data Baru</span>`;
                        }
                        if (jumlah_rasd == null) {
                            jumlah_rasd = 0;
                        }
                        html += '<tr>' +
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
                            '<td> ' + data[i].JUMLAH_SETUJU_TERAKHIR + ' </td>' +
                            '<td>  </td>' +
                            '<td>  </td>' +
                            '<td>' +
                            '<a href="<?php echo base_url() ?>hbp/index/' + data[i].ID_KHP_BARANG + '" class="btn btn-info btn-xs block"><i class="fa fa-plus-square"></i> Tambah Vendor  </a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-success btn-xs item_edit block" data="' + data[i].ID_KHP_BARANG + '"><i class="fa fa-pencil"></i> Pilih Vendor </a>' + ' ' +

                            '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }


        // //CREAT SPP
        // $('#show_data').on('click', '.item_create', function() {
        //     var id = $(this).attr('data');
        //     $.ajax({
        //         type: "GET",
        //         url: "<?php echo base_url('hbp/data_hbp_barang') ?>",
        //         dataType: "JSON",
        //         data: {
        //             id: id
        //         },
        //         success: function(data) {
        //             let html = '';
        //             $('#ModalPilih').modal('show');
        //             data.forEach(res => {
        //                 console.log(res.ID_KHP_BARANG);
        //                 html += '<tr>' +
        //                     '<td>' + '<input type="radio" value="' + res.ID_HBP + '/' + res.ID_KHP_BARANG + '" name="DATA_HBP">' + '</td>' +
        //                     '<td>' + res.NAMA_VENDOR + '</td>' +
        //                     '<td>' + res.HARGA_SATUAN_VENDOR + '</td>' +
        //                     '</tr>';
        //             });
        //             $('#show_data_hbp').html(html);
        //         }
        //     });
        //     return false;
        // });


        //GET UPDATE
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('hbp/data_hbp_barang') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    let html = '';
                    $('#ModalPilih').modal('show');
                    data.forEach(res => {
                        console.log(res.ID_KHP_BARANG);
                        html += '<tr>' +
                            '<td>' + '<input type="radio" value="' + res.ID_HBP + '/' + res.ID_KHP_BARANG + '" name="DATA_HBP">' + '</td>' +
                            '<td>' + res.NAMA_VENDOR + '</td>' +
                            '<td>' + res.HARGA_SATUAN_VENDOR + '</td>' +
                            '</tr>';
                    });
                    $('#show_data_hbp').html(html);
                }
            });
            return false;
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('khp_barang/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(id);
                        if (data.ID_BARANG_MASTER != null) {
                            $('#NAMA_3').html('KHP Barang : ' + data.NAMA);
                        } else {
                            $('#NAMA_3').html('KHP Barang : ' + data.NAMA_RASD_BARANG);
                        }
                    });
                }
            });
        });

        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });

        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            var form_data = {
                ID_RASD: id_khp,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('khp_barang/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    console.log(data);

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
                url: "<?php echo site_url('khp_barang/update_data') ?>",
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
                url: "<?php echo base_url('khp_barang/hapus_data') ?>",
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