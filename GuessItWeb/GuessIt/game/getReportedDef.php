<?php
		
		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		
		$link = $db_mysql;
		
		mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
		mysql_query ( "SET NAMES 'utf8'" );
		$id_usuario = $_POST['id_usuario'];
		$id_aula = $_POST['id_aula'];
		
		$string_result = "";
		
		$sql = "SELECT count(puntuaciones.id) as jugadas FROM puntuaciones, definiciones WHERE puntuaciones.id_palabra = definiciones.id AND puntuaciones.id_usuario = ".$id_usuario." AND definiciones.id_aula = ".$id_aula;
		$res = mysql_query($sql);
		$jugadas = mysql_fetch_assoc($res);
		
		$string_result .= $jugadas['jugadas'].";";
		
		$sql = "SELECT count(puntuaciones.id) as acertadas FROM puntuaciones, definiciones WHERE puntuaciones.acierto != 0 AND  puntuaciones.id_palabra = definiciones.id AND puntuaciones.id_usuario = ".$id_usuario." AND definiciones.id_aula = ".$id_aula;
		$res = mysql_query($sql);
		$acertadas = mysql_fetch_assoc($res);
		
		$string_result .= $acertadas['acertadas'].";";
		
		$sql = "SELECT AVG(puntuaciones.puntuacion) as media FROM puntuaciones, definiciones WHERE puntuaciones.reporte = 0 AND puntuaciones.id_usuario = ".$id_usuario." AND definiciones.id = puntuaciones.id_palabra AND definiciones.id_aula = ".$id_aula;
		$res = mysql_query($sql);
		$media = mysql_fetch_assoc($res);
		
		if(empty($media['media'])){
			$string_result .= "0;";
		}else{
			$string_result .= $media['media'].";";
		}
		
		$sql = "SELECT categoria.nombre as categoria, count(puntuaciones.id) as cantidad FROM categoria, definiciones, puntuaciones WHERE definiciones.id = puntuaciones.id_palabra AND definiciones.id_categoria = categoria.id AND puntuaciones.id_usuario = ".$id_usuario." AND definiciones.id_aula = ".$id_aula." GROUP BY definiciones.id_categoria ORDER BY cantidad DESC LIMIT 1";
		$res = mysql_query($sql);
		$categoria = mysql_fetch_assoc($res);
		
		if(empty($categoria['categoria'])){
			$string_result .= "None;";
		}else{
			$string_result .= $categoria['categoria'].";";
		}

		$string_result .= ";#;";

		//$sql = "SELECT result.catno AS categoria_nombre, count(puntuaciones.id) AS jugadas, cantidad.canti AS categoria_maximo FROM ( SELECT categoria.id AS catid, categoria.nombre AS catno FROM categoria WHERE categoria.id_aula = ".$id_aula.") result, ( SELECT definiciones.id_categoria AS catid, count(*) AS canti FROM definiciones, aula, categoria WHERE aula.id = ".$id_aula." AND aula.id = definiciones.id_aula AND categoria.id = definiciones.id_categoria GROUP BY definiciones.id_categoria ORDER BY definiciones.id_categoria) cantidad, definiciones, puntuaciones WHERE result.catid = definiciones.id_categoria AND puntuaciones.id_palabra = definiciones.id AND puntuaciones.id_usuario = ".$id_usuario." AND cantidad.catid = result.catid GROUP BY result.catid";
		$sql = "SELECT count(definiciones.id) AS jugadas, categoria.nombre AS categoria_nombre FROM definiciones, puntuaciones, categoria WHERE definiciones.id = puntuaciones.id_palabra AND definiciones.id_categoria = categoria.id AND puntuaciones.acierto = 1 AND definiciones.id_aula = ".$id_aula." AND puntuaciones.id_usuario = ".$id_usuario." GROUP BY definiciones.id_categoria";
		$res = mysql_query($sql);

		if(count($res) > 0){
			while($row = mysql_fetch_assoc($res)){
				$string_result .= $row['categoria_nombre'].";".$row['jugadas'].";";//.$row['categoria_maximo'].";";
			}
		}

		$string_result .= ";#;";


		$sql = "SELECT definiciones.palabra as palabra, puntuaciones.motivo AS motivo, count(motivo) as cantidad FROM definiciones,puntuaciones WHERE puntuaciones.reporte = 1 AND puntuaciones.id_palabra = definiciones.id AND definiciones.id_usuario = ".$id_usuario." AND definiciones.id_aula = ".$id_aula." GROUP BY motivo";
		$res = mysql_query($sql);
		
		if(count($res) > 0){
			while($row = mysql_fetch_assoc($res)){
				$string_result .= $row['palabra'].";".$row['motivo'].";".$row['cantidad'].";";
			}
		}
		
		mysql_close($link);
		echo $string_result;
?>