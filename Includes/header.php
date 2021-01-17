<?php require_once "Classes/initialize.php"; ?>
<!DOCTYPE html>
<html lang="fa">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link rel="stylesheet" type="text/css" href="Style/bootstrap/css/bootstrap.min.css" />
      <link rel="stylesheet" type="text/css" href="Style/css/style.css" />
      <script type="text/javascript" src="Style/bootstrap/js/bootstrap.min.js"></script>
      <script type="text/javascript" src="Style/jquery/jquery-3.5.1.min.js"></script>
      <script type="text/javascript" src="Style/jquery/jquery-3.5.1.js"></script>
      <script language="JavaScript" type="text/javascript" src="Style/js/style.js"></script>
      <link href="Style/select2/css/select2.min.css" rel="stylesheet" />
      <script src="Style/select2/js/select2.min.js"></script>
      <link rel="stylesheet" type="text/css" href="Style/DataTables/datatables.css"/>
      <link rel="stylesheet" type="text/css" href="Style/DataTables/jquery.datatables.min.css"/>
      <link rel="stylesheet" type="text/css" href="Style/DataTables/select.datatables.min.css"/>
      <script type="text/javascript" src="Style/DataTables/datatables.js"></script>
      <script type="text/javascript" src="Style/DataTables/jquery.datatables.min.js"></script>
      <script type="text/javascript" src="Style/DataTables/datatables.select.min.js"></script>
  </head>
  <body onload="startTime()">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="today-navbar">
            <span id="now-date"><?= jdate('l') ?> - <?= $Funcs->nowJalalianDate(); ?></span>
            <span id="now-time"></span>
          </div>
        </div>
      </div>

      <?php
          if ($Funcs->checkValue($_SESSION["errorMessage"],false,true)){
            echo "<div class='flash-message'>{$Sessions::showErrorMessage()}</div>";
            $SS->unsetErrorMessage();
          }
          if ($Funcs->checkValue($_SESSION["alertMessage"],false,true)){
            echo '<script>window.alert("'.$Sessions::showAlertMessage().'");</script>';
            $SS->unsetErrorMessage();
          }
       ?>
