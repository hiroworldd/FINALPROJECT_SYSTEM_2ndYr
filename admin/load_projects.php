<?php
header('Content-Type: application/json');
include('db.php');

$sql = "SELECT id, seq, title, description, due_date, completed, status FROM projects ORDER BY seq ASC";
$result = $mysqli->query($sql);

if (!$result) {
    http_response_code(500);
    echo json_encode(['error' => true, 'message' => 'Could not load projects: ' . $mysqli->error]);
    exit;
}

$projects = [];
while ($row = $result->fetch_assoc()) {
    $projects[] = $row;
}

echo json_encode($projects);
?>