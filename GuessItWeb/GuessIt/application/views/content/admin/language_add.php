<div class="col-md-9">
	<?php echo form_open('index.php/Main/add_language','class="form"'); ?>
		<div class="form-group">
		<input type="text" name="newLang" class="form-control" placeHolder="Language Name"><br>
		</div>
		<div class="form-group">
		<button type="submit" class="btn btn-primary"> Save </button><br>
		</div>
	<?php form_close(); ?>
	<?php
		include('scripts/get_languages_add.php');
	?>
</div>