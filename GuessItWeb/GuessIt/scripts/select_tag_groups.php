<?php

include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
    
	$mysqli = $db;
	$res = mysqli_query($mysqli, "SELECT * FROM idiomas");

	if(count($res) > 0){
			echo '<select name="idioma">';
			foreach($res as $row){
					echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
			}
			echo '</select>';
	}
	
	mysqli_close($mysqli);
?>