<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class data_ruang extends CI_Controller {
	
	function __construct() {
   		parent::__construct();
   		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        date_default_timezone_set("Asia/Bangkok");

		if(empty($this->session->userdata('rule'))){
        	redirect(base_url().'login'); 
      	}elseif($this->session->userdata('rule') == 2){
        	redirect(base_url().'user/home');
        }

		//load header & model
		$data['nama'] = $this->session->userdata('nama');
        $this->load->view('admin/header', $data);
        $this->load->model('admin/m_data_ruang');
 	}

 	function index(){
 		
 		$flag = $this->uri->segment(4);
			
		$data['ruang'] = $this->m_data_ruang->show_ruangan();
		if ($flag == 1) {
				$data['alert'] = "Data berhasil disimpan";
		}elseif ($flag == 2){
			$data['alert'] = "Data berhasil diedit";
		}elseif ($flag == 3){
			$data['alert'] = "Data berhasil dihapus";
		} else {
			$data['alert'] = "";
		}

		$this->load->view('admin/v_data_ruang',$data);

    }

    function tambah_ruang(){
		$nama_ruangan = $this->input->post('nama_ruangan');
		$status = $this->input->post('status');
		$kapasitas = $this->input->post('kapasitas');
		$this->form_validation->set_rules('nama_ruangan','Nama Ruangan.','required');
		$this->form_validation->set_rules('status','Status.','required|number');
		$this->form_validation->set_rules('kapasitas','Kapasitas.','required|number');

		if ($this->form_validation->run() == TRUE) 
		{
			$data = array (
            		'nama_ruang' => $nama_ruangan,
            		'status_ruang' => $status,
            		'kapasitas' => $kapasitas
            );
			$this->m_data_ruang->tambah_ruang($data);
			$flag = 1;
			redirect(base_url() . 'admin/data_ruang/index/' . $flag);	
		}
		
		$this->load->view('admin/v_form_tambah_ruang');
	}

	function delete_ruang(){
		$id_ruang = $this->uri->segment(4);
		$this->m_data_ruang->delete_ruang($id_ruang);

		$flag = 3;
		redirect(base_url() . 'admin/data_ruang/index/' . $flag);
	}

	function edit_ruang(){
		$id_ruang = $this->uri->segment(4);
		
		$data['ruang'] = $this->m_data_ruang->show_edit_ruang($id_ruang);
		$this->load->view('admin/v_form_edit_ruang',$data);
	}

	function edit_ruang_exc(){
		$id_ruang = $this->input->post('id_ruang');
		$nama_ruangan = $this->input->post('nama_ruangan');
		$status = $this->input->post('status');
		$kapasitas = $this->input->post('kapasitas');
		$this->form_validation->set_rules('nama_ruangan','Nama Ruangan.','required');
		$this->form_validation->set_rules('status','Status.','required|number');
		$this->form_validation->set_rules('kapasitas','Kapasitas.','required|number');

		if ($this->form_validation->run() == TRUE) 
		{
			$data = array (
            	'nama_ruang' => $nama_ruangan,
            	'status_ruang' => $status,
            	'kapasitas' => $kapasitas
            );
			$this->m_data_ruang->edit_ruang($id_ruang,$data);
			$flag = 2;
			redirect(base_url() . 'admin/data_ruang/index/' . $flag);	
		}
	}

}