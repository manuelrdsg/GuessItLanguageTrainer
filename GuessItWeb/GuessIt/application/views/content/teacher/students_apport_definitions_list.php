<?php

echo '<div class="col-md-9">';

	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');

	$mysqli = $db;
	mysqli_query($mysqli,"SET NAMES 'utf8'");

	$sql = "SELECT usuarios.id AS id, usuarios.nombre AS nombre, usuarios.apellidos AS apellidos, usuarios.email AS email FROM usuarios WHERE usuarios.id = ".$id_usuario;

	$result_definitions = mysqli_query($mysqli, $sql);

	foreach($result_definitions as $row){
		echo '<h1>';
		echo $row['apellidos'].', '.$row['nombre'].'  <small>'.$row['email'].'</small>';
		echo '</h1>';
	}

	$sql = "SELECT definiciones.palabra AS palabra, definiciones.articulo AS articulo, definiciones.frase AS frase, definiciones.pista AS pista, definiciones.id_categoria AS catid, definiciones.fecha AS fecha, definiciones.nivel AS nivel FROM definiciones WHERE id_usuario = ".$id_usuario." AND id_aula = ".$id_grupo;

	$result_definitions = mysqli_query($mysqli, $sql); 

	foreach($result_definitions as $row){
		echo '<div class="panel panel-info">';
			echo '<div class="panel-heading">';
				echo $row['palabra'];
			echo '</div>';
			echo '<div class="panel-body">';
				$sql2 = "SELECT categoria.nombre AS nombre FROM categoria WHERE id = ".$row['catid'];
				$result_count = mysqli_query($mysqli, $sql2);
				foreach($result_count as $row2){
					echo '<b>Category: </b>'.$row2['nombre'];
					echo '<br>';
				}
				echo '<b>Article: </b>'.$row['articulo'];
				echo '<br>';
				echo '<b>Level: </b>'.$row['nivel'];
				echo '<br>';
				echo '<b>Definition: </b>'.$row['frase'];
				echo '<br>';
				echo '<b>Hint: </b>'.$row['pista'];
				echo '<br>';
				echo '<b>Date: </b>'.$row['fecha'];
				echo '<br>';
			echo '</div>';
		echo '</div>';
	}
	mysqli_close($mysqli);

echo '</div>';

?>