<?php
class Barang_master_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh barang master
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function data_barang_master
	//         2. NAMA_JENIS_BARANG
	function barang_master_list()
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, J.ID_JENIS_BARANG, S.ID_SATUAN_BARANG, J.NAMA_JENIS_BARANG, 
		M.KODE_BARANG, M.NAMA, M.PERALATAN_PERLENGKAPAN, M.GROSS_WEIGHT, M.NETT_WEIGHT, M.DIMENSI_PANJANG, M.DIMENSI_LEBAR, 
		M.DIMENSI_TINGGI, M.SPESIFIKASI_LENGKAP, M.SPESIFIKASI_SINGKAT, M.CARA_SINGKAT_PENGGUNAAN, M.CARA_PENYIMPANAN_BARANG, 
		 M.MASA_PAKAI, M.ALIAS, M.MEREK, M.HASH_MD5_BARANG_MASTER, S.NAMA_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON J.ID_JENIS_BARANG=M.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as S ON S.ID_SATUAN_BARANG=M.ID_SATUAN_BARANG");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang master berdasarkan ID_BARANG_MASTER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller FPB_form / function simpan_data_dari_barang_master
	//         2. 
	function barang_master_list_by_id_barang_master($ID_BARANG_MASTER)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, J.ID_JENIS_BARANG, S.ID_SATUAN_BARANG, J.NAMA_JENIS_BARANG, 
		M.KODE_BARANG, M.NAMA, M.PERALATAN_PERLENGKAPAN, M.GROSS_WEIGHT, M.NETT_WEIGHT, M.DIMENSI_PANJANG, M.DIMENSI_LEBAR, 
		M.DIMENSI_TINGGI, M.SPESIFIKASI_LENGKAP, M.SPESIFIKASI_SINGKAT, M.CARA_SINGKAT_PENGGUNAAN, M.CARA_PENYIMPANAN_BARANG, 
		 M.MASA_PAKAI, M.ALIAS, M.MEREK,  M.HASH_MD5_BARANG_MASTER, S.NAMA_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON J.ID_JENIS_BARANG=M.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as S ON S.ID_SATUAN_BARANG=M.ID_SATUAN_BARANG
		WHERE M.ID_BARANG_MASTER = '$ID_BARANG_MASTER'");
		return $hasil->row();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang master HASH_MD5_BARANG_MASTER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function profil_barang_master
	//         2. 
	function barang_master_list_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, J.ID_JENIS_BARANG, S.ID_SATUAN_BARANG, J.NAMA_JENIS_BARANG, 
		M.KODE_BARANG, M.NAMA, M.PERALATAN_PERLENGKAPAN, M.GROSS_WEIGHT, M.NETT_WEIGHT, M.DIMENSI_PANJANG, M.DIMENSI_LEBAR, 
		M.DIMENSI_TINGGI, M.SPESIFIKASI_LENGKAP, M.SPESIFIKASI_SINGKAT, M.CARA_SINGKAT_PENGGUNAAN, M.CARA_PENYIMPANAN_BARANG, 
		 M.MASA_PAKAI, M.ALIAS, M.MEREK,  M.HASH_MD5_BARANG_MASTER, S.NAMA_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON J.ID_JENIS_BARANG=M.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as S ON S.ID_SATUAN_BARANG=M.ID_SATUAN_BARANG
		WHERE M.HASH_MD5_BARANG_MASTER = '$HASH_MD5_BARANG_MASTER'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang master berdasarkan HASH_MD5_BARANG_MASTER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function profil_barang_master
	//         2. 
	function barang_master_list_by_HASH_MD5_BARANG_MASTER_result($HASH_MD5_BARANG_MASTER)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, J.ID_JENIS_BARANG, S.ID_SATUAN_BARANG, J.NAMA_JENIS_BARANG, 
		M.KODE_BARANG, M.NAMA, M.PERALATAN_PERLENGKAPAN, M.GROSS_WEIGHT, M.NETT_WEIGHT, M.DIMENSI_PANJANG, M.DIMENSI_LEBAR, 
		M.DIMENSI_TINGGI, M.SPESIFIKASI_LENGKAP, M.SPESIFIKASI_SINGKAT, M.CARA_SINGKAT_PENGGUNAAN, M.CARA_PENYIMPANAN_BARANG, 
		 M.MASA_PAKAI, M.ALIAS, M.MEREK,  M.HASH_MD5_BARANG_MASTER, S.NAMA_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON J.ID_JENIS_BARANG=M.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as S ON S.ID_SATUAN_BARANG=M.ID_SATUAN_BARANG
		WHERE M.HASH_MD5_BARANG_MASTER = '$HASH_MD5_BARANG_MASTER'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang master berdasarkan HASH_MD5_BARANG_MASTER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function profil_barang_master
	//         2. 
	function barang_master_list_by_HASH_MD5_BARANG_ENTITAS_result($HASH_MD5_BARANG_ENTITAS)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, J.ID_JENIS_BARANG, S.ID_SATUAN_BARANG, J.NAMA_JENIS_BARANG, 
		M.KODE_BARANG, M.NAMA, M.PERALATAN_PERLENGKAPAN, M.GROSS_WEIGHT, M.NETT_WEIGHT, M.DIMENSI_PANJANG, M.DIMENSI_LEBAR, 
		M.DIMENSI_TINGGI, M.SPESIFIKASI_LENGKAP, M.SPESIFIKASI_SINGKAT, M.CARA_SINGKAT_PENGGUNAAN, M.CARA_PENYIMPANAN_BARANG, 
		 M.MASA_PAKAI, M.ALIAS, M.MEREK,  M.HASH_MD5_BARANG_MASTER, S.NAMA_SATUAN_BARANG, BE.STATUS_KEPEMILIKAN, BE.ID_BARANG_ENTITAS
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON J.ID_JENIS_BARANG=M.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as S ON S.ID_SATUAN_BARANG=M.ID_SATUAN_BARANG
        LEFT JOIN barang_entitas AS BE ON BE.ID_BARANG_MASTER = M.ID_BARANG_MASTER
		WHERE BE.HASH_MD5_BARANG_ENTITAS = '$HASH_MD5_BARANG_ENTITAS'");
		return $hasil->result();
	}
	
	//FUNGSI: Fungsi ini untuk menghapus data barang master berdasarkan HASH_MD5_BARANG_MASTER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function hapus_data
	//         2. 
	function hapus_data_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER)
	{
		$hasil = $this->db->query("DELETE FROM barang_master WHERE HASH_MD5_BARANG_MASTER='$HASH_MD5_BARANG_MASTER'");
		return $hasil;
	}

	
	//FUNGSI: Fungsi ini untuk menampilkan data barang master berdasarkan ID_BARANG_MASTER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function update_data
	//         2. 
	function get_data_by_id_barang_master($ID_BARANG_MASTER)
	{
		$hsl = $this->db->query("SELECT M.ID_BARANG_MASTER, J.ID_JENIS_BARANG, S.ID_SATUAN_BARANG, J.NAMA_JENIS_BARANG, 
		M.KODE_BARANG, M.NAMA, M.PERALATAN_PERLENGKAPAN, M.GROSS_WEIGHT, M.NETT_WEIGHT, M.DIMENSI_PANJANG, M.DIMENSI_LEBAR, 
		M.DIMENSI_TINGGI, M.SPESIFIKASI_LENGKAP, M.SPESIFIKASI_SINGKAT, M.CARA_SINGKAT_PENGGUNAAN, M.CARA_PENYIMPANAN_BARANG, 
		 M.MASA_PAKAI, M.ALIAS, M.MEREK, S.NAMA_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON J.ID_JENIS_BARANG=M.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as S ON S.ID_SATUAN_BARANG=M.ID_SATUAN_BARANG
		WHERE M.ID_BARANG_MASTER = '$ID_BARANG_MASTER'");
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

	//FUNGSI: Fungsi ini untuk menampilkan data ID_BARANG_MASTER berdasarkan HASH_MD5_BARANG_MASTER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function proses_upload_file
	//         2. 
	function get_id_barang_master_by_HASH_MD5_BARANG_MASTER($HASH_MD5_BARANG_MASTER){
		$hsl=$this->db->query("SELECT * FROM barang_master WHERE HASH_MD5_BARANG_MASTER='$HASH_MD5_BARANG_MASTER'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER
					);
			}
		}
		else
		{
			$hasil = "BELUM ADA DATA";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang master berdasarkan HASH_MD5_BARANG_MASTER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function get_data
	//         2. 
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

	//FUNGSI: Fungsi ini untuk mengecek apakah NAMA di tabel barang_master sudah ada 
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function simpan_data
	//         2. 
	function cek_nama_barang_master_by_admin_nama($NAMA)
	{
		$hsl = $this->db->query("SELECT * FROM barang_master WHERE NAMA ='$NAMA'");
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

	function cek_nama_barang_master_by_admin_kode($KODE_BARANG)
	{
		$hsl = $this->db->query("SELECT * FROM barang_master WHERE KODE_BARANG = '$KODE_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'KODE_BARANG' => $data->KODE_BARANG
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk mengeset HASH_MD5_BARANG_MASTER berdasarkan ID_BARANG_MASTER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function simpan_data
	//         2. 
	function set_md5_id_barang_master($NAMA)
	{
		$hsl = $this->db->query("SELECT ID_BARANG_MASTER FROM barang_master WHERE NAMA='$NAMA'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER
				);
			}
		} else {
			$hasil = "BELUM ADA BARANG_MASTER";
		}
		$ID_BARANG_MASTER = $hasil['ID_BARANG_MASTER'];
		$HASH_MD5_BARANG_MASTER = md5($ID_BARANG_MASTER);
		$this->db->query("UPDATE barang_master SET HASH_MD5_BARANG_MASTER='$HASH_MD5_BARANG_MASTER' WHERE ID_BARANG_MASTER='$ID_BARANG_MASTER'");
		
	}

	//FUNGSI: Fungsi ini untuk update seluruh data barang master
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function update_data
	//         2. 
	function update_data(
		$ID_BARANG_MASTER,
		$NAMA,
		$ALIAS,
		$MEREK,
		$NAMA_SATUAN_BARANG,
		$JENIS_BARANG,
		$PERALATAN_PERLENGKAPAN,
		$GROSS_WEIGHT,
		$NETT_WEIGHT,
		$DIMENSI_PANJANG,
		$DIMENSI_LEBAR,
		$DIMENSI_TINGGI,
		$SPESIFIKASI_LENGKAP,
		$SPESIFIKASI_SINGKAT,
		$CARA_SINGKAT_PENGGUNAAN,
		$CARA_PENYIMPANAN_BARANG,
		$KODE_BARANG,
		$MASA_PAKAI
	) {
		$hasil = $this->db->query("UPDATE barang_master SET 
		NAMA='$NAMA', 
		ALIAS='$ALIAS', 
		MEREK='$MEREK', 
		ID_SATUAN_BARANG='$NAMA_SATUAN_BARANG', 
		ID_JENIS_BARANG='$JENIS_BARANG', 
		PERALATAN_PERLENGKAPAN='$PERALATAN_PERLENGKAPAN',
		GROSS_WEIGHT='$GROSS_WEIGHT',
		NETT_WEIGHT='$NETT_WEIGHT',
		DIMENSI_PANJANG='$DIMENSI_PANJANG',
		DIMENSI_LEBAR='$DIMENSI_LEBAR',
		DIMENSI_TINGGI='$DIMENSI_TINGGI',
		SPESIFIKASI_LENGKAP='$SPESIFIKASI_LENGKAP',
		SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
		CARA_SINGKAT_PENGGUNAAN='$CARA_SINGKAT_PENGGUNAAN',
		CARA_PENYIMPANAN_BARANG='$CARA_PENYIMPANAN_BARANG',
		KODE_BARANG='$KODE_BARANG',
		MASA_PAKAI='$MASA_PAKAI'
		WHERE ID_BARANG_MASTER='$ID_BARANG_MASTER'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menyimpan seluruh data barang master
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function simpan_data
	//         2. 
	function simpan_data_by_admin(
		$NAMA,
		$ALIAS,
		$MEREK,
		$JENIS_BARANG,
		$PERALATAN_PERLENGKAPAN,
		$NAMA_SATUAN_BARANG,
		$GROSS_WEIGHT,
		$NETT_WEIGHT,
		$DIMENSI_PANJANG,
		$DIMENSI_LEBAR,
		$DIMENSI_TINGGI,
		$SPESIFIKASI_LENGKAP,
		$SPESIFIKASI_SINGKAT,
		$CARA_SINGKAT_PENGGUNAAN,
		$CARA_PENYIMPANAN_BARANG,
		$KODE_BARANG,
		$MASA_PAKAI
	) {
		$hasil = $this->db->query("INSERT INTO barang_master (
			NAMA,
			ALIAS,
			MEREK,
			ID_JENIS_BARANG,
			PERALATAN_PERLENGKAPAN,
			ID_SATUAN_BARANG,
			GROSS_WEIGHT,
			NETT_WEIGHT,
			DIMENSI_PANJANG,
			DIMENSI_LEBAR,
			DIMENSI_TINGGI,
			SPESIFIKASI_LENGKAP,
			SPESIFIKASI_SINGKAT,
			CARA_SINGKAT_PENGGUNAAN,
			CARA_PENYIMPANAN_BARANG,
			KODE_BARANG,
			MASA_PAKAI)
		VALUES(
			'$NAMA',
			'$ALIAS',
			'$MEREK',
			'$JENIS_BARANG',
			'$PERALATAN_PERLENGKAPAN',
			'$NAMA_SATUAN_BARANG',
			'$GROSS_WEIGHT',
			'$NETT_WEIGHT',
			'$DIMENSI_PANJANG',
			'$DIMENSI_LEBAR',
			'$DIMENSI_TINGGI',
			'$SPESIFIKASI_LENGKAP',
			'$SPESIFIKASI_SINGKAT',
			'$CARA_SINGKAT_PENGGUNAAN',
			'$CARA_PENYIMPANAN_BARANG',
			'$KODE_BARANG',
			'$MASA_PAKAI')");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menyimpan user_log_barang_master berdasarkan ID_USER, KETERANGAN, WAKTU
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_master / function logout
	//         2. 
	function user_log_barang_master($ID_USER, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO user_log_barang_master (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
