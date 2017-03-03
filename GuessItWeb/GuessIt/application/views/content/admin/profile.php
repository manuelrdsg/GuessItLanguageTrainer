<div class="col-md-9">
	<?php echo form_open('index.php/Main/update_admin','class="form"');?>
	<input type="hidden" class="form-control" name="id" value="<?php echo $id;?>">
	<div class="form-group">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?php echo $nombre;?>">
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="lastname">Last Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="lastname" placeholder="Enter lastname" value="<?php echo $apellidos;?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="email" placeholder="Enter email" value="<?php echo $email;?>">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="password">Password:</label>
      <div class="col-sm-10">          
        <input type="password" class="form-control" name="password" placeholder="Enter password">
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="center">Center:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="center" placeholder="Enter studies center" value="<?php echo $centro;?>">
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  <?php form_close();?>
</div>