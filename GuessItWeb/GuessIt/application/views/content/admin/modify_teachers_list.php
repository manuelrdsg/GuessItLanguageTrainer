<?php

echo '<div class="col-md-9">';
	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
	$mysqli = $db;
	mysqli_query($mysqli,"SET NAMES 'utf8'");

	$sql = "SELECT usuarios.id AS id, usuarios.nombre AS nombre, usuarios.apellidos AS apellidos, usuarios.email AS email, usuarios.alta AS fecha, usuarios.centro AS centro FROM usuarios WHERE usuarios.tipo = 1 AND usuarios.validar = 1 ORDER BY apellidos ASC";

	$result_definitions = mysqli_query($mysqli, $sql);

	foreach($result_definitions as $row){
		echo form_open('index.php/Main/show_modify_teachers_form','class="form"');
		echo '<input type="hidden" class="form-control" name="uid" value="'.$row['id'].'">';

		echo '<div class="panel panel-info">';
			echo '<div class="panel-heading">';
				echo $row['apellidos'].", ".$row['nombre'];
			echo '</div>';
			echo '<div class="panel-body">';
				echo '<b>Email: </b>'.$row['email'];
				echo '<br>';
				echo '<b>Joined: </b>'.$row['fecha'];
				echo '<br>';
				echo '<b>Institution: </b>'.$row['centro'];
				echo '<br>';
			echo '</div>';

		echo '<input type="submit" class="btn btn-primary" value="Modify">';
		echo '</div>';

		echo form_close();

	}
	mysqli_close($mysqli);

echo '</div>';

?>