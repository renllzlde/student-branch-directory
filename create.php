<?php

require_once 'db_connect.php';

$name = $email = "";
$name_err = $email_err = "";


if($_SERVER["REQUEST_METHOD"] == "POST"){

    
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter a name.";
    } else{
        $name = trim($_POST["name"]);
    }

    
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email.";
    } else{
        
        $sql = "SELECT id FROM students WHERE email = ?";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("s", $param_email);
            $param_email = trim($_POST["email"]);

            if($stmt->execute()){
                $stmt->store_result();
                if($stmt->num_rows == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            }
            $stmt->close();
        }
    }

    
    if(empty($name_err) && empty($email_err)){
        
        $sql = "INSERT INTO students (name, email) VALUES (?, ?)";

        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("ss", $param_name, $param_email);
            $param_name = $name;
            $param_email = $email;

            if($stmt->execute()){
                
                header("location: read.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
            $stmt->close();
        }
    }

    
    if ($conn->close()) {}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student Record</title>
    <style>
        .error { color: red; }
        form div { margin-bottom: 15px; }
        label { display: block; }
    </style>
</head>
<body>
    <h2>Add New Student Record (CREATE Operation)</h2>
    <p>Please fill this form and submit to add a student record.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
        <div>
            <input type="submit" value="Submit">
            <a href="read.php">Cancel</a>
        </div>
    </form>
</body>
</html>