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
				Silahkan tekan tombol download untuk mendownload dokumen.
			</div>
			
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Download Dokumen</h5>
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
			
			tampil_download_dokumen();	//pemanggilan fungsi tampil data.
			
			var table = $('#mydata').DataTable(
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
			function tampil_download_dokumen(){
				$.ajax({
					type  : 'ajax',
					url   : '<?php echo base_url()?>index.php/download_dokumen/data_download_dokumen',
					async : false,
					dataType : 'json',
					success : function(data){
						var html = '';
						var foto = '';
						var dokumen_cv = '';
						var ktp = '';
						var bpjs_kesehatan = '';
						var bpjs_ketenagakerjaan = '';
						var paspor = '';
						var kk = '';
						var i;
						for(i=0; i<data.length; i++){
							
							if(data[i].KETERANGAN != null)
							{
							foto = '<a href="<?php echo base_url(); ?>'+data[i].KETERANGAN+'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-cloud-download"></i> Download Pasfoto </a>';
							}
							else
							{
							foto = '<a href="#" class="btn btn-danger btn-sm" target="_blank" disabled><i class="fa fa-cloud-download"></i> Pasfoto Tidak Tersedia </a>';
							}
							
							if(data[i].NAMA_DOKUMEN_CV != null)
							{
							dokumen_cv = '<a href="<?php echo base_url(); ?>assets/upload_dokumen_cv/'+data[i].NAMA_DOKUMEN_CV+'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-cloud-download"></i> Download Dokumen CV </a>';
							}
							else
							{
							dokumen_cv = '<a href="#" class="btn btn-danger btn-sm" target="_blank" disabled><i class="fa fa-cloud-download"></i> Dokumen CV Tidak Tersedia </a>';
							}
							
							if(data[i].NAMA_KTP != null)
							{
							ktp = '<a href="<?php echo base_url(); ?>assets/upload_ktp/'+data[i].NAMA_KTP+'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-cloud-download"></i> Download KTP </a>';
							}
							else
							{
							ktp = '<a href="#" class="btn btn-danger btn-sm" target="_blank" disabled><i class="fa fa-cloud-download"></i> KTP Tidak Tersedia </a>';
							}
							
							if(data[i].NAMA_BPJS_KESEHATAN != null)
							{
							bpjs_kesehatan = '<a href="<?php echo base_url(); ?>assets/upload_bpjs_kesehatan/'+data[i].NAMA_BPJS_KESEHATAN+'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-cloud-download"></i> Download BPJS Kesehatan </a>';
							}
							else
							{
							bpjs_kesehatan = '<a href="#" class="btn btn-danger btn-sm" target="_blank" disabled><i class="fa fa-cloud-download"></i> BPJS Kesehatan Tidak Tersedia </a>';
							}
							
							if(data[i].NAMA_BPJS_KETENAGAKERJAAN != null)
							{
							bpjs_ketenagakerjaan = '<a href="<?php echo base_url(); ?>assets/upload_bpjs_ketenagakerjaan/'+data[i].NAMA_BPJS_KETENAGAKERJAAN+'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-cloud-download"></i> Download BPJS Ketenagakerjaan </a>';
							}
							else
							{
							bpjs_ketenagakerjaan = '<a href="#" class="btn btn-danger btn-sm" target="_blank" disabled><i class="fa fa-cloud-download"></i> BPJS Ketenagakerjaan Tidak Tersedia </a>';
							}
							
							if(data[i].NAMA_PASPOR != null)
							{
							paspor = '<a href="<?php echo base_url(); ?>assets/upload_paspor/'+data[i].NAMA_PASPOR+'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-cloud-download"></i> Download Paspor </a>';
							}
							else
							{
							paspor = '<a href="#" class="btn btn-danger btn-sm" target="_blank" disabled><i class="fa fa-cloud-download"></i> Paspor Tidak Tersedia </a>';
							}
							
							if(data[i].NAMA_KK != null)
							{
							kk = '<a href="<?php echo base_url(); ?>assets/upload_kk/'+data[i].NAMA_KK+'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-cloud-download"></i> Download Kartu Keluarga </a>';
							}
							else
							{
							kk = '<a href="#" class="btn btn-danger btn-sm" target="_blank" disabled><i class="fa fa-cloud-download"></i> Kartu Keluarga Tidak Tersedia </a>';
							}
							
							
							html += '<tr>'+
									'<td>'+data[i].NIP+'</td>'+
									'<td>'+data[i].NAMA+'</td>'+
									'<td>'+data[i].NAMA_JABATAN+'</td>'+
									'<td>'+data[i].NAMA_DEPARTEMEN+'</td>'
									+'<td>'+
									foto+'</br>'+dokumen_cv+'</br>'+ktp+'</br>'+bpjs_kesehatan+'</br>'+bpjs_ketenagakerjaan+'</br>'+paspor+'</br>'+kk
									+'</td>'+
						
									'</tr>';
						}
						$('#show_data').html(html);
					}

				});
			}
			
			setInterval( function () {
				tampil_download_dokumen();
			}, 60000 );

        });
    </script>

</body>

</html>