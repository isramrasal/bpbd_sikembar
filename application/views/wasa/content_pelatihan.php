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
				Sistem menampilkan data pelatihan seluruh pegawai.
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Pelatihan</h5>
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
						<th>Nama Pelatihan</th>
						<th>Bidang Pelatihan</th>
						<th>Nama Penyelenggara</th>
						<th>Keterangan</th>
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
		
		<!-- MODAL ADD -->
        <div class="modal inmodal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-graduation-cap modal-icon"></i>
				<h4 class="modal-title">Data Pelatihan</h4>
				<small class="font-bold">Silakan isi data pelatihan Anda secara lengkap</small>
			</div>
			<?php $attributes = array("nama_pelatihan" => "contact_form", "id" => "contact_form");
            echo form_open("pelatihan/simpan_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">
					
						<div class="form-group">
							<label class="control-label col-xs-3">Nama Pelatihan</label>
							<div class="col-xs-9">
								<input name="NAMA_PELATIHAN" id="NAMA_PELATIHAN" class="form-control" type="text" placeholder="Nama Pelatihan.." required><span class="help-block m-b-none">Nama kegiatan pelatihan yang Anda ikuti</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Bidang Pelatihan</label>
							<div class="col-xs-9">
								<input name="BIDANG_PELATIHAN" id="BIDANG_PELATIHAN" class="form-control" type="text" placeholder="Bidang Pelatihan.." required><span class="help-block m-b-none">Bidang kegiatan pelatihan yang Anda ikuti</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Nama Penyelenggara</label>
							<div class="col-xs-9">
								<input name="NAMA_PENYELENGGARA" id="NAMA_PENYELENGGARA" class="form-control" type="text" placeholder="Nama Penyelenggara.." required><span class="help-block m-b-none">Nama penyelenggara pelatihan yang Anda ikuti</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Keterangan</label>
							<div class="col-xs-9">
								<input name="KETERANGAN" id="KETERANGAN" class="form-control" type="text" placeholder="Keterangan.." required><span class="help-block m-b-none">Keterangan</span>
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
                <h3 class="modal-title" id="myModalLabel">Edit Data Pelatihan</h3>
            </div>
            <?php $attributes = array("id_pelatihan2" => "contact_form", "id" => "contact_form");
            echo form_open("pelatihan/update_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-xs-3" >ID Pelatihan</label>
							<div class="col-xs-9">
								<input name="ID_PELATIHAN2" id="ID_PELATIHAN2" class="form-control" type="text" placeholder="ID_PELATIHAN" readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3">Nama Pelatihan</label>
							<div class="col-xs-9">
								<input name="NAMA_PELATIHAN2" id="NAMA_PELATIHAN2" class="form-control" type="text" placeholder="Nama Pelatihan.." required><span class="help-block m-b-none">Nama kegiatan pelatihan yang Anda ikuti</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Bidang Pelatihan</label>
							<div class="col-xs-9">
								<input name="BIDANG_PELATIHAN2" id="BIDANG_PELATIHAN2" class="form-control" type="text" placeholder="Bidang Pelatihan.." required><span class="help-block m-b-none">Bidang kegiatan pelatihan yang Anda ikuti</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Nama Penyelenggara</label>
							<div class="col-xs-9">
								<input name="NAMA_PENYELENGGARA2" id="NAMA_PENYELENGGARA2" class="form-control" type="text" placeholder="Nama Penyelenggara.." required><span class="help-block m-b-none">Nama penyelenggara pelatihan yang Anda ikuti</span>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3">Keterangan</label>
							<div class="col-xs-9">
								<input name="KETERANGAN2" id="KETERANGAN2" class="form-control" type="text" placeholder="Keterangan.." required><span class="help-block m-b-none">Keterangan</span>
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
                        <h4 class="modal-title" id="myModalLabel">Hapus Data Pelatihan</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin ingin menghapus data ini?</p>
							<div name="nama_pelatihan_3" id="nama_pelatihan_3"></div>
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
			
			tampil_data_pelatihan();	//pemanggilan fungsi tampil data.
			
			$('#mydata').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv', title: 'Pelatihan'},
                    {extend: 'excel', title: 'Pelatihan'},
                    {extend: 'pdf', title: 'Pelatihan'},

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
			function tampil_data_pelatihan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/pelatihan/data_pelatihan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].NIP+'</td>'+
									'<td>'+data[i].NAMA+'</td>'+
									'<td>'+data[i].NAMA_PELATIHAN+'</td>'+
									'<td>'+data[i].BIDANG_PELATIHAN+'</td>'+
									'<td>'+data[i].NAMA_PENYELENGGARA+'</td>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].ID_PELATIHAN+'"><i class="fa fa-trash"></i> Hapus</a>'+
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
					url  : "<?php echo base_url('index.php/pelatihan/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_PELATIHAN, ID_PEGAWAI, NAMA_PELATIHAN, BIDANG_PELATIHAN, NAMA_PENYELENGGARA, KETERANGAN ){
							$('#ModalaEdit').modal('show');
							$('[name="ID_PELATIHAN2"]').val(data.ID_PELATIHAN);
							$('[name="NAMA_PELATIHAN2"]').val(data.NAMA_PELATIHAN);
							$('[name="BIDANG_PELATIHAN2"]').val(data.BIDANG_PELATIHAN);
							$('[name="NAMA_PENYELENGGARA2"]').val(data.NAMA_PENYELENGGARA);
							$('[name="KETERANGAN2"]').val(data.KETERANGAN);
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
					url  : "<?php echo base_url('index.php/pelatihan/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_PELATIHAN, NAMA_PELATIHAN, NAMA_PENYELENGGARA){
							$('#ModalHapus').modal('show');
							$('[name="kode"]').val(id);
							$('#nama_pelatihan_3').html('Jenjang Pelatihan: ' + data.NAMA_PELATIHAN + ' - '+ data.NAMA_PENYELENGGARA);
						});
					}
				});
			});
			
			//SIMPAN DATA
			$('#btn_simpan').click(function() {
				var form_data = {
					NAMA_PELATIHAN: $('#NAMA_PELATIHAN').val(),
					BIDANG_PELATIHAN: $('#BIDANG_PELATIHAN').val(),
					NAMA_PENYELENGGARA: $('#NAMA_PENYELENGGARA').val(),
					KETERANGAN: $('#KETERANGAN').val(),
				};
				$.ajax({
					url: "<?php echo site_url('pelatihan/simpan_data'); ?>",
					type: 'POST',
					data: form_data,
					success: function(data){
						if (data != '')
						{
							$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
						}
						else
						{
							$('[name="NAMA_PELATIHAN"]').val("");
							$('[name="BIDANG_PELATIHAN"]').val("");
							$('[name="NAMA_PENYELENGGARA"]').val("");
							$('[name="KETERANGAN"]').val("");
							$('#ModalaAdd').modal('hide');
							window.location.reload();
						}
					}
				});
				return false;
			});
			
			//UPDATE DATA 
			$('#btn_update').on('click',function(){
				
				var ID_PELATIHAN2=$('#ID_PELATIHAN2').val();
				var NAMA_PELATIHAN2=$('#NAMA_PELATIHAN2').val();
				var BIDANG_PELATIHAN2=$('#BIDANG_PELATIHAN2').val();
				var NAMA_PENYELENGGARA2=$('#NAMA_PENYELENGGARA2').val();
				var KETERANGAN2=$('#KETERANGAN2').val();
				$.ajax({
					url  : "<?php echo site_url('pelatihan/update_data')?>",
					type : "POST",
					dataType : "JSON",
					data : {ID_PELATIHAN2:ID_PELATIHAN2, NAMA_PELATIHAN2:NAMA_PELATIHAN2, BIDANG_PELATIHAN2:BIDANG_PELATIHAN2, NAMA_PENYELENGGARA2:NAMA_PENYELENGGARA2, KETERANGAN2:KETERANGAN2},
					success: function(data){
						if (data == true)
						{
							$('#ModalaEdit').modal('hide');
							$('[name="ID_PELATIHAN2"]').val("");
							$('[name="NAMA_PELATIHAN2"]').val("");
							$('[name="BIDANG_PELATIHAN2"]').val("");
							$('[name="NAMA_PENYELENGGARA2"]').val("");
							$('[name="KETERANGAN2"]').val("");
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
				url  : "<?php echo base_url('index.php/pelatihan/hapus_data')?>",
				dataType : "JSON",
						data : {kode: kode},
						success: function(data){
								$('#ModalHapus').modal('hide');
								tampil_data_pelatihan();
								window.location.reload();
						}
					});
					return false;
				});

        });

    </script>

</body>

</html>