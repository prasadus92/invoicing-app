$(function(){
	var username = $('#session_username');
	var password = $('#session_password');
	
	$('#login_user').live("click",function(){
		if(validateUsername() && validatePassword())
		{
			data = 'username=' + username.val() + '&password=' + password.val();
			$.post('libs/login.php',data,function(response){
				if(response == 'true' || response == ' true')
				{
					window.location = 'index.php';
				}
				else
				{
					$('#login_form_inner_wrapper .alert-box').removeClass('hidden');
					$('#login_form_inner_wrapper .alert-box').html(response);
				}
			});
		}
		return false;
	});
	
	function validateUsername(){
		if(username.val().length == 0)
		{
			$(username).addClass('error');
			return false;
		}
		else
		{
			$(username).removeClass('error');
			return true;
		}
	}

	function validatePassword(){
		if(password.val().length == 0)
		{
			$(password).addClass('error');
			return false;
		}
		else
		{
			$(password).removeClass('error');
			return true;
		}
	}

	/* TOGGLE LOGIN AND PASSWORD FORGOT BOX */
	
	$('#showPassword').click(function(){
		$('.login_box').addClass('hidden');
		$('#form_heading').html('Forgot Password');
		$('.password_box').removeClass('hidden');
		return false;
	});

	$('#showLogin').click(function(){
		$('.login_box').removeClass('hidden');
		$('#form_heading').html('Login Here');
		$('.password_box').addClass('hidden');
		return false;
	});
	
	$('.action_login_form_inner_wrapper').live("click",function(){
		$('.form_wrappers').addClass('hidden');
		$('#login_form_inner_wrapper').removeClass('hidden');
		return false;
	});
	
	$('#action_register_form_inner_wrapper').click(function(){
		$('.form_wrappers').addClass('hidden');
		$('#register_form_inner_wrapper').removeClass('hidden');
		return false;
	});

	$('#action_fPassword_form_inner_wrapper').live("click",function(){
		$('.form_wrappers').addClass('hidden');
		$('#fPassword_form_inner_wrapper').removeClass('hidden');
		return false;
	});

	/* REGISTRATION PROCESS */
	
	$('#register_user').click(function(){
		if(validateRegisterUsername() && validateRegisterEmail() && validateRegisterPassword() && validateRegisterRePassword())
		{
			register_data = 'register_username=' + $('#register_username').val() + '&register_email=' + $('#register_email').val() + '&register_password=' + $('#register_password').val();
			$.post('libs/register.php',register_data,function(response){
				if(response == 'true' || response == ' true')
				{
					$('#register_form_inner_wrapper .alert-box').removeClass('hidden').removeClass('alert').addClass('success');
					$('#register_form_inner_wrapper .alert-box').html('Registered Successfully');
				}
				else if(response == 'email' || response == ' email')
				{
					$('#register_form_inner_wrapper .alert-box').removeClass('hidden').removeClass('alert').addClass('success');
					$('#register_form_inner_wrapper .alert-box').html('Registered Successfully, check your email to verify your account');
				}
				else
				{
					$('#register_form_inner_wrapper .alert-box').removeClass('hidden').removeClass('success').addClass('alert');
					$('#register_form_inner_wrapper .alert-box').html(response);
				}
			});
		}
		return false;
	});
	
	function validateRegisterUsername(){
		if($('#register_username').val().length == 0)
		{
			$('#register_username').addClass('error');
			return false;
		}
		else
		{
			$('#register_username').removeClass('error');
			return true;
		}
	}
	
	function validateRegisterEmail(){
		var email_regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
		var this_email = $('#register_email').val();
		if($('#register_email').val().length == 0)
		{
			$('#register_email').addClass('error');
			return false;
		}
		else if(email_regex.test(this_email))
		{
			$('#register_email').removeClass('error');
			return true;
		}
		else
		{
			$('#register_email').addClass('error');
			return false;
		}
	}

	function validateRegisterPassword(){
		if($('#register_password').val().length == 0)
		{
			$('#register_password').addClass('error');
			return false;
		}
		else
		{
			$('#register_password').removeClass('error');
			return true;
		}
	}

	function validateRegisterRePassword(){
		if($('#register_re_password').val().length == 0)
		{
			$('#register_re_password').addClass('error');
			return false;
		}
		else
		{
			if($('#register_re_password').val() !== $('#register_password').val())
			{
				$('#register_re_password').addClass('error');
				$('#register_password').addClass('error');
				return false;
			}
			else
			{
				$('#register_re_password').removeClass('error');
				$('#register_password').removeClass('error');
				return true;
			}
		}
	}

	/* FORGOT PASSWORD OPTION */

	$('#get_password').live("click",function(){
		if(validateEmail())
		{
			passwordData = 'password_email=' + $('#password_email').val();
			$.post('libs/forgotPassword.php',passwordData,function(response){
				if(response == 'true' || response == ' true')
				{
					$('#fPassword_form_inner_wrapper').find('.alert-box').removeClass('hidden').removeClass('error').addClass('success').html('Password Sent');
				}
				else
				{
					$('#fPassword_form_inner_wrapper').find('.alert-box').removeClass('hidden').html(response);
				}
			})
		}
		return false;
	});

	function validateEmail(){
		if($('#password_email').val().length == 0)
		{
			$('#password_email').addClass('error');
			$('.password_email_error').html('Email is required');
			return false;
		}
		else
		{
			$('#password_email').removeClass('error');
			$('.password_email_error').html('');
			return true;
		}
	}


});