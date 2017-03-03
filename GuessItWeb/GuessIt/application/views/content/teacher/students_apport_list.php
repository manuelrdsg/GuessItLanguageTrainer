<?php

echo '<div class="col-md-9">';

	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');

	$mysqli = $db;
	mysqli_query($mysqli,"SET NAMES 'utf8'");

	$sql = "SELECT usuarios.id AS id, usuarios.nombre AS nombre, usuarios.apellidos AS apellidos, usuarios.email AS email, usuarios.usuario AS usuario, usuarios.alta AS fecha FROM usuarios, usuarios_aula WHERE usuarios.id = usuarios_aula.id_usuario AND usuarios_aula.id_aula = ".$id_grupo." AND usuarios_aula.validar = 1 ORDER BY apellidos ASC";

	$result_definitions = mysqli_query($mysqli, $sql);

	foreach($result_definitions as $row){
		echo form_open('index.php/Main/show_students_apport_definitions_list','class="form"');
		echo '<input type="hidden" class="form-control" name="uid" value="'.$row['id'].'">';
		echo '<input type="hidden" class="form-control" name="gid" value="'.$id_grupo.'">';

		echo '<div class="panel panel-info">';
			echo '<div class="panel-heading">';
				echo $row['apellidos'].", ".$row['nombre'];
			echo '</div>';
			echo '<div class="panel-body">';
				echo '<b>Email: </b>'.$row['email'];
				echo '<br>';
				$sql2 = "SELECT count(*) AS cantidad FROM definiciones WHERE id_usuario = ".$row['id']." AND id_aula = ".$id_grupo;
				$result_count = mysqli_query($mysqli, $sql2);
				foreach($result_count as $row2){
					echo '<b>Number of definitions: </b>'.$row2['cantidad'];
					echo '<br>';
				}
			echo '</div>';

		echo '<input type="submit" class="btn btn-primary" value="View definitions">';
		echo '</div>';

		echo form_close();

	}
	mysqli_close($mysqli);

echo '</div>';

?>