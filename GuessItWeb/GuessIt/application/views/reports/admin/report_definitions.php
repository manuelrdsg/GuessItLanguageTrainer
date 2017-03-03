<div class="col-md-10">
<div class="container-fluid">
	<ul class="nav nav-tabs nav-justified">
		<li role="presentation"> <a href="<?php echo base_url('index.php/Main/show_report_teacher')?>"> Informe por alumnos </a> </li>
		<li role="presentation" class="active"> <a href=""> Informe por definiciones </a> </li>
	</ul>
	
	<?php echo form_open('index.php/Main/input_login_user/','class="form"')?>
	<div class="col-md-7">
	
		<!-- Lista de alumnos -->
	
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading"> Alumnos </div>
				<div class="panel-body">
					<select multiple id="alumnos_seleccionados">
						<option value="1"> 49076548E </option>
						<option value="2"> 98765498H </option>
					</select>
				</div>
			</div>
		</div>
		
		<!-- Informe -->
		
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading"> Informe </div>
				<div class="panel-body">
					<select id="informe_seleccionado">
						<option value="1"> Porcentaje de reportes que coinciden con el docente </option>
						<option value="2"> Valoración media recibida y valoración del profesor por cada definición introducida </option>
						<option value=""> Listado de definiciones introducidas indicando si ha sido reportado por el profesor </option>
					</select>
				</div>
			</div>
		</div>
		
		<!-- Tipo del informe -->
		
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading"> Tipo de informe </div>
				<div class="panel-body">
					<div class="form-group">
						<input type="radio" name="tipo" value="tabla"> Tablas <br>
						<input type="radio" name="tipo" value="csv"> Fichero CSV <br>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-3">
		
		<!-- Niveles -->
		
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading"> Niveles </div>
				<div class="panel-body">
					<select multiple id="niveles_seleccionados">
						<option value="1"> Nivel 1 </option>
						<option value="2"> Nivel 2 </option>
						<option value="3"> Nivel 3 </option>
						<option value="4"> Nivel 4 </option>
					</select>
				</div>
			</div>
		</div>
		
		<!-- Boton de generar -->
		
		<div class="row">
			<div class="form-group">
				<button type="submit" class="btn btn-default btn-lg btn-block"> Generar </button>
			</div>
		</div>
	</div>
	<?php echo form_close();?>
</div>
</div>
