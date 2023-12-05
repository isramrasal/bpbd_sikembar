 <div class="row wrapper border-bottom white-bg page-heading">
     <div class="col-lg-10">
         <h2>Tambah Barang Master</h2>
         <ol class="breadcrumb">
             <li>
                 <a href="<?php echo base_url() ?>">Home</a>
             </li>
             <li>
                 <a href="<?php echo base_url('index.php/barang_master/') ?>">Master List</a>
             </li>
             <li class="active">
                 <strong>Tambah Barang Master</strong>
             </li>
         </ol>
     </div>
 </div>
 <div class="wrapper wrapper-content animated fadeInRight">
     <div class="row">
         <div class="col-lg-12">
             <div class="ibox float-e-margins">
                 <div class="ibox-title">
                     <h5>Informasi Barang</h5>
                     <hr>
                 </div>
                 <div class="ibox-content">
                     <div class="panel-body">
                         <?php $attributes = array("name" => "contact_form", "id" => "contact_form");
                            echo form_open("barang_master/simpan_data", $attributes); ?>
                         <fieldset class="form-horizontal">
                             <div class="form-group"><label class="col-sm-2 control-label">Nama Barang Master </label>
                                 <div class="col-sm-10"><input type="text" class="form-control" placeholder="Contoh: All New Avanza" name="NAMA" id="NAMA" required autofocus></div>
                             </div>
                             <div class="form-group"><label class="col-sm-2 control-label">Alias</label>
                                 <div class="col-sm-10">
                                     <input type="text" class="form-control" placeholder="Contoh: Avanza, Apanja, Afanza, Afansa" name="ALIAS" id="ALIAS" required>
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
                             <div class="form-group"><label class="col-sm-2 control-label">Tool/Consumable/Material</label>
                                 <div class="col-sm-10">
                                     <select name="PERALATAN_PERLENGKAPAN" class="form-control" id="PERALATAN_PERLENGKAPAN">
                                         <option value=''>- Pilih Tool/Consumable/Material -</option>
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

                             <div class="form-group"><label class="col-sm-2 control-label">Gross Weight(kg)</label>
                                 <div class="col-sm-10">
                                     <div class="form-group row">
                                         <div class="col-xs-2">
                                             <input type="text" class="form-control" placeholder="Contoh: 150" name="GROSS_WEIGHT" id="GROSS_WEIGHT" required>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group"><label class="col-sm-2 control-label">Nett Weight(kg)</label>
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
                                             <input class="form-control" type="number" placeholder="Contoh: 320" name="DIMENSI_PANJANG" id="DIMENSI_PANJANG" required>
                                         </div>
                                         <div class="col-xs-2">
                                             <label for="DIMENSI_LEBAR">Lebar</label>
                                             <input class="form-control" type="number" placeholder="Contoh: 200" name="DIMENSI_LEBAR" id="DIMENSI_LEBAR" required>
                                         </div>
                                         <div class="col-xs-2">
                                             <label for="DIMENSI_TINGGI">Tinggi</label>
                                             <input class="form-control" type="number" placeholder="Contoh: 180" name="DIMENSI_TINGGI" id="DIMENSI_TINGGI" required>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="form-group"><label class="col-sm-2 control-label">Spesifikasi Lengkap</label>
                                 <div class="col-sm-10">
                                     <textarea class="form-control h-200" name="SPESIFIKASI_LENGKAP" id="SPESIFIKASI_LENGKAP" placeholder="Contoh: Toyota Avanza tersedia dalam pilihan mesin Bensin di Indonesia MPV baru dari Toyota hadir dalam 10 varian. Bicara soal spesifikasi mesin Toyota Avanza, ini ditenagai dua pilihan mesin Bensin berkapasitas 1496 cc. Avanza tersedia dengan transmisi Manual and Otomatis tergantung variannya. Juga, tergantung pilihan dan jenis bahan bakar, konsumsi BBM Avanza mencapai 14.8 kmpl untuk perkotaan. Avanza adalah MPV 7 seater dengan panjang 4190 mm, lebar 1660 mm, wheelbase 2655 mm. serta ground clearance 200 mm." required></textarea>
                                 </div>
                             </div>
                             <div class="form-group"><label class="col-sm-2 control-label">Spesifikasi Singkat</label>
                                 <div class="col-sm-10">
                                     <textarea class="form-control h-200" name="SPESIFIKASI_SINGKAT" id="SPESIFIKASI_SINGKAT" placeholder="Contoh : Mesin 1329 cc, Jenis transmisi: Matic" required></textarea>
                                 </div>
                             </div>
                             <div class="form-group"><label class="col-sm-2 control-label">Cara Singkat Penggunaan</label>
                                 <div class="col-sm-10">
                                     <textarea class="form-control h-150" name="CARA_SINGKAT_PENGGUNAAN" id="CARA_SINGKAT_PENGGUNAAN" placeholder="Contoh : 1. Nyalakan mesin. Injak pedal rem dulu, pastikan tuas transmisi ada di posisi 'P' (Parking). Putar kunci kontak sampai mesin menyala. 2. Perhatikan Posisi Kaki. Gunakan kaki kanan ketika mengemudi mobil matic untuk gas dan rem. " required></textarea>
                                 </div>
                             </div>
                             <div class="form-group"><label class="col-sm-2 control-label">Cara Penyimpanan Barang</label>
                                 <div class="col-sm-10">
                                     <textarea class="form-control h-150" name="CARA_PENYIMPANAN_BARANG" id="CARA_PENYIMPANAN_BARANG" placeholder="Contoh : Simpan pada tempat seminim mungkin terkena pengaruh cuaca, di dalam bangunan yang teduh dan kering jauh lebih baik. Jika Anda tidak memiliki garasi, Sistem bahan bakar, misalnya, dapat menjadi sumber utama masalah. Pastikan untuk mengendarai mobil selama sekitar 10 mil setelah menambahkan stabilizer agar menyebar atau tercampur dengan baik." required></textarea>
                                 </div>
                             </div>
                             <div class="form-group"><label class="col-sm-2 control-label">Kode Barang</label>
                                 <div class="col-sm-10">
                                     <input type="text" class="form-control" placeholder="Contoh : WME-ACVR-MAT-10000N" value="" name="KODE_BARANG" id="KODE_BARANG">
                                 </div>
                             </div>
                             <div class="form-group"><label class="col-sm-2 control-label">Masa Pakai</label>
                                 <div class="col-sm-10">
                                     <input type="text" class="form-control" placeholder="Contoh : 4 Tahun atau T4" name="MASA_PAKAI" id="MASA_PAKAI" required>
                                 </div>
                             </div>
                         </fieldset>
                     </div>

                     <div class="alert alert-info alert-dismissable">
                         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                         Upload file dokumen dilakukan di halaman profil barang master.
                     </div>
                     </break>

                     <button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
                 </div>
             </div>
             <div id="alert-msg"></div>

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
         //SIMPAN DATA
         $('#btn_simpan').click(function() {
             var form_data = {
                 NAMA: $('#NAMA').val(),
                 ALIAS: $('#ALIAS').val(),
                 MEREK: $('#MEREK').val(),
                 NAMA_SATUAN_BARANG: $('#NAMA_SATUAN_BARANG').val(),
                 JENIS_BARANG: $('#JENIS_BARANG').val(),
                 PERALATAN_PERLENGKAPAN: $('#PERALATAN_PERLENGKAPAN').val(),
                 GROSS_WEIGHT: $('#GROSS_WEIGHT').val(),
                 NETT_WEIGHT: $('#NETT_WEIGHT').val(),
                 DIMENSI_PANJANG: $('#DIMENSI_PANJANG').val(),
                 DIMENSI_LEBAR: $('#DIMENSI_LEBAR').val(),
                 DIMENSI_TINGGI: $('#DIMENSI_TINGGI').val(),
                 SPESIFIKASI_LENGKAP: $('#SPESIFIKASI_LENGKAP').val(),
                 SPESIFIKASI_SINGKAT: $('#SPESIFIKASI_SINGKAT').val(),
                 CARA_SINGKAT_PENGGUNAAN: $('#CARA_SINGKAT_PENGGUNAAN').val(),
                 CARA_PENYIMPANAN_BARANG: $('#CARA_PENYIMPANAN_BARANG').val(),
                 KODE_BARANG: $('#KODE_BARANG').val(),
                 GAMBAR_1: $('#GAMBAR_1').val(),
                 GAMBAR_2: $('#GAMBAR_2').val(),
                 GAMBAR_3: $('#GAMBAR_3').val(),
                 DOK_BUKU_PANDUAN: $('#DOK_BUKU_PANDUAN').val(),
                 MASA_PAKAI: $('#MASA_PAKAI').val(),
             };
             $.ajax({
                 url: "<?php echo site_url('barang_master/simpan_data'); ?>",
                 type: 'POST',
                 data: form_data,
                 success: function(data) {
                     if (data != '') {
                         $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
                     } else {
                         window.location.href = "<?php echo base_url(); ?>index.php/barang_master";
                     }
                 }
             });
             return false;
         });
     });
 </script>