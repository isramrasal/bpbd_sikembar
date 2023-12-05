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
				Pastikan pegawai mengisi data dengan benar. 
			</div>
			
			<div class="alert alert-info alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				Silahkan pilih edit untuk memasukkan atau mengubah biodata Pegawai.
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Biodata Pegawai</h5>
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
						<th>NIP</th>
						<th>Nama Pegawai</th>
						<th>NIK</th>
						<th>Tempat&nbsp;dan&nbsp;Tanggal&nbsp;Lahir&nbsp; (YYYY-MM-DD)</th>
						<th>Umur (Tahun)</th>
						<th>Lama Bekerja(Bulan) </br> Sejak Kontrak </br> Sampai Sekarang</th>
						<th>Lama Bekerja(Bulan) </br> Sejak Tetap </br> Sampai Sekarang</th>
						<th>Nomor Handphone Utama</th>
						<th>Username</th>
                        <th>Aksi</td>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data">
				
					</tbody>
             
					</table>
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
		
		
		
		<!-- MODAL EDIT -->
        <div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<i class="fa fa-user-circle modal-icon"></i>
						<h4 class="modal-title">Biodata Pegawai</h4>
						<small class="font-bold">Silakan edit biodata pegawai secara lengkap</small>
					</div>
            <?php $attributes = array("id_pegawai2" => "contact_form", "id" => "contact_form");
            echo form_open("pegawai/update_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">
							
						<div class="form-group">
							<label class="control-label col-xs-3" >ID Pegawai</label>
							<div class="col-xs-9">
								<input name="ID_PEGAWAI2" id="ID_PEGAWAI2" class="form-control" type="text" placeholder="ID pegawai..." readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Nomor Induk Pegawai</label>
							<div class="col-xs-9">
								<input name="NIP2" id="NIP2" class="form-control" type="text" placeholder="Nomor Induk Pegawai..." readonly> <span class="help-block m-b-none">NIP pegawai</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-3 control-label">Nomor Induk Kependudukan</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" name="NIK2" id="NIK2" > <span class="help-block m-b-none">NIK pegawai</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-3 control-label">Nomor Kartu Keluarga</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" name="NO_KARTU_KELUARGA2" id="NO_KARTU_KELUARGA2" > <span class="help-block m-b-none">Nomor KK pegawai</span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3">Nama Lengkap</label>
							<div class="col-xs-9">
								<input name="NAMA2" id="NAMA2" class="form-control" type="text" placeholder="Nama lengkap Pegawai..." required><span class="help-block m-b-none">Nama lengkap pegawai sesuai identitas diri dan lengkap dengan gelar</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Email Alternatif</label>
							<div class="col-xs-9">
								<input name="EMAIL2" id="EMAIL2" class="form-control" type="text" placeholder="Email Alternatif Pegawai..." required><span class="help-block m-b-none">Alamat email alternatif pegawai yang aktif</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Nomor Handphone Utama</label>
							<div class="col-xs-9">
								<input name="NO_HP_12" id="NO_HP_12" class="form-control" type="text" placeholder="Nomor handphone utama Pegawai..." required><span class="help-block m-b-none">Nomor handphone yang pegawai gunakan sehari-hari</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Nomor Handphone Alternatif*</label>
							<div class="col-xs-9">
								<input name="NO_HP_22" id="NO_HP_22" class="form-control" type="text" placeholder="Nomor handphone alternatif Pegawai..." required><span class="help-block m-b-none">Nomor handphone yang pegawai gunakan sebagai alternatif</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Jenis Kelamin</label>
							<div class="col-xs-9">
								<select name="JENIS_KELAMIN2" class="form-control" id="JENIS_KELAMIN2">
									<option value=''>- Pilih Jenis Kelamin -</option>
									<option value='Pria'>Pria</option>
									<option value='Wanita'>Wanita</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Kota Kelahiran</label>
							<div class="col-xs-9">
								<input name="TEMPAT_LAHIR2" id="TEMPAT_LAHIR2" class="form-control" type="text" placeholder="Kota kelahiran Pegawai..." required><span class="help-block m-b-none">Kota/Kabupaten/Lokasi dimana pegawai dilahirkan sesuai identitas diri</span>
							</div>
						</div>
						
						<div class="form-group" id="tanggal_akhir">
							<label class="control-label col-xs-3" >Tanggal Lahir (YYYY-MM-DD)</label>
							<div class="col-xs-9">
								<div class="input-group date"><input type="text" class="form-control" id="TANGGAL_LAHIR2" name="TANGGAL_LAHIR2">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								<span class="help-block m-b-none">Tanggal kapan pegawai dilahirkan sesuai identitas diri</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Agama</label>
							<div class="col-xs-9">
								<select name="AGAMA2" class="form-control" id="AGAMA2">
									<option value=''>- Pilih Agama -</option>
									<option value='Islam'>Islam</option>
									<option value='Kristen Protestan'>Kristen Protestan</option>
									<option value='Kristen Katolik'>Kristen Katolik</option>
									<option value='Hindu'>Hindu</option>
									<option value='Buddha'>Buddha</option>
									<option value='Kong Hu Cu'>Kong Hu Cu</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Status Pernikahan</label>
							<div class="col-xs-9">
								<select name="STATUS_PERNIKAHAN2" class="form-control" id="STATUS_PERNIKAHAN2">
									<option value=''>- Pilih Status Pernikahan -</option>
									<option value='Lajang'>Lajang</option>
									<option value='Menikah'>Menikah</option>
									<option value='Janda'>Janda</option>
									<option value='Duda'>Duda</option>
								</select>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">NPWP*</label>
							<div class="col-xs-9">
								<input name="NPWP2" id="NPWP2" class="form-control" type="text" placeholder="NPWP Pegawai.." required><span class="help-block m-b-none">Nomor Pokok Wajib Pajak</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Paspor*</label>
							<div class="col-xs-9">
								<input name="PASPOR2" id="PASPOR2" class="form-control" type="text" placeholder="Nomor Paspor Pegawai.." required><span class="help-block m-b-none">Nomor paspor pegawai yang masih berlaku sampai saat ini</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">BPJS Kesehatan*</label>
							<div class="col-xs-9">
								<input name="BPJS_KESEHATAN2" id="BPJS_KESEHATAN2" class="form-control" type="text" placeholder="Nomor BPJS Kesehatan Pegawai.." required><span class="help-block m-b-none">Nomor BPJS Kesehatan pegawai yang masih berlaku sampai saat ini</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">BPJS Tenaga Kerja*</label>
							<div class="col-xs-9">
								<input name="BPJS_TK2" id="BPJS_TK2" class="form-control" type="text" placeholder="Nomor BPJS Tenaga Kerja Pegawai.." required><span class="help-block m-b-none">Nomor BPJS Tenaga Kerja pegawai yang masih berlaku sampai saat ini</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-6">* Tidak wajib diisi</label>
						</div>
						
						
						<div id="alert-msg-2"></div>

					</div>

					<div class="modal-footer">
						<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
						<button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Update</button>
					</div>
				</div>
			<?php echo form_close(); ?> 
            </div>
            </div>
        </div>
        <!--END MODAL EDIT-->
		
		<!--MODAL HAPUS-->
        <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        <h4 class="modal-title" id="myModalLabel">Hapus Data Pegawai</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin ingin menghapus data ini? Data pegawai yang sudah dihapus tidak bisa dipulihkan kembali. Anda akan menghapus seluruh data pegawai, termasuk foto, berkas dan riwayat penggunaan.</p>
							</br>
							<div name="nama_pegawai_3" id="nama_pegawai_3"></div>
							<div name="nip_pegawai_3" id="nip_pegawai_3"></div>
							<div name="nik_pegawai_3" id="nik_pegawai_3"></div>
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
			
			$('#tanggal_akhir .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
			
			$('#ModalaEdit').on('shown.bs.modal', function () {
				$('#NIK2').focus();
			});
			
			tampil_data_pegawai();	//pemanggilan fungsi tampil data.
	
			
			$('#mydata').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv', title: 'Biodata Pegawai'},
                    {extend: 'excel', title: 'Biodata Pegawai'},
                    {extend: 'pdf', title: 'Biodata Pegawai'},

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
			function tampil_data_pegawai(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/pegawai/data_pegawai',
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
									'<td>'+data[i].NAMA+'</td>'+
									'<td>'+data[i].NIK+'</td>'+
									'<td>'+data[i].TEMPAT_LAHIR+' '+data[i].TANGGAL_LAHIR+'</td>'+
									'<td>'+data[i].UMUR+' tahun</td>'+
									'<td>'+data[i].LAMA_BEKERJA_KONTRAK+'</td>'+
									'<td>'+data[i].LAMA_BEKERJA_TETAP+'</td>'+
									'<td>'+data[i].NO_HP_1+'</td>'+
									'<td>'+username+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].ID_PEGAWAI+'"><i class="fa fa-pencil"></i> Edit </a>'+' '+
										'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].ID_PEGAWAI+'"><i class="fa fa-trash"></i> Hapus Data Pegawai</a>'+
									'</td>'+
									'</tr>';
						}
						$('#show_data').html(html);
					}

				});
			}
			
			//GET UPDATE
			$('#show_data').on('click','.item_edit',function(){
				var id=$(this).attr('data');
				$.ajax({
					type : "GET",
					url  : "<?php echo base_url('index.php/pegawai/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_PEGAWAI, NIP, NIK, NAMA, EMAIL, NO_HP_1, NO_HP_2, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, AGAMA, STATUS_PERNIKAHAN, NPWP, PASPOR, BPJS_KESEHATAN, BPJS_TK){
							$('#ModalaEdit').modal('show');
							$('[name="ID_PEGAWAI2"]').val(data.ID_PEGAWAI);
							$('[name="NIP2"]').val(data.NIP);
							$('[name="NIK2"]').val(data.NIK);
							$('[name="NO_KARTU_KELUARGA2"]').val(data.NO_KARTU_KELUARGA);
							$('[name="NAMA2"]').val(data.NAMA);
							$('[name="EMAIL2"]').val(data.EMAIL);
							$('[name="NO_HP_12"]').val(data.NO_HP_1);
							$('[name="NO_HP_22"]').val(data.NO_HP_2);
							$('[name="JENIS_KELAMIN2"]').val(data.JENIS_KELAMIN);
							$('[name="TEMPAT_LAHIR2"]').val(data.TEMPAT_LAHIR);
							$('[name="TANGGAL_LAHIR2"]').val(data.TANGGAL_LAHIR);
							$('[name="AGAMA2"]').val(data.AGAMA);
							$('[name="STATUS_PERNIKAHAN2"]').val(data.STATUS_PERNIKAHAN);
							$('[name="NPWP2"]').val(data.NPWP);
							$('[name="PASPOR2"]').val(data.PASPOR);
							$('[name="BPJS_KESEHATAN2"]').val(data.BPJS_KESEHATAN);
							$('[name="BPJS_TK2"]').val(data.BPJS_TK);
							$('#alert-msg-2').html('<div></div>');
						});
					}
				});
				return false;
			});
			
			//GET HAPUS
			$('#show_data').on('click','.item_hapus',function(){
				var id=$(this).attr('data');
				$.ajax({
					type : "GET",
					url  : "<?php echo base_url('index.php/pegawai/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_PEGAWAI, NAMA){
							$('#ModalHapus').modal('show');
							$('[name="kode"]').val(id);
							$('#nama_pegawai_3').html('Nama Pegawai: ' + data.NAMA);
							$('#nip_pegawai_3').html('Nomor Induk Pegawai: ' + data.NIP);
							$('#nik_pegawai_3').html('NIK Pegawai: ' + data.NIK);
						});
					}
				});
			});
			
			//HAPUS DATA
			$('#btn_hapus').on('click',function(){
				var kode=$('#textkode').val();
				$.ajax({
				type : "POST",
				url  : "<?php echo base_url('index.php/pegawai/hapus_data')?>",
				dataType : "JSON",
						data : {kode: kode},
						success: function(data){
								$('#ModalHapus').modal('hide');
								tampil_data_pegawai();
								window.location.reload();
						}
					});
					return false;
				});
			
			
			
			//UPDATE DATA 
			$('#btn_update').on('click',function(){
				
				var ID_PEGAWAI2=$('#ID_PEGAWAI2').val();
				var NIP2=$('#NIP2').val();
				var NIK2=$('#NIK2').val();
				var NO_KARTU_KELUARGA2=$('#NO_KARTU_KELUARGA2').val();
				var NAMA2=$('#NAMA2').val();
				var EMAIL2=$('#EMAIL2').val();
				var NO_HP_12=$('#NO_HP_12').val();
				var NO_HP_22=$('#NO_HP_22').val();
				var JENIS_KELAMIN2=$('#JENIS_KELAMIN2').val();
				var TEMPAT_LAHIR2=$('#TEMPAT_LAHIR2').val();
				var TANGGAL_LAHIR2=$('#TANGGAL_LAHIR2').val();
				var AGAMA2=$('#AGAMA2').val();
				var STATUS_PERNIKAHAN2=$('#STATUS_PERNIKAHAN2').val();
				var NPWP2=$('#NPWP2').val();
				var PASPOR2=$('#PASPOR2').val();
				var BPJS_KESEHATAN2=$('#BPJS_KESEHATAN2').val();
				var BPJS_TK2=$('#BPJS_TK2').val();
				$.ajax({
					url  : "<?php echo site_url('pegawai/update_data')?>",
					type : "POST",
					dataType : "JSON",
					data : {ID_PEGAWAI2:ID_PEGAWAI2, NIP2:NIP2, NO_KARTU_KELUARGA2:NO_KARTU_KELUARGA2, NIK2:NIK2, NAMA2:NAMA2, EMAIL2:EMAIL2, NO_HP_12:NO_HP_12, NO_HP_22:NO_HP_22, JENIS_KELAMIN2:JENIS_KELAMIN2, TEMPAT_LAHIR2:TEMPAT_LAHIR2, TANGGAL_LAHIR2:TANGGAL_LAHIR2, AGAMA2:AGAMA2, STATUS_PERNIKAHAN2:STATUS_PERNIKAHAN2, NPWP2:NPWP2, PASPOR2:PASPOR2, BPJS_KESEHATAN2:BPJS_KESEHATAN2, BPJS_TK2:BPJS_TK2},
					success: function(data){
						if (data == true)
						{
							$('#ModalaEdit').modal('hide');
							$('[name="id_pegawai2"]').val("");
							$('[name="ID_PEGAWAI2"]').val("");
							$('[name="NIP2"]').val("");
							$('[name="NIK2"]').val("");
							$('[name="NO_KARTU_KELUARGA2"]').val("");
							$('[name="NAMA2"]').val("");
							$('[name="EMAIL2"]').val("");
							$('[name="NO_HP_12"]').val("");
							$('[name="NO_HP_22"]').val("");
							$('[name="JENIS_KELAMIN2"]').val("");
							$('[name="TEMPAT_LAHIR2"]').val("");
							$('[name="TANGGAL_LAHIR2"]').val("");
							$('[name="AGAMA2"]').val("");
							$('[name="STATUS_PERNIKAHAN2"]').val("");
							$('[name="NPWP2"]').val("");;
							$('[name="PASPOR2"]').val("");
							$('[name="BPJS_KESEHATAN2"]').val("");
							$('[name="BPJS_TK2"]').val("");
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

</body>

</html>