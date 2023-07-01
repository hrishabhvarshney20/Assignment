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

// Get the form data
$name = $_POST['name'];
$age = $_POST['age'];
$weight = $_POST['weight'];
$email = $_POST['email'];
$healthReport = $_FILES['healthReport'];

// Insert user details into the database
$sql = "INSERT INTO users (name, age, weight, email) VALUES ('$name', '$age', '$weight', '$email')";
if ($conn->query($sql) === TRUE) {
    // Get the ID of the newly inserted user
    $userId = $conn->insert_id;

    // Move the uploaded health report file to a designated folder
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($healthReport['name']);
    move_uploaded_file($healthReport['tmp_name'], $targetFile);

    // Insert the health report file details into the database
    $sql = "INSERT INTO health_reports (user_id, file_name, file_path) VALUES ('$userId', '$healthReport[name]', '$targetFile')";
    if ($conn->query($sql) === TRUE) {
        echo "Form submitted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>
