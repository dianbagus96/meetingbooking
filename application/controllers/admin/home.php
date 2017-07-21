<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
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
        $this->load->model('admin/m_home');
        $current_date = date('Y-m-d');

        //ceking status meeting is On Progress
		$cek_onprog = $this->m_home->cek_booking_onprog($current_date);
		if (!empty($cek_onprog)) {
			foreach ($cek_onprog as $row_onprog) :
				$id_booking = $row_onprog->id_booking;
				
				$data = array(
            		'status' => 'On Progres'
        		);
        		$this->m_home->update_status_progdone($id_booking,$data);
			endforeach;
		}

		//ceking status meeting is Done
		$cek_done = $this->m_home->cek_booking_done($current_date);
		if (!empty($cek_done)) {
			foreach ($cek_done as $row_done) :
				$id_booking = $row_done->id_booking;
				
				$data = array(
            		'status' => 'Done'
        		);
        		$this->m_home->update_status_progdone($id_booking,$data);
			endforeach;
		}

 	}

 	function index(){
 		$start_date = $this->input->post('start_date');
		$this->form_validation->set_rules('start_date', 'TGL.', 'required');
		
		$data['startdate'] = null;
		if ($this->form_validation->run() == TRUE) 
		{
			$data['startdate'] = date("Y-m-d", strtotime($start_date));
		}else{
			$data['startdate'] = date('Y-m-d', strtotime('sunday this week', strtotime('last saturday')));
		}		
		
        $startdate = $data['startdate'];
        $end_date = date('Y-m-d', strtotime("+6 days $startdate"));
                  
		$data['ruang'] = $this->m_home->list_room();
		$data['data_booking'] = $this->m_home->list_room_day($startdate,$end_date);

		$this->load->view('admin/v_home',$data);
    }

}