<?php
session_start();
include('../db.php');

header('Content-Type: application/json; charset=utf-8');

date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['user_logged_in'])) {
    echo json_encode([]);
    exit();
}

$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);

$orders = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        
        if (!empty($row['order_date'])) {
            try {
                
                $dt = new DateTime($row['order_date'], new DateTimeZone('UTC'));
                $dt->setTimezone(new DateTimeZone('Asia/Manila'));
                $row['order_date'] = $dt->format('Y-m-d H:i:s');
            } catch (Exception $e) {
                
                try {
                    $dt2 = new DateTime($row['order_date']);
                    $dt2->setTimezone(new DateTimeZone('Asia/Manila'));
                    $row['order_date'] = $dt2->format('Y-m-d H:i:s');
                } catch (Exception $e2) {
                   
                }
            }
        } else {
            $row['order_date'] = null;
        }

     
        $dn = isset($row['design_name']) ? trim($row['design_name']) : null;
        if ($dn === '') $dn = null;
        if ($dn !== null) {
            $dn_l = strtolower($dn);
            if (in_array($dn_l, ['null', 'undefined', 'my order', '—'])) {
                $dn = null;
            }
        }
        $row['design_name'] = $dn;

     
        $row['contact'] = (!empty($row['contact']) && strtolower(trim($row['contact'])) !== 'null') ? $row['contact'] : null;
        $row['address'] = (!empty($row['address']) && strtolower(trim($row['address'])) !== 'null') ? $row['address'] : null;
        $row['price'] = (isset($row['price']) && $row['price'] !== '') ? $row['price'] : '0.00';
        $row['payment_method'] = (!empty($row['payment_method']) && strtolower(trim($row['payment_method'])) !== 'null') ? $row['payment_method'] : null;
        $row['message'] = (!empty($row['message']) && strtolower(trim($row['message'])) !== 'null') ? $row['message'] : null;
        $row['upload_logo'] = (!empty($row['upload_logo']) && !in_array(strtolower(trim($row['upload_logo'])), ['null','undefined'])) ? $row['upload_logo'] : null;
        $row['status'] = isset($row['status']) ? $row['status'] : 'pending';

        $orders[] = $row;
    }
}


echo json_encode($orders, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
