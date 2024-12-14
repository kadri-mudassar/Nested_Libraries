<?php
session_start();
error_reporting(0);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else { 

    if (isset($_POST['update'])) {
        $bookid = intval($_GET['bookid']);
        $bookimg = $_FILES["bookpic"]["name"];
        
        // Current image
        $cimage = $_POST['curremtimage'];
        $cpath = "bookimg/" . $cimage;
        
        // Get the image extension
        $extension = substr($bookimg, strlen($bookimg) - 4, strlen($bookimg));
        
        // Allowed extensions
        $allowed_extensions = array(".jpg", ".jpeg", ".png", ".gif");
        
        // Rename the image file
        $imgnewname = md5($bookimg . time()) . $extension;

        // Validate file extension
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Invalid format. Only jpg / jpeg / png / gif format allowed');</script>";
        } else {
            // Move the uploaded image to the directory
            move_uploaded_file($_FILES["bookpic"]["tmp_name"], "bookimg/" . $imgnewname);

            // Update the database with the new image
            $sql = "UPDATE tblbooks SET bookImage = :imgnewname WHERE id = :bookid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':imgnewname', $imgnewname, PDO::PARAM_STR);
            $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
            $query->execute();
            
            // Delete the old image
            unlink($cpath);

            echo "<script>alert('Book image updated successfully');</script>";
            echo "<script>window.location.href='manage-books.php'</script>";
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
    <title>Online Library Management System | Edit Book</title>
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
                    <h4 class="header-line">Add Book</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Book Info
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post" enctype="multipart/form-data">
                                <?php 
                                $bookid = intval($_GET['bookid']);
                                $sql = "SELECT tblbooks.BookName, tblbooks.id AS bookid, tblbooks.bookImage FROM tblbooks WHERE tblbooks.id = :bookid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) { ?>  
                                        <input type="hidden" name="curremtimage" value="<?php echo htmlentities($result->bookImage); ?>">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Book Image</label>
                                                <img src="bookimg/<?php echo htmlentities($result->bookImage); ?>" width="100">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Book Name <span style="color:red;">*</span></label>
                                                <input class="form-control" type="text" name="bookname" value="<?php echo htmlentities($result->BookName); ?>" readonly />
                                            </div>
                                        </div>
                                        <div class="col-md-6">  
                                            <div class="form-group">
                                                <label>Book Picture <span style="color:red;">*</span></label>
                                                <input class="form-control" type="file" name="bookpic" autocomplete="off" required="required" />
                                            </div>
                                        </div>
                                <?php 
                                    }
                                } ?>
                                <div class="col-md-12">
                                    <button type="submit" name="update" class="btn btn-info">Update</button>
                                </div>
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