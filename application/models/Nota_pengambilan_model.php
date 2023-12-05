<?php
class Nota_pengambilan_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function index
	//         2. controller SPPB / function data_sppb
	function nota_pengambilan_list()
	{
		$hasil = $this->db->query("SELECT *
		FROM nota_pengambilan AS NP 
		LEFT JOIN rasd AS R ON R.ID_RASD = NP.ID_RASD 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = NP.ID_PROYEK");
		return $hasil->result();
	}

	// //FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan ID_SPPB
	// //SUMBER TABEL: tabel sppb
	// //DIPAKAI: 1. controller SPPB_form / function index
	// //         2. 
	// function sppb_list_by_id_sppb($ID_SPPB)
	// {
	// 	$hasil = $this->db->query("SELECT S.ID_SPPB, S.HASH_MD5_SPPB, P.NAMA_PROYEK,R.ID_RASD,S.JENIS_PEKERJAAN,S.NO_URUT_SPPB,
	// 	S.TANGGAL_PEMBUATAN_SPPB_JAM,S.TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN,
	// 	S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.PROGRESS_SPPB,S.STATUS_SPPB,S.DUE_DATE_CHIEF,S.DUE_DATE_SM,
	// 	S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB
	// 	FROM sppb AS S 
	// 	LEFT JOIN rasd AS R ON R.ID_RASD = S.ID_RASD 
	// 	LEFT JOIN proyek AS P ON P.ID_PROYEK = R.ID_PROYEK
    //     WHERE S.ID_SPPB = '$ID_SPPB'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function data_sppb
	//         2. controller Surat_Jalan / function index
	function nota_pengambilan_list_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT NP.ID_NOTA_PENGAMBILAN, NP.HASH_MD5_NOTA_PENGAMBILAN, P.NAMA_PROYEK,R.ID_RASD, NP.JENIS_PEKERJAAN, NP.NO_URUT_NOTA_PENGAMBILAN,NP.TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_JAM,NP.TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_HARI,NP.TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_BULAN,
		NP.TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_TAHUN,NP.PROGRESS_NOTA_PENGAMBILAN, NP.STATUS_NOTA_PENGAMBILAN
		FROM nota_pengambilan AS NP 
		LEFT JOIN rasd AS R ON R.ID_RASD = NP.ID_RASD 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = NP.ID_PROYEK
		WHERE NP.ID_PROYEK = '$ID_PROYEK'");
		return $hasil->result();
	}


	function get_data_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN)
	{
		$hsl = $this->db->query("SELECT * FROM nota_pengambilan WHERE HASH_MD5_SPPB ='$HASH_MD5_NOTA_PENGAMBILAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_NOTA_PENGAMBILAN' => $data->ID_NOTA_PENGAMBILAN,
					'HASH_MD5_NOTA_PENGAMBILAN' => $data->HASH_MD5_NOTA_PENGAMBILAN,
					'NO_URUT_NOTA_PENGAMBILAN' => $data->NO_URUT_NOTA_PENGAMBILAN,
					'PROGRESS_NOTA_PENGAMBILAN' => $data->PROGRESS_NOTA_PENGAMBILAN,
					'STATUS_NOTA_PENGAMBILAN' => $data->STATUS_NOTA_PENGAMBILAN
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	// function sppb_list_sppb_by_hashmd5($HASH_MD5_SPPB)
	// {

	// 	$hasil = $this->db->query("SELECT * from sppb WHERE ( HASH_MD5_SPPB = '$HASH_MD5_SPPB')");
	// 	return $hasil;
	// }

	// function get_data_sppb_by_HASH_MD5_SPPB($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT * FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_SPPB' => $data->ID_SPPB,
	// 				'HASH_MD5_SPPB' => $data->HASH_MD5_SPPB,
	// 				'NO_URUT_SPPB' => $data->NO_URUT_SPPB,
	// 				'PROGRESS_SPPB' => $data->PROGRESS_SPPB,
	// 				'STATUS_SPPB' => $data->STATUS_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_STAFF_UMUM_LOG($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_STAFF_UMUM_LOG FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_STAFF_UMUM_LOG' => $data->CTT_STAFF_UMUM_LOG,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_SPV_LOG($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_SPV_LOG FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_SPV_LOG' => $data->CTT_SPV_LOG,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_CHIEF($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_CHIEF FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_CHIEF' => $data->CTT_CHIEF,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_SM($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_SM FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_SM' => $data->CTT_SM,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_PM($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_PM FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_PM' => $data->CTT_PM,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_STAFF_LOG($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_STAFF_LOG FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_STAFF_LOG' => $data->CTT_STAFF_LOG,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_STAFF_GUDANG_LOG($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_STAFF_GUDANG_LOG FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_STAFF_GUDANG_LOG' => $data->CTT_STAFF_GUDANG_LOG,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_KASIE_LOG($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_KASIE_LOG FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_KASIE_LOG' => $data->CTT_KASIE_LOG,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_M_HRD($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_HRD FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_M_HRD' => $data->CTT_M_HRD,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_M_KEU($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_KEU FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_M_KEU' => $data->CTT_M_KEU,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	// function get_data_CTT_M_KONS($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_SPPB, CTT_M_KONS FROM sppb WHERE HASH_MD5_SPPB ='$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'CTT_M_KONS' => $data->CTT_M_KONS,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 		return $hasil;
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

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

	//FUNGSI: Fungsi ini untuk mengeset HASH_MD5_SPPB berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function set_md5_id_nota_pengambilan($ID_RASD, $NO_URUT_NOTA_PENGAMBILAN, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT ID_NOTA_PENGAMBILAN FROM NOTA_PENGAMBILAN WHERE ID_RASD='$ID_RASD' AND
		NO_URUT_NOTA_PENGAMBILAN='$NO_URUT_NOTA_PENGAMBILAN' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_NOTA_PENGAMBILAN' => $data->ID_NOTA_PENGAMBILAN
				);
			}
		} else {
			$hasil = "BELUM ADA NOTA PENGAMBILAN";
		}
		$ID_NOTA_PENGAMBILAN = $hasil['ID_NOTA_PENGAMBILAN'];
		$HASH_MD5_NOTA_PENGAMBILAN = md5($ID_NOTA_PENGAMBILAN);
		$hsl3 = $this->db->query("UPDATE NOTA_PENGAMBILAN SET HASH_MD5_NOTA_PENGAMBILAN='$HASH_MD5_NOTA_PENGAMBILAN' WHERE ID_NOTA_PENGAMBILAN='$ID_NOTA_PENGAMBILAN'");

		$hsl2 = $this->db->query("SELECT HASH_MD5_NOTA_PENGAMBILAN FROM NOTA_PENGAMBILAN WHERE HASH_MD5_NOTA_PENGAMBILAN='$HASH_MD5_NOTA_PENGAMBILAN'");
		if ($hsl2->num_rows() > 0) {
			foreach ($hsl2->result() as $data) {
				$hasil2 = array(
					'HASH_MD5_NOTA_PENGAMBILAN' => $data->HASH_MD5_NOTA_PENGAMBILAN
				);
			}
		} else {
			$hasil = "BELUM ADA NOTA PENGAMBILAN";
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

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut sppb berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut
	//         2. 
	function get_nomor_urut_by_id_rasd($ID_RASD)
	{
		$hsl = $this->db->query("SELECT MAX(JUMLAH_COUNT) AS JUMLAH_COUNT FROM SPPB WHERE ID_RASD ='$ID_RASD'");
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

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut sppb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut_by_id_proyek
	//         2. 
	function get_nomor_urut_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT MAX(JUMLAH_COUNT) AS JUMLAH_COUNT FROM NOTA_PENGAMBILAN WHERE ID_PROYEK ='$ID_PROYEK'");
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
		$hsl = $this->db->query("SELECT P.INISIAL, P.ID_PROYEK, P.NAMA_PROYEK  FROM proyek as P 
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
		$hsl = $this->db->query("SELECT P.INISIAL, P.ID_PROYEK, P.NAMA_PROYEK  FROM proyek as P 
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

	function get_id_nota_pengambilan_by_HASH_MD5_NOTA_PENGAMBILAN($HASH_MD5_NOTA_PENGAMBILAN)
	{
		$hsl = $this->db->query("SELECT ID_NOTA_PENGAMBILAN FROM NOTA_PENGAMBILAN WHERE HASH_MD5_NOTA_PENGAMBILAN ='$HASH_MD5_NOTA_PENGAMBILAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB' => $data->ID_NOTA_PENGAMBILAN,
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
		$hasil = $this->db->query("SELECT S.ID_SPPB, P.NAMA_PROYEK,R.ID_RASD,S.JENIS_PEKERJAAN,S.NO_URUT_SPPB,
		S.TANGGAL_PEMBUATAN_SPPB_JAM,S.TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN,
		S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.PROGRESS_SPPB,S.DUE_DATE_CHIEF,S.DUE_DATE_SM,
		S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB
		FROM sppb AS S 
		LEFT JOIN rasd AS R ON R.ID_RASD = S.ID_RASD 
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
		S.ID_SPPB, P.NAMA_PROYEK, R.ID_RASD, S.JENIS_PEKERJAAN, S.NO_URUT_SPPB, 
		S.TANGGAL_PEMBUATAN_SPPB_JAM, S.TANGGAL_PEMBUATAN_SPPB_HARI, 
		S.TANGGAL_PEMBUATAN_SPPB_BULAN, S.TANGGAL_PEMBUATAN_SPPB_TAHUN,
		S.PROGRESS_SPPB,S.DUE_DATE_CHIEF,S.DUE_DATE_SM,
		S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,
		S.DUE_DATE_DIR,S.CB_PERSETUJUAN_M_LOG,S.CB_PERSETUJUAN_M_PROC,S.CB_PERSETUJUAN_M_SDM,
		S.CB_PERSETUJUAN_M_KONS,S.CB_PERSETUJUAN_M_EP,S.CB_PERSETUJUAN_M_QAQC,S.CB_PERSETUJUAN_M_KEU,
		S.CB_PERSETUJUAN_D_PSDS,S.CB_PERSETUJUAN_D_KONS,S.CB_PERSETUJUAN_D_KEU
		FROM sppb AS S 
		LEFT JOIN rasd AS R ON R.ID_RASD = S.ID_RASD 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
		WHERE S.ID_SPPB = '$ID_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB' => $data->ID_SPPB,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'ID_RASD' => $data->ID_RASD,
					'JENIS_PEKERJAAN' => $data->JENIS_PEKERJAAN,
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
		S.ID_SPPB, P.NAMA_PROYEK, R.ID_RASD, S.JENIS_PEKERJAAN, S.NO_URUT_SPPB, 
		S.TANGGAL_PEMBUATAN_SPPB_JAM, S.TANGGAL_PEMBUATAN_SPPB_HARI, 
		S.TANGGAL_PEMBUATAN_SPPB_BULAN, S.TANGGAL_PEMBUATAN_SPPB_TAHUN,
		S.PROGRESS_SPPB,S.DUE_DATE_CHIEF,S.DUE_DATE_SM,
		S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,
		S.DUE_DATE_DIR,S.CB_PERSETUJUAN_M_LOG,S.CB_PERSETUJUAN_M_PROC,S.CB_PERSETUJUAN_M_SDM,
		S.CB_PERSETUJUAN_M_KONS,S.CB_PERSETUJUAN_M_EP,S.CB_PERSETUJUAN_M_QAQC,S.CB_PERSETUJUAN_M_KEU,
		S.CB_PERSETUJUAN_D_PSDS,S.CB_PERSETUJUAN_D_KONS,S.CB_PERSETUJUAN_D_KEU
		FROM sppb AS S 
		LEFT JOIN rasd AS R ON R.ID_RASD = S.ID_RASD 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
		WHERE S.HASH_MD5_SPPB = '$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB' => $data->ID_SPPB,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'ID_RASD' => $data->ID_RASD,
					'JENIS_PEKERJAAN' => $data->JENIS_PEKERJAAN,
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
	function cek_no_urut_nota_pengambilan_by_admin($NO_URUT_NOTA_PENGAMBILAN)
	{
		$hsl = $this->db->query("SELECT ID_NOTA_PENGAMBILAN, NO_URUT_NOTA_PENGAMBILAN FROM NOTA_PENGAMBILAN WHERE NO_URUT_NOTA_PENGAMBILAN ='$NO_URUT_NOTA_PENGAMBILAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'NO_URUT_NOTA_PENGAMBILAN' => $data->NO_URUT_NOTA_PENGAMBILAN,
					'ID_NOTA_PENGAMBILAN' => $data->ID_NOTA_PENGAMBILAN
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
	) {
		$hasil = $this->db->query("UPDATE sppb SET 
		CTT_STAFF_LOG='$CTT'
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
	) {
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

	//FUNGSI: Fungsi ini untuk menambahkan data sppb berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function simpan_data
	//         2. controller SPPB / function simpan_ajuan_akhir
	function simpan_data_by_admin(
		$ID_RASD,
		$ID_PROYEK,
		$JENIS_PEKERJAAN,
		$TANGGAL_PEMBUATAN_SPPB_JAM,
		$TANGGAL_PEMBUATAN_SPPB_HARI,
		$TANGGAL_PEMBUATAN_SPPB_BULAN,
		$TANGGAL_PEMBUATAN_SPPB_TAHUN,
		$NO_URUT_SPPB,
		$JUMLAH_COUNT,
		$CREATE_BY_USER,
		$PROGRESS_SPPB,
		$STATUS_SPPB,
		$FILE_NAME_TEMP
	) {
		$hasil = $this->db->query("INSERT INTO sppb (
			ID_RASD,
			ID_PROYEK,
			JUMLAH_COUNT,
			JENIS_PEKERJAAN,
			TANGGAL_PEMBUATAN_SPPB_JAM,
            TANGGAL_PEMBUATAN_SPPB_HARI,
            TANGGAL_PEMBUATAN_SPPB_BULAN,
            TANGGAL_PEMBUATAN_SPPB_TAHUN,
			NO_URUT_SPPB,
			CREATE_BY_USER,
			PROGRESS_SPPB,
			STATUS_SPPB,
			FILE_NAME_TEMP)
		VALUES(
			'$ID_RASD',
			'$ID_PROYEK',
			'$JUMLAH_COUNT',
			'$JENIS_PEKERJAAN',
			'$TANGGAL_PEMBUATAN_SPPB_JAM',
    		'$TANGGAL_PEMBUATAN_SPPB_HARI',
    		'$TANGGAL_PEMBUATAN_SPPB_BULAN',
    		'$TANGGAL_PEMBUATAN_SPPB_TAHUN',
			'$NO_URUT_SPPB',
			'$CREATE_BY_USER',
			'$PROGRESS_SPPB',
			'$STATUS_SPPB',
			'$FILE_NAME_TEMP')");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function simpan_data_by_staff_gudang_logistik_sp(
		$ID_RASD,
		$ID_PROYEK,
		$TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_JAM,
		$TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_HARI,
		$TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_BULAN,
		$TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_TAHUN,
		$NO_URUT_NOTA_PENGAMBILAN,
		$JUMLAH_COUNT,
		$CREATE_BY_USER,
		$PROGRESS_NOTA_PENGAMBILAN,
		$STATUS_NOTA_PENGAMBILAN,
		$FILE_NAME_TEMP
	) {
		$hasil = $this->db->query("INSERT INTO NOTA_PENGAMBILAN (
			ID_RASD,
			ID_PROYEK,
			JUMLAH_COUNT,
			TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_JAM,
            TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_HARI,
            TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_BULAN,
            TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_TAHUN,
			NO_URUT_NOTA_PENGAMBILAN,
			CREATE_BY_USER,
			PROGRESS_NOTA_PENGAMBILAN,
			STATUS_NOTA_PENGAMBILAN,
			FILE_NAME_TEMP)
		VALUES(
			'$ID_RASD',
			'$ID_PROYEK',
			'$JUMLAH_COUNT',
			'$TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_JAM',
    		'$TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_HARI',
    		'$TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_BULAN',
    		'$TANGGAL_PEMBUATAN_NOTA_PENGAMBILAN_TAHUN',
			'$NO_URUT_NOTA_PENGAMBILAN',
			'$CREATE_BY_USER',
			'$PROGRESS_NOTA_PENGAMBILAN',
			'$STATUS_NOTA_PENGAMBILAN',
			'$FILE_NAME_TEMP'
			)");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan HASH_MD5_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_data_sppb_baru
	//         2. 
	function get_data_nota_pengambilan_baru($NO_URUT_NOTA_PENGAMBILAN)
	{
		$hsl = $this->db->query("SELECT * FROM NOTA_PENGAMBILAN WHERE NO_URUT_NOTA_PENGAMBILAN = '$NO_URUT_NOTA_PENGAMBILAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_NOTA_PENGAMBILAN' => $data->HASH_MD5_NOTA_PENGAMBILAN
				);
			}
		} else {
			$hasil = "BELUM ADA NOTA PENGAMBILAN";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb berdasarkan ID_USER
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function logout
	//         2. controller SPPB / function user_log
	function user_log_nota_pengambilan($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_nota_pengambilan (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
