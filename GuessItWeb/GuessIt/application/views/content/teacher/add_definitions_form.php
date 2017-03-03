<div class="col-md-9">
	<?php echo form_open('index.php/Main/store_definition','class="form"');?>
    <div class="form-group">
      <label class="control-label col-sm-2" for="level">Level:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="level" placeholder="Enter level">
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="word">Word:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="word" placeholder="Enter word">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="article">Article:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="article" placeholder="Enter article">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="definition">Definition:</label>
      <div class="col-sm-10">          
        <input type="text" class="form-control" name="definition" placeholder="Enter definition">
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="hint">Hint:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="hint" placeholder="Enter hint">
      </div>
    </div>
  <div class="form-group">
      <label class="control-label col-sm-2" for="image">Image:</label>
      <div class="col-sm-10">
        <input type="file" class="form-control" name="image" accept=".jpg">
      </div>
  </div>
	<?php include('scripts/select_category_definition.php'); ?>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  <?php form_close();?>
</div>
