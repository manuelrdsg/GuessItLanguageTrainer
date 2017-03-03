<?php
// Conectando, seleccionando la base de datos

	$link = mysql_connect('localhost', 'root', '')
	or die('No se pudo conectar: ' . mysql_error());
	//echo 'Conecxion exitosa';
	mysql_select_db('prueba') or die('No se pudo seleccionar la base de datos');

	$nombre = $_POST['nombre'];
	$puntaje = $_POST['puntaje'];

	$sql="INSERT INTO score(nombre, puntaje) VALUES('$nombre',$puntaje)";

	mysql_query($sql);

	// Cerrar la conexión
	mysql_close($link);
	echo true;

?>