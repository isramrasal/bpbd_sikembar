<?php
class Organisasi_model extends CI_Model
{
	//FUNGSI: Fungsi ini untuk menampilkan seluruh data organisasi
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function organisasi_list()
	{
		$hasil = $this->db->query("SELECT * FROM pegawai");
		return $hasil->result();
	}

	function organisasi_list_by_id_proyek($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT * FROM pegawai where ID_PROYEK_PEGAWAI='$ID_PROYEK'");
		return $hasil->result();
	}

	function organisasi_list_by_id_proyek_logistik($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT * FROM pegawai where ID_PROYEK_PEGAWAI='$ID_PROYEK' AND ID_DEPARTEMEN_PEGAWAI=13");
		return $hasil->result();
	}

	function groups_list()
	{
		$hasil = $this->db->query("SELECT * FROM groups");
		return $hasil->result();
	}

	function groups_list_by_lokasi($LOKASI)
	{
		$hasil = $this->db->query("SELECT * FROM groups where lokasi='$LOKASI' order by description ASC");
		return $hasil->result();
	}

	function groups_list_by_id_jabatan($id_jabatan)
	{
		$hasil = $this->db->query("SELECT * FROM groups where id='$id_jabatan'");
		return $hasil->result();
	}

	function pegawai_list_by_id_proyek_logistik($ID_PROYEK)
	{
		$hasil = $this->db->query("SELECT P.ID_PEGAWAI, P.NIP, P.NAMA, P.EMAIL, P.NO_HP_1, P.JABATAN_PEGAWAI, R.NAMA_PROYEK, Q.NAMA_DEPARTEMEN, P.ID_JABATAN_PEGAWAI, G.description as NAMA_JABATAN FROM pegawai as P LEFT JOIN proyek as R ON P.ID_PROYEK_PEGAWAI=R.ID_PROYEK LEFT JOIN departemen as Q ON P.ID_DEPARTEMEN_PEGAWAI=Q.ID_DEPARTEMEN LEFT JOIN groups as G on G.id = P.ID_JABATAN_PEGAWAI where P.ID_PROYEK_PEGAWAI='$ID_PROYEK' and (G.id='14' or G.id='42')");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan seluruh data organisasi
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller Organisasi / function data_pegawai
	//         2. 
	function organisasi_list_table_view()
	{
		$hasil = $this->db->query("SELECT P.ID_PEGAWAI, P.NIP, P.NAMA, P.EMAIL, P.NO_HP_1, R.NAMA_PROYEK, U.username, U.last_login, G.description
		FROM pegawai as P 
		LEFT JOIN proyek as R ON P.ID_PROYEK_PEGAWAI = R.ID_PROYEK 
		LEFT JOIN users as U on U.ID_PEGAWAI = P.ID_PEGAWAI
		LEFT JOIN users_groups as UG on UG.user_id = U.id
		LEFT JOIN groups as G on G.id = UG.group_id");
		return $hasil->result();
	}

	//FUNGSI: Fungsi ini untuk menampilkan seluruh data organisasi list cv
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function organisasi_list_cv(){
		$hasil=$this->db->query("SELECT pegawai.ID_PEGAWAI, pegawai.NIP, pegawai.NAMA, pegawai.NIK, pegawai.TEMPAT_LAHIR, pegawai.TANGGAL_LAHIR, pegawai.NO_HP_1, pegawai.ID_STATUS_PEGAWAI, ws_status_pegawai.NAMA_STATUS_PEGAWAI, pegawai.ID_JABATAN_PEGAWAI, ws_jabatan.NAMA_JABATAN, pegawai.ID_DEPARTEMEN, ws_departemen.NAMA_DEPARTEMEN, TIMESTAMPDIFF(YEAR, TANGGAL_LAHIR, CURDATE()) AS UMUR, pegawai.TANGGAL_STATUS_KONTRAK, pegawai.TANGGAL_STATUS_TETAP, TIMESTAMPDIFF(MONTH, TANGGAL_STATUS_KONTRAK, CURDATE()) AS LAMA_BEKERJA_KONTRAK, TIMESTAMPDIFF(MONTH, TANGGAL_STATUS_TETAP, CURDATE()) AS LAMA_BEKERJA_TETAP FROM pegawai
		LEFT JOIN ws_status_pegawai ON ws_status_pegawai.ID_STATUS_PEGAWAI=pegawai.ID_STATUS_PEGAWAI
		LEFT JOIN ws_jabatan ON ws_jabatan.ID_JABATAN_PEGAWAI=pegawai.ID_JABATAN_PEGAWAI
		LEFT JOIN ws_departemen ON ws_departemen.ID_DEPARTEMEN=pegawai.ID_DEPARTEMEN");
		return $hasil;
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan data organisasi berdasarkan ID_PEGAWAI
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller Organisasi / function data_pegawai
	//         2. 
	function organisasi_list_by_id_pegawai($ID_PEGAWAI){
		$hasil = $this->db->query("SELECT ID_PEGAWAI, NIP, NIK, NO_KARTU_KELUARGA, NAMA, EMAIL, NO_HP_1,NO_HP_2, JENIS_KELAMIN, TEMPAT_LAHIR, TANGGAL_LAHIR, AGAMA, STATUS_PERNIKAHAN, NPWP, PASPOR, BPJS_KESEHATAN, BPJS_TK, TIMESTAMPDIFF(YEAR, TANGGAL_LAHIR, CURDATE()) AS UMUR, TIMESTAMPDIFF(MONTH, TANGGAL_STATUS_KONTRAK, CURDATE()) AS LAMA_BEKERJA_KONTRAK, TIMESTAMPDIFF(MONTH, TANGGAL_STATUS_TETAP, CURDATE()) AS LAMA_BEKERJA_TETAP  FROM pegawai WHERE ID_PEGAWAI ='$ID_PEGAWAI'");
		return $hasil->result();
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan data organisasi berdasarkan id
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller Organisasi / function get_data
	//         2. controller Organisasi / function update_data
	//         3. controller Organisasi / function hapus_data
	function get_data_by_id($id){
		$hsl=$this->db->query("SELECT P.ID_PEGAWAI, P.NIP, P.NAMA, P.EMAIL, P.NO_HP_1, P.ID_PROYEK_PEGAWAI, P.ID_DEPARTEMEN_PEGAWAI, ID_JABATAN_PEGAWAI, R.NAMA_PROYEK, Q.NAMA_DEPARTEMEN, U.username, U.id AS ID_USER  FROM pegawai as P
		LEFT JOIN proyek as R ON P.ID_PROYEK_PEGAWAI=R.ID_PROYEK
		LEFT JOIN departemen as Q ON P.ID_DEPARTEMEN_PEGAWAI=Q.ID_DEPARTEMEN
        LEFT JOIN users as U ON U.ID_PEGAWAI=P.ID_PEGAWAI
        WHERE P.ID_pegawai='$id'
		");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_PEGAWAI' => $data->ID_PEGAWAI,
					'ID_USER' => $data->ID_USER,
					'NIP' => $data->NIP,
					'NAMA' => $data->NAMA,
					'EMAIL' => $data->EMAIL,
					'NO_HP_1' => $data->NO_HP_1,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					'ID_PROYEK_PEGAWAI' => $data->ID_PROYEK_PEGAWAI,
					'ID_DEPARTEMEN_PEGAWAI' => $data->ID_DEPARTEMEN_PEGAWAI,
					'NAMA_DEPARTEMEN' => $data->NAMA_DEPARTEMEN,
					'ID_JABATAN_PEGAWAI' => $data->ID_JABATAN_PEGAWAI
					);
			}
		}
		return $hasil;
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan data organisasi berdasarkan id
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function get_data_by_id_cont_nip($id){
		$hsl=$this->db->query("SELECT pegawai.ID_PEGAWAI, pegawai.NIP, pegawai.NAMA, pegawai.NIK, pegawai.ID_STATUS_PEGAWAI, pegawai.TANGGAL_STATUS_KONTRAK, pegawai.TANGGAL_STATUS_TETAP, ws_status_pegawai.NAMA_STATUS_PEGAWAI, pegawai.ID_JABATAN_PEGAWAI, ws_jabatan.NAMA_JABATAN, pegawai.ID_DEPARTEMEN, ws_departemen.NAMA_DEPARTEMEN FROM pegawai LEFT JOIN ws_status_pegawai ON ws_status_pegawai.ID_STATUS_PEGAWAI=pegawai.ID_STATUS_PEGAWAI LEFT JOIN ws_jabatan ON ws_jabatan.ID_JABATAN_PEGAWAI=pegawai.ID_JABATAN_PEGAWAI LEFT JOIN ws_departemen ON ws_departemen.ID_DEPARTEMEN=pegawai.ID_DEPARTEMEN WHERE pegawai.ID_PEGAWAI='$id'");
		
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_PEGAWAI' => $data->ID_PEGAWAI,
					'NIP' => $data->NIP,
					'NIK' => $data->NIK,
					'NAMA' => $data->NAMA,
					'ID_STATUS_PEGAWAI' => $data->ID_STATUS_PEGAWAI,
					'NAMA_STATUS_PEGAWAI' => $data->NAMA_STATUS_PEGAWAI,
					'ID_JABATAN_PEGAWAI' => $data->ID_JABATAN_PEGAWAI,
					'NAMA_JABATAN' => $data->NAMA_JABATAN,
					'ID_DEPARTEMEN' => $data->ID_DEPARTEMEN,
					'NAMA_DEPARTEMEN' => $data->NAMA_DEPARTEMEN,
					'TANGGAL_STATUS_KONTRAK' => $data->TANGGAL_STATUS_KONTRAK,
					'TANGGAL_STATUS_TETAP' => $data->TANGGAL_STATUS_TETAP
					);
			}
		}
		return $hasil;
	}
	
	//FUNGSI: Fungsi ini untuk menambahkan data organisasi berdasarkan NIP
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function simpan_data_buat_nip($NIP, $NIK, $NAMA, $ID_STATUS_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN, $tanggal_status_kontrak, $tanggal_status_tetap){
		$hasil=$this->db->query("INSERT INTO pegawai (NIP, NIK, NAMA, ID_STATUS_PEGAWAI, ID_JABATAN_PEGAWAI, ID_DEPARTEMEN, TANGGAL_STATUS_KONTRAK, TANGGAL_STATUS_TETAP) VALUES('$NIP','$NIK','$NAMA','$ID_STATUS_PEGAWAI','$ID_JABATAN_PEGAWAI','$ID_DEPARTEMEN', '$tanggal_status_kontrak', '$tanggal_status_tetap')");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data organisasi berdasarkan NIP
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller Organisasi / function simpan_data
	//         2. 
	function simpan_data($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI)
	{
		$hasil = $this->db->query("INSERT INTO pegawai (NIP, NAMA, EMAIL,  NO_HP_1, ID_PROYEK_PEGAWAI, ID_JABATAN_PEGAWAI) VALUES ('$NIP', '$NAMA','$EMAIL', '$NO_HP_1', '$ID_PROYEK_PEGAWAI', '$ID_JABATAN_PEGAWAI')");
		return $hasil;
	}

	function simpan_data_PIC_proyek($NIP, $NAMA, $EMAIL,  $NO_HP_1, $ID_PROYEK_PEGAWAI, $ID_JABATAN_PEGAWAI, $ID_DEPARTEMEN_PEGAWAI)
	{
		$hasil = $this->db->query("INSERT INTO pegawai (NIP, NAMA, EMAIL,  NO_HP_1, ID_PROYEK_PEGAWAI, ID_JABATAN_PEGAWAI , ID_DEPARTEMEN_PEGAWAI) VALUES ('$NIP', '$NAMA','$EMAIL', '$NO_HP_1', '$ID_PROYEK_PEGAWAI', '$ID_JABATAN_PEGAWAI', '$ID_DEPARTEMEN_PEGAWAI')");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data user berdasarkan ID_PEGAWAI
	//SUMBER TABEL: tabel users
	//DIPAKAI: 1. controller Organisasi / function simpan_data
	//         2. 
	function register_users($EMAIL, $USERNAME, $PASSWORD_UTAMA, $CREATED, $ID_PEGAWAI){
		$hasil=$this->db->query("INSERT INTO users (id, ip_address, username, password, salt, email, activation_code, forgotten_password_code, forgotten_password_time, remember_code, created_on, last_login, active, ID_PEGAWAI, STATUS_DATA_PEGAWAI)  VALUES (NULL, '::1', '$USERNAME', '$PASSWORD_UTAMA', NULL, '$EMAIL', NULL, NULL, NULL, NULL, '$CREATED', NULL, '1', '$ID_PEGAWAI', 'pegawai_wme')");
		
		return $hasil;
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan data organisasi berdasarkan nip
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller Organisasi / function simpan_data
	//         2. controller Organisasi / function update_data
	function cek_nip($nip){
		$hsl=$this->db->query("SELECT * FROM pegawai WHERE NIP ='$nip'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_PEGAWAI' => $data->ID_PEGAWAI,
					'NIP' => $data->NIP,
					'NIK' => $data->NIK,
					);
			}
			return $hasil;
		}
		else
		{
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk menampilkan data organisasi berdasarkan email
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller Organisasi / function simpan_data
	//         2. controller Organisasi / function update_data
	function cek_email($email){
		$hsl=$this->db->query("SELECT * FROM pegawai WHERE EMAIL ='$email'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_PEGAWAI' => $data->ID_PEGAWAI
					);
			}
			return $hasil;
		}
		else
		{
			return 'Data belum ada';
		}
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan data organisasi berdasarkan ID_PEGAWAI
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function cek_nip_dan_email($nip,$email){
		$hsl=$this->db->query("SELECT * FROM pegawai WHERE EMAIL ='$email' AND NIP ='$nip'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_PEGAWAI' => $data->ID_PEGAWAI
					);
			}
			return $hasil;
		}
		else
		{
			return 'Data belum ada';
		}
	}

	//FUNGSI: Fungsi ini untuk menampilkan data organisasi berdasarkan nip
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function cek_nip_by_status($nip){
		$hsl=$this->db->query("SELECT users.id, pegawai.NIP, pegawai.NAMA
		FROM users
		LEFT JOIN organisasi ON users.ID_PEGAWAI=pegawai.ID_PEGAWAI
		WHERE pegawai.NIP ='$nip'");
				if($hsl->num_rows()>0){
					foreach ($hsl->result() as $data) {
						$hasil=array(
							'NAMA' => $data->NAMA
							);
					}
					return $hasil;
				}
				else
				{
					return 'NIP belum diaktivasi';
				}
	}

	//FUNGSI: Fungsi ini untuk menampilkan data organisasi berdasarkan username di tabel user
	//SUMBER TABEL: tabel user
	//DIPAKAI: 1. controller Organisasi / function simpan_data
	//         2. controller Organisasi / function update_data
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
	
	//FUNGSI: Fungsi ini untuk menampilkan data organisasi berdasarkan nik
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function cek_nik($nik){
		$hsl=$this->db->query("SELECT * FROM pegawai WHERE NIK ='$nik'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'ID_PEGAWAI' => $data->ID_PEGAWAI
					);
			}
			return $hasil;
		}
		else
		{
			return 'Data belum ada';
		}
	}
	
	//FUNGSI: Fungsi ini untuk mengubah data organisasi berdasarkan ID_PEGAWAI2
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller Organisasi / function update_data
	//         2. 
	function update_data($ID_PEGAWAI2, $NIP2, $ID_PROYEK_PEGAWAI2, $ID_DEPARTEMEN_PEGAWAI2, $NAMA2, $EMAIL2, $NO_HP_12){
		$hasil=$this->db->query("UPDATE pegawai SET 
		NIP='$NIP2', ID_PROYEK_PEGAWAI='$ID_PROYEK_PEGAWAI2', ID_DEPARTEMEN_PEGAWAI='$ID_DEPARTEMEN_PEGAWAI2', NAMA='$NAMA2', EMAIL='$EMAIL2', NO_HP_1='$NO_HP_12' WHERE ID_PEGAWAI='$ID_PEGAWAI2'");
		return $hasil;
	}
	
	//FUNGSI: Fungsi ini untuk mengubah data organisasi berdasarkan id_pegawai
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller (BELUM) / function (BELUM)
	//         2. 
	function update_nip($id_pegawai, $nip, $nama, $ID_STATUS_PEGAWAI2, $ID_JABATAN2, $ID_DEPARTEMEN2, $tanggal_status_kontrak2, $tanggal_status_tetap2){
		$hasil=$this->db->query("UPDATE organisasi SET 
		NIP='$nip', NAMA='$nama', ID_STATUS_PEGAWAI='$ID_STATUS_PEGAWAI2', ID_JABATAN_PEGAWAI='$ID_JABATAN2', ID_DEPARTEMEN='$ID_DEPARTEMEN2', TANGGAL_STATUS_KONTRAK='$tanggal_status_kontrak2', TANGGAL_STATUS_TETAP='$tanggal_status_tetap2' WHERE ID_PEGAWAI='$id_pegawai'");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menambahkan data user log organisasi berdasarkan ID_USER
	//SUMBER TABEL: tabel pegawai (pegawai)
	//DIPAKAI: 1. controller Organisasi / function logout
	//         2. controller Organisasi / function user_log
	function user_log_organisasi($ID_USER, $KETERANGAN, $WAKTU){
		$hasil=$this->db->query("INSERT INTO user_log_pegawai (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}

	//FUNGSI: Fungsi ini untuk menghapus data organisasi berdasarkan ID_PEGAWAI
	//SUMBER TABEL: tabel organisasi
	//DIPAKAI: 1. controller Organisasi / function hapus_data
	//         2. 
	function hapus_data($ID_PEGAWAI){
		$hasil=$this->db->query("DELETE FROM users WHERE ID_PEGAWAI='$ID_PEGAWAI'");
		$hasil=$this->db->query("DELETE FROM pegawai WHERE ID_PEGAWAI='$ID_PEGAWAI'");
		return $hasil;
	}

	
}
