<?php
session_start();
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

include 'db.php';

$user_email = $_SESSION['user_email'];

// Function to format date like "november 27 2025 12:51am"
function formatOrderDate($dateString) {
    try {
        $date = new DateTime($dateString);
        $months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
        
        $month = $months[$date->format('n') - 1];
        $day = $date->format('j');
        $year = $date->format('Y');
        
        $hour = $date->format('g');
        $minute = $date->format('i');
        $ampm = $date->format('a');
        
        return $month . ' ' . $day . ' ' . $year . ' ' . $hour . ':' . $minute . $ampm;
    } catch (Exception $e) {
        return "Date not available";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders - BOSSBINO</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --footer-height: 72px; }
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; font-family: 'Poppins', sans-serif; background: #f8f9fa; color: #000; height: 100%; overflow-x: hidden; }
        body { display: flex; flex-direction: column; min-height: 100vh; }
        
        .orders-container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 20px;
            flex: 1;
        }
        
        .orders-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .order-card { 
            background: white; 
            border-radius: 15px; 
            padding: 20px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-left: 5px solid #ffce00;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        
        .order-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: flex-start;
            margin-bottom: 15px; 
            flex-wrap: wrap;
        }
        
        .order-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #000;
            margin-bottom: 10px;
            line-height: 1.3;
        }
        
        .order-status { 
            padding: 6px 15px; 
            border-radius: 20px; 
            font-weight: bold; 
            font-size: 0.8rem;
            white-space: nowrap;
        }
        
        .status-pending { background: #fff3cd; color: #856404; border: 2px solid #ffce00; }
        .status-approved { background: #d4edda; color: #155724; border: 2px solid #28a745; }
        .status-declined { background: #f8d7da; color: #721c24; border: 2px solid #dc3545; }
        
        .order-info { 
            margin-bottom: 8px; 
            font-size: 0.9rem;
        }
        
        .order-info strong { 
            color: #333; 
            font-size: 0.85rem;
        }
        
        .order-details {
            flex: 1;
        }
        
        .order-image-container {
            margin-top: 15px;
            text-align: center;
        }
        
        .order-image { 
            max-width: 100%; 
            max-height: 120px; 
            border-radius: 8px; 
            margin-top: 5px;
        }
        
        .no-orders { 
            text-align: center; 
            padding: 60px 20px; 
            color: #666;
            grid-column: 1 / -1;
        }
        
        footer { 
            height: var(--footer-height); 
            line-height: var(--footer-height); 
            text-align: center; 
            padding: 0 1rem; 
            background: #000; 
            color: #fff; 
            font-size: 1rem; 
            flex-shrink: 0; 
            width: 100%; 
        }
        
        body, footer { max-width: 100vw; }
        
        .sidebar { display: none; height: 100%; width: 0; position: fixed; top: 0; right: 0; background: #ffce00; overflow-x: hidden; transition: 0.3s; padding-top: 60px; z-index: 9999; }
        .sidebar a { display: block; padding: 1rem 2rem; text-decoration: none; font-size: 1.2rem; color: #000; font-weight: 600; }
        .sidebar a:hover { background-color: #ffd633; }
        .sidebar .closebtn { position: absolute; top: 10px; right: 20px; font-size: 2rem; cursor: pointer; color: #000; }

        @media (max-width: 768px) {
            .navbar-nav { display: none !important; }
            .sidebar { display: block; }
            
            .orders-grid {
                grid-template-columns: 1fr;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1199px) {
            .orders-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (min-width: 1200px) {
            .orders-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>
    
    <div id="mySidebar" class="sidebar">
        <span class="closebtn" onclick="closeSidebar()">&times;</span>
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="works.php">My Works</a>
        <a href="message.php">Message Me</a>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
    </div>

    <div class="orders-container">
        <h1 class="mb-4">My Orders</h1>
        
        <?php
        try {
            // Fetch orders for the logged-in customer
            $stmt = $conn->prepare("SELECT * FROM orders WHERE email = ? ORDER BY order_date DESC");
            if ($stmt) {
                $stmt->bind_param("s", $user_email);
                $stmt->execute();
                $result = $stmt->get_result();
                $orders = $result->fetch_all(MYSQLI_ASSOC);
                
                if (count($orders) > 0): 
                ?>
                <div class="orders-grid">
                <?php
                    foreach ($orders as $order): 
                        $status_class = 'status-' . htmlspecialchars($order['status']);
                        $status_text = ucfirst(htmlspecialchars($order['status']));
                ?>
                    <div class="order-card">
                        <div class="order-header">
                            <div class="order-title"><?php echo htmlspecialchars($order['design_name']); ?></div>
                            <span class="order-status <?php echo $status_class; ?>">
                                <?php echo $status_text; ?>
                            </span>
                        </div>
                        
                        <div class="order-details">
                            <div class="order-info">
                                <strong>Contact:</strong> <?php echo htmlspecialchars($order['contact']); ?>
                            </div>
                            <div class="order-info">
                                <strong>Address:</strong> <?php echo htmlspecialchars($order['address']); ?>
                            </div>
                            <div class="order-info">
                                <strong>Payment:</strong> <?php echo htmlspecialchars($order['payment_method']); ?>
                            </div>
                            <div class="order-info">
                                <strong>Price:</strong> ₱<?php echo number_format($order['price'], 2); ?>
                            </div>
                            <?php if (!empty($order['message'])): ?>
                            <div class="order-info">
                                <strong>Message:</strong> 
                                <div style="font-size: 0.8rem; margin-top: 2px;"><?php echo htmlspecialchars($order['message']); ?></div>
                            </div>
                            <?php endif; ?>
                            <div class="order-info">
                                <strong>Date:</strong> <?php echo formatOrderDate($order['order_date']); ?>
                            </div>
                        </div>
                        
                        <?php if (!empty($order['upload_logo'])): ?>
                        <div class="order-image-container">
                            <strong>Uploaded Logo:</strong><br>
                            <img src="<?php echo htmlspecialchars($order['upload_logo']); ?>" alt="Uploaded Logo" class="order-image" onerror="this.style.display='none'">
                        </div>
                        <?php endif; ?>
                    </div>
                <?php 
                    endforeach; 
                ?>
                </div>
                <?php
                else: 
                ?>
                    <div class="no-orders">
                        <h3>No orders found</h3>
                        <p class="text-muted">You haven't placed any orders yet.</p>
                        <a href="works.php" class="btn" style="background: #ffce00; color: #000; font-weight: 700; padding: 12px 25px; border-radius: 8px; text-decoration: none;">Browse Works</a>
                    </div>
                <?php 
                endif;
                $stmt->close();
            } else {
                throw new Exception("Failed to prepare statement");
            }
        } catch (Exception $e) {
            echo "<div class='alert alert-danger'>Error loading orders: " . htmlspecialchars($e->getMessage()) . "</div>";
        }
        ?>
    </div>

    <?php include '../footer.php'; ?>
    
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