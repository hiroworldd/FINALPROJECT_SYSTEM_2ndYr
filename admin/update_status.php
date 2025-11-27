<?php
session_start();
include('db.php'); 

header('Content-Type: application/json');

if (!isset($_POST['id']) || !isset($_POST['status'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
    exit;
}

$id = intval($_POST['id']);
$status = $_POST['status'];

$allowed = ['successful', 'unsuccessful', 'pending'];
if (!in_array($status, $allowed)) {
    echo json_encode(['success' => false, 'error' => 'Invalid status']);
    exit;
}

$stmt = $conn->prepare("UPDATE projects SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database error']);
}

$stmt->close();
$conn->close();
?>
