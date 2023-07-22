<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>Document</title>
</head>
<body>
<div class="card">
    <div class="card-header">
      <h5 class="mb-0">External User Management</h5>
    </div>
    <div class="card-body bg-light">
      <div class="row">
        <div class="col-3">
          <!-- // -->
          <div class="wrapper">
        <h2></h2>
        <p>Please fill this form to create an account.</p>
        <form action="" method="post" id="formus">
            <div class="form-group">
                <label>Fist Name</label>
                <input type="text" name="fname" id="fname" class="form-control">
                <span id="invalid-feedback1"></span>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lname" id="lname" class="form-control">
                <span id="invalid-feedback1"></span>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" class="form-control">
                <span id="invalid-feedback1"></span>
            </div>        
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <span id="invalid-feedback2"></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                <span id="invalid-feedback3"></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            
        </form>
    </div>  
<!-- // -->
        </div>
      </div>
    </div>
  </div>
  <!-- close gutter -->
</body>
</html>
    

  <script>
$('#formus').submit(function(e){
    e.preventDefault();
var email = $('#email').val();
var fname = $('#fname').val();
var lname = $('#lname').val();
var pwrd = $('#password').val();
var c_pwrd = $('#confirm_password').val();

if(fname == '') {
$('#invalid-feedback1').html('First name required');
$('#invalid-feedback2').html('');
$('#invalid-feedback3').html('');
} else if(pwrd == '') {
    $('#invalid-feedback2').html('Invalid password');
    $('#invalid-feedback3').html('');
    $('#invalid-feedback1').html('');
} else if((pwrd).length < 6) {
  $('#invalid-feedback2').html('Min length should be 6 characters');
    $('#invalid-feedback3').html('');
    $('#invalid-feedback1').html('');
} else if(c_pwrd != pwrd) {
    $('#invalid-feedback3').html('Password mismatch!');
    $('#invalid-feedback2').html('');
    $('#invalid-feedback1').html('');
} else {
    $.ajax({
      url: "_adduser.php", 
      type: "POST", 
      data: {
        fn: fname,
        ln: lname,
        em: email,
        pw: pwrd,
        pwtwo: c_pwrd
      },
      success: function(result) {
    alert(result);
      }
    });

}
})
      </script>

