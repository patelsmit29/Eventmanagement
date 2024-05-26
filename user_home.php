<?php
include('evconfig.php');
include('delete_ev_auto.php');
session_start();
    if(!isset($_SESSION['user'])) {
        header('Location: login.php');
    }


try {
    $connectDB = new PDO($dns, $username, $password);
    $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $connectDB->query("SELECT * FROM events");
    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventify - Your Ultimate Event Management Partner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
        /* Container Styles */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        .event-cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }
        .event-card {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        .event-card h2 {
            margin-top: 0;
            color: #1a1a1a;
            font-size: 24px;
        }
        .event-card p {
            color: #555;
            margin-bottom: 15px;
        }
        .event-card a {
            display: inline-block;
            background-color: #ffd700;
            color: #1a1a1a;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .event-card a:hover {
            background-color: #1a1a1a;
            color: #fff;
        }
    </style>
</head>
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
    <!-- Container -->
    <div class="container">
        <h2>Upcoming Events</h2>
        <div class="event-cards-container">
        <?php 
        if (count($events) > 0) {
            foreach ($events as $event) : 
        ?>
            <div class="event-card">
                <h2><?php echo $event['ev_name']; ?></h2>
                <p><i class="fas fa-calendar-alt"></i> <?php echo $event['ev_date']; ?> at <?php echo $event['ev_time']; ?></p>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo $event['ev_location']; ?></p>
                <a href="moreinfo.php?ev_name=<?php echo $event['ev_name']; ?>">MORE INFO</a>
            </div>
        <?php 
            endforeach;
        } else {
            echo "<p>No events found.</p>";
        }
        ?>
    </div>
    </div>
    <footer>
        <p>&copy; 2024 Eventify. All rights reserved.</p>
    </footer>
</body>
</html>
