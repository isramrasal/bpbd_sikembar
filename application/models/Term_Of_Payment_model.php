<?php
class Term_Of_Payment_model extends CI_Model{

	//FUNGSI: Fungsi ini untuk menampilkan seluruh data TOP
	//SUMBER TABEL: tabel term_of_payment
	//DIPAKAI: 1. controller term_of_payment / function data_term_of_payment
	function term_of_payment_list()
	{
		$hasil = $this->db->query("SELECT * FROM `term_of_payment` ORDER BY `term_of_payment`.`NAMA_TERM_OF_PAYMENT` ASC");
		return $hasil->result();
	}

	function term_of_payment_list_by_id_term_of_payment($ID_TERM_OF_PAYMENT)
	{
		$hasil = $this->db->query("SELECT * FROM term_of_payment WHERE ID_TERM_OF_PAYMENT = '$ID_TERM_OF_PAYMENT'");
		return $hasil;
	}

	function set_md5_id_term_of_payment($NAMA_TERM_OF_PAYMENT)
	{
		$hsl = $this->db->query("SELECT ID_TERM_OF_PAYMENT FROM term_of_payment WHERE NAMA_TERM_OF_PAYMENT='$NAMA_TERM_OF_PAYMENT'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_TERM_OF_PAYMENT' => $data->ID_TERM_OF_PAYMENT
				);
			}
		} else {
			$hasil = "BELUM ADA TERM OF PAYMENT";
		}
		$ID_TERM_OF_PAYMENT = $hasil['ID_TERM_OF_PAYMENT'];
		$HASH_MD5_TOP = md5($ID_TERM_OF_PAYMENT);
		$this->db->query("UPDATE term_of_payment SET HASH_MD5_TOP='$HASH_MD5_TOP' WHERE ID_TERM_OF_PAYMENT='$ID_TERM_OF_PAYMENT'");
	}

	function set_md5_id_term_of_payment_dari_rfq_form($NAMA_TERM_OF_PAYMENT)
	{
		$hsl = $this->db->query("SELECT ID_TERM_OF_PAYMENT FROM term_of_payment WHERE NAMA_TERM_OF_PAYMENT='$NAMA_TERM_OF_PAYMENT'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_TERM_OF_PAYMENT' => $data->ID_TERM_OF_PAYMENT
				);
			}
		} else {
			$hasil = "BELUM ADA TERM OF PAYMENT";
		}
		$ID_TERM_OF_PAYMENT = $hasil['ID_TERM_OF_PAYMENT'];
		$HASH_MD5_TOP = md5($ID_TERM_OF_PAYMENT);
		$this->db->query("UPDATE term_of_payment SET HASH_MD5_TOP='$HASH_MD5_TOP' WHERE ID_TERM_OF_PAYMENT='$ID_TERM_OF_PAYMENT'");
	}

	function set_md5_id_term_of_payment_dari_po_form($NAMA_TERM_OF_PAYMENT)
	{
		$hsl = $this->db->query("SELECT ID_TERM_OF_PAYMENT FROM term_of_payment WHERE NAMA_TERM_OF_PAYMENT='$NAMA_TERM_OF_PAYMENT'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_TERM_OF_PAYMENT' => $data->ID_TERM_OF_PAYMENT
				);
			}
		} else {
			$hasil = "BELUM ADA TERM OF PAYMENT";
		}
		$ID_TERM_OF_PAYMENT = $hasil['ID_TERM_OF_PAYMENT'];
		$HASH_MD5_TOP = md5($ID_TERM_OF_PAYMENT);
		$this->db->query("UPDATE term_of_payment SET HASH_MD5_TOP='$HASH_MD5_TOP' WHERE ID_TERM_OF_PAYMENT='$ID_TERM_OF_PAYMENT'");
	}
	
	//FUNGSI: Fungsi ini untuk menampilkan data Term of Payment berdasarkan ID_TERM_OF_PAYMENT
	//SUMBER TABEL: tabel term_of_payment
	//DIPAKAI: 1. controller term_of_payment / function get_data
	//         2. controller term_of_payment / function hapus_data
	//         3. controller term_of_payment / function update_data
	function get_data_by_id_term_of_payment($ID_TERM_OF_PAYMENT)
	{
		$hsl = $this->db->query("SELECT * FROM term_of_payment WHERE ID_TERM_OF_PAYMENT='$ID_TERM_OF_PAYMENT'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_TERM_OF_PAYMENT' => $data->ID_TERM_OF_PAYMENT,
					'NAMA_TERM_OF_PAYMENT' => $data->NAMA_TERM_OF_PAYMENT,
				);
			}
		} else {
			$hasil = "BELUM ADA TERM OF PAYMENT";
		}
		return $hasil;
	}

	function cek_nama_top($NAMA_TERM_OF_PAYMENT)
	{
		$hsl = $this->db->query("SELECT * FROM term_of_payment WHERE NAMA_TERM_OF_PAYMENT ='$NAMA_TERM_OF_PAYMENT'");
		if ($hsl->num_rows() > 0) {
			foreach ($hsl->result() as $data) {
				$hasil = array(
					'ID_TERM_OF_PAYMENT' => $data->ID_TERM_OF_PAYMENT,
					'NAMA_TERM_OF_PAYMENT' => $data->NAMA_TERM_OF_PAYMENT,
				);
			}
			return $hasil;
		} else {
			return 'Data belum ada';
		}
	}

	function simpan_data_term_of_payment($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER){
		$hasil=$this->db->query("INSERT INTO term_of_payment (NAMA_TERM_OF_PAYMENT, CREATE_BY_USER) VALUES ('$NAMA_TERM_OF_PAYMENT', '$CREATE_BY_USER')");
		return $hasil;
	}

	function simpan_data_dari_rfq_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER){
		$hasil=$this->db->query("INSERT INTO term_of_payment (NAMA_TERM_OF_PAYMENT, CREATE_BY_USER) VALUES ('$NAMA_TERM_OF_PAYMENT', '$CREATE_BY_USER')");
		return $hasil;
	}

	function simpan_data_dari_po_form($NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER){
		$hasil=$this->db->query("INSERT INTO term_of_payment (NAMA_TERM_OF_PAYMENT, CREATE_BY_USER) VALUES ('$NAMA_TERM_OF_PAYMENT', '$CREATE_BY_USER')");
		return $hasil;
	}

	function update_data($ID_TERM_OF_PAYMENT, $NAMA_TERM_OF_PAYMENT, $CREATE_BY_USER)
	{
		$hasil = $this->db->query("UPDATE term_of_payment SET 
			ID_TERM_OF_PAYMENT='$ID_TERM_OF_PAYMENT',
			NAMA_TERM_OF_PAYMENT='$NAMA_TERM_OF_PAYMENT',
			CREATE_BY_USER='$CREATE_BY_USER'
			WHERE ID_TERM_OF_PAYMENT='$ID_TERM_OF_PAYMENT'");
		return $hasil;
	}

	function hapus_data_top($ID_TERM_OF_PAYMENT){
		$hasil=$this->db->query("DELETE FROM term_of_payment WHERE ID_TERM_OF_PAYMENT='$ID_TERM_OF_PAYMENT'");
		return $hasil;
	}
}