<?php
class Surat_Jalan_form_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_FSTB
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function data_fstb_form
	//         2. controller FSTB_form / function cetak_pdf
	function surat_jalan_form_list_by_id_surat_jalan($ID_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT 	surat_jalan_form.ID_SURAT_JALAN_FORM,
		surat_jalan_form.ID_SURAT_JALAN,
        surat_jalan_form.NAMA_BARANG,
        surat_jalan_form.ID_JENIS_BARANG,
        surat_jalan_form.ID_SATUAN_BARANG,
        surat_jalan_form.SPESIFIKASI_SINGKAT,
        surat_jalan_form.JUMLAH,
        surat_jalan_form.KETERANGAN,
        surat_jalan_form.NETT_WEIGHT,
        surat_jalan_form.GROSS_WEIGHT,
        surat_jalan_form.PACKING_STYLE,
        surat_jalan_form.DIMENSI_PANJANG,
        surat_jalan_form.DIMENSI_LEBAR,
        surat_jalan_form.DIMENSI_TINGGI,
        SB.NAMA_SATUAN_BARANG,
        JB.NAMA_JENIS_BARANG
        FROM surat_jalan_form
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = surat_jalan_form.ID_SATUAN_BARANG
        LEFT JOIN jenis_barang AS JB ON JB.ID_JENIS_BARANG = surat_jalan_form.ID_JENIS_BARANG 
        WHERE ID_SURAT_JALAN = '$ID_SURAT_JALAN'");
		return $hsl->result();
	}

	function get_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM)
	{
		$hsl = $this->db->query("SELECT
		surat_jalan_form.ID_SURAT_JALAN_FORM,
		surat_jalan_form.ID_SURAT_JALAN,
        surat_jalan_form.NAMA_BARANG,
        surat_jalan_form.MEREK,
        surat_jalan_form.ID_JENIS_BARANG,
        surat_jalan_form.PERALATAN_PERLENGKAPAN,
        surat_jalan_form.ID_SATUAN_BARANG,
        surat_jalan_form.SPESIFIKASI_SINGKAT,
        surat_jalan_form.JUMLAH,
        surat_jalan_form.KETERANGAN,
        surat_jalan_form.NETT_WEIGHT,
        surat_jalan_form.GROSS_WEIGHT,
        surat_jalan_form.PACKING_STYLE,
        surat_jalan_form.DIMENSI_PANJANG,
        surat_jalan_form.DIMENSI_LEBAR,
        surat_jalan_form.DIMENSI_TINGGI,
        SB.NAMA_SATUAN_BARANG,
        JB.NAMA_JENIS_BARANG
        FROM surat_jalan_form
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = surat_jalan_form.ID_SATUAN_BARANG
        LEFT JOIN jenis_barang AS JB ON JB.ID_JENIS_BARANG = surat_jalan_form.ID_JENIS_BARANG 
        WHERE ID_SURAT_JALAN_FORM = '$ID_SURAT_JALAN_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SURAT_JALAN_FORM' => $data->ID_SURAT_JALAN_FORM,
					'NAMA_BARANG' => $data->NAMA_BARANG,
					'MEREK' => $data->MEREK,
					'SPESIFIKASI_SINGKAT' => $data->SPESIFIKASI_SINGKAT,
					'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'NAMA_JENIS_BARANG' => $data->NAMA_JENIS_BARANG,
					'ID_SATUAN_BARANG' => $data->ID_SATUAN_BARANG,
					'NAMA_SATUAN_BARANG' => $data->NAMA_SATUAN_BARANG,
					'JUMLAH' => $data->JUMLAH,
					'KETERANGAN' => $data->KETERANGAN,
					'NETT_WEIGHT' => $data->NETT_WEIGHT,
					'GROSS_WEIGHT' => $data->GROSS_WEIGHT,
					'PACKING_STYLE' => $data->PACKING_STYLE,
					'DIMENSI_PANJANG' => $data->DIMENSI_PANJANG,
					'DIMENSI_LEBAR' => $data->DIMENSI_LEBAR,
					'DIMENSI_TINGGI' => $data->DIMENSI_TINGGI
				);
			}
		} else {
			$hasil = "BELUM ADA SURAT JALAN FORM";
		}
		return $hasil;
	}

	function simpan_data_dari_barang_master(
		$ID_SURAT_JALAN,
		$ID_BARANG_MASTER,
		$ID_RASD_FORM,
		$ID_SATUAN_BARANG,
		$ID_JENIS_BARANG,
		$NAMA,
		$MEREK,
		$PERALATAN_PERLENGKAPAN,
		$SPESIFIKASI_SINGKAT,
		$GROSS_WEIGHT,
		$NETT_WEIGHT,
		$DIMENSI_PANJANG,
		$DIMENSI_LEBAR,
		$DIMENSI_TINGGI,
		$JUMLAH_BARANG
	) {
		$hasil = $this->db->query("INSERT INTO surat_jalan_form (
				ID_SURAT_JALAN,
				ID_BARANG_MASTER,
				ID_RASD_FORM,
				ID_SATUAN_BARANG,
				ID_JENIS_BARANG,
				NAMA_BARANG,
				MEREK,
				PERALATAN_PERLENGKAPAN,
				SPESIFIKASI_SINGKAT,
				GROSS_WEIGHT,
				NETT_WEIGHT,
				DIMENSI_PANJANG,
				DIMENSI_LEBAR,
				DIMENSI_TINGGI,
				JUMLAH)
			VALUES(
				'$ID_SURAT_JALAN',
				'$ID_BARANG_MASTER',
				'$ID_RASD_FORM',
				'$ID_SATUAN_BARANG',
				'$ID_JENIS_BARANG',
				'$NAMA',
				'$MEREK',
				'$PERALATAN_PERLENGKAPAN',
				'$SPESIFIKASI_SINGKAT',
				'$GROSS_WEIGHT',
				'$NETT_WEIGHT',
				'$DIMENSI_PANJANG',
				'$DIMENSI_LEBAR',
				'$DIMENSI_TINGGI',
				'$JUMLAH_BARANG')");
		return $hasil;
	}

	function update_data(
		$ID_SURAT_JALAN_FORM,
		$NAMA_BARANG,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$ID_JENIS_BARANG,
		$PERALATAN_PERLENGKAPAN,
		$ID_SATUAN_BARANG,
		$JUMLAH,
		$KETERANGAN_SURAT_JALAN,
		$NETT_WEIGHT,
		$GROSS_WEIGHT,
		$PACKING_STYLE,
		$DIMENSI_PANJANG,
		$DIMENSI_LEBAR,
		$DIMENSI_TINGGI
	) {
		$hasil = $this->db->query("UPDATE surat_jalan_form SET 
			NAMA_BARANG='$NAMA_BARANG',
			MEREK='$MEREK',
			SPESIFIKASI_SINGKAT='$SPESIFIKASI_SINGKAT',
			ID_JENIS_BARANG='$ID_JENIS_BARANG',
			PERALATAN_PERLENGKAPAN='$PERALATAN_PERLENGKAPAN',
			ID_SATUAN_BARANG='$ID_SATUAN_BARANG',
			JUMLAH='$JUMLAH',
			KETERANGAN='$KETERANGAN_SURAT_JALAN',
			NETT_WEIGHT='$NETT_WEIGHT',
			GROSS_WEIGHT='$GROSS_WEIGHT',
			PACKING_STYLE='$PACKING_STYLE',
			DIMENSI_PANJANG='$DIMENSI_PANJANG',
			DIMENSI_LEBAR='$DIMENSI_LEBAR',
			DIMENSI_TINGGI='$DIMENSI_TINGGI'
			
			WHERE ID_SURAT_JALAN_FORM='$ID_SURAT_JALAN_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_FSTB
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function cetak_pdf
	//         2. 
	function ID_JABATAN_PEGAWAI_BY_ID_SURAT_JALAN($ID_SURAT_JALAN)
	{
		$hasil = $this->db->query("SELECT P.ID_JABATAN_PEGAWAI
		FROM pegawai AS P
		LEFT JOIN users AS U ON U.ID_PEGAWAI = P.ID_PEGAWAI
		LEFT JOIN surat_jalan AS SJ ON SJ.CREATE_BY_USER = U.id 
		where SJ.ID_SURAT_JALAN = '$ID_SURAT_JALAN'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menghapus data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function hapus_data
	//         2. 
	function hapus_data_by_id_surat_jalan_form($ID_SURAT_JALAN_FORM)
	{
		$hasil = $this->db->query("DELETE FROM Surat_Jalan_form WHERE ID_SURAT_JALAN_FORM='$ID_SURAT_JALAN_FORM'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function get_data
	//         2. controller FSTB_form / function hapus_data
	//         3. controller FSTB_form / function update_data
	function get_data_by_id_Surat_Jalan($ID_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT 	
		surat_jalan_form.ID_SURAT_JALAN_FORM,
		surat_jalan_form.ID_SURAT_JALAN,
        surat_jalan_form.NAMA_BARANG,
        surat_jalan_form.MEREK,
        surat_jalan_form.PERALATAN_PERLENGKAPAN,
        surat_jalan_form.ID_JENIS_BARANG,
        surat_jalan_form.ID_SATUAN_BARANG,
        surat_jalan_form.SPESIFIKASI_SINGKAT,
        surat_jalan_form.JUMLAH,
        surat_jalan_form.KETERANGAN,
        surat_jalan_form.NETT_WEIGHT,
        surat_jalan_form.GROSS_WEIGHT,
        surat_jalan_form.PACKING_STYLE,
        surat_jalan_form.DIMENSI_PANJANG,
        surat_jalan_form.DIMENSI_LEBAR,
        surat_jalan_form.DIMENSI_TINGGI,
		SJ.JENIS_PENGIRIMAN,
		SJ.JENIS_KENDARAAN,
		SJ.NO_POLISI,
		SJ.NAMA_PENGEMUDI,
		SJ.NO_HP_PENGEMUDI,
        SB.NAMA_SATUAN_BARANG,
        JB.NAMA_JENIS_BARANG
        FROM surat_jalan_form
		LEFT JOIN surat_jalan AS SJ ON SJ.ID_SURAT_JALAN = surat_jalan_form.ID_SURAT_JALAN
        LEFT JOIN satuan_barang AS SB ON SB.ID_SATUAN_BARANG = surat_jalan_form.ID_SATUAN_BARANG
        LEFT JOIN jenis_barang AS JB ON JB.ID_JENIS_BARANG = surat_jalan_form.ID_JENIS_BARANG 
        WHERE surat_jalan_form.ID_SURAT_JALAN = '$ID_SURAT_JALAN'");
		return $hsl->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data catatan surat jalan berdasarkan ID_SURAT_JALAN
	//SUMBER TABEL: tabel surat_jalan
	//DIPAKAI: 1. controller Surat_Jalan_form / function index
	//         2. controller Surat_Jalan_form / function get_data_catatan_surat_jalan
	//         3. controller Surat_Jalan_form / function update_data_catatan_surat_jalan
	//         4. controller Surat_Jalan_form / function cetak_pdf
	function get_data_catatan_surat_jalan_by_ID_SURAT_JALAN($ID_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT 
		ID_SURAT_JALAN, 
		CTT_STAFF_UMUM_LOG_SP,
		CTT_SPV_LOG_SP,
		CTT_STAFF_LOG_KP,
		CTT_KASIE_LOG_KP,
		CTT_MAN_LOG_KP

		FROM surat_jalan

		WHERE ID_SURAT_JALAN = '$ID_SURAT_JALAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SURAT_JALAN' => $data->ID_SURAT_JALAN,
					'CTT_STAFF_UMUM_LOG_SP' => $data->CTT_STAFF_UMUM_LOG_SP,
					'CTT_SPV_LOG_SP' => $data->CTT_SPV_LOG_SP,
					'CTT_STAFF_LOG_KP' => $data->CTT_STAFF_LOG_KP,
					'CTT_KASIE_LOG_KP' => $data->CTT_KASIE_LOG_KP,
					'CTT_MAN_LOG_KP' => $data->CTT_MAN_LOG_KP
				);
			}
		} else {
			$hasil = "TIDAK ADA CATATAN";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data surat jalan berdasarkan ID_SURAT_JALAN
	//SUMBER TABEL: tabel surat_jalan
	//DIPAKAI: 1. controller Surat_Jalan_form / function data_surat_jalan_form_pengiriman
	//         2. 
	function get_data_surat_jalan_form_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT 	surat_jalan.ID_SURAT_JALAN,
		surat_jalan.JENIS_PENGIRIMAN,
        surat_jalan.JENIS_KENDARAAN,
        surat_jalan.NO_POLISI,
        surat_jalan.NAMA_PENGEMUDI,
        surat_jalan.NO_HP_PENGEMUDI
        FROM surat_jalan WHERE ID_SURAT_JALAN= '$ID_SURAT_JALAN'");
		return $hsl->result();
	}

	function get_data_pengiriman_by_ID_SURAT_JALAN($ID_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT surat_jalan.ID_SURAT_JALAN,
		surat_jalan.JENIS_PENGIRIMAN,
        surat_jalan.JENIS_KENDARAAN,
        surat_jalan.NO_POLISI,
        surat_jalan.NAMA_PENGEMUDI,
        surat_jalan.NO_HP_PENGEMUDI
        FROM surat_jalan WHERE ID_SURAT_JALAN= '$ID_SURAT_JALAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SURAT_JALAN' => $data->ID_SURAT_JALAN,
					'JENIS_PENGIRIMAN' => $data->JENIS_PENGIRIMAN,
					'JENIS_KENDARAAN' => $data->JENIS_KENDARAAN,
					'NO_POLISI' => $data->NO_POLISI,
					'NAMA_PENGEMUDI' => $data->NAMA_PENGEMUDI,
					'NO_HP_PENGEMUDI' => $data->NO_HP_PENGEMUDI
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA PENGIRIMAN";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data fstb berdasarkan NAMA
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function simpan_data
	//         2. 
	function simpan_data(
		$ID_SURAT_JALAN,
		$NAMA_BARANG,
		$MEREK,
		$SPESIFIKASI_SINGKAT,
		$ID_JENIS_BARANG,
		$PERALATAN_PERLENGKAPAN,
		$ID_SATUAN_BARANG,
		$JUMLAH,
		$KETERANGAN,
		$NETT_WEIGHT,
		$GROSS_WEIGHT,
		$PACKING_STYLE,
		$DIMENSI_PANJANG,
		$DIMENSI_LEBAR,
		$DIMENSI_TINGGI
	) {
		$hasil = $this->db->query("INSERT INTO surat_jalan_form (
				ID_SURAT_JALAN,
				NAMA_BARANG,
				MEREK,
				SPESIFIKASI_SINGKAT,
				ID_JENIS_BARANG,
				PERALATAN_PERLENGKAPAN,
				ID_SATUAN_BARANG,
				JUMLAH,
				KETERANGAN,
				NETT_WEIGHT,
				GROSS_WEIGHT,
				PACKING_STYLE,
				DIMENSI_PANJANG,
				DIMENSI_LEBAR,
				DIMENSI_TINGGI)
			VALUES(
				'$ID_SURAT_JALAN',
				'$NAMA_BARANG',
				'$MEREK',
				'$SPESIFIKASI_SINGKAT',
				'$ID_JENIS_BARANG',
				'$PERALATAN_PERLENGKAPAN',
				'$ID_SATUAN_BARANG',
				'$JUMLAH',
				'$KETERANGAN',
				'$NETT_WEIGHT',
				'$GROSS_WEIGHT',
				'$PACKING_STYLE',
				'$DIMENSI_PANJANG',
				'$DIMENSI_LEBAR',
				'$DIMENSI_TINGGI')");
		return $hasil;
	}

	function cek_nama_barang_surat_jalan_form($NAMA, $ID_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT ID_SURAT_JALAN, NAMA_BARANG AS NAMA FROM surat_jalan_form WHERE NAMA_BARANG ='$NAMA' AND ID_SURAT_JALAN ='$ID_SURAT_JALAN' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SURAT_JALAN' => $data->ID_SURAT_JALAN,
					'NAMA' => $data->NAMA
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function cek_pengiriman($ID_SURAT_JALAN)
	{
		$hsl = $this->db->query("SELECT ID_SURAT_JALAN FROM surat_jalan WHERE AND ID_SURAT_JALAN ='$ID_SURAT_JALAN' ");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SURAT_JALAN' => $data->ID_SURAT_JALAN
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
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

	function update_data_pengiriman(
		$ID_SURAT_JALAN,
		$JENIS_PENGIRIMAN,
		$JENIS_KENDARAAN,
		$NO_POLISI,
		$NAMA_PENGEMUDI,
		$NO_HP_PENGEMUDI
	) {
		$hasil = $this->db->query("UPDATE surat_jalan SET 
			JENIS_PENGIRIMAN='$JENIS_PENGIRIMAN',
			JENIS_KENDARAAN='$JENIS_KENDARAAN',
			NO_POLISI='$NO_POLISI',
			NAMA_PENGEMUDI='$NAMA_PENGEMUDI',
			NO_HP_PENGEMUDI='$NO_HP_PENGEMUDI'
			
			WHERE ID_SURAT_JALAN='$ID_SURAT_JALAN'");
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
	function update_data_CTT_STAFF_UMUM_LOG_SP($ID_SURAT_JALAN, $CTT_STAFF_UMUM_LOG_SP)
	{
		$hasil = $this->db->query("UPDATE surat_jalan SET 
			CTT_STAFF_UMUM_LOG_SP='$CTT_STAFF_UMUM_LOG_SP' 
			WHERE ID_SURAT_JALAN='$ID_SURAT_JALAN'");
		return $hasil;
	}

	function update_data_CTT_SPV_LOG_SP($ID_SURAT_JALAN, $CTT_SPV_LOG_SP)
	{
		$hasil = $this->db->query("UPDATE surat_jalan SET 
			CTT_SPV_LOG_SP='$CTT_SPV_LOG_SP' 
			WHERE ID_SURAT_JALAN='$ID_SURAT_JALAN'");
		return $hasil;
	}

	function update_data_CTT_STAFF_LOG_KP($ID_SURAT_JALAN, $CTT_STAFF_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE surat_jalan SET 
			CTT_STAFF_LOG_KP='$CTT_STAFF_LOG_KP' 
			WHERE ID_SURAT_JALAN='$ID_SURAT_JALAN'");
		return $hasil;
	}

	function update_data_CTT_KASIE_LOG_KP($ID_SURAT_JALAN, $CTT_KASIE_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE surat_jalan SET 
			CTT_KASIE_LOG_KP='$CTT_KASIE_LOG_KP' 
			WHERE ID_SURAT_JALAN='$ID_SURAT_JALAN'");
		return $hasil;
	}

	function update_data_CTT_MAN_LOG_KP($ID_SURAT_JALAN, $CTT_MAN_LOG_KP)
	{
		$hasil = $this->db->query("UPDATE surat_jalan SET 
			CTT_MAN_LOG_KP='$CTT_MAN_LOG_KP' 
			WHERE ID_SURAT_JALAN='$ID_SURAT_JALAN'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data surat_jalan berdasarkan ID_SURAT_JALAN
	//SUMBER TABEL: tabel Surat_jalan_form
	//DIPAKAI: 1. controller Surat_Jalan_form / function update_data_kirim_surat_jalan
	//         2. 
	function update_data_kirim_surat_jalan($ID_SURAT_JALAN, $PROGRESS_SURAT_JALAN, $STATUS_SURAT_JALAN, $TANGGAL_PENGAJUAN_SURAT_JALAN)
	{
		$hasil = $this->db->query("UPDATE surat_jalan SET 
			PROGRESS_SURAT_JALAN='$PROGRESS_SURAT_JALAN',
			STATUS_SURAT_JALAN='$STATUS_SURAT_JALAN',
			TANGGAL_PENGAJUAN_SURAT_JALAN='$TANGGAL_PENGAJUAN_SURAT_JALAN' 
			WHERE ID_SURAT_JALAN='$ID_SURAT_JALAN'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function update_data_tanggal
	//         2. 
	function update_data_tanggal($id, $field, $value)
	{
		$hasil = $this->db->query("UPDATE surat_jalan SET $field='$value' WHERE ID_SURAT_JALAN_FORM ='$id'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data fstb berdasarkan ID_FSTB_FORM
	//SUMBER TABEL: tabel FSTB_form
	//DIPAKAI: 1. controller FSTB_form / function logout
	//         2. controller FSTB_form / function user_log
	function user_log_surat_jalan_form($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_surat_jalan_form(ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
