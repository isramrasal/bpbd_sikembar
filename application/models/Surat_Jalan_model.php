<?php
class Surat_Jalan_model extends CI_Model
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
	function surat_jalan_list_by_ID_PROYEK_USER_ID($ID_PROYEK, $USER_ID)
	{
		$hasil = $this->db->query("SELECT * FROM surat_jalan WHERE ID_PROYEK = '$ID_PROYEK' AND CREATE_BY_USER = '$USER_ID'");
		return $hasil->result();
	}

	function surat_jalan_list()
	{
		$hasil = $this->db->query("SELECT * FROM surat_jalan AS SJ LEFT JOIN sppb AS S ON S.ID_SPPB = SJ.ID_SPPB");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_PROYEKz
	//SUMBER TABEL: tabel pegawai
	//DIPAKAI: 1. controller FSTB / function data_FSTB
	//         2. 
	function surat_jalan_list_by_ID_PROYEK($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT SJ.NO_SURAT_JALAN, SJ.TANGGAL_PENGAJUAN_SURAT_JALAN, SJ.HASH_MD5_SURAT_JALAN, SJ.PIC_PENERIMA_BARANG, SJ.KEPADA, SJ.NO_HP_PIC, SJ.PROGRESS_SURAT_JALAN, SJ.STATUS_SURAT_JALAN, SJ.TANGGAL_SURAT_JALAN_HARI, S.NO_URUT_SPPB
		FROM surat_jalan AS SJ
        LEFT JOIN sppb AS S ON S.ID_SPPB = SJ.ID_SPPB
		WHERE SJ.ID_PROYEK = '$ID_PROYEK'");
		return $hasil->result();
	}



	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB_form / function index
	//         2. controller FSTB_form / function view
	//         2. controller FSTB_form / function cetak_pdf
	function surat_jalan_list_by_id_surat_jalan($ID_SURAT_JALAN)
	{
		$hasil = $this->db->query("SELECT 
		SJ.ID_SURAT_JALAN, 
		SJ.HASH_MD5_SURAT_JALAN,
        SJ.ID_PROYEK,
        SJ.ID_SPPB,
        SJ.ID_VENDOR,
        SJ.NO_SURAT_JALAN,
        SJ.NO_DELIVERY_NOTE,
        SJ.NO_PACKING_LIST,
        SJ.COUNT_SURAT_JALAN,
        SJ.TANGGAL_SURAT_JALAN_JAM,
        SJ.TANGGAL_SURAT_JALAN_HARI,
        SJ.TANGGAL_SURAT_JALAN_BULAN,
        SJ.TANGGAL_SURAT_JALAN_TAHUN,
        SJ.FILE_NAME_TEMP,
        SJ.FILE_NAME_TEMP_DELIVERY_NOTE,
        SJ.FILE_NAME_TEMP_PACKING_LIST,
        SJ.KEPADA,
        SJ.PIC_PENERIMA_BARANG,
        SJ.NO_HP_PIC,
        SJ.JENIS_PENGIRIMAN,
        SJ.JENIS_KENDARAAN,
        SJ.NO_POLISI,
        SJ.NAMA_PENGEMUDI,
        SJ.NO_HP_PENGEMUDI,
        SJ.DOK_SURAT_JALAN,
        SJ.DOK_DELIVERY_NOTE,
        SJ.DOK_PACKING_LIST,
        SJ.CTT_STAFF_UMUM_LOG_SP,
		SJ.CTT_SPV_LOG_SP,
		SJ.CTT_STAFF_LOG_KP,
		SJ.CTT_KASIE_LOG_KP,
		SJ.CTT_MAN_LOG_KP,
        SJ.CREATE_BY_USER,
        SJ.PROGRESS_SURAT_JALAN,
        SJ.STATUS_SURAT_JALAN,
        SJ.TANGGAL_PENGAJUAN_SURAT_JALAN,
        P.NAMA_PROYEK,
        P.LOKASI,
        P.INISIAL,
        SPPB.NO_URUT_SPPB,
        SPPB.TANGGAL_PEMBUATAN_SPPB_HARI,
        V.NAMA_VENDOR,
        V.ALAMAT_VENDOR,
        V.NO_TELP_VENDOR,
        V.NAMA_PIC_VENDOR,
        V.NAMA_PIC_VENDOR,
        V.NO_HP_PIC_VENDOR,
        V.EMAIL_PIC_VENDOR

        FROM surat_jalan AS SJ
        LEFT JOIN vendor AS V ON SJ.ID_VENDOR = V.ID_VENDOR
        LEFT JOIN proyek AS P ON SJ.ID_PROYEK = P.ID_PROYEK
        LEFT JOIN sppb AS SPPB ON SJ.ID_SPPB = SPPB.ID_SPPB

        WHERE SJ.ID_SURAT_JALAN = '$ID_SURAT_JALAN'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengeset data fstb berdasarkan HASH_MD5_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function simpan_data
	//         2. 
	function set_md5_id_Surat_Jalan($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT ID_SURAT_JALAN FROM surat_jalan WHERE ID_PROYEK_SURAT_JALAN='$ID_PROYEK_SURAT_JALAN' AND
		NO_SURAT_JALAN='$NO_SURAT_JALAN' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SURAT_JALAN' => $data->ID_SURAT_JALAN
				);
			}
		} else {
			$hasil = "BELUM ADA BELUM ADA SURAT JALAN";
		}
		$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
		$HASH_MD5_SURAT_JALAN = md5($ID_SURAT_JALAN);
		$this->db->query("UPDATE surat_jalan SET HASH_MD5_SURAT_JALAN='$HASH_MD5_SURAT_JALAN' WHERE ID_SURAT_JALAN='$ID_SURAT_JALAN'");
	}

	function set_md5_id_Surat_Jalan_ke_sp($ID_PROYEK_SURAT_JALAN, $NO_SURAT_JALAN, $ID_SPPB, $CREATE_BY_USER)
	{
		$hsl = $this->db->query("SELECT ID_SURAT_JALAN FROM surat_jalan WHERE ID_PROYEK_SURAT_JALAN='$ID_PROYEK_SURAT_JALAN' AND
		NO_SURAT_JALAN='$NO_SURAT_JALAN' AND CREATE_BY_USER='$CREATE_BY_USER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SURAT_JALAN' => $data->ID_SURAT_JALAN
				);
			}
		} else {
			$hasil = "BELUM ADA SURAT JALAN";
		}
		$ID_SURAT_JALAN = $hasil['ID_SURAT_JALAN'];
		$HASH_MD5_SURAT_JALAN = md5($ID_SURAT_JALAN);
		$this->db->query("UPDATE surat_jalan SET HASH_MD5_SURAT_JALAN='$HASH_MD5_SURAT_JALAN' WHERE ID_SURAT_JALAN='$ID_SURAT_JALAN'");

		$hsl_2 = $this->db->query("SELECT SPPB.ID_SPPB, SPPB.ID_SPPB_FORM, SPPB.ID_RASD_FORM, SPPB.ID_BARANG_MASTER, SPPB.ID_JENIS_BARANG, SPPB.ID_SATUAN_BARANG, SPPB.NAMA_BARANG, SPPB.MEREK, SPPB.SPESIFIKASI_SINGKAT, SPPB.JUMLAH_SETUJU_TERAKHIR, SPPB.PERALATAN_PERLENGKAPAN, B.GROSS_WEIGHT, B.NETT_WEIGHT, B.DIMENSI_PANJANG, B.DIMENSI_LEBAR, B.DIMENSI_TINGGI
		FROM sppb_form AS SPPB
        LEFT JOIN barang_master AS B ON B.ID_BARANG_MASTER = SPPB.ID_BARANG_MASTER
		WHERE SPPB.ID_SPPB ='$ID_SPPB' AND SPPB.JUMLAH_QTY_SPP = 0");
		if ($hsl_2->num_rows() > 0) {
			foreach ($hsl_2->result() as $data) {
				$hasil_2 = array(
					'ID_SPPB' => $data->ID_SPPB,
					'ID_SPPB_FORM' => $data->ID_SPPB_FORM,
					'ID_RASD_FORM' => $data->ID_RASD_FORM,
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
					'ID_SATUAN_BARANG' => $data->ID_SATUAN_BARANG,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'JUMLAH_SETUJU_TERAKHIR' => $data->JUMLAH_SETUJU_TERAKHIR,
					'GROSS_WEIGHT' => $data->GROSS_WEIGHT,
					'NETT_WEIGHT' => $data->NETT_WEIGHT,
					'DIMENSI_PANJANG' => $data->DIMENSI_PANJANG,
					'DIMENSI_LEBAR' => $data->DIMENSI_LEBAR,
					'DIMENSI_TINGGI' => $data->DIMENSI_TINGGI
				);

				$this->db->query(
					"INSERT INTO surat_jalan_form (ID_SURAT_JALAN, ID_SATUAN_BARANG, ID_JENIS_BARANG, ID_SPPB, ID_RASD_FORM, ID_BARANG_MASTER, NAMA_BARANG, MEREK, PERALATAN_PERLENGKAPAN, SPESIFIKASI_SINGKAT, JUMLAH, GROSS_WEIGHT, NETT_WEIGHT, DIMENSI_PANJANG, DIMENSI_LEBAR, DIMENSI_TINGGI)
					VALUES ('$ID_SURAT_JALAN', '$data->ID_SATUAN_BARANG', '$data->ID_JENIS_BARANG', '$data->ID_SPPB', '$data->ID_RASD_FORM','$data->ID_BARANG_MASTER', '$data->NAMA_BARANG', '$data->MEREK', '$data->PERALATAN_PERLENGKAPAN', '$data->SPESIFIKASI_SINGKAT', '$data->JUMLAH_SETUJU_TERAKHIR', '$data->GROSS_WEIGHT', '$data->NETT_WEIGHT', '$data->DIMENSI_PANJANG', '$data->DIMENSI_LEBAR', '$data->DIMENSI_TINGGI')"
				);
			}
		}
	}

	//FUNGSI: Fungsi ini untuk menghapus data fstb berdasarkan HASH_MD5_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function hapus_data_by_HASH_MD5_FSTB($HASH_MD5_FSTB)
	{
		$hasil = $this->db->query("DELETE FROM fstb WHERE HASH_MD5_FSTB='$HASH_MD5_FSTB'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function get_nomor_urut
	//         2. 
	function get_nomor_urut_by_ID_PROYEK($ID_PROYEK_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT MAX(COUNT_SURAT_JALAN) AS JUMLAH_COUNT FROM surat_jalan WHERE ID_PROYEK_SURAT_JALAN ='$ID_PROYEK_SURAT_JALAN' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'JUMLAH_COUNT' => $data->JUMLAH_COUNT
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan HASH_MD5_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB_form / function index
	//         2. controller FSTB_form / function view
	//         3. controller FSTB_form / function cetak_pdf
	function get_id_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT ID_SURAT_JALAN FROM surat_jalan WHERE HASH_MD5_SURAT_JALAN ='$HASH_MD5_SURAT_JALAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SURAT_JALAN' => $data->ID_SURAT_JALAN,
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA SURAT JALAN";
		}
		return $hasil;
	}

	function get_data_surat_jalan_by_HASH_MD5_SURAT_JALAN($HASH_MD5_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT 
		surat_jalan.ID_SURAT_JALAN,
        surat_jalan.HASH_MD5_SURAT_JALAN,
        surat_jalan.ID_PROYEK,
        surat_jalan.ID_SPPB,
        surat_jalan.ID_VENDOR,
        surat_jalan.NO_SURAT_JALAN,
        surat_jalan.NO_DELIVERY_NOTE,
        surat_jalan.NO_PACKING_LIST,
        surat_jalan.COUNT_SURAT_JALAN,
        surat_jalan.TANGGAL_SURAT_JALAN_JAM,
        surat_jalan.TANGGAL_SURAT_JALAN_HARI,
        surat_jalan.TANGGAL_SURAT_JALAN_BULAN,
        surat_jalan.TANGGAL_SURAT_JALAN_TAHUN,
        surat_jalan.FILE_NAME_TEMP,
        surat_jalan.FILE_NAME_TEMP_DELIVERY_NOTE,
        surat_jalan.FILE_NAME_TEMP_PACKING_LIST,
        surat_jalan.KEPADA,
        surat_jalan.PIC_PENERIMA_BARANG,
        surat_jalan.NO_HP_PIC,
        surat_jalan.JENIS_PENGIRIMAN,
        surat_jalan.JENIS_KENDARAAN,
        surat_jalan.NO_POLISI,
        surat_jalan.NAMA_PENGEMUDI,
        surat_jalan.NO_HP_PENGEMUDI,
        surat_jalan.DOK_SURAT_JALAN,
        surat_jalan.DOK_DELIVERY_NOTE,
        surat_jalan.DOK_PACKING_LIST,
        surat_jalan.CTT_STAFF_UMUM_LOG_SP,
		surat_jalan.CTT_SPV_LOG_SP,
		surat_jalan.CTT_STAFF_LOG_KP,
		surat_jalan.CTT_KASIE_LOG_KP,
		surat_jalan.CTT_MAN_LOG_KP,
        surat_jalan.CREATE_BY_USER,
        surat_jalan.PROGRESS_SURAT_JALAN,
        surat_jalan.STATUS_SURAT_JALAN,
        surat_jalan.TANGGAL_PENGAJUAN_SURAT_JALAN,
        p.ID_PROYEK,
        sp.NO_URUT_SPPB,
        v.ID_VENDOR
		FROM surat_jalan 
		LEFT JOIN proyek AS p ON surat_jalan.ID_PROYEK = p.ID_PROYEK
		LEFT JOIN sppb AS sp ON surat_jalan.ID_SPPB = sp.ID_SPPB
		LEFT JOIN vendor AS v ON surat_jalan.ID_VENDOR = v.ID_VENDOR
		WHERE HASH_MD5_SURAT_JALAN ='$HASH_MD5_SURAT_JALAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SURAT_JALAN' => $data->ID_SURAT_JALAN,
					'ID_SPPB' => $data->ID_SPPB,
					'NO_URUT_SPPB' => $data->NO_URUT_SPPB,
					'KEPADA' => $data->KEPADA,
					'PIC_PENERIMA_BARANG' => $data->PIC_PENERIMA_BARANG,
					'NO_HP_PIC' => $data->NO_HP_PIC,
					'TANGGAL_SURAT_JALAN_HARI' => $data->TANGGAL_SURAT_JALAN_HARI,
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA SURAT JALAN";
		}
		return $hasil;
	}

	function get_data_by_id_FSTB($ID_FSTB)
	{
		$hsl = $this->db->query("SELECT 
		FPB_form.ID_FPB_FORM, 
		FPB_form.NAMA_BARANG, 
		FPB_form.MEREK, 
		FPB_form.JUSTIFIKASI_CHIEF,
		FPB_form.SPESIFIKASI_SINGKAT, 
		FPB_form.JUMLAH_MINTA,
		FPB_form.TANGGAL_MULAI_PAKAI,
		FPB_form.TANGGAL_SELESAI_PAKAI,
		M.ID_BARANG_MASTER, M.KODE_BARANG, M.HASH_MD5_BARANG_MASTER,
        RB.ID_RASD, RB.ID_RASD_FORM,
        J.NAMA_JENIS_BARANG,
        SB.NAMA_SATUAN_BARANG
        FROM FPB_form
        LEFT JOIN barang_master AS M ON FPB_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
        LEFT JOIN rasd_form AS RB ON RB.ID_RASD_FORM = FPB_form.ID_RASD_FORM
        LEFT JOIN jenis_barang AS J ON J.ID_JENIS_BARANG = FPB_form.ID_JENIS_BARANG
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = FPB_form.ID_SATUAN_BARANG 
        WHERE FSTB.ID_FSTB = '$ID_FSTB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FPB_FORM' => $data->ID_FPB_FORM,
					'KODE_BARANG' => $data->KODE_BARANG,
					'HASH_MD5_BARANG_MASTER' => $data->HASH_MD5_BARANG_MASTER,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'JUMLAH_MINTA' => $data->JUMLAH_MINTA,
					'JUSTIFIKASI_CHIEF' => $data->JUSTIFIKASI_CHIEF,
					'TANGGAL_MULAI_PAKAI' => $data->TANGGAL_MULAI_PAKAI,
					'TANGGAL_SELESAI_PAKAI' => $data->TANGGAL_SELESAI_PAKAI
				);
			}
		} else {
			$hasil = "BELUM ADA FPB Barang";
		}
		return $hasil;
		// return $hsl;
	}

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

	// function get_data_by_id_FSTB($ID_FSTB)
	// {
	// 	$hsl = $this->db->query("SELECT 
	// 	S.ID_FSTB, P.NAMA_PROYEK, R.ID_RASD, S.JENIS_PEKERJAAN, S.NO_URUT_FSTB, 
	// 	S.TANGGAL_PENGAJUAN_FSTB_JAM, S.TANGGAL_PENGAJUAN_FSTB_HARI, 
	// 	S.TANGGAL_PENGAJUAN_FSTB_BULAN, S.TANGGAL_PENGAJUAN_FSTB_TAHUN,
	// 	S.PROGRESS_FSTB,S.DATE_COUNT_PROYEK_CHIEF,S.DATE_COUNT_PROYEK_SM,
	// 	S.DATE_COUNT_PROYEK_PM,S.DATE_COUNT_M_LOG,S.DATE_COUNT_MANAGER,
	// 	S.DATE_COUNT_DIR,S.CB_PERSETUJUAN_M_LOG,S.CB_PERSETUJUAN_M_PROC,S.CB_PERSETUJUAN_M_SDM,
	// 	S.CB_PERSETUJUAN_M_KONS,S.CB_PERSETUJUAN_M_EP,S.CB_PERSETUJUAN_M_QAQC,S.CB_PERSETUJUAN_M_KEU,
	// 	S.CB_PERSETUJUAN_D_PSDS,S.CB_PERSETUJUAN_D_KONS,S.CB_PERSETUJUAN_D_KEU
	// 	FROM FSTB AS S 
	// 	LEFT JOIN rasd AS R ON R.ID_RASD = S.ID_RASD 
	// 	LEFT JOIN proyek AS P ON P.ID_PROYEK = S.ID_PROYEK
	// 	WHERE S.ID_FSTB = '$ID_FSTB'");
	// 	if ($hsl->num_rows() > 0) {
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil = array(
	// 				'ID_FSTB' => $data->ID_FSTB,
	// 				'NAMA_PROYEK' => $data->NAMA_PROYEK,
	// 				'ID_RASD' => $data->ID_RASD,
	// 				'JENIS_PEKERJAAN' => $data->JENIS_PEKERJAAN,
	// 				'NO_URUT_FSTB' => $data->NO_URUT_FSTB,
	// 				'TANGGAL_PENGAJUAN_FSTB_JAM' => $data->TANGGAL_PENGAJUAN_FSTB_JAM,
	// 				'TANGGAL_PENGAJUAN_FSTB_HARI' => $data->TANGGAL_PENGAJUAN_FSTB_HARI,
	// 				'TANGGAL_PENGAJUAN_FSTB_BULAN' => $data->TANGGAL_PENGAJUAN_FSTB_BULAN,
	// 				'TANGGAL_PENGAJUAN_FSTB_TAHUN' => $data->TANGGAL_PENGAJUAN_FSTB_TAHUN,
	// 				'PROGRESS_FSTB' => $data->PROGRESS_FSTB,
	// 				'DATE_COUNT_PROYEK_CHIEF' => $data->DATE_COUNT_PROYEK_CHIEF,
	// 				'DATE_COUNT_PROYEK_SM' => $data->DATE_COUNT_PROYEK_SM,
	// 				'DATE_COUNT_PROYEK_PM' => $data->DATE_COUNT_PROYEK_PM,
	// 				'DATE_COUNT_M_LOG' => $data->DATE_COUNT_M_LOG,
	// 				'DATE_COUNT_MANAGER' => $data->DATE_COUNT_MANAGER,
	// 				'DATE_COUNT_DIR' => $data->DATE_COUNT_DIR,
	// 				'CB_PERSETUJUAN_M_LOG' => $data->CB_PERSETUJUAN_M_LOG,
	// 				'CB_PERSETUJUAN_M_PROC' => $data->CB_PERSETUJUAN_M_PROC,
	// 				'CB_PERSETUJUAN_M_SDM' => $data->CB_PERSETUJUAN_M_SDM,
	// 				'CB_PERSETUJUAN_M_KONS' => $data->CB_PERSETUJUAN_M_KONS,
	// 				'CB_PERSETUJUAN_M_EP' => $data->CB_PERSETUJUAN_M_EP,
	// 				'CB_PERSETUJUAN_M_QAQC' => $data->CB_PERSETUJUAN_M_QAQC,
	// 				'CB_PERSETUJUAN_M_KEU' => $data->CB_PERSETUJUAN_M_KEU,
	// 				'CB_PERSETUJUAN_D_PSDS' => $data->CB_PERSETUJUAN_D_PSDS,
	// 				'CB_PERSETUJUAN_D_KONS' => $data->CB_PERSETUJUAN_D_KONS,
	// 				'CB_PERSETUJUAN_D_KEU' => $data->CB_PERSETUJUAN_D_KEU
	// 			);
	// 		}
	// 	} else {
	// 		$hasil = "BELUM ADA FSTB";
	// 	}
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan HASH_MD5_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function get_data_by_HASH_MD5_FSTB($HASH_MD5_FSTB)
	{
		$hsl = $this->db->query("SELECT * FROM fstb WHERE HASH_MD5_FSTB = '$HASH_MD5_FSTB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FSTB' => $data->ID_FSTB,
					'ID_RASD' => $data->ID_RASD,
					'NO_URUT_FSTB' => $data->NO_URUT_FSTB,
					'ID_SPPB' => $data->ID_SPPB,
					'TANGGAL_PENGAJUAN_FSTB' => $data->TANGGAL_PENGAJUAN_FSTB,
					'PROGRESS_FSTB' => $data->PROGRESS_FSTB
				);
			}
		} else {
			$hasil = "BELUM ADA FSTB";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan HASH_MD5_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function get_data_fstb_baru
	//         2. 
	function get_data_surat_jalan_baru($ID_PROYEK_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN, $NO_SURAT_JALAN, $USER_ID)
	{
		$hsl = $this->db->query("SELECT * FROM surat_jalan WHERE ID_PROYEK_SURAT_JALAN = '$ID_PROYEK_SURAT_JALAN' AND
		TANGGAL_PENGAJUAN_SURAT_JALAN = '$TANGGAL_PENGAJUAN_SURAT_JALAN' AND
		NO_SURAT_JALAN = '$NO_SURAT_JALAN' AND
		CREATE_BY_USER = '$USER_ID' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'HASH_MD5_SURAT_JALAN' => $data->HASH_MD5_SURAT_JALAN
				);
			}
		} else {
			$hasil = "BELUM ADA SURAT JALAN";
		}
		return $hasil;
	}

	function get_data_proyek()
	{
		$hsl = $this->db->query("SELECT * FROM proyek");
		return $hsl->result();
	}

	function get_data_proyek_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT * FROM proyek where ID_PROYEK = '$ID_PROYEK'");
		return $hsl->result();
	}

	function get_data_vendor()
	{
		$hsl = $this->db->query("SELECT * FROM vendor");
		return $hsl->result();
	}

	function get_data_sppb($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT * FROM sppb where ID_PROYEK = '$ID_PROYEK'");
		return $hsl->result();
	}

	function get_data_lokasi_penyerahan($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT * FROM proyek_lokasi_penyerahan where ID_PROYEK = '$ID_PROYEK'");
		return $hsl->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data BARANG MASTER berdasarkan ID_PO
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller po_form / function index
	//         2. 
	function barang_master_where_not_in_surat_jalan_and_rasd($ID_SURAT_JALAN)
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
				AND RASD_FORM.ID_RASD = (SELECT ID_RASD FROM surat_jalan WHERE ID_SURAT_JALAN = '$ID_SURAT_JALAN'))
           	AND
            NOT EXISTS
            	(SELECT ID_BARANG_MASTER
                 FROM surat_jalan_form
                 WHERE surat_jalan_form.ID_BARANG_MASTER = M.ID_BARANG_MASTER
                 AND surat_jalan_form.ID_SURAT_JALAN = '$ID_SURAT_JALAN')
            	");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan NO_URUT_FSTB
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function simpan_data
	//         2. 
	function cek_no_urut_Surat_Jalan($NO_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT ID_SURAT_JALAN, NO_SURAT_JALAN FROM surat_jalan WHERE NO_SURAT_JALAN ='$NO_SURAT_JALAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'NO_SURAT_JALAN' => $data->NO_SURAT_JALAN,
					'ID_SURAT_JALAN' => $data->ID_SURAT_JALAN
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function update_data(
		$NO_URUT_SPPB,
		$TANGGAL_SURAT_JALAN_HARI,
		$KEPADA,
		$PIC_PENERIMA_BARANG,
		$NO_HP_PIC,
		$HASH_MD5_SURAT_JALAN
	) {
		$hasil = $this->db->query("UPDATE surat_jalan SET 
			ID_SPPB='$NO_URUT_SPPB',
			TANGGAL_SURAT_JALAN_HARI='$TANGGAL_SURAT_JALAN_HARI',
			KEPADA='$KEPADA',
			PIC_PENERIMA_BARANG='$PIC_PENERIMA_BARANG',
			NO_HP_PIC='$NO_HP_PIC'
			WHERE HASH_MD5_SURAT_JALAN='$HASH_MD5_SURAT_JALAN'");
		return $hasil;
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
	function simpan_data(
		$ID_PROYEK,
		$ID_PROYEK_SURAT_JALAN,
		$ID_PROYEK_LOKASI_PENYERAHAN,
		$TANGGAL_PENGAJUAN_SURAT_JALAN,
		$NO_SURAT_JALAN,
		$NO_DELIVERY_NOTE,
		$NO_PACKING_LIST,
		$CREATE_BY_USER,
		$STATUS_SURAT_JALAN,
		$PROGRESS_SURAT_JALAN,
		$JUMLAH_COUNT,
		$FILE_NAME_TEMP,
		$FILE_NAME_TEMP_DELIVERY_NOTE,
		$FILE_NAME_TEMP_PACKING_LIST,
		$ID_SPPB,
		$ID_VENDOR,
		$KEPADA,
		$PIC_PENERIMA_BARANG,
		$NO_HP_PIC,
		$TANGGAL_SURAT_JALAN_HARI
	) {
		$hasil = $this->db->query("INSERT INTO surat_jalan (
			ID_PROYEK,
			ID_PROYEK_SURAT_JALAN,
			ID_PROYEK_LOKASI_PENYERAHAN,
			TANGGAL_PENGAJUAN_SURAT_JALAN,
			NO_SURAT_JALAN,
			NO_DELIVERY_NOTE,
			NO_PACKING_LIST,
			CREATE_BY_USER,
			STATUS_SURAT_JALAN,
			PROGRESS_SURAT_JALAN,
			COUNT_SURAT_JALAN,
			FILE_NAME_TEMP,
			FILE_NAME_TEMP_DELIVERY_NOTE,
			FILE_NAME_TEMP_PACKING_LIST,
			ID_SPPB,
			ID_VENDOR,
			KEPADA,
			PIC_PENERIMA_BARANG,
			NO_HP_PIC,
			TANGGAL_SURAT_JALAN_HARI)
		VALUES(
			'$ID_PROYEK',
			'$ID_PROYEK_SURAT_JALAN',
			'$ID_PROYEK_LOKASI_PENYERAHAN',
			'$TANGGAL_PENGAJUAN_SURAT_JALAN',
			'$NO_SURAT_JALAN',
			'$NO_DELIVERY_NOTE',
			'$NO_PACKING_LIST',
			'$CREATE_BY_USER',
			'$STATUS_SURAT_JALAN',
			'$PROGRESS_SURAT_JALAN',
			'$JUMLAH_COUNT',
			'$FILE_NAME_TEMP',
			'$FILE_NAME_TEMP_DELIVERY_NOTE',
			'$FILE_NAME_TEMP_PACKING_LIST',
			'$ID_SPPB',
			'$ID_VENDOR',
			'$KEPADA',
			'$PIC_PENERIMA_BARANG',
			'$NO_HP_PIC',
			'$TANGGAL_SURAT_JALAN_HARI'
			)");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fstb berdasarkan ID_USER
	//SUMBER TABEL: tabel fstb
	//DIPAKAI: 1. controller FSTB / function logout
	//         2. controller FSTB / function user_log
	function user_log_surat_jalan($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_surat_jalan (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
