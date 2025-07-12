<?php

include 'connection.php';

$sql = "CREATE TABLE IF NOT EXISTS filtterText(
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if ($con->query($sql) === TRUE) {
    echo "Table 'projects' created successfully.";
} else {
    echo "Error creating table: " . $con->error;
}

$con->close();
?>

