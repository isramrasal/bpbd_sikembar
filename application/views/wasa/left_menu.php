					<div class="logo-element">
						WME
					</div>
				</li>
				<?php if($left_menu == "dashboard_admin_aktif") {?>
                <li class="active">
                    <a href="<?php echo base_url(); ?>index.php/dashboard_admin"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
                </li>
				<?php }
				else {?>
				<li>
                    <a href="<?php echo base_url(); ?>index.php/dashboard_admin"><i class="fa fa-th-large"></i> <span class="nav-label">Home</span> </a>
                </li>
				<?php }?>
				
				<?php if($left_menu == "pegawai_aktif") {?>
				<li class="active">
                    <a href="#"><i class="fa fa-user-circle"></i> <span class="nav-label">Pegawai</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/nip">Nomor Induk Pegawai</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/pegawai">Biodata Pegawai</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/riwayat_pekerjaan">Riwayat Pekerjaan</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/pendidikan">Pendidikan</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/pelatihan">Pelatihan</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/alamat">List Alamat</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/keluarga">List Keluarga</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/cv">CV</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/download_dokumen">Download Dokumen</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/role_user">Role User</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/registrasi_user">Registrasi User</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/ganti_password">Ganti Password</a></li>
                    </ul>
                </li>
				<?php }
				else {?>
				<li>
                     <a href="#"><i class="fa fa-user-circle"></i> <span class="nav-label">Pegawai</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/nip">Nomor Induk Pegawai</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/pegawai">Biodata Pegawai</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/riwayat_pekerjaan">Riwayat Pekerjaan</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/pendidikan">Pendidikan</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/pelatihan">Pelatihan</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/alamat">List Alamat</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/keluarga">List Keluarga</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/cv">CV</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/download_dokumen">Download Dokumen</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/role_user">Role User</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/registrasi_user">Registrasi User</a></li>
						<li><a href="<?php echo base_url(); ?>index.php/ganti_password">Ganti Password</a></li>
                    </ul>
                </li>
				<?php }?>
				
				<?php if($left_menu == "status_pegawai_aktif") {?>
				<li class="active">
                    <a href="#"><i class="fa fa-slideshare"></i> <span class="nav-label">Status Pegawai</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/status_pegawai">List Status Pegawai</a></li>
                    </ul>
                </li>
				<?php }
				else {?>
				<li>
                    <a href="#"><i class="fa fa-slideshare"></i> <span class="nav-label">Status Pegawai</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/status_pegawai">List Status Pegawai</a></li>
                    </ul>
                </li>
				<?php }?>
				
				<?php if($left_menu == "departemen_aktif") {?>
				<li class="active">
                    <a href="#"><i class="fa fa-group"></i> <span class="nav-label">Departemen</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/departemen">List Departemen</a></li>
                    </ul>
                </li>
				<?php }
				else {?>
				<li>
                    <a href="#"><i class="fa fa-group"></i> <span class="nav-label">Departemen</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/departemen">List Departemen</a></li>
                    </ul>
                </li>
				<?php }?>
				
				
				
				
				
				<?php if($left_menu == "bidang_pekerjaan_aktif") {?>
				<li class="active">
                    <a href="#"><i class="fa fa-star"></i> <span class="nav-label">Bidang Pekerjaan</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/bidang_pekerjaan">List Bidang Pekerjaan</a></li>
                    </ul>
                </li>
				<?php }
				else {?>
				<li>
                    <a href="#"><i class="fa fa-star"></i> <span class="nav-label">Bidang Pekerjaan</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/bidang_pekerjaan">List Bidang Pekerjaan</a></li>
                    </ul>
                </li>
				<?php }?>
				
				<?php if($left_menu == "jabatan_aktif") {?>
				<li class="active">
                    <a href="#"><i class="fa fa-suitcase"></i> <span class="nav-label">Jabatan</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/jabatan">List Jabatan</a></li>
                    </ul>
                </li>
				<?php }
				else {?>
				<li>
                    <a href="#"><i class="fa fa-suitcase"></i> <span class="nav-label">Jabatan</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/jabatan">List Jabatan</a></li>
                    </ul>
                </li>
				<?php }?>
				
				<?php if($left_menu == "perusahaan_aktif") {?>
				<li class="active">
                    <a href="#"><i class="fa fa-briefcase"></i> <span class="nav-label">Perusahaan</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/perusahaan">List Perusahaan</a></li>
                    </ul>
                </li>
				<?php }
				else {?>
				<li>
                    <a href="#"><i class="fa fa-briefcase"></i> <span class="nav-label">Perusahaan</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/perusahaan">List Perusahaan</a></li>
                    </ul>
                </li>
				<?php }?>
				
				<?php if($left_menu == "pengumuman_aktif") {?>
				<li class="active">
                    <a href="#"><i class="fa fa-bullhorn"></i> <span class="nav-label">Pengumuman</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/pengumuman">List Pengumuman</a></li>
                    </ul>
                </li>
				<?php }
				else {?>
				<li>
                    <a href="#"><i class="fa fa-bullhorn"></i> <span class="nav-label">Pengumuman</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
						<li><a href="<?php echo base_url(); ?>index.php/pengumuman">List Pengumuman</a></li>
                    </ul>
                </li>
				<?php }?>
				
				<?php if($left_menu == "spk_aktif") {?>
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
				<?php }
				else {?>
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
				<?php }?>
        </div>
    </nav>