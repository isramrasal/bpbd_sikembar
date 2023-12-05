<?php
class Klasifikasi_barang_model extends CI_Model{

	function klasifikasi_barang_list(){
		$hasil=$this->db->query("SELECT * FROM klasifikasi_barang");
		return $hasil->result();
	}
	
	function klasifikasi_barang_list_by_ID_KLASIFIKASI_BARANG($ID_KLASIFIKASI_BARANG){
		$hasil=$this->db->query("SELECT * FROM klasifikasi_barang WHERE ID_KLASIFIKASI_BARANG ='$ID_KLASIFIKASI_BARANG'");
		return $hasil;
		//return $hasil->result();
	}
	
	// function klasifikasi_barang_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM klasifikasi_barang WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }
	
	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM klasifikasi_barang WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }
	
	function hapus_data_by_ID_KLASIFIKASI_BARANG($ID_KLASIFIKASI_BARANG){
		$hasil=$this->db->query("DELETE FROM klasifikasi_barang WHERE ID_KLASIFIKASI_BARANG='$ID_KLASIFIKASI_BARANG'");
		return $hasil;
	}
	
	function get_data_by_ID_KLASIFIKASI_BARANG($ID_KLASIFIKASI_BARANG){
		$hsl=$this->db->query("SELECT * FROM klasifikasi_barang WHERE ID_KLASIFIKASI_BARANG='$ID_KLASIFIKASI_BARANG'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG ,
					'NAMA_klasifikasi_barang' => $data->NAMA_klasifikasi_barang,
					);
			}
		}
		else
		{
			$hasil = "BELUM ADA JENIS BARANG";
		}
		return $hasil;
	}

	function cek_nama_klasifikasi_barang_by_admin($NAMA_klasifikasi_barang){
		$hsl = $this->db->query("SELECT * FROM klasifikasi_barang WHERE NAMA_klasifikasi_barang ='$NAMA_klasifikasi_barang'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KLASIFIKASI_BARANG' => $data->ID_KLASIFIKASI_BARANG,
					'NAMA_klasifikasi_barang' => $data->NAMA_klasifikasi_barang
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function update_data($ID_KLASIFIKASI_BARANG2, $NAMA_klasifikasi_barang2)
	{
		$hasil = $this->db->query("UPDATE klasifikasi_barang SET NAMA_klasifikasi_barang='$NAMA_klasifikasi_barang2' WHERE ID_KLASIFIKASI_BARANG='$ID_KLASIFIKASI_BARANG2'");
		return $hasil;
	}

	function simpan_data_by_admin($NAMA_klasifikasi_barang){
		$hasil=$this->db->query("INSERT INTO klasifikasi_barang (NAMA_klasifikasi_barang )VALUES('$NAMA_klasifikasi_barang')");
		return $hasil;
	}
	
	/* function log_klasifikasi_barang($ID_KLASIFIKASI_BARANG, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_klasifikasi_barang (ID_KLASIFIKASI_BARANG, KETERANGAN, WAKTU) VALUES('$ID_KLASIFIKASI_BARANG', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
	
	
}