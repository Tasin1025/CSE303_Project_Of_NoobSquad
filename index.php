<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>LOGIN</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="box">
		<form action="login.php" method="post">
			<center><img src="logo.png" width="140" height="112"></center>
			<h2>Sign in</h2>
			<input type="text" name = "id" id="userField" placeholder="User ID" required="required">
			<input type="password" name = "pass" id="Password" placeholder="Password" >

			<div class="links">
				<a href="#" class="forgot-pass">Forgot Password ?</a>
			</div>
			<input type="submit" id="login" value="Login">
		</form>
	</div>
	<script src="/js/index.js"></script>

</body>
</html>