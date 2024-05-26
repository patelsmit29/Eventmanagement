<?php
session_start();
include('logic_user_dele.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="home.css">
    <title>Eventify - Your Ultimate Event Management Partner</title>
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
.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.5); /* Adjust transparency here */
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}
h1 {
    color: #fff;
    text-align: center;
}

        #logout {
    margin-left: 45%; /* This pushes the logout button to the right */
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
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
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

        /* Table Styles */
        .container {
            max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8); /* Adjust transparency here */
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

table-container {
    text-align: center;
}

table {
    margin: 0 auto;
    background-color: rgba(255, 255, 255, 0.9); /* Adjust transparency here */
    border-radius: 5px;
    overflow: hidden;
}

th,
td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
    color: #333;
}
        /* Delete Button Style */
        .delete-button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .delete-button:hover {
            background-color: #c82333;
        }

        /* No User Found Style */
        .nofound {
            text-align: center;
            margin-top: 20px;
        }

        .noitem {
            color: #777;
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

    <!-- Main content -->
    <h1>USER LIST</h1>
    <?php
    // Check if there are users to display
    if (!empty($issueResults)) {
        echo '<table>
                <tr>
                    <th>Name</th>
                    <th>Number</th>
                    <th>Email</th>
                    <th>ACTIONS</th>
                </tr>';

        // Display user information
        foreach ($issueResults as $row) {
            // Exclude the 'admin' user from the list
            if ($row['NAME'] != 'admin') {
            ?>
                <tr>
                    <td><?php echo "{$row['NAME']}"; ?></td>
                    <td><?php echo "{$row['NUMBER']}"; ?></td>
                    <td><?php echo "{$row['EMAIL']}"; ?></td>
                    <td>
                        <!-- Form for user deletion with confirmation -->
                        <form method="post" onsubmit="return confirmDelete('<?php echo $row['NAME']; ?>')">
                            <input type='text' name='NAME' value="<?php echo $row['NAME']; ?>" style='display: none;'>
                            <button type='submit' name='deletebutton' class="delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
        }

        echo '</table>';
    } else {
        echo '<div class="nofound"><h1 class="noitem">No User found.</h1></div>';
    }
    ?>

    <!-- JavaScript function for logout and confirming user deletion -->
    <script>
        function confirmDelete(USERNAME) {
            var result = confirm("Are you sure you want to delete the user with USERNAME: " + USERNAME + "?");
            return result;
        }
    </script>
</body>

</html>
