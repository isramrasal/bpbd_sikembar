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
                        <h5>Pengumuman</h5>
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
						<th>Judul Pengumuman</th>
						<th>Isi Pengumuman</th>
						<th>Tanggal Posting (YYYY-MM-DD)</th>
						<th>Keterangan</th>
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
        <div class="modal inmodal fade" id="ModalaAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
			<div class="modal-content animated bounceInRight">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-bullhorn modal-icon"></i>
				<h4 class="modal-title">Data Pengumuman</h4>
				<small class="font-bold">Silakan tambah data pengumuman secara lengkap</small>
			</div>
			<?php $attributes = array("pengumuman" => "contact_form", "id" => "contact_form");
            echo form_open("pengumuman/simpan_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">

						<div class="form-group">
							<label class="control-label col-xs-3" >Judul Pengumuman</label>
							<div class="col-xs-9">
								<textarea style="width:100%" name="judul" id="judul" class="form-control" type="text" placeholder="Judul Pengumuman.." required></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Isi Pengumuman (Gunakan <code>&lt;br&gt;</code> sebagai spasi paragraf)</label>
							<div class="col-xs-9">
								<textarea style="width:100%" name="isi" id="isi" class="form-control" type="text" placeholder="Isi Pengumuman.." required></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >Keterangan</label>
							<div class="col-xs-9">
								<textarea style="width:100%" name="keterangan" id="keterangan" class="form-control" type="text" placeholder="Keterangan.." required></textarea>
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
				<i class="fa fa-bullhorn modal-icon"></i>
				<h4 class="modal-title">Data Pengumuman</h4>
				<small class="font-bold">Silakan edit data pengumuman secara lengkap</small>
			</div>
            <?php $attributes = array("id_pengumuman2" => "contact_form", "id" => "contact_form");
            echo form_open("pengumuman/update_data", $attributes);?>
				<div class="form-horizontal">
					<div class="modal-body">
						
						<div class="form-group">
							<label class="control-label col-xs-3" >ID Pengumuman</label>
							<div class="col-xs-9">
								<textarea style="width:100%" name="id_pengumuman2" id="id_pengumuman2" class="form-control" type="text" placeholder="ID Pengumuman.." required disabled></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >Judul Pengumuman</label>
							<div class="col-xs-9">
								<textarea style="width:100%" name="judul2" id="judul2" class="form-control" type="text" placeholder="Judul Pengumuman.." required></textarea>
							</div>
						</div>
						
						<div class="form-group">
							<label class="control-label col-xs-3" >Isi Pengumuman (Gunakan <code>&lt;br&gt;</code> sebagai spasi paragraf)</label>
							<div class="col-xs-9">
								<textarea style="width:100%" name="isi2" id="isi2" class="form-control" type="text" placeholder="Isi Pengumuman.." required></textarea>
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-xs-3" >Keterangan</label>
							<div class="col-xs-9">
								<textarea style="width:100%" name="keterangan2" id="keterangan2" class="form-control" type="text" placeholder="Keterangan.." required></textarea>
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
                        <h4 class="modal-title" id="myModalLabel">Hapus Data Pengumuman</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin ingin menghapus data ini?</p>
							<div name="judul_3" id="judul_3"></div>
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
	
	<!-- SUMMERNOTE -->
	<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/summernote/summernote.min.js"></script>


    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
			$('.summernote').summernote();
			
			tampil_data_pengumuman();	//pemanggilan fungsi tampil data.
			
			$('#mydata').dataTable(
			{
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'data pengumuman'},
                    {extend: 'pdf', title: 'data pengumuman'},

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
			function tampil_data_pengumuman(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/pengumuman/data_pengumuman',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].JUDUL+'</td>'+
									'<td>'+data[i].ISI+'</td>'+
									'<td>'+data[i].TANGGAL_POSTING+'</td>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-info btn-xs item_edit" data="'+data[i].ID_PENGUMUMAN+'"><i class="fa fa-pencil"></i> Edit </a>'+' '+
										'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].ID_PENGUMUMAN+'"><i class="fa fa-trash"></i> Hapus</a>'+
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
					url  : "<?php echo base_url('index.php/pengumuman/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_PENGUMUMAN, ID_PEGAWAI, JUDUL, ISI, TANGGAL_POSTING, KETERANGAN){
							$('#ModalaEdit').modal('show');
							$('[name="id_pengumuman2"]').val(data.ID_PENGUMUMAN);
							$('[name="judul2"]').val(data.JUDUL);
							$('[name="isi2"]').val(data.ISI);
							$('[name="keterangan2"]').val(data.KETERANGAN);
							$('#alert-msg-2').html('<div></div>');
						});
					}
				});
				return false;
			});
			
					
			//SIMPAN DATA
			$('#btn_simpan').click(function() {
				var form_data = {
					judul: $('#judul').val(),
					isi: $('#isi').val(),
					keterangan: $('#keterangan').val()
				};
				$.ajax({
					url: "<?php echo site_url('pengumuman/simpan_data'); ?>",
					type: 'POST',
					data: form_data,
					success: function(data){
						if (data != '')
						{
							$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
						}
						else
						{
							$('[name="judul"]').val("");
							$('[name="isi"]').val("");
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
				
				var id_pengumuman2=$('#id_pengumuman2').val();
				var judul2=$('#judul2').val();
				var isi2=$('#isi2').val();
				var keterangan2=$('#keterangan2').val();
				$.ajax({
					url  : "<?php echo site_url('pengumuman/update_data')?>",
					type : "POST",
					dataType : "JSON",
					data : {id_pengumuman2:id_pengumuman2, judul2:judul2, isi2:isi2, keterangan2:keterangan2},
					success: function(data){
						if (data == true)
						{
							$('#ModalaEdit').modal('hide');
							$('[name="id_pengumuman2"]').val("");
							$('[name="judul2"]').val("");
							$('[name="isi2"]').val("");
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

			//GET HAPUS
			$('#show_data').on('click','.item_hapus',function(){
				var id=$(this).attr('data');
				$.ajax({
					type : "GET",
					url  : "<?php echo base_url('index.php/pengumuman/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_PENGUMUMAN, ID_PEGAWAI, JUDUL, ISI, TANGGAL_POSTING, KETERANGAN){
							$('#ModalHapus').modal('show');
							$('[name="kode"]').val(id);
							$('#judul_3').html('Judul Pengumuman: ' + data.JUDUL);
						});
					}
				});
			});
					
			//HAPUS DATA
			$('#btn_hapus').on('click',function(){
				var kode=$('#textkode').val();
				$.ajax({
				type : "POST",
				url  : "<?php echo base_url('index.php/pengumuman/hapus_data')?>",
				dataType : "JSON",
						data : {kode: kode},
						success: function(data){
								$('#ModalHapus').modal('hide');
								tampil_data_pengumuman();
								window.location.reload();
						}
					});
					return false;
			});

        });

    </script>

</body>

</html>