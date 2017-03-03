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
		<script src="<?php echo base_url('js/Chart.js')?>"></script>
		<script src="<?php echo base_url('js/legend.js')?>"></script>
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<!--<link href="<?php echo base_url(); ?>assets/login/css/styles.css" rel="stylesheet">-->
	</head>
<body>
<nav class="navbar navbar-inverse navbar-static-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="<?php echo base_url('index.php/Main/show_main_teacher/')?>">GuessIt! Portal</a>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right">
    					<span class="pull-right">
    						<a class="btn btn-default" href="<?php echo base_url('index.php/Main/logout_user');?>">Log out</a>
    					</span>
    			</ul>
    		</div> <!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>
<div class="container-fluid">
