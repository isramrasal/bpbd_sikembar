<?php
class Nota_pengambilan_form_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb form
	//SUMBER TABEL: tabel nota_pengambilan_form
	//DIPAKAI: 1. controller nota_pengambilan_form / function data_nota_pengambilan_form
	//         2. 
	function nota_pengambilan_form_list_by_id_nota_pengambilan($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT nota_pengambilan_form.ID_SPPB, 
		nota_pengambilan_form.ID_nota_pengambilan_form,
        nota_pengambilan_form.ID_FPB_FORM,
		nota_pengambilan_form.NAMA_BARANG,
		nota_pengambilan_form.MEREK, 
		nota_pengambilan_form.SPESIFIKASI_SINGKAT, 
		nota_pengambilan_form.JUMLAH_MINTA,
		nota_pengambilan_form.BIDANG_PEMAKAI,
		nota_pengambilan_form.CORET,
		nota_pengambilan_form.CATATAN_CORET,
		nota_pengambilan_form.CATATAN_BATAL_CORET, 
		nota_pengambilan_form.POSISI,
		nota_pengambilan_form.JUMLAH_SETUJU_STAFF_LOG,
		nota_pengambilan_form.JUMLAH_SETUJU_TERAKHIR,
		nota_pengambilan_form.JUMLAH_SETUJU_SPV_LOG,
		nota_pengambilan_form.JUMLAH_SETUJU_CHIEF,
		nota_pengambilan_form.JUMLAH_SETUJU_SM,
		nota_pengambilan_form.JUMLAH_SETUJU_PM,
		nota_pengambilan_form.JUMLAH_SETUJU_M_LOG,
		nota_pengambilan_form.JUMLAH_SETUJU_M_PROC,
		nota_pengambilan_form.JUMLAH_SETUJU_M_SDM,
		nota_pengambilan_form.JUMLAH_SETUJU_M_KONS,
		nota_pengambilan_form.JUMLAH_SETUJU_M_EP,
		nota_pengambilan_form.JUMLAH_SETUJU_M_QAQC,
		nota_pengambilan_form.JUMLAH_SETUJU_M_KEU,
		nota_pengambilan_form.JUMLAH_SETUJU_D_PSDS,
		nota_pengambilan_form.JUMLAH_SETUJU_D_KEU,
		nota_pengambilan_form.JUMLAH_SETUJU_D_KEU,
		nota_pengambilan_form.JUSTIFIKASI_STAFF_LOG, 
		nota_pengambilan_form.JUSTIFIKASI_SVP_LOG, 
		nota_pengambilan_form.JUSTIFIKASI_CHIEF, 
		nota_pengambilan_form.JUSTIFIKASI_SM, 
		nota_pengambilan_form.JUSTIFIKASI_PM,
		nota_pengambilan_form.TOLAK_SPV_LOG,
		nota_pengambilan_form.TOLAK_SM,
		nota_pengambilan_form.TOLAK_PM,
		nota_pengambilan_form.TOLAK_M_LOG,
		nota_pengambilan_form.TOLAK_M_PROC,
		nota_pengambilan_form.TOLAK_M_SDM,
		nota_pengambilan_form.TOLAK_M_KONS,
		nota_pengambilan_form.TOLAK_M_EP,
		nota_pengambilan_form.TOLAK_M_QAQC,
		nota_pengambilan_form.TOLAK_M_KEU,
		nota_pengambilan_form.TOLAK_D_PSDS,
		nota_pengambilan_form.TOLAK_D_KONS,
		nota_pengambilan_form.TOLAK_D_KEU,
		nota_pengambilan_form.TANGGAL_MULAI_PAKAI_HARI,
		nota_pengambilan_form.TANGGAL_SELESAI_PAKAI_HARI,
		nota_pengambilan_form.JUMLAH_QTY_GUDANG,
		nota_pengambilan_form.JUMLAH_QTY_SPP,
		M.ID_BARANG_MASTER, 
		M.KODE_BARANG, 
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, 
		RB.ID_RASD_FORM, 
		RB.TOTAL_PENGADAAN_SAAT_INI,
        RB.JUMLAH_BARANG AS JUMLAH_RASD,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG,
        SPB.ID_RASD AS ID_RASD_MASTER,
		SPB.ID_PROYEK,
        FF.ID_FPB,
        FB.HASH_MD5_FPB,
        FB.NO_URUT_FPB,
		M.PERALATAN_PERLENGKAPAN
        FROM nota_pengambilan_form
        LEFT JOIN barang_master AS M ON nota_pengambilan_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN RASD_FORM AS RB ON RB.ID_RASD_FORM = nota_pengambilan_form.ID_RASD_FORM
        LEFT JOIN FPB_FORM AS FF ON FF.ID_FPB_FORM = nota_pengambilan_form.ID_FPB_FORM
        LEFT JOIN FPB AS FB ON FF.ID_FPB = FB.ID_FPB
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = nota_pengambilan_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = nota_pengambilan_form.ID_SATUAN_BARANG
        LEFT JOIN sppb as SPB ON SPB.ID_SPPB = nota_pengambilan_form.ID_SPPB
        WHERE nota_pengambilan_form.ID_SPPB = '$ID_SPPB'");
		return $hasil->result();
	}

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form berdasarkan ID_RASD
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller (BELUM) / function (BELUM)
	// //         2. 
	// function sppb_barang_list_by_id_rasd($ID_RASD)
	// {
	// 	$hasil = $this->db->query("SELECT M.NAMA, RB.NAMA AS NAMA_RASD_FORM, RB.MEREK AS MEREK_RASD_FORM,RB.SPESIFIKASI_SINGKAT AS SPESIFIKASI_SINGKAT_RASD_FORM, RB.SATUAN_BARANG AS SATUAN_BARANG_RASD_FORM, M.KODE_BARANG, M.MEREK, J.NAMA_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, 
	// 	M.SATUAN_BARANG,RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, M.ID_BARANG_MASTER 
	// 	FROM nota_pengambilan_form as RB
	// 	LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
	// 	LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
    //     WHERE RB.ID_RASD = '$ID_RASD'");
	// 	return $hasil->result();
	// }

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel barang_master
	// //DIPAKAI: 1. controller nota_pengambilan_form / function index
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
    //              FROM nota_pengambilan_form
    //              WHERE nota_pengambilan_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
    //              AND nota_pengambilan_form.ID_SPPB = '$ID_SPPB')
    //         	");
	// 	return $hasil->result();
	// }

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel RASD_FORM
	// //DIPAKAI: 1. controller nota_pengambilan_form / function index
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
    //             (SELECT nota_pengambilan_form.ID_RASD_FORM, nota_pengambilan_form.ID_BARANG_MASTER
    //              FROM nota_pengambilan_form WHERE nota_pengambilan_form.ID_RASD_FORM = RB.ID_RASD_FORM
    //             AND nota_pengambilan_form.ID_SPPB = '$ID_SPPB')
    //     AND NOT EXISTS
    //     		(SELECT nota_pengambilan_form.ID_BARANG_MASTER 
    //              FROM nota_pengambilan_form WHERE nota_pengambilan_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
    //             AND nota_pengambilan_form.ID_SPPB='$ID_SPPB')
	// 	AND RB.ID_RASD = (SELECT ID_RASD FROM sppb WHERE ID_SPPB = '$ID_SPPB')");
	// 	return $hasil->result();
	// }

	// function fpb_form_list_where_not_in_sppb($ID_SPPB)
	// {
	// 	$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER, F.ID_FPB, FP.NO_URUT_FPB, FP.HASH_MD5_FPB,
	// 	F.ID_FPB_FORM, F.JUMLAH_MINTA, F.JUMLAH_QTY_SPPB, F.NAMA_BARANG,
    //     F.MEREK, F.SPESIFIKASI_SINGKAT, F.STATUS_FPB, F.CORET,
    //     SB.NAMA_SATUAN_BARANG, SB.ID_SATUAN_BARANG,
    //     J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, FP.ID_PROYEK
	// 	FROM FPB_FORM as F
    //     LEFT JOIN fpb as FP ON F.ID_FPB=FP.ID_FPB
	// 	LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=F.ID_BARANG_MASTER 
	// 	LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG OR F.ID_JENIS_BARANG=J.ID_JENIS_BARANG
	// 	LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG OR F.ID_SATUAN_BARANG = SB.ID_SATUAN_BARANG
	// 	WHERE 
    //         NOT EXISTS
    //             (SELECT nota_pengambilan_form.ID_FPB_FORM, nota_pengambilan_form.ID_BARANG_MASTER
    //              FROM nota_pengambilan_form WHERE nota_pengambilan_form.ID_FPB_FORM = F.ID_FPB_FORM
    //             AND nota_pengambilan_form.ID_SPPB = '$ID_SPPB')
    //     AND F.STATUS_FPB = 'SELESAI' AND F.CORET <> 1 AND F.JUMLAH_QTY_SPPB > 0 AND F.STATUS_SPPB = '' AND F.KET_SPPB = '' AND FP.ID_PROYEK = (SELECT sppb.ID_PROYEK FROM sppb where sppb.ID_SPPB = '$ID_SPPB')");
	// 	return $hasil->result();
	// }

	// //FUNGSI: Fungsi ini untuk menghapus data sppb form ID_nota_pengambilan_form
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function hapus_data
	// //         2. 
	// function hapus_data_by_id_nota_pengambilan_form($ID_nota_pengambilan_form)
	// {
	// 	$hasil = $this->db->query("DELETE FROM nota_pengambilan_form WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// function data_quantity_rasd_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_RASD)
	// {
	// 	$hasil = $this->db->query("SELECT JUMLAH_BARANG AS jumlah_quantity_rasd, TOTAL_PENGADAAN_SAAT_INI from rasd_form WHERE (ID_BARANG_MASTER='$ID_BARANG_MASTER' AND ID_RASD= '$ID_RASD')");
	// 	return $hasil->result();
	// }

	// function data_quantity_barang_entitas_by_ID_BARANG_MASTER($ID_BARANG_MASTER, $ID_PROYEK)
	// {
	// 	$hasil = $this->db->query("SELECT COUNT(JUMLAH_BARANG) AS jumlah_quantity, POSISI from barang_entitas WHERE (ID_BARANG_MASTER='$ID_BARANG_MASTER' AND ID_PROYEK= '$ID_PROYEK' AND POSISI= 'GUDANG' AND KONDISI='DAPAT DIGUNAKAN')");
	// 	return $hasil->result();
	// }

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_nota_pengambilan_form
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function get_data
	// //         2. controller nota_pengambilan_form / function hapus_data
	// //		   3. controller nota_pengambilan_form / function update_data
	// function get_data_by_id_nota_pengambilan_form($ID_nota_pengambilan_form)
	// {
	// 	$hsl = $this->db->query("SELECT 
	// 	nota_pengambilan_form.ID_nota_pengambilan_form,
	// 	nota_pengambilan_form.ID_FPB_FORM,
	// 	nota_pengambilan_form.NAMA_BARANG, 
	// 	nota_pengambilan_form.MEREK, 
	// 	nota_pengambilan_form.JUSTIFIKASI_STAFF_LOG,
	// 	nota_pengambilan_form.JUSTIFIKASI_SVP_LOG,
	// 	nota_pengambilan_form.JUSTIFIKASI_CHIEF,
	// 	nota_pengambilan_form.JUSTIFIKASI_SM,
	// 	nota_pengambilan_form.JUSTIFIKASI_PM,
	// 	nota_pengambilan_form.SPESIFIKASI_SINGKAT, 
	// 	nota_pengambilan_form.JUMLAH_MINTA,
	// 	nota_pengambilan_form.BIDANG_PEMAKAI,
	// 	nota_pengambilan_form.TANGGAL_MULAI_PAKAI_HARI,
	// 	nota_pengambilan_form.TANGGAL_SELESAI_PAKAI_HARI,
	// 	M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
    //     RB.ID_RASD, RB.ID_RASD_FORM,
    //     J.NAMA_JENIS_BARANG,
    //     SB.NAMA_SATUAN_BARANG
    //     FROM nota_pengambilan_form
    //     LEFT JOIN barang_master AS M ON nota_pengambilan_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
    //     LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = nota_pengambilan_form.ID_RASD_FORM
    //     LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = nota_pengambilan_form.ID_JENIS_BARANG
    //     LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = nota_pengambilan_form.ID_SATUAN_BARANG 
    //     WHERE nota_pengambilan_form.ID_nota_pengambilan_form = '$ID_nota_pengambilan_form'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_nota_pengambilan_form' => $data->ID_nota_pengambilan_form,
	// 				'ID_FPB_FORM' => $data->ID_FPB_FORM,
	// 				'KODE_BARANG' => $data->KODE_BARANG,
	// 				'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
	// 				'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
	// 				'NAMA_BARANG' => $data->NAMA_BARANG,
	// 				'MEREK' => $data->MEREK,
	// 				'JUMLAH_MINTA' => $data->JUMLAH_MINTA,
	// 				'BIDANG_PEMAKAI' => $data->BIDANG_PEMAKAI,
	// 				'TANGGAL_MULAI_PAKAI_HARI' => $data->TANGGAL_MULAI_PAKAI_HARI,
	// 				'TANGGAL_SELESAI_PAKAI_HARI' => $data->TANGGAL_SELESAI_PAKAI_HARI,
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

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form ID_nota_pengambilan_form
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function update_data_justifikasi_barang
	// //         2. 
	// function get_justifikasi_by_id_nota_pengambilan_form($ID_nota_pengambilan_form)
	// {
	// 	$hsl = $this->db->query("SELECT 
	// 	ID_nota_pengambilan_form, 
	// 	JUSTIFIKASI_STAFF_LOG,
	// 	JUSTIFIKASI_SVP_LOG,
	// 	JUSTIFIKASI_CHIEF,
	// 	JUSTIFIKASI_SM,
	// 	JUSTIFIKASI_PM

	// 	FROM nota_pengambilan_form

    //     WHERE ID_nota_pengambilan_form = '$ID_nota_pengambilan_form'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_nota_pengambilan_form' => $data->ID_nota_pengambilan_form,
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
	// //DIPAKAI: 1. controller nota_pengambilan_form / function index
	// //         2. controller nota_pengambilan_form / function get_data_catatan_sppb
	// //         2. controller nota_pengambilan_form / function update_data_catatan_sppb
	// function get_data_catatan_sppb_by_id_nota_pengambilan($ID_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT 
	// 	ID_SPPB, 
	// 	CTT_STAFF_UMUM_LOG,
	// 	CTT_SPV_LOG,
	// 	CTT_CHIEF,
	// 	CTT_SM,
	// 	CTT_PM,
	// 	CTT_STAFF_LOG,
	// 	CTT_STAFF_GUDANG_LOG,
	// 	CTT_KASIE_LOG,
	// 	CTT_M_HRD,
	// 	CTT_M_KEU,
	// 	CTT_M_KONS,	
	// 	CTT_M_SDM,
	// 	CTT_M_QAQC,
	// 	CTT_M_EP,
	// 	CTT_M_HSSE,
	// 	CTT_M_MARKETING,
	// 	CTT_M_KOMERSIAL,
	// 	CTT_M_LOG,
	// 	CTT_D_KEU,
	// 	CTT_D_EP_KONS,
	// 	CTT_D_PSDS

	// 	FROM SPPB

    //     WHERE ID_SPPB = '$ID_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_SPPB' => $data->ID_SPPB,
	// 				'CTT_STAFF_UMUM_LOG' => $data->CTT_STAFF_UMUM_LOG,
	// 				'CTT_SPV_LOG' => $data->CTT_SPV_LOG,
	// 				'CTT_CHIEF' => $data->CTT_CHIEF,
	// 				'CTT_SM' => $data->CTT_SM,
	// 				'CTT_PM' => $data->CTT_PM,
	// 				'CTT_STAFF_LOG' => $data->CTT_STAFF_LOG,
	// 				'CTT_STAFF_GUDANG_LOG' => $data->CTT_STAFF_GUDANG_LOG,
	// 				'CTT_KASIE_LOG' => $data->CTT_KASIE_LOG,
	// 				'CTT_M_HRD' => $data->CTT_M_HRD,
	// 				'CTT_M_KEU' => $data->CTT_M_KEU,
	// 				'CTT_M_KONS' => $data->CTT_M_KONS,
	// 				'CTT_M_SDM' => $data->CTT_M_SDM,
	// 				'CTT_M_QAQC' => $data->CTT_M_QAQC,
	// 				'CTT_M_EP' => $data->CTT_M_EP,
	// 				'CTT_M_HSSE' => $data->CTT_M_HSSE,
	// 				'CTT_M_MARKETING' => $data->CTT_M_MARKETING,
	// 				'CTT_M_KOMERSIAL' => $data->CTT_M_KOMERSIAL,
	// 				'CTT_M_LOG' => $data->CTT_M_LOG,
	// 				'CTT_D_KEU' => $data->CTT_D_KEU,
	// 				'CTT_D_EP_KONS' => $data->CTT_D_EP_KONS,
	// 				'CTT_D_PSDS' => $data->CTT_D_PSDS,
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "TIDAK ADA CATATAN";
	// 	}
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb form NAMA
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function simpan_data_di_luar_barang_master
	// //         2. 
	// function cek_nama_barang_nota_pengambilan_form($NAMA)
	// {
	// 	$hsl = $this->db->query("SELECT ID_nota_pengambilan_form, NAMA_BARANG AS NAMA FROM nota_pengambilan_form WHERE NAMA_BARANG ='$NAMA'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_nota_pengambilan_form' => $data->ID_nota_pengambilan_form,
	// 				'NAMA' => $data->NAMA
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'Data belum ada';
	// 	}
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_nota_pengambilan_form
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function update_data_justifikasi_barang
	// //         2. 
	// function update_data_JUSTIFIKASI_STAFF_LOG($ID_nota_pengambilan_form, $JUSTIFIKASI_STAFF_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE nota_pengambilan_form SET 
	// 		JUSTIFIKASI_STAFF_LOG='$JUSTIFIKASI_STAFF_LOG' 
	// 		WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_nota_pengambilan_form
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function update_data_justifikasi_barang
	// //         2. 
	// function update_data_JUSTIFIKASI_SVP_LOG($ID_nota_pengambilan_form, $JUSTIFIKASI_SVP_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE nota_pengambilan_form SET 
	// 		JUSTIFIKASI_SVP_LOG='$JUSTIFIKASI_SVP_LOG' 
	// 		WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_nota_pengambilan_form
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function update_data_justifikasi_barang
	// //         2. 
	// function update_data_JUSTIFIKASI_CHIEF($ID_nota_pengambilan_form, $JUSTIFIKASI_CHIEF)
	// {
	// 	$hasil = $this->db->query("UPDATE nota_pengambilan_form SET 
	// 		JUSTIFIKASI_CHIEF='$JUSTIFIKASI_CHIEF' 
	// 		WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// function update_data_JUSTIFIKASI_SDM($ID_nota_pengambilan_form, $JUSTIFIKASI_SDM)
	// {
	// 	$hasil = $this->db->query("UPDATE nota_pengambilan_form SET 
	// 		JUSTIFIKASI_SDM='$JUSTIFIKASI_SDM' 
	// 		WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_nota_pengambilan_form
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function update_data_coret
	// //         2. 
	// function update_data_coret($ID_nota_pengambilan_form, $CATATAN_CORET)
	// {
	// 	$hasil = $this->db->query("UPDATE nota_pengambilan_form SET 
	// 		CORET=1, CATATAN_CORET = '$CATATAN_CORET'
	// 		WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_nota_pengambilan_form
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function update_data_batal_coret
	// //         2. 
	// function update_data_batal_coret($ID_nota_pengambilan_form, $CATATAN_BATAL_CORET)
	// {
	// 	$hasil = $this->db->query("UPDATE nota_pengambilan_form SET 
	// 		CORET=0, CATATAN_BATAL_CORET = '$CATATAN_BATAL_CORET'
	// 		WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB
	// //SUMBER TABEL: tabel sppb
	// //DIPAKAI: 1. controller nota_pengambilan_form / function update_data_catatan_sppb
	// //         2. 
	// function update_data_CTT_STAFF_UMUM_LOG($ID_SPPB, $CTT_STAFF_UMUM_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_STAFF_UMUM_LOG='$CTT_STAFF_UMUM_LOG' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_SPV_LOG($ID_SPPB, $CTT_SPV_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_SPV_LOG='$CTT_SPV_LOG' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_CHIEF($ID_SPPB, $CTT_CHIEF)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_CHIEF='$CTT_CHIEF' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_SM($ID_SPPB, $CTT_SM)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_SM='$CTT_SM' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_PM($ID_SPPB, $CTT_PM)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_PM='$CTT_PM' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_STAFF_LOG($ID_SPPB, $CTT_STAFF_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_STAFF_LOG='$CTT_STAFF_LOG' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_STAFF_GUDANG_LOG($ID_SPPB, $CTT_STAFF_GUDANG_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_STAFF_GUDANG_LOG='$CTT_STAFF_GUDANG_LOG' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_KASIE_LOG($ID_SPPB, $CTT_KASIE_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_KASIE_LOG='$CTT_KASIE_LOG' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_M_HRD($ID_SPPB, $CTT_M_HRD)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_M_HRD='$CTT_M_HRD' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_M_KEU($ID_SPPB, $CTT_M_KEU)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_M_KEU='$CTT_M_KEU' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_M_KONS($ID_SPPB, $CTT_M_KONS)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_M_KONS='$CTT_M_KONS' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_M_SDM($ID_SPPB, $CTT_M_SDM)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_M_SDM='$CTT_M_SDM' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_M_QAQC($ID_SPPB, $CTT_M_QAQC)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_M_QAQC='$CTT_M_QAQC' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_M_EP($ID_SPPB, $CTT_M_EP)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_M_EP='$CTT_M_EP' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_M_HSSE($ID_SPPB, $CTT_M_HSSE)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_M_HSSE='$CTT_M_HSSE' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_M_MARKETING($ID_SPPB, $CTT_M_MARKETING)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_M_MARKETING='$CTT_M_MARKETING' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_M_KOMERSIAL($ID_SPPB, $CTT_M_KOMERSIAL)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_M_KOMERSIAL='$CTT_M_KOMERSIAL' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_M_LOG($ID_SPPB, $CTT_M_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_M_LOG='$CTT_M_LOG' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_D_KEU($ID_SPPB, $CTT_D_KEU)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_D_KEU='$CTT_D_KEU' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_D_EP_KONS($ID_SPPB, $CTT_D_EP_KONS)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_D_EP_KONS='$CTT_D_EP_KONS' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_CTT_D_PSDS($ID_SPPB, $CTT_D_PSDS)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_D_PSDS='$CTT_D_PSDS' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_nota_pengambilan_form
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function update_data
	// //         2. controller SPPB / function update_data
	// function update_data($ID_nota_pengambilan_form, $JUMLAH_MINTA, $BIDANG_PEMAKAI, $TANGGAL_MULAI_PAKAI_HARI, $TANGGAL_SELESAI_PAKAI_HARI)
	// {
	// 	$hasil = $this->db->query("UPDATE nota_pengambilan_form SET 
	// 		JUMLAH_MINTA='$JUMLAH_MINTA',
	// 		BIDANG_PEMAKAI='$BIDANG_PEMAKAI',
	// 		TANGGAL_MULAI_PAKAI_HARI='$TANGGAL_MULAI_PAKAI_HARI',
	// 		TANGGAL_SELESAI_PAKAI_HARI='$TANGGAL_SELESAI_PAKAI_HARI'
	// 		WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// function update_quantity_spp($ID_nota_pengambilan_form, $JUMLAH_QTY_SPP, $JUMLAH_QTY_GUDANG)
	// {
	// 	$hasil = $this->db->query("UPDATE nota_pengambilan_form SET 
	// 		JUMLAH_QTY_SPP='$JUMLAH_QTY_SPP', JUMLAH_QTY_GUDANG='$JUMLAH_QTY_GUDANG'
	// 		WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// function update_data_M_LOG($ID_nota_pengambilan_form, $JUMLAH_MINTA, $JUMLAH_SETUJU_M_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE nota_pengambilan_form SET 
	// 		JUMLAH_MINTA='$JUMLAH_MINTA', 
	// 		JUMLAH_SETUJU_M_LOG='$JUMLAH_SETUJU_M_LOG'
	// 		WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB
	// //SUMBER TABEL: tabel sppb
	// //DIPAKAI: 1. controller nota_pengambilan_form / function update_data_kirim_sppb
	// //         2. 
	// function update_data_kirim_sppb($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		PROGRESS_SPPB='$PROGRESS_SPPB',
	// 		STATUS_SPPB='$STATUS_SPPB' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_kirim_sppb_user_staff_umum_logistik_sp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_STAFF_UMUM_LOG_SP)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		PROGRESS_SPPB='$PROGRESS_SPPB',
	// 		STATUS_SPPB='$STATUS_SPPB',
	// 		SIGN_USER_STAFF_UMUM_LOG_SP='$SIGN_USER_STAFF_UMUM_LOG_SP' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_kirim_sppb_user_supervisi_logistik_sp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_SUPERVISI_LOG_SP)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		PROGRESS_SPPB='$PROGRESS_SPPB',
	// 		STATUS_SPPB='$STATUS_SPPB',
	// 		SIGN_USER_SUPERVISI_LOG_SP='$SIGN_USER_SUPERVISI_LOG_SP' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_kirim_sppb_user_staff_umum_logistik_kp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_STAFF_UMUM_LOG_KP)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		PROGRESS_SPPB='$PROGRESS_SPPB',
	// 		STATUS_SPPB='$STATUS_SPPB',
	// 		SIGN_USER_STAFF_UMUM_LOG_KP='$SIGN_USER_STAFF_UMUM_LOG_KP' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// function update_data_kirim_sppb_user_staff_gudang_logistik_kp($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB, $SIGN_USER_STAFF_GUDANG_LOG_KP)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		PROGRESS_SPPB='$PROGRESS_SPPB',
	// 		STATUS_SPPB='$STATUS_SPPB',
	// 		SIGN_USER_STAFF_GUDANG_LOG_KP='$SIGN_USER_STAFF_GUDANG_LOG_KP' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_nota_pengambilan_form
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function update_data_proses
	// //         2. 
	// function update_data_proses($ID_nota_pengambilan_form, $JUMLAH_SETUJU_TERAKHIR)
	// {
	// 	$hasil = $this->db->query("UPDATE nota_pengambilan_form SET 
	// 		JUMLAH_SETUJU_TERAKHIR='$JUMLAH_SETUJU_TERAKHIR' 
	// 		WHERE ID_nota_pengambilan_form='$ID_nota_pengambilan_form'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function simpan_data_dari_rasd_form
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
	// 	$JUMLAH_MINTA
	// ) {
	// 	$hasil = $this->db->query("INSERT INTO nota_pengambilan_form (
	// 			ID_SPPB,
	// 			ID_BARANG_MASTER,
	// 			ID_RASD_FORM,
	// 			ID_SATUAN_BARANG,
	// 			ID_JENIS_BARANG,
	// 			NAMA_BARANG,
	// 			MEREK,
	// 			SPESIFIKASI_SINGKAT,
	// 			JUMLAH_MINTA
	// 			)
	// 		VALUES(
	// 			'$ID_SPPB',
	// 			$ID_BARANG_MASTER,
	// 			$ID_RASD_FORM,
	// 			'$ID_SATUAN_BARANG',
	// 			'$ID_JENIS_BARANG',
	// 			'$NAMA',
	// 			'$MEREK',
	// 			'$SPESIFIKASI_SINGKAT',
	// 			'$JUMLAH_MINTA'
	// 			 )");
	// 	return $hasil;
	// }

	// function simpan_data_dari_fpb_form(
	// 	$ID_SPPB,
	// 	$ID_FPB_FORM,
	// 	$ID_RASD_FORM,
	// 	$ID_BARANG_MASTER,
	// 	$ID_SATUAN_BARANG,
	// 	$ID_JENIS_BARANG,
	// 	$NAMA,
	// 	$MEREK,
	// 	$SPESIFIKASI_SINGKAT,
	// 	$JUMLAH_MINTA,
	// 	$TANGGAL_MULAI_PAKAI_HARI,
	// 	$TANGGAL_SELESAI_PAKAI_HARI
	// ) {
	// 	$hasil = $this->db->query("INSERT INTO nota_pengambilan_form (
	// 			ID_SPPB,
	// 			ID_FPB_FORM,
	// 			ID_RASD_FORM,
	// 			ID_BARANG_MASTER,
	// 			ID_SATUAN_BARANG,
	// 			ID_JENIS_BARANG,
	// 			NAMA_BARANG,
	// 			MEREK,
	// 			SPESIFIKASI_SINGKAT,
	// 			JUMLAH_MINTA,
	// 			TANGGAL_MULAI_PAKAI_HARI,
	// 			TANGGAL_SELESAI_PAKAI_HARI
	// 			)
	// 		VALUES(
	// 			'$ID_SPPB',
	// 			'$ID_FPB_FORM',
	// 			'$ID_RASD_FORM',
	// 			'$ID_BARANG_MASTER',
	// 			'$ID_SATUAN_BARANG',
	// 			'$ID_JENIS_BARANG',
	// 			'$NAMA',
	// 			'$MEREK',
	// 			'$SPESIFIKASI_SINGKAT',
	// 			'$JUMLAH_MINTA',
	// 			'$TANGGAL_MULAI_PAKAI_HARI',
	// 			'$TANGGAL_SELESAI_PAKAI_HARI'
	// 			 )");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function simpan_data_dari_barang_master
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
	// 	$JUMLAH_MINTA
	// ) {
	// 	$hasil = $this->db->query("INSERT INTO nota_pengambilan_form (
	// 			ID_SPPB,
	// 			ID_BARANG_MASTER,
	// 			ID_RASD_FORM,
	// 			ID_SATUAN_BARANG,
	// 			ID_JENIS_BARANG,
	// 			NAMA_BARANG,
	// 			MEREK,
	// 			SPESIFIKASI_SINGKAT,
	// 			JUMLAH_MINTA)
	// 		VALUES(
	// 			'$ID_SPPB',
	// 			$ID_BARANG_MASTER,
	// 			$ID_RASD_FORM,
	// 			'$ID_SATUAN_BARANG',
	// 			'$ID_JENIS_BARANG',
	// 			'$NAMA',
	// 			'$MEREK',
	// 			'$SPESIFIKASI_SINGKAT',
	// 			'$JUMLAH_MINTA' )");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_SPPB
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function simpan_data_di_luar_barang_master
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
	// 	$JUMLAH_MINTA
	// ) {
	// 	$hasil = $this->db->query("INSERT INTO nota_pengambilan_form (
	// 			ID_SPPB,
	// 			ID_BARANG_MASTER,
	// 			ID_RASD_FORM,
	// 			ID_SATUAN_BARANG,
	// 			ID_JENIS_BARANG,
	// 			NAMA_BARANG,
	// 			MEREK,
	// 			SPESIFIKASI_SINGKAT,
	// 			JUMLAH_MINTA)
	// 		VALUES(
	// 			'$ID_SPPB',
	// 			$ID_BARANG_MASTER,
	// 			$ID_RASD_FORM,
	// 			'$ID_SATUAN_BARANG',
	// 			'$ID_JENIS_BARANG',
	// 			'$NAMA',
	// 			'$MEREK',
	// 			'$SPESIFIKASI_SINGKAT',
	// 			'$JUMLAH_MINTA' )");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_USER
	// //SUMBER TABEL: tabel nota_pengambilan_form
	// //DIPAKAI: 1. controller nota_pengambilan_form / function logout
	// //         2. controller nota_pengambilan_form / function user_log
	function user_log_nota_pengambilan_form($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_nota_pengambilan_form (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
