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
        <h2>Form PO</h2>
        <ol class="breadcrumb">
            <li>
                <a href="<?php echo base_url('index.php') ?>">Home</a>
            </li>
            <li>
                <a href="<?php echo base_url('index.php/PO/') ?>">PO</a>
            </li>
            <li class="active">
                <strong>
                    <a>Form PO</a>
                </strong>
            </li>
        </ol>
    </div>
</div>

<!-- Form PO -->
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        Pastikan Anda mengisi data dengan benar.
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Formulir Pengajuan PO</h5>
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

                            <li class="" style="display:none;"><a data-toggle="tab" href="#tab-2">Catatan PO</a></li>

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
                                            foreach ($PO->result() as $PO) :
                                        ?>
                                                <div class="form-group"><label class="col-sm-2 control-label">No. Urut PO</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="NO_URUT_PO_GANTI" id="NO_URUT_PO_GANTI" class="form-control" value="<?php echo $PO->NO_URUT_PO; ?>">
                                                        <input name="NO_URUT_PO_ASLI" id="NO_URUT_PO_ASLI" type="hidden" class="form-control" value="<?php echo $PO->NO_URUT_PO; ?>">
                                                    </div>
                                                </div>

                                                <div class="form-group" id="data_TANGGAL_DOKUMEN_PO"><label class="col-sm-2 control-label">Tanggal Dokumen PO</label>
                                                    <div class="col-sm-10">
                                                        <?php
                                                        if (empty($PO->TANGGAL_DOKUMEN_PO)) {
                                                        ?>
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_PO" name="TANGGAL_DOKUMEN_PO" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                                            </div>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_DOKUMEN_PO" name="TANGGAL_DOKUMEN_PO" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $PO->TANGGAL_DOKUMEN_PO; ?>">
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>

                                                <div class="form-group"><label class="col-sm-2 control-label">Tanggal PO By System</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo tanggal_indo_full($PO->TANGGAL_PEMBUATAN_PO_HARI, false); ?>" disabled></div>
                                                </div>
                                                <div class="form-group"><label class="col-sm-2 control-label">Jenis Pengadaan</label>
                                                    <div class="col-sm-10"><input type="text" class="form-control" value="<?php echo $PO->JENIS_PENGADAAN; ?>" disabled></div>
                                                </div>
                                        <?php endforeach;
                                        } ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Pembelian")) {
                                        ?>
                                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi Penyerahan</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($LOKASI_PENYERAHAN)) {
                                                ?>
                                                    <select class="form-control" name="LOKASI_PENYERAHAN" id="LOKASI_PENYERAHAN">
                                                        <option value=''>- Pilih Lokasi Penyerahan -</option>
                                                        <?php foreach ($LOKASI_PENYERAHAN_LIST as $prov) {
                                                            echo '<option value="' . $prov->NAMA_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- LOKASI LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="LOKASI_PENYERAHAN" id="LOKASI_PENYERAHAN">
                                                        <option value=''>- Pilih Lokasi Penyerahan -</option>
                                                        <?php foreach ($LOKASI_PENYERAHAN_LIST as $prov) {
                                                            if ($prov->NAMA_LOKASI_PENYERAHAN == $LOKASI_PENYERAHAN) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . ' </option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $LOKASI_PENYERAHAN; ?>"><?php echo $LOKASI_PENYERAHAN; ?></option>
                                                        <option value='99999'>- LOKASI LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>
                                                    <div id="show_hidden_lokasi" hidden>
                                                        <input type="text" name="LOKASI_PENYERAHAN_TEKS" id="LOKASI_PENYERAHAN_TEKS" class="form-control" placeholder="Contoh: Gudang Site PT. WME Jalan Raya XXX">
                                                    </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Rental")) {
                                        ?>
                                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi Penyerahan</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($LOKASI_PENYERAHAN)) {
                                                ?>
                                                    <select class="form-control" name="LOKASI_PENYERAHAN" id="LOKASI_PENYERAHAN">
                                                        <option value=''>- Pilih Lokasi Penyerahan -</option>
                                                        <?php foreach ($LOKASI_PENYERAHAN_LIST as $prov) {
                                                            echo '<option value="' . $prov->NAMA_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- LOKASI LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="LOKASI_PENYERAHAN" id="LOKASI_PENYERAHAN">
                                                        <option value=''>- Pilih Lokasi Penyerahan -</option>
                                                        <?php foreach ($LOKASI_PENYERAHAN_LIST as $prov) {
                                                            if ($prov->NAMA_LOKASI_PENYERAHAN == $LOKASI_PENYERAHAN) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . ' </option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $LOKASI_PENYERAHAN; ?>"><?php echo $LOKASI_PENYERAHAN; ?></option>
                                                        <option value='99999'>- LOKASI LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>
                                                    <div id="show_hidden_lokasi" hidden>
                                                        <input type="text" name="LOKASI_PENYERAHAN_TEKS" id="LOKASI_PENYERAHAN_TEKS" class="form-control" placeholder="Contoh: Gudang Site PT. WME Jalan Raya XXX">
                                                    </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Jasa")) {
                                        ?>
                                        <div class="form-group"><label class="col-sm-2 control-label">Lokasi Pekerjaan</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($LOKASI_PENYERAHAN)) {
                                                ?>
                                                    <select class="form-control" name="LOKASI_PENYERAHAN" id="LOKASI_PENYERAHAN">
                                                        <option value=''>- Pilih Lokasi Pekerjaan -</option>
                                                        <?php foreach ($LOKASI_PENYERAHAN_LIST as $prov) {
                                                            echo '<option value="' . $prov->NAMA_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- LOKASI LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="LOKASI_PENYERAHAN" id="LOKASI_PENYERAHAN">
                                                        <option value=''>- Pilih Lokasi Pekerjaan -</option>
                                                        <?php foreach ($LOKASI_PENYERAHAN_LIST as $prov) {
                                                            if ($prov->NAMA_LOKASI_PENYERAHAN == $LOKASI_PENYERAHAN) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_LOKASI_PENYERAHAN . '">' . $prov->NAMA_LOKASI_PENYERAHAN . ' </option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $LOKASI_PENYERAHAN; ?>"><?php echo $LOKASI_PENYERAHAN; ?></option>
                                                        <option value='99999'>- LOKASI LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>
                                                    <div id="show_hidden_lokasi" hidden>
                                                        <input type="text" name="LOKASI_PENYERAHAN_TEKS" id="LOKASI_PENYERAHAN_TEKS" class="form-control" placeholder="Contoh: Gudang Site PT. WME Jalan Raya XXX">
                                                    </div>
                                            </div>
                                        </div>
                                        <?php
                                        }
                                        ?>

                                        <div class="form-group"><label class="col-sm-2 control-label">Vendor</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="NAMA_VENDOR" id="NAMA_VENDOR" class="form-control" value="<?php echo $NAMA_VENDOR; ?>" placeholder="Contoh: PT. Pertamina Persero" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Term of Payment</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($TERM_OF_PAYMENT)) {
                                                ?>
                                                    <select class="form-control" name="TERM_OF_PAYMENT" id="TERM_OF_PAYMENT">
                                                        <option value=''>- Pilih TOP -</option>
                                                        <?php foreach ($term_of_payment as $prov) {
                                                            echo '<option value="' . $prov->NAMA_TERM_OF_PAYMENT . '">' . $prov->NAMA_TERM_OF_PAYMENT . '</option>';
                                                        } ?>
                                                        <option value='99999'>- TERM OF PAYMENT LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="TERM_OF_PAYMENT" id="TERM_OF_PAYMENT">
                                                        <option value=''>- Pilih TOP -</option>
                                                        <?php foreach ($term_of_payment as $prov) {
                                                            if ($prov->NAMA_TERM_OF_PAYMENT == $TERM_OF_PAYMENT) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_TERM_OF_PAYMENT . '">' . $prov->NAMA_TERM_OF_PAYMENT . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_TERM_OF_PAYMENT . '">' . $prov->NAMA_TERM_OF_PAYMENT . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $TERM_OF_PAYMENT; ?>"><?php echo $TERM_OF_PAYMENT; ?></option>
                                                        <option value='99999'>- TERM OF PAYMENT LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>
                                                    <div id="show_hidden_top" hidden>
                                                        <input type="text" name="TERM_OF_PAYMENT_TEKS" id="TERM_OF_PAYMENT_TEKS" class="form-control" placeholder="Contoh: 90 (SEMBILAN PULUH) HARI SETELAH INVOICE DITERIMA LENGKAP DAN BENAR">
                                                    </div>
                                            </div>
                                        </div>


                                        <div class="form-group" id="data_BATAS_AKHIR" hidden><label class="col-sm-2 control-label">Batas Akhir Konfirmasi PO</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($BATAS_AKHIR)) {
                                                ?>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="BATAS_AKHIR" name="BATAS_AKHIR" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="input-group date">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="BATAS_AKHIR" name="BATAS_AKHIR" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $BATAS_AKHIR; ?>">
                                                    </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group"><label class="col-sm-2 control-label">Keperluan</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($CTT_KEPERLUAN)) {
                                                ?>
                                                    <input type="text" name="CTT_KEPERLUAN" id="CTT_KEPERLUAN" class="form-control" placeholder="Contoh: Keperluan Mengenai PO (Baris Pertama)">
                                                    
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="CTT_KEPERLUAN" id="CTT_KEPERLUAN" class="form-control" placeholder="Contoh: Keperluan Mengenai PO (Baris Pertama)" value="<?php echo $CTT_KEPERLUAN; ?>">
                                                <?php
                                                }
                                                ?>

                                                <?php
                                                if (empty($CTT_KEPERLUAN_BARIS_2)) {
                                                ?>
                                                    <input type="text" name="CTT_KEPERLUAN_BARIS_2" id="CTT_KEPERLUAN_BARIS_2" class="form-control" placeholder="Contoh: Keperluan Mengenai PO (Baris Kedua)">
                                                    
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="CTT_KEPERLUAN_BARIS_2" id="CTT_KEPERLUAN_BARIS_2" class="form-control" placeholder="Contoh: Keperluan Mengenai PO (Baris Kedua)" value="<?php echo $CTT_KEPERLUAN_BARIS_2; ?>">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Kondisi Pengadaan :</label>
                                        </div>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Pembelian")) {
                                        ?>
                                            <div class="form-group" id="data_TANGGAL_KIRIM_BARANG_HARI"><label class="col-sm-2 control-label">1. Tanggal Kirim</label>
                                                <div class="col-sm-10">
                                                    <?php
                                                    if (empty($TANGGAL_KIRIM_BARANG_HARI)) {
                                                    ?>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_KIRIM_BARANG_HARI" name="TANGGAL_KIRIM_BARANG_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="input-group date">
                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_KIRIM_BARANG_HARI" name="TANGGAL_KIRIM_BARANG_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $TANGGAL_KIRIM_BARANG_HARI; ?>">
                                                        </div>
                                                    <?php
                                                    }
                                                    ?>
                                                    <input type="hidden" name="KONDISI_PENGADAAN_BARIS_1" id="KONDISI_PENGADAAN_BARIS_1" class="form-control" value="TANGGAL KIRIM : ">

                                                    <div class="row" hidden>
                                                        <div class="col-md-4">
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_MULAI_PAKAI_HARI" name="TANGGAL_MULAI_PAKAI_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $TANGGAL_MULAI_PAKAI_HARI; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"><input type="text" placeholder="s.d" class="form-control" disabled></div>
                                                        <div class="col-md-4">
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_SELESAI_PAKAI_HARI" name="TANGGAL_SELESAI_PAKAI_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $TANGGAL_SELESAI_PAKAI_HARI; ?>">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Jasa")) {
                                        ?>
                                            <div class="form-group" id="data_DURASI"><label class="col-sm-2 control-label">1. Tanggal Pekerjaan</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_MULAI_PAKAI_HARI" name="TANGGAL_MULAI_PAKAI_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $TANGGAL_MULAI_PAKAI_HARI; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1">s/d</div>
                                                        <div class="col-md-4">
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_SELESAI_PAKAI_HARI" name="TANGGAL_SELESAI_PAKAI_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $TANGGAL_SELESAI_PAKAI_HARI; ?>">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="KONDISI_PENGADAAN_BARIS_1" id="KONDISI_PENGADAAN_BARIS_1" class="form-control" value="TANGGAL PEKERJAAN : ">

                                                        <div hidden>
                                                            <div class="input-group date" hidden>
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_KIRIM_BARANG_HARI" name="TANGGAL_KIRIM_BARANG_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Rental")) {
                                        ?>
                                            <div class="form-group" id="data_DURASI"><label class="col-sm-2 control-label">1. Durasi Sewa</label>
                                                <div class="col-sm-10">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_MULAI_PAKAI_HARI" name="TANGGAL_MULAI_PAKAI_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $TANGGAL_MULAI_PAKAI_HARI; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1"> s/d </div>
                                                        <div class="col-md-4">
                                                            <div class="input-group date">
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_SELESAI_PAKAI_HARI" name="TANGGAL_SELESAI_PAKAI_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy" value="<?php echo $TANGGAL_SELESAI_PAKAI_HARI; ?>">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" name="KONDISI_PENGADAAN_BARIS_1" id="KONDISI_PENGADAAN_BARIS_1" class="form-control" value="TANGGAL DURASI SEWA : ">
                                                        <div hidden>
                                                            <div class="input-group date" hidden>
                                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="TANGGAL_KIRIM_BARANG_HARI" name="TANGGAL_KIRIM_BARANG_HARI" type="text" class="form-control" placeholder="dd/mm/yyyy">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <div class="form-group"><label class="col-sm-2 control-label">2. Referensi Dokumen Quotation/SPH</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($REFERENSI_DOKUMEN_SPH)) {
                                                ?>
                                                    <input type="text" name="REFERENSI_DOKUMEN_SPH" id="REFERENSI_DOKUMEN_SPH" class="form-control" placeholder="Contoh: No. 013-QUOT-XXX-2023 tanggal 12 Juli 2023">
                                                    
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="REFERENSI_DOKUMEN_SPH" id="REFERENSI_DOKUMEN_SPH" class="form-control" placeholder="Contoh: No. 013-QUOT-XXX-2023 tanggal 12 Juli 2023" value="<?php echo $REFERENSI_DOKUMEN_SPH; ?>">
                                                <?php
                                                }
                                                ?>
                                                <input type="hidden" name="KONDISI_PENGADAAN_BARIS_2" id="KONDISI_PENGADAAN_BARIS_2" class="form-control" value="REFERENSI DOKUMEN QUOTATION/SPH : ">
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">3. Referensi Dokumen Kontrak</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($REFERENSI_DOKUMEN_KONTRAK)) {
                                                ?>
                                                    <input type="text" name="REFERENSI_DOKUMEN_KONTRAK" id="REFERENSI_DOKUMEN_KONTRAK" class="form-control" placeholder="Contoh: 098/PKS/XXX/2023 tanggal 12 Juli 2023">
                                                    
                                                <?php
                                                } else {
                                                ?>
                                                    <input type="text" name="REFERENSI_DOKUMEN_KONTRAK" id="REFERENSI_DOKUMEN_KONTRAK" class="form-control" placeholder="Contoh: 098/PKS/XXX/2023 tanggal 12 Juli 2023" value="<?php echo $REFERENSI_DOKUMEN_KONTRAK; ?>">
                                                <?php
                                                }
                                                ?>
                                                <input type="hidden" name="KONDISI_PENGADAAN_BARIS_3" id="KONDISI_PENGADAAN_BARIS_3" class="form-control" value="REFERENSI DOKUMEN KONTRAK : ">
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">4. Kondisi</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="KONDISI_PENGADAAN_BARIS_4" id="KONDISI_PENGADAAN_BARIS_4" class="form-control" value="PROSES PENGIRIMAN BARANG/PELAKSANAAN PEKERJAAN WAJIB MENGIKUTI ATURAN KESELAMATAN (K3)" disabled>
                                            </div>
                                        </div>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Pembelian")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">5. Kondisi</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="KONDISI_PENGADAAN_BARIS_5" id="KONDISI_PENGADAAN_BARIS_5" class="form-control" value="PEMBELI DIBEBASKAN DARI SEMUA TUNTUTAN PIHAK LAIN ATAS BARANG TERSEBUT DI ATAS" disabled>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Rental")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">5. Kondisi</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="KONDISI_PENGADAAN_BARIS_5" id="KONDISI_PENGADAAN_BARIS_5" class="form-control" value="PENYEWA DIBEBASKAN DARI SEMUA TUNTUTAN PIHAK LAIN ATAS BARANG TERSEBUT DI ATAS" disabled>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Jasa")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">5. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_5)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_5" id="KONDISI_PENGADAAN_BARIS_5">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_5" id="KONDISI_PENGADAAN_BARIS_5">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_5) {
                                                                echo '<option selected="selected" value="' . $prov->KONDISI_PENGADAAN_BARIS_5 . '">' . $prov->KONDISI_PENGADAAN_BARIS_5 . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_5; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_5; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_1" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_5_TEKS" id="KONDISI_PENGADAAN_BARIS_5_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Pembelian")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">6. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_6)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_6" id="KONDISI_PENGADAAN_BARIS_6">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_6" id="KONDISI_PENGADAAN_BARIS_6">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_6) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_6; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_6; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_2" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_6_TEKS" id="KONDISI_PENGADAAN_BARIS_6_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Rental")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">6. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_6)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_6" id="KONDISI_PENGADAAN_BARIS_6">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_6" id="KONDISI_PENGADAAN_BARIS_6">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_6) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_6; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_6; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_2" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_6_TEKS" id="KONDISI_PENGADAAN_BARIS_6_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Jasa")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">6. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_6)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_6" id="KONDISI_PENGADAAN_BARIS_6">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_6" id="KONDISI_PENGADAAN_BARIS_6">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_6) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_6; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_6; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_2" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_6_TEKS" id="KONDISI_PENGADAAN_BARIS_6_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Pembelian")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">7. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_7)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_7" id="KONDISI_PENGADAAN_BARIS_7">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_7" id="KONDISI_PENGADAAN_BARIS_7">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_7) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_7; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_7; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_3" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_7_TEKS" id="KONDISI_PENGADAAN_BARIS_7_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Rental")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">7. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_7)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_7" id="KONDISI_PENGADAAN_BARIS_7">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_7" id="KONDISI_PENGADAAN_BARIS_7">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_7) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_7; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_7; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_3" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_7_TEKS" id="KONDISI_PENGADAAN_BARIS_7_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Jasa")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">7. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_7)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_7" id="KONDISI_PENGADAAN_BARIS_7">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_7" id="KONDISI_PENGADAAN_BARIS_7">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_7) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_7; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_7; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_3" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_7_TEKS" id="KONDISI_PENGADAAN_BARIS_7_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Pembelian")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">8. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_8)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_8" id="KONDISI_PENGADAAN_BARIS_8">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_8" id="KONDISI_PENGADAAN_BARIS_8">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_8) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_8; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_8; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_4" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_8_TEKS" id="KONDISI_PENGADAAN_BARIS_8_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Rental")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">8. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_8)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_8" id="KONDISI_PENGADAAN_BARIS_8">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_8" id="KONDISI_PENGADAAN_BARIS_8">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_8) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_8; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_8; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_4" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_8_TEKS" id="KONDISI_PENGADAAN_BARIS_8_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Jasa")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">8. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_8)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_8" id="KONDISI_PENGADAAN_BARIS_8">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_8" id="KONDISI_PENGADAAN_BARIS_8">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_8) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_8; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_8; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_4" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_8_TEKS" id="KONDISI_PENGADAAN_BARIS_8_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <!-- baris 9 -->
                                        <?php
                                        if (($JENIS_PENGADAAN == "Pembelian")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">9. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_9)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_9" id="KONDISI_PENGADAAN_BARIS_9">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_9" id="KONDISI_PENGADAAN_BARIS_9">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_9) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_9; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_9; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_5" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_9_TEKS" id="KONDISI_PENGADAAN_BARIS_9_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Rental")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">9. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_9)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_9" id="KONDISI_PENGADAAN_BARIS_9">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_9" id="KONDISI_PENGADAAN_BARIS_9">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_9) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_9; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_9; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_5" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_9_TEKS" id="KONDISI_PENGADAAN_BARIS_9_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Jasa")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">9. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_9)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_9" id="KONDISI_PENGADAAN_BARIS_9">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_9" id="KONDISI_PENGADAAN_BARIS_9">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_9) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_9; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_9; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_5" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_9_TEKS" id="KONDISI_PENGADAAN_BARIS_9_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <!-- baris 10 -->
                                        <?php
                                        if (($JENIS_PENGADAAN == "Pembelian")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">10. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_10)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_10" id="KONDISI_PENGADAAN_BARIS_10">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_10" id="KONDISI_PENGADAAN_BARIS_10">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_10) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_10; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_10; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_6" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_10_TEKS" id="KONDISI_PENGADAAN_BARIS_10_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Rental")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">10. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_10)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_10" id="KONDISI_PENGADAAN_BARIS_10">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_10" id="KONDISI_PENGADAAN_BARIS_10">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_10) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_10; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_10; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_6" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_10_TEKS" id="KONDISI_PENGADAAN_BARIS_10_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        <?php
                                        if (($JENIS_PENGADAAN == "Jasa")) {
                                        ?>
                                            <div class="form-group"><label class="col-sm-2 control-label">10. Kondisi</label>
                                                <div class="col-sm-10">
                                                <?php
                                                if (empty($KONDISI_PENGADAAN_BARIS_10)) {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_10" id="KONDISI_PENGADAAN_BARIS_10">
                                                        <option value=''>- Pilih Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                        } ?>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="KONDISI_PENGADAAN_BARIS_10" id="KONDISI_PENGADAAN_BARIS_10">
                                                        <option value=''>- Pilihan Kondisi Opsional -</option>
                                                        <?php foreach ($kondisi_pengadaan as $prov) {
                                                            if ($prov->NAMA_KONDISI_PENGADAAN == $KONDISI_PENGADAAN_BARIS_10) {
                                                                echo '<option selected="selected" value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . ' </option>';
                                                            } else {
                                                                echo '<option value="' . $prov->NAMA_KONDISI_PENGADAAN . '">' . $prov->NAMA_KONDISI_PENGADAAN . '</option>';
                                                            }
                                                        } ?>
                                                        <option selected="selected" value="<?php echo $KONDISI_PENGADAAN_BARIS_10; ?>"><?php echo $KONDISI_PENGADAAN_BARIS_10; ?></option>
                                                        <option value='99999'>- KONDISI PENGADAAN LAINNYA -</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>

                                                    <div id="show_hidden_kondisi_pengadaan_6" hidden>
                                                        <input type="text" name="KONDISI_PENGADAAN_BARIS_10_TEKS" id="KONDISI_PENGADAAN_BARIS_10_TEKS" class="form-control" placeholder="Contoh: BARANG DIKIRIM DALAM KONDISI BAIK">
                                                    </div>

                                                </div>

                                            </div>
                                        <?php
                                        }
                                        ?>

                                        </br>
                                        <div class="form-group"><label class="col-sm-2 control-label">Baris Kosong</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($BARIS_KOSONG)) {
                                                ?>
                                                    <input name="BARIS_KOSONG" id="BARIS_KOSONG" class="form-control touchspin1" type="number">
                                                    
                                                <?php
                                                } else {
                                                ?>
                                                    <input name="BARIS_KOSONG" id="BARIS_KOSONG" class="form-control touchspin1" type="number" value="<?php echo $BARIS_KOSONG; ?>">
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group"><label class="col-sm-2 control-label">Tanda Tangan</label>
                                            <div class="col-sm-10">
                                                <?php
                                                if (empty($TANDA_TANGAN_1)) {
                                                ?>
                                                    <select class="form-control" name="TANDA_TANGAN" id="TANDA_TANGAN">
                                                        <option selected="selected" value='Mjr. Pengadaan'>Mjr. Pengadaan dan Bag. Pembelian</option>
                                                        <option value='Mjr. Site'>Mjr. Site dan Bag. Pembelian</option>
                                                        <option value='Direktur'>Direktur dan Mjr. Pengadaan</option>
                                                        <option value='Direktur Utama'>Direktur Utama dan Direktur</option>
                                                    </select>
                                                <?php
                                                } else {
                                                ?>
                                                    <select class="form-control" name="TANDA_TANGAN" id="TANDA_TANGAN">
                                                        <option selected="selected" value="<?php echo $TANDA_TANGAN_1; ?>"><?php echo $TANDA_TANGAN_1; ?> dan <?php echo $TANDA_TANGAN_2; ?></option>
                                                        <option value='Mjr. Pengadaan'>Mjr. Pengadaan dan Bag. Pembelian</option>
                                                        <option value='Mjr. Site'>Mjr. Site dan Bag. Pembelian</option>
                                                        <option value='Direktur'>Direktur dan Mjr. Pengadaan</option>
                                                        <option value='Direktur Utama'>Direktur Utama dan Direktur</option>
                                                    </select>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>


                                
                                        <input style="width:100%" name="HASH_MD5_PO" id="HASH_MD5_PO" type="hidden" value="<?php echo $HASH_MD5_PO; ?>">
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
                                            <?php echo $CATATAN_PO['CTT_STAFF_PROC_SP']; ?>
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
                                            <?php echo $CATATAN_PO['CTT_SUPERVISI_PROC_SP']; ?>
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
                                            <?php echo $CATATAN_PO['CTT_STAFF_PROC']; ?>
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
                                            <?php echo $CATATAN_PO['CTT_KASIE']; ?>
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
                                            <?php echo $CATATAN_PO['CTT_MANAGER_PROC']; ?>
                                        </div>
                                    </div>
                                    </br>
                                    <div class="hr-line-dashed"></div>
                                    <a href="javascript:;" id="item_edit_catatan_po" name="item_edit_catatan_po" class="btn btn-primary" data="<?php echo $HASH_MD5_PO; ?>"><i class="fa fa-comment"></i> Berikan Catatan PO </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>PO Item Barang/Jasa</h5>
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
                            
                            <a href="javascript:;" id="tambah_item_spp" name="tambah_item_spp" class="btn btn-primary"><span class="fa fa-plus"></span> Tambah Item dari SPP</a>
                            <br>
                            <br>
                            <br>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="mydata">
                                    <thead>
                                        <tr>
                                            <th>Nama Barang/Jasa</th>
                                            <th>Merek Barang/Jasa</th>
                                            <th>Spesifikasi Singkat</th>
                                            <th>Klasifikasi Barang</th>
                                            <th>Satuan Barang</th>                                        
                                            <th>Jumlah Yang Diadakan</th>
                                            <th>Harga Satuan Barang</th>
                                            <th>Harga Total Barang</th>
                                            <th>Pajak</th>
                                            <th>Keterangan</th>
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
                            <div class="form-horizontal">

                                <div class="form-group"><label class="control-label col-xs-1">Diskon</label>
                                    <div class="col-xs-3">
                                        <select class="form-control" name=DISKON3" id="DISKON3">
                                            <option value='TIDAK'>Tidak Ada Diskon</option>
                                            <option value='ADA'>Terdapat Diskon</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="show_hidden_diskon" class="form-group" hidden><label class="control-label col-xs-1">Input Nominal Diskon</label>
                                    <div class="col-xs-3">
                                        <input type="text" name="NOMINAL_DISKON3" id="NOMINAL_DISKON3" class="form-control" value="<?php echo $NOMINAL_DISKON; ?>">
                                    </div>
                                </div>

                                <div class="form-group"><label class="control-label col-xs-1">Nominal Diskon</label>
                                    <div class="col-xs-3">
                                        <input type="text" name="TAMPIL_NOMINAL_DISKON3" id="TAMPIL_NOMINAL_DISKON3" class="form-control" disabled>
                                    </div>
                                </div>

                                <div class="form-group"><label class="control-label col-xs-1">Pajak</label>
                                    <div class="col-xs-3">
                                        <?php
                                        if (empty($ID_PAJAK)) {
                                        ?>
                                            <select class="form-control" name="TARIF_PAJAK3" id="TARIF_PAJAK3">
                                                <!-- <option value=''>- Pilih Jenis Pajak  -</option> -->
                                                <?php foreach ($pajak_list as $item) {
                                                    echo '<option value="' . $item->ID_PAJAK . '">' . $item->KETERANGAN . '</option>';
                                                } ?>
                                            </select>
                                        <?php
                                        } else {
                                        ?>
                                            <select class="form-control" name="TARIF_PAJAK3" id="TARIF_PAJAK3">
                                                <!-- <option value=''>- Pilih -</option> -->
                                                <?php foreach ($pajak_list as $item) {
                                                    if ($item->ID_PAJAK == $ID_PAJAK) {
                                                        echo '<option selected="selected" value="' . $item->ID_PAJAK . '">' . $item->KETERANGAN . ' </option>';
                                                    } else {
                                                        echo '<option value="' . $item->ID_PAJAK . '">' . $item->KETERANGAN . '</option>';
                                                    }
                                                } ?>
                                            </select>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <button class="btn btn-primary" id="btn_simpan_pajak"><i class="fa fa-save"></i> Hitung Ulang Pajak dan Diskon Untuk Semua Item Barang/Jasa</button>


                                <div class="hr-line-dashed"></div>

                                <div class="alert alert-warning alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    Perubahan data pada form PO tidak akan mempengaruhi data pada form SPP.
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="ibox float-e-margins">
                        <div class="ibox-content">
                            <div class="form-group">
                                <div class="sm-10">
                                    <button class="btn btn-primary" id="btn_simpan_perubahan_pdf"><i class="fa fa-save"></i> Simpan Perubahan & View Dokumen PO</button>
                                    </br>
                                    <a href="javascript:;" id="item_edit_kirim_po" name="item_edit_kirim_po" class="btn btn-success" data="<?php echo $ID_PO; ?>"><span class="fa fa-send"></span> Ajukan PO Untuk Proses Selanjutnya </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Form PO -->


<!-- MODAL ADD  DARI SPP -->
<div class="modal inmodal fade" id="ModalAddDariSPP" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <?php
            if ($spp_barang_list != NULL) {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Daftar Item Barang/Jasa dari SPP</h4>
                    <small class="font-bold">Silakan isi data PO berdasarkan daftar SPP</small>
                </div>

                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="table-responsive">

                        <?php
                        foreach ($spp_barang_list as $data): ?>
                        Sumber SPPB: <a href="<?php echo base_url() ?>SPPB_form/view/<?php echo $SPPB->HASH_MD5_SPPB; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $SPPB->NO_URUT_SPPB; ?> </a>
                        </br>
                        </br>
                        Sumber SPP: <a href="<?php echo base_url() ?>SPP_form/view/<?php echo $SPP->HASH_MD5_SPP; ?>" class="btn btn-primary btn-outline" target="_blank"><i class="fa fa-eye"></i> <?php echo $SPP->NO_URUT_SPP; ?> </a>
                        <?php break;?>
                        <?php endforeach;
                        ?>

                        </br>
                        </br>

                            <form method="POST" action="<?php echo site_url('PO_form/simpan_data_dari_spp_form'); ?>" id="formTambahSPP">
                                <table class="table table-striped table-bordered table-hover" id="mydata_SPP">
                                    <thead>
                                        <tr>
                                            <th>Pilih<input type="checkbox" id="checkAllspp"></th>
                                            <th>Nama Barang/Jasa</th>
                                            <th>Merek Barang/Jasa</th>
                                            <th style="width: 30%;">Spesifikasi Singkat</th>
                                            <th>Klasifikasi Barang</th>
                                            <th>Qty SPP</th>
                                            <th>Qty Realisasi PO</th>
                                            <th>Qty pada PO ini</th>
                                            <th>Vendor</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_data_SPP">                                        
                                    </tbody>
                                </table>

                            </form>
                        </div>
                        <div id="alert-msg-add-dari-po"></div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                        <button class="btn btn-primary" type="submit" form="formTambahSPP"><i class="fa fa-save"></i> Simpan</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            <?php
            } else {
            ?>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-exclamation-triangle modal-icon"></i>
                    <h4 class="modal-title">Daftar Item Barang/Jasa dari SPP</h4>
                    <b class="font-bold">Maaf semua item barang/jasa dari SPP sudah ada di Form PO ini atau seluruh item sudah diproses di Form PO yang lain</b>
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
<!--END MODAL ADD DARI SPP -->


<!-- MODAL EDIT -->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Ubah Item Barang/Jasa PO</h4>
                <small class="font-bold">Silakan edit item barang/jasa PO</small>
            </div>
            <?php $attributes = array("ID_PO_FORM_2" => "contact_form", "id" => "contact_form");
            echo form_open("PO_form/update_data", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_SPP_FORM_2" id="ID_SPP_FORM_2" class="form-control" type="hidden" readonly>
                    <input name="ID_PO_FORM_2" id="ID_PO_FORM_2" class="form-control" type="hidden" readonly>

                    <div class="form-group row">
                        <label class="col-xs-2 control-label">Identitas Barang/Jasa</label>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang </label>
                        <div class="col-xs-9">
                            <input name="NAMA_2" id="NAMA_2" class="form-control" type="text" placeholder="Contoh : Mata Gerinda 3 Inch">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek Barang</label>
                        <div class="col-xs-9">
                            <input name="MEREK_2" id="MEREK_2" class="form-control" type="text" placeholder="Contoh : Tekiro">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT_2" id="SPESIFIKASI_SINGKAT_2" class="form-control" type="text" placeholder="Contoh : 3 Inch">
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG_2" id="JUMLAH_BARANG_2" class="form-control touchspin1" type="number">
                        </div>
                    </div> -->

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
                            <select name="KLASIFIKASI_BARANG_2" class="form-control" id="KLASIFIKASI_BARANG_2" disabled>
                                <option value=''>- Pilih Klasifikasi Barang -</option>
                                <?php foreach ($klasifikasi_barang_list as $item) {
                                    echo '<option value="' . $item->ID_KLASIFIKASI_BARANG . '">' . $item->NAMA_KLASIFIKASI_BARANG . '</option>';
                                } ?>
                            </select>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan</label>
                        <div class="col-xs-9">
                            <input name="KETERANGAN_2" id="KETERANGAN_2" class="form-control" type="text">
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
                            <input name="HARGA_TOTAL_FIX_2" id="HARGA_TOTAL_FIX_2" class="form-control" type="hidden" placeholder="Contoh: Rp 14000000 " disabled>
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
                    <button class="btn btn-primary" id="btn_update" disabled><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT-->

<!-- MODAL EDIT KETERANGAN BARANG-->
<div class="modal inmodal fade" id="ModalEditKeteranganBarang" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Keterangan Item Barang/Jasa</h4>
                <small class="font-bold">Silakan berikan keterangan atas item barang/jasa</small>
            </div>
            <?php $attributes = array("ID_PO_barang5" => "contact_form", "id" => "contact_form");
            echo form_open("PO_form/update_data_justifikasi_barang", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_PO_FORM5" id="ID_PO_FORM5" class="form-control" type="hidden" readonly>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Kode Barang</label>
                        <div class="col-xs-9">
                            <input name="KODE_BARANG5" id="KODE_BARANG5" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Nama Barang</label>
                        <div class="col-xs-9">
                            <input name="NAMA5" id="NAMA5" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Merek</label>
                        <div class="col-xs-9">
                            <input name="MEREK5" id="MEREK5" class="form-control" type="text" placeholder="Contoh : Heavy Equipment" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Spesifikasi Singkat</label>
                        <div class="col-xs-9">
                            <input name="SPESIFIKASI_SINGKAT5" id="SPESIFIKASI_SINGKAT5" class="form-control" type="text" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Barang</label>
                        <div class="col-xs-9">
                            <input name="JUMLAH_BARANG5" id="JUMLAH_BARANG5" class="form-control touchspin1" type="number" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-xs-3">Keterangan Item Barang</label>
                        <div class="col-xs-9">
                            <textarea class="form-control h-200" name="KETERANGAN5" id="KETERANGAN5" placeholder="Contoh: Paku Payung 13 cm" required></textarea>
                        </div>
                    </div>

                    <div id="alert-msg-5"></div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
                    <button class="btn btn-primary" id="btn_update_keterangan_barang"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KETERANGAN BARANG-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width: 80vw;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                <h4 class="modal-title" id="myModalLabel">Hapus Item Barang/Jasa PO</h4>
            </div>
            <form class="form-horizontal">
                <div class="modal-body">

                    <input type="hidden" name="kode" id="textkode" value="">
                    <div class="alert alert-warning">
                        <p>Apakah Anda yakin ingin menghapus item barang/jasa ini?</p>
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

<!-- MODAL KIRIM PO-->
<div class="modal inmodal fade" id="ModalEditKirimPO" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 30vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-send modal-icon"></i>
                <h4 class="modal-title">Kirim PO</h4>
                <small class="font-bold">Selesaikan proses dan kirim Form PO ini untuk proses selanjutnya</small>
            </div>
            <?php $attributes = array("ID_PO7" => "contact_form", "id" => "contact_form");
            echo form_open("PO_form/update_data_kirim_po", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">

                    <input name="ID_PO7" id="ID_PO7" class="form-control" type="hidden" placeholder="ID PO" readonly>

                    <div id="show_hidden_setuju" class="form-group" hidden>
                        <div class="i-checks"><label> <input type="checkbox" id="saya_setuju"><i></i> Saya telah selesai melakukan proses form PO ini dan menyetujui untuk diproses lebih lanjut </label></div>
                    </div>

                    <div id="show_hidden_tidak_ada_item_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada item barang yang diminta pada PO ini</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_jumlah_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, masih ada item jumlah barang yang bernilai 0</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_harga_barang" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada harga yang diminta pada PO ini</center>
                        </div>
                    </div>

                    <div id="show_hidden_belum_atur_pajak" hidden>
                        <div class="alert alert-danger alert-dismissable block">
                            <center>Proses tidak dapat dilanjutkan, tidak ada pajak yang diminta pada PO ini</center>
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
                    <button class="btn btn-primary" id="btn_update_kirim_po" disabled><i class="fa fa-send"></i> Kirim</button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<!--END MODAL EDIT KIRIM PO-->

<!-- MODAL EDIT CATATAN PO-->
<div class="modal inmodal fade" id="ModalEditCatatanPO" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="width: 80vw;">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <i class="fa fa-group modal-icon"></i>
                <h4 class="modal-title">Catatan PO</h4>
                <small class="font-bold">Silakan berikan komentar atau catatan mengenai Form PO ini</small>
            </div>
            <?php $attributes = array("ID_PO6" => "contact_form", "id" => "contact_form");
            echo form_open("PO_form/update_data_catatan_po", $attributes); ?>
            <div class="form-horizontal">
                <div class="modal-body">


                    <input name="ID_PO6" id="ID_PO6" class="form-control" type="hidden" placeholder="ID PO" readonly>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Catatan PO</label>

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
<!--END MODAL EDIT CATATAN PO-->


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
        var ID_PO = <?php echo $ID_PO;  ?>;
        var HASH_MD5_PO = '<?php echo $HASH_MD5_PO;  ?>';

        var HARGA = <?php echo $NOMINAL_DISKON;  ?>;
        var JUMLAH = 1;
        var TOTAL = Math.floor(HARGA * JUMLAH);

        $('[name="TAMPIL_NOMINAL_DISKON3"]').val(new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(TOTAL));

        $('#data_TANGGAL_KIRIM_BARANG_HARI .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#data_BATAS_AKHIR .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#data_DURASI .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $('#data_TANGGAL_DOKUMEN_PO .input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: 'dd/mm/yyyy'
        });

        $("#HARGA_SATUAN_BARANG_FIX_4").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_4").val();
            var JUMLAH = $("#JUMLAH_BARANG_4").val();
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_4"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_4"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });

        $("#NOMINAL_DISKON3").on("change", function() {

            var HARGA = $("#NOMINAL_DISKON3").val();
            var JUMLAH = 1;
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="TAMPIL_NOMINAL_DISKON3"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });

        $("#NOMINAL_DISKON3").on("keyup", function() {

            var HARGA = $("#NOMINAL_DISKON3").val();
            var JUMLAH = 1;
            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="TAMPIL_NOMINAL_DISKON3"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });

        //GET UPDATE untuk edit jumlah
        $("#HARGA_SATUAN_BARANG_FIX_2").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_2").val();
            var JUMLAH = $("#JUMLAH_BARANG_2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

        });

        //GET UPDATE untuk edit jumlah
        $("#JUMLAH_BARANG_2").on("focusout", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_2").val();
            var JUMLAH = $("#JUMLAH_BARANG_2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));

            var form_data = {
                ID_SPP_FORM: $("#ID_SPP_FORM_2").val()
            };

            var jumlah_realisasi_po, jumlah_po_di_spp,jumlah_sisa = 0;

            $.ajax({
                url: "<?php echo site_url('PO_form/data_qty_po_realisasi') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {

                    console.log("data_qty_po_realisasi", data);

                    var data_3 = data;

                    if (data_3[0].JUMLAH_BARANG == null) {
                        jumlah_realisasi_spp = 0;
                    }
                    else {
                        jumlah_realisasi_po = data_3[0].JUMLAH_BARANG;
                    }

                }
            });

            $.ajax({
                url: "<?php echo site_url('PO_form/data_jumlah_qty_po_by_id_spp_form') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {

                    console.log("data_jumlah_qty_po_by_id_spp_form", data);

                    if (data.JUMLAH_BARANG == null) {
                        jumlah_po_di_spp = 0;
                    }
                    else {
                        jumlah_po_di_spp = data.JUMLAH_BARANG;
                    }

                }
            });

            jumlah_sisa = jumlah_po_di_spp - jumlah_realisasi_po;

            console.log("jumlah_sisa", jumlah_sisa);

            var JUMLAH_ORIGINAL = $("#JUMLAH_BARANG_ORIGINAL_2").val();

            console.log("JUMLAH_ORIGINAL", JUMLAH_ORIGINAL);

            var jumlah_tampil = (jumlah_po_di_spp) - (jumlah_realisasi_po) - ( (JUMLAH) - (JUMLAH_ORIGINAL));

            jumlah_tampil = parseFloat(jumlah_tampil.toFixed(2));

            console.log("jumlah_tampil", jumlah_tampil);

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
                currency: 'IDR'
            }).format(TOTAL));

            var form_data = {
                ID_SPP_FORM: $("#ID_SPP_FORM_2").val()
            };

            var jumlah_realisasi_po, jumlah_po_di_spp,jumlah_sisa = 0;

            $.ajax({
                url: "<?php echo site_url('PO_form/data_qty_po_realisasi') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {

                    console.log("data_qty_po_realisasi", data);

                    var data_3 = data;

                    if (data_3[0].JUMLAH_BARANG == null) {
                        jumlah_realisasi_spp = 0;
                    }
                    else {
                        jumlah_realisasi_po = data_3[0].JUMLAH_BARANG;
                    }

                }
            });

            $.ajax({
                url: "<?php echo site_url('PO_form/data_jumlah_qty_po_by_id_spp_form') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {

                    console.log("data_jumlah_qty_po_by_id_spp_form", data);

                    if (data.JUMLAH_BARANG == null) {
                        jumlah_po_di_spp = 0;
                    }
                    else {
                        jumlah_po_di_spp = data.JUMLAH_BARANG;
                    }

                }
            });

            jumlah_sisa = jumlah_po_di_spp - jumlah_realisasi_po;

            console.log("jumlah_sisa", jumlah_sisa);

            var JUMLAH_ORIGINAL = $("#JUMLAH_BARANG_ORIGINAL_2").val();

            console.log("JUMLAH_ORIGINAL", JUMLAH_ORIGINAL);

            var jumlah_tampil = (jumlah_po_di_spp) - (jumlah_realisasi_po) - ( (JUMLAH) - (JUMLAH_ORIGINAL));
 
            jumlah_tampil = parseFloat(jumlah_tampil.toFixed(2));

            console.log("jumlah_tampil", jumlah_tampil);

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
                currency: 'IDR'
            }).format(TOTAL));

            var form_data = {
                ID_SPP_FORM: $("#ID_SPP_FORM_2").val()
            };

            var jumlah_realisasi_po, jumlah_po_di_spp,jumlah_sisa = 0;

            $.ajax({
                url: "<?php echo site_url('PO_form/data_qty_po_realisasi') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {

                    console.log("data_qty_po_realisasi", data);

                    var data_3 = data;

                    if (data_3[0].JUMLAH_BARANG == null) {
                        jumlah_realisasi_spp = 0;
                    }
                    else {
                        jumlah_realisasi_po = data_3[0].JUMLAH_BARANG;
                    }

                }
            });

            $.ajax({
                url: "<?php echo site_url('PO_form/data_jumlah_qty_po_by_id_spp_form') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {

                    console.log("data_jumlah_qty_po_by_id_spp_form", data);

                    if (data.JUMLAH_BARANG == null) {
                        jumlah_po_di_spp = 0;
                    }
                    else {
                        jumlah_po_di_spp = data.JUMLAH_BARANG;
                    }

                }
            });

            jumlah_sisa = jumlah_po_di_spp - jumlah_realisasi_po;

            console.log("jumlah_sisa", jumlah_sisa);

            var JUMLAH_ORIGINAL = $("#JUMLAH_BARANG_ORIGINAL_2").val();

            console.log("JUMLAH_ORIGINAL", JUMLAH_ORIGINAL);

            var jumlah_tampil = (jumlah_po_di_spp) - (jumlah_realisasi_po) - ( (JUMLAH) - (JUMLAH_ORIGINAL));

            jumlah_tampil = parseFloat(jumlah_tampil.toFixed(2));

            console.log("jumlah_tampil", jumlah_tampil);

            var html = "Sisa yang belum terealisasi " + jumlah_tampil +" qty"
            $('#show_data_sisa').html(html);


        });


        $("#LOKASI_PENYERAHAN").change(function() {
        if ($("#LOKASI_PENYERAHAN option:selected").text() == '- LOKASI LAINNYA -') {
            $('#show_hidden_lokasi').attr("hidden", false); //enable input
        } else {
            $('#show_hidden_lokasi').attr("hidden", true); //enable input

        }
        });

        $("#TERM_OF_PAYMENT").change(function() {
        if ($("#TERM_OF_PAYMENT option:selected").text() == '- TERM OF PAYMENT LAINNYA -') {
            $('#show_hidden_top').attr("hidden", false); //enable input
        } else {
            $('#show_hidden_top').attr("hidden", true); //enable input

        }
        });

        $("#KONDISI_PENGADAAN_BARIS_5").change(function() {
        if ($("#KONDISI_PENGADAAN_BARIS_5 option:selected").text() == '- KONDISI PENGADAAN LAINNYA -') {
            $('#show_hidden_kondisi_pengadaan_1').attr("hidden", false); //enable input
        } else {
            $('#show_hidden_kondisi_pengadaan_1').attr("hidden", true); //enable input

        }
        });

        $("#KONDISI_PENGADAAN_BARIS_6").change(function() {
        if ($("#KONDISI_PENGADAAN_BARIS_6 option:selected").text() == '- KONDISI PENGADAAN LAINNYA -') {
            $('#show_hidden_kondisi_pengadaan_2').attr("hidden", false); //enable input
        } else {
            $('#show_hidden_kondisi_pengadaan_2').attr("hidden", true); //enable input

        }
        });

        $("#KONDISI_PENGADAAN_BARIS_7").change(function() {
        if ($("#KONDISI_PENGADAAN_BARIS_7 option:selected").text() == '- KONDISI PENGADAAN LAINNYA -') {
            $('#show_hidden_kondisi_pengadaan_3').attr("hidden", false); //enable input
        } else {
            $('#show_hidden_kondisi_pengadaan_3').attr("hidden", true); //enable input

        }
        });

        $("#KONDISI_PENGADAAN_BARIS_8").change(function() {
        if ($("#KONDISI_PENGADAAN_BARIS_8 option:selected").text() == '- KONDISI PENGADAAN LAINNYA -') {
            $('#show_hidden_kondisi_pengadaan_4').attr("hidden", false); //enable input
        } else {
            $('#show_hidden_kondisi_pengadaan_4').attr("hidden", true); //enable input

        }
        });

        $("#KONDISI_PENGADAAN_BARIS_9").change(function() {
        if ($("#KONDISI_PENGADAAN_BARIS_9 option:selected").text() == '- KONDISI PENGADAAN LAINNYA -') {
            $('#show_hidden_kondisi_pengadaan_5').attr("hidden", false); //enable input
        } else {
            $('#show_hidden_kondisi_pengadaan_5').attr("hidden", true); //enable input

        }
        });

        $("#KONDISI_PENGADAAN_BARIS_10").change(function() {
        if ($("#KONDISI_PENGADAAN_BARIS_10 option:selected").text() == '- KONDISI PENGADAAN LAINNYA -') {
            $('#show_hidden_kondisi_pengadaan_6').attr("hidden", false); //enable input
        } else {
            $('#show_hidden_kondisi_pengadaan_6').attr("hidden", true); //enable input

        }
        });

        $('#saya_setuju').click(function () {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update').attr('disabled', true); //disable input
            }
        });

        $("#DISKON3").change(function() {
            if ($("#DISKON3 option:selected").val() == 'TIDAK') {
                
                $('#show_hidden_diskon').attr("hidden", true);

                $('[name="NOMINAL_DISKON3"]').val(0);

                var HARGA = $("#NOMINAL_DISKON3").val();
                var JUMLAH = 1;
                var TOTAL = Math.floor(HARGA * JUMLAH);

                $('[name="TAMPIL_NOMINAL_DISKON3"]').val(new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                }).format(TOTAL));

            } else if ($("#DISKON3 option:selected").val() == 'ADA') {
                
                $('#show_hidden_diskon').attr("hidden", false);

            } else {
                $('#show_hidden_diskon').attr("hidden", true);
            }
            
        });

        tampil_data_form_po(); //pemanggilan fungsi tampil data.

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
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
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
						columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
					},
				}
			]

        });
        $('#modalmaster').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            order: [
                [2, "asc"]
            ]
        });
        $('#modalrasd').dataTable({
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, 'All'],
            ],
            responsive: true,
            order: [
                [2, "asc"]
            ]
        });

        $("#checkAllbarangmaster").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#checkAllspp").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        $("#checkAllrasd").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
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
        //fungsi tampil data penyerahan vendor top
        function tampil_data_po_penyerahan_vendor_top() {
            var ID_PO = ID_PO;
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('PO_form/get_data_po') ?>",
                dataType: "JSON",
                data: {
                    ID_PO: ID_PO
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEdit').modal('show');
                        $('[name="ID_PO_FORM_2"]').val(data.ID_PO_FORM);
                        $('[name="KODE_BARANG2"]').val(data.KODE_BARANG);
                        $('[name="NAMA_2"]').val(data.NAMA_BARANG);
                        $('[name="MEREK_2"]').val(data.MEREK);
                        $('[name="JENIS_BARANG2"]').val(data.JENIS_BARANG);
                        $('[name="PERALATAN_PERLENGKAPAN2"]').val(data.PERALATAN_PERLENGKAPAN);
                        $('[name="SPESIFIKASI_SINGKAT_2"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="SATUAN_BARANG_2"]').val(data.SATUAN_BARANG);
                        $('[name="JUMLAH_BARANG_2"]').val(data.JUMLAH_BARANG);
                        $('[name="TANGGAL_MULAI_PAKAI2"]').val(data.TANGGAL_MULAI_PAKAI);
                        $('[name="TANGGAL_SELESAI_PAKAI2"]').val(data.TANGGAL_SELESAI_PAKAI);
                        $('#alert-msg-2').html('<div></div>');
                    });
                }
            });
            return false;

        }

        //fungsi tampil data
        function tampil_data_form_po() {
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>PO_form/data_po_form',
                async: false,
                dataType: 'json',
                data: {
                    id: ID_PO
                },
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        let jumlah_barang = data[i].JUMLAH_BARANG;

                        HARGA_SATUAN_BARANG_FIX = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data[i].HARGA_SATUAN_BARANG_FIX);

                        HARGA_TOTAL_FIX = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(data[i].HARGA_TOTAL_FIX);

                        HARGA_SETELAH_PAJAK = (parseInt(data[i].HARGA_TOTAL_FIX) * parseInt(data[i].TARIF_PAJAK) / 100);
                        HARGA_SETELAH_PAJAK = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(HARGA_SETELAH_PAJAK);

                        html += '<tr>' +
                            '<td>' + data[i].NAMA_BARANG + '</td>' +
                            '<td>' + data[i].MEREK + '</td>' +
                            '<td>' + data[i].SPESIFIKASI_SINGKAT + '</td>' +
                            '<td>' + data[i].KODE_KLASIFIKASI_BARANG + '</td>' +
                            '<td>' + data[i].SATUAN_BARANG + '</td>' +
                            '<td>' + jumlah_barang + '</td>' +
                            '<td>' + HARGA_SATUAN_BARANG_FIX + '</td>' +
                            '<td>' + HARGA_TOTAL_FIX + '</td>' +
                            '<td>' + data[i].TARIF_PAJAK + '%' + '<br>' + HARGA_SETELAH_PAJAK + '</td>' +
                            '<td>' + data[i].KETERANGAN_BARANG_PO + '</td>' +
                            '<td>' +
                            '<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_PO_FORM + '"><i class="fa fa-pencil"></i> Ubah </a>' + ' ' +
                            '<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_PO_FORM + '"><i class="fa fa-trash"></i> Hapus</a>' +
                            '</td>' +

                            '</tr>';
                    }
                    $('#show_data').html(html);
                }
            });
        }

        $("#HARGA_SATUAN_BARANG_FIX_2").on("keyup", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_2").val();
            var JUMLAH = $("#JUMLAH_BARANG_2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));
        });

        $("#JUMLAH_BARANG_2").on("change", function() {

            var HARGA = $("#HARGA_SATUAN_BARANG_FIX_2").val();
            var JUMLAH = $("#JUMLAH_BARANG_2").val();

            var TOTAL = Math.floor(HARGA * JUMLAH);

            $('[name="HARGA_TOTAL_FIX_2"]').val(TOTAL);
            $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(TOTAL));
        });

        //GET UPDATE untuk edit jumlah
        $('#show_data').on('click', '.item_edit', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('PO_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#ModalEdit').modal('show');
                    $('[name="ID_SPP_FORM_2"]').val(data.ID_SPP_FORM);
                    $('[name="ID_PO_FORM_2"]').val(data.ID_PO_FORM);
                    $('[name="NAMA_2"]').val(data.NAMA_BARANG);
                    $('[name="MEREK_2"]').val(data.MEREK);
                    $('[name="SPESIFIKASI_SINGKAT_2"]').val(data.SPESIFIKASI_SINGKAT);
                    $('[name="JUMLAH_BARANG_2"]').val(data.JUMLAH_BARANG);
                    $('[name="JUMLAH_BARANG_ORIGINAL_2"]').val(data.JUMLAH_BARANG);
                    $('[name="KLASIFIKASI_BARANG2"]').val(data.SATUAN_BARANG);
                    $('[name="SATUAN_BARANG_2"]').val(data.SATUAN_BARANG);
                    $('[name="HARGA_SATUAN_BARANG_FIX_2"]').val(data.HARGA_SATUAN_BARANG_FIX);
                    $('[name="HARGA_TOTAL_FIX_2"]').val(data.HARGA_TOTAL_FIX);
                    $('[name="HARGA_TOTAL_TAMPIL_2"]').val(new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(data.HARGA_TOTAL_FIX));

                }
            });
            return false;
        });

        //UPDATE JUSTIFIKASI BARANG 
        $('#btn_update_keterangan_barang').on('click', function() {

            let ID_PO_FORM = $('#ID_PO_FORM5').val();
            let KETERANGAN = $('#KETERANGAN5').val();
            $.ajax({
                url: "<?php echo site_url('PO_form/update_data_keterangan_barang') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_PO_FORM: ID_PO_FORM,
                    KETERANGAN: KETERANGAN
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKeteranganBarang').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        //SIMPAN DATA
        $('#btn_simpan_data_di_luar_barang_master').click(function() {
            var form_data = {
                ID_PO: ID_PO,
                NAMA: $('#NAMA_4').val(),
                MEREK: $('#MEREK_4').val(),
                JENIS_BARANG: $('#JENIS_BARANG_4').val(),
                PERALATAN_PERLENGKAPAN: $('#PERALATAN_PERLENGKAPAN_4').val(),
                SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT_4').val(),
                SATUAN_BARANG: $('#SATUAN_BARANG_4').val(),
                JUMLAH_BARANG: $('#JUMLAH_BARANG_4').val(),
                HARGA_SATUAN_BARANG_FIX: $('#HARGA_SATUAN_BARANG_FIX_4').val(),
                HARGA_TOTAL_FIX: $('#HARGA_TOTAL_FIX_4').val(),
            };
            $.ajax({
                url: "<?php echo site_url('PO_form/simpan_data_di_luar_barang_master'); ?>",
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

        //SIMPAN IDENTITAS FORM
        $('#btn_simpan_identitas_form').click(function() {
            var TANGGAL_KIRIM_BARANG_HARI = $('#TANGGAL_KIRIM_BARANG_HARI').val(),
            TANGGAL_KIRIM_BARANG_HARI = TANGGAL_KIRIM_BARANG_HARI.split("/").reverse().join("-");

            var BATAS_AKHIR = $('#BATAS_AKHIR').val(),
            BATAS_AKHIR = BATAS_AKHIR.split("/").reverse().join("-");

            var TANGGAL_MULAI_PAKAI_HARI = $('#TANGGAL_MULAI_PAKAI_HARI').val(),
            TANGGAL_MULAI_PAKAI_HARI = TANGGAL_MULAI_PAKAI_HARI.split("/").reverse().join("-");

            var TANGGAL_SELESAI_PAKAI_HARI = $('#TANGGAL_SELESAI_PAKAI_HARI').val(),
            TANGGAL_SELESAI_PAKAI_HARI = TANGGAL_SELESAI_PAKAI_HARI.split("/").reverse().join("-");

            var TANGGAL_DOKUMEN_PO = $('#TANGGAL_DOKUMEN_PO').val(),
            TANGGAL_DOKUMEN_PO = TANGGAL_DOKUMEN_PO.split("/").reverse().join("-");

            if($('#KONDISI_PENGADAAN_BARIS_5').val() == "99999")
            {

                var KONDISI_PENGADAAN_BARIS_5 =  $('#KONDISI_PENGADAAN_BARIS_5_TEKS').val();
            }
            else
            {
                var KONDISI_PENGADAAN_BARIS_5 =  $('#KONDISI_PENGADAAN_BARIS_5').val();
            }
            

            if($('#KONDISI_PENGADAAN_BARIS_6').val() == "99999")
            {

                var KONDISI_PENGADAAN_BARIS_6 =  $('#KONDISI_PENGADAAN_BARIS_6_TEKS').val();
            }
            else
            {
                var KONDISI_PENGADAAN_BARIS_6 =  $('#KONDISI_PENGADAAN_BARIS_6').val();
            }
            
            if($('#KONDISI_PENGADAAN_BARIS_7').val() == "99999")
            {

                var KONDISI_PENGADAAN_BARIS_7 =  $('#KONDISI_PENGADAAN_BARIS_7_TEKS').val();
            }
            else
            {
                var KONDISI_PENGADAAN_BARIS_7 =  $('#KONDISI_PENGADAAN_BARIS_7').val();
            }

            if($('#KONDISI_PENGADAAN_BARIS_8').val() == "99999")
            {
                var KONDISI_PENGADAAN_BARIS_8 =  $('#KONDISI_PENGADAAN_BARIS_8_TEKS').val();
            }
            else
            {
                var KONDISI_PENGADAAN_BARIS_8 =  $('#KONDISI_PENGADAAN_BARIS_8').val();
            }

            if($('#KONDISI_PENGADAAN_BARIS_9').val() == "99999")
            {
                var KONDISI_PENGADAAN_BARIS_9 =  $('#KONDISI_PENGADAAN_BARIS_9_TEKS').val();
            }
            else
            {
                var KONDISI_PENGADAAN_BARIS_9 =  $('#KONDISI_PENGADAAN_BARIS_9').val();
            }

            if($('#KONDISI_PENGADAAN_BARIS_10').val() == "99999")
            {
                var KONDISI_PENGADAAN_BARIS_10 =  $('#KONDISI_PENGADAAN_BARIS_10_TEKS').val();
            }
            else
            {
                var KONDISI_PENGADAAN_BARIS_10 =  $('#KONDISI_PENGADAAN_BARIS_10').val();
            }

            if($('#TERM_OF_PAYMENT').val() == "99999")
            {
                var TERM_OF_PAYMENT =  $('#TERM_OF_PAYMENT_TEKS').val();
            }
            else
            {
                var TERM_OF_PAYMENT =  $('#TERM_OF_PAYMENT').val();
            }

            if($('#LOKASI_PENYERAHAN').val() == "99999")
            {
                var LOKASI_PENYERAHAN =  $('#LOKASI_PENYERAHAN_TEKS').val();
            }
            else
            {
                var LOKASI_PENYERAHAN =  $('#LOKASI_PENYERAHAN').val();
            }

            if($('#TANDA_TANGAN').val() == "Mjr. Pengadaan")
            {

                var TANDA_TANGAN_1 =  'Mjr. Pengadaan';
                var TANDA_TANGAN_2 =  'Bag. Pembelian';
            }

            if($('#TANDA_TANGAN').val() == "Mjr. Site")
            {

                var TANDA_TANGAN_1 =  'Mjr. Site';
                var TANDA_TANGAN_2 =  'Bag. Pembelian';
            }


            if($('#TANDA_TANGAN').val() == "Direktur")
            {

                var TANDA_TANGAN_1 =  'Direktur';
                var TANDA_TANGAN_2 =  'Mjr. Pengadaan';
            }

            if($('#TANDA_TANGAN').val() == "Direktur Utama")
            {

                var TANDA_TANGAN_1 =  'Direktur Utama';
                var TANDA_TANGAN_2 =  'Direktur';
            }

            var form_data = {
                ID_PO: ID_PO,
                NO_URUT_PO_GANTI: $('#NO_URUT_PO_GANTI').val(),
                NO_URUT_PO_ASLI: $('#NO_URUT_PO_ASLI').val(),
                LOKASI_PENYERAHAN: LOKASI_PENYERAHAN,
                TERM_OF_PAYMENT: TERM_OF_PAYMENT,
                TANGGAL_KIRIM_BARANG_HARI: TANGGAL_KIRIM_BARANG_HARI,
                BATAS_AKHIR: BATAS_AKHIR,
                TANGGAL_MULAI_PAKAI_HARI: TANGGAL_MULAI_PAKAI_HARI,
                TANGGAL_SELESAI_PAKAI_HARI: TANGGAL_SELESAI_PAKAI_HARI,
                TANGGAL_DOKUMEN_PO: TANGGAL_DOKUMEN_PO,
                CTT_KEPERLUAN: $('#CTT_KEPERLUAN').val(),
                CTT_KEPERLUAN_BARIS_2: $('#CTT_KEPERLUAN_BARIS_2').val(),
                KONDISI_PENGADAAN_BARIS_1: $('#KONDISI_PENGADAAN_BARIS_1').val(),
                KONDISI_PENGADAAN_BARIS_2: $('#KONDISI_PENGADAAN_BARIS_2').val(),
                KONDISI_PENGADAAN_BARIS_3: $('#KONDISI_PENGADAAN_BARIS_3').val(),
                KONDISI_PENGADAAN_BARIS_4: $('#KONDISI_PENGADAAN_BARIS_4').val(),
                KONDISI_PENGADAAN_BARIS_5: KONDISI_PENGADAAN_BARIS_5,
                KONDISI_PENGADAAN_BARIS_6: KONDISI_PENGADAAN_BARIS_6,
                KONDISI_PENGADAAN_BARIS_7: KONDISI_PENGADAAN_BARIS_7,
                KONDISI_PENGADAAN_BARIS_8: KONDISI_PENGADAAN_BARIS_8,
                KONDISI_PENGADAAN_BARIS_9: KONDISI_PENGADAAN_BARIS_9,
                KONDISI_PENGADAAN_BARIS_10: KONDISI_PENGADAAN_BARIS_10,
                REFERENSI_DOKUMEN_SPH: $('#REFERENSI_DOKUMEN_SPH').val(),
                REFERENSI_DOKUMEN_KONTRAK: $('#REFERENSI_DOKUMEN_KONTRAK').val(),
                BARIS_KOSONG: $('#BARIS_KOSONG').val(),
                TANDA_TANGAN_1: TANDA_TANGAN_1,
                TANDA_TANGAN_2: TANDA_TANGAN_2
            };
            $.ajax({
                url: "<?php echo site_url('PO_form/simpan_identitas_form'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 'true') {
                        $('#alert-msg-8').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var HASH_MD5_PO = $('#HASH_MD5_PO').val()
                        var alamat = "<?php echo base_url('PO_form/index/'); ?>" + HASH_MD5_PO;
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
            var HASH_MD5_PO = $('#HASH_MD5_PO').val()
            var alamat = "<?php echo base_url('PO_form/view/'); ?>" + HASH_MD5_PO;
            window.open(
                alamat,
                '_self' // <- This is what makes it open in a new window.
            );
        });

        //GET UDPATE untuk berikan justifkasi
        $('#show_data').on('click', '.item_edit_keterangan', function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('PO_form/get_data') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditKeteranganBarang').modal('show');
                        $('[name="ID_PO_FORM5"]').val(data.ID_PO_FORM);
                        $('[name="KODE_BARANG5"]').val(data.KODE_BARANG);
                        $('[name="NAMA5"]').val(data.NAMA_BARANG);
                        $('[name="MEREK5"]').val(data.MEREK);
                        $('[name="SPESIFIKASI_SINGKAT5"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="JUMLAH_BARANG5"]').val(data.JUMLAH_BARANG);
                        $('[name="KETERANGAN5"]').val(data.KETERANGAN);
                        $('#alert-msg-5').html('<div></div>');
                    });
                }
            });
            return false;
        });

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            var form_data = {
                ID_SPP_FORM : $('#ID_SPP_FORM_2').val(),
                ID_PO_FORM : $('#ID_PO_FORM_2').val(),
                NAMA : $('#NAMA_2').val(),
                MEREK : $('#MEREK_2').val(),
                SPESIFIKASI_SINGKAT : $('#SPESIFIKASI_SINGKAT_2').val(),
                SATUAN_BARANG : $('#SATUAN_BARANG_2').val(),
                JUMLAH_BARANG : $('#JUMLAH_BARANG_2').val(),
                JUMLAH_BARANG_ORIGINAL : $('#JUMLAH_BARANG_ORIGINAL_2').val(),
                HARGA_SATUAN_BARANG_FIX : $('#HARGA_SATUAN_BARANG_FIX_2').val(),
                HARGA_TOTAL_FIX : $('#HARGA_TOTAL_FIX_2').val(),
                KETERANGAN : $('#KETERANGAN_2').val()
            };

            console.log(form_data);

            $.ajax({
                url: "<?php echo site_url('PO_form/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: form_data,
                async: false,
                error: function (xhr, status) {
                    alert(status);
                },
                success: function(data) {

                    console.log(data);
                    if (data == true) {
                        document.getElementById("saya_setuju").checked = false;
                        $('#btn_update').attr('disabled', true); //disable input
                        $('#ModalEdit').modal('hide');
                        $("#mydata").dataTable().fnDestroy();
                        tampil_data_form_po();
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
                url: "<?php echo base_url('PO_form/get_data') ?>",
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

        //HAPUS DATA
        $('#btn_hapus').on('click', function() {
            var kode = $('#textkode').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('PO_form/hapus_data') ?>",
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

        $('#saya_setuju').click(function() {
            //check if checkbox is checked
            if ($(this).is(':checked')) {

                $('#btn_update_kirim_po').removeAttr('disabled'); //enable input

            } else {
                $('#btn_update_kirim_po').attr('disabled', true); //disable input
            }
        });

        //UPDATE CATATAN PO 
        $('#btn_update_catatan_po').on('click', function() {

            let ID_PO = $('#ID_PO6').val();
            let CTT_STAFF_PROC = $('#CTT_STAFF_PROC6').val();
            $.ajax({
                url: "<?php echo site_url('PO_form/update_data_catatan_po') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_PO: ID_PO,
                    CTT_STAFF_PROC: CTT_STAFF_PROC
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditCatatanPO').modal('hide');
                        window.location.reload();
                    } else {
                        $('#alert-msg-6').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });


        //UPDATE KIRIM PO
        $('#btn_update_kirim_po').on('click', function() {

            let ID_PO = $('#ID_PO7').val();
            $.ajax({
                url: "<?php echo site_url('PO_form/update_data_kirim_po') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_PO: ID_PO,
                },
                success: function(data) {
                    if (data == true) {
                        $('#ModalEditKirimPO').modal('hide');
                        window.location.href = '<?php echo site_url('PO') ?>';
                    } else {
                        $('#alert-msg-7').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });

        tambah_item_spp.onclick = function() {

        $('#ModalAddDariSPP').modal('show');

        $('#mydata_SPP').DataTable().destroy();

        //fungsi tampil data
        var data = <?php echo json_encode($spp_barang_list); ?>;
        var html = '';
        var jumlah_realisasi_po, jumlah_sisa = 0;

        console.log(data);

        for (l = 0; l < data.length; l++) {

            var form_data = {
                ID_SPP_FORM: data[l].ID_SPP_FORM
            };

            $.ajax({
                url: "<?php echo site_url('PO_form/data_qty_po_realisasi') ?>",
                type: "POST",
                dataType: "JSON",
                async: false,
                data: form_data,
                success: function (data) {
                    var data_3 = data;

                    if (data_3[0].JUMLAH_BARANG == null) {
                        jumlah_realisasi_po = 0;
                    }
                    else {
                        jumlah_realisasi_po = data_3[0].JUMLAH_BARANG;
                    }

                }
            });

            jumlah_sisa = data[l].JUMLAH_BARANG - jumlah_realisasi_po;

            html += '<tr>' +
            
            '<td>' + 
            '<input name="ID_PO" class="form-control" type="text" value="'+ ID_PO +'" style="display: none;" readonly>' +
            '<input class="checkbox" name="ID_SPP_FORM[]" value="'+ data[l].ID_SPP_FORM +'" type="checkbox">' +
            '</td>' +
            '<td>' + data[l].NAMA_BARANG + '</td>' +
            '<td>' + data[l].MEREK + '</td>' +
            '<td>' + data[l].SPESIFIKASI_SINGKAT + '</td>' +
            '<td>' + data[l].NAMA_KLASIFIKASI_BARANG + '</td>' +
            '<td>' + data[l].JUMLAH_BARANG + ' ' + data[l].SATUAN_BARANG + '</td>' +
            '<td>' + jumlah_realisasi_po + ' ' + data[l].SATUAN_BARANG + '</td>' +
            '<td>' + jumlah_sisa + ' ' + data[l].SATUAN_BARANG + '</td>' +
            '<td>' + data[l].NAMA_VENDOR + '</td>' +
            '</td>' +
            '</tr>';

        }
        $('#show_data_SPP').html(html);


        $('#mydata_SPP').dataTable({
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


        };

        item_edit_catatan_po.onclick = function() {
            var HASH_MD5_PO = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('PO_form/get_data_ctt_po') ?>",
                dataType: "JSON",
                data: {
                    HASH_MD5_PO: HASH_MD5_PO
                },
                success: function(data) {
                    $.each(data, function() {
                        $('#ModalEditCatatanPO').modal('show');
                        $('[name="ID_PO6"]').val(data.ID_PO);
                        $('[name="CTT_STAFF_PROC6"]').val(data.CTT_STAFF_PROC);

                        $('#alert-msg-6').html('<div></div>');
                    });
                }
            });
            return false;
        };

        item_edit_kirim_po.onclick = function() {
            var id = $(this).attr('data');
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('PO_form/data_po_form') ?>",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#ModalEditKirimPO').modal('show');
                    $.each(data, function() {
                        $('[name="ID_PO7"]').val(data[0].ID_PO);
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
                                $('#show_hidden_belum_atur_jumlah_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].HARGA_SATUAN_BARANG_FIX == 0) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_harga_barang').attr("hidden", false);
                                break;
                            }

                            if (data[i].TARIF_PAJAK == "" || data[i].TARIF_PAJAK == null) {
                                $('#show_hidden_setuju').attr("hidden", true);
                                $('#show_hidden_belum_atur_pajak').attr("hidden", false);
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

        //SIMPAN PAJAK FOR ALL
        $('#btn_simpan_pajak').click(function() {
            var form_data = {
                ID_PO: ID_PO,
                TARIF_PAJAK: $('#TARIF_PAJAK3').val(),
                DISKON: $('#DISKON3').val(),
                NOMINAL_DISKON: $('#NOMINAL_DISKON3').val(),
            };
            $.ajax({
                url: "<?php echo site_url('PO_form/simpan_pajak'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != 'true') {
                        $('#alert-msg-8').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        var alamat = "<?php echo base_url('PO_form/index/'); ?>" + HASH_MD5_PO;
                        window.open(
                            alamat,
                            '_self' // <- This is what makes it open in a new window.
                        );
                    }
                }
            });
            return false;
        });

    });
</script>

</body>

</html>