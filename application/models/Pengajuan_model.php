<?php
class Pengajuan_model extends CI_Model
{

	public function list_pengajuan_by_all_bencana()
    {
        $this->db->select('*');
        $this->db->from('form_inventaris_kebutuhan_korban_bencana');
        $query = $this->db->get();

        log_message('debug', 'SQL Query (Grup 2): ' . $this->db->last_query());

        return $query->result_array();
    }

    public function list_pengajuan_by_CREATE_BY_USER($CREATE_BY_USER)
    {
        $this->db->select('*');
        $this->db->from('form_inventaris_kebutuhan_korban_bencana');
        $this->db->where('CREATE_BY_USER', $CREATE_BY_USER);
        $query = $this->db->get();

        log_message('debug', 'SQL Query (Grup 3): ' . $this->db->last_query());

        return $query->result_array();
    }

    // Ambil data dengan filter jenis bencana
	public function list_pengajuan_by_filter($ID_JENIS_BENCANA_LIST, $user_id)
	{
		$this->db->select('*');
		$this->db->from('form_inventaris_kebutuhan_korban_bencana');
	
		if ($ID_JENIS_BENCANA_LIST !== "Semua") {
			$this->db->where('Jenis_Bencana', $ID_JENIS_BENCANA_LIST);
		}
	
		$this->db->where('CREATE_BY_USER', $user_id);
	
		$query = $this->db->get();
	
		return $query->result_array();
	}

	public function count_pengajuan_by_filter($ID_JENIS_BENCANA_LIST, $user_id)
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('form_inventaris_kebutuhan_korban_bencana');
        
		// Filter berdasarkan jenis bencana
        if ($ID_JENIS_BENCANA_LIST !== "Semua") {
            $this->db->where('Jenis_Bencana', $ID_JENIS_BENCANA_LIST);  
        }

        // Filter berdasarkan user ID
        $this->db->where('CREATE_BY_USER', $user_id);
        
        $query = $this->db->get();
        $result = $query->row();

        return $result->total;
    }
	
	
	function pengajuan_list_by_id_pengajuan($ID_FORM_INVENTARIS_KORBAN_BENCANA)
	{
		$hasil = $this->db->query("SELECT FIK.ID_FORM_INVENTARIS_KORBAN_BENCANA, FIK.CODE_MD5, FIK.Nomor_Surat_Form_Inventaris, DATE_FORMAT(FIK.Tanggal_Pembuatan, '%d/%m/%Y') AS TANGGAL_PEMBUATAN, DATE_FORMAT(FIK.Tanggal_Surat, '%d/%m/%Y') AS TANGGAL_SURAT, FIK.Nama_Pemohon, FIK.Jumlah_Korban_Diwakili, FIK.NIK, FIK.NIP, FIK.Jabatan, FIK.Instansi, FIK.Kampung_Bencana, FIK.RT, FIK.RW, FIK.Desa_Kelurahan_Bencana, FIK.Kecamatan_Bencana, FIK.Kabupaten_Kota_Bencana, FIK.Kode_Pos_Bencana, FIK.Jenis_Bencana, FIK.Nama_Pejabat_BPBD, FIK.NIP_Pejabat_BPBD, FIK.Jabatan_Pejabat_BPBD, DATE_FORMAT(FIK.TANGGAL_KEJADIAN_BENCANA, '%d/%m/%Y') AS TANGGAL_KEJADIAN_BENCANA FROM form_inventaris_kebutuhan_korban_bencana AS FIK
        WHERE FIK.ID_FORM_INVENTARIS_KORBAN_BENCANA =  '$ID_FORM_INVENTARIS_KORBAN_BENCANA'");
		return $hasil;
		//return $hasil->result();
	}

	function get_data_pengajuan_by_CODE_MD5($CODE_MD5)
	{
		$hsl = $this->db->query("SELECT * FROM form_inventaris_kebutuhan_korban_bencana WHERE CODE_MD5 ='$CODE_MD5'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FORM_INVENTARIS_KORBAN_BENCANA' => $data->ID_FORM_INVENTARIS_KORBAN_BENCANA,
					'CODE_MD5' => $data->CODE_MD5,
					'Nomor_Surat_Form_Inventaris' => $data->Nomor_Surat_Form_Inventaris,
					'PROGRESS_PENGAJUAN' => $data->PROGRESS_PENGAJUAN,
					'STATUS_PENGAJUAN' => $data->STATUS_PENGAJUAN
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	public function get_data_pengajuan_by_CODE_MD5_perwakilan($CODE_MD5)
	{
		// Query untuk mendapatkan data dengan CODE_MD5 yang cocok
		$query = $this->db->query("SELECT * FROM form_inventaris_kebutuhan_korban_bencana WHERE CODE_MD5 = '$CODE_MD5'");
		if ($query->num_rows() > 0) {
			$data = $query->row();
			return array(
				'ID_FORM_INVENTARIS_KORBAN_BENCANA' => $data->ID_FORM_INVENTARIS_KORBAN_BENCANA,
				'CODE_MD5' => $data->CODE_MD5,
				'Nomor_Surat_Form_Inventaris' => $data->Nomor_Surat_Form_Inventaris,
				'PROGRESS_PENGAJUAN' => $data->PROGRESS_PENGAJUAN,
				'STATUS_PENGAJUAN' => $data->STATUS_PENGAJUAN
			);
		} else {
			return 'TIDAK ADA DATA';
		}
	}
	function simpan_data_pengajuan_bantuan(
		$CODE_MD5,
		$ID_JENIS_BENCANA,
		$NAMA_PEMOHON,
		$NIK,
		$ID_KABUPATEN_KOTA,
		$ID_KECAMATAN,
		$ID_DESA_KELURAHAN,
		$RW,
		$RT,
		$KAMPUNG,
		$KODE_POS,
		$TANGGAL_DOKUMEN_PENGAJUAN,
		$TANGGAL_KEJADIAN_BENCANA,
		$TANGGAL_PEMBUATAN_PENGAJUAN_JAM,
		$TANGGAL_PEMBUATAN,
		$TANGGAL_PEMBUATAN_PENGAJUAN_BULAN,
		$TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN,
		$CREATE_BY_USER,
		$PROGRESS_PENGAJUAN,
		$STATUS_PENGAJUAN
	)
	{
		$hasil = $this->db->query("INSERT INTO form_inventaris_kebutuhan_korban_bencana (
				CODE_MD5,
				Tanggal_Pembuatan,
				Tanggal_Surat,
				Hari_Surat,
				Nama_Pemohon,
				NIK,
				Kampung_Bencana,
				RT,
				RW,
				Desa_Kelurahan_Bencana,
				Kecamatan_Bencana,
				Kabupaten_Kota_Bencana,
				Kode_Pos_Bencana,
				Jenis_Bencana,
				TANGGAL_KEJADIAN_BENCANA,
                CREATE_BY_USER,
				PROGRESS_PENGAJUAN,
                STATUS_PENGAJUAN)
			VALUES(
				'$CODE_MD5',
				'$TANGGAL_PEMBUATAN',
				'$TANGGAL_DOKUMEN_PENGAJUAN',
				'$TANGGAL_PEMBUATAN',
				'$NAMA_PEMOHON',
				'$NIK',
				'$KAMPUNG',
				'$RW',
				'$RT',
				'$ID_DESA_KELURAHAN',
				'$ID_KECAMATAN',
                '$ID_KABUPATEN_KOTA',
                '$KODE_POS',
                '$ID_JENIS_BENCANA',
                '$TANGGAL_KEJADIAN_BENCANA',
                '$CREATE_BY_USER',
                '$PROGRESS_PENGAJUAN',
				'$STATUS_PENGAJUAN'
				)");

		return $hasil;
	}

	function simpan_data_pengajuan_bantuan_perwakilan(
		$CODE_MD5_PERWAKILAN,
		$ID_JENIS_BENCANA_PERWAKILAN,
		$NAMA_PEMOHON_PERWAKILAN,
		$JUMLAH_KORBAN_DIWAKILI,
		$NIP,
		$NIK_PERWAKILAN,
		$JABATAN,
		$INSTANSI,		
		$ID_KABUPATEN_KOTA_PERWAKILAN,
		$ID_KECAMATAN_PERWAKILAN,
		$ID_DESA_KELURAHAN_PERWAKILAN,
		$RW_PERWAKILAN,
		$RT_PERWAKILAN,
		$KAMPUNG_PERWAKILAN,
		$KODE_POS_PERWAKILAN,
		$TANGGAL_DOKUMEN_PENGAJUAN_PERWAKILAN,
		$TANGGAL_KEJADIAN_BENCANA_PERWAKILAN,
		$TANGGAL_PEMBUATAN_PENGAJUAN_JAM,
		$TANGGAL_PEMBUATAN,
		$TANGGAL_PEMBUATAN_PENGAJUAN_BULAN,
		$TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN,
		$CREATE_BY_USER,
		$PROGRESS_PENGAJUAN,
		$STATUS_PENGAJUAN
	)
	{
		$hasil = $this->db->query("INSERT INTO form_inventaris_kebutuhan_korban_bencana (
				CODE_MD5,
				Tanggal_Pembuatan,
				Tanggal_Surat,
				Hari_Surat,
				Nama_Pemohon,
				Jumlah_Korban_Diwakili,
				NIP,
				NIK,
				Jabatan,
				Instansi,
				Kampung_Bencana,
				RT,
				RW,
				Desa_Kelurahan_Bencana,
				Kecamatan_Bencana,
				Kabupaten_Kota_Bencana,
				Kode_Pos_Bencana,
				Jenis_Bencana,
				TANGGAL_KEJADIAN_BENCANA,
                CREATE_BY_USER,
				PROGRESS_PENGAJUAN,
                STATUS_PENGAJUAN)
			VALUES(
				'$CODE_MD5_PERWAKILAN',
				'$TANGGAL_PEMBUATAN',
				'$TANGGAL_DOKUMEN_PENGAJUAN_PERWAKILAN',
				'$TANGGAL_PEMBUATAN',
				'$NAMA_PEMOHON_PERWAKILAN',
				'$JUMLAH_KORBAN_DIWAKILI',
				'$NIP',
				'$NIK_PERWAKILAN',
				'$JABATAN',
				'$INSTANSI',
				'$KAMPUNG_PERWAKILAN',
				'$RW_PERWAKILAN',
				'$RT_PERWAKILAN',
				'$ID_DESA_KELURAHAN_PERWAKILAN',
				'$ID_KECAMATAN_PERWAKILAN',
				'$ID_KABUPATEN_KOTA_PERWAKILAN',
				'$KODE_POS_PERWAKILAN',
				'$ID_JENIS_BENCANA_PERWAKILAN',
				'$TANGGAL_KEJADIAN_BENCANA_PERWAKILAN',
				'$CREATE_BY_USER',
				'$PROGRESS_PENGAJUAN',
				'$STATUS_PENGAJUAN'
				)");

		return $hasil;
	}
	function get_data_pengajuan_baru($CODE_MD5)
	{
		$hsl = $this->db->query("SELECT * FROM form_inventaris_kebutuhan_korban_bencana WHERE CODE_MD5 = '$CODE_MD5'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CODE_MD5' => $data->CODE_MD5
				);
			}
		} else {
			$hasil = "BELUM ADA PENGAJUAN";
		}
		return $hasil;
	}
}