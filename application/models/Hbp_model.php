<?php
class Hbp_model extends CI_Model
{

	function hbp_barang_list()
	{
		$hasil = $this->db->query("SELECT H.ID_HBP, S.ID_SPPB, V.ID_VENDOR, 
		H.HARGA_SATUAN_VENDOR, H.DELIVERY_VENDOR, H.SISTEM_BAYAR_VENDOR, 
		H.KETERANGAN_HBP, H.TANGGAL_HBP_HARI, V.NAMA_VENDOR
		FROM harga_barang_pemasok AS S
		LEFT JOIN harga_barang_pemasok AS H ON S.ID_SPPB = H.ID_SPPB
        LEFT JOIN vendor AS V ON V.ID_VENDOR = H.ID_VENDOR
		");
		return $hasil->result();
	}


	// function get_sppb_barang_by_id_khp_barang($ID_KHP_BARANG)
	// {
	// 	$hasil = $this->db->query("SELECT KB.ID_KHP_BARANG, SB.ID_SPPB_BARANG, K.ID_KHP, 
	// 	H.ID_HBP, KB.KEPUTUSAN_HARGA_SATUAN, KB.KEPUTUSAN_DELIVERY, KB.KEPUTUSAN_VENDOR, 
	// 	KB.KETERANGAN_KHP_BARANG_STAFF_PROC, KB.KETERANGAN_KHP_BARANG_KASIE, 
	// 	KB.KETERANGAN_KHP_BARANG_M_PROC, KB.JUMLAH_ITEM_BARANG
	// 	FROM sppb_barang AS SB
	// 	LEFT JOIN khp_barang AS KB ON SB.ID_SPPB_BARANG = KB.ID_SPPB_BARANG
	// 	LEFT JOIN komparasi_harga_pemasok AS K ON SB.ID_KHP = K.ID_KHP
	// 	LEFT JOIN harga_barang_pemasok AS H ON SB.ID_HBP = H.ID_HBP
	// 	WHERE KB.ID_KHP_BARANG ='$ID_KHP_BARANG'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	function hbp_barang_list_by_id_khp_barang($ID_KHP_BARANG)
	{
		$hasil = $this->db->query("SELECT H.ID_HBP, V.ID_VENDOR, H.ID_KHP_BARANG,
		H.HARGA_SATUAN_VENDOR, H.DELIVERY_VENDOR, H.SISTEM_BAYAR_VENDOR, 
		H.KETERANGAN_HBP, H.TANGGAL_HBP_HARI, V.NAMA_VENDOR
		FROM harga_barang_pemasok AS H
		LEFT JOIN vendor AS V ON H.ID_VENDOR = V.ID_VENDOR
		WHERE
		H.ID_KHP_BARANG = '$ID_KHP_BARANG'");
		// return $hasil;
		return $hasil->result();
	}

	function barang_master_list_where_not_in_khp($ID_KHP)
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.KODE_BARANG, M.MEREK, 
		J.NAMA_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
		M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
        WHERE NOT EXISTS (SELECT ID_BARANG_MASTER 
		FROM khp_barang 
		WHERE khp_barang.ID_BARANG_MASTER = M.ID_BARANG_MASTER 
		AND khp_barang.ID_KHP = '$ID_KHP')");
		// return $hasil;
		return $hasil->result();
	}



	// function Rasd_barang_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM Rasd_barang WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM Rasd_barang WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }

	function hapus_data_by_id_hbp($ID_HBP)
	{
		$hasil = $this->db->query("DELETE FROM harga_barang_pemasok WHERE ID_HBP='$ID_HBP'");
		return $hasil;
	}

	function get_data_by_id_hbp($ID_HBP)
	{
		$hsl = $this->db->query("SELECT H.ID_HBP, H.ID_KHP_BARANG, V.ID_VENDOR, V.NAMA_VENDOR
		FROM harga_barang_pemasok AS H
        LEFT JOIN vendor AS V ON V.ID_VENDOR = H.ID_HBP
		WHERE
		H.ID_HBP = '$ID_HBP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_HBP' => $data->ID_HBP,
					'ID_KHP_BARANG' => $data->ID_KHP_BARANG,
					'ID_VENDOR' => $data->ID_VENDOR,
					'NAMA_VENDOR' => $data->NAMA_VENDOR
				);
			}
		} else {
			$hasil = "BELUM ADA NAMA VENDOR";
		}
		return $hasil;
	}

	function hbp_list_by_id_khp_barang($ID_KHP_BARANG){
		$hasil =$this->db->query("SELECT H.ID_HBP, V.ID_VENDOR, H.ID_KHP_BARANG,
		H.HARGA_SATUAN_VENDOR, V.NAMA_VENDOR
		FROM harga_barang_pemasok AS H
        LEFT JOIN vendor AS V ON V.ID_VENDOR = H.ID_VENDOR
		WHERE H.ID_KHP_BARANG='$ID_KHP_BARANG'
		");
		return $hasil->result();
	}

	function cek_id_vendor($ID_KHP_BARANG)
	{
		$hsl = $this->db->query("SELECT ID_VENDOR FROM harga_barang_pemasok
		WHERE  ID_KHP_BARANG='$ID_KHP_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_VENDOR' => $data->ID_VENDOR
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function update_data($ID_KHP_BARANG, $ID_BARANG_MASTER, $JUMLAH_BARANG)
	{
		if ($ID_BARANG_MASTER != null) {
			$hasil = $this->db->query("UPDATE khp_barang SET 
				ID_BARANG_MASTER='$ID_BARANG_MASTER', 
				JUMLAH_BARANG='$JUMLAH_BARANG' 
				WHERE ID_KHP_BARANG='$ID_KHP_BARANG'");
			return $hasil;
		} else {
			$hasil = $this->db->query("UPDATE khp_barang SET 
			JUMLAH_BARANG='$JUMLAH_BARANG' 
			WHERE ID_KHP_BARANG='$ID_KHP_BARANG'");
			return $hasil;
		}
	}

	// SIMPAN DATA BERDASARKAN DATA BARANG MASTER
	// function simpan_data_from_barang_master_by_admin($ID_BARANG_MASTER, $ID_KHP, $JUMLAH_BARANG)
	// {
	// 	$hasil = $this->db->query("INSERT INTO khp_barang (ID_KHP, ID_BARANG_MASTER, JUMLAH_BARANG)VALUES('$ID_KHP', '$ID_BARANG_MASTER', '$JUMLAH_BARANG' )");
	// 	return $hasil;
	// }

	// SIMPAN DATA YANG TIDAK ADA DI BARANG MASTER
	function simpan_data_baru_by_admin($ID_KHP_BARANG, $ID_VENDOR, $HARGA_SATUAN_VENDOR)
	{
		$hasil = $this->db->query("INSERT INTO harga_barang_pemasok (ID_KHP_BARANG, ID_VENDOR, HARGA_SATUAN_VENDOR)VALUES('$ID_KHP_BARANG','$ID_VENDOR','$HARGA_SATUAN_VENDOR')");
		return $hasil;
	}

	/* function log_Rasd_barang($ID_KHP_BARANG, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_Rasd_barang (ID_KHP_BARANG, KETERANGAN, WAKTU) VALUES('$ID_KHP_BARANG', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
}
