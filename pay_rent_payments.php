<?php
// Start session to access session variables
session_start();

// Include the database connection
include 'db_connection.php';

// Initialize variables for messages
$message = "";

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch rent payments data
$query = "SELECT * FROM rent_payments";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pay Rent Payments</title>
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
    </style>
</head>
<body>
    <h2>Pay Rent Payments</h2>

    <div class="table-container">
        <table>
            <tr>
                <th>Serial No</th>
                <th>Owner Email</th>
                <th>Rent Date</th>
                <th>Rent Amount</th>
                <th>Is Paid</th>
                <th>Month</th>
                <th>Actions</th> <!-- Replacing Download button with Pay button -->
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['serial_no']); ?></td>
                        <td><?php echo htmlspecialchars($row['owner_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['rent_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['rent_amount']); ?></td>
                        <td><?php echo $row['is_paid'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo htmlspecialchars($row['month']); ?></td>
                        <td>
                            <?php if (!$row['is_paid']): ?>
                                <!-- Pay button redirects to payment_page.php -->
                                <a href="payment_page.php?serial_no=<?php echo urlencode($row['serial_no']); ?>&owner_email=<?php echo urlencode($row['owner_email']); ?>&rent_amount=<?php echo urlencode($row['rent_amount']); ?>">
                                    <button type="button">Pay</button>
                                </a>
                            <?php else: ?>
                                Paid
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">No rent payment records found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
