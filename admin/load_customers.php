<?php
header('Content-Type: application/json');
include('db.php');

$sql = "SELECT id, seq, name, email, phone, notes FROM customers ORDER BY seq ASC";
$result = $mysqli->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => 'Could not load customers: ' . $mysqli->error]);
    exit;
}

$customers = [];
while ($row = $result->fetch_assoc()) {
    $customers[] = $row;
}

echo json_encode($customers);
?>