<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class jadwal_booking extends CI_Controller {
	
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
        $this->load->model('user/m_jadwal_booking');
 	}

 	function index(){
 		$id_karyawan = $this->session->userdata('id_karyawan');
 		$data['history'] = $this->m_jadwal_booking->show_jadwal($id_karyawan);
		$this->load->view('user/v_jadwal_booking',$data);
    }

    function cancel_booking(){
		$id_booking = $this->uri->segment(4);

        //update status in tb_booking
        $this->m_jadwal_booking->update_status_booking($id_booking);
       
        //redirect(base_url() . 'user/jadwal_booking');
        redirect(base_url() . 'mailing/cancelMail/' . $id_booking);
	}

	//-- reschedule booking ruangan--\\
	function reschedule(){
		$id_booking = $this->input->post('id_booking');
		$tgl = $this->input->post('tanggal');
		$jml_psrta = $this->input->post('jml_psrta');
		$start_time = $this->input->post('start_time');
		$end_time = $this->input->post('end_time');
		$this->form_validation->set_rules('tanggal', 'Tanggal.', 'required');
		$this->form_validation->set_rules('jml_psrta', 'Jumlah Peserta.', 'required');
		$this->form_validation->set_rules('start_time', 'Start_time.', 'required');
		$this->form_validation->set_rules('end_time', 'End_time.', 'required');
		
		$datenow = date('Y-m-d');
		$tgl_meeting = date("Y-m-d", strtotime($tgl));
		$time_now = date('H:i');

		//jika form di submit(search ruangan)
		if ($this->form_validation->run() == TRUE) 
		{
			//--Show form booking
			if ($tgl_meeting < $datenow){
          		redirect(base_url() . 'user/jadwal_booking/reschedule/' . $id_booking . '/' . 2);
        	}else if ($start_time > $end_time){
          		redirect(base_url() . 'user/jadwal_booking/reschedule/' . $id_booking .'/'. 3);
        	}else if ($tgl_meeting == $datenow && $start_time < $time_now) {
          		redirect(base_url() . 'user/jadwal_booking/reschedule/' . $id_booking .'/'. 3);
        	}

			//ambil ruangan yang sesuai kapasitas
			$data['ruang'] = $this->m_jadwal_booking->show_room_edit($id_booking,$jml_psrta);
			//ambil list email yg ikut meeting
			$data['email_selected'] = $this->m_jadwal_booking->show_email_selected($id_booking);
			//ambil list email yg tdk ikut meeting
			$data['email_unselected'] = $this->m_jadwal_booking->show_email_unselected($id_booking);
			//ambil info topik
			$data['topik'] = $this->m_jadwal_booking->get_topik($id_booking);

			$data['prs_frm'] = array (
				'tgl' => $tgl,
        		'jml_psrta' => $jml_psrta,
            	'start_time' => $start_time,
            	'end_time' => $end_time,
            	'id_booking' => $id_booking
            );
            
            //tampilkan form booking dgn membawa data email & ruangan
			$this->load->view('user/v_form_reschedule',$data);
		}else{

			$data['id_booking'] = $this->uri->segment(4);
			$flag = 0;
			$flag = $this->uri->segment(5);
			if ($flag == 1) {
				$data['alert'] = "The room was booked at the time";
			}
			elseif ($flag == 2) {
          		$data['alert'] = "Please check your input date";
        	}
        	elseif ($flag == 3) {
          		$data['alert'] = "Please check your input time";
        	}
			else {
				$data['alert'] = "";
			}
			
			$data['dt_book'] = $this->m_jadwal_booking->show_booking($data['id_booking']);
			
			$this->load->view('user/v_reschedule',$data);
		}

	}

	function reschedule_exc(){
		$id_booking = $this->input->post('id_booking');
		$id_karyawan = $this->session->userdata('id_karyawan');
		$tgl = $this->input->post('tanggal');
		$start_time = $this->input->post('start_time');
		$end_time = $this->input->post('end_time');
		$email = $this->input->post('email');
		$ruang = $this->input->post('ruang');
		$topik = $this->input->post('topik');
		$this->form_validation->set_rules('tanggal', 'Tanggal.', 'required');
		$this->form_validation->set_rules('start_time', 'Start_time.', 'required');
		$this->form_validation->set_rules('end_time', 'End_time.', 'required');
		$this->form_validation->set_rules('email', 'Email.', 'required');
		$this->form_validation->set_rules('ruang', 'Ruang.', 'required');
		$this->form_validation->set_rules('topik', 'Topik.', 'required');

		$tgl_meeting = date("Y-m-d", strtotime($tgl));
		$tgl_psn = date('Y-m-d');

		//If form booking room submmited
		if ($this->form_validation->run() == TRUE) 
		{
			$this->load->model('user/m_book_room');
			//--ceking jam tersedia
			$a = $this->m_book_room->show_status_room_a($ruang,$tgl_meeting,$start_time,$end_time);
			$b = $this->m_book_room->show_status_room_b($ruang,$tgl_meeting,$start_time,$end_time);
			$c = $this->m_book_room->show_status_room_c($ruang,$tgl_meeting);
			$d = $this->m_book_room->show_status_room_d($ruang,$tgl_meeting);

			$row_c = $c->row();
			$row_d = $d->row();
			
			//handling cek ruang yang di booking
		    if( $start_time > $row_c->jam_mulai && $start_time < $row_d->jam_akhir || $end_time > $row_c->jam_mulai && $end_time < $row_d->jam_akhir){
		    	redirect(base_url() . 'user/jadwal_booking/reschedule/'. $id_booking .'/1');
		    }elseif (!empty($a) or !empty($b)){
        		redirect(base_url() . 'user/jadwal_booking/reschedule/'. $id_booking .'/1');
      		}else{
			    	//--Jadwal booking tersedia
				$data_det_booking = array (
					'id_ruang' => $ruang,
	            	'tanggal_meeting' => $tgl_meeting,
	            	'jam_mulai' => $start_time,
	            	'jam_akhir'=> $end_time,
	            	'topik' => $topik
	            );
	          	
	          	//update tb_detail_booking
				$this->m_jadwal_booking->update_schedule('tb_booking','id_booking',$id_booking,$data_det_booking);
		
				//cleansing data peserta
				$this->m_jadwal_booking->cleansing_peserta($id_booking);

				//get list peserta meeting
	            for ($i = 0; $i < count($email); $i++) {
	            	$data_peserta = array (
	            		'id_booking' => $id_booking,
	            		'id_karyawan' => $email[$i]
	            	);
	            	//insert_to_tb_peserta
	            	$this->m_jadwal_booking->insert_booking('tb_peserta',$data_peserta);	 
				}
				//redirect(base_url() . 'user/jadwal_booking/');
				redirect(base_url() . 'mailing/rescheduleMail/' . $id_booking);
		    }	
		}

	}



}