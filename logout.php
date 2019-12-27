<?php 
	session_start();
	if(isset($_GET['id'])):
		session_unset();
		session_destroy();
		header('Location: registration_new.php');
	endif;
 ?>