<?php
session_start();
include 'db.php';

if(isset($_GET['order_id'])) {
    $order_id = intval($_GET['order_id']);
    
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id=?");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    
    if(!$order){
        die("Order not found");
    }
    
    $design_name = $order['design_name'];
    $customer_name = $order['customer_name'];
    $email = $order['email'];
    $contact = $order['contact'];
    $address = $order['address'];
    $payment_method = $order['payment_method'];
    $price = $order['price'];
    $upload_logo = $order['upload_logo'];
    $message = $order['message'];
    $order_date = $order['order_date'];
} else {
    header("Location: works.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Receipt - BOSSBINO</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { font-family:'Poppins',sans-serif; background:#f8f9fa; padding:2rem; }
.card { max-width:600px; margin:2rem auto; padding:2rem; border-radius:10px; box-shadow:0 5px 20px rgba(0,0,0,0.1); background:#fff; }
.card h3 { text-align:center; margin-bottom:1.5rem; font-weight:800; }
.card img { max-width:100%; margin-bottom:1rem; border-radius:8px; }
.card p { margin-bottom:0.5rem; }
.btn-home { display:block; margin:1.5rem auto 0 auto; text-align:center; font-weight:700; }
.receipt-header { text-align: center; border-bottom: 2px solid #ffce00; padding-bottom: 1rem; margin-bottom: 1.5rem; }
</style>
</head>
<body>
<div class="card">
    <div class="receipt-header">
        <h3>Order Receipt</h3>
        <p class="text-muted">Thank you for your order!</p>
    </div>
    
    <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
    <p><strong>Order Date:</strong> <?php echo date('F j, Y g:i A', strtotime($order_date)); ?></p>
    <p><strong>Design:</strong> <?php echo htmlspecialchars($design_name); ?></p>
    <p><strong>Customer:</strong> <?php echo htmlspecialchars($customer_name); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Contact:</strong> <?php echo htmlspecialchars($contact); ?></p>
    <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
    <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($payment_method); ?></p>
    <p><strong>Price:</strong> ₱<?php echo number_format($price, 2); ?></p>

    <?php if($upload_logo): ?>
        <p><strong>Uploaded Logo:</strong></p>
        <img src="uploads/<?php echo htmlspecialchars($upload_logo); ?>" alt="Uploaded Logo">
    <?php endif; ?>

    <?php if($message): ?>
        <p><strong>Message / Notes:</strong> <?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="works.php" class="btn btn-warning btn-home">Back to Works</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="customer/orders.php" class="btn btn-outline-secondary">My Orders</a>
        <?php endif; ?>
    </div>
</div>
</body>
</html>