<?php
class Manajemen_user_model extends CI_Model{

	function manajemen_user_list(){
		$hasil=$this->db->query("SELECT users.id, users.username, users.active AS STATUS_USER, users.ID_PEGAWAI, pegawai.NIP, users_groups.group_id, groups.name, pegawai.NAMA FROM users LEFT JOIN users_groups ON users.id=users_groups.user_id LEFT JOIN groups ON users_groups.group_id=groups.id LEFT JOIN pegawai ON users.ID_PEGAWAI=pegawai.ID_PEGAWAI WHERE NOT  users_groups.group_id = 1 ");
		return $hasil->result();
	}
	
	function get_data_by_id($id){
		$hsl=$this->db->query("SELECT users.id, users.ID_PEGAWAI, pegawai.NIP, 
		users.email,
		users.activation_code,
		users.forgotten_password_code,
		users.forgotten_password_time,
		users.remember_code,
		users.created_on,
		users.last_login,
		users.active,
		users.ID_PEGAWAI,
		users.STATUS_DATA_PEGAWAI,
		users.SPPB_baca,
		users.SPPB_BARANG_baca,
		users.RASD_baca,
		users.RASD_BARANG_baca,
		users.KHP_baca,
		users.KHP_BARANG_baca,
		users.PO_baca,
		users.SPP_baca,
		users.PROYEK_baca,
		users.GUDANG_baca,
		users.SPPB_tambah,
		users.SPPB_BARANG_tambah,
		users.RASD_tambah,
		users.RASD_BARANG_tambah,
		users.KHP_tambah,
		users.KHP_BARANG_tambah,
		users.PO_tambah,
		users.SPP_tambah,
		users.PROYEK_tambah,
		users.GUDANG_tambah,
		users.SPPB_ubah,
		users.SPPB_BARANG_ubah,
		users.RASD_ubah,
		users.RASD_BARANG_ubah,
		users.KHP_ubah,
		users.KHP_BARANG_ubah,
		users.PO_ubah,
		users.SPP_ubah,
		users.PROYEK_ubah,
		users.GUDANG_ubah,
		users.SPPB_hapus,
		users.SPPB_BARANG_hapus,
		users.RASD_hapus,
		users.RASD_BARANG_hapus,
		users.KHP_hapus,
		users.KHP_BARANG_hapus,
		users.PO_hapus,
		users.SPP_hapus,
		users.PROYEK_hapus,
		users.GUDANG_hapus,
		users_groups.group_id, groups.name, pegawai.NAMA
FROM users
LEFT JOIN users_groups ON users.id=users_groups.user_id
LEFT JOIN groups ON users_groups.group_id=groups.id
LEFT JOIN pegawai ON users.ID_PEGAWAI=pegawai.ID_PEGAWAI
WHERE users.id='$id'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'user_id' => $data->id,
					'ID_PEGAWAI' => $data->ID_PEGAWAI,
					'NIP' => $data->NIP,
					'group_id' => $data->group_id,
					'name' => $data->name,
					'NAMA' => $data->NAMA,
					'email' => $data->email,
					'activation_code' => $data->activation_code,
					'forgotten_password_code' => $data->forgotten_password_code,
					'forgotten_password_time' => $data->forgotten_password_time,
					'remember_code' => $data->remember_code,
					'created_on' => $data->created_on,
					'last_login' => $data->last_login,
					'active' => $data->active,
					'STATUS_DATA_PEGAWAI' => $data->STATUS_DATA_PEGAWAI,
					'SPPB_baca' => $data->SPPB_baca,
					'SPPB_BARANG_baca' => $data->SPPB_BARANG_baca,
					'RASD_baca' => $data->RASD_baca,
					'RASD_BARANG_baca' => $data->RASD_BARANG_baca,
					'KHP_baca' => $data->KHP_baca,
					'KHP_BARANG_baca' => $data->KHP_BARANG_baca,
					'PO_baca' => $data->PO_baca,
					'SPP_baca' => $data->SPP_baca,
					'PROYEK_baca' => $data->PROYEK_baca,
					'GUDANG_baca' => $data->GUDANG_baca,
					'SPPB_tambah' => $data->SPPB_tambah,
					'SPPB_BARANG_tambah' => $data->SPPB_BARANG_tambah,
					'RASD_tambah' => $data->RASD_tambah,
					'RASD_BARANG_tambah' => $data->RASD_BARANG_tambah,
					'KHP_tambah' => $data->KHP_tambah,
					'KHP_BARANG_tambah' => $data->KHP_BARANG_tambah,
					'PO_tambah' => $data->PO_tambah,
					'SPP_tambah' => $data->SPP_tambah,
					'PROYEK_tambah' => $data->PROYEK_tambah,
					'GUDANG_tambah' => $data->GUDANG_tambah,
					'SPPB_ubah' => $data->SPPB_ubah,
					'SPPB_BARANG_ubah' => $data->SPPB_BARANG_ubah,
					'RASD_ubah' => $data->RASD_ubah,
					'RASD_BARANG_ubah' => $data->RASD_BARANG_ubah,
					'KHP_ubah' => $data->KHP_ubah,
					'KHP_BARANG_ubah' => $data->KHP_BARANG_ubah,
					'PO_ubah' => $data->PO_ubah,
					'SPP_ubah' => $data->SPP_ubah,
					'PROYEK_ubah' => $data->PROYEK_ubah,
					'GUDANG_ubah' => $data->GUDANG_ubah,
					'SPPB_hapus' => $data->SPPB_hapus,
					'SPPB_BARANG_hapus' => $data->SPPB_BARANG_hapus,
					'RASD_hapus' => $data->RASD_hapus,
					'RASD_BARANG_hapus' => $data->RASD_BARANG_hapus,
					'KHP_hapus' => $data->KHP_hapus,
					'KHP_BARANG_hapus' => $data->KHP_BARANG_hapus,
					'PO_hapus' => $data->PO_hapus,
					'SPP_hapus' => $data->SPP_hapus,
					'PROYEK_hapus' => $data->PROYEK_hapus,
					'GUDANG_hapus' => $data->GUDANG_hapus
					);
			}
		}
		return $hasil;
	}

	function get_data_role_user_by_id($id){
		$hsl=$this->db->query("SELECT
		users.id,
		users.ID_PEGAWAI,
		pegawai.NIP,
		users.last_login,
		users.active,
		users.ID_PEGAWAI,
		users.username,
		users_groups.group_id,
		groups.name,
		groups.description,
		pegawai.NAMA,
		proyek.NAMA_PROYEK 
		FROM users 
		LEFT JOIN users_groups ON users.id=users_groups.user_id 
		LEFT JOIN groups ON users_groups.group_id=groups.id 
		LEFT JOIN pegawai ON users.ID_PEGAWAI=pegawai.ID_PEGAWAI 
		LEFT JOIN proyek ON proyek.ID_PROYEK=pegawai.ID_PROYEK_PEGAWAI 
		WHERE users.id='$id'");
		if($hsl->num_rows()>0){
			foreach ($hsl->result() as $data) {
				$hasil=array(
					'user_id' => $data->id,
					'ID_PEGAWAI' => $data->ID_PEGAWAI,
					'username' => $data->username,
					'NIP' => $data->NIP,
					'group_id' => $data->group_id,
					'name' => $data->name,
					'NAMA' => $data->NAMA,
					'active' => $data->active,
					'description' => $data->description,
					'NAMA_PROYEK' => $data->NAMA_PROYEK,
					);
			}
		}
		return $hasil;
	}
	
	function update_data_role_user($id_user2,$role_user2,$status_user2){
		$hasil=$this->db->query("UPDATE users_groups SET group_id='$role_user2' WHERE user_id='$id_user2'");
		$hasil=$this->db->query("UPDATE users SET active='$status_user2' WHERE id='$id_user2'");
		return $hasil;
	}
	
	
	//FUNGSI: Fungsi ini untuk menambahkan data manajemen user berdasarkan ID_USER
	//SUMBER TABEL: tabel fpb
	//DIPAKAI: 1. controller Manajemen user / function logout
	//         2. controller Manajemen user / function user_log
	function user_log_manajemen_user($ID_USER, $KETERANGAN, $WAKTU)
	{
		$hasil = $this->db->query("INSERT INTO user_log_manajemen_user (ID_USER, KETERANGAN, WAKTU) VALUES('$ID_USER', '$KETERANGAN', '$WAKTU')");
		return $hasil;
	}
	
	
}