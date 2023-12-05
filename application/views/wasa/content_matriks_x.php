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
				Sistem menampilkan perhitungan matriks X pada metode SAW .
			</div>
			
            <div class="row">
                <div class="col-lg-12">
					 <div class="ibox-content">
					
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover"  id="data_matriks_x">
							<thead>
							<tr>
								<th>NIP</th>
								<th>Nama Pegawai</th>
								<th> Pendidikan</th>
								<th> Lama Kerja</th>
								<th> Sertifikasi</th>
								<th> Wawancara</th>
								<th> Ujian</th>
								<th> Usia</th>
								<th> Jenis Kelamin</th>
								<th> Status Pernikahan</th>
							</tr>
							</thead>
							<tbody>
							<?php $i = 1; foreach($MATRIKS_X as $mat_x){
								
							?>
								<tr>
									<td><?php echo $mat_x->NIP; ?></td>
									<td><?php echo $mat_x->NAMA; ?></td>
									<td><?php echo $mat_x->nilai_pendidikan; ?></td>
									<td><?php echo $mat_x->nilai_lama_kerja; ?></td>
									<td><?php echo $mat_x->nilai_sertifikasi; ?></td>
									<td><?php echo $mat_x->nilai_wawancara; ?></td>
									<td><?php echo $mat_x->nilai_ujian; ?></td>
									<td><?php echo $mat_x->nilai_usia; ?></td>
									<td><?php echo $mat_x->nilai_jenis_kelamin; ?></td>
									<td><?php echo $mat_x->nilai_status_pernikahan ; ?></td>
								</tr>
							<?php $i = $i+1;} ?>
							</tbody>
					 
							</table>
						</div>
						<?php $i = 1; foreach($maks_nilai_pendidikan as $maks_nilai_pendidikan){?>
						Nilai Maksimum Kriteria Pendidikan: <?php echo $maks_nilai_pendidikan->max_pendidikan; 
						$max_pendidikan = $maks_nilai_pendidikan->max_pendidikan; }?>
						
						<?php $i = 1; foreach($maks_nilai_lama_kerja as $maks_nilai_lama_kerja){?>
						</br>Nilai Maksimum Kriteria Lama Kerja: <?php echo $maks_nilai_lama_kerja->max_lama_kerja; 
						$max_lama_kerja = $maks_nilai_lama_kerja->max_lama_kerja; }?>
						
						<?php $i = 1; foreach($maks_nilai_sertifikasi as $maks_nilai_sertifikasi){?>
						</br>Nilai Maksimum Kriteria Sertifikasi: <?php echo $maks_nilai_sertifikasi->max_sertifikasi; 
						$max_sertifikasi = $maks_nilai_sertifikasi->max_sertifikasi; }?>
						
						<?php $i = 1; foreach($maks_nilai_wawancara as $maks_nilai_wawancara){?>
						</br>Nilai Maksimum Kriteria Wawancara: <?php echo $maks_nilai_wawancara->max_wawancara;
						$max_wawancara = $maks_nilai_wawancara->max_wawancara;}?>
						
						<?php $i = 1; foreach($maks_nilai_ujian as $maks_nilai_ujian){?>
						</br>Nilai Maksimum Kriteria Ujian: <?php echo $maks_nilai_ujian->max_ujian; 
						$max_ujian = $maks_nilai_ujian->max_ujian; }?>
						
						<?php $i = 1; foreach($min_nilai_usia as $min_nilai_usia){?>
						</br>Nilai Minimum Kriteria Usia: <?php echo $min_nilai_usia->min_usia; 
						$min_usia = $min_nilai_usia->min_usia; }?>
						
						<?php $i = 1; foreach($min_nilai_jenis_kelamin as $min_nilai_jenis_kelamin){?>
						</br>Nilai Minimum Kriteria Jenis Kelamin: <?php echo $min_nilai_jenis_kelamin->min_jenis_kelamin; $min_jenis_kelamin = $min_nilai_jenis_kelamin->min_jenis_kelamin;}?>
						
						<?php $i = 1; foreach($min_nilai_status_pernikahan as $min_nilai_status_pernikahan){?>
						</br>Nilai Minimum Kriteria Status Pernikahan: <?php echo $min_nilai_status_pernikahan->min_status_pernikahan; $min_status_pernikahan = $min_nilai_status_pernikahan->min_status_pernikahan; }?>

						</br>
						</br>
						
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover"  id="data_matriks_r">
							<thead>
							<tr>
								<th>NIP</th>
								<th>Nama Pegawai</th>
								<th>Nilai Akhir</th>
								<th>Pendidikan</th>
								<th>Lama Kerja</th>
								<th>Sertifikasi</th>
								<th>Wawancara</th>
								<th>Ujian</th>
								<th>Usia</th>
								<th>Jenis Kelamin</th>
								<th>Status Pernikahan</th>
								
							</tr>
							</thead>
							<tbody>
							<?php $i = 1; foreach($MATRIKS_X as $mat_x){
								
								$nilai_pendidikan = $mat_x->nilai_pendidikan/$max_pendidikan;
								$nilai_lama_kerja = $mat_x->nilai_lama_kerja/$max_lama_kerja;
								$nilai_sertifikasi = $mat_x->nilai_sertifikasi/$max_sertifikasi;
								$nilai_wawancara = $mat_x->nilai_wawancara/$max_wawancara;
								$nilai_ujian = $mat_x->nilai_ujian/$max_ujian;
								$nilai_usia = $min_usia/$mat_x->nilai_usia;
								$nilai_jenis_kelamin = $min_jenis_kelamin/$mat_x->nilai_jenis_kelamin;
								$nilai_status_pernikahan = $min_status_pernikahan/$mat_x->nilai_status_pernikahan;
								
							?>
								<tr>
									<td><?php echo $mat_x->NIP; ?></td>
									<td><?php echo $mat_x->NAMA; ?></td>
									<td><?php
									
									$nilai_akhir = 
									($nilai_pendidikan*$DATA_BOBOT['BOBOT_PENILAIAN_PENDIDIKAN']) +
									($nilai_lama_kerja*$DATA_BOBOT['BOBOT_PENILAIAN_PENGALAMAN_KERJA']) + 
									($nilai_sertifikasi*$DATA_BOBOT['BOBOT_PENILAIAN_SERTIFIKASI']) + 
									($nilai_wawancara*$DATA_BOBOT['BOBOT_PENILAIAN_WAWANCARA']) + 
									($nilai_ujian*$DATA_BOBOT['BOBOT_PENILAIAN_UJIAN']) + 
									($nilai_usia*$DATA_BOBOT['BOBOT_PENILAIAN_USIA']) +
									($nilai_jenis_kelamin*$DATA_BOBOT['BOBOT_PENILAIAN_JENIS_KELAMIN']) + 
									($nilai_status_pernikahan*$DATA_BOBOT['BOBOT_PENILAIAN_STATUS_PERNIKAHAN']) 
									;
									echo $nilai_akhir;
									?></td>
									<td>Nilai: <?php echo $nilai_pendidikan; ?>
									</br>Bobot: <?php echo $DATA_BOBOT['BOBOT_PENILAIAN_PENDIDIKAN']; ?>
									</br>= <?php echo $nilai_pendidikan*$DATA_BOBOT['BOBOT_PENILAIAN_PENDIDIKAN']; ?></td>
									<td>Nilai: <?php echo $nilai_lama_kerja; ?>
									</br>Bobot: <?php echo $DATA_BOBOT['BOBOT_PENILAIAN_PENGALAMAN_KERJA']; ?>
									</br>= <?php echo $nilai_lama_kerja*$DATA_BOBOT['BOBOT_PENILAIAN_PENGALAMAN_KERJA']; ?></td>
									<td>Nilai: <?php echo $nilai_sertifikasi; ?>
									</br>Bobot: <?php echo $DATA_BOBOT['BOBOT_PENILAIAN_SERTIFIKASI']; ?>
									</br>= <?php echo $nilai_sertifikasi*$DATA_BOBOT['BOBOT_PENILAIAN_SERTIFIKASI']; ?></td>
									<td>Nilai: <?php echo $nilai_wawancara; ?>
									</br>Bobot: <?php echo $DATA_BOBOT['BOBOT_PENILAIAN_WAWANCARA']; ?>
									</br>= <?php echo $nilai_wawancara*$DATA_BOBOT['BOBOT_PENILAIAN_WAWANCARA']; ?></td>
									<td>Nilai: <?php echo $nilai_ujian; ?>
									</br>Bobot: <?php echo $DATA_BOBOT['BOBOT_PENILAIAN_UJIAN']; ?>
									</br>= <?php echo $nilai_ujian*$DATA_BOBOT['BOBOT_PENILAIAN_UJIAN']; ?></td>
									<td>Nilai: <?php echo $nilai_usia; ?>
									</br>Bobot: <?php echo $DATA_BOBOT['BOBOT_PENILAIAN_USIA']; ?>
									</br>= <?php echo $nilai_usia*$DATA_BOBOT['BOBOT_PENILAIAN_USIA']; ?></td>
									<td>Nilai: <?php echo $nilai_jenis_kelamin; ?>
									</br>Bobot: <?php echo $DATA_BOBOT['BOBOT_PENILAIAN_JENIS_KELAMIN']; ?>
									</br>= <?php echo $nilai_jenis_kelamin*$DATA_BOBOT['BOBOT_PENILAIAN_JENIS_KELAMIN']; ?></td>
									<td>Nilai: <?php echo $nilai_status_pernikahan; ?>
									</br>Bobot: <?php echo $DATA_BOBOT['BOBOT_PENILAIAN_STATUS_PERNIKAHAN']; ?>
									</br>= <?php echo $nilai_status_pernikahan*$DATA_BOBOT['BOBOT_PENILAIAN_STATUS_PERNIKAHAN']; ?></td>
									
								</tr>
							<?php $i = $i+1;} ?>
							</tbody>
					 
							</table>
						</div>
						</br>
						</br>
						</br>
					</div>
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
		
			$('#data_matriks_x').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'data_matriks_x'},
                    {extend: 'csv', title: 'data_matriks_x'},
                    {extend: 'excel', title: 'data_matriks_x'},
                    {extend: 'pdf', title: 'data_matriks_x' },

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
			
			$('#data_matriks_r').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'data_matriks_r'},
                    {extend: 'csv', title: 'data_matriks_r'},
                    {extend: 'excel', title: 'data_matriks_r'},
                    {extend: 'pdf', title: 'data_matriks_r' },

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });
		
		
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