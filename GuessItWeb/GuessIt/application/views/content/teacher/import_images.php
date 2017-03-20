<div class="col-md-9">
	<?php echo form_open_multipart('index.php/Main/store_images','class="form"');?>
	<div class="containter">
			<div class="form-group">
				<label>Import csv</label>
				<input type='file' name='sel_file' size='20' accept=".csv">
			</div>
			<input type="hidden" class="form-control" name="id_grupo" value="<?php echo $id_grupo;?>">
			<input type="hidden" class="form-control" name="id_docente" value="<?php echo $id_docente;?>">
			<div class="form-group">
				<label>Import zip</label>
				<input type="file"  name="zip" accept=".zip">
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
	<?php form_close();?>
</div>