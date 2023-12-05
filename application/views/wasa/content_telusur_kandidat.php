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
		
			<div class="alert alert-danger alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				Pastikan Anda mengisi data dengan benar.
			</div>
			
			<div class="alert alert-info alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				Sistem menampilkan nama pegawai calon seleksi promosi jabatan .
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Cari Pegawai Calon Seleksi Promosi Jabatan</h5>
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
						<div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> Maksud dan Tujuan</a></li>
							<li class=""><a data-toggle="tab" href="#tab-2">Tanggal Dibutuhkan</a></li>
							<li class=""><a data-toggle="tab" href="#tab-3">Jabatan</a></li>
							<li class=""><a data-toggle="tab" href="#tab-4">Kualifikasi Pendidikan</a></li>
							<li class=""><a data-toggle="tab" href="#tab-5">Kualifikasi Lama Kerja</a></li>
							<li class=""><a data-toggle="tab" href="#tab-6">Kualifikasi Umur</a></li>
                        </ul>
						<?php foreach($seleksi_jabatan as $sel_jab){ ?>
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


                    </div>
					
						<div class="table-responsive">
						
						</div>
						
						<div class="table-responsive">
							<?php $attributes = array("nama_seleksi_jabatan" => "contact_form", "id" => "contact_form");
							echo form_open("cari_kandidat/simpan_telusur_kandidat", $attributes);?>
								</br>
								</br>
								<input name="KODE_SJ" id="KODE_SJ" class="form-control" type="hidden" value="<?php echo $sel_jab->KODE_SJ;?>">
								<table class="table table-striped table-bordered table-hover"  id="data_pegawai">
									
									<thead>
										<tr>
											<th>Pilih Kandidat</th>
											<th>NIP</th>
											<th>Nama Pegawai</th>
											<th>KODE_JENJANG_PENDIDIKAN</th>
											<th>Pendidikan</th>
											<th>Lama Bekerja (Bulan)</br>Sejak Kontrak</br>Sampai Sekarang</th>
											<th>Umur (Tahun)</th>
											<th>Jabatan Saat Ini</th>
											<th>Departemen Saat Ini</th>
											<th>Lihat CV</th>
										</tr>
									</thead>
									<tbody id="show_data">
								
									</tbody>
						 
								</table>
								<hr>
							<?php if($status_telusur == "data_kosong")
							{ ?>
							<button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
							<?php }?>
							<?php if($status_telusur == "data_ada")
							{ ?>
							<div class="alert alert-danger">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								Anda telah menentukan pegawai calon seleksi promosi jabatan. Silakan input bobot dan input skoring.
							</div>
							</br>
							<button class="btn btn-danger" id="btn_simpan" disabled><i class="fa fa-save"></i> Simpan</button>
							<?php }?>
							<?php echo form_close(); ?> 
						</div>
						
						
						
						
                    </div>
					
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
		
		tampil_data_pegawai();	//pemanggilan fungsi tampil data.
		
		var table = $('#data_pegawai').DataTable({
			'columnDefs': [
			 {
				'targets': 0,
				'checkboxes': {
				   'selectRow': true
				}
			 },
			 {
				'visible':false,
				'targets':3
			 }
			],
			'responsive': true,
			'dom': '<"html5buttons"B>lTfgitp',
			'select': {
			 'style': 'multi'
			},
			'order': [[1, 'asc']],
			'buttons': [
                    {'extend': 'copy'},
                    {'extend': 'csv', 'title': 'Cari Pegawai Calon Seleksi Promosi Jabatan'},
                    {'extend': 'excel', 'title': 'Cari Pegawai Calon Seleksi Promosi Jabatan'},
                    {'extend': 'pdf', 'title': 'Cari Pegawai Calon Seleksi Promosi Jabatan'}
                ]
		});
			
				
		//SIMPAN DATA
			$('#contact_form').on('submit', function(){
				
				var form = this;
				var rows_selected = table.column(0).checkboxes.selected();
				  
				  // Iterate over all selected checkboxes
				  $.each(rows_selected, function(index, rowId){
					 // Create a hidden element 
					 $(form).append(
						 $('<input>')
							.attr('type', 'hidden')
							.attr('name', 'id[]')
							.val(rowId)
					 );
				  });
				  
				var form_data = {
					KODE_SJ: $('#KODE_SJ').val(),
					rows_selected
				};
				
				$.ajax({
					url: "<?php echo site_url('cari_kandidat/simpan_telusur_kandidat'); ?>",
					type: 'POST',
					data: form_data,
					success: function(data){
						if (data != '')
						{
							/* $('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>'); */
							console.log("If");
						}
						else
						{
							console.log("Else");
							/* $('[name="KODE_SJ"]').val("");
							$('[name="ID_DEPARTEMEN"]').val("");
							$('[name="MAKSUD_TUJUAN"]').val("");
							$('[name="TANGGAL_DIBUTUHKAN"]').val("");
							$('[name="JUMLAH_PERSONIL"]').val("");
							$('[name="ID_JABATAN"]').val("");
							$('[name="KUALIFIKASI_PENDIDIKAN"]').val("");
							$('[name="KUALIFIKASI_LAMA_KERJA"]').val("");
							$('[name="MINIMAL_UMUR_KARYAWAN"]').val("");
							$('[name="MAKSIMAL_UMUR_KARYAWAN"]').val("");
							$('#ModalaAdd').modal('hide');
							window.location.reload(); */
						}
					}
				});
				return false;
			});

		//fungsi tampil data
		function tampil_data_pegawai(){
			$.ajax({
				type  : 'ajax',
				url   : '<?php echo base_url()?>index.php/cari_kandidat/data_telusur_kandidat',
				async : false,
				dataType : 'json',
				success : function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){
						
						if(data[i].username != null)
						{
						username = data[i].username;
						}
						else
						{
						username = 'Belum Registrasi';
						}
						
						
						html += '<tr>'+
								'<td>'+data[i].NIP+'</td>'+
								'<td>'+data[i].NIP+'</td>'+
								'<td>'+data[i].NAMA+'</td>'+
								'<td>'+data[i].KODE_JENJANG_PENDIDIKAN+'</td>'+
								'<td>'+data[i].JENJANG_PENDIDIKAN+'</td>'+
								'<td>'+data[i].LAMA_BEKERJA_KONTRAK+'</td>'+
								'<td>'+data[i].UMUR+'</td>'+
								'<td>'+data[i].NAMA_JABATAN+'</td>'+
								'<td>'+data[i].NAMA_DEPARTEMEN+'</td>'+
								'<td>'+'<a href="<?php echo base_url(); ?>index.php/cv/lihat_cv/'+data[i].ID_PEGAWAI+'" class="btn btn-info btn-xs"><i class="fa fa-binoculars"></i> Lihat CV </a>'+'</td>'+
								'</tr>';
					}
					$('#show_data').html(html);
				}

			});
		}
		
		

	});

	</script>

</body>

</html>