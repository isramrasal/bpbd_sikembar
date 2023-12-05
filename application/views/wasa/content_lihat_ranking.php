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
				Sistem menampilkan hasil perhitungan.
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Lihat Ranking</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
							<a class="fullscreen-link">
                                <i class="fa fa-expand"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover"  id="mydata">
					<thead>
                    <tr>
						<th>Kode Seleksi Jabatan</th>
						<th>Departemen</th>
						<th>Maksud & Tujuan</th>
						<th>Tanggal </br>Dibutuhkan</th>
                        <th>Jabatan</td>
						<th>Minimal Kualifikasi </br>Pendidikan</td>
						<th>Minimal Kualifikasi </br>Lama Kerja (Bulan)</td>
						<th>Minimal Kualifikasi </br>Umur Karyawan (Tahun)</td>
						<th>Maksimal Kualifikasi </br>Umur Karyawan (Tahun)</td>
						<th>Tindak Lanjut</th>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data">
				
					</tbody>
             
                    </table>
					
                </div>
            </div>
            </div>
        </div>
		</br>
		
        <div class="footer">
			<div>
				<p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br/> Hak cipta dilindungi undang-undang.</p>
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
	
	<!-- Data picker -->
	<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/datapicker/bootstrap-datepicker.js"></script>
	
	<!-- Date range use moment.js same as full calendar plugin -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/fullcalendar/moment.min.js"></script>

    <!-- Date range picker -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/daterangepicker/daterangepicker.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
	
		
        $(document).ready(function(){
			
			$(".add").on("change", function() {
			  addAll();
			});

			addAll();

			function addAll() {
			var sum = 0; // you had a missing semi-colon here
				$('.add').each(function (){        
					//      sum += isNaN(this.value) || $.trim(this.value) === '' ? 0 : parseFloat(this.value);
				   sum += parseFloat(this.value) || 0; // the other line works but this is simpler and shorter, if for any reason the value returned isn't a number it will choose a zero.
				});
					$('#total').html(sum);
			}
			
			$('#tanggal_akhir .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
			
			$('#tanggal_akhir_2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
			
			tampil_data_input_skoring();	//pemanggilan fungsi tampil data.
			
			$('#mydata').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy', title: 'input_skoring'},
                    {extend: 'csv', title: 'input_skoring'},
                    {extend: 'excel', title: 'input_skoring'},
                    {extend: 'pdf', title: 'input_skoring' },

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
						 
			//fungsi tampil data
			function tampil_data_input_skoring(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/lihat_ranking/data_lihat_ranking',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].KODE_SJ+'</td>'+
									'<td>'+data[i].NAMA_DEPARTEMEN+'</td>'+
									'<td>'+data[i].MAKSUD_TUJUAN+'</td>'+
									'<td>'+data[i].TANGGAL_DIBUTUHKAN+'</td>'+
									'<td>'+data[i].NAMA_JABATAN+'</td>'+
									'<td>'+data[i].KUALIFIKASI_PENDIDIKAN+'</td>'+
									'<td>'+data[i].KUALIFIKASI_LAMA_KERJA+'</td>'+
									'<td>'+data[i].MINIMAL_UMUR_KARYAWAN+'</td>'+
									'<td>'+data[i].MAKSIMAL_UMUR_KARYAWAN+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-warning btn-xs item_lihat_bobot" data="'+data[i].KODE_SJ+'"><i class="fa fa-pencil"></i> Lihat Skoring </a>'+' '+
										'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].ID_SELEKSI_JABATAN+'"><i class="fa fa-trash"></i> Lihat Ranking</a>'+
										'<a href="<?php echo base_url(); ?>index.php/lihat_ranking/matriks_x/'+data[i].KODE_SJ+'" class="btn btn-info btn-xs" ><i class="fa fa-plus"></i> Lihat Matriks X</a>'+
									'</td>'+
									
									
									
									'</tr>';
						}
						$('#show_data').html(html);
					}

				});
			}
			
			//GET LIHAT
			$('#show_data').on('click','.item_lihat',function(){
				var id=$(this).attr('data');
				$.ajax({
					type : "GET",
					url  : "<?php echo base_url('index.php/input_skoring/get_data_pegawai')?>",
					dataType : "JSON",
					data : {id:id},
					success : function(data){
						console.log(data);
						$('#ModalLihat').modal('show');
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].NIP+'</td>'+
									'<td>'+data[i].NAMA+'</td>'+
									'<td>'+data[i].KODE_SJ+'</td>'+
									
									'<td>'+data[i].BOBOT_PENILAIAN_PENDIDIKAN+'</td>'+
									'<td>'+data[i].nilai_pendidikan+'</td>'+
									
									'<td>'+data[i].BOBOT_PENILAIAN_PENGALAMAN_KERJA+'</td>'+
									'<td>'+data[i].nilai_lama_kerja+'</td>'+
									
									'<td>'+data[i].BOBOT_PENILAIAN_SERTIFIKASI+'</td>'+
									'<td>'+data[i].nilai_sertifikasi+'</td>'+
									
									'<td>'+data[i].BOBOT_PENILAIAN_WAWANCARA+'</td>'+
									'<td>'+data[i].nilai_wawancara+'</td>'+
									
									'<td>'+data[i].BOBOT_PENILAIAN_UJIAN+'</td>'+
									'<td>'+data[i].nilai_ujian+'</td>'+
									
									'<td>'+data[i].BOBOT_PENILAIAN_USIA+'</td>'+
									'<td>'+data[i].nilai_usia+'</td>'+
									
									'<td>'+data[i].BOBOT_PENILAIAN_JENIS_KELAMIN+'</td>'+
									'<td>'+data[i].nilai_jenis_kelamin+'</td>'+
									
									'<td>'+data[i].BOBOT_PENILAIAN_STATUS_PERNIKAHAN+'</td>'+
									'<td>'+data[i].nilai_status_pernikahan+'</td>'+
									
									
									'</tr>';
						}
						$('#show_data_lihat').html(html);
					}
				});
				return false;
			});
			
			//GET LIHAT BOBOT
			$('#show_data').on('click','.item_lihat_bobot',function(){
				var id=$(this).attr('data');
				$.ajax({
					type : "GET",
					url  : "<?php echo base_url('index.php/input_skoring/get_data_bobot')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_BOBOT, KODE_SJ, BOBOT_PENILAIAN_PENDIDIKAN, BOBOT_PENILAIAN_PENGALAMAN_KERJA, BOBOT_PENILAIAN_USIA, BOBOT_PENILAIAN_STATUS_PERNIKAHAN, BOBOT_PENILAIAN_JENIS_KELAMIN, BOBOT_PENILAIAN_WAWANCARA, BOBOT_PENILAIAN_UJIAN){
							$('#ModalLihatSkoring').modal('show');
							$('[name="KODE_SJ"]').val(data.KODE_SJ);
							$('[name="BOBOT_PENILAIAN_PENDIDIKAN"]').val(data.BOBOT_PENILAIAN_PENDIDIKAN);
							$('[name="BOBOT_PENILAIAN_PENGALAMAN_KERJA"]').val(data.BOBOT_PENILAIAN_PENGALAMAN_KERJA);
							$('[name="BOBOT_PENILAIAN_USIA"]').val(data.BOBOT_PENILAIAN_USIA);
							$('[name="BOBOT_PENILAIAN_STATUS_PERNIKAHAN"]').val(data.BOBOT_PENILAIAN_STATUS_PERNIKAHAN);
							$('[name="BOBOT_PENILAIAN_JENIS_KELAMIN"]').val(data.BOBOT_PENILAIAN_JENIS_KELAMIN);
							$('[name="BOBOT_PENILAIAN_WAWANCARA"]').val(data.BOBOT_PENILAIAN_WAWANCARA);
							$('[name="BOBOT_PENILAIAN_UJIAN"]').val(data.BOBOT_PENILAIAN_UJIAN);


						});
					}
				});
				return false;
			});
			
			//GET UPDATE
			$('#show_data').on('click','.item_edit',function(){
				var id=$(this).attr('data');
				$.ajax({
					type : "GET",
					url  : "<?php echo base_url('index.php/input_skoring/input_skoring')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_SELEKSI_JABATAN, ID_DEPARTEMEN, MAKSUD_TUJUAN, TANGGAL_DIBUTUHKAN, ID_JABATAN, KUALIFIKASI_PENDIDIKAN, KUALIFIKASI_LAMA_KERJA){
							$('#ModalaEdit').modal('show');
							$('[name="ID_SELEKSI_JABATAN2"]').val(data.ID_SELEKSI_JABATAN);
							$('[name="KODE_SJ2"]').val(data.KODE_SJ);
							$('[name="NAMA_DEPARTEMEN2"]').val(data.NAMA_DEPARTEMEN);
							$('[name="MAKSUD_TUJUAN2"]').val(data.MAKSUD_TUJUAN);
							$('[name="TANGGAL_DIBUTUHKAN2"]').val(data.TANGGAL_DIBUTUHKAN);
							$('[name="ID_JABATAN2"]').val(data.ID_JABATAN);
							$('[name="NAMA_JABATAN2"]').val(data.NAMA_JABATAN);
							$('[name="KUALIFIKASI_PENDIDIKAN2"]').val(data.KUALIFIKASI_PENDIDIKAN);
							$('[name="KUALIFIKASI_LAMA_KERJA2"]').val(data.KUALIFIKASI_LAMA_KERJA);
							$('[name="MINIMAL_UMUR_KARYAWAN2"]').val(data.MINIMAL_UMUR_KARYAWAN);
							$('[name="MAKSIMAL_UMUR_KARYAWAN2"]').val(data.MAKSIMAL_UMUR_KARYAWAN);
							$('#alert-msg-2').html('<div></div>');
						});
					}
				});
				return false;
			});
			
			//UPDATE DATA 
			$('#btn_update').on('click',function(){
				
				var sum = 0; // you had a missing semi-colon here
				$('.add').each(function (){        
					//      sum += isNaN(this.value) || $.trim(this.value) === '' ? 0 : parseFloat(this.value);
				   sum += parseFloat(this.value) || 0; // the other line works but this is simpler and shorter, if for any reason the value returned isn't a number it will choose a zero.
				});
				
				var ID_SELEKSI_JABATAN=$('#ID_SELEKSI_JABATAN2').val();
				var KODE_SJ=$('#KODE_SJ2').val();
				var BOBOT_PENILAIAN_PENDIDIKAN=$('#PENILAIAN_PENDIDIKAN').val();
				var BOBOT_PENILAIAN_PENGALAMAN_KERJA=$('#PENILAIAN_PENGALAMAN_KERJA').val();
				var BOBOT_PENILAIAN_USIA=$('#PENILAIAN_USIA').val();
				var BOBOT_PENILAIAN_STATUS_PERNIKAHAN=$('#PENILAIAN_STATUS_PERNIKAHAN').val();
				var BOBOT_PENILAIAN_JENIS_KELAMIN=$('#PENILAIAN_JENIS_KELAMIN').val();
				var BOBOT_PENILAIAN_WAWANCARA=$('#PENILAIAN_WAWANCARA').val();
				var BOBOT_PENILAIAN_UJIAN=$('#PENILAIAN_UJIAN').val();
				
				console.log(sum);
				
				
				$.ajax({
					url  : "<?php echo site_url('input_skoring/update_data')?>",
					type : "POST",
					dataType : "JSON",
					data : {KODE_SJ:KODE_SJ, BOBOT_PENILAIAN_PENDIDIKAN:BOBOT_PENILAIAN_PENDIDIKAN, BOBOT_PENILAIAN_PENGALAMAN_KERJA:BOBOT_PENILAIAN_PENGALAMAN_KERJA, BOBOT_PENILAIAN_USIA:BOBOT_PENILAIAN_USIA, BOBOT_PENILAIAN_STATUS_PERNIKAHAN:BOBOT_PENILAIAN_STATUS_PERNIKAHAN, BOBOT_PENILAIAN_JENIS_KELAMIN:BOBOT_PENILAIAN_JENIS_KELAMIN, BOBOT_PENILAIAN_WAWANCARA:BOBOT_PENILAIAN_WAWANCARA, BOBOT_PENILAIAN_UJIAN:BOBOT_PENILAIAN_UJIAN, sum:sum },
					success: function(data){
						if (data == true)
						{
							$('#ModalaEdit').modal('hide');
							$('[name="KODE_SJ2"]').val("");
							window.location.reload();
						}
						else
						{
							$('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
						}
					} 
				});
				return false;
			});

        });

    </script>
	
	<script>
	var slider_PENILAIAN_PENDIDIKAN = document.getElementById("PENILAIAN_PENDIDIKAN");
	var output_PENILAIAN_PENDIDIKAN = document.getElementById("val_PENILAIAN_PENDIDIKAN");
	output_PENILAIAN_PENDIDIKAN.innerHTML = slider_PENILAIAN_PENDIDIKAN.value;
	
	slider_PENILAIAN_PENDIDIKAN.oninput = function() {
	  output_PENILAIAN_PENDIDIKAN.innerHTML = this.value;
	  
	  var val_slider_PENILAIAN_PENDIDIKAN = slider_PENILAIAN_PENDIDIKAN.value;
	}
	
	</script>
	
	<script>
	var slider_PENILAIAN_PENGALAMAN_KERJA = document.getElementById("PENILAIAN_PENGALAMAN_KERJA");
	var output_PENILAIAN_PENGALAMAN_KERJA = document.getElementById("val_PENILAIAN_PENGALAMAN_KERJA");
	output_PENILAIAN_PENGALAMAN_KERJA.innerHTML = slider_PENILAIAN_PENGALAMAN_KERJA.value;

	slider_PENILAIAN_PENGALAMAN_KERJA.oninput = function() {
	  output_PENILAIAN_PENGALAMAN_KERJA.innerHTML = this.value;
	  
	  var val_slider_PENILAIAN_PENGALAMAN_KERJA = slider_PENILAIAN_PENGALAMAN_KERJA.value;
	}
	</script>
	
	<script>
	var slider_PENILAIAN_USIA = document.getElementById("PENILAIAN_USIA");
	var output_PENILAIAN_USIA = document.getElementById("val_PENILAIAN_USIA");
	output_PENILAIAN_USIA.innerHTML = slider_PENILAIAN_USIA.value;

	slider_PENILAIAN_USIA.oninput = function() {
	  output_PENILAIAN_USIA.innerHTML = this.value;
	}
	</script>
	
	<script>
	var slider_PENILAIAN_STATUS_PERNIKAHAN = document.getElementById("PENILAIAN_STATUS_PERNIKAHAN");
	var output_PENILAIAN_STATUS_PERNIKAHAN = document.getElementById("val_PENILAIAN_STATUS_PERNIKAHAN");
	output_PENILAIAN_STATUS_PERNIKAHAN.innerHTML = slider_PENILAIAN_STATUS_PERNIKAHAN.value;

	slider_PENILAIAN_STATUS_PERNIKAHAN.oninput = function() {
	  output_PENILAIAN_STATUS_PERNIKAHAN.innerHTML = this.value;
	}
	</script>
	
	<script>
	var slider_PENILAIAN_JENIS_KELAMIN = document.getElementById("PENILAIAN_JENIS_KELAMIN");
	var output_PENILAIAN_JENIS_KELAMIN = document.getElementById("val_PENILAIAN_JENIS_KELAMIN");
	output_PENILAIAN_JENIS_KELAMIN.innerHTML = slider_PENILAIAN_JENIS_KELAMIN.value;

	slider_PENILAIAN_JENIS_KELAMIN.oninput = function() {
	  output_PENILAIAN_JENIS_KELAMIN.innerHTML = this.value;
	}
	</script>
	
	<script>
	var slider_PENILAIAN_WAWANCARA = document.getElementById("PENILAIAN_WAWANCARA");
	var output_PENILAIAN_WAWANCARA = document.getElementById("val_PENILAIAN_WAWANCARA");
	output_PENILAIAN_WAWANCARA.innerHTML = slider_PENILAIAN_WAWANCARA.value;

	slider_PENILAIAN_WAWANCARA.oninput = function() {
	  output_PENILAIAN_WAWANCARA.innerHTML = this.value;
	}
	</script>
	
	<script>
	var slider_PENILAIAN_UJIAN = document.getElementById("PENILAIAN_UJIAN");
	var output_PENILAIAN_UJIAN = document.getElementById("val_PENILAIAN_UJIAN");
	output_PENILAIAN_UJIAN.innerHTML = slider_PENILAIAN_UJIAN.value;

	slider_PENILAIAN_UJIAN.oninput = function() {
	  output_PENILAIAN_UJIAN.innerHTML = this.value;
	  
	  var val_slider_PENILAIAN_UJIAN = slider_PENILAIAN_UJIAN.value;
	}
	</script>
	

</body>

</html>