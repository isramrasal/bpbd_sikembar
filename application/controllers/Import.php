<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Import extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->library(array('excel','session'));
	}

	public function index()
	{
		$this->load->model('Import_model');
		$data = array(
			'list_data'	=> $this->Import_model->getData()
		);
		$this->load->view('wasa/import_excel',$data);
	}

	public function import_excel(){
		if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();	
				for($row=2; $row<=$highestRow; $row++)
				{
					$nama = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$jurusan = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$angkatan = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$temp_data[] = array(
						'nama'	=> $nama,
						'jurusan'	=> $jurusan,
						'angkatan'	=> $angkatan
					); 	
				}
			}
			$this->load->model('Import_model');
			$insert = $this->Import_model->insert($temp_data);
			if($insert){
				$this->session->set_flashdata('status', '<span class="glyphicon glyphicon-ok"></span> Data Berhasil di Import ke Database');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('status', '<span class="glyphicon glyphicon-remove"></span> Terjadi Kesalahan');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}else{
			echo "Tidak ada file yang masuk";
		}
	}

}