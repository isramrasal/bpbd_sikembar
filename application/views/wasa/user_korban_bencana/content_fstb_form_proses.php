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
        <h2>Form FISTB</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/FSTB/') ?>">FISTB</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form FISTB</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<!-- Form FISTB -->
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Pastikan Anda mengisi data dengan benar.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Formulir Pengajuan FISTB</h5>
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
                            <li class="" style="display:none;"><a data-toggle="tab" href="#tab-2">Catatan FISTB</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
                                    <form method="get" class="form-horizontal">

                                        <?php
                                        if (isset($SPPB)) {
                                            foreach ($SPPB->result() as $SPPB) :
                                        ?>
                                                <div class="form-group"><label class="col-sm-2 control-label">Proyek</label>
                                                    <div class="col-sm-10"><a href="<?php echo base_url() ?>Proyek/detil_proyek/<?php echo $SPPB->HASH_MD5_PROYEK; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $SPPB->NAMA_PROYEK; ?> </a></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Pekerjaan</label>
                                                    <div class="col-sm-10"><input name="SUB_PROYEK" id="SUB_PROYEK" type="text"
                                                            class="form-control" value="<?php echo $SPPB->SUB_PROYEK; ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">No. Urut SPPB</label>
                                                    <div class="col-sm-10"><a href="<?php echo base_url() ?>SPPB_form/view/<?php echo $SPPB->HASH_MD5_SPPB; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $SPPB->NO_URUT_SPPB; ?> </a></div>
                                                </div>
                                        <?php endforeach;
                                        } ?>

                                        <?php
                                        if (isset($SPP)) {
                                            foreach ($SPP->result()  as $SPP) :
                                        ?>
                                                <div class="form-group"><label class="col-sm-2 control-label">No. Urut SPP</label>
                                                <div class="col-sm-10"><a href="<?php echo base_url() ?>SPP_form/view/<?php echo $SPP->HASH_MD5_SPP; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $SPP->NO_URUT_SPP; ?> </a></div>
                                                </div>
                                        <?php endforeach;
                                        } ?>

                                        <?php
                                        if (isset($PO)) {
                                            foreach ($PO->result()  as $PO) :
                                        ?>
                                                <div class="form-group"><label class="col-sm-2 control-label">No. Urut PO</label>
                                                <div class="col-sm-10"><a href="<?php echo base_url() ?>PO_form/view/<?php echo $PO->HASH_MD5_PO; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $PO->NO_URUT_PO; ?> </a></div>
                                                </div>
                                        <?php endforeach;
                                        } ?>

                                        <?php
                                        if (isset($FSTB)) {
                                            foreach ($FSTB->result() as $FSTB) :
                                        ?>
                                                <div class="form-group"><label class="col-sm-2 control-label">No. Urut FISTB</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="NO_URUT_FSTB_GANTI" id="NO_URUT_FSTB_GANTI" class="form-control" value="<?php echo $FSTB->NO_URUT_FSTB; ?>">
                                                        <input name="NO_URUT_FSTB_ASLI" id="NO_URUT_FSTB_ASLI" type="hidden" class="form-control" value="<?php echo $FSTB->NO_URUT_FSTB; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group" id="data_TANGGAL_DOKUMEN_FSTB"><label class="col-sm-2 control-label">Tanggal Dokumen FISTB</label>
                                                    <div class="col-sm-10">
                                                        <?php
                                                        if (empty($FSTB->TANGGAL_DOKUMEN_FSTB)) {
                                                        ?>
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_FSTB" name="TANGGAL_DOKUMEN_FSTB" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                                            </div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_FSTB" name="TANGGAL_DOKUMEN_FSTB" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $FSTB->TANGGAL_DOKUMEN_FSTB; ?>">
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="form-group"><label class="col-sm-2 control-label">Tanggal FISTB By System</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo tanggal_indo_full($FSTB->TANGGAL_PEMBUATAN_FSTB_HARI, false); ?>" disabled></div>
                                                </div>

                                                <div class="form-group"><label class="col-sm-2 control-label">Lokasi Serah Terima Barang</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="LOKASI_PENYERAHAN" id="LOKASI_PENYERAHAN" class="form-control" value="<?php echo $FSTB->LOKASI_PENYERAHAN; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group"><label class="col-sm-2 control-label">Nama Vendor</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="NAMA_VENDOR" id="NAMA_VENDOR" class="form-control" value="<?php echo $FSTB->NAMA_VENDOR; ?>" disabled>
                                                    </div>
                                                </div>

                                                <div class="form-group"><label class="col-sm-2 control-label">Nomor Surat Jalan Vendor</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="NOMOR_SURAT_JALAN_VENDOR" id="NOMOR_SURAT_JALAN_VENDOR" class="form-control" value="<?php echo $FSTB->NOMOR_SURAT_JALAN_VENDOR; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group"><label class="col-sm-2 control-label">Nama Pengirim</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="NAMA_PENGIRIM" id="NAMA_PENGIRIM" class="form-control" value="<?php echo $FSTB->NAMA_PENGIRIM; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group"><label class="col-sm-2 control-label">No HP Pengirim</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="NO_HP_PENGIRIM" id="NO_HP_PENGIRIM" class="form-control" value="<?php echo $FSTB->NO_HP_PENGIRIM; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group"><label class="col-sm-2 control-label">Nama Pegawai Penerima Barang</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="NAMA_PEGAWAI" id="NAMA_PEGAWAI" class="form-control" value="<?php echo $FSTB->NAMA_PEGAWAI; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group" id="data_TANGGAL_BARANG_DATANG_HARI"><label class="col-sm-2 control-label">Tanggal Barang Datang</label>
                                                    <div class="col-sm-10">
                                                        <?php
                                                        if (empty($FSTB->TANGGAL_BARANG_DATANG_HARI)) {
                                                        ?>
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_BARANG_DATANG_HARI" name="TANGGAL_BARANG_DATANG_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                                            </div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_BARANG_DATANG_HARI" name="TANGGAL_BARANG_DATANG_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $FSTB->TANGGAL_BARANG_DATANG_HARI; ?>">
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="form-group"><label class="col-sm-2 control-label">Catatan</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="CTT_STAFF_LOG" id="CTT_STAFF_LOG" class="form-control" value="<?php echo $FSTB->CTT_STAFF_LOG; ?>">
                                                    </div>
                                                </div>

                                                <input style="width:100%" name="HASH_MD5_FSTB" id="HASH_MD5_FSTB" type="hidden" value="<?php echo $HASH_MD5_FSTB; ?>">
                                                
                                        <?php endforeach;
                                        } ?>

                                    </form>
                                    </br>
                                    <div class="hr-line-dashed"></div>
                                    <div id="alert-msg-8"></div>
                                    <button class="btn btn-primary" id="btn_simpan_identitas_form"><i class="fa fa-save"></i> Simpan Identitas Form</button>
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
                                                    <span>Catatan Staff Procurement SP</span>
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Supervisi Procurement SP</span>
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Staff Procurement KP</span>
                                                </a>
                                            </div>
                    
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Kasie Procurement KP</span>
                                                </a>
                                            </div>
                 
                                        </div>
                                    </div>

                                    <div class="stream">
                                        <div class="stream-badge">
                                            <i class="fa fa-circle"></i>
                                        </div>
                                        <div class="stream-panel">
                                            <div class="stream-info">
                                                <a href="#">
                                                    <span>Catatan Manajer Procurement KP</span>
                                                </a>
                                            </div>
                        
                                        </div>
                                    </div>
                                    </br>
                                    <div class="hr-line-dashed"></div>
                                    <a href="javascript:;" id="item_edit_catatan_po" name="item_edit_catatan_po" class="btn btn-primary" data="<?php echo $HASH_MD5_FSTB; ?>"><i class="fa fa-comment"></i> Berikan Catatan FISTB </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>FISTB Item Barang/Jasa</h5>
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
                    
                    <a href="javascript:;" id="tambah_item_po" name="tambah_item_po" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah Item dari PO</a>
                    <br>
                    <a href="javascript:;" id="hapus_semua_item" name="hapus_semua_item" class="btn btn-danger text-right" data="<?php echo $HASH_MD5_FSTB; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Hapus Semua Barang/Jasa</a>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="mydata">
                            <thead>
                                <tr>
                                    <th>Nama Barang/Jasa</th>
                                    <th>Merek Barang/Jasa</th>
                                    <th>Spesifikasi Singkat</th>
                                    <th>Satuan Barang</th>                                        
                                    <th>Jumlah Yang Dipesan</th>
                                    <th>Jumlah Yang Diterima</th>
                                    <th>Jumlah Yang Diterima Dengan Syarat</th>
                                    <th>Jumlah Yang Ditolak</th>
                                    <th>Pilihan</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">

                            </tbody>

                        </table>
                    </div>

                    </br>
                    </br>
                    </br>

                </div>
            </div>

            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="sm-10">
                            <button class="btn btn-primary" id="btn_simpan_perubahan_pdf"><i class="fa fa-save"></i> Simpan Perubahan & View Dokumen FISTB</button>
                            </br>
                            <a href="javascript:;" id="item_edit_kirim_fstb" name="item_edit_kirim_fstb" class="btn btn-success" data="<?php echo $ID_FSTB; ?>"><span class="fa fa-send"></span> Ajukan FISTB Untuk Proses Selanjutnya </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Form FISTB -->


<!-- MODAL ADD  DARI PO -->
<div class="modal inmodal fade" id="ModalAddDariSPP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <?php
            if ($po_barang_list != NULL) {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Daftar Item Barang/Jasa dari PO</h4>
                    <small class="font-bold">Silakan isi data FISTB berdasarkan daftar PO</small>
                </div>

                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="table-responsive">

                        <?php
                        foreach ($po_barang_list as $data): ?>
                        Sumber SPP: <a href="<?php echo base_url() ?>SPP_form/view/<?php echo $SPP->HASH_MD5_SPP; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $SPP->NO_URUT_SPP; ?> </a>
                        </br>
                        </br>
                        Sumber PO: <a href="<?php echo base_url() ?>PO_form/view/<?php echo $PO->HASH_MD5_PO; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $PO->NO_URUT_PO; ?> </a>
                        <?php break;?>
                        <?php endforeach;
                        ?>

                        </br>
                        </br>

                            <form method="POST" action="<?php echo site_url('FSTB_form/simpan_data_dari_po_form'); ?>" id="formTambahPO">
                                <table class="table table-striped table-bordered table-hover" id="mydata_PO">
                                    <thead>
                                        <tr>
                                            <th>Pilih<input type="checkbox" id="checkAllpo"></th>
                                            <th>Nama Barang/Jasa</th>
                                            <th>Merek Barang/Jasa</th>
                                            <th style="width: 30%;">Spesifikasi Singkat</th>
                                            <th>Klasifikasi Barang</th>
                                            <th>Qty PO</th>
                                            <th>Qty Realisasi FISTB</th>
                                            <th>Qty pada FISTB ini</th>
                                            <th>Vendor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data_PO">                                        
                                    </tbody>
                                </table>

                            </form>
                        </div>
                        <div id="alert-msg-add-dari-po"></div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                        <button class="btn btn-primary" type="submit" form="formTambahPO"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            <?php
            } else {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-exclamation-triangle modal-icon"></i>
                    <h4 class="modal-title">Daftar Item Barang/Jasa dari PO</h4>
                    <b class="font-bold">Maaf semua item barang/jasa dari PO sudah ada di Form FISTB ini atau seluruh item sudah diproses di Form FISTB yang lain</b>
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
<!--END MODAL ADD DARI PO -->


<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ubah Item Barang/Jasa FISTB</h4>
                <small class="font-bold">Silakan edit item barang/jasa FISTB</small>
            </div>
            <?php $attributes = array("ID_FSTB_FORM_2" => "contact_form", "id" => "contact_form");
            echo form_open("FSTB_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_PO_FORM_2" id="ID_PO_FORM_2" class="form-control" type="hidden" readonly>
                    <input name="ID_FSTB_FORM_2" id="ID_FSTB_FORM_2" class="form-control" type="hidden" readonly>

                    <div class="form-group row">
                        <label class="col-xs-2 control-label">Identitas Barang/Jasa</label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang </label>
                        <div class="col-xs-9">
                            <input name="NAMA_2" id="NAMA_2" class="form-control" type="text" placeholder="Contoh : Mata Gerinda 3 Inch" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_2" id="MEREK_2" class="form-control" type="text" placeholder="Contoh : Tekiro" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_2" id="SPESIFIKASI_SINGKAT_2" class="form-control" type="text" placeholder="Contoh : 3 Inch" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="SATUAN_BARANG_2" id="SATUAN_BARANG_2" class="form-control" type="text" disabled>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Yang Dipesan</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_DIMINTA_2" id="JUMLAH_DIMINTA_2" class="touchspin1" type="number" disabled>
                            <input name="JUMLAH_DIMINTA_ORIGINAL_2" id="JUMLAH_DIMINTA_ORIGINAL_2" type="hidden">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Yang Diterima</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_DITERIMA_2" id="JUMLAH_DITERIMA_2" class="touchspin1" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Yang Diterima Dengan Syarat</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_DITERIMA_SYARAT_2" id="JUMLAH_DITERIMA_SYARAT_2" class="touchspin1" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan Diterima Dengan Syarat</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN_DITERIMA_SYARAT_2" id="KETERANGAN_DITERIMA_SYARAT_2" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Yang Ditolak</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_DITOLAK_2" id="JUMLAH_DITOLAK_2" class="touchspin1" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan Ditolak</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN_DITOLAK_2" id="KETERANGAN_DITOLAK_2" class="form-control" type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                            <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya
                                    telah selesai melakukan pengisian jumlah diterima, diterima dengan syarat dan ditolak dengan benar, menyetujui untuk
                                    dimasukkan ke dalam realisasi PO </label></div>
                        </div>

                    </div>

                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update" disabled><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 80vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa FISTB</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus item barang/jasa ini?</p>
                        <div name="NAMA_3" id="NAMA_3"></div>
                    </div>

                    <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju_hapus"><i></i> Saya dengan sadar dan setuju untuk menghapus item barang/jasa pada FISTB ini. Item yang sudah dihapus tidak dapat dipulihkan kembali.</label></div>

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

<!-- MODAL KIRIM FISTB-->
<div class="modal inmodal fade" id="ModalEditKirimFSTB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Kirim FISTB</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form FISTB ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_FSTB7" => "contact_form", "id" => "contact_form");
            echo form_open("FSTB_form/update_data_kirim_fstb", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_FSTB7" id="ID_FSTB7" class="form-control" type="hidden" placeholder="ID FSTB" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="i-checks"><label> <input type="checkbox" id="saya_setuju_kirim"><i></i> Saya telah selesai melakukan proses form FISTB ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang diminta pada FISTB ini</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item jumlah barang yang diterima bernilai 0</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_peralatan_perlengkapan" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item barang yang belum diatur Kategori</center>
                        </div>
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
<!--END MODAL EDIT KIRIM FISTB-->

<!-- MODAL EDIT CATATAN FISTB-->
<div class="modal inmodal fade" id="ModalEditCatatanFSTB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Catatan FISTB</h4>
                <small class="font-bold">Silakan berikan komentar atau catatan mengenai Form FISTB ini</small>
            </div>
            <?php $attributes = array("ID_FSTB6" => "contact_form", "id" => "contact_form");
            echo form_open("FSTB_form/update_data_catatan_po", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_FSTB6" id="ID_FSTB6" class="form-control" type="hidden" placeholder="ID FSTB" readonly>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Catatan FISTB</label>

                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="CTT_STAFF_PROC6" id="CTT_STAFF_PROC6" required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-6"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_catatan_po"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT CATATAN FISTB-->

<!--MODAL HAPUS SEMUA-->
<div class="modal fade" id="ModalHapusSemua" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 30vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Semua Item Barang/Jasa FISTB</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode_semua" id="textkode_semua" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus semua item barang/jasa pada FISTB ini?</p>
                        <div name="NAMA_5" id="NAMA_5"></div>
                    </div>

                    <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju_hapus_semua"><i></i> Saya dengan sadar dan setuju untuk menghapus semua item barang/jasa pada FISTB ini. Item yang sudah dihapus tidak dapat dipulihkan kembali.</label></div>

                </div>
                <div id="alert-msg-9"></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-danger" id="btn_hapus_semua" disabled><i class="fa fa-trash"></i> Hapus</button>
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

<!-- Page-Level Scripts -->
<script>
    
    $(document).ready(function() {
        var ID_SPP = <?php echo $ID_SPP;  ?>;
        var ID_FSTB = <?php echo $ID_FSTB;  ?>;
        var HASH_MD5_FSTB = '<?php echo $HASH_MD5_FSTB;  ?>';

        $('#data_TANGGAL_DOKUMEN_FSTB .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#data_TANGGAL_BARANG_DATANG_HARI .input-group.date').datepicker({
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

        tampil_data_form_fstb(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            order: [
                [2, "asc"]
            ],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
					extend: 'excel',
					title: '<?php echo $title ?>',
					exportOptions: {
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
					},
				},
				{
					extend: 'print',
					orientation: 'landscape',
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


        $("#checkAllpo").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        // jumlah-+
        $(".touchspin1").TouchSpin({
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white',
            min: 0,
            max: 9999999999999,
            step: 0.01,
            decimals: 2,
        });



        //fungsi tampil data
        function tampil_data_form_fstb() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>FSTB_form/data_fstb_form',
                async: false,
                dataType: 'json',
                data: {
                    ID_FSTB: ID_FSTB
                },
                success: function(data) {
                    var html = '';
                    var $KET_DITOLAK  = '';
                    var $KET_DITERIMA_SYARAT  = '';
                    var i;
                    for (i = 0; i < data.length; i++) {

                        if (data[i].JUMLAH_DITERIMA_SYARAT > 0)
                        {
                            $KET_DITERIMA_SYARAT = '<br> Keterangan: ' + data[i].KETERANGAN_DITERIMA_SYARAT;
                        }

                        if (data[i].JUMLAH_DITOLAK  > 0)
                        {
                            $KET_DITOLAK = '<br> Keterangan: ' + data[i].KETERANGAN_DITOLAK;
                        }

                        html += '<tr>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].SATUAN_BARANG + '</td>' +
                            '<td>' + data[i].JUMLAH_DIMINTA + '</td>' +
                            '<td>' + data[i].JUMLAH_DITERIMA + '</td>' +
                            '<td>' + data[i].JUMLAH_DITERIMA_SYARAT + $KET_DITERIMA_SYARAT + '</td>' +
                            '<td>' + data[i].JUMLAH_DITOLAK + $KET_DITOLAK + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_FSTB_FORM + '"><i class="fa fa-pencil"></i> Ubah </a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_FSTB_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' +
                            '</td>' +

                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        //GET UPDATE untuk edit jumlah yang diterima
        $('#show_data').on('click', '.item_edit', function() {
            var ID_FSTB_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('FSTB_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_FSTB_FORM: ID_FSTB_FORM
                },
                success: function(data) {
                    $('#ModalEdit').modal('show');
                    $('[name="ID_PO_FORM_2"]').val(data.ID_PO_FORM);
                    $('[name="ID_FSTB_FORM_2"]').val(data.ID_FSTB_FORM);
                    $('[name="NAMA_2"]').val(data.NAMA_BARANG);
                    $('[name="MEREK_2"]').val(data.MEREK);
                    $('[name="SPESIFIKASI_SINGKAT_2"]').val(data.SPESIFIKASI_SINGKAT);

                    JUMLAH_DIMINTA = data.JUMLAH_DIMINTA
                    JUMLAH_DIMINTA = Number(data.JUMLAH_DIMINTA).toFixed(2);

                    $('[name="JUMLAH_DIMINTA_2"]').val(JUMLAH_DIMINTA);
                    $('[name="JUMLAH_DIMINTA_ORIGINAL_2"]').val(JUMLAH_DIMINTA);
                    $('[name="JUMLAH_DITERIMA_2"]').val(data.JUMLAH_DITERIMA);
                    $('[name="JUMLAH_DITOLAK_2"]').val(data.JUMLAH_DITOLAK);
                    $('[name="JUMLAH_DITERIMA_SYARAT_2"]').val(data.JUMLAH_DITERIMA_SYARAT);
                    $('[name="SATUAN_BARANG_2"]').val(data.SATUAN_BARANG);
                    $('[name="KETERANGAN_DITOLAK_2"]').val(data.KETERANGAN_DITOLAK);
                    $('[name="KETERANGAN_DITERIMA_SYARAT_2"]').val(data.KETERANGAN_DITERIMA_SYARAT);
                }
            });
            return false;
        });

        //SIMPAN IDENTITAS FORM
        $('#btn_simpan_identitas_form').click(function() {
            var TANGGAL_DOKUMEN_FSTB = $('#TANGGAL_DOKUMEN_FSTB').val(),
            TANGGAL_DOKUMEN_FSTB = TANGGAL_DOKUMEN_FSTB.split("/").reverse().join("-");

            var TANGGAL_BARANG_DATANG_HARI = $('#TANGGAL_BARANG_DATANG_HARI').val(),
            TANGGAL_BARANG_DATANG_HARI = TANGGAL_BARANG_DATANG_HARI.split("/").reverse().join("-");


            var form_data = {
                ID_FSTB: ID_FSTB,
                NO_URUT_FSTB_GANTI: $('#NO_URUT_FSTB_GANTI').val(),
                NO_URUT_FSTB_ASLI: $('#NO_URUT_FSTB_ASLI').val(),
                TANGGAL_DOKUMEN_FSTB: TANGGAL_DOKUMEN_FSTB,
                LOKASI_PENYERAHAN: $('#LOKASI_PENYERAHAN').val(),
                NOMOR_SURAT_JALAN_VENDOR: $('#NOMOR_SURAT_JALAN_VENDOR').val(),
                NAMA_PENGIRIM: $('#NAMA_PENGIRIM').val(),
                NO_HP_PENGIRIM: $('#NO_HP_PENGIRIM').val(),
                NAMA_PEGAWAI: $('#NAMA_PEGAWAI').val(),
                TANGGAL_BARANG_DATANG_HARI: TANGGAL_BARANG_DATANG_HARI,
                CTT_STAFF_LOG: $('#CTT_STAFF_LOG').val()
            };
            $.ajax({
                url: "<?php echo site_url('FSTB_form/simpan_identitas_form'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 'true') {
                        $('#alert-msg-8').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var HASH_MD5_FSTB = $('#HASH_MD5_FSTB').val()
                        var alamat = "<?php echo base_url('FSTB_form/index/'); ?>" + HASH_MD5_FSTB;
                        window.open(
                            alamat,
                            '_self' // <- This is what makes it open in a new window.
                        );
                    }
                }
            });
            return false;
        });

        //SIMPAN PERUBAHAN DAN LIHAT PDF
        $('#btn_simpan_perubahan_pdf').click(function() {
            var HASH_MD5_FSTB = $('#HASH_MD5_FSTB').val()
            var alamat = "<?php echo base_url('FSTB_form/view/'); ?>" + HASH_MD5_FSTB;
            window.open(
                alamat,
                '_self' // <- This is what makes it open in a new window.
            );
        });

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            var form_data = {
                ID_PO_FORM : $('#ID_PO_FORM_2').val(),
                ID_FSTB_FORM : $('#ID_FSTB_FORM_2').val(),
                JUMLAH_DIMINTA : $('#JUMLAH_DIMINTA_2').val(),
                JUMLAH_DIMINTA_ORIGINAL : $('#JUMLAH_DIMINTA_ORIGINAL_2').val(),
                JUMLAH_DITERIMA : $('#JUMLAH_DITERIMA_2').val(),
                JUMLAH_DITOLAK : $('#JUMLAH_DITOLAK_2').val(),
                JUMLAH_DITERIMA_SYARAT : $('#JUMLAH_DITERIMA_SYARAT_2').val(),
                KETERANGAN_DITOLAK : $('#KETERANGAN_DITOLAK_2').val(),
                KETERANGAN_DITERIMA_SYARAT : $('#KETERANGAN_DITERIMA_SYARAT_2').val()
            };

            $.ajax({
                url: "<?php echo site_url('FSTB_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: form_data,
                async: false,
                error: function (xhr, status) {
                    alert(status);
                },
                success: function(data) {

                    if (data == true) {
                        document.getElementById("saya_setuju").checked = false;
                        $('#btn_update').attr('disabled', true); //disable input
                        $('#ModalEdit').modal('hide');
                        $("#mydata").dataTable().fnDestroy();
                        tampil_data_form_fstb();
                        window.location.reload();
                    } else {
                        $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
                    }

                }
            });
            return false;
        });


        hapus_semua_item.onclick = function() {
            var id = $(this).attr('data');
            $('#ModalHapusSemua').modal('show');
            $('[name="kode_semua"]').val(id);
            $('#NAMA_5').html('</br>FISTB kode : ' + id);
        };

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function() {
            var ID_FSTB_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('FSTB_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_FSTB_FORM: ID_FSTB_FORM
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalHapus').modal('show');
                        $('[name="kode"]').val(ID_FSTB_FORM);
                        $('#NAMA_3').html('</br>Nama Barang : ' + data.NAMA_BARANG);

                    });
                }
            });
        });

        //HAPUS DATA SEMUA
        $('#btn_hapus_semua').on('click', function () {
            var HASH_MD5_FSTB = $('#textkode_semua').val();
            console.log(HASH_MD5_FSTB);

            $.ajax({
                type: "POST",
                url: "<?php echo base_url('FSTB_form/hapus_data_semua') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_FSTB: HASH_MD5_FSTB
                },
                success: function (data) {
                    console.log(data);
                    // $('#ModalHapusSemua').modal('hide');
                    window.location.reload();
                }
            });

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

        $('#saya_setuju_kirim').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_fstb').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_fstb').attr('disabled', true); //disable input
            }
        });

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update').attr('disabled', true); //disable input
            }
        });

        //UPDATE CATATAN FISTB 
        $('#btn_update_catatan_po').on('click', function() {

            let ID_FSTB = $('#ID_FSTB6').val();
            let CTT_STAFF_PROC = $('#CTT_STAFF_PROC6').val();
            $.ajax({
                url: "<?php echo site_url('FSTB_form/update_data_catatan_po') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FSTB: ID_FSTB,
                    CTT_STAFF_PROC: CTT_STAFF_PROC
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

        $('#saya_setuju_hapus').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_hapus').removeAttr('disabled'); //enable input

            } else {
                $('#btn_hapus').attr('disabled', true); //disable input
            }
        });

        $('#saya_setuju_hapus_semua').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {
                $('#btn_hapus_semua').removeAttr('disabled'); //enable input
            } else {
                $('#btn_hapus_semua').attr('disabled', true); //disable input
            }
        });
        


        //UPDATE KIRIM FISTB
        $('#btn_update_kirim_fstb').on('click', function() {

            var ID_FSTB = $('#ID_FSTB7').val();
            console.log(ID_FSTB);
            $.ajax({
                url: "<?php echo site_url('FSTB_form/update_data_kirim_fstb') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_FSTB: ID_FSTB,
                },
                success: function(data) {
                    console.log(data);
                    if (data == true) {
                        $('#ModalEditKirimFSTB').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        tambah_item_po.onclick = function() {

            $('#ModalAddDariSPP').modal('show');

            $('#mydata_PO').DataTable().destroy();

            //fungsi tampil data
            var data = <?php echo json_encode($po_barang_list); ?>;
            var html = '';
            var jumlah_realisasi_fstb, jumlah_sisa = 0;


            for (l = 0; l < data.length; l++) {

                var form_data = {
                    ID_PO_FORM: data[l].ID_PO_FORM
                };

                $.ajax({
                    url: "<?php echo site_url('FSTB_form/data_qty_fstb_realisasi') ?>",
                    type: "POST",
                    dataType: "JSON",
                    async: false,
                    data: form_data,
                    success: function (data) {
                        
                        var data_3 = data;

                        if (data_3[0].JUMLAH_BARANG == null) {
                            jumlah_realisasi_fstb = 0;
                        }
                        else {
                            jumlah_realisasi_fstb = data_3[0].JUMLAH_BARANG;
                        }

                    }
                });

                jumlah_sisa = data[l].JUMLAH_BARANG - jumlah_realisasi_fstb;

                html += '<tr>' +
                
                '<td>' + 
                '<input name="ID_FSTB" class="form-control" type="text" value="'+ ID_FSTB +'" style="display: none;" readonly>' +
                '<input class="checkbox" name="ID_PO_FORM[]" value="'+ data[l].ID_PO_FORM +'" type="checkbox">' +
                '</td>' +
                '<td>' + data[l].NAMA_BARANG + '</td>' +
                '<td>' + data[l].MEREK + '</td>' +
                '<td>' + data[l].SPESIFIKASI_SINGKAT + '</td>' +
                '<td>' + data[l].NAMA_KLASIFIKASI_BARANG + '</td>' +
                '<td>' + data[l].JUMLAH_BARANG + ' ' + data[l].SATUAN_BARANG + '</td>' +
                '<td>' + jumlah_realisasi_fstb + ' ' + data[l].SATUAN_BARANG + '</td>' +
                '<td>' + jumlah_sisa + ' ' + data[l].SATUAN_BARANG + '</td>' +
                '<td>' + data[l].NAMA_VENDOR + '</td>' +
                '</td>' +
                '</tr>';

            }
            $('#show_data_PO').html(html);


            $('#mydata_PO').dataTable({
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
                        title: 'PO export EXCEL',
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


        };

        item_edit_catatan_po.onclick = function() {
            var HASH_MD5_FSTB = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('FSTB_form/get_data_ctt_po') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_FSTB: HASH_MD5_FSTB
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditCatatanFSTB').modal('show');
                        $('[name="ID_FSTB6"]').val(data.ID_FSTB);
                        $('[name="CTT_STAFF_PROC6"]').val(data.CTT_STAFF_PROC);

                        $('#alert-msg-6').html('<div></div>');
                    });
                }
            });
            return false;
        };

        item_edit_kirim_fstb.onclick = function() {
            var ID_FSTB = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('FSTB_form/data_fstb_form') ?>",
                dataType: "JSON",
                data: {
                    ID_FSTB: ID_FSTB
                },
                success: function(data) {
                    console.log(data);
                    $('#ModalEditKirimFSTB').modal('show');
                    $.each(data, function() {
                        $('[name="ID_FSTB7"]').val(data[0].ID_FSTB);
                    });

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);
                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        let i = 0;
                        for (i = 0; i < data.length; i++) {

                            //CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].JUMLAH_DITERIMA == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_jumlah_barang').attr("hidden", false);
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

    });
</script>

</body>

</html>