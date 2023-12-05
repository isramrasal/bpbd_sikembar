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
				NIP adalah nomor induk pegawai.
			</div>
			
			<div class="alert alert-success alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				NIP diperlukan untuk registrasi user baru.
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Nomor Induk Pegawai</h5>
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
						<th>Jabatan</th>
						<th>Departemen</th>
						<th>Status Pegawai&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
						<th>Tanggal Status Kontrak</th>
						<th>Tanggal Status Tetap</th>
						<th>Lama Bekerja(Bulan) </br> Sejak Kontrak </br> Sampai Sekarang</th>
						<th>Lama Bekerja(Bulan) </br> Sejak Tetap </br> Sampai Sekarang</th>
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
		</br>
		
        <div class="footer">
			<div>
				<p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br/> Hak cipta dilindungi undang-undang.</p>
			</div> 
        </div>

        </div>
        </div>
		
		<!-- MODAL ADD -->
		<div class="modal inmodal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-user-circle modal-icon"></i>
				<h4 class="modal-title">Nomor Induk Pegawai</h4>
				<small class="font-bold">Silakan tambah Nomor Induk Pegawai</small>
			</div>
			<?php $attributes = array("nip" => "contact_form", "id" => "contact_form");
            echo form_open("nip/simpan_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-xs-3" >NIP</label>
							<div class="col-xs-9">
								<input name="nip" id="nip" class="form-control" type="text" placeholder="Nomor Induk Pegawai.." required autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >NIK</label>
							<div class="col-xs-9">
								<input name="nik" id="nik" class="form-control" type="text" placeholder="Nomor Induk Kependudukan.." required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Nama Lengkap</label>
							<div class="col-xs-9">
								<input name="nama" id="nama" class="form-control" type="text" placeholder="Nama Lengkap.." required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Status Pegawai</label>
							<div class="col-xs-9">
								<select name="ID_STATUS_PEGAWAI" class="form-control" id="ID_STATUS_PEGAWAI">
									<option value=''>- Pilih Status Pegawai -</option>
									<?php foreach($status_pegawai as $prov){
										echo '<option value="'.$prov->ID_STATUS_PEGAWAI.'">'.$prov->NAMA_STATUS_PEGAWAI.'-'.$prov->KETERANGAN.'</option>';
									} ?>
								</select>
								<span class="help-block m-b-none">Status pegawai saat ini</span>
							</div>
						</div>
						
						<div class="form-group" id="tanggal_akhir">
							<label class="control-label col-xs-3" >Tanggal Status Kontrak</label>
							<div class="col-xs-9">
								<div class="input-group date"><input type="text" class="form-control" id="tanggal_status_kontrak" name="tanggal_status_kontrak">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								<span class="help-block m-b-none">Tanggal pegawai diangkat menjadi pegawai kontrak</span>
							</div>
						</div>
						
						<div class="form-group" id="tanggal_akhir2">
							<label class="control-label col-xs-3" >Tanggal Status Tetap</label>
							<div class="col-xs-9">
								<div class="input-group date"><input type="text" class="form-control" id="tanggal_status_tetap" name="tanggal_status_tetap">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								<span class="help-block m-b-none">Tanggal pegawai diangkat menjadi pegawai tetap</span>
							</div>
						</div>
				
						<div class="form-group">
							<label class="control-label col-xs-3" >Jabatan</label>
							<div class="col-xs-9">
								<select name="ID_JABATAN" class="form-control" id="ID_JABATAN">
									<option value=''>- Pilih Jabatan -</option>
									<?php foreach($jabatan as $prov2){
										echo '<option value="'.$prov2->ID_JABATAN.'">'.$prov2->NAMA_JABATAN.'-'.$prov2->JENIS.'</option>';
									} ?>
								</select>
								<span class="help-block m-b-none">Jabatan pegawai saat ini</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Departemen</label>
							<div class="col-xs-9">
								<select name="ID_DEPARTEMEN" class="form-control" id="ID_DEPARTEMEN">
									<option value=''>- Pilih Departemen -</option>
									<?php foreach($departemen as $prov3){
										echo '<option value="'.$prov3->ID_DEPARTEMEN.'">'.$prov3->NAMA_DEPARTEMEN.'</option>';
									} ?>
								</select>
								<span class="help-block m-b-none">Departemen pegawai saat ini</span>
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
        <div class="modal inmodal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-user-circle modal-icon"></i>
				<h4 class="modal-title">Nomor Induk Pegawai</h4>
				<small class="font-bold">Silakan edit Nomor Induk Pegawai</small>
			</div>
            <?php $attributes = array("id_pegawai2" => "contact_form", "id" => "contact_form");
            echo form_open("nip/update_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">
					
					<div class="alert alert-info alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						NIK dapat diedit di modul data pegawai.
					</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >ID Pegawai</label>
							<div class="col-xs-9">
								<input name="id_pegawai2" id="id_pegawai2" class="form-control" type="text" placeholder="ID Pegawai" readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >NIP</label>
							<div class="col-xs-9">
								<input name="nip2" id="nip2" class="form-control" type="text" placeholder="Nomor Induk Pegawai.." required autofocus>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >NIK</label>
							<div class="col-xs-9">
								<input name="nik2" id="nik2" class="form-control" type="text" placeholder="Nomor Induk Kependudukan.." readonly required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Nama Lengkap</label>
							<div class="col-xs-9">
								<input name="nama2" id="nama2" class="form-control" type="text" placeholder="Nama Lengkap.." required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Status Pegawai</label>
							<div class="col-xs-9">
								<select name="ID_STATUS_PEGAWAI2" class="form-control" id="ID_STATUS_PEGAWAI2">
									<option value=''>- Pilih Status Pegawai -</option>
									<?php foreach($status_pegawai as $prov){
										echo '<option value="'.$prov->ID_STATUS_PEGAWAI.'">'.$prov->NAMA_STATUS_PEGAWAI.'-'.$prov->KETERANGAN.'</option>';
									} ?>
								</select>
								<span class="help-block m-b-none">Status pegawai saat ini</span>
							</div>
						</div>
						
						<div class="form-group" id="tanggal_akhir3">
							<label class="control-label col-xs-3" >Tanggal Status Kontrak</label>
							<div class="col-xs-9">
								<div class="input-group date"><input type="text" class="form-control" id="tanggal_status_kontrak2" name="tanggal_status_kontrak2">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								<span class="help-block m-b-none">Tanggal pegawai diangkat menjadi pegawai kontrak</span>
							</div>
						</div>
						
						<div class="form-group" id="tanggal_akhir4">
							<label class="control-label col-xs-3" >Tanggal Status Tetap</label>
							<div class="col-xs-9">
								<div class="input-group date"><input type="text" class="form-control" id="tanggal_status_tetap2" name="tanggal_status_tetap2">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								<span class="help-block m-b-none">Tanggal pegawai diangkat menjadi pegawai tetap</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Jabatan</label>
							<div class="col-xs-9">
								<select name="ID_JABATAN2" class="form-control" id="ID_JABATAN2">
									<option value=''>- Pilih Jabatan -</option>
									<?php foreach($jabatan as $prov2){
										echo '<option value="'.$prov2->ID_JABATAN.'">'.$prov2->NAMA_JABATAN.'-'.$prov2->JENIS.'</option>';
									} ?>
								</select>
								<span class="help-block m-b-none">Jabatan pegawai saat ini</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Departemen</label>
							<div class="col-xs-9">
								<select name="ID_DEPARTEMEN2" class="form-control" id="ID_DEPARTEMEN2">
									<option value=''>- Pilih Departemen -</option>
									<?php foreach($departemen as $prov3){
										echo '<option value="'.$prov3->ID_DEPARTEMEN.'">'.$prov3->NAMA_DEPARTEMEN.'</option>';
									} ?>
								</select>
								<span class="help-block m-b-none">Departemen pegawai saat ini</span>
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
			
			$('#tanggal_akhir2 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
			
			$('#tanggal_akhir3 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
			
			$('#tanggal_akhir4 .input-group.date').datepicker({
                startView: 1,
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "yyyy-mm-dd"
            });
			
			
			tampil_data_pegawai();	//pemanggilan fungsi tampil data.
			
			$('#mydata').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv', title: 'Nomor Induk Pegawai'},
                    {extend: 'excel', title: 'Nomor Induk Pegawai'},
                    {extend: 'pdf', title: 'Nomor Induk Pegawai'},

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
					url   : '<?php echo base_url()?>index.php/nip/data_pegawai',
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
									'<td>'+data[i].NAMA_JABATAN+'</td>'+
									'<td>'+data[i].NAMA_DEPARTEMEN+'</td>'+
									'<td>'+data[i].NAMA_STATUS_PEGAWAI+'</td>'+
									'<td>'+data[i].TANGGAL_STATUS_KONTRAK+'</td>'+
									'<td>'+data[i].TANGGAL_STATUS_TETAP+'</td>'+
									'<td>'+data[i].LAMA_BEKERJA_KONTRAK+'</td>'+
									'<td>'+data[i].LAMA_BEKERJA_TETAP+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].ID_PEGAWAI+'"><i class="fa fa-pencil"></i> Edit </a>'+' '
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
					url  : "<?php echo base_url('index.php/nip/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_PEGAWAI, NIP, NIK, NAMA, ID_STATUS_PEGAWAI, ID_JABATAN, ID_DEPARTEMEN, TANGGAL_STATUS_KONTRAK, TANGGAL_STATUS_TETAP ){
							$('#ModalaEdit').modal('show');
							$('[name="id_pegawai2"]').val(data.ID_PEGAWAI);
							$('[name="nip2"]').val(data.NIP);
							$('[name="nik2"]').val(data.NIK);
							$('[name="nama2"]').val(data.NAMA);
							$('[name="ID_STATUS_PEGAWAI2"]').val(data.ID_STATUS_PEGAWAI);
							$('[name="ID_JABATAN2"]').val(data.ID_JABATAN);
							$('[name="ID_DEPARTEMEN2"]').val(data.ID_DEPARTEMEN);
							$('[name="tanggal_status_kontrak2"]').val(data.TANGGAL_STATUS_KONTRAK);
							$('[name="tanggal_status_tetap2"]').val(data.TANGGAL_STATUS_TETAP);
							$('#alert-msg-2').html('<div></div>');
						});
					}
				});
				return false;
			});
			
					
			//SIMPAN DATA
			$('#btn_simpan').click(function() {
				var form_data = {
					nip: $('#nip').val(),
					nik: $('#nik').val(),
					nama: $('#nama').val(),
					ID_STATUS_PEGAWAI: $('#ID_STATUS_PEGAWAI').val(),
					ID_JABATAN: $('#ID_JABATAN').val(),
					ID_DEPARTEMEN: $('#ID_DEPARTEMEN').val(),
					tanggal_status_kontrak: $('#tanggal_status_kontrak').val(),
					tanggal_status_tetap: $('#tanggal_status_tetap').val(),
				};
				$.ajax({
					url: "<?php echo site_url('nip/simpan_data'); ?>",
					type: 'POST',
					data: form_data,
					success: function(data){
						if (data != '')
						{
							$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
						}
						else
						{
							$('[name="nip"]').val("");
							$('[name="nik"]').val("");
							$('[name="nama"]').val("");
							$('[name="ID_STATUS_PEGAWAI"]').val("");
							$('[name="ID_JABATAN"]').val("");
							$('[name="ID_DEPARTEMEN"]').val("");
							$('[name="tanggal_status_kontrak"]').val("");
							$('[name="tanggal_status_tetap"]').val("");
							$('#ModalaAdd').modal('hide');
							window.location.reload();
						}
					}
				});
				return false;
			});
			
			//UPDATE DATA 
			$('#btn_update').on('click',function(){
				
				var id_pegawai2=$('#id_pegawai2').val();
				var nip2=$('#nip2').val();
				var nama2=$('#nama2').val();
				var ID_STATUS_PEGAWAI2=$('#ID_STATUS_PEGAWAI2').val();
				var ID_JABATAN2=$('#ID_JABATAN2').val();
				var ID_DEPARTEMEN2=$('#ID_DEPARTEMEN2').val();
				var tanggal_status_kontrak2=$('#tanggal_status_kontrak2').val();
				var tanggal_status_tetap2=$('#tanggal_status_tetap2').val();
				$.ajax({
					url  : "<?php echo site_url('nip/update_data')?>",
					type : "POST",
					dataType : "JSON",
					data : {id_pegawai2:id_pegawai2, nip2:nip2, nama2:nama2, ID_STATUS_PEGAWAI2:ID_STATUS_PEGAWAI2, ID_JABATAN2:ID_JABATAN2, ID_DEPARTEMEN2:ID_DEPARTEMEN2, tanggal_status_kontrak2:tanggal_status_kontrak2, tanggal_status_tetap2:tanggal_status_tetap2},
					success: function(data){
						if (data == true)
						{
							$('#ModalaEdit').modal('hide');
							$('[name="id_pegawai2"]').val("");
							$('[name="nip2"]').val("");
							$('[name="nik2"]').val("");
							$('[name="nama2"]').val("");
							$('[name="ID_STATUS_PEGAWAI2"]').val("");
							$('[name="ID_JABATAN2"]').val("");
							$('[name="ID_DEPARTEMEN2"]').val("");
							$('[name="tanggal_status_kontrak2"]').val("");
							$('[name="tanggal_status_tetap2"]').val("");
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