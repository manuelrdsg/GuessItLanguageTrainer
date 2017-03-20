<?php
		
		include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		
		$link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('No se pudo conectar: ' . mysql_error());
		
		mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
		mysql_query ( "SET NAMES 'utf8'" );
		$usuario = $_POST['usuario'];
		$pass = $_POST['password'];
		
		$sql="SELECT * FROM `usuarios` WHERE email='".$usuario."'";
		$result = mysql_query($sql);
		
		mysql_close($link);
		
		if (count($result) > 0) {
			// Check if password is correct
			$user = mysql_fetch_assoc($result);
       			if (password_verify($pass, $user['password']) && $user['validar'] != 0) {
				echo $user['id'].";".$user['nombre'].";".$user['apellidos'].";".$user['email'].";".$user['usuario'].";".$user['test'];
            		}
        	}

?>