<?php
session_start();
include('evconfig.php');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Check if event name is provided in the URL
if (!isset($_GET['ev_name'])) {
    echo "Event name is missing.";
    exit();
}

try {
    // Connect to the database
    $connectDB = new PDO($dns, $username, $password);
    $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch event details based on event name
    $stmt = $connectDB->prepare("SELECT * FROM events WHERE ev_name = :ev_name");
    $stmt->bindParam(':ev_name', $_GET['ev_name']);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if event exists
    if (!$event) {
        echo "Event not found.";
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit();
}

// Determine the redirect URL based on user role
$redirectURL = ($_SESSION['user'] === 'admin@gmail.com') ? 'home.php' : 'user_home.php';

// Handle registration process if "Register - Myself" button is clicked
if (isset($_POST['register_myself'])) {
    // Get user details from session
    $userEmail = $_SESSION['user'];
    $stmt = $connectDB->prepare("SELECT * FROM signup WHERE EMAIL = :EMAIL");
    $stmt->bindParam(':EMAIL', $userEmail);
    $stmt->execute();
    $signupRecords = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch user details from signup table
    if (count($signupRecords) > 0) {
        // Assuming only one record is found
        $userDetails = $signupRecords[0];
        $name = $userDetails['NAME'];
        $email = $userDetails['EMAIL'];
        $number = $userDetails['NUMBER'];

        // Check if the user is already registered for the event
        $stmt = $connectDB->prepare("SELECT * FROM registrations WHERE EMAIL = :EMAIL AND ev_name = :ev_name");
        $stmt->bindParam(':EMAIL', $email);
        $stmt->bindParam(':ev_name', $_POST['ev_name']);
        $stmt->execute();
        $existingRegistration = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingRegistration) {
            // User is already registered for the event, display alert
            echo "<script>alert('You are already registered for this event.');</script>";
        } else {
            // User is not registered, proceed with registration
            try {
                // Prepare and execute the INSERT query to insert into registration table
                $stmt = $connectDB->prepare("INSERT INTO registrations (ev_name, NAME, EMAIL, NUMBER) VALUES (:ev_name, :name, :email, :number)");
                $stmt->bindParam(':ev_name', $_POST['ev_name']);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':number', $number);
                $stmt->execute();

                // Registration successful, display alert and redirect
                echo "<script>alert('Registration successful.');</script>";
                echo "<script>window.location.href = 'user_home.php';</script>";
                exit(); // Exit after redirect
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
                exit();
            }
        }
    } else {
        echo "User details not found.";
        exit();
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>Event Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 50px auto; /* Center the container vertically */
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9); /* Transparent white background */
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .event-details {
            margin-top: 20px;
        }

        .event-details p {
            margin: 10px 0;
            color: #555;
        }

        .event-details strong {
            color: #333;
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

        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Event Details</h1>
        <div class="event-details">
            <p><strong>Event Name:</strong> <?php echo $event['ev_name']; ?></p>
            <p><strong>Date:</strong> <?php echo $event['ev_date']; ?></p>
            <p><strong>Time:</strong> <?php echo $event['ev_time']; ?></p>
            <p><strong>Location:</strong> <?php echo $event['ev_location']; ?></p>
            <p><strong>Description:</strong> <?php echo $event['ev_des']; ?></p>
        </div>
        <!-- Button container -->
        <div class="button-container">
        <?php if ($_SESSION['user'] === 'admin@gmail.com'): ?>
            <form method="get" action="ev_reg_info.php" style="display: inline-block;"> <!-- Added inline-block style -->
                    <input type="hidden" name="ev_name" value="<?php echo $_GET['ev_name']; ?>">
                    <button type="submit" name="register_detail" class="back-link"><b>register_detail</b></button>
                </form>
            <?php else: ?>
                <form method="post" style="display: inline-block;"> <!-- Added inline-block style -->
                    <input type="hidden" name="ev_name" value="<?php echo $_GET['ev_name']; ?>">
                    <button type="submit" name="register_myself" class="back-link"><b>Register - Myself</b></button>
                </form>
            <?php endif; ?>
            <a href="<?php echo $redirectURL; ?>" class="back-link"><b>Back to Home</b></a>
        </div>
    </div>
</body>
</html>

