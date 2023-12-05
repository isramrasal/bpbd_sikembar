<?php
class Jenis_barang_model extends CI_Model{

	function jenis_barang_list(){
		$hasil=$this->db->query("SELECT * FROM jenis_barang");
		return $hasil->result();
	}
	
	function jenis_barang_list_by_id_jenis_barang($ID_JENIS_BARANG){
		$hasil=$this->db->query("SELECT * FROM jenis_barang WHERE ID_JENIS_BARANG ='$ID_JENIS_BARANG'");
		return $hasil;
		//return $hasil->result();
	}
	
	// function jenis_barang_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM jenis_barang WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }
	
	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM jenis_barang WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }
	
	function hapus_data_by_id_jenis_barang($ID_JENIS_BARANG){
		$hasil=$this->db->query("DELETE FROM jenis_barang WHERE ID_JENIS_BARANG='$ID_JENIS_BARANG'");
		return $hasil;
	}
	
	function get_data_by_id_jenis_barang($ID_JENIS_BARANG){
		$hsl=$this->db->query("SELECT * FROM jenis_barang WHERE ID_JENIS_BARANG='$ID_JENIS_BARANG'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG ,
					'NAMA_JENIS_BARANG' => $data->NAMA_JENIS_BARANG,
					);
			}
		}
		else
		{
			$hasil = "BELUM ADA JENIS BARANG";
		}
		return $hasil;
	}

	function cek_nama_jenis_barang_by_admin($NAMA_JENIS_BARANG){
		$hsl = $this->db->query("SELECT * FROM jenis_barang WHERE NAMA_JENIS_BARANG ='$NAMA_JENIS_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_JENIS_BARANG' => $data->ID_JENIS_BARANG,
					'NAMA_JENIS_BARANG' => $data->NAMA_JENIS_BARANG
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function update_data($ID_JENIS_BARANG2, $NAMA_JENIS_BARANG2)
	{
		$hasil = $this->db->query("UPDATE jenis_barang SET NAMA_JENIS_BARANG='$NAMA_JENIS_BARANG2' WHERE ID_JENIS_BARANG='$ID_JENIS_BARANG2'");
		return $hasil;
	}

	function simpan_data_by_admin($NAMA_JENIS_BARANG){
		$hasil=$this->db->query("INSERT INTO jenis_barang (NAMA_JENIS_BARANG )VALUES('$NAMA_JENIS_BARANG')");
		return $hasil;
	}
	
	/* function log_jenis_barang($ID_JENIS_BARANG, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_jenis_barang (ID_JENIS_BARANG, KETERANGAN, WAKTU) VALUES('$ID_JENIS_BARANG', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
	
	
}