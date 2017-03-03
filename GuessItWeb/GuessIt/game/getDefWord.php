<?php
		
		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		
		$link = $db_mysql;
		
		mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
		mysql_query ( "SET NAMES 'utf8'" );
		$id_aula = $_POST['id_aula'];
		$rand_level = rand(1,4);
		$sql = "SELECT definiciones.nivel AS nivel, definiciones.palabra AS palabra, definiciones.articulo AS articulo, definiciones.id_categoria AS categoria, count(definiciones.id) AS cantidad FROM definiciones WHERE definiciones.id_aula = ".$id_aula." AND definiciones.nivel = ".$rand_level." GROUP BY definiciones.palabra ORDER BY cantidad, rand() ASC LIMIT 1";
		
		$result = mysql_query($sql);
		
		$string_result = "";
		
		if(count($result) > 0){
			while($row = mysql_fetch_assoc($result)){
				$sql = "SELECT nombre AS catname FROM categoria WHERE id = ".$row['categoria'];
				$res2 = mysql_query($sql);
				if(count($res2) > 0){
					while($row2 = mysql_fetch_assoc($res2)){
						$string_result .= $row['nivel'].";".$row['palabra'].";".$row['articulo'].";".$row['categoria'].";".$row2['catname'].";";
					}
				}
			}
		}
		mysql_close($link);
		echo $string_result;
?>