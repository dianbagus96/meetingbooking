<?php

Class m_data_user extends CI_Model {

	function show_user(){
    	$sql = "SELECT a.id_karyawan as id_karyawan,a.nama as nama,b.departemen as departemen,a.email as email,a.no_telp as no_telp,a.username as username,a.rule as rule
			FROM tb_user a
			INNER JOIN tb_departemen b
			on a.id_departemen = b.id_departemen";

		return $this->db->query($sql)->result();
	}

}