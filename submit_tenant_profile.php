<?php
// Start the session
session_start();

// Check if the user is logged in and is a tenant
if (!isset($_SESSION['user_email']) || $_SESSION['user_type'] != 'Tenant') {
    header("Location: login.php");
    exit;
}

// Include database connection (modify this according to your setup)
include 'db_connection.php';

// Function to generate a UUID for filenames
function generateUUID() {
    return bin2hex(random_bytes(16));  // Generates a 32-character unique ID
}

// Define the directory where files will be stored
$upload_dir = 'uploads/';

// Collect the form data
$user_email = $_SESSION['user_email'];
$user_type = $_SESSION['user_type'];
$college_name = $_POST['college_name'];
$permanent_address = $_POST['permanent_address'];
$alt_contact_number = $_POST['alt_contact_number'];
$upi_id = $_POST['upi_id'];
$bank_account_number = $_POST['bank_account_number'];
$ifsc_number = $_POST['ifsc_number'];

// Handle Aadhaar Card file upload
if (isset($_FILES['aadhaar_card']) && $_FILES['aadhaar_card']['error'] == 0) {
    $aadhaar_card_extension = pathinfo($_FILES['aadhaar_card']['name'], PATHINFO_EXTENSION);
    $aadhaar_card_filename = generateUUID() . '.' . $aadhaar_card_extension;
    $aadhaar_card_path = $upload_dir . $aadhaar_card_filename;

    // Move the file to the upload directory
    move_uploaded_file($_FILES['aadhaar_card']['tmp_name'], $aadhaar_card_path);
}

// Handle UPI QR file upload
if (isset($_FILES['upi_qr']) && $_FILES['upi_qr']['error'] == 0) {
    $upi_qr_extension = pathinfo($_FILES['upi_qr']['name'], PATHINFO_EXTENSION);
    $upi_qr_filename = generateUUID() . '.' . $upi_qr_extension;
    $upi_qr_path = $upload_dir . $upi_qr_filename;

    // Move the file to the upload directory
    move_uploaded_file($_FILES['upi_qr']['tmp_name'], $upi_qr_path);
}

// Insert form data into the database
// $sql = "INSERT INTO tenant_profile (user_email, user_type, college_name, permanent_address, alt_contact_number, aadhaar_card_path, upi_qr_path, upi_id, bank_account_number, ifsc_number) 
//         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$sql = "INSERT INTO tenant_profile (user_email, user_type, college_name, permanent_address, alt_contact_number, aadhaar_card_path, upi_qr_path, upi_id, bank_account_number, ifsc_number) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE 
            user_type = VALUES(user_type),
            college_name = VALUES(college_name),
            permanent_address = VALUES(permanent_address),
            alt_contact_number = VALUES(alt_contact_number),
            aadhaar_card_path = VALUES(aadhaar_card_path),
            upi_qr_path = VALUES(upi_qr_path),
            upi_id = VALUES(upi_id),
            bank_account_number = VALUES(bank_account_number),
            ifsc_number = VALUES(ifsc_number)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssss", $user_email, $user_type, $college_name, $permanent_address, $alt_contact_number, $aadhaar_card_path, $upi_qr_path, $upi_id, $bank_account_number, $ifsc_number);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    echo "Tenant profile submitted successfully.";
    header("Location: dashboard.php?message=Profile submitted successfully.&status=success");
    exit;
} else {
    $stmt->close();
    $conn->close();
    echo "Error: " . $stmt->error;
    header("Location: dashboard.php?message=Error submitting profile.&status=error");
    exit;
}

?>
