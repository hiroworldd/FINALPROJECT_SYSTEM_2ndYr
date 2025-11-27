<?php
session_start();
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT * FROM tb_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        
        if (password_verify($password, $user['password'])) {
           
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role']; 

        
            if ($user['role'] === 'admin') {
                header("Location: home.php"); 
            } else {
                header("Location: customer/index.php"); 
            }
            exit();
        } else {
            $_SESSION['error'] = "Password does not match!";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Email not found!";
        header("Location: login.php");
        exit();
    }
} else {
    
    header("Location: login.php");
    exit();
}
?>
