<?php
// Start session and error reporting
session_start();
error_reporting(0);
include('includes/config.php');

// Handle login when the form is submitted
if (isset($_POST['login'])) {
    $emailOrUsername = $_POST['emailOrUsername'];
    $password = $_POST['password'];

    // Check if it's an admin login
    $adminSql = "SELECT UserName, Password FROM admin WHERE AdminEmail = :identifier OR UserName = :identifier";
    $query = $dbh->prepare($adminSql);
    $query->bindParam(':identifier', $emailOrUsername, PDO::PARAM_STR);
    $query->execute();
    $adminResult = $query->fetch(PDO::FETCH_OBJ);

    // Validate admin credentials
    if ($adminResult && $adminResult->Password === $password) {
        $_SESSION['alogin'] = $adminResult->UserName;
        echo "<script type='text/javascript'> document.location ='admin/dashboard.php'; </script>";
        exit;
    }

    // Check if it's a user login
    $userSql = "SELECT EmailId, Password, StudentId, Status FROM tblstudents WHERE EmailId = :email";
    $query = $dbh->prepare($userSql);
    $query->bindParam(':email', $emailOrUsername, PDO::PARAM_STR);
    $query->execute();
    $userResult = $query->fetch(PDO::FETCH_OBJ);

    // Validate user credentials
    if ($userResult && $userResult->Password === $password) {
        if ($userResult->Status == 1) {
            $_SESSION['stdid'] = $userResult->StudentId;
            $_SESSION['login'] = $userResult->EmailId;
            echo "<script type='text/javascript'> document.location ='dashboard.php'; </script>";
        } else {
            echo "<script>alert('Your Account has been blocked. Please contact admin.');</script>";
        }
    } else {
        echo "<script>alert('Invalid email/username or password.');</script>";
    }
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">    
    <title>The Reading Nest | Login</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: #ececec;
        }
        /*------------ Login container ------------*/
        .box-area {
            width: 930px;
        }
        /*------------ Right box ------------*/
        .right-box {
            padding: 40px 30px 40px 40px;
        }
        /*------------ Custom Placeholder ------------*/
        ::placeholder {
            font-size: 16px;
        }
        .rounded-4 {
            border-radius: 20px;
        }
        .rounded-5 {
            border-radius: 30px;
        }
        /*------------ For small screens------------*/
        @media only screen and (max-width: 768px) {
            .box-area {
                margin: 0 10px;
            }
            .left-box {
                height: 100px;
                overflow: hidden;
            }
            .right-box {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 bg-white shadow box-area">
            <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #103cbe;">
                <div class="featured-image mb-3">
                    <img src="image/1.png" class="img-fluid" style="width: 250px;">
                </div>
                <p class="text-white fs-2" style="font-family: 'Courier New', Courier, monospace; font-weight: 600;">Be Verified</p>
                <small class="text-white text-wrap text-center" style="width: 17rem; font-family: 'Courier New', Courier, monospace;">Join experienced Designers on this platform.</small>
            </div> 

            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <div class="header-text mb-4">
                        <h2>Hello, Again</h2>
                        <p>We are happy to have you back.</p>
                    </div>
                    <form role="form" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control form-control-lg bg-light fs-6" name="emailOrUsername" placeholder="Enter Email or Username" required autocomplete="off">
                        </div>
                        <div class="input-group mb-1">
                            <input type="password" class="form-control form-control-lg bg-light fs-6" name="password" placeholder="Password" required autocomplete="off">
                        </div>
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                            </div>
                            <div class="forgot">
                                <small><a href="user-forgot-password.php">Forgot Password?</a></small>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <button type="submit" name="login" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                        </div>
                        <div class="row">
                            <small>Don't have an account? <a href="signup.php">Sign Up</a></small>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html> 
