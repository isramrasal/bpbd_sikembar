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
				Sistem menampilkan nama pegawai calon seleksi promosi jabatan .
			</div>
			
			
			
            <div class="row">
				
				<?php echo form_open("input_skoring/test_data"); ?>
				<div class="col-lg-12">
					<div class="tabs-container">
						<table class="table table-bordered">
							<thead>
							<tr>
								<th>ID 1</th>
								<td><input type="number" name="navid[]" id="navid"></td>
							</tr>
							<tr>
								<th>ID 2</th>
								<td><input type="number" name="navid[]" id="navid"></td>
							</tr>
							<tr>
								<th>Menu IN 1</th>
								<td><input type="text" name="menuin[]"></input></td>
							</tr>
							<tr>
								<th>Menu IN 2</th>
								<td><input type="text" name="menuin[]"></input></td>
							</tr>
							<tr>
								<th>Menu ENG 1</th>
								<td><input type="text" name="menueng[]"></input>
								</td>
							</tr>
							<tr>
								<th>Menu ENG 2</th>
								<td><input type="text" name="menueng[]"></input>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
					<button class="btn btn-primary" id="btn_submit"><i class="fa fa-save"></i> Submit</button>
				</div>
				<?php echo form_close(); ?> 
			
            </div>
        </div>
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
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/wasa/dataTableBaru/jquery-1.11.0.js.download"></script>
	
    <script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- dataTables -->
	
	<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/wasa/dataTableBaru/dataTables.checkboxes.min.js.download"></script>
	
    <!-- Custom and plugin javascript -->
    <script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
    <script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>
	
    <!-- Page-Level Scripts -->
    <script type="text/javascript">
		
	$(document).ready(function() {
		
		//TEST DATA
		$("#btn_submit").click(function(){
			var navid = [];
			$('input[name="navid[]"]').each( function() {
				navid.push(this.value);
			});
			var menuin = [];
			$('input[name="menuin[]"]').each( function() {
				menuin.push(this.value);
			});
			var menueng = [];
			$('input[name="menueng[]"]').each( function() {
				menueng.push(this.value);
			});
				$.ajax({
					url: "<?php echo site_url('input_skoring/test_data'); ?>",
					type: 'post',
					data: {navid:navid,menuin:menuin,menueng:menueng},
					success: function(data){
						alert(data);
						//$('#nav')[0].reset();
					}
				});
		});
		
		

	});

	</script>

</body>

</html>