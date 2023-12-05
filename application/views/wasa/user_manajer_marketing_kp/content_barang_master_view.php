<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>View Barang Master</h2>
        <ol class="breadcrumb">
            <li>
                <a href="index.html">Home</a>
            </li>
            <li>
                <a>Barang Master</a>
            </li>
            <li class="active">
                <strong>View</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div id="alert-msg"></div>
                <div class="ibox-title">
                    <h5>Info Barang</h5>
                </div>
                <div class="ibox-content">
                    <div class="panel-body">
                        <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
                        echo form_open("barang_master/", $attributes); ?>
                        <fieldset class="form-horizontal">
                            <div class="form-group"><label class="col-sm-2 control-label">Id Barang Master :</label>
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Product name" name="ID_BARANG_MASTER" id="ID_BARANG_MASTER" disabled></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Nama Barang Master :</label>
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Contoh : All New Avanza" name="NAMA" id="NAMA" autofocus disabled></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Alias :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Contoh : Avanza, Apanja, Afanza, Afansa" name="ALIAS" id="ALIAS" disabled>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Merek :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Contoh : Toyota" name="MEREK" id="MEREK" disabled>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Jenis Barang :</label>
                                <div class="col-sm-10">
                                    <select name="JENIS_BARANG" class="form-control" id="JENIS_BARANG" disabled>
                                        <option value=''>- Pilih Jenis Barang -</option>
                                        <?php foreach ($jenis_barang as $barang) {
                                            echo '<option value="' . $barang->ID_JENIS_BARANG . '">' . $barang->NAMA_JENIS_BARANG . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Peralatan/Perlengkapan :</label>
                                <div class="col-sm-10">
                                    <select name="PERALATAN_PERLENGKAPAN" class="form-control" id="PERALATAN_PERLENGKAPAN" disabled>
                                        <option value=''>- Pilih -</option>
                                        <option value="Peralatan">Peralatan</option>
                                        <option value="Perlengkapan">Perlengkapan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Satuan Barang :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Contoh : Unit" name="NAMA_SATUAN_BARANG" id="NAMA_SATUAN_BARANG" disabled>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Gross Weight (kg):</label>
                                <div class="col-sm-10">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <input type="text" class="form-control" placeholder="Contoh : 150" name="GROSS_WEIGHT" id="GROSS_WEIGHT" disabled>
                                        </div>
                                        <!-- <div class="col-xs-1">
                                            <select class="form-control" id="ex2">
                                                <option value="TON">ton</option>
                                                <option selected>kg</option>
                                                <option>g</option>
                                            </select>
                                        </div> -->

                                    </div>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Nett Weight (kg):</label>
                                <div class="col-sm-10">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <input type="text" class="form-control" name="NETT_WEIGHT" id="NETT_WEIGHT" placeholder="Contoh : 120" disabled>
                                        </div>
                                        <!-- <div class="col-xs-1">
                                            <select class="form-control" id="ex2">
                                                <option>ton</option>
                                                <option selected>kg</option>
                                                <option>g</option>
                                            </select>
                                        </div> -->

                                    </div>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Dimensi (cm):</label>
                                <div class="col-sm-10">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <label for="DIMENSI_PANJANG">Panjang</label>
                                            <input class="form-control" type="text" placeholder="Contoh : 320" name="DIMENSI_PANJANG" id="DIMENSI_PANJANG" disabled>
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="DIMENSI_LEBAR">Lebar</label>
                                            <input class="form-control" type="text" placeholder="Contoh : 200" name="DIMENSI_LEBAR" id="DIMENSI_LEBAR" disabled>
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="DIMENSI_TINGGI">Tinggi</label>
                                            <input class="form-control" type="text" placeholder="Contoh : 180" name="DIMENSI_TINGGI" id="DIMENSI_TINGGI" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Spesifikasi Lengkap :</label>
                                <div class="col-sm-10">
                                    <textarea disabled class="form-control h-200" name="SPESIFIKASI_LENGKAP" id="SPESIFIKASI_LENGKAP" placeholder="Contoh : Toyota Avanza tersedia dalam pilihan mesin Bensin di Indonesia MPV baru dari Toyota hadir dalam 10 varian. Bicara soal spesifikasi mesin Toyota Avanza, ini ditenagai dua pilihan mesin Bensin berkapasitas 1496 cc. Avanza tersedia dengan transmisi Manual and Otomatis tergantung variannya. Juga, tergantung pilihan dan jenis bahan bakar, konsumsi BBM Avanza mencapai 14.8 kmpl untuk perkotaan. Avanza adalah MPV 7 seater dengan panjang 4190 mm, lebar 1660 mm, wheelbase 2655 mm. serta ground clearance 200 mm." readonly>
                                            </textarea>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Spesifikasi Singkat :</label>
                                <div class="col-sm-10">
                                    <textarea disabled class="form-control h-200" name="SPESIFIKASI_SINGKAT" id="SPESIFIKASI_SINGKAT" placeholder="Contoh : Mesin 1329 cc, Jenis transmisi : Matic" disable>
                                            </textarea>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Cara Singkat Penggunaan :</label>
                                <div class="col-sm-10">
                                    <textarea disabled class="form-control h-150" name="CARA_SINGKAT_PENGGUNAAN" id="CARA_SINGKAT_PENGGUNAAN" placeholder="Contoh : 1. Nyalakan mesin. Injak pedal rem dulu, pastikan tuas transmisi ada di posisi 'P' (Parking). Putar kunci kontak sampai mesin menyala. 2. Perhatikan Posisi Kaki. Gunakan kaki kanan ketika mengemudi mobil matic untuk gas dan rem. " disable>
                                            </textarea>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Cara Penyimpanan Barang :</label>
                                <div class="col-sm-10">
                                    <textarea disabled class="form-control h-150" name="CARA_PENYIMPANAN_BARANG" id="CARA_PENYIMPANAN_BARANG" placeholder="Contoh : Simpan pada tempat seminim mungkin terkena pengaruh cuaca, di dalam bangunan yang teduh dan kering jauh lebih baik. Jika Anda tidak memiliki garasi, Sistem bahan bakar, misalnya, dapat menjadi sumber utama masalah. Pastikan untuk mengendarai mobil selama sekitar 10 mil setelah menambahkan stabilizer agar menyebar atau tercampur dengan baik." disable>
                                            </textarea>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Kode Barang (Generate by System) :</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Kode Barang" value="" name="KODE_BARANG" id="KODE_BARANG" disabled>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Gambar 1:</label>
                                <div class="col-sm-10">
                                    <!-- <img id="imageResult" src="#" alt="" style="width: 20vw;"> -->
                                    <input id="upload" type="file" onchange="readURL(this);" name="GAMBAR_1" disabled>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Gambar 2:</label>
                                <div class="col-sm-10">
                                    <!-- <img id="imageResult" src="#" alt="" style="width: 20vw;"> -->
                                    <input id="upload" type="file" onchange="readURL(this);" name="GAMBAR_2" disabled>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Gambar 3:</label>
                                <div class="col-sm-10">
                                    <!-- <img id="imageResult" src="#" alt="" style="width: 20vw;"> -->
                                    <input id="upload" type="file" onchange="readURL(this);" name="GAMBAR_3" disabled>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Dokumen Buku Panduan :</label>
                                <div class="col-sm-10">
                                    <input type="file" accept="any" disabled>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Masa Pakai :</label>
                                <div class="col-sm-10">
                                    <input disabled type="text" class="form-control" placeholder="Contoh : x Tahun" name="MASA_PAKAI" id="MASA_PAKAI" disable>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                </div>
            </div>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="form-group">
                        <div class="row m-20">
                            <button class="btn btn-danger" id="btn_exit"><i class="fa fa-close"></i> Exit </button>
                        </div>
                    </div>
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

<script>
    $(document).ready(function() {
        tampil_data_barang_master();

        //fungsi tampil data
        function tampil_data_barang_master() {
            var id = <?php echo $id_view ?>;
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>barang_master/get_data',
                dataType: 'JSON',
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $.each(data, function(
                        ID_BARANG_MASTER,
                        NAMA,
                        ALIAS,
                        MEREK,
                        NAMA_SATUAN_BARANG,
                        JENIS_BARANG,
                        PERALATAN_PERLENGKAPAN,
                        GROSS_WEIGHT,
                        NETT_WEIGHT,
                        DIMENSI_PANJANG,
                        DIMENSI_LEBAR,
                        DIMENSI_TINGGI,
                        SPESIFIKASI_LENGKAP,
                        SPESIFIKASI_SINGKAT,
                        CARA_SINGKAT_PENGGUNAAN,
                        CARA_PENYIMPANAN_BARANG,
                        KODE_BARANG,
                        GAMBAR_1,
                        GAMBAR_2,
                        GAMBAR_3,
                        DOK_BUKU_PANDUAN,
                        MASA_PAKAI
                    ) {
                        $('[ID="ID_BARANG_MASTER"]').val(data.ID_BARANG_MASTER);
                        $('[name="NAMA"]').val(data.NAMA);
                        $('[name="ALIAS"]').val(data.ALIAS);
                        $('[name="MEREK"]').val(data.MEREK);
                        $('[name="NAMA_SATUAN_BARANG"]').val(NAMA_SATUAN_BARANG);
                        $('[name="JENIS_BARANG"]').val(data.JENIS_BARANG);
                        $('[name="PERALATAN_PERLENGKAPAN"]').val(data.PERALATAN_PERLENGKAPAN);
                        $('[name="GROSS_WEIGHT"]').val(data.GROSS_WEIGHT);
                        $('[name="NETT_WEIGHT"]').val(data.NETT_WEIGHT);
                        $('[name="DIMENSI_PANJANG"]').val(data.DIMENSI_PANJANG);
                        $('[name="DIMENSI_LEBAR"]').val(data.DIMENSI_LEBAR);
                        $('[name="DIMENSI_TINGGI"]').val(data.DIMENSI_TINGGI);
                        $('[name="SPESIFIKASI_LENGKAP"]').val(data.SPESIFIKASI_LENGKAP);
                        $('[name="SPESIFIKASI_SINGKAT"]').val(data.SPESIFIKASI_SINGKAT);
                        $('[name="CARA_SINGKAT_PENGGUNAAN"]').val(data.CARA_SINGKAT_PENGGUNAAN);
                        $('[name="CARA_PENYIMPANAN_BARANG"]').val(data.CARA_PENYIMPANAN_BARANG);
                        $('[name="KODE_BARANG"]').val(data.KODE_BARANG);
                        $('[name="GAMBAR_1"]').val(data.GAMBAR_1);
                        $('[name="GAMBAR_2"]').val(data.GAMBAR_2);
                        $('[name="GAMBAR_3"]').val(data.GAMBAR_3);
                        $('[name="DOK_BUKU_PANDUAN"]').val(data.DOK_BUKU_PANDUAN);
                        $('[name="MASA_PAKAI"]').val(data.MASA_PAKAI);
                    });
                }

            });
            return false;
        }
     });
</script>


<!-- <script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#imageResult')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script> -->