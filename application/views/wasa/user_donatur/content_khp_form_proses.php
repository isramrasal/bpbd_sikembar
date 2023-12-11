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
        <h2>Form KHP</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/KHP/') ?>">KHP</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form KHP</a>
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
                    <h5>Formulir Pengajuan KHP</h5>
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
                            <li class="" style="display:none;"><a data-toggle="tab" href="#tab-2">Catatan KHP</a></li>
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
                                        if (isset($KHP)) {
                                        foreach ($KHP->result() as $KHP):
                                        ?>

                                        <div class="form-group"><label class="col-sm-2 control-label">No. Urut KHP</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="NO_URUT_KHP_GANTI" id="NO_URUT_KHP_GANTI" class="form-control" value="<?php echo $KHP->NO_URUT_KHP; ?>">
                                                <input name="NO_URUT_KHP_ASLI" id="NO_URUT_KHP_ASLI" type="hidden" class="form-control" value="<?php echo $KHP->NO_URUT_KHP; ?>">
                                            </div>
                                        </div>

                                        <div class="form-group" id="data_TANGGAL_DOKUMEN_KHP"><label class="col-sm-2 control-label">Tanggal Dokumen KHP</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($KHP->TANGGAL_DOKUMEN_KHP)) {
                                                ?>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_KHP" name="TANGGAL_DOKUMEN_KHP" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_KHP" name="TANGGAL_DOKUMEN_KHP" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $KHP->TANGGAL_DOKUMEN_KHP; ?>">
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Tanggal KHP By System</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo tanggal_indo_full($KHP->TANGGAL_PEMBUATAN_KHP_HARI, false); ?>" disabled></div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Catatan KHP</label>
                                            <div class="col-sm-10">
                                                <input name="KETERANGAN_KHP" id="KETERANGAN_KHP" type="text"
                                                    class="form-control" value="<?php echo $KHP->KETERANGAN_KHP; ?>">
                                            </div>
                                        </div>

                                        <input type="text" name="HASH_MD5_KHP" id="HASH_MD5_KHP" value="<?php echo $KHP->HASH_MD5_KHP; ?>" hidden>

                                        <?php endforeach;
                                        } ?>

                                        <div class="ibox float-e-margins">
                                            <div class="ibox-title">
                                                <h5>Identitas Vendor Pertama</h5>
                                                <div class="ibox-tools">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ibox-content">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Vendor Pertama</label>
                                                    <div class="col-sm-10">
                                                        <?php
                                                        if (empty($ID_VENDOR_PERTAMA)) {
                                                            ?>
                                                            <select class="chosen-select" name="ID_VENDOR_PERTAMA"
                                                                id="ID_VENDOR_PERTAMA">
                                                                <option value=''>- Pilih Vendor -</option>
                                                                <?php foreach ($vendor_pertama as $prov_pertama) {
                                                                    echo '<option value="' . $prov_pertama->ID_VENDOR . '">' . $prov_pertama->NAMA_VENDOR . '</option>';
                                                                } ?>
                                                            </select>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <select class="chosen-select" name="ID_VENDOR_PERTAMA"
                                                                id="ID_VENDOR_PERTAMA">
                                                                <option value=''>- Pilih Vendor -</option>
                                                                <?php foreach ($vendor_pertama as $prov_pertama) {
                                                                    if ($prov_pertama->ID_VENDOR == $ID_VENDOR_PERTAMA) {
                                                                        echo '<option selected="selected" value="' . $prov_pertama->ID_VENDOR . '">' . $prov_pertama->NAMA_VENDOR . ' </option>';
                                                                    } else {
                                                                        echo '<option value="' . $prov_pertama->ID_VENDOR . '">' . $prov_pertama->NAMA_VENDOR . ' </option>';
                                                                    }
                                                                } ?>
                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div id="show_hidden_vendor_pertama">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Delivery Vendor Pertama</label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            if (empty($DELIVERY_VENDOR_PERTAMA)) {
                                                                ?>
                                                                <input type="text" name="DELIVERY_VENDOR_PERTAMA"
                                                                    id="DELIVERY_VENDOR_PERTAMA" class="form-control"
                                                                    placeholder="Contoh: Harga Franco Jakarta dikirim Via Udara">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="text" name="DELIVERY_VENDOR_PERTAMA"
                                                                    id="DELIVERY_VENDOR_PERTAMA" class="form-control"
                                                                    value="<?php echo $DELIVERY_VENDOR_PERTAMA; ?>"
                                                                    placeholder="Contoh: Harga Franco Jakarta dikirim Via Udara">
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Term Of Payment</label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            if (empty($SISTEM_BAYAR_VENDOR_PERTAMA)) {
                                                                ?>
                                                                <input type="text" name="SISTEM_BAYAR_VENDOR_PERTAMA"
                                                                    id="SISTEM_BAYAR_VENDOR_PERTAMA" class="form-control"
                                                                    placeholder="Contoh: 1 Bulan Setelah Dokumen Invoice Lengkap Diterima">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="text" name="SISTEM_BAYAR_VENDOR_PERTAMA"
                                                                    id="SISTEM_BAYAR_VENDOR_PERTAMA" class="form-control"
                                                                    value="<?php echo $SISTEM_BAYAR_VENDOR_PERTAMA; ?>"
                                                                    placeholder="Contoh: 1 Bulan Setelah Dokumen Invoice Lengkap Diterima">
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="ibox float-e-margins">
                                            <div class="ibox-title">
                                                <h5>Identitas Vendor Kedua</h5>
                                                <div class="ibox-tools">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ibox-content">
                                                <div class="form-group">
                                                    <label class="col-sm-2 control-label">Vendor Kedua</label>
                                                    <div class="col-sm-10">
                                                        <?php
                                                        if (empty($ID_VENDOR_KEDUA)) {
                                                            ?>
                                                            <select class="chosen-select" name="ID_VENDOR_KEDUA" id="ID_VENDOR_KEDUA">
                                                                <option value=''>- Pilih Vendor -</option>
                                                                <?php foreach ($vendor_kedua as $prov_kedua) {
                                                                    echo '<option value="' . $prov_kedua->ID_VENDOR . '">' . $prov_kedua->NAMA_VENDOR . '</option>';
                                                                } ?>
                                                            </select>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <select class="chosen-select" name="ID_VENDOR_KEDUA" id="ID_VENDOR_KEDUA">
                                                                <option value=''>- Pilih Vendor -</option>
                                                                <?php foreach ($vendor_kedua as $prov_kedua) {
                                                                    if ($prov_kedua->ID_VENDOR == $ID_VENDOR_KEDUA) {
                                                                        echo '<option selected="selected" value="' . $prov_kedua->ID_VENDOR . '">' . $prov_kedua->NAMA_VENDOR . ' </option>';
                                                                    } else {
                                                                        echo '<option value="' . $prov_kedua->ID_VENDOR . '">' . $prov_kedua->NAMA_VENDOR . ' </option>';
                                                                    }
                                                                } ?>

                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div id="show_hidden_vendor_kedua">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Delivery Vendor Kedua</label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            if (empty($DELIVERY_VENDOR_KEDUA)) {
                                                                ?>
                                                                <input type="text" name="DELIVERY_VENDOR_KEDUA"
                                                                    id="DELIVERY_VENDOR_KEDUA" class="form-control"
                                                                    placeholder="Contoh: Harga Franco Jakarta dikirim Via Udara">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="text" name="DELIVERY_VENDOR_KEDUA"
                                                                    id="DELIVERY_VENDOR_KEDUA" class="form-control"
                                                                    value="<?php echo $DELIVERY_VENDOR_KEDUA; ?>"
                                                                    placeholder="Contoh: Harga Franco Jakarta dikirim Via Udara">
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Term Of Payment</label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            if (empty($SISTEM_BAYAR_VENDOR_KEDUA)) {
                                                                ?>
                                                                <input type="text" name="SISTEM_BAYAR_VENDOR_KEDUA"
                                                                    id="SISTEM_BAYAR_VENDOR_KEDUA" class="form-control"
                                                                    placeholder="Contoh: 1 Bulan Setelah Dokumen Invoice Lengkap Diterima">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="text" name="SISTEM_BAYAR_VENDOR_KEDUA"
                                                                    id="SISTEM_BAYAR_VENDOR_KEDUA" class="form-control"
                                                                    value="<?php echo $SISTEM_BAYAR_VENDOR_KEDUA; ?>"
                                                                    placeholder="Contoh: 1 Bulan Setelah Dokumen Invoice Lengkap Diterima">
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <div class="ibox float-e-margins">
                                            <div class="ibox-title">
                                                <h5>Identitas Vendor Ketiga</h5>
                                                <div class="ibox-tools">
                                                    <a class="collapse-link">
                                                        <i class="fa fa-chevron-up"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="ibox-content">
                                                <div class="form-group"><label class="col-sm-2 control-label">Vendor Ketiga</label>
                                                    <div class="col-sm-10">
                                                        <?php
                                                        if (empty($ID_VENDOR_KETIGA)) {
                                                            ?>
                                                            <select class="chosen-select" name="ID_VENDOR_KETIGA" id="ID_VENDOR_KETIGA">
                                                                <option value=''>- Pilih Vendor -</option>
                                                                <?php foreach ($vendor_ketiga as $prov_ketiga) {
                                                                    echo '<option value="' . $prov_ketiga->ID_VENDOR . '">' . $prov_ketiga->NAMA_VENDOR . '</option>';
                                                                } ?>
                                                            </select>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <select class="chosen-select" name="ID_VENDOR_KETIGA" id="ID_VENDOR_KETIGA">
                                                                <option value=''>- Pilih Vendor -</option>
                                                                <?php foreach ($vendor_ketiga as $prov_ketiga) {
                                                                    if ($prov_ketiga->ID_VENDOR == $ID_VENDOR_KETIGA) {
                                                                        echo '<option selected="selected" value="' . $prov_ketiga->ID_VENDOR . '">' . $prov_ketiga->NAMA_VENDOR . ' </option>';
                                                                    } else {
                                                                        echo '<option value="' . $prov_ketiga->ID_VENDOR . '">' . $prov_ketiga->NAMA_VENDOR . ' </option>';
                                                                    }
                                                                } ?>

                                                            </select>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div id="show_hidden_vendor_ketiga">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Delivery Vendor Ketiga</label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            if (empty($DELIVERY_VENDOR_KETIGA)) {
                                                                ?>
                                                                <input type="text" name="DELIVERY_VENDOR_KETIGA"
                                                                    id="DELIVERY_VENDOR_KETIGA" class="form-control"
                                                                    placeholder="Contoh: Harga Franco Jakarta dikirim Via Udara">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="text" name="DELIVERY_VENDOR_KETIGA"
                                                                    id="DELIVERY_VENDOR_KETIGA" class="form-control"
                                                                    value="<?php echo $DELIVERY_VENDOR_KETIGA; ?>"
                                                                    placeholder="Contoh: Harga Franco Jakarta dikirim Via Udara">
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Term Of Payment</label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            if (empty($SISTEM_BAYAR_VENDOR_KETIGA)) {
                                                                ?>
                                                                <input type="text" name="SISTEM_BAYAR_VENDOR_KETIGA"
                                                                    id="SISTEM_BAYAR_VENDOR_KETIGA" class="form-control"
                                                                    placeholder="Contoh: 1 Bulan Setelah Dokumen Invoice Lengkap Diterima">
                                                                <?php
                                                            } else {
                                                                ?>
                                                                <input type="text" name="SISTEM_BAYAR_VENDOR_KETIGA"
                                                                    id="SISTEM_BAYAR_VENDOR_KETIGA" class="form-control"
                                                                    value="<?php echo $SISTEM_BAYAR_VENDOR_KETIGA; ?>"
                                                                    placeholder="Contoh: 1 Bulan Setelah Dokumen Invoice Lengkap Diterima">
                                                                <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="alert-msg-8"></div>
                                        <button class="btn btn-primary" id="btn_simpan_identitas_form"><i class="fa fa-save"></i> Simpan Identitas Form</button>
                                    </form>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-pane">
                                <div class="panel-body"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>KHP Item Barang/Jasa</h5>
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

                    <a href="javascript:;" id="tambah_item_sppb" name="tambah_item_sppb" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah Item dari SPPB</a>
                    <br>
                    <a href="javascript:;" id="item_edit_upload_excel" name="item_edit_upload_excel" class="btn btn-warning" data="<?php echo $ID_KHP; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Edit Item Barang/Jasa Secara Bulk</a>
                    </br>
                    <a href="javascript:;" id="hapus_semua_item" name="hapus_semua_item" class="btn btn-danger text-right" data="<?php echo $HASH_MD5_KHP; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Hapus Semua Barang/Jasa</a>
                    
                    <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="mydata">
                                <div>
                                    <thead>
                                        <tr>
                                            <th style='width: 5px;'>Nama Barang/Jasa</th>
                                            <th style='width: 5px;'>Merek Barang/Jasa</th>
                                            <th style='width: 5px;'>Spesifikasi Singkat</th>
                                            <th style='width: 5px;'>Jumlah </br> Yang </br> Diadakan</th>
                                            <th style='width: 325px;'>
                                                <?php echo $NAMA_VENDOR_PERTAMA; ?>
                                            </th>
                                            <th style='width: 325px;'><?php echo $NAMA_VENDOR_KEDUA; ?></th>
                                            <th style='width: 325px;'>
                                                <?php echo $NAMA_VENDOR_KETIGA; ?>
                                            </th>
                                            <th style='width: 325px;'>Keputusan</th>
                                            <th style='width: 325px;'>Keterangan</th>
                                            <th style='width: 5px;'>Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data">
                                    </tbody>
                                </div>
                            </table>
                        </div>
                    </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                        <div class="sm-10">
                            <button class="btn btn-primary" id="btn_simpan_perubahan_pdf"><i class="fa fa-save"></i>
                                Simpan Perubahan & View Dokumen KHP</button>
                            </br>
                            <a href="javascript:;" id="item_edit_kirim_khp" name="item_edit_kirim_khp" class="btn btn-success" data="<?php echo $ID_KHP; ?>"><span class="fa fa-send"></span> Ajukan KHP Untuk Proses Selanjutnya </a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- MODAL ADD  DARI SPPB -->
<div class="modal inmodal fade" id="ModalAddDariSPPB" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 60vw;">
        <div class="modal-content animated bounceInRight">
        <?php
        if ($sppb_barang_list != NULL) {
        ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Daftar Item Barang/Jasa dari SPPB</h4>
                <small class="font-bold">Silakan tambah item barang/jasa KHP berdasarkan SPPB</small>
            </div>

            <div class="modal-body">
                <div class="ibox float-e-margins" id="ibox2">
                    <div class="ibox-title">
                        <h5>KHP Item Barang/Jasa</h5>
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
                            <form method="POST" action="<?php echo site_url('KHP_form/simpan_data_dari_sppb_form'); ?>" id="formTambahSPPB">
                                <table class="table table-striped table-bordered table-hover" id="mydata_SPPB">
                                    <thead>
                                        <tr>
                                            <th>Pilih<input type="checkbox" id="checkAllItemSPPB"></th>
                                            <th>Nama Barang/Jasa</th>
                                            <th>Merek Barang/Jasa</th>
                                            <th style="width: 30%;">Spesifikasi Singkat</th>
                                            <th>Kategori RAB dan Klasifikasi Barang</th>
                                            <th>Qty SPPB</th>
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
        <?php echo form_close(); ?>
        <?php
        } else {
        ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Daftar Item Barang/Jasa dari SPPB</h4>
                <b class="font-bold">Maaf semua item barang/jasa dari SPPB sudah ada di Form KHP ini</b>
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


<!-- MODAL EDIT HARGA VENDOR-->
<div class="modal inmodal fade" id="ModalPengajuanVendor" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 60vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Ubah Pengajuan Harga Barang/Jasa</h4>
                <small class="font-bold">Silakan ubah pengajuan harga barang/jasa KHP</small>
            </div>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_KHP_FORM2" id="ID_KHP_FORM2" class="form-control" type="hidden" readonly>
                    <input name="ID_KHP2" id="ID_KHP2" class="form-control" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang/Jasa</label>
                        <div class="col-xs-9">
                            <input name="NAMA2" id="NAMA2" class="form-control" type="text" placeholder="Contoh : Crane" disabled >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang/Jasa</label>
                        <div class="col-xs-9">
                            <input name="MEREK2" id="MEREK2" class="form-control" type="text" placeholder="Contoh : Toyota" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT2" id="SPESIFIKASI_SINGKAT2" class="form-control" type="text" placeholder="Contoh: Mata Gerindra Stainless Grinding ukuran 4 inch" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Yang Diadakan</label>
                        <div class="col-xs-9">
                            <input class=" touchspin1" type="number" value="0" name="JUMLAH_MINTA2" id="JUMLAH_MINTA2" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Satuan Barang</label>
                        <div class="col-xs-9">
                            <input name="SATUAN_BARANG2" id="SATUAN_BARANG2" placeholder="Contoh : PCS" class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN2" id="KETERANGAN2" class="form-control" placeholder="Contoh: Substitusi produk XXX">
                        </div>
                    </div>

                    <hr style="border-top: dotted 2px;" />

                    <div class="form-group">
                        <label class="control-label col-xs-3">Vendor Pertama</label>
                        <div class="col-xs-9">
                            <input name="NAMA_VENDOR_PERTAMA2" id="NAMA_VENDOR_PERTAMA2" class="form-control"
                                value="<?php echo $NAMA_VENDOR_PERTAMA; ?>" disabled>
                            <input name="ID_VENDOR_PERTAMA2" id="ID_VENDOR_PERTAMA2"
                                value="<?php echo $ID_VENDOR_PERTAMA; ?>" type="hidden" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Item Barang (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_VENDOR_PERTAMA2" id="HARGA_SATUAN_BARANG_VENDOR_PERTAMA2"
                                class="form-control" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Total Harga (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_TOTAL_VENDOR_PERTAMA2" id="HARGA_TOTAL_VENDOR_PERTAMA2"
                                class="form-control" type="hidden" disabled>
                            <input name="HARGA_TOTAL_TAMPIL_VENDOR_PERTAMA2" id="HARGA_TOTAL_TAMPIL_VENDOR_PERTAMA2"
                                class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <hr style="border-top: dotted 2px;" />

                    <div class="form-group">
                        <label class="control-label col-xs-3">Vendor Kedua</label>
                        <div class="col-xs-9">
                            <input name="NAMA_VENDOR_KEDUA2" id="NAMA_VENDOR_KEDUA2" class="form-control"
                                value="<?php echo $NAMA_VENDOR_KEDUA; ?>" disabled>
                            <input name="ID_VENDOR_KEDUA2" id="ID_VENDOR_KEDUA2" value="<?php echo $ID_VENDOR_KEDUA; ?>"
                                type="hidden" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Item Barang (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_VENDOR_KEDUA2" id="HARGA_SATUAN_BARANG_VENDOR_KEDUA2"
                                class="form-control" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Total Harga (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_TOTAL_VENDOR_KEDUA2" id="HARGA_TOTAL_VENDOR_KEDUA2" class="form-control"
                                type="hidden" disabled>
                            <input name="HARGA_TOTAL_TAMPIL_VENDOR_KEDUA2" id="HARGA_TOTAL_TAMPIL_VENDOR_KEDUA2"
                                class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <hr style="border-top: dotted 2px;" />

                    <div class="form-group">
                        <label class="control-label col-xs-3">Vendor Ketiga</label>
                        <div class="col-xs-9">
                            <input name="NAMA_VENDOR_KETIGA2" id="NAMA_VENDOR_KETIGA2" class="form-control"
                                value="<?php echo $NAMA_VENDOR_KETIGA; ?>" disabled>
                            <input name="ID_VENDOR_KETIGA2" id="ID_VENDOR_KETIGA2"
                                value="<?php echo $ID_VENDOR_KETIGA; ?>" type="hidden" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Harga Item Barang (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_SATUAN_BARANG_VENDOR_KETIGA2" id="HARGA_SATUAN_BARANG_VENDOR_KETIGA2"
                                class="form-control" type="number">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Total Harga (Rupiah)</label>
                        <div class="col-xs-9">
                            <input name="HARGA_TOTAL_VENDOR_KETIGA2" id="HARGA_TOTAL_VENDOR_KETIGA2"
                                class="form-control" type="hidden" disabled>
                            <input name="HARGA_TOTAL_TAMPIL_VENDOR_KETIGA2" id="HARGA_TOTAL_TAMPIL_VENDOR_KETIGA2"
                                class="form-control" type="text" disabled>
                        </div>
                    </div>

                    <hr style="border-top: dotted 2px;" />

                    <div class="form-group">
                        <label class="col-xs-3 control-label"></label>
                        <div class="col-xs-9">
                            <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya
                                    telah selesai melakukan pengisian identitas dan harga penawaran vendor pada item barang/jasa dengan benar, menyetujui untuk
                                    dimasukkan ke dalam dokumen KHP </label></div>
                        </div>
                    </div>

                    <div id="alert-msg-2"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_ubah_harga" disabled><i class="fa fa-save"></i>
                        Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL EDIT HARGA VENDOR-->

<!-- MODAL EDIT PENETAPAN VENDOR -->
<div class="modal inmodal fade" id="ModalPenetapanVendor" tabindex="-1" role="dialog" aria-labelledby="largeModal"
    aria-hidden="true">
    <div class="modal-dialog" style="width: 60vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <h4 class="modal-title">Penetapan Vendor Barang/Jasa</h4>
                <small class="font-bold">Silakan tetapkan vendor barang/jasa KHP</small>
            </div>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_KHP_FORM3" id="ID_KHP_FORM3" class="form-control" type="hidden" readonly>
                    <input name="ID_KHP3" id="ID_KHP3" class="form-control" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Vendor Ditetapkan</label>
                        <div class="col-xs-9">
                            <select class="chosen-select" name="ID_VENDOR_FIX3" id="ID_VENDOR_FIX3">
                                <option value=''>- Pilih Vendor -</option>
                                <option value='<?php echo $ID_VENDOR_PERTAMA; ?>'>
                                    <?php echo $NAMA_VENDOR_PERTAMA; ?>
                                </option>
                                <option value='<?php echo $ID_VENDOR_KEDUA; ?>'>
                                    <?php echo $NAMA_VENDOR_KEDUA; ?>
                                </option>
                                <option value='<?php echo $ID_VENDOR_KETIGA; ?>'>
                                    <?php echo $NAMA_VENDOR_KETIGA; ?>
                                </option>
                            </select>
                        </div>
                    </div>


                    <div id="alert-msg-3"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_penetapan_vendor"><i class="fa fa-save"></i>
                        Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL EDIT PENETAPAN VENDOR -->

<!-- MODAL KIRIM KHP-->
<div class="modal inmodal fade" id="ModalEditKirimKHP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 60vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Kirim KHP</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form KHP ini untuk proses selanjutnya</small>
            </div>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_KHP7" id="ID_KHP7" class="form-control" type="hidden" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="i-checks"><label> <input type="checkbox" id="saya_setuju_kirim"><i></i> Saya telah selesai melakukan proses form KHP ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang diminta pada KHP ini</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_vendor_pertama" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, belum ada vendor pertama
                            </center>
                        </div>
                    </div>

                    <div id="alert-msg-7"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_kirim_khp" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM KHP-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa KHP</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="ID_KHP_FORM" id="ID_KHP_FORM" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus item barang/jasa ini?</p>
                        <div name="NAMA_3" id="NAMA_3"></div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox i-checks"><label> <input type="checkbox" id="saya_setuju_hapus"><i></i>
                                Saya
                                dengan sadar akan menghapus item barang/jasa tersebut dan memahami data yang
                                sudah
                                dihapus tidak dapat dikembalikan lagi
                            </label></div>
                    </div>

                </div>
                <div id="alert-msg-xx"></div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i
                            class="fa fa-window-close"></i> Batal</button>
                    <button class="btn_hapus btn btn-danger" id="btn_hapus" disabled><i class="fa fa-trash"></i>
                        Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL HAPUS-->

<!-- MODAL MAAF UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalEditExcelMaaf" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 60vw;">
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
                       Maaf, Anda belum memasukkan item untuk diproses dalam KHP ini. Silakan Tambah Item dari SPPB terlebih dahulu.
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

<!-- MODAL BELUM ADA VENDOR PERTAMA UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalEditExcelVendor" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 60vw;">
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
                       Maaf, Anda belum mengatur vendor pertama.
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END MODAL BELUM ADA VENDOR PERTAMA UPLOAD DOCUMENT-->

<!-- MODAL GAGAL UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalGagalExcel" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 60vw;">
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

<!-- MODAL UPLOAD DOCUMENT -->
<div class="modal inmodal fade" id="ModalEditExcel" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 60vw;">
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
                                        File dokumen yang Anda upload akan digunakan untuk keperluan pengisian item barang/jasa KHP, dengan ketentuan sebagai berikut:
                                        <ul class="sortable-list connectList agile-list" id="ketentuan">
                                            <li class="warning-element" id="task1">
                                                1. File dokumen yang diupload harus merupakan data berkaitan dengan KHP No <?php echo $NO_URUT_KHP ?>.
                                            </li>
                                            <li class="danger-element" id="task2">
                                                2. Ukuran dokumen yang diterima sistem maksimal 1.5 Giga Bytes (1.5 GB). Ekstensi/tipe file yang diterima sistem adalah .XLSX
                                            </li>
                                            <li class="success-element" id="task4">
                                                3. File yang diupload berdasarkan isian KHP ini. <a href="<?php echo base_url(); ?>KHP_form/download_excel/<?php echo $HASH_MD5_KHP ?>">Download file bulk khusus KHP ini</a>
                                            </li>
                                            <li class="danger-element" id="task2">
                                                4. Dilarang mengubah kolom ID KHP FORM
                                            </li>
                                        </ul>
                                    </p>

                                    <form action="#" class="dropzone" id="dropzoneForm">

                                        </br>
                                        <div class="col-xs-9">
                                            <input name="HASH_MD5_KHP_UPLOAD_EXCEL" id="HASH_MD5_KHP_UPLOAD_EXCEL" type="hidden" value="<?php echo $HASH_MD5_KHP ?>" readonly>
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

<!--MODAL HAPUS SEMUA-->
<div class="modal fade" id="ModalHapusSemua" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 60vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Semua Item Barang/Jasa KHP</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="HASH_MD5_KHP_3" id="HASH_MD5_KHP_3" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus semua item barang/jasa pada KHP ini?</p>
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

<!-- Chosen -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/chosen/chosen.jquery.js"></script>

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

    $(document).ready(function () {
        if (document.getElementById('dropzoneForm')) {
            var file_upload = new Dropzone(".dropzone", {
                url: "<?php echo base_url('index.php/KHP_form/proses_upload_file_excel_bulk_khp') ?>",
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
                            HASH_MD5_KHP_UPLOAD_EXCEL: $('#HASH_MD5_KHP_UPLOAD_EXCEL').val()
                        };
                        $.ajax({
                            url: "<?php echo base_url('index.php/KHP_form/proses_upload_file_excel_bulk_khp') ?>",
                            type: 'POST',
                            data: form_data,
                            success: function(data) {
                                if (data != '') {
                                    console.log(data);
                                    console.log('1');

                                } else {
                                    console.log(data);
                                    console.log('2');
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

        $('.chosen-select').chosen({width: "100%"});

        var ID_SPPB = <?php echo $ID_SPPB; ?>;
        var ID_KHP = <?php echo $ID_KHP; ?>;

        $('#data_TANGGAL_DOKUMEN_KHP .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd/mm/yyyy'
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

        $("#HARGA_SATUAN_BARANG_VENDOR_PERTAMA2").on("change", function () {

            var HARGA = $("#HARGA_SATUAN_BARANG_VENDOR_PERTAMA2").val();
            var JUMLAH = $("#JUMLAH_MINTA2").val();
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_VENDOR_PERTAMA2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_VENDOR_PERTAMA2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });

        $("#HARGA_SATUAN_BARANG_VENDOR_PERTAMA2").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_VENDOR_PERTAMA2").val();
            var JUMLAH = $("#JUMLAH_MINTA2").val();
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_VENDOR_PERTAMA2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_VENDOR_PERTAMA2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });


        $("#HARGA_SATUAN_BARANG_VENDOR_PERTAMA2").on("keyup", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_VENDOR_PERTAMA2").val();
            var JUMLAH = $("#JUMLAH_MINTA2").val();
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_VENDOR_PERTAMA2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_VENDOR_PERTAMA2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });

        $("#HARGA_SATUAN_BARANG_VENDOR_KEDUA2").on("change", function () {

            var HARGA = $("#HARGA_SATUAN_BARANG_VENDOR_KEDUA2").val();
            var JUMLAH = $("#JUMLAH_MINTA2").val();
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_VENDOR_KEDUA2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_VENDOR_KEDUA2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));

        });

        $("#HARGA_SATUAN_BARANG_VENDOR_KEDUA2").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_VENDOR_KEDUA2").val();
            var JUMLAH = $("#JUMLAH_MINTA2").val();
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_VENDOR_KEDUA2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_VENDOR_KEDUA2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });


        $("#HARGA_SATUAN_BARANG_VENDOR_KEDUA2").on("keyup", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_VENDOR_KEDUA2").val();
            var JUMLAH = $("#JUMLAH_MINTA2").val();
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_VENDOR_KEDUA2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_VENDOR_KEDUA2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });

        $("#HARGA_SATUAN_BARANG_VENDOR_KETIGA2").on("change", function () {

            var HARGA = $("#HARGA_SATUAN_BARANG_VENDOR_KETIGA2").val();
            var JUMLAH = $("#JUMLAH_MINTA2").val();
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_VENDOR_KETIGA2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_VENDOR_KETIGA2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });

        $("#HARGA_SATUAN_BARANG_VENDOR_KETIGA2").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_VENDOR_KETIGA2").val();
            var JUMLAH = $("#JUMLAH_MINTA2").val();
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_VENDOR_KETIGA2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_VENDOR_KETIGA2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });


        $("#HARGA_SATUAN_BARANG_VENDOR_KETIGA2").on("keyup", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_VENDOR_KETIGA2").val();
            var JUMLAH = $("#JUMLAH_MINTA2").val();
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_VENDOR_KETIGA2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_VENDOR_KETIGA2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0, 
                minimumFractionDigits: 0,
            }).format(TOTAL));
        });

        $("#ID_VENDOR_PERTAMA").change(function () {
            if ($("#ID_VENDOR_PERTAMA option:selected").text() != '- Pilih Vendor -') {
                $('#show_hidden_vendor_pertama').attr("hidden", false);
            }
            else if ($("#ID_VENDOR_PERTAMA option:selected").text() == '- Pilih Vendor -') {
                $('#show_hidden_vendor_pertama').attr("hidden", true);
            }
        });

        $("#ID_VENDOR_KEDUA").change(function () {
            if ($("#ID_VENDOR_KEDUA option:selected").text() == '- Pilih Vendor -') {
                $('#show_hidden_vendor_kedua').attr("hidden", true);
            }
            else if ($("#ID_VENDOR_KEDUA option:selected").text() == 'Tidak Ada') {
                $('#show_hidden_vendor_kedua').attr("hidden", true);
            }
            else {
                $('#show_hidden_vendor_kedua').attr("hidden", false);
            }
        });

        $("#ID_VENDOR_KETIGA").change(function () {
            if ($("#ID_VENDOR_KETIGA option:selected").text() == '- Pilih Vendor -') {
                $('#show_hidden_vendor_ketiga').attr("hidden", true);
            }
            else if ($("#ID_VENDOR_KETIGA option:selected").text() == 'Tidak Ada') {
                $('#show_hidden_vendor_ketiga').attr("hidden", true);
            }
            else {
                $('#show_hidden_vendor_ketiga').attr("hidden", false);
            }
        });


        tampil_data_form_khp(); //pemanggilan fungsi tampil data.

        $('#mydata').dataTable({
            pageLength: 10,
            aaSorting: [],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                {
                    extend: 'excel',
                    title: 'KHP Form'
                },
                {
                    extend: 'print',
                    customize: function (win) {
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
        function tampil_data_form_khp() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url() ?>KHP_form/data_khp_form',
                async: false,
                dataType: 'JSON',
                data: {
                    ID_KHP: ID_KHP
                },
                success: function (data) {

                    var data_1 = data;
                    var KHP, html, NAMA_VENDOR_FIX = '';

                    for (i = 0; i < data_1.length; i++) {

                        if (data_1[i].NAMA_VENDOR_FIX == null) {
                            NAMA_VENDOR_FIX = "";
                        }
                        else {
                            NAMA_VENDOR_FIX = data_1[i].NAMA_VENDOR_FIX;
                        }

                        html +=
                            '<tr>' +
                            '</td>' +
                            '<td>' + data_1[i].NAMA_BARANG + '</td>' +
                            '<td>' + data_1[i].MEREK + '</td>' +
                            '<td>' + data_1[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data_1[i].JUMLAH_MINTA + ' ' + data_1[i].SATUAN_BARANG + '</td>' +
                            '<td>' + 'Harga Satuan: ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0, minimumFractionDigits: 0 }).format(data_1[i].HARGA_SATUAN_BARANG_VENDOR_PERTAMA) + '</br></br>' +
                            'Harga Total: ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0, minimumFractionDigits: 0 }).format(data_1[i].HARGA_TOTAL_VENDOR_PERTAMA) + '</br></br>' + '</td>' +
                            '<td>' + 'Harga Satuan: ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0, minimumFractionDigits: 0 }).format(data_1[i].HARGA_SATUAN_BARANG_VENDOR_KEDUA) + '</br></br>' +
                            'Harga Total: ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0, minimumFractionDigits: 0 }).format(data_1[i].HARGA_TOTAL_VENDOR_KEDUA) + '</br></br>' + '</td>' +
                            '<td>' + 'Harga Satuan: ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0, minimumFractionDigits: 0 }).format(data_1[i].HARGA_SATUAN_BARANG_VENDOR_KETIGA) + '</br></br>' +
                            'Harga Total: ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0, minimumFractionDigits: 0 }).format(data_1[i].HARGA_TOTAL_VENDOR_KETIGA) + '</br></br>' + '</td>' +
                            '<td>' + NAMA_VENDOR_FIX + '</td>' +
                            '<td>' + data_1[i].KETERANGAN + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-warning btn-xs item_pengajuan block" data="' + data_1[i].ID_KHP_FORM + '"><i class="fa fa-pencil"></i> Ubah</a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-info btn-xs item_penetapan block" data="' + data_1[i].ID_KHP_FORM + '"><i class="fa fa-pencil"></i> Penetapan</a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data_1[i].ID_KHP_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' +
                            '</tr>';
                        penawaran = '';
                    }
                    $('#show_data').html(html);
                }

            });
        }

        //GET UPDATE untuk edit pengajuan
        $('#show_data').on('click', '.item_pengajuan', function () {
            var ID_KHP_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('KHP_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_KHP_FORM: ID_KHP_FORM
                },
                success: function (data) {

                    $('#ModalPengajuanVendor').modal('show');
                    $('[name="ID_KHP_FORM2"]').val(data.ID_KHP_FORM);
                    $('[name="ID_KHP2"]').val(data.ID_KHP);
                    $('[name="NAMA2"]').val(data.NAMA_BARANG);
                    $('[name="MEREK2"]').val(data.MEREK);
                    $('[name="SPESIFIKASI_SINGKAT2"]').val(data.SPESIFIKASI_SINGKAT);
                    $('[name="JUMLAH_MINTA2"]').val(data.JUMLAH_MINTA);
                    $('[name="SATUAN_BARANG2"]').val(data.SATUAN_BARANG);
                    $('[name="KETERANGAN2"]').val(data.KETERANGAN);
                    $('[name="HARGA_SATUAN_BARANG_VENDOR_PERTAMA2"]').val(data.HARGA_SATUAN_BARANG_VENDOR_PERTAMA);
                    $('[name="HARGA_SATUAN_BARANG_VENDOR_KEDUA2"]').val(data.HARGA_SATUAN_BARANG_VENDOR_KEDUA);
                    $('[name="HARGA_SATUAN_BARANG_VENDOR_KETIGA2"]').val(data.HARGA_SATUAN_BARANG_VENDOR_KETIGA);
                    $('[name="KETERANGAN2"]').val(data.KETERANGAN);

                    var HARGA_PERTAMA = $("#HARGA_SATUAN_BARANG_VENDOR_PERTAMA2").val();
                    var JUMLAH_PERTAMA = $("#JUMLAH_MINTA2").val();
                    var TOTAL_PERTAMA = HARGA_PERTAMA * JUMLAH_PERTAMA;

                    $('[name="HARGA_TOTAL_VENDOR_PERTAMA2"]').val(TOTAL_PERTAMA);
                    $('[name="HARGA_TOTAL_TAMPIL_VENDOR_PERTAMA2"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(TOTAL_PERTAMA));

                    var HARGA_KEDUA = $("#HARGA_SATUAN_BARANG_VENDOR_KEDUA2").val();
                    var JUMLAH_KEDUA = $("#JUMLAH_MINTA2").val();
                    var TOTAL_KEDUA = HARGA_KEDUA * JUMLAH_KEDUA;

                    $('[name="HARGA_TOTAL_VENDOR_KEDUA2"]').val(TOTAL_KEDUA);
                    $('[name="HARGA_TOTAL_TAMPIL_VENDOR_KEDUA2"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(TOTAL_KEDUA));

                    var HARGA_KETIGA = $("#HARGA_SATUAN_BARANG_VENDOR_KETIGA2").val();
                    var JUMLAH_KETIGA = $("#JUMLAH_MINTA2").val();
                    var TOTAL_KETIGA = HARGA_KETIGA * JUMLAH_KETIGA;

                    $('[name="HARGA_TOTAL_VENDOR_KETIGA2"]').val(TOTAL_KETIGA);
                    $('[name="HARGA_TOTAL_TAMPIL_VENDOR_KETIGA2"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0, 
                        minimumFractionDigits: 0,
                    }).format(TOTAL_KETIGA));
                }
            });
            return false;
        });

        //GET UPDATE untuk edit pengajuan
        $('#show_data').on('click', '.item_penetapan', function () {
            var ID_KHP_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('KHP_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_KHP_FORM: ID_KHP_FORM
                },
                success: function (data) {

                    $('#ModalPenetapanVendor').modal('show');
                    $('[name="ID_KHP_FORM3"]').val(data.ID_KHP_FORM);
                    $('[name="ID_KHP3"]').val(data.ID_KHP);
                    $('[name="NAMA2"]').val(data.NAMA_BARANG);
                }
            });
            return false;
        });

        //GET HAPUS
        $('#show_data').on('click', '.item_hapus', function () {
            var ID_KHP_FORM = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('KHP_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_KHP_FORM: ID_KHP_FORM
                },
                success: function (data) {

                    $('#ModalHapus').modal('show');
                    $('[name="ID_KHP_FORM"]').val(ID_KHP_FORM);
                    $('#NAMA_3').html('</br>Nama Barang : ' + data.NAMA_BARANG);


                }
            });
        });

        //SIMPAN IDENTITAS FORM
        $('#btn_simpan_identitas_form').click(function () {

            var TANGGAL_DOKUMEN_KHP = $('#TANGGAL_DOKUMEN_KHP').val(),
            TANGGAL_DOKUMEN_KHP = TANGGAL_DOKUMEN_KHP.split("/").reverse().join("-");

            var form_data = {
                ID_KHP: ID_KHP,
                KETERANGAN_KHP: $('#KETERANGAN_KHP').val(),
                ID_VENDOR_PERTAMA: $('#ID_VENDOR_PERTAMA').val(),
                DELIVERY_VENDOR_PERTAMA: $('#DELIVERY_VENDOR_PERTAMA').val(),
                SISTEM_BAYAR_VENDOR_PERTAMA: $('#SISTEM_BAYAR_VENDOR_PERTAMA').val(),
                ID_VENDOR_KEDUA: $('#ID_VENDOR_KEDUA').val(),
                DELIVERY_VENDOR_KEDUA: $('#DELIVERY_VENDOR_KEDUA').val(),
                SISTEM_BAYAR_VENDOR_KEDUA: $('#SISTEM_BAYAR_VENDOR_KEDUA').val(),
                ID_VENDOR_KETIGA: $('#ID_VENDOR_KETIGA').val(),
                DELIVERY_VENDOR_KETIGA: $('#DELIVERY_VENDOR_KETIGA').val(),
                SISTEM_BAYAR_VENDOR_KETIGA: $('#SISTEM_BAYAR_VENDOR_KETIGA').val(),
                TANGGAL_DOKUMEN_KHP: TANGGAL_DOKUMEN_KHP,
                NO_URUT_KHP_GANTI: $('#NO_URUT_KHP_GANTI').val(),
                NO_URUT_KHP_ASLI: $('#NO_URUT_KHP_ASLI').val(),

            };
            $.ajax({
                url: "<?php echo site_url('KHP_form/simpan_identitas_form'); ?>",
                type: 'POST',
                data: form_data,
                success: function (data) {
                    if (data != 'true') {
                        $('#alert-msg-8').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var HASH_MD5_KHP = $('#HASH_MD5_KHP').val()
                        var alamat = "<?php echo base_url('KHP_form/index/'); ?>" + HASH_MD5_KHP;
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
        $('#btn_simpan_perubahan_pdf').click(function () {

            var HASH_MD5_KHP = $('#HASH_MD5_KHP').val()
            var alamat = "<?php echo base_url('KHP_form/view/'); ?>" + HASH_MD5_KHP;
            window.open(
                alamat,
                '_blank' // <- This is what makes it open in a new window.
            );
        });

        //UPDATE DATA HARGA VENDOR
        $('#btn_ubah_harga').on('click', function () {

            var form_data = {
                ID_KHP_FORM: $('#ID_KHP_FORM2').val(),
                ID_KHP: $('#ID_KHP2').val(),
                NAMA: $('#NAMA2').val(),
                MEREK: $('#MEREK2').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT2').val(),
                JUMLAH_MINTA: $('#JUMLAH_MINTA2').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG2').val(),
                KETERANGAN: $('#KETERANGAN2').val(),

                ID_VENDOR_PERTAMA: $('#ID_VENDOR_PERTAMA2').val(),
                NAMA_VENDOR_PERTAMA: $('#NAMA_VENDOR_PERTAMA2').val(),
                HARGA_SATUAN_BARANG_VENDOR_PERTAMA: $('#HARGA_SATUAN_BARANG_VENDOR_PERTAMA2').val(),
                DELIVERY_VENDOR_PERTAMA: $('#DELIVERY_VENDOR_PERTAMA2').val(),
                SISTEM_BAYAR_VENDOR_PERTAMA: $('#SISTEM_BAYAR_VENDOR_PERTAMA2').val(),
                HARGA_TOTAL_VENDOR_PERTAMA: $('#HARGA_TOTAL_VENDOR_PERTAMA2').val(),

                ID_VENDOR_KEDUA: $('#ID_VENDOR_KEDUA2').val(),
                NAMA_VENDOR_KEDUA: $('#NAMA_VENDOR_KEDUA2').val(),
                HARGA_SATUAN_BARANG_VENDOR_KEDUA: $('#HARGA_SATUAN_BARANG_VENDOR_KEDUA2').val(),
                DELIVERY_VENDOR_KEDUA: $('#DELIVERY_VENDOR_KEDUA2').val(),
                SISTEM_BAYAR_VENDOR_KEDUA: $('#SISTEM_BAYAR_VENDOR_KEDUA2').val(),
                HARGA_TOTAL_VENDOR_KEDUA: $('#HARGA_TOTAL_VENDOR_KEDUA2').val(),

                ID_VENDOR_KETIGA: $('#ID_VENDOR_KETIGA2').val(),
                NAMA_VENDOR_KETIGA: $('#NAMA_VENDOR_KETIGA2').val(),
                HARGA_SATUAN_BARANG_VENDOR_KETIGA: $('#HARGA_SATUAN_BARANG_VENDOR_KETIGA2').val(),
                DELIVERY_VENDOR_KETIGA: $('#DELIVERY_VENDOR_KETIGA2').val(),
                SISTEM_BAYAR_VENDOR_KETIGA: $('#SISTEM_BAYAR_VENDOR_KETIGA2').val(),
                HARGA_TOTAL_VENDOR_KETIGA: $('#HARGA_TOTAL_VENDOR_KETIGA2').val(),
            };
            $.ajax({
                url: "<?php echo site_url('KHP_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: form_data,
                success: function (data) {
                    if (data == true) {
                        $('#ModalPengajuanVendor').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //UPDATE DATA PENETAPAN VENDOR
        $('#btn_penetapan_vendor').on('click', function () {

            var form_data = {

                ID_KHP_FORM: $('#ID_KHP_FORM3').val(),
                ID_KHP: $('#ID_KHP3').val(),
                ID_VENDOR_FIX: $('#ID_VENDOR_FIX3').val(),

            };
            $.ajax({
                url: "<?php echo site_url('KHP_form/update_data_penetapan_vendor') ?>",
                type: "POST",
                dataType: "JSON",
                data: form_data,
                success: function (data) {
                    if (data == true) {
                        $('#ModalPenetapanVendor').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-3').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //HAPUS DATA
        $('#btn_hapus').on('click', function () {
            var ID_KHP_FORM = $('#ID_KHP_FORM').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('KHP_form/hapus_data') ?>",
                dataType: "JSON",
                data: {
                    ID_KHP_FORM: ID_KHP_FORM
                },
                success: function (data) {
                    $('#ModalHapus').modal('hide');
                    window.location.reload();
                }
            });
            return false;
        });

        $('#saya_setuju').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_ubah_harga').removeAttr('disabled'); //enable input

            } else {
                $('#btn_ubah_harga').attr('disabled', true); //disable input
            }
        });

        $('#saya_setuju_kirim').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_khp').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_khp').attr('disabled', true); //disable input
            }
        });

        $('#saya_setuju_hapus').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_hapus').removeAttr('disabled'); //enable input

            } else {
                $('#btn_hapus').attr('disabled', true); //disable input
            }
        });

        $("#checkAllItemSPPB").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        item_edit_kirim_khp.onclick = function() {
            var ID_KHP = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('KHP_form/data_khp_form') ?>",
                dataType: "JSON",
                data: {
                    ID_KHP: ID_KHP
                },
                success: function(data) {

                    $('#ModalEditKirimKHP').modal('show');
                    $('[name="ID_KHP7"]').val(data[0].ID_KHP);

                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.length < 1) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#show_hidden_setuju').attr("hidden", true);
                        $('#show_hidden_tidak_ada_item_barang').attr("hidden", false);
                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        let i = 0;
                        for (i = 0; i < data.length; i++) {

                            // CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                            if (data[i].ID_VENDOR_PERTAMA == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_vendor_pertama').attr("hidden", false);
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

        //UPDATE KIRIM SPPB 
        $('#btn_update_kirim_khp').on('click', function () {

            let ID_KHP = $('#ID_KHP7').val();
            $.ajax({
                url: "<?php echo site_url('KHP_form/update_data_kirim_khp') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_KHP: ID_KHP,
                },
                success: function (data) {
                    if (data == true) {
                        $('#ModalEditKirimKHP').modal('hide');
                        window.location.href = '<?php echo site_url('KHP') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //TAMBAH DARI SPPB
        tambah_item_sppb.onclick = function() {

            $('#ModalAddDariSPPB').modal('show');

            $("#mydata_SPPB").dataTable().fnDestroy();

            $('#ibox2').children('.ibox-content').toggleClass('sk-loading');

            setTimeout(function(){
                //fungsi tampil data
                var data = <?php echo json_encode($sppb_barang_list); ?>;
                var html = '';

                for (l = 0; l < data.length; l++) {

                    html += '<tr>' +
                    
                    '<td>' + 
                    '<input name="ID_KHP" class="form-control" type="text" value="'+ ID_KHP +'" style="display: none;" readonly>' +
                    '<input class="checkbox" name="ID_SPPB_FORM[]" value="'+ data[l].ID_SPPB_FORM +'" type="checkbox">' +
                    '</td>' +
                    '<td>' + data[l].NAMA_BARANG + '</td>' +
                    '<td>' + data[l].MEREK + '</td>' +
                    '<td>' + data[l].SPESIFIKASI_SINGKAT + '</td>' +
                    '<td>' + 'RAB: ' + data[l].NAMA_KATEGORI + '</br> Klasifikasi:' + data[l].NAMA_KLASIFIKASI_BARANG + '</td>' +
                    '<td>' + data[l].JUMLAH_QTY_SPP + ' ' + data[l].SATUAN_BARANG + '</td>' +
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
                            title: 'KHP export EXCEL',
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
            var ID_KHP = $(this).attr('data');
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('KHP/get_data') ?>",
                dataType: "JSON",
                data: {
                    ID_KHP: ID_KHP
                },
                success: function(data) {
                   
                    //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                    if (data.ID_VENDOR_PERTAMA == 0) { //JIKA BELUM ADA BARANG YANG DI ADD
                        $('#ModalEditExcelMaaf').modal('show');
                    } else { //JIKA SUDAH ADA BARANG YANG DI ADD

                        $.ajax({
                            type: "POST",
                            url: "<?php echo base_url('KHP_form/data_khp_form') ?>",
                            dataType: "JSON",
                            data: {
                                ID_KHP: ID_KHP
                            },
                            success: function(data) {

                                //CEK APAKAH SUDAH ADA ITEM BARANG ATAU BELUM
                                let i = 0;
                                // CEK APAKAH MASIH ADA JUMLAH MINTA YANG NOL
                                if (data.length < 1)
                                {
                                    $('#ModalEditExcelMaaf').modal('show');
                                }
                                else{
                                    for (i = 0; i < data.length; i++) {

                                        //JIKA SEMUA ITEM BARANG ADA JUMLAH MINTANYA (TIDAK NOL)
                                        if (i == (data.length - 1)) {
                                            $('#ModalEditExcel').modal('show');
                                        }
                                    }
                                }

                                
                            }
                        });

                    }
                }
            });
            return false;
        };

        //HAPUS DATA SEMUA
        hapus_semua_item.onclick = function() {
            var HASH_MD5_KHP = $(this).attr('data');
            $('#ModalHapusSemua').modal('show');
            $('[name="HASH_MD5_KHP_3"]').val(HASH_MD5_KHP);
            $('#NAMA_5').html('</br>KHP kode : ' + HASH_MD5_KHP);
        };

        //HAPUS DATA SEMUA
        $('#btn_hapus_semua').on('click', function () {
            var HASH_MD5_KHP = $('#HASH_MD5_KHP_3').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('KHP_form/hapus_data_semua') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_KHP: HASH_MD5_KHP
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

    });
</script>

</body>

</html>