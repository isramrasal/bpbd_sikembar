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
                        <h5>Data Pegawai</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
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
						<th>Nama</th>
						<th>No. Hp</th>
						<th>Bidang Pekerjaan</th>
						<th>Jabatan</th>
						<th>Status Karyawan</th>
                        <th>Aksi</td>
                        
                    </tr>
                    </thead>
                    <tbody id="show_data">
				
					</tbody>
             
                    </table>
					</div>
						<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalaAdd"><span class="fa fa-plus"></span> Tambah Data</a>
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
		
		<!-- MODAL ADD -->
        <div class="modal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Data Pegawai</h3>
            </div>
			<?php $attributes = array("nama_bidang" => "contact_form", "id" => "contact_form");
            echo form_open("pegawai/simpan_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">

						<div class="form-group"><label class="col-sm-3 control-label">NIK</label>
							<div class="col-sm-9"><input type="text" class="form-control" id="NIK" name="NIK"> <span class="help-block m-b-none">Nomor Induk Kependudukan sesuai KTP/KK
							</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">NIP</label>
							<div class="col-sm-9"><input type="text" class="form-control" id="NIP" name="NIP"> <span class="help-block m-b-none">Nomor Induk Pegawai yang telah terdaftar di PT. WME.</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Nama Lengkap</label>
							<div class="col-sm-9"><input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap"> <span class="help-block m-b-none">Nama lengkap sesuai identitas diri Pegawai dan lengkap dengan gelar jika ada.</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Jenis Kelamin</label>
							<div class="col-sm-9">
								<select class="form-control m-b" name="kelamin" id="kelamin">
									<option>Pria</option>
									<option>Wanita</option>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Kota Kelahiran</label>
							<div class="col-sm-9"><input type="text" class="form-control" id="kota_kelahiran" name="kota_kelahiran"> <span class="help-block m-b-none">Kota kelahiran sesuai identitas</span>
							</div>
						</div>
						<div class="form-group" id="data_2"><label class="col-sm-3 control-label">Tanggal Kelahiran</label>
							<div class="col-sm-9">
								<div class="input-group date"><input type="text" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="25/12/1976">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								<span class="help-block m-b-none">Tanggal lahir sesuai identitas.</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Agama</label>
							<div class="col-sm-9">
								<select class="form-control m-b" name="Agama"  id="Agama">
									<option>Islam</option>
									<option>Kristen Katolik</option>
									<option>Kristen Protestan</option>
									<option>Hindu</option>
									<option>Budha</option>
									<option>Kong Hu Cu</option>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Alamat Sesuai Identitas</label>
							<div class="col-sm-9"><textarea style="width:100%" name="alamat_identitas" id="alamat_identitas"></textarea>
								</textarea> <span class="help-block m-b-none">Alamat sesuai identitas Pegawai</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Alamat Domisili</label>
							<div class="col-sm-9"><textarea style="width:100%" name="alamat_domisili"  id="alamat_domisili"></textarea>
								</textarea> <span class="help-block m-b-none">Alamat domisili pegawai saat ini</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Email Alternatif</label>
							<div class="col-sm-9"><textarea style="width:100%" name="email_alternatif"  id="email_alternatif"></textarea>
								</textarea> <span class="help-block m-b-none">Email alternatif pegawai saat ini</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Email Alternatif</label>
							<div class="col-sm-9"><textarea style="width:100%" name="email_alternatif"  id="email_alternatif"></textarea>
								</textarea> <span class="help-block m-b-none">Email alternatif pegawai saat ini</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Nomor Handphone</label>
							<div class="col-sm-9"><input type="text" class="form-control" id="nomor_handphone" name="nomor_handphone"> <span class="help-block m-b-none">Nomor Handphone Pegawai.</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Pendidikan Terakhir</label>
							<div class="col-sm-9">
								<select class="form-control m-b" name="pend_akhir">
									<option>SMP</option>
									<option>SMA</option>
									<option>S1</option>
									<option>S2</option>
									<option>S3</option>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Lembaga Pendidikan Terakhir</label>
							<div class="col-sm-9"><input type="text" class="form-control" id="lembaga_pendidikan_akhir" name="lembaga_pendidikan_akhir"> <span class="help-block m-b-none">Nama lembaga pegawai menempuh pendidikan terakhir.</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Jurusan</label>
							<div class="col-sm-9"><input type="text" class="form-control" id="jurusan" name="jurusan"> <span class="help-block m-b-none">Jurusan ketika mengambil pendidikan terakhir.</span>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">IPK</label>
							<div class="col-sm-9"><input type="text" class="form-control" id="ipk" name="ipk"> <span class="help-block m-b-none">Indeks Prestasi Kumulatif pendidikan terakhir.</span>
							</div>
						</div>
						
						<div class="form-group"><label class="col-sm-3 control-label">Status Pernikahan</label>
							<div class="col-sm-9">
								<select class="form-control m-b" name="status_pernikahan" name="status_pernikahan">
									<option>Menikah</option>
									<option>Lajang</option>
									<option>Duda</option>
									<option>Janda</option>
								</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Nama Suami/Istri</label>
							<div class="col-sm-9"><input type="text" class="form-control" id="nama_suami_istri" name="nama_suami_istri"> <span class="help-block m-b-none">Nama suami/istri pegawai.</span>
							</div>
						</div>
						


						
						<div class="form-group"><label class="col-sm-3 control-label">Bidang Pekerjaan</label>
								<div class="col-sm-9">
									<select class="form-control m-b" name="bidang_pekerjaan">
										<option>Mekanikal</option>
										<option>Elektrikal</option>
										<option>Sipil</option>
										<option>HSSE</option>
										<option>QA/QC</option>
									</select>
								</div>
						</div>
						<div class="form-group"><label class="col-sm-3 control-label">Jabatan</label>
							<div class="col-sm-9">
								<select class="form-control m-b" name="jabatan">
									<option>Manajer</option>
									<option>Project Manajer</option>
									<option>Site Manajer</option>
									<option>Site Construction Manajer</option>
								</select>
							</div>
						</div>
						<div class="form-group" id="data_2"><label class="col-sm-3 control-label">Mulai bekerja</label>
							<div class="col-sm-9">
								<div class="input-group date"><input type="text" class="form-control" name="mulai_kerja_1" value="25/12/1976">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								<span class="help-block m-b-none">Tanggal kapan Pegawai mulai bekerja.</span>
							</div>
						</div>
					
						
						
						<div class="form-group"><label class="col-sm-3 control-label">Upload Pas Foto</label>
								<div class="col-sm-9"><label title="Upload Pas Foto" class="btn btn-primary">
									<input type="file" accept="image/*" name="file" class="hide">
									Upload Pas Foto
									</label> <span class="help-block m-b-none">Ukuran maks. 1 MB dengan tipe data JPG atau PNG.</span>
								</div>
						</div>
							
						<div class="form-group"><label class="col-sm-3 control-label">Upload CV</label>
								<div class="col-sm-9"><label title="Upload CV" class="btn btn-primary">
									<input type="file" accept="application/pdf" name="file_2" class="hide">
									Upload CV
									</label> <span class="help-block m-b-none">Ukuran maks. 3 MB dengan tipe data PDF.</span>
								</div>
						</div>
							
						<div class="form-group"><label class="col-sm-3 control-label">Upload Dokumen Pendukung</label>
								<div class="col-sm-9"><label title="Upload Dokumen Pendukung" class="btn btn-primary">
									<input type="file" accept="application/pdf" name="file_3"  class="hide">
									Upload Dokumen Pendukung
									</label> <span class="help-block m-b-none">Ukuran maks. 3 MB dengan tipe data PDF.</span>
								</div>
						</div>
						
						<div id="alert-msg"></div>

					</div>

					<div class="modal-footer">
						<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
						<button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
					</div>
				</div>
			<?php echo form_close(); ?> 
            </div>
            </div>
        </div>
        <!--END MODAL ADD-->
		
		<!-- MODAL EDIT -->
        <div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Data Data Pegawai </h3>
            </div>
            <?php $attributes = array("id_bidang2" => "contact_form", "id" => "contact_form");
            echo form_open("pegawai/update_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-xs-3" >ID Bidang</label>
							<div class="col-xs-9">
								<input name="id_bidang2" id="id_bidang2" class="form-control" type="text" placeholder="ID Bidang" readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >Nama Data Pegawai</label>
							<div class="col-xs-9">
								<input name="nama_bidang2" id="nama_bidang2" class="form-control" type="text" placeholder="Nama Bidang Pekerjaan.." required>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >Keterangan</label>
							<div class="col-xs-9">
								<input name="keterangan2" id="keterangan2" class="form-control" type="text" placeholder="Keterangan.." required>
							</div>
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
                        <h4 class="modal-title" id="myModalLabel">Hapus Data Data Pegawai</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin ingin menghapus data ini?</p>
							<div name="nama_bidang_3" id="nama_bidang_3"></div>
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

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
			
			tampil_data_pegawai();	//pemanggilan fungsi tampil data.
			
			$('#mydata').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Data_Pegawai'},
                    {extend: 'pdf', title: 'Data_Pegawai'},

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
					url   : '<?php echo base_url()?>index.php/data_pegawai/tampil_data_pegawai',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].NIP+'</td>'+
									'<td>'+data[i].nama_lengkap+'</td>'+
									'<td>'+data[i].nomor_handphone+'</td>'+
									'<td>'+data[i].bidang_pekerjaan+'</td>'+
									'<td>'+data[i].jabatan_saat_ini+'</td>'+
									'<td>'+data[i].status_karyawan+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].id_bidang+'"><i class="fa fa-pencil"></i> Edit </a>'+' '+
										'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].id_bidang+'"><i class="fa fa-trash"></i> Hapus</a>'+' '+
										'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].id_bidang+'"><i class="fa fa-pencil"></i> Edit </a>'+' '+
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
						$.each(data,function(id_bidang, nama_bidang, keterangan){
							$('#ModalaEdit').modal('show');
							$('[name="id_bidang2"]').val(data.id_bidang);
							$('[name="nama_bidang2"]').val(data.nama_bidang);
							$('[name="keterangan2"]').val(data.keterangan);
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
						$.each(data,function(id_bidang, nama_bidang, keterangan){
							$('#ModalHapus').modal('show');
							$('[name="kode"]').val(id);
							$('#nama_bidang_3').html('Data Pegawai: ' + data.nama_bidang);
						});
					}
				});
			});
					
			//SIMPAN DATA
			$('#btn_simpan').click(function() {
				var form_data = {
					nama_bidang: $('#nama_bidang').val(),
					keterangan: $('#keterangan').val(),
				};
				$.ajax({
					url: "<?php echo site_url('pegawai/simpan_data'); ?>",
					type: 'POST',
					data: form_data,
					success: function(data){
						if (data != '')
						{
							$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
						}
						else
						{
							$('[name="nama_bidang"]').val("");
							$('[name="keterangan"]').val("");
							$('#ModalaAdd').modal('hide');
							window.location.reload();
						}
					}
				});
				return false;
			});
			
			//UPDATE DATA 
			$('#btn_update').on('click',function(){
				
				var id_bidang2=$('#id_bidang2').val();
				var nama_bidang2=$('#nama_bidang2').val();
				var keterangan2=$('#keterangan2').val();
				$.ajax({
					url  : "<?php echo site_url('pegawai/update_data')?>",
					type : "POST",
					dataType : "JSON",
					data : {id_bidang2:id_bidang2 , nama_bidang2:nama_bidang2, keterangan2:keterangan2},
					success: function(data){
						if (data == true)
						{
							$('#ModalaEdit').modal('hide');
							$('[name="id_bidang2"]').val("");
							$('[name="nama_bidang2"]').val("");
							$('[name="keterangan2"]').val("");
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

        });

    </script>

</body>

</html>