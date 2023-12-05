					<div class="logo-element">
						WME
					</div>
					</li>
					<?php if ($left_menu == "dashboard_pm_proyek_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/dashboard_pm_sp"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/dashboard_pm_sp"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
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
					</div>
					</nav>