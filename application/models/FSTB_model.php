<?php
class FSTB_model extends CI_Model
{

	// function FSTB_list()
	// {
	// 	$hasil = $this->db->query("SELECT *
	// 	FROM FSTB AS S 
	// 	LEFT JOIN rasd AS R ON R.ID_RASD = S.ID_RASD 
	// 	LEFT JOIN proyek AS P ON P.ID_PROYEK = R.ID_PROYEK");
	// 	return $hasil->result();
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function data_FSTB
	//         2. 
	// function fstb_list_by_ID_PROYEK_USER_ID($ID_PROYEK, $USER_ID)
	// {
	// 	$hasil = $this->db->query("SELECT * FROM fstb WHERE ID_PROYEK = '$ID_PROYEK' AND CREATE_BY_USER = '$USER_ID'");
	// 	return $hasil->result();
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel pegawai
	//DIPAKAI: 1. controller FSTB / function data_FSTB
	//         2. 
	// function fstb_list_by_ID_PROYEK($ID_PROYEK, $USER_ID)
	// {
	// 	$hasil = $this->db->query("SELECT F.NO_URUT_FSTB, F.TANGGAL_PENGAJUAN_FSTB, V.NAMA_VENDOR, F.NAMA_PENGIRIM, F.HASH_MD5_FSTB, P.NO_URUT_PO, F.ID_SURAT_JALAN, F.NO_HP_PENGIRIM, F.TANGGAL_BARANG_DATANG_HARI, F.STATUS_FSTB, F.PROGRESS_FSTB, PE.NAMA, SJ.NO_SURAT_JALAN
	// 	FROM fstb AS F
    //     LEFT JOIN vendor AS V ON V.ID_VENDOR = F.ID_VENDOR
    //     LEFT JOIN po AS P ON p.ID_PO = F.ID_PO
    //     LEFT JOIN pegawai AS PE ON PE.ID_PEGAWAI = F.ID_PEGAWAI
	// 	LEFT JOIN surat_jalan AS SJ ON SJ.ID_SURAT_JALAN = F.ID_SURAT_JALAN
	// 	WHERE F.ID_PROYEK = '$ID_PROYEK' AND F.CREATE_BY_USER = '$USER_ID'");
	// 	return $hasil->result();
	// }

	// function fstb_list_by_kantor_pusat()
	// {
	// 	$hasil = $this->db->query("SELECT F.NO_URUT_FSTB, F.TANGGAL_PENGAJUAN_FSTB, V.NAMA_VENDOR, F.NAMA_PENGIRIM, F.HASH_MD5_FSTB, P.NO_URUT_PO, F.ID_SURAT_JALAN, F.NO_HP_PENGIRIM, F.TANGGAL_BARANG_DATANG_HARI, F.STATUS_FSTB, F.PROGRESS_FSTB, PE.NAMA, SJ.NO_SURAT_JALAN
	// 	FROM fstb AS F
    //     LEFT JOIN vendor AS V ON V.ID_VENDOR = F.ID_VENDOR
    //     LEFT JOIN po AS P ON p.ID_PO = F.ID_PO
    //     LEFT JOIN pegawai AS PE ON PE.ID_PEGAWAI = F.ID_PEGAWAI
	// 	LEFT JOIN surat_jalan AS SJ ON SJ.ID_SURAT_JALAN = F.ID_SURAT_JALAN
	// 	");
	// 	return $hasil->result();
	// }

	// function po_list_fstb()
	// {
	// 	$hasil = $this->db->query("SELECT PO.ID_PO, PO.NO_URUT_PO, P.NAMA_PROYEK, DATE_FORMAT(PO.TANGGAL_DOKUMEN_PO, '%d/%m/%Y') AS TANGGAL_DOKUMEN_PO, DATE_FORMAT(PO.TANGGAL_PEMBUATAN_PO_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_PO_HARI, PO.HASH_MD5_PO, PSP.NAMA_SUB_PEKERJAAN from PO AS PO 
	// 	LEFT JOIN proyek AS P on P.ID_PROYEK = PO.ID_PROYEK
	// 	LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = PO.ID_PROYEK_SUB_PEKERJAAN");
	// 	return $hasil->result();
	// }

	function list_FISTB_by_all_proyek()//092023
	{
		$hasil = $this->db->query("SELECT FSTB.HASH_MD5_FSTB, FSTB.NO_URUT_FSTB, FSTB.STATUS_FSTB, DATE_FORMAT(FSTB.TANGGAL_DOKUMEN_FSTB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_FSTB, P.NAMA_PROYEK, PSP.NAMA_SUB_PEKERJAAN, SPB.ID_SPPB, SPB.HASH_MD5_SPPB FROM FSTB AS FSTB
		LEFT JOIN sppb AS SPB on SPB.ID_SPPB = FSTB.ID_SPPB
		LEFT JOIN proyek AS P on P.ID_PROYEK = FSTB.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = FSTB.ID_PROYEK_SUB_PEKERJAAN ");
		return $hasil->result();
	}

	function sppb_list_by_id_sppb($ID_SPPB) //092023
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.HASH_MD5_SPPB, S.SUB_PROYEK, PSP.ID_PROYEK_SUB_PEKERJAAN, PSP.NAMA_SUB_PEKERJAAN, P.NAMA_PROYEK, P.HASH_MD5_PROYEK, DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB,S.NO_URUT_SPPB,S.TANGGAL_PEMBUATAN_SPPB_JAM,DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN,S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB,S.PROGRESS_SPPB,S.STATUS_SPPB, S.CTT_DEPT_PROC
		FROM sppb AS S 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
        LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = S.ID_PROYEK_SUB_PEKERJAAN
        WHERE S.ID_SPPB =  '$ID_SPPB' ORDER BY S.NO_URUT_SPPB DESC");
		return $hasil;
	}

	function spp_list_by_id_spp($ID_SPP) //092023
	{
		$hasil = $this->db->query("SELECT SP.ID_SPP, SP.HASH_MD5_SPP, SP.NO_URUT_SPP, SP.PROGRESS_SPP, SP.STATUS_SPP, SP.TANGGAL_PEMBUATAN_SPP_JAM, SP.TANGGAL_PEMBUATAN_SPP_HARI, SP.TANGGAL_PEMBUATAN_SPP_BULAN, SP.TANGGAL_PEMBUATAN_SPP_TAHUN, P.NAMA_PROYEK
		FROM spp AS SP
		LEFT JOIN proyek AS P ON P.ID_PROYEK = SP.ID_PROYEK
		WHERE SP.ID_SPP = '$ID_SPP'");
		return $hasil;
	}
 
	function po_list_by_id_po($ID_PO) //092023
	{

		$hasil = $this->db->query("SELECT ID_PO, NO_URUT_PO, ID_SPP, ID_SPPB, ID_PROYEK, LOKASI_PENYERAHAN, TERM_OF_PAYMENT, ID_VENDOR, DATE_FORMAT(TANGGAL_DOKUMEN_PO, '%d/%m/%Y') AS TANGGAL_DOKUMEN_PO, TANGGAL_DOKUMEN_PO AS TANGGAL_DOKUMEN_PO_INDO, TANGGAL_KIRIM_BARANG_HARI, TANGGAL_MULAI_PAKAI_HARI, TANGGAL_SELESAI_PAKAI_HARI, CTT_KEPERLUAN, CTT_KEPERLUAN_BARIS_2, REFERENSI_DOKUMEN_SPH, REFERENSI_DOKUMEN_KONTRAK, NOMINAL_DISKON, BARIS_KOSONG, TANGGAL_PEMBUATAN_PO_HARI, HASH_MD5_PO, JENIS_PENGADAAN, KONDISI_PENGADAAN_BARIS_1, KONDISI_PENGADAAN_BARIS_2, KONDISI_PENGADAAN_BARIS_3, KONDISI_PENGADAAN_BARIS_4, KONDISI_PENGADAAN_BARIS_5, KONDISI_PENGADAAN_BARIS_6, KONDISI_PENGADAAN_BARIS_7, KONDISI_PENGADAAN_BARIS_8, TANDA_TANGAN_1, TANDA_TANGAN_2  from po WHERE ( ID_PO = '$ID_PO')");
		return $hasil;
	}

	// function po_list_fstb_by_id_proyek($ID_PROYEK)
	// {
	// 	$hasil = $this->db->query("SELECT PO.ID_PO, PO.NO_URUT_PO, P.NAMA_PROYEK, PO.TANGGAL_DOKUMEN_PO, PO.HASH_MD5_PO, PSP.NAMA_SUB_PEKERJAAN from po AS PO 
	// 	LEFT JOIN proyek AS P on P.ID_PROYEK = PO.ID_PROYEK 
	// 	LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = PO.ID_PROYEK_SUB_PEKERJAAN
	// 	WHERE PO.ID_PROYEK = '$ID_PROYEK'");
	// 	return $hasil->result();
	// }

	function list_FSTB_by_id_proyek($ID_PROYEK)//092023
	{
		$hasil = $this->db->query("SELECT FSTB.HASH_MD5_FSTB, FSTB.NO_URUT_FSTB, FSTB.STATUS_FSTB, DATE_FORMAT(FSTB.TANGGAL_DOKUMEN_FSTB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_FSTB, P.NAMA_PROYEK, PSP.NAMA_SUB_PEKERJAAN, SPB.ID_SPPB, SPB.HASH_MD5_SPPB FROM FSTB AS FSTB
		LEFT JOIN sppb AS SPB on SPB.ID_SPPB = FSTB.ID_SPPB
		LEFT JOIN proyek AS P on P.ID_PROYEK = FSTB.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = FSTB.ID_PROYEK_SUB_PEKERJAAN
		WHERE FSTB.ID_PROYEK = '$ID_PROYEK'");
		return $hasil->result();
	}

	function cek_nomor_urut_fstb($NO_URUT_FSTB) //092023
	{
		$hsl = $this->db->query("SELECT ID_FSTB, HASH_MD5_FSTB, NO_URUT_FSTB FROM FSTB WHERE NO_URUT_FSTB ='$NO_URUT_FSTB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FSTB' => $data->ID_FSTB,
					'HASH_MD5_FSTB' => $data->HASH_MD5_FSTB,
					'NO_URUT_FSTB' => $data->NO_URUT_FSTB
				);
			}
			return $hasil;
		} else {
			return 'DATA BELUM ADA';
		}
	}

	// function get_list_fstb_by_id_po($ID_PO)
	// {
	// 	$hsl = $this->db->query("SELECT HASH_MD5_FSTB, NO_URUT_FSTB, STATUS_FSTB, DATE_FORMAT(TANGGAL_DOKUMEN_FSTB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_FSTB, ID_FSTB FROM fstb WHERE ID_PO ='$ID_PO'");
	// 	if ($hsl->num_rows() > 0) {
	// 		return $hsl->result();
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB_form / function index
	//         2. controller FSTB_form / function view
	//         2. controller FSTB_form / function cetak_pdf
	function fstb_list_by_id_fstb($ID_FSTB) //092023
	{
		$hasil = $this->db->query("SELECT 
		FSTB.HASH_MD5_FSTB, 
		FSTB.ID_PO,
        FSTB.ID_SPP,
        FSTB.ID_SPPB,
        FSTB.ID_VENDOR,
        FSTB.NAMA_PEGAWAI,
        FSTB.ID_PROYEK,
		FSTB.ID_PROYEK_SUB_PEKERJAAN,
        FSTB.NO_URUT_FSTB,
        FSTB.NO_URUT_FIB,
        FSTB.ID_SURAT_JALAN,
        FSTB.SUMBER_PENERIMAAN,
		FSTB.LOKASI_PENYERAHAN,
        FSTB.NAMA_PENGIRIM,
        FSTB.NO_HP_PENGIRIM,
        FSTB.DOK_SURAT_JALAN,
        FSTB.COUNT_FSTB,
        FSTB.TANGGAL_BARANG_DATANG_JAM,
		DATE_FORMAT(FSTB.TANGGAL_BARANG_DATANG_HARI, '%d/%m/%Y') AS TANGGAL_BARANG_DATANG_HARI,
		FSTB.TANGGAL_BARANG_DATANG_HARI AS TANGGAL_BARANG_DATANG_HARI_INDO,
        FSTB.TANGGAL_BARANG_DATANG_BULAN,
        FSTB.TANGGAL_BARANG_DATANG_TAHUN,
        FSTB.FILE_NAME_TEMP,
        FSTB.FILE_NAME_TEMP_FIB,
        FSTB.CTT_STAFF_LOG,
        FSTB.CREATE_BY_USER,
        FSTB.STATUS_FSTB,
        FSTB.PROGRESS_FSTB,
        DATE_FORMAT(FSTB.TANGGAL_DOKUMEN_FSTB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_FSTB,
		FSTB.TANGGAL_DOKUMEN_FSTB AS TANGGAL_DOKUMEN_FSTB_INDO,
		FSTB.TANGGAL_PEMBUATAN_FSTB_HARI,
		FSTB.NOMOR_SURAT_JALAN_VENDOR,
		PO.NO_URUT_PO,
		SJ.NO_SURAT_JALAN,
		P.NAMA_PROYEK,
        V.NAMA_VENDOR,
		SPPB.NO_URUT_SPPB,
		SPP.NO_URUT_SPP
        FROM fstb AS FSTB
        LEFT JOIN vendor AS V ON FSTB.ID_VENDOR = V.ID_VENDOR
		LEFT JOIN SPPB AS SPPB ON SPPB.ID_SPPB = FSTB.ID_SPPB
		LEFT JOIN SPP AS SPP ON SPP.ID_SPP = FSTB.ID_SPP
		LEFT JOIN po AS PO ON PO.ID_PO = FSTB.ID_PO
		LEFT JOIN surat_jalan AS SJ ON SJ.ID_SURAT_JALAN = FSTB.ID_SURAT_JALAN
		LEFT JOIN proyek AS P ON P.ID_PROYEK = FSTB.ID_PROYEK
        WHERE FSTB.ID_FSTB = '$ID_FSTB'");
		return $hasil;
	}

	function qty_fstb_form_by_id_fstb($ID_FSTB) //092023
	{
		$hasil = $this->db->query("SELECT COUNT(ID_FSTB) AS JUMLAH_BARANG_FSTB FROM fstb_form where ID_FSTB = '$ID_FSTB'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk mengeset data fstb berdasarkan HASH_MD5_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function simpan_data
	//         2. 
	function set_md5_id_FSTB_dari_vendor($ID_PROYEK, $NO_URUT_FSTB, $ID_PO, $CREATE_BY_USER) //092023
	{
		$hsl = $this->db->query("SELECT ID_FSTB FROM fstb WHERE ID_PROYEK='$ID_PROYEK' AND
		NO_URUT_FSTB='$NO_URUT_FSTB' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FSTB' => $data->ID_FSTB
				);
			}
		} else {
			$hasil = "BELUM ADA FSTB";
		}
		$ID_FSTB = $hasil['ID_FSTB'];
		$HASH_MD5_FSTB = md5($ID_FSTB);
		$hasil = $this->db->query("UPDATE fstb SET HASH_MD5_FSTB='$HASH_MD5_FSTB' WHERE ID_FSTB='$ID_FSTB'");

		return $hasil;

		// $hsl_2 = $this->db->query("SELECT PO.ID_PO_FORM, PO.ID_PO, PO.ID_BARANG_MASTER, PO.SATUAN_BARANG, PO.ID_JENIS_BARANG, PO.NAMA_BARANG, PO.SPESIFIKASI_SINGKAT, PO.MEREK, PO.PERALATAN_PERLENGKAPAN, PO.JUMLAH_BARANG
		// FROM po_form AS PO 
		// WHERE PO.ID_PO ='$ID_PO'");
		// if ($hsl_2->num_rows() > 0) {
		// 	foreach ($hsl_2->result() as $data) {
		// 		$hasil_2 = array(
		// 			'ID_PO_FORM' => $data->ID_PO_FORM,
		// 			'ID_PO' => $data->ID_PO,
		// 			'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
		// 			'SATUAN_BARANG' => $data->SATUAN_BARANG,
		// 			'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
		// 			'NAMA_BARANG' => $data->NAMA_BARANG,
		// 			'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
		// 			'MEREK' => $data->MEREK,
		// 			'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
		// 			'JUMLAH_BARANG' => $data->JUMLAH_BARANG
		// 		);

		// 		$this->db->query(
		// 			"INSERT INTO fstb_form (ID_FSTB, ID_BARANG_MASTER, SATUAN_BARANG, ID_JENIS_BARANG, NAMA_BARANG, MEREK, PERALATAN_PERLENGKAPAN, SPESIFIKASI_SINGKAT, JUMLAH_DIMINTA)
		// 			VALUES ('$ID_FSTB', '$data->ID_BARANG_MASTER', '$data->SATUAN_BARANG', '$data->ID_JENIS_BARANG', '$data->NAMA_BARANG', '$data->MEREK', '$data->PERALATAN_PERLENGKAPAN', '$data->SPESIFIKASI_SINGKAT', '$data->JUMLAH_BARANG')"
		// 		);
		// 	}
		// }
	}

	function set_md5_id_FSTB_dari_sp($ID_PROYEK_SERAH_TERIMA, $NO_URUT_FSTB, $ID_SURAT_JALAN, $CREATE_BY_USER) //??
	{
		$hsl = $this->db->query("SELECT ID_FSTB FROM fstb WHERE ID_PROYEK_SERAH_TERIMA='$ID_PROYEK_SERAH_TERIMA' AND
		NO_URUT_FSTB='$NO_URUT_FSTB' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FSTB' => $data->ID_FSTB
				);
			}
		} else {
			$hasil = "BELUM ADA FSTB";
		}
		$ID_FSTB = $hasil['ID_FSTB'];
		$HASH_MD5_FSTB = md5($ID_FSTB);
		$this->db->query("UPDATE fstb SET HASH_MD5_FSTB='$HASH_MD5_FSTB' WHERE ID_FSTB='$ID_FSTB'");

		$hsl_2 = $this->db->query("SELECT SJ.ID_SURAT_JALAN, SJ.ID_SURAT_JALAN_FORM, SJ.ID_JENIS_BARANG, SJ.ID_SATUAN_BARANG, SJ.NAMA_BARANG, SJ.MEREK, SJ.PERALATAN_PERLENGKAPAN, SJ.SPESIFIKASI_SINGKAT, SJ.JUMLAH
		FROM surat_jalan_form AS SJ 
		WHERE SJ.ID_SURAT_JALAN ='$ID_SURAT_JALAN'");
		if ($hsl_2->num_rows() > 0) {
			foreach ($hsl_2->result() as $data) {
				$hasil_2 = array(
					'ID_SURAT_JALAN' => $data->ID_SURAT_JALAN,
					'ID_SURAT_JALAN_FORM' => $data->ID_SURAT_JALAN_FORM,
					'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
					'ID_SATUAN_BARANG' => $data->ID_SATUAN_BARANG,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'MEREK' => $data->MEREK,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'JUMLAH' => $data->JUMLAH
				);

				$this->db->query(
					"INSERT INTO fstb_form (ID_FSTB, ID_SATUAN_BARANG, ID_JENIS_BARANG, NAMA_BARANG, MEREK, SPESIFIKASI_SINGKAT, JUMLAH_DIMINTA)
					VALUES ('$ID_FSTB', '$data->ID_SATUAN_BARANG', '$data->ID_JENIS_BARANG', '$data->NAMA_BARANG', '$data->MEREK', '$data->PERALATAN_PERLENGKAPAN', '$data->SPESIFIKASI_SINGKAT', '$data->JUMLAH')"
				);
			}
		}
	}

	//FUNGSI: Fungsi ini untuk menghapus data fstb berdasarkan HASH_MD5_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	// function hapus_data_by_HASH_MD5_FSTB($HASH_MD5_FSTB)
	// {
	// 	$hasil = $this->db->query("DELETE FROM fstb WHERE HASH_MD5_FSTB='$HASH_MD5_FSTB'");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function get_nomor_urut
	//         2. 
	// function get_nomor_urut_by_ID_PROYEK_SERAH_TERIMA($ID_PROYEK_SERAH_TERIMA)
	// {
	// 	$hsl = $this->db->query("SELECT MAX(COUNT_FSTB) AS JUMLAH_COUNT FROM fstb WHERE ID_PROYEK_SERAH_TERIMA ='$ID_PROYEK_SERAH_TERIMA' ");
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

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan HASH_MD5_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB_form / function index
	//         2. controller FSTB_form / function view
	//         3. controller FSTB_form / function cetak_pdf
	function get_data_fstb_by_HASH_MD5_FSTB($HASH_MD5_FSTB)//092023
	{
		$hsl = $this->db->query("SELECT ID_FSTB, HASH_MD5_FSTB, ID_PO, ID_SPP, ID_SPPB, ID_VENDOR, NAMA_PEGAWAI, ID_PROYEK_SUB_PEKERJAAN, ID_PROYEK, NO_URUT_FSTB, LOKASI_PENYERAHAN, NOMOR_SURAT_JALAN_VENDOR, NAMA_PENGIRIM, NO_HP_PENGIRIM, DATE_FORMAT( TANGGAL_BARANG_DATANG_HARI, '%d/%m/%Y') AS TANGGAL_BARANG_DATANG_HARI, SUMBER_PENERIMAAN, DATE_FORMAT( TANGGAL_DOKUMEN_FSTB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_FSTB, DATE_FORMAT( TANGGAL_PEMBUATAN_FSTB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_FSTB_HARI  FROM fstb WHERE HASH_MD5_FSTB ='$HASH_MD5_FSTB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FSTB' => $data->ID_FSTB,
					'HASH_MD5_FSTB' => $data->HASH_MD5_FSTB,
					'ID_PO' => $data->ID_PO,
					'ID_SPP' => $data->ID_SPP,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_VENDOR' => $data->ID_VENDOR,
					'NAMA_PEGAWAI' => $data->NAMA_PEGAWAI,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'ID_PROYEK' => $data->ID_PROYEK,
					'NO_URUT_FSTB' => $data->NO_URUT_FSTB,
					'LOKASI_PENYERAHAN' => $data->LOKASI_PENYERAHAN,
					'NOMOR_SURAT_JALAN_VENDOR' => $data->NOMOR_SURAT_JALAN_VENDOR,
					'NAMA_PENGIRIM' => $data->NAMA_PENGIRIM,
					'NO_HP_PENGIRIM' => $data->NO_HP_PENGIRIM,
					'TANGGAL_BARANG_DATANG_HARI' => $data->TANGGAL_BARANG_DATANG_HARI,
					'SUMBER_PENERIMAAN' => $data->SUMBER_PENERIMAAN,
					'TANGGAL_DOKUMEN_FSTB' => $data->TANGGAL_DOKUMEN_FSTB,
					'TANGGAL_PEMBUATAN_FSTB_HARI' => $data->TANGGAL_PEMBUATAN_FSTB_HARI

				);
			}
		} else {
			$hasil = "TIDAK ADA DATA FSTB";
		}
		return $hasil;
	}

	function simpan_identitas_form( //092023
		$ID_FSTB,
		$NO_URUT_FSTB_GANTI,
		$TANGGAL_DOKUMEN_FSTB,
		$LOKASI_PENYERAHAN, 
		$NOMOR_SURAT_JALAN_VENDOR, 
		$NAMA_PENGIRIM, 
		$NO_HP_PENGIRIM,
		$NAMA_PEGAWAI,
		$TANGGAL_BARANG_DATANG_HARI,
		$CTT_STAFF_LOG
)
	{
		$hasil = $this->db->query("UPDATE FSTB SET
			NO_URUT_FSTB='$NO_URUT_FSTB_GANTI',
			TANGGAL_DOKUMEN_FSTB='$TANGGAL_DOKUMEN_FSTB',
			LOKASI_PENYERAHAN='$LOKASI_PENYERAHAN',
			NOMOR_SURAT_JALAN_VENDOR='$NOMOR_SURAT_JALAN_VENDOR',
			NAMA_PENGIRIM='$NAMA_PENGIRIM',
			NO_HP_PENGIRIM='$NO_HP_PENGIRIM',
			NAMA_PEGAWAI='$NAMA_PEGAWAI',
			TANGGAL_BARANG_DATANG_HARI='$TANGGAL_BARANG_DATANG_HARI',
			CTT_STAFF_LOG='$CTT_STAFF_LOG'
			WHERE ID_FSTB='$ID_FSTB'");
		return $hasil;
	}

	// function get_data_by_id_FSTB($ID_FSTB)
	// {
	// 	$hsl = $this->db->query("SELECT 
	// 	FPB_form.ID_FPB_FORM, 
	// 	FPB_form.NAMA_BARANG, 
	// 	FPB_form.MEREK, 
	// 	FPB_form.JUSTIFIKASI_CHIEF,
	// 	FPB_form.SPESIFIKASI_SINGKAT, 
	// 	FPB_form.JUMLAH_MINTA,
	// 	FPB_form.SATUAN_BARAMG, 
	// 	FPB_form.TANGGAL_MULAI_PAKAI,
	// 	FPB_form.TANGGAL_SELESAI_PAKAI,
	// 	M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
    //     RB.ID_RASD, RB.ID_RASD_FORM,
    //     J.NAMA_JENIS_BARANG,
    //     FROM FPB_form
    //     LEFT JOIN barang_master AS M ON FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
    //     LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = FPB_form.ID_RASD_FORM
    //     LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = FPB_form.ID_JENIS_BARANG
    //     WHERE FSTB.ID_FSTB = '$ID_FSTB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_FPB_FORM' => $data->ID_FPB_FORM,
	// 				'KODE_BARANG' => $data->KODE_BARANG,
	// 				'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
	// 				'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
	// 				'NAMA_BARANG' => $data->NAMA_BARANG,
	// 				'MEREK' => $data->MEREK,
	// 				'JUMLAH_MINTA' => $data->JUMLAH_MINTA,
	// 				'JUSTIFIKASI_CHIEF' => $data->JUSTIFIKASI_CHIEF,
	// 				'TANGGAL_MULAI_PAKAI' => $data->TANGGAL_MULAI_PAKAI,
	// 				'TANGGAL_SELESAI_PAKAI' => $data->TANGGAL_SELESAI_PAKAI
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA FPB Barang";
	// 	}
	// 	return $hasil;
	// 	// return $hsl;
	// }

	// function get_id_FSTB_by_id_khp($ID_KHP)
	// {
	// 	$hasil = $this->db->query("SELECT S.ID_FSTB, P.NAMA_PROYEK,R.ID_RASD,S.JENIS_PEKERJAAN,S.NO_URUT_FSTB,
	// 	S.TANGGAL_PENGAJUAN_FSTB_JAM,S.TANGGAL_PENGAJUAN_FSTB_HARI,S.TANGGAL_PENGAJUAN_FSTB_BULAN,
	// 	S.TANGGAL_PENGAJUAN_FSTB_TAHUN,S.PROGRESS_FSTB,S.DATE_COUNT_PROYEK_CHIEF,S.DATE_COUNT_PROYEK_SM,
	// 	S.DATE_COUNT_PROYEK_PM,S.DATE_COUNT_M_LOG,S.DATE_COUNT_MANAGER,S.DATE_COUNT_DIR,S.DOK_FSTB
	// 	FROM FSTB AS S 
	// 	LEFT JOIN rasd AS R ON R.ID_RASD = S.ID_RASD 
	// 	LEFT JOIN proyek AS P ON P.ID_PROYEK = R.ID_PROYEK
	//     WHERE S.ID_FSTB = (SELECT ID_FSTB FROM komparasi_harga_pemasok WHERE ID_KHP = '$ID_KHP')");
	// 	return $hasil;
	// }



	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan HASH_MD5_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	// function get_data_by_HASH_MD5_FSTB($HASH_MD5_FSTB)
	// {
	// 	$hsl = $this->db->query("SELECT * FROM fstb WHERE HASH_MD5_FSTB = '$HASH_MD5_FSTB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_FSTB' => $data->ID_FSTB,
	// 				'ID_RASD' => $data->ID_RASD,
	// 				'NO_URUT_FSTB' => $data->NO_URUT_FSTB,
	// 				'TANGGAL_PENGAJUAN_FSTB' => $data->TANGGAL_PENGAJUAN_FSTB,
	// 				'PROGRESS_FSTB' => $data->PROGRESS_FSTB
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA FSTB";
	// 	}
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan HASH_MD5_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function get_data_fstb_baru
	//         2. 
	function get_data_fstb_baru($ID_PROYEK, $NO_URUT_FSTB) //23092023
	{
		$hsl = $this->db->query("SELECT * FROM fstb WHERE ID_PROYEK = '$ID_PROYEK' AND
		NO_URUT_FSTB = '$NO_URUT_FSTB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_FSTB' => $data->HASH_MD5_FSTB
				);
			}
		} else {
			$hasil = "BELUM ADA FSTB";
		}
		return $hasil;
	}

	function get_data_proyek() //092023
	{
		$hsl = $this->db->query("SELECT * FROM proyek");
		return $hsl->result();
	}

	function get_data_proyek_sp($ID_PROYEK) //092023 ??
	{
		$hsl = $this->db->query("SELECT * FROM proyek WHERE ID_PROYEK = '$ID_PROYEK'");
		return $hsl->result();
	}

	function get_data_surat_jalan($ID_PROYEK) //092023 ??
	{
		$hsl = $this->db->query("SELECT * FROM surat_jalan WHERE ID_PROYEK ='$ID_PROYEK'");
		return $hsl->result();
	}

	function get_data_po($ID_PROYEK) //092023
	{
		$hsl = $this->db->query("SELECT * FROM po
		WHERE ID_PROYEK ='$ID_PROYEK'");
		return $hsl->result();
	}

	function get_data_vendor($ID_PO) //092023
	{
		$hsl = $this->db->query("SELECT PO.ID_PO, PO.ID_VENDOR, PO.NO_URUT_PO, PO.ID_SPP, PO.ID_SPPB, PO.LOKASI_PENYERAHAN, PO.ID_PROYEK_SUB_PEKERJAAN, V.NAMA_VENDOR FROM po AS PO
		LEFT JOIN vendor AS V ON V.ID_VENDOR = PO.ID_VENDOR
		WHERE ID_PO ='$ID_PO'");
		return $hsl->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan NO_URUT_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function simpan_data
	//         2. 
	function cek_no_urut_FSTB($NO_URUT_FSTB) //092023
	{
		$hsl = $this->db->query("SELECT ID_FSTB, NO_URUT_FSTB FROM fstb WHERE NO_URUT_FSTB ='$NO_URUT_FSTB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'NO_URUT_FSTB' => $data->NO_URUT_FSTB,
					'ID_FSTB' => $data->ID_FSTB
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	// function update_data_ubah_logistik(
	// 	$ID_FSTB,
	// 	$CTT
	// ) {
	// 	$hasil = $this->db->query("UPDATE FSTB SET 
	// 	CTT_STAFF_LOG='$CTT'
	// 	WHERE ID_FSTB='$ID_FSTB'");
	// 	return $hasil;
	// }

	// function update_data_akhir(
	// 	$ID_FSTB,
	// 	$CTT
	// ) {
	// 	$hasil = $this->db->query("UPDATE FSTB SET 
	// 	CTT_D_KEU='$CTT'
	// 	WHERE ID_FSTB='$ID_FSTB'");
	// 	return $hasil;
	// }


	// function get_id_FSTB_by_no_urut($NO_URUT_FSTB)
	// {
	// 	$hsl = $this->db->query("SELECT ID_FSTB FROM FSTB WHERE NO_URUT_FSTB = '$NO_URUT_FSTB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		// foreach ($hsl->result() as $data) {
	// 		// 	$hasil =  $data->ID_FSTB;
	// 		// }
	// 		$hasil = $hsl->row()->ID_FSTB;
	// 	} else {
	// 		$hasil = "BELUM ADA";
	// 	}
	// 	return $hasil;
	// }

	// function simpan_data_by_admin($ID_RASD, $JENIS_PEKERJAAN, $TANGGAL_PENGAJUAN_FSTB, $NO_URUT_FSTB, $JUMLAH_COUNT)
	// {
	// 	$hasil = $this->db->query("INSERT INTO FSTB (
	// 		ID_RASD,
	// 		JUMLAH_COUNT,
	// 		JENIS_PEKERJAAN,
	// 		TANGGAL_PENGAJUAN_FSTB_HARI,
	// 		NO_URUT_FSTB)
	// 	VALUES(
	// 		'$ID_RASD',
	// 		'$JUMLAH_COUNT',
	// 		'$JENIS_PEKERJAAN',
	// 		'$TANGGAL_PENGAJUAN_FSTB',
	// 		'$NO_URUT_FSTB')");

	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menambahkan data fstb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function simpan_data
	//         2. 
	function simpan_data( //092023
		$ID_PROYEK,
		$ID_PROYEK_SUB_PEKERJAAN,
		$ID_SPPB,
		$ID_SPP,
		$ID_PO,
		$TANGGAL_DOKUMEN_FSTB,
		$TANGGAL_PEMBUATAN_FSTB_HARI,
		$NO_URUT_FSTB,
		$CREATE_BY_USER,
		$STATUS_FSTB,
		$PROGRESS_FSTB,
		$JUMLAH_COUNT,
		$FILE_NAME_TEMP,
		$ID_VENDOR,
		$ID_SURAT_JALAN,
		$NOMOR_SURAT_JALAN_VENDOR,
		$LOKASI_PENYERAHAN,
		$NAMA_PENGIRIM,
		$NO_HP_PENGIRIM,
		$NAMA_PEGAWAI,
		$TANGGAL_BARANG_DATANG_HARI,
		$SUMBER_PENERIMAAN
) {
		$hasil = $this->db->query("INSERT INTO fstb (
			ID_PROYEK,
			ID_PROYEK_SUB_PEKERJAAN,
			ID_SPPB,
			ID_SPP,
            ID_PO,
            TANGGAL_DOKUMEN_FSTB,
			TANGGAL_PEMBUATAN_FSTB_HARI,
            NO_URUT_FSTB,
            CREATE_BY_USER,
            STATUS_FSTB,
            PROGRESS_FSTB,
            COUNT_FSTB,
            FILE_NAME_TEMP,
            ID_VENDOR,
            ID_SURAT_JALAN,
			NOMOR_SURAT_JALAN_VENDOR,
			LOKASI_PENYERAHAN,
            NAMA_PENGIRIM,
            NO_HP_PENGIRIM,
            NAMA_PEGAWAI,
            TANGGAL_BARANG_DATANG_HARI,
			SUMBER_PENERIMAAN)
		VALUES(
			'$ID_PROYEK',
			'$ID_PROYEK_SUB_PEKERJAAN',
			'$ID_SPPB',
			'$ID_SPP',
			'$ID_PO',
			'$TANGGAL_DOKUMEN_FSTB',
			'$TANGGAL_PEMBUATAN_FSTB_HARI',
			'$NO_URUT_FSTB',
			'$CREATE_BY_USER',
			'$STATUS_FSTB',
			'$PROGRESS_FSTB',
			'$JUMLAH_COUNT',
			'$FILE_NAME_TEMP',
			'$ID_VENDOR',
			'$ID_SURAT_JALAN',
			'$NOMOR_SURAT_JALAN_VENDOR',
			'$LOKASI_PENYERAHAN',
			'$NAMA_PENGIRIM',
			'$NO_HP_PENGIRIM',
			'$NAMA_PEGAWAI',
			'$TANGGAL_BARANG_DATANG_HARI',
			'$SUMBER_PENERIMAAN')");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fstb berdasarkan ID_USER
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function logout
	//         2. controller FSTB / function user_log

	function user_log_fstb($ID_USER, $ID_FSTB,  $KETERANGAN, $WAKTU) //092023
	{
		$db2 = $this->load->database('logs', TRUE);

		$hasil = $db2->query("INSERT INTO user_log_fstb (ID_USER, ID_FSTB, KETERANGAN, WAKTU) VALUES('$ID_USER', '$ID_FSTB', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
