<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Profil Vendor</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li >
					<a href="<?php echo base_url('index.php/vendor/') ?>">Vendor</a>	
			</li>
			<li class="active">
				<strong>
					<a>Profil Vendor</a>
				</strong>
			</li>
		</ol>
	</div>
</div>
            
        <div class="wrapper wrapper-content animated fadeInRight">

			<?php foreach ($query_vendor_HASH_MD5_result as $data_vendor) {?>
			<div class="ibox-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="m-b-md">
							<h2>Profil Vendor</h2>
						</div>
						<dl class="dl-horizontal">
							<?php if($data_vendor->STATUS_VENDOR=="Aktif")
							{
							?>
							<dt>Status:</dt> <dd><span class="label label-primary">Aktif</span></dd>
							<?php 
							}
							?>
							<?php if($data_vendor->STATUS_VENDOR=="Tidak Aktif")
							{
							?>
							<dt>Status:</dt> <dd><span class="label label-danger">Tidak Aktif</span></dd>
							<?php 
							}
							?>
							
						</dl>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-5">
						<dl class="dl-horizontal">

							<dt>Nama Vendor:</dt> <dd><?php echo $data_vendor->NAMA_VENDOR; ?></dd>
							<dt>Alamat Vendor:</dt> <dd>  <?php echo $data_vendor->ALAMAT_VENDOR; ?></dd>
							<dt>Nomor Telepon Vendor:</dt> <dd>  <?php echo $data_vendor->NO_TELP_VENDOR; ?></dd>
							<dt>Email Vendor:</dt> <dd>  <?php echo $data_vendor->EMAIL_VENDOR; ?></dd>
						</dl>
					</div>
					<div class="col-lg-5">
						<dl class="dl-horizontal">

							<dt>Nama PIC Vendor:</dt> <dd><?php echo $data_vendor->NAMA_PIC_VENDOR; ?></dd>
							<dt>Nomor HP PIC Vendor:</dt> <dd>  <?php echo $data_vendor->NO_HP_PIC_VENDOR; ?></dd>
							<dt>Email PIC Vendor:</dt> <dd>  <?php echo $data_vendor->EMAIL_PIC_VENDOR; ?></dd>

						</dl>
					</div>
				</div>
			</div>
			<?php } ?>

			</br>
			<div class="alert alert-danger alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				Sistem menampilkan seluruh file dokumen yang diupload.
			</div>


			<?php if($FILE == "ADA") {?>
				<div class="row">
					<div class="col-lg-9 animated fadeInRight">
						<div class="row">
						<div class="col-lg-12">
							<?php foreach ($dokumen as $vendor_file) {?>
							
							<div class="file-box">
							<div class="file">
								<a href="#">
									<span class="corner"></span>

									<div class="icon">
										<i class="fa fa-file"></i>
									</div>
									<div class="file-name">
									<a href="<?php echo base_url(); ?>assets/upload_vendor_npwp/<?php echo $vendor_file->DOK_FILE; ?>">Download file</a>
										<br/>
										<small>Jenis file: <?php echo $vendor_file->JENIS_FILE; ?></small>
										<br/>
										<small>Keterangan file: <?php echo $vendor_file->KETERANGAN_FILE; ?></small>
										<br/>
										<small>Diupload: <?php echo $vendor_file->TANGGAL_UPLOAD; ?></small>
									</div>
									<input type="button" class="btn btn-block btn-outline btn-danger" onclick="location.href='<?php echo base_url(); ?>index.php/vendor/hapus_file/<?php echo $vendor_file->DOK_FILE; ?>';" value="Hapus" />

								</a>
							</div>
							</div>
							
							<?php } ?>
							</div>
						
						</div>
					</div>
				</div>

			<?php }
			else {?>


			<div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
							<h5>Download File Dokumen</h5>
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
							Belum ada file dokumen. Silakan upload file dokumen.
						</div>

                    </div>
                </div>
			</div>
			<?php }?>
		
			<div class="alert alert-info alert-dismissable">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
				Silakan upload file dokumen sesuai dengan ketentuan.
			</div>
			
            
			<div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
							<h5>Upload File Dokumen</h5>
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
							

                            <p>
                               File dokumen yang Anda upload akan digunakan untuk keperluan vendor/penyedia/supplier, dengan ketentuan sebagai berikut:
								<ul class="sortable-list connectList agile-list" id="ketentuan">
                                <li class="warning-element" id="task1">
                                    1. File dokumen yang diupload harus merupakan data milik vendor.
                                </li>
								<li class="danger-element" id="task2">
                                    2. Ukuran dokumen yang diterima sistem maksimal 5 Mega Bytes (5 MB).
                                </li>
								<li class="success-element" id="task4">
                                    3. Ekstensi/tipe file yang diterima sistem adalah .PDF dan .JPEG/.JPG/.BMP.
								</li>

								<li class="warning-element" id="task1">
									4. Pilih jenis File Dokumen sebelum melakukan upload.
									</br>
										
								</li>
								
							</ul>
							</p>


                            <form action="#" class="dropzone" id="dropzoneForm">
                                
								</br>
								<div class="col-xs-3">
									<select name="JENIS_FILE" id="JENIS_FILE" class="block">
										<option value='Belum didefinisikan'>- Pilih Jenis File Dokumen -</option>
										<option value='NPWP'>NPWP</option>
										<option value='SIUP'>SIUP</option>
										<option value='Akta Pendirian/Perubahan'>Akta Pendirian/Perubahan</option>
										<option value='Laporan Keuangan'>Laporan Keuangan</option>
										<option value='Dokumen Lainnya'>Dokumen Lainnya</option>
									</select>
									</br>
									<input name="KETERANGAN_FILE" id="KETERANGAN_FILE" class="form-control" type="text" placeholder="Keterangan File Dokumen" required autofocus>

								</div>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								</br>
								<div class="fallback">
                                    <input name="file" type="file" multiple />
								</div>
							</form>
							
							<div>
							</br>
							<button class="btn btn-primary" name="btn_upload" id="btn_upload"><i class="fa fa-save"></i> Upload</button>
							</div>
						
                        </div>
                    </div>
                </div>
            </div>
			</br>
			</br></br>

			
        </div>
		</br>
		</br>
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

    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>
	
	<!-- DROPZONE -->
     <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dropzone/dropzone.js"></script>

    <!-- Page-Level Scripts -->
    <script>
	
		Dropzone.autoDiscover = false;
	
		Dropzone.options.dropzoneForm = {
			paramName: "file", // The name that will be used to transfer the file
			autoProcessQueue: false,
            maxFilesize: 5, // MB
			maxFiles: 1,
            dictDefaultMessage: "<strong>Letakkan file di sini atau klik untuk memuat file. </strong></br> (Pastikan file yang Anda upload sesuai dengan ketentuan)",
			dictFileTooBig: "Maaf ukuran file tidak sesuai ketentuan."
		};
		


		var file_upload= new Dropzone(".dropzone",{
			url: "<?php echo base_url('index.php/vendor/proses_upload_file') ?>",
			maxFilesize: 5,
			method:"post",
			acceptedFiles:"image/jpeg,image/png,image/jpg,image/bmp,application/pdf",
			paramName:"userfile",
			dictInvalidFileType:"Maaf ekstensi/tipe file tidak sesuai ketentuan.",
			addRemoveLinks:true,
			init: function() {
				var myDropzone = this;

				// Update selector to match your button
				$("#btn_upload").click(function (e) {
					e.preventDefault();
					myDropzone.processQueue();
					var form_data = {
						JENIS_FILE: $('#JENIS_FILE').val(),
						KETERANGAN_FILE: $('#KETERANGAN_FILE').val()
					};
					$.ajax({
						url: "<?php echo base_url('index.php/vendor/proses_upload_file') ?>",
						type: 'POST',
						data: form_data,
						success: function(data) {
							if (data != '') {
								console.log("waduh");
							} else {
								console.log("waduh 2");
							}
						}
					});
				});


				this.on("success", function(file, responseText) {
					location.reload();;
				});
			}
		});


		//Event ketika Memulai mengupload
		file_upload.on("sending",function(a,b,c){
			a.token=Math.random();
			c.append("token_npwp",a.token); //Mempersiapkan token untuk masing masing npwp
		});


		//Event ketika data dihapus
		file_upload.on("removedfile",function(a){
			var token=a.token;
			$.ajax({
				type:"post",
				data:{token:token},
				url:"<?php echo base_url('index.php/vendor/remove_file') ?>",
				cache:false,
				dataType: 'json',
				success: function(){
					console.log("Data terhapus");
				},
				error: function(){
					console.log("Error");
				}
			});
		});

	</script>
	
	<script>
        $(document).ready(function(){
            $('.file-box').each(function() {
                animationHover(this, 'pulse');
            });
        });
    </script>

</body>

</html>