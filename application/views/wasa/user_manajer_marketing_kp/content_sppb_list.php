<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List SPPB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPPB/') ?>">SPPB</a>
            </li>
            <li class="active">
                <strong>
                    <a>List SPPB</a>
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
        Sistem menampilkan seluruh SPPB.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>SPPB</h5>
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
                                    <th>No. SPPB</th>
                                    <th>Nama Proyek</th>
                                    <th>Jenis Kegiatan</th>
                                    <th>Tanggal Pembuatan SPPB</th>
                                    <th>Status SPPB</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    <!-- <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalaAdd"><span class="fa fa-plus"></span> Buat SPPB</a> -->
                </div>

            </div>
        </div>
    </div>
</div>
</br>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 40vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-suitcase modal-icon"></i>
                <h4 class="modal-title">SPPB</h4>
                <small class="font-bold">Silakan isi data SPPB Baru</small>
            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Lokasi :</label>
                        <div class="col-xs-9">
                            <select name="ID_RASD" class="form-control" id="ID_RASD">
                                <option value=''>- Pilih Proyek -</option>
                                <?php foreach ($rasd as $rasd) {
                                    echo '<option value="' . $rasd->ID_RASD . ' ' . $rasd->INISIAL . '">' . $rasd->NAMA_PROYEK . ' - ' . $rasd->LOKASI . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-xs-3 control-label">Jenis Pekerjaan :</label>
                        <div class="col-xs-9">
                            <div class="col-xs-4">
                                <label><input type="radio" value="Mainwork" id="Mainwork" name="KERJA" onclick="getPekerjaan(this.value)">&nbsp; Main Work</label>
                            </div>
                            <div class="col-xs-4">
                                <label> <input type="radio" value="additional" id="additional" name="KERJA" onclick="getPekerjaan(this.value)">
                                    &nbsp; Additional</label>
                            </div>
                            <input type="text" id="PEKERJAAN" name="PEKERJAAN" style="display: none;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut :</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_SPPB" id="NO_URUT_SPPB" disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tanggal Pembuatan SPPB:</label>
                        <div class="col-xs-9" id="data_1">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="tglPem" type="date" class="form-control unstyled" />
                            </div>
                        </div>
                    </div>



                    <div id="alert-msg"></div>

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

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Data SPPB</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus data ini?</p>
                        <div name="NAMA_3" id="NAMA_3"></div>
                    </div>

                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        Seluruh isian item barang dan jasa pada SPPB juga akan dihapus oleh sistem!
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

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Page-Level Scripts -->
<script>
    function goToRasdBarang() {
        var rasd = $('#ID_RASD').val();
        var pisah = rasd.split(' ')
        var id_rasd = pisah[0]
        if (id_rasd) {
            window.open("<?php echo base_url(); ?>rasd_barang/view/" + id_rasd)
        } else {
            $('#alert-msg').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> Pastikan anda pilih lokasi untuk melihat barang RASD </div>');
        }
    }


    function getPekerjaan(kerja) {
        // 001/SPPB/WME/CRB-2/Main Work/2020
        var rasd = $('#ID_RASD').val();
        //console.log(rasd);
        var pisah = rasd.split(' ')
        var inisial = pisah[1]
        var ID_RASD = pisah[0]
        var jenis = ""
        if (kerja == 'Mainwork') {
            jenis = 'Main Work'
        } else {
            jenis = 'Additional'
        }

        var id = ID_RASD;
        var COUNT = "";
        var NO_URUT = "";
        var DEPAN = "";
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('SPPB/get_nomor_urut') ?>",
            dataType: "JSON",
            data: {
                id: id
            },
            success: function(data) {
                $.each(data, function() {

                    var COUNT = data.JUMLAH_COUNT;


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
                    console.log(NO_URUT);

                    $('[name="JUMLAH_COUNT"]').val(COUNT);
                    $('[name="PEKERJAAN"]').val(kerja);
                    $('[name="NO_URUT_SPPB"]').val(`${NO_URUT}/SPPB/WME/${inisial}/${jenis}/2020`);
                });



            }
        });
    }

    $(document).ready(function() {
        var today = new Date().toISOString().substr(0, 10);
        document.querySelector("#tglPem").valueAsDate = new Date();

        tampil_data_sppb(); //pemanggilan fungsi tampil data.

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
                    title: 'SPPB'
                },
                {
                    extend: 'pdf',
                    title: 'SPPB'
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
        function tampil_data_sppb() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url('SPPB/data_sppb') ?>',
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html, html_progress = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        if (data[i].PROGRESS_SPPB == "Dalam Proses Manajer Kantor Pusat") {
                            html_progress = '<a href="#" class="btn btn-info btn-xs block"> ' + data[i].PROGRESS_SPPB + ' </a>';
                            tombol_sppb = '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-warning btn-xs block"><i class="fa fa-eye"></i> Lihat SPPB </a>';
                        } else if (data[i].PROGRESS_SPPB == "SPPB Disetujui") {
                            html_progress = '<a href="#" class="btn btn-primary btn-xs block"> ' + data[i].PROGRESS_SPPB + ' </a>';
                            tombol_sppb = '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Lihat SPPB </a>';
                        } else {
                            html_progress = '<a href="#" class="btn btn-info btn-outline btn-xs block"> ' + data[i].PROGRESS_SPPB + ' </a>';
                            tombol_sppb = '<a href="<?php echo base_url() ?>sppb_form/view/' + data[i].HASH_MD5_SPPB + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Lihat SPPB </a>';
                        }

                        html += '<tr>' +
                            '<td>' + data[i].NO_URUT_SPPB + '</td>' +
                            '<td>' + data[i].NAMA_PROYEK + '</td>' +
                            '<td>' + data[i].JENIS_PEKERJAAN + '</td>' +
                            '<td>' + data[i].TANGGAL_PEMBUATAN_SPPB_HARI + '</td>' +
                            '<td>' + html_progress + '</td>' +
                            '<td>' + tombol_sppb + ' '
                        '</td>' +
                        '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            var form_data = {
                ID_RASD: $('#ID_RASD').val(),
                JENIS_PEKERJAAN: $('[name="PEKERJAAN"]').val(),
                TANGGAL_PEMBUATAN_SPPB: $('#tglPem').val(),
                NO_URUT_SPPB: $('#NO_URUT_SPPB').val(),
                JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
            };
            // if (!form_data.ID_RASD || !form_data.JENIS_PEKERJAAN || !form_data.TANGGAL_PEMBUATAN_SPPB) {
            //     return $('#alert-msg').html('<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> isi semua data terlebih dahulu ! </div>');
            // }
            $.ajax({
                url: "<?php echo site_url('SPPB/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        console.log(data);
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('SPPB/get_data_sppb_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                console.log(data);
                                $.each(data, function() {
                                    if (data == 'BELUM ADA SPPB') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        window.location.href = '<?php echo base_url(); ?>SPPB_form/index/' + data.HASH_MD5_SPPB;
                                    }
                                });
                            }
                        });
                    }
                }
            });
            return false;
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPPB/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(id);
                        $('#NAMA_3').html('No. SPPB: ' + data.NO_URUT_SPPB);
                    });
                }
            });
        });

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('SPPB/hapus_data') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    $('#ModalHapus').modal('hide');
                    tampil_data_sppb();
                    window.location.reload();
                }
            });
            return false;
        });

    });
</script>

</body>

</html>