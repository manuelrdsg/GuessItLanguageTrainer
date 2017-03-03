<?php
    
include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
    
	$mysqli = $db;
	$sql = "SELECT usuarios.id AS id, usuarios.nombre AS nombre, usuarios.apellidos AS apellidos FROM usuarios, usuarios_aula WHERE usuarios.id = usuarios_aula.id_usuario AND usuarios_aula.id_aula = 14";
	mysqli_query($mysqli,"SET NAMES 'utf8'");
	$res = mysqli_query($mysqli, $sql);
	
	foreach($res as $row){
		$sql = "select count(definiciones.id) AS cantidad from definiciones where definiciones.id in(select puntuaciones.id_palabra from puntuaciones where puntuaciones.id_usuario = ".$row['id'].")";
		$res2 = mysqli_query($mysqli, $sql);
		foreach($res2 as $row2){
			echo $row['nombre']." ".$row['apellidos']." - ".$row2['cantidad']/1020;
			echo '<br>';
		}
	}
	echo form_close();
	mysqli_close($mysqli);
    
?>