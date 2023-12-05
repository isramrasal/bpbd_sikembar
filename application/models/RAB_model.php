<?php
class RAB_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh RAB
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RAB / function data_RAB
	//         2. 
	function RAB_list() //DIPAKE
	{
		$hasil = $this->db->query("SELECT P.ID_PROYEK, P.NAMA_PROYEK, P.LOKASI, P.STATUS_PROYEK, P.HASH_MD5_PROYEK, P.INISIAL,  C.NAMA as PEGAWAI_PM, D.NAMA as PEGAWAI_SM  FROM proyek AS P
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=P.ID_PEGAWAI_PM
		LEFT JOIN pegawai as D ON D.ID_PEGAWAI=P.ID_PEGAWAI_SM");
		return $hasil->result();
	}


	function RAB_form_list_by_ID_RAB($ID_RAB){ //DIPAKE
		$hasil = $this->db->query("SELECT * FROM rab_form where ID_RAB  ='$ID_RAB'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RAB berdasarkan HASH_MD5_RAB
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RAB_form / function index
	//         2. 
	function RAB_list_by_HASH_MD5_RAB($HASH_MD5_RAB) //DIPAKE
	{
		$hasil = $this->db->query("SELECT A.ID_RAB, A.HASH_MD5_RAB, A.ID_PROYEK_SUB_PEKERJAAN, A.ID_PROYEK, B.NAMA_PROYEK, B.HASH_MD5_PROYEK, B.LOKASI, B.ID_PEGAWAI_PM, B.INISIAL, B.ID_PEGAWAI_SM, C.NAMA as PEGAWAI_PM, D.NAMA as PEGAWAI_SM, A.ID_RAB, B.STATUS_PROYEK, PSB.NAMA_SUB_PEKERJAAN, PSB.ID_PROYEK_SUB_PEKERJAAN FROM rab as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=B.ID_PEGAWAI_PM 
		LEFT JOIN pegawai as D ON D.ID_PEGAWAI=B.ID_PEGAWAI_SM
        LEFT JOIN proyek_sub_pekerjaan as PSB ON PSB.ID_PROYEK_SUB_PEKERJAAN=A.ID_PROYEK_SUB_PEKERJAAN
        WHERE A.HASH_MD5_RAB = '$HASH_MD5_RAB'");
		return $hasil;
		//return $hasil->result();
	}


	function get_list_rab_by_id_proyek($ID_PROYEK) //DIPAKE
	{
		$hsl = $this->db->query("SELECT RAB.ID_RAB, RAB.HASH_MD5_RAB, RAB.ID_PROYEK, RAB.ID_PROYEK_SUB_PEKERJAAN, PSB.NAMA_SUB_PEKERJAAN FROM RAB as RAB
		LEFT JOIN proyek_sub_pekerjaan as PSB ON RAB.ID_PROYEK_SUB_PEKERJAAN = PSB.ID_PROYEK_SUB_PEKERJAAN
		WHERE RAB.ID_PROYEK = '$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function get_id_rab_by_HASH_MD5_RAB($HASH_MD5_RAB)
	{
		$hsl = $this->db->query("SELECT ID_RAB, ID_PROYEK FROM RAB 
		WHERE HASH_MD5_RAB ='$HASH_MD5_RAB'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RAB' => $data->ID_RAB,
					'ID_PROYEK' => $data->ID_PROYEK
				);
			}
		} else {
			$hasil = "BELUM ADA RAB";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data RAB berdasarkan $ID_USER', '$KETERANGAN', '$WAKTU'
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RAB_form / function logout
	//         2. controller RAB_form / function user_log
	//		   3. controller RAB / function user_log
	function user_log_rab($ID_USER, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO user_log_rab (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
	
}
