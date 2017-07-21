<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class data_user extends CI_Controller {
	
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
        $this->load->model('admin/m_data_user');

 	}

 	function index(){
 		$data['karyawan'] = $this->m_data_user->show_user();
		$this->load->view('admin/v_data_user',$data);
    }

}