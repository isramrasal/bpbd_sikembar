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
				Sistem menampilkan semua alamat yang pegawai simpan.
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Alamat</h5>
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
						<th>Status Alamat</th>
						<th>Provinsi</th>
						<th>Kota/Kabupaten</th>
						<th>Kecamatan</th>
						<th>Kelurahan/Desa</th>
						<th>Nama Jalan</td>
						<th>Telepon</td>
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
				<i class="fa fa-envelope modal-icon"></i>
				<h4 class="modal-title">Data Alamat</h4>
				<small class="font-bold">Silakan edit data alamat Pegawai secara lengkap</small>
			</div>
            <?php $attributes = array("id_bidang2" => "contact_form", "id" => "contact_form");
            echo form_open("alamat/update_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">
					
						<div class="form-group">
							<label class="control-label col-xs-3" >ID Alamat</label>
							<div class="col-xs-9">
								<input name="ID_ALAMAT2" id="ID_ALAMAT2" class="form-control" type="text" placeholder="ID Alamat" readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >Status Alamat</label>
							<div class="col-xs-9">
								<select name="STATUS_ALAMAT2" class="form-control" id="STATUS_ALAMAT2">
									<option value=''>- Pilih status -</option>
									<option value='Domisili'>Alamat Domisili</option>
									<option value='Sesuai KTP'>Alamat Sesuai KTP</option>
									<option value='Lainnya'>Alamat Lainnya</option>
								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >Provinsi</label>
							<div class="col-xs-9">
								<input name="PROVINSI2" id="PROVINSI2" class="form-control" type="text" placeholder="Provinsi.." required>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >Kota/Kabupaten</label>
							<div class="col-xs-9">
								<input name="KOTA2" id="KOTA2" class="form-control" type="text" placeholder="Kota/Kabupaten.." required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Kecamatan</label>
							<div class="col-xs-9">
								<input name="KECAMATAN2" id="KECAMATAN2" class="form-control" type="text" placeholder="Kecamatan.." required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Kelurahan/Desa</label>
							<div class="col-xs-9">
								<input name="KELURAHAN2" id="KELURAHAN2" class="form-control" type="text" placeholder="Kelurahan/Desa.." required>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Nama Jalan</label>
							<div class="col-xs-9">
								<textarea style="width:100%" name="NAMA_JALAN2" id="NAMA_JALAN2" class="form-control" type="text" placeholder="Nama Jalan.." required></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Nomor Telepon</label>
							<div class="col-xs-9">
								<input name="TELP_ALAMAT2" id="TELP_ALAMAT2" class="form-control" type="text" placeholder="Nomor Telepon.." required>
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
                        <h4 class="modal-title" id="myModalLabel">Hapus Data Bidang Pekerjaan</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin ingin menghapus data ini?</p>
							<div name="ket_3" id="ket_3"></div>
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
			
			$('#ModalaAdd').on('shown.bs.modal', function () {
				$('#PROVINSI').focus();
			});
						
			tampil_data_master_alamat();	//pemanggilan fungsi tampil data.
			
			$('#mydata').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv', title: 'Alamat'},
                    {extend: 'excel', title: 'Alamat'},
                    {extend: 'pdf', title: 'Alamat'},

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
			function tampil_data_master_alamat(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/alamat/data_alamat',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].NIP+'</td>'+
									'<td>'+data[i].NAMA+'</td>'+
									'<td>'+data[i].STATUS_ALAMAT+'</td>'+
									'<td>'+data[i].PROVINSI+'</td>'+
									'<td>'+data[i].KOTA+'</td>'+
									'<td>'+data[i].KECAMATAN+'</td>'+
									'<td>'+data[i].KELURAHAN+'</td>'+
									'<td>'+data[i].NAMA_JALAN+'</td>'+
									'<td>'+data[i].TELP_ALAMAT+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].ID_ALAMAT+'"><i class="fa fa-pencil"></i> Edit </a>'+' '+
										'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].ID_ALAMAT+'"><i class="fa fa-trash"></i> Hapus</a>'+
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
					url  : "<?php echo base_url('index.php/alamat/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_ALAMAT, STATUS_ALAMAT, PROVINSI, KOTA, KECAMATAN, KELURAHAN, NAMA_JALAN, TELP_ALAMAT){
							$('#ModalaEdit').modal('show');
							$('[name="ID_ALAMAT2"]').val(data.ID_ALAMAT);
							$('[name="STATUS_ALAMAT2"]').val(data.STATUS_ALAMAT);
							$('[name="PROVINSI2"]').val(data.PROVINSI);
							$('[name="KOTA2"]').val(data.KOTA);
							$('[name="KECAMATAN2"]').val(data.KECAMATAN);
							$('[name="KELURAHAN2"]').val(data.KELURAHAN);
							$('[name="NAMA_JALAN2"]').val(data.NAMA_JALAN);
							$('[name="TELP_ALAMAT2"]').val(data.TELP_ALAMAT);
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
					url  : "<?php echo base_url('index.php/alamat/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_ALAMAT, STATUS_ALAMAT, NAMA_JALAN){
							$('#ModalHapus').modal('show');
							$('[name="kode"]').val(id);
							$('#ket_3').html('Alamat: '+ data.STATUS_ALAMAT + ", "+ data.NAMA_JALAN);
						});
					}
				});
			});
			
			//UPDATE DATA 
			$('#btn_update').on('click',function(){
				
				var ID_ALAMAT2=$('#ID_ALAMAT2').val();
				var STATUS_ALAMAT2=$('#STATUS_ALAMAT2').val();
				var PROVINSI2=$('#PROVINSI2').val();
				var KOTA2=$('#KOTA2').val();
				var KECAMATAN2=$('#KECAMATAN2').val();
				var KELURAHAN2=$('#KELURAHAN2').val();
				var NAMA_JALAN2=$('#NAMA_JALAN2').val();
				var TELP_ALAMAT2=$('#TELP_ALAMAT2').val();
				
				$.ajax({
					url  : "<?php echo site_url('alamat/update_data')?>",
					type : "POST",
					dataType : "JSON",
					data : {ID_ALAMAT2:ID_ALAMAT2, STATUS_ALAMAT2:STATUS_ALAMAT2, PROVINSI2:PROVINSI2, KOTA2:KOTA2, KECAMATAN2:KECAMATAN2, KELURAHAN2:KELURAHAN2, NAMA_JALAN2:NAMA_JALAN2, TELP_ALAMAT2:TELP_ALAMAT2},
					success: function(data){
						if (data == true)
						{
							$('#ModalaEdit').modal('hide');
							$('[name="STATUS_ALAMAT"]').val("");
							$('[name="PROVINSI"]').val("");
							$('[name="KOTA"]').val("");
							$('[name="KECAMATAN"]').val("");
							$('[name="KELURAHAN"]').val("");
							$('[name="NAMA_JALAN"]').val("");
							$('[name="TELP_ALAMAT"]').val("");
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
				url  : "<?php echo base_url('index.php/alamat/hapus_data')?>",
				dataType : "JSON",
						data : {kode: kode},
						success: function(data){
								$('#ModalHapus').modal('hide');
								tampil_data_master_alamat();
								window.location.reload();
						}
					});
					return false;
				});

        });

    </script>

</body>

</html>