<?php

class Login_Register_Model extends CI_Model
{
	var $details;
	
	function validate_user($email, $password){
		// Build a query to retrieve the user's details
		// based on the received username and password
		$this->db->from('usuarios');
		$this->db->where('email', $email);
		$query = $this->db->get();
		        
		// If one row is returned
		if ($query->num_rows() == 1) {
				// Check if password is correct
			$user = $query->row();
	       		if (password_verify($password, $user->password)) {
		        // user authentication details are correct
					// Set the users details into the $details property of this class
					$this->details = $user;
					// Call set_session to set the user's session vars via CodeIgniter
					$this->set_session();
					if($user->tipo == 1){
						return 1;
					}
					if($user->tipo == 2){
						return 2;
					}
		    }
        	}
		return 0;
	}
	
	function set_session(){
		// session->set_userdata is a CodeIgniter function that
		// stores data in CodeIgniter's session storage.  Some of the values are built in
		// to CodeIgniter, others are added.  See CodeIgniter's documentation for details.
		$this->session->set_userdata(array(
		    'id' => $this->details->id,
		    'nombre' => $this->details->nombre,
		    'email' => $this->details->email,
		    'isLoggedIn' => true
		));
	}
	
	function update_user_old($id, $data){
		$this->db->where('id', $id);
		$this->db->update('usuario4', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}
	
	function delete_user($id){
		//echo $id;
		$this->db->where('id', $id);
		$this->db->delete('usuario4'); 
	}
	
	function store_user($data){
		$insert = $this->db->insert('usuarios', $data);
	    	return $insert;
	}
	
	function update_user($id, $data){
		$this->db->where('id',$id);
		$this->db->update('usuarios',$data);
		return true;
	}
	
	function get_user(){
		$userdata['id'] = $this->details->id;
		$userdata['name'] = $this->details->nombre_usuario;
		return $userdata;
	}
	
	function get_teacher_id($email){
		$this->db->select('id');
		$this->db->from('usuarios');
		$this->db->where('email',$email);
		$res = $this->db->get();
		return $res->row();
	}
	
	function get_teacher($email){
		$this->db->from('usuarios');
		$this->db->where('email',$email);
		$res = $this->db->get();
		return $res;
	}
}
