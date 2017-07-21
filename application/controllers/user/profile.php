<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class profile extends CI_Controller {
	
	function __construct() {
   		parent::__construct();
   		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        date_default_timezone_set("Asia/Bangkok");

		if(empty($this->session->userdata('rule'))){
        	redirect(base_url().'login'); 
      	}elseif($this->session->userdata('rule') == 1){
        	redirect(base_url().'admin/home');
        }

		//load header & model
		$data['nama'] = $this->session->userdata('nama');
        $this->load->view('user/header', $data);
        $this->load->model('user/m_profile');
 	}

 	function index(){
 		$id = $this->session->userdata('id_karyawan');
    	$result = $this->m_profile->lihat_profil($id);
    	$data = array(
            'data' => $result
        );
    	$this->load->view('user/v_profile', $data);
    }

    function test(){
    	echo "hellow word";
    	exit;
    }

}