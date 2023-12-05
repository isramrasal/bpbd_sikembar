<div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="search_results.html">

            </form>
        </div>
            <ul class="nav navbar-top-links navbar-right">
				<li>
                    <a href="<?php echo base_url(); ?>index.php/auth/logout">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>

        </nav>
        </div>
            
        <div class="wrapper wrapper-content animated fadeInRight">
			
			<div class="alert alert-info alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				Sistem menampilkan nama pegawai calon seleksi promosi jabatan .
			</div>
			
            <div class="row">
                <div class="col-lg-12">
						<div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1">Maksud dan Tujuan</a></li>
							<li class=""><a data-toggle="tab" href="#tab-2">Tanggal Dibutuhkan</a></li>
							<li class=""><a data-toggle="tab" href="#tab-3">Jabatan</a></li>
							<li class=""><a data-toggle="tab" href="#tab-4">Kualifikasi Pendidikan</a></li>
							<li class=""><a data-toggle="tab" href="#tab-5">Kualifikasi Lama Kerja</a></li>
							<li class=""><a data-toggle="tab" href="#tab-6">Kualifikasi Umur</a></li>
                        </ul>
						<?php foreach($SELEKSI_JABATAN as $sel_jab){ ?>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane active">
                                <div class="panel-body">
									<p>Kode Seleksi Jabatan: <?php echo $sel_jab->KODE_SJ; ?></p>
									</br>
                                    <p>Maksud dan Tujuan: <?php echo $sel_jab->MAKSUD_TUJUAN; ?></p>
									</br>
									<p>Untuk ditempatkan di departemen <?php echo $sel_jab->NAMA_DEPARTEMEN; ?></p>
                                </div>
                            </div>
							<div id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <p><?php echo $sel_jab->TANGGAL_DIBUTUHKAN; ?></p>
                                </div>
                            </div>
							<div id="tab-3" class="tab-pane">
                                <div class="panel-body">
                                    <p><?php echo $sel_jab->NAMA_JABATAN; ?></p>
                                </div>
                            </div>
							<div id="tab-4" class="tab-pane">
                                <div class="panel-body">
                                    <p><?php echo $sel_jab->KUALIFIKASI_PENDIDIKAN; ?></p>
                                </div>
                            </div>
							<div id="tab-5" class="tab-pane">
                                <div class="panel-body">
                                    <p>Minimal telah bekerja selama <?php echo $sel_jab->KUALIFIKASI_LAMA_KERJA; ?> bulan</p>
                                </div>
                            </div>
							<div id="tab-6" class="tab-pane">
                                <div class="panel-body">
                                    <p>Umur minimal <?php echo $sel_jab->MINIMAL_UMUR_KARYAWAN; ?> tahun</p>
									</br>
									<p>Umur maksimal <?php echo $sel_jab->MAKSIMAL_UMUR_KARYAWAN; ?> tahun</p>
                                </div>
                            </div>
                        </div>
						<?php } ?>

						</br>
                    </div>
					
					<div class="alert alert-warning alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Pastikan Anda mengisi data dengan benar.
					</div>
					
				<?php echo form_open("input_skoring/update_data");?>
				
				<input name="KODE_SJ" id="KODE_SJ" class="form-control" type="hidden" value="<?php echo $sel_jab->KODE_SJ; ?>">
				
				<?php foreach($DATA_PEGAWAI as $data_pegawai){ ?>
				
				<?php 
				
				$NIP = $data_pegawai->NIP;
				
				
				$hsl_1=$this->db->query("SELECT ID_PEGAWAI, JENIS_KELAMIN, STATUS_PERNIKAHAN,  TIMESTAMPDIFF(YEAR, TANGGAL_LAHIR, CURDATE()) AS UMUR, TIMESTAMPDIFF(MONTH, TANGGAL_STATUS_KONTRAK, CURDATE()) AS LAMA_BEKERJA_KONTRAK FROM ws_pegawai WHERE NIP='$NIP'");
					if($hsl_1->num_rows()>0){
						foreach ($hsl_1->result() as $data_peg_1) {
							$hasil_1=array(
								'ID_PEGAWAI' => $data_peg_1->ID_PEGAWAI,
								'JENIS_KELAMIN' => $data_peg_1->JENIS_KELAMIN,
								'STATUS_PERNIKAHAN' => $data_peg_1->STATUS_PERNIKAHAN,
								'UMUR' => $data_peg_1->UMUR,
								'LAMA_BEKERJA_KONTRAK' => $data_peg_1->LAMA_BEKERJA_KONTRAK
								);
						}
					}
				
				$ID_PEGAWAI = $hasil_1['ID_PEGAWAI'];
					
				$hsl_2=$this->db->query("SELECT COUNT(*) AS JUMLAH FROM ws_pelatihan WHERE ( `KETERANGAN` = 'TERSERTIFIKASI' AND `ID_PEGAWAI` = '$ID_PEGAWAI' )");
					if($hsl_2->num_rows()>0){
						foreach ($hsl_2->result() as $data_peg_2) {
							$hasil_2=array(
								'JUMLAH' => $data_peg_2->JUMLAH
								);
						}
					}
					
				$hsl_3=$this->db->query("SELECT * FROM ws_pendidikan WHERE KODE_JENJANG_PENDIDIKAN = (SELECT MAX(KODE_JENJANG_PENDIDIKAN) FROM ws_pendidikan WHERE `ID_PEGAWAI` = '$ID_PEGAWAI')");
					if($hsl_3->num_rows()>0){
						foreach ($hsl_3->result() as $data_peg_3) {
							$hasil_3=array(
								'JENJANG_PENDIDIKAN' => $data_peg_3->JENJANG_PENDIDIKAN,
								'KODE_JENJANG_PENDIDIKAN' => $data_peg_3->KODE_JENJANG_PENDIDIKAN
								);
						}
					}
					
				//var_dump($hsl_3);
				?>
				
				<input name="NIP[]" id="NIP" class="form-control" type="hidden" value="<?php echo $NIP; ?>">
				

				 <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5><?php echo $data_pegawai->NAMA; ?> - <?php echo $data_pegawai->NIP; ?></h5>
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
						<table class="table">
                            <thead>
                            <tr>
                                <th>Penilaian</th>
                                <th>Bobot</th>
                                <th>Data Aktual</th>
                                <th>Nilai</th>
								<th>Keterangan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Pendidikan</td>
                                <td><?php echo $DATA_BOBOT['BOBOT_PENILAIAN_PENDIDIKAN']."%"; ?></td>
								<input name="BOBOT_PENILAIAN_PENDIDIKAN[]" id="BOBOT_PENILAIAN_PENDIDIKAN" class="form-control" type="hidden" value="<?php echo $DATA_BOBOT['BOBOT_PENILAIAN_PENDIDIKAN']; ?>">
                                <td><?php echo $hasil_3['JENJANG_PENDIDIKAN']; ?></td>
								<?php 
								if ($hasil_3['KODE_JENJANG_PENDIDIKAN'] == '1')
								{
									$nilai_pendidikan = 0.4;
								}
								else if ($hasil_3['KODE_JENJANG_PENDIDIKAN'] == '2')
								{
									$nilai_pendidikan = 0.5;
								}
								else if ($hasil_3['KODE_JENJANG_PENDIDIKAN'] == '3')
								{
									$nilai_pendidikan = 0.6;
								}
								else if ($hasil_3['KODE_JENJANG_PENDIDIKAN'] == '4')
								{
									$nilai_pendidikan = 0.7;
								}
								else if ($hasil_3['KODE_JENJANG_PENDIDIKAN'] == '5')
								{
									$nilai_pendidikan = 0.8;
								}
								else if ($hasil_3['KODE_JENJANG_PENDIDIKAN'] == '5')
								{
									$nilai_pendidikan = 0.9;
								}
								else if ($hasil_3['KODE_JENJANG_PENDIDIKAN'] == '6')
								{
									$nilai_pendidikan = 1;
								}
								?>
                                <td><input type="text" name="nilai_pendidikan[]" id="nilai_pendidikan" value="<?php echo $nilai_pendidikan; ?>" disabled /></td>
								<td>-</td>
                            </tr>
							
							
                            <tr>
                                <td>Lama Kerja</td>
                                <td><?php echo $DATA_BOBOT['BOBOT_PENILAIAN_PENGALAMAN_KERJA']."%"; ?></td>
								<input name="BOBOT_PENILAIAN_PENGALAMAN_KERJA[]" id="BOBOT_PENILAIAN_PENGALAMAN_KERJA" class="form-control" type="hidden" value="<?php echo $DATA_BOBOT['BOBOT_PENILAIAN_PENGALAMAN_KERJA']; ?>">
                                <td><?php echo floor($hasil_1['LAMA_BEKERJA_KONTRAK']/12); ?> tahun</td>
								<?php 
								if (floor($hasil_1['LAMA_BEKERJA_KONTRAK']/12) > 10)
								{
									$nilai_lama_kerja = 1;
								}
								else if ((floor($hasil_1['LAMA_BEKERJA_KONTRAK']/12) <= 10) AND (floor($hasil_1['LAMA_BEKERJA_KONTRAK']/12) > 8) )
								{
									$nilai_lama_kerja = 0.8;
								}
								else if ((floor($hasil_1['LAMA_BEKERJA_KONTRAK']/12) <= 8) AND (floor($hasil_1['LAMA_BEKERJA_KONTRAK']/12) > 6) )
								{
									$nilai_lama_kerja = 0.6;
								}
								else if ((floor($hasil_1['LAMA_BEKERJA_KONTRAK']/12) <= 6) AND (floor($hasil_1['LAMA_BEKERJA_KONTRAK']/12) > 4) )
								{
									$nilai_lama_kerja = 0.4;
								}
								else
								{
									$nilai_lama_kerja = 0.2;
								}
								//var_dump($nilai_lama_kerja);
								?>
								
								
                                <td><input type="text" name="nilai_lama_kerja[]" id="nilai_lama_kerja" value="<?php echo $nilai_lama_kerja; ?>" disabled /></td>
								<td>-</td>
                            </tr>
                            <tr>
                                <td>Sertifikasi</td>
                                <td><?php echo $DATA_BOBOT['BOBOT_PENILAIAN_SERTIFIKASI']."%"; ?></td>
								<input name="BOBOT_PENILAIAN_SERTIFIKASI[]" id="BOBOT_PENILAIAN_SERTIFIKASI" class="form-control" type="hidden" value="<?php echo $DATA_BOBOT['BOBOT_PENILAIAN_SERTIFIKASI']; ?>">
                                <td>
								<?php if($hasil_2['JUMLAH'] > 0)
								{
									echo "Memiliki";
									$nilai_sertifikasi = 1;
								}
								else
								{
									echo "Tidak Memiliki";
									$nilai_sertifikasi = 0.2;
								}
								?>
								
								</td>
                                <td><input type="text" name="nilai_sertifikasi[]" id="nilai_sertifikasi" value="<?php echo $nilai_sertifikasi; ?>" disabled /></td>
								<td>-</td>
                            </tr>
							<tr>
                                <td>Wawancara</td>
                                <td><?php echo $DATA_BOBOT['BOBOT_PENILAIAN_WAWANCARA']."%"; ?></td>
								<input name="BOBOT_PENILAIAN_WAWANCARA[]" id="BOBOT_PENILAIAN_WAWANCARA" class="form-control" type="hidden" value="<?php echo $DATA_BOBOT['BOBOT_PENILAIAN_WAWANCARA']; ?>">
                                <td>-</td>
                                <td><input type="number" name="nilai_wawancara[]" id="nilai_wawancara[]" placeholder="Input nilai wawancara" min="1" max="100" /></td>
								<td>Nilai antara 0 - 100</td>
                            </tr>
							<tr>
                                <td>Ujian</td>
                                <td><?php echo $DATA_BOBOT['BOBOT_PENILAIAN_UJIAN']."%"; ?></td>
								<input name="BOBOT_PENILAIAN_UJIAN[]" id="BOBOT_PENILAIAN_UJIAN" class="form-control" type="hidden" value="<?php echo $DATA_BOBOT['BOBOT_PENILAIAN_UJIAN']; ?>">
                                <td>-</td>
                                <td><input type="number" name="nilai_ujian[]" id="nilai_ujian[]" placeholder="Input nilai ujian" min="1" max="100" /> </td>
								<td>Nilai antara 0 - 100</td>
                            </tr>
							<tr>
                                <td>Usia</td>
                                <td><?php echo $DATA_BOBOT['BOBOT_PENILAIAN_USIA']."%"; ?></td>
								<input name="BOBOT_PENILAIAN_USIA[]" id="BOBOT_PENILAIAN_USIA" class="form-control" type="hidden" value="<?php echo $DATA_BOBOT['BOBOT_PENILAIAN_USIA']; ?>">
                                <td><?php echo $hasil_1['UMUR']; ?> tahun</td>
								
								<?php 
								if (floor($hasil_1['UMUR']) > 37)
								{
									$nilai_usia = 0.8;
								}
								else if ((floor($hasil_1['UMUR']) <= 27) AND (floor($hasil_1['UMUR']) > 37) )
								{
									$nilai_usia = 1;
								}
								else
								{
									$nilai_usia = 0.6;
								}
								//var_dump($nilai_usia);
								?>
								
								
                                <td><input type="text" name="nilai_usia[]" id="nilai_usia" value="<?php echo $nilai_usia; ?>" disabled /></td>
								<td>-</td>
                            </tr>
							<tr>
                                <td>Jenis Kelamin</td>
                                <td><?php echo $DATA_BOBOT['BOBOT_PENILAIAN_JENIS_KELAMIN']."%"; ?></td>
								<input name="BOBOT_PENILAIAN_JENIS_KELAMIN[]" id="BOBOT_PENILAIAN_JENIS_KELAMIN" class="form-control" type="hidden" value="<?php echo $DATA_BOBOT['BOBOT_PENILAIAN_JENIS_KELAMIN']; ?>">
                                <td><?php echo $hasil_1['JENIS_KELAMIN']; ?></td>
								
								<?php 
								if ($hasil_1['JENIS_KELAMIN'] == 'Pria')
								{
									$nilai_jenis_kelamin = 0.8;
								}
								else
								{
									$nilai_jenis_kelamin = 0.6;
								}
								//var_dump($nilai_jenis_kelamin);
								?>
								
                                <td><input type="text" name="nilai_jenis_kelamin[]" name="nilai_jenis_kelamin" value="<?php echo $nilai_jenis_kelamin; ?>" disabled /></td>
								<td>-</td>
                            </tr>
							<tr>
                                <td>Status Pernikahan</td>
                                <td><?php echo $DATA_BOBOT['BOBOT_PENILAIAN_STATUS_PERNIKAHAN']."%"; ?></td>
								<input name="BOBOT_PENILAIAN_STATUS_PERNIKAHAN[]" id="BOBOT_PENILAIAN_STATUS_PERNIKAHAN" class="form-control" type="hidden" value="<?php echo $DATA_BOBOT['BOBOT_PENILAIAN_STATUS_PERNIKAHAN']; ?>">
                                <td><?php echo $hasil_1['STATUS_PERNIKAHAN']; ?></td>
								
								<?php 
								if ($hasil_1['STATUS_PERNIKAHAN'] == 'Lajang')
								{
									$nilai_status_pernikahan = 1;
								}
								else if ($hasil_1['STATUS_PERNIKAHAN'] == 'Menikah')
								{
									$nilai_status_pernikahan = 0.6;
								}
								else
								{
									$nilai_status_pernikahan = 0.8;
								}
								//var_dump($nilai_jenis_kelamin);
								?>
								
                                <td><input type="text" name="nilai_status_pernikahan[]" name="nilai_status_pernikahan" value="<?php echo $nilai_status_pernikahan; ?>" disabled /></td>
								<td>-</td>
                            </tr>
                            </tbody>
                        </table>
					
                    </div>
					
                </div>
				
				<?php } ?>
				
						
				<div id="alert-msg"></div>
				
				<button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Simpan</button>
				
				<?php echo form_close(); ?> 
				

				
				
            </div>
            </div>
        </div>
		</br>
		</br>
		
        <div class="footer">
			<div>
				<p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br/> Hak cipta dilindungi undang-undang.</p>
			</div> 
        </div>

        </div>
        </div>
		
		
    <!-- Mainly scripts -->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/wasa/dataTableBaru/jquery-1.11.0.js.download"></script>
	
    <script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- dataTables -->
	
	<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/wasa/dataTableBaru/dataTables.checkboxes.min.js.download"></script>
	
    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>
	
    <!-- Page-Level Scripts -->
    <script type="text/javascript">
		
	$(document).ready(function() {
		
		
		//SIMPAN DATA
		$('#btn_update').click(function() {
			var KODE_SJ=$('#KODE_SJ').val();
			
			var NIP = [];
				$('input[name="NIP[]"]').each( function() {
					NIP.push(this.value);
				});
			var BOBOT_PENILAIAN_PENDIDIKAN = [];
				$('input[name="BOBOT_PENILAIAN_PENDIDIKAN[]"]').each( function() {
					BOBOT_PENILAIAN_PENDIDIKAN.push(this.value);
				});
			var nilai_pendidikan = [];
				$('input[name="nilai_pendidikan[]"]').each( function() {
					nilai_pendidikan.push(this.value);
				});
				
			var BOBOT_PENILAIAN_PENGALAMAN_KERJA = [];
				$('input[name="BOBOT_PENILAIAN_PENGALAMAN_KERJA[]"]').each( function() {
					BOBOT_PENILAIAN_PENGALAMAN_KERJA.push(this.value);
				});
			var nilai_lama_kerja = [];
				$('input[name="nilai_lama_kerja[]"]').each( function() {
					nilai_lama_kerja.push(this.value);
				});
				
			var BOBOT_PENILAIAN_SERTIFIKASI = [];
				$('input[name="BOBOT_PENILAIAN_SERTIFIKASI[]"]').each( function() {
					BOBOT_PENILAIAN_SERTIFIKASI.push(this.value);
				});
			var nilai_sertifikasi = [];
				$('input[name="nilai_sertifikasi[]"]').each( function() {
					nilai_sertifikasi.push(this.value);
				});
				
			var BOBOT_PENILAIAN_WAWANCARA = [];
				$('input[name="BOBOT_PENILAIAN_WAWANCARA[]"]').each( function() {
					BOBOT_PENILAIAN_WAWANCARA.push(this.value);
				});
			var nilai_wawancara = [];
				$('input[name="nilai_wawancara[]"]').each( function() {
					nilai_wawancara.push(this.value);
				});
			
			var BOBOT_PENILAIAN_UJIAN = [];
				$('input[name="BOBOT_PENILAIAN_UJIAN[]"]').each( function() {
					BOBOT_PENILAIAN_UJIAN.push(this.value);
				});
			var nilai_ujian = [];
				$('input[name="nilai_ujian[]"]').each( function() {
					nilai_ujian.push(this.value);
				});
			
			var BOBOT_PENILAIAN_USIA = [];
				$('input[name="BOBOT_PENILAIAN_USIA[]"]').each( function() {
					BOBOT_PENILAIAN_USIA.push(this.value);
				});
			var nilai_usia = [];
				$('input[name="nilai_usia[]"]').each( function() {
					nilai_usia.push(this.value);
				});
			
			var BOBOT_PENILAIAN_JENIS_KELAMIN = [];
				$('input[name="BOBOT_PENILAIAN_JENIS_KELAMIN[]"]').each( function() {
					BOBOT_PENILAIAN_JENIS_KELAMIN.push(this.value);
				});
			var nilai_jenis_kelamin = [];
				$('input[name="nilai_jenis_kelamin[]"]').each( function() {
					nilai_jenis_kelamin.push(this.value);
				});	
			
			var BOBOT_PENILAIAN_STATUS_PERNIKAHAN = [];
				$('input[name="BOBOT_PENILAIAN_STATUS_PERNIKAHAN[]"]').each( function() {
					BOBOT_PENILAIAN_STATUS_PERNIKAHAN.push(this.value);
				});
			var nilai_status_pernikahan = [];
				$('input[name="nilai_status_pernikahan[]"]').each( function() {
					nilai_status_pernikahan.push(this.value);
				});	
			
			$.ajax({
					url: "<?php echo site_url('input_skoring/update_data'); ?>",
					type: 'post',
					data: {
					KODE_SJ:KODE_SJ,
					NIP:NIP,
					BOBOT_PENILAIAN_PENDIDIKAN:BOBOT_PENILAIAN_PENDIDIKAN,
					nilai_pendidikan:nilai_pendidikan,
					BOBOT_PENILAIAN_PENGALAMAN_KERJA:BOBOT_PENILAIAN_PENGALAMAN_KERJA,
					nilai_lama_kerja:nilai_lama_kerja,
					BOBOT_PENILAIAN_SERTIFIKASI:BOBOT_PENILAIAN_SERTIFIKASI,
					nilai_sertifikasi:nilai_sertifikasi,
					BOBOT_PENILAIAN_WAWANCARA:BOBOT_PENILAIAN_WAWANCARA,
					nilai_wawancara:nilai_wawancara,
					BOBOT_PENILAIAN_UJIAN:BOBOT_PENILAIAN_UJIAN,
					nilai_ujian:nilai_ujian,
					BOBOT_PENILAIAN_USIA:BOBOT_PENILAIAN_USIA,
					nilai_usia:nilai_usia,
					BOBOT_PENILAIAN_JENIS_KELAMIN:BOBOT_PENILAIAN_JENIS_KELAMIN,
					nilai_jenis_kelamin:nilai_jenis_kelamin,
					BOBOT_PENILAIAN_STATUS_PERNIKAHAN:BOBOT_PENILAIAN_STATUS_PERNIKAHAN,
					nilai_status_pernikahan:nilai_status_pernikahan
					},
					success: function(data){
						if (data == "true")
						{
							alert(data);
							window.location.assign("<?php echo site_url('input_skoring'); ?>");	
						}
						else
						{
							alert(data);
							$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
						}
					}
				});
			return false;
		});
	});

	</script>

</body>

</html>