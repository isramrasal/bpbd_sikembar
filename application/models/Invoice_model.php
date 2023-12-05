<?php
class Invoice_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb yang barangnya tidak ada di gudang
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller PO / function index
	//         2. 
	function po_list_invoice()
	{
		$hasil = $this->db->query("SELECT PO.ID_PO, PO.NO_URUT_PO, P.NAMA_PROYEK, PO.TANGGAL_KIRIM_BARANG_HARI, PO.HASH_MD5_PO, PO.PROGRESS_PO
		from po AS PO
		LEFT JOIN proyek as P on P.ID_PROYEK = PO.ID_PROYEK");
		return $hasil->result();
	}

	function po_list_invoice_by_id_vendor($ID_VENDOR)
	{
		$hasil = $this->db->query("SELECT PO.ID_PO, PO.NO_URUT_PO, P.NAMA_PROYEK, PO.TANGGAL_KIRIM_BARANG_HARI, PO.HASH_MD5_PO, PO.PROGRESS_PO, PO.ID_VENDOR, PO.TANGGAL_DOKUMEN_PO
		from po AS PO
		LEFT JOIN proyek as P on P.ID_PROYEK = PO.ID_PROYEK
		WHERE PO.ID_VENDOR = '$ID_VENDOR'");
		return $hasil->result();
	}
	//  WHERE SF.GUDANG_TERSEDIA = 'TIDAK'
	// LEFT JOIN rencana_pengiriman_barang AS R on PF.ID_PO = P.ID_PO 

	function sppb_list_po_by_hashmd5($HASH_MD5_SPPB)
	{
		$hasil = $this->db->query("SELECT DISTINCT SF.ID_SPPB, S.NO_URUT_SPPB, P.NAMA_PROYEK, S.TANGGAL_PEMBUATAN_SPPB_HARI, S.HASH_MD5_SPPB from sppb_form as SF LEFT JOIN sppb AS S on S.ID_SPPB = SF.ID_SPPB LEFT JOIN proyek as P on P.ID_PROYEK = S.ID_PROYEK WHERE( SF.GUDANG_TERSEDIA = 'TIDAK' AND S.HASH_MD5_SPPB = '$HASH_MD5_SPPB')");
		return $hasil->result();
	}

	function po_list_by_ID_VENDOR($ID_VENDOR)
	{

		$hasil = $this->db->query("SELECT * from po WHERE ( ID_VENDOR = '$ID_VENDOR')");
		return $hasil->result();
	}

	function get_data_po_by_HASH_MD5_VENDOR_INVOICE($HASH_MD5_VENDOR_INVOICE)
	{
		$hsl = $this->db->query("SELECT 
		PO.ID_PO,
        PO.HASH_MD5_PO,
        PO.ID_SPPB,
        PO.ID_RASD,
        PO.ID_VENDOR,
		PO.ID_TERM_OF_PAYMENT,
        PO.ID_SPP,
        PO.NO_URUT_PO,
        PO.PROGRESS_PO,
        PO.TOP,
        PO.JUMLAH_COUNT,
		PO.PERALATAN_PERLENGKAPAN,
        PO.TANGGAL_PEMBUATAN_PO_JAM,
        PO.TANGGAL_PEMBUATAN_PO_HARI,
        PO.TANGGAL_PEMBUATAN_PO_BULAN,
        PO.TANGGAL_PEMBUATAN_PO_TAHUN,
		PO.TANGGAL_KIRIM_BARANG_HARI,
        PO.CTT_KEPERLUAN,
        PO.KETERANGAN_RFQ,
        PO.CTT_STAFF_PROC,
        PO.CTT_KASIE,
        PO.CTT_MANAGER_PROC,
        PO.CREATE_BY_USER,
        PO.BATAS_AKHIR,
		PO.ID_PROYEK_LOKASI_PENYERAHAN,
        PO.LOKASI_PENYERAHAN,
        PO.ID_PROYEK,
        PO.TOTAL_HARGA_PO_BARANG,
        PO.TERBILANG,
		VI.ID_PO,
        VI.HASH_MD5_VENDOR_INVOICE,
		VI.ID_VENDOR,
		VI.ID_VENDOR_INVOICE,
		VI.NO_INVOICE,
		VI.TANGGAL_PENYERAHAN_HARI
        
        FROM vendor_invoice AS VI
        LEFT JOIN PO AS PO ON VI.ID_PO = PO.ID_PO
        WHERE VI.HASH_MD5_VENDOR_INVOICE = '$HASH_MD5_VENDOR_INVOICE'");

		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PO' => $data->ID_PO,
					'ID_SPP' => $data->ID_SPP,
					'HASH_MD5_PO' => $data->HASH_MD5_PO,
					'NO_URUT_PO' => $data->NO_URUT_PO,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'ID_SPPB' => $data->ID_SPPB,
					'PROGRESS_PO' => $data->PROGRESS_PO,
					'CTT_KEPERLUAN' => $data->CTT_KEPERLUAN,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_VENDOR' => $data->ID_VENDOR,
					'ID_TERM_OF_PAYMENT' => $data->ID_TERM_OF_PAYMENT,
					'ID_PROYEK_LOKASI_PENYERAHAN' => $data->ID_PROYEK_LOKASI_PENYERAHAN,
					'LOKASI_PENYERAHAN' => $data->LOKASI_PENYERAHAN,
					'BATAS_AKHIR' => $data->BATAS_AKHIR,
					'TANGGAL_KIRIM_BARANG_HARI' => $data->TANGGAL_KIRIM_BARANG_HARI,
					'HASH_MD5_VENDOR_INVOICE' => $data->HASH_MD5_VENDOR_INVOICE,
					'NO_INVOICE' => $data->NO_INVOICE,
					'ID_VENDOR_INVOICE' => $data->ID_VENDOR_INVOICE,
					'TANGGAL_PENYERAHAN_HARI' => $data->TANGGAL_PENYERAHAN_HARI
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut PO  berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel po
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut
	//         2. 
	function get_nomor_urut_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT MAX(RPB.JUMLAH_COUNT) AS JUMLAH_COUNT FROM rencana_pengiriman_barang AS RPB WHERE RPB.ID_PROYEK ='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'JUMLAH_COUNT' => $data->JUMLAH_COUNT
				);
			}
		} else {
			$hasil = "BELUM ADA PO";
		}
		return $hasil;
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

	function get_list_invoice_by_id_po($ID_PO)
	{
		$hsl = $this->db->query("SELECT * FROM vendor_invoice WHERE ID_PO ='$ID_PO'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function cek_no_urut_invoice($NO_INVOICE)
	{
		$hsl = $this->db->query("SELECT ID_VENDOR_INVOICE , HASH_MD5_VENDOR_INVOICE, NO_INVOICE FROM vendor_invoice WHERE NO_INVOICE ='$NO_INVOICE'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_VENDOR_INVOICE' => $data->ID_VENDOR_INVOICE,
					'HASH_MD5_VENDOR_INVOICE' => $data->HASH_MD5_VENDOR_INVOICE,
					'NO_INVOICE' => $data->NO_INVOICE
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
	function simpan_data_invoice(
		$ID_PO,
		$ID_VENDOR,
		$NO_INVOICE,
		$HARGA_INVOICE,
		$TANGGAL_PENYERAHAN_HARI
	) {
		$hasil = $this->db->query(
			"INSERT INTO vendor_invoice
			(
				ID_PO,
				ID_VENDOR,
				NO_INVOICE,
				HARGA_INVOICE,
				TANGGAL_PENYERAHAN_HARI
			)
			VALUES
			(
				'$ID_PO',
				'$ID_VENDOR',
				'$NO_INVOICE',
				'$HARGA_INVOICE',
				'$TANGGAL_PENYERAHAN_HARI'
			)"
		);

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengeset HASH_MD5_SPPB berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function set_md5_id_invoice($ID_VENDOR, $ID_PO, $NO_INVOICE)
	{
		$hsl = $this->db->query("SELECT ID_VENDOR_INVOICE FROM vendor_invoice WHERE ID_VENDOR = '$ID_VENDOR' AND
		ID_PO='$ID_PO' AND NO_INVOICE='$NO_INVOICE'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_VENDOR_INVOICE' => $data->ID_VENDOR_INVOICE
				);
			}
		} else {
			$hasil = "BELUM ADA INVOICE";
		}
		$ID_VENDOR_INVOICE = $hasil['ID_VENDOR_INVOICE'];
		$HASH_MD5_VENDOR_INVOICE = md5($ID_VENDOR_INVOICE);
		$hasil = $this->db->query("UPDATE vendor_invoice SET HASH_MD5_VENDOR_INVOICE='$HASH_MD5_VENDOR_INVOICE' WHERE ID_VENDOR_INVOICE='$ID_VENDOR_INVOICE'");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut sppb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut_by_id_proyek
	//         2. 
	function get_data_proyek_by_hash_md5_po($HASH_MD5_PO)
	{
		$hsl = $this->db->query("SELECT PO.ID_PO, PO.ID_PROYEK, PO.NO_URUT_PO, PO.ID_RASD, PO.ID_SPPB, PO.ID_PROYEK_LOKASI_PENYERAHAN, P.NAMA_PROYEK, P.LOKASI, P.INISIAL, V.ID_VENDOR, V.NAMA_VENDOR from po as PO 
		LEFT JOIN proyek AS P ON PO.ID_PROYEK = P.ID_PROYEK
		LEFT JOIN vendor AS V ON PO.ID_VENDOR = V.ID_VENDOR
		WHERE PO.HASH_MD5_PO = '$HASH_MD5_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PO' => $data->ID_PO,
					'ID_PROYEK' => $data->ID_PROYEK,
					'NO_URUT_PO' => $data->NO_URUT_PO,
					'ID_RASD' => $data->ID_RASD,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK_LOKASI_PENYERAHAN' => $data->ID_PROYEK_LOKASI_PENYERAHAN,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'LOKASI' => $data->LOKASI,
					'INISIAL' => $data->INISIAL,
					'ID_VENDOR' => $data->ID_VENDOR,
					'NAMA_VENDOR' => $data->NAMA_VENDOR,
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
	function get_data_invoice_baru($ID_VENDOR, $NO_INVOICE)
	{
		$hsl = $this->db->query("SELECT * FROM vendor_invoice WHERE ID_VENDOR = '$ID_VENDOR' AND
		NO_INVOICE= '$NO_INVOICE'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_VENDOR_INVOICE' => $data->HASH_MD5_VENDOR_INVOICE
				);
			}
		} else {
			$hasil = "BELUM ADA INVOICE";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data PO berdasarkan ID_PO
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller PO_form / function index

	function rpb_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG)
	{
		$hasil = $this->db->query("SELECT * FROM rencana_pengiriman_barang WHERE ID_RENCANA_PENGIRIMAN_BARANG = '$ID_RENCANA_PENGIRIMAN_BARANG'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data po form berdasarkan ID_PO_FORM
	//SUMBER TABEL: tabel po
	//DIPAKAI: 1. controller PO_form / function simpan_perubahan_pdf
	//         
	function simpan_perubahan_pdf($ID_PO, $ID_SPP, $ID_PROYEK_LOKASI_PENYERAHAN, $ID_VENDOR, $ID_TERM_OF_PAYMENT, $PERALATAN_PERLENGKAPAN, $PROGRESS_PO, $TANGGAL_KIRIM_BARANG_HARI)
	{
		$hasil = $this->db->query("UPDATE po SET 
			ID_PROYEK_LOKASI_PENYERAHAN='$ID_PROYEK_LOKASI_PENYERAHAN',
			ID_SPP='$ID_SPP',
			ID_VENDOR='$ID_VENDOR',
			ID_TERM_OF_PAYMENT='$ID_TERM_OF_PAYMENT',
			PERALATAN_PERLENGKAPAN='$PERALATAN_PERLENGKAPAN',
			PROGRESS_PO='$PROGRESS_PO',
			TANGGAL_KIRIM_BARANG_HARI='$TANGGAL_KIRIM_BARANG_HARI'
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
	function user_log_rpb($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_rpb (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
