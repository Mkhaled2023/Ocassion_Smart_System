<!DOCTYPE html>
<html>
<head>
	<title>SignUp and Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>


<body>
<div class="container" id="container">

            @yield('content')
            <div class="overlay-container">
	<div class="overlay">
		<div class="overlay-panel overlay-left">
			<h2>Welcome Back!</h2>
			<p>Sign in now and enjoy our feature and Services </p>
			<button class="ghost" id="signIn">Sign In</button>
		</div>
		<div class="overlay-panel overlay-right">
			<h2>Welcome</h2>
			<p>Dont have an Account!?,sign up now </p>
			<button class="ghost" id="signUp">Sign Up</button>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	const signUpButton = document.getElementById('signUp');
	const signInButton = document.getElementById('signIn');
	const container = document.getElementById('container');

	signUpButton.addEventListener('click', () => {
		container.classList.add("right-panel-active");
	});
	signInButton.addEventListener('click', () => {
		container.classList.remove("right-panel-active");
	});
</script>


</body>
</html>







