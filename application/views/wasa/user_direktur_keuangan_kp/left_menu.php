					<div class="logo-element">
						WME
					</div>
					</li>
					<?php if ($left_menu == "dashboard_direktur_keuangan_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/Dashboard_direktur_keuangan_kp"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/Dashboard_direktur_keuangan_kp"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
						</li>
					<?php } ?>

					<?php if ($left_menu == "sppb_aktif") { ?>
						<li class="active">
							<a href="<?php echo base_url(); ?>index.php/SPPB"><i class="fa fa-compass"></i> <span class="nav-label">SPPB</span> </a>

						</li>
					<?php } else { ?>
						<li>
							<a href="<?php echo base_url(); ?>index.php/SPPB"><i class="fa fa-compass"></i> <span class="nav-label">SPPB</span> </a>
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


					<?php if ($left_menu == "Invoice_aktif") { ?>
						<li class="active">
							<a href="#"><i class="fa fa-star"></i> <span class="nav-label">Invoice</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/RASD">List Invoice</a></li>
							</ul>
						</li>
					<?php } else { ?>
						<li>
							<a href="#"><i class="fa fa-star"></i> <span class="nav-label">Invoice</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/RASD">List Invoice</a></li>
							</ul>
						</li>
					<?php } ?>

					<div class="hr-line-dashed"></div>




					<?php if ($left_menu == "pegawai_aktif") { ?>
						<li class="active">
							<a href="#"><i class="fa fa-user-circle"></i> <span class="nav-label">Pegawai</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/nip">Nomor Induk Pegawai</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/cv">CV</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/role_user">Role User</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/registrasi_user">Registrasi User</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/ganti_password">Ganti Password</a></li>
							</ul>
						</li>
					<?php } else { ?>
						<li>
							<a href="#"><i class="fa fa-user-circle"></i> <span class="nav-label">Pegawai</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/nip">Nomor Induk Pegawai</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/cv">CV</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/role_user">Role User</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/registrasi_user">Registrasi User</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/ganti_password">Ganti Password</a></li>
							</ul>
						</li>
					<?php } ?>


					<?php if ($left_menu == "proyek_aktif") { ?>
						<li class="active">
							<a href="#"><i class="fa fa-group"></i> <span class="nav-label">Proyek</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/Proyek">List Proyek</a></li>
							</ul>
						</li>
					<?php } else { ?>
						<li>
							<a href="#"><i class="fa fa-group"></i> <span class="nav-label">Proyek</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/Proyek">List Proyek</a></li>
							</ul>
						</li>
					<?php } ?>





					<?php if ($left_menu == "RASD_aktif") { ?>
						<li class="active">
							<a href="#"><i class="fa fa-star"></i> <span class="nav-label">RASD Proyek</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/RASD">List RASD Proyek</a></li>
							</ul>
						</li>
					<?php } else { ?>
						<li>
							<a href="#"><i class="fa fa-star"></i> <span class="nav-label">RASD Proyek</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/RASD">List RASD Proyek</a></li>
							</ul>
						</li>
					<?php } ?>



					<?php if ($left_menu == "barang_master_aktif") { ?>
						<li class="active">
							<a href="#"><i class="fa fa-briefcase"></i> <span class="nav-label">Daftar Barang</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/barang_master">List Barang</a></li>
							</ul>
						</li>
					<?php } else { ?>
						<li>
							<a href="#"><i class="fa fa-briefcase"></i> <span class="nav-label">Daftar Barang</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/barang_master">List Baran</a></li>
							</ul>
						</li>
					<?php } ?>

					<?php if ($left_menu == "vendor_aktif") { ?>
						<li class="active">
							<a href="#"><i class="fa fa-bullhorn"></i> <span class="nav-label">Vendor</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/vendor">List Vendor</a></li>
							</ul>
						</li>
					<?php } else { ?>
						<li>
							<a href="#"><i class="fa fa-bullhorn"></i> <span class="nav-label">Vendor</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/vendor">List Vendor</a></li>
							</ul>
						</li>
					<?php } ?>

					<?php if ($left_menu == "spk_aktif") { ?>
						<li class="active">
							<a href="#"><i class="fa fa-search-plus"></i> <span class="nav-label">SPK</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/seleksi_jabatan">Seleksi Jabatan</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/kriteria_penilaian">Kriteria Penilaian</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/input_bobot">Input Bobot</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/input_skoring">Input Skoring</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/lihat_ranking">Lihat Ranking</a></li>
							</ul>
						</li>
					<?php } else { ?>
						<li>
							<a href="#"><i class="fa fa-search-plus"></i> <span class="nav-label">SPK</span> <span class="fa arrow"></span></a>
							<ul class="nav nav-second-level collapse">
								<li><a href="<?php echo base_url(); ?>index.php/seleksi_jabatan">Seleksi Jabatan</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/kriteria_penilaian">Kriteria Penilaian</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/input_bobot">Input Bobot</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/input_skoring">Input Skoring</a></li>
								<li><a href="<?php echo base_url(); ?>index.php/lihat_ranking">Lihat Ranking</a></li>
							</ul>
						</li>
					<?php } ?>
					</div>
					</nav>