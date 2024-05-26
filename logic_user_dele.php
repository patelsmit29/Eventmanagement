<?php
include('evconfig.php');
try {
    
    // Assuming you have already connected to the database and have the $connectDB object
    $connectDB = new PDO($dns, $username, $password);
    $connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the delete button is clicked

    class delete {
        private $NAME;

        public function __construct($NAME) {
            $this->NAME = $NAME;
        }
        public function deleteuser($connectDB) {
            $qry1 = "delete from signup where NAME=:NAME";

            $qry1_run = $connectDB->prepare($qry1);

            $data = [
                'NAME' => $this->NAME,
            ];

            $result = $qry1_run->execute($data);
            
            if($result) {
                echo "<script> location.replace('http://localhost/eventmange/userlist.php'); </script>";
                
            }
        }
    }
        
    $issueQuery = "SELECT  NAME,NUMBER,EMAIL FROM signup";
    $issueStmt = $connectDB->prepare($issueQuery);
    $issueStmt->execute();
    $issueResults = $issueStmt->fetchAll(PDO::FETCH_ASSOC);


} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}?>
<?php 
        if (isset($_POST['deletebutton'])) {
            $delete = new delete($_POST['NAME']);
            $delete->deleteuser($connectDB);
        }
?>