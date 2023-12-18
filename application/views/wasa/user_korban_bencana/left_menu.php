					<div class="logo-element">
						WME
					</div>
					</li>
					<?php if ($left_menu == "dashboard_korban_bencana_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Dashboard_korban_bencana"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Dashboard_korban_bencana"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } ?>

					

					<?php if ($left_menu == "pengajuan_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Pengajuan"><i class="fa fa-compass"></i> <span class="nav-label">Pengajuan Bantuan</span> </a>

						</li>
					<?php } else { ?>
						<li>
						<a href="<?php echo base_url(); ?>index.php/Pengajuan"><i class="fa fa-compass"></i> <span class="nav-label">Pengajuan Bantuan</span> </a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "penyaluran_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Penyaluran"><i class="fa fa-clone"></i> <span class="nav-label">Penyaluran Bantuan</span></a>

						</li>
					<?php } else { ?>
						<li>
						<a href="<?php echo base_url(); ?>index.php/Penyaluran"><i class="fa fa-clone"></i> <span class="nav-label">Penyaluran Bantuan</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "data_korban_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Data_korban"><i class="fa fa-bandcamp"></i> <span class="nav-label">Data Korban</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Data_korban"><i class="fa fa-bandcamp"></i> <span class="nav-label">Data Korban</span></a>
						</li>
					<?php } ?>

			
					
					</div>
					</nav>