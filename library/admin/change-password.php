<?php
session_start();
include('includes/config.php');
error_reporting(0);

// Check if user is logged in
if (strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else { 
    // Handle password change
    if (isset($_POST['change'])) {
        $password = md5($_POST['password']);
        $newpassword = md5($_POST['newpassword']);
        $username = $_SESSION['alogin'];

        // Verify current password
        $sql = "SELECT Password FROM admin WHERE UserName = :username AND Password = :password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();

        if ($query->rowCount() > 0) {
            // Update password
            $con = "UPDATE admin SET Password = :newpassword WHERE UserName = :username";
            $chngpwd1 = $dbh->prepare($con);
            $chngpwd1->bindParam(':username', $username, PDO::PARAM_STR);
            $chngpwd1->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
            $chngpwd1->execute();
            $msg = "Your password has been successfully changed";
        } else {
            $error = "Your current password is incorrect";  
        }
    }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Change Password</title>

    <!-- Stylesheets -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    <style>
        .errorWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #dd3d36;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
        .succWrap {
            padding: 10px;
            margin: 0 0 20px 0;
            background: #fff;
            border-left: 4px solid #5cb85c;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
        }
    </style>
</head>
<script type="text/javascript">
function valid() {
    if (document.chngpwd.newpassword.value != document.chngpwd.confirmpassword.value) {
        alert("New Password and Confirm Password fields do not match!");
        document.chngpwd.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>

<body>
    <?php include('includes/adminheader.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">User Change Password</h4>
                </div>
            </div>

            <?php if ($error) { ?>
                <div class="errorWrap"><strong>ERROR</strong>: <?php echo htmlentities($error); ?></div>
            <?php } else if ($msg) { ?>
                <div class="succWrap"><strong>SUCCESS</strong>: <?php echo htmlentities($msg); ?></div>
            <?php } ?>            

            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Change Password
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" onSubmit="return valid();" name="chngpwd">
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input class="form-control" type="password" name="password" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>New Password</label>
                                    <input class="form-control" type="password" name="newpassword" autocomplete="off" required />
                                </div>

                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input class="form-control" type="password" name="confirmpassword" autocomplete="off" required />
                                </div>

                                <button type="submit" name="change" class="btn btn-info">Change</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>

    <!-- JavaScript Scripts -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>

<?php } ?>
