<?php
session_start();

// Check if logout confirmation is needed
if (!isset($_POST['confirm_logout'])) {
    // Show confirmation page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout Confirmation - BOSSBINO</title>
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
        .card h3 { margin-bottom: 20px; font-weight: 700; color: #333; }
        .btn-group { 
            display: flex; 
            gap: 15px; 
            margin-top: 20px;
            justify-content: center;
        }
        .btn { 
            font-weight: 600; 
            border-radius: 8px; 
          
            height: 48px;
            border: none;
            font-size: 1rem;
            min-width: 180px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .btn-yes { 
            background-color: #ffce00; 
            color: #000; 
        }
        .btn-yes:hover { 
            background-color: #e6b800; 
            color: #000;
        }
        .btn-no { 
            background-color: #6c757d; 
            color: white; 
        }
        .btn-no:hover { 
            background-color: #5a6268; 
            color: white;
        }
    </style>
</head>
<body>
    <div class="card">
        <h3>Are you sure you want to logout?</h3>
        <div class="btn-group">
            <form method="post" action="">
                <input type="hidden" name="confirm_logout" value="yes">
                <button type="submit" class="btn btn-yes">Yes</button>
            </form>
            <a href="/index.php" class="btn btn-no">No</a>
        </div>
    </div>
</body>
</html>
<?php
    exit();
}

// If user confirmed logout, destroy session and redirect
if ($_POST['confirm_logout'] === 'yes') {
    // Destroy all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
    
    // Redirect to home page
    header("Location: /index.php");
    exit();
}
?>