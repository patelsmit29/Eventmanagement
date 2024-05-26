<?php
    include ('evconfig.php');
    session_start();
    if(!isset($_SESSION['user'])) {
        header('Location: login.php');
    }


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Add New Event</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('bg.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }.container {
            max-width: 600px;
            margin: 20px auto;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        input[type="time"],
        textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 8px auto;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 16px;
            display: block;
            color: #333;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
            display: block;
            margin: 0 auto;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
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
        #logout {
    margin-left: 45%; /* This pushes the logout button to the right */
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
<div class="container">
    <h2>Add New Event</h2>
    <form method="post">
        <label for="event_name">Event Name:</label><br>
        <input type="text" id="event_name" name="event_name"><br>

        <label for="event_date">Event Date:</label><br>
        <input type="date" id="event_date" name="event_date"><br>

        <label for="event_time">Event Time:</label><br>
        <input type="time" id="event_time" name="event_time"><br>

        <label for="event_location">Event Location:</label><br>
        <input type="text" id="event_location" name="event_location"><br>

        <label for="event_description">Event Description:</label><br>
        <textarea id="event_description" name="event_description" rows="4" cols="50"></textarea><br>

        <input type="submit" value="Add Event" name="add_ev">
    </form>
</div>
</body>
</html>

<?php
try {
    
    $connectDB = new PDO($dns, $username, $password);
    $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $eventName = $_POST['event_name'];
    $eventDate = $_POST['event_date'];
    $eventTime = $_POST['event_time'];
    $eventLocation = $_POST['event_location'];
    $eventDescription = $_POST['event_description'];

    try {
        // Prepare SQL statement to insert data into the database
        $sql = "INSERT INTO events (ev_name, ev_date, ev_time, ev_des, ev_location )
                VALUES (:eventName, :eventDate, :eventTime, :eventDescription,  :eventLocation)";

        // Prepare the statement
        $stmt = $connectDB->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':eventName', $eventName);
        $stmt->bindParam(':eventDate', $eventDate);
        $stmt->bindParam(':eventTime', $eventTime);
        $stmt->bindParam(':eventLocation', $eventLocation);
        $stmt->bindParam(':eventDescription', $eventDescription);

        // Execute the statement
        $stmt->execute();
        echo '<script>alert("New event added successfully");</script>';
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} 

} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>