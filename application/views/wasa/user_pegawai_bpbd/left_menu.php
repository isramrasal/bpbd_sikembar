					<div class="logo-element">
					    WME
					</div>
					</li>
					<?php if ($left_menu == "dashboard_pegawai_bpbd_aktif") { ?>
					<li class="active">
					    <a href="<?php echo base_url(); ?>index.php/Dashboard_pegawai_bpbd"><i class="fa fa-th-large"></i> <span
					            class="nav-label">Home</span> </a>
					</li>
					<?php } else { ?>
					<li>
					    <a href="<?php echo base_url(); ?>index.php/Dashboard_pegawai_bpbd"><i class="fa fa-th-large"></i> <span
					            class="nav-label">Home</span> </a>
					</li>
					<?php } ?>



					<?php if ($left_menu == "donasi_aktif") { ?>
					<li class="active">
					    <a href="<?php echo base_url(); ?>index.php/Donasi"><i class="fa fa-compass"></i> <span
					            class="nav-label">Manajemen Donasi</span> </a>

					</li>
					<?php } else { ?>
					<li>
					    <a href="<?php echo base_url(); ?>index.php/Donasi"><i class="fa fa-compass"></i> <span
					            class="nav-label">Manajemen Donasi</span> </a>
					</li>
					<?php } ?>

					<?php if ($left_menu == "inventaris_bencana_aktif") { ?>
					<li class="active">
					    <a href="<?php echo base_url(); ?>index.php/Inventaris_Bencana"><i class="fa fa-clone"></i> <span
					            class="nav-label">Inventaris Bencana</span></a>

					</li>
					<?php } else { ?>
					<li>
					    <a href="<?php echo base_url(); ?>index.php/Inventaris_Bencana"><i class="fa fa-clone"></i> <span
					            class="nav-label">Inventaris Bencana</span></a>
					</li>
					<?php } ?>

					<?php if ($left_menu == "penyaluran_aktif") { ?>
					<li class="active">
					    <a href="<?php echo base_url(); ?>index.php/Penyaluran"><i class="fa fa-tags"></i> <span
					            class="nav-label">Manajemen Penyaluran</span></a>

					</li>
					<?php } else { ?>
					<li>
					    <a href="<?php echo base_url(); ?>index.php/Penyaluran"><i class="fa fa-tags"></i> <span
					            class="nav-label">Manajemen Penyaluran</span></a>
					</li>
					<?php } ?>

					<!-- <?php if ($left_menu == "pengajuan_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Pengajuan"><i class="fa fa-compass"></i> <span class="nav-label">Pengajuan Bantuan</span> </a>

						</li>
					<?php } else { ?>
						<li>
						<a href="<?php echo base_url(); ?>index.php/Pengajuan"><i class="fa fa-compass"></i> <span class="nav-label">Pengajuan Bantuan</span> </a>
						</li>
					<?php } ?> -->

					<?php if ($left_menu == "barang_aktif") { ?>
					<li class="active">
					    <a href="<?php echo base_url(); ?>index.php/Barang"><i class="fa fa-bandcamp"></i> <span
					            class="nav-label">Manajemen Barang</span></a>

					</li>
					<?php } else { ?>
					<li>
					    <a href="<?php echo base_url(); ?>index.php/Barang"><i class="fa fa-bandcamp"></i> <span
					            class="nav-label">Manajemen Barang</span></a>
					</li>
					<?php } ?>

					<?php if ($left_menu == "data_diri_aktif") { ?>
					<li class="active">
					    <a href="<?php echo base_url(); ?>index.php/Data_Diri"><i class="fa fa-bandcamp"></i> <span
					            class="nav-label">Data Diri</span></a>

					</li>
					<?php } else { ?>
					<li>
					    <a href="<?php echo base_url(); ?>index.php/Data_Diri"><i class="fa fa-bandcamp"></i> <span
					            class="nav-label">Data Diri</span></a>
					</li>
					<?php } ?>

					</div>
					</nav>