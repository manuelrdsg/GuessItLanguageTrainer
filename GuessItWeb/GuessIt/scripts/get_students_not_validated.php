<?php

include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
    
	$mysqli = $db;
	mysqli_query($mysqli,"SET NAMES 'utf8'");
	$sql = "SELECT usuarios.id, usuarios.nombre, usuarios.apellidos, usuarios.email, usuarios.alta FROM usuarios, usuarios_aula WHERE usuarios.id = usuarios_aula.id_usuario AND usuarios_aula.validar=0 AND id_aula='".$id_grupo."'";
	//echo $sql;
	$res = mysqli_query($mysqli, $sql);
	echo form_open('index.php/Main/validate_student_form','class="form"');
	echo '<input type="hidden" class="form-control" name="gid" value="'.$id_grupo.'">';
	foreach($res as $row){
		echo '<div class="panel panel-info">';
			echo '<div class="panel-heading">';
				echo $row['nombre']." ".$row['apellidos'];
			echo '</div>';
			echo '<div class="panel-body">';
				echo "<b>e-mail: </b>".$row['email'];
				echo '<br>';
				echo "<b>joined: </b>".$row['alta'];
				echo '<br>';
				echo '<b>validate: </b><input type="checkbox" name="estudiantes_validados[]" value="'.$row['id'].'">';
			echo '</div>';
		echo '</div>';
	}
	echo '<input type="submit" class="btn btn-primary" value="Validate">';
	
	echo form_close();
	mysqli_close($mysqli);
?>