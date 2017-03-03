<?php
    
	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
    
	$mysqli = $db;
	$sql = "SELECT id, nombre FROM aula WHERE activa = 1 AND id_docente = '".$id_docente."'";
	mysqli_query($mysqli,"SET NAMES 'utf8'");
	$res = mysqli_query($mysqli, $sql);
	
	echo form_open('index.php/Main/show_students_apport_list','class="form"');
	echo '<div class="form-group">';
	echo '<label class="control-label col-sm-2" for="name">Select Group:</label>';
	echo '<div class="col-sm-10">';
	echo '<select name="grupo_seleccionado">';
	foreach($res as $row){
		echo "<option value=".$row['id'].">".$row['nombre']."</option>";
	}
	echo '</select>';
	echo '<button type="submit" class="btn btn-primary">Go!</button>';
	echo '</div>';
	echo '</div>';
	echo form_close();
	mysqli_close($mysqli);
    
?>