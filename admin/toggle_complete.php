<?php
session_start();
include('db.php');
header('Content-Type: application/json');

if (!isset($_POST['id']) || !isset($_POST['completed'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
    exit;
}

$id = intval($_POST['id']);
$completed = intval($_POST['completed']); // 0 or 1

$stmt = $conn->prepare("UPDATE projects SET completed = ? WHERE id = ?");
$stmt->bind_param("ii", $completed, $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Database error']);
}

$stmt->close();
$conn->close();
?>
