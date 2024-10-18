<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
        <h1>Login</h1>

        <!-- Display success message if it exists in the URL -->
        <?php
        if (isset($_GET['message'])) {
            echo '<p style="color: green;">' . htmlspecialchars($_GET['message']) . '</p>';
        }
        if (isset($_GET['error'])) {
            echo '<p style="color: red;">' . htmlspecialchars($_GET['error']) . '</p>';
        }
        ?>

        <form action="login_process.php" method="POST">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your Email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your Password" required>

            <div class="wrap">
                <button type="submit">Login</button>
            </div>
        </form>

        <p>Don't have an account? <a href="registration1.php" style="text-decoration: none;">Register</a><br>
            Forget Password?      <a href="forget.php" style="text-decoration: none;">Click Here</a></p>
        
    </div>
</body>
</html>
