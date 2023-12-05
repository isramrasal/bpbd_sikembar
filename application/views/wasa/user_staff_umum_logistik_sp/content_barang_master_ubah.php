<div class="row wrapper border-bottom white-bg page-heading">
<div class="col-lg-10">
         <h2>Ubah Barang Master</h2>
         <ol class="breadcrumb">
             <li>
                 <a href="index.html">Home</a>
             </li>
             <li>
                <strong>
                <a href="<?php echo base_url('index.php/barang_master/') ?>">Barang Master</a>	
                </strong>
            </li>
             <li class="active">
                 <strong>Ubah</strong>
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
                <h5>Informasi Barang</h5>
                </div>
                <div class="ibox-content">
                    <div class="panel-body">
                        <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
                        echo form_open("barang_master/update_data", $attributes); ?>
                        <fieldset class="form-horizontal">
                            <input type="hidden" class="form-control" placeholder="Product name" name="ID_BARANG_MASTER" id="ID_BARANG_MASTER" required disabled>
                            
                            <div class="form-group"><label class="col-sm-2 control-label">Nama Barang Master</label>
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Contoh: All New Avanza" name="NAMA" id="NAMA" required autofocus></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Alias</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Contoh  Avanza, Apanja, Afanza, Afansa" name="ALIAS" id="ALIAS" required>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Merek</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Contoh: Toyota" name="MEREK" id="MEREK" required>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Jenis Barang</label>
                                <div class="col-sm-10">
                                    <select name="JENIS_BARANG" class="form-control" id="JENIS_BARANG">
                                        <option value=''>- Pilih Jenis Barang -</option>
                                        <?php foreach ($jenis_barang as $barang) {
                                            echo '<option value="' . $barang->ID_JENIS_BARANG . '">' . $barang->NAMA_JENIS_BARANG . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="form-group"><label class="col-sm-2 control-label">Peralatan/Perlengkapan</label>
                                <div class="col-sm-10">
                                    <select name="PERALATAN_PERLENGKAPAN" class="form-control" id="PERALATAN_PERLENGKAPAN">
                                        <option value=''>- Pilih -</option>
                                        <option value="Peralatan">Peralatan</option>
                                        <option value="Perlengkapan">Perlengkapan</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="form-group"><label class="col-sm-2 control-label">Tool/Consumable/Material</label>
                                 <div class="col-sm-10">
                                     <select name="PERALATAN_PERLENGKAPAN" class="form-control" id="PERALATAN_PERLENGKAPAN">
                                         <option value=''>- Pilih -</option>
                                         <option value="TOOL">TOOL</option>
                                         <option value="CONSUMABLE">CONSUMABLE</option>
                                         <option value="MATERIAL">MATERIAL</option>
                                     </select>
                                 </div>
                             </div>

                            <div class="form-group"><label class="col-sm-2 control-label">Satuan Barang</label>
                                <div class="col-sm-10">
                                    <select name="NAMA_SATUAN_BARANG" class="form-control" id="NAMA_SATUAN_BARANG">
                                        <option value=''>- Pilih Satuan Barang -</option>
                                        <?php foreach ($satuan_barang as $barang) {
                                            echo '<option value="' . $barang->ID_SATUAN_BARANG . '">' . $barang->NAMA_SATUAN_BARANG . '</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label">Gross Weight (kg)</label>
                                <div class="col-sm-10">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <input type="text" class="form-control" placeholder="Contoh: 150" name="GROSS_WEIGHT" id="GROSS_WEIGHT" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Nett Weight (kg)</label>
                                <div class="col-sm-10">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <input type="text" class="form-control" name="NETT_WEIGHT" id="NETT_WEIGHT" placeholder="Contoh: 120" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Dimensi (cm)</label>
                                <div class="col-sm-10">
                                    <div class="form-group row">
                                        <div class="col-xs-2">
                                            <label for="DIMENSI_PANJANG">Panjang</label>
                                            <input class="form-control" type="text" placeholder="Contoh: 320" name="DIMENSI_PANJANG" id="DIMENSI_PANJANG" required>
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="DIMENSI_LEBAR">Lebar</label>
                                            <input class="form-control" type="text" placeholder="Contoh: 200" name="DIMENSI_LEBAR" id="DIMENSI_LEBAR" required>
                                        </div>
                                        <div class="col-xs-2">
                                            <label for="DIMENSI_TINGGI">Tinggi</label>
                                            <input class="form-control" type="text" placeholder="Contoh: 180" name="DIMENSI_TINGGI" id="DIMENSI_TINGGI" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Spesifikasi Lengkap</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control h-200" name="SPESIFIKASI_LENGKAP" id="SPESIFIKASI_LENGKAP" placeholder="Contoh : Toyota Avanza tersedia dalam pilihan mesin Bensin di Indonesia MPV baru dari Toyota hadir dalam 10 varian. Bicara soal spesifikasi mesin Toyota Avanza, ini ditenagai dua pilihan mesin Bensin berkapasitas 1496 cc. Avanza tersedia dengan transmisi Manual and Otomatis tergantung variannya. Juga, tergantung pilihan dan jenis bahan bakar, konsumsi BBM Avanza mencapai 14.8 kmpl untuk perkotaan. Avanza adalah MPV 7 seater dengan panjang 4190 mm, lebar 1660 mm, wheelbase 2655 mm. serta ground clearance 200 mm." required>
                                            </textarea>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Spesifikasi Singkat </label>
                                <div class="col-sm-10">
                                    <textarea class="form-control h-200" name="SPESIFIKASI_SINGKAT" id="SPESIFIKASI_SINGKAT" placeholder="Contoh: Mesin 1329 cc, Jenis transmisi: Matic" required>
                                            </textarea>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Cara Singkat Penggunaan</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control h-150" name="CARA_SINGKAT_PENGGUNAAN" id="CARA_SINGKAT_PENGGUNAAN" placeholder="Contoh: 1. Nyalakan mesin. Injak pedal rem dulu, pastikan tuas transmisi ada di posisi 'P' (Parking). Putar kunci kontak sampai mesin menyala. 2. Perhatikan Posisi Kaki. Gunakan kaki kanan ketika mengemudi mobil matic untuk gas dan rem. " required>
                                            </textarea>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Cara Penyimpanan Barang</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control h-150" name="CARA_PENYIMPANAN_BARANG" id="CARA_PENYIMPANAN_BARANG" placeholder="Contoh: Simpan pada tempat seminim mungkin terkena pengaruh cuaca, di dalam bangunan yang teduh dan kering jauh lebih baik. Jika Anda tidak memiliki garasi, Sistem bahan bakar, misalnya, dapat menjadi sumber utama masalah. Pastikan untuk mengendarai mobil selama sekitar 10 mil setelah menambahkan stabilizer agar menyebar atau tercampur dengan baik." required>
                                            </textarea>
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Kode Barang (Generate by System)</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Kode Barang" value="" name="KODE_BARANG" id="KODE_BARANG">
                                </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label">Masa Pakai</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="Contoh: x Tahun" name="MASA_PAKAI" id="MASA_PAKAI" required>
                                </div>
                            </div>
                            <div class="alert alert-info alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                Upload file dokumen dilakukan di halaman profil barang master.
                            </div>
                        </fieldset>
                    </div>
                    <button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Simpan</button>
                </div>
            </div>
            <div id="alert-msg-2"></div>

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
            var id = "<?php echo $ID_HASH_MD5_BARANG_MASTER; ?>";
            
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
                        MASA_PAKAI
                    ) {
                        $('[ID="ID_BARANG_MASTER"]').val(data.ID_BARANG_MASTER);
                        $('[name="NAMA"]').val(data.NAMA);
                        $('[name="ALIAS"]').val(data.ALIAS);
                        $('[name="MEREK"]').val(data.MEREK);
                        $('[name="NAMA_SATUAN_BARANG"]').val(data.NAMA_SATUAN_BARANG);
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
                        $('[name="MASA_PAKAI"]').val(data.MASA_PAKAI);
                    });
                }

            });
            return false;
        }

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            var ID_BARANG_MASTER = $('#ID_BARANG_MASTER').val();
            var NAMA = $('#NAMA').val();
            var ALIAS = $('#ALIAS').val();
            var MEREK = $('#MEREK').val();
            var NAMA_SATUAN_BARANG = $('#NAMA_SATUAN_BARANG').val();
            var JENIS_BARANG = $('#JENIS_BARANG').val();
            var PERALATAN_PERLENGKAPAN = $('#PERALATAN_PERLENGKAPAN').val();
            var GROSS_WEIGHT = $('#GROSS_WEIGHT').val();
            var NETT_WEIGHT = $('#NETT_WEIGHT').val();
            var DIMENSI_PANJANG = $('#DIMENSI_PANJANG').val();
            var DIMENSI_LEBAR = $('#DIMENSI_LEBAR').val();
            var DIMENSI_TINGGI = $('#DIMENSI_TINGGI').val();
            var SPESIFIKASI_LENGKAP = $('#SPESIFIKASI_LENGKAP').val();
            var SPESIFIKASI_SINGKAT = $('#SPESIFIKASI_SINGKAT').val();
            var CARA_SINGKAT_PENGGUNAAN = $('#CARA_SINGKAT_PENGGUNAAN').val();
            var CARA_PENYIMPANAN_BARANG = $('#CARA_PENYIMPANAN_BARANG').val();
            var KODE_BARANG = $('#KODE_BARANG').val();
            var MASA_PAKAI = $('#MASA_PAKAI').val();
            $.ajax({
                url: "<?php echo site_url('barang_master/update_data') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_BARANG_MASTER: ID_BARANG_MASTER,
                    NAMA: NAMA,
                    ALIAS: ALIAS,
                    MEREK: MEREK,
                    NAMA_SATUAN_BARANG: NAMA_SATUAN_BARANG,
                    JENIS_BARANG: JENIS_BARANG,
                    PERALATAN_PERLENGKAPAN: PERALATAN_PERLENGKAPAN,
                    GROSS_WEIGHT: GROSS_WEIGHT,
                    NETT_WEIGHT: NETT_WEIGHT,
                    DIMENSI_PANJANG: DIMENSI_PANJANG,
                    DIMENSI_LEBAR: DIMENSI_LEBAR,
                    DIMENSI_TINGGI: DIMENSI_TINGGI,
                    SPESIFIKASI_LENGKAP: SPESIFIKASI_LENGKAP,
                    SPESIFIKASI_SINGKAT: SPESIFIKASI_SINGKAT,
                    CARA_SINGKAT_PENGGUNAAN: CARA_SINGKAT_PENGGUNAAN,
                    CARA_PENYIMPANAN_BARANG: CARA_PENYIMPANAN_BARANG,
                    KODE_BARANG: KODE_BARANG,
                    MASA_PAKAI: MASA_PAKAI
                },
                success: function(data) {
                    console.log(data);
                    if (data == true) {
                        window.location.href = "<?php echo base_url(); ?>index.php/barang_master";
                        $('[name="ID_BARANG_MASTER"]').val('');
                        $('[name="NAMA"]').val(data.NAMA);
                        $('[name="ALIAS"]').val(data.ALIAS);
                        $('[name="MEREK"]').val(data.MEREK);
                        $('[name="NAMA_SATUAN_BARANG"]').val(data.NAMA_SATUAN_BARANG);
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
                        $('[name="MASA_PAKAI"]').val(data.MASA_PAKAI);
                        // window.location.reload();
                    } else {
                        $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
        });
    });
</script>

	
	<script>
        $(document).ready(function(){
            $('.file-box').each(function() {
                animationHover(this, 'pulse');
            });
        });
    </script>
