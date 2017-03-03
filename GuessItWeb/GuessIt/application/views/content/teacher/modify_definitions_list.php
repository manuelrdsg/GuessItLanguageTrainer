<?php

echo '<div class="col-md-9">';

	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');

	$mysqli = $db;
	mysqli_query($mysqli,"SET NAMES 'utf8'");

	$sql = "SELECT id, palabra, articulo, frase, pista FROM definiciones WHERE id_usuario = ".$id_docente." AND id_aula = ".$id_grupo." AND nivel = ".$nivel." AND id_categoria = ".$categoria;

	$result_definitions = mysqli_query($mysqli, $sql);

	foreach($result_definitions as $row){
		echo form_open('index.php/Main/show_modify_definitions_form','class="form"');
		echo '<input type="hidden" class="form-control" name="did" value="'.$row['id'].'">';
		echo '<input type="hidden" class="form-control" name="gid" value="'.$id_grupo.'">';
		echo '<input type="hidden" class="form-control" name="lvl" value="'.$nivel.'">';
		echo '<input type="hidden" class="form-control" name="cat" value="'.$categoria.'">';

		echo '<div class="panel panel-info">';
			echo '<div class="panel-heading">';
				echo $row['palabra'];
			echo '</div>';
			echo '<div class="panel-body">';
				echo '<b>Article: </b>'.$row['articulo'];
				echo '<br>';
				echo '<b>Definition: </b>'.$row['frase'];
				echo '<br>';
				echo '<b>Hint: </b>'.$row['pista'];
				echo '<br>';
			echo '</div>';
		echo '</div>';

		echo '<input type="submit" class="btn btn-primary" value="Modify">';

		echo form_close();

	}
	mysqli_close($mysqli);

echo '</div>';

?>