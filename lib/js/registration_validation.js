
$(function(){
	$('#registrationForm span').hide();
	var authorisation = false;
	
	function emailValidation(email){
		let reg = /^([a-z0-9._-]+)@([a-z0-9._-]+)\.([a-z]{2,6})$/;
		email = reg.test(email);
		return email;
	}

	function passwordValidation(password, confirmationPassword){
		if ((password != '') && (password == confirmationPassword)) {	
			return true;
		} else{
			return false;
		}
	}

	function validateForm(){
		var email = $('#email-field').val();
		var password = $('#pwd-field').val();
		var passwordConfirmaton = $('#pwdconf-field').val();
		email = emailValidation(email);
		password = passwordValidation(password, passwordConfirmaton);
		if (!password) {
			$('#pwd-field').siblings().show();
		} else {
			$('#pwd-field').siblings().hide();
		}
		if (email && password){
			return true;
		} else {
			return false;
		}
	}


	$('#email-field').on('blur', function(){
		let $email = '';  
		$email = emailValidation($(this).val());
		if (!$email) {
			$(this).siblings().text('Invalid email address');
			$(this).siblings().show();
		} else if($email) {
			$(this).siblings().hide();
			$email = $(this).val();
			$.ajax({
				url: 'registration_controller.php',
				type: 'POST',
				data: {
					'check_user_email': 1,
					'email': $email,
				},
				success: function(response){
					if (response) {
						console.log(response);
						response = $.trim(response);
						if (response == 'User exists') {
							$('#email-field').siblings().text('This eamil is already taken');
							$('#email-field').siblings().show();
						} else if(response == 'Saved'){
							authorisation = true;	
						}
					}
				}
			});
		}
	});
	
	$('#registrationForm').on('submit', function(e){
		let result = '';
		result = validateForm();
		if (!result || (authorisation == false)) {
			e.preventDefault();
		}
	});
});