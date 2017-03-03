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
<!--login modal -->
<div id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h1 class="text-center">GuessIt! Login</h1>
      </div>
      <div class="modal-body">
         <!--<?php if (isset($error) && $error): ?>
          <div class="alert alert-danger">
            <a class="close" data-dismiss="alert" href="#">×</a>Incorrect Username or Password!
          </div>
        <?php endif; ?>
		  
		  <?php 
			$attributes = array('class' => 'form col-md-12 center-block');
			echo form_open('login/login_user', $attributes);
	?>
		-->
		<?php echo form_open('index.php/Main/input_login_user/','class="form"')?>
            <div class="form-group">
              <input type="text" class="form-control input-lg" name="email" placeholder="Email">
            </div>
            <div class="form-group">
              <input type="password" class="form-control input-lg" name="password" placeholder="Password">
            </div>
            <div class="form-group">
              <button class="btn btn-primary btn-lg btn-block" type="submit">Sign In</button>
            </div>
            </div>
		<?php echo form_close();?>
      </div>
      <div class="modal-footer">
        <div class="col-md-12">
        <span class="pull-right">
              	<button class="btn btn-default" onclick="location.href='<?php echo base_url('index.php/Main/show_register/');?>'">Register</button>
         </span>
	</div>	
      </div>
  </div>
  </div>
</div>
