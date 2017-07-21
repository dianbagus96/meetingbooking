<?php

Class m_profile extends CI_Model {

	function lihat_profil($id){
    	$sql = "select * 
      	from tb_user a
      	INNER JOIN tb_departemen b
      	ON a.id_departemen = b.id_departemen
      	where a.id_karyawan = '$id'";

    	return $this->db->query($sql)->result();
  	}

}

