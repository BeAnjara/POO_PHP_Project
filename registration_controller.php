<?php 
	include 'connect_to_db.php';
	 session_start();
 ?>

 <?php 
 		function dataFilter($data){
 			$data = trim($data);
 			$data = stripcslashes($data);
 			$data = htmlspecialchars($data);
 			return $data;
 		}

 		function testPassword($password, $confirmationPassword){
 			$password = dataFilter($password);
 			$confirmationPassword = dataFilter($confirmationPassword);
			if($password == $confirmationPassword):
				$password = sha1($password);
				return $password;
			else:
				throw new Exception("Password did not match!");
			endif;
 		}

 		function testEmail($email){
 			$email = dataFilter($email);
 			if(filter_var($email, FILTER_VALIDATE_EMAIL)):
 				return $email;
 			else:
 				throw new Exception("Invalid email address");
 			endif;
 		}

  ?>
	

<?php 

	/*
	* Client side validation and check if user already exists in database
	*/

	if(isset($_POST['check_user_email'])):
		$email = testEmail($_POST['email']);
		$req = $db->prepare('SELECT username FROM users WHERE email = :email');
		$req->execute(array('email' => $email));
		if($req->fetch()):
			echo "User exists";
			exit();
		else:
			echo "Saved";
			exit();
		endif;
		$req->closeCursor();
	endif;

	/*
	* Server Side Validation 	
	*/

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registration_submit'])):
		$authorisation = false;
		if(isset($_POST['email']) && !empty($_POST['email'])):
			try {
				$email = testEmail($_POST['email']);
				$email = $email;
				$authorisation = true;		
			} catch (Exception $e) {
				$_SESSION['registationErrorEmail'] = $e->getMessage();
				$authorisation = false;
				header('Location: registration_new.php');
			}
		endif;

		if((isset($_POST['password']) && !empty($_POST['password'])) && (isset($_POST['password_confirmaton']) && !empty($_POST['password_confirmaton']))):
			try {
				$password = testPassword($_POST['password'], $_POST['password_confirmaton']);
				$password = $password;
			} catch (Exception $e) {
				$_SESSION['passwordError'] = $e->getMessage();
				$authorisation = false;
				header('Location: registration_new.php');
			}
		endif;
	endif;
	/*
	* Check if User already has an account
	 */

	if(isset($authorisation)):
		$req = $db->prepare('SELECT username FROM users WHERE email = :email');
		$req->execute(array('email' => $email));
		if($req->fetch()):
			$_SESSION['registationErrorEmail'] = 'This eamil is already taken';
			$req->closeCursor();
			header('Location: registration_new.php');
		else:
			
			$req->closeCursor();
			$req = $db->prepare('INSERT INTO users(email, password) VALUES(:email, :password)');
			$req->execute(array(
				'email' => $email,
				'password' => $password
			));
			$_SESSION['user'] = $email;
			$_SESSION['registationSuccess'] = 'Welcome to Mama benz';
			header('Location: index.php');
		endif;
		$req->closeCursor();
	endif;
 ?>

