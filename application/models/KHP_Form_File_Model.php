<?php
class KHP_Form_File_Model extends CI_Model{

	function file_list_by_ID_KHP_FORM($ID_KHP_FORM){
		$hasil=$this->db->query("SELECT * FROM khp_form_file WHERE ID_KHP_FORM = '$ID_KHP_FORM' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil;
	}

	function file_list_by_ID_KHP_FORM_result($ID_KHP_FORM){
		$hasil=$this->db->query("SELECT * FROM khp_form_file WHERE ID_KHP_FORM = '$ID_KHP_FORM' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil->result();
	}

	function file_list_by_HASH_MD5_KHP($HASH_MD5_KHP){
		$hasil=$this->db->query("SELECT * FROM khp_form_file WHERE HASH_MD5_KHP = '$HASH_MD5_KHP' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil;
	}

	function file_list_by_HASH_MD5_KHP_result($HASH_MD5_KHP){
		$hasil=$this->db->query("SELECT * FROM khp_form_file WHERE HASH_MD5_KHP = '$HASH_MD5_KHP' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil->result();
	}

	function file_list_by_DOK_FILE($DOK_FILE){
		$hasil=$this->db->query("SELECT * FROM khp_form_file WHERE DOK_file = '$DOK_FILE' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil;
	}

	function hapus_data_by_DOK_FILE($DOK_FILE){
		$hasil=$this->db->query("DELETE FROM khp_form_file WHERE DOK_file='$DOK_FILE'");
		return $hasil;
	}
	
}