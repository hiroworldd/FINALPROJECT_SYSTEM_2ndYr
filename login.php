<?php
session_start();
include 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    
    $admin_email = "admin@gmail.com";  
    $admin_pass  = "admin123";        

 
    if ($email === $admin_email && $password === $admin_pass) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['user_id'] = 0;
        $_SESSION['name'] = 'Admin';
        $_SESSION['user_email'] = $admin_email;
        $_SESSION['role'] = 'admin';
        header("Location: admin/index.php");
        exit();
    }


    try {
        $table_check = $conn->query("SHOW TABLES LIKE 'tb_users'");
        if ($table_check->num_rows == 0) {
            throw new Exception("Users table doesn't exist. Please contact admin.");
        }

        $stmt = $conn->prepare("SELECT id, name, email, password FROM tb_users WHERE email = ?");
        if (!$stmt) throw new Exception("Database error: " . $conn->error);

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['user_email'] = $row['email'];
                $_SESSION['role'] = 'customer';

             
                header("Location: customer/my_orders.php");
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            $error = "Email not found! Please sign up first.";
        }

        $stmt->close();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - BOSSBINO</title>
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
    margin: 0;
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
.btn-primary, .btn-secondary {
    width: 100%;
    font-weight: 600;
    border-radius: 8px;
    padding: 10px 0.6rem;
    margin-top: 10px;
}
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
    <h2>Login</h2>
    <?php if(!empty($error)) echo "<p class='error-msg'>".htmlspecialchars($error)."</p>"; ?>
    <form method="post" action="">
        <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
        <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
        <button type="submit" class="btn btn-primary">Login</button>
        <a href="index.php" class="btn btn-secondary mt-2">Go Back</a>
    </form>
    <p class="mt-3 text-muted">Don't have an account? <a href="signup.php">Sign Up</a></p>
</div>
</body>
</html>
