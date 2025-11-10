<?php
require_once 'db_connect.php';

echo "<h2>Student Records (READ Operation)</h2>";

$sql = "SELECT id, name, email FROM students ORDER BY id";
if($result = $conn->query($sql)){
    if($result->num_rows > 0){
        echo "<table border='1' style='border-collapse: collapse; width: 50%;'>";
            echo "<thead><tr><th>#</th><th>Name</th><th>Email</th><th>Action</th></tr></thead>";
            echo "<tbody>";
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td><a href='update.php?id=" . $row['id'] . "'>Edit</a></td>"; // Placeholder for future CRUD links
                echo "</tr>";
            }
            echo "</tbody>";
        echo "</table>";
        $result->free();
    } else{
        echo "<p><em>No records were found.</em></p>";
        echo "<p><a href='create.php'>Add New Student</a></p>";
    }
} else{
    echo "ERROR: Could not execute $sql. " . $conn->error;
}

$conn->close();
?>