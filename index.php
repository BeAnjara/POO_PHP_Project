<?php 
	include 'connect_to_db.php';
	include 'view/header.php';
	session_start();
?>

 <?php 
 	if($_SESSION):
 		if($_SESSION['user']):
 			echo "User connected";
 			echo $_SESSION['user'];
 			echo "<br> <a href='logout.php?id=1'>Logout</a>";
 		else:
 			echo "User not connected";
 		endif;
 	else:
 		echo "Not signed in";
 	endif;
  ?>

 <?php include 'view/footer.php' ?>