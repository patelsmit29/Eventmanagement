<?php
                session_start();
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
    </nav>
    <div class="container">
        <h2>Edit Registered Events</h2>
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Approval</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                include('evconfig.php');
                include('del.php');
                try {
                    // Connect to the database
                    $connectDB = new PDO($dns, $username, $password);
                    $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Check if user's email matches in registrations table
                    $stmt = $connectDB->prepare("SELECT * FROM registrations WHERE EMAIL = :user_email");
                    $stmt->bindParam(':user_email', $_SESSION['user']);
                    $stmt->execute();
                    $registrations = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if ($registrations) {
                        foreach ($registrations as $registration) {
                            $ev_name = $registration['ev_name'];
                            $approval = $registration['Approvel'];

                            // Check if ev_name matches in events table
                            $stmt = $connectDB->prepare("SELECT * FROM events WHERE ev_name = :ev_name");
                            $stmt->bindParam(':ev_name', $ev_name);
                            $stmt->execute();
                            $event = $stmt->fetch(PDO::FETCH_ASSOC);

                            // If ev_name found in events
                            if ($event) {
                                $ev_date = $event['ev_date'];
                                $ev_time = $event['ev_time'];
                                $ev_location = $event['ev_location'];

                                // Now you have the details, print them in table rows
                                echo "<tr>";
                                echo "<td>$ev_name</td>";
                                echo "<td>$ev_date</td>";
                                echo "<td>$ev_time</td>";
                                echo "<td>$ev_location</td>";
                                echo "<td>$approval</td>";?>
                                <td>
    <a href="del.php?ev_name=<?php echo urlencode($ev_name); ?>" class="edit-button">Cancel</a>
</td><?php
                            } else {
                                echo "<tr><td colspan='6'>Event not found in the events table.</td></tr>";
                            }
                        }
                    } else {
                        echo "<tr><td colspan='6'>No registered events found for this user.</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                    exit();
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
