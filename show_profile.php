<?php
session_start();

if(!isset($_SESSION['user'])) {
    header('Location: login.php');
}

include('evconfig.php'); 

try {
    $connectDB = new PDO($dns, $username, $password);
    $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $userId = $_SESSION['user'];     
    $query = "SELECT * FROM signup WHERE EMAIL=:EMAIL";
    $statement = $connectDB->prepare($query);
    $statement->bindParam(':EMAIL', $userId);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
