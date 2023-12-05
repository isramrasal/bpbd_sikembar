<?php
class Aktivitas_berjalan_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan seluruh data proyek
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function proyek_list()
	{
		$hasil = $this->db->query("SELECT P.NAMA as PEGAWAI_PM, Q.NAMA as PEGAWAI_SM, R.NAMA as PEGAWAI_LOG, S.NAMA as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5, STATUS_PROYEK  FROM proyek as A
		LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
		LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
		LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
		LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data proyek berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function proyek_list_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT P.NAMA as PEGAWAI_PM, Q.NAMA as PEGAWAI_SM, R.NAMA as PEGAWAI_LOG, S.NAMA as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5, STATUS_PROYEK  FROM proyek as A
		LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
		LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
		LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
		LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC
		WHERE A.ID_PROYEK ='$ID_PROYEK'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data proyek berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function proyek_list_by_HASH_MD5($HASH_MD5)
	{
		$hasil = $this->db->query("SELECT P.NAMA as PEGAWAI_PM, Q.NAMA as PEGAWAI_SM, R.NAMA as PEGAWAI_LOG, S.NAMA as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5, STATUS_PROYEK  FROM proyek as A
		LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
		LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
		LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
		LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC
		WHERE A.HASH_MD5 ='$HASH_MD5'");
		return $hasil;
	}

	function proyek_list_by_HASH_MD5_result($HASH_MD5)
	{
		$hasil = $this->db->query("SELECT P.NAMA as PEGAWAI_PM, Q.NAMA as PEGAWAI_SM, R.NAMA as PEGAWAI_LOG, S.NAMA as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5, STATUS_PROYEK  FROM proyek as A
		LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
		LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
		LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
		LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC
		WHERE A.HASH_MD5 ='$HASH_MD5'");
		return $hasil->result();
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

	function hapus_data_by_id_proyek($ID_PROYEK)
	{
		//Hapus data di tabel Proyek, akan menghapus data di tabel RASD dan RASD barang, juga di proyek_file
		$hsl = $this->db->query("SELECT DOK_FILE FROM proyek_file WHERE ID_PROYEK='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil4 = array(
					'DOK_FILE' => $data->DOK_FILE
				);
				if(file_exists($file='./assets/upload_proyek_file/'.$data->DOK_FILE)){
					unlink($file);
				}
			}
		} else {
			$hasil4 = "BELUM ADA PROYEK";
		}

		$hasil5 = $this->db->query("DELETE FROM proyek_file WHERE ID_PROYEK='$ID_PROYEK'");


		$hsl = $this->db->query("SELECT ID_RASD FROM RASD WHERE ID_PROYEK='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil4 = array(
					'ID_RASD' => $data->ID_RASD
				);
			}
		} else {
			$hasil4 = "BELUM ADA PROYEK";
		}

		$ID_RASD = $hasil4['ID_RASD'];

		$hasil3 = $this->db->query("DELETE FROM rasd_barang WHERE ID_RASD='$ID_RASD'");
		$hasil2 = $this->db->query("DELETE FROM rasd WHERE ID_PROYEK='$ID_PROYEK'");
		$hasil = $this->db->query("DELETE FROM proyek WHERE ID_PROYEK='$ID_PROYEK'");

		return $hasil;
	}

	function get_data_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT P.ID_PEGAWAI as PEGAWAI_PM, Q.ID_PEGAWAI as PEGAWAI_SM, R.ID_PEGAWAI as PEGAWAI_LOG, S.ID_PEGAWAI as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5, STATUS_PROYEK  FROM proyek as A
		LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
		LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
		LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
		LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC
		WHERE A.ID_PROYEK ='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'HASH_MD5' => $data->HASH_MD5,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'INISIAL' => $data->INISIAL,
					'LOKASI' => $data->LOKASI,
					'PEGAWAI_PM' => $data->PEGAWAI_PM,
					'PEGAWAI_SM' => $data->PEGAWAI_SM,
					'PEGAWAI_LOG' => $data->PEGAWAI_LOG,
					'PEGAWAI_PROC' => $data->PEGAWAI_PROC,
					'STATUS_PROYEK' => $data->STATUS_PROYEK
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	function get_id_proyek_by_HASH_MD5($HASH_MD5)
	{
		$hsl = $this->db->query("SELECT P.ID_PEGAWAI as PEGAWAI_PM, Q.ID_PEGAWAI as PEGAWAI_SM, R.ID_PEGAWAI as PEGAWAI_LOG, S.ID_PEGAWAI as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5, STATUS_PROYEK  FROM proyek as A
		LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
		LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
		LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
		LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC
		WHERE A.HASH_MD5 ='$HASH_MD5'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'HASH_MD5' => $data->HASH_MD5,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'INISIAL' => $data->INISIAL,
					'LOKASI' => $data->LOKASI,
					'PEGAWAI_PM' => $data->PEGAWAI_PM,
					'PEGAWAI_SM' => $data->PEGAWAI_SM,
					'PEGAWAI_LOG' => $data->PEGAWAI_LOG,
					'PEGAWAI_PROC' => $data->PEGAWAI_PROC,
					'STATUS_PROYEK' => $data->STATUS_PROYEK
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	function get_data_by_nama_proyek($NAMA_PROYEK)
	{
		$hsl = $this->db->query("SELECT ID_PROYEK  FROM proyek 
		
		WHERE NAMA_PROYEK ='$NAMA_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil =$data->ID_PROYEK;
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	function cek_nama_proyek_by_admin($NAMA_PROYEK)
	{
		$hsl = $this->db->query("SELECT * FROM proyek WHERE NAMA_PROYEK ='$NAMA_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_PROYEK' => $data->NAMA_PROYEK
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function update_data($ID_PROYEK2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $NAMA_PROJECT_MANAGER2, $NAMA_SITE_MANAGER2, $NAMA_SPV_LOG2, $NAMA_SPV_PROC2, $STATUS_PROYEK2)
	{
		$hasil = $this->db->query("UPDATE proyek SET NAMA_PROYEK='$NAMA_PROYEK2', 
		LOKASI='$LOKASI2', 
		INISIAL='$INISIAL2', 
		STATUS_PROYEK='$STATUS_PROYEK2', 
		ID_PEGAWAI_PM ='$NAMA_PROJECT_MANAGER2', ID_PEGAWAI_SM='$NAMA_SITE_MANAGER2', ID_PEGAWAI_LOG='$NAMA_SPV_LOG2', 
		ID_PEGAWAI_PROC='$NAMA_SPV_PROC2' WHERE ID_PROYEK='$ID_PROYEK2'");
		return $hasil;
	}

	function simpan_data_by_admin($NAMA_PROYEK, $LOKASI, $INISIAL, $NAMA_PROJECT_MANAGER, $NAMA_SITE_MANAGER, $NAMA_SPV_LOG, $NAMA_SPV_PROC, $STATUS_PROYEK)
	{
		$hasil = $this->db->query("INSERT INTO proyek (NAMA_PROYEK, LOKASI, INISIAL, STATUS_PROYEK, ID_PEGAWAI_PM , ID_PEGAWAI_SM , ID_PEGAWAI_LOG, ID_PEGAWAI_PROC )VALUES('$NAMA_PROYEK', '$LOKASI', '$INISIAL', '$STATUS_PROYEK', '$NAMA_PROJECT_MANAGER', '$NAMA_SITE_MANAGER', '$NAMA_SPV_LOG', '$NAMA_SPV_PROC')");
		return $hasil;
	}

	function set_md5_id_proyek($NAMA_PROYEK, $LOKASI, $INISIAL)
	{
		$hsl = $this->db->query("SELECT ID_PROYEK FROM proyek WHERE NAMA_PROYEK='$NAMA_PROYEK' AND
		LOKASI='$LOKASI' AND
		INISIAL='$INISIAL'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		$ID_PROYEK = $hasil['ID_PROYEK'];
		$HASH_MD5 = md5($ID_PROYEK);
		$this->db->query("UPDATE proyek SET HASH_MD5='$HASH_MD5' WHERE ID_PROYEK='$ID_PROYEK'");
		
	}

	function daftar_proyek()
	{
		$hasil = $this->db->query("SELECT * FROM proyek WHERE STATUS_PROYEK='Berjalan'");
		return $hasil->result();
	}

	/* function log_Proyek($ID_PROYEK, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_Proyek (ID_PROYEK, KETERANGAN, WAKTU) VALUES('$ID_PROYEK', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
}
