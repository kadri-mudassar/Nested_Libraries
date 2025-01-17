<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if user is logged in
if (strlen($_SESSION['alogin']) == 0) {   
    header('location:index.php');
} else {
    // Handle deletion of a book
    if (isset($_GET['del'])) {
        $id = $_GET['del'];
        $sql = "DELETE FROM tblbooks WHERE id = :id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_STR);
        $query->execute();
        $_SESSION['delmsg'] = "Book deleted successfully";
        header('location:manage-books.php');
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Manage Books</title>

    <!-- Bootstrap Core Style -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- Font Awesome Style -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DataTable Style -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- Custom Style -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- Google Font -->
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
                    <h4 class="header-line">Manage Books</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Books Listing
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Book Name</th>
                                            <th>Category</th>
                                            <th>Author</th>
                                            <th>ISBN</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $sql = "SELECT tblbooks.BookName, tblcategory.CategoryName, tblauthors.AuthorName, tblbooks.ISBNNumber, tblbooks.BookPrice, tblbooks.id as bookid, tblbooks.bookImage 
                                                FROM tblbooks 
                                                JOIN tblcategory ON tblcategory.id = tblbooks.CatId 
                                                JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;

                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) { ?>                                      

                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo htmlentities($cnt); ?></td>
                                                    <td class="center" width="300">
                                                        <img src="bookimg/<?php echo htmlentities($result->bookImage); ?>" width="100">
                                                        <br /><b><?php echo htmlentities($result->BookName); ?></b>
                                                    </td>
                                                    <td class="center"><?php echo htmlentities($result->CategoryName); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->AuthorName); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->ISBNNumber); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->BookPrice); ?></td>
                                                    <td class="center">
                                                        <a href="edit-book.php?bookid=<?php echo htmlentities($result->bookid); ?>">
                                                            <button class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button>
                                                        </a>
                                                        <a href="manage-books.php?del=<?php echo htmlentities($result->bookid); ?>" onclick="return confirm('Are you sure you want to delete?');">
                                                            <button class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
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
                    <!-- End Advanced Tables -->
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
