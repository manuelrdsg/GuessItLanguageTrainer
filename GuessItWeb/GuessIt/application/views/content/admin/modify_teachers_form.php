<?php
	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
	echo '<div class="col-md-9">';

	$mysqli = $db;
	mysqli_query($mysqli,"SET NAMES 'utf8'");

	$sql = "SELECT id, nombre, apellidos, email, centro FROM usuarios WHERE id=".$id_usuario;

	$student = mysqli_query($mysqli, $sql);

	echo form_open('index.php/Main/update_teacher','class="form"');
	foreach($student as $row){
		echo '<input type="hidden" class="form-control" name="uid" value="'.$row['id'].'">';
		echo '<div class="form-group">';
      			echo '<label class="control-label col-sm-2" for="name">Name:</label>';
      			echo '<div class="col-md-10">';
        			echo "<input type=\"text\" class=\"form-control\" name=\"name\" value='".$row['nombre']."'>";
      			echo '</div>';
    		echo '</div>';
		echo '<div class="form-group">';
      			echo '<label class="control-label col-sm-2" for="apellidos">Lastname:</label>';
      			echo '<div class="col-md-10">';
        			echo "<input type=\"text\" class=\"form-control\" name=\"apellidos\" value='".$row['apellidos']."'>";
      			echo '</div>';
    		echo '</div>';
		echo '<div class="form-group">';
      			echo '<label class="control-label col-sm-2" for="email">Email:</label>';
      			echo '<div class="col-md-10">';
        			echo "<input type=\"text\" class=\"form-control\" name=\"email\" value='".$row['email']."'>";
      			echo '</div>';
    		echo '</div>';
		echo '<div class="form-group">';
      			echo '<label class="control-label col-sm-2" for="centro">Institution:</label>';
      			echo '<div class="col-md-10">';
        			echo "<input type=\"text\" class=\"form-control\" name=\"centro\" value='".$row['centro']."'>";
      			echo '</div>';
    		echo '</div>';
		echo '<div class="form-group">';
      			echo '<label class="control-label col-sm-2" for="password">Password:</label>';
      			echo '<div class="col-md-10">';
        			echo "<input type=\"password\" class=\"form-control\" name=\"password\" value=''>";
      			echo '</div>';
    		echo '</div>';
		echo '<input type="submit" class="btn btn-primary" value="Save">';
	}

	echo form_close();

	mysqli_close($mysqli);

	echo '</div>';
?>