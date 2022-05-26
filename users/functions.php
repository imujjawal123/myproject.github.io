<?php 
  function check_input($conn,$input=''){
    $input = trim($input);
    $input = stripslashes($input);
    $input = mysqli_real_escape_string($conn,$input);
    return $input;
  }
  function getAdminProfile($conn){
  	$sql=mysqli_query($conn,"select * from admin");
  	$data_arr=array();
  	if ($sql) {
  		while($row=mysqli_fetch_assoc($sql)){
  			$data_arr[]=$row;
  		}
  	}
  	else{
      die("QUERY FAILED " .mysqli_error($conn));
  	}
  	return $data_arr;
  }
?>