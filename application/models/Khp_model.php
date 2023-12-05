<?php
class KHP_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb yang barangnya tidak ada di gudang
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller KHP / function index
	//         2. 
	// function rfq_list_by_id_sppb($ID_SPPB)
	// {
	// 	$hasil = $this->db->query("SELECT DISTINCT V.NAMA_VENDOR from rfq_form as RF LEFT JOIN request_for_quotation as RFQ on RFQ.ID_RFQ = RF.ID_RFQ LEFT JOIN vendor as V on V.ID_VENDOR = RFQ.ID_VENDOR WHERE RF.ID_SPPB = '$ID_SPPB'");
	// 	return $hasil;
	// }

	// function sppb_list_rfq_by_hashmd5($HASH_MD5_SPPB)
	// {
	// 	$hasil = $this->db->query("SELECT DISTINCT SF.ID_SPPB, S.NO_URUT_SPPB, P.NAMA_PROYEK, S.TANGGAL_PEMBUATAN_SPPB_HARI, S.HASH_MD5_SPPB from sppb_form as SF LEFT JOIN sppb AS S on S.ID_SPPB = SF.ID_SPPB LEFT JOIN proyek as P on P.ID_PROYEK = S.ID_PROYEK WHERE( SF.GUDANG_TERSEDIA = 'TIDAK' AND S.HASH_MD5_SPPB = '$HASH_MD5_SPPB')");
	// 	return $hasil->result();
	// }

	// function sppb_list_khp()
	// {
	// 	$hasil = $this->db->query("SELECT S.ID_SPPB, S.NO_URUT_SPPB, DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB, S.HASH_MD5_SPPB, P.NAMA_PROYEK from sppb AS S LEFT JOIN proyek AS P on P.ID_PROYEK = S.ID_PROYEK WHERE S.PROGRESS_SPPB = 'SPPB Pembelian Disetujui'");
	// 	return $hasil->result();
	// }

	function sppb_list_by_id_sppb($ID_SPPB) //092023
	{
		$hasil = $this->db->query("SELECT S.ID_SPPB, S.HASH_MD5_SPPB, S.SUB_PROYEK, PSP.ID_PROYEK_SUB_PEKERJAAN, PSP.NAMA_SUB_PEKERJAAN, P.NAMA_PROYEK, P.HASH_MD5_PROYEK, DATE_FORMAT(S.TANGGAL_DOKUMEN_SPPB, '%d/%m/%Y') AS TANGGAL_DOKUMEN_SPPB,S.NO_URUT_SPPB,S.TANGGAL_PEMBUATAN_SPPB_JAM,DATE_FORMAT(S.TANGGAL_PEMBUATAN_SPPB_HARI, '%d/%m/%Y') AS TANGGAL_PEMBUATAN_SPPB_HARI,S.TANGGAL_PEMBUATAN_SPPB_BULAN,S.TANGGAL_PEMBUATAN_SPPB_TAHUN,S.DUE_DATE_PM,S.DUE_DATE_M_LOG,S.DUE_DATE_MANAGER,S.DUE_DATE_DIR,S.DOK_SPPB,S.PROGRESS_SPPB,S.STATUS_SPPB, S.CTT_DEPT_PROC
		FROM sppb AS S 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
        LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = S.ID_PROYEK_SUB_PEKERJAAN
        WHERE S.ID_SPPB =  '$ID_SPPB' ORDER BY S.NO_URUT_SPPB DESC");
		return $hasil;
	}

	function list_KHP_by_id_proyek($ID_PROYEK)//092023
	{
		$hasil = $this->db->query("SELECT KHP.HASH_MD5_KHP, KHP.NO_URUT_KHP, KHP.STATUS_KHP, DATE_FORMAT(KHP.TANGGAL_DOKUMEN_KHP, '%d/%m/%Y') AS TANGGAL_DOKUMEN_KHP, P.NAMA_PROYEK, PSP.NAMA_SUB_PEKERJAAN, SPB.ID_SPPB, SPB.HASH_MD5_SPPB FROM komparasi_harga_pemasok AS KHP
		LEFT JOIN sppb AS SPB on SPB.ID_SPPB = KHP.ID_SPPB
		LEFT JOIN proyek AS P on P.ID_PROYEK = KHP.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = KHP.ID_PROYEK_SUB_PEKERJAAN
		WHERE KHP.ID_PROYEK = '$ID_PROYEK'");
		return $hasil->result();
	}

	function khp_list_khp_by_hashmd5($HASH_MD5_KHP) //112023
	{

		$hasil = $this->db->query("SELECT * from komparasi_harga_pemasok WHERE ( HASH_MD5_KHP = '$HASH_MD5_KHP')");
		return $hasil;
	}

	// function rfq_list_by_ID_VENDOR($ID_VENDOR, $WAKTU)
	// {

	// 	$hasil = $this->db->query("SELECT * from request_for_quotation WHERE ( ID_VENDOR = '$ID_VENDOR') AND ( BATAS_AKHIR > '$WAKTU' ) AND ( STATUS_VENDOR = '')");
	// 	return $hasil->result();
	// }

	function list_KHP_by_all_proyek()//092023
	{
		$hasil = $this->db->query("SELECT KHP.HASH_MD5_KHP, KHP.NO_URUT_KHP, KHP.STATUS_KHP, DATE_FORMAT(KHP.TANGGAL_DOKUMEN_KHP, '%d/%m/%Y') AS TANGGAL_DOKUMEN_KHP, P.NAMA_PROYEK, PSP.NAMA_SUB_PEKERJAAN, SPB.ID_SPPB, SPB.HASH_MD5_SPPB FROM komparasi_harga_pemasok AS KHP
		LEFT JOIN sppb AS SPB on SPB.ID_SPPB = KHP.ID_SPPB
		LEFT JOIN proyek AS P on P.ID_PROYEK = KHP.ID_PROYEK
		LEFT JOIN proyek_sub_pekerjaan AS PSP ON PSP.ID_PROYEK_SUB_PEKERJAAN = KHP.ID_PROYEK_SUB_PEKERJAAN ");
		return $hasil->result();
	}

	function get_data_sub_pekerjaan_by_id_sppb($ID_SPPB) //112023
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

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut KHP  berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel rfq
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut
	//         2. 
	// function get_nomor_urut_by_id_proyek($ID_PROYEK)
	// {
	// 	$hsl = $this->db->query("SELECT MAX(KHP.JUMLAH_COUNT) AS JUMLAH_COUNT_KHP FROM komparasi_harga_pemasok AS KHP WHERE KHP.ID_PROYEK ='$ID_PROYEK'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'JUMLAH_COUNT_KHP' => $data->JUMLAH_COUNT_KHP
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA KHP";
	// 	}
	// 	return $hasil;
	// }

	function get_data_sppb_by_id_proyek($ID_PROYEK) //112023
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


	function get_data_khp_by_HASH_MD5_KHP($HASH_MD5_KHP) //112023
	{
		$hsl = $this->db->query("SELECT * FROM komparasi_harga_pemasok WHERE HASH_MD5_KHP ='$HASH_MD5_KHP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KHP' => $data->ID_KHP,
					'HASH_MD5_KHP' => $data->HASH_MD5_KHP,
					'NO_URUT_KHP' => $data->NO_URUT_KHP,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'ID_VENDOR_PERTAMA' => $data->ID_VENDOR_PERTAMA,
					'ID_VENDOR_KEDUA' => $data->ID_VENDOR_KEDUA,
					'ID_VENDOR_KETIGA' => $data->ID_VENDOR_KETIGA,
					'DELIVERY_VENDOR_PERTAMA' => $data->DELIVERY_VENDOR_PERTAMA,
					'DELIVERY_VENDOR_KEDUA' => $data->DELIVERY_VENDOR_KEDUA,
					'DELIVERY_VENDOR_KETIGA' => $data->DELIVERY_VENDOR_KETIGA,
					'SISTEM_BAYAR_VENDOR_PERTAMA' => $data->SISTEM_BAYAR_VENDOR_PERTAMA,
					'SISTEM_BAYAR_VENDOR_KEDUA' => $data->SISTEM_BAYAR_VENDOR_KEDUA,
					'SISTEM_BAYAR_VENDOR_KETIGA' => $data->SISTEM_BAYAR_VENDOR_KETIGA,
					'PROGRESS_KHP' => $data->PROGRESS_KHP,
					'STATUS_KHP' => $data->STATUS_KHP,
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_data_khp_by_ID_KHP($ID_KHP) //122023
	{
		$hsl = $this->db->query("SELECT * FROM komparasi_harga_pemasok WHERE ID_KHP ='$ID_KHP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KHP' => $data->ID_KHP,
					'HASH_MD5_KHP' => $data->HASH_MD5_KHP,
					'NO_URUT_KHP' => $data->NO_URUT_KHP,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'ID_VENDOR_PERTAMA' => $data->ID_VENDOR_PERTAMA,
					'ID_VENDOR_KEDUA' => $data->ID_VENDOR_KEDUA,
					'ID_VENDOR_KETIGA' => $data->ID_VENDOR_KETIGA,
					'DELIVERY_VENDOR_PERTAMA' => $data->DELIVERY_VENDOR_PERTAMA,
					'DELIVERY_VENDOR_KEDUA' => $data->DELIVERY_VENDOR_KEDUA,
					'DELIVERY_VENDOR_KETIGA' => $data->DELIVERY_VENDOR_KETIGA,
					'SISTEM_BAYAR_VENDOR_PERTAMA' => $data->SISTEM_BAYAR_VENDOR_PERTAMA,
					'SISTEM_BAYAR_VENDOR_KEDUA' => $data->SISTEM_BAYAR_VENDOR_KEDUA,
					'SISTEM_BAYAR_VENDOR_KETIGA' => $data->SISTEM_BAYAR_VENDOR_KETIGA,
					'PROGRESS_KHP' => $data->PROGRESS_KHP,
					'STATUS_KHP' => $data->STATUS_KHP,
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	// function get_list_khp_by_id_sppb($ID_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT HASH_MD5_KHP, NO_URUT_KHP, STATUS_KHP, DATE_FORMAT(TANGGAL_DOKUMEN_KHP, '%d/%m/%Y') AS TANGGAL_DOKUMEN_KHP, ID_KHP FROM komparasi_harga_pemasok WHERE ID_SPPB ='$ID_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		return $hsl->result();
	// 	} else {
	// 		return 'TIDAK ADA DATA';
	// 	}
	// }

	function cek_nomor_urut_KHP($NO_URUT_KHP) //112023
	{
		$hsl = $this->db->query("SELECT ID_KHP, HASH_MD5_KHP, NO_URUT_KHP FROM komparasi_harga_pemasok WHERE NO_URUT_KHP ='$NO_URUT_KHP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KHP ' => $data->ID_KHP,
					'HASH_MD5_KHP' => $data->HASH_MD5_KHP,
					'NO_URUT_KHP' => $data->NO_URUT_KHP
				);
			}
			return $hasil;
		} else {
			return 'DATA BELUM ADA';
		}
	}

	//FUNGSI: Fungsi ini untuk menambahkan data KHP
	//SUMBER TABEL: tabel sppb_form
	//DIPAKAI: 1. controller KHP_form / function simpan_data_dari_barang_master
	//         2. 
	//1102023
	function simpan_data_khp(
		$ID_SPPB,
		$ID_PROYEK,
		$ID_PROYEK_SUB_PEKERJAAN,
		$FILE_NAME_TEMP,
		$JUMLAH_COUNT_KHP,
		$TANGGAL_DOKUMEN_KHP,
		$NO_URUT_KHP,
		$CREATE_BY_USER,
		$PROGRESS_KHP,
		$STATUS_KHP,
		$TANGGAL_PEMBUATAN_KHP_JAM,
		$TANGGAL_PEMBUATAN_KHP_HARI,
		$TANGGAL_PEMBUATAN_KHP_BULAN,
		$TANGGAL_PEMBUATAN_KHP_TAHUN
	) {
		$hasil = $this->db->query(
			"INSERT INTO komparasi_harga_pemasok
			(
				ID_SPPB,
				ID_PROYEK,
				ID_PROYEK_SUB_PEKERJAAN,
				FILE_NAME_TEMP,
				JUMLAH_COUNT,
				TANGGAL_DOKUMEN_KHP,
				NO_URUT_KHP,
				CREATE_BY_USER,
				PROGRESS_KHP,
				STATUS_KHP,
                TANGGAL_PEMBUATAN_KHP_JAM,
                TANGGAL_PEMBUATAN_KHP_HARI,
                TANGGAL_PEMBUATAN_KHP_BULAN,
                TANGGAL_PEMBUATAN_KHP_TAHUN
			)
			VALUES
			(
				'$ID_SPPB',
				'$ID_PROYEK',
				'$ID_PROYEK_SUB_PEKERJAAN',
				'$FILE_NAME_TEMP',
				'$JUMLAH_COUNT_KHP',
				'$TANGGAL_DOKUMEN_KHP',
				'$NO_URUT_KHP',
				'$CREATE_BY_USER',
				'$PROGRESS_KHP',
				'$STATUS_KHP',
                '$TANGGAL_PEMBUATAN_KHP_JAM',
                '$TANGGAL_PEMBUATAN_KHP_HARI',
                '$TANGGAL_PEMBUATAN_KHP_BULAN',
                '$TANGGAL_PEMBUATAN_KHP_TAHUN'
				
			)"
		);

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengeset HASH_MD5_SPPB berdasarkan ID_RASD
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function set_md5_id_KHP($ID_PROYEK, $ID_SPPB, $NO_URUT_KHP, $CREATE_BY_USER) //112023
	{
		$hsl = $this->db->query("SELECT ID_KHP FROM komparasi_harga_pemasok WHERE ID_PROYEK='$ID_PROYEK' AND
		ID_SPPB='$ID_SPPB' AND NO_URUT_KHP='$NO_URUT_KHP' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KHP' => $data->ID_KHP
				);
			}
		} else {
			$hasil = "BELUM ADA KHP";
		}
		$ID_KHP = $hasil['ID_KHP'];
		$HASH_MD5_KHP = md5($ID_KHP);
		$hasil = $this->db->query("UPDATE komparasi_harga_pemasok SET HASH_MD5_KHP='$HASH_MD5_KHP' WHERE ID_KHP='$ID_KHP'");

		// $hsl_2 = $this->db->query("SELECT SF.ID_SPPB_FORM, SF.ID_SPPB, SF.ID_RASD_FORM, SF.ID_FPB_FORM, SF.ID_BARANG_MASTER, SF.ID_SATUAN_BARANG, SF.ID_JENIS_BARANG, SF.NAMA_BARANG, SF.MEREK, SF.SPESIFIKASI_SINGKAT, SF.JUMLAH_SETUJU_TERAKHIR, FPBF.ID_FPB
		// FROM sppb_form AS SF
        // LEFT JOIN fpb_form AS FPBF ON SF.ID_FPB_FORM = FPBF.ID_FPB_FORM
		// WHERE SF.ID_SPPB = '$ID_SPPB' AND SF.JUMLAH_QTY_SPP > 0;");
		// if ($hsl_2->num_rows() > 0) {
		// 	foreach ($hsl_2->result() as $data) {
		// 		$hasil_2 = array(
		// 			'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
		// 			'ID_SPPB' => $data->ID_SPPB,
		// 			'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
		// 			'ID_SATUAN_BARANG' => $data->ID_SATUAN_BARANG,
		// 			'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
		// 			'ID_FPB' => $data->ID_FPB,
		// 			'ID_FPB_FORM' => $data->ID_FPB_FORM,
		// 			'NAMA_BARANG' => $data->NAMA_BARANG,
		// 			'MEREK' => $data->MEREK,
		// 			'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
		// 			'JUMLAH_SETUJU_TERAKHIR' => $data->JUMLAH_SETUJU_TERAKHIR
		// 		);

		// 		$this->db->query(
		// 			"INSERT INTO khp_form (ID_KHP, 
		// 			ID_SPPB_FORM, 
		// 			ID_SPPB, 
		// 			ID_RASD_FORM, 
		// 			ID_BARANG_MASTER, 
		// 			ID_FPB, 
		// 			ID_FPB_FORM, 
		// 			ID_SATUAN_BARANG, 
		// 			ID_JENIS_BARANG, 
		// 			NAMA_BARANG, 
		// 			MEREK, 
		// 			SPESIFIKASI_SINGKAT, 
		// 			JUMLAH_MINTA)
		// 			VALUES ('$ID_KHP', 
		// 			'$data->ID_SPPB_FORM', 
		// 			'$data->ID_SPPB', 
		// 			'$data->ID_RASD_FORM', 
		// 			'$data->ID_BARANG_MASTER',
		// 			'$data->ID_FPB',
		// 			'$data->ID_FPB_FORM',
		// 			'$data->ID_SATUAN_BARANG', 
		// 			'$data->ID_JENIS_BARANG', 
		// 			'$data->NAMA_BARANG',
		// 			'$data->MEREK',
		// 			'$data->SPESIFIKASI_SINGKAT',
		// 			'$data->JUMLAH_SETUJU_TERAKHIR')"
		// 		);

		// 		$this->db->query(
		// 			"UPDATE fpb_form SET 
		// 			STATUS_KHP='Dalam Proses KHP', KET_KHP='$ID_KHP'
		// 			WHERE ID_FPB_FORM='$data->ID_FPB_FORM'"
		// 		);
		// 	}
		// }

		// $hsl_3 = $this->db->query("SELECT KF.ID_KHP_FORM, KF.ID_KHP, KF.ID_SPPB, KF.ID_SPPB_FORM, KF.NAMA_BARANG FROM khp_form as KF WHERE KF.ID_SPPB = '$ID_SPPB' AND KF.ID_KHP = '$ID_KHP'");
		// if ($hsl_3->num_rows() > 0) {
		// 	foreach ($hsl_3->result() as $data_3) {
		// 		$hasil_3 = array(
		// 			'ID_KHP_FORM' => $data_3->ID_KHP_FORM,
		// 			'ID_KHP' => $data_3->ID_KHP,
		// 			'ID_SPPB' => $data_3->ID_SPPB,
		// 			'ID_SPPB_FORM' => $data_3->ID_SPPB_FORM,
		// 			'NAMA_BARANG' => $data_3->NAMA_BARANG
		// 		);

		// 		$hsl_4 = $this->db->query("SELECT RF.ID_RFQ_FORM, RF.ID_SPPB, RF.ID_SPPB_FORM, RF.NAMA_BARANG, R.ID_VENDOR, R.ID_RFQ, RF.HARGA_SATUAN_BARANG, RF.HARGA_TOTAL, R.ID_VENDOR, R.LOKASI_PENYERAHAN, R.TOP FROM rfq_form as RF LEFT JOIN request_for_quotation AS R ON R.ID_RFQ = RF.ID_RFQ WHERE RF.ID_SPPB = '$data_3->ID_SPPB' AND R.PROGRESS_RFQ = 'Terisi Vendor' AND RF.ID_SPPB_FORM = '$data_3->ID_SPPB_FORM'");
		// 		foreach ($hsl_4->result() as $data_4) {
		// 			$hasil_4 = array(
		// 				'ID_RFQ_FORM' => $data_4->ID_RFQ_FORM,
		// 				'ID_SPPB' => $data_4->ID_SPPB,
		// 				'ID_SPPB_FORM' => $data_4->ID_SPPB_FORM,
		// 				'ID_VENDOR' => $data_4->ID_VENDOR,
		// 				'ID_RFQ' => $data_4->ID_RFQ,
		// 				'HARGA_SATUAN_BARANG' => $data_4->HARGA_SATUAN_BARANG,
		// 				'HARGA_TOTAL' => $data_4->HARGA_TOTAL,
		// 				'LOKASI_PENYERAHAN' => $data_4->LOKASI_PENYERAHAN,
		// 				'TOP' => $data_4->TOP
		// 			);
		// 			$this->db->query(
		// 				"INSERT INTO harga_barang_pemasok (ID_SPPB, ID_SPPB_FORM, ID_RFQ, ID_RFQ_FORM, ID_VENDOR, ID_KHP_FORM, ID_KHP, HARGA_SATUAN_BARANG, HARGA_TOTAL, LOKASI_PENYERAHAN, SISTEM_BAYAR_VENDOR)
		// 				VALUES ('$data_4->ID_SPPB', '$data_4->ID_SPPB_FORM', '$data_4->ID_RFQ', '$data_4->ID_RFQ_FORM', '$data_4->ID_VENDOR', '$data_3->ID_KHP_FORM', '$data_3->ID_KHP', '$data_4->HARGA_SATUAN_BARANG', '$data_4->HARGA_TOTAL', '$data_4->LOKASI_PENYERAHAN', '$data_4->TOP')"
		// 			);
		// 		}
		// 	}
		// }

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data nomor urut sppb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_nomor_urut_by_id_proyek
	//         2. 
	// function get_data_proyek_by_hash_md5_sppb($HASH_MD5_SPPB)
	// {
	// 	$hsl = $this->db->query("SELECT S.ID_PROYEK, S.NO_URUT_SPPB, S.ID_SPPB, S.ID_PROYEK_SUB_PEKERJAAN, S.SUB_PROYEK, P.NAMA_PROYEK, P.LOKASI, P.INISIAL from sppb as S 
	// 	LEFT JOIN proyek AS P ON S.ID_PROYEK = P.ID_PROYEK
	// 	WHERE S.HASH_MD5_SPPB = '$HASH_MD5_SPPB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_PROYEK' => $data->ID_PROYEK,
	// 				'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
	// 				'NAMA_PROYEK' => $data->NAMA_PROYEK,
	// 				'SUB_PROYEK' => $data->SUB_PROYEK,
	// 				'LOKASI' => $data->LOKASI,
	// 				'INISIAL' => $data->INISIAL,
	// 				'NO_URUT_SPPB' => $data->NO_URUT_SPPB,
	// 				'ID_SPPB' => $data->ID_SPPB
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA PROYEK";
	// 	}
	// 	return $hasil;
	// }
	

	//FUNGSI: Fungsi ini untuk menampilkan data KHP berdasarkan yang baru diinput
	//SUMBER TABEL: tabel KHP
	//DIPAKAI: 1. controller KHP / function get_data_rfq_baru
	//         2. 
	function get_data_khp_baru($ID_PROYEK, $NO_URUT_KHP, $CREATE_BY_USER) //112023
	{
		$hsl = $this->db->query("SELECT * FROM komparasi_harga_pemasok WHERE ID_PROYEK = '$ID_PROYEK' AND
		NO_URUT_KHP = '$NO_URUT_KHP' AND
		CREATE_BY_USER = '$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_KHP' => $data->HASH_MD5_KHP
				);
			}
		} else {
			$hasil = "BELUM ADA KHP";
		}
		return $hasil;
	}



	//FUNGSI: Fungsi ini untuk menampilkan data KHP berdasarkan ID_KHP
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller KHP_form / function index

	function khp_list_by_id_khp($ID_KHP)//112023
	{
		$hasil = $this->db->query("SELECT
		KHP.ID_KHP,
		KHP.HASH_MD5_KHP,
		KHP.ID_SPPB,
		KHP.ID_PROYEK,
		KHP.ID_PROYEK_SUB_PEKERJAAN,
		KHP.ID_RASD,
		KHP.ID_VENDOR,
		KHP.ID_VENDOR_PERTAMA,
		KHP.DELIVERY_VENDOR_PERTAMA,
		KHP.SISTEM_BAYAR_VENDOR_PERTAMA,
		KHP.ID_VENDOR_KEDUA,
		KHP.DELIVERY_VENDOR_KEDUA,
		KHP.SISTEM_BAYAR_VENDOR_KEDUA,
		KHP.ID_VENDOR_KETIGA,
		KHP.DELIVERY_VENDOR_KETIGA,
		KHP.SISTEM_BAYAR_VENDOR_KETIGA,
		KHP.ID_HBP,
		KHP.TOP,
		KHP.LOKASI_PENYERAHAN,
		KHP.SUB_PROYEK,
		KHP.JUMLAH_COUNT,
		KHP.PROGRESS_KHP,
		KHP.STATUS_KHP,
		KHP.NO_URUT_KHP,
		KHP.FILE_NAME_TEMP,
		KHP.TANGGAL_DOKUMEN_KHP AS TANGGAL_DOKUMEN_KHP_INDO,
		DATE_FORMAT(KHP.TANGGAL_DOKUMEN_KHP, '%d/%m/%Y') AS TANGGAL_DOKUMEN_KHP,
		KHP.TANGGAL_PEMBUATAN_KHP_JAM,
		KHP.TANGGAL_PEMBUATAN_KHP_HARI,
		KHP.TANGGAL_PEMBUATAN_KHP_BULAN,
		KHP.TANGGAL_PEMBUATAN_KHP_TAHUN,
		KHP.KETERANGAN_KHP,
		KHP.CTT_STAFF_PROC,
		KHP.CTT_KASIE,
		KHP.CTT_MANAGER_PROC,
		KHP.CREATE_BY_USER,
		P.NAMA_PROYEK,
		SPPB.NO_URUT_SPPB
        FROM komparasi_harga_pemasok AS KHP
		LEFT JOIN SPPB AS SPPB ON SPPB.ID_SPPB = KHP.ID_SPPB
		LEFT JOIN proyek AS P ON P.ID_PROYEK = KHP.ID_PROYEK
        WHERE KHP.ID_KHP = '$ID_KHP'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data rfq form berdasarkan ID_KHP_FORM
	//SUMBER TABEL: tabel rfq
	//DIPAKAI: 1. controller KHP_form / function simpan_perubahan_pdf
	//         
	// function simpan_perubahan_pdf($ID_KHP, $LOKASI_PENYERAHAN, $ID_VENDOR, $TOP, $TANGGAL_PEMBUATAN_KHP_HARI, $PROGRESS_KHP)
	// {
	// 	$hasil = $this->db->query("UPDATE request_for_quotation SET 
	// 		LOKASI_PENYERAHAN='$LOKASI_PENYERAHAN',
	// 		ID_VENDOR='$ID_VENDOR',
	// 		TOP='$TOP',
	// 		TANGGAL_PEMBUATAN_KHP_HARI='$TANGGAL_PEMBUATAN_KHP_HARI',
	// 		PROGRESS_KHP='$PROGRESS_KHP'
	// 		WHERE ID_KHP='$ID_KHP'");
	// 	return $hasil;
	// }

	//112023
	function simpan_identitas_form($ID_KHP, 
		$KETERANGAN_KHP, 
		$ID_VENDOR_PERTAMA, 
		$DELIVERY_VENDOR_PERTAMA, 
		$SISTEM_BAYAR_VENDOR_PERTAMA, 
		$ID_VENDOR_KEDUA, 
		$DELIVERY_VENDOR_KEDUA, 
		$SISTEM_BAYAR_VENDOR_KEDUA, 
		$ID_VENDOR_KETIGA, 
		$DELIVERY_VENDOR_KETIGA, 
		$SISTEM_BAYAR_VENDOR_KETIGA,
		$NO_URUT_KHP_GANTI,
		$TANGGAL_DOKUMEN_KHP)
	{
		$hasil = $this->db->query("UPDATE komparasi_harga_pemasok SET 
			KETERANGAN_KHP='$KETERANGAN_KHP',
			ID_VENDOR_PERTAMA='$ID_VENDOR_PERTAMA',
			DELIVERY_VENDOR_PERTAMA='$DELIVERY_VENDOR_PERTAMA',
			SISTEM_BAYAR_VENDOR_PERTAMA='$SISTEM_BAYAR_VENDOR_PERTAMA',
			ID_VENDOR_KEDUA='$ID_VENDOR_KEDUA',
			DELIVERY_VENDOR_KEDUA='$DELIVERY_VENDOR_KEDUA',
			SISTEM_BAYAR_VENDOR_KEDUA='$SISTEM_BAYAR_VENDOR_KEDUA',
			ID_VENDOR_KETIGA='$ID_VENDOR_KETIGA',
			DELIVERY_VENDOR_KETIGA='$DELIVERY_VENDOR_KETIGA',
			SISTEM_BAYAR_VENDOR_KETIGA='$SISTEM_BAYAR_VENDOR_KETIGA',
			NO_URUT_KHP='$NO_URUT_KHP_GANTI',
			TANGGAL_DOKUMEN_KHP='$TANGGAL_DOKUMEN_KHP'
			
			WHERE ID_KHP='$ID_KHP'");
		return $hasil;
	}

	// function update_progress_khp($HASH_MD5_KHP, $PROGRESS_KHP)
	// {
	// 	$hasil = $this->db->query("UPDATE komparasi_harga_pemasok SET 
	// 		PROGRESS_KHP='$PROGRESS_KHP'
	// 		WHERE HASH_MD5_KHP='$HASH_MD5_KHP'");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menambahkan data sppb berdasarkan ID_USER
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function logout
	//         2. controller SPPB / function user_log
	function user_log_khp($ID_USER, $ID_KHP,  $KETERANGAN, $WAKTU) //112023
	{
		$db2 = $this->load->database('logs', TRUE);

		$hasil = $db2->query("INSERT INTO user_log_khp (ID_USER, ID_KHP, KETERANGAN, WAKTU) VALUES('$ID_USER', '$ID_KHP', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
