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
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Input Skoring</h5>
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
									<th>Pegawai Calon Seleksi </br> Promosi Jabatan</th>
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
		
		<!-- MODAL LIHAT -->
        <div class="modal inmodal fade" id="ModalLihat" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-jsfiddle modal-icon"></i>
				<h4 class="modal-title">Data Pegawai Calon Seleksi Promosi Jabatan</h4>
				<small class="font-bold">berdasarkan kode seleksi jabatan</small>
			</div>
				<div class="form-horizontal">
					<div class="modal-body">
						
						<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  id="mydata_lihat">
						<thead>
						<tr>
							<th>NIP</th>
							<th>Nama Pegawai</th>
							<th>Kode Seleksi Jabatan</th>
							
							<th>Bobot Penilaian Pendidikan</th>
							<th>Nilai Pendidikan</th>
							
							<th>Bobot Penilaian Lama Kerja</th>
							<th>Nilai Lama Kerja</th>
							
							<th>Bobot Penilaian Sertifikasi</th>
							<th>Nilai Sertifikasi</th>
							
							<th>Bobot Penilaian Wawancara</th>
							<th>Nilai Wawancara</th>
							
							<th>Bobot Penilaian Ujian</th>
							<th>Nilai Ujian</th>
							
							<th>Bobot Penilaian Usia</th>
							<th>Nilai Usia</th>
							
							<th>Bobot Penilaian Jenis Kelamin</th>
							<th>Nilai Jenis Kelamin</th>
							
							<th>Bobot Penilaian Status Pernikahan</th>
							<th>Nilai Status Pernikahan</th>

							
						</tr>
						</thead>
						<tbody id="show_data_lihat">
					
						</tbody>
				 
						</table>
						</div>

					</div>

					<div class="modal-footer">
						<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Kembali</button>
					</div>
				</div>
            </div>
            </div>
        </div>
        <!--END MODAL LIHAT-->
		
		<!-- MODAL LIHAT BOBOT -->
        <div class="modal inmodal fade" id="ModalLihatSkoring" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-database modal-icon"></i>
				<h4 class="modal-title">Data Skoring Kriteria Penilaian</h4>
				<small class="font-bold">berdasarkan kode seleksi jabatan</small>
			</div>
				<div class="form-horizontal">
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-xs-3" >Kode Seleksi Jabatan</label>
							<div class="col-xs-9">
								<input name="KODE_SJ" id="KODE_SJ" class="form-control" type="text" placeholder="KODE_SJ" readonly>
							</div>
						</div>
						
						<div class="hr-line-dashed"></div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Pendidikan</label>
							<div class="col-xs-9">
								<input name="BOBOT_PENILAIAN_PENDIDIKAN" id="BOBOT_PENILAIAN_PENDIDIKAN" class="form-control" type="text" placeholder="BOBOT_PENILAIAN_PENDIDIKAN" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Pengalaman Kerja</label>
							<div class="col-xs-9">
								<input name="BOBOT_PENILAIAN_PENGALAMAN_KERJA" id="BOBOT_PENILAIAN_PENGALAMAN_KERJA" class="form-control" type="text" placeholder="BOBOT_PENILAIAN_PENGALAMAN_KERJA" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Usia</label>
							<div class="col-xs-9">
								<input name="BOBOT_PENILAIAN_USIA" id="BOBOT_PENILAIAN_USIA" class="form-control" type="text" placeholder="BOBOT_PENILAIAN_USIA" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Status Pernikahan</label>
							<div class="col-xs-9">
								<input name="BOBOT_PENILAIAN_STATUS_PERNIKAHAN" id="BOBOT_PENILAIAN_STATUS_PERNIKAHAN" class="form-control" type="text" placeholder="BOBOT_PENILAIAN_STATUS_PERNIKAHAN" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Jenis Kelamin</label>
							<div class="col-xs-9">
								<input name="BOBOT_PENILAIAN_JENIS_KELAMIN" id="BOBOT_PENILAIAN_JENIS_KELAMIN" class="form-control" type="text" placeholder="BOBOT_PENILAIAN_JENIS_KELAMIN" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Wawancara</label>
							<div class="col-xs-9">
								<input name="BOBOT_PENILAIAN_WAWANCARA" id="BOBOT_PENILAIAN_WAWANCARA" class="form-control" type="text" placeholder="BOBOT_PENILAIAN_WAWANCARA" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Ujian</label>
							<div class="col-xs-9">
								<input name="BOBOT_PENILAIAN_UJIAN" id="BOBOT_PENILAIAN_UJIAN" class="form-control" type="text" placeholder="BOBOT_PENILAIAN_UJIAN" readonly>
							</div>
						</div>
					</div>

					<div class="modal-footer">
						<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Kembali</button>
					</div>
				</div>
            </div>
            </div>
        </div>
        <!--END MODAL LIHAT BOBOT-->
		
		<!-- MODAL EDIT -->
        <div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-cogs modal-icon"></i>
				<h4 class="modal-title">Input Skoring</h4>
				<small class="font-bold">berdasarkan kode seleksi jabatan</small>
			</div>
            <?php $attributes = array("id_input_skoring2" => "contact_form", "id" => "contact_form");
            echo form_open("input_skoring/update_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-xs-3" >ID Seleksi Jabatan</label>
							<div class="col-xs-9">
								<input name="ID_SELEKSI_JABATAN2" id="ID_SELEKSI_JABATAN2" class="form-control" type="text" placeholder="ID_SELEKSI_JABATAN2" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Kode Seleksi Jabatan</label>
							<div class="col-xs-9">
								<input name="KODE_SJ2" id="KODE_SJ2" class="form-control" type="text" placeholder="KODE_SJ2" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Departemen</label>
							<div class="col-xs-9">
								<input name="NAMA_DEPARTEMEN2" id="NAMA_DEPARTEMEN2" class="form-control" type="text" placeholder="NAMA_DEPARTEMEN2" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Maksud & Tujuan</label>
							<div class="col-xs-9">
								<input name="MAKSUD_TUJUAN2" id="MAKSUD_TUJUAN2" class="form-control" type="text" placeholder="MAKSUD_TUJUAN2" readonly>
							</div>
						</div>
						
						<div class="form-group" id="tanggal_akhir_2">
							<label class="control-label col-xs-3" >Tanggal Dibutuhkan (YYYY-MM-DD)</label>
							<div class="col-xs-9">
								<input name="TANGGAL_DIBUTUHKAN2" id="TANGGAL_DIBUTUHKAN2" class="form-control" type="text" placeholder="TANGGAL_DIBUTUHKAN2" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Jabatan</label>
							<div class="col-xs-9">
								<input name="NAMA_JABATAN2" id="NAMA_JABATAN2" class="form-control" type="text" placeholder="NAMA_JABATAN2" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Minimal Kualifikasi Pendidikan</label>
							<div class="col-xs-9">
								<input name="KUALIFIKASI_PENDIDIKAN2" id="KUALIFIKASI_PENDIDIKAN2" class="form-control" type="text" placeholder="KUALIFIKASI_PENDIDIKAN2" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Minimal Kualifikasi Lama Kerja (Bulan)</label>
							<div class="col-xs-9">
								<input name="KUALIFIKASI_LAMA_KERJA2" id="KUALIFIKASI_LAMA_KERJA2" class="form-control" type="text" placeholder="KUALIFIKASI_LAMA_KERJA2" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Minimal Kualifikasi Umur Karyawan (Tahun)</label>
							<div class="col-xs-9">
								<input name="MINIMAL_UMUR_KARYAWAN2" id="MINIMAL_UMUR_KARYAWAN2" class="form-control" type="text" placeholder="MINIMAL_UMUR_KARYAWAN2" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Maksimal Kualifikasi Umur Karyawan (Tahun)</label>
							<div class="col-xs-9">
								<input name="MAKSIMAL_UMUR_KARYAWAN2" id="MAKSIMAL_UMUR_KARYAWAN2" class="form-control" type="text" placeholder="MAKSIMAL_UMUR_KARYAWAN2" readonly>
							</div>
						</div>
						
						<div class="hr-line-dashed"></div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Pendidikan</label>
							<div class="col-xs-9">
								<input class="add" name="PENILAIAN_PENDIDIKAN" type="range" min="1" max="50" value="10" class="slider" id="PENILAIAN_PENDIDIKAN">
								<p>Skoring (%): <span id="val_PENILAIAN_PENDIDIKAN"></span></p>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Pengalaman Kerja</label>
							<div class="col-xs-9">
								<input class="add" name="PENILAIAN_PENGALAMAN_KERJA" type="range" min="1" max="50" value="10" class="slider" id="PENILAIAN_PENGALAMAN_KERJA">
								<p>Skoring (%): <span id="val_PENILAIAN_PENGALAMAN_KERJA"></span></p>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Usia</label>
							<div class="col-xs-9">
								<input class="add" name="PENILAIAN_USIA" type="range" min="1" max="50" value="10" class="slider" id="PENILAIAN_USIA">
								<p>Skoring (%): <span id="val_PENILAIAN_USIA"></span></p>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Status Pernikahan</label>
							<div class="col-xs-9">
								<input class="add" name="PENILAIAN_STATUS_PERNIKAHAN" type="range" min="1" max="50" value="10" class="slider" id="PENILAIAN_STATUS_PERNIKAHAN">
								<p>Skoring (%): <span id="val_PENILAIAN_STATUS_PERNIKAHAN"></span></p>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Jenis Kelamin</label>
							<div class="col-xs-9">
								<input class="add" name="PENILAIAN_JENIS_KELAMIN" type="range" min="1" max="50" value="10" class="slider" id="PENILAIAN_JENIS_KELAMIN">
								<p>Skoring (%): <span id="val_PENILAIAN_JENIS_KELAMIN"></span></p>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Wawancara</label>
							<div class="col-xs-9">
								<input class="add" name="PENILAIAN_WAWANCARA" type="range" min="1" max="50" value="25" class="slider" id="PENILAIAN_WAWANCARA">
								<p>Skoring (%): <span id="val_PENILAIAN_WAWANCARA"></span></p>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Skoring Penilaian Ujian</label>
							<div class="col-xs-9">
								<input class="add" name="PENILAIAN_UJIAN" type="range" min="1" max="50" value="25" class="slider" id="PENILAIAN_UJIAN">
								<p>Skoring (%): <span id="val_PENILAIAN_UJIAN"></span></p>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Jumlah Skoring:</label>
							<div class="col-xs-9">
								<strong id="total"></strong>
							</div>
						</div>
						
						<div class="hr-line-dashed"></div>
						
						<div id="alert-msg-2"></div>
						

					</div>

					<div class="modal-footer">
						<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
						<button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Simpan</button>
					</div>
				</div>
			<?php echo form_close(); ?> 
            </div>
            </div>
        </div>
        <!--END MODAL EDIT-->
		
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
					url   : '<?php echo base_url()?>index.php/input_skoring/data_input_skoring',
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
										'<a href="javascript:;" class="btn btn-info btn-xs item_lihat" data="'+data[i].KODE_SJ+'"><i class="fa fa-search"></i> Lihat Skoring Pegawai </a>'+
									'</td>'+
									'<td>'+
										
										'<a href="<?php echo base_url(); ?>index.php/input_skoring/tambah/'+data[i].KODE_SJ+'" class="btn btn-info btn-xs" ><i class="fa fa-plus"></i> Input Skoring</a>'+
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