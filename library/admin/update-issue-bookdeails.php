<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else { 

    // Handle submitting the fine
    if (isset($_POST['submitFine'])) {
        $rid = intval($_GET['rid']);
        $fine = $_POST['fine'];
        $bookid = $_POST['bookid'];
        $studentId = $_POST['studentId'];

        // Update fine in issued book details and student's fine
        $sql = "UPDATE tblissuedbookdetails SET fine=:fine WHERE id=:rid;
                UPDATE tblstudents SET fineDue=fineDue + :fine WHERE StudentId=:studentId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->bindParam(':fine', $fine, PDO::PARAM_STR);
        $query->bindParam(':studentId', $studentId, PDO::PARAM_STR);
        $query->execute();

        $_SESSION['msg'] = "Fine submitted successfully";
        header('location:manage-issued-books.php');
    }

    // Handle deleting the book
    if (isset($_POST['delete'])) {
        $rid = intval($_GET['rid']);
        $sql = "DELETE FROM tblissuedbookdetails WHERE id=:rid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':rid', $rid, PDO::PARAM_STR);
        $query->execute();

        $_SESSION['msg'] = "Issued book deleted successfully";
        header('location:manage-issued-books.php');
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Online Library Management System | Issued Book Details</title>
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
                    <h4 class="header-line">Issued Book Details</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Issued Book Details
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <?php 
                                $rid = intval($_GET['rid']);
                                $sql = "SELECT tblstudents.StudentId, tblstudents.FullName, tblstudents.EmailId, tblstudents.MobileNumber, 
                                        tblbooks.BookName, tblbooks.ISBNNumber, tblissuedbookdetails.IssuesDate, 
                                        tblissuedbookdetails.ReturnDate, tblissuedbookdetails.id as rid, 
                                        tblissuedbookdetails.fine, tblissuedbookdetails.RetrunStatus, 
                                        tblbooks.id as bid, tblbooks.bookImage 
                                        FROM tblissuedbookdetails 
                                        JOIN tblstudents ON tblstudents.StudentId=tblissuedbookdetails.StudentId 
                                        JOIN tblbooks ON tblbooks.id=tblissuedbookdetails.BookId 
                                        WHERE tblissuedbookdetails.id=:rid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':rid', $rid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>                                      

                                        <input type="hidden" name="bookid" value="<?php echo htmlentities($result->bid); ?>">
                                        <input type="hidden" name="studentId" value="<?php echo htmlentities($result->StudentId); ?>">
                                        <h4>Student Details</h4>
                                        <hr />
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Student ID :</label>
                                                <?php echo htmlentities($result->StudentId); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Student Name :</label>
                                                <?php echo htmlentities($result->FullName); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Student Email Id :</label>
                                                <?php echo htmlentities($result->EmailId); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Student Contact No :</label>
                                                <?php echo htmlentities($result->MobileNumber); ?>
                                            </div>
                                        </div>

                                        <h4>Book Details</h4>
                                        <hr />
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Book Image :</label>
                                                <img src="bookimg/<?php echo htmlentities($result->bookImage); ?>" width="120">
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Book Name :</label>
                                                <?php echo htmlentities($result->BookName); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>ISBN :</label>
                                                <?php echo htmlentities($result->ISBNNumber); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Book Issued Date :</label>
                                                <?php echo htmlentities($result->IssuesDate); ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-group">
                                                <label>Book Returned Date :</label>
                                                <?php echo $result->ReturnDate == "" ? "Not Returned Yet" : htmlentities($result->ReturnDate); ?>
                                            </div>
                                        </div>

                                        <h4>Fine Details</h4>
                                        <hr />
                                        <div class="col-md-12"> 
                                            <div class="form-group">
                                                <label>Fine (in USD) :</label>
                                                <input class="form-control" type="text" name="fine" id="fine" value="<?php echo htmlentities($result->fine); ?>" required />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button type="submit" name="delete" class="btn btn-danger">Delete Book</button>
                                            <button type="submit" name="submitFine" class="btn btn-success pull-left" style="margin-left: 10px;">Submit Fine</button>
                                        </div>
                                    <?php }
                                } ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
