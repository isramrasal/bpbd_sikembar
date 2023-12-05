<?php
class Registrasi_user_model extends CI_Model{

	//FUNGSI: Fungsi ini untuk menampilkan seluruh data registrasi
	//SUMBER TABEL: tabel Pegawai
	//DIPAKAI: 1. controller Registrasi_user / function data_registrasi_user
	//         2. 
	function registrasi_user_list(){
		$hasil=$this->db->query("SELECT Pegawai.ID_PEGAWAI, Pegawai.NAMA, Pegawai.NIP, Pegawai.EMAIL, users.id
			FROM Pegawai
			LEFT JOIN users ON users.ID_PEGAWAI=Pegawai.ID_PEGAWAI
			WHERE users.id IS null");
		return $hasil->result();
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan data registrasi berdasarkan id
	//SUMBER TABEL: tabel Pegawai
	//DIPAKAI: 1. controller Registrasi_user / function get_data
	//         2. 
	function get_data_by_id($id){
		$hsl=$this->db->query("SELECT Pegawai.ID_PEGAWAI, Pegawai.NIP, Pegawai.NAMA, Pegawai.EMAIL
			FROM Pegawai
			LEFT JOIN users ON users.ID_PEGAWAI=Pegawai.ID_PEGAWAI WHERE Pegawai.ID_PEGAWAI='$id'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_PEGAWAI' => $data->ID_PEGAWAI,
					'NIP' => $data->NIP,
					'NAMA' => $data->NAMA,
					'EMAIL' => $data->EMAIL,
					);
			}
		}
		return $hasil;
	}
	
	//FUNGSI: Fungsi ini untuk menambahkan data registrasi berdasarkan ID_PEGAWAI
	//SUMBER TABEL: tabel users
	//DIPAKAI: 1. controller Registrasi_user / function update_data
	//         2. 
	function update_data($email, $password, $created, $ID_PEGAWAI){
		$hasil=$this->db->query("INSERT INTO users (id, ip_address, username, password, salt, email, activation_code, forgotten_password_code, forgotten_password_time, remember_code, created_on, last_login, active, ID_PEGAWAI, STATUS_DATA_PEGAWAI)  VALUES (NULL, '::1', '$email', '$password', NULL, '$email', NULL, NULL, NULL, NULL, '$created', NULL, '1', '$ID_PEGAWAI', 'pegawai_wme')");
		
		return $hasil;
	}
	
	//FUNGSI: Fungsi ini untuk menambahkan data registrasi berdasarkan ID_PEGAWAI
	//SUMBER TABEL: tabel users
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function log_registrasi_user($ID_PEGAWAI, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO ws_log_registrasi_user (ID_PEGAWAI, KETERANGAN, WAKTU) VALUES('$ID_PEGAWAI', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
	
	//FUNGSI: Fungsi ini untuk menambahkan data registrasi berdasarkan ID_PEGAWAI
	//SUMBER TABEL: tabel users
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function get_data_log_registrasi_user($ID_PEGAWAI){
		$hasil=$this->db->query("SELECT * from ws_log_registrasi_user where ID_PEGAWAI='$ID_PEGAWAI'");
		return $hasil->result();
	}
}