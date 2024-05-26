<?php

// Check if registration_id is set in the POST request
if (isset($_POST['registration_id'])) {
    $registration_id = $_POST['registration_id'];

    // Now you have the registration_id and you can use it in your code
    // For example, you can use it to perform database operations or any other tasks
    
    // Database connection
    include('evconfig.php');
    $connectDB = new PDO($dns, $username, $password);
    $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update Approval column to 'Denied' for the corresponding registration ID
    $stmt_deny = $connectDB->prepare("UPDATE registrations SET Approvel = 'Denied' WHERE id = :registration_id");
    $stmt_deny->bindParam(':registration_id', $registration_id);
    $stmt_deny->execute();

    // Redirect back to the page where the denial was done
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
} else {
    // If registration_id is not set, redirect to an error page or any other appropriate action
    header("Location: error.php");
    exit();
}
?>
