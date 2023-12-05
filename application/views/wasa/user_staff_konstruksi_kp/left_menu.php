					<div class="logo-element">
						WME
					</div>
					</li>
					<?php if ($left_menu == "dashboard_staff_konstruksi_kp_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Dashboard_staff_konstruksi_kp"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Dashboard_staff_konstruksi_kp"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } ?>

					<?php if($left_menu == "sppb_aktif") {?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/SPPB"><i class="fa fa-compass"></i> <span class="nav-label">SPPB</span> </a>
							
						</li>
						<?php }
						else {?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/SPPB"><i class="fa fa-compass"></i> <span class="nav-label">SPPB</span> </a>
						</li>
					<?php }?>

					<?php if ($left_menu == "RFQ_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/RFQ"><i class="fa fa-clone"></i> <span class="nav-label">RFQ</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/RFQ"><i class="fa fa-clone"></i> <span class="nav-label">RFQ</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "KHP_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/KHP"><i class="fa fa-tags"></i> <span class="nav-label">KHP</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/KHP"><i class="fa fa-tags"></i> <span class="nav-label">KHP</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "SPP_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/SPP"><i class="fa fa-bandcamp"></i> <span class="nav-label">SPP</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/SPP"><i class="fa fa-bandcamp"></i> <span class="nav-label">SPP</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "PO_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/PO"><i class="fa fa-telegram"></i> <span class="nav-label">PO</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/PO"><i class="fa fa-telegram"></i> <span class="nav-label">PO</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "FSTB_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/FSTB"><i class="fa fa-stumbleupon"></i> <span class="nav-label">FSTB</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/FSTB"><i class="fa fa-stumbleupon"></i> <span class="nav-label">FSTB</span></a>
						</li>
					<?php } ?>

					<div class="hr-line-dashed"></div>


					<?php if ($left_menu == "proyek_aktif") { ?>

						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Proyek"><i class="fa fa-group"></i> <span class="nav-label">Proyek</span></a>

						</li>

					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Proyek"><i class="fa fa-group"></i> <span class="nav-label">Proyek</span></a>
						</li>

					<?php } ?>

					<?php if($left_menu == "barang_master_aktif") {?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/barang_master"><i class="fa fa-briefcase"></i> <span class="nav-label">Daftar Barang</span> </a>
							
						</li>
						<?php }
						else {?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/barang_master"><i class="fa fa-briefcase"></i> <span class="nav-label">Daftar Barang</span> </a>
						</li>
						<?php }?>
						
						<?php if($left_menu == "vendor_aktif") {?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/vendor"><i class="fa fa-bullhorn"></i> <span class="nav-label">Vendor</span> </span></a>
							
						</li>
						<?php }
						else {?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/vendor"><i class="fa fa-bullhorn"></i> <span class="nav-label">Vendor</span> </span></a>
						</li>
					<?php }?>


					</div>
					</nav>