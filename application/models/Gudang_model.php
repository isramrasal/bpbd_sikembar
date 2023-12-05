<?php
class Gudang_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan seluruh data gudang
	//SUMBER TABEL: tabel gudang
	//DIPAKAI: 1. controller Gudang / function data_gudang
	//         2. 
	function gudang_list()
	{
		$hasil = $this->db->query("SELECT A.NAMA_GUDANG, A.HASH_MD5_GUDANG, A.LOKASI_GUDANG, B.ID_PROYEK, B.NAMA_PROYEK, B.LOKASI, C.NAMA as PEGAWAI_LOG_GUDANG, A.ID_GUDANG FROM gudang as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK 
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=A.ID_PEGAWAI_LOG_GUDANG");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data gudang berdasarkan ID_GUDANG
	//SUMBER TABEL: tabel gudang
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function gudang_list_by_id_gudang($ID_GUDANG)
	{
		$hasil = $this->db->query("SELECT A.NAMA_GUDANG, A.LOKASI_GUDANG, B.ID_PROYEK, B.NAMA_PROYEK, B.LOKASI, C.NAMA as PEGAWAI_LOG_GUDANG, A.ID_GUDANG FROM gudang as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK 
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=A.ID_PEGAWAI_LOG_GUDANG 
		WHERE A.ID_GUDANG ='$ID_GUDANG'");
		return $hasil;
		//return $hasil->result();
	}

	function gudang_list_by_id_proyek_result($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT A.NAMA_GUDANG, A.HASH_MD5_GUDANG, A.LOKASI_GUDANG, B.ID_PROYEK, B.NAMA_PROYEK, B.LOKASI, C.NAMA as PEGAWAI_LOG_GUDANG, A.ID_GUDANG FROM gudang as A
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK 
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=A.ID_PEGAWAI_LOG_GUDANG 
		WHERE A.ID_PROYEK ='$ID_PROYEK'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data gudang berdasarkan HASH_MD5_GUDANG
	//SUMBER TABEL: tabel gudang
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function get_id_model_by_HASH_MD5_GUDANG($HASH_MD5_GUDANG)
	{
		$hasil = $this->db->query("SELECT A.NAMA_GUDANG, A.HASH_MD5_GUDANG, A.LOKASI_GUDANG, B.ID_PROYEK, B.NAMA_PROYEK, B.LOKASI, C.NAMA as PEGAWAI_LOG_GUDANG, A.ID_GUDANG FROM gudang as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK 
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=A.ID_PEGAWAI_LOG_GUDANG 
		WHERE A.HASH_MD5_GUDANG ='$HASH_MD5_GUDANG'");
		
		$hsl = $this->db->query("SELECT A.NAMA_GUDANG, A.HASH_MD5_GUDANG, A.LOKASI_GUDANG, B.ID_PROYEK, B.NAMA_PROYEK, B.LOKASI, C.NAMA as PEGAWAI_LOG_GUDANG, A.ID_GUDANG FROM gudang as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK 
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=A.ID_PEGAWAI_LOG_GUDANG 
		WHERE A.HASH_MD5_GUDANG ='$HASH_MD5_GUDANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_GUDANG' => $data->HASH_MD5_GUDANG,
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA";
		}
		return $hasil;
		
	}

	function set_md5_ID_GUDANG($ID_PROYEK, $ID_PEGAWAI_LOG_GUDANG, $NAMA_GUDANG, $LOKASI_GUDANG)
	{
		$hsl = $this->db->query("SELECT ID_GUDANG FROM GUDANG WHERE ID_PROYEK='$ID_PROYEK' AND
		ID_PEGAWAI_LOG_GUDANG='$ID_PEGAWAI_LOG_GUDANG' AND NAMA_GUDANG='$NAMA_GUDANG' AND LOKASI_GUDANG='$LOKASI_GUDANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_GUDANG' => $data->ID_GUDANG
				);
			}
		} else {
			$hasil = "BELUM ADA GUDANG";
		}
		$ID_GUDANG = $hasil['ID_GUDANG'];
		$HASH_MD5_GUDANG = md5($ID_GUDANG);
		$hasil = $this->db->query("UPDATE GUDANG SET HASH_MD5_GUDANG='$HASH_MD5_GUDANG' WHERE ID_GUDANG='$ID_GUDANG'");

		return $hasil;
	}

	// function Gudang_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM Gudang WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM Gudang WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menghapus data gudang berdasarkan ID_GUDANG
	//SUMBER TABEL: tabel gudang
	//DIPAKAI: 1. controller Gudang / function hapus_data
	//         2. 
	function hapus_data_by_id_gudang($ID_GUDANG)
	{
		$hasil = $this->db->query("DELETE FROM gudang WHERE ID_GUDANG='$ID_GUDANG'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data gudang berdasarkan ID_GUDANG
	//SUMBER TABEL: tabel gudang
	//DIPAKAI: 1. controller Gudang / function get_data 
	//         2. controller Gudang / function hapus_data
	//         3. controller Gudang / function update_data
	function get_data_by_id_gudang($ID_GUDANG)
	{
		$hsl = $this->db->query("SELECT A.ID_GUDANG, A.NAMA_GUDANG, A.LOKASI_GUDANG, B.ID_PROYEK, B.NAMA_PROYEK, B.LOKASI, C.NAMA as PEGAWAI_LOG_GUDANG, C.ID_PEGAWAI FROM gudang as A LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK LEFT JOIN pegawai as C ON C.ID_PEGAWAI=A.ID_PEGAWAI_LOG_GUDANG WHERE ID_GUDANG='$ID_GUDANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_GUDANG' => $data->ID_GUDANG,
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'LOKASI' => $data->LOKASI,
					'PEGAWAI_LOG_GUDANG' => $data->ID_PEGAWAI,
					'NAMA_GUDANG' => $data->NAMA_GUDANG,
					'LOKASI_GUDANG' => $data->LOKASI_GUDANG
				);
			}
		} else {
			$hasil = "BELUM ADA GUDANG";
		}
		return $hasil;
	}
	// function get_id_proyek_by_id_gudang($ID_GUDANG)
	// {
	// 	$hsl = $this->db->query("SELECT ID_PROYEK  FROM gudang 
	// 	WHERE ID_GUDANG ='$ID_GUDANG'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil =$data->ID_PROYEK;
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA ID PROYEK";
	// 	}
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data gudang berdasarkan NAMA_GUDANG
	//SUMBER TABEL: tabel gudang
	//DIPAKAI: 1. controller Gudang / function simpan_data 
	//         2. controller Gudang / function update_data
	function cek_nama_gudang_by_admin($NAMA_GUDANG)
	{
		$hsl = $this->db->query("SELECT * FROM gudang WHERE NAMA_GUDANG ='$NAMA_GUDANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_GUDANG' => $data->ID_GUDANG,
					'NAMA_GUDANG' => $data->NAMA_GUDANG
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk mengubah data gudang berdasarkan ID_GUDANG2
	//SUMBER TABEL: tabel gudang
	//DIPAKAI: 1. controller Gudang / function update_data
	//         2. 
	function update_data($ID_GUDANG_2, $ID_PEGAWAI_LOG_GUDANG_2, $NAMA_GUDANG_2, $LOKASI_GUDANG_2)
	{
		$hasil = $this->db->query("UPDATE gudang SET 
		NAMA_GUDANG='$NAMA_GUDANG_2', 
		ID_PEGAWAI_LOG_GUDANG ='$ID_PEGAWAI_LOG_GUDANG_2', 
		LOKASI_GUDANG='$LOKASI_GUDANG_2' 
		WHERE ID_GUDANG='$ID_GUDANG_2'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data gudang berdasarkan NAMA_PROYEK
	//SUMBER TABEL: tabel gudang
	//DIPAKAI: 1. controller Gudang / function simpan_data
	//         2. 
	function simpan_data_by_admin($ID_PROYEK, $ID_PEGAWAI_LOG_GUDANG, $NAMA_GUDANG, $LOKASI_GUDANG)
	{
		$hasil = $this->db->query("INSERT INTO gudang (ID_PROYEK, ID_PEGAWAI_LOG_GUDANG, NAMA_GUDANG, LOKASI_GUDANG )VALUES('$ID_PROYEK', '$ID_PEGAWAI_LOG_GUDANG', '$NAMA_GUDANG', '$LOKASI_GUDANG')");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data gudang berdasarkan ID_GUDANG
	//SUMBER TABEL: tabel gudang
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function simpan_data_gudang_barang($ID_BARANG_MASTER, $ID_BARANG_ENTITAS, $ID_GUDANG)
	{
		$hasil = $this->db->query("INSERT INTO gudang_barang (ID_BARANG_MASTER, ID_BARANG_ENTITAS, ID_GUDANG)VALUES('$ID_BARANG_MASTER', '$ID_BARANG_ENTITAS', '$ID_GUDANG')");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data gudang berdasarkan ID_USER
	//SUMBER TABEL: tabel gudang
	//DIPAKAI: 1. controller Gudang / function logout
	//         2. controller Gudang / function user_log
	function user_log_gudang($ID_USER, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO user_log_gudang (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
