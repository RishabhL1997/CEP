
<?php
// Start the session
session_start();

// Redirect to login page if user_email is not set in session
if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] != 'Owner') {
    header("Location: login.php");
    exit;
}
?>





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
            background-image: url('images/5.webp');
            background-repeat: no-repeat;
            background-size: 1530px 750px;

			opacity: 0.7;
		}
		 
		.main {
			background-color:rgb(225, 225, 224);

			border-radius: 70px;
			box-shadow: 0 0 20px rgba(105, 105, 105, 0.781);
			padding: 15px 25px;
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
			margin-top: 2px;
			margin-bottom: 2px;
			text-align: left;
			color: #100000;
			font-weight: bold;
		}

		input {
			display: block;
			width: 100%;
			margin-bottom: 2px;
			padding: 8px;
			box-sizing: border-box;
			border: 1px solid #ddd;
			border-radius: 5px;

		}
		select{
			display: block;
			width: 100%;
			margin-bottom: 2px;
			padding: 2px;
			box-sizing: border-box;
			border: 1px solid #ddd;
			border-radius: 5px;

		}
		
		button {
			padding: 2px;
			border-radius: 10px;
			margin-top: 2px;
			margin-bottom: 2px;
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
	<h1>Owner Profile</h1>

	<form action="submit_owner_profile.php" method="POST" enctype="multipart/form-data">
        <!-- Hidden Fields for Email and User Type -->
        <input type="hidden" name="user_email" value="<?php echo $_SESSION['user_email']; ?>">
        <input type="hidden" name="user_type" value="<?php echo $_SESSION['user_type']; ?>">

        <!-- Permanent Address -->
        <label for="permanent_address">Permanent Address:</label>
        <input type="text" name="permanent_address" id="permanent_address" required>
        <br>

        <!-- Alternate Contact Number -->
        <label for="alt_contact_number">Alternate Contact Number:</label>
        <input type="text" name="alt_contact_number" id="alt_contact_number" required>
        <br>

        <!-- Aadhaar Card Upload -->
        <label for="aadhaar_card">Aadhaar Card (PDF/Image):</label>
        <input type="file" name="aadhaar_card" id="aadhaar_card" accept=".pdf,.jpg,.jpeg,.png" required>
        <br>

        <!-- UPI QR Upload -->
        <label for="upi_qr">UPI QR (Image):</label>
        <input type="file" name="upi_qr" id="upi_qr" accept=".jpg,.jpeg,.png" required>
        <br>

        <!-- UPI ID -->
        <label for="upi_id">UPI ID:</label>
        <input type="text" name="upi_id" id="upi_id" required>
        <br>

        <!-- Bank Account Number -->
        <label for="bank_account_number">Bank Account Number:</label>
        <input type="text" name="bank_account_number" id="bank_account_number" required>
        <br>

        <!-- IFSC Number -->
        <label for="ifsc_number">IFSC Number:</label>
        <input type="text" name="ifsc_number" id="ifsc_number" required>
        <br>

        <!-- Submit Button -->
        <button type="submit">Submit</button>
    </form>

</div>
</body>
</html>