<?php 
require_once("includes/config.php");

// Check if ISBN is provided
if (!empty($_POST["isbn"])) {
    $isbn = $_POST["isbn"];
    
    // Prepare SQL query to check if ISBN exists
    $sql = "SELECT id FROM tblbooks WHERE ISBNNumber = :isbn";
    $query = $dbh->prepare($sql);
    $query->bindParam(':isbn', $isbn, PDO::PARAM_STR);
    $query->execute();
    
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    
    // Check if any results were returned
    if ($query->rowCount() > 0) {
        echo "<span style='color:red'> ISBN already exists with another book.</span>"; 
        echo "<script>$('#add').prop('disabled', true);</script>";
    } else {
        echo "<script>$('#add').prop('disabled', false);</script>";
    }
}
?>
