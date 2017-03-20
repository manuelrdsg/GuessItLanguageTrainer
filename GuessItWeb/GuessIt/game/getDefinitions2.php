<?php
		
		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		
		$link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('No se pudo conectar: ' . mysql_error());
		
		mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
		mysql_query ( "SET NAMES 'utf8'" );
		$level = $_POST['level'];
		$id_aula = $_POST['id_aula'];
		
		$cadena_categorias = $_POST['categories'];
		$token = strtok($cadena_categorias, ";");
		$cadena_sql = " AND (id_categoria = '".$token."'";
		$token = strtok(";");
		while($token !== false){
			$cadena_sql .= " OR id_categoria = '".$token."'";
			$token = strtok(";");
		}
		
		$sql = "SELECT id, nivel, palabra, articulo, frase, pista, id_categoria, id_aula FROM definiciones WHERE id_aula = '".$id_aula."' AND nivel = '".$level."'".$cadena_sql.") ORDER BY RAND() LIMIT 10";
		
		$result = mysql_query($sql);
		
		$string_result = "";
		
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