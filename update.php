<?php
require_once 'db_connect.php';

$id = $name = $email = "";
$name_err = $email_err = "";


if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];

    
    if(empty(trim($_POST["name"]))){ $name_err = "Please enter a name."; } else{ $name = trim($_POST["name"]); }
    if(empty(trim($_POST["email"]))){ $email_err = "Please enter an email."; } else{ $email = trim($_POST["email"]); }

    
    if(empty($name_err) && empty($email_err)){
        
        
        $sql = "UPDATE students SET name=?, email=? WHERE id=?";

        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("ssi", $param_name, $param_email, $param_id);

            $param_name = $name;
            $param_email = $email;
            $param_id = $id;

            if($stmt->execute()){
                
                header("location: read.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later during execution.";
            }
            $stmt->close();
        }
    }
    $conn->close();

    
} elseif(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    $id = trim($_GET["id"]);

    
    $sql = "SELECT * FROM students WHERE id = ?";
    if($stmt = $conn->prepare($sql)){
        $stmt->bind_param("i", $param_id);
        $param_id = $id;

        if($stmt->execute()){
            $result = $stmt->get_result();
            if($result->num_rows == 1){
                
                $row = $result->fetch_assoc();
                $name = $row["name"];
                $email = $row["email"];
            } else{
                
                echo "Error: Record not found.";
                exit();
            }
        } else{
            echo "Oops! Something went wrong. Please try again later during fetch.";
        }
        $stmt->close();
    }
    $conn->close();
} else{
    
    header("location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <style>.error { color: red; } form div { margin-bottom: 15px; } label { display: block; }</style>
</head>
<body>
    <h2>Update Student Record (UPDATE Operation)</h2>
    <p>Edit the fields below and submit to update the student record.</p>
    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
        <div>
            <label>Name</label>
            <input type="text" name="name" value="<?php echo $name; ?>">
            <span class="error"><?php echo $name_err; ?></span>
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" value="<?php echo $email; ?>">
            <span class="error"><?php echo $email_err; ?></span>
        </div>
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div>
            <input type="submit" value="Submit">
            <a href="read.php">Cancel</a>
        </div>
    </form>
</body>
</html>