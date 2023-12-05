<?php
class Gudang_barang_model extends CI_Model
{

	function gudang_barang_list()
	{
		$hasil = $this->db->query("SELECT GB.TANGGAL_KADALUARSA_HARI, GB.NORMAL as JUMLAH_ITEM, BE.KODE_BARANG_ENTITAS, JB.NAMA_JENIS_BARANG, BM.NAMA, BM.MEREK, SB.NAMA_SATUAN_BARANG, BE.HASH_MD5_BARANG_ENTITAS FROM Gudang_barang as GB 
		LEFT JOIN barang_entitas as BE ON BE.ID_BARANG_ENTITAS = GB.ID_BARANG_ENTITAS  
		LEFT JOIN barang_master as BM ON BM.ID_BARANG_MASTER = GB.ID_BARANG_MASTER 
        LEFT JOIN jenis_barang as JB ON JB.ID_JENIS_BARANG = BM.ID_JENIS_BARANG
        LEFT JOIN satuan_barang as SB ON SB.ID_SATUAN_BARANG = BM.ID_SATUAN_BARANG");
		return $hasil->result();
	}

	function gudang_barang_list_by_ID_GUDANG($ID_GUDANG)
	{
		$hasil = $this->db->query("SELECT GB.TANGGAL_KADALUARSA_HARI, GB.NORMAL as JUMLAH_ITEM, BE.JUMLAH_BARANG, BE.KONDISI, BE.KODE_BARANG_ENTITAS, JB.NAMA_JENIS_BARANG, BM.NAMA, BM.MEREK, BM.HASH_MD5_BARANG_MASTER, SB.NAMA_SATUAN_BARANG, BE.HASH_MD5_BARANG_ENTITAS FROM Gudang_barang as GB
		LEFT JOIN barang_entitas as BE ON BE.ID_BARANG_ENTITAS = GB.ID_BARANG_ENTITAS  
		LEFT JOIN barang_master as BM ON BM.ID_BARANG_MASTER = GB.ID_BARANG_MASTER 
        LEFT JOIN jenis_barang as JB ON JB.ID_JENIS_BARANG = BM.ID_JENIS_BARANG
        LEFT JOIN satuan_barang as SB ON SB.ID_SATUAN_BARANG = BM.ID_SATUAN_BARANG
 		WHERE GB.ID_GUDANG = '$ID_GUDANG'");
		return $hasil->result();
	}

	function Gudang_barang_list_by_id_Gudang_barang($ID_Gudang_barang)
	{
		$hasil = $this->db->query("SELECT A.NAMA_Gudang_barang, A.LOKASI_Gudang_barang, B.ID_PROYEK, B.NAMA_PROYEK, B.LOKASI, C.NAMA as PEGAWAI_LOG_Gudang_barang, A.ID_Gudang_barang FROM Gudang_barang as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK 
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=A.ID_PEGAWAI_LOG_Gudang_barang 
		WHERE A.ID_Gudang_barang ='$ID_Gudang_barang'");
		return $hasil;
		//return $hasil->result();
	}

	function get_id_gudang_by_HASH_MD5_GUDANG($HASH_MD5_GUDANG)
	{
		$hsl = $this->db->query("SELECT * FROM gudang WHERE HASH_MD5_GUDANG ='$HASH_MD5_GUDANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_GUDANG' => $data->ID_GUDANG,
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_GUDANG' => $data->NAMA_GUDANG,
					'LOKASI_GUDANG' => $data->LOKASI_GUDANG,
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA";
		}
		return $hasil;
	}

	// function Gudang_barang_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM Gudang_barang WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM Gudang_barang WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }

	function hapus_data_by_id_Gudang_barang($ID_Gudang_barang)
	{
		$hasil = $this->db->query("DELETE FROM Gudang_barang WHERE ID_Gudang_barang='$ID_Gudang_barang'");
		return $hasil;
	}

	function hapus_data_by_ID_BARANG_ENTITAS($ID_BARANG_ENTITAS)
	{
		$hasil = $this->db->query("DELETE FROM Gudang_barang WHERE ID_BARANG_ENTITAS='$ID_BARANG_ENTITAS'");
		return $hasil;
	}

	function get_data_by_id_Gudang_barang($ID_Gudang_barang)
	{
		$hsl = $this->db->query("SELECT A.ID_Gudang_barang, A.NAMA_Gudang_barang, A.LOKASI_Gudang_barang, B.ID_PROYEK, B.NAMA_PROYEK, B.LOKASI, C.NAMA as PEGAWAI_LOG_Gudang_barang, C.ID_PEGAWAI FROM Gudang_barang as A LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK LEFT JOIN pegawai as C ON C.ID_PEGAWAI=A.ID_PEGAWAI_LOG_Gudang_barang WHERE ID_Gudang_barang='$ID_Gudang_barang'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_Gudang_barang' => $data->ID_Gudang_barang,
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'LOKASI' => $data->LOKASI,
					'PEGAWAI_LOG_Gudang_barang' => $data->ID_PEGAWAI,
					'NAMA_Gudang_barang' => $data->NAMA_Gudang_barang,
					'LOKASI_Gudang_barang' => $data->LOKASI_Gudang_barang
				);
			}
		} else {
			$hasil = "BELUM ADA Gudang_barang";
		}
		return $hasil;
	}

	// function get_id_proyek_by_id_Gudang_barang($ID_Gudang_barang)
	// {
	// 	$hsl = $this->db->query("SELECT ID_PROYEK  FROM Gudang_barang 
	// 	WHERE ID_Gudang_barang ='$ID_Gudang_barang'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil =$data->ID_PROYEK;
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA ID PROYEK";
	// 	}
	// 	return $hasil;
	// }

	function cek_nama_Gudang_barang_by_admin($NAMA_Gudang_barang)
	{
		$hsl = $this->db->query("SELECT * FROM Gudang_barang WHERE NAMA_Gudang_barang ='$NAMA_Gudang_barang'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_Gudang_barang' => $data->ID_Gudang_barang,
					'NAMA_Gudang_barang' => $data->NAMA_Gudang_barang
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function update_data($ID_Gudang_barang2, $PEGAWAI_LOG_Gudang_barang2, $NAMA_Gudang_barang2, $LOKASI_Gudang_barang2)
	{
		$hasil = $this->db->query("UPDATE Gudang_barang SET 
		NAMA_Gudang_barang='$NAMA_Gudang_barang2', 
		ID_PEGAWAI_LOG_Gudang_barang ='$PEGAWAI_LOG_Gudang_barang2', 
		LOKASI_Gudang_barang='$LOKASI_Gudang_barang2' 
		WHERE ID_Gudang_barang='$ID_Gudang_barang2'");
		return $hasil;
	}

	function simpan_data_by_admin($NAMA_PROYEK, $PEGAWAI_LOG_Gudang_barang, $NAMA_Gudang_barang, $LOKASI_Gudang_barang)
	{
		$hasil = $this->db->query("INSERT INTO Gudang_barang (ID_PROYEK, ID_PEGAWAI_LOG_Gudang_barang, NAMA_Gudang_barang, LOKASI_Gudang_barang )VALUES('$NAMA_PROYEK', '$PEGAWAI_LOG_Gudang_barang', '$NAMA_Gudang_barang', '$LOKASI_Gudang_barang')");
		return $hasil;
	}

	function simpan_data_Gudang_barang_barang_by_admin($ID_Gudang_barang, $ID_BARANG_MASTER, $ID_BARANG_ENTITAS, $NORMAL, $RUSAK, $DIPAKAI, $BELUM_DIPAKAI)
	{
		$hasil = $this->db->query("INSERT INTO Gudang_barang_barang (ID_Gudang_barang, ID_BARANG_MASTER, ID_BARANG_ENTITAS, NORMAL, RUSAK, DIPAKAI, BELUM_DIPAKAI)VALUES('$ID_Gudang_barang', '$ID_BARANG_MASTER', '$ID_BARANG_ENTITAS', '$NORMAL', '$RUSAK', '$DIPAKAI', '$BELUM_DIPAKAI')");
		return $hasil;
	}

	function user_log_gudang_barang($ID_USER, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO user_log_gudang_barang (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
