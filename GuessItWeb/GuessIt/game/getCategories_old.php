<?php

		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		
		$link = $db_mysql;
		
		mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
		mysql_query ( "SET NAMES 'utf8'" );
		$id_aula = $_POST['id_aula'];
		$nivel = $_POST['nivel'];
		$sql = "SELECT id, nombre FROM categoria WHERE id_aula = '".$id_aula."'";
		
		$result = mysql_query($sql);
		
		$string_result = "";
		
		if(count($result) > 0){
			while($row = mysql_fetch_assoc($result)){
				$sql = "SELECT count(*) AS cantidad FROM definiciones WHERE id_categoria =".$row['id'];//." AND nivel =".$nivel;
				$res = mysql_query($sql);
				if(count($res) > 0){
					while($row2 = mysql_fetch_assoc($res)){
						$string_result .= $row['id'].";".$row['nombre'].";".$row2['cantidad'].";";
					}
				}
			}
		}
		mysql_close($link);
		echo $string_result;
?>