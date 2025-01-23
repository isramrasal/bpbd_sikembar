<?php
class Pengajuan_form_model extends CI_Model
{

	function data_barang_bantuan_form($ID_FORM_INVENTARIS_KORBAN_BENCANA)
	{
		$hasil = $this->db->query("SELECT * FROM item_form_pengajuan_barang WHERE ID_FORM_INVENTARIS_KORBAN_BENCANA = '$ID_FORM_INVENTARIS_KORBAN_BENCANA'");
		return $hasil->result();
	}

	function hapus_data_by_id_item_form_pengajuan_barang($ID_ITEM_FORM_PENGAJUAN_BARANG)
	{
		$hasil = $this->db->query("DELETE FROM item_form_pengajuan_barang WHERE ID_ITEM_FORM_PENGAJUAN_BARANG='$ID_ITEM_FORM_PENGAJUAN_BARANG'");
		return $hasil;
	}

	function hapus_data_by_id_form_inventaris_korban_bencana($ID_FORM_INVENTARIS_KORBAN_BENCANA)
	{
		$hasil = $this->db->query("DELETE FROM item_form_pengajuan_barang WHERE ID_FORM_INVENTARIS_KORBAN_BENCANA='$ID_FORM_INVENTARIS_KORBAN_BENCANA'");
        return $hasil;
	}

	function get_data_by_id_item_form_pengajuan_barang($ID_ITEM_FORM_PENGAJUAN_BARANG)
	{
		$hsl = $this->db->query("SELECT * FROM item_form_pengajuan_barang WHERE ID_ITEM_FORM_PENGAJUAN_BARANG = '$ID_ITEM_FORM_PENGAJUAN_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_ITEM_FORM_PENGAJUAN_BARANG' => $data->ID_ITEM_FORM_PENGAJUAN_BARANG,
					'ID_FORM_INVENTARIS_KORBAN_BENCANA' => $data->ID_FORM_INVENTARIS_KORBAN_BENCANA,
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

	function get_data_by_id_item_form_inventaris_korban_bencana($ID_ITEM_FORM_INVENTARIS_KORBAN_BENCANA)
	{
		$hsl = $this->db->query("SELECT * FROM item_form_pengajuan_barang WHERE ID_ITEM_FORM_INVENTARIS_KORBAN_BENCANA = '$ID_ITEM_FORM_INVENTARIS_KORBAN_BENCANA'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_ITEM_FORM_PENGAJUAN_BARANG' => $data->ID_ITEM_FORM_PENGAJUAN_BARANG,
					'ID_FORM_INVENTARIS_KORBAN_BENCANA' => $data->ID_FORM_INVENTARIS_KORBAN_BENCANA,
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
		$ID_ITEM_FORM_PENGAJUAN_BARANG,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$SATUAN_BARANG,
		$JENIS_BANTUAN,
		$KETERANGAN)
	{
		$hasil = $this->db->query("UPDATE item_form_pengajuan_barang SET 
			NAMA_BARANG='$NAMA',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			JUMLAH_BARANG='$JUMLAH_BARANG',
			SATUAN_BARANG='$SATUAN_BARANG',
			JENIS_BANTUAN='$JENIS_BANTUAN',
			KETERANGAN='$KETERANGAN'
			WHERE ID_ITEM_FORM_PENGAJUAN_BARANG='$ID_ITEM_FORM_PENGAJUAN_BARANG'");
		return $hasil;
	}
	function simpan_data_barang_bantuan(
		$ID_FORM_INVENTARIS_KORBAN_BENCANA,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$SATUAN_BARANG,
		$JENIS_BANTUAN,
		$KETERANGAN
	) {
		$hasil = $this->db->query("INSERT INTO item_form_pengajuan_barang (
				ID_FORM_INVENTARIS_KORBAN_BENCANA,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG,
				SATUAN_BARANG,
				JENIS_BANTUAN,
				KETERANGAN
				)
			VALUES(
				'$ID_FORM_INVENTARIS_KORBAN_BENCANA',
				'$NAMA',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG',
				'$SATUAN_BARANG',
				'$JENIS_BANTUAN',
                '$KETERANGAN'
				 )");
		return $hasil;
	}
}