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
				Sistem menampilkan data pendidikan seluruh pegawai.
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Pendidikan</h5>
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
						<th>Nama</th>
						<th>Jenjang Pendidikan</th>
						<th>Institusi</th>
						<th>Alamat</th>
						<th>Tahun Lulus</th>
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
        <div class="modal fade" id="ModalaEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Edit Data Pendidikan</h3>
            </div>
            <?php $attributes = array("id_pendidikan2" => "contact_form", "id" => "contact_form");
            echo form_open("pendidikan/update_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-xs-3" >ID Pendidikan</label>
							<div class="col-xs-9">
								<input name="ID_PENDIDIKAN2" id="ID_PENDIDIKAN2" class="form-control" type="text" placeholder="ID_PENDIDIKAN2" readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3">Jenjang Pendidikan</label>
							<div class="col-xs-9">
								<select name="JENJANG_PENDIDIKAN2" class="form-control" id="JENJANG_PENDIDIKAN2">
									<option value=''>- Pilih Jenjang Pendidikan -</option>
									<option value='S3'>S3</option>
									<option value='S2'>S2</option>
									<option value='S1'>S1</option>
									<option value='D3'>D3</option>
									<option value='SMA sederajat'>SMA sederajat</option>
									<option value='SMP sederajat'>SMP sederajat</option>
									<option value='SD sederajat'>SD sederajat</option>
								</select>
								<span class="help-block m-b-none">Jenjang pendidikan Anda</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Nama Institusi</label>
							<div class="col-xs-9">
								<input name="NAMA_INSTITUSI2" id="NAMA_INSTITUSI2" class="form-control" type="text" placeholder="Nama Institusi.." required><span class="help-block m-b-none">Nama institusi dimana Anda mengenyam pendidikan</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Alamat Institusi</label>
							<div class="col-xs-9">
								<input name="ALAMAT2" id="ALAMAT2" class="form-control" type="text" placeholder="Alamat Institusi.." required><span class="help-block m-b-none">Alamat institusi dimana Anda mengenyam pendidikan</span>
							</div>
						</div>
						
						<div class="form-group" id="tanggal_akhir">
							<label class="control-label col-xs-3" >Tahun Lulus</label>
							<div class="col-xs-9">
								<div class="input-group date"><input type="text" class="form-control" id="TAHUN_LULUS2" name="TAHUN_LULUS2">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								<span class="help-block m-b-none">Tahun kelulusan</span>
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
                        <h4 class="modal-title" id="myModalLabel">Hapus Data Pendidikan</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin ingin menghapus data ini?</p>
							<div name="nama_pendidikan_3" id="nama_pendidikan_3"></div>
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
                minViewMode: "years",
                keyboardNavigation: false,
                forceParse: false,
                forceParse: false,
                autoclose: true,
                todayHighlight: true,
				format: "yyyy"
            });
			
			tampil_data_pendidikan();	//pemanggilan fungsi tampil data.
			
			$('#mydata').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv', title: 'Pendidikan'},
                    {extend: 'excel', title: 'Pendidikan'},
                    {extend: 'pdf', title: 'Pendidikan'},

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
			function tampil_data_pendidikan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/pendidikan/data_pendidikan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].NIP+'</td>'+
									'<td>'+data[i].NAMA+'</td>'+
									'<td>'+data[i].JENJANG_PENDIDIKAN+'</td>'+
									'<td>'+data[i].NAMA_INSTITUSI+'</td>'+
									'<td>'+data[i].ALAMAT+'</td>'+
									'<td>'+data[i].TAHUN_LULUS+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].ID_PENDIDIKAN+'"><i class="fa fa-trash"></i> Hapus</a>'+
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
					url  : "<?php echo base_url('index.php/pendidikan/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_PENDIDIKAN, ID_PEGAWAI, JENJANG_PENDIDIKAN, NAMA_INSTITUSI, TAHUN_LULUS, ALAMAT ){
							$('#ModalaEdit').modal('show');
							$('[name="ID_PENDIDIKAN2"]').val(data.ID_PENDIDIKAN);
							$('[name="JENJANG_PENDIDIKAN2"]').val(data.JENJANG_PENDIDIKAN);
							$('[name="NAMA_INSTITUSI2"]').val(data.NAMA_INSTITUSI);
							$('[name="TAHUN_LULUS2"]').val(data.TAHUN_LULUS);
							$('[name="ALAMAT2"]').val(data.ALAMAT);
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
					url  : "<?php echo base_url('index.php/pendidikan/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_PENDIDIKAN, JENJANG_PENDIDIKAN, NAMA_INSTITUSI){
							$('#ModalHapus').modal('show');
							$('[name="kode"]').val(id);
							$('#nama_pendidikan_3').html('Jenjang Pendidikan: ' + data.JENJANG_PENDIDIKAN + ' - '+ data.NAMA_INSTITUSI);
						});
					}
				});
			});
			
			//SIMPAN DATA
			$('#btn_simpan').click(function() {
				var form_data = {
					JENJANG_PENDIDIKAN: $('#JENJANG_PENDIDIKAN').val(),
					NAMA_INSTITUSI: $('#NAMA_INSTITUSI').val(),
					TAHUN_LULUS: $('#TAHUN_LULUS').val(),
					ALAMAT: $('#ALAMAT').val(),
				};
				$.ajax({
					url: "<?php echo site_url('pendidikan/simpan_data'); ?>",
					type: 'POST',
					data: form_data,
					success: function(data){
						if (data != '')
						{
							$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
						}
						else
						{
							$('[name="JENJANG_PENDIDIKAN"]').val("");
							$('[name="NAMA_INSTITUSI"]').val("");
							$('[name="TAHUN_LULUS"]').val("");
							$('[name="ALAMAT"]').val("");
							$('#ModalaAdd').modal('hide');
							window.location.reload();
						}
					}
				});
				return false;
			});
			
			//UPDATE DATA 
			$('#btn_update').on('click',function(){
				
				var ID_PENDIDIKAN2=$('#ID_PENDIDIKAN2').val();
				var JENJANG_PENDIDIKAN2=$('#JENJANG_PENDIDIKAN2').val();
				var NAMA_INSTITUSI2=$('#NAMA_INSTITUSI2').val();
				var TAHUN_LULUS2=$('#TAHUN_LULUS2').val();
				var ALAMAT2=$('#ALAMAT2').val();
				$.ajax({
					url  : "<?php echo site_url('pendidikan/update_data')?>",
					type : "POST",
					dataType : "JSON",
					data : {ID_PENDIDIKAN2:ID_PENDIDIKAN2, JENJANG_PENDIDIKAN2:JENJANG_PENDIDIKAN2, NAMA_INSTITUSI2:NAMA_INSTITUSI2, TAHUN_LULUS2:TAHUN_LULUS2, ALAMAT2:ALAMAT2},
					success: function(data){
						if (data == true)
						{
							$('#ModalaEdit').modal('hide');
							$('[name="ID_PENDIDIKAN2"]').val("");
							$('[name="JENJANG_PENDIDIKAN2"]').val("");
							$('[name="NAMA_INSTITUSI2"]').val("");
							$('[name="TAHUN_LULUS2"]').val("");
							$('[name="ALAMAT2"]').val("");
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
				url  : "<?php echo base_url('index.php/pendidikan/hapus_data')?>",
				dataType : "JSON",
						data : {kode: kode},
						success: function(data){
								$('#ModalHapus').modal('hide');
								tampil_data_pendidikan();
								window.location.reload();
						}
					});
					return false;
				});

        });

    </script>

</body>

</html>