
<?php
// Configuration
$host = 'localhost';
$username = 'your_username';
$password = 'your_password';
$dbname = 'your_database';

// Connect to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Send Message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['message']) {
    $message = $_POST['message'];
    $sql = "INSERT INTO messages (message) VALUES ('$message')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => $message]);
    } else {
        echo json_encode(['error' => $conn->error]);
    }
}

// Upload Image
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_FILES['image']) {
    $image = $_FILES['image'];
    $uploadDir = 'uploads/';
    $imageName = $image['name'];
    $imagePath = $uploadDir . $imageName;
    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
        $sql = "INSERT INTO images (url) VALUES ('$imagePath')";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['url' => $imagePath]);
        } else {
            echo json_encode(['error' => $conn->error]);
        }
    } else {
        echo json_encode(['error' => 'Failed to upload image']);
    }
}

$conn->close();
?>
