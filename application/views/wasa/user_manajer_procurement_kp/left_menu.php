					<div class="logo-element">
						WME
					</div>
					</li>
					<?php if ($left_menu == "dashboard_manajer_procurement_kp_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>Dashboard_manajer_procurement_kp"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>Dashboard_manajer_procurement_kp"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "sppb_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>SPPB"><i class="fa fa-compass"></i> <span class="nav-label">SPPB Pembelian</span> </a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>SPPB"><i class="fa fa-compass"></i> <span class="nav-label">SPPB Pembelian</span> </a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "RFQ_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>RFQ"><i class="fa fa-clone"></i> <span class="nav-label">RFQ</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>RFQ"><i class="fa fa-clone"></i> <span class="nav-label">RFQ</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "KHP_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>KHP"><i class="fa fa-tags"></i> <span class="nav-label">KHP</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>KHP"><i class="fa fa-tags"></i> <span class="nav-label">KHP</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "SPP_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>SPP"><i class="fa fa-bandcamp"></i> <span class="nav-label">SPP</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>SPP"><i class="fa fa-bandcamp"></i> <span class="nav-label">SPP</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "PO_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>PO"><i class="fa fa-telegram"></i> <span class="nav-label">PO</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>PO"><i class="fa fa-telegram"></i> <span class="nav-label">PO</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "Invoice_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>Invoice"><i class="fa fa-money"></i> <span class="nav-label">Invoice</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>Invoice"><i class="fa fa-money"></i> <span class="nav-label">Invoice</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "RPB_form_aktif" || $left_menu == "Rencana_Pengiriman_Barang_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>Rencana_Pengiriman_Barang"><i class="fa fa-truck"></i> <span class="nav-label">RPB</span></a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>Rencana_Pengiriman_Barang"><i class="fa fa-truck"></i> <span class="nav-label">RPB</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "FSTB_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>FSTB"><i class="fa fa-stumbleupon"></i> <span class="nav-label">FSTB</span></a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>FSTB"><i class="fa fa-stumbleupon"></i> <span class="nav-label">FSTB</span></a>
						</li>
					<?php } ?>

					<div class="hr-line-dashed"></div>

					<?php if ($left_menu == "proyek_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>Proyek"><i class="fa fa-group"></i> <span class="nav-label">Proyek</span></a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>Proyek"><i class="fa fa-group"></i> <span class="nav-label">Proyek</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "vendor_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>vendor"><i class="fa fa-bullhorn"></i> <span class="nav-label">Vendor</span></a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>vendor"><i class="fa fa-bullhorn"></i> <span class="nav-label">Vendor</span></a>
						</li>
					<?php } ?>
					
					</div>
					</nav>