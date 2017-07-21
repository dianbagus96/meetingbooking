<?php

Class m_jadwal_booking extends CI_Model {

	function show_jadwal(){
		$sql = "SELECT e.nama as nama,a.topik as topik,a.id_booking as id_booking,d.nama_ruang as ruang,a.tanggal_psn as tgl_psn,a.tanggal_meeting as tgl_meeting,CONCAT(SUBSTR(a.jam_mulai,1,5),'-',SUBSTR(a.jam_akhir,1,5)) as waktu,a.status as status
				from tb_booking a
				INNER JOIN tb_ruang d
				ON a.id_ruang = d.id_ruang
				INNER JOIN tb_user e
				ON a.id_karyawan = e.id_karyawan";

			return $this->db->query($sql)->result();
	}

	function update_status_booking($id){
		$this->db->set('status', 'Canceled');
		$this->db->where('id_booking', $id);
		$this->db->update('tb_booking'); 
	}

	function show_booking($id){
		$sql = "SELECT a.id_booking as id_booking,DATE_FORMAT(a.tanggal_meeting,'%m/%d/%Y') as tgl,a.jam_mulai as jam_mulai,a.jam_akhir as jam_akhir,COUNT(c.id_karyawan) as tot_psrta
				FROM tb_booking a
				INNER JOIN tb_peserta c
				ON a.id_booking = c.id_booking
				where a.id_booking = $id
				GROUP BY id_booking,tgl,jam_mulai,jam_akhir";

		return $this->db->query($sql)->result();
	}

	function show_room_edit($id_booking,$jml_psrta){
		$sql = "select a.id_ruang as id_ruang,a.nama_ruang as nama_ruang
			from tb_ruang a
			INNER JOIN tb_booking b
			ON a.id_ruang = b.id_ruang
			WHERE b.id_booking = '$id_booking'
			UNION ALL
			select id_ruang ,nama_ruang 
			from tb_ruang 
			WHERE id_ruang not in (
			select a.id_ruang as id_ruang
			from tb_ruang a
			INNER JOIN tb_booking b
			ON a.id_ruang = b.id_ruang
			WHERE b.id_booking = '$id_booking'
			and a.kapasitas >= '$jml_psrta'
			and status_ruang = 'active' )";

		return $this->db->query($sql)->result();
	}

	function show_email_selected($id_booking){
		$sql = "SELECT a.id_karyawan as id_karyawan,a.email as email
			from  tb_user a
			INNER JOIN tb_peserta b 
			ON a.id_karyawan = b.id_karyawan
			WHERE b.id_booking = '$id_booking'";

		return $this->db->query($sql)->result();
	}

	function show_email_unselected($id_booking){
		$sql = "SELECT id_karyawan,email
			from  tb_user
			WHERE id_karyawan not in (
			SELECT a.id_karyawan as id_karyawan
			from  tb_user a
			INNER JOIN tb_peserta b 
			ON a.id_karyawan = b.id_karyawan
			WHERE b.id_booking = '$id_booking')";

		return $this->db->query($sql)->result();
	}

	function get_topik($id_booking){
		$sql = "SELECT a.topik as topik
			FROM tb_booking a
			INNER JOIN tb_ruang b
			ON a.id_ruang = b.id_ruang
			where a.id_booking = $id_booking";
		
		return $this->db->query($sql)->result();
	}

	function update_schedule($tablename,$columnn_id,$id,$data){
		$this->db->where("$columnn_id", $id);
		$this->db->update("$tablename", $data); 
	}
	
	function cleansing_peserta($id){
		$this->db->where('id_booking', $id);
        $this->db->delete('tb_peserta');
	}

	function insert_booking($tablename,$data){
		$this->db->insert("$tablename", $data);
	}

}