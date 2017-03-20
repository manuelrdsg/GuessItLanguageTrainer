
<?php 
    //include('scripts/import_definitions.php');

		$id_grupo = $this->input->post('id_grupo');
		$id_docente = $this->input->post('id_docente');

		$mysqli = $db;
		mysqli_query($mysqli,"SET NAMES 'utf8'");

		$get_cat_sql = "SELECT * FROM categoria WHERE id_aula='".$id_grupo."'";
		$res_cat = mysqli_query($mysqli, $get_cat_sql);
		$fname = $_FILES['sel_file']['name'];
		//echo 'upload file name: '.$fname.'<br>';
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

			echo '<div class="alert alert-success"> <strong>TEST</strong> </div>';
            $imp_images = true;
		}
		mysqli_close($mysqli);
	}
   
?>