<?php
if ($_SERVER['REQUEST_METHOD']== $_POST){
	header('Location: login/authenticate');
}
?>
<html>
<head>
<meta charset="UTF-8">
<title>Smartest Farm Login</title>
<link rel="stylesheet" href="Views/login/css/style.css">
</head>

<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#"> <img alt="Brand"
				src="logo.png">
			</a>-->
			</div>
		</div>
	</nav>
	<div class="wrapper">
		<div class="container">
			<?php if (isset($this->msg)){ ?>
			<h3>Login Failed, Please try again</h3>
			<?php }?>
			<h1>Welcome</h1>
			<form action="login/authenticate" class="form" method="POST">
				<input type="text" placeholder="Username" name="username" autocomplete="off">
				 <input type="password"	placeholder="Password" name="password" autocomplete="off">
				<button type="submit" id="login-button">Login</button>
			</form>
		</div>
	</div>

	<script
		src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

	<script src="Views/login/js/index.js"></script>
</body>
</html>