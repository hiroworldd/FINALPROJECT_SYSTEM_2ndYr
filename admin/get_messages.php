<?php
include('db.php');

header('Content-Type: application/json');

date_default_timezone_set('Asia/Manila');

$sql = "SELECT * FROM messages ORDER BY created_at DESC";
$result = $conn->query($sql);

$messages = [];
if($result && $result->num_rows > 0){
    while($row = $result->fetch_assoc()){
       
        if ($row['created_at']) {
            $utc_date = new DateTime($row['created_at'], new DateTimeZone('UTC'));
            $utc_date->setTimezone(new DateTimeZone('Asia/Manila'));
            $row['created_at'] = $utc_date->format('Y-m-d H:i:s');
        }
        $messages[] = $row;
    }
}

echo json_encode($messages);
$conn->close();
?>