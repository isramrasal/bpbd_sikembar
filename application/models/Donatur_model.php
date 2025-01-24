<?php
class Donatur_model extends CI_Model
{
    public function list_pengajuan_by_user($CREATE_BY_USER)
    {
        $this->db->select('*'); // Pilih semua kolom
        $this->db->from('form_inventaris_bantuan_donasi'); // Nama tabel
        $this->db->where('CREATE_BY_USER', $CREATE_BY_USER); // Filter berdasarkan kolom CREATE_BY_USER
        $query = $this->db->get(); // Eksekusi query

        log_message('debug', 'SQL Query (Grup 4): ' . $this->db->last_query()); // Logging SQL query

        return $query->result_array(); // Kembalikan hasil sebagai array
    }

	public function count_donatur($user_id)
    {
        $this->db->select('COUNT(*) as total');
        $this->db->from('form_inventaris_bantuan_donasi');  // Ganti dengan nama tabel yang sesuai
        // Filter berdasarkan user ID
        $this->db->where('CREATE_BY_USER', $user_id);  // Ganti dengan kolom yang sesuai dengan user ID
        
        // Eksekusi query
        $query = $this->db->get();
        $result = $query->row();

        // Mengembalikan hasil jumlah pengajuan
        return $result->total;
    }

	function list_donatur_by_nik($NIK)
	{
		$hasil = $this->db->query("SELECT * FROM form_inventaris_bantuan_donasi WHERE NIK = '$NIK'");
		return $hasil->result();
	}
	
	function donatur_list_by_id_donatur($ID_FORM_INVENTARIS_BANTUAN_DONASI)
	{
		$hasil = $this->db->query("SELECT FPBD.ID_FORM_INVENTARIS_BANTUAN_DONASI, FPBD.CODE_MD5, FPBD.Nomor_Surat_Bantuan_Donasi, DATE_FORMAT(FPBD.Tanggal_Pembuatan, '%d/%m/%Y') AS TANGGAL_PEMBUATAN, DATE_FORMAT(FPBD.Tanggal_Surat, '%d/%m/%Y') AS TANGGAL_SURAT, FPBD.Nama_Donatur, FPBD.NIK, FPBD.NIP, FPBD.Jabatan, FPBD.Instansi, FPBD.Kampung_Bencana, FPBD.RT, FPBD.RW, FPBD.Desa_Kelurahan_Bencana, FPBD.Kecamatan_Bencana, FPBD.Kabupaten_Kota_Bencana, FPBD.Kode_Pos_Bencana, FPBD.Jenis_Bencana, FPBD.Nama_Pejabat_BPBD, FPBD.NIP_Pejabat_BPBD, FPBD.Jabatan_Pejabat_BPBD FROM form_inventaris_bantuan_donasi AS FPBD
        WHERE FPBD.ID_FORM_INVENTARIS_BANTUAN_DONASI =  '$ID_FORM_INVENTARIS_BANTUAN_DONASI'");
		return $hasil;
		//return $hasil->result();
	}

	function get_data_donatur_by_CODE_MD5($CODE_MD5)
	{
		$hsl = $this->db->query("SELECT * FROM form_inventaris_bantuan_donasi WHERE CODE_MD5 ='$CODE_MD5'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FORM_INVENTARIS_BANTUAN_DONASI' => $data->ID_FORM_INVENTARIS_BANTUAN_DONASI,
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

	function simpan_data_pengajuan_donasi(
		$CODE_MD5,
		$NAMA_DONATUR,
		$NIK,
		$NIP,
		$JABATAN,
		$INSTANSI,
		$ID_KABUPATEN_KOTA,
		$ID_KECAMATAN,
		$ID_DESA_KELURAHAN,
		$RW,
		$RT,
		$KAMPUNG,
		$KODE_POS,
		$TANGGAL_DOKUMEN_DONASI,
		$TANGGAL_PEMBUATAN,
		$TANGGAL_PEMBUATAN_PENGAJUAN_JAM,
		$TANGGAL_PEMBUATAN_PENGAJUAN_HARI,
		$TANGGAL_PEMBUATAN_PENGAJUAN_BULAN,
		$TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN,
		$CREATE_BY_USER,
		$PROGRESS_PENGAJUAN,
		$STATUS_PENGAJUAN
	)
	{
		$hasil = $this->db->query("INSERT INTO form_inventaris_bantuan_donasi (
				CODE_MD5,
				Tanggal_Pembuatan,
				Tanggal_Surat,
				Hari_Surat,
				Nama_Donatur,
				NIK,
				NIP,
				Jabatan,
				Instansi,
				Kampung_Bencana,
				RT,
				RW,
				Desa_Kelurahan_Bencana,
				Kecamatan_Bencana,
				Kabupaten_Kota_Bencana,
				Kode_Pos_Bencana,
				TANGGAL_PEMBUATAN_PENGAJUAN_JAM,
				TANGGAL_PEMBUATAN_PENGAJUAN_HARI,
				TANGGAL_PEMBUATAN_PENGAJUAN_BULAN,
                TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN,
                CREATE_BY_USER,
				PROGRESS_PENGAJUAN,
                STATUS_PENGAJUAN)
			VALUES(
				'$CODE_MD5',
				'$TANGGAL_PEMBUATAN',
				'$TANGGAL_DOKUMEN_DONASI',
				'$TANGGAL_PEMBUATAN_PENGAJUAN_HARI',
				'$NAMA_DONATUR',
				'$NIK',
				'$NIP',
				'$JABATAN',
				'$INSTANSI',
				'$KAMPUNG',
				'$RW',
				'$RT',
				'$ID_DESA_KELURAHAN',
				'$ID_KECAMATAN',
                '$ID_KABUPATEN_KOTA',
                '$KODE_POS',
                '$TANGGAL_PEMBUATAN_PENGAJUAN_JAM',
				'$TANGGAL_PEMBUATAN_PENGAJUAN_HARI',
                '$TANGGAL_PEMBUATAN_PENGAJUAN_BULAN',
                '$TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN',
                '$CREATE_BY_USER',
                '$PROGRESS_PENGAJUAN',
				'$STATUS_PENGAJUAN'
				)");

		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data sppb berdasarkan HASH_MD5_SPPB
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function get_data_sppb_baru
	//         2. 
	public function get_data_donatur_baru($CODE_MD5)
	{
    // Query untuk mendapatkan data dengan CODE_MD5 yang cocok
    $query = $this->db->query("SELECT * FROM form_inventaris_bantuan_donasi WHERE CODE_MD5 = '$CODE_MD5'");
    if ($query->num_rows() > 0) {
        $data = $query->row();
        return array(
            'ID_FORM_INVENTARIS_BANTUAN_DONASI' => $data->ID_FORM_INVENTARIS_BANTUAN_DONASI,
            'CODE_MD5' => $data->CODE_MD5,
            'Nomor_Surat_Form_Inventaris' => $data->Nomor_Surat_Form_Inventaris,
            'PROGRESS_PENGAJUAN' => $data->PROGRESS_PENGAJUAN,
            'STATUS_PENGAJUAN' => $data->STATUS_PENGAJUAN
        );
    } else {
        return 'TIDAK ADA DATA';
    }
	}
}