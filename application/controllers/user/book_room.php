<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class book_room extends CI_Controller {

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
      $this->load->model('user/m_book_room');

 	}

  function index(){

      $data['alert'] = "";
      $this->load->view('user/v_book_room',$data);  
  }

 	function search_room(){

    $tgl = $this->input->post('tanggal');
    $jml_psrta = $this->input->post('jml_psrta');
    $start_time = $this->input->post('start_time');
    $end_time = $this->input->post('end_time');
    $this->form_validation->set_rules('tanggal', 'Tanggal.', 'required');
    $this->form_validation->set_rules('jml_psrta', 'Jumlah Peserta.', 'required');
    $this->form_validation->set_rules('start_time', 'Start_time.', 'required');
    $this->form_validation->set_rules('end_time', 'End_time.', 'required');
    
    $tgl_meeting = date("Y-m-d", strtotime($tgl));
    $tgl_psn = date('Y-m-d');
    $time_now = date('H:i');

    if ($this->form_validation->run() == TRUE) 
    {
        if ($tgl_meeting < $tgl_psn){
          redirect(base_url() . 'user/book_room/search_room/' . 2);
        }else if ($start_time > $end_time){
          redirect(base_url() . 'user/book_room/search_room/' . 3);
        }else if ($tgl_meeting == $tgl_psn && $start_time < $time_now) {
          redirect(base_url() . 'user/book_room/search_room/' . 3);
        }

        //--Show form booking      
        //ambil ruangan yang sesuai kapasitas
        $data['ruang'] = $this->m_book_room->show_room($jml_psrta,$tgl,$start_time,$end_time);
        //ambil list email
        $data['email'] = $this->m_book_room->show_email();
        $data['prs_frm'] = array (
          'tgl' => $tgl,
          'jml_psrta' => $jml_psrta,
          'start_time' => $start_time,
          'end_time' => $end_time
        );
            
        //tampilkan form booking dgn membawa data email & ruangan
        $this->load->view('user/v_form_book_room',$data);
    }else{
        $flag = 0;
        $flag = $this->uri->segment(4);
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
        $this->load->view('user/v_book_room',$data);
    }

 	}

  function book_room_exc(){

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
      //--ceking jam tersedia
      $a = $this->m_book_room->show_status_room_a($ruang,$tgl_meeting,$start_time,$end_time);
      $b = $this->m_book_room->show_status_room_b($ruang,$tgl_meeting,$start_time,$end_time);
      $c = $this->m_book_room->show_status_room_c($ruang,$tgl_meeting);
      $d = $this->m_book_room->show_status_room_d($ruang,$tgl_meeting);

      $row_c = $c->row();//10:00:00
      $row_d = $d->row();//12:00:00

      //handling cek ruang yang di booking
      if( $start_time > $row_c->jam_mulai && $start_time < $row_d->jam_akhir || $end_time > $row_c->jam_mulai && $end_time < $row_d->jam_akhir){
          redirect(base_url() . 'user/book_room/search_room/' . '1');
      }elseif (!empty($a) or !empty($b)){
          redirect(base_url() . 'user/book_room/search_room/' . '1');
      }else{

          //get uniq id number for id_booking 
          $id_booking = $this->m_book_room->select_max_id('tb_booking','id_booking');
          $data_booking = array (
            'id_booking' => $id_booking,
            'id_ruang' => $ruang,
            'id_karyawan' => $id_karyawan,
            'tanggal_psn' => $tgl_psn,
            'tanggal_meeting' => $tgl_meeting,
            'jam_mulai' => $start_time,
            'jam_akhir' => $end_time,
            'topik' => $topik,
            'status' => 'Upcoming'
          );
          //insert_to_tb_booking
          $this->m_book_room->insert_booking('tb_booking',$data_booking);
                
          //get list peserta meeting
          for ($i = 0; $i < count($email); $i++) {
              $data_peserta = array (
                'id_booking' => $id_booking,
                'id_karyawan' => $email[$i]
              );

              //insert_to_tb_peserta
              $this->m_book_room->insert_booking('tb_peserta',$data_peserta);  
          }
      }
      //redirect(base_url() . 'user/jadwal_booking/');'mailing/meetingMail/' . $id_booking
      redirect(base_url() . 'mailing/meetingMail/' . $id_booking);
    }

  }


}