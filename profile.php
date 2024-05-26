<?php
include('show_profile.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
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
        

.profile-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-top: 20px;
}

.user-details {
    margin-bottom: 10px;
}

.button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
    text-decoration: none;
}

.button:hover {
    background-color: #0056b3;
}
    </style>
</head>

<body>
<body>
<header>
        <h1>Welcome to <span style="color: #ffd700;">Eventify</span></h1>
        <p>Your Ultimate Event Management Partner</p>
    </header>
    <!-- Navigation Bar -->
    <nav>
        <ul>
            <li><a href="user_home.php">Home</a></li>
                <a href="reg_ev_list.php">Registered Events</a>
            <li class="dropdown">
                <a href="#" class="dropbtn">PROFILE</a>
                <div class="dropdown-content">
                    <a href="profile.php">EDIT PROFILE</a>
                    <a href="change_pass.php">CHANGE PASSWORD</a>
                </div>
            </li>
            <li id="logout"><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="profile-container">
    <h1>User Profile</h1>
        <div class="user-details" name="NAME">NAME : <?php echo $user['NAME']?></div>
        <div class="user-details" name="EMAIL">EMAIL : <?php echo $user['EMAIL']; ?></div>
        <div class="user-details" name="NUMBER">MOBILE NO. : <?php echo $user['NUMBER']; ?>
        <br><br><a href="#" class="button" onclick="editProfile()">Edit Profile</a>
    </div>
     

    </div>
<script>
        function editProfile() {
            // Redirect to the profile editing page or show an edit form
            location.replace('user_editprofile.php');
        }
    </script>
</body>

</html>
