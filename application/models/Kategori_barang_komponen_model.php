<?php
class Kategori_barang_komponen_model extends CI_Model{

	function kategori_barang_komponen_list(){
		$hasil=$this->db->query("SELECT * FROM kategori_barang_komponen");
		return $hasil->result();
	}
	
	function kategori_barang_komponen_list_by_id_kategori_barang_komponen($ID_KATEGORI_BARANG_KOMPONEN){
		$hasil=$this->db->query("SELECT * FROM kategori_barang_komponen WHERE ID_KATEGORI_BARANG_KOMPONEN ='$ID_KATEGORI_BARANG_KOMPONEN'");
		return $hasil;
		//return $hasil->result();
	}
	
	// function kategori_barang_komponen_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM kategori_barang_komponen WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }
	
	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM kategori_barang_komponen WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }
	
	function hapus_data_by_id_kategori_barang_komponen($ID_KATEGORI_BARANG_KOMPONEN){
		$hasil=$this->db->query("DELETE FROM kategori_barang_komponen WHERE ID_KATEGORI_BARANG_KOMPONEN='$ID_KATEGORI_BARANG_KOMPONEN'");
		return $hasil;
	}
	
	function get_data_by_id_kategori_barang_komponen($ID_KATEGORI_BARANG_KOMPONEN){
		$hsl=$this->db->query("SELECT * FROM kategori_barang_komponen WHERE ID_KATEGORI_BARANG_KOMPONEN='$ID_KATEGORI_BARANG_KOMPONEN'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_KATEGORI_BARANG_KOMPONEN' => $data->ID_KATEGORI_BARANG_KOMPONEN ,
					'NAMA_KATEGORI_BARANG_KOMPONEN' => $data->NAMA_KATEGORI_BARANG_KOMPONEN,
					);
			}
		}
		else
		{
			$hasil = "BELUM ADA KATEGORI BARANG";
		}
		return $hasil;
	}

	function cek_nama_kategori_barang_komponen_by_admin($NAMA_KATEGORI_BARANG_KOMPONEN){
		$hsl = $this->db->query("SELECT * FROM kategori_barang_komponen WHERE NAMA_KATEGORI_BARANG_KOMPONEN ='$NAMA_KATEGORI_BARANG_KOMPONEN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KATEGORI_BARANG_KOMPONEN' => $data->ID_KATEGORI_BARANG_KOMPONEN,
					'NAMA_KATEGORI_BARANG_KOMPONEN' => $data->NAMA_KATEGORI_BARANG_KOMPONEN
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function update_data($ID_KATEGORI_BARANG_KOMPONEN2, $NAMA_KATEGORI_BARANG_KOMPONEN2)
	{
		$hasil = $this->db->query("UPDATE kategori_barang_komponen SET NAMA_KATEGORI_BARANG_KOMPONEN='$NAMA_KATEGORI_BARANG_KOMPONEN2' WHERE ID_KATEGORI_BARANG_KOMPONEN='$ID_KATEGORI_BARANG_KOMPONEN2'");
		return $hasil;
	}

	function simpan_data_by_admin($NAMA_KATEGORI_BARANG_KOMPONEN){
		$hasil=$this->db->query("INSERT INTO kategori_barang_komponen (NAMA_KATEGORI_BARANG_KOMPONEN )VALUES('$NAMA_KATEGORI_BARANG_KOMPONEN')");
		return $hasil;
	}
	
	/* function log_kategori_barang_komponen($ID_KATEGORI_BARANG_KOMPONEN, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_kategori_barang_komponen (ID_KATEGORI_BARANG_KOMPONEN, KETERANGAN, WAKTU) VALUES('$ID_KATEGORI_BARANG_KOMPONEN', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
	
	
}