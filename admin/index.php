<?php session_start(); include('db.php'); if (!isset($_SESSION['user_id'])) { $_SESSION['user_id'] = 1; $_SESSION['name'] = 'Admin'; } date_default_timezone_set('Asia/Manila'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #fffbea;
            color: #333;
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background-color: #ffce00;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
            padding: 18px 24px;
        }
        .navbar-brand {
            color: #000 !important;
            font-weight: 700;
            display:flex;
            align-items:center;
            gap:16px;
        }
        .navbar-brand img {
            width:88px;
            height:88px;
            object-fit:cover;
            border-radius:50%;
        }
        .top-nav-rect {
            background: #ffce00;
            border-radius: 12px;
            padding: 6px 10px;
            display:flex;
            gap:6px;
            align-items:center;
        }
        .nav-pills .nav-link {
            color: #000;
            background: transparent;
            border-radius: 8px;
            font-weight: 600;
            padding: 8px 12px;
        }
        .nav-pills .nav-link:hover {
            color: #000;
            background: rgba(0,0,0,0.04);
        }
        .nav-pills .nav-link.active {
            background: #ffd633;
            color: #000;
            box-shadow: inset 0 -2px 0 rgba(0,0,0,0.06);
        }
        
        /* Updated card styles */
        #orders-list .card, #messages-list .card, #customers-list .card {
            margin-bottom: 15px;
            background-color: #fff; /* Changed to white */
            color: #000;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transition: 0.3s;
            height: 100%; 
        }
        #orders-list .card:hover, #messages-list .card:hover, #customers-list .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.12);
        }
        #orders-list .card img {
            border-radius: 8px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            transition: 0.3s;
        }
        .card:hover {
            transform: translateY(-3px);
        }
        .btn-primary {
            background-color: #ffce00;
            border: none;
            color: #000;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #ffd633;
        }
        .btn-success {
            background-color: #28a745;
            border: none;
            color: #fff;
        }
        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #000;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
            color: #fff;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 0.875rem;
        }
        .order-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.8rem;
            display: inline-block;
            margin-bottom: 10px;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 2px solid #ffce00;
        }
        .status-approved {
            background: #d4edda;
            color: #155724;
            border: 2px solid #28a745;
        }
        .status-declined {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #dc3545;
        }
        .customer-stats {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        footer {
            text-align: center;
            padding: 20px;
            color: #666;
            margin-top: 50px;
        }
        #logoutModal .modal-content {
            background-color: #000;
            color: #ffce00;
            border-radius: 12px;
        }
        #logoutModal .modal-header, #logoutModal .modal-footer {
            border:none;
        }
        #logoutModal .btn-yes {
            background-color: #ffce00;
            color:#000;
            font-weight:600;
        }
        #logoutModal .btn-yes:hover {
            background-color: #ffd633;
        }
        #logoutModal .btn-no {
            background-color: #333;
            color:#fff;
        }
        #logoutModal .btn-no:hover {
            background-color: #555;
        }
        
        /* Custom logout button styling */
        .logout-btn {
            background-color: #ffce00;
            color: #000;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            padding: 8px 16px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-left: 10px;
        }
        .logout-btn:hover {
            background-color: #e6b800;
            color: #000;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        
        @media (max-width: 767px) {
            .top-nav-rect {
                display: none;
            }
            .navbar {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a class="navbar-brand" href="#">
                <img src="bino.jpg" alt="logo">
                <span>Project Manager</span>
            </a>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="top-nav-rect">
                <ul class="nav nav-pills" id="topTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="messages-tab" data-bs-toggle="pill" data-bs-target="#messages" type="button" role="tab">MESSAGES</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="customers-tab" data-bs-toggle="pill" data-bs-target="#customers" type="button" role="tab">CUSTOMERS</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="orders-tab" data-bs-toggle="pill" data-bs-target="#orders" type="button" role="tab">ORDERS</button>
                    </li>
                </ul>
                <!-- Logout button positioned beside the Orders tab -->
                <button class="logout-btn" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</button>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="tab-content">
            <div class="tab-pane fade" id="messages" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Messages</h4>
                    <button class="btn btn-primary" onclick="loadMessages()">Refresh</button>
                </div>
                <div id="messages-list" class="row g-3"></div>
            </div>
            
            <div class="tab-pane fade" id="customers" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Customers</h4>
                    <button class="btn btn-primary" onclick="loadCustomers()">Refresh</button>
                </div>
                <div id="customers-list" class="row g-3"></div>
            </div>
            
            <div class="tab-pane fade show active" id="orders" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Orders Management</h4>
                    <button class="btn btn-primary" onclick="loadOrders()">Refresh Orders</button>
                </div>
                <div id="orders-list" class="row g-3"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-header border-0 justify-content-center">
                    <h5 class="modal-title">Do you want to logout?</h5>
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="../public/logout.php" class="btn btn-yes me-2">Yes</a>
                    <button type="button" class="btn btn-no" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>

    <footer>© <?php echo date('Y'); ?> Hiro, All rights reserved.</footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function formatDate(dateString) {
            if (!dateString) return 'No date available';
            try {
                let date;
                if (dateString.includes('T')) {
                    date = new Date(dateString);
                } else if (dateString.includes(' ')) {
                    const [datePart, timePart] = dateString.split(' ');
                    const [year, month, day] = datePart.split('-');
                    const [hours, minutes, seconds] = timePart.split(':');
                    date = new Date(year, month - 1, day, hours, minutes, seconds);
                } else {
                    date = new Date(dateString);
                }
                if (isNaN(date.getTime())) {
                    console.log('Invalid date:', dateString);
                    return 'Invalid date';
                }
                const months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                const month = months[date.getMonth()];
                const day = date.getDate();
                const year = date.getFullYear();
                let hours = date.getHours();
                let minutes = date.getMinutes();
                const ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                return `${month} ${day} ${year} ${hours}:${minutes}${ampm}`;
            } catch (error) {
                console.log('Date formatting error:', error, 'for date:', dateString);
                return 'Invalid date';
            }
        }

        function loadOrders(){
            $.getJSON('get_orders.php', function(orders){
                console.log('get_orders.php returned:', orders);
                $('#orders-list').empty();
                if(!orders || !orders.length){
                    $('#orders-list').append('<p class="text-center text-muted">No orders yet.</p>');
                    return;
                }
                orders.forEach(order => {
                    const col = $('<div>').addClass('col-md-6 col-lg-4'); 
                    const card = $('<div>').addClass('card p-3');
                    const statusKey = (order.status || '').toString().toLowerCase();
                    const statusClass = 'status-' + statusKey;
                    const statusText = statusKey ? (statusKey.charAt(0).toUpperCase() + statusKey.slice(1)) : 'Unknown';
                    card.append($('<div>').addClass('order-status ' + statusClass).text(statusText));
                    
                    let dname = order.design_name;
                    if (typeof dname === 'string') dname = dname.trim();
                    const invalidNames = ['', null, undefined, 'null', 'undefined', 'My Order', 'my order'];
                    const hasValidName = (dname && !invalidNames.includes(dname));
                    if (hasValidName) {
                        card.append($('<h5>').text(dname));
                    }
                    
                    card.append(
                        $('<p>').html('<strong>Contact:</strong> ' + (order.contact || '—')),
                        $('<p>').html('<strong>Address:</strong> ' + (order.address || '—')),
                        $('<p>').html('<strong>Price:</strong> ₱' + (order.price || '0.00')),
                        $('<p>').html('<strong>Payment:</strong> ' + (order.payment_method || '—')),
                        $('<p>').html('<strong>Message:</strong> ' + (order.message || '—')),
                        $('<p>').html('<strong>Date:</strong> ' + formatDate(order.order_date))
                    );
                    
                    if(order.upload_logo && order.upload_logo !== 'undefined' && order.upload_logo !== 'null'){
                        card.append(
                            $('<p>').html('<strong>Uploaded Logo:</strong>'),
                            $('<img>').attr('src','../' + order.upload_logo).css({width:'100px',height:'100px',objectFit:'cover',marginTop:'10px',borderRadius:'8px'})
                        );
                    }
                    
                    const actionDiv = $('<div>').addClass('mt-3').css({'display':'flex','gap':'5px','flexWrap':'wrap'});
                    if (statusKey === 'pending') {
                        actionDiv.append(
                            $('<button>').addClass('btn btn-success btn-sm').text('Approve')
                                .click(function() {
                                    updateOrderStatus(order.id, 'approved');
                                }),
                            $('<button>').addClass('btn btn-warning btn-sm').text('Decline')
                                .click(function() {
                                    updateOrderStatus(order.id, 'declined');
                                })
                        );
                    }
                    actionDiv.append(
                        $('<button>').addClass('btn btn-danger btn-sm').text('Delete')
                            .click(function() {
                                deleteOrder(order.id);
                            })
                    );
                    card.append(actionDiv);
                    col.append(card);
                    $('#orders-list').append(col);
                });
            }).fail(()=>{
                $('#orders-list').html('<p class="text-danger">Could not load orders.</p>');
            });
        }

        function loadCustomers(){
            $.getJSON('get_customers.php', function(customers){
                $('#customers-list').empty();
                if(!customers || !customers.length){
                    $('#customers-list').append('<p class="text-center text-muted">No customers yet.</p>');
                } else {
                    // Removed customer statistics section
                    customers.forEach(customer => {
                        const col = $('<div>').addClass('col-md-6 col-lg-4'); 
                        const card = $('<div>').addClass('card p-3');
                        const customerName = customer.customer_name || 'Unknown Customer';
                        const email = customer.email || 'No email provided';
                        const contact = customer.contact || 'No contact provided';
                        const orderCount = customer.order_count || 0;
                        const lastOrderDate = customer.last_order_date ? formatDate(customer.last_order_date) : 'No orders yet';
                        
                        card.append(
                            $('<h5>').text(customerName),
                            $('<p>').html('<strong>Email:</strong> ' + email),
                            $('<p>').html('<strong>Contact:</strong> ' + contact),
                            $('<p>').html('<strong>Total Orders:</strong> ' + orderCount),
                            $('<p>').html('<strong>Last Order:</strong> ' + lastOrderDate)
                        );
                        
                        col.append(card);
                        $('#customers-list').append(col);
                    });
                }
            }).fail(()=>$('#customers-list').html('<p class="text-danger">Could not load customers.</p>'));
        }

        function updateOrderStatus(orderId, status) {
            if (confirm('Are you sure you want to ' + status + ' this order?')) {
                $.post('update_order_status.php', { order_id: orderId, status: status }, function(response) {
                    if (response.success) {
                        alert('Order status updated successfully!');
                        loadOrders();
                    } else {
                        alert('Error updating order status: ' + response.error);
                    }
                }).fail(function() {
                    alert('Error updating order status.');
                });
            }
        }

        function deleteOrder(orderId) {
            if (confirm('Are you sure you want to delete this order? This action cannot be undone.')) {
                $.post('delete_order.php', { order_id: orderId }, function(response) {
                    if (response.success) {
                        alert('Order deleted successfully!');
                        loadOrders();
                    } else {
                        alert('Error deleting order: ' + response.error);
                    }
                }).fail(function() {
                    alert('Error deleting order.');
                });
            }
        }

        function loadMessages(){
            $.getJSON('get_messages.php', function(messages){
                $('#messages-list').empty();
                if(!messages || !messages.length){
                    $('#messages-list').append('<p class="text-center text-muted">No messages yet.</p>');
                } else {
                    messages.forEach(msg => {
                        const col = $('<div>').addClass('col-md-6 col-lg-4'); 
                        const card = $('<div>').addClass('card p-3');
                        card.append(
                            $('<h5>').text('Message #' + msg.id),
                            $('<p>').html('<strong>Name:</strong> ' + msg.name),
                            $('<p>').html('<strong>Email:</strong> ' + msg.email),
                            $('<p>').html('<strong>Message:</strong> ' + msg.message),
                            $('<p>').html('<strong>Date:</strong> ' + formatDate(msg.created_at))
                        );
                        col.append(card);
                        $('#messages-list').append(col);
                    });
                }
            }).fail(()=>$('#messages-list').html('<p class="text-danger">Could not load messages.</p>'));
        }

        $(document).ready(function() {
            loadOrders();
        });

        $('#orders-tab').on('shown.bs.tab', function () {
            loadOrders();
        });

        $('#messages-tab').on('shown.bs.tab', function () {
            loadMessages();
        });

        $('#customers-tab').on('shown.bs.tab', function () {
            loadCustomers();
        });
    </script>
</body>
</html>