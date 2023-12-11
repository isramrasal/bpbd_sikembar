					<div class="logo-element">
						WME
					</div>
					</li>
					<?php if ($left_menu == "dashboard_korban_bencana_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Dashboard_pegawai_bpbd"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Dashboard_pegawai_bpbd"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } ?>

					

					<?php if ($left_menu == "donasi_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Donasi"><i class="fa fa-compass"></i> <span class="nav-label">Manajemen Donasi</span> </a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Donasi"><i class="fa fa-compass"></i> <span class="nav-label">Manajemen Donasi</span> </a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "inventaris_bencana_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Inventaris_Bencana"><i class="fa fa-clone"></i> <span class="nav-label">Inventaris Bencana</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Inventaris_Bencana"><i class="fa fa-clone"></i> <span class="nav-label">Inventaris Bencana</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "penyaluran_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Penyaluran"><i class="fa fa-tags"></i> <span class="nav-label">Manajemen Penyaluran</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Penyaluran"><i class="fa fa-tags"></i> <span class="nav-label">Manajemen Penyaluran</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "barang_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Barang"><i class="fa fa-bandcamp"></i> <span class="nav-label">Manajemen Barang</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Barang"><i class="fa fa-bandcamp"></i> <span class="nav-label">Manajemen Barang</span></a>
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

					<?php if ($left_menu == "Invoice_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Invoice"><i class="fa fa-money"></i> <span class="nav-label">Invoice</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Invoice"><i class="fa fa-money"></i> <span class="nav-label">Invoice</span></a>
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
					
					<?php if ($left_menu == "vendor_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/vendor"><i class="fa fa-bullhorn"></i> <span class="nav-label">Vendor</span></a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/vendor"><i class="fa fa-bullhorn"></i> <span class="nav-label">Vendor</span></a>
						</li>
					<?php } ?>
					
					</div>
					</nav>