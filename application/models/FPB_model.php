<?php
class FPB_model extends CI_Model
{
	// function FPB_list()
	// {
	// 	$hasil = $this->db->query("SELECT *
	// 	FROM FPB AS S 
	// 	LEFT JOIN rasd AS R ON R.ID_RASD = S.ID_RASD 
	// 	LEFT JOIN proyek AS P ON P.ID_PROYEK = R.ID_PROYEK");
	// 	return $hasil->result();
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller FPB / function data_FPB
	//         2. 
	function fpb_list_by_ID_PROYEK_USER_ID($ID_PROYEK, $USER_ID)
	{
		$hasil = $this->db->query("SELECT P.ID_JABATAN_PEGAWAI, P.NAMA, P.ID_JABATAN_PEGAWAI, F.ID_FPB, F.HASH_MD5_FPB, F.ID_PROYEK, F.ID_RASD, F.NO_URUT_FPB, F.TEMP_NO_URUT_FPB, F.JUMLAH_COUNT, F.TANGGAL_DOKUMEN_FPB, F.TANGGAL_PENGAJUAN_FPB, F.CTT_PEMINTA, F.CTT_STAFF_GUDANG_LOGISTIK, F.CTT_CHIEF, F.CTT_SM, F.PROGRESS_FPB, F.DUE_DATE_CHIEF,
		F.DUE_DATE_SM,
		F.DUE_DATE_STAFF_LOGISTIK,
		TIMEDIFF(now(), DUE_DATE_STAFF_LOGISTIK) as SELISIH_WAKTU_DUE_DATE_STAFF_LOGISTIK, 
		TIMEDIFF(now(), DUE_DATE_CHIEF) as SELISIH_WAKTU_DUE_DATE_CHIEF,
		TIMEDIFF(now(), DUE_DATE_SM) as SELISIH_WAKTU_DUE_DATE_SM,
		F.DOK_SPPB, F.CREATE_BY_USER, F.STATUS_FPB, F.FILE_NAME_TEMP, G.description as NAMA_JABATAN
		FROM pegawai AS P 
		LEFT JOIN users AS U ON U.ID_PEGAWAI = P.ID_PEGAWAI 
		LEFT JOIN fpb AS F ON F.CREATE_BY_USER = U.id
		LEFT JOIN groups as G on G.id = P.ID_JABATAN_PEGAWAI
		where F.ID_PROYEK = '$ID_PROYEK' AND F.CREATE_BY_USER = '$USER_ID' ORDER BY ID_FPB DESC");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel pegawai
	//DIPAKAI: 1. controller FPB / function data_FPB
	//         2. 
	function fpb_list_by_ID_PROYEK($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT F.ID_FPB, F.HASH_MD5_FPB, F.ID_PROYEK, F.ID_RASD, F.NO_URUT_FPB, F.TEMP_NO_URUT_FPB, F.JUMLAH_COUNT, F.TANGGAL_DOKUMEN_FPB, F.TANGGAL_PENGAJUAN_FPB, F.CTT_PEMINTA, F.CTT_STAFF_GUDANG_LOGISTIK, F.CTT_CHIEF, F.CTT_SM, F.PROGRESS_FPB, F.DUE_DATE_CHIEF, F.DUE_DATE_SM, F.DUE_DATE_STAFF_LOGISTIK, TIMEDIFF(now(), DUE_DATE_STAFF_LOGISTIK) as SELISIH_WAKTU_DUE_DATE_STAFF_LOGISTIK, TIMEDIFF(now(), DUE_DATE_CHIEF) as SELISIH_WAKTU_DUE_DATE_CHIEF, TIMEDIFF(now(), DUE_DATE_SM) as SELISIH_WAKTU_DUE_DATE_SM, F.DOK_SPPB, F.CREATE_BY_USER, F.STATUS_FPB, F.FILE_NAME_TEMP, P.ID_JABATAN_PEGAWAI, P.NAMA, P.ID_JABATAN_PEGAWAI, G.description as NAMA_JABATAN FROM fpb AS F
		LEFT JOIN users AS U ON U.id = F.CREATE_BY_USER
		LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = U.ID_PEGAWAI
		LEFT JOIN groups as G on G.id = P.ID_JABATAN_PEGAWAI
		where F.ID_PROYEK = '$ID_PROYEK' ORDER BY F.ID_FPB DESC ");
		return $hasil->result();
	}

	function fpb_list()
	{
		$hasil = $this->db->query("SELECT F.ID_FPB, F.HASH_MD5_FPB, F.ID_PROYEK, F.ID_RASD, F.NO_URUT_FPB, F.TEMP_NO_URUT_FPB, F.JUMLAH_COUNT, F.TANGGAL_DOKUMEN_FPB, F.TANGGAL_PENGAJUAN_FPB, F.CTT_PEMINTA, F.CTT_STAFF_GUDANG_LOGISTIK, F.CTT_CHIEF, F.CTT_SM, F.PROGRESS_FPB, F.DUE_DATE_CHIEF, F.DUE_DATE_SM, F.DUE_DATE_STAFF_LOGISTIK, TIMEDIFF(now(), DUE_DATE_STAFF_LOGISTIK) as SELISIH_WAKTU_DUE_DATE_STAFF_LOGISTIK, TIMEDIFF(now(), DUE_DATE_CHIEF) as SELISIH_WAKTU_DUE_DATE_CHIEF, TIMEDIFF(now(), DUE_DATE_SM) as SELISIH_WAKTU_DUE_DATE_SM, F.DOK_SPPB, F.CREATE_BY_USER, F.STATUS_FPB, F.FILE_NAME_TEMP, P.ID_JABATAN_PEGAWAI, P.NAMA, P.ID_JABATAN_PEGAWAI, G.description as NAMA_JABATAN FROM fpb AS F
		LEFT JOIN users AS U ON U.id = F.CREATE_BY_USER
		LEFT JOIN pegawai AS P ON P.ID_PEGAWAI = U.ID_PEGAWAI
		LEFT JOIN groups as G on G.id = P.ID_JABATAN_PEGAWAI
		ORDER BY F.ID_FPB DESC ");
		return $hasil->result();
	}

	function fpb_list_by_DUE_DATE_STAFF_LOGISTIK_less_than_now()
	{
		$hasil = $this->db->query("SELECT * FROM fpb WHERE DUE_DATE_STAFF_LOGISTIK < NOW() AND PROGRESS_FPB = 'Dalam Proses Staff Logistik'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel pegawai
	//DIPAKAI: 1. controller FPB / function index
	//         2. 
	function fpb_list_by_ID_PROYEK_and_condition($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT P.ID_JABATAN_PEGAWAI, F.ID_FPB, F.HASH_MD5_FPB, F.ID_PROYEK, F.ID_RASD, F.NO_URUT_FPB, F.TEMP_NO_URUT_FPB, F.JUMLAH_COUNT, F.TANGGAL_DOKUMEN_FPB, F.CTT_PEMINTA, F.PROGRESS_FPB, F.STATUS_FPB
		FROM pegawai AS P
		LEFT JOIN users AS U ON U.ID_PEGAWAI = P.ID_PEGAWAI
		LEFT JOIN fpb AS F ON F.CREATE_BY_USER = U.id 
		where F.ID_PROYEK = '$ID_PROYEK' AND F.PROGRESS_FPB = 'Dalam Proses Staff Logistik' ");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller FPB_form / function index
	//         2. controller FPB_form / function view
	//         2. controller FPB_form / function cetak_pdf
	function fpb_list_by_id_fpb($ID_FPB)
	{
		$hasil = $this->db->query("SELECT P.ID_JABATAN_PEGAWAI, P.NAMA, P.ID_JABATAN_PEGAWAI, F.ID_FPB, F.HASH_MD5_FPB, F.ID_PROYEK, F.ID_RASD, F.NO_URUT_FPB, F.TEMP_NO_URUT_FPB, F.JUMLAH_COUNT, F.TANGGAL_DOKUMEN_FPB, F.TANGGAL_PENGAJUAN_FPB, F.CTT_PEMINTA, F.CTT_STAFF_GUDANG_LOGISTIK, F.CTT_CHIEF, F.CTT_SM, F.PROGRESS_FPB, 
		F.SIGN_USER_PEMINTA,
		F.SIGN_CHIEF,
		F.SIGN_SM,
		F.SIGN_STAFF_LOGISTIK,
		F.DUE_DATE_CHIEF,
		F.DUE_DATE_SM,
		F.DUE_DATE_STAFF_LOGISTIK, F.DOK_SPPB, F.CREATE_BY_USER, F.STATUS_FPB, F.FILE_NAME_TEMP, G.description as NAMA_JABATAN
		FROM pegawai AS P 
		LEFT JOIN users AS U ON U.ID_PEGAWAI = P.ID_PEGAWAI 
		LEFT JOIN fpb AS F ON F.CREATE_BY_USER = U.id
		LEFT JOIN groups as G on G.id = P.ID_JABATAN_PEGAWAI WHERE F.ID_FPB = '$ID_FPB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengeset data fpb berdasarkan HASH_MD5_FPB
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller FPB / function simpan_data
	//         2. 
	function set_md5_id_FPB($ID_PROYEK, $NO_URUT_FPB, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT ID_FPB FROM FPB WHERE ID_PROYEK='$ID_PROYEK' AND
		NO_URUT_FPB='$NO_URUT_FPB' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FPB' => $data->ID_FPB
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		$ID_FPB = $hasil['ID_FPB'];
		$HASH_MD5_FPB = md5($ID_FPB);
		$this->db->query("UPDATE FPB SET HASH_MD5_FPB='$HASH_MD5_FPB' WHERE ID_FPB='$ID_FPB'");
	}

	//FUNGSI: Fungsi ini untuk menghapus data fpb berdasarkan HASH_MD5_FPB
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function hapus_data_by_HASH_MD5_FPB($HASH_MD5_FPB)
	{
		$hasil = $this->db->query("DELETE FROM fpb WHERE HASH_MD5_FPB='$HASH_MD5_FPB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller FPB / function get_nomor_urut
	//         2. 
	// function get_nomor_urut_by_ID_PROYEK_USER_ID($ID_PROYEK, $USER_ID)
	// {
	// 	$hsl = $this->db->query("SELECT MAX(JUMLAH_COUNT) AS JUMLAH_COUNT FROM FPB WHERE ID_PROYEK ='$ID_PROYEK' AND CREATE_BY_USER  ='$USER_ID'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'JUMLAH_COUNT' => $data->JUMLAH_COUNT
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA PROYEK";
	// 	}
	// 	return $hasil;
	// }

	function get_nomor_urut_by_ID_PROYEK_USER_ID($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT MAX(JUMLAH_COUNT) AS JUMLAH_COUNT FROM FPB WHERE ID_PROYEK ='$ID_PROYEK'");
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

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan HASH_MD5_FPB
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller FPB_form / function index
	//         2. controller FPB_form / function view
	//         3. controller FPB_form / function cetak_pdf
	function get_id_fpb_by_HASH_MD5_FPB($HASH_MD5_FPB)
	{
		$hsl = $this->db->query("SELECT ID_FPB FROM FPB WHERE HASH_MD5_FPB ='$HASH_MD5_FPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FPB' => $data->ID_FPB,
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA";
		}
		return $hasil;
	}

	// function get_id_FPB_by_id_khp($ID_KHP)
	// {
	// 	$hasil = $this->db->query("SELECT S.ID_FPB, P.NAMA_PROYEK,R.ID_RASD,S.JENIS_PEKERJAAN,S.NO_URUT_FPB,
	// 	S.TANGGAL_PENGAJUAN_FPB_JAM,S.TANGGAL_PENGAJUAN_FPB_HARI,S.TANGGAL_PENGAJUAN_FPB_BULAN,
	// 	S.TANGGAL_PENGAJUAN_FPB_TAHUN,S.PROGRESS_FPB,S.DATE_COUNT_PROYEK_CHIEF,S.DATE_COUNT_PROYEK_SM,
	// 	S.DATE_COUNT_PROYEK_PM,S.DATE_COUNT_M_LOG,S.DATE_COUNT_MANAGER,S.DATE_COUNT_DIR,S.DOK_FPB
	// 	FROM FPB AS S 
	// 	LEFT JOIN rasd AS R ON R.ID_RASD = S.ID_RASD 
	// 	LEFT JOIN proyek AS P ON P.ID_PROYEK = R.ID_PROYEK
	//     WHERE S.ID_FPB = (SELECT ID_FPB FROM komparasi_harga_pemasok WHERE ID_KHP = '$ID_KHP')");
	// 	return $hasil;
	// }

	// function get_data_by_id_FPB($ID_FPB)
	// {
	// 	$hsl = $this->db->query("SELECT 
	// 	S.ID_FPB, P.NAMA_PROYEK, R.ID_RASD, S.JENIS_PEKERJAAN, S.NO_URUT_FPB, 
	// 	S.TANGGAL_PENGAJUAN_FPB_JAM, S.TANGGAL_PENGAJUAN_FPB_HARI, 
	// 	S.TANGGAL_PENGAJUAN_FPB_BULAN, S.TANGGAL_PENGAJUAN_FPB_TAHUN,
	// 	S.PROGRESS_FPB,S.DATE_COUNT_PROYEK_CHIEF,S.DATE_COUNT_PROYEK_SM,
	// 	S.DATE_COUNT_PROYEK_PM,S.DATE_COUNT_M_LOG,S.DATE_COUNT_MANAGER,
	// 	S.DATE_COUNT_DIR,S.CB_PERSETUJUAN_M_LOG,S.CB_PERSETUJUAN_M_PROC,S.CB_PERSETUJUAN_M_SDM,
	// 	S.CB_PERSETUJUAN_M_KONS,S.CB_PERSETUJUAN_M_EP,S.CB_PERSETUJUAN_M_QAQC,S.CB_PERSETUJUAN_M_KEU,
	// 	S.CB_PERSETUJUAN_D_PSDS,S.CB_PERSETUJUAN_D_KONS,S.CB_PERSETUJUAN_D_KEU
	// 	FROM FPB AS S 
	// 	LEFT JOIN rasd AS R ON R.ID_RASD = S.ID_RASD 
	// 	LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
	// 	WHERE S.ID_FPB = '$ID_FPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_FPB' => $data->ID_FPB,
	// 				'NAMA_PROYEK' => $data->NAMA_PROYEK,
	// 				'ID_RASD' => $data->ID_RASD,
	// 				'JENIS_PEKERJAAN' => $data->JENIS_PEKERJAAN,
	// 				'NO_URUT_FPB' => $data->NO_URUT_FPB,
	// 				'TANGGAL_PENGAJUAN_FPB_JAM' => $data->TANGGAL_PENGAJUAN_FPB_JAM,
	// 				'TANGGAL_PENGAJUAN_FPB_HARI' => $data->TANGGAL_PENGAJUAN_FPB_HARI,
	// 				'TANGGAL_PENGAJUAN_FPB_BULAN' => $data->TANGGAL_PENGAJUAN_FPB_BULAN,
	// 				'TANGGAL_PENGAJUAN_FPB_TAHUN' => $data->TANGGAL_PENGAJUAN_FPB_TAHUN,
	// 				'PROGRESS_FPB' => $data->PROGRESS_FPB,
	// 				'DATE_COUNT_PROYEK_CHIEF' => $data->DATE_COUNT_PROYEK_CHIEF,
	// 				'DATE_COUNT_PROYEK_SM' => $data->DATE_COUNT_PROYEK_SM,
	// 				'DATE_COUNT_PROYEK_PM' => $data->DATE_COUNT_PROYEK_PM,
	// 				'DATE_COUNT_M_LOG' => $data->DATE_COUNT_M_LOG,
	// 				'DATE_COUNT_MANAGER' => $data->DATE_COUNT_MANAGER,
	// 				'DATE_COUNT_DIR' => $data->DATE_COUNT_DIR,
	// 				'CB_PERSETUJUAN_M_LOG' => $data->CB_PERSETUJUAN_M_LOG,
	// 				'CB_PERSETUJUAN_M_PROC' => $data->CB_PERSETUJUAN_M_PROC,
	// 				'CB_PERSETUJUAN_M_SDM' => $data->CB_PERSETUJUAN_M_SDM,
	// 				'CB_PERSETUJUAN_M_KONS' => $data->CB_PERSETUJUAN_M_KONS,
	// 				'CB_PERSETUJUAN_M_EP' => $data->CB_PERSETUJUAN_M_EP,
	// 				'CB_PERSETUJUAN_M_QAQC' => $data->CB_PERSETUJUAN_M_QAQC,
	// 				'CB_PERSETUJUAN_M_KEU' => $data->CB_PERSETUJUAN_M_KEU,
	// 				'CB_PERSETUJUAN_D_PSDS' => $data->CB_PERSETUJUAN_D_PSDS,
	// 				'CB_PERSETUJUAN_D_KONS' => $data->CB_PERSETUJUAN_D_KONS,
	// 				'CB_PERSETUJUAN_D_KEU' => $data->CB_PERSETUJUAN_D_KEU
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA FPB";
	// 	}
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan HASH_MD5_FPB
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function get_data_by_HASH_MD5_FPB($HASH_MD5_FPB)
	{
		$hsl = $this->db->query("SELECT * FROM fpb WHERE HASH_MD5_FPB = '$HASH_MD5_FPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FPB' => $data->ID_FPB,
					'ID_RASD' => $data->ID_RASD,
					'NO_URUT_FPB' => $data->NO_URUT_FPB,
					'TANGGAL_DOKUMEN_FPB' => $data->TANGGAL_DOKUMEN_FPB,
					'PROGRESS_FPB' => $data->PROGRESS_FPB
				);
			}
		} else {
			$hasil = "BELUM ADA FPB";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan HASH_MD5_FPB
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller FPB / function get_data_fpb_baru
	//         2. 
	function get_data_fpb_baru($ID_PROYEK, $TANGGAL_DOKUMEN_FPB, $NO_URUT_FPB, $USER_ID)
	{
		$hsl = $this->db->query("SELECT * FROM fpb WHERE ID_PROYEK = '$ID_PROYEK' AND
		TANGGAL_DOKUMEN_FPB = '$TANGGAL_DOKUMEN_FPB' AND
		NO_URUT_FPB = '$NO_URUT_FPB' AND
		CREATE_BY_USER = '$USER_ID' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_FPB' => $data->HASH_MD5_FPB
				);
			}
		} else {
			$hasil = "BELUM ADA FPB";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fpb berdasarkan NO_URUT_FPB
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller FPB / function simpan_data
	//         2. 
	function cek_no_urut_FPB_by_chief($NO_URUT_FPB)
	{
		$hsl = $this->db->query("SELECT ID_FPB, NO_URUT_FPB FROM FPB WHERE NO_URUT_FPB ='$NO_URUT_FPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'NO_URUT_FPB' => $data->NO_URUT_FPB,
					'ID_FPB' => $data->ID_FPB
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	// function update_data_ubah_logistik(
	// 	$ID_FPB,
	// 	$CTT
	// ) {
	// 	$hasil = $this->db->query("UPDATE FPB SET 
	// 	CTT_STAFF_LOG='$CTT'
	// 	WHERE ID_FPB='$ID_FPB'");
	// 	return $hasil;
	// }

	// function update_data_akhir(
	// 	$ID_FPB,
	// 	$CTT
	// ) {
	// 	$hasil = $this->db->query("UPDATE FPB SET 
	// 	CTT_D_KEU='$CTT'
	// 	WHERE ID_FPB='$ID_FPB'");
	// 	return $hasil;
	// }


	// function get_id_FPB_by_no_urut($NO_URUT_FPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_FPB FROM FPB WHERE NO_URUT_FPB = '$NO_URUT_FPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		// foreach ($hsl->result() as $data) {
	// 		// 	$hasil =  $data->ID_FPB;
	// 		// }
	// 		$hasil = $hsl->row()->ID_FPB;
	// 	} else {
	// 		$hasil = "BELUM ADA";
	// 	}
	// 	return $hasil;
	// }

	// function simpan_data_by_admin($ID_RASD, $JENIS_PEKERJAAN, $TANGGAL_DOKUMEN_FPB, $NO_URUT_FPB, $JUMLAH_COUNT)
	// {
	// 	$hasil = $this->db->query("INSERT INTO FPB (
	// 		ID_RASD,
	// 		JUMLAH_COUNT,
	// 		JENIS_PEKERJAAN,
	// 		TANGGAL_PENGAJUAN_FPB_HARI,
	// 		NO_URUT_FPB)
	// 	VALUES(
	// 		'$ID_RASD',
	// 		'$JUMLAH_COUNT',
	// 		'$JENIS_PEKERJAAN',
	// 		'$TANGGAL_DOKUMEN_FPB',
	// 		'$NO_URUT_FPB')");

	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller FPB / function simpan_data
	//         2. 
	function simpan_data_by_chief(
		$ID_PROYEK,
		$ID_RASD,
		$TANGGAL_DOKUMEN_FPB,
		$TANGGAL_PENGAJUAN_FPB,
		$NO_URUT_FPB,
		$CREATE_BY_USER,
		$PROGRESS_FPB,
		$STATUS_FPB,
		$JUMLAH_COUNT,
		$FILE_NAME_TEMP
	) {
		$hasil = $this->db->query("INSERT INTO FPB (
			ID_PROYEK,
			ID_RASD,
			TANGGAL_DOKUMEN_FPB,
			TANGGAL_PENGAJUAN_FPB,
			NO_URUT_FPB,
			CREATE_BY_USER,
			PROGRESS_FPB,
			STATUS_FPB,
			JUMLAH_COUNT,
			FILE_NAME_TEMP)
		VALUES(
			'$ID_PROYEK',
			'$ID_RASD',
			'$TANGGAL_DOKUMEN_FPB',
			'$TANGGAL_PENGAJUAN_FPB',
			'$NO_URUT_FPB',
			'$CREATE_BY_USER',
			'$PROGRESS_FPB',
			'$STATUS_FPB',
			'$JUMLAH_COUNT',
			'$FILE_NAME_TEMP'
			)");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_USER
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller FPB / function logout
	//         2. controller FPB / function user_log
	function user_log_FPB($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_FPB (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
