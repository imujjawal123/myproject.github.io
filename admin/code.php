<?php 
  require_once('../main/config.php');
  require_once('../main/functions.php');
  session_start();
  if (isset($_POST['login-btn'])) {
  	 $username=check_input($conn,$_POST['username']);
  	 $password=check_input($conn,$_POST['password']);
  	 if ($username!=''&&$password!='') {
  	   $sql="select * from admin_user where username='$username' ";
  	   $sql=mysqli_query($conn,$sql);
  	   if (mysqli_num_rows($sql) > 0) {
  	   	 while($row=mysqli_fetch_assoc($sql)){
  	   	 	if (password_verify($password, $row['password'])) {
  	   	 		$_SESSION['ADMIN_LOGIN'] = 'yes';
                $_SESSION['ADMIN_USERNAME'] = $username;
                header('location:index.php');
                die();
  	   	 	}
  	   	 	else{
  	   	 		$_SESSION['error'] = "Password is invalid";
                header('location:login.php');
                 die();
  	   	 	}
  	   	 }
  	   }
  	   else{
  	   	$_SESSION['error'] = "Invalid username!";
        header('location:login.php');
        die();
  	   }
  	 }
  	 else{
  	 	$_SESSION['error'] = "Username and Password is required";
        header('location:login.php');
        die();
  	 }
  }

  if (isset($_POST['update_profile'])) {
     $id = check_input($conn,$_POST['id']);
  	 $name=check_input($conn,$_POST['name']);
     $email=check_input($conn,$_POST['email']);
     $phone_number=check_input($conn,$_POST['phone_number']);
     $old_image=$_POST['old_image'];
     $update_date=date("Y-m-d H:i:s");
     $upload_dir = 'assets/img/admin-img'.DIRECTORY_SEPARATOR;
     $allowed_types = array('jpg', 'png', 'jpeg', 'webp');
     $maxsize = 2 * 1024 * 1024;
  	 if (isset($_FILES['profile_img']) && $_FILES['profile_img']['name'] !='') {
        $file_name=$_FILES['profile_img']['name'];
        $file_tmp_name=$_FILES['profile_img']['tmp_name'];
        $file_size=$_FILES['profile_img']['size'];
        $file_ext=strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $filepath=$upload_dir.$file_name;
        if (!in_array($file_ext, $allowed_types)) {
              $_SESSION['error']="File type is not allowed. Please use only jpg,jpeg,png,webp extention only";
              echo "<script> window.location.href = 'admin-profile.php' </script>";
              die();
          }
        if ($file_size > $maxsize) {
             $_SESSION['error']="File size exceeds limit. Please use file less than 2mb";
              echo "<script> window.location.href = 'admin-profile.php' </script>";
              die();
        }
        
        if (file_exists("$upload_dir/" . $_FILES['profile_img']['name'])) {
             $filename=$_FILES['profile_img']['name'];
             $_SESSION['error'] = "Image already exists " .$filename;
             echo "<script> window.location.href = 'admin-profile.php' </script>";
            die();
         }  
     }

     else {
        $file_name=$old_image;
     }
     $update_sql="update admin
                      set name='$name',
                          email='$email',
                          image='$file_name',
                          update_date='$update_date'
                          where id='$id' ";
        $result=mysqli_query($conn,$update_sql);
        if ($result) {
           if ($_FILES['profile_img']['name'] != '') {
                move_uploaded_file($file_tmp_name,"$upload_dir/".$file_name."");
                unlink("$upload_dir/".$old_image);
            } 
           $_SESSION['success'] = 'Profile updated successfully';
            echo "<script> window.location.href = 'admin-profile.php' </script>";
        }
        else{
           die("QUERY FAILED " .mysqli_error($conn));
        } 
  }

  if (isset($_POST['action']) == "update_password") {
     $id = check_input($conn,$_POST['id']);
  	 $current_password=check_input($conn,$_POST['current_password']);
  	 $password=check_input($conn,$_POST['password']);
  	 $cpassword=check_input($conn,$_POST['cpassword']);
  	 $sql=mysqli_query($conn,"select * from admin where id= '$id' ");
  	 $db_pass=mysqli_fetch_assoc($sql);
  	 $db_pass=$db_pass['password'];
  	 if ($db_pass==$current_password) {
  	 	 if ($password==$cpassword) {
            $password=password_hash($password, PASSWORD_DEFAULT);
  	 	 	$update_password=mysqli_query($conn,"update admin set password='$password'");
  	 	 	echo"OK";
  	 	 }
  	 }
  	 else{
	    echo "Something went wrong";
  	 }
  }
?>