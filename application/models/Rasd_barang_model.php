<?php
class Rasd_barang_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data RASD
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function rasd_barang_list()
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.KODE_BARANG, M.MEREK, 
		J.NAMA_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
		RB.ID_RASD_BARANG, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, 
		RB.ID_RASD, M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN rasd_barang as RB ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
		");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_RASD_BARANG
	//SUMBER TABEL: tabel
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function rasd_barang_list_by_id_rasd_barang($ID_RASD_BARANG)
	{
		$hasil = $this->db->query("SELECT RB.NAMA, M.KODE_BARANG, RB.MEREK, 
		J.NAMA_JENIS_BARANG, RB.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
		RB.ID_RASD_BARANG, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, 
		RB.ID_RASD, M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG, J.ID_JENIS_BARANG
		FROM rasd_barang as RB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER
		LEFT JOIN jenis_barang as J ON RB.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON RB.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
		WHERE RB.ID_RASD_BARANG ='$ID_RASD_BARANG'");
		return $hasil->row();
		//return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_RASD
	//SUMBER TABEL: tabel (BELUM)
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function rasd_barang_list_by_id_rasd($ID_RASD)
	{
		$hasil = $this->db->query("SELECT
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		RB.ID_RASD,
		RB.ID_RASD_BARANG,
		RB.NAMA,
		RB.MEREK,
		RB.SPESIFIKASI_SINGKAT,
		RB.JUMLAH_BARANG,
		RB.TOTAL_PENGADAAN_SAAT_INI,
		J.NAMA_JENIS_BARANG,
		SB.NAMA_SATUAN_BARANG
	FROM rasd_barang AS RB
	LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER = RB.ID_BARANG_MASTER
	LEFT JOIN jenis_barang AS J	ON  RB.ID_JENIS_BARANG = J.ID_JENIS_BARANG
	LEFT JOIN satuan_barang AS SB ON  RB.ID_SATUAN_BARANG = SB.ID_SATUAN_BARANG
	WHERE
		RB.ID_RASD = '$ID_RASD'");
		// return $hasil;
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_RASD
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller RASD_form / function view_RASD_form
	//         2. controller RASD_form / function index
	function barang_master_list_where_not_in_rasd($ID_RASD)
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.KODE_BARANG, M.MEREK, 
		J.NAMA_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
		M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG, J.ID_JENIS_BARANG
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
        WHERE NOT EXISTS (SELECT ID_BARANG_MASTER 
		FROM rasd_barang 
		WHERE rasd_barang.ID_BARANG_MASTER = M.ID_BARANG_MASTER 
		AND rasd_barang.ID_RASD = '$ID_RASD')");
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

	//FUNGSI: Fungsi ini untuk menghapus data RASD berdasarkan ID_RASD_BARANG
	//SUMBER TABEL: tabel rasd_barang
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function hapus_data_by_id_rasd_barang($ID_RASD_BARANG)
	{
		$hasil = $this->db->query("DELETE FROM rasd_barang WHERE ID_RASD_BARANG='$ID_RASD_BARANG'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_RASD_BARANG
	//SUMBER TABEL: tabel rasd_barang
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. controller (BELUM) / function (BELUM)
	//         3. 
	function get_data_by_id_rasd_barang($ID_RASD_BARANG)
	{
		$hsl = $this->db->query("SELECT
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		RB.ID_RASD,
		RB.ID_RASD_BARANG,
		RB.JUMLAH_BARANG,
		RB.TOTAL_PENGADAAN_SAAT_INI,
		RB.NAMA,
		RB.MEREK,
		RB.SPESIFIKASI_SINGKAT,
		J_M.NAMA_JENIS_BARANG AS JENIS_MASTER,
		J_RASD.NAMA_JENIS_BARANG AS JENIS_RASD,
		RB.ID_JENIS_BARANG,
		RB.ID_SATUAN_BARANG,
		SB_M.NAMA_SATUAN_BARANG AS SATUAN_MASTER,
		SB_RASD.NAMA_SATUAN_BARANG AS SATUAN_RASD
	FROM
		rasd_barang AS RB
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
		RB.ID_RASD_BARANG = '$ID_RASD_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'NAMA_MASTER' => $data->NAMA,
					'KODE_BARANG' => $data->KODE_BARANG,
					'MEREK_MASTER' => $data->MEREK,
					'SS_MASTER' => $data->SPESIFIKASI_SINGKAT,
					'ID_RASD' => $data->ID_RASD,
					'ID_RASD_BARANG' => $data->ID_RASD_BARANG,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'TOTAL_PENGADAAN_SAAT_INI' => $data->TOTAL_PENGADAAN_SAAT_INI,
					'NAMA_RASD' => $data->NAMA,
					'MEREK_RASD' => $data->MEREK,
					'SS_RASD' => $data->SPESIFIKASI_SINGKAT,
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

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan NAMA
	//SUMBER TABEL: tabel rasd_barang
	//DIPAKAI: 1. controller (BELUM) / function simpan_data
	//         2. controller (BELUM) / function update_data
	//         3. 
	function cek_nama_rasd_barang_by_admin($NAMA)
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

	//FUNGSI: Fungsi ini untuk mengubah data RASD berdasarkan ID_RASD_BARANG
	//SUMBER TABEL: tabel rasd_barang
	//DIPAKAI: 1. controller RASD_barang / function update_data
	//         2. 
	function update_data($ID_RASD_BARANG, $ID_BARANG_MASTER, $JUMLAH_BARANG)
	{
		if ($ID_BARANG_MASTER != null) {
			$hasil = $this->db->query("UPDATE rasd_barang SET 
				ID_BARANG_MASTER='$ID_BARANG_MASTER', 
				JUMLAH_BARANG='$JUMLAH_BARANG' 
				WHERE ID_RASD_BARANG='$ID_RASD_BARANG'");
			return $hasil;
		} else {
			$hasil = $this->db->query("UPDATE rasd_barang SET 
			JUMLAH_BARANG='$JUMLAH_BARANG' 
			WHERE ID_RASD_BARANG='$ID_RASD_BARANG'");
			return $hasil;
		}
	}

	// // SIMPAN DATA BERDASARKAN DATA BARANG MASTER
	// function simpan_data_from_barang_master_by_admin($ID_BARANG_MASTER, $ID_RASD, $JUMLAH_BARANG)
	// {
	// 	$hasil = $this->db->query("INSERT INTO rasd_barang (ID_RASD, ID_BARANG_MASTER, JUMLAH_BARANG)VALUES('$ID_RASD', '$ID_BARANG_MASTER', '$JUMLAH_BARANG' )");
	// 	return $hasil;
	// }

	// // SIMPAN DATA YANG TIDAK ADA DI BARANG MASTER
	// function simpan_data_baru_by_admin($ID_RASD, $NAMA, $MEREK, $JENIS_BARANG, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG)
	// {
	// 	$hasil = $this->db->query("INSERT INTO rasd_barang (ID_RASD, NAMA, MEREK, ID_JENIS_BARANG, SPESIFIKASI_SINGKAT, ID_SATUAN_BARANG, JUMLAH_BARANG)VALUES('$ID_RASD', '$NAMA','$MEREK','$JENIS_BARANG','$SPESIFIKASI_SINGKAT','$SATUAN_BARANG', '$JUMLAH_BARANG' )");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menambahkan data RASD berdasarkan ID_BARANG_MASTER
	//SUMBER TABEL: tabel rasd_barang
	//DIPAKAI: 1. controller RASD_barang / function simpan_data
	//         2. controller RASD_barang / function simpan_data_dari_barang_master
	function simpan_data_by_admin(
		$ID_BARANG_MASTER,
		$ID_RASD,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO rasd_barang (
				ID_BARANG_MASTER,
				ID_RASD,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG)VALUES(
					$ID_BARANG_MASTER,
					'$ID_RASD',
					'$ID_SATUAN_BARANG',
					'$ID_JENIS_BARANG',
					'$NAMA',
					'$MEREK',
					'$SPESIFIKASI_SINGKAT',
					'$JUMLAH_BARANG' 
				)");
		return $hasil;
	}

	/* function log_Rasd_barang($ID_RASD_BARANG, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_Rasd_barang (ID_RASD_BARANG, KETERANGAN, WAKTU) VALUES('$ID_RASD_BARANG', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
}
