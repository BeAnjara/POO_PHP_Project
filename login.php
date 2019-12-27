<?php 
	include 'connect_to_db.php';
	include 'view/header.php';
	session_start();
?>

<form action="login_controller.php" class="offset-md-3 col-md-6">
	<div class="form-group">
		Email: <input type="text" class="form-control" name="email">
	</div>

	<div class="form-group">
		Password: <input type="text" class="form-control" name="password">
	</div>

	<button class="btn btn-primary" name="login"> Log in</button>
</form>


<?php include 'view/footer.php' ?>
