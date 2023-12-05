<?php
class Quotation_form_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh rfq form
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function data_rfq_form
	//         2. 
	function quotation_form_list_by_id_quotation($ID_QUOTATION) //dipakai
	{
		$hasil = $this->db->query("SELECT 
		QF.ID_SPPB,
		QF.ID_QUOTATION_FORM,
		QF.ID_SPPB_FORM,
		QF.NAMA_BARANG, 
		QF.MEREK, 
		QF.PERALATAN_PERLENGKAPAN, 
		QF.SPESIFIKASI_SINGKAT, 
		QF.JUMLAH_BARANG,
		QF.KETERANGAN,
		QF.HARGA_SATUAN_BARANG,
		QF.HARGA_TOTAL,
		QF.KETERANGAN_VENDOR,
		QF.KETERANGAN_INPUT_MANUAL,
		QFA.ID_QUOTATION_FORM,
		QFA.NAMA_BARANG_ALTERNATIF, 
		QFA.MEREK_ALTERNATIF, 
		QFA.PERALATAN_PERLENGKAPAN, 
		QFA.SPESIFIKASI_SINGKAT_ALTERNATIF, 
		QFA.JUMLAH_BARANG_ALTERNATIF,
		QFA.KETERANGAN,
		QFA.HARGA_SATUAN_BARANG_ALTERNATIF,
		QFA.HARGA_TOTAL_ALTERNATIF,
		QFA.KETERANGAN_VENDOR_ALTERNATIF,
		QFA.KETERANGAN_INPUT_MANUAL,
		M.ID_BARANG_MASTER, 
		M.KODE_BARANG, 
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_QUOTATION,
		RB.ID_QUOTATION_FORM,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG,
		sppb_form.JUMLAH_QTY_SPP
        FROM quotation_form AS QF
        LEFT JOIN barang_master AS M ON QF.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN quotation_form_alternatif AS QFA ON QF.ID_QUOTATION_FORM = QFA.ID_QUOTATION_FORM
        LEFT JOIN quotation_form AS RB ON RB.ID_QUOTATION_FORM = QF.ID_QUOTATION_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = QF.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = QF.ID_SATUAN_BARANG
        LEFT JOIN sppb_form AS sppb_form ON sppb_form.ID_SPPB_FORM = QF.ID_SPPB_FORM
        WHERE RB.ID_QUOTATION = '$ID_QUOTATION'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data BARANG MASTER berdasarkan ID_RFQ
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller rfq_form / function index
	//         2. 
	function barang_master_where_not_in_rfq_and_rasd($ID_RFQ)
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.KODE_BARANG, M.MEREK, M.HASH_MD5_BARANG_MASTER, 
		J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG, M.PERALATAN_PERLENGKAPAN,
		M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
        WHERE 
        	NOT EXISTS 
            	(SELECT ID_BARANG_MASTER 
				FROM RASD_FORM 
				WHERE RASD_FORM.ID_BARANG_MASTER = M.ID_BARANG_MASTER 
				AND RASD_FORM.ID_RASD = (SELECT ID_RASD FROM request_for_quotation WHERE ID_RFQ = '$ID_RFQ'))
           	AND
            NOT EXISTS
            	(SELECT ID_BARANG_MASTER
                 FROM rfq_form
                 WHERE rfq_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                 AND rfq_form.ID_RFQ = '$ID_RFQ')
            	");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_RFQ
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller RFQ_form / function index
	//         2. 
	function rasd_form_list_where_not_in_rfq($ID_RFQ)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER,
		RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, RB.NAMA, RB.PERALATAN_PERLENGKAPAN,
        RB.MEREK, RB.SPESIFIKASI_SINGKAT,
        SB.NAMA_SATUAN_BARANG, SB.ID_SATUAN_BARANG,
        J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG
		FROM RASD_FORM as RB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG OR RB.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG OR RB.ID_SATUAN_BARANG = SB.ID_SATUAN_BARANG
		WHERE 
            NOT EXISTS
                (SELECT rfq_form.ID_RASD_FORM, rfq_form.ID_BARANG_MASTER
                 FROM rfq_form WHERE rfq_form.ID_RASD_FORM = RB.ID_RASD_FORM
                AND rfq_form.ID_RFQ = '$ID_RFQ')
        AND NOT EXISTS
        		(SELECT rfq_form.ID_BARANG_MASTER 
                 FROM rfq_form WHERE rfq_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                AND rfq_form.ID_RFQ='$ID_RFQ')
		AND RB.ID_RASD = (SELECT ID_RASD FROM request_for_quotation WHERE ID_RFQ = '$ID_RFQ')");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk mengecek rfq berdasarkan NAMA
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function simpan_data_di_luar_barang_master
	//         2. 
	function cek_nama_barang_quotation_form($NAMA, $ID_QUOTATION)
	{
		$hsl = $this->db->query("SELECT NAMA_BARANG AS NAMA FROM Quotation_form WHERE NAMA_BARANG ='$NAMA' AND ID_QUOTATION ='$ID_QUOTATION' ");
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
		$ID_RFQ,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO rfq_form (
				ID_RFQ,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG)
			VALUES(
				'$ID_RFQ',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel RFQ_form
	//DIPAKAI: 1. controller RFQ_form / function simpan_data_di_luar_barang_master
	//         2. 
	function simpan_data_di_luar_barang_master(
		$ID_RFQ,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO RFQ_form (
				ID_RFQ,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG)
			VALUES(
				'$ID_RFQ',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG' )");
		return $hasil;
	}

	function simpan_data_barang_alternatif_vendor(
		$ID_QUOTATION,
		$ID_QUOTATION_FORM,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$HARGA_SATUAN_BARANG,
		$HARGA_TOTAL,
		$KETERANGAN_VENDOR,
		$KESANGGUPAN_PENGADAAN
	) {
		$hasil = $this->db->query("INSERT INTO quotation_form_alternatif (
				ID_QUOTATION,
				ID_QUOTATION_FORM,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG_ALTERNATIF,
				NAMA_BARANG_ALTERNATIF,
				MEREK_ALTERNATIF,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT_ALTERNATIF,
				JUMLAH_BARANG_ALTERNATIF,
				HARGA_SATUAN_BARANG_ALTERNATIF,
				HARGA_TOTAL_ALTERNATIF,
				KETERANGAN_VENDOR_ALTERNATIF)
			VALUES(
				'$ID_QUOTATION',
				'$ID_QUOTATION_FORM',
				'$ID_BARANG_MASTER',
				'$ID_RASD_FORM',
				'$ID_SATUAN_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG',
				'$HARGA_SATUAN_BARANG',
				'$HARGA_TOTAL',
				'$KETERANGAN_VENDOR' )");

		$hasil2 = $this->db->query("INSERT INTO quotation_form (
				KESANGGUPAN_PENGADAAN)
			VALUES(
				'$KESANGGUPAN_PENGADAAN')");
		return $hasil;
	}

	function simpan_data_di_luar_barang_master_user_vendor(
		$ID_RFQ,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$HARGA_SATUAN_BARANG,
		$KETERANGAN_VENDOR

	) {
		$hasil = $this->db->query("INSERT INTO RFQ_form (
				ID_RFQ,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				HARGA_SATUAN_BARANG,
				KETERANGAN_VENDOR)
			VALUES(
				'$ID_RFQ',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$HARGA_SATUAN_BARANG',
				'$KETERANGAN_VENDOR' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data rfq form berdasarkan ID_RFQ
	//SUMBER TABEL: tabel RFQ_form
	//DIPAKAI: 1. controller RFQ_form / function simpan_data_dari_barang_master
	//         2. 
	function simpan_data_dari_barang_master(
		$ID_RFQ,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO RFQ_form (
				ID_RFQ,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG)
			VALUES(
				'$ID_RFQ',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RFQ form ID_SPPB_FORM
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function get_data
	//         2. controller rfq_form / function hapus_data
	//		   3. controller rfq_form / function update_data
	function get_data_by_id_quotation_form($ID_QUOTATION_FORM) //dipakai
	{
		$hsl = $this->db->query("SELECT 
		QF.ID_QUOTATION_FORM,
		QF.NAMA_BARANG, 
		QF.MEREK, 
		QF.PERALATAN_PERLENGKAPAN, 
		QF.KETERANGAN,
		QF.SPESIFIKASI_SINGKAT, 
		QF.JUMLAH_BARANG,
		QF.HARGA_SATUAN_BARANG,
		QF.HARGA_TOTAL,
		M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, RB.ID_RASD_FORM,
        J.NAMA_JENIS_BARANG,
		J.ID_JENIS_BARANG,
		SB.ID_SATUAN_BARANG,
        SB.NAMA_SATUAN_BARANG
        FROM quotation_form AS QF
        LEFT JOIN barang_master AS M ON QF.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = QF.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = QF.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = QF.ID_SATUAN_BARANG 
        WHERE QF.ID_QUOTATION_FORM = '$ID_QUOTATION_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_QUOTATION_FORM' => $data->ID_QUOTATION_FORM,
					'KODE_BARANG' => $data->KODE_BARANG,
					'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'HARGA_SATUAN_BARANG' => $data->HARGA_SATUAN_BARANG,
					'HARGA_TOTAL' => $data->HARGA_TOTAL,
					'KETERANGAN' => $data->KETERANGAN,
					'ID_SATUAN_BARANG' => $data->ID_SATUAN_BARANG,
					'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
				);
			}
		} else {
			$hasil = "BELUM ADA QUOTATION BARANG";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RFQ form ID_SPPB_FORM
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function get_data
	//         2. controller rfq_form / function hapus_data
	//		   3. controller rfq_form / function update_data
	function get_data_rfq_form_by_id_rfq($ID_RFQ)
	{
		$hasil = $this->db->query("SELECT rfq_form.ID_RFQ_FORM, 
		rfq_form.NAMA_BARANG, 
		rfq_form.MEREK,
		rfq_form.PERALATAN_PERLENGKAPAN,
		rfq_form.KETERANGAN,
		rfq_form.SPESIFIKASI_SINGKAT, 
		rfq_form.JUMLAH_BARANG,
		rfq_form.HARGA_SATUAN_BARANG,
		rfq_form.HARGA_TOTAL,
		M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, RB.ID_RASD_FORM,
        J.NAMA_JENIS_BARANG,
		J.ID_JENIS_BARANG,
		SB.ID_SATUAN_BARANG,
        SB.NAMA_SATUAN_BARANG
        FROM rfq_form
        LEFT JOIN barang_master AS M ON rfq_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = rfq_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = rfq_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = rfq_form.ID_SATUAN_BARANG 
        WHERE rfq_form.ID_RFQ = '$ID_RFQ'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RFQ by ID_RFQ
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function get_data_rfq

	function get_data_rfq_by_id_rfq($ID_RFQ)
	{
		$hsl = $this->db->query("SELECT * 
        FROM request_for_quotation
        WHERE ID_RFQ = '$ID_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RFQ ' => $data->ID_RFQ,
					'HASH_MD5_RFQ' => $data->HASH_MD5_RFQ,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_RASD' => $data->ID_RASD,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_VENDOR' => $data->ID_VENDOR,
					'ID_TERM_OF_PAYMENT' => $data->ID_TERM_OF_PAYMENT,
					'NO_URUT_RFQ' => $data->NO_URUT_RFQ,
					'TOP' => $data->TOP,
					'LOKASI_PENYERAHAN' => $data->LOKASI_PENYERAHAN,
					'TANGGAL_PEMBUATAN_RFQ_JAM' => $data->TANGGAL_PEMBUATAN_RFQ_JAM
				);
			}
		} else {
			$hasil = "BELUM ADA RFQ BARANG";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data rfq form berdasarkan ID_RFQ_FORM
	//SUMBER TABEL: tabel rfq
	//DIPAKAI: 1. controller RFQ_form / function update_data
	//         
	function update_data($ID_RFQ_FORM, $NAMA, $MEREK, $JENIS_BARANG, $PERALATAN_PERLENGKAPAN, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG)
	{
		$hasil = $this->db->query("UPDATE rfq_form SET 
			NAMA_BARANG='$NAMA',
			MEREK='$MEREK',
			ID_JENIS_BARANG='$JENIS_BARANG',
			PERALATAN_PERLENGKAPAN='$PERALATAN_PERLENGKAPAN',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			ID_SATUAN_BARANG='$SATUAN_BARANG',
			JUMLAH_BARANG='$JUMLAH_BARANG'
			WHERE ID_RFQ_FORM='$ID_RFQ_FORM'");
		return $hasil;
	}

	function update_data_CTT_STAFF_PROC_KP($ID_RFQ, $CTT_STAFF_PROC)
	{
		$hasil = $this->db->query("UPDATE request_for_quotation SET 
			CTT_STAFF_PROC='$CTT_STAFF_PROC' 
			WHERE ID_RFQ='$ID_RFQ'");
		return $hasil;
	}

	function update_data_CTT_KASIE($ID_RFQ, $CTT_KASIE)
	{
		$hasil = $this->db->query("UPDATE request_for_quotation SET 
			CTT_KASIE='$CTT_KASIE' 
			WHERE ID_RFQ='$ID_RFQ'");
		return $hasil;
	}

	function update_data_CTT_MANAGER_PROC($ID_RFQ, $CTT_MANAGER_PROC)
	{
		$hasil = $this->db->query("UPDATE request_for_quotation SET 
			CTT_MANAGER_PROC='$CTT_MANAGER_PROC' 
			WHERE ID_RFQ='$ID_RFQ'");
		return $hasil;
	}

	function update_data_CTT_STAFF_PROC_SP($ID_RFQ, $CTT_STAFF_PROC_SP)
	{
		$hasil = $this->db->query("UPDATE request_for_quotation SET 
			CTT_STAFF_PROC_SP='$CTT_STAFF_PROC_SP' 
			WHERE ID_RFQ='$ID_RFQ'");
		return $hasil;
	}

	function update_data_CTT_SUPERVISI_PROC_SP($ID_RFQ, $CTT_SUPERVISI_PROC_SP)
	{
		$hasil = $this->db->query("UPDATE request_for_quotation SET 
			CTT_SUPERVISI_PROC_SP='$CTT_SUPERVISI_PROC_SP' 
			WHERE ID_RFQ='$ID_RFQ'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menghapus data rfq berdasarkan ID_RFQ_FORM
	//SUMBER TABEL: tabel RFQ_form
	//DIPAKAI: 1. controller RFQ_form / function hapus_data
	//         2. 
	function hapus_data_by_id_rfq_form($ID_RFQ_FORM)
	{
		$hasil = $this->db->query("DELETE FROM rfq_form WHERE ID_RFQ_FORM='$ID_RFQ_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data catatat RFQ form berdasarkan ID_RFQFORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_keterangan_barang
	//         2. 
	function get_keterangan_by_id_quotation_form($ID_QUOTATION_FORM)
	{
		$hsl = $this->db->query("SELECT 
		ID_QUOTATION_FORM,
		KETERANGAN

		FROM QUOTATION_FORM

        WHERE ID_QUOTATION_FORM = '$ID_QUOTATION_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_QUOTATION_FORM' => $data->ID_QUOTATION_FORM,
					'KETERANGAN' => $data->KETERANGAN
				);
			}
		} else {
			$hasil = "TIDAK ADA KETERANGAN";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data rfq berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function update_data_keterangan_barang
	//         2. 
	function update_data_keterangan_barang($ID_RFQ_FORM, $KETERANGAN)
	{
		$hasil = $this->db->query("UPDATE rfq_form SET 
			KETERANGAN='$KETERANGAN' 
			WHERE ID_RFQ_FORM='$ID_RFQ_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data rfq berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel rfq_form
	//DIPAKAI: 1. controller rfq_form / function update_data_keterangan_barang
	//         2. 
	function update_data_harga_barang($ID_QUOTATION_FORM, $HARGA_SATUAN_BARANG, $HARGA_TOTAL, $KETERANGAN_INPUT_MANUAL) //DIGUNAKAN
	{
		$hasil = $this->db->query("UPDATE quotation_form SET 
			HARGA_SATUAN_BARANG='$HARGA_SATUAN_BARANG',
			HARGA_TOTAL='$HARGA_TOTAL',
			KETERANGAN_INPUT_MANUAL='$KETERANGAN_INPUT_MANUAL'
			WHERE ID_QUOTATION_FORM='$ID_QUOTATION_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data catatat RFQ form berdasarkan ID_RFQFORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_keterangan_barang
	//         2. 
	function get_keterangan_by_id_rfq($ID_RFQ)
	{
		$hsl = $this->db->query("SELECT 
		*
		FROM RFQ_FORM

        WHERE ID_RFQ = '$ID_RFQ'");
		return $hsl->result();
	}

	function update_data_kirim_email($ID_RFQ, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $ISI_BODY)
	{
		$hasil = $this->db->query("UPDATE request_for_quotation SET 
			NAMA_PIC_VENDOR='$NAMA_PIC_VENDOR',
			EMAIL_PIC_VENDOR='$EMAIL_PIC_VENDOR',
			KIRIM_EMAIL='TERKIRIM',
			ISI_BODY='$ISI_BODY' 
			WHERE ID_RFQ='$ID_RFQ'");
		return $hasil;
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
	// 	sppb_form.TANGGAL_MULAI_PAKAI_HARI,
	// 	sppb_form.TANGGAL_SELESAI_PAKAI_HARI,
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
	function get_data_catatan_sppb_by_id_rfq($ID_SPPB)
	{
		$hsl = $this->db->query("SELECT 
		ID_SPPB, 
		CTT_STAFF_LOG,
		CTT_SPV_LOG,
		CTT_CHIEF,
		CTT_SM,
		CTT_PM,
		CTT_M_LOG,
		CTT_M_PROC,
		CTT_M_SDM,
		CTT_M_KONS,
		CTT_M_EP,
		CTT_M_QAQC,	
		CTT_M_KEU,
		CTT_D_PSDS,
		CTT_D_KONS,
		CTT_D_KEU	

		FROM SPPB

        WHERE ID_SPPB = '$ID_SPPB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SPPB' => $data->ID_SPPB,
					'CTT_STAFF_LOG' => $data->CTT_STAFF_LOG,
					'CTT_SPV_LOG' => $data->CTT_SPV_LOG,
					'CTT_CHIEF' => $data->CTT_CHIEF,
					'CTT_SM' => $data->CTT_SM,
					'CTT_PM' => $data->CTT_PM,
					'CTT_M_LOG' => $data->CTT_M_LOG,

					'CTT_M_PROC' => $data->CTT_M_PROC,
					'CTT_M_SDM' => $data->CTT_M_SDM,
					'CTT_M_KONS' => $data->CTT_M_KONS,
					'CTT_M_EP' => $data->CTT_M_EP,
					'CTT_M_QAQC' => $data->CTT_M_QAQC,
					'CTT_M_KEU' => $data->CTT_M_KEU,

					'CTT_D_PSDS' => $data->CTT_D_PSDS,
					'CTT_D_KONS' => $data->CTT_D_KONS,
					'CTT_D_KEU' => $data->CTT_D_KEU
				);
			}
		} else {
			$hasil = "TIDAK ADA CATATAN";
		}
		return $hasil;
	}

	function get_data_catatan_rfq_by_id_rfq($ID_RFQ)
	{
		$hsl = $this->db->query("SELECT 
		ID_RFQ,
		CTT_STAFF_PROC,
		CTT_KASIE,
		CTT_MANAGER_PROC,
		CTT_STAFF_PROC_SP,
		CTT_SUPERVISI_PROC_SP

		FROM request_for_quotation

        WHERE ID_RFQ = '$ID_RFQ'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RFQ' => $data->ID_RFQ,
					'CTT_STAFF_PROC' => $data->CTT_STAFF_PROC,
					'CTT_KASIE' => $data->CTT_KASIE,
					'CTT_MANAGER_PROC' => $data->CTT_MANAGER_PROC,
					'CTT_STAFF_PROC_SP' => $data->CTT_STAFF_PROC_SP,
					'CTT_SUPERVISI_PROC_SP' => $data->CTT_SUPERVISI_PROC_SP,
				);
			}
		} else {
			$hasil = "TIDAK ADA CATATAN";
		}
		return $hasil;
	}

	function users_by_id_vendor($ID_VENDOR)
	{
		$hasil = $this->db->query("SELECT username, password, expired FROM users WHERE ID_VENDOR = '$ID_VENDOR'");
		return $hasil;
	}

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

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB
	// //SUMBER TABEL: tabel sppb
	// //DIPAKAI: 1. controller SPPB_form / function update_data_catatan_sppb
	// //         2. 
	// function update_data_CTT_STAFF_LOG($ID_SPPB, $CTT_STAFF_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_STAFF_LOG='$CTT_STAFF_LOG' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB
	// //SUMBER TABEL: tabel sppb
	// //DIPAKAI: 1. controller SPPB_form / function update_data_catatan_sppb
	// //         2. 
	// function update_data_CTT_SPV_LOG($ID_SPPB, $CTT_SPV_LOG)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_SPV_LOG='$CTT_SPV_LOG' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }

	// //FUNGSI: Fungsi ini untuk mengubah data sppb form ID_SPPB
	// //SUMBER TABEL: tabel sppb
	// //DIPAKAI: 1. controller SPPB_form / function update_data_catatan_sppb
	// //         2. 
	// function update_data_CTT_CHIEF($ID_SPPB, $CTT_CHIEF)
	// {
	// 	$hasil = $this->db->query("UPDATE sppb SET 
	// 		CTT_CHIEF='$CTT_CHIEF' 
	// 		WHERE ID_SPPB='$ID_SPPB'");
	// 	return $hasil;
	// }



	//FUNGSI: Fungsi ini untuk mengubah data RFQ form by ID_RFQ
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function update_data_kirim_sppb
	//         2. 
	function update_data_kirim_rfq($ID_SPPB, $PROGRESS_SPPB, $STATUS_SPPB)
	{
		$hasil = $this->db->query("UPDATE sppb SET 
			PROGRESS_SPPB='$PROGRESS_SPPB',
			STATUS_SPPB='$STATUS_SPPB' 
			WHERE ID_SPPB='$ID_SPPB'");
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
	function user_log_rfq_form($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_rfq_form (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
