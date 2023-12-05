<?php
class Departemen_model extends CI_Model
{

	function departemen_list()
	{
		$hasil = $this->db->query("SELECT * FROM departemen");
		return $hasil->result();
	}

	function pegawai_list_table_view()
	{
		$hasil = $this->db->query("SELECT P.ID_PEGAWAI, P.NIP, P.NAMA, P.EMAIL, P.NO_HP_1, R.NAMA_PROYEK  FROM pegawai as P
		LEFT JOIN proyek as R ON P.ID_PROYEK_PEGAWAI=R.ID_PROYEK");
		return $hasil->result();
	}


	
}
