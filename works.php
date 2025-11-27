<?php
session_start();
include 'db.php';

if(isset($_POST['place_order'])){
    $design_name = $_POST['design_name'];
    $price = $_POST['price'];
    $customer_name = $_POST['customer_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];
    $message = $_POST['message'] ?? null;

    $upload_logo = null;
    if(isset($_FILES['upload_logo']) && $_FILES['upload_logo']['error'] === UPLOAD_ERR_OK){
        $tmp_name = $_FILES['upload_logo']['tmp_name'];
        $filename = time() . '_' . basename($_FILES['upload_logo']['name']);
        $destination = 'uploads/' . $filename;
        if(!is_dir('uploads')) mkdir('uploads');
        move_uploaded_file($tmp_name, $destination);
        $upload_logo = $destination;
    }

    $stmt = $conn->prepare("INSERT INTO orders (design_name, price, customer_name, email, contact, address, payment_method, upload_logo, message) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sdsssssss", $design_name, $price, $customer_name, $email, $contact, $address, $payment_method, $upload_logo, $message);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Order placed successfully!'); window.location='works.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Works - BOSSBINO</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { margin:0; font-family:'Poppins',sans-serif; background:#fff; color:#000; }
.container-box{ padding:4rem 2rem; max-width:1200px; margin:2rem auto; text-align:center; }
.container-box h1{ font-size:clamp(1.8rem,5vw,3.4rem); font-weight:800; margin-bottom:2rem; }
.section-title{ font-size:1.8rem; font-weight:700; margin-bottom:1rem; }
.card-box{ border-radius:10px; background:#fff; padding:1rem; height:100%; box-shadow:0 4px 10px rgba(0,0,0,0.1); transition: transform 0.3s; color:#000; }
.card-box:hover{ transform: translateY(-5px); }
.card-box img{ width:100%; height:200px; object-fit:contain; border-radius:10px; margin-bottom:1rem; }
.card-price{ font-weight:700; font-size:1.1rem; margin-bottom:0.25rem; color:#000; }
.card-subtitle{ font-size:0.9rem; color:#555; }
.order-btn{ background:#ffce00 !important; color:#000 !important; font-weight:700; padding:10px 20px; border:2px solid #ffce00 !important; border-radius:8px; margin-top:0.5rem; transition: all 0.3s; display:inline-block; text-decoration:none; text-align:center; }
.order-btn:hover{ background:#ffd633 !important; border-color:#ffd633 !important; color:#000 !important; }
.more-btn, .back-btn{ background: #ffce00 !important; border: 2px solid #ffce00 !important; color: #000 !important; font-weight: 700 !important; padding: 12px 25px; border-radius: 8px; font-size: 1.1rem; margin-top: 2rem; text-decoration: none; }
.more-btn:hover, .back-btn:hover{ background: #ffd633 !important; border-color: #ffd633 !important; color: #000 !important; }
footer{ background:#000; color:#fff; text-align:center; padding:20px 0; margin-top:3rem; width:100%; }
.sidebar{ display:none; height:100%; width:0; position:fixed; top:0; right:0; background:#ffce00; overflow-x:hidden; transition:.3s; padding-top:60px; z-index:9999; }
.sidebar a{ display:block; padding:1rem 2rem; text-decoration:none; font-size:1.2rem; color:#000; font-weight:600; }
.sidebar a:hover{ background:#ffd633; }
.sidebar .closebtn{ position:absolute; top:10px; right:20px; font-size:2rem; cursor:pointer; color:#000; }
@media(max-width:768px){ .navbar-nav{display:none!important;} .sidebar{display:block;} }
.modal-content { border-radius: 15px; background: #fff; color: #000; padding: 2rem; box-shadow: 0 8px 20px rgba(0,0,0,0.2); }
.modal-header, .modal-footer { border:none; background:#fff; }
.modal-title { font-weight: 800; text-align: center; width: 100%; color: #000; }
.modal-body input, .modal-body textarea, .modal-body select{ background:#fff; color:#000; border:1px solid #ccc; }
.modal-body input::placeholder, .modal-body textarea::placeholder{ color:#888; }
.modal-footer .btn-secondary{ background:#fff !important; color:#000 !important; font-weight:700; }
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

<div class="container-box">
    <h1>My Works</h1>

    <div class="section-title">LOGO DESIGNS</div>
    <div class="row g-4 mb-5">
        <?php
        $logos = ['logo1','logo2','logo3','logo4'];
        foreach($logos as $logo):
        ?>
        <div class="col-md-6 col-lg-3">
            <div class="card-box">
                <img src="images/<?= $logo ?>.jpg" alt="<?= ucfirst($logo) ?>">
                <div class="card-price">₱2500</div>
                <div class="card-subtitle">per design</div>

                <?php
                if (isset($_SESSION['user_logged_in']) || isset($_SESSION['admin_logged_in'])):
                ?>
                    <button class="btn order-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#orderModal"
                        data-design="<?= htmlspecialchars(ucfirst($logo)) ?>"
                        data-price="2500">
                        Checkout
                    </button>
                <?php else: ?>
                    <a href="login.php" class="btn order-btn">
                        Login to Checkout
                    </a>
                <?php endif; ?>

            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="section-title">JERSEY DESIGNS</div>
    <div class="row g-4 mb-5">
        <?php
        $jerseys = ['jersey1','jersey2','jersey3','jersey4'];
        foreach($jerseys as $jersey):
        ?>
        <div class="col-md-6 col-lg-3">
            <div class="card-box">
                <img src="images/<?= $jersey ?>.jpg" alt="<?= ucfirst($jersey) ?>">
                <div class="card-price">₱900</div>
                <div class="card-subtitle">per design</div>

                <?php
                if (isset($_SESSION['user_logged_in']) || isset($_SESSION['admin_logged_in'])):
                ?>
                    <button class="btn order-btn"
                        data-bs-toggle="modal"
                        data-bs-target="#orderModal"
                        data-design="<?= htmlspecialchars(ucfirst($jersey)) ?>"
                        data-price="900">
                        Checkout
                    </button>
                <?php else: ?>
                    <a href="login.php" class="btn order-btn">
                        Login to Checkout
                    </a>
                <?php endif; ?>

            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <a href="works-more.php" class="more-btn">More Designs</a>
</div>


<div class="modal fade" id="orderModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" enctype="multipart/form-data">
        <div class="modal-header border-0">
          <h5 class="modal-title">Place Your Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="design_name" id="designName">
            <input type="hidden" name="price" id="designPrice">

            <div class="mb-3"><label>Customer Name</label><input type="text" class="form-control" name="customer_name" placeholder="Your name" required></div>
            <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control" name="email"
                   value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>"
                   placeholder="Your email" required>
           </div>
            <div class="mb-3"><label>Contact Number</label><input type="text" class="form-control" name="contact" placeholder="Your contact" required></div>
            <div class="mb-3"><label>Address</label><textarea class="form-control" name="address" placeholder="Your address" required></textarea></div>
            <div class="mb-3"><label>Payment Method</label>
                <select class="form-select" name="payment_method" required>
                    <option value="Gcash">Gcash</option>
                    <option value="Paymaya">Paymaya</option>
                    <option value="COD">Cash on Delivery</option>
                </select>
            </div>
            <div class="mb-3"><label>Upload Your Logo (optional)</label><input type="file" class="form-control" name="upload_logo"></div>
            <div class="mb-3"><label>Message / Notes (optional)</label><textarea class="form-control" name="message" placeholder="Any additional instructions..."></textarea></div>
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
          <button type="submit" name="place_order" class="btn order-btn">Place Order</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
var sidebar=document.getElementById("mySidebar");
function openSidebar(){sidebar.style.width="250px";}
function closeSidebar(){sidebar.style.width="0";}


(function(){
    
    var orderButtons = document.querySelectorAll('.order-btn[data-design]');
    orderButtons.forEach(btn => {
        btn.addEventListener('click', function(){
           
            var design = this.dataset.design || '';
            var price = this.dataset.price || '';
            var nameInput = document.getElementById('designName');
            var priceInput = document.getElementById('designPrice');
            if(nameInput) nameInput.value = design;
            if(priceInput) priceInput.value = price;
        });
    });
})();
</script>

</body>
</html>