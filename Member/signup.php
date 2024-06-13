<?php
session_start();
ob_start(); 
include '../Include/connect.php';

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Blood Buzz-Sign up</title>
    <link rel="stylesheet" href="../Style/style.css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="icon" href="../img/logo.png" type="image/x-icon" />
	<script src="../File/jquery.js"></script>
	<script src="../File/js/bootstrap.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <style>
        #signup{
            background-color: crimson;
            color: white;
        }
        .back_to_login{
            color:rgb(227,103,128);
        }
        .back_to_login{
			color:crimson;
		}
        body{
            background-color: rgb(252, 231, 231);
        }
		input[type="radio"]
        {
            transform: scale(1.4); /* Adjust the scale factor as needed */
        }
		.message {
		display: block;
		margin-top: 5px;
		color: red; /* Default color for warnings */
		}
		.valid-sign {
			color: green;
		}
		.invalid-sign {
			color: red;
		}
    </style>
        <script type="text/javascript">
            $(document).ready(function()
			{
                $(".state").change(function()
				{
                    var state_id=$(this).val();
                    $.ajax({
							url:"statecity.php",
							method:"POST",
							data:{state_id:state_id},
							success:function(data)
							{
								$(".city").html(data);
							}
                    	});
                });  
            });
        </script>

		<script>
		document.addEventListener("DOMContentLoaded", function() {
			var today = new Date();
			var maxDate = new Date(today.getFullYear() - 18, today.getMonth(), today.getDate()).toISOString().split('T')[0];
			var minDate = new Date(today.getFullYear() - 118, today.getMonth(), today.getDate()).toISOString().split('T')[0]; // Assuming max age is 118
			
			document.getElementById("birthdate").setAttribute("max", maxDate);
			document.getElementById("birthdate").setAttribute("min", minDate);
		});
		</script>
		
  </head>
 <body>


<?php
if(isset($_SESSION['signup-error-message'])) {
    echo "<script>
            swal({
              icon: 'error',
              title: 'Error',
              text: '{$_SESSION['signup-error-message']}'
            });
          </script>";
    unset($_SESSION['signup-error-message']);
}

elseif(isset($_SESSION['signup-message'])) {
    echo "<script>
            swal({
              icon: 'success',
              title: 'Signed up',
              text: '{$_SESSION['signup-message']}',
              timer: 2000,
              showConfirmButton: false
            }).then(function() {
                window.location.href = 'login.php';
            });
          </script>";
    unset($_SESSION['signup-message']);
}
?>


<form autocomplete="off" action="signupCode.php" method="POST" id="signupForm" enctype="multipart/form-data" >	
     <section class="ftco-section">
		<div class="container-fluid" style="height:100%;margin-top:100px;">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(../img/login.jpg);height:1100px">
			      </div>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">The gift of blood is a gift to someone's life.</h3>
			      		</div>
			      	</div>
              <input type="hidden" id="action" value="register">
              <div class="row">
                <div class="col-6">
                <div class="form-group mb-3">
			      			<label class="label" for="fname">First Name</label>
			      			<input type="text" id="fname" name="fname" class="form-control" placeholder="First Name" required pattern="[A-Za-z]{4,}">
			      		</div></div>

                <div class="col-6"><div class="form-group mb-3">
			      			<label class="label" for="lname">Last Name</label>
			      			<input type="text" id="lname"  name="lname" class="form-control" placeholder="Last Name" required pattern="[A-Za-z]{4,}">
			      		</div></div>

              </div>
			      		<div class="form-group mb-3">
			      			<label class="label">Email</label>
			      			<input type="email" id="email"  name="email" class="form-control" placeholder="email" required>
			      		</div>
						  <div class="row">
					<div class="col-6">
                <div class="form-group mb-3">
				<label class="label">Password</label>
				<input type="password" id="password"  name="pwd" class="form-control" placeholder="Password" required minlength="8"><br>
				<span id="lengthMessage" class="message"></span>
				<span id="uppercaseMessage" class="message"></span>
				<span id="specialCharMessage" class="message"></span>
				<span id="passwordStatus" class="message"></span>
			      		</div></div>

                <div class="col-6"><div class="form-group mb-3">
				<label class="label">Confirm Password</label>
				<input type="password" id="cpassword"  name="cpwd" class="form-control" placeholder="Confirm Password" required minlength="8">
			      		</div></div></div>
                    
                    <div class="form-group mb-3">
		            	<label class="label">Profile Pic</label>
		              <input type="file" id="pfp"  name="pfp" class="form-control" accept="image/*">
		            </div>
                    
                    <div class="form-group mb-3">
		            	<label class="label">Contact Number</label>
		              <input type="text" placeholder="Contact Number" maxlength=10 name="cno" pattern=[0-9]{10} class="form-control" required>
		            </div>

					<div class="row">
						<div class="col-6">
						<div class="form-group mb-3">
							<label class="label">Gender</label><br>
							<input type="radio" name="gen" checked value="Male">&nbsp;Male&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="gen" Value="Female">&nbsp;Female&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="gen" Value="Other">&nbsp;Other
						</div></div>
						<div class="col-6"><div class="form-group mb-3">
							<label class="label">Date of Birth</label>
                    	    <input type="date" name="dob" required class="form-control" placeholder="Date of Birth" id="birthdate"/> 
						</div></div>
					  </div>

                    <div class="form-group mb-3">
		            	<label class="label">Address</label>
                        <textarea name="add" cols="30" rows="3" required class="form-control" placeholder="Address" pattern="[A-Za-z]{10,}"></textarea>
		            </div>
					<div class="row">
						<div class="col-6">
						<div class="form-group mb-3">
						<label class="label" for="state">State</label>
						<select id="state"  name="state" class="state form-control" required>
							<option selected disabled>Select State</option>
							<?php 
							$state="SELECT * FROM states ORDER BY state_name";
							$state_run=mysqli_query($connection,$state);
							while($display_state=mysqli_fetch_array($state_run))
							{ ?>
							<option value="<?php echo $display_state['state_id']; ?>"><?php echo $display_state['state_name'];  ?></option>
							<?php	
							}
							?>
						</select> 
						</div></div>
		
						<div class="col-6"><div class="form-group mb-3">
									  <label class="label" for="city">City</label>
									  <select id="city" name="city" class=" city form-control" required>
									  <option disabled selected>Select City</option>
            						<p id="place_city"></p></select>
						</div></div>
		
					  </div>
					  <div class="row">
						<div class="col-6">
						<div class="form-group mb-3">
									  <label class="label" for="ldmk">Landmark</label>
									  <input type="text" id="ldmk" name="ldmk" class="form-control" placeholder="Landmark" required pattern="[A-Za-z]{4,}">
								  </div></div>
		
						<div class="col-6"><div class="form-group mb-3">
									  <label class="label" for="pin">Pincode</label>
									  <input type="text" id="pcode" name="pin" class="form-control" placeholder="Pincode" maxlength=6 pattern=[0-9]{6} required>
								  </div></div>
					  </div>

		            <div class="form-group">
					<button type="submit" style="cursor:pointer;"  name="signup" class="form-control" id="signup">Sign Up</button>

		            </div>
		           
		          <p class="text-center"><a data-toggle="tab" href="./login.php" class="back_to_login">Alreadt have an account ? Login here.</a></p>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>
	</form>

	<!-- for password -->
	<script>
    const passwordInput = document.getElementById('password');
    const lengthMessage = document.getElementById('lengthMessage');
    const uppercaseMessage = document.getElementById('uppercaseMessage');
    const specialCharMessage = document.getElementById('specialCharMessage');
    const passwordStatus = document.getElementById('passwordStatus');

    passwordInput.addEventListener('keyup', function() {
      const password = passwordInput.value;
      
      // Check length
      lengthMessage.textContent = password.length >= 8 ? '' : '✘Password must be at least 8 characters long';
      lengthMessage.className = password.length >= 8 ? 'valid-sign' : 'invalid-sign';
      lengthMessage.style.display = password.length >= 8 ? 'none' : 'block';

      // Check for uppercase letter
      uppercaseMessage.textContent = /[A-Z]/.test(password) ? '' : '✘Atleast one uppercase letter';
      uppercaseMessage.className = /[A-Z]/.test(password) ? 'valid-sign' : 'invalid-sign';
      uppercaseMessage.style.display = /[A-Z]/.test(password) ? 'none' : 'block';

      // Check for special character
      specialCharMessage.textContent = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password) ? '' : '✘Atleast one special character';
      specialCharMessage.className = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password) ? 'valid-sign' : 'invalid-sign';
      specialCharMessage.style.display = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password) ? 'none' : 'block';

      // Check overall password status
      const isValidPassword = password.length >= 8 && /[A-Z]/.test(password) && /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
      passwordStatus.textContent = isValidPassword ? '✔Password is strong' : '✘Password is not strong';
      passwordStatus.className = isValidPassword ? 'valid-sign' : 'invalid-sign';
      passwordStatus.style.display = password ? 'block' : 'none';
    });
  </script>



  </body>
</html>

