<?php
// Start session to access session variables
session_start();

// Include the database connection
include 'db_connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Retrieve query string parameters
$serial_no = $_GET['serial_no'];
$owner_email = $_GET['owner_email'];
$rent_amount = $_GET['rent_amount'];

// Fetch owner profile details
$query = "SELECT * FROM owner_profile WHERE user_email = '$owner_email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $owner_data = $result->fetch_assoc();
} else {
    echo "Owner details not found.";
    exit();
}

// Handle receipt upload and payment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate file upload
    if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == 0) {
        $receipt_extension = pathinfo($_FILES['receipt']['name'], PATHINFO_EXTENSION);
        $receipt_filename = bin2hex(random_bytes(16)) . '.' . $receipt_extension; // Generate UUID for file name
        $receipt_path = 'uploads/' . $receipt_filename;

        // Move uploaded file to the uploads directory
        if (move_uploaded_file($_FILES['receipt']['tmp_name'], $receipt_path)) {
            // Update rent_payments table with receipt details
            $updateQuery = "UPDATE rent_payments SET is_paid = 1, receipt_uploaded = '$receipt_path' WHERE serial_no = $serial_no";
            if ($conn->query($updateQuery) === TRUE) {
                header("Location: dashboard.php?message=Payment successful&status=success");
                exit();
            } else {
                echo "Error updating payment record: " . $conn->error;
            }
        } else {
            echo "Failed to upload receipt.";
        }
    } else {
        echo "Please upload a valid receipt.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
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
        .container {
            width: 80%;
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 50px;
            border-radius: 8px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
        }
        .content p {
            font-size: 18px;
            margin-bottom: 15px;
        }
        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
        .qr-code img {
            max-width: 200px;
        }
        .form-container {
            margin-top: 30px;
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Payment Details</h2>
    </div>
    <div class="content">
        <p><strong>Owner Email:</strong> <?php echo htmlspecialchars($owner_email); ?></p>
        <p><strong>Bank Account Number:</strong> <?php echo htmlspecialchars($owner_data['bank_account_number']); ?></p>
        <p><strong>IFSC Code:</strong> <?php echo htmlspecialchars($owner_data['ifsc_number']); ?></p>

        <div class="qr-code">
            <p><strong>UPI QR Code:</strong></p>
            <img src="<?php echo htmlspecialchars($owner_data['upi_qr_path']); ?>" alt="QR Code">
        </div>
    </div>

    <div class="form-container">
        <h3>Pay Rent</h3>
        <form method="POST" enctype="multipart/form-data">
            <label for="rent_amount">Rent Amount:</label>
            <input type="text" value="<?php echo htmlspecialchars($rent_amount); ?>" readonly>

            <label for="receipt">Upload Payment Receipt:</label>
            <input type="file" name="receipt" required>

            <button type="submit">Submit Payment</button>
        </form>
    </div>
</div>

</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
