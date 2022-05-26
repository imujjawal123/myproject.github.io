<?php 
  session_start();
  if (isset($_SESSION['USER_LOGIN']) && isset($_SESSION['USER_EMAIL']) && isset($_SESSION['USER_NAME']) && isset($_SESSION['USER_ID']) && isset($_SESSION['USER_STATUS'])) {
  	 unset($_SESSION);
  	 session_destroy();
  	 header('location:../user-login');
  }
?>