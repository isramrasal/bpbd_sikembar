<?php
class Pengajuan_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function index
	//         2. controller SPPB / function list_sppb_by_all_proyek
	function list_sppb_by_all_proyek()
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.HASH_MD5_SPPB, S.ID_PROYEK, S.NO_URUT_SPPB, DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB, DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI, S.STATUS_SPPB, P.HASH_MD5_PROYEK, P.NAMA_PROYEK, PSP.NAMA_SUB_PEKERJAAN FROM sppb AS S
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = S.ID_PROYEK_SUB_PEKERJAAN
		ORDER BY S.NO_URUT_SPPB DESC");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan ID_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function index
	//         2. 
	function sppb_list_by_id_sppb($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.HASH_MD5_SPPB, S.SUB_PROYEK, PSP.ID_PROYEK_SUB_PEKERJAAN, PSP.NAMA_SUB_PEKERJAAN, P.HASH_MD5_PROYEK, P.NAMA_PROYEK,DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB, S.TANGGAL_DOKUMEN_SPPB AS TANGGAL_DOKUMEN_SPPB_INDO, S.NO_URUT_SPPB,S.TANGGAL_PEMBUATAN_SPPB_JAM,DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI, S.TANGGAL_PEMBUATAN_SPPB_HARI AS TANGGAL_PEMBUATAN_SPPB_HARI_INDO, S.TANGGAL_PEMBUATAN_SPPB_BULAN,S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB,S.PROGRESS_SPPB,S.STATUS_SPPB, S.CTT_DEPT_PROC
		FROM sppb AS S 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
        LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = S.ID_PROYEK_SUB_PEKERJAAN
        WHERE S.ID_SPPB =  '$ID_SPPB' ORDER BY S.NO_URUT_SPPB DESC");
		return $hasil;
		//return $hasil->result();
	}

	function sppb_list()
	{
		$hasil = $this->db->query("SELECT * FROM sppb");
		return $hasil;
		//return $hasil->result();
	}

	function sppb_list_by_id_sppb_result($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.HASH_MD5_SPPB, S.SUB_PROYEK, PSP.ID_PROYEK_SUB_PEKERJAAN, PSP.NAMA_SUB_PEKERJAAN, P.HASH_MD5_PROYEK, P.NAMA_PROYEK,DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB,S.NO_URUT_SPPB,S.TANGGAL_PEMBUATAN_SPPB_JAM,DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN,S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB,S.PROGRESS_SPPB,S.STATUS_SPPB, S.CTT_DEPT_PROC
		FROM sppb AS S 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
        LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = S.ID_PROYEK_SUB_PEKERJAAN
        WHERE S.ID_SPPB =  '$ID_SPPB' ORDER BY S.NO_URUT_SPPB DESC");
		return $hasil->result();
	}

	// function rab_list_by_id_proyek_id_proyek_sub_pekerjaan($ID_SPPB)
	// {
	// 	$hasil = $this->db->query("SELECT S.ID_SPPB, S.HASH_MD5_SPPB, P.HASH_MD5_PROYEK, P.NAMA_PROYEK,DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB,S.NO_URUT_SPPB,S.TANGGAL_PEMBUATAN_SPPB_JAM,DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN,S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB,S.PROGRESS_SPPB,S.STATUS_SPPB
	// 	FROM sppb AS S 
	// 	LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
    //      WHERE S.ID_SPPB = '$ID_SPPB'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	function qty_sppb_form_by_id_sppb($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT COUNT(ID_SPPB) AS JUMLAH_BARANG_SPPB FROM sppb_form where ID_SPPB = '$ID_SPPB'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function data_sppb
	//         2. controller Surat_Jalan / function index
	function list_sppb_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.HASH_MD5_SPPB, P.HASH_MD5_PROYEK, P.NAMA_PROYEK,S.NO_URUT_SPPB,DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB,S.TANGGAL_PEMBUATAN_SPPB_JAM,DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN,S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.PROGRESS_SPPB,S.STATUS_SPPB,S.DUE_DATE_CHIEF,S.DUE_DATE_SM,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB, PSP.NAMA_SUB_PEKERJAAN
		FROM sppb AS S 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = S.ID_PROYEK_SUB_PEKERJAAN
        WHERE S.ID_PROYEK = '$ID_PROYEK' ORDER BY S.NO_URUT_SPPB DESC");
		return $hasil->result();
	}

	function sppb_list_sppb_by_hashmd5($HASH_MD5_SPPB)
	{

		$hasil = $this->db->query("SELECT CB_PERSETUJUAN_D_KEU,
		CB_PERSETUJUAN_D_KONS,
		CB_PERSETUJUAN_D_PSDS,
		CB_PERSETUJUAN_M_EP,
		CB_PERSETUJUAN_M_KEU,
		CB_PERSETUJUAN_M_KONS,
		CB_PERSETUJUAN_M_LOG,
		CB_PERSETUJUAN_M_PROC,
		CB_PERSETUJUAN_M_QAQC,
		CB_PERSETUJUAN_M_SDM,
		CREATE_BY_USER,
		CTT_CHIEF,
		CTT_D_EP_KONS,
		CTT_D_KEU,
		CTT_D_PSDS,
		CTT_DEPT_PROC,
		CTT_KASIE_LOG_KP,
		CTT_M_EP,
		CTT_M_HRD,
		CTT_M_HSSE,
		CTT_M_KEU,
		CTT_M_KOMERSIAL,
		CTT_M_KONS,
		CTT_M_LOG,
		CTT_M_MARKETING,
		CTT_M_QAQC,
		CTT_M_SDM,
		CTT_PM,
		CTT_SM,
		CTT_SPV_LOG_SP,
		CTT_STAFF_GUDANG_LOG_KP,
		CTT_STAFF_LOG_KP,
		CTT_STAFF_UMUM_LOG_SP,
		DOK_SPPB,
		DUE_DATE_CHIEF,
		DUE_DATE_DIR,
		DUE_DATE_M_LOG,
		DUE_DATE_MANAGER,
		DUE_DATE_PM,
		DUE_DATE_SM,
		FILE_NAME_TEMP,
		HASH_MD5_SPPB,
		ID_PROYEK,
		ID_SPPB,
		JUMLAH_COUNT,
		NO_URUT_SPPB,
		PROGRESS_SPPB,
		SIGN_USER_CHIEF_SP,
		SIGN_USER_D_EP_KONS_KP,
		SIGN_USER_D_KEU_KP,
		SIGN_USER_D_PSDS_KP,
		SIGN_USER_KASIE_LOG_KP,
		SIGN_USER_M_EP_KP,
		SIGN_USER_M_HRD_KP,
		SIGN_USER_M_HSSE_KP,
		SIGN_USER_M_KEU_KP,
		SIGN_USER_M_KOMERSIAL_KP,
		SIGN_USER_M_KONS_KP,
		SIGN_USER_M_LOG_KP,
		SIGN_USER_M_MARKETING_KP,
		SIGN_USER_M_QAQC_KP,
		SIGN_USER_M_SDM_KP,
		SIGN_USER_PM_SP,
		SIGN_USER_SM_SP,
		SIGN_USER_STAFF_GUDANG_LOG_KP,
		SIGN_USER_STAFF_UMUM_LOG_KP,
		SIGN_USER_STAFF_UMUM_LOG_SP,
		SIGN_USER_SUPERVISI_LOG_SP,
		STATUS_SPPB,
		SUB_PROYEK,
		DATE_FORMAT(TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB,
		TANGGAL_DOKUMEN_SPPB AS TANGGAL_DOKUMEN_SPPB_INDO,
		DATE_FORMAT(TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,
		TANGGAL_PEMBUATAN_SPPB_BULAN,
		TANGGAL_PEMBUATAN_SPPB_JAM,
		TANGGAL_PEMBUATAN_SPPB_TAHUN
		from sppb WHERE ( HASH_MD5_SPPB = '$HASH_MD5_SPPB')");
		return $hasil;
	}

	function sppb_list_sppb_by_id_sppb($ID_SPPB)
	{

		$hasil = $this->db->query("SELECT CB_PERSETUJUAN_D_KEU,
		CB_PERSETUJUAN_D_KONS,
		CB_PERSETUJUAN_D_PSDS,
		CB_PERSETUJUAN_M_EP,
		CB_PERSETUJUAN_M_KEU,
		CB_PERSETUJUAN_M_KONS,
		CB_PERSETUJUAN_M_LOG,
		CB_PERSETUJUAN_M_PROC,
		CB_PERSETUJUAN_M_QAQC,
		CB_PERSETUJUAN_M_SDM,
		CREATE_BY_USER,
		CTT_CHIEF,
		CTT_D_EP_KONS,
		CTT_D_KEU,
		CTT_D_PSDS,
		CTT_DEPT_PROC,
		CTT_KASIE_LOG_KP,
		CTT_M_EP,
		CTT_M_HRD,
		CTT_M_HSSE,
		CTT_M_KEU,
		CTT_M_KOMERSIAL,
		CTT_M_KONS,
		CTT_M_LOG,
		CTT_M_MARKETING,
		CTT_M_QAQC,
		CTT_M_SDM,
		CTT_PM,
		CTT_SM,
		CTT_SPV_LOG_SP,
		CTT_STAFF_GUDANG_LOG_KP,
		CTT_STAFF_LOG_KP,
		CTT_STAFF_UMUM_LOG_SP,
		DOK_SPPB,
		DUE_DATE_CHIEF,
		DUE_DATE_DIR,
		DUE_DATE_M_LOG,
		DUE_DATE_MANAGER,
		DUE_DATE_PM,
		DUE_DATE_SM,
		FILE_NAME_TEMP,
		HASH_MD5_SPPB,
		ID_PROYEK,
		ID_SPPB,
		JUMLAH_COUNT,
		NO_URUT_SPPB,
		PROGRESS_SPPB,
		SIGN_USER_CHIEF_SP,
		SIGN_USER_D_EP_KONS_KP,
		SIGN_USER_D_KEU_KP,
		SIGN_USER_D_PSDS_KP,
		SIGN_USER_KASIE_LOG_KP,
		SIGN_USER_M_EP_KP,
		SIGN_USER_M_HRD_KP,
		SIGN_USER_M_HSSE_KP,
		SIGN_USER_M_KEU_KP,
		SIGN_USER_M_KOMERSIAL_KP,
		SIGN_USER_M_KONS_KP,
		SIGN_USER_M_LOG_KP,
		SIGN_USER_M_MARKETING_KP,
		SIGN_USER_M_QAQC_KP,
		SIGN_USER_M_SDM_KP,
		SIGN_USER_PM_SP,
		SIGN_USER_SM_SP,
		SIGN_USER_STAFF_GUDANG_LOG_KP,
		SIGN_USER_STAFF_UMUM_LOG_KP,
		SIGN_USER_STAFF_UMUM_LOG_SP,
		SIGN_USER_SUPERVISI_LOG_SP,
		STATUS_SPPB,
		SUB_PROYEK,
		DATE_FORMAT(TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB,
		DATE_FORMAT(TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,
		TANGGAL_PEMBUATAN_SPPB_BULAN,
		TANGGAL_PEMBUATAN_SPPB_JAM,
		TANGGAL_PEMBUATAN_SPPB_TAHUN
		from sppb WHERE ( ID_SPPB = '$ID_SPPB')");
		return $hasil;
	}

	function proyek_list()
	{
		$hasil = $this->db->query("SELECT A.ID_PROYEK, A.HASH_MD5_PROYEK, A.STATUS_PROYEK, A.NAMA_PROYEK, A.LOKASI, A.INISIAL, C.NAMA as PEGAWAI_PM, D.NAMA as PEGAWAI_SM FROM proyek as A
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=A.ID_PEGAWAI_PM 
		LEFT JOIN pegawai as D ON D.ID_PEGAWAI=A.ID_PEGAWAI_SM
		ORDER BY A.NAMA_PROYEK ASC");
		return $hasil->result();
	}

	function proyek_list_by_id_proyek($ID_PROYEK) //122023
	{
		$hasil = $this->db->query("SELECT A.ID_PROYEK, A.HASH_MD5_PROYEK, A.STATUS_PROYEK, A.NAMA_PROYEK, A.LOKASI, A.INISIAL, C.NAMA as PEGAWAI_PM, D.NAMA as PEGAWAI_SM FROM proyek as A
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=A.ID_PEGAWAI_PM 
		LEFT JOIN pegawai as D ON D.ID_PEGAWAI=A.ID_PEGAWAI_SM WHERE A.ID_PROYEK = '$ID_PROYEK'
		ORDER BY A.NAMA_PROYEK ASC");
		return $hasil->result();
	}

	function data_sub_pekerjaan_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT NAMA_SUB_PEKERJAAN, ID_PROYEK_SUB_PEKERJAAN FROM proyek_sub_pekerjaan where ID_PROYEK  ='$ID_PROYEK'");
		return $hasil->result();
	}

	function get_data_id_rab_form_by_id_proyek($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN)
	{
		$hsl = $this->db->query("SELECT * FROM RAB where ID_PROYEK  ='$ID_PROYEK' AND ID_PROYEK_SUB_PEKERJAAN ='$ID_PROYEK_SUB_PEKERJAAN' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil_1 = array(
					'ID_RAB' => $data->ID_RAB
				);
			}
			$ID_RAB = $hasil_1['ID_RAB'];
			$hasil = $this->db->query("SELECT * FROM RAB_FORM where ID_RAB  ='$ID_RAB' ");
			return $hasil->result();
		} else {
			return 'Data belum ada';
		}
	}

	function get_data_id_rab_form_by_id_rab($ID_RAB)
	{

		$hasil = $this->db->query("SELECT * FROM RAB_FORM where ID_RAB  ='$ID_RAB' ");
		return $hasil->result();

	}

	function get_data_id_rab_by_id_proyek($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN)
	{
		$hsl = $this->db->query("SELECT * FROM RAB where ID_PROYEK  ='$ID_PROYEK' AND ID_PROYEK_SUB_PEKERJAAN ='$ID_PROYEK_SUB_PEKERJAAN' ");
		return $hsl->result();
	}

	function get_data_id_rasd_by_id_rab($ID_RAB)
	{
		$hsl = $this->db->query("SELECT * FROM RASD where ID_RAB ='$ID_RAB'");
		return $hsl->result();
	}

	function get_data_id_rasd_by_id_rab_and_nama_barang($ID_RAB, $NAMA)
	{
		$hsl = $this->db->query("SELECT * FROM RASD where ID_RAB ='$ID_RAB'");
		return $hsl->result();
	}

	function get_data_id_rasd_by_id_rab_form($ID_RAB_FORM)
	{
		$hsl = $this->db->query("SELECT * FROM RASD where ID_RAB_FORM  ='$ID_RAB_FORM' ");

		return $hsl->result();
	}

	function get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT * FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'HASH_MD5_SPPB' => $data->HASH_MD5_SPPB,
					'NO_URUT_SPPB' => $data->NO_URUT_SPPB,
					'PROGRESS_SPPB' => $data->PROGRESS_SPPB,
					'STATUS_SPPB' => $data->STATUS_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_STAFF_UMUM_LOG_SP($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_STAFF_UMUM_LOG_SP FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_STAFF_UMUM_LOG_SP' => $data->CTT_STAFF_UMUM_LOG_SP,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_SPV_LOG_SP($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_SPV_LOG_SP FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_SPV_LOG_SP' => $data->CTT_SPV_LOG_SP,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_CHIEF($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_CHIEF FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_CHIEF' => $data->CTT_CHIEF,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_SM($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_SM FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_SM' => $data->CTT_SM,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_PM($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_PM FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_PM' => $data->CTT_PM,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_STAFF_LOG_KP($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_STAFF_LOG_KP FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_STAFF_LOG_KP' => $data->CTT_STAFF_LOG_KP,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_STAFF_GUDANG_LOG_KP($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_STAFF_GUDANG_LOG_KP FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_STAFF_GUDANG_LOG_KP' => $data->CTT_STAFF_GUDANG_LOG_KP,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_KASIE_LOG_KP($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_KASIE_LOG_KP FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_KASIE_LOG_KP' => $data->CTT_KASIE_LOG_KP,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_HRD($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_HRD FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_HRD' => $data->CTT_M_HRD,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_KEU($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_KEU FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_KEU' => $data->CTT_M_KEU,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_KONS($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_KONS FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_KONS' => $data->CTT_M_KONS,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_SDM($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_SDM FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_SDM' => $data->CTT_M_SDM,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_QAQC($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_QAQC FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_QAQC' => $data->CTT_M_QAQC,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_EP($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_EP FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_EP' => $data->CTT_M_EP,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_HSSE($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_HSSE FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_HSSE' => $data->CTT_M_HSSE,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_MARKETING($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_MARKETING FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_MARKETING' => $data->CTT_M_MARKETING,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_KOMERSIAL($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_KOMERSIAL FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_KOMERSIAL' => $data->CTT_M_KOMERSIAL,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_LOG($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_LOG FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_LOG' => $data->CTT_M_LOG,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_D_KEU($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_D_KEU FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_D_KEU' => $data->CTT_D_KEU,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_D_EP_KONS($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_D_EP_KONS FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_D_EP_KONS' => $data->CTT_D_EP_KONS,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_D_PSDS($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_D_PSDS FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_D_PSDS' => $data->CTT_D_PSDS,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_DEPT_PROC($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, CTT_DEPT_PROC FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_DEPT_PROC' => $data->CTT_DEPT_PROC,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function set_md5_id_sppb_pembelian($ID_PROYEK, $NO_URUT_SPPB, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT ID_SPPB FROM sppb WHERE ID_PROYEK='$ID_PROYEK' AND
		NO_URUT_SPPB='$NO_URUT_SPPB' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB' => $data->ID_SPPB
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		$ID_SPPB = $hasil['ID_SPPB'];
		$HASH_MD5_SPPB = md5($ID_SPPB);
		$hsl3 = $this->db->query("UPDATE sppb SET HASH_MD5_SPPB='$HASH_MD5_SPPB' WHERE ID_SPPB='$ID_SPPB'");

		$hsl2 = $this->db->query("SELECT HASH_MD5_SPPB FROM sppb WHERE HASH_MD5_SPPB='$HASH_MD5_SPPB'");
		if ($hsl2->num_rows() > 0) {
			foreach ($hsl2->result() as $data) {
				$hasil2 = array(
					'HASH_MD5_SPPB' => $data->HASH_MD5_SPPB
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}

		return $hasil2;
	}

	//FUNGSI: Fungsi ini untuk menghapus data sppb berdasarkan HASH_MD5_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function hapus_data
	//         2. 
	function hapus_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB)
	{
		$hasil = $this->db->query("DELETE FROM sppb WHERE HASH_MD5_SPPB='$HASH_MD5_SPPB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut sppb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut_by_id_proyek
	//         2. 
	function get_nomor_urut_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT MAX(JUMLAH_COUNT) AS JUMLAH_COUNT FROM SPPB WHERE ID_PROYEK ='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'JUMLAH_COUNT' => $data->JUMLAH_COUNT
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan INSIAL PROYEK berdasarkan HASH_MD5_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller RFQ / function (---
	//         2. 

	function get_inisial_proyek_by_HASH_MD5_SPPB($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT P.INISIAL, P.ID_PROYEK, P.HASH_MD5_PROYEK, P.NAMA_PROYEK  FROM proyek as P 
		LEFT JOIN SPPB AS S ON S.ID_PROYEK = P.ID_PROYEK
		WHERE S.HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'INISIAL' => $data->INISIAL,
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_PROYEK' => $data->NAMA_PROYEK
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA";
		}
		return $hasil;
	}

	function get_id_proyek_by_HASH_MD5_SPPB($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT P.INISIAL, P.ID_PROYEK, P.HASH_MD5_PROYEK, P.NAMA_PROYEK  FROM proyek as P 
		LEFT JOIN SPPB AS S ON S.ID_PROYEK = P.ID_PROYEK
		WHERE S.HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'INISIAL' => $data->INISIAL,
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_PROYEK' => $data->NAMA_PROYEK
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA";
		}
		return $hasil;
	}

	// FUNGSI: Fungsi ini untuk menampilkan data nomor urut sppb berdasarkan HASH_MD5_SPPB
	// SUMBER TABEL: tabel sppb
	// DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function get_id_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT * FROM SPPB WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'NO_URUT_SPPB' => $data->NO_URUT_SPPB
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan ID_KHP
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function get_id_sppb_by_id_khp($ID_KHP)
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, P.HASH_MD5_PROYEK, P.NAMA_PROYEK,DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB,S.NO_URUT_SPPB,S.TANGGAL_PEMBUATAN_SPPB_JAM,DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN,S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.PROGRESS_SPPB,S.DUE_DATE_CHIEF,S.DUE_DATE_SM,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB
		FROM sppb AS S 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = R.ID_PROYEK
        WHERE S.ID_SPPB = (SELECT ID_SPPB FROM komparasi_harga_pemasok WHERE ID_KHP = '$ID_KHP')");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan ID_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function update_data
	//         2. controller SPPB / function view_ubah
	function get_data_by_id_sppb($ID_SPPB)
	{
		$hsl = $this->db->query("SELECT 
		S.ID_SPPB, P.HASH_MD5_PROYEK, P.NAMA_PROYEK, DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB, S.NO_URUT_SPPB,S.TANGGAL_PEMBUATAN_SPPB_JAM, DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN, S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.PROGRESS_SPPB,S.DUE_DATE_CHIEF,S.DUE_DATE_SM,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.CB_PERSETUJUAN_M_LOG,S.CB_PERSETUJUAN_M_PROC,S.CB_PERSETUJUAN_M_SDM,S.CB_PERSETUJUAN_M_KONS,S.CB_PERSETUJUAN_M_EP,S.CB_PERSETUJUAN_M_QAQC,S.CB_PERSETUJUAN_M_KEU,S.CB_PERSETUJUAN_D_PSDS,S.CB_PERSETUJUAN_D_KONS,S.CB_PERSETUJUAN_D_KEU
		FROM sppb AS S 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
		WHERE S.ID_SPPB = '$ID_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB' => $data->ID_SPPB,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'TANGGAL_DOKUMEN_SPPB' => $data->TANGGAL_DOKUMEN_SPPB,
					'NO_URUT_SPPB' => $data->NO_URUT_SPPB,
					'TANGGAL_PEMBUATAN_SPPB_JAM' => $data->TANGGAL_PEMBUATAN_SPPB_JAM,
					'TANGGAL_PEMBUATAN_SPPB_HARI' => $data->TANGGAL_PEMBUATAN_SPPB_HARI,
					'TANGGAL_PEMBUATAN_SPPB_BULAN' => $data->TANGGAL_PEMBUATAN_SPPB_BULAN,
					'TANGGAL_PEMBUATAN_SPPB_TAHUN' => $data->TANGGAL_PEMBUATAN_SPPB_TAHUN,
					'PROGRESS_SPPB' => $data->PROGRESS_SPPB,
					'DUE_DATE_CHIEF' => $data->DUE_DATE_CHIEF,
					'DUE_DATE_SM' => $data->DUE_DATE_SM,
					'DUE_DATE_PM' => $data->DUE_DATE_PM,
					'DUE_DATE_M_LOG' => $data->DUE_DATE_M_LOG,
					'DUE_DATE_MANAGER' => $data->DUE_DATE_MANAGER,
					'DUE_DATE_DIR' => $data->DUE_DATE_DIR,
					'CB_PERSETUJUAN_M_LOG' => $data->CB_PERSETUJUAN_M_LOG,
					'CB_PERSETUJUAN_M_PROC' => $data->CB_PERSETUJUAN_M_PROC,
					'CB_PERSETUJUAN_M_SDM' => $data->CB_PERSETUJUAN_M_SDM,
					'CB_PERSETUJUAN_M_KONS' => $data->CB_PERSETUJUAN_M_KONS,
					'CB_PERSETUJUAN_M_EP' => $data->CB_PERSETUJUAN_M_EP,
					'CB_PERSETUJUAN_M_QAQC' => $data->CB_PERSETUJUAN_M_QAQC,
					'CB_PERSETUJUAN_M_KEU' => $data->CB_PERSETUJUAN_M_KEU,
					'CB_PERSETUJUAN_D_PSDS' => $data->CB_PERSETUJUAN_D_PSDS,
					'CB_PERSETUJUAN_D_KONS' => $data->CB_PERSETUJUAN_D_KONS,
					'CB_PERSETUJUAN_D_KEU' => $data->CB_PERSETUJUAN_D_KEU
				);
			}
		} else {
			$hasil = "BELUM ADA SPPB";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan HASH_MD5_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_data
	//         2. controller SPPB / function hapus_data
	function get_data_by_HASH_MD5_SPPB($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT 
		S.ID_SPPB, P.HASH_MD5_PROYEK, P.NAMA_PROYEK, DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB, S.NO_URUT_SPPB, S.TANGGAL_PEMBUATAN_SPPB_JAM, DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN, S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.PROGRESS_SPPB,S.DUE_DATE_CHIEF,S.DUE_DATE_SM,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.CB_PERSETUJUAN_M_LOG,S.CB_PERSETUJUAN_M_PROC,S.CB_PERSETUJUAN_M_SDM,S.CB_PERSETUJUAN_M_KONS,S.CB_PERSETUJUAN_M_EP,S.CB_PERSETUJUAN_M_QAQC,S.CB_PERSETUJUAN_M_KEU,S.CB_PERSETUJUAN_D_PSDS,S.CB_PERSETUJUAN_D_KONS,S.CB_PERSETUJUAN_D_KEU
		FROM sppb AS S 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
		WHERE S.HASH_MD5_SPPB = '$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB' => $data->ID_SPPB,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'TANGGAL_DOKUMEN_SPPB' => $data->TANGGAL_DOKUMEN_SPPB,
					'NO_URUT_SPPB' => $data->NO_URUT_SPPB,
					'TANGGAL_PEMBUATAN_SPPB_JAM' => $data->TANGGAL_PEMBUATAN_SPPB_JAM,
					'TANGGAL_PEMBUATAN_SPPB_HARI' => $data->TANGGAL_PEMBUATAN_SPPB_HARI,
					'TANGGAL_PEMBUATAN_SPPB_BULAN' => $data->TANGGAL_PEMBUATAN_SPPB_BULAN,
					'TANGGAL_PEMBUATAN_SPPB_TAHUN' => $data->TANGGAL_PEMBUATAN_SPPB_TAHUN,
					'PROGRESS_SPPB' => $data->PROGRESS_SPPB,
					'DUE_DATE_CHIEF' => $data->DUE_DATE_CHIEF,
					'DUE_DATE_SM' => $data->DUE_DATE_SM,
					'DUE_DATE_PM' => $data->DUE_DATE_PM,
					'DUE_DATE_M_LOG' => $data->DUE_DATE_M_LOG,
					'DUE_DATE_MANAGER' => $data->DUE_DATE_MANAGER,
					'DUE_DATE_DIR' => $data->DUE_DATE_DIR,
					'CB_PERSETUJUAN_M_LOG' => $data->CB_PERSETUJUAN_M_LOG,
					'CB_PERSETUJUAN_M_PROC' => $data->CB_PERSETUJUAN_M_PROC,
					'CB_PERSETUJUAN_M_SDM' => $data->CB_PERSETUJUAN_M_SDM,
					'CB_PERSETUJUAN_M_KONS' => $data->CB_PERSETUJUAN_M_KONS,
					'CB_PERSETUJUAN_M_EP' => $data->CB_PERSETUJUAN_M_EP,
					'CB_PERSETUJUAN_M_QAQC' => $data->CB_PERSETUJUAN_M_QAQC,
					'CB_PERSETUJUAN_M_KEU' => $data->CB_PERSETUJUAN_M_KEU,
					'CB_PERSETUJUAN_D_PSDS' => $data->CB_PERSETUJUAN_D_PSDS,
					'CB_PERSETUJUAN_D_KONS' => $data->CB_PERSETUJUAN_D_KONS,
					'CB_PERSETUJUAN_D_KEU' => $data->CB_PERSETUJUAN_D_KEU
				);
			}
		} else {
			$hasil = "BELUM ADA SPPB";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan NO_URUT_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function simpan_data
	//         2. 
	function cek_no_urut_sppb_by_admin($NO_URUT_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, NO_URUT_SPPB FROM sppb WHERE NO_URUT_SPPB ='$NO_URUT_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'NO_URUT_SPPB' => $data->NO_URUT_SPPB,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function cek_no_urut_sppb($NO_URUT_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB, NO_URUT_SPPB FROM sppb WHERE NO_URUT_SPPB ='$NO_URUT_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'NO_URUT_SPPB' => $data->NO_URUT_SPPB,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk mengubah data logistik berdasarkan ID_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function simpan_perubahan_sppb
	//         2. 
	function update_data_ubah_logistik(
		$ID_SPPB,
		$CTT
	)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
		CTT_STAFF_LOG_KP='$CTT'
		WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data sppb berdasarkan ID_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function simpan_ajuan_akhir
	//         2. 
	function update_data_akhir(
		$ID_SPPB,
		$CTT
	)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
		CTT_D_KEU='$CTT'
		WHERE ID_SPPB='$ID_SPPB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut sppb berdasarkan NO_URUT_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function get_id_sppb_by_no_urut($NO_URUT_SPPB)
	{
		$hsl = $this->db->query("SELECT ID_SPPB FROM sppb WHERE NO_URUT_SPPB = '$NO_URUT_SPPB'");
		if ($hsl->num_rows() > 0) {
			// foreach ($hsl->result() as $data) {
			// 	$hasil =  $data->ID_SPPB;
			// }
			$hasil = $hsl->row()->ID_SPPB;
		} else {
			$hasil = "BELUM ADA";
		}
		return $hasil;
	}


	function simpan_data_pengajuan_bantuan(
		$ID_JENIS_BENCANA,
		$NAMA_PEMOHON,
		$NIP,
		$JABATAN,
		$INSTANSI,
		$ID_KABUPATEN_KOTA,
		$ID_KECAMATAN,
		$ID_DESA_KELURAHAN,
		$RW,
		$RT,
		$KAMPUNG,
		$KODE_POS,
		$TANGGAL_DOKUMEN_PENGAJUAN,
		$TANGGAL_KEJADIAN_BENCANA,
		$TANGGAL_PEMBUATAN_PENGAJUAN_JAM,
		$TANGGAL_PEMBUATAN_PENGAJUAN_HARI,
		$TANGGAL_PEMBUATAN_PENGAJUAN_BULAN,
		$TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN,
		$CREATE_BY_USER,
		$PROGRESS_PENGAJUAN,
		$STATUS_PENGAJUAN
	)
	{
		$hasil = $this->db->query("INSERT INTO form_inventaris_kebutuhan_korban_bencana (
				Tanggal_Pembuatan,
				Tanggal_Surat,
				Hari_Surat,
				Nama_Pemohon,
				NIP,
				Jabatan,
				Instansi,
				Kampung_Bencana,
				RT,
				RW,
				Desa_Kelurahan_Bencana,
				Kecamatan_Bencana,
				Kabupaten_Kota_Bencana,
				Kode_Pos_Bencana,
				Jenis_Bencana,
				TANGGAL_KEJADIAN_BENCANA,
				TANGGAL_PEMBUATAN_PENGAJUAN_JAM,
				TANGGAL_PEMBUATAN_PENGAJUAN_HARI,
				TANGGAL_PEMBUATAN_PENGAJUAN_BULAN,
                TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN,
                CREATE_BY_USER,
				PROGRESS_PENGAJUAN,
                STATUS_PENGAJUAN)
			VALUES(
				'$TANGGAL_PEMBUATAN_PENGAJUAN_JAM',
				'$TANGGAL_DOKUMEN_PENGAJUAN',
				'$TANGGAL_PEMBUATAN_PENGAJUAN_HARI',
				'$NAMA_PEMOHON',
				'$NIP',
				'$JABATAN',
				'$INSTANSI',
				'$KAMPUNG',
				'$RW',
				'$RT',
				'$ID_DESA_KELURAHAN',
				'$ID_KECAMATAN',
                '$ID_KABUPATEN_KOTA',
                '$KODE_POS',
                '$ID_JENIS_BENCANA',
                '$TANGGAL_KEJADIAN_BENCANA',
                '$TANGGAL_PEMBUATAN_PENGAJUAN_JAM',
				'$TANGGAL_PEMBUATAN_PENGAJUAN_HARI',
                '$TANGGAL_PEMBUATAN_PENGAJUAN_BULAN',
                '$TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN',
                '$CREATE_BY_USER',
                '$PROGRESS_PENGAJUAN',
				'$STATUS_PENGAJUAN'
				)");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan HASH_MD5_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_data_sppb_baru
	//         2. 
	function get_data_sppb_baru($NO_URUT_SPPB)
	{
		$hsl = $this->db->query("SELECT * FROM form_inventaris_kebutuhan_korban_bencana WHERE NO_URUT_SPPB = '$NO_URUT_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_SPPB' => $data->HASH_MD5_SPPB
				);
			}
		} else {
			$hasil = "BELUM ADA SPPB";
		}
		return $hasil;
	}

	function get_data_sppb_pembelian_baru($NO_URUT_SPPB)
	{
		$hsl = $this->db->query("SELECT * FROM sppb WHERE NO_URUT_SPPB = '$NO_URUT_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_SPPB' => $data->HASH_MD5_SPPB
				);
			}
		} else {
			$hasil = "BELUM ADA SPPB";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb berdasarkan ID_USER
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function logout
	//         2. controller SPPB / function user_log
	function user_log_sppb($ID_USER, $ID_SPPB, $KETERANGAN, $WAKTU)
	{
		$db2 = $this->load->database('logs', TRUE);

		$hasil = $db2->query("INSERT INTO user_log_sppb (ID_USER, ID_SPPB, KETERANGAN, WAKTU) VALUES('$ID_USER', '$ID_SPPB', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}