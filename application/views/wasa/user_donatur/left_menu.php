					<div class="logo-element">
					    SIKEMBAR
					</div>
					</li>
					<?php if ($left_menu == "dashboard_korban_bencana_aktif") { ?>
					<li class="active">
					    <a href="<?php echo base_url(); ?>index.php/Dashboard_donatur"><i class="fa fa-th-large"></i> <span
					            class="nav-label">Home</span> </a>
					</li>
					<?php } else { ?>
					<li>
					    <a href="<?php echo base_url(); ?>index.php/Dashboard_donatur"><i class="fa fa-th-large"></i> <span
					            class="nav-label">Home</span> </a>
					</li>
					<?php } ?>



					<?php if ($left_menu == "donasi_aktif") { ?>
					<li class="active">
					    <a href="<?php echo base_url(); ?>index.php/Donatur"><i class="fa fa-compass"></i> <span
					            class="nav-label">Pengajuan Donasi</span> </a>

					</li>
					<?php } else { ?>
					<li>
					    <a href="<?php echo base_url(); ?>index.php/Donatur"><i class="fa fa-compass"></i> <span
					            class="nav-label">Pengajuan Donasi</span> </a>
					</li>
					<?php } ?>

					</div>
					</nav>