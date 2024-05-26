<?php
include('evconfig.php');

try {
    // Connect to the database
    $connectDB = new PDO($dns, $username, $password);
    $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the current date
    $currentDate = date('Y-m-d');

    // Prepare and execute a query to delete events completed before today
    $stmt = $connectDB->prepare("DELETE FROM events WHERE DATE_ADD(ev_date, INTERVAL 1 DAY) <= :current_date");
    $stmt->bindParam(':current_date', $currentDate);
    $stmt->execute();

    // Count the number of deleted rows
    $deletedRows = $stmt->rowCount();

    if ($deletedRows > 0) {
        echo "<script>alert('Deleted $deletedRows past event(s) successfully.');</script>";
    } 
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

