<?php
class PO_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb yang barangnya tidak ada di gudang
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller PO / function index
	//         2. 
	function sppb_list_po()
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.NO_URUT_SPPB, S.TANGGAL_PEMBUATAN_SPPB_HARI, S.HASH_MD5_SPPB, P.NAMA_PROYEK from sppb AS S LEFT JOIN proyek AS P on P.ID_PROYEK = S.ID_PROYEK WHERE S.PROGRESS_SPPB = 'SPPB Disetujui'");
		return $hasil->result();
	}
	// WHERE SF.GUDANG_TERSEDIA = 'TIDAK'

	function sppb_list_po_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.NO_URUT_SPPB, S.TANGGAL_PEMBUATAN_SPPB_HARI, S.HASH_MD5_SPPB, P.NAMA_PROYEK from sppb AS S LEFT JOIN proyek AS P on P.ID_PROYEK = S.ID_PROYEK WHERE S.PROGRESS_SPPB = 'SPPB Disetujui' AND S.ID_PROYEK = '$ID_PROYEK'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh spp yang barangnya tidak ada di gudang
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller PO / function index
	//         2. 
	function spp_list_po()
	{
		$hasil = $this->db->query("SELECT SP.ID_SPP, SP.NO_URUT_SPP, P.NAMA_PROYEK, DATE_FORMAT(SP.TANGGAL_DOKUMEN_SPP, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPP, DATE_FORMAT(SP.TANGGAL_PEMBUATAN_SPP_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPP_HARI, SP.HASH_MD5_SPP, PSP.NAMA_SUB_PEKERJAAN from spp AS SP 
		LEFT JOIN proyek AS P on P.ID_PROYEK = SP.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = SP.ID_PROYEK_SUB_PEKERJAAN");
		return $hasil->result();
	}

	function spp_list_po_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT SP.ID_SPP, SP.NO_URUT_SPP, P.NAMA_PROYEK, SP.TANGGAL_DOKUMEN_SPP, SP.TANGGAL_PEMBUATAN_SPP_HARI, SP.HASH_MD5_SPP, PSP.NAMA_SUB_PEKERJAAN from spp AS SP 
		LEFT JOIN proyek AS P on P.ID_PROYEK = SP.ID_PROYEK 
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = SP.ID_PROYEK_SUB_PEKERJAAN
		WHERE SP.ID_PROYEK = '$ID_PROYEK'");
		return $hasil->result();
	}

	function sppb_list_po_by_hashmd5($HASH_MD5_SPPB)
	{
		$hasil = $this->db->query("SELECT DISTINCT SF.ID_SPPB, S.NO_URUT_SPPB, P.NAMA_PROYEK, S.TANGGAL_PEMBUATAN_SPPB_HARI, S.HASH_MD5_SPPB from sppb_form as SF LEFT JOIN sppb AS S on S.ID_SPPB = SF.ID_SPPB LEFT JOIN proyek as P on P.ID_PROYEK = S.ID_PROYEK WHERE( SF.GUDANG_TERSEDIA = 'TIDAK' AND S.HASH_MD5_SPPB = '$HASH_MD5_SPPB')");
		return $hasil->result();
	}

	function po_list_po_by_hashmd5($HASH_MD5_PO)
	{

		$hasil = $this->db->query("SELECT ID_PO, NO_URUT_PO, ID_SPP, ID_SPPB, ID_PROYEK, ID_PROYEK_SUB_PEKERJAAN, LOKASI_PENYERAHAN, TERM_OF_PAYMENT, ID_VENDOR, DATE_FORMAT(TANGGAL_DOKUMEN_PO, '%d/%m/%Y') AS TANGGAL_DOKUMEN_PO, TANGGAL_DOKUMEN_PO AS TANGGAL_DOKUMEN_PO_INDO, TANGGAL_KIRIM_BARANG_HARI, TANGGAL_MULAI_PAKAI_HARI, TANGGAL_SELESAI_PAKAI_HARI, CTT_KEPERLUAN, CTT_KEPERLUAN_BARIS_2, REFERENSI_DOKUMEN_SPH, REFERENSI_DOKUMEN_KONTRAK, NOMINAL_DISKON, BARIS_KOSONG, TANGGAL_PEMBUATAN_PO_HARI, HASH_MD5_PO, JENIS_PENGADAAN, KONDISI_PENGADAAN_BARIS_1, KONDISI_PENGADAAN_BARIS_2, KONDISI_PENGADAAN_BARIS_3, KONDISI_PENGADAAN_BARIS_4, KONDISI_PENGADAAN_BARIS_5, KONDISI_PENGADAAN_BARIS_6, KONDISI_PENGADAAN_BARIS_7, KONDISI_PENGADAAN_BARIS_8, TANDA_TANGAN_1, TANDA_TANGAN_2  from po WHERE ( HASH_MD5_PO = '$HASH_MD5_PO')");
		return $hasil;
	}

	function qty_po_form_by_id_po($ID_PO)
	{
		$hasil = $this->db->query("SELECT COUNT(ID_PO) AS JUMLAH_BARANG_PO FROM po_form where ID_PO = '$ID_PO'");
		return $hasil->result();
	}


	function sppb_list_by_id_sppb_result($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.HASH_MD5_SPPB, P.NAMA_PROYEK,S.TANGGAL_DOKUMEN_SPPB,S.NO_URUT_SPPB,S.TANGGAL_PEMBUATAN_SPPB_JAM,S.TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN,S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB,S.PROGRESS_SPPB,S.STATUS_SPPB
		FROM sppb AS S 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
        WHERE S.ID_SPPB = '$ID_SPPB'");
		return $hasil->result();
		//return $hasil->result();
	}

	function sppb_list_by_id_sppb($ID_SPPB)
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.HASH_MD5_SPPB, S.SUB_PROYEK, PSP.ID_PROYEK_SUB_PEKERJAAN, PSP.NAMA_SUB_PEKERJAAN, P.NAMA_PROYEK, P.HASH_MD5_PROYEK, DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB,S.NO_URUT_SPPB,S.TANGGAL_PEMBUATAN_SPPB_JAM,DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN,S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB,S.PROGRESS_SPPB,S.STATUS_SPPB, S.CTT_DEPT_PROC
		FROM sppb AS S 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
        LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = S.ID_PROYEK_SUB_PEKERJAAN
        WHERE S.ID_SPPB =  '$ID_SPPB' ORDER BY S.NO_URUT_SPPB DESC");
		return $hasil;
	}

	function po_list_by_ID_VENDOR($ID_VENDOR)
	{

		$hasil = $this->db->query("SELECT * from po WHERE ( ID_VENDOR = '$ID_VENDOR')");
		return $hasil->result();
	}


	function po_list()
	{

		$hasil = $this->db->query("SELECT * from po");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut PO  berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel po
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut
	//         2. 
	function get_nomor_urut_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT MAX(PO.JUMLAH_COUNT) AS JUMLAH_COUNT_PO FROM po AS PO WHERE PO.ID_PROYEK ='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'JUMLAH_COUNT_PO' => $data->JUMLAH_COUNT_PO
				);
			}
		} else {
			$hasil = "BELUM ADA PO";
		}
		return $hasil;
	}

	function get_data_spp_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT SP.ID_SPP, SP.HASH_MD5_SPP, SP.NO_URUT_SPP, SP.ID_PROYEK_SUB_PEKERJAAN, PSP.NAMA_SUB_PEKERJAAN FROM spp as SP
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON SP.ID_PROYEK_SUB_PEKERJAAN = PSP.ID_PROYEK_SUB_PEKERJAAN
		WHERE SP.ID_PROYEK ='$ID_PROYEK' AND SP.COMPLETE='' ");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_sub_pekerjaan_by_id_spp($ID_SPP)
	{
		$hsl = $this->db->query("SELECT SP.ID_SPP, SP.NO_URUT_SPP, SP.ID_PROYEK_SUB_PEKERJAAN, PSP.NAMA_SUB_PEKERJAAN FROM spp as SP
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON SP.ID_PROYEK_SUB_PEKERJAAN = PSP.ID_PROYEK_SUB_PEKERJAAN
		WHERE SP.ID_SPP ='$ID_SPP' AND SP.COMPLETE='' ");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
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

	function get_data_jenis_pengadaan_by_id_spp_id_vendor($ID_SPP, $ID_VENDOR)
	{
		$hsl = $this->db->query("SELECT DISTINCT SF.JENIS_PENGADAAN
		FROM spp_form AS SF
		WHERE SF.ID_SPP = '$ID_SPP' AND SF.ID_VENDOR_FIX = '$ID_VENDOR'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_jenis_pengadaan_by_id_spp_id_vendor_jenis_pengadaan($ID_SPP, $ID_VENDOR, $JENIS_PENGADAAN)
	{
		$hsl = $this->db->query("SELECT DISTINCT SF.ID_KLASIFIKASI_BARANG, KB.NAMA_KLASIFIKASI_BARANG
		FROM spp_form AS SF
		LEFT JOIN klasifikasi_barang AS KB ON SF.ID_KLASIFIKASI_BARANG = KB.ID_KLASIFIKASI_BARANG
		WHERE SF.ID_SPP = '$ID_SPP' AND SF.ID_VENDOR_FIX = '$ID_VENDOR' AND SF.JENIS_PENGADAAN = '$JENIS_PENGADAAN'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_id_rab_form_by_id_spp($ID_SPP)
	{
		$hsl = $this->db->query("SELECT ID_SPPB FROM SPP where ID_SPP  ='$ID_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil_1 = array(
					'ID_SPPB' => $data->ID_SPPB
				);
			}
			$ID_SPPB = $hasil_1['ID_SPPB'];

			$hsl_1 = $this->db->query("SELECT ID_PROYEK, ID_PROYEK_SUB_PEKERJAAN FROM SPPB where ID_SPPB ='$ID_SPPB'");

			if ($hsl_1->num_rows() > 0) {
				foreach ($hsl_1->result() as $data) {
					$hasil_2 = array(
						'ID_PROYEK' => $data->ID_PROYEK,
						'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN
					);
				}
				$ID_PROYEK = $hasil_2['ID_PROYEK'];
				$ID_PROYEK_SUB_PEKERJAAN = $hasil_2['ID_PROYEK_SUB_PEKERJAAN'];

				$hsl_2 = $this->db->query("SELECT * FROM RAB where ID_PROYEK  ='$ID_PROYEK' AND ID_PROYEK_SUB_PEKERJAAN ='$ID_PROYEK_SUB_PEKERJAAN' ");
				if ($hsl_2->num_rows() > 0) {
					foreach ($hsl_2->result() as $data) {
						$hasil_3 = array(
							'ID_RAB' => $data->ID_RAB
						);
					}
					$ID_RAB = $hasil_3['ID_RAB'];
					$hasil = $this->db->query("SELECT * FROM RAB_FORM where ID_RAB  ='$ID_RAB' ");
					return $hasil->result();
				} else {
					return 'Data belum ada';
				}
			}
		}
	}


	function get_data_po_by_HASH_MD5_PO($HASH_MD5_PO)
	{
		$hsl = $this->db->query("SELECT DISTINCT
		PO.ID_PO,
        PO.HASH_MD5_PO,
        PO.ID_SPPB,
        PO.ID_RASD,
        PO.ID_VENDOR,
        PO.ID_SPP,
        PO.NO_URUT_PO,
        PO.PROGRESS_PO,
        PO.TERM_OF_PAYMENT,
        PO.JUMLAH_COUNT,
		PO.JENIS_PENGADAAN,
		DATE_FORMAT( PO.TANGGAL_PEMBUATAN_PO_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_PO_HARI,
		DATE_FORMAT( PO.TANGGAL_DOKUMEN_PO, '%d/%m/%Y') AS TANGGAL_DOKUMEN_PO,
		DATE_FORMAT( PO.TANGGAL_KIRIM_BARANG_HARI, '%d/%m/%Y') AS TANGGAL_KIRIM_BARANG_HARI,
        PO.CTT_KEPERLUAN,
		PO.CTT_KEPERLUAN_BARIS_2,
        PO.KETERANGAN_RFQ,
        PO.CTT_STAFF_PROC,
        PO.CTT_KASIE,
        PO.CTT_MANAGER_PROC,
        PO.CREATE_BY_USER,
        DATE_FORMAT( PO.BATAS_AKHIR, '%d/%m/%Y') AS BATAS_AKHIR,
        PO.CTT_KEPERLUAN,
        PO.LOKASI_PENYERAHAN,
        PO.ID_PROYEK,
        PO.TOTAL_HARGA_PO_BARANG,
        PO.TERBILANG,
		PO.DISKON,
		PO.NOMINAL_DISKON,
        SPP.NO_URUT_SPP,
        PF.ID_PAJAK,
		PO.KONDISI_PENGADAAN_BARIS_1,
		PO.KONDISI_PENGADAAN_BARIS_2,
		PO.KONDISI_PENGADAAN_BARIS_3,
		PO.KONDISI_PENGADAAN_BARIS_4,
		PO.KONDISI_PENGADAAN_BARIS_5,
		PO.KONDISI_PENGADAAN_BARIS_6,
		PO.KONDISI_PENGADAAN_BARIS_7,
		PO.KONDISI_PENGADAAN_BARIS_8,
		PO.REFERENSI_DOKUMEN_SPH,
		PO.REFERENSI_DOKUMEN_KONTRAK,
		DATE_FORMAT( PO.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI,
		DATE_FORMAT( PO.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI,
		DATE_FORMAT( PF.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI_PF,
		DATE_FORMAT( PF.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI_PF,
		PO.BARIS_KOSONG,
		PO.TANDA_TANGAN_1,
		PO.TANDA_TANGAN_2

        FROM po AS PO
        LEFT JOIN spp AS SPP ON PO.ID_SPP = SPP.ID_SPP
        LEFT JOIN po_form AS PF ON PO.ID_PO = PF.ID_PO
        WHERE PO.HASH_MD5_PO = '$HASH_MD5_PO'");

		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PO' => $data->ID_PO,
					'ID_SPP' => $data->ID_SPP,
					'HASH_MD5_PO' => $data->HASH_MD5_PO,
					'NO_URUT_PO' => $data->NO_URUT_PO,
					'JENIS_PENGADAAN' => $data->JENIS_PENGADAAN,
					'NO_URUT_SPP' => $data->NO_URUT_SPP,
					'ID_SPPB' => $data->ID_SPPB,
					'PROGRESS_PO' => $data->PROGRESS_PO,
					'CTT_KEPERLUAN' => $data->CTT_KEPERLUAN,
					'CTT_KEPERLUAN_BARIS_2' => $data->CTT_KEPERLUAN_BARIS_2,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_VENDOR' => $data->ID_VENDOR,
					'TERM_OF_PAYMENT' => $data->TERM_OF_PAYMENT,
					'LOKASI_PENYERAHAN' => $data->LOKASI_PENYERAHAN,
					'BATAS_AKHIR' => $data->BATAS_AKHIR,
					'TANGGAL_KIRIM_BARANG_HARI' => $data->TANGGAL_KIRIM_BARANG_HARI,
					'TANGGAL_PEMBUATAN_PO_HARI' => $data->TANGGAL_PEMBUATAN_PO_HARI,
					'TANGGAL_DOKUMEN_PO' => $data->TANGGAL_DOKUMEN_PO,
					'DISKON' => $data->DISKON,
					'NOMINAL_DISKON' => $data->NOMINAL_DISKON,
					'ID_PAJAK' => $data->ID_PAJAK,
					'KONDISI_PENGADAAN_BARIS_1' => $data->KONDISI_PENGADAAN_BARIS_1,
					'KONDISI_PENGADAAN_BARIS_2' => $data->KONDISI_PENGADAAN_BARIS_2,
					'KONDISI_PENGADAAN_BARIS_3' => $data->KONDISI_PENGADAAN_BARIS_3,
					'KONDISI_PENGADAAN_BARIS_4' => $data->KONDISI_PENGADAAN_BARIS_4,
					'KONDISI_PENGADAAN_BARIS_5' => $data->KONDISI_PENGADAAN_BARIS_5,
					'KONDISI_PENGADAAN_BARIS_6' => $data->KONDISI_PENGADAAN_BARIS_6,
					'KONDISI_PENGADAAN_BARIS_7' => $data->KONDISI_PENGADAAN_BARIS_7,
					'KONDISI_PENGADAAN_BARIS_8' => $data->KONDISI_PENGADAAN_BARIS_8,
					'REFERENSI_DOKUMEN_SPH' => $data->REFERENSI_DOKUMEN_SPH,
					'REFERENSI_DOKUMEN_KONTRAK' => $data->REFERENSI_DOKUMEN_KONTRAK,
					'TANGGAL_MULAI_PAKAI_HARI_PF' => $data->TANGGAL_MULAI_PAKAI_HARI_PF,
					'TANGGAL_SELESAI_PAKAI_HARI_PF' => $data->TANGGAL_SELESAI_PAKAI_HARI_PF,
					'TANGGAL_MULAI_PAKAI_HARI' => $data->TANGGAL_MULAI_PAKAI_HARI,
					'TANGGAL_SELESAI_PAKAI_HARI' => $data->TANGGAL_SELESAI_PAKAI_HARI,
					'BARIS_KOSONG' => $data->BARIS_KOSONG,
					'TANDA_TANGAN_1' => $data->TANDA_TANGAN_1,
					'TANDA_TANGAN_2' => $data->TANDA_TANGAN_2
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_id_po_by_HASH_MD5_PO($HASH_MD5_PO)
	{
		$hsl = $this->db->query("SELECT ID_PO FROM po WHERE HASH_MD5_PO ='$HASH_MD5_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PO' => $data->ID_PO,
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA";
		}
		return $hasil;
	}

	function get_list_po_by_id_sppb($ID_SPPB)
	{
		$hsl = $this->db->query("SELECT * FROM po WHERE ID_SPPB ='$ID_SPPB'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}


	function get_list_po_by_id_spp($ID_SPP)
	{
		$hsl = $this->db->query("SELECT HASH_MD5_PO, NO_URUT_PO, STATUS_PO, JENIS_PENGADAAN, DATE_FORMAT(TANGGAL_DOKUMEN_PO, '%d/%m/%Y') AS TANGGAL_DOKUMEN_PO, ID_PO FROM po WHERE ID_SPP ='$ID_SPP'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_list_fstb_by_id_po($ID_PO)
	{
		$hsl = $this->db->query("SELECT * FROM fstb WHERE ID_PO ='$ID_PO'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_STAFF_PROC($HASH_MD5_PO)
	{
		$hsl = $this->db->query("SELECT ID_PO, CTT_STAFF_PROC FROM po WHERE HASH_MD5_PO ='$HASH_MD5_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_STAFF_PROC' => $data->CTT_STAFF_PROC,
					'ID_PO' => $data->ID_PO
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_KASIE($HASH_MD5_PO)
	{
		$hsl = $this->db->query("SELECT ID_PO, CTT_KASIE FROM po WHERE HASH_MD5_PO ='$HASH_MD5_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_KASIE' => $data->CTT_KASIE,
					'ID_PO' => $data->ID_PO
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_MANAGER_PROC($HASH_MD5_PO)
	{
		$hsl = $this->db->query("SELECT ID_PO, CTT_MANAGER_PROC FROM po WHERE HASH_MD5_PO ='$HASH_MD5_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_MANAGER_PROC' => $data->CTT_MANAGER_PROC,
					'ID_PO' => $data->ID_PO
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_STAFF_PROC_SP($HASH_MD5_PO)
	{
		$hsl = $this->db->query("SELECT ID_PO, CTT_STAFF_PROC_SP FROM po WHERE HASH_MD5_PO ='$HASH_MD5_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_STAFF_PROC_SP' => $data->CTT_STAFF_PROC_SP,
					'ID_PO' => $data->ID_PO
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_SUPERVISI_PROC_SP($HASH_MD5_PO)
	{
		$hsl = $this->db->query("SELECT ID_PO, CTT_SUPERVISI_PROC_SP FROM po WHERE HASH_MD5_PO ='$HASH_MD5_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_SUPERVISI_PROC_SP' => $data->CTT_SUPERVISI_PROC_SP,
					'ID_PO' => $data->ID_PO
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function cek_nomor_urut_po($NO_URUT_PO)
	{
		$hsl = $this->db->query("SELECT ID_PO, HASH_MD5_PO, NO_URUT_PO FROM po WHERE NO_URUT_PO ='$NO_URUT_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PO' => $data->ID_PO,
					'HASH_MD5_PO' => $data->HASH_MD5_PO,
					'NO_URUT_PO' => $data->NO_URUT_PO
				);
			}
			return $hasil;
		} else {
			return 'DATA BELUM ADA';
		}
	}

	//FUNGSI: Fungsi ini untuk menambahkan data PO
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller PO_form / function simpan_data_dari_barang_master
	//         2. 
	function simpan_data_po(
		$ID_SPP,
		$ID_SPPB,
		$ID_PROYEK,
		$ID_PROYEK_SUB_PEKERJAAN,
		$ID_VENDOR,
		$JENIS_PENGADAAN,
		$JUMLAH_COUNT_PO,
		$NO_URUT_PO,
		$CREATE_BY_USER,
		$PROGRESS_PO,
		$STATUS_PO,
		$TANGGAL_DOKUMEN_PO,
		$TANGGAL_PEMBUATAN_PO_JAM,
		$TANGGAL_PEMBUATAN_PO_HARI,
		$TANGGAL_PEMBUATAN_PO_BULAN,
		$TANGGAL_PEMBUATAN_PO_TAHUN
	) {
		$hasil = $this->db->query(
			"INSERT INTO po
			(
				ID_SPP,
				ID_SPPB,
				ID_PROYEK,
				ID_PROYEK_SUB_PEKERJAAN,
				ID_VENDOR,
				JENIS_PENGADAAN,
				JUMLAH_COUNT,
				NO_URUT_PO,
				CREATE_BY_USER,
				PROGRESS_PO,
				STATUS_PO,
				TANGGAL_DOKUMEN_PO,
				TANGGAL_PEMBUATAN_PO_JAM,
                TANGGAL_PEMBUATAN_PO_HARI,
                TANGGAL_PEMBUATAN_PO_BULAN,
                TANGGAL_PEMBUATAN_PO_TAHUN
			)
			VALUES
			(
				'$ID_SPP',
				'$ID_SPPB',
				'$ID_PROYEK',
				'$ID_PROYEK_SUB_PEKERJAAN',
				'$ID_VENDOR',
				'$JENIS_PENGADAAN',
				'$JUMLAH_COUNT_PO',
				'$NO_URUT_PO',
				'$CREATE_BY_USER',
				'$PROGRESS_PO',
				'$STATUS_PO',
				'$TANGGAL_DOKUMEN_PO',
				'$TANGGAL_PEMBUATAN_PO_JAM',
            	'$TANGGAL_PEMBUATAN_PO_HARI',
                '$TANGGAL_PEMBUATAN_PO_BULAN',
                '$TANGGAL_PEMBUATAN_PO_TAHUN'
				
			)"
		);

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengeset HASH_MD5_SPPB berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function set_md5_id_PO($ID_PROYEK, $ID_SPP, $ID_SPPB, $NO_URUT_PO, $CREATE_BY_USER,$ID_PROYEK_SUB_PEKERJAAN, $ID_VENDOR, $JENIS_PENGADAAN, $KLASIFIKASI_BARANG)
	{
		$hsl = $this->db->query("SELECT ID_PO FROM po WHERE ID_PROYEK='$ID_PROYEK' AND ID_SPP='$ID_SPP' AND ID_SPPB='$ID_SPPB' AND NO_URUT_PO='$NO_URUT_PO' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PO' => $data->ID_PO
				);
			}
		} else {
			$hasil = "BELUM ADA PO";
		}
		$ID_PO = $hasil['ID_PO'];
		$HASH_MD5_PO = md5($ID_PO);
		$hasil = $this->db->query("UPDATE po SET HASH_MD5_PO='$HASH_MD5_PO' WHERE ID_PO='$ID_PO'");

		if($KLASIFIKASI_BARANG == "SEMUA")
		{
			$hsl_2 = $this->db->query("SELECT SPF.ID_SPP, SPF.ID_SPP_FORM, SPF.ID_PROYEK_SUB_PEKERJAAN, SPF.ID_SPPB_FORM, SPF.ID_SPPB, SPF.ID_RASD_FORM, SPF.ID_FPB_FORM, SPF.ID_BARANG_MASTER, SPF.SATUAN_BARANG, SPF.ID_JENIS_BARANG, SPF.ID_KLASIFIKASI_BARANG, SPF.NAMA_BARANG, SPF.MEREK, SPF.SPESIFIKASI_SINGKAT, SPF.JUMLAH_BARANG, SPF.HARGA_SATUAN_BARANG_FIX, SPF.HARGA_TOTAL_FIX, FPBF.ID_FPB, SPF.ID_VENDOR_FIX, SPF.JENIS_PENGADAAN, KB.NAMA_KLASIFIKASI_BARANG, KB.KODE_KLASIFIKASI_BARANG, SPF.TANGGAL_MULAI_PAKAI_HARI, SPF.TANGGAL_SELESAI_PAKAI_HARI
			FROM spp_form AS SPF
			LEFT JOIN sppb_form AS SF ON SPF.ID_SPPB_FORM = SF.ID_SPPB_FORM
			LEFT JOIN fpb_form AS FPBF ON SF.ID_FPB_FORM = FPBF.ID_FPB_FORM
			LEFT JOIN klasifikasi_barang AS KB ON SPF.ID_KLASIFIKASI_BARANG = KB.ID_KLASIFIKASI_BARANG
			WHERE SPF.ID_SPP = '$ID_SPP' AND SPF.ID_VENDOR_FIX = '$ID_VENDOR' AND SPF.JENIS_PENGADAAN = '$JENIS_PENGADAAN'");
			if ($hsl_2->num_rows() > 0) {
				foreach ($hsl_2->result() as $data) {
					$hasil_2 = array(
						'ID_SPP_FORM' => $data->ID_SPP_FORM,
						'ID_SPP' => $data->ID_SPP,
						'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
						'ID_SPPB' => $data->ID_SPPB,
						'ID_FPB_FORM' => $data->ID_FPB_FORM,
						'ID_FPB' => $data->ID_FPB,
						'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
						'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
						'SATUAN_BARANG' => $data->SATUAN_BARANG,
						'JENIS_PENGADAAN' => $data->JENIS_PENGADAAN,
						'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
						'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
						'NAMA_KLASIFIKASI_BARANG' => $data->NAMA_KLASIFIKASI_BARANG,
						'KODE_KLASIFIKASI_BARANG' => $data->KODE_KLASIFIKASI_BARANG,
						'NAMA_BARANG' => $data->NAMA_BARANG,
						'MEREK' => $data->MEREK,
						'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
						'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
						'HARGA_SATUAN_BARANG_FIX' => $data->HARGA_SATUAN_BARANG_FIX,
						'HARGA_TOTAL_FIX' => $data->HARGA_TOTAL_FIX,
						'TANGGAL_MULAI_PAKAI_HARI' => $data->TANGGAL_MULAI_PAKAI_HARI,
						'TANGGAL_SELESAI_PAKAI_HARI' => $data->TANGGAL_SELESAI_PAKAI_HARI
					);

					$this->db->query(
						"INSERT INTO po_form (
							ID_PO, ID_SPPB_FORM, ID_SPPB, ID_SPP, ID_SPP_FORM, ID_PROYEK_SUB_PEKERJAAN, ID_BARANG_MASTER, ID_FPB, ID_FPB_FORM, SATUAN_BARANG, ID_KLASIFIKASI_BARANG, NAMA_BARANG, MEREK, SPESIFIKASI_SINGKAT, JUMLAH_BARANG, HARGA_SATUAN_BARANG_FIX, HARGA_TOTAL_FIX, TANGGAL_MULAI_PAKAI_HARI, TANGGAL_SELESAI_PAKAI_HARI )
						VALUES ('$ID_PO', '$data->ID_SPPB_FORM', '$data->ID_SPPB', '$data->ID_SPP', '$data->ID_SPP_FORM', '$data->ID_PROYEK_SUB_PEKERJAAN', '$data->ID_BARANG_MASTER', '$data->ID_FPB', '$data->ID_FPB_FORM', '$data->SATUAN_BARANG', '$data->ID_KLASIFIKASI_BARANG', '$data->NAMA_BARANG', '$data->MEREK' , '$data->SPESIFIKASI_SINGKAT', '$data->JUMLAH_BARANG' , '$data->HARGA_SATUAN_BARANG_FIX', '$data->HARGA_TOTAL_FIX', '$data->TANGGAL_MULAI_PAKAI_HARI', '$data->TANGGAL_SELESAI_PAKAI_HARI')"
					);

					// $this->db->query(
					// 	"UPDATE fpb_form SET 
					// 	STATUS_PO='Dalam Proses PO', KET_PO='$ID_PO'
					// 	WHERE ID_FPB_FORM='$data->ID_FPB_FORM'"
					// );

					// $this->db->query("UPDATE po SET ID_SPPB='$data->ID_SPPB' WHERE ID_PO='$ID_PO'");
				}
			}
		
		}
		else
		{
			$hsl_2 = $this->db->query("SELECT SPF.ID_SPP, SPF.ID_SPP_FORM, SPF.ID_PROYEK_SUB_PEKERJAAN, SPF.ID_SPPB_FORM, SPF.ID_SPPB, SPF.ID_RASD_FORM, SPF.ID_FPB_FORM, SPF.ID_BARANG_MASTER, SPF.SATUAN_BARANG, SPF.ID_JENIS_BARANG, SPF.ID_KLASIFIKASI_BARANG, SPF.NAMA_BARANG, SPF.MEREK, SPF.SPESIFIKASI_SINGKAT, SPF.JUMLAH_BARANG, SPF.HARGA_SATUAN_BARANG_FIX, SPF.HARGA_TOTAL_FIX, FPBF.ID_FPB, SPF.ID_VENDOR_FIX, SPF.JENIS_PENGADAAN, KB.NAMA_KLASIFIKASI_BARANG, KB.KODE_KLASIFIKASI_BARANG, SPF.TANGGAL_MULAI_PAKAI_HARI, SPF.TANGGAL_SELESAI_PAKAI_HARI
			FROM spp_form AS SPF
			LEFT JOIN sppb_form AS SF ON SPF.ID_SPPB_FORM = SF.ID_SPPB_FORM
			LEFT JOIN fpb_form AS FPBF ON SF.ID_FPB_FORM = FPBF.ID_FPB_FORM
			LEFT JOIN klasifikasi_barang AS KB ON SPF.ID_KLASIFIKASI_BARANG = KB.ID_KLASIFIKASI_BARANG
			WHERE SPF.ID_SPP = '$ID_SPP' AND SPF.ID_VENDOR_FIX = '$ID_VENDOR' AND SPF.JENIS_PENGADAAN = '$JENIS_PENGADAAN' AND  SPF.ID_KLASIFIKASI_BARANG = '$KLASIFIKASI_BARANG' ");
			if ($hsl_2->num_rows() > 0) {
				foreach ($hsl_2->result() as $data) {
					$hasil_2 = array(
						'ID_SPP_FORM' => $data->ID_SPP_FORM,
						'ID_SPP' => $data->ID_SPP,
						'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
						'ID_SPPB' => $data->ID_SPPB,
						'ID_FPB_FORM' => $data->ID_FPB_FORM,
						'ID_FPB' => $data->ID_FPB,
						'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
						'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
						'SATUAN_BARANG' => $data->SATUAN_BARANG,
						'JENIS_PENGADAAN' => $data->JENIS_PENGADAAN,
						'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
						'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
						'NAMA_KLASIFIKASI_BARANG' => $data->NAMA_KLASIFIKASI_BARANG,
						'KODE_KLASIFIKASI_BARANG' => $data->KODE_KLASIFIKASI_BARANG,
						'NAMA_BARANG' => $data->NAMA_BARANG,
						'MEREK' => $data->MEREK,
						'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
						'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
						'HARGA_SATUAN_BARANG_FIX' => $data->HARGA_SATUAN_BARANG_FIX,
						'HARGA_TOTAL_FIX' => $data->HARGA_TOTAL_FIX,
						'TANGGAL_MULAI_PAKAI_HARI' => $data->TANGGAL_MULAI_PAKAI_HARI,
						'TANGGAL_SELESAI_PAKAI_HARI' => $data->TANGGAL_SELESAI_PAKAI_HARI
					);

					$this->db->query(
						"INSERT INTO po_form (
							ID_PO, ID_SPPB_FORM, ID_SPPB, ID_SPP, ID_SPP_FORM, ID_PROYEK_SUB_PEKERJAAN, ID_BARANG_MASTER, ID_FPB, ID_FPB_FORM, SATUAN_BARANG, ID_KLASIFIKASI_BARANG, NAMA_BARANG, MEREK, SPESIFIKASI_SINGKAT, JUMLAH_BARANG, HARGA_SATUAN_BARANG_FIX, HARGA_TOTAL_FIX, TANGGAL_MULAI_PAKAI_HARI, TANGGAL_SELESAI_PAKAI_HARI )
						VALUES ('$ID_PO', '$data->ID_SPPB_FORM', '$data->ID_SPPB', '$data->ID_SPP', '$data->ID_SPP_FORM', '$data->ID_PROYEK_SUB_PEKERJAAN', '$data->ID_BARANG_MASTER', '$data->ID_FPB', '$data->ID_FPB_FORM', '$data->SATUAN_BARANG', '$data->ID_KLASIFIKASI_BARANG', '$data->NAMA_BARANG', '$data->MEREK' , '$data->SPESIFIKASI_SINGKAT', '$data->JUMLAH_BARANG' , '$data->HARGA_SATUAN_BARANG_FIX', '$data->HARGA_TOTAL_FIX', '$data->TANGGAL_MULAI_PAKAI_HARI', '$data->TANGGAL_SELESAI_PAKAI_HARI')"
					);

					// $this->db->query(
					// 	"UPDATE fpb_form SET 
					// 	STATUS_PO='Dalam Proses PO', KET_PO='$ID_PO'
					// 	WHERE ID_FPB_FORM='$data->ID_FPB_FORM'"
					// );

					// $this->db->query("UPDATE po SET ID_SPPB='$data->ID_SPPB' WHERE ID_PO='$ID_PO'");
				}
			}

		}

		

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut sppb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut_by_id_proyek
	//         2. 
	function get_data_proyek_by_hash_md5_sppb($HASH_MD5_SPPB)
	{
		$hsl = $this->db->query("SELECT S.ID_PROYEK, S.NO_URUT_SPPB, S.ID_SPPB, P.NAMA_PROYEK, P.LOKASI, P.INISIAL from sppb as S 
		LEFT JOIN proyek AS P ON S.ID_PROYEK = P.ID_PROYEK
		WHERE S.HASH_MD5_SPPB = '$HASH_MD5_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
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

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut sppb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut_by_id_proyek
	//         2. 
	function get_data_proyek_by_hash_md5_spp($HASH_MD5_SPP)
	{
		$hsl = $this->db->query("SELECT SPP.ID_PROYEK, SPP.HASH_MD5_SPP, SPP.ID_PROYEK_SUB_PEKERJAAN, PSP.NAMA_SUB_PEKERJAAN, SPP.NO_URUT_SPP, SPP.ID_SPPB, SPP.ID_SPP, P.NAMA_PROYEK, P.LOKASI, P.INISIAL, P.NAMA_PROYEK, SPB.NO_URUT_SPPB from spp as SPP 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = SPP.ID_PROYEK
        LEFT JOIN sppb AS SPB ON SPB.ID_SPPB = SPP.ID_SPPB
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON SPP.ID_PROYEK_SUB_PEKERJAAN = PSP.ID_PROYEK_SUB_PEKERJAAN
		WHERE SPP.HASH_MD5_SPP = '$HASH_MD5_SPP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'SUB_PROYEK' => $data->NAMA_SUB_PEKERJAAN,
					'LOKASI' => $data->LOKASI,
					'INISIAL' => $data->INISIAL,
					'NO_URUT_SPP' => $data->NO_URUT_SPP,
					'NO_URUT_SPPB' => $data->NO_URUT_SPPB,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_SPP' => $data->ID_SPP,
					'HASH_MD5_SPP' => $data->HASH_MD5_SPP,
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data PO berdasarkan yang baru diinput
	//SUMBER TABEL: tabel PO
	//DIPAKAI: 1. controller PO / function get_data_po_baru
	//         2. 
	function get_data_po_baru($ID_PROYEK, $NO_URUT_PO, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT * FROM po WHERE ID_PROYEK = '$ID_PROYEK' AND
		NO_URUT_PO = '$NO_URUT_PO' AND
		CREATE_BY_USER = '$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_PO' => $data->HASH_MD5_PO
				);
			}
		} else {
			$hasil = "BELUM ADA PO";
		}
		return $hasil;
	}



	//FUNGSI: Fungsi ini untuk menampilkan data PO berdasarkan ID_PO
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller PO_form / function index

	function po_list_by_id_po($ID_PO)
	{
		$hasil = $this->db->query("SELECT * FROM po WHERE ID_PO = '$ID_PO'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data po form berdasarkan ID_PO_FORM
	//SUMBER TABEL: tabel po
	//DIPAKAI: 1. controller PO_form / function simpan_identitas_form
	//         
	function simpan_identitas_form($ID_PO,
		$NO_URUT_PO,
		$TANGGAL_DOKUMEN_PO,
		$LOKASI_PENYERAHAN, 
		$TERM_OF_PAYMENT, 
		$CTT_KEPERLUAN, 
		$CTT_KEPERLUAN_BARIS_2,
		$REFERENSI_DOKUMEN_SPH,
		$REFERENSI_DOKUMEN_KONTRAK,
		$TANGGAL_KIRIM_BARANG_HARI, 
		$TANGGAL_MULAI_PAKAI_HARI,
		$TANGGAL_SELESAI_PAKAI_HARI,
		$BATAS_AKHIR,
		$KONDISI_PENGADAAN_BARIS_1,
		$KONDISI_PENGADAAN_BARIS_2,
		$KONDISI_PENGADAAN_BARIS_3,
		$KONDISI_PENGADAAN_BARIS_4,
		$KONDISI_PENGADAAN_BARIS_5,
		$KONDISI_PENGADAAN_BARIS_6,
		$KONDISI_PENGADAAN_BARIS_7,
		$KONDISI_PENGADAAN_BARIS_8,
		$BARIS_KOSONG,
		$TANDA_TANGAN_1,
		$TANDA_TANGAN_2
	)
	{
		$hasil = $this->db->query("UPDATE po SET
			NO_URUT_PO='$NO_URUT_PO',
			TANGGAL_DOKUMEN_PO='$TANGGAL_DOKUMEN_PO',
			LOKASI_PENYERAHAN='$LOKASI_PENYERAHAN',
			TERM_OF_PAYMENT='$TERM_OF_PAYMENT',
			CTT_KEPERLUAN='$CTT_KEPERLUAN',
			CTT_KEPERLUAN_BARIS_2='$CTT_KEPERLUAN_BARIS_2',
			REFERENSI_DOKUMEN_SPH='$REFERENSI_DOKUMEN_SPH',
			REFERENSI_DOKUMEN_KONTRAK='$REFERENSI_DOKUMEN_KONTRAK',
			TANGGAL_KIRIM_BARANG_HARI='$TANGGAL_KIRIM_BARANG_HARI',
			TANGGAL_MULAI_PAKAI_HARI='$TANGGAL_MULAI_PAKAI_HARI',
			TANGGAL_SELESAI_PAKAI_HARI='$TANGGAL_SELESAI_PAKAI_HARI',
			BATAS_AKHIR='$BATAS_AKHIR',
			KONDISI_PENGADAAN_BARIS_1='$KONDISI_PENGADAAN_BARIS_1',
			KONDISI_PENGADAAN_BARIS_2='$KONDISI_PENGADAAN_BARIS_2',
			KONDISI_PENGADAAN_BARIS_3='$KONDISI_PENGADAAN_BARIS_3',
			KONDISI_PENGADAAN_BARIS_4='$KONDISI_PENGADAAN_BARIS_4',
			KONDISI_PENGADAAN_BARIS_5='$KONDISI_PENGADAAN_BARIS_5',
			KONDISI_PENGADAAN_BARIS_6='$KONDISI_PENGADAAN_BARIS_6',
			KONDISI_PENGADAAN_BARIS_7='$KONDISI_PENGADAAN_BARIS_7',
			KONDISI_PENGADAAN_BARIS_8='$KONDISI_PENGADAAN_BARIS_8',
			BARIS_KOSONG='$BARIS_KOSONG',
			TANDA_TANGAN_1='$TANDA_TANGAN_1',
			TANDA_TANGAN_2='$TANDA_TANGAN_2'
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function update_progress_po($HASH_MD5_PO, $PROGRESS_PO, $STATUS_PO)
	{
		$hasil = $this->db->query("UPDATE po SET 
			PROGRESS_PO='$PROGRESS_PO'
			STATUS_PO='$STATUS_PO'
			WHERE HASH_MD5_PO='$HASH_MD5_PO'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb berdasarkan ID_USER
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function logout
	//         2. controller SPPB / function user_log
	function user_log_po($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_po (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
