<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Informasi Barang Entitas</h2>
		<ol class="breadcrumb">
			<li>
				<a href="<?php echo base_url('index.php') ?>">Home</a>
			</li>
			<li>
				<a href="<?php echo base_url('index.php/barang_master/') ?>">List Asset</a>
			</li>
			<li>
				<a href="#">Profil Barang Entitas</a>
			</li>
			<li class="active">
				<strong>
					<a>Informasi Barang Entitas</a>
				</strong>
			</li>
		</ol>
	</div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
	<?php foreach ($query_barang_master_HASH_MD5_BARANG_MASTER_result as $data_barang_master) { ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Profil Barang Master</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="fullscreen-link">
								<i class="fa fa-expand"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						<div class="row">
							<div class="col-lg-12">
								<div class="row">
									<div class="col-md-4">
										<div class="product-images">
											<?php if (isset($dokumen)) { ?>
												<?php foreach ($dokumen as $barang_master_file) { ?>
													<?php if ($barang_master_file->JENIS_FILE == "Gambar Produk") {
														echo ("<img src='" . base_url() . $barang_master_file->KETERANGAN . "' alt='' srcset=''>'");
													}
													?>
											<?php }
											} else {
												echo ("Belum ada gambar produk. Silakan upload gambar produk");
											} ?>
										</div>
									</div>
									<div class="col-md-7">
										<div class="m-t-md">
											Status: <span class="label label-primary">Active</span>
										</div>
										<div class="m-t-md">
											<h2 class="product-main-price"><b>Nama Barang Master:</b></h2>
											<h2><?php echo $data_barang_master->NAMA; ?></h2>
										</div>
										<hr>
										<div class="m-t-md">
											<h4 class="product-main-price"><b>Alias:</b></h4>
											<?php echo $data_barang_master->ALIAS; ?>
										</div>
										<hr>
										<div class="m-t-md">
											<h4 class="product-main-price"><b>Kode Barang:</b></h4>
											<?php echo $data_barang_master->KODE_BARANG; ?>
										</div>
										<div class="m-t-md">
											<h4 class="product-main-price"><b>Merek:</b></h4>
											<?php echo $data_barang_master->MEREK; ?>
										</div>
										<hr>
										<!-- <h4>Spesifikasi Produk</h4> -->
										<div class="m-t-md">
											<h4 class="product-main-price"><b>Jenis Barang:</b></h4>
											<?php echo $data_barang_master->NAMA_JENIS_BARANG; ?>
										</div>
										<div class="m-t-md">
											<h4 class="product-main-price"><b>Peralatan Perlengkapan:</b></h4>
											<?php echo $data_barang_master->PERALATAN_PERLENGKAPAN; ?>
										</div>
										<div class="m-t-md">
											<h4 class="product-main-price"><b>Satuan Barang:</b></h4>
											<?php echo $data_barang_master->NAMA_SATUAN_BARANG; ?>
										</div>
										<div class="m-t-md">
											<h4 class="product-main-price"><b>Gross Weight:</b></h4>
											<?php echo $data_barang_master->GROSS_WEIGHT; ?>
										</div>
										<div class="m-t-md">
											<h4 class="product-main-price"><b>Nett Weight:</b></h4>
											<?php echo $data_barang_master->NETT_WEIGHT; ?>
										</div>
										<div class="m-t-md">
											<h4 class="product-main-price"><b>Dimensi:</b></h4>
											<?php echo $data_barang_master->DIMENSI_PANJANG . ' cm x ' . $data_barang_master->DIMENSI_LEBAR . ' cm x ' . $data_barang_master->DIMENSI_TINGGI . ' cm'; ?>
										</div>
										<hr>
										<div class="m-t-md">
											<h4 class="product-main-price">Spesifikasi Lengkap Produk:</h4>
											<?php echo $data_barang_master->SPESIFIKASI_LENGKAP; ?>
										</div>
										<div class="m-t-md">
											<h4 class="product-main-price">Spesifikasi Singkat Produk:</h4>
											<?php echo $data_barang_master->SPESIFIKASI_SINGKAT; ?>
										</div>
										<div class="m-t-md">
											<h4 class="product-main-price">Cara Singkat Penggunaan:</h4>
											<?php echo $data_barang_master->CARA_SINGKAT_PENGGUNAAN; ?>
										</div>
										<div class="m-t-md">
											<h4 class="product-main-price">Cara Penyimpanan Barang: <br></h4>
											<?php echo $data_barang_master->CARA_PENYIMPANAN_BARANG; ?>
										</div>
										<div class="m-t-md">
											<h4 class="product-main-price">Masa Pakai: <br></h4>
											<?php echo $data_barang_master->MASA_PAKAI; ?>
										</div>
										<hr>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<?php if ($FILE == "ADA") { ?>
		<div class="row">
			<div class="col-lg-9 animated fadeInRight">
				<div class="row">
					<div class="col-lg-12">
						<?php foreach ($dokumen as $barang_entitas_file) { ?>

							<div class="file-box">
								<div class="file">
									<a href="#">
										<span class="corner"></span>

										<?php if ($barang_entitas_file->JENIS_FILE == "Gambar Produk") {
											echo ("<div class='image'>
										<img alt='image' class='img-responsive' 
										src='" . base_url() . $barang_entitas_file->KETERANGAN . "'></div>");
										} else {
											echo ("<div class='icon'>
										<i class='fa fa-file'></i>
										</div>");
										} ?>

										<div class="file-name">
											<a href="<?php echo base_url(); ?>assets/upload_barang_entitas_npwp/<?php echo $barang_entitas_file->DOK_FILE; ?>">Download file</a>
											<br />
											<small>Jenis file: <?php echo $barang_entitas_file->JENIS_FILE; ?></small>
											<br />
											<small>Diupload: <?php echo $barang_entitas_file->TANGGAL_UPLOAD; ?></small>
										</div>
									</a>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>

	<?php } else { ?>

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox">
					<div class="ibox-title">
						<h5>Download File Dokumen</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
							<a class="fullscreen-link">
								<i class="fa fa-expand"></i>
							</a>
							<a class="close-link">
								<i class="fa fa-times"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">
						Belum ada file dokumen. Silakan upload file dokumen.
					</div>
				</div>
			</div>
		</div>
	<?php } ?>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Barang Entitas</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
						<a class="fullscreen-link">
							<i class="fa fa-expand"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th>Kode Barang Entitas</th>
									<th>Tanggal Perolehan</th>
									<th>No. SPPB</th>
									<th>No. PO</th>
									<th>Status Kepemilikan</th>
									<th>Tanggal Mulai Sewa</th>
									<th>Tanggal Selesai Sewa</th>
									<th>Lokasi Saat ini</th>
									<th>Jumlah Barang</th>
									<th>Kondisi</th>
									<th>Pilihan</th>
								</tr>
							</thead>
							<tbody id="show_data">
							</tbody>
						</table>
					</div>
					<a href="#" class="btn btn-success" data-toggle="modal" data-target="#ModalAdd"><span class="fa fa-plus"></span> Tambah Data</a><br>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL ADD -->
<div class="modal inmodal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-cubes modal-icon"></i>
				<h4 class="modal-title">Asset</h4>
				<small class="font-bold">Silakan Tambah Data Asset</small>
			</div>
			<?php $attributes = array("nama_proyek" => "contact_form", "id" => "contact_form");
			echo form_open("proyek/simpan_data", $attributes); ?>
			<div class="form-horizontal">
				<div class="modal-body">

					<div class="form-group">
						<label class="control-label col-xs-3">Tool/Consumable/<br>Material</label>
						<div class="col-xs-9">
							<div>
								<input type="text" class="form-control" value='<?php echo $PERALATAN_PERLENGKAPAN; ?>' name="PERALATAN_PERLENGKAPAN" id="PERALATAN_PERLENGKAPAN" disabled />
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Kode Barang Master</label>
						<div class="col-xs-9">
							<div>
								<input name="KODE_BARANG_MASTER" id="KODE_BARANG_MASTER" class="form-control" type="text" value='<?php echo $KODE_BARANG; ?>' disabled>
								<input name="ID_BARANG_MASTER" id="ID_BARANG_MASTER" class="form-control" type="hidden" value='<?php echo $ID_BARANG_MASTER; ?>'>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Quantity Entitas</label>
						<div class="col-xs-9">
							<div>
								<select name="QUANTITY_ENTITAS" id="QUANTITY_ENTITAS" class="form-control">
									<?php
									for ($i = 1; $i <= 100; $i++) {
									?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
					</div>

					<input type="hidden" class="form-control" value="" name="JUMLAH_COUNT" id="JUMLAH_COUNT" disabled />


					<div class="form-group">
						<label class="control-label col-xs-3">Kode Barang Entitas Mulai Dari</label>
						<div class="col-xs-9">
							<div>
								<input name="KODE_BARANG_ENTITAS_START" id="KODE_BARANG_ENTITAS_START" class="form-control" type="text" disabled>
							</div>
						</div>
					</div>

					<input name="SUDAH_SAMPAI_KE" id="SUDAH_SAMPAI_KE" class="form-control" type="hidden" disabled>


					<div class="form-group">
						<label class="control-label col-xs-3">Kode Barang Entitas Sampai Dari</label>
						<div class="col-xs-9">
							<div>
								<input name="KODE_BARANG_ENTITAS_END" id="KODE_BARANG_ENTITAS_END" class="form-control" type="text" disabled>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Proyek</label>
						<div class="col-xs-9">
							<select name="ID_PROYEK" class="form-control" id="ID_PROYEK">
								<option value=''>- Pilih Proyek -</option>
								<?php foreach ($proyek_list as $prov) {
									echo '<option value="' . $prov->ID_PROYEK  . '">' . $prov->NAMA_PROYEK . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Gudang</label>
						<div class="col-xs-9">
							<select name="ID_GUDANG" class="form-control" id="ID_GUDANG">
								<option value=''>- Pilih Gudang -</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nomor Urut SPPB</label>
						<div class="col-xs-9">
							<select name="ID_SPPB" class="form-control" id="ID_SPPB">
								<option value=''>- Pilih Nomor SPPB -</option>
								<option value='0'>- Tanpa SPPB -</option>
								<?php foreach ($sppb_list as $item) {
									echo '<option value="' . $item->ID_SPPB . '">' . $item->NO_URUT_SPPB . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nomor Urut PO</label>
						<div class="col-xs-9">
							<select name="ID_PO" class="form-control" id="ID_PO">
								<option value=''>- Pilih Nomor PO -</option>
								<option value='Tanpa SPPB'>- Tanpa PO -</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Tanggal Perolehan</label>
						<div class="col-xs-9">
							<input name="TANGGAL_PEROLEHAN" id="TANGGAL_PEROLEHAN" class="form-control" type="date">
						</div>
					</div>

					<?php if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) { ?>

						<div class="form-group">
							<label class="col-xs-3 control-label">Jumlah Barang</label>
							<div class="col-xs-9">
								<input type="number" class="form-control" name="JUMLAH_BARANG" id="JUMLAH_BARANG" />
							</div>
						</div>

					<?php
					} ?>

					<div class="form-group">
						<label class="control-label col-xs-3">Beli atau Sewa</label>
						<div class="col-xs-9">
							<select name="STATUS_KEPEMILIKAN" class="form-control" id="STATUS_KEPEMILIKAN">
								<option value=''>- Pilih Beli atau Sewa -</option>
								<option value='Beli'>Beli</option>
								<option value='Sewa'>Sewa</option>
							</select>
						</div>
					</div>

					<div class="form-group" id="show_hidden_tanggal_mulai_sewa" hidden>
						<label class="control-label col-xs-3">Tanggal Mulai Sewa</label>
						<div class="col-xs-9">
							<input name="TANGGAL_MULAI_SEWA_HARI" id="TANGGAL_MULAI_SEWA_HARI" class="form-control" type="date">
						</div>
					</div>

					<div class="form-group" id="show_hidden_tanggal_selesai_sewa" hidden>
						<label class="control-label col-xs-3">Tanggal Selesai Sewa</label>
						<div class="col-xs-9">
							<input name="TANGGAL_SELESAI_SEWA_HARI" id="TANGGAL_SELESAI_SEWA_HARI" class="form-control" type="date">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Posisi</label>
						<div class="col-xs-9">
							<select name="POSISI" class="form-control" id="POSISI">
								<option value=''>- Pilih Posisi -</option>
								<option value='GUDANG'>Berada di Gudang</option>
								<option value='USER'>Dipakai oleh User</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Kondisi</label>
						<div class="col-xs-9">
							<select name="KONDISI" class="form-control" id="KONDISI">
								<option value=''>- Pilih Kondisi -</option>
								<option value='DAPAT DIGUNAKAN'>Dapat Digunakan</option>
								<option value='RUSAK'>Rusak</option>
								<option value='HILANG'>Hilang</option>
								<option value='DALAM PERBAIKAN'>Dalam Perbaikan</option>
							</select>
						</div>
					</div>

					<div class="alert alert-info alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Upload file dokumen dilakukan di halaman profil barang entitas / asset.
					</div>

					<div id="alert-msg"></div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" id="btn_simpan"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END MODAL ADD-->

<!--MODAL HAPUS-->
<div class="modal fade" id="ModalHapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>
				<h4 class="modal-title" id="myModalLabel">Hapus Data Barang Entitas</h4>
			</div>
			<form class="form-horizontal">
				<div class="modal-body">

					<input type="hidden" name="kode" id="textkode" value="">
					<div class="alert alert-warning">
						<p>Apakah Anda yakin ingin menghapus data ini?</p>
						<div name="KODE_BARANG_ENTITAS_3" id="KODE_BARANG_ENTITAS_3"></div>
					</div>

				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn_hapus btn btn-danger" id="btn_hapus"><i class="fa fa-trash"></i> Hapus</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!--END MODAL HAPUS-->

<!-- MODAL EDIT-->
<div class="modal inmodal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content animated bounceInRight">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<i class="fa fa-group modal-icon"></i>
				<h4 class="modal-title">Asset</h4>
				<small class="font-bold">Silakan Ubah Data Asset</small>
			</div>

			<div class="form-horizontal">
				<div class="modal-body">

					<input name="ID_BARANG_ENTITAS5" id="ID_BARANG_ENTITAS5" class="form-control" type="hidden" readonly>

					<div class="form-group">
						<label class="control-label col-xs-3">Tool/Consumable/<br>Material</label>
						<div class="col-xs-9">
							<div>
								<input type="text" class="form-control" value='<?php echo $PERALATAN_PERLENGKAPAN; ?>' name="PERALATAN_PERLENGKAPAN5" id="PERALATAN_PERLENGKAPAN5" disabled />
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Kode Barang Master</label>
						<div class="col-xs-9">
							<div>
								<input name="KODE_BARANG_MASTER5" id="KODE_BARANG_MASTER5" class="form-control" type="text" value='<?php echo $KODE_BARANG; ?>' disabled>
								<input name="ID_BARANG_MASTER5" id="ID_BARANG_MASTER5" class="form-control" type="hidden" value='<?php echo $ID_BARANG_MASTER; ?>'>
							</div>
						</div>
					</div>

					<input type="hidden" class="form-control" value="" name="JUMLAH_COUNT5" id="JUMLAH_COUNT5" disabled />

					<div class="form-group">
						<label class="control-label col-xs-3">Kode Barang Entitas</label>
						<div class="col-xs-9">
							<div>
								<input name="KODE_BARANG_ENTITAS5" id="KODE_BARANG_ENTITAS5" class="form-control" type="text" disabled>
							</div>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Proyek</label>
						<div class="col-xs-9">
							<input name="ID_PROYEK5" id="ID_PROYEK5" class="form-control" type="hidden">
							<input name="NAMA_PROYEK5" id="NAMA_PROYEK5" class="form-control" type="text" disabled>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Gudang</label>
						<div class="col-xs-9">
							<input name="ID_GUDANG5" id="ID_GUDANG5" class="form-control" type="hidden">
							<input name="NAMA_GUDANG5" id="NAMA_GUDANG5" class="form-control" type="text" disabled>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nomor Urut SPPB</label>
						<div class="col-xs-9">
							<select name="ID_SPPB5" class="form-control" id="ID_SPPB5">
								<option value=''>- Pilih Nomor SPPB -</option>
								<option value='0'>- Tanpa SPPB -</option>
								<?php foreach ($sppb_list as $item) {
									echo '<option value="' . $item->ID_SPPB . '">' . $item->NO_URUT_SPPB . '</option>';
								} ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Nomor Urut PO</label>
						<div class="col-xs-9">
							<select name="ID_PO5" class="form-control" id="ID_PO5">
								<option value=''>- Pilih Nomor PO -</option>
								<option value='Tanpa SPPB'>- Tanpa PO -</option>

							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Tanggal Perolehan</label>
						<div class="col-xs-9">
							<input name="TANGGAL_PEROLEHAN_HARI5" id="TANGGAL_PEROLEHAN_HARI5" class="form-control" type="date">
						</div>
					</div>

					<?php if ($PERALATAN_PERLENGKAPAN == ("CONSUMABLE")) { ?>

						<div class="form-group">
							<label class="col-xs-3 control-label">Jumlah Barang</label>
							<div class="col-xs-9">
								<input type="number" class="form-control" name="JUMLAH_BARANG5" id="JUMLAH_BARANG5" />
							</div>
						</div>

					<?php
					} ?>

					<div class="form-group">
						<label class="control-label col-xs-3">Beli atau Sewa</label>
						<div class="col-xs-9">
							<select name="STATUS_KEPEMILIKAN5" class="form-control" id="STATUS_KEPEMILIKAN5">
								<option value=''>- Pilih Beli atau Sewa -</option>
								<option value='Beli'>Beli</option>
								<option value='Sewa'>Sewa</option>
							</select>
						</div>
					</div>

					<div class="form-group" id="show_hidden_tanggal_mulai_sewa5" hidden>
						<label class="control-label col-xs-3">Tanggal Mulai Sewa</label>
						<div class="col-xs-9">
							<input name="TANGGAL_MULAI_SEWA_HARI5" id="TANGGAL_MULAI_SEWA_HARI5" class="form-control" type="date">
						</div>
					</div>

					<div class="form-group" id="show_hidden_tanggal_selesai_sewa5" hidden>
						<label class="control-label col-xs-3">Tanggal Selesai Sewa</label>
						<div class="col-xs-9">
							<input name="TANGGAL_SELESAI_SEWA_HARI5" id="TANGGAL_SELESAI_SEWA_HARI5" class="form-control" type="date">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Posisi</label>
						<div class="col-xs-9">
							<select name="POSISI5" class="form-control" id="POSISI5">
								<option value=''>- Pilih Posisi -</option>
								<option value='GUDANG'>Berada di Gudang</option>
								<option value='USER'>Dipakai oleh User</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-xs-3">Kondisi</label>
						<div class="col-xs-9">
							<select name="KONDISI5" class="form-control" id="KONDISI5">
								<option value=''>- Pilih Kondisi -</option>
								<option value='DAPAT DIGUNAKAN'>Dapat Digunakan</option>
								<option value='RUSAK'>Rusak</option>
								<option value='HILANG'>Hilang</option>
								<option value='DALAM PERBAIKAN'>Dalam Perbaikan</option>
							</select>
						</div>
					</div>

					<div class="alert alert-info alert-dismissable">
						<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
						Upload file dokumen dilakukan di halaman profil barang entitas / asset.
					</div>

					<div id="alert-msg-5"></div>

				</div>

				<div class="modal-footer">
					<button class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-window-close"></i> Batal</button>
					<button class="btn btn-primary" id="btn_update"><i class="fa fa-save"></i> Simpan</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
<!--END MODAL EDIT-->

<!-- Mainly scripts -->
<script src="<?php echo base_url(); ?>assets/wasa/js/jquery-3.1.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dataTables/datatables.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="<?php echo base_url(); ?>assets/wasa/js/inspinia.js"></script>
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/pace/pace.min.js"></script>

<!-- DROPZONE -->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/dropzone/dropzone.js"></script>

<!-- slick carousel-->
<script src="<?php echo base_url(); ?>assets/wasa/js/plugins/slick/slick.min.js"></script>

<!-- Page-Level Scripts -->


<script>
	$(document).ready(function() {
		$('.product-images').slick({
			dots: true
		});

		$('#NO_URUT_BARANG').keyup(function() {
			var kode_barang_master = "<?php echo $KODE_BARANG ?>";
			var KODE_BARANG_ENTITAS = "";
			var NO_URUT = "";

			NO_URUT = $('[name="NO_URUT_BARANG"]').val();

			KODE_BARANG_ENTITAS = kode_barang_master + "." + NO_URUT;
			$('[name="KODE_BARANG_ENTITAS"]').val(KODE_BARANG_ENTITAS);

		});

		tampil_data_barang_entitas(); //pemanggilan fungsi tampil data.

		$('#mydata').dataTable({
			pageLength: 10,
			responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [{
					extend: 'copy'
				},
				{
					extend: 'csv'
				},
				{
					extend: 'excel',
					title: 'Barang Entitas'
				},
				{
					extend: 'pdf',
					title: 'Barang Entitas'
				},

				{
					extend: 'print',
					customize: function(win) {
						$(win.document.body).addClass('white-bg');
						$(win.document.body).css('font-size', '10px');

						$(win.document.body).find('table')
							.addClass('compact')
							.css('font-size', 'inherit');
					}
				}
			]

		});

		//fungsi tampil data
		function tampil_data_barang_entitas() {
			var id = <?php echo $ID_BARANG_MASTER; ?>;
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url() ?>barang_entitas/data_barang_entitas_by_id_master',
				async: false,
				dataType: 'json',
				data: {
					id: id
				},
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {

						let ID_SPPB = data[i].ID_SPPB;
						let ID_PO = data[i].ID_PO;

						if (ID_SPPB == "0") {
							NO_URUT_SPPB_cetak = 'Tanpa SPPB';
						} else {
							NO_URUT_SPPB_cetak = data[i].NO_URUT_SPPB;
						}

						if (ID_PO == "0") {
							NO_URUT_PO_cetak = 'Tanpa PO';
						} else {
							NO_URUT_PO_cetak = data[i].NO_URUT_PO;
						}

						html += '<tr>' +
							'<td>' + data[i].KODE_BARANG_ENTITAS + '</td>' +
							'<td>' + data[i].TANGGAL_PEROLEHAN_HARI + '</td>' +
							'<td>' + NO_URUT_SPPB_cetak + '</td>' +
							'<td>' + NO_URUT_PO_cetak + '</td>' +
							'<td>' + data[i].STATUS_KEPEMILIKAN + '</td>' +
							'<td>' + data[i].TANGGAL_MULAI_SEWA_HARI + '</td>' +
							'<td>' + data[i].TANGGAL_SELESAI_SEWA_HARI + '</td>' +
							'<td>' + data[i].NAMA_GUDANG + ' - Berada di: ' + data[i].POSISI + '</td>' +
							'<td>' + data[i].JUMLAH_BARANG + '</td>' +
							'<td>' + data[i].KONDISI + '</td>' +
							'<td>' +
							'<a href="<?php echo base_url() ?>Riwayat_pemakaian_barang_entitas/item/' + data[i].HASH_MD5_BARANG_ENTITAS + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Riwayat Pemakaian Barang </a>' + ' ' +
							'<a href="<?php echo base_url() ?>Riwayat_perbaikan_barang_entitas/item/' + data[i].HASH_MD5_BARANG_ENTITAS + '" class="btn btn-info btn-xs block"><i class="fa fa-eye"></i> Riwayat Perbaikan Barang </a>' + ' ' +
							'<a href="javascript:;" class="btn btn-warning btn-xs item_edit block" data="' + data[i].ID_BARANG_ENTITAS + '"><i class="fa fa-pencil"></i> Edit</a>' + ' ' +
							'<a href="javascript:;" class="btn btn-danger btn-xs item_hapus block" data="' + data[i].ID_BARANG_ENTITAS + '"><i class="fa fa-trash"></i> Hapus</a>' +
							'</td>' +
							'</tr>';

					}
					$('#show_data').html(html);
				}
			});
		}

		$('#ModalAdd').on('shown.bs.modal', function(e) {
			var COUNT = "";
			var NO_URUT_1, NO_URUT_2 = "";
			var DEPAN_1, DEPAN_2 = "";
			var KODE_BARANG_ENTITAS = "";

			var id = <?php echo $ID_BARANG_MASTER ?>;
			var kode_barang_master = "<?php echo $KODE_BARANG ?>";
			$.ajax({
				type: "GET",
				url: "<?php echo base_url() ?>Barang_entitas/get_nomor_urut_by_ID_BARANG_MASTER",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function() {

						var SUDAH_SAMPAI_KE = data.JUMLAH_COUNT;
						var SELANG = $('#QUANTITY_ENTITAS').val();
						var SAMPAI_DENGAN = 0;

						console.log(SUDAH_SAMPAI_KE);
						console.log(SELANG);

						if (SUDAH_SAMPAI_KE == null) {
							SUDAH_SAMPAI_KE = "0";
						}
						if (SUDAH_SAMPAI_KE == NaN) {
							SUDAH_SAMPAI_KE = "0";
						}

						SUDAH_SAMPAI_KE = parseInt(SUDAH_SAMPAI_KE) + 1;
						SAMPAI_DENGAN = parseInt(data.JUMLAH_COUNT) + parseInt(SELANG);

						if (SUDAH_SAMPAI_KE < 1000) {
							DEPAN_1 = "0";
						}

						if (SUDAH_SAMPAI_KE < 100) {
							DEPAN_1 = "00";
						}

						if (SUDAH_SAMPAI_KE < 10) {
							DEPAN_1 = "000";
						}

						if (SAMPAI_DENGAN < 1000) {
							DEPAN_2 = "0";
						}

						if (SAMPAI_DENGAN < 100) {
							DEPAN_2 = "00";
						}

						if (SAMPAI_DENGAN < 10) {
							DEPAN_2 = "000";
						}


						var str1 = DEPAN_1;
						var str2 = SUDAH_SAMPAI_KE;

						var str3 = DEPAN_2;
						var str4 = SAMPAI_DENGAN;
						console.log(str4);

						var belakang_1 = +str2.toString();
						NO_URUT_1 = str1 + str2.toString();

						var belakang_2 = +str4.toString();
						NO_URUT_2 = str3 + str4.toString();
						console.log(NO_URUT_2);

						KODE_BARANG_ENTITAS_START = kode_barang_master + "." + NO_URUT_1;
						KODE_BARANG_ENTITAS_END = kode_barang_master + "." + NO_URUT_2;

						$('[name="JUMLAH_COUNT"]').val(SAMPAI_DENGAN);
						$('[name="NO_URUT_BARANG"]').val(NO_URUT_1);
						$('[name="KODE_BARANG_ENTITAS_START"]').val(KODE_BARANG_ENTITAS_START);
						$('[name="KODE_BARANG_ENTITAS_END"]').val(KODE_BARANG_ENTITAS_END);
						$('[name="SUDAH_SAMPAI_KE"]').val(SUDAH_SAMPAI_KE);
					});

				}
			});
		})

		// Dropdown Berubah
		$('#QUANTITY_ENTITAS').change(function() {
			var COUNT = "";
			var NO_URUT_1, NO_URUT_2 = "";
			var DEPAN_1, DEPAN_2 = "";
			var KODE_BARANG_ENTITAS = "";

			var id = <?php echo $ID_BARANG_MASTER ?>;
			var kode_barang_master = "<?php echo $KODE_BARANG ?>";
			$.ajax({
				type: "GET",
				url: "<?php echo base_url() ?>Barang_entitas/get_nomor_urut_by_ID_BARANG_MASTER",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function() {

						var SUDAH_SAMPAI_KE = data.JUMLAH_COUNT;
						var SELANG = $('#QUANTITY_ENTITAS').val();
						var SAMPAI_DENGAN = 0;

						console.log(SUDAH_SAMPAI_KE);
						console.log(SELANG);

						if (SUDAH_SAMPAI_KE == null) {
							SUDAH_SAMPAI_KE = "0";
						}
						if (SUDAH_SAMPAI_KE == NaN) {
							SUDAH_SAMPAI_KE = "0";
						}

						SUDAH_SAMPAI_KE = parseInt(SUDAH_SAMPAI_KE) + 1;
						SAMPAI_DENGAN = parseInt(data.JUMLAH_COUNT) + parseInt(SELANG);

						if (SUDAH_SAMPAI_KE < 1000) {
							DEPAN_1 = "0";
						}

						if (SUDAH_SAMPAI_KE < 100) {
							DEPAN_1 = "00";
						}

						if (SUDAH_SAMPAI_KE < 10) {
							DEPAN_1 = "000";
						}

						if (SAMPAI_DENGAN < 1000) {
							DEPAN_2 = "0";
						}

						if (SAMPAI_DENGAN < 100) {
							DEPAN_2 = "00";
						}

						if (SAMPAI_DENGAN < 10) {
							DEPAN_2 = "000";
						}


						var str1 = DEPAN_1;
						var str2 = SUDAH_SAMPAI_KE;

						var str3 = DEPAN_2;
						var str4 = SAMPAI_DENGAN;
						console.log(str4);

						var belakang_1 = +str2.toString();
						NO_URUT_1 = str1 + str2.toString();

						var belakang_2 = +str4.toString();
						NO_URUT_2 = str3 + str4.toString();
						console.log(NO_URUT_2);

						KODE_BARANG_ENTITAS_START = kode_barang_master + "." + NO_URUT_1;
						KODE_BARANG_ENTITAS_END = kode_barang_master + "." + NO_URUT_2;

						$('[name="JUMLAH_COUNT"]').val(SAMPAI_DENGAN);
						$('[name="NO_URUT_BARANG"]').val(NO_URUT_1);
						$('[name="KODE_BARANG_ENTITAS_START"]').val(KODE_BARANG_ENTITAS_START);
						$('[name="KODE_BARANG_ENTITAS_END"]').val(KODE_BARANG_ENTITAS_END);
						$('[name="SUDAH_SAMPAI_KE"]').val(SUDAH_SAMPAI_KE);
					});

				}
			});

		});

		// Dropdown ID PROYEK Untuk Manggil SPPB pada Modal Add Berubah
		$('#ID_PROYEK').change(function() {
			var ID_PROYEK = $('#ID_PROYEK').val();

			// Menggunakan ajax untuk mengirim dan dan menerima data dari server
			$.ajax({
				url: "<?php echo base_url(); ?>/Barang_entitas/get_list_sppb_by_id_proyek",
				method: "POST",
				data: {
					ID_PROYEK: ID_PROYEK
				},
				async: false,
				dataType: 'json',
				success: function(data) {

					var html = '';
					var i;
					if (data != "TIDAK ADA DATA") {
						for (i = 0; i < data.length; i++) {
							html += '<option value=' + data[i].ID_SPPB + '>' + data[i].NO_URUT_SPPB + '</option>';
						}
						html += '<option value="Tanpa SPPB">- Tanpa SPPB -</option>';
						$('#ID_SPPB').html(html);
						tampil_cari_list_po();
					} else {
						html += '<option value="Tanpa SPPB">- Tanpa SPPB -</option>';
						$('#ID_SPPB').html(html);
					}
				}
			});
		});

		function tampil_cari_list_po() {
			var ID_SPPB = $('#ID_SPPB').val();

			// Menggunakan ajax untuk mengirim dan dan menerima data dari server
			$.ajax({
				url: "<?php echo base_url(); ?>/Barang_entitas/get_list_po_by_id_sppb",
				method: "POST",
				data: {
					ID_SPPB: ID_SPPB
				},
				async: false,
				dataType: 'json',
				success: function(data) {

					var html = '';
					var i;
					if (data != "TIDAK ADA DATA") {
						for (i = 0; i < data.length; i++) {
							html += '<option value=' + data[i].ID_PO + '>' + data[i].NO_URUT_PO + '</option>';
						}
						html += '<option value="Tanpa SPPB">- Tanpa PO -</option>';
						$('#ID_PO').html(html);
					} else {
						html += '<option value="Tanpa SPPB">- Tanpa PO -</option>';
						$('#ID_PO').html(html);
					}
				}
			});
		};

		// Dropdown ID SPPB Untuk Manggil PO pada Modal ADD Berubah
		$('#ID_SPPB').change(function() {
			var ID_SPPB = $('#ID_SPPB').val();

			// Menggunakan ajax untuk mengirim dan dan menerima data dari server
			$.ajax({
				url: "<?php echo base_url(); ?>/Barang_entitas/get_list_po_by_id_sppb",
				method: "POST",
				data: {
					ID_SPPB: ID_SPPB
				},
				async: false,
				dataType: 'json',
				success: function(data) {

					var html = '';
					var i;
					if (data != "TIDAK ADA DATA") {
						for (i = 0; i < data.length; i++) {
							html += '<option value=' + data[i].ID_PO + '>' + data[i].NO_URUT_PO + '</option>';
						}
						html += '<option value="Tanpa SPPB">- Tanpa PO -</option>';
						$('#ID_PO').html(html);
					} else {
						html += '<option value="Tanpa SPPB">- Tanpa PO -</option>';
						$('#ID_PO').html(html);
					}
				}
			});
		});

		// Dropdown ID PROYEK Untuk Manggil Gudang pada Modal Add Berubah
		$('#ID_PROYEK').change(function() {
			var proyek = $('#ID_PROYEK').val();

			// Menggunakan ajax untuk mengirim dan dan menerima data dari server
			$.ajax({
				url: "<?php echo base_url(); ?>/Barang_entitas/get_gudang_proyek",
				method: "POST",
				data: {
					proyek: proyek
				},
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;

					for (i = 0; i < data.length; i++) {
						html += '<option value=' + data[i].ID_GUDANG + '>' + data[i].NAMA_GUDANG + '</option>';
					}
					$('#ID_GUDANG').html(html);

				}
			});
		});

		// Dropdown ID SPPB Untuk Manggil PO pada Modal Edit Berubah
		$('#ID_SPPB5').change(function() {
			var ID_SPPB = $('#ID_SPPB5').val();

			// Menggunakan ajax untuk mengirim dan dan menerima data dari server
			$.ajax({
				url: "<?php echo base_url(); ?>/Barang_entitas/get_list_po_by_id_sppb",
				method: "POST",
				data: {
					ID_SPPB: ID_SPPB
				},
				async: false,
				dataType: 'json',
				success: function(data) {

					var html = '';
					var i;
					if (data != "TIDAK ADA DATA") {
						for (i = 0; i < data.length; i++) {
							html += '<option value=' + data[i].ID_PO + '>' + data[i].NO_URUT_PO + '</option>';
						}
						html += '<option value="Tanpa SPPB">- Tanpa PO -</option>';
						$('#ID_PO5').html(html);
					} else {
						html += '<option value="Tanpa SPPB">- Tanpa PO -</option>';
						$('#ID_PO5').html(html);
					}
				}
			});
		});

		$("#STATUS_KEPEMILIKAN").change(function() {
			if ($("#STATUS_KEPEMILIKAN option:selected").text() == 'Sewa') {
				$('#show_hidden_tanggal_mulai_sewa').attr("hidden", false); //enable input
				$('#show_hidden_tanggal_selesai_sewa').attr("hidden", false); //enable input

			} else {
				$('#show_hidden_tanggal_mulai_sewa').attr("hidden", true); //enable input
				$('#show_hidden_tanggal_selesai_sewa').attr("hidden", true); //enable input

			}
		});

		$("#STATUS_KEPEMILIKAN5").change(function() {
			if ($("#STATUS_KEPEMILIKAN5 option:selected").text() == 'Sewa') {
				$('#show_hidden_tanggal_mulai_sewa5').attr("hidden", false); //enable input
				$('#show_hidden_tanggal_selesai_sewa5').attr("hidden", false); //enable input

			} else {
				$('#show_hidden_tanggal_mulai_sewa5').attr("hidden", true); //enable input
				$('#show_hidden_tanggal_selesai_sewa5').attr("hidden", true); //enable input

			}
		});

		$('.file-box').each(function() {
			animationHover(this, 'pulse');
		});

		//SIMPAN DATA
		$('#btn_simpan').click(function() {
			var form_data = {
				ID_BARANG_MASTER: $('#ID_BARANG_MASTER').val(),
				KODE_BARANG_MASTER: $('#KODE_BARANG_MASTER').val(),
				QUANTITY_ENTITAS: $('#QUANTITY_ENTITAS').val(),
				KODE_BARANG_ENTITAS_START: $('#KODE_BARANG_ENTITAS_START').val(),
				KODE_BARANG_ENTITAS_END: $('#KODE_BARANG_ENTITAS_END').val(),
				SUDAH_SAMPAI_KE: $('#SUDAH_SAMPAI_KE').val(),
				NO_URUT_BARANG: $('#NO_URUT_BARANG').val(),
				ID_SPPB: $('#ID_SPPB').val(),
				JUMLAH_COUNT: $('#JUMLAH_COUNT').val(),
				ID_PO: $('#ID_PO').val(),
				TANGGAL_PEROLEHAN: $('#TANGGAL_PEROLEHAN').val(),
				JUMLAH_BARANG: $('#JUMLAH_BARANG').val(),
				STATUS_KEPEMILIKAN: $('#STATUS_KEPEMILIKAN').val(),
				TANGGAL_MULAI_SEWA_HARI: $('#TANGGAL_MULAI_SEWA_HARI').val(),
				TANGGAL_SELESAI_SEWA_HARI: $('#TANGGAL_SELESAI_SEWA_HARI').val(),
				ID_PROYEK: $('#ID_PROYEK').val(),
				ID_GUDANG: $('#ID_GUDANG').val(),
				POSISI: $('#POSISI').val(),
				KONDISI: $('#KONDISI').val(),
				PERALATAN_PERLENGKAPAN: $('#PERALATAN_PERLENGKAPAN').val()
			};
			$.ajax({
				url: "<?php echo site_url('Barang_entitas/simpan_data'); ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data == "") {
						$('#ModalAdd').modal('hide');
						window.location.reload();

					} else {
						$('#alert-msg').html('<div class="alert alert-danger">' + data + '</div>');
					}
				}
			});
			return false;
		});

		//GET UDPATE
		$('#show_data').on('click', '.item_edit', function() {
			var id = $(this).attr('data');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('Barang_entitas/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {

					$('#ModalEdit').modal('show');
					$('[name="ID_BARANG_ENTITAS5"]').val(data.ID_BARANG_ENTITAS);
					$('[name="KODE_BARANG_MASTER5"]').val(data.KODE_BARANG);
					$('[name="NO_URUT_BARANG5"]').val(data.NO_URUT_BARANG);
					$('[name="ID_BARANG_MASTER5"]').val(data.ID_BARANG_MASTER5);
					$('[name="KODE_BARANG_ENTITAS5"]').val(data.KODE_BARANG_ENTITAS);
					$('[name="PERALATAN_PERLENGKAPAN5"]').val(data.PERALATAN_PERLENGKAPAN);
					$('[name="ID_SPPB5"]').val(data.ID_SPPB);
					$('[name="ID_PO5"]').val('');
					$('[name="TANGGAL_PEROLEHAN_HARI5"]').val(data.TANGGAL_PEROLEHAN_HARI);
					$('[name="JUMLAH_BARANG5"]').val(data.JUMLAH_BARANG);
					$('[name="STATUS_KEPEMILIKAN5"]').val(data.STATUS_KEPEMILIKAN);
					$('[name="TANGGAL_MULAI_SEWA_HARI5"]').val(data.TANGGAL_MULAI_SEWA_HARI);
					$('[name="TANGGAL_SELESAI_SEWA_HARI5"]').val(data.TANGGAL_SELESAI_SEWA_HARI);
					$('[name="ID_PROYEK5"]').val(data.ID_PROYEK);
					$('[name="NAMA_PROYEK5"]').val(data.NAMA_PROYEK);
					$('[name="ID_GUDANG5"]').val(data.ID_GUDANG);
					$('[name="NAMA_GUDANG5"]').val(data.NAMA_GUDANG);
					$('[name="POSISI5"]').val(data.POSISI);
					$('[name="KONDISI5"]').val(data.KONDISI);

				}
			});
			return false;
		});

		//UPDATE DATA 
		$('#btn_update').on('click', function() {
			var form_data = {
				ID_BARANG_ENTITAS: $('#ID_BARANG_ENTITAS5').val(),
				ID_SPPB: $('#ID_SPPB5').val(),
				ID_PO: $('#ID_PO5').val(),
				TANGGAL_PEROLEHAN_HARI: $('#TANGGAL_PEROLEHAN_HARI5').val(),
				JUMLAH_BARANG: $('#JUMLAH_BARANG5').val(),
				STATUS_KEPEMILIKAN: $('#STATUS_KEPEMILIKAN5').val(),
				TANGGAL_MULAI_SEWA_HARI: $('#TANGGAL_MULAI_SEWA_HARI5').val(),
				TANGGAL_SELESAI_SEWA_HARI: $('#TANGGAL_SELESAI_SEWA_HARI5').val(),
				POSISI: $('#POSISI5').val(),
				KONDISI: $('#KONDISI5').val(),
				PERALATAN_PERLENGKAPAN: $('#PERALATAN_PERLENGKAPAN5').val()
			};
			$.ajax({
				url: "<?php echo site_url('Barang_entitas/update_data') ?>",
				type: 'POST',
				data: form_data,
				success: function(data) {
					if (data == true) {
						console.log(data);
						$('#ModalEdit').modal('hide');
						window.location.reload();
					} else {
						console.log(data);
						$('#alert-msg-5').html('<div class="alert alert-danger">' + data + '</div>');
					}
				}
			});
			return false;
		});

		//HAPUS DATA
		$('#btn_hapus').on('click', function() {
			var kode = $('#textkode').val();
			$.ajax({
				type: "POST",
				url: "<?php echo base_url('index.php/barang_entitas/hapus_data') ?>",
				dataType: "JSON",
				data: {
					kode: kode
				},
				success: function(data) {
					$('#ModalHapus').modal('hide');
					tampil_data_barang_entitas();
					window.location.reload();
				}
			});
			return false;
		});

		//GET HAPUS
		$('#show_data').on('click', '.item_hapus', function() {
			var id = $(this).attr('data');
			$.ajax({
				type: "GET",
				url: "<?php echo base_url('index.php/barang_entitas/get_data') ?>",
				dataType: "JSON",
				data: {
					id: id
				},
				success: function(data) {
					$.each(data, function(ID_BARANG_ENTITAS, KODE_BARANG_ENTITAS) {
						$('#ModalHapus').modal('show');
						$('[name="kode"]').val(id);
						$('#KODE_BARANG_ENTITAS_3').html('Kode Barang Entitas: ' + data.KODE_BARANG_ENTITAS);
					});
				}
			});
		});

		// Dropdown ID PROYEK berubah modal edit
		$("#ModalEdit").on('show.bs.modal', function() {
			var proyek = $('#ID_PROYEK5').val();

			// Menggunakan ajax untuk mengirim dan dan menerima data dari server
			$.ajax({
				url: "<?php echo base_url(); ?>/Barang_entitas/get_gudang_proyek",
				method: "POST",
				data: {
					proyek: proyek
				},
				async: false,
				dataType: 'json',
				success: function(data) {
					var html = '';
					var i;
					for (i = 0; i < data.length; i++) {
						html += '<option value=' + data[i].ID_GUDANG + '>' + data[i].NAMA_GUDANG + '</option>';
					}
					$('#ID_GUDANG5').html(html);

				}
			});

			if ($("#STATUS_KEPEMILIKAN5 option:selected").text() == 'Sewa') {
				$('#show_hidden_tanggal_mulai_sewa5').attr("hidden", false); //enable input
				$('#show_hidden_tanggal_selesai_sewa5').attr("hidden", false); //enable input

			} else {
				$('#show_hidden_tanggal_mulai_sewa5').attr("hidden", true); //enable input
				$('#show_hidden_tanggal_selesai_sewa5').attr("hidden", true); //enable input

			}
		});
	});
</script>

</body>

</html>