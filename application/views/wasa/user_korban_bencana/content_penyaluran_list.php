<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Penyaluran Bantuan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPPB/') ?>">Penyaluran Bantuan</a>
            </li>
            <li class="active">
                <strong>
                    <a>List Penyaluran Bantuan</a>
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
        Sistem menampilkan seluruh penyaluran bantuan yang Anda ajukan.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" id="ibox1">
                <div class="ibox-title">
                    <h5>Penyaluran Bantuan</h5>
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
                    <div class="sk-spinner sk-spinner-wave">
                        <div class="sk-rect1"></div>
                        <div class="sk-rect2"></div>
                        <div class="sk-rect3"></div>
                        <div class="sk-rect4"></div>
                        <div class="sk-rect5"></div>
                    </div>

                    <!-- <a href="#" class="btn btn-primary btn-xs" name="btn_buat" id="btn_buat" ><span class="fa fa-plus" hidden></span> Buat Penyaluran Bantuan</a> -->

                    <!-- <a href="#" class="btn btn-primary btn-xs" name="btn_buat" id="btn_buat" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Buat PENYALURAN Bantuan</a> -->
                    </br>
                    </br>

                    <select class="chosen-select" name="ID_JENIS_BENCANA_LIST" class="form-control"
                        id="ID_JENIS_BENCANA_LIST">
                        <option value=''>- Pilih Bencana -</option>
                        <option value='Semua'>Semua Bencana</option>
                        <option value='Gempa Bumi'>Gempa Bumi</option>
                        <option value='Angin Puting Beliung'>Angin Puting Beliung</option>
                        <option value='Banjir'>Banjir</option>
                        <option value='Longsor'>Longsor</option>
                        <option value='Tsunami'>Tsunami</option>
                        <option value='Kebakaran'>Kebakaran</option>
                        <option value='Pohon Tumbang'>Pohon Tumbang</option>
                        <option value='Kekeringan'>Kekeringan</option>
                    </select>

                    </br>
                    </br>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead id="show_data_head">
                            </thead>
                            <tbody id="show_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 70vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Buat Penyaluran Bantuan</h4>
                <small class="font-bold">Silakan isi identitas formulir penyaluran bantuan</small>
            </div>
            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
            <input type="hidden" class="form-control" value="" name="CODE_MD5" id="CODE_MD5" disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Bencana *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_JENIS_BENCANA" class="form-control"
                                id="ID_JENIS_BENCANA">
                                <option value=''>- Pilih Bencana -</option>
                                <option value='Gempa Bumi'>Gempa Bumi</option>
                                <option value='Angin Puting Beliung'>Angin Puting Beliung</option>
                                <option value='Banjir'>Banjir</option>
                                <option value='Longsor'>Longsor</option>
                                <option value='Tsunami'>Tsunami</option>
                                <option value='Kebakaran'>Kebakaran</option>
                                <option value='Pohon Tumbang'>Pohon Tumbang</option>
                                <option value='Kekeringan'>Kekeringan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama Pegawai *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NAMA_PEGAWAI_BPBD"
                                id="NAMA_PEGAWAI_BPBD" placeholder="Contoh: ASEP SAEPUDIN" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">NIK Pegawai *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NIK_PEGAWAI_BPBD"
                                id="NIK_PEGAWAI_BPBD" placeholder="Contoh: 3602041211870001" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">NIP Pegawai *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NIP_PEGAWAI_BPBD"
                                id="NIP_PEGAWAI_BPBD" placeholder="Contoh: 197002092007011005" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Jabatan Pegawai *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="JABATAN_PEGAWAI_BPBD"
                                id="JABATAN_PEGAWAI_BPBD" placeholder="Contoh: Kepala sub seksi" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama Penerima *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NAMA_PENERIMA" id="NAMA_PENERIMA"
                                placeholder="Contoh: Wangwang Kuswaya" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nomor KK Penerima </label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NOMOR_KK_PENERIMA"
                                id="NOMOR_KK_PENERIMA" placeholder="Contoh: 3602041211870001" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">NIK Penerima</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NIK_PENERIMA" id="NIK_PENERIMA"
                                placeholder="Contoh: 3602041211870001" />
                        </div>
                    </div>
                    <div class="form-group" id="data_TANGGAL_LAHIR_PENERIMA">
                        <label class="col-xs-3 control-label">Tanggal Lahir Penerima *</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    id="TANGGAL_LAHIR_PENERIMA" type="text" class="form-control"
                                    placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Tempat Lahir Penerima *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="TEMPAT_LAHIR_PENERIMA"
                                id="TEMPAT_LAHIR_PENERIMA" placeholder="Contoh: Cianjur" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">NIP Penerima</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NIP_PENERIMA" id="NIP_PENERIMA"
                                placeholder="Contoh: 197509282005011007" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Jabatan Penerima</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="JABATAN_PENERIMA"
                                id="JABATAN_PENERIMA" placeholder="Contoh: Kepala sub seksi" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Instansi Penerima</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="INSTANSI_PENERIMA"
                                id="INSTANSI_PENERIMA" placeholder="Contoh: Universitas Gunadarma" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kabupaten/Kota *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_KABUPATEN_KOTA" class="form-control"
                                id="ID_KABUPATEN_KOTA">
                                <option value=''>- Pilih Kabupaten/Kota -</option>
                                <option value='Cianjur'>Cianjur</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kecamatan *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_KECAMATAN" class="form-control" id="ID_KECAMATAN">
                                <option value=''>- Pilih Kecamatan -</option>
                                <option value='Bojongpicung'>Bojongpicung</option>
                                <option value='Campaka'>Campaka</option>
                                <option value='Campaka Mulya'>Campaka Mulya</option>
                                <option value='Cianjur'>Cianjur</option>
                                <option value='Cibeber'>Cibeber</option>
                                <option value='Cibinong'>Cibinong</option>
                                <option value='Cidaun'>Cidaun</option>
                                <option value='Cijati'>Cijati</option>
                                <option value='Cikadu'>Cikadu</option>
                                <option value='Cikalongkulon'>Cikalongkulon</option>
                                <option value='Cilaku'>Cilaku</option>
                                <option value='Cipanas'>Cipanas</option>
                                <option value='Ciranjang'>Ciranjang</option>
                                <option value='Cugenang'>Cugenang</option>
                                <option value='Gekbrong'>Gekbrong</option>
                                <option value='Haurwangi'>Haurwangi</option>
                                <option value='Kadupandak'>Kadupandak</option>
                                <option value='Karangtengah'>Karangtengah</option>
                                <option value='Leles'>Leles</option>
                                <option value='Mande'>Mande</option>
                                <option value='Naringgul'>Naringgul</option>
                                <option value='Pacet'>Pacet</option>
                                <option value='Pagelaran'>Pagelaran</option>
                                <option value='Pasirkuda'>Pasirkuda</option>
                                <option value='Sindangbarang'>Sindangbarang</option>
                                <option value='Sukaluyu'>Sukaluyu</option>
                                <option value='Sukanagara'>Sukanagara</option>
                                <option value='Sukaresmi'>Sukaresmi</option>
                                <option value='Takokak'>Takokak</option>
                                <option value='Tanggeung'>Tanggeung</option>
                                <option value='Warungkondang'>Warungkondang</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Desa/Kelurahan *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_DESA_KELURAHAN" class="form-control"
                                id="ID_DESA_KELURAHAN">
                                <option value=''>- Pilih Desa/Kelurahan -</option>
                                <option value='Bojongkaso'>Bojongkaso</option>
                                <option value='Bunisari'>Bunisari</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">RT *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="RT" id="RT"
                                placeholder="Contoh: 03" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">RW *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="RW" id="RW"
                                placeholder="Contoh: 02" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Kampung</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="KAMPUNG" id="KAMPUNG"
                                placeholder="Contoh: Kp. Ciater" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Kode Pos</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="KODE_POS" id="KODE_POS"
                                placeholder="Contoh: 43273" />
                        </div>
                    </div>
                    <div class="form-group" id="data_TANGGAL_KEJADIAN_BENCANA">
                        <label class="col-xs-3 control-label">Tanggal Kejadian Bencana *</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    id="TANGGAL_KEJADIAN_BENCANA" type="text" class="form-control"
                                    placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="data_TANGGAL_DOKUMEN_PENYALURAN">
                        <label class="col-xs-3 control-label">Tanggal Penyaluran */**</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    id="TANGGAL_DOKUMEN_PENYALURAN" type="text" class="form-control"
                                    placeholder="dd/mm/yyyy">
                            </div>
                            </br>
                            *wajib diisi
                            </br>
                            **Sistem juga menyimpan tanggal aktual pembuatan penyaluran ini by system
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Buat Penyaluran
                        Bantuan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL ADD-->
</br>

<!-- MODAL STATUS -->
<div class="modal inmodal fade" id="ModalStatus" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 50vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Status SPPB</h4>
                <small class="font-bold">Progress SPPB sampai dengan Serah Terima Barang</small>
            </div>

            <input type="hidden" class="form-control" value="" name="ID_SPPB_3" id="ID_SPPB_3" disabled />
            <input type="hidden" class="form-control" value="" name="NO_URUT_SPPB_3" id="NO_URUT_SPPB_3" disabled />
            <input type="hidden" class="form-control" value="" name="HASH_MD5_SPPB_3" id="HASH_MD5_SPPB_3" disabled />
            <input type="hidden" class="form-control" value="" name="TANGGAL_DOKUMEN_SPPB_3" id="TANGGAL_DOKUMEN_SPPB_3"
                disabled />

            <input type="hidden" class="form-control" value="" name="PROGRESS_SPPB_3" id="PROGRESS_SPPB_3" disabled />

            <div class="wrapper wrapper-content  animated fadeInRight form-horizontal">
                <div class="row">
                    <div class="modal-body">
                        <div class="social-feed-box">
                            <div class="social-footer">
                                <div class="social-comment">
                                    <div id="show_data_status_new">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-window-close"></i> Kembali</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL STATUS-->
</br>



<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- Chosen -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/chosen/chosen.jquery.js"></script>

<!-- Page-Level Scripts -->
<script>
$(document).ready(function() {
    $('.chosen-select').chosen({
        width: "100%"
    });

    var today = new Date().toISOString().substr(0, 10);

    $('#data_TANGGAL_DOKUMEN_PENYALURAN .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#data_TANGGAL_KEJADIAN_BENCANA .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#data_TANGGAL_LAHIR_PENERIMA .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    // html_head = '<tr><th>No. SPPB</th><th>Proyek</th>><th>Tanggal Dokumen SPPB</th><th>Status SPPB</th></tr>';
    // $('#show_data_head').html(html_head);
    $('#mydata').dataTable({
        aaSorting: [],
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'excel',
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

    $("#ID_JENIS_BENCANA_LIST").change(function() {
        var ID_JENIS_BENCANA_LIST = $('#ID_JENIS_BENCANA_LIST').val();
        var NAMA_BENCANA = $('#ID_JENIS_BENCANA_LIST option:selected').text();
        var JUDUL = "List Penyaluran Bantuan " + NAMA_BENCANA;

        // Siapkan data untuk dikirim ke server
        var form_data = {
            ID_JENIS_BENCANA_LIST: ID_JENIS_BENCANA_LIST
        };

        console.log("Form Data: ", form_data);

        // Hancurkan DataTable yang sudah ada
        if ($.fn.DataTable.isDataTable("#mydata")) {
            $("#mydata").DataTable().destroy();
        }

        // Bersihkan tabel
        $('#show_data_head').empty();
        $('#show_data').empty();

        // Tampilkan efek loading
        $('#ibox1').children('.ibox-content').toggleClass('sk-loading');

        $.ajax({
            url: "<?php echo base_url(); ?>Penyaluran/list_penyaluran_by_all_bencana",
            method: "POST",
            data: form_data,
            dataType: 'json',
            success: function(data) {
                console.log("Response Data: ", data);

                var html = '';
                var html_head = `
                <tr>
                    <th>No. Penyaluran</th>
                    <th>Jenis Bencana</th>
                    <th>Nama Penerima</th>
                    <th>NIK Penerima</th>
                    <th>Instansi Penerima</th>
                    <th>Desa Penerima</th>
                    <th>Kecamatan Penerima</th>
                    <th>Tanggal Kejadian Bencana</th>
                    <th>Aksi</th>
                </tr>`;

                if (data && data.length > 0) {
                    data.forEach((item) => {
                        html += `
                    <tr>
                        <td>
                            <a href="<?php echo base_url() ?>pengajuan_form/view/${item.CODE_MD5}" class="btn btn-default btn-xs btn-outline">
                                <i class="fa fa-eye"></i> ${item.CODE_MD5}
                            </a>
                        </td>
                        <td>${item.Jenis_Bencana}</td>
                        <td>${item.Nama_Penerima}</td>
                        <td>${item.NIK_Penerima}</td>
                        <td>${item.Instansi_Penerima}</td>
                        <td>${item.Desa_Kelurahan_Bencana}</td>
                        <td>${item.Kecamatan_Bencana}</td>
                        <td>${item.TANGGAL_KEJADIAN_BENCANA}</td>
                        <td>
                            <a href="javascript:;" class="btn btn-primary btn-xs item_status block" data="${item.CODE_MD5}">
                                <i class="fa fa-pencil"></i> ${item.STATUS_SPPB}
                            </a>
                        </td>
                    </tr>`;
                    });
                } else {
                    html = `
                <tr>
                    <td colspan="9" class="text-center">Data tidak ditemukan</td>
                </tr>`;
                }

                $('#show_data_head').html(html_head);
                $('#show_data').html(html);

                // Inisialisasi ulang DataTable
                $('#mydata').DataTable({
                    aaSorting: [],
                    pageLength: 10,
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, 'All']
                    ],
                    responsive: true,
                    dom: '<"html5buttons"B>lTfgitp',
                    buttons: [{
                            extend: 'excel',
                            title: JUDUL
                        },
                        {
                            extend: 'print',
                            customize: function(win) {
                                $(win.document.body).addClass('white-bg');
                                $(win.document.body).css('font-size',
                                    '10px');
                                $(win.document.body).find('table').addClass(
                                    'compact').css('font-size',
                                    'inherit');
                            }
                        }
                    ]
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);
                alert("Terjadi kesalahan saat mengambil data. Silakan coba lagi.");
            },
            complete: function() {
                // Sembunyikan loading
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            }
        });
    });






    $("#ID_PROYEK").change(function() {

        var ID_PROYEK = $('[name="ID_PROYEK"]').val();

        var form_data = {
            ID_PROYEK: ID_PROYEK,
        }

        $.ajax({
            url: "<?php echo base_url(); ?>/SPPB/data_sub_pekerjaan_by_id_proyek",
            method: "POST",
            data: form_data,
            async: false,
            dataType: 'json',
            success: function(data) {

                var html = '';
                var i;

                $("#ID_PROYEK_SUB_PEKERJAAN").chosen();
                $('#ID_PROYEK_SUB_PEKERJAAN').empty();

                for (i = 0; i < data.length; i++) {
                    $("#ID_PROYEK_SUB_PEKERJAAN").append(
                        '<option selected="selected" value="' + data[i]
                        .ID_PROYEK_SUB_PEKERJAAN + '">' + data[i].NAMA_SUB_PEKERJAAN +
                        ' </option>');
                }

                $("#ID_PROYEK_SUB_PEKERJAAN").trigger("liszt:updated");
                $("#ID_PROYEK_SUB_PEKERJAAN").chosen();
                $("#ID_PROYEK_SUB_PEKERJAAN").trigger("chosen:updated");

            }
        });

    });


    $('#ModalStatus').on('shown.bs.modal', function() {

        var ID_SPPB = $("#ID_SPPB_3").val();
        var NO_URUT_SPPB = $("#NO_URUT_SPPB_3").val();
        var HASH_MD5_SPPB = $("#HASH_MD5_SPPB_3").val();
        var TANGGAL_DOKUMEN_SPPB = $("#TANGGAL_DOKUMEN_SPPB_3").val();
        var PROGRESS_SPPB = $("#PROGRESS_SPPB_3").val();
        var html, html_new = "";
        var NO_URUT_SPPB_CETAK = NO_URUT_SPPB;
        var NO_URUT_SPP_CETAK, NO_URUT_SPP_CETAK_NEW = "";
        var NO_URUT_PO_CETAK, NO_URUT_PO_CETAK_NEW = "";
        var NO_URUT_FSTB_CETAK, NO_URUT_FSTB_CETAK_NEW = "";

        // html += '<tr>';
        // html += '<td>' + '<a href="<?php echo base_url() ?>sppb_form/view/' + HASH_MD5_SPPB + '" class="btn btn-xs block"><i class="fa fa-eye"></i> ' + NO_URUT_SPPB_CETAK + " " + '</a>' + '</td>';

        //GET JUMLAH ITEM BARANG

        var ID_SPPB = ID_SPPB;
        $.ajax({
            url: "<?php echo site_url('SPPB/data_qty_sppb_form') ?>",
            type: "POST",
            dataType: "JSON",
            async: false,
            data: {
                ID_SPPB: ID_SPPB,
            },
            success: function(data) {

                html_new +=
                    '<div class="media-body"><a href="<?php echo base_url() ?>sppb_form/view/' +
                    HASH_MD5_SPPB + '">' + NO_URUT_SPPB_CETAK +
                    '</a><small class="text-muted"> <i class="fa fa-dropbox"></i> ' + data[
                        0].JUMLAH_BARANG_SPPB +
                    ' item barang</small><small class="text-muted"> | Tanggal ' +
                    TANGGAL_DOKUMEN_SPPB + ' | Progress: ' + PROGRESS_SPPB +
                    '</small></div>';
            }
        });

        $.ajax({
            url: "<?php echo site_url('SPPB/get_list_spp_by_id_sppb') ?>",
            type: "POST",
            dataType: "JSON",
            async: false,
            data: {
                ID_SPPB: ID_SPPB,
            },
            success: function(data) {
                var data_2 = data;

                if (data_2 != "TIDAK ADA DATA") {
                    for (j = 0; j < data_2.length; j++) {

                        var ID_SPP = data_2[j].ID_SPP;
                        var NO_URUT_SPP = data_2[j].NO_URUT_SPP;
                        var HASH_MD5_SPP = data_2[j].HASH_MD5_SPP;
                        var TANGGAL_DOKUMEN_SPP = data_2[j].TANGGAL_DOKUMEN_SPP;
                        var STATUS_SPP = data_2[j].STATUS_SPP;
                        var br_SPP = "";
                        var br_SPP2 = "";

                        //html_progress = html_progress + NO_URUT_SPP + "</br>";
                        $.ajax({
                            url: "<?php echo site_url('SPPB/get_list_po_by_id_spp') ?>",
                            type: "POST",
                            dataType: "JSON",
                            async: false,
                            data: {
                                ID_SPP: ID_SPP,
                            },
                            success: function(data) {
                                var data_3 = data;

                                if (data_3 != "TIDAK ADA DATA") {

                                    l = 0;
                                    NO_URUT_PO_CETAK_NEW = "";
                                    for (k = 0; k < data_3.length; k++) {
                                        var ID_PO = data_3[k].ID_PO;
                                        var NO_URUT_PO = data_3[k].NO_URUT_PO;
                                        var HASH_MD5_PO = data_3[k].HASH_MD5_PO;
                                        var TANGGAL_DOKUMEN_PO = data_3[k]
                                            .TANGGAL_DOKUMEN_PO;
                                        var STATUS_PO = data_3[k].STATUS_PO;
                                        var br_PO = "";

                                        if (k > 0) {
                                            br_SPP +=
                                                '<a href="#" class="btn btn-link btn-xs block text-decoration-none">----</a>';
                                        }

                                        $.ajax({
                                            url: "<?php echo site_url('SPPB/get_list_fstb_by_id_po') ?>",
                                            type: "POST",
                                            dataType: "JSON",
                                            async: false,
                                            data: {
                                                ID_PO: ID_PO,
                                            },
                                            success: function(data) {
                                                console.log(data);
                                                var data_4 = data;


                                                if (data_4 !=
                                                    "TIDAK ADA DATA"
                                                ) {
                                                    NO_URUT_FSTB_CETAK_NEW
                                                        = "";
                                                    for (l = 0; l <
                                                        data_4
                                                        .length; l++
                                                    ) {

                                                        var ID_FSTB =
                                                            data_4[
                                                                l]
                                                            .ID_FSTB;
                                                        var HASH_MD5_FSTB =
                                                            data_4[
                                                                l]
                                                            .HASH_MD5_FSTB;
                                                        var NO_URUT_FSTB =
                                                            data_4[
                                                                l]
                                                            .NO_URUT_FSTB;
                                                        var TANGGAL_DOKUMEN_FSTB =
                                                            data_4[
                                                                l]
                                                            .TANGGAL_DOKUMEN_FSTB;
                                                        var STATUS_FSTB =
                                                            data_4[
                                                                l]
                                                            .STATUS_FSTB;

                                                        var id =
                                                            ID_FSTB;
                                                        $.ajax({
                                                            url: "<?php echo site_url('FSTB/data_qty_fstb_form') ?>",
                                                            type: "POST",
                                                            dataType: "JSON",
                                                            async: false,
                                                            data: {
                                                                id: id,
                                                            },
                                                            success: function(
                                                                data
                                                            ) {

                                                                NO_URUT_FSTB_CETAK_NEW
                                                                    +=
                                                                    '<div class="social-comment"><div class="media-body"><a href="<?php echo base_url() ?>fstb_form/view/' +
                                                                    HASH_MD5_FSTB +
                                                                    '">FSTB nomor: ' +
                                                                    NO_URUT_FSTB +
                                                                    '</a><small class="text-muted"> <i class="fa fa-dropbox"></i> ' +
                                                                    data[
                                                                        0
                                                                    ]
                                                                    .JUMLAH_BARANG_FSTB +
                                                                    ' item barang</small><small class="text-muted"> | Tanggal ' +
                                                                    TANGGAL_DOKUMEN_FSTB +
                                                                    ' | Progress: ' +
                                                                    STATUS_FSTB +
                                                                    '</small></div></div>';

                                                            }
                                                        });


                                                    }
                                                }
                                            }
                                        });

                                        var id = ID_PO;
                                        $.ajax({
                                            url: "<?php echo site_url('PO/data_qty_po_form') ?>",
                                            type: "POST",
                                            dataType: "JSON",
                                            async: false,
                                            data: {
                                                id: id,
                                            },
                                            success: function(data) {

                                                NO_URUT_PO_CETAK_NEW
                                                    +=
                                                    '<div class="social-comment"><div class="media-body"><a href="<?php echo base_url() ?>po_form/view/' +
                                                    HASH_MD5_PO +
                                                    '">PO nomor: ' +
                                                    NO_URUT_PO +
                                                    '</a><small class="text-muted"> <i class="fa fa-dropbox"></i> ' +
                                                    data[0]
                                                    .JUMLAH_BARANG_PO +
                                                    ' item barang</small><small class="text-muted"> | Tanggal ' +
                                                    TANGGAL_DOKUMEN_PO +
                                                    ' | Progress: ' +
                                                    STATUS_PO +
                                                    '</small></div>' +
                                                    NO_URUT_FSTB_CETAK_NEW +
                                                    '</div>';
                                            }
                                        });


                                    }
                                }

                            }
                        });

                        var id = ID_SPP;
                        $.ajax({
                            url: "<?php echo site_url('SPP/data_qty_spp_form') ?>",
                            type: "POST",
                            dataType: "JSON",
                            async: false,
                            data: {
                                id: id,
                            },
                            success: function(data) {

                                NO_URUT_SPP_CETAK_NEW +=
                                    '<div class="social-comment"><div class="media-body"><a href="<?php echo base_url() ?>spp_form/view/' +
                                    HASH_MD5_SPP + '">SPP nomor: ' +
                                    NO_URUT_SPP +
                                    '</a><small class="text-muted"> <i class="fa fa-dropbox"></i> ' +
                                    data[0].JUMLAH_BARANG_SPP +
                                    ' item barang</small><small class="text-muted"> | Tanggal ' +
                                    TANGGAL_DOKUMEN_SPP + ' | Progress: ' +
                                    STATUS_SPP + '</small></div>' +
                                    NO_URUT_PO_CETAK_NEW + '</div>';
                            }
                        });
                    }

                }
            }
        });

        html_new += NO_URUT_SPP_CETAK_NEW;

        $('#show_data_status_new').html(html_new);

    })

    //GET STATUS
    $('#show_data').on('click', '.item_status', function() {
        var ID_SPPB = $(this).attr('data');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('SPPB/data_sppb_by_id_sppb') ?>",
            dataType: "JSON",
            data: {
                ID_SPPB: ID_SPPB
            },
            success: function(data) {
                $('#ModalStatus').modal('show');
                $('[name="ID_SPPB_3"]').val(data[0].ID_SPPB);
                $('[name="NO_URUT_SPPB_3"]').val(data[0].NO_URUT_SPPB);
                $('[name="HASH_MD5_SPPB_3"]').val(data[0].HASH_MD5_SPPB);
                $('[name="TANGGAL_DOKUMEN_SPPB_3"]').val(data[0].TANGGAL_DOKUMEN_SPPB);
                $('[name="PROGRESS_SPPB_3"]').val(data[0].PROGRESS_SPPB);

            }
        });
        return false;
    });

    //SIMPAN DATA
    $('#btn_simpan').click(function() {

        var TANGGAL_LAHIR_PENERIMA = $('#TANGGAL_LAHIR_PENERIMA').val(),
            TANGGAL_LAHIR_PENERIMA = TANGGAL_LAHIR_PENERIMA.split("/").reverse().join("-");

        var TANGGAL_DOKUMEN_PENYALURAN = $('#TANGGAL_DOKUMEN_PENYALURAN').val(),
            TANGGAL_DOKUMEN_PENYALURAN = TANGGAL_DOKUMEN_PENYALURAN.split("/").reverse().join("-");

        var TANGGAL_KEJADIAN_BENCANA = $('#TANGGAL_KEJADIAN_BENCANA').val(),
            TANGGAL_KEJADIAN_BENCANA = TANGGAL_KEJADIAN_BENCANA.split("/").reverse().join("-");

        var form_data = {
            CODE_MD5: $('#CODE_MD5').val(),
            ID_JENIS_BENCANA: $('#ID_JENIS_BENCANA').val(),
            NAMA_PEGAWAI_BPBD: $('#NAMA_PEGAWAI_BPBD').val(),
            NIK_PEGAWAI_BPBD: $('#NIK_PEGAWAI_BPBD').val(),
            NIP_PEGAWAI_BPBD: $('#NIP_PEGAWAI_BPBD').val(),
            JABATAN_PEGAWAI_BPBD: $('#JABATAN_PEGAWAI_BPBD').val(),
            NAMA_PENERIMA: $('#NAMA_PENERIMA').val(),
            NOMOR_KK_PENERIMA: $('#NOMOR_KK_PENERIMA').val(),
            NIK_PENERIMA: $('#NIK_PENERIMA').val(),
            TANGGAL_LAHIR_PENERIMA: TANGGAL_LAHIR_PENERIMA,
            TEMPAT_LAHIR_PENERIMA: $('#TEMPAT_LAHIR_PENERIMA').val(),
            NIP_PENERIMA: $('#NIP_PENERIMA').val(),
            JABATAN_PENERIMA: $('#JABATAN_PENERIMA').val(),
            INSTANSI_PENERIMA: $('#INSTANSI_PENERIMA').val(),
            ID_KABUPATEN_KOTA: $('#ID_KABUPATEN_KOTA').val(),
            ID_KECAMATAN: $('#ID_KECAMATAN').val(),
            ID_DESA_KELURAHAN: $('#ID_DESA_KELURAHAN').val(),
            RW: $('#RW').val(),
            RT: $('#RT').val(),
            KAMPUNG: $('#KAMPUNG').val(),
            KODE_POS: $('#KODE_POS').val(),
            TANGGAL_DOKUMEN_PENYALURAN: TANGGAL_DOKUMEN_PENYALURAN,
            TANGGAL_KEJADIAN_BENCANA: TANGGAL_KEJADIAN_BENCANA
        };

        $.ajax({
            url: "<?php echo site_url('Penyaluran/simpan_data_penyaluran_bantuan'); ?>",
            type: 'POST',
            data: form_data,
            success: function(data) {
                if (data != '') {
                    $('#alert-msg').html('<div class="alert alert-danger">' + data +
                        '</div>');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Penyaluran/get_data_penyaluran_bantuan_baru') ?>",
                        dataType: "JSON",
                        data: form_data,
                        success: function(data) {
                            $.each(data, function() {
                                if (data == 'BELUM ADA PENYALURAN') {
                                    $('#alert-msg').html(
                                        '<div class="alert alert-danger">' +
                                        data + '</div>');
                                } else {
                                    window.location.href =
                                        '<?php echo base_url(); ?>Penyaluran_form/index/' +
                                        data.HASH_MD5_PENYALURAN;
                                }
                            });
                        }
                    });
                }
            }
        });
        return false;
    });

    $('#btn_buat').click(function() {

        $.ajax({
            url: "<?php echo site_url('PENYALURAN/generate_md5'); ?>",
            type: 'POST',
            success: function(data) {

                $('[name="CODE_MD5"]').val(data);
                console.log(data);
                $('#ModalAdd').modal('show');

            }
        });
        return false;
    });

});
</script>

</body>

</html>