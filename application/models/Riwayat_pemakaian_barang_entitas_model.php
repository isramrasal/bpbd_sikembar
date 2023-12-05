<?php
class Riwayat_pemakaian_barang_entitas_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh riwayat pemakaian barang entitas
	//SUMBER TABEL: tabel riwayat_pemakaian_b_e
	//DIPAKAI: 1. controller Riwayat_pemakaian_barang / function data_riwayat_pemakaian_barang
	//         2. 
	function riwayat_pemakaian_barang_entitas_list()
	{
		$hasil = $this->db->query("SELECT P.ID_PEGAWAI, PR.ID_PROYEK, BM.ID_BARANG_MASTER, 
		BE.ID_BARANG_ENTITAS, DEPARTEMEN, KETERANGAN, TANGGAL_MULAI_PEMAKAIAN_HARI, 
		TANGGAL_SELESAI_PEMAKAIAN_HARI, P.NAMA AS NAMA_PEGAWAI, PR.NAMA_PROYEK, 
		BM.NAMA AS NAMA_BARANG, BM.MEREK, BE.KODE_BARANG_ENTITAS, BE.STATUS_KEPEMILIKAN, 
		BE.JENIS_KEPEMILIKAN, ID_R_PEMAKAIAN_B_E, BE.HASH_MD5_BARANG_ENTITAS FROM riwayat_pemakaian_b_e AS E
		LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = E.ID_PEGAWAI
		LEFT JOIN proyek AS PR ON PR.ID_PROYEK = E.ID_PROYEK
		LEFT JOIN barang_master AS BM ON BM.ID_BARANG_MASTER = E.ID_BARANG_MASTER
		LEFT JOIN barang_entitas AS BE ON BE.ID_BARANG_ENTITAS = E.ID_BARANG_ENTITAS");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data riwayat pemakaian barang entitas berdasarkan HASH_MD5_BARANG_ENTITAS
	//SUMBER TABEL: tabel riwayat_pemakaian_b_e
	//DIPAKAI: 1. controller Riwayat_pemakaian_barang / function data_riwayat_pemakaian_barang_entitas
	//         2. controller Riwayat_pemakaian_barang / function item
	function riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_BARANG_ENTITAS($HASH_MD5_BARANG_ENTITAS)
	{
		$hasil = $this->db->query("SELECT P.ID_PEGAWAI, PR.ID_PROYEK, BM.ID_BARANG_MASTER, 
		BE.ID_BARANG_ENTITAS, DEPARTEMEN, KETERANGAN, TANGGAL_MULAI_PEMAKAIAN_HARI, 
		TANGGAL_SELESAI_PEMAKAIAN_HARI, P.NAMA AS NAMA_PEGAWAI, PR.NAMA_PROYEK, 
		BM.NAMA AS NAMA_BARANG, BM.MEREK, BE.KODE_BARANG_ENTITAS, BE.STATUS_KEPEMILIKAN, 
		BE.JENIS_KEPEMILIKAN, ID_R_PEMAKAIAN_B_E, BE.HASH_MD5_BARANG_ENTITAS, E.HASH_MD5_RIWAYAT FROM riwayat_pemakaian_b_e AS E
		LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = E.ID_PEGAWAI
		LEFT JOIN proyek AS PR ON PR.ID_PROYEK = E.ID_PROYEK
		LEFT JOIN barang_master AS BM ON BM.ID_BARANG_MASTER = E.ID_BARANG_MASTER
		LEFT JOIN barang_entitas AS BE ON BE.ID_BARANG_ENTITAS = E.ID_BARANG_ENTITAS
		WHERE BE.HASH_MD5_BARANG_ENTITAS = '$HASH_MD5_BARANG_ENTITAS'");
		return $hasil->result();
	}

	function riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_RIWAYAT($HASH_MD5_RIWAYAT)
	{
		$hasil = $this->db->query("SELECT ID_R_PEMAKAIAN_B_E, ID_PEGAWAI, ID_PROYEK, ID_BARANG_MASTER, ID_BARANG_ENTITAS, DEPARTEMEN, KETERANGAN, NAMA_PEGAWAI, NAMA_PROYEK, TANGGAL_MULAI_PEMAKAIAN_HARI, TANGGAL_SELESAI_PEMAKAIAN_HARI
		FROM riwayat_pemakaian_b_e");
		return $hasil->result();
	}
	//FUNGSI: Fungsi ini untuk menampilkan data riwayat pemakaian barang entitas berdasarkan HASH_MD5_BARANG_ENTITAS
	//SUMBER TABEL: tabel riwayat_pemakaian_b_e
	//DIPAKAI: 1. controller Riwayat_pemakaian_barang / function item
	//         2. 
	function get_data_riwayat_pemakaian_barang_entitas_list_by_HASH_MD5_BARANG_ENTITAS($HASH_MD5_BARANG_ENTITAS)
	{
		$hsl = $this->db->query("SELECT P.ID_PEGAWAI, PR.ID_PROYEK, BM.ID_BARANG_MASTER, 
		BE.ID_BARANG_ENTITAS, DEPARTEMEN, KETERANGAN, TANGGAL_MULAI_PEMAKAIAN_HARI, 
		TANGGAL_SELESAI_PEMAKAIAN_HARI, P.NAMA AS NAMA_PEGAWAI, PR.NAMA_PROYEK, 
		BM.NAMA AS NAMA_BARANG, BM.MEREK, BE.KODE_BARANG_ENTITAS, BE.STATUS_KEPEMILIKAN, 
		BE.JENIS_KEPEMILIKAN, ID_R_PEMAKAIAN_B_E, BE.HASH_MD5_BARANG_ENTITAS FROM riwayat_pemakaian_b_e AS E
		LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = E.ID_PEGAWAI
		LEFT JOIN proyek AS PR ON PR.ID_PROYEK = E.ID_PROYEK
		LEFT JOIN barang_master AS BM ON BM.ID_BARANG_MASTER = E.ID_BARANG_MASTER
		LEFT JOIN barang_entitas AS BE ON BE.ID_BARANG_ENTITAS = E.ID_BARANG_ENTITAS
		WHERE BE.HASH_MD5_BARANG_ENTITAS = '$HASH_MD5_BARANG_ENTITAS'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PEGAWAI' => $data->ID_PEGAWAI,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'ID_BARANG_ENTITAS' => $data->ID_BARANG_ENTITAS,
					'DEPARTEMEN' => $data->DEPARTEMEN,
					'KETERANGAN' => $data->KETERANGAN,
					'TANGGAL_MULAI_PEMAKAIAN_HARI' => $data->TANGGAL_MULAI_PEMAKAIAN_HARI,
					'TANGGAL_SELESAI_PEMAKAIAN_HARI' => $data->TANGGAL_SELESAI_PEMAKAIAN_HARI,
					'NAMA_PEGAWAI' => $data->NAMA_PEGAWAI,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'KODE_BARANG_ENTITAS' => $data->KODE_BARANG_ENTITAS,
					'STATUS_KEPEMILIKAN' => $data->STATUS_KEPEMILIKAN,
					'JENIS_KEPEMILIKAN' => $data->JENIS_KEPEMILIKAN,
					'ID_R_PEMAKAIAN_B_E' => $data->ID_R_PEMAKAIAN_B_E,
					'HASH_MD5_BARANG_ENTITAS' => $data->HASH_MD5_BARANG_ENTITAS
				);
			}
		} else {
			$hasil = "BELUM ADA RIWAYAT PEMAKAIAN BARANG";
		}
		return $hasil;
	}

	function get_data_riwayat_pemakaian_barang_entitas_list_id_riwayat($ID_R_PEMAKAIAN_B_E)
	{
		$hsl = $this->db->query("SELECT 
		-- P.ID_PEGAWAI, PR.ID_PROYEK, 
		-- BM.ID_BARANG_MASTER, 
		-- BE.ID_BARANG_ENTITAS, 
		E.DEPARTEMEN, E.KETERANGAN, E.TANGGAL_MULAI_PEMAKAIAN_HARI, E.TANGGAL_SELESAI_PEMAKAIAN_HARI, E.NAMA_PEGAWAI, E.NAMA_PROYEK
		-- P.NAMA AS NAMA_PEGAWAI, PR.NAMA_PROYEK, 
		-- BM.NAMA AS NAMA_BARANG, BM.MEREK, BE.KODE_BARANG_ENTITAS, BE.STATUS_KEPEMILIKAN, 
		-- BE.JENIS_KEPEMILIKAN, ID_R_PEMAKAIAN_B_E, BE.HASH_MD5_BARANG_ENTITAS 
		FROM riwayat_pemakaian_b_e AS E
		-- LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = E.ID_PEGAWAI
		-- LEFT JOIN proyek AS PR ON PR.ID_PROYEK = E.ID_PROYEK
		-- LEFT JOIN barang_master AS BM ON BM.ID_BARANG_MASTER = E.ID_BARANG_MASTER
		-- LEFT JOIN barang_entitas AS BE ON BE.ID_BARANG_ENTITAS = E.ID_BARANG_ENTITAS
		WHERE E.ID_R_PEMAKAIAN_B_E = '$ID_R_PEMAKAIAN_B_E'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					// 'ID_PEGAWAI' => $data->ID_PEGAWAI,
					// 'ID_PROYEK' => $data->ID_PROYEK,
					// 'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					// 'ID_BARANG_ENTITAS' => $data->ID_BARANG_ENTITAS,
					'DEPARTEMEN' => $data->DEPARTEMEN,
					'KETERANGAN' => $data->KETERANGAN,
					'TANGGAL_MULAI_PEMAKAIAN_HARI' => $data->TANGGAL_MULAI_PEMAKAIAN_HARI,
					'TANGGAL_SELESAI_PEMAKAIAN_HARI' => $data->TANGGAL_SELESAI_PEMAKAIAN_HARI,
					'NAMA_PEGAWAI' => $data->NAMA_PEGAWAI,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					// 'MEREK' => $data->MEREK,
					// 'KODE_BARANG_ENTITAS' => $data->KODE_BARANG_ENTITAS,
					// 'STATUS_KEPEMILIKAN' => $data->STATUS_KEPEMILIKAN,
					// 'JENIS_KEPEMILIKAN' => $data->JENIS_KEPEMILIKAN,
					'ID_R_PEMAKAIAN_B_E' => $data->ID_R_PEMAKAIAN_B_E
					// 'HASH_MD5_BARANG_ENTITAS' => $data->HASH_MD5_BARANG_ENTITAS
				);
			}
		} else {
			$hasil = "BELUM ADA RIWAYAT PEMAKAIAN BARANG";
		}
		return $hasil;
	}

	function get_data_riwayat_baru($HASH_MD5_RIWAYAT, $ID_R_PEMAKAIAN_B_E, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT * FROM riwayat_pemakaian_b_e WHERE HASH_MD5_RIWAYAT = '$HASH_MD5_RIWAYAT' AND
		ID_R_PEMAKAIAN_B_E= '$ID_R_PEMAKAIAN_B_E' AND
		CREATE_BY_USER = '$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_RIWAYAT' => $data->HASH_MD5_RIWAYAT
				);
			}
		} else {
			$hasil = "BELUM ADA RPB";
		}
		return $hasil;
	}

	function hapus_data_by_id_riwayat($ID_R_PEMAKAIAN_B_E)
	{
		$hasil = $this->db->query("DELETE FROM riwayat_pemakaian_b_e WHERE ID_R_PEMAKAIAN_B_E='$ID_R_PEMAKAIAN_B_E'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data riwayat pemakaian barang entitas berdasarkan ID_RIWAYAT_PEMAKAIAN_BARANG
	//SUMBER TABEL: tabel riwayat_pemakaian_barang
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function riwayat_pemakaian_barang_list_by_id_riwayat_pemakaian_barang($ID_RIWAYAT_PEMAKAIAN_BARANG)
	{
		$hasil = $this->db->query("SELECT * FROM riwayat_pemakaian_barang WHERE ID_RIWAYAT_PEMAKAIAN_BARANG ='$ID_RIWAYAT_PEMAKAIAN_BARANG'");
		return $hasil;
		//return $hasil->result();
	}

	// function riwayat_pemakaian_barang_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM riwayat_pemakaian_barang WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM riwayat_pemakaian_barang WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menghapus data riwayat pemakaian barang entitas berdasarkan ID_RIWAYAT_PEMAKAIAN_BARANG
	//SUMBER TABEL: tabel riwayat_pemakaian_barang
	//DIPAKAI: 1. controller Riwayat_pemakaian_barang / function hapus_data
	//         2. 
	function hapus_data_by_id_riwayat_pemakaian_barang($ID_RIWAYAT_PEMAKAIAN_BARANG)
	{
		$hasil = $this->db->query("DELETE FROM riwayat_pemakaian_barang WHERE ID_RIWAYAT_PEMAKAIAN_BARANG='$ID_RIWAYAT_PEMAKAIAN_BARANG'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menghapus data riwayat pemakaian barang entitas berdasarkan ID_RIWAYAT_PEMAKAIAN_BARANG
	//SUMBER TABEL: tabel riwayat_pemakaian_barang
	//DIPAKAI: 1. controller Riwayat_pemakaian_barang / function get_data
	//         2. controller Riwayat_pemakaian_barang / function hapus_data
	//         3. controller Riwayat_pemakaian_barang / function update_data
	function get_data_by_id_riwayat_pemakaian_barang($ID_R_PEMAKAIAN_B_E)
	{
		$hsl = $this->db->query("SELECT * FROM riwayat_pemakaian_b_e WHERE ID_R_PEMAKAIAN_B_E='$ID_R_PEMAKAIAN_B_E'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_R_PEMAKAIAN_B_E' => $data->ID_R_PEMAKAIAN_B_E,
					'DEPARTEMEN' => $data->DEPARTEMEN,
					'KETERANGAN' => $data->KETERANGAN,
					'NAMA_PEGAWAI' => $data->NAMA_PEGAWAI,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'TANGGAL_MULAI_PEMAKAIAN_HARI' => $data->TANGGAL_MULAI_PEMAKAIAN_HARI,
					'TANGGAL_SELESAI_PEMAKAIAN_HARI' => $data->TANGGAL_SELESAI_PEMAKAIAN_HARI
				);
			}
		} else {
			$hasil = "BELUM ADA RIWAYAT PEMAKAIAN BARANG";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data riwayat pemakaian barang entitas berdasarkan NAMA_RIWAYAT_PEMAKAIAN_BARANG
	//SUMBER TABEL: tabel riwayat_pemakaian_barang
	//DIPAKAI: 1. controller Riwayat_pemakaian_barang / function simpan_data
	//         2. controller Riwayat_pemakaian_barang / function update_data
	function cek_nama_riwayat_pemakaian_barang_by_admin($NAMA_RIWAYAT_PEMAKAIAN_BARANG)
	{
		$hsl = $this->db->query("SELECT * FROM riwayat_pemakaian_barang WHERE NAMA_RIWAYAT_PEMAKAIAN_BARANG ='$NAMA_RIWAYAT_PEMAKAIAN_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RIWAYAT_PEMAKAIAN_BARANG' => $data->ID_RIWAYAT_PEMAKAIAN_BARANG,
					'NAMA_RIWAYAT_PEMAKAIAN_BARANG' => $data->NAMA_RIWAYAT_PEMAKAIAN_BARANG
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function cek_riwayat_pemakaian_barang_by_id($ID_BARANG_ENTITAS)
	{
		$hsl = $this->db->query("SELECT ID_BARANG_ENTITAS FROM riwayat_pemakaian_b_e WHERE ID_BARANG_ENTITAS ='$ID_BARANG_ENTITAS'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_ENTITAS' => $data->ID_BARANG_ENTITAS
				);
			}
			return $hasil;
		} else {
			return 'DATA BELUM ADA';
		}
	}

	//FUNGSI: Fungsi ini untuk mengubah data riwayat pemakaian barang entitas berdasarkan ID_RIWAYAT_PEMAKAIAN_BARANG2
	//SUMBER TABEL: tabel riwayat_pemakaian_barang
	//DIPAKAI: 1. controller Riwayat_pemakaian_barang / function update_data
	//         2. 
	function update_dat($ID_RIWAYAT_PEMAKAIAN_BARANG2, $NAMA_RIWAYAT_PEMAKAIAN_BARANG2, $ALAMAT_RIWAYAT_PEMAKAIAN_BARANG2, $NO_TELP_RIWAYAT_PEMAKAIAN_BARANG2, $NAMA_PIC_RIWAYAT_PEMAKAIAN_BARANG2, $NO_HP_PIC_RIWAYAT_PEMAKAIAN_BARANG2, $EMAIL_PIC_RIWAYAT_PEMAKAIAN_BARANG2, $EMAIL_RIWAYAT_PEMAKAIAN_BARANG2)
	{
		$hasil = $this->db->query("UPDATE riwayat_pemakaian_barang SET NAMA_RIWAYAT_PEMAKAIAN_BARANG='$NAMA_RIWAYAT_PEMAKAIAN_BARANG2', ALAMAT_RIWAYAT_PEMAKAIAN_BARANG='$ALAMAT_RIWAYAT_PEMAKAIAN_BARANG2', NO_TELP_RIWAYAT_PEMAKAIAN_BARANG='$NO_TELP_RIWAYAT_PEMAKAIAN_BARANG2', NAMA_PIC_RIWAYAT_PEMAKAIAN_BARANG='$NAMA_PIC_RIWAYAT_PEMAKAIAN_BARANG2', NO_HP_PIC_RIWAYAT_PEMAKAIAN_BARANG='$NO_HP_PIC_RIWAYAT_PEMAKAIAN_BARANG2', EMAIL_PIC_RIWAYAT_PEMAKAIAN_BARANG='$EMAIL_PIC_RIWAYAT_PEMAKAIAN_BARANG2', EMAIL_RIWAYAT_PEMAKAIAN_BARANG='$EMAIL_RIWAYAT_PEMAKAIAN_BARANG2' WHERE ID_RIWAYAT_PEMAKAIAN_BARANG='$ID_RIWAYAT_PEMAKAIAN_BARANG2'");
		return $hasil;
	}

	function update_data($ID_R_PEMAKAIAN_B_E, $NAMA_PEGAWAI, $NAMA_PROYEK, $DEPARTEMEN, $KETERANGAN, $TANGGAL_MULAI_PEMAKAIAN_HARI, $TANGGAL_SELESAI_PEMAKAIAN_HARI)
	{
		$hasil = $this->db->query("UPDATE riwayat_pemakaian_b_e SET 
			NAMA_PEGAWAI='$NAMA_PEGAWAI',
			NAMA_PROYEK='$NAMA_PROYEK',
			DEPARTEMEN='$DEPARTEMEN',
			KETERANGAN='$KETERANGAN',
			TANGGAL_MULAI_PEMAKAIAN_HARI='$TANGGAL_MULAI_PEMAKAIAN_HARI',
			TANGGAL_SELESAI_PEMAKAIAN_HARI='$TANGGAL_SELESAI_PEMAKAIAN_HARI'
			WHERE ID_R_PEMAKAIAN_B_E='$ID_R_PEMAKAIAN_B_E'");
		return $hasil;
	}

	function set_md5_id_riwayat($KETERANGAN, $DEPARTEMEN, $NAMA_PROYEK, $NAMA_PEGAWAI, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT ID_R_PEMAKAIAN_B_E FROM riwayat_pemakaian_b_e WHERE KETERANGAN='$KETERANGAN' AND
		DEPARTEMEN='$DEPARTEMEN' AND NAMA_PROYEK='$NAMA_PROYEK' AND NAMA_PEGAWAI='$NAMA_PEGAWAI' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_R_PEMAKAIAN_B_E' => $data->ID_R_PEMAKAIAN_B_E
				);
			}
		} else {
			$hasil = "BELUM ADA RPB";
		}
		$ID_R_PEMAKAIAN_B_E = $hasil['ID_R_PEMAKAIAN_B_E'];
		$HASH_MD5_RIWAYAT = md5($ID_R_PEMAKAIAN_B_E);
		$hasil = $this->db->query("UPDATE riwayat_pemakaian_b_e SET HASH_MD5_RIWAYAT='$HASH_MD5_RIWAYAT' WHERE ID_R_PEMAKAIAN_B_E='$ID_R_PEMAKAIAN_B_E'");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data riwayat pemakaian barang entitas berdasarkan NAMA_RIWAYAT_PEMAKAIAN_BARANG
	//SUMBER TABEL: tabel riwayat_pemakaian_barang
	//DIPAKAI: 1. controller Riwayat_pemakaian_barang / function simpan_data
	//         2. 
	function simpan_data_by_admin($NAMA_RIWAYAT_PEMAKAIAN_BARANG, $ALAMAT_RIWAYAT_PEMAKAIAN_BARANG, $NO_TELP_RIWAYAT_PEMAKAIAN_BARANG, $NAMA_PIC_RIWAYAT_PEMAKAIAN_BARANG, $NO_HP_PIC_RIWAYAT_PEMAKAIAN_BARANG, $EMAIL_PIC_RIWAYAT_PEMAKAIAN_BARANG, $EMAIL_RIWAYAT_PEMAKAIAN_BARANG)
	{
		$hasil = $this->db->query("INSERT INTO riwayat_pemakaian_barang (NAMA_RIWAYAT_PEMAKAIAN_BARANG, ALAMAT_RIWAYAT_PEMAKAIAN_BARANG, NO_TELP_RIWAYAT_PEMAKAIAN_BARANG, NAMA_PIC_RIWAYAT_PEMAKAIAN_BARANG, NO_HP_PIC_RIWAYAT_PEMAKAIAN_BARANG, EMAIL_PIC_RIWAYAT_PEMAKAIAN_BARANG, EMAIL_RIWAYAT_PEMAKAIAN_BARANG)VALUES('$NAMA_RIWAYAT_PEMAKAIAN_BARANG', '$ALAMAT_RIWAYAT_PEMAKAIAN_BARANG', '$NO_TELP_RIWAYAT_PEMAKAIAN_BARANG', '$NAMA_PIC_RIWAYAT_PEMAKAIAN_BARANG', '$NO_HP_PIC_RIWAYAT_PEMAKAIAN_BARANG', '$EMAIL_PIC_RIWAYAT_PEMAKAIAN_BARANG', '$EMAIL_RIWAYAT_PEMAKAIAN_BARANG')");
		return $hasil;
	}

	function simpan_data_riwayat(
		$ID_PROYEK,
        $ID_PEGAWAI,
        $ID_BARANG_MASTER,
        $ID_BARANG_ENTITAS,
        $NAMA_PEGAWAI,
        $NAMA_PROYEK,
        $DEPARTEMEN,
        $KETERANGAN,
        $TANGGAL_MULAI_PEMAKAIAN_HARI,
        $TANGGAL_SELESAI_PEMAKAIAN_HARI,
		$CREATE_BY_USER
	) {
		$hasil = $this->db->query(
			"INSERT INTO riwayat_pemakaian_b_e
			(
				ID_PROYEK,
                ID_PEGAWAI,
                ID_BARANG_MASTER,
                ID_BARANG_ENTITAS,
                NAMA_PEGAWAI,
                NAMA_PROYEK,
                DEPARTEMEN,
                KETERANGAN,
                TANGGAL_MULAI_PEMAKAIAN_HARI,
                TANGGAL_SELESAI_PEMAKAIAN_HARI,
				CREATE_BY_USER
			)
			VALUES
			(
				'$ID_PROYEK',
                '$ID_PEGAWAI',
                '$ID_BARANG_MASTER',
                '$ID_BARANG_ENTITAS',
                '$NAMA_PEGAWAI',
                '$NAMA_PROYEK',
                '$DEPARTEMEN',
                '$KETERANGAN',
                '$TANGGAL_MULAI_PEMAKAIAN_HARI',
                '$TANGGAL_SELESAI_PEMAKAIAN_HARI',
				'$CREATE_BY_USER'
				
			)"
		);


		return $hasil;
	}

	// function get_data_riwayat_baruu($ID_PEGAWAI, $ID_BARANG_ENTITAS, $CREATE_BY_USER)
	// {
	// 	$hsl = $this->db->query("SELECT * FROM riwayat_pemakaian_b_e WHERE ID_PEGAWAI = '$ID_PEGAWAI' AND
	// 	ID_BARANG_ENTITAS= '$ID_BARANG_ENTITAS' AND
	// 	CREATE_BY_USER = '$CREATE_BY_USER'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'HASH_MD5_RENCANA_PENGIRIMAN_BARANG' => $data->HASH_MD5_RENCANA_PENGIRIMAN_BARANG
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA RPB";
	// 	}
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menambahkan data riwayat pemakaian barang berdasarkan ID_USER
	//SUMBER TABEL: tabel user_log_riwayat_pemakaian_b_e
	//DIPAKAI: 1. controller Riwayat_perbaikan_barang / function logout
	//         2. controller Riwayat_perbaikan_barang / function user_log
	function user_log_riwayat_pemakaian_b_e($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_riwayat_pemakaian_b_e (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
