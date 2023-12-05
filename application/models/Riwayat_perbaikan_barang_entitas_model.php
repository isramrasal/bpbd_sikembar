<?php
class Riwayat_perbaikan_barang_entitas_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh riwayat pemakaian barang entitas
	//SUMBER TABEL: tabel riwayat_perbaikan_b_e
	//DIPAKAI: 1. controller Riwayat_pemakaian_barang / function data_riwayat_perbaikan_barang
	//         2. 
	function riwayat_perbaikan_barang_list($ID_BARANG_ENTITAS)
	{
		$hasil = $this->db->query("SELECT RPBE.ID_R_PERBAIKAN_B_E, RPBE.HASH_MD5_PERBAIKAN, E.ID_BARANG_ENTITAS, M.ID_BARANG_MASTER, M.NAMA, M.MEREK, E.KODE_BARANG_ENTITAS, E.STATUS_KEPEMILIKAN, RPBE.LOKASI_SERVICE, RPBE.KETERANGAN, RPBE.TANGGAL_MULAI_SERVICE_JAM, RPBE.TANGGAL_MULAI_SERVICE_HARI, RPBE.TANGGAL_MULAI_SERVICE_BULAN, RPBE.TANGGAL_MULAI_SERVICE_TAHUN, RPBE.TANGGAL_SELESAI_SERVICE_JAM, RPBE.TANGGAL_SELESAI_SERVICE_HARI, RPBE.TANGGAL_SELESAI_SERVICE_BULAN, RPBE.TANGGAL_SELESAI_SERVICE_TAHUN, RPBE.CREATE_BY_USER
		FROM riwayat_perbaikan_b_e AS RPBE
		LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER=RPBE.ID_BARANG_MASTER
		LEFT JOIN barang_entitas AS E ON E.ID_BARANG_ENTITAS=RPBE.ID_BARANG_ENTITAS
		WHERE E.ID_BARANG_ENTITAS = '$ID_BARANG_ENTITAS'");
		return $hasil->result();
	}

	function set_md5_id_riwayat($ID_BARANG_ENTITAS, $ID_BARANG_MASTER, $LOKASI_SERVICE, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT ID_R_PERBAIKAN_B_E  FROM riwayat_perbaikan_b_e WHERE ID_BARANG_ENTITAS='$ID_BARANG_ENTITAS' AND
		ID_BARANG_MASTER='$ID_BARANG_MASTER' AND LOKASI_SERVICE='$LOKASI_SERVICE' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_R_PERBAIKAN_B_E' => $data->ID_R_PERBAIKAN_B_E
				);
			}
		} else {
			$hasil = "BELUM ADA RIWAYAT";
		}
		$ID_R_PERBAIKAN_B_E = $hasil['ID_R_PERBAIKAN_B_E'];
		$HASH_MD5_PERBAIKAN = md5($ID_R_PERBAIKAN_B_E);
		$hasil = $this->db->query("UPDATE riwayat_perbaikan_b_e SET HASH_MD5_PERBAIKAN='$HASH_MD5_PERBAIKAN' WHERE ID_R_PERBAIKAN_B_E='$ID_R_PERBAIKAN_B_E'");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data riwayat perbaikan barang entitas berdasarkan HASH_MD5_BARANG_ENTITAS
	//SUMBER TABEL: tabel riwayat_perbaikan_b_e
	//DIPAKAI: 1. controller Riwayat_perbaikan_barang / function data_riwayat_perbaikan_barang_entitas
	//         2. controller Riwayat_perbaikan_barang / function item
	function riwayat_perbaikan_barang_entitas_list_by_HASH_MD5_BARANG_ENTITAS($HASH_MD5_BARANG_ENTITAS)
	{
		$hasil = $this->db->query("SELECT BM.ID_BARANG_MASTER, BE.ID_BARANG_ENTITAS, LOKASI_SERVICE, 
		KETERANGAN, TANGGAL_MULAI_SERVICE_HARI, TANGGAL_SELESAI_SERVICE_HARI, BM.NAMA AS NAMA_BARANG,
		BM.MEREK, BE.KODE_BARANG_ENTITAS, BE.STATUS_KEPEMILIKAN, BE.JENIS_KEPEMILIKAN, ID_R_PERBAIKAN_B_E, BE.HASH_MD5_BARANG_ENTITAS
		FROM riwayat_perbaikan_b_e AS E
		LEFT JOIN barang_master AS BM ON BM.ID_BARANG_MASTER = E.ID_BARANG_MASTER
		LEFT JOIN barang_entitas AS BE ON BE.ID_BARANG_ENTITAS = E.ID_BARANG_ENTITAS
		WHERE BE.HASH_MD5_BARANG_ENTITAS = '$HASH_MD5_BARANG_ENTITAS'");
		return $hasil->result();
	}

	function kepemilikan()
	{
		$hasil = $this->db->query("SELECT STATUS_KEPEMILIKAN, JENIS_KEPEMILIKAN FROM barang_entitas");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data riwayat perbaikan barang entitas berdasarkan HASH_MD5_BARANG_ENTITAS
	//SUMBER TABEL: tabel riwayat_perbaikan_b_e
	//DIPAKAI: 1. controller Riwayat_perbaikan_barang / function item
	//         2. 
	function get_data_riwayat_perbaikan_barang_entitas_list_by_HASH_MD5_BARANG_ENTITAS($HASH_MD5_BARANG_ENTITAS)
	{
		$hsl = $this->db->query("SELECT BM.ID_BARANG_MASTER, BE.ID_BARANG_ENTITAS, E.LOKASI_SERVICE, 
		E.KETERANGAN, E.TANGGAL_MULAI_SERVICE_HARI, E.TANGGAL_SELESAI_SERVICE_HARI, BM.NAMA AS NAMA_BARANG,
		BM.MEREK, BE.KODE_BARANG_ENTITAS, BE.STATUS_KEPEMILIKAN, BE.JENIS_KEPEMILIKAN, E.ID_R_PERBAIKAN_B_E, BE.HASH_MD5_BARANG_ENTITAS
		FROM riwayat_perbaikan_b_e AS E
		LEFT JOIN barang_master AS BM ON BM.ID_BARANG_MASTER = E.ID_BARANG_MASTER
		LEFT JOIN barang_entitas AS BE ON BE.ID_BARANG_ENTITAS = E.ID_BARANG_ENTITAS
		WHERE BE.HASH_MD5_BARANG_ENTITAS = '$HASH_MD5_BARANG_ENTITAS'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'ID_BARANG_ENTITAS' => $data->ID_BARANG_ENTITAS,
					'LOKASI_SERVICE' => $data->LOKASI_SERVICE,
					'KETERANGAN' => $data->KETERANGAN,
					'TANGGAL_MULAI_SERVICE_HARI' => $data->TANGGAL_MULAI_SERVICE_HARI,
					'TANGGAL_SELESAI_SERVICE_HARI' => $data->TANGGAL_SELESAI_SERVICE_HARI,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'KODE_BARANG_ENTITAS' => $data->KODE_BARANG_ENTITAS,
					'STATUS_KEPEMILIKAN' => $data->STATUS_KEPEMILIKAN,
					'JENIS_KEPEMILIKAN' => $data->JENIS_KEPEMILIKAN,
					'ID_R_PERBAIKAN_B_E' => $data->ID_R_PERBAIKAN_B_E,
					'HASH_MD5_BARANG_ENTITAS' => $data->HASH_MD5_BARANG_ENTITAS
				);
			}
		} else {
			$hasil = "BELUM ADA RIWAYAT PERBAIKAN BARANG";
		}
		return $hasil;
	}

	function get_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER)
	{
		$hsl = $this->db->query("SELECT M.ID_BARANG_MASTER, J.ID_JENIS_BARANG, S.ID_SATUAN_BARANG, J.NAMA_JENIS_BARANG, 
		M.KODE_BARANG, M.NAMA, M.PERALATAN_PERLENGKAPAN, M.GROSS_WEIGHT, M.NETT_WEIGHT, M.DIMENSI_PANJANG, M.DIMENSI_LEBAR, 
		M.DIMENSI_TINGGI, M.SPESIFIKASI_LENGKAP, M.SPESIFIKASI_SINGKAT, M.CARA_SINGKAT_PENGGUNAAN, M.CARA_PENYIMPANAN_BARANG, 
		 M.MASA_PAKAI, M.ALIAS, M.MEREK, M.HASH_MD5_BARANG_MASTER, S.NAMA_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON J.ID_JENIS_BARANG=M.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as S ON S.ID_SATUAN_BARANG=M.ID_SATUAN_BARANG
		WHERE M.HASH_MD5_BARANG_MASTER = '$HASH_MD5_BARANG_MASTER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'NAMA' => $data->NAMA,
					'ALIAS' => $data->ALIAS,
					'MEREK' => $data->MEREK,
					'JENIS_BARANG' => $data->ID_JENIS_BARANG,
					'NAMA_SATUAN_BARANG' => $data->ID_SATUAN_BARANG,
					'GROSS_WEIGHT' => $data->GROSS_WEIGHT,
					'NETT_WEIGHT' => $data->NETT_WEIGHT,
					'KODE_BARANG' => $data->KODE_BARANG,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'DIMENSI_PANJANG' => $data->DIMENSI_PANJANG,
					'DIMENSI_LEBAR' => $data->DIMENSI_LEBAR,
					'DIMENSI_TINGGI' => $data->DIMENSI_TINGGI,
					'SPESIFIKASI_LENGKAP' => $data->SPESIFIKASI_LENGKAP,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'CARA_SINGKAT_PENGGUNAAN' => $data->CARA_SINGKAT_PENGGUNAAN,
					'CARA_PENYIMPANAN_BARANG' => $data->CARA_PENYIMPANAN_BARANG,
					'MASA_PAKAI' => $data->MASA_PAKAI
				);
			}
		} else {
			$hasil = "BELUM ADA BARANG MASTER";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data riwayat pemakaian barang berdasarkan ID_RIWAYAT_PERBAIKAN_BARANG
	//SUMBER TABEL: tabel riwayat_perbaikan_barang
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function riwayat_perbaikan_barang_list_by_id_riwayat_perbaikan_barang($ID_RIWAYAT_PERBAIKAN_BARANG)
	{
		$hasil = $this->db->query("SELECT * FROM riwayat_perbaikan_barang WHERE ID_RIWAYAT_PERBAIKAN_BARANG ='$ID_RIWAYAT_PERBAIKAN_BARANG'");
		return $hasil;
		//return $hasil->result();
	}

	// function riwayat_perbaikan_barang_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM riwayat_perbaikan_barang WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM riwayat_perbaikan_barang WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menghapus data riwayat pemakaian barang berdasarkan ID_RIWAYAT_PERBAIKAN_BARANG
	//SUMBER TABEL: tabel riwayat_perbaikan_barang
	//DIPAKAI: 1. controller Riwayat_perbaikan_barang / function hapus_data
	//         2. 
	function hapus_data_by_id_riwayat_perbaikan_barang($ID_RIWAYAT_PERBAIKAN_BARANG)
	{
		$hasil = $this->db->query("DELETE FROM riwayat_perbaikan_barang WHERE ID_RIWAYAT_PERBAIKAN_BARANG='$ID_RIWAYAT_PERBAIKAN_BARANG'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data riwayat pemakaian barang berdasarkan ID_RIWAYAT_PERBAIKAN_BARANG
	//SUMBER TABEL: tabel riwayat_perbaikan_barang
	//DIPAKAI: 1. controller Riwayat_perbaikan_barang / function get_data
	//         2. controller Riwayat_perbaikan_barang / function hapus_data
	//         3. controller Riwayat_perbaikan_barang / function update_data
	function get_data_by_id_riwayat_perbaikan_barang($ID_RIWAYAT_PERBAIKAN_BARANG)
	{
		$hsl = $this->db->query("SELECT * FROM riwayat_perbaikan_barang WHERE ID_RIWAYAT_PERBAIKAN_BARANG='$ID_RIWAYAT_PERBAIKAN_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RIWAYAT_PERBAIKAN_BARANG' => $data->ID_RIWAYAT_PERBAIKAN_BARANG,
					'NAMA_RIWAYAT_PERBAIKAN_BARANG' => $data->NAMA_RIWAYAT_PERBAIKAN_BARANG,
					'ALAMAT_RIWAYAT_PERBAIKAN_BARANG' => $data->ALAMAT_RIWAYAT_PERBAIKAN_BARANG,
					'NO_TELP_RIWAYAT_PERBAIKAN_BARANG' => $data->NO_TELP_RIWAYAT_PERBAIKAN_BARANG,
					'NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG' => $data->NAMA_PIC_RIWAYAT_PERBAIKAN_BARANG,
					'NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG' => $data->NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG,
					'EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG' => $data->EMAIL_PIC_RIWAYAT_PERBAIKAN_BARANG,
					'NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG' => $data->NO_HP_PIC_RIWAYAT_PERBAIKAN_BARANG,
					'EMAIL_RIWAYAT_PERBAIKAN_BARANG' => $data->EMAIL_RIWAYAT_PERBAIKAN_BARANG,
					'DOK_NPWP' => $data->DOK_NPWP,
					'DOK_SIUP' => $data->DOK_SIUP,
					'DOK_AKTA' => $data->DOK_AKTA,
					'DOK_LAP_KEU' => $data->DOK_LAP_KEU,
					'DOK_LAINNYA' => $data->DOK_LAINNYA
				);
			}
		} else {
			$hasil = "BELUM ADA RIWAYAT_PERBAIKAN_BARANG";
		}
		return $hasil;
	}

	function get_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E)
	{
		$hsl = $this->db->query("SELECT RPBE.ID_R_PERBAIKAN_B_E, RPBE.HASH_MD5_PERBAIKAN, E.ID_BARANG_ENTITAS, E.KODE_BARANG_ENTITAS, M.ID_BARANG_MASTER, M.NAMA, M.MEREK, E.KODE_BARANG_ENTITAS, E.STATUS_KEPEMILIKAN, RPBE.LOKASI_SERVICE, RPBE.KETERANGAN, RPBE.TANGGAL_MULAI_SERVICE_JAM, RPBE.TANGGAL_MULAI_SERVICE_HARI, RPBE.TANGGAL_MULAI_SERVICE_BULAN, RPBE.TANGGAL_MULAI_SERVICE_TAHUN, RPBE.TANGGAL_SELESAI_SERVICE_JAM, RPBE.TANGGAL_SELESAI_SERVICE_HARI, RPBE.TANGGAL_SELESAI_SERVICE_BULAN, RPBE.TANGGAL_SELESAI_SERVICE_TAHUN, RPBE.CREATE_BY_USER
		FROM riwayat_perbaikan_b_e AS RPBE
		LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER=RPBE.ID_BARANG_MASTER
		LEFT JOIN barang_entitas AS E ON E.ID_BARANG_ENTITAS=RPBE.ID_BARANG_ENTITAS
		WHERE RPBE.ID_R_PERBAIKAN_B_E = '$ID_R_PERBAIKAN_B_E'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_R_PERBAIKAN_B_E' => $data->ID_R_PERBAIKAN_B_E,
					'HASH_MD5_PERBAIKAN' => $data->HASH_MD5_PERBAIKAN,
					'ID_BARANG_ENTITAS' => $data->ID_BARANG_ENTITAS,
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'NAMA' => $data->NAMA,
					'MEREK' => $data->MEREK,
					'KODE_BARANG_ENTITAS' => $data->KODE_BARANG_ENTITAS,
					'STATUS_KEPEMILIKAN' => $data->STATUS_KEPEMILIKAN,
					'LOKASI_SERVICE' => $data->LOKASI_SERVICE,
					'KETERANGAN' => $data->KETERANGAN,
					'TANGGAL_MULAI_SERVICE_JAM' => $data->TANGGAL_MULAI_SERVICE_JAM,
					'TANGGAL_MULAI_SERVICE_HARI' => $data->TANGGAL_MULAI_SERVICE_HARI,
					'TANGGAL_MULAI_SERVICE_BULAN' => $data->TANGGAL_MULAI_SERVICE_BULAN,
					'TANGGAL_MULAI_SERVICE_TAHUN' => $data->TANGGAL_MULAI_SERVICE_TAHUN,
					'TANGGAL_SELESAI_SERVICE_JAM' => $data->TANGGAL_SELESAI_SERVICE_JAM,
					'TANGGAL_SELESAI_SERVICE_HARI' => $data->TANGGAL_SELESAI_SERVICE_HARI,
					'TANGGAL_SELESAI_SERVICE_BULAN' => $data->TANGGAL_SELESAI_SERVICE_BULAN,
					'TANGGAL_SELESAI_SERVICE_TAHUN' => $data->TANGGAL_SELESAI_SERVICE_TAHUN,
					'CREATE_BY_USER' => $data->CREATE_BY_USER,
				);
			}
		} else {
			$hasil = "BELUM ADA RIWAYAT PERBAIKAN BARANG";
		}
		return $hasil;
	}

	function hapus_data_by_id_riwayat_perbaikan_barang_entitas($ID_R_PERBAIKAN_B_E)
	{
		$hasil = $this->db->query("DELETE FROM riwayat_perbaikan_b_e WHERE ID_R_PERBAIKAN_B_E='$ID_R_PERBAIKAN_B_E'");
		return $hasil;
	}

	

	//FUNGSI: Fungsi ini untuk menampilkan data riwayat pemakaian barang berdasarkan NAMA_RIWAYAT_PERBAIKAN_BARANG
	//SUMBER TABEL: tabel riwayat_perbaikan_barang
	//DIPAKAI: 1. controller Riwayat_perbaikan_barang / function simpan_data
	//         2. controller Riwayat_perbaikan_barang / function update_data
	function cek_nama_riwayat_perbaikan_barang_by_admin($NAMA_RIWAYAT_PERBAIKAN_BARANG)
	{
		$hsl = $this->db->query("SELECT * FROM riwayat_perbaikan_barang WHERE NAMA_RIWAYAT_PERBAIKAN_BARANG ='$NAMA_RIWAYAT_PERBAIKAN_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RIWAYAT_PERBAIKAN_BARANG' => $data->ID_RIWAYAT_PERBAIKAN_BARANG,
					'NAMA_RIWAYAT_PERBAIKAN_BARANG' => $data->NAMA_RIWAYAT_PERBAIKAN_BARANG
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk mengubah data riwayat pemakaian barang berdasarkan ID_RIWAYAT_PERBAIKAN_BARANG2
	//SUMBER TABEL: tabel riwayat_perbaikan_barang
	//DIPAKAI: 1. controller Riwayat_perbaikan_barang / function update_data
	//         2. 
	function update_data($ID_R_PERBAIKAN_B_E, $LOKASI_SERVICE, $KETERANGAN, $TANGGAL_MULAI_SERVICE_HARI, $TANGGAL_SELESAI_SERVICE_HARI) {
		$hasil = $this->db->query("UPDATE riwayat_perbaikan_b_e SET 
			LOKASI_SERVICE = '$LOKASI_SERVICE',
			KETERANGAN = '$KETERANGAN',
			TANGGAL_MULAI_SERVICE_HARI = '$TANGGAL_MULAI_SERVICE_HARI',
			TANGGAL_SELESAI_SERVICE_HARI = '$TANGGAL_SELESAI_SERVICE_HARI'
			WHERE ID_R_PERBAIKAN_B_E='$ID_R_PERBAIKAN_B_E'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data riwayat pemakaian barang berdasarkan NAMA_RIWAYAT_PERBAIKAN_BARANG
	//SUMBER TABEL: tabel riwayat_perbaikan_barang
	//DIPAKAI: 1. controller Riwayat_perbaikan_barang / function simpan_data
	//         2. 
	function simpan_data(
		$ID_BARANG_MASTER,
		$ID_BARANG_ENTITAS,
		$LOKASI_SERVICE,
		$KETERANGAN,
		$TANGGAL_MULAI_SERVICE_HARI,
		$TANGGAL_SELESAI_SERVICE_HARI,
		$CREATE_BY_USER
	) {
		$hasil = $this->db->query(
			"INSERT INTO riwayat_perbaikan_b_e
			(
				ID_BARANG_MASTER,
				ID_BARANG_ENTITAS,
                LOKASI_SERVICE,
                KETERANGAN,
                TANGGAL_MULAI_SERVICE_HARI,
                TANGGAL_SELESAI_SERVICE_HARI,
				CREATE_BY_USER
			)
			VALUES
			(
				'$ID_BARANG_MASTER',
				'$ID_BARANG_ENTITAS',
                '$LOKASI_SERVICE',
                '$KETERANGAN',
                '$TANGGAL_MULAI_SERVICE_HARI',
                '$TANGGAL_SELESAI_SERVICE_HARI',
				'$CREATE_BY_USER'
			)"
		);
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data riwayat pemakaian barang berdasarkan ID_USER
	//SUMBER TABEL: tabel user_log_riwayat_perbaikan_b_e
	//DIPAKAI: 1. controller Riwayat_perbaikan_barang / function logout
	//         2. controller Riwayat_perbaikan_barang / function user_log
	function user_log_riwayat_perbaikan_b_e($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_riwayat_perbaikan_b_e (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
