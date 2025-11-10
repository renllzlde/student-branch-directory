<?php
// We only process the delete if an ID is passed in the URL
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once 'db_connect.php';

    // Prepare a delete statement
    $sql = "DELETE FROM students WHERE id = ?";

    if($stmt = $conn->prepare($sql)){
        // Bind the ID parameter
        $stmt->bind_param("i", $param_id);

        // Set parameter from URL
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Success! Redirect to the read page
            header("location: read.php");
            exit();
        } else{
            echo "Oops! Something went wrong during deletion. Please try again later.";
        }
    }
    $stmt->close();
    $conn->close();
} else {
    // If ID parameter is missing, redirect to the read page
    header("location: read.php");
    exit();
}
?>