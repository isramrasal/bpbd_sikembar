<?php
class RAB_form_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh RAB form
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller RAB_form / function data_RAB_form
	//         2. 
	function RAB_form_list()
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.HASH_MD5_BARANG_MASTER, M.ALIAS,M.KODE_BARANG, M.MEREK, 
		J.NAMA_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
		RB.ID_RAB_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, 
		RB.ID_RAB, M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN RAB_form AS RB ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
		");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RAB form berdasarkan ID_RAB_FORM
	//SUMBER TABEL: tabel RAB_form
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function RAB_form_list_by_id_RAB_form($ID_RAB_FORM)
	{
		$hasil = $this->db->query("SELECT RB.NAMA, M.KODE_BARANG, RB.PERALATAN_PERLENGKAPAN, RB.MEREK, 
		J.NAMA_JENIS_BARANG, RB.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
		RB.ID_RAB_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, 
		RB.ID_RAB, M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG, J.ID_JENIS_BARANG
		FROM RAB_form AS RB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER
		LEFT JOIN jenis_barang as J ON RB.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON RB.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
		WHERE RB.ID_RAB_FORM ='$ID_RAB_FORM'");
		return $hasil->row();
		//return $hasil->result();
	}

	function rab_list_by_id_proyek_sub_pekerjaan($ID_PROYEK_SUB_PEKERJAAN)
	{
		$hasil = $this->db->query("SELECT RB.ID_RAB_FORM, RB.NAMA_KATEGORI
		FROM RAB_form AS RB
		LEFT JOIN rab as R ON R.ID_RAB=RB.ID_RAB
		WHERE R.ID_PROYEK_SUB_PEKERJAAN ='$ID_PROYEK_SUB_PEKERJAAN'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RAB form berdasarkan ID_RAB
	//SUMBER TABEL: tabel RAB_form
	//DIPAKAI: 1. controller RAB_form / function data_RAB_form
	//         2. 
	function RAB_form_list_by_id_RAB($ID_RAB)
	{
		$hasil = $this->db->query("SELECT
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		M.ALIAS,
		M.HASH_MD5_BARANG_MASTER,
		RB.ID_RAB,
		RB.ID_RAB_FORM,
		RB.NAMA,
		RB.MEREK,
		RB.SPESIFIKASI_SINGKAT,
		RB.JUMLAH_BARANG,
		RB.PERALATAN_PERLENGKAPAN,
		RB.HARGA_BARANG,
		RB.TOTAL_PENGADAAN_SAAT_INI,
		J.NAMA_JENIS_BARANG,
		SB.NAMA_SATUAN_BARANG
	FROM RAB_form AS RB
	LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER = RB.ID_BARANG_MASTER
	LEFT JOIN jenis_barang AS J	ON  RB.ID_JENIS_BARANG = J.ID_JENIS_BARANG
	LEFT JOIN satuan_barang AS SB ON  RB.ID_SATUAN_BARANG = SB.ID_SATUAN_BARANG
	WHERE
		RB.ID_RAB = '$ID_RAB'");
		// return $hasil;
		return $hasil->result();
	}

	function file_list_by_HASH_MD5_RAB($HASH_MD5_RAB){ //dipake
		$hasil=$this->db->query("SELECT * FROM rab_form_file WHERE HASH_MD5_RAB = '$HASH_MD5_RAB' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil;
	}

	function file_list_by_HASH_MD5_RAB_result($HASH_MD5_RAB){ //dipake
		$hasil=$this->db->query("SELECT * FROM rab_form_file WHERE HASH_MD5_RAB = '$HASH_MD5_RAB' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil->result();
	}

	function data_anggaran_sum_jumlah_barang_rab_pengadaan_sebelumnya($ID_RAB_FORM)
	{
		$hasil = $this->db->query("SELECT * FROM rasd_realisasi
        WHERE (ID_RAB_FORM = '$ID_RAB_FORM') ");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menghapus data RAB form berdasarkan ID_RAB_FORM
	//SUMBER TABEL: tabel RAB_form
	//DIPAKAI: 1. controller RAB_form / function hapus_data
	//         2. 
	function hapus_data_by_id_RAB_form($ID_RAB_FORM) //DIPAKE
	{
		$hasil = $this->db->query("DELETE FROM RAB_form WHERE ID_RAB_FORM='$ID_RAB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RAB form berdasarkan ID_RAB_FORM
	//SUMBER TABEL: tabel RAB_form
	//DIPAKAI: 1. controller RAB_form / function get_data
	//         2. controller RAB_form / function hapus_data
	//         2. controller RAB_form / function update_data
	function get_data_by_id_RAB_form($ID_RAB_FORM) //DIPAKE
	{
		$hsl = $this->db->query("SELECT RABF.ID_RAB_FORM, RABF.NAMA_KATEGORI, RABF.RENCANA_ANGGARAN, RABF.REALISASI_ANGGARAN, RAB.ID_PROYEK, RAB.ID_PROYEK_SUB_PEKERJAAN, RAB.ID_RAB FROM RAB_form AS RABF LEFT JOIN rab as RAB ON RAB.ID_RAB = RABF.ID_RAB WHERE RABF.ID_RAB_FORM = '$ID_RAB_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'ID_RAB_FORM' => $data->ID_RAB_FORM,
					'ID_RAB' => $data->ID_RAB,
					'NAMA_KATEGORI' => $data->NAMA_KATEGORI,
					'RENCANA_ANGGARAN' => $data->RENCANA_ANGGARAN,
					'REALISASI_ANGGARAN' => $data->REALISASI_ANGGARAN
				);
			}
		} else {
			$hasil = "BELUM ADA RAB_FORM";
		}
		return $hasil;
	}

	function cek_nama_kategori_rab($ID_RAB, $NAMA_KATEGORI)//DIPAKE
	{
		$hsl = $this->db->query("SELECT * FROM rab_form WHERE NAMA_KATEGORI ='$NAMA_KATEGORI' AND ID_RAB ='$ID_RAB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RAB' => $data->ID_RAB,
					'ID_RAB_FORM' => $data->ID_RAB_FORM,
					'NAMA_KATEGORI' => $data->NAMA_KATEGORI
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function cek_nama_rasd_by_id_rab_form($ID_RAB_FORM, $NAMA_RASD)//DIPAKE
	{
		$hsl = $this->db->query("SELECT * FROM rasd WHERE ID_RAB_FORM ='$ID_RAB_FORM' AND NAMA_RASD ='$NAMA_RASD'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RAB' => $data->ID_RAB,
					'ID_RAB_FORM' => $data->ID_RAB_FORM,
					'NAMA_RASD' => $data->NAMA_RASD
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function cek_nama_kategori_rab_by_ID_RAB_FORM($ID_RAB, $NAMA_KATEGORI, $ID_RAB_FORM)//DIPAKE
	{
		$hsl = $this->db->query("SELECT * FROM rab_form WHERE NAMA_KATEGORI ='$NAMA_KATEGORI' AND ID_RAB ='$ID_RAB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RAB' => $data->ID_RAB,
					'NAMA_KATEGORI' => $data->NAMA_KATEGORI
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function cek_nama_rasd_by_id_rab($ID_RAB, $NAMA_RASD)//DIPAKE
	{
		$hsl = $this->db->query("SELECT * FROM rasd WHERE NAMA_RASD ='$NAMA_RASD' AND ID_RAB ='$ID_RAB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RAB' => $data->ID_RAB,
					'NAMA_RASD' => $data->NAMA_RASD
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk mengubah data RAB form berdasarkan ID_RAB_FORM
	//SUMBER TABEL: tabel RAB_form
	//DIPAKAI: 1. controller RAB_form / function update_data
	//         2. 
	function update_data($ID_RAB_FORM, $NAMA_KATEGORI, $RENCANA_ANGGARAN)
	{

		$hasil = $this->db->query("UPDATE RAB_form SET 
			NAMA_KATEGORI='$NAMA_KATEGORI',
			RENCANA_ANGGARAN='$RENCANA_ANGGARAN'  
			WHERE ID_RAB_FORM='$ID_RAB_FORM'");
		return $hasil;
	}

	function update_data_menjadi_RASD($ID_RAB_FORM, $NAMA_KATEGORI)
	{

		$hasil = $this->db->query("UPDATE RAB_form SET 
			NAMA_KATEGORI='$NAMA_KATEGORI'
			WHERE ID_RAB_FORM='$ID_RAB_FORM'");
		return $hasil;
	}

	function update_data_menjadi_NON_RASD($ID_RAB_FORM, $NAMA_KATEGORI, $JENIS_RASD, $RENCANA_ANGGARAN)
	{

		$hasil = $this->db->query("UPDATE RAB_form SET 
			NAMA_KATEGORI='$NAMA_KATEGORI',
			JENIS_RASD='$JENIS_RASD',
			RENCANA_ANGGARAN='$RENCANA_ANGGARAN'  
			WHERE ID_RAB_FORM='$ID_RAB_FORM'");
		return $hasil;
	}


	function simpan_data_nama_kategori_MENGGUNAKAN_RASD($ID_RAB, $NAMA_KATEGORI)//DIPAKE
	{
		$hasil = $this->db->query("INSERT INTO rab_form (ID_RAB, NAMA_KATEGORI )VALUES('$ID_RAB','$NAMA_KATEGORI')");
		return $hasil;
	}

	function simpan_data_nama_kategori_TANPA_RASD($ID_RAB, $NAMA_KATEGORI, $RENCANA_ANGGARAN, $JENIS_RASD)//DIPAKE
	{
		$hasil = $this->db->query("INSERT INTO rab_form (ID_RAB, NAMA_KATEGORI, RENCANA_ANGGARAN, JENIS_RASD )VALUES('$ID_RAB', '$NAMA_KATEGORI','$RENCANA_ANGGARAN','$JENIS_RASD')");
		return $hasil;
	}

	function simpan_data_rasd($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN, $ID_RAB, $ID_RAB_FORM, $NAMA_RASD)
	{
		$hasil = $this->db->query("INSERT INTO rasd (ID_PROYEK, ID_PROYEK_SUB_PEKERJAAN, ID_RAB, ID_RAB_FORM, NAMA_RASD )VALUES('$ID_PROYEK','$ID_PROYEK_SUB_PEKERJAAN','$ID_RAB','$ID_RAB_FORM','$NAMA_RASD')");
		return $hasil;
	}

	function set_md5_id_rasd($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN, $ID_RAB, $NAMA_RASD)
	{
		$hsl = $this->db->query("SELECT ID_RASD FROM rasd WHERE 
		ID_PROYEK='$ID_PROYEK' AND
		ID_PROYEK_SUB_PEKERJAAN='$ID_PROYEK_SUB_PEKERJAAN' AND
		ID_RAB='$ID_RAB' AND
		NAMA_RASD='$NAMA_RASD'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RASD' => $data->ID_RASD
				);
			}
		} else {
			$hasil = "BELUM ADA RASD";
		}
		$ID_RASD = $hasil['ID_RASD'];
		$HASH_MD5_RASD = md5($ID_RASD);
		$this->db->query("UPDATE rasd SET HASH_MD5_RASD='$HASH_MD5_RASD' WHERE ID_RASD='$ID_RASD'");
	}

	function set_id_rab_form_tabel_rasd($ID_RASD, $ID_RAB_FORM)
	{

		$this->db->query("UPDATE rasd SET ID_RAB_FORM='$ID_RAB_FORM' WHERE ID_RASD='$ID_RASD'");
	}

	function get_list_rasd_by_id_rab_form($ID_RAB_FORM)
	{
		$hsl = $this->db->query("SELECT RASD.ID_RASD, RASD.HASH_MD5_RASD, RASD.ID_PROYEK, RASD.NAMA_RASD, RASD.ID_PROYEK_SUB_PEKERJAAN, RASD.DOK_RASD, PSB.NAMA_SUB_PEKERJAAN FROM rasd as RASD
		LEFT JOIN proyek_sub_pekerjaan as PSB ON RASD.ID_PROYEK_SUB_PEKERJAAN = PSB.ID_PROYEK_SUB_PEKERJAAN
		WHERE RASD.ID_RAB_FORM ='$ID_RAB_FORM'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_total_harga_by_id_rab_form($ID_RASD)
	{
		$hsl = $this->db->query("SELECT * FROM rasd_form
		WHERE ID_RASD ='$ID_RASD'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA HARGA';
		}
	}

	function get_data_id_rasd($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN, $ID_RAB, $NAMA_RASD)
	{
		$hsl = $this->db->query("SELECT ID_RASD  FROM rasd WHERE 
		ID_PROYEK = '$ID_PROYEK' AND 
		ID_PROYEK_SUB_PEKERJAAN = '$ID_PROYEK_SUB_PEKERJAAN' AND
		ID_RAB = '$ID_RAB' AND
		NAMA_RASD = '$NAMA_RASD'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = $data->ID_RASD;
			}
		} else {
			$hasil = "BELUM ADA RASD";
		}
		return $hasil;
	}

	function get_data_id_rab_form($ID_RAB, $NAMA_KATEGORI)
	{
		$hsl = $this->db->query("SELECT id_rab_form  FROM rab_form WHERE 
		ID_RAB = '$ID_RAB' AND 
		NAMA_KATEGORI = '$NAMA_KATEGORI'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = $data->id_rab_form;
			}
		} else {
			$hasil = "BELUM ADA RASD FORM";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data RAB form berdasarkan ID_USER
	//SUMBER TABEL: tabel RAB_form
	//DIPAKAI: 1. controller RAB_form / function logout
	//         2. controller RAB_form / function user_log
	function user_log_rab_form($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_rab_form (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
