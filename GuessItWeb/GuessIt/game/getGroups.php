<?php
		
		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		
		$link = $db_mysql;
		
		mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
		mysql_query ( "SET NAMES 'utf8'" );
			$sql = "SELECT aula.id AS id, aula.nombre AS nombre, usuarios.nombre AS unombre, usuarios.apellidos AS uapellidos, aula.id_idioma AS idioma FROM aula, usuarios WHERE aula.activa = 1 AND aula.id_docente = usuarios.id";
		
			$result = mysql_query($sql);
		
			$string_result = "";
		
			if(count($result) > 0){
				while($row = mysql_fetch_assoc($result)){
					$string_result .= $row['id'].";".$row['nombre'].";".$row['unombre']." ".$row['uapellidos'].";".$row['idioma'].";";
				}
			}
		mysql_close($link);
		echo $string_result;
?>