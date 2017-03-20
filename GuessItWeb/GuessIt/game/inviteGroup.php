<?php
		
		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		
		$link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('No se pudo conectar: ' . mysql_error());
		
		mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
		//mysql_query ( "SET NAMES 'utf8'" );
		$id_usuario = $_POST['id_usuario'];
		$id_aula = $_POST['id_aula'];

		$sql = "INSERT INTO usuarios_aula(id_usuario,id_aula,validar) VALUES('$id_usuario','$id_aula',0)";
		$result = mysql_query($sql);

		$sql = "SELECT * FROM usuarios_aula WHERE id_usuario='$id_usuario' AND id_aula='$id_aula'";
		$res  = mysql_query($sql);
		$row = mysql_fetch_assoc($res);
		while($row = mysql_fetch_assoc($res)){
			$sql = "DELETE FROM usuarios_aula WHERE id='".$row['id']."'";
			$resu = mysql_query($sql);
		}

		mysql_close($link);
		echo true;
?>