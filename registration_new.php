<?php 
	include 'connect_to_db.php';
	include 'view/header.php';
	 session_start();

 ?>

 	<form action="registration_controller.php" id="registrationForm" class="offset-md-3 col-md-6" method="POST">
 		
 		<div class="form-group">
 			Email: <input type="text" class="form-control" id="email-field" name="email" placeholder="Enter your email address" required>
 			<span style="color: red; display: none;">Invalid email address</span>
 			 
 			<? if(isset($_SESSION['registationErrorEmail'])): ?>
				<span style="color: red;"><?= $_SESSION['registationErrorEmail'] ?></span>
			<? unset($_SESSION['registationErrorEmail']); ?>
 			<? endif; ?>
 			
 		</div>

 		<div class="form-group">
 			Password: <input type="password" class="form-control" name="password" id="pwd-field" pattern=".{6,}" title="6 characters minimum" required>
 			<span style="color: red; display: none;">Password did not match</span>
 			<? if(isset($_SESSION['passwordError'])): ?>
				<span style="color: red;"><?= $_SESSION['passwordError'] ?></span>
			<? unset($_SESSION['passwordError']); ?>
 			<? endif; ?>
 		</div>

 		<div class="form-group">
 			Confirmation: <input type="password" class="form-control" name="password_confirmaton" id="pwdconf-field">
 		</div>

 		<div class="form-group">
 			<button class="btn btn-primary" name="registration_submit">Sign Up</button>
 		</div>

 	</form>
 <?php include 'view/footer.php' ?>
