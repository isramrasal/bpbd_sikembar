<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Manajemen User</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li >
					<a href="<?php echo base_url('index.php/user/') ?>">User</a>	
			</li>
			<li class="active">
				<strong>
					<a>Manajemen User</a>
				</strong>
			</li>
		</ol>
	</div>
</div>
            
	<div class="wrapper wrapper-content animated fadeInRight">
	
		<div class="alert alert-warning alert-dismissable">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			Pastikan Anda mengatur user dengan benar.
		</div>
		
		<div class="alert alert-info alert-dismissable">
			<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
			Role pada sistem terdiri dari 3 jenis, yaitu Staff, Manager dan Direktur. Untuk konfigurasi role Administrator silakan hubungi Administrator.
		</div>
		
		<div class="row">
			<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Manajemen User</h5>
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
					<th>Email Username</th>
					<th>Role</th>
					<th>Status User</th>
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
			<p><strong>&copy; <?php echo date('Y'); ?> PT. Wasa Mitra Enginering</strong><br/> Hak cipta dilindungi undang-undang.</p>
		</div> 
	</div>

	</div>
	</div>
	
	<!-- MODAL EDIT -->
	<div class="modal inmodal fade" id="ModalaEdit_role_user" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<i class="fa fa-random modal-icon"></i>
			<h4 class="modal-title">Data Role User</h4>
			<small class="font-bold">Silakan edit data Role User Pegawai</small>
		</div>
		<?php $attributes = array("id_manajemen_user2" => "contact_form", "id" => "contact_form");
		echo form_open("manajemen_user/update_data_role_user", $attributes);?>
			<div class="form-horizontal">
				<div class="modal-body">
				
					
					<input name="id_user2" id="id_user2" class="form-control" type="hidden" readonly>

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
						<label class="control-label col-xs-3">Status User</label>
						<div class="col-xs-9">
							<select name="status_user2" class="form-control" id="status_user2">
								<option value=''>- Pilih Status User -</option>
								<option value='1'>Aktif</option>
								<option value='0'>Non-Aktif</option>
							</select>
						</div>
					</div>


					<div class="form-group">
						<label class="control-label col-xs-3">Role User</label>
						<div class="col-xs-9">
							<select name="role_user2" class="form-control" id="role_user2">
								<option value=''>- Pilih Role User -</option>
								<option value='2'>Role Staff Logistic</option>
								<option value='3'>Role Supervisor Logistic</option>
								<option value='17'>Role Staff Procurement</option>
								<option value='18'>Role Kepala Seksi Procurement</option>
								<option value='4'>Role Chief Proyek</option>
								<option value='5'>Role SM Proyek</option>
								<option value='6'>Role PM Proyek</option>
								<option value='7'>Role Manajer Logistic</option>
								<option value='8'>Role Manajer Procurement</option>
								<option value='9'>Role Manajer SDM</option>
								<option value='10'>Role Manajer Konstruksi</option>
								<option value='11'>Role Manajer EP</option>
								<option value='12'>Role Manajer QAQC</option>
								<option value='13'>Role Manajer Keuangan</option>
								<option value='14'>Role Direktur PSDS</option>
								<option value='15'>Role Direktur Keuangan</option>
								<option value='16'>Role Direktur Konstruksi</option>
							</select>
						</div>
					</div>

					<div id="alert-msg-2"></div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" id="btn_update_role_user"><i class="fa fa-save"></i> Update</button>
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
		
		
		tampil_data_manajemen_user();	//pemanggilan fungsi tampil data.
		
		$('#mydata').dataTable(
		{
			pageLength: 25,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
				{extend: 'copy'},
				{extend: 'csv'},
				{extend: 'excel', title: 'Role User'},
				{extend: 'pdf', title: 'Role User'},

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
		function tampil_data_manajemen_user(){
			$.ajax({
				type  : 'ajax',
				url   : '<?php echo base_url()?>index.php/manajemen_user/data_manajemen_user',
				async : false,
				dataType : 'json',
				success : function(data){
					var html = '';
					var i;
					for(i=0; i<data.length; i++){

						if (data[i].STATUS_USER=="1")
						{
							html_status = '<td> <span class="label label-primary block">' + 'Aktif' + '</span></td>';
						}
						if (data[i].STATUS_USER=="0")
						{
							html_status = '<td> <span class="label label-danger block">' + 'Non-Aktif'+ '</span></td>';
						}

						html += '<tr>'+
								'<td>'+data[i].NIP+'</td>'+
								'<td>'+data[i].NAMA+'</td>'+
								'<td>'+data[i].username+'</td>'+
								'<td>'+data[i].name+'</td>'+
								html_status + 
								'<td>'+
									'<a href="javascript:;" class="btn btn-info btn-xs block item_edit" data="'+data[i].id+'"><i class="fa fa-pencil"></i> Edit Role </a>'+
									'<a href="javascript:;" class="btn btn-warning btn-xs block item_edit_otorisasi" data="'+data[i].id+'"><i class="fa fa-pencil"></i> Edit Otorisasi </a>'+
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
				url  : "<?php echo base_url('index.php/manajemen_user/get_data_role_user')?>",
				dataType : "JSON",
				data : {id:id},
				success: function(data){
					$.each(data,function(
					user_id,
					ID_PEGAWAI,
					NIP,
					NAMA,
					group_id,
					activation_code,
					active,
					ID_PEGAWAI,
					STATUS_DATA_PEGAWAI
					){
						$('#ModalaEdit_role_user').modal('show');
						$('[name="id_user2"]').val(data.user_id);
						$('[name="id_pegawai2"]').val(data.ID_PEGAWAI);
						$('[name="nip2"]').val(data.NIP);
						$('[name="nama2"]').val(data.NAMA);
						$('[name="status_user2"]').val(data.active);
						$('[name="role_user2"]').val(data.group_id);
						$('#alert-msg-2').html('<div></div>');
					});
				}
			});
			return false;
		});
		
		//UPDATE DATA 
		$('#btn_update_role_user').on('click',function(){
			
			var id_user2=$('#id_user2').val();
			var status_user2=$('#status_user2').val();
			var role_user2=$('#role_user2').val();
			
			$.ajax({
				url  : "<?php echo site_url('manajemen_user/update_data_role_user')?>",
				type : "POST",
				dataType : "JSON",
				data : {id_user2:id_user2, status_user2:status_user2, role_user2:role_user2},
				success: function(data){
					if (data == true)
					{
						$('#ModalaEdit_role_user').modal('hide');
						$('[name="id_pegawai2"]').val("");
						$('[name="role_user2"]').val("");
						$('[name="status_user2"]').val("");
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