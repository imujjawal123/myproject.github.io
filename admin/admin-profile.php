<?php 
include('admin_header.php'); 
include('sidebar.php');
?>
<div class="page-wrapper">
<div class="content container-fluid">
<div class="row">
<div class="col-xl-8 offset-xl-2">

<div class="page-header">
<div class="row">
<div class="col-sm-12">
<h3 class="page-title">Admin Profile</h3>
</div>
</div>
</div>

<div class="card">
<?php 
if (isset($_SESSION['success']) && $_SESSION['success'] !='') {
   echo '<div class="alert alert-success alert-dismissible">'.$_SESSION['success'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> </div>';   
   unset($_SESSION['success']);
} 
if (isset($_SESSION['error']) && $_SESSION['error'] !='') {
   echo '<div class="alert alert-danger alert-dismissible" style="color:#f50017">'.$_SESSION['error'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button> </div>';    
   unset($_SESSION['error']);
}
$get_profile_data=getAdminProfile($conn);
foreach($get_profile_data as $data){

}
?>    
<div class="card-body profile-menu">
<ul class="nav nav-tabs nav-tabs-solid" role="tablist">
<li class="nav-item home_tab">
<a class="nav-link active" data-toggle="tab" href="#profile_settings" role="tab" aria-selected="false">
Profile Settings
</a>
</li>
<li class="nav-item home_add">
<a class="nav-link" data-toggle="tab" href="#change_password" role="tab" aria-selected="false">
Change password
</a>
</li>
</ul>
<div class="tab-content">

<div class="tab-pane fade show active" id="profile_settings" role="tabpanel">
<form method="post" action="code.php" enctype="multipart/form-data">
   <input type="hidden" name="id" value="<?=$data['id']?>">
<div class="form-group">
<label>Name</label>
<input type="text" name="name" class="form-control" placeholder="Update Name" value="<?=$data['name']?>">
</div>
<div class="form-group">   
<label>Email</label>
<input type="email" class="form-control" name="email" placeholder="Update Email" value="<?=$data['email']?>">
</div>
<div class="form-group">
<label>Phone Number</label>
<input type="text" class="form-control" name="phone_number" placeholder="Update Number" value="<?=$data['phone_number']?>">
</div>
<div class="form-group">
<label>Profile Image</label>
<div class="media align-items-center">
<div class="media-left">
<img class="rounded-circle profile-img avatar-view-img" src="assets/img/admin-img/<?=$data['image']?>" alt="" width="100" height="100">
</div>
<div class="media-body">
<div class="uploader">
<div class="form-group">
  <input type="file" name="profile_img" class="form-control">  
</div>
<div class="form-group">
  <input type="hidden" name="old_image" value="<?=$data['image']?>"> 
</div>     
</div>
</div>
</div>
</div>
<div class="mt-4 save-form">
<button class="btn btn-primary save-btn" type="submit" name="update_profile">Save</button>
</div>
</form>
</div>


<div class="tab-pane fade" id="change_password" role="tabpanel">
<form id="updatePasswordForm" method="post">
 <input type="hidden" name="id" value="<?=$data['id']?>">   
<div class="form-group">
<label>Current Password</label>
<input type="password" name="current_password" id="current_password" class="form-control" value="<?=$data['password']?>">
</div>
<div class="form-group">
<label>New Password</label>
<input type="password" name="password" id="password" class="form-control">
<div class="password-msg"></div>
</div>
<div class="form-group">
<label>Repeat Password</label>
<input type="password" name="cpassword" id="cpassword" class="form-control">
<div class="cpassword-msg"></div>
</div>
<div class="mt-4 save-form">
<input class="btn save-btn btn-primary" name="update_password" id="update_password" type="submit" value="Submit">
</div>
</form>
<div class="justify-content-center alert alert-danger alert-dismissible fade show" id="result" role="alert">
 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div> 
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
<?php include('admin_footer.php') ?>

<script type="text/javascript">
   $('#password').on('input', function () {
   var password = $(this).val();
   var cpassword = $('#cpassword').val();
   var uppercasePassword = /(?=.*?[A-Z])/;
   var lowercasePassword = /(?=.*?[a-z])/;
   var digitPassword = /(?=.*?[0-9])/;
   var spacesPassword = /^$|\s+/;
   var symbolPassword = /(?=.*?[#?!@$%^&*-])/;
   var minEightPassword = /.{8,}/;
if (password.length == 0) {
   $('.password-msg').addClass('invalid-msg').text('Password is required');
   $(this).addClass('invalid-input').removeClass('valid-input');
}
else if (!uppercasePassword.test(password)) {
   $('.password-msg').addClass('invalid-msg').text('At least one Uppercase');
   $(this).addClass('invalid-input').removeClass('valid-input');
}
else if (!lowercasePassword.test(password)) {
   $('.password-msg').addClass('invalid-msg').text('At least one Lowercase');
   $(this).addClass('invalid-input').removeClass('valid-input');
}
else if (!digitPassword.test(password)) {
   $('.password-msg').addClass('invalid-msg').text('At least one digit');
   $(this).addClass('invalid-input').removeClass('valid-input');
} else if (!symbolPassword.test(password)) {
   $('.password-msg').addClass('invalid-msg').text('At least one special character');
   $(this).addClass('invalid-input').removeClass('valid-input');
}
else if (spacesPassword.test(password)) {
   $('.password-msg').addClass('invalid-msg').text('Whitespaces are not allowed');
   $(this).addClass('invalid-input').removeClass('valid-input');
}
else if (!minEightPassword.test(password)) {
   $('.password-msg').addClass('invalid-msg').text('Minimum length 8');
   $(this).addClass('invalid-input').removeClass('valid-input');
}
else if(cpassword.length>0) {
    if(password!=cpassword){
   $('.cpassword-msg').addClass('invalid-msg').text('must be matched');
   $('#cpassword').addClass('invalid-input').removeClass('valid-input');
   }
   else
   {
    $('.cpassword-msg').empty();
    $('#cpassword').addClass('valid-input').removeClass('invalid-input');
   }
   $('#password').addClass('valid-input').removeClass('invalid-input');
   $('.password-msg').empty();
} 
else {
   $('.password-msg').empty();
   $(this).addClass('valid-input').removeClass('invalid-input');
}
});
   // valiadtion for Confirm Password
$('#cpassword').on('input', function () {
   var password = $('#password').val();
   var cpassword = $(this).val();
if (cpassword.length == 0) {
   $('.cpassword-msg').addClass('invalid-msg').text('Confirm password is required');
   $(this).addClass('invalid-input').removeClass('valid-input');
}
else if(cpassword != password) {
   $('.cpassword-msg').addClass('invalid-msg').text('must be matched');
   $(this).addClass('invalid-input').removeClass('valid-input');
} 
else {
   $('.cpassword-msg').empty();
   $(this).addClass('valid-input').removeClass('invalid-input');
    }
});
// validation to submit the form
$('input').on('input',function(e){
   if($('#updatePasswordForm').find('.valid-input').length==2){
       $('#update_password').removeClass('allowed-submit');
       $('#update_password').removeAttr('disabled');

       $("#update_password").click(function(e){
          e.preventDefault();
          var password = $("#password").val();
          var cpassword = $("#cpassword").val();
         $.ajax({
               type: "POST",
               url: "code.php",
               data: $("#updatePasswordForm").serialize()+'&action=update_password',
               success: function(response){
                 if ($.trim(response) == 'OK') {
                     $("#result").css("display", "block");
                     $("#result").addClass('alert-success').removeClass('alert-danger').html("Password changed successfully");
                 }
                 else {
                    $("#result").css("display", "block");
                    $("#result").addClass('alert-danger').removeClass('alert-success').html(response);
                 }
               }
          });
       })
   }
  else{
       e.preventDefault();
       $('#submit-btn').attr('disabled','disabled')
       
      }
});
</script>