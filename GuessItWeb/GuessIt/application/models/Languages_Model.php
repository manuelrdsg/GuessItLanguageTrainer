<?php

class Languages_Model extends CI_Model
{
	function store_language($data){
		$this->db->select('nombre');
		$this->db->where('nombre',$data['nombre']);
		$query = $this->db->get('idiomas');
		if($query->num_rows() == 0)
			$insert = $this->db->insert('idiomas',$data);
	}
	
	function delete_language($id){
		$this->db->where('id', $id);
		$this->db->delete('idiomas');
	}
	
	function modify_language($id, $data){
		$this->db->where('id', $id);
		$this->db->update('idiomas', $data);
	}
	
	function get_languages(){
		return $this->db->get('idiomas');
	}
}