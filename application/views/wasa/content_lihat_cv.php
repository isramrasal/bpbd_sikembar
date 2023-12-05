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
				Sistem menampilkan resume data yang pegawai masukkan.
			</div>
			
            <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
						<div class="ibox-title">
							<div class="ibox-tools">
								<a class="fullscreen-link">
									<i class="fa fa-expand"></i>
								</a>
								<a href="<?php echo base_url(); ?>index.php/cetak_cv/index/<?php echo $ID_PEGAWAI; ?>" target="_blank" class="btn btn-primary"><i class="fa fa-print"></i> Cetak CV </a>
							</div>
						</div>
                        <div class="ibox-content">
							<div class="row m-b-lg m-t-lg">
								<div class="col-md-6">

									<div class="profile-image">
										<img src="<?php echo base_url(); ?><?php echo $foto_pegawai; ?>" class="img-circle circle-border m-b-md" alt="profile">
									</div>
									<div class="profile-info">
										<div class="">
											<div>
												<h2 class="no-margins">
													Curriculum Vitae
												</h2>
												<?php foreach($pegawai as $peg){ ?>
												<h4><?php echo $peg->NAMA; ?></h4>
												<small>
													
												</small>
											</div>
										</div>
									</div>
								</div>
							</div>
						
						
						
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Biodata</h2>
                                    </div>
                                </div>
                            </div>
							
							<div class="row">
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Nama Lengkap:</dt> <dd><?php echo $peg->NAMA; ?></dd>
										<dt>Agama:</dt> <dd><?php echo $peg->AGAMA; ?></dd>
										<dt>Jenis Kelamin:</dt> <dd><?php echo $peg->JENIS_KELAMIN; ?></dd>

                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal" >

                                        <dt>Kota Kelahiran:</dt> <dd><?php echo $peg->TEMPAT_LAHIR; ?></dd>
										<dt>Tanggal Lahir:</dt> <dd><?php echo $peg->TANGGAL_LAHIR; ?></dd>
										<dt>Umur:</dt> <dd><?php echo $peg->UMUR; ?> tahun</dd>
										<dt>Status Pernikahan:</dt> <dd><?php echo $peg->STATUS_PERNIKAHAN; ?></dd>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
							
							<div class="row">
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
										<dt>Email Alternatif:</dt> <dd><?php echo $peg->EMAIL; ?></dd>
										<dt>No HP Utama:</dt> <dd><?php echo $peg->NO_HP_1; ?></dd>
										<dt>No HP Alternatif:</dt> <dd><?php echo $peg->NO_HP_2; ?></dd>
                                    </dl>
                                </div>
                            </div>
							
                            <div class="row">
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
										<dt>NIP:</dt> <dd><?php echo $peg->NIP; ?></dd>
										<dt>NIK:</dt> <dd><?php echo $peg->NIK; ?></dd>
										<dt>NPWP:</dt> <dd><?php echo $peg->NPWP; ?></dd>
										<dt>Kartu Keluarga:</dt> <dd><?php echo $peg->NO_KARTU_KELUARGA; ?></dd>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal" >

                                        <dt>Paspor:</dt> <dd><?php echo $peg->PASPOR; ?></dd>
										<dt>BPJS Kesehatan:</dt> <dd><?php echo $peg->BPJS_KESEHATAN; ?></dd>
										<dt>BPJS Tenaga Kerja:</dt> <dd><?php echo $peg->BPJS_TK; ?></dd>

                                        </dd>
                                    </dl>
                                </div>
                            </div>
							<?php } ?>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Pendidikan</h2>
                                    </div>
                                </div>
                            </div>
							<?php foreach($pendidikan as $pend){ ?>
							<div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>Jenjang Pendidikan:</dt> <dd><?php echo $pend->JENJANG_PENDIDIKAN; ?></dd>
										<dt>Nama Institusi:</dt> <dd><?php echo $pend->NAMA_INSTITUSI; ?></dd>
										<dt>Tahun Lulus:</dt> <dd><?php echo $pend->TAHUN_LULUS; ?></dd>

                                    </dl>
                                </div>
                            </div>

							<?php } ?>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Pelatihan</h2>
                                    </div>
                                </div>
                            </div>
							<?php foreach($pelatihan as $pelt){ ?>
							<div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>Nama Pelatihan:</dt> <dd><?php echo $pelt->NAMA_PELATIHAN; ?></dd>
										<dt>Bidang Pelatihan:</dt> <dd><?php echo $pelt->BIDANG_PELATIHAN; ?></dd>
										<dt>Nama Penyelenggara:</dt> <dd><?php echo $pelt->NAMA_PENYELENGGARA; ?></dd>
										<dt>Keterangan:</dt> <dd><?php echo $pelt->KETERANGAN; ?></dd>

                                    </dl>
                                </div>
                            </div>
							<?php } ?>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Pekerjaan</h2>
                                    </div>
                                </div>
                            </div>
							<?php foreach($riwayat_pekerjaan as $riw_per){ ?>
							<div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>Perusahaan:</dt> <dd><?php echo $riw_per->NAMA_PERUSAHAAN; ?></dd>
										<dt>Jabatan:</dt> <dd><?php echo $riw_per->NAMA_JABATAN; ?></dd>
										<dt>Bidang Pekerjaan:</dt> <dd><?php echo $riw_per->NAMA_BIDANG_PEKERJAAN; ?></dd>
										<dt>Tanggal Awal Bekerja:</dt> <dd><?php echo $riw_per->TANGGAL_AWAL_BEKERJA; ?></dd>
										<dt>Tanggal Akhir Bekerja:</dt> <dd><?php echo $riw_per->TANGGAL_AKHIR_BEKERJA; ?></dd>

                                    </dl>
                                </div>
                            </div>
							<?php } ?>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Alamat</h2>
                                    </div>
                                </div>
                            </div>
							<?php foreach($alamat as $alam){ ?>
							<div class="row">
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Status Alamat:</dt> <dd><?php echo $alam->STATUS_ALAMAT; ?></dd>
										<dt>Provinsi:</dt> <dd><?php echo $alam->PROVINSI; ?></dd>
										<dt>Kota/Kabupaten:</dt> <dd><?php echo $alam->KOTA; ?></dd>
										<dt>Kecamatan:</dt> <dd><?php echo $alam->KECAMATAN; ?></dd>
                                    </dl>
                                </div>
								<div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Kelurahan/Desa:</dt> <dd><?php echo $alam->KELURAHAN; ?></dd>
										<dt>Nama Jalan:</dt> <dd><?php echo $alam->NAMA_JALAN; ?></dd>
										<dt>Nomor Telepon:</dt> <dd><?php echo $alam->TELP_ALAMAT; ?></dd>
                                    </dl>
                                </div>
                            </div>
							<?php } ?>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Anggota Keluarga</h2>
                                    </div>
                                </div>
                            </div>
							<?php foreach($keluarga as $kelg){ ?>
							<div class="row">
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Nama Lengkap:</dt> <dd><?php echo $kelg->NAMA; ?></dd>
										<dt>Hubungan:</dt> <dd><?php echo $kelg->HUBUNGAN; ?></dd>
                                    </dl>
                                </div>
                            </div>
							<?php } ?>

                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
		
        <div class="footer">
			<div>
				<p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br/> Hak cipta dilindungi undang-undang.</p>
			</div> 
        </div>

        </div>
        </div>
		
		
		
		<!-- MODAL EDIT -->
        <div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Data Pegawai</h3>
            </div>
            <?php $attributes = array("id_pegawai2" => "contact_form", "id" => "contact_form");
            echo form_open("pegawai/update_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">
							
						<div class="form-group">
							<label class="control-label col-xs-3" >ID pegawai</label>
							<div class="col-xs-9">
								<input name="ID_PEGAWAI2" id="ID_PEGAWAI2" class="form-control" type="text" placeholder="ID pegawai..." readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Nomor Induk Pegawai</label>
							<div class="col-xs-9">
								<input name="NIP2" id="NIP2" class="form-control" type="text" placeholder="Nomor Induk Pegawai..." readonly> <span class="help-block m-b-none">NIP Anda</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-3 control-label">Nomor Induk Kependudukan</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" name="NIK2" id="NIK2" > <span class="help-block m-b-none">NIK Anda</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-xs-3 control-label">Nomor Kartu Keluarga</label>
							<div class="col-xs-9">
								<input type="text" class="form-control" name="NO_KARTU_KELUARGA2" id="NO_KARTU_KELUARGA2" > <span class="help-block m-b-none">Nomor KK Anda</span>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3">Nama Lengkap</label>
							<div class="col-xs-9">
								<input name="NAMA2" id="NAMA2" class="form-control" type="text" placeholder="Nama lengkap Anda..." required><span class="help-block m-b-none">Nama lengkap Anda sesuai identitas diri dan lengkap dengan gelar</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Email</label>
							<div class="col-xs-9">
								<input name="EMAIL2" id="EMAIL2" class="form-control" type="text" placeholder="Email Anda..." required><span class="help-block m-b-none">Alamat email Anda yang aktif</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Nomor Handphone Utama</label>
							<div class="col-xs-9">
								<input name="NO_HP_12" id="NO_HP_12" class="form-control" type="text" placeholder="Nomor handphone utama Anda..." required><span class="help-block m-b-none">Nomor Handphone yang Anda gunakan sehari-hari</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Nomor Handphone Alternatif*</label>
							<div class="col-xs-9">
								<input name="NO_HP_22" id="NO_HP_22" class="form-control" type="text" placeholder="Nomor handphone alternatif Anda..." required><span class="help-block m-b-none">Nomor Handphone yang Anda gunakan sebagai alternatif</span>
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
								<input name="TEMPAT_LAHIR2" id="TEMPAT_LAHIR2" class="form-control" type="text" placeholder="Kota kelahiran Anda..." required><span class="help-block m-b-none">Kota/Kabupaten/Lokasi dimana Anda dilahirkan sesuai identitas diri</span>
							</div>
						</div>
						
						<div class="form-group" id="tanggal_akhir">
							<label class="control-label col-xs-3" >Tanggal Lahir</label>
							<div class="col-xs-9">
								<div class="input-group date"><input type="text" class="form-control" id="TANGGAL_LAHIR2" name="TANGGAL_LAHIR2">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								<span class="help-block m-b-none">Tanggal kapan Anda dilahirkan sesuai identitas diri</span>
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
								<input name="NPWP2" id="NPWP2" class="form-control" type="text" placeholder="NPWP Anda.." required><span class="help-block m-b-none">Nomor Pokok Wajib Pajak</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Paspor*</label>
							<div class="col-xs-9">
								<input name="PASPOR2" id="PASPOR2" class="form-control" type="text" placeholder="Nomor Paspor Anda.." required><span class="help-block m-b-none">Nomor Paspor Anda yang masih berlaku sampai saat ini</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">BPJS Kesehatan*</label>
							<div class="col-xs-9">
								<input name="BPJS_KESEHATAN2" id="BPJS_KESEHATAN2" class="form-control" type="text" placeholder="Nomor BPJS Kesehatan Anda.." required><span class="help-block m-b-none">Nomor BPJS Kesehatan Anda yang masih berlaku sampai saat ini</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">BPJS Tenaga Kerja*</label>
							<div class="col-xs-9">
								<input name="BPJS_TK2" id="BPJS_TK2" class="form-control" type="text" placeholder="Nomor BPJS Tenaga Kerja Anda.." required><span class="help-block m-b-none">Nomor BPJS Tenaga Kerja Anda yang masih berlaku sampai saat ini</span>
							</div>
						</div>
						
						<div class="ibox-title">* Tidak wajib diisi</div>
						
						
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
                format: "dd/mm/yyyy"
            });
			
			$('#ModalaEdit').on('shown.bs.modal', function () {
				$('#NIK2').focus();
			});
			
			tampil_data_pegawai();	//pemanggilan fungsi tampil data.
	
			
			$('#mydata').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
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
							html += '<tr>'+
									'<td>'+data[i].NIP+'</td>'+
									'<td>'+data[i].NAMA+'</td>'+
									'<td>'+data[i].NIK+'</td>'+
									'<td>'+data[i].TEMPAT_LAHIR+' '+data[i].TANGGAL_LAHIR+'</td>'+
									'<td>'+data[i].NO_HP_1+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].ID_PEGAWAI+'"><i class="fa fa-pencil"></i> Edit </a>'+
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