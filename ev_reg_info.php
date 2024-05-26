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
      
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }
 .button-container {
            text-align: center; /* Center the button horizontally */
            margin-top: 20px; /* Add space between the event details and the button */
        }

        .back-link {
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            display: inline-block; /* Display the button as inline-block to make it non-full width */
            cursor: pointer; /* Add pointer cursor on hover */
            margin-right: 10px;
        }
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

    /* Style for approve and deny buttons */
    input[type="submit"] {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 6px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-right: 5px; /* Add some space between buttons */
    }

    /* Ensure buttons are displayed inline */
    form {
        display: inline;
    }

    /* Container for buttons */
    .action-buttons {
        margin-top: 10px;
        text-align: center;
    }
        .back-link:hover {
            background-color: #0056b3;
        }
    
    </style>
</head>
<body>
    <header>
        <h1>Welcome to <span style="color: #ffd700;">Eventify</span></h1>
        <p>Your Ultimate Event Management Partner</p>
    </header>
    <div class="container">
        <table>
            <?php
            // Database connection
            include('evconfig.php');
            $connectDB = new PDO($dns, $username, $password);
            $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if(isset($_GET['ev_name'])) {
                $event_name = $_GET['ev_name'];

                $stmt_event = $connectDB->prepare("SELECT * FROM events WHERE ev_name = :ev_name");
                $stmt_event->bindParam(':ev_name', $event_name);
                $stmt_event->execute();
                $event = $stmt_event->fetch(PDO::FETCH_ASSOC);

                if($event) {
                    $stmt_registrations = $connectDB->prepare("SELECT * FROM registrations WHERE ev_name = :ev_name");
                    $stmt_registrations->bindParam(':ev_name', $event_name);
                    $stmt_registrations->execute();
                    $registrations = $stmt_registrations->fetchAll(PDO::FETCH_ASSOC);

                    // Count the total number of registrations
                    $total_registrations = count($registrations);

                    echo "<h2>Event Registration Details for: {$event['ev_name']}</h2>";
                    echo "<p>Event Date: {$event['ev_date']}</p>";
                    echo "<p>Event Time: {$event['ev_time']}</p>";
                    echo "<p>Event Location: {$event['ev_location']}</p>";
                    echo "<p>Total Registrations: $total_registrations</p>";
                    echo "<a href='home.php' class='back-link'><b>Back to Home</b></a>";

                    echo "<table border='1'>";
                    echo "<tr><th>Name</th><th>Number</th><th>Email</th><th>Approval</th><th>Action</th></tr>";
                    foreach ($registrations as $registration) {
                        echo "<tr>";
                        echo "<td>{$registration['NAME']}</td>";
                        echo "<td>{$registration['NUMBER']}</td>";
                        echo "<td>{$registration['EMAIL']}</td>";
                        echo "<td>{$registration['Approvel']}</td>";
                        echo "<td>";
                        // Approve button
                        echo "<form action='approve.php' method='post'>";
                        echo "<input type='hidden' name='registration_id' value='{$registration['id']}'>";
                        echo "<input type='submit' value='Approve'>";
                        echo "</form>";
                        // Deny button
                        echo "<form action='deny.php' method='post'>";
                        echo "<input type='hidden' name='registration_id' value='{$registration['id']}'>";
                        echo "<input type='submit' value='Deny'>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "Event not found.";
                }
            } else {
                echo "Event name not provided.";
            }
            ?>
        </table>
    </div>
</body>
</html>
