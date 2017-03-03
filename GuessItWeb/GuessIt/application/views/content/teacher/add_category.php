<div class="col-md-9">
<?php echo form_open('index.php/Main/add_category','class="form"');?>
<input type="hidden" class="form-control" name="aula" value="<?php echo $id_grupo;?>">
<br>
<input type="text" class="form-control" name="categories" placeholder="Type categories separated with comma.">
<br>
<input type="submit" class="btn btn-primary" value="Save">
<?php form_close(); ?>
</div>