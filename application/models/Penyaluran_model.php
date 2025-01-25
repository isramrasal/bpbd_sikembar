<?php
class Penyaluran_model extends CI_Model
{

	//FUNGSI: Fungsi ini untuk menampilkan data seluruh sppb
	//SUMBER TABEL: tabel sppb
	//DIPAKAI: 1. controller SPPB / function index
	//         2. controller SPPB / function list_sppb_by_all_proyek

	// public function getPenyaluranByUser($user_id) {
    //     $this->db->select('form_penyaluran_barang_bencana.*');
    //     $this->db->from('form_penyaluran_barang_bencana');
    //     $this->db->join('form_inventaris_kebutuhan_korban_bencana', 'form_penyaluran_barang_bencana.id_penyaluran = form_inventaris_kebutuhan_korban_bencana.id_penyaluran');
    //     $this->db->where('form_inventaris_kebutuhan_korban_bencana.create_by_user', $user_id);
    //     $query = $this->db->get();
    //     return $query->result_array();
    // }

	function list_penyaluran_by_all_bencana()
	{
		$hasil = $this->db->query("SELECT * FROM form_penyaluran_barang_bencana");
		return $hasil->result();
	}

	public function list_penyaluran_by_filter($ID_JENIS_BENCANA_LIST, $user_id)
	{
		$this->db->select('*');
		$this->db->from('form_penyaluran_barang_bencana');
	
		if ($ID_JENIS_BENCANA_LIST !== "Semua") {
			$this->db->where('Jenis_Bencana', $ID_JENIS_BENCANA_LIST);
		}
	
		$this->db->where('CREATE_BY_USER', $user_id);
	
		$query = $this->db->get();
	
		return $query->result_array();
	}
	

	// function list_penyaluran_by_all_bencana_by_NIK($NIK_Penerima) {
	// 	$this->db->where('NIK_Penerima', $NIK_Penerima);
	// 	$query = $this->db->get('form_penyaluran_barang_bencana');
		
	// 	log_message('debug', 'Query Result: ' . json_encode($query->result()));  // Log query result for debugging
	// 	return $query->result_array();  // Ensure the result is returned as an array
	// }

	// public function list_penyaluran_by_filter($ID_JENIS_BENCANA_LIST, $user_id)
	// {
	// 	// Pilih kolom yang diperlukan dari kedua tabel
	// 	$this->db->select('
	// 		form_penyaluran_barang_bencana.*,
	// 		form_inventaris_kebutuhan_korban_bencana.Jenis_Bencana,
	// 		form_inventaris_kebutuhan_korban_bencana.CREATE_BY_USER
	// 	');
	
	// 	// Tentukan tabel utama
	// 	$this->db->from('form_penyaluran_barang_bencana');
	
	// 	// Lakukan join ke tabel form_inventaris_kebutuhan_korban_bencana
	// 	$this->db->join(
	// 		'form_inventaris_kebutuhan_korban_bencana',
	// 		'form_penyaluran_barang_bencana.id_form_penyaluran_barang_bencana = form_inventaris_kebutuhan_korban_bencana.id_form_inventaris_kebutuhan_korban_bencana'
	// 	);
	
	// 	// Tambahkan filter untuk jenis bencana (jika bukan "Semua")
	// 	if ($ID_JENIS_BENCANA_LIST !== "Semua") {
	// 		$this->db->where('form_inventaris_kebutuhan_korban_bencana.Jenis_Bencana', $ID_JENIS_BENCANA_LIST);
	// 	}
	
	// 	// Tambahkan filter berdasarkan user yang membuat data
	// 	if (!empty($user_id)) {
	// 		$this->db->where('form_inventaris_kebutuhan_korban_bencana.CREATE_BY_USER', $user_id);
	// 	}
	
	// 	// Eksekusi query
	// 	$query = $this->db->get();
	
	// 	// Log untuk debugging
	// 	log_message('debug', 'SQL Query: ' . $this->db->last_query());
	
	// 	// Kembalikan hasil sebagai array
	// 	return $query->result_array();
	// }
	


	
	
	

	function penyaluran_list_by_id_penyaluran($ID_FORM_PENYALURAN_BARANG_BENCANA)
	{
		$hasil = $this->db->query("SELECT FPBB.ID_FORM_PENYALURAN_BARANG_BENCANA AS ID_FORM_PENYALURAN_BARANG_BENCANA, FPBB.CODE_MD5 AS CODE_MD5, DATE_FORMAT(FPBB.Tanggal_Pembuatan, '%d/%m/%Y') AS Tanggal_Pembuatan, DATE_FORMAT(FPBB.Tanggal_Surat, '%d/%m/%Y') AS Tanggal_Surat, FPBB.Nama_Penerima AS Nama_Penerima, FPBB.Nomor_KK_Penerima AS Nomor_KK_Penerima, FPBB.NIK_Penerima AS NIK_Penerima, DATE_FORMAT(FPBB.Tanggal_Lahir_Penerima, '%d/%m/%Y') AS Tanggal_Lahir_Penerima, FPBB.Tempat_Lahir_Penerima AS Tempat_Lahir_Penerima, FPBB.NIP_Penerima AS NIP_Penerima, FPBB.Jabatan_Penerima AS Jabatan_Penerima, FPBB.Instansi_Penerima AS Instansi_Penerima, FPBB.Kampung_Bencana AS Kampung_Bencana, FPBB.RT_Bencana AS RT_Bencana, FPBB.RW_Bencana AS RW_Bencana, FPBB.Desa_Kelurahan_Bencana AS Desa_Kelurahan_Bencana, FPBB.Kecamatan_Bencana AS Kecamatan_Bencana, FPBB.Kabupaten_Kota_Bencana AS Kabupaten_Kota_Bencana, FPBB.Kode_Pos_Bencana AS Kode_Pos_Bencana, FPBB.Jenis_Bencana AS Jenis_Bencana, FPBB.Nama_Pejabat_BPBD AS Nama_Pejabat_BPBD, FPBB.NIK_Pejabat_BPBD AS NIK_Pejabat_BPBD, FPBB.NIP_Pejabat_BPBD AS NIP_Pejabat_BPBD, FPBB.Jabatan_Pejabat_BPBD AS Jabatan_Pejabat_BPBD, DATE_FORMAT(FPBB.TANGGAL_KEJADIAN_BENCANA, '%d/%m/%Y') AS TANGGAL_KEJADIAN_BENCANA FROM form_penyaluran_barang_bencana AS FPBB
        WHERE FPBB.ID_FORM_PENYALURAN_BARANG_BENCANA =  '$ID_FORM_PENYALURAN_BARANG_BENCANA'");
		return $hasil;
		//return $hasil->result();
	}

	public function count_penyaluran_by_filter($ID_JENIS_BENCANA_LIST, $user_id)
	{
		$this->db->select('COUNT(*) as total');
		$this->db->from('form_penyaluran_barang_bencana'); // Pastikan nama tabel sesuai

		if ($ID_JENIS_BENCANA_LIST !== "Semua") {
			$this->db->where('Jenis_Bencana', $ID_JENIS_BENCANA_LIST); // Pastikan nama kolom sesuai
		}

		$query = $this->db->get();
		$result = $query->row();
		return $result->total;
	}

	function get_data_penyaluran_by_CODE_MD5($CODE_MD5)
	{
		$hsl = $this->db->query("SELECT * FROM form_penyaluran_barang_bencana WHERE CODE_MD5 ='$CODE_MD5'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_FORM_PENYALURAN_BARANG_BENCANA' => $data->ID_FORM_PENYALURAN_BARANG_BENCANA,
					'CODE_MD5' => $data->CODE_MD5,
					'PROGRESS_PENGAJUAN' => $data->PROGRESS_PENGAJUAN,
					'STATUS_PENGAJUAN' => $data->STATUS_PENGAJUAN
				);
			}
			return $hasil;
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	function simpan_data_penyaluran_bantuan(
		$CODE_MD5,
		$ID_JENIS_BENCANA,
		$NAMA_PEGAWAI_BPBD,
		$NIK_PEGAWAI_BPBD,
		$NIP_PEGAWAI_BPBD,
		$JABATAN_PEGAWAI_BPBD,
		$NAMA_PENERIMA,
		$NOMOR_KK_PENERIMA,
		$NIK_PENERIMA,
		$TANGGAL_LAHIR_PENERIMA,
		$TEMPAT_LAHIR_PENERIMA,
		$NIP_PENERIMA,
		$JABATAN_PENERIMA,
		$INSTANSI_PENERIMA,
		$ID_KABUPATEN_KOTA,
		$ID_KECAMATAN,
		$ID_DESA_KELURAHAN,
		$RW,
		$RT,
		$KAMPUNG,
		$KODE_POS,
		$TANGGAL_DOKUMEN_PENYALURAN,
		$TANGGAL_KEJADIAN_BENCANA,
		$TANGGAL_PEMBUATAN_PENYALURAN_JAM,
		$TANGGAL_PEMBUATAN_PENYALURAN_HARI,
		$TANGGAL_PEMBUATAN_PENYALURAN_BULAN,
		$TANGGAL_PEMBUATAN_PENYALURAN_TAHUN,
		$CREATE_BY_USER,
		$PROGRESS_PENYALURAN,
		$STATUS_PENYALURAN
	)
	{
		$hasil = $this->db->query("INSERT INTO form_penyaluran_barang_bencana (
			CODE_MD5,
			Tanggal_Pembuatan,
			Tanggal_Surat,
			Hari_Surat,
			Nama_Pejabat_BPBD,
			NIK_Pejabat_BPBD,
			NIP_Pejabat_BPBD,
			Jabatan_Pejabat_BPBD,
			Nama_Penerima,
			Nomor_KK_Penerima,
			NIK_Penerima,
			Tanggal_Lahir_Penerima,
			Tempat_Lahir_Penerima,
			NIP_Penerima,
			Jabatan_Penerima,
			Instansi_Penerima,
			Kampung_Bencana,
			RT_Bencana,
			RW_Bencana,
			Desa_Kelurahan_Bencana,
			Kecamatan_Bencana,
			Kabupaten_Kota_Bencana,
			Kode_Pos_Bencana,
			Jenis_Bencana,
			TANGGAL_KEJADIAN_BENCANA,
			TANGGAL_PEMBUATAN_PENGAJUAN_JAM,
			TANGGAL_PEMBUATAN_PENGAJUAN_HARI,
			TANGGAL_PEMBUATAN_PENGAJUAN_BULAN,
			TANGGAL_PEMBUATAN_PENGAJUAN_TAHUN,
			CREATE_BY_USER,
			PROGRESS_PENGAJUAN,
			STATUS_PENGAJUAN)
		VALUES(
			'$CODE_MD5',
			'$TANGGAL_PEMBUATAN_PENYALURAN_JAM',
			'$TANGGAL_DOKUMEN_PENYALURAN',
			'$TANGGAL_PEMBUATAN_PENYALURAN_HARI',
			'$NAMA_PEGAWAI_BPBD',
			'$NIK_PEGAWAI_BPBD',
			'$NIP_PEGAWAI_BPBD',
			'$JABATAN_PEGAWAI_BPBD',
			'$NAMA_PENERIMA',
			'$NOMOR_KK_PENERIMA',
			'$NIK_PENERIMA',
			'$TANGGAL_LAHIR_PENERIMA',
			'$TEMPAT_LAHIR_PENERIMA',
			'$NIP_PENERIMA',
			'$JABATAN_PENERIMA',
			'$INSTANSI_PENERIMA',
			'$KAMPUNG',
			'$RT',
			'$RW',
			'$ID_DESA_KELURAHAN',
			'$ID_KECAMATAN',
			'$ID_KABUPATEN_KOTA',
			'$KODE_POS',
			'$ID_JENIS_BENCANA',
			'$TANGGAL_KEJADIAN_BENCANA',
			'$TANGGAL_PEMBUATAN_PENYALURAN_JAM',
			'$TANGGAL_PEMBUATAN_PENYALURAN_HARI',
			'$TANGGAL_PEMBUATAN_PENYALURAN_BULAN',
			'$TANGGAL_PEMBUATAN_PENYALURAN_TAHUN',
			'$CREATE_BY_USER',
			'$PROGRESS_PENYALURAN',
			'$STATUS_PENYALURAN'
			)");

		return $hasil;
	}

	function get_data_penyaluran_baru($CODE_MD5)
	{
		$hsl = $this->db->query("SELECT * FROM form_penyaluran_barang_bencana WHERE CODE_MD5 = '$CODE_MD5'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'CODE_MD5' => $data->CODE_MD5
				);
			}
		} else {
			$hasil = "BELUM ADA PENYALURAN";
		}
		return $hasil;
	}
}