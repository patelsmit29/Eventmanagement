<?php

include('evconfig.php'); 


$connectDB = new PDO($dns, $username, $password);
$connectDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

class Change {
    private $currentPass;
    private $newPass;
    private $confirmPass;
    private $EMAIL;

    public function __construct($currentPass, $newPass, $confirmPass, $EMAIL) {
        $this->currentPass = $currentPass;
        $this->newPass = $newPass;
        $this->confirmPass = $confirmPass;
        $this->EMAIL = $EMAIL;
    }

    public function updatePassword($connectDB) {
        $checkQry = "SELECT * FROM signup WHERE EMAIL=:EMAIL";
        $checkQry_run = $connectDB->prepare($checkQry);

        $checkData = [
            ':EMAIL' => $this->EMAIL,
        ];

        $checkQry_run->execute($checkData);
        $user = $checkQry_run->fetch(PDO::FETCH_ASSOC);
 
        if ($user['PASSWORD'] == $this->currentPass) {
            if ($this->newPass === $this->confirmPass) {
                $updateQry = "UPDATE signup SET PASSWORD=:PASSWORD WHERE EMAIL=:EMAIL";
                $updateQry_run = $connectDB->prepare($updateQry);

                $updateData = [
                    ':PASSWORD' => $this->newPass,
                    ':EMAIL' => $this->EMAIL,
                ];

                $updateQry_run->execute($updateData);

                echo "<script> alert('Password updated successfully.'); </script>";
            } else {
                echo "<script> alert('New password and confirm password do not match.'); </script>";
            }
        } else {
            echo "<script> alert('Incorrect current password.'); </script>";
        }
    }
}

if (isset($_POST['updatePasswordSubmit'])) {
    $changePassword = new Change($_POST['currentPass'], $_POST['newPass'], $_POST['confirmPass'], $_SESSION['user']);
    $changePassword->updatePassword($connectDB);
}
?>
