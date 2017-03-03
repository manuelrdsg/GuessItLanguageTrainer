<?php

	echo '<div class="col-md-10">';
	echo '<div class="container-fluid">';
	echo '<ul class="nav nav-tabs nav-justified">';
	echo '<li role="presentation" class="active"> <a href=""> Informe por alumnos </a> </li>';
	echo '<li role="presentation" >';
	echo '<a href="'.base_url('index.php/Main/show_report_definitions_teacher').'> Informe por definiciones </a> </li>';
	//echo '"> Informe por definiciones </a> </li>';
	echo '</ul>';
	
	echo form_open('index.php/Main/input_login_user/','class="form"');
	echo '<div class="col-md-6">';
	
	echo '<div class="row">';
	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading"> Alumnos </div>';
	echo '<div class="panel-body">';
	
	echo '<select multiple id="alumnos_seleccionados[]">';
	
	
	echo '</select>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	
	echo '<div class="row">';
	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading"> Informe </div>';
	echo '<div class="panel-body">';
	echo '<select id="informe_seleccionado">';
	echo '<option value="1"> Número de definiciones jugadas </option>';
	echo '<option value="2"> Número / Porcentaje de definiciones acertadas </option>';
	echo '<option value="3"> Porcentaje de reportes que coinciden con el docente </option>';
	echo '<option value="4"> Número de definiciones introducidas </option>';
	echo '<option value="5"> Número de definiciones introducidas jugadas por cualquiera </option>';
	echo '<option value="6"> Número / Porcentaje de definiciones introducidas acertadas por cualquiera </option>';
	echo '<option value="7"> Valoración media recibida por las definiciones introducidas </option>';
	echo '</select>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	
	echo '<div class="row">';
	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading"> Tipo de informe </div>';
	echo '<div class="panel-body">';
	echo '<div class="form-group">';
	echo '<input type="radio" name="tipo" value="grafico"> Gráfica <br>';
	echo '<input type="radio" name="tipo" value="tabla"> Tablas <br>';
	echo '<input type="radio" name="tipo" value="csv"> Fichero CSV <br>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	
	echo '<div class="col-md-4">';
	
	echo '<div class="row">';
	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading"> Rango del informe </div>';
	echo '<div class="panel-body">';
	echo '<div class="form-group">';
	echo '<input type="radio" name="rango" value="dias"> Días';
	echo '<input type="radio" name="rango" value="semanas"> Semanas';
	echo '<input type="radio" name="rango" value="todo"> Total';
	echo '</div>';
	echo '<div class="form-group">';
	echo '<input type="text" class="form-control input-mg" name="rango_ini" placeHolder="Inicio del rango YYYY-MM-DD">';
	echo '<input type="text" class="form-control input-mg" name="rango_fin" placeHolder="Fin del rango YYYY-MM-DD">';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
		
	echo '<div class="row">';
	echo '<div class="panel panel-default">';
	echo '<div class="panel-heading"> Niveles </div>';
	echo '<div class="panel-body">';
	echo '<select multiple id="niveles_seleccionados[]">';
	echo '<option value="1"> Nivel 1 </option>';
	echo '<option value="2"> Nivel 2 </option>';
	echo '<option value="3"> Nivel 3 </option>';
	echo '<option value="4"> Nivel 4 </option>';
	echo '</select>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
		
	echo '<div class="row">';
	echo '<div class="form-group">';
	echo '<button type="submit" class="btn btn-default btn-lg btn-block"> Generar </button>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	
	echo form_close();
</div>
</div>

?>