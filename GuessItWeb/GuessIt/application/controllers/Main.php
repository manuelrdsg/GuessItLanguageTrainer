<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller
{
	public function __construct(){
		parent::__construct();
	}
	
	function index(){
        	$this->show_login();
        	//$this->show_main();
	}
	
	//Funciones para mostrar vistas
	
	function show_login(){
		$this->load->view('login/login_view');
	}
	
	function show_register(){
		$this->load->view('login/login_register_view');
	}
	
	// %%%%%%%%%%%%%%%%%%%%%%%%%%%% ADMIN %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_main_admin(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('slave_menus/slave_menu_empty');
		$this->load->view('main/admin/footer');
	}
	
	// %%%%%%%%%%%%%%%% Teachers %%%%%%%%%%%%%%%%
	
	function show_slave_teacher_admin(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('slave_menus/admin/slave_menu_teacher');
		$this->load->view('main/admin/footer');
	}
	
	function show_add_teacher_admin(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('slave_menus/admin/slave_menu_teacher');
		$this->load->view('content/admin/add_teacher_view');
		$this->load->view('main/admin/footer');
	}
	
	function add_teacher(){
		$this->load->model('Login_Register_Model');
		$now = date("Y-m-d H:i:s");
		$data_to_store = array(
			'nombre' => $this->input->post('name'),
			'apellidos' => $this->input->post('lastname'),
			'email' => $this->input->post('email'),
			'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
			'centro' => $this->input->post('center'),
			'alta' => $now,
			'validar' => 1,
			'tipo' => 1
		);
		//if the insert has returned true then we show the flash message
		if ($this->Login_Register_Model->store_user($data_to_store)) {
			$data['flash_message'] = TRUE;
		} else {
			$data['flash_message'] = FALSE;
		}
		$this->show_add_teacher_admin();
	}
	
	function show_teacher_validate_admin(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('slave_menus/admin/slave_menu_teacher');
		$this->load->view('content/admin/teachers_validate');
		$this->load->view('main/admin/footer');
	}
	
	function validate_teachers(){
		$query = $this->input->post('profesores_validados');
		$this->load->model('Teacher_Model');
		foreach($query as $id_profesor){
			$this->Teacher_Model->teacher_validate($id_profesor);
		}
		$this->show_teacher_validate_admin();
	}

	function show_modify_teachers_list(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('slave_menus/admin/slave_menu_teacher');
		$this->load->view('content/admin/modify_teachers_list');
		$this->load->view('main/admin/footer');
	}

	function show_modify_teachers_form(){
		$teacher_id = $this->input->post('uid');
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_usuario' => $teacher_id
		);
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('slave_menus/admin/slave_menu_teacher');
		$this->load->view('content/admin/modify_teachers_form', $data);
		$this->load->view('main/admin/footer');
	}

	function update_teacher(){
		$teacher_id = $this->input->post('uid');
		$teacher_name = $this->input->post('name');
		$teacher_lastname = $this->input->post('apellidos');
		$teacher_email = $this->input->post('email');
		$teacher_center = $this->input->post('centro');
		$teacher_password = password_hash($this->input->post('password'),PASSWORD_DEFAULT);

		$data = array(
			'id' => $teacher_id,
			'nombre' => $teacher_name,
			'apellidos' => $teacher_lastname,
			'email' => $teacher_email,
			'password' => $teacher_password,
			'centro' => $teacher_center
		);
		$this->load->model('Login_Register_Model');
		$this->Login_Register_Model->update_user($data['id'],$data);
		
		$this->show_modify_teachers_list();
	}
	
	// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%% REPORTS %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_report_admin(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('reports/admin/report_select_group_students');
		$this->load->view('main/admin/footer');
	}

	function show_report_admin_form(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('reports/admin/report_select_group_students');
		$id_grupo = $this->input->post('grupo_seleccionado');
		$data = array(
			'id_grupo' => $id_grupo
		);
		$this->load->view('reports/admin/report_students', $data);
		$this->load->view('main/admin/footer');
	}

	function show_report_admin_students_result(){ // CAMBIAR
		$data = array(
			'id_grupo' => $this->input->post('gid'),
			'id_docente' => $this->input->post('uid'),
			'alumnos' => $this->input->post('alumnos_seleccionados'),
			'informe' => $this->input->post('informe_seleccionado'),
			'tipo' => $this->input->post('tipo'),
			'rango' => $this->input->post('rango'),
			'rango_ini' => $this->input->post('rango_ini'),
			'rango_fin' => $this->input->post('rango_fin'),
			'nivel' => $this->input->post('nivel_seleccionado')
		);
		if($data['tipo'] != 'csv'){
			$this->load->view('main/admin/header');
			$this->load->view('main/admin/side_menu');
			$this->load->view('reports/admin/report_select_group_students',$data);
			// Aqui el php de la grafica
			$this->load->view('reports/admin/report_students_result',$data);
		
			$this->load->view('main/admin/footer');
		}else{
			$this->load->view('reports/admin/report_students_result',$data);
		}
	}
	
	function show_report_definitions_admin(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('reports/admin/report_definitions');
		$this->load->view('main/admin/footer');
	}
	
	// %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%  Languages %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_languages_admin(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('slave_menus/admin/slave_menu_languages');
		$this->load->view('main/admin/footer');
	}
	
	function show_languages_add_admin(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('slave_menus/admin/slave_menu_languages');
		$this->load->view('content/admin/language_add');
		$this->load->view('main/admin/footer');
	}
	
	function show_languages_modify_admin(){
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('slave_menus/admin/slave_menu_languages');
		$this->load->view('content/admin/language_modify');
		$this->load->view('main/admin/footer');
	}
	
	function add_language(){
		$this->load->model('Languages_Model');
		$langname = $this->input->post('newLang');
		$datalang = array(
			'nombre' => $langname
		);
		$this->Languages_Model->store_language($datalang);
		$this->show_languages_add_admin();
	}
	
	// %%%%%%%%%%%%%%%%%%%%%%% PROFILE %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_profile_admin(){
		$this->load->model('Login_Register_Model');
		$res = $this->Login_Register_Model->get_teacher($this->session->userdata('email'));
		$result = $res->row();
		$data = array(
			'id' => $result->id,
			'nombre' => $result->nombre,
			'apellidos' => $result->apellidos,
			'email' => $result->email,
			'centro' => $result->centro
		);
		$this->load->view('main/admin/header');
		$this->load->view('main/admin/side_menu');
		$this->load->view('content/admin/profile', $data);
		$this->load->view('main/admin/footer');
	}
	
	// %%%%%%%%%%%%%%%%%%%%%%%%%% TEACHER %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_main_teacher(){
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/slave_menu_empty');
		$this->load->view('main/teacher/footer');
	}

	// %%%%%%%%%%%%%%%%%%%%%%%%%%% DEFINITIONS %%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_slave_definitions_teacher(){
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('main/teacher/footer');
	}

	// %%%%%%%%%%%%%%%%%%%%%%%% ADD DEFINITIONS %%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_add_definitions_teacher(){
		$this->load->model('Login_Register_Model');
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('content/teacher/select_group_definition',$data);
		$this->load->view('main/teacher/footer');
	}
	
	function add_definitions(){
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_definition',$data);
		$id_grupo = $this->input->post('grupo_seleccionado');
		$data = array(
			'id_grupo' => $id_grupo,
			'id_docente' => $id_profesor->id
		);
		$this->load->view('content/teacher/add_definitions_form',$data);
		$this->load->view('main/teacher/footer');
	}

	function store_definition(){
		$this->load->model('Teacher_Model');
		$now = date("Y-m-d H:i:s");

		$config['upload_path']   = $_SERVER['DOCUMENT_ROOT'].'/GuessIt/uploads'; 
        $config['allowed_types'] = 'png|bmp'; 
        $config['max_size']      = 2048; 
        $config['max_width']     = 1024; 
        $config['max_height']    = 768;  
		$config['file_name'] 	 = $this->input->post('word');
        $this->load->library('upload', $config);
		if( ! $this->upload->do_upload('image')) {
			print_r($this->upload->display_errors());
			echo '<div class="alert alert-warning"> <?php $this->upload->display_errors() ?> </div>';
		}


		$data_to_store = array(
			'nivel' => $this->input->post('level'),
			'palabra' => $this->input->post('word'),
			'articulo' => $this->input->post('article'),
			'frase' => $this->input->post('definition'),
			'pista' => $this->input->post('hint'),
			'id_categoria' => $this->input->post('categoria'),
			'id_aula' => $this->input->post('gid'),
			'id_usuario' => $this->input->post('uid'),
			'fecha' => $now,
			'validar' => 1,
			'imagen' =>  $config['upload_path'].'/'.$config['file_name']
		);
		$this->Teacher_Model->store_def($data_to_store);
		$this->add_definitions();
	}

	// %%%%%%%%%%%%%%%%%%%% IMPORT DEFINITIONS %%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_import_definitions_teacher(){
		$this->load->model('Login_Register_Model');
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('content/teacher/select_group_import',$data);
		$this->load->view('main/teacher/footer');
	}

	
	function show_import_definitions(){
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_import',$data);
		$id_grupo = $this->input->post('grupo_seleccionado');
		$images = $this->input->post('images');
		$data = array(
			'id_grupo' => $id_grupo,
			'id_docente' => $id_profesor->id,
			'images' => $images
		);

		if($images == 'true') {
			$this->load->view('content/teacher/import_images',$data);
		} else {
			$this->load->view('content/teacher/import_definitions',$data);
		}

		$this->load->view('main/teacher/footer');
	}


	function store_images() {

		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);

		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_import',$data);
		$this->load->view('content/teacher/import_success');


		$config['upload_path']   = $_SERVER['DOCUMENT_ROOT'].'/GuessIt/uploads/zip'; 
        $config['allowed_types'] = 'zip'; 
        //$config['max_size']      = 2048;  
		//$config['file_name'] 	 = $this->input->post('word');
        $this->load->library('upload', $config);
		if( ! $this->upload->do_upload('zip')) {
			print_r($this->upload->display_errors());
			echo '<div class="alert alert-warning"> <?php $this->upload->display_errors() ?> </div>';
		}
		$upload_data = $this->upload->data();

		$zip = new ZipArchive;
		$filename = $_SERVER['DOCUMENT_ROOT'].'/GuessIt/uploads/zip/'.$upload_data['file_name'];
		$res = $zip->open($filename);

		if($res==TRUE) {  
			$zip->extractTo($_SERVER['DOCUMENT_ROOT'].'/GuessIt/uploads');
			$zip->close();

			$convert_command = 'mogrify -format png '.$_SERVER['DOCUMENT_ROOT'].'/GuessIt/uploads/*';
			$script_delete = 'sh '.$_SERVER['DOCUMENT_ROOT'].'/GuessIt/scripts/delete.sh';

			exec($convert_command);
			echo exec($script_delete);
		}

		$id_grupo = $this->input->post('id_grupo');
		$id_docente = $this->input->post('id_docente');
		
		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		$mysqli = $db;
		mysqli_query($mysqli,"SET NAMES 'utf8'");

		$get_cat_sql = "SELECT * FROM categoria WHERE id_aula='".$id_grupo."'";
		$res_cat = mysqli_query($mysqli, $get_cat_sql);
		$fname = $_FILES['sel_file']['name'];
		$chk_ext = explode(".",$fname);
		if(strtolower(end($chk_ext)) == "csv"){
			$filename = $_FILES['sel_file']['tmp_name'];
			$handle = fopen($filename,'r');
			while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
				if(empty($data[0])){
					$data[0] = " ";
				}
				while($row = mysqli_fetch_assoc($res_cat)){
					if($row['nombre'] == $data[3]){
						$data[3] = $row['id'];
					}
				}
				

				if($data[5] == 'jpg') {
					$image = $_SERVER['DOCUMENT_ROOT'].'/GuessIt/uploads/'.$data[1];
				} else {
					$image = null;
				}

				$res_cat = mysqli_query($mysqli, $get_cat_sql);

				$now = date("Y-m-d H:i:s");
				$sql = "INSERT INTO definiciones (nivel, palabra, articulo, frase, pista, id_categoria, id_aula, id_usuario, fecha, validar, imagen) VALUES ('$data[2]','$data[1]','$data[0]','$data[4]','$data[5]','$data[3]','$id_grupo','$id_docente','$now','1','$image')";
				mysqli_query($mysqli, $sql);
			}
			
			fclose($handle);
		}
		mysqli_close($mysqli);


	}

	// %%%%%%%%%%%%%%% MODIFY DEFINITIONS %%%%%%%%%%%%%%%%%%

	function show_modify_definitions_teacher(){
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_definition_modify', $data);
		$this->load->view('main/teacher/footer');

	}

	function show_modify_definitions(){
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_definition_modify', $data);
		$id_grupo = $this->input->post('grupo_seleccionado');
		$data = array(
			'id_grupo' => $id_grupo,
			'id_docente' => $id_profesor->id
		);
		$this->load->view('content/teacher/modify_definitions', $data);
		$this->load->view('main/teacher/footer');
	}

	function show_modify_definitions_list(){
		$nivel = $this->input->post('nivel_seleccionado');
		$categoria = $this->input->post('categoria_seleccionada');

		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_definition_modify', $data);
		$id_grupo = $this->input->post('gid');
		$data = array(
			'id_grupo' => $id_grupo,
			'id_docente' => $id_profesor->id,
			'nivel' => $nivel,
			'categoria' => $categoria
		);
		$this->load->view('content/teacher/modify_definitions_list', $data);
		$this->load->view('main/teacher/footer');
	}

	function show_modify_definitions_form(){
		$definition_id = $this->input->post('did');
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id,
			'definicion' => $definition_id,
			'id_grupo' => $this->input->post('gid'),
			'nivel' => $this->input->post('lvl'),
			'categoria' => $this->input->post('cat')
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_definition_modify', $data);
		$this->load->view('content/teacher/modify_definition_form', $data);
		$this->load->view('main/teacher/footer');
	}

	function update_definition(){
		$definition_id = $this->input->post('did');
		$definition_word = $this->input->post('word');
		$definition_article = $this->input->post('article');
		$definition_sentence = $this->input->post('sentence');
		$definition_hint = $this->input->post('hint');
		$id_grupo = $this->input->post('gid');
		$nivel = $this->input->post('lvl');
		$categoria = $this->input->post('cat');
		
		$config['upload_path']   = $_SERVER['DOCUMENT_ROOT'].'/GuessIt/uploads'; 
        $config['allowed_types'] = 'png|bmp'; 
        $config['max_size']      = 2048; 
        $config['max_width']     = 1024; 
        $config['max_height']    = 768;  
		$config['file_name'] 	 = $this->input->post('word');
		$config['overrite'] 	 = true;
        $this->load->library('upload', $config);
		if( ! $this->upload->do_upload('image')) {
			print_r($this->upload->display_errors());
			echo '<div class="alert alert-warning"> <?php $this->upload->display_errors() ?> </div>';
		}

		$image =  $config['upload_path'].'/'.$config['file_name'];
		

		$data = array(
			'id' => $definition_id,
			'palabra' => $definition_word,
			'articulo' => $definition_article,
			'frase' => $definition_sentence,
			'pista' => $definition_hint,
			'imagen' => $image
		);
		$this->load->model('Teacher_Model');
		$this->Teacher_Model->update_def($data);
		
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id,
			'id_grupo' => $id_grupo,
			'nivel' => $nivel,
			'categoria' => $categoria
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_definition_modify', $data);
		$this->load->view('content/teacher/modify_definitions_list', $data);
		$this->load->view('main/teacher/footer');
	}

		// %%%%%%%%%%%%%%%%%%% REVIEW REPORTS %%%%%%%%%%%%%%%%%%%%%%%

	function show_definition_review_teacher(){
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_definition_review', $data);
		$this->load->view('main/teacher/footer');	
	}

	function show_definition_review_list(){
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_definition_review', $data);
		$id_grupo = $this->input->post('grupo_seleccionado');
		$data = array(
			'id_grupo' => $id_grupo,
			'id_docente' => $id_profesor->id
		);
		$this->load->view('content/teacher/review_definitions', $data);
		$this->load->view('main/teacher/footer');
	}

	function review_report(){
		$query = $this->input->post('pid');
		$review = $this->input->post('correccion');
		$this->load->model('Teacher_Model');
		//var_dump($query);
		//var_dump($review);
		for($i = 0 ; $i < count($query) ; $i++ ){
			$this->Teacher_Model->update_review($query[$i], $review[$i]);
		}
		$this->show_definition_review_teacher();
	}

		// %%%%%%%%%%%%%%%%%%% STUDENTS DEFINITIONS %%%%%%%%%%%%%%%%%%%%%%%%%%

	function show_students_apport_teacher(){
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_students_apport', $data);
		$this->load->view('main/teacher/footer');

	}

	function show_students_apport_list(){
		$id_grupo = $this->input->post('grupo_seleccionado');

		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_students_apport', $data);
		$data = array(
			'id_grupo' => $id_grupo
		);
		$this->load->view('content/teacher/students_apport_list', $data);
		$this->load->view('main/teacher/footer');
	}

	function show_students_apport_definitions_list(){
		$student_id = $this->input->post('uid');
		$group_id = $this->input->post('gid');
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id,
			'id_grupo' => $group_id,
			'id_usuario' => $student_id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_definition');
		$this->load->view('content/teacher/select_group_students_apport', $data);
		$this->load->view('content/teacher/students_apport_definitions_list', $data);
		$this->load->view('main/teacher/footer');
	}

	// %%%%%%%%%%%%%%% REPORTS %%%%%%%%%%%%%%%%%%%
	
	function show_report_teacher(){
		$this->load->model('Login_Register_Model');
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('reports/teacher/report_select_group_students',$data);
		//$this->load->view('reports/teacher/report_students');
		$this->load->view('main/teacher/footer');
	}
	
	function show_report_teacher_generate(){
		$this->load->model('Login_Register_Model');
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('reports/teacher/report_select_group_students',$data);
		$id_grupo = $this->input->post('grupo_seleccionado');
		$data = array(
			'id_grupo' => $id_grupo,
			'id_docente' => $id_profesor->id
		);
		$this->load->view('reports/teacher/report_students',$data);
		$this->load->view('main/teacher/footer');
	}
	
	function show_report_teacher_result(){
		$data = array(
			'id_grupo' => $this->input->post('gid'),
			'id_docente' => $this->input->post('uid'),
			'alumnos' => $this->input->post('alumnos_seleccionados'),
			'informe' => $this->input->post('informe_seleccionado'),
			'tipo' => $this->input->post('tipo'),
			'rango' => $this->input->post('rango'),
			'rango_ini' => $this->input->post('rango_ini'),
			'rango_fin' => $this->input->post('rango_fin'),
			'nivel' => $this->input->post('nivel_seleccionado')
		);
		if($data['tipo'] != 'csv'){
			$this->load->view('main/teacher/header');
			$this->load->view('main/teacher/side_menu');
			$this->load->view('reports/teacher/report_select_group_students',$data);
			// Aqui el php de la grafica
			$this->load->view('reports/teacher/report_students_result',$data);
		
			$this->load->view('main/teacher/footer');
		}else{
			$this->load->view('reports/teacher/report_students_result',$data);
		}		
	}
	
	function show_report_definitions_teacher(){
		$this->load->model('Login_Register_Model');
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('reports/teacher/report_select_group_definitions',$data);
		$this->load->view('reports/teacher/report_definitions');
		$this->load->view('main/teacher/footer');
	}

	// %%%%%%%%%%%%%%%%%%%%%%% STUDENTS %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_slave_students_teacher(){
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_students');
		$this->load->view('main/teacher/footer');
	}
	
	function show_add_student_teacher(){
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_students');
		$this->load->view('content/teacher/add_student');
		$this->load->view('main/teacher/footer');
	}
	
	function show_validate_student_teacher(){
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_students');
		$this->load->view('content/teacher/select_group_student',$data);
		$this->load->view('main/teacher/footer');
	}
	
	function validate_student(){
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_students');
		$this->load->view('content/teacher/select_group_student',$data);
		$id_grupo = $this->input->post('grupo_seleccionado');
		$data = array(
			'id_grupo' => $id_grupo
		);
		$this->load->view('content/teacher/validate_students',$data);
		$this->load->view('main/teacher/footer');
	}
	
	function validate_student_form(){
		$query = $this->input->post('estudiantes_validados');
		$id_grupo = $this->input->post('gid');
		$this->load->model('Teacher_Model');
		foreach($query as $id_alumno){
			$this->Teacher_Model->student_validate($id_alumno, $id_grupo);
		}
		$this->show_validate_student_teacher();
	}
	
	function add_student(){
		$this->load->model('Login_Register_Model');
		$now = date("Y-m-d H:i:s");
		$data_to_store = array(
			'nombre' => $this->input->post('name'),
			'apellidos' => $this->input->post('lastname'),
			'usuario' => $this->input->post('username'),
			'email' => $this->input->post('email'),
			'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
			'alta' => $now,
			'validar' => 1,
			'tipo' => 0
		);
		//if the insert has returned true then we show the flash message
		if ($this->Login_Register_Model->store_user($data_to_store)) {
			$data['flash_message'] = TRUE;
		} else {
			$data['flash_message'] = FALSE;
		}
		$this->show_add_student_teacher();
	}

	// %%%%%%%%%%%%%%%%%%% MODIFY STUDENTS %%%%%%%%%%%%%%%%%%%%%%%%%%%%

	function show_modify_students_teacher(){
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_students');
		$this->load->view('content/teacher/select_group_student_modify', $data);
		$this->load->view('main/teacher/footer');

	}

	function show_modify_students_list(){
		$id_grupo = $this->input->post('grupo_seleccionado');

		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_students');
		$this->load->view('content/teacher/select_group_student_modify', $data);
		$data = array(
			'id_grupo' => $id_grupo
		);
		$this->load->view('content/teacher/modify_students_list', $data);
		$this->load->view('main/teacher/footer');
	}

	function show_modify_students_form(){
		$student_id = $this->input->post('uid');
		$group_id = $this->input->post('gid');
		$this->load->model('Login_Register_Model');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id,
			'id_grupo' => $group_id,
			'id_usuario' => $student_id
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_students');
		$this->load->view('content/teacher/select_group_student_modify', $data);
		$this->load->view('content/teacher/modify_student_form', $data);
		$this->load->view('main/teacher/footer');
	}

	function update_student(){
		$student_id = $this->input->post('uid');
		$student_name = $this->input->post('name');
		$student_lastname = $this->input->post('apellidos');
		$student_email = $this->input->post('email');
		$student_username = $this->input->post('username');
		$student_password = password_hash($this->input->post('password'),PASSWORD_DEFAULT);
		$id_grupo = $this->input->post('gid');

		$data = array(
			'id' => $student_id,
			'nombre' => $student_name,
			'apellidos' => $student_lastname,
			'email' => $student_email,
			'usuario' => $student_username,
			'password' => $student_password
		);
		$this->load->model('Login_Register_Model');
		$this->Login_Register_Model->update_user($data['id'],$data);
		
		
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id,
			'id_grupo' => $id_grupo
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_students');
		$this->load->view('content/teacher/select_group_student_modify', $data);
		$this->load->view('content/teacher/modify_students_list', $data);
		$this->load->view('main/teacher/footer');
	}

	// %%%%%%%%%%%%%%%%%%%%%% GROUPS %%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_slave_classroom_teacher(){
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_classroom');
		$this->load->view('main/teacher/footer');
	}
	
	function show_add_classroom_teacher(){
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_classroom');
		$this->load->view('content/teacher/add_class');
		$this->load->view('main/teacher/footer');
	}
	
	function add_class(){
		$this->load->model('Groups_Model');
		$this->load->model('Login_Register_Model');
		$groupname = $this->input->post('gname');
		$id_idioma = $this->input->post('idioma');
		$split_categoria = $this->input->post('categories');
		
		$categorias = array();
		
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		
		$data = array(
			'nombre' => $groupname,
			'id_idioma' => $id_idioma,
			'activa' => 1,
			'id_docente' => $id_profesor->id
		);
		
		$aula = $this->Groups_Model->add_group($data);
		$id_aula = $aula->id;
		$tok = strtok($split_categoria,",");
		while($tok !== false){
			$categorias[] = $tok;
			//echo $tok;
			$data_cat = array(
				'nombre' => $tok,
				'id_aula' => $id_aula
			);
			$this->Groups_Model->add_categorie($data_cat);
			$tok = strtok(",");
		}
		
		$this->show_add_classroom_teacher();
	}
	
	function show_add_classroom_add_cat_teacher(){
		$this->load->model('Login_Register_Model');
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_classroom');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('content/teacher/select_group_category',$data);
		$this->load->view('main/teacher/footer');
	}
	
	function show_add_category_teacher(){
		$this->load->model('Login_Register_Model');
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_classroom');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);

        	$this->load->view('content/teacher/select_group_category',$data);
        	$id_grupo = $this->input->post('grupo_seleccionado');
		$data_grupo = array(
                      'id_grupo' => $id_grupo
                      );
		$this->load->view('content/teacher/add_category',$data_grupo);
		$this->load->view('main/teacher/footer');
	}
    
    function add_category(){
        $this->load->model('Groups_Model');
        $split_categoria = $this->input->post('categories');
        $id_aula = $this->input->post('aula');
        
        $tok = strtok($split_categoria,",");
		while($tok !== false){
			$categorias[] = $tok;
			//echo $tok;
			$data_cat = array(
                              'nombre' => $tok,
                              'id_aula' => $id_aula
                              );
			$this->Groups_Model->add_categorie($data_cat);
			$tok = strtok(",");
		}
        $this->show_add_classroom_add_cat_teacher();
    }
	
	function show_group_modify_teacher(){
		$this->load->model('Login_Register_Model');
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_classroom');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);
		$this->load->view('content/teacher/select_group_modify_group',$data);
		$this->load->view('main/teacher/footer');
	}

	function show_group_modify_teacher_form(){
		$this->load->model('Login_Register_Model');
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		$this->load->view('slave_menus/teacher/slave_menu_classroom');
		$id_profesor = $this->Login_Register_Model->get_teacher_id($this->session->userdata('email'));
		$data = array(
			'id_docente' => $id_profesor->id
		);

        	$this->load->view('content/teacher/select_group_modify_group',$data);
        	$id_grupo = $this->input->post('grupo_seleccionado');
		$data_grupo = array(
                      'id_grupo' => $id_grupo
                      );
		$this->load->view('content/teacher/modify_group',$data_grupo);
		$this->load->view('main/teacher/footer');
	}

	function update_group(){
		$this->load->model('Groups_Model');
		$group_name = $this->input->post('name');
		$group_id = $this->input->post('gid');
		
		$data = array(
			'nombre' => $group_name
		);
		$this->Groups_Model->update_group($group_id, $data);

		$cat_number = $this->input->post('cat_num');
		for($i = 1; $i <= $cat_number; $i++){
			$id_category = "id_cat_".$i;
			$name_category = "name_cat_".$i;
			$id = $this->input->post($id_category);
			$data = array(
				'nombre' => $this->input->post($name_category)
			);
			$this->Groups_Model->update_category($id,$data);
		}

		$this->show_group_modify_teacher();
	}

	// %%%%%%%%%%%%%%%%%%%%%%%%%% PROFILE %%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	
	function show_profile_teacher(){
		$this->load->model('Login_Register_Model');
		$res = $this->Login_Register_Model->get_teacher($this->session->userdata('email'));
		$result = $res->row();
		$data = array(
			'id' => $result->id,
			'nombre' => $result->nombre,
			'apellidos' => $result->apellidos,
			'email' => $result->email,
			'centro' => $result->centro
		);
		$this->load->view('main/teacher/header');
		$this->load->view('main/teacher/side_menu');
		//$this->load->view('slave_menus/teacher/slave_menu_students');
		$this->load->view('content/teacher/profile',$data);
		$this->load->view('main/teacher/footer');
	}
	
	// %%%%%%%%%%%%%%%%%%%%%%%% OTHERS %%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
	//Funciones de registro, login, cerrar sesion
	
	function input_login_user(){
        
		// Create an instance of the user model
		$this->load->model('Login_Register_Model');
		
		// Grab the email and password from the form POST
		$email = $this->input->post('email');
		$pass  = $this->input->post('password');
		
		//Ensure values exist for email and pass, and validate the user's credentials
		if ($email && $pass) {
			// If the user is valid, redirect to the main view
			if($this->Login_Register_Model->validate_user($email, $pass) == 2){
				$data = array(
					'email' => $email,
					'isLoggedIn' => true,
					'per_page' => 20
				);
				$this->session->set_userdata($data);
				$this->session->set_userdata($data);
				$this->show_main_admin();
			}else{
				if($this->Login_Register_Model->validate_user($email, $pass) == 1){
					$data = array(
						'email' => $email,
						'isLoggedIn' => true,
						'per_page' => 20
					);
					$this->session->set_userdata($data);
					$this->session->set_userdata($data);
					$this->show_main_teacher();
				} else {
					$this->index();
					echo '<div class="alert alert-danger"> <strong>Something gone wrong.</strong> Check your info. </div>';
				}
			}
		} else {
		// Otherwise show the login screen with an error message.
			$this->index();
		}
	}
	






	function input_register(){
		$this->load->model('Login_Register_Model');
		$now = date("Y-m-d H:i:s");
		$data_to_store = array(
			'nombre' => $this->input->post('name'),
			'apellidos' => $this->input->post('lastname'),
			'email' => $this->input->post('email'),
			'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
			'centro' => $this->input->post('center'),
			'alta' => $now,
			'tipo' => 1
		);
		//if the insert has returned true then we show the flash message
		if ($this->Login_Register_Model->store_user($data_to_store)) {
			$data['flash_message'] = TRUE;
		} else {
			$data['flash_message'] = FALSE;
		}
		$this->index();
	}
	
	function update_user(){
		$this->load->model('Login_Register_Model');
		$data = array(
			'nombre' => $this->input->post('name'),
			'apellidos' => $this->input->post('lastname'),
			'email' => $this->input->post('email'),
			'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
			'centro' => $this->input->post('center')
		);
		if($this->Login_Register_Model->update_user($this->Login_Register_Model->get_teacher_id($this->session->userdata('email'))->id,$data)){
			
		}
		$this->show_profile_teacher();
	}

	function update_admin(){
		$this->load->model('Login_Register_Model');
		$data = array(
			'nombre' => $this->input->post('name'),
			'apellidos' => $this->input->post('lastname'),
			'email' => $this->input->post('email'),
			'password' => password_hash($this->input->post('password'),PASSWORD_DEFAULT),
			'centro' => $this->input->post('center')
		);
		if($this->Login_Register_Model->update_user($this->Login_Register_Model->get_teacher_id($this->session->userdata('email'))->id,$data)){
			
		}
		$this->show_profile_admin();
	}
	
	function logout_user(){
		$this->session->sess_destroy();
		$this->index();
	}
}
