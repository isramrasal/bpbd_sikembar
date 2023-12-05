<body class="white-bg">			
					<div class="ibox">
                        <div class="ibox-content">
						
							<div class="row m-b-lg m-t-lg">
								<div class="col-md-6">

									<div class="profile-image">
										<img src="<?php echo base_url(); ?><?php echo $foto_pegawai; ?>" class="img-circle circle-border m-b-md" alt="profile">
									</div>
									<div class="profile-info">
										<div class="">
											<div>
												<h2 class="no-margins">
													Curriculum Vitae
												</h2>
												<?php foreach($pegawai as $peg){ ?>
												<h4><?php echo $peg->NAMA; ?></h4>
												<small>
												</small>
											</div>
										</div>
									</div>
								</div>
							</div>
						
						
						
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Biodata</h2>
                                    </div>
                                </div>
                            </div>
							
							
							
							<div class="row">
                                <div class="col-md-6">
                                    <dl class="dl-horizontal">
                                        <dt>Nama Lengkap:</dt> <dd><?php echo $peg->NAMA; ?></dd>
										<dt>Agama:</dt> <dd><?php echo $peg->AGAMA; ?></dd>
										<dt>Jenis Kelamin:</dt> <dd><?php echo $peg->JENIS_KELAMIN; ?></dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <dl class="dl-horizontal" >

                                        <dt>Kota Kelahiran:</dt> <dd><?php echo $peg->TEMPAT_LAHIR; ?></dd>
										<dt>Tanggal Lahir:</dt> <dd><?php echo $peg->TANGGAL_LAHIR; ?></dd>
										<dt>Umur:</dt> <dd><?php echo $peg->UMUR; ?> tahun</dd>
										<dt>Status Pernikahan:</dt> <dd><?php echo $peg->STATUS_PERNIKAHAN; ?></dd>
                                        </dd>
                                    </dl>
                                </div>
                            </div>
							
							<div class="row">
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
										<dt>Email Alternatif:</dt> <dd><?php echo $peg->EMAIL; ?></dd>
										<dt>No HP Utama:</dt> <dd><?php echo $peg->NO_HP_1; ?></dd>
										<dt>No HP Alternatif:</dt> <dd><?php echo $peg->NO_HP_2; ?></dd>
                                    </dl>
                                </div>
                            </div>
							
                            <div class="row">
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
										<dt>NIP:</dt> <dd><?php echo $peg->NIP; ?></dd>
										<dt>NIK:</dt> <dd><?php echo $peg->NIK; ?></dd>
										<dt>NPWP:</dt> <dd><?php echo $peg->NPWP; ?></dd>
										<dt>Kartu Keluarga:</dt> <dd><?php echo $peg->NO_KARTU_KELUARGA; ?></dd>
                                    </dl>
                                </div>
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal" >

                                        <dt>Paspor:</dt> <dd><?php echo $peg->PASPOR; ?></dd>
										<dt>BPJS Kesehatan:</dt> <dd><?php echo $peg->BPJS_KESEHATAN; ?></dd>
										<dt>BPJS Tenaga Kerja:</dt> <dd><?php echo $peg->BPJS_TK; ?></dd>

                                        </dd>
                                    </dl>
                                </div>
                            </div>
							<?php } ?>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Pendidikan</h2>
                                    </div>
                                </div>
                            </div>
							<?php foreach($pendidikan as $pend){ ?>
							<div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>Jenjang Pendidikan:</dt> <dd><?php echo $pend->JENJANG_PENDIDIKAN; ?></dd>
										<dt>Nama Institusi:</dt> <dd><?php echo $pend->NAMA_INSTITUSI; ?></dd>
										<dt>Tahun Lulus:</dt> <dd><?php echo $pend->TAHUN_LULUS; ?></dd>

                                    </dl>
                                </div>
                            </div>

							<?php } ?>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Pelatihan</h2>
                                    </div>
                                </div>
                            </div>
							<?php foreach($pelatihan as $pelt){ ?>
							<div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>Nama Pelatihan:</dt> <dd><?php echo $pelt->NAMA_PELATIHAN; ?></dd>
										<dt>Bidang Pelatihan:</dt> <dd><?php echo $pelt->BIDANG_PELATIHAN; ?></dd>
										<dt>Nama Penyelenggara:</dt> <dd><?php echo $pelt->NAMA_PENYELENGGARA; ?></dd>
										<dt>Keterangan:</dt> <dd><?php echo $pelt->KETERANGAN; ?></dd>

                                    </dl>
                                </div>
                            </div>
							<?php } ?>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Pekerjaan</h2>
                                    </div>
                                </div>
                            </div>
							<?php foreach($riwayat_pekerjaan as $riw_per){ ?>
							<div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>Perusahaan:</dt> <dd><?php echo $riw_per->NAMA_PERUSAHAAN; ?></dd>
										<dt>Jabatan:</dt> <dd><?php echo $riw_per->NAMA_JABATAN; ?></dd>
										<dt>Bidang Pekerjaan:</dt> <dd><?php echo $riw_per->NAMA_BIDANG_PEKERJAAN; ?></dd>
										<dt>Tanggal Awal Bekerja:</dt> <dd><?php echo $riw_per->TANGGAL_AWAL_BEKERJA; ?></dd>
										<dt>Tanggal Akhir Bekerja:</dt> <dd><?php echo $riw_per->TANGGAL_AKHIR_BEKERJA; ?></dd>

                                    </dl>
                                </div>
                            </div>
							<?php } ?>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Alamat</h2>
                                    </div>
                                </div>
                            </div>
							<?php foreach($alamat as $alam){ ?>
							<div class="row">
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Status Alamat:</dt> <dd><?php echo $alam->STATUS_ALAMAT; ?></dd>
										<dt>Provinsi:</dt> <dd><?php echo $alam->PROVINSI; ?></dd>
										<dt>Kota/Kabupaten:</dt> <dd><?php echo $alam->KOTA; ?></dd>
										<dt>Kecamatan:</dt> <dd><?php echo $alam->KECAMATAN; ?></dd>
                                    </dl>
                                </div>
								<div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Kelurahan/Desa:</dt> <dd><?php echo $alam->KELURAHAN; ?></dd>
										<dt>Nama Jalan:</dt> <dd><?php echo $alam->NAMA_JALAN; ?></dd>
										<dt>Nomor Telepon:</dt> <dd><?php echo $alam->TELP_ALAMAT; ?></dd>
                                    </dl>
                                </div>
                            </div>
							<?php } ?>
							
							<div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>Anggota Keluarga</h2>
                                    </div>
                                </div>
                            </div>
							<?php foreach($keluarga as $kelg){ ?>
							<div class="row">
                                <div class="col-lg-6">
                                    <dl class="dl-horizontal">
                                        <dt>Nama Lengkap:</dt> <dd><?php echo $kelg->NAMA; ?></dd>
										<dt>Hubungan:</dt> <dd><?php echo $kelg->HUBUNGAN; ?></dd>
                                    </dl>
                                </div>
                            </div>
							<?php } ?>

                            
                        </div>
                    </div>

</body>

<script type="text/javascript">
        window.print();
    </script>

</html>