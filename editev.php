<?php
    // Include database configuration
    include('evconfig.php');
    session_start();
    if(!isset($_SESSION['user'])) {
        header('Location: login.php');
    }


    // Fetch events data from the database
    try {
        $connectDB = new PDO($dns, $username, $password);
        $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $connectDB->query("SELECT * FROM events");
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
  
    // Check if form is submitted
    if (isset($_POST['savebtn'])) {
        try {
            // Sanitize user input
            $oldEventName = htmlspecialchars($_POST['oldEventName']); // Old event name
            $eventName = htmlspecialchars($_POST['eventName']); // Updated event name
            $eventDate = htmlspecialchars($_POST['eventDate']);
            $eventTime = htmlspecialchars($_POST['eventTime']);
            $eventLocation = htmlspecialchars($_POST['eventLocation']);
            $eventDescription = htmlspecialchars($_POST['eventDescription']); // Updated event description

            // Check if the new event name already exists in the database
            $checkStmt = $connectDB->prepare("SELECT COUNT(*) FROM events WHERE ev_name = :ev_name AND ev_name <> :old_ev_name");
            $checkStmt->bindParam(':ev_name', $eventName);
            $checkStmt->bindParam(':old_ev_name', $oldEventName);
            $checkStmt->execute();
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                // Event name already exists, show alert and do not proceed with the update
                echo "<script>alert('Event name already exists. Please choose a different name.');</script>";
            } else {
                // Prepare SQL statement to update event details based on event name
                $stmt = $connectDB->prepare("UPDATE events SET ev_name = :new_ev_name, ev_date = :ev_date, ev_time = :ev_time, ev_location = :ev_location, ev_des = :ev_des WHERE ev_name = :old_ev_name");

                // Bind parameters
                $stmt->bindParam(':new_ev_name', $eventName);
                $stmt->bindParam(':ev_date', $eventDate);
                $stmt->bindParam(':ev_time', $eventTime);
                $stmt->bindParam(':ev_location', $eventLocation);
                $stmt->bindParam(':ev_des', $eventDescription);
                $stmt->bindParam(':old_ev_name', $oldEventName);

                // Execute the update query
                $stmt->execute();

                // Debugging
                echo "Number of rows affected: " . $stmt->rowCount();

                // Redirect to the edit events page after updating
                header("Location: editev.php");
                exit();
            }
        } catch (PDOException $e) {
            // Log the error and display a user-friendly message
            error_log("Error updating event: " . $e->getMessage(), 0);
            echo "An error occurred while updating the event. Please try again later.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Events - Eventify</title>
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

        /* Container Styles */
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #f2f2f2;
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
        #logout {
    margin-left: 45%; /* This pushes the logout button to the right */
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
        .popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5); /* Black background with transparency */
        }

        .popup-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 8px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Style for form elements */
        input[type="text"],
        input[type="date"],
        input[type="time"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 0 auto 20px auto;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 16px;
            display: block;
        }
    .edit-button {
        background-color: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .edit-button:hover {
        background-color: #45a049; /* Darker green on hover */
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

        textarea {
            width: calc(100% - 20px);
            margin: 0 auto 20px auto;
            box-sizing: border-box;
            display: block;
        }

        textarea:focus {
            border-color: #007bff;
            outline: none;
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
        <h2>Edit Events</h2>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $event) : ?>
                    <tr>
                        <td><?php echo $event['ev_name']; ?></td>
                        <td><?php echo $event['ev_date']; ?></td>
                        <td><?php echo $event['ev_time']; ?></td>
                        <td><?php echo $event['ev_location']; ?></td>
                        <td><button class="edit-button" onclick="openPopup('<?php echo $event['ev_name'] . ',' . $event['ev_date'] . ',' . $event['ev_time'] . ',' . $event['ev_location'] . ',' . $event['ev_des']; ?>')">Edit</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="editPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <h2>Edit Event</h2>
            <form id="editForm" method="post">
                <input type="hidden" id="oldEventName" name="oldEventName">
                <label for="eventName">Event Name:</label><br>
                <input type="text" id="eventName" name="eventName"><br>

                <label for="eventDate">Event Date:</label><br>
                <input type="date" id="eventDate" name="eventDate"><br>

                <label for="eventTime">Event Time:</label><br>
                <input type="time" id="eventTime" name="eventTime"><br>

                <label for="eventLocation">Event Location:</label><br>
                <input type="text" id="eventLocation" name="eventLocation"><br>

                <label for="eventDescription">Event Description:</label><br>
                <textarea id="eventDescription" name="eventDescription" rows="6" cols="50" style="padding: 10px; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;"></textarea><br>
   
                <input type="submit" value="Save Changes" name="savebtn">
            </form>
        </div>
    </div>


    <script>
        function openPopup(eventDetails) {
    var popup = document.getElementById("editPopup");
    popup.style.display = "block";

    // Split eventDetails into an array
    var detailsArray = eventDetails.split(',');

    // Check if enough elements are present in the array
    if (detailsArray.length >= 4) {
        // Populate form fields with event details
        document.getElementById("oldEventName").value = detailsArray[0]; // Store the old event name
        document.getElementById("eventName").value = detailsArray[0]; // Event name to be edited
        document.getElementById("eventDate").value = detailsArray[1];
        document.getElementById("eventTime").value = detailsArray[2];
        document.getElementById("eventLocation").value = detailsArray[3];

        // Check if description is available
        if (detailsArray.length >= 5) {
            document.getElementById("eventDescription").value = detailsArray[4];
        } else {
            document.getElementById("eventDescription").value = ''; // Clear description field
        }
    }
}


        function closePopup() {
            var popup = document.getElementById("editPopup");
            popup.style.display = "none";
        }

        function validateForm() {
            var eventName = document.getElementById("eventName").value.trim();
            var oldEventName = document.getElementById("oldEventName").value.trim();

            if (eventName === oldEventName) {
                alert("Event name is the same as the original. Please make changes.");
                return false;
            }

            return true;
        }
    </script>
    </body>
</html>
