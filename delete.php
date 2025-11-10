<?php

if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once 'db_connect.php';


    $sql = "DELETE FROM students WHERE id = ?";

    if($stmt = $conn->prepare($sql)){
        
        $stmt->bind_param("i", $param_id);


        $param_id = trim($_GET["id"]);


        if($stmt->execute()){
           
            header("location: read.php");
            exit();
        } else{
            echo "Oops! Something went wrong during deletion. Please try again later.";
        }
    }
    $stmt->close();
    $conn->close();
} else {

    header("location: read.php");
    exit();
}
?>