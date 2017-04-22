
<?php

    include('/var/www/html/GuessIt/utils/db_config.php');	
	$mysqli = $db;

    mysqli_query($mysqli, "TRUNCATE TABLE tablaestatica_def");

    $res = mysqli_query($mysqli, "SELECT id_palabra FROM puntuaciones WHERE reporte > 0");

    foreach($res as $row) {
        $id_definicion = $row["id_palabra"];

        $res_num_report = mysqli_query($mysqli, "SELECT count(id) AS 'num_reportes' FROM puntuaciones WHERE id_palabra = $id_definicion and reporte > 0");
        $row_num_report = mysqli_fetch_row($res_num_report);
        $num_reportes = $row_num_report["0"];

        $res_palabra = mysqli_query($mysqli, "SELECT palabra FROM definiciones WHERE id = $id_definicion");
        $row_palabra = mysqli_fetch_row($res_palabra);
        $palabra = $row_palabra["0"];

        $res_num_definiciones = mysqli_query($mysqli, "SELECT count(id) FROM definiciones WHERE palabra like '". $palabra."' ");
        $row_num_definiciones = mysqli_fetch_row($res_num_definiciones);
        $num_definiciones = $row_num_definiciones["0"];


        $sql = "INSERT INTO tablaestatica_def (id_definicion, num_reportes, num_definiciones) VALUES ($id_definicion, $num_reportes, $num_definiciones)";
        mysqli_query($mysqli, $sql);
    }

?>