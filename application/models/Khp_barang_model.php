<?php
class Khp_barang_model extends CI_Model
{

	function khp_barang_list()
	{
		$hasil = $this->db->query("SELECT KB.ID_KHP_BARANG, SB.ID_SPPB_BARANG, K.ID_KHP, 
		H.ID_HBP, KB.KEPUTUSAN_HARGA_SATUAN, KB.KEPUTUSAN_DELIVERY, KB.KEPUTUSAN_VENDOR, 
		KB.KETERANGAN_KHP_BARANG_STAFF_PROC, KB.KETERANGAN_KHP_BARANG_KASIE, 
		KB.KETERANGAN_KHP_BARANG_M_PROC, KB.JUMLAH_ITEM_BARANG
		FROM sppb_barang AS SB
		LEFT JOIN khp_barang AS KB ON SB.ID_SPPB_BARANG = KB.ID_SPPB_BARANG
		LEFT JOIN komparasi_harga_pemasok AS K ON SB.ID_KHP = K.ID_KHP
		LEFT JOIN harga_barang_pemasok AS H ON SB.ID_HBP = H.ID_HBP
		");
		return $hasil->result();
	}


	function khp_barang_list_by_id_khp_barang($ID_KHP_BARANG)
	{
		$hasil = $this->db->query("SELECT KB.ID_KHP_BARANG, SB.ID_SPPB_BARANG, K.ID_KHP, 
		H.ID_HBP, KB.KEPUTUSAN_HARGA_SATUAN, KB.KEPUTUSAN_DELIVERY, KB.KEPUTUSAN_VENDOR, 
		KB.KETERANGAN_KHP_BARANG_STAFF_PROC, KB.KETERANGAN_KHP_BARANG_KASIE, 
		KB.KETERANGAN_KHP_BARANG_M_PROC, KB.JUMLAH_ITEM_BARANG
		FROM sppb_barang AS SB
		LEFT JOIN khp_barang AS KB ON SB.ID_SPPB_BARANG = KB.ID_SPPB_BARANG
		LEFT JOIN komparasi_harga_pemasok AS K ON SB.ID_KHP = K.ID_KHP
		LEFT JOIN harga_barang_pemasok AS H ON SB.ID_HBP = H.ID_HBP
		WHERE KB.ID_KHP_BARANG ='$ID_KHP_BARANG'");
		return $hasil;
		//return $hasil->result();
	}

	function get_data_sppb_barang_by_id_khp_barang_for_hbp($ID_KHP_BARANG)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, J.ID_JENIS_BARANG, 
		ST.ID_SATUAN_BARANG, KB.ID_KHP_BARANG, SB.ID_SPPB_BARANG, 
		SB.NAMA_BARANG, SB.MEREK, SB.JUMLAH_MINTA, SB.SPESIFIKASI_SINGKAT, 
		ST.NAMA_SATUAN_BARANG, J.NAMA_JENIS_BARANG, M.KODE_BARANG
		FROM khp_barang AS KB 
		
		LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER = (SELECT ID_BARANG_MASTER FROM sppb_barang WHERE ID_SPPB_BARANG = KB.ID_SPPB_BARANG)
		LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = (SELECT ID_JENIS_BARANG FROM sppb_barang WHERE ID_SPPB_BARANG = KB.ID_SPPB_BARANG)
		LEFT JOIN satuan_barang AS ST ON ST.ID_SATUAN_BARANG = (SELECT ID_SATUAN_BARANG FROM sppb_barang WHERE ID_SPPB_BARANG = KB.ID_SPPB_BARANG)
		LEFT JOIN sppb_barang AS SB ON SB.ID_SPPB_BARANG = KB.ID_SPPB_BARANG
		
		WHERE KB.ID_KHP_BARANG = '$ID_KHP_BARANG'");
		return $hasil;
	}

	function khp_barang_list_by_id_khp($ID_KHP)
	{
		$hasil = $this->db->query("SELECT
		KB.ID_KHP_BARANG,
		SB.ID_SPPB_BARANG,
		K.ID_KHP,
		H.ID_HBP,
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		SB.NAMA_BARANG,
		SB.MEREK,
		SB.SPESIFIKASI_SINGKAT,
		SB.JUMLAH_MINTA, SB.JUMLAH_SETUJU_TERAKHIR,
		SB.ID_JENIS_BARANG, ST.NAMA_SATUAN_BARANG,
		SB.ID_SATUAN_BARANG, JB.NAMA_JENIS_BARANG,
		RB.ID_RASD_BARANG,
		RB.JUMLAH_BARANG AS JUMLAH_RASD
	FROM
		khp_barang AS KB
	LEFT JOIN barang_master AS M
	ON
		M.ID_BARANG_MASTER =(
		SELECT
			ID_BARANG_MASTER
		FROM
			sppb_barang
		WHERE
			ID_SPPB_BARANG = KB.ID_SPPB_BARANG
	)
	LEFT JOIN sppb_barang AS SB
	ON
		KB.ID_SPPB_BARANG = SB.ID_SPPB_BARANG
	LEFT JOIN rasd_barang AS RB
	ON
		RB.ID_RASD_BARANG =(
		SELECT
			ID_RASD_BARANG
		FROM
			sppb_barang
		WHERE
			ID_SPPB_BARANG = KB.ID_SPPB_BARANG
	)
	LEFT JOIN komparasi_harga_pemasok AS K
	ON
		SB.ID_KHP = K.ID_KHP
	LEFT JOIN harga_barang_pemasok AS H
	ON
		SB.ID_HBP = H.ID_HBP
	LEFT JOIN satuan_barang AS ST
	ON
		ST.ID_SATUAN_BARANG =(
		SELECT
			ID_SATUAN_BARANG
		FROM
			sppb_barang
		WHERE
			ID_SPPB_BARANG = KB.ID_SPPB_BARANG
	)
	LEFT JOIN jenis_barang AS JB
	ON
		JB.ID_JENIS_BARANG =(
		SELECT
			ID_JENIS_BARANG
		FROM
			sppb_barang
		WHERE
			ID_SPPB_BARANG = KB.ID_SPPB_BARANG
	)
	WHERE
		KB.ID_KHP = '$ID_KHP'");
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

	function hapus_data_by_id_khp_barang($ID_KHP_BARANG)
	{
		$hasil = $this->db->query("DELETE FROM khp_barang WHERE ID_KHP_BARANG='$ID_KHP_BARANG'");
		return $hasil;
	}

	function get_data_by_id_khp_barang($ID_KHP_BARANG)
	{
		$hsl = $this->db->query("SELECT
		M.ID_BARANG_MASTER,
		M.NAMA AS NAMA_MASTER,
		M.KODE_BARANG,
		M.MEREK AS MEREK_MASTER,
		M.SPESIFIKASI_SINGKAT AS SS_MASTER,
		RB.ID_KHP,
		RB.ID_KHP_BARANG,
		RB.JUMLAH_BARANG,
		RB.TOTAL_PENGADAAN_SAAT_INI,
		RB.NAMA AS NAMA_RASD,
		RB.MEREK AS MEREK_RASD,
		RB.SPESIFIKASI_SINGKAT AS SS_RASD,
		J_M.NAMA_JENIS_BARANG AS JENIS_MASTER,
		J_RASD.NAMA_JENIS_BARANG AS JENIS_RASD,
		SB_M.NAMA_SATUAN_BARANG AS SATUAN_MASTER,
		SB_RASD.NAMA_SATUAN_BARANG AS SATUAN_RASD
		FROM
			khp_barang AS RB
		LEFT JOIN barang_master AS M
		ON
			M.ID_BARANG_MASTER = RB.ID_BARANG_MASTER
		LEFT JOIN jenis_barang AS J_M
		ON
			M.ID_JENIS_BARANG = J_M.ID_JENIS_BARANG
		LEFT JOIN jenis_barang AS J_RASD
		ON
			RB.ID_JENIS_BARANG = J_RASD.ID_JENIS_BARANG
		LEFT JOIN satuan_barang AS SB_M
		ON
			M.ID_SATUAN_BARANG = SB_M.ID_SATUAN_BARANG
		LEFT JOIN satuan_barang AS SB_RASD
		ON
			RB.ID_SATUAN_BARANG = SB_RASD.ID_SATUAN_BARANG
		WHERE
		RB.ID_KHP_BARANG = '$ID_KHP_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'NAMA_MASTER' => $data->NAMA_MASTER,
					'KODE_BARANG' => $data->KODE_BARANG,
					'MEREK_MASTER' => $data->MEREK_MASTER,
					'SS_MASTER' => $data->SS_MASTER,
					'ID_KHP' => $data->ID_KHP,
					'ID_KHP_BARANG' => $data->ID_KHP_BARANG,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'TOTAL_PENGADAAN_SAAT_INI' => $data->TOTAL_PENGADAAN_SAAT_INI,
					'NAMA_RASD' => $data->NAMA_RASD,
					'MEREK_RASD' => $data->MEREK_RASD,
					'SS_RASD' => $data->SS_RASD,
					'JENIS_MASTER' => $data->JENIS_MASTER,
					'JENIS_RASD' => $data->JENIS_RASD,
					'SATUAN_MASTER' => $data->SATUAN_MASTER,
					'SATUAN_RASD' => $data->SATUAN_RASD,
				);
			}
		} else {
			$hasil = "BELUM ADA RASD_BARANG";
		}
		return $hasil;
	}

	function cek_nama_khp_barang_by_admin($NAMA)
	{
		$hsl = $this->db->query("SELECT ID_BARANG_MASTER, NAMA FROM barang_master WHERE NAMA ='$NAMA'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'NAMA' => $data->NAMA
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function update_data($ID_HBP, $ID_KHP_BARANG)
	{
		$hasil = $this->db->query("UPDATE khp_barang SET 
				ID_HBP='$ID_HBP' 
				WHERE ID_KHP_BARANG='$ID_KHP_BARANG'");
		return $hasil;
	}

	/* function log_Rasd_barang($ID_KHP_BARANG, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_Rasd_barang (ID_KHP_BARANG, KETERANGAN, WAKTU) VALUES('$ID_KHP_BARANG', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
}
