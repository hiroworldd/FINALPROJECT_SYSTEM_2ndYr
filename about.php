<?php
session_start();
include 'db.php';

?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>About - BOSSBINO</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root { --footer-height: 72px; }
* { box-sizing: border-box; }
html, body { margin: 0; padding: 0; font-family: 'Poppins', sans-serif; background: #fff; color: #000; height: 100%; overflow-x: hidden; }
body { display: flex; flex-direction: column; min-height: 100vh; }
.container { flex: 1 0 auto; padding: 4rem 2rem; text-align: center; max-width: 1200px; margin: 2rem auto; border-radius: 10px; background: #fff; }
.container h1 { font-size: clamp(1.8rem, 5vw, 3.4rem); font-weight: 800; margin-bottom: 2rem; color: #000; }

.card { border-radius:10px; background:#f8f8f8; padding:2rem; text-align:center; height:100%; }
.card h5 { font-weight:700; margin-bottom:1rem; }
.card p { font-size:1rem; line-height:1.5; }

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
    <h1>About BOSSBINO</h1>

    <div class="row g-4">
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <h5>BACKGROUND</h5>
                <p>BOSSBINO is my artist name, and my real name is Noveneil Molinas, I am 20 years old, and currently living a simple life in Barangay Kinuskusan, Bansalan. </p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <h5>INSPIRATION</h5>
                <p>Inspired by modern art and digital trends, BOSSBINO aims to bring fresh, creative ideas to every project, turning concepts into visually striking designs.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <h5>INFORMATION</h5>
                <p>We provide services including logo creation, t-shirt layouts, stickers, and other custom graphic projects for businesses, events, and personal branding.</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card">
                <h5>GOAL</h5>
                <p>Our goal is to deliver high-quality, budget-friendly designs that meet client expectations while showcasing creativity and professional craftsmanship.</p>
            </div>
        </div>
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
