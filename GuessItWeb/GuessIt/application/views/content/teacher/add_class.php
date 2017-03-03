<div class="col-md-9">
	<?php echo form_open('index.php/Main/add_class','class="form"');?>
	
		<input type="text" class="form-control" name="gname" placeholder="Group name">
		<br>
		<?php include('scripts/select_tag_groups.php'); ?>
		<br>
		<br>
		<input type="text" class="form-control" name="categories" placeholder="Type categories separated with comma.">
		<br>
		<input type="submit" class="btn btn-primary" value="Save">
	<?php form_close(); ?>
</div>