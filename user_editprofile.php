<?php
include('show_profile.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newName = $_POST['newName'];
    $newEmail = $_POST['newEmail'];
    $newNumber = $_POST['newNumber'];
    $userSNO = $_POST['SNO']; // Retrieve the SNO from the form

    include('evconfig.php');

    try {
        $connectDB = new PDO($dns, $username, $password);
        $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the new email is already registered
        $checkEmailQuery = "SELECT COUNT(*) FROM signup WHERE EMAIL = :newEmail AND SNO != :SNO";
        $checkEmailStmt = $connectDB->prepare($checkEmailQuery);
        $checkEmailStmt->bindParam(':newEmail', $newEmail);
        $checkEmailStmt->bindParam(':SNO', $userSNO); // Use the retrieved SNO
        $checkEmailStmt->execute();
        $emailExists = $checkEmailStmt->fetchColumn();

        // Check if the new mobile number is already registered
        $checkMobileQuery = "SELECT COUNT(*) FROM signup WHERE NUMBER = :newNumber AND SNO != :SNO";
        $checkMobileStmt = $connectDB->prepare($checkMobileQuery);
        $checkMobileStmt->bindParam(':newNumber', $newNumber);
        $checkMobileStmt->bindParam(':SNO', $userSNO); // Use the retrieved SNO
        $checkMobileStmt->execute();
        $mobileExists = $checkMobileStmt->fetchColumn();

        if ($emailExists > 0) {
            // Email is already registered
            echo '<script>alert("Email is already registered. Please choose a different email.");</script>';
        } elseif ($mobileExists > 0) {
            // Mobile number is already registered
            echo '<script>alert("Mobile number is already registered. Please choose a different mobile number.");</script>';
        } else {
         
                $updateQuery = "UPDATE signup
                                SET NAME=:newName,
                                    EMAIL=:newEmail,NUMBER=:newNumber
                                WHERE SNO=:SNO";
            
                $updateStmt = $connectDB->prepare($updateQuery);
          
            // Update other user information
            $updateStmt->bindParam(':newName', $newName);
            $updateStmt->bindParam(':newEmail', $newEmail);
            $updateStmt->bindParam(':newNumber', $newNumber);
            $updateStmt->bindParam(':SNO', $userSNO); 
            $updateStmt->execute();

            // Redirect to the profile page after updating
            header('Location: profile.php');
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Edit Profile</title>
    <style>
        body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
}

.title {
    text-align: center;
    color: #fff;
    padding: 15px;
}

.nav-bar {
    background-color: #333;
    overflow: hidden;
}

.nav-bar nav {
    display: flex;
    justify-content: space-between;
    padding: 10px;
}

.nav-bar a {
    color: white;
    text-decoration: none;
    padding: 14px 16px;
}

.nav-bar a:hover {
    background-color: #ddd;
    color: black;
}

.footer {
    text-align: center;
    margin-top: 20px;
}

.profile-container {
    max-width: 400px;
    width: 100%;
    text-align: center;
    margin: 20px auto;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
}

.profile-container label {
    display: block;
    margin-bottom: 10px;
}

.profile-container input {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

.button {
    background-color: #4caf50;
    color: #fff;
    padding: 12px 20px;
    text-decoration: none;
    border-radius: 5px;
    display: inline-block;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.button:hover {
    background-color: #45a049;
}

    </style>
</head>

<body>
    <header>
        <h1>Welcome to <span style="color: #ffd700;">Eventify</span></h1>
        <p>Your Ultimate Event Management Partner</p>
    </header>
    </div>
    <div class="footer">
        <h1>Edit Profile</h1>
        <hr>
    </div>

    <div class="profile-container">
        <!-- Form for editing user profile -->
        <form method="POST" enctype="multipart/form-data">
           
            <label for="newFirstName">First Name:</label>
            <input type="text" name="newName" value="<?php echo $user['NAME']; ?>" required>

            <label for="newEmail">Email:</label>
            <input type="email" name="newEmail" value="<?php echo $user['EMAIL']; ?>" required>

            <label for="newNumber">Mobile Number:</label>
            <input type="tel" name="newNumber" value="<?php echo $user['NUMBER']; ?>" required>

            <!-- Hidden field for SNO -->
            <input type="hidden" name="SNO" value="<?php echo $user['SNO']; ?>">

            <button type="submit" class="button">Save Changes</button>
        </form>

    </div>

</body>

</html>
