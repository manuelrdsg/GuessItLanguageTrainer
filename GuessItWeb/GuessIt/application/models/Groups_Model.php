<?php

class Groups_Model extends CI_Model
{
	function add_group($data){
		$insert = $this->db->insert('aula',$data);
		if($insert){
			$this->db->select('id');
			$this->db->from('aula');
			$this->db->where('nombre',$data['nombre']);
			$this->db->where('id_docente',$data['id_docente']);
			$res = $this->db->get();
			return $res->row();
		}
	}
	
	function add_categorie($data){
		$insert = $this->db->insert('categoria',$data);
		return $insert;
	}
	
	function get_groups($data){
		$this->db->select('id');
		$this->db->from('aula');
		$this->db->where('id_docente',$data['id_docente']);
		$res = $this->db->get();
		return $res->row();
	}

	function update_group($id, $data){
		$this->db->where('id',$id);
		$this->db->update('aula',$data);
		return true;
	}

	function update_category($id, $data){
		$this->db->where('id',$id);
		$this->db->update('categoria',$data);
		return true;
	}
}