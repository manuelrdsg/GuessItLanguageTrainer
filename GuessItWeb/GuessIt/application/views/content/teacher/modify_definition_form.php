<?php

	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');

	echo '<div class="col-md-9">';

	$mysqli = $db;
	mysqli_query($mysqli,"SET NAMES 'utf8'");

	$sql = "SELECT id, palabra, articulo, frase, pista FROM definiciones WHERE id=".$definicion;

	$definition = mysqli_query($mysqli, $sql);

	echo form_open_multipart('index.php/Main/update_definition','class="form"');
	echo '<input type="hidden" class="form-control" name="gid" value="'.$id_grupo.'">';
	echo '<input type="hidden" class="form-control" name="lvl" value="'.$nivel.'">';
	echo '<input type="hidden" class="form-control" name="cat" value="'.$categoria.'">';
	foreach($definition as $row){
		echo '<input type="hidden" class="form-control" name="did" value="'.$row['id'].'">';
		echo '<div class="form-group">';
      			echo '<label class="control-label col-sm-2" for="word">Word:</label>';
      			echo '<div class="col-md-10">';
        			echo "<input type=\"text\" class=\"form-control\" name=\"word\" value='".$row['palabra']."'>";
      			echo '</div>';
    		echo '</div>';
		echo '<div class="form-group">';
      			echo '<label class="control-label col-sm-2" for="article">Article:</label>';
      			echo '<div class="col-md-10">';
        			echo "<input type=\"text\" class=\"form-control\" name=\"article\" value='".$row['articulo']."'>";
      			echo '</div>';
    		echo '</div>';
		echo '<div class="form-group">';
      			echo '<label class="control-label col-sm-2" for="sentence">Definition:</label>';
      			echo '<div class="col-md-10">';
        			echo "<input type=\"text\" class=\"form-control\" name=\"sentence\" value='".$row['frase']."'>";
      			echo '</div>';
    		echo '</div>';
		echo '<div class="form-group">';
      			echo '<label class="control-label col-sm-2" for="hint">Hint:</label>';
      			echo '<div class="col-md-10">';
        			echo "<input type=\"text\" class=\"form-control\" name=\"hint\" value='".$row['pista']."'>";
      			echo '</div>';
    		echo '</div>';
		
		echo '<div class="form-group">';
      			echo '<label class="control-label col-sm-2" for="image">Image:</label>';
      			echo '<div class="col-md-10">';
        			echo "<input type=\"file\" class=\"form-control\" name=\"image\" accept=\".bmp\" "'>";
      			echo '</div>';
    		echo '</div>';

		echo '<input type="submit" class="btn btn-primary" value="Save">';
	}

	echo form_close();

	mysqli_close($mysqli);

	echo '</div>';
?>
