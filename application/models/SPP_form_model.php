<?php
class SPP_form_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh rfq form
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function data_rfq_form
	//         2. 
	function spp_form_list_by_id_spp($ID_SPP, $ID_RAB_FORM)
	{
		$hasil = $this->db->query("SELECT 
		spp_form.ID_SPPB, 
		spp_form.ID_SPP_FORM, 
		spp_form.ID_SPP,
		spp_form.ID_RASD_FORM,
		spp_form.ID_KLASIFIKASI_BARANG,
		spp_form.ID_PROYEK_SUB_PEKERJAAN,
		spp_form.ID_RAB_FORM,
		spp_form.NAMA_BARANG,
		spp_form.SATUAN_BARANG,
		spp_form.MEREK,
		spp_form.SPESIFIKASI_SINGKAT, 
		spp_form.JUMLAH_BARANG,
		spp_form.HARGA_SATUAN_BARANG_FIX,
		spp_form.HARGA_TOTAL_FIX,
		spp_form.KETERANGAN_UMUM,
		DATE_FORMAT(spp_form.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI,
		DATE_FORMAT(spp_form.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI,
		spp_form.TANGGAL_MULAI_PAKAI_HARI AS TANGGAL_MULAI_PAKAI_HARI_INDO,
		spp_form.TANGGAL_SELESAI_PAKAI_HARI AS TANGGAL_SELESAI_PAKAI_HARI_INDO,
        V.NAMA_VENDOR,
		RABF.NAMA_KATEGORI,
		KB.NAMA_KLASIFIKASI_BARANG,
        PSP.NAMA_SUB_PEKERJAAN
        FROM spp_form
		LEFT JOIN spp AS spp ON spp.ID_SPP = spp_form.ID_SPP
        LEFT JOIN vendor AS V ON V.ID_VENDOR = spp_form.ID_VENDOR_FIX
		LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = spp_form.ID_RAB_FORM
		LEFT JOIN klasifikasi_barang as KB ON KB.ID_KLASIFIKASI_BARANG = spp_form.ID_KLASIFIKASI_BARANG
        LEFT JOIN proyek_sub_pekerjaan as PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = spp_form.ID_PROYEK_SUB_PEKERJAAN
        WHERE spp_form.ID_SPP = '$ID_SPP' AND spp_form.ID_RAB_FORM = '$ID_RAB_FORM'
		ORDER BY spp_form.NAMA_BARANG ASC
		");
		return $hasil->result();
	}

	function data_spp_form_by_id_spp($ID_SPP)
	{
		$hasil = $this->db->query("SELECT 
		spp_form.ID_SPPB,
		spp_form.ID_SPPB_FORM,
		spp_form.ID_SPP_FORM, 
		spp_form.ID_SPP,
		spp_form.ID_RASD_FORM,
		spp_form.ID_KLASIFIKASI_BARANG,
		spp_form.ID_PROYEK_SUB_PEKERJAAN,
		spp_form.ID_RAB_FORM,
		spp_form.NAMA_BARANG,
		spp_form.SATUAN_BARANG,
		spp_form.MEREK,
		spp_form.SPESIFIKASI_SINGKAT, 
		spp_form.JUMLAH_BARANG,
		spp_form.HARGA_SATUAN_BARANG_FIX,
		spp_form.HARGA_TOTAL_FIX,
		spp_form.KETERANGAN_UMUM,
		DATE_FORMAT(spp_form.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI,
		DATE_FORMAT(spp_form.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI,
		spp_form.TANGGAL_MULAI_PAKAI_HARI AS TANGGAL_MULAI_PAKAI_HARI_INDO,
		spp_form.TANGGAL_SELESAI_PAKAI_HARI AS TANGGAL_SELESAI_PAKAI_HARI_INDO,
        V.NAMA_VENDOR,
		RABF.NAMA_KATEGORI,
		KB.NAMA_KLASIFIKASI_BARANG,
        PSP.NAMA_SUB_PEKERJAAN
        FROM spp_form
		LEFT JOIN spp AS spp ON spp.ID_SPP = spp_form.ID_SPP
        LEFT JOIN vendor AS V ON V.ID_VENDOR = spp_form.ID_VENDOR_FIX
		LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = spp_form.ID_RAB_FORM
		LEFT JOIN klasifikasi_barang as KB ON KB.ID_KLASIFIKASI_BARANG = spp_form.ID_KLASIFIKASI_BARANG
        LEFT JOIN proyek_sub_pekerjaan as PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = spp_form.ID_PROYEK_SUB_PEKERJAAN
        WHERE spp_form.ID_SPP = '$ID_SPP'
		ORDER BY spp_form.NAMA_BARANG ASC
		");
		return $hasil->result();
	}

	function spp_form_list_by_id_spp_kirim_SPP($ID_SPP)
	{
		$hasil = $this->db->query("SELECT 
		spp_form.ID_SPPB,
		spp_form.ID_SPPB_FORM, 
		spp_form.ID_SPP_FORM,
		spp_form.ID_SPP,
		spp_form.ID_RASD_FORM,
		spp_form.ID_KLASIFIKASI_BARANG,
		spp_form.ID_PROYEK_SUB_PEKERJAAN,
		spp_form.ID_RAB_FORM,
		spp_form.ID_VENDOR_FIX,
		spp_form.NAMA_BARANG,
		spp_form.SATUAN_BARANG,
		spp_form.JENIS_PENGADAAN,
		spp_form.MEREK,
		spp_form.SPESIFIKASI_SINGKAT, 
		spp_form.JUMLAH_BARANG,
		spp_form.HARGA_SATUAN_BARANG_FIX,
		spp_form.HARGA_TOTAL_FIX,
		spp_form.KETERANGAN_UMUM,
		DATE_FORMAT(spp_form.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI,
		DATE_FORMAT(spp_form.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI,
		spp_form.TANGGAL_MULAI_PAKAI_HARI AS TANGGAL_MULAI_PAKAI_HARI_INDO,
		spp_form.TANGGAL_SELESAI_PAKAI_HARI AS TANGGAL_SELESAI_PAKAI_HARI_INDO,
        V.NAMA_VENDOR,
		RABF.NAMA_KATEGORI,
		KB.NAMA_KLASIFIKASI_BARANG,
        PSP.NAMA_SUB_PEKERJAAN,
		spp.HASH_MD5_SPP
        FROM spp_form
		LEFT JOIN spp AS spp ON spp.ID_SPP = spp_form.ID_SPP
        LEFT JOIN vendor AS V ON V.ID_VENDOR = spp_form.ID_VENDOR_FIX
		LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = spp_form.ID_RAB_FORM
		LEFT JOIN klasifikasi_barang as KB ON KB.ID_KLASIFIKASI_BARANG = spp_form.ID_KLASIFIKASI_BARANG
        LEFT JOIN proyek_sub_pekerjaan as PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = spp_form.ID_PROYEK_SUB_PEKERJAAN
        WHERE spp_form.ID_SPP = '$ID_SPP'
		ORDER BY spp_form.NAMA_BARANG ASC
		");
		return $hasil->result();
	}



	function spp_form_list_anggaran_by_id_spp($ID_SPP)
	{
		$hasil = $this->db->query("SELECT spp_form.ID_SPP_FORM, 
		spp_form.ID_SPP,
		spp_form.ID_RASD_FORM,
		spp_form.ID_RAB_FORM,
		spp_form.NAMA_BARANG,
		spp_form.ID_PROYEK_SUB_PEKERJAAN,
        RABF.NAMA_KATEGORI,
        RABF.ID_RAB,
        RABF.RENCANA_ANGGARAN,
        RASD.ID_RASD,
        RAB.ID_PROYEK_SUB_PEKERJAAN,
        PROYEK_SUB.NAMA_SUB_PEKERJAAN
        FROM spp_form
		LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = spp_form.ID_RAB_FORM
        LEFT JOIN RAB as RAB ON RAB.ID_RAB = RABF.ID_RAB
        LEFT JOIN RASD as RASD ON RASD.ID_RAB_FORM = spp_form.ID_RAB_FORM
        LEFT JOIN proyek_sub_pekerjaan as PROYEK_SUB ON PROYEK_SUB.ID_PROYEK_SUB_PEKERJAAN = RAB.ID_PROYEK_SUB_PEKERJAAN
        WHERE spp_form.ID_SPP = '$ID_SPP'
        GROUP BY spp_form.ID_RAB_FORM");
		return $hasil->result();
	}


	function grup_rab_spp_form($ID_SPP)
	{
		$hasil = $this->db->query("SELECT distinct
		spp_form.ID_RAB_FORM,
        RABF.NAMA_KATEGORI
        FROM spp_form
        LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = spp_form.ID_RAB_FORM
        WHERE spp_form.ID_SPP = '$ID_SPP' ORDER BY spp_form.ID_RAB_FORM ASC");
		return $hasil->result();
	}

	function data_qty_spp_realisasi_by_ID_SPPB_FORM($ID_SPPB_FORM)
	{
		$hasil = $this->db->query("SELECT SUM(JUMLAH_BARANG) AS JUMLAH_BARANG from spp_form WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil->result();
	}

	function data_anggaran_sum_jumlah_barang_rasd($ID_RASD)
	{
		$hasil = $this->db->query("SELECT * FROM rasd_form
        WHERE ID_RASD = '$ID_RASD'");
		return $hasil->result();
	}

	function data_jumlah_qty_spp_by_id_sppb_form($ID_SPPB_FORM)
	{
		$hsl = $this->db->query("SELECT JUMLAH_QTY_SPP from sppb_form WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'JUMLAH_QTY_SPP' => $data->JUMLAH_QTY_SPP,
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function data_jumlah_realisasi_by_id_sppb_form($ID_SPPB_FORM)
	{
		$hsl = $this->db->query("SELECT SUM(JUMLAH_BARANG) AS JUMLAH_REALISASI_SPP from spp_form WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'JUMLAH_REALISASI_SPP' => $data->JUMLAH_REALISASI_SPP,
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function data_anggaran_sum_jumlah_barang_rab($ID_RAB_FORM,$ID_SPP)
	{
		$hasil = $this->db->query("SELECT * FROM spp_form
        WHERE (ID_RAB_FORM = '$ID_RAB_FORM' AND ID_SPP = '$ID_SPP') ");
		return $hasil->result();
	}

	function data_anggaran_sum_jumlah_barang_rab_pengadaan_sebelumnya($ID_RAB_FORM)
	{
		$hasil = $this->db->query("SELECT * FROM rasd_realisasi
        WHERE (ID_RAB_FORM = '$ID_RAB_FORM') ");
		return $hasil->result();
	}

	function cek_item_spp_kontrol_anggaran($ID_SPP, $ID_RAB_FORM)
	{
		$hsl = $this->db->query("SELECT * FROM spp_kontrol_anggaran WHERE ID_SPP='$ID_SPP' AND ID_RAB_FORM='$ID_RAB_FORM'");
		if ($hsl->num_rows() > 0) {
			$hasil = "SUDAH ADA ITEM";
		} else {
			$hasil = "BELUM ADA ITEM";
		}
		return $hasil;
	}

	function hapus_item_spp_kontrol_anggaran($ID_SPP)
	{
		$hasil = $this->db->query("DELETE FROM spp_kontrol_anggaran WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function kontrol_anggaran_list_by_id_spp($ID_SPP)
	{
		$hasil = $this->db->query("SELECT * FROM spp_kontrol_anggaran WHERE ID_SPP='$ID_SPP' ");
		return $hasil->result();
	}

	function cek_rasd_realiasi_by_id_spp_form($ID_SPP_FORM)
	{
		$hsl = $this->db->query("SELECT * FROM rasd_realisasi_temp WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		if ($hsl->num_rows() > 0) {
			$hasil = "SUDAH ADA ITEM";
		} else {
			$hasil = "BELUM ADA ITEM";
		}
		return $hasil;
	}

	function simpan_rasd_realisasi($ID_RAB_FORM, $ID_RASD_FORM, $ID_SPP, $ID_SPP_FORM, $SATUAN_BARANG, $JUMLAH_BARANG, $HARGA_BARANG, $HARGA_TOTAL)
	{
		$hasil = $this->db->query("INSERT INTO rasd_realisasi_temp (
			ID_RAB_FORM,
			ID_RASD_FORM,
			ID_SPP,
			ID_SPP_FORM,
			SATUAN_BARANG,
			JUMLAH_BARANG,
			HARGA_BARANG,
			HARGA_TOTAL)
		VALUES(
			'$ID_RAB_FORM',
			'$ID_RASD_FORM',
			'$ID_SPP',
			'$ID_SPP_FORM',
			'$SATUAN_BARANG',
			'$JUMLAH_BARANG',
			'$HARGA_BARANG',
			'$HARGA_TOTAL')");
	return $hasil;
	}

	function update_progress_id_spp($ID_SPP, $PROGRESS_SPP)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_rasd_realisasi($ID_RAB_FORM, $ID_RASD_FORM, $ID_SPP, $ID_SPP_FORM, $SATUAN_BARANG, $JUMLAH_BARANG, $HARGA_BARANG, $HARGA_TOTAL)
	{
		$hasil = $this->db->query("UPDATE rasd_realisasi_temp SET 
			SATUAN_BARANG='$SATUAN_BARANG',
			JUMLAH_BARANG='$JUMLAH_BARANG',
			HARGA_BARANG='$HARGA_BARANG',
			HARGA_TOTAL='$HARGA_TOTAL'
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function hapus_rasd_realisasi($ID_SPP_FORM)
	{
		$hasil = $this->db->query("DELETE FROM rasd_realisasi_temp WHERE ID_SPP_FORM = '$ID_SPP_FORM'");
		return $hasil;
	}

	function SPP_form_list_by_id_spp_form($ID_SPP_FORM)
	{
		$hasil = $this->db->query("SELECT 
		SPP_form.ID_SPP, 
		SPP_form.ID_SPP_FORM,
        SPP_form.ID_BARANG_MASTER,
        SPP_form.ID_JENIS_BARANG,
		SPP_form.NAMA_BARANG,
		SPP_form.SATUAN_BARANG, 
		SPP_form.MEREK, 
		SPP_form.PERALATAN_PERLENGKAPAN,
		SPP_form.SPESIFIKASI_SINGKAT, 
		SPP_form.JUMLAH_BARANG,
		SPP_form.HARGA_SATUAN_BARANG_FIX,
		SPP_form.HARGA_TOTAL_FIX,
		SPP_form.JUMLAH_BARANG,
		SPP_form.CORET, 
		SPP_form.TANGGAL_MULAI_PAKAI_HARI,
		SPP_form.TANGGAL_SELESAI_PAKAI_HARI,
        S.CREATE_BY_USER,
        U.ID_PEGAWAI,
        P.NAMA,
        P.ID_DEPARTEMEN_PEGAWAI,
		M.ID_BARANG_MASTER,
		M.PERALATAN_PERLENGKAPAN,
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
        S.ID_PROYEK,
		S.NO_URUT_SPP
        FROM SPP_form
        LEFT JOIN barang_master AS M ON SPP_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = SPP_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = SPP_form.ID_JENIS_BARANG
        LEFT JOIN spp AS S ON S.ID_SPP = SPP_form.ID_SPP
        LEFT JOIN users AS U ON U.id = S.CREATE_BY_USER
        LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = U.ID_PEGAWAI
        WHERE SPP_form.ID_SPP_FORM = '$ID_SPP_FORM' AND S.NO_URUT_SPP
		ORDER BY J.NAMA_JENIS_BARANG ASC");
		return $hasil->row();
	}

	function sign_spp_by_id_spp_non_result($ID_SPP)
	{
		$hasil = $this->db->query("SELECT
		SIGN_USER_M_PROC,
		SIGN_USER_SM,
		SIGN_USER_M_QAQC,
		SIGN_USER_M_HSSE,
		SIGN_USER_M_EP,
		SIGN_USER_M_KONS,
		SIGN_USER_M_LOG,
		SIGN_USER_M_KEU,
		SIGN_USER_D_KEU,
		SIGN_USER_D_EP_KONS,
		SIGN_USER_D_PSDS
        FROM spp
        WHERE ID_SPP = '$ID_SPP'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data BARANG MASTER berdasarkan ID_SPP
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller rfq_form / function index
	//         2. 
	function barang_master_where_not_in_spp_and_rasd($ID_SPP)
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.KODE_BARANG, M.MEREK, M.HASH_MD5_BARANG_MASTER, M.PERALATAN_PERLENGKAPAN,
		J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, M.ID_BARANG_MASTER
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
        WHERE 
        	NOT EXISTS 
            	(SELECT ID_BARANG_MASTER 
				FROM RASD_FORM 
				WHERE RASD_FORM.ID_BARANG_MASTER = M.ID_BARANG_MASTER 
				AND RASD_FORM.ID_RASD = (SELECT ID_RASD FROM spp WHERE ID_SPP = '$ID_SPP'))
           	AND
            NOT EXISTS
            	(SELECT ID_BARANG_MASTER
                 FROM spp_form
                 WHERE spp_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                 AND spp_form.ID_SPP = '$ID_SPP')
            	");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_SPP
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller SPP_form / function index
	//         2. 
	function rasd_form_list_where_not_in_spp($ID_SPP)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER, RB.PERALATAN_PERLENGKAPAN,
		RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, RB.NAMA,
        RB.MEREK, RB.SPESIFIKASI_SINGKAT, J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG
		FROM RASD_FORM as RB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG OR RB.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		WHERE 
            NOT EXISTS
                (SELECT spp_form.ID_RASD_FORM, spp_form.ID_BARANG_MASTER
                 FROM spp_form WHERE spp_form.ID_RASD_FORM = RB.ID_RASD_FORM
                AND spp_form.ID_SPP = '$ID_SPP')
        AND NOT EXISTS
        		(SELECT spp_form.ID_BARANG_MASTER 
                 FROM spp_form WHERE spp_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                AND spp_form.ID_SPP='$ID_SPP')
		AND RB.ID_RASD = (SELECT ID_RASD FROM spp WHERE ID_SPP = '$ID_SPP')");
		return $hasil->result();
	}

	//original ya harus dibuat ulang
	// function sppb_form_list_where_not_in_spp($ID_SPP, $ID_SPPB)
	// {
	// 	$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER, SS.ID_SPPB, SS.NO_URUT_SPPB, SS.HASH_MD5_SPPB, DATE_FORMAT(SF.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI, DATE_FORMAT(SF.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI, SF.ID_SPPB_FORM, SF.JUMLAH_MINTA, SF.JUMLAH_QTY_SPP, SF.NAMA_BARANG, SF.MEREK, SF.PERALATAN_PERLENGKAPAN, SF.SPESIFIKASI_SINGKAT, SF.STATUS_SPPB, SF.CORET, SF.SATUAN_BARANG, J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, SS.ID_PROYEK, SF.ID_KLASIFIKASI_BARANG, KB.NAMA_KLASIFIKASI_BARANG, PSP.NAMA_SUB_PEKERJAAN, RABF.NAMA_KATEGORI
	// 	FROM SPPB_FORM as SF
    //     LEFT JOIN sppb as SS ON SS.ID_SPPB = SF.ID_SPPB
	// 	LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=SF.ID_BARANG_MASTER 
	// 	LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG OR SF.ID_JENIS_BARANG=J.ID_JENIS_BARANG
	// 	LEFT JOIN klasifikasi_barang as KB ON KB.ID_KLASIFIKASI_BARANG = SF.ID_KLASIFIKASI_BARANG
    //     LEFT JOIN proyek_sub_pekerjaan as PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = SF.ID_PROYEK_SUB_PEKERJAAN
	// 	LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = SF.ID_RAB_FORM
	// 	WHERE 
    //         NOT EXISTS
    //             (SELECT spp_form.ID_SPPB_FORM, spp_form.ID_BARANG_MASTER
    //              FROM spp_form WHERE spp_form.ID_SPPB_FORM = SF.ID_SPPB_FORM
    //             AND spp_form.ID_SPP = '$ID_SPP')
    //     AND SF.ID_SPPB = '$ID_SPPB' AND SF.STATUS_SPPB = 'SELESAI' AND SF.CORET <> 1 AND SF.JUMLAH_QTY_SPP > 0 AND SF.STATUS_SPP = '' AND SF.KET_SPP = '' AND SS.ID_PROYEK = (SELECT spp.ID_PROYEK FROM spp where spp.ID_SPP = '$ID_SPP')");
	// 	return $hasil->result();
	// }

	function sppb_form_list_where_not_in_spp($ID_SPP, $ID_SPPB)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER, SS.ID_SPPB, SS.NO_URUT_SPPB, SS.HASH_MD5_SPPB, DATE_FORMAT(SF.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI, DATE_FORMAT(SF.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI, SF.ID_SPPB_FORM, SF.JUMLAH_MINTA, SF.JUMLAH_QTY_SPP, SF.NAMA_BARANG, SF.MEREK, SF.PERALATAN_PERLENGKAPAN, SF.SPESIFIKASI_SINGKAT, SF.STATUS_SPPB, SF.CORET, SF.SATUAN_BARANG, J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, SS.ID_PROYEK, SF.ID_KLASIFIKASI_BARANG, KB.NAMA_KLASIFIKASI_BARANG, PSP.NAMA_SUB_PEKERJAAN, RABF.NAMA_KATEGORI
		FROM SPPB_FORM as SF
        LEFT JOIN sppb as SS ON SS.ID_SPPB = SF.ID_SPPB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=SF.ID_BARANG_MASTER 
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG OR SF.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN klasifikasi_barang as KB ON KB.ID_KLASIFIKASI_BARANG = SF.ID_KLASIFIKASI_BARANG
        LEFT JOIN proyek_sub_pekerjaan as PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = SF.ID_PROYEK_SUB_PEKERJAAN
		LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = SF.ID_RAB_FORM
		
		WHERE
        SF.ID_SPPB = '$ID_SPPB' AND SF.STATUS_SPPB = 'SELESAI' AND SF.CORET <> 1 AND SF.JUMLAH_QTY_SPP > 0 AND SF.COMPLETE = '' AND SS.ID_PROYEK = (SELECT spp.ID_PROYEK FROM spp where spp.ID_SPP = '$ID_SPP')");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk mengecek rfq berdasarkan NAMA
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function simpan_data_di_luar_barang_master
	//         2. 
	function cek_nama_barang_spp_form($NAMA,$ID_SPP)
	{
		$hsl = $this->db->query("SELECT NAMA_BARANG AS NAMA FROM SPP_form WHERE NAMA_BARANG ='$NAMA' AND ID_SPP ='$ID_SPP' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'NAMA' => $data->NAMA
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk menambahkan data rfq form berdasarkan data RASD
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function simpan_data_dari_rasd_form
	//         2. 
	function simpan_data_dari_rasd_form(
		$ID_SPP,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO spp_form (
				ID_SPP,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG)
			VALUES(
				'$ID_SPP',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel SPP_form
	//DIPAKAI: 1. controller SPP_form / function simpan_data_di_luar_barang_master
	//         2. 
	function simpan_data_di_luar_barang_master(
		$ID_SPP,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$ID_VENDOR,
		$HARGA_SATUAN_BARANG_FIX,
		$HARGA_TOTAL_FIX,
		$TANGGAL_MULAI_PAKAI_HARI
	) {
		$hasil = $this->db->query("INSERT INTO SPP_form (
				ID_SPP,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG,
				ID_VENDOR_FIX,
				HARGA_SATUAN_BARANG_FIX,
				HARGA_TOTAL_FIX,
				TANGGAL_MULAI_PAKAI_HARI)
			VALUES(
				'$ID_SPP',
				'$ID_BARANG_MASTER',
				'$ID_RASD_FORM',
				'$SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG',
				'$ID_VENDOR',
				'$HARGA_SATUAN_BARANG_FIX',
				'$HARGA_TOTAL_FIX',
				'$TANGGAL_MULAI_PAKAI_HARI' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data rfq form berdasarkan ID_RFQ
	//SUMBER TABEL: tabel RFQ_form
	//DIPAKAI: 1. controller RFQ_form / function simpan_data_dari_barang_master
	//         2. 
	function simpan_data_dari_barang_master(
		$ID_SPP,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO SPP_form (
				ID_SPP,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG)
			VALUES(
				'$ID_SPP',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG' )");
		return $hasil;
	}

	function simpan_data_dari_sppb_form(
		$ID_SPPB_FORM, $ID_SPP
	) {
		$hsl_2 = $this->db->query("SELECT SF.ID_SPPB_FORM, SF.ID_RASD_FORM, SF.ID_RAB_FORM, SF.ID_SPPB, SF.ID_PROYEK_SUB_PEKERJAAN, SF.SATUAN_BARANG, SF.ID_KLASIFIKASI_BARANG, SF.NAMA_BARANG, SF.MEREK, SF.SPESIFIKASI_SINGKAT, SF.JUMLAH_SETUJU_TERAKHIR, SF.TANGGAL_MULAI_PAKAI_HARI, SF.TANGGAL_SELESAI_PAKAI_HARI, SF.JUMLAH_QTY_SPP, SF.KETERANGAN_UMUM
		FROM sppb_form AS SF
		LEFT JOIN fpb_form AS FPBF ON SF.ID_FPB_FORM = FPBF.ID_FPB_FORM
		WHERE SF.ID_SPPB_FORM = '$ID_SPPB_FORM'");
		if ($hsl_2->num_rows() > 0) {
			foreach ($hsl_2->result() as $data) {
				$hasil_2 = array(
					'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
					'ID_RASD_FORM' => $data->ID_RASD_FORM,
					'ID_RAB_FORM' => $data->ID_RAB_FORM,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'JUMLAH_SETUJU_TERAKHIR' => $data->JUMLAH_SETUJU_TERAKHIR,
					'TANGGAL_MULAI_PAKAI_HARI' => $data->TANGGAL_MULAI_PAKAI_HARI,
					'TANGGAL_SELESAI_PAKAI_HARI' => $data->TANGGAL_SELESAI_PAKAI_HARI,
					'JUMLAH_QTY_SPP' => $data->JUMLAH_QTY_SPP,
					'KETERANGAN_UMUM' => $data->KETERANGAN_UMUM
				);

				$hsl_3 = $this->db->query("SELECT SUM(JUMLAH_BARANG) AS JUMLAH_BARANG from spp_form WHERE ID_SPPB_FORM='$data->ID_SPPB_FORM'");

				if ($hsl_3->num_rows() > 0) {
					foreach ($hsl_3->result() as $data) {

						$hasil_3 = array(
							'JUMLAH_BARANG' => $data->JUMLAH_BARANG
						);

					}
				}

				$jumlah_sisa = $hasil_2['JUMLAH_QTY_SPP'] - $hasil_3['JUMLAH_BARANG'];

				$ID_SPPB_FORM = $hasil_2['ID_SPPB_FORM'];
				$ID_SPPB = $hasil_2['ID_SPPB'];
				$ID_RASD_FORM = $hasil_2['ID_RASD_FORM'];
				$ID_RAB_FORM = $hasil_2['ID_RAB_FORM'];
				$ID_PROYEK_SUB_PEKERJAAN = $hasil_2['ID_PROYEK_SUB_PEKERJAAN'];
				$SATUAN_BARANG = $hasil_2['SATUAN_BARANG'];
				$ID_KLASIFIKASI_BARANG = $hasil_2['ID_KLASIFIKASI_BARANG'];
				$NAMA_BARANG = $hasil_2['NAMA_BARANG'];
				$MEREK = $hasil_2['MEREK'];
				$SPESIFIKASI_SINGKAT = $hasil_2['SPESIFIKASI_SINGKAT'];
				$TANGGAL_MULAI_PAKAI_HARI = $hasil_2['TANGGAL_MULAI_PAKAI_HARI'];
				$TANGGAL_SELESAI_PAKAI_HARI = $hasil_2['TANGGAL_SELESAI_PAKAI_HARI'];
				$KETERANGAN_UMUM = $hasil_2['KETERANGAN_UMUM'];

				$this->db->query(
					"INSERT INTO spp_form (ID_SPP, ID_SPPB_FORM, ID_SPPB, ID_RASD_FORM, ID_RAB_FORM, ID_PROYEK_SUB_PEKERJAAN, SATUAN_BARANG, ID_KLASIFIKASI_BARANG, NAMA_BARANG, MEREK, SPESIFIKASI_SINGKAT, JUMLAH_BARANG, TANGGAL_MULAI_PAKAI_HARI, TANGGAL_SELESAI_PAKAI_HARI, KETERANGAN_UMUM)
					VALUES ('$ID_SPP', 
					'$ID_SPPB_FORM',
					'$ID_SPPB', 
					'$ID_RASD_FORM',
					'$ID_RAB_FORM',
					'$ID_PROYEK_SUB_PEKERJAAN', 
					'$SATUAN_BARANG', 
					'$ID_KLASIFIKASI_BARANG', 
					'$NAMA_BARANG', 
					'$MEREK', 
					'$SPESIFIKASI_SINGKAT', 
					'$jumlah_sisa',
					'$TANGGAL_MULAI_PAKAI_HARI',
					'$TANGGAL_SELESAI_PAKAI_HARI',
					'$KETERANGAN_UMUM'
					)"
				);

				// $this->db->query(
				// 	"UPDATE sppb_form SET 
				// 	STATUS_SPP='Dalam Proses SPP', KET_SPP='$ID_SPP'
				// 	WHERE ID_SPPB_FORM='$data->ID_SPPB_FORM'"
				// );
			}
		}
	}

	function simpan_identitas_form($ID_SPP, $NO_URUT_SPP_GANTI, $TANGGAL_DOKUMEN_SPP, $JENIS_PERMINTAAN, $CTT_DEPT_PROC, $BARIS_KOSONG )
	{
		$hasil = $this->db->query("UPDATE SPP SET
			NO_URUT_SPP='$NO_URUT_SPP_GANTI',
			TANGGAL_DOKUMEN_SPP='$TANGGAL_DOKUMEN_SPP',
			JENIS_PERMINTAAN='$JENIS_PERMINTAAN',
			CTT_DEPT_PROC='$CTT_DEPT_PROC',
			BARIS_KOSONG='$BARIS_KOSONG'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function simpan_item_spp_kontrol_anggaran($ID_SPP, $ID_RAB_FORM, $ID_PROYEK_SUB_PEKERJAAN, $NAMA_KATEGORI, $RENCANA_ANGGARAN, $PENGADAAN_SEBELUMNYA, $PENGADAAN_SAAT_INI, $TOTAL_PENGADAAN, $SISA_ANGGARAN){
		$hasil=$this->db->query("INSERT INTO spp_kontrol_anggaran (ID_SPP, ID_RAB_FORM, ID_PROYEK_SUB_PEKERJAAN, NAMA_KATEGORI, RENCANA_ANGGARAN, PENGADAAN_SEBELUMNYA, PENGADAAN_SAAT_INI, TOTAL_PENGADAAN, SISA_ANGGARAN) VALUES ('$ID_SPP', '$ID_RAB_FORM', '$ID_PROYEK_SUB_PEKERJAAN', '$NAMA_KATEGORI', '$RENCANA_ANGGARAN', '$PENGADAAN_SEBELUMNYA', '$PENGADAAN_SAAT_INI', '$TOTAL_PENGADAAN', '$SISA_ANGGARAN')");
		return $hasil;
	}

	function ubah_TAMPILKAN_KONTROL_ANGGARAN($HASH_MD5_SPP){

		$hsl_2 = $this->db->query("SELECT TAMPILKAN_KONTROL_ANGGARAN
		FROM spp
		WHERE HASH_MD5_SPP='$HASH_MD5_SPP'");

		if ($hsl_2->num_rows() > 0) {
			foreach ($hsl_2->result() as $data) {

				if ($data->TAMPILKAN_KONTROL_ANGGARAN == "TAMPIL")
				{
					$this->db->query("UPDATE spp SET TAMPILKAN_KONTROL_ANGGARAN='SEMBUNYI' WHERE HASH_MD5_SPP='$HASH_MD5_SPP'");
				}
				else
				{
					$this->db->query("UPDATE spp SET TAMPILKAN_KONTROL_ANGGARAN='TAMPIL' WHERE HASH_MD5_SPP='$HASH_MD5_SPP'");
				}

			}
		}
		else {
			$this->db->query("UPDATE spp SET TAMPILKAN_KONTROL_ANGGARAN='TAMPIL' WHERE HASH_MD5_SPP='$HASH_MD5_SPP'");
		}

		return $hsl_2->result();

	}

	function update_item_spp_kontrol_anggaran($ID_SPP, $ID_RAB_FORM, $ID_PROYEK_SUB_PEKERJAAN, $NAMA_KATEGORI, $RENCANA_ANGGARAN, $PENGADAAN_SEBELUMNYA, $PENGADAAN_SAAT_INI, $TOTAL_PENGADAAN, $SISA_ANGGARAN)
	{
		$hasil = $this->db->query("UPDATE spp_kontrol_anggaran SET 
			ID_PROYEK_SUB_PEKERJAAN='$ID_PROYEK_SUB_PEKERJAAN',
			NAMA_KATEGORI='$NAMA_KATEGORI',
			RENCANA_ANGGARAN='$RENCANA_ANGGARAN',
			PENGADAAN_SEBELUMNYA='$PENGADAAN_SEBELUMNYA',
			PENGADAAN_SAAT_INI='$PENGADAAN_SAAT_INI',
			TOTAL_PENGADAAN='$TOTAL_PENGADAAN',
			SISA_ANGGARAN ='$SISA_ANGGARAN'
			WHERE ID_SPP='$ID_SPP' AND ID_RAB_FORM='$ID_RAB_FORM' ");

		$hsl_2 = $this->db->query("SELECT *
		FROM spp_kontrol_anggaran AS SPP_ANGGARAN_TEMP
		WHERE SPP_ANGGARAN_TEMP.PENGADAAN_SAAT_INI = 0");
		if ($hsl_2->num_rows() > 0) {
			foreach ($hsl_2->result() as $data) {
				$hasil_2 = array(
					'ID_SPP_KONTROL_ANGGARAN' => $data->ID_SPP_KONTROL_ANGGARAN,
				);

				$this->db->query(
					"DELETE FROM spp_kontrol_anggaran WHERE ID_SPP_KONTROL_ANGGARAN = '$data->ID_SPP_KONTROL_ANGGARAN'"
				);
			}
		}

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RFQ form ID_SPPB_FORM
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function get_data
	//         2. controller rfq_form / function hapus_data
	//		   3. controller rfq_form / function update_data
	function get_data_by_id_spp_form($ID_SPP_FORM)
	{
		$hsl = $this->db->query("SELECT
		SF.ID_SPP,
		SF.ID_SPP_FORM,
		SF.ID_SPPB,
		SF.ID_SPPB_FORM,
		SF.ID_RAB_FORM,
		SF.ID_PROYEK_SUB_PEKERJAAN,
		SF.ID_KLASIFIKASI_BARANG,
		SF.NAMA_BARANG,
		SF.SATUAN_BARANG, 
		SF.MEREK,
		SF.JENIS_PENGADAAN,
		SF.PERALATAN_PERLENGKAPAN,
		SF.KETERANGAN_STAFF_PROC_PROYEK,
		SF.KETERANGAN_SPV_PROC_PROYEK,
		SF.KETERANGAN_SM,
		SF.KETERANGAN_PM,
		SF.KETERANGAN_STAFF_PROC_KP,
		SF.KETERANGAN_KASIE_PROC_KP,
		SF.KETERANGAN_M_PROC_KP,
		SF.KETERANGAN_M_KONS,
		SF.KETERANGAN_M_HSSE,
		SF.KETERANGAN_M_QAQC,
		SF.KETERANGAN_M_KEU,
		SF.KETERANGAN_M_SDM,
		SF.KETERANGAN_M_LOG,
		SF.KETERANGAN_M_EP,
		SF.KETERANGAN_M_MARKETING,
		SF.KETERANGAN_M_KOMERSIAL,
		SF.KETERANGAN_D_PSDS,
		SF.KETERANGAN_D_EP_KONS,
		SF.KETERANGAN_D_KEU,
		SF.KETERANGAN_UMUM,
		SF.SPESIFIKASI_SINGKAT, 
		SF.JUMLAH_BARANG,
        SF.ID_VENDOR_FIX,
		V.NAMA_VENDOR,
		SF.HARGA_SATUAN_BARANG_FIX,
		SF.HARGA_TOTAL_FIX,
		DATE_FORMAT(SF.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI,
		DATE_FORMAT(SF.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI,
		M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, RB.ID_RASD_FORM,
        J.NAMA_JENIS_BARANG,
		J.ID_JENIS_BARANG
        FROM spp_form as SF
        LEFT JOIN barang_master AS M ON SF.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = SF.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = SF.ID_JENIS_BARANG
		LEFT JOIN vendor AS V ON V.ID_VENDOR = SF.ID_VENDOR_FIX
		LEFT JOIN klasifikasi_barang as KB ON KB.ID_KLASIFIKASI_BARANG = SF.ID_KLASIFIKASI_BARANG
        WHERE SF.ID_SPP_FORM = '$ID_SPP_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPP' => $data->ID_SPP,
					'ID_SPP_FORM' => $data->ID_SPP_FORM,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
					'ID_RAB_FORM' => $data->ID_RAB_FORM,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'ID_RASD_FORM' => $data->ID_RASD_FORM,
					'KODE_BARANG' => $data->KODE_BARANG,
					'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
					'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'KETERANGAN_STAFF_PROC_PROYEK' => $data->KETERANGAN_STAFF_PROC_PROYEK,
					'KETERANGAN_SPV_PROC_PROYEK' => $data->KETERANGAN_SPV_PROC_PROYEK,
					'KETERANGAN_SM' => $data->KETERANGAN_SM,
					'KETERANGAN_PM' => $data->KETERANGAN_PM,
					'KETERANGAN_STAFF_PROC_KP' => $data->KETERANGAN_STAFF_PROC_KP,
					'KETERANGAN_KASIE_PROC_KP' => $data->KETERANGAN_KASIE_PROC_KP,
					'KETERANGAN_M_PROC_KP' => $data->KETERANGAN_M_PROC_KP,
					'KETERANGAN_M_KONS' => $data->KETERANGAN_M_KONS,
					'KETERANGAN_M_HSSE' => $data->KETERANGAN_M_HSSE,
					'KETERANGAN_M_QAQC' => $data->KETERANGAN_M_QAQC,
					'KETERANGAN_M_KEU' => $data->KETERANGAN_M_KEU,
					'KETERANGAN_M_SDM' => $data->KETERANGAN_M_SDM,
					'KETERANGAN_M_LOG' => $data->KETERANGAN_M_LOG,
					'KETERANGAN_M_EP' => $data->KETERANGAN_M_EP,
					'KETERANGAN_M_MARKETING' => $data->KETERANGAN_M_MARKETING,
					'KETERANGAN_M_KOMERSIAL' => $data->KETERANGAN_M_KOMERSIAL,
					'KETERANGAN_D_PSDS' => $data->KETERANGAN_D_PSDS,
					'KETERANGAN_D_EP_KONS' => $data->KETERANGAN_D_EP_KONS,
					'KETERANGAN_D_KEU' => $data->KETERANGAN_D_KEU,
					'KETERANGAN_UMUM' => $data->KETERANGAN_UMUM,
					'JENIS_PENGADAAN' => $data->JENIS_PENGADAAN,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'ID_VENDOR' => $data->ID_VENDOR_FIX,
					'HARGA_SATUAN_BARANG_FIX' => $data->HARGA_SATUAN_BARANG_FIX,
					'HARGA_TOTAL_FIX' => $data->HARGA_TOTAL_FIX,
					'TANGGAL_MULAI_PAKAI_HARI' => $data->TANGGAL_MULAI_PAKAI_HARI,
					'TANGGAL_SELESAI_PAKAI_HARI' => $data->TANGGAL_SELESAI_PAKAI_HARI
				);
			}
		} else {
			$hasil = "BELUM ADA SPP BARANG";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RFQ by ID_RFQ
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function get_data_rfq

	function get_data_spp_by_id_spp($ID_SPP)
	{
		$hsl = $this->db->query("SELECT * 
        FROM spp
        WHERE ID_SPP = '$ID_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPP ' => $data->ID_SPP ,
					'HASH_MD5_SPP' => $data->HASH_MD5_SPP,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_RASD' => $data->ID_RASD,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_VENDOR' => $data->ID_VENDOR,
					'NO_URUT_SPP' => $data->NO_URUT_SPP,
					'JENIS_PERMINTAAN' => $data->JENIS_PERMINTAAN,
					'TOP' => $data->TOP,
					'LOKASI_PENYERAHAN' => $data->LOKASI_PENYERAHAN,
					'TANGGAL_PEMBUATAN_SPP_JAM' => $data->TANGGAL_PEMBUATAN_SPP_JAM
				);
			}
		} else {
			$hasil = "BELUM ADA SPP BARANG";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data rfq form berdasarkan ID_RFQ_FORM
	//SUMBER TABEL: tabel rfq
	//DIPAKAI: 1. controller RFQ_form / function update_data
	//         
	function update_data($ID_SPP_FORM,
	$NAMA,
	$MEREK,
	$SPESIFIKASI_SINGKAT,
	$JUMLAH_BARANG,
	$SATUAN_BARANG,
	$ID_KLASIFIKASI_BARANG,
	$JENIS_PENGADAAN,
	$TANGGAL_MULAI_PAKAI_HARI,
	$TANGGAL_SELESAI_PAKAI_HARI,
	$KETERANGAN_UMUM,
	$ID_PROYEK_SUB_PEKERJAAN,
	$ID_RAB_FORM,
	$ID_RASD_FORM,
	$ID_VENDOR_FIX,
	$HARGA_SATUAN_BARANG_FIX,
	$HARGA_TOTAL_FIX)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			NAMA_BARANG='$NAMA',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			JUMLAH_BARANG='$JUMLAH_BARANG',
			SATUAN_BARANG='$SATUAN_BARANG',
			ID_KLASIFIKASI_BARANG='$ID_KLASIFIKASI_BARANG',
			JENIS_PENGADAAN='$JENIS_PENGADAAN',
			TANGGAL_MULAI_PAKAI_HARI='$TANGGAL_MULAI_PAKAI_HARI',
			TANGGAL_SELESAI_PAKAI_HARI='$TANGGAL_SELESAI_PAKAI_HARI',
			KETERANGAN_UMUM='$KETERANGAN_UMUM',
			ID_PROYEK_SUB_PEKERJAAN='$ID_PROYEK_SUB_PEKERJAAN',
			ID_RAB_FORM='$ID_RAB_FORM',
			ID_RASD_FORM='$ID_RASD_FORM',
			ID_VENDOR_FIX='$ID_VENDOR_FIX',
			HARGA_SATUAN_BARANG_FIX='$HARGA_SATUAN_BARANG_FIX',
			HARGA_TOTAL_FIX='$HARGA_TOTAL_FIX'
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_from_excel($ID_SPP,
	$ID_SPP_FORM,
	$NAMA_BARANG,
	$MEREK,
	$SPESIFIKASI_SINGKAT,
	$JUMLAH_BARANG,
	$SATUAN_BARANG,
	$ID_VENDOR_FIX,
	$HARGA_SATUAN_BARANG_FIX,
	$HARGA_TOTAL_FIX,
	$JENIS_PEMBELIAN,
	$KETERANGAN_UMUM)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			NAMA_BARANG='$NAMA_BARANG',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			JUMLAH_BARANG='$JUMLAH_BARANG',
			SATUAN_BARANG='$SATUAN_BARANG',
			JENIS_PENGADAAN='$JENIS_PEMBELIAN',
			KETERANGAN_UMUM='$KETERANGAN_UMUM',
			ID_VENDOR_FIX='$ID_VENDOR_FIX',
			HARGA_SATUAN_BARANG_FIX='$HARGA_SATUAN_BARANG_FIX',
			HARGA_TOTAL_FIX='$HARGA_TOTAL_FIX'
			WHERE ID_SPP_FORM='$ID_SPP_FORM' AND ID_SPP='$ID_SPP'");
		return $hasil;
	}

	


	//FUNGSI: Fungsi ini untuk menghapus data rfq berdasarkan ID_RFQ_FORM
	//SUMBER TABEL: tabel RFQ_form
	//DIPAKAI: 1. controller RFQ_form / function hapus_data
	//         2. 
	function hapus_data_by_id_spp_form($ID_SPP_FORM)
	{
		$hasil = $this->db->query("DELETE FROM spp_form WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function hapus_data_by_id_spp($ID_SPP)
	{
		$hasil = $this->db->query("DELETE FROM spp_kontrol_anggaran WHERE ID_SPP='$ID_SPP'");

		$hasil = $this->db->query("DELETE FROM rasd_realisasi_temp WHERE ID_SPP = '$ID_SPP'");

		$hasil = $this->db->query("DELETE FROM spp_form WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}


	//FUNGSI: Fungsi ini untuk menampilkan data catatat RFQ form berdasarkan ID_RFQFORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_keterangan_barang
	//         2. 
	function get_keterangan_by_id_spp_form($ID_SPP_FORM)
	{
		$hsl = $this->db->query("SELECT 
		ID_SPP_FORM, 
		KETERANGAN_STAFF_PROC_PROYEK,
		KETERANGAN_SPV_PROC_PROYEK,
		KETERANGAN_SM,
		KETERANGAN_PM,
		KETERANGAN_STAFF_PROC_KP,
		KETERANGAN_KASIE_PROC_KP,
		KETERANGAN_M_PROC_KP,
		KETERANGAN_M_KONS,
		KETERANGAN_M_HSSE,
		KETERANGAN_M_QAQC,
		KETERANGAN_M_KEU,
		KETERANGAN_M_SDM,
		KETERANGAN_M_LOG,
		KETERANGAN_M_EP,
		KETERANGAN_M_MARKETING,
		KETERANGAN_M_KOMERSIAL,
		KETERANGAN_D_PSDS,
		KETERANGAN_D_EP_KONS,
		KETERANGAN_D_KEU

		FROM SPP_FORM

        WHERE ID_SPP_FORM = '$ID_SPP_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPP_FORM' => $data->ID_SPP_FORM,
					'KETERANGAN_STAFF_PROC_PROYEK' => $data->KETERANGAN_STAFF_PROC_PROYEK,
					'KETERANGAN_SPV_PROC_PROYEK' => $data->KETERANGAN_SPV_PROC_PROYEK,
					'KETERANGAN_SM' => $data->KETERANGAN_SM,
					'KETERANGAN_PM' => $data->KETERANGAN_PM,
					'KETERANGAN_STAFF_PROC_KP' => $data->KETERANGAN_STAFF_PROC_KP,
					'KETERANGAN_KASIE_PROC_KP' => $data->KETERANGAN_KASIE_PROC_KP,
					'KETERANGAN_M_PROC_KP' => $data->KETERANGAN_M_PROC_KP,
					'KETERANGAN_M_KONS' => $data->KETERANGAN_M_KONS,
					'KETERANGAN_M_HSSE' => $data->KETERANGAN_M_HSSE,
					'KETERANGAN_M_QAQC' => $data->KETERANGAN_M_QAQC,
					'KETERANGAN_M_KEU' => $data->KETERANGAN_M_KEU,
					'KETERANGAN_M_SDM' => $data->KETERANGAN_M_SDM,
					'KETERANGAN_M_LOG' => $data->KETERANGAN_M_LOG,
					'KETERANGAN_M_EP' => $data->KETERANGAN_M_EP,
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

	//FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPP_FORM
	//SUMBER TABEL: tabel spp_form
	//DIPAKAI: 1. controller SPP_form / function update_data_keterangan_barang
	//         2. 
	function update_data_KETERANGAN_STAFF_PROC_PROYEK($ID_SPP_FORM, $KETERANGAN_STAFF_PROC_PROYEK)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_STAFF_PROC_PROYEK='$KETERANGAN_STAFF_PROC_PROYEK' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_SPV_PROC_PROYEK($ID_SPP_FORM, $KETERANGAN_SPV_PROC_PROYEK)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_SPV_PROC_PROYEK='$KETERANGAN_SPV_PROC_PROYEK' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_SM($ID_SPP_FORM, $KETERANGAN_SM)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_SM='$KETERANGAN_SM' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_PM($ID_SPP_FORM, $KETERANGAN_PM)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_PM='$KETERANGAN_PM' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_STAFF_PROC_KP($ID_SPP_FORM, $KETERANGAN_STAFF_PROC_KP)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_STAFF_PROC_KP='$KETERANGAN_STAFF_PROC_KP' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_KASIE_PROC_KP($ID_SPP_FORM, $KETERANGAN_KASIE_PROC_KP)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_KASIE_PROC_KP='$KETERANGAN_KASIE_PROC_KP' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_PROC_KP($ID_SPP_FORM, $KETERANGAN_M_PROC_KP)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_M_PROC_KP='$KETERANGAN_M_PROC_KP' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_KONS($ID_SPP_FORM, $KETERANGAN_M_KONS)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_M_KONS='$KETERANGAN_M_KONS' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_HSSE($ID_SPP_FORM, $KETERANGAN_M_HSSE)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_M_HSSE='$KETERANGAN_M_HSSE' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_QAQC($ID_SPP_FORM, $KETERANGAN_M_QAQC)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_M_QAQC='$KETERANGAN_M_QAQC' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_KEU($ID_SPP_FORM, $KETERANGAN_M_KEU)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_M_KEU='$KETERANGAN_M_KEU' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_SDM($ID_SPP_FORM, $KETERANGAN_M_SDM)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_M_SDM='$KETERANGAN_M_SDM' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_LOG($ID_SPP_FORM, $KETERANGAN_M_LOG)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_M_LOG='$KETERANGAN_M_LOG' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_EP($ID_SPP_FORM, $KETERANGAN_M_EP)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_M_EP='$KETERANGAN_M_EP' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}
	
	function update_data_KETERANGAN_M_MARKETING($ID_SPP_FORM, $KETERANGAN_M_MARKETING)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_M_MARKETING='$KETERANGAN_M_MARKETING' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_M_KOMERSIAL($ID_SPP_FORM, $KETERANGAN_M_KOMERSIAL)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_M_KOMERSIAL='$KETERANGAN_M_KOMERSIAL' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_D_PSDS($ID_SPP_FORM, $KETERANGAN_D_PSDS)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_D_PSDS='$KETERANGAN_D_PSDS' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_D_EP_KONS($ID_SPP_FORM, $KETERANGAN_D_EP_KONS)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_D_EP_KONS='$KETERANGAN_D_EP_KONS' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_KETERANGAN_D_KEU($ID_SPP_FORM, $KETERANGAN_D_KEU)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			KETERANGAN_D_KEU='$KETERANGAN_D_KEU' 
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data rfq berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function update_data_keterangan_barang
	//         2. 
	function update_data_harga_barang($ID_SPP_FORM, $HARGA_SATUAN_BARANG, $HARGA_TOTAL)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			HARGA_SATUAN_BARANG='$HARGA_SATUAN_BARANG',
			HARGA_TOTAL='$HARGA_TOTAL'
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_data_total_harga_spp_barang($ID_SPP, $TOTAL_HARGA_SPP_BARANG)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			TOTAL_HARGA_SPP_BARANG='$TOTAL_HARGA_SPP_BARANG'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_status_id_sppb_form_complete($ID_SPPB_FORM)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			COMPLETE='TERPENUHI'
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function update_status_id_sppb_form_incomplete($ID_SPPB_FORM)
	{
		$hasil = $this->db->query("UPDATE sppb_form SET 
			COMPLETE=''
			WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
		return $hasil;
	}

	function get_data_catatan_spp_by_id_spp($ID_SPP)
	{
		$hsl = $this->db->query("SELECT 
		ID_SPP,
		CTT_STAFF_PROC_PROYEK,
		CTT_SPV_PROC_PROYEK,
		CTT_SM,
		CTT_PM,
		CTT_STAFF_PROC_KP,
		CTT_KASIE_PROC_KP,
		CTT_M_LOG,
		CTT_M_KEU,
		CTT_M_KONS,
		CTT_M_SDM,
		CTT_M_QAQC,
		CTT_M_EP,
		CTT_M_HSSE,
		CTT_M_MARKETING,
		CTT_M_KOMERSIAL,
		CTT_M_PROC,
		CTT_D_KEU,
		CTT_D_EP_KONS,
		CTT_D_PSDS

		FROM SPP

        WHERE ID_SPP = '$ID_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPP' => $data->ID_SPP,
					'CTT_STAFF_PROC_PROYEK' => $data->CTT_STAFF_PROC_PROYEK,
					'CTT_SPV_PROC_PROYEK' => $data->CTT_SPV_PROC_PROYEK,
					'CTT_SM' => $data->CTT_SM,
					'CTT_PM' => $data->CTT_PM,
					'CTT_STAFF_PROC_KP' => $data->CTT_STAFF_PROC_KP,
					'CTT_KASIE_PROC_KP' => $data->CTT_KASIE_PROC_KP,

					'CTT_M_LOG' => $data->CTT_M_LOG,
					'CTT_M_KEU' => $data->CTT_M_KEU,
					'CTT_M_KONS' => $data->CTT_M_KONS,
					'CTT_M_SDM' => $data->CTT_M_SDM,
					'CTT_M_QAQC' => $data->CTT_M_QAQC,
					'CTT_M_EP' => $data->CTT_M_EP,
					'CTT_M_HSSE' => $data->CTT_M_HSSE,
					'CTT_M_MARKETING' => $data->CTT_M_MARKETING,
					'CTT_M_KOMERSIAL' => $data->CTT_M_KOMERSIAL,
					'CTT_M_PROC' => $data->CTT_M_PROC,

					'CTT_D_KEU' => $data->CTT_D_KEU,
					'CTT_D_EP_KONS' => $data->CTT_D_EP_KONS,
					'CTT_D_PSDS' => $data->CTT_D_PSDS
				);
			}
		} else {
			$hasil = "TIDAK ADA CATATAN";
		}
		return $hasil;
	}

	function get_data_catatan_spp_by_HASH_MD5_SPP($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT 
		ID_SPP,
		CTT_STAFF_PROC_PROYEK,
		CTT_SPV_PROC_PROYEK,
		CTT_SM,
		CTT_PM,
		CTT_STAFF_PROC_KP,
		CTT_KASIE_PROC_KP,
		CTT_M_LOG,
		CTT_M_KEU,
		CTT_M_KONS,
		CTT_M_SDM,
		CTT_M_QAQC,
		CTT_M_EP,
		CTT_M_HSSE,
		CTT_M_MARKETING,
		CTT_M_KOMERSIAL,
		CTT_M_PROC,
		CTT_D_KEU,
		CTT_D_EP_KONS,
		CTT_D_PSDS

		FROM SPP

        WHERE HASH_MD5_SPP = '$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPP' => $data->ID_SPP,
					'CTT_STAFF_PROC_PROYEK' => $data->CTT_STAFF_PROC_PROYEK,
					'CTT_SPV_PROC_PROYEK' => $data->CTT_SPV_PROC_PROYEK,
					'CTT_SM' => $data->CTT_SM,
					'CTT_PM' => $data->CTT_PM,
					'CTT_STAFF_PROC_KP' => $data->CTT_STAFF_PROC_KP,
					'CTT_KASIE_PROC_KP' => $data->CTT_KASIE_PROC_KP,

					'CTT_M_LOG' => $data->CTT_M_LOG,
					'CTT_M_KEU' => $data->CTT_M_KEU,
					'CTT_M_KONS' => $data->CTT_M_KONS,
					'CTT_M_SDM' => $data->CTT_M_SDM,
					'CTT_M_QAQC' => $data->CTT_M_QAQC,
					'CTT_M_EP' => $data->CTT_M_EP,
					'CTT_M_HSSE' => $data->CTT_M_HSSE,
					'CTT_M_MARKETING' => $data->CTT_M_MARKETING,
					'CTT_M_KOMERSIAL' => $data->CTT_M_KOMERSIAL,
					'CTT_M_PROC' => $data->CTT_M_PROC,

					'CTT_D_KEU' => $data->CTT_D_KEU,
					'CTT_D_EP_KONS	' => $data->CTT_D_EP_KONS,
					'CTT_D_PSDS' => $data->CTT_D_PSDS
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
	function get_data_catatan_spp_by_id_spp_non_result($ID_SPP)
	{
		$hsl = $this->db->query("SELECT 
		ID_SPP, 
		CTT_STAFF_PROC_PROYEK,
		CTT_SPV_PROC_PROYEK,
		CTT_SM,
		CTT_PM,
		CTT_STAFF_PROC_KP,
		CTT_KASIE_PROC_KP,
		CTT_M_LOG,
		CTT_M_KEU,
		CTT_M_KONS,	
		CTT_M_SDM,
		CTT_M_QAQC,
		CTT_M_EP,
		CTT_M_HSSE,
		CTT_M_MARKETING,
		CTT_M_KOMERSIAL,
		CTT_M_PROC,
		CTT_D_KEU,
		CTT_D_EP_KONS,
		CTT_D_PSDS

		FROM SPP

        WHERE ID_SPP = '$ID_SPP'");
		return $hsl;
	}

	function get_data_keterangan_barang_by_id_spp($ID_SPP)
	{
		$hsl = $this->db->query("SELECT 
		NAMA_BARANG,
        KETERANGAN_STAFF_PROC_PROYEK,
		KETERANGAN_SPV_PROC_PROYEK,
		KETERANGAN_SM,
		KETERANGAN_PM,
		KETERANGAN_STAFF_PROC_KP,
		KETERANGAN_KASIE_PROC_KP,
		KETERANGAN_M_PROC_KP,
		KETERANGAN_M_KONS,
		KETERANGAN_M_HSSE,
		KETERANGAN_M_QAQC,
		KETERANGAN_M_KEU,
		KETERANGAN_M_SDM,
		KETERANGAN_M_LOG,
		KETERANGAN_M_EP,
		KETERANGAN_M_MARKETING,
		KETERANGAN_M_KOMERSIAL,
		KETERANGAN_D_PSDS,
		KETERANGAN_D_EP_KONS,
		KETERANGAN_D_KEU

		FROM spp_form

        WHERE ID_SPP = '$ID_SPP' AND (
        KETERANGAN_STAFF_PROC_PROYEK IS NOT NULL OR
		KETERANGAN_SPV_PROC_PROYEK IS NOT NULL OR
		KETERANGAN_SM IS NOT NULL OR
		KETERANGAN_PM IS NOT NULL OR
		KETERANGAN_STAFF_PROC_KP IS NOT NULL OR
		KETERANGAN_KASIE_PROC_KP IS NOT NULL OR
		KETERANGAN_M_PROC_KP IS NOT NULL OR
		KETERANGAN_M_KONS IS NOT NULL OR
		KETERANGAN_M_HSSE IS NOT NULL OR
		KETERANGAN_M_QAQC IS NOT NULL OR
		KETERANGAN_M_KEU IS NOT NULL OR
		KETERANGAN_M_SDM IS NOT NULL OR
		KETERANGAN_M_LOG IS NOT NULL OR
		KETERANGAN_M_EP IS NOT NULL OR
		KETERANGAN_M_MARKETING IS NOT NULL OR
		KETERANGAN_M_KOMERSIAL IS NOT NULL OR
		KETERANGAN_D_PSDS IS NOT NULL OR
		KETERANGAN_D_EP_KONS IS NOT NULL OR
		KETERANGAN_D_KEU IS NOT NULL)");
		return $hsl->result();
	}


	// //FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb form
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function data_sppb_form
	// //         2. 
	// function sppb_form_list_by_id_sppb($ID_SPPB)
	// {
	// 	$hasil = $this->db->query("SELECT sppb_form.ID_SPPB, sppb_form.ID_SPPB_FORM, 
	// 	sppb_form.NAMA_BARANG, sppb_form.MEREK, 
	// 	sppb_form.SPESIFIKASI_SINGKAT, 
	// 	sppb_form.JUMLAH_BARANG, sppb_form.CORET, sppb_form.POSISI,sppb_form.JUMLAH_SETUJU_TERAKHIR,
	// 	sppb_form.JUSTIFIKASI_STAFF_LOG, sppb_form.JUSTIFIKASI_SVP_LOG, sppb_form.JUSTIFIKASI_CHIEF, sppb_form.JUSTIFIKASI_SM, sppb_form.JUSTIFIKASI_PM,
	// 	sppb_form.TOLAK_SPV_LOG,
	// 	sppb_form.TOLAK_SM,
	// 	sppb_form.TOLAK_PM,
	// 	sppb_form.TOLAK_M_LOG,
	// 	sppb_form.TOLAK_M_PROC,
	// 	sppb_form.TOLAK_M_SDM,
	// 	sppb_form.TOLAK_M_KONS,
	// 	sppb_form.TOLAK_M_EP,
	// 	sppb_form.TOLAK_M_QAQC,
	// 	sppb_form.TOLAK_M_KEU,
	// 	sppb_form.TOLAK_D_PSDS,
	// 	sppb_form.TOLAK_D_KONS,
	// 	sppb_form.TOLAK_D_KEU,
	// 	sppb_form.TANGGAL_MULAI_PAKAI_HARI_HARI,
	// 	sppb_form.TANGGAL_SELESAI_PAKAI_HARI_HARI,
	// 	M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
    //     RB.ID_RASD, RB.ID_RASD_FORM, RB.TOTAL_PENGADAAN_SAAT_INI,
    //     RB.JUMLAH_BARANG AS JUMLAH_RASD,
    //     J.NAMA_JENIS_BARANG,
    //     SB.NAMA_SATUAN_BARANG
    //     FROM sppb_form
    //     LEFT JOIN barang_master AS M ON sppb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
    //     LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = sppb_form.ID_RASD_FORM
    //     LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = sppb_form.ID_JENIS_BARANG
    //     LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = sppb_form.ID_SATUAN_BARANG 
    //     WHERE ID_SPPB = '$ID_SPPB'");
	// 	return $hasil->result();
	// }

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form berdasarkan ID_RASD
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller (BELUM) / function (BELUM)
	// //         2. 
	// function sppb_barang_list_by_id_rasd($ID_RASD)
	// {
	// 	$hasil = $this->db->query("SELECT M.NAMA, RB.NAMA AS NAMA_RASD_FORM, RB.MEREK AS MEREK_RASD_FORM,RB.SPESIFIKASI_SINGKAT AS SPESIFIKASI_SINGKAT_RASD_FORM, RB.SATUAN_BARANG AS SATUAN_BARANG_RASD_FORM, M.KODE_BARANG, M.MEREK, J.NAMA_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, 
	// 	M.SATUAN_BARANG,RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, M.ID_BARANG_MASTER 
	// 	FROM sppb_form as RB
	// 	LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
	// 	LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
    //     WHERE RB.ID_RASD = '$ID_RASD'");
	// 	return $hasil->result();
	// }

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel barang_master
	// //DIPAKAI: 1. controller SPPB_form / function index
	// //         2. controller SPPB-form / function view_only
	// function barang_master_where_not_in_sppb_and_rasd($ID_SPPB)
	// {
	// 	$hasil = $this->db->query("SELECT M.NAMA, M.KODE_BARANG, M.MEREK, M.HASH_MD5_BARANG_MASTER, 
	// 	J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
	// 	M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG 
	// 	FROM barang_master as M
	// 	LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
	// 	LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
    //     WHERE 
    //     	NOT EXISTS 
    //         	(SELECT ID_BARANG_MASTER 
	// 			FROM RASD_FORM 
	// 			WHERE RASD_FORM.ID_BARANG_MASTER = M.ID_BARANG_MASTER 
	// 			AND RASD_FORM.ID_RASD = (SELECT ID_RASD FROM sppb WHERE ID_SPPB = '$ID_SPPB'))
    //        	AND
    //         NOT EXISTS
    //         	(SELECT ID_BARANG_MASTER
    //              FROM sppb_form
    //              WHERE sppb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
    //              AND sppb_form.ID_SPPB = '$ID_SPPB')
    //         	");
	// 	return $hasil->result();
	// }

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel RASD_FORM
	// //DIPAKAI: 1. controller SPPB_form / function index
	// //         2. controller SPPB-form / function view_only
	// function rasd_form_list_where_not_in_sppb($ID_SPPB)
	// {
	// 	$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER,
	// 	RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, RB.NAMA,
    //     RB.MEREK, RB.SPESIFIKASI_SINGKAT,
    //     SB.NAMA_SATUAN_BARANG, SB.ID_SATUAN_BARANG,
    //     J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG
	// 	FROM RASD_FORM as RB
	// 	LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
	// 	LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG OR RB.ID_JENIS_BARANG=J.ID_JENIS_BARANG
	// 	LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG OR RB.ID_SATUAN_BARANG = SB.ID_SATUAN_BARANG
	// 	WHERE 
    //         NOT EXISTS
    //             (SELECT sppb_form.ID_RASD_FORM, sppb_form.ID_BARANG_MASTER
    //              FROM sppb_form WHERE sppb_form.ID_RASD_FORM = RB.ID_RASD_FORM
    //             AND sppb_form.ID_SPPB = '$ID_SPPB')
    //     AND NOT EXISTS
    //     		(SELECT sppb_form.ID_BARANG_MASTER 
    //              FROM sppb_form WHERE sppb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
    //             AND sppb_form.ID_SPPB='$ID_SPPB')
	// 	AND RB.ID_RASD = (SELECT ID_RASD FROM sppb WHERE ID_SPPB = '$ID_SPPB')");
	// 	return $hasil->result();
	// }

	// //FUNGSI: Fungsi ini untuk menghapus data sppb form ID_SPPB_FORM
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function hapus_data
	// //         2. 
	// function hapus_data_by_id_sppb_form($ID_SPPB_FORM)
	// {
	// 	$hasil = $this->db->query("DELETE FROM sppb_form WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB_FORM
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function get_data
	// //         2. controller SPPB_form / function hapus_data
	// //		   3. controller SPPB_form / function update_data
	// function get_data_by_id_sppb_form($ID_SPPB_FORM)
	// {
	// 	$hsl = $this->db->query("SELECT sppb_form.ID_SPPB_FORM, sppb_form.NAMA_BARANG, sppb_form.MEREK, 
	// 	sppb_form.JUSTIFIKASI_STAFF_LOG,
	// 	sppb_form.JUSTIFIKASI_SVP_LOG,
	// 	sppb_form.JUSTIFIKASI_CHIEF,
	// 	sppb_form.JUSTIFIKASI_SM,
	// 	sppb_form.JUSTIFIKASI_PM,
	// 	sppb_form.SPESIFIKASI_SINGKAT, 
	// 	sppb_form.JUMLAH_BARANG,
	// 	M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
    //     RB.ID_RASD, RB.ID_RASD_FORM,
    //     J.NAMA_JENIS_BARANG,
    //     SB.NAMA_SATUAN_BARANG
    //     FROM sppb_form
    //     LEFT JOIN barang_master AS M ON sppb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
    //     LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = sppb_form.ID_RASD_FORM
    //     LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = sppb_form.ID_JENIS_BARANG
    //     LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = sppb_form.ID_SATUAN_BARANG 
    //     WHERE sppb_form.ID_SPPB_FORM = '$ID_SPPB_FORM'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
	// 				'KODE_BARANG' => $data->KODE_BARANG,
	// 				'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
	// 				'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
	// 				'NAMA_BARANG' => $data->NAMA_BARANG,
	// 				'MEREK' => $data->MEREK,
	// 				'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
	// 				'JUSTIFIKASI_STAFF_LOG' => $data->JUSTIFIKASI_STAFF_LOG,
	// 				'JUSTIFIKASI_SVP_LOG' => $data->JUSTIFIKASI_SVP_LOG,
	// 				'JUSTIFIKASI_CHIEF' => $data->JUSTIFIKASI_CHIEF,
	// 				'JUSTIFIKASI_SM' => $data->JUSTIFIKASI_SM,
	// 				'JUSTIFIKASI_PM' => $data->JUSTIFIKASI_PM
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA SPPB Barang";
	// 	}
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB_FORM
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function update_data_justifikasi_barang
	// //         2. 
	// function get_justifikasi_by_id_sppb_form($ID_SPPB_FORM)
	// {
	// 	$hsl = $this->db->query("SELECT 
	// 	ID_SPPB_FORM, 
	// 	JUSTIFIKASI_STAFF_LOG,
	// 	JUSTIFIKASI_SVP_LOG,
	// 	JUSTIFIKASI_CHIEF,
	// 	JUSTIFIKASI_SM,
	// 	JUSTIFIKASI_PM

	// 	FROM SPPB_FORM

    //     WHERE ID_SPPB_FORM = '$ID_SPPB_FORM'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
	// 				'JUSTIFIKASI_STAFF_LOG' => $data->JUSTIFIKASI_STAFF_LOG,
	// 				'JUSTIFIKASI_SVP_LOG' => $data->JUSTIFIKASI_SVP_LOG,
	// 				'JUSTIFIKASI_CHIEF' => $data->JUSTIFIKASI_CHIEF,
	// 				'JUSTIFIKASI_SM' => $data->JUSTIFIKASI_SM,
	// 				'JUSTIFIKASI_PM' => $data->JUSTIFIKASI_PM
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "TIDAK ADA JUSTIFIKASI";
	// 	}
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel sppb
	// //DIPAKAI: 1. controller SPPB_form / function index
	// //         2. controller SPPB_form / function get_data_catatan_sppb
	// //         2. controller SPPB_form / function update_data_catatan_sppb
	// function get_data_catatan_sppb_by_id_sppb($ID_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT 
	// 	ID_SPPB, 
	// 	CTT_STAFF_LOG,
	// 	CTT_SPV_LOG,
	// 	CTT_CHIEF,
	// 	CTT_SM,
	// 	CTT_PM,
	// 	CTT_M_LOG,
	// 	CTT_M_PROC,
	// 	CTT_M_SDM,
	// 	CTT_M_KONS,
	// 	CTT_M_EP,
	// 	CTT_M_QAQC,	
	// 	CTT_M_KEU,
	// 	CTT_D_PSDS,
	// 	CTT_D_KONS,
	// 	CTT_D_KEU	

	// 	FROM SPPB

    //     WHERE ID_SPPB = '$ID_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_SPPB' => $data->ID_SPPB,
	// 				'CTT_STAFF_LOG' => $data->CTT_STAFF_LOG,
	// 				'CTT_SPV_LOG' => $data->CTT_SPV_LOG,
	// 				'CTT_CHIEF' => $data->CTT_CHIEF,
	// 				'CTT_SM' => $data->CTT_SM,
	// 				'CTT_PM' => $data->CTT_PM,
	// 				'CTT_M_LOG' => $data->CTT_M_LOG,

	// 				'CTT_M_PROC' => $data->CTT_M_PROC,
	// 				'CTT_M_SDM' => $data->CTT_M_SDM,
	// 				'CTT_M_KONS' => $data->CTT_M_KONS,
	// 				'CTT_M_EP' => $data->CTT_M_EP,
	// 				'CTT_M_QAQC' => $data->CTT_M_QAQC,
	// 				'CTT_M_KEU' => $data->CTT_M_KEU,

	// 				'CTT_D_PSDS' => $data->CTT_D_PSDS,
	// 				'CTT_D_KONS' => $data->CTT_D_KONS,
	// 				'CTT_D_KEU' => $data->CTT_D_KEU
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "TIDAK ADA CATATAN";
	// 	}
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function update_data_justifikasi_barang
	// //         2. 
	// function update_data_JUSTIFIKASI_STAFF_LOG($ID_SPPB_FORM, $JUSTIFIKASI_STAFF_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb_form SET 
	// 		JUSTIFIKASI_STAFF_LOG='$JUSTIFIKASI_STAFF_LOG' 
	// 		WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function update_data_justifikasi_barang
	// //         2. 
	// function update_data_JUSTIFIKASI_SVP_LOG($ID_SPPB_FORM, $JUSTIFIKASI_SVP_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb_form SET 
	// 		JUSTIFIKASI_SVP_LOG='$JUSTIFIKASI_SVP_LOG' 
	// 		WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function update_data_justifikasi_barang
	// //         2. 
	// function update_data_JUSTIFIKASI_CHIEF($ID_SPPB_FORM, $JUSTIFIKASI_CHIEF)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb_form SET 
	// 		JUSTIFIKASI_CHIEF='$JUSTIFIKASI_CHIEF' 
	// 		WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function update_data_coret
	// //         2. 
	// function update_data_coret($ID_SPPB_FORM)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb_form SET 
	// 		CORET=1 
	// 		WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function update_data_batal_coret
	// //         2. 
	// function update_data_batal_coret($ID_SPPB_FORM)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb_form SET 
	// 		CORET=0 
	// 		WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk mengubah data spp form ID_SPP_FORM
	//SUMBER TABEL: tabel spp_form
	//DIPAKAI: 1. controller SPP_form / function update_data_coret
	//         2. 
	function update_data_coret($ID_SPP_FORM, $CATATAN_CORET)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			CORET=1, CATATAN_CORET = '$CATATAN_CORET'
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPP_FORM
	//SUMBER TABEL: tabel spp_form
	//DIPAKAI: 1. controller SPP_form / function update_data_batal_coret
	//         2. 
	function update_data_batal_coret($ID_SPP_FORM, $CATATAN_BATAL_CORET)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			CORET=0, CATATAN_BATAL_CORET = '$CATATAN_BATAL_CORET'
			WHERE ID_SPP_FORM = '$ID_SPP_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function update_data_catatan_sppb
	//         2. 
	function update_data_CTT_STAFF_PROC_PROYEK($ID_SPP, $CTT_STAFF_PROC_PROYEK)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_STAFF_PROC_PROYEK='$CTT_STAFF_PROC_PROYEK' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_SPV_PROC_PROYEK($ID_SPP, $CTT_SPV_PROC_PROYEK)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_SPV_PROC_PROYEK='$CTT_SPV_PROC_PROYEK' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_SM($ID_SPP, $CTT_SM)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_SM='$CTT_SM' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_PM($ID_SPP, $CTT_PM)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_PM='$CTT_PM' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_STAFF_PROC_KP($ID_SPP, $CTT_STAFF_PROC_KP)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_STAFF_PROC_KP='$CTT_STAFF_PROC_KP' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_KASIE_PROC_KP($ID_SPP, $CTT_KASIE_PROC_KP)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_KASIE_PROC_KP='$CTT_KASIE_PROC_KP' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_M_LOG($ID_SPP, $CTT_M_LOG)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_M_LOG='$CTT_M_LOG' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_M_KEU($ID_SPP, $CTT_M_KEU)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_M_KEU='$CTT_M_KEU' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_M_KONS($ID_SPP, $CTT_M_KONS)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_M_KONS='$CTT_M_KONS' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_M_SDM($ID_SPP, $CTT_M_SDM)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_M_SDM='$CTT_M_SDM' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_M_QAQC($ID_SPP, $CTT_M_QAQC)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_M_QAQC='$CTT_M_QAQC' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_M_EP($ID_SPP, $CTT_M_EP)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_M_EP='$CTT_M_EP' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_M_HSSE($ID_SPP, $CTT_M_HSSE)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_M_HSSE='$CTT_M_HSSE' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_M_MARKETING($ID_SPP, $CTT_M_MARKETING)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_M_MARKETING='$CTT_M_MARKETING' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_M_KOMERSIAL($ID_SPP, $CTT_M_KOMERSIAL)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_M_KOMERSIAL='$CTT_M_KOMERSIAL' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_M_PROC($ID_SPP, $CTT_M_PROC)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_M_PROC='$CTT_M_PROC' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_D_KEU($ID_SPP, $CTT_D_KEU)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_D_KEU='$CTT_D_KEU' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_D_EP_KONS($ID_SPP, $CTT_D_EP_KONS)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_D_EP_KONS='$CTT_D_EP_KONS' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_CTT_D_PSDS($ID_SPP, $CTT_D_PSDS)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			CTT_D_PSDS='$CTT_D_PSDS' 
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	

	//FUNGSI: Fungsi ini untuk mengubah data SPP form by ID_SPP
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function update_data_kirim_sppb
	//         2. 
	function update_data_kirim_spp($ID_SPP, $PROGRESS_SPP, $STATUS_SPP)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP' 
			WHERE ID_SPP='$ID_SPP'");

		$hsl = $this->db->query("SELECT * from rasd_realisasi_temp WHERE ID_SPP='$ID_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {

				$this->db->query("INSERT INTO rasd_realisasi (
					ID_RAB_FORM,
					ID_RASD_FORM,
					ID_SPP,
					ID_SPP_FORM,
					SATUAN_BARANG,
					JUMLAH_BARANG,
					HARGA_BARANG,
					HARGA_TOTAL)
				VALUES(
					'$data->ID_RAB_FORM',
					'$data->ID_RASD_FORM',
					'$data->ID_SPP',
					'$data->ID_SPP_FORM',
					'$data->SATUAN_BARANG',
					'$data->JUMLAH_BARANG',
					'$data->HARGA_BARANG',
					'$data->HARGA_TOTAL')");
			}
		}
		
		return $hasil;
	}

	function update_data_kirim_spp_user_sm_sp($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_SM)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_SM='$SIGN_USER_SM'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_kirim_spp_user_m_log($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_M_LOG)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_M_LOG='$SIGN_USER_M_LOG'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_kirim_spp_user_m_keu($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_M_KEU)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_M_KEU='$SIGN_USER_M_KEU'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_kirim_spp_user_m_kons($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_M_KONS)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_M_KONS='$SIGN_USER_M_KONS'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_kirim_spp_user_m_qaqc($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_M_QAQC)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_M_QAQC='$SIGN_USER_M_QAQC'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_kirim_spp_user_m_hsse($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_M_HSSE)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_M_HSSE='$SIGN_USER_M_HSSE'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_kirim_spp_user_m_ep($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_M_EP)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_M_EP='$SIGN_USER_M_EP'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_kirim_spp_user_m_proc($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_M_PROC)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_M_PROC='$SIGN_USER_M_PROC'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_kirim_spp_user_d_keu($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_D_KEU)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_D_KEU='$SIGN_USER_D_KEU'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_kirim_spp_user_d_psds($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_D_PSDS)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_D_PSDS='$SIGN_USER_D_PSDS'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_data_kirim_spp_user_d_ep_kons($ID_SPP, $PROGRESS_SPP, $STATUS_SPP, $SIGN_USER_D_EP_KONS)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP',
			STATUS_SPP='$STATUS_SPP',
			SIGN_USER_D_EP_KONS='$SIGN_USER_D_EP_KONS'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_status_po_by_id_spp_form($ID_SPP_FORM, $ID_PO)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			STATUS_PO='Dalam Proses PO', KET_PO='$ID_PO'
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	function update_delete_status_po_by_id_spp_form($ID_SPP_FORM)
	{
		$hasil = $this->db->query("UPDATE spp_form SET 
			STATUS_PO='', KET_PO=''
			WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil;
	}

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB_FORM
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function update_data_proses
	// //         2. 
	// function update_data_proses($ID_SPPB_FORM, $JUMLAH_SETUJU_TERAKHIR)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb_form SET 
	// 		JUMLAH_SETUJU_TERAKHIR='$JUMLAH_SETUJU_TERAKHIR' 
	// 		WHERE ID_SPPB_FORM='$ID_SPPB_FORM'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function simpan_data_dari_rasd_form
	// //         2. 
	// function simpan_data_dari_rasd_form(
	// 	$ID_SPPB,
	// 	$ID_BARANG_MASTER,
	// 	$ID_RASD_FORM,
	// 	$ID_SATUAN_BARANG,
	// 	$ID_JENIS_BARANG,
	// 	$NAMA,
	// 	$MEREK,
	// 	$SPESIFIKASI_SINGKAT,
	// 	$JUMLAH_BARANG
	// ) {
	// 	$hasil = $this->db->query("INSERT INTO sppb_form (
	// 			ID_SPPB,
	// 			ID_BARANG_MASTER,
	// 			ID_RASD_FORM,
	// 			ID_SATUAN_BARANG,
	// 			ID_JENIS_BARANG,
	// 			NAMA_BARANG,
	// 			MEREK,
	// 			SPESIFIKASI_SINGKAT,
	// 			JUMLAH_BARANG)
	// 		VALUES(
	// 			'$ID_SPPB',
	// 			$ID_BARANG_MASTER,
	// 			$ID_RASD_FORM,
	// 			'$ID_SATUAN_BARANG',
	// 			'$ID_JENIS_BARANG',
	// 			'$NAMA',
	// 			'$MEREK',
	// 			'$SPESIFIKASI_SINGKAT',
	// 			'$JUMLAH_BARANG' )");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function simpan_data_dari_barang_master
	// //         2. 
	// function simpan_data_dari_barang_master(
	// 	$ID_SPPB,
	// 	$ID_BARANG_MASTER,
	// 	$ID_RASD_FORM,
	// 	$ID_SATUAN_BARANG,
	// 	$ID_JENIS_BARANG,
	// 	$NAMA,
	// 	$MEREK,
	// 	$SPESIFIKASI_SINGKAT,
	// 	$JUMLAH_BARANG
	// ) {
	// 	$hasil = $this->db->query("INSERT INTO sppb_form (
	// 			ID_SPPB,
	// 			ID_BARANG_MASTER,
	// 			ID_RASD_FORM,
	// 			ID_SATUAN_BARANG,
	// 			ID_JENIS_BARANG,
	// 			NAMA_BARANG,
	// 			MEREK,
	// 			SPESIFIKASI_SINGKAT,
	// 			JUMLAH_BARANG)
	// 		VALUES(
	// 			'$ID_SPPB',
	// 			$ID_BARANG_MASTER,
	// 			$ID_RASD_FORM,
	// 			'$ID_SATUAN_BARANG',
	// 			'$ID_JENIS_BARANG',
	// 			'$NAMA',
	// 			'$MEREK',
	// 			'$SPESIFIKASI_SINGKAT',
	// 			'$JUMLAH_BARANG' )");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel sppb_form
	// //DIPAKAI: 1. controller SPPB_form / function simpan_data_di_luar_barang_master
	// //         2. 
	// function simpan_data_di_luar_barang_master(
	// 	$ID_SPPB,
	// 	$ID_BARANG_MASTER,
	// 	$ID_RASD_FORM,
	// 	$ID_SATUAN_BARANG,
	// 	$ID_JENIS_BARANG,
	// 	$NAMA,
	// 	$MEREK,
	// 	$SPESIFIKASI_SINGKAT,
	// 	$JUMLAH_BARANG
	// ) {
	// 	$hasil = $this->db->query("INSERT INTO sppb_form (
	// 			ID_SPPB,
	// 			ID_BARANG_MASTER,
	// 			ID_RASD_FORM,
	// 			ID_SATUAN_BARANG,
	// 			ID_JENIS_BARANG,
	// 			NAMA_BARANG,
	// 			MEREK,
	// 			SPESIFIKASI_SINGKAT,
	// 			JUMLAH_BARANG)
	// 		VALUES(
	// 			'$ID_SPPB',
	// 			$ID_BARANG_MASTER,
	// 			$ID_RASD_FORM,
	// 			'$ID_SATUAN_BARANG',
	// 			'$ID_JENIS_BARANG',
	// 			'$NAMA',
	// 			'$MEREK',
	// 			'$SPESIFIKASI_SINGKAT',
	// 			'$JUMLAH_BARANG' )");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_USER
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function logout
	//         2. controller SPPB_form / function user_log
	function user_log_spp_form($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_spp_form (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
