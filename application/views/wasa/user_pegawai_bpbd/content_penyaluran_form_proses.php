<?php
function tanggal_indo_full($tanggal, $cetak_hari = false)
{
    if($tanggal == '0000-00-00')
    {
        $tgl_indo = "-";
        return $tgl_indo;
    }

    else if($tanggal == NULL)
    {
        $tgl_indo = "-";
        return $tgl_indo;
    }

    else
    {
        $hari = array ( 1 =>    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu',
                    'Minggu'
                );
                
        $bulan = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        $split 	  = explode('-', $tanggal);
        $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
        
        if ($cetak_hari) {
            $num = date('N', strtotime($tanggal));
            return $hari[$num] . ', ' . $tgl_indo;
        }
        return $tgl_indo;

    }
}
?>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Form Penyaluran</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url() ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/Penyaluran/') ?>">Penyaluran</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form Penyaluran</a>
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

    <!-- Identitas Form Penyaluran -->
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>Formulir Pengisian Item Barang/Jasa Penyaluran Bantuan</h5>
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

                    <li class="" style="display:none;"><a data-toggle="tab" href="#tab-2">Catatan Penyaluran</a></li>

                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <form method="get" class="form-horizontal">
                                <?php
                                if (isset($Penyaluran)) {
                                    foreach ($Penyaluran->result() as $Penyaluran):
                                        ?>


                                <div class="form-group" id="data_TANGGAL_DOKUMEN_PENYALURAN"><label
                                        class="col-sm-2 control-label">Tanggal Dokumen Penyaluran</label>
                                    <div class="col-sm-10">
                                        <?php
                                                if (empty($Penyaluran->Tanggal_Surat)) {
                                                ?>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                                id="TANGGAL_DOKUMEN_PENYALURAN" name="TANGGAL_DOKUMEN_PENYALURAN"
                                                type="text" class="form-control" placeholder="dd/mm/yyyy">
                                        </div>
                                        <?php
                                                } else {
                                                ?>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                                id="TANGGAL_DOKUMEN_PENYALURAN" name="TANGGAL_DOKUMEN_PENYALURAN"
                                                type="text" class="form-control" placeholder="dd/mm/yyyy"
                                                value="<?php echo $Penyaluran->Tanggal_Surat; ?>">
                                        </div>
                                        <?php
                                                }
                                                ?>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Nama Penerima</label>
                                    <div class="col-sm-10"><input name="NAMA_PENERIMA" id="NAMA_PENERIMA" type="text"
                                            class="form-control" value="<?php echo $Penyaluran->Nama_Penerima; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">NIK Penerima</label>
                                    <div class="col-sm-10"><input name="NIK_PENERIMA" id="NIK_PENERIMA" type="text"
                                            class="form-control" value="<?php echo $Penyaluran->NIK_Penerima; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">NIP Penerima</label>
                                    <div class="col-sm-10"><input name="NIP_PENERIMA" id="NIP_PENERIMA" type="text"
                                            class="form-control" value="<?php echo $Penyaluran->NIP_Penerima; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Jabatan Penerima</label>
                                    <div class="col-sm-10"><input name="JABATAN_PENERIMA" id="JABATAN_PENERIMA"
                                            type="text" class="form-control"
                                            value="<?php echo $Penyaluran->Jabatan_Penerima; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Instansi</label>
                                    <div class="col-sm-10"><input name="INSTANSI_PENERIMA" id="INSTANSI_PENERIMA"
                                            type="text" class="form-control"
                                            value="<?php echo $Penyaluran->Instansi_Penerima; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Kampung Bencana</label>
                                    <div class="col-sm-10"><input name="KAMPUNG_BENCANA" id="KAMPUNG_BENCANA"
                                            type="text" class="form-control"
                                            value="<?php echo $Penyaluran->Kampung_Bencana; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">RT</label>
                                    <div class="col-sm-10"><input name="RT_BENCANA" id="RT_BENCANA" type="text"
                                            class="form-control" value="<?php echo $Penyaluran->RT_Bencana; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">RW</label>
                                    <div class="col-sm-10"><input name="RW_BENCANA" id="RW_BENCANA" type="text"
                                            class="form-control" value="<?php echo $Penyaluran->RW_Bencana; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Desa/Kelurahan</label>
                                    <div class="col-sm-10"><input name="DESA_KELURAHAN_BENCANA"
                                            id="DESA_KELURAHAN_BENCANA" type="text" class="form-control"
                                            value="<?php echo $Penyaluran->Desa_Kelurahan_Bencana; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Kecamatan</label>
                                    <div class="col-sm-10"><input name="KECAMATAN_BENCANA" id="KECAMATAN_BENCANA"
                                            type="text" class="form-control"
                                            value="<?php echo $Penyaluran->Kecamatan_Bencana; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Kabupaten/Kota</label>
                                    <div class="col-sm-10"><input name="KABUPATEN_KOTA_BENCANA"
                                            id="KABUPATEN_KOTA_BENCANA" type="text" class="form-control"
                                            value="<?php echo $Penyaluran->Kabupaten_Kota_Bencana; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Kode Pos</label>
                                    <div class="col-sm-10"><input name="KODE_POS_BENCANA" id="KODE_POS_BENCANA"
                                            type="text" class="form-control"
                                            value="<?php echo $Penyaluran->Kode_Pos_Bencana; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Jenis Bencana</label>
                                    <div class="col-sm-10"><input name="JENIS_BENCANA" id="JENIS_BENCANA" type="text"
                                            class="form-control" value="<?php echo $Penyaluran->Jenis_Bencana; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Nama Pegawai BPBD</label>
                                    <div class="col-sm-10"><input name="NAMA_PEJABAT_BPBD" id="NAMA_PEJABAT_BPBD"
                                            type="text" class="form-control"
                                            value="<?php echo $Penyaluran->Nama_Pejabat_BPBD; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">NIK Pegawai BPBD</label>
                                    <div class="col-sm-10"><input name="NIK_PEJABAT_BPBD" id="NIK_PEJABAT_BPBD"
                                            type="text" class="form-control"
                                            value="<?php echo $Penyaluran->NIK_Pejabat_BPBD; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">NIP Pegawai BPBD</label>
                                    <div class="col-sm-10"><input name="NIP_PEJABAT_BPBD" id="NIP_PEJABAT_BPBD"
                                            type="text" class="form-control"
                                            value="<?php echo $Penyaluran->NIP_Pejabat_BPBD; ?>">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Jabatan Pegawai
                                        BPBD</label>
                                    <div class="col-sm-10"><input name="JABATAN_PEJABAT_BPBD" id="JABATAN_PEJABAT_BPBD"
                                            type="text" class="form-control"
                                            value="<?php echo $Penyaluran->Jabatan_Pejabat_BPBD; ?>">
                                    </div>
                                </div>
                                <div class="form-group" id="data_TANGGAL_KEJADIAN_BENCANA"><label
                                        class="col-sm-2 control-label">Tanggal Kejadian Bencana</label>
                                    <div class="col-sm-10">
                                        <?php
                                                if (empty($Penyaluran->TANGGAL_KEJADIAN_BENCANA)) {
                                                ?>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                                id="TANGGAL_KEJADIAN_BENCANA" name="TANGGAL_KEJADIAN_BENCANA"
                                                type="text" class="form-control" placeholder="dd/mm/yyyy">
                                        </div>
                                        <?php
                                                } else {
                                                ?>
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                                id="TANGGAL_KEJADIAN_BENCANA" name="TANGGAL_KEJADIAN_BENCANA"
                                                type="text" class="form-control" placeholder="dd/mm/yyyy"
                                                value="<?php echo $Penyaluran->TANGGAL_KEJADIAN_BENCANA; ?>">
                                        </div>
                                        <?php
                                                }
                                                ?>
                                    </div>
                                </div>


                                <?php endforeach;
                                } ?>
                            </form>
                            <!-- <div class="hr-line-dashed"></div> -->
                            <div id="alert-msg-4"></div>
                            <button class="btn btn-primary" id="btn_simpan_identitas_form"><i class="fa fa-save"></i>
                                Simpan Identitas Form</button>
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
                                            <span>Catatan Dept. Procurement</span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            </br>
                            <!-- <div class="hr-line-dashed"></div> -->

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- End Identitas Form SPPB -->

    <!-- Form SPPB -->
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Item Barang/Jasa Penyaluran Bantuan</h5>
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
                    <div class="form-horizontal">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#ModalAdd1Item"><span
                                class="fa fa-plus"></span> Tambah Item Barang/Jasa</a>
                        </br>
                        </br>
                        <a href="javascript:;" id="hapus_semua_item" name="hapus_semua_item"
                            class="btn btn-danger text-right" data="<?php echo $CODE_MD5; ?>"><i class="fa fa-trash"
                                aria-hidden="true"></i> Hapus Semua Barang/Jasa</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Merek Barang</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Jumlah Barang</th>
                                    <th>Satuan Barang</th>
                                    <th>Jenis Bantuan</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>

                    <br>
                    <!-- <div class="hr-line-dashed"></div> -->

                    <!-- END OF konten tanggal apply for all -->
                </div>

            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="sm-10">
                            <a href="<?php echo base_url('index.php/Pengajuan_forn/view/'); ?><?php echo $CODE_MD5; ?>"
                                class="btn btn-primary"><span class="fa fa-save"></span> Simpan Perubahan & View Dokumen
                                Penyaluran Bantuan</a>
                            </br>
                            <a href="javascript:;" id="item_edit_kirim_pengajuan" name="item_edit_kirim_pengajuan"
                                class="btn btn-success"
                                data="<?php echo $ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA; ?>"><span
                                    class="fa fa-send"></span>
                                Ajukan Penyaluran Bantuan Untuk Diproses </a><br>
                        </div>
                    </div>
                    <div id="alert-msg-9"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Form Pengajuan -->
</div>

<!-- MODAL ADD 1 ITEM-->
<div class="modal inmodal fade" name="ModalAdd1Item" id="ModalAdd1Item" tabindex="-1" role="dialog"
    aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Tambah Item Penyaluran Barang Bantuan</h4>
                <small class="font-bold">Silakan isi data Item Penyaluran Barang Bantuan yang Anda Butuhkan</small></br>
            </div>
            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-xs-2 control-label">Identitas Penyaluran Barang Bantuan</label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Bantuan*</label>
                        <div class="col-xs-9">
                            <select name="JENIS_BANTUAN_4" class="form-control" id="JENIS_BANTUAN_4">
                                <option value=''>- Pilih Jenis Bantuan -</option>
                                <optgroup label="Barang Kebutuhan Dasar (Esensial)">
                                    <option value='Pangan'>Pangan: Makanan instan, air minum, susu formula</option>
                                    <option value='Pakaian'>Pakaian: Layak pakai, selimut, jaket, sarung</option>
                                    <option value='Peralatan Kebersihan'>Peralatan Kebersihan: Sabun, pasta gigi, popok
                                        bayi</option>
                                </optgroup>
                                <optgroup label="Barang Medis">
                                    <option value='Obat-obatan dasar'>Obat-obatan dasar: Antiseptik, obat flu, obat
                                        diare</option>
                                    <option value='Peralatan Medis'>Peralatan Medis: Masker, perban, alat pengukur
                                        tekanan darah</option>
                                    <option value='Vitamin dan Suplemen'>Vitamin dan Suplemen</option>
                                </optgroup>
                                <optgroup label="Barang untuk Tempat Tinggal Sementara">
                                    <option value='Tenda Darurat'>Tenda darurat</option>
                                    <option value='Terpal'>Terpal</option>
                                    <option value='Matras atau Alas Tidur'>Matras atau alas tidur</option>
                                </optgroup>
                                <optgroup label="Barang untuk Keperluan Balita dan Lansia">
                                    <option value='Susu Formula dan Botol Susu'>Susu formula, botol susu</option>
                                    <option value='Popok dan Mainan Sederhana'>Popok bayi, mainan sederhana</option>
                                    <option value='Kursi Roda atau Alat Bantu Jalan'>Kursi roda, alat bantu jalan
                                    </option>
                                </optgroup>
                                <optgroup label="Barang untuk Pemulihan Psikologis">
                                    <option value='Mainan Edukasi'>Mainan edukasi untuk anak-anak</option>
                                    <option value='Buku atau Alat Tulis'>Buku atau alat tulis</option>
                                    <option value='Papan Permainan'>Papan permainan atau barang penghibur</option>
                                </optgroup>
                                <optgroup label="Barang Kebersihan Lingkungan">
                                    <option value='Karbol atau Disinfektan'>Karbol atau disinfektan</option>
                                    <option value='Alat Kebersihan'>Alat kebersihan: Sapu, pel, kantong sampah</option>
                                    <option value='Masker dan Sarung Tangan'>Masker dan sarung tangan</option>
                                </optgroup>
                                <optgroup label="Barang untuk Memasak">
                                    <option value='Kompor Portabel'>Kompor portabel</option>
                                    <option value='Gas atau Bahan Bakar'>Gas atau bahan bakar</option>
                                    <option value='Peralatan Memasak'>Peralatan memasak: Panci, wajan, sendok, piring
                                    </option>
                                </optgroup>
                                <optgroup label="Barang Lainnya">
                                    <option value='Power Bank atau Alat Penerangan'>Power bank, alat penerangan</option>
                                    <option value='Generator Listrik'>Generator listrik</option>
                                    <option value='Sandal atau Sepatu'>Sandal atau sepatu</option>
                                </optgroup>
                                <optgroup label="Barang untuk Rehabilitasi dan Rekonstruksi">
                                    <option value='Peralatan Bangunan'>Peralatan bangunan: Palang, paku, gergaji, sekop
                                    </option>
                                    <option value='Bahan Bangunan'>Bahan bangunan: Semen, kayu, batu bata</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang*</label>
                        <div class="col-xs-9">
                            <input name="NAMA_4" id="NAMA_4" class="form-control" type="text"
                                placeholder="Contoh : Mie Instan">
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_4" id="MEREK_4" class="form-control" type="text"
                                placeholder="Contoh : Indomie">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_4" id="SPESIFIKASI_SINGKAT_4" class="form-control"
                                type="text" placeholder="Contoh: Indomie Goreng 85gram ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang*</label>
                        <div class="col-xs-9">
                            <input class="touchspin1" type="number" name="JUMLAH_BARANG_4" id="JUMLAH_BARANG_4">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang*</label>
                        <div class="col-xs-9">
                            <input name="SATUAN_BARANG_4" id="SATUAN_BARANG_4" class="form-control" type="text"
                                placeholder="Contoh : Kardus, Botol, Liter, Box, Pcs, dll">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN_4" id="KETERANGAN_4" class="form-control" type="text"
                                placeholder="Contoh: Belum termasuk peralatan makan">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3"></label>
                        <div class="col-xs-9"> * Wajib diisi
                        </div>
                    </div>

                    </br>
                    <div id="alert-msg-1"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_simpan_data_1_item"><i class="fa fa-save"></i>
                        Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL ADD 1 ITEM-->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Ubah Item Barang Bantuan</h4>
                <small class="font-bold">Silakan edit data item barang bantuan yang Anda butuhkan</small>
            </div>
            <?php $attributes = array("ID_SPPB_barang2" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_ITEM_FORM_PENGAJUAN_BARANG_2" id="ID_ITEM_FORM_PENGAJUAN_BARANG_2"
                        class="form-control" type="hidden" readonly>

                    <div class="form-group row">
                        <label class="col-xs-2 control-label">Identitas Barang/Jasa</label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Bantuan*</label>
                        <div class="col-xs-9">
                            <select name="JENIS_BANTUAN_2" class="form-control" id="JENIS_BANTUAN_2">
                                <option value=''>- Pilih Jenis Bantuan -</option>
                                <optgroup label="Barang Kebutuhan Dasar (Esensial)">
                                    <option value='Pangan'>Pangan: Makanan instan, air minum, susu formula</option>
                                    <option value='Pakaian'>Pakaian: Layak pakai, selimut, jaket, sarung</option>
                                    <option value='Peralatan Kebersihan'>Peralatan Kebersihan: Sabun, pasta gigi, popok
                                        bayi</option>
                                </optgroup>
                                <optgroup label="Barang Medis">
                                    <option value='Obat-obatan dasar'>Obat-obatan dasar: Antiseptik, obat flu, obat
                                        diare</option>
                                    <option value='Peralatan Medis'>Peralatan Medis: Masker, perban, alat pengukur
                                        tekanan darah</option>
                                    <option value='Vitamin dan Suplemen'>Vitamin dan Suplemen</option>
                                </optgroup>
                                <optgroup label="Barang untuk Tempat Tinggal Sementara">
                                    <option value='Tenda Darurat'>Tenda darurat</option>
                                    <option value='Terpal'>Terpal</option>
                                    <option value='Matras atau Alas Tidur'>Matras atau alas tidur</option>
                                </optgroup>
                                <optgroup label="Barang untuk Keperluan Balita dan Lansia">
                                    <option value='Susu Formula dan Botol Susu'>Susu formula, botol susu</option>
                                    <option value='Popok dan Mainan Sederhana'>Popok bayi, mainan sederhana</option>
                                    <option value='Kursi Roda atau Alat Bantu Jalan'>Kursi roda, alat bantu jalan
                                    </option>
                                </optgroup>
                                <optgroup label="Barang untuk Pemulihan Psikologis">
                                    <option value='Mainan Edukasi'>Mainan edukasi untuk anak-anak</option>
                                    <option value='Buku atau Alat Tulis'>Buku atau alat tulis</option>
                                    <option value='Papan Permainan'>Papan permainan atau barang penghibur</option>
                                </optgroup>
                                <optgroup label="Barang Kebersihan Lingkungan">
                                    <option value='Karbol atau Disinfektan'>Karbol atau disinfektan</option>
                                    <option value='Alat Kebersihan'>Alat kebersihan: Sapu, pel, kantong sampah</option>
                                    <option value='Masker dan Sarung Tangan'>Masker dan sarung tangan</option>
                                </optgroup>
                                <optgroup label="Barang untuk Memasak">
                                    <option value='Kompor Portabel'>Kompor portabel</option>
                                    <option value='Gas atau Bahan Bakar'>Gas atau bahan bakar</option>
                                    <option value='Peralatan Memasak'>Peralatan memasak: Panci, wajan, sendok, piring
                                    </option>
                                </optgroup>
                                <optgroup label="Barang Lainnya">
                                    <option value='Power Bank atau Alat Penerangan'>Power bank, alat penerangan</option>
                                    <option value='Generator Listrik'>Generator listrik</option>
                                    <option value='Sandal atau Sepatu'>Sandal atau sepatu</option>
                                </optgroup>
                                <optgroup label="Barang untuk Rehabilitasi dan Rekonstruksi">
                                    <option value='Peralatan Bangunan'>Peralatan bangunan: Palang, paku, gergaji, sekop
                                    </option>
                                    <option value='Bahan Bangunan'>Bahan bangunan: Semen, kayu, batu bata</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang*</label>
                        <div class="col-xs-9">
                            <input name="NAMA_2" id="NAMA_2" class="form-control" type="text"
                                placeholder="Contoh : Mie Instan">
                        </div>
                    </div>
                    <div id="alert-msg"></div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_2" id="MEREK_2" class="form-control" type="text"
                                placeholder="Contoh : Indomie">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_2" id="SPESIFIKASI_SINGKAT_2" class="form-control"
                                type="text" placeholder="Contoh: Indomie Goreng 85gram ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang*</label>
                        <div class="col-xs-9">
                            <input class="touchspin1" type="number" name="JUMLAH_BARANG_2" id="JUMLAH_BARANG_2">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang*</label>
                        <div class="col-xs-9">
                            <input name="SATUAN_BARANG_2" id="SATUAN_BARANG_2" class="form-control" type="text"
                                placeholder="Contoh : Kardus, Botol, Liter, Box, Pcs, dll">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN_2" id="KETERANGAN_2" class="form-control" type="text"
                                placeholder="Contoh: Belum termasuk peralatan makan">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3"></label>
                        <div class="col-xs-9"> * Wajib diisi
                        </div>
                    </div>

                    </br>
                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->

<!-- MODAL EDIT Ajukan SPPB-->
<!-- <div class="modal inmodal fade" id="ModalEditKirimSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Ajukan SPPB</h4>
                <small class="font-bold">Selesaikan proses dan ajukan Form SPPB ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_SPPB7" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_kirim_sppb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SPPB7" id="ID_SPPB7" class="form-control" type="hidden" placeholder="ID SPPB"
                        readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <center>
                            <div class="i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah
                                    selesai melakukan proses form SPPB ini dan menyetujui untuk diproses lebih lanjut
                                </label></div>
                        </center>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang/jasa yang diminta pada SPPB
                                ini
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_tidak_ada_attachment_dokumen" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>
                                Proses tidak dapat dilanjutkan, tidak ada attachment dokumen <b> SPPB Cap Basah </b>
                                yang diminta pada SPPB ini
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item jumlah barang/jasa yang bernilai 0
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_catatan_sppb" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, catatan SPPB belum diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_nama_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item nama barang/jasa yang belum diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_spesifikasi_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item spefisikasi barang/jasa yang belum
                                diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_rab_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item kategori RAB barang/jasa yang belum
                                diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_klasifikasi_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item klasifikasi barang/jasa yang belum
                                diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_satuan_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item satuan barang/jasa yang belum diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_rasd_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item RASD barang/jasa yang belum diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_sub_pekerjaan" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item Jenis Pekerjaan yang belum diisi
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_tanggal_mulai_selesai" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang yang belum diatur tanggal
                                mulai</center>
                        </div>
                    </div>


                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_sppb" disabled><i class="fa fa-send"></i>
                        Ajukan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div> -->
<!--END MODAL EDIT ajukan SPPB-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 30vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa SPPB</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus item barang/jasa ini?</p>
                        <div name="NAMA_3" id="NAMA_3"></div>
                    </div>

                </div>
                <div id="alert-msg-8"></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL HAPUS-->

<!--MODAL HAPUS SEMUA-->
<div class="modal fade" id="ModalHapusSemua" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 30vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Semua Item Barang/Jasa SPPB</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode_semua" id="textkode_semua" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus semua item barang/jasa pada SPPB ini?</p>
                        <div name="NAMA_5" id="NAMA_5"></div>
                    </div>

                </div>
                <div id="alert-msg-9"></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-danger" id="btn_hapus_semua"><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL HAPUS-->

<!-- MODAL UPLOAD DOCUMENT BULK -->
<div class="modal inmodal fade" id="ModalEditExcel" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Upload Item Barang/Jasa Secara Bulk</h4>
                <small class="font-bold">Silakan Upload Item Barang/Jasa Secara Bulk</small>
            </div>
            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-info alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        Silakan upload file dokumen sesuai dengan ketentuan .
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="ibox">
                                <div class="ibox-title">
                                    <h5>Upload File Dokumen</h5>
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

                                    <p>
                                        File dokumen yang Anda upload akan digunakan untuk keperluan pengisian item
                                        barang/jasa SPPB Pembelian, dengan ketentuan sebagai berikut:
                                    <ul class="sortable-list connectList agile-list" id="ketentuan">
                                        <li class="warning-element" id="task1">
                                            1. File dokumen yang diupload harus merupakan data berkaitan dengan SPPB No
                                            <?php echo $NO_URUT_SPPB ?>.
                                        </li>
                                        <li class="danger-element" id="task2">
                                            2. Ukuran dokumen yang diterima sistem maksimal 1.5 Giga Bytes (1.5 GB).
                                            Ekstensi/tipe file yang diterima sistem adalah .XLSX
                                        </li>
                                        <li class="success-element" id="task4">
                                            3. File yang diupload berdasarkan template bulk. <a
                                                href="<?php echo base_url(); ?>assets/template/template_sppb_pembelian.xlsx">Download
                                                file template bulk khusus SPPB Pembelian</a>
                                        </li>
                                        <li class="warning-element" id="task1">
                                            4. Isian ID RAB FORM silakan mengacu pada tabel berikut
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Kategori RAB</th>
                                                            <th>ID RAB FORM</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                            if (isset($RAB_list)) {
                                                foreach ($RAB_list->result() as $RAB_list):
                                                ?>
                                                        <tr>
                                                            <td><?php echo $RAB_list->NAMA_KATEGORI; ?></td>
                                                            <td><?php echo $RAB_list->ID_RAB_FORM; ?></td>
                                                        </tr>
                                                        <?php endforeach;
                                            } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </li>
                                        <li class="success-element" id="task4">
                                            5. Isian ID KLASIFIKASI silakan mengacu pada tabel berikut
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Nama Klasifikasi</th>
                                                            <th>ID KLASIFIKASI BARANG</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                            if (isset($RAB_list)) {
                                                foreach ($klasifikasi_barang_list as $klasifikasi):
                                                ?>
                                                        <tr>
                                                            <td><?php echo $klasifikasi->NAMA_KLASIFIKASI_BARANG; ?>
                                                            </td>
                                                            <td><?php echo $klasifikasi->ID_KLASIFIKASI_BARANG; ?></td>
                                                        </tr>
                                                        <?php endforeach;
                                            } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </li>
                                        <li class="danger-element" id="task2">
                                            6. Isian TANGGAL_MULAI_PAKAI_HARI dan TANGGAL_SELESAI_PAKAI_HARI menggunakan
                                            format YYYY-MM-DD, contoh 2023-12-31.
                                        </li>
                                    </ul>
                                    </p>

                                    <form action="#" class="dropzone" id="dropzoneForm">

                                        </br>
                                        <div class="col-xs-9">
                                            <input name="JENIS_FILE_3" id="JENIS_FILE_3" type="hidden"
                                                value="Dokumen Bulk SPPB" readonly>
                                        </div>
                                        </br>
                                        </br>
                                        </br>
                                        </br>
                                        <div class="fallback">
                                            <input name="file" type="file" />
                                        </div>
                                    </form>

                                    <div>
                                        </br>
                                        <button class="btn btn-primary" name="btn_upload" id="btn_upload"><i
                                                class="fa fa-save"></i> Upload</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    </br>
                    </br></br>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL UPLOAD DOCUMENT BULK-->

<!-- MODAL GAGAL UPLOAD DOCUMENT BULK-->
<div class="modal inmodal fade" id="ModalGagalExcel" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        Proses upload gagal. Terdapat simbol yang tidak bisa diproses: mengandung tanda petik dan
                        semicolon.
                        <br>
                        Mohon cek kembali dokumen excel dan upload ulang kembali.
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" id="btn_gagal_upload"><i class="fa fa-window-close"></i>
                        Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL UPLOAD DOCUMENT BULK-->

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/summernote/summernote.min.js"></script>

<!-- TouchSpin -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/datapicker/bootstrap-datepicker.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- DROPZONE -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dropzone/dropzone.js"></script>

<!-- Page-Level Scripts -->
<script>
$(document).ready(function() {

    let ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA =
        <?php echo $ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA ?>;
    let CODE_MD5 = "<?php echo $CODE_MD5 ?>";
    tampil_data_penyaluran_form(); //pemanggilan fungsi tampil data.

    $('#data_TANGGAL_MULAI_PAKAI_HARI_2 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#data_TANGGAL_SELESAI_PAKAI_HARI_2 .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#data_TANGGAL_MULAI_PAKAI_HARI_4 .input-group.date').datepicker({
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

    $('#data_TANGGAL_DOKUMEN_PENGAJUAN .input-group.date').datepicker({
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true,
        format: 'dd/mm/yyyy'
    });

    $('#mydata').dataTable({
        pageLength: 10,
        aaSorting: [],
        lengthMenu: [
            [10, 25, 50, -1],
            [10, 25, 50, 'All'],
        ],
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'excel',
                title: 'SPPB export EXCEL ',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
            },
            {
                extend: 'print',
                orientation: 'landscape',
                title: 'SPPB export',
                pageSize: 'A4',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                },
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                },
            }
        ]

    });


    $("#checkAllrasd").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });


    function tampil_data_penyaluran_form() {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url() ?>Penyaluran_form/data_penyaluran_barang_form',
            async: false,
            dataType: 'json',
            data: {
                ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA: ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA
            },
            success: function(data) {


                var html = '';

                for (l = 0; l < data.length; l++) {
                    html +=
                        '<tr>' +
                        '<td>' + data[l].NAMA_BARANG + '</td>' +
                        '<td>' + data[l].MEREK + '</td>' +
                        '<td>' + data[l].SPESIFIKASI_SINGKAT + '</td>' +
                        '<td>' + data[l].JUMLAH_BARANG + '</td>' +
                        '<td>' + data[l].SATUAN_BARANG + '</td>' +
                        '<td>' + data[l].KLASIFIKASI_BARANG + '</td>' +
                        '<td>' + data[l].KETERANGAN + '</td>' +
                        data[l].NAMA_BARANG +
                        '<td>' +
                        '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' +
                        data[l].ID_ITEM_FORM_PENYALURAN_BARANG +
                        '"><i class="fa fa-pencil"></i> Edit</a>' + ' ' +
                        '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' +
                        data[l].ID_ITEM_FORM_PENYALURAN_BARANG +
                        '"><i class="fa fa-trash"></i> Hapus</a>' +
                        '</td>' +
                        '</tr>';
                }
                $('#show_data').html(html);
            }
        });
    }
    $('#btn_gagal_upload').click(function() {
        location.reload();
    });

    //GET UPDATE untuk edit jumlah
    $('#show_data').on('click', '.item_edit', function() {
        var ID_ITEM_FORM_PENGAJUAN_BARANG = $(this).attr('data');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Pengajuan_form/get_data') ?>",
            dataType: "JSON",
            data: {
                ID_ITEM_FORM_PENGAJUAN_BARANG: ID_ITEM_FORM_PENGAJUAN_BARANG
            },
            success: function(data) {
                console.log(data);

                $('[name="ID_ITEM_FORM_PENGAJUAN_BARANG_2"]').val(data
                    .ID_ITEM_FORM_PENGAJUAN_BARANG);
                $('[name="JENIS_BANTUAN_2"]').val(data.JENIS_BANTUAN);
                $('[name="NAMA_2"]').val(data.NAMA_BARANG);
                $('[name="MEREK_2"]').val(data.MEREK);
                $('[name="SPESIFIKASI_SINGKAT_2"]').val(data.SPESIFIKASI_SINGKAT);
                $('[name="JUMLAH_BARANG_2"]').val(data.JUMLAH_BARANG);
                $('[name="SATUAN_BARANG_2"]').val(data.SATUAN_BARANG);
                $('[name="KETERANGAN_2"]').val(data.KETERANGAN);
                $('#alert-msg-2').html('<div></div>');
                $('#ModalEdit').modal('show');

            }
        });
        return false;
    });


    //GET HAPUS
    $('#show_data').on('click', '.item_hapus', function() {
        var ID_ITEM_FORM_PENGAJUAN_BARANG = $(this).attr('data');
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Pengajuan_form/get_data') ?>",
            dataType: "JSON",
            data: {
                ID_ITEM_FORM_PENGAJUAN_BARANG: ID_ITEM_FORM_PENGAJUAN_BARANG
            },
            success: function(data) {
                $.each(data, function() {
                    $('#ModalHapus').modal('show');
                    $('[name="kode"]').val(ID_ITEM_FORM_PENGAJUAN_BARANG);
                    $('#NAMA_3').html('</br>Nama Barang : ' + data.NAMA_BARANG);

                });
            }
        });
    });

    hapus_semua_item.onclick = function() {
        var id = $(this).attr('data');
        $('#ModalHapusSemua').modal('show');
        $('[name="kode_semua"]').val(id);
        $('#NAMA_5').html('</br>SPPB kode : ' + id);
    };

    // jumlah-+
    $(".touchspin1").TouchSpin({
        buttondown_class: 'btn btn-white',
        buttonup_class: 'btn btn-white',
        min: 0,
        max: 99999999999,
        step: 1.00,
        decimals: 2,
    });


    //SIMPAN DATA
    $('#btn_simpan_data_1_item').click(function() {
        var form_data = {
            ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA: ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA,
            NAMA: $('#NAMA_4').val(),
            MEREK: $('#MEREK_4').val(),
            SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
            SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
            JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
            KLASIFIKASI_BARANG: $('#KLASIFIKASI_BARANG_4').val(),
            KETERANGAN: $('#KETERANGAN_4').val(),

        };
        $.ajax({
            url: "<?php echo site_url('Penyaluran_form/simpan_data_barang_bantuan'); ?>",
            type: 'POST',
            data: form_data,
            success: function(data) {
                if (data != '') {
                    $('#alert-msg-1').html('<div class="alert alert-danger">' + data +
                        '</div>');
                } else {
                    $('#ModalAdd1Item').modal('hide');
                    window.location.reload();
                }
            }
        });
        return false;
    });


    $('#summernote').summernote({
        tabsize: 1,
        height: 420
    });

    //GET UPDATE untuk Upload Excel
    // item_edit_upload_excel.onclick = function() {
    //     $('#ModalEditExcel').modal('show');
    // };
});
</script>

</body>

</html>