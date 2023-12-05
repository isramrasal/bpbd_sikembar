<?php
class Rencana_pengiriman_barang_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb yang barangnya tidak ada di gudang
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller PO / function index
	//         2. 
	function po_list_rpb()
	{
		$hasil = $this->db->query("SELECT PO.ID_PO, PO.NO_URUT_PO, P.NAMA_PROYEK, PO.TANGGAL_KIRIM_BARANG_HARI, PO.HASH_MD5_PO, PO.PROGRESS_PO
		from po AS PO
		LEFT JOIN proyek as P on P.ID_PROYEK = PO.ID_PROYEK");
		return $hasil->result();
	}

	function po_list_rpb_by_id_vendor($ID_VENDOR)
	{
		$hasil = $this->db->query("SELECT PO.ID_PO, PO.NO_URUT_PO, P.NAMA_PROYEK, PO.TANGGAL_KIRIM_BARANG_HARI, PO.HASH_MD5_PO, PO.PROGRESS_PO, PO.ID_VENDOR
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

	function rpb_list_rpb_by_hashmd5($HASH_MD5_RENCANA_PENGIRIMAN_BARANG)
	{

		$hasil = $this->db->query("SELECT * from rencana_pengiriman_barang WHERE ( HASH_MD5_RENCANA_PENGIRIMAN_BARANG = '$HASH_MD5_RENCANA_PENGIRIMAN_BARANG')");
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


	function get_data_rpb_by_HASH_MD5_RENCANA_PENGIRIMAN_BARANG($HASH_MD5_RENCANA_PENGIRIMAN_BARANG)
	{
		$hsl = $this->db->query("SELECT 
		RPB.ID_RENCANA_PENGIRIMAN_BARANG ,
        RPB.HASH_MD5_RENCANA_PENGIRIMAN_BARANG,
        RPB.ID_PO,
        RPB.NO_RENCANA_PENGIRIMAN_BARANG,
        RPB.JUMLAH_COUNT,
		RPB.TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
        RPB.CREATE_BY_USER,
		RPB.ID_PROYEK_LOKASI_PENYERAHAN,
        RPB.NAMA_LOKASI_PENYERAHAN,
        RPB.STATUS_RPB,
        RPB.PROGRESS_RPB,
        RPB.ID_PROYEK
        
        FROM rencana_pengiriman_barang AS RPB
        WHERE RPB.HASH_MD5_RENCANA_PENGIRIMAN_BARANG = '$HASH_MD5_RENCANA_PENGIRIMAN_BARANG'");

		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RENCANA_PENGIRIMAN_BARANG' => $data->ID_RENCANA_PENGIRIMAN_BARANG,
					'HASH_MD5_RENCANA_PENGIRIMAN_BARANG' => $data->HASH_MD5_RENCANA_PENGIRIMAN_BARANG,
					'ID_PO' => $data->ID_PO,
					'NO_RENCANA_PENGIRIMAN_BARANG' => $data->NO_RENCANA_PENGIRIMAN_BARANG,
					'JUMLAH_COUNT' => $data->JUMLAH_COUNT,
					'TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI' => $data->TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
					'CREATE_BY_USER' => $data->CREATE_BY_USER,
					'ID_PROYEK_LOKASI_PENYERAHAN' => $data->ID_PROYEK_LOKASI_PENYERAHAN,
					'NAMA_LOKASI_PENYERAHAN' => $data->NAMA_LOKASI_PENYERAHAN,
					'STATUS_RPB' => $data->STATUS_RPB,
					'PROGRESS_RPB' => $data->PROGRESS_RPB,
					'ID_PROYEK' => $data->ID_PROYEK
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

	function get_list_rpb_by_id_po($ID_PO)
	{
		$hsl = $this->db->query("SELECT * FROM rencana_pengiriman_barang WHERE ID_PO ='$ID_PO'");
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

	function cek_no_urut_rencana_pengiriman_barang($NO_RENCANA_PENGIRIMAN_BARANG)
	{
		$hsl = $this->db->query("SELECT ID_RENCANA_PENGIRIMAN_BARANG , HASH_MD5_RENCANA_PENGIRIMAN_BARANG, NO_RENCANA_PENGIRIMAN_BARANG FROM rencana_pengiriman_barang WHERE NO_RENCANA_PENGIRIMAN_BARANG ='$NO_RENCANA_PENGIRIMAN_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RENCANA_PENGIRIMAN_BARANG' => $data->ID_RENCANA_PENGIRIMAN_BARANG,
					'HASH_MD5_RENCANA_PENGIRIMAN_BARANG' => $data->HASH_MD5_RENCANA_PENGIRIMAN_BARANG,
					'NO_RENCANA_PENGIRIMAN_BARANG' => $data->NO_RENCANA_PENGIRIMAN_BARANG
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
	function simpan_data_rpb(
		$ID_PO,
		$ID_PROYEK,
		$ID_VENDOR,
		$ID_SPPB,
		$ID_PROYEK_LOKASI_PENYERAHAN,
		$JUMLAH_COUNT,
		$NO_URUT_PO,
		$NO_RENCANA_PENGIRIMAN_BARANG,
		$TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
		$CREATE_BY_USER,
		$NAMA_PENGIRIM,
		$NO_HP_PENGIRIM,
		$KEPADA,
		$TUJUAN
	) {
		$hasil = $this->db->query(
			"INSERT INTO rencana_pengiriman_barang
			(
				ID_PO,
				ID_PROYEK,
				ID_VENDOR,
				ID_SPPB,
				ID_PROYEK_LOKASI_PENYERAHAN,
				JUMLAH_COUNT,
				NO_URUT_PO,
				NO_RENCANA_PENGIRIMAN_BARANG,
				TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI,
				CREATE_BY_USER,
				NAMA_PENGIRIM,
				NO_HP_PENGIRIM,
				KEPADA,
				TUJUAN
			)
			VALUES
			(
				'$ID_PO',
				'$ID_PROYEK',
				'$ID_VENDOR',
				'$ID_SPPB',
				'$ID_PROYEK_LOKASI_PENYERAHAN',
				'$JUMLAH_COUNT',
				'$NO_URUT_PO',
				'$NO_RENCANA_PENGIRIMAN_BARANG',
				'$TANGGAL_RENCANA_PENGIRIMAN_BARANG_HARI',
				'$CREATE_BY_USER',
				'$NAMA_PENGIRIM',
				'$NO_HP_PENGIRIM',
				'$KEPADA',
				'$TUJUAN'
				
			)"
		);

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengeset HASH_MD5_SPPB berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function set_md5_id_RPB($ID_PROYEK, $ID_PO, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT ID_RENCANA_PENGIRIMAN_BARANG FROM rencana_pengiriman_barang WHERE ID_PROYEK='$ID_PROYEK' AND
		ID_PO='$ID_PO' AND NO_RENCANA_PENGIRIMAN_BARANG='$NO_RENCANA_PENGIRIMAN_BARANG' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RENCANA_PENGIRIMAN_BARANG' => $data->ID_RENCANA_PENGIRIMAN_BARANG
				);
			}
		} else {
			$hasil = "BELUM ADA RPB";
		}
		$ID_RENCANA_PENGIRIMAN_BARANG = $hasil['ID_RENCANA_PENGIRIMAN_BARANG'];
		$HASH_MD5_RENCANA_PENGIRIMAN_BARANG = md5($ID_RENCANA_PENGIRIMAN_BARANG);
		$hasil = $this->db->query("UPDATE rencana_pengiriman_barang SET HASH_MD5_RENCANA_PENGIRIMAN_BARANG='$HASH_MD5_RENCANA_PENGIRIMAN_BARANG' WHERE ID_RENCANA_PENGIRIMAN_BARANG='$ID_RENCANA_PENGIRIMAN_BARANG'");

		$hsl_2 = $this->db->query("SELECT ID_PO_FORM, ID_PO, ID_RASD_FORM, ID_BARANG_MASTER, ID_SATUAN_BARANG, ID_JENIS_BARANG, NAMA_BARANG, MEREK, SPESIFIKASI_SINGKAT, HARGA_SATUAN_BARANG_FIX, JUMLAH_BARANG, HARGA_TOTAL_FIX
		FROM po_form
		WHERE po_form.ID_PO = '$ID_PO'");
		if ($hsl_2->num_rows() > 0) {
			foreach ($hsl_2->result() as $data) {
				$hasil_2 = array(
					'ID_PO_FORM' => $data->ID_PO_FORM,
					'ID_PO' => $data->ID_PO,
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'ID_SATUAN_BARANG' => $data->ID_SATUAN_BARANG,
					'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'HARGA_SATUAN_BARANG_FIX' => $data->HARGA_SATUAN_BARANG_FIX,
					'HARGA_TOTAL_FIX' => $data->HARGA_TOTAL_FIX
				);

				$this->db->query(
					"INSERT INTO rencana_pengiriman_barang_form (ID_RENCANA_PENGIRIMAN_BARANG, ID_PO_FORM, ID_PO, ID_RASD_FORM, ID_BARANG_MASTER, ID_SATUAN_BARANG, ID_JENIS_BARANG, NAMA_BARANG, MEREK, SPESIFIKASI_SINGKAT, JUMLAH_BARANG, HARGA_SATUAN_BARANG_FIX, HARGA_TOTAL_FIX)
					VALUES ('$ID_RENCANA_PENGIRIMAN_BARANG', '$data->ID_PO_FORM', '$data->ID_PO', '$data->ID_RASD_FORM', '$data->ID_BARANG_MASTER', '$data->ID_SATUAN_BARANG', '$data->ID_JENIS_BARANG', '$data->NAMA_BARANG', '$data->MEREK' , '$data->SPESIFIKASI_SINGKAT', '$data->JUMLAH_BARANG', '$data->HARGA_SATUAN_BARANG_FIX', '$data->HARGA_TOTAL_FIX')"
				);
			}
		}

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
	function get_data_rpb_baru($ID_PROYEK, $NO_RENCANA_PENGIRIMAN_BARANG, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT * FROM rencana_pengiriman_barang WHERE ID_PROYEK = '$ID_PROYEK' AND
		NO_RENCANA_PENGIRIMAN_BARANG= '$NO_RENCANA_PENGIRIMAN_BARANG' AND
		CREATE_BY_USER = '$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_RENCANA_PENGIRIMAN_BARANG' => $data->HASH_MD5_RENCANA_PENGIRIMAN_BARANG
				);
			}
		} else {
			$hasil = "BELUM ADA RPB";
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
