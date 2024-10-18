<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<style>
		body {
			font-family: Arial, sans-serif;
			background-color : #ffffff;
            display: flex;
			justify-content: center;
			align-items: center;
            background-image: url('images/bg.jpg');
            background-repeat: no-repeat;
            background-size: 1550px 750px;

			opacity: 0.7;
		}
		 
		.main {
			background-color:rgb(225, 225, 224);

			border-radius: 70px;
			box-shadow: 0 0 20px rgba(105, 105, 105, 0.781);
			padding: 10px 25px;
			transition: transform 0.1s;
			width: 460px;
			text-align: center;
		}
		
		h1 {
			color: #3b3b3a;
		}
		
		label {
			display: block;
			width: 100%;
			margin-top: 10px;
			margin-bottom: 5px;
			text-align: left;
			color: #100000;
			font-weight: bold;
		}

	



		
		input {
			display: block;
			width: 100%;
			margin-bottom: 10px;
			padding: 10px;
			box-sizing: border-box;
			border: 1px solid #ddd;
			border-radius: 5px;

		}
		select{
			display: block;
			width: 100%;
			margin-bottom: 10px;
			padding: 10px;
			box-sizing: border-box;
			border: 1px solid #ddd;
			border-radius: 5px;

		}
		
		button {
			padding: 15px;
			border-radius: 10px;
			margin-top: 15px;
			margin-bottom: 15px;
			border: none;
			color: white;
			cursor: pointer;
			background-color: #4CAF50;
			width: 100%;
			font-size: 16px;
		}
		
		.wrap {
			display: flex;
			justify-content: center;
			align-items: center;
		}
	</style>
</head>
<body>
<div class="main">
	<h1>Create An Account</h1>
	<form action="register.php" method="POST">
		<label>Register As:</label><br>
		<select name="user_type" id="user_type" required>
			<option value="Tenant">Tenant</option>
			<option value="Owner">Owner</option>
		</select>

		<label for="username">Username:</label>
		<input type="text" id="username" name="username" placeholder="Enter your Username" required>

		<label for="contactno">Contact No:</label>
		<input type="text" id="contactno" name="contactno" placeholder="Enter your Contact No" required>

		<label for="email">Email:</label>
		<input type="email" id="email" name="email" placeholder="Enter your Email" required>

		<label for="password">Password:</label>
		<input type="password" id="password" name="password" placeholder="Enter your Password" required>

		<label for="confirm-password">Confirm Password:</label>
		<input type="password" id="confirm-password" name="confirm-password" placeholder="Confirm your Password" required>

		<div class="wrap">
			<button type="submit">Submit</button>
		</div>
	</form>

	<p>Already have an account? <a href="login.php" style="text-decoration: none;">Login</a></p>
</div>
</body>
</html>