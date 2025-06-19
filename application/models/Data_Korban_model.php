<?php
class Data_Korban_model extends CI_Model
{

	function list_korban_by_all_bencana()
	{
		$hasil = $this->db->query("SELECT * FROM data_korban");
		return $hasil->result();
	}

	public function count_data_korban_by_filter($ID_JENIS_BENCANA_LIST, $user_id)
	{
		$this->db->select('COUNT(*) as total');
		$this->db->from('data_korban'); 

		if ($ID_JENIS_BENCANA_LIST !== "Semua") {
			$this->db->where('Jenis_Bencana', $ID_JENIS_BENCANA_LIST); 
		}

		$this->db->where('CREATE_BY_USER', $user_id); 
		$query = $this->db->get();
		$result = $query->row();

		return $result->total;
	}


	function korban_list_by_id_korban($ID_KORBAN) //122023
	{
		$hasil = $this->db->query("SELECT DK.CODE_MD5, DK.ID_KORBAN, DK.JENIS_BENCANA, DK.NAMA_KORBAN, DK.NO_KK, DK.NIK, DK.TEMPAT_LAHIR, DATE_FORMAT(DK.TANGGAL_LAHIR, '%d/%m/%Y') AS TANGGAL_LAHIR, DK.ALAMAT,DK.KABUPATEN_KOTA, DK.KECAMATAN, DK.DESA_KELURAHAN, DK.RT, DK.RW, DK.KAMPUNG, DK.KODE_POS, DATE_FORMAT(DK.TANGGAL_KEJADIAN_BENCANA, '%d/%m/%Y') AS TANGGAL_KEJADIAN_BENCANA FROM data_korban AS DK  WHERE DK.ID_KORBAN = '$ID_KORBAN'
		");
		return $hasil->result();
	}

	function get_data_korban_by_CODE_MD5($CODE_MD5)
	{
		$hsl = $this->db->query("SELECT * FROM data_korban WHERE CODE_MD5 ='$CODE_MD5'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_KORBAN' => $data->ID_KORBAN,
					'CODE_MD5' => $data->CODE_MD5,
					'PROGRESS_DATA_KORBAN' => $data->PROGRESS_DATA_KORBAN,
					'STATUS_DATA_KORBAN' => $data->STATUS_DATA_KORBAN
				);
			}
		} else {
			$hasil = "TIDAK ADA DATA";
		}
		return $hasil;
	}
public function get_last_update($user_id)
{
    $this->db->select('MAX(TANGGAL_KEJADIAN_BENCANA) as last_update');
    $this->db->from('data_korban');
    $this->db->where('CREATE_BY_USER', $user_id);
    $query = $this->db->get();
    
    if ($query->num_rows() > 0) {
        $result = $query->row();
        return $result->last_update ? date('d-m-Y', strtotime($result->last_update)) : 'Belum ada data';
    }
    return 'Belum ada data';
}


	function simpan_data_korban(
		$CODE_MD5,
		$JENIS_BENCANA,
		$NAMA_KORBAN,
		$NO_KK,
		$NIK,
		$TEMPAT_LAHIR,
		$TANGGAL_LAHIR,
		$ALAMAT,
		$ID_KABUPATEN_KOTA,
		$ID_KECAMATAN,
		$ID_DESA_KELURAHAN,
		$RW,
		$RT,
		$KAMPUNG,
		$KODE_POS,
		$TANGGAL_KEJADIAN_BENCANA,
		$CREATE_BY_USER,
		$PROGRESS_DATA_KORBAN,
		$STATUS_DATA_KORBAN
	)
	{
		$hasil = $this->db->query("INSERT INTO data_korban (
				CODE_MD5,
				JENIS_BENCANA,
				NAMA_KORBAN,
				NO_KK,
				NIK,
				TEMPAT_LAHIR,
				TANGGAL_LAHIR,
				ALAMAT,
				KABUPATEN_KOTA,
				KECAMATAN,
                DESA_KELURAHAN,
                RW,
                RT,
                KAMPUNG,
				KODE_POS,	
				TANGGAL_KEJADIAN_BENCANA,
                CREATE_BY_USER,
				PROGRESS_DATA_KORBAN,
                STATUS_DATA_KORBAN)
			VALUES(
				'$CODE_MD5',
				'$JENIS_BENCANA',
				'$NAMA_KORBAN',
				'$NO_KK',
				'$NIK',
				'$TEMPAT_LAHIR',
				'$TANGGAL_LAHIR',
				'$ALAMAT',
				'$ID_DESA_KELURAHAN',
				'$ID_KECAMATAN',
                '$ID_KABUPATEN_KOTA',
				'$RW',
				'$RT',
				'$KAMPUNG',
                '$KODE_POS',
                '$TANGGAL_KEJADIAN_BENCANA',
                '$CREATE_BY_USER',
                '$PROGRESS_DATA_KORBAN',
				'$STATUS_DATA_KORBAN'
				)");

		return $hasil;
	}


	function get_data_korban_baru($CODE_MD5)
	{
		$hsl = $this->db->query("SELECT * FROM data_korban WHERE CODE_MD5 = '$CODE_MD5'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CODE_MD5' => $data->CODE_MD5
				);
			}
		} else {
			$hasil = "BELUM ADA DATA_KORBAN";
		}
		return $hasil;
	}
}