<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else { 
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>The Reading Nest | Manage Issued Books</title>

    <!-- CSS Includes -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <?php include('includes/adminheader.php'); ?>

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Manage Issued Books</h4>
                </div>
            </div>

            <div class="row">
                <!-- Display error and success messages -->
                <?php if ($_SESSION['error'] != "") { ?>
                    <div class="col-md-6">
                        <div class="alert alert-danger">
                            <strong>Error :</strong> 
                            <?php echo htmlentities($_SESSION['error']); ?>
                            <?php $_SESSION['error'] = ""; ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['msg'] != "") { ?>
                    <div class="col-md-6">
                        <div class="alert alert-success">
                            <strong>Success :</strong> 
                            <?php echo htmlentities($_SESSION['msg']); ?>
                            <?php $_SESSION['msg'] = ""; ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['delmsg'] != "") { ?>
                    <div class="col-md-6">
                        <div class="alert alert-success">
                            <strong>Success :</strong> 
                            <?php echo htmlentities($_SESSION['delmsg']); ?>
                            <?php $_SESSION['delmsg'] = ""; ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Issued Books 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Book Name</th>
                                            <th>ISBN</th>
                                            <th>Issued Date</th>
                                            <th>Return Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        // Fetch issued book details from the database
                                        $sql = "SELECT 
                                                    tblstudents.FullName,
                                                    tblbooks.BookName,
                                                    tblbooks.ISBNNumber,
                                                    tblissuedbookdetails.IssuesDate,
                                                    tblissuedbookdetails.ReturnDate,
                                                    tblissuedbookdetails.id as rid 
                                                FROM 
                                                    tblissuedbookdetails 
                                                JOIN 
                                                    tblstudents ON tblstudents.StudentId = tblissuedbookdetails.StudentId 
                                                JOIN 
                                                    tblbooks ON tblbooks.id = tblissuedbookdetails.BookId 
                                                ORDER BY 
                                                    tblissuedbookdetails.id DESC";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;

                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>                                      

                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->FullName); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->BookName); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->ISBNNumber); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->IssuesDate); ?></td>
                                                    <td class="center">
                                                        <?php 
                                                        // Display return date or a message if not returned
                                                        if ($result->ReturnDate == "") {
                                                            echo htmlentities("Not Returned Yet");
                                                        } else {
                                                            echo htmlentities($result->ReturnDate);
                                                        } ?>
                                                    </td>
                                                    <td class="center">
                                                        <a href="update-issue-bookdeails.php?rid=<?php echo htmlentities($result->rid); ?>">
                                                            <button class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button>
                                                        </a>
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
