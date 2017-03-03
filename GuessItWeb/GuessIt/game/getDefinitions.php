<?php
		
		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		
		$link = $db_mysql;
		
		mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
		mysql_query ( "SET NAMES 'utf8'" );
		$level = $_POST['level'];
		$id_aula = $_POST['id_aula'];
		$id_usuario = $_POST['id_usuario'];
		$test = $_POST['test'];

		$string_result = "";
		
		$cadena_categorias = $_POST['categories'];
		$token = strtok($cadena_categorias, ";");
		$cadena_sql = " AND (id_categoria = '".$token."'";
		$token = strtok(";");
		while($token !== false){
			$cadena_sql .= " OR id_categoria = '".$token."'";
			$token = strtok(";");
		}

		/*

		if(strcmp($test, "A") !== 0){
			$sql2 = "SELECT id, nivel, palabra, articulo, frase, pista, id_categoria, id_aula FROM definiciones WHERE id_aula = '".$id_aula."' AND nivel = '".$level."'".$cadena_sql.") ORDER BY RAND() LIMIT 10"; 
		}else{
			$numero = 0;
			$sql2 = "SELECT ROUND(((count(puntuaciones.id)/total.cantidad)*5),0) AS nuevas FROM `puntuaciones`, (SELECT count(puntuaciones.id) as cantidad FROM puntuaciones, definiciones WHERE definiciones.id_aula = '".$id_aula."' AND puntuaciones.id_usuario = '".$id_usuario."') total, definiciones WHERE definiciones.id_aula = '".$id_aula."' AND puntuaciones.id_usuario = '".$id_usuario."' AND puntuaciones.acierto = 1";
			$result1 = mysql_query($sql2);
			if(count($result1) > 0){
				while($row2 = mysql_fetch_assoc($result1)){
					$numero = $row2['nuevas'];
				}
			}

			$sql = "SELECT id, nivel, palabra, articulo, frase, pista, id_categoria, id_aula FROM definiciones WHERE id_aula = '".$id_aula."' AND nivel = '".$level."'".$cadena_sql.") ORDER BY RAND() LIMIT ".$numero;
		
			$result = mysql_query($sql);
		
		
		
			if(count($result) > 0){
				while($row = mysql_fetch_assoc($result)){
					if(empty($row['articulo'])){
						$string_result .= $row['id']."|".$row['nivel']."|".$row['palabra']."| |".$row['frase']."|".$row['pista']."|".$row['id_categoria']."|".$row['id_aula']."|";
					}else{
						$string_result .= $row['id']."|".$row['nivel']."|".$row['palabra']."|".$row['articulo']."|".$row['frase']."|".$row['pista']."|".$row['id_categoria']."|".$row['id_aula']."|";
					}
				}
			}
		}

		*/
		
		$sql = "SELECT id, nivel, palabra, articulo, frase, pista, id_categoria, id_aula FROM definiciones WHERE id_aula = '".$id_aula."' AND nivel = '".$level."'".$cadena_sql.") ORDER BY RAND() LIMIT 10";
		
		$result = mysql_query($sql);
		
		
		
		if(count($result) > 0){
			while($row = mysql_fetch_assoc($result)){
				if(empty($row['articulo'])){
					$string_result .= $row['id']."|".$row['nivel']."|".$row['palabra']."| |".$row['frase']."|".$row['pista']."|".$row['id_categoria']."|".$row['id_aula']."|";
				}else{
					$string_result .= $row['id']."|".$row['nivel']."|".$row['palabra']."|".$row['articulo']."|".$row['frase']."|".$row['pista']."|".$row['id_categoria']."|".$row['id_aula']."|";
				}
			}
		}
		mysql_close($link);
		echo $string_result;
?>