<?php
		
		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
		$link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('No se pudo conectar: ' . mysql_error());
		
		mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
		//mysql_query ( "SET NAMES 'utf8'" );
		$id_usuario = $_POST['id_usuario'];
		$id_palabra = $_POST['id_palabra'];
		$puntuacion = $_POST['puntuacion'];
		$acierto = $_POST['acierto'];
		$pista = $_POST['pista'];
		$intentos = $_POST['intentos'];
		$reporte = $_POST['reporte'];
		$motivo = $_POST['motivo'];
		$fecha = $_POST['fecha'];
		$sql = "INSERT INTO puntuaciones(id_usuario,id_palabra,puntuacion,acierto,pista,intentos,reporte,motivo,fecha) VALUES('$id_usuario','$id_palabra','$puntuacion','$acierto','$pista','$intentos','$reporte','$motivo','$fecha')";
		
		$result = mysql_query($sql);
		mysql_close($link);
		echo true;
?>