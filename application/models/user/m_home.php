<?php

Class m_home extends CI_Model {

	function list_room(){
		$this->db->select("*");
		$this->db->from("tb_ruang");
		$this->db->order_by("id_ruang", "asc");
        
        return $this->db->get()->result();
	}

	function list_room_day($start_date,$end_date){
		$sql = "select c.nama as nama,a.id_ruang as id_ruang,a.tanggal_meeting as tgl,lower(date_format(a.tanggal_meeting, '%W')) as hari,CONCAT(SUBSTR(a.jam_mulai,1,5),'-',SUBSTR(a.jam_akhir,1,5)) as waktu,a.status as status,a.topik as topik
			from tb_booking a
			INNER JOIN tb_user c
			on a.id_karyawan = c.id_karyawan
			WHERE a.tanggal_meeting BETWEEN '$start_date' and '$end_date'";
			
        return $this->db->query($sql)->result();
	}

	function cek_booking_onprog($current_date){
		$sql = "SELECT a.id_booking as id_booking
			from tb_booking a
			where a.`status` = 'Upcoming'
			and a.tanggal_meeting = '$current_date'
			and DATE_FORMAT(NOW(),'%H:%i:00') > jam_mulai
			and DATE_FORMAT(NOW(),'%H:%i:00') < jam_akhir";

		return $this->db->query($sql)->result();
	}

	function cek_booking_done($current_date){
		$sql = "SELECT a.id_booking as id_booking
			from tb_booking a
			where a.`status` in ('Upcoming','On Progres')
			and a.tanggal_meeting = '$current_date'
			and jam_akhir < DATE_FORMAT(NOW(),'%H:%i:00')
			UNION ALL
			SELECT a.id_booking as id_booking
			from tb_booking a
			where a.`status` in ('Upcoming','On Progres')
			and a.tanggal_meeting < '$current_date'";

		return $this->db->query($sql)->result();
	}
	
	function update_status_progdone($id,$data){
		$this->db->where('id_booking', $id);
        $this->db->update('tb_booking', $data);
	}

}