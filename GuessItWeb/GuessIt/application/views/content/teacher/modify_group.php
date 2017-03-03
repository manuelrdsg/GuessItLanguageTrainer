<div class="col-md-9">
<?php 

	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');

	$mysqli = $db;
	$sql = "SELECT id, nombre FROM aula WHERE id = '".$id_grupo."'";
	mysqli_query($mysqli,"SET NAMES 'utf8'");
	$res = mysqli_query($mysqli, $sql);

	echo form_open('index.php/Main/update_group','class="form"');
    
	echo '<div class="form-group">';

      	echo '<label class="control-label col-sm-2" for="name">Group\'s name:</label>';

      	echo '<div class="col-sm-10">';
	
	echo '<input type="hidden" class="form-control" name="gid" value="'.$id_grupo.'">';
	
	foreach($res as $row){
        	echo '<input type="text" class="form-control" name="name" value="'.$row['nombre'].'">';
	}
      	echo '</div>';

    	echo '</div>';

	echo '<div class="form-group">';

      	echo '<label class="control-label col-sm-12" for="categories">Categories:</label>';

	$sql = "SELECT id, nombre FROM categoria WHERE id_aula = '".$id_grupo."'";
	$res = mysqli_query($mysqli, $sql);

	$numberCat = 1;
	foreach($res as $row){

		echo '<div class="col-sm-10">';

		$id_cat = "id_cat_".$numberCat;

		echo '<input type="hidden" name="'.$id_cat.'" value="'.$row['id'].'">';

		$name_cat = "name_cat_".$numberCat;

        	echo '<input type="text" class="form-control" name="'.$name_cat.'" value="'.$row['nombre'].'">';

      		echo '</div>';
		
		$numberCat = $numberCat + 1;

	}

	echo '<input type="hidden" name="cat_num" value="'.$numberCat.'">';
    	
	echo '</div>';
    
	echo '<div class="form-group">';        
      
	echo '<div class="col-sm-offset-2 col-sm-10">';
        
	echo '<button type="submit" class="btn btn-primary">Update</button>';
     
	echo '</div>';
    
	echo '</div>';
	
	form_close();

	mysqli_close($mysqli);

?>
</div>