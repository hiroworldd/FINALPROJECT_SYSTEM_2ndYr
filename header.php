<?php
session_start();
require_once __DIR__ . '/includes/db.php';

$is_customer = (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) || 
               (isset($_SESSION['user_email']) && isset($_SESSION['role']) && $_SESSION['role'] === 'customer');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BOSSBINO</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Comic+Sans+MS&display=swap" rel="stylesheet">

<style>
.navbar-brand{display:flex;align-items:center;}
.navbar-brand img{margin-left:0;}
.navbar-brand span{font-weight:700;font-size:1.4rem;font-family:'Comic Sans MS','Comic Sans',sans-serif;}
.nav-link{font-weight:700;font-size:1.05rem;font-family:'Comic Sans MS','Comic Sans',sans-serif;margin-left:1rem;margin-right:1rem;color:#111!important;}
.nav-link:hover{color:#333!important;}
.navbar{background:#ffce00;}
.navbar-toggler{border:none;}
.navbar-light .navbar-toggler-icon{background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0,0,0,0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");}
.navbar,.navbar a,.navbar-toggler,.navbar-toggler span{font-family:'Comic Sans MS','Comic Sans',sans-serif!important;}

.sidebar{display:none;height:100%;width:0;position:fixed;top:0;right:0;background:#ffce00;overflow-x:hidden;transition:.3s;padding-top:60px;z-index:9999;}
.sidebar a{display:block;padding:1rem 2rem;text-decoration:none;font-size:1.2rem;color:#000;font-weight:600;}
.sidebar a:hover{background:#ffd633;}
.sidebar .closebtn{position:absolute;top:10px;right:20px;font-size:2rem;cursor:pointer;color:#000;}

@media(max-width:768px){
.navbar-nav{display:none!important;}
.sidebar{display:block;}
}
@media(min-width:992px){
.navbar-brand{margin-left:1.5rem;}
.navbar-brand img{margin-left:1.3rem;}
}
</style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light px-4">
  <a class="navbar-brand d-flex align-items-center" href="/index.php">
      <img src="/bino.jpg" width="55" height="55" class="me-2 rounded-circle">
      <span>BOSSBINO</span>
  </a>

  <button class="navbar-toggler" type="button" onclick="openSidebar()">
      <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="/about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="/works.php">My Works</a></li>
          <li class="nav-item"><a class="nav-link" href="/message.php">Message Me</a></li>
          <?php if($is_customer): ?>
              <li class="nav-item"><a class="nav-link" href="/customer/my_orders.php">My Orders</a></li>
              <li class="nav-item"><a class="nav-link" href="/customer/logout.php">Logout</a></li>
          <?php else: ?>
              <li class="nav-item"><a class="nav-link" href="/login.php">Login</a></li>
              <li class="nav-item"><a class="nav-link" href="/signup.php">Signup</a></li>
          <?php endif; ?>
      </ul>
  </div>
</nav>

<div id="mySidebar" class="sidebar">
  <span class="closebtn" onclick="closeSidebar()">&times;</span>
  <a href="/index.php">Home</a>
  <a href="/about.php">About</a>
  <a href="/works.php">My Works</a>
  <a href="/message.php">Message Me</a>
  <?php if($is_customer): ?>
      <a href="/customer/my_orders.php">My Orders</a>
      <a href="/customer/logout.php">Logout</a>
  <?php else: ?>
      <a href="/login.php">Login</a>
      <a href="/signup.php">Signup</a>
  <?php endif; ?>
</div>

<script>
function openSidebar(){document.getElementById("mySidebar").style.width="250px";}
function closeSidebar(){document.getElementById("mySidebar").style.width="0";}
</script>
</body>
</html>