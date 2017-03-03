<?php

class Teacher_Model extends CI_Model
{

	function teacher_validate($id){
		$update_sql = "UPDATE usuarios SET validar=1 WHERE id=".$id;
		$this->db->query($update_sql);
	}
	
	function student_validate($id, $id_grupo){
		$update_sql = "UPDATE usuarios_aula SET validar=1 WHERE id_usuario=".$id;
		$update_data = array('validar'=>'1');
		$this->db->where('id_usuario',$id);
		$this->db->where('id_aula', $id_grupo);
		$this->db->where('validar' , '0');
		$this->db->update('usuarios_aula',$update_data);
		//$this->db->query($update_sql);
	}
	
	function store_def($data){
		$insert = $this->db->insert('definiciones', $data);
	    	return $insert;
	}

	function update_def($data){
		$this->db->where('id',$data['id']);
		$this->db->update('definiciones',$data);
	}

	function update_review($id, $review){
		$update_sql = "UPDATE puntuaciones SET revision = ".$review." WHERE id=".$id;
		$update_data = array('revision'=>$review);
		$this->db->where('id',$id);
		$this->db->update('puntuaciones',$update_data);
		//$this->db->query($update_sql);
	}

}