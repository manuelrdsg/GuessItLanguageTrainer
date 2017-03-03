<?php

include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
    
	$mysqli = $db;
	$sql = "SELECT usuarios.id as id, usuarios.nombre as nombre, usuarios.apellidos as apellidos FROM usuarios, usuarios_aula WHERE usuarios.id = usuarios_aula.id_usuario AND usuarios_aula.validar = 1 AND usuarios_aula.id_aula = ".$id_grupo." ORDER BY apellidos";
	mysqli_query($mysqli,"SET NAMES 'utf8'");
	$res = mysqli_query($mysqli, $sql);
	
	foreach($res as $row){
		echo "<option value=".$row['id'].">".$row['apellidos'].", ".$row['nombre']."</option>";
	}
	
	mysqli_close($mysqli);

?>