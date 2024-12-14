<?php 
require_once("includes/config.php");

// Check if book ID is provided
if (!empty($_POST["bookid"])) {
    $bookid = $_POST["bookid"];
 
    // Prepare the SQL query to fetch book details
    $sql = "
        SELECT DISTINCT 
            tblbooks.BookName,
            tblbooks.id,
            tblauthors.AuthorName,
            tblbooks.bookImage,
            tblbooks.isIssued 
        FROM tblbooks
        JOIN tblauthors ON tblauthors.id = tblbooks.AuthorId
        WHERE (ISBNNumber = :bookid OR BookName LIKE :bookid)";
    
    $query = $dbh->prepare($sql);
    $query->bindParam(':bookid', $bookid, PDO::PARAM_STR);
    
    // Use wildcards for the LIKE clause
    $wildcardBookId = "%" . $bookid . "%";
    $query->bindParam(':wildcardBookId', $wildcardBookId, PDO::PARAM_STR);
    
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() > 0) {
?>
        <table border="1">
            <tr>
                <?php foreach ($results as $result) { ?>
                    <th style="padding-left:5%; width: 10%;">
                        <img src="bookimg/<?php echo htmlentities($result->bookImage); ?>" width="120"><br />
                        <?php echo htmlentities($result->BookName); ?><br />
                        <?php echo htmlentities($result->AuthorName); ?><br />

                        <?php if ($result->isIssued == '1'): ?>
                            <p style="color:red;">Book Already issued</p>
                        <?php else: ?>
                            <input type="radio" name="bookid" value="<?php echo htmlentities($result->id); ?>" required>
                        <?php endif; ?>
                    </th>
                <?php 
                    // Enable submit button
                    echo "<script>$('#submit').prop('disabled', false);</script>";
                }
                ?>
            </tr>
        </table>
    </div>
</div>

<?php  
    } else { ?>
        <p>Record not found. Please try again.</p>
        <?php 
        // Disable submit button
        echo "<script>$('#submit').prop('disabled', true);</script>";
    }
}
?>
