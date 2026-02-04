<?php
echo "<h1>Database Diagnostic Check</h1>";

// Check connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "student_mgmt";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    echo "<p style='color: red;'><strong>❌ Connection Error:</strong> " . mysqli_connect_error() . "</p>";
    die();
} else {
    echo "<p style='color: green;'><strong>✓ Connected to database: $database</strong></p>";
}

// Check if student table exists
$result = mysqli_query($conn, "SHOW TABLES LIKE 'student'");
if (mysqli_num_rows($result) > 0) {
    echo "<p style='color: green;'><strong>✓ Table 'student' exists</strong></p>";
    
    // Show table structure
    echo "<h2>Table Structure:</h2>";
    $columns = mysqli_query($conn, "DESCRIBE student");
    echo "<table border='1' cellpadding='10'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    while ($col = mysqli_fetch_assoc($columns)) {
        echo "<tr>";
        echo "<td>" . $col['Field'] . "</td>";
        echo "<td>" . $col['Type'] . "</td>";
        echo "<td>" . $col['Null'] . "</td>";
        echo "<td>" . $col['Key'] . "</td>";
        echo "<td>" . $col['Default'] . "</td>";
        echo "<td>" . $col['Extra'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Count records
    $count = mysqli_query($conn, "SELECT COUNT(*) AS total FROM student");
    $row = mysqli_fetch_assoc($count);
    echo "<p><strong>Total records in student table: " . $row['total'] . "</strong></p>";
    
} else {
    echo "<p style='color: red;'><strong>❌ Table 'student' does NOT exist</strong></p>";
    echo "<p>You need to create the table first. Copy and run this SQL:</p>";
    echo "<pre>";
    echo "CREATE TABLE student (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    email VARCHAR(100) NOT NULL
);";
    echo "</pre>";
}

mysqli_close($conn);
?>
