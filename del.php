<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('evconfig.php');

if (isset($_GET['ev_name'])) {
    try {
        // Connect to the database
        $connectDB = new PDO($dns, $username, $password);
        $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retrieve event name from URL parameter
        $ev_name = $_GET['ev_name'];

        // Delete record from registrations table
        $stmt = $connectDB->prepare("DELETE FROM registrations WHERE ev_name = :ev_name AND EMAIL = :user_email");
        $stmt->bindParam(':ev_name', $ev_name);
        $stmt->bindParam(':user_email', $_SESSION['user']);
        $stmt->execute();
        
        // Optionally, you can perform additional tasks here
        
        // Redirect back to the page where the link was clicked
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
