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
    <title>Online Library Management System | Student History</title>
    
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
                    <?php $sid = $_GET['stdid']; ?>
                    <h4 class="header-line">#<?php echo htmlentities($sid); ?> Book Issued History</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo htmlentities($sid); ?> Details
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student ID</th>
                                            <th>Student Name</th>
                                            <th>Issued Book</th>
                                            <th>Issued Date</th>
                                            <th>Returned Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        // Fetch issued book details for the specific student
                                        $sql = "SELECT 
                                                    tblstudents.StudentId,
                                                    tblstudents.FullName,
                                                    tblbooks.BookName,
                                                    tblissuedbookdetails.IssuesDate,
                                                    tblissuedbookdetails.ReturnDate
                                                FROM 
                                                    tblissuedbookdetails 
                                                JOIN 
                                                    tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId 
                                                JOIN 
                                                    tblbooks ON tblbooks.id = tblissuedbookdetails.BookId 
                                                WHERE 
                                                    tblstudents.StudentId = :sid";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':sid', $sid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;

                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>                                      

                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->StudentId); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->FullName); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->BookName); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->IssuesDate); ?></td>
                                                    <td class="center">
                                                        <?php 
                                                        if ($result->ReturnDate == '') {
                                                            echo "Not returned yet";
                                                        } else {
                                                            echo htmlentities($result->ReturnDate);
                                                        } ?>
                                                    </td>
                                                </tr>
                                                <?php 
                                                $cnt++;
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
    <!-- <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="assets/js/custom.js"></script> -->
</body>
</html>
<?php } ?>
