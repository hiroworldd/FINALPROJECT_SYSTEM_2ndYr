<?php
require_once __DIR__.'/../includes/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "CREATE TABLE IF NOT EXISTS messages (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        message TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    mysqli_query($conn, $sql);

    $insert = "INSERT INTO messages (name,email,message) VALUES ('$name','$email','$message')";
    if(mysqli_query($conn, $insert)){
        echo "<script>alert('Message sent successfully!'); window.location='message.php';</script>";
    } else {
        echo "<script>alert('Error sending message.'); window.location='message.php';</script>";
    }
}
?>
