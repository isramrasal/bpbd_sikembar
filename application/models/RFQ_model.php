<?php
class RFQ_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb yang barangnya tidak ada di gudang
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller RFQ / function index
	//         2. 
	// function sppb_list_rfq()
	// {
	// 	$hasil = $this->db->query("SELECT S.ID_SPPB, S.NO_URUT_SPPB, DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB, S.HASH_MD5_SPPB, P.NAMA_PROYEK from sppb AS S LEFT JOIN proyek AS P on P.ID_PROYEK = S.ID_PROYEK WHERE S.PROGRESS_SPPB = 'SPPB Pembelian Disetujui'");
	// 	return $hasil->result();
	// }
	// // WHERE SF.GUDANG_TERSEDIA = 'TIDAK'

	// function sppb_list_rfq_by_id_proyek($ID_PROYEK)
	// {
	// 	$hasil = $this->db->query("SELECT S.ID_SPPB, S.NO_URUT_SPPB, DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB, S.HASH_MD5_SPPB, P.NAMA_PROYEK, PSP.NAMA_SUB_PEKERJAAN from sppb AS S 
	// 	LEFT JOIN proyek AS P on P.ID_PROYEK = S.ID_PROYEK
	// 	LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = S.ID_PROYEK_SUB_PEKERJAAN
	// 	WHERE S.PROGRESS_SPPB = 'SPPB Pembelian Disetujui' AND S.ID_PROYEK = '$ID_PROYEK'");
	// 	return $hasil->result();
	// }

	function list_RFQ_by_all_proyek()//092023
	{
		$hasil = $this->db->query("SELECT RFQ.HASH_MD5_RFQ, RFQ.NO_URUT_RFQ, RFQ.STATUS_RFQ, DATE_FORMAT(RFQ.TANGGAL_DOKUMEN_RFQ, '%d/%m/%Y') AS TANGGAL_DOKUMEN_RFQ, P.NAMA_PROYEK, PSP.NAMA_SUB_PEKERJAAN, SPB.ID_SPPB, SPB.HASH_MD5_SPPB FROM request_for_quotation AS RFQ
		LEFT JOIN sppb AS SPB on SPB.ID_SPPB = RFQ.ID_SPPB
		LEFT JOIN proyek AS P on P.ID_PROYEK = RFQ.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = RFQ.ID_PROYEK_SUB_PEKERJAAN ");
		return $hasil->result();
	}

	function list_RFQ_by_id_proyek($ID_PROYEK)//092023
	{
		$hasil = $this->db->query("SELECT RFQ.HASH_MD5_RFQ, RFQ.NO_URUT_RFQ, RFQ.STATUS_RFQ, DATE_FORMAT(RFQ.TANGGAL_DOKUMEN_RFQ, '%d/%m/%Y') AS TANGGAL_DOKUMEN_RFQ, P.NAMA_PROYEK, PSP.NAMA_SUB_PEKERJAAN, SPB.ID_SPPB, SPB.HASH_MD5_SPPB FROM request_for_quotation AS RFQ
		LEFT JOIN sppb AS SPB on SPB.ID_SPPB = RFQ.ID_SPPB
		LEFT JOIN proyek AS P on P.ID_PROYEK = RFQ.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = RFQ.ID_PROYEK_SUB_PEKERJAAN
		WHERE RFQ.ID_PROYEK = '$ID_PROYEK'");
		return $hasil->result();
	}

	function sppb_list_rfq_by_hashmd5($HASH_MD5_SPPB)
	{
		$hasil = $this->db->query("SELECT DISTINCT SF.ID_SPPB, S.NO_URUT_SPPB, P.NAMA_PROYEK, DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB, S.HASH_MD5_SPPB from sppb_form as SF LEFT JOIN sppb AS S on S.ID_SPPB = SF.ID_SPPB LEFT JOIN proyek as P on P.ID_PROYEK = S.ID_PROYEK WHERE(S.PROGRESS_SPPB = 'SPPB Pembelian Disetujui' AND S.HASH_MD5_SPPB = '$HASH_MD5_SPPB')");
		return $hasil->result();
	}

	function rfq_list_rfq_by_hashmd5($HASH_MD5_RFQ)
	{

		$hasil = $this->db->query("SELECT ALAMAT_VENDOR,
		DATE_FORMAT(BATAS_AKHIR, '%d/%m/%Y') AS BATAS_AKHIR,
		BATAS_AKHIR AS BATAS_AKHIR_INDO,
		CREATE_BY_USER,
		CTT_KASIE,
		CTT_MANAGER_PROC,
		CTT_STAFF_PROC,
		CTT_STAFF_PROC_SP,
		CTT_SUPERVISI_PROC_SP,
		EMAIL_PIC_VENDOR,
		HASH_MD5_RFQ,
		ID_PROYEK,
		ID_PROYEK_LOKASI_PENYERAHAN,
		ID_RFQ,
		ID_SPPB,
		TERM_OF_PAYMENT,
		ID_VENDOR,
		ISI_BODY,
		JUMLAH_COUNT,
		KETERANGAN_RFQ,
		KIRIM_EMAIL,
		LOKASI_PENYERAHAN,
		NAMA_PIC_VENDOR,
		NAMA_VENDOR,
		NO_TELP_VENDOR,
		NO_URUT_RFQ,
		PROGRESS_RFQ,
		REVISI_KE,
		SALAM_PEMBUKA,
		STATUS_RFQ,
		STATUS_VENDOR,
		DATE_FORMAT(TANGGAL_DOKUMEN_RFQ, '%d/%m/%Y') AS TANGGAL_DOKUMEN_RFQ,
		TANGGAL_DOKUMEN_RFQ AS TANGGAL_DOKUMEN_RFQ_INDO,
		TANGGAL_PEMBUATAN_RFQ_HARI,
		TANGGAL_PEMBUATAN_RFQ_BULAN,
		TANGGAL_PEMBUATAN_RFQ_JAM,
		TANGGAL_PEMBUATAN_RFQ_TAHUN,
		TOP
		 from request_for_quotation WHERE ( HASH_MD5_RFQ = '$HASH_MD5_RFQ')");
		return $hasil;
	}

	function rfq_list_by_ID_VENDOR($ID_VENDOR, $WAKTU)
	{

		$hasil = $this->db->query("SELECT ALAMAT_VENDOR,
		BATAS_AKHIR,
		CREATE_BY_USER,
		CTT_KASIE,
		CTT_MANAGER_PROC,
		CTT_STAFF_PROC,
		CTT_STAFF_PROC_SP,
		CTT_SUPERVISI_PROC_SP,
		EMAIL_PIC_VENDOR,
		HASH_MD5_RFQ,
		ID_PROYEK,
		ID_PROYEK_LOKASI_PENYERAHAN,
		ID_RFQ,
		ID_SPPB,
		TERM_OF_PAYMENT,
		ID_VENDOR,
		ISI_BODY,
		JUMLAH_COUNT,
		KETERANGAN_RFQ,
		KIRIM_EMAIL,
		LOKASI_PENYERAHAN,
		NAMA_PIC_VENDOR,
		NAMA_VENDOR,
		NO_TELP_VENDOR,
		NO_URUT_RFQ,
		PROGRESS_RFQ,
		REVISI_KE,
		SALAM_PEMBUKA,
		STATUS_RFQ,
		STATUS_VENDOR,
		DATE_FORMAT(TANGGAL_DOKUMEN_RFQ, '%d/%m/%Y') AS TANGGAL_DOKUMEN_RFQ,
		DATE_FORMAT(TANGGAL_PEMBUATAN_RFQ_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_RFQ_HARI,
		TANGGAL_PEMBUATAN_RFQ_BULAN,
		TANGGAL_PEMBUATAN_RFQ_JAM,
		TANGGAL_PEMBUATAN_RFQ_TAHUN,
		TOP
		 from request_for_quotation WHERE ( ID_VENDOR = '$ID_VENDOR') AND ( BATAS_AKHIR > '$WAKTU' ) AND ( STATUS_VENDOR = '') AND (KIRIM_EMAIL = 'TERKIRIM')");
		return $hasil->result();
	}

	function rfq_list_rfq_by_id_vendor($ID_VENDOR)
	{

		$hasil = $this->db->query("SELECT * from request_for_quotation WHERE ( ID_VENDOR = '$ID_VENDOR')");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut RFQ  berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel rfq
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut
	//         2. 
	function get_nomor_urut_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT MAX(RFQ.JUMLAH_COUNT) AS JUMLAH_COUNT_RFQ FROM request_for_quotation AS RFQ WHERE RFQ.ID_PROYEK ='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'JUMLAH_COUNT_RFQ' => $data->JUMLAH_COUNT_RFQ
				);
			}
		} else {
			$hasil = "BELUM ADA RFQ";
		}
		return $hasil;
	}

	function get_data_sppb_by_id_proyek($ID_PROYEK)//092023
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

	function get_data_sub_pekerjaan_by_id_sppb($ID_SPPB)//092023
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

	function get_data_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ)
	{
		$hsl = $this->db->query("SELECT ID_RFQ, HASH_MD5_RFQ, NO_URUT_RFQ, ID_SPPB, ID_PROYEK, ID_PROYEK_SUB_PEKERJAAN, ID_VENDOR, TERM_OF_PAYMENT, TOP, ID_PROYEK_LOKASI_PENYERAHAN, PROGRESS_RFQ, KETERANGAN_RFQ, CTT_STAFF_PROC, DATE_FORMAT(BATAS_AKHIR, '%d/%m/%Y') AS BATAS_AKHIR, BATAS_AKHIR AS BATAS_AKHIR_INDO FROM request_for_quotation WHERE HASH_MD5_RFQ ='$HASH_MD5_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RFQ' => $data->ID_RFQ,
					'HASH_MD5_RFQ' => $data->HASH_MD5_RFQ,
					'NO_URUT_RFQ' => $data->NO_URUT_RFQ,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'ID_VENDOR' => $data->ID_VENDOR,
					'TERM_OF_PAYMENT' => $data->TERM_OF_PAYMENT,
					'TOP' => $data->TOP,
					'ID_PROYEK_LOKASI_PENYERAHAN' => $data->ID_PROYEK_LOKASI_PENYERAHAN,
					'PROGRESS_RFQ' => $data->PROGRESS_RFQ,
					'KETERANGAN_RFQ' => $data->KETERANGAN_RFQ,
					'CTT_STAFF_PROC' => $data->CTT_STAFF_PROC,
					'BATAS_AKHIR' => $data->BATAS_AKHIR,
					'BATAS_AKHIR_INDO' => $data->BATAS_AKHIR_INDO
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_id_rasd_by_id_rab_form($ID_RAB_FORM)
	{
		$hsl = $this->db->query("SELECT * FROM RASD where ID_RAB_FORM  ='$ID_RAB_FORM' ");

		return $hsl->result();
	}

	function get_data_quotation_by_ID_RFQ($ID_RFQ)
	{
		$hsl = $this->db->query("SELECT * FROM quotation WHERE ID_RFQ ='$ID_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RFQ' => $data->ID_RFQ,
					'ID_QUOTATION' => $data->ID_QUOTATION,
					'HASH_MD5_QUOTATION' => $data->HASH_MD5_QUOTATION,
					'NO_URUT_QUOTATION' => $data->NO_URUT_QUOTATION,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_VENDOR' => $data->ID_VENDOR,
					'TERM_OF_PAYMENT' => $data->TERM_OF_PAYMENT,
					'TOP' => $data->TOP,
					'ID_PROYEK_LOKASI_PENYERAHAN' => $data->ID_PROYEK_LOKASI_PENYERAHAN,
					'KETERANGAN_RFQ' => $data->KETERANGAN_RFQ,
					'BATAS_AKHIR' => $data->BATAS_AKHIR
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_quotation_by_ID_RFQ_HASIL($ID_RFQ)
	{
		$hasil = $this->db->query("SELECT * FROM quotation WHERE ID_RFQ ='$ID_RFQ'");
		
		return $hasil;
	}
	
	function get_data_proyek_by_hash_md5_po($HASH_MD5_PO)
	{
		$hsl = $this->db->query("SELECT 
		P.ID_PROYEK_LOKASI_PENYERAHAN, 
		P.ID_PO, 
		S.HASH_MD5_RENCANA_PENGIRIMAN_BARANG, 
		S.NO_RENCANA_PENGIRIMAN_BARANG,
		S.NO_URUT_PO,
		S.TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
		S.KEPADA,
		S.NAMA_PENGIRIM,
		S.NO_HP_PENGIRIM,
		S.TUJUAN
		from po as P 
		LEFT JOIN rencana_pengiriman_barang AS R ON P.ID_PO = R.ID_PO
		WHERE P.HASH_MD5_PO = '$HASH_MD5_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK_LOKASI_PENYERAHAN' => $data->ID_PROYEK_LOKASI_PENYERAHAN,
					'ID_PO' => $data->ID_PO,
					'HASH_MD5_RENCANA_PENGIRIMAN_BARANG' => $data->HASH_MD5_RENCANA_PENGIRIMAN_BARANG,
					'NO_RENCANA_PENGIRIMAN_BARANG' => $data->NO_RENCANA_PENGIRIMAN_BARANG,
					'NO_URUT_PO' => $data->NO_URUT_PO,
					'TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI' => $data->TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
					'KEPADA' => $data->KEPADA,
					'NAMA_PENGIRIM' => $data->NAMA_PENGIRIM,
					'NO_HP_PENGIRIM' => $data->NO_HP_PENGIRIM,
					'TUJUAN' => $data->TUJUAN
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	function get_id_rfq_by_HASH_MD5_RFQ($HASH_MD5_RFQ)
	{
		$hsl = $this->db->query("SELECT ID_RFQ FROM request_for_quotation WHERE HASH_MD5_RFQ ='$HASH_MD5_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RFQ' => $data->ID_RFQ,
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA";
		}
		return $hasil;
	}

	// function get_list_rfq_by_id_sppb($ID_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT HASH_MD5_RFQ, NO_URUT_RFQ, STATUS_RFQ, DATE_FORMAT(TANGGAL_DOKUMEN_RFQ, '%d/%m/%Y') AS TANGGAL_DOKUMEN_RFQ, ID_RFQ FROM request_for_quotation WHERE ID_SPPB ='$ID_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		return $hsl->result();
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	function cek_nomor_urut_rfq($NO_URUT_RFQ)//092023
	{
		$hsl = $this->db->query("SELECT ID_RFQ, HASH_MD5_RFQ, NO_URUT_RFQ FROM request_for_quotation WHERE NO_URUT_RFQ ='$NO_URUT_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RFQ ' => $data->ID_RFQ,
					'HASH_MD5_RFQ' => $data->HASH_MD5_RFQ,
					'NO_URUT_RFQ' => $data->NO_URUT_RFQ
				);
			}
			return $hasil;
		} else {
			return 'DATA BELUM ADA';
		}
	}

	//FUNGSI: Fungsi ini untuk menambahkan data RFQ
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller RFQ_form / function simpan_data_dari_barang_master
	//         2. 
	function simpan_data_rfq( //092023
		$ID_SPPB,
		$ID_PROYEK,
		$ID_PROYEK_SUB_PEKERJAAN,
		$FILE_NAME_TEMP,
		$REVISI_KE,
		$JUMLAH_COUNT_RFQ,
		$TANGGAL_DOKUMEN_RFQ,
		$NO_URUT_RFQ,
		$CREATE_BY_USER,
		$STATUS_RFQ,
		$PROGRESS_RFQ,
		$TANGGAL_PEMBUATAN_RFQ_JAM,
		$TANGGAL_PEMBUATAN_RFQ_HARI,
		$TANGGAL_PEMBUATAN_RFQ_BULAN,
		$TANGGAL_PEMBUATAN_RFQ_TAHUN
	)
	{
		$hasil = $this->db->query(
			"INSERT INTO request_for_quotation
			(
				ID_SPPB,
				ID_PROYEK,
				ID_PROYEK_SUB_PEKERJAAN,
				FILE_NAME_TEMP,
				REVISI_KE,
				JUMLAH_COUNT,
				TANGGAL_DOKUMEN_RFQ,
				NO_URUT_RFQ,
				CREATE_BY_USER,
				STATUS_RFQ,
				PROGRESS_RFQ,
				TANGGAL_PEMBUATAN_RFQ_JAM,
                TANGGAL_PEMBUATAN_RFQ_HARI,
                TANGGAL_PEMBUATAN_RFQ_BULAN,
                TANGGAL_PEMBUATAN_RFQ_TAHUN
			)
			VALUES
			(
				'$ID_SPPB',
				'$ID_PROYEK',
				'$ID_PROYEK_SUB_PEKERJAAN',
				'$FILE_NAME_TEMP',
				'$REVISI_KE',
				'$JUMLAH_COUNT_RFQ',
				'$TANGGAL_DOKUMEN_RFQ',
				'$NO_URUT_RFQ',
				'$CREATE_BY_USER',
				'$STATUS_RFQ',
				'$PROGRESS_RFQ',
				'$TANGGAL_PEMBUATAN_RFQ_JAM',
            	'$TANGGAL_PEMBUATAN_RFQ_HARI',
                '$TANGGAL_PEMBUATAN_RFQ_BULAN',
                '$TANGGAL_PEMBUATAN_RFQ_TAHUN'
			)"
		);

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengeset HASH_MD5_SPPB berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function set_md5_id_RFQ($ID_PROYEK, $ID_SPPB, $NO_URUT_RFQ, $CREATE_BY_USER)//092023
	{
		$hsl = $this->db->query("SELECT ID_RFQ FROM request_for_quotation WHERE ID_PROYEK='$ID_PROYEK' AND
		ID_SPPB='$ID_SPPB' AND NO_URUT_RFQ='$NO_URUT_RFQ' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RFQ' => $data->ID_RFQ
				);
			}
		} else {
			$hasil = "BELUM ADA RFQ";
		}
		$ID_RFQ = $hasil['ID_RFQ'];
		$HASH_MD5_RFQ = md5($ID_RFQ);
		$hasil = $this->db->query("UPDATE request_for_quotation SET HASH_MD5_RFQ='$HASH_MD5_RFQ' WHERE ID_RFQ='$ID_RFQ'");

		// $hsl_2 = $this->db->query("SELECT SF.ID_SPPB_FORM, SF.ID_SPPB, SF.ID_RASD_FORM, SF.ID_BARANG_MASTER, SF.SATUAN_BARANG, SF.ID_JENIS_BARANG, SF.ID_KLASIFIKASI_BARANG, SF.ID_PROYEK_SUB_PEKERJAAN, SF.NAMA_BARANG, SF.MEREK, SF.SPESIFIKASI_SINGKAT, SF.JUMLAH_QTY_SPP, SF.PERALATAN_PERLENGKAPAN, FPBF.ID_FPB, FPBF.ID_FPB_FORM
		// FROM sppb_form AS SF
        // LEFT JOIN fpb_form AS FPBF ON SF.ID_FPB_FORM = FPBF.ID_FPB_FORM
		// WHERE SF.ID_SPPB = '$ID_SPPB' AND SF.JUMLAH_QTY_SPP > 0;");
		// if ($hsl_2->num_rows() > 0) {
		// 	foreach ($hsl_2->result() as $data) {
		// 		$hasil_2 = array(
		// 			'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
		// 			'ID_SPPB' => $data->ID_SPPB,
		// 			'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
		// 			'SATUAN_BARANG' => $data->SATUAN_BARANG,
		// 			'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
		// 			'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
		// 			'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
		// 			'ID_FPB' => $data->ID_FPB,
		// 			'ID_FPB_FORM' => $data->ID_FPB_FORM,
		// 			'NAMA_BARANG' => $data->NAMA_BARANG,
		// 			'MEREK' => $data->MEREK,
		// 			'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
		// 			'JUMLAH_QTY_SPP' => $data->JUMLAH_QTY_SPP,
		// 			'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN
		// 		);

		// 		$this->db->query(
		// 			"INSERT INTO rfq_form (ID_RFQ, ID_SPPB_FORM, ID_SPPB, ID_RASD_FORM, ID_BARANG_MASTER, ID_FPB, ID_FPB_FORM, SATUAN_BARANG, ID_JENIS_BARANG, ID_KLASIFIKASI_BARANG, ID_PROYEK_SUB_PEKERJAAN, NAMA_BARANG, MEREK, SPESIFIKASI_SINGKAT, JUMLAH_BARANG, PERALATAN_PERLENGKAPAN)
		// 			VALUES ('$ID_RFQ', '$data->ID_SPPB_FORM', '$data->ID_SPPB', '$data->ID_RASD_FORM', '$data->ID_BARANG_MASTER', '$data->ID_FPB', '$data->ID_FPB_FORM', '$data->SATUAN_BARANG', '$data->ID_JENIS_BARANG', '$data->ID_KLASIFIKASI_BARANG', '$data->ID_PROYEK_SUB_PEKERJAAN', '$data->NAMA_BARANG', '$data->MEREK' , '$data->SPESIFIKASI_SINGKAT', '$data->JUMLAH_QTY_SPP', '$data->PERALATAN_PERLENGKAPAN')"
		// 		);

		// 		$this->db->query(
		// 			"UPDATE sppb_form SET 
		// 			STATUS_RFQ='Dalam Proses RFQ', KET_RFQ='$ID_RFQ'
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

	function get_data_proyek_by_hash_md5_rfq($HASH_MD5_RFQ)
	{
		$hsl = $this->db->query("SELECT RFQ.ID_PROYEK, RFQ.NO_URUT_RFQ, RFQ.ID_RASD, RFQ.ID_RFQ, P.NAMA_PROYEK, P.LOKASI, P.INISIAL from request_for_quotation as RFQ 
		LEFT JOIN proyek AS P ON RFQ.ID_PROYEK = P.ID_PROYEK
		WHERE RFQ.HASH_MD5_RFQ = '$HASH_MD5_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_RASD' => $data->ID_RASD,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'LOKASI' => $data->LOKASI,
					'INISIAL' => $data->INISIAL,
					'NO_URUT_RFQ' => $data->NO_URUT_RFQ,
					'ID_RFQ' => $data->ID_RFQ
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RFQ berdasarkan yang baru diinput
	//SUMBER TABEL: tabel RFQ
	//DIPAKAI: 1. controller RFQ / function get_data_rfq_baru
	//         2. 
	function get_data_rfq_baru($ID_PROYEK, $NO_URUT_RFQ, $CREATE_BY_USER)//092023
	{
		$hsl = $this->db->query("SELECT * FROM request_for_quotation WHERE ID_PROYEK = '$ID_PROYEK' AND
		NO_URUT_RFQ = '$NO_URUT_RFQ' AND
		CREATE_BY_USER = '$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_RFQ' => $data->HASH_MD5_RFQ
				);
			}
		} else {
			$hasil = "BELUM ADA RFQ";
		}
		return $hasil;
	}

	function get_data_CTT_STAFF_PROC($HASH_MD5_RFQ)
	{
		$hsl = $this->db->query("SELECT ID_RFQ, CTT_STAFF_PROC FROM request_for_quotation WHERE HASH_MD5_RFQ ='$HASH_MD5_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_STAFF_PROC' => $data->CTT_STAFF_PROC,
					'ID_RFQ' => $data->ID_RFQ
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_KASIE($HASH_MD5_RFQ)
	{
		$hsl = $this->db->query("SELECT ID_RFQ, CTT_KASIE FROM request_for_quotation WHERE HASH_MD5_RFQ ='$HASH_MD5_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_KASIE' => $data->CTT_KASIE,
					'ID_RFQ' => $data->ID_RFQ
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_MANAGER_PROC($HASH_MD5_RFQ)
	{
		$hsl = $this->db->query("SELECT ID_RFQ, CTT_MANAGER_PROC FROM request_for_quotation WHERE HASH_MD5_RFQ ='$HASH_MD5_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_MANAGER_PROC' => $data->CTT_MANAGER_PROC,
					'ID_RFQ' => $data->ID_RFQ
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_STAFF_PROC_SP($HASH_MD5_RFQ)
	{
		$hsl = $this->db->query("SELECT ID_RFQ, CTT_STAFF_PROC_SP FROM request_for_quotation WHERE HASH_MD5_RFQ ='$HASH_MD5_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_STAFF_PROC_SP' => $data->CTT_STAFF_PROC_SP,
					'ID_RFQ' => $data->ID_RFQ
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_CTT_SUPERVISI_PROC_SP($HASH_MD5_RFQ)
	{
		$hsl = $this->db->query("SELECT ID_RFQ, CTT_SUPERVISI_PROC_SP FROM request_for_quotation WHERE HASH_MD5_RFQ ='$HASH_MD5_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CTT_SUPERVISI_PROC_SP' => $data->CTT_SUPERVISI_PROC_SP,
					'ID_RFQ' => $data->ID_RFQ
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RFQ berdasarkan ID_RFQ
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller RFQ_form / function index

	function rfq_list_by_id_rfq($ID_RFQ)
	{
		$hasil = $this->db->query("SELECT * FROM request_for_quotation WHERE ID_RFQ = '$ID_RFQ'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data rfq form berdasarkan ID_RFQ_FORM
	//SUMBER TABEL: tabel rfq
	//DIPAKAI: 1. controller RFQ_form / function simpan_identitas_form
	//         
	function simpan_identitas_form($ID_RFQ, $NO_URUT_RFQ_GANTI, $TANGGAL_DOKUMEN_RFQ, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $TERM_OF_PAYMENT, $KETERANGAN_RFQ, $BATAS_AKHIR)//092023
	{
		$hasil = $this->db->query("UPDATE request_for_quotation SET
			NO_URUT_RFQ ='$NO_URUT_RFQ_GANTI',
			TANGGAL_DOKUMEN_RFQ ='$TANGGAL_DOKUMEN_RFQ',
			ID_PROYEK_LOKASI_PENYERAHAN ='$ID_PROYEK_LOKASI_PENYERAHAN',
			ID_VENDOR ='$ID_VENDOR',
			TERM_OF_PAYMENT ='$TERM_OF_PAYMENT',
			KETERANGAN_RFQ = '$KETERANGAN_RFQ',
			BATAS_AKHIR = '$BATAS_AKHIR'
			WHERE ID_RFQ ='$ID_RFQ'");
		return $hasil;
	}

	function update_progress_rfq($HASH_MD5_RFQ, $PROGRESS_RFQ)
	{
		$hasil = $this->db->query("UPDATE request_for_quotation SET 
			PROGRESS_RFQ='$PROGRESS_RFQ'
			WHERE HASH_MD5_RFQ='$HASH_MD5_RFQ'");
		return $hasil;
	}

	function update_status_vendor($HASH_MD5_RFQ, $STATUS_VENDOR)
	{
		$hasil = $this->db->query("UPDATE request_for_quotation SET 
			STATUS_VENDOR='$STATUS_VENDOR'
			WHERE HASH_MD5_RFQ='$HASH_MD5_RFQ'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb berdasarkan ID_USER
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function logout
	//         2. controller SPPB / function user_log
	function user_log_rfq($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_rfq (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}