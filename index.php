<?php 
require_once("DBConnection.php"); 
include("functions.php");
session_start();
?>

<?php
    if (isset($_POST['login'])) {
        if (!empty($_POST['username']) && !empty($_POST['password'])) {
            $username = mysqli_real_escape_string($conn,$_POST['username']);
            $pass = mysqli_real_escape_string($conn,$_POST['password']);

            $login = login($username,$pass,$conn);          
        }
        else{
            echo "Required All fields!";
        }     
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>System Access Application ICT PKNP</title>
    <style>
        #invalidMsg{
            display:none;
        }
        /* Clock styles */
        .login-clock {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;  /* Reduced from 20px to move login text up */
            text-align: center;
        }
        
        .digital-clock {
            font-family: 'Source Sans Pro', sans-serif;
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
            background-color: #f8f9fa;
            padding: 15px 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            line-height: 1.6;
        }
        .time {
            font-size: 1.8rem;
        }
        .date {
            font-size: 1.2rem;
        }
        
        /* Added to move login heading up */
        .rightComponent h3 {
            margin-top: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
     
<body>

    <!-- header -->
    <nav class="navbar header-nav navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">System Access Application ICT PKNP</a>
            <a id="register" href="signup.php">Sign Up</a>
        </div>
    </nav>
    <!-- header ends -->

    <!-- body -->
    <div class="container-fluid">
        <div class="row">
            <!-- leftComponent -->
            <div class="leftComponent col-md-5">
                <img src="img/22.gif" alt="Leave Image" class="img-fluid">
            </div>
            <!-- leftComponent ends -->

            <!-- rightComponent -->
            <div class="rightComponent col-md-5">
                <!-- Clock moved above login heading -->
                <div class="login-clock">
                    <div class="digital-clock">
                        <div class="time" id="time">10:41:42</div>
                        <div class="date" id="date">Fri, 25 April 2025</div>
                    </div>
                </div>

                <br>

                <h3>Please login to continue . . . . .</h3>
                <hr>
                <form method="POST" class="loginForm">
                    <div class="alert alert-danger" id="invalidMsg">
                        <?php      
                            if(isset($_POST['login'])){
                                if($login == false)
                                    echo "<script type='text/javascript'>document.getElementById('invalidMsg').style.display = 'block';</script>";
                                    echo "Invalid Username or Password";
                            }
                            else
                                echo "";
                        ?>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="text" id="username" name="username" placeholder="Enter Username" required>
                    </div>
                    <div class="mb-3">
                        <input class="form-control" type="password" id="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <input type="submit" class="btn btn-success" name="login" value="Log In">
                </form>
            </div>
            <!-- rightComponent ends -->
        </div>
    </div>
    <!-- body ends -->
     
    <div class="content2">
        <p class="heading lead text-start">
        Simple yet effective for System Access Application ICT PKNP
        </p>
        <p class="text-start">
        System Access Application ICT PKNP is a system designed to streamline the application process for employees in the Pahang State Development Corporation (PKNP).
        This system allows employees in PKNP to submit and manage their applications to access the system online easily.
        </p>
    </div>

    <footer class="footer navbar navbar-expand-lg navbar-light bg-light" style="color:white;">
    <div>
      <p class="text-center">&copy; <?php echo date("Y"); ?> - Pahang State Development Corporation (PKNP)</p>
      <p class="text-center">Developed by ICT Department</p>
      <a href="https://pknp.gov.my/en/" target="_blank" style="text-decoration: none;">Pahang State Development Corporation (PKNP)</a><br>
      <a href="https://pknp.my/web-v1/index.php" target="_blank" style="text-decoration: none;">E-Agency</a>
    </div>
    </footer>

    <!-- Clock JavaScript with 24-hour format -->
    <script>
        function updateClock() {
            const now = new Date();
            
            // Time in 24-hour format
            const hours = now.getHours().toString().padStart(2, '0');
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');
            
            // Date formatting
            const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const months = ['January', 'February', 'March', 'April', 'May', 'June', 
                           'July', 'August', 'September', 'October', 'November', 'December'];
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            
            // Update elements
            document.getElementById('time').textContent = `${hours}:${minutes}:${seconds}`;
            document.getElementById('date').textContent = `${dayName}, ${date} ${monthName} ${year}`;
            
            setTimeout(updateClock, 1000);
        }
        
        // Start the clock when page loads
        window.onload = updateClock;
    </script>
</body>
</html>

<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
?>