<?php
class PO_form_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh po form
	//SUMBER TABEL: tabel po_form
	//DIPAKAI: 1. controller po_form / function data_po_form
	//         2. 
	function po_form_list_by_id_po($ID_PO)
	{
		$hasil = $this->db->query("SELECT 
		po_form.ID_PO, 
		po_form.ID_SPP, 
		po_form.ID_PO_FORM, 
		po_form.NAMA_BARANG, 
		po_form.MEREK,
		po_form.PERALATAN_PERLENGKAPAN,
		po_form.SPESIFIKASI_SINGKAT, 
		po_form.JUMLAH_BARANG,
		po_form.KETERANGAN_BARANG_PO,
		po_form.HARGA_SATUAN_BARANG_FIX,
		po_form.HARGA_TOTAL_FIX,
		po_form.ID_KLASIFIKASI_BARANG,
		po_form.SATUAN_BARANG,
		KB.NAMA_KLASIFIKASI_BARANG,
		KB.KODE_KLASIFIKASI_BARANG,
		M.ID_BARANG_MASTER, 
		M.KODE_BARANG, 
		M.HASH_MD5_BARANG_MASTER,
        RB.ID_PO, 
		RB.ID_PO_FORM,
		po.TOTAL_HARGA_PO_BARANG,
        po.TOTAL_PAJAK_PO_BARANG,
        po.TOTAL_ALL_PO_BARANG,
		P.ID_PAJAK,
		P.TARIF_PAJAK,
		P.SATUAN,
		P.KETERANGAN
        FROM po_form
		LEFT JOIN po AS po ON po.ID_PO = po_form.ID_PO
        LEFT JOIN barang_master AS M ON po_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN po_form AS RB ON RB.ID_PO_FORM = po_form.ID_PO_FORM 
		LEFT JOIN pajak AS P ON P.ID_PAJAK = po_form.ID_PAJAK
		LEFT JOIN klasifikasi_barang AS KB ON KB.ID_KLASIFIKASI_BARANG = po_form.ID_KLASIFIKASI_BARANG
        WHERE RB.ID_PO = '$ID_PO'");
		return $hasil->result();
	} //LEFT JOIN po_form harusnya ke po (induk)

	function sign_po_by_id_po_non_result($ID_PO)
	{
		$hasil = $this->db->query("SELECT
		SIGN_USER_M_PROC,
		SIGN_USER_KASIE_PROC
        FROM po
        WHERE ID_PO = '$ID_PO'");
		return $hasil;
	}

	function pajak_by_id_po_non_result($ID_PO)
	{
		$hasil = $this->db->query("SELECT
		P.ID_PAJAK,
		P.TARIF_PAJAK,
		P.SATUAN,
        p.KETERANGAN,
		p.LABEL
        FROM po_form
		LEFT JOIN pajak AS P ON P.ID_PAJAK = po_form.ID_PAJAK
        WHERE po_form.ID_PO = '$ID_PO'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data BARANG MASTER berdasarkan ID_PO
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller po_form / function index
	//         2. 
	function barang_master_where_not_in_po_and_rasd($ID_PO)
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.KODE_BARANG, M.MEREK, M.HASH_MD5_BARANG_MASTER, M.PERALATAN_PERLENGKAPAN,
		J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, M.SPESIFIKASI_SINGKAT, SB.NAMA_SATUAN_BARANG,
		M.ID_BARANG_MASTER, SB.ID_SATUAN_BARANG 
		FROM barang_master as M
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
        WHERE 
        	NOT EXISTS 
            	(SELECT ID_BARANG_MASTER 
				FROM RASD_FORM 
				WHERE RASD_FORM.ID_BARANG_MASTER = M.ID_BARANG_MASTER 
				AND RASD_FORM.ID_RASD = (SELECT ID_RASD FROM po WHERE ID_PO = '$ID_PO'))
           	AND
            NOT EXISTS
            	(SELECT ID_BARANG_MASTER
                 FROM po_form
                 WHERE po_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                 AND po_form.ID_PO = '$ID_PO')
            	");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_PO
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller PO_form / function index
	//         2. 
	function rasd_form_list_where_not_in_po($ID_PO)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER,
		RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, RB.NAMA,
        RB.MEREK, RB.SPESIFIKASI_SINGKAT,
        SB.NAMA_SATUAN_BARANG, SB.ID_SATUAN_BARANG,
        J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG
		FROM RASD_FORM as RB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG
		WHERE 
            NOT EXISTS
                (SELECT po_form.ID_RASD_FORM, po_form.ID_BARANG_MASTER
                 FROM po_form WHERE po_form.ID_RASD_FORM = RB.ID_RASD_FORM
                AND po_form.ID_PO = '$ID_PO')
        AND NOT EXISTS
        		(SELECT po_form.ID_BARANG_MASTER 
                 FROM po_form WHERE po_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                AND po_form.ID_PO='$ID_PO')
		AND RB.ID_RASD = (SELECT ID_RASD FROM po WHERE ID_PO = '$ID_PO')");
		return $hasil->result();
	}

	function spp_form_list_where_not_in_po($ID_PO, $ID_SPP, $ID_VENDOR)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER, SP.ID_SPP, SP.NO_URUT_SPP, SP.HASH_MD5_SPP, SF.ID_SPP_FORM, SF.JUMLAH_BARANG, SF.NAMA_BARANG, SF.MEREK, SF.PERALATAN_PERLENGKAPAN, SF.SPESIFIKASI_SINGKAT, SF.STATUS_SPP, SF.CORET, SF.ID_VENDOR_FIX, SF.SATUAN_BARANG, SF.ID_KLASIFIKASI_BARANG, KB.NAMA_KLASIFIKASI_BARANG, KB.KODE_KLASIFIKASI_BARANG, SP.ID_PROYEK, V.NAMA_VENDOR
		FROM SPP_FORM as SF
        LEFT JOIN spp as SP ON SP.ID_SPP = SF.ID_SPP
        LEFT JOIN vendor as V ON V.ID_VENDOR = SF.ID_VENDOR_FIX
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=SF.ID_BARANG_MASTER 
		LEFT JOIN klasifikasi_barang as KB on KB.ID_KLASIFIKASI_BARANG=SF.ID_KLASIFIKASI_BARANG

		WHERE 
        SF.STATUS_SPP = '' AND SF.ID_SPP = '$ID_SPP' AND SF.ID_VENDOR_FIX = '$ID_VENDOR' AND SF.CORET <> 1 AND SF.JUMLAH_BARANG > 0  AND SP.ID_PROYEK = (SELECT po.ID_PROYEK FROM po where po.ID_PO = '$ID_PO') OR SF.STATUS_SPP = 'SELESAI'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk mengecek po berdasarkan NAMA
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function simpan_data_di_luar_barang_master
	//         2. 
	function cek_nama_barang_po_form($NAMA,$ID_PO)
	{
		$hsl = $this->db->query("SELECT NAMA_BARANG AS NAMA FROM PO_form WHERE NAMA_BARANG ='$NAMA' AND ID_PO ='$ID_PO' ");
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

	//FUNGSI: Fungsi ini untuk menambahkan data po form berdasarkan data RASD
	//SUMBER TABEL: tabel po_form
	//DIPAKAI: 1. controller po_form / function simpan_data_dari_rasd_form
	//         2. 
	function simpan_data_dari_rasd_form(
		$ID_PO,
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
		$hasil = $this->db->query("INSERT INTO po_form (
				ID_PO,
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
				'$ID_PO',
				'$ID_BARANG_MASTER',
				'$ID_RASD_FORM',
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
	//SUMBER TABEL: tabel PO_form
	//DIPAKAI: 1. controller PO_form / function simpan_data_di_luar_barang_master
	//         2. 
	function simpan_data_di_luar_barang_master(
		$ID_PO,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$HARGA_SATUAN_BARANG_FIX,
		$HARGA_TOTAL_FIX

	) {
		$hasil = $this->db->query("INSERT INTO PO_form (
				ID_PO,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				JUMLAH_BARANG,
				HARGA_SATUAN_BARANG_FIX,
				HARGA_TOTAL_FIX
				)
			VALUES(
				'$ID_PO',
				'$ID_BARANG_MASTER',
				'$ID_RASD_FORM',
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG',
				'$HARGA_SATUAN_BARANG_FIX',
				'$HARGA_TOTAL_FIX'
				 )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data po form berdasarkan ID_PO
	//SUMBER TABEL: tabel PO_form
	//DIPAKAI: 1. controller PO_form / function simpan_data_dari_barang_master
	//         2. 
	function simpan_data_dari_barang_master(
		$ID_PO,
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
		$hasil = $this->db->query("INSERT INTO PO_form (
				ID_PO,
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
				'$ID_PO',
				'$ID_BARANG_MASTER',
				'$ID_RASD_FORM',
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG' )");
		return $hasil;
	}

	function simpan_pajak($ID_PO, $ID_PAJAK)
	{
		$hasil = $this->db->query("UPDATE po_form SET
			ID_PAJAK='$ID_PAJAK'
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function simpan_diskon($ID_PO, $DISKON, $NOMINAL_DISKON)
	{
		$hasil = $this->db->query("UPDATE po SET
			DISKON='$DISKON', NOMINAL_DISKON='$NOMINAL_DISKON'
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	// function simpan_data_dari_spp_form(
	// 	$ID_PO,
	// 	$ID_SPP,
	// 	$ID_SPP_FORM,
	// 	$ID_RASD_FORM,
	// 	$ID_BARANG_MASTER,
	// 	$ID_SATUAN_BARANG,
	// 	$ID_JENIS_BARANG,
	// 	$ID_PAJAK,
	// 	$NAMA,
	// 	$MEREK,
	// 	$PERALATAN_PERLENGKAPAN,
	// 	$SPESIFIKASI_SINGKAT,
	// 	$JUMLAH_BARANG,
	// 	$HARGA_SATUAN_BARANG_FIX,
	// 	$HARGA_TOTAL_FIX,
	// 	$TANGGAL_MULAI_PAKAI_HARI,
	// 	$TANGGAL_SELESAI_PAKAI_HARI
	// ) {
	// 	$hasil = $this->db->query("INSERT INTO po_form (
	// 			ID_PO,
	// 			ID_SPP,
	// 			ID_SPP_FORM,
	// 			ID_RASD_FORM,
	// 			ID_BARANG_MASTER,
	// 			ID_SATUAN_BARANG,
	// 			ID_JENIS_BARANG,
	// 			ID_PAJAK,
	// 			NAMA_BARANG,
	// 			MEREK,
	// 			PERALATAN_PERLENGKAPAN,
	// 			SPESIFIKASI_SINGKAT,
	// 			JUMLAH_BARANG,
	// 			HARGA_SATUAN_BARANG_FIX,
	// 			HARGA_TOTAL_FIX,
	// 			TANGGAL_MULAI_PAKAI,
	// 			TANGGAL_SELESAI_PAKAI
	// 			)
	// 		VALUES(
	// 			'$ID_PO',
	// 			'$ID_SPP',
	// 			'$ID_SPP_FORM',
	// 			'$ID_RASD_FORM',
	// 			'$ID_BARANG_MASTER',
	// 			'$ID_SATUAN_BARANG',
	// 			'$ID_JENIS_BARANG',
	// 			'$ID_PAJAK',
	// 			'$NAMA',
	// 			'$MEREK',
	// 			'$PERALATAN_PERLENGKAPAN',
	// 			'$SPESIFIKASI_SINGKAT',
	// 			'$JUMLAH_BARANG',
	// 			'$HARGA_SATUAN_BARANG_FIX',
	// 			'$HARGA_TOTAL_FIX',
	// 			'$TANGGAL_MULAI_PAKAI_HARI',
	// 			'$TANGGAL_SELESAI_PAKAI_HARI'
	// 			 )");
	// 	return $hasil;
	// }

	function simpan_data_dari_spp_form(
		$ID_SPP_FORM, $ID_PO
	) {
		$hsl_2 = $this->db->query("SELECT SF.ID_SPPB_FORM, SF.ID_RAB_FORM, SF.ID_SPPB, SF.ID_SPP, SF.ID_SPP_FORM, SF.ID_PROYEK_SUB_PEKERJAAN, SF.ID_KLASIFIKASI_BARANG, SF.NAMA_BARANG, SF.MEREK, SF.SPESIFIKASI_SINGKAT, SF.JUMLAH_BARANG, SF.SATUAN_BARANG, SF.HARGA_SATUAN_BARANG_FIX, SF.HARGA_TOTAL_FIX, SF.ID_VENDOR_FIX
		FROM spp_form AS SF
		LEFT JOIN fpb_form AS FPBF ON SF.ID_FPB_FORM = FPBF.ID_FPB_FORM
		WHERE SF.ID_SPP_FORM = '$ID_SPP_FORM'");
		if ($hsl_2->num_rows() > 0) {
			foreach ($hsl_2->result() as $data) {
				$hasil_2 = array(
					'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
					'ID_RAB_FORM' => $data->ID_RAB_FORM,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_SPP' => $data->ID_SPP,
					'ID_SPP_FORM' => $data->ID_SPP_FORM,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'HARGA_SATUAN_BARANG_FIX' => $data->HARGA_SATUAN_BARANG_FIX,
					'HARGA_TOTAL_FIX' => $data->HARGA_TOTAL_FIX,
					'ID_VENDOR_FIX' => $data->ID_VENDOR_FIX
				);

				$hsl_3 = $this->db->query("SELECT SUM(JUMLAH_BARANG) AS JUMLAH_BARANG from po_form WHERE ID_SPP_FORM='$data->ID_SPP_FORM'");

				if ($hsl_3->num_rows() > 0) {
					foreach ($hsl_3->result() as $data) {

						$hasil_3 = array(
							'JUMLAH_BARANG' => $data->JUMLAH_BARANG
						);

					}
				}

				$jumlah_sisa = $hasil_2['JUMLAH_BARANG'] - $hasil_3['JUMLAH_BARANG'];

				$ID_SPPB_FORM = $hasil_2['ID_SPPB_FORM'];
				$ID_SPPB = $hasil_2['ID_SPPB'];
				$ID_SPP = $hasil_2['ID_SPP'];
				$ID_SPP_FORM = $hasil_2['ID_SPP_FORM'];
				$ID_RAB_FORM = $hasil_2['ID_RAB_FORM'];
				$ID_PROYEK_SUB_PEKERJAAN = $hasil_2['ID_PROYEK_SUB_PEKERJAAN'];
				$SATUAN_BARANG = $hasil_2['SATUAN_BARANG'];
				$ID_KLASIFIKASI_BARANG = $hasil_2['ID_KLASIFIKASI_BARANG'];
				$NAMA_BARANG = $hasil_2['NAMA_BARANG'];
				$MEREK = $hasil_2['MEREK'];
				$SPESIFIKASI_SINGKAT = $hasil_2['SPESIFIKASI_SINGKAT'];
				$HARGA_SATUAN_BARANG_FIX = $hasil_2['HARGA_SATUAN_BARANG_FIX'];
				$HARGA_TOTAL_FIX = $hasil_2['HARGA_TOTAL_FIX'];

				$this->db->query(
					"INSERT INTO po_form (ID_PO, ID_SPP, ID_SPP_FORM, ID_SPPB_FORM, ID_SPPB, ID_PROYEK_SUB_PEKERJAAN, SATUAN_BARANG, ID_KLASIFIKASI_BARANG, NAMA_BARANG, MEREK, SPESIFIKASI_SINGKAT, JUMLAH_BARANG, HARGA_SATUAN_BARANG_FIX, HARGA_TOTAL_FIX)
					VALUES (
					'$ID_PO',
					'$ID_SPP',
					'$ID_SPP_FORM',
					'$ID_SPPB_FORM', 
					'$ID_SPPB', 
					'$ID_PROYEK_SUB_PEKERJAAN', 
					'$SATUAN_BARANG', 
					'$ID_KLASIFIKASI_BARANG', 
					'$NAMA_BARANG', 
					'$MEREK', 
					'$SPESIFIKASI_SINGKAT', 
					'$jumlah_sisa',
					'$HARGA_SATUAN_BARANG_FIX',
					'$HARGA_TOTAL_FIX'
					)"
				);

				// $this->db->query(
				// 	"UPDATE spp_form SET 
				// 	STATUS_PO='Dalam Proses PO', KET_PO='$ID_PO'
				// 	WHERE ID_SPP_FORM='$data->ID_SPP_FORM'"
				// );
			}
		}
	}

	function data_qty_po_realisasi_by_ID_SPP_FORM($ID_SPP_FORM)
	{
		$hasil = $this->db->query("SELECT SUM(JUMLAH_BARANG) AS JUMLAH_BARANG from po_form WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		return $hasil->result();
	}

	function data_jumlah_qty_po_by_id_spp_form($ID_SPP_FORM)
	{
		$hsl = $this->db->query("SELECT JUMLAH_BARANG from spp_form WHERE ID_SPP_FORM='$ID_SPP_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}



	//FUNGSI: Fungsi ini untuk menampilkan data PO form ID_SPPB_FORM
	//SUMBER TABEL: tabel po_form
	//DIPAKAI: 1. controller po_form / function get_data
	//         2. controller po_form / function hapus_data
	//		   3. controller po_form / function update_data
	function get_data_by_id_po_form($ID_PO_FORM)
	{
		$hsl = $this->db->query("SELECT 
		po_form.ID_PO_FORM,
		po_form.ID_SPP_FORM,
		po_form.NAMA_BARANG, 
		po_form.MEREK,
		po_form.PERALATAN_PERLENGKAPAN,
		po_form.KETERANGAN_BARANG_PO,
		po_form.SPESIFIKASI_SINGKAT, 
		po_form.JUMLAH_BARANG,
		po_form.ID_JENIS_BARANG,
		po_form.SATUAN_BARANG,
		po_form.SPESIFIKASI_SINGKAT,
		po_form.JUMLAH_BARANG,
		po_form.HARGA_SATUAN_BARANG_FIX,
		po_form.HARGA_TOTAL_FIX,
		M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, RB.ID_RASD_FORM
        FROM po_form
        LEFT JOIN barang_master AS M ON po_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = po_form.ID_RASD_FORM
        WHERE po_form.ID_PO_FORM = '$ID_PO_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PO_FORM' => $data->ID_PO_FORM,
					'ID_SPP_FORM' => $data->ID_SPP_FORM,
					'KODE_BARANG' => $data->KODE_BARANG,
					'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'KETERANGAN_BARANG_PO' => $data->KETERANGAN_BARANG_PO,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'HARGA_SATUAN_BARANG_FIX' => $data->HARGA_SATUAN_BARANG_FIX,
					'HARGA_TOTAL_FIX' => $data->HARGA_TOTAL_FIX
				);
			}
		} else {
			$hasil = "BELUM ADA PO BARANG";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data PO by ID_PO
	//SUMBER TABEL: tabel po_form
	//DIPAKAI: 1. controller po_form / function get_data_po

	function get_data_po_by_id_po($ID_PO)
	{
		$hsl = $this->db->query("SELECT * 
        FROM po
        WHERE ID_PO = '$ID_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PO ' => $data->ID_PO ,
					'HASH_MD5_PO' => $data->HASH_MD5_PO,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_RASD' => $data->ID_RASD,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_VENDOR' => $data->ID_VENDOR,
					'NO_URUT_PO' => $data->NO_URUT_PO,
					'TOP' => $data->TOP,
					'LOKASI_PENYERAHAN' => $data->LOKASI_PENYERAHAN,
					'TANGGAL_PEMBUATAN_PO_JAM' => $data->TANGGAL_PEMBUATAN_PO_JAM
				);
			}
		} else {
			$hasil = "BELUM ADA PO BARANG";
		}
		return $hasil;
	}

	function get_data_po_form_by_ID_PO($ID_PO)
	{
		$hsl = $this->db->query("SELECT * 
        FROM po_form
        WHERE ID_PO = '$ID_PO'");
		// if ($hsl->num_rows() > 0) {
		// 	foreach ($hsl->result() as $data) {
		// 		$hasil = array(
		// 			'ID_PO_FORM' => $data->ID_PO_FORM,
		// 			'ID_PO' => $data->ID_PO,
		// 			'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
		// 			'ID_SPPB' => $data->ID_SPPB,
		// 			'ID_RASD_FORM' => $data->ID_RASD_FORM,
		// 			'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
		// 			'ID_SATUAN_BARANG' => $data->ID_SATUAN_BARANG,
		// 			'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
		// 			'DEVIASI' => $data->DEVIASI,
		// 			'NAMA_BARANG' => $data->NAMA_BARANG,
		// 			'MEREK' => $data->MEREK,
		// 			'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
		// 			'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
		// 			'HARGA_SATUAN_BARANG_FIX' => $data->HARGA_SATUAN_BARANG_FIX,
		// 			'HARGA_TOTAL_FIX' => $data->HARGA_TOTAL_FIX,
		// 			'KETERANGAN' => $data->KETERANGAN
		// 		);
		// 	}
		// } else {
		// 	$hasil = "BELUM ADA PO BARANG";
		// }
		return $hsl->result();
	}

	//FUNGSI: Fungsi ini untuk mengubah data po form berdasarkan ID_PO_FORM
	//SUMBER TABEL: tabel po
	//DIPAKAI: 1. controller PO_form / function update_data
	//         
	function update_data($ID_PO_FORM, $NAMA, $MEREK, $SPESIFIKASI_SINGKAT, $SATUAN_BARANG, $JUMLAH_BARANG, $HARGA_SATUAN_BARANG_FIX, $HARGA_TOTAL_FIX, $KETERANGAN)
	{
		$hasil = $this->db->query("UPDATE po_form SET 
			SATUAN_BARANG='$SATUAN_BARANG',
			NAMA_BARANG='$NAMA',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			JUMLAH_BARANG='$JUMLAH_BARANG',
			HARGA_SATUAN_BARANG_FIX='$HARGA_SATUAN_BARANG_FIX',
			HARGA_TOTAL_FIX='$HARGA_TOTAL_FIX',
			KETERANGAN_BARANG_PO='$KETERANGAN'
			WHERE ID_PO_FORM='$ID_PO_FORM'");
		return $hasil;
	}

	function update_data_kirim_email($ID_PO, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $ISI_BODY)
	{
		$hasil = $this->db->query("UPDATE po SET 
			ID_PO='$ID_PO',
			NAMA_PIC_VENDOR='$NAMA_PIC_VENDOR',
			EMAIL_PIC_VENDOR='$EMAIL_PIC_VENDOR',
			ISI_BODY='$ISI_BODY' WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menghapus data po berdasarkan ID_PO_FORM
	//SUMBER TABEL: tabel PO_form
	//DIPAKAI: 1. controller PO_form / function hapus_data
	//         2. 
	function hapus_data_by_id_po_form($ID_PO_FORM)
	{
		$hasil = $this->db->query("DELETE FROM po_form WHERE ID_PO_FORM='$ID_PO_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data catatat PO form berdasarkan ID_POFORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_keterangan_barang
	//         2. 
	function get_keterangan_by_id_po_form($ID_PO_FORM)
	{
		$hsl = $this->db->query("SELECT 
		ID_PO_FORM, 
		KETERANGAN

		FROM PO_FORM

        WHERE ID_PO_FORM = '$ID_PO_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PO_FORM' => $data->ID_PO_FORM,
					'KETERANGAN' => $data->KETERANGAN
				);
			}
		} else {
			$hasil = "TIDAK ADA KETERANGAN";
		}
		return $hasil;
	}

	function update_progress_id_po($ID_PO, $PROGRESS_PO)
	{
		$hasil = $this->db->query("UPDATE PO SET 
			PROGRESS_PO='$PROGRESS_PO'
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data po berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel po_form
	//DIPAKAI: 1. controller po_form / function update_data_keterangan_barang
	//         2. 
	function update_data_keterangan_barang($ID_PO_FORM, $KETERANGAN)
	{
		$hasil = $this->db->query("UPDATE po_form SET 
			KETERANGAN='$KETERANGAN' 
			WHERE ID_PO_FORM='$ID_PO_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data po berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel po_form
	//DIPAKAI: 1. controller po_form / function update_data_keterangan_barang
	//         2. 
	function update_data_harga_barang($ID_PO_FORM, $HARGA_SATUAN_BARANG_FIX, $HARGA_TOTAL_FIX)
	{
		$hasil = $this->db->query("UPDATE po_form SET 
			HARGA_SATUAN_BARANG_FIX='$HARGA_SATUAN_BARANG_FIX',
			HARGA_TOTAL_FIX='$HARGA_TOTAL_FIX'
			WHERE ID_PO_FORM='$ID_PO_FORM'");
		return $hasil;
	}

	function update_data_total_harga_po_barang($ID_PO, $TOTAL_HARGA_PO_BARANG)
	{
		$hasil = $this->db->query("UPDATE po SET 
			TOTAL_HARGA_PO_BARANG='$TOTAL_HARGA_PO_BARANG'
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function update_data_total_pajak_po_barang($ID_PO, $TOTAL_PAJAK_PO_BARANG)
	{
		$hasil = $this->db->query("UPDATE po SET 
			TOTAL_PAJAK_PO_BARANG='$TOTAL_PAJAK_PO_BARANG'
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function update_data_total_all_po_barang($ID_PO, $TOTAL_ALL_PO_BARANG)
	{
		$hasil = $this->db->query("UPDATE po SET 
			TOTAL_ALL_PO_BARANG='$TOTAL_ALL_PO_BARANG'
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data catatat PO form berdasarkan ID_POFORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_keterangan_barang
	//         2. 
	function get_keterangan_by_id_po($ID_PO)
	{
		$hsl = $this->db->query("SELECT 
		*
		FROM PO_FORM

        WHERE ID_PO = '$ID_PO'");
		return $hsl->result();
	}

	function get_data_catatan_po_by_id_po($ID_PO)
	{
		$hsl = $this->db->query("SELECT 
		ID_PO,
		CTT_STAFF_PROC,
		CTT_KASIE,
		CTT_MANAGER_PROC,
		CTT_STAFF_PROC_SP,
		CTT_SUPERVISI_PROC_SP

		FROM po

        WHERE ID_PO = '$ID_PO'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PO' => $data->ID_PO,
					'CTT_STAFF_PROC' => $data->CTT_STAFF_PROC,
					'CTT_KASIE' => $data->CTT_KASIE,
					'CTT_MANAGER_PROC' => $data->CTT_MANAGER_PROC,
					'CTT_STAFF_PROC_SP' => $data->CTT_STAFF_PROC_SP,
					'CTT_SUPERVISI_PROC_SP' => $data->CTT_SUPERVISI_PROC_SP
				);
			}
		} else {
			$hasil = "TIDAK ADA CATATAN";
		}
		return $hasil;
	}

	function update_data_CTT_STAFF_PROC($ID_PO, $CTT_STAFF_PROC)
	{
		$hasil = $this->db->query("UPDATE po SET 
			CTT_STAFF_PROC='$CTT_STAFF_PROC' 
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function update_data_CTT_KASIE($ID_PO, $CTT_KASIE)
	{
		$hasil = $this->db->query("UPDATE po SET 
			CTT_KASIE='$CTT_KASIE' 
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function update_data_CTT_MANAGER_PROC($ID_PO, $CTT_MANAGER_PROC)
	{
		$hasil = $this->db->query("UPDATE po SET 
			CTT_MANAGER_PROC='$CTT_MANAGER_PROC' 
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function update_data_CTT_STAFF_PROC_SP($ID_PO, $CTT_STAFF_PROC_SP)
	{
		$hasil = $this->db->query("UPDATE po SET 
			CTT_STAFF_PROC_SP='$CTT_STAFF_PROC_SP' 
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function update_data_CTT_SUPERVISI_PROC_SP($ID_PO, $CTT_SUPERVISI_PROC_SP)
	{
		$hasil = $this->db->query("UPDATE po SET 
			CTT_SUPERVISI_PROC_SP='$CTT_SUPERVISI_PROC_SP' 
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data PO form by ID_PO
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function update_data_kirim_sppb
	//         2. 
	function update_data_kirim_po($ID_PO, $PROGRESS_PO, $STATUS_PO)
	{
		$hasil = $this->db->query("UPDATE po SET 
			PROGRESS_PO='$PROGRESS_PO',
			STATUS_PO='$STATUS_PO' 
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function update_data_kirim_po_user_kasie_proc($ID_PO, $PROGRESS_PO, $STATUS_PO, $SIGN_USER_KASIE_PROC)
	{
		$hasil = $this->db->query("UPDATE po SET 
			PROGRESS_PO='$PROGRESS_PO',
			STATUS_PO='$STATUS_PO',
			SIGN_USER_KASIE_PROC='$SIGN_USER_KASIE_PROC'
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function update_data_kirim_po_user_m_proc($ID_PO, $PROGRESS_PO, $STATUS_PO, $SIGN_USER_M_PROC, $SIGN_USER_KASIE_PROC)
	{
		$hasil = $this->db->query("UPDATE po SET 
			PROGRESS_PO='$PROGRESS_PO',
			STATUS_PO='$STATUS_PO',
			SIGN_USER_M_PROC='$SIGN_USER_M_PROC',
			SIGN_USER_KASIE_PROC='$SIGN_USER_KASIE_PROC'
			WHERE ID_PO='$ID_PO'");
		return $hasil;
	}

	function users_by_id_vendor($ID_VENDOR)
	{
		$hasil = $this->db->query("SELECT username, password, expired FROM users WHERE ID_VENDOR = '$ID_VENDOR'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_USER
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function logout
	//         2. controller SPPB_form / function user_log
	function user_log_po_form($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_po_form (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
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
	// 	sppb_form.JUMLAH_MINTA, sppb_form.CORET, sppb_form.POSISI,sppb_form.JUMLAH_SETUJU_TERAKHIR,
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
	// 	sppb_form.JUMLAH_MINTA,
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
	// 				'JUMLAH_MINTA' => $data->JUMLAH_MINTA,
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
	// function get_data_catatan_sppb_by_id_sppb($ID_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT 
	// 	ID_SPPB, 
	// 	CTT_STAFF_LOG,
	// 	CTT_SPV_LOG,
	// 	CTT_CHIEF,
	// 	CTT_SM,
	// 	CTT_PM,
	// 	CTT_M_LOG,
	// 	CTT_M_PROC,
	// 	CTT_M_SDM,
	// 	CTT_M_KONS,
	// 	CTT_M_EP,
	// 	CTT_M_QAQC,	
	// 	CTT_M_KEU,
	// 	CTT_D_PSDS,
	// 	CTT_D_KONS,
	// 	CTT_D_KEU	

	// 	FROM SPPB

    //     WHERE ID_SPPB = '$ID_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_SPPB' => $data->ID_SPPB,
	// 				'CTT_STAFF_LOG' => $data->CTT_STAFF_LOG,
	// 				'CTT_SPV_LOG' => $data->CTT_SPV_LOG,
	// 				'CTT_CHIEF' => $data->CTT_CHIEF,
	// 				'CTT_SM' => $data->CTT_SM,
	// 				'CTT_PM' => $data->CTT_PM,
	// 				'CTT_M_LOG' => $data->CTT_M_LOG,

	// 				'CTT_M_PROC' => $data->CTT_M_PROC,
	// 				'CTT_M_SDM' => $data->CTT_M_SDM,
	// 				'CTT_M_KONS' => $data->CTT_M_KONS,
	// 				'CTT_M_EP' => $data->CTT_M_EP,
	// 				'CTT_M_QAQC' => $data->CTT_M_QAQC,
	// 				'CTT_M_KEU' => $data->CTT_M_KEU,

	// 				'CTT_D_PSDS' => $data->CTT_D_PSDS,
	// 				'CTT_D_KONS' => $data->CTT_D_KONS,
	// 				'CTT_D_KEU' => $data->CTT_D_KEU
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "TIDAK ADA CATATAN";
	// 	}
	// 	return $hasil;
	// }

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
	// 			JUMLAH_MINTA)
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
	// 			JUMLAH_MINTA)
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
	// 			JUMLAH_MINTA)
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
}
