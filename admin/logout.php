<?php 
  session_start();
  if (isset($_SESSION['ADMIN_LOGIN']) && isset($_SESSION['ADMIN_EMAIL'])) {
  	 unset($_SESSION);
  	 session_destroy();
  	 header('location:../admin-login');
  }
?>