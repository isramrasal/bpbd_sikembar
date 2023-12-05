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
                        <h5>Registrasi User</h5>
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
						<th>Jabatan</th>
						<th>Departemen</th>
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
				<i class="fa fa-send-o modal-icon"></i>
				<h4 class="modal-title">Registrasi User</h4>
				<small class="font-bold">Silakan Registrasi User</small>
			</div>
            <?php $attributes = array("id_registrasi_user2" => "contact_form", "id" => "contact_form");
            echo form_open("registrasi_user/update_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-xs-3" >ID Pegawai</label>
							<div class="col-xs-9">
								<input name="id_pegawai2" id="id_pegawai2" class="form-control" type="text" readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >NIP</label>
							<div class="col-xs-9">
								<input name="nip2" id="nip2" class="form-control" type="text" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Nama Pegawai</label>
							<div class="col-xs-9">
								<input name="nama2" id="nama2" class="form-control" type="text" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Jabatan</label>
							<div class="col-xs-9">
								<input name="jabatan2" id="jabatan2" class="form-control" type="text" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Departemen</label>
							<div class="col-xs-9">
								<input name="departemen2" id="departemen2" class="form-control" type="text" readonly>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Email</label>
							<div class="col-xs-9">
								<input name="email2" id="email2" class="form-control" type="text">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Password</label>
							<div class="col-xs-9">
								<input name="ganti_password2" id="ganti_password2" class="form-control" type="text">
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Ketik Ulang Password</label>
							<div class="col-xs-9">
								<input name="ganti_password3" id="ganti_password3" class="form-control" type="text">
							</div>
						</div>
						

						<div id="alert-msg-2"></div>

					</div>

					<div class="modal-footer">
						<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
						<button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Registrasi</button>
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

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
			
			
			tampil_data_registrasi_user();	//pemanggilan fungsi tampil data.
			
			$('#mydata').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Registrasi User'},
                    {extend: 'pdf', title: 'Registrasi User'},

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
			function tampil_data_registrasi_user(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/registrasi_user/data_registrasi_user',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].NIP+'</td>'+
									'<td>'+data[i].NAMA+'</td>'+
									'<td>'+data[i].NAMA_JABATAN+'</td>'+
									'<td>'+data[i].NAMA_DEPARTEMEN+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].ID_PEGAWAI+'"><i class="fa fa-send-o"></i> Registrasi User </a>'+
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
					url  : "<?php echo base_url('index.php/registrasi_user/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_PEGAWAI, NIP, NAMA, NAMA_JABATAN, NAMA_DEPARTEMEN){
							$('#ModalaEdit').modal('show');
							$('[name="id_pegawai2"]').val(data.ID_PEGAWAI);
							$('[name="nip2"]').val(data.NIP);
							$('[name="nama2"]').val(data.NAMA);
							$('[name="jabatan2"]').val(data.NAMA_JABATAN);
							$('[name="departemen2"]').val(data.NAMA_DEPARTEMEN);
							$('#alert-msg-2').html('<div></div>');
						});
					}
				});
				return false;
			});
			
			//UPDATE DATA 
			$('#btn_update').on('click',function(){
				
				var id_pegawai2=$('#id_pegawai2').val();
				var email2=$('#email2').val();
				var ganti_password2=$('#ganti_password2').val();
				var ganti_password3=$('#ganti_password3').val();
				
				$.ajax({
					url  : "<?php echo site_url('registrasi_user/update_data')?>",
					type : "POST",
					dataType : "JSON",
					data : {id_pegawai2:id_pegawai2, email2:email2, ganti_password2:ganti_password2, ganti_password3:ganti_password3},
					success: function(data){
						if (data == true)
						{
							$('#ModalaEdit').modal('hide');
							$('[name="user_id2"]').val("");
							$('[name="id_pegawai2"]').val("");
							$('[name="nip2"]').val("");
							$('[name="nama2"]').val("");
							$('[name="jabatan2"]').val("");
							$('[name="departemen2"]').val("");
							$('[name="email2"]').val("");
							$('[name="ganti_password2"]').val("");
							$('[name="ganti_password3"]').val("");
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