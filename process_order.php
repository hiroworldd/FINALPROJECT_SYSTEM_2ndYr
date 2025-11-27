<?php
session_start();
include 'db.php';

if(isset($_POST['place_order'])){

    $design_name = trim($_POST['design_name']);
    $customer_name = trim($_POST['customer_name']);
    $email = trim($_POST['email']);
    $contact = trim($_POST['contact']);
    $address = trim($_POST['address']);
    $payment_method = $_POST['payment_method'];
    $message = trim($_POST['message']);
    $price = floatval($_POST['price']);
    $user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;

    if(empty($customer_name) || empty($email) || empty($contact) || empty($address)) {
        $_SESSION['order_error'] = "All required fields must be filled";
        header("Location: works.php");
        exit();
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['order_error'] = "Invalid email format";
        header("Location: works.php");
        exit();
    }

    $upload_logo = null;
    if(isset($_FILES['upload_logo']) && $_FILES['upload_logo']['error'] == 0){
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; 
        
        $file_type = $_FILES['upload_logo']['type'];
        $file_size = $_FILES['upload_logo']['size'];
        
        if(in_array($file_type, $allowed_types) && $file_size <= $max_size){
            $filename = time() . '_' . uniqid() . '_' . basename($_FILES['upload_logo']['name']);
            $upload_dir = 'uploads/';
            
            if(!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $target_path = $upload_dir . $filename;
            
            if(move_uploaded_file($_FILES['upload_logo']['tmp_name'], $target_path)){
                $upload_logo = $filename;
            } else {
                $_SESSION['order_error'] = "Failed to upload file";
                header("Location: works.php");
                exit();
            }
        } else {
            $_SESSION['order_error'] = "Invalid file type or size too large (max 5MB)";
            header("Location: works.php");
            exit();
        }
    }

    try {
        $stmt = $conn->prepare("INSERT INTO orders 
            (design_name, customer_name, email, contact, address, payment_method, upload_logo, message, price, user_id, order_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        
        if($user_id) {
            $stmt->bind_param("ssssssssdi", $design_name, $customer_name, $email, $contact, $address, $payment_method, $upload_logo, $message, $price, $user_id);
        } else {
            $stmt->bind_param("ssssssssd", $design_name, $customer_name, $email, $contact, $address, $payment_method, $upload_logo, $message, $price);
        }
        
        if($stmt->execute()){
            $order_id = $stmt->insert_id;
            $_SESSION['order_success'] = true;
            $_SESSION['order_id'] = $order_id;
            $stmt->close();
            
            header("Location: receipt.php?order_id=" . $order_id);
            exit();
        } else {
            throw new Exception("Database error: " . $stmt->error);
        }
    } catch (Exception $e) {
        $_SESSION['order_error'] = "Failed to place order: " . $e->getMessage();
        header("Location: works.php");
        exit();
    }
} else {
    header("Location: works.php");
    exit();
}
?>