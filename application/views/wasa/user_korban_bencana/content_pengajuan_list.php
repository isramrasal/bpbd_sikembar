<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>List Pengajuan Bantuan</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPPB/') ?>">Pengajuan Bantuan</a>
            </li>
            <li class="active">
                <strong>
                    <a>List Pengajuan Bantuan</a>
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
        Sistem menampilkan seluruh pengajuan bantuan yang Anda ajukan.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins" id="ibox1">
                <div class="ibox-title">
                    <h5>Pengajuan Bantuan</h5>
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

                    <a href="#" class="btn btn-primary btn-xs" name="btn_buat" id="btn_buat" data-toggle="modal"
                        data-target="#ModalStatus">
                        <span class="fa fa-plus"></span> Buat Pengajuan Bantuan
                    </a>

                    </br>
                    </br>
                    <!-- List jenis bencana -->
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

                    <<div class="table-responsive">
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

<!-- Modal Add -->
<div class="modal fade" id="ModalStatus" tabindex="-1" role="dialog" aria-labelledby="ModalStatusLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalStatusLabel">Pilih Pengajuan Bantuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <button type="button" class="btn btn-primary" id="btn_perorangan">Pengajuan Bantuan Perorangan</button>
                <button type="button" class="btn btn-primary" id="btn_perwakilan">Pengajuan Bantuan Perwakilan</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL Pengajuan Bantuan Perorangan -->
<div class="modal inmodal fade" id="ModalPerorangan" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 70vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Buat Pengajuan Bantuan Perorangan</h4>
                <small class="font-bold">Silakan isi identitas formulir pengajuan bantuan perorangan</small>
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
                                <option value='Angin Puting Beliung'>Angin Puting Beliung</option>
                                <option value='Banjir'>Banjir</option>
                                <option value='Erupsi Gunung Api'>Erupsi Gunung Api</option>
                                <option value='Gempa Bumi'>Gempa Bumi</option>
                                <option value='Kebakaran Rumah'>Kebakaran Rumah</option>
                                <option value='Kebakaran Hutan dan Lahan'>Kebakaran Hutan dan Lahan</option>
                                <option value='Kekeringan'>Kekeringan</option>
                                <option value='Tanah Longsor'>Tanah Longsor</option>
                                <option value='Pohon Tumbang'>Pohon Tumbang</option>
                                <option value='Tsunami'>Tsunami</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama Pemohon *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NAMA_PEMOHON" id="NAMA_PEMOHON"
                                placeholder="Contoh: Nurul Fitri" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">NIK Pemohon *</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control" value="" name="NIK" id="NIK"
                                placeholder="Contoh: 3602041211870001" />
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
                        <label class="col-xs-3 control-label">RW *</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control" value="" name="RW" id="RW"
                                placeholder="Contoh: 02" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">RT *</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control" value="" name="RT" id="RT"
                                placeholder="Contoh: 03" />
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
                            <input type="number" class="form-control" value="" name="KODE_POS" id="KODE_POS"
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
                    <div class="form-group" id="data_TANGGAL_DOKUMEN_PENGAJUAN">
                        <label class="col-xs-3 control-label">Tanggal Pengajuan */**</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    id="TANGGAL_DOKUMEN_PENGAJUAN" type="text" class="form-control"
                                    placeholder="dd/mm/yyyy">
                            </div>
                            </br>
                            *wajib diisi
                            </br>
                            **Sistem juga menyimpan tanggal aktual pembuatan pengajuan ini by system
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Buat Pengajuan
                        Bantuan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL ADD-->
</br>

<!-- MODAL Pengajuan Bantuan Perwakilan -->
<div class="modal inmodal fade" id="ModalPerwakilan" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 70vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Buat Pengajuan Bantuan Perwakilan</h4>
                <small class="font-bold">Silakan isi identitas formulir pengajuan bantuan perwakilan</small>
            </div>
            <input type="hidden" class="form-control" value="" name="FILE_NAME_TEMP" id="FILE_NAME_TEMP" disabled />
            <input type="hidden" class="form-control" value="" name="CODE_MD5_PERWAKILAN" id="CODE_MD5_PERWAKILAN"
                disabled />

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Bencana *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_JENIS_BENCANA_PERWAKILAN" class="form-control"
                                id="ID_JENIS_BENCANA_PERWAKILAN">
                                <option value=''>- Pilih Bencana -</option>
                                <option value='Angin Puting Beliung'>Angin Puting Beliung</option>
                                <option value='Banjir'>Banjir</option>
                                <option value='Erupsi Gunung Api'>Erupsi Gunung Api</option>
                                <option value='Gempa Bumi'>Gempa Bumi</option>
                                <option value='Kebakaran Rumah'>Kebakaran Rumah</option>
                                <option value='Kebakaran Hutan dan Lahan'>Kebakaran Hutan dan Lahan</option>
                                <option value='Kekeringan'>Kekeringan</option>
                                <option value='Tanah Longsor'>Tanah Longsor</option>
                                <option value='Pohon Tumbang'>Pohon Tumbang</option>
                                <option value='Tsunami'>Tsunami</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Nama Pemohon *</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="NAMA_PEMOHON_PERWAKILAN"
                                id="NAMA_PEMOHON_PERWAKILAN" placeholder="Contoh: Nurul Fitri" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Jumlah Korban yang Diwakili *</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control" value="" name="JUMLAH_KORBAN_DIWAKILI"
                                id="JUMLAH_KORBAN_DIWAKILI" placeholder="Contoh: 10" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">NIK *</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control" value="" name="NIK_PERWAKILAN" id="NIK_PERWAKILAN"
                                placeholder="Contoh: 3602041211870001" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">NIP</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control" value="" name="NIP" id="NIP"
                                placeholder="Contoh: 3602041211870001" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Jabatan</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="JABATAN" id="JABATAN"
                                placeholder="Contoh: Kepala sub seksi" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Instansi</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="INSTANSI" id="INSTANSI"
                                placeholder="Contoh: Universitas Gunadarma" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kabupaten/Kota *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_KABUPATEN_KOTA_PERWAKILAN" class="form-control"
                                id="ID_KABUPATEN_KOTA_PERWAKILAN">
                                <option value=''>- Pilih Kabupaten/Kota -</option>
                                <option value='Cianjur'>Cianjur</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kecamatan *</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_KECAMATAN_PERWAKILAN" class="form-control"
                                id="ID_KECAMATAN_PERWAKILAN">
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
                            <select class="chosen-select" name="ID_DESA_KELURAHAN_PERWAKILAN" class="form-control"
                                id="ID_DESA_KELURAHAN_PERWAKILAN">
                                <option value=''>- Pilih Desa/Kelurahan -</option>
                                <option value='Bojongkaso'>Bojongkaso</option>
                                <option value='Bunisari'>Bunisari</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">RW *</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control" value="" name="RW_PERWAKILAN" id="RW_PERWAKILAN"
                                placeholder="Contoh: 02" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">RT *</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control" value="" name="RT_PERWAKILAN" id="RT_PERWAKILAN"
                                placeholder="Contoh: 03" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Kampung</label>
                        <div class="col-xs-9">
                            <input type="text" class="form-control" value="" name="KAMPUNG_PERWAKILAN"
                                id="KAMPUNG_PERWAKILAN" placeholder="Contoh: Kp. Ciater" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-3 control-label">Kode Pos</label>
                        <div class="col-xs-9">
                            <input type="number" class="form-control" value="" name="KODE_POS_PERWAKILAN"
                                id="KODE_POS_PERWAKILAN" placeholder="Contoh: 43273" />
                        </div>
                    </div>
                    <div class="form-group" id="data_TANGGAL_KEJADIAN_BENCANA_PERWAKILAN">
                        <label class="col-xs-3 control-label">Tanggal Kejadian Bencana *</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    id="TANGGAL_KEJADIAN_BENCANA_PERWAKILAN" name="TANGGAL_KEJADIAN_BENCANA_PERWAKILAN"
                                    type="text" class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="data_TANGGAL_DOKUMEN_PENGAJUAN_PERWAKILAN">
                        <label class="col-xs-3 control-label">Tanggal Pengajuan */**</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    id="TANGGAL_DOKUMEN_PENGAJUAN_PERWAKILAN"
                                    name="TANGGAL_DOKUMEN_PENGAJUAN_PERWAKILAN" type="text" class="form-control"
                                    placeholder="dd/mm/yyyy">
                            </div>
                            </br>
                            *wajib diisi
                            </br>
                            **Sistem juga menyimpan tanggal aktual pembuatan pengajuan ini by system
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan_perwakilan"><i class="fa fa-save"></i>
                        Buat Pengajuan Bantuan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end modal perwakilan -->
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

    $('#data_TANGGAL_DOKUMEN_PENGAJUAN .input-group.date').datepicker({
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

    $('#data_TANGGAL_DOKUMEN_PENGAJUAN_PERWAKILAN .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#data_TANGGAL_KEJADIAN_BENCANA_PERWAKILAN .input-group.date').datepicker({
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
        var form_data = {
            ID_JENIS_BENCANA_LIST: $('#ID_JENIS_BENCANA_LIST').val()
        };

        var ID_JENIS_BENCANA_LIST = $('#ID_JENIS_BENCANA_LIST').val();
        var NAMA_BENCANA = $('#ID_JENIS_BENCANA_LIST option:selected').text();
        var JUDUL = "List Data Korban " + NAMA_BENCANA;

        $("#mydata").dataTable().fnDestroy();
        $('#ibox1').children('.ibox-content').toggleClass('sk-loading');

        var url =
            ID_JENIS_BENCANA_LIST === "Semua" ?
            "<?php echo base_url(); ?>/Pengajuan/list_pengajuan_by_all_bencana" :
            "<?php echo base_url(); ?>/Pengajuan/list_pengajuan_by_all_bencana";

        $.ajax({
            url: url,
            method: "POST",
            data: form_data,
            async: false,
            dataType: 'json',
            success: function(data) {
                console.log(data);

                var html = '';
                var html_head =
                    '<tr><th></th><th>Jenis Bencana</th><th>Nama Korban</th><th>Jumlah Korban Diwakili</th><th>NIK</th><th>Instansi</th><th>Kecamatan Bencana</th><th>Desa/Kelurahan Bencana</th><th>Tanggal Kejadian Bencana</th><th>Tanggal Pengajuan</th><th>Proses Pengajuan</th></tr>';

                if (data && data.length > 0) {
                    data.forEach(function(item) {
                        html += `
                            <tr>
                                <td>
                                    <a href="<?php echo base_url(); ?>Pengajuan_form/index_perwakilan/${item.CODE_MD5}" class="btn btn-default btn-xs btn-outline">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                                <td>${item.Jenis_Bencana}</td>
                                <td>${item.Nama_Pemohon}</td>
                                <td>${item.Jumlah_Korban_Diwakili}</td>
                                <td>${item.NIK}</td>
                                <td>${item.Instansi}</td>
                                <td>${item.Kecamatan_Bencana}</td>
                                <td>${item.Desa_Kelurahan_Bencana}</td>
                                <td>${item.TANGGAL_KEJADIAN_BENCANA}</td>
                                <td>${item.Tanggal_Pembuatan}</td>
                                <td>${item.STATUS_PENGAJUAN}</td>
                            </tr>`;
                    });
                } else {
                    html =
                        '<tr><td colspan="9" class="text-center text-danger">Data tidak tersedia</td></tr>';
                }

                $('#show_data_head').html(html_head);
                $('#show_data').html(html);

                $('#mydata').dataTable({
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

                // Stop loading animation
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            },
            error: function(error) {
                console.error("Error:", error);

                $('#show_data').html(
                    '<tr><td colspan="9" class="text-center text-danger">Gagal memuat data</td></tr>'
                );
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            }
        });
    });


    //SIMPAN DATA
    $('#btn_simpan').click(function() {

        var TANGGAL_DOKUMEN_PENGAJUAN = $('#TANGGAL_DOKUMEN_PENGAJUAN').val(),
            TANGGAL_DOKUMEN_PENGAJUAN = TANGGAL_DOKUMEN_PENGAJUAN.split("/").reverse().join("-");

        var TANGGAL_KEJADIAN_BENCANA = $('#TANGGAL_KEJADIAN_BENCANA').val(),
            TANGGAL_KEJADIAN_BENCANA = TANGGAL_KEJADIAN_BENCANA.split("/").reverse().join("-");



        var form_data = {
            CODE_MD5: $('#CODE_MD5').val(),
            ID_JENIS_BENCANA: $('#ID_JENIS_BENCANA').val(),
            NAMA_PEMOHON: $('#NAMA_PEMOHON').val(),
            NIK: $('#NIK').val(),
            // NIP: $('#NIP').val(),
            // JABATAN: $('#JABATAN').val(),
            // INSTANSI: $('#INSTANSI').val(),
            ID_KABUPATEN_KOTA: $('#ID_KABUPATEN_KOTA').val(),
            ID_KECAMATAN: $('#ID_KECAMATAN').val(),
            ID_DESA_KELURAHAN: $('#ID_DESA_KELURAHAN').val(),
            RW: $('#RW').val(),
            RT: $('#RT').val(),
            KAMPUNG: $('#KAMPUNG').val(),
            KODE_POS: $('#KODE_POS').val(),
            TANGGAL_DOKUMEN_PENGAJUAN: TANGGAL_DOKUMEN_PENGAJUAN,
            TANGGAL_KEJADIAN_BENCANA: TANGGAL_KEJADIAN_BENCANA
        };

        $.ajax({
            url: "<?php echo site_url('Pengajuan/simpan_data_pengajuan_bantuan'); ?>",
            type: 'POST',
            data: form_data,
            success: function(data) {
                if (data != '') {
                    $('#alert-msg').html('<div class="alert alert-danger">' + data +
                        '</div>');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Pengajuan/get_data_pengajuan_bantuan_baru') ?>",
                        dataType: "JSON",
                        data: form_data,
                        success: function(data) {
                            $.each(data, function() {
                                if (data == 'BELUM ADA PENGAJUAN') {
                                    $('#alert-msg').html(
                                        '<div class="alert alert-danger">' +
                                        data + '</div>');
                                } else {
                                    window.location.href =
                                        '<?php echo base_url(); ?>Pengajuan_form/index/' +
                                        data.CODE_MD5;
                                }
                            });
                        }
                    });
                }
            }
        });
        return false;
    });

    $('#btn_simpan_perwakilan').click(function() {

        // Ambil dan format ulang tanggal dokumen pengajuan
        var TANGGAL_DOKUMEN_PENGAJUAN = $('#TANGGAL_DOKUMEN_PENGAJUAN_PERWAKILAN').val();
        TANGGAL_DOKUMEN_PENGAJUAN = TANGGAL_DOKUMEN_PENGAJUAN.split("/").reverse().join("-");

        // Ambil dan format ulang tanggal kejadian bencana
        var TANGGAL_KEJADIAN_BENCANA = $('#TANGGAL_KEJADIAN_BENCANA_PERWAKILAN').val();
        TANGGAL_KEJADIAN_BENCANA = TANGGAL_KEJADIAN_BENCANA.split("/").reverse().join("-");

        // console.log("Tanggal Dokumen Pengajuan:", TANGGAL_DOKUMEN_PENGAJUAN_PERWAKILAN);
        // console.log("Tanggal Kejadian Bencana:", TANGGAL_KEJADIAN_BENCANA_PERWAKILAN);

        // Kumpulkan data formulir
        var form_data = {
            CODE_MD5_PERWAKILAN: $('#CODE_MD5_PERWAKILAN').val(),
            ID_JENIS_BENCANA_PERWAKILAN: $('#ID_JENIS_BENCANA_PERWAKILAN').val(),
            NAMA_PEMOHON_PERWAKILAN: $('#NAMA_PEMOHON_PERWAKILAN').val(),
            JUMLAH_KORBAN_DIWAKILI: $('#JUMLAH_KORBAN_DIWAKILI').val(),
            NIK_PERWAKILAN: $('#NIK_PERWAKILAN').val(),
            NIP: $('#NIP').val(),
            JABATAN: $('#JABATAN').val(),
            INSTANSI: $('#INSTANSI').val(),
            ID_KABUPATEN_KOTA_PERWAKILAN: $('#ID_KABUPATEN_KOTA_PERWAKILAN').val(),
            ID_KECAMATAN_PERWAKILAN: $('#ID_KECAMATAN_PERWAKILAN').val(),
            ID_DESA_KELURAHAN_PERWAKILAN: $('#ID_DESA_KELURAHAN_PERWAKILAN').val(),
            RW_PERWAKILAN: $('#RW_PERWAKILAN').val(),
            RT_PERWAKILAN: $('#RT_PERWAKILAN').val(),
            KAMPUNG_PERWAKILAN: $('#KAMPUNG_PERWAKILAN').val(),
            KODE_POS_PERWAKILAN: $('#KODE_POS_PERWAKILAN').val(),
            TANGGAL_DOKUMEN_PENGAJUAN_PERWAKILAN: TANGGAL_DOKUMEN_PENGAJUAN,
            TANGGAL_KEJADIAN_BENCANA_PERWAKILAN: TANGGAL_KEJADIAN_BENCANA
        };

        console.log(form_data);

        $.ajax({
            url: "<?php echo site_url('Pengajuan/simpan_data_pengajuan_bantuan_perwakilan'); ?>",
            type: 'POST',
            data: form_data,
            success: function(data) {
                console.log(
                    "Response dari server pada simpan_data_pengajuan_bantuan_perwakilan:",
                    data);
                if (data != '') {
                    $('#alert-msg').html('<div class="alert alert-danger">' + data +
                        '</div>');
                } else {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url('Pengajuan/get_data_pengajuan_bantuan_baru_perwakilan') ?>",
                        dataType: "JSON",
                        data: form_data,
                        success: function(data) {
                            console.log(
                                "Response dari server pada get_data_pengajuan_bantuan_baru:",
                                data);
                            $.each(data, function() {
                                if (data == 'BELUM ADA PENGAJUAN') {
                                    $('#alert-msg').html(
                                        '<div class="alert alert-danger">' +
                                        data + '</div>');
                                } else {
                                    window.location.href =
                                        '<?php echo base_url(); ?>Pengajuan_form/index_perwakilan/' +
                                        data.CODE_MD5;
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(
                                "Error di get_data_pengajuan_bantuan_baru:",
                                xhr.responseText);
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error di simpan_data_pengajuan_bantuan_perwakilan:", xhr
                    .responseText);
                $('#alert-msg').html(
                    '<div class="alert alert-danger">Terjadi kesalahan pada server. Silakan coba lagi nanti.</div>'
                );
            }
        });


        return false;
    });

    $('#btn_perorangan').click(function() {

        $.ajax({
            url: "<?php echo site_url('Pengajuan/generate_md5'); ?>",
            type: 'POST',
            success: function(data) {

                $('[name="CODE_MD5"]').val(data);
                console.log(data);
                $('#ModalPerorangan').modal('show');

            }
        });
        return false;
    });
    $('#btn_perwakilan').click(function() {
        $.ajax({
            url: "<?php echo site_url('Pengajuan/generate_md5'); ?>",
            type: 'POST',
            success: function(data) {
                $('#CODE_MD5_PERWAKILAN').val(
                    data);
                console.log("CODE_MD5 untuk perwakilan: " +
                    data);
                $('#ModalPerwakilan').modal('show');
            }
        });
        return false;
    });

});
</script>

</body>

</html>