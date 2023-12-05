<?php
class SPP_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb yang barangnya tidak ada di gudang
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPP / function index
	//         2. 
	function sppb_list_spp()
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.NO_URUT_SPPB, DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI, S.HASH_MD5_SPPB, P.NAMA_PROYEK, PSP.NAMA_SUB_PEKERJAAN from sppb AS S 
		LEFT JOIN proyek AS P on P.ID_PROYEK = S.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = S.ID_PROYEK_SUB_PEKERJAAN
		WHERE S.PROGRESS_SPPB = 'SPPB Pembelian Disetujui'");
		return $hasil->result();
	} // WHERE SF.GUDANG_TERSEDIA = 'TIDAK'

	function sppb_list_spp_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.NO_URUT_SPPB, DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI, S.HASH_MD5_SPPB, P.NAMA_PROYEK, PSP.NAMA_SUB_PEKERJAAN from sppb AS S 
		LEFT JOIN proyek AS P on P.ID_PROYEK = S.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = S.ID_PROYEK_SUB_PEKERJAAN
		WHERE S.PROGRESS_SPPB = 'SPPB Pembelian Disetujui' AND S.ID_PROYEK = '$ID_PROYEK'");
		return $hasil->result();
	}

	function sppb_list_spp_by_hashmd5($HASH_MD5_SPPB)
	{
		$hasil = $this->db->query("SELECT DISTINCT SF.ID_SPPB, S.NO_URUT_SPPB, P.NAMA_PROYEK, DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI, S.HASH_MD5_SPPB from sppb_form as SF 
		LEFT JOIN sppb AS S on S.ID_SPPB = SF.ID_SPPB LEFT JOIN proyek as P on P.ID_PROYEK = S.ID_PROYEK 
		WHERE( SF.GUDANG_TERSEDIA = 'TIDAK' AND S.HASH_MD5_SPPB = '$HASH_MD5_SPPB')");
		return $hasil->result();
	}

	function spp_list_spp_by_hashmd5($HASH_MD5_SPP)
	{

		$hasil = $this->db->query("SELECT FILE_NAME_TEMP,
		HASH_MD5_SPP,
		ID_HBP,
		ID_PROYEK,
		ID_SPP,
		ID_SPPB,
		JENIS_PERMINTAAN,
		JUMLAH_COUNT,
		NO_URUT_SPP,
		SUB_PROYEK,
		PROGRESS_SPP,
		SIGN_USER_D_EP_KONS,
		SIGN_USER_D_KEU,
		SIGN_USER_D_PSDS,
		SIGN_USER_M_EP,
		SIGN_USER_M_HSSE,
		SIGN_USER_M_KEU,
		SIGN_USER_M_KONS,
		SIGN_USER_M_LOG,
		SIGN_USER_M_PROC,
		SIGN_USER_M_QAQC,
		SIGN_USER_SM,
		CTT_DEPT_PROC,
		STATUS_SETUJU,
		STATUS_SPP,
		DATE_FORMAT(TANGGAL_DOKUMEN_SPP, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPP,
		DATE_FORMAT(TANGGAL_PEMBUATAN_SPP_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPP_HARI,
		TANGGAL_DOKUMEN_SPP AS TANGGAL_DOKUMEN_SPP_INDO,
		TANGGAL_PEMBUATAN_SPP_HARI AS TANGGAL_PEMBUATAN_SPP_HARI_INDO,
		TANGGAL_PEMBUATAN_SPP_BULAN,
		TANGGAL_PEMBUATAN_SPP_JAM,
		TANGGAL_PEMBUATAN_SPP_TAHUN,
		TERBILANG,
		TOLAK_D_KEU,
		TOLAK_D_KONS,
		TOLAK_D_PSDS,
		TOLAK_KASIE_PROC_KP,
		TOLAK_M_EP,
		TOLAK_M_HSSE,
		TOLAK_M_KEU,
		TOLAK_M_KONS,
		TOLAK_M_LOG,
		TOLAK_M_PROC_KP,
		TOLAK_M_QAQC,
		TOLAK_M_SDM,
		TOLAK_PM,
		TOLAK_SM,
		TOLAK_SPV_PROC_PROYEK,
		TOLAK_STAFF_PROC_KP,
		TOTAL_ALL_SPP_BARANG,
		TOTAL_HARGA_SPP_BARANG,
		TOTAL_PAJAK_SPP_BARANG,
		JENIS_PERMINTAAN,
		TAMPILKAN_KONTROL_ANGGARAN,
		BARIS_KOSONG
		from spp WHERE ( HASH_MD5_SPP = '$HASH_MD5_SPP')");
		return $hasil;
	}

	function spp_list_by_ID_VENDOR($ID_VENDOR, $WAKTU)
	{

		$hasil = $this->db->query("SELECT * from spp WHERE ( ID_VENDOR = '$ID_VENDOR') AND ( BATAS_AKHIR > '$WAKTU' ) AND ( STATUS_VENDOR = '')");
		return $hasil->result();
	}

	function spp_list_by_id_sppb($ID_SPPB)
	{

		$hasil = $this->db->query("SELECT * from spp WHERE ( ID_SPPB = '$ID_SPPB')");
		return $hasil->result();
	}

	function qty_spp_form_by_id_spp($ID_SPP)
	{
		$hasil = $this->db->query("SELECT COUNT(ID_SPP) AS JUMLAH_BARANG_SPP FROM spp_form where ID_SPP = '$ID_SPP'");
		return $hasil->result();
	}



	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut SPP  berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel rfq
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut
	//         2. 
	function get_nomor_urut_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT MAX(SPP.JUMLAH_COUNT) AS JUMLAH_COUNT_SPP FROM spp AS SPP WHERE SPP.ID_PROYEK ='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'JUMLAH_COUNT_SPP' => $data->JUMLAH_COUNT_SPP
				);
			}
		} else {
			$hasil = "BELUM ADA SPP";
		}
		return $hasil;
	}

	function get_data_spp_by_id_spp($ID_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, HASH_MD5_SPP, NO_URUT_SPP, ID_SPPB, ID_PROYEK, PROGRESS_SPP, STATUS_SPP, BARIS_KOSONG FROM spp WHERE ID_SPP ='$ID_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPP' => $data->ID_SPP,
					'HASH_MD5_SPP' => $data->HASH_MD5_SPP,
					'NO_URUT_SPP' => $data->NO_URUT_SPP,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK' => $data->ID_PROYEK,
					'PROGRESS_SPP' => $data->PROGRESS_SPP,
					'STATUS_SPP' => $data->STATUS_SPP,
					'BARIS_KOSONG' => $data->BARIS_KOSONG
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_spp_by_HASH_MD5_SPP($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, HASH_MD5_SPP, NO_URUT_SPP, ID_SPPB, ID_PROYEK, PROGRESS_SPP, STATUS_SPP, BARIS_KOSONG  FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPP' => $data->ID_SPP,
					'HASH_MD5_SPP' => $data->HASH_MD5_SPP,
					'NO_URUT_SPP' => $data->NO_URUT_SPP,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK' => $data->ID_PROYEK,
					'PROGRESS_SPP' => $data->PROGRESS_SPP,
					'STATUS_SPP' => $data->STATUS_SPP,
					'BARIS_KOSONG' => $data->BARIS_KOSONG
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_id_spp_by_HASH_MD5_SPP($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP FROM SPP WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPP' => $data->ID_SPP,
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA";
		}
		return $hasil;
	}

	function get_list_spp_by_id_sppb($ID_SPPB)
	{
		$hsl = $this->db->query("SELECT HASH_MD5_SPP, NO_URUT_SPP, STATUS_SPP, DATE_FORMAT(TANGGAL_DOKUMEN_SPP, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPP, ID_SPP FROM spp WHERE ID_SPPB ='$ID_SPPB'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_sppb_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT S.ID_SPPB, S.NO_URUT_SPPB, S.ID_PROYEK_SUB_PEKERJAAN, PSP.NAMA_SUB_PEKERJAAN FROM sppb as S
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON S.ID_PROYEK_SUB_PEKERJAAN = PSP.ID_PROYEK_SUB_PEKERJAAN
		WHERE S.ID_PROYEK ='$ID_PROYEK' AND S.COMPLETE='' AND S.PROGRESS_SPPB='SPPB Pembelian Disetujui' "); 
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_sub_pekerjaan_by_id_sppb($ID_SPPB)
	{
		$hsl = $this->db->query("SELECT S.ID_SPPB, S.NO_URUT_SPPB, S.ID_PROYEK_SUB_PEKERJAAN, PSP.NAMA_SUB_PEKERJAAN FROM sppb as S
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON S.ID_PROYEK_SUB_PEKERJAAN = PSP.ID_PROYEK_SUB_PEKERJAAN
		WHERE S.ID_SPPB ='$ID_SPPB' AND S.COMPLETE='' AND S.PROGRESS_SPPB='SPPB Pembelian Disetujui' ");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_STAFF_PROC_PROYEK($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_STAFF_PROC_PROYEK FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_STAFF_PROC_PROYEK' => $data->CTT_STAFF_PROC_PROYEK,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_STAFF_PROC_SP($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_STAFF_PROC_SP FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_STAFF_PROC_SP' => $data->CTT_STAFF_PROC_SP,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_SPV_PROC_PROYEK($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_SPV_PROC_PROYEK FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_SPV_PROC_PROYEK' => $data->CTT_SPV_PROC_PROYEK,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_PROC_KP($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_PROC_KP FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_PROC_KP' => $data->CTT_M_PROC_KP,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_D_KONS($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_D_KONS FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_D_KONS' => $data->CTT_D_KONS,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_SPV_PROC_SP($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_SPV_PROC_SP FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_SPV_PROC_SP' => $data->CTT_SPV_PROC_SP,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_SM($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_SM FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_SM' => $data->CTT_SM,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_PM($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_PM FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_PM' => $data->CTT_PM,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_STAFF_PROC_KP($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_STAFF_PROC_KP FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_STAFF_PROC_KP' => $data->CTT_STAFF_PROC_KP,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_KASIE_PROC_KP($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_KASIE_PROC_KP FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_KASIE_PROC_KP' => $data->CTT_KASIE_PROC_KP,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_LOG($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_LOG FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_LOG' => $data->CTT_M_LOG,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_KEU($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_KEU FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_KEU' => $data->CTT_M_KEU,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_KONS($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_KONS FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_KONS' => $data->CTT_M_KONS,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_SDM($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_SDM FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_SDM' => $data->CTT_M_SDM,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_QAQC($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_QAQC FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_QAQC' => $data->CTT_M_QAQC,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_EP($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_EP FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_EP' => $data->CTT_M_EP,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_HSSE($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_HSSE FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_HSSE' => $data->CTT_M_HSSE,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_MARKETING($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_MARKETING FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_MARKETING' => $data->CTT_M_MARKETING,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_KOMERSIAL($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_KOMERSIAL FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_KOMERSIAL' => $data->CTT_M_KOMERSIAL,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_M_PROC($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_M_PROC FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_M_PROC' => $data->CTT_M_PROC,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_D_KEU($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_D_KEU FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_D_KEU' => $data->CTT_D_KEU,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_D_EP_KONS($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_D_EP_KONS FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_D_EP_KONS' => $data->CTT_D_EP_KONS,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_D_PSDS($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, CTT_D_PSDS FROM spp WHERE HASH_MD5_SPP ='$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_D_PSDS' => $data->CTT_D_PSDS,
					'ID_SPP' => $data->ID_SPP
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function cek_nomor_urut_spp($NO_URUT_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPP, HASH_MD5_SPP, NO_URUT_SPP FROM spp WHERE NO_URUT_SPP ='$NO_URUT_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPP ' => $data->ID_SPP,
					'HASH_MD5_SPP' => $data->HASH_MD5_SPP,
					'NO_URUT_SPP' => $data->NO_URUT_SPP
				);
			}
			return $hasil;
		} else {
			return 'DATA BELUM ADA';
		}
	}

	//FUNGSI: Fungsi ini untuk menambahkan data SPP
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPP_form / function simpan_data_dari_barang_master
	//         2. 
	function simpan_data_spp(
		$ID_SPPB,
		$ID_PROYEK,
		$ID_PROYEK_SUB_PEKERJAAN,
		$JUMLAH_COUNT_SPP,
		$SUB_PROYEK,
		$NO_URUT_SPP,
		$CREATE_BY_USER,
		$PROGRESS_SPP,
		$STATUS_SPP,
		$TANGGAL_DOKUMEN_SPP,
		$TANGGAL_PEMBUATAN_SPP_JAM,
		$TANGGAL_PEMBUATAN_SPP_HARI,
		$TANGGAL_PEMBUATAN_SPP_BULAN,
		$TANGGAL_PEMBUATAN_SPP_TAHUN,
		$JENIS_PERMINTAAN,
		$FILE_NAME_TEMP
	)
	{
		$hasil = $this->db->query(
			"INSERT INTO spp
			(
				ID_SPPB,
				ID_PROYEK,
				ID_PROYEK_SUB_PEKERJAAN,
				JUMLAH_COUNT,
				SUB_PROYEK,
				NO_URUT_SPP,
				CREATE_BY_USER,
				PROGRESS_SPP,
				STATUS_SPP,
				TANGGAL_DOKUMEN_SPP,
				TANGGAL_PEMBUATAN_SPP_JAM,
				TANGGAL_PEMBUATAN_SPP_HARI,
				TANGGAL_PEMBUATAN_SPP_BULAN,
				TANGGAL_PEMBUATAN_SPP_TAHUN,
				JENIS_PERMINTAAN,
				FILE_NAME_TEMP
			)
			VALUES
			(
				'$ID_SPPB',
				'$ID_PROYEK',
				'$ID_PROYEK_SUB_PEKERJAAN',
				'$JUMLAH_COUNT_SPP',
				'$SUB_PROYEK',
				'$NO_URUT_SPP',
				'$CREATE_BY_USER',
				'$PROGRESS_SPP',
				'$STATUS_SPP',
				'$TANGGAL_DOKUMEN_SPP',
				'$TANGGAL_PEMBUATAN_SPP_JAM',
				'$TANGGAL_PEMBUATAN_SPP_HARI',
				'$TANGGAL_PEMBUATAN_SPP_BULAN',
				'$TANGGAL_PEMBUATAN_SPP_TAHUN',
				'$JENIS_PERMINTAAN',
				'$FILE_NAME_TEMP'
			)"
		);

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengeset HASH_MD5_SPPB berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function set_md5_id_SPP($ID_PROYEK, $ID_SPPB, $NO_URUT_SPP, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT ID_SPP FROM spp WHERE ID_PROYEK='$ID_PROYEK' AND
		ID_SPPB='$ID_SPPB' AND NO_URUT_SPP='$NO_URUT_SPP' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPP' => $data->ID_SPP
				);
			}
		} else {
			$hasil = "BELUM ADA SPP";
		}
		$ID_SPP = $hasil['ID_SPP'];
		$HASH_MD5_SPP = md5($ID_SPP);
		$hasil = $this->db->query("UPDATE spp SET HASH_MD5_SPP='$HASH_MD5_SPP' WHERE ID_SPP='$ID_SPP'");

		//TAMPILKAN KONTROL ANGGARAN
		$hasil = $this->db->query("UPDATE spp SET TAMPILKAN_KONTROL_ANGGARAN='TAMPIL' WHERE ID_SPP='$ID_SPP'");

		//KODINGAN COPY DATA SPPB FORM KE SPP FORM
		// $hsl_2 = $this->db->query("SELECT SF.ID_SPPB_FORM, SF.ID_RASD_FORM, SF.ID_RAB_FORM, SF.ID_SPPB, SF.ID_PROYEK_SUB_PEKERJAAN, SF.SATUAN_BARANG, SF.ID_KLASIFIKASI_BARANG, SF.NAMA_BARANG, SF.MEREK, SF.SPESIFIKASI_SINGKAT, SF.JUMLAH_SETUJU_TERAKHIR, SF.TANGGAL_MULAI_PAKAI_HARI, SF.TANGGAL_SELESAI_PAKAI_HARI, SF.JUMLAH_QTY_SPP, SF.KETERANGAN_UMUM, SF.NAMA_KATEGORI_RAB
		// FROM sppb_form AS SF
		// LEFT JOIN fpb_form AS FPBF ON SF.ID_FPB_FORM = FPBF.ID_FPB_FORM
		// WHERE SF.ID_SPPB = '$ID_SPPB' AND SF.JUMLAH_QTY_SPP > 0");
		// if ($hsl_2->num_rows() > 0) {
		// 	foreach ($hsl_2->result() as $data) {
		// 		$hasil_2 = array(
		// 			'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
		// 			'ID_RASD_FORM' => $data->ID_RASD_FORM,
		// 			'ID_RAB_FORM' => $data->ID_RAB_FORM,
		// 			'ID_SPPB' => $data->ID_SPPB,
		// 			'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
		// 			'SATUAN_BARANG' => $data->SATUAN_BARANG,
		// 			'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
		// 			'NAMA_BARANG' => $data->NAMA_BARANG,
		// 			'MEREK' => $data->MEREK,
		// 			'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
		// 			'JUMLAH_SETUJU_TERAKHIR' => $data->JUMLAH_SETUJU_TERAKHIR,
		// 			'TANGGAL_MULAI_PAKAI_HARI' => $data->TANGGAL_MULAI_PAKAI_HARI,
		// 			'TANGGAL_SELESAI_PAKAI_HARI' => $data->TANGGAL_SELESAI_PAKAI_HARI,
		// 			'JUMLAH_QTY_SPP' => $data->JUMLAH_QTY_SPP,
		// 			'KETERANGAN_UMUM' => $data->KETERANGAN_UMUM,
		// 			'NAMA_KATEGORI_RAB' => $data->NAMA_KATEGORI_RAB
		// 		);

		// 		$this->db->query(
		// 			"INSERT INTO spp_form (ID_SPP, ID_SPPB_FORM, ID_SPPB, ID_RASD_FORM, ID_RAB_FORM, ID_PROYEK_SUB_PEKERJAAN, SATUAN_BARANG, ID_KLASIFIKASI_BARANG, NAMA_BARANG, MEREK, SPESIFIKASI_SINGKAT, JUMLAH_BARANG, TANGGAL_MULAI_PAKAI_HARI, TANGGAL_SELESAI_PAKAI_HARI, KETERANGAN_UMUM, NAMA_KATEGORI_RAB)
		// 			VALUES ('$ID_SPP', 
		// 			'$data->ID_SPPB_FORM', 
		// 			'$data->ID_SPPB', 
		// 			'$data->ID_RASD_FORM',
		// 			'$data->ID_RAB_FORM',
		// 			'$data->ID_PROYEK_SUB_PEKERJAAN', 
		// 			'$data->SATUAN_BARANG', 
		// 			'$data->ID_KLASIFIKASI_BARANG', 
		// 			'$data->NAMA_BARANG', 
		// 			'$data->MEREK', 
		// 			'$data->SPESIFIKASI_SINGKAT', 
		// 			'$data->JUMLAH_QTY_SPP', 
		// 			'$data->TANGGAL_MULAI_PAKAI_HARI',
		// 			'$data->TANGGAL_SELESAI_PAKAI_HARI',
		// 			'$data->KETERANGAN_UMUM',
		// 			'$data->NAMA_KATEGORI_RAB'
		// 			)"
		// 		);

		// 		$this->db->query(
		// 			"UPDATE sppb_form SET 
		// 			STATUS_SPP='Dalam Proses SPP', KET_SPP='$ID_SPP'
		// 			WHERE ID_SPPB_FORM='$data->ID_SPPB_FORM'"
		// 		);
		// 	}
		// }

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut sppb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut_by_id_proyek
	//         2. 
	function get_data_proyek_by_hash_md5_sppb($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT S.ID_PROYEK, S.NO_URUT_SPPB, S.ID_SPPB, S.ID_PROYEK_SUB_PEKERJAAN, S.SUB_PROYEK, P.NAMA_PROYEK, P.LOKASI, P.INISIAL from sppb as S 
		LEFT JOIN proyek AS P ON S.ID_PROYEK = P.ID_PROYEK
		WHERE S.HASH_MD5_SPPB = '$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'SUB_PROYEK' => $data->SUB_PROYEK,
					'LOKASI' => $data->LOKASI,
					'INISIAL' => $data->INISIAL,
					'NO_URUT_SPPB' => $data->NO_URUT_SPPB,
					'ID_SPPB' => $data->ID_SPPB
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data SPP berdasarkan yang baru diinput
	//SUMBER TABEL: tabel SPP
	//DIPAKAI: 1. controller SPP / function get_data_rfq_baru
	//         2. 
	function get_data_spp_baru($ID_PROYEK, $NO_URUT_SPP, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT * FROM spp WHERE ID_PROYEK = '$ID_PROYEK' AND
		NO_URUT_SPP = '$NO_URUT_SPP' AND
		CREATE_BY_USER = '$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_SPP' => $data->HASH_MD5_SPP
				);
			}
		} else {
			$hasil = "BELUM ADA SPP";
		}
		return $hasil;
	}

	function get_data_id_vendor_by_id_spp($ID_SPP)
	{
		$hsl = $this->db->query("SELECT DISTINCT SF.ID_VENDOR_FIX, V.NAMA_VENDOR, V.ID_VENDOR
		FROM spp_form AS SF
        LEFT JOIN spp AS SP ON SP.ID_SPP = SF.ID_SPP
		LEFT JOIN vendor AS V ON V.ID_VENDOR = SF.ID_VENDOR_FIX
		WHERE SP.ID_SPP = '$ID_SPP'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	

	//FUNGSI: Fungsi ini untuk menampilkan data SPP berdasarkan ID_SPP
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller SPP_form / function index

	function spp_list_by_id_spp_result($ID_SPP)
	{
		$hasil = $this->db->query("SELECT SP.ID_SPP, SP.HASH_MD5_SPP, SP.NO_URUT_SPP, SP.TANGGAL_PEMBUATAN_SPP_JAM, SP.TANGGAL_PEMBUATAN_SPP_HARI, SP.TANGGAL_PEMBUATAN_SPP_BULAN, SP.TANGGAL_PEMBUATAN_SPP_TAHUN, P.NAMA_PROYEK
		FROM spp AS SP
		LEFT JOIN proyek AS P ON P.ID_PROYEK = SP.ID_PROYEK
		WHERE SP.ID_SPP = '$ID_SPP'");
		return $hasil->result();
	}

	function spp_list_by_id_spp($ID_SPP)
	{
		$hasil = $this->db->query("SELECT SP.ID_SPP, SP.HASH_MD5_SPP, SP.NO_URUT_SPP, SP.PROGRESS_SPP, SP.STATUS_SPP, SP.TANGGAL_PEMBUATAN_SPP_JAM, SP.TANGGAL_PEMBUATAN_SPP_HARI, SP.TANGGAL_PEMBUATAN_SPP_BULAN, SP.TANGGAL_PEMBUATAN_SPP_TAHUN, P.NAMA_PROYEK
		FROM spp AS SP
		LEFT JOIN proyek AS P ON P.ID_PROYEK = SP.ID_PROYEK
		WHERE SP.ID_SPP = '$ID_SPP'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data rfq form berdasarkan ID_SPP_FORM
	//SUMBER TABEL: tabel rfq
	//DIPAKAI: 1. controller SPP_form / function simpan_perubahan_pdf
	//         
	function simpan_perubahan_pdf($ID_SPP, $LOKASI_PENYERAHAN, $ID_VENDOR, $TOP, $TANGGAL_PEMBUATAN_SPP_HARI, $PROGRESS_SPP)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			LOKASI_PENYERAHAN='$LOKASI_PENYERAHAN',
			ID_VENDOR='$ID_VENDOR',
			TOP='$TOP',
			TANGGAL_PEMBUATAN_SPP_HARI='$TANGGAL_PEMBUATAN_SPP_HARI',
			PROGRESS_SPP='$PROGRESS_SPP'
			WHERE ID_SPP='$ID_SPP'");
		return $hasil;
	}

	function update_progress_spp($HASH_MD5_SPP, $PROGRESS_SPP)
	{
		$hasil = $this->db->query("UPDATE spp SET 
			PROGRESS_SPP='$PROGRESS_SPP'
			WHERE HASH_MD5_SPP='$HASH_MD5_SPP'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb berdasarkan ID_USER
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function logout
	//         2. controller SPPB / function user_log
	function user_log_spp($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_spp (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}