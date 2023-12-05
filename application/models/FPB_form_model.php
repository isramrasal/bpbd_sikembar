<?php
class FPB_form_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function data_fpb_form
	//         2. controller FPB_form / function cetak_pdf
	function FPB_form_list_by_id_fpb($ID_FPB)
	{
		$hasil = $this->db->query("SELECT 
		FPB_form.ID_FPB, 
		FPB_form.ID_FPB_FORM, 
		FPB_form.NAMA_BARANG, 
		FPB_form.MEREK,
		FPB_form.PERALATAN_PERLENGKAPAN,
		FPB_form.SPESIFIKASI_SINGKAT, 
		FPB_form.JUMLAH_MINTA,
		FPB_form.BIDANG_PEMAKAI,
		FPB_form.CORET, 
		FPB_form.REMARKS_CHIEF,
		FPB_form.REMARKS_STAFF_GUDANG_LOGISTIK, 
		FPB_form.REMARKS_SM, 
		FPB_form.REMARKS_STAFF_UMUM_LOGISTIK, 
		FPB_form.TANGGAL_MULAI_PAKAI,
		FPB_form.TANGGAL_SELESAI_PAKAI,
		FPB_form.JUMLAH_QTY_GUDANG,
        F.CREATE_BY_USER,
        U.ID_PEGAWAI,
        P.NAMA,
        P.ID_DEPARTEMEN_PEGAWAI,
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD,
		RB.ID_RASD_FORM,
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG,
        F.ID_PROYEK
        FROM FPB_form
        LEFT JOIN barang_master AS M ON FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = FPB_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = FPB_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = FPB_form.ID_SATUAN_BARANG
        LEFT JOIN fpb AS F ON F.ID_FPB = FPB_form.ID_FPB
        LEFT JOIN users AS U ON U.id = F.CREATE_BY_USER
        LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = U.ID_PEGAWAI
        WHERE FPB_form.ID_FPB = '$ID_FPB' 
		ORDER BY J.NAMA_JENIS_BARANG ASC");
		return $hasil->result();
	}

	function FPB_form_list_tool_by_id_fpb($ID_FPB)
	{
		$hasil = $this->db->query("SELECT 
		FPB_form.ID_FPB, 
		FPB_form.ID_FPB_FORM, 
		FPB_form.NAMA_BARANG, 
		FPB_form.MEREK,
		FPB_form.PERALATAN_PERLENGKAPAN,
		FPB_form.SPESIFIKASI_SINGKAT, 
		FPB_form.JUMLAH_MINTA,
		FPB_form.BIDANG_PEMAKAI,
		FPB_form.CORET, 
		FPB_form.REMARKS_CHIEF,
		FPB_form.REMARKS_STAFF_GUDANG_LOGISTIK, 
		FPB_form.REMARKS_SM, 
		FPB_form.REMARKS_STAFF_UMUM_LOGISTIK, 
		FPB_form.TANGGAL_MULAI_PAKAI,
		FPB_form.TANGGAL_SELESAI_PAKAI,
		FPB_form.JUMLAH_QTY_GUDANG,
        F.CREATE_BY_USER,
        U.ID_PEGAWAI,
        P.NAMA,
        P.ID_DEPARTEMEN_PEGAWAI,
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD,
		RB.ID_RASD_FORM,
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG,
        F.ID_PROYEK
        FROM FPB_form
        LEFT JOIN barang_master AS M ON FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = FPB_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = FPB_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = FPB_form.ID_SATUAN_BARANG
        LEFT JOIN fpb AS F ON F.ID_FPB = FPB_form.ID_FPB
        LEFT JOIN users AS U ON U.id = F.CREATE_BY_USER
        LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = U.ID_PEGAWAI
        WHERE FPB_form.ID_FPB = '$ID_FPB' AND FPB_form.PERALATAN_PERLENGKAPAN = 'TOOL'
		ORDER BY J.NAMA_JENIS_BARANG ASC");
		return $hasil->result();
	}

	function FPB_form_list_consumable_by_id_fpb($ID_FPB)
	{
		$hasil = $this->db->query("SELECT 
		FPB_form.ID_FPB, 
		FPB_form.ID_FPB_FORM, 
		FPB_form.NAMA_BARANG, 
		FPB_form.MEREK,
		FPB_form.PERALATAN_PERLENGKAPAN,
		FPB_form.SPESIFIKASI_SINGKAT, 
		FPB_form.JUMLAH_MINTA,
		FPB_form.BIDANG_PEMAKAI,
		FPB_form.CORET, 
		FPB_form.REMARKS_CHIEF,
		FPB_form.REMARKS_STAFF_GUDANG_LOGISTIK, 
		FPB_form.REMARKS_SM, 
		FPB_form.REMARKS_STAFF_UMUM_LOGISTIK, 
		FPB_form.TANGGAL_MULAI_PAKAI,
		FPB_form.TANGGAL_SELESAI_PAKAI,
		FPB_form.JUMLAH_QTY_GUDANG,
        F.CREATE_BY_USER,
        U.ID_PEGAWAI,
        P.NAMA,
        P.ID_DEPARTEMEN_PEGAWAI,
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD,
		RB.ID_RASD_FORM,
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG,
        F.ID_PROYEK
        FROM FPB_form
        LEFT JOIN barang_master AS M ON FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = FPB_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = FPB_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = FPB_form.ID_SATUAN_BARANG
        LEFT JOIN fpb AS F ON F.ID_FPB = FPB_form.ID_FPB
        LEFT JOIN users AS U ON U.id = F.CREATE_BY_USER
        LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = U.ID_PEGAWAI
        WHERE FPB_form.ID_FPB = '$ID_FPB' AND FPB_form.PERALATAN_PERLENGKAPAN = 'CONSUMABLE'
		ORDER BY J.NAMA_JENIS_BARANG ASC");
		return $hasil->result();
	}

	function FPB_form_list_material_by_id_fpb($ID_FPB)
	{
		$hasil = $this->db->query("SELECT 
		FPB_form.ID_FPB, 
		FPB_form.ID_FPB_FORM, 
		FPB_form.NAMA_BARANG, 
		FPB_form.MEREK,
		FPB_form.PERALATAN_PERLENGKAPAN,
		FPB_form.SPESIFIKASI_SINGKAT, 
		FPB_form.JUMLAH_MINTA,
		FPB_form.BIDANG_PEMAKAI,
		FPB_form.CORET, 
		FPB_form.REMARKS_CHIEF,
		FPB_form.REMARKS_STAFF_GUDANG_LOGISTIK, 
		FPB_form.REMARKS_SM, 
		FPB_form.REMARKS_STAFF_UMUM_LOGISTIK, 
		FPB_form.TANGGAL_MULAI_PAKAI,
		FPB_form.TANGGAL_SELESAI_PAKAI,
		FPB_form.JUMLAH_QTY_GUDANG,
        F.CREATE_BY_USER,
        U.ID_PEGAWAI,
        P.NAMA,
        P.ID_DEPARTEMEN_PEGAWAI,
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD,
		RB.ID_RASD_FORM,
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG,
        F.ID_PROYEK
        FROM FPB_form
        LEFT JOIN barang_master AS M ON FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = FPB_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = FPB_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = FPB_form.ID_SATUAN_BARANG
        LEFT JOIN fpb AS F ON F.ID_FPB = FPB_form.ID_FPB
        LEFT JOIN users AS U ON U.id = F.CREATE_BY_USER
        LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = U.ID_PEGAWAI
        WHERE FPB_form.ID_FPB = '$ID_FPB' AND FPB_form.PERALATAN_PERLENGKAPAN = 'MATERIAL'
		ORDER BY J.NAMA_JENIS_BARANG ASC");
		return $hasil->result();
	}

	function FPB_form_list_jasa_rental_by_id_fpb($ID_FPB)
	{
		$hasil = $this->db->query("SELECT 
		FPB_form.ID_FPB, 
		FPB_form.ID_FPB_FORM, 
		FPB_form.NAMA_BARANG, 
		FPB_form.MEREK,
		FPB_form.PERALATAN_PERLENGKAPAN,
		FPB_form.SPESIFIKASI_SINGKAT, 
		FPB_form.JUMLAH_MINTA,
		FPB_form.BIDANG_PEMAKAI,
		FPB_form.CORET, 
		FPB_form.REMARKS_CHIEF,
		FPB_form.REMARKS_STAFF_GUDANG_LOGISTIK, 
		FPB_form.REMARKS_SM, 
		FPB_form.REMARKS_STAFF_UMUM_LOGISTIK, 
		FPB_form.TANGGAL_MULAI_PAKAI,
		FPB_form.TANGGAL_SELESAI_PAKAI,
		FPB_form.JUMLAH_QTY_GUDANG,
        F.CREATE_BY_USER,
        U.ID_PEGAWAI,
        P.NAMA,
        P.ID_DEPARTEMEN_PEGAWAI,
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD,
		RB.ID_RASD_FORM,
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG,
        F.ID_PROYEK
        FROM FPB_form
        LEFT JOIN barang_master AS M ON FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = FPB_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = FPB_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = FPB_form.ID_SATUAN_BARANG
        LEFT JOIN fpb AS F ON F.ID_FPB = FPB_form.ID_FPB
        LEFT JOIN users AS U ON U.id = F.CREATE_BY_USER
        LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = U.ID_PEGAWAI
        WHERE FPB_form.ID_FPB = '$ID_FPB' AND FPB_form.PERALATAN_PERLENGKAPAN = 'JASA/RENTAL'
		ORDER BY J.NAMA_JENIS_BARANG ASC");
		return $hasil->result();
	}

	function FPB_form_list_by_id_fpb_form($ID_FPB_FORM)
	{
		$hasil = $this->db->query("SELECT 
		FPB_form.ID_FPB, 
		FPB_form.ID_FPB_FORM,
        FPB_form.ID_BARANG_MASTER,
        FPB_form.ID_SATUAN_BARANG,
        FPB_form.ID_JENIS_BARANG,
		FPB_form.NAMA_BARANG, 
		FPB_form.MEREK, 
		FPB_form.PERALATAN_PERLENGKAPAN,
		FPB_form.SPESIFIKASI_SINGKAT, 
		FPB_form.JUMLAH_MINTA,
		FPB_form.JUMLAH_QTY_SPPB, 
		FPB_form.CORET, 
		FPB_form.REMARKS_CHIEF,
		FPB_form.REMARKS_STAFF_GUDANG_LOGISTIK, 
		FPB_form.REMARKS_SM, 
		FPB_form.REMARKS_STAFF_UMUM_LOGISTIK, 
		FPB_form.TANGGAL_MULAI_PAKAI,
		FPB_form.TANGGAL_SELESAI_PAKAI,
        F.CREATE_BY_USER,
        U.ID_PEGAWAI,
        P.NAMA,
        P.ID_DEPARTEMEN_PEGAWAI,
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		M.HASH_MD5_BARANG_MASTER,
        M.NAMA as NAMA_BARANG_MASTER,
        M.MEREK as MEREK_MASTER,
        M.SPESIFIKASI_SINGKAT as SPESIFIKASI_SINGKAT_MASTER,
        RB.ID_RASD,
		RB.ID_RASD_FORM,
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG,
        F.ID_PROYEK
        FROM FPB_form
        LEFT JOIN barang_master AS M ON FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = FPB_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = FPB_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = FPB_form.ID_SATUAN_BARANG
        LEFT JOIN fpb AS F ON F.ID_FPB = FPB_form.ID_FPB
        LEFT JOIN users AS U ON U.id = F.CREATE_BY_USER
        LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = U.ID_PEGAWAI
        WHERE FPB_form.ID_FPB_FORM = '$ID_FPB_FORM'
		ORDER BY J.NAMA_JENIS_BARANG ASC");
		return $hasil->row();
	}

	function FPB_form_list_approval_by_id_fpb($ID_FPB)
	{
		$hasil = $this->db->query("SELECT 
		FPB_form.ID_FPB, 
		FPB_form.ID_FPB_FORM, 
		FPB_form.NAMA_BARANG, 
		FPB_form.MEREK, 
		FPB_form.PERALATAN_PERLENGKAPAN,
		FPB_form.SPESIFIKASI_SINGKAT, 
		FPB_form.JUMLAH_MINTA,
        fpb_form.JUMLAH_QTY_SPPB,
        FPB_form.JUMLAH_QTY_GUDANG,
		FPB_form.CORET,
		FPB_form.CATATAN_CORET,
		FPB_form.CATATAN_BATAL_CORET,
		FPB_form.REMARKS_CHIEF,
		FPB_form.REMARKS_STAFF_GUDANG_LOGISTIK, 
		FPB_form.REMARKS_SM, 
		FPB_form.REMARKS_STAFF_UMUM_LOGISTIK,  
		FPB_form.TANGGAL_MULAI_PAKAI,
		FPB_form.TANGGAL_SELESAI_PAKAI,
		M.ID_BARANG_MASTER,
		M.KODE_BARANG,
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD,
		RB.ID_RASD_FORM,
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG,
        F.ID_PROYEK
        FROM FPB_form
        LEFT JOIN barang_master AS M ON FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = FPB_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = FPB_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = FPB_form.ID_SATUAN_BARANG
        LEFT JOIN fpb AS F ON F.ID_FPB = FPB_form.ID_FPB
        WHERE FPB_form.ID_FPB = '$ID_FPB'
		ORDER BY J.NAMA_JENIS_BARANG ASC");
		return $hasil->result();
	}

	function data_quantity_barang_entitas_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT COUNT(JUMLAH_BARANG) AS jumlah_quantity, POSISI from barang_entitas WHERE (ID_BARANG_MASTER='$ID_BARANG_MASTER' AND ID_PROYEK= '$ID_PROYEK' AND POSISI= 'GUDANG' AND KONDISI='DAPAT DIGUNAKAN')");
		return $hasil->result();
	}


	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function cetak_pdf
	//         2. 
	function justifikasi_by_id_fpb($ID_FPB)
	{
		$hasil = $this->db->query("SELECT 
		FPB_form.ID_FPB, 
		FPB_form.NAMA_BARANG, 
		FPB_form.REMARKS_CHIEF
        FROM FPB_form
        WHERE ID_FPB = '$ID_FPB' AND fpb_form.REMARKS_CHIEF IS NOT NULL");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function cetak_pdf
	//         2. 
	function ID_JABATAN_BY_ID_FPB($ID_FPB)
	{
		$hasil = $this->db->query("SELECT P.ID_JABATAN_PEGAWAI, G.description
		FROM pegawai AS P
        LEFT JOIN users AS U ON U.ID_PEGAWAI = P.ID_PEGAWAI
        LEFT JOIN users_groups as UG on UG.user_id = U.id
        LEFT JOIN groups AS G ON G.id = UG.group_id
		LEFT JOIN fpb AS F ON F.CREATE_BY_USER = U.id 
		where F.ID_FPB = '$ID_FPB'");
		return $hasil->result();
	}

	// function FPB_barang_list_by_id_rasd($ID_RASD)
	// {
	// 	$hasil = $this->db->query("SELECT M.NAMA, RB.NAMA AS NAMA_RASD_FORM, RB.MEREK AS MEREK_RASD_FORM,RB.SPESIFIKASI_SINGKAT AS SPESIFIKASI_SINGKAT_RASD_FORM, RB.SATUAN_BARANG AS SATUAN_BARANG_RASD_FORM, M.KODE_BARANG, M.MEREK, J.NAMA_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, 
	// 	M.SATUAN_BARANG,RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, M.ID_BARANG_MASTER 
	// 	FROM FPB_form as RB
	// 	LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
	// 	LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
	//     WHERE RB.ID_RASD = '$ID_RASD'");
	// 	return $hasil->result();
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function cetak_pdf
	//         2. 
	function barang_master_where_not_in_FPB_and_rasd($ID_FPB)
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.KODE_BARANG, M.MEREK, M.HASH_MD5_BARANG_MASTER, M.PERALATAN_PERLENGKAPAN,
		J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
		M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
        WHERE 
        	NOT EXISTS 
            	(SELECT ID_BARANG_MASTER 
				FROM RASD_FORM 
				WHERE RASD_FORM.ID_BARANG_MASTER = M.ID_BARANG_MASTER 
				AND RASD_FORM.ID_RASD = (SELECT ID_RASD FROM fpb WHERE ID_FPB = '$ID_FPB'))
           	AND
            NOT EXISTS
            	(SELECT ID_BARANG_MASTER
                 FROM FPB_form
                 WHERE FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                 AND FPB_form.ID_FPB = '$ID_FPB')
            	");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function index
	//         2. controller FPB_form / function cetak_pdf
	function rasd_form_list_where_not_in_fpb($ID_FPB)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER, RB.PERALATAN_PERLENGKAPAN,
		RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, RB.NAMA,
        RB.MEREK, RB.SPESIFIKASI_SINGKAT,
        SB.NAMA_SATUAN_BARANG, SB.ID_SATUAN_BARANG,
        J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG
		FROM RASD_FORM as RB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG OR RB.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG OR RB.ID_SATUAN_BARANG = SB.ID_SATUAN_BARANG
		WHERE 
            NOT EXISTS
                (SELECT FPB_form.ID_RASD_FORM, FPB_form.ID_BARANG_MASTER
                 FROM FPB_form WHERE FPB_form.ID_RASD_FORM = RB.ID_RASD_FORM
                AND FPB_form.ID_FPB = '$ID_FPB')
        AND NOT EXISTS
        		(SELECT FPB_form.ID_BARANG_MASTER 
                 FROM FPB_form WHERE FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                AND FPB_form.ID_FPB='$ID_FPB')
		AND RB.ID_RASD = (SELECT ID_RASD FROM fpb WHERE ID_FPB = '$ID_FPB')");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menghapus data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function hapus_data
	//         2. 
	function hapus_data_by_id_FPB_form($ID_FPB_FORM)
	{
		$hasil = $this->db->query("DELETE FROM FPB_form WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function get_data
	//         2. controller FPB_form / function hapus_data
	//         3. controller FPB_form / function update_data
	function get_data_by_id_FPB_form($ID_FPB_FORM)
	{
		$hsl = $this->db->query("SELECT 
		FPB_form.ID_FPB_FORM, 
		FPB_form.NAMA_BARANG, 
		FPB_form.MEREK, 
		FPB_form.PERALATAN_PERLENGKAPAN, 
		FPB_form.REMARKS_CHIEF,
		FPB_form.SPESIFIKASI_SINGKAT, 
		FPB_form.JUMLAH_MINTA,
		FPB_form.BIDANG_PEMAKAI,
		FPB_form.TANGGAL_MULAI_PAKAI,
		FPB_form.TANGGAL_SELESAI_PAKAI,
		M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, RB.ID_RASD_FORM,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG
        FROM FPB_form
        LEFT JOIN barang_master AS M ON FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = FPB_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = FPB_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = FPB_form.ID_SATUAN_BARANG 
        WHERE FPB_form.ID_FPB_FORM = '$ID_FPB_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FPB_FORM' => $data->ID_FPB_FORM,
					'KODE_BARANG' => $data->KODE_BARANG,
					'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'JUMLAH_MINTA' => $data->JUMLAH_MINTA,
					'BIDANG_PEMAKAI' => $data->BIDANG_PEMAKAI,
					'REMARKS_CHIEF' => $data->REMARKS_CHIEF,
					'TANGGAL_MULAI_PAKAI' => $data->TANGGAL_MULAI_PAKAI,
					'TANGGAL_SELESAI_PAKAI' => $data->TANGGAL_SELESAI_PAKAI
				);
			}
		} else {
			$hasil = "BELUM ADA FPB Barang";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_justifikasi_barang
	//         2. 
	function get_justifikasi_by_id_FPB_form($ID_FPB_FORM)
	{
		$hsl = $this->db->query("SELECT 
		ID_FPB_FORM, 
		JUSTIFIKASI_CHIEF

		FROM FPB_FORM

        WHERE ID_FPB_FORM = '$ID_FPB_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FPB_FORM' => $data->ID_FPB_FORM,
					'JUSTIFIKASI_CHIEF' => $data->JUSTIFIKASI_CHIEF
				);
			}
		} else {
			$hasil = "TIDAK ADA JUSTIFIKASI";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function index
	//         2. controller FPB_form / function get_data_catatan_fpb
	//         3. controller FPB_form / function update_data_catatan_fpb
	//         4. controller FPB_form / function cetak_pdf
	function get_data_catatan_FPB_by_id_fpb($ID_FPB)
	{
		$hsl = $this->db->query("SELECT 
		ID_FPB, 
		CTT_PEMINTA,
		CTT_STAFF_GUDANG_LOGISTIK,
		CTT_CHIEF,
		CTT_SM

		FROM FPB

        WHERE ID_FPB = '$ID_FPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FPB' => $data->ID_FPB,
					'CTT_PEMINTA' => $data->CTT_PEMINTA,
					'CTT_STAFF_GUDANG_LOGISTIK' => $data->CTT_STAFF_GUDANG_LOGISTIK,
					'CTT_CHIEF' => $data->CTT_CHIEF,
					'CTT_SM' => $data->CTT_SM
				);
			}
		} else {
			$hasil = "TIDAK ADA CATATAN";
		}
		return $hasil;
	}

	function get_data_catatan_fpb_by_id_fpb_non_result($ID_FPB)
	{
		$hsl = $this->db->query("SELECT 
		ID_FPB, 
		CTT_PEMINTA,
		CTT_STAFF_GUDANG_LOGISTIK,
		CTT_CHIEF,
		CTT_SM

		FROM FPB

        WHERE ID_FPB = '$ID_FPB'");
		return $hsl;
	}

	function get_data_remaks_barang_by_id_fpb($ID_FPB)
	{
		$hsl = $this->db->query("SELECT 
		NAMA_BARANG,
        REMARKS_CHIEF,
		REMARKS_STAFF_GUDANG_LOGISTIK,
		REMARKS_SM

		FROM fpb_form

        WHERE ID_FPB = '$ID_FPB' AND (
            REMARKS_CHIEF IS NOT NULL OR 
            REMARKS_STAFF_GUDANG_LOGISTIK IS NOT NULL OR
            REMARKS_SM IS NOT NULL)");
		return $hsl->result();
	}

	function get_data_quantity_rasd_by_ID_RASD_FORM($ID_RASD_FORM)
	{
		$hasil = $this->db->query("SELECT RASD_FORM.JUMLAH_BARANG, RASD_FORM.TOTAL_PENGADAAN_SAAT_INI FROM rasd_form AS RASD_FORM
		LEFT JOIN fpb_form as FPB_FORM on FPB_FORM.ID_RASD_FORM = RASD_FORM.ID_RASD_FORM
		WHERE FPB_FORM.ID_RASD_FORM = '$ID_RASD_FORM'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan NAMA
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function simpan_data_di_luar_barang_master
	//         2. 
	function cek_nama_barang_FPB_form($NAMA, $ID_FPB)
	{
		$hsl = $this->db->query("SELECT ID_FPB_FORM, NAMA_BARANG AS NAMA FROM FPB_form WHERE NAMA_BARANG ='$NAMA' AND ID_FPB ='$ID_FPB' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FPB_FORM' => $data->ID_FPB_FORM,
					'NAMA' => $data->NAMA
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function update_quantity_sppb($ID_FPB_FORM, $JUMLAH_QTY_SPPB, $JUMLAH_QTY_GUDANG)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			JUMLAH_QTY_SPPB='$JUMLAH_QTY_SPPB', JUMLAH_QTY_GUDANG='$JUMLAH_QTY_GUDANG'
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	function update_status_sppb_by_id_fpb_form($ID_FPB_FORM, $ID_SPPB)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			STATUS_SPPB='Dalam Proses SPPB', KET_SPPB='$ID_SPPB'
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	function update_coret_status_sppb_by_id_fpb_form($ID_FPB_FORM, $ID_SPPB)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			STATUS_SPPB='DITOLAK', KET_SPPB='$ID_SPPB'
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	function update_batal_coret_status_sppb_by_id_fpb_form($ID_FPB_FORM, $ID_SPPB)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			STATUS_SPPB='DITERIMA', KET_SPPB='$ID_SPPB'
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	function update_delete_status_sppb_by_id_fpb_form($ID_FPB_FORM)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			STATUS_SPPB='', KET_SPPB=''
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_justifikasi_barang
	//         2. 
	function update_data_REMARKS_CHIEF($ID_FPB_FORM, $REMARKS_CHIEF)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			REMARKS_CHIEF='$REMARKS_CHIEF' 
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	function update_data_REMARKS_SM($ID_FPB_FORM, $REMARKS_SM)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			REMARKS_SM='$REMARKS_SM' 
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	function update_data_REMARKS_STAFF_GUDANG_LOGISTIK($ID_FPB_FORM, $REMARKS_STAFF_GUDANG_LOGISTIK)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			REMARKS_STAFF_GUDANG_LOGISTIK='$REMARKS_STAFF_GUDANG_LOGISTIK' 
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	function update_data_REMARKS_STAFF_UMUM_LOGISTIK($ID_FPB_FORM, $REMARKS_STAFF_UMUM_LOGISTIK)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			REMARKS_STAFF_UMUM_LOGISTIK='$REMARKS_STAFF_UMUM_LOGISTIK' 
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_coret
	//         2. 
	function update_data_coret($ID_FPB_FORM, $CATATAN_CORET)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			CORET = 1 , CATATAN_CORET = '$CATATAN_CORET'
			WHERE ID_FPB_FORM = '$ID_FPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_batal_coret
	//         2. 
	function update_data_batal_coret($ID_FPB_FORM, $CATATAN_BATAL_CORET)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			CORET = 0, CATATAN_BATAL_CORET = '$CATATAN_BATAL_CORET' 
			WHERE ID_FPB_FORM = '$ID_FPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_catatan_fpb
	//         2. 
	function update_data_CTT_PEMINTA($ID_FPB, $CTT_PEMINTA)
	{
		$hasil = $this->db->query("UPDATE fpb SET CTT_PEMINTA='$CTT_PEMINTA' WHERE ID_FPB='$ID_FPB'");
		return $hasil;
	}

	function update_data_CTT_STAFF_GUDANG_LOGISTIK($ID_FPB, $CTT_STAFF_GUDANG_LOGISTIK)
	{
		$hasil = $this->db->query("UPDATE fpb SET CTT_STAFF_GUDANG_LOGISTIK='$CTT_STAFF_GUDANG_LOGISTIK' WHERE ID_FPB='$ID_FPB'");
		return $hasil;
	}

	function update_data_CTT_CHIEF($ID_FPB, $CTT_CHIEF)
	{
		$hasil = $this->db->query("UPDATE fpb SET CTT_CHIEF='$CTT_CHIEF' WHERE ID_FPB='$ID_FPB'");
		return $hasil;
	}

	function update_data_CTT_SM($ID_FPB, $CTT_SM)
	{
		$hasil = $this->db->query("UPDATE fpb SET CTT_SM='$CTT_SM' WHERE ID_FPB='$ID_FPB'");
		return $hasil;
	}

	function simpan_tanggal($ID_FPB, $TANGGAL_MULAI_PAKAI, $TANGGAL_SELESAI_PAKAI, $BIDANG_PEMAKAI)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET
			TANGGAL_MULAI_PAKAI='$TANGGAL_MULAI_PAKAI',
			TANGGAL_SELESAI_PAKAI='$TANGGAL_SELESAI_PAKAI' ,
			BIDANG_PEMAKAI='$BIDANG_PEMAKAI'
			WHERE ID_FPB='$ID_FPB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data
	//         2. 
	function update_data($ID_FPB_FORM, $JUMLAH_BARANG, $PERALATAN_PERLENGKAPAN, $BIDANG_PEMAKAI, $TANGGAL_MULAI_PAKAI, $TANGGAL_SELESAI_PAKAI)
	{
		
		$hasil = $this->db->query("UPDATE FPB_form SET 
			JUMLAH_MINTA='$JUMLAH_BARANG',
			PERALATAN_PERLENGKAPAN='$PERALATAN_PERLENGKAPAN',
			BIDANG_PEMAKAI='$BIDANG_PEMAKAI',
			TANGGAL_MULAI_PAKAI='$TANGGAL_MULAI_PAKAI',
			TANGGAL_SELESAI_PAKAI='$TANGGAL_SELESAI_PAKAI' 
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data
	//         2. 
	function update_data_by_user_sm($ID_FPB_FORM, $JUMLAH_BARANG, $PERALATAN_PERLENGKAPAN, $BIDANG_PEMAKAI, $TANGGAL_MULAI_PAKAI, $TANGGAL_SELESAI_PAKAI)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET 
			JUMLAH_MINTA='$JUMLAH_BARANG',
			PERALATAN_PERLENGKAPAN='$PERALATAN_PERLENGKAPAN',
			BIDANG_PEMAKAI='$BIDANG_PEMAKAI',
			TANGGAL_MULAI_PAKAI='$TANGGAL_MULAI_PAKAI',
			TANGGAL_SELESAI_PAKAI='$TANGGAL_SELESAI_PAKAI' 
			WHERE ID_FPB_FORM='$ID_FPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_kirim_fpb
	//         2. 
	function update_data_kirim_fpb($ID_FPB, $PROGRESS_FPB, $STATUS_FPB, $TANGGAL_PENGAJUAN_FPB, $SIGN_USER_PEMINTA, $DUE_DATE_STAFF_LOGISTIK)
	{
		$hasil = $this->db->query("UPDATE fpb SET 
			PROGRESS_FPB='$PROGRESS_FPB',
			STATUS_FPB='$STATUS_FPB',
			TANGGAL_PENGAJUAN_FPB='$TANGGAL_PENGAJUAN_FPB',
			SIGN_USER_PEMINTA='$SIGN_USER_PEMINTA',
			DUE_DATE_STAFF_LOGISTIK='$DUE_DATE_STAFF_LOGISTIK'
			WHERE ID_FPB='$ID_FPB'");
		return $hasil;
	}

	function update_data_kirim_fpb_STAFF_LOGISTIK($ID_FPB, $PROGRESS_FPB, $STATUS_FPB, $SIGN_STAFF_LOGISTIK, $DUE_DATE_CHIEF, $DUE_DATE_SM)
	{
		$hasil = $this->db->query("UPDATE fpb SET 
			PROGRESS_FPB='$PROGRESS_FPB',
			STATUS_FPB='$STATUS_FPB',
			SIGN_STAFF_LOGISTIK='$SIGN_STAFF_LOGISTIK',
			DUE_DATE_CHIEF='$DUE_DATE_CHIEF',
			DUE_DATE_SM='$DUE_DATE_SM'
			WHERE ID_FPB='$ID_FPB'");
		return $hasil;
	}

	function update_data_gudang_fpb($ID_FPB, $PROGRESS_FPB, $STATUS_FPB)
	{
		$hasil = $this->db->query("UPDATE fpb SET 
			PROGRESS_FPB='$PROGRESS_FPB',
			STATUS_FPB='$STATUS_FPB'
			WHERE ID_FPB='$ID_FPB'");
		return $hasil;
	}

	function update_data_kirim_fpb_finish($ID_FPB, $PROGRESS_FPB, $STATUS_FPB, $SIGN_CHIEF, $SIGN_SM)
	{
		$hasil = $this->db->query("UPDATE fpb_form SET
			STATUS_FPB='SELESAI'
			WHERE ID_FPB='$ID_FPB'");
		$hasil = $this->db->query("UPDATE fpb SET 
			PROGRESS_FPB='$PROGRESS_FPB',
			STATUS_FPB='$STATUS_FPB',
			SIGN_CHIEF='$SIGN_CHIEF',
			SIGN_SM='$SIGN_SM'
			WHERE ID_FPB='$ID_FPB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function simpan_data_dari_rasd_form
	//         2. 
	function simpan_data_dari_rasd_form(
		$ID_FPB,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO FPB_form (
				ID_FPB,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA)
			VALUES(
				'$ID_FPB',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function simpan_data_dari_barang_master
	//         2. 
	function simpan_data_dari_barang_master(
		$ID_FPB,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO FPB_form (
				ID_FPB,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA)
			VALUES(
				'$ID_FPB',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function simpan_data_di_luar_barang_master
	//         2. 
	function simpan_data_di_luar_barang_master(
		$ID_FPB,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$TANGGAL_MULAI_PAKAI,
		$TANGGAL_SELESAI_PAKAI
	) {
		$hasil = $this->db->query("INSERT INTO FPB_form (
				ID_FPB,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA,
				TANGGAL_MULAI_PAKAI,
				TANGGAL_SELESAI_PAKAI
				)
			VALUES(
				'$ID_FPB',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG',
				'$TANGGAL_MULAI_PAKAI',
				'$TANGGAL_SELESAI_PAKAI' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_tanggal
	//         2. 
	function update_data_tanggal($id, $field, $value)
	{
		$hasil = $this->db->query("UPDATE FPB_form SET $field='$value' WHERE ID_FPB_FORM ='$id'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function logout
	//         2. controller FPB_form / function user_log
	function user_log_fpb_form($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_fpb_form (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}

	function coba($ID_FPB)
	{
		$hasil = $this->db->query("SELECT ID_FPB_FORM, ID_FPB, NAMA_BARANG FROM fpb_form
		WHERE ID_FPB ='$ID_FPB'");
		return $hasil;
	}
}
