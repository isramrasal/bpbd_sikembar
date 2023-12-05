<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Organisasi Proyek</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/proyek/') ?>">Proyek</a>
			</li>
			<li class="active">
				<strong>
					<a>Organisasi Proyek</a>
				</strong>
			</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="ibox float-e-margins">
				<?php foreach ($query_proyek_HASH_MD5_PROYEK_result as $data_proyek) { ?>
					<div class="ibox-title">
						<h5>Info Proyek</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="fullscreen-link">
								<i class="fa fa-expand"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<dl class="dl-horizontal">
									<?php if ($data_proyek->STATUS_PROYEK == "Berjalan") {
									?>
										<dt>Status:</dt>
										<dd><span class="label label-primary">Berjalan</span></dd>
									<?php
									}
									?>
									<?php if ($data_proyek->STATUS_PROYEK == "Selesai") {
									?>
										<dt>Status:</dt>
										<dd><span class="label label-danger">Selesai</span></dd>
									<?php
									}
									?>

								</dl>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-5">
								<dl class="dl-horizontal">

									<dt>Nama Proyek:</dt>
									<dd><?php echo $data_proyek->NAMA_PROYEK; ?></dd>
									<dt>Lokasi Proyek:</dt>
									<dd> <?php echo $data_proyek->LOKASI; ?></dd>
									<dt>Inisial Proyek:</dt>
									<dd> <?php echo $data_proyek->INISIAL; ?></dd>
								</dl>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="ibox float-e-margins">
				<div id="alert-msg"></div>
				<div class="ibox-title">
					<h5>Organisasi Proyek</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="fullscreen-link">
							<i class="fa fa-expand"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="panel-body">
						<?php $attributes = array("name" => "contact_form", "id" => "contact_form");
						echo form_open("proyek/update_data_organisasi", $attributes); ?>
						<fieldset class="form-horizontal">
							<input type="hidden" class="form-control" name="ID_PROYEK" id="ID_PROYEK" required disabled>

							<div class="form-group"><label class="col-sm-2 control-label">Project Manager</label>
								<div class="col-sm-10">
									<select name="ID_PEGAWAI_PM" class="form-control" id="ID_PEGAWAI_PM">
										<option value=''>- Pilih Project Manager -</option>
										<?php foreach ($pegawai_proyek as $peg) {
											echo '<option value="' . $peg->ID_PEGAWAI . '">' . $peg->NAMA . '</option>';
										} ?>
									</select>
								</div>
							</div>

							<div class="form-group"><label class="col-sm-2 control-label">Site Manager</label>
								<div class="col-sm-10">
									<select name="ID_PEGAWAI_SM" class="form-control" id="ID_PEGAWAI_SM">
										<option value=''>- Pilih Site Manager -</option>
										<?php foreach ($pegawai_proyek as $peg) {
											echo '<option value="' . $peg->ID_PEGAWAI . '">' . $peg->NAMA . '</option>';
										} ?>
									</select>
								</div>
							</div>

							<div class="form-group"><label class="col-sm-2 control-label">Supervisor Logistik</label>
								<div class="col-sm-10">
									<select name="ID_PEGAWAI_LOG" class="form-control" id="ID_PEGAWAI_LOG">
										<option value=''>- Pilih Supervisor Logistik -</option>
										<?php foreach ($pegawai_proyek as $peg) {
											echo '<option value="' . $peg->ID_PEGAWAI . '">' . $peg->NAMA . '</option>';
										} ?>
									</select>
								</div>
							</div>

							<div class="form-group"><label class="col-sm-2 control-label">Supervisor Procurement</label>
								<div class="col-sm-10">
									<select name="ID_PEGAWAI_PROC" class="form-control" id="ID_PEGAWAI_PROC">
										<option value=''>- Pilih Supervisor Procurement -</option>
										<?php foreach ($pegawai_proyek as $peg) {
											echo '<option value="' . $peg->ID_PEGAWAI . '">' . $peg->NAMA . '</option>';
										} ?>
									</select>
								</div>
							</div>
							
						</fieldset>
					</div>
					<button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Simpan</button>
					</br>
					<div id="alert-msg-2"></div>
				</div>
				
			</div>
			


		</div>
	</div>
</div>

</br>
</br>
</br>
<div class="footer">
	<div>
		<p><strong>&copy; 2020 PT. Wasa Mitra Enginering</strong><br /> Hak cipta dilindungi undang-undang.</p>
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
    $(document).ready(function() {
        tampil_data_organisasi_proyek();
        

        //fungsi tampil data
        function tampil_data_organisasi_proyek() {
            var id = "<?php echo $ID_PROYEK; ?>";
            
            console.log(id);
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url() ?>proyek/get_data',
                dataType: 'JSON',
                data: {
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $.each(data, function(
                        ID_PROYEK,
                        PEGAWAI_PM,
                        PEGAWAI_SM,
                        PEGAWAI_LOG,
                        PEGAWAI_PROC,

                    ) {
                        $('[ID="ID_PROYEK"]').val(data.ID_PROYEK);
                        $('[name="ID_PEGAWAI_PM"]').val(data.PEGAWAI_PM);
                        $('[name="ID_PEGAWAI_SM"]').val(data.PEGAWAI_SM);
                        $('[name="ID_PEGAWAI_LOG"]').val(data.PEGAWAI_LOG);
                        $('[name="ID_PEGAWAI_PROC"]').val(data.PEGAWAI_PROC);

                    });
                }

            });
            return false;
        }

        //UPDATE DATA 
        $('#btn_update').on('click', function() {

            var ID_PROYEK = $('#ID_PROYEK').val();
            var ID_PEGAWAI_PM = $('#ID_PEGAWAI_PM').val();
            var ID_PEGAWAI_SM = $('#ID_PEGAWAI_SM').val();
            var ID_PEGAWAI_LOG = $('#ID_PEGAWAI_LOG').val();
            var ID_PEGAWAI_PROC = $('#ID_PEGAWAI_PROC').val();

            $.ajax({
                url: "<?php echo site_url('proyek/update_data_organisasi') ?>",
                type: "POST",
                dataType: "JSON",
                data: {
                    ID_PROYEK: ID_PROYEK,
                    ID_PEGAWAI_PM: ID_PEGAWAI_PM,
                    ID_PEGAWAI_SM: ID_PEGAWAI_SM,
                    ID_PEGAWAI_LOG: ID_PEGAWAI_LOG,
                    ID_PEGAWAI_PROC: ID_PEGAWAI_PROC
                },
                success: function(data) {
                    console.log(data);
                    if (data == true) {
                        window.location.href = "<?php echo base_url(); ?>index.php/proyek";
                        $('[name="ID_PROYEK"]').val('');
                        $('[name="ID_PEGAWAI_PM"]').val(data.ID_PEGAWAI_PM);
                        $('[name="ID_PEGAWAI_SM"]').val(data.ID_PEGAWAI_SM);
                        $('[name="ID_PEGAWAI_LOG"]').val(data.ID_PEGAWAI_LOG);
                        $('[name="ID_PEGAWAI_PROC"]').val(data.ID_PEGAWAI_PROC);
                    } else {
                        $('#alert-msg-2').html('<div class="alert alert-danger">' + data + '</div>');
                    }
                }
            });
            return false;
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