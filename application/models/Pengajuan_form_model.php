<?php
class Pengajuan_form_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb form
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function data_sppb_form
	//         2. 

	function data_barang_bantuan_form($ID_FORM_INVENTARIS_KORBAN_BENCANA)
	{
		$hasil = $this->db->query("SELECT * FROM item_form_pengajuan_barang WHERE ID_FORM_INVENTARIS_KORBAN_BENCANA = '$ID_FORM_INVENTARIS_KORBAN_BENCANA'");
		return $hasil->result();
	}

	function sppb_form_list_by_id_sppb($ID_SPPB, $ID_RAB_FORM)
	{
		$hasil = $this->db->query("SELECT 
		sppb_form.ID_SPPB, 
		sppb_form.ID_SPPB_FORM,
		sppb_form.ID_FPB_FORM,
		sppb_form.ID_RASD_FORM,
		sppb_form.ID_RAB_FORM,
		sppb_form.ID_PROYEK_SUB_PEKERJAAN,
		sppb_form.NAMA_BARANG,
		sppb_form.SATUAN_BARANG,
		sppb_form.MEREK,
		sppb_form.ID_KLASIFIKASI_BARANG,
		sppb_form.PERALATAN_PERLENGKAPAN,
		sppb_form.SPESIFIKASI_SINGKAT, 
		sppb_form.JUMLAH_MINTA,
		sppb_form.BIDANG_PEMAKAI,
		sppb_form.CORET,
		sppb_form.CATATAN_CORET,
		sppb_form.CATATAN_BATAL_CORET,
		sppb_form.KETERANGAN_UMUM,
		sppb_form.POSISI,
		sppb_form.JUMLAH_SETUJU_TERAKHIR,
		sppb_form.JUMLAH_SETUJU_STAFF_LOG,
		sppb_form.JUMLAH_SETUJU_TERAKHIR,
		sppb_form.JUMLAH_SETUJU_SPV_LOG,
		sppb_form.JUMLAH_SETUJU_CHIEF,
		sppb_form.JUMLAH_SETUJU_SM,
		sppb_form.JUMLAH_SETUJU_PM,
		sppb_form.JUMLAH_SETUJU_M_LOG,
		sppb_form.JUMLAH_SETUJU_M_PROC,
		sppb_form.JUMLAH_SETUJU_M_SDM,
		sppb_form.JUMLAH_SETUJU_M_KONS,
		sppb_form.JUMLAH_SETUJU_M_EP,
		sppb_form.JUMLAH_SETUJU_M_QAQC,
		sppb_form.JUMLAH_SETUJU_M_KEU,
		sppb_form.JUMLAH_SETUJU_D_PSDS,
		sppb_form.JUMLAH_SETUJU_D_KEU,
		sppb_form.JUMLAH_SETUJU_D_KEU,
		sppb_form.TOLAK_SPV_LOG,
		sppb_form.TOLAK_SM,
		sppb_form.TOLAK_PM,
		sppb_form.TOLAK_M_LOG,
		sppb_form.TOLAK_M_PROC,
		sppb_form.TOLAK_M_SDM,
		sppb_form.TOLAK_M_KONS,
		sppb_form.TOLAK_M_EP,
		sppb_form.TOLAK_M_QAQC,
		sppb_form.TOLAK_M_KEU,
		sppb_form.TOLAK_D_PSDS,
		sppb_form.TOLAK_D_KONS,
		sppb_form.TOLAK_D_KEU,
		sppb_form.COMPLETE,
		DATE_FORMAT(sppb_form.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI,
		DATE_FORMAT(sppb_form.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI,
		sppb_form.TANGGAL_MULAI_PAKAI_HARI AS TANGGAL_MULAI_PAKAI_HARI_INDO,
		sppb_form.TANGGAL_SELESAI_PAKAI_HARI AS TANGGAL_SELESAI_PAKAI_HARI_INDO,
		sppb_form.JUMLAH_QTY_GUDANG,
		sppb_form.JUMLAH_QTY_SPP,
		M.ID_BARANG_MASTER, 
		M.KODE_BARANG, 
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, 
		RB.ID_RASD_FORM, 
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
		SPB.ID_PROYEK,
		SPB.SIGN_USER_STAFF_UMUM_LOG_SP,
		SPB.SIGN_USER_CHIEF_SP,
		SPB.SIGN_USER_SM_SP,
		SPB.SIGN_USER_PM_SP,
		SPB.SIGN_USER_M_HRD_KP,
		SPB.SIGN_USER_M_KEU_KP,
		SPB.SIGN_USER_M_KONS_KP,
		SPB.SIGN_USER_M_SDM_KP,
		SPB.SIGN_USER_M_QAQC_KP,
		SPB.SIGN_USER_M_EP_KP,
		SPB.SIGN_USER_M_HSSE_KP,
		SPB.SIGN_USER_M_KOMERSIAL_KP,
		SPB.SIGN_USER_M_LOG_KP,
		SPB.SIGN_USER_D_KEU_KP,
		SPB.SIGN_USER_D_EP_KONS_KP,
		SPB.SIGN_USER_D_PSDS_KP,
        FF.ID_FPB,
        FB.HASH_MD5_FPB,
        FB.NO_URUT_FPB,
		RABF.NAMA_KATEGORI,
		KB.NAMA_KLASIFIKASI_BARANG
        FROM sppb_form
        LEFT JOIN barang_master AS M ON sppb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = sppb_form.ID_RASD_FORM
        LEFT JOIN FPB_FORM AS FF ON FF.ID_FPB_FORM = sppb_form.ID_FPB_FORM
        LEFT JOIN FPB AS FB ON FF.ID_FPB = FB.ID_FPB
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = sppb_form.ID_JENIS_BARANG
        LEFT JOIN sppb as SPB ON SPB.ID_SPPB = sppb_form.ID_SPPB
		LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = sppb_form.ID_RAB_FORM
		LEFT JOIN klasifikasi_barang as KB ON KB.ID_KLASIFIKASI_BARANG = sppb_form.ID_KLASIFIKASI_BARANG
        WHERE sppb_form.ID_SPPB = '$ID_SPPB' AND sppb_form.ID_RAB_FORM = '$ID_RAB_FORM'
		ORDER BY sppb_form.NAMA_BARANG ASC");
		return $hasil->result();
	}

	function sppb_form_file_list_by_id_sppb($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT * 
        FROM sppb_form_file
        WHERE ID_SPPB = '$ID_SPPB'");
		return $hasil->result();
	}

	function SPPB_form_list_by_id_sppb_form($ID_SPPB_FORM)
	{
		$hasil = $this->db->query("SELECT 
		SPPB_form.ID_SPPB, 
		SPPB_form.ID_SPPB_FORM,
        SPPB_form.ID_BARANG_MASTER,
        SPPB_form.ID_JENIS_BARANG,
		SPPB_form.NAMA_BARANG, 
		SPPB_form.MEREK,
		SPPB_form.PERALATAN_PERLENGKAPAN,
		SPPB_form.SPESIFIKASI_SINGKAT, 
		SPPB_form.JUMLAH_MINTA,
		SPPB_form.JUMLAH_QTY_SPP, 
		SPPB_form.CORET, 
		DATE_FORMAT(sppb_form.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI,
		DATE_FORMAT(sppb_form.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI,
        S.CREATE_BY_USER,
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
        S.ID_PROYEK
        FROM SPPB_form
        LEFT JOIN barang_master AS M ON SPPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = SPPB_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = SPPB_form.ID_JENIS_BARANG
        LEFT JOIN sppb AS S ON S.ID_SPPB = SPPB_form.ID_SPPB
        LEFT JOIN users AS U ON U.id = S.CREATE_BY_USER
        LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = U.ID_PEGAWAI
        WHERE SPPB_form.ID_SPPB_FORM = '$ID_SPPB_FORM'
		ORDER BY J.NAMA_JENIS_BARANG ASC");
		return $hasil->row();
	}

	function sppb_form_list_by_id_sppb_non_result($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT sppb_form.ID_SPPB, 
		sppb_form.ID_SPPB_FORM,
        sppb_form.ID_FPB_FORM,
		sppb_form.NAMA_BARANG,
		sppb_form.MEREK, 
		sppb_form.PERALATAN_PERLENGKAPAN, 
		sppb_form.SPESIFIKASI_SINGKAT, 
		sppb_form.JUMLAH_MINTA,
		sppb_form.BIDANG_PEMAKAI,
		sppb_form.CORET,
		sppb_form.CATATAN_CORET,
		sppb_form.CATATAN_BATAL_CORET, 
		sppb_form.POSISI,
		sppb_form.JUMLAH_SETUJU_TERAKHIR,
		sppb_form.JUMLAH_SETUJU_STAFF_LOG,
		sppb_form.JUMLAH_SETUJU_TERAKHIR,
		sppb_form.JUMLAH_SETUJU_SPV_LOG,
		sppb_form.JUMLAH_SETUJU_CHIEF,
		sppb_form.JUMLAH_SETUJU_SM,
		sppb_form.JUMLAH_SETUJU_PM,
		sppb_form.JUMLAH_SETUJU_M_LOG,
		sppb_form.JUMLAH_SETUJU_M_PROC,
		sppb_form.JUMLAH_SETUJU_M_SDM,
		sppb_form.JUMLAH_SETUJU_M_KONS,
		sppb_form.JUMLAH_SETUJU_M_EP,
		sppb_form.JUMLAH_SETUJU_M_QAQC,
		sppb_form.JUMLAH_SETUJU_M_KEU,
		sppb_form.JUMLAH_SETUJU_D_PSDS,
		sppb_form.JUMLAH_SETUJU_D_KEU,
		sppb_form.JUMLAH_SETUJU_D_KEU,
		sppb_form.TOLAK_SPV_LOG,
		sppb_form.TOLAK_SM,
		sppb_form.TOLAK_PM,
		sppb_form.TOLAK_M_LOG,
		sppb_form.TOLAK_M_PROC,
		sppb_form.TOLAK_M_SDM,
		sppb_form.TOLAK_M_KONS,
		sppb_form.TOLAK_M_EP,
		sppb_form.TOLAK_M_QAQC,
		sppb_form.TOLAK_M_KEU,
		sppb_form.TOLAK_D_PSDS,
		sppb_form.TOLAK_D_KONS,
		sppb_form.TOLAK_D_KEU,
		DATE_FORMAT(sppb_form.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI,
		DATE_FORMAT(sppb_form.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI,
		sppb_form.JUMLAH_QTY_GUDANG,
		sppb_form.JUMLAH_QTY_SPP,
		M.ID_BARANG_MASTER, 
		M.KODE_BARANG, 
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, 
		RB.ID_RASD_FORM, 
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
        SPB.ID_RASD AS ID_RASD_MASTER,
		SPB.ID_PROYEK,
		SPB.SIGN_USER_STAFF_UMUM_LOG_SP,
		SPB.SIGN_USER_CHIEF_SP,
		SPB.SIGN_USER_SM_SP,
		SPB.SIGN_USER_PM_SP,
		SPB.SIGN_USER_M_HRD_KP,
		SPB.SIGN_USER_M_KEU_KP,
		SPB.SIGN_USER_M_KONS_KP,
		SPB.SIGN_USER_M_SDM_KP,
		SPB.SIGN_USER_M_QAQC_KP,
		SPB.SIGN_USER_M_EP_KP,
		SPB.SIGN_USER_M_HSSE_KP,
		SPB.SIGN_USER_M_KOMERSIAL_KP,
		SPB.SIGN_USER_M_LOG_KP,
		SPB.SIGN_USER_D_KEU_KP,
		SPB.SIGN_USER_D_EP_KONS_KP,
		SPB.SIGN_USER_D_PSDS_KP,
        FF.ID_FPB,
        FB.HASH_MD5_FPB,
        FB.NO_URUT_FPB
        FROM sppb_form
        LEFT JOIN barang_master AS M ON sppb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = sppb_form.ID_RASD_FORM
        LEFT JOIN FPB_FORM AS FF ON FF.ID_FPB_FORM = sppb_form.ID_FPB_FORM
        LEFT JOIN FPB AS FB ON FF.ID_FPB = FB.ID_FPB
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = sppb_form.ID_JENIS_BARANG
        LEFT JOIN sppb as SPB ON SPB.ID_SPPB = sppb_form.ID_SPPB
        WHERE sppb_form.ID_SPPB = '$ID_SPPB'");
		return $hasil;
	}

	function sppb_form_list_by_id_sppb_kirim_SPPB($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT 
		sppb_form.ID_SPPB, 
		sppb_form.ID_SPPB_FORM,
		sppb_form.ID_FPB_FORM,
		sppb_form.ID_RASD_FORM,
		sppb_form.ID_RAB_FORM,
		sppb_form.ID_PROYEK_SUB_PEKERJAAN,
		sppb_form.NAMA_BARANG,
		sppb_form.SATUAN_BARANG,
		sppb_form.MEREK,
		sppb_form.ID_KLASIFIKASI_BARANG,
		sppb_form.PERALATAN_PERLENGKAPAN,
		sppb_form.SPESIFIKASI_SINGKAT, 
		sppb_form.JUMLAH_MINTA,
		sppb_form.BIDANG_PEMAKAI,
		sppb_form.CORET,
		sppb_form.CATATAN_CORET,
		sppb_form.CATATAN_BATAL_CORET,
		sppb_form.KETERANGAN_UMUM,
		sppb_form.POSISI,
		sppb_form.JUMLAH_SETUJU_TERAKHIR,
		sppb_form.JUMLAH_SETUJU_STAFF_LOG,
		sppb_form.JUMLAH_SETUJU_TERAKHIR,
		sppb_form.JUMLAH_SETUJU_SPV_LOG,
		sppb_form.JUMLAH_SETUJU_CHIEF,
		sppb_form.JUMLAH_SETUJU_SM,
		sppb_form.JUMLAH_SETUJU_PM,
		sppb_form.JUMLAH_SETUJU_M_LOG,
		sppb_form.JUMLAH_SETUJU_M_PROC,
		sppb_form.JUMLAH_SETUJU_M_SDM,
		sppb_form.JUMLAH_SETUJU_M_KONS,
		sppb_form.JUMLAH_SETUJU_M_EP,
		sppb_form.JUMLAH_SETUJU_M_QAQC,
		sppb_form.JUMLAH_SETUJU_M_KEU,
		sppb_form.JUMLAH_SETUJU_D_PSDS,
		sppb_form.JUMLAH_SETUJU_D_KEU,
		sppb_form.JUMLAH_SETUJU_D_KEU,
		sppb_form.TOLAK_SPV_LOG,
		sppb_form.TOLAK_SM,
		sppb_form.TOLAK_PM,
		sppb_form.TOLAK_M_LOG,
		sppb_form.TOLAK_M_PROC,
		sppb_form.TOLAK_M_SDM,
		sppb_form.TOLAK_M_KONS,
		sppb_form.TOLAK_M_EP,
		sppb_form.TOLAK_M_QAQC,
		sppb_form.TOLAK_M_KEU,
		sppb_form.TOLAK_D_PSDS,
		sppb_form.TOLAK_D_KONS,
		sppb_form.TOLAK_D_KEU,
		DATE_FORMAT(sppb_form.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI,
		DATE_FORMAT(sppb_form.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI,
		sppb_form.JUMLAH_QTY_GUDANG,
		sppb_form.JUMLAH_QTY_SPP,
		M.ID_BARANG_MASTER, 
		M.KODE_BARANG, 
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, 
		RB.ID_RASD_FORM, 
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
		SPB.ID_PROYEK,
		SPB.SIGN_USER_STAFF_UMUM_LOG_SP,
		SPB.SIGN_USER_CHIEF_SP,
		SPB.SIGN_USER_SM_SP,
		SPB.SIGN_USER_PM_SP,
		SPB.SIGN_USER_M_HRD_KP,
		SPB.SIGN_USER_M_KEU_KP,
		SPB.SIGN_USER_M_KONS_KP,
		SPB.SIGN_USER_M_SDM_KP,
		SPB.SIGN_USER_M_QAQC_KP,
		SPB.SIGN_USER_M_EP_KP,
		SPB.SIGN_USER_M_HSSE_KP,
		SPB.SIGN_USER_M_KOMERSIAL_KP,
		SPB.SIGN_USER_M_LOG_KP,
		SPB.SIGN_USER_D_KEU_KP,
		SPB.SIGN_USER_D_EP_KONS_KP,
		SPB.SIGN_USER_D_PSDS_KP,
		SPB.CTT_DEPT_PROC,
        FF.ID_FPB,
        FB.HASH_MD5_FPB,
        FB.NO_URUT_FPB,
		RABF.NAMA_KATEGORI,
		KB.NAMA_KLASIFIKASI_BARANG
        FROM sppb_form
        LEFT JOIN barang_master AS M ON sppb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = sppb_form.ID_RASD_FORM
        LEFT JOIN FPB_FORM AS FF ON FF.ID_FPB_FORM = sppb_form.ID_FPB_FORM
        LEFT JOIN FPB AS FB ON FF.ID_FPB = FB.ID_FPB
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = sppb_form.ID_JENIS_BARANG
        LEFT JOIN sppb as SPB ON SPB.ID_SPPB = sppb_form.ID_SPPB
		LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = sppb_form.ID_RAB_FORM
		LEFT JOIN klasifikasi_barang as KB ON KB.ID_KLASIFIKASI_BARANG = sppb_form.ID_KLASIFIKASI_BARANG
        WHERE sppb_form.ID_SPPB = '$ID_SPPB'
		ORDER BY sppb_form.NAMA_BARANG ASC");
		return $hasil->result();
	}

	function data_grup_rab_sppb_form($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT distinct
		sppb_form.ID_RAB_FORM,
        RABF.NAMA_KATEGORI
        FROM sppb_form
        LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = sppb_form.ID_RAB_FORM
        WHERE sppb_form.ID_SPPB = '$ID_SPPB' ORDER BY sppb_form.ID_RAB_FORM ASC");
		return $hasil->result();
	}

	function sign_sppb_by_id_sppb_non_result($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT SIGN_USER_STAFF_UMUM_LOG_SP,
		SIGN_USER_CHIEF_SP,
		SIGN_USER_SM_SP,
		SIGN_USER_PM_SP,
		SIGN_USER_M_HRD_KP,
		SIGN_USER_M_KEU_KP,
		SIGN_USER_M_KONS_KP,
		SIGN_USER_M_SDM_KP,
		SIGN_USER_M_QAQC_KP,
		SIGN_USER_M_EP_KP,
		SIGN_USER_M_HSSE_KP,
		SIGN_USER_M_KOMERSIAL_KP,
		SIGN_USER_M_LOG_KP,
		SIGN_USER_D_KEU_KP,
		SIGN_USER_D_EP_KONS_KP,
		SIGN_USER_D_PSDS_KP
        FROM sppb
        WHERE ID_SPPB = '$ID_SPPB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb form berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function sppb_barang_list_by_id_rasd($ID_RASD)
	{
		$hasil = $this->db->query("SELECT M.NAMA, RB.NAMA AS NAMA_RASD_FORM, RB.MEREK AS MEREK_RASD_FORM,RB.SPESIFIKASI_SINGKAT AS SPESIFIKASI_SINGKAT_RASD_FORM, M.KODE_BARANG, M.MEREK, J.NAMA_JENIS_BARANG, M.SPESIFIKASI_SINGKAT,RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, M.ID_BARANG_MASTER 
		FROM sppb_form as RB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
        WHERE RB.ID_RASD = '$ID_RASD'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller SPPB_form / function index
	//         2. controller SPPB-form / function view_only
	function barang_master_where_not_in_sppb_and_rasd($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.KODE_BARANG, M.MEREK, M.HASH_MD5_BARANG_MASTER, M.PERALATAN_PERLENGKAPAN,
		J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, 
		M.ID_BARANG_MASTER
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
        WHERE 
        	NOT EXISTS 
            	(SELECT ID_BARANG_MASTER 
				FROM RASD_FORM 
				WHERE RASD_FORM.ID_BARANG_MASTER = M.ID_BARANG_MASTER 
				AND RASD_FORM.ID_RASD = (SELECT ID_RASD FROM sppb WHERE ID_SPPB = '$ID_SPPB'))
           	AND
            NOT EXISTS
            	(SELECT ID_BARANG_MASTER
                 FROM sppb_form
                 WHERE sppb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                 AND sppb_form.ID_SPPB = '$ID_SPPB')
            	");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB
	//SUMBER TABEL: tabel RASD_FORM
	//DIPAKAI: 1. controller SPPB_form / function index
	//         2. controller SPPB-form / function view_only
	function rasd_form_list_where_not_in_sppb($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER,
		RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, RB.NAMA,
        RB.MEREK, RB.SPESIFIKASI_SINGKAT
		FROM RASD_FORM as RB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
		WHERE 
            NOT EXISTS
                (SELECT sppb_form.ID_RASD_FORM, sppb_form.ID_BARANG_MASTER
                 FROM sppb_form WHERE sppb_form.ID_RASD_FORM = RB.ID_RASD_FORM
                AND sppb_form.ID_SPPB = '$ID_SPPB')
        AND NOT EXISTS
        		(SELECT sppb_form.ID_BARANG_MASTER 
                 FROM sppb_form WHERE sppb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                AND sppb_form.ID_SPPB='$ID_SPPB')
		AND RB.ID_RASD = (SELECT ID_RASD FROM sppb WHERE ID_SPPB = '$ID_SPPB')");
		return $hasil->result();
	}

	function get_data_id_rasd_form_by_id_rasd($ID_RASD)
	{
		$hasil = $this->db->query("SELECT * FROM rasd_form where ID_RASD  ='$ID_RASD' ORDER BY rasd_form.NAMA ASC");
		return $hasil->result();
	}

	function fpb_form_list_where_not_in_sppb($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER, F.ID_FPB, FP.NO_URUT_FPB, FP.HASH_MD5_FPB,
		F.ID_FPB_FORM, F.JUMLAH_MINTA, F.JUMLAH_QTY_SPPB, F.NAMA_BARANG, F.PERALATAN_PERLENGKAPAN,
        F.MEREK, F.SPESIFIKASI_SINGKAT, F.STATUS_FPB, F.CORET,
        J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, FP.ID_PROYEK
		FROM FPB_FORM as F
        LEFT JOIN fpb as FP ON F.ID_FPB=FP.ID_FPB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=F.ID_BARANG_MASTER 
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG OR F.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		WHERE 
            NOT EXISTS
                (SELECT sppb_form.ID_FPB_FORM, sppb_form.ID_BARANG_MASTER
                 FROM sppb_form WHERE sppb_form.ID_FPB_FORM = F.ID_FPB_FORM
                AND sppb_form.ID_SPPB = '$ID_SPPB')
        AND F.STATUS_FPB = 'SELESAI' AND F.CORET <> 1 AND F.JUMLAH_QTY_SPPB > 0 AND F.STATUS_SPPB = '' AND F.KET_SPPB = '' AND FP.ID_PROYEK = (SELECT sppb.ID_PROYEK FROM sppb where sppb.ID_SPPB = '$ID_SPPB')");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menghapus data sppb form ID_SPPB_FORM
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function hapus_data
	//         2. 
	function hapus_data_by_id_sppb_form($ID_SPPB_FORM)
	{
		$hasil = $this->db->query("DELETE FROM sppb_form WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}


	function hapus_data_by_id_item_form_pengajuan_barang($ID_ITEM_FORM_PENGAJUAN_BARANG)
	{
		$hasil = $this->db->query("DELETE FROM item_form_pengajuan_barang WHERE ID_ITEM_FORM_PENGAJUAN_BARANG='$ID_ITEM_FORM_PENGAJUAN_BARANG'");
		return $hasil;
	}

	function hapus_data_by_id_sppb($ID_SPPB)
	{
		$hasil = $this->db->query("DELETE FROM sppb_form WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function data_spp_form_by_id_sppb_form($ID_SPPB_FORM)
	{
		$hasil = $this->db->query("SELECT ID_SPP, JUMLAH_BARANG, SATUAN_BARANG from spp_form WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil->result();
	}

	function data_spp_by_id_spp($ID_SPP)
	{
		$hasil = $this->db->query("SELECT NO_URUT_SPP, HASH_MD5_SPP from spp WHERE ID_SPP='$ID_SPP'");
		return $hasil->result();
	}

	function data_po_form_by_id_sppb_form($ID_SPPB_FORM)
	{
		$hasil = $this->db->query("SELECT ID_PO, JUMLAH_BARANG, SATUAN_BARANG from po_form WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil->result();
	}

	function data_po_by_id_po($ID_PO)
	{
		$hasil = $this->db->query("SELECT NO_URUT_PO, HASH_MD5_PO from po WHERE ID_PO='$ID_PO'");
		return $hasil->result();
	}

	function data_fstb_form_by_id_sppb_form($ID_SPPB_FORM)
	{
		$hasil = $this->db->query("SELECT ID_FSTB, JUMLAH_DITERIMA, JUMLAH_DITERIMA_SYARAT, SATUAN_BARANG from fstb_form WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil->result();
	}

	function data_fstb_by_id_fstb($ID_FSTB)
	{
		$hasil = $this->db->query("SELECT NO_URUT_FSTB, HASH_MD5_FSTB from fstb WHERE ID_FSTB='$ID_FSTB'");
		return $hasil->result();
	}

	function data_quantity_rasd_by_ID_RASD_FORM($ID_RASD_FORM)
	{
		$hasil = $this->db->query("SELECT JUMLAH_BARANG AS jumlah_quantity_rasd, NAMA, TOTAL_PENGADAAN_SAAT_INI from rasd_form WHERE ID_RASD_FORM='$ID_RASD_FORM'");
		return $hasil->result();
	}

	function data_quantity_rasd_realisasi_by_ID_RASD_FORM($ID_RASD_FORM)
	{
		$hasil = $this->db->query("SELECT SUM(JUMLAH_BARANG) AS JUMLAH_BARANG from rasd_realisasi WHERE ID_RASD_FORM='$ID_RASD_FORM'");
		return $hasil->result();
	}

	function data_quantity_barang_entitas_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT COUNT(JUMLAH_BARANG) AS jumlah_quantity, POSISI from barang_entitas WHERE (ID_BARANG_MASTER='$ID_BARANG_MASTER' AND ID_PROYEK= '1' AND POSISI= 'GUDANG' AND KONDISI='DAPAT DIGUNAKAN')");
		return $hasil->result();
	}

	function data_quantity_barang_entitas_consum_material_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT SUM(JUMLAH_BARANG) AS jumlah_quantity, POSISI from barang_entitas WHERE (ID_BARANG_MASTER='$ID_BARANG_MASTER' AND ID_PROYEK= '1' AND POSISI= 'GUDANG' AND KONDISI='DAPAT DIGUNAKAN')");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB_FORM
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function get_data
	//         2. controller SPPB_form / function hapus_data
	//		   3. controller SPPB_form / function update_data
	function get_data_by_id_sppb_form($ID_SPPB_FORM)
	{
		$hsl = $this->db->query("SELECT 
		sppb_form.ID_SPPB_FORM,
		sppb_form.ID_FPB_FORM,
		sppb_form.ID_PROYEK_SUB_PEKERJAAN,
		sppb_form.ID_RAB_FORM,
		sppb_form.NAMA_BARANG,
		sppb_form.SATUAN_BARANG,
		sppb_form.MEREK, 
		sppb_form.PERALATAN_PERLENGKAPAN, 
		sppb_form.KETERANGAN_STAFF_UMUM_LOG_SP,
		sppb_form.KETERANGAN_SVP_LOG_SP,
		sppb_form.KETERANGAN_CHIEF,
		sppb_form.KETERANGAN_SM,
		sppb_form.KETERANGAN_PM,
		sppb_form.KETERANGAN_STAFF_LOG_KP,
		sppb_form.KETERANGAN_STAFF_GUDANG_LOG_KP,
		sppb_form.KETERANGAN_KASIE_LOG_KP,
		sppb_form.KETERANGAN_M_LOG,
		sppb_form.KETERANGAN_M_SDM,
		sppb_form.KETERANGAN_M_KONS,
		sppb_form.KETERANGAN_M_EP,
		sppb_form.KETERANGAN_M_QAQC,
		sppb_form.KETERANGAN_M_KEU,
		sppb_form.KETERANGAN_M_HRD,
		sppb_form.KETERANGAN_M_HSSE,
		sppb_form.KETERANGAN_M_MARKETING,
		sppb_form.KETERANGAN_M_KOMERSIAL,
		sppb_form.KETERANGAN_D_PSDS,
		sppb_form.KETERANGAN_D_EP_KONS,
		sppb_form.KETERANGAN_D_KEU,
		sppb_form.KETERANGAN_UMUM,
		sppb_form.SPESIFIKASI_SINGKAT, 
		sppb_form.JUMLAH_MINTA,
		sppb_form.JUMLAH_QTY_SPP,
		sppb_form.BIDANG_PEMAKAI,
		sppb_form.ID_RASD_FORM,
		DATE_FORMAT(sppb_form.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI,
		DATE_FORMAT(sppb_form.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI,
		M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD,
        J.NAMA_JENIS_BARANG,
		KB.NAMA_KLASIFIKASI_BARANG,
		sppb_form.ID_KLASIFIKASI_BARANG
        FROM sppb_form
        LEFT JOIN barang_master AS M ON sppb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = sppb_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = sppb_form.ID_JENIS_BARANG
		LEFT JOIN klasifikasi_barang as KB ON KB.ID_KLASIFIKASI_BARANG = sppb_form.ID_KLASIFIKASI_BARANG
        WHERE sppb_form.ID_SPPB_FORM = '$ID_SPPB_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'ID_RASD_FORM' => $data->ID_RASD_FORM,
					'ID_RAB_FORM' => $data->ID_RAB_FORM,
					'ID_FPB_FORM' => $data->ID_FPB_FORM,
					'KODE_BARANG' => $data->KODE_BARANG,
					'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'MEREK' => $data->MEREK,
					'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
					'NAMA_KLASIFIKASI_BARANG' => $data->NAMA_KLASIFIKASI_BARANG,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'KETERANGAN_STAFF_UMUM_LOG_SP' => $data->KETERANGAN_STAFF_UMUM_LOG_SP,
					'KETERANGAN_SVP_LOG_SP' => $data->KETERANGAN_SVP_LOG_SP,
					'KETERANGAN_CHIEF' => $data->KETERANGAN_CHIEF,
					'KETERANGAN_SM' => $data->KETERANGAN_SM,
					'KETERANGAN_PM' => $data->KETERANGAN_PM,
					'KETERANGAN_STAFF_LOG_KP' => $data->KETERANGAN_STAFF_LOG_KP,
					'KETERANGAN_STAFF_GUDANG_LOG_KP' => $data->KETERANGAN_STAFF_GUDANG_LOG_KP,
					'KETERANGAN_KASIE_LOG_KP' => $data->KETERANGAN_KASIE_LOG_KP,
					'KETERANGAN_M_LOG' => $data->KETERANGAN_M_LOG,
					'KETERANGAN_M_SDM' => $data->KETERANGAN_M_SDM,
					'KETERANGAN_M_KONS' => $data->KETERANGAN_M_KONS,
					'KETERANGAN_M_EP' => $data->KETERANGAN_M_EP,
					'KETERANGAN_M_QAQC' => $data->KETERANGAN_M_QAQC,
					'KETERANGAN_M_KEU' => $data->KETERANGAN_M_KEU,
					'KETERANGAN_M_HRD' => $data->KETERANGAN_M_HRD,
					'KETERANGAN_M_HSSE' => $data->KETERANGAN_M_HSSE,
					'KETERANGAN_M_MARKETING' => $data->KETERANGAN_M_MARKETING,
					'KETERANGAN_M_KOMERSIAL' => $data->KETERANGAN_M_KOMERSIAL,
					'KETERANGAN_D_PSDS' => $data->KETERANGAN_D_PSDS,
					'KETERANGAN_D_EP_KONS' => $data->KETERANGAN_D_EP_KONS,
					'KETERANGAN_D_KEU' => $data->KETERANGAN_D_KEU,
					'KETERANGAN_UMUM' => $data->KETERANGAN_UMUM,
					'JUMLAH_QTY_SPP' => $data->JUMLAH_QTY_SPP,
					'BIDANG_PEMAKAI' => $data->BIDANG_PEMAKAI,
					'TANGGAL_MULAI_PAKAI_HARI' => $data->TANGGAL_MULAI_PAKAI_HARI,
					'TANGGAL_SELESAI_PAKAI_HARI' => $data->TANGGAL_SELESAI_PAKAI_HARI
				);
			}
		} else {
			$hasil = "BELUM ADA SPPB Barang";
		}
		return $hasil;
	}

	function get_data_by_id_item_form_pengajuan_barang($ID_ITEM_FORM_PENGAJUAN_BARANG)
	{
		$hsl = $this->db->query("SELECT * FROM item_form_pengajuan_barang WHERE ID_ITEM_FORM_PENGAJUAN_BARANG = '$ID_ITEM_FORM_PENGAJUAN_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_ITEM_FORM_PENGAJUAN_BARANG' => $data->ID_ITEM_FORM_PENGAJUAN_BARANG,
					'ID_FORM_INVENTARIS_KORBAN_BENCANA' => $data->ID_FORM_INVENTARIS_KORBAN_BENCANA,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'JENIS_BANTUAN' => $data->JENIS_BANTUAN,
					'KETERANGAN' => $data->KETERANGAN
				);
			}
		} else {
			$hasil = "BELUM ADA Pengajuan Barang";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB_FORM
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function update_data_keterangan_barang
	//         2. 
	function get_keterangan_by_id_sppb_form($ID_SPPB_FORM)
	{
		$hsl = $this->db->query("SELECT 
		ID_SPPB_FORM, 
		KETERANGAN_STAFF_UMUM_LOG_SP,
		KETERANGAN_SVP_LOG_SP,
		KETERANGAN_CHIEF,
		KETERANGAN_SM,
		KETERANGAN_PM,
		KETERANGAN_STAFF_LOG_KP,
		KETERANGAN_STAFF_GUDANG_LOG_KP,
		KETERANGAN_KASIE_LOG_KP,
		KETERANGAN_M_LOG,
		KETERANGAN_M_SDM,
		KETERANGAN_M_KONS,
		KETERANGAN_M_EP,
		KETERANGAN_M_QAQC,
		KETERANGAN_M_KEU,
		KETERANGAN_M_HRD,
		KETERANGAN_M_HSSE,
		KETERANGAN_M_MARKETING,
		KETERANGAN_M_KOMERSIAL,
		KETERANGAN_D_PSDS,
		KETERANGAN_D_EP_KONS,
		KETERANGAN_D_KEU

		FROM SPPB_FORM

        WHERE ID_SPPB_FORM = '$ID_SPPB_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
					'KETERANGAN_STAFF_UMUM_LOG_SP' => $data->KETERANGAN_STAFF_UMUM_LOG_SP,
					'KETERANGAN_SVP_LOG_SP' => $data->KETERANGAN_SVP_LOG_SP,
					'KETERANGAN_CHIEF' => $data->KETERANGAN_CHIEF,
					'KETERANGAN_SM' => $data->KETERANGAN_SM,
					'KETERANGAN_PM' => $data->KETERANGAN_PM,
					'KETERANGAN_STAFF_LOG_KP' => $data->KETERANGAN_STAFF_LOG_KP,
					'KETERANGAN_STAFF_GUDANG_LOG_KP' => $data->KETERANGAN_STAFF_GUDANG_LOG_KP,
					'KETERANGAN_KASIE_LOG_KP' => $data->KETERANGAN_KASIE_LOG_KP,
					'KETERANGAN_M_LOG' => $data->KETERANGAN_M_LOG,
					'KETERANGAN_M_SDM' => $data->KETERANGAN_M_SDM,
					'KETERANGAN_M_KONS' => $data->KETERANGAN_M_KONS,
					'KETERANGAN_M_EP' => $data->KETERANGAN_M_EP,
					'KETERANGAN_M_QAQC' => $data->KETERANGAN_M_QAQC,
					'KETERANGAN_M_KEU' => $data->KETERANGAN_M_KEU,
					'KETERANGAN_M_HRD' => $data->KETERANGAN_M_HRD,
					'KETERANGAN_M_HSSE' => $data->KETERANGAN_M_HSSE,
					'KETERANGAN_M_MARKETING' => $data->KETERANGAN_M_MARKETING,
					'KETERANGAN_M_KOMERSIAL' => $data->KETERANGAN_M_KOMERSIAL,
					'KETERANGAN_D_PSDS' => $data->KETERANGAN_D_PSDS,
					'KETERANGAN_D_EP_KONS' => $data->KETERANGAN_D_EP_KONS,
					'KETERANGAN_D_KEU' => $data->KETERANGAN_D_KEU
				);
			}
		} else {
			$hasil = "TIDAK ADA KETERANGAN";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function index
	//         2. controller SPPB_form / function get_data_catatan_sppb
	//         2. controller SPPB_form / function update_data_catatan_sppb
	function get_data_catatan_sppb_by_id_sppb($ID_SPPB)
	{
		$hsl = $this->db->query("SELECT 
		ID_SPPB, 
		CTT_STAFF_UMUM_LOG_SP,
		CTT_SPV_LOG_SP,
		CTT_CHIEF,
		CTT_SM,
		CTT_PM,
		CTT_STAFF_LOG_KP,
		CTT_STAFF_GUDANG_LOG_KP,
		CTT_KASIE_LOG_KP,
		CTT_M_HRD,
		CTT_M_KEU,
		CTT_M_KONS,	
		CTT_M_SDM,
		CTT_M_QAQC,
		CTT_M_EP,
		CTT_M_HSSE,
		CTT_M_MARKETING,
		CTT_M_KOMERSIAL,
		CTT_M_LOG,
		CTT_D_KEU,
		CTT_D_EP_KONS,
		CTT_D_PSDS,
		CTT_DEPT_PROC

		FROM SPPB

        WHERE ID_SPPB = '$ID_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB' => $data->ID_SPPB,
					'CTT_STAFF_UMUM_LOG_SP' => $data->CTT_STAFF_UMUM_LOG_SP,
					'CTT_SPV_LOG_SP' => $data->CTT_SPV_LOG_SP,
					'CTT_CHIEF' => $data->CTT_CHIEF,
					'CTT_SM' => $data->CTT_SM,
					'CTT_PM' => $data->CTT_PM,
					'CTT_STAFF_LOG_KP' => $data->CTT_STAFF_LOG_KP,
					'CTT_STAFF_GUDANG_LOG_KP' => $data->CTT_STAFF_GUDANG_LOG_KP,
					'CTT_KASIE_LOG_KP' => $data->CTT_KASIE_LOG_KP,
					'CTT_M_HRD' => $data->CTT_M_HRD,
					'CTT_M_KEU' => $data->CTT_M_KEU,
					'CTT_M_KONS' => $data->CTT_M_KONS,
					'CTT_M_SDM' => $data->CTT_M_SDM,
					'CTT_M_QAQC' => $data->CTT_M_QAQC,
					'CTT_M_EP' => $data->CTT_M_EP,
					'CTT_M_HSSE' => $data->CTT_M_HSSE,
					'CTT_M_MARKETING' => $data->CTT_M_MARKETING,
					'CTT_M_KOMERSIAL' => $data->CTT_M_KOMERSIAL,
					'CTT_M_LOG' => $data->CTT_M_LOG,
					'CTT_D_KEU' => $data->CTT_D_KEU,
					'CTT_D_EP_KONS' => $data->CTT_D_EP_KONS,
					'CTT_D_PSDS' => $data->CTT_D_PSDS,
					'CTT_DEPT_PROC' => $data->CTT_DEPT_PROC,
				);
			}
		} else {
			$hasil = "TIDAK ADA CATATAN";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function index
	//         2. controller SPPB_form / function get_data_catatan_sppb
	//         2. controller SPPB_form / function update_data_catatan_sppb
	function get_data_catatan_sppb_by_id_sppb_non_result($ID_SPPB)
	{
		$hsl = $this->db->query("SELECT 
		ID_SPPB, 
		CTT_STAFF_UMUM_LOG_SP,
		CTT_SPV_LOG_SP,
		CTT_CHIEF,
		CTT_SM,
		CTT_PM,
		CTT_STAFF_LOG_KP,
		CTT_STAFF_GUDANG_LOG_KP,
		CTT_KASIE_LOG_KP,
		CTT_M_HRD,
		CTT_M_KEU,
		CTT_M_KONS,	
		CTT_M_SDM,
		CTT_M_QAQC,
		CTT_M_EP,
		CTT_M_HSSE,
		CTT_M_MARKETING,
		CTT_M_KOMERSIAL,
		CTT_M_LOG,
		CTT_D_KEU,
		CTT_D_EP_KONS,
		CTT_D_PSDS

		FROM SPPB

        WHERE ID_SPPB = '$ID_SPPB'");
		return $hsl;
	}

	function get_data_keterangan_barang_by_id_sppb($ID_SPPB)
	{
		$hsl = $this->db->query("SELECT 
		NAMA_BARANG,
        KETERANGAN_STAFF_UMUM_LOG_SP,
		KETERANGAN_SVP_LOG_SP,
		KETERANGAN_CHIEF,
		KETERANGAN_SM,
		KETERANGAN_PM,
		KETERANGAN_STAFF_LOG_KP,
		KETERANGAN_STAFF_GUDANG_LOG_KP,
		KETERANGAN_KASIE_LOG_KP,
		KETERANGAN_M_LOG,
		KETERANGAN_M_SDM,
		KETERANGAN_M_KONS,
		KETERANGAN_M_EP,
		KETERANGAN_M_QAQC,
		KETERANGAN_M_KEU,
		KETERANGAN_M_HRD,
		KETERANGAN_M_HSSE,
		KETERANGAN_M_MARKETING,
		KETERANGAN_M_KOMERSIAL,
		KETERANGAN_D_PSDS,
		KETERANGAN_D_EP_KONS,
		KETERANGAN_D_KEU

		FROM sppb_form

        WHERE ID_SPPB = '$ID_SPPB' AND (
            KETERANGAN_STAFF_UMUM_LOG_SP IS NOT NULL OR 
            KETERANGAN_SVP_LOG_SP IS NOT NULL OR
            KETERANGAN_CHIEF IS NOT NULL OR
            KETERANGAN_SM IS NOT NULL OR
            KETERANGAN_PM IS NOT NULL OR
            KETERANGAN_STAFF_LOG_KP IS NOT NULL OR
            KETERANGAN_STAFF_GUDANG_LOG_KP IS NOT NULL OR
            KETERANGAN_KASIE_LOG_KP IS NOT NULL OR
            KETERANGAN_M_LOG IS NOT NULL OR
            KETERANGAN_M_SDM IS NOT NULL OR
            KETERANGAN_M_KONS IS NOT NULL OR
            KETERANGAN_M_EP IS NOT NULL OR
            KETERANGAN_M_QAQC IS NOT NULL OR
            KETERANGAN_M_KEU IS NOT NULL OR
			KETERANGAN_M_HRD IS NOT NULL OR
			KETERANGAN_M_HSSE IS NOT NULL OR
			KETERANGAN_M_MARKETING IS NOT NULL OR
			KETERANGAN_M_KOMERSIAL IS NOT NULL OR
            KETERANGAN_D_PSDS IS NOT NULL OR
            KETERANGAN_D_EP_KONS IS NOT NULL OR
            KETERANGAN_D_KEU IS NOT NULL)");
		return $hsl->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb form NAMA
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function simpan_data_di_luar_barang_master
	//         2. 
	function cek_nama_barang_sppb_form($NAMA)
	{
		$hsl = $this->db->query("SELECT ID_SPPB_FORM, NAMA_BARANG AS NAMA FROM sppb_form WHERE NAMA_BARANG ='$NAMA'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
					'NAMA' => $data->NAMA
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function update_data_keterangan_barang
	//         2. 
	function update_data_KETERANGAN_STAFF_UMUM_LOG_SP($ID_SPPB_FORM, $KETERANGAN_STAFF_UMUM_LOG_SP)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_STAFF_UMUM_LOG_SP='$KETERANGAN_STAFF_UMUM_LOG_SP' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_SVP_LOG_SP($ID_SPPB_FORM, $KETERANGAN_SVP_LOG_SP)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_SVP_LOG_SP='$KETERANGAN_SVP_LOG_SP' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_CHIEF($ID_SPPB_FORM, $KETERANGAN_CHIEF)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_CHIEF='$KETERANGAN_CHIEF' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_SM($ID_SPPB_FORM, $KETERANGAN_SM)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_SM='$KETERANGAN_SM' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_PM($ID_SPPB_FORM, $KETERANGAN_PM)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_PM='$KETERANGAN_PM' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_STAFF_LOG_KP($ID_SPPB_FORM, $KETERANGAN_STAFF_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_STAFF_LOG_KP='$KETERANGAN_STAFF_LOG_KP' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_STAFF_GUDANG_LOG_KP($ID_SPPB_FORM, $KETERANGAN_STAFF_GUDANG_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_STAFF_GUDANG_LOG_KP='$KETERANGAN_STAFF_GUDANG_LOG_KP' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_KASIE_LOG_KP($ID_SPPB_FORM, $KETERANGAN_KASIE_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_KASIE_LOG_KP='$KETERANGAN_KASIE_LOG_KP' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_LOG($ID_SPPB_FORM, $KETERANGAN_M_LOG)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_M_LOG='$KETERANGAN_M_LOG' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_SDM($ID_SPPB_FORM, $KETERANGAN_M_SDM)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_M_SDM='$KETERANGAN_M_SDM' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_KONS($ID_SPPB_FORM, $KETERANGAN_M_KONS)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_M_KONS='$KETERANGAN_M_KONS' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_EP($ID_SPPB_FORM, $KETERANGAN_M_EP)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_M_EP='$KETERANGAN_M_EP' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_QAQC($ID_SPPB_FORM, $KETERANGAN_M_QAQC)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_M_QAQC='$KETERANGAN_M_QAQC' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_KEU($ID_SPPB_FORM, $KETERANGAN_M_KEU)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_M_KEU='$KETERANGAN_M_KEU' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_HRD($ID_SPPB_FORM, $KETERANGAN_M_HRD)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_M_HRD='$KETERANGAN_M_HRD' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_HSSE($ID_SPPB_FORM, $KETERANGAN_M_HSSE)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_M_HSSE='$KETERANGAN_M_HSSE' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_MARKETING($ID_SPPB_FORM, $KETERANGAN_M_MARKETING)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_M_MARKETING='$KETERANGAN_M_MARKETING' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_KOMERSIAL($ID_SPPB_FORM, $KETERANGAN_M_KOMERSIAL)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_M_KOMERSIAL='$KETERANGAN_M_KOMERSIAL' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_D_PSDS($ID_SPPB_FORM, $KETERANGAN_D_PSDS)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_D_PSDS='$KETERANGAN_D_PSDS' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_D_EP_KONS($ID_SPPB_FORM, $KETERANGAN_D_EP_KONS)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_D_EP_KONS='$KETERANGAN_D_EP_KONS' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_D_KEU($ID_SPPB_FORM, $KETERANGAN_D_KEU)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			KETERANGAN_D_KEU='$KETERANGAN_D_KEU' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function update_data_coret
	//         2. 
	function update_data_coret($ID_SPPB_FORM, $CATATAN_CORET)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			CORET=1, CATATAN_CORET = '$CATATAN_CORET'
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function update_data_batal_coret
	//         2. 
	function update_data_batal_coret($ID_SPPB_FORM, $CATATAN_BATAL_CORET)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			CORET=0, CATATAN_BATAL_CORET = '$CATATAN_BATAL_CORET'
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function update_data_catatan_sppb
	//         2. 
	function update_data_CTT_STAFF_UMUM_LOG_SP($ID_SPPB, $CTT_STAFF_UMUM_LOG_SP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_STAFF_UMUM_LOG_SP='$CTT_STAFF_UMUM_LOG_SP' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_SPV_LOG_SP($ID_SPPB, $CTT_SPV_LOG_SP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_SPV_LOG_SP='$CTT_SPV_LOG_SP' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_CHIEF($ID_SPPB, $CTT_CHIEF)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_CHIEF='$CTT_CHIEF' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_SM($ID_SPPB, $CTT_SM)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_SM='$CTT_SM' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_PM($ID_SPPB, $CTT_PM)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_PM='$CTT_PM' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_STAFF_LOG_KP($ID_SPPB, $CTT_STAFF_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_STAFF_LOG_KP='$CTT_STAFF_LOG_KP' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_DEPT_PROC($ID_SPPB, $CTT_DEPT_PROC)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_DEPT_PROC='$CTT_DEPT_PROC' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_STAFF_GUDANG_LOG_KP($ID_SPPB, $CTT_STAFF_GUDANG_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_STAFF_GUDANG_LOG_KP='$CTT_STAFF_GUDANG_LOG_KP' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_KASIE_LOG_KP($ID_SPPB, $CTT_KASIE_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_KASIE_LOG_KP='$CTT_KASIE_LOG_KP' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_M_HRD($ID_SPPB, $CTT_M_HRD)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_M_HRD='$CTT_M_HRD' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_M_KEU($ID_SPPB, $CTT_M_KEU)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_M_KEU='$CTT_M_KEU' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_M_KONS($ID_SPPB, $CTT_M_KONS)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_M_KONS='$CTT_M_KONS' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_M_SDM($ID_SPPB, $CTT_M_SDM)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_M_SDM='$CTT_M_SDM' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_M_QAQC($ID_SPPB, $CTT_M_QAQC)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_M_QAQC='$CTT_M_QAQC' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_M_EP($ID_SPPB, $CTT_M_EP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_M_EP='$CTT_M_EP' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_M_HSSE($ID_SPPB, $CTT_M_HSSE)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_M_HSSE='$CTT_M_HSSE' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_M_MARKETING($ID_SPPB, $CTT_M_MARKETING)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_M_MARKETING='$CTT_M_MARKETING' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_M_KOMERSIAL($ID_SPPB, $CTT_M_KOMERSIAL)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_M_KOMERSIAL='$CTT_M_KOMERSIAL' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_M_LOG($ID_SPPB, $CTT_M_LOG)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_M_LOG='$CTT_M_LOG' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_D_KEU($ID_SPPB, $CTT_D_KEU)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_D_KEU='$CTT_D_KEU' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_D_EP_KONS($ID_SPPB, $CTT_D_EP_KONS)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_D_EP_KONS='$CTT_D_EP_KONS' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_CTT_D_PSDS($ID_SPPB, $CTT_D_PSDS)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			CTT_D_PSDS='$CTT_D_PSDS' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function update_data
	//         2. controller SPPB / function update_data
	function update_data($ID_SPPB_FORM, $JUMLAH_MINTA, $PERALATAN_PERLENGKAPAN, $BIDANG_PEMAKAI, $TANGGAL_MULAI_PAKAI_HARI, $TANGGAL_SELESAI_PAKAI_HARI)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			JUMLAH_MINTA='$JUMLAH_MINTA',
			JUMLAH_SETUJU_TERAKHIR='$JUMLAH_MINTA',
			PERALATAN_PERLENGKAPAN='$PERALATAN_PERLENGKAPAN',
			BIDANG_PEMAKAI='$BIDANG_PEMAKAI',
			TANGGAL_MULAI_PAKAI_HARI='$TANGGAL_MULAI_PAKAI_HARI',
			TANGGAL_SELESAI_PAKAI_HARI='$TANGGAL_SELESAI_PAKAI_HARI'
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_barang_bantuan(
		$ID_ITEM_FORM_PENGAJUAN_BARANG,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$SATUAN_BARANG,
		$JENIS_BANTUAN,
		$KETERANGAN)
	{
		$hasil = $this->db->query("UPDATE item_form_pengajuan_barang SET 
			NAMA_BARANG='$NAMA',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			JUMLAH_BARANG='$JUMLAH_BARANG',
			SATUAN_BARANG='$SATUAN_BARANG',
			JENIS_BANTUAN='$JENIS_BANTUAN',
			KETERANGAN='$KETERANGAN'
			WHERE ID_ITEM_FORM_PENGAJUAN_BARANG='$ID_ITEM_FORM_PENGAJUAN_BARANG'");
		return $hasil;
	}

	function update_data_sppb_pembelian($ID_SPPB_FORM, $NAMA, $MEREK, $SPESIFIKASI_SINGKAT, $JUMLAH_QTY_SPP, $SATUAN_BARANG, $ID_KLASIFIKASI_BARANG, $ID_PROYEK_SUB_PEKERJAAN, $TANGGAL_MULAI_PAKAI_HARI, $TANGGAL_SELESAI_PAKAI_HARI, $KETERANGAN, $ID_RAB_FORM, $ID_RASD_FORM)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			NAMA_BARANG='$NAMA',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			JUMLAH_QTY_SPP='$JUMLAH_QTY_SPP',
			SATUAN_BARANG='$SATUAN_BARANG',
			ID_KLASIFIKASI_BARANG='$ID_KLASIFIKASI_BARANG',
			ID_PROYEK_SUB_PEKERJAAN='$ID_PROYEK_SUB_PEKERJAAN',
			TANGGAL_MULAI_PAKAI_HARI='$TANGGAL_MULAI_PAKAI_HARI',
			TANGGAL_SELESAI_PAKAI_HARI='$TANGGAL_SELESAI_PAKAI_HARI',
			KETERANGAN_UMUM='$KETERANGAN',
			ID_RAB_FORM='$ID_RAB_FORM',
			ID_RASD_FORM='$ID_RASD_FORM'
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_status_id_sppb_form($ID_SPPB_FORM)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			COMPLETE='TERPENUHI'
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_progress_id_sppb($ID_SPPB, $PROGRESS_SPPB)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_quantity_spp($ID_SPPB_FORM, $JUMLAH_QTY_SPP, $JUMLAH_QTY_GUDANG)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			JUMLAH_QTY_SPP='$JUMLAH_QTY_SPP', JUMLAH_QTY_GUDANG='$JUMLAH_QTY_GUDANG'
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_data_M_LOG($ID_SPPB_FORM, $JUMLAH_MINTA, $JUMLAH_SETUJU_M_LOG)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			JUMLAH_MINTA='$JUMLAH_MINTA', 
			JUMLAH_SETUJU_M_LOG='$JUMLAH_SETUJU_M_LOG'
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function update_data_kirim_sppb
	//         2. 
	function update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB' 
			WHERE ID_SPPB='$ID_SPPB'");
		$hasil2 = $this->db->query("UPDATE sppb_form SET
			STATUS_SPPB='$STATUS_SPPB' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil2;
	}

	function update_data_kirim_sppb_user_staff_umum_logistik_sp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_STAFF_UMUM_LOG_SP, $SIGN_USER_CHIEF_SP, $SIGN_USER_SM_SP, $SIGN_USER_PM_SP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB',
			SIGN_USER_STAFF_UMUM_LOG_SP='$SIGN_USER_STAFF_UMUM_LOG_SP',
			SIGN_USER_CHIEF_SP='$SIGN_USER_CHIEF_SP',
			SIGN_USER_SM_SP='$SIGN_USER_SM_SP',
			SIGN_USER_PM_SP='$SIGN_USER_PM_SP'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_kirim_sppb_user_supervisi_logistik_sp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_SUPERVISI_LOG_SP, $SIGN_USER_CHIEF_SP, $SIGN_USER_SM_SP, $SIGN_USER_PM_SP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB',
			SIGN_USER_SUPERVISI_LOG_SP='$SIGN_USER_SUPERVISI_LOG_SP',
			SIGN_USER_CHIEF_SP='$SIGN_USER_CHIEF_SP',
			SIGN_USER_SM_SP='$SIGN_USER_SM_SP',
			SIGN_USER_PM_SP='$SIGN_USER_PM_SP'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_kirim_sppb_user_staff_umum_logistik_kp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_STAFF_UMUM_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB',
			SIGN_USER_STAFF_UMUM_LOG_KP='$SIGN_USER_STAFF_UMUM_LOG_KP'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_kirim_sppb_user_staff_gudang_logistik_kp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_STAFF_GUDANG_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB',
			SIGN_USER_STAFF_GUDANG_LOG_KP='$SIGN_USER_STAFF_GUDANG_LOG_KP' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_kirim_sppb_user_pm_sp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_PM_SP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB',
			SIGN_USER_PM_SP='$SIGN_USER_PM_SP'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_kirim_sppb_user_manajer_kons_kp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_M_KONS_KP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB',
			SIGN_USER_M_KONS_KP='$SIGN_USER_M_KONS_KP'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_kirim_sppb_user_manajer_ep_kp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_M_EP_KP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB',
			SIGN_USER_M_EP_KP='$SIGN_USER_M_EP_KP'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_kirim_sppb_user_manajer_log_kp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_M_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB',
			SIGN_USER_M_LOG_KP='$SIGN_USER_M_LOG_KP'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_kirim_sppb_user_d_ep_kons_kp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_D_EP_KONS_KP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB',
			SIGN_USER_D_EP_KONS_KP='$SIGN_USER_D_EP_KONS_KP'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function update_data_kirim_sppb_user_d_psds_kp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_D_PSDS_KP)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB',
			SIGN_USER_D_PSDS_KP='$SIGN_USER_D_PSDS_KP'
			WHERE ID_SPPB='$ID_SPPB'");
		$hasil2 = $this->db->query("UPDATE sppb_form SET
			STATUS_SPPB='$STATUS_SPPB' 
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function update_data_proses
	//         2. 
	function update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			JUMLAH_SETUJU_TERAKHIR='$JUMLAH_SETUJU_TERAKHIR' 
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_status_spp_by_id_sppb_form($ID_SPPB_FORM, $ID_SPP)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			STATUS_SPP='Dalam Proses SPP', KET_SPP='$ID_SPP'
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_delete_status_spp_by_id_sppb_form($ID_SPPB_FORM)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			STATUS_SPP='', KET_SPP=''
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_SPPB
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function simpan_data_dari_rasd_form
	//         2. 
	function simpan_data_dari_rasd_form(
		$ID_SPPB,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_MINTA
	) {
		$hasil = $this->db->query("INSERT INTO sppb_form (
				ID_SPPB,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA,
				JUMLAH_SETUJU_TERAKHIR,
				JUMLAH_QTY_SPP
				)
			VALUES(
				'$ID_SPPB',
				'$ID_BARANG_MASTER',
				'$ID_RASD_FORM',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_MINTA',
				'$JUMLAH_MINTA',
				'$JUMLAH_MINTA'
				 )");
		return $hasil;
	}

	function simpan_data_dari_fpb_form(
		$ID_SPPB,
		$ID_FPB_FORM,
		$ID_RASD_FORM,
		$ID_BARANG_MASTER,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_MINTA,
		$TANGGAL_MULAI_PAKAI_HARI,
		$TANGGAL_SELESAI_PAKAI_HARI
	) {
		$hasil = $this->db->query("INSERT INTO sppb_form (
				ID_SPPB,
				ID_FPB_FORM,
				ID_RASD_FORM,
				ID_BARANG_MASTER,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA,
				JUMLAH_SETUJU_TERAKHIR,
				TANGGAL_MULAI_PAKAI_HARI,
				TANGGAL_SELESAI_PAKAI_HARI
				)
			VALUES(
				'$ID_SPPB',
				'$ID_FPB_FORM',
				'$ID_RASD_FORM',
				'$ID_BARANG_MASTER',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_MINTA',
				'$JUMLAH_MINTA',
				'$TANGGAL_MULAI_PAKAI_HARI',
				'$TANGGAL_SELESAI_PAKAI_HARI'
				 )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_SPPB
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function simpan_data_dari_barang_master
	//         2. 
	function simpan_data_dari_barang_master(
		$ID_SPPB,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_MINTA
	) {
		$hasil = $this->db->query("INSERT INTO sppb_form (
				ID_SPPB,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA,
				JUMLAH_SETUJU_TERAKHIR
				)
			VALUES(
				'$ID_SPPB',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_MINTA',
				'$JUMLAH_MINTA'
				 )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_SPPB
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function simpan_data_di_luar_barang_master
	//         2. 
	function simpan_data_di_luar_barang_master(
		$ID_SPPB,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_MINTA,
		$TANGGAL_MULAI_PAKAI_HARI,
		$TANGGAL_SELESAI_PAKAI_HARI
	) {
		$hasil = $this->db->query("INSERT INTO sppb_form (
				ID_SPPB,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA,
				JUMLAH_SETUJU_TERAKHIR,
				TANGGAL_MULAI_PAKAI_HARI, 
				TANGGAL_SELESAI_PAKAI_HARI
				)
			VALUES(
				'$ID_SPPB',
				'$ID_BARANG_MASTER',
				'$ID_RASD_FORM',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_MINTA',
				'$JUMLAH_MINTA',
				'$TANGGAL_MULAI_PAKAI_HARI', 
				'$TANGGAL_SELESAI_PAKAI_HARI'
				)");
		return $hasil;
	}

	function simpan_data_dari_excel_tanpa_rasd_form(
		$ID_SPPB,
		$ID_RAB_FORM,
		$ID_KLASIFIKASI_BARANG,
		$NAMA_BARANG,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_QTY_SPP,
		$SATUAN_BARANG,
		$TANGGAL_MULAI_PAKAI_HARI,
		$TANGGAL_SELESAI_PAKAI_HARI,
		$KETERANGAN_UMUM
	) {
		$hasil = $this->db->query("INSERT INTO sppb_form (
				ID_SPPB,
				ID_RAB_FORM,
				ID_KLASIFIKASI_BARANG,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_QTY_SPP,
				SATUAN_BARANG,
				TANGGAL_MULAI_PAKAI_HARI,
				TANGGAL_SELESAI_PAKAI_HARI,
				KETERANGAN_UMUM
				)
			VALUES(
				'$ID_SPPB',
				'$ID_RAB_FORM',
				'$ID_KLASIFIKASI_BARANG',
				'$NAMA_BARANG',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_QTY_SPP',
				'$SATUAN_BARANG',
				'$TANGGAL_MULAI_PAKAI_HARI',
				'$TANGGAL_SELESAI_PAKAI_HARI',
				'$KETERANGAN_UMUM'
				)");
		return $hasil;
	}

	function simpan_data_dari_excel_ada_rasd_form(
		$ID_SPPB,
		$ID_RAB_FORM,
		$ID_PROYEK_SUB_PEKERJAAN,
		$ID_RASD_FORM,
		$ID_KLASIFIKASI_BARANG,
		$NAMA_BARANG,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_QTY_SPP,
		$SATUAN_BARANG,
		$TANGGAL_MULAI_PAKAI_HARI,
		$TANGGAL_SELESAI_PAKAI_HARI,
		$KETERANGAN_UMUM
	) {
		$hasil = $this->db->query("INSERT INTO sppb_form (
				ID_SPPB,
				ID_RAB_FORM,
				ID_PROYEK_SUB_PEKERJAAN,
				ID_RASD_FORM,
				ID_KLASIFIKASI_BARANG,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_QTY_SPP,
				SATUAN_BARANG,
				TANGGAL_MULAI_PAKAI_HARI,
				TANGGAL_SELESAI_PAKAI_HARI,
				KETERANGAN_UMUM
				)
			VALUES(
				'$ID_SPPB',
				'$ID_RAB_FORM',
				'$ID_PROYEK_SUB_PEKERJAAN',
				'$ID_RASD_FORM',
				'$ID_KLASIFIKASI_BARANG',
				'$NAMA_BARANG',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_QTY_SPP',
				'$SATUAN_BARANG',
				'$TANGGAL_MULAI_PAKAI_HARI',
				'$TANGGAL_SELESAI_PAKAI_HARI',
				'$KETERANGAN_UMUM'
				)");
		return $hasil;
	}

	function simpan_data_spbb_pembelian_deviasi_kategori(
		$ID_SPPB,
		$ID_RASD_FORM,
		$ID_RAB_FORM,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$PERALATAN_PERLENGKAPAN,
		$JUMLAH_MINTA,
		$TANGGAL_MULAI_PAKAI_HARI,
		$TANGGAL_SELESAI_PAKAI_HARI
	) {
		$hasil = $this->db->query("INSERT INTO sppb_form (
				ID_SPPB,
				ID_RASD_FORM,
				ID_RAB_FORM,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				PERALATAN_PERLENGKAPAN,
				JUMLAH_MINTA,
				JUMLAH_SETUJU_TERAKHIR,
				JUMLAH_QTY_SPP,
				TANGGAL_MULAI_PAKAI_HARI, 
				TANGGAL_SELESAI_PAKAI_HARI
				)
			VALUES(
				'$ID_SPPB',
				'$ID_RASD_FORM',
				'$ID_RAB_FORM',
				'$NAMA',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$PERALATAN_PERLENGKAPAN',
				'$JUMLAH_MINTA',
				'$JUMLAH_MINTA',
				'$JUMLAH_MINTA',
				'$TANGGAL_MULAI_PAKAI_HARI',
				'$TANGGAL_SELESAI_PAKAI_HARI'
				)");
		return $hasil;
	}

	function simpan_data_spbb_pembelian_1_item_by_rab_and_by_rasd(
		$ID_SPPB,
		$SATUAN_BARANG,
		$ID_RASD_FORM,
		$ID_RAB_FORM,
		$ID_KLASIFIKASI_BARANG,
		$ID_PROYEK_SUB_PEKERJAAN,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_QTY_SPP,
		$TANGGAL_MULAI_PAKAI_HARI,
		$TANGGAL_SELESAI_PAKAI_HARI,
		$KETERANGAN
	) {
		$hasil = $this->db->query("INSERT INTO sppb_form (
				ID_SPPB,
				SATUAN_BARANG,
				ID_RASD_FORM,
				ID_RAB_FORM,
				ID_KLASIFIKASI_BARANG,
				ID_PROYEK_SUB_PEKERJAAN,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_QTY_SPP,
				TANGGAL_MULAI_PAKAI_HARI,
				TANGGAL_SELESAI_PAKAI_HARI,
				KETERANGAN_UMUM
				)
			VALUES(
				'$ID_SPPB',
				'$SATUAN_BARANG',
				'$ID_RASD_FORM',
				'$ID_RAB_FORM',
				'$ID_KLASIFIKASI_BARANG',
				'$ID_PROYEK_SUB_PEKERJAAN',
				'$NAMA',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_QTY_SPP',
				'$TANGGAL_MULAI_PAKAI_HARI',
				'$TANGGAL_SELESAI_PAKAI_HARI',
				'$KETERANGAN'
				)");
		return $hasil;
	}

	function simpan_tanggal($ID_SPPB, $TANGGAL_MULAI_PAKAI, $TANGGAL_SELESAI_PAKAI)
	{
		$hasil = $this->db->query("UPDATE SPPB_form SET
			TANGGAL_MULAI_PAKAI_HARI='$TANGGAL_MULAI_PAKAI',
			TANGGAL_SELESAI_PAKAI_HARI='$TANGGAL_SELESAI_PAKAI'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function simpan_identitas_form($ID_SPPB, $NO_URUT_SPPB_GANTI, $CTT_DEPT_PROC, $SUB_PROYEK, $TANGGAL_DOKUMEN_SPPB)
	{
		$hasil = $this->db->query("UPDATE SPPB SET
			NO_URUT_SPPB='$NO_URUT_SPPB_GANTI',
			CTT_DEPT_PROC='$CTT_DEPT_PROC',
			SUB_PROYEK='$SUB_PROYEK',
			TANGGAL_DOKUMEN_SPPB='$TANGGAL_DOKUMEN_SPPB'
			WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	function simpan_data_barang_bantuan(
		$ID_FORM_INVENTARIS_KORBAN_BENCANA,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$SATUAN_BARANG,
		$JENIS_BANTUAN,
		$KETERANGAN
	) {
		$hasil = $this->db->query("INSERT INTO item_form_pengajuan_barang (
				ID_FORM_INVENTARIS_KORBAN_BENCANA,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG,
				SATUAN_BARANG,
				JENIS_BANTUAN,
				KETERANGAN
				)
			VALUES(
				'$ID_FORM_INVENTARIS_KORBAN_BENCANA',
				'$NAMA',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG',
				'$SATUAN_BARANG',
				'$JENIS_BANTUAN',
                '$KETERANGAN'
				 )");
		return $hasil;
	}



	//FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_USER
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function logout
	//         2. controller SPPB_form / function user_log
	function user_log_sppb_form($ID_USER, $ID_SPPB_FORM, $KETERANGAN, $WAKTU)
	{
		$db2 = $this->load->database('logs', TRUE);

		$hasil = $db2->query("INSERT INTO user_log_sppb_form (ID_USER, ID_SPPB_FORM, KETERANGAN, WAKTU) VALUES('$ID_USER', '$ID_SPPB_FORM', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}