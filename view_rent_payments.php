<?php 
    session_start(); 
    if (!isset($_SESSION['user_name'])) {
        // If not set, redirect to login page
        header("Location: login.php");
        exit;
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Rental Dashboard</title>
    <style>
       
        header {
            
            color: white;
            padding: 20px;
            text-align: left;
            position: relative;
        }
        .sidebar {
            width: 250px;
           
            padding: 15px;
            position: fixed;
            height: 100%;
            left: -250px;
            transition: left 0.3s;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            z-index: 1000;
        }
        .sidebar.active {
            left: 0;
        }
        .sidebar h2 {
            font-size: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin: 15px 0;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #333;
        }
        .sidebar ul li a:hover {
            text-decoration: underline;
        }
        .sign-out {
            margin-top: auto; /* Push the sign out button to the bottom */
            padding: 10px;
            background-color: #e74c3c;
            color: white;
            text-align: center;
            cursor: pointer;
            border: none;
            border-radius: 5px;
        }
        .sign-out:hover {
            background-color: #c0392b;
        }
        .hamburger {
            font-size: 30px;
            cursor: pointer;
        }
        .main-content {
            padding: 20px;
	margin-left: 30px;
        }
 /* Header navigation links */
 .nav-links {
            display: flex;
            gap: 1px;
            font-size: medium;
            justify-content: right;
        }

        .nav-links a {
            color: rgb(0, 0, 0);
            font-family: 'Times New Roman', Times, serif;
            opacity: 0.5;
            text-decoration: none;
            padding: 5px 15px;
            font-size: 24px;
        }

        .nav-links a:hover {
            background-color: #d0e9b6;
            border-radius: 5px;
        }
       

       /* Basic reset and styling */
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
        

        /* Header styling */
        .header {
            rgb(31, 74, 2);
            color: rgb(163, 243, 139);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1;
            img {
  opacity: 9.5;
}
           
        }

        .search-bar {
    flex: 1; /* Makes the search bar take up more space */
    display: flex;
    justify-content: center;
    }

    .search-bar input[type="text"] {
    font-family: 'Times New Roman', Times, serif;
    width: 500px;
    padding: 8px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px 0 0 4px;
    outline: none;
    }

    .search-bar button {
    padding: 10px 16px;
    background-color: #52a447; /* Example button color */
    border: none;
    color: white;
    cursor: pointer;
    font-size: 16px;
    border-radius: 0 4px 4px 0;
    }

    .search-bar button:hover {
    background-color: #77dd7c; /* Darken the button on hover */
    }

    .table-container {
            max-height: 100%; /* Set the max height for scroll */
            overflow-y: auto; /* Enable vertical scrolling */
            border: 1px solid #ddd; /* Border around the container */
            border-radius: 5px; /* Rounded corners */
            background-color: #fff; /* Background color */
        }
        table {
            width: 100%;
            border-collapse: collapse; /* Collapse borders */
        }
        th, td {
            border: 1px solid #ddd; /* Table cell border */
            padding: 2px; /* Padding inside table cells */
            text-align: left; /* Left align text */
            background-color: #f2f2f2;
        }
        th {
            background-color: #4CAF50; /* Header background color */
            color: white; /* Header text color */
            
        }
       
        
    </style>
</head>
<body>


    <div class="header">
    <header>
        <span class="hamburger" onclick="toggleSidebar()">☰</span>
    
    
        <div class="sidebar" id="sidebar">
       
        <ul>
                
            <!-- <li><a href="profile_tenant.php"><b>Profile</b></a></li>
             -->
             <?php
                
                if (isset($_SESSION['user_type'])) {
                    if ($_SESSION['user_type'] == 'Tenant') {
                        echo '<li><a href="profile_tenant.php"><b>Profile</b></a></li>';
                        echo '<li><a href="pay_rent_payments.php"><b>Pay Rent</b></a></li>';
                    } elseif ($_SESSION['user_type'] == 'Owner') {
                        echo '<li><a href="profile_owner.php"><b>Profile</b></a></li>';
                        echo '<li><a href="view_rent_payments.php"><b>View Rent</b></a></li>';
                    }
                } else {
                    
                    echo '<li><a href="#"><b>Profile</b></a></li>';

                }
                ?>
            
           
            <li><a href="#settings"><b>Settings</b></a></li>
            <li><a href="#About Us"><b>About Us</b></a></li>
            <li><a href="#Help"><b>Help</b></a></li>
        </ul>
        <p>Welcome <?php echo ($_SESSION['user_name'] );  ?></p>

        <form method="POST" action="logout.php">
            <button type="submit">Logout</button>
        </form>
        </header>
    </div>

   


    <!-- Header -->
   
    <div class="header">         
         
         <div class="search-bar">
            <form action="#" method="GET">
                <input type="text" name="query" placeholder="Search properties, tenants, etc." />
                <button type="submit">Search</button>
            </form>
            <div class="nav-links">
            <a href="dashboard.php"><b>Home</a></b>
  
        </div>
        </div>


    </div>

    <br>


    <div style="padding-left: 10%;padding-top: 5%;padding-right: 3%;">
  
        <?php
        include 'db_connection.php';

        $message = "";


        // Fetch rent payments data
        $query = "SELECT * FROM rent_payments";
        $result = $conn->query($query);

        ?>
            <table >
            <tr>
                <th>Serial No</th>
                <th>Tenant Email</th>
                <th>Rent Date</th>
                <th>Rent Amount</th>
                <th>Is Paid</th>
                <th>Month</th>
                <th>Transaction</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['serial_no']); ?></td>
                        <td><?php echo htmlspecialchars($row['tenant_email']); ?></td>
                        <td><?php echo htmlspecialchars($row['rent_date']); ?></td>
                        <td><?php echo htmlspecialchars($row['rent_amount']); ?></td>
                        <td><?php echo $row['is_paid'] ? 'Yes' : 'No'; ?></td>
                        <td><?php echo htmlspecialchars($row['month']); ?></td>
                        <td>
                            <?php if (!empty($row['receipt_uploaded'])): ?>
                                <a href="<?php echo htmlspecialchars($row['receipt_uploaded']); ?>" download>
                                    <button type="button">Download Receipt</button>
                                </a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No rent payment records found.</td>
                </tr>
            <?php endif; ?>
        </table>

        <?php
        // Close the database connection
        $conn->close();
        ?>

  
    </div>
        
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    }

</script>


</body>
</html>