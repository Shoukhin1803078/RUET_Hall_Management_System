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

// Handle file upload and database insertion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $imageName = $_FILES['image']['name'];

    // Insert image data into the database
    $sql = "INSERT INTO images (image_data, image_name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $imageData, $imageName);
    $stmt->execute();
    $stmt->close();
}

// Display images from the database
$sql = "SELECT id, image_name FROM images";
$result = $conn->query($sql);

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload and Display</title>
</head>
<body>

    <h2>Image Upload</h2>

    <!-- Form for image upload -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept="image/*">
        <input type="submit" value="Upload">
    </form>

    <h2>Image Gallery</h2>

    <!-- Display images from the database -->
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<img src="display.php?id=' . $row["id"] . '" alt="' . $row["image_name"] . '" style="max-width: 300px; margin: 10px;">';
        }
    } else {
        echo "No images in the database.";
    }
    ?>

</body>
</html>
