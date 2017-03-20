<?php
		
		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		
		$link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('No se pudo conectar: ' . mysql_error());
		
		mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
		mysql_query ( "SET NAMES 'utf8'" );
		$id_usuario = $_POST['id_usuario'];
		$sql = "SELECT aula.id AS id, aula.nombre AS nombre, usuarios.nombre AS unombre, usuarios.apellidos AS uapellidos, aula.id_idioma AS idioma, idiomas.nombre AS idioma_lang FROM aula, usuarios_aula, usuarios, idiomas WHERE aula.activa = 1 AND usuarios_aula.id_aula = aula.id AND aula.id_idioma = idiomas.id AND aula.id_docente = usuarios.id AND usuarios_aula.id_usuario = '".$id_usuario."' AND usuarios_aula.validar = 1";
		
		$result = mysql_query($sql);
		
		$string_result = "";
		
		if(count($result) > 0){
			while($row = mysql_fetch_assoc($result)){
				$sql = "SELECT count(*) AS cantidad FROM definiciones WHERE id_aula=".$row['id'];
				$res = mysql_query($sql);
				if(count($res) > 0){
					while($row2 = mysql_fetch_assoc($res)){
						$string_result .= $row['id'].";".$row['nombre'].";".$row['unombre']." ".$row['uapellidos'].";".$row['idioma'].";".$row['idioma_lang'].";".$row2['cantidad'].";";
					}
				}
			}
		}
		mysql_close($link);
		echo $string_result;
?>