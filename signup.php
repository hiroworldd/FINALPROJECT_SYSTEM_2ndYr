<?php
session_start();
require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    
    $check = $conn->prepare("SELECT id FROM tb_users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $error = "Email already exists. Please login.";
    } else {
        $stmt = $conn->prepare("INSERT INTO tb_users (name,email,phone,password) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $hashedPassword);

        if ($stmt->execute()) {
            
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['name'] = $name;
            $_SESSION['user_email'] = $email;

        
            header("Location: customer/index.php");
            exit();
        } else {
            $error = "Signup failed: " . $stmt->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up - BOSSBINO</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
body {
    background-color: #ffce00;
    font-family: 'Poppins', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.card {
    background-color: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 400px;
    text-align: center;
}
.card h2 { margin-bottom: 20px; font-weight: 700; color: #333; }
.form-control { border-radius: 8px; padding: 10px 15px; }
.btn-primary, .btn-secondary { width: 100%; font-weight: 600; border-radius: 8px; padding: 10px 0.6rem; margin-top: 10px; }
.btn-primary { background-color: #ffce00; color: #000; border: none; }
.btn-primary:hover { background-color: #ffd633; }
.btn-secondary { background-color: #333; color: #fff; border: none; }
.btn-secondary:hover { background-color: #555; }
.text-muted { font-size: 0.85rem; }
a { text-decoration: none; font-weight: 600; color: #333; }
a:hover { color: #000; }
.error-msg { color: #e63946; margin-bottom: 10px; font-weight: 600; }
</style>
</head>
<body>
<div class="card">
    <h2>Create Account</h2>
    <?php if(isset($error)) echo "<p class='error-msg'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="name" class="form-control mb-3" placeholder="Full Name" required>
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="text" name="phone" class="form-control mb-3" placeholder="Phone">
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        
        
        <a type="submit" href="login.php" class="btn btn-primary">Sign Up</a>
        <a href="home.php" class="btn btn-secondary mt-2">Go Back</a>
    </form>
    <p class="mt-3 text-muted">Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>
