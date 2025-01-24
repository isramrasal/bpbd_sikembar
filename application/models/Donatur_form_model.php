<?php
class Donatur_form_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb form
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function data_sppb_form
	//         2. 
	function data_barang_bantuan_form($ID_FORM_INVENTARIS_BANTUAN_DONASI)
	{
		$hasil = $this->db->query("SELECT * FROM item_form_bantuan_donasi WHERE ID_FORM_INVENTARIS_BANTUAN_DONASI = '$ID_FORM_INVENTARIS_BANTUAN_DONASI'");
		return $hasil->result();
	}

	function hapus_data_by_id_item_form_bantuan_donasi($ID_ITEM_FORM_BANTUAN_DONASI)
	{
		$hasil = $this->db->query("DELETE FROM item_form_bantuan_donasi WHERE ID_ITEM_FORM_BANTUAN_DONASI='$ID_ITEM_FORM_BANTUAN_DONASI'");
		return $hasil;
	}

	function get_data_by_id_item_form_bantuan_donasi($ID_ITEM_FORM_BANTUAN_DONASI)
	{
		$hsl = $this->db->query("SELECT * FROM item_form_bantuan_donasi WHERE ID_ITEM_FORM_BANTUAN_DONASI = '$ID_ITEM_FORM_BANTUAN_DONASI'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_ITEM_FORM_BANTUAN_DONASI' => $data->ID_ITEM_FORM_BANTUAN_DONASI,
					'ID_FORM_INVENTARIS_BANTUAN_DONASI' => $data->ID_FORM_INVENTARIS_BANTUAN_DONASI,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'JENIS_BANTUAN' => $data->JENIS_BANTUAN,
					'KETERANGAN' => $data->KETERANGAN
				);
			}
		} else {
			$hasil = "BELUM ADA Pengajuan Barang";
		}
		return $hasil;
	}

	function update_data_barang_bantuan(
		$ID_ITEM_FORM_BANTUAN_DONASI,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$SATUAN_BARANG,
		$JENIS_BANTUAN,
		$KETERANGAN)
	{
		$hasil = $this->db->query("UPDATE item_form_bantuan_donasi SET 
			NAMA_BARANG='$NAMA',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			JUMLAH_BARANG='$JUMLAH_BARANG',
			SATUAN_BARANG='$SATUAN_BARANG',
			JENIS_BANTUAN='$JENIS_BANTUAN',	
			KETERANGAN='$KETERANGAN'
			WHERE ID_ITEM_FORM_BANTUAN_DONASI='$ID_ITEM_FORM_BANTUAN_DONASI'");
		return $hasil;
	}

	function simpan_data_barang_bantuan(
		$ID_FORM_INVENTARIS_BANTUAN_DONASI,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$SATUAN_BARANG,
		$KLASIFIKASI_BARANG,
		$JENIS_BANTUAN,
		$KETERANGAN
	) {
		$hasil = $this->db->query("INSERT INTO item_form_bantuan_donasi (
				ID_FORM_INVENTARIS_BANTUAN_DONASI,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG,
				SATUAN_BARANG,
				KLASIFIKASI_BARANG,
				JENIS_BANTUAN,
				KETERANGAN
				)
			VALUES(
				'$ID_FORM_INVENTARIS_BANTUAN_DONASI',
				'$NAMA',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG',
				'$SATUAN_BARANG',
				'$KLASIFIKASI_BARANG',
				'$JENIS_BANTUAN',
                '$KETERANGAN'
				 )");
		return $hasil;
	}

	function simpan_data_dari_fpb_form(
		$ID_SPPB,
		$ID_FPB_FORM,
		$ID_RASD_FORM,
		$ID_BARANG_MASTER,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_MINTA,
		$TANGGAL_MULAI_PAKAI_HARI,
		$TANGGAL_SELESAI_PAKAI_HARI
	) {
		$hasil = $this->db->query("INSERT INTO sppb_form (
				ID_SPPB,
				ID_FPB_FORM,
				ID_RASD_FORM,
				ID_BARANG_MASTER,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA,
				JUMLAH_SETUJU_TERAKHIR,
				TANGGAL_MULAI_PAKAI_HARI,
				TANGGAL_SELESAI_PAKAI_HARI
				)
			VALUES(
				'$ID_SPPB',
				'$ID_FPB_FORM',
				'$ID_RASD_FORM',
				'$ID_BARANG_MASTER',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_MINTA',
				'$JUMLAH_MINTA',
				'$TANGGAL_MULAI_PAKAI_HARI',
				'$TANGGAL_SELESAI_PAKAI_HARI'
				 )");
		return $hasil;
	}
}