<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title><?php echo $title.($subtitle ? ' ('.$subtitle.')' : '') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Кабельное телевидение в Бресте">
  <meta name="author" content="ООО ТелеСпутник">
  
  <!-- styles -->
  <link rel="stylesheet" type="text/css" href="/stylesheets/bootstrap.min.css" />
  <link rel="stylesheet" type="text/css" href="/stylesheets/bootstrap-overrides.css" />
  <link rel="stylesheet" type="text/css" href="/stylesheets/bootstrap-datepicker.css" />
  <link rel="stylesheet" type="text/css" href="/stylesheets/application.css" />

  <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode/svn/trunk/html5.js" type="text/javascript"></script>
  <![endif]-->

  <!-- fav-icons -->
  <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
  
  <!-- Placed at the end of the document so the pages load faster -->
  <script type="text/javascript" src="/javascripts/jquery.min.js"></script>
  <script type="text/javascript" src="/javascripts/jquery.maskedinput.js"></script>
  <script type="text/javascript" src="/javascripts/bootstrap.min.js"></script>
  <script type="text/javascript" src="/javascripts/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="/javascripts/rails.min.js"></script>
  <script type="text/javascript" src="/javascripts/application.js"></script>
  
</head>
<body <?php if ($controller == 'index') echo 'class="home"'; ?>>

  <!-- nav-bar -->
  <div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="brand" href="/">ТелеСпутник</a>
        <div class="nav-collapse collapse">
          <?php include('_primary_menu.php'); ?>
        </div>
      </div>
    </div>
  </div>
  
  <div class="container">

<?php if (isset($_SESSION['user_id']) && $has_secondary_menu) { // Secondary menu BEGIN ?>
<div class="row">
  <div class="span3 bs-docs-sidebar">
  <?php include('_secondary_menu.php'); ?>
  </div>
  <div class="span9">
<?php } ?>
  
  <?php if (isset($_SESSION['flash-alert'])) { ?>
    <div class='alert alert-error'><a class='close' data-dismiss='alert'>×</a><?php echo $_SESSION['flash-alert'] ?></div>
  <?php unset($_SESSION['flash-alert']); } ?>
  <?php if (isset($_SESSION['flash-notice'])) { ?>
    <div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><?php echo $_SESSION['flash-notice'] ?></div>
  <?php unset($_SESSION['flash-notice']); } ?>
	
<!-- page begin -->