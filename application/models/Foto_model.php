<?php
class Foto_model extends CI_Model{

	function foto_list(){
		$hasil=$this->db->query("SELECT * FROM foto");
		return $hasil->result();
	}
	
	function foto_list_by_id_pegawai($ID_PEGAWAI){
		$hasil=$this->db->query("SELECT * FROM foto WHERE ID_PEGAWAI ='$ID_PEGAWAI'");
		return $hasil;
		//return $hasil->result();
	}
	
	function foto_list_by_token($TOKEN){
		$hasil=$this->db->query("SELECT * FROM foto WHERE TOKEN ='$TOKEN'");
		return $hasil;
		//return $hasil->result();
	}
	
	function hapus_data_by_token($TOKEN){
		$hasil=$this->db->query("DELETE FROM foto WHERE TOKEN='$TOKEN'");
		return $hasil;
	}
	
	function hapus_data_by_id_pegawai($ID_PEGAWAI){
		$hasil=$this->db->query("DELETE FROM foto WHERE ID_PEGAWAI='$ID_PEGAWAI'");
		return $hasil;
	}
	
	function get_data_by_id_pegawai($ID_PEGAWAI){
		$hsl=$this->db->query("SELECT * FROM foto WHERE ID_PEGAWAI='$ID_PEGAWAI'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_FOTO' => $data->ID_FOTO,
					'ID_PEGAWAI' => $data->ID_PEGAWAI,
					'NAMA_FOTO' => $data->NAMA_FOTO,
					'TOKEN' => $data->TOKEN,
					'TANGGAL_UPLOAD' => $data->TANGGAL_UPLOAD,
					'KETERANGAN' => $data->KETERANGAN,
					'KETERANGAN_2' => $data->KETERANGAN_2
					);
			}
		}
		else
		{
			$hasil = "BELUM ADA FOTO";
		}
		return $hasil;
	}
	
	/* function log_foto($ID_PEGAWAI, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_foto (ID_PEGAWAI, KETERANGAN, WAKTU) VALUES('$ID_PEGAWAI', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
	
	
}