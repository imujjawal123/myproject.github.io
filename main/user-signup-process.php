<?php 
  require_once('config.php');
  require_once('functions.php');
  session_start();
	$user_name = check_input($conn, $_POST['user_name']);
	$user_email = check_input($conn, $_POST['user_email']);
	$user_pnumber = check_input($conn, $_POST['user_pnumber']);
	$user_password = check_input($conn, $_POST['user_password']);
	$c_password = check_input($conn, $_POST['c_password']);
	$update_date=date("Y-m-d H:i:s");
    $upload_dir = "../assets/images/userimage";;
    $allowed_types = array('jpg', 'png', 'jpeg', 'webp');
    
    if (isset($_FILES['user_image']) && $_FILES['user_image']['name']) {
    	$target_file=$upload_dir."/".basename($_FILES['user_image']['name']);
    	$file_name=$_FILES['user_image']['name'];
	    $file_tmp_name=$_FILES['user_image']['tmp_name'];
	    $file_size=$_FILES['user_image']['size'];
	    $file_ext=strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        if (in_array($file_ext, $allowed_types)) {
    		$password_hash = password_hash($user_password, PASSWORD_DEFAULT);
    		$select_query = "SELECT * FROM users WHERE user_email = '".$user_email."' ";
    		$result = mysqli_query($conn,$select_query);
    		if (mysqli_num_rows($result) > 0) {
    			echo 'Email Id is already exists';
    		}
            else {
            	$insert_query ="insert into users(user_name,user_email,user_pnumber,user_password,user_image,status,update_date) values('$user_name','$user_email','$user_pnumber','$password_hash','$file_name',1,'$update_date')";
				$result = mysqli_query($conn,$insert_query);
			    if ($result) {
			    	move_uploaded_file($file_tmp_name, $target_file);
		      		echo "1";
		      	}
			    else {
			        echo 'Something went wrong';
			    }
            }
        }

        else {
        	echo 'Invalid file extention';
        }

    }
	
?>