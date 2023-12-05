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
        <h2>Form SPP</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/SPP/') ?>">SPP</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form SPP</a>
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

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Formulir Pengajuan SPP</h5>
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
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <form method="get" class="form-horizontal">
                                        <?php
                                        if (isset($SPPB)) {
                                            foreach ($SPPB->result() as $SPPB):
                                                ?>
                                                    <div class="form-group"><label class="col-sm-2 control-label">Proyek</label>
                                                        <div class="col-sm-10"><a href="<?php echo base_url() ?>Proyek/detil_proyek/<?php echo $SPPB->HASH_MD5_PROYEK; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $SPPB->NAMA_PROYEK; ?> </a></div>
                                                    </div>

                                                    <div class="form-group"><label class="col-sm-2 control-label">Pekerjaan</label>
                                                        <div class="col-sm-10"><input name="SUB_PROYEK" id="SUB_PROYEK" type="text"
                                                                class="form-control" value="<?php echo $SPPB->NAMA_SUB_PEKERJAAN; ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="form-group"><label class="col-sm-2 control-label">No. Urut SPPB</label>
                                                        <div class="col-sm-10"><a href="<?php echo base_url() ?>SPPB_form/view/<?php echo $SPPB->HASH_MD5_SPPB; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $SPPB->NO_URUT_SPPB; ?> </a></div>
                                                    </div>
                                            <?php endforeach;
                                            } ?>

                                        <?php
                                        if (isset($SPP)) {
                                            foreach ($SPP->result() as $SPP):
                                                ?>
                                                    <div class="form-group"><label class="col-sm-2 control-label">No. Urut SPP</label>
                                                        <div class="col-sm-10">
                                                                <input name="NO_URUT_SPP_GANTI" id="NO_URUT_SPP_GANTI" type="text" class="form-control"
                                                                value="<?php echo $SPP->NO_URUT_SPP; ?>">
                                                                <input name="NO_URUT_SPP_ASLI" id="NO_URUT_SPP_ASLI" type="hidden" class="form-control" value="<?php echo $SPP->NO_URUT_SPP; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="data_TANGGAL_DOKUMEN_SPP"><label class="col-sm-2 control-label">Tanggal Dokumen SPP</label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            if (empty($SPP->TANGGAL_DOKUMEN_SPP)) {
                                                            ?>
                                                                <div class="input-group date">
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_SPP" name="TANGGAL_DOKUMEN_SPP" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                                                </div>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <div class="input-group date">
                                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_SPP" name="TANGGAL_DOKUMEN_SPP" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $SPP->TANGGAL_DOKUMEN_SPP; ?>">
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>


                                                    <div class="form-group"><label class="col-sm-2 control-label">Tanggal SPP By System</label>
                                                        <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo tanggal_indo_full($SPP->TANGGAL_PEMBUATAN_SPP_HARI_INDO, false); ?>" disabled></div>
                                                    </div>

                                                    <div class="form-group"><label class="col-sm-2 control-label">Jenis Permintaan</label>
                                                        <div class="col-sm-10">
                                                            <select name="JENIS_PERMINTAAN" class="form-control" id="JENIS_PERMINTAAN">
                                                                <option value="<?php echo $SPP->JENIS_PERMINTAAN; ?>" selected><?php echo $SPP->JENIS_PERMINTAAN; ?></option>
                                                                <option value="BIASA">BIASA</option>
                                                                <option value="SEGERA">SEGERA</option>
                                                                <option value="PERSEDIAAN">PERSEDIAAN</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group"><label class="col-sm-2 control-label">Catatan Dokumen
                                                            SPP</label>
                                                        <div class="col-sm-10"><input name="CTT_DEPT_PROC" id="CTT_DEPT_PROC" type="text"
                                                                class="form-control" value="<?php echo $SPP->CTT_DEPT_PROC; ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group"><label class="col-sm-2 control-label">Baris Kosong</label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            if (empty($BARIS_KOSONG)) {
                                                            ?>
                                                                <input name="BARIS_KOSONG" id="BARIS_KOSONG" class="form-control touchspin2" type="number">
                                                                
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <input name="BARIS_KOSONG" id="BARIS_KOSONG" class="form-control touchspin2" type="number" value="<?php echo $BARIS_KOSONG; ?>">
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                <?php endforeach;
                                        } ?>
                                    </form>
                                    <div class="hr-line-dashed"></div>
                                    <div id="alert-msg-4"></div>
                                    <button class="btn btn-primary" id="btn_simpan_identitas_form"><i class="fa fa-save"></i>
                                    Simpan Identitas Form</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins" id="ibox1">
                        <div class="ibox-title">
                            <h5>SPP Item Barang/Jasa</h5>
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
                            <div class="form-horizontal">
                                <div class="alert alert-warning alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    Perubahan data pada form SPP tidak akan mempengaruhi data pada form SPPB Pembelian.
                                </div>
                            </div>
                            <a href="javascript:;" id="tambah_item_sppb" name="tambah_item_sppb" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah Item dari SPPB</a>
                            <br>
                            <a href="javascript:;" id="item_edit_upload_excel" name="item_edit_upload_excel" class="btn btn-warning" data="<?php echo $ID_SPP; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Edit Item Barang/Jasa Secara Bulk</a>
                            <br>
                            <a href="javascript:;" id="hapus_semua_item" name="hapus_semua_item" class="btn btn-danger text-right" data="<?php echo $HASH_MD5_SPP; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Hapus Semua Barang/Jasa</a>

                            <br>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="mydata">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang/Jasa</th>
                                            <th>Merek Barang/Jasa</th>
                                            <th>Spesifikasi Singkat</th>
                                            <th>Kategori RAB dan Klasifikasi Barang</th>
                                            <th>Jumlah Yang Diadakan</th>
                                            <th>Satuan Barang</th>
                                            <th>Item&nbsp;dan&nbsp;Qty&nbsp;RASD</th>                                            
                                            <th>Tanggal Dibutuhkan</th>
                                            <th>Supplier/Vendor</th>
                                            <th>Harga Satuan Barang</th>
                                            <th>Harga Total Barang</th>
                                            <th>Keterangan</th>
                                            <th>Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">

                                    </tbody>

                                </table>
                            </div>

                            <div id="alert-msg-6"></div>

                        </div>
                    </div>

                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Kontrol Anggaran</h5>
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
                        <button class="btn btn-primary" name="btn_kontrol_anggaran" id="btn_kontrol_anggaran"><i class="fa fa-calculator"></i> Tampilkan/Hitung Ulang Kontrol Anggaran</button> </br></br>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="mydata_anggaran">
                                    <thead>
                                        <tr>
                                            <th>Jenis Pekerjaan</th>
                                            <th>Kategori RAB</th>
                                            <th>Rencana Anggaran</th>
                                            <th>Pengadaan Sebelumnya</th>
                                            <th>Pengadaan Saat Ini</th>
                                            <th>Total Pengadaan</th>
                                            <th>Sisa Anggaran</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data_anggaran">
                                        <tr>
                                        </tr>
                                       
                                    </tbody>

                                </table>
                            </div>

                        </div>
                    </div>


                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="form-group">
                                <div class="sm-10">
                                    <a href="javascript:;"  id="btn_simpan_perubahan" name="btn_simpan_perubahan" class="btn btn-primary" data="<?php echo $HASH_MD5_SPP; ?>"><span class="fa fa-save"></span> Simpan Perubahan & View Dokumen SPP</a>
                                    </br>
                                    <a href="javascript:;" id="item_edit_kirim_spp" name="item_edit_kirim_spp" class="btn btn-success" data="<?php echo $ID_SPP; ?>"><span class="fa fa-send"></span> Ajukan SPP Untuk Proses Selanjutnya </a><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MODAL ADD  DARI SPPB -->
<div class="modal inmodal fade" id="ModalAddDariSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <?php
            if ($sppb_barang_list != NULL) {
                ?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Daftar Item Barang/Jasa dari SPPB</h4>
        <small class="font-bold">Silakan tambah item barang/jasa SPP berdasarkan SPPB</small>
    </div>

    <div class="modal-body">

        <div class="ibox float-e-margins" id="ibox2">
            <div class="ibox-title">
                <h5>SPP Item Barang/Jasa</h5>
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
                <div class="table-responsive">

                    <?php
                    foreach ($sppb_barang_list as $data): ?>
                    Sumber SPPB: <a href="<?php echo base_url() ?>SPPB_form/view/<?php echo $SPPB->HASH_MD5_SPPB; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $SPPB->NO_URUT_SPPB; ?> </a>
                    <?php break;?>
                    <?php endforeach;
                    ?>

                    </br>
                    </br>
                    <form method="POST" action="<?php echo site_url('SPP_form/simpan_data_dari_sppb_form'); ?>" id="formTambahSPPB">
                        <table class="table table-striped table-bordered table-hover" id="mydata_SPPB">
                            <thead>
                                <tr>
                                    <th>Pilih<input type="checkbox" id="checkAllItemSPPB"></th>
                                    <th>Nama Barang/Jasa</th>
                                    <th>Merek Barang/Jasa</th>
                                    <th style="width: 30%;">Spesifikasi Singkat</th>
                                    <th>Kategori RAB dan Klasifikasi Barang</th>
                                    <th>Qty SPPB</th>
                                    <th>Qty Realisasi SPP</th>
                                    <th>Qty pada SPP ini</th>
                                    <th>Tanggal Mulai dan Selesai Pemakaian</th>
                                </tr>
                            </thead>
                            <tbody id="show_data_SPPB">

                            </tbody>

                        </table>

                    </form>
                </div>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
        <button class="btn btn-primary" type="submit" form="formTambahSPPB"><i class="fa fa-save"></i> Simpan</button>
    </div>


<?php
} else {
?>
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <i class="fa fa-exclamation-triangle modal-icon"></i>
        <h4 class="modal-title">Daftar Item Barang/Jasa dari SPPB</h4>
        <b class="font-bold">Maaf semua item barang/jasa dari SPPB sudah ada di Form SPP ini atau seluruh item sudah diproses di Form SPP yang lain</b>
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
<!--END MODAL ADD DARI SPPB -->

<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ubah Item Barang/Jasa SPP</h4>
                <small class="font-bold">Silakan edit item barang/jasa SPP</small>
            </div>
            <?php $attributes = array("ID_SPP_FORM_2" => "contact_form", "id" => "contact_form");
            echo form_open("SPP_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SPPB_2" id="ID_SPPB_2" class="form-control" type="hidden" readonly>
                    <input name="ID_SPPB_FORM_2" id="ID_SPPB_FORM_2" class="form-control" type="hidden" readonly>
                    <input name="ID_SPP_2" id="ID_SPP_2" class="form-control" type="hidden" readonly>
                    <input name="ID_SPP_FORM_2" id="ID_SPP_FORM_2" class="form-control" type="hidden" readonly>

                    <div class="form-group row">
                        <label class="col-xs-2 control-label">Identitas Barang/Jasa</label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA_2" id="NAMA_2" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_2" id="MEREK_2" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_2" id="SPESIFIKASI_SINGKAT_2" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG_2" id="JUMLAH_BARANG_2" class="touchspin1" type="number">
                            <input name="JUMLAH_BARANG_ORIGINAL_2" id="JUMLAH_BARANG_ORIGINAL_2" type="hidden">
                            <div id="show_data_sisa">Sisa yang belum terealisasi
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="SATUAN_BARANG_2" id="SATUAN_BARANG_2" class="form-control" type="text">
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Klasifikasi Barang</label>
                        <div class="col-xs-9">
                            <select name="KLASIFIKASI_BARANG_2" class="form-control" id="KLASIFIKASI_BARANG_2">
                                <option value=''>- Pilih Klasifikasi Barang -</option>
                                <?php foreach ($klasifikasi_barang_list as $item) {
                                    echo '<option value="' . $item->ID_KLASIFIKASI_BARANG . '">' . $item->NAMA_KLASIFIKASI_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" id="data_TANGGAL_MULAI_PAKAI_HARI_2">
                        <label class="col-xs-3 control-label">Tanggal Mulai Pemakaian</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    name="TANGGAL_MULAI_PAKAI_HARI_2" id="TANGGAL_MULAI_PAKAI_HARI_2" type="text"
                                    class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                    </div>

                    <div class="form-group" id="data_TANGGAL_SELESAI_PAKAI_HARI_2">
                        <label class="col-xs-3 control-label">Tanggal Selesai Pemakaian</label>
                        <div class="col-xs-9">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                    name="TANGGAL_SELESAI_PAKAI_HARI_2" id="TANGGAL_SELESAI_PAKAI_HARI_2" type="text"
                                    class="form-control" placeholder="dd/mm/yyyy">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN_UMUM_2" id="KETERANGAN_UMUM_2" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenis Pengadaan</label>
                        <div class="col-xs-9">
                            <select class="form-control" name="JENIS_PENGADAAN_2" id="JENIS_PENGADAAN_2">
                                <option value=''>- Pilih Jenis Pengadaan -</option>
                                <option value='Pembelian'>Pembelian</option>
                                <option value='Rental'>Rental</option>
                                <option value='Jasa'>Jasa</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-2 control-label">Sumber Mata Anggaran</label>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-3 control-label">Jenis Pekerjaan</label>
                        <div class="col-xs-9">
                            <select name="ID_PROYEK_SUB_PEKERJAAN_2" class="form-control" disabled
                                id="ID_PROYEK_SUB_PEKERJAAN_2" >
                                <option value=''>- Pilih Jenis Pekerjaan -</option>
                                <?php foreach ($jenis_pekerjaan_list as $item_jenis_pekerjaan_list_2) {
                                    echo '<option value="' . $item_jenis_pekerjaan_list_2->ID_PROYEK_SUB_PEKERJAAN . '">' . $item_jenis_pekerjaan_list_2->NAMA_SUB_PEKERJAAN . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-3 control-label">Kategori RAB</label>
                        <div class="col-xs-9">
                            <select name="ID_RAB_FORM_2" class="form-control" id="ID_RAB_FORM_2" disabled>
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_rab_baru_2" hidden class="form-group row">
                        <label class="col-xs-3 control-label">Nama Kategori RAB (Input Baru)</label>
                        <div class="col-xs-9">
                            <input type="text" name="NAMA_KATEGORI_RAB_2" id="NAMA_KATEGORI_RAB_2" class="form-control" disabled>
                        </div>
                    </div>

                    <div id="show_hidden_item_rab_2" hidden class="form-group row">
                        <label class="col-xs-3 control-label">Item Barang/Jasa RAB</label>
                        <div class="col-xs-9">
                            <select name="ID_RASD_FORM_2" class="form-control" id="ID_RASD_FORM_2" disabled>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-xs-2 control-label">Identitas Vendor Terpilih</label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Vendor</label>
                        <div class="col-xs-9">
                            <select class="form-control" name="ID_VENDOR_2" id="ID_VENDOR_2">
                            </select>
                        </div>
                    </div>

                    <div id="show_hidden_vendor_4" class="form-group" hidden>
                        <label class="control-label col-xs-3">Nama Vendor</label>
                        <div class="col-xs-9">
                            <input type="text" name="NAMA_VENDOR_2" id="NAMA_VENDOR_2" class="form-control" placeholder="Contoh: PT. Pertamina Persero">
                        </div>
                    </div>

                    <div id="show_hidden_vendor_5" class="form-group" hidden>
                        <label class="control-label col-xs-3">Alamat Vendor</label>
                        <div class="col-xs-9">
                            <input type="text" name="ALAMAT_VENDOR_2" id="ALAMAT_VENDOR_2" class="form-control" placeholder="Contoh: JL. TB Simatupang Kavling 28">
                        </div>
                    </div>

                    <div id="show_hidden_vendor_6" class="form-group" hidden>
                        <label class="control-label col-xs-3">No Telepon Vendor</label>
                        <div class="col-xs-9">
                            <input type="text" name="NO_TELP_VENDOR_2" id="NO_TELP_VENDOR_2" class="form-control" placeholder="Contoh: 021-8762812">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_FIX_2" id="HARGA_SATUAN_BARANG_FIX_2" class="form-control" type="text" placeholder="Contoh: Rp 2000000 ">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Total Barang</label>
                        <div class="col-xs-9">

                            <input name="HARGA_TOTAL_FIX_2" id="HARGA_TOTAL_FIX_2" class="form-control" type="hidden" placeholder="Contoh: Rp 14000000 " disabled />
                            <input name="HARGA_TOTAL_TAMPIL_2" id="HARGA_TOTAL_TAMPIL_2" class="form-control" type="text" placeholder="Contoh: Rp 14000000 " disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                            <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya
                                    telah selesai melakukan pengisian identitas, mata anggaran, vendor dan harga pada item barang/jasa dengan benar, menyetujui untuk
                                    dimasukkan ke dalam kontrol anggaran </label></div>
                        </div>

                    </div>


                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" name="btn_update" id="btn_update" disabled><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->


<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 40vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa SPP</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus item barang/jasa ini?</p>
                        <div name="NAMA_3" id="NAMA_3"></div>
                    </div>


                    <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju_hapus"><i></i> Saya dengan sadar dan setuju untuk menghapus item barang/jasa pada SPP ini. Item yang sudah dihapus tidak dapat dipulihkan kembali.</label></div>


                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn_hapus btn btn-danger" id="btn_hapus" disabled><i class="fa fa-trash"></i> Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL HAPUS-->

<!-- MODAL KIRIM SPP-->
<div class="modal inmodal fade" id="ModalEditKirimSPP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Kirim SPP</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form SPP ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_SPP7" => "contact_form", "id" => "contact_form");
            echo form_open("SPPB_form/update_data_kirim_sppb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SPP7" id="ID_SPP7" class="form-control" type="hidden" placeholder="ID_SPP" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju_kirim"><i></i> Saya telah selesai melakukan proses form SPP ini dan menyetujui untuk diproses lebih lanjut </label></div>
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
                            <center>Proses tidak dapat dilanjutkan, tidak ada attachment dokumen SPPB yang diminta pada
                                SPPB
                                ini
                            </center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item jumlah barang/jasa yang bernilai 0
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
                                mulai dan selesai pemakaian</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_harga_minta" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada harga item barang/jasa yang diminta bernilai 0</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_nama_vendor" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada nama vendor yang belum diinput</center>
                        </div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_spp" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM SPP-->

<!-- MODAL UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalEditExcel" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Edit Item Barang/Jasa Secara Bulk</h4>
                <small class="font-bold">Silakan Edit Item Barang/Jasa Secara Bulk</small>
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
                                        File dokumen yang Anda upload akan digunakan untuk keperluan pengisian item barang/jasa SPP, dengan ketentuan sebagai berikut:
                                    <ul class="sortable-list connectList agile-list" id="ketentuan">
                                        <li class="warning-element" id="task1">
                                            1. File dokumen yang diupload harus merupakan data berkaitan dengan SPP No <?php echo $NO_URUT_SPP ?>.
                                        </li>
                                        <li class="danger-element" id="task2">
                                            2. Ukuran dokumen yang diterima sistem maksimal 1.5 Giga Bytes (1.5 GB). Ekstensi/tipe file yang diterima sistem adalah .XLSX
                                        </li>
                                        <li class="success-element" id="task4">
                                            3. File yang diupload berdasarkan isian SPP ini. <a href="<?php echo base_url(); ?>SPP_form/download_excel/<?php echo $HASH_MD5_SPP ?>">Download file bulk khusus SPP ini</a>
                                        </li>
                                        <li class="warning-element" id="task1">
                                            4. Isian kolom ID Vendor silakan downloand pada file berikut <a href="<?php echo base_url(); ?>SPP_form/download_excel_vendor/">Download daftar list vendor</a>
                                            
                                        </li>
                                        <li class="success-element" id="task4">
                                            5. Isian kolom Jenis Pengadaan silakan mengacu pada tabel berikut
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Jenis Pengadaan</th>

                                                        </tr>
                                                        
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Pembelian</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Rental</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Jasa</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </li>
                                        <li class="danger-element" id="task2">
                                            6. Dilarang mengubah kolom ID SPP FORM
                                        </li>
                                    </ul>
                                    </p>

                                    <form action="#" class="dropzone" id="dropzoneForm">

                                        </br>
                                        <div class="col-xs-9">
                                            <input name="ID_SPP" id="ID_SPP" type="hidden" value="<?php echo $ID_SPP ?>" readonly>
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
                                        <button class="btn btn-primary" name="btn_upload" id="btn_upload"><i class="fa fa-save"></i> Upload</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    </br>
                    </br></br>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL UPLOAD DOCUMENT-->


<!-- MODAL MAAF UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalEditExcelMaaf" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Edit Item Barang/Jasa Secara Bulk</h4>
                <small class="font-bold">Silakan Edit Item Barang/Jasa Secara Bulk</small>
            </div>
            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                       Maaf, Anda belum memasukkan item untuk diproses dalam SPP ini. Silakan Tambah Item dari SPPB terlebih dahulu.
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL UPLOAD DOCUMENT-->

<!-- MODAL GAGAL UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalGagalExcel" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 45vw;">
        <div class="modal-content animated bounceInRight">

            <div class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        Proses upload gagal. Terdapat simbol yang tidak bisa diproses: mengandung tanda petik dan semicolon.
                        <br>
                        <br>
                        Mohon cek kembali dokumen excel dan upload ulang kembali.
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" id="btn_gagal_upload"><i class="fa fa-window-close"></i>
                        Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL UPLOAD DOCUMENT-->

<!--MODAL HAPUS SEMUA-->
<div class="modal fade" id="ModalHapusSemua" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 30vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Semua Item Barang/Jasa SPP</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode_semua" id="textkode_semua" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus semua item barang/jasa pada SPP ini?</p>
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


<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

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
    Dropzone.autoDiscover = false;

    Dropzone.options.dropzoneForm = {
        paramName: "file", // The name that will be used to transfer the file
        autoProcessQueue: false,
        maxFilesize: 1500, // MB
        maxFiles: 1,
        dictDefaultMessage: "<strong>Letakkan file di sini atau klik untuk memuat file. </strong></br> (Pastikan file yang Anda upload sesuai dengan ketentuan)",
        dictFileTooBig: "Maaf ukuran file tidak sesuai ketentuan."
    };

    $(document).ready(function() {
        if (document.getElementById('dropzoneForm')) {
            var file_upload = new Dropzone(".dropzone", {
                url: "<?php echo base_url('index.php/SPP_form/proses_upload_file_excel_bulk_spp') ?>",
                maxFilesize: 1500, // MB
                method: "post",
                acceptedFiles: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                paramName: "userfile",
                dictInvalidFileType: "Maaf ekstensi/tipe file tidak sesuai ketentuan.",
                addRemoveLinks: true,
                init: function() {
                    var myDropzone = this;

                    // Update selector to match your button
                    $("#btn_upload").click(function(e) {
                        e.preventDefault();
                        myDropzone.processQueue();
                        var form_data = {
                            ID_SPP: $('#ID_SPP').val()
                        };
                        $.ajax({
                            url: "<?php echo base_url('index.php/SPP_form/proses_upload_file_excel_bulk_spp') ?>",
                            type: 'POST',
                            data: form_data,
                            success: function(data) {
                                if (data != '') {

                                } else {

                                }
                            }
                        });
                    });

                    this.on("success", function(file, responseText) {

                        if (responseText=='Terdapat simbol yang tidak bisa diproses: mengandung tanda petik, koma dan semicolon')
                        {
                            $('#ModalEditExcel').modal('hide')
                            $('#ModalGagalExcel').modal('show');
                                                        
                        }
                        else
                        {
                            location.reload();
                        }

                    });
                }
            });

            //Event ketika Memulai mengupload
            file_upload.on("sending", function(a, b, c) {
                a.token = Math.random();
                c.append("token_npwp", a.token); //Mempersiapkan token untuk masing masing npwp
            });

        }

        var ID_PROYEK = <?php echo $ID_PROYEK ?>;
        var ID_SPPB = <?php echo $ID_SPPB; ?>;
        var ID_SPP = <?php echo $ID_SPP; ?>;
        var HASH_MD5_SPP = '<?php echo $HASH_MD5_SPP; ?>';

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

        $('#data_TANGGAL_DOKUMEN_SPP .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#saya_setuju').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update').attr('disabled', true); //disable input
            }
        });


        $("#ID_VENDOR_2").change(function() {
            if ($("#ID_VENDOR_2 option:selected").text() == '- Tambah Vendor Lainnya -') {
                $('#show_hidden_vendor_4').attr("hidden", false); //enable input
                $('#show_hidden_vendor_5').attr("hidden", false); //enable input
                $('#show_hidden_vendor_6').attr("hidden", false); //enable input
            } else {
                $('#show_hidden_vendor_4').attr("hidden", true); //disable input
                $('#show_hidden_vendor_5').attr("hidden", true); //disable input
                $('#show_hidden_vendor_6').attr("hidden", true); //disable input
            }
        });

        
        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999,
            step: 0.01,
            decimals: 2,
        });

        // jumlah-+
        $(".touchspin2").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 99999999999,
            step: 1,
            decimals: 0,
        });

        $("#checkAllbarangmaster").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#checkAllsppb").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#checkAllItemSPPB").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#checkAllrasd").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        tampil_data_spp_form(); //pemanggilan fungsi tampil data.

        $('#modalmaster').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            aaSorting: [],
        });
        $('#modalrasd').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            aaSorting: [],
        });
        // $('#modalsppb').dataTable({
        //     pageLength: 10,
        //     lengthMenu: [
        //         [10, 25, 50, -1],
        //         [10, 25, 50, 'All'],
        //     ],
        //     responsive: true,
        //     aaSorting: [],
        // });

        //fungsi tampil data
        function tampil_data_spp_form() {
            
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>SPP_form/grup_rab_spp_form',
                async: false,
                dataType: 'json',
                data: {
                    ID_SPP: ID_SPP
                },
                success: function (data) {
                    var html = '';

                    for (l = 0; l < data.length; l++) {

                        ID_RAB_FORM = data[l].ID_RAB_FORM;
                        NAMA_KATEGORI = data[l].NAMA_KATEGORI;

                        html +=
                        '<tr>'+
                        '<td>' + '<b>' + NAMA_KATEGORI + '</b>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '<td>' + '</td>' +
                        '</tr>';

                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() ?>SPP_form/data_spp_form',
                            async: false,
                            dataType: 'json',
                            data: {
                                ID_SPP: ID_SPP,
                                ID_RAB_FORM: ID_RAB_FORM
                            },
                            success: function(data) {

                                var data_1 = data;

                                var i;
                                var jumlah_rasd = 0;
                                var nama_rasd = '';
                                for (i = 0; i < data.length; i++) {
                                    let jumlah_barang = data[i].JUMLAH_BARANG;
                                    let jumlah_rasd = data[i].JUMLAH_RASD;
                                    let kode_barang = data[i].KODE_BARANG;

                                    
                                    var form_data = {
                                        ID_RASD_FORM: data[i].ID_RASD_FORM
                                    };

                                    if (data[i].ID_RASD_FORM == null) {
                                        jumlah_rasd = null;
                                        nama_rasd = null;
                                    }
                                    else {
                                        $.ajax({
                                            url: "<?php echo site_url('SPPB_form/data_qty_rasd') ?>",
                                            type: "POST",
                                            dataType: "JSON",
                                            async: false,
                                            data: form_data,
                                            success: function (data) {
                                                var data_2 = data;

                                                if (data_2[0] == null) {

                                                }
                                                else {
                                                    jumlah_rasd = data_2[0].jumlah_quantity_rasd;
                                                    nama_rasd = data_2[0].NAMA;

                                                    if (jumlah_rasd == null)
                                                    {
                                                        jumlah_rasd = "Deviasi";
                                                    }
                                                }

                                            }
                                        });
                                    }

                                    if (data[i].HARGA_SATUAN_BARANG_FIX == 0 || data[i].HARGA_SATUAN_BARANG_FIX == null) {

                                        data[i].HARGA_SATUAN_BARANG_FIX = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        maximumFractionDigits: 0, 
                                        minimumFractionDigits: 0,
                                        }).format(data[i].HARGA_SATUAN_BARANG_FIX);

                                        HARGA_SATUAN_BARANG_FIX = '<td style="background-color:#DAF7A6">' + data[i].HARGA_SATUAN_BARANG_FIX + '</td>';
                                    }
                                    else
                                    {
   
                                        data[i].HARGA_SATUAN_BARANG_FIX = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        maximumFractionDigits: 0, 
                                        minimumFractionDigits: 0,
                                        }).format(data[i].HARGA_SATUAN_BARANG_FIX);

                                        HARGA_SATUAN_BARANG_FIX = '<td>' + data[i].HARGA_SATUAN_BARANG_FIX + '</td>';
                                    }

                                    if (data[i].HARGA_TOTAL_FIX == 0 || data[i].HARGA_TOTAL_FIX == null) {

                                        data[i].HARGA_TOTAL_FIX = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        maximumFractionDigits: 0, 
                                        minimumFractionDigits: 0,
                                        }).format(data[i].HARGA_TOTAL_FIX);

                                        HARGA_TOTAL_FIX = '<td style="background-color:#DAF7A6">' + data[i].HARGA_TOTAL_FIX + '</td>';
                                    }
                                    else
                                    {

                                        data[i].HARGA_TOTAL_FIX = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR',
                                        maximumFractionDigits: 0, 
                                        minimumFractionDigits: 0,
                                        }).format(data[i].HARGA_TOTAL_FIX);

                                        HARGA_TOTAL_FIX = '<td>' + data[i].HARGA_TOTAL_FIX + '</td>';
                                    }

                                    

                                    // HARGA_TOTAL_FIX = new Intl.NumberFormat('id-ID', {
                                    //     style: 'currency',
                                    //     currency: 'IDR'
                                    // }).format(data[i].HARGA_TOTAL_FIX);

                                    if (data[i].NAMA_VENDOR == null || data[i].NAMA_VENDOR == "") {
                                        NAMA_VENDOR = '<td style="background-color:#DAF7A6">' + data_1[i].NAMA_VENDOR + '</td>';
                                    }
                                    else
                                    {
                                        NAMA_VENDOR = '<td>' + data_1[i].NAMA_VENDOR + '</td>';
                                    }

                                    html += '<tr>' +
                                    // '<td>' + kode_barang_cetak + '</td>' +
                                    '<td>' + data[i].NAMA_BARANG + '</td>' +
                                    '<td>' + data[i].MEREK + '</td>' +
                                    '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                                    '<td>' + 'RAB: ' + data[i].NAMA_KATEGORI + '</br> Klasifikasi:' + data[i].NAMA_KLASIFIKASI_BARANG + '</td>' +
                                    '<td>' + jumlah_barang + '</td>' +
                                    '<td>' + data[i].SATUAN_BARANG + '</td>' +
                                    '<td>' + 'Item: ' + nama_rasd + '</br>' + 'Qty: ' + jumlah_rasd + '</td>' +
                                    '<td>' + data[i].TANGGAL_MULAI_PAKAI_HARI + ' s.d.' + data[i].TANGGAL_SELESAI_PAKAI_HARI + '</td>' +
                                    NAMA_VENDOR +
                                    HARGA_SATUAN_BARANG_FIX +
                                    HARGA_TOTAL_FIX +
                                    '<td>' + data[i].KETERANGAN_UMUM + '</td>' +
                                    '<td>' +
                                    '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_SPP_FORM + '"><i class="fa fa-pencil"></i> Edit </a>' + ' ' +
                                    '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_SPP_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' +
                                    '</td>' +

                                    '</tr>';
                                }
                            }
                        });
                        $('#show_data').html(html);
                    }
                }
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
                        title: 'SPP export EXCEL',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10]
                        },
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

            setTimeout(function(){
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            }, 3000); 
        }

        //fungsi tampil data
        function tampil_data_anggaran() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>SPP_form/data_anggaran', //GET DATA BY ID RAB FORM/ KATEGORI RAB
                async: false,
                dataType: 'json',
                data: {
                    ID_SPP: ID_SPP
                },
                success: function(data) {

                    var html = '';
                    var i;
                    var jumlah_rasd = 0;
                    var nama_rasd = '';

                    var form_data = {
                        ID_SPP: ID_SPP,
                    }

                    $.ajax({
                        url: "<?php echo site_url('SPP_form/hapus_item_spp_kontrol_anggaran') ?>",
                        type: "POST",
                        dataType: "JSON",
                        data: form_data,
                        success: function(data) {
                        }
                    });
        
                    for (i = 0; i < data.length; i++) {

                        var rencana_anggaran = 0;
                        var total_pengadaan = 0;
                        var pengadaan_saat_ini = 0;
                        var pengadaan_sebelumnya = 0;
                        var sisa_anggaran = 0;

                        var ID_RASD = Number(data[i].ID_RASD);
                        var ID_RAB_FORM = Number(data[i].ID_RAB_FORM);
                        var ID_PROYEK_SUB_PEKERJAAN = Number(data[i].ID_PROYEK_SUB_PEKERJAAN);

                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() ?>SPP_form/data_anggaran_sum_jumlah_barang_rasd',
                            async: false,
                            dataType: 'json',
                            data: {
                                ID_RASD: ID_RASD
                            },
                            success: function(data) {
                                
                                data_2 = data;

                                for (j = 0; j < data_2.length; j++) {

                                    var HARGA_BARANG = data_2[j].HARGA_BARANG;
                                    var JUMLAH_BARANG = data_2[j].JUMLAH_BARANG;

                                    rencana_anggaran = rencana_anggaran + (HARGA_BARANG*JUMLAH_BARANG);
                                }
                            }
                        });

                        var form_data = {
                                    ID_RAB_FORM: data[i].ID_RAB_FORM,
                                    ID_SPP: data[i].ID_SPP,
                                }
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() ?>SPP_form/data_anggaran_sum_jumlah_barang_rab_pengadaan_sebelumnya',
                            async: false,
                            dataType: 'json',
                            data: form_data,
                            success: function(data) {
            
                                data_4 = data;

                                for (l = 0; l < data_4.length; l++) {

                                    var HARGA_TOTAL = Number(data_4[l].HARGA_TOTAL);

                                    pengadaan_sebelumnya = pengadaan_sebelumnya + HARGA_TOTAL ;
                                }
                            }
                        });

                        var form_data = {
                                    ID_RAB_FORM: data[i].ID_RAB_FORM,
                                    ID_SPP: data[i].ID_SPP,
                                }
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url() ?>SPP_form/data_anggaran_sum_jumlah_barang_rab',
                            async: false,
                            dataType: 'json',
                            data: form_data,
                            success: function(data) {
          
                                data_3 = data;

                                for (k = 0; k < data_3.length; k++) {

                                    var HARGA_TOTAL = Number(data_3[k].HARGA_TOTAL_FIX);

                                    pengadaan_saat_ini = pengadaan_saat_ini + HARGA_TOTAL ;
                                }

                            }
                        });
            
                        total_pengadaan = pengadaan_saat_ini + pengadaan_sebelumnya;
                        sisa_anggaran = rencana_anggaran - total_pengadaan;

                        var form_data = {
                            ID_SPP: ID_SPP,
                            ID_RAB_FORM: ID_RAB_FORM,
                            ID_PROYEK_SUB_PEKERJAAN: ID_PROYEK_SUB_PEKERJAAN,
                            NAMA_KATEGORI: data[i].NAMA_KATEGORI,
                            RENCANA_ANGGARAN: rencana_anggaran,
                            TOTAL_PENGADAAN: total_pengadaan,
                            PENGADAAN_SAAT_INI: pengadaan_saat_ini,
                            PENGADAAN_SEBELUMNYA: pengadaan_sebelumnya,
                            SISA_ANGGARAN: sisa_anggaran
                        }

                        $.ajax({
                            url: "<?php echo site_url('SPP_form/update_data_kontrol_anggaran') ?>",
                            type: "POST",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {
                            }
                        });

                        rencana_anggaran = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            maximumFractionDigits: 0, 
                            minimumFractionDigits: 0,
                        }).format(rencana_anggaran);

                        pengadaan_sebelumnya = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            maximumFractionDigits: 0, 
                            minimumFractionDigits: 0,
                        }).format(pengadaan_sebelumnya);

                        pengadaan_saat_ini = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            maximumFractionDigits: 0, 
                            minimumFractionDigits: 0,
                        }).format(pengadaan_saat_ini);

                        total_pengadaan = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            maximumFractionDigits: 0, 
                            minimumFractionDigits: 0,
                        }).format(total_pengadaan);

                        sisa_anggaran = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR',
                            maximumFractionDigits: 0, 
                            minimumFractionDigits: 0,
                        }).format(sisa_anggaran);

                        html += '<tr>' +
                            '<td>' + data[i].NAMA_SUB_PEKERJAAN + '</td>' +
                            '<td>' + data[i].NAMA_KATEGORI + '</td>' +
                            '<td>' + rencana_anggaran + '</td>' +
                            '<td>' + pengadaan_sebelumnya + '</td>' +
                            '<td>' + pengadaan_saat_ini + '</td>' +
                            '<td>' + total_pengadaan + '</td>' +
                            '<td>' + sisa_anggaran + '</td>' +
                            '</tr>';

                    }
                    $('#show_data_anggaran').html(html);
                }
            });
        }

        //fungsi update_tabel_rasd_realisasi
        function update_tabel_rasd_realisasi() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>SPP_form/data_spp_form_by_id_spp', //GET DATA BY ID RAB FORM/ KATEGORI RAB
                async: false,
                dataType: 'json',
                data: {
                    ID_SPP: ID_SPP
                },
                success: function(data) {

                    console.log(data);

                    for (i = 0; i < data.length; i++) {
                        var form_data = {
                            ID_RAB_FORM: data[i].ID_RAB_FORM,
                            ID_RASD_FORM: data[i].ID_RASD_FORM,
                            ID_SPP: data[i].ID_SPP,
                            ID_SPP_FORM: data[i].ID_SPP_FORM,
                            SATUAN_BARANG: data[i].SATUAN_BARANG,
                            JUMLAH_BARANG: data[i].JUMLAH_BARANG,
                            HARGA_BARANG: data[i].HARGA_SATUAN_BARANG_FIX,
                            HARGA_TOTAL: data[i].HARGA_TOTAL_FIX
                        };

                        $.ajax({
                            url: "<?php echo site_url('SPP_form/update_tabel_rasd_realisasi') ?>",
                            type: "POST",
                            dataType: "JSON",
                            data: form_data,
                            success: function(data) {

                                console.log(data);

                                if (data == true) {
                                    
                                } else {
                                    
                                }
                            }
                        });
                    }
                }
            });
        }

        $('#saya_setuju_hapus').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_hapus').removeAttr('disabled'); //enable input

            } else {
                $('#btn_hapus').attr('disabled', true); //disable input
            }
        });
        
        $("#HARGA_SATUAN_BARANG_FIX_2").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_2").val();
            var JUMLAH = $("#JUMLAH_BARANG_2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });

        $("#HARGA_SATUAN_BARANG_FIX_2").on("keyup", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_2").val();
            var JUMLAH = $("#JUMLAH_BARANG_2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });

        $("#HARGA_SATUAN_BARANG_FIX_2").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_2").val();
            var JUMLAH = $("#JUMLAH_BARANG_2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });

        $("#JUMLAH_BARANG_2").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_2").val();
            var JUMLAH = $("#JUMLAH_BARANG_2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

            var form_data = {
                ID_SPPB_FORM: $("#ID_SPPB_FORM_2").val()
            };

            var jumlah_realisasi_spp, jumlah_spp_di_sppb,jumlah_sisa = 0;

            $.ajax({
                url: "<?php echo site_url('SPP_form/data_qty_spp_realisasi') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {
                    var data_3 = data;

                    if (data_3[0].JUMLAH_BARANG == null) {
                        jumlah_realisasi_spp = 0;
                    }
                    else {
                        jumlah_realisasi_spp = data_3[0].JUMLAH_BARANG;
                    }

                }
            });

            $.ajax({
                url: "<?php echo site_url('SPP_form/data_jumlah_qty_spp_by_id_sppb_form') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {

                    if (data.JUMLAH_QTY_SPP == null) {
                        jumlah_spp_di_sppb = 0;
                    }
                    else {
                        jumlah_spp_di_sppb = data.JUMLAH_QTY_SPP;
                    }

                }
            });

            jumlah_sisa = jumlah_spp_di_sppb - jumlah_realisasi_spp;

            var JUMLAH_ORIGINAL = $("#JUMLAH_BARANG_ORIGINAL_2").val();

            var jumlah_tampil = parseInt(jumlah_spp_di_sppb) - parseInt(jumlah_realisasi_spp) - ( parseInt(JUMLAH) - parseInt(JUMLAH_ORIGINAL));

            var html = "Sisa yang belum terealisasi " + jumlah_tampil +" qty"
            $('#show_data_sisa').html(html);

        });

        $("#JUMLAH_BARANG_2").on("keyup", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_2").val();
            var JUMLAH = $("#JUMLAH_BARANG_2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

            var form_data = {
                ID_SPPB_FORM: $("#ID_SPPB_FORM_2").val()
            };

            var jumlah_realisasi_spp, jumlah_spp_di_sppb,jumlah_sisa = 0;

            $.ajax({
                url: "<?php echo site_url('SPP_form/data_qty_spp_realisasi') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {
                    var data_3 = data;

                    if (data_3[0].JUMLAH_BARANG == null) {
                        jumlah_realisasi_spp = 0;
                    }
                    else {
                        jumlah_realisasi_spp = data_3[0].JUMLAH_BARANG;
                    }

                }
            });

            $.ajax({
                url: "<?php echo site_url('SPP_form/data_jumlah_qty_spp_by_id_sppb_form') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {

                    if (data.JUMLAH_QTY_SPP == null) {
                        jumlah_spp_di_sppb = 0;
                    }
                    else {
                        jumlah_spp_di_sppb = data.JUMLAH_QTY_SPP;
                    }

                }
            });

            jumlah_sisa = jumlah_spp_di_sppb - jumlah_realisasi_spp;

            var JUMLAH_ORIGINAL = $("#JUMLAH_BARANG_ORIGINAL_2").val();

            var jumlah_tampil = parseInt(jumlah_spp_di_sppb) - parseInt(jumlah_realisasi_spp) - ( parseInt(JUMLAH) - parseInt(JUMLAH_ORIGINAL));

            var html = "Sisa yang belum terealisasi " + jumlah_tampil +" qty"
            $('#show_data_sisa').html(html);

        });

        $("#JUMLAH_BARANG_2").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_2").val();
            var JUMLAH = $("#JUMLAH_BARANG_2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

            var form_data = {
                ID_SPPB_FORM: $("#ID_SPPB_FORM_2").val()
            };

            var jumlah_realisasi_spp, jumlah_spp_di_sppb,jumlah_sisa = 0;

            $.ajax({
                url: "<?php echo site_url('SPP_form/data_qty_spp_realisasi') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {
                    var data_3 = data;

                    if (data_3[0].JUMLAH_BARANG == null) {
                        jumlah_realisasi_spp = 0;
                    }
                    else {
                        jumlah_realisasi_spp = data_3[0].JUMLAH_BARANG;
                    }

                }
            });

            $.ajax({
                url: "<?php echo site_url('SPP_form/data_jumlah_qty_spp_by_id_sppb_form') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {

                    if (data.JUMLAH_QTY_SPP == null) {
                        jumlah_spp_di_sppb = 0;
                    }
                    else {
                        jumlah_spp_di_sppb = data.JUMLAH_QTY_SPP;
                    }

                }
            });

            jumlah_sisa = jumlah_spp_di_sppb - jumlah_realisasi_spp;

            var JUMLAH_ORIGINAL = $("#JUMLAH_BARANG_ORIGINAL_2").val();

            var jumlah_tampil = parseFloat(jumlah_spp_di_sppb) - parseFloat(jumlah_realisasi_spp) - ( parseFloat(JUMLAH) - parseFloat(JUMLAH_ORIGINAL));

            var html = "Sisa yang belum terealisasi " + jumlah_tampil +" qty"
            $('#show_data_sisa').html(html);

        });

        $('#show_data').on('click', '.item_edit', function() {

            $('#alert-msg-2').html('');

            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {

                    $.ajax({
                        url: "<?php echo base_url(); ?>/SPP_form/data_vendor",
                        method: "POST",
                        data: form_data,
                        async: false,
                        dataType: 'json',
                        success: function (data) {

                            var html = '';
                            var i;

                            html = "<option value=''>- Pilih Vendor -</option>";

                            for (i = 0; i < data.length; i++) {
                                html += '<option value="' + data[i].ID_VENDOR + '">' + data[i].NAMA_VENDOR + '</option>';

                            }
                            html += '<option value="666666">' + '- Tambah Vendor Lainnya -' + '</option>';
                            $('#ID_VENDOR_2').html(html);

                            }
                    });

                    $('#ModalEdit').modal('show');
                    $('[name="ID_SPPB_2"]').val(data.ID_SPPB);
                    $('[name="ID_SPPB_FORM_2"]').val(data.ID_SPPB_FORM);
                    $('[name="ID_SPP_2"]').val(data.ID_SPP);
                    $('[name="ID_SPP_FORM_2"]').val(data.ID_SPP_FORM);
                    $('[name="NAMA_2"]').val(data.NAMA_BARANG);
                    $('[name="MEREK_2"]').val(data.MEREK);
                    $('[name="SPESIFIKASI_SINGKAT_2"]').val(data.SPESIFIKASI_SINGKAT);
                    $('[name="SATUAN_BARANG_2"]').val(data.SATUAN_BARANG);
                    $('[name="JUMLAH_BARANG_2"]').val(data.JUMLAH_BARANG);
                    $('[name="JUMLAH_BARANG_ORIGINAL_2"]').val(data.JUMLAH_BARANG);
                    $('[name="KLASIFIKASI_BARANG_2"]').val(data.ID_KLASIFIKASI_BARANG);
                    $('[name="TANGGAL_MULAI_PAKAI_HARI_2"]').val(data.TANGGAL_MULAI_PAKAI_HARI);
                    $('[name="TANGGAL_SELESAI_PAKAI_HARI_2"]').val(data.TANGGAL_SELESAI_PAKAI_HARI);
                    $('[name="KETERANGAN_UMUM_2"]').val(data.KETERANGAN_UMUM);
                    $('[name="JENIS_PENGADAAN_2"]').val(data.JENIS_PENGADAAN);
                    $('[name="ID_PROYEK_SUB_PEKERJAAN_2"]').val(data.ID_PROYEK_SUB_PEKERJAAN);
                    $('[name="NAMA_KATEGORI_RAB_2"]').val(data.NAMA_KATEGORI_RAB);
                    $('[name="ID_VENDOR_2"]').val(data.ID_VENDOR);
                    $('[name="HARGA_SATUAN_BARANG_FIX_2"]').val(data.HARGA_SATUAN_BARANG_FIX);
                    $('[name="PAJAK_2"]').val(data.ID_PAJAK);
                    $('[name="HARGA_TOTAL_FIX_2"]').val(data.HARGA_TOTAL_FIX);
                    $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(data.HARGA_TOTAL_FIX));
                    $('[name="TANGGAL_MULAI_PAKAI_2"]').val(data.TANGGAL_MULAI_PAKAI);

                    var ID_PROYEK_SUB_PEKERJAAN = $('[name="ID_PROYEK_SUB_PEKERJAAN_2"]').val();

                    var form_data = {
                        ID_PROYEK: ID_PROYEK,
                        ID_PROYEK_SUB_PEKERJAAN: ID_PROYEK_SUB_PEKERJAAN
                    }

                    $.ajax({
                        url: "<?php echo base_url(); ?>/SPPB_form/get_data_id_rab_by_id_proyek",
                        method: "POST",
                        data: form_data,
                        async: false,
                        dataType: 'json',
                        success: function (data) {

                            var html = '';
                            var i;

                            for (i = 0; i < data.length; i++) {

                                var form_data = {
                                    ID_RAB: data[i].ID_RAB,
                                }

                                $.ajax({
                                    url: "<?php echo base_url(); ?>/SPPB_form/get_data_id_rab_form_by_id_rab",
                                    method: "POST",
                                    data: form_data,
                                    async: false,
                                    dataType: 'json',
                                    success: function (data) {

                                        var html = '';
                                        var i;

                                        html = "<option value=''>- Pilih Kategori RAB -</option>";

                                        for (i = 0; i < data.length; i++) {
                                            html += '<option value="' + data[i].ID_RAB_FORM + '">' + data[i].NAMA_KATEGORI + '</option>';

                                        }
                                        html += '<option value="999999999">' + '-Tambah Kategori RAB Baru-' + '</option>';
                                        $('#ID_RAB_FORM_2').html(html);

                                        }
                                });
                            }

                        }
                    });

                    $('[name="ID_RAB_FORM_2"]').val(data.ID_RAB_FORM);

                    var ID_PROYEK_SUB_PEKERJAAN = $('[name="ID_PROYEK_SUB_PEKERJAAN_2"]').val();

                    var form_data = {
                        ID_RAB_FORM: $('#ID_RAB_FORM_2').val(),
                        ID_PROYEK_SUB_PEKERJAAN: ID_PROYEK_SUB_PEKERJAAN

                    }

                    $.ajax({
                        url: "<?php echo base_url(); ?>/SPPB_form/get_data_id_rasd_by_id_rab_form",
                        method: "POST",
                        data: form_data,
                        async: false,
                        dataType: 'json',
                        success: function (data) {

                            var html = '';
                            var i;

                            html = "<option value=''>- Pilih RASD -</option>";

                            for (i = 0; i < data.length; i++) {

                                var form_data = {
                                    ID_RASD: data[i].ID_RASD,
                                }

                                $.ajax({
                                    url: "<?php echo base_url(); ?>/SPPB_form/get_data_id_rasd_form_by_id_rasd",
                                    method: "POST",
                                    data: form_data,
                                    async: false,
                                    dataType: 'json',
                                    success: function (data) {

                                        var html = '';
                                        var i;

                                        for (i = 0; i < data.length; i++) {

                                            html += '<option value="' + data[i].ID_RASD_FORM + '">' + data[i].NAMA + ' | ' + data[i].SPESIFIKASI_SINGKAT + '</option>';
                                        }
                                        html += '<option value="666666">- Tambah sebagai item baru -</option>';
                                        $('#ID_RASD_FORM_2').html(html);

                                    }
                                });
                            }

                        }
                    });


                    $('[name="ID_RASD_FORM_2"]').val(data.ID_RASD_FORM);
                    
                    var ID_RAB_FORM = $('#ID_RAB_FORM_2').val();
                    if (ID_RAB_FORM == "999999999") {
                        $('#show_hidden_rab_baru_2').attr("hidden", false);
                        $('#show_hidden_item_rab_2').attr("hidden", true);
                        $('#NAMA_KATEGORI_RAB_2').val("");
                        $('#ID_RASD_FORM_2').val("");
                    } else {
                        $('#show_hidden_rab_baru_2').attr("hidden", true);
                        $('#show_hidden_item_rab_2').attr("hidden", false);
                        $('#NAMA_KATEGORI_RAB_2').val("");
                    }

                }
            });
            return false;
        });

        $('#btn_simpan_identitas_form').click(function () {

            var TANGGAL_DOKUMEN_SPP = $('#TANGGAL_DOKUMEN_SPP').val(),
            TANGGAL_DOKUMEN_SPP = TANGGAL_DOKUMEN_SPP.split("/").reverse().join("-");

            var form_data = {
                ID_SPP: ID_SPP,
                NO_URUT_SPP_GANTI: $('#NO_URUT_SPP_GANTI').val(),
                NO_URUT_SPP_ASLI: $('#NO_URUT_SPP_ASLI').val(),
                CTT_DEPT_PROC: $('#CTT_DEPT_PROC').val(),
                TANGGAL_DOKUMEN_SPP: TANGGAL_DOKUMEN_SPP,
                JENIS_PERMINTAAN: $('#JENIS_PERMINTAAN').val(),
                BARIS_KOSONG: $('#BARIS_KOSONG').val(),
            };
            $.ajax({
                url: "<?php echo site_url('SPP_form/simpan_identitas_form'); ?>",
                type: 'POST',
                data: form_data,
                success: function (data) {
                    if (data != 'true') {
                        $('#alert-msg-4').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var alamat = "<?php echo base_url('SPP_form/index/'); ?>" + HASH_MD5_SPP;
                        window.open(
                            alamat,
                            '_self' // <- This is what makes it open in a new window.
                        );
                    }
                }
            });
            return false;
        });

        //SIMPAN PERUBAHAN
        $('#btn_simpan_perubahan').click(function() {

            tampil_data_anggaran(); //pemanggilan fungsi tampil data.

            var HASH_MD5_SPP = $(this).attr('data');

            var alamat = "<?php echo base_url('SPP_form/view/'); ?>" + HASH_MD5_SPP;

            window.open(
                alamat,
                '_self' // <- This is what makes it open in a new window.
            );
            
        });


        //TAMPILKAN KONTROL ANGGARAN
        $('#btn_kontrol_anggaran').click(function() {

            update_tabel_rasd_realisasi(); //pemanggilan fungsi update_tabel_rasd_realisasi.

            tampil_data_anggaran(); //pemanggilan fungsi tampil data.
            
        });

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            var TANGGAL_MULAI_PAKAI_HARI = $('#TANGGAL_MULAI_PAKAI_HARI_2').val(),
                TANGGAL_MULAI_PAKAI_HARI = TANGGAL_MULAI_PAKAI_HARI.split("/").reverse().join("-");

            var TANGGAL_SELESAI_PAKAI_HARI = $('#TANGGAL_SELESAI_PAKAI_HARI_2').val(),
                TANGGAL_SELESAI_PAKAI_HARI = TANGGAL_SELESAI_PAKAI_HARI.split("/").reverse().join("-");

            var form_data = {
                ID_SPPB: $('#ID_SPPB_2').val(),
                ID_SPPB_FORM: $('#ID_SPPB_FORM_2').val(),
                ID_SPP: $('#ID_SPP_2').val(),
                ID_SPP_FORM: $('#ID_SPP_FORM_2').val(),
                NAMA: $('#NAMA_2').val(),
                MEREK: $('#MEREK_2').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_2').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_2').val(),
                JUMLAH_BARANG_ORIGINAL: $('#JUMLAH_BARANG_ORIGINAL_2').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_2').val(),
                KLASIFIKASI_BARANG: $('#KLASIFIKASI_BARANG_2').val(),
                TANGGAL_MULAI_PAKAI_HARI: TANGGAL_MULAI_PAKAI_HARI,
                TANGGAL_SELESAI_PAKAI_HARI: TANGGAL_SELESAI_PAKAI_HARI,
                KETERANGAN_UMUM: $('#KETERANGAN_UMUM_2').val(),
                JENIS_PENGADAAN: $('#JENIS_PENGADAAN_2').val(),
                ID_PROYEK_SUB_PEKERJAAN: $('#ID_PROYEK_SUB_PEKERJAAN_2').val(),
                ID_RAB_FORM: $('#ID_RAB_FORM_2').val(),
                NAMA_KATEGORI_RAB: $('#NAMA_KATEGORI_RAB_2').val(),
                ID_RASD_FORM: $('#ID_RASD_FORM_2').val(),
                ID_VENDOR: $('#ID_VENDOR_2').val(),
                NAMA_VENDOR: $('#NAMA_VENDOR_2').val(),
                ALAMAT_VENDOR: $('#ALAMAT_VENDOR_2').val(),
                NO_TELP_VENDOR: $('#NO_TELP_VENDOR_2').val(),
                HARGA_SATUAN_BARANG_FIX: $('#HARGA_SATUAN_BARANG_FIX_2').val(),
                HARGA_TOTAL_FIX: $('#HARGA_TOTAL_FIX_2').val(),
            };

            $.ajax({
                url: "<?php echo site_url('SPP_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: form_data,
                success: function(data) {

                    if (data == true) {
                        // window.location.reload();
                        document.getElementById("saya_setuju").checked = false;
                        $('#btn_update').attr('disabled', true); //disable input
                        $('#ModalEdit').modal('hide');
                        $("#mydata").dataTable().fnDestroy();
                        tampil_data_spp_form();
                        $('#alert-msg-2').html('');
                        $('#show_hidden_vendor_4').attr("hidden", true); //disable input
                        $('#show_hidden_vendor_5').attr("hidden", true); //disable input
                        $('#show_hidden_vendor_6').attr("hidden", true); //disable input
                    } else {
                        $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
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
                url: "<?php echo base_url('SPP_form/get_data') ?>",
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

        hapus_semua_item.onclick = function() {
            var id = $(this).attr('data');
            $('#ModalHapusSemua').modal('show');
            $('[name="kode_semua"]').val(id);
            $('#NAMA_5').html('</br>SPP kode : ' + id);
        };

        //HAPUS DATA SEMUA
        $('#btn_hapus_semua').on('click', function () {
            var kode = $('#textkode_semua').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('SPP_form/hapus_data_semua') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function (data) {
                    $('#ModalHapusSemua').modal('hide');
                    window.location.reload();
                }
            });
            return false;
        });

        $('#btn_gagal_upload').on('click', function() {
            window.location.reload();
        });

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('SPP_form/hapus_data') ?>",
                dataType: "JSON",
                data: {
                    kode: kode
                },
                success: function(data) {
                    // window.location.reload();
                    document.getElementById("saya_setuju_hapus").checked = false;
                    $('#btn_hapus').attr('disabled', true); //disable input
                    $('#ModalHapus').modal('hide');
                    $("#mydata").dataTable().fnDestroy();
                    window.location.reload();
                }
            });
            return false;
        });

        $('#saya_setuju_kirim').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_spp').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_spp').attr('disabled', true); //disable input
            }
        });

        //UPDATE KIRIM SPP 
        $('#btn_update_kirim_spp').on('click', function() {
            
            update_tabel_rasd_realisasi()
            tampil_data_anggaran();

            let ID_SPP = $('#ID_SPP7').val();
            $.ajax({
                url: "<?php echo site_url('SPP_form/update_data_kirim_spp') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_SPP: ID_SPP,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimSPP').modal('hide');
                        window.location.href = '<?php echo site_url('SPP') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        item_edit_kirim_spp.onclick = function() {

            tampil_data_anggaran(); //pemanggilan fungsi tampil data.

            var ID_SPP = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/data_spp_form_kirim_SPP') ?>",
                dataType: "JSON",
                data: {
                    ID_SPP: ID_SPP
                },
                success: function(data) {
                    $('#ModalEditKirimSPP').modal('show');
                    $.each(data, function() {
                        $('[name="ID_SPP7"]').val(data[0].ID_SPP);
                        $('#alert-msg-7').html('<div></div>');
                    });

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);
                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        let i = 0;
                        for (i = 0; i < data.length; i++) {

                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH_BARANG == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_jumlah_minta').attr("hidden", false);
                                break;
                            }

                            if (data[i].NAMA_BARANG == null || data[i].NAMA_BARANG == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_nama_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].SPESIFIKASI_SINGKAT == null || data[i].SPESIFIKASI_SINGKAT == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_spesifikasi_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_PROYEK_SUB_PEKERJAAN == null || data[i].ID_PROYEK_SUB_PEKERJAAN == "" || data[i].ID_PROYEK_SUB_PEKERJAAN == "0") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_sub_pekerjaan').attr("hidden", false);
                                break;
                            }

                            
                            if (data[i].ID_RAB_FORM == "" && data[i].NAMA_KATEGORI_RAB == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rab_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_RAB_FORM == null && data[i].NAMA_KATEGORI_RAB == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rab_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_RAB_FORM == null && data[i].NAMA_KATEGORI_RAB == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rab_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_RAB_FORM == "" && data[i].NAMA_KATEGORI_RAB == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rab_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_RAB_FORM == "0" && data[i].NAMA_KATEGORI_RAB == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rab_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_KLASIFIKASI_BARANG == null || data[i].ID_KLASIFIKASI_BARANG == "" || data[i].ID_KLASIFIKASI_BARANG == "0") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_klasifikasi_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].SATUAN_BARANG == null || data[i].SATUAN_BARANG == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_satuan_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].ID_RASD_FORM == null || data[i].ID_RASD_FORM == "") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_rasd_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].TANGGAL_MULAI_PAKAI_HARI == "" || data[i].TANGGAL_MULAI_PAKAI_HARI == "00/00/0000" || data[i].TANGGAL_MULAI_PAKAI_HARI == null || data[i].TANGGAL_SELESAI_PAKAI_HARI == "" || data[i].TANGGAL_SELESAI_PAKAI_HARI == null || data[i].TANGGAL_SELESAI_PAKAI_HARI == "00/00/0000") {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_tanggal_mulai_selesai').attr("hidden", false);
                                break;
                            }

                            
                            if (data[i].NAMA_VENDOR == "" || data[i].NAMA_VENDOR == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_nama_vendor').attr("hidden", false);
                                break;
                            }

                            if (data[i].HARGA_SATUAN_BARANG_FIX == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_harga_minta').attr("hidden", false);
                                break;
                            }

                            //JIKA SEMUA ITEM BARANG ADA JUMLAH MINTANYA (TIDAK NOL)
                            if (i == (data.length - 1)) {
                                $('#show_hidden_setuju').attr("hidden", false);
                            }
                        }
                    }
                }
            });
            return false;
        };

        tambah_item_sppb.onclick = function() {

            $('#ModalAddDariSPPB').modal('show');

            $("#mydata_SPPB").dataTable().fnDestroy();

            $('#ibox2').children('.ibox-content').toggleClass('sk-loading');

            setTimeout(function(){
                //fungsi tampil data
                var data = <?php echo json_encode($sppb_barang_list); ?>;
                var html = '';
                var jumlah_realisasi_spp, jumlah_sisa = 0;

                for (l = 0; l < data.length; l++) {

                    var form_data = {
                        ID_SPPB_FORM: data[l].ID_SPPB_FORM
                    };

                    $.ajax({
                        url: "<?php echo site_url('SPP_form/data_qty_spp_realisasi') ?>",
                        type: "POST",
                        dataType: "JSON",
                        async: false,
                        data: form_data,
                        success: function (data) {
                            var data_3 = data;

                            if (data_3[0].JUMLAH_BARANG == null) {
                                jumlah_realisasi_spp = 0;
                            }
                            else {
                                jumlah_realisasi_spp = data_3[0].JUMLAH_BARANG;
                            }

                        }
                    });

                    jumlah_sisa = data[l].JUMLAH_QTY_SPP - jumlah_realisasi_spp;

                    html += '<tr>' +
                    
                    '<td>' + 
                    '<input name="ID_SPP" class="form-control" type="text" value="'+ ID_SPP +'" style="display: none;" readonly>' +
                    '<input class="checkbox" name="ID_SPPB_FORM[]" value="'+ data[l].ID_SPPB_FORM +'" type="checkbox">' +
                    '</td>' +
                    '<td>' + data[l].NAMA_BARANG + '</td>' +
                    '<td>' + data[l].MEREK + '</td>' +
                    '<td>' + data[l].SPESIFIKASI_SINGKAT + '</td>' +
                    '<td>' + 'RAB: ' + data[l].NAMA_KATEGORI + '</br> Klasifikasi:' + data[l].NAMA_KLASIFIKASI_BARANG + '</td>' +
                    '<td>' + data[l].JUMLAH_QTY_SPP + ' ' + data[l].SATUAN_BARANG + '</td>' +
                    '<td>' + jumlah_realisasi_spp + ' ' + data[l].SATUAN_BARANG + '</td>' +
                    '<td>' + jumlah_sisa + ' ' + data[l].SATUAN_BARANG + '</td>' +
                    '<td>' + data[l].TANGGAL_MULAI_PAKAI_HARI + ' s.d.' + data[l].TANGGAL_SELESAI_PAKAI_HARI + '</td>' +
                    '</td>' +
                    '</tr>';
                }
                $('#show_data_SPPB').html(html);

                $('#mydata_SPPB').dataTable({
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
                            title: 'SPP export EXCEL',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9,10]
                            },
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
            }, 1000); 

            setTimeout(function(){
                $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
            }, 3000); 


        };

        //GET UPDATE untuk Upload Excel
        item_edit_upload_excel.onclick = function() {
            var ID_SPP = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('SPP_form/data_spp_form_kirim_SPP') ?>",
                dataType: "JSON",
                data: {
                    ID_SPP: ID_SPP
                },
                success: function(data) {

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#ModalEditExcelMaaf').modal('show');
                    } else {
                        $('#ModalEditExcel').modal('show');
                    }
                    
                }
            });
            return false;
        };
    });
</script>

</body>

</html>