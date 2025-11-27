<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Message - BOSSBINO</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root { --footer-height: 72px; }
* { box-sizing: border-box; }
html, body { margin: 0; padding: 0; font-family: 'Poppins', sans-serif; background: #fff; color: #000; height: 100%; overflow-x: hidden; }
body { display: flex; flex-direction: column; min-height: 100vh; }

.container { flex: 1 0 auto; display: flex; justify-content: center; align-items: center; padding: 4rem 2rem; text-align: center; max-width: 1200px; margin: 2rem auto; }

.modal-content {
    border-radius: 15px;
    padding: 2rem;
    width: 100%;
    max-width: 500px;
    background: #f8f8f8;
    text-align: center;
}

.modal-content h3 {
    font-weight: 800;
    margin-bottom: 1.5rem;
    color: #000;
}

.modal-content input, .modal-content textarea {
    width: 100%;
    margin-bottom: 1rem;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-family: 'Poppins', sans-serif;
}

.modal-content button {
    background: #ffce00;
    color: #000;
    font-weight: 700;
    padding: 10px 25px;
    border: 2px solid #ffce00;
    border-radius: 8px;
    transition: 0.3s;
}

.modal-content button:hover {
    background: #ffd633;
    border-color: #ffd633;
    color: #000;
}

footer { height: var(--footer-height); line-height: var(--footer-height); text-align: center; padding: 0 1rem; background: #000; color: #fff; font-size: 1rem; flex-shrink: 0; width: 100%; }
body, footer { max-width: 100vw; }

.sidebar { display: none; height: 100%; width: 0; position: fixed; top: 0; right: 0; background: #ffce00; overflow-x: hidden; transition: 0.3s; padding-top: 60px; z-index: 9999; }
.sidebar a { display: block; padding: 1rem 2rem; text-decoration: none; font-size: 1.2rem; color: #000; font-weight: 600; }
.sidebar a:hover { background-color: #ffd633; }
.sidebar .closebtn { position: absolute; top: 10px; right: 20px; font-size: 2rem; cursor: pointer; color: #000; }

@media (max-width: 768px) {
  .navbar-nav { display: none !important; }
  .sidebar { display: block; }
}
</style>
</head>
<body>

<?php include 'header.php'; ?>

<div id="mySidebar" class="sidebar">
  <span class="closebtn" onclick="closeSidebar()">&times;</span>
  <a href="home.php">Home</a>
  <a href="about.php">About</a>
  <a href="works.php">My Works</a>
  <a href="message.php">Message Me</a>
  <a href="login.php">Login</a>
  <a href="signup.php">Signup</a>
</div>

<div class="container">
    <div class="modal-content">
        <h3>Send a Message</h3>
        <form action="send_message.php" method="POST">
            <input type="text" name="name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit" name="send_message">Send Message</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
var sidebar = document.getElementById("mySidebar");
function openSidebar() { sidebar.style.width = "250px"; }
function closeSidebar() { sidebar.style.width = "0"; }

var toggler = document.querySelector(".navbar-toggler");
if(toggler) { toggler.addEventListener("click", function(e){ e.preventDefault(); openSidebar(); }); }
</script>

</body>
</html>
