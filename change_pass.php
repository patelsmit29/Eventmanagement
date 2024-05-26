<?php
// Start the session
session_start();
include('evconfig.php');

include('logic_updatepass.php');

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Metadata and styles for the page -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <style>
      body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        /* Navigation Bar Styles */
        nav {
            background-color: #262626;
            padding: 15px 0;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        nav ul li a:hover {
            background-color: #ffd700;
            color: #262626;
        }
        /* Dropdown Menu Styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #ddd;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        #logout {
    margin-left: 45%; /* This pushes the logout button to the right */
}
    
.container_1 {
    max-width: 400px;
    margin: 20px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.container_1 h1 {
    text-align: center;
    margin-bottom: 20px;
}

.container_1 form {
    text-align: center;
}

.container_1 label {
    display: block;
    margin-bottom: 10px;
}

.container_1 input[type="password"] {
    width: calc(100% - 20px);
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    font-size: 16px;
}

.container_1 button[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.container_1 button[type="submit"]:hover {
    background-color: #0056b3;
}
        
    </style>
</head>

<body>
<header>
        <h1>Welcome to <span style="color: #ffd700;">Eventify</span></h1>
        <p>Your Ultimate Event Management Partner</p>
    </header>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Events</a>
                <div class="dropdown-content">
                    <a href="addev.php">Add Events</a>
                    <a href="editev.php">Edit Events</a>
                </div>
            </li>
            <li><a href="userlist.php">Users</a></li>
            <li id="logout"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Container for password update -->
    <div class="container_1">
        <h1>Password Update</h1>
        <!-- Password update form -->
        <form method="post">
            <label for="currentPass">Current Password:</label>
            <input type="password" id="currentPassword" name="currentPass" required>

            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" name="newPass" title="Password must contain at least 1 number, 1 special character">

            <label for="confirmPassword">Confirm New Password:</label>
            <input type="password" id="confirmPassword" name="confirmPass" title="Password must contain at least 1 number, 1 special character">

            <!-- Update Password button -->
            <button type="submit" name="updatePasswordSubmit">Update Password</button>
        </form>
    </div>

    <!-- JavaScript function for logout -->
    
</body>

</html>
