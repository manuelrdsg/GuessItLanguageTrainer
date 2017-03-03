<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>GuessIt! Portal</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="<?php echo base_url('css/bootstrap.min.css')?>" rel="stylesheet">
		<link href="<?php echo base_url('js/bootstrap.js')?>" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!--<link href="<?php echo base_url(); ?>assets/login/css/styles.css" rel="stylesheet">-->
	</head>
<body>
<div class="container">
  <h2>GuessIt! Portal Registration Form</h2>
  <?php echo validation_errors(); ?>
  <?php echo form_open('index.php/Main/input_register','class="form"');?>
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="name" placeholder="Enter name">
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="lastname">Last Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="lastname" placeholder="Enter lastname">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" name="email" placeholder="Enter email">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="password">Password:</label>
      <div class="col-sm-10">          
        <input type="password" class="form-control" name="password" placeholder="Enter password">
      </div>
    </div>
	<div class="form-group">
      <label class="control-label col-sm-2" for="center">Institution:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="center" placeholder="Enter studies center">
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  <?php form_close();?>
  <a class="btn btn-default" data-dismiss="modal" aria-hidden="true" href="<?php echo base_url();?>">Cancel</a>
</div>

</body>
</html>

