<?php

		echo '<div class="col-md-9">';

		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');

		$mysqli = $db;
		mysqli_query($mysqli,"SET NAMES 'utf8'");

		echo '<div class="col-md-12"> <br> <br> </div>';

		echo form_open('index.php/Main/show_modify_definitions_list','class="form"');

		echo '<input type="hidden" class="form-control" name="gid" value="'.$id_grupo.'">';

		echo '<label class="control-label col-sm-2" for="level">Select the level:</label>';
		
		echo '<div class="col-md-2">';
		echo '<select name="nivel_seleccionado">';

			echo '<option value=1> Level 1 </option>';
			echo '<option value=2> Level 2 </option>';
			echo '<option value=3> Level 3 </option>';
			echo '<option value=4> Level 4 </option>';

		echo '</select>';
		echo '</div>';
		
		echo '<label class="control-label col-sm-2" for="level">Select category:</label>';

		echo '<div class="col-md-2">';

		$sql = "SELECT id, nombre FROM categoria WHERE id_aula =".$id_grupo." ORDER BY id ASC";
		$result_cat = mysqli_query($mysqli, $sql);

		echo '<select name="categoria_seleccionada">';

		foreach($result_cat as $row){
			echo '<option value='.$row['id'].'> '.$row['nombre'].' </option>';
		}

		echo '</select>';

		echo '</div>';

		echo '<div class="col-md-1">';
		
		echo '<input type="submit" class="btn btn-primary" value="Go!">';
		
		echo '</div>';

		echo form_close();

		mysqli_close($mysqli);
		echo '</div>';

?>