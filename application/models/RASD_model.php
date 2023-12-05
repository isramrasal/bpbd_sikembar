<?php
class RASD_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan data seluruh RASD
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD / function data_RASD
	//         2. 
	function RASD_list()
	{
		$hasil = $this->db->query("SELECT A.DOK_RASD, A.HASH_MD5_RASD, B.HASH_MD5_PROYEK,  B.NAMA_PROYEK, B.LOKASI, B.ID_PEGAWAI_PM, B.ID_PEGAWAI_SM, B.INISIAL, C.NAMA as PEGAWAI_PM, D.NAMA as PEGAWAI_SM, ID_RASD, B.STATUS_PROYEK FROM rasd as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=B.ID_PEGAWAI_PM 
		LEFT JOIN pegawai as D ON D.ID_PEGAWAI=B.ID_PEGAWAI_SM");
		return $hasil->result();
	}

	function RASD_list_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT A.DOK_RASD, A.ID_RASD, A.HASH_MD5_RASD, B.HASH_MD5_PROYEK,  B.NAMA_PROYEK, B.LOKASI, B.ID_PEGAWAI_PM, B.ID_PEGAWAI_SM, B.INISIAL, C.NAMA as PEGAWAI_PM, D.NAMA as PEGAWAI_SM, ID_RASD, B.STATUS_PROYEK FROM rasd as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=B.ID_PEGAWAI_PM 
		LEFT JOIN pegawai as D ON D.ID_PEGAWAI=B.ID_PEGAWAI_SM
		WHERE B.ID_PROYEK='$ID_PROYEK'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_RASD
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD / function view_RASD_form
	//         2. controller RASD / function view_only_RASD_form
	function RASD_list_by_id_RASD($ID_RASD)
	{
		$hasil = $this->db->query("SELECT A.DOK_RASD, A.HASH_MD5_RASD, B.HASH_MD5_PROYEK, B.NAMA_PROYEK, B.LOKASI, B.ID_PEGAWAI_PM, B.INISIAL, B.ID_PEGAWAI_SM, C.NAMA as PEGAWAI_PM, D.NAMA as PEGAWAI_SM, ID_RASD, B.STATUS_PROYEK FROM rasd as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=B.ID_PEGAWAI_PM 
		LEFT JOIN pegawai as D ON D.ID_PEGAWAI=B.ID_PEGAWAI_SM WHERE A.ID_RASD ='$ID_RASD'");
		return $hasil;
		//return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan HASH_MD5_RASD
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD_form / function index
	//         2. 
	function RASD_list_by_HASH_MD5_RASD($HASH_MD5_RASD)
	{
		$hasil = $this->db->query("SELECT A.DOK_RASD, A.HASH_MD5_RASD, A.ID_PROYEK, PSB.ID_PROYEK_SUB_PEKERJAAN, PSB.NAMA_SUB_PEKERJAAN, RF.NAMA_KATEGORI, RF.ID_RAB, RF.ID_RAB_FORM, B.NAMA_PROYEK, B.HASH_MD5_PROYEK, B.LOKASI, B.ID_PEGAWAI_PM, B.INISIAL, B.ID_PEGAWAI_SM, C.NAMA as PEGAWAI_PM, D.NAMA as PEGAWAI_SM, A.ID_RASD, B.STATUS_PROYEK FROM rasd as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK
        LEFT JOIN rab_form as RF ON A.ID_RAB_FORM =RF.ID_RAB_FORM
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=B.ID_PEGAWAI_PM 
		LEFT JOIN pegawai as D ON D.ID_PEGAWAI=B.ID_PEGAWAI_SM
        LEFT JOIN proyek_sub_pekerjaan as PSB ON PSB.ID_PROYEK_SUB_PEKERJAAN=A.ID_PROYEK_SUB_PEKERJAAN
        WHERE A.HASH_MD5_RASD = '$HASH_MD5_RASD'");
		return $hasil;
		//return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan tabel RASD barang berdasarkan INISIAL
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD / function (belum diisi)
	//         2. 
	function create_tabel_rasd_barang_by_proyek($INISIAL)
	{
		$cek = $this->db->query("SELECT * from '$INISIAL'");
	}

	//FUNGSI: Fungsi ini untuk menghapus data RASD berdasarkan ID_RASD
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD / function hapus_data
	//         2. controller RASD_form / function hapus_data
	function hapus_data_by_id_RASD($ID_RASD)
	{
		$hasil = $this->db->query("DELETE FROM rasd WHERE ID_RASD='$ID_RASD'");
		return $hasil;
	}

	function cek_nama_kategori_rabp($ID_PROYEK_SUB_PEKERJAAN, $NAMA_KATEGORI)
	{
		$hsl = $this->db->query("SELECT * FROM rasd_kategori WHERE NAMA_KATEGORI ='$NAMA_KATEGORI' AND ID_PROYEK_SUB_PEKERJAAN ='$ID_PROYEK_SUB_PEKERJAAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_PROYEK_SUB_PEKERJAAN' => $data->ID_PROYEK_SUB_PEKERJAAN,
					'NAMA_KATEGORI' => $data->NAMA_KATEGORI
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function simpan_data_nama_kategori($ID_PROYEK, $ID_RASD, $ID_PROYEK_SUB_PEKERJAAN, $NAMA_KATEGORI, $NOMINAL_ANGGARAN)
	{
		$hasil = $this->db->query("INSERT INTO rasd_kategori (ID_PROYEK, ID_RASD, ID_PROYEK_SUB_PEKERJAAN, NAMA_KATEGORI, NOMINAL_ANGGARAN )VALUES('$ID_PROYEK','$ID_RASD','$ID_PROYEK_SUB_PEKERJAAN','$NAMA_KATEGORI','$NOMINAL_ANGGARAN')");
		return $hasil;
	}

	function RABP_list_by_id_proyek_sub_pekerjaan($ID_PROYEK_SUB_PEKERJAAN){
		$hasil = $this->db->query("SELECT * FROM rasd_kategori where ID_PROYEK_SUB_PEKERJAAN  ='$ID_PROYEK_SUB_PEKERJAAN'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_RASD
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD / function get_data
	//         2. controller RASD / function hapus_data
	//		   3. controller RASD_form / function get_data
	//         4. controller RASD_form / function hapus_data
	function get_data_by_id_RASD($ID_RASD)
	{
		$hsl = $this->db->query("SELECT A.DOK_RASD, B.NAMA_PROYEK, B.LOKASI, B.ID_PEGAWAI_PM, B.ID_PEGAWAI_SM, C.NAMA as PEGAWAI_PM, D.NAMA as PEGAWAI_SM, ID_RASD, B.ID_PROYEK, B.STATUS_PROYEK FROM rasd as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=B.ID_PEGAWAI_PM 
		LEFT JOIN pegawai as D ON D.ID_PEGAWAI=B.ID_PEGAWAI_SM WHERE A.ID_RASD ='$ID_RASD'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RASD' => $data->ID_RASD,
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'STATUS_PROYEK' => $data->STATUS_PROYEK
				);
			}
		} else {
			$hasil = "BELUM ADA RASD";
		}
		return $hasil;
	}

	function get_data_by_HASH_MD_RASD($HASH_MD5_RASD)
	{
		$hsl = $this->db->query("SELECT A.DOK_RASD, B.NAMA_PROYEK, B.LOKASI, B.ID_PEGAWAI_PM, B.ID_PEGAWAI_SM, C.NAMA as PEGAWAI_PM, D.NAMA as PEGAWAI_SM, ID_RASD, B.ID_PROYEK, B.STATUS_PROYEK FROM rasd as A 
		LEFT JOIN proyek as B ON B.ID_PROYEK=A.ID_PROYEK
		LEFT JOIN pegawai as C ON C.ID_PEGAWAI=B.ID_PEGAWAI_PM 
		LEFT JOIN pegawai as D ON D.ID_PEGAWAI=B.ID_PEGAWAI_SM WHERE A.HASH_MD5_RASD ='$HASH_MD5_RASD'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RASD' => $data->ID_RASD,
					'ID_PROYEK' => $data->ID_PROYEK,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'STATUS_PROYEK' => $data->STATUS_PROYEK
				);
			}
		} else {
			$hasil = "BELUM ADA RASD";
		}
		return $hasil;
	}

	function get_list_rasd_by_id_proyek($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT RASD.ID_RASD, RASD.HASH_MD5_RASD, RASD.ID_PROYEK, RASD.ID_PROYEK_SUB_PEKERJAAN, RASD.DOK_RASD, PSB.NAMA_SUB_PEKERJAAN FROM rasd as RASD
		LEFT JOIN proyek_sub_pekerjaan as PSB ON RASD.ID_PROYEK_SUB_PEKERJAAN = PSB.ID_PROYEK_SUB_PEKERJAAN
		WHERE RASD.ID_PROYEK ='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			return $hsl->result();
		} else {
			return 'TIDAK ADA DATA';
		}
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan NAMA_PROYEK
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD / function (belum diisi)
	//         2. 
	function cek_proyek_by_admin($NAMA_PROYEK)
	{
		$hsl = $this->db->query("SELECT * FROM rasd WHERE ID_PROYEK ='$NAMA_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RASD' => $data->ID_RASD,
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD / function (belum diisi)
	//         2. 
	function get_id_rasd_by_id_proyek_FPB($ID_PROYEK){
		$hsl = $this->db->query("SELECT ID_RASD from rasd WHERE ID_PROYEK = '$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RASD' => $data->ID_RASD,
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk menampilkan data RASD berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD / function (belum diisi)
	//         2. 
	function get_id_rasd_by_id_proyek($ID_PROYEK){
		$hsl = $this->db->query("SELECT ID_RASD from rasd WHERE ID_PROYEK = '$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil =$data->ID_RASD;
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function get_id_rasd_by_id_rab_form($ID_RAB_FORM){
		$hsl = $this->db->query("SELECT ID_RASD from rasd WHERE ID_RAB_FORM = '$ID_RAB_FORM'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil =$data->ID_RASD;
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk mengupdate data RASD berdasarkan ID_RASD2
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD_form / function update_data
	//         2. 
	function update_data($ID_RASD2, $DOK_RASD2)
	{
		$hasil = $this->db->query("UPDATE rasd SET DOK_RASD='$DOK_RASD2' WHERE ID_RASD='$ID_RASD2'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data RASD berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD_form / function simpan_data
	//         2. controller RASD_form / function simpan_data_dari_barang_master
	function simpan_data_by_admin($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN)
	{
		$hasil = $this->db->query("INSERT INTO rasd (ID_PROYEK, ID_PROYEK_SUB_PEKERJAAN ) VALUES('$ID_PROYEK', '$ID_PROYEK_SUB_PEKERJAAN')");
		return $hasil;
	}

	function simpan_data_lokasi($NAMA_LOKASI_PENYERAHAN)
	{
		$hasil = $this->db->query("INSERT INTO proyek_lokasi_penyerahan(NAMA_LOKASI_PENYERAHAN) VALUES('$NAMA_LOKASI_PENYERAHAN')");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk mengeset HASH_MD5_RASD berdasarkan ID_PROYEK
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD_form / function (belum diisi)
	//         2. 
	function set_md5_id_rasd($ID_PROYEK)
	{
		$hsl = $this->db->query("SELECT ID_RASD FROM rasd WHERE ID_PROYEK='$ID_PROYEK'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RASD' => $data->ID_RASD
				);
			}
		} else {
			$hasil = "BELUM ADA RASD";
		}
		$ID_RASD = $hasil['ID_RASD'];
		$HASH_MD5_RASD = md5($ID_RASD);
		$this->db->query("UPDATE rasd SET HASH_MD5_RASD='$HASH_MD5_RASD' WHERE ID_RASD='$ID_RASD'");
		
	}

	function set_md5_id_rasd_by_ID_PROYEK_dan_ID_PROYEK_SUB_PEKERJAAN($ID_PROYEK, $ID_PROYEK_SUB_PEKERJAAN)
	{
		$hsl = $this->db->query("SELECT ID_RASD FROM rasd WHERE ID_PROYEK='$ID_PROYEK' AND ID_PROYEK_SUB_PEKERJAAN = '$ID_PROYEK_SUB_PEKERJAAN'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_RASD' => $data->ID_RASD
				);
			}
		} else {
			$hasil = "BELUM ADA RASD";
		}
		$ID_RASD = $hasil['ID_RASD'];
		$HASH_MD5_RASD = md5($ID_RASD);
		$this->db->query("UPDATE rasd SET HASH_MD5_RASD='$HASH_MD5_RASD' WHERE ID_RASD='$ID_RASD'");
		
	}

	//FUNGSI: Fungsi ini untuk menambahkan data RASD berdasarkan $ID_USER', '$KETERANGAN', '$WAKTU'
	//SUMBER TABEL: tabel rasd
	//DIPAKAI: 1. controller RASD_form / function logout
	//         2. controller RASD_form / function user_log
	//		   3. controller RASD / function user_log
	function user_log_rasd($ID_USER, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO user_log_rasd (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
	
}
