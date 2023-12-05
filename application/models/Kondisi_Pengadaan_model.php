<?php
class Kondisi_Pengadaan_model extends CI_Model{

	//FUNGSI: Fungsi ini untuk menampilkan seluruh data TOP
	//SUMBER TABEL: tabel kondisi_pengadaan
	//DIPAKAI: 1. controller kondisi_pengadaan / function data_kondisi_pengadaan
	function kondisi_pengadaan_list()
	{
		$hasil = $this->db->query("SELECT * FROM kondisi_pengadaan");
		return $hasil->result();
	}

	function kondisi_pengadaan_list_by_id_kondisi_pengadaan($ID_KONDISI_PENGADAAN)
	{
		$hasil = $this->db->query("SELECT * FROM kondisi_pengadaan WHERE ID_KONDISI_PENGADAAN = '$ID_KONDISI_PENGADAAN'");
		return $hasil;
	}

	// function set_md5_id_kondisi_pengadaan($NAMA_KONDISI_PENGADAAN)
	// {
	// 	$hsl = $this->db->query("SELECT ID_KONDISI_PENGADAAN FROM kondisi_pengadaan WHERE NAMA_KONDISI_PENGADAAN='$NAMA_KONDISI_PENGADAAN'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_KONDISI_PENGADAAN' => $data->ID_KONDISI_PENGADAAN
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA TERM OF PAYMENT";
	// 	}
	// 	$ID_KONDISI_PENGADAAN = $hasil['ID_KONDISI_PENGADAAN'];
	// 	$HASH_MD5_KONDISI_PENGADAAN = md5($ID_KONDISI_PENGADAAN);
	// 	$this->db->query("UPDATE kondisi_pengadaan SET HASH_MD5_KONDISI_PENGADAAN='$HASH_MD5_KONDISI_PENGADAAN' WHERE ID_KONDISI_PENGADAAN='$ID_KONDISI_PENGADAAN'");
	// }

	// function set_md5_id_kondisi_pengadaan_dari_rfq_form($NAMA_KONDISI_PENGADAAN)
	// {
	// 	$hsl = $this->db->query("SELECT ID_KONDISI_PENGADAAN FROM kondisi_pengadaan WHERE NAMA_KONDISI_PENGADAAN='$NAMA_KONDISI_PENGADAAN'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_KONDISI_PENGADAAN' => $data->ID_KONDISI_PENGADAAN
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA TERM OF PAYMENT";
	// 	}
	// 	$ID_KONDISI_PENGADAAN = $hasil['ID_KONDISI_PENGADAAN'];
	// 	$HASH_MD5_KONDISI_PENGADAAN = md5($ID_KONDISI_PENGADAAN);
	// 	$this->db->query("UPDATE kondisi_pengadaan SET HASH_MD5_KONDISI_PENGADAAN='$HASH_MD5_KONDISI_PENGADAAN' WHERE ID_KONDISI_PENGADAAN='$ID_KONDISI_PENGADAAN'");
	// }

	function set_md5_id_kondisi_pengadaan_dari_po_form($NAMA_KONDISI_PENGADAAN)
	{
		$hsl = $this->db->query("SELECT ID_KONDISI_PENGADAAN FROM kondisi_pengadaan WHERE NAMA_KONDISI_PENGADAAN='$NAMA_KONDISI_PENGADAAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KONDISI_PENGADAAN' => $data->ID_KONDISI_PENGADAAN
				);
			}
		} else {
			$hasil = "BELUM ADA TERM OF PAYMENT";
		}
		$ID_KONDISI_PENGADAAN = $hasil['ID_KONDISI_PENGADAAN'];
		$HASH_MD5_KONDISI_PENGADAAN = md5($ID_KONDISI_PENGADAAN);
		$this->db->query("UPDATE kondisi_pengadaan SET HASH_MD5_KONDISI_PENGADAAN='$HASH_MD5_KONDISI_PENGADAAN' WHERE ID_KONDISI_PENGADAAN='$ID_KONDISI_PENGADAAN'");
	}
	
	// //FUNGSI: Fungsi ini untuk menampilkan data Term of Payment berdasarkan ID_KONDISI_PENGADAAN
	// //SUMBER TABEL: tabel kondisi_pengadaan
	// //DIPAKAI: 1. controller kondisi_pengadaan / function get_data
	// //         2. controller kondisi_pengadaan / function hapus_data
	// //         3. controller kondisi_pengadaan / function update_data
	// function get_data_by_id_kondisi_pengadaan($ID_KONDISI_PENGADAAN)
	// {
	// 	$hsl = $this->db->query("SELECT * FROM kondisi_pengadaan WHERE ID_KONDISI_PENGADAAN='$ID_KONDISI_PENGADAAN'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_KONDISI_PENGADAAN' => $data->ID_KONDISI_PENGADAAN,
	// 				'NAMA_KONDISI_PENGADAAN' => $data->NAMA_KONDISI_PENGADAAN,
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA TERM OF PAYMENT";
	// 	}
	// 	return $hasil;
	// }

	function cek_nama_kondisi_pengadaan($NAMA_KONDISI_PENGADAAN)
	{
		$hsl = $this->db->query("SELECT * FROM kondisi_pengadaan WHERE NAMA_KONDISI_PENGADAAN ='$NAMA_KONDISI_PENGADAAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KONDISI_PENGADAAN' => $data->ID_KONDISI_PENGADAAN,
					'NAMA_KONDISI_PENGADAAN' => $data->NAMA_KONDISI_PENGADAAN,
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	// function simpan_data_kondisi_pengadaan($NAMA_KONDISI_PENGADAAN, $CREATE_BY_USER){
	// 	$hasil=$this->db->query("INSERT INTO kondisi_pengadaan (NAMA_KONDISI_PENGADAAN, CREATE_BY_USER) VALUES ('$NAMA_KONDISI_PENGADAAN', '$CREATE_BY_USER')");
	// 	return $hasil;
	// }

	// function simpan_data_dari_rfq_form($NAMA_KONDISI_PENGADAAN, $CREATE_BY_USER){
	// 	$hasil=$this->db->query("INSERT INTO kondisi_pengadaan (NAMA_KONDISI_PENGADAAN, CREATE_BY_USER) VALUES ('$NAMA_KONDISI_PENGADAAN', '$CREATE_BY_USER')");
	// 	return $hasil;
	// }

	function simpan_data_dari_po_form($NAMA_KONDISI_PENGADAAN, $CREATE_BY_USER){
		$hasil=$this->db->query("INSERT INTO kondisi_pengadaan (NAMA_KONDISI_PENGADAAN, CREATE_BY_USER) VALUES ('$NAMA_KONDISI_PENGADAAN', '$CREATE_BY_USER')");
		return $hasil;
	}

	// function update_data($ID_KONDISI_PENGADAAN, $NAMA_KONDISI_PENGADAAN, $CREATE_BY_USER)
	// {
	// 	$hasil = $this->db->query("UPDATE kondisi_pengadaan SET 
	// 		ID_KONDISI_PENGADAAN='$ID_KONDISI_PENGADAAN',
	// 		NAMA_KONDISI_PENGADAAN='$NAMA_KONDISI_PENGADAAN',
	// 		CREATE_BY_USER='$CREATE_BY_USER'
	// 		WHERE ID_KONDISI_PENGADAAN='$ID_KONDISI_PENGADAAN'");
	// 	return $hasil;
	// }

	// function hapus_data_top($ID_KONDISI_PENGADAAN){
	// 	$hasil=$this->db->query("DELETE FROM kondisi_pengadaan WHERE ID_KONDISI_PENGADAAN='$ID_KONDISI_PENGADAAN'");
	// 	return $hasil;
	// }
}