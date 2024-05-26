<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Login</title>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="#" method="POST">
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>use your number & email for registeration</span>
                <input name="name" type="text" placeholder="Name" required>
                <input name="num" type="text" placeholder="number" pattern="\d{10}" title="Please enter your 10-digit Number Properly" required>
                <input name="email" type="email" placeholder="Email" required>
                <input name="pass" type="password" placeholder="Password" required>
                <button name="signup">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form  action="#" method="POST">
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <span>or use your email password</span>
                <input type="email" placeholder="Email" required name="email">
                <input type="password" placeholder="Password" required name="pass">
                <a href="#">Forget Your Password?</a>
                <button name="signin">Sign In</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1> 
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register" >Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>

<?php
session_start();
    $pdo = new PDO("mysql:host=localhost;dbname=eventmange","root","");

    if(isset($_POST['signup']))
    {
        $nm=$_POST['name'];
        $num=$_POST['num'];
        $email=$_POST['email'];
        $pass=$_POST['pass'];
        
        $stmt=$pdo->prepare("INSERT INTO signup(NAME,NUMBER,EMAIL,PASSWORD) VALUES(:NAME,:NUMBER,:EMAIL,:PASSWORD)");
        $stmt->bindparam(':NAME',$nm);
        $stmt->bindparam(':NUMBER',$num);
        $stmt->bindparam(':EMAIL',$email);
        $stmt->bindparam(':PASSWORD',$pass);
        $stmt->execute();
        header('location:login.php');
    }
        elseif (isset($_POST['signin'])) {
            $email2 = $_POST['email'];
            $pass2 = $_POST['pass'];
        
            $stmt = $pdo->prepare("SELECT * FROM signup WHERE EMAIL = :EMAIL AND PASSWORD = :PASSWORD");
            $stmt->bindParam(':EMAIL', $email2);
            $stmt->bindParam(':PASSWORD', $pass2);
            $stmt->execute();
        
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                $_SESSION['user'] = $email2;
                header('location: home.php');
                if ($email2 === 'admin@gmail.com') {
                    header('location: home.php');
                } else {
                    header('location: user_home.php');
                }
            } else {
                echo "Invalid email or password.";
            }
        }
?>