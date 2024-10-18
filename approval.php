<?php
// Include the database connection
include 'db_connection.php';
session_start();
// Initialize variables for error and success messages
$error = "";
$success = "";

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

if ($_SESSION['user_type'] == 'Owner') {
    header("Location: dashboard.php"); // Redirect to login page if not logged in
    exit();
}

$tenant_email = $_SESSION['user_email'];



// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get values from POST request
    $owner_email = $_POST['owner_email'];
    $rent_monthly = $_POST['rent_monthly'];
    $date_of_rent = $_POST['date_of_rent'];
    $deposit = $_POST['deposit'];
    $agreement_months = $_POST['agreement_months'];
    $rent_start_date = $_POST['rent_start_date'];
    $tenant_email = $_SESSION['user_email'];

    if ($tenant_email != $owner_email){
            // Check if owner exists in the registration table
        $checkOwnerQuery = "SELECT * FROM registration WHERE EMAIL_ID = '$owner_email'";
        $ownerResult = $conn->query($checkOwnerQuery);

        if ($ownerResult->num_rows > 0) {
            // Owner exists, prepare to insert rental agreement
            
            $insertQuery = "INSERT INTO rental_agreements_approval (Tenant_email, Owner_email, Rent_monthly, Date_of_rent, Agreement_months, Deposit, Insert_date, rent_start_date) 
            VALUES ('$tenant_email', '$owner_email', $rent_monthly, '$date_of_rent', $agreement_months, $deposit, NOW(), '$rent_start_date')";

            
            // Check if the query executes successfully
            if ($conn->query($insertQuery) === TRUE) {
                $success = "Link request submitted.";
            } else {
                $error = "Error: " . $conn->error;
            }
        } else {
            // Owner does not exist
            $error = "Owner email not found in the registration table.";
        }

    }
    else {
        // Owner does not exist
        $error = "Owner email and Tenant Email cannot be same.";
    }


}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
           body {
            margin: 0;
            font-size: 20px;
            background-image: url('images/bg.jpg'); opacity: 9.5;
            background-repeat: no-repeat;
            background-size: cover; /* Cover the entire viewport */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            background-attachment: fixed; /* Make the background image fixed */
            background-position: center; /* Center the background image */
            margin: 20px;
            color: #333; /* Text color */
           
        }
        h2 {
            text-align: center;
        }
        .table-container {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
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
        .main {
			background-color:rgb(225, 225, 224);
			border-radius: 70px;
			box-shadow: 0 0 20px rgba(105, 105, 105, 0.781);
			padding: 15px 25px;
			transition: transform 0.1s;
			width: 460px;
			text-align: center;
            align-items: center;
		}
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Agreement Form</title>
</head>
<body>
    <h2>Rental Agreement Form</h2>

    <!-- Display success message -->
    <?php if ($success): ?>
        <p style="color: green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- Display error message -->
    <?php if ($error): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <div class="main">
    <form action="" method="POST">
        Owner Email: <input type="email" name="owner_email" required><br>
        Rent Monthly Rs: <input type="number" name="rent_monthly" required><br>
        Rent Start Date: <input type="date" name="rent_start_date" required><br> <!-- New Field -->
        Date of Rent: <input type="date" name="date_of_rent" required><br>
        Deposit Amount: <input type="number" name="deposit" required><br>
        Agreement Months: <input type="number" name="agreement_months" required><br>
        <input type="submit" value="Submit">
    </form>
    </div>
</body>
</html>
