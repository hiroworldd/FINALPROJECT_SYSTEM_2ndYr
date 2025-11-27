<?php
session_start();
include 'db.php'; 

if (isset($_POST['send_message'])) {
   
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['message_error'] = "All fields are required.";
        header("Location: message.php");
        exit();
    }

   
    $stmt = $conn->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        $_SESSION['message_success'] = "Your message has been sent successfully!";
        header("Location: message.php");
        exit();
    } else {
        $_SESSION['message_error'] = "Failed to send message. Please try again.";
        header("Location: message.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: message.php");
    exit();
}
?>
