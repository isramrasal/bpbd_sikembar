<?php
class KHP_form_model extends CI_Model
{
	function get_list_pengajuan_vendor_by_id_sppb_form($ID_SPPB_FORM, $ID_KHP)
	{
		$hsl = $this->db->query("SELECT HBP.ID_SPPB, HBP.ID_SPPB_FORM, HBP.ID_RFQ, HBP.ID_RFQ_FORM, HBP.ID_VENDOR, HBP.HARGA_SATUAN_BARANG, HBP.HARGA_TOTAL, HBP.SISTEM_BAYAR_VENDOR, V.NAMA_VENDOR from harga_barang_pemasok as HBP LEFT JOIN vendor as V on V.ID_VENDOR = HBP.ID_VENDOR WHERE HBP.ID_SPPB_FORM = '$ID_SPPB_FORM' AND HBP.ID_KHP = '$ID_KHP'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}


	//FUNGSI: Fungsi ini untuk menampilkan data seluruh rfq form
	//SUMBER TABEL: tabel khp_form
	//DIPAKAI: 1. controller khp_form / function data_khp_form
	//         2. 
	function khp_form_list_by_id_khp($ID_KHP)
	{
		$hasil = $this->db->query("SELECT 
		khp_form.ID_SPPB, 
		khp_form.ID_KHP_FORM, 
		khp_form.ID_SPPB_FORM,
		khp_form.NAMA_BARANG, 
		khp_form.MEREK, 
		khp_form.SPESIFIKASI_SINGKAT, 
		khp_form.SATUAN_BARANG,
		khp_form.JUMLAH_MINTA,
		khp_form.KETERANGAN,

		khp_form.ID_VENDOR_PERTAMA,
		khp_form.HARGA_SATUAN_BARANG_VENDOR_PERTAMA,
		khp_form.HARGA_TOTAL_VENDOR_PERTAMA,
		V1.NAMA_VENDOR AS NAMA_VENDOR_PERTAMA,

		khp_form.ID_VENDOR_KEDUA,
		khp_form.HARGA_SATUAN_BARANG_VENDOR_KEDUA,
		khp_form.HARGA_TOTAL_VENDOR_KEDUA,
		V2.NAMA_VENDOR AS NAMA_VENDOR_KEDUA,

		khp_form.ID_VENDOR_KETIGA,
		khp_form.HARGA_SATUAN_BARANG_VENDOR_KETIGA,
		khp_form.HARGA_TOTAL_VENDOR_KETIGA,
		V3.NAMA_VENDOR AS NAMA_VENDOR_KETIGA,

		M.ID_BARANG_MASTER, 
		M.KODE_BARANG, 
		M.HASH_MD5_BARANG_MASTER,
        KHP.ID_KHP, 
		KHP.HASH_MD5_KHP,
		V.NAMA_VENDOR AS NAMA_VENDOR_FIX

        FROM khp_form
        LEFT JOIN barang_master AS M ON khp_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN komparasi_harga_pemasok AS KHP ON KHP.ID_KHP = khp_form.ID_KHP
		LEFT JOIN vendor AS V ON V.ID_VENDOR = khp_form.ID_VENDOR_FIX
		LEFT JOIN vendor AS V1 ON V1.ID_VENDOR = khp_form.ID_VENDOR_PERTAMA
		LEFT JOIN vendor AS V2 ON V2.ID_VENDOR = khp_form.ID_VENDOR_KEDUA
		LEFT JOIN vendor AS V3 ON V3.ID_VENDOR = khp_form.ID_VENDOR_KETIGA 
        WHERE KHP.ID_KHP = '$ID_KHP'");
		return $hasil->result();
	}

	function vendor_list_by_id_khp($ID_KHP)
	{
		$hasil = $this->db->query("SELECT DISTINCT
		khp_form.ID_VENDOR_PERTAMA,
		khp_form.HARGA_SATUAN_BARANG_VENDOR_PERTAMA,
		khp_form.HARGA_TOTAL_VENDOR_PERTAMA,
		V1.NAMA_VENDOR AS NAMA_VENDOR_PERTAMA,

		khp_form.ID_VENDOR_KEDUA,
		khp_form.HARGA_SATUAN_BARANG_VENDOR_KEDUA,
		khp_form.HARGA_TOTAL_VENDOR_KEDUA,
		V2.NAMA_VENDOR AS NAMA_VENDOR_KEDUA,

		khp_form.ID_VENDOR_KETIGA,
		khp_form.HARGA_SATUAN_BARANG_VENDOR_KETIGA,
		khp_form.HARGA_TOTAL_VENDOR_KETIGA,
		V3.NAMA_VENDOR AS NAMA_VENDOR_KETIGA

        FROM khp_form
        LEFT JOIN barang_master AS M ON khp_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN komparasi_harga_pemasok AS khp ON khp.ID_KHP = khp_form.ID_KHP
		LEFT JOIN vendor AS V ON V.ID_VENDOR = khp_form.ID_VENDOR_FIX
		LEFT JOIN vendor AS V1 ON V1.ID_VENDOR = khp.ID_VENDOR_PERTAMA
		LEFT JOIN vendor AS V2 ON V2.ID_VENDOR = khp.ID_VENDOR_KEDUA
		LEFT JOIN vendor AS V3 ON V3.ID_VENDOR = khp.ID_VENDOR_KETIGA
		WHERE khp_form.ID_KHP='$ID_KHP'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data BARANG MASTER berdasarkan ID_KHP
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller khp_form / function index
	//         2. 
	function barang_master_where_not_in_rfq_and_rasd($ID_KHP)
	{
		$hasil = $this->db->query("SELECT M.NAMA, M.KODE_BARANG, M.MEREK, M.HASH_MD5_BARANG_MASTER, 
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
				AND RASD_FORM.ID_RASD = (SELECT ID_RASD FROM request_for_quotation WHERE ID_KHP = '$ID_KHP'))
           	AND
            NOT EXISTS
            	(SELECT ID_BARANG_MASTER
                 FROM khp_form
                 WHERE khp_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                 AND khp_form.ID_KHP = '$ID_KHP')
            	");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_KHP
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller KHP_form / function index
	//         2. 
	function rasd_form_list_where_not_in_rfq($ID_KHP)
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER,
		RB.ID_RASD_FORM, RB.JUMLAH_BARANG, RB.TOTAL_PENGADAAN_SAAT_INI, RB.ID_RASD, RB.NAMA,
        RB.MEREK, RB.SPESIFIKASI_SINGKAT,
        SB.NAMA_SATUAN_BARANG, SB.ID_SATUAN_BARANG,
        J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG
		FROM RASD_FORM as RB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=RB.ID_BARANG_MASTER 
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG OR RB.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN satuan_barang as SB ON M.ID_SATUAN_BARANG=SB.ID_SATUAN_BARANG OR RB.ID_SATUAN_BARANG = SB.ID_SATUAN_BARANG
		WHERE 
            NOT EXISTS
                (SELECT khp_form.ID_RASD_FORM, khp_form.ID_BARANG_MASTER
                 FROM khp_form WHERE khp_form.ID_RASD_FORM = RB.ID_RASD_FORM
                AND khp_form.ID_KHP = '$ID_KHP')
        AND NOT EXISTS
        		(SELECT khp_form.ID_BARANG_MASTER 
                 FROM khp_form WHERE khp_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                AND khp_form.ID_KHP='$ID_KHP')
		AND RB.ID_RASD = (SELECT ID_RASD FROM request_for_quotation WHERE ID_KHP = '$ID_KHP')");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk mengecek rfq berdasarkan NAMA
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function simpan_data_di_luar_barang_master
	//         2. 
	function cek_nama_barang_khp_form($NAMA,$ID_KHP)
	{
		$hsl = $this->db->query("SELECT NAMA_BARANG AS NAMA FROM KHP_form WHERE NAMA_BARANG ='$NAMA' AND ID_KHP ='$ID_KHP' ");
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

	function simpan_data_dari_sppb_form(
		$ID_SPPB_FORM, $ID_KHP
	) {
		$hsl_2 = $this->db->query("SELECT SF.ID_SPPB_FORM, SF.ID_RASD_FORM, SF.ID_RAB_FORM, SF.ID_SPPB, SF.ID_PROYEK_SUB_PEKERJAAN, SF.SATUAN_BARANG, SF.ID_KLASIFIKASI_BARANG, SF.NAMA_BARANG, SF.MEREK, SF.SPESIFIKASI_SINGKAT, SF.JUMLAH_SETUJU_TERAKHIR, SF.TANGGAL_MULAI_PAKAI_HARI, SF.TANGGAL_SELESAI_PAKAI_HARI, SF.JUMLAH_QTY_SPP, SF.KETERANGAN_UMUM
		FROM sppb_form AS SF
		LEFT JOIN fpb_form AS FPBF ON SF.ID_FPB_FORM = FPBF.ID_FPB_FORM
		WHERE SF.ID_SPPB_FORM = '$ID_SPPB_FORM'");
		if ($hsl_2->num_rows() > 0) {
			foreach ($hsl_2->result() as $data) {
				$hasil_2 = array(
					'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
					'ID_RASD_FORM' => $data->ID_RASD_FORM,
					'ID_RAB_FORM' => $data->ID_RAB_FORM,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'JUMLAH_SETUJU_TERAKHIR' => $data->JUMLAH_SETUJU_TERAKHIR,
					'TANGGAL_MULAI_PAKAI_HARI' => $data->TANGGAL_MULAI_PAKAI_HARI,
					'TANGGAL_SELESAI_PAKAI_HARI' => $data->TANGGAL_SELESAI_PAKAI_HARI,
					'JUMLAH_QTY_SPP' => $data->JUMLAH_QTY_SPP,
					'KETERANGAN_UMUM' => $data->KETERANGAN_UMUM
				);

				$this->db->query(
					"INSERT INTO KHP_form (ID_KHP, ID_SPPB_FORM, ID_SPPB, ID_RASD_FORM, ID_RAB_FORM, ID_PROYEK_SUB_PEKERJAAN, SATUAN_BARANG, ID_KLASIFIKASI_BARANG, NAMA_BARANG, MEREK, SPESIFIKASI_SINGKAT, JUMLAH_MINTA, KETERANGAN)
					VALUES ('$ID_KHP', 
					'$data->ID_SPPB_FORM', 
					'$data->ID_SPPB', 
					'$data->ID_RASD_FORM',
					'$data->ID_RAB_FORM',
					'$data->ID_PROYEK_SUB_PEKERJAAN', 
					'$data->SATUAN_BARANG', 
					'$data->ID_KLASIFIKASI_BARANG', 
					'$data->NAMA_BARANG', 
					'$data->MEREK', 
					'$data->SPESIFIKASI_SINGKAT', 
					'$data->JUMLAH_QTY_SPP',
					'$data->KETERANGAN_UMUM'
					)"
				);
			}
		}
	}

	//FUNGSI: Fungsi ini untuk menambahkan data rfq form berdasarkan data RASD
	//SUMBER TABEL: tabel khp_form
	//DIPAKAI: 1. controller khp_form / function simpan_data_dari_rasd_form
	//         2. 
	function simpan_data_dari_rasd_form(
		$ID_KHP,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO khp_form (
				ID_KHP,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA)
			VALUES(
				'$ID_KHP',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fpb berdasarkan ID_FPB
	//SUMBER TABEL: tabel KHP_form
	//DIPAKAI: 1. controller KHP_form / function simpan_data_di_luar_barang_master
	//         2. 
	function simpan_data_di_luar_barang_master(
		$ID_KHP,
		$ID_SATUAN_BARANG,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG,
		$KETERANGAN
	) {
		$hasil = $this->db->query("INSERT INTO KHP_form (
				ID_KHP,
				ID_SATUAN_BARANG,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA,
				KETERANGAN)
			VALUES(
				'$ID_KHP',
				'$ID_SATUAN_BARANG',
				'$NAMA',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG',
				'$KETERANGAN' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data rfq form berdasarkan ID_KHP
	//SUMBER TABEL: tabel KHP_form
	//DIPAKAI: 1. controller KHP_form / function simpan_data_dari_barang_master
	//         2. 
	function simpan_data_dari_barang_master(
		$ID_KHP,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO KHP_form (
				ID_KHP,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				JUMLAH_MINTA)
			VALUES(
				'$ID_KHP',
				$ID_BARANG_MASTER,
				$ID_RASD_FORM,
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$JUMLAH_BARANG' )");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RFQ form ID_SPPB_FORM
	//SUMBER TABEL: tabel khp_form
	//DIPAKAI: 1. controller khp_form / function get_data
	//         2. controller khp_form / function hapus_data
	//		   3. controller khp_form / function update_data
	function get_data_by_id_khp_form($ID_KHP_FORM)
	{
		$hsl = $this->db->query("SELECT 
		khp_form.ID_SPPB, 
		khp_form.ID_KHP_FORM, 
		khp_form.ID_KHP, 
		khp_form.NAMA_BARANG, 
		khp_form.MEREK,
		khp_form.KETERANGAN,
		khp_form.SPESIFIKASI_SINGKAT, 
		khp_form.JUMLAH_MINTA,
		khp_form.SATUAN_BARANG,
		khp_form.HARGA_SATUAN_BARANG_VENDOR_PERTAMA	,
		khp_form.HARGA_SATUAN_BARANG_VENDOR_KEDUA,
		khp_form.HARGA_SATUAN_BARANG_VENDOR_KETIGA,
		khp_form.ID_SATUAN_BARANG,
		M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, RB.ID_RASD_FORM
        FROM khp_form
        LEFT JOIN barang_master AS M ON khp_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = khp_form.ID_RASD_FORM
        WHERE khp_form.ID_KHP_FORM = '$ID_KHP_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KHP_FORM' => $data->ID_KHP_FORM,
					'ID_KHP' => $data->ID_KHP,
					'SATUAN_BARANG' => $data->SATUAN_BARANG,
					'KODE_BARANG' => $data->KODE_BARANG,
					'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'JUMLAH_MINTA' => $data->JUMLAH_MINTA,
					'HARGA_SATUAN_BARANG_VENDOR_PERTAMA' => $data->HARGA_SATUAN_BARANG_VENDOR_PERTAMA,
					'HARGA_SATUAN_BARANG_VENDOR_KEDUA' => $data->HARGA_SATUAN_BARANG_VENDOR_KEDUA,
					'HARGA_SATUAN_BARANG_VENDOR_KETIGA' => $data->HARGA_SATUAN_BARANG_VENDOR_KETIGA,
					'KETERANGAN' => $data->KETERANGAN
				);
			}
		} else {
			$hasil = "BELUM ADA KHP BARANG";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RFQ by ID_KHP
	//SUMBER TABEL: tabel khp_form
	//DIPAKAI: 1. controller khp_form / function get_data_rfq

	function get_data_rfq_by_id_rfq($ID_KHP)
	{
		$hsl = $this->db->query("SELECT * 
        FROM request_for_quotation
        WHERE ID_KHP = '$ID_KHP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KHP ' => $data->ID_KHP ,
					'HASH_MD5_RFQ' => $data->HASH_MD5_RFQ,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_RASD' => $data->ID_RASD,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_VENDOR' => $data->ID_VENDOR,
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

	//FUNGSI: Fungsi ini untuk mengubah data rfq form berdasarkan ID_KHP_FORM
	//SUMBER TABEL: tabel rfq
	//DIPAKAI: 1. controller KHP_form / function update_data
	//     
	
	//112023
	function update_data($ID_KHP_FORM,
	$JUMLAH_MINTA,
	$SATUAN_BARANG,
	$NAMA,
	$MEREK,
	$SPESIFIKASI_SINGKAT,
	$KETERANGAN,
	$ID_VENDOR_PERTAMA,
	$HARGA_SATUAN_BARANG_VENDOR_PERTAMA,
	$HARGA_TOTAL_VENDOR_PERTAMA,
	$ID_VENDOR_KEDUA,
	$HARGA_SATUAN_BARANG_VENDOR_KEDUA,
	$HARGA_TOTAL_VENDOR_KEDUA,
	$ID_VENDOR_KETIGA,
	$HARGA_SATUAN_BARANG_VENDOR_KETIGA,
	$HARGA_TOTAL_VENDOR_KETIGA)
	{
		$hasil = $this->db->query("UPDATE khp_form SET 
			JUMLAH_MINTA='$JUMLAH_MINTA',
			SATUAN_BARANG='$SATUAN_BARANG',
			NAMA_BARANG='$NAMA',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			KETERANGAN='$KETERANGAN',
			ID_VENDOR_PERTAMA='$ID_VENDOR_PERTAMA',
			HARGA_SATUAN_BARANG_VENDOR_PERTAMA='$HARGA_SATUAN_BARANG_VENDOR_PERTAMA',
			HARGA_TOTAL_VENDOR_PERTAMA='$HARGA_TOTAL_VENDOR_PERTAMA',
			ID_VENDOR_KEDUA='$ID_VENDOR_KEDUA',
			HARGA_SATUAN_BARANG_VENDOR_KEDUA='$HARGA_SATUAN_BARANG_VENDOR_KEDUA',
			HARGA_TOTAL_VENDOR_KEDUA='$HARGA_TOTAL_VENDOR_KEDUA',
			ID_VENDOR_KETIGA='$ID_VENDOR_KETIGA',
			HARGA_SATUAN_BARANG_VENDOR_KETIGA='$HARGA_SATUAN_BARANG_VENDOR_KETIGA',
			HARGA_TOTAL_VENDOR_KETIGA='$HARGA_TOTAL_VENDOR_KETIGA'
			WHERE ID_KHP_FORM='$ID_KHP_FORM'");
		return $hasil;
	}

	function update_data_from_excel($ID_KHP,
	$ID_KHP_FORM,
	$NAMA_BARANG,
	$MEREK,
	$SPESIFIKASI_SINGKAT,
	$JUMLAH_MINTA,
	$SATUAN_BARANG,
	$HARGA_SATUAN_BARANG_VENDOR_PERTAMA,
	$HARGA_TOTAL_VENDOR_PERTAMA,
	$HARGA_SATUAN_BARANG_VENDOR_KEDUA,
	$HARGA_TOTAL_VENDOR_KEDUA,
	$HARGA_SATUAN_BARANG_VENDOR_KETIGA,
	$HARGA_TOTAL_VENDOR_KETIGA)
	{
		$hasil = $this->db->query("UPDATE khp_form SET 
			JUMLAH_MINTA='$JUMLAH_MINTA',
			SATUAN_BARANG='$SATUAN_BARANG',
			NAMA_BARANG='$NAMA_BARANG',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			HARGA_SATUAN_BARANG_VENDOR_PERTAMA='$HARGA_SATUAN_BARANG_VENDOR_PERTAMA',
			HARGA_TOTAL_VENDOR_PERTAMA='$HARGA_TOTAL_VENDOR_PERTAMA',
			HARGA_SATUAN_BARANG_VENDOR_KEDUA='$HARGA_SATUAN_BARANG_VENDOR_KEDUA',
			HARGA_TOTAL_VENDOR_KEDUA='$HARGA_TOTAL_VENDOR_KEDUA',
			HARGA_SATUAN_BARANG_VENDOR_KETIGA='$HARGA_SATUAN_BARANG_VENDOR_KETIGA',
			HARGA_TOTAL_VENDOR_KETIGA='$HARGA_TOTAL_VENDOR_KETIGA'
			WHERE ID_KHP_FORM='$ID_KHP_FORM' AND ID_KHP='$ID_KHP' ");
		return $hasil;
	}

	function update_data_penetapan_vendor($ID_KHP_FORM, $ID_VENDOR_FIX)
	{
		$hasil = $this->db->query("UPDATE khp_form SET 
			ID_VENDOR_FIX='$ID_VENDOR_FIX'
			WHERE ID_KHP_FORM='$ID_KHP_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menghapus data rfq berdasarkan ID_KHP_FORM
	//SUMBER TABEL: tabel KHP_form
	//DIPAKAI: 1. controller KHP_form / function hapus_data
	//         2. 
	function hapus_data_by_id_khp_form($ID_KHP_FORM)
	{
		$hasil = $this->db->query("DELETE FROM khp_form WHERE ID_KHP_FORM='$ID_KHP_FORM'");
		return $hasil;
	}

	function hapus_data_by_id_khp($ID_KHP) //122023
	{
		$hasil = $this->db->query("DELETE FROM khp_form WHERE ID_KHP='$ID_KHP'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data catatat RFQ form berdasarkan ID_KHPFORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_keterangan_barang
	//         2. 
	function get_keterangan_by_id_khp_form($ID_KHP_FORM)
	{
		$hsl = $this->db->query("SELECT 
		ID_KHP_FORM, 
		KETERANGAN

		FROM RFQ_FORM

        WHERE ID_KHP_FORM = '$ID_KHP_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KHP_FORM' => $data->ID_KHP_FORM,
					'KETERANGAN' => $data->KETERANGAN
				);
			}
		} else {
			$hasil = "TIDAK ADA KETERANGAN";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data rfq berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel khp_form
	//DIPAKAI: 1. controller khp_form / function update_data_keterangan_barang
	//         2. 
	function update_data_keterangan_barang($ID_KHP_FORM, $KETERANGAN)
	{
		$hasil = $this->db->query("UPDATE khp_form SET 
			KETERANGAN='$KETERANGAN' 
			WHERE ID_KHP_FORM='$ID_KHP_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data rfq berdasarkan ID_FPB_FORM
	//SUMBER TABEL: tabel khp_form
	//DIPAKAI: 1. controller khp_form / function update_data_keterangan_barang
	//         2. 
	function update_data_harga_barang($ID_KHP_FORM, $HARGA_SATUAN_BARANG, $HARGA_TOTAL)
	{
		$hasil = $this->db->query("UPDATE khp_form SET 
			HARGA_SATUAN_BARANG='$HARGA_SATUAN_BARANG',
			HARGA_TOTAL='$HARGA_TOTAL'
			WHERE ID_KHP_FORM='$ID_KHP_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data catatat RFQ form berdasarkan ID_KHPFORM
	//SUMBER TABEL: tabel FPB_form
	//DIPAKAI: 1. controller FPB_form / function update_data_keterangan_barang
	//         2. 
	function get_keterangan_by_id_rfq($ID_KHP)
	{
		$hsl = $this->db->query("SELECT 
		*
		FROM RFQ_FORM

        WHERE ID_KHP = '$ID_KHP'");
		return $hsl->result();
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

	function sppb_form_list_where_not_in_rfq($ID_KHP, $ID_SPPB) //112023
	{
		$hasil = $this->db->query("SELECT M.ID_BARANG_MASTER, M.KODE_BARANG,  M.HASH_MD5_BARANG_MASTER, SS.ID_SPPB, SS.NO_URUT_SPPB, SS.HASH_MD5_SPPB, DATE_FORMAT(SF.TANGGAL_MULAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_MULAI_PAKAI_HARI, DATE_FORMAT(SF.TANGGAL_SELESAI_PAKAI_HARI, '%d/%m/%Y') AS TANGGAL_SELESAI_PAKAI_HARI, SF.ID_SPPB_FORM, SF.JUMLAH_MINTA, SF.JUMLAH_QTY_SPP, SF.NAMA_BARANG, SF.MEREK, SF.PERALATAN_PERLENGKAPAN, SF.SPESIFIKASI_SINGKAT, SF.STATUS_SPPB, SF.CORET, SF.SATUAN_BARANG, J.NAMA_JENIS_BARANG, J.ID_JENIS_BARANG, SS.ID_PROYEK, SF.ID_KLASIFIKASI_BARANG, KB.NAMA_KLASIFIKASI_BARANG, PSP.NAMA_SUB_PEKERJAAN, RABF.NAMA_KATEGORI
		FROM SPPB_FORM as SF
        LEFT JOIN sppb as SS ON SS.ID_SPPB = SF.ID_SPPB
		LEFT JOIN barang_master as M ON M.ID_BARANG_MASTER=SF.ID_BARANG_MASTER 
		LEFT JOIN jenis_barang as J ON M.ID_JENIS_BARANG=J.ID_JENIS_BARANG OR SF.ID_JENIS_BARANG=J.ID_JENIS_BARANG
		LEFT JOIN klasifikasi_barang as KB ON KB.ID_KLASIFIKASI_BARANG = SF.ID_KLASIFIKASI_BARANG
        LEFT JOIN proyek_sub_pekerjaan as PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = SF.ID_PROYEK_SUB_PEKERJAAN
		LEFT JOIN RAB_FORM as RABF ON RABF.ID_RAB_FORM = SF.ID_RAB_FORM
		WHERE 
            NOT EXISTS
                (SELECT khp_form.ID_SPPB_FORM, khp_form.ID_BARANG_MASTER
                 FROM khp_form WHERE khp_form.ID_SPPB_FORM = SF.ID_SPPB_FORM
                AND khp_form.ID_KHP = '$ID_KHP')
        AND SF.ID_SPPB = '$ID_SPPB' AND SF.STATUS_SPPB = 'SELESAI' AND SF.CORET <> 1 AND SF.JUMLAH_QTY_SPP > 0 AND SS.ID_PROYEK = (SELECT komparasi_harga_pemasok.ID_PROYEK FROM komparasi_harga_pemasok where komparasi_harga_pemasok.ID_KHP = '$ID_KHP')");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk mengubah data RFQ form by ID_KHP
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB_form / function update_data_kirim_sppb
	//         2. 
	function update_data_kirim_khp($ID_KHP, $PROGRESS_KHP, $STATUS_KHP)
	{
		$hasil = $this->db->query("UPDATE komparasi_harga_pemasok SET 
			PROGRESS_KHP='$PROGRESS_KHP',
			STATUS_KHP='$STATUS_KHP' 
			WHERE ID_KHP='$ID_KHP'");
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

	//FUNGSI: Fungsi ini untuk menambahkan data sppb form ID_USER
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller SPPB_form / function logout
	//         2. controller SPPB_form / function user_log

	function user_log_khp_form($ID_USER, $ID_KHP_FORM,  $KETERANGAN, $WAKTU) //112023
	{
		$db2 = $this->load->database('logs', TRUE);

		$hasil = $db2->query("INSERT INTO user_log_khp_form (ID_USER, ID_KHP_FORM, KETERANGAN, WAKTU) VALUES('$ID_USER', '$ID_KHP_FORM', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
