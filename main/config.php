<?php 
 $dbhost="localhost";
 $dbuser="root";
 $dbpass="";
 $dbname="myproject";
 $conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
 if (!$conn) {
    die("Could not connect to the database " .mysqli_error($conn));
 }
?>