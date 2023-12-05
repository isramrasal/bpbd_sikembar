<?php
class Proyek_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh proyek
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function list_proyek
	//         2. 
	function list_proyek()
	{
		$hasil = $this->db->query("SELECT ID_PROYEK, HASH_MD5_PROYEK, NAMA_PROYEK, LOKASI, INISIAL, STATUS_PROYEK, PERSENTASE, DATE_FORMAT(TANGGAL_SELESAI_PROYEK, '%d/%m/%Y') AS TANGGAL_SELESAI_PROYEK, DATE_FORMAT(TANGGAL_MULAI_PROYEK, '%d/%m/%Y') AS TANGGAL_MULAI_PROYEK  FROM proyek");
		return $hasil->result();
	}

	function list_proyek_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT ID_PROYEK, HASH_MD5_PROYEK, NAMA_PROYEK, LOKASI, INISIAL, STATUS_PROYEK, PERSENTASE, DATE_FORMAT(TANGGAL_SELESAI_PROYEK, '%d/%m/%Y') AS TANGGAL_SELESAI_PROYEK, DATE_FORMAT(TANGGAL_MULAI_PROYEK, '%d/%m/%Y') AS TANGGAL_MULAI_PROYEK FROM proyek WHERE ID_PROYEK ='$ID_PROYEK' ");
		return $hasil->result();
	}

	function list_pegawai()
	{
		$hasil = $this->db->query("SELECT NAMA AS NAMA_PEGAWAI FROM pegawai ORDER BY NAMA ASC");
		return $hasil->result();
	}

	function get_list_sppb_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT * FROM sppb WHERE ID_PROYEK ='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	//FUNGSI: Fungsi ini untuk menampilkan data proyek (objek result) berdasarkan HASH_MD5_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function detil_proyek
	//         2. 
	function detil_proyek_by_HASH_MD5_PROYEK_result($HASH_MD5_PROYEK)
	{
		$hasil = $this->db->query("SELECT ID_PROYEK, HASH_MD5_PROYEK, NAMA_PROYEK, LOKASI, INISIAL, STATUS_PROYEK, PERSENTASE, DATE_FORMAT(TANGGAL_SELESAI_PROYEK, '%d/%m/%Y') AS TANGGAL_SELESAI_PROYEK, DATE_FORMAT(TANGGAL_MULAI_PROYEK, '%d/%m/%Y') AS TANGGAL_MULAI_PROYEK  FROM proyek
		WHERE HASH_MD5_PROYEK ='$HASH_MD5_PROYEK'");
		return $hasil->result();
	}

	function detil_proyek_by_ID_PROYEK_result($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT ID_PROYEK, HASH_MD5_PROYEK, NAMA_PROYEK, LOKASI, INISIAL, STATUS_PROYEK, PERSENTASE, DATE_FORMAT(TANGGAL_SELESAI_PROYEK, '%d/%m/%Y') AS TANGGAL_SELESAI_PROYEK, DATE_FORMAT(TANGGAL_MULAI_PROYEK, '%d/%m/%Y') AS TANGGAL_MULAI_PROYEK  FROM proyek
		WHERE ID_PROYEK ='$ID_PROYEK'");
		return $hasil->result();
	}

	function detil_proyek_by_ID_PROYEK($ID_PROYEK) //112023
	{
		$hasil = $this->db->query("SELECT ID_PROYEK, HASH_MD5_PROYEK, NAMA_PROYEK, LOKASI, INISIAL, STATUS_PROYEK, PERSENTASE, TANGGAL_SELESAI_PROYEK, DATE_FORMAT(TANGGAL_MULAI_PROYEK, '%d/%m/%Y') AS TANGGAL_MULAI_PROYEK  FROM proyek
		WHERE ID_PROYEK ='$ID_PROYEK'");
		return $hasil;
	}


	//FUNGSI: Fungsi ini untuk menampilkan data proyek berdasarkan HASH_MD5_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function detil_proyek
	//         2. 
	function detil_proyek_by_HASH_MD5_PROYEK($HASH_MD5_PROYEK)
	{
		$hasil = $this->db->query("SELECT ID_PROYEK, HASH_MD5_PROYEK, NAMA_PROYEK, LOKASI, INISIAL, STATUS_PROYEK, PERSENTASE, DATE_FORMAT(TANGGAL_SELESAI_PROYEK, '%d/%m/%Y') AS TANGGAL_SELESAI_PROYEK, DATE_FORMAT(TANGGAL_MULAI_PROYEK, '%d/%m/%Y') AS TANGGAL_MULAI_PROYEK  FROM proyek
		WHERE HASH_MD5_PROYEK ='$HASH_MD5_PROYEK'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data pegawai berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel pegawai
	//DIPAKAI: 1. controller Proyek / function organisasi_proyek
	//         2. 
	function pegawai_list_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT P.ID_PEGAWAI, U.USERNAME, P.NIP, P.NAMA, P.EMAIL, P.NO_HP_1, P.JABATAN_PEGAWAI, R.NAMA_PROYEK, Q.NAMA_DEPARTEMEN, P.ID_JABATAN_PEGAWAI, G.description as NAMA_JABATAN  FROM pegawai as P
		LEFT JOIN proyek as R ON P.ID_PROYEK_PEGAWAI=R.ID_PROYEK
		LEFT JOIN departemen as Q ON P.ID_DEPARTEMEN_PEGAWAI=Q.ID_DEPARTEMEN 
        LEFT JOIN groups as G on G.id = P.ID_JABATAN_PEGAWAI
        LEFT JOIN users as U on U.ID_PEGAWAI=P.ID_PEGAWAI
        where P.ID_PROYEK_PEGAWAI='$ID_PROYEK'");
		return $hasil->result();
	}

	function lokasi_penyerahan_list_by_id_proyek($ID_PROYEK){
		$hasil = $this->db->query("SELECT NAMA_LOKASI_PENYERAHAN, ID_PROYEK_LOKASI_PENYERAHAN FROM proyek_lokasi_penyerahan where ID_PROYEK  ='$ID_PROYEK'");
		return $hasil->result();
	}

	function lokasi_penyerahan_list($ID_PROYEK_LOKASI_PENYERAHAN){
		$hasil = $this->db->query("SELECT NAMA_LOKASI_PENYERAHAN, ID_PROYEK FROM proyek_lokasi_penyerahan where ID_PROYEK_LOKASI_PENYERAHAN  ='$ID_PROYEK_LOKASI_PENYERAHAN'");
		return $hasil;
	}

	function sub_pekerjaan_list_by_id_proyek($ID_PROYEK){
		$hasil = $this->db->query("SELECT PSP.NAMA_SUB_PEKERJAAN, PSP.ID_PROYEK_SUB_PEKERJAAN, RAB.HASH_MD5_RAB FROM proyek_sub_pekerjaan AS PSP 
		LEFT JOIN rab as RAB on RAB.ID_PROYEK_SUB_PEKERJAAN= PSP.ID_PROYEK_SUB_PEKERJAAN
		where PSP.ID_PROYEK  = '$ID_PROYEK'");
		return $hasil->result();
	}

	function sub_pekerjaan_list($ID_PROYEK_SUB_PEKERJAAN){
		$hasil = $this->db->query("SELECT NAMA_SUB_PEKERJAAN, ID_PROYEK FROM proyek_sub_pekerjaan where ID_PROYEK_SUB_PEKERJAAN  ='$ID_PROYEK_SUB_PEKERJAAN'");
		return $hasil;
	}

	// function proyek_list()
	// {
	// 	$hasil = $this->db->query("SELECT P.NAMA as PEGAWAI_PM, Q.NAMA as PEGAWAI_SM, R.NAMA as PEGAWAI_LOG, S.NAMA as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5_PROYEK, STATUS_PROYEK  FROM proyek as A
	// 	LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
	// 	LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
	// 	LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
	// 	LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC");
	// 	return $hasil->result();
	// }

	// function proyek_list_by_id_proyek($ID_PROYEK)
	// {
	// 	$hasil = $this->db->query("SELECT P.NAMA as PEGAWAI_PM, Q.NAMA as PEGAWAI_SM, R.NAMA as PEGAWAI_LOG, S.NAMA as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5_PROYEK, STATUS_PROYEK  FROM proyek as A
	// 	LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
	// 	LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
	// 	LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
	// 	LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC
	// 	WHERE A.ID_PROYEK ='$ID_PROYEK'");
	// 	return $hasil;
	// }

	// function proyek_list_by_HASH_MD5_PROYEK($HASH_MD5_PROYEK)
	// {
	// 	$hasil = $this->db->query("SELECT P.NAMA as PEGAWAI_PM, Q.NAMA as PEGAWAI_SM, R.NAMA as PEGAWAI_LOG, S.NAMA as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5_PROYEK, STATUS_PROYEK  FROM proyek as A
	// 	LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
	// 	LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
	// 	LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
	// 	LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC
	// 	WHERE A.HASH_MD5_PROYEK ='$HASH_MD5_PROYEK'");
	// 	return $hasil;
	// }

	// function proyek_list_by_HASH_MD5_PROYEK_result($HASH_MD5_PROYEK)
	// {
	// 	$hasil = $this->db->query("SELECT P.NAMA as PEGAWAI_PM, Q.NAMA as PEGAWAI_SM, R.NAMA as PEGAWAI_LOG, S.NAMA as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5_PROYEK, STATUS_PROYEK  FROM proyek as A
	// 	LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
	// 	LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
	// 	LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
	// 	LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC
	// 	WHERE A.HASH_MD5_PROYEK ='$HASH_MD5_PROYEK'");
	// 	return $hasil->result();
	// }

	// function Proyek_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM Proyek WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM Proyek WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }

	function hapus_data_lokasi($ID_PROYEK_LOKASI_PENYERAHAN){
		$hasil=$this->db->query("DELETE FROM proyek_lokasi_penyerahan WHERE ID_PROYEK_LOKASI_PENYERAHAN='$ID_PROYEK_LOKASI_PENYERAHAN'");
		return $hasil;
	}

	function hapus_data_sub_pekerjaan($ID_PROYEK_SUB_PEKERJAAN){
		$hasil=$this->db->query("DELETE FROM proyek_sub_pekerjaan WHERE ID_PROYEK_SUB_PEKERJAAN='$ID_PROYEK_SUB_PEKERJAAN'");
		return $hasil;
	}

	function get_id_proyek_by_id_rasd($ID_RASD)
	{

		$hasil = $this->db->query("SELECT P.ID_PROYEK, P.INISIAL, RASD.ID_RASD FROM rasd AS RASD 
		LEFT JOIN proyek AS P ON P.ID_PROYEK = RASD.ID_PROYEK
		WHERE RASD.ID_RASD ='$ID_RASD'");
		return $hasil;
	}


	//FUNGSI: Fungsi ini untuk menghapus data berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function hapus_data
	//         2. 
	function hapus_data_by_id_proyek($ID_PROYEK)
	{
		//Hapus data di tabel Proyek, akan menghapus data di tabel RASD dan RASD barang, juga di proyek_file
		$hsl = $this->db->query("SELECT DOK_FILE FROM proyek_file WHERE ID_PROYEK='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil4 = array(
					'DOK_FILE' => $data->DOK_FILE
				);
				if (file_exists($file = './assets/upload_proyek_file/' . $data->DOK_FILE)) {
					unlink($file);
				}
			}
			$this->db->query("DELETE FROM proyek_file WHERE ID_PROYEK='$ID_PROYEK'");
		}

		$hsl = $this->db->query("SELECT ID_RASD FROM RASD WHERE ID_PROYEK='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil4 = array(
					'ID_RASD' => $data->ID_RASD
				);
			}
			$ID_RASD = $hasil4['ID_RASD'];
			$this->db->query("DELETE FROM rasd_form WHERE ID_RASD='$ID_RASD'");
			$this->db->query("DELETE FROM rasd WHERE ID_PROYEK='$ID_PROYEK'");
		}

		$hsl = $this->db->query("SELECT ID_PROYEK FROM proyek_sub_pekerjaan WHERE ID_PROYEK='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			$this->db->query("DELETE FROM proyek_sub_pekerjaan WHERE ID_PROYEK='$ID_PROYEK'");
		}

		$hasil = $this->db->query("DELETE FROM proyek WHERE ID_PROYEK='$ID_PROYEK'");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menyimpan data berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function get_data
	//         2. 
	function get_data_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT P.ID_PEGAWAI as PEGAWAI_PM, Q.ID_PEGAWAI as PEGAWAI_SM, R.ID_PEGAWAI as PEGAWAI_LOG, S.ID_PEGAWAI as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5_PROYEK, STATUS_PROYEK, PERSENTASE, DATE_FORMAT(TANGGAL_MULAI_PROYEK, '%d/%m/%Y') AS TANGGAL_MULAI_PROYEK, DATE_FORMAT(TANGGAL_SELESAI_PROYEK, '%d/%m/%Y') AS TANGGAL_SELESAI_PROYEK FROM proyek as A
		LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
		LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
		LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
		LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC
		WHERE A.ID_PROYEK ='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'HASH_MD5_PROYEK' => $data->HASH_MD5_PROYEK,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'INISIAL' => $data->INISIAL,
					'LOKASI' => $data->LOKASI,
					'PEGAWAI_PM' => $data->PEGAWAI_PM,
					'PEGAWAI_SM' => $data->PEGAWAI_SM,
					'PEGAWAI_LOG' => $data->PEGAWAI_LOG,
					'PEGAWAI_PROC' => $data->PEGAWAI_PROC,
					'STATUS_PROYEK' => $data->STATUS_PROYEK,
					'PERSENTASE' => $data->PERSENTASE,
					'TANGGAL_MULAI_PROYEK' => $data->TANGGAL_MULAI_PROYEK,
					'TANGGAL_SELESAI_PROYEK' => $data->TANGGAL_SELESAI_PROYEK
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	function get_data_lokasi_by_id_proyek_lokasi_penyerahan($ID_PROYEK_LOKASI_PENYERAHAN)
	{
		$hsl = $this->db->query("SELECT A.ID_PROYEK, A.ID_PROYEK_LOKASI_PENYERAHAN, A.NAMA_LOKASI_PENYERAHAN FROM proyek_lokasi_penyerahan AS A
		LEFT JOIN proyek as P ON P.ID_PROYEK=A.ID_PROYEK
		WHERE A.ID_PROYEK_LOKASI_PENYERAHAN ='$ID_PROYEK_LOKASI_PENYERAHAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_PROYEK_LOKASI_PENYERAHAN' => $data->ID_PROYEK_LOKASI_PENYERAHAN,
					'NAMA_LOKASI_PENYERAHAN' => $data->NAMA_LOKASI_PENYERAHAN
				);
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	function get_data_sub_pekerjaan_by_id_proyek_sub_pekerjaan($ID_PROYEK_SUB_PEKERJAAN)
	{
		$hsl = $this->db->query("SELECT A.ID_PROYEK, A.ID_PROYEK_SUB_PEKERJAAN, A.NAMA_SUB_PEKERJAAN FROM proyek_sub_pekerjaan AS A
		LEFT JOIN proyek as P ON P.ID_PROYEK=A.ID_PROYEK
		WHERE A.ID_PROYEK_SUB_PEKERJAAN ='$ID_PROYEK_SUB_PEKERJAAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'NAMA_SUB_PEKERJAAN' => $data->NAMA_SUB_PEKERJAAN
				);
			}
		} else {
			$hasil = "BELUM ADA SUB PEKERJAAN";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data berdasarkan HASH_MD5_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function get_data
	//         2. 
	function get_id_proyek_by_HASH_MD5_PROYEK($HASH_MD5_PROYEK)
	{
		$hsl = $this->db->query("SELECT P.ID_PEGAWAI as PEGAWAI_PM, Q.ID_PEGAWAI as PEGAWAI_SM, R.ID_PEGAWAI as PEGAWAI_LOG, S.ID_PEGAWAI as PEGAWAI_PROC, NAMA_PROYEK, LOKASI, INISIAL, ID_PROYEK, HASH_MD5_PROYEK, STATUS_PROYEK  FROM proyek as A
		LEFT JOIN pegawai as P ON P.ID_PEGAWAI=A.ID_PEGAWAI_PM
		LEFT JOIN pegawai as Q ON Q.ID_PEGAWAI=A.ID_PEGAWAI_SM
		LEFT JOIN pegawai as R ON R.ID_PEGAWAI=A.ID_PEGAWAI_LOG
		LEFT JOIN pegawai as S ON S.ID_PEGAWAI=A.ID_PEGAWAI_PROC
		WHERE A.HASH_MD5_PROYEK ='$HASH_MD5_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'HASH_MD5_PROYEK' => $data->HASH_MD5_PROYEK,
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

	//FUNGSI: Fungsi ini untuk menampilkan data berdasarkan NAMA_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function simpan_data
	//         2. 
	function get_data_by_nama_proyek($NAMA_PROYEK)
	{
		$hsl = $this->db->query("SELECT ID_PROYEK  FROM proyek 
		
		WHERE NAMA_PROYEK ='$NAMA_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = $data->ID_PROYEK;
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	function get_data_id_sub_pekerjaan_by_nama_sub_pekerjaan($ID_PROYEK, $NAMA_SUB_PEKERJAAN)
	{
		$hsl = $this->db->query("SELECT ID_PROYEK_SUB_PEKERJAAN  FROM proyek_sub_pekerjaan 
		
		WHERE NAMA_SUB_PEKERJAAN = '$NAMA_SUB_PEKERJAAN' AND ID_PROYEK = '$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = $data->ID_PROYEK_SUB_PEKERJAAN;
			}
		} else {
			$hasil = "BELUM ADA PROYEK SUB PEKERJAAN";
		}
		return $hasil;
	}

	function get_data_by_id_lokasi($ID_PROYEK_LOKASI_PENYERAHAN)
	{
		$hsl = $this->db->query("SELECT ID_PROYEK_LOKASI_PENYERAHAN  FROM proyek_lokasi_penyerahan WHERE ID_PROYEK_LOKASI_PENYERAHAN ='$ID_PROYEK_LOKASI_PENYERAHAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = $data->ID_PROYEK_LOKASI_PENYERAHAN;
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	function get_data_by_id_sub_pekerjaan($ID_PROYEK_SUB_PEKERJAAN)
	{
		$hsl = $this->db->query("SELECT *  FROM proyek_sub_pekerjaan WHERE ID_PROYEK_SUB_PEKERJAAN ='$ID_PROYEK_SUB_PEKERJAAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = $data->ID_PROYEK_SUB_PEKERJAAN;
			}
		} else {
			$hasil = "BELUM ADA PROYEK";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data berdasarkan NAMA_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function simpan_data
	//         2. 
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

	function cek_nama_lokasi($NAMA_LOKASI_PENYERAHAN, $ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT * FROM proyek_lokasi_penyerahan WHERE NAMA_LOKASI_PENYERAHAN ='$NAMA_LOKASI_PENYERAHAN' AND ID_PROYEK ='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_LOKASI_PENYERAHAN' => $data->NAMA_LOKASI_PENYERAHAN
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function cek_nama_sub_pekerjaan($ID_PROYEK, $NAMA_SUB_PEKERJAAN)
	{
		$hsl = $this->db->query("SELECT * FROM proyek_sub_pekerjaan WHERE NAMA_SUB_PEKERJAAN ='$NAMA_SUB_PEKERJAAN' AND ID_PROYEK = '$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_SUB_PEKERJAAN' => $data->NAMA_SUB_PEKERJAAN
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk mengupdate data berdasarkan ID_PROYEK2
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function update_data
	//         2. 
	function update_data($ID_PROYEK2, $NAMA_PROYEK2, $LOKASI2, $INISIAL2, $STATUS_PROYEK2, $TANGGAL_MULAI_PROYEK2, $TANGGAL_SELESAI_PROYEK2, $PERSENTASE2)
	{
		$hasil = $this->db->query("UPDATE proyek SET NAMA_PROYEK='$NAMA_PROYEK2', 
		LOKASI='$LOKASI2', 
		INISIAL='$INISIAL2', 
		STATUS_PROYEK='$STATUS_PROYEK2',
		TANGGAL_MULAI_PROYEK='$TANGGAL_MULAI_PROYEK2',
		TANGGAL_SELESAI_PROYEK='$TANGGAL_SELESAI_PROYEK2',
		PERSENTASE='$PERSENTASE2' WHERE ID_PROYEK='$ID_PROYEK2'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengupdate data (data_organisasi) berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function update_data_organisasi
	//         2. 
	function update_data_organisasi(
		$ID_PROYEK,
		$ID_PEGAWAI_PM,
		$ID_PEGAWAI_SM,
		$ID_PEGAWAI_LOG,
		$ID_PEGAWAI_PROC
	) {
		$hasil = $this->db->query("UPDATE proyek SET ID_PEGAWAI_PM='$ID_PEGAWAI_PM', 
		ID_PEGAWAI_SM='$ID_PEGAWAI_SM', 
		ID_PEGAWAI_LOG='$ID_PEGAWAI_LOG', 
		ID_PEGAWAI_PROC='$ID_PEGAWAI_PROC' WHERE ID_PROYEK='$ID_PROYEK'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data berdasarkan $NAMA_PROYEK, $LOKASI, $INISIAL, $STATUS_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function simpan_data
	//         2. 
	function simpan_data_by_admin($NAMA_PROYEK, $LOKASI, $INISIAL, $STATUS_PROYEK, $TANGGAL_MULAI_PROYEK, $TANGGAL_SELESAI_PROYEK)
	{
		$hasil = $this->db->query("INSERT INTO proyek (NAMA_PROYEK, LOKASI, INISIAL, STATUS_PROYEK, TANGGAL_MULAI_PROYEK, TANGGAL_SELESAI_PROYEK)VALUES('$NAMA_PROYEK', '$LOKASI', '$INISIAL', '$STATUS_PROYEK', '$TANGGAL_MULAI_PROYEK', '$TANGGAL_SELESAI_PROYEK')");
		return $hasil;
	}

	function simpan_data_lokasi($ID_PROYEK, $NAMA_LOKASI_PENYERAHAN)
	{
		$hasil = $this->db->query("INSERT INTO proyek_lokasi_penyerahan (ID_PROYEK, NAMA_LOKASI_PENYERAHAN)VALUES('$ID_PROYEK','$NAMA_LOKASI_PENYERAHAN')");
		return $hasil;
	}

	function simpan_data_sub_pekerjaan($ID_PROYEK, $NAMA_SUB_PEKERJAAN)
	{
		$hasil = $this->db->query("INSERT INTO proyek_sub_pekerjaan (ID_PROYEK, NAMA_SUB_PEKERJAAN)VALUES('$ID_PROYEK','$NAMA_SUB_PEKERJAAN')");
		return $hasil;
	}

	function simpan_data_rab_baru($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN)
	{
		$hasil = $this->db->query("INSERT INTO RAB (ID_PROYEK, ID_PROYEK_SUB_PEKERJAAN) VALUES('$ID_PROYEK','$ID_PROYEK_SUB_PEKERJAAN')");
		return $hasil;
	}

	function set_md5_id_rab_by_ID_PROYEK_dan_ID_PROYEK_SUB_PEKERJAAN($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN)
	{
		$hsl = $this->db->query("SELECT ID_RAB FROM RAB WHERE ID_PROYEK='$ID_PROYEK' AND ID_PROYEK_SUB_PEKERJAAN = '$ID_PROYEK_SUB_PEKERJAAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RAB' => $data->ID_RAB
				);
			}
		} else {
			$hasil = "BELUM ADA RAB";
		}
		$ID_RAB = $hasil['ID_RAB'];
		$HASH_MD5_RAB = md5($ID_RAB);
		$this->db->query("UPDATE RAB SET HASH_MD5_RAB='$HASH_MD5_RAB' WHERE ID_RAB='$ID_RAB'");
		
	}

	public function getreq()
	{
		$this->db->select('NAMA_LOKASI_PENYERAHAN');
		$query = $this->db->get('proyek_lokasi_penyerahan');
		
		return $query->result();
	}

	//FUNGSI: Fungsi ini untuk mengeset HASH_MD5_PROYEK berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function simpan_data
	//         2. 
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
		$HASH_MD5_PROYEK = md5($ID_PROYEK);
		$this->db->query("UPDATE proyek SET HASH_MD5_PROYEK='$HASH_MD5_PROYEK' WHERE ID_PROYEK='$ID_PROYEK'");
	}

	//FUNGSI: Fungsi ini untuk menambahkan data berdasarkan $ID_USER, $KETERANGAN, $WAKTU
	//SUMBER TABEL: tabel proyek
	//DIPAKAI: 1. controller Proyek / function logout
	//         2. 
	function user_log_proyek($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_proyek (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
