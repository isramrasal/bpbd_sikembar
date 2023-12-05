<?php
class Satuan_barang_model extends CI_Model{

	//FUNGSI: Fungsi ini untuk menampilkan seluruh data satuan barang
	//SUMBER TABEL: tabel satuan_barang
	//DIPAKAI: 1. controller Satuan_barang / function data_satuan_barang
	//         2. 
	function satuan_barang_list(){
		$hasil=$this->db->query("SELECT * FROM satuan_barang ORDER BY NAMA_SATUAN_BARANG ASC");
		return $hasil->result();
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan data satuan barang berdasarkan ID_SATUAN_BARANG
	//SUMBER TABEL: tabel satuan_barang
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function satuan_barang_list_by_id_satuan_barang($ID_SATUAN_BARANG){
		$hasil=$this->db->query("SELECT * FROM satuan_barang WHERE ID_SATUAN_BARANG ='$ID_SATUAN_BARANG'");
		return $hasil;
		//return $hasil->result();
	}
	
	// function satuan_barang_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM satuan_barang WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }
	
	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM satuan_barang WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }
	
	//FUNGSI: Fungsi ini untuk menghapus data satuan barang berdasarkan ID_SATUAN_BARANG
	//SUMBER TABEL: tabel satuan_barang
	//DIPAKAI: 1. controller Satuan_barang / function hapus_data
	//         2. 
	function hapus_data_by_id_satuan_barang($ID_SATUAN_BARANG){
		$hasil=$this->db->query("DELETE FROM satuan_barang WHERE ID_SATUAN_BARANG='$ID_SATUAN_BARANG'");
		return $hasil;
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan data satuan barang berdasarkan ID_SATUAN_BARANG
	//SUMBER TABEL: tabel satuan_barang
	//DIPAKAI: 1. controller Satuan_barang / function get_data
	//         2. controller Satuan_barang / function hapus_data
	//         3. controller Satuan_barang / function update_data
	function get_data_by_id_satuan_barang($ID_SATUAN_BARANG){
		$hsl=$this->db->query("SELECT * FROM satuan_barang WHERE ID_SATUAN_BARANG='$ID_SATUAN_BARANG'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_SATUAN_BARANG' => $data->ID_SATUAN_BARANG ,
					'NAMA_SATUAN_BARANG' => $data->NAMA_SATUAN_BARANG,
					);
			}
		}
		else
		{
			$hasil = "BELUM ADA SATUAN BARANG";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data satuan barang berdasarkan NAMA_SATUAN_BARANG
	//SUMBER TABEL: tabel satuan_barang
	//DIPAKAI: 1. controller Satuan_barang / function simpan_data
	//         2. controller Satuan_barang / function update_data
	function cek_nama_satuan_barang_by_admin($NAMA_SATUAN_BARANG){
		$hsl = $this->db->query("SELECT * FROM satuan_barang WHERE NAMA_SATUAN_BARANG ='$NAMA_SATUAN_BARANG'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_SATUAN_BARANG' => $data->ID_SATUAN_BARANG,
					'NAMA_SATUAN_BARANG' => $data->NAMA_SATUAN_BARANG
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk mengubah data satuan barang berdasarkan ID_SATUAN_BARANG2
	//SUMBER TABEL: tabel satuan_barang
	//DIPAKAI: 1. controller Satuan_barang / function update_data
	//         2. 
	function update_data($ID_SATUAN_BARANG2, $NAMA_SATUAN_BARANG2)
	{
		$hasil = $this->db->query("UPDATE satuan_barang SET NAMA_SATUAN_BARANG='$NAMA_SATUAN_BARANG2' WHERE ID_SATUAN_BARANG='$ID_SATUAN_BARANG2'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengubah data satuan barang berdasarkan NAMA_SATUAN_BARANG
	//SUMBER TABEL: tabel satuan_barang
	//DIPAKAI: 1. controller Satuan_barang / function simpan_data
	//         2. 
	function simpan_data_by_admin($NAMA_SATUAN_BARANG){
		$hasil=$this->db->query("INSERT INTO satuan_barang (NAMA_SATUAN_BARANG )VALUES('$NAMA_SATUAN_BARANG')");
		return $hasil;
	}
	
	/* function log_satuan_barang($ID_SATUAN_BARANG, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_satuan_barang (ID_SATUAN_BARANG, KETERANGAN, WAKTU) VALUES('$ID_SATUAN_BARANG', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
	
	
}