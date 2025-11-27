<?php
session_start();
include('../db.php');

if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['user_logged_in'])) {
    die("<h3 style='text-align:center;margin-top:50px;'>Access Denied</h3>");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Orders</title>
<style>
body { font-family: 'Poppins', sans-serif; background:#fdf9eb; padding:20px; }

.order-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
}

.order-card {
    background: #fff;
    border-radius: 10px;
    border-left: 8px solid #ffce00; /* yellow strip on left */
    padding: 12px;
    font-size: 13px;
    transition: 0.2s;
}
.order-card:hover {
    transform: scale(1.02);
    box-shadow: 0 2px 12px rgba(0,0,0,0.15);
}

.order-card img {
    width: 100%;
    height: 90px;
    border-radius: 5px;
    object-fit: cover;
    margin-bottom: 8px;
}

.order-card h4 { font-size: 14px; margin:0 0 4px 0; }
.order-card .meta { margin-bottom:3px; }
.order-card .price { font-weight:600; color:#333; }

@media(max-width:900px){ .order-grid{ grid-template-columns: repeat(2,1fr); } }
@media(max-width:600px){ .order-grid{ grid-template-columns: 1fr; } }

</style>
</head>
<body>

<h2 style="text-align:center;margin-bottom:20px;">Orders</h2>
<div class="order-grid" id="orderGrid"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadOrders(){
    $.getJSON('getorders.php', function(orders){
        const grid = $('#orderGrid');
        grid.empty();

        if(!orders || !orders.length){
            grid.html('<p style="text-align:center;color:#888;">No orders yet.</p>');
            return;
        }

        orders.forEach(o => {
            const card = $('<div>').addClass('order-card');

            if(o.upload_logo){
                card.append($('<img>').attr('src','../'+o.upload_logo));
            }

            card.append($('<h4>').text(o.design_name || 'My Order'));
            card.append($('<div>').addClass('meta').html('<b>Date:</b> '+ (o.order_date || 'N/A')));
            card.append($('<div>').addClass('meta').html('<b>Contact:</b> '+ (o.contact || 'N/A')));
            card.append($('<div>').addClass('meta').html('<b>Address:</b> '+ (o.address || 'N/A')));
            card.append($('<div>').addClass('price').html('<b>Price:</b> ₱'+ (o.price || '0.00')));
            card.append($('<div>').addClass('meta').html('<b>Payment:</b> '+ (o.payment_method || 'N/A')));
            card.append($('<div>').addClass('meta').html('<b>Status:</b> '+ (o.status || 'pending')));

            grid.append(card);
        });
    }).fail(()=>$('#orderGrid').html('<p style="text-align:center;color:red;">Failed to load orders.</p>'));
}

$(document).ready(function(){ loadOrders(); });
</script>

</body>
</html>
