					<div class="logo-element">
						WME
					</div>
					</li>
					<?php if ($left_menu == "RFQ_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>RFQ"><i class="fa fa-book"></i> <span class="nav-label">Input RFQ</span></a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>RFQ"><i class="fa fa-book"></i> <span class="nav-label">Input RFQ</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "PO_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>PO"><i class="fa fa-folder"></i> <span class="nav-label">Purchase Order</span></a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>PO"><i class="fa fa-folder"></i> <span class="nav-label">Purchase Order</span></a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "Invoice_aktif" || $left_menu == "Invoice_aktif") { ?>
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
							<a href="<?php echo base_url(); ?>Rencana_Pengiriman_Barang"><i class="fa fa-truck"></i> <span class="nav-label">Delivery Plan</span></a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>Rencana_Pengiriman_Barang"><i class="fa fa-truck"></i> <span class="nav-label">Delivery Plan</span></a>
						</li>
					<?php } ?>

					</div>
					</nav>