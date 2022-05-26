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

                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Admin LogIn</p>

                <form class="mx-1 mx-md-4" id="adminForm">

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example3c">Your Email</label>
                      <input type="email" id="email" name="email" class="form-control" required />
                      <div class="email-msg"></div>
                    </div>
                  </div>

                  <div class="d-flex flex-row align-items-center mb-4">
                    <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                    <div class="form-outline flex-fill mb-0">
                      <label class="form-label" for="form3Example4c">Password</label>
                      <input type="password" id="password" name="password" class="form-control" required />
                      <div class="password-msg"></div>
                    </div>
                  </div>

                  <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <input type="submit" value="Submit" id="submit-btn" class="btn btn-primary btn-lg btn-block" disabled="disabled">
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
  $('#email').on('input', function () {
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
// valiadtion for Password
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
else {
   $('.password-msg').empty();
   $(this).addClass('valid-input').removeClass('invalid-input');
}
});

// validation to submit the form
$('input').on('input',function(e){
   if($('#adminForm').find('.valid-input').length==2){
       $('#submit-btn').removeClass('allowed-submit');
       $('#submit-btn').removeAttr('disabled');

       $("#submit-btn").click(function(e){
          e.preventDefault();
          var email = $("#email").val();
          var password = $("#password").val();
         $.ajax({
               type: "POST",
               url: "./main/code.php",
               data: $("#adminForm").serialize()+'&action=admin_login',
               success: function(response){
                 if (response == 'loginOk') {
                     $("#result").css("display", "block");
                     $("#result").addClass('alert-success').removeClass('alert-danger').html("LogIn Successfull redirecting to the Dashboard page");
                     location.replace("admin/index");
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