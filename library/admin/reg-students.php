<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else { 

    // Code for blocking a student
    if (isset($_GET['inid'])) {
        $id = $_GET['inid'];
        $status = 0; // Blocked status
        $sql = "UPDATE tblstudents SET Status = :status WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('location:reg-students.php');
    }

    // Code for activating a student
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $status = 1; // Active status
        $sql = "UPDATE tblstudents SET Status = :status WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->execute();
        header('location:reg-students.php');
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Manage Reg Students</title>
    
    <!-- CSS Includes -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <!-- Menu Section Start -->
    <?php include('includes/adminheader.php'); ?>
    <!-- Menu Section End -->

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Manage Registered Students</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Registered Students
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Email ID</th>
                                            <th>Mobile Number</th>
                                            <th>Reg Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = "SELECT * FROM tblstudents";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;

                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>                                      

                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->StudentId); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->FullName); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->EmailId); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->MobileNumber); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->RegDate); ?></td>
                                                    <td class="center">
                                                        <?php 
                                                        if ($result->Status == 1) {
                                                            echo htmlentities("Active");
                                                        } else {
                                                            echo htmlentities("Blocked");
                                                        } ?>
                                                    </td>
                                                    <td class="center">
                                                        <?php if ($result->Status == 1) { ?>
                                                            <a href="reg-students.php?inid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to block this student?');">
                                                                <button class="btn btn-danger">Inactive</button>
                                                            </a>
                                                        <?php } else { ?>
                                                            <a href="reg-students.php?id=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to activate this student?');">
                                                                <button class="btn btn-primary">Active</button>
                                                            </a>
                                                        <?php } ?>

                                                        <a href="student-history.php?stdid=<?php echo htmlentities($result->StudentId); ?>">
                                                            <button class="btn btn-success">Details</button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php $cnt++; 
                                            }
                                        } ?>                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Advanced Tables -->
                </div>
            </div>
        </div>
    </div>

    <!-- JS Includes -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
