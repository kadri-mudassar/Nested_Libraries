<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Check if the user is logged in
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else { 
    // Check if the update form has been submitted
    if (isset($_POST['update'])) {
        $category = $_POST['category'];
        $status = $_POST['status'];
        $catid = intval($_GET['catid']);

        // Update category information in the database
        $sql = "UPDATE tblcategory SET CategoryName = :category, Status = :status WHERE id = :catid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':category', $category, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':catid', $catid, PDO::PARAM_STR);
        $query->execute();

        $_SESSION['updatemsg'] = "Category updated successfully";
        header('location:manage-categories.php');
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Online Library Management System | Edit Categories</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <!-- MENU SECTION START -->
    <?php include('includes/adminheader.php'); ?>
    <!-- MENU SECTION END -->

    <div class="content-wrapper">
        <div class="container">
            <div class="row pad-botm">
                <div class="col-md-12">
                    <h4 class="header-line">Edit Category</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            Category Info
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <?php 
                                $catid = intval($_GET['catid']);
                                $sql = "SELECT * FROM tblcategory WHERE id = :catid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':catid', $catid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {               
                                ?> 
                                    <div class="form-group">
                                        <label>Category Name</label>
                                        <input class="form-control" type="text" name="category" value="<?php echo htmlentities($result->CategoryName); ?>" required />
                                    </div>

                                    <div class="form-group">
                                        <label>Status</label>
                                        <?php if ($result->Status == 1) { ?>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="1" checked="checked">Active
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="0">Inactive
                                                </label>
                                            </div>
                                        <?php } else { ?>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="0" checked="checked">Inactive
                                                </label>
                                            </div>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status" value="1">Active
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                <?php 
                                    } 
                                } ?>
                                <button type="submit" name="update" class="btn btn-info">Update</button>
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
