<?php
    $currentPath = $_SERVER['PHP_SELF'];
    $pathInfo = pathinfo($currentPath);
    $hostName = $_SERVER['HTTP_HOST'];
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0,5)) == 'https://'?'https://':'http://';
    $link = $protocol.$hostName.$pathInfo['dirname'];
?>
<?php 
   require_once('main/config.php');
   require_once('main/functions.php');
   session_start();
 ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png">
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/21cf0de08d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"type="text/css" href="assets/css/style.css">
	<title>My Project</title>
</head>
<body>
	<div class="main">
	    <header>
		<div class="header-menu fixed-top">
			<nav class="navbar navbar-expand-lg navbar-light">
			  <div class="container">
			    <a class="navbar-brand" href="<?=$link?>">My Project</a>
			    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			      <span class="navbar-toggler-icon"></span>
			    </button>
			    <div class="collapse navbar-collapse" id="navbarSupportedContent">
			      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
			        <li class="nav-item">
			          <a class="nav-link active" href="<?=$link?>">Home</a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link" href="admin-login">Admin LogIn</a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link" href="user-login">User LogIn</a>
			        </li>
			        <li class="nav-item">
			          <a class="nav-link" href="user-signup">User SignUp</a>
			        </li>
			      </ul>
			      <div class="left-list d-flex">
			      	 <a href="admin-login" class="d-flex btn btn123">Admin LogIn</a>
			         <a href="user-login" class="d-flex btn btn123">User LogIn</a>
			         <a href="user-signup" class="d-flex btn btn123">User SignUp</a>
			      </div>
			    </div>
			  </div>
		    </nav>
        </div>
	    </header>