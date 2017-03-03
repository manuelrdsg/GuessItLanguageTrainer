<?php
	
	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');	
	$link = $db_mysql;
	
	//echo 'Conecxion exitosa';
	mysql_select_db('guessit') or die('No se pudo seleccionar la base de datos');
	mysql_query ( "SET NAMES 'utf8'" );
	$nivel = $_POST['nivel'];
	$palabra = $_POST['palabra'];
	$articulo = $_POST['articulo'];
	$frase = $_POST['frase'];
	$pista = $_POST['pista'];
	$id_categoria = $_POST['id_categoria'];
	$id_aula = $_POST['id_aula'];
	$id_usuario = $_POST['id_usuario'];
	$fecha = $_POST['fecha'];

	$palabra = str_replace("[RED]","",$palabra);
	$articulo = str_replace("[BLACK]","",$articulo);
	
	$sql="INSERT INTO definiciones(nivel,palabra,articulo,frase,pista,id_categoria,id_aula,id_usuario,fecha,validar) VALUES('$nivel','$palabra','$articulo','$frase','$pista','$id_categoria','$id_aula','$id_usuario','$fecha',1)";

	mysql_query($sql);

	// Cerrar la conexión
	mysql_close($link);
	echo true;

?>