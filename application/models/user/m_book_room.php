<?php

Class m_book_room extends CI_Model {

	function show_room($jml_psrta){
		$sql = "SELECT * from tb_ruang where kapasitas >= $jml_psrta and status_ruang = 'active'";
		return $this->db->query($sql)->result();
	}

	function show_email(){
		$this->db->select("id_karyawan,email");
		$this->db->from("tb_user");
        return $this->db->get()->result();
	}

	function show_status_room_a($ruang,$tgl,$start_time,$end_time){
		$sql = "select * from tb_booking a
			INNER JOIN tb_ruang c
			ON a.id_ruang = c.id_ruang
			where `status` not IN ('Canceled','Done')
			and c.id_ruang = '$ruang'
			and a.tanggal_meeting = '$tgl'
			and a.jam_mulai BETWEEN '$start_time' and '$end_time'";

		return $this->db->query($sql)->result();			
	}

	function show_status_room_b($id_ruang,$tgl,$start_time,$end_time){
		$sql = "select * from tb_booking a
			INNER JOIN tb_ruang c
			ON a.id_ruang = c.id_ruang
			where `status` not IN ('Canceled','Done')
			and a.id_ruang = '$id_ruang'
			and a.tanggal_meeting = '$tgl'
			and a.jam_akhir BETWEEN '$start_time' and '$end_time'";

			return $this->db->query($sql)->result();
	}

	function show_status_room_c($id_ruang,$tgl){
		$sql = "select c.id_ruang,a.jam_mulai
			from tb_booking a
			INNER JOIN tb_ruang c
			ON a.id_ruang = c.id_ruang
			where `status` not IN ('Canceled','Done')
			and c.id_ruang = '$id_ruang'
			and a.tanggal_meeting = '$tgl'";

		$row = $this->db->query($sql);
		return $row;
	}

	function show_status_room_d($id_ruang,$tgl){
		$sql = "select c.id_ruang,a.jam_akhir
			from tb_booking a
			INNER JOIN tb_ruang c
			ON a.id_ruang = c.id_ruang
			where `status` not IN ('Canceled','Done')
			and c.id_ruang = '$id_ruang'
			and a.tanggal_meeting = '$tgl'";

		$row = $this->db->query($sql);
		return $row;
	}

	function select_max_id($tablename,$columnid){
		$this->db->select_max("$columnid");
        $query = $this->db->get("$tablename")->row_array();
        $id = $query["$columnid"];
        if ($id == null) {
            $id = 1;
        } else {
            $id = 1 + $query["$columnid"];
        }
        return $id;
	}

	function insert_booking($tablename,$data){
		$this->db->insert("$tablename", $data);
	}

}