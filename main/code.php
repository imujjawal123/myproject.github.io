<?php 
  require_once('config.php');
  require_once('functions.php');
  session_start();
  if (isset($_POST['action']) == "admin_login") {
     $email=check_input($conn,$_POST['email']);
     $password=check_input($conn,$_POST['password']);
     if ($email!=''&&$password!='') {
       $sql="select * from admin where email='$email' ";
       $sql=mysqli_query($conn,$sql); 
       if (!$sql) {
         die("QUERY FAILED " .mysqli_error($conn));
       }
       if (mysqli_num_rows($sql) > 0) {
         while($row=mysqli_fetch_assoc($sql)){
          if (password_verify($password, $row['password'])) {
            $_SESSION['ADMIN_LOGIN'] = 'yes';
            $_SESSION['ADMIN_EMAIL'] = $email;
            echo "loginOk";
          }
          else{
            echo "Password is invalid!";
          }
         }
       }
       else{
        echo "Invalid Email Id!";
       }
     }
     else{
     echo "Email and Password is required";
     }
  }

  if (isset($_POST['user_action']) == "user_login") {
     $user_email=check_input($conn,$_POST['user_email']);
     $user_password=check_input($conn,$_POST['user_password']);
     if ($user_email!=''&&$user_password!='') {
       $sql="select * from users where user_email='$user_email' ";
       $sql=mysqli_query($conn,$sql); 
       if (!$sql) {
         die("QUERY FAILED " .mysqli_error($conn));
       }
       if (mysqli_num_rows($sql) > 0) {
         while($row=mysqli_fetch_assoc($sql)){
          if (password_verify($user_password, $row['user_password']) && $row['status'] == 1) {
            $_SESSION['USER_LOGIN'] = 'yes';
            $_SESSION['USER_EMAIL'] = $user_email;
            $_SESSION['USER_ID'] = $row['user_id'];
            $_SESSION['USER_STATUS'] = $row['status'];
            $_SESSION['USER_NAME'] = $row['user_name'];
            echo "OK";
          }
          else{
            echo "Password is invalid or Unauthorized access";
          }
         }
       }
       else{
        echo "Invalid Email Id!";
       }
     }
     else{
     echo "Email and Password is required";
     }
  }
?>