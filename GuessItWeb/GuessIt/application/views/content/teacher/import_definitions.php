<div class="col-md-9">
	<?php

	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
	
	if(isset($_POST['submit'])){
		$id_grupo = $_POST['id_grupo'];
		$id_docente = $_POST['id_docente'];

		$mysqli = $db;
		mysqli_query($mysqli,"SET NAMES 'utf8'");
		//mysql_query("SET NAMES 'utf8'");
		$get_cat_sql = "SELECT * FROM categoria WHERE id_aula='".$id_grupo."'";
		$res_cat = mysqli_query($mysqli, $get_cat_sql);
		$fname = $_FILES['sel_file']['name'];
		//echo 'upload file name: '.$fname.'<br>';
		$chk_ext = explode(".",$fname);
		if(strtolower(end($chk_ext)) == "csv"){
			$filename = $_FILES['sel_file']['tmp_name'];
			$handle = fopen($filename,'r');
			while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
				if(empty($data[0])){
					$data[0] = " ";
				}
				while($row = mysqli_fetch_assoc($res_cat)){
					if($row['nombre'] == $data[3]){
						$data[3] = $row['id'];
					}
				}
				$res_cat = mysqli_query($mysqli, $get_cat_sql);
				//echo $data[0]."$".$data[1]."$".$data[2]."$".$data[3]."$".$data[4]."$".$data[5]."<br>";
				$now = date("Y-m-d H:i:s");
				$sql = "INSERT INTO definiciones (nivel, palabra, articulo, frase, pista, id_categoria, id_aula, id_usuario, fecha, validar) VALUES ('$data[2]','$data[1]','$data[0]','$data[4]','$data[5]','$data[3]','$id_grupo','$id_docente','$now','1')";
				mysqli_query($mysqli, $sql);
			}
			
			fclose($handle);
			//echo "Success!";
			echo '<div class="alert alert-success"> <strong>Import Successfull!</strong> </div>';
		}
		mysqli_close($mysqli);
	}
	//mysql_close($link);
?>
<div class="containter">
	<form class="form" action='<?php echo $_SERVER["PHP_SELF"];?>' method='post' enctype="multipart/form-data">
		<div class="form-group">
                <label>Import csv</label>
                <input type='file' name='sel_file' size='20'>
        </div>
		<!--Import csv: <input type='file' name='sel_file' size='20'>-->
		<input type="hidden" class="form-control" name="id_grupo" value="<?php echo $id_grupo;?>">
		<input type="hidden" class="form-control" name="id_docente" value="<?php echo $id_docente;?>">
		<input class="btn btn-primary" type='submit' name='submit' value='Submit'>
	</form>
</div>
</div>