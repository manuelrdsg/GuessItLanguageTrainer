<div class="col-md-9">
<?php include('scripts/import_definitions.php'); ?>
<div class="containter">
	<form class="form" action='<?php echo $_SERVER["PHP_SELF"];?>' method='post' enctype="multipart/form-data">
		<div class="form-group">
                <label>Import csv</label>
                <input type='file' name='sel_file' size='20' accept=".csv">
        </div>
		<input type="hidden" class="form-control" name="id_grupo" value="<?php echo $id_grupo;?>">
		<input type="hidden" class="form-control" name="id_docente" value="<?php echo $id_docente;?>">
		<input class="btn btn-primary" type='submit' name='submit' value='Submit'>
	</form>
</div>
</div>