<?php
	
	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');
		
	$link = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('No se pudo conectar: ' . mysql_error());

	//echo 'Conecxion exitosa';
	mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
	mysql_query ( "SET NAMES 'utf8'" ); // NO OLVIDARSE DE ESTO PARA LOS CARACTERES ESPECIALES
	$name = $_POST['nombre'];
	$lastname = $_POST['apellidos'];
	$email = $_POST['email'];
	$usuario = $_POST['usuario'];
	$pass = $_POST['password'];
	
	//$message = "Welcome ".$name." ".$lastname." to GuessIt!. You're password is: ".$pass." . Don't delete this message. Thanks!";
	
	//mail($email,"GuessIt! Registration",$message);

	$pass = password_hash($pass,PASSWORD_DEFAULT);
	
	$get_last_test = "SELECT test FROM usuarios ORDER BY id DESC LIMIT 1";
	$res = mysql_query($get_last_test);
	if(!$res){
		$test = 0;
	}else{
		$row = mysql_fetch_assoc($res);
		$test = !$row['test'];
	}
	
	$alta = $_POST['alta'];
	
	$sql="INSERT INTO usuarios(nombre,apellidos,email,usuario, password, alta, validar, test) VALUES('$name','$lastname','$email','$usuario','$pass','$alta','1','$test')";

	mysql_query($sql);

	// Cerrar la conexión
	mysql_close($link);
	echo true;

?>