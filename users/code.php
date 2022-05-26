<?php 
  require_once('../main/config.php');
  require_once('../main/functions.php');
  session_start();

  if (isset($_POST['update_profile'])) {
     $id = $_SESSION['USER_ID'];
  	 $name=check_input($conn,$_POST['name']);
     $email=check_input($conn,$_POST['email']);
     $phone_number=check_input($conn,$_POST['phone_number']);
     $old_image=$_POST['old_image'];
     $update_date=date("Y-m-d H:i:s");
     $upload_dir = '../assets/images/userimage'.DIRECTORY_SEPARATOR;
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
              echo "<script> window.location.href = 'user-profile.php' </script>";
              die();
          }
        if ($file_size > $maxsize) {
             $_SESSION['error']="File size exceeds limit. Please use file less than 2mb";
              echo "<script> window.location.href = 'user-profile.php' </script>";
              die();
        }
        
        if (file_exists("$upload_dir/" . $_FILES['profile_img']['name'])) {
             $filename=$_FILES['profile_img']['name'];
             $_SESSION['error'] = "Image already exists " .$filename;
             echo "<script> window.location.href = 'user-profile.php' </script>";
            die();
         }  
     }

     else {
        $file_name=$old_image;
     }
     $update_sql="update users
                      set user_name='$name',
                          user_email='$email',
                          user_image='$file_name',
                          user_pnumber='$phone_number',
                          status = '1',
                          update_date='$update_date'
                          where user_id='$id' ";
        $result=mysqli_query($conn,$update_sql);
        if ($result) {
           if ($_FILES['profile_img']['name'] != '') {
                move_uploaded_file($file_tmp_name,"$upload_dir/".$file_name."");
                unlink("$upload_dir/".$old_image);
            } 
           $_SESSION['success'] = 'Profile updated successfully';
            echo "<script> window.location.href = 'user-profile.php' </script>";
        }
        else{
           die("QUERY FAILED " .mysqli_error($conn));
        } 
  }

  if (isset($_POST['action']) == "update_password") {
     $id = $_SESSION['USER_ID'];
  	 $current_password=check_input($conn,$_POST['current_password']);
  	 $password=check_input($conn,$_POST['password']);
  	 $cpassword=check_input($conn,$_POST['cpassword']);
  	 $sql=mysqli_query($conn,"select * from users where user_id= '$id' ");
  	 $db_pass=mysqli_fetch_assoc($sql);
  	 $db_pass=$db_pass['user_password'];
  	 if ($db_pass==$current_password) {
  	 	 if ($password==$cpassword) {
            $password=password_hash($password, PASSWORD_DEFAULT);
  	 	 	$update_password=mysqli_query($conn,"update users set password='$password'");
  	 	 	echo"OK";
  	 	 }
  	 }
  	 else{
	    echo "Something went wrong";
  	 }
  }

  if (isset($_POST['add_category'])) {
    $cat_name=check_input($conn,$_POST['cat_name']);
     if (isset($_FILES['cat_image']) && $_FILES['cat_image']['name'] !='') {
       $target_dir="assets/img/category/".DIRECTORY_SEPARATOR;
       $target_file=$target_dir.basename($_FILES['cat_image']['name']);
       $file_name=basename($_FILES['cat_image']['name']);
       $file_type=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
       $check=getimagesize($_FILES['cat_image']['tmp_name']);
       $allowed_type=array("jpg"=>"image/jpg","jpeg"=>"image/jpeg","png"=>"image/png","webp"=>"image/webp");
       if ($check!=false) {
            if (array_key_exists($file_type, $allowed_type)) {
              move_uploaded_file($_FILES['cat_image']['tmp_name'], $target_file);
               $res = mysqli_query($conn,"insert into service_category(cat_name,cat_image,added_on) values('$cat_name','$file_name',now())");
               if ($res) {
                  $_SESSION['success'] = "Service category inserted successfully";
                  echo "<script> window.location.href = 'categories.php'</script>";
               }
               else{
                die("QUERY FAILED " .mysqli_error($conn));
               }
            }
            else{
               $_SESSION['error']="Invalid format. File type must be of jpg,png,jpeg or webp.";
               echo "<script> window.location.href = 'add-category.php';</script>";
               die(); 
            }
       }
       else{
            $_SESSION['error']="File is not an image";
            echo "<script> window.location.href = 'add-category.php';</script>";
            die();
       }
     }
  }

  if (isset($_POST['update_category'])) {
    $cat_id=$_SESSION['cat_id'];
    $cat_name=check_input($conn,$_POST['cat_name']);
    if (isset($_FILES['cat_image']) && $_FILES['cat_image']['name'] !='') {
       $target_dir="assets/img/category/".DIRECTORY_SEPARATOR;
       $target_file=$target_dir.basename($_FILES['cat_image']['name']);
       $file_name=basename($_FILES['cat_image']['name']);
       $file_type=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
       $check=getimagesize($_FILES['cat_image']['tmp_name']);
       $allowed_type=array("jpg"=>"image/jpg","jpeg"=>"image/jpeg","png"=>"image/png","webp"=>"image/webp");
       if ($check!=false) {
            if (array_key_exists($file_type, $allowed_type)) {
              move_uploaded_file($_FILES['cat_image']['tmp_name'], $target_file);
               $res = mysqli_query($conn,"update service_category set cat_name='$cat_name', cat_image='$file_name',added_on=now() where cat_id='$cat_id'");
               if ($res) {
                  $_SESSION['success'] = "Service category inserted successfully";
                  echo "<script> window.location.href = 'categories.php'</script>";
               }
               else{
                die("QUERY FAILED " .mysqli_error($conn));
               }
            }
            else{
               $_SESSION['error']="Invalid format. File type must be of jpg,png,jpeg or webp.";
               echo "<script> window.location.href = 'edit-category.php?edit_id=$cat_id';</script>";
               die(); 
            }
       }
       else{
            $_SESSION['error']="File is not an image";
            echo "<script> window.location.href = 'edit-category.php?edit_id=$cat_id';</script>";
            die();
       }
     }
     else{
       $update_category=mysqli_query($conn,"update service_category set cat_name='$cat_name',added_on=now() where cat_id='$cat_id'");
       if ($update_category) {
          $_SESSION['success'] = "Service category updated successfully";
          echo "<script> window.location.href = 'categories.php'</script>";
       }
       else{
        die("QUERY FAILED " .mysqli_error($conn));
       }
     }
  }
?>
<?php 
  if (isset($_POST['add_service'])) {
      $ser_title=check_input($conn,$_POST['ser_title']);
      $ser_price=check_input($conn,$_POST['ser_price']);
      $ser_location=check_input($conn,$_POST['ser_location']);
      $ser_category=check_input($conn,$_POST['ser_category']);
      $ser_offered=$_POST['ser_offered'];
      $ser_details=check_input($conn,$_POST['ser_details']);
      $ser_details1=check_input($conn,$_POST['ser_details1']);

      if(isset($_FILES['ser_image']['name']) && !empty($_FILES['ser_image']['name'])) {
       $target_dir="assets/img/services/".DIRECTORY_SEPARATOR;
       $target_file=$target_dir.basename($_FILES['ser_image']['name']);
       $file_name=basename($_FILES['ser_image']['name']);
       $file_type=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
       $check=getimagesize($_FILES['ser_image']['tmp_name']);
       $allowed_type=array("jpg"=>"image/jpg","jpeg"=>"image/jpeg","png"=>"image/png","webp"=>"image/webp");
       if ($check!=false) {
            if (array_key_exists($file_type, $allowed_type)) {
              move_uploaded_file($_FILES['ser_image']['tmp_name'], $target_file);
              $service_offered=implode(",", $ser_offered);
               $res = mysqli_query($conn,"insert into service(ser_category,ser_title,ser_image,ser_location,ser_details,ser_details1,ser_status,ser_offered,ser_price,ser_added) values('$ser_category','$ser_title','$file_name','$ser_location','$ser_details','$ser_details1',1,'$service_offered','$ser_price',now())");
               if ($res) {
                  $_SESSION['success'] = "Service inserted successfully";
                  echo "<script> window.location.href = 'services.php'</script>";
               }
               else{
                die("QUERY FAILED " .mysqli_error($conn));
               }
            }
            else{
               $_SESSION['error']="Invalid format. File type must be of jpg,png,jpeg or webp.";
               echo "<script> window.location.href = 'add-service.php';</script>";
               die(); 
            }
       }
       else{
            $_SESSION['error']="File is not an image";
            echo "<script> window.location.href = 'add-service.php';</script>";
            die();
       }
     }
     else{
        $_SESSION['error']="Please select a file first";
        echo "<script> window.location.href = 'add-service.php';</script>";
        die(); 
     }
  }

  if (isset($_POST['update_service'])) {
      $ser_id = $_SESSION['ser_id'];
      $ser_title=check_input($conn,$_POST['ser_title']);
      $ser_price=check_input($conn,$_POST['ser_price']);
      $ser_location=check_input($conn,$_POST['ser_location']);
      $ser_category=check_input($conn,$_POST['ser_category']);
      $ser_offered=$_POST['ser_offered'];
      $ser_details=check_input($conn,$_POST['ser_details']);
      $ser_details1=check_input($conn,$_POST['ser_details1']);
      if(isset($_FILES['ser_image']['name']) && !empty($_FILES['ser_image']['name'])) {
       $target_dir="assets/img/services/".DIRECTORY_SEPARATOR;
       $target_file=$target_dir.basename($_FILES['ser_image']['name']);
       $file_name=basename($_FILES['ser_image']['name']);
       $file_type=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
       $check=getimagesize($_FILES['ser_image']['tmp_name']);
       $allowed_type=array("jpg"=>"image/jpg","jpeg"=>"image/jpeg","png"=>"image/png","webp"=>"image/webp");
       if ($check!=false) {
            if (array_key_exists($file_type, $allowed_type)) {
              move_uploaded_file($_FILES['ser_image']['tmp_name'], $target_file);
              $service_offered=implode(",", $ser_offered);
               $res = mysqli_query($conn,"update service set ser_category='$ser_category',ser_title='$ser_title',ser_image='$file_name',ser_location='$ser_location',ser_details='$ser_details',ser_details1='$ser_details1',ser_status=1,ser_offered='$service_offered',ser_price='$ser_price',ser_added=now() where ser_id='$ser_id'");
               if ($res) {
                  $_SESSION['success'] = "Service updated successfully";
                  echo "<script> window.location.href = 'services.php'</script>";
               }
               else{
                die("QUERY FAILED " .mysqli_error($conn));
               }
            }
            else{
               $_SESSION['error']="Invalid format. File type must be of jpg,png,jpeg or webp.";
               echo "<script> window.location.href = 'edit-service.php?edit_id=$ser_id';</script>";
               die(); 
            }
       }
       else{
            $_SESSION['error']="File is not an image";
            echo "<script> window.location.href = 'edit-service.php?edit_id=$ser_id';</script>";
            die();
       }
     }
     elseif (empty($_FILES['ser_image']['name'])) {
        $service_offered=implode(",", $ser_offered);
        $res = mysqli_query($conn,"update service set ser_category='$ser_category',ser_title='$ser_title',ser_location='$ser_location',ser_details='$ser_details',ser_details1='$ser_details1',ser_status=1,ser_offered='$service_offered',ser_price='$ser_price',ser_added=now() where ser_id='$ser_id'");
        if ($res) {
          $_SESSION['success'] = "Service updated successfully";
          echo "<script> window.location.href = 'services.php'</script>";
        }
        else{
         die("QUERY FAILED " .mysqli_error($conn));
        }
     }
     else{
        $_SESSION['error']="Please select a file first";
        echo "<script> window.location.href = 'edit-service.php?edit_id=$ser_id';</script>";
        die(); 
     }
  }

    if (isset($_POST['add_amcservice'])) {
      $amc_title=check_input($conn,$_POST['amc_title']);
      $amc_price=check_input($conn,$_POST['amc_price']);
      $amc_location=check_input($conn,$_POST['amc_location']);
      $amc_name=check_input($conn,$_POST['amc_name']);
      $ser_offered=$_POST['ser_offered'];
      $amc_details=check_input($conn,$_POST['amc_details']);

      if(isset($_FILES['amc_image']['name']) && !empty($_FILES['amc_image']['name'])) {
       $target_dir="assets/img/amc/".DIRECTORY_SEPARATOR;
       $target_file=$target_dir.basename($_FILES['amc_image']['name']);
       $file_name=basename($_FILES['amc_image']['name']);
       $file_type=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
       $check=getimagesize($_FILES['amc_image']['tmp_name']);
       $allowed_type=array("jpg"=>"image/jpg","jpeg"=>"image/jpeg","png"=>"image/png","webp"=>"image/webp");
       if ($check!=false) {
            if (array_key_exists($file_type, $allowed_type)) {
              move_uploaded_file($_FILES['amc_image']['tmp_name'], $target_file);
              $service_offered=implode(",", $ser_offered);
               $res = mysqli_query($conn,"insert into amc_service(amc_name,amc_title,amc_image,amc_location,amc_details,amc_status,amc_service_offered,amc_price,added_date) values('$amc_name','$amc_title','$file_name','$amc_location','$amc_details',1,'$service_offered','$amc_price',now())");
               if ($res) {
                  $_SESSION['success'] = "AMC Service inserted successfully";
                  echo "<script> window.location.href = 'amc-services.php'</script>";
               }
               else{
                die("QUERY FAILED " .mysqli_error($conn));
               }
            }
            else{
               $_SESSION['error']="Invalid format. File type must be of jpg,png,jpeg or webp.";
               echo "<script> window.location.href = 'add-amcservice.php';</script>";
               die(); 
            }
       }
       else{
            $_SESSION['error']="File is not an image";
            echo "<script> window.location.href = 'add-amcservice.php';</script>";
            die();
       }
     }
     else{
        $_SESSION['error']="Please select a file first";
        echo "<script> window.location.href = 'services.php';</script>";
        die(); 
     }
  }
    if (isset($_POST['update_amcservice'])) {
      $amc_id = $_SESSION['amc_id'];
      $amc_title=check_input($conn,$_POST['amc_title']);
      $amc_price=check_input($conn,$_POST['amc_price']);
      $amc_location=check_input($conn,$_POST['amc_location']);
      $amc_name=check_input($conn,$_POST['amc_name']);
      $ser_offered=$_POST['ser_offered'];
      $amc_details=check_input($conn,$_POST['amc_details']);
      if(isset($_FILES['amc_image']['name']) && !empty($_FILES['amc_image']['name'])) {
       $target_dir="assets/img/amc/".DIRECTORY_SEPARATOR;
       $target_file=$target_dir.basename($_FILES['amc_image']['name']);
       $file_name=basename($_FILES['amc_image']['name']);
       $file_type=strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
       $check=getimagesize($_FILES['amc_image']['tmp_name']);
       $allowed_type=array("jpg"=>"image/jpg","jpeg"=>"image/jpeg","png"=>"image/png","webp"=>"image/webp");
       if ($check!=false) {
            if (array_key_exists($file_type, $allowed_type)) {
              move_uploaded_file($_FILES['amc_image']['tmp_name'], $target_file);
              $service_offered=implode(",", $ser_offered);
               $res = mysqli_query($conn,"update amc_service set amc_name='$amc_name',amc_title='$amc_title',amc_image='$file_name',amc_location='$amc_location',amc_details='$amc_details',amc_status=1,amc_service_offered='$service_offered',amc_price='$amc_price',added_date=now() where amc_id='$amc_id'");
               if ($res) {
                  $_SESSION['success'] = "AMC service updated successfully";
                  echo "<script> window.location.href = 'amc-services.php'</script>";
               }
               else{
                die("QUERY FAILED " .mysqli_error($conn));
               }
            }
            else{
               $_SESSION['error']="Invalid format. File type must be of jpg,png,jpeg or webp.";
               echo "<script> window.location.href = 'edit-amcservice.php?edit_id=$amc_id';</script>";
               die(); 
            }
       }
       else{
            $_SESSION['error']="File is not an image";
            echo "<script> window.location.href = 'edit-amcservice.php?edit_id=$amc_id';</script>";
            die();
       }
     }
     elseif (empty($_FILES['amc_image']['name'])) {
        $service_offered=implode(",", $ser_offered);
        $res = mysqli_query($conn,"update amc_service set amc_name='$amc_name',amc_title='$amc_title',amc_location='$amc_location',amc_details='$amc_details',amc_status=1,amc_service_offered='$service_offered',amc_price='$amc_price',added_date=now() where amc_id='$amc_id'");
        if ($res) {
          $_SESSION['success'] = "AMC service updated successfully";
          echo "<script> window.location.href = 'amc-services.php'</script>";
        }
        else{
         die("QUERY FAILED " .mysqli_error($conn));
        }
     }
     else{
        $_SESSION['error']="Please select a file first";
        echo "<script> window.location.href = 'edit-amcservice.php?edit_id=$amc_id';</script>";
        die(); 
     }
  }

  /*Update general information*/
  if (isset($_POST['update_info'])) {
      $info_id=check_input($conn,$_POST['info_id']);
      $website_name=check_input($conn,$_POST['website_name']);
      $contact_details=check_input($conn,$_POST['contact_details']);
      $mobile_num1=check_input($conn,$_POST['mobile_num1']);
      $mobile_num2=check_input($conn,$_POST['mobile_num2']);
      $allowed_type=array("png"=>"image/png");
      $upload_logo = 'assets/img/';
      $upload_favicon = 'assets/img/';
      if ($_FILES['website_logo']['name'] != '' && $_FILES['website_favicon']['name'] != '') {
        $file_name1=$_FILES['website_logo']['name'];
        $file_name2=$_FILES['website_favicon']['name'];
        $target_file1=$upload_logo.basename($_FILES['website_logo']['name']);
        $target_file2=$upload_favicon.basename($_FILES['website_favicon']['name']);
        $file_type1=strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
        $file_type2=strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
        if (array_key_exists($file_type1,$allowed_type) && array_key_exists($file_type2, $allowed_type)) {
            move_uploaded_file($_FILES['website_logo']['tmp_name'], $target_file1);
            move_uploaded_file($_FILES['website_favicon']['tmp_name'], $target_file2);
            $update_info=mysqli_query($conn,"update general_info set website_name='$website_name',contact_details='$contact_details',mobile_num1='$mobile_num1',mobile_num2='$mobile_num2',website_logo='$file_name1',website_favicon='$file_name2' where id='$info_id'");
            if ($update_info) {
               $_SESSION['success'] = "General information updated successfully";
               echo "<script> window.location.href = 'settings.php'</script>";
            }
            else{
                die("QUERY FALIED " .mysqli_error($conn));
            }
        }
        else{
          $_SESSION['error']="Invalid Format! Only png image allowed";
          echo "<script> window.location.href = 'settings.php';</script>";
          die();   
        }
      }
      elseif (!empty($_FILES['website_favicon']['name'])) {
         $file_name2=$_FILES['website_favicon']['name'];
         $target_file2=$upload_logo.basename($_FILES['website_favicon']['name']);
         $file_type2=strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
         if (array_key_exists($file_type2,$allowed_type)) {
            move_uploaded_file($_FILES['website_favicon']['tmp_name'], $target_file2);
            $update_info=mysqli_query($conn,"update general_info set website_name='$website_name',contact_details='$contact_details',mobile_num1='$mobile_num1',mobile_num2='$mobile_num2',website_favicon='$file_name1' where id='$info_id'");
            if ($update_info) {
               $_SESSION['success'] = "General information updated successfully";
               echo "<script> window.location.href = 'settings.php'</script>";
            }
            else{
                die("QUERY FALIED " .mysqli_error($conn));
            }  
         }
      }
      elseif (!empty($_FILES['website_logo']['name'])) {
         $file_name1=$_FILES['website_logo']['name'];
         $target_file1=$upload_favicon.basename($_FILES['website_logo']['name']);
         $file_type1=strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
         if (array_key_exists($file_type1,$allowed_type)) {
            move_uploaded_file($_FILES['website_logo']['tmp_name'], $target_file1);
            $update_info=mysqli_query($conn,"update general_info set website_name='$website_name',contact_details='$contact_details',mobile_num1='$mobile_num1',mobile_num2='$mobile_num2',website_logo='$file_name1' where id='$info_id'");
            if ($update_info) {
               $_SESSION['success'] = "General information updated successfully";
               echo "<script> window.location.href = 'settings.php'</script>";
            }
            else{
                die("QUERY FALIED " .mysqli_error($conn));
            }  
         }
      }
      else{
        $update_info=mysqli_query($conn,"update general_info set website_name='$website_name',contact_details='$contact_details',mobile_num1='$mobile_num1',mobile_num2='$mobile_num2' where id='$info_id'");
            if ($update_info) {
               $_SESSION['success'] = "General1 information updated successfully";
               echo "<script> window.location.href = 'settings.php'</script>";
            }
            else{
                die("QUERY FALIED " .mysqli_error($conn));
            }  
      }
    }
    
    if (isset($_POST['updated_about'])) {
        $abt_id=check_input($conn,$_POST['abt_id']);
        $abt_title=check_input($conn,$_POST['abt_title']);
        $abt_desc1=check_input($conn,$_POST['abt_desc1']);
        $abt_desc2=check_input($conn,$_POST['abt_desc2']);
        $allowed_type=array("png"=>"image/png","jpeg"=>"image/jpeg","jpg"=>"image/jpg","webp"=>"image/webp");
        $upload_dir = 'assets/img/';
        if (isset($_FILES['abt_img']['name']) && !empty($_FILES['abt_img']['name'])) {
         $file_name1=$_FILES['abt_img']['name'];
         $target_file1=$upload_dir.basename($_FILES['abt_img']['name']);
         $file_type1=strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
         if (array_key_exists($file_type1,$allowed_type)) {
            move_uploaded_file($_FILES['abt_img']['tmp_name'], $target_file1);
            $update_about=mysqli_query($conn,"update about_us set abt_title='$abt_title',abt_desc1='$abt_desc1',abt_desc2='$abt_desc2',abt_img='$file_name1' where id='$abt_id'");
            if ($update_about) {
               $_SESSION['success'] = "About information updated successfully";
               echo "<script> window.location.href = 'about-details.php'</script>";
            }
            else{
                die("QUERY FALIED " .mysqli_error($conn));
            }  
         }
      }
      else{
         $update_about=mysqli_query($conn,"update about_us set abt_title='$abt_title',abt_desc1='$abt_desc1',abt_desc2='$abt_desc2' where id='$abt_id'");
            if ($update_about) {
               $_SESSION['success'] = "About information updated successfully";
               echo "<script> window.location.href = 'about-details.php'</script>";
            }
            else{
                die("QUERY FALIED " .mysqli_error($conn));
            } 
        }
    }

    /*Social Media*/
    if (isset($_POST['updated_social'])) {
        $social_id=check_input($conn,$_POST['social_id']);
        $fb_link=check_input($conn,$_POST['fb_link']);
        $ins_link=check_input($conn,$_POST['ins_link']);
        $whatsapp_link=check_input($conn,$_POST['whatsapp_link']);
        $youtube_link=check_input($conn,$_POST['youtube_link']);
        $tw_link=check_input($conn,$_POST['tw_link']);

        $update_social=mysqli_query($conn,"update social_media set fb_link='$fb_link',ins_link='$ins_link',whatsapp_link='$whatsapp_link',youtube_link='$youtube_link',tw_link='$tw_link'");
        if ($update_social) {
            $_SESSION['success'] = "Social media link updated successfully";
            echo "<script> window.location.href = 'social-media.php'</script>";
        }
        else{
            die("QUERY FALIED " .mysqli_error($conn));
        }
    }
?>