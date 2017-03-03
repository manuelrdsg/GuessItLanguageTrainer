<?php

include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
    
	$mysqli = $db;
	mysqli_query($mysqli,"SET NAMES 'utf8'");
	$res = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE tipo=1 AND validar=0");
	echo form_open('index.php/Main/validate_teachers','class="form"');
	foreach($res as $row){
		echo '<div class="panel panel-info">';
			echo '<div class="panel-heading">';
				echo $row['nombre']." ".$row['apellidos'];
			echo '</div>';
			echo '<div class="panel-body">';
				echo "e-mail: ".$row['email'];
				echo '<br>';
				echo "joined: ".$row['alta'];
				echo '<br>';
				echo "center: ".$row['centro'];
				echo '<br>';
				echo 'validate: <input type="checkbox" name="profesores_validados[]" value="'.$row['id'].'">';
			echo '</div>';
		echo '</div>';
	}
	echo '<input type="submit" class="btn btn-primary" value="Validate">';
	
	echo form_close();
	mysqli_close($mysqli);
?>