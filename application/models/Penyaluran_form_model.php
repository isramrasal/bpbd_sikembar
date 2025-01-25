<?php
class Penyaluran_form_model extends CI_Model
{

	function data_penyaluran_barang_form($ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA)
	{
		$hasil = $this->db->query("SELECT * FROM item_form_penyaluran_barang WHERE ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA = '$ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA'");
		return $hasil->result();
	}

	function hapus_data_by_id_item_form_pengajuan_barang($ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA )
	{
		$hasil = $this->db->query("DELETE FROM item_form_penyaluran_barang WHERE ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA='$ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA '");
		return $hasil;
	}

	function hapus_data_by_ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA($ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA)
	{
		$hasil = $this->db->query("DELETE FROM item_form_penyaluran_barang WHERE ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA='$ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA'");
        return $hasil;
	}

	function get_data_by_id_item_form_penyaluran_barang($ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA )
	{
		$hsl = $this->db->query("SELECT * FROM item_form_penyaluran_barang WHERE ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA = '$ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA '");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA ' => $data->ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA ,
					'ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA' => $data->ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA,
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
			$hasil = "BELUM ADA Penyaluran Barang";
		}
		return $hasil;
	}

	function get_data_by_ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA ($ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA )
	{
		$hsl = $this->db->query("SELECT * FROM item_form_penyaluran_barang WHERE ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA  = '$ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA '");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_ITEM_FORM_PENGAJUAN_BARANG' => $data->ID_ITEM_FORM_PENGAJUAN_BARANG,
					'ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA' => $data->ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA,
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


	function update_data_penyaluran_barang(
		$ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA ,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$SATUAN_BARANG,
		$JENIS_BANTUAN,
		$KETERANGAN)
	{
		$hasil = $this->db->query("UPDATE item_form_penyaluran_barang SET 
			NAMA_BARANG='$NAMA',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			JUMLAH_BARANG='$JUMLAH_BARANG',
			SATUAN_BARANG='$SATUAN_BARANG',
			JENIS_BANTUAN='$JENIS_BANTUAN',
			KETERANGAN='$KETERANGAN'
			WHERE ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA ='$ID_ITEM_FORM_PENYALURAN_BARANG_BENCANA '");
		return $hasil;
	}

	function simpan_data_penyaluran_barang(
		$ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$SATUAN_BARANG,
		$KLASIFIKASI_BARANG,
		$KETERANGAN
	) {
		$hasil = $this->db->query("INSERT INTO item_form_penyaluran_barang (
				ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG,
				SATUAN_BARANG,
				KLASIFIKASI_BARANG,
				KETERANGAN
				)
			VALUES(
				'$ID_FORM_INVENTARIS_PENYALURAN_BARANG_BENCANA',
				'$NAMA',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG',
				'$SATUAN_BARANG',
				'$KLASIFIKASI_BARANG',
                '$KETERANGAN'
				 )");
		return $hasil;
	}
}