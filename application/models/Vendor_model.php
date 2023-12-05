<?php
class Vendor_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan seluruh data vendor
	//SUMBER TABEL: tabel vendor
	//DIPAKAI: 1. controller Vendor / function data_vendor
	//         2. controller Vendor / function profil_vendor
	function vendor_list() //112023
	{
		$hasil = $this->db->query("SELECT * FROM vendor ORDER BY NAMA_VENDOR ASC");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data vendor berdasarkan ID_VENDOR
	//SUMBER TABEL: tabel vendor
	//DIPAKAI: 1. controller Vendor / function data_vendor
	//         2. controller Vendor / function profil_vendor
	function vendor_list_by_id_vendor($ID_VENDOR)
	{
		$hasil = $this->db->query("SELECT * FROM vendor WHERE ID_VENDOR ='$ID_VENDOR'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data vendor berdasarkan HASH_MD5_VENDOR
	//SUMBER TABEL: tabel vendor
	//DIPAKAI: 1. controller Vendor / function profil_vendor
	//         2. 
	function vendor_list_by_HASH_MD5_VENDOR_result($HASH_MD5_VENDOR)
	{
		$hasil = $this->db->query("SELECT * FROM vendor WHERE HASH_MD5_VENDOR ='$HASH_MD5_VENDOR'");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan data vendor berdasarkan HASH_MD5_VENDOR
	//SUMBER TABEL: tabel vendor
	//DIPAKAI: 1. controller Vendor / function profil_vendor
	//         2. 
	function vendor_list_by_HASH_MD5_VENDOR($HASH_MD5_VENDOR)
	{
		$hasil = $this->db->query("SELECT * FROM vendor WHERE HASH_MD5_VENDOR ='$HASH_MD5_VENDOR'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menghapus data vendor berdasarkan ID_VENDOR
	//SUMBER TABEL: tabel vendor_file
	//DIPAKAI: 1. controller Vendor / function hapus_data
	//         2. 
	function hapus_data_by_id_vendor($ID_VENDOR)
	{
		//Hapus data di tabel Vendor, akan menghapus data di tabel Vendor File dan hapus file di folder asset

		$hsl = $this->db->query("SELECT DOK_FILE FROM vendor_file WHERE ID_VENDOR='$ID_VENDOR'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil4 = array(
					'DOK_FILE' => $data->DOK_FILE
				);
				if(file_exists($file='./assets/upload_vendor_file/'.$data->DOK_FILE)){
					unlink($file);
				}
			}
		} else {
			$hasil4 = "BELUM ADA PROYEK";
		}

		$hasil5 = $this->db->query("DELETE FROM vendor_file WHERE ID_VENDOR='$ID_VENDOR'");
		$hsl = $this->db->query("SELECT * FROM users WHERE ID_VENDOR='$ID_VENDOR'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil4 = array(
					'ID_USER' => $data->id
				);
			}
		} else {
			$hasil4 = "BELUM ADA PROYEK";
		}
		$ID_USER = $hasil4['ID_USER'];
		$this->db->query("DELETE FROM users_groups WHERE user_id ='$ID_USER'");
		$this->db->query("DELETE FROM users WHERE id ='$ID_USER'");

		$hasil = $this->db->query("DELETE FROM vendor WHERE ID_VENDOR='$ID_VENDOR'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data vendor berdasarkan HASH_MD5_VENDOR
	//SUMBER TABEL: tabel vendor
	//DIPAKAI: 1. controller Vendor / function proses_upload_file
	//         2. 
	function get_id_vendor_by_HASH_MD5_VENDOR($HASH_MD5_VENDOR){
		$hsl=$this->db->query("SELECT * FROM vendor WHERE HASH_MD5_VENDOR='$HASH_MD5_VENDOR'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_VENDOR' => $data->ID_VENDOR
					);
			}
		}
		else
		{
			$hasil = "BELUM ADA DATA";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data vendor berdasarkan ID_VENDOR
	//SUMBER TABEL: tabel vendor
	//DIPAKAI: 1. controller Vendor / function get_data
	//         2. controller Vendor / function hapus_data
	//         3. controller Vendor / function update_data
	function get_data_by_id_vendor($ID_VENDOR) //112023
	{
		$hsl = $this->db->query("SELECT * FROM vendor WHERE ID_VENDOR='$ID_VENDOR'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_VENDOR' => $data->ID_VENDOR,
					'NAMA_VENDOR' => $data->NAMA_VENDOR,
					'ALAMAT_VENDOR' => $data->ALAMAT_VENDOR,
					'NO_TELP_VENDOR' => $data->NO_TELP_VENDOR,
					'NAMA_PIC_VENDOR' => $data->NAMA_PIC_VENDOR,
					'NO_HP_PIC_VENDOR' => $data->NO_HP_PIC_VENDOR,
					'EMAIL_PIC_VENDOR' => $data->EMAIL_PIC_VENDOR,
					'NO_HP_PIC_VENDOR' => $data->NO_HP_PIC_VENDOR,
					'EMAIL_VENDOR' => $data->EMAIL_VENDOR,
					'STATUS_VENDOR' => $data->STATUS_VENDOR
				);
			}
		} else {
			$hasil = "BELUM ADA VENDOR";
		}
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menampilkan data vendor berdasarkan ID_VENDOR
	//SUMBER TABEL: tabel vendor
	//DIPAKAI: 1. controller Vendor / function simpan_data
	//         2. controller Vendor / function update_data
	function cek_nama_vendor_by_admin($NAMA_VENDOR)
	{
		$hsl = $this->db->query("SELECT * FROM vendor WHERE NAMA_VENDOR ='$NAMA_VENDOR'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_VENDOR' => $data->ID_VENDOR,
					'NAMA_VENDOR' => $data->NAMA_VENDOR
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk mengubah data vendor berdasarkan ID_VENDOR2
	//SUMBER TABEL: tabel vendor
	//DIPAKAI: 1. controller Vendor / function update_data
	//         2. 
	function update_data($ID_VENDOR2, $NAMA_VENDOR2, $ALAMAT_VENDOR2, $NO_TELP_VENDOR2, $NAMA_PIC_VENDOR2, $NO_HP_PIC_VENDOR2, $EMAIL_PIC_VENDOR2, $EMAIL_VENDOR2, $STATUS_VENDOR2)
	{
		$hasil = $this->db->query("UPDATE vendor SET NAMA_VENDOR='$NAMA_VENDOR2', 
		ALAMAT_VENDOR='$ALAMAT_VENDOR2', 
		NO_TELP_VENDOR='$NO_TELP_VENDOR2', 
		NAMA_PIC_VENDOR='$NAMA_PIC_VENDOR2', 
		NO_HP_PIC_VENDOR='$NO_HP_PIC_VENDOR2', 
		EMAIL_PIC_VENDOR='$EMAIL_PIC_VENDOR2', 
		EMAIL_VENDOR='$EMAIL_VENDOR2',
		STATUS_VENDOR='$STATUS_VENDOR2' 
		WHERE ID_VENDOR='$ID_VENDOR2'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data vendor berdasarkan NAMA_VENDOR
	//SUMBER TABEL: tabel vendor
	//DIPAKAI: 1. controller Vendor / function simpan_data
	//         2. 
	function simpan_data_by_admin($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $NO_HP_PIC_VENDOR, $EMAIL_PIC_VENDOR, $EMAIL_VENDOR, $STATUS_VENDOR){
		$hasil=$this->db->query("INSERT INTO vendor (NAMA_VENDOR, ALAMAT_VENDOR, NO_TELP_VENDOR, NAMA_PIC_VENDOR, NO_HP_PIC_VENDOR, EMAIL_PIC_VENDOR, EMAIL_VENDOR, STATUS_VENDOR )VALUES('$NAMA_VENDOR', '$ALAMAT_VENDOR', '$NO_TELP_VENDOR', '$NAMA_PIC_VENDOR', '$NO_HP_PIC_VENDOR', '$EMAIL_PIC_VENDOR', '$EMAIL_VENDOR', '$STATUS_VENDOR')");
		return $hasil;
	}

	function simpan_data_dari_rfq_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR){
		$hasil=$this->db->query("INSERT INTO vendor (NAMA_VENDOR, ALAMAT_VENDOR, EMAIL_VENDOR, NO_TELP_VENDOR, NAMA_PIC_VENDOR, EMAIL_PIC_VENDOR, NO_HP_PIC_VENDOR) VALUES ('$NAMA_VENDOR', '$ALAMAT_VENDOR', '$EMAIL_VENDOR', '$NO_TELP_VENDOR', '$NAMA_PIC_VENDOR', '$EMAIL_PIC_VENDOR', '$NO_HP_PIC_VENDOR')");
		return $hasil;
	}

	function simpan_data_dari_po_form($NAMA_VENDOR, $ALAMAT_VENDOR, $EMAIL_VENDOR, $NO_TELP_VENDOR, $NAMA_PIC_VENDOR, $EMAIL_PIC_VENDOR, $NO_HP_PIC_VENDOR){
		$hasil=$this->db->query("INSERT INTO vendor (NAMA_VENDOR, ALAMAT_VENDOR, EMAIL_VENDOR, NO_TELP_VENDOR, NAMA_PIC_VENDOR, EMAIL_PIC_VENDOR, NO_HP_PIC_VENDOR) VALUES ('$NAMA_VENDOR', '$ALAMAT_VENDOR', '$EMAIL_VENDOR', '$NO_TELP_VENDOR', '$NAMA_PIC_VENDOR', '$EMAIL_PIC_VENDOR', '$NO_HP_PIC_VENDOR')");
		return $hasil;
	}

	function simpan_data_dari_spp_form($NAMA_VENDOR, $ALAMAT_VENDOR, $NO_TELP_VENDOR){
		$hasil=$this->db->query("INSERT INTO vendor (NAMA_VENDOR, ALAMAT_VENDOR, NO_TELP_VENDOR, STATUS_VENDOR) VALUES ('$NAMA_VENDOR', '$ALAMAT_VENDOR', '$NO_TELP_VENDOR', 'AKTIF')");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data vendor berdasarkan ID_VENDOR
	//SUMBER TABEL: tabel vendor
	//DIPAKAI: 1. controller Vendor / function simpan_data
	//         2. 
	function set_md5_id_vendor($NAMA_VENDOR,$ALAMAT_VENDOR,$NO_TELP_VENDOR,$NAMA_PIC_VENDOR,$NO_HP_PIC_VENDOR,$EMAIL_PIC_VENDOR,$EMAIL_VENDOR)
	{
		$hsl = $this->db->query("SELECT ID_VENDOR FROM vendor WHERE NAMA_VENDOR='$NAMA_VENDOR' AND
		ALAMAT_VENDOR='$ALAMAT_VENDOR' AND
		NO_TELP_VENDOR='$NO_TELP_VENDOR' AND
		NAMA_PIC_VENDOR='$NAMA_PIC_VENDOR' AND
		NO_HP_PIC_VENDOR='$NO_HP_PIC_VENDOR' AND
		EMAIL_PIC_VENDOR='$EMAIL_PIC_VENDOR' AND
		EMAIL_VENDOR='$EMAIL_VENDOR'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_VENDOR' => $data->ID_VENDOR
				);
			}
		} else {
			$hasil = "BELUM ADA VENDOR";
		}
		$ID_VENDOR = $hasil['ID_VENDOR'];
		$HASH_MD5_VENDOR = md5($ID_VENDOR);
		$this->db->query("UPDATE vendor SET HASH_MD5_VENDOR='$HASH_MD5_VENDOR' WHERE ID_VENDOR='$ID_VENDOR'");
		
	}

	function set_md5_id_vendor_dari_rfq_form($NAMA_VENDOR,$ALAMAT_VENDOR,$NO_TELP_VENDOR)
	{
		$hsl = $this->db->query("SELECT ID_VENDOR FROM vendor WHERE NAMA_VENDOR='$NAMA_VENDOR' AND
		ALAMAT_VENDOR='$ALAMAT_VENDOR' AND
		NO_TELP_VENDOR='$NO_TELP_VENDOR'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_VENDOR' => $data->ID_VENDOR
				);
			}
		} else {
			$hasil = "BELUM ADA VENDOR";
		}
		$ID_VENDOR = $hasil['ID_VENDOR'];
		$HASH_MD5_VENDOR = md5($ID_VENDOR);
		$this->db->query("UPDATE vendor SET HASH_MD5_VENDOR='$HASH_MD5_VENDOR', STATUS_VENDOR='Aktif' WHERE ID_VENDOR='$ID_VENDOR'");
		
	}

	function set_md5_id_vendor_dari_po_form($NAMA_VENDOR,$ALAMAT_VENDOR,$NO_TELP_VENDOR)
	{
		$hsl = $this->db->query("SELECT ID_VENDOR FROM vendor WHERE NAMA_VENDOR='$NAMA_VENDOR' AND
		ALAMAT_VENDOR='$ALAMAT_VENDOR' AND
		NO_TELP_VENDOR='$NO_TELP_VENDOR'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_VENDOR' => $data->ID_VENDOR
				);
			}
		} else {
			$hasil = "BELUM ADA VENDOR";
		}
		$ID_VENDOR = $hasil['ID_VENDOR'];
		$HASH_MD5_VENDOR = md5($ID_VENDOR);
		$this->db->query("UPDATE vendor SET HASH_MD5_VENDOR='$HASH_MD5_VENDOR', STATUS_VENDOR='Aktif' WHERE ID_VENDOR='$ID_VENDOR'");
		
	}

	function set_md5_id_vendor_dari_spp_form($NAMA_VENDOR,$ALAMAT_VENDOR,$NO_TELP_VENDOR)
	{
		$hsl = $this->db->query("SELECT ID_VENDOR FROM vendor WHERE NAMA_VENDOR='$NAMA_VENDOR' AND
		ALAMAT_VENDOR='$ALAMAT_VENDOR' AND
		NO_TELP_VENDOR='$NO_TELP_VENDOR'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_VENDOR' => $data->ID_VENDOR
				);
			}
		} else {
			$hasil = "BELUM ADA VENDOR";
		}
		$ID_VENDOR = $hasil['ID_VENDOR'];
		$HASH_MD5_VENDOR = md5($ID_VENDOR);
		$this->db->query("UPDATE vendor SET HASH_MD5_VENDOR='$HASH_MD5_VENDOR', STATUS_VENDOR='Aktif' WHERE ID_VENDOR='$ID_VENDOR'");
		
	}

	function cek_username_users($USERNAME){
		$hsl=$this->db->query("SELECT * FROM users WHERE username ='$USERNAME'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'id' => $data->id
					);
			}
			return $hasil;
		}
		else
		{
			return 'Data belum ada';
		}
	}

	function register_users($USERNAME, $PASSWORD_UTAMA, $EMAIL, $CREATED_ON, $EXPIRED, $ID_VENDOR, $STATUS_DATA_PEGAWAI){
		$hasil=$this->db->query("INSERT INTO users (id, ip_address, username, password, salt, email, activation_code, forgotten_password_code, forgotten_password_time, remember_code, created_on, last_login, active, expired, ID_PEGAWAI, ID_VENDOR, STATUS_DATA_PEGAWAI)  VALUES (NULL, '::1', '$USERNAME', '$PASSWORD_UTAMA', NULL, '$EMAIL', NULL, NULL, NULL, NULL, '$CREATED_ON', NULL, '1', '$EXPIRED', NULL, '$ID_VENDOR','$STATUS_DATA_PEGAWAI')");
		
		return $hasil;
	}

	function update_password_users($USERNAME, $PASSWORD_UTAMA, $EXPIRED){
		$hasil=$this->db->query("UPDATE users SET password='$PASSWORD_UTAMA' , expired='$EXPIRED' WHERE username='$USERNAME'");
		
		return $hasil;
	}

	function user_log_vendor($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_vendor (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
}
