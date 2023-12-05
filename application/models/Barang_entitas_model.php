<?php
class Barang_entitas_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan seluruh data barang entitas
	//SUMBER TABEL: tabel barang_entitas
	//DIPAKAI: 1. controller Barang_entitas / function view_tambah
	//         2. controller Barang_entitas / function view_ubah
	//         3. controller Barang_entitas / function view
	function barang_entitas_list()
	{
		$hasil = $this->db->query("SELECT E.ID_BARANG_ENTITAS, M.ID_BARANG_MASTER, M.KODE_BARANG, S.ID_SPPB, S.NO_URUT_SPPB, P.ID_PO, E.KODE_BARANG_ENTITAS, E.TANGGAL_PEROLEHAN_JAM, E.TANGGAL_PEROLEHAN_HARI, E.TANGGAL_PEROLEHAN_BULAN, E.TANGGAL_PEROLEHAN_TAHUN, E.DOK_KARTU_GARANSI, E.DOK_SERTIFIKAT_PRODUK, E.DOK_LAINNYA, E.JENIS_KEPEMILIKAN, E.TANGGAL_MULAI_SEWA_JAM, E.TANGGAL_MULAI_SEWA_HARI, E.TANGGAL_MULAI_SEWA_BULAN, E.TANGGAL_MULAI_SEWA_TAHUN, E.TANGGAL_SELESAI_SEWA_JAM, E.TANGGAL_SELESAI_SEWA_HARI, E.TANGGAL_SELESAI_SEWA_BULAN, E.TANGGAL_SELESAI_SEWA_TAHUN
		FROM barang_entitas AS E
		LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER=E.ID_BARANG_MASTER
		LEFT JOIN sppb AS S ON S.ID_SPPB=E.ID_SPPB
		LEFT JOIN po AS P ON P.ID_PO=E.ID_SPPB");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang entitas berdasarkan ID_BARANG_ENTITAS
	//SUMBER TABEL: tabel barang_entitas
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function barang_entitas_list_by_id_barang_entitas($ID_BARANG_ENTITAS)
	{
		$hasil = $this->db->query("SELECT E.ID_BARANG_ENTITAS, M.ID_BARANG_MASTER, M.KODE_BARANG, S.ID_SPPB, S.NO_URUT_SPPB, P.ID_PO, E.KODE_BARANG_ENTITAS, E.TANGGAL_PEROLEHAN_JAM, E.TANGGAL_PEROLEHAN_HARI, E.TANGGAL_PEROLEHAN_BULAN, E.TANGGAL_PEROLEHAN_TAHUN, E.DOK_KARTU_GARANSI, E.DOK_SERTIFIKAT_PRODUK, E.DOK_LAINNYA, E.JENIS_KEPEMILIKAN, E.TANGGAL_MULAI_SEWA_JAM, E.TANGGAL_MULAI_SEWA_HARI, E.TANGGAL_MULAI_SEWA_BULAN, E.TANGGAL_MULAI_SEWA_TAHUN, E.TANGGAL_SELESAI_SEWA_JAM, E.TANGGAL_SELESAI_SEWA_HARI, E.TANGGAL_SELESAI_SEWA_BULAN, E.TANGGAL_SELESAI_SEWA_TAHUN
		FROM barang_entitas AS E
		LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER=E.ID_BARANG_MASTER
		LEFT JOIN sppb AS S ON S.ID_SPPB=E.ID_SPPB
		LEFT JOIN po AS P ON P.ID_PO=E.ID_SPPB
		WHERE E.ID_BARANG_ENTITAS = '$ID_BARANG_ENTITAS'");
		return $hasil;
		//return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang entitas berdasarkan ID_BARANG
	//SUMBER TABEL: tabel barang_entitas
	//DIPAKAI: 1. controller Barang_entitas / function list_entitas
	//         2. controller Barang_entitas / function list_barang_entitas
	function list_barang_entitas($ID_BARANG_MASTER)
	{
		$hasil = $this->db->query("SELECT BE.HASH_MD5_BARANG_ENTITAS, BE.ID_BARANG_ENTITAS, BE.KODE_BARANG_ENTITAS, BE.JUMLAH_BARANG, BE.TANGGAL_PEROLEHAN_HARI, BE.STATUS_KEPEMILIKAN, BE.JENIS_KEPEMILIKAN, BE.ID_PO, BE.ID_SPPB, BE.KONDISI, BE.POSISI, GB.NORMAL, G.NAMA_GUDANG, P.NAMA_PROYEK, PO.NO_URUT_PO, GD.NAMA_GUDANG, BE.TANGGAL_MULAI_SEWA_HARI, BE.TANGGAL_SELESAI_SEWA_HARI, SPB.NO_URUT_SPPB
		FROM barang_entitas AS BE
		LEFT JOIN barang_master AS BM ON BM.ID_BARANG_MASTER=BE.ID_BARANG_MASTER
        LEFT JOIN gudang_barang AS GB ON BE.ID_BARANG_ENTITAS=GB.ID_BARANG_ENTITAS
        LEFT JOIN gudang AS G ON G.ID_GUDANG=GB.ID_GUDANG
        LEFT JOIN proyek AS P ON G.ID_PROYEK=P.ID_PROYEK
        LEFT JOIN po as PO on PO.ID_PO=BE.ID_PO
        LEFT JOIN gudang as GD on GD.ID_GUDANG=GB.ID_GUDANG
        LEFT JOIN sppb as SPB on SPB.ID_SPPB=BE.ID_SPPB
        WHERE BM.ID_BARANG_MASTER = '$ID_BARANG_MASTER'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang entitas berdasarkan ID_BARANG_MASTER
	//SUMBER TABEL: tabel barang_entitas
	//DIPAKAI: 1. controller Barang_entitas / function data_barang_entitas_by_id_master
	//         2. 
	function barang_entitas_list_by_id_barang_master($ID_BARANG_MASTER)
	{
		$hasil = $this->db->query("SELECT E.ID_BARANG_ENTITAS, M.ID_BARANG_MASTER, M.KODE_BARANG, S.ID_SPPB, S.NO_URUT_SPPB, P.ID_PO, E.KODE_BARANG_ENTITAS, E.TANGGAL_PEROLEHAN_JAM, E.TANGGAL_PEROLEHAN_HARI, E.TANGGAL_PEROLEHAN_BULAN, E.TANGGAL_PEROLEHAN_TAHUN, E.DOK_KARTU_GARANSI, E.DOK_SERTIFIKAT_PRODUK, E.DOK_LAINNYA, E.JENIS_KEPEMILIKAN, E.TANGGAL_MULAI_SEWA_JAM, E.TANGGAL_MULAI_SEWA_HARI, E.TANGGAL_MULAI_SEWA_BULAN, E.TANGGAL_MULAI_SEWA_TAHUN, E.TANGGAL_SELESAI_SEWA_JAM, E.TANGGAL_SELESAI_SEWA_HARI, E.TANGGAL_SELESAI_SEWA_BULAN, E.TANGGAL_SELESAI_SEWA_TAHUN
		FROM barang_entitas AS E
		LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER=E.ID_BARANG_MASTER
		LEFT JOIN sppb AS S ON S.ID_SPPB=E.ID_SPPB
		LEFT JOIN po AS P ON P.ID_PO=E.ID_SPPB
		WHERE E.ID_BARANG_MASTER = '$ID_BARANG_MASTER'");
		// return $hasil;
		return $hasil->result();
	}

	// function barang_entitas_by_id

	// function barang_entitas_list_by_token($TOKEN){
	// 	$hasil=$this->db->query("SELECT * FROM barang_entitas WHERE TOKEN ='$TOKEN'");
	// 	return $hasil;
	// 	//return $hasil->result();
	// }

	// function hapus_data_by_token($TOKEN){
	// 	$hasil=$this->db->query("DELETE FROM barang_entitas WHERE TOKEN='$TOKEN'");
	// 	return $hasil;
	// }

	//FUNGSI: Fungsi ini untuk menghapus data barang entitas berdasarkan ID_BARANG_ENTITAS
	//SUMBER TABEL: tabel barang_entitas
	//DIPAKAI: 1. controller Barang_entitas / function hapus_data
	//         2. 
	function hapus_data_by_id_barang_entitas($ID_BARANG_ENTITAS)
	{
		$hasil = $this->db->query("DELETE FROM barang_entitas WHERE ID_BARANG_ENTITAS='$ID_BARANG_ENTITAS'");
		return $hasil;
	}

	function get_nomor_urut_by_ID_BARANG_MASTER($ID_BARANG_MASTER)
	{
		$hsl = $this->db->query("SELECT MAX(JUMLAH_COUNT) AS JUMLAH_COUNT FROM barang_entitas WHERE ID_BARANG_MASTER ='$ID_BARANG_MASTER'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'JUMLAH_COUNT' => $data->JUMLAH_COUNT
				);
			}
		} else {
			$hasil = "BELUM ADA BARANG ENTITAS";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang entitas berdasarkan ID_BARANG_ENTITAS
	//SUMBER TABEL: tabel barang_entitas
	//DIPAKAI: 1. controller Barang_entitas / function get_data
	//         2. controller Barang_entitas / function hapus_data
	//         3. controller Barang_entitas / function update_data
	//         4. controller Barang_entitas / function view_ubah
	//         5. controller Barang_entitas / function view
	function get_data_by_id_barang_entitas($ID_BARANG_ENTITAS)
	{
		$hsl = $this->db->query("SELECT E.ID_BARANG_ENTITAS, M.ID_BARANG_MASTER, M.KODE_BARANG, S.ID_SPPB, P.ID_PO, PY.ID_PROYEK, E.KODE_BARANG_ENTITAS, E.TANGGAL_PEROLEHAN_JAM, E.TANGGAL_PEROLEHAN_HARI, E.TANGGAL_PEROLEHAN_BULAN, E.TANGGAL_PEROLEHAN_TAHUN, E.DOK_KARTU_GARANSI, E.DOK_SERTIFIKAT_PRODUK, E.DOK_LAINNYA, E.STATUS_KEPEMILIKAN, E.JENIS_KEPEMILIKAN, E.POSISI, E.KONDISI, E.TANGGAL_MULAI_SEWA_JAM, E.TANGGAL_MULAI_SEWA_HARI, E.TANGGAL_MULAI_SEWA_BULAN, E.TANGGAL_MULAI_SEWA_TAHUN, E.TANGGAL_SELESAI_SEWA_JAM, E.TANGGAL_SELESAI_SEWA_HARI, E.TANGGAL_SELESAI_SEWA_BULAN, E.TANGGAL_SELESAI_SEWA_TAHUN, PY.NAMA_PROYEK, G.ID_GUDANG, G.NAMA_GUDANG, E.JUMLAH_BARANG, M.PERALATAN_PERLENGKAPAN
		FROM barang_entitas AS E
		LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER=E.ID_BARANG_MASTER
		LEFT JOIN sppb AS S ON S.ID_SPPB=E.ID_SPPB
		LEFT JOIN po AS P ON P.ID_PO=E.ID_PO
		LEFT JOIN proyek AS PY ON PY.ID_PROYEK=E.ID_PROYEK
		LEFT JOIN gudang AS G ON G.ID_GUDANG=E.ID_GUDANG
		WHERE E.ID_BARANG_ENTITAS = '$ID_BARANG_ENTITAS'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_ENTITAS' => $data->ID_BARANG_ENTITAS,
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PO' => $data->ID_PO,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_GUDANG' => $data->ID_GUDANG,
					'NAMA_GUDANG' => $data->NAMA_GUDANG,
					'KODE_BARANG' => $data->KODE_BARANG,
					'KODE_BARANG_ENTITAS' => $data->KODE_BARANG_ENTITAS,
					'JUMLAH_BARANG' => $data->JUMLAH_BARANG,
					'PERALATAN_PERLENGKAPAN' => $data->PERALATAN_PERLENGKAPAN,
					'TANGGAL_PEROLEHAN_JAM' => $data->TANGGAL_PEROLEHAN_JAM,
					'TANGGAL_PEROLEHAN_HARI' => $data->TANGGAL_PEROLEHAN_HARI,
					'TANGGAL_PEROLEHAN_BULAN' => $data->TANGGAL_PEROLEHAN_BULAN,
					'TANGGAL_PEROLEHAN_TAHUN' => $data->TANGGAL_PEROLEHAN_TAHUN,
					'DOK_KARTU_GARANSI' => $data->DOK_KARTU_GARANSI,
					'DOK_SERTIFIKAT_PRODUK' => $data->DOK_SERTIFIKAT_PRODUK,
					'DOK_LAINNYA' => $data->DOK_LAINNYA,
					'STATUS_KEPEMILIKAN' => $data->STATUS_KEPEMILIKAN,
					'JENIS_KEPEMILIKAN' => $data->JENIS_KEPEMILIKAN,
					'POSISI' => $data->POSISI,
					'KONDISI' => $data->KONDISI,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'TANGGAL_MULAI_SEWA_JAM' => $data->TANGGAL_MULAI_SEWA_JAM,
					'TANGGAL_MULAI_SEWA_HARI' => $data->TANGGAL_MULAI_SEWA_HARI,
					'TANGGAL_MULAI_SEWA_BULAN' => $data->TANGGAL_MULAI_SEWA_BULAN,
					'TANGGAL_MULAI_SEWA_TAHUN' => $data->TANGGAL_MULAI_SEWA_TAHUN,
					'TANGGAL_SELESAI_SEWA_JAM' => $data->TANGGAL_SELESAI_SEWA_JAM,
					'TANGGAL_SELESAI_SEWA_HARI' => $data->TANGGAL_SELESAI_SEWA_HARI,
					'TANGGAL_SELESAI_SEWA_BULAN' => $data->TANGGAL_SELESAI_SEWA_BULAN,
					'TANGGAL_SELESAI_SEWA_TAHUN' => $data->TANGGAL_SELESAI_SEWA_TAHUN
				);
			}
		} else {
			$hasil = "BELUM ADA BARANG ENTITAS";
		}
		return $hasil;
	}

	function get_data_by_HASH_MD5_BARANG_ENTITAS($HASH_MD5_BARANG_ENTITAS)
	{
		$hsl = $this->db->query("SELECT E.ID_BARANG_ENTITAS, M.ID_BARANG_MASTER, S.ID_SPPB, P.ID_PO, PY.ID_PROYEK, E.ID_GUDANG, E.KODE_BARANG_ENTITAS, E.TANGGAL_PEROLEHAN_JAM, E.TANGGAL_PEROLEHAN_HARI, E.TANGGAL_PEROLEHAN_BULAN, E.TANGGAL_PEROLEHAN_TAHUN, E.DOK_KARTU_GARANSI, E.DOK_SERTIFIKAT_PRODUK, E.DOK_LAINNYA, E.STATUS_KEPEMILIKAN,E.JENIS_KEPEMILIKAN, E.TANGGAL_MULAI_SEWA_JAM, E.TANGGAL_MULAI_SEWA_HARI, E.TANGGAL_MULAI_SEWA_BULAN, E.TANGGAL_MULAI_SEWA_TAHUN, E.TANGGAL_SELESAI_SEWA_JAM, E.TANGGAL_SELESAI_SEWA_HARI, E.TANGGAL_SELESAI_SEWA_BULAN,
		E.TANGGAL_SELESAI_SEWA_TAHUN,
		E. POSISI, E. KONDISI
		FROM barang_entitas AS E
		LEFT JOIN barang_master AS M ON M.ID_BARANG_MASTER=E.ID_BARANG_MASTER
		LEFT JOIN sppb AS S ON S.ID_SPPB=E.ID_SPPB
		LEFT JOIN po AS P ON P.ID_PO=E.ID_SPPB
		LEFT JOIN proyek AS PY ON PY.ID_PROYEK=E.ID_PROYEK
		WHERE E.HASH_MD5_BARANG_ENTITAS = '$HASH_MD5_BARANG_ENTITAS'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_ENTITAS' => $data->ID_BARANG_ENTITAS,
					'ID_BARANG_MASTER' => $data->ID_BARANG_MASTER,
					'ID_SPPB' => $data->ID_SPPB,
					'ID_PO' => $data->ID_PO,
					'ID_PROYEK' => $data->ID_PROYEK,
					'ID_GUDANG' => $data->ID_GUDANG,
					'KODE_BARANG_ENTITAS' => $data->KODE_BARANG_ENTITAS,
					'TANGGAL_PEROLEHAN_JAM' => $data->TANGGAL_PEROLEHAN_JAM,
					'TANGGAL_PEROLEHAN_HARI' => $data->TANGGAL_PEROLEHAN_HARI,
					'TANGGAL_PEROLEHAN_BULAN' => $data->TANGGAL_PEROLEHAN_BULAN,
					'TANGGAL_PEROLEHAN_TAHUN' => $data->TANGGAL_PEROLEHAN_TAHUN,
					'DOK_KARTU_GARANSI' => $data->DOK_KARTU_GARANSI,
					'DOK_SERTIFIKAT_PRODUK' => $data->DOK_SERTIFIKAT_PRODUK,
					'DOK_LAINNYA' => $data->DOK_LAINNYA,
					'STATUS_KEPEMILIKAN' => $data->STATUS_KEPEMILIKAN,
					'JENIS_KEPEMILIKAN' => $data->JENIS_KEPEMILIKAN,
					'TANGGAL_MULAI_SEWA_JAM' => $data->TANGGAL_MULAI_SEWA_JAM,
					'TANGGAL_MULAI_SEWA_HARI' => $data->TANGGAL_MULAI_SEWA_HARI,
					'TANGGAL_MULAI_SEWA_BULAN' => $data->TANGGAL_MULAI_SEWA_BULAN,
					'TANGGAL_MULAI_SEWA_TAHUN' => $data->TANGGAL_MULAI_SEWA_TAHUN,
					'TANGGAL_SELESAI_SEWA_JAM' => $data->TANGGAL_SELESAI_SEWA_JAM,
					'TANGGAL_SELESAI_SEWA_HARI' => $data->TANGGAL_SELESAI_SEWA_HARI,
					'TANGGAL_SELESAI_SEWA_BULAN' => $data->TANGGAL_SELESAI_SEWA_BULAN,
					'TANGGAL_SELESAI_SEWA_TAHUN' => $data->TANGGAL_SELESAI_SEWA_TAHUN,
					'POSISI' => $data->POSISI,
					'KONDISI' => $data->KONDISI
				);
			}
		} else {
			$hasil = "BELUM ADA BARANG ENTITAS";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang entitas berdasarkan KODE_BARANG_ENTITAS
	//SUMBER TABEL: tabel barang_entitas
	//DIPAKAI: 1. controller Barang_entitas / function simpan_data
	//         2. 
	function get_id_barang_entitas_by_kode_barang_entitas($KODE_BARANG_ENTITAS)
	{
		$hsl = $this->db->query("SELECT ID_BARANG_ENTITAS  FROM barang_entitas 
		
		WHERE KODE_BARANG_ENTITAS ='$KODE_BARANG_ENTITAS'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = $data->ID_BARANG_ENTITAS;
			}
		} else {
			$hasil = "BELUM ADA KODE BARANG ENTITAS";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang entitas berdasarkan KODE_BARANG_ENTITAS
	//SUMBER TABEL: tabel barang_entitas
	//DIPAKAI: 1. controller Barang_entitas / function simpan_data
	//         2. 
	function cek_kode_barang_entitas($KODE_BARANG_ENTITAS)
	{
		$hsl = $this->db->query("SELECT * FROM barang_entitas WHERE KODE_BARANG_ENTITAS = '$KODE_BARANG_ENTITAS'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_BARANG_ENTITAS' => $data->ID_BARANG_ENTITAS,
					'KODE_BARANG_ENTITAS' => $data->KODE_BARANG_ENTITAS
				);
			}
			return $hasil;
		} else {
			return 'BELUM ADA KODE BARANG ENTITAS';
		}
	}

	//FUNGSI: Fungsi ini untuk mengubah data barang entitas berdasarkan ID_BARANG_ENTITAS
	//SUMBER TABEL: tabel barang_entitas
	//DIPAKAI: 1. controller Barang_entitas / function update_data
	//         2. 
	function update_data(
		$ID_BARANG_ENTITAS,
		$ID_SPPB,
		$ID_PO,
		$JUMLAH_BARANG,
		$TANGGAL_PEROLEHAN_HARI,
		$STATUS_KEPEMILIKAN,
		$TANGGAL_MULAI_SEWA_HARI,
		$TANGGAL_SELESAI_SEWA_HARI,
		$POSISI,
		$KONDISI
	) {
		$hasil = $this->db->query("UPDATE barang_entitas SET 
			ID_SPPB = '$ID_SPPB',
			ID_PO = '$ID_PO',
			JUMLAH_BARANG = '$JUMLAH_BARANG',
			TANGGAL_PEROLEHAN_HARI = '$TANGGAL_PEROLEHAN_HARI',
			STATUS_KEPEMILIKAN = '$STATUS_KEPEMILIKAN',
			TANGGAL_MULAI_SEWA_HARI = '$TANGGAL_MULAI_SEWA_HARI',
			TANGGAL_SELESAI_SEWA_HARI = '$TANGGAL_SELESAI_SEWA_HARI',
			POSISI = '$POSISI',
			KONDISI = '$KONDISI'
			WHERE ID_BARANG_ENTITAS='$ID_BARANG_ENTITAS'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data barang entitas berdasarkan ID_BARANG_MASTER
	//SUMBER TABEL: tabel barang_entitas
	//DIPAKAI: 1. controller Barang_entitas / function simpan_data
	//         2. 
	function simpan_data(
		$ID_BARANG_MASTER,
		$ID_SPPB,
		$ID_PO,
		$ID_PROYEK,
		$ID_GUDANG,
		$KODE_BARANG_ENTITAS,
		$JUMLAH_BARANG,
		$JUMLAH_COUNT,
		$TANGGAL_PEROLEHAN_HARI,
		$STATUS_KEPEMILIKAN,
		$TANGGAL_MULAI_SEWA_HARI,
		$TANGGAL_SELESAI_SEWA_HARI,
		$POSISI,
		$KONDISI
	) {
		$HASH_MD5_BARANG_ENTITAS = md5($KODE_BARANG_ENTITAS);
		$hasil = $this->db->query("INSERT INTO barang_entitas (
			HASH_MD5_BARANG_ENTITAS,
			ID_BARANG_MASTER,
			ID_SPPB,
			ID_PO,
			ID_PROYEK,
			ID_GUDANG,
			KODE_BARANG_ENTITAS,
			JUMLAH_BARANG,
			JUMLAH_COUNT,
			TANGGAL_PEROLEHAN_HARI,
			STATUS_KEPEMILIKAN,
			TANGGAL_MULAI_SEWA_HARI,
			TANGGAL_SELESAI_SEWA_HARI,
			POSISI,
			KONDISI
			)
		VALUES(
			'$HASH_MD5_BARANG_ENTITAS',
			'$ID_BARANG_MASTER',
			'$ID_SPPB',
			'$ID_PO',
			'$ID_PROYEK',
			'$ID_GUDANG',
			'$KODE_BARANG_ENTITAS',
			'$JUMLAH_BARANG',
			'$JUMLAH_COUNT',
			'$TANGGAL_PEROLEHAN_HARI',
			'$STATUS_KEPEMILIKAN',
			'$TANGGAL_MULAI_SEWA_HARI',
			'$TANGGAL_SELESAI_SEWA_HARI',
			'$POSISI',
			'$KONDISI'
)");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data barang entitas berdasarkan ID_BARANG_MASTER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_entitas / function view_tambah
	//         2. 
	public function buat_kode($ID_BARANG_MASTER)
	{
		//get kode barang master
		$query_m = $this->db->query("SELECT KODE_BARANG AS kode_m FROM barang_master WHERE ID_BARANG_MASTER = '$ID_BARANG_MASTER'");
		//get kode barang entitas by id barang master
		$query_e = $this->db->query("SELECT RIGHT (KODE_BARANG_ENTITAS,4) AS kode_e
		FROM barang_entitas 
		WHERE ID_BARANG_MASTER = '$ID_BARANG_MASTER'  ORDER BY kode_e DESC LIMIT 1");     //cek dulu apakah ada sudah ada kode di tabel.    
		if ($query_e->num_rows() <> 0) {
			//jika kode ternyata sudah ada.      
			$data_e = $query_e->row();
			$kode_e = intval($data_e->kode_e) + 1;
		} else {
			//jika kode belum ada      
			$kode_e = 1;
		}
		$kodemax = str_pad($kode_e, 4, "0", STR_PAD_LEFT); // angka 4 menunjukkan jumlah digit angka 0
		$data_m = $query_m->row();
		$kodejadi = $data_m->kode_m . $kodemax;
		return $kodejadi;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data barang entitas berdasarkan ID_USER
	//SUMBER TABEL: tabel barang_master
	//DIPAKAI: 1. controller Barang_entitas / function logout
	//         2. controller Barang_entitas / function user_log
	function user_log_barang_entitas($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_barang_entitas (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
