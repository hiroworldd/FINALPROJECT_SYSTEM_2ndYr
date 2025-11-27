<?php
session_start();
include 'db.php';
$is_customer = isset($_SESSION['user_email']) && isset($_SESSION['role']) && $_SESSION['role'] === 'customer';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BOSSBINO</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<style>
:root { --footer-height: 72px; }
* { box-sizing: border-box; }
html, body { margin: 0; padding: 0; font-family: 'Poppins', sans-serif; background: #111; color: #fff; height: 100%; overflow-x: hidden; }
body { display: flex; flex-direction: column; min-height: 100vh; }
.hero { position: relative; flex: 1 0 auto; width: 100%; display: flex; align-items: center; justify-content: center; text-align: center; overflow: hidden; min-height: 70vh; }
.hero img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 0; filter: blur(4px); transform: scale(1.05); }
.hero::before { content: ""; position: absolute; inset: 0; background: rgba(0,0,0,0.55); z-index: 1; }
.hero-content { position: relative; z-index: 2; max-width: 1000px; padding: 0 1.5rem; }
.hero-title { font-size: clamp(1.8rem, 5vw, 3.4rem); font-weight: 800; margin-bottom: .5rem; color: #fff; }
.hero-subtext { font-size: clamp(1rem, 2.2vw, 1.2rem); max-width: 860px; margin: 0 auto; line-height: 1.5; color: #fff; }
footer { height: var(--footer-height); line-height: var(--footer-height); text-align: center; padding: 0 1rem; background: #000; color: #fff; font-size: 1rem; flex-shrink: 0; width: 100%; }
body, .hero, footer { max-width: 100vw; }

.sidebar { display: none; height: 100%; width: 0; position: fixed; top: 0; right: 0; background: #ffce00; overflow-x: hidden; transition: 0.3s; padding-top: 60px; z-index: 9999; }
.sidebar a { display: block; padding: 1rem 2rem; text-decoration: none; font-size: 1.2rem; color: #000; font-weight: 600; }
.sidebar a:hover { background-color: #ffd633; }
.sidebar .closebtn { position: absolute; top: 10px; right: 20px; font-size: 2rem; cursor: pointer; color: #000; }

@media (max-width: 768px) {
  .navbar-nav { display: none !important; }
  .sidebar { display: block; }
}
@media (max-width: 480px) {
  .hero { min-height: 45vh; }
  .hero-title { font-size: 1.8rem; }
  .hero-subtext { font-size: .9rem; }
}
</style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="hero">
    <img src="bg.jpg" alt="Hero Image">
    <div class="hero-content">
        <h1 class="hero-title">ARE YOU LOOKING FOR A BUDGET FRIENDLY DESIGN?</h1>
        <p class="hero-subtext">Come and explore my artwork and browse some of my previous projects, offering affordable rates with high-quality craftsmanship.</p>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>

var toggler = document.querySelector(".navbar-toggler");
if(toggler) { 
    toggler.addEventListener("click", function(e){ 
        e.preventDefault(); 
        
        if(typeof openSidebar === 'function') {
            openSidebar();
        }
    }); 
}
</script>
</body>
</html>