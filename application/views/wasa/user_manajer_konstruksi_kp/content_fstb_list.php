<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List FSTB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/FSTB/') ?>">FSTB</a>
            </li>
            <li class="active">
                <strong>
                    <a>List FSTB</a>
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
        Sistem menampilkan seluruh FSTB yang Anda ajukan pada proyek <?php echo ($NAMA_PROYEK); ?>.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>FSTB</h5>
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
                                    <th>Nomor Urut FSTB</th>
                                    <th>Tanggal Pengajuan FSTB</th>
                                    <th>Nama Vendor</th>
                                    <th>Nama Pengirim</th>
                                    <th>Nomor Urut PO</th>
                                    <th>Nomor Surat jalan</th>
                                    <th>No HP Pengirim</th>
                                    <th>Nama Pegawai Departemen Logistik</th>
                                    <th>Tanggal Barang Datang</th>
                                    <th>Progres FSTB</th>
                                    <th>Status</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd" style="margin-top: 30px;"><span class="fa fa-plus"></span> Buat Form Serah Terima Barang</a>
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
                <h4 class="modal-title">Identitas Format Serah Terima Barang</h4>
                <small class="font-bold">Silakan isi tanggal serah terima barang</small>
            </div>
            <?php $attributes = array("NAMA_JENIS_BARANG" => "contact_form", "id" => "contact_form");
            echo form_open("FSTB/simpan_data", $attributes); ?>

            <input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />

            <input type="hidden" class="form-control" value="<?php echo ($ID_PROYEK); ?>" name="ID_PROYEK" id="ID_PROYEK" disabled />

            <input type="hidden" class="form-control" value="<?php echo ($INISIAL); ?>" name="INISIAL" id="INISIAL" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($USER_ID); ?>" name="USER_ID" id="USER_ID" disabled />
            <input type="hidden" class="form-control" value="<?php echo ($ID_JABATAN_PEGAWAI); ?>" name="ID_JABATAN_PEGAWAI" id="ID_JABATAN_PEGAWAI" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut FSTB:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_FSTB" id="NO_URUT_FSTB" disabled />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Urut FIB:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NO_URUT_FIB" id="NO_URUT_FIB" disabled />
                            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP_FIB" id="FILE_NAME_TEMP_FIB" disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tanggal Pengajuan FSTB/FIB:</label>
                        <div class="col-xs-9">
                            <input type="date" class="form-control" id="tglPem">
                        </div>
                    </div>
                    <p>*tanggal pengajuan akan berubah sesuai dengan tanggal aktual pengajuan FSTB/FIB</p>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nomor Urut PO</label>
                        <div class="col-xs-9">
                            <select name="NO_URUT_PO_1" class="form-control" id="NO_URUT_PO_1">
                                <option value=''>- Pilih Nomor PO -</option>
                                <option value='TANPA PO'>- Tanpa PO -</option>
                                <?php foreach ($NO_PO_LIST as $item) {
                                    echo '<option value="' . $item->ID_PO . '">' . $item->NO_URUT_PO . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Vendor</label>
                        <div class="col-xs-9">
                            <select name="ID_VENDOR_1" class="form-control" id="ID_VENDOR_1">
                                <option value=''>- Pilih Nama Vendor -</option>
                                <?php foreach ($NAMA_VENDOR_LIST as $item) {
                                    echo '<option value="' . $item->ID_VENDOR . '">' . $item->NAMA_VENDOR . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor Surat jalan:</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" name="NO_SURAT_JALAN" id="NO_SURAT_JALAN" />
                        </div>
                    </div>

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
						<label class="control-label col-xs-3">Nama Pegawai</label>
						<div class="col-xs-9">
							<select name="NAMA" class="form-control" id="NAMA">
								<option value=''>- Pilih Pegawai -</option>
                                <?php foreach ($DATA_PEGAWAI_PROYEK as $item) {
                                    echo '<option value="' . $item->ID_PEGAWAI . '">' . $item->NAMA . '</option>';
                                } ?>
							</select>
						</div>
					</div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Tanggal Barang Datang</label>
                        <div class="col-xs-9">
                            <input name="TANGGAL_BARANG_DATANG" id="TANGGAL_BARANG_DATANG" class="form-control" type="date">
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Buat FSTB</button>
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
    $('#ModalAdd').on('shown.bs.modal', function(e) {

        var ID_JABATAN_PEGAWAI = $('#ID_JABATAN_PEGAWAI').val();
        //console.log(rasd);
        var pisah = ID_JABATAN_PEGAWAI.split(' ');
        var SUB_DEPARTEMEN = pisah[1];

        var ID_PROYEK = $('#ID_PROYEK').val();
        var INISIAL = $('#INISIAL').val();

        var id = ID_PROYEK;
        var COUNT = "";
        var NO_URUT = "";
        var DEPAN = "";

        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>FSTB/get_nomor_urut",
            dataType: "JSON",
            data: {
                id: id
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
                    console.log(NO_URUT);

                    $('[name="JUMLAH_COUNT"]').val(COUNT);
                    $('[name="NO_URUT_FSTB"]').val(`${NO_URUT}/FSTB/WME/${INISIAL}/${date.getFullYear()}`);
                    $('[name="NO_URUT_FIB"]').val(`${NO_URUT}/FIB/WME/${INISIAL}/${date.getFullYear()}`);
                    $('[name="FILE_NAME_TEMP"]').val(`${NO_URUT}_FSTB_WME_${INISIAL}_${date.getFullYear()}`);
                    $('[name="FILE_NAME_TEMP_FIB"]').val(`${NO_URUT}_FIB_WME_${INISIAL}_${date.getFullYear()}`);
                });
            }
        });
    });

    $(document).ready(function() {
        var today = new Date().toISOString().substr(0, 10);
        // document.querySelector("#tglPem").valueAsDate = new Date();

        tampil_data_fstb(); //pemanggilan fungsi tampil data.

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
        function tampil_data_fstb() {
            $.ajax({
                type: 'ajax',
                url: '<?php echo base_url() ?>FSTB/data_FSTB',
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {

                        let PROGRESS_FSTB = data[i].PROGRESS_FSTB;
                        let STATUS_FSTB = data[i].STATUS_FSTB;

                        if (PROGRESS_FSTB == "Dalam Proses Supervisor Logistik") {
                            tombol_ubah = '<a href="#" class="btn btn-warning btn-xs block" disabled><i class="fa fa-pencil"></i> Ubah </a>';
                        } else {
                            tombol_ubah = '<a href="<?php echo base_url() ?>FSTB_form/index/' + data[i].HASH_MD5_FSTB + '" class="btn btn-warning btn-xs block"><i class="fa fa-pencil"></i> Ubah </a>';
                        }

                        if (data[i].NO_URUT_PO === null) {
                            KET_NO_URUT_PO = 'TANPA PO';
                        } else {
                            KET_NO_URUT_PO = data[i].NO_URUT_PO;
                        }

                        if (data[i].NAMA === null) {
                            KET_NAMA = 'PEGAWAI BELUM DIATUR';
                        } else {
                            KET_NAMA = data[i].NAMA;
                        }

                        html += '<tr>' +
                            '<td>' + data[i].NO_URUT_FSTB + '</td>' +
                            '<td>' + data[i].TANGGAL_PENGAJUAN_FSTB + '</td>' +
                            '<td>' + data[i].NAMA_VENDOR + '</td>' +
                            '<td>' + data[i].NAMA_PENGIRIM + '</td>' +
                            '<td>' + data[i].NO_URUT_PO + '</td>' +
                            '<td>' + data[i].NO_SURAT_JALAN + '</td>' +
                            '<td>' + data[i].NO_HP_PENGIRIM + '</td>' +
                            '<td>' + data[i].NAMA + '</td>' +
                            '<td>' + data[i].TANGGAL_BARANG_DATANG_HARI + '</td>' +
                            '<td>' + data[i].PROGRESS_FSTB + '</td>' +
                            '<td>' + data[i].STATUS_FSTB + '</td>' +
                            '<td>' +
                            '<a href="<?php echo base_url() ?>FSTB_form/view/' + data[i].HASH_MD5_FSTB + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i>Lihat FSTB</a>' + ' ' +
                            '</td>' +
                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        //SIMPAN DATA
        $('#btn_simpan').click(function() {
            let form_data = {
                ID_PROYEK: $('#ID_PROYEK').val(),
                TANGGAL_PENGAJUAN_FSTB: $('#tglPem').val(),
                JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
                NO_URUT_FSTB: $('#NO_URUT_FSTB').val(),
                NO_URUT_FIB: $('#NO_URUT_FIB').val(),
                USER_ID: $('#USER_ID').val(),
                FILE_NAME_TEMP: $('#FILE_NAME_TEMP').val(),
                FILE_NAME_TEMP_FIB: $('#FILE_NAME_TEMP_FIB').val(),
                ID_PO: $('#NO_URUT_PO_1').val(),
                ID_VENDOR: $('#ID_VENDOR_1').val(),
                NO_SURAT_JALAN: $('#NO_SURAT_JALAN').val(),
                NAMA_PENGIRIM: $('#NAMA_PENGIRIM').val(),
                NO_HP_PENGIRIM: $('#NO_HP_PENGIRIM').val(),
                ID_PEGAWAI: $('#NAMA').val(),
                TANGGAL_BARANG_DATANG_HARI: $('#TANGGAL_BARANG_DATANG').val(),
            };
            $.ajax({
                url: "<?php echo site_url('FSTB/simpan_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        $.ajax({
                            type: "GET",
                            url: "<?php echo base_url('FSTB/get_data_fstb_baru') ?>",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                                $.each(data, function() {
                                    if (data == 'BELUM ADA FSTB') {
                                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                                    } else {
                                        console.log(data);
                                        window.location.href = '<?php echo base_url(); ?>FSTB_form/index/' + data.HASH_MD5_FSTB;
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