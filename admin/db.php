<?php
$servername = "localhost";
$username = "u530884239_bossbino111";
$password = "Bossbino111"; 
$dbname = "u530884239_bossbino111"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->query("SET time_zone = '+08:00'");

$conn->query("
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    due_date DATETIME,
    completed TINYINT(1) DEFAULT 0,
    status ENUM('pending','successful','unsuccessful') DEFAULT 'pending',
    customer_id INT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$conn->query("
CREATE TABLE IF NOT EXISTS customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    phone VARCHAR(50),
    notes TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");
?>