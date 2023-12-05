<?php
class ws_jabatan_model extends CI_Model{

	function jabatan_list(){
		$hasil=$this->db->query("SELECT ws_jabatan.ID_JABATAN, ws_jabatan.NAMA_JABATAN, ws_jabatan.KETERANGAN, ws_jabatan.STATUS, ws_jabatan.ID_PEGAWAI, ws_pegawai.NAMA, ws_pegawai.NIP
		FROM ws_jabatan
		LEFT JOIN ws_pegawai
		ON ws_jabatan.ID_PEGAWAI=ws_pegawai.ID_PEGAWAI");
		return $hasil->result();
	}
	
	function jabatan_list_by_status(){
		$hasil=$this->db->query("SELECT * FROM ws_jabatan WHERE STATUS = 'internal' ORDER BY NAMA_JABATAN ASC");
		return $hasil->result();
	}
	
	function jabatan_list_by_id_pegawai_atau_status($ID_PEGAWAI){
		$hasil=$this->db->query("SELECT * FROM ws_jabatan WHERE ID_PEGAWAI ='$ID_PEGAWAI' OR STATUS = 'internal'");
		return $hasil->result();
	}
	
	function simpan_data_by_admin($NAMA_JABATAN,$KETERANGAN, $ID_PEGAWAI){
		$hasil=$this->db->query("INSERT INTO ws_jabatan (NAMA_JABATAN, KETERANGAN, STATUS, ID_PEGAWAI )VALUES('$NAMA_JABATAN','$KETERANGAN', 'internal', $ID_PEGAWAI)");
		return $hasil;
	}
	
	function simpan_data_by_pegawai($NAMA_JABATAN,$KETERANGAN, $ID_PEGAWAI){
		$hasil=$this->db->query("INSERT INTO ws_jabatan (NAMA_JABATAN, KETERANGAN, STATUS, ID_PEGAWAI )VALUES('$NAMA_JABATAN','$KETERANGAN', 'eksternal', $ID_PEGAWAI)");
		return $hasil;
	}
	
	function cek_nama_jabatan_by_admin($NAMA_JABATAN){
		$hsl=$this->db->query("SELECT * FROM ws_jabatan WHERE NAMA_JABATAN ='$NAMA_JABATAN' AND STATUS = 'internal'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_JABATAN' => $data->ID_JABATAN,
					'NAMA_JABATAN' => $data->NAMA_JABATAN,
					'KETERANGAN' => $data->KETERANGAN,
					);
			}
			return $hasil;
		}
		else
		{
			return 'Data belum ada';
		}
	}
	
	function cek_nama_jabatan_by_pegawai($NAMA_JABATAN, $ID_PEGAWAI){
		$hsl=$this->db->query("SELECT * FROM ws_jabatan WHERE NAMA_JABATAN ='$NAMA_JABATAN' AND STATUS = 'eksternal' AND ID_PEGAWAI ='$ID_PEGAWAI'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_JABATAN' => $data->ID_JABATAN,
					'NAMA_JABATAN' => $data->NAMA_JABATAN,
					'KETERANGAN' => $data->KETERANGAN,
					);
			}
			return $hasil;
		}
		else
		{
			return 'Data belum ada';
		}
	}
		
	
	function get_data_by_id($id){
		$hsl=$this->db->query("SELECT * FROM ws_jabatan WHERE ID_JABATAN='$id'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_JABATAN' => $data->ID_JABATAN,
					'NAMA_JABATAN' => $data->NAMA_JABATAN,
					'KETERANGAN' => $data->KETERANGAN,
					);
			}
		}
		return $hasil;
	}
	
	function update_data($ID_JABATAN,$NAMA_JABATAN,$KETERANGAN){
		$hasil=$this->db->query("UPDATE ws_jabatan SET NAMA_JABATAN='$NAMA_JABATAN',KETERANGAN='$KETERANGAN' WHERE ID_JABATAN='$ID_JABATAN'");
		return $hasil;
	}
	
	function hapus_data($ID_JABATAN){
		$hasil=$this->db->query("DELETE FROM ws_jabatan WHERE ID_JABATAN='$ID_JABATAN'");
		return $hasil;
	}
	
	function log_jabatan($ID_PEGAWAI, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_jabatan (ID_PEGAWAI, KETERANGAN, WAKTU) VALUES('$ID_PEGAWAI', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
	
	function get_data_log_jabatan($ID_PEGAWAI){
		$hasil=$this->db->query("SELECT * from ws_log_jabatan where ID_PEGAWAI='$ID_PEGAWAI'");
		return $hasil->result();
	}
}