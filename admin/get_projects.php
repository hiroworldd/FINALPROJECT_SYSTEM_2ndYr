<?php
header('Content-Type: application/json');
include('db.php');

$result = $conn->query("SELECT * FROM projects ORDER BY due_date ASC");
$projects = [];
while($row = $result->fetch_assoc()){
    $projects[] = $row;
}
echo json_encode($projects);
?>
