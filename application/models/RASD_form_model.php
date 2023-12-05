<?php
class RASD_form_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh RASD form
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller RASD_form / function data_RASD_form
	//         2. 
	function RASD_form_list()
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.HASH_MD5_BARANG_MASTER, M.ALIAS,M.KODE_BARANG, M.MEREK, 
		J.NAMA_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
		RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, 
		RB.ID_RASD, M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN rasd_form AS RB ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
		");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD form berdasarkan ID_RASD_FORM
	//SUMBER TABEL: tabel rasd_form
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function rasd_form_list_by_id_rasd_form($ID_RASD_FORM)
	{
		$hasil = $this->db->query("SELECT RB.NAMA, M.KODE_BARANG, RB.PERALATAN_PERLENGKAPAN, RB.MEREK, 
		J.NAMA_JENIS_BARANG, RB.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
		RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, 
		RB.ID_RASD, M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG, J.ID_JENIS_BARANG, RAB_F.NAMA_KATEGORI
		FROM rasd_form AS RB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER
		LEFT JOIN jenis_barang as J ON RB.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON RB.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
        LEFT JOIN rasd as RASD ON RB.ID_RASD=RASD.ID_RASD
        LEFT join rab_form as RAB_F ON RAB_F.ID_RAB_FORM = RASD.ID_RAB_FORM
		WHERE RB.ID_RASD_FORM = '$ID_RASD_FORM'");
		return $hasil->row();
		//return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD form berdasarkan ID_RASD
	//SUMBER TABEL: tabel rasd_form
	//DIPAKAI: 1. controller RASD_form / function data_RASD_form
	//         2. 
	function RASD_form_list_by_id_rasd($ID_RASD)
	{
		$hasil = $this->db->query("SELECT
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		M.ALIAS,
		M.HASH_MD5_BARANG_MASTER,
		RB.ID_RASD,
		RB.ID_RASD_FORM,
		RB.NAMA,
		RB.MEREK,
		RB.SPESIFIKASI_SINGKAT,
		RB.SATUAN_BARANG,
		RB.JUMLAH_BARANG,
		RB.HARGA_BARANG,
		RB.TOTAL_HARGA,
        RASD.ID_RAB_FORM
	FROM rasd_form AS RB
	LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER = RB.ID_BARANG_MASTER
    LEFT JOIN RASD AS RASD ON RASD.ID_RASD = RB.ID_RASD
	WHERE
		RB.ID_RASD = '$ID_RASD' AND RB.HARGA_BARANG <> '0' AND RB.JUMLAH_BARANG <> '0'  ORDER BY NAMA ASC");
		// return $hasil;
		return $hasil->result();
	}

	function RASD_form_deviasi_list_by_id_rasd($ID_RASD)
	{
		$hasil = $this->db->query("SELECT
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		M.ALIAS,
		M.HASH_MD5_BARANG_MASTER,
		RB.ID_RASD,
		RB.ID_RASD_FORM,
		RB.NAMA,
		RB.MEREK,
		RB.SPESIFIKASI_SINGKAT,
		RB.SATUAN_BARANG,
		RB.JUMLAH_BARANG,
		RB.HARGA_BARANG,
		RB.TOTAL_HARGA,
        RASD.ID_RAB_FORM
	FROM rasd_form AS RB
	LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER = RB.ID_BARANG_MASTER
    LEFT JOIN RASD AS RASD ON RASD.ID_RASD = RB.ID_RASD
	WHERE
		RB.ID_RASD = '$ID_RASD' AND RB.HARGA_BARANG IS NULL AND RB.JUMLAH_BARANG IS NULL ORDER BY NAMA ASC");
		// return $hasil;
		return $hasil->result();
	}

	function data_RASD_realisasi($ID_RASD_FORM)
	{
		$hasil = $this->db->query("SELECT
		RR.ID_RAB_FORM,
		RR.ID_SPP,
		RR.SATUAN_BARANG,
		RR.JUMLAH_BARANG,
		RR.HARGA_BARANG,
		RR.HARGA_TOTAL,
		SPP.NO_URUT_SPP,
		SPP.HASH_MD5_SPP,
		SPPF.NAMA_BARANG,
		SPPF.MEREK
		FROM
			rasd_realisasi AS RR
		LEFT JOIN spp AS SPP
		ON
			RR.ID_SPP = SPP.ID_SPP
		LEFT JOIN spp_form AS SPPF
		ON
			RR.ID_SPP_FORM = SPPF.ID_SPP_FORM
		WHERE
		RR.ID_RASD_FORM = '$ID_RASD_FORM'");
		// return $hasil;
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang master berdasarkan ID_RASD
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller RASD_form / function index
	//         2. controller RASD_form / function view_RASD_form
	function barang_master_list_where_not_in_rasd($ID_RASD)
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.HASH_MD5_BARANG_MASTER, M.ALIAS, M.KODE_BARANG, M.MEREK, 
		J.NAMA_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG, M.PERALATAN_PERLENGKAPAN,
		M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG, J.ID_JENIS_BARANG
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
        WHERE NOT EXISTS (SELECT ID_BARANG_MASTER 
		FROM RASD_form 
		WHERE RASD_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER 
		AND RASD_form.ID_RASD = '$ID_RASD')");
		// return $hasil;
		return $hasil->result();
	}

	function data_anggaran_sum_jumlah_barang_rab_pengadaan_sebelumnya($ID_RAB_FORM, $ID_RASD_FORM)
	{
		$hasil = $this->db->query("SELECT * FROM rasd_realisasi
        WHERE (ID_RAB_FORM = '$ID_RAB_FORM' AND ID_RASD_FORM = '$ID_RASD_FORM') ");
		return $hasil->result();
	}



	// function RASD_form_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM RASD_form WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM RASD_form WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menghapus data RASD form berdasarkan ID_RASD_FORM
	//SUMBER TABEL: tabel rasd_form
	//DIPAKAI: 1. controller RASD_form / function hapus_data
	//         2. 
	function hapus_data_by_id_RASD_form($ID_RASD_FORM)
	{
		$hasil = $this->db->query("DELETE FROM RASD_form WHERE ID_RASD_FORM='$ID_RASD_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD form berdasarkan ID_RASD_FORM
	//SUMBER TABEL: tabel rasd_form
	//DIPAKAI: 1. controller RASD_form / function get_data
	//         2. controller RASD_form / function hapus_data
	//         2. controller RASD_form / function update_data
	function get_data_by_id_RASD_form($ID_RASD_FORM)
	{
		$hsl = $this->db->query("SELECT
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		RB.ID_RASD,
		RB.ID_RASD_FORM,
		RB.JUMLAH_BARANG,
		RB.HARGA_BARANG,
		RB.TOTAL_HARGA,
		RB.NAMA,
		RB.MEREK,
		RB.SPESIFIKASI_SINGKAT,
		RB.SATUAN_BARANG,
		RB.ID_KLASIFIKASI_BARANG
	FROM
		rasd_form AS RB
	LEFT JOIN barang_master AS M
	ON
		M.ID_BARANG_MASTER = RB.ID_BARANG_MASTER
	WHERE
		RB.ID_RASD_FORM = '$ID_RASD_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'KODE_BARANG' => $data->KODE_BARANG,
					'ID_RASD' => $data->ID_RASD,
					'ID_RASD_FORM' => $data->ID_RASD_FORM,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'HARGA_BARANG' => $data->HARGA_BARANG,
					'TOTAL_HARGA' => $data->TOTAL_HARGA,
					'NAMA' => $data->NAMA,
					'MEREK' => $data->MEREK,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,

				);
			}
		} else {
			$hasil = "BELUM ADA RASD_FORM";
		}
		return $hasil;
	}

	function get_data_by_id_RASD_nama_spesifikasi($ID_RASD, $NAMA, $SPESIFIKASI_SINGKAT)
	{
		$hsl = $this->db->query("SELECT
		*
	FROM
		rasd_form
	WHERE
		ID_RASD = '$ID_RASD' AND NAMA = '$NAMA' AND SPESIFIKASI_SINGKAT = '$SPESIFIKASI_SINGKAT' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RASD_FORM' => $data->ID_RASD_FORM
				);
			}
		} else {
			$hasil = "BELUM ADA RASD FORM";
		}
		return $hasil;
	}

	function get_data_rasd_realisasi($ID_RASD_FORM)
	{
		$hsl = $this->db->query("SELECT
		RR.ID_RAB_FORM,
		RR.ID_SPP,
		RR.SATUAN_BARANG,
		RR.JUMLAH_BARANG,
		RR.HARGA_BARANG,
		RR.HARGA_TOTAL,
		SPP.NO_URUT_SPP
	FROM
		rasd_realisasi AS RR
	LEFT JOIN spp AS SPP
	ON
		RR.ID_SPP = SPP.ID_SPP
	WHERE
		RR.ID_RASD_FORM = '$ID_RASD_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'KODE_BARANG' => $data->KODE_BARANG,
					'ID_RASD' => $data->ID_RASD,
					'ID_RASD_FORM' => $data->ID_RASD_FORM,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'HARGA_BARANG' => $data->HARGA_BARANG,
					'TOTAL_HARGA' => $data->TOTAL_HARGA,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,

				);
			}
		} else {
			$hasil = "BELUM ADA RASD_FORM";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD form berdasarkan NAMA
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller RASD_form / function simpan_data
	//         2. 
	function cek_nama_RASD_form($ID_RASD, $NAMA)
	{
		$hsl = $this->db->query("SELECT ID_RASD_FORM, NAMA FROM rasd_form WHERE NAMA ='$NAMA' AND ID_RASD='ID_RASD' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RASD_FORM' => $data->ID_RASD_FORM,
					'NAMA' => $data->NAMA
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function get_data_id_rasd_form($ID_RASD, $NAMA, $SPESIFIKASI_SINGKAT)
	{
		$hsl = $this->db->query("SELECT ID_RASD_FORM, NAMA FROM rasd_form WHERE ID_RASD ='$ID_RASD' AND NAMA='$NAMA' AND SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = $data->ID_RASD_FORM;
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}


	//FUNGSI: Fungsi ini untuk mengubah data RASD form berdasarkan ID_RASD_FORM
	//SUMBER TABEL: tabel rasd_form
	//DIPAKAI: 1. controller RASD_form / function update_data
	//         2. 
	function update_data($ID_RASD_FORM, $ID_BARANG_MASTER, $NAMA, $MEREK, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG, $HARGA_BARANG, $TOTAL_HARGA)
	{
		if ($ID_BARANG_MASTER != null) {
			$hasil = $this->db->query("UPDATE RASD_form SET 
				ID_BARANG_MASTER='$ID_BARANG_MASTER', 
				JUMLAH_BARANG='$JUMLAH_BARANG',
				HARGA_BARANG='$HARGA_BARANG',
				TOTAL_HARGA='$TOTAL_HARGA'
				WHERE ID_RASD_FORM='$ID_RASD_FORM'");
			return $hasil;
		} else {
			$hasil = $this->db->query("UPDATE RASD_form SET
			NAMA='$NAMA',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			SATUAN_BARANG='$SATUAN_BARANG',
			JUMLAH_BARANG='$JUMLAH_BARANG',
			HARGA_BARANG='$HARGA_BARANG',
			TOTAL_HARGA='$TOTAL_HARGA'
			WHERE ID_RASD_FORM='$ID_RASD_FORM'");
			return $hasil;
		}
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_tanggal
	//         2. 
	function update_data_harga($id, $field, $value)
	{
		$hasil = $this->db->query("UPDATE RASD_form SET $field='$value' WHERE ID_RASD_FORM ='$id'");
		return $hasil;
	}

	// // SIMPAN DATA BERDASARKAN DATA BARANG MASTER
	// function simpan_data_from_barang_master_by_admin($ID_BARANG_MASTER, $ID_RASD, $JUMLAH_BARANG)
	// {
	// 	$hasil = $this->db->query("INSERT INTO RASD_form (ID_RASD, ID_BARANG_MASTER, JUMLAH_BARANG)VALUES('$ID_RASD', '$ID_BARANG_MASTER', '$JUMLAH_BARANG' )");
	// 	return $hasil;
	// }

	// // SIMPAN DATA YANG TIDAK ADA DI BARANG MASTER
	// function simpan_data_baru_by_admin($ID_RASD, $NAMA, $MEREK, $JENIS_BARANG, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG)
	// {
	// 	$hasil = $this->db->query("INSERT INTO RASD_form (ID_RASD, NAMA, MEREK, ID_JENIS_BARANG, SPESIFIKASI_SINGKAT, ID_SATUAN_BARANG, JUMLAH_BARANG)VALUES('$ID_RASD', '$NAMA','$MEREK','$JENIS_BARANG','$SPESIFIKASI_SINGKAT','$SATUAN_BARANG', '$JUMLAH_BARANG' )");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menambahkan data RASD form berdasarkan ID_BARANG_MASTER
	//SUMBER TABEL: tabel rasd_form
	//DIPAKAI: 1. controller RASD_form / function simpan_data
	//         2. controller RASD_form / function simpan_data_dari_barang_master
	function simpan_data(
		$ID_RASD,
		$SATUAN_BARANG,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$HARGA_BARANG,
		$TOTAL_HARGA
	) {
		$hasil = $this->db->query("INSERT INTO RASD_form (
				ID_RASD,
				SATUAN_BARANG,
				NAMA,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG,
				HARGA_BARANG,
				TOTAL_HARGA
				)VALUES(
					'$ID_RASD',
					'$SATUAN_BARANG',
					'$NAMA',
					'$MEREK',
					'$SPESIFIKASI_SINGKAT',
					'$JUMLAH_BARANG',
					'$HARGA_BARANG',
					'$TOTAL_HARGA'
				)");
		return $hasil;
	}

	function simpan_data_dari_sppb_form(
		$ID_RASD,
		$SATUAN_BARANG,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT
	) {
		$hasil = $this->db->query("INSERT INTO RASD_form (
				ID_RASD,
				SATUAN_BARANG,
				NAMA,
				MEREK,
				SPESIFIKASI_SINGKAT
				)VALUES(
					'$ID_RASD',
					'$SATUAN_BARANG',
					'$NAMA',
					'$MEREK',
					'$SPESIFIKASI_SINGKAT'
				)");
		return $hasil;
	}

	function simpan_data_dari_sppb_form_deviasi(
		$ID_RASD,
		$SATUAN_BARANG,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT
	) {
		$hasil = $this->db->query("INSERT INTO RASD_form (
				ID_RASD,
				SATUAN_BARANG,
				NAMA,
				MEREK,
				SPESIFIKASI_SINGKAT,
				DEVIASI
				)VALUES(
					'$ID_RASD',
					'$SATUAN_BARANG',
					'$NAMA',
					'$MEREK',
					'$SPESIFIKASI_SINGKAT',
					'DEVIASI'
				)");
		return $hasil;
	}

	function simpan_data_dari_barang_master(
		$ID_BARANG_MASTER,
		$ID_RASD,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO RASD_form (
				ID_BARANG_MASTER,
				ID_RASD,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG
				)VALUES(
					'$ID_BARANG_MASTER',
					'$ID_RASD',
					'$ID_SATUAN_BARANG',
					'$ID_JENIS_BARANG',
					'$NAMA',
					'$MEREK',
					'$PERALATAN_PERLENGKAPAN',
					'$SPESIFIKASI_SINGKAT',
					'$JUMLAH_BARANG'
				)");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data RASD form berdasarkan ID_USER
	//SUMBER TABEL: tabel rasd_form
	//DIPAKAI: 1. controller RASD_form / function logout
	//         2. controller RASD_form / function user_log
	function user_log_rasd_form($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_rasd_form (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
