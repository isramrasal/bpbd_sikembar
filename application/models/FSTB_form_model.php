<?php
class FSTB_form_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_FSTB
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function data_fstb_form
	//         2. controller FSTB_form / function cetak_pdf
	function fstb_form_list_by_id_fstb($ID_FSTB) //092023
	{
		$hsl = $this->db->query("SELECT
		fstb_form.ID_FSTB,
		fstb_form.ID_FSTB_FORM,
        fstb_form.NAMA_BARANG, 
		fstb_form.MEREK,
		fstb_form.SATUAN_BARANG,
		fstb_form.SPESIFIKASI_SINGKAT,
		fstb_form.JUMLAH_DIMINTA,
        fstb_form.JUMLAH_DITERIMA,
        fstb_form.JUMLAH_DITOLAK,
        fstb_form.JUMLAH_DITERIMA_SYARAT,
        fstb_form.GAMBAR_FSTB_BARANG,
		fstb_form.HASIL_INSPEKSI,
		fstb_form.KETERANGAN_DITOLAK,
		fstb_form.KETERANGAN_DITERIMA_SYARAT,
        BM.KODE_BARANG AS KODE_BARANG_MASTER,
        JB.NAMA_JENIS_BARANG,
		FSTB.ID_SURAT_JALAN,
		FSTB.ID_PROYEK,
		FSTB.ID_VENDOR,
		FSTB.ID_PO,
		FSTB.NOMOR_SURAT_JALAN_VENDOR,
        FSTB.SUMBER_PENERIMAAN,
		P.NAMA_PROYEK,
		SJ.NO_SURAT_JALAN,
		PO.NO_URUT_PO,
		V.NAMA_VENDOR
        FROM fstb_form
        LEFT JOIN barang_master AS BM ON BM.ID_BARANG_MASTER = fstb_form.ID_BARANG_MASTER
        LEFT JOIN jenis_barang AS JB ON JB.ID_JENIS_BARANG = fstb_form.ID_JENIS_BARANG
		LEFT JOIN fstb AS FSTB ON FSTB.ID_FSTB = fstb_form.ID_FSTB
		LEFT JOIN surat_jalan AS SJ ON SJ.ID_SURAT_JALAN = FSTB.ID_SURAT_JALAN
		LEFT JOIN proyek AS P ON P.ID_PROYEK = FSTB.ID_PROYEK
		LEFT JOIN vendor AS V ON V.ID_VENDOR = FSTB.ID_VENDOR
		LEFT JOIN PO AS PO ON PO.ID_PO = FSTB.ID_PO
        WHERE fstb_form.ID_FSTB = '$ID_FSTB'");
		return $hsl->result();
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan hasil inspeksi berdasarkan ID_FSTB
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function update_data_barang_hasil_temuan
	//         2. controller FSTB_form / function cetak_pdf
	// function hasil_inspeksi_by_id_fstb($ID_FSTB)
	// {
	// 	$hasil = $this->db->query("SELECT 
	// 	fstb_form.ID_FSTB, 
	// 	fstb_form.NAMA_BARANG, 
	// 	fstb_form.HASIL_INSPEKSI
    //     FROM fstb_form
    //     WHERE ID_FSTB = '$ID_FSTB' AND fstb_form.HASIL_INSPEKSI IS NOT NULL");
	// 	return $hasil->result();
	// }

	function data_qty_po_realisasi_by_ID_PO_FORM($ID_PO_FORM) //092023
	{
		$hasil = $this->db->query("SELECT SUM(JUMLAH_DITERIMA + JUMLAH_DITERIMA_SYARAT) AS JUMLAH_BARANG from fstb_form WHERE ID_PO_FORM='$ID_PO_FORM'");
		return $hasil->result();
	}

	function po_form_list_where_not_in_fstb($ID_PO)//092023
	{
		$hasil = $this->db->query("SELECT 
		PO.ID_PO, PO.NO_URUT_PO, PO.HASH_MD5_PO, 
		PF.ID_PO_FORM, PF.NAMA_BARANG, PF.MEREK, PF.PERALATAN_PERLENGKAPAN, PF.SPESIFIKASI_SINGKAT, PF.JUMLAH_BARANG, PF.SATUAN_BARANG, PF.KETERANGAN_BARANG_PO, PF.ID_KLASIFIKASI_BARANG,
		KB.NAMA_KLASIFIKASI_BARANG, KB.KODE_KLASIFIKASI_BARANG, 
		V.NAMA_VENDOR
				FROM PO_FORM as PF
				LEFT JOIN po as PO ON PO.ID_PO = PF.ID_PO
				LEFT JOIN vendor as V ON V.ID_VENDOR = PO.ID_VENDOR
				LEFT JOIN klasifikasi_barang as KB on KB.ID_KLASIFIKASI_BARANG=PF.ID_KLASIFIKASI_BARANG
				WHERE 
				PF.STATUS_PO_FORM = '' AND PF.ID_PO = '$ID_PO' AND PF.JUMLAH_BARANG > 0");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function hapus_data
	//         2. controller FSTB_form / function update_data
	//		   3. controller FSTB_form / function get_data
	function get_data_by_ID_FSTB_FORM($ID_FSTB_FORM) //092023
	{
		$hsl = $this->db->query("SELECT 	
		fstb_form.ID_FSTB_FORM,
        fstb_form.ID_FSTB,
		fstb_form.ID_PO,
		fstb_form.ID_PO_FORM,
        fstb_form.NAMA_BARANG, 
		fstb_form.MEREK,
		fstb_form.SATUAN_BARANG,
		fstb_form.SPESIFIKASI_SINGKAT,
		fstb_form.PERALATAN_PERLENGKAPAN,
        fstb_form.JUMLAH_DITERIMA,
		fstb_form.JUMLAH_DITERIMA_SYARAT,
        fstb_form.JUMLAH_DITOLAK,
        fstb_form.JUMLAH_DIMINTA,
        fstb_form.GAMBAR_FSTB_BARANG,
		fstb_form.HASIL_INSPEKSI,
		fstb_form.KETERANGAN_DITOLAK,
		fstb_form.KETERANGAN_DITERIMA_SYARAT
        FROM fstb_form
        WHERE fstb_form.ID_FSTB_FORM = '$ID_FSTB_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FSTB_FORM' => $data->ID_FSTB_FORM,
					'ID_FSTB' => $data->ID_FSTB,
					'ID_PO' => $data->ID_PO,
					'ID_PO_FORM' => $data->ID_PO_FORM,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'JUMLAH_DITERIMA' => $data->JUMLAH_DITERIMA,
					'JUMLAH_DITERIMA_SYARAT' => $data->JUMLAH_DITERIMA_SYARAT,
					'JUMLAH_DITOLAK' => $data->JUMLAH_DITOLAK,
					'JUMLAH_DIMINTA' => $data->JUMLAH_DIMINTA,
					'KETERANGAN_DITERIMA_SYARAT' => $data->KETERANGAN_DITERIMA_SYARAT,
					'KETERANGAN_DITOLAK' => $data->KETERANGAN_DITOLAK,
					'HASIL_INSPEKSI' => $data->HASIL_INSPEKSI
				);
			}
		} else {
			$hasil = "BELUM ADA FSTB BARANG";
		}
		return $hasil;
	}

	function update_status_id_po_form_incomplete($ID_PO_FORM) //092023
	{
		$hasil = $this->db->query("UPDATE po_form SET 
			COMPLETE=''
			WHERE ID_PO_FORM='$ID_PO_FORM'");
		return $hasil;
	}

	// function get_data_nama_master($nama)
	// {
	// 	$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, J.ID_JENIS_BARANG, S.ID_SATUAN_BARANG, J.NAMA_JENIS_BARANG, 
	// 	M.KODE_BARANG, M.NAMA, M.PERALATAN_PERLENGKAPAN, M.GROSS_WEIGHT, M.NETT_WEIGHT, M.DIMENSI_PANJANG, M.DIMENSI_LEBAR, 
	// 	M.DIMENSI_TINGGI, M.SPESIFIKASI_LENGKAP, M.SPESIFIKASI_SINGKAT, M.CARA_SINGKAT_PENGGUNAAN, M.CARA_PENYIMPANAN_BARANG, 
	// 	 M.MASA_PAKAI, M.ALIAS, M.MEREK, M.HASH_MD5_BARANG_MASTER, S.NAMA_SATUAN_BARANG 
	// 	FROM barang_master as M
	// 	LEFT JOIN jenis_barang as J ON J.ID_JENIS_BARANG=M.ID_JENIS_BARANG
	// 	LEFT JOIN satuan_barang as S ON S.ID_SATUAN_BARANG=M.ID_SATUAN_BARANG
	// 	WHERE M.NAMA LIKE '%$nama[0]%' ");
		
	// 	return$hasil->result();
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data hasil inspeksi berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function update_data_barang_hasil_temuan
	//         2. 
	// function get_hasil_inspeksi_by_id_fstb_form($ID_FSTB_FORM)
	// {
	// 	$hsl = $this->db->query("SELECT 
	// 	ID_FSTB_FORM, 
	// 	HASIL_INSPEKSI

	// 	FROM fstb_form

    //     WHERE ID_FSTB_FORM = '$ID_FSTB_FORM'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_FSTB_FORM' => $data->ID_FSTB_FORM,
	// 				'HASIL_INSPEKSI' => $data->HASIL_INSPEKSI
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "TIDAK ADA KETERANGAN";
	// 	}
	// 	return $hasil;
	// }

	function update_progress_id_fstb($ID_FSTB, $PROGRESS_FSTB)
	{
		$hasil = $this->db->query("UPDATE FSTB SET 
			PROGRESS_FSTB='$PROGRESS_FSTB'
			WHERE ID_FSTB='$ID_FSTB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk merubah hasil inspeksi berdasarkan ID_FSTB_FORM, HASIL_INSPEKSI
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function update_data_barang_hasil_temuan
	//         2. 
	function update_data_hasil_inspeksi($ID_FSTB_FORM, $HASIL_INSPEKSI)
	{
		$hasil = $this->db->query("UPDATE fstb_form SET 
			HASIL_INSPEKSI='$HASIL_INSPEKSI' 
			WHERE ID_FSTB_FORM='$ID_FSTB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk merubah data fstb berdasarkan ID_FSTB_FORM, NAMA_BARANG, MEREK, ID_SATUAN_BARANG, JUMLAH_DITERIMA, JUMLAH_DITOLAK, JUMLAH_DIMINTA, ID_JENIS_BARANG, SPESIFIKASI_SINGKAT
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function update_data
	//         2. 
	function update_data($ID_FSTB_FORM, $JUMLAH_DITERIMA, $JUMLAH_DITOLAK, $JUMLAH_DITERIMA_SYARAT, $KETERANGAN_DITOLAK, $KETERANGAN_DITERIMA_SYARAT)
	{
		$hasil = $this->db->query("UPDATE fstb_form SET 
			JUMLAH_DITERIMA='$JUMLAH_DITERIMA',
			JUMLAH_DITOLAK='$JUMLAH_DITOLAK',
			JUMLAH_DITERIMA_SYARAT='$JUMLAH_DITERIMA_SYARAT',
			KETERANGAN_DITOLAK='$KETERANGAN_DITOLAK',
			KETERANGAN_DITERIMA_SYARAT='$KETERANGAN_DITERIMA_SYARAT'
			WHERE ID_FSTB_FORM='$ID_FSTB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_FSTB
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function cetak_pdf
	//         2. 
	function ID_JABATAN_BY_ID_FSTB($ID_FSTB)
	{
		$hasil = $this->db->query("SELECT P.ID_JABATAN_PEGAWAI
		FROM pegawai AS P
		LEFT JOIN users AS U ON U.ID_PEGAWAI = P.ID_PEGAWAI
		LEFT JOIN fstb AS F ON F.CREATE_BY_USER = U.id 
		where F.ID_FSTB = '$ID_FSTB'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menghapus data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function hapus_data
	//         2. 
	function hapus_data_by_id_FSTB_form($ID_FSTB_FORM)
	{
		$hasil = $this->db->query("DELETE FROM FSTB_form WHERE ID_FSTB_FORM='$ID_FSTB_FORM'");
		return $hasil;
	}

	function hapus_data_by_id_fstb($ID_FSTB) //092023
	{
		$hasil = $this->db->query("DELETE FROM fstb_form WHERE ID_FSTB='$ID_FSTB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function get_data
	//         2. controller FSTB_form / function hapus_data
	//         3. controller FSTB_form / function update_data
	function get_data_by_id_FSTB($ID_FSTB)
	{
		$hsl = $this->db->query("SELECT 	
		fstb_form.ID_FSTB_FORM,
        fstb_form.ID_FSTB,
        fstb_form.NAMA_BARANG, 
		fstb_form.MEREK,
		fstb_form.SATUAN_BARANG,
		fstb_form.PERALATAN_PERLENGKAPAN,
        fstb_form.JUMLAH_DITERIMA,
        fstb_form.JUMLAH_DITOLAK,
        fstb_form.JUMLAH_DIMINTA,
        fstb_form.GAMBAR_FSTB_BARANG,
        fstb_form.ID_JENIS_BARANG,
		JB.NAMA_JENIS_BARANG,
        fstb_form.SPESIFIKASI_SINGKAT,
        fstb_form.TANGGAL_BARANG_DATANG,
        BM.KODE_BARANG AS KODE_BARANG_MASTER,
        JB.NAMA_JENIS_BARANG
        FROM fstb_form
        LEFT JOIN barang_master AS BM ON BM.ID_BARANG_MASTER = fstb_form.ID_BARANG_MASTER
        LEFT JOIN jenis_barang AS JB ON JB.ID_JENIS_BARANG = fstb_form.ID_JENIS_BARANG 
        WHERE ID_FSTB = '$ID_FSTB'");
		return $hsl->result();
		
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function index
	//         2. controller FSTB_form / function get_data_catatan_fstb
	//         3. controller FSTB_form / function update_data_catatan_fstb
	//         4. controller FSTB_form / function cetak_pdf
	function get_data_catatan_fstb_by_id_fstb($ID_FSTB)
	{
		$hsl = $this->db->query("SELECT 
		ID_FSTB, 
		CTT_STAFF_LOG
		FROM fstb
        WHERE ID_FSTB = '$ID_FSTB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FSTB' => $data->ID_FSTB,
					'CTT_STAFF_LOG' => $data->CTT_STAFF_LOG
				);
			}
		} else {
			$hasil = "TIDAK ADA CATATAN";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan NAMA
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function simpan_data
	//         2. 
	function simpan_data(
		$ID_FSTB,
		$NAMA_BARANG,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$ID_SATUAN_BARANG,
		$JUMLAH_DITERIMA,
		$JUMLAH_DITOLAK,
		$JUMLAH_DIMINTA,
		$ID_JENIS_BARANG,
		$SPESIFIKASI_SINGKAT,
		$TANGGAL_BARANG_DATANG) {
		$hasil = $this->db->query("INSERT INTO FSTB_form (
				ID_FSTB,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				ID_SATUAN_BARANG,
				JUMLAH_DITERIMA,
				JUMLAH_DITOLAK,
				JUMLAH_DIMINTA,
				ID_JENIS_BARANG,
				SPESIFIKASI_SINGKAT,
				TANGGAL_BARANG_DATANG)
			VALUES(
				'$ID_FSTB',
				'$NAMA_BARANG',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$ID_SATUAN_BARANG',
				'$JUMLAH_DITERIMA',
				'$JUMLAH_DITOLAK',
				'$JUMLAH_DIMINTA',
				'$ID_JENIS_BARANG',
				'$SPESIFIKASI_SINGKAT',
				'$TANGGAL_BARANG_DATANG' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan NAMA
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function simpan_data
	//         2. 
	function cek_nama_barang_FSTB_form($NAMA,$ID_FSTB)
	{
		$hsl = $this->db->query("SELECT ID_FSTB_FORM, NAMA_BARANG AS NAMA FROM fstb_form WHERE NAMA_BARANG ='$NAMA' AND ID_FSTB ='$ID_FSTB' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FSTB_FORM' => $data->ID_FSTB_FORM,
					'NAMA' => $data->NAMA
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function simpan_data_dari_po_form(
		$ID_PO_FORM, $ID_FSTB
	) {
		$hsl_2 = $this->db->query("SELECT PF.ID_SPPB, PF.ID_SPPB_FORM, PF.ID_SPP, PF.ID_SPP_FORM, PF.ID_PO, PF.ID_PO_FORM, PF.ID_PROYEK_SUB_PEKERJAAN, PF.ID_KLASIFIKASI_BARANG, PF.NAMA_BARANG, PF.MEREK, PF.SPESIFIKASI_SINGKAT, PF.JUMLAH_BARANG, PF.SATUAN_BARANG
		FROM po_form AS PF
		WHERE PF.ID_PO_FORM = '$ID_PO_FORM'");
		if ($hsl_2->num_rows() > 0) {
			foreach ($hsl_2->result() as $data) {
				$hasil_2 = array(
					'ID_SPPB' => $data->ID_SPPB,
					'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
					'ID_SPP' => $data->ID_SPP,
					'ID_SPP_FORM' => $data->ID_SPP_FORM,
					'ID_PO' => $data->ID_PO,
					'ID_PO_FORM' => $data->ID_PO_FORM,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'SATUAN_BARANG' => $data->SATUAN_BARANG
				);

				$hsl_3 = $this->db->query("SELECT SUM(JUMLAH_DITERIMA + JUMLAH_DITERIMA_SYARAT) AS JUMLAH_BARANG from fstb_form WHERE ID_PO_FORM='$data->ID_PO_FORM'");

				if ($hsl_3->num_rows() > 0) {
					foreach ($hsl_3->result() as $data) {

						$hasil_3 = array(
							'JUMLAH_BARANG' => $data->JUMLAH_BARANG
						);

					}
				}

				if($hasil_3['JUMLAH_BARANG'] == NULL)
				{
					$hasil_3['JUMLAH_BARANG'] = 0;
				}

				$jumlah_sisa = $hasil_2['JUMLAH_BARANG'] - $hasil_3['JUMLAH_BARANG'];
				
				$ID_SPPB = $hasil_2['ID_SPPB'];
				$ID_SPPB_FORM = $hasil_2['ID_SPPB_FORM'];
				$ID_SPP = $hasil_2['ID_SPP'];
				$ID_SPP_FORM = $hasil_2['ID_SPP_FORM'];
				$ID_PO = $hasil_2['ID_PO'];
				$ID_PO_FORM = $hasil_2['ID_PO_FORM'];
				$ID_PROYEK_SUB_PEKERJAAN = $hasil_2['ID_PROYEK_SUB_PEKERJAAN'];
				$SATUAN_BARANG = $hasil_2['SATUAN_BARANG'];
				$ID_KLASIFIKASI_BARANG = $hasil_2['ID_KLASIFIKASI_BARANG'];
				$NAMA_BARANG = $hasil_2['NAMA_BARANG'];
				$MEREK = $hasil_2['MEREK'];
				$SPESIFIKASI_SINGKAT = $hasil_2['SPESIFIKASI_SINGKAT'];

				$this->db->query(
					"INSERT INTO fstb_form (
						ID_FSTB, 
						ID_SPPB, 
						ID_SPPB_FORM, 
						ID_SPP, 
						ID_SPP_FORM, 
						ID_PO, 
						ID_PO_FORM, 
						ID_PROYEK_SUB_PEKERJAAN,
						ID_KLASIFIKASI_BARANG, 
						SATUAN_BARANG, 
						NAMA_BARANG, 
						MEREK, 
						SPESIFIKASI_SINGKAT, 
						JUMLAH_DIMINTA)
					VALUES (
					'$ID_FSTB',
					'$ID_SPPB',
					'$ID_SPPB_FORM',
					'$ID_SPP',
					'$ID_SPP_FORM', 
					'$ID_PO',
					'$ID_PO_FORM', 
					'$ID_PROYEK_SUB_PEKERJAAN',
					'$ID_KLASIFIKASI_BARANG', 
					'$SATUAN_BARANG',
					'$NAMA_BARANG', 
					'$MEREK', 
					'$SPESIFIKASI_SINGKAT', 
					'$jumlah_sisa'
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

	//FUNGSI: Fungsi ini untuk mengubah data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function update_data_coret
	//         2. 
	function update_data_coret($ID_FSTB_FORM)
	{
		$hasil = $this->db->query("UPDATE fstb_form SET 
			CORET=1 
			WHERE ID_FSTB_FORM='$ID_FSTB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function update_data_batal_coret
	//         2. 
	function update_data_batal_coret($ID_FSTB_FORM)
	{
		$hasil = $this->db->query("UPDATE fstb_form SET 
			CORET=0 
			WHERE ID_FSTB_FORM='$ID_FSTB_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data fstb berdasarkan ID_FSTB
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function update_data_catatan_fstb
	//         2. 
	function update_data_CTT_STAFF_LOG($ID_FSTB, $CTT_STAFF_LOG)
	{
		$hasil = $this->db->query("UPDATE fstb SET CTT_STAFF_LOG='$CTT_STAFF_LOG' WHERE ID_FSTB='$ID_FSTB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data fstb berdasarkan ID_FSTB
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function update_data_kirim_fstb
	//         2. 
	function update_data_kirim_fstb($ID_FSTB, $PROGRESS_FSTB, $STATUS_FSTB)
	{
		$hasil = $this->db->query("UPDATE fstb SET 
			PROGRESS_FSTB='$PROGRESS_FSTB',
			STATUS_FSTB='$STATUS_FSTB'
			WHERE ID_FSTB='$ID_FSTB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function update_data_tanggal
	//         2. 
	function update_data_tanggal($id,$field,$value)
	{
		$hasil = $this->db->query("UPDATE fstb_form SET $field='$value' WHERE ID_FSTB_FORM ='$id'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function logout
	//         2. controller FSTB_form / function user_log
	function user_log_fstb_form($ID_USER, $ID_FSTB_FORM, $KETERANGAN, $WAKTU)
	{
		$db2 = $this->load->database('logs', TRUE);

		$hasil = $db2->query("INSERT INTO user_log_fstb_form (ID_USER, ID_FSTB_FORM, KETERANGAN, WAKTU) VALUES('$ID_USER', '$ID_FSTB_FORM', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
