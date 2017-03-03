<?php

include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
    
	$mysqli = $db;
	mysqli_query($mysqli,"SET NAMES 'utf8'");
	$res = mysqli_query($mysqli, "SELECT * FROM categoria WHERE id_aula='".$id_grupo."'");
	echo '<div class="form-group">';
    echo '<label class="control-label col-sm-2" for="hint">Category:</label>';
    echo '<div class="col-sm-10">';
	if(count($res) > 0){
			echo '<select name="categoria">';
			foreach($res as $row){
					echo '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
			}
			echo '</select>';
	}
	echo '</div>';
    echo '</div>';
	echo '<div class="form-group">';
	//echo '<label class="control-label col-sm-2" for="gid">Group ID:</label>';
	echo '<div class="col-sm-10">';
	echo '<input type="hidden" class="form-control" name="gid" value="'.$id_grupo.'">';
	echo '</div>';
	echo '</div>';
	
	echo '<div class="form-group">';
	//echo '<label class="control-label col-sm-2" for="uid">User ID:</label>';
	echo '<div class="col-sm-10">';
	echo '<input type="hidden" class="form-control" name="uid" value="'.$id_docente.'">';
	echo '</div>';
	echo '</div>';
	
	mysqli_close($mysqli);
?>