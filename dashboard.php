<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Rental Dashboard</title>
    <style>
          body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
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
            font-family: 'Times New Roman', Times, serif;
            font-size: 20px;
            background-image: url('images/bg.jpg'); opacity: 9.5;
            background-repeat: no-repeat;
            background-size: 1550px 820px;
           
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


       
        
    </style>
</head>
<body>
    <?php session_start(); 
    if (!isset($_SESSION['user_name'])) {
        // If not set, redirect to login page
        header("Location: login.php");
        exit;
    }

    // Initialize total count variable
        $total_rent_payments = 0;
        include 'db_connection.php';

        // Get the user type and email from the session
        $user_type = $_SESSION['user_type'];
        $user_email = $_SESSION['user_email'];

        if ($user_type == 'Owner') {
            // For Owners
            $query = "SELECT 
                        COUNT(*) as total_payments, 
                        SUM(CASE WHEN is_paid = 1 THEN 1 ELSE 0 END) as total_paid, 
                        SUM(CASE WHEN is_paid = 0 THEN 1 ELSE 0 END) as total_unpaid 
                      FROM rent_payments 
                      WHERE owner_email = '$user_email'";
        } elseif ($user_type == 'Tenant') {
            // For Tenants
            $query = "SELECT 
                        COUNT(*) as total_payments, 
                        SUM(CASE WHEN is_paid = 1 THEN 1 ELSE 0 END) as total_paid, 
                        SUM(CASE WHEN is_paid = 0 THEN 1 ELSE 0 END) as total_unpaid 
                      FROM rent_payments 
                      WHERE tenant_email = '$user_email'";
        }
        
        // Execute the query
        $result = $conn->query($query);
        
        // Fetch the result and get the total payments count
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total_rent_payments = $row['total_payments'];
            $total_paid_rent_payments = $row['total_paid'];
            $total_unpaid_rent_payments = $row['total_unpaid'];
        } else {
            $total_rent_payments = 0;
            $total_paid_rent_payments = 0;
            $total_unpaid_rent_payments = 0; // If no rows are found, count is 0
        }

        // Close the database connection
        $conn->close();



    ?>

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
                        echo '<li><a href="approval.php"><b>Link Owner</b></a></li>';
                    } elseif ($_SESSION['user_type'] == 'Owner') {
                        echo '<li><a href="profile_owner.php"><b>Profile</b></a></li>';
                        echo '<li><a href="view_rent_payments.php"><b>View Rent</b></a></li>';
                        echo '<li><a href="approval_list.php"><b>Link Requests</b></a></li>';
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


    <div style="padding-left: 20%;padding-top: 5%;">
  
        <?php 
        if (isset($_GET['message'])) {
            $message = $_GET['message'];
            echo htmlspecialchars($message);
        }
        ?>
        <div class="dashboard-summary">
            <h4>Dashboard Summary</h4>
            <p class="summary-item">Total Rent Payments: <?php echo $total_rent_payments; ?></p>
            <p class="summary-item">Paid Payments: <?php echo $total_paid_rent_payments; ?></p>
            <p class="summary-item">Unpaid Payments: <?php echo $total_unpaid_rent_payments; ?></p>

        </div>

  
    </div>
        
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        sidebar.classList.toggle('active');
    }

</script>


</body>
</html>