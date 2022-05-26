<?php include('includes/header.php') ?>
<section style="background-color: #eee;position: relative;
    padding-top: 120px; padding-bottom: 30px;">
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-12 col-xl-8">
        <div class="card text-black" style="border-radius: 25px;">
          <div class="card-body p-md-5">
            <div class="row justify-content-center">
              <div class="col-md-6 col-lg-8 col-xl-10">

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">User SignUp</p>

                <form class="mx-1 mx-md-4" id="userSignUp" enctype="multipart/form-data">

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example3c">Enter Name</label>
                      <input type="text" id="user_name" name="user_name" class="form-control" />
                      <div class="name-msg"></div>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example4c">Enter Email</label>
                      <input type="email" id="user_email" name="user_email" class="form-control" />
                       <div class="email-msg"></div>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-phone fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example3c">Enter Mobile Number</label>
                      <input type="text" id="user_pnumber" name="user_pnumber" class="form-control" />
                      <div class="number-msg"></div>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example4c">Enter Password</label>
                      <input type="password" id="user_password" name="user_password" class="form-control" />
                       <div class="password-msg"></div>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example4c">Confirm Password</label>
                      <input type="password" id="c_password" name="c_password" class="form-control" />
                      <div class="cpassword-msg"></div>
                    </div>
                  </div>

                   <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-file fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example4c">Upload Image</label>
                      <input type="file" id="user_image" name="user_image" class="form-control" />
                    </div>
                  </div>


                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <input type="submit" value="SignUp" id="btn-signup" class="btn btn-primary btn-lg btn-block" disabled="disabled">
                  </div>
                  
                  <div class="justify-content-center alert alert-danger alert-dismissible fade show" id="result" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div> 

                </form>

              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include('includes/footer.php') ?>
<script type="text/javascript">
  $('#user_name').on('input', function () {
   var userName = $(this).val();
   var validName = /^[a-zA-Z ]*$/;
   if (userName.length == 0) {
      $('.name-msg').addClass('invalid-msg').text("Name is required");
      $(this).addClass('invalid-input').removeClass('valid-input');
      
   }
   else if (!validName.test(userName)) {
      $('.name-msg').addClass('invalid-msg').text('only characters & Whitespace are allowed');
      $(this).addClass('invalid-input').removeClass('valid-input');
      
   }
   else {
      $('.name-msg').empty();
      $(this).addClass('valid-input').removeClass('invalid-input');
   }
  });

  $('#user_email').on('input', function () {
   var emailAddress = $(this).val();
   var validEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
   if (emailAddress.length == 0) {
     $('.email-msg').addClass('invalid-msg').text('Email is required');
     $(this).addClass('invalid-input').removeClass('valid-input');
   }
   else if (!validEmail.test(emailAddress)) {
     $('.email-msg').addClass('invalid-msg').text('Invalid Email Address');
     $(this).addClass('invalid-input').removeClass('valid-input');
   }
   else {
     $('.email-msg').empty();
     $(this).addClass('valid-input').removeClass('invalid-input');
  }
  });

  $('#user_pnumber').on('input', function () {
   var phoneNumber = $(this).val();
   var validNumber = /^\d*(?:\.\d{1,2})?$/;

   if (phoneNumber.length == 0) {
     $('.number-msg').addClass('invalid-msg').text('Phone Number is required');
     $(this).addClass('invalid-input').removeClass('valid-input');
   }
   else if (!validNumber.test(phoneNumber)) {
     $('.number-msg').addClass('invalid-msg').text('Only digits are allowed');
     $(this).addClass('invalid-input').removeClass('valid-input');
   }
   else {
     $('.number-msg').empty();
     $(this).addClass('valid-input').removeClass('invalid-input');
  }
  });
// valiadtion for Password
$('#user_password').on('input', function () {
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
else if(c_password.length>0) {
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
$('#c_password').on('input', function () {
   var password = $('#user_password').val();
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
  var length=$('#userSignUp').find('.valid-input').length;
   if(length==5){
       $('#btn-signup').removeClass('allowed-submit');
       $('#btn-signup').removeAttr('disabled');

       $("#btn-signup").click(function(e){
          e.preventDefault();
          e.stopImmediatePropagation();
          var form = $('#userSignUp')[0];
          var formdata = new FormData(form);    
          var file = $('#user_image')[0].files;

          if (formdata) {
            formdata.append("file", file);
            $.ajax({
              url: "./main/user-signup-process.php",
              type: "POST",
              data: formdata,
              success:function(response){
                 if (response == "1") {
                     $("#result").css("display", "block");
                      $("#result").addClass('alert-success').removeClass('alert-danger').html("Registration Success").delay(5000).fadeOut();
                     $("#userSignUp")[0].reset();
                     location.replace("users/index");
                 }
                 else {
                    $("#result").css("display", "block");
                    $("#result").addClass('alert-danger').removeClass('alert-success').html(response).delay(1000).fadeOut();
                 }
              },
              cache: false,
              contentType: false,
              processData: false
            });
          }           

       });
   }
  else{
       e.preventDefault();
       $('#submit-btn').attr('disabled','disabled')
      }
});
</script> 