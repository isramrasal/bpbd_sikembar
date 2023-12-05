<?php
class RAB_Form_File_Model extends CI_Model{

	// // function file_list(){
	// // 	$hasil=$this->db->query("SELECT * FROM ws_file");
	// // 	return $hasil->result();
	// // }
	
	// function file_list_by_id_barang_master($ID_VENDOR){
	// 	$hasil=$this->db->query("SELECT * FROM barang_master_file WHERE ID_VENDOR = '$ID_VENDOR' ORDER BY TANGGAL_UPLOAD ASC");
	// 	return $hasil;
	// }

	function file_list_by_ID_RAB_FORM($ID_RAB_FORM){
		$hasil=$this->db->query("SELECT * FROM rab_form_file WHERE ID_RAB_FORM = '$ID_RAB_FORM' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil;
	}

	function file_list_by_ID_RAB_FORM_result($ID_RAB_FORM){
		$hasil=$this->db->query("SELECT * FROM rab_form_file WHERE ID_RAB_FORM = '$ID_RAB_FORM' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil->result();
	}

	function file_list_by_HASH_MD5_RAB($HASH_MD5_RAB){
		$hasil=$this->db->query("SELECT * FROM rab_form_file WHERE HASH_MD5_RAB = '$HASH_MD5_RAB' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil;
	}

	function file_list_by_HASH_MD5_RAB_result($HASH_MD5_RAB){
		$hasil=$this->db->query("SELECT * FROM rab_form_file WHERE HASH_MD5_RAB = '$HASH_MD5_RAB' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil->result();
	}

	function file_list_by_DOK_FILE($DOK_FILE){
		$hasil=$this->db->query("SELECT * FROM rab_form_file WHERE DOK_file = '$DOK_FILE' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil;
	}

	function hapus_data_by_DOK_FILE($DOK_FILE){
		$hasil=$this->db->query("DELETE FROM rab_form_file WHERE DOK_file='$DOK_FILE'");
		return $hasil;
	}
	
}