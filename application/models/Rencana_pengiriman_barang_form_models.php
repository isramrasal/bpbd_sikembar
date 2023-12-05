<?php
class Rencana_pengiriman_barang_form_models extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh po form
	//SUMBER TABEL: tabel po_form
	//DIPAKAI: 1. controller po_form / function data_po_form
	//         2. 
	function rpb_form_list_by_id_rpb($ID_RENCANA_PENGIRIMAN_BARANG)
	{
		$hasil = $this->db->query("SELECT 
		RPB_Form.ID_PO, RPB_Form.ID_RENCANA_PENGIRIMAN_BARANG_FORM, RPB_Form.ID_RENCANA_PENGIRIMAN_BARANG,
		RPB_Form.ID_BARANG_MASTER, RPB_Form.ID_SATUAN_BARANG, RPB_Form.ID_JENIS_BARANG,
		RPB_Form.NAMA_BARANG, RPB_Form.MEREK,
		RPB_Form.SPESIFIKASI_SINGKAT, 
		RPB_Form.JUMLAH_BARANG,
		RPB_Form.JUMLAH_BARANG_KIRIM,
		RPB_Form.KETERANGAN,
		RPB_Form.HARGA_SATUAN_BARANG_FIX,
		RPB_Form.HARGA_TOTAL_FIX,
		M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG
        FROM rencana_pengiriman_barang_form as RPB_Form
        LEFT JOIN barang_master AS M ON RPB_Form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN rencana_pengiriman_barang AS RPB ON RPB.ID_RENCANA_PENGIRIMAN_BARANG  = RPB_Form.ID_RENCANA_PENGIRIMAN_BARANG
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = RPB_Form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = RPB_Form.ID_SATUAN_BARANG 
        WHERE RPB_Form.ID_RENCANA_PENGIRIMAN_BARANG = '$ID_RENCANA_PENGIRIMAN_BARANG'");
		return $hasil->result();
	}

	function simpan_perubahan_pdf($ID_RENCANA_PENGIRIMAN_BARANG, $KEPADA, $NAMA_PENGIRIM, $TUJUAN, $PROGRESS_RPB)
	{
		$hasil = $this->db->query("UPDATE rencana_pengiriman_barang SET 
			KEPADA='$KEPADA',
			NAMA_PENGIRIM='$NAMA_PENGIRIM',
			TUJUAN='$TUJUAN',
			PROGRESS_RPB='$PROGRESS_RPB'
			WHERE ID_RENCANA_PENGIRIMAN_BARANG='$ID_RENCANA_PENGIRIMAN_BARANG'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data PO form ID_SPPB_FORM
	//SUMBER TABEL: tabel po_form
	//DIPAKAI: 1. controller po_form / function get_data
	//         2. controller po_form / function hapus_data
	//		   3. controller po_form / function update_data
	function get_data_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM)
	{
		$hsl = $this->db->query("SELECT rpb_form.ID_RENCANA_PENGIRIMAN_BARANG_FORM, rpb_form.NAMA_BARANG, rpb_form.MEREK,  rpb_form.KETERANGAN,
		rpb_form.SPESIFIKASI_SINGKAT, 
		rpb_form.JUMLAH_BARANG,
		rpb_form.ID_JENIS_BARANG,
		rpb_form.ID_SATUAN_BARANG,
		rpb_form.SPESIFIKASI_SINGKAT,
		rpb_form.JUMLAH_BARANG_KIRIM,
		rpb_form.HARGA_SATUAN_BARANG_FIX,
		rpb_form.HARGA_TOTAL_FIX,
		M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG
        FROM rencana_pengiriman_barang_form as rpb_form
        LEFT JOIN barang_master AS M ON rpb_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = rpb_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = rpb_form.ID_SATUAN_BARANG 
        WHERE rpb_form.ID_RENCANA_PENGIRIMAN_BARANG_FORM = '$ID_RENCANA_PENGIRIMAN_BARANG_FORM'");
		if ($hsl->num_rows() > 0) {	
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RENCANA_PENGIRIMAN_BARANG_FORM' => $data->ID_RENCANA_PENGIRIMAN_BARANG_FORM,
					'KODE_BARANG' => $data->KODE_BARANG,
					'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'KETERANGAN' => $data->KETERANGAN,
					'ID_SATUAN_BARANG' => $data->ID_SATUAN_BARANG,
					'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
					'JUMLAH_BARANG_KIRIM' => $data->JUMLAH_BARANG_KIRIM,
					'HARGA_SATUAN_BARANG_FIX' => $data->HARGA_SATUAN_BARANG_FIX,
					'HARGA_TOTAL_FIX' => $data->HARGA_TOTAL_FIX,
				);
			}
		} else {
			$hasil = "BELUM ADA RPB BARANG";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data catatat PO form berdasarkan ID_POFORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_keterangan_barang
	//         2. 
	function get_keterangan_by_id_rpb_form($ID_RENCANA_PENGIRIMAN_BARANG_FORM)
	{
		$hsl = $this->db->query("SELECT 
		ID_RENCANA_PENGIRIMAN_BARANG_FORM, 
		KETERANGAN

		FROM rencana_pengiriman_barang_form

        WHERE ID_RENCANA_PENGIRIMAN_BARANG_FORM = '$ID_RENCANA_PENGIRIMAN_BARANG_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RENCANA_PENGIRIMAN_BARANG_FORM' => $data->ID_RENCANA_PENGIRIMAN_BARANG_FORM,
					'KETERANGAN' => $data->KETERANGAN
				);
			}
		} else {
			$hasil = "TIDAK ADA KETERANGAN";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data po berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel po_form
	//DIPAKAI: 1. controller po_form / function update_data_keterangan_barang
	//         2. 
	function update_data_jumlah_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $JUMLAH_BARANG_KIRIM, $JUMLAH_BARANG)
	{
		$hasil = $this->db->query("UPDATE rencana_pengiriman_barang_form SET 
			JUMLAH_BARANG_KIRIM='$JUMLAH_BARANG_KIRIM',
			JUMLAH_BARANG='$JUMLAH_BARANG'
			WHERE ID_RENCANA_PENGIRIMAN_BARANG_FORM='$ID_RENCANA_PENGIRIMAN_BARANG_FORM'");
		return $hasil;
	}

	function update_data_harga_barang($ID_RENCANA_PENGIRIMAN_BARANG_FORM, $HARGA_SATUAN_BARANG_FIX, $HARGA_TOTAL_FIX)
	{
		$hasil = $this->db->query("UPDATE rencana_pengiriman_barang_form SET 
			HARGA_SATUAN_BARANG_FIX='$HARGA_SATUAN_BARANG_FIX',
			HARGA_TOTAL_FIX='$HARGA_TOTAL_FIX'
			WHERE ID_RENCANA_PENGIRIMAN_BARANG_FORM='$ID_RENCANA_PENGIRIMAN_BARANG_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data PO form by ID_PO
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function update_data_kirim_sppb
	//         2. 
	function update_data_kirim_rpb($ID_RENCANA_PENGIRIMAN_BARANG, $STATUS_RPB, $PROGRESS_RPB)
	{
		$hasil = $this->db->query("UPDATE rencana_pengiriman_barang SET 
			STATUS_RPB='$STATUS_RPB',
			PROGRESS_RPB='$PROGRESS_RPB'
			WHERE ID_RENCANA_PENGIRIMAN_BARANG='$ID_RENCANA_PENGIRIMAN_BARANG'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_USER
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function logout
	//         2. controller SPPB_form / function user_log
	function user_log_rpb_form($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_rpb_form (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
