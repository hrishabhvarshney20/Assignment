<?php
// MySQL database connection details
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the email ID from the query string
$email = $_GET['email'];

// Fetch the health report file details from the database
$sql = "SELECT file_path FROM health_reports JOIN users ON health_reports.user_id = users.id WHERE users.email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the file path
    $row = $result->fetch_assoc();
    $filePath = $row['file_path'];

    // Send the PDF file as a download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    readfile($filePath);
} else {
    echo "Health report not found for the specified email ID.";
}

// Close the database connection
$conn->close();
?>
