<?php
// Include the database connection
include 'db_connection.php';

// Start session to access session variables
session_start();

// Initialize variables for messages
$message = "";

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

if ($_SESSION['user_type'] == 'Tenant') {
    header("Location: dashboard.php"); // Redirect to dashboard if the user is a tenant
    exit();
}

$owner_email = $_SESSION['user_email'];


// Handle approval or rejection
if (isset($_POST['action'])) {
    $agreement_id = $_POST['agreement_id'];
    $is_approved = ($_POST['action'] === 'approve') ? 1 : 0;

    // Update the rental agreement's approval status
    $updateQuery = "UPDATE rental_agreements_approval SET Is_approved = $is_approved WHERE Srno = $agreement_id AND Owner_email = '$owner_email'";
    
    if ($conn->query($updateQuery) === TRUE) {
        $message = "Record updated successfully.";

        // Insert into rent_payments table if approved
        if ($is_approved) {
            // Fetch details from rental_agreements_approval table
            $fetchQuery = "SELECT * FROM rental_agreements_approval WHERE Srno = $agreement_id";
            $agreementResult = $conn->query($fetchQuery);
            
            if ($agreementResult->num_rows > 0) {
                $agreement = $agreementResult->fetch_assoc();

                $tenant_email = $agreement['Tenant_email'];
                $rent_monthly = $agreement['Rent_monthly'];
                $rent_start_date = new DateTime($agreement['rent_start_date']);
                $agreement_months = $agreement['Agreement_months'];

                // Insert records into rent_payments for each month starting from rent_start_date
                for ($i = 0; $i < $agreement_months; $i++) {
                    // Set rent_date as the starting date plus the month offset
                    $rent_date = (clone $rent_start_date)->modify("+$i month")->format('Y-m-d');
                    
                    $insertQuery = "INSERT INTO rent_payments (tenant_email, owner_email, rent_date, rent_amount, is_paid, month, rental_agreements_approval_id)
                                    VALUES ('$tenant_email', '$owner_email', '$rent_date', $rent_monthly, 0, '$rent_date', $agreement_id)";

                    if ($conn->query($insertQuery) !== TRUE) {
                        $message .= " Error inserting rent payment record: " . $conn->error;
                    }
                }
            }
        }
    } else {
        $message = "Error updating record: " . $conn->error;
    }
}

// Fetch rental agreements for the owner
$query = "SELECT * FROM rental_agreements_approval WHERE Owner_email = '$owner_email' AND Is_approved !=1 ;";
$result = $conn->query($query);
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
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Agreements</title>
</head>
<body>
    <h2>Rental Agreements</h2>

    <!-- Display message -->
    <?php if ($message): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <table border="1">
        <tr>
            <th>Tenant Email</th>
            <th>Rent Monthly</th>
            <th>Rent Start Date</th>
            <th>Date of Rent</th>
            <th>Agreement Months</th>
            <th>Deposit</th>
            <th>Is Approved</th>
            <th>Actions</th>
        </tr>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Tenant_email']); ?></td>
                    <td><?php echo htmlspecialchars($row['Rent_monthly']); ?></td>
                    <td><?php echo htmlspecialchars($row['rent_start_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['Date_of_rent']); ?></td>
                    <td><?php echo htmlspecialchars($row['Agreement_months']); ?></td>
                    <td><?php echo htmlspecialchars($row['Deposit']); ?></td>
                    <td><?php echo $row['Is_approved'] ? 'Yes' : 'No'; ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="agreement_id" value="<?php echo ($row['Srno']); ?>">
                            <input type="hidden" name="tenant_email" value="<?php echo htmlspecialchars($row['Tenant_email']); ?>">
                            <input type="hidden" name="rent_monthly" value="<?php echo htmlspecialchars($row['Rent_monthly']); ?>">
                            <input type="hidden" name="date_of_rent" value="<?php echo htmlspecialchars($row['Date_of_rent']); ?>">
                            <input type="hidden" name="agreement_months" value="<?php echo htmlspecialchars($row['Agreement_months']); ?>">
                            <input type="hidden" name="deposit" value="<?php echo htmlspecialchars($row['Deposit']); ?>">
                            <input type="submit" name="action" value="approve">
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="agreement_id" value="<?php echo ($row['Srno']); ?>">
                            <input type="hidden" name="tenant_email" value="<?php echo htmlspecialchars($row['Tenant_email']); ?>">
                            <input type="hidden" name="rent_monthly" value="<?php echo htmlspecialchars($row['Rent_monthly']); ?>">
                            <input type="hidden" name="date_of_rent" value="<?php echo htmlspecialchars($row['Date_of_rent']); ?>">
                            <input type="hidden" name="agreement_months" value="<?php echo htmlspecialchars($row['Agreement_months']); ?>">
                            <input type="hidden" name="deposit" value="<?php echo htmlspecialchars($row['Deposit']); ?>">
                            <input type="submit" name="action" value="reject">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="8">No rental agreements found.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
