<?php 
require_once("includes/config.php");

// Check if student ID is provided
if (!empty($_POST["studentid"])) {
    // Convert student ID to uppercase
    $studentid = strtoupper($_POST["studentid"]);

    // Prepare SQL query to fetch student details
    $sql = "
        SELECT 
            FullName,
            Status,
            EmailId,
            MobileNumber 
        FROM tblstudents 
        WHERE StudentId = :studentid";
    
    $query = $dbh->prepare($sql);
    $query->bindParam(':studentid', $studentid, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    // Check if any results were found
    if ($query->rowCount() > 0) {
        foreach ($results as $result) {
            // Check if the student is blocked
            if ($result->Status == 0) {
                echo "<span style='color:red'> Student ID Blocked </span><br />";
                echo "<b>Student Name:</b> " . htmlentities($result->FullName);
                echo "<script>$('#submit').prop('disabled', true);</script>";
            } else {
                // Display student details
                echo htmlentities($result->FullName) . "<br />";
                echo htmlentities($result->EmailId) . "<br />";
                echo htmlentities($result->MobileNumber);
                echo "<script>$('#submit').prop('disabled', false);</script>";
            }
        }
    } else {
        // No valid student ID found
        echo "<span style='color:red'> Invalid Student ID. Please enter a valid Student ID.</span>";
        echo "<script>$('#submit').prop('disabled', true);</script>";
    }
}
?>
