<?php
class Barang_komponen_model extends CI_Model
{

    function barang_komponen_list()
    {
        $hasil = $this->db->query("SELECT A.ID_BARANG_KOMPONEN, B.ID_KATEGORI_BARANG_KOMPONEN, A.NAMA_KOMPONEN, B.NAMA_KATEGORI 
        FROM barang_komponen AS A 
        LEFT JOIN kategori_barang_komponen AS B ON B.ID_KATEGORI_BARANG_KOMPONEN = A.ID_KATEGORI_BARANG_KOMPONEN
        ");
        return $hasil->result();
    }

    function barang_komponen_list_by_id_barang_komponen($ID_BARANG_KOMPONEN)
    {
        $hasil = $this->db->query("SELECT A.ID_BARANG_KOMPONEN, B.ID_KATEGORI_BARANG_KOMPONEN, A.NAMA_KOMPONEN, B.NAMA_KATEGORI 
        FROM barang_komponen AS A 
        LEFT JOIN kategori_barang_komponen AS B ON B.ID_KATEGORI_BARANG_KOMPONEN = A.ID_KATEGORI_BARANG_KOMPONEN 
        WHERE ID_BARANG_KOMPONEN ='$ID_BARANG_KOMPONEN'");
        return $hasil;
        //return $hasil->result();
    }

    // function barang_komponen_list_by_token($TOKEN){
    // 	$hasil=$this->db->query("SELECT * FROM barang_komponen WHERE TOKEN ='$TOKEN'");
    // 	return $hasil;
    // 	//return $hasil->result();
    // }

    // function hapus_data_by_token($TOKEN){
    // 	$hasil=$this->db->query("DELETE FROM barang_komponen WHERE TOKEN='$TOKEN'");
    // 	return $hasil;
    // }

    function hapus_data_by_id_barang_komponen($ID_BARANG_KOMPONEN)
    {
        $hasil = $this->db->query("DELETE FROM barang_komponen WHERE ID_BARANG_KOMPONEN='$ID_BARANG_KOMPONEN'");
        return $hasil;
    }

    function get_data_by_id_barang_komponen($ID_BARANG_KOMPONEN)
    {
        $hsl = $this->db->query("SELECT * FROM barang_komponen WHERE ID_BARANG_KOMPONEN='$ID_BARANG_KOMPONEN'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'ID_BARANG_KOMPONEN' => $data->ID_BARANG_KOMPONEN,
                    'NAMA_KOMPONEN' => $data->NAMA_KOMPONEN,
                    'NAMA_KATEGORI' => $data->ID_KATEGORI_BARANG_KOMPONEN
                );
            }
        } else {
            $hasil = "BELUM ADA BARANG KOMPONEN";
        }
        return $hasil;
    }

    function cek_nama_komponen_by_admin($NAMA_KOMPONEN)
    {
        $hsl = $this->db->query("SELECT * FROM barang_komponen WHERE NAMA_KOMPONEN ='$NAMA_KOMPONEN'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    'ID_BARANG_KOMPONEN' => $data->ID_BARANG_KOMPONEN,
                    'NAMA_KOMPONEN' => $data->NAMA_KOMPONEN,
                    'NAMA_KATEGORI' => $data->ID_KATEGORI_BARANG_KOMPONEN

                );
            }
            return $hasil;
        } else {
            return 'Data belum ada';
        }
    }

    function update_data($ID_BARANG_KOMPONEN2, $NAMA_KOMPONEN2, $NAMA_KATEGORI2)
    {
        $hasil = $this->db->query("UPDATE barang_komponen SET NAMA_KOMPONEN='$NAMA_KOMPONEN2', ID_KATEGORI_BARANG_KOMPONEN='$NAMA_KATEGORI2' WHERE ID_BARANG_KOMPONEN='$ID_BARANG_KOMPONEN2'");
        return $hasil;
    }

    function simpan_data_by_admin($NAMA_KOMPONEN, $NAMA_KATEGORI)
    {
        $hasil = $this->db->query("INSERT INTO barang_komponen (NAMA_KOMPONEN, ID_KATEGORI_BARANG_KOMPONEN)VALUES('$NAMA_KOMPONEN','$NAMA_KATEGORI')");
        return $hasil;
    }
    function list_kategori()
    {
        $hasil = $this->db->query("SELECT * FROM kategori_barang_komponen");
        return $hasil->result();
    }

    /* function log_barang_komponen($ID_BARANG_KOMPONEN, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_barang_komponen (ID_BARANG_KOMPONEN, KETERANGAN, WAKTU) VALUES('$ID_BARANG_KOMPONEN', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	} */
}
