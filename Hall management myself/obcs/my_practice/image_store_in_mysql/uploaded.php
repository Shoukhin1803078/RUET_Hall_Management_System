<?php
// Database connection parameters
$servername = "your_server_name";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle file upload
$imageData = file_get_contents($_FILES['image']['tmp_name']);
$imageName = $_FILES['image']['name'];

// Insert image data into the database
$sql = "INSERT INTO images (image_data, image_name) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $imageData, $imageName);
$stmt->execute();
$stmt->close();

// Close database connection
$conn->close();

// Redirect or display a success message
header("Location: success.php");
exit();
?>
