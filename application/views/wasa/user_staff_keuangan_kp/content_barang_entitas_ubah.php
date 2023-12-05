<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tambah Barang Entitas</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a onclick="goBack()">Barang Entitas By Id Barang Master</a>
            </li>
            <li class="active">
                <strong>Ubah</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight ecommerce">

    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1"> Informasi Barang</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-2"> Perolehan</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-3"> Kepemilikan</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-4"> Lokasi Barang</a></li>
                    <li class=""><a data-toggle="tab" href="#tab-7"> Simpan</a></li>
                </ul>
                <div class="tab-content">
                    <!-- informasi Barang -->
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="ibox product-detail">
                                        <div class="ibox-content">
                                            <div class="row">
                                                <?php
                                                if (isset($barang_master)) {
                                                    foreach ($barang_master->result() as $master) {
                                                ?>
                                                        <div class="col-md-4">
                                                            <div class="product-images">
                                                                <img src="https://d2pa5gi5n2e1an.cloudfront.net/webp/global/images/product/laptops/ASUS_ROG_Zephyrus_S_GX521/ASUS_ROG_Zephyrus_S_GX521_L_1.jpg" alt="" srcset="">
                                                                <img src="https://d2pa5gi5n2e1an.cloudfront.net/webp/global/images/product/laptops/ASUS_ROG_Zephyrus_S_GX521/ASUS_ROG_Zephyrus_S_GX521_L_5.jpg" alt="" srcset="">
                                                                <img src="https://d2pa5gi5n2e1an.cloudfront.net/webp/global/images/product/laptops/ASUS_ROG_Zephyrus_S_GX521/ASUS_ROG_Zephyrus_S_GX521_L_4.jpg" alt="" srcset="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">

                                                            <h2 class="font-bold m-b-xs">
                                                                <?php echo $master->NAMA; ?>
                                                            </h2>
                                                            <div class="m-t-md">
                                                                <h2 class="product-main-price">Kode Master : <?php echo $master->KODE_BARANG; ?></h2>
                                                            </div>
                                                            <div class="m-t-md">
                                                                <h3 class="product-main-price" id="kode_entity"></h3>
                                                            </div>
                                                            <!-- <div>
                                                                <label class="col-sm-3 " style="font-size: 12pt;">Kode Entity :</label>
                                                                <div class="col-sm-5"><input type="text" class="form-control" value="getKodeEntitas()" name="KODE_BARANG_ENTITAS" id="KODE_BARANG_ENTITAS" required disabled></div>
                                                            </div> -->
                                                            <hr>
                                                            <!-- <h4>Spesifikasi Produk</h4> -->
                                                            <dl class="m-t-md">
                                                                <dt>Jenis Barang :</dt>
                                                                <dd><?php echo $master->NAMA_JENIS_BARANG ?></dd><br>
                                                                <dt>Gross Weight :</dt>
                                                                <dd><?php echo $master->GROSS_WEIGHT ?></dd><br>
                                                                <dt>Nett Weight :</dt>
                                                                <dd><?php echo $master->NETT_WEIGHT ?></dd><br>
                                                                <dt>Dimensi :</dt>
                                                                <dd><?php echo $master->DIMENSI_PANJANG . ' cm x ' . $master->DIMENSI_LEBAR . ' cm x ' . $master->DIMENSI_TINGGI . ' cm' ?></dd>
                                                            </dl>
                                                            <h4>Spesifikasi Singkat Produk</h4>
                                                            <div class=" text-muted">
                                                                <?php echo $master->SPESIFIKASI_SINGKAT ?>
                                                            </div>
                                                            <hr>
                                                            <button class="btn btn-primary btn-sm" style="font-weight: bold;"><i class="fa fa-download"></i> Download Buku Panduan</button>
                                                        </div>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Riwayat Perolehan -->
                    <div id="tab-2" class="tab-pane ">
                        <div class="panel-body">
                            <!-- <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
                                    echo form_open("barang_entitas/simpan_data", $attributes); ?> -->
                            <fieldset class="form-horizontal">
                                <div class="form-group" style="display: none;"><label class="col-sm-2 control-label">Id Barang Entitas :</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" placeholder="id entitas" name="ID_BARANG_ENTITAS" id="ID_BARANG_ENTITAS" disabled></div>
                                </div>
                                <!-- <div class="form-group"><label class="col-sm-2 control-label">Kode Barang (Generate by System) :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode Barang" value="HE-001" disabled></div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Kode Entity (Generate by System) :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode Barang" value="HE-001-001" disabled></div>
                                        </div> -->
                                <div class="form-group"><label class="col-sm-2 control-label">Tanggal Peroleh :</label>
                                    <div class="col-sm-10" id="data_1">
                                        <!-- <div class="input-group date"> -->
                                        <!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span> -->
                                        <input type="date" class="form-control" placeholder="dd/bb/yyyy" id="TANGGAL_PEROLEHAN_HARI" name="TANGGAL_PEROLEHAN_HARI">
                                        <!-- </div> -->
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Nomor SPPB :</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nomor SPPB" name="ID_SPPB" id="ID_SPPB" disabled></div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Nomor PO :</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nomor PO" name="ID_PO" id="ID_PO" disabled></div>
                                </div>
                                <!-- <div class="form-group"><label class="col-sm-2 control-label">Nomor Invoice :</label>
                                    <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode Barang" value="0002114" disabled></div>
                                </div> -->
                                <div class="form-group"><label class="col-sm-2 control-label">Upload Kartu Garansi :</label>
                                    <div class="col-sm-10">
                                        <input type="file" accept="application/pdf" name="DOK_KARTU_GARANSI" id="DOK_KARTU_GARANSI">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Upload Sertifikat Produk :</label>
                                    <div class="col-sm-10">
                                        <input type="file" accept="application/pdf" name="DOK_SERTIFIKAT_PRODUK" id="DOK_SERTIFIKAT_PRODUK">
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Upload Dokumen Lainnya :</label>
                                    <div class="col-sm-10">
                                        <input type="file" accept="application/pdf" name="DOK_LAINNYA" id="DOK_LAINNYA">
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                    </div>
                    <!-- Riwayat Kepemilikan -->
                    <div id="tab-3" class="tab-pane">
                        <div class="panel-body">
                            <!-- <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
                                    echo form_open("barang_entitas/simpan_data", $attributes); ?> -->
                            <fieldset class="form-horizontal">
                                <!-- <div class="form-group"><label class="col-sm-2 control-label">Kode Barang (Generate by System) :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode Barang" value="HE-001" disabled></div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Kode Entity (Generate by System) :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode Barang" value="HE-001-001" disabled></div>
                                        </div> -->
                                <div class="form-group"><label class="col-sm-2 control-label">Status Kepemilikan :</label>
                                    <div class="col-sm-10">
                                        <select name="STATUS_KEPEMILIKAN" class="form-control" id="STATUS_KEPEMILIKAN" onchange="changeJenisKepemilikan()">
                                            <option value=''>- Pilih -</option>
                                            <option value="Beli">Beli</option>
                                            <option value="Sewa">Sewa</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label">Jenis Kepemilikan :</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="JENIS_KEPEMILIKAN" id="JENIS_KEPEMILIKAN" placeholder="Silahkan pilih status kepemilikan dahulu" disabled>
                                    </div>
                                </div>
                                <div class="form-group" id="tgl_mulai" style="display: none;"><label class="col-sm-2 control-label">Tanggal Mulai :</label>
                                    <div class="col-sm-10" id="data_1">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" placeholder="dd/bb/yyyy" name="TANGGAL_MULAI_SEWA_HARI" id="TANGGAL_MULAI_SEWA_HARI">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" id="tgl_selesai" style="display: none;"><label class="col-sm-2 control-label" id="tgl_selesai">Tanggal Selesai :</label>
                                    <div class="col-sm-10" id="data_1">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" placeholder="dd/bb/yyyy" name="TANGGAL_SELESAI_SEWA_HARI" id="TANGGAL_SELESAI_SEWA_HARI">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <!-- Lokasi Barang -->
                    <div id="tab-4" class="tab-pane">
                        <div class="panel-body">
                            <!-- <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
                                    echo form_open("barang_entitas/simpan_data", $attributes); ?> -->
                            <fieldset class="form-horizontal">
                                <!-- <div class="form-group"><label class="col-sm-2 control-label">Kode Barang (Generate by System) :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode Barang" value="HE-001" disabled></div>
                                        </div>
                                        <div class="form-group"><label class="col-sm-2 control-label">Kode Entity (Generate by System) :</label>
                                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode Barang" value="HE-001-001" disabled></div>
                                        </div> -->
                                <div class="form-group"><label class="col-sm-2 control-label">Lokasi :</label>
                                    <div class="col-sm-10">
                                        <select name="ID_PROYEK" class="form-control" id="ID_PROYEK">
                                            <option value=''>- Pilih Proyek -</option>
                                            <?php foreach ($proyek as $proyek) {
                                                echo '<option value="' . $proyek->ID_GUDANG . '">' . $proyek->NAMA_PROYEK . ' - ' . $proyek->NAMA_GUDANG . '</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group"><label class="col-sm-2 control-label">Penempatan :</label>
                                    <div class="col-sm-10">
                                        <select name="ID_PROYEK" class="form-control" id="ID_PROYEK">
                                            <option value=''>- Pilih Penempatan -</option>
                                            <option value=''>Gudang</option>
                                            <option value=''>Lapangan</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group"><label class="col-sm-2 control-label">Kondisi :</label>
                                    <div class="col-sm-10">
                                        <select name="ID_PROYEK" class="form-control" id="ID_PROYEK">
                                            <option value=''>- Pilih Kondisi -</option>
                                            <option value=''>Work</option>
                                            <option value=''>Not Work</option>

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group"><label class="col-sm-2 control-label">Tanggal Kadaluarsa :</label>
                                    <div class="col-sm-10" id="data_1">
                                        <input type="date" class="form-control" placeholder="dd/bb/yyyy" name="TANGGAL_SELESAI_SEWA_HARI" id="TANGGAL_SELESAI_SEWA_HARI">
                                    </div>
                                </div>

                            </fieldset>
                        </div>
                    </div>

                    <!-- Simpan -->
                    <div id="tab-7" class="tab-pane">
                        <div class="panel-body">
                            <hr>
                            <!-- <button class="btn btn-primary" type="submit">Simpan Ke Data Entity</button> -->
                            <!-- <button class="btn btn-warning" type="submit">Simpan Sebagai Draft</button> -->
                            <button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Simpan Perubahan Data</button>

                        </div>
                    </div>
                    <br><br>
                    <div id="alert-msg"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- slick carousel-->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slick/slick.min.js"></script>

<script>
    function goBack() {
        window.history.back();
    }

    function changeJenisKepemilikan() {
        <?php if (isset($barang_master)) {
            foreach ($barang_master->result() as $master) {
                echo 'var PERALATAN_PERLENGKAPAN = ' . $master->PERALATAN_PERLENGKAPAN;
            }
        } ?>;
        let tgl_mulai = document.getElementById("tgl_mulai");
        let tgl_selesai = document.getElementById("tgl_selesai");
        var status = document.getElementById("STATUS_KEPEMILIKAN").value;
        if (status == 'Beli' && PERALATAN_PERLENGKAPAN == 'Peralatan') {
            $('#JENIS_KEPEMILIKAN').val("Asset")
            tgl_mulai.style.display = "none";
            tgl_selesai.style.display = "none";
            $('#TANGGAL_MULAI_SEWA_HARI').val("")
            $('#TANGGAL_SELESAI_SEWA_HARI').val("")
        } else if (status == 'Sewa') {
            $('#JENIS_KEPEMILIKAN').val("Non Asset")
            tgl_mulai.style.display = "block";
            tgl_selesai.style.display = "block";
        } else if (status == 'Beli') {
            $('#JENIS_KEPEMILIKAN').val("Non Asset")
            tgl_mulai.style.display = "none";
            tgl_selesai.style.display = "none";
            $('#TANGGAL_MULAI_SEWA_HARI').val("")
            $('#TANGGAL_SELESAI_SEWA_HARI').val("")

        } else {
            console.log("error changeJenisKepemilikan function");
        }
    }
    $(document).ready(function() {
        tampil_data_barang_entitas();

        function tampil_data_barang_entitas() {
            var id = <?php echo $id_barang_entitas ?>;
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>index.php/barang_entitas/get_data',
                dataType: 'JSON',
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $.each(data, function(
                        ID_BARANG_ENTITAS,
                        ID_BARANG_MASTER,
                        ID_SPPB,
                        ID_PO,
                        ID_PROYEK,
                        KODE_BARANG_ENTITAS,
                        TANGGAl_PEROLEHAN_HARI,
                        DOK_KARTU_GARANSI,
                        DOK_SERTIFIKAT_PRODUK,
                        DOK_LAINNYA,
                        STATUS_KEPEMILIKAN,
                        JENIS_KEPEMILIKAN,
                        TANGGAL_MULAI_SEWA_HARI,
                        TANGGAL_SELESAI_SEWA_HARI
                    ) {
                        $('[name="ID_BARANG_ENTITAS"]').val(data.ID_BARANG_ENTITAS);
                        $('[name="ID_SPPB"]').val(data.ID_SPPB);
                        $('[name="ID_PO"]').val(data.ID_PO);
                        $('[name="ID_PROYEK"]').val(data.ID_PROYEK);
                        // $('[name="KODE_BARANG_ENTITAS"]').val(data.KODE_BARANG_ENTITAS);
                        document.getElementById("kode_entity").innerHTML = "Kode Entity : " + data.KODE_BARANG_ENTITAS;
                        $('[name="TANGGAl_PEROLEHAN_HARI"]').val(data.TANGGAl_PEROLEHAN_HARI);
                        $('[name="DOK_KARTU_GARANSI"]').val(data.DOK_KARTU_GARANSI);
                        $('[name="DOK_SERTIFIKAT_PRODUK"]').val(data.DOK_SERTIFIKAT_PRODUK);
                        $('[name="DOK_LAINNYA"]').val(data.DOK_LAINNYA);
                        $('[name="STATUS_KEPEMILIKAN"]').val(data.STATUS_KEPEMILIKAN);
                        $('[name="JENIS_KEPEMILIKAN"]').val(data.JENIS_KEPEMILIKAN);
                        $('[name="TANGGAL_MULAI_SEWA_HARI"]').val(data.TANGGAL_MULAI_SEWA_HARI);
                        $('[name="TANGGAL_SELESAI_SEWA_HARI"]').val(data.TANGGAL_SELESAI_SEWA_HARI);
                    });
                }

            });
            return false;
        }

        $('#btn_update').click(function() {
            // let id_barang_master = <?php echo $id_barang_master ?>;
            var form_data = {
                // ID_BARANG_MASTER: id_barang_master,
                ID_BARANG_ENTITAS: $('#ID_BARANG_ENTITAS').val(),
                ID_SPPB: $('#ID_SPPB').val(),
                ID_PO: $('#ID_PO').val(),
                ID_PROYEK: $('#ID_PROYEK').val(),
                // KODE_BARANG_ENTITAS: kode_barang_entitas,
                TANGGAl_PEROLEHAN_HARI: $('#TANGGAl_PEROLEHAN_HARI').val(),
                DOK_KARTU_GARANSI: $('#DOK_KARTU_GARANSI').val(),
                DOK_SERTIFIKAT_PRODUK: $('#DOK_SERTIFIKAT_PRODUK').val(),
                DOK_LAINNYA: $('#DOK_LAINNYA').val(),
                STATUS_KEPEMILIKAN: $('#STATUS_KEPEMILIKAN').val(),
                JENIS_KEPEMILIKAN: $('#JENIS_KEPEMILIKAN').val(),
                TANGGAL_MULAI_SEWA_HARI: $('#TANGGAL_MULAI_SEWA_HARI').val(),
                TANGGAL_SELESAI_SEWA_HARI: $('#TANGGAL_SELESAI_SEWA_HARI').val(),
            };
            $.ajax({
                url: "<?php echo site_url('barang_entitas/update_data'); ?>",
                type: 'POST',
                data: form_data,
                success: function(data) {
                    if (data != '') {
                        $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                    } else {
                        // $('[name="ID_SPPB"]').val("");
                        // $('[name="ID_PO"]').val("");
                        // $('[name="ID_PROYEK"]').val("");
                        // $('[name="TANGGAl_PEROLEHAN_HARI"]').val("");
                        // $('[name="DOK_KARTU_GARANSI"]').val("");
                        // $('[name="SPESIFIKASI_SINGKAT"]').val("");
                        // $('[name="CARA_SINGKAT_PENGGUNAAN"]').val("");
                        // $('[name="CARA_PENYIMPANAN_BARANG"]').val("");
                        // $('[name="KODE_BARANG"]').val("");
                        // $('[name="GAMBAR_1"]').val("");
                        // $('[name="GAMBAR_2"]').val("");
                        // $('[name="GAMBAR_3"]').val("");
                        // $('[name="DOK_BUKU_PANDUAN"]').val("");
                        // $('[name="MASA_PAKAI"]').val("");
                        window.location.href = "<?php echo base_url(); ?>index.php/barang_entitas/list_by_id/<?php echo $id_barang_master ?>";
                    }
                }
            });
            return false;
        });

        // informasi barang slide gambar 
        $('.product-images').slick({
            dots: true
        });
    });
</script>