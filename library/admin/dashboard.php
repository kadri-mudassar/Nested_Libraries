<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
    exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Admin Dash Board</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <?php include('includes/adminheader.php'); ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">ADMIN DASHBOARD</h4>
                </div>
            </div>
            <div class="row">
                <a href="manage-books.php">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="alert alert-success back-widget-set text-center">
                            <i class="fa fa-book fa-5x"></i>
                            <?php 
                            $sql = "SELECT id FROM tblbooks";
                            $query = $dbh->prepare($sql);
                            $query->execute();
                            $listdbooks = $query->rowCount();
                            ?>
                            <h3><?php echo htmlentities($listdbooks); ?></h3>
                            Books Listed
                        </div>
                    </div>
                </a>
                <a href="manage-issued-books.php">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="alert alert-warning back-widget-set text-center">
                            <i class="fa fa-recycle fa-5x"></i>
                            <?php 
                            $sql2 = "SELECT id FROM tblissuedbookdetails WHERE (RetrunStatus='' OR RetrunStatus IS NULL)";
                            $query2 = $dbh->prepare($sql2);
                            $query2->execute();
                            $returnedbooks = $query2->rowCount();
                            ?>
                            <h3><?php echo htmlentities($returnedbooks); ?></h3>
                            Books Not Returned Yet
                        </div>
                    </div>
                </a>
                <a href="reg-students.php">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="alert alert-danger back-widget-set text-center">
                            <i class="fa fa-users fa-5x"></i>
                            <?php 
                            $sql3 = "SELECT id FROM tblstudents";
                            $query3 = $dbh->prepare($sql3);
                            $query3->execute();
                            $regstds = $query3->rowCount();
                            ?>
                            <h3><?php echo htmlentities($regstds); ?></h3>
                            Registered Users
                        </div>
                    </div>
                </a>
                <a href="manage-authors.php">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="alert alert-success back-widget-set text-center">
                            <i class="fa fa-user fa-5x"></i>
                            <?php 
                            $sql4 = "SELECT id FROM tblauthors";
                            $query4 = $dbh->prepare($sql4);
                            $query4->execute();
                            $listdathrs = $query4->rowCount();
                            ?>
                            <h3><?php echo htmlentities($listdathrs); ?></h3>
                            Authors Listed
                        </div>
                    </div>
                </a>
            </div>
            <div class="row">
                <a href="manage-categories.php">
                    <div class="col-md-3 col-sm-3 col-xs-6">
                        <div class="alert alert-info back-widget-set text-center">
                            <i class="fa fa-file-archive-o fa-5x"></i>
                            <?php 
                            $sql5 = "SELECT id FROM tblcategory";
                            $query5 = $dbh->prepare($sql5);
                            $query5->execute();
                            $listdcats = $query5->rowCount();
                            ?>
                            <h3><?php echo htmlentities($listdcats); ?></h3>
                            Listed Categories
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
