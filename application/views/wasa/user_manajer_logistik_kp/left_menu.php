					<div class="logo-element">
						WME
					</div>
					</li>
					<?php if ($left_menu == "dashboard_manajer_logistik_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Dashboard_manajer_logistik_kp"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Dashboard_manajer_logistik_kp"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "FPB_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/FPB"><i class="fa fa-book"></i> <span class="nav-label">FPB</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/FPB"><i class="fa fa-book"></i> <span class="nav-label">FPB</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "sppb_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/SPPB"><i class="fa fa-compass"></i> <span class="nav-label">SPPB</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/SPPB"><i class="fa fa-compass"></i> <span class="nav-label">SPPB</span></a>
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

					<?php if ($left_menu == "RPB_form_aktif" || $left_menu == "Rencana_Pengiriman_Barang_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Rencana_Pengiriman_Barang"><i class="fa fa-truck"></i> <span class="nav-label">RPB</span></a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Rencana_Pengiriman_Barang"><i class="fa fa-truck"></i> <span class="nav-label">RPB</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "Surat_Jalan_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/surat_jalan"><i class="fa fa-bus"></i> <span class="nav-label">Surat Jalan</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/surat_jalan"><i class="fa fa-bus"></i> <span class="nav-label">Surat Jalan</span></a>
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

					<?php if ($left_menu == "gudang_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/gudang"><i class="fa fa-bitbucket-square "></i> <span class="nav-label">Gudang</span></a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/gudang"><i class="fa fa-bitbucket-square "></i> <span class="nav-label">Gudang</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "barang_master_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/barang_master"><i class="fa fa-briefcase"></i> <span class="nav-label">Master List</span></a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/barang_master"><i class="fa fa-briefcase"></i> <span class="nav-label">Master List</span></a>
						</li>
					<?php } ?>
					</div>
					</nav>