<?php
class Khp_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan seluruh data komparasi harga pemasok
	//SUMBER TABEL: tabel komparasi_harga_pemasok
	//DIPAKAI: 1. controller Khp / function data_khp
	//         2. 
	function khp_list()
	{
		$hasil = $this->db->query("SELECT K.ID_KHP, S.ID_SPPB, K.NO_URUT_KHP, 
		K.PROGRESS_KHP, K.KETERANGAN_KHP, K.CTT_STAFF_PROC, K.CTT_KASIE, 
		K.CTT_MANAGER_PROC, K.TANGGAL_PEMBUATAN_KHP_HARI, S.ID_SPPB, S.NO_URUT_SPPB,
		P.NAMA_PROYEK, V.NAMA_VENDOR
		FROM komparasi_harga_pemasok as K
		LEFT JOIN sppb as S ON S.ID_SPPB=K.ID_SPPB
        LEFT JOIN proyek as P ON P.ID_PROYEK=(SELECT ID_PROYEK FROM sppb WHERE ID_SPPB=K.ID_SPPB)
		LEFT JOIN vendor as V ON V.ID_VENDOR=(SELECT ID_VENDOR FROM harga_barang_pemasok WHERE ID_HBP=K.ID_HBP)
		");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data komparasi harga pemasok berdasarkan ID_KHP
	//SUMBER TABEL: tabel komparasi_harga_pemasok
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function khp_list_by_id_khp($ID_KHP)
	{
		$hasil = $this->db->query("SELECT K.ID_KHP, S.ID_SPPB, K.NO_URUT_KHP, 
		K.PROGRESS_KHP, K.KETERANGAN_KHP, K.CTT_STAFF_PROC, K.CTT_KASIE, 
		K.CTT_MANAGER_PROC, K.TANGGAL_PEMBUATAN_KHP_HARI, S.ID_SPPB, S.NO_URUT_SPPB,
		P.NAMA_PROYEK, V.NAMA_VENDOR
		FROM komparasi_harga_pemasok as K
		LEFT JOIN sppb as S ON S.ID_SPPB=K.ID_SPPB
        LEFT JOIN proyek as P ON P.ID_PROYEK=(SELECT ID_PROYEK FROM sppb WHERE ID_SPPB=K.ID_SPPB)
		LEFT JOIN vendor as V ON V.ID_VENDOR=(SELECT ID_VENDOR FROM harga_barang_pemasok WHERE ID_HBP=K.ID_HBP)
		WHERE K.ID_KHP ='$ID_KHP'");
		return $hasil;
		//return $hasil->result();
	}

	// function Proyek_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM Proyek WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM Proyek WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menghapus data komparasi harga pemasok berdasarkan ID_KHP
	//SUMBER TABEL: tabel komparasi_harga_pemasok
	//DIPAKAI: 1. controller Khp / function hapus_data
	//         2. 
	function hapus_data_by_id_khp($ID_KHP)
	{
		$hasil = $this->db->query("DELETE FROM komparasi_harga_pemasok WHERE ID_KHP='$ID_KHP'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data komparasi harga pemasok berdasarkan ID_KHP
	//SUMBER TABEL: tabel komparasi_harga_pemasok
	//DIPAKAI: 1. controller Khp / function get_data
	//         2. controller Khp / function hapus_data
	//         3. controller Khp / function update_data
	function get_data_by_id_khp($ID_KHP)
	{
		$hsl = $this->db->query("SELECT K.ID_KHP, S.ID_SPPB, K.NO_URUT_KHP, 
		K.PROGRESS_KHP, K.KETERANGAN_KHP, K.CTT_STAFF_PROC, K.CTT_KASIE, 
		K.CTT_MANAGER_PROC, K.TANGGAL_PEMBUATAN_KHP_HARI, S.ID_SPPB, S.NO_URUT_SPPB,
		P.NAMA_PROYEK, V.NAMA_VENDOR
		FROM komparasi_harga_pemasok as K
		LEFT JOIN sppb as S ON S.ID_SPPB=K.ID_SPPB
        LEFT JOIN proyek as P ON P.ID_PROYEK=(SELECT ID_PROYEK FROM sppb WHERE ID_SPPB=K.ID_SPPB)
		LEFT JOIN vendor as V ON V.ID_VENDOR=(SELECT ID_VENDOR FROM harga_barang_pemasok WHERE ID_HBP=K.ID_HBP)
		WHERE K.ID_KHP ='$ID_KHP'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KHP' => $data->ID_KHP,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'INISIAL' => $data->INISIAL,
					'LOKASI' => $data->LOKASI,
					'PEGAWAI_PM' => $data->PEGAWAI_PM,
					'PEGAWAI_SM' => $data->PEGAWAI_SM,
					'PEGAWAI_LOG' => $data->PEGAWAI_LOG,
					'PEGAWAI_PROC' => $data->PEGAWAI_PROC
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data komparasi harga pemasok berdasarkan NAMA_PROYEK
	//SUMBER TABEL: tabel komparasi_harga_pemasok
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function get_data_by_nama_khp($NAMA_PROYEK)
	{
		$hsl = $this->db->query("SELECT ID_KHP  FROM komparasi_harga_pemasok 
		
		WHERE NAMA_PROYEK ='$NAMA_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = $data->ID_KHP;
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data komparasi harga pemasok berdasarkan NAMA_PROYEK
	//SUMBER TABEL: tabel komparasi_harga_pemasok
	//DIPAKAI: 1. controller Khp / function update_data
	//         2. 
	function cek_nama_khp_by_admin($NAMA_PROYEK)
	{
		$hsl = $this->db->query("SELECT * FROM komparasi_harga_pemasok WHERE NAMA_PROYEK ='$NAMA_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KHP' => $data->ID_KHP,
					'NAMA_PROYEK' => $data->NAMA_PROYEK
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk menampilkan data komparasi harga pemasok berdasarkan ID_KHP2
	//SUMBER TABEL: tabel komparasi_harga_pemasok
	//DIPAKAI: 1. controller Khp / function update_data
	//         2. 
	function update_data($ID_KHP2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $NAMA_PROJECT_MANAGER2, $NAMA_SITE_MANAGER2, $NAMA_SPV_LOG2, $NAMA_SPV_PROC2)
	{
		$hasil = $this->db->query("UPDATE komparasi_harga_pemasok SET NAMA_PROYEK='$NAMA_PROYEK2', 
		LOKASI='$LOKASI2', 
		INISIAL='$INISIAL2', 
		ID_PEGAWAI_PM ='$NAMA_PROJECT_MANAGER2', ID_PEGAWAI_SM='$NAMA_SITE_MANAGER2', ID_PEGAWAI_LOG='$NAMA_SPV_LOG2', 
		ID_PEGAWAI_PROC='$NAMA_SPV_PROC2' WHERE ID_KHP='$ID_KHP2'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data komparasi harga pemasok berdasarkan ID_SPPB
	//SUMBER TABEL: tabel komparasi_harga_pemasok
	//DIPAKAI: 1. controller Khp / function simpan_data
	//         2. 
	function simpan_data_by_admin($ID_SPPB)
	{
		$this->db->query("INSERT INTO komparasi_harga_pemasok ( ID_SPPB )VALUES('$ID_SPPB')");
		$hasilInsert = $this->db->query("SELECT ID_KHP FROM komparasi_harga_pemasok WHERE ID_SPPB = '$ID_SPPB'");
		if ($hasilInsert->num_rows() > 0) {
			return $hasilInsert->row()->ID_KHP;
		}
	}

	//FUNGSI: Fungsi ini untuk menambahkan data komparasi harga pemasok berdasarkan ID_KHP
	//SUMBER TABEL: tabel khp_barang
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function simpan_data_khp_barang_by_admin($ID_KHP, $ID_SPPB_BARANG, $JUMLAH_SETUJU_D_KEU)
	{
		$this->db->query("INSERT INTO khp_barang ( ID_KHP, ID_SPPB_BARANG, JUMLAH_ITEM_BARANG ) VALUES ('$ID_KHP', '$ID_SPPB_BARANG', '$JUMLAH_SETUJU_D_KEU')");
		return;
	}
	/* function log_Proyek($ID_KHP, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_Proyek (ID_KHP, KETERANGAN, WAKTU) VALUES('$ID_KHP', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
}
