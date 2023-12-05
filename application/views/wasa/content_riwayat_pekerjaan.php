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
				Sistem menampilkan riwayat pekerjaan internal dan eksternal.
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Riwayat Pekerjaan</h5>
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
						<th>Perusahaan</th>
						<th>Jabatan</th>
						<th>Bidang Pekerjaan</th>
						<th>Awal Bekerja</th>
						<th>Akhir Bekerja</th>
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
		
		<!--MODAL HAPUS-->
        <div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
                        <h4 class="modal-title" id="myModalLabel">Hapus Data Riwayat Pekerjaan</h4>
                    </div>
                    <form class="form-horizontal">
                    <div class="modal-body">
                                          
                            <input type="hidden" name="kode" id="textkode" value="">
                            <div class="alert alert-warning"><p>Apakah Anda yakin ingin menghapus data ini?</p>
							<div name="ket_hapus" id="ket_hapus"></div>
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
			

			tampil_data_master_riwayat_pekerjaan();	//pemanggilan fungsi tampil data.
			
			$('#mydata').dataTable(
			{
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv', title: 'Riwayat_Pekerjaan'},
                    {extend: 'excel', title: 'Riwayat_Pekerjaan'},
                    {extend: 'pdf', title: 'Riwayat_Pekerjaan'},

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
			function tampil_data_master_riwayat_pekerjaan(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/riwayat_pekerjaan/data_riwayat_pekerjaan',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var i;
						for(i=0; i<data.length; i++){
							html += '<tr>'+
									'<td>'+data[i].NIP+'</td>'+
									'<td>'+data[i].NAMA+'</td>'+
									'<td>'+data[i].NAMA_PERUSAHAAN+'</td>'+
									'<td>'+data[i].NAMA_JABATAN+'</td>'+
									'<td>'+data[i].NAMA_BIDANG_PEKERJAAN+'</td>'+
									'<td>'+data[i].TANGGAL_AWAL_BEKERJA+'</td>'+
									'<td>'+data[i].TANGGAL_AKHIR_BEKERJA+'</td>'+
									'<td>'+data[i].KETERANGAN+'</td>'+
									'<td>'+
										'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus" data="'+data[i].ID_RIWAYAT_PEKERJAAN+'"><i class="fa fa-trash"></i> Hapus</a>'+
									'</td>'+
									'</tr>';
						}
						$('#show_data').html(html);
					}

				});
			}

			
			//GET HAPUS
			$('#show_data').on('click','.item_hapus',function(){
				var id=$(this).attr('data');
				$.ajax({
					type : "GET",
					url  : "<?php echo base_url('index.php/riwayat_pekerjaan/get_data')?>",
					dataType : "JSON",
					data : {id:id},
					success: function(data){
						$.each(data,function(ID_RIWAYAT_PEKERJAAN, NAMA_PERUSAHAAN, NAMA_JABATAN){
							$('#ModalHapus').modal('show');
							$('[name="kode"]').val(id);
							$('#ket_hapus').html('Perusahaan: ' + data.NAMA_PERUSAHAAN + ', Jabatan: ' + data.NAMA_JABATAN);
						});
					}
				});
			});
					
			//SIMPAN DATA
			$('#btn_simpan').click(function() {
				var form_data = {
					perusahaan: $('#perusahaan').val(),
					jabatan: $('#jabatan').val(),
					bidang: $('#bidang').val(),
					tanggal_awal_bekerja: $('#tanggal_awal_bekerja').val(),
					tanggal_akhir_bekerja: $('#tanggal_akhir_bekerja').val(),
					keterangan: $('#keterangan').val()
				};
				$.ajax({
					url: "<?php echo site_url('riwayat_pekerjaan/simpan_data'); ?>",
					type: 'POST',
					data: form_data,
					success: function(data){
						if (data != '')
						{
							$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
						}
						else
						{
							$('[name="perusahaan"]').val("");
							$('[name="jabatan"]').val("");
							$('[name="bidang"]').val("");
							$('[name="tanggal_awal_bekerja"]').val("");
							$('[name="tanggal_akhir_bekerja"]').val("");
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
					url  : "<?php echo site_url('riwayat_pekerjaan/update_data')?>",
					type : "POST",
					dataType : "JSON",
					data : {id_bidang2:id_bidang2, nama_bidang2:nama_bidang2, keterangan2:keterangan2},
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
				url  : "<?php echo base_url('index.php/riwayat_pekerjaan/hapus_data')?>",
				dataType : "JSON",
						data : {kode: kode},
						success: function(data){
								$('#ModalHapus').modal('hide');
								tampil_data_master_riwayat_pekerjaan();
								window.location.reload();
						}
					});
					return false;
				});

        });

    </script>

</body>

</html>