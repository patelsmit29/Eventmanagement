<?php


// Check if registration_id is set in the POST request
if (isset($_POST['registration_id'])) {
    $registration_id = $_POST['registration_id'];

    // Database connection
    include('evconfig.php');
    $connectDB = new PDO($dns, $username, $password);
    $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Update Approval column to 'Approved' for the corresponding registration ID
    $stmt_approve = $connectDB->prepare("UPDATE registrations SET Approvel = 'Approved' WHERE id = :registration_id");
    $stmt_approve->bindParam(':registration_id', $registration_id);
    $stmt_approve->execute();

    // Redirect back to the page where the approval was done
    header("Location: ".$_SERVER['HTTP_REFERER']);
    exit();
} else {
    // If registration_id is not set, redirect to an error page or any other appropriate action
    header("Location: error.php");
    exit();
}
?>
