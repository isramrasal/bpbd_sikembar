<?php
class Quotation_Form_File_Model extends CI_Model{

	// // function file_list(){
	// // 	$hasil=$this->db->query("SELECT * FROM ws_file");
	// // 	return $hasil->result();
	// // }
	
	// function file_list_by_id_barang_master($ID_VENDOR){
	// 	$hasil=$this->db->query("SELECT * FROM barang_master_file WHERE ID_VENDOR = '$ID_VENDOR' ORDER BY TANGGAL_UPLOAD ASC");
	// 	return $hasil;
	// }

	function file_list_by_ID_RFQ_FORM($ID_RFQ_FORM){
		$hasil=$this->db->query("SELECT * FROM rfq_form_file WHERE ID_RFQ_FORM = '$ID_RFQ_FORM' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil;
	}

	function file_list_by_ID_RFQ_FORM_result($ID_RFQ_FORM){
		$hasil=$this->db->query("SELECT * FROM rfq_form_file WHERE ID_RFQ_FORM = '$ID_RFQ_FORM' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil->result();
	}

	function file_list_by_HASH_MD5_QUOTATION($HASH_MD5_QUOTATION){ //dipakai
		$hasil=$this->db->query("SELECT * FROM quotation_form_file WHERE HASH_MD5_QUOTATION = '$HASH_MD5_QUOTATION' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil;
	}

	function file_list_by_HASH_MD5_QUOTATION_result($HASH_MD5_QUOTATION){ //dipakai
		$hasil=$this->db->query("SELECT * FROM quotation_form_file WHERE HASH_MD5_QUOTATION = '$HASH_MD5_QUOTATION' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil->result();
	}

	function file_list_by_DOK_FILE($DOK_FILE){
		$hasil=$this->db->query("SELECT * FROM rfq_form_file WHERE DOK_file = '$DOK_FILE' ORDER BY TANGGAL_UPLOAD ASC");
		return $hasil;
	}

	function hapus_data_by_DOK_FILE($DOK_FILE){
		$hasil=$this->db->query("DELETE FROM rfq_form_file WHERE DOK_file='$DOK_FILE'");
		return $hasil;
	}

	// function file_list_by_DOK_FILE($DOK_FILE){
	// 	$hasil=$this->db->query("SELECT * FROM barang_master_file WHERE DOK_file = '$DOK_FILE' ORDER BY TANGGAL_UPLOAD ASC");
	// 	return $hasil;
	// }
	
	// // function file_list_by_token($TOKEN){
	// // 	$hasil=$this->db->query("SELECT * FROM ws_file WHERE TOKEN ='$TOKEN'");
	// // 	return $hasil;
	// // 	//return $hasil->result();
	// // }
	
	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM ws_file WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }
	
	// function get_data_by_id_pegawai($ID_PEGAWAI){
	// 	$hsl=$this->db->query("SELECT * FROM ws_file WHERE ID_PEGAWAI='$ID_PEGAWAI'");
	// 	if($hsl->num_rows()>0){
	// 		foreach ($hsl->result() as $data) {
	// 			$hasil=array(
	// 				'ID_file' => $data->ID_file,
	// 				'ID_PEGAWAI' => $data->ID_PEGAWAI,
	// 				'NAMA_file' => $data->NAMA_file,
	// 				'TOKEN' => $data->TOKEN,
	// 				'TANGGAL_UPLOAD' => $data->TANGGAL_UPLOAD,
	// 				'KETERANGAN' => $data->KETERANGAN,
	// 				);
	// 		}
	// 	}
	// 	else
	// 	{
	// 		$hasil = "BELUM ADA file";
	// 	}
	// 	return $hasil;
	// }
	
	// /* function log_file($ID_PEGAWAI, $KETERANGAN, $WAKTU){
	// 	$hasil=$this->db->query("INSERT INTO ws_log_file (ID_PEGAWAI, KETERANGAN, WAKTU) VALUES('$ID_PEGAWAI', '$KETERANGAN', '$WAKTU')");
	// 	return $hasil;
	// } */
	
	
}