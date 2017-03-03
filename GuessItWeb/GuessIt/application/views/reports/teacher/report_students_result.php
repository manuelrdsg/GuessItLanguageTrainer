<?php

	/*
		TODO:
		- Diferentes informes
		- Rango de fechas
		- Tipo del informe


	*/

	include($_SERVER['DOCUMENT_ROOT'].'/GuessIt/utils/db_config.php');

	function dias_transcurridos($fecha_i,$fecha_f)
	{
		$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
		$dias 	= abs($dias); $dias = floor($dias);		
		return $dias;
	}

	function array_to_csv_download($array, $filename = "export.csv", $delimiter=",") {
		// open raw memory as file so no temp files needed, you might run out of memory though
		$f = fopen('php://memory', 'w'); 
		// loop over the input array
		foreach ($array as $line) { 
			// generate csv lines from the inner arrays
			fputcsv($f, $line, $delimiter); 
		}
		// reset the file pointer to the start of the file
		rewind($f);
		// tell the browser it's going to be a csv file
		header('Content-Type: application/csv; charset=UTF-8');
		// tell the browser we want to save it instead of displaying it
		header('Content-Disposition: attachment; filename="'.$filename.'";');
		// make php send the generated csv lines to the browser
		fpassthru($f);
	}
	
	// Todas las variables

	$grupo_id = $id_grupo;
	$docente_id = $id_docente;
	$id_alumnos = $alumnos;
	$informe_sel = $informe;
	$tipo_respuesta = $tipo;
	$tipo_rango = $rango;
	$inicio_rango = $rango_ini;
	$fin_rango = $rango_fin;
	$nivel_sel = $nivel;
	$sql_nivel = "";

	$cadena_niveles = implode(";",$nivel_sel);
	
	$token = strtok($cadena_niveles,";");

	$sql_nivel = " AND (definiciones.nivel = '".$token."'";

	$token = strtok(";");
	while($token !== false){
		$sql_nivel .= " OR definiciones.nivel = '".$token."'";
		$token = strtok(";");
	}
	
	$dias_transcurridos = dias_transcurridos($inicio_rango, $fin_rango);
	
	$cadena_rango = "";
	$cadena_datasets = "";
	
	// Aqui el script para obtener los datos de la DB
	
	$mysqli = $db;
	mysqli_query($mysqli,"SET NAMES 'utf8'");

	$fechas = "SELECT puntuaciones.fecha AS fecha FROM puntuaciones, definiciones WHERE definiciones.id = puntuaciones.id_palabra AND definiciones.id_aula = ".$grupo_id." GROUP BY puntuaciones.fecha";
	
	$resultado_fechas = mysqli_query($mysqli,$fechas);
	$array_fechas = array();
	$array_nombres = array();
	$array_datos = array();

	while($row_fechas = mysqli_fetch_assoc($resultado_fechas)){
		if(empty($inicio_rango) && empty($fin_rango)){
			$cadena_rango .= '"'.$row_fechas['fecha'].'",';
			$array_fechas[] = $row_fechas['fecha'];
		}else{
			if($row_fechas['fecha'] >= $inicio_rango && $row_fechas['fecha'] <= $fin_rango){
				$cadena_rango .= '"'.$row_fechas['fecha'].'",';
				$array_fechas[] = $row_fechas['fecha'];	
			}
		}
	}

	$cadena_rango = rtrim($cadena_rango,",");

	for( $i = 0 ; $i < count($id_alumnos) ; $i++ ){
		$cadena_datasets .= "{ ";
		$consulta_nombre_apellidos = "SELECT usuarios.nombre AS nombre, usuarios.apellidos AS apellidos FROM usuarios WHERE id = ".$id_alumnos[$i];

		$res_nombre_apellidos = mysqli_query($mysqli, $consulta_nombre_apellidos);

		while($row_nombre_apellidos = mysqli_fetch_assoc($res_nombre_apellidos)){
			$cadena_datasets .= 'label: "'.$row_nombre_apellidos['nombre'].' '.$row_nombre_apellidos['apellidos'].'",';
			if($tipo_respuesta == 'csv'){
				$array_nombres[] = $row_nombre_apellidos['apellidos'].' '.$row_nombre_apellidos['nombre'];
			}else{
				$array_nombres[] = $row_nombre_apellidos['apellidos'].', '.$row_nombre_apellidos['nombre'];
			}
		}
		$colorR = rand(1,255);
		$colorG = rand(1,255);
		$colorB = rand(1,255);
		$cadena_datasets .= '
			fillColor: "rgba('.$colorR.','.$colorG.','.$colorB.',0.2)",
			strokeColor: "rgba('.$colorR.','.$colorG.','.$colorB.',1)",
			pointColor: "rgba('.$colorR.','.$colorG.','.$colorB.',1)",
			pointStrokeColor: "#fff",
			pointHighlightFill: "#fff",
			pointHighlightStroke: "rgba('.$colorR.','.$colorG.','.$colorB.',1)",
		';

		$cadena_datasets .= 'data: [';
		for( $j = 0 ; $j < count($array_fechas) ; $j++ ){
			switch($informe_sel){
				case 1:
					$consulta_valor = "SELECT count(puntuaciones.id) AS cantidad FROM puntuaciones, definiciones WHERE puntuaciones.id_palabra = definiciones.id ".$sql_nivel.") AND definiciones.id_aula = ".$grupo_id." AND puntuaciones.id_usuario = ".$id_alumnos[$i]." AND puntuaciones.fecha = '".$array_fechas[$j]."'";
				break;
				case 2:
					$consulta_valor = "SELECT count(puntuaciones.id) AS cantidad FROM puntuaciones, definiciones WHERE puntuaciones.id_palabra = definiciones.id ".$sql_nivel.") AND definiciones.id_aula = ".$grupo_id." AND puntuaciones.id_usuario = ".$id_alumnos[$i]." AND puntuaciones.fecha = '".$array_fechas[$j]."' AND puntuaciones.acierto = 1";
				break;
				case 3:
					$consulta_valor = "SELECT count(puntuaciones.id) AS cantidad FROM puntuaciones, definiciones WHERE puntuaciones.id_palabra = definiciones.id ".$sql_nivel.") AND definiciones.id_aula = ".$grupo_id." AND puntuaciones.id_usuario = ".$id_alumnos[$i]." AND puntuaciones.fecha = '".$array_fechas[$j]."' AND puntuaciones.motivo != '' AND puntuaciones.motivo = puntuaciones.revision";
				break;
				case 4:
					$consulta_valor = "SELECT count(definiciones.id) AS cantidad FROM definiciones WHERE definiciones.id_aula = ".$grupo_id.$sql_nivel.") AND definiciones.id_usuario = ".$id_alumnos[$i]." AND definiciones.fecha = '".$array_fechas[$j]."'";
				break;
				case 5:
					$consulta_valor = "SELECT count(definiciones.id) AS cantidad FROM definiciones, puntuaciones WHERE definiciones.id = puntuaciones.id_palabra ".$sql_nivel.") AND definiciones.id_aula = ".$grupo_id." AND definiciones.id_usuario = ".$id_alumnos[$i]." AND definiciones.fecha = '".$array_fechas[$j]."'";
				break;
				case 6:
					$consulta_valor = "SELECT count(definiciones.id) AS cantidad FROM definiciones, puntuaciones WHERE definiciones.id = puntuaciones.id_palabra ".$sql_nivel.") AND definiciones.id_aula = ".$grupo_id." AND definiciones.id_usuario = ".$id_alumnos[$i]." AND definiciones.fecha = '".$array_fechas[$j]."' AND puntuaciones.acierto = 1";
				break;
				case 7:
				break;
			}
			$res_consulta_valor = mysqli_query($mysqli, $consulta_valor);
			switch($informe_sel){
				case 1:
					while( $row_consulta_valor = mysqli_fetch_assoc($res_consulta_valor)){
						$cadena_datasets .= $row_consulta_valor['cantidad'].",";
						$array_datos[] = $row_consulta_valor['cantidad'];
					}
				break;
				case 2:
					while( $row_consulta_valor = mysqli_fetch_assoc($res_consulta_valor)){
						$cadena_datasets .= $row_consulta_valor['cantidad'].",";
						$array_datos[] = $row_consulta_valor['cantidad'];
					}
				break;
				case 3:
					while( $row_consulta_valor = mysqli_fetch_assoc($res_consulta_valor)){
						$cadena_datasets .= $row_consulta_valor['cantidad'].",";
						$array_datos[] = $row_consulta_valor['cantidad'];
					}
				break;
				case 4:
					while( $row_consulta_valor = mysqli_fetch_assoc($res_consulta_valor)){
						$cadena_datasets .= $row_consulta_valor['cantidad'].",";
						$array_datos[] = $row_consulta_valor['cantidad'];
					}
				break;
				case 5:
					while( $row_consulta_valor = mysqli_fetch_assoc($res_consulta_valor)){
						$cadena_datasets .= $row_consulta_valor['cantidad'].",";
						$array_datos[] = $row_consulta_valor['cantidad'];
					}
				break;
				case 6:
					while( $row_consulta_valor = mysqli_fetch_assoc($res_consulta_valor)){
						$cadena_datasets .= $row_consulta_valor['cantidad'].",";
						$array_datos[] = $row_consulta_valor['cantidad'];
					}
				break;
				case 7:
				break;
			}
			
		}

		$cadena_datasets = rtrim($cadena_datasets, ",");

		$cadena_datasets .= ']},';
	}

	$cadena_datasets = rtrim($cadena_datasets, ",");
	
	/*for($i=0;$i<count($id_alumnos);$i++){
		$dia_inicio = $inicio_rango;
		for($j=0;$j<$dias_transcurridos;$j++){
			
		}
	}*/

	// Aqui las cabeceras
	if($tipo_respuesta != 'csv'){
	switch($informe_sel){
		case 1:
			echo '<div class="col-md-9"><h2> Número de definiciones jugadas </h2></div>';
		break;
		case 2:
			echo '<div class="col-md-9"><h2> Número de definiciones acertadas </h2></div>';
		break;
		case 3:
			echo '<div class="col-md-9"><h2> Porcentaje de reportes que coinciden con el docente </h2></div>';
		break;
		case 4:
			echo '<div class="col-md-9"><h2> Número de definiciones introducidas </h2></div>';
		break;
		case 5:
			echo '<div class="col-md-9"><h2> Número de definiciones introducidas jugadas por cualquiera </h2></div>';
		break;
		case 6:
			echo '<div class="col-md-9"><h2> Número de definiciones introducidas acertadas por cualquiera </h2></div>';
		break;
		case 7:
			echo '<div class="col-md-9"><h2> Valoración media por las definiciones introducidas </h2></div>';
		break;
	}
	}
	// Aqui el script chartjs
	if($tipo_respuesta == 'grafico'){

	echo '<div class="col-md-9"> <canvas id="myChart" width="1200" height="550"></canvas> <div id="leyendaBarras" class="col-md-9"> </div>';
	echo '<script>';
	
	echo 'var ctx = document.getElementById("myChart").getContext("2d");';
	
	echo 'var data = {';
	
	echo 'labels: ['.$cadena_rango."] ,";
	
	echo 'datasets: ['.$cadena_datasets.']';	
	
	echo '};';

	echo '
		var options = {
	responsive: true,

    	///Boolean - Whether grid lines are shown across the chart
    	scaleShowGridLines : true,

    	//String - Colour of the grid lines
    	scaleGridLineColor : "rgba(0,0,0,.05)",

    	//Number - Width of the grid lines
    	scaleGridLineWidth : 1,

    	//Boolean - Whether to show horizontal lines (except X axis)
    	scaleShowHorizontalLines: true,

    	//Boolean - Whether to show vertical lines (except Y axis)
    	scaleShowVerticalLines: true,

    	//Boolean - Whether the line is curved between points
    	bezierCurve : true,

    	//Number - Tension of the bezier curve between points
    	bezierCurveTension : 0.4,

    	//Boolean - Whether to show a dot for each point
    	pointDot : true,

    	//Number - Radius of each point dot in pixels
    	pointDotRadius : 4,

    	//Number - Pixel width of point dot stroke
    	pointDotStrokeWidth : 1,

    	//Number - amount extra to add to the radius to cater for hit detection outside the drawn point
    	pointHitDetectionRadius : 20,

    	//Boolean - Whether to show a stroke for datasets
    	datasetStroke : true,

    	//Number - Pixel width of dataset stroke
    	datasetStrokeWidth : 2,

    	//Boolean - Whether to fill the dataset with a colour
    	datasetFill : true,

    	//String - A legend template
	// Para el tamano maximo: datasets.length
    	legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].strokeColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

	};
	';
	
	echo 'var myLineChart = new Chart(ctx).Line(data, options);';
	echo 'legend(document.getElementById("leyendaBarras"), data);';
	
	echo '</script> </div>';
	}else{
		if($tipo_respuesta == 'tabla'){
			echo '<div class="col-md-9">';
			echo '<table class="table table-bordered">';
				echo '<tr class="success">';
					echo '<th> Names </th>';
					for($i = 0; $i < count($array_fechas); $i++){
						echo '<th>'.$array_fechas[$i].'</th>';
					}
				echo '</tr>';
				for($i = 0; $i < count($array_nombres); $i++){
					if($i%2 == 0){
						echo '<tr>';
					}else{
						echo '<tr class="info">';
					}
						echo '<td>'.$array_nombres[$i].'</td>';
						
						for($j = $i*count($array_fechas); $j < ($i*count($array_fechas)) + count($array_fechas); $j++){
							echo '<td>'.$array_datos[$j].'</td>';
						}
					echo '</tr>';
				}
			echo '</table>';
			echo '</div>';
		}else{
			if($tipo_respuesta == 'csv'){
				$export = array();
				$str_fechas = implode(';', $array_fechas);
				$str_fechas = "Names;".$str_fechas;
				$first_row = explode(";",$str_fechas);
				$export[] = $first_row;
				for($i = 0; $i < count($array_nombres); $i++){
					$tmp_array = array();
					$tmp_string = "";
					$tmp_string .= $array_nombres[$i].";";
					for($j = $i*count($array_fechas); $j < ($i*count($array_fechas)) + count($array_fechas); $j++){
						$tmp_string .= $array_datos[$j].";";
					}
					$tmp_array = explode(";", $tmp_string);
					$export[] = $tmp_array;
				}
				array_to_csv_download($export,"statistics_guessit.csv");
			}
		}
	}
	
	mysqli_close($mysqli);

?>