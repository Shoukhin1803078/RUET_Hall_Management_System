<?php
// Retrieve image data from the database
$sql = "SELECT image_data, image_name FROM images WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $imageId); // Assuming $imageId is the ID of the image you want to display
$stmt->execute();
$stmt->bind_result($imageData, $imageName);
$stmt->fetch();
$stmt->close();

// Display the image
header("Content-type: image/jpeg"); // Adjust the content type based on your image type
echo $imageData;
?>
