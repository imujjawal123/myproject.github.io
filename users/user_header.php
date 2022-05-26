<?php 
   require_once('../main/config.php');
   require_once('../main/functions.php');
   session_start();
 ?>
<!DOCTYPE html>
<html lang="en">
<?php
    if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] != '' && $_SESSION['USER_STATUS'] == 1) {
  }
  else{
      header('location:../user-login');
      die();
  }
 ?> 
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<title>User Dashboard</title>

<link rel="shortcut icon" href="assets/img/favicon.png">

<link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css">

<link rel="stylesheet" href="assets/plugins/datatables/datatables.min.css">
<link rel="stylesheet" href="assets/css/animate.min.css">
<link rel="stylesheet" href="assets/css/select2.min.css">

<link rel="stylesheet" href="assets/css/admin.css">
<style type="text/css">
  .allowed-submit{opacity: .5;cursor: not-allowed;}
 .valid-input{
    border:1px solid green !important;
  }
  .invalid-input{
    border:1px solid red !important;
  }
  .invalid-msg{
    color: red;
  }

  #result {
    display: none;
  }
</style>
</head>
<body>
<div class="main-wrapper">

<div class="header">
<div class="header-left">
<a href="index" class="logo logo-small">
<img src="assets/img/logo-icon.png" alt="Logo" width="30" height="30">
</a>
</div>
<a href="javascript:void(0);" id="toggle_btn">
<i class="fas fa-align-left"></i>
</a>
<a class="mobile_btn" id="mobile_btn" href="javascript:void(0);">
<i class="fas fa-align-left"></i>
</a>
<ul class="nav user-menu">
<li class="nav-item dropdown">
<a href="javascript:void(0)" class="dropdown-toggle user-link  nav-link" data-toggle="dropdown">
<span class="user-img">
<img class="rounded-circle" src="assets/img/user.jpg" width="40" alt="Admin">
</span>
</a>
<div class="dropdown-menu dropdown-menu-right">
<a class="dropdown-item" href="user-profile">Profile</a>
<a class="dropdown-item" href="logout">Logout</a>
</div>
</li>

</ul>
</div>