<?php
session_start();
include('../db.php');

header('Content-Type: application/json');

date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$query = "
    SELECT 
        customer_name,
        email,
        contact,
        COUNT(*) as order_count,
        MAX(order_date) as last_order_date
    FROM orders 
    WHERE customer_name IS NOT NULL 
      AND customer_name != '' 
      AND email IS NOT NULL
    GROUP BY email, customer_name, contact
    ORDER BY last_order_date DESC
";

$result = $conn->query($query);
$customers = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
       
        if ($row['last_order_date']) {
            $utc_date = new DateTime($row['last_order_date'], new DateTimeZone('UTC'));
            $utc_date->setTimezone(new DateTimeZone('Asia/Manila'));
            $row['last_order_date'] = $utc_date->format('Y-m-d H:i:s');
        }
        
        $row['customer_name'] = $row['customer_name'] ?: 'Unknown Customer';
        $row['email'] = $row['email'] ?: 'No email provided';
        $row['contact'] = $row['contact'] ?: 'No contact provided';
        $row['order_count'] = $row['order_count'] ?: 0;
        $row['last_order_date'] = $row['last_order_date'] ?: date('Y-m-d H:i:s');
        
        $customers[] = $row;
    }
}


echo json_encode($customers);
?>