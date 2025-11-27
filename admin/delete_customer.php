<?php
session_start();
include('db.php');
header('Content-Type: application/json');

if (!isset($_POST['id'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid parameters']);
    exit;
}

$id = intval($_POST['id']);


$stmt = $conn->prepare("DELETE FROM projects WHERE customer_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();


$stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
$stmt->bind_param("i", $id);
$success = $stmt->execute();
$stmt->close();

echo json_encode(['success' => $success]);
$conn->close();
?>
