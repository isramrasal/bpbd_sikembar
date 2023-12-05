<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Spp Barang</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a onclick="goBack()">Spp</a>
            </li>
            <li class="active">
                <strong>
                    <a>Spp Barang</a>
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
        Sistem menampilkan seluruh spp barang.
    </div>

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian Item spp</h5>
        </div>
        <div class="ibox-content">
            <form method="get" class="form-horizontal">
                <?php
                if (isset($data_spp)) {
                    foreach ($data_spp as $data) :
                ?>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Form No :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" value="WME/FSPP/01" disabled />
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
                        <input style="display:none" type="text" class="form-control" name="ID_RASD" id="ID_RASD" value="<?php echo $data->ID_RASD; ?>">
                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $data->NAMA_PROYEK; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Jenis Pekerjaan :</label>
                            <div class="col-sm-10">
                                <?php if ($data->JENIS_PEKERJAAN == "mainwork") {
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
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $data->NO_URUT_SPP; ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal Pembuatan :</label>
                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $data->TANGGAL_SPP; ?>" disabled>
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
                    <h5>Spp Item List</h5>
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
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Merek Barang</th>
                                    <th>Jenis Barang</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Satuan Barang</th>
                                    <th>Jumlah Minta</th>
                                    <th>Tanggal Dibutuhkan</th>
                                    <th>Vendor</th>
                                    <th>Harga Satuan</th>
                                    <th>Total Harga</th>
                                    <th>Keterangan</th>
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
                            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalSPP"><span class="fa fa-save"></span> Simpan Perubahan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL SIMPAN SPP -->
    <div class="modal inmodal fade" id="ModalSPP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog" style="width: 40vw;">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-save modal-icon"></i>
                    <h4 class="modal-title">Simpan Sppb</h4>
                    <small class="font-bold">Silakan isi catatan Spp dan Simpan Perubahan</small>
                </div>
                <!-- exclamation-triangle -->
                <div class="form-horizontal">
                    <div class="modal-body">

                        <form method="POST" action="<?php echo site_url('sppb/simpan_perubahan_sppb'); ?>" id="formSimpanSPP">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea class="form-control h-200" name="CTT" id="CTT" placeholder="Contoh : Barang ini sangat diperlukan segera di lapangan" required></textarea>
                                    <input name="ID_SPP" class="form-control" type="text" value="<?php echo $id_sppb  ?>" style="display: none;" readonly>
                                </div>
                            </div>
                        </form>
                        <div id="alert-msg"></div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                        <button class="btn btn-primary" type="submit" form="formSimpanSPP"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    <!-- END MODAL SIMPAN SPP -->

    <!-- MODAL EDIT -->
    <div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-group modal-icon"></i>
                    <h4 class="modal-title">Spp Barang</h4>
                    <small class="font-bold">Silakan edit data sppb barang</small>
                </div>
                <?php $attributes = array("id_sppb_barang2" => "contact_form", "id" => "contact_form");
                echo form_open("sppb_barang/update_data", $attributes); ?>
                <div class="form-horizontal">
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label col-xs-3">ID Spp Barang</label>
                            <div class="col-xs-9">
                                <input name="ID_SPP_BARANG2" id="ID_SPP_BARANG2" class="form-control" type="text" placeholder="ID sppb barang" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">ID Barang Master</label>
                            <div class="col-xs-9">
                                <input name="ID_BARANG_MASTER2" id="ID_BARANG_MASTER2" class="form-control" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Kode Barang</label>
                            <div class="col-xs-9">
                                <input name="KODE_BARANG2" id="KODE_BARANG2" class="form-control" type="text" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Nama</label>
                            <div class="col-xs-9">
                                <input name="NAMA2" id="NAMA2" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Merek</label>
                            <div class="col-xs-9">
                                <input name="MEREK2" id="MEREK2" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Jumlah Barang</label>
                            <div class="col-xs-9">
                                <input name="JUMLAH_BARANG2" id="JUMLAH_BARANG2" class="form-control touchspin1" type="number">
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
                    <h4 class="modal-title" id="myModalLabel">Hapus Data sppb barang</h4>
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
            location.replace("<?php echo base_url(); ?>sppb")
        }

        function goToRasdBarang() {
            let id_rasd = $('#ID_RASD').val();
            if (id_rasd) {
                window.open("<?php echo base_url(); ?>rasd_barang/view/" + id_rasd)
            } else {
                $('#alert-msg').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> Pastikan anda pilih lokasi untuk melihat barang RASD </div>');
            }
        }
        $(document).ready(function() {
            let id_spp = <?php echo $id_spp  ?>;
            tampil_data_spp_barang(); //pemanggilan fungsi tampil data.

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
                        title: 'Spp Barang'
                    },
                    {
                        extend: 'pdf',
                        title: 'Spp Barang'
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
            function tampil_data_spp_barang() {
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url() ?>spp_barang/data_spp_barang',
                    async: false,
                    dataType: 'json',
                    data: {
                        id: id_spp
                    },
                    success: function(data) {
                        var html = '';
                        var i;
                        for (i = 0; i < data.length; i++) {
                            let jumlah_rasd = data[i].JUMLAH_BARANG_SPP;
                            let kode_barang = data[i].KODE_BARANG;
                            let totalharga;
                            if (data[i].HARGA_SATUAN_VENDOR != null || data[i].HARGA_SATUAN_VENDOR > 0 || data[i].JUMLAH_BARANG_SPP > 0) {
                                totalharga = Number(data[i].JUMLAH_BARANG_SPP) * Number(data[i].HARGA_SATUAN_VENDOR)
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
                                '<td>' + data[i].NAMA_VENDOR + '</td>' +
                                '<td> Rp. ' + data[i].HARGA_SATUAN_VENDOR + '</td>' +
                                '<td> Rp. ' + totalharga + '</td>' +
                                '<td>  </td>' +
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

            // SIMPAN SPP DAN KEMBALI KE SPP LIST
            $('#btn_simpan_sppb').on('click', function() {
                let ID_SPP = id_sppb;
                let CTT = $('#CTT').val();

            })

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
                        $.each(data, function() {
                            $('#ModalaEdit').modal('show');
                            $('[name="ID_SPP_BARANG2"]').val(data.ID_SPP_BARANG);
                            // $('[name="ID_BARANG_MASTER2"]').val(data.ID_BARANG_MASTER);
                            $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                            $('[name="NAMA2"]').val(data.NAMA_MASTER);
                            $('[name="MEREK2"]').val(data.MEREK_MASTER);
                            $('[name="JUMLAH_BARANG2"]').val(data.JUMLAH_SPP);
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
                    url: "<?php echo base_url('sppb_barang/get_data') ?>",
                    dataType: "JSON",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $.each(data, function() {
                            $('#ModalHapus').modal('show');
                            $('[name="kode"]').val(id);
                            if (data.NAMA_SPP != null) {
                                $('#NAMA_3').html('Spp Barang : ' + data.NAMA_SPP);
                            } else if (data.NAMA_RASD != null) {
                                $('#NAMA_3').html('Spp Barang : ' + data.NAMA_RASD);
                            } else if (data.NAMA_MASTER != null) {
                                $('#NAMA_3').html('Spp Barang : ' + data.NAMA_MASTER);
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
            $('#btn_simpan_sppb_barang').click(function() {
                var form_data = {
                    ID_SPP: id_sppb,
                    NAMA: $('#NAMA_4').val(),
                    MEREK: $('#MEREK_4').val(),
                    JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                    SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                    SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                    JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
                };
                $.ajax({
                    url: "<?php echo site_url('sppb_barang/simpan_data'); ?>",
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

                let ID_SPP_BARANG = $('#ID_SPP_BARANG2').val();
                // let ID_BARANG_MASTER = $('#ID_BARANG_MASTER2').val();
                let JUMLAH_BARANG = $('#JUMLAH_BARANG2').val();
                $.ajax({
                    url: "<?php echo site_url('sppb_barang/update_data') ?>",
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        ID_SPP_BARANG: ID_SPP_BARANG,
                        // ID_BARANG_MASTER: ID_BARANG_MASTER,
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
                    url: "<?php echo base_url('sppb_barang/hapus_data') ?>",
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