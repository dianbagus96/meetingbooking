<?php

Class m_data_ruang extends CI_Model {

	function show_ruangan(){
		$this->db->select("*");
		$this->db->from("tb_ruang");
        return $this->db->get()->result();
	}

	function tambah_ruang($data){
		$this->db->insert('tb_ruang', $data);
	}

	function delete_ruang($id_ruang){
		$this->db->where('id_ruang', $id_ruang);
        $this->db->delete('tb_ruang');
    }

    function show_edit_ruang($id_ruang){
		$this->db->select("*");
		$this->db->where('id_ruang',$id_ruang);
        $this->db->from("tb_ruang");
        return $this->db->get()->result();
	}

	function edit_ruang($id_ruang,$data){
		$this->db->where('id_ruang', $id_ruang);
        $this->db->update('tb_ruang', $data);
	}

}