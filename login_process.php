<?php
// Start session to store user data after successful login
session_start();

// Include your database connection file
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepare SQL query to fetch user with the provided email
    $sql = "SELECT * FROM registration WHERE EMAIL_ID = '$email'";
    $result = mysqli_query($conn, $sql);

    // Check if the user exists
    if (mysqli_num_rows($result) > 0) {
        // Fetch the user data
        $user = mysqli_fetch_assoc($result);

        // Verify the password with the hashed password in the database
        if (password_verify($password, $user['PASSWORD'])) {
            // Store user data in session (excluding sensitive information)
            $_SESSION['user_id'] = $user['SR_NO'];
            $_SESSION['user_name'] = $user['FULL_NAME'];
            $_SESSION['user_email'] = $user['EMAIL_ID'];
            $_SESSION['user_type'] = $user['USER_TYPE'];

            // Redirect to the dashboard or another page after successful login
            header("Location: dashboard.php");
            exit();
        } else {
            // Password does not match
            header("Location: login.php?error=Incorrect password");
            exit();
        }
    } else {
        // User does not exist
        header("Location: login.php?error=No account found with that email");
        exit();
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
