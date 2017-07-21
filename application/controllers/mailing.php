<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mailing extends CI_Controller {
	
  function __construct() {
   		parent::__construct();
   		$this->load->model('m_mailing');
  }

  function index(){
		//echo $id_booking;exit;
	}

  function meetingMail(){
   	$id_booking = $this->uri->segment(3);
   	$id_karyawan = $this->session->userdata('id_karyawan');
		
		$get_psrta = $this->m_mailing->get_list_peserta($id_booking);
		$get_jdwl_meeting = $this->m_mailing->get_jdwl_meeting($id_booking);
    $get_role = $this->m_mailing->get_role($id_karyawan);
    $get_member = $this->m_mailing->get_list_member($id_booking);
    
		$row_jdwl = $get_jdwl_meeting->row();
    
    foreach ($get_psrta as $row) {
      
      $member=array();
      foreach ($get_member as $row_member) {
        $member[]=$row_member->nama;
      }
      $member_implode=implode(", ", $member);

  		$message = 'Dear ' . $row->nama . ', <br><br>

  		Diharapkan kehadiran bapak/ibu saudara untuk mengikuti meeting yang akan dilaksanakan pada : <br><br>

  		Judul : <b>' . $row_jdwl->topik .'</b><br>
  		Hari / Tanggal  : ' . date_format(date_create($row_jdwl->tgl),"D ,M Y") . '<br>
  		Tempat : Ruang ' . $row_jdwl->nama_ruang . '<br>
  		Waktu : ' . $row_jdwl->waktu . '<br> <br>

      ---------------------------------------------------------<b><br>'
      . $row_jdwl->topik . '</b><br>
      Reservator : ' . $get_role->row()->nama . '<br>
      Member     : ' . $member_implode .
        
      '<br> 
      ---------------------------------------------------------- <br> <br>

  		<i>Thanks & Regards,</i>';
  		
      	$config = Array(
    			'mailtype' => 'html',
          'smtp_port' => 465,
          'protocol' => 'smtp',
          'smtp_timeout' => '30',
          'charset' => 'utf-8',
          'protocol' => 'smtp',
          'mailpath' => '/usr/sbin/sendmail',
          'charset' => 'iso-8859-1',
          'wordwrap' => TRUE,
          'smtp_host' => 'ssl://smtp.googlemail.com',
          'smtp_user' => 'book.meetroom@gmail.com', // change it to yours
          'smtp_pass' => 'admin12345678' // change it to yours
  		  );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
      	$this->email->from('book.meetroom@gmail.com'); // change it to yours
      	$this->email->to($row->email);// change it to yours
      	$this->email->subject($row_jdwl->topik);
      	$this->email->message($message);


        if(!$this->email->send())
       	{
       		//show_error($this->email->print_debugger());exit;
          echo "sent mail failed,cek your connection or anymore";
      	}
    }

    $role = $get_role->row()->rule;
    //for routing redirect
    if ($role == 1) {
      redirect(base_url() . 'admin/jadwal_booking/');
    }else{
      redirect(base_url() . 'user/jadwal_booking/');
    }

	}

  function rescheduleMail(){
    $id_booking = $this->uri->segment(3);
    $id_karyawan = $this->session->userdata('id_karyawan');
    
    $get_psrta = $this->m_mailing->get_list_peserta($id_booking);
    $get_jdwl_meeting = $this->m_mailing->get_jdwl_meeting($id_booking);
    $get_role = $this->m_mailing->get_role($id_karyawan);
    $get_member = $this->m_mailing->get_list_member($id_booking);

    $row_jdwl = $get_jdwl_meeting->row();

    foreach ($get_psrta as $row) :

      $member=array();
      foreach ($get_member as $row_member) {
        $member[]=$row_member->nama;
      }
      $member_implode=implode(", ", $member);

      $message = 'Dear ' . $row->nama . ', <br><br>

      Dengan ini diberitahukan perihal adanya <b>Reschedule</b> meeting sebagai berikut : <br><br>

      Judul : <b>' . $row_jdwl->topik .'</b><br>
      Hari / Tanggal  : ' . date_format(date_create($row_jdwl->tgl),"D ,M Y") . '<br>
      Tempat : Ruang ' . $row_jdwl->nama_ruang . '<br>
      Waktu : ' . $row_jdwl->waktu . '<br> <br>

      ---------------------------------------------------------<b><br>'
      . $row_jdwl->topik . '</b><br>
      Reservator : ' . $get_role->row()->nama . '<br>
      Member     : ' . $member_implode .
        
      '<br> 
      ---------------------------------------------------------- <br> <br>

      <i>Thanks & Regards,</i>';
    
      $config = Array(
        'mailtype' => 'html',
        'smtp_port' => 465,
        'protocol' => 'smtp',
        'smtp_timeout' => '30',
        'charset' => 'utf-8',
        'protocol' => 'smtp',
        'mailpath' => '/usr/sbin/sendmail',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE,
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_user' => 'book.meetroom@gmail.com', // change it to yours
        'smtp_pass' => 'admin12345678' // change it to yours
      );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('book.meetroom@gmail.com'); // change it to yours
        $this->email->to($row->email);// change it to yours
        $this->email->subject('[Reschedule Meeting] ' . $row_jdwl->topik);
        $this->email->message($message);

        if(!$this->email->send())
        {
            //show_error($this->email->print_debugger());exit;
            echo "sent mail failed,cek your connection or anymore";
        }

    endforeach;

    $role = $get_role->row()->rule;
    //for routing redirect
    if ($role == 1) {
      redirect(base_url() . 'admin/jadwal_booking/');
    }else{
      redirect(base_url() . 'user/jadwal_booking/');
    }

  }

  function cancelMail(){
    $id_booking = $this->uri->segment(3);
    $id_karyawan = $this->session->userdata('id_karyawan');
    
    $get_psrta = $this->m_mailing->get_list_peserta($id_booking);
    $get_jdwl_meeting = $this->m_mailing->get_jdwl_meeting($id_booking);
    $get_role = $this->m_mailing->get_role($id_karyawan);
    $get_member = $this->m_mailing->get_list_member($id_booking);

    $row_jdwl = $get_jdwl_meeting->row();

    foreach ($get_psrta as $row) :

      $member=array();
      foreach ($get_member as $row_member) {
        $member[]=$row_member->nama;
      }
      $member_implode=implode(", ", $member);

    $message = 'Dear ' . $row->nama . ', <br><br>

    Dengan ini diberitahukan meeting yang akan dilaksanakan pada : <br><br>

    Judul : <b>' . $row_jdwl->topik .'</b><br>
    Hari / Tanggal  : ' . date_format(date_create($row_jdwl->tgl),"D ,M Y") . '<br>
    Tempat : Ruang ' . $row_jdwl->nama_ruang . '<br>
    Waktu : ' . $row_jdwl->waktu . '<br> <br>

    <b>TIDAK JADI</b> dilaksanakan. Untuk informasi updatenya akan diberitahukan lebih lanjut.<br><br>
    Demikian pemberitahuan ini dibuat, untuk perhatian dan kerjasamanya kami ucapkan terima kasih.<br><br>

    ---------------------------------------------------------<b><br>'
    . $row_jdwl->topik . '</b><br>
    Reservator : ' . $get_role->row()->nama . '<br>
    Member     : ' . $member_implode .
      
    '<br> 
    ---------------------------------------------------------- <br> <br>


    <i>Thanks & Regards,</i>';
    
      $config = Array(
        'mailtype' => 'html',
        'smtp_port' => 465,
        'protocol' => 'smtp',
        'smtp_timeout' => '30',
        'charset' => 'utf-8',
        'protocol' => 'smtp',
        'mailpath' => '/usr/sbin/sendmail',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE,
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_user' => 'book.meetroom@gmail.com', // change it to yours
        'smtp_pass' => 'admin12345678' // change it to yours
      );

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('book.meetroom@gmail.com'); // change it to yours
        $this->email->to($row->email);// change it to yours
        $this->email->subject('[Cancel Meeting] ' . $row_jdwl->topik);
        $this->email->message($message);

        if(!$this->email->send())
        {
            //show_error($this->email->print_debugger());exit;
            echo "sent mail failed,cek your connection or anymore";
        }

    endforeach;

    $role = $get_role->row()->rule;
    //for routing redirect
    if ($role == 1) {
      redirect(base_url() . 'admin/jadwal_booking/');
    }else{
      redirect(base_url() . 'user/jadwal_booking/');
    }

  }

}